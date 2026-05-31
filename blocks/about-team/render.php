<?php
$bg              = $attributes['background']       ?? 'primary';
$badge_label     = $attributes['badgeLabel']       ?? 'Our Story';
$heading_line1   = $attributes['headingLine1']     ?? 'Medically Led.';
$heading_line2   = $attributes['headingLine2']     ?? 'Results Driven.';
$heading_line3   = $attributes['headingLine3']     ?? 'Locally Loved.';
$paragraph1      = $attributes['paragraph1']       ?? '';
$paragraph2      = $attributes['paragraph2']       ?? '';
$tags_raw        = $attributes['tags']             ?? '';
$cta_label       = $attributes['ctaLabel']         ?? 'Meet Our Team';
$cta_url         = $attributes['ctaUrl']           ?? '/staff/';
$founder_url     = $attributes['founderImageUrl']  ?? '';
$founder_alt     = $attributes['founderImageAlt']  ?? '';
$founder_name1   = $attributes['founderName1']     ?? 'Jennifer Walsh';
$founder_title1  = $attributes['founderTitle1']    ?? 'RN · Co-Founder';
$founder_name2   = $attributes['founderName2']     ?? 'Candace Reusch';
$founder_title2  = $attributes['founderTitle2']    ?? 'MSN, APRN, FNP-C · Co-Founder';
$exterior_url    = $attributes['exteriorImageUrl'] ?? '';
$exterior_alt    = $attributes['exteriorImageAlt'] ?? '';
$exterior_caption = $attributes['exteriorCaption'] ?? '';
$reasons_raw     = $attributes['reasons']          ?? '';

$tags    = array_filter( array_map( 'trim', explode( "\n", $tags_raw ) ) );
$reasons = array_filter( array_map( 'trim', explode( "\n", $reasons_raw ) ) );

// ── Colour tokens per variant ─────────────────────────────────────────────────
if ( $bg === 'secondary' ) {
    // Gold background — dark text
    $section_bg      = 'bg-brand-taupe';
    $badge_color     = 'text-brand-dark';
    $badge_line_bg   = 'bg-brand-dark';
    $heading_color   = 'text-brand-dark';
    $accent_class    = 'text-brand-dark font-bold';   // no shimmer on gold bg
    $body_text       = 'text-brand-dark/70';
    $strong_text     = 'text-brand-dark';
    $tag_class       = 'bg-white/30 text-brand-dark border border-brand-dark/10';
    $cta_class       = 'bg-brand-dark text-white hover:bg-brand-sage shadow-lg hover:shadow-brand-dark/30';
    $card_bg         = 'bg-white/20 border border-brand-dark/10';
    $card_label      = 'text-brand-dark';
    $reason_icon_bg  = 'bg-brand-dark/15';
    $reason_text     = 'text-brand-dark/75';
    $overlay_from    = 'from-brand-dark/60';
    $overlay_card    = 'from-brand-dark/60';
    $img_name_text   = 'text-white';
    $img_title_text  = 'text-white/80';
    $loc_label       = 'text-white/80';
    $loc_text        = 'text-white';
    $check_icon_fill = '#3A3028';
} elseif ( $bg === 'white' ) {
    // White background — dark text
    $section_bg      = 'bg-white';
    $badge_color     = 'text-brand-taupe';
    $badge_line_bg   = 'bg-brand-taupe';
    $heading_color   = 'text-brand-dark';
    $accent_class    = 'shimmer-text';
    $body_text       = 'text-brand-dark/60';
    $strong_text     = 'text-brand-dark';
    $tag_class       = 'bg-brand-dark/5 border border-brand-dark/10 text-brand-dark/70';
    $cta_class       = 'bg-brand-sage text-white hover:bg-brand-mid shadow-lg hover:shadow-brand-sage/30';
    $card_bg         = 'bg-brand-dark/5 border border-brand-dark/10';
    $card_label      = 'text-brand-taupe';
    $reason_icon_bg  = 'bg-brand-taupe/20';
    $reason_text     = 'text-brand-dark/70';
    $overlay_from    = 'from-brand-dark/60';
    $overlay_card    = 'from-brand-dark/60';
    $img_name_text   = 'text-white';
    $img_title_text  = 'text-white/80';
    $loc_label       = 'text-white/70';
    $loc_text        = 'text-white';
    $check_icon_fill = '#7A8F7B';
} else {
    // Primary = brand-dark — white text (default)
    $section_bg      = 'bg-brand-dark';
    $badge_color     = 'text-brand-taupe';
    $badge_line_bg   = 'bg-brand-taupe';
    $heading_color   = 'text-white';
    $accent_class    = 'shimmer-text';
    $body_text       = 'text-white/60';
    $strong_text     = 'text-white';
    $tag_class       = 'glass text-white/80';
    $cta_class       = 'bg-brand-sage text-white hover:bg-brand-mid shadow-lg hover:shadow-brand-sage/30';
    $card_bg         = 'glass';
    $card_label      = 'text-brand-taupe';
    $reason_icon_bg  = 'bg-brand-taupe/20';
    $reason_text     = 'text-white/70';
    $overlay_from    = 'from-brand-dark/60';
    $overlay_card    = 'from-brand-dark/60';
    $img_name_text   = 'text-white';
    $img_title_text  = 'text-brand-light';
    $loc_label       = 'text-white/70';
    $loc_text        = 'text-white';
    $check_icon_fill = '#7A8F7B';
}

$check_svg = '<svg class="w-3 h-3" fill="' . esc_attr( $check_icon_fill ) . '" viewBox="0 0 16 16"><path d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.75.75 0 0 1 1.06-1.06L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0z"/></svg>';

