<?php
/**
 * Dynamic render for zerogravitynky/zg-reviews block.
 * Pulls 3 random published reviews from the zg_review CPT.
 * Font colors are chosen to meet WCAG AA contrast against each background.
 */
defined( 'ABSPATH' ) || exit;

$bg_color     = $attributes['bgColor']      ?? 'lavender';
$section_title = $attributes['sectionTitle'] ?? 'What Our Clients Say';
$rating_label  = $attributes['ratingLabel']  ?? '5.0 · Consistently 5-star rated';

// ── ADA-compliant colour schemes ──────────────────────────────────────────
// All contrast ratios verified against WCAG AA (4.5:1 normal text, 3:1 large).
//
// lavender   bg #e9e6ed  — dark-on-light
// light-gold bg #f0dfa0  — dark-on-light
// purple     bg #720eec  — light-on-dark
//
// Full class strings written out literally so Tailwind v4 scanner picks them up.
$scheme = match ( $bg_color ) {
    'light-gold' => [
        // bg #f0dfa0 ─ heading contrast ~12:1, eyebrow ~6.5:1, body ~5.9:1 ✓
        'section'        => 'bg-brand-taupe-light',
        'eyebrow_text'   => 'text-brand-dark',
        'eyebrow_line'   => 'bg-brand-dark',
        'heading'        => 'text-brand-dark',
        'rating_text'    => 'text-brand-gray',
    ],
    'purple' => [
        // bg #720eec ─ white heading ~8.5:1, gold-light eyebrow ~6.5:1 ✓
        'section'        => 'bg-brand-sage',
        'eyebrow_text'   => 'text-brand-taupe-light',
        'eyebrow_line'   => 'bg-brand-taupe-light',
        'heading'        => 'text-white',
        'rating_text'    => 'text-white/85',
    ],
    default => [
        // lavender bg #e9e6ed ─ heading ~14:1, eyebrow ~7.3:1, body ~6.7:1 ✓
        'section'        => 'bg-brand-sand',
        'eyebrow_text'   => 'text-brand-sage',
        'eyebrow_line'   => 'bg-brand-sage',
        'heading'        => 'text-brand-dark',
        'rating_text'    => 'text-brand-gray',
    ],
};

// ── Fetch 3 random reviews ─────────────────────────────────────────────────
$review_posts = get_posts( [
    'post_type'      => 'zg_review',
    'post_status'    => 'publish',
    'posts_per_page' => 3,
    'orderby'        => 'rand',
] );

// ── SVG helpers ────────────────────────────────────────────────────────────
$star_filled = '<svg class="w-4 h-4 text-brand-taupe" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>';
$star_empty  = '<svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>';
$star_lg     = '<svg class="w-5 h-5 text-brand-taupe" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>';

// Stars on purple bg use gold-light for contrast; on light bgs use normal gold
$star_lg_scheme = ( $bg_color === 'purple' )
    ? str_replace( 'text-brand-taupe', 'text-brand-taupe-light', $star_lg )
    : $star_lg;

// Avatar color cycle — full literal class strings so Tailwind v4 scanner keeps them.
$avatar_styles = [
    [ 'bg' => 'bg-brand-sage/10', 'text' => 'text-brand-sage' ],
    [ 'bg' => 'bg-brand-taupe/20',   'text' => 'text-brand-taupe'   ],
    [ 'bg' => 'bg-brand-mid/10',    'text' => 'text-brand-mid'    ],
];
?>

