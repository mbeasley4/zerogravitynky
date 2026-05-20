<?php
$custom_logo_id = get_theme_mod( 'custom_logo' );
$logo_src       = $custom_logo_id
    ? wp_get_attachment_image_url( $custom_logo_id, 'full' )
    : 'https://zerogravitynky.com/wp-content/uploads/2022/07/ZGA_logo_final_horiz-white-copy-2-600x91.png';
$site_name = get_bloginfo( 'name' );
?>
<style>
.nav-item.is-open > .nav-dropdown {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
    transform: translateY(0);
}
</style>
<nav id="navbar" class="fixed left-0 right-0 z-50 bg-transparent">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">
        <div class="flex items-center justify-between h-18 py-3">

            <!-- Logo -->
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center group shrink-0" rel="home">
                <img src="<?php echo esc_url( $logo_src ); ?>"
                     alt="<?php echo esc_attr( $site_name ); ?>"
                     class="site-logo h-10 w-auto group-hover:opacity-90 transition-opacity" />
            </a>

            <!-- Desktop Nav -->
            <nav class="hidden lg:flex items-center shrink-0" aria-label="Primary navigation">
                <?php
                wp_nav_menu( [
                    'theme_location' => 'primary',
                    'container'      => false,
                    'items_wrap'     => '<ul class="flex items-center gap-1 flex-nowrap m-0 p-0 list-none">%3$s</ul>',
                    'walker'         => new ZG_Nav_Walker( false ),
                    'fallback_cb'    => false,
                ] );
                ?>
            </nav><!-- end desktop nav -->

            <!-- Mobile hamburger -->
            <button id="menu-btn" class="lg:hidden text-white p-3 -mr-1 rounded-xl hover:bg-white/10 transition active:scale-95" aria-label="Open menu">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

</nav>

<!-- Mobile overlay (outside nav to avoid fixed-in-fixed stacking issues) -->
<div id="mobile-overlay" class="lg:hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-40 opacity-0 pointer-events-none transition-opacity duration-300"></div>

<!-- Mobile drawer (outside nav to avoid fixed-in-fixed stacking issues) -->
<div id="mobile-menu" class="lg:hidden fixed top-0 -right-full h-full w-80 max-w-[85vw] z-50 flex flex-col transition-transform duration-300 ease-in-out bg-brand-dark/97 backdrop-blur-xl">

    <!-- Drawer header: logo + close -->
    <div class="flex items-center justify-between px-6 py-5 shrink-0 border-b border-white/10">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center" rel="home">
            <img src="<?php echo esc_url( $logo_src ); ?>"
                 alt="<?php echo esc_attr( $site_name ); ?>"
                 class="h-8 w-auto" />
        </a>
        <button id="menu-close" class="text-white/60 hover:text-white p-3 -mr-3 rounded-xl hover:bg-white/10 transition active:scale-95" aria-label="Close menu">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Scrollable nav -->
    <div class="flex-1 overflow-y-auto px-5 py-3">
        <?php
        wp_nav_menu( [
            'theme_location' => 'primary',
            'container'      => false,
            'items_wrap'     => '<ul class="m-0 p-0 list-none" aria-label="Mobile navigation">%3$s</ul>',
            'walker'         => new ZG_Nav_Walker(true),
            'fallback_cb'    => false,
        ] );
        ?>

        <a href="tel:8593443250" class="flex items-center gap-2 text-white/60 hover:text-white py-4 border-b border-white/10 text-sm">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
            </svg>
            (859) 344-3250
        </a>
    </div>
</div>
