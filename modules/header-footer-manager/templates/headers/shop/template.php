<?php
/**
 * Header Template: Shop
 * هدر فروشگاهی - با امکانات ووکامرس
 */
defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$bg_color = $settings['bg_color'] ?? '#ffffff';
$text_color = $settings['text_color'] ?? '#1f2937';
$show_search = $settings['show_search'] ?? true;
$show_cart = $settings['show_cart'] ?? true;
$show_account = $settings['show_account'] ?? true;
$show_wishlist = $settings['show_wishlist'] ?? false;
$is_sticky = $settings['sticky'] ?? false;

$cart_count = function_exists('WC') ? WC()->cart->get_cart_contents_count() : 0;
$cart_url = function_exists('wc_get_cart_url') ? wc_get_cart_url() : '#';
$account_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : wp_login_url();
?>

<header class="hf-header hf-header-shop <?php echo $is_sticky ? 'hf-header-sticky-shop' : ''; ?>"
        style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;">
    <div class="hf-container">
        <div class="hf-header-inner">
            <!-- Logo -->
            <div class="hf-logo">
                <?php dst_logo(); ?>
            </div>

            <!-- Search -->
            <?php if ($show_search): ?>
                <div class="hf-search">
                    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                        <input type="search" name="s" placeholder="جستجو در محصولات..." value="<?php echo get_search_query(); ?>">
                        <?php if (function_exists('WC')): ?>
                            <input type="hidden" name="post_type" value="product">
                        <?php endif; ?>
                        <button type="submit" aria-label="جستجو">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                        </button>
                    </form>
                </div>
            <?php endif; ?>

            <!-- Desktop Navigation -->
            <nav class="hf-nav hf-nav-desktop">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'hf-nav-menu',
                    'fallback_cb' => false,
                    'depth' => 2,
                ]);
                ?>
            </nav>

            <!-- Actions -->
            <div class="hf-actions">
                <?php if ($show_wishlist): ?>
                    <a href="<?php echo esc_url(home_url('/wishlist')); ?>" class="hf-icon-btn" title="علاقه‌مندی‌ها">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                    </a>
                <?php endif; ?>

                <?php if ($show_account): ?>
                    <a href="<?php echo esc_url($account_url); ?>" class="hf-icon-btn" title="<?php echo is_user_logged_in() ? 'حساب کاربری' : 'ورود'; ?>">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </a>
                <?php endif; ?>

                <?php if ($show_cart): ?>
                    <a href="<?php echo esc_url($cart_url); ?>" class="hf-icon-btn hf-cart-btn" title="سبد خرید">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        <?php if ($cart_count > 0): ?>
                            <span class="hf-cart-count"><?php echo $cart_count; ?></span>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>

                <!-- Mobile Menu Toggle -->
                <button class="hf-mobile-toggle" aria-label="منو" onclick="document.body.classList.toggle('hf-mobile-open')">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="hf-mobile-menu">
        <?php if ($show_search): ?>
            <div class="hf-mobile-search">
                <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                    <input type="search" name="s" placeholder="جستجو..." value="<?php echo get_search_query(); ?>">
                    <?php if (function_exists('WC')): ?>
                        <input type="hidden" name="post_type" value="product">
                    <?php endif; ?>
                    <button type="submit" aria-label="جستجو">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    </button>
                </form>
            </div>
        <?php endif; ?>

        <nav class="hf-mobile-nav">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container' => false,
                'menu_class' => 'hf-mobile-menu-list',
                'fallback_cb' => false,
            ]);
            ?>
        </nav>

        <div class="hf-mobile-actions">
            <?php if ($show_account): ?>
                <a href="<?php echo esc_url($account_url); ?>" class="hf-btn hf-btn-secondary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <?php echo is_user_logged_in() ? 'حساب من' : 'ورود'; ?>
                </a>
            <?php endif; ?>
            <?php if ($show_cart): ?>
                <a href="<?php echo esc_url($cart_url); ?>" class="hf-btn hf-btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    سبد خرید
                    <?php if ($cart_count > 0): ?>
                        <span>(<?php echo $cart_count; ?>)</span>
                    <?php endif; ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>
