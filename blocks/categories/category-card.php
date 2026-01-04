<?php
/**
 * Category Card Template
 *
 * متغیرهای در دسترس:
 * - $term (WP_Term)
 * - $term_link
 * - $image (تصویر)
 * - $style, $hover_effect, $image_ratio
 * - $show_count, $show_description
 * - $overlay_color, $text_color, $ratio_classes
 */

$count_text = '';
if ($taxonomy === 'product_cat') {
    $count_text = sprintf(_n('%s محصول', '%s محصول', $term->count, 'developer-starter'), number_format_i18n($term->count));
} else {
    $count_text = sprintf(_n('%s مطلب', '%s مطلب', $term->count, 'developer-starter'), number_format_i18n($term->count));
}

// افکت‌های هاور
$hover_classes = match($hover_effect) {
    'zoom' => 'hover:scale-105',
    'lift' => 'hover:-translate-y-2 hover:shadow-2xl',
    'glow' => 'hover:ring-4 hover:ring-primary-300',
    default => ''
};

$image_hover = $hover_effect === 'zoom' ? 'group-hover:scale-110' : '';
?>

<?php if ($style === 'overlay'): ?>
    <!-- متن روی تصویر -->
    <a
        href="<?php echo esc_url($term_link); ?>"
        class="group block relative overflow-hidden rounded-2xl <?php echo esc_attr($hover_classes); ?> transition-all duration-500"
    >
        <div class="<?php echo esc_attr($ratio_classes[$image_ratio] ?? 'aspect-square'); ?>">
            <?php if ($image): ?>
                <img
                    src="<?php echo esc_url($image[0]); ?>"
                    alt="<?php echo esc_attr($term->name); ?>"
                    class="w-full h-full object-cover transition-transform duration-700 <?php echo esc_attr($image_hover); ?>"
                    loading="lazy"
                >
            <?php else: ?>
                <div class="w-full h-full bg-gradient-to-br from-primary-500 to-primary-700"></div>
            <?php endif; ?>
        </div>

        <!-- Overlay -->
        <div
            class="absolute inset-0 flex flex-col items-center justify-center p-6 transition-all duration-300"
            style="background: <?php echo esc_attr($overlay_color); ?>; color: <?php echo esc_attr($text_color); ?>;"
        >
            <h3 class="text-xl md:text-2xl font-bold mb-2 text-center"><?php echo esc_html($term->name); ?></h3>

            <?php if ($show_count): ?>
                <span class="text-sm opacity-80"><?php echo esc_html($count_text); ?></span>
            <?php endif; ?>

            <?php if ($show_description && $term->description): ?>
                <p class="mt-3 text-sm text-center opacity-80 line-clamp-2"><?php echo esc_html($term->description); ?></p>
            <?php endif; ?>

            <span class="mt-4 inline-flex items-center gap-2 text-sm font-medium opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0 transition-all">
                مشاهده
                <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </span>
        </div>
    </a>

<?php elseif ($style === 'below'): ?>
    <!-- متن زیر تصویر -->
    <a
        href="<?php echo esc_url($term_link); ?>"
        class="group block <?php echo esc_attr($hover_classes); ?> transition-all duration-500"
    >
        <div class="overflow-hidden rounded-2xl mb-4 <?php echo esc_attr($ratio_classes[$image_ratio] ?? 'aspect-square'); ?>">
            <?php if ($image): ?>
                <img
                    src="<?php echo esc_url($image[0]); ?>"
                    alt="<?php echo esc_attr($term->name); ?>"
                    class="w-full h-full object-cover transition-transform duration-700 <?php echo esc_attr($image_hover); ?>"
                    loading="lazy"
                >
            <?php else: ?>
                <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
            <?php endif; ?>
        </div>

        <h3 class="text-lg font-bold text-gray-900 group-hover:text-primary-600 transition-colors mb-1">
            <?php echo esc_html($term->name); ?>
        </h3>

        <?php if ($show_count): ?>
            <span class="text-sm text-gray-500"><?php echo esc_html($count_text); ?></span>
        <?php endif; ?>

        <?php if ($show_description && $term->description): ?>
            <p class="mt-2 text-sm text-gray-600 line-clamp-2"><?php echo esc_html($term->description); ?></p>
        <?php endif; ?>
    </a>

