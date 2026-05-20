<?php
/**
 * Remove 100 px wp:spacer Blocks from All Post Content
 *
 * Strips every occurrence of the exact spacer markup:
 *
 *   <!-- wp:spacer -->
 *   <div style="height:100px" aria-hidden="true" class="wp-block-spacer"></div>
 *   <!-- /wp:spacer -->
 *
 * from post_content in the database.  Vertical spacing is now handled by
 * CSS in src/css/main.css via the [class*="wp-block-zerogravitynky-"] rule.
 *
 * Usage:
 *   wp --skip-plugins eval-file wp-content/themes/zerogravitynky/tools/remove-spacers.php [dry-run] [verbose]
 *
 * Options (positional):
 *   dry-run   Preview matches without writing to the database.
 *   verbose   Print each updated post ID and title.
 *   post-id=N Process a single post by ID.
 */

if ( ! defined( 'ABSPATH' ) || ! class_exists( 'WP_CLI' ) ) {
    die( "Run this script via WP-CLI: wp eval-file <path-to-script>\n" );
}

// ── Argument parsing ──────────────────────────────────────────────────────────
$dry_run = in_array( 'dry-run', $args ?? [], true );
$verbose = in_array( 'verbose', $args ?? [], true );
$post_id = null;

foreach ( $args ?? [] as $arg ) {
    if ( str_starts_with( $arg, 'post-id=' ) ) {
        $post_id = (int) substr( $arg, 8 );
    }
}

// ── Spacer pattern ────────────────────────────────────────────────────────────
// Matches the 100 px spacer with any surrounding whitespace / newlines so the
// regex is robust to minor editor-introduced formatting differences.
$pattern = '/<!--\s*wp:spacer\s*-->\s*<div[^>]*class="wp-block-spacer"[^>]*><\/div>\s*<!--\s*\/wp:spacer\s*-->/i';

// ── Query posts ───────────────────────────────────────────────────────────────
$query_args = [
    'post_type'      => 'any',
    'post_status'    => 'any',
    'posts_per_page' => -1,
    'fields'         => 'ids',
    'no_found_rows'  => true,
];

if ( $post_id ) {
    $query_args['p']         = $post_id;
    $query_args['post_type'] = 'any';
}

$ids = get_posts( $query_args );

if ( empty( $ids ) ) {
    WP_CLI::warning( 'No posts found.' );
    return;
}

WP_CLI::log( sprintf( 'Scanning %d post(s)…', count( $ids ) ) );

$updated = 0;
$skipped = 0;

foreach ( $ids as $id ) {
    $post    = get_post( $id );
    $content = $post->post_content;

    if ( ! preg_match( $pattern, $content ) ) {
        $skipped++;
        continue;
    }

    $new_content = preg_replace( $pattern, '', $content );
    // Collapse runs of blank lines left behind by the removed spacer.
    $new_content = preg_replace( '/\n{3,}/', "\n\n", $new_content );
    $new_content = trim( $new_content );

    if ( $verbose || $dry_run ) {
        $label = $dry_run ? '[DRY-RUN]' : '[UPDATE]';
        WP_CLI::log( sprintf( '%s  ID=%d  "%s"', $label, $id, get_the_title( $id ) ) );
    }

    if ( ! $dry_run ) {
        wp_update_post( [
            'ID'           => $id,
            'post_content' => $new_content,
        ] );
    }

    $updated++;
}

$action = $dry_run ? 'Would update' : 'Updated';
WP_CLI::success( sprintf(
    '%s %d post(s). %d post(s) had no spacers.',
    $action,
    $updated,
    $skipped
) );
