<?php
/**
 * WooCommerce Helper Functions
 *
 * توابع کمکی برای کار با ووکامرس در هدر و فوتر
 *
 * @package Developer_Starter
 * @since 2.0.0
 */

defined('ABSPATH') || exit;

/**
 * بررسی فعال بودن ووکامرس
 */
function dst_is_woocommerce_active() {
    return class_exists('WooCommerce');
}

/**
 * گرفتن تعداد محصولات در سبد خرید
 */
function dst_get_cart_count() {
    if (!dst_is_woocommerce_active() || !WC()->cart) {
        return 0;
    }
    return WC()->cart->get_cart_contents_count();
}

/**
 * گرفتن جمع کل سبد خرید
 */
function dst_get_cart_total() {
    if (!dst_is_woocommerce_active() || !WC()->cart) {
        return '';
    }
    return WC()->cart->get_cart_total();
}

/**
 * گرفتن لینک سبد خرید
 */
function dst_get_cart_url() {
    if (!dst_is_woocommerce_active()) {
        return '#';
    }
    return wc_get_cart_url();
}

/**
 * گرفتن لینک تسویه حساب
 */
function dst_get_checkout_url() {
    if (!dst_is_woocommerce_active()) {
        return '#';
    }
    return wc_get_checkout_url();
}

/**
 * گرفتن لینک حساب کاربری
 */
function dst_get_account_url() {
    if (!dst_is_woocommerce_active()) {
        return wp_login_url();
    }
    return wc_get_page_permalink('myaccount');
}

/**
 * گرفتن لینک فروشگاه
 */
function dst_get_shop_url() {
    if (!dst_is_woocommerce_active()) {
        return home_url('/shop');
    }
    return wc_get_page_permalink('shop');
}

/**
 * گرفتن لینک لیست علاقه‌مندی‌ها (اگر YITH Wishlist نصب باشد)
 */
function dst_get_wishlist_url() {
    if (function_exists('YITH_WCWL')) {
        return YITH_WCWL()->get_wishlist_url();
    }
    return '#';
}

/**
 * گرفتن تعداد آیتم‌های لیست علاقه‌مندی
 */
function dst_get_wishlist_count() {
    if (function_exists('YITH_WCWL')) {
        return YITH_WCWL()->count_products();
    }
    return 0;
}

/**
 * رندر آیکون سبد خرید با تعداد
 */
function dst_cart_icon($class = '') {
    if (!dst_is_woocommerce_active()) {
        return '';
    }

    $count = dst_get_cart_count();
    $url = dst_get_cart_url();

    ob_start();
    ?>
    <a href="<?php echo esc_url($url); ?>" class="hf-cart-icon <?php echo esc_attr($class); ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <?php if ($count > 0): ?>
            <span class="hf-badge hf-badge-primary"><?php echo esc_html($count); ?></span>
        <?php endif; ?>
    </a>
    <?php
    return ob_get_clean();
}

/**
 * رندر مینی کارت
 */
