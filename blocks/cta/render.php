<?php
/**
 * CTA (Call to Action) Block
 *
 * @package Developer_Starter
 */

// فیلدها
$title = get_field('title') ?: 'آماده شروع هستید؟';
$description = get_field('description') ?: 'همین الان با ما تماس بگیرید و از مشاوره رایگان بهره‌مند شوید.';
$buttons = get_field('buttons') ?: [];
$style = get_field('style') ?: 'gradient';
$bg_color = get_field('bg_color') ?: '#3C50E0';
$bg_gradient = get_field('bg_gradient') ?: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
$bg_image = get_field('bg_image');
$text_color = get_field('text_color') ?: '#ffffff';
$alignment = get_field('alignment') ?: 'center';
$show_pattern = get_field('show_pattern') ?: true;

// نمونه دکمه
if (empty($buttons)) {
    $buttons = [
        ['text' => 'شروع کنید', 'link' => '#', 'style' => 'white'],
        ['text' => 'بیشتر بدانید', 'link' => '#', 'style' => 'outline'],
    ];
}

$align_classes = [
    'left' => 'text-right',
    'center' => 'text-center',
    'right' => 'text-left',
];

$block_id = dst_block_id($block, 'cta');
?>

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="dst-block dst-cta py-16 lg:py-24 relative overflow-hidden"
    x-data="{ shown: false }"
    x-intersect:enter="shown = true"
>
    <!-- پس‌زمینه -->
    <?php if ($style === 'image' && $bg_image): ?>
        <div class="absolute inset-0 z-0">
            <img src="<?php echo esc_url($bg_image['url']); ?>" alt="" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gray-900/70"></div>
        </div>
    <?php elseif ($style === 'gradient'): ?>
        <div class="absolute inset-0 z-0" style="background: <?php echo esc_attr($bg_gradient); ?>;"></div>
    <?php else: ?>
        <div class="absolute inset-0 z-0" style="background-color: <?php echo esc_attr($bg_color); ?>;"></div>
    <?php endif; ?>

    <?php if ($show_pattern): ?>
        <!-- پترن تزئینی -->
        <div class="absolute inset-0 z-0 opacity-10">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <defs>
                    <pattern id="cta-pattern" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                        <circle cx="2" cy="2" r="1" fill="white"/>
                    </pattern>
                </defs>
                <rect fill="url(#cta-pattern)" width="100" height="100"/>
            </svg>
        </div>
    <?php endif; ?>

    <div class="container mx-auto px-4 relative z-10">
        <div
            class="max-w-4xl <?php echo $alignment === 'center' ? 'mx-auto' : ($alignment === 'left' ? 'mr-auto' : 'ml-auto'); ?> <?php echo esc_attr($align_classes[$alignment] ?? 'text-center'); ?>"
            x-show="shown"
            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 translate-y-8"
            x-transition:enter-end="opacity-100 translate-y-0"
            style="color: <?php echo esc_attr($text_color); ?>;"
        >
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-6">
                <?php echo wp_kses_post($title); ?>
            </h2>

            <?php if ($description): ?>
                <p class="text-lg md:text-xl opacity-90 mb-8 max-w-2xl <?php echo $alignment === 'center' ? 'mx-auto' : ''; ?>">
                    <?php echo esc_html($description); ?>
                </p>
            <?php endif; ?>

            <?php if ($buttons): ?>
                <div class="flex flex-wrap gap-4 <?php echo $alignment === 'center' ? 'justify-center' : ($alignment === 'left' ? 'justify-end' : 'justify-start'); ?>">
                    <?php foreach ($buttons as $btn): ?>
                        <?php
                        $btn_style = $btn['style'] ?? 'white';
                        $btn_classes = match($btn_style) {
                            'white' => 'bg-white text-gray-900 hover:bg-gray-100 shadow-lg',
                            'dark' => 'bg-gray-900 text-white hover:bg-gray-800',
                            'outline' => 'border-2 border-white text-white hover:bg-white hover:text-gray-900',
                            default => 'bg-white text-gray-900 hover:bg-gray-100'
                        };
                        ?>
                        <a
                            href="<?php echo esc_url($btn['link'] ?: '#'); ?>"
                            class="inline-flex items-center gap-2 px-8 py-4 rounded-xl font-semibold text-lg transition-all duration-300 <?php echo esc_attr($btn_classes); ?>"
                        >
                            <?php if (!empty($btn['icon_before'])): ?>
                                <?php echo dst_icon($btn['icon_before'], 'w-5 h-5'); ?>
                            <?php endif; ?>
                            <?php echo esc_html($btn['text'] ?? 'کلیک کنید'); ?>
                            <?php if (!empty($btn['icon_after'])): ?>
                                <?php echo dst_icon($btn['icon_after'], 'w-5 h-5'); ?>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
