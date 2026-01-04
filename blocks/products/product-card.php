<?php
/**
 * Product Card Template
 *
 * متغیرهای در دسترس:
 * - $product (WC_Product)
 * - $style, $hover_effect, $image_ratio
 * - $show_rating, $show_sale_badge, $show_add_to_cart, $show_wishlist
 * - $card_bg, $ratio_classes
 * - $product_index (برای انیمیشن)
 */

$product_id = $product->get_id();
$product_link = get_permalink($product_id);
$product_title = $product->get_name();
$product_image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'woocommerce_thumbnail');
$product_gallery = $product->get_gallery_image_ids();
$second_image = !empty($product_gallery) ? wp_get_attachment_image_src($product_gallery[0], 'woocommerce_thumbnail') : null;

// قیمت
$regular_price = $product->get_regular_price();
$sale_price = $product->get_sale_price();
$price_html = $product->get_price_html();

// تخفیف
$is_on_sale = $product->is_on_sale();
$sale_percent = 0;
if ($is_on_sale && $regular_price && $sale_price) {
    $sale_percent = round((($regular_price - $sale_price) / $regular_price) * 100);
}

// امتیاز
$rating = $product->get_average_rating();
$rating_count = $product->get_rating_count();

// وضعیت موجودی
$in_stock = $product->is_in_stock();

// استایل کارت
$card_classes = match($style) {
    'cards' => 'bg-white rounded-2xl shadow-md hover:shadow-xl',
    'bordered' => 'bg-white rounded-xl border border-gray-200 hover:border-primary-300',
    'minimal' => 'bg-transparent',
    default => 'bg-white rounded-2xl shadow-md hover:shadow-xl'
};
?>

<div
    class="group relative <?php echo esc_attr($card_classes); ?> overflow-hidden transition-all duration-300"
    style="<?php echo $style !== 'minimal' ? 'background-color:' . esc_attr($card_bg) . ';' : ''; ?>"
    x-data="{ shown: false, loading: false }"
    x-intersect:enter="shown = true"
    x-show="shown"
    x-transition:enter="transition ease-out duration-500"
    x-transition:enter-start="opacity-0 translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    style="transition-delay: <?php echo (isset($product_index) ? $product_index : 0) * 100; ?>ms;"
