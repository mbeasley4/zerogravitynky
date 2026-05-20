<?php
/**
 * Dynamic render for zerogravitynky/zg-faq block.
 * Outputs an accessible accordion using <details>/<summary>.
 */
defined( 'ABSPATH' ) || exit;

$section_title = ! empty( $attributes['sectionTitle'] ) ? $attributes['sectionTitle'] : 'Frequently Asked Questions';
$faqs          = ! empty( $attributes['faqs'] ) && is_array( $attributes['faqs'] ) ? $attributes['faqs'] : [];

$wrapper_attrs = get_block_wrapper_attributes( [ 'class' => 'zg-faq' ] );
?>

<section <?php echo $wrapper_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
    <div class="py-20 px-5 lg:px-8">
        <div class="max-w-3xl mx-auto">

            <!-- Section heading -->
            <div class="text-center mb-12">
                <span class="inline-block text-xs font-semibold uppercase tracking-widest text-brand-taupe mb-3">Questions &amp; Answers</span>
                <h2 class="font-serif text-3xl md:text-4xl text-brand-dark font-bold leading-tight">
                    <?php echo esc_html( $section_title ); ?>
                </h2>
            </div>

            <!-- FAQ accordion -->
            <?php if ( $faqs ) : ?>
            <div class="space-y-3">
                <?php foreach ( $faqs as $index => $faq ) :
                    $question  = ! empty( $faq['question'] )  ? $faq['question']  : '';
                    $answer    = ! empty( $faq['answer'] )    ? $faq['answer']    : '';
                    $image_url = ! empty( $faq['imageUrl'] )  ? $faq['imageUrl']  : '';
                    $image_id  = ! empty( $faq['imageId'] )   ? absint( $faq['imageId'] ) : 0;
                    if ( ! $question ) continue;
                ?>
                <details class="zg-faq__item group rounded-2xl border border-brand-dark/10 bg-white shadow-sm overflow-hidden">
                    <summary class="flex items-center justify-between gap-4 px-6 py-5 cursor-pointer list-none select-none
                                    font-serif text-lg font-semibold text-brand-dark
                                    hover:text-brand-sage transition-colors duration-200
                                    [&::-webkit-details-marker]:hidden">
                        <span><?php echo esc_html( $question ); ?></span>
                        <!-- Plus / minus icon -->
                        <span class="flex-none w-8 h-8 rounded-full flex items-center justify-center
                                     bg-brand-sage/8 group-open:bg-brand-sage transition-colors duration-200">
                            <svg class="w-4 h-4 text-brand-sage group-open:text-white transition-colors duration-200"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 6v12M6 12h12"
                                      class="group-open:opacity-0 transition-opacity duration-150" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M6 12h12"
                                      class="opacity-0 group-open:opacity-100 transition-opacity duration-150" />
                            </svg>
                        </span>
                    </summary>

                    <div class="px-6 pb-6 pt-1 border-t border-brand-dark/8">
                        <?php if ( $image_url ) : ?>
                        <div class="flex flex-col md:flex-row md:gap-6 md:items-start">
                            <!-- Text column -->
                            <div class="text-brand-gray leading-relaxed md:flex-1 order-2 md:order-1">
                                <?php echo wp_kses_post( wpautop( $answer ) ); ?>
                            </div>
                            <!-- Image column -->
                            <div class="order-1 md:order-2 mb-4 md:mb-0 md:w-2/5 md:flex-none">
                                <img
                                    src="<?php echo esc_url( $image_url ); ?>"
                                    <?php if ( $image_id ) : ?>
                                    alt="<?php echo esc_attr( get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ); ?>"
                                    <?php else : ?>
                                    alt=""
                                    <?php endif; ?>
                                    class="w-full h-auto rounded-xl object-cover"
                                />
                            </div>
                        </div>
                        <?php else : ?>
                        <div class="text-brand-gray leading-relaxed">
                            <?php echo wp_kses_post( wpautop( $answer ) ); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </details>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

        </div>
    </div>
</section>
