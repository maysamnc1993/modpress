<?php
/**
 * مگا فوتر
 * چند بخشی بزرگ
 */
?>
<footer class="bg-gray-900 text-white" dir="rtl">

    <!-- بخش بالا -->
    <div class="bg-gray-800 py-12">
        <div class="hf-container max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">

                <!-- درباره ما -->
                <div class="lg:col-span-2">
                    <?php if (has_custom_logo()): ?>
                        <div class="mb-4 brightness-0 invert">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php else: ?>
                        <h3 class="text-2xl font-bold mb-4">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-primary-400 transition-colors">
                                <?php bloginfo('name'); ?>
                            </a>
                        </h3>
                    <?php endif; ?>
                    <p class="text-gray-400 leading-relaxed mb-6">
                        <?php echo get_bloginfo('description'); ?>
                    </p>

                    <!-- اطلاعات تماس -->
                    <div class="space-y-3">
                        <div class="flex items-start gap-3 text-gray-300">
                            <?php echo dst_get_icon('location', 'w-5 h-5 mt-0.5 flex-shrink-0 text-primary-400'); ?>
                            <span>تهران، خیابان ولیعصر، پلاک 123</span>
                        </div>
                        <div class="flex items-start gap-3 text-gray-300">
                            <?php echo dst_get_icon('phone', 'w-5 h-5 mt-0.5 flex-shrink-0 text-primary-400'); ?>
                            <a href="tel:+982112345678" class="hover:text-white transition-colors">021-12345678</a>
                        </div>
                        <div class="flex items-start gap-3 text-gray-300">
                            <?php echo dst_get_icon('mail', 'w-5 h-5 mt-0.5 flex-shrink-0 text-primary-400'); ?>
                            <a href="mailto:info@example.com" class="hover:text-white transition-colors">info@example.com</a>
                        </div>
                    </div>
                </div>

                <!-- لینک‌های سریع -->
                <div>
                    <h4 class="text-lg font-bold mb-4 border-b border-gray-700 pb-2">لینک‌های سریع</h4>
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
                        <h4 class="text-lg font-bold mb-4 border-b border-gray-700 pb-2">فروشگاه</h4>
                        <ul class="hf-footer-menu space-y-2">
                            <li><a href="<?php echo esc_url(dst_get_shop_url()); ?>" class="text-gray-400 hover:text-white transition-colors">محصولات</a></li>
                            <li><a href="<?php echo esc_url(dst_get_cart_url()); ?>" class="text-gray-400 hover:text-white transition-colors">سبد خرید</a></li>
                            <li><a href="<?php echo esc_url(dst_get_checkout_url()); ?>" class="text-gray-400 hover:text-white transition-colors">تسویه حساب</a></li>
                            <li><a href="<?php echo esc_url(dst_get_account_url()); ?>" class="text-gray-400 hover:text-white transition-colors">حساب کاربری</a></li>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- خدمات مشتریان -->
                <div>
                    <h4 class="text-lg font-bold mb-4 border-b border-gray-700 pb-2">خدمات مشتریان</h4>
                    <ul class="hf-footer-menu space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">سوالات متداول</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">راهنمای خرید</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">رویه بازگشت کالا</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">شرایط استفاده</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">حریم خصوصی</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <!-- بخش میانی - ویژگی‌ها -->
    <div class="bg-gray-850 border-y border-gray-800 py-8">
        <div class="hf-container max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <div class="flex items-center gap-4 bg-gray-800 p-4 rounded-lg">
                    <div class="w-12 h-12 rounded-full bg-primary-600 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                    </div>
                    <div>
                        <h5 class="font-bold mb-1">ارسال رایگان</h5>
                        <p class="text-sm text-gray-400">برای خرید بالای 500 هزار تومان</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 bg-gray-800 p-4 rounded-lg">
                    <div class="w-12 h-12 rounded-full bg-primary-600 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <h5 class="font-bold mb-1">پرداخت امن</h5>
                        <p class="text-sm text-gray-400">با تضمین بازگشت وجه</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 bg-gray-800 p-4 rounded-lg">
                    <div class="w-12 h-12 rounded-full bg-primary-600 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                        </svg>
                    </div>
                    <div>
                        <h5 class="font-bold mb-1">7 روز ضمانت بازگشت</h5>
                        <p class="text-sm text-gray-400">بازگشت کالا تا 7 روز</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 bg-gray-800 p-4 rounded-lg">
                    <div class="w-12 h-12 rounded-full bg-primary-600 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <h5 class="font-bold mb-1">پشتیبانی 24/7</h5>
                        <p class="text-sm text-gray-400">همیشه در خدمت شما</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- بخش پایین -->
    <div class="bg-gray-900 py-6">
        <div class="hf-container max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">

                <!-- کپی‌رایت -->
                <p class="text-gray-400 text-sm">
                    &copy; <?php echo date('Y'); ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-white transition-colors">
                        <?php bloginfo('name'); ?>
                    </a>
                    - تمامی حقوق محفوظ است.
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
                    <a href="#" class="w-10 h-10 rounded-lg bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-primary-600 hover:text-white transition-all" aria-label="یوتیوب">
                        <?php echo dst_get_icon('youtube', 'w-5 h-5'); ?>
                    </a>
                </div>

            </div>
        </div>
    </div>

</footer>
