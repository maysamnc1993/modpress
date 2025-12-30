<?php
/**
 * Header Template: Search Centric
 * Search-focused header with large prominent search bar
 */

defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$is_sticky = $settings['sticky'] ?? true;
$search_placeholder = $settings['search_placeholder'] ?? 'What are you looking for?';
$search_width = $settings['search_width'] ?? 'lg';
$show_search_suggestions = $settings['show_search_suggestions'] ?? true;
$search_suggestions = $settings['search_suggestions'] ?? 'T-shirts, Shoes, Laptops, Books';
$bg_color = $settings['bg_color'] ?? '#ffffff';
$text_color = $settings['text_color'] ?? '#000000';
$search_bg_color = $settings['search_bg_color'] ?? '#f3f4f6';
$search_border_color = $settings['search_border_color'] ?? '#e5e7eb';
$search_focus_color = $settings['search_focus_color'] ?? '#3b82f6';
$show_cart = $settings['show_cart'] ?? true;
$show_account = $settings['show_account'] ?? true;
$show_wishlist = $settings['show_wishlist'] ?? false;
$show_categories_menu = $settings['show_categories_menu'] ?? true;
$logo_size = $settings['logo_size'] ?? 'sm';
$search_style = $settings['search_style'] ?? 'rounded';

$search_width_class = match($search_width) {
    'md' => 'max-w-md',
    'xl' => 'max-w-3xl',
    'full' => 'max-w-full',
    default => 'max-w-2xl'
};

$logo_height = match($logo_size) {
    'xs' => 'h-6',
    'md' => 'h-12',
    default => 'h-8'
};

$search_radius = match($search_style) {
    'pill' => 'rounded-full',
    'square' => 'rounded-none',
    default => 'rounded-lg'
};

$suggestions_array = array_map('trim', explode(',', $search_suggestions));
?>

<style>
    .search-centric-header .search-input:focus {
        border-color: <?php echo esc_attr($search_focus_color); ?>;
        box-shadow: 0 0 0 3px <?php echo esc_attr($search_focus_color); ?>33;
    }
</style>

<header
    x-data="header"
    :class="{
        'shadow-md': isScrolled,
        '-translate-y-full': isHidden && isScrolled
    }"
    class="search-centric-header <?php echo $is_sticky ? 'hf-header-sticky' : 'relative'; ?> transition-all duration-300"
    style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;"
