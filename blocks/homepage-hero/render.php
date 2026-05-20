<?php
$badge          = $attributes['badge']          ?? 'Voted Best Med Spa in Northern Kentucky';
$headline_l1    = $attributes['headlineLine1']  ?? 'Reveal Your';
$headline_acc   = $attributes['headlineAccent'] ?? 'Most Radiant';
$headline_l3    = $attributes['headlineLine3']  ?? 'Self';
$subheadline    = $attributes['subheadline']    ?? "Northern Kentucky's premier medical spa — operated by nurse practitioners and RNs with 20+ years of combined expertise.";
$cta_label1     = $attributes['ctaLabel1']      ?? 'Book a Consultation';
$cta_url1       = $attributes['ctaUrl1']        ?? '/zg-wellness-dermatology-services/';
$cta_label2     = $attributes['ctaLabel2']      ?? 'View Services';
$cta_url2       = $attributes['ctaUrl2']        ?? '#services';
$image_url      = $attributes['imageUrl']       ?? '';
$image_alt      = $attributes['imageAlt']       ?? 'Voted Best Med Spa in Northern Kentucky';

// Fall back to theme image if no upload
if ( empty( $image_url ) ) {
    $image_url = get_template_directory_uri() . '/images/hero-img.png';
}
?>
<section class="relative min-h-[78vh] bg-hero-gradient flex items-center overflow-hidden" style="padding-top: 72px;">
    <div class="hero-glow pointer-events-none"></div>
    <div class="blob absolute -top-32 -right-32 w-96 h-96 bg-brand-mid/30 blur-3xl pointer-events-none"></div>
    <div class="blob absolute bottom-0 -left-24 w-80 h-80 bg-brand-sage/40 blur-3xl pointer-events-none" style="animation-delay:-3s"></div>
    <div class="absolute top-1/3 right-1/4 w-64 h-64 bg-brand-taupe/10 rounded-full blur-2xl animate-float-slow pointer-events-none"></div>
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, rgba(255,255,255,0.4) 1px, transparent 1px); background-size: 36px 36px;"></div>

    <div class="relative max-w-7xl mx-auto px-5 lg:px-8 py-20 lg:py-16 grid lg:grid-cols-2 gap-12 items-center">
        <div>
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full glass mb-6">
                <svg class="w-4 h-4 text-brand-taupe" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                <span class="text-white text-xs font-semibold tracking-wider uppercase"><?php echo esc_html( $badge ); ?></span>
            </div>
            <h1 class="font-serif text-5xl lg:text-6xl xl:text-7xl text-white leading-tight mb-6">
                <?php echo esc_html( $headline_l1 ); ?><br />
                <em class="not-italic shimmer-text"><?php echo esc_html( $headline_acc ); ?></em><br />
                <?php echo esc_html( $headline_l3 ); ?>
            </h1>
            <p class="text-white/70 text-lg lg:text-xl leading-relaxed mb-10 max-w-lg">
                <?php echo esc_html( $subheadline ); ?>
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="<?php echo esc_url( $cta_url1 ); ?>" class="px-8 py-4 bg-brand-sage text-white font-semibold rounded-full hover:bg-brand-mid hover:scale-105 transition shadow-lg hover:shadow-brand-sage/30">
                    <?php echo esc_html( $cta_label1 ); ?>
                </a>
                <a href="<?php echo esc_url( $cta_url2 ); ?>" class="px-8 py-4 glass text-white rounded-full">
                    <?php echo esc_html( $cta_label2 ); ?>
                </a>
            </div>
        </div>

        <div class="hidden lg:flex justify-center items-center relative h-[520px]">
            <div class="absolute inset-4 rounded-3xl overflow-hidden shadow-2xl border border-white/10 animate-float">
                <img src="<?php echo esc_url( $image_url ); ?>"
                    fetchpriority="high"
                     alt="<?php echo esc_attr( $image_alt ); ?>"
                     class="w-full h-full object-cover" />
                <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/50 via-transparent"></div>
            </div>
        </div>
    </div>

    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" class="w-full h-16 lg:h-20">
            <path d="M0 80L60 72C120 64 240 48 360 42.7C480 37.3 600 42.7 720 48C840 53.3 960 58.7 1080 56C1200 53.3 1320 42.7 1380 37.3L1440 32V80Z" fill="white"/>
        </svg>
    </div>
</section>
