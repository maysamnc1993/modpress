<?php
/**
 * Footer Template: Contact
 * فوتر با اطلاعات تماس
 */
defined('ABSPATH') || exit;

$settings = dst_get_footer_setting();
$bg_color = $settings['bg_color'] ?? '#1f2937';
$text_color = $settings['text_color'] ?? '#9ca3af';
$accent_color = $settings['accent_color'] ?? '#3C50E0';
$phone = $settings['phone'] ?? '';
$email = $settings['email'] ?? '';
$address = $settings['address'] ?? '';
$working_hours = $settings['working_hours'] ?? '';
$show_socials = $settings['show_socials'] ?? true;
$copyright_text = $settings['copyright_text'] ?? 'تمامی حقوق محفوظ است.';
?>

<footer class="hf-footer hf-footer-contact" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>; --hf-accent: <?php echo esc_attr($accent_color); ?>;">
    <!-- Contact Info Section -->
    <div class="hf-footer-contact-section">
        <div class="hf-container">
            <div class="hf-contact-grid">
                <!-- Phone -->
                <?php if ($phone): ?>
                    <div class="hf-contact-item">
                        <div class="hf-contact-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </div>
                        <div class="hf-contact-content">
                            <span class="hf-contact-label">تلفن تماس</span>
                            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>" class="hf-contact-value"><?php echo esc_html($phone); ?></a>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Email -->
                <?php if ($email): ?>
                    <div class="hf-contact-item">
                        <div class="hf-contact-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </div>
                        <div class="hf-contact-content">
                            <span class="hf-contact-label">ایمیل</span>
                            <a href="mailto:<?php echo esc_attr($email); ?>" class="hf-contact-value"><?php echo esc_html($email); ?></a>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Address -->
                <?php if ($address): ?>
                    <div class="hf-contact-item">
                        <div class="hf-contact-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                        <div class="hf-contact-content">
                            <span class="hf-contact-label">آدرس</span>
                            <span class="hf-contact-value"><?php echo esc_html($address); ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Working Hours -->
                <?php if ($working_hours): ?>
                    <div class="hf-contact-item">
                        <div class="hf-contact-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <div class="hf-contact-content">
                            <span class="hf-contact-label">ساعت کاری</span>
                            <span class="hf-contact-value"><?php echo esc_html($working_hours); ?></span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="hf-footer-bottom">
        <div class="hf-container">
            <div class="hf-footer-bottom-inner">
                <div class="hf-copyright">
                    &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>.
                    <?php echo esc_html($copyright_text); ?>
                </div>

                <?php if ($show_socials && function_exists('dst_social_icons')): ?>
                    <div class="hf-footer-socials">
                        <?php dst_social_icons(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</footer>
