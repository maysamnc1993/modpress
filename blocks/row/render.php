<?php
/**
 * Row Block - ردیف با ستون‌بندی
 *
 * @package Developer_Starter
 */

// تنظیمات ستون‌ها
$columns_layout = get_field('columns_layout') ?: '1';
$columns_gap = get_field('columns_gap') ?: 'medium';
$vertical_align = get_field('vertical_align') ?: 'top';
$reverse_mobile = get_field('reverse_mobile') ?: false;

// تنظیمات ظاهری
$container_width = get_field('container_width') ?: 'contained';
$padding_top = get_field('padding_top') ?: 'medium';
$padding_bottom = get_field('padding_bottom') ?: 'medium';

// پس‌زمینه
$bg_type = get_field('bg_type') ?: 'none';
$bg_color = get_field('bg_color') ?: '';
$bg_gradient = get_field('bg_gradient') ?: '';
$bg_image = get_field('bg_image');
$bg_overlay = get_field('bg_overlay') ?: '';
$bg_parallax = get_field('bg_parallax') ?: false;

// حاشیه
$border_top = get_field('border_top') ?: false;
$border_bottom = get_field('border_bottom') ?: false;
$border_color = get_field('border_color') ?: '#e5e7eb';

// انیمیشن
$animation = get_field('animation') ?: 'none';

// کلاس‌های ستون‌ها
$layout_classes = [
    '1' => 'grid-cols-1',
    '2' => 'grid-cols-1 md:grid-cols-2',
    '3' => 'grid-cols-1 md:grid-cols-3',
    '4' => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-4',
    '1-2' => 'grid-cols-1 md:grid-cols-3',
    '2-1' => 'grid-cols-1 md:grid-cols-3',
    '1-3' => 'grid-cols-1 md:grid-cols-4',
    '3-1' => 'grid-cols-1 md:grid-cols-4',
    '1-1-2' => 'grid-cols-1 md:grid-cols-4',
    '2-1-1' => 'grid-cols-1 md:grid-cols-4',
];

// کلاس‌های فاصله
$gap_classes = [
    'none' => 'gap-0',
    'small' => 'gap-4',
    'medium' => 'gap-6 lg:gap-8',
    'large' => 'gap-8 lg:gap-12',
];

// تراز عمودی
$valign_classes = [
    'top' => 'items-start',
    'center' => 'items-center',
    'bottom' => 'items-end',
    'stretch' => 'items-stretch',
];

// Padding
$pt_classes = [
    'none' => 'pt-0',
    'small' => 'pt-8',
    'medium' => 'pt-16',
    'large' => 'pt-24',
    'xlarge' => 'pt-32',
];
$pb_classes = [
    'none' => 'pb-0',
    'small' => 'pb-8',
    'medium' => 'pb-16',
    'large' => 'pb-24',
    'xlarge' => 'pb-32',
];

$block_id = dst_block_id($block, 'row');

// استایل‌های inline
$section_styles = [];
if ($bg_type === 'color' && $bg_color) {
    $section_styles[] = "background-color: {$bg_color}";
}
if ($bg_type === 'gradient' && $bg_gradient) {
    $section_styles[] = "background: {$bg_gradient}";
}
?>

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="dst-block dst-row relative <?php echo esc_attr($pt_classes[$padding_top] ?? 'pt-16'); ?> <?php echo esc_attr($pb_classes[$padding_bottom] ?? 'pb-16'); ?> <?php echo $border_top ? 'border-t' : ''; ?> <?php echo $border_bottom ? 'border-b' : ''; ?>"
    style="<?php echo esc_attr(implode('; ', $section_styles)); ?> <?php echo ($border_top || $border_bottom) ? "border-color: {$border_color};" : ''; ?>"
    <?php if ($animation !== 'none'): ?>
    x-data="{ shown: false }"
    x-intersect:enter="shown = true"
    <?php endif; ?>
