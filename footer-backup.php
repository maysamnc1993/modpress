</main>

<footer class="dst-footer">
    <div class="dst-footer__container">
        
        <!-- Footer Widgets -->
        <div class="dst-footer__widgets">
            <?php for ($i = 1; $i <= 4; $i++): ?>
                <?php if (is_active_sidebar('footer-' . $i)): ?>
                <div class="dst-footer__col">
                    <?php dynamic_sidebar('footer-' . $i); ?>
                </div>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
        
        <!-- Footer Bottom -->
        <div class="dst-footer__bottom">
            <p class="dst-footer__copyright">
                &copy; <?php echo date('Y'); ?> 
                <a href="<?php echo home_url('/'); ?>"><?php bloginfo('name'); ?></a>
                - تمامی حقوق محفوظ است.
            </p>
            
            <?php if (has_nav_menu('footer')): ?>
            <nav class="dst-footer__nav">
                <?php
                wp_nav_menu([
                    'theme_location' => 'footer',
                    'container'      => false,
                    'menu_class'     => 'dst-footer-menu',
                    'depth'          => 1,
                ]);
                ?>
            </nav>
            <?php endif; ?>
        </div>
        
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
