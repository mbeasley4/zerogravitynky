<?php
/**
 * Elementor → Gutenberg Migration Script
 *
 * Converts Elementor page data (_elementor_data) to serialized Gutenberg block
 * markup, strips Elementor header/footer templates and header/footer sections
 * from page content, and writes the result back to post_content.
 *
 * Usage — ALWAYS pass --skip-plugins to prevent Elementor Pro from consuming
 * memory. The script only reads post meta from the database; no plugins needed.
 *
 *   wp --skip-plugins eval-file wp-content/themes/zerogravitynky/tools/elementor-to-blocks.php [args...]
 *
 * wp eval-file only accepts positional arguments (no --flags).
 * Pass options as plain words or key=value pairs after the file path:
 *
 *   dry-run            Preview output without writing to the database
 *   post-id=<N>        Migrate a single post by ID
 *   post-type=<type>   Limit to a specific post type (default: all)
 *   cleanup            After migrating, delete _elementor_data meta from migrated posts
 *   verbose            Print converted block markup for every post
 *
 * Examples:
 *   wp --skip-plugins eval-file .../tools/elementor-to-blocks.php dry-run
 *   wp --skip-plugins eval-file .../tools/elementor-to-blocks.php dry-run post-id=42
 *   wp --skip-plugins eval-file .../tools/elementor-to-blocks.php post-type=page dry-run
 *   wp --skip-plugins eval-file .../tools/elementor-to-blocks.php cleanup
 */

if ( ! defined( 'ABSPATH' ) || ! class_exists( 'WP_CLI' ) ) {
    die( "Run this script via WP-CLI: wp eval-file <path-to-script>\n" );
}

// Raise memory limit before any processing begins.
// Elementor data JSON can be very large; 512 M is a safe ceiling for most sites.
ini_set( 'memory_limit', '512M' );

// ─────────────────────────────────────────────────────────────────────────────
// Argument Parsing
// ─────────────────────────────────────────────────────────────────────────────
// WP-CLI injects $args (positional) and $assoc_args into the eval'd scope.
// All custom options must be positional — wp eval-file rejects unknown --flags.

$dry_run   = in_array( 'dry-run', $args ?? [] );
$cleanup   = in_array( 'cleanup', $args ?? [] );
$verbose   = in_array( 'verbose', $args ?? [] );
$post_id   = null;
$post_type = null;

foreach ( $args ?? [] as $arg ) {
    if ( preg_match( '/^post-id=(\d+)$/', $arg, $m ) ) {
        $post_id = (int) $m[1];
    }
    if ( preg_match( '/^post-type=(\S+)$/', $arg, $m ) ) {
        $post_type = sanitize_key( $m[1] );
    }
}

if ( $dry_run ) {
    WP_CLI::log( WP_CLI::colorize( '%YDRY RUN — no changes will be written to the database.%n' ) );
    WP_CLI::log( '' );
}

// ─────────────────────────────────────────────────────────────────────────────
// Migration Class
// ─────────────────────────────────────────────────────────────────────────────

class ZG_Elementor_To_Blocks {

    /** @var bool */
    private bool $dry_run;
    /** @var bool */
    private bool $cleanup;
    /** @var bool */
    private bool $verbose;

    /** @var array{processed:int,migrated:int,skipped:int,errors:int} */
    private array $stats = [
        'processed' => 0,
        'migrated'  => 0,
        'skipped'   => 0,
        'errors'    => 0,
    ];

    /**
     * Post IDs that were successfully migrated (used for cleanup pass).
     * @var int[]
     */
    private array $migrated_ids = [];

