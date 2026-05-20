<?php
$items = $attributes['items'] ?? [
    'Botox & Fillers',
    'Custom Facials & Peels',
    'Laser Hair Removal',
    'Body Contouring',
    'IV Therapy & Wellness',
    'Weight Loss Programs',
    'Spray Tan',
    'Eyelash Extensions',
    'Memberships Available',
    'ZG Aesthetics Academy',
];
?>
<div class="bg-brand-sand py-3 overflow-hidden relative">
    <div class="flex gap-12 whitespace-nowrap" style="animation: scroll 25s linear infinite;">
        <span class="flex gap-12 shrink-0">
            <?php foreach ( $items as $i => $item ) : ?>
                <span class="<?php echo $i % 2 === 0 ? 'text-brand-dark font-semibold' : 'text-brand-gray'; ?> text-sm<?php echo $i % 2 === 0 ? ' tracking-wide' : ''; ?>">
                    ✦ <?php echo esc_html( $item ); ?>
                </span>
            <?php endforeach; ?>
        </span>
        <span class="flex gap-12 shrink-0" aria-hidden="true">
            <?php foreach ( $items as $i => $item ) : ?>
                <span class="<?php echo $i % 2 === 0 ? 'text-brand-dark font-semibold' : 'text-brand-gray'; ?> text-sm<?php echo $i % 2 === 0 ? ' tracking-wide' : ''; ?>">
                    ✦ <?php echo esc_html( $item ); ?>
                </span>
            <?php endforeach; ?>
        </span>
    </div>
</div>
