<?php
/**
 * Clients/Partners Logo Block
 *
 * @package Developer_Starter
 */

// فیلدها
$title = get_field('title') ?: '';
$subtitle = get_field('subtitle') ?: '';
$clients = get_field('clients') ?: [];
$layout = get_field('layout') ?: 'slider';
$columns = get_field('columns') ?: '6';
$bg_color = get_field('bg_color') ?: '#f8fafc';
$grayscale = get_field('grayscale') ?: true;

// نمونه داده
if (empty($clients)) {
    $clients = [
        ['name' => 'شرکت آلفا'],
        ['name' => 'شرکت بتا'],
        ['name' => 'شرکت گاما'],
        ['name' => 'شرکت دلتا'],
        ['name' => 'شرکت اپسیلون'],
        ['name' => 'شرکت زتا'],
    ];
}

$col_classes = [
    '4' => 'grid-cols-2 md:grid-cols-4',
    '5' => 'grid-cols-2 md:grid-cols-3 lg:grid-cols-5',
    '6' => 'grid-cols-2 md:grid-cols-3 lg:grid-cols-6',
];

$block_id = dst_block_id($block, 'clients');
?>

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="dst-block dst-clients py-12 lg:py-16"
    style="background-color: <?php echo esc_attr($bg_color); ?>;"
>
    <div class="container mx-auto px-4">
        <?php if ($title || $subtitle): ?>
            <div class="text-center max-w-3xl mx-auto mb-10">
                <?php if ($subtitle): ?>
                    <p class="text-primary-600 font-semibold mb-2"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>
                <?php if ($title): ?>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($layout === 'slider'): ?>
            <!-- اسلایدر -->
            <div
                class="overflow-hidden"
                x-data="{
                    scroll: 0,
                    init() {
                        setInterval(() => {
                            this.scroll -= 1;
                            if (this.scroll <= -100) this.scroll = 0;
                        }, 30);
                    }
                }"
            >
                <div
                    class="flex gap-12 items-center"
                    :style="'transform: translateX(' + scroll + '%); width: 200%;'"
                >
                    <?php for ($i = 0; $i < 2; $i++): ?>
                        <?php foreach ($clients as $client): ?>
                            <div class="flex-shrink-0 px-6">
                                <?php if (!empty($client['logo'])): ?>
                                    <img
                                        src="<?php echo esc_url($client['logo']['url']); ?>"
                                        alt="<?php echo esc_attr($client['name']); ?>"
                                        class="h-12 md:h-16 w-auto object-contain <?php echo $grayscale ? 'grayscale hover:grayscale-0' : ''; ?> opacity-60 hover:opacity-100 transition-all duration-300"
                                    >
                                <?php else: ?>
                                    <div class="h-12 md:h-16 px-6 bg-gray-200 rounded-lg flex items-center justify-center <?php echo $grayscale ? 'grayscale hover:grayscale-0' : ''; ?> opacity-60 hover:opacity-100 transition-all">
                                        <span class="text-gray-500 font-semibold"><?php echo esc_html($client['name']); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endfor; ?>
                </div>
            </div>
        <?php else: ?>
            <!-- گرید -->
            <div class="grid gap-8 items-center <?php echo esc_attr($col_classes[$columns] ?? 'lg:grid-cols-6'); ?>">
                <?php foreach ($clients as $index => $client): ?>
                    <div
                        class="flex items-center justify-center p-4"
                        x-data="{ shown: false }"
                        x-intersect:enter="shown = true"
                        x-show="shown"
                        x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0 scale-90"
                        x-transition:enter-end="opacity-100 scale-100"
                        style="transition-delay: <?php echo $index * 50; ?>ms;"
                    >
                        <?php if (!empty($client['logo'])): ?>
                            <?php if (!empty($client['url'])): ?>
                                <a href="<?php echo esc_url($client['url']); ?>" target="_blank" rel="noopener">
                            <?php endif; ?>
                                <img
                                    src="<?php echo esc_url($client['logo']['url']); ?>"
                                    alt="<?php echo esc_attr($client['name']); ?>"
                                    class="h-12 md:h-16 w-auto object-contain <?php echo $grayscale ? 'grayscale hover:grayscale-0' : ''; ?> opacity-60 hover:opacity-100 transition-all duration-300"
                                >
                            <?php if (!empty($client['url'])): ?>
                                </a>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="h-12 md:h-16 px-6 bg-gray-200 rounded-lg flex items-center justify-center <?php echo $grayscale ? 'grayscale hover:grayscale-0' : ''; ?> opacity-60 hover:opacity-100 transition-all">
                                <span class="text-gray-500 font-semibold"><?php echo esc_html($client['name']); ?></span>
                            </div>
                        <?php endif; ?>
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
        'key' => 'group_block_clients',
        'title' => 'تنظیمات مشتریان',
        'fields' => [
            [
                'key' => 'field_clients_title',
                'label' => 'عنوان',
                'name' => 'title',
                'type' => 'text',
            ],
            [
                'key' => 'field_clients_subtitle',
                'label' => 'زیرعنوان',
                'name' => 'subtitle',
                'type' => 'text',
            ],
            [
                'key' => 'field_clients_items',
                'label' => 'مشتریان',
                'name' => 'clients',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'افزودن مشتری',
                'sub_fields' => [
                    [
                        'key' => 'field_client_logo',
                        'label' => 'لوگو',
                        'name' => 'logo',
                        'type' => 'image',
                        'return_format' => 'array',
                    ],
                    [
                        'key' => 'field_client_name',
                        'label' => 'نام',
                        'name' => 'name',
                        'type' => 'text',
                    ],
                    [
                        'key' => 'field_client_url',
                        'label' => 'لینک',
                        'name' => 'url',
                        'type' => 'url',
                    ],
                ],
            ],
            [
                'key' => 'field_clients_layout',
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
                'key' => 'field_clients_columns',
                'label' => 'تعداد ستون (گرید)',
                'name' => 'columns',
                'type' => 'select',
                'choices' => [
                    '4' => '۴ ستون',
                    '5' => '۵ ستون',
                    '6' => '۶ ستون',
                ],
                'default_value' => '6',
                'wrapper' => ['width' => '33'],
                'conditional_logic' => [
                    [['field' => 'field_clients_layout', 'operator' => '==', 'value' => 'grid']],
                ],
            ],
            [
                'key' => 'field_clients_grayscale',
                'label' => 'سیاه و سفید',
                'name' => 'grayscale',
                'type' => 'true_false',
                'default_value' => 1,
                'wrapper' => ['width' => '34'],
            ],
            [
                'key' => 'field_clients_bg',
                'label' => 'رنگ پس‌زمینه',
                'name' => 'bg_color',
                'type' => 'color_picker',
                'default_value' => '#f8fafc',
            ],
        ],
        'location' => [
            [['param' => 'block', 'operator' => '==', 'value' => 'acf/clients']],
        ],
    ]);
});
?>
