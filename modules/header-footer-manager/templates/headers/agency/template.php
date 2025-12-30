<?php
/**
 * Header Template: Creative Agency
 * Creative agency style with animated menu, portfolio dropdown, and contact button
 */

defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$is_sticky = $settings['sticky'] ?? true;
$show_topbar = $settings['show_topbar'] ?? false;
$topbar_bg_color = $settings['topbar_bg_color'] ?? '#111827';
$topbar_text_color = $settings['topbar_text_color'] ?? '#ffffff';
$show_search = $settings['show_search'] ?? false;
$show_cart = $settings['show_cart'] ?? false;
$show_account = $settings['show_account'] ?? false;
$show_wishlist = $settings['show_wishlist'] ?? false;
$bg_color = $settings['bg_color'] ?? '#ffffff';
$text_color = $settings['text_color'] ?? '#111827';
$show_cta = $settings['show_cta'] ?? true;
$cta_text = $settings['cta_text'] ?? "Let's Talk";
$cta_url = $settings['cta_url'] ?? '/contact';
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
        <div class="text-sm hidden lg:block" style="background-color: <?php echo esc_attr($topbar_bg_color); ?>; color: <?php echo esc_attr($topbar_text_color); ?>;">
            <div class="hf-container">
                <div class="flex items-center justify-between py-2">
                    <div class="flex items-center gap-4">
                        <?php
                        $contact = dst_get_contact();
                        if (!empty($contact['email'])):
                        ?>
                            <a href="mailto:<?php echo esc_attr($contact['email']); ?>" class="hover:opacity-80 transition-opacity">
                                <?php echo esc_html($contact['email']); ?>
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="flex items-center gap-4">
                        <?php
                        $social = dst_get_social();
                        foreach ($social as $platform => $url):
                            if (!empty($url)):
                        ?>
                            <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="hover:opacity-80 transition-opacity" aria-label="<?php echo esc_attr($platform); ?>">
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
        <div class="flex items-center justify-between h-24">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <?php dst_the_logo('default', 'h-14 w-auto max-w-[220px] object-contain'); ?>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex items-center gap-10">
                <a href="<?php echo home_url('/'); ?>" class="nav-link text-base font-medium hover:text-primary-600 transition-colors">
                    Home
                </a>

                <div class="relative" x-data="{ open: false }">
                    <button
                        @mouseenter="open = true"
                        @mouseleave="open = false"
                        class="nav-link text-base font-medium hover:text-primary-600 transition-colors flex items-center gap-1"
                    >
                        <span>Services</span>
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
                        <a href="#" class="block px-4 py-3 hover:bg-secondary-50 transition-colors">
                            <div class="font-semibold text-secondary-900">Web Design</div>
                            <div class="text-xs text-secondary-500">Beautiful & responsive websites</div>
                        </a>
                        <a href="#" class="block px-4 py-3 hover:bg-secondary-50 transition-colors">
                            <div class="font-semibold text-secondary-900">Branding</div>
                            <div class="text-xs text-secondary-500">Identity & visual design</div>
                        </a>
                        <a href="#" class="block px-4 py-3 hover:bg-secondary-50 transition-colors">
                            <div class="font-semibold text-secondary-900">Digital Marketing</div>
                            <div class="text-xs text-secondary-500">SEO & social media</div>
                        </a>
                        <a href="#" class="block px-4 py-3 hover:bg-secondary-50 transition-colors">
                            <div class="font-semibold text-secondary-900">Development</div>
                            <div class="text-xs text-secondary-500">Custom web applications</div>
                        </a>
                    </div>
                </div>

                <div class="relative" x-data="{ open: false }">
                    <button
                        @mouseenter="open = true"
                        @mouseleave="open = false"
                        class="nav-link text-base font-medium hover:text-primary-600 transition-colors flex items-center gap-1"
                    >
                        <span>Portfolio</span>
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
                        class="absolute top-full left-0 mt-2 w-48 bg-white shadow-xl rounded-lg border border-secondary-100 py-2 z-50"
                        style="display: none;"
                    >
                        <a href="#" class="block px-4 py-2 hover:bg-secondary-50 transition-colors">All Projects</a>
                        <a href="#" class="block px-4 py-2 hover:bg-secondary-50 transition-colors">Web Design</a>
                        <a href="#" class="block px-4 py-2 hover:bg-secondary-50 transition-colors">Branding</a>
                        <a href="#" class="block px-4 py-2 hover:bg-secondary-50 transition-colors">Case Studies</a>
                    </div>
                </div>

                <a href="<?php echo home_url('/about'); ?>" class="nav-link text-base font-medium hover:text-primary-600 transition-colors">
                    About
                </a>

                <a href="<?php echo home_url('/blog'); ?>" class="nav-link text-base font-medium hover:text-primary-600 transition-colors">
                    Blog
                </a>
            </nav>

            <!-- Header Actions -->
            <div class="flex items-center gap-4">
                <?php if ($show_cta): ?>
                    <a href="<?php echo esc_url($cta_url); ?>" class="hidden lg:inline-flex <?php echo esc_attr($cta_button_class); ?>">
                        <?php echo esc_html($cta_text); ?>
                        <?php echo dst_get_icon('arrow-right', 'w-4 h-4 ml-1'); ?>
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

        <nav class="p-4">
            <div class="space-y-4">
                <a href="<?php echo home_url('/'); ?>" class="block text-lg font-medium py-2 hover:text-primary-600 transition-colors">
                    Home
                </a>

                <div x-data="{ open: false }">
                    <button @click="open = !open" class="w-full flex items-center justify-between text-lg font-medium py-2 hover:text-primary-600 transition-colors">
                        <span>Services</span>
                        <?php echo dst_get_icon('chevron-down', 'w-5 h-5 transition-transform', ['x-bind:class' => "{ 'rotate-180': open }"]); ?>
                    </button>
                    <div x-show="open" x-collapse class="pl-4 mt-2 space-y-2">
                        <a href="#" class="block py-2 text-secondary-600">Web Design</a>
                        <a href="#" class="block py-2 text-secondary-600">Branding</a>
                        <a href="#" class="block py-2 text-secondary-600">Digital Marketing</a>
                        <a href="#" class="block py-2 text-secondary-600">Development</a>
                    </div>
                </div>

                <div x-data="{ open: false }">
                    <button @click="open = !open" class="w-full flex items-center justify-between text-lg font-medium py-2 hover:text-primary-600 transition-colors">
                        <span>Portfolio</span>
                        <?php echo dst_get_icon('chevron-down', 'w-5 h-5 transition-transform', ['x-bind:class' => "{ 'rotate-180': open }"]); ?>
                    </button>
                    <div x-show="open" x-collapse class="pl-4 mt-2 space-y-2">
                        <a href="#" class="block py-2 text-secondary-600">All Projects</a>
                        <a href="#" class="block py-2 text-secondary-600">Web Design</a>
                        <a href="#" class="block py-2 text-secondary-600">Branding</a>
                        <a href="#" class="block py-2 text-secondary-600">Case Studies</a>
                    </div>
                </div>

                <a href="<?php echo home_url('/about'); ?>" class="block text-lg font-medium py-2 hover:text-primary-600 transition-colors">
                    About
                </a>

                <a href="<?php echo home_url('/blog'); ?>" class="block text-lg font-medium py-2 hover:text-primary-600 transition-colors">
                    Blog
                </a>
            </div>
        </nav>

        <div class="p-4 border-t border-secondary-100 mt-auto">
            <?php if ($show_cta): ?>
                <a href="<?php echo esc_url($cta_url); ?>" class="<?php echo esc_attr($cta_button_class); ?> w-full justify-center">
                    <?php echo esc_html($cta_text); ?>
                    <?php echo dst_get_icon('arrow-right', 'w-4 h-4 ml-1'); ?>
                </a>
            <?php endif; ?>

            <div class="flex items-center justify-center gap-4 mt-4">
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
