<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="dst-header">
    <div class="dst-header__container">
        
        <!-- Logo -->
        <div class="dst-header__logo">
            <?php if (has_custom_logo()): ?>
                <?php the_custom_logo(); ?>
            <?php else: ?>
                <a href="<?php echo home_url('/'); ?>">
                    <?php bloginfo('name'); ?>
                </a>
            <?php endif; ?>
        </div>
        
        <!-- Navigation -->
        <nav class="dst-header__nav">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'dst-nav-menu',
                'fallback_cb'    => false,
            ]);
            ?>
        </nav>
        
        <!-- Mobile Toggle -->
        <button class="dst-header__toggle" aria-label="منو">
            <span></span>
            <span></span>
            <span></span>
        </button>
        
    </div>
</header>

<main class="dst-main">
