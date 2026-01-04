<?php
/**
 * Products Block - نمایش محصولات ووکامرس
 *
 * @package Developer_Starter
 */

// چک کردن وجود ووکامرس
if (!class_exists('WooCommerce')) {
    if (is_admin()) {
        echo '<div class="dst-block-notice">برای استفاده از این بلاک، ووکامرس باید نصب و فعال باشد.</div>';
    }
    return;
}

// تنظیمات بلاک
$title = get_field('title') ?: '';
$subtitle = get_field('subtitle') ?: '';
$description = get_field('description') ?: '';

// تنظیمات کوئری
$product_type = get_field('product_type') ?: 'latest';
$category = get_field('category') ?: '';
$tag = get_field('tag') ?: '';
$specific_products = get_field('specific_products') ?: [];
$limit = get_field('limit') ?: 8;
$columns = get_field('columns') ?: '4';
$orderby = get_field('orderby') ?: 'date';
$order = get_field('order') ?: 'DESC';

// تنظیمات نمایش
$layout = get_field('layout') ?: 'grid';
$style = get_field('style') ?: 'cards';
$show_rating = get_field('show_rating') !== false;
$show_sale_badge = get_field('show_sale_badge') !== false;
$show_add_to_cart = get_field('show_add_to_cart') !== false;
$show_wishlist = get_field('show_wishlist') ?: false;
$show_quick_view = get_field('show_quick_view') ?: false;
$image_ratio = get_field('image_ratio') ?: 'square';

// تنظیمات پیشرفته
$bg_color = get_field('bg_color') ?: '#ffffff';
$card_bg = get_field('card_bg') ?: '#ffffff';
$hover_effect = get_field('hover_effect') ?: 'zoom';
$show_navigation = get_field('show_navigation') !== false;
$autoplay = get_field('autoplay') ?: false;
$autoplay_speed = get_field('autoplay_speed') ?: 5000;

// لینک بیشتر
$show_view_all = get_field('show_view_all') ?: false;
$view_all_text = get_field('view_all_text') ?: 'مشاهده همه محصولات';
$view_all_link = get_field('view_all_link') ?: wc_get_page_permalink('shop');

// ساخت کوئری
$args = [
    'post_type' => 'product',
    'posts_per_page' => $limit,
    'post_status' => 'publish',
    'orderby' => $orderby,
    'order' => $order,
];

// فیلتر بر اساس نوع محصول
switch ($product_type) {
    case 'featured':
        $args['tax_query'][] = [
            'taxonomy' => 'product_visibility',
            'field' => 'name',
            'terms' => 'featured',
        ];
        break;
    case 'sale':
        $args['meta_query'][] = [
            'key' => '_sale_price',
            'value' => '',
            'compare' => '!=',
        ];
        break;
    case 'best_selling':
        $args['meta_key'] = 'total_sales';
        $args['orderby'] = 'meta_value_num';
        break;
    case 'top_rated':
        $args['meta_key'] = '_wc_average_rating';
        $args['orderby'] = 'meta_value_num';
        break;
    case 'specific':
        if (!empty($specific_products)) {
            $args['post__in'] = $specific_products;
            $args['orderby'] = 'post__in';
        }
        break;
}

// فیلتر بر اساس دسته‌بندی
if ($category && $product_type !== 'specific') {
    $args['tax_query'][] = [
        'taxonomy' => 'product_cat',
        'field' => 'term_id',
        'terms' => $category,
    ];
}

// فیلتر بر اساس برچسب
if ($tag && $product_type !== 'specific') {
    $args['tax_query'][] = [
        'taxonomy' => 'product_tag',
        'field' => 'term_id',
        'terms' => $tag,
    ];
}

$products = new WP_Query($args);

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
];

$block_id = dst_block_id($block, 'products');
?>

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="dst-block dst-products py-16 lg:py-24"
    style="background-color: <?php echo esc_attr($bg_color); ?>;"
    <?php if ($layout === 'slider'): ?>
    x-data="{
        current: 0,
        total: <?php echo $products->post_count; ?>,
        perView: <?php echo intval($columns); ?>,
        autoplay: <?php echo $autoplay ? 'true' : 'false'; ?>,
        interval: null,
        init() {
            if (this.autoplay) {
                this.startAutoplay();
            }
        },
        startAutoplay() {
            this.interval = setInterval(() => this.next(), <?php echo intval($autoplay_speed); ?>);
        },
        next() {
            this.current = (this.current + 1) % Math.ceil(this.total / this.perView);
        },
        prev() {
            this.current = (this.current - 1 + Math.ceil(this.total / this.perView)) % Math.ceil(this.total / this.perView);
        },
        goTo(index) {
            this.current = index;
        }
    }"
    <?php endif; ?>
