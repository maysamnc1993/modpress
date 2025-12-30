<?php
/**
 * Footer Template: Mega Footer
 * Large multi-section footer with everything - newsletter, app buttons, trust badges, payment icons
 */

defined('ABSPATH') || exit;

$settings = dst_get_footer_setting();
$columns = $settings['columns'] ?? '4';
$show_newsletter_bar = $settings['show_newsletter_bar'] ?? true;
$newsletter_bg_color = $settings['newsletter_bg_color'] ?? '#3b82f6';
$newsletter_text = $settings['newsletter_text'] ?? 'Subscribe to our Newsletter';
$newsletter_description = $settings['newsletter_description'] ?? 'Get the latest updates, offers, and exclusive content delivered to your inbox';
$show_app_buttons = $settings['show_app_buttons'] ?? true;
$ios_link = $settings['ios_link'] ?? '#';
$android_link = $settings['android_link'] ?? '#';
$show_trust_badges = $settings['show_trust_badges'] ?? true;
$show_payment_icons = $settings['show_payment_icons'] ?? true;
$bg_color = $settings['bg_color'] ?? '#111827';
$text_color = $settings['text_color'] ?? '#d1d5db';
$heading_color = $settings['heading_color'] ?? '#ffffff';
$link_hover_color = $settings['link_hover_color'] ?? '#3b82f6';
$bottom_bg_color = $settings['bottom_bg_color'] ?? '#0f172a';
$show_working_hours = $settings['show_working_hours'] ?? true;
$working_hours_text = $settings['working_hours_text'] ?? "Monday - Friday: 9:00 AM - 6:00 PM\nSaturday: 10:00 AM - 4:00 PM\nSunday: Closed";

$column_class = match($columns) {
    '3' => 'lg:grid-cols-3',
    '5' => 'lg:grid-cols-5',
    '6' => 'lg:grid-cols-6',
    default => 'lg:grid-cols-4'
};
?>

<style>
    .mega-footer-link:hover {
        color: <?php echo esc_attr($link_hover_color); ?>;
    }
</style>

