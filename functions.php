<?php
// ─────────────────────────────────────────────
// Theme Version  ← bump this to bust all caches
// ─────────────────────────────────────────────
define( 'ZG_THEME_VERSION', '1.0.8' );


// ─────────────────────────────────────────────
// Theme Setup
// ─────────────────────────────────────────────
add_action( 'after_setup_theme', function () {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ] );
    add_theme_support( 'align-wide' );
    add_theme_support( 'editor-styles' );

    add_theme_support( 'custom-logo', [
        'height'      => 91,
        'width'       => 600,
        'flex-height' => true,
        'flex-width'  => true,
    ] );

    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

    // ✅ Single menu only
    register_nav_menus( [
        'primary' => __( 'Primary Navigation', 'zerogravitynky' ),
    ] );

    // Image sizes matched to actual display dimensions in block templates
    add_image_size( 'zg-service-card',  500, 352, true  ); // service-card h-44 at max ~387px wide
    add_image_size( 'zg-content-wide',  700, 300, true  ); // about/membership images max-height:200-260px
    add_image_size( 'zg-hero',         1200, 650, false ); // homepage hero, full-width at lg
} );


// ─────────────────────────────────────────────
// Enqueue Scripts & Styles
// ─────────────────────────────────────────────
add_action( 'wp_enqueue_scripts', function () {

    wp_enqueue_style(
        'zg-google-fonts',
        'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Fraunces:ital,wght@0,400;0,600;0,700;1,400;1,600&display=swap',
        [],
        null
    );

    wp_enqueue_style(
        'zg-main',
        get_template_directory_uri() . '/dist/css/main.css',
        [ 'zg-google-fonts' ],
        ZG_THEME_VERSION
    );

    wp_enqueue_script(
        'zg-theme',
        get_template_directory_uri() . '/src/js/theme.js',
        [],
        ZG_THEME_VERSION,
        true
    );
} );


// ─────────────────────────────────────────────
// Block Editor Assets
// ─────────────────────────────────────────────
add_action( 'enqueue_block_editor_assets', function () {

    if ( file_exists( get_template_directory() . '/dist/css/editor.css' ) ) {
        wp_enqueue_style(
            'zg-editor',
            get_template_directory_uri() . '/dist/css/editor.css',
            [],
            ZG_THEME_VERSION
        );
    }

    if ( file_exists( get_template_directory() . '/dist/js/blocks/blocks.js' ) ) {
        wp_enqueue_script(
            'zg-blocks',
            get_template_directory_uri() . '/dist/js/blocks/blocks.js',
            [ 'wp-blocks', 'wp-block-editor', 'wp-components', 'wp-element', 'wp-i18n' ],
            ZG_THEME_VERSION,
            true
        );
    }
} );

add_filter('block_editor_settings_all', function ($settings) {

    // Override spacer defaults
    $settings['defaultBlockStyles']['core/spacer'] = [
        'height' => '4rem'
    ];

    return $settings;
});


// ─────────────────────────────────────────────
// Register Custom Block Category
// ─────────────────────────────────────────────
add_filter( 'block_categories_all', function ( $categories ) {
    return array_merge(
        [ [ 'slug' => 'zerogravitynky', 'title' => 'Zero Gravity', 'icon' => null ] ],
        $categories
    );
} );


// ─────────────────────────────────────────────
// News archive — 15 posts per page
// ─────────────────────────────────────────────
add_action( 'pre_get_posts', function ( $query ) {
    if ( ! is_admin() && $query->is_main_query() && ( $query->is_home() || $query->is_category() || $query->is_tag() || $query->is_date() || $query->is_author() ) ) {
        $query->set( 'posts_per_page', 15 );
    }
} );


// ─────────────────────────────────────────────
// Staff CPT — default ordering by menu_order
// ─────────────────────────────────────────────
add_action( 'pre_get_posts', function ( $query ) {
    if ( ! is_admin() && $query->is_main_query() && $query->is_post_type_archive( 'staff' ) ) {
        $query->set( 'orderby', 'menu_order' );
        $query->set( 'order', 'ASC' );
        $query->set( 'posts_per_page', -1 );
    }
} );


// ─────────────────────────────────────────────
// Single product — "Add to cart" → "Add to Bag"
// ─────────────────────────────────────────────
add_filter( 'woocommerce_product_single_add_to_cart_text', function () {
    return __( 'Add to Bag', 'zerogravitynky' );
} );


