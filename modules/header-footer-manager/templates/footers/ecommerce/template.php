<?php
/**
 * فوتر فروشگاهی
 * لینک‌های فروشگاهی و پشتیبانی
 */
?>
<footer class="bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800" dir="rtl">

    <!-- بنر ویژگی‌ها -->
    <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 py-8">
        <div class="hf-container max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div>
                        <h5 class="font-bold text-gray-800 dark:text-white">ارسال سریع و رایگان</h5>
                        <p class="text-sm text-gray-600 dark:text-gray-400">برای خرید بالای 500 هزار تومان</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <h5 class="font-bold text-gray-800 dark:text-white">ضمانت اصل بودن کالا</h5>
                        <p class="text-sm text-gray-600 dark:text-gray-400">100% اصل و گارانتی معتبر</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                        </svg>
                    </div>
                    <div>
                        <h5 class="font-bold text-gray-800 dark:text-white">7 روز ضمانت بازگشت</h5>
                        <p class="text-sm text-gray-600 dark:text-gray-400">بدون هیچ شرطی</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <h5 class="font-bold text-gray-800 dark:text-white">پشتیبانی 24/7</h5>
                        <p class="text-sm text-gray-600 dark:text-gray-400">تماس و چت آنلاین</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- بخش اصلی -->
    <div class="py-12">
        <div class="hf-container max-w-7xl mx-auto px-4">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">

                <!-- درباره فروشگاه -->
                <div class="lg:col-span-2">
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
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed mb-6">
                        <?php echo get_bloginfo('description'); ?>
                    </p>

                    <!-- روش‌های پرداخت -->
                    <div>
                        <h5 class="text-sm font-bold text-gray-800 dark:text-white mb-3">روش‌های پرداخت</h5>
                        <div class="flex flex-wrap gap-2">
                            <div class="px-3 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded text-xs font-medium text-gray-700 dark:text-gray-300">
                                💳 کارت بانکی
                            </div>
                            <div class="px-3 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded text-xs font-medium text-gray-700 dark:text-gray-300">
                                🏧 درگاه بانکی
                            </div>
                            <div class="px-3 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded text-xs font-medium text-gray-700 dark:text-gray-300">
                                💰 پرداخت در محل
                            </div>
                        </div>
                    </div>
                </div>

                <!-- خرید -->
                <?php if (dst_is_woocommerce_active()): ?>
                    <div>
                        <h4 class="hf-footer-widget-title text-lg font-bold text-gray-800 dark:text-white mb-4">خرید</h4>
                        <ul class="hf-footer-menu space-y-2">
                            <li><a href="<?php echo esc_url(dst_get_shop_url()); ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">محصولات</a></li>
                            <li><a href="<?php echo esc_url(dst_get_cart_url()); ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">سبد خرید</a></li>
                            <li><a href="<?php echo esc_url(dst_get_checkout_url()); ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">تسویه حساب</a></li>
                            <li><a href="<?php echo esc_url(dst_get_account_url()); ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">حساب کاربری</a></li>
                            <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">پیگیری سفارش</a></li>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- خدمات مشتریان -->
                <div>
                    <h4 class="hf-footer-widget-title text-lg font-bold text-gray-800 dark:text-white mb-4">خدمات مشتریان</h4>
                    <ul class="hf-footer-menu space-y-2">
                        <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">سوالات متداول</a></li>
                        <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">راهنمای خرید</a></li>
                        <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">رویه بازگشت کالا</a></li>
                        <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">شرایط استفاده</a></li>
                        <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">حریم خصوصی</a></li>
                    </ul>
                </div>

                <!-- ارتباط با ما -->
                <div>
                    <h4 class="hf-footer-widget-title text-lg font-bold text-gray-800 dark:text-white mb-4">ارتباط با ما</h4>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-start gap-3 text-gray-600 dark:text-gray-400">
                            <?php echo dst_get_icon('phone', 'w-5 h-5 mt-0.5 flex-shrink-0 text-primary-600'); ?>
                            <div>
                                <div class="font-medium text-gray-800 dark:text-white">پشتیبانی فروش</div>
                                <a href="tel:+982112345678" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">021-12345678</a>
                            </div>
                        </li>
                        <li class="flex items-start gap-3 text-gray-600 dark:text-gray-400">
                            <?php echo dst_get_icon('mail', 'w-5 h-5 mt-0.5 flex-shrink-0 text-primary-600'); ?>
                            <div>
                                <div class="font-medium text-gray-800 dark:text-white">ایمیل</div>
                                <a href="mailto:support@example.com" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">support@example.com</a>
                            </div>
                        </li>
                        <li class="flex items-start gap-3 text-gray-600 dark:text-gray-400">
                            <?php echo dst_get_icon('location', 'w-5 h-5 mt-0.5 flex-shrink-0 text-primary-600'); ?>
                            <div>
                                <div class="font-medium text-gray-800 dark:text-white">آدرس</div>
                                <span>تهران، خیابان ولیعصر</span>
                            </div>
                        </li>
                    </ul>

                    <!-- شبکه‌های اجتماعی -->
                    <div class="hf-social-icons flex gap-2">
                        <a href="#" class="w-10 h-10 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:border-primary-600 hover:text-primary-600 dark:hover:text-primary-400 transition-all" aria-label="اینستاگرام">
                            <?php echo dst_get_icon('instagram', 'w-5 h-5'); ?>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:border-primary-600 hover:text-primary-600 dark:hover:text-primary-400 transition-all" aria-label="تلگرام">
                            <?php echo dst_get_icon('telegram', 'w-5 h-5'); ?>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:border-primary-600 hover:text-primary-600 dark:hover:text-primary-400 transition-all" aria-label="واتساپ">
                            <?php echo dst_get_icon('whatsapp', 'w-5 h-5'); ?>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- نوار پایین -->
    <div class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 py-6">
        <div class="hf-container max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-600 dark:text-gray-400 text-sm text-center md:text-right">
                    &copy; <?php echo date('Y'); ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="font-medium hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                        <?php bloginfo('name'); ?>
                    </a>
                    - تمامی حقوق محفوظ است.
                </p>

                <!-- لینک‌های قانونی -->
                <div class="flex flex-wrap justify-center gap-4 text-sm">
                    <a href="#" class="text-gray-500 dark:text-gray-500 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">شرایط و قوانین</a>
                    <a href="#" class="text-gray-500 dark:text-gray-500 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">حریم خصوصی</a>
                    <a href="#" class="text-gray-500 dark:text-gray-500 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">درباره ما</a>
                    <a href="#" class="text-gray-500 dark:text-gray-500 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">تماس با ما</a>
                </div>
            </div>
        </div>
    </div>

</footer>
