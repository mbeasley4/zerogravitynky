<?php
/**
 * Front Page Block Seeder
 *
 * Writes serialized Gutenberg block markup for the ZG Homepage Hero,
 * ZG Marquee Strip, and ZG Services Section blocks into the WordPress
 * front page post, so those sections become editable in the block editor.
 *
 * Usage (from WordPress root):
 *
 *   wp eval-file wp-content/themes/zerogravitynky/tools/seed-front-page.php
 *
 * Options (pass as plain words after the file path):
 *
 *   dry-run    Preview the block markup without writing to the database.
 *   force      Overwrite even when the front page already has block content.
 *
 * Examples:
 *   wp eval-file .../tools/seed-front-page.php dry-run
 *   wp eval-file .../tools/seed-front-page.php force
 */

if ( ! defined( 'ABSPATH' ) || ! class_exists( 'WP_CLI' ) ) {
    exit( "Run via: wp eval-file path/to/seed-front-page.php\n" );
}

$dry_run = in_array( 'dry-run', $args, true );
$force   = in_array( 'force',   $args, true );

// ─────────────────────────────────────────────
// 1. Locate the front page
// ─────────────────────────────────────────────
$front_page_id = (int) get_option( 'page_on_front' );

if ( ! $front_page_id ) {
    WP_CLI::error( 'No static front page is set. Go to Settings › Reading and choose a static front page first.' );
}

$post = get_post( $front_page_id );
if ( ! $post ) {
    WP_CLI::error( "Could not load post ID {$front_page_id}." );
}

WP_CLI::log( "Front page: \"{$post->post_title}\" (ID {$front_page_id})" );

// ─────────────────────────────────────────────
// 2. Guard against overwriting existing content
// ─────────────────────────────────────────────
if ( ! empty( trim( $post->post_content ) ) && ! $force ) {
    WP_CLI::warning( 'The front page already has content. Pass `force` to overwrite it.' );
    WP_CLI::log( '' );
    WP_CLI::log( 'Current post_content:' );
    WP_CLI::log( substr( $post->post_content, 0, 400 ) . ( strlen( $post->post_content ) > 400 ? ' …' : '' ) );
    exit;
}

// ─────────────────────────────────────────────
// 3. Build block data
// ─────────────────────────────────────────────

