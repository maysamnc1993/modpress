<?php
/**
 * Header Template: Dual Row Header
 * Two-row header with top info bar and bottom navigation
 */

defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$is_sticky = $settings['sticky'] ?? true;
$show_row1 = $settings['show_row1'] ?? true;
$row1_bg_color = $settings['row1_bg_color'] ?? '#1e293b';
$row1_text_color = $settings['row1_text_color'] ?? '#ffffff';
$row2_bg_color = $settings['row2_bg_color'] ?? '#ffffff';
$row2_text_color = $settings['row2_text_color'] ?? '#000000';
$show_contact_info = $settings['show_contact_info'] ?? true;
$show_social = $settings['show_social'] ?? true;
$show_language_switcher = $settings['show_language_switcher'] ?? false;
$top_row_message = $settings['top_row_message'] ?? 'Free Shipping on Orders Over $50';
$show_search = $settings['show_search'] ?? true;
$show_cart = $settings['show_cart'] ?? true;
$show_account = $settings['show_account'] ?? true;
$show_wishlist = $settings['show_wishlist'] ?? true;
$sticky_mode = $settings['sticky_mode'] ?? 'both';
$show_cta = $settings['show_cta'] ?? true;
$cta_text = $settings['cta_text'] ?? 'Get Quote';
$cta_url = $settings['cta_url'] ?? '/contact';

$sticky_class = match($sticky_mode) {
    'row2' => 'dual-row-sticky-bottom',
    'none' => 'relative',
    default => 'hf-header-sticky'
};
?>

<style>
    .dual-row-sticky-bottom .row-2 {
        position: sticky;
        top: 0;
        z-index: 50;
    }
</style>

<header
    x-data="header"
    class="<?php echo $sticky_class; ?> transition-all duration-300"
>
    <!-- Row 1: Top Info Bar -->
    <?php if ($show_row1): ?>
        <div
            class="row-1 text-sm py-2.5 hidden lg:block"
            style="background-color: <?php echo esc_attr($row1_bg_color); ?>; color: <?php echo esc_attr($row1_text_color); ?>;"
        >
            <div class="hf-container">
                <div class="flex items-center justify-between">
                    <!-- Left: Message/Contact -->
                    <div class="flex items-center gap-6">
                        <?php if ($top_row_message): ?>
                            <div class="flex items-center gap-2">
                                <?php echo dst_get_icon('truck', 'w-4 h-4'); ?>
                                <span><?php echo esc_html($top_row_message); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if ($show_contact_info): ?>
                            <?php
                            $contact = dst_get_contact();
                            if (!empty($contact['phone'])):
                            ?>
                                <a href="tel:<?php echo esc_attr($contact['phone']); ?>" class="flex items-center gap-2 hover:text-primary-400 transition-colors">
                                    <?php echo dst_get_icon('phone', 'w-4 h-4'); ?>
                                    <span><?php echo esc_html($contact['phone']); ?></span>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($contact['email'])): ?>
                                <a href="mailto:<?php echo esc_attr($contact['email']); ?>" class="flex items-center gap-2 hover:text-primary-400 transition-colors">
                                    <?php echo dst_get_icon('mail', 'w-4 h-4'); ?>
                                    <span><?php echo esc_html($contact['email']); ?></span>
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Right: Social, Language, Account -->
                    <div class="flex items-center gap-4">
                        <?php if ($show_social): ?>
                            <div class="flex items-center gap-3">
                                <?php
                                $social = dst_get_social();
                                foreach ($social as $platform => $url):
                                    if (!empty($url)):
                                ?>
                                    <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="hover:text-primary-400 transition-colors" aria-label="<?php echo esc_attr($platform); ?>">
                                        <?php echo dst_get_icon($platform, 'w-4 h-4'); ?>
                                    </a>
                                <?php
                                    endif;
                                endforeach;
                                ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($show_language_switcher && function_exists('pll_the_languages')): ?>
                            <div class="flex items-center gap-2 border-l pl-4" style="border-color: rgba(255,255,255,0.2);">
                                <?php
                                pll_the_languages([
                                    'dropdown' => 1,
                                    'show_flags' => 1,
                                    'show_names' => 0,
                                ]);
                                ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($show_account): ?>
                            <a href="<?php echo dst_get_account_url(); ?>" class="flex items-center gap-2 hover:text-primary-400 transition-colors border-l pl-4" style="border-color: rgba(255,255,255,0.2);">
                                <?php echo dst_get_icon('user', 'w-4 h-4'); ?>
                                <span><?php echo is_user_logged_in() ? 'My Account' : 'Login'; ?></span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Row 2: Main Navigation -->
    <div
        class="row-2 shadow-sm"
        :class="{ 'shadow-md': isScrolled }"
        style="background-color: <?php echo esc_attr($row2_bg_color); ?>; color: <?php echo esc_attr($row2_text_color); ?>;"
    >
        <div class="hf-container">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <?php dst_the_logo('default', 'h-12 w-auto max-w-[180px] object-contain'); ?>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex items-center gap-8 flex-1 justify-center">
                    <?php
                    if (has_nav_menu('primary')) {
                        wp_nav_menu([
                            'theme_location' => 'primary',
                            'container' => false,
                            'menu_class' => 'flex items-center gap-8',
                            'fallback_cb' => false,
                            'depth' => 2,
                            'link_before' => '<span class="font-medium hover:text-primary-600 transition-colors">',
                            'link_after' => '</span>',
                        ]);
                    }
                    ?>
                </nav>

                <!-- Actions -->
                <div class="flex items-center gap-4">
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

                    <!-- Cart -->
                    <?php if ($show_cart && dst_is_woocommerce_active()): ?>
                        <div class="relative" x-data="miniCart">
                            <button @click="toggle()" class="hf-icon-btn relative">
                                <?php echo dst_get_icon('shopping-bag', 'w-5 h-5'); ?>
                                <?php if (dst_get_cart_count() > 0): ?>
                                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-primary-600 text-white text-xs rounded-full flex items-center justify-center"><?php echo dst_get_cart_count(); ?></span>
                                <?php endif; ?>
                            </button>
                            <?php echo dst_mini_cart(); ?>
                        </div>
                    <?php endif; ?>

                    <!-- CTA Button -->
                    <?php if ($show_cta): ?>
                        <a
                            href="<?php echo esc_url($cta_url); ?>"
                            class="hidden lg:inline-flex hf-btn hf-btn-primary"
                        >
                            <?php echo esc_html($cta_text); ?>
                        </a>
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
                x-transition:enter-start="opacity-0 max-h-0"
                x-transition:enter-end="opacity-100 max-h-24"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 max-h-24"
                x-transition:leave-end="opacity-0 max-h-0"
                class="border-t border-secondary-100 overflow-hidden"
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

        <?php if ($show_cta): ?>
            <div class="p-4 border-t border-secondary-100">
                <a href="<?php echo esc_url($cta_url); ?>" class="hf-btn hf-btn-primary w-full justify-center">
                    <?php echo esc_html($cta_text); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</header>
