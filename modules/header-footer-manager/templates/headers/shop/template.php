<?php
/**
 * Header Template: E-commerce Shop
 * E-commerce optimized with categories, search, cart, wishlist, and account
 */

defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$is_sticky = $settings['sticky'] ?? true;
$show_topbar = $settings['show_topbar'] ?? true;
$topbar_bg_color = $settings['topbar_bg_color'] ?? '#2563eb';
$topbar_text_color = $settings['topbar_text_color'] ?? '#ffffff';
$show_search = $settings['show_search'] ?? true;
$show_cart = $settings['show_cart'] ?? true;
$show_account = $settings['show_account'] ?? true;
$show_wishlist = $settings['show_wishlist'] ?? true;
$bg_color = $settings['bg_color'] ?? '#ffffff';
$text_color = $settings['text_color'] ?? '#1f2937';
$show_cta = $settings['show_cta'] ?? false;
$cta_text = $settings['cta_text'] ?? 'Shop Now';
$cta_url = $settings['cta_url'] ?? '/shop';
$cta_style = $settings['cta_style'] ?? 'primary';

$cta_button_class = match($cta_style) {
    'secondary' => 'hf-btn hf-btn-secondary',
    'outline' => 'hf-btn hf-btn-outline',
    default => 'hf-btn hf-btn-primary'
};
?>

<header
    x-data="header"
    :class="{
        'shadow-lg': isScrolled,
        '-translate-y-full': isHidden && isScrolled
    }"
    class="<?php echo $is_sticky ? 'hf-header-sticky' : 'relative'; ?> transition-all duration-300"
    style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;"
