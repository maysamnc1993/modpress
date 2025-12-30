<?php
/**
 * Header Template: Minimal
 * هدر ساده و مینیمال - فقط لوگو و منو
 */

defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$is_sticky = $settings['sticky'] ?? false;
$show_search = $settings['show_search'] ?? false;
$show_cart = $settings['show_cart'] ?? false;
$show_account = $settings['show_account'] ?? false;
$bg_color = $settings['bg_color'] ?? '#ffffff';
?>

<header
    x-data="header"
    class="<?php echo $is_sticky ? 'hf-header-sticky' : 'relative'; ?> transition-all duration-300 border-b border-secondary-100"
    style="background-color: <?php echo esc_attr($bg_color); ?>;"
>
    <div class="hf-container">
        <div class="flex items-center justify-between h-16 lg:h-20">

            <!-- Logo -->
            <div class="flex-shrink-0">
                <?php dst_the_logo('default', 'h-10 w-auto max-w-[180px] object-contain'); ?>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex items-center">
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
            <div class="flex items-center gap-2">

                <!-- Search -->
                <?php if ($show_search): ?>
                    <button @click="toggleSearch()" class="hf-icon-btn hidden md:flex" aria-label="جستجو">
                        <?php echo dst_get_icon('search'); ?>
                    </button>
                <?php endif; ?>

                <!-- Cart -->
                <?php if ($show_cart && dst_is_woocommerce_active()): ?>
                    <div class="relative hidden md:block" x-data="miniCart">
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
                    <?php echo dst_account_icon('hidden md:block'); ?>
                <?php endif; ?>

                <!-- Mobile Menu Toggle -->
                <button
                    @click="toggleMobileMenu()"
                    class="lg:hidden hf-icon-btn"
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

    <!-- Search Overlay -->
    <?php if ($show_search): ?>
        <div x-show="isSearchOpen" x-transition @click.outside="closeSearch()" class="absolute top-full left-0 right-0 bg-white shadow-lg p-4 z-50 border-t border-secondary-100">
            <div class="hf-container max-w-2xl mx-auto">
                <?php echo dst_product_search_form(); ?>
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
            <span class="text-lg font-bold text-secondary-800">منو</span>
            <button @click="closeMobileMenu()" class="hf-icon-btn">
                <?php echo dst_get_icon('close'); ?>
            </button>
        </div>

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

        <!-- Mobile Actions -->
        <?php if ($show_cart || $show_account): ?>
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
        <?php endif; ?>
    </div>
</header>
