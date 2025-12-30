<?php
/**
 * Header Template: News Ticker Header
 * Header with scrolling news/announcement ticker bar at the top and main navigation below
 */

defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$is_sticky = $settings['sticky'] ?? true;
$show_ticker = $settings['show_ticker'] ?? true;
$ticker_text = $settings['ticker_text'] ?? 'Breaking News: New Product Launch | Special Offer: 20% Off All Items | Free Shipping Worldwide';
$ticker_speed = $settings['ticker_speed'] ?? 'medium';
$ticker_bg_color = $settings['ticker_bg_color'] ?? '#000000';
$ticker_text_color = $settings['ticker_text_color'] ?? '#ffffff';
$ticker_pausable = $settings['ticker_pausable'] ?? true;
$bg_color = $settings['bg_color'] ?? '#ffffff';
$text_color = $settings['text_color'] ?? '#000000';
$show_search = $settings['show_search'] ?? true;
$show_cart = $settings['show_cart'] ?? true;
$show_account = $settings['show_account'] ?? false;
$menu_style = $settings['menu_style'] ?? 'inline';
$ticker_separator = $settings['ticker_separator'] ?? ' | ';
$ticker_font_size = $settings['ticker_font_size'] ?? 'sm';
$ticker_dismissible = $settings['ticker_dismissible'] ?? false;

$ticker_duration = match($ticker_speed) {
    'slow' => '60s',
    'fast' => '20s',
    default => '40s'
};

$ticker_id = 'ticker-' . uniqid();
?>

<style>
@keyframes ticker-scroll {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}
.ticker-animate {
    animation: ticker-scroll <?php echo esc_attr($ticker_duration); ?> linear infinite;
}
<?php if ($ticker_pausable): ?>
.ticker-wrapper:hover .ticker-animate {
    animation-play-state: paused;
}
<?php endif; ?>
</style>

<header
    x-data="{ ...header, tickerDismissed: false }"
    :class="{
        'shadow-sm': isScrolled,
        '-translate-y-full': isHidden && isScrolled
    }"
    class="<?php echo $is_sticky ? 'hf-header-sticky' : 'relative'; ?> transition-all duration-300"
>
    <!-- Ticker Bar -->
    <?php if ($show_ticker): ?>
        <div
            x-show="!tickerDismissed"
            class="relative overflow-hidden ticker-wrapper"
            style="background-color: <?php echo esc_attr($ticker_bg_color); ?>; color: <?php echo esc_attr($ticker_text_color); ?>;"
        >
            <div class="flex items-center">
                <!-- Ticker Content -->
                <div class="flex-1 overflow-hidden py-2">
                    <div class="flex ticker-animate whitespace-nowrap text-<?php echo esc_attr($ticker_font_size); ?>">
                        <?php
                        // Split ticker text and duplicate for seamless loop
                        $ticker_items = explode('|', $ticker_text);
                        $ticker_content = '';
                        foreach ($ticker_items as $item) {
                            $ticker_content .= '<span class="inline-flex items-center"><span class="font-medium">📢</span><span class="mx-3">' . esc_html(trim($item)) . '</span><span class="opacity-50">' . esc_html($ticker_separator) . '</span></span>';
                        }
                        // Duplicate content for seamless loop
                        echo $ticker_content . $ticker_content;
                        ?>
                    </div>
                </div>

                <!-- Dismiss Button -->
                <?php if ($ticker_dismissible): ?>
                    <button
                        @click="tickerDismissed = true"
                        class="px-4 py-2 hover:opacity-70 transition-opacity"
                        aria-label="Close ticker"
                    >
                        <?php echo dst_get_icon('close', 'w-4 h-4'); ?>
                    </button>
                <?php endif; ?>
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
