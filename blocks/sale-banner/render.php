<?php
/**
 * Sale Banner Block - بنر تخفیف/پیشنهاد ویژه
 *
 * @package Developer_Starter
 */

// محتوا
$badge = get_field('badge') ?: 'پیشنهاد ویژه';
$title = get_field('title') ?: 'تا ۵۰٪ تخفیف';
$subtitle = get_field('subtitle') ?: 'فقط تا پایان این هفته';
$description = get_field('description') ?: '';
$button_text = get_field('button_text') ?: 'مشاهده محصولات';
$button_link = get_field('button_link') ?: '#';
$button_style = get_field('button_style') ?: 'white';

// تایمر
$show_countdown = get_field('show_countdown') ?: false;
$countdown_date = get_field('countdown_date') ?: '';
$countdown_style = get_field('countdown_style') ?: 'boxes';

// پس‌زمینه
$bg_type = get_field('bg_type') ?: 'gradient';
$bg_color = get_field('bg_color') ?: '#dc2626';
$bg_gradient = get_field('bg_gradient') ?: 'linear-gradient(135deg, #dc2626 0%, #991b1b 100%)';
$bg_image = get_field('bg_image');
$overlay_color = get_field('overlay_color') ?: 'rgba(0,0,0,0.3)';
$text_color = get_field('text_color') ?: '#ffffff';

// تنظیمات نمایش
$layout = get_field('layout') ?: 'center';
$height = get_field('height') ?: 'medium';
$show_pattern = get_field('show_pattern') !== false;
$animation = get_field('animation') ?: 'fade';

// تصویر محصول
$show_product_image = get_field('show_product_image') ?: false;
$product_image = get_field('product_image');

// ارتفاع
$height_classes = [
    'small' => 'py-12 lg:py-16',
    'medium' => 'py-16 lg:py-24',
    'large' => 'py-24 lg:py-32',
    'full' => 'min-h-[70vh] py-16',
];

// تراز
$align_classes = [
    'left' => 'text-right items-end',
    'center' => 'text-center items-center',
    'right' => 'text-left items-start',
];

// دکمه
$button_classes = match($button_style) {
    'white' => 'bg-white text-gray-900 hover:bg-gray-100 shadow-lg',
    'dark' => 'bg-gray-900 text-white hover:bg-gray-800',
    'outline' => 'border-2 border-white text-white hover:bg-white hover:text-gray-900',
    'primary' => 'bg-primary-600 text-white hover:bg-primary-700',
    default => 'bg-white text-gray-900 hover:bg-gray-100'
};

$block_id = dst_block_id($block, 'sale-banner');

