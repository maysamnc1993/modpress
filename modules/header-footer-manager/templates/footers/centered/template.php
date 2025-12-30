<?php
/**
 * فوتر متمرکز
 * محتوا در مرکز
 */
?>
<footer class="bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 py-12" dir="rtl">
    <div class="hf-container max-w-4xl mx-auto px-4">

        <div class="text-center">

            <!-- لوگو -->
            <div class="mb-6">
                <?php if (has_custom_logo()): ?>
                    <div class="flex justify-center">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else: ?>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white">
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <?php bloginfo('name'); ?>
                        </a>
                    </h3>
                <?php endif; ?>
            </div>

            <!-- توضیحات -->
            <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-2xl mx-auto leading-relaxed">
                <?php echo get_bloginfo('description'); ?>
            </p>

            <!-- منو -->
            <div class="mb-8">
                <?php
                wp_nav_menu([
                    'theme_location' => 'footer',
                    'container'      => false,
                    'menu_class'     => 'flex flex-wrap justify-center gap-6 text-sm',
                    'fallback_cb'    => false,
                    'depth'          => 1,
                    'link_before'    => '',
                    'link_after'     => '',
                    'walker'         => null,
                ]);
                ?>
            </div>

            <!-- لینک‌های فروشگاه -->
            <?php if (dst_is_woocommerce_active()): ?>
                <div class="mb-8">
                    <div class="flex flex-wrap justify-center gap-6 text-sm">
                        <a href="<?php echo esc_url(dst_get_shop_url()); ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors font-medium">فروشگاه</a>
                        <a href="<?php echo esc_url(dst_get_cart_url()); ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors font-medium">سبد خرید</a>
                        <a href="<?php echo esc_url(dst_get_checkout_url()); ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors font-medium">تسویه حساب</a>
                        <a href="<?php echo esc_url(dst_get_account_url()); ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors font-medium">حساب کاربری</a>
                    </div>
                </div>
            <?php endif; ?>

            <!-- شبکه‌های اجتماعی -->
            <div class="hf-social-icons flex justify-center gap-4 mb-8">
                <a href="#" class="w-12 h-12 rounded-full bg-gray-200 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-primary-600 hover:text-white transition-all transform hover:scale-110" aria-label="اینستاگرام">
                    <?php echo dst_get_icon('instagram', 'w-5 h-5'); ?>
                </a>
                <a href="#" class="w-12 h-12 rounded-full bg-gray-200 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-primary-600 hover:text-white transition-all transform hover:scale-110" aria-label="تلگرام">
                    <?php echo dst_get_icon('telegram', 'w-5 h-5'); ?>
                </a>
                <a href="#" class="w-12 h-12 rounded-full bg-gray-200 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-primary-600 hover:text-white transition-all transform hover:scale-110" aria-label="واتساپ">
                    <?php echo dst_get_icon('whatsapp', 'w-5 h-5'); ?>
                </a>
                <a href="#" class="w-12 h-12 rounded-full bg-gray-200 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-primary-600 hover:text-white transition-all transform hover:scale-110" aria-label="یوتیوب">
                    <?php echo dst_get_icon('youtube', 'w-5 h-5'); ?>
                </a>
            </div>

            <!-- کپی‌رایت -->
            <p class="text-gray-500 dark:text-gray-500 text-sm">
                &copy; <?php echo date('Y'); ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="font-medium hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                    <?php bloginfo('name'); ?>
                </a>
                - تمامی حقوق محفوظ است.
            </p>

        </div>

    </div>
</footer>
