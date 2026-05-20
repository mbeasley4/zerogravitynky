<?php
/**
 * Cart totals — Zero Gravity theme override.
 * Overrides woocommerce/templates/cart/cart-totals.php
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @version 2.3.6
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="cart_totals <?php echo WC()->customer->has_calculated_shipping() ? 'calculated_shipping' : ''; ?> rounded-2xl border border-black/8 bg-white shadow-sm overflow-hidden">

    <?php do_action( 'woocommerce_before_cart_totals' ); ?>

    <!-- Header -->
    <div class="px-6 py-5 border-b border-black/8 bg-brand-sand/40">
        <h2 class="font-serif text-xl font-semibold text-brand-dark"><?php esc_html_e( 'Order Summary', 'woocommerce' ); ?></h2>
    </div>

    <!-- Totals rows -->
    <div class="px-6 py-5 space-y-3">

        <!-- Subtotal -->
        <div class="cart-subtotal flex items-center justify-between text-sm">
            <span class="text-brand-gray/70 font-medium"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></span>
            <span class="font-semibold text-brand-dark"><?php wc_cart_totals_subtotal_html(); ?></span>
        </div>

        <!-- Coupons -->
        <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
        <div class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?> flex items-center justify-between text-sm">
            <span class="text-brand-gray/70 font-medium"><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
            <span class="font-semibold text-brand-taupe"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
        </div>
        <?php endforeach; ?>

        <!-- Shipping -->
        <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
        <?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>
        <?php wc_cart_totals_shipping_html(); ?>
        <?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>
        <?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>
        <div class="shipping flex items-start justify-between text-sm">
            <span class="text-brand-gray/70 font-medium"><?php esc_html_e( 'Shipping', 'woocommerce' ); ?></span>
            <span class="text-right"><?php woocommerce_shipping_calculator(); ?></span>
        </div>
        <?php endif; ?>

        <!-- Fees -->
        <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
        <div class="fee flex items-center justify-between text-sm">
            <span class="text-brand-gray/70 font-medium"><?php echo esc_html( $fee->name ); ?></span>
            <span class="font-semibold text-brand-dark"><?php wc_cart_totals_fee_html( $fee ); ?></span>
        </div>
        <?php endforeach; ?>

        <!-- Tax -->
        <?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) :
            $taxable_address = WC()->customer->get_taxable_address();
            $estimated_text  = '';

            if ( WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ) {
                $estimated_text = sprintf(
                    ' <small>' . esc_html__( '(estimated for %s)', 'woocommerce' ) . '</small>',
                    WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ]
                );
            }

            if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) :
                $tax_totals  = WC()->cart->get_tax_totals();
                $tax_labels  = array_column( (array) $tax_totals, 'label' );
                $has_dupes   = count( $tax_labels ) !== count( array_unique( $tax_labels ) );
                // Friendly names for up to 4 duplicate-label tax lines (most common: state + local).
                $dupe_names  = [ __( 'State Tax', 'zerogravitynky' ), __( 'Local Tax', 'zerogravitynky' ), __( 'County Tax', 'zerogravitynky' ), __( 'City Tax', 'zerogravitynky' ) ];
                $seen_labels = [];

                foreach ( $tax_totals as $code => $tax ) :
                    $label = $tax->label;
                    if ( $has_dupes ) {
                        $idx           = $seen_labels[ $label ] ?? 0;
                        $label         = $dupe_names[ $idx ] ?? $tax->label . ' ' . ( $idx + 1 );
                        $seen_labels[ $tax->label ] = $idx + 1;
                    }
                    ?>
                <div class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?> flex items-center justify-between text-sm">
                    <span class="text-brand-gray/70 font-medium"><?php echo esc_html( $label ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                    <span class="font-semibold text-brand-dark"><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
                </div>
                <?php endforeach;

                if ( count( $tax_totals ) > 1 ) : ?>
                <div class="tax-total flex items-center justify-between text-sm border-t border-dashed border-black/8 pt-2 mt-1">
                    <span class="text-brand-gray/70 font-semibold"><?php esc_html_e( 'Total Tax', 'zerogravitynky' ); ?><?php echo $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                    <span class="font-bold text-brand-dark"><?php wc_cart_totals_taxes_total_html(); ?></span>
                </div>
                <?php endif;

            else : ?>
                <div class="tax-total flex items-center justify-between text-sm">
                    <span class="text-brand-gray/70 font-medium"><?php echo esc_html( WC()->countries->tax_or_vat() ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                    <span class="font-semibold text-brand-dark"><?php wc_cart_totals_taxes_total_html(); ?></span>
                </div>
            <?php endif;
        endif; ?>

        <?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

    </div>

    <!-- Order total -->
    <div class="order-total px-6 py-5 border-t border-black/8 flex items-center justify-between">
        <span class="font-semibold text-brand-dark"><?php esc_html_e( 'Total', 'woocommerce' ); ?></span>
        <span class="font-bold text-xl text-brand-sage"><?php wc_cart_totals_order_total_html(); ?></span>
    </div>

    <?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

    <!-- Proceed to checkout -->
    <div class="wc-proceed-to-checkout px-6 pb-6">
        <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="checkout-button flex items-center justify-center gap-2 px-3 py-2 bg-brand-taupe text-white text-sm font-semibold rounded-full hover:bg-yellow-600 transition-all">
            <?php esc_html_e( 'Proceed to checkout', 'woocommerce' ); ?>
        </a>
    </div>

    <?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>
