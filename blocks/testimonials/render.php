<?php
/**
 * Testimonials Block - نظرات مشتریان
 */

$title = get_field('title') ?: 'نظرات مشتریان';
$subtitle = get_field('subtitle') ?: '';
$testimonials = get_field('testimonials') ?: [];
$layout = get_field('layout') ?: 'slider';
$columns = get_field('columns') ?: 3;
$show_rating = get_field('show_rating') !== false;
$bg_color = get_field('bg_color') ?: '#f8fafc';
$autoplay = get_field('autoplay') !== false;
$autoplay_speed = get_field('autoplay_speed') ?: 5000;

$block_id = dst_block_id($block, 'testimonials');
?>

<section id="<?php echo esc_attr($block_id); ?>" class="dst-block dst-testimonials py-16 lg:py-24" style="background-color: <?php echo esc_attr($bg_color); ?>;">
    <div class="container mx-auto px-4">
        <!-- عنوان -->
        <?php if ($title || $subtitle): ?>
            <div class="text-center mb-12">
                <?php if ($subtitle): ?><p class="text-primary-600 font-semibold mb-2"><?php echo esc_html($subtitle); ?></p><?php endif; ?>
                <?php if ($title): ?><h2 class="text-3xl md:text-4xl font-bold text-gray-900"><?php echo esc_html($title); ?></h2><?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($testimonials): ?>
            <?php if ($layout === 'slider'): ?>
                <!-- اسلایدر -->
                <div x-data="{
                    active: 0,
                    total: <?php echo count($testimonials); ?>,
                    autoplay: <?php echo $autoplay ? 'true' : 'false'; ?>,
                    interval: null,
                    startAutoplay() {
                        if (this.autoplay) {
                            this.interval = setInterval(() => this.next(), <?php echo intval($autoplay_speed); ?>);
                        }
                    },
                    stopAutoplay() {
                        if (this.interval) clearInterval(this.interval);
                    },
                    next() {
                        this.active = (this.active + 1) % this.total;
                    },
                    prev() {
                        this.active = (this.active - 1 + this.total) % this.total;
                    }
                }" x-init="startAutoplay()" @mouseenter="stopAutoplay()" @mouseleave="startAutoplay()" class="relative">
                    <div class="overflow-hidden">
                        <div class="flex transition-transform duration-500" :style="'transform: translateX(' + (active * 100) + '%)'">
                            <?php foreach ($testimonials as $index => $item): ?>
                                <div class="w-full flex-shrink-0 px-4">
                                    <div class="bg-white rounded-2xl shadow-lg p-8 max-w-3xl mx-auto">
                                        <!-- ستاره‌ها -->
                                        <?php if ($show_rating && !empty($item['rating'])): ?>
                                            <div class="flex gap-1 mb-4 justify-center">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <svg class="w-5 h-5 <?php echo $i <= $item['rating'] ? 'text-yellow-400' : 'text-gray-300'; ?>" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                <?php endfor; ?>
                                            </div>
                                        <?php endif; ?>

                                        <!-- متن نظر -->
                                        <blockquote class="text-lg md:text-xl text-gray-700 text-center mb-6 leading-relaxed">
                                            "<?php echo esc_html($item['content']); ?>"
                                        </blockquote>

                                        <!-- اطلاعات کاربر -->
                                        <div class="flex items-center justify-center gap-4">
                                            <?php if (!empty($item['image'])): ?>
                                                <img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo esc_attr($item['name']); ?>" class="w-14 h-14 rounded-full object-cover">
                                            <?php else: ?>
                                                <div class="w-14 h-14 rounded-full bg-primary-100 flex items-center justify-center">
                                                    <span class="text-primary-600 font-bold text-xl"><?php echo mb_substr($item['name'], 0, 1); ?></span>
                                                </div>
                                            <?php endif; ?>
                                            <div class="text-center">
                                                <div class="font-semibold text-gray-900"><?php echo esc_html($item['name']); ?></div>
                                                <?php if (!empty($item['position'])): ?>
                                                    <div class="text-sm text-gray-500"><?php echo esc_html($item['position']); ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- کنترل‌ها -->
                    <?php if (count($testimonials) > 1): ?>
                        <button @click="prev()" class="absolute right-0 top-1/2 -translate-y-1/2 -translate-x-4 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-600 hover:text-primary-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                        <button @click="next()" class="absolute left-0 top-1/2 -translate-y-1/2 translate-x-4 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-600 hover:text-primary-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </button>

                        <!-- نقاط -->
                        <div class="flex justify-center gap-2 mt-8">
                            <?php foreach ($testimonials as $index => $item): ?>
                                <button @click="active = <?php echo $index; ?>" class="w-3 h-3 rounded-full transition-colors" :class="active === <?php echo $index; ?> ? 'bg-primary-600' : 'bg-gray-300'"></button>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <!-- گرید -->
                <div class="grid gap-6 <?php
                    echo $columns == 2 ? 'md:grid-cols-2' : '';
                    echo $columns == 3 ? 'md:grid-cols-2 lg:grid-cols-3' : '';
                    echo $columns == 4 ? 'md:grid-cols-2 lg:grid-cols-4' : '';
                ?>">
                    <?php foreach ($testimonials as $item): ?>
                        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow" x-data="{ shown: false }" x-intersect:enter="shown = true">
                            <div x-show="shown" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                                <!-- ستاره‌ها -->
                                <?php if ($show_rating && !empty($item['rating'])): ?>
                                    <div class="flex gap-1 mb-4">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <svg class="w-4 h-4 <?php echo $i <= $item['rating'] ? 'text-yellow-400' : 'text-gray-300'; ?>" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        <?php endfor; ?>
                                    </div>
                                <?php endif; ?>

                                <!-- متن نظر -->
                                <blockquote class="text-gray-600 mb-6 leading-relaxed">
                                    "<?php echo esc_html($item['content']); ?>"
                                </blockquote>

                                <!-- اطلاعات کاربر -->
                                <div class="flex items-center gap-3 border-t pt-4">
                                    <?php if (!empty($item['image'])): ?>
                                        <img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo esc_attr($item['name']); ?>" class="w-12 h-12 rounded-full object-cover">
                                    <?php else: ?>
                                        <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center">
                                            <span class="text-primary-600 font-bold"><?php echo mb_substr($item['name'], 0, 1); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <div class="font-semibold text-gray-900"><?php echo esc_html($item['name']); ?></div>
                                        <?php if (!empty($item['position'])): ?>
                                            <div class="text-sm text-gray-500"><?php echo esc_html($item['position']); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<?php
