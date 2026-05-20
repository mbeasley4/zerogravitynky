<?php
/**
 * Dynamic render for zerogravitynky/zg-policy-notice block.
 */
defined( 'ABSPATH' ) || exit;

$section_label = $attributes['sectionLabel'] ?? 'Important Updates';
$section_title = $attributes['sectionTitle'] ?? 'Our Policies';

$card1_title = $attributes['card1Title'] ?? 'Cancellation Policy';
$card1_raw   = $attributes['card1Items'] ?? '';

$card2_title = $attributes['card2Title'] ?? 'Consultation Policy';
$card2_raw   = $attributes['card2Items'] ?? '';

$card1_items = array_filter( array_map( 'trim', explode( "\n", $card1_raw ) ) );
$card2_items = array_filter( array_map( 'trim', explode( "\n", $card2_raw ) ) );

/**
 * Highlight dollar amounts (e.g. $25, $100) in a line of policy text.
 * Wraps matched amounts in a bold, brand-sage span.
 */
function zg_highlight_amounts( string $text ): string {
    return preg_replace(
        '/(\$\d+(?:\.\d{2})?)\b/',
        '<strong class="text-brand-sage font-semibold">$1</strong>',
        esc_html( $text )
    );
}

// Clock icon — cancellation card header
$icon_clock = '<svg class="w-5 h-5 text-brand-taupe flex-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';

// Info-circle icon — consultation card header
$icon_info = '<svg class="w-5 h-5 text-brand-taupe flex-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>';

// Bullet dash icon
$bullet = '<svg class="w-4 h-4 flex-none mt-0.5 text-brand-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
?>
<section class="py-20 bg-brand-sand">
    <div class="max-w-5xl mx-auto px-5 lg:px-8">

        <!-- ── Section header ──────────────────────────────────────── -->
        <div class="text-center mb-12 reveal">
            <div class="inline-flex items-center gap-2 text-brand-sage text-sm font-semibold uppercase tracking-widest mb-4">
                <span class="w-8 h-px bg-brand-sage"></span>
                <?php echo esc_html( $section_label ); ?>
                <span class="w-8 h-px bg-brand-sage"></span>
            </div>
            <h2 class="font-serif text-4xl lg:text-5xl text-brand-dark font-bold">
                <?php echo esc_html( $section_title ); ?>
            </h2>
        </div>

        <!-- ── Policy cards ───────────────────────────────────────── -->
        <div class="grid md:grid-cols-2 gap-6 reveal">

            <!-- Card 1: Cancellation -->
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="bg-brand-dark px-6 py-4 flex items-center gap-3">
                    <?php echo $icon_clock; // phpcs:ignore ?>
                    <h3 class="text-white font-semibold text-base m-0">
                        <?php echo esc_html( $card1_title ); ?>
                    </h3>
                </div>
                <ul class="px-6 py-5 space-y-4 list-none m-0">
                    <?php foreach ( $card1_items as $item ) : ?>
                    <li class="flex items-start gap-3 text-sm text-brand-gray leading-relaxed">
                        <?php echo $bullet; // phpcs:ignore ?>
                        <span><?php echo zg_highlight_amounts( $item ); // phpcs:ignore ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Card 2: Consultation -->
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="bg-brand-sage px-6 py-4 flex items-center gap-3">
                    <?php echo $icon_info; // phpcs:ignore ?>
                    <h3 class="text-white font-semibold text-base m-0">
                        <?php echo esc_html( $card2_title ); ?>
                    </h3>
                </div>
                <ul class="px-6 py-5 space-y-4 list-none m-0">
                    <?php foreach ( $card2_items as $item ) : ?>
                    <li class="flex items-start gap-3 text-sm text-brand-gray leading-relaxed">
                        <?php echo $bullet; // phpcs:ignore ?>
                        <span><?php echo zg_highlight_amounts( $item ); // phpcs:ignore ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

        </div>
    </div>
</section>
