<?php
/**
 * Dynamic render for zerogravitynky/membership-tier block.
 */
defined( 'ABSPATH' ) || exit;

$section_label = $attributes['sectionLabel'] ?? 'Memberships';
$section_title = $attributes['sectionTitle'] ?? 'Exclusive ZG Membership Plans';
$section_body  = $attributes['sectionBody']  ?? '';
$perks_raw     = $attributes['perks']        ?? '';
$cta_label     = $attributes['ctaLabel']     ?? 'Explore Memberships';
$cta_url       = $attributes['ctaUrl']       ?? '/zero-gravity-memberships/';
$image_url     = $attributes['imageUrl']     ?? '';
$image_alt     = $attributes['imageAlt']     ?? 'Zero Gravity Memberships';

$tier1_label   = $attributes['tier1Label']   ?? 'Wellness';
$tier1_name    = $attributes['tier1Name']    ?? 'Vitality Membership';
$tier1_desc    = $attributes['tier1Desc']    ?? '';
$tier1_badge   = $attributes['tier1Badge']   ?? 'Popular';

$tier2_label   = $attributes['tier2Label']   ?? 'Premium';
$tier2_name    = $attributes['tier2Name']    ?? 'ZG VIP Membership';
$tier2_desc    = $attributes['tier2Desc']    ?? '';

$perks = array_filter( array_map( 'trim', explode( "\n", $perks_raw ) ) );

// ── Color scheme ─────────────────────────────────────────────────────────
$bg_color = $attributes['bgColor'] ?? 'white';

$schemes = [
    'white' => [
        'section_bg'    => '#ffffff',
        'label_color'   => '#7A8F7B',
        'line_color'    => '#7A8F7B',
        'heading_color' => '#3D4A3E',
        'body_color'    => 'rgba(81,81,81,0.7)',
        'perk_color'    => '#515151',
        'check_color'   => '#7A8F7B',
        'cta_bg'        => '#7A8F7B',
        'cta_text'      => '#ffffff',
        'is_dark_bg'    => false,
    ],
    // Beige / Sand (#E8DED2) — calm, natural, high-end
    'lavender' => [
        'section_bg'    => '#E8DED2',
        'label_color'   => '#7A8F7B',
        'line_color'    => '#7A8F7B',
        'heading_color' => '#3D4A3E',
        'body_color'    => 'rgba(61,74,62,0.7)',
        'perk_color'    => '#3D4A3E',
        'check_color'   => '#7A8F7B',
        'cta_bg'        => '#7A8F7B',
        'cta_text'      => '#ffffff',
        'is_dark_bg'    => false,
    ],
    // Sage (#7A8F7B) — white text for contrast
    'purple' => [
        'section_bg'    => '#7A8F7B',
        'label_color'   => 'rgba(255,255,255,0.9)',
        'line_color'    => 'rgba(255,255,255,0.5)',
        'heading_color' => '#ffffff',
        'body_color'    => 'rgba(255,255,255,0.85)',
        'perk_color'    => 'rgba(255,255,255,0.9)',
        'check_color'   => '#ffffff',
        'cta_bg'        => '#ffffff',
        'cta_text'      => '#3D4A3E',
        'is_dark_bg'    => true,
    ],
    // Taupe (#B7AFA3) — dark olive text for contrast
    'gold' => [
        'section_bg'    => '#B7AFA3',
        'label_color'   => '#3D4A3E',
        'line_color'    => '#3D4A3E',
        'heading_color' => '#3D4A3E',
        'body_color'    => 'rgba(61,74,62,0.8)',
        'perk_color'    => '#3D4A3E',
        'check_color'   => '#3D4A3E',
        'cta_bg'        => '#3D4A3E',
        'cta_text'      => '#ffffff',
        'is_dark_bg'    => false,
    ],
];

$scheme      = $schemes[ $bg_color ] ?? $schemes['white'];
$is_dark_bg  = $scheme['is_dark_bg'];

// ── Tier card styles (vary by section background) ─────────────────────────
// On dark/saturated backgrounds the cards must be solid white so they clearly pop.
if ( 'gold' === $bg_color ) {
    // White card on taupe: dark olive border + shadow for depth
    $card1_style = 'background-color:#ffffff;border-color:#3D4A3E;box-shadow:0 6px 24px rgba(61,74,62,0.18);';
    $card2_style = 'background-color:#ffffff;border-color:rgba(61,74,62,0.3);box-shadow:0 4px 16px rgba(61,74,62,0.12);';
} elseif ( 'purple' === $bg_color ) {
    // White card on sage: white border + shadow
    $card1_style = 'background-color:#ffffff;border-color:rgba(255,255,255,0.5);box-shadow:0 6px 24px rgba(0,0,0,0.15);';
    $card2_style = 'background-color:#ffffff;border-color:rgba(255,255,255,0.3);box-shadow:0 4px 16px rgba(0,0,0,0.10);';
} else {
    // Light backgrounds — subtle sage/taupe tints
    $card1_style = 'background-color:rgba(122,143,123,0.06);';
    $card2_style = 'background-color:rgba(183,175,163,0.06);';
}

$check = '<svg class="w-5 h-5 shrink-0" fill="none" stroke="' . esc_attr( $scheme['check_color'] ) . '" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
$arrow = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>';

