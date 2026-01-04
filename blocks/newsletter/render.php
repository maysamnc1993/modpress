<?php
/**
 * Newsletter Block - فرم عضویت خبرنامه
 *
 * @package Developer_Starter
 */

// محتوا
$title = get_field('title') ?: 'عضو خبرنامه ما شوید';
$subtitle = get_field('subtitle') ?: '';
$description = get_field('description') ?: 'با عضویت در خبرنامه از آخرین اخبار و تخفیف‌های ویژه باخبر شوید.';
$button_text = get_field('button_text') ?: 'عضویت';
$placeholder = get_field('placeholder') ?: 'ایمیل خود را وارد کنید...';
$success_message = get_field('success_message') ?: 'با موفقیت عضو خبرنامه شدید!';

// تنظیمات نمایش
$layout = get_field('layout') ?: 'horizontal';
$style = get_field('style') ?: 'default';
$show_icon = get_field('show_icon') !== false;
$show_name = get_field('show_name') ?: false;

// پس‌زمینه
$bg_type = get_field('bg_type') ?: 'color';
$bg_color = get_field('bg_color') ?: '#f8fafc';
$bg_gradient = get_field('bg_gradient') ?: '';
$bg_image = get_field('bg_image');
$overlay_color = get_field('overlay_color') ?: 'rgba(0,0,0,0.5)';
$text_color = get_field('text_color') ?: '';

// تنظیمات پیشرفته
$form_shortcode = get_field('form_shortcode') ?: '';

$block_id = dst_block_id($block, 'newsletter');

// تعیین رنگ متن
$is_dark_bg = in_array($bg_type, ['gradient', 'image']) || (
    $bg_type === 'color' &&
    preg_match('/^#([0-9a-f]{6})$/i', $bg_color, $matches) &&
    (hexdec(substr($matches[1], 0, 2)) + hexdec(substr($matches[1], 2, 2)) + hexdec(substr($matches[1], 4, 2))) / 3 < 128
);
$text_class = $text_color ? '' : ($is_dark_bg ? 'text-white' : 'text-gray-900');
?>

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="dst-block dst-newsletter py-16 lg:py-24 relative overflow-hidden"
    x-data="{
        email: '',
        name: '',
        loading: false,
        success: false,
        error: '',
        async submit() {
            if (!this.email) return;

            this.loading = true;
            this.error = '';

            // شبیه‌سازی ارسال - در پروژه واقعی با API جایگزین شود
            await new Promise(resolve => setTimeout(resolve, 1500));

            this.loading = false;
            this.success = true;
            this.email = '';
            this.name = '';
        }
    }"
