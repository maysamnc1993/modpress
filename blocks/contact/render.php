<?php
/**
 * Contact Info Block
 *
 * @package Developer_Starter
 */

// فیلدها
$title = get_field('title') ?: '';
$subtitle = get_field('subtitle') ?: '';
$layout = get_field('layout') ?: 'with-form';
$bg_color = get_field('bg_color') ?: '#ffffff';

// اطلاعات تماس
$phone = get_field('phone') ?: (function_exists('dst_get_setting') ? dst_get_setting('phone') : '');
$email = get_field('email') ?: (function_exists('dst_get_setting') ? dst_get_setting('email') : '');
$address = get_field('address') ?: (function_exists('dst_get_setting') ? dst_get_setting('address') : '');
$working_hours = get_field('working_hours') ?: '';

// نقشه
$show_map = get_field('show_map') ?: false;
$map_embed = get_field('map_embed') ?: '';
$map_lat = get_field('map_lat') ?: '';
$map_lng = get_field('map_lng') ?: '';

// فرم
$show_form = get_field('show_form') ?: true;
$form_shortcode = get_field('form_shortcode') ?: '';

// شبکه‌های اجتماعی
$show_social = get_field('show_social') ?: true;

$block_id = dst_block_id($block, 'contact');
?>

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="dst-block dst-contact py-16 lg:py-24"
    style="background-color: <?php echo esc_attr($bg_color); ?>;"
