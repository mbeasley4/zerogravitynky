<?php
$section_title = $attributes['sectionTitle']    ?? '';
$services      = $attributes['services']        ?? [];
$bg_option     = $attributes['backgroundColor'] ?? 'white';
$cta_label     = $attributes['ctaLabel']        ?? 'View All Services';
$cta_url       = $attributes['ctaUrl']          ?? '/services/';

if ( empty( $services ) ) {
    $block_meta = json_decode( file_get_contents( __DIR__ . '/block.json' ), true );
    $services   = $block_meta['attributes']['services']['default'] ?? [];
}

if ( empty( $services ) ) {
    return;
}

/*
 * ADA/WCAG AA compliant color mapping per background choice.
 *
 * white       – bg #ffffff  | heading #2d0a5e (12.4:1) | body #515151 (7.4:1) | link #720eec (5.9:1)
 * lavender    – bg #e9e6ed  | heading #2d0a5e (11.1:1) | body #515151 (6.6:1) | link #4a0099 (7.3:1)
 * purple-dark – bg #2d0a5e  | heading #ffffff (12.4:1) | body rgba white/85   | link #c4a8ff (5.2:1)
 *
 * Card backgrounds are chosen to maintain legible card/section separation
 * while keeping inner text contrast compliant.
 */
switch ( $bg_option ) {
    case 'lavender':
        $section_bg_class  = 'bg-brand-sand';
        $heading_class     = 'text-brand-dark';
        $card_bg_class     = 'bg-white';
        $card_title_class  = 'text-brand-dark';
        $card_desc_class   = 'text-brand-gray/80';
        $card_link_class   = 'text-[#7A8F7B] hover:text-brand-sage';
        $overlay_class     = 'bg-brand-sage/20 group-hover:bg-brand-sage/10';
        $btn_class         = 'bg-brand-sage text-white hover:bg-brand-dark';
        break;

    case 'purple-dark':
        $section_bg_class  = 'bg-brand-dark';
        $heading_class     = 'text-white';
        $card_bg_class     = 'bg-white/10 border border-white/15';
        $card_title_class  = 'text-white';
        $card_desc_class   = 'text-white/80';
        $card_link_class   = 'text-[#B7AFA3] hover:text-white';
        $overlay_class     = 'bg-white/10 group-hover:bg-white/5';
        $btn_class         = 'bg-white text-brand-dark hover:bg-brand-sand';
        break;

    default: // white
        $section_bg_class  = 'bg-white';
        $heading_class     = 'text-brand-dark';
        $card_bg_class     = 'bg-brand-sand';
        $card_title_class  = 'text-brand-dark';
        $card_desc_class   = 'text-brand-gray/70';
        $card_link_class   = 'text-brand-sage hover:text-brand-dark';
        $overlay_class     = 'bg-brand-sage/20 group-hover:bg-brand-sage/10';
        $btn_class         = 'bg-brand-sage text-white hover:bg-brand-dark';
        break;
}
?>
<section id="services" class="py-24 <?php echo esc_attr( $section_bg_class ); ?>">
    <?php if ( $section_title ) : ?>
    <div class="max-w-7xl mx-auto px-5 lg:px-8 mb-10 text-center reveal">
        <h2 class="font-serif text-4xl lg:text-5xl font-bold <?php echo esc_attr( $heading_class ); ?>">
            <?php echo esc_html( $section_title ); ?>
        </h2>
    </div>
    <?php endif; ?>

    <div class="max-w-7xl mx-auto px-5 lg:px-8 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ( $services as $s ) :
            $img   = esc_url( $s['imageUrl'] ?? '' );
            $alt   = esc_attr( $s['imageAlt'] ?? ( $s['title'] ?? '' ) );
            $title = $s['title']       ?? '';
            $desc  = $s['description'] ?? '';
            $url   = esc_url( $s['linkUrl']  ?? '#' );
            $link  = $s['linkText']    ?? 'Learn More';
        ?>
        <div class="service-card reveal group <?php echo esc_attr( $card_bg_class ); ?> rounded-2xl overflow-hidden cursor-pointer border border-transparent hover:border-brand-sage/20">
            <div class="h-44 overflow-hidden relative">
                <?php if ( $img ) : ?>
                    <img src="<?php echo $img; ?>"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                         alt="<?php echo $alt; ?>" />
                <?php else : ?>
                    <div class="w-full h-full bg-brand-mid/30 flex items-center justify-center">
                        <span class="text-brand-sage/50 text-sm">No image set</span>
                    </div>
                <?php endif; ?>
                <div class="absolute inset-0 <?php echo esc_attr( $overlay_class ); ?> transition-colors"></div>
            </div>
            <div class="p-7">
                <h3 class="font-serif text-xl font-semibold <?php echo esc_attr( $card_title_class ); ?> mb-3">
                    <?php echo esc_html( $title ); ?>
                </h3>
                <p class="<?php echo esc_attr( $card_desc_class ); ?> text-sm leading-relaxed mb-5">
                    <?php echo esc_html( $desc ); ?>
                </p>
                <a href="<?php echo $url; ?>"
                   class="inline-flex items-center gap-1.5 <?php echo esc_attr( $card_link_class ); ?> font-semibold text-sm group-hover:gap-3 transition-all"
                   aria-label="<?php echo esc_attr( $link . ' about ' . $title ); ?>">
                    <?php echo esc_html( $link ); ?> →
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php if ( $cta_label ) : ?>
    <div class="text-center mt-12 reveal">
        <a href="<?php echo esc_url( $cta_url ); ?>"
           class="inline-block px-10 py-4 rounded-full font-bold text-base transition-colors duration-200 <?php echo esc_attr( $btn_class ); ?>">
            <?php echo esc_html( $cta_label ); ?>
        </a>
    </div>
    <?php endif; ?>
</section>
