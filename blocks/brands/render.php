<?php
/**
 * Brands Block - نمایش برندها
 *
 * @package Developer_Starter
 */

// محتوا
$title = get_field('title') ?: '';
$subtitle = get_field('subtitle') ?: '';
$description = get_field('description') ?: '';

// برندها
$brands = get_field('brands') ?: [];

// نمونه داده
if (empty($brands)) {
    $brands = [
        ['name' => 'برند ۱'],
        ['name' => 'برند ۲'],
        ['name' => 'برند ۳'],
        ['name' => 'برند ۴'],
        ['name' => 'برند ۵'],
        ['name' => 'برند ۶'],
    ];
}

// تنظیمات نمایش
$layout = get_field('layout') ?: 'slider';
$columns = get_field('columns') ?: '6';
$logo_height = get_field('logo_height') ?: 'medium';
$grayscale = get_field('grayscale') !== false;
$show_name = get_field('show_name') ?: false;

// تنظیمات اسلایدر
$autoplay = get_field('autoplay') !== false;
$speed = get_field('speed') ?: 30;
$pause_on_hover = get_field('pause_on_hover') !== false;
$direction = get_field('direction') ?: 'rtl';

// ظاهر
$bg_color = get_field('bg_color') ?: '#ffffff';
$logo_style = get_field('logo_style') ?: 'default';

// کلاس‌های ستون
$col_classes = [
    '4' => 'grid-cols-2 md:grid-cols-4',
    '5' => 'grid-cols-2 md:grid-cols-3 lg:grid-cols-5',
    '6' => 'grid-cols-2 md:grid-cols-3 lg:grid-cols-6',
    '8' => 'grid-cols-2 md:grid-cols-4 lg:grid-cols-8',
];

// ارتفاع لوگو
$height_classes = [
    'small' => 'h-8 md:h-10',
    'medium' => 'h-12 md:h-16',
    'large' => 'h-16 md:h-20',
];

$block_id = dst_block_id($block, 'brands');
?>

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="dst-block dst-brands py-12 lg:py-16"
    style="background-color: <?php echo esc_attr($bg_color); ?>;"
    <?php if ($layout === 'slider'): ?>
    x-data="{
        paused: false,
        init() {
            // نیازی به JS نیست - انیمیشن CSS استفاده می‌شود
        }
    }"
    <?php endif; ?>
