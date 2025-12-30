<?php
/**
 * Testimonials Block
 *
 * @package Developer_Starter
 */

// فیلدها
$title = get_field('title') ?: '';
$subtitle = get_field('subtitle') ?: '';
$testimonials = get_field('testimonials') ?: [];
$layout = get_field('layout') ?: 'slider';
$columns = get_field('columns') ?: '3';
$bg_color = get_field('bg_color') ?: '#f8fafc';
$show_rating = get_field('show_rating') ?: true;

// نمونه داده
if (empty($testimonials)) {
    $testimonials = [
        ['name' => 'علی محمدی', 'role' => 'مدیرعامل شرکت آلفا', 'content' => 'تجربه فوق‌العاده‌ای با این تیم داشتم. کار حرفه‌ای و به موقع تحویل دادند.', 'rating' => 5],
        ['name' => 'سارا احمدی', 'role' => 'مدیر مارکتینگ', 'content' => 'کیفیت خدمات عالی و پشتیبانی بی‌نظیر. حتماً به دیگران پیشنهاد می‌کنم.', 'rating' => 5],
        ['name' => 'محمد رضایی', 'role' => 'کارآفرین', 'content' => 'بهترین سرمایه‌گذاری برای کسب و کارم بود. نتایج فراتر از انتظار.', 'rating' => 5],
    ];
}

