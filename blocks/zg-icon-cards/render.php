<?php
/**
 * Dynamic render for zerogravitynky/zg-icon-cards block.
 */
defined( 'ABSPATH' ) || exit;

$section_headline       = ! empty( $attributes['sectionHeadline'] )    ? $attributes['sectionHeadline']    : '';
$section_content        = ! empty( $attributes['sectionContent'] )     ? $attributes['sectionContent']     : '';
$section_content_align  = ! empty( $attributes['sectionContentAlign'] ) ? $attributes['sectionContentAlign'] : 'center';
$column_count           = isset( $attributes['columnCount'] )          ? absint( $attributes['columnCount'] ) : 3;
$cards                  = ! empty( $attributes['cards'] ) && is_array( $attributes['cards'] ) ? $attributes['cards'] : [];

$column_count = max( 2, min( 4, $column_count ) );
$active_cards = array_slice( $cards, 0, $column_count );

if ( 2 === $column_count ) {
    $grid_class = 'grid-cols-1 md:grid-cols-2';
} elseif ( 4 === $column_count ) {
    $grid_class = 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4';
} else {
    $grid_class = 'grid-cols-1 md:grid-cols-3';
}

$default_icon = '<svg class="w-6 h-6 text-brand-sage" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z"/></svg>';

$wrapper_attrs = get_block_wrapper_attributes( [ 'class' => 'zg-icon-cards' ] );
?>
<section <?php echo $wrapper_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
    <div class="<?php echo ( $section_headline || $section_content ) ? 'py-20' : 'pt-8 pb-20'; ?> px-5 lg:px-8">
        <div class="max-w-6xl mx-auto">

            <?php if ( $section_headline || $section_content ) : ?>
            <div class="mb-14 max-w-3xl mx-auto" style="text-align:<?php echo esc_attr( $section_content_align ); ?>;">
                <?php if ( $section_headline ) : ?>
                <h2 class="font-serif text-3xl md:text-4xl xl:text-5xl font-bold text-brand-dark leading-tight mb-5">
                    <?php echo esc_html( $section_headline ); ?>
                </h2>
                <?php endif; ?>
                <?php if ( $section_content ) : ?>
                <div class="text-brand-gray text-base leading-relaxed">
                    <?php echo wp_kses_post( $section_content ); ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if ( $active_cards ) : ?>
            <div class="grid <?php echo esc_attr( $grid_class ); ?> gap-5">
                <?php foreach ( $active_cards as $card ) :
                    $icon_url      = ! empty( $card['iconUrl'] )  ? $card['iconUrl']  : '';
                    $icon_alt      = ! empty( $card['iconAlt'] )  ? $card['iconAlt']  : '';
                    $headline      = ! empty( $card['headline'] ) ? $card['headline'] : '';
                    $content       = ! empty( $card['content'] )  ? $card['content']  : '';
                    $cta_label     = ! empty( $card['ctaLabel'] ) ? $card['ctaLabel'] : '';
                    $cta_url       = ! empty( $card['ctaUrl'] )   ? $card['ctaUrl']   : '';
                    $content_align = ! empty( $card['align'] )    ? $card['align']    : '';
                    if ( ! $headline && ! $content ) continue;
                ?>
                <div class="bg-white rounded-2xl shadow-sm border border-brand-dark/8 flex flex-col" style="padding: 2rem 1.75rem;">

                    <?php if ( $icon_url ) : ?>
                    <div class="w-12 h-12 rounded-xl bg-brand-sage/10 flex items-center justify-center mb-5 shrink-0">
                        <img src="<?php echo esc_url( $icon_url ); ?>"
                             alt="<?php echo esc_attr( $icon_alt ); ?>"
                             class="w-7 h-7 object-contain" />
                    </div>
                    <?php endif; ?>

                    <?php if ( $headline ) : ?>
                    <h3 class="font-serif text-xl font-bold text-brand-dark leading-snug mb-3">
                        <?php echo esc_html( $headline ); ?>
                    </h3>
                    <?php endif; ?>

                    <?php if ( $content ) : ?>
                    <div class="text-brand-gray text-sm leading-relaxed flex-grow<?php echo ( $cta_label && $cta_url ) ? ' mb-6' : ''; ?>"<?php echo $content_align ? ' style="text-align:' . esc_attr( $content_align ) . ';"' : ''; ?>>
                        <?php echo wp_kses_post( $content ); ?>
                    </div>
                    <?php endif; ?>

                    <?php if ( $cta_label && $cta_url ) : ?>
                    <a href="<?php echo esc_url( $cta_url ); ?>"
                       class="self-start inline-flex items-center mt-auto text-sm font-semibold rounded-full bg-brand-sage text-white hover:bg-brand-dark transition-colors duration-200"
                       style="padding: 0.5rem 1.25rem;">
                        <?php echo esc_html( $cta_label ); ?>
                    </a>
                    <?php endif; ?>

                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

        </div>
    </div>
</section>