<footer class="hf-footer hf-footer-mega-footer" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;">

    <!-- Newsletter Bar -->
    <?php if ($show_newsletter_bar): ?>
        <div class="py-12" style="background-color: <?php echo esc_attr($newsletter_bg_color); ?>;">
            <div class="hf-container max-w-7xl mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                    <div>
                        <h3 class="text-2xl md:text-3xl font-bold text-white mb-2">
                            <?php echo esc_html($newsletter_text); ?>
                        </h3>
                        <p class="text-white/90">
                            <?php echo esc_html($newsletter_description); ?>
                        </p>
                    </div>
                    <div class="max-w-md lg:ml-auto w-full" x-data="newsletter">
                        <form @submit.prevent="subscribe" class="flex flex-col sm:flex-row gap-3">
                            <input
                                type="email"
                                x-model="email"
                                :disabled="loading"
                                required
                                placeholder="Enter your email address"
                                class="flex-1 px-4 py-3 rounded-lg bg-white text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-white/50"
                            >
                            <button
                                type="submit"
                                :disabled="loading"
                                class="px-8 py-3 rounded-lg bg-white text-gray-900 font-bold hover:bg-gray-100 disabled:opacity-50 transition-all whitespace-nowrap"
                            >
                                <span x-show="!loading">Subscribe</span>
                                <span x-show="loading">Subscribing...</span>
                            </button>
                        </form>
                        <div x-show="message" x-transition class="mt-3">
                            <p :class="success ? 'text-green-100' : 'text-red-100'" class="text-sm" x-text="message"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Footer Content -->
    <div class="py-16">
        <div class="hf-container max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 <?php echo esc_attr($column_class); ?> gap-8 mb-12">

                <!-- About / Logo Column -->
                <div class="<?php echo $columns >= 5 ? 'lg:col-span-2' : ''; ?>">
                    <div class="mb-6">
                        <?php dst_the_logo('footer', 'h-12 w-auto max-w-[200px] object-contain brightness-0 invert'); ?>
                    </div>
                    <p class="mb-6 leading-relaxed max-w-sm">
                        <?php echo get_bloginfo('description'); ?>
                    </p>

                    <?php
                    $contact = dst_get_contact();
                    if (!empty($contact)):
                    ?>
                    <div class="space-y-3 mb-6">
                        <?php if (!empty($contact['phone'])): ?>
                        <div class="flex items-start gap-3">
                            <?php echo dst_get_icon('phone', 'w-5 h-5 mt-0.5 flex-shrink-0'); ?>
                            <a href="tel:<?php echo esc_attr($contact['phone']); ?>" class="mega-footer-link transition-colors">
                                <?php echo esc_html($contact['phone']); ?>
                            </a>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($contact['email'])): ?>
                        <div class="flex items-start gap-3">
                            <?php echo dst_get_icon('mail', 'w-5 h-5 mt-0.5 flex-shrink-0'); ?>
                            <a href="mailto:<?php echo esc_attr($contact['email']); ?>" class="mega-footer-link transition-colors">
                                <?php echo esc_html($contact['email']); ?>
                            </a>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($contact['address'])): ?>
                        <div class="flex items-start gap-3">
                            <?php echo dst_get_icon('location', 'w-5 h-5 mt-0.5 flex-shrink-0'); ?>
                            <span><?php echo esc_html($contact['address']); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Social Icons -->
                    <div class="flex gap-3">
                        <?php
                        $social = dst_get_social();
                        foreach ($social as $platform => $url):
                            if (!empty($url)):
                        ?>
                            <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center hover:bg-white/20 transition-all" aria-label="<?php echo esc_attr($platform); ?>">
                                <?php echo dst_get_icon($platform, 'w-5 h-5'); ?>
                            </a>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-bold mb-4" style="color: <?php echo esc_attr($heading_color); ?>;">Quick Links</h4>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer',
                        'container'      => false,
                        'menu_class'     => 'space-y-2',
                        'fallback_cb'    => false,
                        'depth'          => 1,
                        'link_before'    => '<span class="mega-footer-link transition-colors">',
                        'link_after'     => '</span>',
                    ]);
                    ?>
                </div>

                <!-- Services -->
                <div>
                    <h4 class="text-lg font-bold mb-4" style="color: <?php echo esc_attr($heading_color); ?>;">Services</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="mega-footer-link transition-colors">Web Design</a></li>
                        <li><a href="#" class="mega-footer-link transition-colors">Development</a></li>
                        <li><a href="#" class="mega-footer-link transition-colors">Digital Marketing</a></li>
                        <li><a href="#" class="mega-footer-link transition-colors">SEO Services</a></li>
                        <li><a href="#" class="mega-footer-link transition-colors">Consulting</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h4 class="text-lg font-bold mb-4" style="color: <?php echo esc_attr($heading_color); ?>;">Support</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="mega-footer-link transition-colors">Help Center</a></li>
                        <li><a href="#" class="mega-footer-link transition-colors">FAQ</a></li>
                        <li><a href="#" class="mega-footer-link transition-colors">Contact Us</a></li>
                        <li><a href="#" class="mega-footer-link transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="mega-footer-link transition-colors">Terms of Service</a></li>
                    </ul>
                </div>

                <?php if ($columns >= 5): ?>
                <!-- Resources -->
                <div>
                    <h4 class="text-lg font-bold mb-4" style="color: <?php echo esc_attr($heading_color); ?>;">Resources</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="mega-footer-link transition-colors">Blog</a></li>
                        <li><a href="#" class="mega-footer-link transition-colors">Case Studies</a></li>
                        <li><a href="#" class="mega-footer-link transition-colors">Documentation</a></li>
                        <li><a href="#" class="mega-footer-link transition-colors">API Reference</a></li>
                    </ul>
                </div>
                <?php endif; ?>

                <?php if ($columns >= 6): ?>
                <!-- Company -->
                <div>
                    <h4 class="text-lg font-bold mb-4" style="color: <?php echo esc_attr($heading_color); ?>;">Company</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="mega-footer-link transition-colors">About Us</a></li>
                        <li><a href="#" class="mega-footer-link transition-colors">Careers</a></li>
                        <li><a href="#" class="mega-footer-link transition-colors">Press</a></li>
                        <li><a href="#" class="mega-footer-link transition-colors">Partners</a></li>
                    </ul>
                </div>
                <?php endif; ?>

                <!-- Working Hours / App Downloads -->
                <?php if ($show_working_hours || $show_app_buttons): ?>
                <div>
                    <?php if ($show_working_hours): ?>
                        <h4 class="text-lg font-bold mb-4" style="color: <?php echo esc_attr($heading_color); ?>;">Working Hours</h4>
                        <div class="space-y-2 text-sm mb-6">
                            <?php
                            $hours_lines = explode("\n", $working_hours_text);
                            foreach ($hours_lines as $line):
                                if (trim($line)):
                            ?>
                                <div><?php echo esc_html($line); ?></div>
                            <?php
                                endif;
                            endforeach;
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($show_app_buttons): ?>
                        <h4 class="text-lg font-bold mb-4" style="color: <?php echo esc_attr($heading_color); ?>;">Download App</h4>
                        <div class="space-y-3">
                            <a href="<?php echo esc_url($ios_link); ?>" class="flex items-center gap-3 px-4 py-3 bg-white/10 rounded-lg hover:bg-white/20 transition-all">
                                <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
                                </svg>
                                <div class="text-left">
                                    <div class="text-xs opacity-80">Download on the</div>
                                    <div class="font-bold">App Store</div>
                                </div>
                            </a>
                            <a href="<?php echo esc_url($android_link); ?>" class="flex items-center gap-3 px-4 py-3 bg-white/10 rounded-lg hover:bg-white/20 transition-all">
                                <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M3,20.5V3.5C3,2.91 3.34,2.39 3.84,2.15L13.69,12L3.84,21.85C3.34,21.6 3,21.09 3,20.5M16.81,15.12L6.05,21.34L14.54,12.85L16.81,15.12M20.16,10.81C20.5,11.08 20.75,11.5 20.75,12C20.75,12.5 20.53,12.9 20.18,13.18L17.89,14.5L15.39,12L17.89,9.5L20.16,10.81M6.05,2.66L16.81,8.88L14.54,11.15L6.05,2.66Z"/>
                                </svg>
                                <div class="text-left">
                                    <div class="text-xs opacity-80">Get it on</div>
                                    <div class="font-bold">Google Play</div>
                                </div>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

            </div>

            <!-- Trust Badges & Payment Icons -->
            <?php if ($show_trust_badges || $show_payment_icons): ?>
                <div class="border-t border-white/10 pt-8 mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                        <?php if ($show_trust_badges): ?>
                        <div>
                            <h5 class="font-semibold mb-4 text-sm opacity-80">Security & Trust</h5>
                            <div class="flex flex-wrap gap-4">
                                <div class="px-4 py-2 bg-white/10 rounded-lg text-sm font-medium">
                                    <?php echo dst_get_icon('shield', 'w-4 h-4 inline-block mr-1'); ?>
                                    SSL Secure
                                </div>
                                <div class="px-4 py-2 bg-white/10 rounded-lg text-sm font-medium">
                                    <?php echo dst_get_icon('check-circle', 'w-4 h-4 inline-block mr-1'); ?>
                                    Verified
                                </div>
                                <div class="px-4 py-2 bg-white/10 rounded-lg text-sm font-medium">
                                    <?php echo dst_get_icon('lock', 'w-4 h-4 inline-block mr-1'); ?>
                                    Privacy Protected
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if ($show_payment_icons): ?>
                        <div>
                            <h5 class="font-semibold mb-4 text-sm opacity-80">We Accept</h5>
                            <div class="flex flex-wrap gap-3">
                                <div class="w-12 h-8 bg-white rounded flex items-center justify-center text-xs font-bold text-gray-800">VISA</div>
                                <div class="w-12 h-8 bg-white rounded flex items-center justify-center text-xs font-bold text-gray-800">MC</div>
                                <div class="w-12 h-8 bg-white rounded flex items-center justify-center text-xs font-bold text-blue-600">PayPal</div>
                                <div class="w-12 h-8 bg-white rounded flex items-center justify-center text-xs font-bold text-gray-800">AMEX</div>
                                <div class="w-12 h-8 bg-white rounded flex items-center justify-center text-xs font-bold text-gray-800">GPay</div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="py-6 border-t border-white/10" style="background-color: <?php echo esc_attr($bottom_bg_color); ?>;">
        <div class="hf-container max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm">
                <p>
                    &copy; <?php echo date('Y'); ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="mega-footer-link transition-colors font-semibold">
                        <?php bloginfo('name'); ?>
                    </a>
                    - All rights reserved.
                </p>

                <div class="flex items-center gap-6">
                    <a href="#" class="mega-footer-link transition-colors">Privacy Policy</a>
                    <a href="#" class="mega-footer-link transition-colors">Terms of Service</a>
                    <a href="#" class="mega-footer-link transition-colors">Cookie Policy</a>
                </div>
            </div>
        </div>
    </div>

</footer>
