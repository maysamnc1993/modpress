<?php
/**
 * Header Template: Mega Navigation
 * Full-width mega menu header with product category dropdowns showing images
 */

defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$is_sticky = $settings['sticky'] ?? true;
$mega_menu_columns = $settings['mega_menu_columns'] ?? '4';
$show_category_images = $settings['show_category_images'] ?? true;
$dropdown_animation = $settings['dropdown_animation'] ?? 'fade';
$show_search = $settings['show_search'] ?? true;
$show_cart = $settings['show_cart'] ?? true;
$show_account = $settings['show_account'] ?? true;
$show_wishlist = $settings['show_wishlist'] ?? true;
$bg_color = $settings['bg_color'] ?? '#ffffff';
$nav_bg_color = $settings['nav_bg_color'] ?? '#1e293b';
$nav_text_color = $settings['nav_text_color'] ?? '#ffffff';
$mega_bg_color = $settings['mega_bg_color'] ?? '#ffffff';
$mega_border_color = $settings['mega_border_color'] ?? '#e2e8f0';
$hover_color = $settings['hover_color'] ?? '#3b82f6';
$mega_width = $settings['mega_width'] ?? 'full';
$show_featured_products = $settings['show_featured_products'] ?? true;

$animation_class = match($dropdown_animation) {
    'slide' => 'mega-slide',
    'scale' => 'mega-scale',
    default => 'mega-fade'
};
?>

<style>
    .mega-nav-header .mega-menu-dropdown {
        opacity: 0;
        visibility: hidden;
        transform-origin: top;
        transition: all 0.3s ease;
    }

    .mega-nav-header .mega-menu-item:hover .mega-menu-dropdown {
        opacity: 1;
        visibility: visible;
    }

    .mega-fade .mega-menu-dropdown {
        transform: translateY(-10px);
    }

    .mega-fade .mega-menu-item:hover .mega-menu-dropdown {
        transform: translateY(0);
    }

    .mega-slide .mega-menu-dropdown {
        transform: translateY(-20px);
    }

    .mega-slide .mega-menu-item:hover .mega-menu-dropdown {
        transform: translateY(0);
    }

    .mega-scale .mega-menu-dropdown {
        transform: scale(0.95);
    }

    .mega-scale .mega-menu-item:hover .mega-menu-dropdown {
        transform: scale(1);
    }
</style>

<header
    x-data="header"
    :class="{
        'shadow-md': isScrolled,
        '-translate-y-full': isHidden && isScrolled
    }"
    class="mega-nav-header <?php echo $is_sticky ? 'hf-header-sticky' : 'relative'; ?> transition-all duration-300"
    style="background-color: <?php echo esc_attr($bg_color); ?>;"
