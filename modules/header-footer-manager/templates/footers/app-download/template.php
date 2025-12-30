<?php
/**
 * Footer Template: App Download Footer
 * App download focused footer with large app mockup, store buttons, and QR code
 */

defined('ABSPATH') || exit;

$settings = dst_get_footer_setting();
$app_image = $settings['app_image'] ?? '';
$show_qr_code = $settings['show_qr_code'] ?? true;
$qr_code_image = $settings['qr_code_image'] ?? '';
$ios_link = $settings['ios_link'] ?? '#';
$android_link = $settings['android_link'] ?? '#';
$show_web_app = $settings['show_web_app'] ?? false;
$web_app_link = $settings['web_app_link'] ?? '#';
$app_heading = $settings['app_heading'] ?? 'Download Our Mobile App';
$app_description = $settings['app_description'] ?? 'Experience our platform on the go. Download our mobile app for iOS and Android devices.';
$show_features = $settings['show_features'] ?? true;
$bg_color = $settings['bg_color'] ?? '#0f172a';
$text_color = $settings['text_color'] ?? '#e2e8f0';
$heading_color = $settings['heading_color'] ?? '#ffffff';
$accent_color = $settings['accent_color'] ?? '#3b82f6';
$app_section_bg = $settings['app_section_bg'] ?? '#1e293b';
$bottom_bg_color = $settings['bottom_bg_color'] ?? '#020617';
$show_stats = $settings['show_stats'] ?? true;
?>

<style>
    .app-footer-accent {
        color: <?php echo esc_attr($accent_color); ?>;
    }
    .app-footer-link:hover {
        color: <?php echo esc_attr($accent_color); ?>;
    }
</style>

