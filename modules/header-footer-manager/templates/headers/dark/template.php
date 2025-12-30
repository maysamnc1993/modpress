<?php
/**
 * Header Template: Dark
 * هدر با تم تیره - Dark Mode
 */

defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$is_sticky = $settings['sticky'] ?? true;
$show_search = $settings['show_search'] ?? true;
$show_cart = $settings['show_cart'] ?? true;
$show_account = $settings['show_account'] ?? true;
$bg_color = $settings['bg_color'] ?? '#1a1a1a';
?>

<header
    x-data="header"
    :class="{
        'shadow-lg shadow-black/20': isScrolled,
        '-translate-y-full': isHidden && isScrolled
    }"
    class="<?php echo $is_sticky ? 'hf-header-sticky' : 'relative'; ?> bg-secondary-900 text-white transition-all duration-300"
    style="background-color: <?php echo esc_attr($bg_color); ?>;"
>
    <!-- Top Bar -->
    <div class="bg-black/30 py-2 text-sm hidden lg:block">
        <div class="hf-container">
            <div class="flex items-center justify-between text-secondary-300">
                <div class="flex items-center gap-6">
                    <span class="flex items-center gap-2">
                        <?php echo dst_get_icon('truck', 'w-4 h-4'); ?>
                        <span>ارسال رایگان برای خرید بالای 500 هزار تومان</span>
                    </span>
                </div>
                <div class="flex items-center gap-4">
                    <?php if ($phone = get_option('dst_phone')): ?>
                        <a href="tel:<?php echo esc_attr($phone); ?>" class="flex items-center gap-1 hover:text-primary-400 transition-colors">
                            <?php echo dst_get_icon('phone', 'w-4 h-4'); ?>
                            <span><?php echo esc_html($phone); ?></span>
                        </a>
                    <?php endif; ?>
                    <?php if ($email = get_option('dst_email')): ?>
                        <a href="mailto:<?php echo esc_attr($email); ?>" class="flex items-center gap-1 hover:text-primary-400 transition-colors">
                            <?php echo dst_get_icon('mail', 'w-4 h-4'); ?>
                            <span><?php echo esc_html($email); ?></span>
                        </a>
                    <?php endif; ?>
                    <div class="flex items-center gap-2 border-r rtl:border-r-0 rtl:border-l border-secondary-700 pr-4 rtl:pr-0 rtl:pl-4">
                        <?php if ($instagram = get_option('dst_instagram')): ?>
                            <a href="<?php echo esc_url($instagram); ?>" target="_blank" class="hover:text-primary-400 transition-colors">
                                <?php echo dst_get_icon('instagram', 'w-4 h-4'); ?>
                            </a>
                        <?php endif; ?>
                        <?php if ($telegram = get_option('dst_telegram')): ?>
                            <a href="<?php echo esc_url($telegram); ?>" target="_blank" class="hover:text-primary-400 transition-colors">
                                <?php echo dst_get_icon('telegram', 'w-4 h-4'); ?>
                            </a>
                        <?php endif; ?>
                        <?php if ($whatsapp = get_option('dst_whatsapp')): ?>
                            <a href="<?php echo esc_url($whatsapp); ?>" target="_blank" class="hover:text-primary-400 transition-colors">
                                <?php echo dst_get_icon('whatsapp', 'w-4 h-4'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="hf-container">
        <div class="flex items-center justify-between h-20 border-b border-secondary-800">

            <!-- Logo -->
            <div class="flex-shrink-0">
                <?php dst_the_logo('light', 'h-10 w-auto max-w-[180px] object-contain'); ?>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex items-center gap-1">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'hf-nav-menu dark-mode',
                    'fallback_cb' => false,
                    'depth' => 3,
                ]);
                ?>
            </nav>

            <!-- Header Actions -->
            <div class="flex items-center gap-2">

                <!-- Search -->
                <?php if ($show_search): ?>
                    <div class="relative hidden md:block" x-data="{ searchOpen: false }">
                        <button
                            @click="searchOpen = !searchOpen"
                            class="hf-icon-btn text-secondary-300 hover:text-white hover:bg-secondary-800"
                            aria-label="جستجو"
                        >
                            <?php echo dst_get_icon('search'); ?>
                        </button>

                        <div
                            x-show="searchOpen"
                            x-transition
                            @click.outside="searchOpen = false"
                            class="absolute top-full left-0 rtl:left-auto rtl:right-0 mt-2 w-80"
                        >
                            <div class="bg-secondary-800 p-4 rounded-lg shadow-xl border border-secondary-700">
                                <?php echo dst_product_search_form(); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Wishlist -->
                <?php if (function_exists('YITH_WCWL')): ?>
                    <a href="<?php echo YITH_WCWL()->get_wishlist_url(); ?>" class="hf-icon-btn text-secondary-300 hover:text-white hover:bg-secondary-800 hidden md:flex relative" aria-label="علاقه‌مندی‌ها">
                        <?php echo dst_get_icon('heart'); ?>
                        <?php
                        $wishlist_count = YITH_WCWL()->count_products();
                        if ($wishlist_count > 0):
                        ?>
                            <span class="hf-badge hf-badge-primary"><?php echo $wishlist_count; ?></span>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>

                <!-- Cart -->
                <?php if ($show_cart && dst_is_woocommerce_active()): ?>
                    <div class="relative" x-data="miniCart">
                        <button @click="toggle()" class="hf-cart-icon hf-icon-btn text-secondary-300 hover:text-white hover:bg-secondary-800">
                            <?php echo dst_get_icon('cart'); ?>
                            <?php if (dst_get_cart_count() > 0): ?>
                                <span class="hf-badge hf-badge-primary"><?php echo dst_get_cart_count(); ?></span>
                            <?php endif; ?>
                        </button>
                        <?php echo dst_mini_cart(); ?>
                    </div>
                <?php endif; ?>

                <!-- Account -->
                <?php if ($show_account): ?>
                    <div class="relative hidden md:block" x-data="{ accountOpen: false }">
                        <button 
                            @click="accountOpen = !accountOpen"
                            class="hf-icon-btn text-secondary-300 hover:text-white hover:bg-secondary-800"
                            aria-label="حساب کاربری"
                        >
                            <?php echo dst_get_icon('user'); ?>
                        </button>

                        <div
                            x-show="accountOpen"
                            x-transition
                            @click.outside="accountOpen = false"
                            class="absolute top-full left-0 rtl:left-auto rtl:right-0 mt-2 w-56 bg-secondary-800 rounded-lg shadow-xl border border-secondary-700 z-50"
                        >
                            <?php if (is_user_logged_in()): ?>
                                <div class="p-4 border-b border-secondary-700">
                                    <div class="flex items-center gap-3">
                                        <?php echo get_avatar(get_current_user_id(), 40, '', '', ['class' => 'rounded-full']); ?>
                                        <div>
                                            <div class="font-semibold text-white text-sm"><?php echo wp_get_current_user()->display_name; ?></div>
                                            <div class="text-xs text-secondary-400"><?php echo wp_get_current_user()->user_email; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-2">
                                    <a href="<?php echo dst_get_account_url(); ?>" class="block px-4 py-2 text-sm text-secondary-300 hover:bg-secondary-700 hover:text-white transition-colors">حساب کاربری من</a>
                                    <a href="<?php echo wc_get_endpoint_url('orders', '', dst_get_account_url()); ?>" class="block px-4 py-2 text-sm text-secondary-300 hover:bg-secondary-700 hover:text-white transition-colors">سفارش‌های من</a>
                                    <a href="<?php echo wp_logout_url(home_url()); ?>" class="block px-4 py-2 text-sm text-red-400 hover:bg-secondary-700 hover:text-red-300 transition-colors">خروج</a>
                                </div>
                            <?php else: ?>
                                <div class="p-4">
                                    <a href="<?php echo dst_get_account_url(); ?>" class="hf-btn hf-btn-primary w-full text-sm">ورود / ثبت نام</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Mobile Menu Toggle -->
                <button
                    @click="toggleMobileMenu()"
                    class="lg:hidden hf-icon-btn text-secondary-300 hover:text-white"
                    :class="{ 'text-primary-400': isMobileMenuOpen }"
                    aria-label="منو"
                >
                    <div class="hf-hamburger dark-mode" :class="{ 'is-active': isMobileMenuOpen }">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div
        class="hf-mobile-menu-overlay lg:hidden"
        :class="{ 'is-open': isMobileMenuOpen }"
        @click="closeMobileMenu()"
    ></div>

    <div 
        class="hf-mobile-menu lg:hidden bg-secondary-900 text-white"
        :class="{ 'is-open': isMobileMenuOpen }"
    >
        <div class="flex items-center justify-between p-4 border-b border-secondary-800 bg-black/30">
            <span class="text-lg font-bold">منو</span>
            <button @click="closeMobileMenu()" class="hf-icon-btn text-secondary-300 hover:text-white">
                <?php echo dst_get_icon('close'); ?>
            </button>
        </div>

        <?php if ($show_search): ?>
            <div class="p-4 border-b border-secondary-800">
                <?php echo dst_product_search_form(); ?>
            </div>
        <?php endif; ?>

        <nav class="p-4">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container' => false,
                'menu_class' => 'space-y-2',
                'fallback_cb' => false,
                'depth' => 2,
                'walker' => class_exists('DST_Mobile_Menu_Walker') ? new DST_Mobile_Menu_Walker() : null,
            ]);
            ?>
        </nav>

        <div class="p-4 border-t border-secondary-800 mt-auto">
            <div class="grid grid-cols-2 gap-3">
                <?php if ($show_cart && dst_is_woocommerce_active()): ?>
                    <a href="<?php echo dst_get_cart_url(); ?>" class="hf-btn hf-btn-primary">
                        <?php echo dst_get_icon('cart', 'w-5 h-5'); ?>
                        <span>سبد خرید</span>
                        <?php if (dst_get_cart_count() > 0): ?>
                            <span class="hf-badge bg-white text-primary-600"><?php echo dst_get_cart_count(); ?></span>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>

                <?php if ($show_account): ?>
                    <a href="<?php echo dst_get_account_url(); ?>" class="hf-btn bg-secondary-800 text-white hover:bg-secondary-700 border-secondary-700">
                        <?php echo dst_get_icon('user', 'w-5 h-5'); ?>
                        <span><?php echo is_user_logged_in() ? 'حساب من' : 'ورود'; ?></span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>
