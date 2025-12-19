<?php
/**
 * Lucide Icons System
 * استفاده از Lucide Icons - مدرن‌ترین آیکون‌ها
 * https://lucide.dev
 */

if (!defined('ABSPATH')) exit;

class DST_Lucide_Icons {
    
    public function __construct() {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_icons']);
        add_action('admin_head', [$this, 'replace_icons_css']);
        add_action('admin_footer', [$this, 'replace_icons_js']);
        add_action('admin_footer', [$this, 'add_topbar_icons']);
    }
    
    /**
     * لود Lucide
     */
    public function enqueue_icons() {
        wp_enqueue_script(
            'lucide-icons',
            'https://unpkg.com/lucide@latest',
            [],
            null,
            true
        );
    }
    
    /**
     * CSS برای آیکون‌ها
     */
    public function replace_icons_css() {
        ?>
        <style>
        body.admin-theme-active #adminmenu .wp-menu-image.dashicons-before::before {
            display: none !important;
        }
        
        body.admin-theme-active #adminmenu .wp-menu-image {
            position: relative !important;
        }
        
        body.admin-theme-active #adminmenu .wp-menu-image svg {
            width: 20px !important;
            height: 20px !important;
            stroke: currentColor !important;
            position: absolute !important;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
        }
        </style>
        <?php
    }
    
    /**
     * JavaScript برای جایگزینی
     */
    public function replace_icons_js() {
        ?>
        <script>
        (function() {
            // نقشه آیکون‌ها
            const iconMap = {
                'menu-icon-dashboard': 'layout-dashboard',
                'menu-icon-post': 'file-text',
                'menu-icon-media': 'image',
                'menu-icon-page': 'file',
                'menu-icon-comments': 'message-square',
                'menu-icon-appearance': 'palette',
                'menu-icon-plugins': 'plug',
                'menu-icon-users': 'users',
                'menu-icon-tools': 'wrench',
                'menu-icon-settings': 'settings',
                'menu-icon-woocommerce': 'shopping-cart',
                'menu-icon-product': 'package',
                'menu-icon-shop_order': 'shopping-bag',
            };
            
            // جایگزینی آیکون‌ها
            function replaceIcons() {
                Object.keys(iconMap).forEach(className => {
                    const elements = document.querySelectorAll(`.${className} .wp-menu-image`);
                    elements.forEach(el => {
                        if (!el.dataset.iconReplaced) {
                            const iconName = iconMap[className];
                            const icon = document.createElement('i');
                            icon.setAttribute('data-lucide', iconName);
                            el.appendChild(icon);
                            el.dataset.iconReplaced = 'true';
                        }
                    });
                });
                
                // فعال‌سازی آیکون‌ها
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            }
            
            // اجرا بعد از لود صفحه
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', replaceIcons);
            } else {
                replaceIcons();
            }
            
            // اجرای مجدد برای منوهای Dynamic
            setTimeout(replaceIcons, 500);
        })();
        </script>
        <?php
    }
    
    /**
     * Topbar Icons
     */
    public function add_topbar_icons() {
        ?>
        <style>
        /* Topbar Icons با Lucide */
        body.admin-theme-active #wpadminbar .ab-icon {
            position: relative !important;
            width: 20px !important;
            height: 20px !important;
            display: inline-block !important;
            vertical-align: middle !important;
        }
        
        body.admin-theme-active #wpadminbar .ab-icon svg {
            width: 20px !important;
            height: 20px !important;
            stroke: currentColor !important;
        }
        
        /* مخفی کردن before برای جای‌گیری SVG */
        body.admin-theme-active #wpadminbar .ab-icon::before {
            display: none !important;
        }
        </style>
        
        <script>
        (function() {
            function addTopbarIcons() {
                // لوگوی وردپرس
                const wpLogo = document.querySelector('#wp-admin-bar-wp-logo .ab-icon');
                if (wpLogo && !wpLogo.dataset.iconAdded) {
                    const icon = document.createElement('i');
                    icon.setAttribute('data-lucide', 'wordpress');
                    wpLogo.appendChild(icon);
                    wpLogo.dataset.iconAdded = 'true';
                }
                
                // نوتیفیکیشن
                const updates = document.querySelector('#wp-admin-bar-updates .ab-icon');
                if (updates && !updates.dataset.iconAdded) {
                    const icon = document.createElement('i');
                    icon.setAttribute('data-lucide', 'bell');
                    updates.appendChild(icon);
                    updates.dataset.iconAdded = 'true';
                }
                
                // کامنت‌ها
                const comments = document.querySelector('#wp-admin-bar-comments .ab-icon');
                if (comments && !comments.dataset.iconAdded) {
                    const icon = document.createElement('i');
                    icon.setAttribute('data-lucide', 'message-square');
                    comments.appendChild(icon);
                    comments.dataset.iconAdded = 'true';
                }
                
                // نوشته جدید
                const newContent = document.querySelector('#wp-admin-bar-new-content .ab-icon');
                if (newContent && !newContent.dataset.iconAdded) {
                    const icon = document.createElement('i');
                    icon.setAttribute('data-lucide', 'plus');
                    newContent.appendChild(icon);
                    newContent.dataset.iconAdded = 'true';
                }
                
                // فعال‌سازی آیکون‌ها
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            }
            
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', addTopbarIcons);
            } else {
                addTopbarIcons();
            }
            
            setTimeout(addTopbarIcons, 500);
        })();
        </script>
        <?php
    }
}

new DST_Lucide_Icons();
