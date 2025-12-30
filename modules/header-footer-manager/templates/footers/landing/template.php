<?php
/**
 * Footer Template: Landing
 * فوتر مینیمال صفحه فرود
 */

defined('ABSPATH') || exit;

$settings = dst_get_footer_setting();
$bg_color = $settings['bg_color'] ?? '#ffffff';
$text_color = $settings['text_color'] ?? '#64748b';
$link_color = $settings['link_color'] ?? '#64748b';
$link_hover_color = $settings['link_hover_color'] ?? '#1e293b';
$show_logo = $settings['show_logo'] ?? true;
$show_description = $settings['show_description'] ?? false;
$description_text = $settings['description_text'] ?? 'راهکار ساده و قدرتمند برای کسب‌وکار شما';
$show_social = $settings['show_social'] ?? true;
$show_newsletter = $settings['show_newsletter'] ?? false;
$newsletter_title = $settings['newsletter_title'] ?? 'عضویت در خبرنامه';
$newsletter_text = $settings['newsletter_text'] ?? 'آخرین اخبار را دریافت کنید';
$show_contact = $settings['show_contact'] ?? false;
$columns = $settings['columns'] ?? '3';
$show_menu1 = $settings['show_menu1'] ?? false;
$menu1_title = $settings['menu1_title'] ?? 'لینک‌ها';
$show_menu2 = $settings['show_menu2'] ?? false;
$menu2_title = $settings['menu2_title'] ?? 'منابع';
$show_copyright = $settings['show_copyright'] ?? true;
$copyright_text = $settings['copyright_text'] ?? 'تمامی حقوق محفوظ است';
$show_payment_icons = $settings['show_payment_icons'] ?? false;
$show_back_to_top = $settings['show_back_to_top'] ?? false;
$show_legal_links = $settings['show_legal_links'] ?? true;
$show_privacy_link = $settings['show_privacy_link'] ?? true;
$privacy_url = $settings['privacy_url'] ?? '/privacy-policy';
$show_terms_link = $settings['show_terms_link'] ?? true;
$terms_url = $settings['terms_url'] ?? '/terms-of-service';
$show_cookies_link = $settings['show_cookies_link'] ?? false;
$cookies_url = $settings['cookies_url'] ?? '/cookies-policy';
$layout_style = $settings['layout_style'] ?? 'centered';
$border_top = $settings['border_top'] ?? true;
?>

<footer
    class="hf-footer hf-footer-landing"
    style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;"
    dir="rtl"
