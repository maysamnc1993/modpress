/**
 * هدر وسط‌چین - جاوااسکریپت
 */
(function() {
    'use strict';
    
    document.addEventListener('DOMContentLoaded', function() {
        const header = document.querySelector('.dst-header-centered');
        if (!header) return;
        
        const toggle = header.querySelector('.dst-mobile-toggle');
        const mobileMenu = header.querySelector('.dst-mobile-menu');
        
        if (toggle && mobileMenu) {
            toggle.addEventListener('click', function() {
                toggle.classList.toggle('active');
                mobileMenu.classList.toggle('active');
            });
        }
    });
})();