// ─────────────────────────────────────────────
// "View cart" → "View bag" everywhere in WC messages
// ─────────────────────────────────────────────
add_filter( 'wc_add_to_cart_message_html', function ( $message ) {
    return str_replace(
        [ 'View cart', 'view cart' ],
        [ 'View bag',  'view bag'  ],
        $message
    );
} );


// ─────────────────────────────────────────────
// Single product — remove SKU / category meta + sidebar
// ─────────────────────────────────────────────
add_action( 'init', function () {
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
    remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
    // Remove the "Returning customer? Click here to login" notice from checkout —
    // it renders an empty info box when login is not required.
    remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
} );


// ─────────────────────────────────────────────
// Checkout — default "Ship to a different address?" to unchecked
// ─────────────────────────────────────────────
add_filter( 'woocommerce_ship_to_different_address_checked', '__return_false' );


// ─────────────────────────────────────────────
// Products — never show private on front end
// ─────────────────────────────────────────────
add_action( 'pre_get_posts', function ( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }
    if ( $query->is_tax( 'product_cat' ) || $query->is_post_type_archive( 'product' ) ) {
        $query->set( 'post_status', 'publish' );
    }
} );


// ─────────────────────────────────────────────
// Specials — "expired" post status
// ─────────────────────────────────────────────
add_action( 'init', function () {
    register_post_status( 'expired', [
        'label'                     => _x( 'Expired', 'post status', 'zerogravitynky' ),
        'public'                    => true,   // visible on front end
        'exclude_from_search'       => true,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        /* translators: %s: number of expired specials */
        'label_count'               => _n_noop( 'Expired <span class="count">(%s)</span>', 'Expired <span class="count">(%s)</span>', 'zerogravitynky' ),
    ] );
} );

// Show "Expired" as an option in the post-status dropdown for Specials
add_action( 'post_submitbox_misc_actions', function () {
    global $post;
    if ( $post && 'specials' === $post->post_type ) {
        $selected = ( 'expired' === $post->post_status ) ? ' selected="selected"' : '';
        echo '<script>
            jQuery(function($){
                $("select#post_status").append("<option value=\"expired\"' . $selected . '>Expired</option>");
                if ("expired" === "' . esc_js( $post->post_status ) . '") {
                    $("#post-status-display").text("Expired");
                }
            });
        </script>';
    }
} );


// ─────────────────────────────────────────────
// Specials — daily cron to auto-expire
// ─────────────────────────────────────────────
add_action( 'wp', function () {
    if ( ! wp_next_scheduled( 'zg_expire_specials' ) ) {
        wp_schedule_event( time(), 'daily', 'zg_expire_specials' );
    }
} );

add_action( 'zg_expire_specials', 'zg_run_expire_specials' );

function zg_run_expire_specials() {
    $today = current_time( 'Y-m-d' );

    $posts = get_posts( [
        'post_type'      => 'specials',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'meta_query'     => [
            [
                'key'     => '_special_end_date',
                'value'   => $today,
                'compare' => '<',
                'type'    => 'DATE',
            ],
        ],
        'fields' => 'ids',
    ] );

    foreach ( $posts as $id ) {
        wp_update_post( [ 'ID' => $id, 'post_status' => 'expired' ] );
    }
}

// Also expire on save, in case the end date is set in the past
add_action( 'save_post_specials', function ( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    $end = get_post_meta( $post_id, '_special_end_date', true );
    if ( $end && $end < current_time( 'Y-m-d' ) ) {
        // Remove our action to avoid recursion, then update
        remove_action( 'save_post_specials', __FUNCTION__ );
        wp_update_post( [ 'ID' => $post_id, 'post_status' => 'expired' ] );
        add_action( 'save_post_specials', __FUNCTION__ );
    }
}, 20 );


