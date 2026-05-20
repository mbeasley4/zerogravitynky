<?php get_header(); ?>

<?php
// Star SVG helper used in ratings
$star = '<svg class="w-4 h-4 text-brand-taupe" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>';
$star_lg = str_replace('w-4 h-4', 'w-5 h-5', $star);
$check = '<svg class="w-5 h-5 text-brand-sage shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
$check_gold = '<svg class="w-3 h-3 text-brand-taupe" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>';
$arrow = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>';
?>

<!-- ═══════════════════════════════════════════
     HERO · MARQUEE · SERVICES
     Rendered from block content stored in the database.
     Edit via WP Admin › Pages › Front Page.
     To seed initial data: wp eval-file wp-content/themes/zerogravitynky/tools/seed-front-page.php
═══════════════════════════════════════════ -->
<main id="main-content" tabindex="-1">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<?php the_content(); ?>
<?php endwhile; endif; ?>
</main> 

<?php get_footer(); ?>

<?php // ── LEGACY FALLBACK ────────────────────────────────────────────────────────
// Displayed only when the front page has no saved block content yet.
// Run the seeder (see comment above) to replace this with database-driven blocks.
$page_content = get_post_field( 'post_content', get_option( 'page_on_front' ) );
if ( ! empty( trim( $page_content ) ) ) { return; }
?>

<!-- Begin legacy static markup -->

<!-- ═══════════════════════════════════════════
     ABOUT / TEAM
═══════════════════════════════════════════ -->
<section id="about" class="py-24 bg-brand-dark overflow-hidden">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">

            <div class="reveal">
                <div class="inline-flex items-center gap-2 text-brand-taupe text-sm font-semibold uppercase tracking-widest mb-5">
                    <span class="w-8 h-px bg-brand-taupe"></span>Our Story
                </div>
                <h2 class="font-serif text-4xl lg:text-5xl text-white font-bold leading-tight mb-6">
                    Medically Led.<br />
                    <span class="shimmer-text">Results Driven.</span><br />
                    Locally Loved.
                </h2>
                <p class="text-white/60 text-base leading-relaxed mb-5">
                    Founded in 2016, Zero Gravity Aesthetics &amp; Wellness was built on a simple belief: everyone deserves access to safe, effective aesthetic care delivered by medical professionals — not just aestheticians.
                </p>
                <p class="text-white/60 text-base leading-relaxed mb-8">
                    Co-founded by <strong class="text-white">Candace Reusch, MSN, APRN, FNP-C</strong> and <strong class="text-white">Jennifer Walsh, RN</strong>, our clinic brings 20+ years of combined nursing expertise to every single treatment. We operate on medical integrity — honest consultations, real results.
                </p>
                <div class="flex flex-wrap gap-3 mb-10">
                    <span class="glass px-4 py-2 rounded-full text-white/80 text-xs font-medium">APRN Led</span>
                    <span class="glass px-4 py-2 rounded-full text-white/80 text-xs font-medium">RN Staffed</span>
                    <span class="glass px-4 py-2 rounded-full text-white/80 text-xs font-medium">20+ Yrs Experience</span>
                    <span class="glass px-4 py-2 rounded-full text-white/80 text-xs font-medium">Est. 2016</span>
                    <span class="glass px-4 py-2 rounded-full text-white/80 text-xs font-medium">NKY Voted #1</span>
                </div>
                <a href="<?php echo esc_url( home_url( '/staff/' ) ); ?>" class="inline-flex items-center gap-2 px-7 py-3.5 bg-brand-sage text-white font-semibold rounded-full hover:bg-brand-mid transition-all shadow-lg hover:shadow-brand-sage/30 text-sm">
                    Meet Our Team <?php echo $arrow; ?>
                </a>
            </div>

            <div class="reveal flex flex-col gap-5">
                <div class="rounded-2xl overflow-hidden relative shadow-xl">
                    <img src="https://zerogravitynky.com/wp-content/uploads/2025/07/candace-jen-zg-web-homepage-1024x759.png"
                         alt="Candace Reusch and Jennifer Walsh — Zero Gravity Founders"
                         class="w-full object-cover object-top" style="max-height:260px;" />
                    <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/60 via-transparent to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-5 flex gap-6">
                        <div>
                            <div class="text-white font-semibold text-sm">Jennifer Walsh</div>
                            <div class="text-brand-light text-xs">RN · Co-Founder</div>
                        </div>
                        <div>
                            <div class="text-white font-semibold text-sm">Candace Reusch</div>
                            <div class="text-brand-light text-xs">MSN, APRN, FNP-C · Co-Founder</div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl overflow-hidden relative shadow-xl">
                    <img src="https://zerogravitynky.com/wp-content/uploads/2025/07/zg-exterior-web2-e1752804466329-995x1024.png"
                         alt="Zero Gravity — Crestview Hills Location"
                         class="w-full object-cover" style="max-height:200px; object-position: center 30%;" />
                    <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/60 via-transparent to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4">
                        <div class="text-white/70 text-xs uppercase tracking-widest mb-0.5">Find Us At</div>
                        <div class="text-white font-semibold text-sm">2853 Town Center Blvd, Crestview Hills, KY</div>
                    </div>
                </div>

                <div class="glass rounded-2xl p-6">
                    <div class="text-brand-taupe text-xs uppercase tracking-widest font-semibold mb-4">Why Patients Choose Us</div>
                    <div class="space-y-3">
                        <?php
                        $reasons = [
                            'Medically owned — not a franchise or chain',
                            'Honest, personalized consultations every time',
                            'Voted NKY\'s best med spa — multiple years running',
                            'Comprehensive services under one roof',
                        ];
                        foreach ( $reasons as $reason ) : ?>
                        <div class="flex items-start gap-3">
                            <div class="w-5 h-5 rounded-full bg-brand-taupe/20 flex items-center justify-center shrink-0 mt-0.5">
                                <?php echo $check_gold; ?>
                            </div>
                            <span class="text-white/70 text-sm"><?php echo esc_html( $reason ); ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════
     TESTIMONIALS
