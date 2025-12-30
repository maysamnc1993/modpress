<?php
/**
 * Footer Template: Split Color Footer
 * Unique split color design with content flowing across divided sections
 */

defined('ABSPATH') || exit;

$settings = dst_get_footer_setting();
$split_style = $settings['split_style'] ?? 'diagonal';
$left_color = $settings['left_color'] ?? '#1e293b';
$right_color = $settings['right_color'] ?? '#3b82f6';
$text_color_left = $settings['text_color_left'] ?? '#ffffff';
$text_color_right = $settings['text_color_right'] ?? '#ffffff';
$heading_color_left = $settings['heading_color_left'] ?? '#ffffff';
$heading_color_right = $settings['heading_color_right'] ?? '#ffffff';
$show_divider = $settings['show_divider'] ?? true;
$divider_color = $settings['divider_color'] ?? '#ffffff';
$divider_opacity = $settings['divider_opacity'] ?? '30';
$show_cta = $settings['show_cta'] ?? true;
$cta_text = $settings['cta_text'] ?? 'Get Started';
$cta_url = $settings['cta_url'] ?? '/contact';
$bottom_bg_color = $settings['bottom_bg_color'] ?? '#0f172a';
$bottom_text_color = $settings['bottom_text_color'] ?? '#94a3b8';
$show_social = $settings['show_social'] ?? true;

// Generate clip-path based on split style
$clip_path_left = '';
$clip_path_right = '';

switch ($split_style) {
    case 'vertical':
        $clip_path_left = 'polygon(0 0, 50% 0, 50% 100%, 0 100%)';
        $clip_path_right = 'polygon(50% 0, 100% 0, 100% 100%, 50% 100%)';
        break;
    case 'diagonal':
        $clip_path_left = 'polygon(0 0, 60% 0, 40% 100%, 0 100%)';
        $clip_path_right = 'polygon(60% 0, 100% 0, 100% 100%, 40% 100%)';
        break;
    case 'curved':
        $clip_path_left = 'polygon(0 0, 55% 0, 45% 50%, 55% 100%, 0 100%)';
        $clip_path_right = 'polygon(55% 0, 100% 0, 100% 100%, 55% 100%, 45% 50%)';
        break;
    case 'zigzag':
        $clip_path_left = 'polygon(0 0, 50% 0, 40% 33%, 60% 66%, 50% 100%, 0 100%)';
        $clip_path_right = 'polygon(50% 0, 100% 0, 100% 100%, 50% 100%, 60% 66%, 40% 33%)';
        break;
    case 'asymmetric':
        $clip_path_left = 'polygon(0 0, 65% 0, 55% 100%, 0 100%)';
        $clip_path_right = 'polygon(65% 0, 100% 0, 100% 100%, 55% 100%)';
        break;
}

$divider_opacity_decimal = intval($divider_opacity) / 100;
?>

<style>
    .split-footer-left {
        background-color: <?php echo esc_attr($left_color); ?>;
        clip-path: <?php echo $clip_path_left; ?>;
    }
    .split-footer-right {
        background-color: <?php echo esc_attr($right_color); ?>;
        clip-path: <?php echo $clip_path_right; ?>;
    }
</style>

