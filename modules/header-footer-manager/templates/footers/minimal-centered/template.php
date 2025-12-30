<?php
/**
 * Footer Template: Minimal Centered
 * Ultra minimal centered footer with logo, social, and copyright
 */

defined('ABSPATH') || exit;

$settings = dst_get_footer_setting();
$bg_color = $settings['bg_color'] ?? '#ffffff';
$text_color = $settings['text_color'] ?? '#6b7280';
$heading_color = $settings['heading_color'] ?? '#111827';
$accent_color = $settings['accent_color'] ?? '#3b82f6';
$border_color = $settings['border_color'] ?? '#e5e7eb';
$layout = $settings['layout'] ?? 'stacked';
$show_logo = $settings['show_logo'] ?? true;
$show_tagline = $settings['show_tagline'] ?? true;
$custom_tagline = $settings['custom_tagline'] ?? '';
$show_menu = $settings['show_menu'] ?? true;
$show_social = $settings['show_social'] ?? true;
$social_style = $settings['social_style'] ?? 'simple';
$show_copyright = $settings['show_copyright'] ?? true;
$copyright_text = $settings['copyright_text'] ?? '';
$spacing = $settings['spacing'] ?? 'medium';
$show_divider = $settings['show_divider'] ?? true;
$divider_style = $settings['divider_style'] ?? 'simple';
$text_size = $settings['text_size'] ?? 'normal';

$spacing_map = [
    'compact' => 'py-8',
    'medium' => 'py-12',
    'relaxed' => 'py-16 lg:py-20'
];

$text_size_map = [
    'small' => 'text-xs',
    'normal' => 'text-sm',
    'large' => 'text-base'
];

$tagline = $custom_tagline ?: get_bloginfo('description');
?>