function dst_mini_cart() {
    if (!dst_is_woocommerce_active()) {
        return '';
    }

    ob_start();
    ?>
    <div class="hf-mini-cart" x-data="miniCart" @click.outside="close()">
        <div class="hf-mini-cart-header">
            <h4 class="text-sm font-bold text-secondary-800">
                سبد خرید
                <span class="text-secondary-500">(<span x-text="count || <?php echo dst_get_cart_count(); ?>"></span>)</span>
            </h4>
        </div>

        <div class="hf-mini-cart-body">
            <?php if (WC()->cart->is_empty()): ?>
                <p class="text-center py-8 text-secondary-500">سبد خرید شما خالی است</p>
            <?php else: ?>
                <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item):
                    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                    $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                    $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
                    $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
                    $product_price = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                    $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                ?>
                    <div class="hf-mini-cart-item">
                        <div class="hf-mini-cart-item-image">
                            <?php if ($product_permalink): ?>
                                <a href="<?php echo esc_url($product_permalink); ?>">
                                    <?php echo $thumbnail; ?>
                                </a>
                            <?php else: ?>
                                <?php echo $thumbnail; ?>
                            <?php endif; ?>
                        </div>
                        <div class="hf-mini-cart-item-info">
                            <?php if ($product_permalink): ?>
                                <a href="<?php echo esc_url($product_permalink); ?>" class="text-sm font-medium text-secondary-800 hover:text-primary-600 line-clamp-2">
                                    <?php echo esc_html($product_name); ?>
                                </a>
                            <?php else: ?>
                                <span class="text-sm font-medium text-secondary-800 line-clamp-2">
                                    <?php echo esc_html($product_name); ?>
                                </span>
                            <?php endif; ?>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-xs text-secondary-500"><?php echo $cart_item['quantity']; ?> ×</span>
                                <span class="text-sm font-bold text-primary-600"><?php echo $product_price; ?></span>
                            </div>
                        </div>
                        <button
                            type="button"
                            @click="removeItem('<?php echo esc_js($cart_item_key); ?>')"
                            class="text-secondary-400 hover:text-red-500 transition-colors"
                            title="حذف"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?php if (!WC()->cart->is_empty()): ?>
            <div class="hf-mini-cart-footer">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-sm text-secondary-600">جمع کل:</span>
                    <span class="text-lg font-bold text-primary-600"><?php echo WC()->cart->get_cart_total(); ?></span>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="hf-btn hf-btn-secondary text-center">
                        مشاهده سبد
                    </a>
                    <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="hf-btn hf-btn-primary text-center">
                        تسویه حساب
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * رندر آیکون حساب کاربری
 */
