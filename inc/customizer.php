<?php
/**
 * Theme Customizer Settings
 *
 * تنظیمات Customizer برای رنگ‌ها، لوگو و تنظیمات قالب
 *
 * @package Developer_Starter
 * @since 2.0.0
 */

defined('ABSPATH') || exit;

/**
 * ثبت تنظیمات Customizer
 */
function dst_customize_register($wp_customize) {

    // ═══════════════════════════════════════════════════════════════
    // پنل اصلی قالب
    // ═══════════════════════════════════════════════════════════════
    $wp_customize->add_panel('dst_theme_panel', [
        'title'       => 'تنظیمات قالب',
        'description' => 'تنظیمات اصلی قالب شامل رنگ‌ها، لوگو و...',
        'priority'    => 10,
    ]);

    // ═══════════════════════════════════════════════════════════════
    // بخش لوگو و برندینگ
    // ═══════════════════════════════════════════════════════════════
    $wp_customize->add_section('dst_branding', [
        'title'    => 'لوگو و برندینگ',
        'panel'    => 'dst_theme_panel',
        'priority' => 10,
    ]);

    // لوگوی اصلی
    $wp_customize->add_setting('dst_logo', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'dst_logo', [
        'label'    => 'لوگوی اصلی',
        'section'  => 'dst_branding',
        'settings' => 'dst_logo',
        'description' => 'لوگوی اصلی سایت برای هدر',
    ]));

    // لوگوی سفید (برای هدرهای تیره)
    $wp_customize->add_setting('dst_logo_light', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'dst_logo_light', [
        'label'    => 'لوگوی سفید',
        'section'  => 'dst_branding',
        'settings' => 'dst_logo_light',
        'description' => 'لوگو برای هدرهای تیره یا شفاف',
    ]));

    // فاویکون
    $wp_customize->add_setting('dst_favicon', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'dst_favicon', [
        'label'    => 'فاویکون',
        'section'  => 'dst_branding',
        'settings' => 'dst_favicon',
        'description' => 'آیکون سایت (32x32 پیکسل)',
    ]));

    // ═══════════════════════════════════════════════════════════════
    // بخش رنگ‌ها
    // ═══════════════════════════════════════════════════════════════
    $wp_customize->add_section('dst_colors', [
        'title'    => 'رنگ‌ها',
        'panel'    => 'dst_theme_panel',
        'priority' => 20,
    ]);

    // رنگ اصلی Primary
    $wp_customize->add_setting('dst_color_primary', [
        'default'           => '#2563eb',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dst_color_primary', [
        'label'    => 'رنگ اصلی (Primary)',
        'section'  => 'dst_colors',
        'settings' => 'dst_color_primary',
        'description' => 'رنگ اصلی برای دکمه‌ها و لینک‌ها',
    ]));

    // رنگ ثانویه Secondary
    $wp_customize->add_setting('dst_color_secondary', [
        'default'           => '#64748b',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dst_color_secondary', [
        'label'    => 'رنگ ثانویه (Secondary)',
        'section'  => 'dst_colors',
        'settings' => 'dst_color_secondary',
        'description' => 'رنگ متن‌های ثانویه',
    ]));

    // رنگ موفقیت Success
    $wp_customize->add_setting('dst_color_success', [
        'default'           => '#22c55e',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dst_color_success', [
        'label'    => 'رنگ موفقیت (Success)',
        'section'  => 'dst_colors',
        'settings' => 'dst_color_success',
    ]));

    // رنگ خطا Error
    $wp_customize->add_setting('dst_color_error', [
        'default'           => '#ef4444',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dst_color_error', [
        'label'    => 'رنگ خطا (Error)',
        'section'  => 'dst_colors',
        'settings' => 'dst_color_error',
    ]));

    // رنگ هشدار Warning
    $wp_customize->add_setting('dst_color_warning', [
        'default'           => '#f59e0b',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dst_color_warning', [
        'label'    => 'رنگ هشدار (Warning)',
        'section'  => 'dst_colors',
        'settings' => 'dst_color_warning',
    ]));

    // ═══════════════════════════════════════════════════════════════
    // بخش دکمه‌ها
    // ═══════════════════════════════════════════════════════════════
    $wp_customize->add_section('dst_buttons', [
        'title'    => 'دکمه‌ها',
        'panel'    => 'dst_theme_panel',
        'priority' => 30,
    ]);

    // رنگ پس‌زمینه دکمه اصلی
    $wp_customize->add_setting('dst_btn_primary_bg', [
        'default'           => '#2563eb',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dst_btn_primary_bg', [
        'label'    => 'رنگ دکمه اصلی',
        'section'  => 'dst_buttons',
        'settings' => 'dst_btn_primary_bg',
    ]));

    // رنگ متن دکمه اصلی
    $wp_customize->add_setting('dst_btn_primary_text', [
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dst_btn_primary_text', [
        'label'    => 'رنگ متن دکمه اصلی',
        'section'  => 'dst_buttons',
        'settings' => 'dst_btn_primary_text',
    ]));

    // رنگ hover دکمه اصلی
    $wp_customize->add_setting('dst_btn_primary_hover', [
        'default'           => '#1d4ed8',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dst_btn_primary_hover', [
        'label'    => 'رنگ hover دکمه اصلی',
        'section'  => 'dst_buttons',
        'settings' => 'dst_btn_primary_hover',
    ]));

    // شعاع گوشه دکمه‌ها
    $wp_customize->add_setting('dst_btn_radius', [
        'default'           => '8',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('dst_btn_radius', [
        'label'       => 'گردی گوشه دکمه‌ها (پیکسل)',
        'section'     => 'dst_buttons',
        'settings'    => 'dst_btn_radius',
        'type'        => 'number',
        'input_attrs' => [
            'min'  => 0,
            'max'  => 50,
            'step' => 1,
        ],
    ]);

    // ═══════════════════════════════════════════════════════════════
    // بخش اطلاعات تماس
    // ═══════════════════════════════════════════════════════════════
    $wp_customize->add_section('dst_contact', [
        'title'    => 'اطلاعات تماس',
        'panel'    => 'dst_theme_panel',
        'priority' => 40,
    ]);

    // شماره تلفن
    $wp_customize->add_setting('dst_phone', [
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('dst_phone', [
        'label'   => 'شماره تلفن',
        'section' => 'dst_contact',
        'type'    => 'text',
    ]);

    // ایمیل
    $wp_customize->add_setting('dst_email', [
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('dst_email', [
        'label'   => 'ایمیل',
        'section' => 'dst_contact',
        'type'    => 'email',
    ]);

    // آدرس
    $wp_customize->add_setting('dst_address', [
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('dst_address', [
        'label'   => 'آدرس',
        'section' => 'dst_contact',
        'type'    => 'textarea',
    ]);

    // ═══════════════════════════════════════════════════════════════
    // بخش شبکه‌های اجتماعی
    // ═══════════════════════════════════════════════════════════════
    $wp_customize->add_section('dst_social', [
        'title'    => 'شبکه‌های اجتماعی',
        'panel'    => 'dst_theme_panel',
        'priority' => 50,
    ]);

    $social_networks = [
        'instagram' => 'اینستاگرام',
        'telegram'  => 'تلگرام',
        'whatsapp'  => 'واتساپ',
        'twitter'   => 'توییتر (X)',
        'facebook'  => 'فیسبوک',
        'linkedin'  => 'لینکدین',
        'youtube'   => 'یوتیوب',
    ];

    foreach ($social_networks as $network => $label) {
        $wp_customize->add_setting("dst_{$network}", [
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        ]);

        $wp_customize->add_control("dst_{$network}", [
            'label'   => $label,
            'section' => 'dst_social',
            'type'    => 'url',
        ]);
    }
}
add_action('customize_register', 'dst_customize_register');

/**
 * خروجی CSS سفارشی در head
 */
function dst_customizer_css() {
    $primary       = get_theme_mod('dst_color_primary', '#2563eb');
    $secondary     = get_theme_mod('dst_color_secondary', '#64748b');
    $success       = get_theme_mod('dst_color_success', '#22c55e');
    $error         = get_theme_mod('dst_color_error', '#ef4444');
    $warning       = get_theme_mod('dst_color_warning', '#f59e0b');
    $btn_bg        = get_theme_mod('dst_btn_primary_bg', '#2563eb');
    $btn_text      = get_theme_mod('dst_btn_primary_text', '#ffffff');
    $btn_hover     = get_theme_mod('dst_btn_primary_hover', '#1d4ed8');
    $btn_radius    = get_theme_mod('dst_btn_radius', '8');

    // تبدیل hex به RGB برای استفاده با opacity
    $primary_rgb = dst_hex_to_rgb($primary);

    ?>
    <style id="dst-customizer-css">
        :root {
            --dst-primary: <?php echo esc_attr($primary); ?>;
            --dst-primary-rgb: <?php echo esc_attr($primary_rgb); ?>;
            --dst-secondary: <?php echo esc_attr($secondary); ?>;
            --dst-success: <?php echo esc_attr($success); ?>;
            --dst-error: <?php echo esc_attr($error); ?>;
            --dst-warning: <?php echo esc_attr($warning); ?>;
            --dst-btn-bg: <?php echo esc_attr($btn_bg); ?>;
            --dst-btn-text: <?php echo esc_attr($btn_text); ?>;
            --dst-btn-hover: <?php echo esc_attr($btn_hover); ?>;
            --dst-btn-radius: <?php echo esc_attr($btn_radius); ?>px;
        }

        /* Primary Color */
        .text-primary-600, .hover\:text-primary-600:hover { color: var(--dst-primary) !important; }
        .bg-primary-600, .hover\:bg-primary-600:hover { background-color: var(--dst-primary) !important; }
        .border-primary-600 { border-color: var(--dst-primary) !important; }
        .ring-primary-500 { --tw-ring-color: var(--dst-primary) !important; }
        .bg-primary-50 { background-color: rgba(var(--dst-primary-rgb), 0.1) !important; }

        /* Buttons */
        .hf-btn-primary {
            background-color: var(--dst-btn-bg) !important;
            color: var(--dst-btn-text) !important;
            border-radius: var(--dst-btn-radius) !important;
        }
        .hf-btn-primary:hover {
            background-color: var(--dst-btn-hover) !important;
        }

        /* Badge */
        .hf-badge-primary {
            background-color: var(--dst-primary) !important;
        }

        /* Links */
        a:hover { color: var(--dst-primary); }
    </style>
    <?php
}
add_action('wp_head', 'dst_customizer_css', 100);

/**
 * تبدیل HEX به RGB
 */
if (!function_exists('dst_hex_to_rgb')) {
    function dst_hex_to_rgb($hex) {
        $hex = ltrim($hex, '#');

        if (strlen($hex) == 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }

        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        return "{$r}, {$g}, {$b}";
    }
}

/**
 * گرفتن لوگوی سایت
 * از تنظیمات قالب (dst-theme-settings) می‌خواند
 *
 * @param string $type 'default' یا 'light'
 * @return string URL لوگو
 */
if (!function_exists('dst_get_logo')) {
    function dst_get_logo($type = 'default') {
        // اول از تنظیمات قالب بخوان
        if (function_exists('dst_get_setting')) {
            if ($type === 'light') {
                $logo = dst_get_setting('site_logo_light');
                if ($logo) {
                    return $logo;
                }
            }
            $logo = dst_get_setting('site_logo');
            if ($logo) {
                return $logo;
            }
        }

        // fallback به لوگوی استاندارد وردپرس
        $custom_logo_id = get_theme_mod('custom_logo');
        if ($custom_logo_id) {
            return wp_get_attachment_image_url($custom_logo_id, 'full');
        }

        return '';
    }
}

/**
 * نمایش لوگو
 *
 * @param string $type 'default' یا 'light'
 * @param string $class کلاس CSS اضافی
 */
if (!function_exists('dst_the_logo')) {
    function dst_the_logo($type = 'default', $class = 'h-10 w-auto') {
        $logo_url = dst_get_logo($type);

        if ($logo_url) {
            printf(
                '<a href="%s" class="block"><img src="%s" alt="%s" class="%s"></a>',
                esc_url(home_url('/')),
                esc_url($logo_url),
                esc_attr(get_bloginfo('name')),
                esc_attr($class)
            );
        } else {
            printf(
                '<a href="%s" class="text-xl font-bold text-secondary-800 hover:text-primary-600 transition-colors">%s</a>',
                esc_url(home_url('/')),
                esc_html(get_bloginfo('name'))
            );
        }
    }
}

/**
 * گرفتن اطلاعات تماس
 * از تنظیمات قالب (dst-theme-settings) می‌خواند
 */
if (!function_exists('dst_get_contact')) {
    function dst_get_contact($field) {
        if (function_exists('dst_get_setting')) {
            return dst_get_setting($field, '');
        }
        return '';
    }
}

/**
 * گرفتن لینک شبکه اجتماعی
 * از تنظیمات قالب (dst-theme-settings) می‌خواند
 */
if (!function_exists('dst_get_social')) {
    function dst_get_social($network) {
        if (function_exists('dst_get_setting')) {
            return dst_get_setting($network, '');
        }
        return '';
    }
}

/**
 * نمایش آیکون‌های شبکه‌های اجتماعی
 */
if (!function_exists('dst_social_icons')) {
    function dst_social_icons($class = 'hf-social-icons') {
        $networks = ['instagram', 'telegram', 'whatsapp', 'twitter', 'facebook', 'linkedin', 'youtube'];

        ob_start();
        ?>
        <div class="<?php echo esc_attr($class); ?>">
            <?php foreach ($networks as $network):
                $url = dst_get_social($network);
                if (!$url) continue;
            ?>
                <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="hf-social-icon" title="<?php echo esc_attr(ucfirst($network)); ?>">
                    <?php echo dst_get_icon($network, 'w-5 h-5'); ?>
                </a>
            <?php endforeach; ?>
        </div>
        <?php
        return ob_get_clean();
    }
}
