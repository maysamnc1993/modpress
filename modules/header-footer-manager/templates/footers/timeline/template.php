<?php
/**
 * Footer Template: Timeline
 * Footer with company timeline/history showing milestones and achievements
 */

defined('ABSPATH') || exit;

$settings = dst_get_footer_setting();
$bg_color = $settings['bg_color'] ?? '#ffffff';
$timeline_bg = $settings['timeline_bg'] ?? '#f9fafb';
$text_color = $settings['text_color'] ?? '#6b7280';
$heading_color = $settings['heading_color'] ?? '#111827';
$accent_color = $settings['accent_color'] ?? '#8b5cf6';
$timeline_line_color = $settings['timeline_line_color'] ?? '#d1d5db';
$show_timeline = $settings['show_timeline'] ?? true;
$timeline_title = $settings['timeline_title'] ?? 'Our Journey';
$timeline_subtitle = $settings['timeline_subtitle'] ?? 'Building excellence since day one';
$timeline_style = $settings['timeline_style'] ?? 'horizontal';
$milestones_count = $settings['milestones_count'] ?? '4';
$show_year = $settings['show_year'] ?? true;
$show_icons = $settings['show_icons'] ?? true;
$animate_timeline = $settings['animate_timeline'] ?? true;
$show_logo = $settings['show_logo'] ?? true;
$show_social = $settings['show_social'] ?? true;
$show_contact = $settings['show_contact'] ?? true;
$columns = $settings['columns'] ?? '3';
$show_copyright = $settings['show_copyright'] ?? true;
$copyright_text = $settings['copyright_text'] ?? 'All rights reserved.';

$contact = dst_get_contact();
$socials = dst_get_socials();
?>

