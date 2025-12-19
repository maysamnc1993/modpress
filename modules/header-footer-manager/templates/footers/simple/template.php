<?php
/**
 * فوتر ساده
 * یک خطی
 */
?>
<footer class="dst-footer dst-footer-simple">
    <div class="dst-container">
        <div class="dst-footer-inner">
            
            <p class="dst-copyright">
                &copy; <?php echo date('Y'); ?> 
                <a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
            </p>
            
            <nav class="dst-footer-nav">
                <?php
                wp_nav_menu([
                    'theme_location' => 'footer',
                    'container'      => false,
                    'menu_class'     => 'dst-footer-menu',
                    'fallback_cb'    => false,
                    'depth'          => 1,
                ]);
                ?>
            </nav>
            
        </div>
    </div>
</footer>