>
    <!-- Top Bar with Logo, Search, and Actions -->
    <div class="hf-container">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <?php dst_the_logo('default', 'h-12 w-auto max-w-[200px] object-contain'); ?>
            </div>

            <!-- Search Bar -->
            <?php if ($show_search): ?>
                <div class="flex-1 max-w-2xl mx-8 hidden lg:block">
                    <div class="relative">
                        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="relative">
                            <input
                                type="search"
                                name="s"
                                placeholder="Search products, categories..."
                                class="w-full px-4 py-3 pr-12 border-2 border-secondary-200 rounded-lg focus:border-primary-500 focus:outline-none transition-colors"
                            />
                            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-secondary-600 hover:text-primary-600 transition-colors">
                                <?php echo dst_get_icon('search', 'w-5 h-5'); ?>
                            </button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Header Actions -->
            <div class="flex items-center gap-4">
                <!-- Wishlist -->
                <?php if ($show_wishlist && function_exists('YITH_WCWL')): ?>
                    <a href="<?php echo YITH_WCWL()->get_wishlist_url(); ?>" class="hf-icon-btn relative hidden lg:flex">
                        <?php echo dst_get_icon('heart', 'w-5 h-5'); ?>
                        <?php
                        $wishlist_count = YITH_WCWL()->count_products();
                        if ($wishlist_count > 0):
                        ?>
                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center"><?php echo $wishlist_count; ?></span>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>

                <!-- Account -->
                <?php if ($show_account): ?>
                    <a href="<?php echo dst_get_account_url(); ?>" class="hf-icon-btn hidden lg:flex">
                        <?php echo dst_get_icon('user', 'w-5 h-5'); ?>
                    </a>
                <?php endif; ?>

                <!-- Cart -->
                <?php if ($show_cart && dst_is_woocommerce_active()): ?>
                    <div class="relative" x-data="miniCart">
                        <button @click="toggle()" class="hf-icon-btn relative">
                            <?php echo dst_get_icon('shopping-bag', 'w-6 h-6'); ?>
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
    </div>

    <!-- Mega Navigation Bar -->
    <div class="<?php echo $animation_class; ?> hidden lg:block" style="background-color: <?php echo esc_attr($nav_bg_color); ?>; color: <?php echo esc_attr($nav_text_color); ?>;">
        <div class="hf-container">
            <nav class="flex items-center justify-center gap-8 py-4">
                <?php
                if (has_nav_menu('primary')) {
                    $menu_items = wp_get_nav_menu_items(wp_get_nav_menu_object(get_nav_menu_locations()['primary']));
                    $parent_items = array_filter($menu_items, function($item) {
                        return $item->menu_item_parent == 0;
                    });

                    foreach ($parent_items as $item):
                        $children = array_filter($menu_items, function($child) use ($item) {
                            return $child->menu_item_parent == $item->ID;
                        });
                        $has_children = !empty($children);
                ?>
                    <div class="mega-menu-item relative group">
                        <a
                            href="<?php echo esc_url($item->url); ?>"
                            class="flex items-center gap-2 px-4 py-2 font-medium transition-colors hover:text-opacity-80"
                            style="color: <?php echo esc_attr($nav_text_color); ?>;"
                        >
                            <?php echo esc_html($item->title); ?>
                            <?php if ($has_children): ?>
                                <?php echo dst_get_icon('chevron-down', 'w-4 h-4'); ?>
                            <?php endif; ?>
                        </a>

                        <?php if ($has_children): ?>
                            <div
                                class="mega-menu-dropdown absolute top-full left-1/2 -translate-x-1/2 mt-0 pt-2 z-50"
                                style="<?php echo $mega_width === 'full' ? 'width: 100vw; left: 50%; margin-left: -50vw;' : 'min-width: 600px;'; ?>"
                            >
                                <div
                                    class="rounded-lg shadow-2xl border p-8"
                                    style="background-color: <?php echo esc_attr($mega_bg_color); ?>; border-color: <?php echo esc_attr($mega_border_color); ?>;"
                                >
                                    <div class="grid grid-cols-<?php echo esc_attr($mega_menu_columns); ?> gap-6">
                                        <?php foreach ($children as $child): ?>
                                            <div>
                                                <a href="<?php echo esc_url($child->url); ?>" class="group/item block">
                                                    <?php if ($show_category_images && has_post_thumbnail($child->object_id)): ?>
                                                        <div class="aspect-square rounded-lg overflow-hidden mb-3">
                                                            <?php echo get_the_post_thumbnail($child->object_id, 'medium', ['class' => 'w-full h-full object-cover group-hover/item:scale-110 transition-transform duration-300']); ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    <h3 class="font-semibold text-secondary-900 group-hover/item:text-primary-600 transition-colors">
                                                        <?php echo esc_html($child->title); ?>
                                                    </h3>
                                                    <?php if ($child->description): ?>
                                                        <p class="text-sm text-secondary-600 mt-1"><?php echo esc_html($child->description); ?></p>
                                                    <?php endif; ?>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <?php if ($show_featured_products && dst_is_woocommerce_active()): ?>
                                        <div class="mt-8 pt-8 border-t" style="border-color: <?php echo esc_attr($mega_border_color); ?>;">
                                            <h4 class="font-semibold text-secondary-900 mb-4">Featured Products</h4>
                                            <div class="grid grid-cols-4 gap-4">
                                                <?php
                                                $featured = wc_get_products(['limit' => 4, 'featured' => true]);
                                                foreach ($featured as $product):
                                                ?>
                                                    <a href="<?php echo esc_url($product->get_permalink()); ?>" class="group/product block">
                                                        <div class="aspect-square rounded-lg overflow-hidden mb-2">
                                                            <?php echo $product->get_image('thumbnail', ['class' => 'w-full h-full object-cover group-hover/product:scale-110 transition-transform duration-300']); ?>
                                                        </div>
                                                        <p class="text-sm font-medium text-secondary-900 group-hover/product:text-primary-600 transition-colors truncate">
                                                            <?php echo esc_html($product->get_name()); ?>
                                                        </p>
                                                        <p class="text-sm text-primary-600 font-semibold">
                                                            <?php echo $product->get_price_html(); ?>
                                                        </p>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php
                    endforeach;
                }
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
            <span class="text-lg font-bold text-secondary-800">Menu</span>
            <button @click="closeMobileMenu()" class="hf-icon-btn">
                <?php echo dst_get_icon('close'); ?>
            </button>
        </div>

        <?php if ($show_search): ?>
            <div class="p-4 border-b border-secondary-100">
                <?php get_search_form(); ?>
            </div>
        <?php endif; ?>

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
