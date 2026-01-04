<?php
/**
 * Hero Block - بنر اصلی
 *
 * @package Developer_Starter
 */

// محتوا
$title = get_field('title') ?: 'به وبسایت ما خوش آمدید';
$subtitle = get_field('subtitle') ?: '';
$description = get_field('description') ?: '';
$buttons = get_field('buttons') ?: [];

// پس‌زمینه
$bg_type = get_field('bg_type') ?: 'gradient';
$bg_color = get_field('bg_color') ?: '#1e293b';
$bg_gradient = get_field('bg_gradient') ?: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
$bg_image = get_field('bg_image');
$bg_video = get_field('bg_video') ?: '';
$overlay_color = get_field('overlay_color') ?: 'rgba(0,0,0,0.5)';
$text_color = get_field('text_color') ?: '#ffffff';

// تنظیمات نمایش
$height = get_field('height') ?: 'large';
$alignment = get_field('alignment') ?: 'center';
$show_scroll = get_field('show_scroll') ?: false;

// ارتفاع
$height_classes = [
    'small' => 'min-h-[400px]',
    'medium' => 'min-h-[600px]',
    'large' => 'min-h-[80vh]',
    'full' => 'min-h-screen',
];

// تراز
$align_classes = [
    'right' => 'text-right items-end',
    'center' => 'text-center items-center',
    'left' => 'text-left items-start',
];

$block_id = dst_block_id($block, 'hero');
?>

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="dst-block dst-hero relative flex <?php echo esc_attr($height_classes[$height] ?? 'min-h-[80vh]'); ?> overflow-hidden"
    x-data="{ loaded: false }"
    x-init="setTimeout(() => loaded = true, 100)"
>
    <!-- پس‌زمینه -->
    <?php if ($bg_type === 'video' && $bg_video): ?>
        <div class="absolute inset-0 z-0">
            <video class="w-full h-full object-cover" autoplay muted loop playsinline>
                <source src="<?php echo esc_url($bg_video); ?>" type="video/mp4">
            </video>
        </div>
    <?php elseif ($bg_type === 'image' && $bg_image): ?>
        <div class="absolute inset-0 z-0">
            <img src="<?php echo esc_url($bg_image['url']); ?>" alt="" class="w-full h-full object-cover">
        </div>
    <?php elseif ($bg_type === 'gradient'): ?>
        <div class="absolute inset-0 z-0" style="background: <?php echo esc_attr($bg_gradient); ?>;"></div>
    <?php else: ?>
        <div class="absolute inset-0 z-0" style="background-color: <?php echo esc_attr($bg_color); ?>;"></div>
    <?php endif; ?>

    <!-- Overlay -->
    <?php if ($bg_type === 'image' || $bg_type === 'video'): ?>
        <div class="absolute inset-0 z-10" style="background: <?php echo esc_attr($overlay_color); ?>;"></div>
    <?php endif; ?>

    <!-- محتوا -->
    <div class="relative z-20 container mx-auto px-4 flex flex-col justify-center <?php echo esc_attr($align_classes[$alignment] ?? 'items-center text-center'); ?>">
        <div
            class="max-w-4xl"
            x-show="loaded"
            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 translate-y-8"
            x-transition:enter-end="opacity-100 translate-y-0"
            style="color: <?php echo esc_attr($text_color); ?>;"
        >
            <?php if ($subtitle): ?>
                <p class="text-lg md:text-xl opacity-80 mb-4 font-medium"><?php echo esc_html($subtitle); ?></p>
            <?php endif; ?>

            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight"><?php echo wp_kses_post($title); ?></h1>

            <?php if ($description): ?>
                <p class="text-lg md:text-xl opacity-90 mb-8 max-w-2xl <?php echo $alignment === 'center' ? 'mx-auto' : ''; ?>">
                    <?php echo esc_html($description); ?>
                </p>
            <?php endif; ?>

            <?php if ($buttons): ?>
                <div class="flex flex-wrap gap-4 <?php echo $alignment === 'center' ? 'justify-center' : ($alignment === 'right' ? 'justify-end' : 'justify-start'); ?>">
                    <?php foreach ($buttons as $btn):
                        $style = $btn['style'] ?? 'primary';
                        $btn_class = match($style) {
                            'primary' => 'bg-white text-gray-900 hover:bg-gray-100',
                            'secondary' => 'bg-white/20 text-white border border-white/30 hover:bg-white/30',
                            'outline' => 'border-2 border-white text-white hover:bg-white hover:text-gray-900',
                            default => 'bg-white text-gray-900 hover:bg-gray-100'
                        };
                    ?>
                        <a href="<?php echo esc_url($btn['link'] ?: '#'); ?>" class="inline-flex items-center gap-2 px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 <?php echo esc_attr($btn_class); ?>">
                            <?php echo esc_html($btn['text'] ?? 'کلیک کنید'); ?>
                            <?php if (!empty($btn['show_arrow'])): ?>
                                <svg class="w-5 h-5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($show_scroll): ?>
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 animate-bounce">
            <svg class="w-8 h-8" style="color: <?php echo esc_attr($text_color); ?>;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    <?php endif; ?>
