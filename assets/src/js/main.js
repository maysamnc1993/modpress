/**
 * Developer Starter Theme - Main JavaScript
 * 
 * این فایل نقطه ورود اصلی است.
 * Vite از اینجا SCSS را هم پردازش می‌کند.
 */

// Import SCSS
import '../scss/main.scss';

// ═══════════════════════════════════════════════════════════════
// Mobile Menu
// ═══════════════════════════════════════════════════════════════
class MobileMenu {
    constructor() {
        this.toggle = document.querySelector('.dst-header__toggle');
        this.nav = document.querySelector('.dst-header__nav');
        this.body = document.body;
        
        if (this.toggle) {
            this.init();
        }
    }
    
    init() {
        this.toggle.addEventListener('click', () => this.toggleMenu());
        
        // بستن منو با کلیک بیرون
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.dst-header')) {
                this.closeMenu();
            }
        });
        
        // بستن منو با Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeMenu();
            }
        });
    }
    
    toggleMenu() {
        this.toggle.classList.toggle('is-active');
        this.nav.classList.toggle('is-open');
        this.body.classList.toggle('menu-open');
    }
    
    closeMenu() {
        this.toggle.classList.remove('is-active');
        this.nav.classList.remove('is-open');
        this.body.classList.remove('menu-open');
    }
}

// ═══════════════════════════════════════════════════════════════
// Header Scroll Effect
// ═══════════════════════════════════════════════════════════════
class HeaderScroll {
    constructor() {
        this.header = document.querySelector('.dst-header');
        this.scrollThreshold = 100;
        
        if (this.header) {
            this.init();
        }
    }
    
    init() {
        window.addEventListener('scroll', () => this.onScroll(), { passive: true });
        this.onScroll(); // Check initial state
    }
    
    onScroll() {
        if (window.scrollY > this.scrollThreshold) {
            this.header.classList.add('is-scrolled');
        } else {
            this.header.classList.remove('is-scrolled');
        }
    }
}

// ═══════════════════════════════════════════════════════════════
// Smooth Scroll
// ═══════════════════════════════════════════════════════════════
class SmoothScroll {
    constructor() {
        this.links = document.querySelectorAll('a[href^="#"]:not([href="#"])');
        
        if (this.links.length) {
            this.init();
        }
    }
    
    init() {
        this.links.forEach(link => {
            link.addEventListener('click', (e) => this.onClick(e, link));
        });
    }
    
    onClick(e, link) {
        const targetId = link.getAttribute('href');
        const target = document.querySelector(targetId);
        
        if (target) {
            e.preventDefault();
            
            const headerHeight = document.querySelector('.dst-header')?.offsetHeight || 0;
            const targetPosition = target.getBoundingClientRect().top + window.scrollY - headerHeight;
            
            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
        }
    }
}

// ═══════════════════════════════════════════════════════════════
// Lazy Load Images
// ═══════════════════════════════════════════════════════════════
class LazyLoad {
    constructor() {
        this.images = document.querySelectorAll('img[data-src]');
        
        if (this.images.length && 'IntersectionObserver' in window) {
            this.init();
        }
    }
    
    init() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.loadImage(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, {
            rootMargin: '50px'
        });
        
        this.images.forEach(img => observer.observe(img));
    }
    
    loadImage(img) {
        img.src = img.dataset.src;
        img.removeAttribute('data-src');
        img.classList.add('is-loaded');
    }
}

// ═══════════════════════════════════════════════════════════════
// Initialize
// ═══════════════════════════════════════════════════════════════
document.addEventListener('DOMContentLoaded', () => {
    new MobileMenu();
    new HeaderScroll();
    new SmoothScroll();
    new LazyLoad();
    
    console.log('🚀 Developer Starter Theme Loaded');
});

// ═══════════════════════════════════════════════════════════════
// Export for use in other scripts
// ═══════════════════════════════════════════════════════════════
export {
    MobileMenu,
    HeaderScroll,
    SmoothScroll,
    LazyLoad
};
