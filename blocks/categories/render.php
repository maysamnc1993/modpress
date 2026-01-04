<?php
/**
 * Categories Block - نمایش دسته‌بندی‌ها
 *
 * @package Developer_Starter
 */

// تنظیمات محتوا
$title = get_field('title') ?: '';
$subtitle = get_field('subtitle') ?: '';
$description = get_field('description') ?: '';

// تنظیمات کوئری
$taxonomy = get_field('taxonomy') ?: 'product_cat';
$source = get_field('source') ?: 'all';
$specific_terms = get_field('specific_terms') ?: [];
$parent_only = get_field('parent_only') ?: false;
$hide_empty = get_field('hide_empty') !== false;
$limit = get_field('limit') ?: 6;
$orderby = get_field('orderby') ?: 'name';
$order = get_field('order') ?: 'ASC';

// تنظیمات نمایش
$layout = get_field('layout') ?: 'grid';
$columns = get_field('columns') ?: '3';
$style = get_field('style') ?: 'overlay';
$image_ratio = get_field('image_ratio') ?: 'square';
$show_count = get_field('show_count') !== false;
$show_description = get_field('show_description') ?: false;

// تنظیمات ظاهری
$bg_color = get_field('bg_color') ?: '#f8fafc';
$overlay_color = get_field('overlay_color') ?: 'rgba(0,0,0,0.4)';
$text_color = get_field('text_color') ?: '#ffffff';
$hover_effect = get_field('hover_effect') ?: 'zoom';

// ساخت کوئری
$args = [
    'taxonomy' => $taxonomy,
    'hide_empty' => $hide_empty,
    'number' => $limit,
    'orderby' => $orderby,
    'order' => $order,
];

if ($source === 'specific' && !empty($specific_terms)) {
    $args['include'] = $specific_terms;
    $args['orderby'] = 'include';
} elseif ($parent_only) {
    $args['parent'] = 0;
}

$terms = get_terms($args);

if (is_wp_error($terms)) {
    $terms = [];
}

// کلاس‌های ستون
$col_classes = [
    '2' => 'md:grid-cols-2',
    '3' => 'md:grid-cols-2 lg:grid-cols-3',
    '4' => 'md:grid-cols-2 lg:grid-cols-4',
    '5' => 'md:grid-cols-3 lg:grid-cols-5',
    '6' => 'md:grid-cols-3 lg:grid-cols-6',
];

// نسبت تصویر
$ratio_classes = [
    'square' => 'aspect-square',
    'portrait' => 'aspect-[3/4]',
    'landscape' => 'aspect-[4/3]',
    'wide' => 'aspect-video',
    'banner' => 'aspect-[3/1]',
];

$block_id = dst_block_id($block, 'categories');
?>

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="dst-block dst-categories py-16 lg:py-24"
    style="background-color: <?php echo esc_attr($bg_color); ?>;"
>
    <div class="container mx-auto px-4">
        <!-- هدر بخش -->
        <?php if ($title || $subtitle || $description): ?>
            <div class="text-center max-w-3xl mx-auto mb-12">
                <?php if ($subtitle): ?>
                    <p class="text-primary-600 font-semibold mb-2"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>
                <?php if ($title): ?>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>
                <?php if ($description): ?>
                    <p class="text-gray-600"><?php echo esc_html($description); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($terms)): ?>
            <?php if ($layout === 'masonry'): ?>
                <!-- ماسونری -->
                <div class="columns-1 md:columns-2 lg:columns-<?php echo esc_attr($columns); ?> gap-6 space-y-6">
                    <?php foreach ($terms as $index => $term):
                        $term_link = get_term_link($term);
                        $thumbnail_id = get_term_meta($term->term_id, 'thumbnail_id', true);
                        $image = $thumbnail_id ? wp_get_attachment_image_src($thumbnail_id, 'large') : null;
                        ?>
                        <div
                            class="break-inside-avoid"
                            x-data="{ shown: false }"
                            x-intersect:enter="shown = true"
                            x-show="shown"
                            x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            style="transition-delay: <?php echo $index * 100; ?>ms;"
                        >
                            <?php include __DIR__ . '/category-card.php'; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <!-- گرید -->
                <div class="grid gap-6 <?php echo esc_attr($col_classes[$columns] ?? 'lg:grid-cols-3'); ?>">
                    <?php foreach ($terms as $index => $term):
                        $term_link = get_term_link($term);
                        $thumbnail_id = get_term_meta($term->term_id, 'thumbnail_id', true);
                        $image = $thumbnail_id ? wp_get_attachment_image_src($thumbnail_id, 'large') : null;
                        ?>
                        <div
                            x-data="{ shown: false }"
                            x-intersect:enter="shown = true"
                            x-show="shown"
                            x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            style="transition-delay: <?php echo $index * 100; ?>ms;"
                        >
                            <?php include __DIR__ . '/category-card.php'; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="text-center py-12">
                <div class="text-gray-400 mb-4">
                    <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <p class="text-gray-500 text-lg">دسته‌بندی یافت نشد</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