>
    <div class="hf-container">
        <div class="flex flex-col gap-4 py-4 lg:py-6">
            <!-- Top Row: Logo and Actions -->
            <div class="flex items-center justify-between">
                <!-- Logo (Small) -->
                <div class="flex-shrink-0">
                    <?php dst_the_logo('default', $logo_height . ' w-auto max-w-[120px] object-contain'); ?>
                </div>

                <!-- Quick Actions -->
                <div class="flex items-center gap-3">
                    <!-- Wishlist -->
                    <?php if ($show_wishlist && function_exists('YITH_WCWL')): ?>
                        <a href="<?php echo YITH_WCWL()->get_wishlist_url(); ?>" class="hf-icon-btn relative hidden md:flex">
                            <?php echo dst_get_icon('heart', 'w-5 h-5'); ?>
                            <?php
                            $wishlist_count = YITH_WCWL()->count_products();
                            if ($wishlist_count > 0):
                            ?>
                                <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center"><?php echo $wishlist_count; ?></span>
                            <?php endif; ?>
                        </a>
                    <?php endif; ?>

                    <!-- Account -->
                    <?php if ($show_account): ?>
                        <a href="<?php echo dst_get_account_url(); ?>" class="hf-icon-btn hidden md:flex flex-col items-center gap-1">
                            <?php echo dst_get_icon('user', 'w-5 h-5'); ?>
                            <span class="text-xs"><?php echo is_user_logged_in() ? 'Account' : 'Login'; ?></span>
                        </a>
                    <?php endif; ?>

                    <!-- Cart -->
                    <?php if ($show_cart && dst_is_woocommerce_active()): ?>
                        <div class="relative" x-data="miniCart">
                            <button @click="toggle()" class="hf-icon-btn relative flex-col items-center gap-1">
                                <?php echo dst_get_icon('shopping-bag', 'w-6 h-6'); ?>
                                <span class="text-xs">Cart</span>
                                <?php if (dst_get_cart_count() > 0): ?>
                                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-primary-600 text-white text-xs rounded-full flex items-center justify-center"><?php echo dst_get_cart_count(); ?></span>
                                <?php endif; ?>
                            </button>
                            <?php echo dst_mini_cart(); ?>
                        </div>
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

            <!-- Large Search Bar -->
            <div class="<?php echo $search_width_class; ?> mx-auto w-full">
                <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="relative">
                    <div class="flex items-center gap-2 <?php echo $search_radius; ?> border-2 p-2 transition-all duration-200"
                         style="background-color: <?php echo esc_attr($search_bg_color); ?>; border-color: <?php echo esc_attr($search_border_color); ?>;">

                        <?php if ($show_categories_menu && dst_is_woocommerce_active()): ?>
                            <!-- Categories Dropdown -->
                            <div x-data="{ open: false }" class="relative hidden md:block">
                                <button
                                    @click="open = !open"
                                    type="button"
                                    class="flex items-center gap-2 px-4 py-2 bg-white rounded-md border border-secondary-200 hover:bg-secondary-50 transition-colors whitespace-nowrap"
                                >
                                    <span class="text-sm font-medium">Categories</span>
                                    <?php echo dst_get_icon('chevron-down', 'w-4 h-4'); ?>
                                </button>

                                <!-- Dropdown Menu -->
                                <div
                                    x-show="open"
                                    @click.outside="open = false"
                                    x-transition
                                    class="absolute top-full left-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-secondary-200 max-h-96 overflow-y-auto z-50"
                                    style="display: none;"
                                >
                                    <?php
                                    $categories = get_terms([
                                        'taxonomy' => 'product_cat',
                                        'hide_empty' => true,
                                        'number' => 10,
                                    ]);
                                    if (!is_wp_error($categories) && !empty($categories)):
                                        foreach ($categories as $category):
                                    ?>
                                        <a href="<?php echo get_term_link($category); ?>" class="block px-4 py-2 text-sm hover:bg-secondary-50 transition-colors">
                                            <?php echo esc_html($category->name); ?>
                                            <span class="text-secondary-500">(<?php echo $category->count; ?>)</span>
                                        </a>
                                    <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Search Input -->
                        <input
                            type="search"
                            name="s"
                            placeholder="<?php echo esc_attr($search_placeholder); ?>"
                            class="search-input flex-1 px-4 py-3 bg-transparent border-0 focus:outline-none text-base"
                            style="color: <?php echo esc_attr($text_color); ?>;"
                        />

                        <!-- Search Button -->
                        <button
                            type="submit"
                            class="hf-btn hf-btn-primary flex items-center gap-2 px-6"
                        >
                            <?php echo dst_get_icon('search', 'w-5 h-5'); ?>
                            <span class="hidden md:inline">Search</span>
                        </button>
                    </div>
                </form>

                <!-- Search Suggestions -->
                <?php if ($show_search_suggestions && !empty($suggestions_array)): ?>
                    <div class="flex items-center gap-3 mt-3 text-sm text-secondary-600">
                        <span class="font-medium">Popular:</span>
                        <div class="flex flex-wrap items-center gap-2">
                            <?php foreach ($suggestions_array as $suggestion): ?>
                                <a href="<?php echo esc_url(home_url('/?s=' . urlencode($suggestion))); ?>"
                                   class="px-3 py-1 bg-secondary-100 rounded-full hover:bg-secondary-200 transition-colors">
                                    <?php echo esc_html($suggestion); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Navigation Menu (if exists) -->
            <?php if (has_nav_menu('primary')): ?>
                <nav class="hidden lg:flex items-center justify-center gap-8 border-t pt-4" style="border-color: <?php echo esc_attr($search_border_color); ?>;">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'container' => false,
                        'menu_class' => 'flex items-center gap-8',
                        'fallback_cb' => false,
                        'depth' => 1,
                        'link_before' => '<span class="text-sm font-medium hover:text-primary-600 transition-colors">',
                        'link_after' => '</span>',
                    ]);
                    ?>
                </nav>
            <?php endif; ?>
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
            <span class="text-lg font-bold text-secondary-800">Menu</span>
            <button @click="closeMobileMenu()" class="hf-icon-btn">
                <?php echo dst_get_icon('close'); ?>
            </button>
        </div>

        <!-- Mobile Search -->
        <div class="p-4 border-b border-secondary-100">
            <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <div class="relative">
                    <input
                        type="search"
                        name="s"
                        placeholder="<?php echo esc_attr($search_placeholder); ?>"
                        class="w-full px-4 py-3 pr-12 border rounded-lg focus:border-primary-500 focus:outline-none"
                    />
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2">
                        <?php echo dst_get_icon('search', 'w-5 h-5'); ?>
                    </button>
                </div>
            </form>
        </div>

        <nav class="p-4">
            <?php
            if (has_nav_menu('primary')) {
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'space-y-2',
                    'fallback_cb' => false,
                ]);
            }
            ?>
        </nav>
    </div>
</header>