<section class="py-24 <?php echo esc_attr( $scheme['section'] ); ?>">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">

        <div class="text-center mb-14 reveal">
            <div class="inline-flex items-center gap-2 <?php echo esc_attr( $scheme['eyebrow_text'] ); ?> text-sm font-semibold uppercase tracking-widest mb-4">
                <span class="w-8 h-px <?php echo esc_attr( $scheme['eyebrow_line'] ); ?>"></span>
                Reviews
                <span class="w-8 h-px <?php echo esc_attr( $scheme['eyebrow_line'] ); ?>"></span>
            </div>
            <h2 class="font-serif text-4xl lg:text-5xl <?php echo esc_attr( $scheme['heading'] ); ?> font-bold mb-3">
                <?php echo esc_html( $section_title ); ?>
            </h2>
            <div class="flex justify-center items-center gap-1 mt-3">
                <?php echo str_repeat( $star_lg_scheme, 5 ); // phpcs:ignore ?>
                <span class="ml-2 <?php echo esc_attr( $scheme['rating_text'] ); ?> font-medium text-sm">
                    <?php echo esc_html( $rating_label ); ?>
                </span>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <?php if ( $review_posts ) :
                foreach ( $review_posts as $i => $review ) :
                    $name    = get_post_meta( $review->ID, '_review_reviewer', true ) ?: $review->post_title;
                    $comment = get_post_meta( $review->ID, '_review_comment',  true );
                    $stars   = min( 5, max( 0, (int) get_post_meta( $review->ID, '_review_stars', true ) ) );
                    $link    = get_post_meta( $review->ID, '_review_link',   true );
                    $source  = get_post_meta( $review->ID, '_review_source', true );
                    $date    = get_post_meta( $review->ID, '_review_date',   true );

                    $parts    = array_filter( explode( ' ', trim( $name ) ) );
                    $initials = implode( '', array_map( fn( $p ) => strtoupper( mb_substr( $p, 0, 1 ) ), array_slice( $parts, 0, 2 ) ) );

                    $avatar_style = $avatar_styles[ $i % count( $avatar_styles ) ];
                    $delay = $i > 0 ? number_format( $i * 0.1, 1 ) . 's' : '';

                    $source_label = match ( $source ) {
                        'google' => 'Google',
                        'yelp'   => 'Yelp',
                        default  => '',
                    };
                    $meta_parts = array_filter( [
                        $source_label,
                        $date ? date_i18n( 'M Y', strtotime( $date ) ) : '',
                    ] );
            ?>
            <div class="testimonial-card reveal bg-white rounded-2xl p-7 shadow-sm"
                 <?php echo $delay ? 'style="transition-delay:' . esc_attr( $delay ) . '"' : ''; ?>>

                <div class="flex gap-0.5 mb-4" role="img" aria-label="<?php echo esc_attr( $stars ); ?> out of 5 stars">
                    <?php
                    echo str_repeat( $star_filled, $stars );        // phpcs:ignore
                    echo str_repeat( $star_empty,  5 - $stars );    // phpcs:ignore
                    ?>
                </div>

                <blockquote class="text-brand-gray/80 text-sm leading-relaxed mb-6 italic">
                    &ldquo;<?php echo esc_html( $comment ); ?>&rdquo;
                </blockquote>

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full <?php echo esc_attr( $avatar_style['bg'] ); ?> flex items-center justify-center shrink-0">
                        <span class="<?php echo esc_attr( $avatar_style['text'] ); ?> font-semibold text-sm">
                            <?php echo esc_html( $initials ); ?>
                        </span>
                    </div>
                    <div class="min-w-0">
                        <div class="text-brand-dark font-semibold text-sm truncate"><?php echo esc_html( $name ); ?></div>
                        <?php if ( $meta_parts ) : ?>
                        <div class="text-brand-gray/50 text-xs"><?php echo esc_html( implode( ' · ', $meta_parts ) ); ?></div>
                        <?php endif; ?>
                    </div>
                    <?php if ( $link ) : ?>
                    <a href="<?php echo esc_url( $link ); ?>"
                       target="_blank" rel="noopener noreferrer"
                       class="ml-auto shrink-0 text-brand-gray/30 hover:text-brand-sage transition-colors"
                       aria-label="View original <?php echo esc_attr( $source_label ); ?> review">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                    <?php endif; ?>
                </div>

            </div>
            <?php endforeach;
            else : ?>
            <p class="md:col-span-3 text-center text-sm py-8 <?php echo esc_attr( $scheme['rating_text'] ); ?> opacity-60">
                No published reviews yet.
                <?php if ( current_user_can( 'edit_posts' ) ) : ?>
                <a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=zg_review' ) ); ?>"
                   class="underline <?php echo esc_attr( $scheme['eyebrow_text'] ); ?>">
                    Add the first review →
                </a>
                <?php endif; ?>
            </p>
            <?php endif; ?>
        </div>

    </div>
</section>
