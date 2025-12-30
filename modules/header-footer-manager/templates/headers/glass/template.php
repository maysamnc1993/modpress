<?php
/**
 * Header Template: Glassmorphism
 * Modern glassmorphism effect with backdrop blur
 */

defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$is_sticky = $settings['sticky'] ?? true;
$blur_amount = $settings['blur_amount'] ?? 'md';
$opacity = $settings['opacity'] ?? '80';
$bg_color = $settings['bg_color'] ?? '#ffffff';
$text_color = $settings['text_color'] ?? '#000000';
$border_color = $settings['border_color'] ?? '#ffffff';
$border_opacity = $settings['border_opacity'] ?? '20';
$show_search = $settings['show_search'] ?? true;
$show_cart = $settings['show_cart'] ?? true;
$show_account = $settings['show_account'] ?? true;
$show_wishlist = $settings['show_wishlist'] ?? false;
$logo_position = $settings['logo_position'] ?? 'left';
$menu_position = $settings['menu_position'] ?? 'right';
$show_social = $settings['show_social'] ?? true;
$glass_style = $settings['glass_style'] ?? 'modern';

$blur_class = match($blur_amount) {
    'sm' => 'backdrop-blur-sm',
    'lg' => 'backdrop-blur-lg',
    'xl' => 'backdrop-blur-xl',
    default => 'backdrop-blur-md'
};

// Convert hex to rgba
$bg_rgb = sscanf($bg_color, "#%02x%02x%02x");
$bg_rgba = "rgba({$bg_rgb[0]}, {$bg_rgb[1]}, {$bg_rgb[2]}, 0.{$opacity})";

$border_rgb = sscanf($border_color, "#%02x%02x%02x");
$border_rgba = "rgba({$border_rgb[0]}, {$border_rgb[1]}, {$border_rgb[2]}, 0.{$border_opacity})";

$glass_shadow = match($glass_style) {
    'frosted' => 'shadow-2xl',
    'minimal' => 'shadow-sm',
    default => 'shadow-lg'
};

$menu_justify = match($menu_position) {
    'left' => 'justify-start',
    'center' => 'justify-center',
    default => 'justify-end'
};
?>

<header
    x-data="header"
    :class="{
        '<?php echo $glass_shadow; ?>': isScrolled
    }"
    class="<?php echo $is_sticky ? 'hf-header-sticky' : 'relative'; ?> <?php echo $blur_class; ?> transition-all duration-300 border-b"
    style="
        background: <?php echo $bg_rgba; ?>;
        color: <?php echo esc_attr($text_color); ?>;
        border-color: <?php echo $border_rgba; ?>;
    "
