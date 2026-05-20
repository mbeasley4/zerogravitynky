<?php
/**
 * Single product page template.
 * Overrides woocommerce/templates/single-product.php
 *
 * Provides a clean constrained wrapper so the floated gallery + summary
 * columns are cleared before the footer renders.
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="main-content" class="single-product-wrap">
    <div class="single-product-inner">
        <?php
        while ( have_posts() ) :
            the_post();
            wc_get_template_part( 'content', 'single-product' );
        endwhile;
        ?>
    </div>
</main>

<?php get_footer();
