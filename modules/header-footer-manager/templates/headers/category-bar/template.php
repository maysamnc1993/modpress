<?php
/**
 * Header Template: E-commerce Category Header
 * E-commerce header with main navigation and horizontal scrolling category bar
 */

defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$is_sticky = $settings['sticky'] ?? true;
$bg_color = $settings['bg_color'] ?? '#ffffff';
$text_color = $settings['text_color'] ?? '#000000';
$show_category_bar = $settings['show_category_bar'] ?? true;
$category_bar_bg = $settings['category_bar_bg'] ?? '#f9fafb';
$show_category_icons = $settings['show_category_icons'] ?? true;
$category_bar_style = $settings['category_bar_style'] ?? 'pills';
$show_search = $settings['show_search'] ?? true;
$search_style = $settings['search_style'] ?? 'expanded';
$show_cart = $settings['show_cart'] ?? true;
$show_wishlist = $settings['show_wishlist'] ?? true;
$show_account = $settings['show_account'] ?? true;
$show_compare = $settings['show_compare'] ?? false;
$show_phone = $settings['show_phone'] ?? false;
$category_hover_color = $settings['category_hover_color'] ?? '#000000';
$max_categories = $settings['max_categories'] ?? '10';
$category_source = $settings['category_source'] ?? 'product';

$category_item_class = match($category_bar_style) {
    'underline' => 'px-4 py-2 border-b-2 border-transparent hover:border-current transition-all',
    'minimal' => 'px-4 py-2 hover:opacity-70 transition-opacity',
    default => 'px-4 py-2 rounded-full hover:bg-white hover:shadow-sm transition-all'
};

// Get categories
$categories = [];
if ($category_source === 'product' && dst_is_woocommerce_active()) {
    $category_args = [
        'taxonomy' => 'product_cat',
        'hide_empty' => true,
        'parent' => 0,
    ];
    if ($max_categories !== 'all') {
        $category_args['number'] = intval($max_categories);
    }
    $product_categories = get_terms($category_args);
    if (!is_wp_error($product_categories)) {
        $categories = $product_categories;
    }
}
?>

<header
    x-data="header"
    :class="{
        'shadow-sm': isScrolled,
        '-translate-y-full': isHidden && isScrolled
    }"
    class="<?php echo $is_sticky ? 'hf-header-sticky' : 'relative'; ?> transition-all duration-300"
    style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;"
