<?php
/**
 * Footer Template: Statistics
 * Footer with company statistics and animated counters
 */

defined('ABSPATH') || exit;

$settings = dst_get_footer_setting();
$bg_color = $settings['bg_color'] ?? '#0f172a';
$text_color = $settings['text_color'] ?? '#cbd5e1';
$heading_color = $settings['heading_color'] ?? '#f1f5f9';
$accent_color = $settings['accent_color'] ?? '#06b6d4';
$stat_number_color = $settings['stat_number_color'] ?? '#06b6d4';
$stat1_number = $settings['stat1_number'] ?? '500+';
$stat1_label = $settings['stat1_label'] ?? 'Happy Clients';
$stat2_number = $settings['stat2_number'] ?? '1000+';
$stat2_label = $settings['stat2_label'] ?? 'Projects Completed';
$stat3_number = $settings['stat3_number'] ?? '15+';
$stat3_label = $settings['stat3_label'] ?? 'Years Experience';
$stat4_number = $settings['stat4_number'] ?? '50+';
$stat4_label = $settings['stat4_label'] ?? 'Team Members';
$enable_animation = $settings['enable_animation'] ?? true;
$stats_heading = $settings['stats_heading'] ?? 'Our Impact in Numbers';
$stats_description = $settings['stats_description'] ?? 'Trusted by businesses worldwide to deliver exceptional results and innovative solutions.';
$show_logo = $settings['show_logo'] ?? true;
$show_menu = $settings['show_menu'] ?? true;
$show_social = $settings['show_social'] ?? true;
$show_copyright = $settings['show_copyright'] ?? true;
$copyright_text = $settings['copyright_text'] ?? 'All rights reserved.';
$divider_style = $settings['divider_style'] ?? 'gradient';

$stats = [
    ['number' => $stat1_number, 'label' => $stat1_label],
    ['number' => $stat2_number, 'label' => $stat2_label],
    ['number' => $stat3_number, 'label' => $stat3_label],
    ['number' => $stat4_number, 'label' => $stat4_label],
];
?>