// ثبت فیلدها
add_action('acf/init', function() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key' => 'group_block_cta',
        'title' => 'تنظیمات CTA',
        'fields' => [
            [
                'key' => 'field_cta_title',
                'label' => 'عنوان',
                'name' => 'title',
                'type' => 'text',
                'default_value' => 'آماده شروع هستید؟',
            ],
            [
                'key' => 'field_cta_description',
                'label' => 'توضیحات',
                'name' => 'description',
                'type' => 'textarea',
                'rows' => 2,
            ],
            [
                'key' => 'field_cta_buttons',
                'label' => 'دکمه‌ها',
                'name' => 'buttons',
                'type' => 'repeater',
                'max' => 3,
                'layout' => 'table',
                'button_label' => 'افزودن دکمه',
                'sub_fields' => [
                    [
                        'key' => 'field_cta_btn_text',
                        'label' => 'متن',
                        'name' => 'text',
                        'type' => 'text',
                    ],
                    [
                        'key' => 'field_cta_btn_link',
                        'label' => 'لینک',
                        'name' => 'link',
                        'type' => 'url',
                    ],
                    [
                        'key' => 'field_cta_btn_style',
                        'label' => 'استایل',
                        'name' => 'style',
                        'type' => 'select',
                        'choices' => [
                            'white' => 'سفید',
                            'dark' => 'تیره',
                            'outline' => 'حاشیه‌دار',
                        ],
                    ],
                ],
            ],
            [
                'key' => 'field_cta_style',
                'label' => 'نوع پس‌زمینه',
                'name' => 'style',
                'type' => 'select',
                'choices' => [
                    'gradient' => 'گرادیان',
                    'color' => 'رنگ ساده',
                    'image' => 'تصویر',
                ],
                'default_value' => 'gradient',
                'wrapper' => ['width' => '33'],
            ],
            [
                'key' => 'field_cta_bg_color',
                'label' => 'رنگ پس‌زمینه',
                'name' => 'bg_color',
                'type' => 'color_picker',
                'default_value' => '#3C50E0',
                'conditional_logic' => [
                    [['field' => 'field_cta_style', 'operator' => '==', 'value' => 'color']],
                ],
            ],
            [
                'key' => 'field_cta_gradient',
                'label' => 'گرادیان CSS',
                'name' => 'bg_gradient',
                'type' => 'text',
                'default_value' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                'conditional_logic' => [
                    [['field' => 'field_cta_style', 'operator' => '==', 'value' => 'gradient']],
                ],
            ],
            [
                'key' => 'field_cta_image',
                'label' => 'تصویر پس‌زمینه',
                'name' => 'bg_image',
                'type' => 'image',
                'return_format' => 'array',
                'conditional_logic' => [
                    [['field' => 'field_cta_style', 'operator' => '==', 'value' => 'image']],
                ],
            ],
            [
                'key' => 'field_cta_text_color',
                'label' => 'رنگ متن',
                'name' => 'text_color',
                'type' => 'color_picker',
                'default_value' => '#ffffff',
                'wrapper' => ['width' => '33'],
            ],
            [
                'key' => 'field_cta_alignment',
                'label' => 'تراز',
                'name' => 'alignment',
                'type' => 'select',
                'choices' => [
                    'left' => 'راست',
                    'center' => 'وسط',
                    'right' => 'چپ',
                ],
                'default_value' => 'center',
                'wrapper' => ['width' => '34'],
            ],
            [
                'key' => 'field_cta_pattern',
                'label' => 'نمایش پترن',
                'name' => 'show_pattern',
                'type' => 'true_false',
                'default_value' => 1,
            ],
        ],
        'location' => [
            [['param' => 'block', 'operator' => '==', 'value' => 'acf/cta']],
        ],
    ]);
});
?>
