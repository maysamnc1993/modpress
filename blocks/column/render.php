<?php
/**
 * Column Block - ستون
 *
 * @package Developer_Starter
 */

// تنظیمات
$width = get_field('width') ?: 'auto';
$padding = get_field('padding') ?: 'none';
$text_align = get_field('text_align') ?: 'right';
$vertical_align = get_field('vertical_align') ?: 'top';

// پس‌زمینه
$bg_color = get_field('bg_color') ?: '';
$border_radius = get_field('border_radius') ?: 'none';
$shadow = get_field('shadow') ?: 'none';

// عرض ستون
$width_classes = [
    'auto' => '',
    '1/4' => 'md:col-span-1',
    '1/3' => 'md:col-span-1',
    '1/2' => 'md:col-span-1',
    '2/3' => 'md:col-span-2',
    '3/4' => 'md:col-span-3',
    'full' => 'col-span-full',
];

// Padding
$padding_classes = [
    'none' => '',
    'small' => 'p-4',
    'medium' => 'p-6',
    'large' => 'p-8',
];

// تراز متن
$align_classes = [
    'right' => 'text-right',
    'center' => 'text-center',
    'left' => 'text-left',
];

// تراز عمودی
$valign_classes = [
    'top' => 'self-start',
    'center' => 'self-center',
    'bottom' => 'self-end',
];

// گردی گوشه
$radius_classes = [
    'none' => '',
    'small' => 'rounded-lg',
    'medium' => 'rounded-xl',
    'large' => 'rounded-2xl',
];

// سایه
$shadow_classes = [
    'none' => '',
    'small' => 'shadow-sm',
    'medium' => 'shadow-md',
    'large' => 'shadow-xl',
];

$block_id = dst_block_id($block, 'column');
?>

<div
    id="<?php echo esc_attr($block_id); ?>"
    class="dst-column <?php echo esc_attr($width_classes[$width] ?? ''); ?> <?php echo esc_attr($padding_classes[$padding] ?? ''); ?> <?php echo esc_attr($align_classes[$text_align] ?? 'text-right'); ?> <?php echo esc_attr($valign_classes[$vertical_align] ?? ''); ?> <?php echo esc_attr($radius_classes[$border_radius] ?? ''); ?> <?php echo esc_attr($shadow_classes[$shadow] ?? ''); ?>"
    style="<?php echo $bg_color ? "background-color: {$bg_color};" : ''; ?>"
>
    <InnerBlocks />
</div>

<?php
// ثبت فیلدهای ACF
add_action('acf/init', function() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key' => 'group_block_column',
        'title' => 'تنظیمات ستون',
        'fields' => [
            [
                'key' => 'field_column_padding',
                'label' => 'فاصله داخلی',
                'name' => 'padding',
                'type' => 'select',
                'choices' => [
                    'none' => 'بدون فاصله',
                    'small' => 'کم',
                    'medium' => 'متوسط',
                    'large' => 'زیاد',
                ],
                'default_value' => 'none',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_column_align',
                'label' => 'تراز متن',
                'name' => 'text_align',
                'type' => 'button_group',
                'choices' => [
                    'right' => 'راست',
                    'center' => 'وسط',
                    'left' => 'چپ',
                ],
                'default_value' => 'right',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_column_valign',
                'label' => 'تراز عمودی',
                'name' => 'vertical_align',
                'type' => 'button_group',
                'choices' => [
                    'top' => 'بالا',
                    'center' => 'وسط',
                    'bottom' => 'پایین',
                ],
                'default_value' => 'top',
            ],
            [
                'key' => 'field_column_bg',
                'label' => 'رنگ پس‌زمینه',
                'name' => 'bg_color',
                'type' => 'color_picker',
            ],
            [
                'key' => 'field_column_radius',
                'label' => 'گردی گوشه',
                'name' => 'border_radius',
                'type' => 'select',
                'choices' => [
                    'none' => 'بدون گردی',
                    'small' => 'کم',
                    'medium' => 'متوسط',
                    'large' => 'زیاد',
                ],
                'default_value' => 'none',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_column_shadow',
                'label' => 'سایه',
                'name' => 'shadow',
                'type' => 'select',
                'choices' => [
                    'none' => 'بدون سایه',
                    'small' => 'کم',
                    'medium' => 'متوسط',
                    'large' => 'زیاد',
                ],
                'default_value' => 'none',
                'wrapper' => ['width' => '50'],
            ],
        ],
        'location' => [
            [['param' => 'block', 'operator' => '==', 'value' => 'acf/column']],
        ],
    ]);
});
?>
