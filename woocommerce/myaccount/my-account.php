<?php
/**
 * My Account page — ZG theme override.
 * Overrides woocommerce/templates/myaccount/my-account.php
 */

defined( 'ABSPATH' ) || exit;

$current_user = wp_get_current_user();
$first_name   = $current_user->first_name ?: $current_user->display_name;
$endpoint     = WC()->query->get_current_endpoint();
$endpoint     = $endpoint ?: 'dashboard';

// Map endpoints → page titles & icons
$page_meta = [
    'dashboard'       => [ 'title' => 'My Dashboard',      'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' ],
    'orders'          => [ 'title' => 'My Orders',          'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2' ],
    'view-order'      => [ 'title' => 'Order Details',      'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2' ],
    'edit-address'    => [ 'title' => 'Addresses',          'icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z' ],
    'payment-methods' => [ 'title' => 'Payment Methods',   'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z' ],
    'edit-account'    => [ 'title' => 'Account Details',   'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z' ],
    'downloads'       => [ 'title' => 'Downloads',         'icon' => 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4' ],
    'customer-logout' => [ 'title' => 'Logout',            'icon' => 'M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1' ],
];

$page_title = $page_meta[ $endpoint ]['title'] ?? 'My Account';
$page_icon  = $page_meta[ $endpoint ]['icon']  ?? $page_meta['dashboard']['icon'];
?>

<div id="main-content">

    <!-- ── Account Hero ──────────────────────────────────────────── -->
    <section class="zg-account-hero">
        <div class="absolute -top-16 -left-16 w-72 h-72 rounded-full opacity-20 blur-3xl pointer-events-none" style="background:#B7AFA3;"></div>
        <div class="absolute -bottom-16 -right-16 w-96 h-96 rounded-full opacity-15 blur-3xl pointer-events-none" style="background:#94A995;"></div>
        <div class="absolute inset-0 opacity-[0.05] pointer-events-none" style="background-image:radial-gradient(circle,rgba(255,255,255,.5) 1px,transparent 1px);background-size:32px 32px;"></div>

        <div class="relative max-w-7xl mx-auto px-5 lg:px-8 flex items-center gap-5">
            <!-- Avatar initials -->
            <div class="zg-account-avatar" aria-hidden="true">
                <?php echo esc_html( strtoupper( substr( $first_name, 0, 1 ) ) ); ?>
            </div>
            <div>
                <p class="zg-account-greeting">Welcome back</p>
                <h1 class="zg-account-name"><?php echo esc_html( $first_name ); ?></h1>
            </div>
        </div>
    </section>

    <!-- ── Account Layout ────────────────────────────────────────── -->
    <div class="zg-account-wrap">

        <!-- Sidebar nav -->
        <?php do_action( 'woocommerce_account_navigation' ); ?>

        <!-- Content panel -->
        <main class="zg-account-content">

            <!-- Section header -->
            <div class="zg-account-section-header">
                <div class="zg-account-section-icon" aria-hidden="true">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="<?php echo esc_attr( $page_icon ); ?>"/>
                    </svg>
                </div>
                <h2 class="zg-account-section-title"><?php echo esc_html( $page_title ); ?></h2>
            </div>

            <div class="woocommerce-MyAccount-content">
                <?php do_action( 'woocommerce_account_content' ); ?>
            </div>

        </main>

    </div>

</div>
