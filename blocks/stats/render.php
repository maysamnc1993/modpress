<?php
/**
 * Stats Block - آمار و ارقام
 */

$title = get_field('title') ?: '';
$subtitle = get_field('subtitle') ?: '';
$stats = get_field('stats') ?: [];
$columns = get_field('columns') ?: 4;
$style = get_field('style') ?: 'simple';
$bg_type = get_field('bg_type') ?: 'color';
$bg_color = get_field('bg_color') ?: '#1e3a5f';
$bg_gradient = get_field('bg_gradient') ?: 'from-primary-600 to-primary-800';
$bg_image = get_field('bg_image');
$text_color = get_field('text_color') ?: 'light';
$animation_duration = get_field('animation_duration') ?: 2000;

$block_id = dst_block_id($block, 'stats');

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

<section id="<?php echo esc_attr($block_id); ?>" class="dst-block dst-stats py-16 lg:py-24 <?php echo esc_attr($bg_class); ?> relative" style="<?php echo esc_attr($bg_style); ?>">
    <?php if ($bg_type === 'image' && $bg_image): ?>
        <div class="absolute inset-0 bg-black/60"></div>
    <?php endif; ?>

    <div class="container mx-auto px-4 relative z-10">
        <!-- عنوان -->
        <?php if ($title || $subtitle): ?>
            <div class="text-center mb-12">
                <?php if ($subtitle): ?><p class="font-semibold mb-2 <?php echo $text_color === 'light' ? 'text-white/80' : 'text-primary-600'; ?>"><?php echo esc_html($subtitle); ?></p><?php endif; ?>
                <?php if ($title): ?><h2 class="text-3xl md:text-4xl font-bold <?php echo esc_attr($text_classes); ?>"><?php echo esc_html($title); ?></h2><?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($stats): ?>
            <div class="grid gap-8 <?php
                echo $columns == 2 ? 'md:grid-cols-2' : '';
                echo $columns == 3 ? 'md:grid-cols-3' : '';
                echo $columns == 4 ? 'md:grid-cols-2 lg:grid-cols-4' : '';
            ?>">
                <?php foreach ($stats as $stat): ?>
                    <div class="text-center" x-data="{
                        count: 0,
                        target: <?php echo intval($stat['number']); ?>,
                        duration: <?php echo intval($animation_duration); ?>,
                        started: false,
                        start() {
                            if (this.started) return;
                            this.started = true;
                            const step = this.target / (this.duration / 16);
                            const animate = () => {
                                this.count += step;
                                if (this.count < this.target) {
                                    requestAnimationFrame(animate);
                                } else {
                                    this.count = this.target;
                                }
                            };
                            animate();
                        }
                    }" x-intersect:enter="start()">

                        <?php if ($style === 'icon' && !empty($stat['icon'])): ?>
                            <!-- استایل با آیکون -->
                            <div class="w-16 h-16 mx-auto mb-4 rounded-full <?php echo $text_color === 'light' ? 'bg-white/20' : 'bg-primary-100'; ?> flex items-center justify-center">
                                <i class="<?php echo esc_attr($stat['icon']); ?> text-2xl <?php echo $text_color === 'light' ? 'text-white' : 'text-primary-600'; ?>"></i>
                            </div>
                        <?php endif; ?>

                        <?php if ($style === 'card'): ?>
                            <!-- استایل کارت -->
                            <div class="bg-white/10 backdrop-blur rounded-2xl p-8">
                        <?php endif; ?>

                        <div class="flex items-center justify-center gap-1 mb-2">
                            <?php if (!empty($stat['prefix'])): ?>
                                <span class="text-3xl md:text-5xl font-bold <?php echo esc_attr($text_classes); ?>"><?php echo esc_html($stat['prefix']); ?></span>
                            <?php endif; ?>
                            <span class="text-4xl md:text-6xl font-bold <?php echo esc_attr($text_classes); ?>" x-text="Math.round(count).toLocaleString('fa-IR')"></span>
                            <?php if (!empty($stat['suffix'])): ?>
                                <span class="text-3xl md:text-5xl font-bold <?php echo esc_attr($text_classes); ?>"><?php echo esc_html($stat['suffix']); ?></span>
                            <?php endif; ?>
                        </div>

                        <p class="text-lg <?php echo esc_attr($subtext_classes); ?>"><?php echo esc_html($stat['label']); ?></p>

                        <?php if ($style === 'card'): ?>
                            </div>
                        <?php endif; ?>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
