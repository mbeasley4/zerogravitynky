<?php
$zg_phone     = zg_get_site_option( 'zg_phone' );
$zg_phone_raw = preg_replace( '/[^0-9]/', '', $zg_phone );
$zg_email     = zg_get_site_option( 'zg_email' );
$zg_hours_topbar = zg_get_site_option( 'zg_hours_topbar' );
?>
<div class="fixed left-0 right-0 z-50 bg-brand-dark/90 backdrop-blur-sm border-b border-white/10 hidden lg:block" id="topbar">
    <div class="max-w-7xl mx-auto px-5 lg:px-8 flex items-center justify-between h-9">
        <div class="flex items-center gap-5">
            <a href="tel:<?php echo esc_attr( $zg_phone_raw ); ?>" class="flex items-center gap-1.5 text-white/60 hover:text-white text-xs transition-colors">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                <?php echo esc_html( $zg_phone ); ?>
            </a>
            <a href="mailto:<?php echo esc_attr( $zg_email ); ?>" class="flex items-center gap-1.5 text-white/60 hover:text-white text-xs transition-colors">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <?php echo esc_html( $zg_email ); ?>
            </a>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-white/40 text-xs"><?php echo esc_html( $zg_hours_topbar ); ?></span>
            <div class="flex items-center gap-3">
                <?php if ( function_exists( 'wc_get_cart_url' ) ) : ?>
                <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="relative text-white/50 hover:text-white transition-colors" aria-label="Cart">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 7H4l1-7z"/>
                    </svg>
                    <?php $count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?>
                    <?php if ( $count > 0 ) : ?>
                    <span class="absolute -top-1.5 -right-1.5 w-3.5 h-3.5 bg-brand-taupe rounded-full text-white text-[9px] font-bold flex items-center justify-center leading-none">
                        <?php echo esc_html( $count ); ?>
                    </span>
                    <?php endif; ?>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
