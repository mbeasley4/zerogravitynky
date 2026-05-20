<?php
/**
 * Dynamic render for zerogravitynky/zg-category-products.
 *
 * Cards deliberately match the site's content-product.php loop style
 * so they look identical to the WooCommerce shop/category pages.
 *
 * - Top $limit best-selling products, falling back to newest.
 * - "View All" button links to parent category when a child is selected.
 */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'wc_get_product' ) ) {
    return;
}

$cat_id       = intval( $attributes['categoryId'] ?? 0 );
$limit        = max( 1, intval( $attributes['limit'] ?? 4 ) );
$heading      = sanitize_text_field( $attributes['heading'] ?? '' );
$color_scheme = sanitize_key( $attributes['colorScheme'] ?? 'white' );

$is_purple     = $color_scheme === 'purple';
$bg_class      = $is_purple ? 'bg-brand-sage' : ( $color_scheme === 'lavender' ? 'bg-brand-sand' : 'bg-white' );
$eyebrow_class = $is_purple ? 'text-brand-taupe'   : 'text-brand-sage';
$heading_class = $is_purple ? 'text-white'         : 'text-brand-dark';
$link_class    = $is_purple ? 'text-white hover:text-brand-taupe' : 'text-brand-sage hover:text-brand-mid';
$cta_style     = $is_purple
    ? 'background:linear-gradient(135deg,#8A8178,#B7AFA3);'
    : 'background:linear-gradient(135deg,#7A8F7B,#94A995);';

if ( ! $cat_id ) {
    if ( current_user_can( 'edit_posts' ) ) {
        echo '<p style="padding:1rem;background:#fef9c3;border:1px solid #fde68a;border-radius:.5rem;">
                ZG Category Products: no category selected — configure this block in the editor.
              </p>';
    }
    return;
}

// ── Resolve category & View All link ─────────────────────────────────────
$category = get_term( $cat_id, 'product_cat' );
if ( ! $category || is_wp_error( $category ) ) {
    return;
}

// Child category → link up to parent for "View All"
if ( $category->parent ) {
    $link_term = get_term( $category->parent, 'product_cat' );
    if ( ! $link_term || is_wp_error( $link_term ) ) {
        $link_term = $category;
    }
} else {
    $link_term = $category;
}

$view_all_url   = get_term_link( $link_term );
$view_all_label = 'View All ' . $link_term->name;
$section_title  = $heading ?: $category->name;

// ── Query top-selling products ────────────────────────────────────────────
$query = new WP_Query( [
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => $limit,
    'tax_query'      => [ [
        'taxonomy'         => 'product_cat',
        'field'            => 'term_id',
        'terms'            => $cat_id,
        'include_children' => true,
    ] ],
    'meta_key' => 'total_sales',
    'orderby'  => [ 'meta_value_num' => 'DESC', 'date' => 'DESC' ],
] );

if ( ! $query->have_posts() ) {
    return;
}

$cols              = min( $limit, 4 );
$wrapper_attrs     = get_block_wrapper_attributes();
?>

