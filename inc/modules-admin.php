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
        ?>
        
        <div class="wrap dst-modules-page">
            <h1>
                🧩 مدیریت ماژول‌ها
                <span class="page-title-action">
                    <?php echo count($modules); ?> ماژول فعال از <?php echo count($all_modules); ?>
                </span>
            </h1>
            
            <?php if (empty($all_modules)): ?>
                
                <div class="notice notice-warning">
                    <p>
                        <strong>هنوز ماژولی نصب نشده!</strong><br>
                        برای ساخت ماژول جدید از دستور زیر استفاده کنید:<br>
                        <code>php create-module.php module-name "Module Title"</code>
                    </p>
                </div>
                
            <?php else: ?>
                
                <div class="dst-modules-grid">
                    <?php foreach ($all_modules as $name => $module): ?>
                        <?php 
                        $is_active = isset($modules[$name]);
                        $has_error = isset($module['error']);
                        ?>
                        
                        <div class="dst-module-card <?php echo $is_active ? 'active' : 'inactive'; ?>">
                            
                            <!-- Header -->
                            <div class="module-header">
                                <h3><?php echo esc_html($module['title']); ?></h3>
                                <span class="module-status">
                                    <?php if ($has_error): ?>
                                        ⚠️ خطا
                                    <?php elseif ($is_active): ?>
                                        ✅ فعال
                                    <?php else: ?>
                                        ⭕ غیرفعال
                                    <?php endif; ?>
                                </span>
                            </div>
                            
                            <!-- Body -->
                            <div class="module-body">
                                
                                <?php if ($has_error): ?>
                                    <div class="module-error">
                                        <?php echo esc_html($module['error']); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <p class="module-description">
                                    <?php echo esc_html($module['description']); ?>
                                </p>
                                
                                <div class="module-meta">
                                    <span class="meta-item">
                                        📦 نسخه: <?php echo esc_html($module['version']); ?>
                                    </span>
                                    
                                    <?php if (!empty($module['author'])): ?>
                                        <span class="meta-item">
                                            👤 <?php echo esc_html($module['author']); ?>
                                        </span>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($module['requires'])): ?>
                                        <span class="meta-item">
                                            🔗 نیازمندی: <?php echo implode(', ', $module['requires']); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if (!empty($module['features'])): ?>
                                    <div class="module-features">
                                        <strong>قابلیت‌ها:</strong>
                                        <ul>
                                            <?php foreach ($module['features'] as $feature): ?>
                                                <li><?php echo esc_html($feature); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                                
                            </div>
                            
                            <!-- Footer -->
                            <div class="module-footer">
                                <?php if (!$has_error): ?>
                                    <button 
                                        type="button" 
                                        class="button dst-toggle-module"
                                        data-module="<?php echo esc_attr($name); ?>"
                                        data-active="<?php echo $is_active ? '1' : '0'; ?>">
                                        <?php echo $is_active ? 'غیرفعال کردن' : 'فعال کردن'; ?>
                                    </button>
                                <?php endif; ?>
                                
                                <?php if (file_exists(DST_PATH . "/modules/{$name}/README.md")): ?>
                                    <a href="<?php echo esc_url(admin_url("theme-editor.php?file=modules/{$name}/README.md")); ?>" 
                                       class="button button-secondary">
                                        📖 مستندات
                                    </a>
                                <?php endif; ?>
                            </div>
                            
                        </div>
                        
                    <?php endforeach; ?>
                </div>
                
            <?php endif; ?>
            
            <!-- راهنما -->
            <div class="dst-help-section">
                <h2>📚 راهنمای سریع</h2>
                
                <div class="help-grid">
                    <div class="help-card">
                        <h3>ساخت ماژول جدید</h3>
                        <code>php create-module.php my-module "عنوان ماژول"</code>
                    </div>
                    
                    <div class="help-card">
                        <h3>ساختار ماژول</h3>
                        <pre>modules/
└── my-module/
    ├── module.json
    ├── init.php
    └── assets/</pre>
                    </div>
                    
                    <div class="help-card">
                        <h3>مستندات کامل</h3>
                        <a href="<?php echo esc_url(DST_URL . '/docs/MODULES.md'); ?>" 
                           target="_blank" 
                           class="button">
                            مشاهده مستندات
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
        
        <?php
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
            max-width: 1400px;
        }
        .dst-modules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        .dst-module-card {
            background: #fff;
            border: 2px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s;
        }
        .dst-module-card.active {
            border-color: #2271b1;
            box-shadow: 0 0 0 1px rgba(34, 113, 177, 0.1);
        }
        .dst-module-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .module-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background: #f8f9fa;
            border-bottom: 1px solid #ddd;
        }
        .module-header h3 {
            margin: 0;
            font-size: 16px;
        }
        .module-status {
            font-size: 12px;
            font-weight: 600;
        }
        .module-body {
            padding: 20px;
        }
        .module-error {
            padding: 10px;
            margin-bottom: 15px;
            background: #fef2f2;
            border: 1px solid #fca5a5;
            border-radius: 4px;
            color: #991b1b;
            font-size: 13px;
        }
        .module-description {
            margin: 0 0 15px;
            color: #666;
        }
        .module-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 15px 0;
        }
        .meta-item {
            font-size: 12px;
            padding: 4px 8px;
            background: #f0f0f0;
            border-radius: 4px;
        }
        .module-features {
            margin-top: 15px;
            font-size: 13px;
        }
        .module-features ul {
            margin: 5px 0;
            padding-left: 20px;
        }
        .module-footer {
            display: flex;
            gap: 10px;
            padding: 15px 20px;
            background: #f8f9fa;
            border-top: 1px solid #ddd;
        }
        .dst-help-section {
            margin-top: 40px;
            padding: 20px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .help-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .help-card {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 4px;
        }
        .help-card h3 {
            margin-top: 0;
            font-size: 14px;
        }
        .help-card code,
        .help-card pre {
            display: block;
            padding: 10px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 12px;
        }
        ';
    }
    
    /**
     * JS اینلاین
     */
    private function get_inline_js() {
        return "
        jQuery(function($) {
            $('.dst-toggle-module').on('click', function() {
                var btn = $(this);
                var module = btn.data('module');
                var isActive = btn.data('active') === 1;
                var activate = !isActive;
                
                btn.prop('disabled', true).text('در حال پردازش...');
                
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
                            btn.prop('disabled', false);
                        }
                    },
                    error: function() {
                        alert('خطا در ارتباط با سرور');
                        btn.prop('disabled', false);
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