    public function __construct( bool $dry_run, bool $cleanup, bool $verbose ) {
        $this->dry_run = $dry_run;
        $this->cleanup = $cleanup;
        $this->verbose = $verbose;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Entry Points
    // ─────────────────────────────────────────────────────────────────────────

    public function run( ?int $post_id = null, ?string $post_type = null ): void {
        if ( $post_id ) {
            $this->migrate_post( $post_id );
        } else {
            $this->migrate_all( $post_type );
        }

        if ( $this->cleanup && ! $this->dry_run && ! empty( $this->migrated_ids ) ) {
            $this->cleanup_elementor_meta();
        }

        $this->print_summary();
    }

    private function migrate_all( ?string $post_type ): void {
        global $wpdb;

        $type_clause = $post_type
            ? $wpdb->prepare( 'AND p.post_type = %s', $post_type )
            : '';

        // Fetch only IDs — avoids loading all post_content into memory at once.
        $all_ids = $wpdb->get_col( "
            SELECT DISTINCT p.ID
            FROM {$wpdb->posts} p
            INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
            WHERE pm.meta_key   = '_elementor_data'
              AND pm.meta_value != ''
              AND pm.meta_value != '[]'
              AND p.post_status NOT IN ('trash','auto-draft')
              {$type_clause}
            ORDER BY p.ID ASC
        " );

        $total = count( $all_ids );
        WP_CLI::log( sprintf( 'Found %d post(s) with Elementor data.', $total ) );
        WP_CLI::log( '' );

        if ( $total === 0 ) {
            return;
        }

        // Process in small batches so memory from each post's JSON is released
        // between iterations rather than accumulated across the full set.
        $batch_size = 10;
        $chunks     = array_chunk( $all_ids, $batch_size );
        $progress   = WP_CLI\Utils\make_progress_bar( 'Migrating', $total );

        foreach ( $chunks as $chunk ) {
            foreach ( $chunk as $id ) {
                $this->migrate_post( (int) $id );
                $progress->tick();
            }

            // Release WordPress object cache and $wpdb query log accumulated
            // during the batch so memory does not grow unboundedly.
            wp_cache_flush();
            $wpdb->flush();
        }

        $progress->finish();
        WP_CLI::log( '' );
    }

    private function migrate_post( int $post_id ): void {
        $this->stats['processed']++;

        $post = get_post( $post_id );
        if ( ! $post ) {
            WP_CLI::warning( "Post {$post_id} not found — skipped." );
            $this->stats['skipped']++;
            return;
        }

        // Skip Elementor header, footer, and popup templates entirely —
        // our theme provides its own header.php / footer.php.
        $template_type = get_post_meta( $post_id, '_elementor_template_type', true );
        if ( in_array( $template_type, [ 'header', 'footer', 'popup', 'section' ], true ) ) {
            WP_CLI::log( sprintf(
                '⏭  [%s] Skipping "%s" (ID %d) — Elementor %s template.',
                strtoupper( $post->post_type ),
                $post->post_title,
                $post_id,
                $template_type
            ) );
            $this->stats['skipped']++;
            return;
        }

        $raw = get_post_meta( $post_id, '_elementor_data', true );
        if ( empty( $raw ) || $raw === '[]' ) {
            $this->stats['skipped']++;
            return;
        }

        $data = json_decode( $raw, true );
        if ( json_last_error() !== JSON_ERROR_NONE ) {
            WP_CLI::warning( sprintf( '✗  Post %d: JSON parse error — %s', $post_id, json_last_error_msg() ) );
            $this->stats['errors']++;
            return;
        }

        try {
            // 1. Strip header / footer sections before converting.
            $data = $this->strip_header_footer_sections( $data );

            // 2. Convert remaining sections to Gutenberg block markup.
            $blocks = $this->convert_sections( $data );
            $blocks = trim( $blocks );

            if ( empty( $blocks ) ) {
                WP_CLI::log( sprintf(
                    '⏭  [%s] "%s" (ID %d) — empty after stripping header/footer.',
                    strtoupper( $post->post_type ),
                    $post->post_title,
                    $post_id
                ) );
                $this->stats['skipped']++;
                return;
            }

            if ( $this->dry_run || $this->verbose ) {
                WP_CLI::log( WP_CLI::colorize( "%B── Post {$post_id}: {$post->post_title} ──%n" ) );
                WP_CLI::log( $blocks );
                WP_CLI::log( '' );
            }

            if ( ! $this->dry_run ) {
                wp_update_post( [
                    'ID'           => $post_id,
                    'post_content' => $blocks,
                ] );

                // Mark post as no longer Elementor-managed.
                update_post_meta( $post_id, '_elementor_edit_mode', '' );

                WP_CLI::success( sprintf(
                    '[%s] "%s" (ID %d)',
                    strtoupper( $post->post_type ),
                    $post->post_title,
                    $post_id
                ) );

                $this->migrated_ids[] = $post_id;
            }

            $this->stats['migrated']++;

        } catch ( Throwable $e ) {
            WP_CLI::warning( sprintf( '✗  Post %d error: %s', $post_id, $e->getMessage() ) );
            $this->stats['errors']++;
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Header / Footer Section Detection
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Remove top-level Elementor sections that are header or footer regions.
     * Our theme provides these via header.php / footer.php — they must not
     * appear in post_content.
     *
     * @param array $sections Top-level Elementor section elements.
     * @return array Filtered sections.
     */
    private function strip_header_footer_sections( array $sections ): array {
        return array_values( array_filter( $sections, fn( $s ) => ! $this->is_header_footer_section( $s ) ) );
    }

    private function is_header_footer_section( array $section ): bool {
        $settings = $section['settings'] ?? [];

        // Check CSS class names and element ID set in Elementor's Advanced tab.
        $identifiers = strtolower(
            ( $settings['css_classes'] ?? '' ) . ' ' .
            ( $settings['_element_id'] ?? '' ) . ' ' .
            ( $settings['custom_id'] ?? '' )
        );

        $patterns = [
            'header', 'footer', 'navbar', 'nav-bar', 'site-nav',
            'topbar', 'top-bar', 'site-header', 'site-footer',
            'main-nav', 'main-header', 'main-footer',
        ];

        foreach ( $patterns as $p ) {
            if ( str_contains( $identifiers, $p ) ) {
                return true;
            }
        }

        // Check whether the section contains navigation-specific widgets.
        foreach ( $this->collect_widgets( $section ) as $widget ) {
            $type = $widget['widgetType'] ?? '';
            if ( in_array( $type, [
                'nav_menu',
                'wp-widget-nav_menu',
                'site-logo',
                'site-navigation-menu',
                'navigation-menu',
            ], true ) ) {
                return true;
            }
        }

        return false;
    }

    /** Recursively collect all widget elements under a given element. */
    private function collect_widgets( array $element ): array {
        $result = [];
        if ( ( $element['elType'] ?? '' ) === 'widget' ) {
            $result[] = $element;
        }
        foreach ( $element['elements'] ?? [] as $child ) {
            $result = array_merge( $result, $this->collect_widgets( $child ) );
        }
        return $result;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Structural Converters: Sections & Columns
    // ─────────────────────────────────────────────────────────────────────────

    private function convert_sections( array $sections ): string {
        $out = '';
        foreach ( $sections as $section ) {
            $out .= $this->convert_element( $section );
        }
        return $out;
    }

    private function convert_element( array $el ): string {
        return match ( $el['elType'] ?? '' ) {
            'section'   => $this->convert_section( $el ),
            'container' => $this->convert_section( $el ),   // Elementor Flexbox Container
            'column'    => $this->convert_column( $el ),
            'widget'    => $this->convert_widget( $el ),
            default     => '',
        };
    }

    private function convert_section( array $section ): string {
        $settings = $section['settings'] ?? [];
        $columns  = $section['elements'] ?? [];

        if ( empty( $columns ) ) {
            return '';
        }

        // Single-column sections: skip the columns wrapper and render widgets directly.
        if ( count( $columns ) === 1 ) {
            $inner = '';
            foreach ( $columns[0]['elements'] ?? [] as $widget ) {
                $inner .= $this->convert_element( $widget );
            }
            return $this->make_group( $inner, $settings );
        }

        // Multi-column sections: core/columns.
        $cols_markup = '';
        foreach ( $columns as $col ) {
            $cols_markup .= $this->convert_column( $col );
        }

        if ( empty( trim( $cols_markup ) ) ) {
            return '';
        }

        $inner = "<!-- wp:columns {\"isStackedOnMobile\":true} -->\n"
               . "<div class=\"wp-block-columns is-layout-flex\">"
               . $cols_markup
               . "</div>\n<!-- /wp:columns -->\n";

        return $this->make_group( $inner, $settings );
    }

    private function convert_column( array $column ): string {
        $settings = $column['settings'] ?? [];
        $inner    = '';

        foreach ( $column['elements'] ?? [] as $widget ) {
            $inner .= $this->convert_element( $widget );
        }

        if ( empty( trim( $inner ) ) ) {
            return '';
        }

        // Column width from Elementor's _column_size (0-100).
        $width     = isset( $settings['_column_size'] ) ? (int) $settings['_column_size'] : null;
        $attrs_str = $width ? " {\"width\":\"{$width}%\"}" : '';

        return "<!-- wp:column{$attrs_str} -->\n"
             . "<div class=\"wp-block-column\">{$inner}</div>\n"
             . "<!-- /wp:column -->\n";
    }

    /**
     * Wrap content in a core/group block.
     * Preserves background color when set on the Elementor section.
     */
    private function make_group( string $inner, array $settings = [] ): string {
        if ( empty( trim( $inner ) ) ) {
            return '';
        }

        $attrs = [];

        if ( ! empty( $settings['background_color'] ) ) {
            $attrs['style']['color']['background'] = $settings['background_color'];
        }

        $extra_class = trim( $settings['css_classes'] ?? '' );
        $class       = 'wp-block-group';
        if ( $extra_class ) {
            $class .= ' ' . esc_attr( $extra_class );
        }

        $attrs_str = ! empty( $attrs ) ? ' ' . $this->encode( $attrs ) : '';

        return "<!-- wp:group{$attrs_str} -->\n"
             . "<div class=\"{$class}\">{$inner}</div>\n"
             . "<!-- /wp:group -->\n";
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Widget Dispatcher
    // ─────────────────────────────────────────────────────────────────────────

    private function convert_widget( array $widget ): string {
        $type = $widget['widgetType'] ?? '';
        $s    = $widget['settings']   ?? [];

        return match ( true ) {
            $type === 'heading'                           => $this->w_heading( $s ),
            $type === 'text-editor'                       => $this->w_text_editor( $s ),
            $type === 'image'                             => $this->w_image( $s ),
            $type === 'button'                            => $this->w_button( $s ),
            $type === 'video'                             => $this->w_video( $s ),
            $type === 'divider'                           => $this->w_divider(),
            $type === 'spacer'                            => $this->w_spacer( $s ),
            $type === 'image-box'                         => $this->w_image_box( $s ),
            $type === 'icon-box'                          => $this->w_icon_box( $s ),
            $type === 'icon-list'                         => $this->w_icon_list( $s ),
            $type === 'gallery'                           => $this->w_gallery( $s ),
            $type === 'social-icons'                      => $this->w_social_icons( $s ),
            in_array( $type, ['accordion', 'toggle'], true ) => $this->w_accordion( $s ),
            $type === 'tabs'                              => $this->w_tabs( $s ),
            $type === 'html'                              => $this->w_html( $s ),
            $type === 'shortcode'                         => $this->w_shortcode( $s ),
            $type === 'form'                              => $this->w_form( $s ),
            // ── ZG custom block detection ────────────────────────────────────
            in_array( $type, ['testimonial', 'testimonial-carousel'], true ) => $this->w_testimonial( $s ),
            // ── WP-native widgets embedded by Elementor ─────────────────────
            str_starts_with( $type, 'wp-widget-' )        => $this->w_fallback( $widget ),
            default                                        => $this->w_fallback( $widget ),
        };
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Widget Converters
    // ─────────────────────────────────────────────────────────────────────────

    private function w_heading( array $s ): string {
        $text  = wp_strip_all_tags( $s['title'] ?? '' );
        if ( empty( $text ) ) return '';

        $tag   = $s['header_size'] ?? 'h2';
        $level = (int) ltrim( $tag, 'h' ) ?: 2;
        $align = $s['align'] ?? '';

        $attrs = [ 'level' => $level ];
        $class = 'wp-block-heading';

        if ( $align && $align !== 'default' ) {
            $attrs['textAlign'] = $align;
            $class .= " has-text-align-{$align}";
        }

        return "<!-- wp:heading {$this->encode( $attrs )} -->\n"
             . "<{$tag} class=\"{$class}\">" . esc_html( $text ) . "</{$tag}>\n"
             . "<!-- /wp:heading -->\n";
    }

    private function w_text_editor( array $s ): string {
        $content = trim( $s['editor'] ?? '' );
        if ( empty( $content ) ) return '';

        // Plain text → paragraph.
        if ( wp_strip_all_tags( $content ) === $content ) {
            return "<!-- wp:paragraph -->\n<p>" . esc_html( $content ) . "</p>\n<!-- /wp:paragraph -->\n";
        }

        // Rich / structured HTML — preserve as-is inside core/html.
        return "<!-- wp:html -->\n" . wp_kses_post( $content ) . "\n<!-- /wp:html -->\n";
    }

    private function w_image( array $s ): string {
        $url = $s['image']['url'] ?? '';
        $id  = (int) ( $s['image']['id'] ?? 0 );
        $alt = $s['image']['alt'] ?? '';
        if ( empty( $url ) ) return '';

        $attrs = [ 'sizeSlug' => 'large' ];
        if ( $id ) $attrs['id'] = $id;

        return "<!-- wp:image {$this->encode( $attrs )} -->\n"
             . "<figure class=\"wp-block-image size-large\">"
             . "<img src=\"" . esc_url( $url ) . "\" alt=\"" . esc_attr( $alt ) . "\"/>"
             . "</figure>\n<!-- /wp:image -->\n";
    }

    private function w_button( array $s ): string {
        $text = wp_strip_all_tags( $s['text'] ?? 'Learn More' );
        $url  = $s['link']['url'] ?? '#';
        $new  = ! empty( $s['link']['is_external'] );

        $link = '<a class="wp-block-button__link wp-element-button"'
              . ' href="' . esc_url( $url ) . '"'
              . ( $new ? ' target="_blank" rel="noopener"' : '' )
              . '>' . esc_html( $text ) . '</a>';

        return "<!-- wp:buttons -->\n<div class=\"wp-block-buttons\">"
             . "<!-- wp:button -->\n"
             . "<div class=\"wp-block-button\">{$link}</div>\n"
             . "<!-- /wp:button -->\n"
             . "</div>\n<!-- /wp:buttons -->\n";
    }

    private function w_video( array $s ): string {
        $type = $s['video_type'] ?? 'youtube';

        $url = match ( $type ) {
            'youtube' => $s['youtube']['url'] ?? '',
            'vimeo'   => $s['vimeo']['url']   ?? '',
            'hosted'  => $s['hosted_url']['url'] ?? $s['external_url']['url'] ?? '',
            default   => '',
        };

        if ( empty( $url ) ) return '';

        if ( $type === 'hosted' ) {
            return "<!-- wp:video -->\n"
                 . "<figure class=\"wp-block-video\">"
                 . "<video controls src=\"" . esc_url( $url ) . "\"></video>"
                 . "</figure>\n<!-- /wp:video -->\n";
        }

        $provider = ( $type === 'vimeo' ) ? 'vimeo' : 'youtube';

        return "<!-- wp:embed {\"url\":\"" . esc_url( $url ) . "\","
             . "\"type\":\"video\",\"providerNameSlug\":\"{$provider}\"} -->\n"
             . "<figure class=\"wp-block-embed is-type-video is-provider-{$provider}\">"
             . "<div class=\"wp-block-embed__wrapper\">\n" . esc_url( $url ) . "\n</div>"
             . "</figure>\n<!-- /wp:embed -->\n";
    }

    private function w_divider(): string {
        return "<!-- wp:separator -->\n"
             . "<hr class=\"wp-block-separator has-alpha-channel-opacity\"/>\n"
             . "<!-- /wp:separator -->\n";
    }

    private function w_spacer( array $s ): string {
        $px = (int) ( $s['space']['size'] ?? 50 );
        return "<!-- wp:spacer {\"height\":\"{$px}px\"} -->\n"
             . "<div style=\"height:{$px}px\" aria-hidden=\"true\" class=\"wp-block-spacer\"></div>\n"
             . "<!-- /wp:spacer -->\n";
    }

    private function w_image_box( array $s ): string {
        $url   = $s['image']['url'] ?? '';
        $id    = (int) ( $s['image']['id'] ?? 0 );
        $alt   = $s['image']['alt'] ?? '';
        $title = wp_strip_all_tags( $s['title_text'] ?? '' );
        $desc  = trim( $s['description_text'] ?? '' );

        if ( empty( $url ) && empty( $title ) ) return '';

        $attrs = [ 'mediaPosition' => 'left', 'isStackedOnMobile' => true ];
        if ( $id )  $attrs['mediaId']  = $id;
        if ( $url ) $attrs['mediaUrl'] = $url;

        $media   = $url ? "<img src=\"" . esc_url( $url ) . "\" alt=\"" . esc_attr( $alt ) . "\"/>" : '';
        $heading = $title ? "<!-- wp:heading {\"level\":3} -->\n<h3 class=\"wp-block-heading\">" . esc_html( $title ) . "</h3>\n<!-- /wp:heading -->\n" : '';
        $para    = $desc  ? "<!-- wp:paragraph -->\n<p>" . wp_kses_post( $desc ) . "</p>\n<!-- /wp:paragraph -->\n" : '';

        return "<!-- wp:media-text {$this->encode( $attrs )} -->\n"
             . "<div class=\"wp-block-media-text alignwide is-stacked-on-mobile\">"
             . "<figure class=\"wp-block-media-text__media\">{$media}</figure>"
             . "<div class=\"wp-block-media-text__content\">{$heading}{$para}</div>"
             . "</div>\n<!-- /wp:media-text -->\n";
    }

    private function w_icon_box( array $s ): string {
        $title = wp_strip_all_tags( $s['title_text'] ?? '' );
        $desc  = trim( $s['description_text'] ?? '' );
        if ( empty( $title ) && empty( $desc ) ) return '';

        $inner = '';
        if ( $title ) $inner .= "<!-- wp:heading {\"level\":3} -->\n<h3 class=\"wp-block-heading\">" . esc_html( $title ) . "</h3>\n<!-- /wp:heading -->\n";
        if ( $desc )  $inner .= "<!-- wp:paragraph -->\n<p>" . wp_kses_post( $desc ) . "</p>\n<!-- /wp:paragraph -->\n";

        return $this->make_group( $inner );
    }

    private function w_icon_list( array $s ): string {
        $items = $s['icon_list'] ?? [];
        if ( empty( $items ) ) return '';

        $lis = '';
        foreach ( $items as $item ) {
            $text = wp_strip_all_tags( $item['text'] ?? '' );
            $url  = $item['link']['url'] ?? '';
            if ( empty( $text ) ) continue;
            $content = $url
                ? "<a href=\"" . esc_url( $url ) . "\">" . esc_html( $text ) . "</a>"
                : esc_html( $text );
            $lis .= "<!-- wp:list-item -->\n<li>{$content}</li>\n<!-- /wp:list-item -->\n";
        }

        return empty( $lis ) ? '' :
            "<!-- wp:list -->\n<ul class=\"wp-block-list\">{$lis}</ul>\n<!-- /wp:list -->\n";
    }

    private function w_gallery( array $s ): string {
        $images = $s['gallery'] ?? [];
        if ( empty( $images ) ) return '';

        $cols = (int) ( $s['gallery_columns']['size'] ?? 3 );
        $attrs = [ 'columns' => $cols ];

        $ids = array_filter( array_column( $images, 'id' ) );
        if ( ! empty( $ids ) ) {
            $attrs['ids'] = array_map( 'intval', $ids );
        }

        $inner = '';
        foreach ( $images as $img ) {
            $url = $img['url'] ?? '';
            $id  = (int) ( $img['id'] ?? 0 );
            if ( empty( $url ) ) continue;
            $ia = $id ? [ 'id' => $id ] : [];
            $inner .= "<!-- wp:image {$this->encode( $ia )} -->\n"
                    . "<figure class=\"wp-block-image\">"
                    . "<img src=\"" . esc_url( $url ) . "\" alt=\"\"/>"
                    . "</figure>\n<!-- /wp:image -->\n";
        }

        return empty( $inner ) ? '' :
            "<!-- wp:gallery {$this->encode( $attrs )} -->\n"
          . "<figure class=\"wp-block-gallery has-nested-images\">{$inner}</figure>\n"
          . "<!-- /wp:gallery -->\n";
    }

    private function w_social_icons( array $s ): string {
        $icons = $s['social_icon_list'] ?? [];
        if ( empty( $icons ) ) return '';

        // Map Font Awesome class fragments → WP social-link service slugs.
        $map = [
            'facebook'  => 'facebook',
            'instagram' => 'instagram',
            'twitter'   => 'twitter',
            'x-twitter' => 'x',
            'linkedin'  => 'linkedin',
            'youtube'   => 'youtube',
            'tiktok'    => 'tiktok',
            'pinterest' => 'pinterest',
        ];

        $links = '';
        foreach ( $icons as $icon ) {
            $url     = $icon['link']['url'] ?? '#';
            $library = strtolower( $icon['social_icon']['library'] ?? $icon['social'] ?? '' );
            $service = 'wordpress';
            foreach ( $map as $key => $slug ) {
                if ( str_contains( $library, $key ) ) {
                    $service = $slug;
                    break;
                }
            }
            $links .= "<!-- wp:social-link {\"url\":\"" . esc_url( $url ) . "\",\"service\":\"{$service}\"} /-->\n";
        }

        return "<!-- wp:social-links -->\n"
             . "<ul class=\"wp-block-social-links\">{$links}</ul>\n"
             . "<!-- /wp:social-links -->\n";
    }

    private function w_accordion( array $s ): string {
        $items = $s['tabs'] ?? [];
        if ( empty( $items ) ) return '';

        $out = '';
        foreach ( $items as $item ) {
            $title   = wp_strip_all_tags( $item['tab_title'] ?? '' );
            $content = wp_kses_post( $item['tab_content'] ?? '' );
            if ( empty( $title ) ) continue;
            $out .= "<!-- wp:details -->\n"
                  . "<details class=\"wp-block-details\">"
                  . "<summary>" . esc_html( $title ) . "</summary>"
                  . "<!-- wp:paragraph -->\n<p>{$content}</p>\n<!-- /wp:paragraph -->"
                  . "</details>\n<!-- /wp:details -->\n";
        }

        return $out;
    }

    private function w_tabs( array $s ): string {
        // No direct core equivalent — flatten to headings + content groups.
        $items = $s['tabs'] ?? [];
        if ( empty( $items ) ) return '';

        $out = '';
        foreach ( $items as $item ) {
            $title   = wp_strip_all_tags( $item['tab_title'] ?? '' );
            $content = trim( $item['tab_content'] ?? '' );
            if ( empty( $title ) ) continue;

            $inner  = "<!-- wp:heading {\"level\":3} -->\n<h3 class=\"wp-block-heading\">" . esc_html( $title ) . "</h3>\n<!-- /wp:heading -->\n";
            $inner .= "<!-- wp:paragraph -->\n<p>" . wp_kses_post( $content ) . "</p>\n<!-- /wp:paragraph -->\n";
            $out   .= $this->make_group( $inner );
        }

        return $out;
    }

    private function w_html( array $s ): string {
        $html = trim( $s['html'] ?? '' );
        return empty( $html ) ? '' : "<!-- wp:html -->\n{$html}\n<!-- /wp:html -->\n";
    }

    private function w_shortcode( array $s ): string {
        $code = trim( $s['shortcode'] ?? '' );
        return empty( $code ) ? '' : "<!-- wp:shortcode -->\n{$code}\n<!-- /wp:shortcode -->\n";
    }

    private function w_form( array $s ): string {
        $name = esc_html( $s['form_name'] ?? 'Contact Form' );
        // Leave a clear placeholder — replace with WPForms / CF7 shortcode after import.
        return "<!-- wp:html -->\n"
             . "<!-- TODO: Replace with your form shortcode. Elementor form: \"{$name}\" -->\n"
             . "<p><em>[Form: {$name} — add shortcode here]</em></p>\n"
             . "<!-- /wp:html -->\n";
    }

    private function w_testimonial( array $s ): string {
        $quote  = wp_strip_all_tags( $s['testimonial_content'] ?? $s['content'] ?? '' );
        $name   = wp_strip_all_tags( $s['testimonial_name']    ?? $s['author_name'] ?? '' );
        $title  = wp_strip_all_tags( $s['testimonial_job']     ?? $s['author_title'] ?? '' );

        if ( empty( $quote ) ) return '';

        // Derive initials from the author name.
        $words    = preg_split( '/\s+/', trim( $name ) );
        $initials = implode( '', array_map( fn( $w ) => strtoupper( substr( $w, 0, 1 ) ), array_slice( $words, 0, 2 ) ) ) ?: 'ZG';

        $attrs = [
            'quote'       => $quote,
            'authorName'  => $name,
            'authorTitle' => $title,
            'initials'    => $initials,
            'rating'      => 5,
        ];

        return "<!-- wp:zerogravitynky/testimonial-card {$this->encode( $attrs )} /-->\n";
    }

    /**
     * Fallback for unmapped or complex widgets.
     * Attempts to extract meaningful text; otherwise leaves a migration comment.
     */
    private function w_fallback( array $widget ): string {
        $type = $widget['widgetType'] ?? 'unknown';
        $s    = $widget['settings']  ?? [];

        // Collect any text-like values from the settings.
        $parts = [];
        foreach ( [ 'title', 'text', 'content', 'description', 'editor', 'html' ] as $k ) {
            if ( ! empty( $s[ $k ] ) ) {
                $parts[] = $s[ $k ];
            }
        }

        if ( ! empty( $parts ) ) {
            $html = implode( "\n", $parts );
            return "<!-- wp:html -->\n"
                 . "<!-- Elementor widget: {$type} -->\n"
                 . wp_kses_post( $html ) . "\n"
                 . "<!-- /wp:html -->\n";
        }

        // Nothing to salvage — leave a review comment.
        return "<!-- wp:html -->\n"
             . "<!-- TODO: Review Elementor widget \"{$type}\" — could not auto-migrate. -->\n"
             . "<!-- /wp:html -->\n";
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Post-Migration Cleanup
    // ─────────────────────────────────────────────────────────────────────────

    private function cleanup_elementor_meta(): void {
        WP_CLI::log( '' );
        WP_CLI::log( 'Cleaning up Elementor meta from migrated posts…' );

        $keys = [
            '_elementor_data',
            '_elementor_draft',
            '_elementor_css',
            '_elementor_page_settings',
        ];

        foreach ( $this->migrated_ids as $id ) {
            foreach ( $keys as $key ) {
                delete_post_meta( $id, $key );
            }
        }

        WP_CLI::success( sprintf( 'Removed Elementor meta from %d post(s).', count( $this->migrated_ids ) ) );
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────────────────────────────────────────

    private function encode( array $data ): string {
        return json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
    }

    private function print_summary(): void {
        WP_CLI::log( '' );
        WP_CLI::log( '─────────────────────────────────────' );
        WP_CLI::log( 'Migration Summary' );
        WP_CLI::log( '─────────────────────────────────────' );
        WP_CLI::log( "  Processed : {$this->stats['processed']}" );
        WP_CLI::log( "  Migrated  : {$this->stats['migrated']}" );
        WP_CLI::log( "  Skipped   : {$this->stats['skipped']}" );
        WP_CLI::log( "  Errors    : {$this->stats['errors']}" );
        WP_CLI::log( '─────────────────────────────────────' );

        if ( $this->dry_run ) {
            WP_CLI::log( WP_CLI::colorize( '%YNo changes were written (dry run).%n' ) );
        }
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// Run
// ─────────────────────────────────────────────────────────────────────────────

$migrator = new ZG_Elementor_To_Blocks( $dry_run, $cleanup, $verbose );
$migrator->run( $post_id, $post_type );
