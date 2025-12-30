<?php
/**
 * Header Template: Split Logo
 * هدر با لوگوی بزرگ در مرکز و منوهای تقسیم شده
 */

defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$is_sticky = $settings['sticky'] ?? true;
$left_menu_location = $settings['left_menu_location'] ?? 'primary';
$right_menu_location = $settings['right_menu_location'] ?? 'secondary';
$logo_size = $settings['logo_size'] ?? 120;
$logo_spacing = $settings['logo_spacing'] ?? 40;
$show_search = $settings['show_search'] ?? true;
$show_cart = $settings['show_cart'] ?? true;
$show_account = $settings['show_account'] ?? true;
$show_wishlist = $settings['show_wishlist'] ?? true;
$bg_color = $settings['bg_color'] ?? '#ffffff';
$text_color = $settings['text_color'] ?? '#1f2937';
$menu_hover_color = $settings['menu_hover_color'] ?? '#3b82f6';
$center_alignment = $settings['center_alignment'] ?? true;
$menu_font_size = $settings['menu_font_size'] ?? 16;
$menu_font_weight = $settings['menu_font_weight'] ?? 'medium';
$actions_position = $settings['actions_position'] ?? 'right';

$font_weight_class = [
    'normal' => 'font-normal',
    'medium' => 'font-medium',
    'semibold' => 'font-semibold',
    'bold' => 'font-bold',
][$menu_font_weight] ?? 'font-medium';
?>

<style>
.split-logo-menu .menu-item > a {
    font-size: <?php echo esc_attr($menu_font_size); ?>px;
}
.split-logo-menu .menu-item > a:hover {
    color: <?php echo esc_attr($menu_hover_color); ?>;
}
</style>

<header
    x-data="header"
    :class="{ 'shadow-md': isScrolled }"
    class="<?php echo $is_sticky ? 'hf-header-sticky' : 'relative'; ?> transition-all duration-300"
    style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;"
>
    <div class="hf-container">
        <div class="flex items-<?php echo $center_alignment ? 'center' : 'start'; ?> justify-between py-6">

            <!-- Left Side Menu -->
            <nav class="hidden lg:flex items-center gap-2 flex-1 justify-end <?php echo $font_weight_class; ?>" style="margin-right: <?php echo esc_attr($logo_spacing); ?>px;">
                <?php
                wp_nav_menu([
                    'theme_location' => $left_menu_location,
                    'container' => false,
                    'menu_class' => 'hf-nav-menu split-logo-menu',
                    'fallback_cb' => false,
                    'depth' => 3,
                ]);
                ?>
            </nav>

            <!-- Center Logo (Large) -->
            <div class="flex-shrink-0 mx-4">
                <?php dst_the_logo('default', 'object-contain', 'width: ' . esc_attr($logo_size) . 'px; height: auto; max-height: 80px;'); ?>
            </div>

            <!-- Right Side Menu + Actions -->
            <div class="flex items-center gap-6 flex-1">

                <!-- Right Menu -->
                <nav class="hidden lg:flex items-center gap-2 <?php echo $font_weight_class; ?>" style="margin-left: <?php echo esc_attr($logo_spacing); ?>px;">
                    <?php
                    wp_nav_menu([
                        'theme_location' => $right_menu_location,
                        'container' => false,
                        'menu_class' => 'hf-nav-menu split-logo-menu',
                        'fallback_cb' => false,
                        'depth' => 3,
                    ]);
                    ?>
                </nav>

                <!-- Header Actions -->
                <?php if ($actions_position === 'right' || $actions_position === 'both'): ?>
                <div class="flex items-center gap-2 ml-auto">

                    <!-- Search -->
                    <?php if ($show_search): ?>
                        <div class="relative hidden md:block" x-data="{ searchOpen: false }">
                            <button
                                @click="searchOpen = !searchOpen"
                                class="hf-icon-btn"
                                aria-label="جستجو"
                            >
                                <?php echo dst_get_icon('search'); ?>
                            </button>

                            <!-- Search Dropdown -->
                            <div
                                x-show="searchOpen"
                                x-transition
                                @click.outside="searchOpen = false"
                                class="absolute top-full left-0 rtl:left-auto rtl:right-0 mt-2 w-80 z-50"
                            >
                                <?php echo dst_product_search_form(); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Wishlist -->
                    <?php if ($show_wishlist && function_exists('YITH_WCWL')): ?>
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
                <?php endif; ?>
            </div>

            <!-- Left Actions (if both) -->
            <?php if ($actions_position === 'left' || $actions_position === 'both'): ?>
            <div class="hidden lg:flex items-center gap-2 mr-auto">

                <?php if ($show_search): ?>
                    <div class="relative" x-data="{ searchOpen: false }">
                        <button
                            @click="searchOpen = !searchOpen"
                            class="hf-icon-btn"
                            aria-label="جستجو"
                        >
                            <?php echo dst_get_icon('search'); ?>
                        </button>

                        <div
                            x-show="searchOpen"
                            x-transition
                            @click.outside="searchOpen = false"
                            class="absolute top-full right-0 rtl:right-auto rtl:left-0 mt-2 w-80 z-50"
                        >
                            <?php echo dst_product_search_form(); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($show_wishlist && function_exists('YITH_WCWL')): ?>
                    <?php echo dst_wishlist_icon(); ?>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div
        class="hf-mobile-menu-overlay lg:hidden"
        :class="{ 'is-open': isMobileMenuOpen }"
        @click="closeMobileMenu()"
    ></div>

    <div
        class="hf-mobile-menu lg:hidden"
        :class="{ 'is-open': isMobileMenuOpen }"
        x-data="mobileMenu"
    >
        <div class="flex items-center justify-between p-4 border-b border-secondary-100">
            <span class="text-lg font-bold text-secondary-800">منو</span>
            <button @click="$dispatch('close-mobile-menu')" class="hf-icon-btn">
                <?php echo dst_get_icon('close'); ?>
            </button>
        </div>

        <!-- Mobile Search -->
        <?php if ($show_search): ?>
            <div class="p-4 border-b border-secondary-100">
                <?php echo dst_product_search_form(); ?>
            </div>
        <?php endif; ?>

        <!-- Mobile Navigation - Left Menu -->
        <nav class="p-4 border-b border-secondary-100">
            <div class="text-xs font-semibold text-secondary-500 mb-2">منوی اول</div>
            <?php
            wp_nav_menu([
                'theme_location' => $left_menu_location,
                'container' => false,
                'menu_class' => 'space-y-2',
                'fallback_cb' => false,
                'depth' => 2,
                'walker' => class_exists('DST_Mobile_Menu_Walker') ? new DST_Mobile_Menu_Walker() : null,
            ]);
            ?>
        </nav>

        <!-- Mobile Navigation - Right Menu -->
        <nav class="p-4">
            <div class="text-xs font-semibold text-secondary-500 mb-2">منوی دوم</div>
            <?php
            wp_nav_menu([
                'theme_location' => $right_menu_location,
                'container' => false,
                'menu_class' => 'space-y-2',
                'fallback_cb' => false,
                'depth' => 2,
                'walker' => class_exists('DST_Mobile_Menu_Walker') ? new DST_Mobile_Menu_Walker() : null,
            ]);
            ?>
        </nav>

        <!-- Mobile Account & Cart -->
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
