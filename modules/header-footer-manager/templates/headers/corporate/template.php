<?php
/**
 * Header Template: Corporate
 * هدر حرفه‌ای شرکتی با نوار تماس و منوی چند سطحی
 */

defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$is_sticky = $settings['sticky'] ?? true;
$show_topbar = $settings['show_topbar'] ?? true;
$topbar_bg_color = $settings['topbar_bg_color'] ?? '#1e293b';
$topbar_text_color = $settings['topbar_text_color'] ?? '#ffffff';
$show_search = $settings['show_search'] ?? true;
$show_cart = $settings['show_cart'] ?? true;
$show_account = $settings['show_account'] ?? true;
$show_wishlist = $settings['show_wishlist'] ?? false;
$bg_color = $settings['bg_color'] ?? '#ffffff';
$text_color = $settings['text_color'] ?? '#1e293b';
$show_cta = $settings['show_cta'] ?? true;
$cta_text = $settings['cta_text'] ?? 'تماس با ما';
$cta_url = $settings['cta_url'] ?? '/contact';
$cta_style = $settings['cta_style'] ?? 'primary';
$show_departments = $settings['show_departments'] ?? true;
$departments_title = $settings['departments_title'] ?? 'دپارتمان‌ها';
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
    <!-- Top Contact Bar -->
    <?php if ($show_topbar): ?>
    <div class="hidden lg:block" style="background-color: <?php echo esc_attr($topbar_bg_color); ?>; color: <?php echo esc_attr($topbar_text_color); ?>;">
        <div class="hf-container">
            <div class="flex items-center justify-between py-2 text-sm">
                <div class="flex items-center gap-6">
                    <?php
                    $phone = dst_get_contact('phone');
                    $email = dst_get_contact('email');
                    $working_hours = dst_get_contact('working_hours');
                    ?>
                    <?php if ($working_hours): ?>
                        <span class="flex items-center gap-2">
                            <?php echo dst_get_icon('clock', 'w-4 h-4'); ?>
                            <span><?php echo esc_html($working_hours); ?></span>
                        </span>
                    <?php endif; ?>
                    <?php if ($phone): ?>
                        <a href="tel:<?php echo esc_attr($phone); ?>" class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                            <?php echo dst_get_icon('phone', 'w-4 h-4'); ?>
                            <span><?php echo esc_html($phone); ?></span>
                        </a>
                    <?php endif; ?>
                    <?php if ($email): ?>
                        <a href="mailto:<?php echo esc_attr($email); ?>" class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                            <?php echo dst_get_icon('mail', 'w-4 h-4'); ?>
                            <span><?php echo esc_html($email); ?></span>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="flex items-center gap-4">
                    <?php
                    $social_networks = ['instagram', 'linkedin', 'twitter', 'telegram'];
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
                        'menu_class' => 'hf-nav-menu flex items-center gap-6',
                        'fallback_cb' => false,
                        'depth' => 3,
                    ]);
                    ?>
                </nav>

                <!-- Header Actions -->
                <div class="flex items-center gap-3">

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

                            <div
                                x-show="searchOpen"
                                x-transition
                                @click.outside="searchOpen = false"
                                class="absolute top-full left-0 rtl:left-auto rtl:right-0 mt-2 w-80 z-50"
                            >
                                <?php echo dst_product_search_form(); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Wishlist -->
                    <?php if ($show_wishlist && function_exists('YITH_WCWL')): ?>
                        <?php echo dst_wishlist_icon('hidden md:flex'); ?>
                    <?php endif; ?>

                    <!-- Cart -->
                    <?php if ($show_cart && dst_is_woocommerce_active()): ?>
                        <div class="relative hidden md:block" x-data="miniCart">
                            <button @click="toggle()" class="hf-icon-btn relative">
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

                    <!-- CTA Button -->
                    <?php if ($show_cta): ?>
                        <a
                            href="<?php echo esc_url($cta_url); ?>"
                            class="hidden lg:inline-flex hf-btn hf-btn-<?php echo esc_attr($cta_style); ?>"
                        >
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

    <!-- Departments Menu Bar -->
    <?php if ($show_departments && has_nav_menu('departments')): ?>
    <div class="hidden lg:block bg-secondary-50 border-b border-secondary-100">
        <div class="hf-container">
            <div class="flex items-center justify-between py-3">
                <div class="relative" x-data="{ deptOpen: false }">
                    <button
                        @click="deptOpen = !deptOpen"
                        class="hf-btn hf-btn-secondary flex items-center gap-2"
                    >
                        <?php echo dst_get_icon('briefcase', 'w-5 h-5'); ?>
                        <span><?php echo esc_html($departments_title); ?></span>
                        <?php echo dst_get_icon('chevron-down', 'w-4 h-4'); ?>
                    </button>

                    <div
                        x-show="deptOpen"
                        x-transition
                        @click.outside="deptOpen = false"
                        class="absolute top-full right-0 rtl:right-auto rtl:left-0 mt-2 w-64 bg-white shadow-xl rounded-lg border border-secondary-100 z-50"
                    >
                        <?php
                        wp_nav_menu([
                            'theme_location' => 'departments',
                            'container' => 'ul',
                            'menu_class' => 'py-2',
                            'fallback_cb' => false,
                        ]);
                        ?>
                    </div>
                </div>

                <div class="flex items-center gap-6 text-sm text-secondary-600">
                    <a href="<?php echo home_url('/about'); ?>" class="hover:text-primary-600 transition-colors">درباره ما</a>
                    <a href="<?php echo home_url('/services'); ?>" class="hover:text-primary-600 transition-colors">خدمات</a>
                    <a href="<?php echo home_url('/portfolio'); ?>" class="hover:text-primary-600 transition-colors">نمونه کارها</a>
                    <a href="<?php echo home_url('/blog'); ?>" class="hover:text-primary-600 transition-colors">وبلاگ</a>
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
                        <span>حساب کاربری</span>
                    </a>
                <?php endif; ?>
            </div>

            <?php if ($show_cta): ?>
                <a href="<?php echo esc_url($cta_url); ?>" class="hf-btn hf-btn-<?php echo esc_attr($cta_style); ?> w-full mt-3">
                    <?php echo esc_html($cta_text); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>