═══════════════════════════════════════════ -->
<section class="py-24 bg-brand-sand">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">

        <div class="text-center mb-14 reveal">
            <div class="inline-flex items-center gap-2 text-brand-sage text-sm font-semibold uppercase tracking-widest mb-4">
                <span class="w-8 h-px bg-brand-sage"></span>Testimonials<span class="w-8 h-px bg-brand-sage"></span>
            </div>
            <h2 class="font-serif text-4xl lg:text-5xl text-brand-dark font-bold mb-3">What Our Clients Say</h2>
            <div class="flex justify-center items-center gap-1 mt-3">
                <?php echo str_repeat( $star_lg, 5 ); ?>
                <span class="ml-2 text-brand-gray font-medium text-sm">5.0 · Consistently 5-star rated</span>
            </div>
        </div>

        <?php
        $review_posts = get_posts( [
            'post_type'      => 'zg_review',
            'post_status'    => 'publish',
            'posts_per_page' => 3,
            'orderby'        => 'rand',
        ] );

        $avatar_colors = [ 'brand-sage', 'brand-taupe', 'brand-mid' ];
        ?>
        <div class="grid md:grid-cols-3 gap-6">
            <?php if ( $review_posts ) :
                foreach ( $review_posts as $i => $review ) :
                    $name    = get_post_meta( $review->ID, '_review_reviewer', true ) ?: $review->post_title;
                    $comment = get_post_meta( $review->ID, '_review_comment',  true );
                    $stars   = (int) get_post_meta( $review->ID, '_review_stars', true );
                    $link    = get_post_meta( $review->ID, '_review_link',    true );
                    $source  = get_post_meta( $review->ID, '_review_source',  true );
                    $date    = get_post_meta( $review->ID, '_review_date',    true );

                    // Build initials from reviewer name
                    $parts    = array_filter( explode( ' ', trim( $name ) ) );
                    $initials = implode( '', array_map( fn( $p ) => strtoupper( mb_substr( $p, 0, 1 ) ), array_slice( $parts, 0, 2 ) ) );

                    $color = $avatar_colors[ $i % count( $avatar_colors ) ];
                    $delay = $i > 0 ? number_format( $i * 0.1, 1 ) . 's' : '';

                    $source_label = match( $source ) {
                        'google' => 'Google Review',
                        'yelp'   => 'Yelp Review',
                        default  => '',
                    };
                    $filled_stars = min( max( $stars, 0 ), 5 );
                ?>
                <div class="testimonial-card reveal bg-white rounded-2xl p-7 shadow-sm"<?php echo $delay ? ' style="transition-delay:' . esc_attr( $delay ) . '"' : ''; ?>>
                    <div class="flex gap-0.5 mb-4">
                        <?php
                        echo str_repeat( $star, $filled_stars );
                        echo str_repeat(
                            '<svg class="w-4 h-4 text-gray-200" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>',
                            5 - $filled_stars
                        );
                        ?>
                    </div>
                    <blockquote class="text-brand-gray/80 text-sm leading-relaxed mb-6 italic"><?php echo esc_html( $comment ); ?></blockquote>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-<?php echo esc_attr( $color ); ?>/<?php echo $color === 'brand-taupe' ? '20' : '10'; ?> flex items-center justify-center shrink-0">
                            <span class="text-<?php echo esc_attr( $color ); ?> font-semibold text-sm"><?php echo esc_html( $initials ); ?></span>
                        </div>
                        <div class="min-w-0">
                            <div class="text-brand-dark font-semibold text-sm truncate"><?php echo esc_html( $name ); ?></div>
                            <?php if ( $source_label || $date ) : ?>
                            <div class="text-brand-gray/50 text-xs">
                                <?php
                                $meta_parts = array_filter( [
                                    $source_label,
                                    $date ? date_i18n( 'M Y', strtotime( $date ) ) : '',
                                ] );
                                echo esc_html( implode( ' · ', $meta_parts ) );
                                ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php if ( $link ) : ?>
                        <a href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener noreferrer"
                           class="ml-auto shrink-0 text-brand-gray/30 hover:text-brand-sage transition-colors"
                           aria-label="View original review">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach;
            else : ?>
                <p class="md:col-span-3 text-center text-brand-gray/50 text-sm py-8">No reviews yet. <a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=zg_review' ) ); ?>" class="underline">Add the first one →</a></p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════
     MEMBERSHIPS
