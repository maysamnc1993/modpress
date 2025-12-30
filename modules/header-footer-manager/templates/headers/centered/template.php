<?php
/**
 * Header Template: Centered
 * هدر با لوگو در مرکز
 */

defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$is_sticky = $settings['sticky'] ?? true;
$show_search = $settings['show_search'] ?? true;
$show_cart = $settings['show_cart'] ?? true;
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
    <div class="border-b border-secondary-100">
        <div class="hf-container">
            <div class="flex items-center justify-between h-16 relative">
                <!-- Left Actions -->
                <div class="flex items-center gap-2">
                    <button @click="toggleMobileMenu()" class="lg:hidden hf-icon-btn" aria-label="منو">
                        <div class="hf-hamburger" :class="{ 'is-active': isMobileMenuOpen }">
                            <span></span><span></span><span></span>
                        </div>
                    </button>
                    <?php if ($show_search): ?>
                        <button @click="toggleSearch()" class="hf-icon-btn hidden md:flex" aria-label="جستجو">
                            <?php echo dst_get_icon('search'); ?>
                        </button>
                    <?php endif; ?>
                </div>

                <!-- Centered Logo -->
                <div class="absolute left-1/2 transform -translate-x-1/2">
                    <?php if (has_custom_logo()): ?>
                        <a href="<?php echo home_url('/'); ?>" class="block">
                            <?php $logo_id = get_theme_mod('custom_logo'); $logo_url = wp_get_attachment_image_url($logo_id, 'full'); ?>
                            <img src="<?php echo esc_url($logo_url); ?>" alt="<?php bloginfo('name'); ?>" class="h-12 w-auto max-w-[200px] object-contain">
                        </a>
                    <?php else: ?>
                        <a href="<?php echo home_url('/'); ?>" class="text-2xl font-bold text-secondary-800 hover:text-primary-600"><?php bloginfo('name'); ?></a>
                    <?php endif; ?>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center gap-2">
                    <?php echo dst_account_icon('hidden md:block'); ?>
                    <?php if ($show_cart && dst_is_woocommerce_active()): ?>
                        <div class="relative" x-data="miniCart">
                            <button @click="toggle()" class="hf-cart-icon hf-icon-btn">
                                <?php echo dst_get_icon('cart'); ?>
                                <?php if (dst_get_cart_count() > 0): ?><span class="hf-badge hf-badge-primary"><?php echo dst_get_cart_count(); ?></span><?php endif; ?>
                            </button>
                            <?php echo dst_mini_cart(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Bar -->
    <div class="hidden lg:block border-b border-secondary-50">
        <div class="hf-container">
            <nav class="flex items-center justify-center py-3">
                <?php wp_nav_menu(['theme_location' => 'primary', 'container' => false, 'menu_class' => 'hf-nav-menu justify-center', 'fallback_cb' => false, 'depth' => 3]); ?>
            </nav>
        </div>
    </div>

    <!-- Search Overlay -->
    <div x-show="isSearchOpen" x-transition @click.outside="isSearchOpen = false" class="absolute top-full left-0 right-0 bg-white shadow-lg p-4 z-50">
        <div class="hf-container max-w-2xl mx-auto"><?php echo dst_product_search_form(); ?></div>
    </div>

    <!-- Mobile Menu -->
    <div class="hf-mobile-menu-overlay lg:hidden" :class="{ 'is-open': isMobileMenuOpen }" @click="closeMobileMenu()"></div>
    <div class="hf-mobile-menu lg:hidden" :class="{ 'is-open': isMobileMenuOpen }">
        <div class="flex items-center justify-between p-4 border-b border-secondary-100">
            <span class="text-lg font-bold">منو</span>
            <button @click="closeMobileMenu()" class="hf-icon-btn"><?php echo dst_get_icon('close'); ?></button>
        </div>
        <div class="p-4 border-b border-secondary-100"><?php echo dst_product_search_form(); ?></div>
        <nav class="p-4"><?php wp_nav_menu(['theme_location' => 'primary', 'container' => false, 'menu_class' => 'space-y-2', 'fallback_cb' => false, 'depth' => 2]); ?></nav>
    </div>
</header>
