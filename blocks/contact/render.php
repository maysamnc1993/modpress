<?php
/**
 * Contact Block - تماس با ما
 */

$title = get_field('title') ?: 'تماس با ما';
$subtitle = get_field('subtitle') ?: '';
$description = get_field('description') ?: '';
$style = get_field('style') ?: 'split';
$show_map = get_field('show_map') !== false;
$map_embed = get_field('map_embed') ?: '';
$bg_color = get_field('bg_color') ?: '#f8fafc';

// اطلاعات تماس
$phone = get_field('phone') ?: '';
$email = get_field('email') ?: '';
$address = get_field('address') ?: '';
$working_hours = get_field('working_hours') ?: '';
$social_links = get_field('social_links') ?: [];

// تنظیمات فرم
$form_title = get_field('form_title') ?: 'پیام خود را بفرستید';
$form_shortcode = get_field('form_shortcode') ?: '';
$show_builtin_form = get_field('show_builtin_form') !== false;

$block_id = dst_block_id($block, 'contact');
?>

<section id="<?php echo esc_attr($block_id); ?>" class="dst-block dst-contact py-16 lg:py-24" style="background-color: <?php echo esc_attr($bg_color); ?>;">
    <div class="container mx-auto px-4">
        <!-- عنوان -->
        <?php if ($title || $subtitle || $description): ?>
            <div class="text-center mb-12 max-w-3xl mx-auto">
                <?php if ($subtitle): ?><p class="text-primary-600 font-semibold mb-2"><?php echo esc_html($subtitle); ?></p><?php endif; ?>
                <?php if ($title): ?><h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4"><?php echo esc_html($title); ?></h2><?php endif; ?>
                <?php if ($description): ?><p class="text-gray-600 text-lg"><?php echo esc_html($description); ?></p><?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($style === 'split'): ?>
            <!-- استایل تقسیم شده -->
            <div class="grid lg:grid-cols-2 gap-12">
                <!-- اطلاعات تماس -->
                <div x-data="{ shown: false }" x-intersect:enter="shown = true">
                    <div x-show="shown" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 -translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">اطلاعات تماس</h3>

                        <div class="space-y-6">
                            <?php if ($phone): ?>
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-primary-100 text-primary-600 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 mb-1">تلفن</h4>
                                        <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>" class="text-gray-600 hover:text-primary-600 transition-colors" dir="ltr"><?php echo esc_html($phone); ?></a>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($email): ?>
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-primary-100 text-primary-600 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 mb-1">ایمیل</h4>
                                        <a href="mailto:<?php echo esc_attr($email); ?>" class="text-gray-600 hover:text-primary-600 transition-colors"><?php echo esc_html($email); ?></a>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($address): ?>
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-primary-100 text-primary-600 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 mb-1">آدرس</h4>
                                        <p class="text-gray-600"><?php echo esc_html($address); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($working_hours): ?>
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-primary-100 text-primary-600 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 mb-1">ساعات کاری</h4>
                                        <p class="text-gray-600"><?php echo nl2br(esc_html($working_hours)); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- شبکه‌های اجتماعی -->
                        <?php if ($social_links): ?>
                            <div class="mt-8 pt-8 border-t border-gray-200">
                                <h4 class="font-semibold text-gray-900 mb-4">ما را دنبال کنید</h4>
                                <div class="flex gap-3">
                                    <?php foreach ($social_links as $social): ?>
                                        <a href="<?php echo esc_url($social['url']); ?>" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-primary-600 hover:text-white transition-colors">
                                            <?php echo dst_get_social_icon($social['network']); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- نقشه -->
                        <?php if ($show_map && $map_embed): ?>
                            <div class="mt-8 rounded-xl overflow-hidden h-64">
                                <?php echo $map_embed; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- فرم تماس -->
                <div x-data="{ shown: false }" x-intersect:enter="shown = true">
                    <div x-show="shown" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                        <div class="bg-white rounded-2xl shadow-xl p-8">
                            <?php if ($form_title): ?>
                                <h3 class="text-2xl font-bold text-gray-900 mb-6"><?php echo esc_html($form_title); ?></h3>
                            <?php endif; ?>

                            <?php if ($form_shortcode): ?>
                                <?php echo do_shortcode($form_shortcode); ?>
                            <?php elseif ($show_builtin_form): ?>
                                <form class="space-y-6" x-data="{ sending: false, sent: false }" @submit.prevent="sending = true; setTimeout(() => { sending = false; sent = true; }, 2000)">
                                    <div class="grid sm:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">نام و نام خانوادگی</label>
                                            <input type="text" name="name" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">شماره تماس</label>
                                            <input type="tel" name="phone" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors" dir="ltr">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">ایمیل</label>
                                        <input type="email" name="email" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors" dir="ltr">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">موضوع</label>
                                        <input type="text" name="subject" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">پیام</label>
                                        <textarea name="message" rows="5" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors resize-none"></textarea>
                                    </div>
                                    <button type="submit" :disabled="sending" class="w-full py-4 bg-primary-600 text-white rounded-lg font-semibold hover:bg-primary-700 transition-colors disabled:opacity-50 flex items-center justify-center gap-2">
                                        <span x-show="!sending && !sent">ارسال پیام</span>
                                        <span x-show="sending" x-cloak>در حال ارسال...</span>
                                        <span x-show="sent" x-cloak class="text-green-100">✓ پیام شما ارسال شد</span>
                                        <svg x-show="!sending && !sent" class="w-5 h-5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        <?php elseif ($style === 'cards'): ?>
            <!-- استایل کارت‌ها -->
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <?php if ($phone): ?>
                    <div class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition-shadow">
                        <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-2">تلفن</h4>
                        <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>" class="text-gray-600 hover:text-primary-600 transition-colors" dir="ltr"><?php echo esc_html($phone); ?></a>
                    </div>
                <?php endif; ?>

                <?php if ($email): ?>
                    <div class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition-shadow">
                        <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-2">ایمیل</h4>
                        <a href="mailto:<?php echo esc_attr($email); ?>" class="text-gray-600 hover:text-primary-600 transition-colors"><?php echo esc_html($email); ?></a>
                    </div>
                <?php endif; ?>

                <?php if ($address): ?>
                    <div class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition-shadow">
                        <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-2">آدرس</h4>
                        <p class="text-gray-600 text-sm"><?php echo esc_html($address); ?></p>
                    </div>
                <?php endif; ?>

                <?php if ($working_hours): ?>
                    <div class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition-shadow">
                        <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-2">ساعات کاری</h4>
                        <p class="text-gray-600 text-sm"><?php echo nl2br(esc_html($working_hours)); ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- فرم و نقشه -->
            <div class="grid lg:grid-cols-2 gap-12">
                <?php if ($show_map && $map_embed): ?>
                    <div class="rounded-2xl overflow-hidden h-96 shadow-xl">
                        <?php echo $map_embed; ?>
                    </div>
                <?php endif; ?>

                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <?php if ($form_title): ?>
                        <h3 class="text-2xl font-bold text-gray-900 mb-6"><?php echo esc_html($form_title); ?></h3>
                    <?php endif; ?>

                    <?php if ($form_shortcode): ?>
                        <?php echo do_shortcode($form_shortcode); ?>
                    <?php elseif ($show_builtin_form): ?>
                        <form class="space-y-4">
                            <input type="text" name="name" placeholder="نام و نام خانوادگی" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors">
                            <input type="email" name="email" placeholder="ایمیل" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors" dir="ltr">
                            <textarea name="message" rows="4" placeholder="پیام شما" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors resize-none"></textarea>
                            <button type="submit" class="w-full py-4 bg-primary-600 text-white rounded-lg font-semibold hover:bg-primary-700 transition-colors">ارسال پیام</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

        <?php else: ?>
            <!-- استایل ساده -->
            <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-xl p-8">
                <?php if ($form_title): ?>
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center"><?php echo esc_html($form_title); ?></h3>
                <?php endif; ?>

                <?php if ($form_shortcode): ?>
                    <?php echo do_shortcode($form_shortcode); ?>
                <?php elseif ($show_builtin_form): ?>
                    <form class="space-y-6">
                        <div class="grid sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">نام</label>
                                <input type="text" name="name" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">ایمیل</label>
                                <input type="email" name="email" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors" dir="ltr">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">پیام</label>
                            <textarea name="message" rows="5" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors resize-none"></textarea>
                        </div>
                        <button type="submit" class="w-full py-4 bg-primary-600 text-white rounded-lg font-semibold hover:bg-primary-700 transition-colors">ارسال پیام</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
