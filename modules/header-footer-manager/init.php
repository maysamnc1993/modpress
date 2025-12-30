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
 * @version 2.0.0
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
        
        // هوک‌ها
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'admin_assets']);
        add_action('wp_enqueue_scripts', [$this, 'frontend_assets']);
        add_action('admin_init', [$this, 'handle_save_settings']);
    }
    
    /**
     * تنظیمات پیش‌فرض
     */
    private function get_default_settings() {
        return [
            'active_header' => 'default',
            'active_footer' => 'default',
            'header_settings' => [], // تنظیمات هر هدر
            'footer_settings' => [], // تنظیمات هر فوتر
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
        
        // ادغام با مقادیر پیش‌فرض
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
        
        // ادغام با مقادیر پیش‌فرض
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
        // ثبت صفحه - منو توسط admin-menu-manager نمایش داده میشه
        add_menu_page(
            'هدر و فوتر',
            'هدر و فوتر',
            'manage_options',
            'dst-header-footer',
            [$this, 'render_admin_page'],
            'dashicons-admin-customizer',
            999 // آخرین موقعیت - توسط admin-menu-manager مخفی میشه
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
            '2.0.0'
        );
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
     * صفحه ادمین
     */
    public function render_admin_page() {
        $headers = $this->get_available_headers();
        $footers = $this->get_available_footers();
        $active_header = $this->settings['active_header'];
        $active_footer = $this->settings['active_footer'];
        ?>
        <div class="wrap dst-hf-wrap">
            <h1>🎨 مدیریت هدر و فوتر</h1>
            <p class="description">هدر و فوتر مورد نظر خود را انتخاب کنید</p>
            
            <form method="post" action="">
                <?php wp_nonce_field('dst_hf_settings_nonce'); ?>
                
                <!-- بخش هدر -->
                <div class="dst-hf-section">
                    <h2>📌 انتخاب هدر</h2>
                    
                    <?php if (empty($headers)): ?>
                        <div class="dst-hf-empty">
                            <p>هیچ هدری یافت نشد!</p>
                            <p>پوشه‌های هدر را در <code>modules/header-footer-manager/templates/headers/</code> قرار دهید.</p>
                        </div>
                    <?php else: ?>
                        <div class="dst-hf-grid">
                            <?php foreach ($headers as $name => $config): ?>
                                <label class="dst-hf-card <?php echo $active_header === $name ? 'active' : ''; ?>">
                                    <input type="radio" name="active_header" value="<?php echo esc_attr($name); ?>" 
                                           <?php checked($active_header, $name); ?>>
                                    
                                    <div class="dst-hf-card-thumb">
                                        <?php if ($config['thumbnail']): ?>
                                            <img src="<?php echo esc_url($config['thumbnail']); ?>" alt="<?php echo esc_attr($config['title']); ?>">
                                            <button type="button" class="dst-hf-zoom-btn" data-lightbox="<?php echo esc_url($config['thumbnail']); ?>" data-title="<?php echo esc_attr($config['title']); ?>">
                                                <span class="dashicons dashicons-search"></span>
                                            </button>
                                        <?php else: ?>
                                            <div class="dst-hf-no-thumb">
                                                <span class="dashicons dashicons-format-image"></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="dst-hf-card-info">
                                        <h3><?php echo esc_html($config['title']); ?></h3>
                                        <?php if ($config['description']): ?>
                                            <p><?php echo esc_html($config['description']); ?></p>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="dst-hf-card-check">
                                        <span class="dashicons dashicons-yes-alt"></span>
                                    </div>
                                </label>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- تنظیمات هدرها -->
                        <?php foreach ($headers as $name => $config): ?>
                            <?php if (isset($config['settings']) && !empty($config['settings'])): ?>
                                <?php $header_settings = $this->get_header_settings($name); ?>
                                <div class="dst-hf-template-settings" data-template="header-<?php echo esc_attr($name); ?>" 
                                     style="<?php echo $active_header === $name ? '' : 'display:none;'; ?>">
                                    <h3>⚙️ تنظیمات <?php echo esc_html($config['title']); ?></h3>
                                    <table class="form-table">
                                        <?php foreach ($config['settings'] as $field_key => $field): ?>
                                            <tr>
                                                <th scope="row">
                                                    <label for="header_<?php echo esc_attr($name . '_' . $field_key); ?>">
                                                        <?php echo esc_html($field['label']); ?>
                                                    </label>
                                                </th>
                                                <td>
                                                    <?php $this->render_field($field, 'header_' . $name . '_' . $field_key, $header_settings[$field_key] ?? $field['default']); ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        
                    <?php endif; ?>
                </div>
                
                <!-- بخش فوتر -->
                <div class="dst-hf-section">
                    <h2>📌 انتخاب فوتر</h2>
                    
                    <?php if (empty($footers)): ?>
                        <div class="dst-hf-empty">
                            <p>هیچ فوتری یافت نشد!</p>
                            <p>پوشه‌های فوتر را در <code>modules/header-footer-manager/templates/footers/</code> قرار دهید.</p>
                        </div>
                    <?php else: ?>
                        <div class="dst-hf-grid">
                            <?php foreach ($footers as $name => $config): ?>
                                <label class="dst-hf-card <?php echo $active_footer === $name ? 'active' : ''; ?>">
                                    <input type="radio" name="active_footer" value="<?php echo esc_attr($name); ?>" 
                                           <?php checked($active_footer, $name); ?>>
                                    
                                    <div class="dst-hf-card-thumb">
                                        <?php if ($config['thumbnail']): ?>
                                            <img src="<?php echo esc_url($config['thumbnail']); ?>" alt="<?php echo esc_attr($config['title']); ?>">
                                            <button type="button" class="dst-hf-zoom-btn" data-lightbox="<?php echo esc_url($config['thumbnail']); ?>" data-title="<?php echo esc_attr($config['title']); ?>">
                                                <span class="dashicons dashicons-search"></span>
                                            </button>
                                        <?php else: ?>
                                            <div class="dst-hf-no-thumb">
                                                <span class="dashicons dashicons-format-image"></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="dst-hf-card-info">
                                        <h3><?php echo esc_html($config['title']); ?></h3>
                                        <?php if ($config['description']): ?>
                                            <p><?php echo esc_html($config['description']); ?></p>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="dst-hf-card-check">
                                        <span class="dashicons dashicons-yes-alt"></span>
                                    </div>
                                </label>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- تنظیمات فوترها -->
                        <?php foreach ($footers as $name => $config): ?>
                            <?php if (isset($config['settings']) && !empty($config['settings'])): ?>
                                <?php $footer_settings = $this->get_footer_settings($name); ?>
                                <div class="dst-hf-template-settings" data-template="footer-<?php echo esc_attr($name); ?>" 
                                     style="<?php echo $active_footer === $name ? '' : 'display:none;'; ?>">
                                    <h3>⚙️ تنظیمات <?php echo esc_html($config['title']); ?></h3>
                                    <table class="form-table">
                                        <?php foreach ($config['settings'] as $field_key => $field): ?>
                                            <tr>
                                                <th scope="row">
                                                    <label for="footer_<?php echo esc_attr($name . '_' . $field_key); ?>">
                                                        <?php echo esc_html($field['label']); ?>
                                                    </label>
                                                </th>
                                                <td>
                                                    <?php $this->render_field($field, 'footer_' . $name . '_' . $field_key, $footer_settings[$field_key] ?? $field['default']); ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        
                    <?php endif; ?>
                </div>
                
                <p class="submit">
                    <button type="submit" name="dst_hf_save" class="button button-primary button-large">
                        💾 ذخیره تنظیمات
                    </button>
                </p>
            </form>
            
            <!-- راهنما -->
            <div class="dst-hf-help">
                <h3>📚 راهنمای افزودن هدر/فوتر جدید</h3>
                <p>برای افزودن هدر یا فوتر جدید، یک پوشه با ساختار زیر ایجاد کنید:</p>
                <pre>
templates/headers/my-header/
├── config.json      ← تنظیمات (اختیاری)
├── template.php     ← کد HTML (اجباری)
├── style.css        ← استایل (اختیاری)
├── script.js        ← جاوااسکریپت (اختیاری)
└── screenshot.png   ← تصویر پیش‌نمایش (اختیاری)
                </pre>
                
                <p><strong>نمونه config.json:</strong></p>
                <pre>
{
    "name": "my-header",
    "title": "هدر سفارشی من",
    "description": "یک هدر زیبا با منوی همبرگری",
    "version": "1.0.0"
}
                </pre>
            </div>

            <!-- لایت‌باکس -->
            <div class="dst-lightbox" id="dst-lightbox">
                <div class="dst-lightbox-content">
                    <button type="button" class="dst-lightbox-close">
                        <span class="dashicons dashicons-no-alt"></span>
                    </button>
                    <button type="button" class="dst-lightbox-nav prev">
                        <span class="dashicons dashicons-arrow-right-alt2"></span>
                    </button>
                    <button type="button" class="dst-lightbox-nav next">
                        <span class="dashicons dashicons-arrow-left-alt2"></span>
                    </button>
                    <img src="" alt="" class="dst-lightbox-image">
                    <div class="dst-lightbox-title"></div>
                </div>
            </div>
        </div>

        <script>
        jQuery(document).ready(function($) {
            // کلیک روی کارت
            $('.dst-hf-card').on('click', function(e) {
                // اگر روی دکمه زوم کلیک شده، کارت رو انتخاب نکن
                if ($(e.target).closest('.dst-hf-zoom-btn').length) {
                    return;
                }

                var $this = $(this);
                var $section = $this.closest('.dst-hf-section');

                // حذف active از همه کارت‌های این بخش
                $section.find('.dst-hf-card').removeClass('active');

                // اضافه کردن active به کارت کلیک شده
                $this.addClass('active');

                // انتخاب radio
                $this.find('input[type="radio"]').prop('checked', true).trigger('change');
            });

            // وقتی radio عوض میشه
            $('input[name="active_header"]').on('change', function() {
                var $card = $(this).closest('.dst-hf-card');
                var $section = $card.closest('.dst-hf-section');
                var templateName = $(this).val();

                // آپدیت کارت‌ها
                $section.find('.dst-hf-card').removeClass('active');
                $card.addClass('active');

                // نمایش/مخفی کردن تنظیمات
                $section.find('.dst-hf-template-settings').hide();
                $section.find('[data-template="header-' + templateName + '"]').show();
            });

            $('input[name="active_footer"]').on('change', function() {
                var $card = $(this).closest('.dst-hf-card');
                var $section = $card.closest('.dst-hf-section');
                var templateName = $(this).val();

                // آپدیت کارت‌ها
                $section.find('.dst-hf-card').removeClass('active');
                $card.addClass('active');

                // نمایش/مخفی کردن تنظیمات
                $section.find('.dst-hf-template-settings').hide();
                $section.find('[data-template="footer-' + templateName + '"]').show();
            });

            // لایت‌باکس
            var $lightbox = $('#dst-lightbox');
            var $lightboxImage = $lightbox.find('.dst-lightbox-image');
            var $lightboxTitle = $lightbox.find('.dst-lightbox-title');
            var currentImages = [];
            var currentIndex = 0;

            // جمع‌آوری تصاویر
            function collectImages($section) {
                var images = [];
                $section.find('.dst-hf-zoom-btn').each(function() {
                    images.push({
                        src: $(this).data('lightbox'),
                        title: $(this).data('title')
                    });
                });
                return images;
            }

            // باز کردن لایت‌باکس
            $('.dst-hf-zoom-btn').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                var $section = $(this).closest('.dst-hf-section');
                currentImages = collectImages($section);
                currentIndex = $section.find('.dst-hf-zoom-btn').index(this);

                showImage(currentIndex);
                $lightbox.addClass('is-open');
                $('body').css('overflow', 'hidden');
            });

            // نمایش تصویر
            function showImage(index) {
                if (currentImages[index]) {
                    $lightboxImage.attr('src', currentImages[index].src);
                    $lightboxTitle.text(currentImages[index].title);
                }
            }

            // بستن لایت‌باکس
            $lightbox.find('.dst-lightbox-close').on('click', closeLightbox);
            $lightbox.on('click', function(e) {
                if ($(e.target).hasClass('dst-lightbox')) {
                    closeLightbox();
                }
            });

            function closeLightbox() {
                $lightbox.removeClass('is-open');
                $('body').css('overflow', '');
            }

            // ناوبری
            $lightbox.find('.dst-lightbox-nav.prev').on('click', function() {
                currentIndex = (currentIndex - 1 + currentImages.length) % currentImages.length;
                showImage(currentIndex);
            });

            $lightbox.find('.dst-lightbox-nav.next').on('click', function() {
                currentIndex = (currentIndex + 1) % currentImages.length;
                showImage(currentIndex);
            });

            // کیبورد
            $(document).on('keydown', function(e) {
                if (!$lightbox.hasClass('is-open')) return;

                if (e.key === 'Escape') closeLightbox();
                if (e.key === 'ArrowRight') {
                    currentIndex = (currentIndex - 1 + currentImages.length) % currentImages.length;
                    showImage(currentIndex);
                }
                if (e.key === 'ArrowLeft') {
                    currentIndex = (currentIndex + 1) % currentImages.length;
                    showImage(currentIndex);
                }
            });
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
            // فالبک به هدر پیش‌فرض
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
            // فالبک به فوتر پیش‌فرض
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
        
        // نمایش توضیحات
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

/**
 * رندر هدر انتخاب شده
 */
function dst_render_header() {
    global $dst_header_footer_manager;
    if ($dst_header_footer_manager) {
        $dst_header_footer_manager->render_header();
    }
}

/**
 * رندر فوتر انتخاب شده
 */
function dst_render_footer() {
    global $dst_header_footer_manager;
    if ($dst_header_footer_manager) {
        $dst_header_footer_manager->render_footer();
    }
}

/**
 * گرفتن نام هدر فعال
 */
function dst_get_active_header() {
    global $dst_header_footer_manager;
    return $dst_header_footer_manager ? $dst_header_footer_manager->get_active_header() : 'default';
}

/**
 * گرفتن نام فوتر فعال
 */
function dst_get_active_footer() {
    global $dst_header_footer_manager;
    return $dst_header_footer_manager ? $dst_header_footer_manager->get_active_footer() : 'default';
}

/**
 * گرفتن تنظیمات هدر فعال
 * 
 * @param string $key (اختیاری) کلید تنظیم خاص
 * @return mixed
 */
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

/**
 * گرفتن تنظیمات فوتر فعال
 * 
 * @param string $key (اختیاری) کلید تنظیم خاص
 * @return mixed
 */
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
