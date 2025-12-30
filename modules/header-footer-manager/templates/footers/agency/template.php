<?php
/**
 * Footer Template: Creative Agency
 * Creative agency footer with portfolio categories, services, awards, and large CTA section
 */

defined('ABSPATH') || exit;

$settings = dst_get_footer_setting();
$bg_color = $settings['bg_color'] ?? '#18181b';
$text_color = $settings['text_color'] ?? '#a1a1aa';
$link_color = $settings['link_color'] ?? '#fafafa';
$link_hover_color = $settings['link_hover_color'] ?? '#a855f7';
$show_logo = $settings['show_logo'] ?? true;
$show_description = $settings['show_description'] ?? true;
$description_text = $settings['description_text'] ?? 'We craft award-winning digital experiences that push boundaries and drive results.';
$show_social = $settings['show_social'] ?? true;
$show_newsletter = $settings['show_newsletter'] ?? true;
$newsletter_title = $settings['newsletter_title'] ?? "Let's Create Together";
$newsletter_text = $settings['newsletter_text'] ?? "Have a project in mind? Drop us a line and let's build something amazing.";
$show_contact = $settings['show_contact'] ?? true;
$columns = $settings['columns'] ?? '4';
$show_menu1 = $settings['show_menu1'] ?? true;
$menu1_title = $settings['menu1_title'] ?? 'Services';
$show_menu2 = $settings['show_menu2'] ?? true;
$menu2_title = $settings['menu2_title'] ?? 'Portfolio';
$show_copyright = $settings['show_copyright'] ?? true;
$copyright_text = $settings['copyright_text'] ?? 'All rights reserved.';
$show_payment_icons = $settings['show_payment_icons'] ?? false;
$show_back_to_top = $settings['show_back_to_top'] ?? true;

$contact = dst_get_contact();
?>

