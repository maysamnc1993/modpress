<?php
/**
 * Footer Template: Standard
 * فوتر استاندارد - با ویجت‌ها
 */
defined('ABSPATH') || exit;

$settings = dst_get_footer_setting();
$bg_color = $settings['bg_color'] ?? '#111827';
$text_color = $settings['text_color'] ?? '#9ca3af';
$show_logo = $settings['show_logo'] ?? true;
$description = $settings['description'] ?? '';
$columns = $settings['columns'] ?? '4';
$show_socials = $settings['show_socials'] ?? true;
$copyright_text = $settings['copyright_text'] ?? 'تمامی حقوق محفوظ است.';
?>

<footer class="hf-footer hf-footer-standard" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;">
    <!-- Main Footer -->
    <div class="hf-footer-main">
        <div class="hf-container">
            <div class="hf-footer-grid hf-cols-<?php echo esc_attr($columns); ?>">
                <!-- Column 1: Logo & Description -->
                <div class="hf-footer-col hf-footer-about">
                    <?php if ($show_logo): ?>
                        <div class="hf-footer-logo">
                            <?php dst_logo('light'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($description): ?>
                        <p class="hf-footer-desc"><?php echo esc_html($description); ?></p>
                    <?php endif; ?>

                    <?php if ($show_socials && function_exists('dst_social_icons')): ?>
                        <div class="hf-footer-socials">
                            <?php dst_social_icons(); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Widget Areas -->
                <?php if (is_active_sidebar('footer-1')): ?>
                    <div class="hf-footer-col">
                        <?php dynamic_sidebar('footer-1'); ?>
                    </div>
                <?php endif; ?>

                <?php if ($columns >= 3 && is_active_sidebar('footer-2')): ?>
                    <div class="hf-footer-col">
                        <?php dynamic_sidebar('footer-2'); ?>
                    </div>
                <?php endif; ?>

                <?php if ($columns >= 4 && is_active_sidebar('footer-3')): ?>
                    <div class="hf-footer-col">
                        <?php dynamic_sidebar('footer-3'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Copyright Bar -->
    <div class="hf-footer-bottom">
        <div class="hf-container">
            <div class="hf-footer-bottom-inner">
                <div class="hf-copyright">
                    &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>.
                    <?php echo esc_html($copyright_text); ?>
                </div>

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
    </div>
</footer>
