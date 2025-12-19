#!/usr/bin/env php
<?php
/**
 * DST Module Generator
 * 
 * ابزار CLI برای ساخت سریع ماژول‌های جدید
 * 
 * استفاده:
 * php create-module.php module-name "Module Title"
 * 
 * @package Developer_Starter
 */

// رنگ‌های CLI
class Colors {
    const GREEN  = "\033[0;32m";
    const BLUE   = "\033[0;34m";
    const YELLOW = "\033[1;33m";
    const RED    = "\033[0;31m";
    const RESET  = "\033[0m";
}

/**
 * نمایش پیام
 */
function message($text, $color = Colors::RESET) {
    echo $color . $text . Colors::RESET . PHP_EOL;
}

/**
 * نمایش خطا و خروج
 */
function error($text) {
    message("❌ خطا: " . $text, Colors::RED);
    exit(1);
}

/**
 * نمایش موفقیت
 */
function success($text) {
    message("✅ " . $text, Colors::GREEN);
}

/**
 * نمایش اطلاعات
 */
function info($text) {
    message("ℹ️  " . $text, Colors::BLUE);
}

/**
 * دریافت ورودی
 */
function prompt($question) {
    echo Colors::YELLOW . $question . Colors::RESET . " ";
    return trim(fgets(STDIN));
}

/**
 * چک آرگومان‌ها
 */
if ($argc < 2) {
    error("استفاده: php create-module.php module-name \"Module Title\"");
}

$module_name = $argv[1];
$module_title = $argv[2] ?? ucfirst(str_replace('-', ' ', $module_name));

// اعتبارسنجی نام
if (!preg_match('/^[a-z0-9-]+$/', $module_name)) {
    error("نام ماژول فقط می‌تواند شامل حروف کوچک، اعداد و خط تیره باشد");
}

// مسیر modules
$theme_dir = dirname(__FILE__);
$modules_dir = $theme_dir . '/modules';

if (!is_dir($modules_dir)) {
    mkdir($modules_dir, 0755, true);
}

$module_dir = $modules_dir . '/' . $module_name;

// چک وجود ماژول
if (is_dir($module_dir)) {
    error("ماژول '$module_name' از قبل وجود دارد!");
}

// دریافت اطلاعات بیشتر
info("ساخت ماژول جدید: $module_name");
echo PHP_EOL;

$description = prompt("توضیح کوتاه:");
$author = prompt("نام توسعه‌دهنده:");
$version = prompt("نسخه (پیش‌فرض: 1.0.0):") ?: "1.0.0";

// ساخت پوشه‌ها
$folders = [
    $module_dir,
    $module_dir . '/assets',
    $module_dir . '/includes',
    $module_dir . '/templates',
];

foreach ($folders as $folder) {
    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }
}

// ساخت module.json
$config = [
    'name' => $module_name,
    'title' => $module_title,
    'description' => $description,
    'version' => $version,
    'author' => $author,
    'requires' => [],
    'php_version' => '7.4',
    'wp_version' => '6.0',
    'priority' => 10,
];

file_put_contents(
    $module_dir . '/module.json',
    json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
);

// ساخت init.php
$class_name = str_replace('-', '_', ucwords($module_name, '-'));
$init_content = <<<PHP
<?php
/**
 * {$module_title} - Init
 * 
 * {$description}
 * 
 * @package Developer_Starter
 * @subpackage Modules/{$class_name}
 * @version {$version}
 * @author {$author}
 */

defined('ABSPATH') || exit;

/**
 * کلاس اصلی ماژول {$module_title}
 */
class DST_{$class_name} {
    
    /**
     * تنظیمات ماژول
     */
    private \$config;
    
    /**
     * مسیر ماژول
     */
    private \$module_path;
    
    /**
     * URL ماژول
     */
    private \$module_url;
    
    /**
     * سازنده
     */
    public function __construct() {
        // گرفتن اطلاعات ماژول
        \$module = dst_get_module('{$module_name}');
        
        if (\$module) {
            \$this->config      = \$module['config'];
            \$this->module_path = \$module['path'];
            \$this->module_url  = \$module['url'];
        }
        
        // هوک‌ها
        add_action('init', [\$this, 'init']);
    }
    
    /**
     * راه‌اندازی ماژول
     */
    public function init() {
        // کدهای اصلی ماژول اینجا
    }
}

/**
 * راه‌اندازی ماژول
 */
new DST_{$class_name}();

PHP;

file_put_contents($module_dir . '/init.php', $init_content);

// ساخت README.md
$readme_content = <<<MD
# {$module_title}

{$description}

## نصب

این ماژول بصورت خودکار توسط قالب لود می‌شود.

## استفاده

```php
// کد مثال اینجا
```

## تنظیمات

تنظیمات در `module.json` قابل تغییر است.

## نسخه

{$version}

## توسعه‌دهنده

{$author}

MD;

file_put_contents($module_dir . '/README.md', $readme_content);

// ساخت style.css
$css_content = <<<CSS
/**
 * {$module_title} - Styles
 * 
 * استایل‌های ماژول {$module_title}
 * 
 * @version {$version}
 */

.dst-{$module_name} {
    /* استایل‌های اصلی */
}

CSS;

file_put_contents($module_dir . '/assets/style.css', $css_content);

// ساخت script.js
$js_content = <<<JS
/**
 * {$module_title} - Script
 * 
 * اسکریپت‌های ماژول {$module_title}
 * 
 * @version {$version}
 */

(function($) {
    'use strict';
    
    /**
     * راه‌اندازی ماژول
     */
    function init() {
        console.log('{$module_title} loaded');
    }
    
    // اجرا بعد از لود صفحه
    $(document).ready(init);
    
})(jQuery);

JS;

file_put_contents($module_dir . '/assets/script.js', $js_content);

// خلاصه نهایی
echo PHP_EOL;
success("ماژول '{$module_name}' با موفقیت ساخته شد!");
echo PHP_EOL;

info("ساختار ایجاد شده:");
echo "  📁 modules/{$module_name}/" . PHP_EOL;
echo "    ├── 📄 module.json" . PHP_EOL;
echo "    ├── 📄 init.php" . PHP_EOL;
echo "    ├── 📄 README.md" . PHP_EOL;
echo "    ├── 📁 assets/" . PHP_EOL;
echo "    │   ├── style.css" . PHP_EOL;
echo "    │   └── script.js" . PHP_EOL;
echo "    ├── 📁 includes/" . PHP_EOL;
echo "    └── 📁 templates/" . PHP_EOL;
echo PHP_EOL;

info("مراحل بعدی:");
echo "  1. فایل init.php را ویرایش کنید" . PHP_EOL;
echo "  2. استایل‌ها و اسکریپت‌ها را اضافه کنید" . PHP_EOL;
echo "  3. ماژول بصورت خودکار لود می‌شود!" . PHP_EOL;
echo PHP_EOL;

message("🎉 موفق باشید!", Colors::GREEN);
