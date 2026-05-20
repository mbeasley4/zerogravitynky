<?php
/**
 * Dynamic render for zerogravitynky/page-hero block.
 *
 * Optional attributes: title, subtext, ctaLabel, ctaUrl, imageId, imageUrl, imageAlt
 * Falls back to the page title when no title attribute is set.
 * Image attribute takes precedence over the featured image.
 */

defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

// Title: use attribute override, fall back to page title
$title = ! empty( $attributes['title'] )
    ? html_entity_decode( wp_strip_all_tags( $attributes['title'] ), ENT_QUOTES | ENT_HTML5, 'UTF-8' )
    : get_the_title( $post_id );

// Optional fields
$subtext   = $attributes['subtext']  ?? '';
$cta_label = $attributes['ctaLabel'] ?? '';
$cta_url   = $attributes['ctaUrl']   ?? '';

// Image: block attribute takes precedence over featured image
$image_url = '';
$image_alt = '';
if ( ! empty( $attributes['imageUrl'] ) ) {
    $image_url = $attributes['imageUrl'];
    $image_alt = $attributes['imageAlt'] ?? $title;
} elseif ( has_post_thumbnail( $post_id ) ) {
    $image_url = get_the_post_thumbnail_url( $post_id, 'large' );
    $image_alt = $title;
}
$has_image = ! empty( $image_url );

// ── Breadcrumbs ──────────────────────────────────────────────────────────────
$crumbs = [];

if ( is_page() ) {
    $ancestors = array_reverse( get_post_ancestors( $post_id ) );
    foreach ( $ancestors as $ancestor_id ) {
        $crumbs[] = [
            'label' => get_the_title( $ancestor_id ),
            'url'   => get_permalink( $ancestor_id ),
        ];
    }
} elseif ( is_singular( 'post' ) ) {
    $category = get_the_category( $post_id );
    if ( $category ) {
        $crumbs[] = [
            'label' => $category[0]->name,
            'url'   => get_category_link( $category[0]->term_id ),
        ];
    }
}
?>
<section class="page-hero-section relative overflow-hidden bg-hero-gradient <?php echo $has_image ? 'page-hero-tall' : 'page-hero-short'; ?>">

    <!-- Background decorations -->
    <div class="blob absolute -top-24 -right-24 w-80 h-80 bg-brand-mid/30 blur-3xl pointer-events-none"></div>
    <div class="blob absolute bottom-0 -left-20 w-72 h-72 bg-brand-sage/40 blur-3xl pointer-events-none" style="animation-delay:-3s"></div>
    <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: radial-gradient(circle, rgba(255,255,255,0.4) 1px, transparent 1px); background-size: 36px 36px;"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 py-16 flex flex-col <?php echo $has_image ? 'lg:flex-row lg:items-center lg:gap-12' : 'items-center text-center'; ?>">

        <!-- Text column -->
        <div class="<?php echo $has_image ? 'lg:flex-1' : 'max-w-2xl'; ?>">

            <!-- Breadcrumb -->
            <?php if ( ! empty( $crumbs ) || is_page() || is_single() ) : ?>
            <nav aria-label="Breadcrumb" class="flex items-center gap-1.5 text-xs text-white/50 mb-5 <?php echo $has_image ? '' : 'justify-center'; ?>">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-white/80 transition-colors">Home</a>
                <?php foreach ( $crumbs as $crumb ) : ?>
                    <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <a href="<?php echo esc_url( $crumb['url'] ); ?>" class="hover:text-white/80 transition-colors">
                        <?php echo esc_html( $crumb['label'] ); ?>
                    </a>
                <?php endforeach; ?>
                <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-white/80"><?php echo esc_html( $title ); ?></span>
            </nav>
            <?php endif; ?>

            <!-- H1 -->
            <h1 class="font-serif text-4xl lg:text-5xl font-bold text-white leading-tight mb-4">
                <?php echo esc_html( $title ); ?>
            </h1>

            <!-- Decorative gold line -->
            <div class="w-16 h-1 rounded-full bg-brand-taupe mb-5 <?php echo $has_image ? '' : 'mx-auto'; ?>"></div>

            <!-- Subtext -->
            <?php if ( ! empty( $subtext ) ) : ?>
            <div class="text-white/80 text-lg leading-relaxed mb-6 <?php echo $has_image ? '' : 'mx-auto max-w-xl'; ?>">
                <?php echo wp_kses_post( $subtext ); ?>
            </div>
            <?php endif; ?>

            <!-- CTA Button -->
            <?php if ( ! empty( $cta_label ) && ! empty( $cta_url ) ) : ?>
            <a href="<?php echo esc_url( $cta_url ); ?>"
               class="inline-block bg-brand-taupe hover:bg-brand-taupe/90 text-white font-semibold px-8 py-3 rounded-full transition-all shadow-lg text-sm">
                <?php echo esc_html( $cta_label ); ?>
            </a>
            <?php endif; ?>

        </div>

        <!-- Image column -->
        <?php if ( $has_image ) : ?>
        <div class="mt-10 lg:mt-0 lg:w-110 xl:w-130 shrink-0">
            <div class="relative rounded-2xl overflow-hidden shadow-2xl aspect-[4/3]">
                <img src="<?php echo esc_url( $image_url ); ?>"
                     alt="<?php echo esc_attr( $image_alt ); ?>"
                     class="w-full h-full object-cover"
                     loading="eager" />
                <div class="absolute inset-0 bg-gradient-to-tl from-brand-dark/30 to-transparent"></div>
            </div>
        </div>
        <?php endif; ?>

    </div>
</section>
