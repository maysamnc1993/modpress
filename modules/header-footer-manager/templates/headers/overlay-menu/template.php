<?php
/**
 * Header Template: Fullscreen Overlay Menu
 * Minimal header with logo and hamburger that opens a fullscreen dark overlay with large menu items
 */

defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$is_sticky = $settings['sticky'] ?? true;
$bg_color = $settings['bg_color'] ?? '#ffffff';
$text_color = $settings['text_color'] ?? '#000000';
$overlay_bg_color = $settings['overlay_bg_color'] ?? '#000000';
$overlay_text_color = $settings['overlay_text_color'] ?? '#ffffff';
$menu_font_size = $settings['menu_font_size'] ?? '3xl';
$menu_alignment = $settings['menu_alignment'] ?? 'left';
$show_social = $settings['show_social'] ?? true;
$show_contact = $settings['show_contact'] ?? true;
$hamburger_style = $settings['hamburger_style'] ?? 'minimal';
$logo_position = $settings['logo_position'] ?? 'center';
$animation_speed = $settings['animation_speed'] ?? 'normal';
$menu_hover_color = $settings['menu_hover_color'] ?? '#999999';
$show_search = $settings['show_search'] ?? true;
$overlay_opacity = $settings['overlay_opacity'] ?? '95';
$show_cta = $settings['show_cta'] ?? true;
$cta_text = $settings['cta_text'] ?? 'Get Started';
$cta_url = $settings['cta_url'] ?? '/contact';

$animation_duration = match($animation_speed) {
    'fast' => '200',
    'slow' => '500',
    default => '300'
};

$hamburger_class = match($hamburger_style) {
    'bold' => 'stroke-[3px]',
    'rounded' => 'rounded-full',
    default => 'stroke-2'
};

$menu_alignment_class = match($menu_alignment) {
    'center' => 'text-center items-center',
    'right' => 'text-right items-end',
    default => 'text-left items-start'
};

$logo_position_class = match($logo_position) {
    'left' => 'justify-start',
    default => 'justify-center'
};
?>

<header
    x-data="header"
    :class="{
        'shadow-sm': isScrolled,
        '-translate-y-full': isHidden && isScrolled
    }"
    class="<?php echo $is_sticky ? 'hf-header-sticky' : 'relative'; ?> transition-all duration-300 z-40"
    style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;"