<footer class="hf-footer hf-footer-agency" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;">
    <style>
        .hf-footer-agency a {
            color: <?php echo esc_attr($link_color); ?>;
        }
        .hf-footer-agency a:hover {
            color: <?php echo esc_attr($link_hover_color); ?>;
        }
    </style>

    <!-- CTA Section -->
    <?php if ($show_newsletter): ?>
        <div class="border-b border-white/10">
            <div class="hf-container py-20 lg:py-24">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                    <div class="space-y-6">
                        <div class="inline-block px-4 py-2 rounded-full text-xs font-semibold tracking-wide uppercase" style="background-color: <?php echo esc_attr($link_hover_color); ?>20; color: <?php echo esc_attr($link_hover_color); ?>;">
                            Let's Work Together
                        </div>
                        <h2 class="text-4xl lg:text-5xl font-bold leading-tight" style="color: <?php echo esc_attr($link_color); ?>;">
                            <?php echo esc_html($newsletter_title); ?>
                        </h2>
                        <p class="text-lg leading-relaxed">
                            <?php echo esc_html($newsletter_text); ?>
                        </p>

                        <?php if ($show_contact && !empty($contact)): ?>
                            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                                <?php if (!empty($contact['email'])): ?>
                                    <a href="mailto:<?php echo esc_attr($contact['email']); ?>" class="inline-flex items-center gap-2 text-lg font-medium group">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        <?php echo esc_html($contact['email']); ?>
                                    </a>
                                <?php endif; ?>

                                <?php if (!empty($contact['phone'])): ?>
                                    <a href="tel:<?php echo esc_attr($contact['phone']); ?>" class="inline-flex items-center gap-2 text-lg font-medium group">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        <?php echo esc_html($contact['phone']); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="space-y-4">
                        <form class="space-y-4" onsubmit="return false;">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <input
                                    type="text"
                                    placeholder="Your Name"
                                    class="px-5 py-4 rounded-lg bg-white/5 border border-white/10 focus:outline-none focus:border-white/30 placeholder:text-white/40"
                                    style="color: <?php echo esc_attr($link_color); ?>;"
                                >
                                <input
                                    type="email"
                                    placeholder="Your Email"
                                    class="px-5 py-4 rounded-lg bg-white/5 border border-white/10 focus:outline-none focus:border-white/30 placeholder:text-white/40"
                                    style="color: <?php echo esc_attr($link_color); ?>;"
                                >
                            </div>
                            <textarea
                                placeholder="Tell us about your project..."
                                rows="4"
                                class="w-full px-5 py-4 rounded-lg bg-white/5 border border-white/10 focus:outline-none focus:border-white/30 placeholder:text-white/40 resize-none"
                                style="color: <?php echo esc_attr($link_color); ?>;"
                            ></textarea>
                            <button
                                type="submit"
                                class="w-full px-8 py-4 text-base font-bold rounded-lg transition-all duration-300 hover:scale-105 hover:shadow-2xl"
                                style="background-color: <?php echo esc_attr($link_hover_color); ?>; color: white;"
                            >
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Footer -->
    <div class="hf-container py-12 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-<?php echo esc_attr($columns); ?> gap-8 lg:gap-12">

            <!-- Column 1: About Agency -->
            <div class="lg:col-span-<?php echo $columns >= 4 ? '2' : '1'; ?> space-y-6">
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
                    <p class="text-base leading-relaxed max-w-md">
                        <?php echo esc_html($description_text ?: get_bloginfo('description')); ?>
                    </p>
                <?php endif; ?>

                <!-- Awards / Stats -->
                <div class="grid grid-cols-3 gap-6 pt-4 max-w-md">
                    <div>
                        <div class="text-3xl font-bold" style="color: <?php echo esc_attr($link_hover_color); ?>;">50+</div>
                        <div class="text-sm mt-1">Awards</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold" style="color: <?php echo esc_attr($link_hover_color); ?>;">200+</div>
                        <div class="text-sm mt-1">Projects</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold" style="color: <?php echo esc_attr($link_hover_color); ?>;">100+</div>
                        <div class="text-sm mt-1">Clients</div>
                    </div>
                </div>

                <?php if ($show_social): ?>
                    <div class="flex gap-3 pt-4">
                        <?php
                        $socials = dst_get_socials();
                        $social_icons = [
                            'instagram' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>',
                            'twitter' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>',
                            'linkedin' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
                            'facebook' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
                            'github' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>'
                        ];

                        foreach ($socials as $network => $url):
                            if (!empty($url) && isset($social_icons[$network])): ?>
                                <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="hover:opacity-80 transition-opacity" aria-label="<?php echo esc_attr(ucfirst($network)); ?>">
                                    <?php echo $social_icons[$network]; ?>
                                </a>
                            <?php endif;
                        endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Column 2: Services -->
            <?php if ($show_menu1): ?>
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold" style="color: <?php echo esc_attr($link_color); ?>;">
                        <?php echo esc_html($menu1_title); ?>
                    </h3>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer-menu-1',
                        'container'      => false,
                        'menu_class'     => 'space-y-2 text-sm',
                        'fallback_cb'    => false,
                        'depth'          => 1,
                    ]);
                    ?>
                </div>
            <?php endif; ?>

            <!-- Column 3: Portfolio -->
            <?php if ($show_menu2): ?>
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold" style="color: <?php echo esc_attr($link_color); ?>;">
                        <?php echo esc_html($menu2_title); ?>
                    </h3>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer-menu-2',
                        'container'      => false,
                        'menu_class'     => 'space-y-2 text-sm',
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
        <div class="hf-container py-6">
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

                <div class="flex items-center gap-6 text-sm">
                    <a href="#" class="hover:underline">Privacy Policy</a>
                    <a href="#" class="hover:underline">Terms of Service</a>
                </div>

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
            class="fixed <?php echo is_rtl() ? 'left-4' : 'right-4'; ?> bottom-4 p-3 rounded-full shadow-lg transition-all duration-300 hover:scale-110"
            style="background-color: <?php echo esc_attr($link_hover_color); ?>; color: white;"
            aria-label="Back to top"
            x-cloak
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
            </svg>
        </button>
    <?php endif; ?>
</footer>
