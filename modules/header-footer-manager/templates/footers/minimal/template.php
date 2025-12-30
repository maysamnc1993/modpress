<?php
/**
 * فوتر مینیمال
 * ساده یک خطی
 */
?>
<footer class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 py-6" dir="rtl">
    <div class="hf-container max-w-7xl mx-auto px-4">

        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">

            <!-- کپی‌رایت -->
            <p class="text-gray-600 dark:text-gray-400 text-sm text-center sm:text-right">
                &copy; <?php echo date('Y'); ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="font-medium hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                    <?php bloginfo('name'); ?>
                </a>
            </p>

            <!-- شبکه‌های اجتماعی -->
            <div class="hf-social-icons flex gap-4">
                <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors" aria-label="اینستاگرام">
                    <?php echo dst_get_icon('instagram', 'w-5 h-5'); ?>
                </a>
                <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors" aria-label="تلگرام">
                    <?php echo dst_get_icon('telegram', 'w-5 h-5'); ?>
                </a>
                <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors" aria-label="واتساپ">
                    <?php echo dst_get_icon('whatsapp', 'w-5 h-5'); ?>
                </a>
                <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors" aria-label="لینکدین">
                    <?php echo dst_get_icon('linkedin', 'w-5 h-5'); ?>
                </a>
            </div>

            <!-- لینک‌های سریع -->
            <?php if (dst_is_woocommerce_active()): ?>
                <div class="flex gap-4 text-sm">
                    <a href="<?php echo esc_url(dst_get_shop_url()); ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">فروشگاه</a>
                    <a href="<?php echo esc_url(dst_get_cart_url()); ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">سبد خرید</a>
                    <a href="<?php echo esc_url(dst_get_account_url()); ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">حساب کاربری</a>
                </div>
            <?php endif; ?>

        </div>

    </div>
</footer>
