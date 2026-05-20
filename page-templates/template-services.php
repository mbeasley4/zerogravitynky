<?php
/*
 * Template Name: Services
 * Template Post Type: page
 */
get_header();

$book_url = home_url( '/zg-wellness-dermatology-services/' );
$shop_url  = home_url( '/product-category/facial/' );
$arrow_icon = '<svg class="w-3.5 h-3.5 text-white/60 group-hover:text-brand-taupe transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>';
?>

<!-- ═══════════════════════════════════════════
     HERO
═══════════════════════════════════════════ -->
<section class="relative pt-24 pb-14 text-white overflow-hidden bg-gradient-to-br from-brand-dark via-brand-sage to-brand-mid">
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-brand-taupe/20 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-24 -right-24 w-[500px] h-[500px] bg-brand-light/20 rounded-full blur-3xl"></div>

    <div class="relative max-w-7xl mx-auto px-5 lg:px-8 grid lg:grid-cols-2 gap-16 items-center">

        <div class="reveal">
            <p class="uppercase tracking-widest text-brand-taupe-light text-xs font-semibold mb-4">
                Zero Gravity Aesthetics &amp; Wellness
            </p>
            <h1 class="font-serif text-5xl md:text-6xl leading-tight mb-6">
                Radiant Skin Starts<br>
                <span class="shimmer-text">With the Right Facial</span>
            </h1>
            <p class="text-white/75 text-lg mb-8 max-w-md">
                Personalized treatments designed to restore glow, smooth texture, and deliver real, visible results.
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="#services" class="px-8 py-4 bg-brand-taupe text-brand-dark font-semibold rounded-full shadow-lg hover:scale-105 transition">
                    View Treatments
                </a>
                <a href="<?php echo esc_url( $book_url ); ?>" class="px-8 py-4 glass rounded-full text-white font-semibold hover:bg-white/10 transition">
                    Book Consultation
                </a>
            </div>
        </div>

        <div class="relative reveal">
            <div class="absolute inset-0 bg-white/10 rounded-2xl blur-xl"></div>
            <img src="https://zerogravitynky.com/wp-content/uploads/2024/02/ZGW_DermatologyServices_Home-600x600.jpg"
                 class="relative rounded-2xl shadow-2xl object-cover w-full h-[420px]"
                 alt="Facial Treatments at Zero Gravity" />
            <div class="absolute inset-0 rounded-2xl ring-1 ring-white/10"></div>
        </div>

    </div>
</section>

<!-- ═══════════════════════════════════════════
     INTRO
═══════════════════════════════════════════ -->
<section class="py-20 bg-white border-b border-black/5">
    <div class="max-w-4xl mx-auto px-5">
        <div class="text-center bg-white rounded-2xl shadow-xl p-10 border border-black/5 reveal">
            <h2 class="font-serif text-4xl text-brand-dark mb-4">Personalized Facial Treatments</h2>
            <p class="text-brand-gray/70 leading-relaxed">
                Our facials are fully customized to your skin type and goals — combining medical-grade products with expert technique to deliver visible, lasting results.
            </p>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════
     SERVICES GRID
═══════════════════════════════════════════ -->
<section id="services" class="py-24 bg-gradient-to-b from-white to-brand-sand">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">

        <div class="text-center mb-14 reveal">
            <h2 class="font-serif text-5xl text-brand-dark mb-4">Facial Treatments</h2>
            <p class="text-brand-gray/60 max-w-xl mx-auto text-sm">Targeted solutions designed for your skin goals</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 reveal">
            <?php
            $basic_services = [
                [
                    'img'   => 'https://zerogravitynky.com/wp-content/uploads/2024/02/ZGW_DermatologyServices_Home-600x600.jpg',
                    'title' => 'Signature Facial',
                    'desc'  => 'Customized treatment for all skin types.',
                ],
                [
                    'img'   => 'https://zerogravitynky.com/wp-content/uploads/2026/03/zero-gravity-hero-mobile.png',
                    'title' => 'Anti-Aging Facial',
                    'desc'  => 'Reduce fine lines and boost collagen.',
                ],
                [
                    'img'   => 'https://zerogravitynky.com/wp-content/uploads/2026/03/zero-gravity-hero-mobile.png',
                    'title' => 'Acne Facial',
                    'desc'  => 'Target breakouts and congestion.',
                ],
            ];
            foreach ( $basic_services as $s ) : ?>
            <div class="service-card bg-white/80 backdrop-blur rounded-2xl overflow-hidden border border-black/5 shadow-lg">
                <img src="<?php echo esc_url( $s['img'] ); ?>" class="h-44 w-full object-cover" alt="<?php echo esc_attr( $s['title'] ); ?>" />
                <div class="p-6">
                    <h3 class="font-serif text-lg mb-2"><?php echo esc_html( $s['title'] ); ?></h3>
                    <p class="text-sm text-brand-gray/70"><?php echo esc_html( $s['desc'] ); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<!-- ═══════════════════════════════════════════
     WHY CHOOSE
