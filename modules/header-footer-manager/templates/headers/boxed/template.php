<?php
/**
 * Header Template: Boxed
 * هدر محدود شده در یک باکس با حاشیه و سایه
 */

defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$is_sticky = $settings['sticky'] ?? true;
$box_margin = $settings['box_margin'] ?? 20;
$box_margin_top = $settings['box_margin_top'] ?? 20;
$box_shadow = $settings['box_shadow'] ?? 'medium';
$box_radius = $settings['box_radius'] ?? 12;
$box_border = $settings['box_border'] ?? true;
$box_border_color = $settings['box_border_color'] ?? '#e5e7eb';
$box_border_width = $settings['box_border_width'] ?? 1;
$show_search = $settings['show_search'] ?? true;
$show_cart = $settings['show_cart'] ?? true;
$show_account = $settings['show_account'] ?? true;
$show_wishlist = $settings['show_wishlist'] ?? true;
$bg_color = $settings['bg_color'] ?? '#ffffff';
$outer_bg_color = $settings['outer_bg_color'] ?? '#f9fafb';
$text_color = $settings['text_color'] ?? '#1f2937';
$menu_hover_color = $settings['menu_hover_color'] ?? '#3b82f6';
$menu_font_weight = $settings['menu_font_weight'] ?? 'medium';

$font_weight_class = [
    'normal' => 'font-normal',
    'medium' => 'font-medium',
    'semibold' => 'font-semibold',
    'bold' => 'font-bold',
][$menu_font_weight] ?? 'font-medium';

$shadow_class = [
    'none' => '',
    'small' => 'shadow-sm',
    'medium' => 'shadow-md',
    'large' => 'shadow-lg',
    'xlarge' => 'shadow-xl',
][$box_shadow] ?? 'shadow-md';
?>

<style>
.boxed-header-menu .menu-item > a:hover {
    color: <?php echo esc_attr($menu_hover_color); ?>;
}
</style>

<header
    x-data="header"
    class="<?php echo $is_sticky ? 'hf-header-sticky' : 'relative'; ?> transition-all duration-300"
    style="background-color: <?php echo esc_attr($outer_bg_color); ?>; padding-top: <?php echo esc_attr($box_margin_top); ?>px;"
>
    <!-- Boxed Container -->
    <div class="hf-container">
        <div
            class="<?php echo $shadow_class; ?> transition-shadow duration-300"
            :class="{ 'shadow-lg': isScrolled && '<?php echo $box_shadow; ?>' !== 'none' }"
            style="
                background-color: <?php echo esc_attr($bg_color); ?>;
                color: <?php echo esc_attr($text_color); ?>;
                border-radius: <?php echo esc_attr($box_radius); ?>px;
                margin-left: <?php echo esc_attr($box_margin); ?>px;
                margin-right: <?php echo esc_attr($box_margin); ?>px;
                <?php if ($box_border): ?>
                border: <?php echo esc_attr($box_border_width); ?>px solid <?php echo esc_attr($box_border_color); ?>;
                <?php endif; ?>
            "
        >
            <div class="flex items-center justify-between px-6 lg:px-8 h-20">

                <!-- Logo -->
                <div class="flex-shrink-0">
                    <?php dst_the_logo('default', 'h-10 w-auto max-w-[180px] object-contain'); ?>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex items-center gap-1 <?php echo $font_weight_class; ?>">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'container' => false,
                        'menu_class' => 'hf-nav-menu boxed-header-menu',
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

        <!-- Mobile Navigation -->
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
