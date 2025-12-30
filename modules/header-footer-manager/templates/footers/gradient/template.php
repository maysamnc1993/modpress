<?php
/**
 * فوتر گرادیانت
 * با گرادیان پس‌زمینه
 */
?>
<footer class="relative bg-gradient-to-br from-primary-600 via-purple-600 to-pink-600 text-white py-16 overflow-hidden" dir="rtl">

    <!-- پترن پس‌زمینه -->
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;1&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

    <div class="hf-container max-w-7xl mx-auto px-4 relative z-10">

        <!-- بخش بالا -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">

            <!-- برند -->
            <div class="lg:col-span-1">
                <?php if (has_custom_logo()): ?>
                    <div class="mb-4 brightness-0 invert">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else: ?>
                    <h3 class="text-2xl font-bold mb-4">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:opacity-80 transition-opacity">
                            <?php bloginfo('name'); ?>
                        </a>
                    </h3>
                <?php endif; ?>
                <p class="text-white/80 leading-relaxed">
                    <?php echo get_bloginfo('description'); ?>
                </p>
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
                        <li><a href="<?php echo esc_url(dst_get_shop_url()); ?>" class="text-white/80 hover:text-white transition-colors">محصولات</a></li>
                        <li><a href="<?php echo esc_url(dst_get_cart_url()); ?>" class="text-white/80 hover:text-white transition-colors">سبد خرید</a></li>
                        <li><a href="<?php echo esc_url(dst_get_checkout_url()); ?>" class="text-white/80 hover:text-white transition-colors">تسویه حساب</a></li>
                        <li><a href="<?php echo esc_url(dst_get_account_url()); ?>" class="text-white/80 hover:text-white transition-colors">حساب کاربری</a></li>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- ارتباط -->
            <div>
                <h4 class="text-lg font-bold mb-4">ارتباط با ما</h4>
                <ul class="space-y-3">
                    <li class="flex items-start gap-3 text-white/80">
                        <?php echo dst_get_icon('phone', 'w-5 h-5 mt-0.5 flex-shrink-0'); ?>
                        <a href="tel:+982112345678" class="hover:text-white transition-colors">021-12345678</a>
                    </li>
                    <li class="flex items-start gap-3 text-white/80">
                        <?php echo dst_get_icon('mail', 'w-5 h-5 mt-0.5 flex-shrink-0'); ?>
                        <a href="mailto:info@example.com" class="hover:text-white transition-colors">info@example.com</a>
                    </li>
                </ul>

                <!-- شبکه‌های اجتماعی -->
                <div class="hf-social-icons flex gap-3 mt-6">
                    <a href="#" class="w-10 h-10 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center hover:bg-white/30 transition-all" aria-label="اینستاگرام">
                        <?php echo dst_get_icon('instagram', 'w-5 h-5'); ?>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center hover:bg-white/30 transition-all" aria-label="تلگرام">
                        <?php echo dst_get_icon('telegram', 'w-5 h-5'); ?>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center hover:bg-white/30 transition-all" aria-label="واتساپ">
                        <?php echo dst_get_icon('whatsapp', 'w-5 h-5'); ?>
                    </a>
                </div>
            </div>

        </div>

        <!-- نوار پایین -->
        <div class="border-t border-white/20 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-white/80 text-sm text-center md:text-right">
                    &copy; <?php echo date('Y'); ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="font-medium hover:text-white transition-colors">
                        <?php bloginfo('name'); ?>
                    </a>
                    - تمامی حقوق محفوظ است.
                </p>
                <div class="flex items-center gap-2 text-white/60 text-sm">
                    <span>طراحی شده با</span>
                    <span class="text-red-300 animate-pulse">♥</span>
                    <span>در ایران</span>
                </div>
            </div>
        </div>

    </div>
</footer>