>
    <!-- پس‌زمینه -->
    <?php if ($bg_type === 'image' && $bg_image): ?>
        <div class="absolute inset-0 z-0">
            <img
                src="<?php echo esc_url($bg_image['url']); ?>"
                alt=""
                class="w-full h-full object-cover"
            >
            <div class="absolute inset-0" style="background: <?php echo esc_attr($overlay_color); ?>;"></div>
        </div>
    <?php elseif ($bg_type === 'gradient' && $bg_gradient): ?>
        <div class="absolute inset-0 z-0" style="background: <?php echo esc_attr($bg_gradient); ?>;"></div>
    <?php else: ?>
        <div class="absolute inset-0 z-0" style="background-color: <?php echo esc_attr($bg_color); ?>;"></div>
    <?php endif; ?>

    <div class="container mx-auto px-4 relative z-10">
        <div
            class="max-w-3xl mx-auto <?php echo esc_attr($text_class); ?>"
            <?php if ($text_color): ?>style="color: <?php echo esc_attr($text_color); ?>;"<?php endif; ?>
        >
            <!-- هدر -->
            <div class="text-center mb-8">
                <?php if ($show_icon): ?>
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full <?php echo $is_dark_bg ? 'bg-white/10' : 'bg-primary-100'; ?> mb-4">
                        <svg class="w-8 h-8 <?php echo $is_dark_bg ? 'text-white' : 'text-primary-600'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                <?php endif; ?>

                <?php if ($subtitle): ?>
                    <p class="<?php echo $is_dark_bg ? 'text-white/70' : 'text-primary-600'; ?> font-semibold mb-2"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>

                <?php if ($title): ?>
                    <h2 class="text-3xl md:text-4xl font-bold mb-4"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>

                <?php if ($description): ?>
                    <p class="text-lg <?php echo $is_dark_bg ? 'opacity-80' : 'text-gray-600'; ?>"><?php echo esc_html($description); ?></p>
                <?php endif; ?>
            </div>

            <!-- فرم -->
            <?php if ($form_shortcode): ?>
                <div class="newsletter-form-wrapper">
                    <?php echo do_shortcode($form_shortcode); ?>
                </div>
            <?php else: ?>
                <form @submit.prevent="submit" class="relative">
                    <!-- پیام موفقیت -->
                    <div
                        x-show="success"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        class="text-center py-8"
                        x-cloak
                    >
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-600 mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <p class="text-lg font-semibold"><?php echo esc_html($success_message); ?></p>
                    </div>

                    <!-- فرم -->
                    <div x-show="!success" class="<?php echo $layout === 'horizontal' ? 'flex flex-col sm:flex-row gap-4' : 'space-y-4'; ?>">
                        <?php if ($show_name): ?>
                            <input
                                type="text"
                                x-model="name"
                                placeholder="نام شما"
                                class="<?php echo $layout === 'horizontal' ? 'flex-1' : 'w-full'; ?> px-6 py-4 rounded-xl border-2 <?php echo $is_dark_bg ? 'border-white/20 bg-white/10 text-white placeholder-white/50' : 'border-gray-200 bg-white text-gray-900 placeholder-gray-400'; ?> focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition-all"
                            >
                        <?php endif; ?>

                        <div class="<?php echo $layout === 'horizontal' ? 'flex-1 flex gap-2' : 'flex gap-2'; ?>">
                            <input
                                type="email"
                                x-model="email"
                                required
                                placeholder="<?php echo esc_attr($placeholder); ?>"
                                class="flex-1 px-6 py-4 rounded-xl border-2 <?php echo $is_dark_bg ? 'border-white/20 bg-white/10 text-white placeholder-white/50' : 'border-gray-200 bg-white text-gray-900 placeholder-gray-400'; ?> focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition-all"
                            >

                            <button
                                type="submit"
                                :disabled="loading"
                                class="px-8 py-4 rounded-xl font-semibold <?php echo $is_dark_bg ? 'bg-white text-gray-900 hover:bg-gray-100' : 'bg-primary-600 text-white hover:bg-primary-700'; ?> transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
                            >
                                <span x-show="!loading"><?php echo esc_html($button_text); ?></span>
                                <svg x-show="loading" x-cloak class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <?php if ($style === 'privacy'): ?>
                        <p class="text-center text-sm <?php echo $is_dark_bg ? 'opacity-60' : 'text-gray-500'; ?> mt-4">
                            با عضویت، با <a href="#" class="underline">قوانین حریم خصوصی</a> ما موافقت می‌کنید.
                        </p>
                    <?php endif; ?>
                </form>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