function dst_account_icon($class = '') {
    $url = dst_get_account_url();
    $is_logged_in = is_user_logged_in();
    $current_user = wp_get_current_user();

    ob_start();
    ?>
    <div class="relative group <?php echo esc_attr($class); ?>">
        <a href="<?php echo esc_url($url); ?>" class="hf-icon-btn">
            <?php if ($is_logged_in && get_avatar_url($current_user->ID)): ?>
                <img src="<?php echo esc_url(get_avatar_url($current_user->ID, ['size' => 32])); ?>"
                     alt="<?php echo esc_attr($current_user->display_name); ?>"
                     class="w-8 h-8 rounded-full object-cover">
            <?php else: ?>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            <?php endif; ?>
        </a>

        <!-- Account Dropdown -->
        <div class="absolute top-full left-0 rtl:left-auto rtl:right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-secondary-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
            <?php if ($is_logged_in): ?>
                <div class="px-4 py-3 border-b border-secondary-100">
                    <p class="text-sm font-medium text-secondary-800"><?php echo esc_html($current_user->display_name); ?></p>
                    <p class="text-xs text-secondary-500 truncate"><?php echo esc_html($current_user->user_email); ?></p>
                </div>
                <div class="py-2">
                    <?php if (dst_is_woocommerce_active()): ?>
                        <a href="<?php echo esc_url(wc_get_account_endpoint_url('dashboard')); ?>" class="block px-4 py-2 text-sm text-secondary-600 hover:bg-secondary-50 hover:text-primary-600">
                            پیشخوان
                        </a>
                        <a href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>" class="block px-4 py-2 text-sm text-secondary-600 hover:bg-secondary-50 hover:text-primary-600">
                            سفارشات
                        </a>
                        <a href="<?php echo esc_url(wc_get_account_endpoint_url('edit-account')); ?>" class="block px-4 py-2 text-sm text-secondary-600 hover:bg-secondary-50 hover:text-primary-600">
                            ویرایش حساب
                        </a>
                    <?php endif; ?>
                    <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                        خروج
                    </a>
                </div>
            <?php else: ?>
                <div class="p-4">
                    <a href="<?php echo esc_url($url); ?>" class="hf-btn hf-btn-primary w-full text-center mb-2">
                        ورود
                    </a>
                    <?php if (get_option('woocommerce_enable_myaccount_registration') === 'yes' || get_option('users_can_register')): ?>
                        <a href="<?php echo esc_url($url); ?>" class="hf-btn hf-btn-secondary w-full text-center">
                            ثبت‌نام
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * رندر آیکون علاقه‌مندی
 */
function dst_wishlist_icon($class = '') {
    if (!function_exists('YITH_WCWL')) {
        return '';
    }

    $count = dst_get_wishlist_count();
    $url = dst_get_wishlist_url();

    ob_start();
    ?>
    <a href="<?php echo esc_url($url); ?>" class="hf-cart-icon <?php echo esc_attr($class); ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>
        <?php if ($count > 0): ?>
            <span class="hf-badge hf-badge-danger"><?php echo esc_html($count); ?></span>
        <?php endif; ?>
    </a>
    <?php
    return ob_get_clean();
}

/**
 * رندر فرم جستجوی محصولات
 */
function dst_product_search_form($class = '') {
    ob_start();
    ?>
    <div class="hf-search-box <?php echo esc_attr($class); ?>" x-data="liveSearch">
        <form action="<?php echo esc_url(home_url('/')); ?>" method="get" @submit.prevent="search()">
            <input type="search"
                   name="s"
                   x-model="query"
                   @focus="isOpen = results.length > 0"
                   class="hf-search-input"
                   placeholder="جستجوی محصولات..."
                   autocomplete="off">
            <input type="hidden" name="post_type" value="product">
            <svg xmlns="http://www.w3.org/2000/svg" class="hf-search-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </form>

        <!-- Search Results Dropdown -->
        <div x-show="isOpen"
             x-transition
             @click.outside="close()"
             class="absolute top-full left-0 right-0 mt-2 bg-white rounded-lg shadow-xl border border-secondary-100 max-h-96 overflow-y-auto z-50">

            <template x-if="isLoading">
                <div class="p-4 text-center">
                    <svg class="animate-spin h-6 w-6 mx-auto text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </template>

            <template x-if="!isLoading && results.length === 0 && query.length >= 3">
                <p class="p-4 text-center text-secondary-500">محصولی یافت نشد</p>
            </template>

            <template x-for="result in results" :key="result.id">
                <a :href="result.url" class="flex gap-3 p-3 hover:bg-secondary-50 transition-colors border-b border-secondary-50 last:border-0">
                    <img :src="result.image" :alt="result.title" class="w-12 h-12 object-cover rounded-lg bg-secondary-100">
                    <div class="flex-1 min-w-0">
                        <h4 x-text="result.title" class="text-sm font-medium text-secondary-800 line-clamp-1"></h4>
                        <p x-html="result.price" class="text-sm text-primary-600 mt-1"></p>
                    </div>
                </a>
            </template>

            <template x-if="!isLoading && results.length > 0">
                <a :href="'<?php echo esc_url(home_url('/?s=')); ?>' + encodeURIComponent(query) + '&post_type=product'"
                   class="block p-3 text-center text-sm font-medium text-primary-600 hover:bg-primary-50 border-t border-secondary-100">
                    مشاهده همه نتایج
                </a>
            </template>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * آیکون‌های SVG برای هدر و فوتر
 */
function dst_get_icon($name, $class = 'w-6 h-6') {
    $icons = [
        'cart' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . esc_attr($class) . '" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>',

        'user' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . esc_attr($class) . '" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>',

        'heart' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . esc_attr($class) . '" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>',

        'search' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . esc_attr($class) . '" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>',

        'menu' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . esc_attr($class) . '" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" /></svg>',

        'close' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . esc_attr($class) . '" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>',

        'chevron-down' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . esc_attr($class) . '" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>',

        'phone' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . esc_attr($class) . '" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>',

        'mail' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . esc_attr($class) . '" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>',

        'location' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . esc_attr($class) . '" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>',

        'instagram' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . esc_attr($class) . '" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>',

        'telegram' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . esc_attr($class) . '" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>',

        'whatsapp' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . esc_attr($class) . '" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>',

        'twitter' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . esc_attr($class) . '" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',

        'facebook' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . esc_attr($class) . '" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',

        'linkedin' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . esc_attr($class) . '" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',

        'youtube' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . esc_attr($class) . '" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
    ];

    return isset($icons[$name]) ? $icons[$name] : '';
}

/**
 * AJAX Handler: دریافت مینی کارت
 */
add_action('wp_ajax_dst_get_mini_cart', 'dst_ajax_get_mini_cart');
add_action('wp_ajax_nopriv_dst_get_mini_cart', 'dst_ajax_get_mini_cart');

function dst_ajax_get_mini_cart() {
    if (!dst_is_woocommerce_active()) {
        wp_send_json_error(['message' => 'WooCommerce is not active']);
        return;
    }

    $items = [];
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        $_product = $cart_item['data'];
        $items[] = [
            'key' => $cart_item_key,
            'name' => $_product->get_name(),
            'quantity' => $cart_item['quantity'],
            'price' => WC()->cart->get_product_price($_product),
            'image' => wp_get_attachment_url($_product->get_image_id()) ?: wc_placeholder_img_src(),
            'url' => $_product->get_permalink(),
        ];
    }

    wp_send_json_success([
        'items' => $items,
        'count' => WC()->cart->get_cart_contents_count(),
        'total' => WC()->cart->get_cart_total(),
    ]);
}

/**
 * AJAX Handler: حذف آیتم از سبد
 */
add_action('wp_ajax_dst_remove_cart_item', 'dst_ajax_remove_cart_item');
add_action('wp_ajax_nopriv_dst_remove_cart_item', 'dst_ajax_remove_cart_item');

function dst_ajax_remove_cart_item() {
    if (!dst_is_woocommerce_active()) {
        wp_send_json_error(['message' => 'WooCommerce is not active']);
        return;
    }

    $cart_key = isset($_POST['cart_key']) ? sanitize_text_field($_POST['cart_key']) : '';

    if ($cart_key && WC()->cart->remove_cart_item($cart_key)) {
        wp_send_json_success(['message' => 'آیتم با موفقیت حذف شد']);
    } else {
        wp_send_json_error(['message' => 'خطا در حذف آیتم']);
    }
}

/**
 * AJAX Handler: جستجوی زنده محصولات
 */
add_action('wp_ajax_dst_live_search', 'dst_ajax_live_search');
add_action('wp_ajax_nopriv_dst_live_search', 'dst_ajax_live_search');

function dst_ajax_live_search() {
    $query = isset($_POST['query']) ? sanitize_text_field($_POST['query']) : '';

    if (strlen($query) < 3) {
        wp_send_json_success([]);
        return;
    }

    $args = [
        'post_type' => 'product',
        'post_status' => 'publish',
        's' => $query,
        'posts_per_page' => 8,
    ];

    $products = new WP_Query($args);
    $results = [];

    if ($products->have_posts()) {
        while ($products->have_posts()) {
            $products->the_post();
            $product = wc_get_product(get_the_ID());

            if (!$product) continue;

            $results[] = [
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'url' => get_permalink(),
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') ?: wc_placeholder_img_src('thumbnail'),
                'price' => $product->get_price_html(),
            ];
        }
        wp_reset_postdata();
    }

    wp_send_json_success($results);
}

/**
 * AJAX Handler: عضویت در خبرنامه
 */
add_action('wp_ajax_dst_newsletter_subscribe', 'dst_ajax_newsletter_subscribe');
add_action('wp_ajax_nopriv_dst_newsletter_subscribe', 'dst_ajax_newsletter_subscribe');

function dst_ajax_newsletter_subscribe() {
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';

    if (!is_email($email)) {
        wp_send_json_error(['message' => 'ایمیل نامعتبر است']);
        return;
    }

    // ذخیره در دیتابیس
    $subscribers = get_option('dst_newsletter_subscribers', []);

    if (in_array($email, $subscribers)) {
        wp_send_json_error(['message' => 'این ایمیل قبلاً ثبت شده است']);
        return;
    }

    $subscribers[] = $email;
    update_option('dst_newsletter_subscribers', $subscribers);

    // اگر MailChimp یا پلاگین دیگری نصب باشد، می‌توان اینجا هوک زد
    do_action('dst_newsletter_subscribed', $email);

    wp_send_json_success(['message' => 'با موفقیت در خبرنامه عضو شدید!']);
}
