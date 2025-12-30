<?php
/**
 * Footer Template: Awards
 * Footer showcasing awards, certificates, and achievements
 */

defined('ABSPATH') || exit;

$settings = dst_get_footer_setting();
$bg_color = $settings['bg_color'] ?? '#ffffff';
$awards_bg = $settings['awards_bg'] ?? '#fafaf9';
$text_color = $settings['text_color'] ?? '#57534e';
$heading_color = $settings['heading_color'] ?? '#1c1917';
$accent_color = $settings['accent_color'] ?? '#f59e0b';
$badge_bg = $settings['badge_bg'] ?? '#fffbeb';
$show_awards = $settings['show_awards'] ?? true;
$awards_title = $settings['awards_title'] ?? 'Awards & Recognition';
$awards_subtitle = $settings['awards_subtitle'] ?? 'Recognized for excellence and innovation';
$awards_layout = $settings['awards_layout'] ?? 'grid';
$awards_count = $settings['awards_count'] ?? '6';
$awards_per_row = $settings['awards_per_row'] ?? '3';
$show_award_names = $settings['show_award_names'] ?? true;
$show_award_icons = $settings['show_award_icons'] ?? true;
$awards_animate = $settings['awards_animate'] ?? true;
$show_logo = $settings['show_logo'] ?? true;
$show_social = $settings['show_social'] ?? true;
$show_contact = $settings['show_contact'] ?? true;
$columns = $settings['columns'] ?? '4';
$show_copyright = $settings['show_copyright'] ?? true;
$copyright_text = $settings['copyright_text'] ?? 'All rights reserved.';

$contact = dst_get_contact();
$socials = dst_get_socials();
?>

