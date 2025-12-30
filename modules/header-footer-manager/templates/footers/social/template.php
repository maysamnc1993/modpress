<?php
/**
 * فوتر شبکه‌های اجتماعی
 * تأکید بر شبکه‌های اجتماعی
 */
?>
<footer class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 py-12" dir="rtl">
    <div class="hf-container max-w-7xl mx-auto px-4">

        <!-- بخش شبکه‌های اجتماعی -->
        <div class="text-center mb-12">
            <h3 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white mb-4">
                با ما در ارتباط باشید
            </h3>
            <p class="text-gray-600 dark:text-gray-400 mb-8">
                ما را در شبکه‌های اجتماعی دنبال کنید
            </p>

            <!-- آیکون‌های بزرگ شبکه‌های اجتماعی -->
            <div class="hf-social-icons flex flex-wrap justify-center gap-4 mb-8">
                <a href="#" class="group flex flex-col items-center gap-2 p-4 rounded-xl bg-gradient-to-br from-purple-600 to-pink-600 text-white hover:scale-110 transition-transform duration-300 shadow-lg hover:shadow-xl w-28" aria-label="اینستاگرام">
                    <div class="w-12 h-12 flex items-center justify-center">
                        <?php echo dst_get_icon('instagram', 'w-8 h-8'); ?>
                    </div>
                    <span class="text-sm font-medium">اینستاگرام</span>
                </a>

                <a href="#" class="group flex flex-col items-center gap-2 p-4 rounded-xl bg-gradient-to-br from-blue-400 to-blue-600 text-white hover:scale-110 transition-transform duration-300 shadow-lg hover:shadow-xl w-28" aria-label="تلگرام">
                    <div class="w-12 h-12 flex items-center justify-center">
                        <?php echo dst_get_icon('telegram', 'w-8 h-8'); ?>
                    </div>
                    <span class="text-sm font-medium">تلگرام</span>
                </a>

                <a href="#" class="group flex flex-col items-center gap-2 p-4 rounded-xl bg-gradient-to-br from-green-400 to-green-600 text-white hover:scale-110 transition-transform duration-300 shadow-lg hover:shadow-xl w-28" aria-label="واتساپ">
                    <div class="w-12 h-12 flex items-center justify-center">
                        <?php echo dst_get_icon('whatsapp', 'w-8 h-8'); ?>
                    </div>
                    <span class="text-sm font-medium">واتساپ</span>
                </a>

                <a href="#" class="group flex flex-col items-center gap-2 p-4 rounded-xl bg-gradient-to-br from-blue-600 to-blue-800 text-white hover:scale-110 transition-transform duration-300 shadow-lg hover:shadow-xl w-28" aria-label="لینکدین">
                    <div class="w-12 h-12 flex items-center justify-center">
                        <?php echo dst_get_icon('linkedin', 'w-8 h-8'); ?>
                    </div>
                    <span class="text-sm font-medium">لینکدین</span>
                </a>

                <a href="#" class="group flex flex-col items-center gap-2 p-4 rounded-xl bg-gradient-to-br from-gray-700 to-gray-900 text-white hover:scale-110 transition-transform duration-300 shadow-lg hover:shadow-xl w-28" aria-label="توییتر">
                    <div class="w-12 h-12 flex items-center justify-center">
                        <?php echo dst_get_icon('twitter', 'w-8 h-8'); ?>
                    </div>
                    <span class="text-sm font-medium">توییتر</span>
                </a>

                <a href="#" class="group flex flex-col items-center gap-2 p-4 rounded-xl bg-gradient-to-br from-red-600 to-red-700 text-white hover:scale-110 transition-transform duration-300 shadow-lg hover:shadow-xl w-28" aria-label="یوتیوب">
                    <div class="w-12 h-12 flex items-center justify-center">
                        <?php echo dst_get_icon('youtube', 'w-8 h-8'); ?>
                    </div>
                    <span class="text-sm font-medium">یوتیوب</span>
                </a>
            </div>
        </div>

        <!-- بخش اطلاعات -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">

            <!-- درباره -->
            <div class="text-center md:text-right">
                <?php if (has_custom_logo()): ?>
                    <div class="mb-4 flex justify-center md:justify-start">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else: ?>
                    <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-4">
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <?php bloginfo('name'); ?>
                        </a>
                    </h4>
                <?php endif; ?>
                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                    <?php echo get_bloginfo('description'); ?>
                </p>
            </div>

            <!-- لینک‌های فروشگاه -->
            <?php if (dst_is_woocommerce_active()): ?>
                <div class="text-center">
                    <h4 class="hf-footer-widget-title text-lg font-bold text-gray-800 dark:text-white mb-4">فروشگاه</h4>
                    <ul class="hf-footer-menu space-y-2">
                        <li><a href="<?php echo esc_url(dst_get_shop_url()); ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">محصولات</a></li>
                        <li><a href="<?php echo esc_url(dst_get_cart_url()); ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">سبد خرید</a></li>
                        <li><a href="<?php echo esc_url(dst_get_checkout_url()); ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">تسویه حساب</a></li>
                        <li><a href="<?php echo esc_url(dst_get_account_url()); ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">حساب کاربری</a></li>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- تماس -->
            <div class="text-center md:text-right">
                <h4 class="hf-footer-widget-title text-lg font-bold text-gray-800 dark:text-white mb-4">تماس با ما</h4>
                <ul class="space-y-3">
                    <li class="flex items-start gap-3 text-gray-600 dark:text-gray-400 justify-center md:justify-start">
                        <?php echo dst_get_icon('phone', 'w-5 h-5 mt-0.5 flex-shrink-0'); ?>
                        <a href="tel:+982112345678" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">021-12345678</a>
                    </li>
                    <li class="flex items-start gap-3 text-gray-600 dark:text-gray-400 justify-center md:justify-start">
                        <?php echo dst_get_icon('mail', 'w-5 h-5 mt-0.5 flex-shrink-0'); ?>
                        <a href="mailto:info@example.com" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">info@example.com</a>
                    </li>
                </ul>
            </div>

        </div>

        <!-- نوار پایین -->
        <div class="border-t border-gray-200 dark:border-gray-700 pt-8 text-center">
            <p class="text-gray-600 dark:text-gray-400 text-sm">
                &copy; <?php echo date('Y'); ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                    <?php bloginfo('name'); ?>
                </a>
                - تمامی حقوق محفوظ است.
            </p>
        </div>

    </div>
</footer>
