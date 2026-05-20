<?php
/**
 * Specials CPT archive — active specials + paginated expired section.
 */

get_header();

$today = current_time( 'Y-m-d' );  

// ── Active specials (published, end date >= today OR no end date) ─────────────
$active_query = new WP_Query( [
    'post_type'      => 'specials',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'DESC',
] );

$active_specials = [];
if ( $active_query->have_posts() ) {
    while ( $active_query->have_posts() ) {
        $active_query->the_post();
        $id    = get_the_ID();
        $start = get_post_meta( $id, '_special_start_date', true );
        $end   = get_post_meta( $id, '_special_end_date', true );

        // Skip if end date is in the past (shouldn't happen if cron ran, but safety check)
        if ( $end && $end < $today ) {
            continue;
        }

        $active_specials[] = [
            'post'  => $GLOBALS['post'],
            'start' => $start,
            'end'   => $end,
        ];
    }
    wp_reset_postdata();
}

// Sort active: items with end dates first (soonest expiring first), then undated
$active_with_dates    = array_filter( $active_specials, fn( $p ) => ! empty( $p['end'] ) );
$active_without_dates = array_filter( $active_specials, fn( $p ) => empty( $p['end'] ) );
usort( $active_with_dates, fn( $a, $b ) => strcmp( $a['end'], $b['end'] ) );
$active_specials = array_merge( array_values( $active_with_dates ), array_values( $active_without_dates ) );

// ── Expired specials (paginated, 12 per page) ─────────────────────────────────
$expired_page = max( 1, (int) ( $_GET['expired_page'] ?? 1 ) ); // phpcs:ignore WordPress.Security.NonceVerification
$expired_per_page = 12;

