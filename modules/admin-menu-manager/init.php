<?php
/**
 * ماژول مدیریت منوی ادمین
 * Admin Menu Manager Module
 * 
 * ترتیب منوها:
 * 1. پیشخوان
 * 2. ماژول‌ها
 * 3. تنظیمات وب‌سایت
 * ---جداکننده---
 * 4. نوشته‌ها
 * 5. رسانه
 * 6. برگه‌ها
 * 7. فهرست‌ها
 * ---جداکننده---
 * 8. کاربران
 * ---جداکننده---
 * 9. سایر (شامل بقیه منوها)
 * 
 * @package Developer_Starter
 * @subpackage Modules/Admin_Menu_Manager
 * @version 4.0.0
 */

defined('ABSPATH') || exit;

class DST_Admin_Menu_Manager {
    
    /**
     * مسیر ماژول
     */
    private $module_path;
    
    /**
     * URL ماژول
     */
    private $module_url;
    
    /**
     * منوهایی که باید در "سایر" قرار بگیرند
     */
    private $others_menus = [];
    
    /**
     * سازنده
     */
    public function __construct() {
        $module = dst_get_module('admin-menu-manager');
        if (!$module) {
            return;
        }
        
        $this->module_path = $module['path'];
        $this->module_url  = $module['url'];
        
        // هوک‌ها
        add_action('admin_menu', [$this, 'reorganize_admin_menu'], 9999);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);
    }
    
    /**
     * لود فایل‌های CSS و JS
     */
    public function enqueue_assets() {
        wp_enqueue_style(
            'dst-menu-style',
            $this->module_url . '/assets/css/menu-style.css',
            [],
            '4.0.0'
        );
        
        wp_enqueue_script(
            'dst-menu-click',
            $this->module_url . '/assets/js/menu-click.js',
            ['jquery'],
            '4.0.0',
            true
        );
    }
    
    /**
     * بازسازی کامل منوی ادمین
     */
    public function reorganize_admin_menu() {
        global $menu, $submenu;
        
        // ذخیره منوهای فعلی
        $original_menu = $menu;
        $original_submenu = $submenu;
        
        // پاک کردن منوی فعلی
        $menu = [];
        
        // === بخش اول: منوهای اصلی ===
        
        // 1. پیشخوان
        $this->restore_menu_item($original_menu, 'index.php', 2);
        
        // 2. ماژول‌ها
        // این منو فقط برای نمایش در سایدبار است
        // لینک واقعی با فیلتر admin_url تنظیم می‌شود
        global $menu;
        $menu[3] = [
            'ماژول‌ها',
            'manage_options',
            'themes.php?page=dst-modules',
            'ماژول‌ها',
            'menu-top menu-icon-generic',
            'menu-modules',
            'dashicons-screenoptions'
        ];
        
        // 3. تنظیمات وب‌سایت
        add_menu_page(
            'تنظیمات وب‌سایت',
            'تنظیمات وب‌سایت',
            'manage_options',
            'dst-website-settings',
            [$this, 'render_website_settings_page'],
            'dashicons-admin-generic',
            4
        );
        
        // زیرمنوهای تنظیمات وب‌سایت
        add_submenu_page(
            'dst-website-settings',
            'تنظیمات وب‌سایت',
            'داشبورد',
            'manage_options',
            'dst-website-settings'
        );
        
        // هدر و فوتر - لینک به صفحه ماژول header-footer-manager
        add_submenu_page(
            'dst-website-settings',
            'هدر و فوتر',
            'هدر و فوتر',
            'manage_options',
            'admin.php?page=dst-header-footer'
        );
        
        // تنظیمات قالب
        add_submenu_page(
            'dst-website-settings',
            'تنظیمات قالب',
            'تنظیمات قالب',
            'manage_options',
            'admin.php?page=dst-theme-settings'
        );
        
        add_submenu_page(
            'dst-website-settings',
            'هویت سایت',
            'هویت سایت',
            'manage_options',
            'customize.php?autofocus[section]=title_tagline'
        );
        
        // === جداکننده 1 ===
        $menu[5] = ['', 'read', 'separator1', '', 'wp-menu-separator'];
        
        // === بخش دوم: محتوا ===
        
        // 4. نوشته‌ها
        $this->restore_menu_item($original_menu, 'edit.php', 10);
        
        // 5. رسانه
        $this->restore_menu_item($original_menu, 'upload.php', 15);
        
        // 6. برگه‌ها
        $this->restore_menu_item($original_menu, 'edit.php?post_type=page', 20);
        
        // 7. فهرست‌ها
        add_menu_page(
            'فهرست‌ها',
            'فهرست‌ها',
            'edit_theme_options',
            'nav-menus.php',
            '',
            'dashicons-menu',
            25
        );
        
        // === جداکننده 2 ===
        $menu[26] = ['', 'read', 'separator2', '', 'wp-menu-separator'];
        
        // === بخش سوم: کاربران ===
        
        // 8. کاربران
        $this->restore_menu_item($original_menu, 'users.php', 30);
        
        // === جداکننده 3 ===
        $menu[35] = ['', 'read', 'separator3', '', 'wp-menu-separator'];
        
        // === بخش چهارم: سایر ===
        
        // 9. سایر - منوی والد
        add_menu_page(
            'سایر',
            'سایر',
            'read',
            'dst-others',
            [$this, 'render_others_page'],
            'dashicons-ellipsis',
            100
        );
        
        // جمع‌آوری بقیه منوها برای "سایر"
        $this->collect_other_menus($original_menu, $original_submenu);
        
        // مرتب‌سازی منو
        ksort($menu);
    }
    
    /**
     * بازگرداندن یک آیتم منو از منوی اصلی
     */
    private function restore_menu_item($original_menu, $slug, $position) {
        global $menu;
        
        foreach ($original_menu as $item) {
            if (isset($item[2]) && $item[2] === $slug) {
                $menu[$position] = $item;
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * جمع‌آوری منوهای دیگر برای قرار دادن در "سایر"
     */
    private function collect_other_menus($original_menu, $original_submenu) {
        // منوهایی که نباید در سایر باشند
        $excluded = [
            'index.php',           // پیشخوان
            'edit.php',            // نوشته‌ها
            'upload.php',          // رسانه
            'edit.php?post_type=page', // برگه‌ها
            'users.php',           // کاربران
            'nav-menus.php',       // فهرست‌ها (جداگانه اضافه شده)
            'dst-header-footer',   // هدر و فوتر (زیرمنوی تنظیمات وب‌سایت)
            'dst-theme-settings',  // تنظیمات قالب
            'separator1',
            'separator2',
            'separator3',
            'separator-last',
        ];
        
        foreach ($original_menu as $item) {
            if (!isset($item[2])) continue;
            
            $slug = $item[2];
            
            // رد کردن منوهای اصلی و جداکننده‌ها
            if (in_array($slug, $excluded)) continue;
            if (strpos($slug, 'separator') !== false) continue;
            if (strpos($slug, 'dst-') === 0) continue; // منوهای خود قالب
            
            // ذخیره برای نمایش در صفحه سایر
            $this->others_menus[] = [
                'title' => $item[0],
                'capability' => $item[1],
                'slug' => $slug,
                'icon' => $item[6] ?? 'dashicons-admin-generic',
            ];
            
            // اضافه به زیرمنوی سایر
            add_submenu_page(
                'dst-others',
                strip_tags($item[0]),
                $item[0],
                $item[1],
                $slug
            );
        }
    }
    
    /**
     * صفحه تنظیمات وب‌سایت
     */
    public function render_website_settings_page() {
        ?>
        <div class="wrap dst-settings-wrap">
            <h1>⚙️ تنظیمات وب‌سایت</h1>
            <p class="description">تنظیمات کلی قالب و وب‌سایت</p>
            
            <div class="dst-settings-grid">
                
                <a href="<?php echo admin_url('admin.php?page=dst-theme-settings'); ?>" class="dst-setting-card">
                    <span class="dashicons dashicons-art"></span>
                    <h3>تنظیمات قالب</h3>
                    <p>لوگو، رنگ‌بندی، فونت و تنظیمات عمومی</p>
                </a>
                
                <a href="<?php echo admin_url('admin.php?page=dst-header-footer'); ?>" class="dst-setting-card">
                    <span class="dashicons dashicons-admin-customizer"></span>
                    <h3>هدر و فوتر</h3>
                    <p>انتخاب نوع هدر و فوتر</p>
                </a>
                
                <a href="<?php echo admin_url('customize.php?autofocus[section]=title_tagline'); ?>" class="dst-setting-card">
                    <span class="dashicons dashicons-admin-site"></span>
                    <h3>هویت سایت</h3>
                    <p>عنوان سایت و توضیحات</p>
                </a>
                
                <a href="<?php echo admin_url('widgets.php'); ?>" class="dst-setting-card">
                    <span class="dashicons dashicons-screenoptions"></span>
                    <h3>ابزارک‌ها</h3>
                    <p>مدیریت ابزارک‌های سایدبار و فوتر</p>
                </a>
                
                <a href="<?php echo admin_url('nav-menus.php'); ?>" class="dst-setting-card">
                    <span class="dashicons dashicons-menu"></span>
                    <h3>فهرست‌ها</h3>
                    <p>مدیریت منوها و فهرست‌های سایت</p>
                </a>
                
            </div>
        </div>
        
        <style>
            .dst-settings-wrap {
                max-width: 1000px;
            }
            .dst-settings-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 20px;
                margin-top: 20px;
            }
            .dst-setting-card {
                background: #fff;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 24px;
                text-decoration: none;
                transition: all 0.3s;
                display: block;
            }
            .dst-setting-card:hover {
                border-color: #2271b1;
                box-shadow: 0 4px 12px rgba(0,0,0,0.08);
                transform: translateY(-2px);
            }
            .dst-setting-card .dashicons {
                font-size: 32px;
                width: 32px;
                height: 32px;
                color: #2271b1;
                margin-bottom: 12px;
            }
            .dst-setting-card h3 {
                margin: 0 0 8px 0;
                color: #1e293b;
                font-size: 16px;
            }
            .dst-setting-card p {
                margin: 0;
                color: #6b7280;
                font-size: 13px;
            }
        </style>
        <?php
    }
    
    /**
     * صفحه سایر - نمایش گرید منوها
     */
    public function render_others_page() {
        global $submenu;
        ?>
        <div class="wrap dst-others-wrap">
            <h1>📁 سایر</h1>
            <p class="description">دسترسی سریع به سایر بخش‌های مدیریت وردپرس</p>
            
            <div class="dst-others-grid">
                <?php
                if (isset($submenu['dst-others'])) {
                    foreach ($submenu['dst-others'] as $index => $item) {
                        // رد کردن اولین آیتم (خود صفحه سایر)
                        if ($index === 0) continue;
                        
                        $title = strip_tags($item[0]);
                        $capability = $item[1];
                        $slug = $item[2];
                        
                        if (!current_user_can($capability)) continue;
                        
                        // ساخت URL
                        if (strpos($slug, '.php') !== false) {
                            $url = admin_url($slug);
                        } else {
                            $url = admin_url('admin.php?page=' . $slug);
                        }
                        
                        // پیدا کردن آیکون
                        $icon = $this->get_menu_icon($slug);
                        ?>
                        <a href="<?php echo esc_url($url); ?>" class="dst-other-item">
                            <span class="dashicons <?php echo esc_attr($icon); ?>"></span>
                            <span class="dst-other-title"><?php echo esc_html($title); ?></span>
                        </a>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
        
        <style>
            .dst-others-wrap {
                max-width: 1200px;
            }
            .dst-others-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 16px;
                margin-top: 20px;
            }
            .dst-other-item {
                background: #fff;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 20px;
                text-decoration: none;
                display: flex;
                align-items: center;
                gap: 12px;
                transition: all 0.2s;
            }
            .dst-other-item:hover {
                border-color: #2271b1;
                background: #f8fafc;
            }
            .dst-other-item .dashicons {
                font-size: 24px;
                width: 24px;
                height: 24px;
                color: #64748b;
            }
            .dst-other-item:hover .dashicons {
                color: #2271b1;
            }
            .dst-other-title {
                color: #1e293b;
                font-size: 14px;
                font-weight: 500;
            }
        </style>
        <?php
    }
    
    /**
     * گرفتن آیکون مناسب برای هر منو
     */
    private function get_menu_icon($slug) {
        $icons = [
            'edit-comments.php' => 'dashicons-admin-comments',
            'themes.php' => 'dashicons-admin-appearance',
            'plugins.php' => 'dashicons-admin-plugins',
            'tools.php' => 'dashicons-admin-tools',
            'options-general.php' => 'dashicons-admin-settings',
            'woocommerce' => 'dashicons-cart',
            'wpcf7' => 'dashicons-email',
            'elementor' => 'dashicons-admin-customizer',
            'acf-options' => 'dashicons-admin-generic',
        ];
        
        foreach ($icons as $key => $icon) {
            if (strpos($slug, $key) !== false) {
                return $icon;
            }
        }
        
        return 'dashicons-admin-generic';
    }
}

// راه‌اندازی ماژول
new DST_Admin_Menu_Manager();
