<?php
/**
 * Default page template.
 * The page-hero block (zerogravitynky/page-hero) is added per-page in the editor.
 */

get_header();
?>

<main id="main-content" tabindex="-1">
<?php while ( have_posts() ) : the_post(); ?>

    <?php the_content(); ?>

<?php endwhile; ?>
</main>

<?php get_footer(); ?>
