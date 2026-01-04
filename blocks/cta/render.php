<?php
/**
 * CTA Block - دعوت به اقدام
 */

$title = get_field('title') ?: 'همین حالا شروع کنید';
$subtitle = get_field('subtitle') ?: '';
$description = get_field('description') ?: '';
$buttons = get_field('buttons') ?: [];
$style = get_field('style') ?: 'centered';
$bg_type = get_field('bg_type') ?: 'gradient';
$bg_color = get_field('bg_color') ?: '#2563eb';
$bg_gradient = get_field('bg_gradient') ?: 'from-primary-600 to-primary-800';
$bg_image = get_field('bg_image');
$bg_pattern = get_field('bg_pattern') ?: 'none';
$text_color = get_field('text_color') ?: 'light';

$block_id = dst_block_id($block, 'cta');

// تنظیم رنگ متن
$text_classes = $text_color === 'light' ? 'text-white' : 'text-gray-900';
$subtext_classes = $text_color === 'light' ? 'text-white/80' : 'text-gray-600';

// تنظیم پس‌زمینه
$bg_style = '';
$bg_class = '';
if ($bg_type === 'color') {
    $bg_style = "background-color: {$bg_color};";
} elseif ($bg_type === 'gradient') {
    $bg_class = "bg-gradient-to-r {$bg_gradient}";
} elseif ($bg_type === 'image' && $bg_image) {
    $bg_style = "background-image: url('{$bg_image['url']}'); background-size: cover; background-position: center;";
}
?>

