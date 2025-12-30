<?php
/**
 * Header Template: CTA Banner Header
 * Header with integrated dismissible call-to-action banner on top and main navigation below
 */

defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$is_sticky = $settings['sticky'] ?? true;
$show_banner = $settings['show_banner'] ?? true;
$banner_text = $settings['banner_text'] ?? '🎉 Limited Time Offer: Get 50% Off Your First Order!';
$banner_link = $settings['banner_link'] ?? '/shop';
$banner_cta_text = $settings['banner_cta_text'] ?? 'Shop Now';
$banner_bg_color = $settings['banner_bg_color'] ?? '#000000';
$banner_text_color = $settings['banner_text_color'] ?? '#ffffff';
$banner_dismissible = $settings['banner_dismissible'] ?? true;
$banner_style = $settings['banner_style'] ?? 'default';
$bg_color = $settings['bg_color'] ?? '#ffffff';
$text_color = $settings['text_color'] ?? '#000000';
$show_search = $settings['show_search'] ?? true;
$show_cart = $settings['show_cart'] ?? true;
$show_account = $settings['show_account'] ?? false;
$menu_style = $settings['menu_style'] ?? 'inline';
$banner_animation = $settings['banner_animation'] ?? 'slide';
$banner_position = $settings['banner_position'] ?? 'top';

$banner_class = match($banner_style) {
    'gradient' => 'bg-gradient-to-r from-primary-600 to-secondary-600',
    'outlined' => 'border-2 border-current',
    default => ''
};

$banner_bg_style = $banner_style !== 'gradient' ? 'background-color: ' . esc_attr($banner_bg_color) . ';' : '';
?>

<header
    x-data="{
        ...header,
        bannerDismissed: localStorage.getItem('bannerDismissed') === 'true',
        dismissBanner() {
            this.bannerDismissed = true;
            localStorage.setItem('bannerDismissed', 'true');
        }
    }"
    :class="{
        'shadow-sm': isScrolled,
        '-translate-y-full': isHidden && isScrolled
    }"
    class="<?php echo $is_sticky ? 'hf-header-sticky' : 'relative'; ?> transition-all duration-300"
