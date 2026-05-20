<?php
/**
 * Dynamic render for zerogravitynky/testimonial-card block.
 */
defined( 'ABSPATH' ) || exit;

$section_title = $attributes['sectionTitle'] ?? 'What Our Clients Say';
$rating_label  = $attributes['ratingLabel']  ?? '5.0 · Consistently 5-star rated';

$testimonials = [
    [
        'quote'    => $attributes['t1Quote']    ?? '',
        'name'     => $attributes['t1Name']     ?? '',
        'type'     => $attributes['t1Type']     ?? '',
        'initials' => $attributes['t1Initials'] ?? '',
        'color'    => $attributes['t1Color']    ?? 'brand-sage',
        'delay'    => '',
    ],
    [
        'quote'    => $attributes['t2Quote']    ?? '',
        'name'     => $attributes['t2Name']     ?? '',
        'type'     => $attributes['t2Type']     ?? '',
        'initials' => $attributes['t2Initials'] ?? '',
        'color'    => $attributes['t2Color']    ?? 'brand-taupe',
        'delay'    => '0.1s',
    ],
    [
        'quote'    => $attributes['t3Quote']    ?? '',
        'name'     => $attributes['t3Name']     ?? '',
        'type'     => $attributes['t3Type']     ?? '',
        'initials' => $attributes['t3Initials'] ?? '',
        'color'    => $attributes['t3Color']    ?? 'brand-mid',
        'delay'    => '0.2s',
    ],
];

$star    = '<svg class="w-4 h-4 text-brand-taupe" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>';
$star_lg = '<svg class="w-5 h-5 text-brand-taupe" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>';
?>
<section class="py-24 bg-brand-sand">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">

        <div class="text-center mb-14 reveal">
            <div class="inline-flex items-center gap-2 text-brand-sage text-sm font-semibold uppercase tracking-widest mb-4">
                <span class="w-8 h-px bg-brand-sage"></span>
                Testimonials
                <span class="w-8 h-px bg-brand-sage"></span>
            </div>
            <h2 class="font-serif text-4xl lg:text-5xl text-brand-dark font-bold mb-3">
                <?php echo esc_html( $section_title ); ?>
            </h2>
            <div class="flex justify-center items-center gap-1 mt-3">
                <?php echo str_repeat( $star_lg, 5 ); // phpcs:ignore ?>
                <span class="ml-2 text-brand-gray font-medium text-sm">
                    <?php echo esc_html( $rating_label ); ?>
                </span>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <?php foreach ( $testimonials as $t ) :
                $is_gold   = $t['color'] === 'brand-taupe';
                $bg_opacity = $is_gold ? '20' : '10';
            ?>
            <div class="testimonial-card reveal bg-white rounded-2xl p-7 shadow-sm"
                 <?php echo $t['delay'] ? 'style="transition-delay:' . esc_attr( $t['delay'] ) . '"' : ''; ?>>
                <div class="flex gap-0.5 mb-4"><?php echo str_repeat( $star, 5 ); // phpcs:ignore ?></div>
                <blockquote class="text-brand-gray/80 text-sm leading-relaxed mb-6 italic">
                    &ldquo;<?php echo esc_html( $t['quote'] ); ?>&rdquo;
                </blockquote>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-<?php echo esc_attr( $t['color'] ); ?>/<?php echo esc_attr( $bg_opacity ); ?> flex items-center justify-center">
                        <span class="text-<?php echo esc_attr( $t['color'] ); ?> font-semibold text-sm">
                            <?php echo esc_html( $t['initials'] ); ?>
                        </span>
                    </div>
                    <div>
                        <div class="text-brand-dark font-semibold text-sm"><?php echo esc_html( $t['name'] ); ?></div>
                        <div class="text-brand-gray/50 text-xs"><?php echo esc_html( $t['type'] ); ?></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
