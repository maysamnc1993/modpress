<?php
/**
 * فوتر پیش‌فرض
 * چند ستونی با ویجت
 */
?>
<footer class="dst-footer dst-footer-default">
    <div class="dst-container">
        
        <!-- ستون‌های فوتر -->
        <div class="dst-footer-columns">
            
            <!-- ستون 1: درباره -->
            <div class="dst-footer-col">
                <div class="dst-footer-logo">
                    <?php if (has_custom_logo()): ?>
                        <?php the_custom_logo(); ?>
                    <?php else: ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <?php bloginfo('name'); ?>
                        </a>
                    <?php endif; ?>
                </div>
                <p class="dst-footer-desc">
                    <?php echo get_bloginfo('description'); ?>
                </p>
            </div>
            
            <!-- ستون 2: لینک‌های سریع -->
            <div class="dst-footer-col">
                <h4>لینک‌های سریع</h4>
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
            
            <!-- ستون 3: خدمات -->
            <div class="dst-footer-col">
                <h4>خدمات</h4>
                <?php
                wp_nav_menu([
                    'theme_location' => 'footer-services',
                    'container'      => false,
                    'menu_class'     => 'dst-footer-menu',
                    'fallback_cb'    => false,
                    'depth'          => 1,
                ]);
                ?>
            </div>
            
            <!-- ستون 4: تماس -->
            <div class="dst-footer-col">
                <h4>تماس با ما</h4>
                <ul class="dst-footer-contact">
                    <li>
                        <span class="icon">📍</span>
                        <span>تهران، ایران</span>
                    </li>
                    <li>
                        <span class="icon">📞</span>
                        <a href="tel:+982112345678">021-12345678</a>
                    </li>
                    <li>
                        <span class="icon">✉️</span>
                        <a href="mailto:info@example.com">info@example.com</a>
                    </li>
                </ul>
            </div>
            
        </div>
        
        <!-- نوار پایین -->
        <div class="dst-footer-bottom">
            <p class="dst-copyright">
                &copy; <?php echo date('Y'); ?> 
                <a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
                - تمامی حقوق محفوظ است.
            </p>
            
            <div class="dst-footer-social">
                <a href="#" aria-label="Instagram">📷</a>
                <a href="#" aria-label="Telegram">✈️</a>
                <a href="#" aria-label="Twitter">🐦</a>
            </div>
        </div>
        
    </div>
</footer>
