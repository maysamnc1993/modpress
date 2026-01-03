<?php
/**
 * Footer Template: Minimal
 * فوتر مینیمال - یک خطی
 */
defined('ABSPATH') || exit;

$settings = dst_get_footer_setting();
$bg_color = $settings['bg_color'] ?? '#f9fafb';
$text_color = $settings['text_color'] ?? '#6b7280';
$border_top = $settings['border_top'] ?? true;
$show_logo = $settings['show_logo'] ?? false;
$copyright_text = $settings['copyright_text'] ?? 'تمامی حقوق محفوظ است.';
?>

<footer class="hf-footer hf-footer-minimal <?php echo $border_top ? 'hf-with-border' : ''; ?>"
        style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;">
    <div class="hf-container">
        <div class="hf-footer-inner">
            <?php if ($show_logo): ?>
                <div class="hf-footer-logo">
                    <?php dst_logo(); ?>
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

            <div class="hf-copyright">
                &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>.
                <?php echo esc_html($copyright_text); ?>
            </div>
        </div>
    </div>
</footer>
