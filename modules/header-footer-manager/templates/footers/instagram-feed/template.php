<?php
/**
 * Footer Template: Instagram Feed
 * Footer with Instagram feed grid and follow CTA
 */

defined('ABSPATH') || exit;

$settings = dst_get_footer_setting();
$bg_color = $settings['bg_color'] ?? '#fafafa';
$text_color = $settings['text_color'] ?? '#262626';
$heading_color = $settings['heading_color'] ?? '#000000';
$accent_color = $settings['accent_color'] ?? '#e4405f';
$border_color = $settings['border_color'] ?? '#dbdbdb';
$instagram_handle = $settings['instagram_handle'] ?? '@yourcompany';
$instagram_url = $settings['instagram_url'] ?? 'https://instagram.com/yourcompany';
$images_count = $settings['images_count'] ?? 8;
$grid_columns = $settings['grid_columns'] ?? '4';
$show_follow_button = $settings['show_follow_button'] ?? true;
$follow_button_text = $settings['follow_button_text'] ?? 'Follow Us on Instagram';
$section_heading = $settings['section_heading'] ?? 'Follow Our Journey';
$section_description = $settings['section_description'] ?? 'Stay updated with our latest products, behind-the-scenes, and inspiration on Instagram.';
$show_logo = $settings['show_logo'] ?? true;
$show_menu = $settings['show_menu'] ?? true;
$show_social = $settings['show_social'] ?? true;
$show_copyright = $settings['show_copyright'] ?? true;
$copyright_text = $settings['copyright_text'] ?? 'All rights reserved.';
$image_border_radius = $settings['image_border_radius'] ?? 'small';
$hover_effect = $settings['hover_effect'] ?? 'zoom';

$radius_map = [
    'none' => '0',
    'small' => '0.375rem',
    'medium' => '0.75rem',
    'large' => '1.5rem'
];

// Placeholder Instagram images (in real implementation, these would come from Instagram API)
$instagram_images = array_slice([
    'https://via.placeholder.com/400x400/e4405f/ffffff?text=Post+1',
    'https://via.placeholder.com/400x400/833ab4/ffffff?text=Post+2',
    'https://via.placeholder.com/400x400/fd1d1d/ffffff?text=Post+3',
    'https://via.placeholder.com/400x400/f56040/ffffff?text=Post+4',
    'https://via.placeholder.com/400x400/fcaf45/ffffff?text=Post+5',
    'https://via.placeholder.com/400x400/833ab4/ffffff?text=Post+6',
    'https://via.placeholder.com/400x400/e4405f/ffffff?text=Post+7',
    'https://via.placeholder.com/400x400/fd1d1d/ffffff?text=Post+8',
    'https://via.placeholder.com/400x400/f56040/ffffff?text=Post+9',
    'https://via.placeholder.com/400x400/fcaf45/ffffff?text=Post+10',
    'https://via.placeholder.com/400x400/833ab4/ffffff?text=Post+11',
    'https://via.placeholder.com/400x400/e4405f/ffffff?text=Post+12'
], 0, $images_count);
?>

<footer class="hf-footer hf-footer-instagram" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;">
    <style>
        .hf-footer-instagram a {
            color: <?php echo esc_attr($accent_color); ?>;
            transition: opacity 0.3s ease;
        }
        .hf-footer-instagram a:hover {
            opacity: 0.8;
        }
        .hf-instagram-image {
            position: relative;
            overflow: hidden;
            aspect-ratio: 1;
            border-radius: <?php echo esc_attr($radius_map[$image_border_radius]); ?>;
        }
        .hf-instagram-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        <?php if ($hover_effect === 'zoom'): ?>
        .hf-instagram-image:hover img {
            transform: scale(1.1);
        }
        <?php elseif ($hover_effect === 'fade'): ?>
        .hf-instagram-image::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(45deg, <?php echo esc_attr($accent_color); ?>dd, transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .hf-instagram-image:hover::after {
            opacity: 1;
        }
        <?php elseif ($hover_effect === 'lift'): ?>
        .hf-instagram-image {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hf-instagram-image:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        <?php endif; ?>
    </style>

    <!-- Instagram Feed Section -->
    <div class="py-16 lg:py-20">
        <div class="hf-container">

            <!-- Section Header -->
            <div class="text-center mb-12 max-w-2xl mx-auto">
                <div class="inline-flex items-center gap-2 mb-4">
                    <svg class="w-8 h-8" style="color: <?php echo esc_attr($accent_color); ?>;" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                    <span class="text-2xl font-bold" style="color: <?php echo esc_attr($heading_color); ?>;">
                        <?php echo esc_html($instagram_handle); ?>
                    </span>
                </div>

                <h2 class="text-3xl lg:text-4xl font-bold mb-4" style="color: <?php echo esc_attr($heading_color); ?>;">
                    <?php echo esc_html($section_heading); ?>
                </h2>

                <p class="text-lg mb-6">
                    <?php echo esc_html($section_description); ?>
                </p>

                <?php if ($show_follow_button): ?>
                    <a href="<?php echo esc_url($instagram_url); ?>"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 px-8 py-4 text-base font-bold rounded-lg transition-all duration-300 hover:scale-105"
                       style="background-color: <?php echo esc_attr($accent_color); ?>; color: white;">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                        <?php echo esc_html($follow_button_text); ?>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Instagram Grid -->
            <div class="grid grid-cols-2 md:grid-cols-<?php echo esc_attr($grid_columns); ?> gap-4">
                <?php foreach ($instagram_images as $image): ?>
                    <a href="<?php echo esc_url($instagram_url); ?>"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="hf-instagram-image block">
                        <img src="<?php echo esc_url($image); ?>" alt="Instagram post" loading="lazy">
                    </a>
                <?php endforeach; ?>
            </div>

        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="py-8 border-t" style="border-color: <?php echo esc_attr($border_color); ?>;">
        <div class="hf-container">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-6">

                <!-- Logo and Menu -->
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <?php if ($show_logo): ?>
                        <?php
                        $logo = dst_get_logo();
                        if ($logo): ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block flex-shrink-0">
                                <img src="<?php echo esc_url($logo); ?>" alt="<?php bloginfo('name'); ?>" class="h-10 w-auto">
                            </a>
                        <?php else: ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-xl font-bold flex-shrink-0" style="color: <?php echo esc_attr($heading_color); ?>;">
                                <?php bloginfo('name'); ?>
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($show_menu): ?>
                        <div class="hidden md:block">
                            <?php
                            wp_nav_menu([
                                'theme_location' => 'footer',
                                'container'      => false,
                                'menu_class'     => 'flex flex-wrap items-center gap-6 text-sm',
                                'fallback_cb'    => false,
                                'depth'          => 1,
                            ]);
                            ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Copyright and Social -->
                <div class="flex flex-col md:flex-row items-center gap-6">
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

                    <?php if ($show_social): ?>
                        <div class="flex gap-4">
                            <?php
                            $socials = dst_get_socials();
                            $social_icons = [
                                'facebook' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
                                'twitter' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>',
                                'linkedin' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
                                'youtube' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>'
                            ];

                            foreach ($socials as $network => $url):
                                if (!empty($url) && isset($social_icons[$network])): ?>
                                    <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="hover:opacity-70 transition-opacity" aria-label="<?php echo esc_attr(ucfirst($network)); ?>">
                                        <?php echo $social_icons[$network]; ?>
                                    </a>
                                <?php endif;
                            endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</footer>