// Sun icon for Glow tier
$icon_glow = '<svg class="w-5 h-5" style="color:#7A8F7B" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/></svg>';
// Shield-check icon for Vitality tier
$icon_vitality = '<svg class="w-5 h-5" style="color:#7A8F7B" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/></svg>';
// Leaf/star icon for VIP tier
$icon_vip = '<svg class="w-5 h-5" style="color:#B7AFA3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg>';
?>
<section id="memberships" class="py-24" style="background-color:<?php echo esc_attr( $scheme['section_bg'] ); ?>">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">

            <!-- ── Left: copy ───────────────────────────────────── -->
            <div class="reveal">
                <div class="inline-flex items-center gap-2 text-sm font-semibold uppercase tracking-widest mb-5"
                     style="color:<?php echo esc_attr( $scheme['label_color'] ); ?>">
                    <span class="w-8 h-px" style="background-color:<?php echo esc_attr( $scheme['line_color'] ); ?>"></span>
                    <?php echo esc_html( $section_label ); ?>
                </div>
                <h2 class="font-serif text-4xl lg:text-5xl font-bold leading-tight mb-5"
                    style="color:<?php echo esc_attr( $scheme['heading_color'] ); ?>">
                    <?php echo esc_html( $section_title ); ?>
                </h2>
                <?php if ( $section_body ) : ?>
                <p class="text-base leading-relaxed mb-6" style="color:<?php echo esc_attr( $scheme['body_color'] ); ?>">
                    <?php echo esc_html( $section_body ); ?>
                </p>
                <?php endif; ?>

                <?php if ( $perks ) : ?>
                <ul class="space-y-3 mb-8">
                    <?php foreach ( $perks as $perk ) : ?>
                    <li class="flex items-center gap-3 text-sm" style="color:<?php echo esc_attr( $scheme['perk_color'] ); ?>">
                        <?php echo $check; // phpcs:ignore ?>
                        <?php echo esc_html( $perk ); ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>

                <?php if ( $cta_label && $cta_url ) : ?>
                <a href="<?php echo esc_url( $cta_url ); ?>"
                   class="inline-flex items-center gap-2 px-8 py-4 font-semibold rounded-full transition-all shadow-lg hover:scale-105"
                   style="background-color:<?php echo esc_attr( $scheme['cta_bg'] ); ?>;color:<?php echo esc_attr( $scheme['cta_text'] ); ?>">
                    <?php echo esc_html( $cta_label ); ?>
                    <?php echo $arrow; // phpcs:ignore ?>
                </a>
                <?php endif; ?>
            </div>

            <!-- ── Right: image + tier cards ───────────────────── -->
            <div class="reveal space-y-4">

                <?php if ( $image_url ) : ?>
                <div class="rounded-2xl overflow-hidden shadow-md">
                    <img src="<?php echo esc_url( $image_url ); ?>"
                         alt="<?php echo esc_attr( $image_alt ); ?>"
                         class="w-full object-cover"
                         style="max-height:200px; object-position: center top;" />
                </div>
                <?php endif; ?>
                <!-- Tier 1 (featured) -->
                <div class="rounded-2xl border-2 p-6 relative cursor-pointer"
                     style="border-color:#7A8F7B;<?php echo esc_attr( $card1_style ); ?>">
                    <?php if ( $tier1_badge ) : ?>
                    <div class="absolute -top-3 right-6 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide"
                         style="background-color:#B7AFA3;">
                        <?php echo esc_html( $tier1_badge ); ?>
                    </div>
                    <?php endif; ?>
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <div class="font-semibold text-xs uppercase tracking-wider mb-1"
                                 style="color:#7A8F7B;">
                                <?php echo esc_html( $tier1_label ); ?>
                            </div>
                            <h3 class="font-serif text-xl font-semibold"
                                style="color:#3D4A3E;">
                                <?php echo esc_html( $tier1_name ); ?>
                            </h3>
                        </div>
                        <div class="w-10 h-10 rounded-full flex items-center justify-center"
                             style="background-color:rgba(122,143,123,0.12);">
                            <?php echo $icon_vitality; // phpcs:ignore ?>
                        </div>
                    </div>
                    <p class="text-sm" style="color:rgba(61,74,62,0.65);"><?php echo esc_html( $tier1_desc ); ?></p>
                </div>

                <!-- Tier 2 (VIP / taupe) -->
                <div class="rounded-2xl border-2 p-6 transition-colors group cursor-pointer"
                     style="border-color:rgba(183,175,163,0.5);<?php echo esc_attr( $card2_style ); ?>">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <div class="font-semibold text-xs uppercase tracking-wider mb-1"
                                 style="color:#B7AFA3;">
                                <?php echo esc_html( $tier2_label ); ?>
                            </div>
                            <h3 class="font-serif text-xl font-semibold"
                                style="color:#3D4A3E;">
                                <?php echo esc_html( $tier2_name ); ?>
                            </h3>
                        </div>
                        <div class="w-10 h-10 rounded-full flex items-center justify-center transition-colors"
                             style="background-color:rgba(183,175,163,0.15);">
                            <?php echo $icon_vip; // phpcs:ignore ?>
                        </div>
                    </div>
                    <p class="text-sm" style="color:rgba(61,74,62,0.65);"><?php echo esc_html( $tier2_desc ); ?></p>
                </div>

            </div>
        </div>
    </div>
</section>