>
    <!-- تصویر -->
    <div class="relative overflow-hidden <?php echo esc_attr($ratio_classes[$image_ratio] ?? 'aspect-square'); ?>">
        <a href="<?php echo esc_url($product_link); ?>" class="block w-full h-full">
            <?php if ($product_image): ?>
                <img
                    src="<?php echo esc_url($product_image[0]); ?>"
                    alt="<?php echo esc_attr($product_title); ?>"
                    class="w-full h-full object-cover transition-all duration-500 <?php
                        echo $hover_effect === 'zoom' ? 'group-hover:scale-110' : '';
                        echo $hover_effect === 'fade' && $second_image ? 'group-hover:opacity-0' : '';
                        echo $hover_effect === 'slide' && $second_image ? 'group-hover:-translate-x-full' : '';
                    ?>"
                    loading="lazy"
                >
                <?php if ($second_image && in_array($hover_effect, ['fade', 'slide'])): ?>
                    <img
                        src="<?php echo esc_url($second_image[0]); ?>"
                        alt="<?php echo esc_attr($product_title); ?>"
                        class="absolute inset-0 w-full h-full object-cover transition-all duration-500 <?php
                            echo $hover_effect === 'fade' ? 'opacity-0 group-hover:opacity-100' : '';
                            echo $hover_effect === 'slide' ? 'translate-x-full group-hover:translate-x-0' : '';
                        ?>"
                        loading="lazy"
                    >
                <?php endif; ?>
            <?php else: ?>
                <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            <?php endif; ?>
        </a>

        <!-- نشان‌ها -->
        <div class="absolute top-3 right-3 rtl:right-auto rtl:left-3 flex flex-col gap-2 z-10">
            <?php if ($show_sale_badge && $is_on_sale && $sale_percent > 0): ?>
                <span class="inline-flex items-center justify-center min-w-[48px] px-2 py-1 bg-red-500 text-white text-xs font-bold rounded-lg">
                    <?php echo $sale_percent; ?>%-
                </span>
            <?php endif; ?>

            <?php if (!$in_stock): ?>
                <span class="inline-flex items-center justify-center px-2 py-1 bg-gray-800 text-white text-xs font-bold rounded-lg">
                    ناموجود
                </span>
            <?php endif; ?>

            <?php if ($product->is_featured()): ?>
                <span class="inline-flex items-center justify-center px-2 py-1 bg-yellow-400 text-gray-900 text-xs font-bold rounded-lg">
                    ویژه
                </span>
            <?php endif; ?>
        </div>

        <!-- دکمه‌های سریع -->
        <div class="absolute inset-x-0 bottom-0 p-4 bg-gradient-to-t from-gray-900/60 to-transparent translate-y-full group-hover:translate-y-0 transition-transform duration-300 flex items-end justify-center gap-2">
            <?php if ($show_add_to_cart && $in_stock): ?>
                <button
                    @click.prevent="loading = true; setTimeout(() => loading = false, 1500)"
                    data-product-id="<?php echo $product_id; ?>"
                    class="dst-add-to-cart flex-1 flex items-center justify-center gap-2 py-3 px-4 bg-white text-gray-900 rounded-lg font-semibold text-sm hover:bg-primary-600 hover:text-white transition-colors"
                >
                    <svg x-show="!loading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <svg x-show="loading" x-cloak class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>افزودن به سبد</span>
                </button>
            <?php endif; ?>

            <?php if ($show_wishlist): ?>
                <button
                    class="flex-shrink-0 w-12 h-12 flex items-center justify-center bg-white/90 text-gray-700 rounded-lg hover:bg-red-50 hover:text-red-500 transition-colors"
                    title="افزودن به علاقه‌مندی‌ها"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- محتوا -->
    <div class="p-4">
        <!-- دسته‌بندی -->
        <?php
        $categories = get_the_terms($product_id, 'product_cat');
        if ($categories && !is_wp_error($categories)):
            $cat = $categories[0];
        ?>
            <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="text-xs text-gray-500 hover:text-primary-600 transition-colors">
                <?php echo esc_html($cat->name); ?>
            </a>
        <?php endif; ?>

        <!-- عنوان -->
        <h3 class="mt-1 mb-2">
            <a href="<?php echo esc_url($product_link); ?>" class="text-gray-900 font-semibold hover:text-primary-600 transition-colors line-clamp-2">
                <?php echo esc_html($product_title); ?>
            </a>
        </h3>

        <!-- امتیاز -->
        <?php if ($show_rating && $rating > 0): ?>
            <div class="flex items-center gap-2 mb-3">
                <div class="flex gap-0.5 text-yellow-400">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <?php if ($i <= $rating): ?>
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                        <?php elseif ($i - 0.5 <= $rating): ?>
                            <svg class="w-4 h-4" viewBox="0 0 20 20">
                                <defs>
                                    <linearGradient id="half-<?php echo $product_id; ?>">
                                        <stop offset="50%" stop-color="currentColor"/>
                                        <stop offset="50%" stop-color="#E5E7EB"/>
                                    </linearGradient>
                                </defs>
                                <path fill="url(#half-<?php echo $product_id; ?>)" d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                        <?php else: ?>
                            <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
                <span class="text-xs text-gray-500">(<?php echo $rating_count; ?>)</span>
            </div>
        <?php endif; ?>

        <!-- قیمت -->
        <div class="flex items-center gap-2 flex-wrap">
            <?php if ($is_on_sale && $sale_price): ?>
                <span class="text-lg font-bold text-primary-600">
                    <?php echo wc_price($sale_price); ?>
                </span>
                <span class="text-sm text-gray-400 line-through">
                    <?php echo wc_price($regular_price); ?>
                </span>
            <?php else: ?>
                <span class="text-lg font-bold text-gray-900">
                    <?php echo $price_html; ?>
                </span>
            <?php endif; ?>
        </div>
    </div>
</div>
