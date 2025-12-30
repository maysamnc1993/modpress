<?php
/**
 * Header Template: Magazine
 * هدر خبری/مجله‌ای با تیکر اخبار و دسته‌بندی
 */

defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$is_sticky = $settings['sticky'] ?? true;
$show_topbar = $settings['show_topbar'] ?? true;
$topbar_bg_color = $settings['topbar_bg_color'] ?? '#dc2626';
$topbar_text_color = $settings['topbar_text_color'] ?? '#ffffff';
$show_search = $settings['show_search'] ?? true;
$show_cart = $settings['show_cart'] ?? false;
$show_account = $settings['show_account'] ?? true;
$show_wishlist = $settings['show_wishlist'] ?? false;
$bg_color = $settings['bg_color'] ?? '#ffffff';
$text_color = $settings['text_color'] ?? '#1e293b';
$show_cta = $settings['show_cta'] ?? false;
$cta_text = $settings['cta_text'] ?? 'اشتراک';
$cta_url = $settings['cta_url'] ?? '/subscribe';
$cta_style = $settings['cta_style'] ?? 'primary';
$show_breaking_news = $settings['show_breaking_news'] ?? true;
$breaking_news_label = $settings['breaking_news_label'] ?? 'خبر فوری';
$show_date = $settings['show_date'] ?? true;
$show_weather = $settings['show_weather'] ?? false;
$show_categories_bar = $settings['show_categories_bar'] ?? true;
?>

<header
    x-data="header"
    :class="{
        'shadow-md': isScrolled,
        '-translate-y-full': isHidden && isScrolled
    }"
    class="<?php echo $is_sticky ? 'hf-header-sticky' : 'relative'; ?> transition-all duration-300"
    style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;"
