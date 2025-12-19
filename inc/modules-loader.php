<?php
/**
 * Modules Loader - سیستم لود خودکار ماژول‌ها
 * 
 * ★★★ این فایل قلب سیستم ماژولار است ★★★
 * 
 * هر پوشه داخل /modules که شامل module.json باشد،
 * بصورت خودکار لود می‌شود.
 * 
 * ساختار هر ماژول:
 * ─────────────────────────────────────────
 * /modules/نام-ماژول/
 *   ├── module.json     ← تنظیمات (اجباری)
 *   ├── init.php        ← فایل اصلی (اجباری)
 *   ├── admin.php       ← بخش ادمین (اختیاری)
 *   ├── functions.php   ← توابع عمومی (اختیاری)
 *   ├── assets/         ← CSS & JS (اختیاری)
 *   │   ├── style.css
 *   │   └── script.js
 *   └── README.md       ← مستندات (اختیاری)
 * ─────────────────────────────────────────
 * 
 * @package Developer_Starter
 * @version 2.0.0
 */

defined('ABSPATH') || exit;

/**
 * کلاس مدیریت ماژول‌ها
 */
class DST_Module_Loader {
    
    /**
     * لیست ماژول‌های ثبت شده
     */
    private $registered_modules = [];
    
    /**
     * لیست ماژول‌های غیرفعال
     */
    private $disabled_modules = [];
    
    /**
     * مسیر پوشه ماژول‌ها
     */
    private $modules_path;
    
    /**
     * URL پوشه ماژول‌ها
     */
    private $modules_url;
    
