</main>

<?php
/**
 * لود Footer از سازنده هدر/فوتر
 */
if (function_exists('dst_builder_footer')) {
    dst_builder_footer();
} else {
    // Fallback به footer پیش‌فرض
    ?>
    <footer class="dst-footer">
        <div class="dst-footer__container">
            <div class="dst-footer__widgets">
                <?php for ($i = 1; $i <= 4; $i++): ?>
                    <?php if (is_active_sidebar('footer-' . $i)): ?>
                    <div class="dst-footer__col">
                        <?php dynamic_sidebar('footer-' . $i); ?>
                    </div>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
            
            <div class="dst-footer__bottom">
                <p class="dst-footer__copyright">
                    &copy; <?php echo date('Y'); ?> 
                    <a href="<?php echo home_url('/'); ?>"><?php bloginfo('name'); ?></a>
                </p>
            </div>
        </div>
    </footer>
    <?php
}
?>

<?php wp_footer(); ?>
</body>
</html>