// ─────────────────────────────────────────────
// Register Custom Post Types
// ─────────────────────────────────────────────
add_action( 'init', function () {

    register_post_type( 'specials', [
        'labels' => [
            'name'               => 'Specials',
            'singular_name'      => 'Special',
            'add_new'            => 'Add New Special',
            'add_new_item'       => 'Add New Special',
            'edit_item'          => 'Edit Special',
            'new_item'           => 'New Special',
            'view_item'          => 'View Special',
            'all_items'          => 'All Specials',
            'search_items'       => 'Search Specials',
            'not_found'          => 'No specials found',
            'not_found_in_trash' => 'No specials found in Trash',
        ],
        'public'            => true,
        'has_archive'       => true,
        'rewrite'           => [ 'slug' => 'specials' ],
        'supports'          => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
        'menu_icon'         => 'dashicons-tag',
        'show_in_rest'      => true,
        'menu_position'     => 6,
    ] );

    register_post_type( 'zg_review', [
        'labels' => [
            'name'               => 'Reviews',
            'singular_name'      => 'Review',
            'add_new'            => 'Add New Review',
            'add_new_item'       => 'Add New Review',
            'edit_item'          => 'Edit Review',
            'new_item'           => 'New Review',
            'view_item'          => 'View Review',
            'all_items'          => 'All Reviews',
            'search_items'       => 'Search Reviews',
            'not_found'          => 'No reviews found',
            'not_found_in_trash' => 'No reviews found in Trash',
        ],
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'has_archive'        => false,
        'rewrite'            => false,
        'supports'           => [ 'title' ],
        'menu_icon'          => 'dashicons-star-filled',
        'show_in_rest'       => false,
        'menu_position'      => 7,
    ] );

    register_post_type( 'staff', [
        'labels' => [
            'name'               => 'Staff',
            'singular_name'      => 'Staff Member',
            'add_new'            => 'Add New Member',
            'add_new_item'       => 'Add New Staff Member',
            'edit_item'          => 'Edit Staff Member',
            'new_item'           => 'New Staff Member',
            'view_item'          => 'View Staff Member',
            'all_items'          => 'All Staff',
            'search_items'       => 'Search Staff',
            'not_found'          => 'No staff found',
            'not_found_in_trash' => 'No staff found in Trash',
        ],
        'public'            => true,
        'has_archive'       => true,
        'rewrite'           => [ 'slug' => 'staff' ],
        'supports'          => [ 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ],
        'menu_icon'         => 'dashicons-groups',
        'show_in_rest'      => true,
        'menu_position'     => 5,
    ] );

} );


// ─────────────────────────────────────────────
// Specials — start / end date meta box
// ─────────────────────────────────────────────
add_action( 'add_meta_boxes', function () {
    add_meta_box(
        'zg_special_dates',
        'Special Dates',
        'zg_special_dates_callback',
        'specials',
        'side',
        'high'
    );
} );

function zg_special_dates_callback( $post ) {
    wp_nonce_field( 'zg_special_dates_save', 'zg_special_dates_nonce' );
    $start = get_post_meta( $post->ID, '_special_start_date', true );
    $end   = get_post_meta( $post->ID, '_special_end_date', true );
    ?>
    <p style="margin-bottom:8px;">
        <label for="zg_start_date" style="display:block;font-weight:600;margin-bottom:4px;">Start Date</label>
        <input type="date" id="zg_start_date" name="zg_start_date"
               value="<?php echo esc_attr( $start ); ?>"
               style="width:100%;padding:4px 6px;" />
    </p>
    <p>
        <label for="zg_end_date" style="display:block;font-weight:600;margin-bottom:4px;">End Date</label>
        <input type="date" id="zg_end_date" name="zg_end_date"
               value="<?php echo esc_attr( $end ); ?>"
               style="width:100%;padding:4px 6px;" />
    </p>
    <?php
}

add_action( 'save_post_specials', function ( $post_id ) {
    if (
        ! isset( $_POST['zg_special_dates_nonce'] ) ||
        ! wp_verify_nonce( $_POST['zg_special_dates_nonce'], 'zg_special_dates_save' ) ||
        defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE
    ) {
        return;
    }
    if ( isset( $_POST['zg_start_date'] ) ) {
        update_post_meta( $post_id, '_special_start_date', sanitize_text_field( $_POST['zg_start_date'] ) );
    }
    if ( isset( $_POST['zg_end_date'] ) ) {
        update_post_meta( $post_id, '_special_end_date', sanitize_text_field( $_POST['zg_end_date'] ) );
    }
} );