$block_id = dst_block_id($block, 'testimonials');
?>

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="dst-block dst-testimonials py-16 lg:py-24"
    style="background-color: <?php echo esc_attr($bg_color); ?>;"
    x-data="{
        current: 0,
        total: <?php echo count($testimonials); ?>,
        autoplay: null,
        init() {
            this.autoplay = setInterval(() => this.next(), 5000);
        },
        next() {
            this.current = (this.current + 1) % this.total;
        },
        prev() {
            this.current = (this.current - 1 + this.total) % this.total;
        }
    }"
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
            </div>
        <?php endif; ?>

        <?php if ($layout === 'slider'): ?>
            <!-- اسلایدر -->
            <div class="relative max-w-4xl mx-auto">
                <div class="overflow-hidden">
                    <?php foreach ($testimonials as $index => $item): ?>
                        <div
                            x-show="current === <?php echo $index; ?>"
                            x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 translate-x-8"
                            x-transition:enter-end="opacity-100 translate-x-0"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="bg-white rounded-2xl shadow-xl p-8 md:p-12"
                        >
                            <div class="text-primary-500 mb-6">
                                <?php echo dst_icon('quote', 'w-12 h-12 opacity-30'); ?>
                            </div>

                            <p class="text-xl md:text-2xl text-gray-700 leading-relaxed mb-8">
                                <?php echo esc_html($item['content']); ?>
                            </p>

                            <div class="flex items-center gap-4">
                                <?php if (!empty($item['image'])): ?>
                                    <img
                                        src="<?php echo esc_url($item['image']['url']); ?>"
                                        alt="<?php echo esc_attr($item['name']); ?>"
                                        class="w-16 h-16 rounded-full object-cover"
                                    >
                                <?php else: ?>
                                    <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold text-xl">
                                        <?php echo mb_substr($item['name'], 0, 1); ?>
                                    </div>
                                <?php endif; ?>

                                <div>
                                    <h4 class="font-bold text-gray-900"><?php echo esc_html($item['name']); ?></h4>
                                    <?php if (!empty($item['role'])): ?>
                                        <p class="text-gray-500"><?php echo esc_html($item['role']); ?></p>
                                    <?php endif; ?>

                                    <?php if ($show_rating && !empty($item['rating'])): ?>
                                        <div class="flex gap-1 mt-1 text-yellow-400">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <?php if ($i <= $item['rating']): ?>
                                                    <?php echo dst_icon('star', 'w-4 h-4'); ?>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- کنترل‌ها -->
                <div class="flex justify-center items-center gap-4 mt-8">
                    <button
                        @click="prev()"
                        class="w-12 h-12 rounded-full bg-white shadow-lg flex items-center justify-center hover:bg-primary-50 transition-colors"
                    >
                        <svg class="w-5 h-5 text-gray-600 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>

                    <div class="flex gap-2">
                        <?php foreach ($testimonials as $index => $item): ?>
                            <button
                                @click="current = <?php echo $index; ?>"
                                :class="current === <?php echo $index; ?> ? 'bg-primary-600 w-8' : 'bg-gray-300 w-2'"
                                class="h-2 rounded-full transition-all duration-300"
                            ></button>
                        <?php endforeach; ?>
                    </div>

                    <button
                        @click="next()"
                        class="w-12 h-12 rounded-full bg-white shadow-lg flex items-center justify-center hover:bg-primary-50 transition-colors"
                    >
                        <svg class="w-5 h-5 text-gray-600 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>
        <?php else: ?>
            <!-- گرید -->
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-<?php echo esc_attr($columns); ?>">
                <?php foreach ($testimonials as $index => $item): ?>
                    <div
                        class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-shadow"
                        x-data="{ shown: false }"
                        x-intersect:enter="shown = true"
                        x-show="shown"
                        x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        style="transition-delay: <?php echo $index * 100; ?>ms;"
                    >
                        <?php if ($show_rating && !empty($item['rating'])): ?>
                            <div class="flex gap-1 mb-4 text-yellow-400">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <?php if ($i <= $item['rating']): ?>
                                        <?php echo dst_icon('star', 'w-5 h-5'); ?>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                        <?php endif; ?>

                        <p class="text-gray-600 leading-relaxed mb-6">
                            <?php echo esc_html($item['content']); ?>
                        </p>

                        <div class="flex items-center gap-3">
                            <?php if (!empty($item['image'])): ?>
                                <img
                                    src="<?php echo esc_url($item['image']['url']); ?>"
                                    alt="<?php echo esc_attr($item['name']); ?>"
                                    class="w-12 h-12 rounded-full object-cover"
                                >
                            <?php else: ?>
                                <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold">
                                    <?php echo mb_substr($item['name'], 0, 1); ?>
                                </div>
                            <?php endif; ?>

                            <div>
                                <h4 class="font-bold text-gray-900"><?php echo esc_html($item['name']); ?></h4>
                                <?php if (!empty($item['role'])): ?>
                                    <p class="text-sm text-gray-500"><?php echo esc_html($item['role']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
// ثبت فیلدها
add_action('acf/init', function() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key' => 'group_block_testimonials',
        'title' => 'تنظیمات نظرات',
        'fields' => [
            [
                'key' => 'field_testimonials_title',
                'label' => 'عنوان',
                'name' => 'title',
                'type' => 'text',
            ],
            [
                'key' => 'field_testimonials_subtitle',
                'label' => 'زیرعنوان',
                'name' => 'subtitle',
                'type' => 'text',
            ],
            [
                'key' => 'field_testimonials_items',
                'label' => 'نظرات',
                'name' => 'testimonials',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'افزودن نظر',
                'sub_fields' => [
                    [
                        'key' => 'field_testimonial_image',
                        'label' => 'تصویر',
                        'name' => 'image',
                        'type' => 'image',
                        'return_format' => 'array',
                        'wrapper' => ['width' => '25'],
                    ],
                    [
                        'key' => 'field_testimonial_name',
                        'label' => 'نام',
                        'name' => 'name',
                        'type' => 'text',
                        'wrapper' => ['width' => '25'],
                    ],
                    [
                        'key' => 'field_testimonial_role',
                        'label' => 'سمت/شرکت',
                        'name' => 'role',
                        'type' => 'text',
                        'wrapper' => ['width' => '25'],
                    ],
                    [
                        'key' => 'field_testimonial_rating',
                        'label' => 'امتیاز',
                        'name' => 'rating',
                        'type' => 'range',
                        'min' => 1,
                        'max' => 5,
                        'default_value' => 5,
                        'wrapper' => ['width' => '25'],
                    ],
                    [
                        'key' => 'field_testimonial_content',
                        'label' => 'متن نظر',
                        'name' => 'content',
                        'type' => 'textarea',
                        'rows' => 3,
                    ],
                ],
            ],
            [
                'key' => 'field_testimonials_layout',
                'label' => 'نوع نمایش',
                'name' => 'layout',
                'type' => 'select',
                'choices' => [
                    'slider' => 'اسلایدر',
                    'grid' => 'گرید',
                ],
                'default_value' => 'slider',
                'wrapper' => ['width' => '33'],
            ],
            [
                'key' => 'field_testimonials_columns',
                'label' => 'تعداد ستون (گرید)',
                'name' => 'columns',
                'type' => 'select',
                'choices' => [
                    '2' => '۲ ستون',
                    '3' => '۳ ستون',
                ],
                'default_value' => '3',
                'wrapper' => ['width' => '33'],
                'conditional_logic' => [
                    [['field' => 'field_testimonials_layout', 'operator' => '==', 'value' => 'grid']],
                ],
            ],
            [
                'key' => 'field_testimonials_rating',
                'label' => 'نمایش امتیاز',
                'name' => 'show_rating',
                'type' => 'true_false',
                'default_value' => 1,
                'wrapper' => ['width' => '34'],
            ],
            [
                'key' => 'field_testimonials_bg',
                'label' => 'رنگ پس‌زمینه',
                'name' => 'bg_color',
                'type' => 'color_picker',
                'default_value' => '#f8fafc',
            ],
        ],
        'location' => [
            [['param' => 'block', 'operator' => '==', 'value' => 'acf/testimonials']],
        ],
    ]);
});
?>
