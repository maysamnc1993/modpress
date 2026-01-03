<?php
/**
 * Footer Template: Simple
 * فوتر ساده - کپی‌رایت
 */
defined('ABSPATH') || exit;

$settings = dst_get_footer_setting();
$bg_color = $settings['bg_color'] ?? '#1f2937';
$text_color = $settings['text_color'] ?? '#9ca3af';
$copyright_text = $settings['copyright_text'] ?? 'تمامی حقوق محفوظ است.';
$show_socials = $settings['show_socials'] ?? false;
?>

<footer class="hf-footer hf-footer-simple" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;">
    <div class="hf-container">
        <div class="hf-footer-inner">
            <div class="hf-copyright">
                &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>.
                <?php echo esc_html($copyright_text); ?>
            </div>

            <?php if ($show_socials && function_exists('dst_social_icons')): ?>
                <div class="hf-socials">
                    <?php dst_social_icons(); ?>
                </div>
            <?php endif; ?>

            <?php if (has_nav_menu('footer')): ?>
                <nav class="hf-footer-nav">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer',
                        'container' => false,
                        'menu_class' => 'hf-footer-menu',
                        'depth' => 1,
                    ]);
                    ?>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</footer>
