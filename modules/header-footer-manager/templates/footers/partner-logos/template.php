<?php
/**
 * Footer Template: Partner Logos
 * Footer with partner/client logos carousel or grid section
 */

defined('ABSPATH') || exit;

$settings = dst_get_footer_setting();
$bg_color = $settings['bg_color'] ?? '#ffffff';
$logos_bg = $settings['logos_bg'] ?? '#f1f5f9';
$text_color = $settings['text_color'] ?? '#475569';
$heading_color = $settings['heading_color'] ?? '#1e293b';
$accent_color = $settings['accent_color'] ?? '#10b981';
$show_logos = $settings['show_logos'] ?? true;
$logos_title = $settings['logos_title'] ?? 'Trusted by Leading Companies';
$logos_subtitle = $settings['logos_subtitle'] ?? 'Join thousands of satisfied clients worldwide';
$logos_style = $settings['logos_style'] ?? 'grid';
$logos_count = $settings['logos_count'] ?? '6';
$logos_per_row = $settings['logos_per_row'] ?? '4';
$logos_grayscale = $settings['logos_grayscale'] ?? true;
$carousel_autoplay = $settings['carousel_autoplay'] ?? true;
$carousel_speed = $settings['carousel_speed'] ?? '3000';
$show_logo = $settings['show_logo'] ?? true;
$show_social = $settings['show_social'] ?? true;
$show_contact = $settings['show_contact'] ?? true;
$columns = $settings['columns'] ?? '4';
$show_copyright = $settings['show_copyright'] ?? true;
$copyright_text = $settings['copyright_text'] ?? 'All rights reserved.';

$contact = dst_get_contact();
$socials = dst_get_socials();
?>

<footer class="hf-footer hf-footer-partner-logos" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;">

    <!-- Partner Logos Section -->
    <?php if ($show_logos): ?>
        <div class="hf-partners-section py-16 lg:py-20" style="background-color: <?php echo esc_attr($logos_bg); ?>;">
            <div class="hf-container max-w-7xl mx-auto px-4">

                <!-- Section Header -->
                <div class="text-center mb-12">
                    <h2 class="text-3xl lg:text-4xl font-bold mb-4" style="color: <?php echo esc_attr($heading_color); ?>;">
                        <?php echo esc_html($logos_title); ?>
                    </h2>
                    <?php if ($logos_subtitle): ?>
                        <p class="text-lg max-w-2xl mx-auto" style="color: <?php echo esc_attr($text_color); ?>;">
                            <?php echo esc_html($logos_subtitle); ?>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Partner Logos Grid/Carousel -->
                <?php if ($logos_style === 'carousel'): ?>
                    <div
                        class="hf-logos-carousel"
                        x-data="{ active: 0, count: <?php echo esc_attr($logos_count); ?> }"
                        <?php if ($carousel_autoplay): ?>
                            x-init="setInterval(() => { active = (active + 1) % count }, <?php echo esc_attr($carousel_speed); ?>)"
                        <?php endif; ?>
                    >
                        <div class="overflow-hidden">
                            <div class="flex transition-transform duration-500" :style="'transform: translateX(-' + (active * 100) + '%)'">
                                <?php for ($i = 0; $i < (int)$logos_count; $i++): ?>
                                    <div class="w-full flex-shrink-0 px-4">
                                        <div class="grid grid-cols-<?php echo esc_attr($logos_per_row); ?> gap-8 items-center">
                                            <?php for ($j = 0; $j < (int)$logos_per_row; $j++): ?>
                                                <div class="flex items-center justify-center p-6 <?php echo $logos_grayscale ? 'grayscale hover:grayscale-0' : ''; ?> transition-all duration-300">
                                                    <div class="w-32 h-16 bg-gray-200 rounded flex items-center justify-center text-xs font-semibold text-gray-500">
                                                        Partner <?php echo ($i * (int)$logos_per_row + $j + 1); ?>
                                                    </div>
                                                </div>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <!-- Carousel Controls -->
                        <div class="flex justify-center gap-2 mt-8">
                            <?php for ($i = 0; $i < (int)$logos_count; $i++): ?>
                                <button
                                    @click="active = <?php echo $i; ?>"
                                    :class="active === <?php echo $i; ?> ? 'w-8' : 'w-2'"
                                    class="h-2 rounded-full transition-all duration-300"
                                    :style="active === <?php echo $i; ?> ? 'background-color: <?php echo esc_attr($accent_color); ?>' : 'background-color: #cbd5e1'"
                                    aria-label="Slide <?php echo $i + 1; ?>"
                                ></button>
                            <?php endfor; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-2 md:grid-cols-<?php echo esc_attr($logos_per_row); ?> gap-8 lg:gap-12">
                        <?php for ($i = 0; $i < (int)$logos_count; $i++): ?>
                            <div class="flex items-center justify-center p-6 bg-white rounded-lg shadow-sm hover:shadow-md <?php echo $logos_grayscale ? 'grayscale hover:grayscale-0' : ''; ?> transition-all duration-300">
                                <div class="w-32 h-16 bg-gray-200 rounded flex items-center justify-center text-xs font-semibold text-gray-500">
                                    Partner <?php echo $i + 1; ?>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
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
                <?php if ($show_social && !empty($socials)): ?>
                    <div class="flex gap-3 pt-4">
                        <?php foreach ($socials as $network => $url):
                            if (!empty($url)): ?>
                                <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-full flex items-center justify-center border-2 hover:bg-opacity-10 transition-all" style="border-color: <?php echo esc_attr($accent_color); ?>; color: <?php echo esc_attr($accent_color); ?>;" aria-label="<?php echo esc_attr(ucfirst($network)); ?>">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
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

            <!-- Column 3: Resources -->
            <div class="space-y-4">
                <h4 class="text-lg font-semibold" style="color: <?php echo esc_attr($heading_color); ?>;">Resources</h4>
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
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: <?php echo esc_attr($accent_color); ?>;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <a href="mailto:<?php echo esc_attr($contact['email']); ?>" class="hover:underline">
                                    <?php echo esc_html($contact['email']); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (!empty($contact['phone'])): ?>
                            <li class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: <?php echo esc_attr($accent_color); ?>;">
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
            <div class="flex flex-col md:flex-row items-center justify-center gap-4">
                <?php if ($show_copyright): ?>
                    <div class="text-sm text-center">
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