>
    <!-- CTA Banner (Top Position) -->
    <?php if ($show_banner && $banner_position === 'top'): ?>
        <div
            x-show="!bannerDismissed"
            x-transition:enter="transition ease-out duration-<?php echo $banner_animation === 'slide' ? '300' : '200'; ?>"
            x-transition:enter-start="<?php echo $banner_animation === 'slide' ? '-translate-y-full' : 'opacity-0'; ?>"
            x-transition:enter-end="<?php echo $banner_animation === 'slide' ? 'translate-y-0' : 'opacity-100'; ?>"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="<?php echo $banner_animation === 'slide' ? 'translate-y-0' : 'opacity-100'; ?>"
            x-transition:leave-end="<?php echo $banner_animation === 'slide' ? '-translate-y-full' : 'opacity-0'; ?>"
            class="relative overflow-hidden <?php echo esc_attr($banner_class); ?>"
            style="<?php echo $banner_bg_style; ?> color: <?php echo esc_attr($banner_text_color); ?>;"
            style="display: none;"
        >
            <div class="hf-container">
                <div class="flex items-center justify-center gap-4 py-3 text-center">
                    <!-- Banner Text -->
                    <p class="text-sm md:text-base font-medium flex-shrink">
                        <?php echo wp_kses_post($banner_text); ?>
                    </p>

                    <!-- CTA Button -->
                    <a
                        href="<?php echo esc_url($banner_link); ?>"
                        class="inline-flex items-center px-4 py-1.5 text-sm font-semibold border-2 border-current rounded hover:bg-white hover:text-black transition-all duration-300 whitespace-nowrap flex-shrink-0"
                    >
                        <?php echo esc_html($banner_cta_text); ?>
                        <span class="ml-2">→</span>
                    </a>

                    <!-- Dismiss Button -->
                    <?php if ($banner_dismissible): ?>
                        <button
                            @click="dismissBanner()"
                            class="ml-auto p-1 hover:opacity-70 transition-opacity flex-shrink-0"
                            aria-label="Dismiss banner"
                        >
                            <?php echo dst_get_icon('close', 'w-4 h-4'); ?>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Header -->
    <div class="border-b border-secondary-100" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;">
        <div class="hf-container">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <?php dst_the_logo('default', 'h-8 w-auto max-w-[160px] object-contain'); ?>
                </div>

                <?php if ($menu_style === 'inline'): ?>
                    <!-- Desktop Navigation -->
                    <nav class="hidden lg:flex items-center justify-center flex-1 px-8">
                        <?php
                        if (has_nav_menu('primary')) {
                            wp_nav_menu([
                                'theme_location' => 'primary',
                                'container' => false,
                                'menu_class' => 'flex items-center gap-8',
                                'fallback_cb' => false,
                                'depth' => 1,
                            ]);
                        }
                        ?>
                    </nav>

                    <!-- Mobile Menu Toggle -->
                    <button
                        @click="toggleMobileMenu()"
                        class="lg:hidden hf-icon-btn"
                        aria-label="Menu"
                    >
                        <div class="hf-hamburger" :class="{ 'is-active': isMobileMenuOpen }">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </button>
                <?php else: ?>
                    <!-- Hamburger Menu -->
                    <button
                        @click="toggleMobileMenu()"
                        class="hf-icon-btn"
                        aria-label="Menu"
                    >
                        <div class="hf-hamburger" :class="{ 'is-active': isMobileMenuOpen }">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </button>
                <?php endif; ?>

                <!-- Right Icons -->
                <div class="flex items-center gap-3">
                    <!-- Search -->
                    <?php if ($show_search): ?>
                        <button
                            @click="toggleSearch()"
                            class="hf-icon-btn"
                            aria-label="Search"
                        >
                            <?php echo dst_get_icon('search', 'w-5 h-5'); ?>
                        </button>
                    <?php endif; ?>

                    <!-- Cart -->
                    <?php if ($show_cart && dst_is_woocommerce_active()): ?>
                        <div class="relative" x-data="miniCart">
                            <button @click="toggle()" class="hf-icon-btn relative">
                                <?php echo dst_get_icon('shopping-bag', 'w-5 h-5'); ?>
                                <?php if (dst_get_cart_count() > 0): ?>
                                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-black text-white text-xs rounded-full flex items-center justify-center"><?php echo dst_get_cart_count(); ?></span>
                                <?php endif; ?>
                            </button>
                            <?php echo dst_mini_cart(); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Account -->
                    <?php if ($show_account): ?>
                        <a href="<?php echo dst_get_account_url(); ?>" class="hf-icon-btn">
                            <?php echo dst_get_icon('user', 'w-5 h-5'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Banner (Below Position) -->
    <?php if ($show_banner && $banner_position === 'below'): ?>
        <div
            x-show="!bannerDismissed"
            x-transition:enter="transition ease-out duration-<?php echo $banner_animation === 'slide' ? '300' : '200'; ?>"
            x-transition:enter-start="<?php echo $banner_animation === 'slide' ? '-translate-y-full' : 'opacity-0'; ?>"
            x-transition:enter-end="<?php echo $banner_animation === 'slide' ? 'translate-y-0' : 'opacity-100'; ?>"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="<?php echo $banner_animation === 'slide' ? 'translate-y-0' : 'opacity-100'; ?>"
            x-transition:leave-end="<?php echo $banner_animation === 'slide' ? '-translate-y-full' : 'opacity-0'; ?>"
            class="relative overflow-hidden <?php echo esc_attr($banner_class); ?>"
            style="<?php echo $banner_bg_style; ?> color: <?php echo esc_attr($banner_text_color); ?>;"
            style="display: none;"
        >
            <div class="hf-container">
                <div class="flex items-center justify-center gap-4 py-3 text-center">
                    <p class="text-sm md:text-base font-medium flex-shrink">
                        <?php echo wp_kses_post($banner_text); ?>
                    </p>
                    <a
                        href="<?php echo esc_url($banner_link); ?>"
                        class="inline-flex items-center px-4 py-1.5 text-sm font-semibold border-2 border-current rounded hover:bg-white hover:text-black transition-all duration-300 whitespace-nowrap flex-shrink-0"
                    >
                        <?php echo esc_html($banner_cta_text); ?>
                        <span class="ml-2">→</span>
                    </a>
                    <?php if ($banner_dismissible): ?>
                        <button
                            @click="dismissBanner()"
                            class="ml-auto p-1 hover:opacity-70 transition-opacity flex-shrink-0"
                            aria-label="Dismiss banner"
                        >
                            <?php echo dst_get_icon('close', 'w-4 h-4'); ?>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Search Overlay -->
    <?php if ($show_search): ?>
        <div
            x-show="isSearchOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4"
            class="border-b border-secondary-100"
            style="background-color: <?php echo esc_attr($bg_color); ?>;"
            @click.outside="closeSearch()"
            style="display: none;"
        >
            <div class="hf-container py-8">
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

    <!-- Mobile Menu -->
    <?php if ($menu_style === 'inline'): ?>
        <div
            class="lg:hidden border-b border-secondary-100"
            style="background-color: <?php echo esc_attr($bg_color); ?>;"
            x-show="isMobileMenuOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4"
            @click.outside="closeMobileMenu()"
            style="display: none;"
        >
            <nav class="hf-container py-6">
                <?php
                if (has_nav_menu('primary')) {
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'container' => false,
                        'menu_class' => 'space-y-4',
                        'fallback_cb' => false,
                        'depth' => 1,
                    ]);
                }
                ?>
            </nav>
        </div>
    <?php else: ?>
        <!-- Full Screen Mobile Menu -->
        <div
            class="fixed inset-0 z-50 bg-white"
            :class="{ 'pointer-events-none': !isMobileMenuOpen }"
            x-show="isMobileMenuOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            style="display: none;"
        >
            <div class="h-full flex flex-col">
                <div class="flex items-center justify-between p-6 border-b border-secondary-100">
                    <?php dst_the_logo('default', 'h-8 w-auto max-w-[160px] object-contain'); ?>
                    <button @click="closeMobileMenu()" class="hf-icon-btn">
                        <?php echo dst_get_icon('close', 'w-6 h-6'); ?>
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto">
                    <nav class="p-8">
                        <?php
                        if (has_nav_menu('primary')) {
                            wp_nav_menu([
                                'theme_location' => 'primary',
                                'container' => false,
                                'menu_class' => 'space-y-6 text-2xl font-light',
                                'fallback_cb' => false,
                                'depth' => 1,
                            ]);
                        }
                        ?>
                    </nav>
                </div>
            </div>
        </div>
    <?php endif; ?>
</header>