═══════════════════════════════════════════ -->
<section id="memberships" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">

            <div class="reveal">
                <div class="inline-flex items-center gap-2 text-brand-sage text-sm font-semibold uppercase tracking-widest mb-5">
                    <span class="w-8 h-px bg-brand-sage"></span>Memberships
                </div>
                <h2 class="font-serif text-4xl lg:text-5xl text-brand-dark font-bold leading-tight mb-5">
                    Exclusive ZG<br />Membership Plans
                </h2>
                <p class="text-brand-gray/70 text-base leading-relaxed mb-6">
                    Unlock exclusive member pricing, priority booking, and monthly treatment credits with a Zero Gravity membership. The most cost-effective way to maintain beautiful, healthy skin year-round.
                </p>
                <ul class="space-y-3 mb-8">
                    <?php
                    $perks = [
                        'Monthly treatment credits applied automatically',
                        'Priority scheduling — always first in line',
                        'Exclusive member-only pricing on all services',
                        'Access to member events and early promotions',
                    ];
                    foreach ( $perks as $perk ) : ?>
                    <li class="flex items-center gap-3 text-brand-gray text-sm">
                        <?php echo $check; ?>
                        <?php echo esc_html( $perk ); ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <a href="<?php echo esc_url( home_url( '/zero-gravity-memberships/' ) ); ?>" class="inline-flex items-center gap-2 px-8 py-4 bg-brand-sage text-white font-semibold rounded-full hover:bg-brand-mid transition-all shadow-lg hover:shadow-brand-sage/30 hover:scale-105">
                    Explore Memberships <?php echo $arrow; ?>
                </a>
            </div>

            <div class="reveal space-y-4">
                <div class="rounded-2xl overflow-hidden shadow-md">
                    <img src="https://zerogravitynky.com/wp-content/uploads/2025/04/zg-home-membership-1024x1024.png"
                         alt="Zero Gravity Memberships"
                         class="w-full object-cover" style="max-height:200px; object-position: center top;" />
                </div>

                <!-- Glow Membership -->
                <div class="rounded-2xl border-2 border-brand-sand p-6 hover:border-brand-sage transition-colors group cursor-pointer">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <div class="text-brand-sage font-semibold text-xs uppercase tracking-wider mb-1">Aesthetics</div>
                            <h3 class="font-serif text-xl text-brand-dark font-semibold">Glow Membership</h3>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-brand-sand group-hover:bg-brand-sage/10 transition-colors flex items-center justify-center">
                            <svg class="w-5 h-5 text-brand-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/></svg>
                        </div>
                    </div>
                    <p class="text-brand-gray/70 text-sm">Monthly facials, skincare treatments, and priority aesthetic services at member rates.</p>
                </div>

                <!-- Vitality Membership -->
                <div class="rounded-2xl border-2 border-brand-sage p-6 bg-brand-sage/5 relative cursor-pointer">
                    <div class="absolute -top-3 right-6 bg-brand-dark text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">Popular</div>
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <div class="text-brand-sage font-semibold text-xs uppercase tracking-wider mb-1">Wellness</div>
                            <h3 class="font-serif text-xl text-brand-dark font-semibold">Vitality Membership</h3>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-brand-sage/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-brand-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/></svg>
                        </div>
                    </div>
                    <p class="text-brand-gray/70 text-sm">IV therapies, wellness visits, and weight loss support with monthly credits and discounted add-ons.</p>
                </div>

                <!-- VIP Membership -->
                <div class="rounded-2xl border-2 border-brand-taupe/40 p-6 hover:border-brand-taupe transition-colors group cursor-pointer bg-gradient-to-br from-brand-taupe/5 to-transparent">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <div class="text-brand-taupe font-semibold text-xs uppercase tracking-wider mb-1">Premium</div>
                            <h3 class="font-serif text-xl text-brand-dark font-semibold">ZG VIP Membership</h3>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-brand-taupe/10 group-hover:bg-brand-taupe/20 transition-colors flex items-center justify-center">
                            <svg class="w-5 h-5 text-brand-taupe" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg>
                        </div>
                    </div>
                    <p class="text-brand-gray/70 text-sm">The full ZG experience — unlimited access to aesthetic and wellness services, first-call priority, and exclusive VIP events.</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════
     ZG ACADEMY