$arrow_svg = '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>';
?>
<section id="about" class="py-24 <?php echo esc_attr( $section_bg ); ?> overflow-hidden">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">

            <!-- ── Left: copy ─────────────────────────────────────── -->
            <div class="reveal">
                <div class="inline-flex items-center gap-2 <?php echo esc_attr( $badge_color ); ?> text-sm font-semibold uppercase tracking-widest mb-5">
                    <span class="w-8 h-px <?php echo esc_attr( $badge_line_bg ); ?>"></span>
                    <?php echo esc_html( $badge_label ); ?>
                </div>

                <h2 class="font-serif text-4xl lg:text-5xl <?php echo esc_attr( $heading_color ); ?> font-bold leading-tight mb-6">
                    <?php echo esc_html( $heading_line1 ); ?><br />
                    <span class="<?php echo esc_attr( $accent_class ); ?>"><?php echo esc_html( $heading_line2 ); ?></span><br />
                    <?php echo esc_html( $heading_line3 ); ?>
                </h2>

                <?php if ( $paragraph1 ) : ?>
                <p class="<?php echo esc_attr( $body_text ); ?> text-base leading-relaxed mb-5">
                    <?php echo esc_html( $paragraph1 ); ?>
                </p>
                <?php endif; ?>

                <?php if ( $paragraph2 ) : ?>
                <p class="<?php echo esc_attr( $body_text ); ?> text-base leading-relaxed mb-8">
                    <?php echo wp_kses( $paragraph2, [ 'strong' => [], 'em' => [], 'a' => [ 'href' => [], 'class' => [] ] ] ); ?>
                </p>
                <?php endif; ?>

                <?php if ( $tags ) : ?>
                <div class="flex flex-wrap gap-3 mb-10">
                    <?php foreach ( $tags as $tag ) : ?>
                    <span class="<?php echo esc_attr( $tag_class ); ?> px-4 py-2 rounded-full text-xs font-medium">
                        <?php echo esc_html( $tag ); ?>
                    </span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <?php if ( $cta_label && $cta_url ) : ?>
                <a href="<?php echo esc_url( $cta_url ); ?>"
                   class="inline-flex items-center gap-2 px-7 py-3.5 <?php echo esc_attr( $cta_class ); ?> font-semibold rounded-full transition-all text-sm">
                    <?php echo esc_html( $cta_label ); ?>
                    <?php echo $arrow_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </a>
                <?php endif; ?>
            </div>

            <!-- ── Right: images + card ───────────────────────────── -->
            <div class="reveal flex flex-col gap-5">

                <!-- Founder photo -->
                <?php if ( $founder_url ) : ?>
                <div class="rounded-2xl overflow-hidden relative shadow-xl">
                    <img src="<?php echo esc_url( $founder_url ); ?>"
                         alt="<?php echo esc_attr( $founder_alt ); ?>"
                         class="w-full object-cover object-top"
                         loading="lazy"
                         style="max-height:260px;" />
                    <div class="absolute inset-0 bg-gradient-to-t <?php echo esc_attr( $overlay_from ); ?> via-transparent to-transparent"></div>
                    <?php if ( $founder_name1 || $founder_name2 ) : ?>
                    <div class="absolute bottom-0 left-0 right-0 p-5 flex gap-6">
                        <?php if ( $founder_name1 ) : ?>
                        <div>
                            <div class="<?php echo esc_attr( $img_name_text ); ?> font-semibold text-sm"><?php echo esc_html( $founder_name1 ); ?></div>
                            <div class="<?php echo esc_attr( $img_title_text ); ?> text-xs"><?php echo esc_html( $founder_title1 ); ?></div>
                        </div>
                        <?php endif; ?>
                        <?php if ( $founder_name2 ) : ?>
                        <div>
                            <div class="<?php echo esc_attr( $img_name_text ); ?> font-semibold text-sm"><?php echo esc_html( $founder_name2 ); ?></div>
                            <div class="<?php echo esc_attr( $img_title_text ); ?> text-xs"><?php echo esc_html( $founder_title2 ); ?></div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <!-- Exterior photo -->
                <?php if ( $exterior_url ) : ?>
                <div class="rounded-2xl overflow-hidden relative shadow-xl">
                    <img src="<?php echo esc_url( $exterior_url ); ?>"
                         alt="<?php echo esc_attr( $exterior_alt ); ?>"
                         class="w-full object-cover"
                         loading="lazy"
                         style="max-height:200px; object-position: center 30%;" />
                    <div class="absolute inset-0 bg-gradient-to-t <?php echo esc_attr( $overlay_card ); ?> via-transparent to-transparent"></div>
                    <?php if ( $exterior_caption ) : ?>
                    <div class="absolute bottom-0 left-0 right-0 p-4">
                        <div class="<?php echo esc_attr( $loc_label ); ?> text-xs uppercase tracking-widest mb-0.5">Find Us At</div>
                        <div class="<?php echo esc_attr( $loc_text ); ?> font-semibold text-sm"><?php echo esc_html( $exterior_caption ); ?></div>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <!-- Why choose us card -->
                <?php if ( $reasons ) : ?>
                <div class="<?php echo esc_attr( $card_bg ); ?> rounded-2xl p-6">
                    <div class="<?php echo esc_attr( $card_label ); ?> text-xs uppercase tracking-widest font-semibold mb-4">Why Patients Choose Us</div>
                    <div class="space-y-3">
                        <?php foreach ( $reasons as $reason ) : ?>
                        <div class="flex items-start gap-3">
                            <div class="w-5 h-5 rounded-full <?php echo esc_attr( $reason_icon_bg ); ?> flex items-center justify-center flex-shrink-0 mt-0.5">
                                <?php echo $check_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                            </div>
                            <span class="<?php echo esc_attr( $reason_text ); ?> text-sm"><?php echo esc_html( $reason ); ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>
