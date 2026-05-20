<?php
$map_img_url      = !empty( $attributes['mapImageUrl'] )      ? $attributes['mapImageUrl']      : 'https://zerogravitynky.com/wp-content/uploads/2019/11/ZGMAP.jpg';
$map_img_alt      = !empty( $attributes['mapImageAlt'] )      ? $attributes['mapImageAlt']      : 'Zero Gravity location map — Crestview Hills Town Center';
$map_img_link     = !empty( $attributes['mapImageLink'] )     ? $attributes['mapImageLink']     : '';
$ext_img_url      = !empty( $attributes['exteriorImageUrl'] ) ? $attributes['exteriorImageUrl'] : 'https://zerogravitynky.com/wp-content/uploads/2025/07/zg-exterior-web2-e1752804466329-995x1024.png';
$ext_img_alt      = !empty( $attributes['exteriorImageAlt'] ) ? $attributes['exteriorImageAlt'] : 'Zero Gravity Med Spa exterior — Crestview Hills';
$ext_img_link     = !empty( $attributes['exteriorImageLink'] ) ? $attributes['exteriorImageLink'] : '';

// Site options — managed via Settings › Site Settings
$zg_phone              = zg_get_site_option( 'zg_phone' );
$zg_phone_raw          = preg_replace( '/[^0-9]/', '', $zg_phone );
$zg_address_street     = zg_get_site_option( 'zg_address_street' );
$zg_address_csz        = zg_get_site_option( 'zg_address_city_state_zip' );
$zg_address_secondary  = zg_get_site_option( 'zg_address_secondary' );
$zg_hours_mon_thu      = zg_get_site_option( 'zg_hours_mon_thu' );
$zg_hours_fri          = zg_get_site_option( 'zg_hours_fri' );
$zg_hours_sat          = zg_get_site_option( 'zg_hours_sat' );
$zg_hours_sun          = zg_get_site_option( 'zg_hours_sun' );

// Helper: determine the CSS class for an hours cell (muted when closed/empty).
$hours_class = function ( string $h ): string {
    return ( '' === $h || 0 === strcasecmp( 'closed', trim( $h ) ) )
        ? 'text-brand-gray/50'
        : 'text-brand-dark font-medium';
};
?>
<!-- ═══════════════════════════════════════════
     CONTACT & HOURS
