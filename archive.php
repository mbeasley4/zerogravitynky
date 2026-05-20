<?php
/**
 * Blog / News archive template.
 * Handles: home (blog index), category, tag, date, and author archives.
 */

get_header();

// ── Archive heading ──────────────────────────────────────────────────────────
if ( is_home() && ! is_front_page() ) {
    $archive_title    = single_post_title( '', false );
    $archive_subtitle = '';
} else {
    $archive_title    = wp_strip_all_tags( get_the_archive_title() );
    $archive_subtitle = get_the_archive_description();
}

// Strip "Category:" / "Tag:" prefix WordPress injects
$archive_title = trim( preg_replace( '/^[^:]+:\s*/', '', $archive_title ) );
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
            <?php echo $archive_title ?: 'News &amp; Insights'; ?>
        </h1>
        <div class="w-16 h-1 rounded-full bg-brand-taupe mx-auto mb-5"></div>
        <?php if ( $archive_subtitle ) : ?>
        <p class="text-white/75 text-lg max-w-xl mx-auto">
            <?php echo wp_kses_post( $archive_subtitle ); ?>
        </p>
        <?php else : ?>
        <p class="text-white/75 text-lg max-w-xl mx-auto">
            Expert tips, treatment guides, and wellness inspiration from our team.
        </p>
        <?php endif; ?>
    </div>
</section>

<!-- ═══════════════════════════════════════════
     POST GRID
═══════════════════════════════════════════ -->
<section class="zg-news-section">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">

        <?php if ( have_posts() ) : ?>

        <div class="zg-post-grid">

            <?php while ( have_posts() ) : the_post();

                $thumb      = get_the_post_thumbnail_url( null, 'medium_large' );
                $categories = get_the_category();
                $cat_name   = $categories ? $categories[0]->name : '';
                $cat_url    = $categories ? get_category_link( $categories[0]->term_id ) : '';
                $read_time  = max( 1, (int) ceil( str_word_count( strip_tags( get_the_content() ) ) / 200 ) );
            ?>

            <article <?php post_class( 'zg-post-card reveal' ); ?>>

                <!-- Thumbnail -->
                <a href="<?php the_permalink(); ?>" class="zg-post-card__thumb" tabindex="-1" aria-hidden="true">
                    <?php if ( $thumb ) : ?>
                        <img src="<?php echo esc_url( $thumb ); ?>"
                             alt="<?php the_title_attribute(); ?>"
                             class="zg-post-card__img" loading="lazy" />
                    <?php else : ?>
                        <div class="zg-post-card__img-placeholder">
                            <svg class="w-12 h-12 text-brand-sage/25" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    <?php endif; ?>
                </a>

                <!-- Body -->
                <div class="zg-post-card__body">

                    <!-- Category pill -->
                    <?php if ( $cat_name ) : ?>
                    <a href="<?php echo esc_url( $cat_url ); ?>" class="zg-post-card__cat">
                        <?php echo esc_html( $cat_name ); ?>
                    </a>
                    <?php endif; ?>

                    <!-- Title -->
                    <h2 class="zg-post-card__title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>

                    <!-- Excerpt -->
                    <p class="zg-post-card__excerpt">
                        <?php echo wp_trim_words( get_the_excerpt() ?: get_the_content(), 22, '&hellip;' ); ?>
                    </p>

                    <!-- Meta row -->
                    <div class="zg-post-card__meta">
                        <span class="zg-post-card__date">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <?php echo esc_html( get_the_date( 'M j, Y' ) ); ?>
                        </span>
                        <span class="zg-post-card__read-time">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <?php echo esc_html( $read_time ); ?> min read
                        </span>
                    </div>

                    <!-- Read more -->
                    <a href="<?php the_permalink(); ?>" class="zg-post-card__link" aria-label="Read: <?php the_title_attribute(); ?>">
                        Read article
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>

                </div>
            </article>

            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <nav class="zg-pagination" aria-label="Blog pages">
            <?php echo paginate_links( [
                'prev_text' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg> Prev',
                'next_text' => 'Next <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>',
                'type'      => 'plain',
            ] ); ?>
        </nav>

        <?php else : ?>
        <p class="text-center text-brand-gray py-24 text-lg">No posts found.</p>
        <?php endif; ?>

    </div>
</section>

</main>

<?php get_footer(); ?>
