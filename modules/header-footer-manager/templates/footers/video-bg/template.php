<?php
/**
 * Footer Template: Video Background
 * Footer with video or image background and overlay content
 */

defined('ABSPATH') || exit;

$settings = dst_get_footer_setting();
$bg_type = $settings['bg_type'] ?? 'video';
$bg_url = $settings['bg_url'] ?? '';
$fallback_image = $settings['fallback_image'] ?? '';
$overlay_color = $settings['overlay_color'] ?? '#000000';
$overlay_opacity = $settings['overlay_opacity'] ?? '0.7';
$text_color = $settings['text_color'] ?? '#ffffff';
$heading_color = $settings['heading_color'] ?? '#ffffff';
$accent_color = $settings['accent_color'] ?? '#06b6d4';
$show_cta = $settings['show_cta'] ?? true;
$cta_title = $settings['cta_title'] ?? 'Ready to Get Started?';
$cta_text = $settings['cta_text'] ?? 'Join thousands of satisfied customers and take your business to the next level';
$cta_button_text = $settings['cta_button_text'] ?? 'Get Started Today';
$cta_button_url = $settings['cta_button_url'] ?? '#';
$video_autoplay = $settings['video_autoplay'] ?? true;
$video_loop = $settings['video_loop'] ?? true;
$video_muted = $settings['video_muted'] ?? true;
$show_logo = $settings['show_logo'] ?? true;
$show_social = $settings['show_social'] ?? true;
$show_contact = $settings['show_contact'] ?? true;
$columns = $settings['columns'] ?? '4';
$show_copyright = $settings['show_copyright'] ?? true;
$copyright_text = $settings['copyright_text'] ?? 'All rights reserved.';

$contact = dst_get_contact();
$socials = dst_get_socials();
?>

<footer class="hf-footer hf-footer-video-bg relative overflow-hidden" style="color: <?php echo esc_attr($text_color); ?>;">

    <!-- Background Video/Image -->
    <div class="absolute inset-0 z-0">
        <?php if ($bg_type === 'video' && !empty($bg_url)): ?>
            <video
                class="absolute inset-0 w-full h-full object-cover"
                <?php echo $video_autoplay ? 'autoplay' : ''; ?>
                <?php echo $video_loop ? 'loop' : ''; ?>
                <?php echo $video_muted ? 'muted' : ''; ?>
                playsinline
                poster="<?php echo esc_url($fallback_image); ?>"
            >
                <source src="<?php echo esc_url($bg_url); ?>" type="video/mp4">
                <?php if (!empty($fallback_image)): ?>
                    <img src="<?php echo esc_url($fallback_image); ?>" alt="Background" class="w-full h-full object-cover">
                <?php endif; ?>
            </video>
        <?php elseif ($bg_type === 'image' && !empty($bg_url)): ?>
            <div
                class="absolute inset-0 w-full h-full bg-cover bg-center"
                style="background-image: url('<?php echo esc_url($bg_url); ?>');"
            ></div>
        <?php else: ?>
            <!-- Default gradient background -->
            <div class="absolute inset-0 w-full h-full" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
        <?php endif; ?>

        <!-- Overlay -->
        <div
            class="absolute inset-0 w-full h-full"
            style="background-color: <?php echo esc_attr($overlay_color); ?>; opacity: <?php echo esc_attr($overlay_opacity); ?>;"
        ></div>
    </div>

    <!-- Content -->
    <div class="relative z-10">

        <!-- CTA Section -->
        <?php if ($show_cta): ?>
            <div class="hf-cta-section py-16 lg:py-24">
                <div class="hf-container max-w-4xl mx-auto px-4 text-center">
                    <h2 class="text-3xl lg:text-5xl font-bold mb-6" style="color: <?php echo esc_attr($heading_color); ?>;">
                        <?php echo esc_html($cta_title); ?>
                    </h2>
                    <p class="text-lg lg:text-xl mb-8 max-w-2xl mx-auto opacity-90">
                        <?php echo esc_html($cta_text); ?>
                    </p>
                    <a
                        href="<?php echo esc_url($cta_button_url); ?>"
                        class="inline-block px-8 lg:px-10 py-4 text-base lg:text-lg font-bold rounded-lg transition-all duration-300 hover:scale-105 hover:shadow-2xl"
                        style="background-color: <?php echo esc_attr($accent_color); ?>; color: white;"
                    >
                        <?php echo esc_html($cta_button_text); ?>
                    </a>
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
                            $logo = dst_get_logo('light');
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
                    <p class="text-sm leading-relaxed opacity-90">
                        <?php echo get_bloginfo('description'); ?>
                    </p>
                    <?php if ($show_social && !empty($socials)): ?>
                        <div class="flex gap-3 pt-4">
                            <?php foreach ($socials as $network => $url):
                                if (!empty($url)): ?>
                                    <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full flex items-center justify-center border-2 hover:bg-white/10 transition-all" style="border-color: <?php echo esc_attr($text_color); ?>; color: <?php echo esc_attr($text_color); ?>;" aria-label="<?php echo esc_attr(ucfirst($network)); ?>">
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
                        'menu_class'     => 'space-y-2 text-sm opacity-90',
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
                        'menu_class'     => 'space-y-2 text-sm opacity-90',
                        'fallback_cb'    => false,
                        'depth'          => 1,
                    ]);
                    ?>
                </div>

                <!-- Column 4: Contact -->
                <?php if ($show_contact): ?>
                    <div class="space-y-4">
                        <h4 class="text-lg font-semibold" style="color: <?php echo esc_attr($heading_color); ?>;">Contact</h4>
                        <ul class="space-y-3 text-sm opacity-90">
                            <?php if (!empty($contact['email'])): ?>
                                <li class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <a href="mailto:<?php echo esc_attr($contact['email']); ?>" class="hover:underline">
                                        <?php echo esc_html($contact['email']); ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty($contact['phone'])): ?>
                                <li class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <a href="tel:<?php echo esc_attr($contact['phone']); ?>" class="hover:underline">
                                        <?php echo esc_html($contact['phone']); ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty($contact['address'])): ?>
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span><?php echo esc_html($contact['address']); ?></span>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t pt-8 opacity-80" style="border-color: <?php echo esc_attr($text_color); ?>33;">
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
    </div>
</footer>