<?php elseif ($style === 'card'): ?>
    <!-- کارتی -->
    <a
        href="<?php echo esc_url($term_link); ?>"
        class="group block bg-white rounded-2xl shadow-md hover:shadow-xl <?php echo esc_attr($hover_classes); ?> overflow-hidden transition-all duration-500"
    >
        <div class="<?php echo esc_attr($ratio_classes[$image_ratio] ?? 'aspect-square'); ?> overflow-hidden">
            <?php if ($image): ?>
                <img
                    src="<?php echo esc_url($image[0]); ?>"
                    alt="<?php echo esc_attr($term->name); ?>"
                    class="w-full h-full object-cover transition-transform duration-700 <?php echo esc_attr($image_hover); ?>"
                    loading="lazy"
                >
            <?php else: ?>
                <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
            <?php endif; ?>
        </div>

        <div class="p-5">
            <h3 class="text-lg font-bold text-gray-900 group-hover:text-primary-600 transition-colors mb-1">
                <?php echo esc_html($term->name); ?>
            </h3>

            <?php if ($show_count): ?>
                <span class="text-sm text-gray-500"><?php echo esc_html($count_text); ?></span>
            <?php endif; ?>

            <?php if ($show_description && $term->description): ?>
                <p class="mt-2 text-sm text-gray-600 line-clamp-2"><?php echo esc_html($term->description); ?></p>
            <?php endif; ?>
        </div>
    </a>

<?php elseif ($style === 'minimal'): ?>
    <!-- مینیمال -->
    <a
        href="<?php echo esc_url($term_link); ?>"
        class="group flex items-center gap-4 p-4 rounded-xl hover:bg-gray-50 <?php echo esc_attr($hover_classes); ?> transition-all duration-300"
    >
        <div class="flex-shrink-0 w-16 h-16 rounded-xl overflow-hidden">
            <?php if ($image): ?>
                <img
                    src="<?php echo esc_url($image[0]); ?>"
                    alt="<?php echo esc_attr($term->name); ?>"
                    class="w-full h-full object-cover"
                    loading="lazy"
                >
            <?php else: ?>
                <div class="w-full h-full bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                    <span class="text-primary-600 font-bold text-xl"><?php echo mb_substr($term->name, 0, 1); ?></span>
                </div>
            <?php endif; ?>
        </div>

        <div class="flex-1 min-w-0">
            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-primary-600 transition-colors">
                <?php echo esc_html($term->name); ?>
            </h3>
            <?php if ($show_count): ?>
                <span class="text-sm text-gray-500"><?php echo esc_html($count_text); ?></span>
            <?php endif; ?>
        </div>

        <svg class="w-5 h-5 text-gray-400 group-hover:text-primary-600 rtl:rotate-180 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </a>

<?php elseif ($style === 'circle'): ?>
    <!-- دایره‌ای -->
    <a
        href="<?php echo esc_url($term_link); ?>"
        class="group block text-center <?php echo esc_attr($hover_classes); ?> transition-all duration-500"
    >
        <div class="mx-auto w-24 h-24 md:w-32 md:h-32 rounded-full overflow-hidden ring-4 ring-transparent group-hover:ring-primary-300 transition-all duration-300 mb-4">
            <?php if ($image): ?>
                <img
                    src="<?php echo esc_url($image[0]); ?>"
                    alt="<?php echo esc_attr($term->name); ?>"
                    class="w-full h-full object-cover transition-transform duration-700 <?php echo esc_attr($image_hover); ?>"
                    loading="lazy"
                >
            <?php else: ?>
                <div class="w-full h-full bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center">
                    <span class="text-white font-bold text-3xl"><?php echo mb_substr($term->name, 0, 1); ?></span>
                </div>
            <?php endif; ?>
        </div>

        <h3 class="text-lg font-bold text-gray-900 group-hover:text-primary-600 transition-colors mb-1">
            <?php echo esc_html($term->name); ?>
        </h3>

        <?php if ($show_count): ?>
            <span class="text-sm text-gray-500"><?php echo esc_html($count_text); ?></span>
        <?php endif; ?>
    </a>
<?php endif; ?>
