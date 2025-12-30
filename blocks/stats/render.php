<?php
/**
 * Stats Counter Block
 *
 * @package Developer_Starter
 */

// فیلدها
$title = get_field('title') ?: '';
$stats = get_field('stats') ?: [];
$style = get_field('style') ?: 'default';
$bg_type = get_field('bg_type') ?: 'color';
$bg_color = get_field('bg_color') ?: '#1e293b';
$bg_image = get_field('bg_image');
$text_color = get_field('text_color') ?: '#ffffff';
$columns = get_field('columns') ?: '4';

// نمونه داده
if (empty($stats)) {
    $stats = [
        ['number' => 500, 'suffix' => '+', 'label' => 'پروژه موفق'],
        ['number' => 120, 'suffix' => '+', 'label' => 'مشتری راضی'],
        ['number' => 15, 'suffix' => '', 'label' => 'سال تجربه'],
        ['number' => 24, 'suffix' => '/7', 'label' => 'پشتیبانی'],
    ];
}

$col_classes = [
    '2' => 'md:grid-cols-2',
    '3' => 'md:grid-cols-3',
    '4' => 'md:grid-cols-2 lg:grid-cols-4',
];

$block_id = dst_block_id($block, 'stats');
?>

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="dst-block dst-stats py-16 lg:py-20 relative overflow-hidden"
    x-data="{
        shown: false,
        counters: [],
        animateCounter(el, target) {
            let current = 0;
            const increment = target / 50;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                el.textContent = Math.floor(current).toLocaleString('fa-IR');
            }, 30);
        }
    }"
    x-intersect:enter.once="shown = true; $nextTick(() => {
        document.querySelectorAll('.dst-stat-number').forEach(el => {
            animateCounter(el, parseInt(el.dataset.target));
        });
    })"
>
    <?php if ($bg_type === 'image' && $bg_image): ?>
        <div class="absolute inset-0 z-0">
            <img src="<?php echo esc_url($bg_image['url']); ?>" alt="" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gray-900/80"></div>
        </div>
    <?php else: ?>
        <div class="absolute inset-0 z-0" style="background-color: <?php echo esc_attr($bg_color); ?>;"></div>
    <?php endif; ?>

    <div class="container mx-auto px-4 relative z-10" style="color: <?php echo esc_attr($text_color); ?>;">
        <?php if ($title): ?>
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-12"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>

        <div class="grid gap-8 <?php echo esc_attr($col_classes[$columns] ?? 'lg:grid-cols-4'); ?>">
            <?php foreach ($stats as $index => $stat): ?>
                <div
                    class="text-center <?php echo $style === 'bordered' ? 'border border-white/20 rounded-2xl p-8' : ''; ?>"
                    x-show="shown"
                    x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 scale-90"
                    x-transition:enter-end="opacity-100 scale-100"
                    style="transition-delay: <?php echo $index * 150; ?>ms;"
                >
                    <?php if (!empty($stat['icon'])): ?>
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-white/10 flex items-center justify-center">
                            <?php
                            if (!empty($stat['custom_icon'])) {
                                echo '<img src="' . esc_url($stat['custom_icon']['url']) . '" alt="" class="w-8 h-8">';
                            } else {
                                echo dst_icon($stat['icon'], 'w-8 h-8');
                            }
                            ?>
                        </div>
                    <?php endif; ?>

                    <div class="text-4xl md:text-5xl lg:text-6xl font-bold mb-2">
                        <?php if (!empty($stat['prefix'])): ?>
                            <span><?php echo esc_html($stat['prefix']); ?></span>
                        <?php endif; ?>
                        <span class="dst-stat-number" data-target="<?php echo intval($stat['number']); ?>">0</span>
                        <?php if (!empty($stat['suffix'])): ?>
                            <span><?php echo esc_html($stat['suffix']); ?></span>
                        <?php endif; ?>
                    </div>

                    <p class="text-lg opacity-80"><?php echo esc_html($stat['label']); ?></p>
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
        'key' => 'group_block_stats',
        'title' => 'تنظیمات آمار',
        'fields' => [
            [
                'key' => 'field_stats_title',
                'label' => 'عنوان',
                'name' => 'title',
                'type' => 'text',
            ],
            [
                'key' => 'field_stats_items',
                'label' => 'آمار',
                'name' => 'stats',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'افزودن آمار',
                'sub_fields' => [
                    [
                        'key' => 'field_stat_icon',
                        'label' => 'آیکون',
                        'name' => 'icon',
                        'type' => 'select',
                        'choices' => [
                            '' => 'بدون آیکون',
                            'users' => 'کاربران',
                            'chart' => 'نمودار',
                            'check' => 'تیک',
                            'star' => 'ستاره',
                            'clock' => 'ساعت',
                        ],
                    ],
                    [
                        'key' => 'field_stat_prefix',
                        'label' => 'پیشوند',
                        'name' => 'prefix',
                        'type' => 'text',
                        'placeholder' => 'مثلاً: $',
                    ],
                    [
                        'key' => 'field_stat_number',
                        'label' => 'عدد',
                        'name' => 'number',
                        'type' => 'number',
                        'required' => 1,
                    ],
                    [
                        'key' => 'field_stat_suffix',
                        'label' => 'پسوند',
                        'name' => 'suffix',
                        'type' => 'text',
                        'placeholder' => 'مثلاً: +',
                    ],
                    [
                        'key' => 'field_stat_label',
                        'label' => 'عنوان',
                        'name' => 'label',
                        'type' => 'text',
                        'required' => 1,
                    ],
                ],
            ],
            [
                'key' => 'field_stats_columns',
                'label' => 'تعداد ستون',
                'name' => 'columns',
                'type' => 'select',
                'choices' => [
                    '2' => '۲ ستون',
                    '3' => '۳ ستون',
                    '4' => '۴ ستون',
                ],
                'default_value' => '4',
                'wrapper' => ['width' => '33'],
            ],
            [
                'key' => 'field_stats_style',
                'label' => 'استایل',
                'name' => 'style',
                'type' => 'select',
                'choices' => [
                    'default' => 'ساده',
                    'bordered' => 'با حاشیه',
                ],
                'default_value' => 'default',
                'wrapper' => ['width' => '33'],
            ],
            [
                'key' => 'field_stats_bg_type',
                'label' => 'نوع پس‌زمینه',
                'name' => 'bg_type',
                'type' => 'select',
                'choices' => [
                    'color' => 'رنگ',
                    'image' => 'تصویر',
                ],
                'default_value' => 'color',
                'wrapper' => ['width' => '34'],
            ],
            [
                'key' => 'field_stats_bg_color',
                'label' => 'رنگ پس‌زمینه',
                'name' => 'bg_color',
                'type' => 'color_picker',
                'default_value' => '#1e293b',
                'conditional_logic' => [
                    [['field' => 'field_stats_bg_type', 'operator' => '==', 'value' => 'color']],
                ],
            ],
            [
                'key' => 'field_stats_bg_image',
                'label' => 'تصویر پس‌زمینه',
                'name' => 'bg_image',
                'type' => 'image',
                'return_format' => 'array',
                'conditional_logic' => [
                    [['field' => 'field_stats_bg_type', 'operator' => '==', 'value' => 'image']],
                ],
            ],
            [
                'key' => 'field_stats_text_color',
                'label' => 'رنگ متن',
                'name' => 'text_color',
                'type' => 'color_picker',
                'default_value' => '#ffffff',
            ],
        ],
        'location' => [
            [['param' => 'block', 'operator' => '==', 'value' => 'acf/stats']],
        ],
    ]);
});
?>