// ─────────────────────────────────────────────
// Reviews — meta box (date, comment, link, stars)
// ─────────────────────────────────────────────
add_action( 'add_meta_boxes', function () {
    add_meta_box(
        'zg_review_details',
        'Review Details',
        'zg_review_details_callback',
        'zg_review',
        'normal',
        'high'
    );
} );

function zg_review_details_callback( $post ) {
    wp_nonce_field( 'zg_review_details_save', 'zg_review_details_nonce' );
    $reviewer = get_post_meta( $post->ID, '_review_reviewer',  true );
    $comment  = get_post_meta( $post->ID, '_review_comment',   true );
    $date     = get_post_meta( $post->ID, '_review_date',      true );
    $link     = get_post_meta( $post->ID, '_review_link',      true );
    $stars    = get_post_meta( $post->ID, '_review_stars',     true );
    $source   = get_post_meta( $post->ID, '_review_source',    true );
    ?>
    <table class="form-table" style="width:100%;">
        <tr>
            <th style="width:160px;padding:12px 10px 12px 0;vertical-align:top;">
                <label for="zg_review_reviewer"><strong>Reviewer Name</strong></label>
            </th>
            <td style="padding:8px 0;">
                <input type="text" id="zg_review_reviewer" name="zg_review_reviewer"
                       value="<?php echo esc_attr( $reviewer ); ?>"
                       style="width:100%;max-width:480px;" placeholder="e.g. Sarah M." />
            </td>
        </tr>
        <tr>
            <th style="padding:12px 10px 12px 0;vertical-align:top;">
                <label for="zg_review_comment"><strong>Review Comment</strong></label>
            </th>
            <td style="padding:8px 0;">
                <textarea id="zg_review_comment" name="zg_review_comment"
                          rows="5" style="width:100%;max-width:600px;"
                          placeholder="Paste or type the review text here…"><?php echo esc_textarea( $comment ); ?></textarea>
            </td>
        </tr>
        <tr>
            <th style="padding:12px 10px 12px 0;vertical-align:top;">
                <label for="zg_review_stars"><strong>Star Rating</strong></label>
            </th>
            <td style="padding:8px 0;">
                <select id="zg_review_stars" name="zg_review_stars" style="width:120px;">
                    <?php for ( $i = 5; $i >= 0; $i-- ) : ?>
                    <option value="<?php echo $i; ?>" <?php selected( (string) $stars, (string) $i ); ?>>
                        <?php echo $i; ?> star<?php echo $i !== 1 ? 's' : ''; ?>
                    </option>
                    <?php endfor; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th style="padding:12px 10px 12px 0;vertical-align:top;">
                <label for="zg_review_source"><strong>Source</strong></label>
            </th>
            <td style="padding:8px 0;">
                <select id="zg_review_source" name="zg_review_source" style="width:160px;">
                    <option value=""     <?php selected( $source, '' ); ?>>— None —</option>
                    <option value="google" <?php selected( $source, 'google' ); ?>>Google</option>
                    <option value="yelp"   <?php selected( $source, 'yelp' ); ?>>Yelp</option>
                    <option value="other"  <?php selected( $source, 'other' ); ?>>Other</option>
                </select>
            </td>
        </tr>
        <tr>
            <th style="padding:12px 10px 12px 0;vertical-align:top;">
                <label for="zg_review_date"><strong>Review Date</strong></label>
            </th>
            <td style="padding:8px 0;">
                <input type="date" id="zg_review_date" name="zg_review_date"
                       value="<?php echo esc_attr( $date ); ?>"
                       style="width:180px;" />
            </td>
        </tr>
        <tr>
            <th style="padding:12px 10px 12px 0;vertical-align:top;">
                <label for="zg_review_link"><strong>Source Link</strong></label>
            </th>
            <td style="padding:8px 0;">
                <input type="url" id="zg_review_link" name="zg_review_link"
                       value="<?php echo esc_attr( $link ); ?>"
                       style="width:100%;max-width:480px;"
                       placeholder="https://g.co/… or https://yelp.com/…" />
                <p class="description">Optional link back to the original review.</p>
            </td>
        </tr>
    </table>
    <?php
}