<footer class="hf-footer hf-footer-timeline" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;">

    <!-- Timeline Section -->
    <?php if ($show_timeline): ?>
        <div class="hf-timeline-section py-16 lg:py-20" style="background-color: <?php echo esc_attr($timeline_bg); ?>;">
            <div class="hf-container max-w-7xl mx-auto px-4">

                <!-- Section Header -->
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold mb-4" style="color: <?php echo esc_attr($heading_color); ?>;">
                        <?php echo esc_html($timeline_title); ?>
                    </h2>
                    <?php if ($timeline_subtitle): ?>
                        <p class="text-lg max-w-2xl mx-auto" style="color: <?php echo esc_attr($text_color); ?>;">
                            <?php echo esc_html($timeline_subtitle); ?>
                        </p>
                    <?php endif; ?>
                </div>

                <?php
                // Sample milestones data
                $milestones = [
                    ['year' => '2018', 'title' => 'Company Founded', 'description' => 'Started our journey with a vision to transform the industry'],
                    ['year' => '2019', 'title' => 'First Major Client', 'description' => 'Partnered with industry leaders and expanded our team'],
                    ['year' => '2021', 'title' => 'Global Expansion', 'description' => 'Opened offices in 5 countries across 3 continents'],
                    ['year' => '2023', 'title' => 'Industry Recognition', 'description' => 'Awarded Best Innovation Company of the Year'],
                    ['year' => '2024', 'title' => 'Milestone Achievement', 'description' => 'Reached 1000+ satisfied clients worldwide'],
                    ['year' => '2025', 'title' => 'Future Forward', 'description' => 'Launching next-generation products and services']
                ];

                $display_count = min((int)$milestones_count, count($milestones));
                $milestones = array_slice($milestones, 0, $display_count);
                ?>

                <!-- Timeline Display -->
                <?php if ($timeline_style === 'horizontal'): ?>
                    <!-- Horizontal Timeline -->
                    <div class="relative">
                        <!-- Timeline Line -->
                        <div class="absolute top-1/2 left-0 right-0 h-1 -translate-y-1/2 hidden lg:block" style="background-color: <?php echo esc_attr($timeline_line_color); ?>;"></div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-<?php echo esc_attr($milestones_count); ?> gap-8">
                            <?php foreach ($milestones as $index => $milestone): ?>
                                <div class="relative" <?php echo $animate_timeline ? 'data-aos="fade-up" data-aos-delay="' . ($index * 100) . '"' : ''; ?>>
                                    <!-- Milestone Dot -->
                                    <div class="flex justify-center mb-6 lg:mb-0">
                                        <?php if ($show_icons): ?>
                                            <div class="w-16 h-16 rounded-full flex items-center justify-center text-white font-bold text-xl z-10 shadow-lg" style="background-color: <?php echo esc_attr($accent_color); ?>;">
                                                <?php echo substr($milestone['year'], -2); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Content -->
                                    <div class="text-center lg:mt-20 space-y-2">
                                        <?php if ($show_year): ?>
                                            <div class="text-2xl font-bold" style="color: <?php echo esc_attr($accent_color); ?>;">
                                                <?php echo esc_html($milestone['year']); ?>
                                            </div>
                                        <?php endif; ?>
                                        <h3 class="text-lg font-semibold" style="color: <?php echo esc_attr($heading_color); ?>;">
                                            <?php echo esc_html($milestone['title']); ?>
                                        </h3>
                                        <p class="text-sm leading-relaxed">
                                            <?php echo esc_html($milestone['description']); ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                <?php else: ?>
                    <!-- Vertical Timeline -->
                    <div class="max-w-3xl mx-auto">
                        <div class="relative">
                            <!-- Timeline Line -->
                            <div class="absolute left-8 top-0 bottom-0 w-1" style="background-color: <?php echo esc_attr($timeline_line_color); ?>;"></div>

                            <div class="space-y-12">
                                <?php foreach ($milestones as $index => $milestone): ?>
                                    <div class="relative flex gap-8" <?php echo $animate_timeline ? 'data-aos="fade-<?php echo $index % 2 === 0 ? 'right' : 'left'; ?>"' : ''; ?>>
                                        <!-- Milestone Dot -->
                                        <?php if ($show_icons): ?>
                                            <div class="flex-shrink-0 w-16 h-16 rounded-full flex items-center justify-center text-white font-bold text-lg z-10 shadow-lg" style="background-color: <?php echo esc_attr($accent_color); ?>;">
                                                <?php echo substr($milestone['year'], -2); ?>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Content -->
                                        <div class="flex-1 pt-2 pb-8 space-y-2">
                                            <?php if ($show_year): ?>
                                                <div class="text-xl font-bold" style="color: <?php echo esc_attr($accent_color); ?>;">
                                                    <?php echo esc_html($milestone['year']); ?>
                                                </div>
                                            <?php endif; ?>
                                            <h3 class="text-xl font-semibold" style="color: <?php echo esc_attr($heading_color); ?>;">
                                                <?php echo esc_html($milestone['title']); ?>
                                            </h3>
                                            <p class="leading-relaxed">
                                                <?php echo esc_html($milestone['description']); ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Footer Content -->
    <div class="hf-container max-w-7xl mx-auto px-4 py-12 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-<?php echo esc_attr($columns); ?> gap-8 lg:gap-12 mb-8">

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
                <?php if ($show_social && !empty($socials)): ?>
                    <div class="flex gap-3 pt-4">
                        <?php foreach ($socials as $network => $url):
                            if (!empty($url)): ?>
                                <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-lg flex items-center justify-center hover:opacity-80 transition-opacity" style="background-color: <?php echo esc_attr($accent_color); ?>; color: white;" aria-label="<?php echo esc_attr(ucfirst($network)); ?>">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="8"/>
                                    </svg>
                                </a>
                            <?php endif;
                        endforeach; ?>
                    </div>
                <?php endif; ?>
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

            <!-- Column 3: Contact -->
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
            </div>
        </div>
    </div>
</footer>