add_action('acf/init', function() {
    if (!function_exists('acf_add_local_field_group')) return;
    acf_add_local_field_group([
        'key' => 'group_block_contact', 'title' => 'تنظیمات تماس با ما',
        'fields' => [
            ['key' => 'field_contact_title', 'label' => 'عنوان', 'name' => 'title', 'type' => 'text', 'default_value' => 'تماس با ما'],
            ['key' => 'field_contact_subtitle', 'label' => 'زیرعنوان', 'name' => 'subtitle', 'type' => 'text'],
            ['key' => 'field_contact_desc', 'label' => 'توضیحات', 'name' => 'description', 'type' => 'textarea', 'rows' => 2],
            ['key' => 'field_contact_style', 'label' => 'استایل', 'name' => 'style', 'type' => 'button_group', 'choices' => ['split' => 'تقسیم شده', 'cards' => 'کارت‌ها', 'simple' => 'ساده'], 'default_value' => 'split'],
            ['key' => 'field_contact_tab_info', 'label' => 'اطلاعات تماس', 'name' => '', 'type' => 'tab'],
            ['key' => 'field_contact_phone', 'label' => 'تلفن', 'name' => 'phone', 'type' => 'text', 'wrapper' => ['width' => '50']],
            ['key' => 'field_contact_email', 'label' => 'ایمیل', 'name' => 'email', 'type' => 'email', 'wrapper' => ['width' => '50']],
            ['key' => 'field_contact_address', 'label' => 'آدرس', 'name' => 'address', 'type' => 'textarea', 'rows' => 2],
            ['key' => 'field_contact_hours', 'label' => 'ساعات کاری', 'name' => 'working_hours', 'type' => 'textarea', 'rows' => 2],
            ['key' => 'field_contact_social', 'label' => 'شبکه‌های اجتماعی', 'name' => 'social_links', 'type' => 'repeater', 'layout' => 'table', 'button_label' => 'افزودن', 'sub_fields' => [
                ['key' => 'field_contact_social_network', 'label' => 'شبکه', 'name' => 'network', 'type' => 'select', 'choices' => ['instagram' => 'اینستاگرام', 'telegram' => 'تلگرام', 'twitter' => 'توییتر', 'linkedin' => 'لینکدین', 'whatsapp' => 'واتساپ', 'facebook' => 'فیسبوک', 'youtube' => 'یوتیوب']],
                ['key' => 'field_contact_social_url', 'label' => 'لینک', 'name' => 'url', 'type' => 'url'],
            ]],
            ['key' => 'field_contact_tab_map', 'label' => 'نقشه', 'name' => '', 'type' => 'tab'],
            ['key' => 'field_contact_show_map', 'label' => 'نمایش نقشه', 'name' => 'show_map', 'type' => 'true_false', 'default_value' => 1, 'ui' => 1],
            ['key' => 'field_contact_map_embed', 'label' => 'کد امبد نقشه', 'name' => 'map_embed', 'type' => 'textarea', 'rows' => 3, 'instructions' => 'کد iframe نقشه گوگل یا نشان را اینجا قرار دهید', 'conditional_logic' => [[['field' => 'field_contact_show_map', 'operator' => '==', 'value' => 1]]]],
            ['key' => 'field_contact_tab_form', 'label' => 'فرم', 'name' => '', 'type' => 'tab'],
            ['key' => 'field_contact_form_title', 'label' => 'عنوان فرم', 'name' => 'form_title', 'type' => 'text', 'default_value' => 'پیام خود را بفرستید'],
            ['key' => 'field_contact_form_shortcode', 'label' => 'شورت‌کد فرم', 'name' => 'form_shortcode', 'type' => 'text', 'instructions' => 'شورت‌کد Contact Form 7 یا فرم ساز دیگر'],
            ['key' => 'field_contact_builtin_form', 'label' => 'استفاده از فرم داخلی', 'name' => 'show_builtin_form', 'type' => 'true_false', 'default_value' => 1, 'ui' => 1, 'instructions' => 'در صورت خالی بودن شورت‌کد'],
            ['key' => 'field_contact_tab_style', 'label' => 'ظاهر', 'name' => '', 'type' => 'tab'],
            ['key' => 'field_contact_bg', 'label' => 'رنگ پس‌زمینه', 'name' => 'bg_color', 'type' => 'color_picker', 'default_value' => '#f8fafc'],
        ],
        'location' => [[['param' => 'block', 'operator' => '==', 'value' => 'acf/contact']]],
    ]);
});
?>
