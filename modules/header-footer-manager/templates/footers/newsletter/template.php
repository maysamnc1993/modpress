<?php
/**
 * فوتر خبرنامه
 * با فرم عضویت خبرنامه
 */
?>
<footer class="bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800" dir="rtl">

    <!-- بخش خبرنامه -->
    <div class="bg-primary-600 text-white py-12">
        <div class="hf-container max-w-4xl mx-auto px-4 text-center">
            <h3 class="text-2xl md:text-3xl font-bold mb-4">عضویت در خبرنامه</h3>
            <p class="text-primary-100 mb-8 max-w-2xl mx-auto">
                با عضویت در خبرنامه ما، از آخرین اخبار، تخفیف‌ها و محصولات جدید مطلع شوید
            </p>

            <!-- فرم خبرنامه با Alpine.js -->
            <div class="max-w-md mx-auto" x-data="newsletter">
                <form @submit.prevent="subscribe" class="hf-newsletter-form">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <input
                            type="email"
                            x-model="email"
                            :disabled="loading"
                            required
                            placeholder="ایمیل خود را وارد کنید"
                            class="hf-newsletter-input flex-1 px-4 py-3 rounded-lg bg-white text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-white/50"
                        >
                        <button
                            type="submit"
                            :disabled="loading"
                            class="hf-btn hf-btn-secondary px-8 py-3 rounded-lg bg-white text-primary-600 font-bold hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed transition-all"
                        >
                            <span x-show="!loading">عضویت</span>
                            <span x-show="loading" class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>در حال ارسال...</span>
                            </span>
                        </button>
                    </div>

                    <!-- پیام -->
                    <div x-show="message" x-transition class="mt-4">
                        <p :class="success ? 'text-green-100' : 'text-red-100'" class="text-sm" x-text="message"></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- بخش اصلی فوتر -->
    <div class="py-12">
        <div class="hf-container max-w-7xl mx-auto px-4">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">

                <!-- درباره -->
                <div>
                    <?php if (has_custom_logo()): ?>
                        <div class="mb-4">
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

                <!-- لینک‌های سریع -->
                <div>
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
                </div>

                <!-- فروشگاه -->
                <?php if (dst_is_woocommerce_active()): ?>
                    <div>
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
                <div>
                    <h4 class="hf-footer-widget-title text-lg font-bold text-gray-800 dark:text-white mb-4">تماس با ما</h4>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3 text-gray-600 dark:text-gray-400">
                            <?php echo dst_get_icon('mail', 'w-5 h-5 mt-0.5 flex-shrink-0'); ?>
                            <a href="mailto:info@example.com" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">info@example.com</a>
                        </li>
                        <li class="flex items-start gap-3 text-gray-600 dark:text-gray-400">
                            <?php echo dst_get_icon('phone', 'w-5 h-5 mt-0.5 flex-shrink-0'); ?>
                            <a href="tel:+982112345678" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">021-12345678</a>
                        </li>
                    </ul>
                </div>

            </div>

            <!-- نوار پایین -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    &copy; <?php echo date('Y'); ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                        <?php bloginfo('name'); ?>
                    </a>
                </p>

                <!-- شبکه‌های اجتماعی -->
                <div class="hf-social-icons flex gap-3">
                    <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors" aria-label="اینستاگرام">
                        <?php echo dst_get_icon('instagram', 'w-6 h-6'); ?>
                    </a>
                    <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors" aria-label="تلگرام">
                        <?php echo dst_get_icon('telegram', 'w-6 h-6'); ?>
                    </a>
                    <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors" aria-label="واتساپ">
                        <?php echo dst_get_icon('whatsapp', 'w-6 h-6'); ?>
                    </a>
                </div>
            </div>

        </div>
    </div>
</footer>