// ثبت فیلدهای ACF
add_action('acf/init', function() {
    if (!function_exists('acf_add_local_field_group')) return;

    // تاکسونومی‌های موجود
    $taxonomies = [
        'category' => 'دسته‌بندی نوشته‌ها',
        'product_cat' => 'دسته‌بندی محصولات',
        'post_tag' => 'برچسب نوشته‌ها',
        'product_tag' => 'برچسب محصولات',
    ];

    acf_add_local_field_group([
        'key' => 'group_block_categories',
        'title' => 'تنظیمات دسته‌بندی‌ها',
        'fields' => [
            // تب محتوا
            [
                'key' => 'field_categories_tab_content',
                'label' => 'محتوا',
                'type' => 'tab',
            ],
            [
                'key' => 'field_categories_title',
                'label' => 'عنوان',
                'name' => 'title',
                'type' => 'text',
                'placeholder' => 'دسته‌بندی محصولات',
            ],
            [
                'key' => 'field_categories_subtitle',
                'label' => 'زیرعنوان',
                'name' => 'subtitle',
                'type' => 'text',
            ],
            [
                'key' => 'field_categories_description',
                'label' => 'توضیحات',
                'name' => 'description',
                'type' => 'textarea',
                'rows' => 2,
            ],

            // تب کوئری
            [
                'key' => 'field_categories_tab_query',
                'label' => 'انتخاب دسته‌ها',
                'type' => 'tab',
            ],
            [
                'key' => 'field_categories_taxonomy',
                'label' => 'نوع',
                'name' => 'taxonomy',
                'type' => 'select',
                'choices' => $taxonomies,
                'default_value' => 'product_cat',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_categories_source',
                'label' => 'منبع',
                'name' => 'source',
                'type' => 'button_group',
                'choices' => [
                    'all' => 'همه',
                    'specific' => 'انتخابی',
                ],
                'default_value' => 'all',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_categories_specific',
                'label' => 'دسته‌های انتخابی',
                'name' => 'specific_terms',
                'type' => 'taxonomy',
                'taxonomy' => 'product_cat',
                'field_type' => 'multi_select',
                'return_format' => 'id',
                'conditional_logic' => [
                    [['field' => 'field_categories_source', 'operator' => '==', 'value' => 'specific']],
                ],
            ],
            [
                'key' => 'field_categories_parent_only',
                'label' => 'فقط دسته‌های والد',
                'name' => 'parent_only',
                'type' => 'true_false',
                'conditional_logic' => [
                    [['field' => 'field_categories_source', 'operator' => '==', 'value' => 'all']],
                ],
                'wrapper' => ['width' => '33'],
            ],
            [
                'key' => 'field_categories_hide_empty',
                'label' => 'پنهان کردن خالی‌ها',
                'name' => 'hide_empty',
                'type' => 'true_false',
                'default_value' => 1,
                'wrapper' => ['width' => '33'],
            ],
            [
                'key' => 'field_categories_limit',
                'label' => 'تعداد',
                'name' => 'limit',
                'type' => 'number',
                'default_value' => 6,
                'min' => 1,
                'max' => 20,
                'wrapper' => ['width' => '34'],
            ],
            [
                'key' => 'field_categories_orderby',
                'label' => 'مرتب‌سازی',
                'name' => 'orderby',
                'type' => 'select',
                'choices' => [
                    'name' => 'نام',
                    'count' => 'تعداد آیتم',
                    'term_id' => 'شناسه',
                    'menu_order' => 'ترتیب منو',
                ],
                'default_value' => 'name',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_categories_order',
                'label' => 'ترتیب',
                'name' => 'order',
                'type' => 'select',
                'choices' => [
                    'ASC' => 'صعودی',
                    'DESC' => 'نزولی',
                ],
                'default_value' => 'ASC',
                'wrapper' => ['width' => '50'],
            ],

            // تب نمایش
            [
                'key' => 'field_categories_tab_display',
                'label' => 'تنظیمات نمایش',
                'type' => 'tab',
            ],
            [
                'key' => 'field_categories_layout',
                'label' => 'چیدمان',
                'name' => 'layout',
                'type' => 'button_group',
                'choices' => [
                    'grid' => 'گرید',
                    'masonry' => 'ماسونری',
                ],
                'default_value' => 'grid',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_categories_columns',
                'label' => 'تعداد ستون',
                'name' => 'columns',
                'type' => 'select',
                'choices' => [
                    '2' => '۲ ستون',
                    '3' => '۳ ستون',
                    '4' => '۴ ستون',
                    '5' => '۵ ستون',
                    '6' => '۶ ستون',
                ],
                'default_value' => '3',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_categories_style',
                'label' => 'استایل',
                'name' => 'style',
                'type' => 'select',
                'choices' => [
                    'overlay' => 'متن روی تصویر',
                    'below' => 'متن زیر تصویر',
                    'card' => 'کارتی',
                    'minimal' => 'مینیمال',
                    'circle' => 'دایره‌ای',
                ],
                'default_value' => 'overlay',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_categories_ratio',
                'label' => 'نسبت تصویر',
                'name' => 'image_ratio',
                'type' => 'select',
                'choices' => [
                    'square' => 'مربع (1:1)',
                    'portrait' => 'عمودی (3:4)',
                    'landscape' => 'افقی (4:3)',
                    'wide' => 'عریض (16:9)',
                    'banner' => 'بنری (3:1)',
                ],
                'default_value' => 'square',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_categories_hover',
                'label' => 'افکت هاور',
                'name' => 'hover_effect',
                'type' => 'select',
                'choices' => [
                    'none' => 'بدون افکت',
                    'zoom' => 'زوم',
                    'lift' => 'بالا آمدن',
                    'glow' => 'درخشش',
                ],
                'default_value' => 'zoom',
            ],
            [
                'key' => 'field_categories_show_count',
                'label' => 'نمایش تعداد',
                'name' => 'show_count',
                'type' => 'true_false',
                'default_value' => 1,
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_categories_show_desc',
                'label' => 'نمایش توضیحات',
                'name' => 'show_description',
                'type' => 'true_false',
                'wrapper' => ['width' => '50'],
            ],

            // تب استایل
            [
                'key' => 'field_categories_tab_style',
                'label' => 'ظاهر',
                'type' => 'tab',
            ],
            [
                'key' => 'field_categories_bg_color',
                'label' => 'رنگ پس‌زمینه بخش',
                'name' => 'bg_color',
                'type' => 'color_picker',
                'default_value' => '#f8fafc',
            ],
            [
                'key' => 'field_categories_overlay_color',
                'label' => 'رنگ Overlay',
                'name' => 'overlay_color',
                'type' => 'text',
                'default_value' => 'rgba(0,0,0,0.4)',
                'placeholder' => 'rgba(0,0,0,0.4)',
                'conditional_logic' => [
                    [['field' => 'field_categories_style', 'operator' => '==', 'value' => 'overlay']],
                ],
            ],
            [
                'key' => 'field_categories_text_color',
                'label' => 'رنگ متن',
                'name' => 'text_color',
                'type' => 'color_picker',
                'default_value' => '#ffffff',
                'conditional_logic' => [
                    [['field' => 'field_categories_style', 'operator' => '==', 'value' => 'overlay']],
                ],
            ],
        ],
        'location' => [
            [['param' => 'block', 'operator' => '==', 'value' => 'acf/categories']],
        ],
    ]);
});
?>
