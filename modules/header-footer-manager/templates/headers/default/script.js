/**
 * هدر پیش‌فرض - جاوااسکریپت
 */
(function() {
    'use strict';
    
    document.addEventListener('DOMContentLoaded', function() {
        const header = document.querySelector('.dst-header-default');
        if (!header) return;
        
        const toggle = header.querySelector('.dst-mobile-toggle');
        const mobileMenu = header.querySelector('.dst-mobile-menu');
        
        if (toggle && mobileMenu) {
            toggle.addEventListener('click', function() {
                toggle.classList.toggle('active');
                mobileMenu.classList.toggle('active');
            });
        }
        
        // بستن منو با کلیک خارج
        document.addEventListener('click', function(e) {
            if (!header.contains(e.target) && mobileMenu && mobileMenu.classList.contains('active')) {
                toggle.classList.remove('active');
                mobileMenu.classList.remove('active');
            }
        });
    });
})();