</section>

<?php
add_action('acf/init', function() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key' => 'group_block_hero',
        'title' => 'تنظیمات هیرو',
        'fields' => [
            ['key' => 'field_hero_tab_content', 'label' => 'محتوا', 'type' => 'tab'],
            ['key' => 'field_hero_title', 'label' => 'عنوان', 'name' => 'title', 'type' => 'text', 'default_value' => 'به وبسایت ما خوش آمدید'],
            ['key' => 'field_hero_subtitle', 'label' => 'زیرعنوان', 'name' => 'subtitle', 'type' => 'text'],
            ['key' => 'field_hero_description', 'label' => 'توضیحات', 'name' => 'description', 'type' => 'textarea', 'rows' => 3],
            [
                'key' => 'field_hero_buttons', 'label' => 'دکمه‌ها', 'name' => 'buttons', 'type' => 'repeater', 'max' => 3, 'layout' => 'table', 'button_label' => 'افزودن دکمه',
                'sub_fields' => [
                    ['key' => 'field_hero_btn_text', 'label' => 'متن', 'name' => 'text', 'type' => 'text'],
                    ['key' => 'field_hero_btn_link', 'label' => 'لینک', 'name' => 'link', 'type' => 'url'],
                    ['key' => 'field_hero_btn_style', 'label' => 'استایل', 'name' => 'style', 'type' => 'select', 'choices' => ['primary' => 'اصلی', 'secondary' => 'ثانویه', 'outline' => 'حاشیه‌دار']],
                    ['key' => 'field_hero_btn_arrow', 'label' => 'فلش', 'name' => 'show_arrow', 'type' => 'true_false'],
                ],
            ],
            ['key' => 'field_hero_tab_bg', 'label' => 'پس‌زمینه', 'type' => 'tab'],
            ['key' => 'field_hero_bg_type', 'label' => 'نوع', 'name' => 'bg_type', 'type' => 'button_group', 'choices' => ['color' => 'رنگ', 'gradient' => 'گرادیان', 'image' => 'تصویر', 'video' => 'ویدیو'], 'default_value' => 'gradient'],
            ['key' => 'field_hero_bg_color', 'label' => 'رنگ', 'name' => 'bg_color', 'type' => 'color_picker', 'default_value' => '#1e293b', 'conditional_logic' => [[['field' => 'field_hero_bg_type', 'operator' => '==', 'value' => 'color']]]],
            ['key' => 'field_hero_bg_gradient', 'label' => 'گرادیان', 'name' => 'bg_gradient', 'type' => 'text', 'default_value' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)', 'conditional_logic' => [[['field' => 'field_hero_bg_type', 'operator' => '==', 'value' => 'gradient']]]],
            ['key' => 'field_hero_bg_image', 'label' => 'تصویر', 'name' => 'bg_image', 'type' => 'image', 'return_format' => 'array', 'conditional_logic' => [[['field' => 'field_hero_bg_type', 'operator' => '==', 'value' => 'image']]]],
            ['key' => 'field_hero_bg_video', 'label' => 'آدرس ویدیو', 'name' => 'bg_video', 'type' => 'url', 'conditional_logic' => [[['field' => 'field_hero_bg_type', 'operator' => '==', 'value' => 'video']]]],
            ['key' => 'field_hero_overlay', 'label' => 'رنگ Overlay', 'name' => 'overlay_color', 'type' => 'text', 'default_value' => 'rgba(0,0,0,0.5)'],
            ['key' => 'field_hero_text_color', 'label' => 'رنگ متن', 'name' => 'text_color', 'type' => 'color_picker', 'default_value' => '#ffffff'],
            ['key' => 'field_hero_tab_display', 'label' => 'نمایش', 'type' => 'tab'],
            ['key' => 'field_hero_height', 'label' => 'ارتفاع', 'name' => 'height', 'type' => 'select', 'choices' => ['small' => 'کوچک', 'medium' => 'متوسط', 'large' => 'بزرگ', 'full' => 'تمام صفحه'], 'default_value' => 'large', 'wrapper' => ['width' => '50']],
            ['key' => 'field_hero_alignment', 'label' => 'تراز', 'name' => 'alignment', 'type' => 'button_group', 'choices' => ['right' => 'راست', 'center' => 'وسط', 'left' => 'چپ'], 'default_value' => 'center', 'wrapper' => ['width' => '50']],
            ['key' => 'field_hero_scroll', 'label' => 'فلش اسکرول', 'name' => 'show_scroll', 'type' => 'true_false'],
        ],
        'location' => [[['param' => 'block', 'operator' => '==', 'value' => 'acf/hero']]],
    ]);
});
?>
