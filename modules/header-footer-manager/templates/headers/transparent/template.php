<?php
/**
 * هدر شفاف
 * مناسب برای صفحاتی که اسلایدر دارند
 */

// گرفتن تنظیمات
$show_cta = dst_get_header_setting('show_cta');
$cta_text = dst_get_header_setting('cta_text') ?: 'شروع کنید';
$cta_url = dst_get_header_setting('cta_url') ?: '#';
$sticky = dst_get_header_setting('sticky');
$bg_color = dst_get_header_setting('bg_color_on_scroll') ?: '#ffffff';

// کلاس‌های هدر
$header_classes = ['dst-header', 'dst-header-transparent'];
if ($sticky) {
    $header_classes[] = 'dst-header-sticky';
}
?>


<header  class="<?php echo esc_attr(implode(' ', $header_classes)); ?>" data-scroll-bg="<?php echo esc_attr($bg_color); ?>">
    <div class="container">
        <div class="row">

            <div class="col-2">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="dst-site-title">
                    <?php dst_logo(); ?>
                </a>
            </div>
            <div class="col-7">
                <nav class="dst-header-nav">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'dst-menu',
                    'fallback_cb'    => false,
                    'depth'          => 2,
                ]);
                ?>
            </nav>
            </div>
            <div class="col-2">
                <?php
                    dst_cta([
                        'type' => 'custom',
                        'text' => 'ثبت‌نام',
                        'url' => '/register',
                        'style' => 'gradient',
                        'size' => 'lg',
                        'icon' => 'arrow-left',
                    ]);
                ?>
            </div>

        </div>
    </div>
</header>

<header style="display:none;" class="<?php echo esc_attr(implode(' ', $header_classes)); ?>" data-scroll-bg="<?php echo esc_attr($bg_color); ?>">
    <div class="dst-container">
        <div class="dst-header-inner">
            
            <!-- لوگو -->
            <div class="dst-header-logo">
                <?php if (dst_logo()): ?>
                    <?php dst_logo(); ?>
                <?php else: ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="dst-site-title">
                        <?php bloginfo('name'); ?>
                    </a>
                <?php endif; ?>
            </div>
            
            <!-- منو -->
            <nav class="dst-header-nav">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'dst-menu',
                    'fallback_cb'    => false,
                    'depth'          => 2,
                ]);
                ?>
            </nav>
            
            <?php if ($show_cta): ?>
            <!-- دکمه CTA -->
            <div class="dst-header-cta">
                <a href="<?php echo esc_url($cta_url); ?>" class="dst-btn"><?php echo esc_html($cta_text); ?></a>
            </div>
            <?php endif; ?>
            
            <!-- دکمه موبایل -->
            <button class="dst-mobile-toggle" aria-label="منو">
                <span></span>
                <span></span>
                <span></span>
            </button>
            
        </div>
    </div>
    
    <!-- منوی موبایل -->
    <div class="dst-mobile-menu">
        <?php
        wp_nav_menu([
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => 'dst-mobile-nav',
            'fallback_cb'    => false,
        ]);
        ?>
    </div>
</header>
