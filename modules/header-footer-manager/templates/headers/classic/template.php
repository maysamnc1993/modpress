<?php
/**
 * Header Template: Classic
 * هدر کلاسیک با لوگو سمت راست و منو سمت چپ
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
        'shadow-md': isScrolled,
        '-translate-y-full': isHidden && isScrolled
    }"
    class="<?php echo $is_sticky ? 'hf-header-sticky' : 'relative bg-white'; ?> transition-all duration-300"
    style="background-color: <?php echo esc_attr($bg_color); ?>;"
>
    <!-- Top Bar (Optional) -->
    <?php
    $phone = dst_get_contact('phone');
    $email = dst_get_contact('email');
    $has_contact = $phone || $email;
    $has_social = dst_get_social('instagram') || dst_get_social('telegram') || dst_get_social('whatsapp');
    ?>
    <?php if ($has_contact || $has_social): ?>
    <div class="bg-secondary-800 text-white py-2 hidden lg:block">
        <div class="hf-container">
            <div class="flex items-center justify-between text-sm">
                <div class="flex items-center gap-4">
                    <?php if ($phone): ?>
                        <a href="tel:<?php echo esc_attr($phone); ?>" class="flex items-center gap-1 hover:text-primary-400 transition-colors">
                            <?php echo dst_get_icon('phone', 'w-4 h-4'); ?>
                            <span><?php echo esc_html($phone); ?></span>
                        </a>
                    <?php endif; ?>
                    <?php if ($email): ?>
                        <a href="mailto:<?php echo esc_attr($email); ?>" class="flex items-center gap-1 hover:text-primary-400 transition-colors">
                            <?php echo dst_get_icon('mail', 'w-4 h-4'); ?>
                            <span><?php echo esc_html($email); ?></span>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="flex items-center gap-3">
                    <?php
                    $social_networks = ['instagram', 'telegram', 'whatsapp', 'twitter'];
                    foreach ($social_networks as $network):
                        $url = dst_get_social($network);
                        if (!$url) continue;
                    ?>
                        <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener" class="hover:text-primary-400 transition-colors">
                            <?php echo dst_get_icon($network, 'w-4 h-4'); ?>
                        </a>
                    <?php endforeach; ?>
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
                <?php dst_the_logo('default', 'h-10 w-auto max-w-[180px] object-contain'); ?>
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
                            class="hf-icon-btn"
                            aria-label="جستجو"
                        >
                            <?php echo dst_get_icon('search'); ?>
                        </button>

                        <!-- Search Dropdown -->
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

                <!-- Wishlist -->
                <?php if (function_exists('YITH_WCWL')): ?>
                    <?php echo dst_wishlist_icon('hidden md:flex'); ?>
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
                    <?php echo dst_account_icon('hidden md:block'); ?>
                <?php endif; ?>

                <!-- Mobile Menu Toggle -->
                <button
                    @click="toggleMobileMenu()"
                    class="lg:hidden hf-icon-btn"
                    :class="{ 'text-primary-600': isMobileMenuOpen }"
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

    <div
        class="hf-mobile-menu lg:hidden"
        :class="{ 'is-open': isMobileMenuOpen }"
        x-data="mobileMenu"
    >
        <div class="flex items-center justify-between p-4 border-b border-secondary-100">
            <span class="text-lg font-bold text-secondary-800">منو</span>
            <button @click="$dispatch('close-mobile-menu')" class="hf-icon-btn">
                <?php echo dst_get_icon('close'); ?>
            </button>
        </div>

        <!-- Mobile Search -->
        <?php if ($show_search): ?>
            <div class="p-4 border-b border-secondary-100">
                <?php echo dst_product_search_form(); ?>
            </div>
        <?php endif; ?>

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

        <!-- Mobile Account & Cart -->
        <div class="p-4 border-t border-secondary-100 mt-auto">
            <div class="grid grid-cols-2 gap-3">
                <?php if ($show_cart && dst_is_woocommerce_active()): ?>
                    <a href="<?php echo dst_get_cart_url(); ?>" class="hf-btn hf-btn-primary">
                        <?php echo dst_get_icon('cart', 'w-5 h-5'); ?>
                        <span>سبد خرید</span>
                        <?php if (dst_get_cart_count() > 0): ?>
                            <span class="hf-badge bg-white text-primary-600"><?php echo dst_get_cart_count(); ?></span>
                        <?php endif; ?>
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
