/**
 * Developer Starter Theme - Main JavaScript
 */

(function() {
    'use strict';
    
    /**
     * Mobile Menu Toggle
     */
    function initMobileMenu() {
        const toggle = document.querySelector('.dst-header__toggle');
        const nav = document.querySelector('.dst-header__nav');
        
        if (!toggle || !nav) return;
        
        toggle.addEventListener('click', function() {
            nav.classList.toggle('is-open');
            this.classList.toggle('is-active');
        });
    }
    
    /**
     * Smooth Scroll
     */
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    }
    
    /**
     * Header Scroll Effect
     */
    function initHeaderScroll() {
        const header = document.querySelector('.dst-header');
        if (!header) return;
        
        window.addEventListener('scroll', function() {
            header.classList.toggle('is-scrolled', window.scrollY > 100);
        });
    }
    
    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        initMobileMenu();
        initSmoothScroll();
        initHeaderScroll();
    });
    
})();
