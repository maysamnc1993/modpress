<?php
/**
 * Header Template: Blog Optimized
 * Blog optimized with categories, search, subscribe button, and author info dropdown
 */

defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$is_sticky = $settings['sticky'] ?? true;
$show_topbar = $settings['show_topbar'] ?? true;
$topbar_bg_color = $settings['topbar_bg_color'] ?? '#f9fafb';
$topbar_text_color = $settings['topbar_text_color'] ?? '#374151';
$show_search = $settings['show_search'] ?? true;
$show_cart = $settings['show_cart'] ?? false;
$show_account = $settings['show_account'] ?? true;
$show_wishlist = $settings['show_wishlist'] ?? false;
$bg_color = $settings['bg_color'] ?? '#ffffff';
$text_color = $settings['text_color'] ?? '#111827';
$show_cta = $settings['show_cta'] ?? true;
$cta_text = $settings['cta_text'] ?? 'Subscribe';
$cta_url = $settings['cta_url'] ?? '/subscribe';
$cta_style = $settings['cta_style'] ?? 'primary';

$cta_button_class = match($cta_style) {
    'secondary' => 'hf-btn hf-btn-secondary',
    'outline' => 'hf-btn hf-btn-outline',
    default => 'hf-btn hf-btn-primary'
};
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
    <!-- Top Bar -->
    <?php if ($show_topbar): ?>
        <div class="border-b border-secondary-100 text-sm hidden lg:block" style="background-color: <?php echo esc_attr($topbar_bg_color); ?>; color: <?php echo esc_attr($topbar_text_color); ?>;">
            <div class="hf-container">
                <div class="flex items-center justify-between py-2">
                    <!-- Trending/Featured -->
                    <div class="flex items-center gap-4">
                        <span class="font-semibold">Trending:</span>
                        <?php
                        $trending_posts = get_posts([
                            'posts_per_page' => 3,
                            'orderby' => 'comment_count',
                            'order' => 'DESC',
                        ]);

                        if ($trending_posts):
                            foreach ($trending_posts as $index => $post):
                        ?>
                            <a href="<?php echo get_permalink($post); ?>" class="hover:text-primary-600 transition-colors">
                                <?php echo esc_html(wp_trim_words($post->post_title, 6)); ?>
                            </a>
                            <?php if ($index < count($trending_posts) - 1): ?>
                                <span class="text-secondary-300">•</span>
                            <?php endif; ?>
                        <?php
                            endforeach;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>

                    <!-- Social Links -->
                    <div class="flex items-center gap-3">
                        <span class="text-xs">Follow us:</span>
                        <?php
                        $social = dst_get_social();
                        foreach ($social as $platform => $url):
                            if (!empty($url)):
                        ?>
                            <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="hover:text-primary-600 transition-colors" aria-label="<?php echo esc_attr($platform); ?>">
                                <?php echo dst_get_icon($platform, 'w-4 h-4'); ?>
                            </a>
                        <?php
                            endif;
                        endforeach;
                        ?>
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
            <nav class="hidden lg:flex items-center gap-8">
                <a href="<?php echo home_url('/'); ?>" class="nav-link text-sm font-semibold hover:text-primary-600 transition-colors">
                    Home
                </a>

                <div class="relative" x-data="{ open: false }">
                    <button
                        @mouseenter="open = true"
                        @mouseleave="open = false"
                        class="nav-link text-sm font-semibold hover:text-primary-600 transition-colors flex items-center gap-1"
                    >
                        <span>Categories</span>
                        <?php echo dst_get_icon('chevron-down', 'w-4 h-4 transition-transform', ['x-bind:class' => "{ 'rotate-180': open }"]); ?>
                    </button>

                    <div
                        x-show="open"
                        @mouseenter="open = true"
                        @mouseleave="open = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-1"
                        class="absolute top-full left-0 mt-2 w-56 bg-white shadow-xl rounded-lg border border-secondary-100 py-2 z-50"
                        style="display: none;"
                    >
                        <?php
                        $categories = get_categories([
                            'hide_empty' => true,
                            'number' => 8,
                        ]);

                        if ($categories):
                            foreach ($categories as $category):
                        ?>
                            <a href="<?php echo get_category_link($category); ?>" class="flex items-center justify-between px-4 py-2 hover:bg-secondary-50 transition-colors">
                                <span><?php echo esc_html($category->name); ?></span>
                                <span class="text-xs text-secondary-500">(<?php echo $category->count; ?>)</span>
                            </a>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>

                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'flex items-center gap-8',
                    'fallback_cb' => false,
                    'depth' => 1,
                    'items_wrap' => '%3$s',
                ]);
                ?>
            </nav>

            <!-- Header Actions -->
            <div class="flex items-center gap-3">
                <!-- Search -->
                <?php if ($show_search): ?>
                    <button
                        @click="toggleSearch()"
                        class="hidden lg:flex hf-icon-btn"
                        aria-label="Search"
                    >
                        <?php echo dst_get_icon('search', 'w-5 h-5'); ?>
                    </button>
                <?php endif; ?>

                <!-- Account/Author Dropdown -->
                <?php if ($show_account): ?>
                    <div class="relative hidden lg:block" x-data="{ open: false }">
                        <button
                            @click="open = !open"
                            class="hf-icon-btn"
                            aria-label="Account"
                        >
                            <?php echo dst_get_icon('user', 'w-5 h-5'); ?>
                        </button>

                        <div
                            x-show="open"
                            x-transition
                            @click.outside="open = false"
                            class="absolute top-full right-0 mt-2 w-56 bg-white shadow-xl rounded-lg border border-secondary-100 py-2 z-50"
                            style="display: none;"
                        >
                            <?php if (is_user_logged_in()): ?>
                                <div class="px-4 py-3 border-b border-secondary-100">
                                    <div class="font-semibold"><?php echo esc_html(wp_get_current_user()->display_name); ?></div>
                                    <div class="text-xs text-secondary-500"><?php echo esc_html(wp_get_current_user()->user_email); ?></div>
                                </div>
                                <a href="<?php echo admin_url(); ?>" class="block px-4 py-2 hover:bg-secondary-50 transition-colors">Dashboard</a>
                                <a href="<?php echo get_edit_profile_url(); ?>" class="block px-4 py-2 hover:bg-secondary-50 transition-colors">Edit Profile</a>
                                <a href="<?php echo wp_logout_url(home_url()); ?>" class="block px-4 py-2 hover:bg-secondary-50 transition-colors text-red-600">Logout</a>
                            <?php else: ?>
                                <a href="<?php echo wp_login_url(); ?>" class="block px-4 py-2 hover:bg-secondary-50 transition-colors">Login</a>
                                <a href="<?php echo wp_registration_url(); ?>" class="block px-4 py-2 hover:bg-secondary-50 transition-colors">Register</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Subscribe CTA -->
                <?php if ($show_cta): ?>
                    <a href="<?php echo esc_url($cta_url); ?>" class="hidden lg:inline-flex <?php echo esc_attr($cta_button_class); ?>">
                        <?php echo dst_get_icon('mail', 'w-4 h-4 mr-1'); ?>
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
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black bg-opacity-50 z-50"
            @click="closeSearch()"
            style="display: none;"
        >
            <div class="hf-container">
                <div class="max-w-3xl mx-auto mt-24">
                    <div class="bg-white rounded-lg p-6 shadow-2xl" @click.stop>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold">Search Articles</h3>
                            <button @click="closeSearch()" class="hf-icon-btn">
                                <?php echo dst_get_icon('close', 'w-6 h-6'); ?>
                            </button>
                        </div>
                        <?php get_search_form(); ?>

                        <?php
                        $popular_posts = get_posts([
                            'posts_per_page' => 5,
                            'orderby' => 'comment_count',
                            'order' => 'DESC',
                        ]);

                        if ($popular_posts):
                        ?>
                            <div class="mt-6">
                                <h4 class="text-sm font-semibold text-secondary-600 mb-3">Popular Articles</h4>
                                <div class="space-y-2">
                                    <?php foreach ($popular_posts as $post): ?>
                                        <a href="<?php echo get_permalink($post); ?>" class="block p-2 hover:bg-secondary-50 rounded transition-colors">
                                            <div class="font-medium text-sm"><?php echo esc_html($post->post_title); ?></div>
                                            <div class="text-xs text-secondary-500"><?php echo get_the_date('F j, Y', $post); ?></div>
                                        </a>
                                    <?php endforeach; ?>
                                    <?php wp_reset_postdata(); ?>
                                </div>
                            </div>
                        <?php endif; ?>
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
            <span class="text-lg font-bold">Menu</span>
            <button @click="closeMobileMenu()" class="hf-icon-btn">
                <?php echo dst_get_icon('close'); ?>
            </button>
        </div>

        <?php if ($show_search): ?>
            <div class="p-4 border-b border-secondary-100">
                <?php get_search_form(); ?>
            </div>
        <?php endif; ?>

        <nav class="p-4">
            <div class="space-y-4">
                <a href="<?php echo home_url('/'); ?>" class="block text-base font-semibold py-2 hover:text-primary-600 transition-colors">
                    Home
                </a>

                <div x-data="{ open: false }">
                    <button @click="open = !open" class="w-full flex items-center justify-between text-base font-semibold py-2 hover:text-primary-600 transition-colors">
                        <span>Categories</span>
                        <?php echo dst_get_icon('chevron-down', 'w-5 h-5 transition-transform', ['x-bind:class' => "{ 'rotate-180': open }"]); ?>
                    </button>
                    <div x-show="open" x-collapse class="pl-4 mt-2 space-y-2">
                        <?php
                        $categories = get_categories(['hide_empty' => true, 'number' => 10]);
                        if ($categories):
                            foreach ($categories as $category):
                        ?>
                            <a href="<?php echo get_category_link($category); ?>" class="block py-2 text-secondary-600">
                                <?php echo esc_html($category->name); ?> (<?php echo $category->count; ?>)
                            </a>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>

                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'space-y-4',
                    'fallback_cb' => false,
                    'depth' => 1,
                ]);
                ?>
            </div>
        </nav>

        <div class="p-4 border-t border-secondary-100 mt-auto">
            <?php if ($show_cta): ?>
                <a href="<?php echo esc_url($cta_url); ?>" class="<?php echo esc_attr($cta_button_class); ?> w-full justify-center mb-4">
                    <?php echo dst_get_icon('mail', 'w-4 h-4 mr-1'); ?>
                    <?php echo esc_html($cta_text); ?>
                </a>
            <?php endif; ?>

            <div class="flex items-center justify-center gap-4">
                <?php
                $social = dst_get_social();
                foreach ($social as $platform => $url):
                    if (!empty($url)):
                ?>
                    <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="text-secondary-600 hover:text-primary-600 transition-colors" aria-label="<?php echo esc_attr($platform); ?>">
                        <?php echo dst_get_icon($platform, 'w-5 h-5'); ?>
                    </a>
                <?php
                    endif;
                endforeach;
                ?>
            </div>
        </div>
    </div>
</header>