$expired_query = new WP_Query( [
    'post_type'      => 'specials',
    'post_status'    => 'expired',
    'posts_per_page' => $expired_per_page,
    'paged'          => $expired_page,
    'orderby'        => 'meta_value',
    'meta_key'       => '_special_end_date',
    'order'          => 'DESC',
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
            Current Specials
        </h1>
        <div class="w-16 h-1 rounded-full bg-brand-taupe mx-auto mb-5"></div>
        <p class="text-white/75 text-lg max-w-xl mx-auto">
            Exclusive offers and limited-time promotions from our team. Book before they're gone.
        </p>
    </div>
</section>

<!-- ═══════════════════════════════════════════
     ACTIVE SPECIALS
═══════════════════════════════════════════ -->
<section class="zg-news-section">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">

        <?php if ( ! empty( $active_specials ) ) : ?>

        <div class="zg-specials-grid">

            <?php foreach ( $active_specials as $item ) :
                $GLOBALS['post'] = $item['post'];
                setup_postdata( $item['post'] );

                $id      = $item['post']->ID;
                $start   = $item['start'];
                $end     = $item['end'];
                $thumb   = get_the_post_thumbnail_url( $id, 'medium_large' );
                $excerpt = wp_trim_words( get_the_excerpt() ?: get_the_content(), 22, '&hellip;' );

                if ( $start && $today < $start ) {
                    $status = 'upcoming'; $status_label = 'Upcoming';
                } else {
                    $status = 'active'; $status_label = 'Active';
                }

                $fmt_start = $start ? date_i18n( 'M j, Y', strtotime( $start ) ) : '';
                $fmt_end   = $end   ? date_i18n( 'M j, Y', strtotime( $end ) )   : '';
            ?>

            <article class="zg-special-card reveal <?php echo esc_attr( 'zg-special-card--' . $status ); ?>">
                <div class="zg-special-card-inner">
                    <div class="zg-special-card__body">

                        <span class="zg-special-card__status zg-special-card__status--<?php echo esc_attr( $status ); ?>">
                            <?php echo esc_html( $status_label ); ?>
                        </span>

                        <h2 class="zg-special-card__title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>

                        <p class="zg-special-card__excerpt"><?php echo $excerpt; // phpcs:ignore ?></p>

                        <?php if ( $fmt_start || $fmt_end ) : ?>
                        <div class="zg-special-card__dates">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <?php if ( $fmt_start && $fmt_end ) : ?>
                                <?php echo esc_html( $fmt_start ); ?> &ndash; <?php echo esc_html( $fmt_end ); ?>
                            <?php elseif ( $fmt_end ) : ?>
                                Ends <?php echo esc_html( $fmt_end ); ?>
                            <?php else : ?>
                                Starts <?php echo esc_html( $fmt_start ); ?>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>

                        <a href="<?php the_permalink(); ?>" class="zg-special-card__link" aria-label="View special: <?php the_title_attribute(); ?>">
                            View Special
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>

                    </div>
                </div>
            </article>

            <?php endforeach; wp_reset_postdata(); ?>
        </div>

        <?php else : ?>

        <!-- No active specials message -->
        <div class="zg-specials-empty">
            <div class="zg-specials-empty__icon" aria-hidden="true">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
            <h2 class="zg-specials-empty__heading">No Active Specials Right Now</h2>
            <p class="zg-specials-empty__text">
                We're always cooking up something special. Check back soon for exclusive savings and limited-time promotions!
            </p>
            <a href="<?php echo esc_url( home_url( '/book-appointment/' ) ); ?>" class="zg-specials-empty__cta">
                Book an Appointment
            </a>
        </div>

        <?php endif; ?>

    </div>
</section>

<!-- ═══════════════════════════════════════════
     EXPIRED SPECIALS
═══════════════════════════════════════════ -->
<?php if ( $expired_query->have_posts() ) : ?>
<section class="zg-specials-expired-section">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">

        <div class="zg-specials-expired-header">
            <h2 class="zg-specials-expired-header__title">Past Specials</h2>
            <p class="zg-specials-expired-header__subtitle">These promotions have ended, but great deals are always on the horizon.</p>
        </div>

        <div class="zg-specials-grid zg-specials-grid--expired">

            <?php while ( $expired_query->have_posts() ) : $expired_query->the_post();
                $id      = get_the_ID();
                $start   = get_post_meta( $id, '_special_start_date', true );
                $end     = get_post_meta( $id, '_special_end_date', true );
                $excerpt = wp_trim_words( get_the_excerpt() ?: get_the_content(), 22, '&hellip;' );

                $fmt_start = $start ? date_i18n( 'M j, Y', strtotime( $start ) ) : '';
                $fmt_end   = $end   ? date_i18n( 'M j, Y', strtotime( $end ) )   : '';
            ?>

            <article class="zg-special-card zg-special-card--expired" aria-label="Expired special">
                <div class="zg-special-card-inner">
                    <div class="zg-special-card__body">

                        <span class="zg-special-card__status zg-special-card__status--expired">
                            Expired
                        </span>

                        <h2 class="zg-special-card__title">
                            <?php the_title(); ?>
                        </h2>

                        <p class="zg-special-card__excerpt"><?php echo $excerpt; // phpcs:ignore ?></p>

                        <?php if ( $fmt_start || $fmt_end ) : ?>
                        <div class="zg-special-card__dates">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <?php if ( $fmt_start && $fmt_end ) : ?>
                                <?php echo esc_html( $fmt_start ); ?> &ndash; <?php echo esc_html( $fmt_end ); ?>
                            <?php elseif ( $fmt_end ) : ?>
                                Ended <?php echo esc_html( $fmt_end ); ?>
                            <?php else : ?>
                                <?php echo esc_html( $fmt_start ); ?>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>

                    </div>
                </div>
            </article>

            <?php endwhile; wp_reset_postdata(); ?>
        </div>

        <?php
        // Pagination
        $total_expired_pages = $expired_query->max_num_pages;
        if ( $total_expired_pages > 1 ) :
            $base_url = get_post_type_archive_link( 'specials' );
        ?>
        <nav class="zg-specials-pagination" aria-label="Past specials pagination">
            <?php if ( $expired_page > 1 ) : ?>
            <a href="<?php echo esc_url( add_query_arg( 'expired_page', $expired_page - 1, $base_url ) ); ?>" class="zg-specials-pagination__btn zg-specials-pagination__btn--prev">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Previous
            </a>
            <?php endif; ?>

            <span class="zg-specials-pagination__info">
                Page <?php echo esc_html( $expired_page ); ?> of <?php echo esc_html( $total_expired_pages ); ?>
            </span>

            <?php if ( $expired_page < $total_expired_pages ) : ?>
            <a href="<?php echo esc_url( add_query_arg( 'expired_page', $expired_page + 1, $base_url ) ); ?>" class="zg-specials-pagination__btn zg-specials-pagination__btn--next">
                Next
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            <?php endif; ?>
        </nav>
        <?php endif; ?>

    </div>
</section>
<?php endif; ?>
</main>

<?php get_footer(); ?>