    /**
     * سازنده
     */
    public function __construct() {
        $this->modules_path = DST_PATH . '/modules';
        $this->modules_url  = DST_URL . '/modules';
        
        // لود تنظیمات ماژول‌های غیرفعال
        $this->disabled_modules = get_option('dst_disabled_modules', []);
        
        // هوک‌ها
        add_action('after_setup_theme', [$this, 'load_modules'], 5);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_module_assets']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_module_admin_assets']);
    }
    
    /**
     * لود تمام ماژول‌ها
     */
    public function load_modules() {
        // چک وجود پوشه modules
        if (!is_dir($this->modules_path)) {
            mkdir($this->modules_path, 0755, true);
            return;
        }
        
        // پیدا کردن ماژول‌ها
        $module_folders = glob($this->modules_path . '/*', GLOB_ONLYDIR);
        
        if (!$module_folders) {
            return;
        }
        
        foreach ($module_folders as $folder) {
            $this->load_single_module($folder);
        }
        
        // اجرای هوک بعد از لود ماژول‌ها
        do_action('dst_modules_loaded', $this->registered_modules);
    }
    
    /**
     * لود یک ماژول
     */
    private function load_single_module($folder) {
        $module_name = basename($folder);
        $config_file = $folder . '/module.json';
        
        // چک وجود module.json
        if (!file_exists($config_file)) {
            $this->log_error($module_name, 'فایل module.json یافت نشد');
            return false;
        }
        
        // خواندن تنظیمات
        $config = json_decode(file_get_contents($config_file), true);
        
        if (!$config) {
            $this->log_error($module_name, 'فایل module.json معتبر نیست');
            return false;
        }
        
        // چک غیرفعال بودن
        if (in_array($module_name, $this->disabled_modules)) {
            return false;
        }
        
        // تنظیمات پیش‌فرض
        $config = wp_parse_args($config, [
            'name'         => $module_name,
            'title'        => ucfirst($module_name),
            'description'  => '',
            'version'      => '1.0.0',
            'author'       => '',
            'requires'     => [], // ماژول‌های مورد نیاز
            'php_version'  => '7.4',
            'wp_version'   => '6.0',
            'priority'     => 10, // اولویت لود
        ]);
        
        // چک نسخه PHP
        if (version_compare(PHP_VERSION, $config['php_version'], '<')) {
            $this->log_error($module_name, 
                sprintf('نیاز به PHP نسخه %s یا بالاتر', $config['php_version'])
            );
            return false;
        }
        
        // چک نسخه وردپرس
        global $wp_version;
        if (version_compare($wp_version, $config['wp_version'], '<')) {
            $this->log_error($module_name, 
                sprintf('نیاز به وردپرس نسخه %s یا بالاتر', $config['wp_version'])
            );
            return false;
        }
        
        // چک ماژول‌های مورد نیاز
        if (!empty($config['requires'])) {
            foreach ($config['requires'] as $required) {
                if (!isset($this->registered_modules[$required])) {
                    $this->log_error($module_name, 
                        sprintf('ماژول "%s" مورد نیاز است', $required)
                    );
                    return false;
                }
            }
        }
        
        // لود فایل اصلی
        $init_file = $folder . '/init.php';
        if (!file_exists($init_file)) {
            $this->log_error($module_name, 'فایل init.php یافت نشد');
            return false;
        }
        
        // ذخیره اطلاعات
        $this->registered_modules[$module_name] = [
            'path'   => $folder,
            'url'    => $this->modules_url . '/' . $module_name,
            'config' => $config,
        ];
        
        // لود فایل اصلی
        require_once $init_file;
        
        // لود توابع عمومی
        $functions_file = $folder . '/functions.php';
        if (file_exists($functions_file)) {
            require_once $functions_file;
        }
        
        // لود بخش ادمین
        if (is_admin()) {
            $admin_file = $folder . '/admin.php';
            if (file_exists($admin_file)) {
                require_once $admin_file;
            }
        }
        
        // اجرای هوک activation
        do_action("dst_module_{$module_name}_loaded", $config);
        
        return true;
    }
    
    /**
     * لود CSS و JS ماژول‌ها (Frontend)
     */
    public function enqueue_module_assets() {
        foreach ($this->registered_modules as $name => $module) {
            // CSS
            $css_file = $module['path'] . '/assets/style.css';
            if (file_exists($css_file)) {
                wp_enqueue_style(
                    'dst-module-' . $name,
                    $module['url'] . '/assets/style.css',
                    ['dst-main'],
                    $module['config']['version']
                );
            }
            
            // JS
            $js_file = $module['path'] . '/assets/script.js';
            if (file_exists($js_file)) {
                wp_enqueue_script(
                    'dst-module-' . $name,
                    $module['url'] . '/assets/script.js',
                    ['dst-main'],
                    $module['config']['version'],
                    true
                );
            }
        }
    }
    
    /**
     * لود CSS و JS ماژول‌ها (Admin)
     */
    public function enqueue_module_admin_assets() {
        foreach ($this->registered_modules as $name => $module) {
            // Admin CSS
            $css_file = $module['path'] . '/assets/admin.css';
            if (file_exists($css_file)) {
                wp_enqueue_style(
                    'dst-module-admin-' . $name,
                    $module['url'] . '/assets/admin.css',
                    [],
                    $module['config']['version']
                );
            }
            
            // Admin JS
            $js_file = $module['path'] . '/assets/admin.js';
            if (file_exists($js_file)) {
                wp_enqueue_script(
                    'dst-module-admin-' . $name,
                    $module['url'] . '/assets/admin.js',
                    ['jquery'],
                    $module['config']['version'],
                    true
                );
            }
        }
    }
    
    /**
     * فعال/غیرفعال کردن ماژول
     */
    public function toggle_module($module_name, $enable = true) {
        if ($enable) {
            // حذف از لیست غیرفعال‌ها
            $this->disabled_modules = array_diff($this->disabled_modules, [$module_name]);
        } else {
            // اضافه به لیست غیرفعال‌ها
            if (!in_array($module_name, $this->disabled_modules)) {
                $this->disabled_modules[] = $module_name;
            }
        }
        
        update_option('dst_disabled_modules', $this->disabled_modules);
        return true;
    }
    
    /**
     * چک فعال بودن ماژول
     */
    public function is_module_active($module_name) {
        return isset($this->registered_modules[$module_name]);
    }
    
    /**
     * گرفتن اطلاعات ماژول
     */
    public function get_module($module_name) {
        return $this->registered_modules[$module_name] ?? null;
    }
    
    /**
     * گرفتن تمام ماژول‌ها
     */
    public function get_modules() {
        return $this->registered_modules;
    }
    
    /**
     * ثبت خطا
     */
    private function log_error($module_name, $message) {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log(sprintf(
                '[DST Module Error] %s: %s',
                $module_name,
                $message
            ));
        }
        
        // نمایش در ادمین
        if (is_admin() && current_user_can('manage_options')) {
            add_action('admin_notices', function() use ($module_name, $message) {
                printf(
                    '<div class="notice notice-error"><p><strong>ماژول %s:</strong> %s</p></div>',
                    esc_html($module_name),
                    esc_html($message)
                );
            });
        }
    }
}

/**
 * توابع کمکی برای ماژول‌ها
 */

/**
 * گرفتن instance لودر ماژول‌ها
 */
function dst_modules() {
    global $dst_module_loader;
    return $dst_module_loader;
}

/**
 * چک کردن فعال بودن ماژول
 */
function dst_is_module_active($module_name) {
    return dst_modules()->is_module_active($module_name);
}

/**
 * گرفتن اطلاعات ماژول
 */
function dst_get_module($module_name) {
    return dst_modules()->get_module($module_name);
}

/**
 * گرفتن مسیر ماژول
 */
function dst_module_path($module_name, $file = '') {
    $module = dst_get_module($module_name);
    if (!$module) {
        return false;
    }
    
    return $file ? $module['path'] . '/' . ltrim($file, '/') : $module['path'];
}

/**
 * گرفتن URL ماژول
 */
function dst_module_url($module_name, $file = '') {
    $module = dst_get_module($module_name);
    if (!$module) {
        return false;
    }
    
    return $file ? $module['url'] . '/' . ltrim($file, '/') : $module['url'];
}

/**
 * راه‌اندازی
 */
global $dst_module_loader;
$dst_module_loader = new DST_Module_Loader();
