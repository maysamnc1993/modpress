<?php
/**
 * Header Template: Centered
 * هدر وسط‌چین - لوگو وسط، منو پایین
 */
defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$bg_color = $settings['bg_color'] ?? '#ffffff';
$text_color = $settings['text_color'] ?? '#1f2937';
$show_topbar = $settings['show_topbar'] ?? true;
$phone = $settings['phone'] ?? '';
$email = $settings['email'] ?? '';
?>

<?php if ($show_topbar && ($phone || $email)): ?>
<div class="hf-topbar" style="background: #f3f4f6; color: #6b7280;">
    <div class="hf-container">
        <div class="hf-topbar-inner">
            <?php if ($phone): ?>
                <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>" class="hf-topbar-item">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    <?php echo esc_html($phone); ?>
                </a>
            <?php endif; ?>
            <?php if ($email): ?>
                <a href="mailto:<?php echo esc_attr($email); ?>" class="hf-topbar-item">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <?php echo esc_html($email); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<header class="hf-header hf-header-centered" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;">
    <div class="hf-container">
        <!-- Logo Row -->
        <div class="hf-logo-row">
            <div class="hf-logo">
                <?php dst_logo(); ?>
            </div>
        </div>

        <!-- Navigation Row -->
        <div class="hf-nav-row">
            <button class="hf-mobile-toggle" aria-label="منو" onclick="document.body.classList.toggle('hf-mobile-open')">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <nav class="hf-nav">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'hf-nav-menu',
                    'fallback_cb' => false,
                    'depth' => 2,
                ]);
                ?>
            </nav>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="hf-mobile-menu">
        <nav class="hf-mobile-nav">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container' => false,
                'menu_class' => 'hf-mobile-menu-list',
                'fallback_cb' => false,
            ]);
            ?>
        </nav>
    </div>
</header>