add_action('acf/init', function() {
    if (!function_exists('acf_add_local_field_group')) return;
    acf_add_local_field_group([
        'key' => 'group_block_stats', 'title' => 'تنظیمات آمار و ارقام',
        'fields' => [
            ['key' => 'field_stats_title', 'label' => 'عنوان', 'name' => 'title', 'type' => 'text'],
            ['key' => 'field_stats_subtitle', 'label' => 'زیرعنوان', 'name' => 'subtitle', 'type' => 'text'],
            ['key' => 'field_stats_style', 'label' => 'استایل', 'name' => 'style', 'type' => 'button_group', 'choices' => ['simple' => 'ساده', 'icon' => 'با آیکون', 'card' => 'کارت'], 'default_value' => 'simple'],
            ['key' => 'field_stats_columns', 'label' => 'تعداد ستون', 'name' => 'columns', 'type' => 'button_group', 'choices' => [2 => '۲', 3 => '۳', 4 => '۴'], 'default_value' => 4],
            ['key' => 'field_stats_duration', 'label' => 'مدت انیمیشن (میلی‌ثانیه)', 'name' => 'animation_duration', 'type' => 'number', 'default_value' => 2000],
            ['key' => 'field_stats_items', 'label' => 'آمار', 'name' => 'stats', 'type' => 'repeater', 'layout' => 'block', 'button_label' => 'افزودن آمار', 'sub_fields' => [
                ['key' => 'field_stats_number', 'label' => 'عدد', 'name' => 'number', 'type' => 'number', 'wrapper' => ['width' => '25']],
                ['key' => 'field_stats_prefix', 'label' => 'پیشوند', 'name' => 'prefix', 'type' => 'text', 'placeholder' => '+', 'wrapper' => ['width' => '15']],
                ['key' => 'field_stats_suffix', 'label' => 'پسوند', 'name' => 'suffix', 'type' => 'text', 'placeholder' => '%', 'wrapper' => ['width' => '15']],
                ['key' => 'field_stats_label', 'label' => 'برچسب', 'name' => 'label', 'type' => 'text', 'wrapper' => ['width' => '25']],
                ['key' => 'field_stats_icon', 'label' => 'آیکون FontAwesome', 'name' => 'icon', 'type' => 'text', 'placeholder' => 'fas fa-users', 'wrapper' => ['width' => '20']],
            ]],
            ['key' => 'field_stats_bg_type', 'label' => 'نوع پس‌زمینه', 'name' => 'bg_type', 'type' => 'button_group', 'choices' => ['color' => 'رنگ', 'gradient' => 'گرادیان', 'image' => 'تصویر'], 'default_value' => 'color'],
            ['key' => 'field_stats_bg_color', 'label' => 'رنگ پس‌زمینه', 'name' => 'bg_color', 'type' => 'color_picker', 'default_value' => '#1e3a5f', 'conditional_logic' => [[['field' => 'field_stats_bg_type', 'operator' => '==', 'value' => 'color']]]],
            ['key' => 'field_stats_bg_gradient', 'label' => 'گرادیان', 'name' => 'bg_gradient', 'type' => 'select', 'choices' => [
                'from-primary-600 to-primary-800' => 'آبی',
                'from-emerald-500 to-teal-600' => 'سبز',
                'from-purple-600 to-indigo-700' => 'بنفش',
                'from-orange-500 to-red-600' => 'نارنجی-قرمز',
                'from-gray-800 to-gray-900' => 'خاکستری',
            ], 'default_value' => 'from-primary-600 to-primary-800', 'conditional_logic' => [[['field' => 'field_stats_bg_type', 'operator' => '==', 'value' => 'gradient']]]],
            ['key' => 'field_stats_bg_image', 'label' => 'تصویر پس‌زمینه', 'name' => 'bg_image', 'type' => 'image', 'return_format' => 'array', 'conditional_logic' => [[['field' => 'field_stats_bg_type', 'operator' => '==', 'value' => 'image']]]],
            ['key' => 'field_stats_text_color', 'label' => 'رنگ متن', 'name' => 'text_color', 'type' => 'button_group', 'choices' => ['light' => 'روشن', 'dark' => 'تیره'], 'default_value' => 'light'],
        ],
        'location' => [[['param' => 'block', 'operator' => '==', 'value' => 'acf/stats']]],
    ]);
});
?>
