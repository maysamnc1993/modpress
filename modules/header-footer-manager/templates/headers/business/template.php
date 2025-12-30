<?php
/**
 * Header Template: Business Professional
 * Professional business header with top bar, logo, navigation, and CTA button
 */

defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$is_sticky = $settings['sticky'] ?? true;
$show_topbar = $settings['show_topbar'] ?? true;
$topbar_bg_color = $settings['topbar_bg_color'] ?? '#1e293b';
$topbar_text_color = $settings['topbar_text_color'] ?? '#ffffff';
$show_search = $settings['show_search'] ?? true;
$show_cart = $settings['show_cart'] ?? false;
$show_account = $settings['show_account'] ?? false;
$show_wishlist = $settings['show_wishlist'] ?? false;
$bg_color = $settings['bg_color'] ?? '#ffffff';
$text_color = $settings['text_color'] ?? '#1e293b';
$show_cta = $settings['show_cta'] ?? true;
$cta_text = $settings['cta_text'] ?? 'Get Started';
$cta_url = $settings['cta_url'] ?? '/contact';
$cta_style = $settings['cta_style'] ?? 'primary';

$cta_button_class = match($cta_style) {
    'secondary' => 'hf-btn hf-btn-secondary',
    'outline' => 'hf-btn hf-btn-outline',
    default => 'hf-btn hf-btn-primary'
};
?>

<header
    x-data="header"
    :class="{
        'shadow-lg': isScrolled,
        '-translate-y-full': isHidden && isScrolled
    }"
    class="<?php echo $is_sticky ? 'hf-header-sticky' : 'relative'; ?> transition-all duration-300"
    style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;"
>
    <!-- Top Bar -->
    <?php if ($show_topbar): ?>
        <div class="border-b border-secondary-100 hidden lg:block" style="background-color: <?php echo esc_attr($topbar_bg_color); ?>; color: <?php echo esc_attr($topbar_text_color); ?>;">
            <div class="hf-container">
                <div class="flex items-center justify-between py-2 text-sm">
                    <!-- Contact Info -->
                    <div class="flex items-center gap-6">
                        <?php
                        $contact = dst_get_contact();
                        if (!empty($contact['email'])):
                        ?>
                            <a href="mailto:<?php echo esc_attr($contact['email']); ?>" class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                                <?php echo dst_get_icon('mail', 'w-4 h-4'); ?>
                                <span><?php echo esc_html($contact['email']); ?></span>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($contact['phone'])): ?>
                            <a href="tel:<?php echo esc_attr($contact['phone']); ?>" class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                                <?php echo dst_get_icon('phone', 'w-4 h-4'); ?>
                                <span><?php echo esc_html($contact['phone']); ?></span>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($contact['address'])): ?>
                            <span class="flex items-center gap-2">
                                <?php echo dst_get_icon('map-pin', 'w-4 h-4'); ?>
                                <span><?php echo esc_html($contact['address']); ?></span>
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- Social Links -->
                    <div class="flex items-center gap-3">
                        <?php
                        $social = dst_get_social();
                        foreach ($social as $platform => $url):
                            if (!empty($url)):
                        ?>
                            <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="hover:opacity-80 transition-opacity" aria-label="<?php echo esc_attr($platform); ?>">
                                <?php echo dst_get_icon($platform, 'w-4 h-4'); ?>
                            </a>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Header -->
    <div class="hf-container">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <?php dst_the_logo('default', 'h-12 w-auto max-w-[200px] object-contain'); ?>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex items-center gap-8 flex-1 justify-center">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'hf-nav-menu',
                    'fallback_cb' => false,
                    'depth' => 2,
                ]);
                ?>
            </nav>

            <!-- Header Actions -->
            <div class="flex items-center gap-4">
                <!-- Search -->
                <?php if ($show_search): ?>
                    <button
                        @click="toggleSearch()"
                        class="hidden lg:flex hf-icon-btn"
                        aria-label="Search"
                    >
                        <?php echo dst_get_icon('search', 'w-5 h-5'); ?>
                    </button>
                <?php endif; ?>

                <!-- Wishlist -->
                <?php if ($show_wishlist && function_exists('YITH_WCWL')): ?>
                    <a href="<?php echo YITH_WCWL()->get_wishlist_url(); ?>" class="hidden lg:flex hf-icon-btn relative">
                        <?php echo dst_get_icon('heart', 'w-5 h-5'); ?>
                        <?php
                        $wishlist_count = YITH_WCWL()->count_products();
                        if ($wishlist_count > 0):
                        ?>
                            <span class="absolute -top-1 -right-1 hf-badge hf-badge-primary text-xs"><?php echo $wishlist_count; ?></span>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>

                <!-- Cart -->
                <?php if ($show_cart && dst_is_woocommerce_active()): ?>
                    <div class="relative hidden lg:block" x-data="miniCart">
                        <button @click="toggle()" class="hf-icon-btn relative">
                            <?php echo dst_get_icon('cart', 'w-5 h-5'); ?>
                            <?php if (dst_get_cart_count() > 0): ?>
                                <span class="absolute -top-1 -right-1 hf-badge hf-badge-primary text-xs"><?php echo dst_get_cart_count(); ?></span>
                            <?php endif; ?>
                        </button>
                        <?php echo dst_mini_cart(); ?>
                    </div>
                <?php endif; ?>

                <!-- Account -->
                <?php if ($show_account): ?>
                    <a href="<?php echo dst_get_account_url(); ?>" class="hidden lg:flex hf-icon-btn">
                        <?php echo dst_get_icon('user', 'w-5 h-5'); ?>
                    </a>
                <?php endif; ?>

                <!-- CTA Button -->
                <?php if ($show_cta): ?>
                    <a href="<?php echo esc_url($cta_url); ?>" class="hidden lg:inline-flex <?php echo esc_attr($cta_button_class); ?>">
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
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black bg-opacity-50 z-50"
            @click="closeSearch()"
            style="display: none;"
        >
            <div class="hf-container">
                <div class="max-w-3xl mx-auto mt-24">
                    <div class="bg-white rounded-lg p-6 shadow-2xl" @click.stop>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold">Search</h3>
                            <button @click="closeSearch()" class="hf-icon-btn">
                                <?php echo dst_get_icon('close', 'w-6 h-6'); ?>
                            </button>
                        </div>
                        <?php get_search_form(); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Mobile Menu -->
    <div
        class="hf-mobile-menu-overlay lg:hidden"
        :class="{ 'is-open': isMobileMenuOpen }"
        @click="closeMobileMenu()"
    ></div>

    <div class="hf-mobile-menu lg:hidden" :class="{ 'is-open': isMobileMenuOpen }">
        <div class="flex items-center justify-between p-4 border-b border-secondary-100">
            <span class="text-lg font-bold">Menu</span>
            <button @click="closeMobileMenu()" class="hf-icon-btn">
                <?php echo dst_get_icon('close'); ?>
            </button>
        </div>

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

        <div class="p-4 border-t border-secondary-100 mt-auto">
            <?php if ($show_cta): ?>
                <a href="<?php echo esc_url($cta_url); ?>" class="<?php echo esc_attr($cta_button_class); ?> w-full justify-center">
                    <?php echo esc_html($cta_text); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>