>
    <div class="hf-container">
        <div class="flex items-center justify-between h-20">
            <!-- Hamburger Menu Button -->
            <button
                @click="toggleMobileMenu()"
                class="relative z-50 p-2 transition-transform hover:scale-110"
                :class="{ 'text-white': isMobileMenuOpen }"
                aria-label="Toggle Menu"
            >
                <div class="hf-hamburger <?php echo esc_attr($hamburger_class); ?>" :class="{ 'is-active': isMobileMenuOpen }">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>

            <!-- Logo -->
            <div class="flex-1 flex <?php echo esc_attr($logo_position_class); ?>">
                <?php dst_the_logo('default', 'h-8 w-auto max-w-[180px] object-contain'); ?>
            </div>

            <!-- Right Spacer (to balance hamburger) -->
            <div class="w-10"></div>
        </div>
    </div>

    <!-- Fullscreen Overlay Menu -->
    <div
        class="fixed inset-0 z-50"
        :class="{ 'pointer-events-none': !isMobileMenuOpen }"
        x-show="isMobileMenuOpen"
        x-transition:enter="transition ease-out duration-<?php echo esc_attr($animation_duration); ?>"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-<?php echo esc_attr($animation_duration); ?>"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="display: none; background-color: <?php echo esc_attr($overlay_bg_color); ?>; opacity: <?php echo esc_attr($overlay_opacity / 100); ?>;"
    >
        <div class="absolute inset-0 overflow-y-auto" style="background-color: <?php echo esc_attr($overlay_bg_color); ?>; color: <?php echo esc_attr($overlay_text_color); ?>;">
            <div class="hf-container min-h-screen">
                <!-- Header -->
                <div class="flex items-center justify-between h-20">
                    <button
                        @click="closeMobileMenu()"
                        class="relative z-50 p-2 transition-transform hover:scale-110"
                        style="color: <?php echo esc_attr($overlay_text_color); ?>;"
                        aria-label="Close Menu"
                    >
                        <div class="hf-hamburger is-active <?php echo esc_attr($hamburger_class); ?>">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </button>

                    <div class="flex-1 flex <?php echo esc_attr($logo_position_class); ?>">
                        <?php dst_the_logo('default', 'h-8 w-auto max-w-[180px] object-contain brightness-0 invert'); ?>
                    </div>

                    <div class="w-10"></div>
                </div>

                <!-- Main Content Grid -->
                <div class="grid lg:grid-cols-2 gap-12 py-12 min-h-[calc(100vh-5rem)]">
                    <!-- Left Column: Navigation -->
                    <div class="flex flex-col justify-center">
                        <nav class="flex flex-col <?php echo esc_attr($menu_alignment_class); ?> space-y-4">
                            <?php
                            if (has_nav_menu('primary')) {
                                wp_nav_menu([
                                    'theme_location' => 'primary',
                                    'container' => false,
                                    'menu_class' => 'space-y-4',
                                    'link_before' => '<span class="text-' . esc_attr($menu_font_size) . ' font-light hover:text-[' . esc_attr($menu_hover_color) . '] transition-colors duration-300 inline-block">',
                                    'link_after' => '</span>',
                                    'fallback_cb' => false,
                                    'depth' => 1,
                                ]);
                            }
                            ?>
                        </nav>

                        <?php if ($show_cta): ?>
                            <div class="mt-12 flex <?php echo esc_attr($menu_alignment_class); ?>">
                                <a
                                    href="<?php echo esc_url($cta_url); ?>"
                                    class="inline-flex items-center justify-center px-8 py-4 border-2 border-current text-lg font-medium hover:bg-white hover:text-black transition-all duration-300"
                                    style="color: <?php echo esc_attr($overlay_text_color); ?>;"
                                >
                                    <?php echo esc_html($cta_text); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Right Column: Additional Info -->
                    <div class="flex flex-col justify-center space-y-12">
                        <?php if ($show_search): ?>
                            <!-- Search -->
                            <div>
                                <h3 class="text-sm font-semibold uppercase tracking-wider mb-4" style="color: <?php echo esc_attr($menu_hover_color); ?>;">Search</h3>
                                <div class="relative max-w-md">
                                    <?php get_search_form(); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($show_contact): ?>
                            <!-- Contact Info -->
                            <div>
                                <h3 class="text-sm font-semibold uppercase tracking-wider mb-4" style="color: <?php echo esc_attr($menu_hover_color); ?>;">Contact</h3>
                                <div class="space-y-2 text-lg">
                                    <?php
                                    $contact = dst_get_contact();
                                    if (!empty($contact['phone'])):
                                    ?>
                                        <div>
                                            <a href="tel:<?php echo esc_attr($contact['phone']); ?>" class="hover:text-[<?php echo esc_attr($menu_hover_color); ?>] transition-colors">
                                                <?php echo esc_html($contact['phone']); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($contact['email'])): ?>
                                        <div>
                                            <a href="mailto:<?php echo esc_attr($contact['email']); ?>" class="hover:text-[<?php echo esc_attr($menu_hover_color); ?>] transition-colors">
                                                <?php echo esc_html($contact['email']); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($show_social): ?>
                            <!-- Social Icons -->
                            <div>
                                <h3 class="text-sm font-semibold uppercase tracking-wider mb-4" style="color: <?php echo esc_attr($menu_hover_color); ?>;">Follow Us</h3>
                                <div class="flex gap-6">
                                    <?php
                                    $social = dst_get_social();
                                    foreach ($social as $platform => $url):
                                        if (!empty($url)):
                                    ?>
                                        <a
                                            href="<?php echo esc_url($url); ?>"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="hover:text-[<?php echo esc_attr($menu_hover_color); ?>] transition-colors transform hover:scale-110"
                                            aria-label="<?php echo esc_attr($platform); ?>"
                                        >
                                            <?php echo dst_get_icon($platform, 'w-6 h-6'); ?>
                                        </a>
                                    <?php
                                        endif;
                                    endforeach;
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
