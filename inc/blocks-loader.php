<?php
/**
 * Blocks Loader - سیستم لود خودکار بلاک‌های ACF
 * 
 * ★★★ این فایل قلب سیستم ماژولار است ★★★
 * 
 * هر پوشه داخل /blocks که شامل block.json باشد،
 * بصورت خودکار به عنوان بلاک ACF ثبت می‌شود.
 * 
 * ساختار هر بلاک:
 * ─────────────────────────────────────────
 * /blocks/نام-بلاک/
 *   ├── block.json      ← تنظیمات بلاک (اجباری)
 *   ├── render.php      ← کد نمایش (اجباری)
 *   ├── style.css       ← استایل (اختیاری)
 *   ├── script.js       ← جاوااسکریپت (اختیاری)
 *   └── fields.php      ← فیلدهای ACF (اختیاری)
 * ─────────────────────────────────────────
 * 
 * @package Developer_Starter
 */

defined('ABSPATH') || exit;

/**
 * کلاس مدیریت بلاک‌ها
 */
class DST_Block_Loader {
    
    /**
     * لیست بلاک‌های ثبت شده
     */
    private $registered_blocks = [];
    
    /**
     * سازنده
     */
    public function __construct() {
        add_action('acf/init', [$this, 'register_blocks']);
        add_action('acf/init', [$this, 'register_block_fields']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_block_assets']);
    }
    
    /**
     * ثبت تمام بلاک‌ها
     */
    public function register_blocks() {
        // چک ACF Pro
        if (!function_exists('acf_register_block_type')) {
            add_action('admin_notices', function() {
                echo '<div class="notice notice-error"><p>';
                echo '<strong>Developer Starter:</strong> ';
                echo 'پلاگین ACF Pro برای استفاده از بلاک‌ها نیاز است.';
                echo '</p></div>';
            });
            return;
        }
        
        // پیدا کردن بلاک‌ها
        $block_folders = glob(DST_BLOCKS_PATH . '/*', GLOB_ONLYDIR);
        
        if (!$block_folders) {
            return;
        }
        
        foreach ($block_folders as $folder) {
            $this->register_single_block($folder);
        }
    }
    
    /**
     * ثبت یک بلاک
     */
    private function register_single_block($folder) {
        $json_file = $folder . '/block.json';
        
        // چک وجود block.json
        if (!file_exists($json_file)) {
            return;
        }
        
        // خواندن تنظیمات
        $config = json_decode(file_get_contents($json_file), true);
        
        if (!$config || !isset($config['name'])) {
            return;
        }
        
        $block_name = $config['name'];
        
        // تنظیمات پیش‌فرض
        $settings = wp_parse_args($config, [
            'title'       => ucfirst($block_name),
            'description' => '',
            'category'    => 'developer-starter',
            'icon'        => 'block-default',
            'keywords'    => [],
            'mode'        => 'preview',
            'align'       => 'full',
            'supports'    => [
                'align'           => ['wide', 'full'],
                'mode'            => true,
                'anchor'          => true,
                'customClassName' => true,
            ],
        ]);
        
        // اضافه کردن render callback
        $settings['render_callback'] = function($block, $content, $is_preview, $post_id) use ($folder, $block_name) {
            $this->render_block($folder, $block_name, $block, $is_preview, $post_id);
        };
        
        // ثبت بلاک
        acf_register_block_type($settings);
        
        // ذخیره اطلاعات
        $this->registered_blocks[$block_name] = [
            'path'   => $folder,
            'config' => $settings,
        ];
    }
    
    /**
     * رندر بلاک
     */
    private function render_block($folder, $block_name, $block, $is_preview, $post_id) {
        $render_file = $folder . '/render.php';
        
        if (!file_exists($render_file)) {
            if ($is_preview) {
                echo '<div class="dst-block-error">';
                echo 'فایل render.php یافت نشد: ' . esc_html($block_name);
                echo '</div>';
            }
            return;
        }
        
        // متغیرهای در دسترس در render.php
        $block_id   = 'dst-' . $block_name . '-' . $block['id'];
        $class_name = 'dst-block dst-block-' . $block_name;
        
        if (!empty($block['className'])) {
            $class_name .= ' ' . $block['className'];
        }
        
        if (!empty($block['align'])) {
            $class_name .= ' align' . $block['align'];
        }
        
        if ($is_preview) {
            $class_name .= ' is-preview';
        }
        
        // لود فایل
        include $render_file;
    }
    
    /**
     * لود CSS و JS بلاک‌ها
     */
    public function enqueue_block_assets() {
        foreach ($this->registered_blocks as $name => $block) {
            // CSS
            $css_file = $block['path'] . '/style.css';
            if (file_exists($css_file)) {
                wp_enqueue_style(
                    'dst-block-' . $name,
                    DST_URL . '/blocks/' . $name . '/style.css',
                    ['dst-main'],
                    filemtime($css_file)
                );
            }
            
            // JS
            $js_file = $block['path'] . '/script.js';
            if (file_exists($js_file)) {
                wp_enqueue_script(
                    'dst-block-' . $name,
                    DST_URL . '/blocks/' . $name . '/script.js',
                    ['dst-main'],
                    filemtime($js_file),
                    true
                );
            }
        }
    }
    
    /**
     * ثبت فیلدهای ACF
     */
    public function register_block_fields() {
        foreach ($this->registered_blocks as $name => $block) {
            $fields_file = $block['path'] . '/fields.php';
            if (file_exists($fields_file)) {
                include $fields_file;
            }
        }
    }
    
    /**
     * گرفتن لیست بلاک‌ها
     */
    public function get_blocks() {
        return $this->registered_blocks;
    }
}

/**
 * ثبت دسته‌بندی بلاک‌ها
 */
function dst_register_block_category($categories) {
    return array_merge(
        [
            [
                'slug'  => 'developer-starter',
                'title' => __('بلاک‌های قالب', 'developer-starter'),
                'icon'  => 'layout',
            ],
        ],
        $categories
    );
}
add_filter('block_categories_all', 'dst_register_block_category');

/**
 * راه‌اندازی
 */
global $dst_block_loader;
$dst_block_loader = new DST_Block_Loader();
