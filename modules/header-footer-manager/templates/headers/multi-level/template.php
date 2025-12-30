<?php
/**
 * Header Template: Multi-Level
 * هدر با منوی چند سطحی و مگامنو
 */

defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$is_sticky = $settings['sticky'] ?? true;
$dropdown_levels = $settings['dropdown_levels'] ?? 3;
$mega_menu_items = $settings['mega_menu_items'] ?? '';
$mega_menu_columns = $settings['mega_menu_columns'] ?? 4;
$dropdown_width = $settings['dropdown_width'] ?? 240;
$mega_menu_width = $settings['mega_menu_width'] ?? 1000;
$dropdown_animation = $settings['dropdown_animation'] ?? 'fade';
$show_icons = $settings['show_icons'] ?? true;
$show_descriptions = $settings['show_descriptions'] ?? true;
$show_search = $settings['show_search'] ?? true;
$show_cart = $settings['show_cart'] ?? true;
$show_account = $settings['show_account'] ?? true;
$show_wishlist = $settings['show_wishlist'] ?? true;
$bg_color = $settings['bg_color'] ?? '#ffffff';
$dropdown_bg_color = $settings['dropdown_bg_color'] ?? '#ffffff';
$text_color = $settings['text_color'] ?? '#1f2937';
$hover_color = $settings['hover_color'] ?? '#3b82f6';
$menu_font_weight = $settings['menu_font_weight'] ?? 'medium';

$font_weight_class = [
    'normal' => 'font-normal',
    'medium' => 'font-medium',
    'semibold' => 'font-semibold',
    'bold' => 'font-bold',
][$menu_font_weight] ?? 'font-medium';

$mega_menu_items_array = array_map('trim', explode(',', $mega_menu_items));
?>

<style>
.multi-level-menu {
    position: relative;
}

.multi-level-menu .menu-item {
    position: relative;
}

.multi-level-menu .menu-item > a {
    transition: color 300ms ease;
}

.multi-level-menu .menu-item > a:hover {
    color: <?php echo esc_attr($hover_color); ?>;
}

/* Dropdown Styles */
.multi-level-menu .sub-menu {
    position: absolute;
    top: 100%;
    left: 0;
    right: auto;
    min-width: <?php echo esc_attr($dropdown_width); ?>px;
    background-color: <?php echo esc_attr($dropdown_bg_color); ?>;
    border-radius: 8px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    padding: 8px;
    margin-top: 8px;
    opacity: 0;
    visibility: hidden;
    transform-origin: top;
    z-index: 1000;
    border: 1px solid #e5e7eb;
}

<?php if ($dropdown_animation === 'fade'): ?>
.multi-level-menu .sub-menu {
    transition: opacity 300ms ease, visibility 300ms ease;
}
<?php elseif ($dropdown_animation === 'slide'): ?>
.multi-level-menu .sub-menu {
    transform: translateY(-10px);
    transition: opacity 300ms ease, visibility 300ms ease, transform 300ms ease;
}
<?php elseif ($dropdown_animation === 'scale'): ?>
.multi-level-menu .sub-menu {
    transform: scale(0.95);
    transition: opacity 300ms ease, visibility 300ms ease, transform 300ms ease;
}
<?php endif; ?>

.multi-level-menu .menu-item:hover > .sub-menu {
    opacity: 1;
    visibility: visible;
    <?php if ($dropdown_animation === 'slide'): ?>
    transform: translateY(0);
    <?php elseif ($dropdown_animation === 'scale'): ?>
    transform: scale(1);
    <?php endif; ?>
}

/* Nested Dropdowns */
.multi-level-menu .sub-menu .sub-menu {
    top: 0;
    left: 100%;
    margin-top: 0;
    margin-left: 8px;
}

.multi-level-menu .sub-menu .menu-item {
    margin: 0;
}

.multi-level-menu .sub-menu .menu-item > a {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 12px;
    border-radius: 6px;
    transition: background-color 200ms ease, color 200ms ease;
    color: <?php echo esc_attr($text_color); ?>;
}

.multi-level-menu .sub-menu .menu-item > a:hover {
    background-color: #f3f4f6;
    color: <?php echo esc_attr($hover_color); ?>;
}

.multi-level-menu .menu-item-has-children > a::after {
    content: '';
    display: inline-block;
    width: 0;
    height: 0;
    margin-left: 6px;
    border-left: 4px solid transparent;
    border-right: 4px solid transparent;
    border-top: 4px solid currentColor;
    vertical-align: middle;
}

.multi-level-menu .sub-menu .menu-item-has-children > a::after {
    border-top: 4px solid transparent;
    border-bottom: 4px solid transparent;
    border-left: 4px solid currentColor;
    border-right: 0;
    margin-left: auto;
}

/* Mega Menu Styles */
.mega-menu-dropdown {
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    width: <?php echo esc_attr($mega_menu_width); ?>px;
    max-width: 90vw;
    background-color: <?php echo esc_attr($dropdown_bg_color); ?>;
    border-radius: 12px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    padding: 24px;
    margin-top: 8px;
    opacity: 0;
    visibility: hidden;
    z-index: 1000;
    border: 1px solid #e5e7eb;
    <?php if ($dropdown_animation === 'fade'): ?>
    transition: opacity 300ms ease, visibility 300ms ease;
    <?php elseif ($dropdown_animation === 'slide'): ?>
    transform: translateX(-50%) translateY(-10px);
    transition: opacity 300ms ease, visibility 300ms ease, transform 300ms ease;
    <?php elseif ($dropdown_animation === 'scale'): ?>
    transform: translateX(-50%) scale(0.95);
    transition: opacity 300ms ease, visibility 300ms ease, transform 300ms ease;
    <?php endif; ?>
}

.menu-item:hover > .mega-menu-dropdown {
    opacity: 1;
    visibility: visible;
    <?php if ($dropdown_animation === 'slide'): ?>
    transform: translateX(-50%) translateY(0);
    <?php elseif ($dropdown_animation === 'scale'): ?>
    transform: translateX(-50%) scale(1);
    <?php endif; ?>
}

.mega-menu-grid {
    display: grid;
    grid-template-columns: repeat(<?php echo esc_attr($mega_menu_columns); ?>, 1fr);
    gap: 24px;
}

.mega-menu-column-title {
    font-weight: 600;
    color: <?php echo esc_attr($text_color); ?>;
    margin-bottom: 12px;
    padding-bottom: 8px;
    border-bottom: 2px solid <?php echo esc_attr($hover_color); ?>;
    font-size: 14px;
}

.mega-menu-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 8px;
    border-radius: 6px;
    transition: background-color 200ms ease;
    margin-bottom: 4px;
}

.mega-menu-item:hover {
    background-color: #f9fafb;
}

.mega-menu-item-icon {
    flex-shrink: 0;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #eff6ff;
    color: <?php echo esc_attr($hover_color); ?>;
    border-radius: 6px;
}

.mega-menu-item-content {
    flex: 1;
}

.mega-menu-item-title {
    font-weight: 500;
    color: <?php echo esc_attr($text_color); ?>;
    margin-bottom: 2px;
    font-size: 14px;
}

.mega-menu-item-title:hover {
    color: <?php echo esc_attr($hover_color); ?>;
}

.mega-menu-item-desc {
    font-size: 12px;
    color: #6b7280;
    line-height: 1.4;
}
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

            <!-- Desktop Navigation with Multi-Level Support -->
            <nav class="hidden lg:flex items-center gap-1 multi-level-menu <?php echo $font_weight_class; ?>">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'hf-nav-menu',
                    'fallback_cb' => false,
                    'depth' => $dropdown_levels,
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