add_action( 'save_post_zg_review', function ( $post_id ) {
    if (
        ! isset( $_POST['zg_review_details_nonce'] ) ||
        ! wp_verify_nonce( $_POST['zg_review_details_nonce'], 'zg_review_details_save' ) ||
        ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
    ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $fields = [
        'zg_review_reviewer' => [ '_review_reviewer', 'sanitize_text_field'     ],
        'zg_review_comment'  => [ '_review_comment',  'sanitize_textarea_field' ],
        'zg_review_date'     => [ '_review_date',      'sanitize_text_field'     ],
        'zg_review_source'   => [ '_review_source',    'sanitize_text_field'     ],
    ];

    foreach ( $fields as $post_key => [ $meta_key, $sanitizer ] ) {
        update_post_meta( $post_id, $meta_key, $sanitizer( $_POST[ $post_key ] ?? '' ) );
    }

    update_post_meta( $post_id, '_review_link',  esc_url_raw( $_POST['zg_review_link'] ?? '' ) );
    update_post_meta( $post_id, '_review_stars', min( 5, absint( $_POST['zg_review_stars'] ?? 5 ) ) );
} );


// ─────────────────────────────────────────────
// Register Custom Blocks
// ─────────────────────────────────────────────
add_action( 'init', function () {

    foreach ( [
        'about-team',    
        'homepage-hero',
        'service-card',
        'cta-banner',
        'testimonial-card',
        'membership-tier',
        'marquee-strip',
        'page-hero',
        'page-hero-short',
        'checkout-trust',
        'zg-column',
        'zg-contact-hours',
        'zg-financing',
        'zg-book-appointment',
        'zg-gift-card',
        'zg-category-products',
        'zg-faq',
        'services-section',
        'zg-image-split',
        'zg-reviews',
        'zg-icon-cards',
    ] as $block ) {

        $block_json = get_template_directory() . '/blocks/' . $block . '/block.json';

        if ( file_exists( $block_json ) ) {
            register_block_type( $block_json );
        }
    }
} );


// ─────────────────────────────────────────────
// Site Settings — contact info & store hours
// ─────────────────────────────────────────────

/**
 * Returns a site option value with a sensible default.
 * Use this in template-parts and block render.php files.
 */
function zg_get_site_option( string $key ): string {
    static $defaults = null;
    if ( null === $defaults ) {
        $defaults = [
            'zg_phone'                  => '(859) 344-3250',
            'zg_email'                  => 'info@zerogravitynky.com',
            'zg_address_street'         => '2853 Town Center Blvd',
            'zg_address_city_state_zip' => 'Crestview Hills, KY 41017',
            'zg_address_secondary'      => "Located in the Crestview Hills Town Center\nNear Cincinnati · Florence · Erlanger",
            'zg_maps_url'               => 'https://maps.google.com/?q=2853+Town+Center+Blvd+Crestview+Hills+KY+41017',
            'zg_hours_topbar'           => 'Mon–Thu 10am–6pm · Fri 10am–5pm',
            'zg_hours_mon_thu'          => '10:00 am – 6:00 pm',
            'zg_hours_fri'              => '10:00 am – 5:00 pm',
            'zg_hours_sat'              => 'Closed',
            'zg_hours_sun'              => 'Closed',
        ];
    }
    return (string) get_option( $key, $defaults[ $key ] ?? '' );
}

add_action( 'admin_menu', function () {
    add_options_page(
        'Site Settings',
        'Site Settings',
        'manage_options',
        'zg-site-settings',
        'zg_site_settings_page'
    );
} );

add_action( 'admin_init', function () {
    $text_keys = [
        'zg_phone', 'zg_email',
        'zg_address_street', 'zg_address_city_state_zip', 'zg_maps_url',
        'zg_hours_topbar', 'zg_hours_mon_thu', 'zg_hours_fri', 'zg_hours_sat', 'zg_hours_sun',
    ];
    foreach ( $text_keys as $key ) {
        register_setting( 'zg_site_settings', $key, [ 'sanitize_callback' => 'sanitize_text_field' ] );
    }
    register_setting( 'zg_site_settings', 'zg_address_secondary', [ 'sanitize_callback' => 'sanitize_textarea_field' ] );
} );

function zg_site_settings_page(): void {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    ?>
    <div class="wrap">
        <h1>Site Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields( 'zg_site_settings' ); ?>

            <h2>Contact</h2>
            <table class="form-table">
                <tr>
                    <th><label for="zg_phone">Phone</label></th>
                    <td><input type="text" id="zg_phone" name="zg_phone" value="<?php echo esc_attr( zg_get_site_option( 'zg_phone' ) ); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label for="zg_email">Email</label></th>
                    <td><input type="email" id="zg_email" name="zg_email" value="<?php echo esc_attr( zg_get_site_option( 'zg_email' ) ); ?>" class="regular-text" /></td>
                </tr>
            </table>

            <h2>Address</h2>
            <table class="form-table">
                <tr>
                    <th><label for="zg_address_street">Street</label></th>
                    <td><input type="text" id="zg_address_street" name="zg_address_street" value="<?php echo esc_attr( zg_get_site_option( 'zg_address_street' ) ); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label for="zg_address_city_state_zip">City, State, Zip</label></th>
                    <td><input type="text" id="zg_address_city_state_zip" name="zg_address_city_state_zip" value="<?php echo esc_attr( zg_get_site_option( 'zg_address_city_state_zip' ) ); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label for="zg_address_secondary">Secondary Note</label></th>
                    <td>
                        <textarea id="zg_address_secondary" name="zg_address_secondary" rows="2" class="regular-text"><?php echo esc_textarea( zg_get_site_option( 'zg_address_secondary' ) ); ?></textarea>
                        <p class="description">Shown below the address in the Contact &amp; Hours block. Use line breaks to split into two lines.</p>
                    </td>
                </tr>
                <tr>
                    <th><label for="zg_maps_url">Google Maps URL</label></th>
                    <td><input type="url" id="zg_maps_url" name="zg_maps_url" value="<?php echo esc_attr( zg_get_site_option( 'zg_maps_url' ) ); ?>" class="regular-text" /></td>
                </tr>
            </table>

            <h2>Store Hours</h2>
            <table class="form-table">
                <tr>
                    <th><label for="zg_hours_topbar">Top Bar Summary</label></th>
                    <td>
                        <input type="text" id="zg_hours_topbar" name="zg_hours_topbar" value="<?php echo esc_attr( zg_get_site_option( 'zg_hours_topbar' ) ); ?>" class="regular-text" />
                        <p class="description">Compact hours shown in the site top bar. E.g. <code>Mon–Thu 10am–6pm · Fri 10am–5pm</code></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="zg_hours_mon_thu">Monday – Thursday</label></th>
                    <td><input type="text" id="zg_hours_mon_thu" name="zg_hours_mon_thu" value="<?php echo esc_attr( zg_get_site_option( 'zg_hours_mon_thu' ) ); ?>" class="regular-text" placeholder="e.g. 10:00 am – 6:00 pm" /></td>
                </tr>
                <tr>
                    <th><label for="zg_hours_fri">Friday</label></th>
                    <td><input type="text" id="zg_hours_fri" name="zg_hours_fri" value="<?php echo esc_attr( zg_get_site_option( 'zg_hours_fri' ) ); ?>" class="regular-text" placeholder="e.g. 10:00 am – 5:00 pm" /></td>
                </tr>
                <tr>
                    <th><label for="zg_hours_sat">Saturday</label></th>
                    <td><input type="text" id="zg_hours_sat" name="zg_hours_sat" value="<?php echo esc_attr( zg_get_site_option( 'zg_hours_sat' ) ); ?>" class="regular-text" placeholder="e.g. Closed" /></td>
                </tr>
                <tr>
                    <th><label for="zg_hours_sun">Sunday</label></th>
                    <td><input type="text" id="zg_hours_sun" name="zg_hours_sun" value="<?php echo esc_attr( zg_get_site_option( 'zg_hours_sun' ) ); ?>" class="regular-text" placeholder="e.g. Closed" /></td>
                </tr>
            </table>

            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}


// ─────────────────────────────────────────────
// Unified Nav Walker (Desktop + Mobile)
// ─────────────────────────────────────────────
class ZG_Nav_Walker extends Walker_Nav_Menu {

    private $is_mobile;
    private $current_parent;

    public function __construct( $is_mobile = false ) {
        $this->is_mobile = $is_mobile;
    }

    private function has_class( $item, $class ) {
        return in_array( $class, (array) $item->classes );
    }

    public function start_lvl( &$output, $depth = 0, $args = null ) {

        if ( $this->is_mobile ) {
            if ( $depth === 0 ) {
                $output .= '<ul class="mobile-sub-menu pl-4 pb-2 hidden">';
            } else {
                $output .= '<ul class="pl-4">';
            }
            return;
        }

        $is_mega = $this->current_parent && $this->has_class( $this->current_parent, 'mega-menu' );
        $is_simple = $this->current_parent && $this->has_class( $this->current_parent, 'simple' );
        if ( $depth === 0 ) {

            if ( $is_mega ) {
                $output .= '<ul class="nav-dropdown absolute left-0 top-full mt-3 w-175
                    opacity-0 invisible pointer-events-none
                    transition-all duration-200 z-50
                    rounded-2xl bg-brand-dark/95 backdrop-blur-xl border border-white/10 shadow-2xl p-6
                    columns-3 gap-x-6">';
            } elseif ($is_simple) {
                $output .= '<ul class="nav-dropdown absolute left-0 top-full mt-3 w-96
                    opacity-0 invisible pointer-events-none
                    transition-all duration-200 z-50
                    rounded-xl bg-brand-dark/95 backdrop-blur-md border border-white/10 shadow-xl p-3
                    columns-1 gap-x-2">';
            } else {
                $output .= '<ul class="nav-dropdown absolute left-0 top-full mt-3 w-96
                    opacity-0 invisible pointer-events-none
                    transition-all duration-200 z-50
                    rounded-xl bg-brand-dark/95 backdrop-blur-md border border-white/10 shadow-xl p-3
                    columns-2 gap-x-2">';
            }
        } elseif ( $depth === 1 ) {
            $output .= '<ul class="pl-3">';
        }
    }

    public function end_lvl( &$output, $depth = 0, $args = null ) {

        if ( $this->is_mobile ) {
            $output .= '</ul>';
            return;
        }

        if ( $depth === 0 || $depth === 1 ) {
            $output .= '</ul>';
        }
    }

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {

        if ( $depth === 0 ) {
            $this->current_parent = $item;
        }

        $is_blank   = $item->target === '_blank';
        $target_attr = $is_blank ? ' target="_blank" rel="noopener noreferrer"' : '';
        $ext_icon   = $is_blank
            ? '<svg class="w-3 h-3 inline-block ml-1 opacity-60 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>'
            : '';

        if ( $depth === 0 && ! $this->is_mobile ) {

            $has_children = $this->has_class( $item, 'menu-item-has-children' );

            $output .= '<li class="relative list-none nav-item">';

            if ( $has_children ) {
                $output .= '<button type="button" class="flex items-center gap-1 px-3 py-2 text-sm font-medium text-white/85 hover:text-white rounded-lg hover:bg-white/10 transition">';
                $output .= esc_html( $item->title );
                $output .= '<svg class="w-3.5 h-3.5 opacity-60 transition-transform duration-200 nav-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>';
                $output .= '</button>';
            } elseif ( $this->has_class( $item, 'button-taupe' ) ) {
                $output .= '<a href="' . esc_url( $item->url ) . '"' . $target_attr . ' class="px-4 py-2.5 bg-brand-taupe-light text-brand-dark text-xs font-semibold rounded-full hover:bg-white transition-all shadow-lg hover:scale-105 whitespace-nowrap">';
                $output .= esc_html( $item->title ) . $ext_icon;
                $output .= '</a>';
            } elseif ( $this->has_class( $item, 'button-ghost' ) ) {
                $output .= '<a href="' . esc_url( $item->url ) . '"' . $target_attr . ' class="px-4 py-2.5 bg-transparent text-white text-xs font-semibold rounded-full border border-white/40 hover:bg-white/10 hover:border-white/70 transition-all whitespace-nowrap">';
                $output .= esc_html( $item->title ) . $ext_icon;
                $output .= '</a>';
            } else {
                $output .= '<a href="' . esc_url( $item->url ) . '"' . $target_attr . ' class="inline-flex items-center px-3 py-2 text-sm font-medium text-white/85 hover:text-white rounded-lg hover:bg-white/10 transition whitespace-nowrap">';
                $output .= esc_html( $item->title ) . $ext_icon;
                $output .= '</a>';
            }
        }

        elseif ( $depth === 0 && $this->is_mobile ) {

            $has_children = $this->has_class( $item, 'menu-item-has-children' );

            $output .= '<li class="border-b border-white/10">';

            if ( $has_children ) {
                $output .= '<button type="button" class="mobile-accordion-btn flex items-center justify-between w-full text-white/80 hover:text-white py-4 text-base font-medium text-left">';
                $output .= '<span>' . esc_html( $item->title ) . '</span>';
                $output .= '<svg class="mobile-chevron w-4 h-4 opacity-50 transition-transform duration-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>';
                $output .= '</button>';
            } else {
                $output .= '<a href="' . esc_url( $item->url ) . '"' . $target_attr . ' class="flex items-center justify-between text-white/80 hover:text-white py-4 text-base font-medium">';
                $output .= '<span>' . esc_html( $item->title ) . $ext_icon . '</span>';
                $output .= '</a>';
            }
        }

        else {

            $is_mega_child = $this->current_parent && $this->has_class( $this->current_parent, 'mega-menu' );
            $output .= $is_mega_child ? '<li class="break-inside-avoid">' : '<li>';

            if ( $this->has_class( $item, 'manage-account' ) ) {
                $output .= '<a href="' . esc_url( $item->url ) . '"' . $target_attr . ' class="inline-flex items-center px-4 py-2 text-xs font-semibold rounded-full whitespace-nowrap shadow-lg hover:scale-105 transition-all" style="background:linear-gradient(135deg,#8A8178,#B7AFA3,#E8DED2);color:#3D4A3E;">';
                $output .= esc_html( $item->title ) . $ext_icon;
                $output .= '</a>';
            } else {
                $output .= '<a href="' . esc_url( $item->url ) . '"' . $target_attr . ' class="block px-3 py-2 rounded-lg text-sm text-white/70 hover:text-white hover:bg-white/10 transition">';
                $output .= esc_html( $item->title ) . $ext_icon;
                $output .= '</a>';
            }
        }
    }

    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= '</li>';
    }
}