>
    <style>
        .hf-footer-landing a {
            color: <?php echo esc_attr($link_color); ?>;
            transition: color 0.3s ease;
        }
        .hf-footer-landing a:hover {
            color: <?php echo esc_attr($link_hover_color); ?>;
        }
    </style>

    <div class="<?php echo $border_top ? 'border-t border-gray-200' : ''; ?>">
        <?php if ($layout_style === 'centered'): ?>
            <!-- Centered Layout -->
            <div class="hf-container py-12">
                <div class="max-w-2xl mx-auto text-center">

                    <!-- Logo -->
                    <?php if ($show_logo): ?>
                        <div class="flex justify-center mb-6">
                            <?php dst_the_logo('default', 'h-10 w-auto'); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Description -->
                    <?php if ($show_description): ?>
                        <p class="text-sm mb-6 leading-relaxed">
                            <?php echo esc_html($description_text); ?>
                        </p>
                    <?php endif; ?>

                    <!-- Social Icons -->
                    <?php if ($show_social): ?>
                        <div class="flex justify-center gap-4 mb-8">
                            <?php
                            $social_networks = ['twitter', 'linkedin', 'instagram', 'github'];
                            foreach ($social_networks as $network):
                                $url = dst_get_social($network);
                                if (!$url) continue;
                            ?>
                                <a
                                    href="<?php echo esc_url($url); ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-gray-900 transition-all"
                                    aria-label="<?php echo esc_attr($network); ?>"
                                >
                                    <?php echo dst_get_icon($network, 'w-5 h-5'); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Legal Links -->
                    <?php if ($show_legal_links): ?>
                        <div class="flex flex-wrap justify-center items-center gap-4 mb-6 text-sm">
                            <?php if ($show_privacy_link): ?>
                                <a href="<?php echo esc_url($privacy_url); ?>" class="hover:underline">
                                    سیاست حریم خصوصی
                                </a>
                            <?php endif; ?>

                            <?php if ($show_privacy_link && $show_terms_link): ?>
                                <span class="text-gray-300">•</span>
                            <?php endif; ?>

                            <?php if ($show_terms_link): ?>
                                <a href="<?php echo esc_url($terms_url); ?>" class="hover:underline">
                                    شرایط استفاده
                                </a>
                            <?php endif; ?>

                            <?php if ($show_cookies_link): ?>
                                <span class="text-gray-300">•</span>
                                <a href="<?php echo esc_url($cookies_url); ?>" class="hover:underline">
                                    سیاست کوکی‌ها
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Copyright -->
                    <?php if ($show_copyright): ?>
                        <div class="text-sm">
                            &copy; <?php echo date('Y'); ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="font-semibold">
                                <?php bloginfo('name'); ?>
                            </a>
                            - <?php echo esc_html($copyright_text); ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        <?php else: ?>
            <!-- Spread Layout -->
            <div class="hf-container py-12">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">

                    <!-- Left: Logo & Copyright -->
                    <div class="flex flex-col md:flex-row items-center gap-4">
                        <?php if ($show_logo): ?>
                            <?php dst_the_logo('default', 'h-8 w-auto'); ?>
                        <?php endif; ?>

                        <?php if ($show_copyright): ?>
                            <div class="text-sm text-center md:text-right">
                                &copy; <?php echo date('Y'); ?>
                                <a href="<?php echo esc_url(home_url('/')); ?>" class="font-semibold">
                                    <?php bloginfo('name'); ?>
                                </a>
                                - <?php echo esc_html($copyright_text); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Center: Legal Links -->
                    <?php if ($show_legal_links): ?>
                        <div class="flex flex-wrap justify-center items-center gap-4 text-sm">
                            <?php if ($show_privacy_link): ?>
                                <a href="<?php echo esc_url($privacy_url); ?>" class="hover:underline">
                                    حریم خصوصی
                                </a>
                            <?php endif; ?>

                            <?php if ($show_terms_link): ?>
                                <a href="<?php echo esc_url($terms_url); ?>" class="hover:underline">
                                    شرایط استفاده
                                </a>
                            <?php endif; ?>

                            <?php if ($show_cookies_link): ?>
                                <a href="<?php echo esc_url($cookies_url); ?>" class="hover:underline">
                                    کوکی‌ها
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Right: Social Icons -->
                    <?php if ($show_social): ?>
                        <div class="flex gap-3">
                            <?php
                            $social_networks = ['twitter', 'linkedin', 'instagram', 'github'];
                            foreach ($social_networks as $network):
                                $url = dst_get_social($network);
                                if (!$url) continue;
                            ?>
                                <a
                                    href="<?php echo esc_url($url); ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="w-9 h-9 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-gray-900 transition-all"
                                    aria-label="<?php echo esc_attr($network); ?>"
                                >
                                    <?php echo dst_get_icon($network, 'w-4 h-4'); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Newsletter (Optional) -->
    <?php if ($show_newsletter): ?>
        <div class="border-t border-gray-200">
            <div class="hf-container py-8">
                <div class="max-w-md mx-auto text-center">
                    <h3 class="text-lg font-bold mb-2"><?php echo esc_html($newsletter_title); ?></h3>
                    <p class="text-sm mb-4"><?php echo esc_html($newsletter_text); ?></p>
                    <form class="flex gap-2" x-data="newsletter">
                        <input
                            type="email"
                            placeholder="ایمیل شما"
                            class="flex-1 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent text-sm"
                            required
                        />
                        <button
                            type="submit"
                            class="px-6 py-2 bg-gray-900 text-white font-semibold rounded-lg hover:bg-gray-800 transition-colors text-sm"
                        >
                            عضویت
                        </button>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Back to Top Button (Optional) -->
    <?php if ($show_back_to_top): ?>
        <button
            @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            x-data
            x-show="window.pageYOffset > 300"
            x-transition
            class="fixed bottom-8 left-8 rtl:left-auto rtl:right-8 w-12 h-12 bg-gray-900 text-white rounded-full shadow-lg hover:shadow-xl transition-all flex items-center justify-center z-50"
            aria-label="بازگشت به بالا"
        >
            <?php echo dst_get_icon('arrow-up', 'w-5 h-5'); ?>
        </button>
    <?php endif; ?>
</footer>
