<?php
/**
 * Product card for loop/archive pages.
 * Overrides woocommerce/templates/content-product.php
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}

$title        = get_the_title();
$price_html   = $product->get_price_html();
$short_desc   = $product->get_short_description();
$on_sale      = $product->is_on_sale();
$thumbnail_id = $product->get_image_id();
$img_url      = $thumbnail_id
    ? wp_get_attachment_image_url( $thumbnail_id, 'woocommerce_thumbnail' )
    : wc_placeholder_img_src( 'woocommerce_thumbnail' );
$img_alt      = $thumbnail_id
    ? trim( wp_strip_all_tags( get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true ) ) )
    : $title;

$can_add_to_cart    = $product->is_purchasable() && $product->is_in_stock() && $product->is_type( 'simple' );
$requires_facial    = has_term( 'waxing', 'product_cat', $product->get_id() )
                      && ! in_array( $product->get_slug(), [ 'full-face-wax' ], true )
                      && is_tax( 'product_cat' );
?>
<li <?php wc_product_class( 'service-card group relative overflow-hidden rounded-2xl bg-brand-sand border border-transparent hover:border-brand-sage/20 flex flex-col cursor-pointer', $product ); ?>>

    <!-- Thumbnail -->
    <div class="relative h-72 overflow-hidden flex-none">
        <img src="<?php echo esc_url( $img_url ); ?>"
             alt="<?php echo esc_attr( $img_alt ); ?>"
             class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500"
             loading="lazy" />
        <div class="absolute inset-0 bg-brand-sage/20 group-hover:bg-brand-sage/10 transition-colors"></div>

        <?php if ( $on_sale ) : ?>
        <span class="absolute top-3 left-3 px-2.5 py-1 bg-brand-taupe text-white text-xs font-bold rounded-full">
            Sale
        </span>
        <?php endif; ?>
    </div>

    <!-- Body -->
    <div class="p-7 flex flex-col flex-1">
         <?php if ( $requires_facial ) : ?>
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold mb-3" style="background: rgba(183,175,163,0.15); border: 1px solid rgba(183,175,163,0.40); color: #5a5248;">
            <svg class="w-3 h-3 flex-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Only with facial service purchase
        </div>
        <?php endif; ?>
        <h3 class="font-serif text-2xl font-semibold text-brand-dark mb-3 leading-snug">
            <?php echo esc_html( $title ); ?>
        </h3>

        <?php if ( $price_html ) : ?>
        <div class="text-brand-sage font-semibold text-base mb-3">
            <?php echo $price_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        </div>
        <?php endif; ?>
        <?php /*
        <?php if ( $short_desc ) : ?>
        <p class="text-brand-gray/70 text-sm leading-relaxed mb-5 line-clamp-2 flex-1">
            <?php echo wp_kses_post( $short_desc ); ?>
        </p>

        <?php else : ?>
        <div class="flex-1"></div>
        <?php endif; ?>
        */ ?>
       

        <div class="flex-1"></div>

        <!-- CTA -->
        <div class="mt-auto pt-4 border-t border-brand-sage/10">
            <?php if ( $can_add_to_cart ) : ?>
            <a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"
               data-quantity="1"
               data-product_id="<?php echo absint( $product->get_id() ); ?>"
               data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>"
               class="add_to_cart_button ajax_add_to_cart w-full flex items-center justify-center gap-2 px-5 py-2.5 bg-brand-taupe text-white text-sm font-semibold rounded-full hover:bg-yellow-600 transition-all">
                <svg class="w-4 h-4 flex-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 11H4L5 9z"/>
                </svg>
                Add to Bag
            </a>
            <?php elseif ( $product->is_type( 'variable' ) ) : ?>
            <a href="<?php echo esc_url( get_permalink() ); ?>"
               class="w-full flex items-center justify-center px-5 py-2.5 bg-brand-sage text-white text-sm font-semibold rounded-full hover:bg-brand-mid transition-all">
                Select Options
            </a>
            <?php else : ?>
            <span class="w-full flex items-center justify-center px-5 py-2.5 bg-brand-sand text-brand-gray text-sm font-semibold rounded-full cursor-not-allowed border border-brand-sage/10">
                Unavailable
            </span>
            <?php endif; ?>
        </div>

    </div>
</li>
