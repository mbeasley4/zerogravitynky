<?php
/**
 * WooCommerce product category archive template.
 * Used for all /product-category/<slug>/ pages.
 *
 * Overrides woocommerce/templates/taxonomy-product_cat.php
 */

defined( 'ABSPATH' ) || exit;

get_header();

$term     = get_queried_object();
$cat_name = $term instanceof WP_Term ? $term->name : '';
$cat_desc = $term instanceof WP_Term ? $term->description : '';

// Category thumbnail (set via WooCommerce category edit screen).
$thumbnail_id = $term instanceof WP_Term ? get_term_meta( $term->term_id, 'thumbnail_id', true ) : 0;
$cat_img_url  = $thumbnail_id ? wp_get_attachment_image_url( $thumbnail_id, 'large' ) : '';

$shop_url = get_permalink( wc_get_page_id( 'shop' ) );
$book_url = home_url( '/zg-wellness-dermatology-services/' );

// Breadcrumb ancestors (parent categories).
$ancestors = $term instanceof WP_Term ? get_ancestors( $term->term_id, 'product_cat', 'taxonomy' ) : [];
$ancestors = array_reverse( $ancestors );

// Child categories — used to decide between grouped and flat view.
$child_cats = $term instanceof WP_Term ? get_terms( [
    'taxonomy'   => 'product_cat',
    'parent'     => $term->term_id,
    'hide_empty' => true,
    'orderby'    => 'menu_order',
    'order'      => 'ASC',
] ) : [];
$has_subcats = ! empty( $child_cats ) && ! is_wp_error( $child_cats );
?>

