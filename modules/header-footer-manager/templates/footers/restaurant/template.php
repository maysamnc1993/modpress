<?php
/**
 * Footer Template: Restaurant
 * فوتر رستوران با ساعات کاری، موقعیت و رزرو
 */

defined('ABSPATH') || exit;

$settings = dst_get_footer_setting();
$bg_color = $settings['bg_color'] ?? '#1c1917';
$text_color = $settings['text_color'] ?? '#fafaf9';
$link_color = $settings['link_color'] ?? '#d6d3d1';
$link_hover_color = $settings['link_hover_color'] ?? '#fbbf24';
$show_logo = $settings['show_logo'] ?? true;
$show_description = $settings['show_description'] ?? true;
$description_text = $settings['description_text'] ?? 'تجربه‌ای منحصر به فرد از طعم‌های اصیل و محیطی دلنشین. ما افتخار می‌کنیم که بهترین غذاها را با مواد اولیه تازه به شما ارائه دهیم.';
$show_social = $settings['show_social'] ?? true;
$show_newsletter = $settings['show_newsletter'] ?? false;
$newsletter_title = $settings['newsletter_title'] ?? 'پیشنهادات ویژه';
$newsletter_text = $settings['newsletter_text'] ?? 'تخفیف‌ها و منوهای ویژه را دریافت کنید';
$show_contact = $settings['show_contact'] ?? true;
$columns = $settings['columns'] ?? '4';
$show_menu1 = $settings['show_menu1'] ?? true;
$menu1_title = $settings['menu1_title'] ?? 'لینک‌های مفید';
$show_menu2 = $settings['show_menu2'] ?? false;
$menu2_title = $settings['menu2_title'] ?? 'خدمات';
$show_copyright = $settings['show_copyright'] ?? true;
$copyright_text = $settings['copyright_text'] ?? 'تمامی حقوق محفوظ است';
$show_payment_icons = $settings['show_payment_icons'] ?? true;
$show_back_to_top = $settings['show_back_to_top'] ?? true;
$show_hours = $settings['show_hours'] ?? true;
$hours_title = $settings['hours_title'] ?? 'ساعات کاری';
$show_location = $settings['show_location'] ?? true;
$location_title = $settings['location_title'] ?? 'آدرس ما';
$show_reservation = $settings['show_reservation'] ?? true;
$reservation_text = $settings['reservation_text'] ?? 'رزرو میز';
$reservation_url = $settings['reservation_url'] ?? '/reservation';
$show_menu_highlights = $settings['show_menu_highlights'] ?? true;
$menu_highlights_title = $settings['menu_highlights_title'] ?? 'غذاهای ویژه';
$show_instagram = $settings['show_instagram'] ?? true;
$instagram_title = $settings['instagram_title'] ?? 'ما را در اینستاگرام دنبال کنید';
$accent_color = $settings['accent_color'] ?? '#fbbf24';
?>

<footer
    class="hf-footer hf-footer-restaurant relative"
    style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;"
    dir="rtl"
