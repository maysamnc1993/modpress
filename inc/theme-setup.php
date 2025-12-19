<?php
/**
 * Theme Setup - تنظیمات پایه قالب
 * 
 * @package Developer_Starter
 */

defined('ABSPATH') || exit;

/**
 * تنظیمات اولیه قالب
 */
function dst_theme_setup() {
    // پشتیبانی از زبان‌ها
    load_theme_textdomain('developer-starter', DST_PATH . '/languages');
    
    // تگ title خودکار
    add_theme_support('title-tag');
    
    // تصویر شاخص
    add_theme_support('post-thumbnails');
    
    // لوگوی سفارشی
    add_theme_support('custom-logo', [
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
    
    // HTML5
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);
    
    // ویرایشگر بلاک
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('editor-styles');
    
    // WooCommerce
    add_theme_support('woocommerce');
    
    // ثبت منوها
    register_nav_menus([
        'primary' => __('منوی اصلی', 'developer-starter'),
        'footer'  => __('منوی فوتر', 'developer-starter'),
        'mobile'  => __('منوی موبایل', 'developer-starter'),
    ]);
    
    // اندازه‌های تصویر
    add_image_size('dst-hero', 1920, 800, true);
    add_image_size('dst-card', 400, 300, true);
    add_image_size('dst-thumb', 150, 150, true);
}
add_action('after_setup_theme', 'dst_theme_setup');

/**
 * ثبت سایدبارها
 */
function dst_register_sidebars() {
    register_sidebar([
        'name'          => __('سایدبار اصلی', 'developer-starter'),
        'id'            => 'sidebar-main',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);
    
    // ستون‌های فوتر
    for ($i = 1; $i <= 4; $i++) {
        register_sidebar([
            'name'          => sprintf(__('فوتر %d', 'developer-starter'), $i),
            'id'            => 'footer-' . $i,
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        ]);
    }
}
add_action('widgets_init', 'dst_register_sidebars');