>
    <div class="container mx-auto px-4">
        <!-- هدر بخش -->
        <?php if ($title || $subtitle || $description || $show_view_all): ?>
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-12">
                <div class="max-w-2xl">
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

                <?php if ($show_view_all): ?>
                    <a href="<?php echo esc_url($view_all_link); ?>" class="inline-flex items-center gap-2 text-primary-600 font-semibold hover:text-primary-700 transition-colors group">
                        <?php echo esc_html($view_all_text); ?>
                        <svg class="w-5 h-5 rtl:rotate-180 group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($products->have_posts()): ?>
            <?php if ($layout === 'slider'): ?>
                <!-- اسلایدر -->
                <div class="relative">
                    <div class="overflow-hidden">
                        <div
                            class="flex transition-transform duration-500 ease-out"
                            :style="'transform: translateX(' + (current * -100) + '%)'"
                        >
                            <?php
                            $slide_index = 0;
                            while ($products->have_posts()): $products->the_post();
                                global $product;
                                if ($slide_index % intval($columns) === 0):
                            ?>
                                <div class="w-full flex-shrink-0 grid gap-6 <?php echo esc_attr($col_classes[$columns] ?? 'lg:grid-cols-4'); ?>">
                            <?php endif; ?>
                                    <?php include __DIR__ . '/product-card.php'; ?>
                            <?php
                                if (($slide_index + 1) % intval($columns) === 0 || $slide_index === $products->post_count - 1):
                            ?>
                                </div>
                            <?php
                                endif;
                                $slide_index++;
                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>

                    <?php if ($show_navigation && $products->post_count > intval($columns)): ?>
                        <!-- ناوبری -->
                        <button
                            @click="prev()"
                            class="absolute top-1/2 -translate-y-1/2 right-0 translate-x-1/2 rtl:right-auto rtl:left-0 rtl:-translate-x-1/2 z-10 w-12 h-12 rounded-full bg-white shadow-lg flex items-center justify-center hover:bg-gray-50 transition-colors"
                        >
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                        <button
                            @click="next()"
                            class="absolute top-1/2 -translate-y-1/2 left-0 -translate-x-1/2 rtl:left-auto rtl:right-0 rtl:translate-x-1/2 z-10 w-12 h-12 rounded-full bg-white shadow-lg flex items-center justify-center hover:bg-gray-50 transition-colors"
                        >
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>

                        <!-- نقاط -->
                        <div class="flex justify-center gap-2 mt-8">
                            <?php for ($i = 0; $i < ceil($products->post_count / intval($columns)); $i++): ?>
                                <button
                                    @click="goTo(<?php echo $i; ?>)"
                                    :class="current === <?php echo $i; ?> ? 'bg-primary-600 w-8' : 'bg-gray-300'"
                                    class="h-2 rounded-full transition-all duration-300 w-2"
                                ></button>
                            <?php endfor; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <!-- گرید -->
                <div class="grid gap-6 <?php echo esc_attr($col_classes[$columns] ?? 'lg:grid-cols-4'); ?>">
                    <?php
                    $product_index = 0;
                    while ($products->have_posts()): $products->the_post();
                        global $product;
                        include __DIR__ . '/product-card.php';
                        $product_index++;
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="text-center py-12">
                <div class="text-gray-400 mb-4">
                    <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <p class="text-gray-500 text-lg">محصولی یافت نشد</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