>
    <div class="container mx-auto px-4">
        <?php if ($title || $subtitle): ?>
            <div class="text-center max-w-3xl mx-auto mb-12">
                <?php if ($subtitle): ?>
                    <p class="text-primary-600 font-semibold mb-2"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>
                <?php if ($title): ?>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="grid gap-12 <?php echo ($show_form || $show_map) ? 'lg:grid-cols-2' : ''; ?>">
            <!-- اطلاعات تماس -->
            <div>
                <div class="space-y-6">
                    <?php if ($phone): ?>
                        <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                            <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-primary-100 text-primary-600 flex items-center justify-center">
                                <?php echo dst_icon('phone', 'w-6 h-6'); ?>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">تلفن</h4>
                                <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>" class="text-gray-600 hover:text-primary-600 transition-colors" dir="ltr">
                                    <?php echo esc_html($phone); ?>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($email): ?>
                        <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                            <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-primary-100 text-primary-600 flex items-center justify-center">
                                <?php echo dst_icon('email', 'w-6 h-6'); ?>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">ایمیل</h4>
                                <a href="mailto:<?php echo esc_attr($email); ?>" class="text-gray-600 hover:text-primary-600 transition-colors">
                                    <?php echo esc_html($email); ?>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($address): ?>
                        <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                            <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-primary-100 text-primary-600 flex items-center justify-center">
                                <?php echo dst_icon('location', 'w-6 h-6'); ?>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">آدرس</h4>
                                <p class="text-gray-600"><?php echo esc_html($address); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($working_hours): ?>
                        <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                            <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-primary-100 text-primary-600 flex items-center justify-center">
                                <?php echo dst_icon('clock', 'w-6 h-6'); ?>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">ساعات کاری</h4>
                                <p class="text-gray-600"><?php echo esc_html($working_hours); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($show_social): ?>
                    <?php
                    $socials = [];
                    if (function_exists('dst_get_socials')) {
                        $socials = dst_get_socials();
                    }
                    if (!empty($socials)):
                    ?>
                        <div class="mt-8 pt-8 border-t border-gray-200">
                            <h4 class="font-semibold text-gray-900 mb-4">ما را در شبکه‌های اجتماعی دنبال کنید</h4>
                            <div class="flex gap-3">
                                <?php foreach ($socials as $social => $url): ?>
                                    <a
                                        href="<?php echo esc_url($url); ?>"
                                        target="_blank"
                                        rel="noopener"
                                        class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-primary-600 hover:text-white transition-colors"
                                    >
                                        <?php
                                        $social_icons = [
                                            'instagram' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>',
                                            'telegram' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>',
                                            'whatsapp' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>',
                                            'twitter' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
                                            'linkedin' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>',
                                            'youtube' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
                                        ];
                                        echo $social_icons[$social] ?? '';
                                        ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <!-- فرم یا نقشه -->
            <?php if ($show_form || $show_map): ?>
                <div>
                    <?php if ($show_form): ?>
                        <div class="bg-gray-50 rounded-2xl p-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6">ارسال پیام</h3>

                            <?php if ($form_shortcode): ?>
                                <?php echo do_shortcode($form_shortcode); ?>
                            <?php else: ?>
                                <!-- فرم ساده -->
                                <form
                                    class="space-y-4"
                                    x-data="{ sending: false, sent: false }"
                                    @submit.prevent="sending = true; setTimeout(() => { sending = false; sent = true; }, 2000)"
                                >
                                    <div class="grid md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">نام</label>
                                            <input
                                                type="text"
                                                required
                                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition-all"
                                                placeholder="نام شما"
                                            >
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">ایمیل</label>
                                            <input
                                                type="email"
                                                required
                                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition-all"
                                                placeholder="ایمیل شما"
                                            >
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">موضوع</label>
                                        <input
                                            type="text"
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition-all"
                                            placeholder="موضوع پیام"
                                        >
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">پیام</label>
                                        <textarea
                                            rows="4"
                                            required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition-all resize-none"
                                            placeholder="متن پیام شما..."
                                        ></textarea>
                                    </div>

                                    <button
                                        type="submit"
                                        :disabled="sending"
                                        class="w-full py-4 px-6 bg-primary-600 text-white rounded-lg font-semibold hover:bg-primary-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                                    >
                                        <span x-show="!sending && !sent">ارسال پیام</span>
                                        <span x-show="sending" x-cloak>در حال ارسال...</span>
                                        <span x-show="sent" x-cloak class="text-green-200">پیام ارسال شد!</span>
                                        <svg x-show="!sending && !sent" class="w-5 h-5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($show_map && ($map_embed || ($map_lat && $map_lng))): ?>
                        <div class="<?php echo $show_form ? 'mt-8' : ''; ?> rounded-2xl overflow-hidden h-[400px]">
                            <?php if ($map_embed): ?>
                                <?php echo $map_embed; ?>
                            <?php else: ?>
                                <iframe
                                    src="https://maps.google.com/maps?q=<?php echo esc_attr($map_lat); ?>,<?php echo esc_attr($map_lng); ?>&z=15&output=embed"
                                    width="100%"
                                    height="100%"
                                    style="border:0;"
                                    loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"
                                ></iframe>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
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
        'key' => 'group_block_contact',
        'title' => 'تنظیمات تماس',
        'fields' => [
            [
                'key' => 'field_contact_title',
                'label' => 'عنوان',
                'name' => 'title',
                'type' => 'text',
            ],
            [
                'key' => 'field_contact_subtitle',
                'label' => 'زیرعنوان',
                'name' => 'subtitle',
                'type' => 'text',
            ],
            [
                'key' => 'field_contact_phone',
                'label' => 'تلفن',
                'name' => 'phone',
                'type' => 'text',
                'instructions' => 'اگر خالی باشد از تنظیمات قالب خوانده می‌شود',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_contact_email',
                'label' => 'ایمیل',
                'name' => 'email',
                'type' => 'email',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_contact_address',
                'label' => 'آدرس',
                'name' => 'address',
                'type' => 'textarea',
                'rows' => 2,
            ],
            [
                'key' => 'field_contact_hours',
                'label' => 'ساعات کاری',
                'name' => 'working_hours',
                'type' => 'text',
                'placeholder' => 'شنبه تا پنجشنبه ۹ صبح تا ۶ عصر',
            ],
            [
                'key' => 'field_contact_social',
                'label' => 'نمایش شبکه‌های اجتماعی',
                'name' => 'show_social',
                'type' => 'true_false',
                'default_value' => 1,
            ],
            [
                'key' => 'field_contact_form',
                'label' => 'نمایش فرم',
                'name' => 'show_form',
                'type' => 'true_false',
                'default_value' => 1,
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_contact_form_shortcode',
                'label' => 'شورتکد فرم',
                'name' => 'form_shortcode',
                'type' => 'text',
                'instructions' => 'شورتکد Contact Form 7 یا WPForms',
                'placeholder' => '[contact-form-7 id="123"]',
                'conditional_logic' => [
                    [['field' => 'field_contact_form', 'operator' => '==', 'value' => '1']],
                ],
            ],
            [
                'key' => 'field_contact_map',
                'label' => 'نمایش نقشه',
                'name' => 'show_map',
                'type' => 'true_false',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_contact_map_embed',
                'label' => 'کد Embed نقشه',
                'name' => 'map_embed',
                'type' => 'textarea',
                'rows' => 3,
                'conditional_logic' => [
                    [['field' => 'field_contact_map', 'operator' => '==', 'value' => '1']],
                ],
            ],
            [
                'key' => 'field_contact_map_lat',
                'label' => 'عرض جغرافیایی',
                'name' => 'map_lat',
                'type' => 'text',
                'placeholder' => '35.6892',
                'wrapper' => ['width' => '50'],
                'conditional_logic' => [
                    [['field' => 'field_contact_map', 'operator' => '==', 'value' => '1']],
                ],
            ],
            [
                'key' => 'field_contact_map_lng',
                'label' => 'طول جغرافیایی',
                'name' => 'map_lng',
                'type' => 'text',
                'placeholder' => '51.3890',
                'wrapper' => ['width' => '50'],
                'conditional_logic' => [
                    [['field' => 'field_contact_map', 'operator' => '==', 'value' => '1']],
                ],
            ],
            [
                'key' => 'field_contact_bg',
                'label' => 'رنگ پس‌زمینه',
                'name' => 'bg_color',
                'type' => 'color_picker',
                'default_value' => '#ffffff',
            ],
        ],
        'location' => [
            [['param' => 'block', 'operator' => '==', 'value' => 'acf/contact']],
        ],
    ]);
});
?>
