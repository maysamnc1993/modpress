# Developer Starter Theme

یک استارتر تم حرفه‌ای و ماژولار برای توسعه سریع قالب‌های وردپرس

---

## 📁 ساختار پوشه‌ها

```
developer-starter-theme/
│
├── style.css              ← فایل اصلی قالب (اطلاعات قالب)
├── functions.php          ← نقطه ورود - لود فایل‌ها
├── index.php              ← قالب پیش‌فرض
├── header.php             ← هدر سایت
├── footer.php             ← فوتر سایت
│
├── inc/                   ← فایل‌های PHP هسته
│   ├── theme-setup.php    ← تنظیمات پایه (منو، سایدبار، ...)
│   ├── assets-loader.php  ← لود CSS و JS
│   ├── blocks-loader.php  ← ★ سیستم لود خودکار بلاک‌ها
│   ├── acf-config.php     ← تنظیمات ACF
│   └── helpers.php        ← توابع کمکی
│
├── blocks/                ← ★ بلاک‌های ACF (هر پوشه = یک بلاک)
│   └── (خالی - بعداً اضافه می‌شود)
│
├── components/            ← قطعات کوچک قابل استفاده مجدد
│
├── templates/             ← قالب‌های صفحات خاص
│
├── assets/
│   ├── css/
│   │   ├── base/          ← استایل‌های پایه
│   │   │   ├── variables.css   ← متغیرهای CSS
│   │   │   ├── reset.css       ← ریست
│   │   │   └── typography.css  ← تایپوگرافی
│   │   ├── utilities/     ← کلاس‌های کمکی
│   │   │   └── utilities.css
│   │   └── main.css       ← استایل اصلی
│   ├── js/
│   │   └── main.js
│   └── images/
│
├── acf-json/              ← ذخیره فیلدهای ACF (برای Git)
│
└── docs/                  ← داکیومنت‌ها
```

---

## 🚀 شروع کار

### پیش‌نیازها

1. وردپرس نسخه 6.0 یا بالاتر
2. PHP نسخه 8.0 یا بالاتر
3. پلاگین **ACF Pro** (برای بلاک‌ها)

### نصب

1. پوشه قالب را در `wp-content/themes/` قرار دهید
2. از پیشخوان وردپرس، قالب را فعال کنید
3. پلاگین ACF Pro را نصب و فعال کنید

---

## ⭐ سیستم بلاک‌ها (قلب قالب)

### بلاک چیست؟

بلاک یک قطعه مستقل از صفحه است که:
- کد HTML خودش را دارد
- استایل CSS خودش را دارد
- فیلدهای ACF خودش را دارد
- می‌تواند در هر جای سایت استفاده شود

### ساختار یک بلاک

هر بلاک یک پوشه در `/blocks/` است:

```
blocks/
└── hero/                   ← نام بلاک
    ├── block.json          ← تنظیمات بلاک (اجباری)
    ├── render.php          ← کد نمایش (اجباری)
    ├── style.css           ← استایل (اختیاری)
    ├── script.js           ← جاوااسکریپت (اختیاری)
    └── fields.php          ← فیلدهای ACF (اختیاری)
```

### فایل block.json

```json
{
    "name": "hero",
    "title": "هیرو / بنر اصلی",
    "description": "بخش بنر اصلی صفحه",
    "category": "developer-starter",
    "icon": "cover-image",
    "keywords": ["hero", "banner", "هیرو"],
    "mode": "preview",
    "align": "full"
}
```

### فایل render.php

```php
<?php
// متغیرهای در دسترس:
// $block_id   - آیدی یونیک بلاک
// $class_name - کلاس‌های CSS
// $is_preview - آیا در ویرایشگر هستیم
// $post_id    - آیدی پست

$title = get_field('hero_title');
$image = get_field('hero_image');
?>

<section id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($class_name); ?>">
    <h1><?php echo esc_html($title); ?></h1>
</section>
```

### فایل fields.php

```php
<?php
if (!function_exists('acf_add_local_field_group')) return;

acf_add_local_field_group([
    'key'    => 'group_block_hero',
    'title'  => 'تنظیمات هیرو',
    'fields' => [
        [
            'key'   => 'field_hero_title',
            'label' => 'تیتر',
            'name'  => 'hero_title',
            'type'  => 'text',
        ],
    ],
    'location' => [
        [
            [
                'param'    => 'block',
                'operator' => '==',
                'value'    => 'acf/hero',
            ],
        ],
    ],
]);
```

---

## 🔧 توابع کمکی

### dst_field()
گرفتن فیلد ACF با مقدار پیش‌فرض:
```php
$title = dst_field('page_title', 'عنوان پیش‌فرض');
```

### dst_option()
گرفتن آپشن از تنظیمات قالب:
```php
$phone = dst_option('contact_phone');
```

### dst_component()
لود کردن یک کامپوننت:
```php
dst_component('button', ['text' => 'کلیک کنید', 'url' => '#']);
```

### dst_fa_num()
تبدیل اعداد به فارسی:
```php
echo dst_fa_num('1234'); // ۱۲۳۴
```

### dst_price()
فرمت قیمت:
```php
echo dst_price(150000); // ۱۵۰,۰۰۰ تومان
```

---

## 🎨 متغیرهای CSS

تمام متغیرها در `assets/css/base/variables.css` تعریف شده‌اند:

```css
/* رنگ‌ها */
--color-primary: #2563eb;
--color-gray-900: #0f172a;

/* فاصله‌ها */
--spacing-md: 1rem;
--spacing-lg: 1.5rem;

/* فونت‌ها */
--text-lg: 1.125rem;
--text-xl: 1.25rem;

/* گوشه‌ها */
--radius-md: 0.5rem;
```

---

## 📝 اضافه کردن بلاک جدید

### قدم ۱: ساخت پوشه
```bash
mkdir blocks/نام-بلاک
```

### قدم ۲: ساخت block.json
```json
{
    "name": "نام-بلاک",
    "title": "عنوان فارسی",
    "icon": "admin-post"
}
```

### قدم ۳: ساخت render.php
```php
<?php
$title = get_field('title');
?>
<section class="<?php echo esc_attr($class_name); ?>">
    <h2><?php echo esc_html($title); ?></h2>
</section>
```

### قدم ۴: ساخت fields.php (اختیاری)
فیلدهای ACF را تعریف کنید.

### قدم ۵: ساخت style.css (اختیاری)
استایل‌های بلاک را بنویسید.

**تمام!** بلاک بصورت خودکار در ویرایشگر ظاهر می‌شود.

---

## 📚 منابع بیشتر

- [مستندات ACF Blocks](https://www.advancedcustomfields.com/resources/blocks/)
- [لیست آیکون‌های Dashicons](https://developer.wordpress.org/resource/dashicons/)

---

## 🆘 سوال داری؟

اگر سوالی داری یا به کمک نیاز داری، بپرس!
