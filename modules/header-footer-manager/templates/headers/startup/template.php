<?php
/**
 * Header Template: Startup
 * هدر مدرن استارتاپی با گرادیانت و دکمه‌های CTA
 */

defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$is_sticky = $settings['sticky'] ?? true;
$show_topbar = $settings['show_topbar'] ?? true;
$topbar_bg_color = $settings['topbar_bg_color'] ?? '#8b5cf6';
$topbar_text_color = $settings['topbar_text_color'] ?? '#ffffff';
$show_search = $settings['show_search'] ?? false;
$show_cart = $settings['show_cart'] ?? false;
$show_account = $settings['show_account'] ?? true;
$show_wishlist = $settings['show_wishlist'] ?? false;
$bg_color = $settings['bg_color'] ?? '#ffffff';
$text_color = $settings['text_color'] ?? '#1e293b';
$show_cta = $settings['show_cta'] ?? true;
$cta_text = $settings['cta_text'] ?? 'شروع رایگان';
$cta_url = $settings['cta_url'] ?? '/signup';
$cta_style = $settings['cta_style'] ?? 'primary';
$show_demo_cta = $settings['show_demo_cta'] ?? true;
$demo_text = $settings['demo_text'] ?? 'مشاهده دمو';
$demo_url = $settings['demo_url'] ?? '/demo';
$show_pricing_link = $settings['show_pricing_link'] ?? true;
$gradient_enabled = $settings['gradient_enabled'] ?? true;
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
    <!-- Announcement Bar -->
    <?php if ($show_topbar): ?>
    <div
        class="relative overflow-hidden py-2 text-center text-sm font-medium"
        style="background-color: <?php echo esc_attr($topbar_bg_color); ?>; color: <?php echo esc_attr($topbar_text_color); ?>;"
    >
        <?php if ($gradient_enabled): ?>
            <div class="absolute inset-0 bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 opacity-90"></div>
        <?php endif; ?>
        <div class="relative hf-container flex items-center justify-center gap-2">
            <span class="hidden md:inline">🎉</span>
            <span>محصول جدید ما را امتحان کنید - 30 روز رایگان!</span>
            <a href="/signup" class="underline hover:no-underline font-semibold">همین حالا شروع کنید</a>
        </div>
    </div>
    <?php endif; ?>

    <!-- Main Header -->
    <div class="border-b border-secondary-100">
        <div class="hf-container">
            <div class="flex items-center justify-between h-20">

                <!-- Logo -->
                <div class="flex-shrink-0">
                    <?php dst_the_logo('default', 'h-10 w-auto max-w-[160px] object-contain'); ?>
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

                    <?php if ($show_pricing_link): ?>
                        <a href="/pricing" class="text-secondary-700 hover:text-primary-600 font-medium transition-colors">
                            قیمت‌گذاری
                        </a>
                    <?php endif; ?>
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

                    <!-- Account (Login) -->
                    <?php if ($show_account): ?>
                        <a href="<?php echo dst_get_account_url(); ?>" class="hidden md:flex items-center gap-2 text-secondary-700 hover:text-primary-600 font-medium transition-colors">
                            <?php echo dst_get_icon('user', 'w-5 h-5'); ?>
                            <span><?php echo is_user_logged_in() ? 'حساب من' : 'ورود'; ?></span>
                        </a>
                    <?php endif; ?>

                    <!-- Demo CTA -->
                    <?php if ($show_demo_cta): ?>
                        <a
                            href="<?php echo esc_url($demo_url); ?>"
                            class="hidden lg:inline-flex items-center gap-2 hf-btn hf-btn-outline"
                        >
                            <?php echo dst_get_icon('play-circle', 'w-5 h-5'); ?>
                            <?php echo esc_html($demo_text); ?>
                        </a>
                    <?php endif; ?>

                    <!-- Main CTA Button -->
                    <?php if ($show_cta): ?>
                        <a
                            href="<?php echo esc_url($cta_url); ?>"
                            class="hidden lg:inline-flex hf-btn hf-btn-<?php echo esc_attr($cta_style); ?> bg-gradient-to-r from-purple-600 to-pink-600 border-0"
                        >
                            <?php echo esc_html($cta_text); ?>
                            <?php echo dst_get_icon('arrow-left', 'w-4 h-4 mr-1 rtl:mr-0 rtl:ml-1'); ?>
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

            <?php if ($show_pricing_link): ?>
                <a href="/pricing" class="block py-3 px-4 text-secondary-700 hover:bg-secondary-50 rounded-lg transition-colors">
                    قیمت‌گذاری
                </a>
            <?php endif; ?>
        </nav>

        <div class="p-4 border-t border-secondary-100 mt-auto space-y-3">
            <?php if ($show_account): ?>
                <a href="<?php echo dst_get_account_url(); ?>" class="hf-btn hf-btn-secondary w-full">
                    <?php echo dst_get_icon('user', 'w-5 h-5'); ?>
                    <span><?php echo is_user_logged_in() ? 'حساب من' : 'ورود'; ?></span>
                </a>
            <?php endif; ?>

            <?php if ($show_demo_cta): ?>
                <a href="<?php echo esc_url($demo_url); ?>" class="hf-btn hf-btn-outline w-full">
                    <?php echo dst_get_icon('play-circle', 'w-5 h-5'); ?>
                    <?php echo esc_html($demo_text); ?>
                </a>
            <?php endif; ?>

            <?php if ($show_cta): ?>
                <a href="<?php echo esc_url($cta_url); ?>" class="hf-btn hf-btn-primary w-full bg-gradient-to-r from-purple-600 to-pink-600 border-0">
                    <?php echo esc_html($cta_text); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>