// تبدیل تاریخ برای JavaScript
$countdown_timestamp = $countdown_date ? strtotime($countdown_date) * 1000 : 0;
?>

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="dst-block dst-sale-banner relative overflow-hidden <?php echo esc_attr($height_classes[$height] ?? 'py-16 lg:py-24'); ?>"
    <?php if ($show_countdown && $countdown_timestamp): ?>
    x-data="{
        targetDate: <?php echo $countdown_timestamp; ?>,
        days: 0,
        hours: 0,
        minutes: 0,
        seconds: 0,
        expired: false,
        init() {
            this.updateCountdown();
            setInterval(() => this.updateCountdown(), 1000);
        },
        updateCountdown() {
            const now = Date.now();
            const diff = this.targetDate - now;

            if (diff <= 0) {
                this.expired = true;
                return;
            }

            this.days = Math.floor(diff / (1000 * 60 * 60 * 24));
            this.hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            this.minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            this.seconds = Math.floor((diff % (1000 * 60)) / 1000);
        },
        formatNumber(n) {
            return n.toString().padStart(2, '0');
        }
    }"
    <?php else: ?>
    x-data="{ shown: false }"
    x-intersect:enter="shown = true"
    <?php endif; ?>
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
    <?php elseif ($bg_type === 'gradient'): ?>
        <div class="absolute inset-0 z-0" style="background: <?php echo esc_attr($bg_gradient); ?>;"></div>
    <?php else: ?>
        <div class="absolute inset-0 z-0" style="background-color: <?php echo esc_attr($bg_color); ?>;"></div>
    <?php endif; ?>

    <?php if ($show_pattern): ?>
        <!-- پترن تزئینی -->
        <div class="absolute inset-0 z-0 opacity-10">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <defs>
                    <pattern id="sale-pattern-<?php echo esc_attr($block_id); ?>" x="0" y="0" width="10" height="10" patternUnits="userSpaceOnUse">
                        <circle cx="1" cy="1" r="1" fill="white"/>
                    </pattern>
                </defs>
                <rect fill="url(#sale-pattern-<?php echo esc_attr($block_id); ?>)" width="100" height="100"/>
            </svg>
        </div>

        <!-- دایره‌های تزئینی -->
        <div class="absolute -top-20 -right-20 w-64 h-64 rounded-full bg-white/10"></div>
        <div class="absolute -bottom-32 -left-32 w-96 h-96 rounded-full bg-white/5"></div>
    <?php endif; ?>

    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-8 lg:gap-12 <?php echo $show_product_image ? 'justify-between' : 'justify-center'; ?>">
            <!-- محتوا -->
            <div
                class="<?php echo $show_product_image ? 'lg:w-1/2' : 'max-w-3xl'; ?> <?php echo esc_attr($align_classes[$layout] ?? 'text-center items-center'); ?> flex flex-col"
                style="color: <?php echo esc_attr($text_color); ?>;"
                <?php if (!$show_countdown): ?>
                x-show="shown"
                x-transition:enter="transition ease-out duration-700"
                x-transition:enter-start="opacity-0 <?php echo $animation === 'slide' ? 'translate-y-8' : ''; ?>"
                x-transition:enter-end="opacity-100 translate-y-0"
                <?php endif; ?>
            >
                <?php if ($badge): ?>
                    <span class="inline-block px-4 py-2 rounded-full bg-white/20 text-sm font-bold mb-4 backdrop-blur-sm">
                        <?php echo esc_html($badge); ?>
                    </span>
                <?php endif; ?>

                <?php if ($title): ?>
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-black mb-4 leading-tight">
                        <?php echo wp_kses_post($title); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($subtitle): ?>
                    <p class="text-xl md:text-2xl opacity-90 mb-6">
                        <?php echo esc_html($subtitle); ?>
                    </p>
                <?php endif; ?>

                <?php if ($description): ?>
                    <p class="text-lg opacity-80 mb-8 max-w-xl <?php echo $layout === 'center' ? 'mx-auto' : ''; ?>">
                        <?php echo esc_html($description); ?>
                    </p>
                <?php endif; ?>

                <?php if ($show_countdown && $countdown_timestamp): ?>
                    <!-- شمارش معکوس -->
                    <div class="mb-8" x-show="!expired">
                        <?php if ($countdown_style === 'boxes'): ?>
                            <div class="flex gap-3 md:gap-4 <?php echo $layout === 'center' ? 'justify-center' : ($layout === 'left' ? 'justify-end' : 'justify-start'); ?>">
                                <div class="text-center">
                                    <div class="w-16 md:w-20 h-16 md:h-20 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                        <span class="text-2xl md:text-3xl font-bold" x-text="formatNumber(days)">00</span>
                                    </div>
                                    <span class="text-xs mt-2 block opacity-80">روز</span>
                                </div>
                                <div class="text-center">
                                    <div class="w-16 md:w-20 h-16 md:h-20 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                        <span class="text-2xl md:text-3xl font-bold" x-text="formatNumber(hours)">00</span>
                                    </div>
                                    <span class="text-xs mt-2 block opacity-80">ساعت</span>
                                </div>
                                <div class="text-center">
                                    <div class="w-16 md:w-20 h-16 md:h-20 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                        <span class="text-2xl md:text-3xl font-bold" x-text="formatNumber(minutes)">00</span>
                                    </div>
                                    <span class="text-xs mt-2 block opacity-80">دقیقه</span>
                                </div>
                                <div class="text-center">
                                    <div class="w-16 md:w-20 h-16 md:h-20 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                        <span class="text-2xl md:text-3xl font-bold" x-text="formatNumber(seconds)">00</span>
                                    </div>
                                    <span class="text-xs mt-2 block opacity-80">ثانیه</span>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="text-3xl md:text-4xl font-bold tracking-wider">
                                <span x-text="formatNumber(days)">00</span>:<span x-text="formatNumber(hours)">00</span>:<span x-text="formatNumber(minutes)">00</span>:<span x-text="formatNumber(seconds)">00</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div x-show="expired" x-cloak class="mb-8 text-xl font-semibold">
                        این پیشنهاد به پایان رسیده است
                    </div>
                <?php endif; ?>

                <?php if ($button_text && $button_link): ?>
                    <a
                        href="<?php echo esc_url($button_link); ?>"
                        class="inline-flex items-center gap-2 px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 <?php echo esc_attr($button_classes); ?>"
                    >
                        <?php echo esc_html($button_text); ?>
                        <svg class="w-5 h-5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>

            <?php if ($show_product_image && $product_image): ?>
                <!-- تصویر محصول -->
                <div
                    class="lg:w-1/2 relative"
                    <?php if (!$show_countdown): ?>
                    x-show="shown"
                    x-transition:enter="transition ease-out duration-700 delay-300"
                    x-transition:enter-start="opacity-0 scale-90"
                    x-transition:enter-end="opacity-100 scale-100"
                    <?php endif; ?>
                >
                    <div class="relative">
                        <!-- گلو پشت تصویر -->
                        <div class="absolute inset-0 bg-white/20 rounded-full blur-3xl scale-75"></div>
                        <img
                            src="<?php echo esc_url($product_image['url']); ?>"
                            alt=""
                            class="relative z-10 max-w-full h-auto mx-auto drop-shadow-2xl animate-float"
                        >
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-15px); }
}
.animate-float {
    animation: float 4s ease-in-out infinite;
}
</style>

