<?php
/**
 * فوتر چسبان
 * چسبان پایین صفحه
 */
?>
<footer class="sticky bottom-0 bg-white dark:bg-gray-900 border-t-2 border-primary-600 shadow-lg z-40" dir="rtl">

    <!-- بخش اصلی فوتر -->
    <div class="bg-gray-50 dark:bg-gray-800 py-8">
        <div class="hf-container max-w-7xl mx-auto px-4">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- برند -->
                <div>
                    <?php if (has_custom_logo()): ?>
                        <div class="mb-3">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php else: ?>
                        <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-3">
                            <a href="<?php echo esc_url(home_url('/')); ?>">
                                <?php bloginfo('name'); ?>
                            </a>
                        </h4>
                    <?php endif; ?>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                        <?php echo get_bloginfo('description'); ?>
                    </p>
                </div>

                <!-- لینک‌های سریع -->
                <div>
                    <h5 class="text-sm font-bold text-gray-800 dark:text-white mb-3">لینک‌های سریع</h5>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer',
                        'container'      => false,
                        'menu_class'     => 'hf-footer-menu space-y-1 text-sm',
                        'fallback_cb'    => false,
                        'depth'          => 1,
                    ]);
                    ?>
                </div>

                <!-- فروشگاه -->
                <?php if (dst_is_woocommerce_active()): ?>
                    <div>
                        <h5 class="text-sm font-bold text-gray-800 dark:text-white mb-3">فروشگاه</h5>
                        <ul class="hf-footer-menu space-y-1 text-sm">
                            <li><a href="<?php echo esc_url(dst_get_shop_url()); ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">محصولات</a></li>
                            <li><a href="<?php echo esc_url(dst_get_cart_url()); ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">سبد خرید</a></li>
                            <li><a href="<?php echo esc_url(dst_get_account_url()); ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">حساب کاربری</a></li>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- ارتباط -->
                <div>
                    <h5 class="text-sm font-bold text-gray-800 dark:text-white mb-3">ارتباط با ما</h5>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                            <?php echo dst_get_icon('phone', 'w-4 h-4 flex-shrink-0'); ?>
                            <a href="tel:+982112345678" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">021-12345678</a>
                        </li>
                        <li class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                            <?php echo dst_get_icon('mail', 'w-4 h-4 flex-shrink-0'); ?>
                            <a href="mailto:info@example.com" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">info@example.com</a>
                        </li>
                    </ul>

                    <!-- شبکه‌های اجتماعی -->
                    <div class="hf-social-icons flex gap-2 mt-3">
                        <a href="#" class="w-8 h-8 rounded-lg bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-primary-600 hover:text-white transition-all" aria-label="اینستاگرام">
                            <?php echo dst_get_icon('instagram', 'w-4 h-4'); ?>
                        </a>
                        <a href="#" class="w-8 h-8 rounded-lg bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-primary-600 hover:text-white transition-all" aria-label="تلگرام">
                            <?php echo dst_get_icon('telegram', 'w-4 h-4'); ?>
                        </a>
                        <a href="#" class="w-8 h-8 rounded-lg bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-primary-600 hover:text-white transition-all" aria-label="واتساپ">
                            <?php echo dst_get_icon('whatsapp', 'w-4 h-4'); ?>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- نوار پایین فشرده -->
    <div class="bg-white dark:bg-gray-900 py-3 border-t border-gray-200 dark:border-gray-700">
        <div class="hf-container max-w-7xl mx-auto px-4">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-2 text-xs">
                <p class="text-gray-500 dark:text-gray-500">
                    &copy; <?php echo date('Y'); ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                        <?php bloginfo('name'); ?>
                    </a>
                </p>

                <!-- دکمه بستن فوتر -->
                <button
                    onclick="this.closest('footer').style.display='none'"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors px-2 py-1 rounded hover:bg-gray-100 dark:hover:bg-gray-800"
                    title="بستن فوتر"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

</footer>
