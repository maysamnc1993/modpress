<?php
/**
 * ماژول مدیریت هدر و فوتر
 * Header Footer Manager Module
 *
 * امکان انتخاب هدر و فوتر از پنل ادمین
 * بدون نیاز به Customizer
 *
 * @package Developer_Starter
 * @subpackage Modules/Header_Footer_Manager
 * @version 3.0.0
 */

defined('ABSPATH') || exit;

class DST_Header_Footer_Manager {

    /**
     * مسیر ماژول
     */
    private $module_path;

    /**
     * URL ماژول
     */
    private $module_url;

    /**
     * نام option در دیتابیس
     */
    private $option_name = 'dst_header_footer_settings';

    /**
     * تنظیمات فعلی
     */
    private $settings;

    /**
     * سازنده
     */
    public function __construct() {
        $module = dst_get_module('header-footer-manager');
        if (!$module) {
            return;
        }

        $this->module_path = $module['path'];
        $this->module_url  = $module['url'];
        $this->settings    = get_option($this->option_name, $this->get_default_settings());

        // چک حالت پیش‌نمایش
        $this->handle_preview_mode();

        // هوک‌ها
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'admin_assets']);
        add_action('wp_enqueue_scripts', [$this, 'frontend_assets']);
        add_action('admin_init', [$this, 'handle_save_settings']);
        add_action('wp_ajax_dst_hf_quick_save', [$this, 'ajax_quick_save']);
    }

    /**
     * هندل کردن حالت پیش‌نمایش
     */
    private function handle_preview_mode() {
        if (!isset($_GET['dst_preview'])) {
            return;
        }

        // فقط ادمین‌ها می‌تونن پیش‌نمایش ببینن
        if (!current_user_can('manage_options')) {
            return;
        }

        // اگر هدر پیش‌نمایش تنظیم شده
        if (isset($_GET['preview_header'])) {
            $preview_header = sanitize_text_field($_GET['preview_header']);
            $headers = $this->get_available_headers();
            if (isset($headers[$preview_header])) {
                $this->settings['active_header'] = $preview_header;
            }
        }

        // اگر فوتر پیش‌نمایش تنظیم شده
        if (isset($_GET['preview_footer'])) {
            $preview_footer = sanitize_text_field($_GET['preview_footer']);
            $footers = $this->get_available_footers();
            if (isset($footers[$preview_footer])) {
                $this->settings['active_footer'] = $preview_footer;
            }
        }
    }

    /**
     * تنظیمات پیش‌فرض
     */
    private function get_default_settings() {
        return [
            'active_header' => 'default',
            'active_footer' => 'default',
            'header_settings' => [],
            'footer_settings' => [],
        ];
    }

    /**
     * گرفتن تنظیمات یک هدر خاص
     */
    public function get_header_settings($header_name) {
        $headers = $this->get_available_headers();
        $saved_settings = isset($this->settings['header_settings'][$header_name])
            ? $this->settings['header_settings'][$header_name]
            : [];

        $defaults = [];
        if (isset($headers[$header_name]['settings'])) {
            foreach ($headers[$header_name]['settings'] as $key => $field) {
                $defaults[$key] = isset($field['default']) ? $field['default'] : '';
            }
        }

        return wp_parse_args($saved_settings, $defaults);
    }

    /**
     * گرفتن تنظیمات یک فوتر خاص
     */
    public function get_footer_settings($footer_name) {
        $footers = $this->get_available_footers();
        $saved_settings = isset($this->settings['footer_settings'][$footer_name])
            ? $this->settings['footer_settings'][$footer_name]
            : [];

        $defaults = [];
        if (isset($footers[$footer_name]['settings'])) {
            foreach ($footers[$footer_name]['settings'] as $key => $field) {
                $defaults[$key] = isset($field['default']) ? $field['default'] : '';
            }
        }

        return wp_parse_args($saved_settings, $defaults);
    }

    /**
     * اضافه کردن صفحه در ادمین
     */
    public function add_admin_menu() {
        add_menu_page(
            'هدر و فوتر',
            'هدر و فوتر',
            'manage_options',
            'dst-header-footer',
            [$this, 'render_admin_page'],
            'dashicons-admin-customizer',
            999
        );
    }

    /**
     * لود فایل‌های ادمین
     */
    public function admin_assets($hook) {
        if ($hook !== 'تنظیمات-وب‌سایت_page_dst-header-footer' &&
            $hook !== 'admin_page_dst-header-footer' &&
            strpos($hook, 'dst-header-footer') === false) {
            return;
        }

        wp_enqueue_style(
            'dst-hf-admin',
            $this->module_url . '/assets/css/admin.css',
            [],
            '3.0.0'
        );

        wp_localize_script('jquery', 'dstHF', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('dst_hf_quick_save'),
        ]);
    }

    /**
     * لود فایل‌های فرانت‌اند
     */
    public function frontend_assets() {
        $header = $this->settings['active_header'];
        $footer = $this->settings['active_footer'];

        // CSS هدر
        $header_css = $this->module_path . '/templates/headers/' . $header . '/style.css';
        if (file_exists($header_css)) {
            wp_enqueue_style(
                'dst-header-' . $header,
                $this->module_url . '/templates/headers/' . $header . '/style.css',
                [],
                filemtime($header_css)
            );
        }

        // JS هدر
        $header_js = $this->module_path . '/templates/headers/' . $header . '/script.js';
        if (file_exists($header_js)) {
            wp_enqueue_script(
                'dst-header-' . $header,
                $this->module_url . '/templates/headers/' . $header . '/script.js',
                ['jquery'],
                filemtime($header_js),
                true
            );
        }

        // CSS فوتر
        $footer_css = $this->module_path . '/templates/footers/' . $footer . '/style.css';
        if (file_exists($footer_css)) {
            wp_enqueue_style(
                'dst-footer-' . $footer,
                $this->module_url . '/templates/footers/' . $footer . '/style.css',
                [],
                filemtime($footer_css)
            );
        }

        // JS فوتر
        $footer_js = $this->module_path . '/templates/footers/' . $footer . '/script.js';
        if (file_exists($footer_js)) {
            wp_enqueue_script(
                'dst-footer-' . $footer,
                $this->module_url . '/templates/footers/' . $footer . '/script.js',
                ['jquery'],
                filemtime($footer_js),
                true
            );
        }
    }

    /**
     * ذخیره سریع با AJAX
     */
    public function ajax_quick_save() {
        check_ajax_referer('dst_hf_quick_save', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error('Permission denied');
        }

        $type = sanitize_text_field($_POST['type'] ?? '');
        $value = sanitize_text_field($_POST['value'] ?? '');

        if ($type === 'header') {
            $this->settings['active_header'] = $value;
        } elseif ($type === 'footer') {
            $this->settings['active_footer'] = $value;
        }

        update_option($this->option_name, $this->settings);

        wp_send_json_success([
            'message' => 'ذخیره شد!',
            'type' => $type,
            'value' => $value,
        ]);
    }

    /**
     * ذخیره تنظیمات
     */
    public function handle_save_settings() {
        if (!isset($_POST['dst_hf_save']) || !current_user_can('manage_options')) {
            return;
        }

        check_admin_referer('dst_hf_settings_nonce');

        $active_header = sanitize_text_field($_POST['active_header'] ?? 'default');
        $active_footer = sanitize_text_field($_POST['active_footer'] ?? 'default');

        // پردازش تنظیمات هدرها
        $header_settings = isset($this->settings['header_settings']) ? $this->settings['header_settings'] : [];
        $headers = $this->get_available_headers();

        foreach ($headers as $header_name => $header_config) {
            if (isset($header_config['settings'])) {
                foreach ($header_config['settings'] as $field_key => $field_config) {
                    $post_key = 'header_' . $header_name . '_' . $field_key;

                    if ($field_config['type'] === 'checkbox') {
                        $header_settings[$header_name][$field_key] = isset($_POST[$post_key]) ? true : false;
                    } else {
                        $header_settings[$header_name][$field_key] = isset($_POST[$post_key])
                            ? sanitize_text_field($_POST[$post_key])
                            : ($field_config['default'] ?? '');
                    }
                }
            }
        }

        // پردازش تنظیمات فوترها
        $footer_settings = isset($this->settings['footer_settings']) ? $this->settings['footer_settings'] : [];
        $footers = $this->get_available_footers();

        foreach ($footers as $footer_name => $footer_config) {
            if (isset($footer_config['settings'])) {
                foreach ($footer_config['settings'] as $field_key => $field_config) {
                    $post_key = 'footer_' . $footer_name . '_' . $field_key;

                    if ($field_config['type'] === 'checkbox') {
                        $footer_settings[$footer_name][$field_key] = isset($_POST[$post_key]) ? true : false;
                    } else {
                        $footer_settings[$footer_name][$field_key] = isset($_POST[$post_key])
                            ? sanitize_text_field($_POST[$post_key])
                            : ($field_config['default'] ?? '');
                    }
                }
            }
        }

        $new_settings = [
            'active_header' => $active_header,
            'active_footer' => $active_footer,
            'header_settings' => $header_settings,
            'footer_settings' => $footer_settings,
        ];

        update_option($this->option_name, $new_settings);
        $this->settings = $new_settings;

        add_action('admin_notices', function() {
            echo '<div class="notice notice-success is-dismissible"><p>✅ تنظیمات با موفقیت ذخیره شد.</p></div>';
        });
    }

    /**
     * اسکن هدرهای موجود
     */
    public function get_available_headers() {
        $headers = [];
        $headers_path = $this->module_path . '/templates/headers';

        if (!is_dir($headers_path)) {
            return $headers;
        }

        $folders = glob($headers_path . '/*', GLOB_ONLYDIR);

        foreach ($folders as $folder) {
            $name = basename($folder);
            $config_file = $folder . '/config.json';

            $config = [
                'name' => $name,
                'title' => ucfirst($name),
                'description' => '',
                'thumbnail' => '',
                'version' => '1.0.0',
            ];

            if (file_exists($config_file)) {
                $json = json_decode(file_get_contents($config_file), true);
                if ($json) {
                    $config = wp_parse_args($json, $config);
                }
            }

            // چک تصویر پیش‌نمایش
            if (file_exists($folder . '/screenshot.png')) {
                $config['thumbnail'] = $this->module_url . '/templates/headers/' . $name . '/screenshot.png';
            } elseif (file_exists($folder . '/screenshot.jpg')) {
                $config['thumbnail'] = $this->module_url . '/templates/headers/' . $name . '/screenshot.jpg';
            } elseif (file_exists($folder . '/screenshot.svg')) {
                $config['thumbnail'] = $this->module_url . '/templates/headers/' . $name . '/screenshot.svg';
            }

            $headers[$name] = $config;
        }

        return $headers;
    }

    /**
     * اسکن فوترهای موجود
     */
    public function get_available_footers() {
        $footers = [];
        $footers_path = $this->module_path . '/templates/footers';

        if (!is_dir($footers_path)) {
            return $footers;
        }

        $folders = glob($footers_path . '/*', GLOB_ONLYDIR);

        foreach ($folders as $folder) {
            $name = basename($folder);
            $config_file = $folder . '/config.json';

            $config = [
                'name' => $name,
                'title' => ucfirst($name),
                'description' => '',
                'thumbnail' => '',
                'version' => '1.0.0',
            ];

            if (file_exists($config_file)) {
                $json = json_decode(file_get_contents($config_file), true);
                if ($json) {
                    $config = wp_parse_args($json, $config);
                }
            }

            // چک تصویر پیش‌نمایش
            if (file_exists($folder . '/screenshot.png')) {
                $config['thumbnail'] = $this->module_url . '/templates/footers/' . $name . '/screenshot.png';
            } elseif (file_exists($folder . '/screenshot.jpg')) {
                $config['thumbnail'] = $this->module_url . '/templates/footers/' . $name . '/screenshot.jpg';
            } elseif (file_exists($folder . '/screenshot.svg')) {
                $config['thumbnail'] = $this->module_url . '/templates/footers/' . $name . '/screenshot.svg';
            }

            $footers[$name] = $config;
        }

        return $footers;
    }

    /**
     * صفحه ادمین - UI جدید
     */
    public function render_admin_page() {
        $headers = $this->get_available_headers();
        $footers = $this->get_available_footers();
        $active_header = $this->settings['active_header'];
        $active_footer = $this->settings['active_footer'];
        $preview_url = add_query_arg([
            'dst_preview' => '1',
            'preview_header' => $active_header,
            'preview_footer' => $active_footer,
        ], home_url('/'));
        ?>
        <div class="wrap dst-hf-wrap">
            <form method="post" action="" id="dst-hf-form">
                <?php wp_nonce_field('dst_hf_settings_nonce'); ?>

                <!-- هدر صفحه -->
                <div class="dst-hf-page-header">
                    <div class="page-header-content">
                        <h1>
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M3 15h18"/></svg>
                            مدیریت هدر و فوتر
                        </h1>
                        <p>طراحی هدر و فوتر سایت خود را با یک کلیک تغییر دهید</p>
                    </div>
                    <div class="page-header-actions">
                        <a href="<?php echo esc_url(home_url('/')); ?>" target="_blank" class="btn-outline">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/></svg>
                            مشاهده سایت
                        </a>
                        <button type="submit" name="dst_hf_save" class="btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            ذخیره تغییرات
                        </button>
                    </div>
                </div>

                <!-- بخش اصلی -->
                <div class="dst-hf-main-layout">
                    <!-- پنل چپ: انتخاب‌ها -->
                    <div class="dst-hf-selector-panel">

                        <!-- بخش هدر -->
                        <div class="selector-section">
                            <div class="section-title">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/></svg>
                                <span>انتخاب هدر</span>
                                <span class="count-badge"><?php echo count($headers); ?></span>
                            </div>

                            <?php if (empty($headers)): ?>
                                <div class="empty-state">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8v13H3V8"/><path d="M1 3h22v5H1z"/></svg>
                                    <p>هدری یافت نشد</p>
                                </div>
                            <?php else: ?>
                                <div class="template-list">
                                    <?php foreach ($headers as $name => $config): ?>
                                        <label class="template-item <?php echo $active_header === $name ? 'active' : ''; ?>" data-type="header" data-name="<?php echo esc_attr($name); ?>">
                                            <input type="radio" name="active_header" value="<?php echo esc_attr($name); ?>" <?php checked($active_header, $name); ?>>

                                            <div class="template-thumb">
                                                <?php if ($config['thumbnail']): ?>
                                                    <img src="<?php echo esc_url($config['thumbnail']); ?>" alt="<?php echo esc_attr($config['title']); ?>">
                                                <?php else: ?>
                                                    <div class="no-thumb">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <div class="template-info">
                                                <h4><?php echo esc_html($config['title']); ?></h4>
                                                <?php if ($config['description']): ?>
                                                    <p><?php echo esc_html($config['description']); ?></p>
                                                <?php endif; ?>
                                            </div>

                                            <div class="template-check">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                            </div>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- بخش فوتر -->
                        <div class="selector-section">
                            <div class="section-title">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="7" x="3" y="14" rx="1"/><rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/></svg>
                                <span>انتخاب فوتر</span>
                                <span class="count-badge"><?php echo count($footers); ?></span>
                            </div>

                            <?php if (empty($footers)): ?>
                                <div class="empty-state">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8v13H3V8"/><path d="M1 3h22v5H1z"/></svg>
                                    <p>فوتری یافت نشد</p>
                                </div>
                            <?php else: ?>
                                <div class="template-list">
                                    <?php foreach ($footers as $name => $config): ?>
                                        <label class="template-item <?php echo $active_footer === $name ? 'active' : ''; ?>" data-type="footer" data-name="<?php echo esc_attr($name); ?>">
                                            <input type="radio" name="active_footer" value="<?php echo esc_attr($name); ?>" <?php checked($active_footer, $name); ?>>

                                            <div class="template-thumb">
                                                <?php if ($config['thumbnail']): ?>
                                                    <img src="<?php echo esc_url($config['thumbnail']); ?>" alt="<?php echo esc_attr($config['title']); ?>">
                                                <?php else: ?>
                                                    <div class="no-thumb">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <div class="template-info">
                                                <h4><?php echo esc_html($config['title']); ?></h4>
                                                <?php if ($config['description']): ?>
                                                    <p><?php echo esc_html($config['description']); ?></p>
                                                <?php endif; ?>
                                            </div>

                                            <div class="template-check">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                            </div>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>

                    <!-- پنل راست: پیش‌نمایش -->
                    <div class="dst-hf-preview-panel">
                        <div class="preview-toolbar">
                            <div class="preview-title">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                                پیش‌نمایش زنده
                            </div>
                            <div class="preview-devices">
                                <button type="button" class="device-btn active" data-device="desktop" title="دسکتاپ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="3" rx="2"/><line x1="8" x2="16" y1="21" y2="21"/><line x1="12" x2="12" y1="17" y2="21"/></svg>
                                </button>
                                <button type="button" class="device-btn" data-device="tablet" title="تبلت">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"/><line x1="12" x2="12.01" y1="18" y2="18"/></svg>
                                </button>
                                <button type="button" class="device-btn" data-device="mobile" title="موبایل">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="20" x="5" y="2" rx="2" ry="2"/><line x1="12" x2="12.01" y1="18" y2="18"/></svg>
                                </button>
                                <div class="device-divider"></div>
                                <button type="button" class="refresh-btn" title="بارگذاری مجدد">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/><path d="M16 16h5v5"/></svg>
                                </button>
                            </div>
                        </div>

                        <div class="preview-container" data-device="desktop">
                            <iframe id="preview-frame" src="<?php echo esc_url($preview_url); ?>"></iframe>
                            <div class="preview-loader">
                                <div class="loader-spinner"></div>
                                <span>در حال بارگذاری...</span>
                            </div>
                        </div>

                        <div class="preview-status">
                            <div class="status-item">
                                <span class="status-label">هدر:</span>
                                <span class="status-value" id="current-header"><?php echo esc_html($headers[$active_header]['title'] ?? $active_header); ?></span>
                            </div>
                            <div class="status-divider"></div>
                            <div class="status-item">
                                <span class="status-label">فوتر:</span>
                                <span class="status-value" id="current-footer"><?php echo esc_html($footers[$active_footer]['title'] ?? $active_footer); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>

        <script>
        jQuery(document).ready(function($) {
            var $iframe = $('#preview-frame');
            var $previewContainer = $('.preview-container');
            var $loader = $('.preview-loader');
            var baseUrl = '<?php echo esc_js(home_url('/')); ?>';
            var previewTimeout;

            // Headers and footers data
            var headersData = <?php echo json_encode(array_map(function($h) { return $h['title']; }, $headers)); ?>;
            var footersData = <?php echo json_encode(array_map(function($f) { return $f['title']; }, $footers)); ?>;

            // وقتی iframe لود شد
            $iframe.on('load', function() {
                $loader.removeClass('show');
            });

            // تابع آپدیت پیش‌نمایش
            function updatePreview() {
                $loader.addClass('show');

                var header = $('input[name="active_header"]:checked').val();
                var footer = $('input[name="active_footer"]:checked').val();
                var previewUrl = baseUrl + '?dst_preview=1&preview_header=' + header + '&preview_footer=' + footer + '&t=' + Date.now();

                $iframe.attr('src', previewUrl);

                // آپدیت استاتوس
                $('#current-header').text(headersData[header] || header);
                $('#current-footer').text(footersData[footer] || footer);
            }

            // کلیک روی آیتم
            $('.template-item').on('click', function() {
                var $this = $(this);
                var $section = $this.closest('.selector-section');

                // آپدیت UI
                $section.find('.template-item').removeClass('active');
                $this.addClass('active');

                // انتخاب radio
                $this.find('input[type="radio"]').prop('checked', true);

                // آپدیت پیش‌نمایش با تأخیر
                clearTimeout(previewTimeout);
                previewTimeout = setTimeout(updatePreview, 200);
            });

            // تغییر دستگاه
            $('.device-btn').on('click', function() {
                var device = $(this).data('device');
                $('.device-btn').removeClass('active');
                $(this).addClass('active');
                $previewContainer.attr('data-device', device);
            });

            // رفرش
            $('.refresh-btn').on('click', function() {
                updatePreview();
            });

            // نمایش اولیه لودر
            $loader.addClass('show');
        });
        </script>
        <?php
    }

    /**
     * گرفتن هدر فعال
     */
    public function get_active_header() {
        return $this->settings['active_header'];
    }

    /**
     * گرفتن فوتر فعال
     */
    public function get_active_footer() {
        return $this->settings['active_footer'];
    }

    /**
     * رندر هدر
     */
    public function render_header() {
        $header = $this->settings['active_header'];
        $template_file = $this->module_path . '/templates/headers/' . $header . '/template.php';

        if (file_exists($template_file)) {
            include $template_file;
        } else {
            echo '<!-- Header template not found: ' . esc_html($header) . ' -->';
            $this->render_fallback_header();
        }
    }

    /**
     * رندر فوتر
     */
    public function render_footer() {
        $footer = $this->settings['active_footer'];
        $template_file = $this->module_path . '/templates/footers/' . $footer . '/template.php';

        if (file_exists($template_file)) {
            include $template_file;
        } else {
            echo '<!-- Footer template not found: ' . esc_html($footer) . ' -->';
            $this->render_fallback_footer();
        }
    }

    /**
     * هدر فالبک
     */
    private function render_fallback_header() {
        ?>
        <header class="dst-header dst-header-fallback">
            <div class="dst-container">
                <div class="dst-header-inner">
                    <div class="dst-logo">
                        <?php if (has_custom_logo()): ?>
                            <?php the_custom_logo(); ?>
                        <?php else: ?>
                            <a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
                        <?php endif; ?>
                    </div>
                    <nav class="dst-nav">
                        <?php
                        wp_nav_menu([
                            'theme_location' => 'primary',
                            'container' => false,
                            'fallback_cb' => false,
                        ]);
                        ?>
                    </nav>
                </div>
            </div>
        </header>
        <?php
    }

    /**
     * فوتر فالبک
     */
    private function render_fallback_footer() {
        ?>
        <footer class="dst-footer dst-footer-fallback">
            <div class="dst-container">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
            </div>
        </footer>
        <?php
    }

    /**
     * رندر فیلد تنظیمات
     */
    private function render_field($field, $name, $value) {
        $type = $field['type'] ?? 'text';
        $id = esc_attr($name);

        switch ($type) {
            case 'text':
            case 'url':
                ?>
                <input type="text"
                       id="<?php echo $id; ?>"
                       name="<?php echo $id; ?>"
                       value="<?php echo esc_attr($value); ?>"
                       class="regular-text">
                <?php
                break;

            case 'textarea':
                ?>
                <textarea id="<?php echo $id; ?>"
                          name="<?php echo $id; ?>"
                          rows="4"
                          class="large-text"><?php echo esc_textarea($value); ?></textarea>
                <?php
                break;

            case 'checkbox':
                ?>
                <label>
                    <input type="checkbox"
                           id="<?php echo $id; ?>"
                           name="<?php echo $id; ?>"
                           value="1"
                           <?php checked($value, true); ?>>
                    <?php echo isset($field['checkbox_label']) ? esc_html($field['checkbox_label']) : 'فعال'; ?>
                </label>
                <?php
                break;

            case 'select':
                ?>
                <select id="<?php echo $id; ?>" name="<?php echo $id; ?>">
                    <?php foreach ($field['options'] as $opt_value => $opt_label): ?>
                        <option value="<?php echo esc_attr($opt_value); ?>" <?php selected($value, $opt_value); ?>>
                            <?php echo esc_html($opt_label); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php
                break;

            case 'color':
                ?>
                <input type="color"
                       id="<?php echo $id; ?>"
                       name="<?php echo $id; ?>"
                       value="<?php echo esc_attr($value); ?>">
                <?php
                break;

            case 'number':
                ?>
                <input type="number"
                       id="<?php echo $id; ?>"
                       name="<?php echo $id; ?>"
                       value="<?php echo esc_attr($value); ?>"
                       class="small-text"
                       <?php echo isset($field['min']) ? 'min="' . esc_attr($field['min']) . '"' : ''; ?>
                       <?php echo isset($field['max']) ? 'max="' . esc_attr($field['max']) . '"' : ''; ?>>
                <?php
                break;

            case 'image':
                ?>
                <div class="dst-image-field">
                    <input type="hidden" id="<?php echo $id; ?>" name="<?php echo $id; ?>" value="<?php echo esc_attr($value); ?>">
                    <div class="dst-image-preview">
                        <?php if ($value): ?>
                            <img src="<?php echo esc_url($value); ?>" style="max-width: 200px; max-height: 100px;">
                        <?php endif; ?>
                    </div>
                    <button type="button" class="button dst-upload-image">انتخاب تصویر</button>
                    <button type="button" class="button dst-remove-image" <?php echo !$value ? 'style="display:none;"' : ''; ?>>حذف</button>
                </div>
                <?php
                break;
        }

        if (isset($field['description'])) {
            echo '<p class="description">' . esc_html($field['description']) . '</p>';
        }
    }
}

