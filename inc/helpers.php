<?php
/**
 * Helper Functions - توابع کمکی
 * 
 * @package Developer_Starter
 */

defined('ABSPATH') || exit;

/**
 * گرفتن فیلد با مقدار پیش‌فرض
 */
function dst_field($name, $default = '', $post_id = false) {
    if (!function_exists('get_field')) {
        return $default;
    }
    $value = get_field($name, $post_id);
    return $value ?: $default;
}

/**
 * گرفتن آپشن با مقدار پیش‌فرض
 */
function dst_option($name, $default = '') {
    if (!function_exists('get_field')) {
        return $default;
    }
    $value = get_field($name, 'option');
    return $value ?: $default;
}

/**
 * نمایش کامپوننت
 */
function dst_component($name, $args = []) {
    $file = DST_PATH . '/components/' . $name . '.php';
    if (file_exists($file)) {
        extract($args);
        include $file;
    }
}

/**
 * تبدیل اعداد به فارسی
 */
function dst_fa_num($string) {
    $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    return str_replace($english, $persian, $string);
}

/**
 * فرمت قیمت
 */
function dst_price($price) {
    return dst_fa_num(number_format($price)) . ' تومان';
}

/**
 * کوتاه کردن متن
 */
function dst_truncate($text, $length = 100, $end = '...') {
    $text = strip_tags($text);
    if (mb_strlen($text) <= $length) {
        return $text;
    }
    return mb_substr($text, 0, $length) . $end;
}

/**
 * دیباگ
 */
function dst_debug($var, $die = false) {
    if (!WP_DEBUG) return;
    
    echo '<pre style="direction:ltr;text-align:left;background:#1e1e1e;color:#fff;padding:20px;margin:20px;border-radius:8px;overflow:auto;">';
    print_r($var);
    echo '</pre>';
    
    if ($die) die();
}
