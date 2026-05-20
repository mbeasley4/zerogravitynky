<?php
/**
 * Staff CPT archive — card grid with profile modals.
 */

get_header();

$book_url = home_url( '/zg-wellness-dermatology-services/' );

/**
 * Split a staff post title into name + role.
 * e.g. "Jennifer Walsh, RN, Partner" → [ 'Jennifer Walsh', 'RN, Partner' ]
 */
function zg_parse_staff_title( $title ) {
    $pos = strpos( $title, ',' );
    if ( $pos === false ) {
        return [ 'name' => $title, 'role' => '' ];
    }
    return [
        'name' => trim( substr( $title, 0, $pos ) ),
        'role' => trim( substr( $title, $pos + 1 ) ),
    ];
}

$staff_query = new WP_Query( [
    'post_type'      => 'staff',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
] );
?>

<main id="main-content" tabindex="-1">
<!-- ═══════════════════════════════════════════
     HERO
═══════════════════════════════════════════ -->
<section class="zg-news-hero">
    <div class="blob absolute -top-24 -right-24 w-80 h-80 bg-brand-mid/30 blur-3xl pointer-events-none"></div>
    <div class="blob absolute bottom-0 -left-20 w-72 h-72 bg-brand-sage/40 blur-3xl pointer-events-none" style="animation-delay:-3s"></div>
    <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image:radial-gradient(circle,rgba(255,255,255,.4) 1px,transparent 1px);background-size:36px 36px;"></div>

    <div class="relative z-10 max-w-3xl mx-auto px-6 lg:px-8 py-20 text-center">
        <p class="uppercase tracking-widest text-brand-taupe text-xs font-semibold mb-4">
            Zero Gravity Aesthetics &amp; Wellness
        </p>
        <h1 class="font-serif text-5xl md:text-6xl font-bold text-white leading-tight mb-4">
            Meet Our Expert Team
        </h1>
        <div class="w-16 h-1 rounded-full bg-brand-taupe mx-auto mb-5"></div>
        <p class="text-white/75 text-lg max-w-2xl mx-auto mb-10">
            Our licensed nurse practitioners, RNs, and estheticians bring 20+ years of combined expertise to every treatment — putting your safety and results first.
        </p>
        <a href="<?php echo esc_url( $book_url ); ?>" class="inline-flex items-center gap-2 px-8 py-4 bg-brand-taupe text-white font-semibold rounded-full shadow-lg hover:scale-105 transition">
            Book a Consultation
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>
</section>

<!-- ═══════════════════════════════════════════
     STAFF GRID
═══════════════════════════════════════════ -->
<section class="py-24 bg-linear-to-b from-white to-brand-sand">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">

        <?php if ( $staff_query->have_posts() ) : ?>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            <?php while ( $staff_query->have_posts() ) : $staff_query->the_post();
                $id      = get_the_ID();
                $parsed  = zg_parse_staff_title( get_the_title() );
                $name    = $parsed['name'];
                $role    = $parsed['role'];
                $photo   = get_the_post_thumbnail_url( $id, 'medium_large' );
                $content = apply_filters( 'the_content', get_post_field( 'post_content', $id ) );
            ?>

            <!-- Card -->
            <div class="staff-card reveal">
                <?php if ( $photo ) : ?>
                    <img src="<?php echo esc_url( $photo ); ?>"
                         alt="<?php echo esc_attr( $name ); ?>"
                         class="staff-card__photo" />
                <?php else : ?>
                    <div class="staff-card__photo-placeholder">
                        <svg class="w-16 h-16 text-brand-sage/30" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                        </svg>
                    </div>
                <?php endif; ?>

                <div class="staff-card__body">
                    <p class="staff-card__name"><?php echo esc_html( $name ); ?></p>
                    <?php if ( $role ) : ?>
                        <p class="staff-card__role"><?php echo esc_html( $role ); ?></p>
                    <?php endif; ?>
                    <button class="staff-card__btn"
                            data-staff-id="<?php echo esc_attr( $id ); ?>"
                            aria-haspopup="dialog">
                        View Profile
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Hidden modal data for this staff member -->
            <template id="staff-tpl-<?php echo esc_attr( $id ); ?>"
                      data-name="<?php echo esc_attr( $name ); ?>"
                      data-role="<?php echo esc_attr( $role ); ?>"
                      data-photo="<?php echo esc_attr( $photo ); ?>">
                <?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </template>

            <?php endwhile; wp_reset_postdata(); ?>

        </div>

        <?php else : ?>
        <p class="text-center text-brand-gray py-20">No staff profiles found.</p>
        <?php endif; ?>

    </div>
</section>

<!-- ═══════════════════════════════════════════
     CALLOUT — ABOUT & NEWS
