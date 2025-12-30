<?php
/**
 * Header Template: Restaurant
 * هدر رستوران با رزرو میز و منوی غذا
 */

defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$is_sticky = $settings['sticky'] ?? false;
$show_topbar = $settings['show_topbar'] ?? true;
$topbar_bg_color = $settings['topbar_bg_color'] ?? '#0f172a';
$topbar_text_color = $settings['topbar_text_color'] ?? '#ffffff';
$show_search = $settings['show_search'] ?? false;
$show_cart = $settings['show_cart'] ?? true;
$show_account = $settings['show_account'] ?? true;
$show_wishlist = $settings['show_wishlist'] ?? false;
$bg_color = $settings['bg_color'] ?? '#ffffff';
$text_color = $settings['text_color'] ?? '#1e293b';
$show_cta = $settings['show_cta'] ?? true;
$cta_text = $settings['cta_text'] ?? 'رزرو میز';
$cta_url = $settings['cta_url'] ?? '/reservation';
$cta_style = $settings['cta_style'] ?? 'primary';
$show_menu_button = $settings['show_menu_button'] ?? true;
$menu_text = $settings['menu_text'] ?? 'مشاهده منو';
$menu_url = $settings['menu_url'] ?? '/menu';
$show_location = $settings['show_location'] ?? true;
$show_hours = $settings['show_hours'] ?? true;
$show_phone = $settings['show_phone'] ?? true;
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
    <!-- Top Info Bar -->
    <?php if ($show_topbar): ?>
    <div class="hidden lg:block" style="background-color: <?php echo esc_attr($topbar_bg_color); ?>; color: <?php echo esc_attr($topbar_text_color); ?>;">
        <div class="hf-container">
            <div class="flex items-center justify-between py-2 text-sm">
                <div class="flex items-center gap-8">
                    <?php
                    $phone = dst_get_contact('phone');
                    $address = dst_get_contact('address');
                    $working_hours = dst_get_contact('working_hours');
                    ?>

                    <?php if ($show_hours && $working_hours): ?>
                        <div class="flex items-center gap-2">
                            <?php echo dst_get_icon('clock', 'w-4 h-4'); ?>
                            <span><?php echo esc_html($working_hours); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if ($show_location && $address): ?>
                        <div class="flex items-center gap-2">
                            <?php echo dst_get_icon('map-pin', 'w-4 h-4'); ?>
                            <span class="max-w-xs truncate"><?php echo esc_html($address); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if ($show_phone && $phone): ?>
                        <a href="tel:<?php echo esc_attr($phone); ?>" class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                            <?php echo dst_get_icon('phone', 'w-4 h-4'); ?>
                            <span><?php echo esc_html($phone); ?></span>
                        </a>
                    <?php endif; ?>
                </div>

                <div class="flex items-center gap-4">
                    <?php
                    $social_networks = ['instagram', 'facebook', 'twitter', 'telegram'];
                    foreach ($social_networks as $network):
                        $url = dst_get_social($network);
                        if (!$url) continue;
                    ?>
                        <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener" class="hover:opacity-80 transition-opacity">
                            <?php echo dst_get_icon($network, 'w-4 h-4'); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Main Header -->
    <div class="border-b border-secondary-100">
        <div class="hf-container">
            <div class="flex items-center justify-between h-24">

                <!-- Logo -->
                <div class="flex-shrink-0">
                    <?php dst_the_logo('default', 'h-16 w-auto max-w-[200px] object-contain'); ?>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex items-center gap-8">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'container' => false,
                        'menu_class' => 'hf-nav-menu flex items-center gap-6',
                        'fallback_cb' => false,
                        'depth' => 2,
                    ]);
                    ?>
                </nav>

                <!-- Header Actions -->
                <div class="flex items-center gap-3">

                    <!-- Menu Button -->
                    <?php if ($show_menu_button): ?>
                        <a
                            href="<?php echo esc_url($menu_url); ?>"
                            class="hidden md:inline-flex items-center gap-2 text-secondary-700 hover:text-primary-600 font-medium transition-colors"
                        >
                            <?php echo dst_get_icon('book-open', 'w-5 h-5'); ?>
                            <span><?php echo esc_html($menu_text); ?></span>
                        </a>
                    <?php endif; ?>

                    <!-- Cart (Online Order) -->
                    <?php if ($show_cart && dst_is_woocommerce_active()): ?>
                        <div class="relative hidden md:block" x-data="miniCart">
                            <button @click="toggle()" class="hf-icon-btn relative">
                                <?php echo dst_get_icon('shopping-bag'); ?>
                                <?php if (dst_get_cart_count() > 0): ?>
                                    <span class="hf-badge hf-badge-primary"><?php echo dst_get_cart_count(); ?></span>
                                <?php endif; ?>
                            </button>
                            <?php echo dst_mini_cart(); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Account -->
                    <?php if ($show_account): ?>
                        <a href="<?php echo dst_get_account_url(); ?>" class="hidden md:flex hf-icon-btn">
                            <?php echo dst_get_icon('user'); ?>
                        </a>
                    <?php endif; ?>

                    <!-- Reservation CTA -->
                    <?php if ($show_cta): ?>
                        <a
                            href="<?php echo esc_url($cta_url); ?>"
                            class="hidden lg:inline-flex hf-btn hf-btn-<?php echo esc_attr($cta_style); ?> gap-2"
                        >
                            <?php echo dst_get_icon('calendar', 'w-5 h-5'); ?>
                            <?php echo esc_html($cta_text); ?>
                        </a>
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

        <?php if ($show_topbar): ?>
            <div class="p-4 border-b border-secondary-100 space-y-3 text-sm">
                <?php if ($show_hours && $working_hours): ?>
                    <div class="flex items-center gap-2 text-secondary-700">
                        <?php echo dst_get_icon('clock', 'w-4 h-4'); ?>
                        <span><?php echo esc_html($working_hours); ?></span>
                    </div>
                <?php endif; ?>

                <?php if ($show_phone && $phone): ?>
                    <a href="tel:<?php echo esc_attr($phone); ?>" class="flex items-center gap-2 text-secondary-700">
                        <?php echo dst_get_icon('phone', 'w-4 h-4'); ?>
                        <span><?php echo esc_html($phone); ?></span>
                    </a>
                <?php endif; ?>

                <?php if ($show_location && $address): ?>
                    <div class="flex items-center gap-2 text-secondary-700">
                        <?php echo dst_get_icon('map-pin', 'w-4 h-4'); ?>
                        <span><?php echo esc_html($address); ?></span>
                    </div>
                <?php endif; ?>
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

        <div class="p-4 border-t border-secondary-100 mt-auto space-y-3">
            <?php if ($show_menu_button): ?>
                <a href="<?php echo esc_url($menu_url); ?>" class="hf-btn hf-btn-outline w-full">
                    <?php echo dst_get_icon('book-open', 'w-5 h-5'); ?>
                    <?php echo esc_html($menu_text); ?>
                </a>
            <?php endif; ?>

            <?php if ($show_cart && dst_is_woocommerce_active()): ?>
                <a href="<?php echo dst_get_cart_url(); ?>" class="hf-btn hf-btn-secondary w-full">
                    <?php echo dst_get_icon('shopping-bag', 'w-5 h-5'); ?>
                    <span>سبد خرید</span>
                    <?php if (dst_get_cart_count() > 0): ?>
                        <span class="hf-badge bg-white text-secondary-600"><?php echo dst_get_cart_count(); ?></span>
                    <?php endif; ?>
                </a>
            <?php endif; ?>

            <?php if ($show_cta): ?>
                <a href="<?php echo esc_url($cta_url); ?>" class="hf-btn hf-btn-<?php echo esc_attr($cta_style); ?> w-full">
                    <?php echo dst_get_icon('calendar', 'w-5 h-5'); ?>
                    <?php echo esc_html($cta_text); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>
