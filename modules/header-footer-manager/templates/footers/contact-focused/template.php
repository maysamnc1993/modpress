<?php
/**
 * Footer Template: Contact Focused Footer
 * Large contact section footer with form, map, working hours, and detailed contact info
 */

defined('ABSPATH') || exit;

$settings = dst_get_footer_setting();
$show_contact_form = $settings['show_contact_form'] ?? true;
$form_style = $settings['form_style'] ?? 'inline';
$show_map = $settings['show_map'] ?? true;
$map_embed_code = $settings['map_embed_code'] ?? '';
$show_working_hours = $settings['show_working_hours'] ?? true;
$working_hours = $settings['working_hours'] ?? "Monday - Friday: 9:00 AM - 6:00 PM\nSaturday: 10:00 AM - 4:00 PM\nSunday: Closed";
$bg_color = $settings['bg_color'] ?? '#f8fafc';
$text_color = $settings['text_color'] ?? '#334155';
$heading_color = $settings['heading_color'] ?? '#0f172a';
$accent_color = $settings['accent_color'] ?? '#3b82f6';
$form_bg_color = $settings['form_bg_color'] ?? '#ffffff';
$bottom_bg_color = $settings['bottom_bg_color'] ?? '#e2e8f0';
$show_social = $settings['show_social'] ?? true;
$contact_heading = $settings['contact_heading'] ?? 'Get in Touch';
$contact_description = $settings['contact_description'] ?? "We'd love to hear from you. Reach out to us for any questions, comments, or concerns.";
$show_phone = $settings['show_phone'] ?? true;
$show_email = $settings['show_email'] ?? true;

$form_class = match($form_style) {
    'stacked' => 'flex-col',
    'minimal' => 'flex-row gap-2',
    default => 'flex-col md:flex-row'
};
?>

<style>
    .contact-footer-accent {
        color: <?php echo esc_attr($accent_color); ?>;
    }
    .contact-footer-link:hover {
        color: <?php echo esc_attr($accent_color); ?>;
    }
    .contact-footer-btn {
        background-color: <?php echo esc_attr($accent_color); ?>;
    }
    .contact-footer-btn:hover {
        opacity: 0.9;
    }
</style>

