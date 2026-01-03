/**
 * Sticky Header Script
 */
(function() {
    const header = document.querySelector('.hf-header-sticky');
    if (!header) return;

    const scrollBg = header.dataset.scrollBg;
    const originalBg = header.style.backgroundColor;

    function handleScroll() {
        if (window.scrollY > 50) {
            header.classList.add('is-scrolled');
            if (scrollBg) {
                header.style.backgroundColor = scrollBg;
            }
        } else {
            header.classList.remove('is-scrolled');
            header.style.backgroundColor = originalBg;
        }
    }

    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll(); // Initial check
})();
