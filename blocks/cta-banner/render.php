<?php
/**
 * Dynamic render for zerogravitynky/cta-banner block.
 */
defined( 'ABSPATH' ) || exit;

$headline   = ! empty( $attributes['headline'] )  ? $attributes['headline']  : 'Ready to Feel Like You?';
$subtext    = ! empty( $attributes['subtext'] )    ? $attributes['subtext']   : 'Book your complimentary consultation today and let our team craft a personalized treatment plan for your skin and wellness goals.';
$cta_label1 = ! empty( $attributes['ctaLabel1'] ) ? $attributes['ctaLabel1'] : 'Schedule Your Visit';
$cta_url1   = ! empty( $attributes['ctaUrl1'] )   ? $attributes['ctaUrl1']   : 'https://web2.myaestheticspro.com/bn/index.cfm?A4E84A7CF274D7120B24A83F9BCC94DE';
$cta_label2 = ! empty( $attributes['ctaLabel2'] ) ? $attributes['ctaLabel2'] : '(859) 344-3250';
$cta_url2   = ! empty( $attributes['ctaUrl2'] )   ? $attributes['ctaUrl2']   : 'tel:8593443250';
$variant    = ! empty( $attributes['variant'] )   ? $attributes['variant']   : 'gold';

$site_host = wp_parse_url( home_url(), PHP_URL_HOST );

if ( ! function_exists( 'zg_cta_is_external' ) ) {
    function zg_cta_is_external( $url, $site_host ) {
        if ( empty( $url ) ) return false;
        $parsed = wp_parse_url( $url );
        if ( empty( $parsed['host'] ) ) return false;
        return $parsed['host'] !== $site_host;
    }
}

$external_icon = '<svg class="w-3 h-3 inline-block ml-1 opacity-80 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>';

// ── Variant tokens ────────────────────────────────────────────────────────────
if ( $variant === 'purple' ) {
    // Sage gradient — lush botanical
    $section_bg  = 'linear-gradient(135deg, #3D4A3E 0%, #58775A 40%, #7A8F7B 70%, #94A995 100%)';
    $btn1_bg     = '#ffffff';
    $btn1_color  = '#3D4A3E';
    $blob1       = '#B7AFA3';
    $blob2       = '#94A995';
    $dot_opacity = '0.08';

} elseif ( $variant === 'dark' ) {
    // Deep olive — near-black, ultra-luxe
    $section_bg  = 'linear-gradient(135deg, #0C1510 0%, #162018 30%, #243527 58%, #344A36 80%, #3D4A3E 100%)';
    $btn1_bg     = 'linear-gradient(135deg, #8A8178 0%, #B7AFA3 50%, #E8DED2 100%)';
    $btn1_color  = '#1C2B1E';
    $blob1       = '#2A3D2C';
    $blob2       = '#1A2A1C';
    $dot_opacity = '0.06';

} else {
    // Warm taupe — rich bronze-to-sand gradient
    $section_bg  = 'linear-gradient(135deg, #5C5248 0%, #7A7068 30%, #A09690 58%, #B7AFA3 78%, #CFC5BA 100%)';
    $btn1_bg     = '#ffffff';
    $btn1_color  = '#5C5248';
    $blob1       = 'rgba(255,255,255,0.22)';
    $blob2       = 'rgba(232,222,210,0.28)';
    $dot_opacity = '0.10';
}
?>
<section class="py-24 relative overflow-hidden" style="background: <?php echo esc_attr( $section_bg ); ?>">

    <!-- Dot grid -->
    <div class="absolute inset-0 pointer-events-none"
         style="opacity:<?php echo esc_attr( $dot_opacity ); ?>; background-image: radial-gradient(circle, rgba(255,255,255,0.7) 1px, transparent 1px); background-size: 28px 28px;"></div>

    <!-- Decorative blobs -->
    <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full blur-3xl pointer-events-none"
         style="background:<?php echo esc_attr( $blob1 ); ?>; opacity:0.30;"></div>
    <div class="absolute -bottom-24 -right-24 w-lg h-128 rounded-full blur-3xl pointer-events-none"
         style="background:<?php echo esc_attr( $blob2 ); ?>; opacity:0.25;"></div>

    <div class="relative max-w-3xl mx-auto px-5 text-center reveal">

        <h2 class="font-serif text-4xl lg:text-5xl xl:text-6xl text-white font-bold mb-5 leading-tight">
            <?php echo esc_html( html_entity_decode( $headline, ENT_QUOTES | ENT_HTML5, 'UTF-8' ) ); ?>
        </h2>

        <p class="text-white/80 text-lg mb-10 max-w-2xl mx-auto leading-relaxed">
            <?php echo wp_kses_post( $subtext ); ?>
        </p>

        <div class="flex flex-wrap gap-4 justify-center">

            <?php if ( $cta_label1 && $cta_url1 ) : ?>
            <a href="<?php echo esc_url( $cta_url1 ); ?>"
               class="inline-flex items-center font-bold rounded-full transition-all shadow-2xl text-sm hover:scale-105 hover:brightness-105"
               style="background:<?php echo esc_attr( $btn1_bg ); ?>; color:<?php echo esc_attr( $btn1_color ); ?>; padding: 1rem 2.25rem;"
               <?php echo zg_cta_is_external( $cta_url1, $site_host ) ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
                <?php echo esc_html( $cta_label1 ); ?>
                <?php if ( zg_cta_is_external( $cta_url1, $site_host ) ) echo $external_icon; // phpcs:ignore ?>
            </a>
            <?php endif; ?>

            <?php if ( $cta_label2 && $cta_url2 ) : ?>
            <a href="<?php echo esc_url( $cta_url2 ); ?>"
               class="inline-flex items-center border-2 border-white/70 text-white font-semibold rounded-full hover:bg-white/15 transition-all text-sm"
               style="padding: 1rem 2.25rem;"
               <?php echo zg_cta_is_external( $cta_url2, $site_host ) ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
                <?php echo esc_html( $cta_label2 ); ?>
                <?php if ( zg_cta_is_external( $cta_url2, $site_host ) ) echo $external_icon; // phpcs:ignore ?>
            </a>
            <?php endif; ?>

        </div>
    </div>
</section>
