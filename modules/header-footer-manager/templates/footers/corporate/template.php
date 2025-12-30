<?php
/**
 * Footer Template: Corporate
 * فوتر شرکتی با دپارتمان‌ها، موقعیت مکانی و روابط سرمایه‌گذار
 */

defined('ABSPATH') || exit;

$settings = dst_get_footer_setting();
$bg_color = $settings['bg_color'] ?? '#1e293b';
$text_color = $settings['text_color'] ?? '#ffffff';
$link_color = $settings['link_color'] ?? '#94a3b8';
$link_hover_color = $settings['link_hover_color'] ?? '#ffffff';
$show_logo = $settings['show_logo'] ?? true;
$show_description = $settings['show_description'] ?? true;
$description_text = $settings['description_text'] ?? 'ما یک شرکت پیشرو در ارائه راهکارهای نوآورانه برای کسب‌وکارها هستیم. ماموریت ما کمک به رشد و موفقیت شما است.';
$show_social = $settings['show_social'] ?? true;
$show_newsletter = $settings['show_newsletter'] ?? true;
$newsletter_title = $settings['newsletter_title'] ?? 'عضویت در خبرنامه';
$newsletter_text = $settings['newsletter_text'] ?? 'آخرین اخبار و به‌روزرسانی‌ها را در ایمیل خود دریافت کنید';
$show_contact = $settings['show_contact'] ?? true;
$columns = $settings['columns'] ?? '4';
$show_menu1 = $settings['show_menu1'] ?? true;
$menu1_title = $settings['menu1_title'] ?? 'لینک‌های سریع';
$show_menu2 = $settings['show_menu2'] ?? true;
$menu2_title = $settings['menu2_title'] ?? 'خدمات';
$show_copyright = $settings['show_copyright'] ?? true;
$copyright_text = $settings['copyright_text'] ?? 'تمامی حقوق محفوظ است';
$show_payment_icons = $settings['show_payment_icons'] ?? false;
$show_back_to_top = $settings['show_back_to_top'] ?? true;
$show_departments = $settings['show_departments'] ?? true;
$departments_title = $settings['departments_title'] ?? 'دپارتمان‌ها';
$show_locations = $settings['show_locations'] ?? true;
$locations_title = $settings['locations_title'] ?? 'شعب ما';
$show_careers = $settings['show_careers'] ?? true;
$careers_url = $settings['careers_url'] ?? '/careers';
$show_investors = $settings['show_investors'] ?? true;
$investors_url = $settings['investors_url'] ?? '/investors';
?>

<footer
    class="hf-footer hf-footer-corporate relative"
    style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;"
    dir="rtl"
