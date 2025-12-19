/**
 * هدر شفاف - جاوااسکریپت
 */
(function() {
    'use strict';
    
    document.addEventListener('DOMContentLoaded', function() {
        const header = document.querySelector('.dst-header-transparent');
        if (!header) return;
        
        const toggle = header.querySelector('.dst-mobile-toggle');
        const mobileMenu = header.querySelector('.dst-mobile-menu');
        
        // منوی موبایل
        if (toggle && mobileMenu) {
            toggle.addEventListener('click', function() {
                toggle.classList.toggle('active');
                mobileMenu.classList.toggle('active');
            });
        }
        
        // تغییر استایل هنگام اسکرول
        function handleScroll() {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }
        
        window.addEventListener('scroll', handleScroll);
        handleScroll(); // چک اولیه
    });
})();
