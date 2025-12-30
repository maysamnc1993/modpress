<?php
/**
 * Header Template: Landing Page
 * هدر صفحه فرود با اسکرول هموار و CTA تبدیل
 */

defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$is_sticky = $settings['sticky'] ?? true;
$show_topbar = $settings['show_topbar'] ?? false;
$topbar_bg_color = $settings['topbar_bg_color'] ?? '#6366f1';
$topbar_text_color = $settings['topbar_text_color'] ?? '#ffffff';
$show_search = $settings['show_search'] ?? false;
$show_cart = $settings['show_cart'] ?? false;
$show_account = $settings['show_account'] ?? true;
$show_wishlist = $settings['show_wishlist'] ?? false;
$bg_color = $settings['bg_color'] ?? '#ffffff';
$text_color = $settings['text_color'] ?? '#1e293b';
$show_cta = $settings['show_cta'] ?? true;
$cta_text = $settings['cta_text'] ?? 'همین حالا شروع کنید';
$cta_url = $settings['cta_url'] ?? '#signup';
$cta_style = $settings['cta_style'] ?? 'primary';
$smooth_scroll = $settings['smooth_scroll'] ?? true;
$transparent_on_top = $settings['transparent_on_top'] ?? true;
$hide_nav_links = $settings['hide_nav_links'] ?? false;
?>

<header
    x-data="header"
    :class="{
        'shadow-lg bg-white': isScrolled,
        'bg-transparent': !isScrolled && <?php echo $transparent_on_top ? 'true' : 'false'; ?>
    }"
    class="<?php echo $is_sticky ? 'hf-header-sticky' : 'relative'; ?> transition-all duration-300"
    style="<?php echo !$transparent_on_top ? 'background-color: ' . esc_attr($bg_color) . ';' : ''; ?> color: <?php echo esc_attr($text_color); ?>;"
