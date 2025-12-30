/**
 * ModPress Theme - Main JavaScript
 *
 * Powered by Alpine.js for reactive UI components
 */

// Import Tailwind CSS
import '../css/main.css';

// Import Alpine.js
import Alpine from 'alpinejs';

// Make Alpine available globally
window.Alpine = Alpine;

// ═══════════════════════════════════════════════════════════════
// Alpine.js Components
// ═══════════════════════════════════════════════════════════════

/**
 * Header Component
 * Handles sticky header, scroll effects, and mobile menu
 */
Alpine.data('header', () => ({
    isScrolled: false,
    isMobileMenuOpen: false,
    isSearchOpen: false,
    scrollThreshold: 50,
    lastScrollY: 0,
    isHidden: false,

    init() {
        this.handleScroll();
        window.addEventListener('scroll', () => this.handleScroll(), { passive: true });

        // Close mobile menu on resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                this.isMobileMenuOpen = false;
            }
        });
    },

    handleScroll() {
        const currentScrollY = window.scrollY;

        // Add scrolled class
        this.isScrolled = currentScrollY > this.scrollThreshold;

        // Hide/show header on scroll direction (optional)
        if (currentScrollY > this.lastScrollY && currentScrollY > 200) {
            this.isHidden = true;
        } else {
            this.isHidden = false;
        }

        this.lastScrollY = currentScrollY;
    },

    toggleMobileMenu() {
        this.isMobileMenuOpen = !this.isMobileMenuOpen;
        document.body.classList.toggle('overflow-hidden', this.isMobileMenuOpen);
    },

    closeMobileMenu() {
        this.isMobileMenuOpen = false;
        document.body.classList.remove('overflow-hidden');
    },

    toggleSearch() {
        this.isSearchOpen = !this.isSearchOpen;
        if (this.isSearchOpen) {
            this.$nextTick(() => {
                this.$refs.searchInput?.focus();
            });
        }
    },
}));

/**
 * Dropdown Component
 * For navigation dropdowns and mega menus
 */
Alpine.data('dropdown', () => ({
    open: false,

    toggle() {
        this.open = !this.open;
    },

    close() {
        this.open = false;
    },

    // Close on click outside
    handleClickOutside(event) {
        if (!this.$el.contains(event.target)) {
            this.open = false;
        }
    }
}));

/**
 * Mini Cart Component
 * WooCommerce mini cart functionality
 */
Alpine.data('miniCart', () => ({
    isOpen: false,
    isLoading: false,
    items: [],
    total: '0',
    count: 0,

    init() {
        // Listen for cart updates from WooCommerce
        document.body.addEventListener('wc_fragment_refresh', () => this.refresh());
        document.body.addEventListener('added_to_cart', () => this.refresh());
        document.body.addEventListener('removed_from_cart', () => this.refresh());
    },

    toggle() {
        this.isOpen = !this.isOpen;
    },

    open() {
        this.isOpen = true;
    },

    close() {
        this.isOpen = false;
    },

    async refresh() {
        this.isLoading = true;
        try {
            const response = await fetch(dstConfig?.ajaxUrl || '/wp-admin/admin-ajax.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'dst_get_mini_cart',
                    nonce: dstConfig?.nonce || '',
                }),
            });
            const data = await response.json();
            if (data.success) {
                this.items = data.data.items;
                this.total = data.data.total;
                this.count = data.data.count;
            }
        } catch (error) {
            console.error('Mini cart refresh error:', error);
        } finally {
            this.isLoading = false;
        }
    },

    async removeItem(cartKey) {
        this.isLoading = true;
        try {
            const response = await fetch(dstConfig?.ajaxUrl || '/wp-admin/admin-ajax.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'dst_remove_cart_item',
                    cart_key: cartKey,
                    nonce: dstConfig?.nonce || '',
                }),
            });
            const data = await response.json();
            if (data.success) {
                await this.refresh();
            }
        } catch (error) {
            console.error('Remove item error:', error);
        } finally {
            this.isLoading = false;
        }
    }
}));

