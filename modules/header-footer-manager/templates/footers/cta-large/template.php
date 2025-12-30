<?php
/**
 * Footer Template: Large CTA
 * Footer with prominent call-to-action section and dual buttons
 */

defined('ABSPATH') || exit;

$settings = dst_get_footer_setting();
$bg_color = $settings['bg_color'] ?? '#111827';
$cta_bg_color = $settings['cta_bg_color'] ?? '#1f2937';
$text_color = $settings['text_color'] ?? '#9ca3af';
$heading_color = $settings['heading_color'] ?? '#ffffff';
$primary_color = $settings['primary_color'] ?? '#10b981';
$secondary_color = $settings['secondary_color'] ?? '#6b7280';
$cta_heading = $settings['cta_heading'] ?? 'Ready to Get Started?';
$cta_subheading = $settings['cta_subheading'] ?? 'Join thousands of satisfied customers';
$cta_text = $settings['cta_text'] ?? 'Transform your business with our cutting-edge solutions. Start your free trial today and experience the difference.';
$primary_btn_text = $settings['primary_btn_text'] ?? 'Start Free Trial';
$primary_btn_url = $settings['primary_btn_url'] ?? '/signup';
$secondary_btn_text = $settings['secondary_btn_text'] ?? 'View Pricing';
$secondary_btn_url = $settings['secondary_btn_url'] ?? '/pricing';
$show_features = $settings['show_features'] ?? true;
$show_logo = $settings['show_logo'] ?? true;
$show_menu = $settings['show_menu'] ?? true;
$show_contact = $settings['show_contact'] ?? true;
$show_social = $settings['show_social'] ?? true;
$show_copyright = $settings['show_copyright'] ?? true;
$copyright_text = $settings['copyright_text'] ?? 'All rights reserved.';
$cta_style = $settings['cta_style'] ?? 'gradient';

$contact = dst_get_contact();

$features = [
    'No credit card required',
    'Cancel anytime',
    '24/7 support',
    'Money-back guarantee'
];
?>

