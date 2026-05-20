<?php
/**
 * Empty cart page — Zero Gravity theme override.
 * Overrides woocommerce/templates/cart/cart-empty.php
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;
?>

<!-- ═══════════════════════════════════════════
     HERO
═══════════════════════════════════════════ -->
<section class="page-hero-section page-hero-short relative pb-10 text-white overflow-hidden bg-hero-gradient">
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-brand-taupe/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-16 -left-24 w-125 h-125 bg-brand-light/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: radial-gradient(circle, rgba(255,255,255,0.4) 1px, transparent 1px); background-size: 36px 36px;"></div>

    <div class="relative max-w-7xl mx-auto px-5 lg:px-8 text-center">
        <p class="uppercase tracking-widest text-brand-taupe-light text-xs font-semibold mb-4">
            Zero Gravity Aesthetics &amp; Wellness
        </p>
        <h1 class="font-serif text-5xl md:text-6xl leading-tight mb-4 text-white">
            Your <span class="shimmer-text">Cart</span>
        </h1>
        <p class="text-white/70 text-lg max-w-md mx-auto">
            Review your selections and complete your booking below.
        </p>
    </div>
</section>

<!-- ═══════════════════════════════════════════
     EMPTY STATE
═══════════════════════════════════════════ -->
<section class="py-24 bg-white">
    <div class="max-w-lg mx-auto px-5 text-center">

        <?php do_action( 'woocommerce_cart_is_empty' ); ?>

        <!-- Icon -->
        <div class="mx-auto mb-8 w-24 h-24 rounded-full bg-brand-sand flex items-center justify-center">
            <svg class="w-10 h-10 text-brand-sage/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 11H4L5 9z"/>
            </svg>
        </div>

        <h2 class="font-serif text-3xl font-semibold text-brand-dark mb-3">Your cart is empty</h2>
        <p class="text-brand-gray/60 text-base mb-10 leading-relaxed">
            Looks like you haven't added any treatments yet.<br>Browse our services and find something you'll love.
        </p>

        <?php if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
        <a class="return-to-shop inline-flex items-center gap-2 px-8 py-4 rounded-full font-semibold text-white shadow-lg hover:scale-105 transition-transform duration-200"
           style="background: linear-gradient(135deg, #7A8F7B 0%, #94A995 100%);"
           href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <?php echo esc_html( apply_filters( 'woocommerce_return_to_shop_text', __( 'Browse Services', 'woocommerce' ) ) ); ?>
        </a>
        <?php endif; ?>

    </div>
</section>