═══════════════════════════════════════════ -->
<section class="py-24 bg-brand-sand relative overflow-hidden">
    <div class="absolute -top-20 -left-20 w-72 h-72 bg-brand-sage/10 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-20 -right-20 w-96 h-96 bg-brand-taupe/10 rounded-full blur-3xl"></div>

    <div class="relative max-w-6xl mx-auto px-5 lg:px-8 text-center reveal">
        <h2 class="font-serif text-5xl text-brand-dark mb-10">Why Choose Zero Gravity</h2>
        <div class="grid md:grid-cols-3 gap-6">
            <?php
            $reasons = [
                [ 'title' => 'Medical Expertise',  'desc' => 'Performed by trained nurse practitioners and RNs.' ],
                [ 'title' => 'Customized Plans',   'desc' => 'Every treatment is tailored to your unique skin goals.' ],
                [ 'title' => 'Real Results',        'desc' => 'Visible improvements you can see and feel.' ],
            ];
            foreach ( $reasons as $r ) : ?>
            <div class="bg-white rounded-xl p-6 shadow-md">
                <h3 class="font-semibold mb-2"><?php echo esc_html( $r['title'] ); ?></h3>
                <p class="text-sm text-brand-gray/70"><?php echo esc_html( $r['desc'] ); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════
     WHAT TO EXPECT
═══════════════════════════════════════════ -->
<section class="py-28 bg-white relative overflow-hidden">
    <div class="absolute -top-20 left-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-brand-sage/5 rounded-full blur-3xl"></div>

    <div class="relative max-w-6xl mx-auto px-5 lg:px-8 text-center reveal">
        <h2 class="font-serif text-5xl md:text-6xl text-brand-dark mb-4">What to Expect</h2>
        <p class="text-brand-gray/60 max-w-xl mx-auto mb-16 text-sm">A seamless experience designed to deliver real, visible results</p>

        <div class="grid md:grid-cols-3 gap-8">
            <?php
            $steps = [
                [
                    'num'   => '1',
                    'color' => 'bg-brand-sage/10 text-brand-sage',
                    'title' => 'Consultation',
                    'desc'  => 'We analyze your skin, discuss your concerns, and build a personalized treatment plan tailored to your goals.',
                ],
                [
                    'num'   => '2',
                    'color' => 'bg-brand-sage/10 text-brand-sage',
                    'title' => 'Treatment',
                    'desc'  => 'Relax while your customized facial is performed using medical-grade products and advanced techniques.',
                ],
                [
                    'num'   => '3',
                    'color' => 'bg-brand-taupe/20 text-brand-dark',
                    'title' => 'Results',
                    'desc'  => 'Walk out with visibly smoother, brighter skin — and a plan to maintain your results long-term.',
                ],
            ];
            foreach ( $steps as $step ) : ?>
            <div class="group bg-white rounded-2xl p-8 border border-black/5 shadow-lg hover:shadow-2xl transition-all duration-300">
                <div class="mb-6 flex justify-center">
                    <div class="w-12 h-12 flex items-center justify-center rounded-full <?php echo esc_attr( $step['color'] ); ?> font-bold text-lg">
                        <?php echo esc_html( $step['num'] ); ?>
                    </div>
                </div>
                <h3 class="font-serif text-xl text-brand-dark mb-3"><?php echo esc_html( $step['title'] ); ?></h3>
                <p class="text-sm text-brand-gray/70 leading-relaxed"><?php echo esc_html( $step['desc'] ); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════
     TOP FACIAL TREATMENTS (dark)
