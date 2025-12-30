<?php
/**
 * Header Template: Social-Focused Header
 * Header design emphasizing social media presence with large icons and optional follower counts
 */

defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$is_sticky = $settings['sticky'] ?? true;
$bg_color = $settings['bg_color'] ?? '#ffffff';
$text_color = $settings['text_color'] ?? '#000000';
$show_follower_count = $settings['show_follower_count'] ?? true;
$social_icon_size = $settings['social_icon_size'] ?? 'large';
$social_position = $settings['social_position'] ?? 'center';
$social_layout = $settings['social_layout'] ?? 'horizontal';
$show_social_labels = $settings['show_social_labels'] ?? true;
$social_hover_effect = $settings['social_hover_effect'] ?? 'scale';
$show_menu = $settings['show_menu'] ?? true;
$menu_position = $settings['menu_position'] ?? 'below';
$show_search = $settings['show_search'] ?? false;
$social_bg_color = $settings['social_bg_color'] ?? '#f3f4f6';
$social_hover_color = $settings['social_hover_color'] ?? '#000000';

// Follower counts
$follower_counts = [
    'instagram' => $settings['instagram_followers'] ?? '10.5K',
    'facebook' => $settings['facebook_followers'] ?? '8.2K',
    'youtube' => $settings['youtube_followers'] ?? '5.1K',
    'twitter' => $settings['twitter_followers'] ?? '12.3K',
    'tiktok' => $settings['tiktok_followers'] ?? '15.7K',
];

$icon_size_class = match($social_icon_size) {
    'medium' => 'w-6 h-6',
    'xlarge' => 'w-10 h-10',
    default => 'w-8 h-8'
};

$hover_effect_class = match($social_hover_effect) {
    'color' => 'hover:text-[' . $social_hover_color . ']',
    'lift' => 'hover:-translate-y-1 hover:shadow-lg',
    default => 'hover:scale-110'
};

$social_position_class = match($social_position) {
    'left' => 'justify-start',
    'right' => 'justify-end',
    default => 'justify-center'
};

$social_layout_class = match($social_layout) {
    'grid' => 'grid grid-cols-3 md:grid-cols-5 gap-6',
    default => 'flex flex-wrap gap-6 md:gap-8'
};

$social = dst_get_social();
?>

<header
    x-data="header"
    :class="{
        'shadow-sm': isScrolled,
        '-translate-y-full': isHidden && isScrolled
    }"
    class="<?php echo $is_sticky ? 'hf-header-sticky' : 'relative'; ?> transition-all duration-300"
    style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;"