>
    <style>
        .hf-footer-corporate a {
            color: <?php echo esc_attr($link_color); ?>;
            transition: color 0.3s ease;
        }
        .hf-footer-corporate a:hover {
            color: <?php echo esc_attr($link_hover_color); ?>;
        }
    </style>

    <!-- Main Footer Content -->
    <div class="hf-container py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-<?php echo esc_attr($columns); ?> gap-8 lg:gap-12">

            <!-- Company Info Column -->
            <div class="lg:col-span-1">
                <?php if ($show_logo): ?>
                    <div class="mb-6">
                        <?php dst_the_logo('light', 'h-12 w-auto'); ?>
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
                        $social_networks = ['instagram', 'linkedin', 'twitter', 'telegram', 'youtube'];
                        foreach ($social_networks as $network):
                            $url = dst_get_social($network);
                            if (!$url) continue;
                        ?>
                            <a
                                href="<?php echo esc_url($url); ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="w-10 h-10 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 transition-colors"
                                aria-label="<?php echo esc_attr($network); ?>"
                            >
                                <?php echo dst_get_icon($network, 'w-5 h-5'); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Quick Links Menu -->
            <?php if ($show_menu1 && has_nav_menu('footer')): ?>
                <div>
                    <h3 class="text-lg font-bold mb-6"><?php echo esc_html($menu1_title); ?></h3>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer',
                        'container' => false,
                        'menu_class' => 'space-y-3',
                        'fallback_cb' => false,
                        'depth' => 1,
                    ]);
                    ?>
                </div>
            <?php endif; ?>

            <!-- Departments Menu -->
            <?php if ($show_departments): ?>
                <div>
                    <h3 class="text-lg font-bold mb-6"><?php echo esc_html($departments_title); ?></h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="<?php echo home_url('/sales'); ?>">فروش و بازاریابی</a></li>
                        <li><a href="<?php echo home_url('/engineering'); ?>">مهندسی و توسعه</a></li>
                        <li><a href="<?php echo home_url('/support'); ?>">پشتیبانی مشتریان</a></li>
                        <li><a href="<?php echo home_url('/hr'); ?>">منابع انسانی</a></li>
                        <li><a href="<?php echo home_url('/finance'); ?>">امور مالی</a></li>
                        <?php if ($show_careers): ?>
                            <li><a href="<?php echo esc_url($careers_url); ?>" class="font-semibold">فرصت‌های شغلی</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Services/Resources Menu -->
            <?php if ($show_menu2 && has_nav_menu('footer-services')): ?>
                <div>
                    <h3 class="text-lg font-bold mb-6"><?php echo esc_html($menu2_title); ?></h3>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer-services',
                        'container' => false,
                        'menu_class' => 'space-y-3',
                        'fallback_cb' => false,
                        'depth' => 1,
                    ]);
                    ?>
                </div>
            <?php endif; ?>

            <!-- Locations -->
            <?php if ($show_locations): ?>
                <div>
                    <h3 class="text-lg font-bold mb-6"><?php echo esc_html($locations_title); ?></h3>
                    <div class="space-y-4 text-sm">
                        <div>
                            <h4 class="font-semibold mb-2">دفتر مرکزی - تهران</h4>
                            <p class="opacity-80"><?php echo esc_html(dst_get_contact('address')); ?></p>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-2">شعبه شمال - رشت</h4>
                            <p class="opacity-80">خیابان امام خمینی، پلاک 123</p>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-2">شعبه غرب - تبریز</h4>
                            <p class="opacity-80">میدان ساعت، برج تجاری</p>
                        </div>
                        <?php if ($show_contact): ?>
                            <div class="pt-2 border-t border-white/10">
                                <div class="flex items-center gap-2 mb-2">
                                    <?php echo dst_get_icon('phone', 'w-4 h-4'); ?>
                                    <a href="tel:<?php echo esc_attr(dst_get_contact('phone')); ?>">
                                        <?php echo esc_html(dst_get_contact('phone')); ?>
                                    </a>
                                </div>
                                <div class="flex items-center gap-2">
                                    <?php echo dst_get_icon('mail', 'w-4 h-4'); ?>
                                    <a href="mailto:<?php echo esc_attr(dst_get_contact('email')); ?>">
                                        <?php echo esc_html(dst_get_contact('email')); ?>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Newsletter -->
            <?php if ($show_newsletter): ?>
                <div class="lg:col-span-<?php echo $columns >= 4 ? '1' : '2'; ?>">
                    <h3 class="text-lg font-bold mb-6"><?php echo esc_html($newsletter_title); ?></h3>
                    <p class="text-sm mb-4 opacity-90"><?php echo esc_html($newsletter_text); ?></p>
                    <form class="flex flex-col sm:flex-row gap-3" x-data="newsletter">
                        <input
                            type="email"
                            placeholder="ایمیل شما"
                            class="flex-1 px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/60 focus:outline-none focus:border-white/40"
                            required
                        />
                        <button
                            type="submit"
                            class="px-6 py-3 bg-white text-gray-900 font-semibold rounded-lg hover:bg-gray-100 transition-colors"
                        >
                            عضویت
                        </button>
                    </form>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="border-t border-white/10">
        <div class="hf-container py-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">

                <!-- Copyright -->
                <?php if ($show_copyright): ?>
                    <div class="text-sm opacity-80 text-center md:text-right">
                        &copy; <?php echo date('Y'); ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="font-semibold">
                            <?php bloginfo('name'); ?>
                        </a>
                        - <?php echo esc_html($copyright_text); ?>
                    </div>
                <?php endif; ?>

                <!-- Legal Links -->
                <div class="flex items-center gap-6 text-sm">
                    <a href="<?php echo home_url('/privacy-policy'); ?>">حریم خصوصی</a>
                    <a href="<?php echo home_url('/terms'); ?>">شرایط استفاده</a>
                    <?php if ($show_investors): ?>
                        <a href="<?php echo esc_url($investors_url); ?>">روابط سرمایه‌گذار</a>
                    <?php endif; ?>
                    <a href="<?php echo home_url('/sitemap'); ?>">نقشه سایت</a>
                </div>

                <!-- Payment Icons -->
                <?php if ($show_payment_icons && dst_is_woocommerce_active()): ?>
                    <div class="flex items-center gap-3 opacity-60">
                        <span class="text-xs">روش‌های پرداخت:</span>
                        <div class="flex gap-2">
                            <div class="w-10 h-7 bg-white/20 rounded flex items-center justify-center text-xs">💳</div>
                            <div class="w-10 h-7 bg-white/20 rounded flex items-center justify-center text-xs">🏦</div>
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
            class="fixed bottom-8 left-8 rtl:left-auto rtl:right-8 w-12 h-12 bg-white text-gray-900 rounded-full shadow-lg hover:shadow-xl transition-all flex items-center justify-center z-50"
            aria-label="بازگشت به بالا"
        >
            <?php echo dst_get_icon('arrow-up', 'w-5 h-5'); ?>
        </button>
    <?php endif; ?>
</footer>
