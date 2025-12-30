<?php
/**
 * Footer Template: Wave Footer
 * Footer with decorative wave or curved top border SVG design
 */

defined('ABSPATH') || exit;

$settings = dst_get_footer_setting();
$wave_style = $settings['wave_style'] ?? 'wave1';
$wave_color = $settings['wave_color'] ?? '#ffffff';
$bg_color = $settings['bg_color'] ?? '#1e40af';
$text_color = $settings['text_color'] ?? '#ffffff';
$heading_color = $settings['heading_color'] ?? '#ffffff';
$link_color = $settings['link_color'] ?? '#93c5fd';
$link_hover_color = $settings['link_hover_color'] ?? '#ffffff';
$show_social = $settings['show_social'] ?? true;
$social_style = $settings['social_style'] ?? 'circle';
$show_contact = $settings['show_contact'] ?? true;
$columns = $settings['columns'] ?? '4';
$wave_height = $settings['wave_height'] ?? 'medium';
$wave_flip = $settings['wave_flip'] ?? false;
$bottom_bg_color = $settings['bottom_bg_color'] ?? '#1e3a8a';
$copyright_text = $settings['copyright_text'] ?? 'All rights reserved.';

$column_class = match($columns) {
    '2' => 'lg:grid-cols-2',
    '3' => 'lg:grid-cols-3',
    default => 'lg:grid-cols-4'
};

$wave_height_px = match($wave_height) {
    'small' => '80',
    'large' => '160',
    default => '120'
};

$social_icon_class = match($social_style) {
    'square' => 'rounded-none',
    'circle' => 'rounded-full',
    default => 'rounded-lg'
};

// Wave SVG paths
$wave_paths = [
    'wave1' => '<path d="M0,64L48,74.7C96,85,192,107,288,112C384,117,480,107,576,90.7C672,75,768,53,864,58.7C960,64,1056,96,1152,106.7C1248,117,1344,107,1392,101.3L1440,96L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z" fill="' . esc_attr($wave_color) . '"/>',
    'wave2' => '<path d="M0,32L60,48C120,64,240,96,360,96C480,96,600,64,720,58.7C840,53,960,75,1080,80C1200,85,1320,75,1380,69.3L1440,64L1440,0L1380,0C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0L0,0Z" fill="' . esc_attr($wave_color) . '"/>',
    'wave3' => '<path d="M0,64L48,58.7C96,53,192,43,288,58.7C384,75,480,117,576,122.7C672,128,768,96,864,74.7C960,53,1056,43,1152,48C1248,53,1344,75,1392,85.3L1440,96L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z" fill="' . esc_attr($wave_color) . '"/><path d="M0,32L48,42.7C96,53,192,75,288,80C384,85,480,75,576,64C672,53,768,43,864,48C960,53,1056,75,1152,80C1248,85,1344,75,1392,69.3L1440,64L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z" fill="' . esc_attr($wave_color) . '" opacity="0.5"/>',
    'curve' => '<path d="M0,96L1440,0L1440,0L0,0Z" fill="' . esc_attr($wave_color) . '"/>',
    'triangle' => '<path d="M0,0L720,' . $wave_height_px . 'L1440,0Z" fill="' . esc_attr($wave_color) . '"/>'
];

$wave_svg = $wave_paths[$wave_style] ?? $wave_paths['wave1'];
$flip_transform = $wave_flip ? 'transform: scaleY(-1);' : '';
?>

<style>
    .wave-footer-link {
        color: <?php echo esc_attr($link_color); ?>;
    }
    .wave-footer-link:hover {
        color: <?php echo esc_attr($link_hover_color); ?>;
    }
</style>