>
    <?php if ($bg_type === 'image' && $bg_image): ?>
        <div class="absolute inset-0 z-0 <?php echo $bg_parallax ? 'bg-fixed' : ''; ?>" style="background-image: url('<?php echo esc_url($bg_image['url']); ?>'); background-size: cover; background-position: center;"></div>
        <?php if ($bg_overlay): ?>
            <div class="absolute inset-0 z-0" style="background: <?php echo esc_attr($bg_overlay); ?>;"></div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="<?php echo $container_width === 'full' ? 'w-full px-4' : 'container mx-auto px-4'; ?> relative z-10">
        <div
            class="grid <?php echo esc_attr($layout_classes[$columns_layout] ?? 'grid-cols-1'); ?> <?php echo esc_attr($gap_classes[$columns_gap] ?? 'gap-6'); ?> <?php echo esc_attr($valign_classes[$vertical_align] ?? 'items-start'); ?> <?php echo $reverse_mobile ? 'flex-col-reverse md:flex-row' : ''; ?>"
            <?php if ($animation !== 'none'): ?>
            x-show="shown"
            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 <?php echo $animation === 'slide-up' ? 'translate-y-8' : ''; ?>"
            x-transition:enter-end="opacity-100 translate-y-0"
            <?php endif; ?>
        >
            <InnerBlocks />
        </div>
    </div>
</section>