<div>

    <!-- ── Category Hero ──────────────────────────────────────────── -->
    <section class="page-hero-section page-hero-short relative overflow-hidden bg-hero-gradient">
        <!-- Background decorations (matching page-hero) -->
        <div class="blob absolute -top-24 -right-24 w-80 h-80 bg-brand-mid/30 blur-3xl pointer-events-none"></div>
        <div class="blob absolute bottom-0 -left-20 w-72 h-72 bg-brand-sage/40 blur-3xl pointer-events-none" style="animation-delay:-3s"></div>
        <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: radial-gradient(circle, rgba(255,255,255,0.4) 1px, transparent 1px); background-size: 36px 36px;"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 py-16 flex flex-col justify-center" style="min-height: 320px;">

            <!-- Breadcrumb -->
            <nav class="flex items-center gap-1.5 text-white/50 text-xs mb-5 flex-wrap">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-white/80 transition-colors">Home</a>
                <svg class="w-3 h-3 flex-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="<?php echo esc_url( $shop_url ); ?>" class="hover:text-white/80 transition-colors">Shop</a>
                <?php foreach ( $ancestors as $ancestor_id ) :
                    $ancestor = get_term( $ancestor_id, 'product_cat' );
                    if ( ! $ancestor || is_wp_error( $ancestor ) ) continue;
                ?>
                <svg class="w-3 h-3 flex-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="<?php echo esc_url( get_term_link( $ancestor ) ); ?>" class="hover:text-white/80 transition-colors"><?php echo esc_html( $ancestor->name ); ?></a>
                <?php endforeach; ?>
                <svg class="w-3 h-3 flex-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-white/80"><?php echo esc_html( $cat_name ); ?></span>
            </nav>

            <!-- H1 -->
            <h1 class="font-serif text-4xl lg:text-5xl font-bold text-white leading-tight mb-4">
                <?php echo esc_html( $cat_name ); ?>
            </h1>

            <!-- Gold decorative line -->
            <div class="w-16 h-1 rounded-full bg-brand-taupe mb-5"></div>

            <?php if ( $cat_desc ) : ?>
            <p class="text-white/75 text-base lg:text-lg max-w-2xl leading-relaxed">
                <?php echo wp_kses_post( $cat_desc ); ?>
            </p>
            <?php endif; ?> 

        </div>
    </section>

    <!-- ── Product Grid ───────────────────────────────────────────── -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <?php if ( $has_subcats ) : ?>

            <?php
            // ── Grouped view: one section per child category ──────────────
            $any_products = false;

            // Direct products in this parent that don't belong to any child cat.
            $child_ids = wp_list_pluck( $child_cats, 'term_id' );

            $direct_query = new WP_Query( [
                'post_type'      => 'product',
                'posts_per_page' => -1,
                'orderby'        => 'menu_order',
                'order'          => 'ASC',
                'post_status'    => 'publish',
                'tax_query'      => [
                    'relation' => 'AND',
                    [
                        'taxonomy' => 'product_cat',
                        'field'    => 'term_id',
                        'terms'    => $term->term_id,
                    ],
                    [
                        'taxonomy' => 'product_cat',
                        'field'    => 'term_id',
                        'terms'    => $child_ids,
                        'operator' => 'NOT IN',
                    ],
                ],
            ] );

            if ( $direct_query->have_posts() ) :
                $any_products = true;
            ?>
            <div class="mb-14">
                <div class="flex items-center gap-4 mb-8">
                    <h2 class="font-serif text-2xl lg:text-3xl font-semibold text-brand-dark whitespace-nowrap">
                        <?php echo esc_html( $cat_name ); ?>
                    </h2>
                    <div class="flex-1 h-px bg-brand-sage/15"></div>
                </div>
                <ul class="products grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php
                    global $product;
                    while ( $direct_query->have_posts() ) {
                        $direct_query->the_post();
                        $product = wc_get_product( get_the_ID() );
                        wc_get_template_part( 'content', 'product' );
                    }
                    wp_reset_postdata();
                    ?>
                </ul>
            </div>
            <?php endif; ?>

            <?php foreach ( $child_cats as $child_cat ) :
                $child_query = new WP_Query( [
                    'post_type'      => 'product',
                    'post_status'    => 'publish',
                    'posts_per_page' => -1,
                    'orderby'        => 'menu_order',
                    'order'          => 'ASC',
                    'tax_query'      => [ [
                        'taxonomy' => 'product_cat',
                        'field'    => 'term_id',
                        'terms'    => $child_cat->term_id,
                    ] ],
                ] );

                if ( ! $child_query->have_posts() ) {
                    wp_reset_postdata();
                    continue;
                }
                $any_products = true;
            ?>
            <div class="mb-14">
                <div class="flex items-center gap-4 mb-8">
                    <h2 class="font-serif text-2xl lg:text-3xl font-semibold text-brand-dark whitespace-nowrap">
                        <a href="<?php echo esc_url( get_term_link( $child_cat ) ); ?>"
                           class="hover:text-brand-sage transition-colors">
                            <?php echo esc_html( $child_cat->name ); ?>
                        </a>
                    </h2>
                    <div class="flex-1 h-px bg-brand-sage/15"></div>
                </div>
                <?php if ( $child_cat->description ) : ?>
                <p class="text-brand-gray/70 text-sm mb-6 -mt-4"><?php echo wp_kses_post( $child_cat->description ); ?></p>
                <?php endif; ?>
                <ul class="products grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php
                    global $product;
                    while ( $child_query->have_posts() ) {
                        $child_query->the_post();
                        $product = wc_get_product( get_the_ID() );
                        wc_get_template_part( 'content', 'product' );
                    }
                    wp_reset_postdata();
                    ?>
                </ul>
            </div>
            <?php endforeach; ?>

            <?php if ( ! $any_products ) : ?>
                <!-- Empty state -->
                <div class="text-center py-24">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-brand-sand mb-6">
                        <svg class="w-9 h-9 text-brand-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h2 class="font-serif text-2xl text-brand-dark mb-3">No services found</h2>
                    <p class="text-brand-gray mb-8">We couldn't find any services in this category.</p>
                    <a href="<?php echo esc_url( $shop_url ); ?>" class="px-6 py-3 bg-brand-sage text-white font-semibold rounded-full hover:bg-brand-mid transition-all">
                        Browse All Services
                    </a>
                </div>
            <?php endif; ?>

        <?php else : ?>

            <?php
            // ── Flat view: standard WooCommerce loop (leaf / no subcats) ──
            if ( woocommerce_product_loop() ) :
            ?>
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-10">
                    <div class="text-brand-gray text-sm"><?php woocommerce_result_count(); ?></div>
                    <div class="wc-ordering"><?php woocommerce_catalog_ordering(); ?></div>
                </div>

                <?php
                woocommerce_product_loop_start();
                while ( have_posts() ) {
                    the_post();
                    wc_get_template_part( 'content', 'product' );
                }
                woocommerce_product_loop_end();
                ?>
                <nav class="zg-pagination mt-10" aria-label="Products pages">
                    <?php echo paginate_links( [
                        'prev_text' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg> Prev',
                        'next_text' => 'Next <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>',
                        'type'      => 'plain',
                    ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </nav>
                <?php
                ?>

            <?php else : ?>
                <!-- Empty state -->
                <div class="text-center py-24">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-brand-sand mb-6">
                        <svg class="w-9 h-9 text-brand-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h2 class="font-serif text-2xl text-brand-dark mb-3">No services found</h2>
                    <p class="text-brand-gray mb-8">We couldn't find any services in this category.</p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                        <a href="<?php echo esc_url( $shop_url ); ?>" class="px-6 py-3 bg-brand-sage text-white font-semibold rounded-full hover:bg-brand-mid transition-all">
                            Browse All Services
                        </a>
                        <a href="<?php echo esc_url( $book_url ); ?>" class="px-6 py-3 border border-brand-sage text-brand-sage font-semibold rounded-full hover:bg-brand-sand transition-all">
                            Schedule a Consultation
                        </a>
                    </div>
                </div>
            <?php endif; ?>

        <?php endif; ?>

        </div>
    </section>

    <!-- ── CTA Strip ──────────────────────────────────────────────── -->
    <section class="bg-brand-taupe py-12 text-white text-center">
        <div class="max-w-3xl mx-auto px-5">
            <h2 class="font-serif text-2xl lg:text-3xl mb-2 text-white">Not sure where to start?</h2>
            <p class="text-white/80 mb-6">Book a complimentary consultation and let our team recommend the right treatment for you.</p>
            <a href="<?php echo esc_url( $book_url ); ?>" class="inline-block px-8 py-3 bg-white text-brand-taupe font-bold rounded-full hover:bg-white/90 transition-all shadow-lg">
                Schedule Your Visit
            </a>
        </div>
    </section>

</div>

<?php get_footer();
