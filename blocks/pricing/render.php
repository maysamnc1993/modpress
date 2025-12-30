<?php
/**
 * Pricing Table Block
 *
 * @package Developer_Starter
 */

// فیلدها
$title = get_field('title') ?: '';
$subtitle = get_field('subtitle') ?: '';
$plans = get_field('plans') ?: [];
$columns = get_field('columns') ?: '3';
$style = get_field('style') ?: 'cards';
$bg_color = get_field('bg_color') ?: '#f8fafc';
$show_toggle = get_field('show_toggle') ?: false;

// نمونه داده
if (empty($plans)) {
    $plans = [
        [
            'name' => 'پایه',
            'price' => '۹۹,۰۰۰',
            'period' => 'ماهانه',
            'features' => [
                ['text' => '۵ گیگابایت فضا', 'included' => true],
                ['text' => 'پهنای باند نامحدود', 'included' => true],
                ['text' => 'SSL رایگان', 'included' => true],
                ['text' => 'پشتیبانی ۲۴/۷', 'included' => false],
            ],
            'button_text' => 'انتخاب پلن',
            'button_link' => '#',
            'featured' => false,
        ],
        [
            'name' => 'حرفه‌ای',
            'price' => '۱۹۹,۰۰۰',
            'period' => 'ماهانه',
            'features' => [
                ['text' => '۵۰ گیگابایت فضا', 'included' => true],
                ['text' => 'پهنای باند نامحدود', 'included' => true],
                ['text' => 'SSL رایگان', 'included' => true],
                ['text' => 'پشتیبانی ۲۴/۷', 'included' => true],
            ],
            'button_text' => 'انتخاب پلن',
            'button_link' => '#',
            'featured' => true,
            'badge' => 'پیشنهادی',
        ],
        [
            'name' => 'سازمانی',
            'price' => '۴۹۹,۰۰۰',
            'period' => 'ماهانه',
            'features' => [
                ['text' => 'فضای نامحدود', 'included' => true],
                ['text' => 'پهنای باند نامحدود', 'included' => true],
                ['text' => 'SSL رایگان', 'included' => true],
                ['text' => 'پشتیبانی ۲۴/۷', 'included' => true],
            ],
            'button_text' => 'تماس بگیرید',
            'button_link' => '#',
            'featured' => false,
        ],
    ];
}

$col_classes = [
    '2' => 'md:grid-cols-2',
    '3' => 'lg:grid-cols-3',
    '4' => 'md:grid-cols-2 xl:grid-cols-4',
];

$block_id = dst_block_id($block, 'pricing');
?>

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="dst-block dst-pricing py-16 lg:py-24"
    style="background-color: <?php echo esc_attr($bg_color); ?>;"
    x-data="{ yearly: false }"
>
    <div class="container mx-auto px-4">
        <?php if ($title || $subtitle): ?>
            <div class="text-center max-w-3xl mx-auto mb-12">
                <?php if ($subtitle): ?>
                    <p class="text-primary-600 font-semibold mb-2"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>
                <?php if ($title): ?>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>

                <?php if ($show_toggle): ?>
                    <div class="flex items-center justify-center gap-4 mt-8">
                        <span :class="yearly ? 'text-gray-400' : 'text-gray-900 font-semibold'">ماهانه</span>
                        <button
                            @click="yearly = !yearly"
                            class="relative w-16 h-8 rounded-full bg-primary-600 transition-colors"
                        >
                            <span
                                class="absolute top-1 w-6 h-6 rounded-full bg-white shadow transition-all"
                                :class="yearly ? 'right-1' : 'left-1'"
                            ></span>
                        </button>
                        <span :class="yearly ? 'text-gray-900 font-semibold' : 'text-gray-400'">سالانه
                            <span class="text-green-600 text-sm">(۲ ماه رایگان)</span>
                        </span>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="grid gap-8 items-start <?php echo esc_attr($col_classes[$columns] ?? 'lg:grid-cols-3'); ?>">
            <?php foreach ($plans as $index => $plan): ?>
                <?php
                $is_featured = !empty($plan['featured']);
                ?>
                <div
                    class="relative rounded-2xl <?php echo $is_featured ? 'bg-primary-600 text-white shadow-2xl scale-105 z-10' : 'bg-white shadow-lg'; ?> overflow-hidden transition-all duration-300 hover:shadow-xl"
                    x-data="{ shown: false }"
                    x-intersect:enter="shown = true"
                    x-show="shown"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 translate-y-8"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    style="transition-delay: <?php echo $index * 100; ?>ms;"
                >
                    <?php if (!empty($plan['badge'])): ?>
                        <div class="absolute top-0 left-0 right-0 bg-yellow-400 text-gray-900 text-center py-2 text-sm font-bold">
                            <?php echo esc_html($plan['badge']); ?>
                        </div>
                    <?php endif; ?>

                    <div class="p-8 <?php echo !empty($plan['badge']) ? 'pt-14' : ''; ?>">
                        <h3 class="text-2xl font-bold mb-2"><?php echo esc_html($plan['name']); ?></h3>

                        <div class="mb-6">
                            <span class="text-4xl md:text-5xl font-bold">
                                <?php echo esc_html($plan['price']); ?>
                            </span>
                            <?php if (!empty($plan['period'])): ?>
                                <span class="<?php echo $is_featured ? 'text-white/70' : 'text-gray-500'; ?>">
                                    / <?php echo esc_html($plan['period']); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($plan['description'])): ?>
                            <p class="<?php echo $is_featured ? 'text-white/80' : 'text-gray-600'; ?> mb-6">
                                <?php echo esc_html($plan['description']); ?>
                            </p>
                        <?php endif; ?>

                        <?php if (!empty($plan['features'])): ?>
                            <ul class="space-y-3 mb-8">
                                <?php foreach ($plan['features'] as $feature): ?>
                                    <li class="flex items-center gap-3">
                                        <?php if ($feature['included']): ?>
                                            <span class="flex-shrink-0 w-5 h-5 rounded-full <?php echo $is_featured ? 'bg-white/20' : 'bg-green-100'; ?> flex items-center justify-center">
                                                <svg class="w-3 h-3 <?php echo $is_featured ? 'text-white' : 'text-green-600'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </span>
                                        <?php else: ?>
                                            <span class="flex-shrink-0 w-5 h-5 rounded-full <?php echo $is_featured ? 'bg-white/10' : 'bg-gray-100'; ?> flex items-center justify-center">
                                                <svg class="w-3 h-3 <?php echo $is_featured ? 'text-white/50' : 'text-gray-400'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </span>
                                        <?php endif; ?>
                                        <span class="<?php echo !$feature['included'] ? ($is_featured ? 'text-white/50' : 'text-gray-400') : ''; ?>">
                                            <?php echo esc_html($feature['text']); ?>
                                        </span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <a
                            href="<?php echo esc_url($plan['button_link'] ?: '#'); ?>"
                            class="block w-full text-center py-4 px-6 rounded-xl font-semibold transition-all duration-300 <?php
                            echo $is_featured
                                ? 'bg-white text-primary-600 hover:bg-gray-100'
                                : 'bg-primary-600 text-white hover:bg-primary-700';
                            ?>"
                        >
                            <?php echo esc_html($plan['button_text'] ?: 'انتخاب پلن'); ?>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php