<section id="<?php echo esc_attr($block_id); ?>" class="dst-block dst-cta py-16 lg:py-24 <?php echo esc_attr($bg_class); ?> relative overflow-hidden" style="<?php echo esc_attr($bg_style); ?>">
    <?php if ($bg_type === 'image' && $bg_image): ?>
        <div class="absolute inset-0 bg-black/50"></div>
    <?php endif; ?>

    <?php if ($bg_pattern !== 'none'): ?>
        <div class="absolute inset-0 opacity-10">
            <?php if ($bg_pattern === 'dots'): ?>
                <div class="absolute inset-0" style="background-image: radial-gradient(circle, currentColor 1px, transparent 1px); background-size: 20px 20px;"></div>
            <?php elseif ($bg_pattern === 'grid'): ?>
                <div class="absolute inset-0" style="background-image: linear-gradient(currentColor 1px, transparent 1px), linear-gradient(90deg, currentColor 1px, transparent 1px); background-size: 40px 40px;"></div>
            <?php elseif ($bg_pattern === 'waves'): ?>
                <svg class="absolute bottom-0 left-0 w-full" viewBox="0 0 1440 120" fill="none"><path fill="currentColor" d="M0 120V60c240-40 480-60 720-60s480 20 720 60v60H0z"/></svg>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="container mx-auto px-4 relative z-10">
        <?php if ($style === 'centered'): ?>
            <!-- استایل مرکزی -->
            <div class="text-center max-w-3xl mx-auto">
                <?php if ($subtitle): ?>
                    <p class="font-semibold mb-2 <?php echo $text_color === 'light' ? 'text-white/80' : 'text-primary-600'; ?>"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>
                <?php if ($title): ?>
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-6 <?php echo esc_attr($text_classes); ?>"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>
                <?php if ($description): ?>
                    <p class="text-lg md:text-xl mb-8 <?php echo esc_attr($subtext_classes); ?>"><?php echo esc_html($description); ?></p>
                <?php endif; ?>

                <?php if ($buttons): ?>
                    <div class="flex flex-wrap justify-center gap-4">
                        <?php foreach ($buttons as $btn): ?>
                            <?php
                            $btn_classes = '';
                            if ($btn['style'] === 'primary') {
                                $btn_classes = $text_color === 'light'
                                    ? 'bg-white text-primary-600 hover:bg-gray-100'
                                    : 'bg-primary-600 text-white hover:bg-primary-700';
                            } elseif ($btn['style'] === 'secondary') {
                                $btn_classes = $text_color === 'light'
                                    ? 'bg-white/20 text-white border border-white/30 hover:bg-white/30'
                                    : 'bg-gray-100 text-gray-900 hover:bg-gray-200';
                            } else {
                                $btn_classes = $text_color === 'light'
                                    ? 'border-2 border-white text-white hover:bg-white hover:text-primary-600'
                                    : 'border-2 border-primary-600 text-primary-600 hover:bg-primary-600 hover:text-white';
                            }
                            ?>
                            <a href="<?php echo esc_url($btn['link']); ?>" class="inline-flex items-center gap-2 px-8 py-4 rounded-xl font-semibold transition-all duration-300 <?php echo esc_attr($btn_classes); ?>">
                                <?php if (!empty($btn['icon'])): ?>
                                    <i class="<?php echo esc_attr($btn['icon']); ?>"></i>
                                <?php endif; ?>
                                <?php echo esc_html($btn['text']); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

        <?php elseif ($style === 'split'): ?>
            <!-- استایل تقسیم شده -->
            <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
                <div class="lg:max-w-2xl">
                    <?php if ($subtitle): ?>
                        <p class="font-semibold mb-2 <?php echo $text_color === 'light' ? 'text-white/80' : 'text-primary-600'; ?>"><?php echo esc_html($subtitle); ?></p>
                    <?php endif; ?>
                    <?php if ($title): ?>
                        <h2 class="text-3xl md:text-4xl font-bold mb-4 <?php echo esc_attr($text_classes); ?>"><?php echo esc_html($title); ?></h2>
                    <?php endif; ?>
                    <?php if ($description): ?>
                        <p class="text-lg <?php echo esc_attr($subtext_classes); ?>"><?php echo esc_html($description); ?></p>
                    <?php endif; ?>
                </div>

                <?php if ($buttons): ?>
                    <div class="flex flex-wrap gap-4">
                        <?php foreach ($buttons as $btn): ?>
                            <?php
                            $btn_classes = '';
                            if ($btn['style'] === 'primary') {
                                $btn_classes = $text_color === 'light'
                                    ? 'bg-white text-primary-600 hover:bg-gray-100'
                                    : 'bg-primary-600 text-white hover:bg-primary-700';
                            } elseif ($btn['style'] === 'secondary') {
                                $btn_classes = $text_color === 'light'
                                    ? 'bg-white/20 text-white border border-white/30 hover:bg-white/30'
                                    : 'bg-gray-100 text-gray-900 hover:bg-gray-200';
                            } else {
                                $btn_classes = $text_color === 'light'
                                    ? 'border-2 border-white text-white hover:bg-white hover:text-primary-600'
                                    : 'border-2 border-primary-600 text-primary-600 hover:bg-primary-600 hover:text-white';
                            }
                            ?>
                            <a href="<?php echo esc_url($btn['link']); ?>" class="inline-flex items-center gap-2 px-8 py-4 rounded-xl font-semibold transition-all duration-300 <?php echo esc_attr($btn_classes); ?>">
                                <?php if (!empty($btn['icon'])): ?>
                                    <i class="<?php echo esc_attr($btn['icon']); ?>"></i>
                                <?php endif; ?>
                                <?php echo esc_html($btn['text']); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

        <?php else: ?>
            <!-- استایل کارت -->
            <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12 max-w-4xl mx-auto text-center">
                <?php if ($subtitle): ?>
                    <p class="text-primary-600 font-semibold mb-2"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>
                <?php if ($title): ?>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>
                <?php if ($description): ?>
                    <p class="text-lg text-gray-600 mb-8"><?php echo esc_html($description); ?></p>
                <?php endif; ?>

                <?php if ($buttons): ?>
                    <div class="flex flex-wrap justify-center gap-4">
                        <?php foreach ($buttons as $btn): ?>
                            <?php
                            $btn_classes = '';
                            if ($btn['style'] === 'primary') {
                                $btn_classes = 'bg-primary-600 text-white hover:bg-primary-700';
                            } elseif ($btn['style'] === 'secondary') {
                                $btn_classes = 'bg-gray-100 text-gray-900 hover:bg-gray-200';
                            } else {
                                $btn_classes = 'border-2 border-primary-600 text-primary-600 hover:bg-primary-600 hover:text-white';
                            }
                            ?>
                            <a href="<?php echo esc_url($btn['link']); ?>" class="inline-flex items-center gap-2 px-8 py-4 rounded-xl font-semibold transition-all duration-300 <?php echo esc_attr($btn_classes); ?>">
                                <?php if (!empty($btn['icon'])): ?>
                                    <i class="<?php echo esc_attr($btn['icon']); ?>"></i>
                                <?php endif; ?>
                                <?php echo esc_html($btn['text']); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