<footer class="hf-footer hf-footer-contact-focused" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;">

    <!-- Main Contact Section -->
    <div class="py-16">
        <div class="hf-container max-w-7xl mx-auto px-4">

            <!-- Header -->
            <div class="text-center mb-12 max-w-3xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-bold mb-4" style="color: <?php echo esc_attr($heading_color); ?>;">
                    <?php echo esc_html($contact_heading); ?>
                </h2>
                <p class="text-lg opacity-80">
                    <?php echo esc_html($contact_description); ?>
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-12">

                <!-- Contact Information & Form -->
                <div>
                    <!-- Contact Info Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                        <?php
                        $contact = dst_get_contact();

                        if ($show_phone && !empty($contact['phone'])):
                        ?>
                        <div class="p-6 rounded-xl border-2 border-gray-200 hover:border-opacity-60 transition-all" style="background-color: <?php echo esc_attr($form_bg_color); ?>; border-color: <?php echo esc_attr($accent_color); ?>20;">
                            <div class="w-12 h-12 rounded-lg mb-4 flex items-center justify-center" style="background-color: <?php echo esc_attr($accent_color); ?>20;">
                                <?php echo dst_get_icon('phone', 'w-6 h-6 contact-footer-accent'); ?>
                            </div>
                            <h4 class="font-bold mb-2" style="color: <?php echo esc_attr($heading_color); ?>;">Phone</h4>
                            <a href="tel:<?php echo esc_attr($contact['phone']); ?>" class="text-lg contact-footer-link transition-colors">
                                <?php echo esc_html($contact['phone']); ?>
                            </a>
                        </div>
                        <?php endif; ?>

                        <?php if ($show_email && !empty($contact['email'])): ?>
                        <div class="p-6 rounded-xl border-2 border-gray-200 hover:border-opacity-60 transition-all" style="background-color: <?php echo esc_attr($form_bg_color); ?>; border-color: <?php echo esc_attr($accent_color); ?>20;">
                            <div class="w-12 h-12 rounded-lg mb-4 flex items-center justify-center" style="background-color: <?php echo esc_attr($accent_color); ?>20;">
                                <?php echo dst_get_icon('mail', 'w-6 h-6 contact-footer-accent'); ?>
                            </div>
                            <h4 class="font-bold mb-2" style="color: <?php echo esc_attr($heading_color); ?>;">Email</h4>
                            <a href="mailto:<?php echo esc_attr($contact['email']); ?>" class="text-lg contact-footer-link transition-colors break-all">
                                <?php echo esc_html($contact['email']); ?>
                            </a>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($contact['address'])): ?>
                        <div class="p-6 rounded-xl border-2 border-gray-200 hover:border-opacity-60 transition-all md:col-span-2" style="background-color: <?php echo esc_attr($form_bg_color); ?>; border-color: <?php echo esc_attr($accent_color); ?>20;">
                            <div class="w-12 h-12 rounded-lg mb-4 flex items-center justify-center" style="background-color: <?php echo esc_attr($accent_color); ?>20;">
                                <?php echo dst_get_icon('location', 'w-6 h-6 contact-footer-accent'); ?>
                            </div>
                            <h4 class="font-bold mb-2" style="color: <?php echo esc_attr($heading_color); ?>;">Address</h4>
                            <p class="text-lg opacity-80">
                                <?php echo esc_html($contact['address']); ?>
                            </p>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Working Hours -->
                    <?php if ($show_working_hours): ?>
                    <div class="p-6 rounded-xl border-2 border-gray-200" style="background-color: <?php echo esc_attr($form_bg_color); ?>; border-color: <?php echo esc_attr($accent_color); ?>20;">
                        <h4 class="font-bold mb-4 flex items-center gap-2" style="color: <?php echo esc_attr($heading_color); ?>;">
                            <?php echo dst_get_icon('clock', 'w-5 h-5 contact-footer-accent'); ?>
                            Working Hours
                        </h4>
                        <div class="space-y-2">
                            <?php
                            $hours_lines = explode("\n", $working_hours);
                            foreach ($hours_lines as $line):
                                if (trim($line)):
                            ?>
                                <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-0">
                                    <span><?php echo esc_html($line); ?></span>
                                </div>
                            <?php
                                endif;
                            endforeach;
                            ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Contact Form or Map -->
                <div>
                    <?php if ($show_contact_form): ?>
                    <div class="p-8 rounded-xl border-2 border-gray-200" style="background-color: <?php echo esc_attr($form_bg_color); ?>; border-color: <?php echo esc_attr($accent_color); ?>20;">
                        <h3 class="text-2xl font-bold mb-6" style="color: <?php echo esc_attr($heading_color); ?>;">Send us a message</h3>

                        <form class="space-y-4" x-data="contactForm">
                            <div class="<?php echo $form_style === 'stacked' ? 'space-y-4' : 'grid grid-cols-2 gap-4'; ?>">
                                <div>
                                    <label class="block text-sm font-semibold mb-2" style="color: <?php echo esc_attr($heading_color); ?>;">Name</label>
                                    <input type="text" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-opacity-100 focus:outline-none transition-colors" style="border-color: <?php echo esc_attr($accent_color); ?>40;" placeholder="Your name">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold mb-2" style="color: <?php echo esc_attr($heading_color); ?>;">Email</label>
                                    <input type="email" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-opacity-100 focus:outline-none transition-colors" style="border-color: <?php echo esc_attr($accent_color); ?>40;" placeholder="Your email">
                                </div>
                            </div>

                            <?php if ($form_style !== 'minimal'): ?>
                            <div>
                                <label class="block text-sm font-semibold mb-2" style="color: <?php echo esc_attr($heading_color); ?>;">Subject</label>
                                <input type="text" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-opacity-100 focus:outline-none transition-colors" style="border-color: <?php echo esc_attr($accent_color); ?>40;" placeholder="Subject">
                            </div>
                            <?php endif; ?>

                            <div>
                                <label class="block text-sm font-semibold mb-2" style="color: <?php echo esc_attr($heading_color); ?>;">Message</label>
                                <textarea required rows="<?php echo $form_style === 'minimal' ? '3' : '5'; ?>" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-opacity-100 focus:outline-none transition-colors resize-none" style="border-color: <?php echo esc_attr($accent_color); ?>40;" placeholder="Your message"></textarea>
                            </div>

                            <button type="submit" class="w-full contact-footer-btn text-white px-8 py-4 rounded-lg font-bold hover:opacity-90 transition-all flex items-center justify-center gap-2">
                                <span>Send Message</span>
                                <?php echo dst_get_icon('arrow-right', 'w-5 h-5'); ?>
                            </button>
                        </form>
                    </div>
                    <?php elseif ($show_map): ?>
                    <div class="h-full min-h-[400px] rounded-xl overflow-hidden border-2 border-gray-200">
                        <?php if (!empty($map_embed_code)): ?>
                            <?php echo $map_embed_code; ?>
                        <?php else: ?>
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <div class="text-center p-8">
                                    <?php echo dst_get_icon('location', 'w-16 h-16 mx-auto mb-4 text-gray-400'); ?>
                                    <p class="text-gray-500 font-semibold">Map Placeholder</p>
                                    <p class="text-sm text-gray-400 mt-2">Add your map embed code in settings</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>

            </div>

            <!-- Quick Links & Social -->
            <div class="border-t border-gray-200 pt-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- About -->
                    <div>
                        <div class="mb-4">
                            <?php dst_the_logo('footer', 'h-10 w-auto max-w-[180px] object-contain'); ?>
                        </div>
                        <p class="text-sm opacity-80">
                            <?php echo get_bloginfo('description'); ?>
                        </p>
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
                            'link_before'    => '<span class="contact-footer-link transition-colors">',
                            'link_after'     => '</span>',
                        ]);
                        ?>
                    </div>

                    <!-- Social -->
                    <?php if ($show_social): ?>
                    <div>
                        <h4 class="font-bold mb-4" style="color: <?php echo esc_attr($heading_color); ?>;">Follow Us</h4>
                        <div class="flex gap-3">
                            <?php
                            $social = dst_get_social();
                            foreach ($social as $platform => $url):
                                if (!empty($url)):
                            ?>
                                <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-lg border-2 flex items-center justify-center hover:bg-opacity-10 transition-all" style="border-color: <?php echo esc_attr($accent_color); ?>40;" aria-label="<?php echo esc_attr($platform); ?>">
                                    <?php echo dst_get_icon($platform, 'w-5 h-5 contact-footer-accent'); ?>
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
    <div class="py-6 border-t border-gray-200" style="background-color: <?php echo esc_attr($bottom_bg_color); ?>;">
        <div class="hf-container max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm">
                <p>
                    &copy; <?php echo date('Y'); ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="contact-footer-link transition-colors font-semibold">
                        <?php bloginfo('name'); ?>
                    </a>
                    - All rights reserved.
                </p>

                <div class="flex items-center gap-6">
                    <a href="#" class="contact-footer-link transition-colors">Privacy Policy</a>
                    <a href="#" class="contact-footer-link transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </div>

</footer>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('contactForm', () => ({
        init() {
            // Contact form initialization
        }
    }));
});
</script>