>
    <!-- Top Bar with Date & Social -->
    <?php if ($show_topbar): ?>
    <div class="hidden lg:block border-b border-secondary-200">
        <div class="hf-container">
            <div class="flex items-center justify-between py-2 text-sm">
                <div class="flex items-center gap-6">
                    <?php if ($show_date): ?>
                        <div class="flex items-center gap-2 text-secondary-600">
                            <?php echo dst_get_icon('calendar', 'w-4 h-4'); ?>
                            <span><?php echo date_i18n('l، j F Y'); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if ($show_weather): ?>
                        <div class="flex items-center gap-2 text-secondary-600">
                            <?php echo dst_get_icon('cloud', 'w-4 h-4'); ?>
                            <span>تهران: 22°C</span>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="flex items-center gap-4">
                    <?php
                    $social_networks = ['instagram', 'twitter', 'telegram', 'youtube'];
                    foreach ($social_networks as $network):
                        $url = dst_get_social($network);
                        if (!$url) continue;
                    ?>
                        <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener" class="text-secondary-600 hover:text-primary-600 transition-colors">
                            <?php echo dst_get_icon($network, 'w-4 h-4'); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Breaking News Ticker -->
    <?php if ($show_breaking_news): ?>
    <div class="hidden lg:block overflow-hidden" style="background-color: <?php echo esc_attr($topbar_bg_color); ?>; color: <?php echo esc_attr($topbar_text_color); ?>;">
        <div class="hf-container">
            <div class="flex items-center h-10">
                <div class="flex-shrink-0 bg-white/20 px-4 py-1 rounded font-bold text-sm">
                    <?php echo esc_html($breaking_news_label); ?>
                </div>
                <div class="flex-1 overflow-hidden mx-4" x-data="{ marquee: true }">
                    <div class="whitespace-nowrap animate-marquee text-sm">
                        <?php
                        // Get latest posts for ticker
                        $recent_posts = get_posts([
                            'numberposts' => 5,
                            'post_status' => 'publish',
                        ]);
                        if ($recent_posts):
                            $ticker_items = [];
                            foreach ($recent_posts as $post) {
                                $ticker_items[] = esc_html($post->post_title);
                            }
                            echo implode(' • ', $ticker_items);
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        @keyframes marquee {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
        .animate-marquee {
            animation: marquee 30s linear infinite;
        }
    </style>
    <?php endif; ?>

    <!-- Main Header -->
    <div class="border-b border-secondary-100">
        <div class="hf-container">
            <div class="flex items-center justify-between h-20">

                <!-- Logo -->
                <div class="flex-shrink-0">
                    <?php dst_the_logo('default', 'h-14 w-auto max-w-[220px] object-contain'); ?>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex items-center gap-6 flex-1 justify-center">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'container' => false,
                        'menu_class' => 'hf-nav-menu flex items-center gap-4',
                        'fallback_cb' => false,
                        'depth' => 2,
                    ]);
                    ?>
                </nav>

                <!-- Header Actions -->
                <div class="flex items-center gap-3">

                    <!-- Search -->
                    <?php if ($show_search): ?>
                        <div class="relative" x-data="{ searchOpen: false }">
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
                                <form role="search" method="get" action="<?php echo home_url('/'); ?>" class="bg-white shadow-lg rounded-lg p-4 border border-secondary-100">
                                    <input
                                        type="search"
                                        name="s"
                                        placeholder="جستجو در مطالب..."
                                        class="w-full px-4 py-2 border border-secondary-300 rounded-lg focus:outline-none focus:border-primary-500"
                                    />
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Account -->
                    <?php if ($show_account): ?>
                        <a href="<?php echo dst_get_account_url(); ?>" class="hidden md:flex hf-icon-btn">
                            <?php echo dst_get_icon('user'); ?>
                        </a>
                    <?php endif; ?>

                    <!-- Subscribe CTA -->
                    <?php if ($show_cta): ?>
                        <a
                            href="<?php echo esc_url($cta_url); ?>"
                            class="hidden lg:inline-flex hf-btn hf-btn-<?php echo esc_attr($cta_style); ?>"
                        >
                            <?php echo dst_get_icon('mail', 'w-4 h-4'); ?>
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

    <!-- Categories Bar -->
    <?php if ($show_categories_bar): ?>
    <div class="hidden lg:block bg-secondary-50 border-b border-secondary-100">
        <div class="hf-container">
            <div class="flex items-center justify-center gap-6 py-3">
                <?php
                $categories = get_categories([
                    'orderby' => 'count',
                    'order' => 'DESC',
                    'number' => 8,
                    'hide_empty' => true,
                ]);

                if ($categories):
                    foreach ($categories as $category):
                ?>
                    <a href="<?php echo get_category_link($category->term_id); ?>" class="text-sm font-medium text-secondary-700 hover:text-primary-600 transition-colors">
                        <?php echo esc_html($category->name); ?>
                    </a>
                <?php
                    endforeach;
                endif;
                ?>
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
                <form role="search" method="get" action="<?php echo home_url('/'); ?>">
                    <input
                        type="search"
                        name="s"
                        placeholder="جستجو در مطالب..."
                        class="w-full px-4 py-2 border border-secondary-300 rounded-lg focus:outline-none focus:border-primary-500"
                    />
                </form>
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

        <?php if ($show_categories_bar && $categories): ?>
        <div class="p-4 border-t border-secondary-100">
            <h3 class="text-sm font-bold text-secondary-800 mb-3">دسته‌بندی‌ها</h3>
            <div class="grid grid-cols-2 gap-2">
                <?php foreach ($categories as $category): ?>
                    <a href="<?php echo get_category_link($category->term_id); ?>" class="text-sm text-secondary-700 hover:text-primary-600 py-2">
                        <?php echo esc_html($category->name); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="p-4 border-t border-secondary-100 mt-auto">
            <?php if ($show_cta): ?>
                <a href="<?php echo esc_url($cta_url); ?>" class="hf-btn hf-btn-<?php echo esc_attr($cta_style); ?> w-full">
                    <?php echo dst_get_icon('mail', 'w-4 h-4'); ?>
                    <?php echo esc_html($cta_text); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>