>
    <div class="<?php echo $layout === 'slider' ? '' : 'container mx-auto px-4'; ?>">
        <!-- هدر بخش -->
        <?php if ($title || $subtitle || $description): ?>
            <div class="text-center max-w-3xl mx-auto mb-10 <?php echo $layout === 'slider' ? 'px-4' : ''; ?>">
                <?php if ($subtitle): ?>
                    <p class="text-primary-600 font-semibold mb-2"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>
                <?php if ($title): ?>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>
                <?php if ($description): ?>
                    <p class="text-gray-600"><?php echo esc_html($description); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($brands)): ?>
            <?php if ($layout === 'slider'): ?>
                <!-- اسلایدر بی‌نهایت -->
                <div
                    class="overflow-hidden"
                    @mouseenter="<?php echo $pause_on_hover ? 'paused = true' : ''; ?>"
                    @mouseleave="paused = false"
                >
                    <div
                        class="flex items-center gap-12 brands-slider"
                        :class="{ 'paused': paused }"
                        style="--speed: <?php echo intval($speed); ?>s; --direction: <?php echo $direction === 'ltr' ? 'reverse' : 'normal'; ?>;"
                    >
                        <?php for ($i = 0; $i < 3; $i++): // تکرار برای حلقه بی‌نهایت ?>
                            <?php foreach ($brands as $brand): ?>
                                <div class="flex-shrink-0 px-6 <?php echo $logo_style === 'card' ? 'py-4' : ''; ?>">
                                    <?php if ($logo_style === 'card'): ?>
                                        <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                                    <?php endif; ?>

                                    <?php if (!empty($brand['url'])): ?>
                                        <a href="<?php echo esc_url($brand['url']); ?>" target="_blank" rel="noopener" class="block">
                                    <?php endif; ?>

                                    <?php if (!empty($brand['logo'])): ?>
                                        <img
                                            src="<?php echo esc_url($brand['logo']['url']); ?>"
                                            alt="<?php echo esc_attr($brand['name'] ?? ''); ?>"
                                            class="<?php echo esc_attr($height_classes[$logo_height] ?? 'h-12 md:h-16'); ?> w-auto object-contain <?php echo $grayscale ? 'grayscale hover:grayscale-0' : ''; ?> opacity-60 hover:opacity-100 transition-all duration-300"
                                            loading="lazy"
                                        >
                                    <?php else: ?>
                                        <div class="<?php echo esc_attr($height_classes[$logo_height] ?? 'h-12 md:h-16'); ?> px-6 bg-gray-100 rounded-lg flex items-center justify-center <?php echo $grayscale ? 'grayscale hover:grayscale-0' : ''; ?> opacity-60 hover:opacity-100 transition-all">
                                            <span class="text-gray-500 font-semibold whitespace-nowrap"><?php echo esc_html($brand['name'] ?? 'برند'); ?></span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($brand['url'])): ?>
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($show_name && !empty($brand['name'])): ?>
                                        <p class="text-center text-sm text-gray-500 mt-2"><?php echo esc_html($brand['name']); ?></p>
                                    <?php endif; ?>

                                    <?php if ($logo_style === 'card'): ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endfor; ?>
                    </div>
                </div>

                <style>
                    .brands-slider {
                        animation: scroll var(--speed) linear infinite;
                        animation-direction: var(--direction);
                        width: max-content;
                    }
                    .brands-slider.paused {
                        animation-play-state: paused;
                    }
                    @keyframes scroll {
                        0% { transform: translateX(0); }
                        100% { transform: translateX(calc(-100% / 3)); }
                    }
                </style>

            <?php elseif ($layout === 'marquee'): ?>
                <!-- مارکی -->
                <div class="overflow-hidden">
                    <div class="flex items-center gap-12 animate-marquee">
                        <?php for ($i = 0; $i < 2; $i++): ?>
                            <?php foreach ($brands as $brand): ?>
                                <div class="flex-shrink-0">
                                    <?php if (!empty($brand['logo'])): ?>
                                        <img
                                            src="<?php echo esc_url($brand['logo']['url']); ?>"
                                            alt="<?php echo esc_attr($brand['name'] ?? ''); ?>"
                                            class="<?php echo esc_attr($height_classes[$logo_height] ?? 'h-12 md:h-16'); ?> w-auto object-contain <?php echo $grayscale ? 'grayscale' : ''; ?> opacity-60"
                                            loading="lazy"
                                        >
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endfor; ?>
                    </div>
                </div>

            <?php else: ?>
                <!-- گرید -->
                <div class="grid gap-8 items-center <?php echo esc_attr($col_classes[$columns] ?? 'lg:grid-cols-6'); ?>">
                    <?php foreach ($brands as $index => $brand): ?>
                        <div
                            class="flex flex-col items-center justify-center <?php echo $logo_style === 'card' ? 'bg-white rounded-xl shadow-sm p-6 hover:shadow-md' : 'p-4'; ?> transition-all duration-300"
                            x-data="{ shown: false }"
                            x-intersect:enter="shown = true"
                            x-show="shown"
                            x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 scale-90"
                            x-transition:enter-end="opacity-100 scale-100"
                            style="transition-delay: <?php echo $index * 50; ?>ms;"
                        >
                            <?php if (!empty($brand['url'])): ?>
                                <a href="<?php echo esc_url($brand['url']); ?>" target="_blank" rel="noopener" class="block">
                            <?php endif; ?>

                            <?php if (!empty($brand['logo'])): ?>
                                <img
                                    src="<?php echo esc_url($brand['logo']['url']); ?>"
                                    alt="<?php echo esc_attr($brand['name'] ?? ''); ?>"
                                    class="<?php echo esc_attr($height_classes[$logo_height] ?? 'h-12 md:h-16'); ?> w-auto object-contain <?php echo $grayscale ? 'grayscale hover:grayscale-0' : ''; ?> opacity-60 hover:opacity-100 transition-all duration-300"
                                    loading="lazy"
                                >
                            <?php else: ?>
                                <div class="<?php echo esc_attr($height_classes[$logo_height] ?? 'h-12 md:h-16'); ?> w-full bg-gray-100 rounded-lg flex items-center justify-center <?php echo $grayscale ? 'grayscale hover:grayscale-0' : ''; ?> opacity-60 hover:opacity-100 transition-all">
                                    <span class="text-gray-500 font-semibold"><?php echo esc_html($brand['name'] ?? 'برند'); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($brand['url'])): ?>
                                </a>
                            <?php endif; ?>

                            <?php if ($show_name && !empty($brand['name'])): ?>
                                <p class="text-center text-sm text-gray-500 mt-3"><?php echo esc_html($brand['name']); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="text-center py-8">
                <p class="text-gray-500">برندی اضافه نشده است</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
