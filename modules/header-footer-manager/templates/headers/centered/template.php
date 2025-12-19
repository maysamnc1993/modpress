<?php
/**
 * هدر وسط‌چین
 * لوگو در وسط، منو زیر آن
 */
?>
<header class="dst-header dst-header-centered">
    <div class="dst-container">
        
        <!-- لوگو وسط -->
        <div class="dst-header-logo">
            <?php if (has_custom_logo()): ?>
                <?php the_custom_logo(); ?>
            <?php else: ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="dst-site-title">
                    <?php bloginfo('name'); ?>
                </a>
                <p class="dst-site-desc"><?php bloginfo('description'); ?></p>
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
        
        <!-- دکمه موبایل -->
        <button class="dst-mobile-toggle" aria-label="منو">
            <span></span>
            <span></span>
            <span></span>
        </button>
        
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