// ثبت فیلدهای ACF
add_action('acf/init', function() {
    if (!function_exists('acf_add_local_field_group')) return;

    // دسته‌بندی‌ها
    $categories = [];
    if (function_exists('get_terms')) {
        $terms = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);
        if (!is_wp_error($terms)) {
            foreach ($terms as $term) {
                $categories[$term->term_id] = $term->name;
            }
        }
    }

    // برچسب‌ها
    $tags = [];
    if (function_exists('get_terms')) {
        $terms = get_terms(['taxonomy' => 'product_tag', 'hide_empty' => false]);
        if (!is_wp_error($terms)) {
            foreach ($terms as $term) {
                $tags[$term->term_id] = $term->name;
            }
        }
    }

    acf_add_local_field_group([
        'key' => 'group_block_products',
        'title' => 'تنظیمات محصولات',
        'fields' => [
            // تب محتوا
            [
                'key' => 'field_products_tab_content',
                'label' => 'محتوا',
                'type' => 'tab',
            ],
            [
                'key' => 'field_products_title',
                'label' => 'عنوان',
                'name' => 'title',
                'type' => 'text',
                'placeholder' => 'محصولات ویژه',
            ],
            [
                'key' => 'field_products_subtitle',
                'label' => 'زیرعنوان',
                'name' => 'subtitle',
                'type' => 'text',
            ],
            [
                'key' => 'field_products_description',
                'label' => 'توضیحات',
                'name' => 'description',
                'type' => 'textarea',
                'rows' => 2,
            ],

            // تب کوئری
            [
                'key' => 'field_products_tab_query',
                'label' => 'انتخاب محصولات',
                'type' => 'tab',
            ],
            [
                'key' => 'field_products_type',
                'label' => 'نوع محصولات',
                'name' => 'product_type',
                'type' => 'select',
                'choices' => [
                    'latest' => 'جدیدترین',
                    'featured' => 'ویژه',
                    'sale' => 'تخفیف‌دار',
                    'best_selling' => 'پرفروش‌ترین',
                    'top_rated' => 'محبوب‌ترین',
                    'specific' => 'انتخاب دستی',
                ],
                'default_value' => 'latest',
            ],
            [
                'key' => 'field_products_specific',
                'label' => 'محصولات انتخابی',
                'name' => 'specific_products',
                'type' => 'post_object',
                'post_type' => ['product'],
                'multiple' => 1,
                'return_format' => 'id',
                'conditional_logic' => [
                    [['field' => 'field_products_type', 'operator' => '==', 'value' => 'specific']],
                ],
            ],
            [
                'key' => 'field_products_category',
                'label' => 'دسته‌بندی',
                'name' => 'category',
                'type' => 'select',
                'choices' => array_merge(['' => 'همه دسته‌ها'], $categories),
                'conditional_logic' => [
                    [['field' => 'field_products_type', 'operator' => '!=', 'value' => 'specific']],
                ],
            ],
            [
                'key' => 'field_products_tag',
                'label' => 'برچسب',
                'name' => 'tag',
                'type' => 'select',
                'choices' => array_merge(['' => 'همه برچسب‌ها'], $tags),
                'conditional_logic' => [
                    [['field' => 'field_products_type', 'operator' => '!=', 'value' => 'specific']],
                ],
            ],
            [
                'key' => 'field_products_limit',
                'label' => 'تعداد محصولات',
                'name' => 'limit',
                'type' => 'number',
                'default_value' => 8,
                'min' => 1,
                'max' => 24,
                'wrapper' => ['width' => '33'],
            ],
            [
                'key' => 'field_products_orderby',
                'label' => 'مرتب‌سازی',
                'name' => 'orderby',
                'type' => 'select',
                'choices' => [
                    'date' => 'تاریخ',
                    'title' => 'عنوان',
                    'price' => 'قیمت',
                    'popularity' => 'محبوبیت',
                    'rating' => 'امتیاز',
                    'rand' => 'تصادفی',
                ],
                'default_value' => 'date',
                'wrapper' => ['width' => '33'],
            ],
            [
                'key' => 'field_products_order',
                'label' => 'ترتیب',
                'name' => 'order',
                'type' => 'select',
                'choices' => [
                    'DESC' => 'نزولی',
                    'ASC' => 'صعودی',
                ],
                'default_value' => 'DESC',
                'wrapper' => ['width' => '34'],
            ],

            // تب نمایش
            [
                'key' => 'field_products_tab_display',
                'label' => 'تنظیمات نمایش',
                'type' => 'tab',
            ],
            [
                'key' => 'field_products_layout',
                'label' => 'چیدمان',
                'name' => 'layout',
                'type' => 'button_group',
                'choices' => [
                    'grid' => 'گرید',
                    'slider' => 'اسلایدر',
                ],
                'default_value' => 'grid',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_products_columns',
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
                'default_value' => '4',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_products_style',
                'label' => 'استایل کارت',
                'name' => 'style',
                'type' => 'select',
                'choices' => [
                    'cards' => 'کارتی (سایه‌دار)',
                    'bordered' => 'حاشیه‌دار',
                    'minimal' => 'مینیمال',
                ],
                'default_value' => 'cards',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_products_image_ratio',
                'label' => 'نسبت تصویر',
                'name' => 'image_ratio',
                'type' => 'select',
                'choices' => [
                    'square' => 'مربع (1:1)',
                    'portrait' => 'عمودی (3:4)',
                    'landscape' => 'افقی (4:3)',
                    'wide' => 'عریض (16:9)',
                ],
                'default_value' => 'square',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_products_hover',
                'label' => 'افکت هاور',
                'name' => 'hover_effect',
                'type' => 'select',
                'choices' => [
                    'none' => 'بدون افکت',
                    'zoom' => 'زوم',
                    'slide' => 'اسلاید (تصویر دوم)',
                    'fade' => 'محو شدن',
                ],
                'default_value' => 'zoom',
            ],
            [
                'key' => 'field_products_show_rating',
                'label' => 'نمایش امتیاز',
                'name' => 'show_rating',
                'type' => 'true_false',
                'default_value' => 1,
                'wrapper' => ['width' => '25'],
            ],
            [
                'key' => 'field_products_show_sale',
                'label' => 'نشان تخفیف',
                'name' => 'show_sale_badge',
                'type' => 'true_false',
                'default_value' => 1,
                'wrapper' => ['width' => '25'],
            ],
            [
                'key' => 'field_products_show_cart',
                'label' => 'دکمه خرید',
                'name' => 'show_add_to_cart',
                'type' => 'true_false',
                'default_value' => 1,
                'wrapper' => ['width' => '25'],
            ],
            [
                'key' => 'field_products_show_wishlist',
                'label' => 'علاقه‌مندی',
                'name' => 'show_wishlist',
                'type' => 'true_false',
                'default_value' => 0,
                'wrapper' => ['width' => '25'],
            ],

            // تب اسلایدر
            [
                'key' => 'field_products_tab_slider',
                'label' => 'تنظیمات اسلایدر',
                'type' => 'tab',
                'conditional_logic' => [
                    [['field' => 'field_products_layout', 'operator' => '==', 'value' => 'slider']],
                ],
            ],
            [
                'key' => 'field_products_navigation',
                'label' => 'ناوبری',
                'name' => 'show_navigation',
                'type' => 'true_false',
                'default_value' => 1,
                'wrapper' => ['width' => '33'],
            ],
            [
                'key' => 'field_products_autoplay',
                'label' => 'پخش خودکار',
                'name' => 'autoplay',
                'type' => 'true_false',
                'default_value' => 0,
                'wrapper' => ['width' => '33'],
            ],
            [
                'key' => 'field_products_autoplay_speed',
                'label' => 'سرعت (میلی‌ثانیه)',
                'name' => 'autoplay_speed',
                'type' => 'number',
                'default_value' => 5000,
                'min' => 1000,
                'max' => 10000,
                'wrapper' => ['width' => '34'],
                'conditional_logic' => [
                    [['field' => 'field_products_autoplay', 'operator' => '==', 'value' => '1']],
                ],
            ],

            // تب استایل
            [
                'key' => 'field_products_tab_style',
                'label' => 'ظاهر',
                'type' => 'tab',
            ],
            [
                'key' => 'field_products_bg_color',
                'label' => 'رنگ پس‌زمینه بخش',
                'name' => 'bg_color',
                'type' => 'color_picker',
                'default_value' => '#ffffff',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_products_card_bg',
                'label' => 'رنگ پس‌زمینه کارت',
                'name' => 'card_bg',
                'type' => 'color_picker',
                'default_value' => '#ffffff',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_products_view_all',
                'label' => 'نمایش لینک بیشتر',
                'name' => 'show_view_all',
                'type' => 'true_false',
                'default_value' => 0,
            ],
            [
                'key' => 'field_products_view_all_text',
                'label' => 'متن لینک',
                'name' => 'view_all_text',
                'type' => 'text',
                'default_value' => 'مشاهده همه محصولات',
                'wrapper' => ['width' => '50'],
                'conditional_logic' => [
                    [['field' => 'field_products_view_all', 'operator' => '==', 'value' => '1']],
                ],
            ],
            [
                'key' => 'field_products_view_all_link',
                'label' => 'آدرس لینک',
                'name' => 'view_all_link',
                'type' => 'url',
                'wrapper' => ['width' => '50'],
                'conditional_logic' => [
                    [['field' => 'field_products_view_all', 'operator' => '==', 'value' => '1']],
                ],
            ],
        ],
        'location' => [
            [['param' => 'block', 'operator' => '==', 'value' => 'acf/products']],
        ],
    ]);
});
?>