>
    <div class="hf-container">
        <div class="flex items-center <?php echo $logo_position === 'center' ? 'justify-between' : 'justify-start'; ?> gap-8 h-20">
            <?php if ($logo_position === 'center'): ?>
                <!-- Left Spacer for Center Logo -->
                <div class="flex-1 flex items-center <?php echo $menu_justify; ?> gap-8">
                    <nav class="hidden lg:flex">
                        <?php
                        if (has_nav_menu('primary')) {
                            $menu_items = wp_get_nav_menu_items(wp_get_nav_menu_object(get_nav_menu_locations()['primary']));
                            if ($menu_items) {
                                $half = ceil(count($menu_items) / 2);
                                $first_half = array_slice($menu_items, 0, $half);
                                echo '<div class="flex items-center gap-8">';
                                foreach ($first_half as $item) {
                                    if ($item->menu_item_parent == 0) {
                                        echo '<a href="' . esc_url($item->url) . '" class="font-medium hover:text-primary-600 transition-colors">' . esc_html($item->title) . '</a>';
                                    }
                                }
                                echo '</div>';
                            }
                        }
                        ?>
                    </nav>
                </div>

                <!-- Centered Logo -->
                <div class="flex-shrink-0">
                    <?php dst_the_logo('default', 'h-12 w-auto max-w-[160px] object-contain'); ?>
                </div>

                <!-- Right Side Menu -->
                <div class="flex-1 flex items-center justify-end gap-8">
                    <nav class="hidden lg:flex">
                        <?php
                        if (has_nav_menu('primary')) {
                            $menu_items = wp_get_nav_menu_items(wp_get_nav_menu_object(get_nav_menu_locations()['primary']));
                            if ($menu_items) {
                                $half = ceil(count($menu_items) / 2);
                                $second_half = array_slice($menu_items, $half);
                                echo '<div class="flex items-center gap-8">';
                                foreach ($second_half as $item) {
                                    if ($item->menu_item_parent == 0) {
                                        echo '<a href="' . esc_url($item->url) . '" class="font-medium hover:text-primary-600 transition-colors">' . esc_html($item->title) . '</a>';
                                    }
                                }
                                echo '</div>';
                            }
                        }
                        ?>
                    </nav>
                </div>
            <?php else: ?>
                <!-- Logo on Left -->
                <div class="flex-shrink-0">
                    <?php dst_the_logo('default', 'h-12 w-auto max-w-[160px] object-contain'); ?>
                </div>

                <!-- Navigation -->
                <nav class="hidden lg:flex flex-1 items-center <?php echo $menu_justify; ?> gap-8">
                    <?php
                    if (has_nav_menu('primary')) {
                        wp_nav_menu([
                            'theme_location' => 'primary',
                            'container' => false,
                            'menu_class' => 'flex items-center gap-8',
                            'fallback_cb' => false,
                            'depth' => 1,
                            'link_before' => '<span class="font-medium hover:text-primary-600 transition-colors">',
                            'link_after' => '</span>',
                        ]);
                    }
                    ?>
                </nav>
            <?php endif; ?>

            <!-- Actions -->
            <div class="flex items-center gap-3">
                <!-- Social Icons -->
                <?php if ($show_social): ?>
                    <div class="hidden xl:flex items-center gap-3 mr-3 pr-3 border-r" style="border-color: <?php echo $border_rgba; ?>;">
                        <?php
                        $social = dst_get_social();
                        $social_count = 0;
                        foreach ($social as $platform => $url):
                            if (!empty($url) && $social_count < 3):
                                $social_count++;
                        ?>
                            <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="text-secondary-600 hover:text-primary-600 transition-colors" aria-label="<?php echo esc_attr($platform); ?>">
                                <?php echo dst_get_icon($platform, 'w-4 h-4'); ?>
                            </a>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                <?php endif; ?>

                <!-- Search -->
                <?php if ($show_search): ?>
                    <button
                        @click="toggleSearch()"
                        class="hf-icon-btn hidden md:flex"
                        aria-label="Search"
                    >
                        <?php echo dst_get_icon('search', 'w-5 h-5'); ?>
                    </button>
                <?php endif; ?>

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
                    <a href="<?php echo dst_get_account_url(); ?>" class="hf-icon-btn hidden md:flex">
                        <?php echo dst_get_icon('user', 'w-5 h-5'); ?>
                    </a>
                <?php endif; ?>

                <!-- Cart -->
                <?php if ($show_cart && dst_is_woocommerce_active()): ?>
                    <div class="relative" x-data="miniCart">
                        <button @click="toggle()" class="hf-icon-btn relative">
                            <?php echo dst_get_icon('shopping-bag', 'w-5 h-5'); ?>
                            <?php if (dst_get_cart_count() > 0): ?>
                                <span class="absolute -top-1 -right-1 w-4 h-4 bg-primary-600 text-white text-xs rounded-full flex items-center justify-center"><?php echo dst_get_cart_count(); ?></span>
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

    <!-- Search Overlay -->
    <?php if ($show_search): ?>
        <div
            x-show="isSearchOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4"
            class="border-t"
            style="border-color: <?php echo $border_rgba; ?>; background: <?php echo $bg_rgba; ?>;"
            @click.outside="closeSearch()"
            style="display: none;"
        >
            <div class="hf-container py-6">
                <div class="max-w-2xl mx-auto">
                    <div class="relative">
                        <?php get_search_form(); ?>
                        <button @click="closeSearch()" class="absolute top-1/2 right-4 -translate-y-1/2">
                            <?php echo dst_get_icon('close', 'w-5 h-5'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Mobile Menu -->
    <div
        class="fixed inset-0 z-50 lg:hidden <?php echo $blur_class; ?>"
        :class="{ 'pointer-events-none': !isMobileMenuOpen }"
        x-show="isMobileMenuOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="display: none; background: <?php echo $bg_rgba; ?>;"
    >
        <div class="h-full flex flex-col">
            <!-- Menu Header -->
            <div class="flex items-center justify-between p-6 border-b" style="border-color: <?php echo $border_rgba; ?>;">
                <?php dst_the_logo('default', 'h-8 w-auto max-w-[140px] object-contain'); ?>
                <button @click="closeMobileMenu()" class="hf-icon-btn">
                    <?php echo dst_get_icon('close', 'w-6 h-6'); ?>
                </button>
            </div>

            <!-- Menu Content -->
            <div class="flex-1 overflow-y-auto p-8">
                <nav class="space-y-6">
                    <?php
                    if (has_nav_menu('primary')) {
                        wp_nav_menu([
                            'theme_location' => 'primary',
                            'container' => false,
                            'menu_class' => 'space-y-6 text-2xl font-light',
                            'fallback_cb' => false,
                            'depth' => 1,
                        ]);
                    }
                    ?>
                </nav>
            </div>

            <!-- Menu Footer -->
            <?php if ($show_social): ?>
                <div class="border-t p-6" style="border-color: <?php echo $border_rgba; ?>;">
                    <div class="flex items-center justify-center gap-6">
                        <?php
                        $social = dst_get_social();
                        foreach ($social as $platform => $url):
                            if (!empty($url)):
                        ?>
                            <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="text-secondary-600 hover:text-primary-600 transition-colors" aria-label="<?php echo esc_attr($platform); ?>">
                                <?php echo dst_get_icon($platform, 'w-5 h-5'); ?>
                            </a>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>