// ثبت فیلدهای ACF
add_action('acf/init', function() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key' => 'group_block_newsletter',
        'title' => 'تنظیمات خبرنامه',
        'fields' => [
            // تب محتوا
            [
                'key' => 'field_newsletter_tab_content',
                'label' => 'محتوا',
                'type' => 'tab',
            ],
            [
                'key' => 'field_newsletter_title',
                'label' => 'عنوان',
                'name' => 'title',
                'type' => 'text',
                'default_value' => 'عضو خبرنامه ما شوید',
            ],
            [
                'key' => 'field_newsletter_subtitle',
                'label' => 'زیرعنوان',
                'name' => 'subtitle',
                'type' => 'text',
            ],
            [
                'key' => 'field_newsletter_description',
                'label' => 'توضیحات',
                'name' => 'description',
                'type' => 'textarea',
                'rows' => 2,
            ],
            [
                'key' => 'field_newsletter_placeholder',
                'label' => 'متن Placeholder',
                'name' => 'placeholder',
                'type' => 'text',
                'default_value' => 'ایمیل خود را وارد کنید...',
            ],
            [
                'key' => 'field_newsletter_button',
                'label' => 'متن دکمه',
                'name' => 'button_text',
                'type' => 'text',
                'default_value' => 'عضویت',
            ],
            [
                'key' => 'field_newsletter_success',
                'label' => 'پیام موفقیت',
                'name' => 'success_message',
                'type' => 'text',
                'default_value' => 'با موفقیت عضو خبرنامه شدید!',
            ],

            // تب تنظیمات
            [
                'key' => 'field_newsletter_tab_settings',
                'label' => 'تنظیمات',
                'type' => 'tab',
            ],
            [
                'key' => 'field_newsletter_layout',
                'label' => 'چیدمان',
                'name' => 'layout',
                'type' => 'button_group',
                'choices' => [
                    'horizontal' => 'افقی',
                    'vertical' => 'عمودی',
                ],
                'default_value' => 'horizontal',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_newsletter_style',
                'label' => 'استایل',
                'name' => 'style',
                'type' => 'select',
                'choices' => [
                    'default' => 'پیش‌فرض',
                    'privacy' => 'با متن حریم خصوصی',
                ],
                'default_value' => 'default',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_newsletter_icon',
                'label' => 'نمایش آیکون',
                'name' => 'show_icon',
                'type' => 'true_false',
                'default_value' => 1,
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_newsletter_name',
                'label' => 'فیلد نام',
                'name' => 'show_name',
                'type' => 'true_false',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_newsletter_shortcode',
                'label' => 'شورتکد فرم',
                'name' => 'form_shortcode',
                'type' => 'text',
                'instructions' => 'اگر می‌خواهید از فرم MailChimp یا پلاگین دیگر استفاده کنید',
                'placeholder' => '[mc4wp_form id="123"]',
            ],

            // تب پس‌زمینه
            [
                'key' => 'field_newsletter_tab_bg',
                'label' => 'پس‌زمینه',
                'type' => 'tab',
            ],
            [
                'key' => 'field_newsletter_bg_type',
                'label' => 'نوع پس‌زمینه',
                'name' => 'bg_type',
                'type' => 'button_group',
                'choices' => [
                    'color' => 'رنگ',
                    'gradient' => 'گرادیان',
                    'image' => 'تصویر',
                ],
                'default_value' => 'color',
            ],
            [
                'key' => 'field_newsletter_bg_color',
                'label' => 'رنگ پس‌زمینه',
                'name' => 'bg_color',
                'type' => 'color_picker',
                'default_value' => '#f8fafc',
                'conditional_logic' => [
                    [['field' => 'field_newsletter_bg_type', 'operator' => '==', 'value' => 'color']],
                ],
            ],
            [
                'key' => 'field_newsletter_bg_gradient',
                'label' => 'گرادیان CSS',
                'name' => 'bg_gradient',
                'type' => 'text',
                'placeholder' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                'conditional_logic' => [
                    [['field' => 'field_newsletter_bg_type', 'operator' => '==', 'value' => 'gradient']],
                ],
            ],
            [
                'key' => 'field_newsletter_bg_image',
                'label' => 'تصویر پس‌زمینه',
                'name' => 'bg_image',
                'type' => 'image',
                'return_format' => 'array',
                'conditional_logic' => [
                    [['field' => 'field_newsletter_bg_type', 'operator' => '==', 'value' => 'image']],
                ],
            ],
            [
                'key' => 'field_newsletter_overlay',
                'label' => 'رنگ Overlay',
                'name' => 'overlay_color',
                'type' => 'text',
                'default_value' => 'rgba(0,0,0,0.5)',
                'conditional_logic' => [
                    [['field' => 'field_newsletter_bg_type', 'operator' => '==', 'value' => 'image']],
                ],
            ],
            [
                'key' => 'field_newsletter_text_color',
                'label' => 'رنگ متن',
                'name' => 'text_color',
                'type' => 'color_picker',
                'instructions' => 'اختیاری - خالی بگذارید برای تشخیص خودکار',
            ],
        ],
        'location' => [
            [['param' => 'block', 'operator' => '==', 'value' => 'acf/newsletter']],
        ],
    ]);
});
?>
