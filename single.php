<?php
/**
 * Single post template.
 */

get_header();

while ( have_posts() ) : the_post();

    $categories = get_the_category();
    $cat_name   = $categories ? $categories[0]->name : '';
    $cat_url    = $categories ? get_category_link( $categories[0]->term_id ) : '';
    $thumb      = get_the_post_thumbnail_url( null, 'full' );
    $read_time  = max( 1, (int) ceil( str_word_count( strip_tags( get_the_content() ) ) / 200 ) );

    // Page-hero block takes over its own hero; only show custom hero when not present
    $has_hero_block = has_block( 'zerogravitynky/page-hero' );
?>

<main id="main-content" tabindex="-1">
<?php if ( ! $has_hero_block ) : ?>
<!-- ── Post Hero ──────────────────────────────────────────────────── -->
<section class="zg-news-hero relative">

    <div class="blob absolute -top-24 -right-24 w-80 h-80 bg-brand-mid/30 blur-3xl pointer-events-none"></div>
    <div class="blob absolute bottom-0 -left-20 w-72 h-72 bg-brand-sage/40 blur-3xl pointer-events-none" style="animation-delay:-3s"></div>
    <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image:radial-gradient(circle,rgba(255,255,255,.4) 1px,transparent 1px);background-size:36px 36px;"></div>

    <div class="relative z-10 max-w-4xl mx-auto px-6 lg:px-8 pt-20 pb-16 text-center">

        <!-- Breadcrumb -->
        <nav aria-label="Breadcrumb" class="flex items-center justify-center gap-1.5 text-xs text-white/50 mb-5">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-white/80 transition-colors">Home</a>
            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/news/' ) ); ?>" class="hover:text-white/80 transition-colors">News</a>
            <?php if ( $cat_name ) : ?>
            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="<?php echo esc_url( $cat_url ); ?>" class="hover:text-white/80 transition-colors"><?php echo esc_html( $cat_name ); ?></a>
            <?php endif; ?>
        </nav>

        <!-- Category pill -->
        <?php if ( $cat_name ) : ?>
        <a href="<?php echo esc_url( $cat_url ); ?>" class="inline-block bg-brand-taupe/20 text-brand-taupe-light text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider mb-5">
            <?php echo esc_html( $cat_name ); ?>
        </a>
        <?php endif; ?>

        <h1 class="font-serif text-4xl lg:text-5xl font-bold text-white leading-tight mb-4">
            <?php the_title(); ?>
        </h1>
        <div class="w-16 h-1 rounded-full bg-brand-taupe mx-auto mb-6"></div>

        <!-- Meta -->
        <div class="flex items-center justify-center gap-4 flex-wrap text-white/60 text-sm">
            <span class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <?php echo esc_html( get_the_date( 'F j, Y' ) ); ?>
            </span>
            <?php if ( get_the_author() ) : ?>
            <span class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <?php the_author(); ?>
            </span>
            <?php endif; ?>
            <span class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <?php echo esc_html( $read_time ); ?> min read
            </span>
        </div>

    </div>
</section>
<?php endif; // ! $has_hero_block ?>

<!-- ── Featured image (only when no block hero) ──── -->
<?php if ( $thumb && ! $has_hero_block ) : ?>
<div class="zg-post-feature-img">
    <img src="<?php echo esc_url( $thumb ); ?>"
         alt="<?php the_title_attribute(); ?>"
         class="w-full h-full object-cover" loading="eager" />
</div>
<?php endif; ?>

<!-- ── Article body ──────────────────────────────── -->
<div class="zg-post-wrap">
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'zg-post-article' ); ?>>

        <div class="entry-content">
            <?php the_content(); ?>
        </div>

        <!-- Footer: tags + nav -->
        <?php $tags = get_the_tags(); ?>
        <?php if ( $tags ) : ?>
        <div class="zg-post-tags">
            <span class="zg-post-tags__label">Tags:</span>
            <?php foreach ( $tags as $tag ) : ?>
            <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="zg-post-tag">
                <?php echo esc_html( $tag->name ); ?>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Prev / Next -->
        <nav class="zg-post-prevnext" aria-label="Post navigation">
            <?php
            $prev = get_previous_post();
            $next = get_next_post();
            ?>
            <?php if ( $prev ) : ?>
            <a href="<?php echo esc_url( get_permalink( $prev ) ); ?>" class="zg-post-prevnext__link">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                <span>
                    <span class="zg-post-prevnext__dir">Previous</span>
                    <span class="zg-post-prevnext__title"><?php echo esc_html( get_the_title( $prev ) ); ?></span>
                </span>
            </a>
            <?php else : ?>
            <span></span>
            <?php endif; ?>
            <?php if ( $next ) : ?>
            <a href="<?php echo esc_url( get_permalink( $next ) ); ?>" class="zg-post-prevnext__link zg-post-prevnext__link--next">
                <span>
                    <span class="zg-post-prevnext__dir">Next</span>
                    <span class="zg-post-prevnext__title"><?php echo esc_html( get_the_title( $next ) ); ?></span>
                </span>
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            <?php endif; ?>
        </nav>

    </article>

    <!-- Back to news -->
    <div class="text-center mt-12">
        <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/news/' ) ); ?>"
           class="inline-flex items-center gap-2 text-sm font-medium text-brand-sage hover:text-brand-dark transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to News
        </a>
    </div>

</div>

<?php endwhile; ?>
</main>

<?php get_footer(); ?>
