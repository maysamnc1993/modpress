/**
 * مدیریت باز/بسته شدن منوها با کلیک
 */
(function($) {
    'use strict';
    
    $(document).ready(function() {
        
        /**
         * تنظیم رفتار کلیک برای منوها
         */
        function setupMenuClickBehavior() {
            var $adminMenu = $('#adminmenu');
            
            // پیدا کردن منوهایی که زیرمنو دارند
            $adminMenu.find('li.menu-top').each(function() {
                var $menuItem = $(this);
                var $link = $menuItem.find('> a.menu-top');
                var $submenu = $menuItem.find('.wp-submenu');
                
                // اگر زیرمنو دارد
                if ($submenu.length > 0) {
                    
                    // حذف event های قبلی
                    $link.off('click.dstmenu');
                    
                    // اضافه کردن event جدید
                    $link.on('click.dstmenu', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        var isOpen = $menuItem.hasClass('dst-menu-open');
                        
                        // بستن همه منوهای باز
                        $adminMenu.find('li.menu-top').removeClass('dst-menu-open');
                        
                        // اگر بسته بود، باز کن
                        if (!isOpen) {
                            $menuItem.addClass('dst-menu-open');
                        }
                        
                        return false;
                    });
                }
            });
            
            // بستن منو با کلیک خارج از آن
            $(document).on('click.dstmenu', function(e) {
                // اگر کلیک خارج از منو بود
                if (!$(e.target).closest('#adminmenu').length) {
                    $adminMenu.find('li.menu-top').removeClass('dst-menu-open');
                }
            });
            
            // جلوگیری از بسته شدن با کلیک داخل زیرمنو
            $adminMenu.find('.wp-submenu').on('click.dstmenu', function(e) {
                e.stopPropagation();
            });
        }
        
        /**
         * راه‌اندازی اولیه
         */
        setupMenuClickBehavior();
        
        /**
         * اگر منوی جدیدی اضافه شد (توسط AJAX یا پلاگین)
         * دوباره تنظیم کن
         */
        var observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.addedNodes.length) {
                    setupMenuClickBehavior();
                }
            });
        });
        
        // شروع نظارت بر تغییرات
        var menuElement = document.getElementById('adminmenu');
        if (menuElement) {
            observer.observe(menuElement, {
                childList: true,
                subtree: true
            });
        }
        
        /**
         * تنظیمات صفحه تنظیمات منو
         */
        $('.dst-menu-mode-option').on('click', function() {
            $(this).find('input[type="radio"]').prop('checked', true);
            $('.dst-menu-mode-option').removeClass('selected');
            $(this).addClass('selected');
        });
        
    });
    
})(jQuery);
