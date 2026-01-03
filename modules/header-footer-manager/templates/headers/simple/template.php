<?php
/**
 * Header Template: Simple
 * هدر ساده - لوگو راست، منو چپ
 */
defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$bg_color = $settings['bg_color'] ?? '#ffffff';
$text_color = $settings['text_color'] ?? '#1f2937';
$show_cta = $settings['show_cta'] ?? false;
$cta_text = $settings['cta_text'] ?? 'تماس با ما';
$cta_url = $settings['cta_url'] ?? '/contact';
?>

<header class="hf-header hf-header-simple" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;">
    <div class="hf-container">
        <div class="hf-header-inner">
            <!-- Logo -->
            <div class="hf-logo">
                <?php dst_logo(); ?>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hf-nav hf-nav-desktop">
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

            <!-- CTA Button -->
            <?php if ($show_cta && $cta_text): ?>
                <a href="<?php echo esc_url($cta_url); ?>" class="hf-btn hf-btn-primary hf-cta-desktop">
                    <?php echo esc_html($cta_text); ?>
                </a>
            <?php endif; ?>

            <!-- Mobile Menu Toggle -->
            <button class="hf-mobile-toggle" aria-label="منو" onclick="document.body.classList.toggle('hf-mobile-open')">
                <span></span>
                <span></span>
                <span></span>
            </button>
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
                'depth' => 2,
            ]);
            ?>
        </nav>
        <?php if ($show_cta && $cta_text): ?>
            <a href="<?php echo esc_url($cta_url); ?>" class="hf-btn hf-btn-primary hf-mobile-cta">
                <?php echo esc_html($cta_text); ?>
            </a>
        <?php endif; ?>
    </div>
</header>