// ─────────────────────────────────────────────
// PERFORMANCE OPTIMIZATIONS
// ─────────────────────────────────────────────

add_action( 'wp_enqueue_scripts', function () {

    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'global-styles' );

    wp_dequeue_script( 'wp-embed' );
    wp_dequeue_script( 'wp-polyfill' );

    if (
        ! is_cart() &&
        ! is_checkout() &&
        ! is_account_page() &&
        ! is_shop() &&
        ! is_product() &&
        ! is_product_category()
    ) {
        wp_dequeue_script( 'wc-cart-fragments' );
        wp_dequeue_script( 'wc-add-to-cart' );
        wp_dequeue_script( 'woocommerce' );

        wp_dequeue_script( 'wc-blocks' );
        wp_dequeue_script( 'wc-blocks-registry' );
        wp_dequeue_script( 'wc-settings' );
        wp_dequeue_script( 'wc-cart-checkout-base' );
        wp_dequeue_script( 'wc-cart-checkout-vendors' );

        wp_dequeue_style( 'woocommerce-general' );
        wp_dequeue_style( 'woocommerce-layout' );
        wp_dequeue_style( 'woocommerce-smallscreen' );
        wp_dequeue_style( 'wc-blocks-style' );
        wp_dequeue_style( 'wc-blocks' );
    }

}, 100 );


add_action( 'wp_default_scripts', function ( $scripts ) {
    if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
        $scripts->registered['jquery']->deps = array_diff(
            $scripts->registered['jquery']->deps,
            ['jquery-migrate']
        );
    }
} );


add_action( 'wp_enqueue_scripts', function () {
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', includes_url( '/js/jquery/jquery.min.js' ), [], null, true );
    wp_enqueue_script( 'jquery' );
} );


add_filter( 'style_loader_tag', function ( $html, $handle ) {
    if ( $handle !== 'zg-google-fonts' ) {
        return $html;
    }
    return str_replace(
        "rel='stylesheet'",
        "rel='preload' as='style' onload=\"this.onload=null;this.rel='stylesheet'\"",
        $html
    );
}, 10, 2 );


// ─────────────────────────────────────────────
// WebP auto-conversion for new uploads (WP 5.8+)
// ─────────────────────────────────────────────
add_filter( 'image_editor_output_format', function ( $formats ) {
    $formats['image/jpeg'] = 'image/webp';
    $formats['image/png']  = 'image/webp';
    return $formats;
} );
