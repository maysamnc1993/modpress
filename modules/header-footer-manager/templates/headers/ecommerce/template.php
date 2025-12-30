<?php
/**
 * Header Template: Ecommerce
 * هدر فروشگاهی حرفه‌ای
 */

defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$is_sticky = $settings['sticky'] ?? true;
$show_search = $settings['show_search'] ?? true;
$show_cart = $settings['show_cart'] ?? true;
$show_account = $settings['show_account'] ?? true;
$bg_color = $settings['bg_color'] ?? '#ffffff';
?>

<header
    x-data="header"
    :class="{
        'shadow-md': isScrolled,
        '-translate-y-full': isHidden && isScrolled
    }"
    class="<?php echo $is_sticky ? 'hf-header-sticky' : 'relative bg-white'; ?> transition-all duration-300"
    style="background-color: <?php echo esc_attr($bg_color); ?>;"
>
    <!-- Top Bar -->
    <div class="bg-secondary-800 text-white py-2 text-sm hidden lg:block">
        <div class="hf-container">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-6">
                    <span class="flex items-center gap-2">
                        <?php echo dst_get_icon('truck', 'w-4 h-4'); ?>
                        <span>ارسال رایگان برای خرید بالای 500 هزار تومان</span>
                    </span>
                    <span class="flex items-center gap-2">
                        <?php echo dst_get_icon('shield-check', 'w-4 h-4'); ?>
                        <span>ضمانت اصالت کالا</span>
                    </span>
                </div>
                <div class="flex items-center gap-4">
                    <?php if ($phone = get_option('dst_phone')): ?>
                        <a href="tel:<?php echo esc_attr($phone); ?>" class="flex items-center gap-1 hover:text-primary-400 transition-colors">
                            <?php echo dst_get_icon('phone', 'w-4 h-4'); ?>
                            <span><?php echo esc_html($phone); ?></span>
                        </a>
                    <?php endif; ?>
                    <div class="flex items-center gap-2">
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="border-b border-secondary-100">
        <div class="hf-container">
            <div class="flex items-center justify-between h-20">

                <!-- Logo -->
                <div class="flex-shrink-0">
                    <?php if (has_custom_logo()): ?>
                        <a href="<?php echo home_url('/'); ?>" class="block">
                            <?php
                            $logo_id = get_theme_mod('custom_logo');
                            $logo_url = wp_get_attachment_image_url($logo_id, 'full');
                            ?>
                            <img src="<?php echo esc_url($logo_url); ?>"
                                 alt="<?php bloginfo('name'); ?>"
                                 class="h-10 w-auto max-w-[180px] object-contain">
                        </a>
                    <?php else: ?>
                        <a href="<?php echo home_url('/'); ?>" class="text-xl font-bold text-secondary-800 hover:text-primary-600 transition-colors">
                            <?php bloginfo('name'); ?>
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Search Bar (Desktop) -->
                <?php if ($show_search): ?>
                    <div class="flex-1 max-w-2xl mx-8 hidden lg:block">
                        <?php echo dst_product_search_form(); ?>
                    </div>
                <?php endif; ?>

                <!-- Header Actions -->
                <div class="flex items-center gap-3">

                    <!-- Compare -->
                    <?php if (class_exists('YITH_Woocompare')): ?>
                        <a href="<?php echo home_url('/compare'); ?>" class="hidden lg:flex flex-col items-center gap-1 text-secondary-600 hover:text-primary-600 transition-colors">
                            <?php echo dst_get_icon('repeat', 'w-6 h-6'); ?>
                            <span class="text-xs">مقایسه</span>
                        </a>
                    <?php endif; ?>

                    <!-- Wishlist -->
                    <?php if (function_exists('YITH_WCWL')): ?>
                        <div class="hidden lg:flex">
                            <a href="<?php echo YITH_WCWL()->get_wishlist_url(); ?>" class="flex flex-col items-center gap-1 text-secondary-600 hover:text-primary-600 transition-colors relative">
                                <?php echo dst_get_icon('heart', 'w-6 h-6'); ?>
                                <span class="text-xs">علاقه‌مندی</span>
                                <?php
                                $wishlist_count = YITH_WCWL()->count_products();
                                if ($wishlist_count > 0):
                                ?>
                                    <span class="absolute -top-1 -right-1 rtl:-right-auto rtl:-left-1 hf-badge hf-badge-primary text-xs"><?php echo $wishlist_count; ?></span>
                                <?php endif; ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <!-- Cart -->
                    <?php if ($show_cart && dst_is_woocommerce_active()): ?>
                        <div class="relative" x-data="miniCart">
                            <button @click="toggle()" class="flex flex-col items-center gap-1 text-secondary-600 hover:text-primary-600 transition-colors relative px-2">
                                <?php echo dst_get_icon('cart', 'w-6 h-6'); ?>
                                <span class="text-xs hidden lg:inline">سبد خرید</span>
                                <?php if (dst_get_cart_count() > 0): ?>
                                    <span class="absolute -top-1 -right-0 rtl:-right-auto rtl:-left-0 hf-badge hf-badge-primary text-xs"><?php echo dst_get_cart_count(); ?></span>
                                <?php endif; ?>
                            </button>
                            <?php echo dst_mini_cart(); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Account -->
                    <?php if ($show_account): ?>
                        <a href="<?php echo dst_get_account_url(); ?>" class="hidden lg:flex flex-col items-center gap-1 text-secondary-600 hover:text-primary-600 transition-colors">
                            <?php echo dst_get_icon('user', 'w-6 h-6'); ?>
                            <span class="text-xs"><?php echo is_user_logged_in() ? 'حساب من' : 'ورود'; ?></span>
                        </a>
                    <?php endif; ?>

                    <!-- Mobile Menu Toggle -->
                    <button
                        @click="toggleMobileMenu()"
                        class="lg:hidden hf-icon-btn"
                        :class="{ 'text-primary-600': isMobileMenuOpen }"
                        aria-label="منو"
                    >
                        <div class="hf-hamburger" :class="{ 'is-active': isMobileMenuOpen }">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Navigation Bar -->
    <div class="hidden lg:block bg-white border-b border-secondary-100">
        <div class="hf-container">
            <div class="flex items-center justify-between py-3">
                <!-- Categories Dropdown -->
                <?php if (dst_is_woocommerce_active()): ?>
                    <div class="relative" x-data="{ categoriesOpen: false }">
                        <button 
                            @click="categoriesOpen = !categoriesOpen"
                            class="hf-btn hf-btn-primary flex items-center gap-2"
                        >
                            <?php echo dst_get_icon('menu', 'w-5 h-5'); ?>
                            <span>دسته‌بندی محصولات</span>
                            <?php echo dst_get_icon('chevron-down', 'w-4 h-4'); ?>
                        </button>

                        <div
                            x-show="categoriesOpen"
                            x-transition
                            @click.outside="categoriesOpen = false"
                            class="absolute top-full right-0 rtl:right-auto rtl:left-0 mt-2 w-64 bg-white shadow-xl rounded-lg border border-secondary-100 z-50"
                        >
                            <?php
                            $product_categories = get_terms([
                                'taxonomy' => 'product_cat',
                                'hide_empty' => true,
                                'parent' => 0,
                                'number' => 8,
                            ]);

                            if ($product_categories && !is_wp_error($product_categories)):
                            ?>
                                <ul class="py-2">
                                    <?php foreach ($product_categories as $category): ?>
                                        <li>
                                            <a href="<?php echo get_term_link($category); ?>" class="flex items-center justify-between px-4 py-2 hover:bg-secondary-50 transition-colors">
                                                <span><?php echo esc_html($category->name); ?></span>
                                                <span class="text-xs text-secondary-500">(<?php echo $category->count; ?>)</span>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                    <li class="border-t border-secondary-100 mt-2 pt-2">
                                        <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="flex items-center justify-center px-4 py-2 text-primary-600 hover:text-primary-700 font-semibold">
                                            مشاهده همه دسته‌ها
                                            <?php echo dst_get_icon('arrow-left', 'w-4 h-4 mr-1 rtl:mr-0 rtl:ml-1'); ?>
                                        </a>
                                    </li>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Main Navigation -->
                <nav class="flex items-center gap-1">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'container' => false,
                        'menu_class' => 'hf-nav-menu',
                        'fallback_cb' => false,
                        'depth' => 2,
                    ]);
                    ?>
                </nav>

                <!-- Special Offers -->
                <a href="<?php echo home_url('/offers'); ?>" class="flex items-center gap-2 text-red-600 hover:text-red-700 font-semibold">
                    <?php echo dst_get_icon('tag', 'w-5 h-5'); ?>
                    <span>پیشنهادات ویژه</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div
        class="hf-mobile-menu-overlay lg:hidden"
        :class="{ 'is-open': isMobileMenuOpen }"
        @click="closeMobileMenu()"
    ></div>

    <div class="hf-mobile-menu lg:hidden" :class="{ 'is-open': isMobileMenuOpen }">
        <div class="flex items-center justify-between p-4 border-b border-secondary-100">
            <span class="text-lg font-bold text-secondary-800">منو</span>
            <button @click="closeMobileMenu()" class="hf-icon-btn">
                <?php echo dst_get_icon('close'); ?>
            </button>
        </div>

        <?php if ($show_search): ?>
            <div class="p-4 border-b border-secondary-100">
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

        <div class="p-4 border-t border-secondary-100 mt-auto">
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
                    <a href="<?php echo dst_get_account_url(); ?>" class="hf-btn hf-btn-secondary">
                        <?php echo dst_get_icon('user', 'w-5 h-5'); ?>
                        <span><?php echo is_user_logged_in() ? 'حساب من' : 'ورود'; ?></span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>
