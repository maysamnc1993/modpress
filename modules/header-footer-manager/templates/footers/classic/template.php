<?php
/**
 * فوتر کلاسیک
 * 4 ستون با ویجت‌ها
 */
?>
<footer class="bg-gray-100 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 py-12" dir="rtl">
    <div class="hf-container max-w-7xl mx-auto px-4">

        <!-- 4 ستون ویجت -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">

            <!-- ستون 1: درباره ما -->
            <div class="footer-widget">
                <?php if (is_active_sidebar('footer-1')): ?>
                    <?php dynamic_sidebar('footer-1'); ?>
                <?php else: ?>
                    <div class="footer-brand">
                        <?php if (has_custom_logo()): ?>
                            <div class="mb-4">
                                <?php the_custom_logo(); ?>
                            </div>
                        <?php else: ?>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4">
                                <a href="<?php echo esc_url(home_url('/')); ?>">
                                    <?php bloginfo('name'); ?>
                                </a>
                            </h3>
                        <?php endif; ?>
                        <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                            <?php echo get_bloginfo('description'); ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- ستون 2: لینک‌های سریع -->
            <div class="footer-widget">
                <?php if (is_active_sidebar('footer-2')): ?>
                    <?php dynamic_sidebar('footer-2'); ?>
                <?php else: ?>
                    <h4 class="hf-footer-widget-title text-lg font-bold text-gray-800 dark:text-white mb-4">لینک‌های سریع</h4>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer',
                        'container'      => false,
                        'menu_class'     => 'hf-footer-menu space-y-2',
                        'fallback_cb'    => false,
                        'depth'          => 1,
                    ]);
                    ?>
                <?php endif; ?>
            </div>

            <!-- ستون 3: فروشگاه -->
            <div class="footer-widget">
                <?php if (is_active_sidebar('footer-3')): ?>
                    <?php dynamic_sidebar('footer-3'); ?>
                <?php else: ?>
                    <h4 class="hf-footer-widget-title text-lg font-bold text-gray-800 dark:text-white mb-4">فروشگاه</h4>
                    <ul class="hf-footer-menu space-y-2">
                        <?php if (dst_is_woocommerce_active()): ?>
                            <li><a href="<?php echo esc_url(dst_get_shop_url()); ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">محصولات</a></li>
                            <li><a href="<?php echo esc_url(dst_get_cart_url()); ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">سبد خرید</a></li>
                            <li><a href="<?php echo esc_url(dst_get_checkout_url()); ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">تسویه حساب</a></li>
                            <li><a href="<?php echo esc_url(dst_get_account_url()); ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">حساب کاربری</a></li>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- ستون 4: تماس با ما -->
            <div class="footer-widget">
                <?php if (is_active_sidebar('footer-4')): ?>
                    <?php dynamic_sidebar('footer-4'); ?>
                <?php else: ?>
                    <h4 class="hf-footer-widget-title text-lg font-bold text-gray-800 dark:text-white mb-4">تماس با ما</h4>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3 text-gray-600 dark:text-gray-400">
                            <?php echo dst_get_icon('phone', 'w-5 h-5 mt-0.5 flex-shrink-0'); ?>
                            <a href="tel:+982112345678" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">021-12345678</a>
                        </li>
                        <li class="flex items-start gap-3 text-gray-600 dark:text-gray-400">
                            <?php echo dst_get_icon('mail', 'w-5 h-5 mt-0.5 flex-shrink-0'); ?>
                            <a href="mailto:info@example.com" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">info@example.com</a>
                        </li>
                        <li class="flex items-start gap-3 text-gray-600 dark:text-gray-400">
                            <?php echo dst_get_icon('location', 'w-5 h-5 mt-0.5 flex-shrink-0'); ?>
                            <span>تهران، ایران</span>
                        </li>
                    </ul>
                <?php endif; ?>
            </div>

        </div>

        <!-- نوار پایین -->
        <div class="border-t border-gray-200 dark:border-gray-700 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-gray-600 dark:text-gray-400 text-sm">
                &copy; <?php echo date('Y'); ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                    <?php bloginfo('name'); ?>
                </a>
                - تمامی حقوق محفوظ است.
            </p>

            <!-- شبکه‌های اجتماعی -->
            <div class="hf-social-icons flex gap-3">
                <a href="#" class="hf-social-icon w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-primary-600 hover:text-white transition-all" aria-label="اینستاگرام">
                    <?php echo dst_get_icon('instagram', 'w-5 h-5'); ?>
                </a>
                <a href="#" class="hf-social-icon w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-primary-600 hover:text-white transition-all" aria-label="تلگرام">
                    <?php echo dst_get_icon('telegram', 'w-5 h-5'); ?>
                </a>
                <a href="#" class="hf-social-icon w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-primary-600 hover:text-white transition-all" aria-label="واتساپ">
                    <?php echo dst_get_icon('whatsapp', 'w-5 h-5'); ?>
                </a>
            </div>
        </div>

    </div>
</footer>