<footer class="hf-footer hf-footer-awards" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;">

    <!-- Awards Section -->
    <?php if ($show_awards): ?>
        <div class="hf-awards-section py-16 lg:py-20" style="background-color: <?php echo esc_attr($awards_bg); ?>;">
            <div class="hf-container max-w-7xl mx-auto px-4">

                <!-- Section Header -->
                <div class="text-center mb-12">
                    <h2 class="text-3xl lg:text-4xl font-bold mb-4" style="color: <?php echo esc_attr($heading_color); ?>;">
                        <?php echo esc_html($awards_title); ?>
                    </h2>
                    <?php if ($awards_subtitle): ?>
                        <p class="text-lg max-w-2xl mx-auto" style="color: <?php echo esc_attr($text_color); ?>;">
                            <?php echo esc_html($awards_subtitle); ?>
                        </p>
                    <?php endif; ?>
                </div>

                <?php
                // Sample awards data
                $awards = [
                    ['name' => 'Best Innovation', 'year' => '2024', 'organization' => 'Tech Awards'],
                    ['name' => 'Excellence in Design', 'year' => '2024', 'organization' => 'Design Institute'],
                    ['name' => 'Top Service Provider', 'year' => '2023', 'organization' => 'Industry Leaders'],
                    ['name' => 'Customer Choice', 'year' => '2023', 'organization' => 'Consumer Reports'],
                    ['name' => 'Quality Excellence', 'year' => '2022', 'organization' => 'Quality Association'],
                    ['name' => 'Innovation Leader', 'year' => '2022', 'organization' => 'Business Council'],
                    ['name' => 'Best Workplace', 'year' => '2021', 'organization' => 'HR Excellence'],
                    ['name' => 'Sustainability Award', 'year' => '2021', 'organization' => 'Green Initiative']
                ];

                $display_count = min((int)$awards_count, count($awards));
                $awards = array_slice($awards, 0, $display_count);
                ?>

                <!-- Awards Display -->
                <div class="<?php echo $awards_layout === 'row' ? 'flex flex-wrap justify-center' : 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-' . esc_attr($awards_per_row); ?> gap-6 lg:gap-8">
                    <?php foreach ($awards as $index => $award): ?>
                        <div class="hf-award-item flex flex-col items-center text-center p-6 rounded-xl <?php echo $awards_animate ? 'hover:scale-105' : ''; ?> transition-all duration-300" style="background-color: <?php echo esc_attr($badge_bg); ?>;">

                            <?php if ($show_award_icons): ?>
                                <!-- Award Icon/Badge -->
                                <div class="mb-4">
                                    <svg class="w-16 h-16 lg:w-20 lg:h-20" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <!-- Award Badge -->
                                        <circle cx="50" cy="40" r="25" fill="<?php echo esc_attr($accent_color); ?>" opacity="0.2"/>
                                        <circle cx="50" cy="40" r="25" fill="none" stroke="<?php echo esc_attr($accent_color); ?>" stroke-width="2"/>
                                        <!-- Star -->
                                        <path d="M50 25 L54 35 L65 36 L57 44 L59 55 L50 50 L41 55 L43 44 L35 36 L46 35 Z" fill="<?php echo esc_attr($accent_color); ?>"/>
                                        <!-- Ribbon -->
                                        <path d="M40 55 L45 80 L50 75 L55 80 L60 55" fill="<?php echo esc_attr($accent_color); ?>" opacity="0.6"/>
                                    </svg>
                                </div>
                            <?php endif; ?>

                            <?php if ($show_award_names): ?>
                                <h3 class="text-lg font-bold mb-2" style="color: <?php echo esc_attr($heading_color); ?>;">
                                    <?php echo esc_html($award['name']); ?>
                                </h3>
                                <div class="text-sm font-semibold mb-1" style="color: <?php echo esc_attr($accent_color); ?>;">
                                    <?php echo esc_html($award['year']); ?>
                                </div>
                                <div class="text-sm">
                                    <?php echo esc_html($award['organization']); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Stats Section -->
                <div class="mt-16 pt-12 border-t" style="border-color: <?php echo esc_attr($text_color); ?>33;">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                        <div>
                            <div class="text-4xl font-bold mb-2" style="color: <?php echo esc_attr($accent_color); ?>;">25+</div>
                            <div class="text-sm">Awards Won</div>
                        </div>
                        <div>
                            <div class="text-4xl font-bold mb-2" style="color: <?php echo esc_attr($accent_color); ?>;">15+</div>
                            <div class="text-sm">Certifications</div>
                        </div>
                        <div>
                            <div class="text-4xl font-bold mb-2" style="color: <?php echo esc_attr($accent_color); ?>;">98%</div>
                            <div class="text-sm">Client Satisfaction</div>
                        </div>
                        <div>
                            <div class="text-4xl font-bold mb-2" style="color: <?php echo esc_attr($accent_color); ?>;">1000+</div>
                            <div class="text-sm">Happy Clients</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Footer Content -->
    <div class="hf-container max-w-7xl mx-auto px-4 py-12 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-<?php echo esc_attr($columns); ?> gap-8 lg:gap-12 mb-8">

            <!-- Column 1: About -->
            <div class="space-y-4">
                <?php if ($show_logo): ?>
                    <div class="mb-4">
                        <?php
                        $logo = dst_get_logo();
                        if ($logo): ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block">
                                <img src="<?php echo esc_url($logo); ?>" alt="<?php bloginfo('name'); ?>" class="h-10 w-auto">
                            </a>
                        <?php else: ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-xl font-bold" style="color: <?php echo esc_attr($heading_color); ?>;">
                                <?php bloginfo('name'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <p class="text-sm leading-relaxed">
                    <?php echo get_bloginfo('description'); ?>
                </p>
            </div>

            <!-- Column 2: Quick Links -->
            <div class="space-y-4">
                <h4 class="text-lg font-semibold" style="color: <?php echo esc_attr($heading_color); ?>;">Quick Links</h4>
                <?php
                wp_nav_menu([
                    'theme_location' => 'footer',
                    'container'      => false,
                    'menu_class'     => 'space-y-2 text-sm',
                    'fallback_cb'    => false,
                    'depth'          => 1,
                ]);
                ?>
            </div>

            <!-- Column 3: Services -->
            <div class="space-y-4">
                <h4 class="text-lg font-semibold" style="color: <?php echo esc_attr($heading_color); ?>;">Services</h4>
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

            <!-- Column 4: Contact -->
            <?php if ($show_contact): ?>
                <div class="space-y-4">
                    <h4 class="text-lg font-semibold" style="color: <?php echo esc_attr($heading_color); ?>;">Contact</h4>
                    <ul class="space-y-3 text-sm">
                        <?php if (!empty($contact['email'])): ?>
                            <li class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="<?php echo esc_attr($accent_color); ?>" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <a href="mailto:<?php echo esc_attr($contact['email']); ?>" class="hover:underline">
                                    <?php echo esc_html($contact['email']); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (!empty($contact['phone'])): ?>
                            <li class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="<?php echo esc_attr($accent_color); ?>" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <a href="tel:<?php echo esc_attr($contact['phone']); ?>" class="hover:underline">
                                    <?php echo esc_html($contact['phone']); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t pt-8" style="border-color: <?php echo esc_attr($text_color); ?>33;">
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

                <?php if ($show_social && !empty($socials)): ?>
                    <div class="flex gap-3">
                        <?php foreach ($socials as $network => $url):
                            if (!empty($url)): ?>
                                <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="hover:opacity-70 transition-opacity" style="color: <?php echo esc_attr($accent_color); ?>;" aria-label="<?php echo esc_attr(ucfirst($network)); ?>">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10"/>
                                    </svg>
                                </a>
                            <?php endif;
                        endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</footer>