═══════════════════════════════════════════ -->
<section class="py-20 bg-brand-dark">
    <div class="max-w-5xl mx-auto px-5 lg:px-8">

        <p class="text-center uppercase tracking-widest text-brand-mid text-xs font-semibold mb-3">Explore More</p>
        <h2 class="font-serif text-3xl md:text-4xl font-bold text-white text-center mb-10">Get to Know Us</h2>

        <div class="grid sm:grid-cols-2 gap-6">

            <!-- About card -->
            <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"
               class="group relative overflow-hidden rounded-2xl bg-hero-gradient p-8 flex flex-col justify-between min-h-50 shadow-xl hover:shadow-2xl hover:scale-[1.02] transition-all reveal">
                <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image:radial-gradient(circle,rgba(255,255,255,.5) 1px,transparent 1px);background-size:28px 28px;"></div>
                <div class="relative z-10">
                    <span class="inline-block px-3 py-1 rounded-full bg-white/20 text-white text-xs font-semibold uppercase tracking-widest mb-4">Our Story</span>
                    <h3 class="font-serif text-2xl font-bold text-white mb-2">About Zero Gravity</h3>
                    <p class="text-white/75 text-sm leading-relaxed">Learn about our mission, our practice philosophy, and the values that drive every treatment we offer.</p>
                </div>
                <div class="relative z-10 mt-6 inline-flex items-center gap-2 text-white font-semibold text-sm group-hover:gap-3 transition-all">
                    Learn More
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </div>
            </a>

            <!-- News card -->
            <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/news/' ) ); ?>"
               class="group relative overflow-hidden rounded-2xl p-8 flex flex-col justify-between min-h-50 shadow-xl hover:shadow-2xl hover:scale-[1.02] transition-all reveal"
               style="background:linear-gradient(135deg,#9EAF9F 0%,#7A8F7B 55%,#5C7060 100%)">
                <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image:radial-gradient(circle,rgba(255,255,255,.5) 1px,transparent 1px);background-size:28px 28px;"></div>
                <div class="relative z-10">
                    <span class="inline-block px-3 py-1 rounded-full bg-white/20 text-white text-xs font-semibold uppercase tracking-widest mb-4">Latest Updates</span>
                    <h3 class="font-serif text-2xl font-bold text-white mb-2">News &amp; Insights</h3>
                    <p class="text-white/75 text-sm leading-relaxed">Stay up to date with skincare tips, wellness advice, and the latest news from our team.</p>
                </div>
                <div class="relative z-10 mt-6 inline-flex items-center gap-2 text-white font-semibold text-sm group-hover:gap-3 transition-all">
                    Read the Blog
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </div>
            </a>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════
     PROFILE MODAL
═══════════════════════════════════════════ -->
<div id="staff-modal-backdrop" class="staff-modal-backdrop" role="dialog" aria-modal="true" aria-labelledby="staff-modal-name">
    <div class="staff-modal-box">

        <button id="staff-modal-close" class="staff-modal-close" aria-label="Close profile">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- Populated by JS -->
        <div class="staff-modal-header">
            <p id="staff-modal-name" class="staff-modal-header-name"></p>
            <p id="staff-modal-role" class="staff-modal-header-role"></p>
        </div>

        <div id="staff-modal-content" class="staff-modal-content"></div>

    </div>
</div>

<script>
(function () {
    const backdrop  = document.getElementById('staff-modal-backdrop');
    const closeBtn  = document.getElementById('staff-modal-close');
    const nameEl    = document.getElementById('staff-modal-name');
    const roleEl    = document.getElementById('staff-modal-role');
    const contentEl = document.getElementById('staff-modal-content');

    function openModal(id) {
        const tpl = document.getElementById('staff-tpl-' + id);
        if (!tpl) return;

        const name  = tpl.dataset.name;
        const role  = tpl.dataset.role;
        const photo = tpl.dataset.photo;

        nameEl.textContent = name;
        roleEl.textContent = role;

        contentEl.innerHTML = tpl.innerHTML;

        // Remove the inline portrait column (already shown in the modal header),
        // but keep the sibling text column that contains the profile description.
        var firstImg = contentEl.querySelector('.wp-block-image');
        if (firstImg) {
            var photoCol = firstImg.closest('.wp-block-column');
            var colsWrap = firstImg.closest('.wp-block-columns');
            if (photoCol && colsWrap) {
                photoCol.remove();
                // If only the text column remains, unwrap it so it renders full-width
                if (colsWrap.children.length === 1) {
                    var textCol = colsWrap.firstElementChild;
                    while (textCol.firstChild) {
                        colsWrap.parentNode.insertBefore(textCol.firstChild, colsWrap);
                    }
                    colsWrap.remove();
                }
            }
        }

        backdrop.scrollTop = 0;
        backdrop.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        backdrop.classList.remove('is-open');
        document.body.style.overflow = '';
    }

    // Delegate click on all "View Profile" buttons
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('[data-staff-id]');
        if (btn) {
            openModal(btn.dataset.staffId);
            return;
        }
        // Close when clicking backdrop itself (outside the box)
        if (e.target === backdrop) closeModal();
    });

    closeBtn.addEventListener('click', closeModal);

    // Close on Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && backdrop.classList.contains('is-open')) closeModal();
    });
})();
</script>
</main>

<?php get_footer(); ?>
