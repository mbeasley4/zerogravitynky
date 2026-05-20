<?php
/**
 * Dynamic render for zerogravitynky/checkout-trust block.
 * Used inline in the checkout sidebar and placeable on any page.
 */

defined( 'ABSPATH' ) || exit;

$headline = $attributes['headline'] ?? 'Safe &amp; Secure Checkout';
$phone    = $attributes['phone']    ?? '(859) 344-3250';
$phone_url = $attributes['phoneUrl'] ?? 'tel:8593443250';
$note     = $attributes['note']     ?? 'All treatments require a prior consultation. No refunds after purchase.';

$trust_points = [
    [
        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>',
        'label' => 'SSL Encrypted',
        'desc'  => 'Your data is protected by 256-bit SSL encryption.',
    ],
    [
        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
        'label' => 'Secure Payment',
        'desc'  => 'Processed safely through our trusted payment gateway.',
    ],
    [
        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>',
        'label' => 'Privacy Protected',
        'desc'  => 'We never sell or share your personal information.',
    ],
    [
        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>',
        'label' => 'Expert Care',
        'desc'  => 'Our nurse practitioners and RNs are here to help.',
    ],
];
?>

<div class="zg-checkout-trust rounded-2xl border border-black/8 bg-white shadow-sm overflow-hidden" <?php echo get_block_wrapper_attributes(); ?>>

    <!-- Header -->
    <div class="px-6 py-4 bg-brand-dark flex items-center gap-2.5">
        <svg class="w-4 h-4 text-brand-taupe flex-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
        </svg>
        <span class="text-sm font-semibold text-white"><?php echo wp_kses_post( $headline ); ?></span>
    </div>

    <!-- Trust points -->
    <div class="divide-y divide-black/6">
        <?php foreach ( $trust_points as $point ) : ?>
        <div class="flex items-start gap-3 px-5 py-3.5">
            <div class="flex-none w-8 h-8 rounded-lg bg-brand-sage/8 flex items-center justify-center mt-0.5">
                <svg class="w-4 h-4 text-brand-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <?php echo $point['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-brand-dark leading-snug"><?php echo esc_html( $point['label'] ); ?></p>
                <p class="text-xs text-brand-gray/60 leading-relaxed mt-0.5"><?php echo esc_html( $point['desc'] ); ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Contact -->
    <div class="px-5 py-4 border-t border-black/8 bg-brand-sand/30">
        <p class="text-xs text-brand-gray/60 mb-2">Need help with your order?</p>
        <a href="<?php echo esc_url( $phone_url ); ?>" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-dark hover:text-brand-sage transition-colors">
            <svg class="w-4 h-4 text-brand-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 7V5z"/>
            </svg>
            <?php echo esc_html( $phone ); ?>
        </a>
    </div>

    <!-- Fine print -->
    <?php if ( $note ) : ?>
    <div class="px-5 py-3 border-t border-black/6">
        <p class="text-xs text-brand-gray/45 leading-relaxed"><?php echo esc_html( $note ); ?></p>
    </div>
    <?php endif; ?>

</div>
