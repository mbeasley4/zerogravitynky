<?php
/**
 * Dynamic render for zerogravitynky/zg-gift-card block.
 * variant: 'dark' (default)  = purple gradient, white text
 * variant: 'light'           = lavender bg, dark text
 */
defined( 'ABSPATH' ) || exit;

$headline  = ! empty( $attributes['headline'] ) ? $attributes['headline'] : 'Give the Gift of Beauty';
$subtext   = ! empty( $attributes['subtext'] )  ? $attributes['subtext']  : '';
$cta_label = ! empty( $attributes['ctaLabel'] ) ? $attributes['ctaLabel'] : 'Shop Gift Cards';
$cta_url   = home_url( '/product/gift-card/' );
$is_dark   = ( ( $attributes['variant'] ?? 'dark' ) === 'dark' );

$wrapper_attrs = get_block_wrapper_attributes();

if ( $is_dark ) :
    // ── Dark variant (default) ────────────────────────────────────
?>
<section <?php echo $wrapper_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
    <div class="relative py-20 overflow-hidden text-white text-center" style="background: linear-gradient(135deg, #3D4A3E 0%, #7A8F7B 55%, #94A995 100%);">
        <div class="absolute -top-16 -left-16 w-72 h-72 rounded-full opacity-20 blur-3xl pointer-events-none" style="background: #B7AFA3;"></div>
        <div class="absolute -bottom-16 -right-16 w-96 h-96 rounded-full opacity-15 blur-3xl pointer-events-none" style="background: #94A995;"></div>
        <div class="absolute inset-0 opacity-[0.06] pointer-events-none" style="background-image: radial-gradient(circle, rgba(255,255,255,0.5) 1px, transparent 1px); background-size: 32px 32px;"></div>

        <div class="relative max-w-2xl mx-auto px-6">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl mb-6" style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2);">
                <svg class="w-7 h-7 text-brand-taupe" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 12v10H4V12M22 7H2v5h20V7zM12 22V7M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7zM12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/>
                </svg>
            </div>
            <h2 class="font-serif text-4xl md:text-5xl font-bold mb-4 leading-tight" style="color:#fff;">
                <?php echo esc_html( $headline ); ?>
            </h2>
            <?php if ( $subtext ) : ?>
            <p class="text-lg mb-10 leading-relaxed" style="color:rgba(255,255,255,0.80); margin-bottom:2.5rem;">
                <?php echo esc_html( $subtext ); ?>
            </p>
            <?php endif; ?>
            <a href="<?php echo esc_url( $cta_url ); ?>"
               class="inline-flex items-center gap-2 px-10 py-4 rounded-full font-semibold shadow-lg hover:scale-105 transition-transform"
               style="background: linear-gradient(135deg, #8A8178, #B7AFA3, #E8DED2); color: #3D4A3E;">
                <?php echo esc_html( $cta_label ); ?>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>

<?php else : // ── Light variant ─────────────────────────────────────────────── ?>

<section <?php echo $wrapper_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
    <div class="relative py-14 overflow-hidden bg-brand-sand">
        <div class="absolute -top-16 -right-16 w-64 h-64 rounded-full bg-brand-sage/10 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-16 -left-16 w-64 h-64 rounded-full bg-brand-taupe/10 blur-3xl pointer-events-none"></div>

        <div class="relative max-w-7xl mx-auto px-5 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-8 lg:gap-16 justify-between">

                <div class="flex items-start gap-5 text-center lg:text-left flex-col sm:flex-row sm:items-center lg:items-start">
                    <div class="w-14 h-14 rounded-2xl bg-brand-sage/15 flex items-center justify-center flex-shrink-0 mx-auto sm:mx-0">
                        <svg class="w-7 h-7 text-brand-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12v10H4V12M22 7H2v5h20V7zM12 22V7M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7zM12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-serif text-2xl lg:text-3xl text-brand-dark font-semibold mb-2">
                            <?php echo esc_html( $headline ); ?>
                        </h2>
                        <?php if ( $subtext ) : ?>
                        <p class="text-brand-gray text-base max-w-xl leading-relaxed" style="margin-bottom:0;">
                            <?php echo esc_html( $subtext ); ?>
                        </p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="flex-shrink-0 text-center">
                    <a href="<?php echo esc_url( $cta_url ); ?>"
                       class="inline-flex items-center gap-2 px-8 py-4 font-semibold rounded-full shadow-lg hover:scale-105 transition-transform whitespace-nowrap text-white"
                       style="background: linear-gradient(135deg, #7A8F7B, #94A995);">
                        <?php echo esc_html( $cta_label ); ?>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>

<?php endif; ?>