<footer class="hf-footer hf-footer-wave relative">

    <!-- Wave SVG -->
    <div class="relative" style="<?php echo $flip_transform; ?>">
        <svg class="w-full" style="height: <?php echo esc_attr($wave_height_px); ?>px; display: block;" viewBox="0 0 1440 <?php echo esc_attr($wave_height_px); ?>" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <?php echo $wave_svg; ?>
        </svg>
    </div>

    <!-- Main Footer Content -->
    <div class="py-16" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>; margin-top: -2px;">
        <div class="hf-container max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 <?php echo esc_attr($column_class); ?> gap-8 mb-12">

                <!-- About / Logo Column -->
                <div>
                    <div class="mb-6">
                        <?php dst_the_logo('footer', 'h-12 w-auto max-w-[200px] object-contain brightness-0 invert'); ?>
                    </div>
                    <p class="mb-6 leading-relaxed opacity-90 max-w-sm">
                        <?php echo get_bloginfo('description'); ?>
                    </p>

                    <?php if ($show_contact):
                        $contact = dst_get_contact();
                        if (!empty($contact)):
                    ?>
                    <div class="space-y-3">
                        <?php if (!empty($contact['phone'])): ?>
                        <div class="flex items-start gap-3 opacity-90">
                            <?php echo dst_get_icon('phone', 'w-5 h-5 mt-0.5 flex-shrink-0'); ?>
                            <a href="tel:<?php echo esc_attr($contact['phone']); ?>" class="wave-footer-link transition-colors">
                                <?php echo esc_html($contact['phone']); ?>
                            </a>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($contact['email'])): ?>
                        <div class="flex items-start gap-3 opacity-90">
                            <?php echo dst_get_icon('mail', 'w-5 h-5 mt-0.5 flex-shrink-0'); ?>
                            <a href="mailto:<?php echo esc_attr($contact['email']); ?>" class="wave-footer-link transition-colors">
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
                    <?php
                        endif;
                    endif;
                    ?>
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
                        'link_before'    => '<span class="wave-footer-link transition-colors">',
                        'link_after'     => '</span>',
                    ]);
                    ?>
                </div>

                <!-- Services -->
                <div>
                    <h4 class="text-lg font-bold mb-4" style="color: <?php echo esc_attr($heading_color); ?>;">Services</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="wave-footer-link transition-colors">Web Design</a></li>
                        <li><a href="#" class="wave-footer-link transition-colors">Development</a></li>
                        <li><a href="#" class="wave-footer-link transition-colors">Digital Marketing</a></li>
                        <li><a href="#" class="wave-footer-link transition-colors">SEO Services</a></li>
                        <li><a href="#" class="wave-footer-link transition-colors">Consulting</a></li>
                    </ul>
                </div>

                <!-- Newsletter / Social -->
                <div>
                    <h4 class="text-lg font-bold mb-4" style="color: <?php echo esc_attr($heading_color); ?>;">Stay Connected</h4>
                    <p class="mb-4 opacity-90">Subscribe to our newsletter for updates</p>

                    <div class="mb-6" x-data="newsletter">
                        <form @submit.prevent="subscribe" class="flex gap-2">
                            <input
                                type="email"
                                x-model="email"
                                :disabled="loading"
                                required
                                placeholder="Your email"
                                class="flex-1 px-4 py-2 rounded-lg bg-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/50 backdrop-blur-sm"
                            >
                            <button
                                type="submit"
                                :disabled="loading"
                                class="px-6 py-2 rounded-lg bg-white/30 hover:bg-white/40 disabled:opacity-50 transition-all backdrop-blur-sm font-medium"
                            >
                                <span x-show="!loading">Subscribe</span>
                                <span x-show="loading">...</span>
                            </button>
                        </form>
                        <div x-show="message" x-transition class="mt-2">
                            <p :class="success ? 'text-green-200' : 'text-red-200'" class="text-sm" x-text="message"></p>
                        </div>
                    </div>

                    <?php if ($show_social): ?>
                    <div>
                        <p class="mb-3 text-sm font-semibold opacity-90">Follow Us</p>
                        <div class="flex gap-3">
                            <?php
                            $social = dst_get_social();
                            foreach ($social as $platform => $url):
                                if (!empty($url)):
                            ?>
                                <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 <?php echo esc_attr($social_icon_class); ?> bg-white/20 flex items-center justify-center hover:bg-white/30 transition-all backdrop-blur-sm" aria-label="<?php echo esc_attr($platform); ?>">
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

    <!-- Bottom Bar -->
    <div class="py-6" style="background-color: <?php echo esc_attr($bottom_bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;">
        <div class="hf-container max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm opacity-90">
                <p>
                    &copy; <?php echo date('Y'); ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="wave-footer-link transition-colors font-semibold">
                        <?php bloginfo('name'); ?>
                    </a>
                    - <?php echo esc_html($copyright_text); ?>
                </p>

                <div class="flex items-center gap-6">
                    <a href="#" class="wave-footer-link transition-colors">Privacy Policy</a>
                    <a href="#" class="wave-footer-link transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </div>

</footer>
