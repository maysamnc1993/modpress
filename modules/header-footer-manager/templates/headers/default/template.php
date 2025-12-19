<?php
/**
 * هدر پیش‌فرض
 * لوگو سمت راست، منو سمت چپ
 */
?>
<header class="dst-header dst-header-default">
    <div class="dst-container">
        <div class="dst-header-inner">
            
            <!-- لوگو -->
            <div class="dst-header-logo">
                <?php if (has_custom_logo()): ?>
                    <?php the_custom_logo(); ?>
                <?php else: ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="dst-site-title">
                        <?php bloginfo('name'); ?>
                    </a>
                <?php endif; ?>
            </div>
            
            <!-- منوی اصلی -->
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
        <div class="dst-mobile-menu-inner">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'dst-mobile-nav',
                'fallback_cb'    => false,
                'depth'          => 2,
            ]);
            ?>
        </div>
    </div>
</header>
