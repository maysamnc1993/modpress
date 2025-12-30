<?php
/**
 * Header Template: Modern Minimal
 * Clean modern design with hamburger menu on all screens, centered logo, minimal icons
 */

defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$is_sticky = $settings['sticky'] ?? true;
$show_topbar = $settings['show_topbar'] ?? false;
$topbar_bg_color = $settings['topbar_bg_color'] ?? '#000000';
$topbar_text_color = $settings['topbar_text_color'] ?? '#ffffff';
$show_search = $settings['show_search'] ?? true;
$show_cart = $settings['show_cart'] ?? true;
$show_account = $settings['show_account'] ?? false;
$show_wishlist = $settings['show_wishlist'] ?? false;
$bg_color = $settings['bg_color'] ?? '#ffffff';
$text_color = $settings['text_color'] ?? '#000000';
$show_cta = $settings['show_cta'] ?? false;
$cta_text = $settings['cta_text'] ?? 'Contact';
$cta_url = $settings['cta_url'] ?? '/contact';
$cta_style = $settings['cta_style'] ?? 'outline';

$cta_button_class = match($cta_style) {
    'secondary' => 'hf-btn hf-btn-secondary',
    'outline' => 'hf-btn hf-btn-outline',
    default => 'hf-btn hf-btn-primary'
};
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
    <!-- Top Bar -->
    <?php if ($show_topbar): ?>
        <div class="text-sm text-center py-2" style="background-color: <?php echo esc_attr($topbar_bg_color); ?>; color: <?php echo esc_attr($topbar_text_color); ?>;">
            <div class="hf-container">
                <p>Free Shipping Worldwide | 30 Days Return Policy</p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Header -->
    <div class="hf-container">
        <div class="flex items-center justify-between h-20">
            <!-- Hamburger Menu (Left) -->
            <button
                @click="toggleMobileMenu()"
                class="hf-icon-btn order-1"
                :class="{ 'text-primary-600': isMobileMenuOpen }"
                aria-label="Menu"
            >
                <div class="hf-hamburger" :class="{ 'is-active': isMobileMenuOpen }">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>

            <!-- Centered Logo -->
            <div class="flex-1 flex justify-center order-2">
                <?php dst_the_logo('default', 'h-8 w-auto max-w-[160px] object-contain'); ?>
            </div>

            <!-- Icons (Right) -->
            <div class="flex items-center gap-3 order-3">
                <!-- Search -->
                <?php if ($show_search): ?>
                    <button
                        @click="toggleSearch()"
                        class="hf-icon-btn"
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
            class="border-t border-secondary-100"
            @click.outside="closeSearch()"
            style="display: none;"
        >
            <div class="hf-container py-8">
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
                <div class="flex-1 flex justify-center">
                    <?php dst_the_logo('default', 'h-8 w-auto max-w-[160px] object-contain'); ?>
                </div>
                <button @click="closeMobileMenu()" class="hf-icon-btn">
                    <?php echo dst_get_icon('close', 'w-6 h-6'); ?>
                </button>
            </div>

            <!-- Menu Content -->
            <div class="flex-1 overflow-y-auto">
                <nav class="p-8">
                    <div class="text-center space-y-6">
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
                    </div>
                </nav>

                <?php if ($show_cta): ?>
                    <div class="px-8 py-4">
                        <a href="<?php echo esc_url($cta_url); ?>" class="<?php echo esc_attr($cta_button_class); ?> w-full justify-center text-lg">
                            <?php echo esc_html($cta_text); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Menu Footer -->
            <div class="border-t border-secondary-100 p-6">
                <div class="flex items-center justify-center gap-6">
                    <?php
                    $social = dst_get_social();
                    foreach ($social as $platform => $url):
                        if (!empty($url)):
                    ?>
                        <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="text-secondary-600 hover:text-black transition-colors" aria-label="<?php echo esc_attr($platform); ?>">
                            <?php echo dst_get_icon($platform, 'w-5 h-5'); ?>
                        </a>
                    <?php
                        endif;
                    endforeach;
                    ?>
                </div>
            </div>
        </div>
    </div>
</header>
