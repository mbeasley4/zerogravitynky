<?php
/**
 * Checkout Form — Zero Gravity theme override.
 * Overrides woocommerce/templates/checkout/form-checkout.php
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @version 9.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<!-- ═══════════════════════════════════════════
     CHECKOUT FORM
═══════════════════════════════════════════ -->
<section class="bg-white">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">
        <?php 
        if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
            echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
            return;
        }
        ?>
        <?php do_action( 'woocommerce_before_checkout_form', $checkout ); ?>

        <form name="checkout" method="post"
              class="checkout woocommerce-checkout lg:flex lg:flex-wrap lg:gap-12 lg:items-start"
              action="<?php echo esc_url( wc_get_checkout_url() ); ?>"
              enctype="multipart/form-data"
              aria-label="<?php echo esc_attr__( 'Checkout', 'woocommerce' ); ?>">

            <!-- ── Left: Customer Details ────────────────── -->
            <?php if ( $checkout->get_checkout_fields() ) : ?>
            <div class="flex-1 min-w-0" id="customer_details">

                <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

                <!-- Billing -->
                <div class="zg-checkout-section mb-8">
                    <h2 class="zg-checkout-section-title">
                        <svg class="w-5 h-5 text-brand-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Billing Details
                    </h2>
                    <?php do_action( 'woocommerce_checkout_billing' ); ?>
                </div>

                <!-- Shipping (only if needed) -->
                <?php if ( WC()->cart && WC()->cart->needs_shipping_address() ) : ?>
                <div class="zg-checkout-section mb-8">
                    <h2 class="zg-checkout-section-title">
                        <svg class="w-5 h-5 text-brand-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Shipping Address
                    </h2>
                    <?php do_action( 'woocommerce_checkout_shipping' ); ?>
                </div>
                <?php else : ?>
                    <?php do_action( 'woocommerce_checkout_shipping' ); ?>
                <?php endif; ?>

                <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

            </div>
            <?php endif; ?>

            <!-- ── Right: Order Summary + Payment ───────── -->
            <div class="w-full lg:w-80 xl:w-96 flex-none mt-10 lg:mt-0">

                <?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

                <div class="rounded-2xl border border-black/8 bg-white shadow-sm overflow-hidden mb-5">

                    <!-- Order summary header -->
                    <div class="px-6 py-5 border-b border-black/8 bg-brand-sand/40 flex items-center justify-between">
                        <h3 class="font-serif text-xl font-semibold text-brand-dark" id="order_review_heading">
                            <?php esc_html_e( 'Your Order', 'woocommerce' ); ?>
                        </h3>
                        <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="text-xs text-brand-sage/70 hover:text-brand-sage transition-colors font-medium">
                            Edit cart
                        </a>
                    </div>

                    <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

                    <div id="order_review" class="woocommerce-checkout-review-order">
                        <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                    </div>

                    <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

                </div>

                <!-- Back to cart link -->
                <div class="text-center mt-4">
                    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="inline-flex items-center gap-1.5 text-xs text-brand-gray/50 hover:text-brand-sage transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Return to cart
                    </a>
                </div>

            </div>

        </form>

    </div>
</section>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