<section <?php echo $wrapper_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
<div class="py-20 <?php echo esc_attr( $bg_class ); ?>">
<div class="max-w-7xl mx-auto px-5 lg:px-8">

    <!-- ── Section header ──────────────────────────────────────────── -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12">
        <div>
            <p class="uppercase tracking-widest <?php echo esc_attr( $eyebrow_class ); ?> text-xs font-semibold mb-3" style="margin:0 0 .5rem;">
                <?php echo esc_html( $link_term->name ); ?>
            </p>
            <h2 class="font-serif text-3xl lg:text-4xl <?php echo esc_attr( $heading_class ); ?>" style="margin:0;">
                <?php echo esc_html( $section_title ); ?>
            </h2>
            <div class="w-14 h-1 rounded-full bg-brand-taupe mt-4"></div>
        </div>
        <a href="<?php echo esc_url( $view_all_url ); ?>"
           class="inline-flex items-center gap-1.5 <?php echo esc_attr( $link_class ); ?> text-sm font-semibold hover:gap-3 transition-all whitespace-nowrap group self-start sm:self-auto">
            <?php echo esc_html( $view_all_label ); ?>
            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
    </div>

    <!-- ── Product grid ────────────────────────────────────────────── -->
    <ul class="grid sm:grid-cols-2 lg:grid-cols-<?php echo esc_attr( $cols ); ?> gap-6 list-none p-0 m-0">

    <?php while ( $query->have_posts() ) : $query->the_post();
        $product = wc_get_product( get_the_ID() );
        if ( ! $product ) { continue; }

        $thumbnail_id    = $product->get_image_id();
        $img_url         = $thumbnail_id
                            ? wp_get_attachment_image_url( $thumbnail_id, 'woocommerce_thumbnail' )
                            : wc_placeholder_img_src( 'woocommerce_thumbnail' );
        $img_alt         = $thumbnail_id
                            ? trim( wp_strip_all_tags( get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true ) ) )
                            : $product->get_name();
        $price_html      = $product->get_price_html();
        $short_desc      = $product->get_short_description();
        $on_sale         = $product->is_on_sale();
        $is_best_seller  = intval( $product->get_total_sales() ) > 0;
        $can_add         = $product->is_purchasable() && $product->is_in_stock() && $product->is_type( 'simple' );
        $is_variable     = $product->is_type( 'variable' );
    ?>

    <li <?php wc_product_class( 'service-card group relative overflow-hidden rounded-2xl bg-brand-sand border border-transparent hover:border-brand-sage/20 flex flex-col cursor-pointer', $product ); ?>>

        <!-- Thumbnail -->
        <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="block relative h-72 overflow-hidden flex-none" tabindex="-1" aria-hidden="true">
            <img src="<?php echo esc_url( $img_url ); ?>"
                 alt="<?php echo esc_attr( $img_alt ); ?>"
                 class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500"
                 loading="lazy" />
            <div class="absolute inset-0 bg-brand-sage/20 group-hover:bg-brand-sage/10 transition-colors"></div>

            <!-- Badges -->
            <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                <?php if ( $on_sale ) : ?>
                <span class="px-2.5 py-1 bg-brand-taupe text-white text-xs font-bold rounded-full">
                    Sale
                </span>
                <?php endif; ?>
                <?php if ( $is_best_seller ) : ?>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold text-white"
                      style="background:rgba(61,74,62,0.85);backdrop-filter:blur(4px);">
                    <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    Best Seller
                </span>
                <?php endif; ?>
            </div>
        </a>

        <!-- Body -->
        <div class="p-7 flex flex-col flex-1">

            <h3 class="font-serif text-xl font-semibold text-brand-dark mb-3 leading-snug" style="margin-top:0;">
                <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="hover:text-brand-sage transition-colors no-underline" style="text-decoration:none;color:inherit;">
                    <?php echo esc_html( $product->get_name() ); ?>
                </a>
            </h3>

            <?php if ( $price_html ) : ?>
            <div class="text-brand-sage font-semibold text-sm mb-3">
                <?php echo $price_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </div>
            <?php endif; ?>

            <?php if ( $short_desc ) : ?>
            <p class="text-brand-gray/70 text-sm leading-relaxed mb-5 line-clamp-2 flex-1" style="margin-bottom:1.25rem;">
                <?php echo wp_kses_post( $short_desc ); ?>
            </p>
            <?php else : ?>
            <div class="flex-1"></div>
            <?php endif; ?>

            <!-- CTA — mirrors content-product.php exactly -->
            <div class="mt-auto pt-4 border-t border-brand-sage/10">
                <?php if ( $can_add ) : ?>
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
                <?php elseif ( $is_variable ) : ?>
                <a href="<?php echo esc_url( $product->get_permalink() ); ?>"
                   class="w-full flex items-center justify-center px-5 py-2.5 bg-brand-sage text-white text-sm font-semibold rounded-full hover:bg-brand-mid transition-all">
                    Select Options
                </a>
                <?php else : ?>
                <a href="<?php echo esc_url( $product->get_permalink() ); ?>"
                   class="w-full flex items-center justify-center px-5 py-2.5 bg-brand-sage text-white text-sm font-semibold rounded-full hover:bg-brand-mid transition-all">
                    View Details
                </a>
                <?php endif; ?>
            </div>

        </div>
    </li>

    <?php endwhile; wp_reset_postdata(); ?>

    </ul>

    <!-- ── View all CTA ────────────────────────────────────────────── -->
    <div class="mt-12 text-center">
        <a href="<?php echo esc_url( $view_all_url ); ?>"
           class="inline-flex items-center gap-2 px-8 py-4 rounded-full font-semibold text-white shadow-lg hover:scale-105 transition-transform"
           style="<?php echo esc_attr( $cta_style ); ?>">
            <?php echo esc_html( $view_all_label ); ?>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
    </div>

</div>
</div>
</section>