═══════════════════════════════════════════ -->
<section id="contact" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">

        <div class="text-center mb-14 reveal">
            <div class="inline-flex items-center gap-2 text-brand-sage text-sm font-semibold uppercase tracking-widest mb-4">
                <span class="w-8 h-px bg-brand-sage"></span>Find Us<span class="w-8 h-px bg-brand-sage"></span>
            </div>
            <h2 class="font-serif text-4xl lg:text-5xl text-brand-dark font-bold">Visit Zero Gravity</h2>
        </div>

        <div class="grid lg:grid-cols-3 gap-8 mb-10">
            <!-- Location -->
            <div class="reveal bg-brand-sand rounded-2xl p-7">
                <div class="w-12 h-12 rounded-xl bg-brand-sage/10 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-brand-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 10.5c0 7.142-7.5 11.25-9.5 11.25S1.5 17.642 1.5 10.5a8.5 8.5 0 0117 0z"/></svg>
                </div>
                <h3 class="font-serif text-lg font-semibold text-brand-dark mb-2">Location</h3>
                <p class="text-brand-gray/70 text-sm leading-relaxed mb-3"><?php echo esc_html( $zg_address_street ); ?><br /><?php echo esc_html( $zg_address_csz ); ?></p>
                <p class="text-brand-gray/50 text-xs"><?php echo nl2br( esc_html( $zg_address_secondary ) ); ?></p>
            </div>

            <!-- Hours -->
            <div class="reveal bg-brand-sand rounded-2xl p-7" style="transition-delay:0.1s">
                <div class="w-12 h-12 rounded-xl bg-brand-sage/10 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-brand-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="font-serif text-lg font-semibold text-brand-dark mb-4">Hours</h3>
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-brand-gray/70">Monday – Thursday</span>
                        <span class="<?php echo esc_attr( $hours_class( $zg_hours_mon_thu ) ); ?>"><?php echo esc_html( $zg_hours_mon_thu ); ?></span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-brand-gray/70">Friday</span>
                        <span class="<?php echo esc_attr( $hours_class( $zg_hours_fri ) ); ?>"><?php echo esc_html( $zg_hours_fri ); ?></span>
                    </div>
                    <div class="h-px bg-brand-gray/10 my-2"></div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-brand-gray/70">Saturday</span>
                        <span class="<?php echo esc_attr( $hours_class( $zg_hours_sat ) ); ?>"><?php echo esc_html( $zg_hours_sat ); ?></span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-brand-gray/70">Sunday</span>
                        <span class="<?php echo esc_attr( $hours_class( $zg_hours_sun ) ); ?>"><?php echo esc_html( $zg_hours_sun ); ?></span>
                    </div>
                </div>
            </div>

            <!-- Contact -->
            <div class="reveal bg-brand-sand rounded-2xl p-7" style="transition-delay:0.2s">
                <div class="w-12 h-12 rounded-xl bg-brand-sage/10 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-brand-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                </div>
                <h3 class="font-serif text-lg font-semibold text-brand-dark mb-4">Contact</h3>
                <div class="space-y-4">
                    <div>
                        <div class="text-brand-gray/50 text-xs uppercase tracking-wider mb-1">Phone</div>
                        <a href="tel:<?php echo esc_attr( $zg_phone_raw ); ?>" class="text-brand-sage font-semibold text-base hover:text-brand-mid transition-colors"><?php echo esc_html( $zg_phone ); ?></a>
                    </div>
                    <div>
                        <div class="text-brand-gray/50 text-xs uppercase tracking-wider mb-1">Book Online</div>
                        <a href="<?php echo esc_url( home_url( '/zg-wellness-dermatology-services/' ) ); ?>" class="text-brand-sage font-semibold text-sm hover:text-brand-mid transition-colors underline underline-offset-2">
                            Schedule a Visit →
                        </a>
                    </div>
                    <div>
                        <div class="text-brand-gray/50 text-xs uppercase tracking-wider mb-1">Social</div>
                        <a href="https://www.facebook.com/zerogravitynky/" target="_blank" rel="noopener" class="text-brand-gray/60 text-sm hover:text-brand-sage transition-colors">
                            Facebook · @zerogravitynky
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <?php $directions_url = $map_img_link ?: zg_get_site_option( 'zg_maps_url' ); ?>
        <div class="reveal grid lg:grid-cols-2 gap-6">
            <div class="flex flex-col gap-3">
                <div class="rounded-2xl overflow-hidden shadow-md border border-brand-sand h-100 relative group">
                    <?php if ( $map_img_link ) : ?>
                    <a href="<?php echo esc_url( $map_img_link ); ?>" target="_blank" rel="noopener noreferrer" class="block w-full h-full" aria-label="<?php echo esc_attr( $map_img_alt ); ?>">
                    <?php endif; ?>
                    <img src="<?php echo esc_url( $map_img_url ); ?>"
                         alt="<?php echo esc_attr( $map_img_alt ); ?>"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                    <?php if ( $map_img_link ) : ?></a><?php endif; ?>
                </div>
                <div class="flex justify-center">
                    <a href="<?php echo esc_url( $directions_url ); ?>" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 bg-brand-taupe text-white font-semibold text-sm px-6 py-3 rounded-full shadow-lg hover:brightness-110 transition-all duration-200">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 10.5c0 7.142-7.5 11.25-9.5 11.25S1.5 17.642 1.5 10.5a8.5 8.5 0 0117 0z"/></svg>
                        Get Directions
                    </a>
                </div>
            </div>
            <div class="flex flex-col gap-3">
                <div class="rounded-2xl overflow-hidden shadow-md border border-brand-sand h-100 relative group">
                    <?php if ( $ext_img_link ) : ?>
                    <a href="<?php echo esc_url( $ext_img_link ); ?>" target="_blank" rel="noopener noreferrer" class="block w-full h-full" aria-label="<?php echo esc_attr( $ext_img_alt ); ?>">
                    <?php endif; ?>
                    <img src="<?php echo esc_url( $ext_img_url ); ?>"
                         alt="<?php echo esc_attr( $ext_img_alt ); ?>"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                         style="object-position: center 20%;" />
                    <div class="absolute inset-0 bg-linear-to-t from-brand-dark/50 to-transparent pointer-events-none"></div>
                    <div class="absolute bottom-4 left-4 pointer-events-none">
                        <div class="text-white font-semibold text-sm">Zero Gravity Med Spa</div>
                        <div class="text-white/70 text-xs"><?php echo esc_html( $zg_address_street . ', ' . $zg_address_csz ); ?></div>
                    </div>
                    <?php if ( $ext_img_link ) : ?></a><?php endif; ?>
                </div>
                <div class="flex justify-center">
                    <a href="<?php echo esc_url( $directions_url ); ?>" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 bg-brand-sage text-white font-semibold text-sm px-6 py-3 rounded-full shadow-lg hover:brightness-125 transition-all duration-200">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 10.5c0 7.142-7.5 11.25-9.5 11.25S1.5 17.642 1.5 10.5a8.5 8.5 0 0117 0z"/></svg>
                        Get Directions
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>