>
    <!-- Announcement Bar (Optional) -->
    <?php if ($show_topbar): ?>
    <div
        class="text-center py-2 text-sm font-medium"
        style="background-color: <?php echo esc_attr($topbar_bg_color); ?>; color: <?php echo esc_attr($topbar_text_color); ?>;"
    >
        <div class="hf-container flex items-center justify-center gap-2">
            <span>🎉</span>
            <span>پیشنهاد ویژه! 50% تخفیف برای اولین 100 نفر</span>
            <a href="#pricing" class="underline hover:no-underline font-semibold">اطلاعات بیشتر</a>
        </div>
    </div>
    <?php endif; ?>

    <!-- Main Header -->
    <div class="hf-container">
        <div class="flex items-center justify-between h-20">

            <!-- Logo -->
            <div class="flex-shrink-0">
                <?php dst_the_logo('default', 'h-10 w-auto max-w-[160px] object-contain'); ?>
            </div>

            <!-- Desktop Navigation (Anchor Links for Smooth Scroll) -->
            <?php if (!$hide_nav_links): ?>
                <nav class="hidden lg:flex items-center gap-8">
                    <a href="#features" class="text-secondary-700 hover:text-primary-600 font-medium transition-colors <?php echo $smooth_scroll ? 'smooth-scroll' : ''; ?>">
                        ویژگی‌ها
                    </a>
                    <a href="#benefits" class="text-secondary-700 hover:text-primary-600 font-medium transition-colors <?php echo $smooth_scroll ? 'smooth-scroll' : ''; ?>">
                        مزایا
                    </a>
                    <a href="#pricing" class="text-secondary-700 hover:text-primary-600 font-medium transition-colors <?php echo $smooth_scroll ? 'smooth-scroll' : ''; ?>">
                        قیمت‌گذاری
                    </a>
                    <a href="#testimonials" class="text-secondary-700 hover:text-primary-600 font-medium transition-colors <?php echo $smooth_scroll ? 'smooth-scroll' : ''; ?>">
                        نظرات
                    </a>
                    <a href="#faq" class="text-secondary-700 hover:text-primary-600 font-medium transition-colors <?php echo $smooth_scroll ? 'smooth-scroll' : ''; ?>">
                        سوالات متداول
                    </a>
                </nav>
            <?php endif; ?>

            <!-- Header Actions -->
            <div class="flex items-center gap-3">

                <!-- Login Link -->
                <?php if ($show_account): ?>
                    <a href="<?php echo dst_get_account_url(); ?>" class="hidden md:inline-flex text-secondary-700 hover:text-primary-600 font-medium transition-colors">
                        <?php echo is_user_logged_in() ? 'حساب من' : 'ورود'; ?>
                    </a>
                <?php endif; ?>

                <!-- Main CTA Button -->
                <?php if ($show_cta): ?>
                    <a
                        href="<?php echo esc_url($cta_url); ?>"
                        class="hf-btn hf-btn-<?php echo esc_attr($cta_style); ?> <?php echo $smooth_scroll && strpos($cta_url, '#') === 0 ? 'smooth-scroll' : ''; ?>"
                    >
                        <?php echo esc_html($cta_text); ?>
                        <?php echo dst_get_icon('arrow-left', 'w-4 h-4 mr-1 rtl:mr-0 rtl:ml-1'); ?>
                    </a>
                <?php endif; ?>

                <!-- Mobile Menu Toggle -->
                <button
                    @click="toggleMobileMenu()"
                    class="lg:hidden hf-icon-btn"
                    :class="{ 'text-primary-600': isMobileMenuOpen }"
                    aria-label="منو"
                >
                    <div class="hf-hamburger" :class="{ 'is-active': isMobileMenuOpen }">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div
        class="hf-mobile-menu-overlay lg:hidden"
        :class="{ 'is-open': isMobileMenuOpen }"
        @click="closeMobileMenu()"
    ></div>

    <div class="hf-mobile-menu lg:hidden" :class="{ 'is-open': isMobileMenuOpen }">
        <div class="flex items-center justify-between p-4 border-b border-secondary-100">
            <span class="text-lg font-bold text-secondary-800">منو</span>
            <button @click="closeMobileMenu()" class="hf-icon-btn">
                <?php echo dst_get_icon('close'); ?>
            </button>
        </div>

        <?php if (!$hide_nav_links): ?>
            <nav class="p-4 space-y-1">
                <a href="#features" @click="closeMobileMenu()" class="block py-3 px-4 text-secondary-700 hover:bg-secondary-50 rounded-lg transition-colors <?php echo $smooth_scroll ? 'smooth-scroll' : ''; ?>">
                    ویژگی‌ها
                </a>
                <a href="#benefits" @click="closeMobileMenu()" class="block py-3 px-4 text-secondary-700 hover:bg-secondary-50 rounded-lg transition-colors <?php echo $smooth_scroll ? 'smooth-scroll' : ''; ?>">
                    مزایا
                </a>
                <a href="#pricing" @click="closeMobileMenu()" class="block py-3 px-4 text-secondary-700 hover:bg-secondary-50 rounded-lg transition-colors <?php echo $smooth_scroll ? 'smooth-scroll' : ''; ?>">
                    قیمت‌گذاری
                </a>
                <a href="#testimonials" @click="closeMobileMenu()" class="block py-3 px-4 text-secondary-700 hover:bg-secondary-50 rounded-lg transition-colors <?php echo $smooth_scroll ? 'smooth-scroll' : ''; ?>">
                    نظرات
                </a>
                <a href="#faq" @click="closeMobileMenu()" class="block py-3 px-4 text-secondary-700 hover:bg-secondary-50 rounded-lg transition-colors <?php echo $smooth_scroll ? 'smooth-scroll' : ''; ?>">
                    سوالات متداول
                </a>
            </nav>
        <?php endif; ?>

        <div class="p-4 border-t border-secondary-100 mt-auto space-y-3">
            <?php if ($show_account): ?>
                <a href="<?php echo dst_get_account_url(); ?>" class="hf-btn hf-btn-secondary w-full">
                    <?php echo dst_get_icon('user', 'w-5 h-5'); ?>
                    <span><?php echo is_user_logged_in() ? 'حساب من' : 'ورود'; ?></span>
                </a>
            <?php endif; ?>

            <?php if ($show_cta): ?>
                <a href="<?php echo esc_url($cta_url); ?>" @click="closeMobileMenu()" class="hf-btn hf-btn-<?php echo esc_attr($cta_style); ?> w-full <?php echo $smooth_scroll && strpos($cta_url, '#') === 0 ? 'smooth-scroll' : ''; ?>">
                    <?php echo esc_html($cta_text); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>

<?php if ($smooth_scroll): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Smooth scroll for anchor links
        document.querySelectorAll('a.smooth-scroll[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    });
</script>
<?php endif; ?>
