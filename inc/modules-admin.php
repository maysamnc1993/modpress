<?php
/**
 * Modules Manager - Admin Page
 * 
 * صفحه مدیریت ماژول‌ها در پیشخوان وردپرس
 * 
 * @package Developer_Starter
 */

defined('ABSPATH') || exit;

/**
 * کلاس مدیریت صفحه ادمین ماژول‌ها
 */
class DST_Modules_Admin {
    
    /**
     * سازنده
     */
    public function __construct() {
        add_action('admin_menu', [$this, 'add_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('wp_ajax_dst_toggle_module', [$this, 'ajax_toggle_module']);
    }
    
    /**
     * اضافه کردن منو
     */
    public function add_menu() {
        add_theme_page(
            'مدیریت ماژول‌ها',
            'ماژول‌ها',
            'manage_options',
            'dst-modules',
            [$this, 'render_page']
        );
    }
    
    /**
     * لود Assets
     */
    public function enqueue_assets($hook) {
        if ($hook !== 'appearance_page_dst-modules') {
            return;
        }
        
        // استایل اینلاین
        wp_add_inline_style('wp-admin', $this->get_inline_css());
        
        // اسکریپت اینلاین
        wp_add_inline_script('jquery', $this->get_inline_js());
    }
    
    /**
     * نمایش صفحه
     */
    public function render_page() {
        if (!current_user_can('manage_options')) {
            return;
        }

        $modules = dst_modules()->get_modules();
        $all_modules = $this->scan_all_modules();
        $active_count = count($modules);
        $total_count = count($all_modules);
        ?>

        <div class="wrap dst-modules-page">
            <div class="dst-modules-header">
                <div class="header-title">
                    <h1>
                        <i data-lucide="puzzle"></i>
                        مدیریت ماژول‌ها
                    </h1>
                    <p class="description">فعال یا غیرفعال کردن قابلیت‌های قالب</p>
                </div>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number"><?php echo $active_count; ?></span>
                        <span class="stat-label">فعال</span>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-item">
                        <span class="stat-number"><?php echo $total_count; ?></span>
                        <span class="stat-label">کل</span>
                    </div>
                </div>
            </div>

            <?php if (empty($all_modules)): ?>

                <div class="dst-modules-empty">
                    <i data-lucide="package-x"></i>
                    <h3>هنوز ماژولی نصب نشده!</h3>
                    <p>برای ساخت ماژول جدید از دستور زیر استفاده کنید:</p>
                    <code>php create-module.php module-name "Module Title"</code>
                </div>

            <?php else: ?>

                <div class="dst-modules-grid">
                    <?php foreach ($all_modules as $name => $module): ?>
                        <?php
                        $is_active = isset($modules[$name]);
                        $has_error = isset($module['error']);
                        $module_icon = $this->get_module_icon($name);
                        ?>

                        <div class="dst-module-card <?php echo $is_active ? 'is-active' : 'is-inactive'; ?> <?php echo $has_error ? 'has-error' : ''; ?>">

                            <div class="module-icon">
                                <i data-lucide="<?php echo esc_attr($module_icon); ?>"></i>
                            </div>

                            <div class="module-content">
                                <div class="module-header">
                                    <h3><?php echo esc_html($module['title']); ?></h3>
                                    <?php if ($has_error): ?>
                                        <span class="module-badge badge-error">خطا</span>
                                    <?php elseif ($is_active): ?>
                                        <span class="module-badge badge-active">فعال</span>
                                    <?php else: ?>
                                        <span class="module-badge badge-inactive">غیرفعال</span>
                                    <?php endif; ?>
                                </div>

                                <?php if ($has_error): ?>
                                    <div class="module-error">
                                        <i data-lucide="alert-triangle"></i>
                                        <?php echo esc_html($module['error']); ?>
                                    </div>
                                <?php endif; ?>

                                <p class="module-description">
                                    <?php echo esc_html($module['description']); ?>
                                </p>

                                <div class="module-meta">
                                    <span class="meta-item">
                                        <i data-lucide="tag"></i>
                                        <?php echo esc_html($module['version']); ?>
                                    </span>

                                    <?php if (!empty($module['author'])): ?>
                                        <span class="meta-item">
                                            <i data-lucide="user"></i>
                                            <?php echo esc_html($module['author']); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="module-footer">
                                <?php if (!$has_error): ?>
                                    <label class="module-toggle">
                                        <input type="checkbox"
                                               class="dst-toggle-module"
                                               data-module="<?php echo esc_attr($name); ?>"
                                               <?php checked($is_active); ?>>
                                        <span class="toggle-slider"></span>
                                    </label>
                                <?php endif; ?>
                            </div>

                        </div>

                    <?php endforeach; ?>
                </div>

            <?php endif; ?>

        </div>

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
     * گرفتن آیکون مناسب برای هر ماژول
     */
    private function get_module_icon($name) {
        $icons = [
            'admin-menu-manager' => 'layout-list',
            'admin-theme' => 'palette',
            'header-footer' => 'layout',
            'theme-settings' => 'settings',
            'seo' => 'search',
            'cache' => 'zap',
            'security' => 'shield',
            'backup' => 'hard-drive',
            'analytics' => 'bar-chart-2',
            'forms' => 'file-input',
            'slider' => 'images',
            'gallery' => 'image',
            'blog' => 'file-text',
            'shop' => 'shopping-cart',
            'social' => 'share-2',
            'email' => 'mail',
            'api' => 'code',
        ];

        foreach ($icons as $key => $icon) {
            if (strpos($name, $key) !== false) {
                return $icon;
            }
        }

        return 'puzzle';
    }
    
    /**
     * اسکن تمام ماژول‌ها (حتی غیرفعال‌ها)
     */
    private function scan_all_modules() {
        $modules_path = DST_PATH . '/modules';
        $modules = [];
        
        if (!is_dir($modules_path)) {
            return $modules;
        }
        
        $folders = glob($modules_path . '/*', GLOB_ONLYDIR);
        
        foreach ($folders as $folder) {
            $name = basename($folder);
            $config_file = $folder . '/module.json';
            
            if (!file_exists($config_file)) {
                $modules[$name] = [
                    'title' => $name,
                    'description' => 'فایل module.json یافت نشد',
                    'version' => '0.0.0',
                    'error' => 'فایل module.json موجود نیست',
                ];
                continue;
            }
            
            $config = json_decode(file_get_contents($config_file), true);
            
            if (!$config) {
                $modules[$name] = [
                    'title' => $name,
                    'description' => 'فایل module.json معتبر نیست',
                    'version' => '0.0.0',
                    'error' => 'فرمت JSON نامعتبر است',
                ];
                continue;
            }
            
            $modules[$name] = wp_parse_args($config, [
                'title' => $name,
                'description' => '',
                'version' => '1.0.0',
                'author' => '',
                'requires' => [],
                'features' => [],
            ]);
        }
        
        return $modules;
    }
    
    /**
     * Ajax: فعال/غیرفعال کردن ماژول
     */
    public function ajax_toggle_module() {
        check_ajax_referer('dst-admin-nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('عدم دسترسی');
        }
        
        $module_name = sanitize_text_field($_POST['module'] ?? '');
        $activate = $_POST['activate'] === 'true';
        
        $result = dst_modules()->toggle_module($module_name, $activate);
        
        if ($result) {
            wp_send_json_success([
                'message' => $activate ? 'ماژول فعال شد' : 'ماژول غیرفعال شد',
                'reload' => true, // رفرش صفحه برای اعمال تغییرات
            ]);
        } else {
            wp_send_json_error('خطا در تغییر وضعیت');
        }
    }
    
    /**
     * CSS اینلاین
     */
    private function get_inline_css() {
        return '
        .dst-modules-page {
            max-width: 1200px;
            margin: 20px auto 0;
        }
        /* Header */
        .dst-modules-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }
        .dst-modules-header h1 {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 26px;
            font-weight: 600;
            color: #1e293b;
            margin: 0 0 8px;
        }
        .dst-modules-header h1 svg {
            width: 32px;
            height: 32px;
            stroke: #3C50E0;
        }
        .dst-modules-header .description {
            font-size: 14px;
            color: #64748b;
            margin: 0;
        }
        .header-stats {
            display: flex;
            align-items: center;
            gap: 20px;
            background: #fff;
            padding: 16px 24px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }
        .stat-item {
            text-align: center;
        }
        .stat-number {
            display: block;
            font-size: 28px;
            font-weight: 700;
            color: #3C50E0;
        }
        .stat-label {
            font-size: 12px;
            color: #64748b;
        }
        .stat-divider {
            width: 1px;
            height: 40px;
            background: #e2e8f0;
        }
        /* Empty State */
        .dst-modules-empty {
            text-align: center;
            padding: 60px 20px;
            background: #fff;
            border: 1px dashed #e2e8f0;
            border-radius: 12px;
        }
        .dst-modules-empty svg {
            width: 64px;
            height: 64px;
            stroke: #94a3b8;
            margin-bottom: 20px;
        }
        .dst-modules-empty h3 {
            font-size: 18px;
            color: #1e293b;
            margin: 0 0 8px;
        }
        .dst-modules-empty p {
            color: #64748b;
            margin: 0 0 16px;
        }
        .dst-modules-empty code {
            display: inline-block;
            padding: 8px 16px;
            background: #f1f5f9;
            border-radius: 6px;
            font-size: 13px;
        }
        /* Grid */
        .dst-modules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
        }
        /* Card */
        .dst-module-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px;
            display: flex;
            gap: 16px;
            transition: all 0.2s ease;
            position: relative;
        }
        .dst-module-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .dst-module-card.is-active {
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
            border-color: #86efac;
        }
        .dst-module-card.has-error {
            background: #fef2f2;
            border-color: #fca5a5;
        }
        /* Icon */
        .module-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .module-icon svg {
            width: 28px;
            height: 28px;
            stroke: #64748b;
        }
        .dst-module-card.is-active .module-icon {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        }
        .dst-module-card.is-active .module-icon svg {
            stroke: #fff;
        }
        .dst-module-card.has-error .module-icon {
            background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
        }
        .dst-module-card.has-error .module-icon svg {
            stroke: #fff;
        }
        /* Content */
        .module-content {
            flex: 1;
            min-width: 0;
        }
        .module-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }
        .module-header h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
        }
        .module-badge {
            font-size: 10px;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: 500;
        }
        .badge-active {
            background: #10b981;
            color: #fff;
        }
        .badge-inactive {
            background: #94a3b8;
            color: #fff;
        }
        .badge-error {
            background: #ef4444;
            color: #fff;
        }
        .module-error {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
            margin-bottom: 10px;
            background: #fff;
            border: 1px solid #fca5a5;
            border-radius: 6px;
            color: #dc2626;
            font-size: 12px;
        }
        .module-error svg {
            width: 14px;
            height: 14px;
            stroke: #dc2626;
            flex-shrink: 0;
        }
        .module-description {
            margin: 0 0 12px;
            color: #64748b;
            font-size: 13px;
            line-height: 1.5;
        }
        .module-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .meta-item {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            padding: 4px 8px;
            background: #f1f5f9;
            border-radius: 4px;
            color: #64748b;
        }
        .meta-item svg {
            width: 12px;
            height: 12px;
        }
        /* Footer / Toggle */
        .module-footer {
            display: flex;
            align-items: flex-start;
            padding-top: 8px;
        }
        .module-toggle {
            position: relative;
            width: 48px;
            height: 26px;
            cursor: pointer;
        }
        .module-toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #cbd5e1;
            border-radius: 26px;
            transition: 0.3s;
        }
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            border-radius: 50%;
            transition: 0.3s;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .module-toggle input:checked + .toggle-slider {
            background-color: #10b981;
        }
        .module-toggle input:checked + .toggle-slider:before {
            transform: translateX(22px);
        }
        .module-toggle input:disabled + .toggle-slider {
            opacity: 0.5;
            cursor: not-allowed;
        }
        @media screen and (max-width: 782px) {
            .dst-modules-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .dst-modules-grid {
                grid-template-columns: 1fr;
            }
        }
        ';
    }
    
    /**
     * JS اینلاین
     */
    private function get_inline_js() {
        return "
        jQuery(function($) {
            $('.dst-toggle-module').on('change', function() {
                var checkbox = $(this);
                var card = checkbox.closest('.dst-module-card');
                var module = checkbox.data('module');
                var activate = checkbox.is(':checked');

                // غیرفعال کردن چک‌باکس
                checkbox.prop('disabled', true);

                // نمایش loading
                card.css('opacity', '0.6');

                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'dst_toggle_module',
                        nonce: '" . wp_create_nonce('dst-admin-nonce') . "',
                        module: module,
                        activate: activate
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert(response.data || 'خطا در تغییر وضعیت');
                            checkbox.prop('checked', !activate);
                            checkbox.prop('disabled', false);
                            card.css('opacity', '1');
                        }
                    },
                    error: function() {
                        alert('خطا در ارتباط با سرور');
                        checkbox.prop('checked', !activate);
                        checkbox.prop('disabled', false);
                        card.css('opacity', '1');
                    }
                });
            });
        });
        ";
    }
}

/**
 * راه‌اندازی
 */
if (is_admin()) {
    new DST_Modules_Admin();
}
