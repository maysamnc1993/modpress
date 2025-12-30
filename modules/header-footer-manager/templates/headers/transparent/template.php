<?php
/**
 * Header Template: Transparent
 * هدر شفاف برای استفاده روی Hero Section
 */

defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$is_sticky = $settings['sticky'] ?? true;
$show_search = $settings['show_search'] ?? true;
$show_cart = $settings['show_cart'] ?? true;
$show_account = $settings['show_account'] ?? true;
$bg_color = $settings['bg_color'] ?? '#ffffff';
?>

<header
    x-data="header"
    :class="{
        'bg-white shadow-md': isScrolled,
        'bg-transparent': !isScrolled
    }"
    class="<?php echo $is_sticky ? 'hf-header-sticky' : 'absolute'; ?> top-0 left-0 right-0 z-50 transition-all duration-300"
    :style="isScrolled ? 'background-color: <?php echo esc_attr($bg_color); ?>;' : ''"
>
    <div class="hf-container">
        <div class="flex items-center justify-between h-20">

            <!-- Logo -->
            <div class="flex-shrink-0">
                <?php dst_the_logo('light', 'h-10 w-auto max-w-[180px] object-contain'); ?>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex items-center gap-1">
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
                            :class="{ 'text-white hover:text-primary-400': !isScrolled, 'text-secondary-700 hover:text-primary-600': isScrolled }"
                            class="hf-icon-btn transition-colors"
                            aria-label="جستجو"
                        >
                            <?php echo dst_get_icon('search'); ?>
                        </button>

                        <div
                            x-show="searchOpen"
                            x-transition
                            @click.outside="searchOpen = false"
                            class="absolute top-full left-0 rtl:left-auto rtl:right-0 mt-2 w-80"
                        >
                            <?php echo dst_product_search_form(); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Cart -->
                <?php if ($show_cart && dst_is_woocommerce_active()): ?>
                    <div class="relative" x-data="miniCart">
                        <button 
                            @click="toggle()" 
                            :class="{ 'text-white hover:text-primary-400': !isScrolled, 'text-secondary-700 hover:text-primary-600': isScrolled }"
                            class="hf-cart-icon hf-icon-btn transition-colors">
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
                    <a href="<?php echo dst_get_account_url(); ?>"
                       :class="{ 'text-white hover:text-primary-400': !isScrolled, 'text-secondary-700 hover:text-primary-600': isScrolled }"
                       class="hf-icon-btn hidden md:flex transition-colors"
                       aria-label="حساب کاربری">
                        <?php echo dst_get_icon('user'); ?>
                    </a>
                <?php endif; ?>

                <!-- Mobile Menu Toggle -->
                <button
                    @click="toggleMobileMenu()"
                    :class="{ 'text-white': !isScrolled, 'text-secondary-700': isScrolled }"
                    class="lg:hidden hf-icon-btn transition-colors"
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

    <div class="hf-mobile-menu lg:hidden" :class="{ 'is-open': isMobileMenuOpen }">
        <div class="flex items-center justify-between p-4 border-b border-secondary-100">
            <span class="text-lg font-bold text-secondary-800">منو</span>
            <button @click="closeMobileMenu()" class="hf-icon-btn">
                <?php echo dst_get_icon('close'); ?>
            </button>
        </div>

        <?php if ($show_search): ?>
            <div class="p-4 border-b border-secondary-100">
                <?php echo dst_product_search_form(); ?>
            </div>
        <?php endif; ?>

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
            <div class="grid grid-cols-2 gap-3">
                <?php if ($show_cart && dst_is_woocommerce_active()): ?>
                    <a href="<?php echo dst_get_cart_url(); ?>" class="hf-btn hf-btn-primary">
                        <?php echo dst_get_icon('cart', 'w-5 h-5'); ?>
                        <span>سبد خرید</span>
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
