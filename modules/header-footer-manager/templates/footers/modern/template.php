<?php
/**
 * Footer Template: Clean Modern
 * Clean modern 3-column footer with large newsletter section, social icons, and minimal links
 */

defined('ABSPATH') || exit;

$settings = dst_get_footer_setting();
$bg_color = $settings['bg_color'] ?? '#0f172a';
$text_color = $settings['text_color'] ?? '#cbd5e1';
$link_color = $settings['link_color'] ?? '#f1f5f9';
$link_hover_color = $settings['link_hover_color'] ?? '#06b6d4';
$show_logo = $settings['show_logo'] ?? true;
$show_description = $settings['show_description'] ?? true;
$description_text = $settings['description_text'] ?? 'Creating beautiful digital experiences that inspire and engage.';
$show_social = $settings['show_social'] ?? true;
$show_newsletter = $settings['show_newsletter'] ?? true;
$newsletter_title = $settings['newsletter_title'] ?? 'Stay Updated';
$newsletter_text = $settings['newsletter_text'] ?? 'Join our community and never miss out on the latest news and updates.';
$show_contact = $settings['show_contact'] ?? false;
$columns = $settings['columns'] ?? '3';
$show_menu1 = $settings['show_menu1'] ?? true;
$menu1_title = $settings['menu1_title'] ?? 'Quick Links';
$show_menu2 = $settings['show_menu2'] ?? true;
$menu2_title = $settings['menu2_title'] ?? 'Resources';
$show_copyright = $settings['show_copyright'] ?? true;
$copyright_text = $settings['copyright_text'] ?? 'All rights reserved.';
$show_payment_icons = $settings['show_payment_icons'] ?? false;
$show_back_to_top = $settings['show_back_to_top'] ?? true;

$contact = dst_get_contact();
?>

