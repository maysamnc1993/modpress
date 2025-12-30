<?php
/**
 * فوتر تیره
 * تم تیره با پس‌زمینه مشکی
 */
?>
<footer class="bg-gray-900 text-white py-12" dir="rtl">
    <div class="hf-container max-w-7xl mx-auto px-4">

        <!-- بخش بالا -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">

            <!-- برند -->
            <div class="lg:col-span-1">
                <?php if (has_custom_logo()): ?>
                    <div class="mb-4 brightness-0 invert">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else: ?>
                    <h3 class="text-xl font-bold mb-4">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-primary-400 transition-colors">
                            <?php bloginfo('name'); ?>
                        </a>
                    </h3>
                <?php endif; ?>
                <p class="text-gray-400 text-sm leading-relaxed mb-6">
                    <?php echo get_bloginfo('description'); ?>
                </p>

                <!-- شبکه‌های اجتماعی -->
                <div class="hf-social-icons flex gap-3">
                    <a href="#" class="w-10 h-10 rounded-lg bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-primary-600 hover:text-white transition-all" aria-label="اینستاگرام">
                        <?php echo dst_get_icon('instagram', 'w-5 h-5'); ?>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-lg bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-primary-600 hover:text-white transition-all" aria-label="تلگرام">
                        <?php echo dst_get_icon('telegram', 'w-5 h-5'); ?>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-lg bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-primary-600 hover:text-white transition-all" aria-label="واتساپ">
                        <?php echo dst_get_icon('whatsapp', 'w-5 h-5'); ?>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-lg bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-primary-600 hover:text-white transition-all" aria-label="لینکدین">
                        <?php echo dst_get_icon('linkedin', 'w-5 h-5'); ?>
                    </a>
                </div>
            </div>

            <!-- لینک‌های سریع -->
            <div>
                <h4 class="text-lg font-bold mb-4">لینک‌های سریع</h4>
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
                    <h4 class="text-lg font-bold mb-4">فروشگاه</h4>
                    <ul class="hf-footer-menu space-y-2">
                        <li><a href="<?php echo esc_url(dst_get_shop_url()); ?>" class="text-gray-400 hover:text-white transition-colors">محصولات</a></li>
                        <li><a href="<?php echo esc_url(dst_get_cart_url()); ?>" class="text-gray-400 hover:text-white transition-colors">سبد خرید</a></li>
                        <li><a href="<?php echo esc_url(dst_get_checkout_url()); ?>" class="text-gray-400 hover:text-white transition-colors">تسویه حساب</a></li>
                        <li><a href="<?php echo esc_url(dst_get_account_url()); ?>" class="text-gray-400 hover:text-white transition-colors">حساب کاربری</a></li>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- تماس -->
            <div>
                <h4 class="text-lg font-bold mb-4">تماس با ما</h4>
                <ul class="space-y-3">
                    <li class="flex items-start gap-3 text-gray-400">
                        <?php echo dst_get_icon('phone', 'w-5 h-5 mt-0.5 flex-shrink-0'); ?>
                        <a href="tel:+982112345678" class="hover:text-white transition-colors">021-12345678</a>
                    </li>
                    <li class="flex items-start gap-3 text-gray-400">
                        <?php echo dst_get_icon('mail', 'w-5 h-5 mt-0.5 flex-shrink-0'); ?>
                        <a href="mailto:info@example.com" class="hover:text-white transition-colors">info@example.com</a>
                    </li>
                    <li class="flex items-start gap-3 text-gray-400">
                        <?php echo dst_get_icon('location', 'w-5 h-5 mt-0.5 flex-shrink-0'); ?>
                        <span>تهران، ایران</span>
                    </li>
                </ul>
            </div>

        </div>

        <!-- نوار پایین -->
        <div class="border-t border-gray-800 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-400 text-sm">
                    &copy; <?php echo date('Y'); ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-white transition-colors">
                        <?php bloginfo('name'); ?>
                    </a>
                    - تمامی حقوق محفوظ است.
                </p>
                <p class="text-gray-500 text-sm">
                    طراحی شده با <span class="text-red-500">♥</span> در ایران
                </p>
            </div>
        </div>

    </div>
</footer>