/** Helper: build a self-closing dynamic block comment */
function zg_block( string $name, array $attrs ): string {
    $json = wp_json_encode( $attrs, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
    return "<!-- wp:{$name} {$json} /-->";
}

// --- Homepage Hero ---
$hero_block = zg_block( 'zerogravitynky/homepage-hero', [
    'badge'          => 'Voted Best Med Spa in Northern Kentucky',
    'headlineLine1'  => 'Reveal Your',
    'headlineAccent' => 'Most Radiant',
    'headlineLine3'  => 'Self',
    'subheadline'    => "Northern Kentucky's premier medical spa — operated by nurse practitioners and RNs with 20+ years of combined expertise.",
    'ctaLabel1'      => 'Book a Consultation',
    'ctaUrl1'        => '/zg-wellness-dermatology-services/',
    'ctaLabel2'      => 'View Services',
    'ctaUrl2'        => '#services',
    'imageId'        => 0,
    'imageUrl'       => '',   // leave blank — render.php falls back to /images/hero-img.png
    'imageAlt'       => 'Voted Best Med Spa in Northern Kentucky',
] );

// --- Marquee Strip ---
$marquee_block = zg_block( 'zerogravitynky/marquee-strip', [
    'items' => [
        'Botox & Fillers',
        'Custom Facials & Peels',
        'Laser Hair Removal',
        'Body Contouring',
        'IV Therapy & Wellness',
        'Weight Loss Programs',
        'Spray Tan',
        'Eyelash Extensions',
        'Memberships Available',
        'ZG Aesthetics Academy',
    ],
] );

// --- Services Section ---
$services_block = zg_block( 'zerogravitynky/services-section', [
    'sectionTitle' => '',
    'services'     => [
        [
            'imageUrl'    => 'https://zerogravitynky.com/wp-content/uploads/2026/03/zero-gravity-hero-mobile.png',
            'imageAlt'    => 'Botox & Dermal Fillers',
            'imageId'     => 0,
            'title'       => 'Botox & Dermal Fillers',
            'description' => 'Smooth fine lines and restore youthful volume with wrinkle-relaxing Botox and precision dermal fillers.',
            'linkUrl'     => '/zg-wellness-dermatology-services/',
            'linkText'    => 'Learn More',
        ],
        [
            'imageUrl'    => 'https://zerogravitynky.com/wp-content/uploads/2024/02/ZGW_DermatologyServices_Home-600x600.jpg',
            'imageAlt'    => 'Facials & Chemical Peels',
            'imageId'     => 0,
            'title'       => 'Facials & Chemical Peels',
            'description' => 'Custom-crafted facials and medical-grade chemical peels that resurface and nourish your skin.',
            'linkUrl'     => '/zg-wellness-dermatology-services/',
            'linkText'    => 'Learn More',
        ],
        [
            'imageUrl'    => 'https://zerogravitynky.com/wp-content/uploads/2026/03/zero-gravity-hero-mobile.png',
            'imageAlt'    => 'Laser Hair Removal',
            'imageId'     => 0,
            'title'       => 'Laser Hair Removal',
            'description' => 'Long-lasting smoothness with advanced laser treatments for all skin types.',
            'linkUrl'     => '/zg-wellness-dermatology-services/',
            'linkText'    => 'Learn More',
        ],
        [
            'imageUrl'    => 'https://zerogravitynky.com/wp-content/uploads/2026/03/zero-gravity-hero-mobile.png',
            'imageAlt'    => 'Body Contouring',
            'imageId'     => 0,
            'title'       => 'Body Contouring',
            'description' => 'Non-invasive body sculpting treatments that reshape and tone without surgery.',
            'linkUrl'     => '/product-category/body-contouring/',
            'linkText'    => 'Learn More',
        ],
        [
            'imageUrl'    => 'https://zerogravitynky.com/wp-content/uploads/2026/03/zero-gravity-hero-mobile.png',
            'imageAlt'    => 'IV Therapy & Wellness',
            'imageId'     => 0,
            'title'       => 'IV Therapy & Wellness',
            'description' => 'Replenish and recharge with customized IV infusions for fast, effective results.',
            'linkUrl'     => '/wellness/',
            'linkText'    => 'Learn More',
        ],
        [
            'imageUrl'    => 'https://zerogravitynky.com/wp-content/uploads/2023/01/weightlossinjections_homepage-600x480.jpg',
            'imageAlt'    => 'Weight Loss Programs',
            'imageId'     => 0,
            'title'       => 'Weight Loss Programs',
            'description' => 'Medically supervised weight loss with personalized plans and real results.',
            'linkUrl'     => '/wellness/',
            'linkText'    => 'Learn More',
        ],
    ],
] );

// Assemble final post_content — one block per line
$post_content = implode( "\n\n", [ $hero_block, $marquee_block, $services_block ] );

// ─────────────────────────────────────────────
// 4. Preview or write
// ─────────────────────────────────────────────
if ( $dry_run ) {
    WP_CLI::log( '' );
    WP_CLI::log( '=== DRY RUN — block markup that would be written ===' );
    WP_CLI::log( '' );

    foreach ( [ 'Homepage Hero' => $hero_block, 'Marquee Strip' => $marquee_block, 'Services Section' => $services_block ] as $label => $markup ) {
        WP_CLI::log( "── {$label} ──" );
        WP_CLI::log( substr( $markup, 0, 300 ) . ( strlen( $markup ) > 300 ? ' …' : '' ) );
        WP_CLI::log( '' );
    }

    WP_CLI::success( 'Dry run complete. Re-run without `dry-run` to write to the database.' );
    exit;
}

// ─────────────────────────────────────────────
// 5. Write to database
// ─────────────────────────────────────────────
$result = wp_update_post( [
    'ID'           => $front_page_id,
    'post_content' => $post_content,
], true );

if ( is_wp_error( $result ) ) {
    WP_CLI::error( 'wp_update_post failed: ' . $result->get_error_message() );
}

WP_CLI::success( "Front page (ID {$front_page_id}) updated with 3 blocks:" );
WP_CLI::log( '  • ZG Homepage Hero' );
WP_CLI::log( '  • ZG Marquee Strip' );
WP_CLI::log( '  • ZG Services Section' );
WP_CLI::log( '' );
WP_CLI::log( 'Edit them at: ' . admin_url( "post.php?post={$front_page_id}&action=edit" ) );
