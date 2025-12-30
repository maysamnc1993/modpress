<?php
/**
 * Footer Template: Startup
 * فوتر مدرن استارتاپی با CTA گرادیانت
 */

defined('ABSPATH') || exit;

$settings = dst_get_footer_setting();
$bg_color = $settings['bg_color'] ?? '#ffffff';
$text_color = $settings['text_color'] ?? '#1e293b';
$link_color = $settings['link_color'] ?? '#64748b';
$link_hover_color = $settings['link_hover_color'] ?? '#8b5cf6';
$show_logo = $settings['show_logo'] ?? true;
$show_description = $settings['show_description'] ?? true;
$description_text = $settings['description_text'] ?? 'ما در حال ساخت ابزارهای نوآورانه برای کمک به رشد کسب‌وکار شما هستیم.';
$show_social = $settings['show_social'] ?? true;
$show_newsletter = $settings['show_newsletter'] ?? false;
$newsletter_title = $settings['newsletter_title'] ?? 'به‌روزرسانی‌های محصول';
$newsletter_text = $settings['newsletter_text'] ?? 'آخرین ویژگی‌ها و اخبار را دریافت کنید';
$show_contact = $settings['show_contact'] ?? true;
$columns = $settings['columns'] ?? '4';
$show_menu1 = $settings['show_menu1'] ?? true;
$menu1_title = $settings['menu1_title'] ?? 'محصولات';
$show_menu2 = $settings['show_menu2'] ?? true;
$menu2_title = $settings['menu2_title'] ?? 'منابع';
$show_copyright = $settings['show_copyright'] ?? true;
$copyright_text = $settings['copyright_text'] ?? 'تمامی حقوق محفوظ است';
$show_payment_icons = $settings['show_payment_icons'] ?? false;
$show_back_to_top = $settings['show_back_to_top'] ?? true;
$show_cta = $settings['show_cta'] ?? true;
$cta_title = $settings['cta_title'] ?? 'آماده شروع هستید؟';
$cta_text = $settings['cta_text'] ?? 'همین الان محصول ما را رایگان امتحان کنید. نیازی به کارت اعتباری نیست.';
$cta_button_text = $settings['cta_button_text'] ?? 'شروع رایگان';
$cta_button_url = $settings['cta_button_url'] ?? '/signup';
$show_demo_link = $settings['show_demo_link'] ?? true;
$demo_text = $settings['demo_text'] ?? 'مشاهده دمو';
$demo_url = $settings['demo_url'] ?? '/demo';
$gradient_start = $settings['gradient_start'] ?? '#8b5cf6';
$gradient_end = $settings['gradient_end'] ?? '#ec4899';
?>

<footer
    class="hf-footer hf-footer-startup"
    style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;"
    dir="rtl"