<footer class="hf-footer hf-footer-modern" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;">
    <style>
        .hf-footer-modern a {
            color: <?php echo esc_attr($link_color); ?>;
        }
        .hf-footer-modern a:hover {
            color: <?php echo esc_attr($link_hover_color); ?>;
        }
    </style>

    <!-- Newsletter Section (Featured) -->
    <?php if ($show_newsletter): ?>
        <div class="border-b border-white/10">
            <div class="hf-container py-16 lg:py-20">
                <div class="max-w-3xl mx-auto text-center space-y-6">
                    <h2 class="text-3xl lg:text-4xl font-bold" style="color: <?php echo esc_attr($link_color); ?>;">
                        <?php echo esc_html($newsletter_title); ?>
                    </h2>
                    <p class="text-lg opacity-90">
                        <?php echo esc_html($newsletter_text); ?>
                    </p>
                    <form class="flex flex-col sm:flex-row gap-3 max-w-xl mx-auto pt-4" onsubmit="return false;">
                        <input
                            type="email"
                            placeholder="Enter your email address"
                            class="flex-1 px-6 py-4 text-base rounded-xl bg-white/10 border border-white/20 focus:outline-none focus:border-white/40 focus:bg-white/15 placeholder:text-white/50 transition-all"
                            style="color: <?php echo esc_attr($link_color); ?>;"
                        >
                        <button
                            type="submit"
                            class="px-8 py-4 text-base font-semibold rounded-xl transition-all duration-300 hover:scale-105 hover:shadow-lg"
                            style="background: linear-gradient(135deg, <?php echo esc_attr($link_hover_color); ?>, <?php echo esc_attr($link_hover_color); ?>dd); color: white;"
                        >
                            Subscribe
                        </button>
                    </form>
                    <p class="text-sm opacity-75 pt-2">
                        We respect your privacy. Unsubscribe at any time.
                    </p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Footer -->
    <div class="hf-container py-12 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-<?php echo esc_attr($columns); ?> gap-8 lg:gap-16">

            <!-- Column 1: Brand & Social -->
            <div class="space-y-6">
                <?php if ($show_logo): ?>
                    <div class="mb-4">
                        <?php
                        $logo = dst_get_logo('light');
                        if ($logo): ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block">
                                <img src="<?php echo esc_url($logo); ?>" alt="<?php bloginfo('name'); ?>" class="h-12 w-auto">
                            </a>
                        <?php else: ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-2xl font-bold" style="color: <?php echo esc_attr($link_color); ?>;">
                                <?php bloginfo('name'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ($show_description): ?>
                    <p class="text-base leading-relaxed max-w-sm">
                        <?php echo esc_html($description_text ?: get_bloginfo('description')); ?>
                    </p>
                <?php endif; ?>

                <?php if ($show_social): ?>
                    <div class="flex gap-4 pt-4">
                        <?php
                        $socials = dst_get_socials();
                        $social_icons = [
                            'instagram' => '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>',
                            'twitter' => '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>',
                            'linkedin' => '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
                            'facebook' => '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
                            'youtube' => '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
                            'github' => '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>'
                        ];

                        foreach ($socials as $network => $url):
                            if (!empty($url) && isset($social_icons[$network])): ?>
                                <a
                                    href="<?php echo esc_url($url); ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="p-2 rounded-lg bg-white/5 hover:bg-white/10 transition-all duration-300"
                                    aria-label="<?php echo esc_attr(ucfirst($network)); ?>"
                                >
                                    <?php echo $social_icons[$network]; ?>
                                </a>
                            <?php endif;
                        endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Column 2: Quick Links -->
            <?php if ($show_menu1): ?>
                <div class="space-y-5">
                    <h3 class="text-lg font-semibold" style="color: <?php echo esc_attr($link_color); ?>;">
                        <?php echo esc_html($menu1_title); ?>
                    </h3>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer-menu-1',
                        'container'      => false,
                        'menu_class'     => 'space-y-3 text-base',
                        'fallback_cb'    => false,
                        'depth'          => 1,
                    ]);
                    ?>
                </div>
            <?php endif; ?>

            <!-- Column 3: Resources -->
            <?php if ($show_menu2): ?>
                <div class="space-y-5">
                    <h3 class="text-lg font-semibold" style="color: <?php echo esc_attr($link_color); ?>;">
                        <?php echo esc_html($menu2_title); ?>
                    </h3>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer-menu-2',
                        'container'      => false,
                        'menu_class'     => 'space-y-3 text-base',
                        'fallback_cb'    => false,
                        'depth'          => 1,
                    ]);
                    ?>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="border-t border-white/10">
        <div class="hf-container py-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">

                <?php if ($show_copyright): ?>
                    <div class="text-sm text-center md:text-<?php echo is_rtl() ? 'right' : 'left'; ?>">
                        &copy; <?php echo date('Y'); ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:underline">
                            <?php bloginfo('name'); ?>
                        </a>
                        <?php if ($copyright_text): ?>
                            - <?php echo esc_html($copyright_text); ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ($show_payment_icons): ?>
                    <div class="flex items-center gap-3">
                        <div class="flex gap-2">
                            <svg class="h-8 w-auto opacity-60 hover:opacity-100 transition-opacity" viewBox="0 0 38 24" fill="none"><rect width="38" height="24" rx="3" fill="#252525"/><path d="M23.21 17.389h-8.52v-10.86h8.52v10.86z" fill="#FF5F00"/><path d="M15.237 11.959a6.902 6.902 0 0 1 2.632-5.43 6.903 6.903 0 1 0 0 10.86 6.902 6.902 0 0 1-2.632-5.43z" fill="#EB001B"/><path d="M29.042 11.959a6.904 6.904 0 0 1-11.173 5.43 6.902 6.902 0 0 0 0-10.86 6.904 6.904 0 0 1 11.173 5.43z" fill="#F79E1B"/></svg>
                            <svg class="h-8 w-auto opacity-60 hover:opacity-100 transition-opacity" viewBox="0 0 38 24" fill="none"><rect width="38" height="24" rx="3" fill="#0E4C96"/></svg>
                            <svg class="h-8 w-auto opacity-60 hover:opacity-100 transition-opacity" viewBox="0 0 38 24" fill="none"><rect width="38" height="24" rx="3" fill="#00579F"/></svg>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <?php if ($show_back_to_top): ?>
        <button
            x-data="{show: false}"
            @scroll.window="show = window.pageYOffset > 300"
            x-show="show"
            @click="window.scrollTo({top: 0, behavior: 'smooth'})"
            class="fixed <?php echo is_rtl() ? 'left-6' : 'right-6'; ?> bottom-6 p-4 rounded-full shadow-xl transition-all duration-300 hover:scale-110"
            style="background: linear-gradient(135deg, <?php echo esc_attr($link_hover_color); ?>, <?php echo esc_attr($link_hover_color); ?>dd); color: white;"
            aria-label="Back to top"
            x-cloak
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
            </svg>
        </button>
    <?php endif; ?>
</footer>
