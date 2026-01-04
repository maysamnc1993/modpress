<?php
/**
 * Services Block - خدمات
 */

$title = get_field('title') ?: '';
$subtitle = get_field('subtitle') ?: '';
$services = get_field('services') ?: [];
$columns = get_field('columns') ?: '3';
$style = get_field('style') ?: 'cards';
$bg_color = get_field('bg_color') ?: '#ffffff';
$icon_style = get_field('icon_style') ?: 'filled';

if (empty($services)) {
    $services = [
        ['icon' => 'shield-alt', 'title' => 'امنیت بالا', 'description' => 'با بهترین استانداردهای امنیتی از داده‌های شما محافظت می‌کنیم.'],
        ['icon' => 'chart-line', 'title' => 'رشد سریع', 'description' => 'کسب و کار شما را با استراتژی‌های هوشمند رشد می‌دهیم.'],
        ['icon' => 'headset', 'title' => 'پشتیبانی ۲۴/۷', 'description' => 'تیم پشتیبانی ما همیشه آماده کمک به شماست.'],
    ];
}

$col_classes = ['2' => 'md:grid-cols-2', '3' => 'md:grid-cols-2 lg:grid-cols-3', '4' => 'md:grid-cols-2 lg:grid-cols-4'];
$block_id = dst_block_id($block, 'services');
?>

<section id="<?php echo esc_attr($block_id); ?>" class="dst-block dst-services py-16 lg:py-24" style="background-color: <?php echo esc_attr($bg_color); ?>;" x-data="{ shown: false }" x-intersect:enter="shown = true">
    <div class="container mx-auto px-4">
        <?php if ($title || $subtitle): ?>
            <div class="text-center max-w-3xl mx-auto mb-12">
                <?php if ($subtitle): ?><p class="text-primary-600 font-semibold mb-2"><?php echo esc_html($subtitle); ?></p><?php endif; ?>
                <?php if ($title): ?><h2 class="text-3xl md:text-4xl font-bold text-gray-900"><?php echo esc_html($title); ?></h2><?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="grid gap-6 lg:gap-8 <?php echo esc_attr($col_classes[$columns] ?? 'lg:grid-cols-3'); ?>">
            <?php foreach ($services as $index => $service): ?>
                <div class="<?php echo $style === 'cards' ? 'bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl' : 'p-6'; ?> transition-all duration-300 group" x-show="shown" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" style="transition-delay: <?php echo $index * 100; ?>ms;">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-14 h-14 rounded-xl <?php echo $icon_style === 'filled' ? 'bg-primary-600 text-white' : 'bg-primary-100 text-primary-600'; ?> flex items-center justify-center group-hover:scale-110 transition-transform">
                            <?php if (!empty($service['custom_icon'])): ?>
                                <img src="<?php echo esc_url($service['custom_icon']['url']); ?>" alt="" class="w-8 h-8">
                            <?php else: ?>
                                <i class="fas fa-<?php echo esc_attr($service['icon'] ?? 'check'); ?> text-2xl"></i>
                            <?php endif; ?>
                        </div>
                        <div class="flex-1">
                            <?php if (!empty($service['title'])): ?><h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-primary-600 transition-colors"><?php echo esc_html($service['title']); ?></h3><?php endif; ?>
                            <?php if (!empty($service['description'])): ?><p class="text-gray-600 leading-relaxed"><?php echo esc_html($service['description']); ?></p><?php endif; ?>
                            <?php if (!empty($service['link'])): ?>
                                <a href="<?php echo esc_url($service['link']); ?>" class="inline-flex items-center gap-2 mt-4 text-primary-600 font-medium hover:gap-3 transition-all">
                                    بیشتر بخوانید <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php
add_action('acf/init', function() {
    if (!function_exists('acf_add_local_field_group')) return;
    acf_add_local_field_group([
        'key' => 'group_block_services', 'title' => 'تنظیمات خدمات',
        'fields' => [
            ['key' => 'field_services_title', 'label' => 'عنوان', 'name' => 'title', 'type' => 'text'],
            ['key' => 'field_services_subtitle', 'label' => 'زیرعنوان', 'name' => 'subtitle', 'type' => 'text'],
            ['key' => 'field_services_items', 'label' => 'خدمات', 'name' => 'services', 'type' => 'repeater', 'layout' => 'block', 'button_label' => 'افزودن خدمت',
                'sub_fields' => [
                    ['key' => 'field_service_icon', 'label' => 'آیکون FontAwesome', 'name' => 'icon', 'type' => 'text', 'placeholder' => 'shield-alt', 'wrapper' => ['width' => '25']],
                    ['key' => 'field_service_custom_icon', 'label' => 'آیکون سفارشی', 'name' => 'custom_icon', 'type' => 'image', 'return_format' => 'array', 'wrapper' => ['width' => '25']],
                    ['key' => 'field_service_title', 'label' => 'عنوان', 'name' => 'title', 'type' => 'text', 'wrapper' => ['width' => '50']],
                    ['key' => 'field_service_desc', 'label' => 'توضیحات', 'name' => 'description', 'type' => 'textarea', 'rows' => 2],
                    ['key' => 'field_service_link', 'label' => 'لینک', 'name' => 'link', 'type' => 'url'],
                ],
            ],
            ['key' => 'field_services_columns', 'label' => 'تعداد ستون', 'name' => 'columns', 'type' => 'select', 'choices' => ['2' => '۲ ستون', '3' => '۳ ستون', '4' => '۴ ستون'], 'default_value' => '3', 'wrapper' => ['width' => '33']],
            ['key' => 'field_services_style', 'label' => 'استایل', 'name' => 'style', 'type' => 'select', 'choices' => ['cards' => 'کارتی', 'simple' => 'ساده'], 'default_value' => 'cards', 'wrapper' => ['width' => '33']],
            ['key' => 'field_services_icon_style', 'label' => 'استایل آیکون', 'name' => 'icon_style', 'type' => 'select', 'choices' => ['filled' => 'پر', 'light' => 'روشن'], 'default_value' => 'filled', 'wrapper' => ['width' => '34']],
            ['key' => 'field_services_bg', 'label' => 'رنگ پس‌زمینه', 'name' => 'bg_color', 'type' => 'color_picker', 'default_value' => '#ffffff'],
        ],
        'location' => [[['param' => 'block', 'operator' => '==', 'value' => 'acf/services']]],
    ]);
});
?>
