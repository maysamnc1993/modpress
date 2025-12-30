<?php
/**
 * Header Template: Sidebar Toggle
 * هدر با سایدبار کامل قابل باز شدن
 */

defined('ABSPATH') || exit;

$settings = dst_get_header_setting();
$is_sticky = $settings['sticky'] ?? true;
$sidebar_position = $settings['sidebar_position'] ?? 'right';
$sidebar_width = $settings['sidebar_width'] ?? 400;
$sidebar_bg_color = $settings['sidebar_bg_color'] ?? '#ffffff';
$sidebar_overlay_color = $settings['sidebar_overlay_color'] ?? '#000000';
$sidebar_overlay_opacity = ($settings['sidebar_overlay_opacity'] ?? 50) / 100;
$show_categories = $settings['show_categories'] ?? true;
$show_search = $settings['show_search'] ?? true;
$show_cart = $settings['show_cart'] ?? true;
$show_account = $settings['show_account'] ?? true;
$show_social = $settings['show_social'] ?? true;
$show_contact = $settings['show_contact'] ?? true;
$bg_color = $settings['bg_color'] ?? '#ffffff';
$text_color = $settings['text_color'] ?? '#1f2937';
$hamburger_style = $settings['hamburger_style'] ?? 'default';
$animation_speed = $settings['animation_speed'] ?? 300;
$show_logo_in_sidebar = $settings['show_logo_in_sidebar'] ?? true;
?>

<header
    x-data="header"
    :class="{ 'shadow-md': isScrolled }"
    class="<?php echo $is_sticky ? 'hf-header-sticky' : 'relative'; ?> transition-all duration-300"
    style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;"
