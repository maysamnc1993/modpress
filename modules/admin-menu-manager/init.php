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
     * تنظیمات مخفی کردن منوها
     */
    private $hidden_menus = [];

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

        // بارگذاری تنظیمات
        $this->hidden_menus = get_option('dst_hidden_menus', []);

        // هوک‌ها
        add_action('admin_menu', [$this, 'add_settings_page'], 99);
        add_action('admin_menu', [$this, 'reorganize_admin_menu'], 9999);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('wp_ajax_dst_save_menu_settings', [$this, 'ajax_save_settings']);
    }

    /**
     * ثبت تنظیمات
     */
    public function register_settings() {
        register_setting('dst_menu_settings', 'dst_hidden_menus');
    }

    /**
     * اضافه کردن صفحه تنظیمات منو
     */
    public function add_settings_page() {
        add_submenu_page(
            'dst-website-settings',
            'تنظیمات منو',
            'تنظیمات منو',
            'manage_options',
            'dst-menu-settings',
            [$this, 'render_settings_page']
        );
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

        // بررسی اگر منو مخفی است
        if (in_array($slug, $this->hidden_menus)) {
            return false;
        }

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
        global $submenu;

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
            if (in_array($slug, $this->hidden_menus)) continue; // منوهای مخفی

            // ساخت URL صحیح
            $url = $this->build_menu_url($slug);

            // ذخیره برای نمایش در صفحه سایر
            $this->others_menus[] = [
                'title' => strip_tags($item[0]),
                'capability' => $item[1],
                'slug' => $slug,
                'url' => $url,
                'icon' => $item[6] ?? 'dashicons-admin-generic',
            ];
        }

        // اضافه کردن زیرمنوها با لینک مستقیم
        if (!isset($submenu['dst-others'])) {
            $submenu['dst-others'] = [];
        }

        // اولین آیتم باید خود صفحه سایر باشد
        $submenu['dst-others'][] = [
            'همه موارد',
            'read',
            'dst-others',
        ];

        // اضافه کردن لینک‌های مستقیم به زیرمنو
        foreach ($this->others_menus as $menu_item) {
            if (!current_user_can($menu_item['capability'])) continue;

            $submenu['dst-others'][] = [
                $menu_item['title'],
                $menu_item['capability'],
                $menu_item['url'],
            ];
        }
    }

    /**
     * ساخت URL صحیح برای یک slug منو
     */
    private function build_menu_url($slug) {
        // اگر فایل PHP است
        if (strpos($slug, '.php') !== false) {
            return admin_url($slug);
        }

        // اگر URL کامل است
        if (strpos($slug, 'http') === 0) {
            return $slug;
        }

        // در غیر این صورت admin.php?page=
        return admin_url('admin.php?page=' . $slug);
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
        ?>
        <div class="wrap dst-others-wrap">
            <div class="dst-others-header">
                <h1>
                    <i data-lucide="more-horizontal"></i>
                    سایر
                </h1>
                <p class="description">دسترسی سریع به سایر بخش‌های مدیریت وردپرس</p>
            </div>

            <?php if (empty($this->others_menus)): ?>
                <div class="dst-others-empty">
                    <i data-lucide="inbox"></i>
                    <p>هیچ منوی دیگری وجود ندارد</p>
                </div>
            <?php else: ?>
                <div class="dst-others-grid">
                    <?php foreach ($this->others_menus as $menu_item):
                        if (!current_user_can($menu_item['capability'])) continue;
                        $lucide_icon = $this->get_lucide_icon($menu_item['slug']);
                        ?>
                        <a href="<?php echo esc_url($menu_item['url']); ?>" class="dst-other-item">
                            <span class="dst-other-icon">
                                <i data-lucide="<?php echo esc_attr($lucide_icon); ?>"></i>
                            </span>
                            <span class="dst-other-title"><?php echo esc_html($menu_item['title']); ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <style>
            .dst-others-wrap {
                max-width: 1200px;
                margin: 20px auto 0;
            }
            .dst-others-header {
                margin-bottom: 30px;
            }
            .dst-others-header h1 {
                display: flex;
                align-items: center;
                gap: 12px;
                font-size: 24px;
                font-weight: 600;
                color: #1e293b;
                margin: 0 0 8px;
            }
            .dst-others-header h1 svg {
                width: 28px;
                height: 28px;
                stroke: #3C50E0;
            }
            .dst-others-header .description {
                font-size: 14px;
                color: #64748b;
                margin: 0;
            }
            .dst-others-empty {
                text-align: center;
                padding: 60px 20px;
                background: #fff;
                border: 1px dashed #e2e8f0;
                border-radius: 12px;
            }
            .dst-others-empty svg {
                width: 48px;
                height: 48px;
                stroke: #94a3b8;
                margin-bottom: 16px;
            }
            .dst-others-empty p {
                color: #64748b;
                font-size: 15px;
                margin: 0;
            }
            .dst-others-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
                gap: 16px;
            }
            .dst-other-item {
                background: #fff;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                padding: 20px;
                text-decoration: none;
                display: flex;
                align-items: center;
                gap: 14px;
                transition: all 0.2s ease;
            }
            .dst-other-item:hover {
                border-color: #3C50E0;
                background: #f8fafc;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(60, 80, 224, 0.1);
            }
            .dst-other-icon {
                width: 44px;
                height: 44px;
                background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.2s ease;
            }
            .dst-other-icon svg {
                width: 22px;
                height: 22px;
                stroke: #64748b;
                transition: all 0.2s ease;
            }
            .dst-other-item:hover .dst-other-icon {
                background: linear-gradient(135deg, #3C50E0 0%, #5B6CE0 100%);
            }
            .dst-other-item:hover .dst-other-icon svg {
                stroke: #fff;
            }
            .dst-other-title {
                color: #1e293b;
                font-size: 14px;
                font-weight: 500;
                flex: 1;
            }
            .dst-other-item:hover .dst-other-title {
                color: #3C50E0;
            }
            @media screen and (max-width: 782px) {
                .dst-others-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
        </script>
        <?php
    }

    /**
     * گرفتن آیکون Lucide مناسب برای هر منو
     */
    private function get_lucide_icon($slug) {
        $icons = [
            // وردپرس
            'edit-comments.php' => 'message-square',
            'themes.php' => 'palette',
            'plugins.php' => 'plug',
            'tools.php' => 'wrench',
            'options-general.php' => 'settings',
            'widgets.php' => 'layout-grid',
            'customize.php' => 'brush',
            'theme-editor.php' => 'code',
            'plugin-editor.php' => 'code-2',
            'update-core.php' => 'download-cloud',
            'site-health.php' => 'activity',

            // ووکامرس
            'woocommerce' => 'shopping-cart',
            'wc-admin' => 'bar-chart-3',
            'wc-settings' => 'settings',
            'wc-status' => 'activity',
            'edit.php?post_type=product' => 'package',

            // ACF
            'edit.php?post_type=acf-field-group' => 'layers',
            'acf-tools' => 'database',

            // سئو
            'wpseo_dashboard' => 'search',
            'rank-math' => 'bar-chart-2',

            // فرم‌ها
            'wpcf7' => 'mail',
            'wpforms-overview' => 'file-input',
            'gf_edit_forms' => 'clipboard-list',
            'ninja-forms' => 'file-edit',

            // المنتور
            'elementor' => 'box',

            // کش و عملکرد
            'wp-rocket' => 'rocket',
            'w3tc_dashboard' => 'zap',
            'litespeed' => 'gauge',

            // امنیت
            'wordfence' => 'shield',
            'sucuri' => 'lock',
            'itsec' => 'shield-check',

            // بکاپ
            'updraftplus' => 'hard-drive',
            'duplicator' => 'copy',
        ];

        foreach ($icons as $key => $icon) {
            if (strpos($slug, $key) !== false) {
                return $icon;
            }
        }

        return 'circle';
    }

    /**
     * صفحه تنظیمات منو
     */
    public function render_settings_page() {
        global $menu;

        // لیست همه منوها
        $all_menus = $this->get_all_menu_items();
        $hidden = $this->hidden_menus;
        ?>
        <div class="wrap dst-menu-settings-wrap">
            <div class="dst-menu-settings-header">
                <h1>
                    <i data-lucide="settings-2"></i>
                    تنظیمات منو
                </h1>
                <p class="description">منوهایی که می‌خواهید مخفی شوند را انتخاب کنید</p>
            </div>

            <form method="post" action="" id="dst-menu-settings-form">
                <?php wp_nonce_field('dst_menu_settings_nonce', 'dst_menu_nonce'); ?>

                <div class="dst-menu-settings-grid">
                    <?php foreach ($all_menus as $menu_item):
                        $slug = $menu_item['slug'];
                        $is_hidden = in_array($slug, $hidden);
                        $lucide_icon = $this->get_lucide_icon($slug);
                        ?>
                        <div class="dst-menu-settings-item <?php echo $is_hidden ? 'is-hidden' : ''; ?>">
                            <label class="dst-menu-toggle">
                                <input type="checkbox"
                                       name="dst_hidden_menus[]"
                                       value="<?php echo esc_attr($slug); ?>"
                                       <?php checked($is_hidden); ?>>
                                <span class="dst-menu-toggle-slider"></span>
                            </label>
                            <span class="dst-menu-icon">
                                <i data-lucide="<?php echo esc_attr($lucide_icon); ?>"></i>
                            </span>
                            <span class="dst-menu-name"><?php echo esc_html($menu_item['title']); ?></span>
                            <?php if ($is_hidden): ?>
                                <span class="dst-menu-badge">مخفی</span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="dst-menu-settings-footer">
                    <button type="submit" class="button button-primary dst-save-btn">
                        <i data-lucide="save"></i>
                        ذخیره تنظیمات
                    </button>
                    <span class="dst-save-message"></span>
                </div>
            </form>
        </div>

        <style>
            .dst-menu-settings-wrap {
                max-width: 900px;
                margin: 20px auto 0;
            }
            .dst-menu-settings-header {
                margin-bottom: 30px;
            }
            .dst-menu-settings-header h1 {
                display: flex;
                align-items: center;
                gap: 12px;
                font-size: 24px;
                font-weight: 600;
                color: #1e293b;
                margin: 0 0 8px;
            }
            .dst-menu-settings-header h1 svg {
                width: 28px;
                height: 28px;
                stroke: #3C50E0;
            }
            .dst-menu-settings-header .description {
                font-size: 14px;
                color: #64748b;
                margin: 0;
            }
            .dst-menu-settings-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 12px;
                margin-bottom: 30px;
            }
            .dst-menu-settings-item {
                background: #fff;
                border: 1px solid #e2e8f0;
                border-radius: 10px;
                padding: 16px;
                display: flex;
                align-items: center;
                gap: 12px;
                transition: all 0.2s ease;
            }
            .dst-menu-settings-item:hover {
                border-color: #cbd5e1;
                box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            }
            .dst-menu-settings-item.is-hidden {
                background: #fef2f2;
                border-color: #fecaca;
            }
            .dst-menu-toggle {
                position: relative;
                width: 44px;
                height: 24px;
                flex-shrink: 0;
            }
            .dst-menu-toggle input {
                opacity: 0;
                width: 0;
                height: 0;
            }
            .dst-menu-toggle-slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #10b981;
                border-radius: 24px;
                transition: 0.3s;
            }
            .dst-menu-toggle-slider:before {
                position: absolute;
                content: "";
                height: 18px;
                width: 18px;
                left: 3px;
                bottom: 3px;
                background-color: white;
                border-radius: 50%;
                transition: 0.3s;
            }
            .dst-menu-toggle input:checked + .dst-menu-toggle-slider {
                background-color: #ef4444;
            }
            .dst-menu-toggle input:checked + .dst-menu-toggle-slider:before {
                transform: translateX(20px);
            }
            .dst-menu-icon {
                width: 36px;
                height: 36px;
                background: #f1f5f9;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .dst-menu-icon svg {
                width: 18px;
                height: 18px;
                stroke: #64748b;
            }
            .dst-menu-settings-item.is-hidden .dst-menu-icon {
                background: #fee2e2;
            }
            .dst-menu-settings-item.is-hidden .dst-menu-icon svg {
                stroke: #ef4444;
            }
            .dst-menu-name {
                flex: 1;
                font-size: 14px;
                font-weight: 500;
                color: #1e293b;
            }
            .dst-menu-badge {
                font-size: 11px;
                padding: 4px 8px;
                background: #ef4444;
                color: #fff;
                border-radius: 4px;
            }
            .dst-menu-settings-footer {
                display: flex;
                align-items: center;
                gap: 16px;
                padding-top: 20px;
                border-top: 1px solid #e2e8f0;
            }
            .dst-save-btn {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 10px 24px !important;
                height: auto !important;
                font-size: 14px !important;
            }
            .dst-save-btn svg {
                width: 18px;
                height: 18px;
            }
            .dst-save-message {
                font-size: 14px;
                color: #10b981;
            }
            @media screen and (max-width: 782px) {
                .dst-menu-settings-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>

        <script>
        jQuery(document).ready(function($) {
            // Toggle visual state
            $('.dst-menu-toggle input').on('change', function() {
                var $item = $(this).closest('.dst-menu-settings-item');
                if (this.checked) {
                    $item.addClass('is-hidden');
                    if (!$item.find('.dst-menu-badge').length) {
                        $item.append('<span class="dst-menu-badge">مخفی</span>');
                    }
                } else {
                    $item.removeClass('is-hidden');
                    $item.find('.dst-menu-badge').remove();
                }
            });

            // AJAX save
            $('#dst-menu-settings-form').on('submit', function(e) {
                e.preventDefault();

                var $form = $(this);
                var $btn = $form.find('.dst-save-btn');
                var $msg = $form.find('.dst-save-message');

                $btn.prop('disabled', true);
                $msg.text('در حال ذخیره...');

                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'dst_save_menu_settings',
                        nonce: $('#dst_menu_nonce').val(),
                        hidden_menus: $form.find('input[name="dst_hidden_menus[]"]:checked').map(function() {
                            return $(this).val();
                        }).get()
                    },
                    success: function(response) {
                        if (response.success) {
                            $msg.css('color', '#10b981').text('ذخیره شد! صفحه در حال بارگذاری مجدد...');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else {
                            $msg.css('color', '#ef4444').text('خطا در ذخیره');
                        }
                    },
                    error: function() {
                        $msg.css('color', '#ef4444').text('خطا در ارتباط');
                    },
                    complete: function() {
                        $btn.prop('disabled', false);
                    }
                });
            });

            // Init Lucide
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
        </script>
        <?php
    }

    /**
     * گرفتن لیست همه آیتم‌های منو
     */
    private function get_all_menu_items() {
        global $menu;

        $items = [];
        $excluded = ['separator', 'dst-'];

        if (!is_array($menu)) return $items;

        foreach ($menu as $item) {
            if (!isset($item[2]) || empty($item[0])) continue;

            $slug = $item[2];

            // رد کردن جداکننده‌ها
            $skip = false;
            foreach ($excluded as $ex) {
                if (strpos($slug, $ex) !== false) {
                    $skip = true;
                    break;
                }
            }
            if ($skip) continue;

            $items[] = [
                'title' => strip_tags($item[0]),
                'slug' => $slug,
                'icon' => $item[6] ?? 'dashicons-admin-generic',
            ];
        }

        return $items;
    }

    /**
     * ذخیره تنظیمات با AJAX
     */
    public function ajax_save_settings() {
        // بررسی nonce
        if (!wp_verify_nonce($_POST['nonce'] ?? '', 'dst_menu_settings_nonce')) {
            wp_send_json_error(['message' => 'Invalid nonce']);
        }

        // بررسی دسترسی
        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => 'Access denied']);
        }

        // ذخیره تنظیمات
        $hidden_menus = isset($_POST['hidden_menus']) ? array_map('sanitize_text_field', $_POST['hidden_menus']) : [];
        update_option('dst_hidden_menus', $hidden_menus);

        wp_send_json_success(['message' => 'Settings saved']);
    }
}

// راه‌اندازی ماژول
new DST_Admin_Menu_Manager();