<?php
// ثبت فیلدهای ACF
add_action('acf/init', function() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key' => 'group_block_row',
        'title' => 'تنظیمات ردیف',
        'fields' => [
            // تب ستون‌ها
            [
                'key' => 'field_row_tab_layout',
                'label' => 'ستون‌بندی',
                'type' => 'tab',
            ],
            [
                'key' => 'field_row_columns',
                'label' => 'تعداد ستون',
                'name' => 'columns_layout',
                'type' => 'select',
                'choices' => [
                    '1' => '۱ ستون (تمام عرض)',
                    '2' => '۲ ستون برابر',
                    '3' => '۳ ستون برابر',
                    '4' => '۴ ستون برابر',
                    '1-2' => '۱/۳ + ۲/۳',
                    '2-1' => '۲/۳ + ۱/۳',
                    '1-3' => '۱/۴ + ۳/۴',
                    '3-1' => '۳/۴ + ۱/۴',
                    '1-1-2' => '۱/۴ + ۱/۴ + ۲/۴',
                    '2-1-1' => '۲/۴ + ۱/۴ + ۱/۴',
                ],
                'default_value' => '2',
            ],
            [
                'key' => 'field_row_gap',
                'label' => 'فاصله بین ستون‌ها',
                'name' => 'columns_gap',
                'type' => 'select',
                'choices' => [
                    'none' => 'بدون فاصله',
                    'small' => 'کم',
                    'medium' => 'متوسط',
                    'large' => 'زیاد',
                ],
                'default_value' => 'medium',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_row_valign',
                'label' => 'تراز عمودی',
                'name' => 'vertical_align',
                'type' => 'select',
                'choices' => [
                    'top' => 'بالا',
                    'center' => 'وسط',
                    'bottom' => 'پایین',
                    'stretch' => 'کشیده',
                ],
                'default_value' => 'top',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_row_reverse',
                'label' => 'معکوس در موبایل',
                'name' => 'reverse_mobile',
                'type' => 'true_false',
                'message' => 'ترتیب ستون‌ها در موبایل برعکس شود',
            ],

            // تب فاصله‌گذاری
            [
                'key' => 'field_row_tab_spacing',
                'label' => 'فاصله‌گذاری',
                'type' => 'tab',
            ],
            [
                'key' => 'field_row_container',
                'label' => 'عرض محتوا',
                'name' => 'container_width',
                'type' => 'button_group',
                'choices' => [
                    'contained' => 'محدود',
                    'full' => 'تمام عرض',
                ],
                'default_value' => 'contained',
            ],
            [
                'key' => 'field_row_pt',
                'label' => 'فاصله بالا',
                'name' => 'padding_top',
                'type' => 'select',
                'choices' => [
                    'none' => 'بدون فاصله',
                    'small' => 'کم',
                    'medium' => 'متوسط',
                    'large' => 'زیاد',
                    'xlarge' => 'خیلی زیاد',
                ],
                'default_value' => 'medium',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_row_pb',
                'label' => 'فاصله پایین',
                'name' => 'padding_bottom',
                'type' => 'select',
                'choices' => [
                    'none' => 'بدون فاصله',
                    'small' => 'کم',
                    'medium' => 'متوسط',
                    'large' => 'زیاد',
                    'xlarge' => 'خیلی زیاد',
                ],
                'default_value' => 'medium',
                'wrapper' => ['width' => '50'],
            ],

            // تب پس‌زمینه
            [
                'key' => 'field_row_tab_bg',
                'label' => 'پس‌زمینه',
                'type' => 'tab',
            ],
            [
                'key' => 'field_row_bg_type',
                'label' => 'نوع پس‌زمینه',
                'name' => 'bg_type',
                'type' => 'button_group',
                'choices' => [
                    'none' => 'بدون پس‌زمینه',
                    'color' => 'رنگ',
                    'gradient' => 'گرادیان',
                    'image' => 'تصویر',
                ],
                'default_value' => 'none',
            ],
            [
                'key' => 'field_row_bg_color',
                'label' => 'رنگ پس‌زمینه',
                'name' => 'bg_color',
                'type' => 'color_picker',
                'conditional_logic' => [
                    [['field' => 'field_row_bg_type', 'operator' => '==', 'value' => 'color']],
                ],
            ],
            [
                'key' => 'field_row_bg_gradient',
                'label' => 'گرادیان',
                'name' => 'bg_gradient',
                'type' => 'text',
                'placeholder' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                'conditional_logic' => [
                    [['field' => 'field_row_bg_type', 'operator' => '==', 'value' => 'gradient']],
                ],
            ],
            [
                'key' => 'field_row_bg_image',
                'label' => 'تصویر پس‌زمینه',
                'name' => 'bg_image',
                'type' => 'image',
                'return_format' => 'array',
                'conditional_logic' => [
                    [['field' => 'field_row_bg_type', 'operator' => '==', 'value' => 'image']],
                ],
            ],
            [
                'key' => 'field_row_bg_overlay',
                'label' => 'رنگ روکش',
                'name' => 'bg_overlay',
                'type' => 'text',
                'placeholder' => 'rgba(0,0,0,0.5)',
                'conditional_logic' => [
                    [['field' => 'field_row_bg_type', 'operator' => '==', 'value' => 'image']],
                ],
            ],
            [
                'key' => 'field_row_parallax',
                'label' => 'افکت پارالکس',
                'name' => 'bg_parallax',
                'type' => 'true_false',
                'conditional_logic' => [
                    [['field' => 'field_row_bg_type', 'operator' => '==', 'value' => 'image']],
                ],
            ],

            // تب حاشیه
            [
                'key' => 'field_row_tab_border',
                'label' => 'حاشیه و انیمیشن',
                'type' => 'tab',
            ],
            [
                'key' => 'field_row_border_top',
                'label' => 'خط بالا',
                'name' => 'border_top',
                'type' => 'true_false',
                'wrapper' => ['width' => '33'],
            ],
            [
                'key' => 'field_row_border_bottom',
                'label' => 'خط پایین',
                'name' => 'border_bottom',
                'type' => 'true_false',
                'wrapper' => ['width' => '33'],
            ],
            [
                'key' => 'field_row_border_color',
                'label' => 'رنگ خط',
                'name' => 'border_color',
                'type' => 'color_picker',
                'default_value' => '#e5e7eb',
                'wrapper' => ['width' => '34'],
            ],
            [
                'key' => 'field_row_animation',
                'label' => 'انیمیشن ورود',
                'name' => 'animation',
                'type' => 'select',
                'choices' => [
                    'none' => 'بدون انیمیشن',
                    'fade' => 'محو شدن',
                    'slide-up' => 'اسلاید از پایین',
                ],
                'default_value' => 'none',
            ],
        ],
        'location' => [
            [['param' => 'block', 'operator' => '==', 'value' => 'acf/row']],
        ],
    ]);
});
?>
