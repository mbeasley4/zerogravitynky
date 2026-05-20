<?php
/**
 * Dynamic render for zerogravitynky/zg-image-split block.
 *
 * Attributes:
 *   imageUrl, imageAlt, imagePosition (left|right),
 *   background (dark|olive|lavender|white),
 *   heading, content (wpautop'd),
 *   ctaLabel1, ctaUrl1, ctaLabel2, ctaUrl2
 */
defined( 'ABSPATH' ) || exit;

$image_url      = $attributes['imageUrl']      ?? '';
$image_alt      = $attributes['imageAlt']      ?? '';
$image_position = $attributes['imagePosition'] ?? 'left';
$background     = $attributes['background']    ?? 'lavender';
$heading        = $attributes['heading']       ?? '';
$content        = $attributes['content']       ?? '';
$cta_label1     = $attributes['ctaLabel1']     ?? '';
$cta_url1       = $attributes['ctaUrl1']       ?? '';
$cta_label2     = $attributes['ctaLabel2']     ?? '';
$cta_url2       = $attributes['ctaUrl2']       ?? '';

// ── Colour tokens ────────────────────────────────────────────────────────────
if ( 'dark' === $background ) {
    $section_bg    = 'bg-brand-dark';
    $heading_class = 'text-white';
    $body_class    = 'text-white/60';
    $prose_class   = 'prose-invert';
    $cta1_class    = 'bg-brand-sage text-white hover:bg-brand-mid shadow-lg hover:shadow-brand-sage/30 hover:scale-105';
    $cta2_class    = 'border-2 border-white text-white hover:bg-white/15';
} elseif ( 'olive' === $background ) {
    $section_bg    = 'bg-brand-sage';
    $heading_class = 'text-white';
    $body_class    = 'text-white/75';
    $prose_class   = 'prose-invert';
    $cta1_class    = 'bg-white text-brand-dark hover:bg-brand-sand shadow-lg hover:scale-105';
    $cta2_class    = 'border-2 border-white text-white hover:bg-white/15';
} elseif ( 'white' === $background ) {
    $section_bg    = 'bg-white';
    $heading_class = 'text-brand-dark';
    $body_class    = 'text-brand-dark/70';
    $prose_class   = '';
    $cta1_class    = 'bg-brand-sage text-white hover:bg-brand-mid shadow-lg hover:shadow-brand-sage/30 hover:scale-105';
    $cta2_class    = 'border-2 border-brand-dark text-brand-dark hover:bg-brand-dark/10';
} else {
    // lavender (default)
    $section_bg    = 'bg-brand-sand';
    $heading_class = 'text-brand-dark';
    $body_class    = 'text-brand-dark/70';
    $prose_class   = '';
    $cta1_class    = 'bg-brand-sage text-white hover:bg-brand-mid shadow-lg hover:shadow-brand-sage/30 hover:scale-105';
    $cta2_class    = 'border-2 border-brand-dark text-brand-dark hover:bg-brand-dark/10';
}

// ── Image position: on mobile the image is always rendered first (order-first).
// On ≥md, use CSS order to swap when imagePosition = right.
$img_order     = ( 'right' === $image_position ) ? 'md:order-2' : '';
$content_order = ( 'right' === $image_position ) ? 'md:order-1' : '';

// ── External link helper ─────────────────────────────────────────────────────
$site_host = wp_parse_url( home_url(), PHP_URL_HOST );
if ( ! function_exists( 'zg_split_is_external' ) ) {
    function zg_split_is_external( string $url, string $host ): bool {
        if ( empty( $url ) ) return false;
        $parsed = wp_parse_url( $url );
        if ( empty( $parsed['host'] ) ) return false;
        return $parsed['host'] !== $host;
    }
}

$external_icon = '<svg class="w-3 h-3 inline-block ml-1 opacity-80 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>';

$arrow_svg = '<svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>';
?>
<section class="py-20 <?php echo esc_attr( $section_bg ); ?> overflow-hidden">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">
        <div class="grid md:grid-cols-2 gap-12 lg:gap-16 items-center">

            <!-- Image column — always first in DOM so it sits on top on mobile -->
            <div class="reveal <?php echo esc_attr( $img_order ); ?>">
                <?php if ( $image_url ) : ?>
                <div class="rounded-2xl overflow-hidden shadow-xl aspect-[4/3]">
                    <img src="<?php echo esc_url( $image_url ); ?>"
                         alt="<?php echo esc_attr( $image_alt ); ?>"
                         class="w-full h-full object-cover" />
                </div>
                <?php else : ?>
                <div class="rounded-2xl bg-brand-dark/10 aspect-[4/3] flex items-center justify-center">
                    <span class="text-brand-dark/30 text-sm">No image selected</span>
                </div>
                <?php endif; ?>
            </div>

            <!-- Content column -->
            <div class="reveal <?php echo esc_attr( $content_order ); ?>">

                <?php if ( $heading ) : ?>
                <h2 class="font-serif text-3xl lg:text-4xl xl:text-5xl <?php echo esc_attr( $heading_class ); ?> font-bold leading-tight mb-5">
                    <?php echo wp_kses_post( $heading ); ?>
                </h2>
                <?php endif; ?>

                <?php if ( $content ) : ?>
                <div class="<?php echo esc_attr( $body_class ); ?> text-base leading-relaxed mb-8 prose <?php echo esc_attr( $prose_class ); ?> max-w-none">
                    <?php echo wp_kses_post( wpautop( $content ) ); ?>
                </div>
                <?php endif; ?>

                <?php if ( $cta_label1 || $cta_label2 ) : ?>
                <div class="flex flex-wrap gap-4">
                    <?php if ( $cta_label1 && $cta_url1 ) : ?>
                    <a href="<?php echo esc_url( $cta_url1 ); ?>"
                       class="inline-flex items-center gap-2 px-7 py-3.5 <?php echo esc_attr( $cta1_class ); ?> font-semibold rounded-full transition-all text-sm"
                       <?php echo zg_split_is_external( $cta_url1, $site_host ) ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
                        <?php echo esc_html( $cta_label1 ); ?>
                        <?php echo zg_split_is_external( $cta_url1, $site_host ) ? $external_icon : $arrow_svg; // phpcs:ignore ?>
                    </a>
                    <?php endif; ?>

                    <?php if ( $cta_label2 && $cta_url2 ) : ?>
                    <a href="<?php echo esc_url( $cta_url2 ); ?>"
                       class="inline-flex items-center gap-2 px-7 py-3.5 <?php echo esc_attr( $cta2_class ); ?> font-semibold rounded-full transition-all text-sm"
                       <?php echo zg_split_is_external( $cta_url2, $site_host ) ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
                        <?php echo esc_html( $cta_label2 ); ?>
                        <?php echo zg_split_is_external( $cta_url2, $site_host ) ? $external_icon : ''; // phpcs:ignore ?>
                    </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>
