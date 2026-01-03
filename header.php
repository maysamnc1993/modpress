<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
/**
 * لود Header از سازنده هدر/فوتر
 */
if (function_exists('dst_builder_header')) {
    dst_builder_header();
} else {
    // Fallback به header پیش‌فرض
    ?>
    <header class="dst-header">
        <div class="dst-header__container">
            <div class="dst-header__logo">
                <?php if (has_custom_logo()): ?>
                    <?php the_custom_logo(); ?>
                <?php else: ?>
                    <a href="<?php echo home_url('/'); ?>">
                        <?php bloginfo('name'); ?>
                    </a>
                <?php endif; ?>
            </div>
            
            <nav class="dst-header__nav">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'dst-nav-menu',
                ]);
                ?>
            </nav>
            
            <button class="dst-header__toggle" aria-label="منو">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </header>
    <?php
}
?>

<main class="dst-main">