>
    <div class="hf-container">
        <div class="flex items-center justify-between h-20">

            <!-- Hamburger Menu (Always Visible) -->
            <button
                @click="toggleMobileMenu()"
                class="hf-icon-btn flex-shrink-0"
                :class="{ 'text-primary-600': isMobileMenuOpen }"
                aria-label="منو"
            >
                <?php if ($hamburger_style === 'dots'): ?>
                    <div class="flex flex-col gap-1">
                        <div class="w-1.5 h-1.5 rounded-full bg-current"></div>
                        <div class="w-1.5 h-1.5 rounded-full bg-current"></div>
                        <div class="w-1.5 h-1.5 rounded-full bg-current"></div>
                    </div>
                <?php elseif ($hamburger_style === 'arrow'): ?>
                    <div class="transform transition-transform" :class="{ 'rotate-180': isMobileMenuOpen }">
                        <?php echo dst_get_icon('chevron-right', 'w-6 h-6'); ?>
                    </div>
                <?php else: ?>
                    <div class="hf-hamburger" :class="{ 'is-active': isMobileMenuOpen }">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                <?php endif; ?>
            </button>

            <!-- Logo (Centered) -->
            <div class="absolute left-1/2 transform -translate-x-1/2">
                <?php dst_the_logo('default', 'h-10 w-auto max-w-[180px] object-contain'); ?>
            </div>

            <!-- Header Actions -->
            <div class="flex items-center gap-2 flex-shrink-0">

                <!-- Cart -->
                <?php if ($show_cart && dst_is_woocommerce_active()): ?>
                    <div class="relative" x-data="miniCart">
                        <button @click="toggle()" class="hf-cart-icon hf-icon-btn">
                            <?php echo dst_get_icon('cart'); ?>
                            <?php if (dst_get_cart_count() > 0): ?>
                                <span class="hf-badge hf-badge-primary"><?php echo dst_get_cart_count(); ?></span>
                            <?php endif; ?>
                        </button>
                        <?php echo dst_mini_cart(); ?>
                    </div>
                <?php endif; ?>

                <!-- Wishlist -->
                <?php if (function_exists('YITH_WCWL')): ?>
                    <?php echo dst_wishlist_icon('hidden md:flex'); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Sidebar Overlay -->
    <div
        class="hf-mobile-menu-overlay"
        :class="{ 'is-open': isMobileMenuOpen }"
        @click="closeMobileMenu()"
        style="background-color: rgba(<?php echo hexdec(substr($sidebar_overlay_color, 1, 2)) . ',' . hexdec(substr($sidebar_overlay_color, 3, 2)) . ',' . hexdec(substr($sidebar_overlay_color, 5, 2)); ?>, <?php echo esc_attr($sidebar_overlay_opacity); ?>);"
    ></div>

    <!-- Full Sidebar Menu -->
    <div
        class="fixed top-0 <?php echo $sidebar_position === 'left' ? 'left-0' : 'right-0 rtl:right-auto rtl:left-0'; ?> h-full shadow-2xl z-[9999] transform transition-transform"
        :class="{
            'translate-x-0': isMobileMenuOpen && '<?php echo $sidebar_position; ?>' === 'left',
            '-translate-x-full': !isMobileMenuOpen && '<?php echo $sidebar_position; ?>' === 'left',
            'translate-x-0 rtl:-translate-x-0': isMobileMenuOpen && '<?php echo $sidebar_position; ?>' === 'right',
            'translate-x-full rtl:-translate-x-full': !isMobileMenuOpen && '<?php echo $sidebar_position; ?>' === 'right'
        }"
        style="width: <?php echo esc_attr($sidebar_width); ?>px; max-width: 90vw; background-color: <?php echo esc_attr($sidebar_bg_color); ?>; transition-duration: <?php echo esc_attr($animation_speed); ?>ms;"
    >
        <!-- Sidebar Header -->
        <div class="flex items-center justify-between p-6 border-b border-secondary-100 bg-gradient-to-r from-primary-600 to-primary-700 text-white">
            <?php if ($show_logo_in_sidebar): ?>
                <?php dst_the_logo('light', 'h-8 w-auto'); ?>
            <?php else: ?>
                <span class="text-lg font-bold">منو</span>
            <?php endif; ?>
            <button @click="closeMobileMenu()" class="text-white hover:text-primary-200 transition-colors">
                <?php echo dst_get_icon('close', 'w-6 h-6'); ?>
            </button>
        </div>

        <!-- Sidebar Content -->
        <div class="h-[calc(100%-73px)] overflow-y-auto">

            <!-- User Account Section -->
            <?php if ($show_account): ?>
                <div class="p-6 border-b border-secondary-100 bg-secondary-50">
                    <?php if (is_user_logged_in()): ?>
                        <div class="flex items-center gap-3">
                            <?php echo get_avatar(get_current_user_id(), 56, '', '', ['class' => 'rounded-full border-2 border-primary-500']); ?>
                            <div class="flex-1">
                                <div class="font-semibold text-secondary-800"><?php echo wp_get_current_user()->display_name; ?></div>
                                <a href="<?php echo dst_get_account_url(); ?>" class="text-sm text-primary-600 hover:text-primary-700 flex items-center gap-1 mt-1">
                                    <span>مشاهده پروفایل</span>
                                    <?php echo dst_get_icon('arrow-left', 'w-3 h-3'); ?>
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo dst_get_account_url(); ?>" class="hf-btn hf-btn-primary w-full justify-center">
                            <?php echo dst_get_icon('user', 'w-5 h-5'); ?>
                            <span>ورود / ثبت نام</span>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Search -->
            <?php if ($show_search): ?>
                <div class="p-6 border-b border-secondary-100">
                    <div class="text-sm font-semibold text-secondary-600 mb-3">جستجو</div>
                    <?php echo dst_product_search_form(); ?>
                </div>
            <?php endif; ?>

            <!-- Product Categories -->
            <?php if ($show_categories && dst_is_woocommerce_active()): ?>
                <div class="p-6 border-b border-secondary-100">
                    <div class="text-sm font-semibold text-secondary-600 mb-3">دسته‌بندی محصولات</div>
                    <div class="space-y-2">
                        <?php
                        $product_categories = get_terms([
                            'taxonomy' => 'product_cat',
                            'hide_empty' => true,
                            'parent' => 0,
                            'number' => 8,
                        ]);
                        if (!empty($product_categories) && !is_wp_error($product_categories)):
                            foreach ($product_categories as $category):
                        ?>
                            <a href="<?php echo get_term_link($category); ?>" class="flex items-center justify-between p-3 rounded-lg hover:bg-secondary-50 transition-colors group">
                                <span class="text-secondary-700 group-hover:text-primary-600"><?php echo esc_html($category->name); ?></span>
                                <span class="text-xs text-secondary-400"><?php echo esc_html($category->count); ?></span>
                            </a>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Main Navigation -->
            <nav class="p-6 border-b border-secondary-100">
                <div class="text-sm font-semibold text-secondary-600 mb-3">منوی اصلی</div>
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'space-y-2',
                    'fallback_cb' => false,
                    'depth' => 3,
                    'walker' => class_exists('DST_Mobile_Menu_Walker') ? new DST_Mobile_Menu_Walker() : null,
                ]);
                ?>
            </nav>

            <!-- Cart Summary -->
            <?php if ($show_cart && dst_is_woocommerce_active() && dst_get_cart_count() > 0): ?>
                <div class="p-6 border-b border-secondary-100 bg-secondary-50">
                    <div class="flex items-center justify-between mb-3">
                        <span class="font-semibold text-secondary-800">سبد خرید شما</span>
                        <span class="hf-badge hf-badge-primary"><?php echo dst_get_cart_count(); ?> محصول</span>
                    </div>
                    <div class="text-sm text-secondary-600 mb-3">
                        جمع کل: <span class="font-bold text-primary-600"><?php echo WC()->cart->get_cart_total(); ?></span>
                    </div>
                    <a href="<?php echo dst_get_cart_url(); ?>" class="hf-btn hf-btn-primary w-full justify-center">
                        مشاهده سبد خرید
                    </a>
                </div>
            <?php endif; ?>

            <!-- Contact Info -->
            <?php
            $phone = dst_get_contact('phone');
            $email = dst_get_contact('email');
            $address = dst_get_contact('address');
            ?>
            <?php if ($show_contact && ($phone || $email || $address)): ?>
                <div class="p-6 border-b border-secondary-100">
                    <div class="text-sm font-semibold text-secondary-600 mb-3">اطلاعات تماس</div>
                    <div class="space-y-3">
                        <?php if ($phone): ?>
                            <a href="tel:<?php echo esc_attr($phone); ?>" class="flex items-center gap-3 text-secondary-700 hover:text-primary-600 transition-colors">
                                <div class="w-10 h-10 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center flex-shrink-0">
                                    <?php echo dst_get_icon('phone', 'w-5 h-5'); ?>
                                </div>
                                <span class="text-sm"><?php echo esc_html($phone); ?></span>
                            </a>
                        <?php endif; ?>
                        <?php if ($email): ?>
                            <a href="mailto:<?php echo esc_attr($email); ?>" class="flex items-center gap-3 text-secondary-700 hover:text-primary-600 transition-colors">
                                <div class="w-10 h-10 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center flex-shrink-0">
                                    <?php echo dst_get_icon('mail', 'w-5 h-5'); ?>
                                </div>
                                <span class="text-sm break-all"><?php echo esc_html($email); ?></span>
                            </a>
                        <?php endif; ?>
                        <?php if ($address): ?>
                            <div class="flex items-start gap-3 text-secondary-700">
                                <div class="w-10 h-10 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center flex-shrink-0">
                                    <?php echo dst_get_icon('map-pin', 'w-5 h-5'); ?>
                                </div>
                                <span class="text-sm"><?php echo esc_html($address); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Social Links -->
            <?php if ($show_social && (dst_get_social('instagram') || dst_get_social('telegram') || dst_get_social('whatsapp'))): ?>
                <div class="p-6">
                    <div class="text-sm font-semibold text-secondary-600 mb-3">شبکه‌های اجتماعی</div>
                    <div class="flex items-center gap-3 flex-wrap">
                        <?php
                        $social_networks = ['instagram', 'telegram', 'whatsapp', 'twitter', 'youtube', 'linkedin'];
                        foreach ($social_networks as $network):
                            $url = dst_get_social($network);
                            if (!$url) continue;
                        ?>
                            <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener" class="hf-icon-btn bg-secondary-100 hover:bg-primary-600 hover:text-white transition-colors">
                                <?php echo dst_get_icon($network, 'w-5 h-5'); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>