<footer class="hf-footer hf-footer-split-color">

    <!-- Split Background Container -->
    <div class="relative min-h-[400px]">
        <!-- Left Background -->
        <div class="split-footer-left absolute inset-0 z-0"></div>

        <!-- Right Background -->
        <div class="split-footer-right absolute inset-0 z-0"></div>

        <!-- Divider Line (optional) -->
        <?php if ($show_divider): ?>
            <?php if ($split_style === 'vertical'): ?>
                <div class="absolute top-0 bottom-0 left-1/2 w-px z-10" style="background-color: <?php echo esc_attr($divider_color); ?>; opacity: <?php echo esc_attr($divider_opacity_decimal); ?>;"></div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Content Layer -->
        <div class="relative z-20 py-16">
            <div class="hf-container max-w-7xl mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-12">

                    <!-- Left Side Content -->
                    <div style="color: <?php echo esc_attr($text_color_left); ?>;">
                        <div class="mb-8">
                            <?php dst_the_logo('footer', 'h-14 w-auto max-w-[220px] object-contain brightness-0 invert'); ?>
                        </div>

                        <h3 class="text-2xl font-bold mb-4" style="color: <?php echo esc_attr($heading_color_left); ?>;">
                            Ready to get started?
                        </h3>
                        <p class="text-lg mb-6 opacity-90 leading-relaxed">
                            <?php echo get_bloginfo('description'); ?>
                        </p>

                        <?php if ($show_cta): ?>
                            <a href="<?php echo esc_url($cta_url); ?>" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-gray-900 rounded-lg font-bold hover:bg-gray-100 transition-all">
                                <?php echo esc_html($cta_text); ?>
                                <?php echo dst_get_icon('arrow-right', 'w-5 h-5'); ?>
                            </a>
                        <?php endif; ?>

                        <!-- Contact Info -->
                        <?php
                        $contact = dst_get_contact();
                        if (!empty($contact)):
                        ?>
                        <div class="mt-8 space-y-3">
                            <?php if (!empty($contact['phone'])): ?>
                            <div class="flex items-start gap-3 opacity-90">
                                <?php echo dst_get_icon('phone', 'w-5 h-5 mt-0.5 flex-shrink-0'); ?>
                                <a href="tel:<?php echo esc_attr($contact['phone']); ?>" class="hover:opacity-80 transition-opacity">
                                    <?php echo esc_html($contact['phone']); ?>
                                </a>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($contact['email'])): ?>
                            <div class="flex items-start gap-3 opacity-90">
                                <?php echo dst_get_icon('mail', 'w-5 h-5 mt-0.5 flex-shrink-0'); ?>
                                <a href="mailto:<?php echo esc_attr($contact['email']); ?>" class="hover:opacity-80 transition-opacity">
                                    <?php echo esc_html($contact['email']); ?>
                                </a>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($contact['address'])): ?>
                            <div class="flex items-start gap-3 opacity-90">
                                <?php echo dst_get_icon('location', 'w-5 h-5 mt-0.5 flex-shrink-0'); ?>
                                <span><?php echo esc_html($contact['address']); ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Right Side Content -->
                    <div style="color: <?php echo esc_attr($text_color_right); ?>;">
                        <div class="grid grid-cols-2 gap-8">

                            <!-- Quick Links -->
                            <div>
                                <h4 class="text-lg font-bold mb-4" style="color: <?php echo esc_attr($heading_color_right); ?>;">Quick Links</h4>
                                <?php
                                wp_nav_menu([
                                    'theme_location' => 'footer',
                                    'container'      => false,
                                    'menu_class'     => 'space-y-2',
                                    'fallback_cb'    => false,
                                    'depth'          => 1,
                                    'link_before'    => '<span class="opacity-90 hover:opacity-100 transition-opacity">',
                                    'link_after'     => '</span>',
                                ]);
                                ?>
                            </div>

                            <!-- Services -->
                            <div>
                                <h4 class="text-lg font-bold mb-4" style="color: <?php echo esc_attr($heading_color_right); ?>;">Services</h4>
                                <ul class="space-y-2">
                                    <li><a href="#" class="opacity-90 hover:opacity-100 transition-opacity">Web Design</a></li>
                                    <li><a href="#" class="opacity-90 hover:opacity-100 transition-opacity">Development</a></li>
                                    <li><a href="#" class="opacity-90 hover:opacity-100 transition-opacity">Marketing</a></li>
                                    <li><a href="#" class="opacity-90 hover:opacity-100 transition-opacity">SEO</a></li>
                                    <li><a href="#" class="opacity-90 hover:opacity-100 transition-opacity">Consulting</a></li>
                                </ul>
                            </div>

                            <!-- Company -->
                            <div>
                                <h4 class="text-lg font-bold mb-4" style="color: <?php echo esc_attr($heading_color_right); ?>;">Company</h4>
                                <ul class="space-y-2">
                                    <li><a href="#" class="opacity-90 hover:opacity-100 transition-opacity">About Us</a></li>
                                    <li><a href="#" class="opacity-90 hover:opacity-100 transition-opacity">Careers</a></li>
                                    <li><a href="#" class="opacity-90 hover:opacity-100 transition-opacity">Blog</a></li>
                                    <li><a href="#" class="opacity-90 hover:opacity-100 transition-opacity">Press</a></li>
                                </ul>
                            </div>

                            <!-- Support -->
                            <div>
                                <h4 class="text-lg font-bold mb-4" style="color: <?php echo esc_attr($heading_color_right); ?>;">Support</h4>
                                <ul class="space-y-2">
                                    <li><a href="#" class="opacity-90 hover:opacity-100 transition-opacity">Help Center</a></li>
                                    <li><a href="#" class="opacity-90 hover:opacity-100 transition-opacity">Contact</a></li>
                                    <li><a href="#" class="opacity-90 hover:opacity-100 transition-opacity">FAQ</a></li>
                                    <li><a href="#" class="opacity-90 hover:opacity-100 transition-opacity">Privacy</a></li>
                                </ul>
                            </div>

                        </div>

                        <!-- Newsletter -->
                        <div class="mt-8">
                            <h4 class="text-lg font-bold mb-3" style="color: <?php echo esc_attr($heading_color_right); ?>;">Newsletter</h4>
                            <p class="mb-4 opacity-90">Stay updated with our latest news</p>

                            <div x-data="newsletter">
                                <form @submit.prevent="subscribe" class="flex gap-2">
                                    <input
                                        type="email"
                                        x-model="email"
                                        :disabled="loading"
                                        required
                                        placeholder="Your email address"
                                        class="flex-1 px-4 py-3 rounded-lg bg-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/50 backdrop-blur-sm"
                                    >
                                    <button
                                        type="submit"
                                        :disabled="loading"
                                        class="px-6 py-3 rounded-lg bg-white/30 hover:bg-white/40 disabled:opacity-50 transition-all backdrop-blur-sm font-medium"
                                    >
                                        <span x-show="!loading">Subscribe</span>
                                        <span x-show="loading">...</span>
                                    </button>
                                </form>
                                <div x-show="message" x-transition class="mt-2">
                                    <p :class="success ? 'text-green-200' : 'text-red-200'" class="text-sm" x-text="message"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Social Icons -->
                        <?php if ($show_social): ?>
                        <div class="mt-6">
                            <div class="flex gap-3">
                                <?php
                                $social = dst_get_social();
                                foreach ($social as $platform => $url):
                                    if (!empty($url)):
                                ?>
                                    <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center hover:bg-white/30 transition-all backdrop-blur-sm" aria-label="<?php echo esc_attr($platform); ?>">
                                        <?php echo dst_get_icon($platform, 'w-5 h-5'); ?>
                                    </a>
                                <?php
                                    endif;
                                endforeach;
                                ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="py-6" style="background-color: <?php echo esc_attr($bottom_bg_color); ?>; color: <?php echo esc_attr($bottom_text_color); ?>;">
        <div class="hf-container max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm">
                <p>
                    &copy; <?php echo date('Y'); ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-white transition-colors font-semibold">
                        <?php bloginfo('name'); ?>
                    </a>
                    - All rights reserved.
                </p>

                <div class="flex items-center gap-6">
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                    <a href="#" class="hover:text-white transition-colors">Cookies</a>
                </div>
            </div>
        </div>
    </div>

</footer>
