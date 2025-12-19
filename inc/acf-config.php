<?php
/**
 * ACF Configuration - تنظیمات ACF
 * 
 * @package Developer_Starter
 */

defined('ABSPATH') || exit;

/**
 * محل ذخیره JSON فیلدها (برای Git)
 */
function dst_acf_json_save_point($path) {
    return DST_PATH . '/acf-json';
}
add_filter('acf/settings/save_json', 'dst_acf_json_save_point');

/**
 * محل خواندن JSON
 */
function dst_acf_json_load_point($paths) {
    unset($paths[0]);
    $paths[] = DST_PATH . '/acf-json';
    return $paths;
}
add_filter('acf/settings/load_json', 'dst_acf_json_load_point');

/**
 * صفحه تنظیمات قالب
 */
function dst_register_options_page() {
    if (!function_exists('acf_add_options_page')) {
        return;
    }
    
    // صفحه اصلی
    acf_add_options_page([
        'page_title' => __('تنظیمات قالب', 'developer-starter'),
        'menu_title' => __('تنظیمات قالب', 'developer-starter'),
        'menu_slug'  => 'theme-settings',
        'capability' => 'edit_posts',
        'redirect'   => false,
        'icon_url'   => 'dashicons-admin-customizer',
        'position'   => 2,
    ]);
    
    // زیر منوها
    acf_add_options_sub_page([
        'page_title'  => __('هدر و فوتر', 'developer-starter'),
        'menu_title'  => __('هدر و فوتر', 'developer-starter'),
        'parent_slug' => 'theme-settings',
    ]);
    
    acf_add_options_sub_page([
        'page_title'  => __('اطلاعات تماس', 'developer-starter'),
        'menu_title'  => __('اطلاعات تماس', 'developer-starter'),
        'parent_slug' => 'theme-settings',
    ]);
}
add_action('acf/init', 'dst_register_options_page');
