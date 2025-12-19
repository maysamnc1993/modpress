<?php
/**
 * Assets Loader - لود CSS و JavaScript
 * 
 * این فایل فایل‌های CSS و JS را بر اساس محیط لود می‌کند:
 * - Development: از Vite dev server
 * - Production: از پوشه dist
 * 
 * @package Developer_Starter
 */

defined('ABSPATH') || exit;

/**
 * چک کردن محیط Development
 * اگر Vite در حال اجراست، true برمی‌گرداند
 */
function dst_is_development() {
    // چک کردن فایل hot که Vite می‌سازد
    $hot_file = DST_PATH . '/assets/dist/.vite/manifest.json';
    
    // یا چک کردن با constant
    if (defined('DST_DEVELOPMENT') && DST_DEVELOPMENT) {
        return true;
    }
    
    return false;
}

/**
 * لود استایل‌ها و اسکریپت‌ها
 */
function dst_enqueue_assets() {
    
    if (dst_is_development()) {
        // ═══════════════════════════════════════
        // Development Mode (Vite Dev Server)
        // ═══════════════════════════════════════
        
        // Vite client
        wp_enqueue_script(
            'vite-client',
            'http://localhost:3000/@vite/client',
            [],
            null,
            false
        );
        
        // Main JS (شامل SCSS هم میشه)
        wp_enqueue_script(
            'dst-main',
            'http://localhost:3000/js/main.js',
            [],
            null,
            true
        );
        
    } else {
        // ═══════════════════════════════════════
        // Production Mode (Built Files)
        // ═══════════════════════════════════════
        
        // Grid System CSS
        wp_enqueue_style(
            'dst-grid',
            DST_URL . '/assets/css/grid.css',
            [],
            DST_VERSION
        );
        
        // CTA Components CSS
        wp_enqueue_style(
            'dst-cta',
            DST_URL . '/assets/css/components/cta.css',
            [],
            DST_VERSION
        );
        
        // CSS
        $css_file = DST_PATH . '/assets/dist/css/style.css';
        $css_version = file_exists($css_file) ? filemtime($css_file) : DST_VERSION;
        
        wp_enqueue_style(
            'dst-main',
            DST_URL . '/assets/dist/css/style.css',
            ['dst-grid'],
            $css_version
        );
        
        // JavaScript
        $js_file = DST_PATH . '/assets/dist/js/main.js';
        $js_version = file_exists($js_file) ? filemtime($js_file) : DST_VERSION;
        
        wp_enqueue_script(
            'dst-main',
            DST_URL . '/assets/dist/js/main.js',
            [],
            $js_version,
            true
        );
    }
    
    // متغیرها برای JS
    wp_localize_script('dst-main', 'dstConfig', [
        'ajaxUrl'   => admin_url('admin-ajax.php'),
        'nonce'     => wp_create_nonce('dst_nonce'),
        'siteUrl'   => home_url('/'),
        'themeUrl'  => DST_URL,
        'isRTL'     => is_rtl(),
        'isLoggedIn'=> is_user_logged_in(),
    ]);
}
add_action('wp_enqueue_scripts', 'dst_enqueue_assets');

/**
 * اضافه کردن type="module" به اسکریپت‌های Vite
 */
function dst_script_type_module($tag, $handle, $src) {
    $module_handles = ['dst-main', 'vite-client'];
    
    if (in_array($handle, $module_handles) && dst_is_development()) {
        return '<script type="module" src="' . esc_url($src) . '"></script>';
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'dst_script_type_module', 10, 3);

/**
 * Preload فونت‌ها
 */
function dst_preload_fonts() {
    ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php
}
add_action('wp_head', 'dst_preload_fonts', 1);

/**
 * لود استایل‌های ویرایشگر
 */
function dst_editor_styles() {
    // اگر فایل build شده وجود داره
    $editor_css = DST_PATH . '/assets/dist/css/style.css';
    
    if (file_exists($editor_css)) {
        add_editor_style('assets/dist/css/style.css');
    }
}
add_action('after_setup_theme', 'dst_editor_styles');
