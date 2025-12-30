<?php
/**
 * Header Template: Split
 * هدر دو بخشی با تقسیم منو به دو طرف لوگو
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
    :class="{ 'shadow-md': isScrolled }"
    class="<?php echo $is_sticky ? 'hf-header-sticky' : 'relative bg-white'; ?> transition-all duration-300"
    style="background-color: <?php echo esc_attr($bg_color); ?>;"
>
    <div class="hf-container">
        <div class="flex items-center justify-between h-24">

            <!-- Left Navigation -->
            <nav class="hidden lg:flex items-center gap-1 flex-1">
                <?php
                // Get first half of menu items
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'hf-nav-menu',
                    'fallback_cb' => false,
                    'depth' => 2,
                    'items_wrap' => '<ul class="%2$s" data-split="left">%3$s</ul>',
                ]);
                ?>
            </nav>

            <!-- Centered Logo -->
            <div class="flex-shrink-0 px-8">
                <?php dst_the_logo('default', 'h-10 w-auto max-w-[180px] object-contain'); ?>
            </div>

            <!-- Right Navigation & Actions -->
            <div class="hidden lg:flex items-center gap-1 flex-1 justify-end">
                <nav class="flex items-center gap-1">
                    <?php
                    // Get second half of menu items
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'container' => false,
                        'menu_class' => 'hf-nav-menu',
                        'fallback_cb' => false,
                        'depth' => 2,
                        'items_wrap' => '<ul class="%2$s" data-split="right">%3$s</ul>',
                    ]);
                    ?>
                </nav>

                <div class="flex items-center gap-2 mr-4 rtl:mr-0 rtl:ml-4 border-r rtl:border-r-0 rtl:border-l border-secondary-200 pr-4 rtl:pr-0 rtl:pl-4">
                    <!-- Search -->
                    <?php if ($show_search): ?>
                        <button @click="toggleSearch()" class="hf-icon-btn" aria-label="جستجو">
                            <?php echo dst_get_icon('search'); ?>
                        </button>
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
                        <?php echo dst_account_icon(); ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Mobile: Logo & Actions -->
            <div class="lg:hidden flex items-center justify-between w-full">
                <!-- Mobile Logo -->
                <div class="flex-1">
                    <?php dst_the_logo('default', 'h-10 w-auto max-w-[180px] object-contain'); ?>
                </div>

                <!-- Mobile Actions -->
                <div class="flex items-center gap-2">
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

                    <button @click="toggleMobileMenu()" class="hf-icon-btn" aria-label="منو">
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
