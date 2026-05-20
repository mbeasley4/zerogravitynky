<?php
/**
 * Dynamic render for zerogravitynky/zg-book-appointment block.
 * variant: 'dark' (default)  = deep sage gradient, white text
 * variant: 'light'           = sand bg, dark text
 *
 * ADA contrast targets (WCAG 2.1 AA):
 *   - Normal text  ≥ 4.5 : 1
 *   - Large text   ≥ 3.0 : 1   (h2 at 36px+ qualifies)
 *   - UI components ≥ 3.0 : 1
 */
defined( 'ABSPATH' ) || exit;

$headline  = ! empty( $attributes['headline'] ) ? $attributes['headline'] : 'Request an Appointment';
$subtext   = ! empty( $attributes['subtext'] )  ? $attributes['subtext']  : '';
$cta_label = ! empty( $attributes['ctaLabel'] ) ? $attributes['ctaLabel'] : 'Book Now';
$cta_url   = ! empty( $attributes['ctaUrl'] )   ? $attributes['ctaUrl']   : 'https://web2.myaestheticspro.com/booknow/index.cfm?A4E84A7CF274D7120B24A83F9BCC94DE';
$is_dark   = ( ( $attributes['variant'] ?? 'dark' ) === 'dark' );

$wrapper_attrs  = get_block_wrapper_attributes();
$cta_aria_label = esc_attr( $cta_label . ' — opens in a new tab' );

if ( $is_dark ) :
    /*
     * Dark variant
     * Background darkened to #1E2B1F→#2D3A2E→#3D4A3E so every text token passes.
     *   white (#fff)    on #2D3A2E  → 11.9 : 1  ✓
     *   #D0D8D1 subtext on #2D3A2E  →  8.4 : 1  ✓
     *   #1E2B1F on #fff (button)    → 14.8 : 1  ✓
     */
?>
<section <?php echo $wrapper_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
    <div class="relative py-20 overflow-hidden text-center"
         style="background: linear-gradient(135deg, #1E2B1F 0%, #2D3A2E 50%, #3D4A3E 100%); border-top: 3px solid #B7AFA3;">

        <div aria-hidden="true" class="absolute -top-20 -left-20 w-80 h-80 rounded-full opacity-25 blur-3xl pointer-events-none" style="background: #B7AFA3;"></div>
        <div aria-hidden="true" class="absolute -bottom-20 -right-20 w-96 h-96 rounded-full opacity-20 blur-3xl pointer-events-none" style="background: #4A5C4B;"></div>
        <div aria-hidden="true" class="absolute inset-0 pointer-events-none" style="opacity: 0.04; background-image: radial-gradient(circle, rgba(255,255,255,0.7) 1px, transparent 1px); background-size: 28px 28px;"></div>

        <div class="relative max-w-2xl mx-auto px-6">
            <div aria-hidden="true"
                 class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-6"
                 style="background: rgba(183,175,163,0.18); border: 1.5px solid rgba(183,175,163,0.35);">
                <svg width="32" height="32" fill="none" stroke="#E8DED2" viewBox="0 0 24 24"
                     stroke-width="1.75" aria-hidden="true" focusable="false">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
            </div>

            <h2 class="font-serif text-4xl md:text-5xl font-bold mb-4 leading-tight"
                style="color: #ffffff; letter-spacing: -0.02em;">
                <?php echo esc_html( $headline ); ?>
            </h2>

            <?php if ( $subtext ) : ?>
            <p class="text-lg leading-relaxed"
               style="color: #D0D8D1; margin-bottom: 2.5rem;">
                <?php echo esc_html( $subtext ); ?>
            </p>
            <?php endif; ?>

            <a href="<?php echo esc_url( $cta_url ); ?>"
               target="_blank"
               rel="noopener noreferrer"
               aria-label="<?php echo $cta_aria_label; ?>"
               class="inline-flex items-center gap-2 px-10 py-4 rounded-full font-semibold shadow-xl
                      hover:shadow-2xl hover:scale-105 transition-all duration-200
                      focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-white focus-visible:ring-offset-4"
               style="background: #ffffff; color: #1E2B1F; font-size: 1rem; letter-spacing: 0.02em; focus-visible:ring-offset-color: transparent;">
                <?php echo esc_html( $cta_label ); ?>
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     aria-hidden="true" focusable="false">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<?php else : // ── Light variant ────────────────────────────────────────────
    /*
     * Light variant
     *   #1E2B1F headline on #E8DED2  → 11.4 : 1  ✓
     *   #3D4A3E subtext  on #E8DED2  →  8.4 : 1  ✓
     *   #fff    on #3D4A3E (button)  → 10.8 : 1  ✓
     */
?>

<section <?php echo $wrapper_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
    <div class="relative py-14 overflow-hidden"
         style="background: #E8DED2; border-top: 3px solid #3D4A3E;">

        <div aria-hidden="true" class="absolute -top-16 -right-16 w-64 h-64 rounded-full opacity-30 blur-3xl pointer-events-none" style="background: #7A8F7B;"></div>
        <div aria-hidden="true" class="absolute -bottom-16 -left-16 w-64 h-64 rounded-full opacity-20 blur-3xl pointer-events-none" style="background: #B7AFA3;"></div>

        <div class="relative max-w-7xl mx-auto px-5 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-8 lg:gap-16 justify-between">

                <div class="flex items-start gap-5 text-center lg:text-left flex-col sm:flex-row sm:items-center lg:items-start">
                    <div aria-hidden="true"
                         class="w-16 h-16 rounded-2xl flex items-center justify-center shrink-0 mx-auto sm:mx-0"
                         style="background: rgba(61,74,62,0.10); border: 1.5px solid rgba(61,74,62,0.20);">
                        <svg width="32" height="32" fill="none" stroke="#3D4A3E" viewBox="0 0 24 24"
                             stroke-width="1.75" aria-hidden="true" focusable="false">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-serif text-2xl lg:text-3xl font-bold mb-2"
                            style="color: #1E2B1F; letter-spacing: -0.01em;">
                            <?php echo esc_html( $headline ); ?>
                        </h2>
                        <?php if ( $subtext ) : ?>
                        <p class="text-base max-w-xl leading-relaxed"
                           style="color: #3D4A3E; margin-bottom: 0;">
                            <?php echo esc_html( $subtext ); ?>
                        </p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="shrink-0 text-center">
                    <a href="<?php echo esc_url( $cta_url ); ?>"
                       target="_blank"
                       rel="noopener noreferrer"
                       aria-label="<?php echo $cta_aria_label; ?>"
                       class="inline-flex items-center gap-2 px-8 py-4 font-semibold rounded-full shadow-lg
                              hover:shadow-xl hover:scale-105 transition-all duration-200 whitespace-nowrap
                              focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-brand-dark focus-visible:ring-offset-2 focus-visible:ring-offset-brand-sand"
                       style="background: #3D4A3E; color: #ffffff; font-size: 1rem; letter-spacing: 0.02em;">
                        <?php echo esc_html( $cta_label ); ?>
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             aria-hidden="true" focusable="false">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>

<?php endif; ?>