═══════════════════════════════════════════ -->
<section class="relative py-24 overflow-hidden" style="background: #0e0520;">
    <div class="absolute top-0 left-1/4 w-[500px] h-[500px] rounded-full blur-[120px] pointer-events-none" style="background: rgba(122,143,123,0.35);"></div>
    <div class="absolute bottom-0 right-1/4 w-[400px] h-[400px] rounded-full blur-[100px] pointer-events-none" style="background: rgba(183,175,163,0.22);"></div>
    <div class="absolute top-1/2 left-0 w-72 h-72 rounded-full blur-3xl pointer-events-none" style="background: rgba(148,169,149,0.22);"></div>
    <div class="absolute inset-0 opacity-[0.06] pointer-events-none" style="background-image: radial-gradient(circle, rgba(255,255,255,0.8) 1px, transparent 1px); background-size: 28px 28px;"></div>

    <div class="relative max-w-7xl mx-auto px-5 lg:px-8">

        <div class="text-center mb-14 reveal">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-brand-taupe/40 bg-brand-taupe/10 text-brand-taupe text-xs font-semibold uppercase tracking-widest mb-5">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                Most Popular
            </span>
            <h2 class="font-serif text-5xl md:text-6xl text-white leading-tight mb-4">
                Top Facial <span class="shimmer-text">Treatments</span>
            </h2>
            <p class="text-white/50 max-w-lg mx-auto text-base">
                Expertly performed by our nurse practitioners — real results, zero guesswork.
            </p>
        </div>

        <?php
        $card_base   = 'group relative rounded-2xl overflow-hidden border border-white/10 hover:border-brand-taupe/50 transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_24px_60px_rgba(61,74,62,0.35)]';
        $card_bg     = 'background: linear-gradient(160deg, rgba(255,255,255,0.07) 0%, rgba(255,255,255,0.02) 100%);';
        $img_overlay = 'background: linear-gradient(to top, #0e0520 10%, rgba(14,5,32,0.4) 60%, transparent 100%);';
        $chevron     = '<svg class="w-3.5 h-3.5 text-white/60 group-hover:text-brand-taupe transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>';

        $top_treatments = [
            [
                'img'   => 'https://zerogravitynky.com/wp-content/uploads/2024/02/ZGW_DermatologyServices_Home-600x600.jpg',
                'badge' => [ 'label' => 'Fan Favorite', 'style' => 'background: rgba(61,74,62,0.80); backdrop-filter: blur(8px); color: white;' ],
                'title' => 'Signature ZG Facial',
                'desc'  => 'Our most-requested custom facial — deep cleanse, exfoliation, extractions, and a personalized mask targeting your exact skin goals.',
            ],
            [
                'img'   => 'https://zerogravitynky.com/wp-content/uploads/2021/08/facial_category-300x300.jpg',
                'badge' => [ 'label' => 'Best Seller', 'style' => 'background: rgba(183,175,163,0.88); backdrop-filter: blur(8px); color: #3D4A3E;' ],
                'title' => 'HydraFacial',
                'desc'  => 'Cleanse, extract, and hydrate in one powerful treatment. Instantly plump, glow-boosting results with no downtime.',
            ],
            [
                'img'   => 'https://zerogravitynky.com/wp-content/uploads/2026/03/zero-gravity-hero-mobile.png',
                'badge' => null,
                'title' => 'Brightening Facial',
                'desc'  => 'Target hyperpigmentation, sun damage, and dullness with vitamin C serums and brightening actives for a luminous complexion.',
            ],
            [
                'img'   => 'https://zerogravitynky.com/wp-content/uploads/2024/02/ZGW_DermatologyServices_Home-600x600.jpg',
                'badge' => null,
                'title' => 'Anti-Aging Facial',
                'desc'  => 'Peptides, growth factors, and retinoids work together to firm skin, reduce fine lines, and visibly restore a youthful glow.',
            ],
        ];
        ?>

        <!-- Row 1: 4 cards -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 reveal">
            <?php foreach ( $top_treatments as $t ) : ?>
            <a href="<?php echo esc_url( $shop_url ); ?>" class="<?php echo $card_base; ?>" style="<?php echo $card_bg; ?>">
                <div class="relative overflow-hidden h-52">
                    <img src="<?php echo esc_url( $t['img'] ); ?>" alt="<?php echo esc_attr( $t['title'] ); ?>"
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
                    <div class="absolute inset-0" style="<?php echo $img_overlay; ?>"></div>
                    <?php if ( $t['badge'] ) : ?>
                    <div class="absolute top-3 right-3">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider" style="<?php echo $t['badge']['style']; ?>"><?php echo esc_html( $t['badge']['label'] ); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="p-5">
                    <h3 class="font-serif text-xl text-white mb-2 group-hover:text-brand-taupe-light transition-colors"><?php echo esc_html( $t['title'] ); ?></h3>
                    <p class="text-white/50 text-xs leading-relaxed mb-4"><?php echo esc_html( $t['desc'] ); ?></p>
                    <div class="flex items-center justify-between">
                        <span class="text-brand-taupe text-xs font-semibold uppercase tracking-wider">Book Now →</span>
                        <div class="w-7 h-7 rounded-full flex items-center justify-center border border-white/20 group-hover:border-brand-taupe/60 group-hover:bg-brand-taupe/10 transition-all">
                            <?php echo $chevron; ?>
                        </div>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- Row 2: 2 wide cards + view-all CTA -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 mt-5 reveal">

            <?php
            $wide_treatments = [
                [
                    'img'   => 'https://zerogravitynky.com/wp-content/uploads/2021/08/facial_category-300x300.jpg',
                    'title' => 'Acne Clearing Facial',
                    'desc'  => 'Deep extractions, salicylic acid, and LED blue light calm active breakouts and congestion.',
                ],
                [
                    'img'   => 'https://zerogravitynky.com/wp-content/uploads/2026/03/zero-gravity-hero-mobile.png',
                    'title' => 'Dermaplaning Facial',
                    'desc'  => 'Manual exfoliation removes dead skin and peach fuzz, leaving an ultra-smooth canvas that glows.',
                ],
            ];
            foreach ( $wide_treatments as $w ) :
            ?>
            <a href="<?php echo esc_url( $shop_url ); ?>" class="<?php echo $card_base; ?> flex flex-col sm:flex-row" style="<?php echo $card_bg; ?>">
                <div class="relative overflow-hidden sm:w-44 flex-none h-44 sm:h-auto">
                    <img src="<?php echo esc_url( $w['img'] ); ?>" alt="<?php echo esc_attr( $w['title'] ); ?>"
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
                    <div class="absolute inset-0" style="background: linear-gradient(to right, transparent 60%, #0e0520 100%);"></div>
                </div>
                <div class="p-5 flex flex-col justify-center">
                    <h3 class="font-serif text-lg text-white mb-2 group-hover:text-brand-taupe-light transition-colors"><?php echo esc_html( $w['title'] ); ?></h3>
                    <p class="text-white/50 text-xs leading-relaxed mb-3"><?php echo esc_html( $w['desc'] ); ?></p>
                    <span class="text-brand-taupe text-xs font-semibold uppercase tracking-wider">Book Now →</span>
                </div>
            </a>
            <?php endforeach; ?>

            <!-- View all CTA card -->
            <a href="<?php echo esc_url( $shop_url ); ?>"
               class="group relative rounded-2xl overflow-hidden border border-brand-sage/40 hover:border-brand-taupe/60 transition-all duration-300 hover:-translate-y-2 flex items-center justify-center min-h-[160px] sm:min-h-0"
               style="background: linear-gradient(135deg, rgba(122,143,123,0.22) 0%, rgba(61,74,62,0.45) 100%);">
                <div class="text-center p-8">
                    <div class="w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4 border border-brand-taupe/40 group-hover:border-brand-taupe group-hover:bg-brand-taupe/10 transition-all" style="background: rgba(183,175,163,0.18);">
                        <svg class="w-6 h-6 text-brand-taupe" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h7"/></svg>
                    </div>
                    <p class="text-white font-semibold mb-1">View All Facials</p>
                    <p class="text-white/40 text-xs mb-4">See our complete treatment menu</p>
                    <span class="inline-flex items-center gap-1.5 px-5 py-2 rounded-full text-xs font-bold text-brand-dark group-hover:scale-105 transition-transform" style="background: linear-gradient(135deg, #8A8178, #B7AFA3, #E8DED2);">
                        Shop Now
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                </div>
            </a>

        </div>

    </div>
