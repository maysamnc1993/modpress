<?php
/**
 * Header Template: Animated Menu
 * هدر با انیمیشن‌های زیبا برای منو
 */

defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$is_sticky = $settings['sticky'] ?? true;
$animation_style = $settings['animation_style'] ?? 'underline';
$animation_duration = $settings['animation_duration'] ?? 300;
$underline_color = $settings['underline_color'] ?? '#3b82f6';
$underline_thickness = $settings['underline_thickness'] ?? 2;
$highlight_color = $settings['highlight_color'] ?? '#eff6ff';
$hover_text_color = $settings['hover_text_color'] ?? '#3b82f6';
$show_search = $settings['show_search'] ?? true;
$show_cart = $settings['show_cart'] ?? true;
$show_account = $settings['show_account'] ?? true;
$show_wishlist = $settings['show_wishlist'] ?? true;
$bg_color = $settings['bg_color'] ?? '#ffffff';
$text_color = $settings['text_color'] ?? '#1f2937';
$menu_spacing = $settings['menu_spacing'] ?? 32;
$menu_font_size = $settings['menu_font_size'] ?? 16;
$menu_font_weight = $settings['menu_font_weight'] ?? 'medium';
$enable_dropdown_animation = $settings['enable_dropdown_animation'] ?? true;

$font_weight_class = [
    'normal' => 'font-normal',
    'medium' => 'font-medium',
    'semibold' => 'font-semibold',
    'bold' => 'font-bold',
][$menu_font_weight] ?? 'font-medium';
?>

<style>
.animated-menu-nav {
    gap: <?php echo esc_attr($menu_spacing); ?>px;
}

.animated-menu-nav .menu-item > a {
    font-size: <?php echo esc_attr($menu_font_size); ?>px;
    position: relative;
    display: inline-block;
    padding: 8px 0;
    transition: color <?php echo esc_attr($animation_duration); ?>ms ease;
}

<?php if ($animation_style === 'underline'): ?>
/* Underline Animation */
.animated-menu-nav .menu-item > a::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: <?php echo esc_attr($underline_thickness); ?>px;
    background-color: <?php echo esc_attr($underline_color); ?>;
    transform: scaleX(0);
    transform-origin: right;
    transition: transform <?php echo esc_attr($animation_duration); ?>ms ease;
}
.animated-menu-nav .menu-item > a:hover::after,
.animated-menu-nav .menu-item.current-menu-item > a::after {
    transform: scaleX(1);
    transform-origin: left;
}
.animated-menu-nav .menu-item > a:hover {
    color: <?php echo esc_attr($hover_text_color); ?>;
}

<?php elseif ($animation_style === 'highlight'): ?>
/* Highlight Animation */
.animated-menu-nav .menu-item > a {
    padding: 8px 16px;
    border-radius: 8px;
}
.animated-menu-nav .menu-item > a::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: <?php echo esc_attr($highlight_color); ?>;
    border-radius: 8px;
    opacity: 0;
    transition: opacity <?php echo esc_attr($animation_duration); ?>ms ease;
    z-index: -1;
}
.animated-menu-nav .menu-item > a:hover::before,
.animated-menu-nav .menu-item.current-menu-item > a::before {
    opacity: 1;
}
.animated-menu-nav .menu-item > a:hover {
    color: <?php echo esc_attr($hover_text_color); ?>;
}

<?php elseif ($animation_style === 'slide'): ?>
/* Slide Animation */
.animated-menu-nav .menu-item > a::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: -8px;
    width: 3px;
    height: 100%;
    background-color: <?php echo esc_attr($underline_color); ?>;
    transform: scaleY(0);
    transform-origin: bottom;
    transition: transform <?php echo esc_attr($animation_duration); ?>ms ease;
    border-radius: 2px;
}
.animated-menu-nav .menu-item > a:hover::after,
.animated-menu-nav .menu-item.current-menu-item > a::after {
    transform: scaleY(1);
}
.animated-menu-nav .menu-item > a:hover {
    color: <?php echo esc_attr($hover_text_color); ?>;
    transform: translateX(-4px);
}

<?php elseif ($animation_style === 'scale'): ?>
/* Scale Animation */
.animated-menu-nav .menu-item > a {
    transition: transform <?php echo esc_attr($animation_duration); ?>ms ease, color <?php echo esc_attr($animation_duration); ?>ms ease;
}
.animated-menu-nav .menu-item > a:hover {
    transform: scale(1.1);
    color: <?php echo esc_attr($hover_text_color); ?>;
}

<?php elseif ($animation_style === 'bounce'): ?>
/* Bounce Animation */
.animated-menu-nav .menu-item > a {
    transition: transform <?php echo esc_attr($animation_duration); ?>ms cubic-bezier(0.68, -0.55, 0.265, 1.55), color <?php echo esc_attr($animation_duration); ?>ms ease;
}
.animated-menu-nav .menu-item > a:hover {
    transform: translateY(-4px);
    color: <?php echo esc_attr($hover_text_color); ?>;
}

<?php elseif ($animation_style === 'glow'): ?>
/* Glow Animation */
.animated-menu-nav .menu-item > a {
    transition: color <?php echo esc_attr($animation_duration); ?>ms ease, text-shadow <?php echo esc_attr($animation_duration); ?>ms ease;
}
.animated-menu-nav .menu-item > a:hover {
    color: <?php echo esc_attr($hover_text_color); ?>;
    text-shadow: 0 0 8px <?php echo esc_attr($underline_color); ?>40, 0 0 16px <?php echo esc_attr($underline_color); ?>20;
}
<?php endif; ?>

<?php if ($enable_dropdown_animation): ?>
/* Dropdown Animation */
.animated-menu-nav .sub-menu {
    animation: slideDown <?php echo esc_attr($animation_duration); ?>ms ease;
}
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
<?php endif; ?>
</style>

<header
    x-data="header"
    :class="{ 'shadow-md': isScrolled }"
    class="<?php echo $is_sticky ? 'hf-header-sticky' : 'relative'; ?> transition-all duration-300"
    style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;"
>
    <div class="hf-container">
        <div class="flex items-center justify-between h-20">

            <!-- Logo -->
            <div class="flex-shrink-0">
                <?php dst_the_logo('default', 'h-10 w-auto max-w-[180px] object-contain'); ?>
            </div>

            <!-- Desktop Navigation with Animations -->
            <nav class="hidden lg:flex items-center animated-menu-nav <?php echo $font_weight_class; ?>">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'hf-nav-menu',
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
