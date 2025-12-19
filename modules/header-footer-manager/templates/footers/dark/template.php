<?php
/**
 * فوتر تیره
 */
?>
<footer class="dst-footer dst-footer-dark">
    <div class="dst-container">
        
        <div class="dst-footer-top">
            
            <!-- لوگو و توضیحات -->
            <div class="dst-footer-brand">
                <div class="dst-footer-logo">
                    <?php if (has_custom_logo()): ?>
                        <?php the_custom_logo(); ?>
                    <?php else: ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <?php bloginfo('name'); ?>
                        </a>
                    <?php endif; ?>
                </div>
                <p><?php echo get_bloginfo('description'); ?></p>
                
                <!-- شبکه‌های اجتماعی -->
                <div class="dst-footer-social">
                    <a href="#" aria-label="Instagram">📷</a>
                    <a href="#" aria-label="Telegram">✈️</a>
                    <a href="#" aria-label="LinkedIn">💼</a>
                </div>
            </div>
            
            <!-- منوها -->
            <div class="dst-footer-menus">
                <div class="dst-footer-menu-col">
                    <h4>صفحات</h4>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer',
                        'container'      => false,
                        'menu_class'     => 'dst-footer-menu',
                        'fallback_cb'    => false,
                        'depth'          => 1,
                    ]);
                    ?>
                </div>
                
                <div class="dst-footer-menu-col">
                    <h4>تماس</h4>
                    <ul class="dst-footer-menu">
                        <li><a href="mailto:info@example.com">info@example.com</a></li>
                        <li><a href="tel:+982112345678">021-12345678</a></li>
                        <li><span>تهران، ایران</span></li>
                    </ul>
                </div>
            </div>
            
        </div>
        
        <!-- نوار پایین -->
        <div class="dst-footer-bottom">
            <p>
                &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?> - 
                طراحی با ❤️
            </p>
        </div>
        
    </div>
</footer>