═══════════════════════════════════════════ -->
<section id="academy" class="py-24 bg-hero-gradient relative overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, rgba(255,255,255,0.4) 1px, transparent 1px); background-size: 36px 36px;"></div>
    <div class="blob absolute -top-20 -right-20 w-80 h-80 bg-brand-mid/20 blur-3xl pointer-events-none"></div>

    <div class="relative max-w-7xl mx-auto px-5 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-14 items-center">

            <div class="reveal">
                <div class="inline-flex items-center gap-2 text-brand-taupe text-sm font-semibold uppercase tracking-widest mb-5">
                    <span class="w-8 h-px bg-brand-taupe"></span>ZG Aesthetics Academy
                </div>
                <h2 class="font-serif text-4xl lg:text-5xl text-white font-bold leading-tight mb-5">
                    Train With<br />
                    <span class="shimmer-text">The Best in NKY</span>
                </h2>
                <p class="text-white/65 text-base leading-relaxed mb-5">
                    Our ZG Aesthetics Academy offers hands-on professional training for nurses, nurse practitioners, and medical professionals looking to enter or advance in the aesthetic medicine field.
                </p>
                <p class="text-white/65 text-base leading-relaxed mb-8">
                    Led by our APRN and RN team, each class provides real-world, patient-focused instruction using the same techniques we use every day at Zero Gravity.
                </p>
                <div class="flex flex-wrap gap-4 mb-8">
                    <div class="glass rounded-xl px-5 py-3 text-center">
                        <div class="text-white font-serif font-bold text-2xl">$3,200</div>
                        <div class="text-white/50 text-xs mt-0.5">Includes workbook &amp; supplies</div>
                    </div>
                    <div class="glass rounded-xl px-5 py-3 text-center">
                        <div class="text-white font-serif font-bold text-2xl">Hands-On</div>
                        <div class="text-white/50 text-xs mt-0.5">Live patient training</div>
                    </div>
                    <div class="glass rounded-xl px-5 py-3 text-center">
                        <div class="text-white font-serif font-bold text-2xl">APRN Led</div>
                        <div class="text-white/50 text-xs mt-0.5">Expert instructors</div>
                    </div>
                </div>
                <a href="<?php echo esc_url( home_url( '/zg-aesthetics-academy/' ) ); ?>" class="inline-flex items-center gap-2 px-8 py-4 bg-brand-sage text-white font-semibold rounded-full hover:bg-brand-mid transition-all shadow-lg hover:shadow-brand-sage/30 hover:scale-105">
                    Learn About the Academy <?php echo $arrow; ?>
                </a>
            </div>

            <div class="reveal">
                <div class="glass rounded-2xl p-8 space-y-6">
                    <div class="text-white/80 text-sm uppercase tracking-widest font-semibold">What You'll Learn</div>
                    <div class="space-y-5">
                        <?php
                        $lessons = [
                            [ 'num' => '01', 'title' => 'Botox & Neurotoxin Injection Techniques', 'desc' => 'Precise injection protocols, dosing, and patient safety for wrinkle-relaxing treatments.' ],
                            [ 'num' => '02', 'title' => 'Dermal Filler & Volume Restoration', 'desc' => 'Facial anatomy, filler selection, cannula vs. needle techniques, and complication management.' ],
                            [ 'num' => '03', 'title' => 'Skin Assessment & Treatment Planning', 'desc' => 'How to assess skin types, build customized treatment plans, and consult with confidence.' ],
                            [ 'num' => '04', 'title' => 'Business & Practice Development', 'desc' => 'How to launch your own aesthetic practice — marketing, pricing, compliance, and more.' ],
                        ];
                        foreach ( $lessons as $l ) : ?>
                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-lg bg-brand-taupe/20 flex items-center justify-center shrink-0 mt-0.5">
                                <span class="text-brand-taupe font-bold text-sm"><?php echo esc_html( $l['num'] ); ?></span>
                            </div>
                            <div>
                                <div class="text-white font-semibold text-sm mb-1"><?php echo esc_html( $l['title'] ); ?></div>
                                <div class="text-white/50 text-xs leading-relaxed"><?php echo esc_html( $l['desc'] ); ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════
     BOOK CTA BANNER
