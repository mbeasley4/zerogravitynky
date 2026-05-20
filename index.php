<?php get_header(); ?>

<main class="max-w-7xl mx-auto px-5 lg:px-8 py-16">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
    <?php endwhile; endif; ?>
</main>

<?php get_footer(); ?>