/**
 * Search Component
 * Live search functionality
 */
Alpine.data('liveSearch', () => ({
    query: '',
    results: [],
    isLoading: false,
    isOpen: false,
    debounceTimeout: null,

    init() {
        this.$watch('query', (value) => {
            clearTimeout(this.debounceTimeout);
            if (value.length >= 3) {
                this.debounceTimeout = setTimeout(() => this.search(), 300);
            } else {
                this.results = [];
                this.isOpen = false;
            }
        });
    },

    async search() {
        this.isLoading = true;
        this.isOpen = true;
        try {
            const response = await fetch(dstConfig?.ajaxUrl || '/wp-admin/admin-ajax.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'dst_live_search',
                    query: this.query,
                    nonce: dstConfig?.nonce || '',
                }),
            });
            const data = await response.json();
            if (data.success) {
                this.results = data.data;
            }
        } catch (error) {
            console.error('Search error:', error);
        } finally {
            this.isLoading = false;
        }
    },

    close() {
        this.isOpen = false;
    },

    clear() {
        this.query = '';
        this.results = [];
        this.isOpen = false;
    }
}));

/**
 * Mobile Menu Component
 * Handles mobile navigation with nested submenus
 */
Alpine.data('mobileMenu', () => ({
    openSubmenus: [],

    toggleSubmenu(index) {
        const idx = this.openSubmenus.indexOf(index);
        if (idx > -1) {
            this.openSubmenus.splice(idx, 1);
        } else {
            this.openSubmenus.push(index);
        }
    },

    isSubmenuOpen(index) {
        return this.openSubmenus.includes(index);
    },

    closeAll() {
        this.openSubmenus = [];
    }
}));

/**
 * Newsletter Component
 * Email subscription form
 */
Alpine.data('newsletter', () => ({
    email: '',
    isLoading: false,
    message: '',
    messageType: '', // success or error

    async submit() {
        if (!this.email || !this.validateEmail(this.email)) {
            this.message = 'لطفاً یک ایمیل معتبر وارد کنید';
            this.messageType = 'error';
            return;
        }

        this.isLoading = true;
        this.message = '';

        try {
            const response = await fetch(dstConfig?.ajaxUrl || '/wp-admin/admin-ajax.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'dst_newsletter_subscribe',
                    email: this.email,
                    nonce: dstConfig?.nonce || '',
                }),
            });
            const data = await response.json();
            if (data.success) {
                this.message = data.data.message || 'با موفقیت عضو شدید!';
                this.messageType = 'success';
                this.email = '';
            } else {
                this.message = data.data.message || 'خطایی رخ داد';
                this.messageType = 'error';
            }
        } catch (error) {
            this.message = 'خطا در ارتباط با سرور';
            this.messageType = 'error';
        } finally {
            this.isLoading = false;
        }
    },

    validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }
}));

/**
 * Back to Top Component
 */
Alpine.data('backToTop', () => ({
    isVisible: false,

    init() {
        window.addEventListener('scroll', () => {
            this.isVisible = window.scrollY > 500;
        }, { passive: true });
    },

    scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
}));

// ═══════════════════════════════════════════════════════════════
// Initialize Alpine
// ═══════════════════════════════════════════════════════════════
Alpine.start();

// ═══════════════════════════════════════════════════════════════
// Additional Utilities
// ═══════════════════════════════════════════════════════════════

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]:not([href="#"])').forEach(link => {
    link.addEventListener('click', (e) => {
        const targetId = link.getAttribute('href');
        const target = document.querySelector(targetId);

        if (target) {
            e.preventDefault();
            const headerHeight = document.querySelector('[x-data="header"]')?.offsetHeight || 80;
            const targetPosition = target.getBoundingClientRect().top + window.scrollY - headerHeight;

            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
        }
    });
});

// Log initialization
console.log('🚀 ModPress Theme with Alpine.js Loaded');