═══════════════════════════════════════════ -->
<section class="py-20 bg-brand-sage relative overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, rgba(255,255,255,0.6) 1px, transparent 1px); background-size: 28px 28px;"></div>
    <div class="relative max-w-3xl mx-auto px-5 text-center reveal">
        <h2 class="font-serif text-4xl lg:text-5xl text-white font-bold mb-4">Ready to Feel Like You?</h2>
        <p class="text-white/80 text-lg mb-8">
            Book your complimentary consultation today and let our team craft a personalized treatment plan for your skin and wellness goals.
        </p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="<?php echo esc_url( home_url( '/zg-wellness-dermatology-services/' ) ); ?>" class="px-8 py-4 bg-white text-brand-sage font-bold rounded-full hover:bg-brand-sand transition-all shadow-xl text-sm hover:scale-105">
                Schedule Your Visit
            </a>
            <a href="tel:8593443250" class="px-8 py-4 border-2 border-white text-white font-semibold rounded-full hover:bg-white/20 transition-all text-sm inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                (859) 344-3250
            </a>
        </div>
    </div>
</section>

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
                <p class="text-brand-gray/70 text-sm leading-relaxed mb-3">2853 Town Center Blvd<br />Crestview Hills, KY 41017</p>
                <p class="text-brand-gray/50 text-xs">Located in the Crestview Hills Town Center<br />Near Cincinnati · Florence · Erlanger</p>
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
                        <span class="text-brand-dark font-medium">10:00 am – 6:00 pm</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-brand-gray/70">Friday</span>
                        <span class="text-brand-dark font-medium">10:00 am – 5:00 pm</span>
                    </div>
                    <div class="h-px bg-brand-gray/10 my-2"></div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-brand-gray/70">Saturday</span>
                        <span class="text-brand-gray/50">Closed</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-brand-gray/70">Sunday</span>
                        <span class="text-brand-gray/50">Closed</span>
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
                        <a href="tel:8593443250" class="text-brand-sage font-semibold text-base hover:text-brand-mid transition-colors">(859) 344-3250</a>
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

        <div class="reveal grid lg:grid-cols-2 gap-6">
            <div class="rounded-2xl overflow-hidden shadow-md border border-brand-sand h-64 relative group">
                <img src="https://zerogravitynky.com/wp-content/uploads/2019/11/ZGMAP.jpg"
                     alt="Zero Gravity location map — Crestview Hills Town Center"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
            </div>
            <div class="rounded-2xl overflow-hidden shadow-md border border-brand-sand h-64 relative group">
                <img src="https://zerogravitynky.com/wp-content/uploads/2025/07/zg-exterior-web2-e1752804466329-995x1024.png"
                     alt="Zero Gravity Med Spa exterior — Crestview Hills"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                     style="object-position: center 20%;" />
                <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/50 to-transparent"></div>
                <div class="absolute bottom-4 left-4">
                    <div class="text-white font-semibold text-sm">Zero Gravity Med Spa</div>
                    <div class="text-white/70 text-xs">2853 Town Center Blvd, Crestview Hills, KY</div>
                </div>
            </div>
        </div>

    </div>
</section>

<?php get_footer(); ?>