<footer class="hf-footer hf-footer-cta-large" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;">
    <style>
        .hf-footer-cta-large a {
            transition: opacity 0.3s ease;
        }
        .hf-footer-cta-large a:hover {
            opacity: 0.9;
        }
        .hf-cta-section {
            <?php if ($cta_style === 'gradient'): ?>
            background: linear-gradient(135deg, <?php echo esc_attr($cta_bg_color); ?>, <?php echo esc_attr($primary_color); ?>20);
            <?php elseif ($cta_style === 'bordered'): ?>
            background: transparent;
            border: 2px solid <?php echo esc_attr($primary_color); ?>40;
            <?php else: ?>
            background: <?php echo esc_attr($cta_bg_color); ?>;
            <?php endif; ?>
        }
        .hf-primary-btn {
            background-color: <?php echo esc_attr($primary_color); ?>;
            color: white;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hf-primary-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px <?php echo esc_attr($primary_color); ?>40;
        }
        .hf-secondary-btn {
            background-color: transparent;
            border: 2px solid <?php echo esc_attr($secondary_color); ?>;
            color: <?php echo esc_attr($heading_color); ?>;
            transition: all 0.3s ease;
        }
        .hf-secondary-btn:hover {
            background-color: <?php echo esc_attr($secondary_color); ?>;
            border-color: <?php echo esc_attr($secondary_color); ?>;
        }
    </style>

    <!-- Large CTA Section -->
    <div class="py-16 lg:py-24">
        <div class="hf-container">
            <div class="hf-cta-section max-w-5xl mx-auto rounded-2xl p-8 lg:p-16">

                <!-- Badge -->
                <div class="text-center mb-6">
                    <span class="inline-block px-4 py-2 text-sm font-semibold rounded-full"
                          style="background-color: <?php echo esc_attr($primary_color); ?>20; color: <?php echo esc_attr($primary_color); ?>;">
                        <?php echo esc_html($cta_subheading); ?>
                    </span>
                </div>

                <!-- Heading -->
                <h2 class="text-4xl lg:text-6xl font-bold text-center mb-6" style="color: <?php echo esc_attr($heading_color); ?>;">
                    <?php echo esc_html($cta_heading); ?>
                </h2>

                <!-- Description -->
                <p class="text-lg lg:text-xl text-center mb-8 max-w-3xl mx-auto" style="color: <?php echo esc_attr($text_color); ?>;">
                    <?php echo esc_html($cta_text); ?>
                </p>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-8">
                    <a href="<?php echo esc_url($primary_btn_url); ?>"
                       class="hf-primary-btn px-8 py-4 text-lg font-bold rounded-lg inline-flex items-center gap-2">
                        <?php echo esc_html($primary_btn_text); ?>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>

                    <a href="<?php echo esc_url($secondary_btn_url); ?>"
                       class="hf-secondary-btn px-8 py-4 text-lg font-bold rounded-lg inline-flex items-center gap-2">
                        <?php echo esc_html($secondary_btn_text); ?>
                    </a>
                </div>

                <!-- Feature Highlights -->
                <?php if ($show_features): ?>
                    <div class="flex flex-wrap items-center justify-center gap-6 text-sm">
                        <?php foreach ($features as $feature): ?>
                            <div class="inline-flex items-center gap-2">
                                <svg class="w-5 h-5" style="color: <?php echo esc_attr($primary_color); ?>;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span><?php echo esc_html($feature); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <!-- Footer Info -->
    <div class="py-12 border-t" style="border-color: <?php echo esc_attr($secondary_color); ?>40;">
        <div class="hf-container">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12 mb-12">

                <!-- Column 1: Logo & About -->
                <?php if ($show_logo): ?>
                    <div class="space-y-4">
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

                        <p class="text-sm leading-relaxed">
                            <?php echo esc_html(get_bloginfo('description')); ?>
                        </p>
                    </div>
                <?php endif; ?>

                <!-- Column 2: Menu -->
                <?php if ($show_menu): ?>
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold" style="color: <?php echo esc_attr($heading_color); ?>;">
                            Quick Links
                        </h3>
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
                <?php endif; ?>

                <!-- Column 3: Contact -->
                <?php if ($show_contact && !empty($contact)): ?>
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold" style="color: <?php echo esc_attr($heading_color); ?>;">
                            Contact Us
                        </h3>
                        <div class="space-y-3 text-sm">
                            <?php if (!empty($contact['email'])): ?>
                                <a href="mailto:<?php echo esc_attr($contact['email']); ?>"
                                   class="flex items-start gap-2 hover:opacity-70"
                                   style="color: <?php echo esc_attr($text_color); ?>;">
                                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <?php echo esc_html($contact['email']); ?>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($contact['phone'])): ?>
                                <a href="tel:<?php echo esc_attr($contact['phone']); ?>"
                                   class="flex items-start gap-2 hover:opacity-70"
                                   style="color: <?php echo esc_attr($text_color); ?>;">
                                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <?php echo esc_html($contact['phone']); ?>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($contact['address'])): ?>
                                <div class="flex items-start gap-2" style="color: <?php echo esc_attr($text_color); ?>;">
                                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <?php echo esc_html($contact['address']); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Column 4: Social -->
                <?php if ($show_social): ?>
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold" style="color: <?php echo esc_attr($heading_color); ?>;">
                            Follow Us
                        </h3>
                        <div class="flex gap-3">
                            <?php
                            $socials = dst_get_socials();
                            $social_icons = [
                                'instagram' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>',
                                'twitter' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>',
                                'facebook' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
                                'linkedin' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
                                'youtube' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>'
                            ];

                            foreach ($socials as $network => $url):
                                if (!empty($url) && isset($social_icons[$network])): ?>
                                    <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer"
                                       class="p-2 rounded-lg hover:opacity-70 transition-opacity"
                                       style="background-color: <?php echo esc_attr($secondary_color); ?>40;"
                                       aria-label="<?php echo esc_attr(ucfirst($network)); ?>">
                                        <?php echo $social_icons[$network]; ?>
                                    </a>
                                <?php endif;
                            endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

            <!-- Copyright -->
            <?php if ($show_copyright): ?>
                <div class="pt-8 border-t text-center text-sm" style="border-color: <?php echo esc_attr($secondary_color); ?>40;">
                    &copy; <?php echo date('Y'); ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:underline" style="color: <?php echo esc_attr($primary_color); ?>;">
                        <?php bloginfo('name'); ?>
                    </a>
                    <?php if ($copyright_text): ?>
                        - <?php echo esc_html($copyright_text); ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</footer>
