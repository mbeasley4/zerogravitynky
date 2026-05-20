<?php
/**
 * Dynamic render for zerogravitynky/zg-seo-callout block.
 *
 * Attributes:
 *   question   – opening hook / keyword-rich question
 *   body       – main SEO paragraph
 *   ctaLabel   – primary CTA label  (default: phone number)
 *   ctaUrl     – primary CTA URL    (default: tel:)
 *   ctaLabel2  – secondary CTA label (optional)
 *   ctaUrl2    – secondary CTA URL   (optional)
 */
defined( 'ABSPATH' ) || exit;

$question   = $attributes['question']  ?? 'Looking for the best med spa membership in Northern Kentucky?';
$body       = $attributes['body']      ?? '';
$cta_label  = $attributes['ctaLabel']  ?? 'Call (859) 344-3250';
$cta_url    = $attributes['ctaUrl']    ?? 'tel:8593443250';
$cta_label2 = $attributes['ctaLabel2'] ?? '';
$cta_url2   = $attributes['ctaUrl2']   ?? '';

$phone_icon = '<svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 8V5z"/></svg>';

$arrow_svg  = '<svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>';

$is_tel   = str_starts_with( $cta_url, 'tel:' );
$cta_icon = $is_tel ? $phone_icon : $arrow_svg;
?>
<section class="py-20 lg:py-28 bg-hero-gradient relative overflow-hidden">

    <!-- Dot-grid overlay -->
    <div class="absolute inset-0 opacity-[0.07]"
         style="background-image: radial-gradient(circle, rgba(255,255,255,0.9) 1px, transparent 1px); background-size: 26px 26px;"
         aria-hidden="true"></div>

    <!-- Decorative oversized quotation mark -->
    <div class="absolute -top-4 left-4 lg:left-10 font-serif text-white/6 select-none pointer-events-none leading-none"
         style="font-size: clamp(12rem, 22vw, 20rem); line-height: 1;" aria-hidden="true">&ldquo;</div>

    <!-- Top accent bar -->
    <div class="absolute top-0 left-0 right-0 h-1 bg-linear-to-r from-transparent via-brand-light to-transparent opacity-50"></div>

    <div class="relative max-w-4xl mx-auto px-5 lg:px-8 reveal">

        <!-- Location badge -->
        <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 text-white/80 text-xs font-semibold uppercase tracking-widest px-4 py-1.5 rounded-full mb-8 backdrop-blur-sm">
            <svg class="w-3 h-3 text-brand-light" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
            </svg>
            Crestview Hills, KY
        </div>

        <!-- Question / hook line -->
        <p class="font-serif text-2xl md:text-3xl lg:text-4xl xl:text-[2.65rem] text-white font-bold leading-snug mb-7 drop-shadow-md">
            <?php echo esc_html( $question ); ?>
        </p>

        <!-- Divider accent -->
        <div class="w-16 h-0.5 bg-linear-to-r from-brand-light to-transparent mb-7 rounded-full"></div>

        <!-- Body copy -->
        <?php if ( $body ) : ?>
        <p class="text-white/80 text-lg lg:text-xl leading-relaxed mb-10 max-w-3xl">
            <?php echo esc_html( $body ); ?>
        </p>
        <?php endif; ?>

        <!-- CTA buttons -->
        <div class="flex flex-wrap gap-4">
            <?php if ( $cta_label && $cta_url ) : ?>
            <a href="<?php echo esc_url( $cta_url ); ?>"
               class="inline-flex items-center gap-2 px-8 py-4 bg-white text-brand-dark font-bold rounded-full shadow-2xl hover:bg-brand-sand transition-all text-sm hover:scale-105">
                <?php echo $cta_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                <?php echo esc_html( $cta_label ); ?>
            </a>
            <?php endif; ?>

            <?php if ( $cta_label2 && $cta_url2 ) : ?>
            <a href="<?php echo esc_url( $cta_url2 ); ?>"
               class="inline-flex items-center gap-2 px-8 py-4 border-2 border-white/60 text-white font-semibold rounded-full hover:bg-white/15 hover:border-white transition-all text-sm">
                <?php echo esc_html( $cta_label2 ); ?>
                <?php echo $arrow_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </a>
            <?php endif; ?>
        </div>

    </div>

    <!-- Bottom accent bar -->
    <div class="absolute bottom-0 left-0 right-0 h-1 bg-linear-to-r from-transparent via-brand-light to-transparent opacity-50"></div>

</section>
