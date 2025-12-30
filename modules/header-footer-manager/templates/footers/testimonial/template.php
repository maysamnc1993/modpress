<?php
/**
 * Footer Template: Testimonial
 * Footer with testimonials section featuring client reviews and standard footer content
 */

defined('ABSPATH') || exit;

$settings = dst_get_footer_setting();
$bg_color = $settings['bg_color'] ?? '#ffffff';
$testimonial_bg = $settings['testimonial_bg'] ?? '#f8fafc';
$text_color = $settings['text_color'] ?? '#475569';
$heading_color = $settings['heading_color'] ?? '#1e293b';
$accent_color = $settings['accent_color'] ?? '#3b82f6';
$show_testimonials = $settings['show_testimonials'] ?? true;
$testimonials_count = $settings['testimonials_count'] ?? '3';
$show_avatars = $settings['show_avatars'] ?? true;
$show_ratings = $settings['show_ratings'] ?? true;
$carousel_autoplay = $settings['carousel_autoplay'] ?? true;
$carousel_speed = $settings['carousel_speed'] ?? '5000';
$testimonial_title = $settings['testimonial_title'] ?? 'What Our Clients Say';
$testimonial_subtitle = $settings['testimonial_subtitle'] ?? 'Trusted by thousands of customers worldwide';
$show_logo = $settings['show_logo'] ?? true;
$show_social = $settings['show_social'] ?? true;
$show_contact = $settings['show_contact'] ?? true;
$columns = $settings['columns'] ?? '4';
$show_copyright = $settings['show_copyright'] ?? true;
$copyright_text = $settings['copyright_text'] ?? 'All rights reserved.';

$contact = dst_get_contact();
$socials = dst_get_socials();
?>

<footer class="hf-footer hf-footer-testimonial" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;">

    <!-- Testimonials Section -->
    <?php if ($show_testimonials): ?>
        <div class="hf-testimonials-section py-16 lg:py-20" style="background-color: <?php echo esc_attr($testimonial_bg); ?>;">
            <div class="hf-container max-w-7xl mx-auto px-4">

                <!-- Section Header -->
                <div class="text-center mb-12">
                    <h2 class="text-3xl lg:text-4xl font-bold mb-4" style="color: <?php echo esc_attr($heading_color); ?>;">
                        <?php echo esc_html($testimonial_title); ?>
                    </h2>
                    <?php if ($testimonial_subtitle): ?>
                        <p class="text-lg max-w-2xl mx-auto" style="color: <?php echo esc_attr($text_color); ?>;">
                            <?php echo esc_html($testimonial_subtitle); ?>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Testimonials Grid/Carousel -->
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-<?php echo esc_attr($testimonials_count); ?> gap-6 lg:gap-8"
                    x-data="{ active: 0 }"
                    <?php if ($carousel_autoplay): ?>
                        x-init="setInterval(() => { active = (active + 1) % <?php echo esc_attr($testimonials_count); ?> }, <?php echo esc_attr($carousel_speed); ?>)"
                    <?php endif; ?>
                >
                    <?php
                    // Sample testimonials data
                    $testimonials = [
                        [
                            'name' => 'Sarah Johnson',
                            'role' => 'CEO, TechCorp',
                            'content' => 'Outstanding service and exceptional quality. This team went above and beyond our expectations and delivered remarkable results.',
                            'rating' => 5
                        ],
                        [
                            'name' => 'Michael Chen',
                            'role' => 'Director, Innovation Labs',
                            'content' => 'Professional, creative, and highly skilled. They transformed our vision into reality with precision and care.',
                            'rating' => 5
                        ],
                        [
                            'name' => 'Emily Rodriguez',
                            'role' => 'Founder, StartupHub',
                            'content' => 'Amazing experience from start to finish. The attention to detail and commitment to excellence is unmatched.',
                            'rating' => 5
                        ],
                        [
                            'name' => 'David Kim',
                            'role' => 'Marketing Manager',
                            'content' => 'Incredible work! They delivered exactly what we needed and more. Highly recommended for any project.',
                            'rating' => 5
                        ],
                        [
                            'name' => 'Lisa Anderson',
                            'role' => 'Product Lead',
                            'content' => 'Best decision we made! The team is talented, responsive, and truly understands client needs.',
                            'rating' => 5
                        ],
                        [
                            'name' => 'James Wilson',
                            'role' => 'CTO, Digital Solutions',
                            'content' => 'Exceeded all expectations. Their expertise and dedication made our project a huge success.',
                            'rating' => 5
                        ]
                    ];

                    $display_count = min((int)$testimonials_count, count($testimonials));
                    for ($i = 0; $i < $display_count; $i++):
                        $testimonial = $testimonials[$i];
                    ?>
                        <div class="hf-testimonial-card bg-white rounded-xl p-6 lg:p-8 shadow-lg hover:shadow-xl transition-shadow duration-300">

                            <?php if ($show_ratings): ?>
                                <div class="flex gap-1 mb-4">
                                    <?php for ($j = 0; $j < 5; $j++): ?>
                                        <svg class="w-5 h-5" fill="<?php echo $j < $testimonial['rating'] ? esc_attr($accent_color) : '#e2e8f0'; ?>" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    <?php endfor; ?>
                                </div>
                            <?php endif; ?>

                            <blockquote class="mb-6 text-base leading-relaxed" style="color: <?php echo esc_attr($text_color); ?>;">
                                "<?php echo esc_html($testimonial['content']); ?>"
                            </blockquote>

                            <div class="flex items-center gap-4">
                                <?php if ($show_avatars): ?>
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold" style="background-color: <?php echo esc_attr($accent_color); ?>;">
                                        <?php echo substr($testimonial['name'], 0, 1); ?>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <div class="font-semibold" style="color: <?php echo esc_attr($heading_color); ?>;">
                                        <?php echo esc_html($testimonial['name']); ?>
                                    </div>
                                    <div class="text-sm" style="color: <?php echo esc_attr($text_color); ?>;">
                                        <?php echo esc_html($testimonial['role']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
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
                    <div class="flex gap-4">
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
