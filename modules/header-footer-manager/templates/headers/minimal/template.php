<?php
/**
 * هدر مینیمال
 * ساده و تمیز
 */
?>
<header class="dst-header dst-header-minimal">
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
            
            <!-- منو -->
            <nav class="dst-header-nav">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'dst-menu',
                    'fallback_cb'    => false,
                    'depth'          => 1,
                ]);
                ?>
            </nav>
            
        </div>
    </div>
</header>
