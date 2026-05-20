<?php
/**
 * Cart Page — Zero Gravity theme override.
 * Overrides woocommerce/templates/cart/cart.php
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @version 10.1.0
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
     CART CONTENT
═══════════════════════════════════════════ -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">
        <?php do_action( 'woocommerce_before_cart' ); ?>
        <div class="lg:flex lg:gap-12 lg:items-start">

            <!-- ── Cart Items ─────────────────────────────── -->
            <div class="flex-1 min-w-0">

                <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
                    <?php do_action( 'woocommerce_before_cart_table' ); ?>

                    <div class="space-y-3">
                        <?php do_action( 'woocommerce_before_cart_contents' ); ?>

                        <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
                            $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                            $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
                            $product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );

                            if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] <= 0 || ! apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                                continue;
                            }

                            $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                            $thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'thumbnail' ), $cart_item, $cart_item_key );
                        ?>

                        <div class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?> flex gap-4 p-4 rounded-2xl border border-black/8 bg-white shadow-sm hover:shadow-md transition-shadow">

                            <!-- Thumbnail -->
                            <div class="zg-cart-thumb w-24 h-24 flex-none rounded-xl overflow-hidden bg-brand-sand">
                                <?php if ( $product_permalink ) : ?>
                                <a href="<?php echo esc_url( $product_permalink ); ?>" class="block w-full h-full">
                                    <?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                </a>
                                <?php else : ?>
                                <?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                <?php endif; ?>
                            </div>

                            <!-- Details -->
                            <div class="flex-1 min-w-0 flex flex-col gap-2">

                                <div class="flex items-start justify-between gap-2">
                                    <div class="min-w-0">
                                        <h3 class="font-semibold text-brand-dark text-sm leading-snug">
                                            <?php if ( $product_permalink ) : ?>
                                            <a href="<?php echo esc_url( $product_permalink ); ?>" class="hover:text-brand-sage transition-colors">
                                                <?php echo esc_html( $_product->get_name() ); ?>
                                            </a>
                                            <?php else : ?>
                                            <?php echo wp_kses_post( $product_name ); ?>
                                            <?php endif; ?>
                                        </h3>
                                        <?php
                                        // Gift card — check parent product type (cart item may be a variation).
                                        $_is_gift_card = defined( 'PWGC_PRODUCT_TYPE_SLUG' ) && ( function_exists( 'wc_get_product' ) && ( $_check_product = wc_get_product( $cart_item['product_id'] ) ) && is_a( $_check_product, 'WC_Product_PW_Gift_Card' ) );

                                        if ( $_is_gift_card ) :
                                            $gc_item_data = apply_filters( 'woocommerce_get_item_data', [], $cart_item );
                                            // Normalise: WC copies 'value' → 'display'; support both.
                                            if ( ! empty( $gc_item_data ) ) :
                                        ?>
                                        <div class="zg-gift-card-meta mt-2.5 rounded-xl overflow-hidden" style="border: 1px solid rgba(122,143,123,0.22);">
                                            <!-- Header -->
                                            <div class="flex items-center gap-2 px-3 py-2" style="background: linear-gradient(135deg, #7A8F7B 0%, #94A995 100%);">
                                                <svg class="w-3.5 h-3.5 flex-none text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 12v10H4V12M22 7H2v5h20V7zM12 22V7M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7zM12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/>
                                                </svg>
                                                <span class="text-xs font-semibold uppercase tracking-wider text-white/90">Gift Card Details</span>
                                            </div>
                                            <!-- Fields -->
                                            <div class="px-3 py-2.5" style="background: linear-gradient(135deg, rgba(122,143,123,0.06) 0%, rgba(148,169,149,0.10) 100%);">
                                                <dl class="grid grid-cols-[auto_1fr] gap-x-3 gap-y-1.5 m-0">
                                                    <?php foreach ( $gc_item_data as $gc_field ) :
                                                        if ( ! empty( $gc_field['hidden'] ) ) continue;
                                                        $gc_val = ! empty( $gc_field['display'] ) ? $gc_field['display'] : ( $gc_field['value'] ?? '' );
                                                    ?>
                                                    <dt class="text-[11px] font-semibold whitespace-nowrap leading-5 m-0" style="color:#7A8F7B;"><?php echo esc_html( $gc_field['key'] ); ?></dt>
                                                    <dd class="text-[11px] text-brand-dark leading-5 m-0"><?php echo wp_kses_post( $gc_val ); ?></dd>
                                                    <?php endforeach; ?>
                                                </dl>
                                            </div>
                                        </div>
                                        <?php
                                            endif;
                                        else :
                                            echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                        endif;
                                        ?>
                                        <?php if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) : ?>
                                        <p class="text-xs text-brand-taupe mt-1"><?php esc_html_e( 'Available on backorder', 'woocommerce' ); ?></p>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Remove -->
                                    <div class="flex-none product-remove">
                                        <?php
                                        echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                            'woocommerce_cart_item_remove_link',
                                            sprintf(
                                                '<a role="button" href="%s" class="remove zg-cart-remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                                                esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                                esc_attr( sprintf( __( 'Remove %s from cart', 'woocommerce' ), wp_strip_all_tags( $product_name ) ) ),
                                                esc_attr( $product_id ),
                                                esc_attr( $_product->get_sku() )
                                            ),
                                            $cart_item_key
                                        );
                                        ?>
                                    </div>
                                </div>

                                <!-- Price + Qty + Subtotal -->
                                <div class="flex items-center justify-between gap-3 mt-auto flex-wrap">

                                    <div class="flex items-center gap-3">
                                        <!-- Unit price -->
                                        <span class="product-price text-xs text-brand-gray/60">
                                            <?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                        </span>

                                        <!-- Quantity -->
                                        <div class="product-quantity">
                                            <?php
                                            if ( $_product->is_sold_individually() ) {
                                                $min_qty = $max_qty = 1;
                                            } else {
                                                $min_qty = 0;
                                                $max_qty = $_product->get_max_purchase_quantity();
                                            }

                                            echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                                'woocommerce_cart_item_quantity',
                                                woocommerce_quantity_input(
                                                    [
                                                        'input_name'   => "cart[{$cart_item_key}][qty]",
                                                        'input_value'  => $cart_item['quantity'],
                                                        'max_value'    => $max_qty,
                                                        'min_value'    => $min_qty,
                                                        'product_name' => $product_name,
                                                    ],
                                                    $_product,
                                                    false
                                                ),
                                                $cart_item_key,
                                                $cart_item
                                            );
                                            ?>
                                        </div>
                                    </div>

                                    <!-- Subtotal -->
                                    <div class="product-subtotal font-semibold text-brand-sage text-sm">
                                        <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <?php endforeach; ?>

                        <?php do_action( 'woocommerce_cart_contents' ); ?>
                    </div>

                    <!-- Actions bar -->
                    <div class="mt-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 pt-5 border-t border-black/8">

                        <?php if ( wc_coupons_enabled() ) : ?>
                        <div class="coupon flex gap-2 flex-1 max-w-xs">
                            <label for="coupon_code" class="sr-only"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label>
                            <input type="text" name="coupon_code" class="input-text flex-1 px-4 py-2 rounded-full border border-black/15 text-sm text-brand-dark bg-white focus:outline-none focus:border-brand-sage focus:ring-2 focus:ring-brand-sage/15 transition" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" />
                            <button type="submit" class="button flex-none px-5 py-2 rounded-full bg-brand-sand text-brand-dark text-sm font-semibold hover:bg-brand-sage/10 transition-colors whitespace-nowrap" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>">
                                <?php esc_html_e( 'Apply', 'woocommerce' ); ?>
                            </button>
                            <?php do_action( 'woocommerce_cart_coupon' ); ?>
                        </div>
                        <?php endif; ?>

                        <div class="flex gap-3 items-center">
                            <?php do_action( 'woocommerce_cart_actions' ); ?>
                            <button type="submit" class="button px-5 py-2 rounded-full border border-black/15 text-brand-gray text-sm font-medium hover:border-brand-sage/50 hover:text-brand-sage transition-all" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>">
                                <?php esc_html_e( 'Update cart', 'woocommerce' ); ?>
                            </button>
                        </div>

                        <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                    </div>

                    <?php do_action( 'woocommerce_after_cart_contents' ); ?>
                    <?php do_action( 'woocommerce_after_cart_table' ); ?>
                </form>

                <!-- Continue shopping -->
                <div class="mt-5">
                    <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="inline-flex items-center gap-2 text-sm text-brand-gray/60 hover:text-brand-sage transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Continue shopping
                    </a>
                </div>

            </div>

            <!-- ── Order Summary Sidebar ──────────────────── -->
            <?php do_action( 'woocommerce_before_cart_collaterals' ); ?>
            <div class="w-full lg:w-80 xl:w-96 flex-none mt-10 lg:mt-0">
                <?php woocommerce_cart_totals(); ?>
            </div>

        </div>
    </div>
</section>

<?php do_action( 'woocommerce_after_cart' ); ?>