<footer class="hf-footer hf-footer-stats" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;">
    <style>
        .hf-footer-stats a {
            color: <?php echo esc_attr($accent_color); ?>;
            transition: opacity 0.3s ease;
        }
        .hf-footer-stats a:hover {
            opacity: 0.8;
        }
        .hf-stat-number {
            color: <?php echo esc_attr($stat_number_color); ?>;
            font-size: 3rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 0.5rem;
        }
        @media (min-width: 1024px) {
            .hf-stat-number {
                font-size: 4rem;
            }
        }
        .hf-stat-label {
            color: <?php echo esc_attr($text_color); ?>;
            font-size: 1rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        <?php if ($enable_animation): ?>
        .hf-stat-item {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .hf-stat-item.visible {
            opacity: 1;
            transform: translateY(0);
        }
        <?php endif; ?>
        .hf-stats-divider {
            height: 2px;
            background: <?php echo esc_attr($accent_color); ?>;
            <?php if ($divider_style === 'gradient'): ?>
            background: linear-gradient(90deg, transparent, <?php echo esc_attr($accent_color); ?>, transparent);
            <?php elseif ($divider_style === 'dotted'): ?>
            background: repeating-linear-gradient(90deg, <?php echo esc_attr($accent_color); ?> 0, <?php echo esc_attr($accent_color); ?> 10px, transparent 10px, transparent 20px);
            <?php endif; ?>
        }
    </style>

    <!-- Statistics Section -->
    <div class="py-16 lg:py-20">
        <div class="hf-container">

            <!-- Section Header -->
            <div class="text-center mb-12 lg:mb-16 max-w-3xl mx-auto">
                <h2 class="text-3xl lg:text-5xl font-bold mb-4" style="color: <?php echo esc_attr($heading_color); ?>;">
                    <?php echo esc_html($stats_heading); ?>
                </h2>
                <p class="text-lg lg:text-xl">
                    <?php echo esc_html($stats_description); ?>
                </p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
                <?php foreach ($stats as $index => $stat): ?>
                    <div class="hf-stat-item text-center"
                         <?php if ($enable_animation): ?>
                         data-stat-index="<?php echo $index; ?>"
                         <?php endif; ?>
                         style="<?php echo $enable_animation ? '' : 'opacity: 1;'; ?>">
                        <div class="hf-stat-number">
                            <?php echo esc_html($stat['number']); ?>
                        </div>
                        <div class="hf-stat-label">
                            <?php echo esc_html($stat['label']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Decorative Elements -->
            <div class="mt-12 lg:mt-16 flex items-center justify-center gap-4">
                <div class="w-16 h-16 rounded-full border-2 opacity-20" style="border-color: <?php echo esc_attr($accent_color); ?>;"></div>
                <div class="w-12 h-12 rounded-full border-2 opacity-30" style="border-color: <?php echo esc_attr($accent_color); ?>;"></div>
                <div class="w-8 h-8 rounded-full border-2 opacity-40" style="border-color: <?php echo esc_attr($accent_color); ?>;"></div>
                <div class="w-20 h-1" style="background: linear-gradient(90deg, transparent, <?php echo esc_attr($accent_color); ?>);"></div>
                <div class="w-8 h-8 rounded-full border-2 opacity-40" style="border-color: <?php echo esc_attr($accent_color); ?>;"></div>
                <div class="w-12 h-12 rounded-full border-2 opacity-30" style="border-color: <?php echo esc_attr($accent_color); ?>;"></div>
                <div class="w-16 h-16 rounded-full border-2 opacity-20" style="border-color: <?php echo esc_attr($accent_color); ?>;"></div>
            </div>

        </div>
    </div>

    <!-- Divider -->
    <?php if ($divider_style !== 'none'): ?>
        <div class="<?php echo $divider_style === 'simple' ? 'border-t' : 'hf-stats-divider'; ?>"
             style="<?php echo $divider_style === 'simple' ? 'border-color: ' . esc_attr($accent_color) . '40;' : ''; ?>">
        </div>
    <?php endif; ?>

    <!-- Footer Info -->
    <div class="py-8 lg:py-12">
        <div class="hf-container">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">

                <!-- Logo -->
                <?php if ($show_logo): ?>
                    <div class="text-center lg:text-<?php echo is_rtl() ? 'right' : 'left'; ?>">
                        <?php
                        $logo = dst_get_logo('light');
                        if ($logo): ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block">
                                <img src="<?php echo esc_url($logo); ?>" alt="<?php bloginfo('name'); ?>" class="h-12 w-auto">
                            </a>
                        <?php else: ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-2xl font-bold" style="color: <?php echo esc_attr($heading_color); ?>;">
                                <?php bloginfo('name'); ?>
                            </a>
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
                            'menu_class'     => 'flex flex-wrap items-center justify-center gap-6 text-sm',
                            'fallback_cb'    => false,
                            'depth'          => 1,
                        ]);
                        ?>
                    </div>
                <?php endif; ?>

                <!-- Social Icons -->
                <?php if ($show_social): ?>
                    <div class="flex gap-4 justify-center lg:justify-<?php echo is_rtl() ? 'start' : 'end'; ?>">
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
                                <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer"
                                   class="hover:opacity-70 transition-opacity p-2 rounded-full"
                                   style="background-color: <?php echo esc_attr($accent_color); ?>20;"
                                   aria-label="<?php echo esc_attr(ucfirst($network)); ?>">
                                    <?php echo $social_icons[$network]; ?>
                                </a>
                            <?php endif;
                        endforeach; ?>
                    </div>
                <?php endif; ?>

            </div>

            <!-- Copyright -->
            <?php if ($show_copyright): ?>
                <div class="mt-8 pt-8 border-t text-center text-sm" style="border-color: <?php echo esc_attr($accent_color); ?>20;">
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
    </div>

    <?php if ($enable_animation): ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const stats = document.querySelectorAll('.hf-stat-item');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, index * 150);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        stats.forEach(stat => observer.observe(stat));
    });
    </script>
    <?php endif; ?>
</footer>
