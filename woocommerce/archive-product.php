<?php
/**
 * WooCommerce shop archive — overrides woocommerce/templates/archive-product.php
 * When WooCommerce is active this file is used for the /shop/ page and
 * product-category archives. The category grid is built dynamically from
 * WooCommerce product categories (get_terms 'product_cat'), using the thumbnail
 * image assigned to each category in WooCommerce → Products → Categories.
 */
get_header();

$book_url = home_url( '/zg-wellness-dermatology-services/' );

$chevron = '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>';

// Map category slugs to filter tags and extra search keywords.
// Add new slugs here as new product categories are created.
$slug_tag_map = [
    'body-contouring'  => [ 'tags' => 'treatments',             'name' => 'body contouring' ],
    'facial'           => [ 'tags' => 'treatments skincare',    'name' => 'facial' ],
    'injectables'      => [ 'tags' => 'injectables treatments', 'name' => 'injectables' ],
    'filler'           => [ 'tags' => 'injectables treatments', 'name' => 'filler dermal filler' ],
    'laser-treatment'  => [ 'tags' => 'laser treatments',       'name' => 'laser treatments' ],
    'laser-hair-removal' => [ 'tags' => 'laser treatments',     'name' => 'laser hair removal' ],
    'lift-tint'        => [ 'tags' => 'treatments',             'name' => 'lift tint lash brow' ],
    'microneedling'    => [ 'tags' => 'treatments skincare',    'name' => 'microneedling' ],
    'pdo-threads'      => [ 'tags' => 'treatments',             'name' => 'pdo threads' ],
    'peel'             => [ 'tags' => 'treatments skincare',    'name' => 'peel chemical peel' ],
    'plasma-pen'       => [ 'tags' => 'treatments',             'name' => 'plasma pen' ],
    'prp'              => [ 'tags' => 'treatments',             'name' => 'prp natural rejuvenation human growth factor' ],
    'skin-care'        => [ 'tags' => 'skincare',               'name' => 'skin care skincare zo elta md' ],
    'supplements'      => [ 'tags' => 'wellness skincare',      'name' => 'supplements vitamins biote' ],
    'waxing'           => [ 'tags' => 'treatments',             'name' => 'waxing hair removal' ],
    'wellness'         => [ 'tags' => 'wellness',               'name' => 'wellness weight loss hormone' ],
    'primary-care'     => [ 'tags' => 'wellness',               'name' => 'primary care' ],
    'packages'         => [ 'tags' => 'gifts',                  'name' => 'packages bundles' ],
    'gift-certificates'=> [ 'tags' => 'gifts',                  'name' => 'gift card gift certificate' ],
];

$raw_terms = get_terms( [
    'taxonomy'   => 'product_cat',
    'hide_empty' => false,
    'orderby'    => 'menu_order',
    'order'      => 'ASC',
] );

$categories = [];
if ( ! is_wp_error( $raw_terms ) ) {
    foreach ( $raw_terms as $term ) {
        $thumbnail_id  = get_term_meta( $term->term_id, 'thumbnail_id', true );
        $img           = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : '';
        $map           = $slug_tag_map[ $term->slug ] ?? null;

        $categories[] = [
            'title' => esc_html( $term->name ),
            'desc'  => $term->description ?: '',
            'img'   => $img,
            'url'   => get_term_link( $term ),
            'tags'  => $map ? $map['tags'] : 'treatments',
            'name'  => $map ? $map['name'] : strtolower( $term->name ),
        ];
    }
}
?>

<!-- ═══════════════════════════════════════════
     HERO
═══════════════════════════════════════════ -->
<section class="page-hero-section relative pb-14 text-white overflow-hidden bg-hero-gradient">
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-brand-taupe/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 w-125 h-125 bg-brand-light/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: radial-gradient(circle, rgba(255,255,255,0.4) 1px, transparent 1px); background-size: 36px 36px;"></div>

    <div class="relative max-w-7xl mx-auto px-5 lg:px-8 text-center">
        <p class="uppercase tracking-widest text-brand-taupe-light text-xs font-semibold mb-4">
            Zero Gravity Aesthetics &amp; Wellness
        </p>
        <h1 class="font-serif text-5xl md:text-6xl leading-tight mb-5 text-white">
            Services &amp; <span class="shimmer-text">Treatments</span>
        </h1>
        <p class="text-white/70 text-lg max-w-xl mx-auto mb-8">
            Browse and book from our full menu of medical-grade treatments —
            from injectables and laser to skincare and wellness.
        </p>

        <!-- Search -->
        <div class="max-w-md mx-auto relative">
            <input id="search-input" type="text" placeholder="Search treatments..."
                   class="w-full px-5 py-3.5 pr-12 rounded-full bg-white/15 backdrop-blur-md border border-white/25 text-white placeholder-white/50 text-sm focus:outline-none focus:border-white/60 focus:bg-white/20 transition" />
            <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-white/50 pointer-events-none"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════
     FILTER PILLS
