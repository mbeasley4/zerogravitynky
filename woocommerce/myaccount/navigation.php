<?php
/**
 * My Account navigation — ZG theme override.
 * Overrides woocommerce/templates/myaccount/navigation.php
 */

defined( 'ABSPATH' ) || exit;

// Icons keyed by endpoint slug
$nav_icons = [
    'dashboard'       => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
    'orders'          => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
    'edit-address'    => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z',
    'payment-methods' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z',
    'edit-account'    => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
    'downloads'       => 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4',
    'customer-logout' => 'M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1',
];

do_action( 'woocommerce_before_account_navigation' );
?>

<nav class="zg-account-nav" aria-label="<?php esc_html_e( 'Account pages', 'woocommerce' ); ?>">
    <ul>
        <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) :
            $classes  = wc_get_account_menu_item_classes( $endpoint );
            $is_active = str_contains( $classes, 'is-active' );
            $icon_path = $nav_icons[ $endpoint ] ?? $nav_icons['dashboard'];
        ?>
        <li class="<?php echo esc_attr( $classes ); ?>">
            <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"
               class="zg-account-nav-link<?php echo $is_active ? ' active' : ''; ?>"
               <?php echo wc_is_current_account_menu_item( $endpoint ) ? 'aria-current="page"' : ''; ?>>
                <svg class="zg-account-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="<?php echo esc_attr( $icon_path ); ?>"/>
                </svg>
                <span><?php echo esc_html( $label ); ?></span>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
