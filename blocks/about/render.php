<?php
/**
 * About Block - درباره ما
 */

$title = get_field('title') ?: 'درباره ما';
$subtitle = get_field('subtitle') ?: '';
$content = get_field('content') ?: '';
$image = get_field('image');
$image_position = get_field('image_position') ?: 'right';
$features = get_field('features') ?: [];
$button_text = get_field('button_text') ?: '';
$button_link = get_field('button_link') ?: '';
$bg_color = get_field('bg_color') ?: '#ffffff';

$block_id = dst_block_id($block, 'about');
?>

<section id="<?php echo esc_attr($block_id); ?>" class="dst-block dst-about py-16 lg:py-24" style="background-color: <?php echo esc_attr($bg_color); ?>;">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center <?php echo $image_position === 'left' ? 'lg:flex-row-reverse' : ''; ?>">
            <!-- محتوا -->
            <div class="<?php echo $image_position === 'left' ? 'lg:order-2' : ''; ?>">
                <?php if ($subtitle): ?><p class="text-primary-600 font-semibold mb-2"><?php echo esc_html($subtitle); ?></p><?php endif; ?>
                <?php if ($title): ?><h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6"><?php echo esc_html($title); ?></h2><?php endif; ?>
                <?php if ($content): ?><div class="text-gray-600 leading-relaxed mb-8 prose prose-lg"><?php echo wp_kses_post($content); ?></div><?php endif; ?>

                <?php if ($features): ?>
                    <div class="grid sm:grid-cols-2 gap-4 mb-8">
                        <?php foreach ($features as $feature): ?>
                            <div class="flex items-center gap-3">
                                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                <span class="text-gray-700 font-medium"><?php echo esc_html($feature['text']); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if ($button_text && $button_link): ?>
                    <a href="<?php echo esc_url($button_link); ?>" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white rounded-lg font-semibold hover:bg-primary-700 transition-colors">
                        <?php echo esc_html($button_text); ?>
                        <svg class="w-5 h-5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                <?php endif; ?>
            </div>

            <!-- تصویر -->
            <div class="<?php echo $image_position === 'left' ? 'lg:order-1' : ''; ?>" x-data="{ shown: false }" x-intersect:enter="shown = true">
                <div class="relative" x-show="shown" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                    <?php if ($image): ?>
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ?: $title); ?>" class="rounded-2xl shadow-2xl w-full">
                    <?php else: ?>
                        <div class="aspect-[4/3] bg-gradient-to-br from-primary-100 to-primary-200 rounded-2xl flex items-center justify-center">
                            <svg class="w-24 h-24 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                    <?php endif; ?>
                    <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-primary-600 rounded-2xl -z-10"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
add_action('acf/init', function() {
    if (!function_exists('acf_add_local_field_group')) return;
    acf_add_local_field_group([
        'key' => 'group_block_about', 'title' => 'تنظیمات درباره ما',
        'fields' => [
            ['key' => 'field_about_title', 'label' => 'عنوان', 'name' => 'title', 'type' => 'text', 'default_value' => 'درباره ما'],
            ['key' => 'field_about_subtitle', 'label' => 'زیرعنوان', 'name' => 'subtitle', 'type' => 'text'],
            ['key' => 'field_about_content', 'label' => 'محتوا', 'name' => 'content', 'type' => 'wysiwyg', 'toolbar' => 'basic', 'media_upload' => 0],
            ['key' => 'field_about_image', 'label' => 'تصویر', 'name' => 'image', 'type' => 'image', 'return_format' => 'array'],
            ['key' => 'field_about_image_pos', 'label' => 'موقعیت تصویر', 'name' => 'image_position', 'type' => 'button_group', 'choices' => ['right' => 'راست', 'left' => 'چپ'], 'default_value' => 'right'],
            ['key' => 'field_about_features', 'label' => 'ویژگی‌ها', 'name' => 'features', 'type' => 'repeater', 'layout' => 'table', 'button_label' => 'افزودن ویژگی', 'sub_fields' => [['key' => 'field_about_feature_text', 'label' => 'متن', 'name' => 'text', 'type' => 'text']]],
            ['key' => 'field_about_btn_text', 'label' => 'متن دکمه', 'name' => 'button_text', 'type' => 'text', 'wrapper' => ['width' => '50']],
            ['key' => 'field_about_btn_link', 'label' => 'لینک دکمه', 'name' => 'button_link', 'type' => 'url', 'wrapper' => ['width' => '50']],
            ['key' => 'field_about_bg', 'label' => 'رنگ پس‌زمینه', 'name' => 'bg_color', 'type' => 'color_picker', 'default_value' => '#ffffff'],
        ],
        'location' => [[['param' => 'block', 'operator' => '==', 'value' => 'acf/about']]],
    ]);
});
?>
