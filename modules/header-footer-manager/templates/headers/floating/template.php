<?php
/**
 * Header Template: Floating Pill
 * Floating pill-shaped header that hovers over content
 */

defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$is_sticky = $settings['sticky'] ?? true;
$float_margin = $settings['float_margin'] ?? 'md';
$pill_radius = $settings['pill_radius'] ?? 'full';
$transparent_start = $settings['transparent_start'] ?? true;
$bg_color = $settings['bg_color'] ?? '#ffffff';
$text_color = $settings['text_color'] ?? '#000000';
$shadow_color = $settings['shadow_color'] ?? '#000000';
$shadow_opacity = $settings['shadow_opacity'] ?? '10';
$show_search = $settings['show_search'] ?? true;
$show_cart = $settings['show_cart'] ?? true;
$show_account = $settings['show_account'] ?? false;
$nav_position = $settings['nav_position'] ?? 'center';
$max_width = $settings['max_width'] ?? '1200';
$show_cta = $settings['show_cta'] ?? true;
$cta_text = $settings['cta_text'] ?? 'Get Started';
$cta_url = $settings['cta_url'] ?? '/contact';

$margin_class = match($float_margin) {
    'sm' => 'mx-2.5 my-2.5',
    'lg' => 'mx-8 my-8',
    'xl' => 'mx-10 my-10',
    default => 'mx-5 my-5'
};

$radius_class = match($pill_radius) {
    'lg' => 'rounded-lg',
    'xl' => 'rounded-xl',
    '2xl' => 'rounded-2xl',
    default => 'rounded-full'
};

$nav_justify = match($nav_position) {
    'left' => 'justify-start',
    'right' => 'justify-end',
    default => 'justify-center'
};

$shadow_rgb = sscanf($shadow_color, "#%02x%02x%02x");
$shadow_rgba = "rgba({$shadow_rgb[0]}, {$shadow_rgb[1]}, {$shadow_rgb[2]}, 0.{$shadow_opacity})";
?>

<header
    x-data="header"
    class="<?php echo $is_sticky ? 'fixed top-0 left-0 right-0 z-50' : 'absolute top-0 left-0 right-0 z-50'; ?> transition-all duration-500"
>
    <div class="<?php echo $margin_class; ?>">
        <div
            :class="{
                'shadow-xl': isScrolled,
                <?php if ($transparent_start): ?>
                'bg-opacity-100': isScrolled,
                'bg-opacity-95': !isScrolled
                <?php endif; ?>
            }"
            class="<?php echo $radius_class; ?> backdrop-blur-md transition-all duration-500 border border-secondary-200"
            style="
                background-color: <?php echo esc_attr($bg_color); ?>;
                color: <?php echo esc_attr($text_color); ?>;
                max-width: <?php echo esc_attr($max_width); ?>px;
                margin: 0 auto;
                box-shadow: 0 10px 40px <?php echo $shadow_rgba; ?>;
            "
        >
            <div class="px-6 lg:px-8">
                <div class="flex items-center justify-between h-16 lg:h-20 gap-4">
                    <!-- Logo -->
                    <div class="flex-shrink-0">
                        <?php dst_the_logo('default', 'h-8 lg:h-10 w-auto max-w-[140px] object-contain'); ?>
                    </div>

                    <!-- Desktop Navigation -->
                    <nav class="hidden lg:flex items-center gap-8 flex-1 <?php echo $nav_justify; ?>">
                        <?php
                        if (has_nav_menu('primary')) {
                            wp_nav_menu([
                                'theme_location' => 'primary',
                                'container' => false,
                                'menu_class' => 'flex items-center gap-8',
                                'fallback_cb' => false,
                                'depth' => 1,
                                'link_before' => '<span class="font-medium hover:text-primary-600 transition-colors">',
                                'link_after' => '</span>',
                            ]);
                        }
                        ?>
                    </nav>

                    <!-- Actions -->
                    <div class="flex items-center gap-3">
                        <!-- Search -->
                        <?php if ($show_search): ?>
                            <button
                                @click="toggleSearch()"
                                class="hf-icon-btn hidden lg:flex"
                                aria-label="Search"
                            >
                                <?php echo dst_get_icon('search', 'w-5 h-5'); ?>
                            </button>
                        <?php endif; ?>

                        <!-- Account -->
                        <?php if ($show_account): ?>
                            <a href="<?php echo dst_get_account_url(); ?>" class="hf-icon-btn hidden lg:flex">
                                <?php echo dst_get_icon('user', 'w-5 h-5'); ?>
                            </a>
                        <?php endif; ?>

                        <!-- Cart -->
                        <?php if ($show_cart && dst_is_woocommerce_active()): ?>
                            <div class="relative" x-data="miniCart">
                                <button @click="toggle()" class="hf-icon-btn relative">
                                    <?php echo dst_get_icon('shopping-bag', 'w-5 h-5'); ?>
                                    <?php if (dst_get_cart_count() > 0): ?>
                                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-primary-600 text-white text-xs rounded-full flex items-center justify-center"><?php echo dst_get_cart_count(); ?></span>
                                    <?php endif; ?>
                                </button>
                                <?php echo dst_mini_cart(); ?>
                            </div>
                        <?php endif; ?>

                        <!-- CTA Button -->
                        <?php if ($show_cta): ?>
                            <a
                                href="<?php echo esc_url($cta_url); ?>"
                                class="hidden lg:inline-flex hf-btn hf-btn-primary"
                            >
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
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 max-h-0"
                    x-transition:enter-end="opacity-100 max-h-24"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 max-h-24"
                    x-transition:leave-end="opacity-0 max-h-0"
                    class="border-t border-secondary-100 overflow-hidden"
                    @click.outside="closeSearch()"
                    style="display: none;"
                >
                    <div class="px-6 lg:px-8 py-4">
                        <div class="relative">
                            <?php get_search_form(); ?>
                            <button @click="closeSearch()" class="absolute top-1/2 right-4 -translate-y-1/2">
                                <?php echo dst_get_icon('close', 'w-5 h-5'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div
        class="fixed inset-0 z-50 lg:hidden"
        :class="{ 'pointer-events-none': !isMobileMenuOpen }"
        x-show="isMobileMenuOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="display: none; background-color: <?php echo esc_attr($bg_color); ?>;"
    >
        <div class="h-full flex flex-col">
            <!-- Menu Header -->
            <div class="flex items-center justify-between p-6 border-b border-secondary-100">
                <?php dst_the_logo('default', 'h-8 w-auto max-w-[140px] object-contain'); ?>
                <button @click="closeMobileMenu()" class="hf-icon-btn">
                    <?php echo dst_get_icon('close', 'w-6 h-6'); ?>
                </button>
            </div>

            <!-- Menu Content -->
            <div class="flex-1 overflow-y-auto p-8">
                <nav class="space-y-6">
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

                <?php if ($show_cta): ?>
                    <div class="mt-8">
                        <a href="<?php echo esc_url($cta_url); ?>" class="hf-btn hf-btn-primary w-full justify-center text-lg">
                            <?php echo esc_html($cta_text); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>
