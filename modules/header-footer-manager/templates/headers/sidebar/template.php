<?php
/**
 * Header Template: Sidebar
 * هدر با منوی کشویی کناری
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
        <div class="flex items-center justify-between h-20">

            <!-- Menu Toggle (Desktop & Mobile) -->
            <button
                @click="toggleMobileMenu()"
                class="hf-icon-btn"
                :class="{ 'text-primary-600': isMobileMenuOpen }"
                aria-label="منو"
            >
                <div class="hf-hamburger" :class="{ 'is-active': isMobileMenuOpen }">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>

            <!-- Logo (Centered) -->
            <div class="absolute left-1/2 transform -translate-x-1/2">
                <?php if (has_custom_logo()): ?>
                    <a href="<?php echo home_url('/'); ?>" class="block">
                        <?php
                        $logo_id = get_theme_mod('custom_logo');
                        $logo_url = wp_get_attachment_image_url($logo_id, 'full');
                        ?>
                        <img src="<?php echo esc_url($logo_url); ?>"
                             alt="<?php bloginfo('name'); ?>"
                             class="h-10 w-auto max-w-[180px] object-contain">
                    </a>
                <?php else: ?>
                    <a href="<?php echo home_url('/'); ?>" class="text-xl font-bold text-secondary-800 hover:text-primary-600 transition-colors">
                        <?php bloginfo('name'); ?>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Header Actions -->
            <div class="flex items-center gap-2">

                <!-- Search -->
                <?php if ($show_search): ?>
                    <button @click="toggleSearch()" class="hf-icon-btn hidden md:flex" aria-label="جستجو">
                        <?php echo dst_get_icon('search'); ?>
                    </button>
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
                    <?php echo dst_account_icon('hidden md:flex'); ?>
                <?php endif; ?>
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

    <!-- Sidebar Menu -->
    <div
        class="hf-mobile-menu-overlay"
        :class="{ 'is-open': isMobileMenuOpen }"
        @click="closeMobileMenu()"
    ></div>

    <div 
        class="fixed top-0 right-0 rtl:right-auto rtl:left-0 h-full w-80 max-w-[85vw] bg-white shadow-2xl z-[9999] transform transition-transform duration-300"
        :class="{ 'translate-x-0 rtl:-translate-x-0': isMobileMenuOpen, 'translate-x-full rtl:-translate-x-full': !isMobileMenuOpen }"
    >
        <!-- Sidebar Header -->
        <div class="flex items-center justify-between p-6 border-b border-secondary-100 bg-primary-600 text-white">
            <?php if (has_custom_logo()): ?>
                <a href="<?php echo home_url('/'); ?>" class="block">
                    <?php
                    $logo_id = get_theme_mod('custom_logo');
                    $logo_url = wp_get_attachment_image_url($logo_id, 'full');
                    ?>
                    <img src="<?php echo esc_url($logo_url); ?>"
                         alt="<?php bloginfo('name'); ?>"
                         class="h-8 w-auto filter brightness-0 invert">
                </a>
            <?php else: ?>
                <span class="text-lg font-bold"><?php bloginfo('name'); ?></span>
            <?php endif; ?>
            <button @click="closeMobileMenu()" class="text-white hover:text-primary-200 transition-colors">
                <?php echo dst_get_icon('close', 'w-6 h-6'); ?>
            </button>
        </div>

        <!-- Sidebar Content -->
        <div class="h-[calc(100%-73px)] overflow-y-auto">
            
            <!-- User Info -->
            <?php if ($show_account): ?>
                <div class="p-6 border-b border-secondary-100 bg-secondary-50">
                    <?php if (is_user_logged_in()): ?>
                        <div class="flex items-center gap-3">
                            <?php echo get_avatar(get_current_user_id(), 48, '', '', ['class' => 'rounded-full']); ?>
                            <div>
                                <div class="font-semibold text-secondary-800"><?php echo wp_get_current_user()->display_name; ?></div>
                                <a href="<?php echo dst_get_account_url(); ?>" class="text-sm text-primary-600 hover:text-primary-700">مشاهده حساب کاربری</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo dst_get_account_url(); ?>" class="hf-btn hf-btn-primary w-full">
                            <?php echo dst_get_icon('user', 'w-5 h-5'); ?>
                            <span>ورود / ثبت نام</span>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Search -->
            <?php if ($show_search): ?>
                <div class="p-6 border-b border-secondary-100 md:hidden">
                    <?php echo dst_product_search_form(); ?>
                </div>
            <?php endif; ?>

            <!-- Navigation -->
            <nav class="p-6">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'space-y-2',
                    'fallback_cb' => false,
                    'depth' => 3,
                    'walker' => class_exists('DST_Mobile_Menu_Walker') ? new DST_Mobile_Menu_Walker() : null,
                ]);
                ?>
            </nav>

            <!-- Cart Summary -->
            <?php if ($show_cart && dst_is_woocommerce_active() && dst_get_cart_count() > 0): ?>
                <div class="p-6 border-t border-secondary-100 bg-secondary-50">
                    <div class="flex items-center justify-between mb-3">
                        <span class="font-semibold text-secondary-800">سبد خرید شما</span>
                        <span class="hf-badge hf-badge-primary"><?php echo dst_get_cart_count(); ?> محصول</span>
                    </div>
                    <a href="<?php echo dst_get_cart_url(); ?>" class="hf-btn hf-btn-primary w-full">
                        مشاهده سبد خرید
                    </a>
                </div>
            <?php endif; ?>

            <!-- Social Links -->
            <?php if (get_option('dst_instagram') || get_option('dst_telegram') || get_option('dst_whatsapp')): ?>
                <div class="p-6 border-t border-secondary-100">
                    <div class="text-sm font-semibold text-secondary-600 mb-3">شبکه‌های اجتماعی</div>
                    <div class="flex items-center gap-3">
                        <?php if ($instagram = get_option('dst_instagram')): ?>
                            <a href="<?php echo esc_url($instagram); ?>" target="_blank" class="hf-icon-btn bg-secondary-100 hover:bg-primary-600 hover:text-white">
                                <?php echo dst_get_icon('instagram', 'w-5 h-5'); ?>
                            </a>
                        <?php endif; ?>
                        <?php if ($telegram = get_option('dst_telegram')): ?>
                            <a href="<?php echo esc_url($telegram); ?>" target="_blank" class="hf-icon-btn bg-secondary-100 hover:bg-primary-600 hover:text-white">
                                <?php echo dst_get_icon('telegram', 'w-5 h-5'); ?>
                            </a>
                        <?php endif; ?>
                        <?php if ($whatsapp = get_option('dst_whatsapp')): ?>
                            <a href="<?php echo esc_url($whatsapp); ?>" target="_blank" class="hf-icon-btn bg-secondary-100 hover:bg-primary-600 hover:text-white">
                                <?php echo dst_get_icon('whatsapp', 'w-5 h-5'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>