>
    <!-- Top Bar -->
    <?php if ($show_topbar): ?>
        <div class="text-sm hidden lg:block" style="background-color: <?php echo esc_attr($topbar_bg_color); ?>; color: <?php echo esc_attr($topbar_text_color); ?>;">
            <div class="hf-container">
                <div class="flex items-center justify-between py-2">
                    <!-- Promotion Message -->
                    <div class="flex items-center gap-6">
                        <span class="flex items-center gap-2">
                            <?php echo dst_get_icon('truck', 'w-4 h-4'); ?>
                            <span>Free Shipping on Orders Over $50</span>
                        </span>
                        <span class="flex items-center gap-2">
                            <?php echo dst_get_icon('shield-check', 'w-4 h-4'); ?>
                            <span>100% Secure Checkout</span>
                        </span>
                    </div>

                    <!-- Contact & Social -->
                    <div class="flex items-center gap-4">
                        <?php
                        $contact = dst_get_contact();
                        if (!empty($contact['phone'])):
                        ?>
                            <a href="tel:<?php echo esc_attr($contact['phone']); ?>" class="flex items-center gap-1 hover:opacity-80 transition-opacity">
                                <?php echo dst_get_icon('phone', 'w-4 h-4'); ?>
                                <span><?php echo esc_html($contact['phone']); ?></span>
                            </a>
                        <?php endif; ?>

                        <div class="flex items-center gap-2">
                            <?php
                            $social = dst_get_social();
                            foreach (['facebook', 'instagram', 'twitter'] as $platform):
                                if (!empty($social[$platform])):
                            ?>
                                <a href="<?php echo esc_url($social[$platform]); ?>" target="_blank" rel="noopener noreferrer" class="hover:opacity-80 transition-opacity" aria-label="<?php echo esc_attr($platform); ?>">
                                    <?php echo dst_get_icon($platform, 'w-4 h-4'); ?>
                                </a>
                            <?php
                                endif;
                            endforeach;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Header -->
    <div class="border-b border-secondary-100">
        <div class="hf-container">
            <div class="flex items-center justify-between h-20 gap-4">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <?php dst_the_logo('default', 'h-10 w-auto max-w-[180px] object-contain'); ?>
                </div>

                <!-- Search Bar (Desktop) -->
                <?php if ($show_search): ?>
                    <div class="flex-1 max-w-2xl mx-4 hidden lg:block">
                        <div class="relative">
                            <?php if (dst_is_woocommerce_active()): ?>
                                <?php echo dst_product_search_form(); ?>
                            <?php else: ?>
                                <?php get_search_form(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Header Actions -->
                <div class="flex items-center gap-2">
                    <!-- Wishlist -->
                    <?php if ($show_wishlist && function_exists('YITH_WCWL')): ?>
                        <a href="<?php echo YITH_WCWL()->get_wishlist_url(); ?>" class="hidden lg:flex flex-col items-center gap-1 text-secondary-600 hover:text-primary-600 transition-colors relative px-2">
                            <?php echo dst_get_icon('heart', 'w-6 h-6'); ?>
                            <span class="text-xs">Wishlist</span>
                            <?php
                            $wishlist_count = YITH_WCWL()->count_products();
                            if ($wishlist_count > 0):
                            ?>
                                <span class="absolute -top-1 -right-0 hf-badge hf-badge-primary text-xs"><?php echo $wishlist_count; ?></span>
                            <?php endif; ?>
                        </a>
                    <?php endif; ?>

                    <!-- Cart -->
                    <?php if ($show_cart && dst_is_woocommerce_active()): ?>
                        <div class="relative" x-data="miniCart">
                            <button @click="toggle()" class="flex flex-col items-center gap-1 text-secondary-600 hover:text-primary-600 transition-colors relative px-2">
                                <?php echo dst_get_icon('shopping-bag', 'w-6 h-6'); ?>
                                <span class="text-xs hidden lg:inline">Cart</span>
                                <?php if (dst_get_cart_count() > 0): ?>
                                    <span class="absolute -top-1 -right-0 hf-badge hf-badge-primary text-xs"><?php echo dst_get_cart_count(); ?></span>
                                <?php endif; ?>
                            </button>
                            <?php echo dst_mini_cart(); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Account -->
                    <?php if ($show_account): ?>
                        <a href="<?php echo dst_get_account_url(); ?>" class="hidden lg:flex flex-col items-center gap-1 text-secondary-600 hover:text-primary-600 transition-colors px-2">
                            <?php echo dst_get_icon('user', 'w-6 h-6'); ?>
                            <span class="text-xs"><?php echo is_user_logged_in() ? 'Account' : 'Login'; ?></span>
                        </a>
                    <?php endif; ?>

                    <!-- Mobile Menu Toggle -->
                    <button
                        @click="toggleMobileMenu()"
                        class="lg:hidden hf-icon-btn"
                        :class="{ 'text-primary-600': isMobileMenuOpen }"
                        aria-label="Menu"
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
    <?php if (dst_is_woocommerce_active()): ?>
        <div class="hidden lg:block bg-secondary-50 border-b border-secondary-100">
            <div class="hf-container">
                <div class="flex items-center justify-between py-3">
                    <!-- Categories Dropdown -->
                    <div class="relative" x-data="{ categoriesOpen: false }">
                        <button
                            @click="categoriesOpen = !categoriesOpen"
                            class="hf-btn hf-btn-primary flex items-center gap-2"
                        >
                            <?php echo dst_get_icon('menu', 'w-5 h-5'); ?>
                            <span>All Categories</span>
                            <?php echo dst_get_icon('chevron-down', 'w-4 h-4'); ?>
                        </button>

                        <div
                            x-show="categoriesOpen"
                            x-transition
                            @click.outside="categoriesOpen = false"
                            class="absolute top-full left-0 mt-2 w-64 bg-white shadow-xl rounded-lg border border-secondary-100 z-50"
                            style="display: none;"
                        >
                            <?php
                            $product_categories = get_terms([
                                'taxonomy' => 'product_cat',
                                'hide_empty' => true,
                                'parent' => 0,
                                'number' => 10,
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
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>

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
                    <a href="<?php echo home_url('/shop'); ?>" class="flex items-center gap-2 text-red-600 hover:text-red-700 font-semibold">
                        <?php echo dst_get_icon('tag', 'w-5 h-5'); ?>
                        <span>Special Offers</span>
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Mobile Menu -->
    <div
        class="hf-mobile-menu-overlay lg:hidden"
        :class="{ 'is-open': isMobileMenuOpen }"
        @click="closeMobileMenu()"
    ></div>

    <div class="hf-mobile-menu lg:hidden" :class="{ 'is-open': isMobileMenuOpen }">
        <div class="flex items-center justify-between p-4 border-b border-secondary-100">
            <span class="text-lg font-bold">Menu</span>
            <button @click="closeMobileMenu()" class="hf-icon-btn">
                <?php echo dst_get_icon('close'); ?>
            </button>
        </div>

        <?php if ($show_search): ?>
            <div class="p-4 border-b border-secondary-100">
                <?php if (dst_is_woocommerce_active()): ?>
                    <?php echo dst_product_search_form(); ?>
                <?php else: ?>
                    <?php get_search_form(); ?>
                <?php endif; ?>
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
                        <?php echo dst_get_icon('shopping-bag', 'w-5 h-5'); ?>
                        <span>Cart</span>
                        <?php if (dst_get_cart_count() > 0): ?>
                            <span class="hf-badge bg-white text-primary-600"><?php echo dst_get_cart_count(); ?></span>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>

                <?php if ($show_account): ?>
                    <a href="<?php echo dst_get_account_url(); ?>" class="hf-btn hf-btn-secondary">
                        <?php echo dst_get_icon('user', 'w-5 h-5'); ?>
                        <span><?php echo is_user_logged_in() ? 'Account' : 'Login'; ?></span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>
