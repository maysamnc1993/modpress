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

/**
 * ═══════════════════════════════════════════════════════════════
 * توابع کمکی بلاک‌ها
 * ═══════════════════════════════════════════════════════════════
 */

/**
 * کلاس‌های بلاک
 */
function dst_block_classes($block, $base_class = '', $extra = []) {
    $classes = ['dst-block'];

    if ($base_class) {
        $classes[] = $base_class;
    }

    if (!empty($block['className'])) {
        $classes[] = $block['className'];
    }

    if (!empty($block['align'])) {
        $classes[] = 'align' . $block['align'];
    }

    $classes = array_merge($classes, $extra);

    return implode(' ', $classes);
}

/**
 * آیدی بلاک
 */
function dst_block_id($block, $prefix = 'dst-block') {
    return $prefix . '-' . $block['id'];
}

/**
 * لود assets بلاک
 */
function dst_block_assets($block_name, $css = true, $js = false) {
    $block_url = DST_URL . '/blocks/' . $block_name;
    $block_path = DST_PATH . '/blocks/' . $block_name;

    if ($css && file_exists($block_path . '/style.css')) {
        wp_enqueue_style(
            'dst-block-' . $block_name,
            $block_url . '/style.css',
            [],
            filemtime($block_path . '/style.css')
        );
    }

    if ($js && file_exists($block_path . '/script.js')) {
        wp_enqueue_script(
            'dst-block-' . $block_name,
            $block_url . '/script.js',
            [],
            filemtime($block_path . '/script.js'),
            true
        );
    }
}

/**
 * SVG آیکون‌های رایج
 */
function dst_icon($name, $class = 'w-6 h-6') {
    $icons = [
        'check' => '<svg class="' . esc_attr($class) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>',
        'star' => '<svg class="' . esc_attr($class) . '" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>',
        'arrow-right' => '<svg class="' . esc_attr($class) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>',
        'phone' => '<svg class="' . esc_attr($class) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>',
        'email' => '<svg class="' . esc_attr($class) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>',
        'location' => '<svg class="' . esc_attr($class) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
        'clock' => '<svg class="' . esc_attr($class) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        'users' => '<svg class="' . esc_attr($class) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>',
        'chart' => '<svg class="' . esc_attr($class) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>',
        'shield' => '<svg class="' . esc_attr($class) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>',
        'play' => '<svg class="' . esc_attr($class) . '" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>',
        'quote' => '<svg class="' . esc_attr($class) . '" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>',
    ];

    return $icons[$name] ?? '';
}