// ثبت فیلدهای ACF
add_action('acf/init', function() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key' => 'group_block_brands',
        'title' => 'تنظیمات برندها',
        'fields' => [
            // تب محتوا
            [
                'key' => 'field_brands_tab_content',
                'label' => 'محتوا',
                'type' => 'tab',
            ],
            [
                'key' => 'field_brands_title',
                'label' => 'عنوان',
                'name' => 'title',
                'type' => 'text',
            ],
            [
                'key' => 'field_brands_subtitle',
                'label' => 'زیرعنوان',
                'name' => 'subtitle',
                'type' => 'text',
            ],
            [
                'key' => 'field_brands_description',
                'label' => 'توضیحات',
                'name' => 'description',
                'type' => 'textarea',
                'rows' => 2,
            ],
            [
                'key' => 'field_brands_items',
                'label' => 'برندها',
                'name' => 'brands',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'افزودن برند',
                'sub_fields' => [
                    [
                        'key' => 'field_brand_logo',
                        'label' => 'لوگو',
                        'name' => 'logo',
                        'type' => 'image',
                        'return_format' => 'array',
                    ],
                    [
                        'key' => 'field_brand_name',
                        'label' => 'نام',
                        'name' => 'name',
                        'type' => 'text',
                    ],
                    [
                        'key' => 'field_brand_url',
                        'label' => 'لینک',
                        'name' => 'url',
                        'type' => 'url',
                    ],
                ],
            ],

            // تب نمایش
            [
                'key' => 'field_brands_tab_display',
                'label' => 'تنظیمات نمایش',
                'type' => 'tab',
            ],
            [
                'key' => 'field_brands_layout',
                'label' => 'چیدمان',
                'name' => 'layout',
                'type' => 'button_group',
                'choices' => [
                    'slider' => 'اسلایدر',
                    'grid' => 'گرید',
                ],
                'default_value' => 'slider',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_brands_columns',
                'label' => 'تعداد ستون (گرید)',
                'name' => 'columns',
                'type' => 'select',
                'choices' => [
                    '4' => '۴ ستون',
                    '5' => '۵ ستون',
                    '6' => '۶ ستون',
                    '8' => '۸ ستون',
                ],
                'default_value' => '6',
                'wrapper' => ['width' => '50'],
                'conditional_logic' => [
                    [['field' => 'field_brands_layout', 'operator' => '==', 'value' => 'grid']],
                ],
            ],
            [
                'key' => 'field_brands_height',
                'label' => 'ارتفاع لوگو',
                'name' => 'logo_height',
                'type' => 'select',
                'choices' => [
                    'small' => 'کوچک',
                    'medium' => 'متوسط',
                    'large' => 'بزرگ',
                ],
                'default_value' => 'medium',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_brands_style',
                'label' => 'استایل',
                'name' => 'logo_style',
                'type' => 'select',
                'choices' => [
                    'default' => 'ساده',
                    'card' => 'کارتی',
                ],
                'default_value' => 'default',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_brands_grayscale',
                'label' => 'سیاه و سفید',
                'name' => 'grayscale',
                'type' => 'true_false',
                'default_value' => 1,
                'message' => 'رنگی شدن در هاور',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_brands_show_name',
                'label' => 'نمایش نام',
                'name' => 'show_name',
                'type' => 'true_false',
                'wrapper' => ['width' => '50'],
            ],

            // تب اسلایدر
            [
                'key' => 'field_brands_tab_slider',
                'label' => 'تنظیمات اسلایدر',
                'type' => 'tab',
                'conditional_logic' => [
                    [['field' => 'field_brands_layout', 'operator' => '==', 'value' => 'slider']],
                ],
            ],
            [
                'key' => 'field_brands_autoplay',
                'label' => 'پخش خودکار',
                'name' => 'autoplay',
                'type' => 'true_false',
                'default_value' => 1,
                'wrapper' => ['width' => '33'],
            ],
            [
                'key' => 'field_brands_speed',
                'label' => 'سرعت (ثانیه)',
                'name' => 'speed',
                'type' => 'number',
                'default_value' => 30,
                'min' => 10,
                'max' => 120,
                'wrapper' => ['width' => '33'],
            ],
            [
                'key' => 'field_brands_pause',
                'label' => 'توقف در هاور',
                'name' => 'pause_on_hover',
                'type' => 'true_false',
                'default_value' => 1,
                'wrapper' => ['width' => '34'],
            ],
            [
                'key' => 'field_brands_direction',
                'label' => 'جهت حرکت',
                'name' => 'direction',
                'type' => 'button_group',
                'choices' => [
                    'rtl' => 'راست به چپ',
                    'ltr' => 'چپ به راست',
                ],
                'default_value' => 'rtl',
            ],

            // تب ظاهر
            [
                'key' => 'field_brands_tab_style',
                'label' => 'ظاهر',
                'type' => 'tab',
            ],
            [
                'key' => 'field_brands_bg_color',
                'label' => 'رنگ پس‌زمینه',
                'name' => 'bg_color',
                'type' => 'color_picker',
                'default_value' => '#ffffff',
            ],
        ],
        'location' => [
            [['param' => 'block', 'operator' => '==', 'value' => 'acf/brands']],
        ],
    ]);
});
?>
