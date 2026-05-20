<?php
/**
 * Dynamic render for zerogravitynky/zg-column block.
 * PHP builds the classes fresh on every request — no stale saved HTML.
 * $content holds the serialized inner blocks HTML (saved by InnerBlocks.Content in save.js).
 */

defined( 'ABSPATH' ) || exit;

$padding_map = [
    'none' => '',
    'sm'   => 'py-8',
    'md'   => 'py-12',
    'lg'   => 'py-20',
];

$bg_map = [
    'none'     => '',
    'white'    => 'zg-column--bg-white',
    'sand'     => 'zg-column--bg-sand',
    'dark'     => 'zg-column--bg-dark',
    'sage'     => 'zg-column--bg-sage',
];

$classes = array_filter( [
    'zg-column',
    'max-w-7xl',
    'mx-auto',
    'px-5',
    'lg:px-8',
    $padding_map[ $attributes['padding']    ?? 'md'   ] ?? '',
    $bg_map[      $attributes['background'] ?? 'none' ] ?? '',
    ( $attributes['rounded']  ?? true  ) ? 'zg-column--rounded'  : '',
    ( $attributes['bordered'] ?? false ) ? 'zg-column--bordered' : '',
    ( $attributes['shadow']   ?? false ) ? 'zg-column--shadow'   : '',
] );

$wrapper_attrs = get_block_wrapper_attributes( [
    'class' => implode( ' ', $classes ),
] );
?>
<div <?php echo $wrapper_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
    <?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</div>