add_action('acf/init', function() {
    if (!function_exists('acf_add_local_field_group')) return;
    acf_add_local_field_group([
        'key' => 'group_block_cta', 'title' => 'تنظیمات دعوت به اقدام',
        'fields' => [
            ['key' => 'field_cta_title', 'label' => 'عنوان', 'name' => 'title', 'type' => 'text', 'default_value' => 'همین حالا شروع کنید'],
            ['key' => 'field_cta_subtitle', 'label' => 'زیرعنوان', 'name' => 'subtitle', 'type' => 'text'],
            ['key' => 'field_cta_desc', 'label' => 'توضیحات', 'name' => 'description', 'type' => 'textarea', 'rows' => 2],
            ['key' => 'field_cta_style', 'label' => 'استایل', 'name' => 'style', 'type' => 'button_group', 'choices' => ['centered' => 'مرکزی', 'split' => 'تقسیم شده', 'card' => 'کارت'], 'default_value' => 'centered'],
            ['key' => 'field_cta_buttons', 'label' => 'دکمه‌ها', 'name' => 'buttons', 'type' => 'repeater', 'layout' => 'table', 'button_label' => 'افزودن دکمه', 'max' => 3, 'sub_fields' => [
                ['key' => 'field_cta_btn_text', 'label' => 'متن', 'name' => 'text', 'type' => 'text'],
                ['key' => 'field_cta_btn_link', 'label' => 'لینک', 'name' => 'link', 'type' => 'url'],
                ['key' => 'field_cta_btn_style', 'label' => 'استایل', 'name' => 'style', 'type' => 'select', 'choices' => ['primary' => 'اصلی', 'secondary' => 'ثانویه', 'outline' => 'خطی']],
                ['key' => 'field_cta_btn_icon', 'label' => 'آیکون', 'name' => 'icon', 'type' => 'text', 'placeholder' => 'fas fa-arrow-left'],
            ]],
            ['key' => 'field_cta_bg_type', 'label' => 'نوع پس‌زمینه', 'name' => 'bg_type', 'type' => 'button_group', 'choices' => ['color' => 'رنگ', 'gradient' => 'گرادیان', 'image' => 'تصویر'], 'default_value' => 'gradient'],
            ['key' => 'field_cta_bg_color', 'label' => 'رنگ پس‌زمینه', 'name' => 'bg_color', 'type' => 'color_picker', 'default_value' => '#2563eb', 'conditional_logic' => [[['field' => 'field_cta_bg_type', 'operator' => '==', 'value' => 'color']]]],
            ['key' => 'field_cta_bg_gradient', 'label' => 'گرادیان', 'name' => 'bg_gradient', 'type' => 'select', 'choices' => [
                'from-primary-600 to-primary-800' => 'آبی',
                'from-emerald-500 to-teal-600' => 'سبز',
                'from-purple-600 to-indigo-700' => 'بنفش',
                'from-orange-500 to-red-600' => 'نارنجی-قرمز',
                'from-pink-500 to-rose-600' => 'صورتی',
            ], 'default_value' => 'from-primary-600 to-primary-800', 'conditional_logic' => [[['field' => 'field_cta_bg_type', 'operator' => '==', 'value' => 'gradient']]]],
            ['key' => 'field_cta_bg_image', 'label' => 'تصویر پس‌زمینه', 'name' => 'bg_image', 'type' => 'image', 'return_format' => 'array', 'conditional_logic' => [[['field' => 'field_cta_bg_type', 'operator' => '==', 'value' => 'image']]]],
            ['key' => 'field_cta_bg_pattern', 'label' => 'الگو', 'name' => 'bg_pattern', 'type' => 'select', 'choices' => ['none' => 'بدون الگو', 'dots' => 'نقطه‌ای', 'grid' => 'شبکه‌ای', 'waves' => 'موج'], 'default_value' => 'none'],
            ['key' => 'field_cta_text_color', 'label' => 'رنگ متن', 'name' => 'text_color', 'type' => 'button_group', 'choices' => ['light' => 'روشن', 'dark' => 'تیره'], 'default_value' => 'light'],
        ],
        'location' => [[['param' => 'block', 'operator' => '==', 'value' => 'acf/cta']]],
    ]);
});
?>