<footer class="hf-footer hf-footer-minimal-centered" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;">
    <style>
        .hf-footer-minimal-centered a {
            color: <?php echo esc_attr($text_color); ?>;
            transition: color 0.3s ease;
        }
        .hf-footer-minimal-centered a:hover {
            color: <?php echo esc_attr($accent_color); ?>;
        }
        <?php if ($divider_style === 'gradient'): ?>
        .hf-divider-gradient {
            height: 1px;
            background: linear-gradient(90deg, transparent, <?php echo esc_attr($border_color); ?>, transparent);
        }
        <?php elseif ($divider_style === 'dots'): ?>
        .hf-divider-dots {
            background-image: radial-gradient(circle, <?php echo esc_attr($border_color); ?> 1px, transparent 1px);
            background-size: 8px 8px;
            height: 1px;
        }
        <?php endif; ?>
        <?php if ($social_style === 'rounded'): ?>
        .hf-social-icon {
            background-color: <?php echo esc_attr($accent_color); ?>10;
            border-radius: 0.5rem;
            padding: 0.5rem;
            transition: background-color 0.3s ease;
        }
        .hf-social-icon:hover {
            background-color: <?php echo esc_attr($accent_color); ?>20;
        }
        <?php elseif ($social_style === 'outlined'): ?>
        .hf-social-icon {
            border: 1px solid <?php echo esc_attr($border_color); ?>;
            border-radius: 50%;
            padding: 0.5rem;
            transition: all 0.3s ease;
        }
        .hf-social-icon:hover {
            border-color: <?php echo esc_attr($accent_color); ?>;
            background-color: <?php echo esc_attr($accent_color); ?>10;
        }
        <?php endif; ?>
    </style>

    <!-- Top Divider -->
    <?php if ($show_divider): ?>
        <div class="hf-container">
            <?php if ($divider_style === 'simple'): ?>
                <div class="border-t" style="border-color: <?php echo esc_attr($border_color); ?>;"></div>
            <?php elseif ($divider_style === 'gradient'): ?>
                <div class="hf-divider-gradient"></div>
            <?php else: ?>
                <div class="hf-divider-dots"></div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Footer Content -->
    <div class="<?php echo esc_attr($spacing_map[$spacing]); ?>">
        <div class="hf-container">

            <?php if ($layout === 'stacked'): ?>
                <!-- Stacked Layout -->
                <div class="flex flex-col items-center gap-6">

                    <!-- Logo -->
                    <?php if ($show_logo): ?>
                        <div class="text-center">
                            <?php
                            $logo = dst_get_logo();
                            if ($logo): ?>
                                <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block">
                                    <img src="<?php echo esc_url($logo); ?>" alt="<?php bloginfo('name'); ?>" class="h-10 lg:h-12 w-auto">
                                </a>
                            <?php else: ?>
                                <a href="<?php echo esc_url(home_url('/')); ?>" class="text-xl lg:text-2xl font-bold" style="color: <?php echo esc_attr($heading_color); ?>;">
                                    <?php bloginfo('name'); ?>
                                </a>
                            <?php endif; ?>

                            <?php if ($show_tagline && $tagline): ?>
                                <p class="mt-2 <?php echo esc_attr($text_size_map[$text_size]); ?>">
                                    <?php echo esc_html($tagline); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Menu -->
                    <?php if ($show_menu): ?>
                        <div class="text-center">
                            <?php
                            wp_nav_menu([
                                'theme_location' => 'footer',
                                'container'      => false,
                                'menu_class'     => 'flex flex-wrap items-center justify-center gap-6 ' . $text_size_map[$text_size],
                                'fallback_cb'    => false,
                                'depth'          => 1,
                            ]);
                            ?>
                        </div>
                    <?php endif; ?>

                    <!-- Social Icons -->
                    <?php if ($show_social): ?>
                        <div class="flex gap-4">
                            <?php
                            $socials = dst_get_socials();
                            $social_icons = [
                                'instagram' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>',
                                'twitter' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>',
                                'facebook' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
                                'linkedin' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
                                'github' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>',
                                'youtube' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>'
                            ];

                            foreach ($socials as $network => $url):
                                if (!empty($url) && isset($social_icons[$network])): ?>
                                    <a href="<?php echo esc_url($url); ?>"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="hf-social-icon"
                                       aria-label="<?php echo esc_attr(ucfirst($network)); ?>">
                                        <?php echo $social_icons[$network]; ?>
                                    </a>
                                <?php endif;
                            endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Copyright -->
                    <?php if ($show_copyright): ?>
                        <div class="text-center <?php echo esc_attr($text_size_map[$text_size]); ?>">
                            &copy; <?php echo date('Y'); ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:underline">
                                <?php bloginfo('name'); ?>
                            </a>
                            <?php if ($copyright_text): ?>
                                - <?php echo esc_html($copyright_text); ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                </div>

            <?php else: ?>
                <!-- Single Line Layout -->
                <div class="flex flex-col lg:flex-row items-center justify-between gap-6">

                    <!-- Logo -->
                    <?php if ($show_logo): ?>
                        <div class="flex items-center gap-4">
                            <?php
                            $logo = dst_get_logo();
                            if ($logo): ?>
                                <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block">
                                    <img src="<?php echo esc_url($logo); ?>" alt="<?php bloginfo('name'); ?>" class="h-8 w-auto">
                                </a>
                            <?php else: ?>
                                <a href="<?php echo esc_url(home_url('/')); ?>" class="text-lg font-bold" style="color: <?php echo esc_attr($heading_color); ?>;">
                                    <?php bloginfo('name'); ?>
                                </a>
                            <?php endif; ?>

                            <?php if ($show_tagline && $tagline): ?>
                                <span class="hidden md:inline text-sm" style="color: <?php echo esc_attr($text_color); ?>;">
                                    <?php echo esc_html($tagline); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Menu -->
                    <?php if ($show_menu): ?>
                        <div class="hidden lg:block">
                            <?php
                            wp_nav_menu([
                                'theme_location' => 'footer',
                                'container'      => false,
                                'menu_class'     => 'flex items-center gap-6 ' . $text_size_map[$text_size],
                                'fallback_cb'    => false,
                                'depth'          => 1,
                            ]);
                            ?>
                        </div>
                    <?php endif; ?>

                    <!-- Right Side (Social + Copyright) -->
                    <div class="flex flex-col md:flex-row items-center gap-6">

                        <!-- Social Icons -->
                        <?php if ($show_social): ?>
                            <div class="flex gap-3">
                                <?php
                                $socials = dst_get_socials();
                                foreach ($socials as $network => $url):
                                    if (!empty($url) && isset($social_icons[$network])): ?>
                                        <a href="<?php echo esc_url($url); ?>"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="hf-social-icon"
                                           aria-label="<?php echo esc_attr(ucfirst($network)); ?>">
                                            <?php echo $social_icons[$network]; ?>
                                        </a>
                                    <?php endif;
                                endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Copyright -->
                        <?php if ($show_copyright): ?>
                            <div class="<?php echo esc_attr($text_size_map[$text_size]); ?>">
                                &copy; <?php echo date('Y'); ?>
                                <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:underline">
                                    <?php bloginfo('name'); ?>
                                </a>
                                <?php if ($copyright_text): ?>
                                    <span class="hidden md:inline">- <?php echo esc_html($copyright_text); ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                    </div>

                </div>
            <?php endif; ?>

        </div>
    </div>
</footer>