</section>

<!-- ═══════════════════════════════════════════
     CTA BANNER
═══════════════════════════════════════════ -->
<section class="relative py-28 text-white text-center overflow-hidden" style="background: linear-gradient(135deg, #3D4A3E 0%, #7A8F7B 55%, #94A995 100%);">
    <div class="absolute -top-16 -left-16 w-72 h-72 rounded-full opacity-20 blur-3xl" style="background: #B7AFA3;"></div>
    <div class="absolute -bottom-16 -right-16 w-96 h-96 rounded-full opacity-15 blur-3xl" style="background: #94A995;"></div>

    <div class="relative max-w-2xl mx-auto px-6 reveal">
        <p class="uppercase tracking-widest text-brand-taupe-light text-sm font-semibold mb-4">Zero Gravity Aesthetics &amp; Wellness</p>
        <h2 class="font-serif text-4xl md:text-5xl font-bold mb-5 leading-tight">
            Ready for <span style="background: linear-gradient(135deg, #6B6560, #B7AFA3, #E8DED2); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Glowing Skin?</span>
        </h2>
        <p class="text-white/70 text-lg mb-10">
            Book your personalized facial today and walk out luminous. New clients welcome — results you'll love, guaranteed.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="<?php echo esc_url( $book_url ); ?>" class="px-8 py-4 rounded-full font-semibold text-brand-dark shadow-lg hover:scale-105 transition-transform duration-200" style="background: linear-gradient(135deg, #8A8178, #B7AFA3, #E8DED2);">
                Book Now
            </a>
            <a href="tel:8593443250" class="px-8 py-4 rounded-full font-semibold border border-white/40 text-white hover:bg-white/10 transition-colors duration-200">
                (859) 344-3250
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