add_action('acf/init', function() {
    if (!function_exists('acf_add_local_field_group')) return;
    acf_add_local_field_group([
        'key' => 'group_block_testimonials', 'title' => 'تنظیمات نظرات مشتریان',
        'fields' => [
            ['key' => 'field_testimonials_title', 'label' => 'عنوان', 'name' => 'title', 'type' => 'text', 'default_value' => 'نظرات مشتریان'],
            ['key' => 'field_testimonials_subtitle', 'label' => 'زیرعنوان', 'name' => 'subtitle', 'type' => 'text'],
            ['key' => 'field_testimonials_layout', 'label' => 'نوع نمایش', 'name' => 'layout', 'type' => 'button_group', 'choices' => ['slider' => 'اسلایدر', 'grid' => 'گرید'], 'default_value' => 'slider'],
            ['key' => 'field_testimonials_columns', 'label' => 'تعداد ستون', 'name' => 'columns', 'type' => 'button_group', 'choices' => [2 => '۲', 3 => '۳', 4 => '۴'], 'default_value' => 3, 'conditional_logic' => [[['field' => 'field_testimonials_layout', 'operator' => '==', 'value' => 'grid']]]],
            ['key' => 'field_testimonials_rating', 'label' => 'نمایش امتیاز', 'name' => 'show_rating', 'type' => 'true_false', 'default_value' => 1, 'ui' => 1],
            ['key' => 'field_testimonials_autoplay', 'label' => 'پخش خودکار', 'name' => 'autoplay', 'type' => 'true_false', 'default_value' => 1, 'ui' => 1, 'conditional_logic' => [[['field' => 'field_testimonials_layout', 'operator' => '==', 'value' => 'slider']]]],
            ['key' => 'field_testimonials_speed', 'label' => 'سرعت (میلی‌ثانیه)', 'name' => 'autoplay_speed', 'type' => 'number', 'default_value' => 5000, 'conditional_logic' => [[['field' => 'field_testimonials_autoplay', 'operator' => '==', 'value' => 1]]]],
            ['key' => 'field_testimonials_items', 'label' => 'نظرات', 'name' => 'testimonials', 'type' => 'repeater', 'layout' => 'block', 'button_label' => 'افزودن نظر', 'sub_fields' => [
                ['key' => 'field_testimonials_name', 'label' => 'نام', 'name' => 'name', 'type' => 'text', 'wrapper' => ['width' => '50']],
                ['key' => 'field_testimonials_position', 'label' => 'سمت / شرکت', 'name' => 'position', 'type' => 'text', 'wrapper' => ['width' => '50']],
                ['key' => 'field_testimonials_image', 'label' => 'تصویر', 'name' => 'image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'thumbnail', 'wrapper' => ['width' => '30']],
                ['key' => 'field_testimonials_rating_val', 'label' => 'امتیاز', 'name' => 'rating', 'type' => 'range', 'min' => 1, 'max' => 5, 'default_value' => 5, 'wrapper' => ['width' => '20']],
                ['key' => 'field_testimonials_content', 'label' => 'متن نظر', 'name' => 'content', 'type' => 'textarea', 'rows' => 3, 'wrapper' => ['width' => '50']],
            ]],
            ['key' => 'field_testimonials_bg', 'label' => 'رنگ پس‌زمینه', 'name' => 'bg_color', 'type' => 'color_picker', 'default_value' => '#f8fafc'],
        ],
        'location' => [[['param' => 'block', 'operator' => '==', 'value' => 'acf/testimonials']]],
    ]);
});
?>