// ثبت فیلدها
add_action('acf/init', function() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key' => 'group_block_pricing',
        'title' => 'تنظیمات قیمت',
        'fields' => [
            [
                'key' => 'field_pricing_title',
                'label' => 'عنوان',
                'name' => 'title',
                'type' => 'text',
            ],
            [
                'key' => 'field_pricing_subtitle',
                'label' => 'زیرعنوان',
                'name' => 'subtitle',
                'type' => 'text',
            ],
            [
                'key' => 'field_pricing_plans',
                'label' => 'پلن‌ها',
                'name' => 'plans',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'افزودن پلن',
                'sub_fields' => [
                    [
                        'key' => 'field_plan_name',
                        'label' => 'نام پلن',
                        'name' => 'name',
                        'type' => 'text',
                        'required' => 1,
                        'wrapper' => ['width' => '25'],
                    ],
                    [
                        'key' => 'field_plan_price',
                        'label' => 'قیمت',
                        'name' => 'price',
                        'type' => 'text',
                        'required' => 1,
                        'wrapper' => ['width' => '25'],
                    ],
                    [
                        'key' => 'field_plan_period',
                        'label' => 'دوره',
                        'name' => 'period',
                        'type' => 'text',
                        'placeholder' => 'ماهانه',
                        'wrapper' => ['width' => '25'],
                    ],
                    [
                        'key' => 'field_plan_featured',
                        'label' => 'ویژه',
                        'name' => 'featured',
                        'type' => 'true_false',
                        'wrapper' => ['width' => '25'],
                    ],
                    [
                        'key' => 'field_plan_badge',
                        'label' => 'نشان',
                        'name' => 'badge',
                        'type' => 'text',
                        'placeholder' => 'پیشنهادی',
                    ],
                    [
                        'key' => 'field_plan_description',
                        'label' => 'توضیحات',
                        'name' => 'description',
                        'type' => 'textarea',
                        'rows' => 2,
                    ],
                    [
                        'key' => 'field_plan_features',
                        'label' => 'ویژگی‌ها',
                        'name' => 'features',
                        'type' => 'repeater',
                        'layout' => 'table',
                        'button_label' => 'افزودن ویژگی',
                        'sub_fields' => [
                            [
                                'key' => 'field_feature_text',
                                'label' => 'متن',
                                'name' => 'text',
                                'type' => 'text',
                            ],
                            [
                                'key' => 'field_feature_included',
                                'label' => 'فعال',
                                'name' => 'included',
                                'type' => 'true_false',
                                'default_value' => 1,
                            ],
                        ],
                    ],
                    [
                        'key' => 'field_plan_button_text',
                        'label' => 'متن دکمه',
                        'name' => 'button_text',
                        'type' => 'text',
                        'default_value' => 'انتخاب پلن',
                        'wrapper' => ['width' => '50'],
                    ],
                    [
                        'key' => 'field_plan_button_link',
                        'label' => 'لینک دکمه',
                        'name' => 'button_link',
                        'type' => 'url',
                        'wrapper' => ['width' => '50'],
                    ],
                ],
            ],
            [
                'key' => 'field_pricing_columns',
                'label' => 'تعداد ستون',
                'name' => 'columns',
                'type' => 'select',
                'choices' => [
                    '2' => '۲ ستون',
                    '3' => '۳ ستون',
                    '4' => '۴ ستون',
                ],
                'default_value' => '3',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_pricing_toggle',
                'label' => 'سوئیچ ماهانه/سالانه',
                'name' => 'show_toggle',
                'type' => 'true_false',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_pricing_bg',
                'label' => 'رنگ پس‌زمینه',
                'name' => 'bg_color',
                'type' => 'color_picker',
                'default_value' => '#f8fafc',
            ],
        ],
        'location' => [
            [['param' => 'block', 'operator' => '==', 'value' => 'acf/pricing']],
        ],
    ]);
});
?>
