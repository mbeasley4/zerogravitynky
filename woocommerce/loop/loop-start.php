<?php
/**
 * Product loop start.
 * Overrides woocommerce/templates/loop/loop-start.php
 */

defined( 'ABSPATH' ) || exit;

echo apply_filters(  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    'woocommerce_product_loop_start',
    '<ul class="products grid grid-cols-1 sm:grid-cols-4 gap-4">'
);