>
    <style>
        .hf-footer-startup a {
            color: <?php echo esc_attr($link_color); ?>;
            transition: color 0.3s ease;
        }
        .hf-footer-startup a:hover {
            color: <?php echo esc_attr($link_hover_color); ?>;
        }
        .hf-gradient-cta {
            background: linear-gradient(135deg, <?php echo esc_attr($gradient_start); ?> 0%, <?php echo esc_attr($gradient_end); ?> 100%);
        }
    </style>

    <!-- CTA Section with Gradient -->
    <?php if ($show_cta): ?>
        <div class="hf-gradient-cta relative overflow-hidden">
            <!-- Decorative Elements -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-10 right-20 w-32 h-32 bg-white rounded-full blur-3xl"></div>
                <div class="absolute bottom-10 left-20 w-40 h-40 bg-white rounded-full blur-3xl"></div>
            </div>

            <div class="hf-container py-16 relative z-10">
                <div class="max-w-3xl mx-auto text-center">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                        <?php echo esc_html($cta_title); ?>
                    </h2>
                    <p class="text-lg text-white/90 mb-8">
                        <?php echo esc_html($cta_text); ?>
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a
                            href="<?php echo esc_url($cta_button_url); ?>"
                            class="inline-flex items-center justify-center px-8 py-4 bg-white text-gray-900 font-bold rounded-xl hover:bg-gray-100 transition-all transform hover:scale-105 shadow-xl"
                        >
                            <?php echo esc_html($cta_button_text); ?>
                            <svg class="w-5 h-5 mr-2 rtl:ml-2 rtl:mr-0 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                        <?php if ($show_demo_link): ?>
                            <a
                                href="<?php echo esc_url($demo_url); ?>"
                                class="inline-flex items-center justify-center px-8 py-4 bg-white/20 text-white font-bold rounded-xl hover:bg-white/30 transition-all backdrop-blur-sm border-2 border-white/30"
                            >
                                <svg class="w-5 h-5 ml-2 rtl:mr-2 rtl:ml-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <?php echo esc_html($demo_text); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Footer Content -->
    <div class="border-t border-gray-200">
        <div class="hf-container py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-<?php echo esc_attr($columns); ?> gap-8 lg:gap-12">

                <!-- Company Info Column -->
                <div class="lg:col-span-1">
                    <?php if ($show_logo): ?>
                        <div class="mb-6">
                            <?php dst_the_logo('default', 'h-10 w-auto'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($show_description): ?>
                        <p class="mb-6 text-sm leading-relaxed text-gray-600">
                            <?php echo esc_html($description_text); ?>
                        </p>
                    <?php endif; ?>

                    <?php if ($show_social): ?>
                        <div class="flex gap-3">
                            <?php
                            $social_networks = ['twitter', 'linkedin', 'github', 'instagram'];
                            foreach ($social_networks as $network):
                                $url = dst_get_social($network);
                                if (!$url) continue;
                            ?>
                                <a
                                    href="<?php echo esc_url($url); ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="w-10 h-10 flex items-center justify-center rounded-lg bg-gray-100 hover:bg-gradient-to-r hover:from-purple-500 hover:to-pink-500 text-gray-600 hover:text-white transition-all"
                                    aria-label="<?php echo esc_attr($network); ?>"
                                >
                                    <?php echo dst_get_icon($network, 'w-5 h-5'); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Products Menu -->
                <?php if ($show_menu1): ?>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-6">
                            <?php echo esc_html($menu1_title); ?>
                        </h3>
                        <ul class="space-y-3 text-sm">
                            <li><a href="<?php echo home_url('/features'); ?>">ویژگی‌ها</a></li>
                            <li><a href="<?php echo home_url('/pricing'); ?>">قیمت‌گذاری</a></li>
                            <li><a href="<?php echo home_url('/integrations'); ?>">یکپارچه‌سازی‌ها</a></li>
                            <li><a href="<?php echo home_url('/api'); ?>">API</a></li>
                            <li><a href="<?php echo home_url('/roadmap'); ?>">نقشه راه</a></li>
                            <li><a href="<?php echo home_url('/changelog'); ?>">تغییرات</a></li>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Resources Menu -->
                <?php if ($show_menu2): ?>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-6">
                            <?php echo esc_html($menu2_title); ?>
                        </h3>
                        <ul class="space-y-3 text-sm">
                            <li><a href="<?php echo home_url('/blog'); ?>">وبلاگ</a></li>
                            <li><a href="<?php echo home_url('/docs'); ?>">مستندات</a></li>
                            <li><a href="<?php echo home_url('/tutorials'); ?>">آموزش‌ها</a></li>
                            <li><a href="<?php echo home_url('/guides'); ?>">راهنماها</a></li>
                            <li><a href="<?php echo home_url('/webinars'); ?>">وبینارها</a></li>
                            <li><a href="<?php echo home_url('/case-studies'); ?>">مطالعات موردی</a></li>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Company Menu -->
                <div>
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-6">شرکت</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="<?php echo home_url('/about'); ?>">درباره ما</a></li>
                        <li><a href="<?php echo home_url('/team'); ?>">تیم ما</a></li>
                        <li><a href="<?php echo home_url('/careers'); ?>">فرصت‌های شغلی</a></li>
                        <li><a href="<?php echo home_url('/press'); ?>">اخبار و مطبوعات</a></li>
                        <li><a href="<?php echo home_url('/partners'); ?>">شرکای تجاری</a></li>
                        <li><a href="<?php echo home_url('/contact'); ?>">تماس با ما</a></li>
                    </ul>
                </div>

            </div>

            <!-- Newsletter -->
            <?php if ($show_newsletter): ?>
                <div class="mt-12 pt-12 border-t border-gray-200">
                    <div class="max-w-xl">
                        <h3 class="text-lg font-bold mb-2"><?php echo esc_html($newsletter_title); ?></h3>
                        <p class="text-sm text-gray-600 mb-4"><?php echo esc_html($newsletter_text); ?></p>
                        <form class="flex gap-3" x-data="newsletter">
                            <input
                                type="email"
                                placeholder="ایمیل شما"
                                class="flex-1 px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                required
                            />
                            <button
                                type="submit"
                                class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-semibold rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all"
                            >
                                عضویت
                            </button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="border-t border-gray-200">
        <div class="hf-container py-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm">

                <!-- Copyright -->
                <?php if ($show_copyright): ?>
                    <div class="text-gray-600 text-center md:text-right">
                        &copy; <?php echo date('Y'); ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="font-semibold text-gray-900">
                            <?php bloginfo('name'); ?>
                        </a>
                        - <?php echo esc_html($copyright_text); ?>
                    </div>
                <?php endif; ?>

                <!-- Legal Links -->
                <div class="flex items-center gap-6 text-gray-600">
                    <a href="<?php echo home_url('/privacy'); ?>">حریم خصوصی</a>
                    <a href="<?php echo home_url('/terms'); ?>">شرایط استفاده</a>
                    <a href="<?php echo home_url('/cookies'); ?>">کوکی‌ها</a>
                    <a href="<?php echo home_url('/status'); ?>" class="flex items-center gap-1">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        وضعیت سرویس
                    </a>
                </div>
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
            class="fixed bottom-8 left-8 rtl:left-auto rtl:right-8 w-12 h-12 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-full shadow-lg hover:shadow-xl transition-all flex items-center justify-center z-50"
            aria-label="بازگشت به بالا"
        >
            <?php echo dst_get_icon('arrow-up', 'w-5 h-5'); ?>
        </button>
    <?php endif; ?>
</footer>
