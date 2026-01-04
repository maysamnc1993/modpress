<?php
/**
 * FAQ Block - سوالات متداول
 */

$title = get_field('title') ?: 'سوالات متداول';
$subtitle = get_field('subtitle') ?: '';
$description = get_field('description') ?: '';
$faqs = get_field('faqs') ?: [];
$style = get_field('style') ?: 'accordion';
$columns = get_field('columns') ?: 1;
$open_first = get_field('open_first') !== false;
$bg_color = get_field('bg_color') ?: '#ffffff';

$block_id = dst_block_id($block, 'faq');
?>

<section id="<?php echo esc_attr($block_id); ?>" class="dst-block dst-faq py-16 lg:py-24" style="background-color: <?php echo esc_attr($bg_color); ?>;">
    <div class="container mx-auto px-4">
        <!-- عنوان -->
        <?php if ($title || $subtitle || $description): ?>
            <div class="text-center mb-12 max-w-3xl mx-auto">
                <?php if ($subtitle): ?><p class="text-primary-600 font-semibold mb-2"><?php echo esc_html($subtitle); ?></p><?php endif; ?>
                <?php if ($title): ?><h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4"><?php echo esc_html($title); ?></h2><?php endif; ?>
                <?php if ($description): ?><p class="text-gray-600 text-lg"><?php echo esc_html($description); ?></p><?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($faqs): ?>
            <?php if ($style === 'accordion'): ?>
                <!-- استایل آکاردئون -->
                <div class="max-w-3xl mx-auto" x-data="{ active: <?php echo $open_first ? '0' : 'null'; ?> }">
                    <?php foreach ($faqs as $index => $faq): ?>
                        <div class="mb-4" x-data="{ shown: false }" x-intersect:enter="shown = true">
                            <div x-show="shown" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="transition-delay: <?php echo $index * 100; ?>ms">
                                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                                    <button @click="active = active === <?php echo $index; ?> ? null : <?php echo $index; ?>" class="w-full flex items-center justify-between p-5 text-right hover:bg-gray-50 transition-colors">
                                        <span class="font-semibold text-gray-900"><?php echo esc_html($faq['question']); ?></span>
                                        <svg class="w-5 h-5 text-gray-500 transition-transform duration-300 flex-shrink-0" :class="active === <?php echo $index; ?> ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    <div x-show="active === <?php echo $index; ?>" x-collapse x-cloak>
                                        <div class="p-5 pt-0 text-gray-600 leading-relaxed border-t border-gray-100">
                                            <?php echo wp_kses_post($faq['answer']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php elseif ($style === 'cards'): ?>
                <!-- استایل کارت‌ها -->
                <div class="grid gap-6 <?php echo $columns == 2 ? 'lg:grid-cols-2' : ''; ?>">
                    <?php foreach ($faqs as $index => $faq): ?>
                        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow" x-data="{ shown: false }" x-intersect:enter="shown = true">
                            <div x-show="shown" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" style="transition-delay: <?php echo $index * 100; ?>ms">
                                <div class="flex items-start gap-4">
                                    <span class="flex-shrink-0 w-10 h-10 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center font-bold">
                                        <?php echo $index + 1; ?>
                                    </span>
                                    <div>
                                        <h3 class="font-semibold text-gray-900 mb-2"><?php echo esc_html($faq['question']); ?></h3>
                                        <div class="text-gray-600 leading-relaxed"><?php echo wp_kses_post($faq['answer']); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php else: ?>
                <!-- استایل ساده -->
                <div class="max-w-3xl mx-auto divide-y divide-gray-200">
                    <?php foreach ($faqs as $index => $faq): ?>
                        <div class="py-6" x-data="{ shown: false }" x-intersect:enter="shown = true">
                            <div x-show="shown" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" style="transition-delay: <?php echo $index * 100; ?>ms">
                                <h3 class="font-semibold text-lg text-gray-900 mb-3 flex items-start gap-3">
                                    <svg class="w-6 h-6 text-primary-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <?php echo esc_html($faq['question']); ?>
                                </h3>
                                <div class="text-gray-600 leading-relaxed pr-9"><?php echo wp_kses_post($faq['answer']); ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Schema.org FAQPage -->
            <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "FAQPage",
                "mainEntity": [
                    <?php
                    $schema_items = [];
                    foreach ($faqs as $faq) {
                        $schema_items[] = '{
                            "@type": "Question",
                            "name": "' . esc_js($faq['question']) . '",
                            "acceptedAnswer": {
                                "@type": "Answer",
                                "text": "' . esc_js(wp_strip_all_tags($faq['answer'])) . '"
                            }
                        }';
                    }
                    echo implode(',', $schema_items);
                    ?>
                ]
            }
            </script>
        <?php endif; ?>
    </div>
</section>

<?php
add_action('acf/init', function() {
    if (!function_exists('acf_add_local_field_group')) return;
    acf_add_local_field_group([
        'key' => 'group_block_faq', 'title' => 'تنظیمات سوالات متداول',
        'fields' => [
            ['key' => 'field_faq_title', 'label' => 'عنوان', 'name' => 'title', 'type' => 'text', 'default_value' => 'سوالات متداول'],
            ['key' => 'field_faq_subtitle', 'label' => 'زیرعنوان', 'name' => 'subtitle', 'type' => 'text'],
            ['key' => 'field_faq_desc', 'label' => 'توضیحات', 'name' => 'description', 'type' => 'textarea', 'rows' => 2],
            ['key' => 'field_faq_style', 'label' => 'استایل', 'name' => 'style', 'type' => 'button_group', 'choices' => ['accordion' => 'آکاردئون', 'cards' => 'کارت', 'simple' => 'ساده'], 'default_value' => 'accordion'],
            ['key' => 'field_faq_columns', 'label' => 'تعداد ستون', 'name' => 'columns', 'type' => 'button_group', 'choices' => [1 => '۱', 2 => '۲'], 'default_value' => 1, 'conditional_logic' => [[['field' => 'field_faq_style', 'operator' => '==', 'value' => 'cards']]]],
            ['key' => 'field_faq_open_first', 'label' => 'باز بودن اولین سوال', 'name' => 'open_first', 'type' => 'true_false', 'default_value' => 1, 'ui' => 1, 'conditional_logic' => [[['field' => 'field_faq_style', 'operator' => '==', 'value' => 'accordion']]]],
            ['key' => 'field_faq_items', 'label' => 'سوالات', 'name' => 'faqs', 'type' => 'repeater', 'layout' => 'block', 'button_label' => 'افزودن سوال', 'sub_fields' => [
                ['key' => 'field_faq_question', 'label' => 'سوال', 'name' => 'question', 'type' => 'text'],
                ['key' => 'field_faq_answer', 'label' => 'پاسخ', 'name' => 'answer', 'type' => 'wysiwyg', 'toolbar' => 'basic', 'media_upload' => 0, 'tabs' => 'visual'],
            ]],
            ['key' => 'field_faq_bg', 'label' => 'رنگ پس‌زمینه', 'name' => 'bg_color', 'type' => 'color_picker', 'default_value' => '#ffffff'],
        ],
        'location' => [[['param' => 'block', 'operator' => '==', 'value' => 'acf/faq']]],
    ]);
});
?>