>
    <style>
        .hf-footer-restaurant a {
            color: <?php echo esc_attr($link_color); ?>;
            transition: color 0.3s ease;
        }
        .hf-footer-restaurant a:hover {
            color: <?php echo esc_attr($link_hover_color); ?>;
        }
        .hf-accent-color {
            color: <?php echo esc_attr($accent_color); ?>;
        }
        .hf-accent-bg {
            background-color: <?php echo esc_attr($accent_color); ?>;
        }
        .hf-accent-border {
            border-color: <?php echo esc_attr($accent_color); ?>;
        }
    </style>

    <!-- Reservation CTA Bar -->
    <?php if ($show_reservation): ?>
        <div class="border-b border-white/10 hf-accent-bg">
            <div class="hf-container py-8">
                <div class="max-w-4xl mx-auto text-center">
                    <h2 class="text-3xl font-bold text-gray-900 mb-3">میز خود را همین الان رزرو کنید</h2>
                    <p class="text-gray-800 mb-6">برای اطمینان از داشتن میز در زمان مورد نظرتان، از قبل رزرو کنید</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a
                            href="<?php echo esc_url($reservation_url); ?>"
                            class="inline-flex items-center justify-center px-8 py-4 bg-gray-900 text-white font-bold rounded-lg hover:bg-gray-800 transition-all transform hover:scale-105"
                        >
                            <svg class="w-5 h-5 ml-2 rtl:mr-2 rtl:ml-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <?php echo esc_html($reservation_text); ?>
                        </a>
                        <?php if (dst_get_contact('phone')): ?>
                            <a
                                href="tel:<?php echo esc_attr(dst_get_contact('phone')); ?>"
                                class="inline-flex items-center justify-center px-8 py-4 bg-white/20 text-gray-900 font-bold rounded-lg hover:bg-white/30 transition-all backdrop-blur-sm"
                            >
                                <svg class="w-5 h-5 ml-2 rtl:mr-2 rtl:ml-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                تماس تلفنی
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Instagram Feed -->
    <?php if ($show_instagram): ?>
        <div class="border-b border-white/10">
            <div class="hf-container py-12">
                <h3 class="text-2xl font-bold text-center mb-8 hf-accent-color">
                    <?php echo esc_html($instagram_title); ?>
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-3">
                    <?php for ($i = 1; $i <= 6; $i++): ?>
                        <a href="#" class="aspect-square bg-stone-800 rounded-lg overflow-hidden group relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-amber-400/20 to-amber-600/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </div>
                            <div class="w-full h-full bg-gradient-to-br from-stone-700 to-stone-800"></div>
                        </a>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Footer Content -->
    <div class="hf-container py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-<?php echo esc_attr($columns); ?> gap-8 lg:gap-12">

            <!-- About Column -->
            <div>
                <?php if ($show_logo): ?>
                    <div class="mb-6">
                        <?php dst_the_logo('light', 'h-16 w-auto'); ?>
                    </div>
                <?php endif; ?>

                <?php if ($show_description): ?>
                    <p class="mb-6 text-sm leading-relaxed opacity-90">
                        <?php echo esc_html($description_text); ?>
                    </p>
                <?php endif; ?>

                <?php if ($show_social): ?>
                    <div class="flex gap-3">
                        <?php
                        $social_networks = ['instagram', 'telegram', 'whatsapp', 'twitter'];
                        foreach ($social_networks as $network):
                            $url = dst_get_social($network);
                            if (!$url) continue;
                        ?>
                            <a
                                href="<?php echo esc_url($url); ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="w-10 h-10 flex items-center justify-center rounded-lg bg-white/10 hover:bg-amber-500 transition-colors"
                                aria-label="<?php echo esc_attr($network); ?>"
                            >
                                <?php echo dst_get_icon($network, 'w-5 h-5'); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Opening Hours -->
            <?php if ($show_hours): ?>
                <div>
                    <h3 class="text-lg font-bold mb-6 hf-accent-color"><?php echo esc_html($hours_title); ?></h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-center pb-2 border-b border-white/10">
                            <span>شنبه - چهارشنبه</span>
                            <span class="font-semibold">12:00 - 23:00</span>
                        </div>
                        <div class="flex justify-between items-center pb-2 border-b border-white/10">
                            <span>پنج‌شنبه - جمعه</span>
                            <span class="font-semibold">11:00 - 24:00</span>
                        </div>
                        <div class="flex items-center gap-2 pt-2 hf-accent-color">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="font-semibold">اکنون باز است</span>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Location -->
            <?php if ($show_location && $show_contact): ?>
                <div>
                    <h3 class="text-lg font-bold mb-6 hf-accent-color"><?php echo esc_html($location_title); ?></h3>
                    <div class="space-y-4 text-sm">
                        <?php if (dst_get_contact('address')): ?>
                            <div class="flex gap-3">
                                <svg class="w-5 h-5 flex-shrink-0 hf-accent-color" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="leading-relaxed"><?php echo esc_html(dst_get_contact('address')); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if (dst_get_contact('phone')): ?>
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 hf-accent-color" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <a href="tel:<?php echo esc_attr(dst_get_contact('phone')); ?>" class="font-semibold">
                                    <?php echo esc_html(dst_get_contact('phone')); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if (dst_get_contact('email')): ?>
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 hf-accent-color" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <a href="mailto:<?php echo esc_attr(dst_get_contact('email')); ?>">
                                    <?php echo esc_html(dst_get_contact('email')); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <!-- Map Placeholder -->
                        <div class="mt-4 aspect-video bg-stone-800 rounded-lg overflow-hidden relative group cursor-pointer">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <svg class="w-12 h-12 opacity-50 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Menu Highlights -->
            <?php if ($show_menu_highlights): ?>
                <div>
                    <h3 class="text-lg font-bold mb-6 hf-accent-color"><?php echo esc_html($menu_highlights_title); ?></h3>
                    <ul class="space-y-3 text-sm">
                        <li class="flex justify-between items-center pb-2 border-b border-white/10">
                            <span>چلوکباب کوبیده</span>
                            <span class="font-bold hf-accent-color">۲۵۰,۰۰۰ تومان</span>
                        </li>
                        <li class="flex justify-between items-center pb-2 border-b border-white/10">
                            <span>ماهی شکم پر</span>
                            <span class="font-bold hf-accent-color">۳۵۰,۰۰۰ تومان</span>
                        </li>
                        <li class="flex justify-between items-center pb-2 border-b border-white/10">
                            <span>خورش فسنجان</span>
                            <span class="font-bold hf-accent-color">۱۸۰,۰۰۰ تومان</span>
                        </li>
                        <li class="flex justify-between items-center pb-2 border-b border-white/10">
                            <span>استیک گوشت</span>
                            <span class="font-bold hf-accent-color">۴۲۰,۰۰۰ تومان</span>
                        </li>
                    </ul>
                    <a href="<?php echo home_url('/menu'); ?>" class="inline-flex items-center gap-2 mt-4 text-sm hf-accent-color hover:opacity-80 transition-opacity">
                        <span>مشاهده منوی کامل</span>
                        <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="border-t border-white/10">
        <div class="hf-container py-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm">

                <!-- Copyright -->
                <?php if ($show_copyright): ?>
                    <div class="opacity-80 text-center md:text-right">
                        &copy; <?php echo date('Y'); ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="font-semibold hf-accent-color">
                            <?php bloginfo('name'); ?>
                        </a>
                        - <?php echo esc_html($copyright_text); ?>
                    </div>
                <?php endif; ?>

                <!-- Links -->
                <div class="flex items-center gap-6">
                    <a href="<?php echo home_url('/menu'); ?>">منو</a>
                    <a href="<?php echo home_url('/about'); ?>">درباره ما</a>
                    <a href="<?php echo home_url('/gallery'); ?>">گالری</a>
                    <a href="<?php echo home_url('/contact'); ?>">تماس</a>
                </div>

                <!-- Payment Methods -->
                <?php if ($show_payment_icons): ?>
                    <div class="flex items-center gap-3 opacity-60">
                        <span class="text-xs">روش‌های پرداخت:</span>
                        <div class="flex gap-2">
                            <div class="w-10 h-7 bg-white/20 rounded flex items-center justify-center text-xs">💳</div>
                            <div class="w-10 h-7 bg-white/20 rounded flex items-center justify-center text-xs">💵</div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <?php if ($show_back_to_top): ?>
        <button
            @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            x-data
            x-show="window.pageYOffset > 300"
            x-transition
            class="fixed bottom-8 left-8 rtl:left-auto rtl:right-8 w-12 h-12 hf-accent-bg text-gray-900 rounded-full shadow-lg hover:shadow-xl transition-all flex items-center justify-center z-50"
            aria-label="بازگشت به بالا"
        >
            <?php echo dst_get_icon('arrow-up', 'w-5 h-5'); ?>
        </button>
    <?php endif; ?>
</footer>
