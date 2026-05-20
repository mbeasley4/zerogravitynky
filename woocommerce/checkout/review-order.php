<?php
/**
 * Review order — Zero Gravity theme override.
 * Overrides woocommerce/templates/checkout/review-order.php
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;
?>

<!-- Cart items -->
<div class="divide-y divide-black/6">
    <?php
    do_action( 'woocommerce_review_order_before_cart_contents' );

    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
        $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

        if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] <= 0 || ! apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
            continue;
        }
    ?>
    <div class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?> flex items-center gap-3 px-6 py-4">

        <!-- Thumbnail -->
        <div class="w-12 h-12 flex-none rounded-lg overflow-hidden bg-brand-sand">
            <?php echo $_product->get_image( 'thumbnail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        </div>

        <!-- Name + qty -->
        <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-brand-dark leading-snug truncate">
                <?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ); ?>
            </p>
            <p class="text-xs text-brand-gray/50 mt-0.5">
                <?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', sprintf( 'Qty: %s', $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </p>
            <?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        </div>

        <!-- Subtotal -->
        <div class="flex-none text-sm font-semibold text-brand-sage">
            <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        </div>

    </div>
    <?php endforeach;

    do_action( 'woocommerce_review_order_after_cart_contents' );
    ?>
</div>

<!-- Totals -->
<div class="px-6 py-5 space-y-2.5 border-t border-black/8">

    <div class="cart-subtotal flex items-center justify-between text-sm">
        <span class="text-brand-gray/70"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></span>
        <span class="font-semibold text-brand-dark"><?php wc_cart_totals_subtotal_html(); ?></span>
    </div>

    <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
    <div class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?> flex items-center justify-between text-sm">
        <span class="text-brand-gray/70"><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
        <span class="font-semibold text-brand-taupe"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
    </div>
    <?php endforeach; ?>

    <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
    <?php do_action( 'woocommerce_review_order_before_shipping' ); ?>
    <?php wc_cart_totals_shipping_html(); ?>
    <?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
    <?php endif; ?>

    <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
    <div class="fee flex items-center justify-between text-sm">
        <span class="text-brand-gray/70"><?php echo esc_html( $fee->name ); ?></span>
        <span class="font-semibold text-brand-dark"><?php wc_cart_totals_fee_html( $fee ); ?></span>
    </div>
    <?php endforeach; ?>

    <?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) :
        if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) :
            $tax_totals  = WC()->cart->get_tax_totals();
            $tax_labels  = array_column( (array) $tax_totals, 'label' );
            $has_dupes   = count( $tax_labels ) !== count( array_unique( $tax_labels ) );
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
                <span class="text-brand-gray/70"><?php echo esc_html( $label ); ?></span>
                <span class="font-semibold text-brand-dark"><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
            </div>
            <?php endforeach;

            if ( count( $tax_totals ) > 1 ) : ?>
            <div class="tax-total flex items-center justify-between text-sm border-t border-dashed border-black/8 pt-2 mt-1">
                <span class="text-brand-gray/70 font-semibold"><?php esc_html_e( 'Total Tax', 'zerogravitynky' ); ?></span>
                <span class="font-bold text-brand-dark"><?php wc_cart_totals_taxes_total_html(); ?></span>
            </div>
            <?php endif;
        else : ?>
            <div class="tax-total flex items-center justify-between text-sm">
                <span class="text-brand-gray/70"><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></span>
                <span class="font-semibold text-brand-dark"><?php wc_cart_totals_taxes_total_html(); ?></span>
            </div>
        <?php endif;
    endif; ?>

    <?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

</div>

<!-- Order total -->
<div class="order-total px-6 py-5 border-t border-black/8 flex items-center justify-between">
    <span class="font-semibold text-brand-dark"><?php esc_html_e( 'Total', 'woocommerce' ); ?></span>
    <span class="font-bold text-xl text-brand-sage"><?php wc_cart_totals_order_total_html(); ?></span>
</div>

<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
