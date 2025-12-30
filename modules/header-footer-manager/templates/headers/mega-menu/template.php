<?php
/**
 * Header Template: Mega Menu
 * هدر با منوی بزرگ Dropdown
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
    <div class="bg-secondary-800 text-white py-2 hidden lg:block">
        <div class="hf-container">
            <div class="flex items-center justify-between text-sm">
                <div class="flex items-center gap-4">
                    <span class="flex items-center gap-1">
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
    <div class="hf-container">
        <div class="flex items-center justify-between h-20 border-b border-secondary-100">

            <!-- Logo -->
            <div class="flex-shrink-0">
                <?php dst_the_logo('default', 'h-10 w-auto max-w-[180px] object-contain'); ?>
            </div>

            <!-- Search Bar -->
            <?php if ($show_search): ?>
                <div class="flex-1 max-w-2xl mx-8 hidden lg:block">
                    <?php echo dst_product_search_form(); ?>
                </div>
            <?php endif; ?>

            <!-- Header Actions -->
            <div class="flex items-center gap-2">

                <!-- Wishlist -->
                <?php if (function_exists('YITH_WCWL')): ?>
                    <?php echo dst_wishlist_icon('hidden md:flex'); ?>
                <?php endif; ?>

                <!-- Cart -->
                <?php if ($show_cart && dst_is_woocommerce_active()): ?>
                    <div class="relative" x-data="miniCart">
                        <button @click="toggle()" class="hf-cart-icon hf-icon-btn">
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
                    <?php echo dst_account_icon('hidden md:flex'); ?>
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

    <!-- Navigation Bar with Mega Menu -->
    <div class="bg-primary-600 text-white hidden lg:block">
        <div class="hf-container">
            <nav class="flex items-center justify-center py-3">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'hf-nav-menu mega-menu-enabled text-white',
                    'fallback_cb' => false,
                    'depth' => 3,
                ]);
                ?>
            </nav>
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
                'depth' => 3,
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