<?php
// ثبت فیلدهای ACF
add_action('acf/init', function() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key' => 'group_block_sale_banner',
        'title' => 'تنظیمات بنر تخفیف',
        'fields' => [
            // تب محتوا
            [
                'key' => 'field_sale_tab_content',
                'label' => 'محتوا',
                'type' => 'tab',
            ],
            [
                'key' => 'field_sale_badge',
                'label' => 'نشان',
                'name' => 'badge',
                'type' => 'text',
                'default_value' => 'پیشنهاد ویژه',
                'placeholder' => 'مثلاً: فقط امروز',
            ],
            [
                'key' => 'field_sale_title',
                'label' => 'عنوان',
                'name' => 'title',
                'type' => 'text',
                'default_value' => 'تا ۵۰٪ تخفیف',
                'instructions' => 'می‌توانید از تگ‌های HTML ساده استفاده کنید',
            ],
            [
                'key' => 'field_sale_subtitle',
                'label' => 'زیرعنوان',
                'name' => 'subtitle',
                'type' => 'text',
            ],
            [
                'key' => 'field_sale_description',
                'label' => 'توضیحات',
                'name' => 'description',
                'type' => 'textarea',
                'rows' => 2,
            ],
            [
                'key' => 'field_sale_button_text',
                'label' => 'متن دکمه',
                'name' => 'button_text',
                'type' => 'text',
                'default_value' => 'مشاهده محصولات',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_sale_button_link',
                'label' => 'لینک دکمه',
                'name' => 'button_link',
                'type' => 'url',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_sale_button_style',
                'label' => 'استایل دکمه',
                'name' => 'button_style',
                'type' => 'select',
                'choices' => [
                    'white' => 'سفید',
                    'dark' => 'تیره',
                    'outline' => 'حاشیه‌دار',
                    'primary' => 'اصلی',
                ],
                'default_value' => 'white',
            ],

            // تب شمارش معکوس
            [
                'key' => 'field_sale_tab_countdown',
                'label' => 'شمارش معکوس',
                'type' => 'tab',
            ],
            [
                'key' => 'field_sale_countdown',
                'label' => 'نمایش شمارش معکوس',
                'name' => 'show_countdown',
                'type' => 'true_false',
            ],
            [
                'key' => 'field_sale_countdown_date',
                'label' => 'تاریخ پایان',
                'name' => 'countdown_date',
                'type' => 'date_time_picker',
                'display_format' => 'Y/m/d H:i',
                'return_format' => 'Y-m-d H:i:s',
                'conditional_logic' => [
                    [['field' => 'field_sale_countdown', 'operator' => '==', 'value' => '1']],
                ],
            ],
            [
                'key' => 'field_sale_countdown_style',
                'label' => 'استایل تایمر',
                'name' => 'countdown_style',
                'type' => 'button_group',
                'choices' => [
                    'boxes' => 'جعبه‌ای',
                    'inline' => 'خطی',
                ],
                'default_value' => 'boxes',
                'conditional_logic' => [
                    [['field' => 'field_sale_countdown', 'operator' => '==', 'value' => '1']],
                ],
            ],

            // تب پس‌زمینه
            [
                'key' => 'field_sale_tab_bg',
                'label' => 'پس‌زمینه',
                'type' => 'tab',
            ],
            [
                'key' => 'field_sale_bg_type',
                'label' => 'نوع پس‌زمینه',
                'name' => 'bg_type',
                'type' => 'button_group',
                'choices' => [
                    'color' => 'رنگ',
                    'gradient' => 'گرادیان',
                    'image' => 'تصویر',
                ],
                'default_value' => 'gradient',
            ],
            [
                'key' => 'field_sale_bg_color',
                'label' => 'رنگ پس‌زمینه',
                'name' => 'bg_color',
                'type' => 'color_picker',
                'default_value' => '#dc2626',
                'conditional_logic' => [
                    [['field' => 'field_sale_bg_type', 'operator' => '==', 'value' => 'color']],
                ],
            ],
            [
                'key' => 'field_sale_bg_gradient',
                'label' => 'گرادیان CSS',
                'name' => 'bg_gradient',
                'type' => 'text',
                'default_value' => 'linear-gradient(135deg, #dc2626 0%, #991b1b 100%)',
                'conditional_logic' => [
                    [['field' => 'field_sale_bg_type', 'operator' => '==', 'value' => 'gradient']],
                ],
            ],
            [
                'key' => 'field_sale_bg_image',
                'label' => 'تصویر پس‌زمینه',
                'name' => 'bg_image',
                'type' => 'image',
                'return_format' => 'array',
                'conditional_logic' => [
                    [['field' => 'field_sale_bg_type', 'operator' => '==', 'value' => 'image']],
                ],
            ],
            [
                'key' => 'field_sale_overlay',
                'label' => 'رنگ Overlay',
                'name' => 'overlay_color',
                'type' => 'text',
                'default_value' => 'rgba(0,0,0,0.3)',
                'conditional_logic' => [
                    [['field' => 'field_sale_bg_type', 'operator' => '==', 'value' => 'image']],
                ],
            ],
            [
                'key' => 'field_sale_text_color',
                'label' => 'رنگ متن',
                'name' => 'text_color',
                'type' => 'color_picker',
                'default_value' => '#ffffff',
            ],

            // تب نمایش
            [
                'key' => 'field_sale_tab_display',
                'label' => 'تنظیمات نمایش',
                'type' => 'tab',
            ],
            [
                'key' => 'field_sale_layout',
                'label' => 'تراز محتوا',
                'name' => 'layout',
                'type' => 'button_group',
                'choices' => [
                    'left' => 'راست',
                    'center' => 'وسط',
                    'right' => 'چپ',
                ],
                'default_value' => 'center',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_sale_height',
                'label' => 'ارتفاع',
                'name' => 'height',
                'type' => 'select',
                'choices' => [
                    'small' => 'کوچک',
                    'medium' => 'متوسط',
                    'large' => 'بزرگ',
                    'full' => 'تمام صفحه',
                ],
                'default_value' => 'medium',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_sale_pattern',
                'label' => 'نمایش پترن',
                'name' => 'show_pattern',
                'type' => 'true_false',
                'default_value' => 1,
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_sale_animation',
                'label' => 'انیمیشن',
                'name' => 'animation',
                'type' => 'select',
                'choices' => [
                    'fade' => 'محو شدن',
                    'slide' => 'اسلاید',
                ],
                'default_value' => 'fade',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_sale_product_image',
                'label' => 'نمایش تصویر محصول',
                'name' => 'show_product_image',
                'type' => 'true_false',
            ],
            [
                'key' => 'field_sale_product_img',
                'label' => 'تصویر محصول',
                'name' => 'product_image',
                'type' => 'image',
                'return_format' => 'array',
                'conditional_logic' => [
                    [['field' => 'field_sale_product_image', 'operator' => '==', 'value' => '1']],
                ],
            ],
        ],
        'location' => [
            [['param' => 'block', 'operator' => '==', 'value' => 'acf/sale-banner']],
        ],
    ]);
});
?>
