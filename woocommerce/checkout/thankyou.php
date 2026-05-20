<?php
/**
 * Thankyou page — Zero Gravity theme override.
 * Overrides woocommerce/templates/checkout/thankyou.php
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;

$failed = $order && $order->has_status( 'failed' );
?>

<!-- ═══════════════════════════════════════════
     HERO
═══════════════════════════════════════════ -->
<section class="page-hero-section page-hero-short relative pb-10 text-white overflow-hidden <?php echo $failed ? 'bg-red-900' : 'bg-hero-gradient'; ?>">
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-brand-taupe/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-16 -left-24 w-125 h-125 bg-brand-light/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: radial-gradient(circle, rgba(255,255,255,0.4) 1px, transparent 1px); background-size: 36px 36px;"></div>

    <div class="relative max-w-7xl mx-auto px-5 lg:px-8 text-center">
        <?php if ( $failed ) : ?>
        <div class="mx-auto mb-5 w-16 h-16 rounded-full bg-white/10 flex items-center justify-center">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </div>
        <h1 class="font-serif text-5xl md:text-6xl leading-tight mb-4">Payment <span class="opacity-80">Failed</span></h1>
        <p class="text-white/70 text-lg max-w-md mx-auto">Your payment could not be processed. Please try again.</p>
        <?php else : ?>
        <div class="mx-auto mb-5 w-16 h-16 rounded-full bg-white/15 flex items-center justify-center">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <p class="uppercase tracking-widest text-brand-taupe-light text-xs font-semibold mb-4">
            Zero Gravity Aesthetics &amp; Wellness
        </p>
        <h1 class="font-serif text-5xl md:text-6xl leading-tight mb-4">
            Thank <span class="shimmer-text">You!</span>
        </h1>
        <p class="text-white/70 text-lg max-w-md mx-auto">
            Your order has been received. We'll be in touch soon to confirm your booking.
        </p>
        <?php endif; ?>
    </div>
</section>

<!-- ═══════════════════════════════════════════
     ORDER DETAILS
═══════════════════════════════════════════ -->
<section class="py-16 bg-white">
    <div class="max-w-3xl mx-auto px-5 lg:px-8">

        <div class="woocommerce-order">

            <?php if ( $order ) :
                do_action( 'woocommerce_before_thankyou', $order->get_id() );

                if ( $failed ) : ?>

                <div class="bg-red-50 border border-red-200 rounded-2xl p-6 mb-6 text-center">
                    <p class="text-red-700 font-medium mb-4"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>
                    <div class="flex flex-col sm:flex-row justify-center gap-3">
                        <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>"
                           class="inline-flex items-center justify-center px-6 py-3 rounded-full bg-brand-sage text-white font-semibold text-sm hover:bg-brand-mid transition-colors">
                            Try Again
                        </a>
                        <?php if ( is_user_logged_in() ) : ?>
                        <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"
                           class="inline-flex items-center justify-center px-6 py-3 rounded-full border border-black/15 text-brand-gray font-semibold text-sm hover:border-brand-sage/50 hover:text-brand-sage transition-all">
                            My Account
                        </a>
                        <?php endif; ?>
                    </div>
                </div>

                <?php else : ?>

                <!-- Success notice -->
                <div class="bg-brand-sage/5 border border-brand-sage/15 rounded-2xl p-5 mb-8 text-center">
                    <p class="text-brand-dark font-medium text-sm">
                        <?php
                        echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            'woocommerce_thankyou_order_received_text',
                            esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ),
                            $order
                        );
                        ?>
                    </p>
                </div>

                <!-- Order meta grid -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-10">

                    <div class="woocommerce-order-overview__order rounded-xl border border-black/8 bg-white p-4 text-center shadow-sm">
                        <p class="text-xs uppercase tracking-widest text-brand-gray/50 mb-1"><?php esc_html_e( 'Order', 'woocommerce' ); ?></p>
                        <p class="font-bold text-brand-dark text-sm">#<?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
                    </div>

                    <div class="woocommerce-order-overview__date rounded-xl border border-black/8 bg-white p-4 text-center shadow-sm">
                        <p class="text-xs uppercase tracking-widest text-brand-gray/50 mb-1"><?php esc_html_e( 'Date', 'woocommerce' ); ?></p>
                        <p class="font-bold text-brand-dark text-sm"><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
                    </div>

                    <div class="woocommerce-order-overview__total rounded-xl border border-black/8 bg-brand-sage/5 p-4 text-center shadow-sm">
                        <p class="text-xs uppercase tracking-widest text-brand-gray/50 mb-1"><?php esc_html_e( 'Total', 'woocommerce' ); ?></p>
                        <p class="font-bold text-brand-sage text-sm"><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
                    </div>

                    <?php if ( $order->get_payment_method_title() ) : ?>
                    <div class="woocommerce-order-overview__payment-method rounded-xl border border-black/8 bg-white p-4 text-center shadow-sm">
                        <p class="text-xs uppercase tracking-widest text-brand-gray/50 mb-1"><?php esc_html_e( 'Payment', 'woocommerce' ); ?></p>
                        <p class="font-bold text-brand-dark text-sm"><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></p>
                    </div>
                    <?php endif; ?>

                    <?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
                    <div class="woocommerce-order-overview__email col-span-2 sm:col-span-4 rounded-xl border border-black/8 bg-white p-4 text-center shadow-sm">
                        <p class="text-xs uppercase tracking-widest text-brand-gray/50 mb-1"><?php esc_html_e( 'Confirmation sent to', 'woocommerce' ); ?></p>
                        <p class="font-bold text-brand-dark text-sm"><?php echo esc_html( $order->get_billing_email() ); ?></p>
                    </div>
                    <?php endif; ?>

                </div>

                <?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
                <?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

                <?php endif; ?>

            <?php else : ?>

                <!-- No order (direct page visit) -->
                <div class="text-center py-12">
                    <p class="text-brand-gray/60 mb-6"><?php esc_html_e( 'Thank you. Your order has been received.', 'woocommerce' ); ?></p>
                    <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
                       class="inline-flex items-center gap-2 px-8 py-4 rounded-full font-semibold text-white shadow-lg hover:scale-105 transition-transform"
                       style="background: linear-gradient(135deg, #7A8F7B 0%, #94A995 100%);">
                        Continue Shopping
                    </a>
                </div>

            <?php endif; ?>

            <!-- CTA back to shop -->
            <?php if ( $order && ! $failed ) : ?>
            <div class="mt-10 pt-8 border-t border-black/8 text-center">
                <p class="text-brand-gray/60 text-sm mb-5">Ready to explore more treatments?</p>
                <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
                   class="inline-flex items-center gap-2 px-8 py-4 rounded-full font-semibold text-white shadow-lg hover:scale-105 transition-transform duration-200"
                   style="background: linear-gradient(135deg, #7A8F7B 0%, #94A995 100%);">
                    Browse More Services
                </a>
            </div>
            <?php endif; ?>

        </div>
    </div>
</section>
