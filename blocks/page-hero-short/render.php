<?php
/**
 * Dynamic render for zerogravitynky/page-hero-short block.
 *
 * Attributes: eyebrow, headingBefore, headingShimmer, subtext
 */

defined( 'ABSPATH' ) || exit;

$eyebrow        = $attributes['eyebrow']        ?? 'Zero Gravity Aesthetics &amp; Wellness';
$heading_before = $attributes['headingBefore']  ?? '';
$heading_shimmer= $attributes['headingShimmer'] ?? '';
$subtext        = $attributes['subtext']        ?? '';
?>
<section class="page-hero-section page-hero-short relative pb-10 text-white overflow-hidden bg-hero-gradient" <?php echo get_block_wrapper_attributes(); ?>>

    <div class="absolute -top-24 -right-24 w-96 h-96 bg-brand-taupe/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-16 -left-24 w-125 h-125 bg-brand-light/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute inset-0 opacity-10 pointer-events-none"
         style="background-image: radial-gradient(circle, rgba(255,255,255,0.4) 1px, transparent 1px); background-size: 36px 36px;"></div>

    <div class="relative max-w-7xl mx-auto px-5 lg:px-8 text-center">

        <?php if ( $eyebrow ) : ?>
        <p class="uppercase tracking-widest text-brand-taupe-light text-xs font-semibold mb-4">
            <?php echo wp_kses_post( $eyebrow ); ?>
        </p>
        <?php endif; ?>

        <h1 class="font-serif text-5xl md:text-6xl leading-tight mb-4 text-white">
            <?php if ( $heading_before ) : ?>
            <?php echo esc_html( $heading_before ); ?>
            <?php endif; ?>
            <?php if ( $heading_shimmer ) : ?>
            <span class="shimmer-text"><?php echo esc_html( $heading_shimmer ); ?></span>
            <?php endif; ?>
        </h1>

        <?php if ( $subtext ) : ?>
        <p class="text-white/70 text-lg max-w-md mx-auto">
            <?php echo wp_kses_post( $subtext ); ?>
        </p>
        <?php endif; ?>

    </div>
</section>