>
    <div class="hf-container">
        <div class="py-8">
            <!-- Logo (Top) -->
            <div class="flex items-center justify-between mb-8">
                <div class="flex-1 flex justify-center">
                    <?php dst_the_logo('default', 'h-12 w-auto max-w-[200px] object-contain'); ?>
                </div>

                <!-- Mobile Menu Toggle -->
                <button
                    @click="toggleMobileMenu()"
                    class="lg:hidden absolute right-4 top-8 hf-icon-btn"
                    aria-label="Menu"
                >
                    <div class="hf-hamburger" :class="{ 'is-active': isMobileMenuOpen }">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </button>

                <!-- Search Icon -->
                <?php if ($show_search): ?>
                    <button
                        @click="toggleSearch()"
                        class="absolute right-16 top-8 hf-icon-btn"
                        aria-label="Search"
                    >
                        <?php echo dst_get_icon('search', 'w-5 h-5'); ?>
                    </button>
                <?php endif; ?>
            </div>

            <!-- Menu Above Social -->
            <?php if ($show_menu && $menu_position === 'above'): ?>
                <nav class="hidden lg:flex items-center justify-center mb-8">
                    <?php
                    if (has_nav_menu('primary')) {
                        wp_nav_menu([
                            'theme_location' => 'primary',
                            'container' => false,
                            'menu_class' => 'flex items-center gap-8 text-sm',
                            'fallback_cb' => false,
                            'depth' => 1,
                        ]);
                    }
                    ?>
                </nav>
            <?php endif; ?>

            <!-- Social Icons Section -->
            <div class="<?php echo esc_attr($social_layout_class); ?> <?php echo esc_attr($social_position_class); ?> mb-8">
                <?php
                foreach ($social as $platform => $url):
                    if (!empty($url)):
                        $follower_count = $follower_counts[$platform] ?? '';
                ?>
                    <a
                        href="<?php echo esc_url($url); ?>"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex flex-col items-center gap-2 group transition-all duration-300 <?php echo esc_attr($hover_effect_class); ?>"
                        aria-label="<?php echo esc_attr(ucfirst($platform)); ?>"
                    >
                        <div
                            class="flex items-center justify-center w-16 h-16 rounded-full transition-all duration-300"
                            style="background-color: <?php echo esc_attr($social_bg_color); ?>;"
                        >
                            <?php echo dst_get_icon($platform, $icon_size_class); ?>
                        </div>

                        <?php if ($show_social_labels): ?>
                            <span class="text-xs font-medium uppercase tracking-wider">
                                <?php echo esc_html(ucfirst($platform)); ?>
                            </span>
                        <?php endif; ?>

                        <?php if ($show_follower_count && !empty($follower_count)): ?>
                            <span class="text-sm font-bold opacity-70">
                                <?php echo esc_html($follower_count); ?>
                            </span>
                        <?php endif; ?>
                    </a>
                <?php
                    endif;
                endforeach;
                ?>
            </div>

            <!-- Menu Below Social -->
            <?php if ($show_menu && $menu_position === 'below'): ?>
                <nav class="hidden lg:flex items-center justify-center border-t border-secondary-100 pt-6">
                    <?php
                    if (has_nav_menu('primary')) {
                        wp_nav_menu([
                            'theme_location' => 'primary',
                            'container' => false,
                            'menu_class' => 'flex items-center gap-8 text-sm',
                            'fallback_cb' => false,
                            'depth' => 1,
                        ]);
                    }
                    ?>
                </nav>
            <?php endif; ?>
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
            class="border-t border-secondary-100"
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
    <div
        class="fixed inset-0 z-50 bg-white lg:hidden"
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
            <!-- Menu Header -->
            <div class="flex items-center justify-between p-6 border-b border-secondary-100">
                <?php dst_the_logo('default', 'h-8 w-auto max-w-[140px] object-contain'); ?>
                <button @click="closeMobileMenu()" class="hf-icon-btn">
                    <?php echo dst_get_icon('close', 'w-6 h-6'); ?>
                </button>
            </div>

            <!-- Menu Content -->
            <div class="flex-1 overflow-y-auto">
                <?php if ($show_menu && has_nav_menu('primary')): ?>
                    <nav class="p-6 border-b border-secondary-100">
                        <?php
                        wp_nav_menu([
                            'theme_location' => 'primary',
                            'container' => false,
                            'menu_class' => 'space-y-4 text-lg',
                            'fallback_cb' => false,
                            'depth' => 1,
                        ]);
                        ?>
                    </nav>
                <?php endif; ?>

                <!-- Social Links -->
                <div class="p-6">
                    <h3 class="text-xs font-semibold uppercase tracking-wider mb-6 text-secondary-500">Follow Us</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <?php
                        foreach ($social as $platform => $url):
                            if (!empty($url)):
                                $follower_count = $follower_counts[$platform] ?? '';
                        ?>
                            <a
                                href="<?php echo esc_url($url); ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex items-center gap-3 p-4 rounded-lg hover:bg-secondary-50 transition-colors"
                            >
                                <div class="flex items-center justify-center w-12 h-12 rounded-full" style="background-color: <?php echo esc_attr($social_bg_color); ?>;">
                                    <?php echo dst_get_icon($platform, 'w-6 h-6'); ?>
                                </div>
                                <div class="flex-1">
                                    <div class="text-xs font-medium uppercase"><?php echo esc_html(ucfirst($platform)); ?></div>
                                    <?php if ($show_follower_count && !empty($follower_count)): ?>
                                        <div class="text-sm font-bold"><?php echo esc_html($follower_count); ?></div>
                                    <?php endif; ?>
                                </div>
                            </a>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