═══════════════════════════════════════════ -->
<section class="sticky top-18 z-40 bg-white border-b border-black/8 shadow-sm">
    <div class="max-w-7xl mx-auto px-5 lg:px-8 py-3 flex items-center gap-2 overflow-x-auto scrollbar-none">
        <?php
        $filters = [
            'all'        => 'All',
            'treatments' => 'Treatments',
            'injectables'=> 'Injectables',
            'laser'      => 'Laser',
            'skincare'   => 'Skin Care',
            'wellness'   => 'Wellness',
            'gifts'      => 'Gifts &amp; Packages',
        ];
        foreach ( $filters as $value => $label ) :
            $active = $value === 'all' ? ' active border-brand-sage/30 text-brand-sage' : ' border-gray-200 text-brand-gray hover:border-brand-sage/40 hover:text-brand-sage';
        ?>
        <button data-filter="<?php echo esc_attr( $value ); ?>"
                class="filter-pill flex-none px-4 py-1.5 rounded-full text-sm font-medium border transition-all<?php echo $active; ?>">
            <?php echo $label; ?>
        </button>
        <?php endforeach; ?>
    </div>
</section>

<!-- ═══════════════════════════════════════════
     CATEGORY GRID
═══════════════════════════════════════════ -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">

        <div id="category-grid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
            <?php foreach ( $categories as $cat ) : ?>
            <a href="<?php echo esc_url( $cat['url'] ); ?>"
               data-tags="<?php echo esc_attr( $cat['tags'] ); ?>"
               data-name="<?php echo esc_attr( $cat['name'] ); ?>"
               class="cat-card group block rounded-2xl overflow-hidden border border-black/8 bg-white shadow-sm reveal">
                <div class="overflow-hidden aspect-square bg-gray-100">
                    <?php if ( ! empty( $cat['img'] ) ) : ?>
                    <img src="<?php echo esc_url( $cat['img'] ); ?>"
                         alt="<?php echo esc_attr( strip_tags( $cat['title'] ) ); ?>"
                         class="cat-img w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                    <?php else : ?>
                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="p-4">
                    <h3 class="text-brand-dark mb-1 text-[1.25rem]"><?php echo $cat['title']; ?></h3>
                    <p class="text-xs text-brand-gray/60 mb-3 leading-relaxed"><?php // echo esc_html( $cat['desc'] ); ?></p>
                    <span class="inline-flex items-center gap-1 font-semibold text-brand-sage group-hover:gap-2 transition-all">
                        Shop Now
                        <?php echo $chevron; ?>
                    </span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- Empty state -->
        <div id="no-results" class="hidden text-center py-20">
            <p class="text-brand-gray/50 text-lg">No categories match your search.</p>
            <button onclick="resetFilters()" class="mt-4 text-brand-sage font-semibold text-sm hover:underline">Clear search</button>
        </div>

    </div>
</section>

<!-- ═══════════════════════════════════════════
     CTA BANNER
═══════════════════════════════════════════ -->
<section class="relative py-24 text-white text-center overflow-hidden" style="background: linear-gradient(135deg, #3D4A3E 0%, #7A8F7B 55%, #94A995 100%);">
    <div class="absolute -top-16 -left-16 w-72 h-72 rounded-full opacity-20 blur-3xl" style="background: #B7AFA3;"></div>
    <div class="absolute -bottom-16 -right-16 w-96 h-96 rounded-full opacity-15 blur-3xl" style="background: #94A995;"></div>

    <div class="relative max-w-2xl mx-auto px-6 reveal">
        <p class="uppercase tracking-widest text-brand-taupe-light text-sm font-semibold mb-4">
            Zero Gravity Aesthetics &amp; Wellness
        </p>
        <h2 class="font-serif text-4xl md:text-5xl font-bold mb-5 leading-tight text-white">
            Ready to <span style="background: linear-gradient(135deg, #6B6560, #B7AFA3, #E8DED2); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Get Started?</span>
        </h2>
        <p class="text-white/70 text-lg mb-10">
            Our team of nurse practitioners and RNs are here to build a custom treatment plan just for you. Book your consultation today.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="<?php echo esc_url( $book_url ); ?>"
               class="px-8 py-4 rounded-full font-semibold text-brand-dark shadow-lg hover:scale-105 transition-transform duration-200"
               style="background: linear-gradient(135deg, #8A8178, #B7AFA3, #E8DED2);">
                Schedule Aesthetics
            </a>
            <a href="tel:8593443250" class="px-8 py-4 rounded-full font-semibold border border-white/40 text-white hover:bg-white/10 transition-colors duration-200">
                (859) 344-3250
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