>
    <!-- Main Header -->
    <div class="border-b border-secondary-100">
        <div class="hf-container">
            <div class="flex items-center justify-between gap-6 h-20">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <?php dst_the_logo('default', 'h-8 w-auto max-w-[140px] object-contain'); ?>
                </div>

                <!-- Search Bar -->
                <?php if ($show_search): ?>
                    <?php if ($search_style === 'expanded'): ?>
                        <div class="hidden lg:flex flex-1 max-w-2xl">
                            <div class="relative w-full">
                                <?php get_search_form(); ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <button
                            @click="toggleSearch()"
                            class="hidden lg:flex hf-icon-btn"
                            aria-label="Search"
                        >
                            <?php echo dst_get_icon('search', 'w-5 h-5'); ?>
                        </button>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Right Icons -->
                <div class="flex items-center gap-2">
                    <!-- Phone -->
                    <?php if ($show_phone): ?>
                        <?php
                        $contact = dst_get_contact();
                        if (!empty($contact['phone'])):
                        ?>
                            <a href="tel:<?php echo esc_attr($contact['phone']); ?>" class="hidden md:flex items-center gap-2 px-3 py-2 hover:opacity-70 transition-opacity">
                                <?php echo dst_get_icon('phone', 'w-4 h-4'); ?>
                                <span class="text-sm font-medium"><?php echo esc_html($contact['phone']); ?></span>
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>

                    <!-- Mobile Search Toggle -->
                    <?php if ($show_search && $search_style === 'expanded'): ?>
                        <button
                            @click="toggleSearch()"
                            class="lg:hidden hf-icon-btn"
                            aria-label="Search"
                        >
                            <?php echo dst_get_icon('search', 'w-5 h-5'); ?>
                        </button>
                    <?php endif; ?>

                    <!-- Wishlist -->
                    <?php if ($show_wishlist && function_exists('YITH_WCWL')): ?>
                        <a href="<?php echo YITH_WCWL()->get_wishlist_url(); ?>" class="hf-icon-btn relative">
                            <?php echo dst_get_icon('heart', 'w-5 h-5'); ?>
                            <?php
                            $wishlist_count = YITH_WCWL()->count_products();
                            if ($wishlist_count > 0):
                            ?>
                                <span class="absolute -top-1 -right-1 w-4 h-4 bg-black text-white text-xs rounded-full flex items-center justify-center"><?php echo $wishlist_count; ?></span>
                            <?php endif; ?>
                        </a>
                    <?php endif; ?>

                    <!-- Compare -->
                    <?php if ($show_compare && class_exists('YITH_Woocompare')): ?>
                        <a href="<?php echo home_url('?action=yith-woocompare-view-table'); ?>" class="hf-icon-btn">
                            <?php echo dst_get_icon('refresh-cw', 'w-5 h-5'); ?>
                        </a>
                    <?php endif; ?>

                    <!-- Cart -->
                    <?php if ($show_cart && dst_is_woocommerce_active()): ?>
                        <div class="relative" x-data="miniCart">
                            <button @click="toggle()" class="hf-icon-btn relative">
                                <?php echo dst_get_icon('shopping-bag', 'w-5 h-5'); ?>
                                <?php if (dst_get_cart_count() > 0): ?>
                                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-black text-white text-xs rounded-full flex items-center justify-center"><?php echo dst_get_cart_count(); ?></span>
                                <?php endif; ?>
                            </button>
                            <?php echo dst_mini_cart(); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Account -->
                    <?php if ($show_account): ?>
                        <a href="<?php echo dst_get_account_url(); ?>" class="hf-icon-btn">
                            <?php echo dst_get_icon('user', 'w-5 h-5'); ?>
                        </a>
                    <?php endif; ?>

                    <!-- Mobile Menu Toggle -->
                    <button
                        @click="toggleMobileMenu()"
                        class="lg:hidden hf-icon-btn ml-2"
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

    <!-- Category Bar -->
    <?php if ($show_category_bar && !empty($categories)): ?>
        <div class="overflow-x-auto scrollbar-hide" style="background-color: <?php echo esc_attr($category_bar_bg); ?>;">
            <div class="hf-container">
                <div class="flex items-center gap-2 py-3">
                    <!-- All Categories -->
                    <button
                        @click="toggleMobileMenu()"
                        class="<?php echo esc_attr($category_item_class); ?> flex items-center gap-2 whitespace-nowrap text-sm font-medium flex-shrink-0"
                    >
                        <?php if ($show_category_icons): ?>
                            <?php echo dst_get_icon('menu', 'w-4 h-4'); ?>
                        <?php endif; ?>
                        All Categories
                    </button>

                    <!-- Category Links -->
                    <?php foreach ($categories as $category): ?>
                        <a
                            href="<?php echo get_term_link($category); ?>"
                            class="<?php echo esc_attr($category_item_class); ?> flex items-center gap-2 whitespace-nowrap text-sm flex-shrink-0"
                            style="color: inherit;"
                        >
                            <?php if ($show_category_icons): ?>
                                <?php
                                // Get category icon (you can extend this with custom fields)
                                $icon_map = [
                                    'electronics' => 'zap',
                                    'fashion' => 'tag',
                                    'home' => 'home',
                                    'sports' => 'activity',
                                    'books' => 'book',
                                ];
                                $icon = $icon_map[strtolower($category->slug)] ?? 'box';
                                echo dst_get_icon($icon, 'w-4 h-4');
                                ?>
                            <?php endif; ?>
                            <?php echo esc_html($category->name); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Search Overlay (Mobile) -->
    <?php if ($show_search && $search_style === 'expanded'): ?>
        <div
            x-show="isSearchOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4"
            class="lg:hidden border-b border-secondary-100"
            style="background-color: <?php echo esc_attr($bg_color); ?>;"
            @click.outside="closeSearch()"
            style="display: none;"
        >
            <div class="hf-container py-6">
                <div class="relative">
                    <?php get_search_form(); ?>
                    <button @click="closeSearch()" class="absolute top-1/2 right-4 -translate-y-1/2">
                        <?php echo dst_get_icon('close', 'w-5 h-5'); ?>
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Full Screen Mobile Menu -->
    <div
        class="fixed inset-0 z-50 bg-white"
        :class="{ 'pointer-events-none': !isMobileMenuOpen }"
        x-show="isMobileMenuOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="display: none;"
    >
        <div class="h-full flex flex-col">
            <!-- Menu Header -->
            <div class="flex items-center justify-between p-6 border-b border-secondary-100">
                <?php dst_the_logo('default', 'h-8 w-auto max-w-[140px] object-contain'); ?>
                <button @click="closeMobileMenu()" class="hf-icon-btn">
                    <?php echo dst_get_icon('close', 'w-6 h-6'); ?>
                </button>
            </div>

            <!-- Menu Content -->
            <div class="flex-1 overflow-y-auto">
                <!-- Categories -->
                <?php if (!empty($categories)): ?>
                    <div class="border-b border-secondary-100 p-6">
                        <h3 class="text-xs font-semibold uppercase tracking-wider mb-4 text-secondary-500">Categories</h3>
                        <div class="space-y-3">
                            <?php foreach ($categories as $category): ?>
                                <a
                                    href="<?php echo get_term_link($category); ?>"
                                    class="flex items-center gap-3 text-lg hover:text-primary-600 transition-colors"
                                >
                                    <?php if ($show_category_icons): ?>
                                        <?php
                                        $icon_map = [
                                            'electronics' => 'zap',
                                            'fashion' => 'tag',
                                            'home' => 'home',
                                            'sports' => 'activity',
                                            'books' => 'book',
                                        ];
                                        $icon = $icon_map[strtolower($category->slug)] ?? 'box';
                                        echo dst_get_icon($icon, 'w-5 h-5');
                                        ?>
                                    <?php endif; ?>
                                    <?php echo esc_html($category->name); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Main Menu -->
                <?php if (has_nav_menu('primary')): ?>
                    <nav class="p-6">
                        <h3 class="text-xs font-semibold uppercase tracking-wider mb-4 text-secondary-500">Menu</h3>
                        <?php
                        wp_nav_menu([
                            'theme_location' => 'primary',
                            'container' => false,
                            'menu_class' => 'space-y-3',
                            'fallback_cb' => false,
                            'depth' => 1,
                        ]);
                        ?>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<style>
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
