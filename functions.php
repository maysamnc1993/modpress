<?php
/**
 * Developer Starter Theme - Functions
 * 
 * این فایل نقطه ورود اصلی قالب است.
 * تمام فایل‌های مورد نیاز از اینجا لود می‌شوند.
 * 
 * @package Developer_Starter
 * @version 1.0.0
 */

defined('ABSPATH') || exit;

/**
 * ═══════════════════════════════════════════════════════════════
 * ثابت‌های قالب
 * ═══════════════════════════════════════════════════════════════
 */
define('DST_VERSION', '1.0.0');
define('DST_PATH', get_template_directory());
define('DST_URL', get_template_directory_uri());
define('DST_BLOCKS_PATH', DST_PATH . '/blocks');

/**
 * ═══════════════════════════════════════════════════════════════
 * لود فایل‌های هسته
 * ═══════════════════════════════════════════════════════════════
 */

// تنظیمات پایه قالب
require_once DST_PATH . '/inc/theme-setup.php';

// لود CSS و JS
require_once DST_PATH . '/inc/assets-loader.php';

// سیستم لود خودکار بلاک‌های ACF
require_once DST_PATH . '/inc/blocks-loader.php';

// سیستم لود خودکار ماژول‌ها
require_once DST_PATH . '/inc/modules-loader.php';

// صفحه مدیریت ماژول‌ها در ادمین
require_once DST_PATH . '/inc/modules-admin.php';

// تنظیمات ACF
require_once DST_PATH . '/inc/acf-config.php';

// توابع کمکی
require_once DST_PATH . '/inc/helpers.php';

// توابع WooCommerce برای هدر و فوتر
require_once DST_PATH . '/inc/woocommerce-helpers.php';