// راه‌اندازی
global $dst_header_footer_manager;
$dst_header_footer_manager = new DST_Header_Footer_Manager();

/**
 * توابع کمکی برای استفاده در قالب
 */

function dst_render_header() {
    global $dst_header_footer_manager;
    if ($dst_header_footer_manager) {
        $dst_header_footer_manager->render_header();
    }
}

function dst_render_footer() {
    global $dst_header_footer_manager;
    if ($dst_header_footer_manager) {
        $dst_header_footer_manager->render_footer();
    }
}

function dst_get_active_header() {
    global $dst_header_footer_manager;
    return $dst_header_footer_manager ? $dst_header_footer_manager->get_active_header() : 'default';
}

function dst_get_active_footer() {
    global $dst_header_footer_manager;
    return $dst_header_footer_manager ? $dst_header_footer_manager->get_active_footer() : 'default';
}

function dst_get_header_setting($key = null) {
    global $dst_header_footer_manager;
    if (!$dst_header_footer_manager) {
        return $key ? null : [];
    }

    $active_header = $dst_header_footer_manager->get_active_header();
    $settings = $dst_header_footer_manager->get_header_settings($active_header);

    if ($key) {
        return isset($settings[$key]) ? $settings[$key] : null;
    }

    return $settings;
}

function dst_get_footer_setting($key = null) {
    global $dst_header_footer_manager;
    if (!$dst_header_footer_manager) {
        return $key ? null : [];
    }

    $active_footer = $dst_header_footer_manager->get_active_footer();
    $settings = $dst_header_footer_manager->get_footer_settings($active_footer);

    if ($key) {
        return isset($settings[$key]) ? $settings[$key] : null;
    }

    return $settings;
}
