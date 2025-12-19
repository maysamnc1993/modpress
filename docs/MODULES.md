# 🧩 سیستم ماژول‌ها (Modules System)

سیستم قدرتمند لود خودکار ماژول‌ها برای افزودن قابلیت‌های جدید به قالب

---

## 📋 فهرست

1. [معرفی](#معرفی)
2. [ساختار ماژول](#ساختار-ماژول)
3. [ساخت ماژول جدید](#ساخت-ماژول-جدید)
4. [تنظیمات module.json](#تنظیمات-modulejson)
5. [توابع کمکی](#توابع-کمکی)
6. [هوک‌ها](#هوک‌ها)
7. [مثال‌های عملی](#مثال‌های-عملی)

---

## 📖 معرفی

### ماژول چیست؟

ماژول یک پکیج کامل و مستقل است که:
- یک قابلیت خاص را به قالب اضافه می‌کند
- تمام کدها، استایل‌ها و اسکریپت‌های خود را دارد
- می‌تواند وابستگی به ماژول‌های دیگر داشته باشد
- بصورت خودکار لود می‌شود
- می‌تواند فعال/غیرفعال شود

### مزایا

✅ **ماژولار**: هر قابلیت جدا از بقیه  
✅ **مستقل**: قابل استفاده در پروژه‌های دیگر  
✅ **خودکار**: بدون نیاز به کد اضافه در functions.php  
✅ **قابل مدیریت**: فعال/غیرفعال آسان  
✅ **استاندارد**: ساختار یکسان برای همه

---

## 🗂️ ساختار ماژول

هر ماژول یک پوشه در `/modules/` است:

```
modules/
└── نام-ماژول/
    ├── module.json         ← تنظیمات (اجباری)
    ├── init.php           ← فایل اصلی (اجباری)
    ├── functions.php      ← توابع عمومی (اختیاری)
    ├── admin.php          ← بخش ادمین (اختیاری)
    ├── assets/            ← فایل‌های استاتیک (اختیاری)
    │   ├── style.css      ← استایل Frontend
    │   ├── script.js      ← اسکریپت Frontend
    │   ├── admin.css      ← استایل Admin
    │   └── admin.js       ← اسکریپت Admin
    ├── includes/          ← کلاس‌های کمکی (اختیاری)
    ├── templates/         ← قالب‌های HTML (اختیاری)
    └── README.md          ← مستندات (اختیاری)
```

---

## 🚀 ساخت ماژول جدید

### قدم ۱: ساخت پوشه

```bash
mkdir -p modules/my-module/assets
```

### قدم ۲: ساخت module.json

```json
{
    "name": "my-module",
    "title": "ماژول من",
    "description": "توضیح کوتاه ماژول",
    "version": "1.0.0",
    "author": "نام شما",
    "requires": [],
    "php_version": "7.4",
    "wp_version": "6.0",
    "priority": 10
}
```

### قدم ۳: ساخت init.php

```php
<?php
/**
 * My Module - Init
 */

defined('ABSPATH') || exit;

class My_Module {
    
    public function __construct() {
        // هوک‌ها
        add_action('init', [$this, 'init']);
    }
    
    public function init() {
        // کدهای اصلی ماژول
    }
}

new My_Module();
```

### قدم ۴: تست

ماژول بصورت خودکار لود می‌شود! ✅

---

## ⚙️ تنظیمات module.json

### فیلدهای اصلی

| فیلد | نوع | الزامی | توضیح |
|------|-----|--------|-------|
| `name` | string | ✅ | نام یونیک ماژول (kebab-case) |
| `title` | string | ✅ | عنوان نمایشی |
| `description` | string | ❌ | توضیح کوتاه |
| `version` | string | ✅ | نسخه (semantic versioning) |
| `author` | string | ❌ | نام توسعه‌دهنده |
| `requires` | array | ❌ | لیست ماژول‌های مورد نیاز |
| `php_version` | string | ❌ | حداقل نسخه PHP (پیش‌فرض: 7.4) |
| `wp_version` | string | ❌ | حداقل نسخه وردپرس (پیش‌فرض: 6.0) |
| `priority` | int | ❌ | اولویت لود (پیش‌فرض: 10) |

### مثال کامل

```json
{
    "name": "advanced-search",
    "title": "جستجوی پیشرفته",
    "description": "سیستم جستجوی قدرتمند با فیلترها",
    "version": "2.1.0",
    "author": "Meysam Khatami",
    "requires": ["ajax-handler", "cache-manager"],
    "php_version": "8.0",
    "wp_version": "6.2",
    "priority": 20,
    "settings": {
        "posts_per_page": 10,
        "cache_enabled": true
    },
    "features": [
        "AJAX search",
        "Custom filters",
        "Caching"
    ]
}
```

---

## 🔧 توابع کمکی

### dst_modules()

دسترسی به instance لودر ماژول‌ها

```php
$loader = dst_modules();
```

### dst_is_module_active()

چک کردن فعال بودن ماژول

```php
if (dst_is_module_active('contact-form')) {
    // ماژول فعال است
}
```

### dst_get_module()

گرفتن اطلاعات ماژول

```php
$module = dst_get_module('contact-form');
// Array شامل: path, url, config
```

### dst_module_path()

گرفتن مسیر فایل در ماژول

```php
// مسیر پوشه ماژول
$path = dst_module_path('contact-form');

// مسیر فایل خاص
$template = dst_module_path('contact-form', 'templates/form.php');
```

### dst_module_url()

گرفتن URL ماژول

```php
// URL پوشه ماژول
$url = dst_module_url('contact-form');

// URL فایل خاص
$image = dst_module_url('contact-form', 'assets/logo.png');
```

---

## 🪝 هوک‌ها

### dst_modules_loaded

بعد از لود تمام ماژول‌ها

```php
add_action('dst_modules_loaded', function($modules) {
    // $modules = آرایه تمام ماژول‌های لود شده
});
```

### dst_module_{name}_loaded

بعد از لود یک ماژول خاص

```php
add_action('dst_module_contact-form_loaded', function($config) {
    // $config = تنظیمات ماژول
});
```

---

## 💡 مثال‌های عملی

### ماژول ساده: شورت‌کد دکمه

**modules/button-shortcode/module.json**
```json
{
    "name": "button-shortcode",
    "title": "شورت‌کد دکمه",
    "version": "1.0.0"
}
```

**modules/button-shortcode/init.php**
```php
<?php
defined('ABSPATH') || exit;

add_shortcode('dst_button', function($atts) {
    $atts = shortcode_atts([
        'text' => 'کلیک کنید',
        'url'  => '#',
    ], $atts);
    
    return sprintf(
        '<a href="%s" class="btn">%s</a>',
        esc_url($atts['url']),
        esc_html($atts['text'])
    );
});
```

### ماژول با وابستگی

**modules/analytics/module.json**
```json
{
    "name": "analytics",
    "title": "آنالیتیکس",
    "requires": ["cookies-handler"],
    "version": "1.0.0"
}
```

### ماژول با تنظیمات

**modules/social-share/init.php**
```php
<?php
$module = dst_get_module('social-share');
$config = $module['config'];

// استفاده از تنظیمات
$twitter = $config['settings']['twitter_enabled'] ?? true;
```

### لود قالب از ماژول

```php
$template = dst_module_path('slider', 'templates/slide.php');

if ($template) {
    include $template;
}
```

### اضافه کردن استایل سفارشی

**modules/custom-widget/admin.php**
```php
<?php
add_action('admin_enqueue_scripts', function() {
    $module_url = dst_module_url('custom-widget');
    
    wp_enqueue_style(
        'custom-widget-admin',
        $module_url . '/assets/admin.css'
    );
});
```

---

## 🎯 Best Practices

### ✅ انجام دهید

- از نام‌های واضح و معنادار استفاده کنید
- README.md برای هر ماژول بنویسید
- نسخه‌گذاری semantic را رعایت کنید
- تست کنید قبل از deploy
- کد را مستند کنید

### ❌ انجام ندهید

- از نام‌های عمومی مثل "module" استفاده نکنید
- همه چیز را در init.php ننویسید
- فراموش نکنید `defined('ABSPATH')` چک کنید
- فایل‌های غیرضروری اضافه نکنید

---

## 🔐 امنیت

```php
// همیشه در ابتدای فایل‌ها
defined('ABSPATH') || exit;

// Sanitize inputs
$value = sanitize_text_field($_POST['value']);

// Escape outputs  
echo esc_html($value);

// Check capabilities
if (!current_user_can('manage_options')) {
    return;
}
```

---

## 🐛 رفع مشکل

### ماژول لود نمی‌شود

1. چک کنید `module.json` معتبر باشد
2. نام پوشه و `name` در json یکسان باشند
3. فایل `init.php` موجود باشد
4. خطاها را در WP_DEBUG چک کنید

### Conflict با ماژول دیگر

از namespace استفاده کنید:

```php
<?php
namespace DST\Modules\MyModule;

defined('ABSPATH') || exit;

class Handler {
    // ...
}
```

### لود نشدن Assets

مسیر و URL را چک کنید:

```php
$path = dst_module_path('my-module', 'assets/style.css');
echo $path; // دیباگ مسیر

$url = dst_module_url('my-module', 'assets/style.css');
echo $url; // دیباگ URL
```

---

## 📚 منابع بیشتر

- [WordPress Plugin Handbook](https://developer.wordpress.org/plugins/)
- [PHP Namespaces](https://www.php.net/manual/en/language.namespaces.php)
- [Semantic Versioning](https://semver.org/)

---

## 🆘 پشتیبانی

اگر سوال یا مشکلی داری، بپرس! 💬
