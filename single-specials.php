<?php
/**
 * Single special template.
 */

get_header();

while ( have_posts() ) : the_post();

    $id    = get_the_ID();
    $thumb = get_the_post_thumbnail_url( null, 'full' );
    $start = get_post_meta( $id, '_special_start_date', true );
    $end   = get_post_meta( $id, '_special_end_date', true );
    $today = current_time( 'Y-m-d' );

    $fmt_start = $start ? date_i18n( 'M j, Y', strtotime( $start ) ) : '';
    $fmt_end   = $end   ? date_i18n( 'M j, Y', strtotime( $end ) )   : '';

    $post_status = get_post_status();
    if ( 'expired' === $post_status ) {
        $status = 'expired'; $status_label = 'Expired';
    } elseif ( $start && $today < $start ) {
        $status = 'upcoming'; $status_label = 'Upcoming';
    } else {
        $status = 'active'; $status_label = 'Active';
    }
?>

<!-- ── Special Hero ───────────────────────────────────────────── -->
<section class="zg-news-hero relative">

    <div class="blob absolute -top-24 -right-24 w-80 h-80 bg-brand-mid/30 blur-3xl pointer-events-none"></div>
    <div class="blob absolute bottom-0 -left-20 w-72 h-72 bg-brand-sage/40 blur-3xl pointer-events-none" style="animation-delay:-3s"></div>
    <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image:radial-gradient(circle,rgba(255,255,255,.4) 1px,transparent 1px);background-size:36px 36px;"></div>

    <div class="relative z-10 max-w-4xl mx-auto px-6 lg:px-8 pt-20 pb-16 text-center">

        <!-- Breadcrumb -->
        <nav aria-label="Breadcrumb" class="flex items-center justify-center gap-1.5 text-xs text-white/50 mb-5">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-white/80 transition-colors">Home</a>
            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'specials' ) ); ?>" class="hover:text-white/80 transition-colors">Specials</a>
        </nav>

        <!-- Status badge -->
        <span class="zg-special-card__status zg-special-card__status--<?php echo esc_attr( $status ); ?> inline-block mb-5">
            <?php echo esc_html( $status_label ); ?>
        </span>

        <h1 class="font-serif text-4xl lg:text-5xl font-bold text-white leading-tight mb-4">
            <?php the_title(); ?>
        </h1>
        <div class="w-16 h-1 rounded-full bg-brand-taupe mx-auto mb-6"></div>

        <!-- Date range -->
        <?php if ( $fmt_start || $fmt_end ) : ?>
        <div class="flex items-center justify-center gap-1.5 text-white/70 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
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

    </div>
</section>

<!-- ── Featured image ────────────────────────────────────────── -->
<?php if ( $thumb ) : ?>
<div class="zg-post-feature-img">
    <img src="<?php echo esc_url( $thumb ); ?>"
         alt="<?php the_title_attribute(); ?>"
         class="w-full h-full object-cover" loading="eager" />
</div>
<?php endif; ?>

<!-- ── Article body ──────────────────────────────────────────── -->
<div class="zg-post-wrap">
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'zg-post-article' ); ?>>

        <div class="entry-content">
            <?php the_content(); ?>
        </div>

        <!-- Book CTA -->
        <div class="mt-10 pt-8 border-t border-black/10 text-center">
            <p class="text-brand-gray mb-4 text-sm">Ready to take advantage of this special?</p>
            <a href="<?php echo esc_url( home_url( '/zg-wellness-dermatology-services/' ) ); ?>"
               class="inline-flex items-center gap-2 px-8 py-4 bg-brand-taupe text-white font-semibold rounded-full shadow-lg hover:scale-105 transition">
                Book a Consultation
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

    </article>

    <!-- Back to specials -->
    <div class="text-center mt-12">
        <a href="<?php echo esc_url( get_post_type_archive_link( 'specials' ) ); ?>"
           class="inline-flex items-center gap-2 text-sm font-medium text-brand-sage hover:text-brand-dark transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Specials
        </a>
    </div>

</div>

<?php endwhile; ?>

<?php get_footer(); ?>
