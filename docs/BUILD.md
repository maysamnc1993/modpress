# راهنمای Build System

این قالب از **Vite** و **SCSS** برای مدیریت استایل‌ها استفاده می‌کند.

---

## 🚀 شروع سریع

### ۱. نصب وابستگی‌ها
```bash
cd wp-content/themes/developer-starter-theme
npm install
```

### ۲. حالت Development
```bash
npm run dev
```
این دستور:
- Vite dev server را روی پورت 3000 اجرا می‌کند
- تغییرات را بصورت زنده اعمال می‌کند (Hot Reload)
- SCSS را کامپایل می‌کند

### ۳. Build برای Production
```bash
npm run build
```
این دستور:
- فایل‌ها را minify می‌کند
- در پوشه `assets/dist/` خروجی می‌دهد

---

## 📁 ساختار فایل‌ها

```
assets/
├── src/                    ← فایل‌های اصلی (اینجا کد میزنی)
│   ├── scss/
│   │   ├── base/
│   │   │   ├── _variables.scss   ← متغیرها (رنگ، فاصله، ...)
│   │   │   ├── _mixins.scss      ← توابع SCSS
│   │   │   ├── _reset.scss       ← ریست استایل‌ها
│   │   │   └── _typography.scss  ← تایپوگرافی
│   │   ├── components/
│   │   │   ├── _buttons.scss     ← دکمه‌ها
│   │   │   ├── _cards.scss       ← کارت‌ها
│   │   │   ├── _forms.scss       ← فرم‌ها
│   │   │   └── _utilities.scss   ← کلاس‌های کمکی
│   │   ├── layout/
│   │   │   ├── _header.scss      ← هدر
│   │   │   └── _footer.scss      ← فوتر
│   │   ├── blocks/               ← استایل بلاک‌ها
│   │   └── main.scss             ← فایل اصلی
│   └── js/
│       └── main.js
│
└── dist/                   ← فایل‌های نهایی (خودکار ساخته میشه)
    ├── css/
    │   └── style.css
    └── js/
        └── main.js
```

---

## 🎨 کار با SCSS

### متغیرها
تمام متغیرها در `_variables.scss` تعریف شدن:

```scss
// رنگ‌ها
$color-primary: #2563eb;
$color-error: #ef4444;

// فاصله‌ها
$spacing-md: 1rem;
$spacing-lg: 1.5rem;

// فونت‌ها
$text-lg: 1.125rem;
```

### Mixins
توابع آماده در `_mixins.scss`:

```scss
// Responsive
@include screen(md) {
    // از 768px به بالا
}

@include screen-down(md) {
    // تا 767px
}

// Flexbox
@include flex-center;
@include flex-between;

// Container
@include container;
@include container($container-md);
```

### اضافه کردن فایل جدید

۱. فایل رو بساز (با _ شروع بشه):
```
assets/src/scss/components/_modal.scss
```

۲. در `main.scss` import کن:
```scss
@import 'components/modal';
```

---

## 🔧 دستورات NPM

| دستور | کاربرد |
|-------|--------|
| `npm run dev` | اجرای dev server |
| `npm run build` | ساخت فایل‌های production |
| `npm run watch` | watch بدون dev server |

---

## ⚙️ تنظیمات Development

برای فعال کردن حالت development، در `wp-config.php`:

```php
define('DST_DEVELOPMENT', true);
```

و مطمئن شو Vite در حال اجراست (`npm run dev`).

---

## 📝 نکات مهم

### ۱. فایل‌های dist را commit نکن
فایل `.gitignore` این کار رو انجام میده. هر developer باید خودش build کنه.

### ۲. متغیرها را تغییر بده
قبل شروع پروژه، متغیرها رو در `_variables.scss` تنظیم کن:
- رنگ‌های برند
- فونت‌ها
- فاصله‌ها

### ۳. از Mixins استفاده کن
بجای تکرار کد، از mixins استفاده کن:

```scss
// ❌ بد
.my-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem 1.5rem;
    // ...
}

// ✅ خوب
.my-button {
    @include button-base;
    background: $color-primary;
}
```

---

## 🆘 مشکلات رایج

### پورت 3000 اشغاله
```bash
# پیدا کردن پروسه
lsof -i :3000

# یا تغییر پورت در vite.config.js
server: {
    port: 3001
}
```

### تغییرات اعمال نمیشه
1. چک کن Vite در حال اجراست
2. چک کن `DST_DEVELOPMENT` فعاله
3. کش مرورگر رو پاک کن

---

## 🔗 منابع

- [مستندات Vite](https://vitejs.dev/)
- [مستندات SCSS](https://sass-lang.com/documentation)