<footer class="hf-footer hf-footer-app-download" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;">

    <!-- App Download Section -->
    <div class="py-16 md:py-24">
        <div class="hf-container max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                <!-- Left: App Info & Download Buttons -->
                <div class="order-2 lg:order-1">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-6" style="color: <?php echo esc_attr($heading_color); ?>;">
                        <?php echo esc_html($app_heading); ?>
                    </h2>
                    <p class="text-lg md:text-xl mb-8 opacity-90 leading-relaxed">
                        <?php echo esc_html($app_description); ?>
                    </p>

                    <!-- Download Buttons -->
                    <div class="flex flex-wrap gap-4 mb-8">
                        <!-- iOS App Store Button -->
                        <a href="<?php echo esc_url($ios_link); ?>" class="flex items-center gap-4 px-6 py-4 rounded-xl transition-all hover:scale-105" style="background-color: <?php echo esc_attr($app_section_bg); ?>;">
                            <svg class="w-10 h-10" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
                            </svg>
                            <div class="text-left">
                                <div class="text-xs opacity-80">Download on the</div>
                                <div class="text-xl font-bold">App Store</div>
                            </div>
                        </a>

                        <!-- Google Play Button -->
                        <a href="<?php echo esc_url($android_link); ?>" class="flex items-center gap-4 px-6 py-4 rounded-xl transition-all hover:scale-105" style="background-color: <?php echo esc_attr($app_section_bg); ?>;">
                            <svg class="w-10 h-10" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M3,20.5V3.5C3,2.91 3.34,2.39 3.84,2.15L13.69,12L3.84,21.85C3.34,21.6 3,21.09 3,20.5M16.81,15.12L6.05,21.34L14.54,12.85L16.81,15.12M20.16,10.81C20.5,11.08 20.75,11.5 20.75,12C20.75,12.5 20.53,12.9 20.18,13.18L17.89,14.5L15.39,12L17.89,9.5L20.16,10.81M6.05,2.66L16.81,8.88L14.54,11.15L6.05,2.66Z"/>
                            </svg>
                            <div class="text-left">
                                <div class="text-xs opacity-80">Get it on</div>
                                <div class="text-xl font-bold">Google Play</div>
                            </div>
                        </a>

                        <?php if ($show_web_app): ?>
                        <!-- Web App Button -->
                        <a href="<?php echo esc_url($web_app_link); ?>" class="flex items-center gap-4 px-6 py-4 rounded-xl transition-all hover:scale-105" style="background-color: <?php echo esc_attr($accent_color); ?>;">
                            <svg class="w-10 h-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                            </svg>
                            <div class="text-left">
                                <div class="text-xs opacity-80">Launch</div>
                                <div class="text-xl font-bold">Web App</div>
                            </div>
                        </a>
                        <?php endif; ?>
                    </div>

                    <!-- QR Code -->
                    <?php if ($show_qr_code): ?>
                    <div class="flex items-center gap-4 p-6 rounded-xl" style="background-color: <?php echo esc_attr($app_section_bg); ?>;">
                        <div class="w-24 h-24 bg-white rounded-lg flex items-center justify-center flex-shrink-0">
                            <?php if (!empty($qr_code_image)): ?>
                                <img src="<?php echo esc_url($qr_code_image); ?>" alt="QR Code" class="w-full h-full object-cover rounded-lg">
                            <?php else: ?>
                                <svg class="w-16 h-16 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                </svg>
                            <?php endif; ?>
                        </div>
                        <div>
                            <h4 class="font-bold mb-1" style="color: <?php echo esc_attr($heading_color); ?>;">Scan to Download</h4>
                            <p class="text-sm opacity-80">Use your phone camera to scan the QR code</p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- App Stats -->
                    <?php if ($show_stats): ?>
                    <div class="grid grid-cols-3 gap-6 mt-8">
                        <div>
                            <div class="text-3xl font-bold mb-1" style="color: <?php echo esc_attr($accent_color); ?>;">4.8</div>
                            <div class="text-sm opacity-80">App Rating</div>
                            <div class="flex gap-1 mt-1">
                                <?php for ($i = 0; $i < 5; $i++): ?>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold mb-1" style="color: <?php echo esc_attr($accent_color); ?>;">1M+</div>
                            <div class="text-sm opacity-80">Downloads</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold mb-1" style="color: <?php echo esc_attr($accent_color); ?>;">50K+</div>
                            <div class="text-sm opacity-80">Reviews</div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Right: App Mockup -->
                <div class="order-1 lg:order-2 flex justify-center items-center">
                    <div class="relative max-w-md w-full">
                        <?php if (!empty($app_image)): ?>
                            <img src="<?php echo esc_url($app_image); ?>" alt="App Screenshot" class="w-full h-auto">
                        <?php else: ?>
                            <!-- Phone Mockup SVG -->
                            <div class="relative">
                                <svg viewBox="0 0 300 600" class="w-full h-auto drop-shadow-2xl">
                                    <!-- Phone frame -->
                                    <rect x="10" y="10" width="280" height="580" rx="30" fill="#1e293b" stroke="#334155" stroke-width="2"/>
                                    <!-- Screen -->
                                    <rect x="20" y="80" width="260" height="460" rx="10" fill="#0f172a"/>
                                    <!-- Notch -->
                                    <rect x="110" y="20" width="80" height="25" rx="12" fill="#0f172a"/>
                                    <!-- Screen content -->
                                    <rect x="40" y="100" width="220" height="40" rx="8" fill="<?php echo esc_attr($accent_color); ?>" opacity="0.3"/>
                                    <rect x="40" y="160" width="100" height="100" rx="8" fill="#334155" opacity="0.5"/>
                                    <rect x="160" y="160" width="100" height="100" rx="8" fill="#334155" opacity="0.5"/>
                                    <rect x="40" y="280" width="220" height="60" rx="8" fill="#334155" opacity="0.3"/>
                                    <rect x="40" y="360" width="220" height="60" rx="8" fill="#334155" opacity="0.3"/>
                                    <rect x="40" y="440" width="220" height="80" rx="8" fill="<?php echo esc_attr($accent_color); ?>" opacity="0.5"/>
                                    <!-- Home indicator -->
                                    <rect x="120" y="560" width="60" height="4" rx="2" fill="#64748b"/>
                                </svg>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

            <!-- App Features -->
            <?php if ($show_features): ?>
            <div class="mt-16 pt-16 border-t border-white/10">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center" style="background-color: <?php echo esc_attr($accent_color); ?>20;">
                            <?php echo dst_get_icon('zap', 'w-8 h-8 app-footer-accent'); ?>
                        </div>
                        <h4 class="font-bold mb-2" style="color: <?php echo esc_attr($heading_color); ?>;">Fast & Smooth</h4>
                        <p class="text-sm opacity-80">Lightning-fast performance on all devices</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center" style="background-color: <?php echo esc_attr($accent_color); ?>20;">
                            <?php echo dst_get_icon('shield', 'w-8 h-8 app-footer-accent'); ?>
                        </div>
                        <h4 class="font-bold mb-2" style="color: <?php echo esc_attr($heading_color); ?>;">Secure</h4>
                        <p class="text-sm opacity-80">Your data is protected with encryption</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center" style="background-color: <?php echo esc_attr($accent_color); ?>20;">
                            <?php echo dst_get_icon('bell', 'w-8 h-8 app-footer-accent'); ?>
                        </div>
                        <h4 class="font-bold mb-2" style="color: <?php echo esc_attr($heading_color); ?>;">Push Notifications</h4>
                        <p class="text-sm opacity-80">Stay updated with real-time alerts</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center" style="background-color: <?php echo esc_attr($accent_color); ?>20;">
                            <?php echo dst_get_icon('smartphone', 'w-8 h-8 app-footer-accent'); ?>
                        </div>
                        <h4 class="font-bold mb-2" style="color: <?php echo esc_attr($heading_color); ?>;">Offline Mode</h4>
                        <p class="text-sm opacity-80">Access your content without internet</p>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer Links Section -->
    <div class="py-12 border-t border-white/10">
        <div class="hf-container max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Logo & About -->
                <div>
                    <div class="mb-4">
                        <?php dst_the_logo('footer', 'h-10 w-auto max-w-[180px] object-contain brightness-0 invert'); ?>
                    </div>
                    <p class="text-sm opacity-80 mb-4">
                        <?php echo get_bloginfo('description'); ?>
                    </p>
                    <!-- Social Icons -->
                    <div class="flex gap-3">
                        <?php
                        $social = dst_get_social();
                        foreach ($social as $platform => $url):
                            if (!empty($url)):
                        ?>
                            <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center hover:bg-white/20 transition-all" aria-label="<?php echo esc_attr($platform); ?>">
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
                    <h4 class="font-bold mb-4" style="color: <?php echo esc_attr($heading_color); ?>;">Quick Links</h4>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer',
                        'container'      => false,
                        'menu_class'     => 'space-y-2 text-sm',
                        'fallback_cb'    => false,
                        'depth'          => 1,
                        'link_before'    => '<span class="opacity-80 hover:opacity-100 app-footer-link transition-all">',
                        'link_after'     => '</span>',
                    ]);
                    ?>
                </div>

                <!-- Support -->
                <div>
                    <h4 class="font-bold mb-4" style="color: <?php echo esc_attr($heading_color); ?>;">Support</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="opacity-80 hover:opacity-100 app-footer-link transition-all">Help Center</a></li>
                        <li><a href="#" class="opacity-80 hover:opacity-100 app-footer-link transition-all">Contact Us</a></li>
                        <li><a href="#" class="opacity-80 hover:opacity-100 app-footer-link transition-all">FAQ</a></li>
                        <li><a href="#" class="opacity-80 hover:opacity-100 app-footer-link transition-all">Report a Bug</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="font-bold mb-4" style="color: <?php echo esc_attr($heading_color); ?>;">Contact</h4>
                    <?php
                    $contact = dst_get_contact();
                    ?>
                    <ul class="space-y-3 text-sm">
                        <?php if (!empty($contact['email'])): ?>
                        <li class="flex items-start gap-2 opacity-80">
                            <?php echo dst_get_icon('mail', 'w-4 h-4 mt-0.5 flex-shrink-0'); ?>
                            <a href="mailto:<?php echo esc_attr($contact['email']); ?>" class="app-footer-link transition-all">
                                <?php echo esc_html($contact['email']); ?>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (!empty($contact['phone'])): ?>
                        <li class="flex items-start gap-2 opacity-80">
                            <?php echo dst_get_icon('phone', 'w-4 h-4 mt-0.5 flex-shrink-0'); ?>
                            <a href="tel:<?php echo esc_attr($contact['phone']); ?>" class="app-footer-link transition-all">
                                <?php echo esc_html($contact['phone']); ?>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="py-6 border-t border-white/10" style="background-color: <?php echo esc_attr($bottom_bg_color); ?>;">
        <div class="hf-container max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm opacity-80">
                <p>
                    &copy; <?php echo date('Y'); ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="app-footer-link transition-all font-semibold">
                        <?php bloginfo('name'); ?>
                    </a>
                    - All rights reserved.
                </p>

                <div class="flex items-center gap-6">
                    <a href="#" class="app-footer-link transition-all">Privacy Policy</a>
                    <a href="#" class="app-footer-link transition-all">Terms of Service</a>
                    <a href="#" class="app-footer-link transition-all">Cookie Policy</a>
                </div>
            </div>
        </div>
    </div>

</footer>
