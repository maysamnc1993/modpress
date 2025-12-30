<?php
/**
 * FAQ Accordion Block
 *
 * @package Developer_Starter
 */

// فیلدها
$title = get_field('title') ?: '';
$subtitle = get_field('subtitle') ?: '';
$faqs = get_field('faqs') ?: [];
$layout = get_field('layout') ?: 'single';
$style = get_field('style') ?: 'bordered';
$bg_color = get_field('bg_color') ?: '#ffffff';
$allow_multiple = get_field('allow_multiple') ?: false;

// نمونه داده
if (empty($faqs)) {
    $faqs = [
        ['question' => 'چگونه می‌توانم ثبت‌نام کنم؟', 'answer' => 'برای ثبت‌نام کافی است روی دکمه ثبت‌نام کلیک کرده و فرم را تکمیل کنید.'],
        ['question' => 'آیا امکان استرداد وجه وجود دارد؟', 'answer' => 'بله، تا ۷ روز پس از خرید امکان استرداد کامل وجه وجود دارد.'],
        ['question' => 'پشتیبانی چگونه انجام می‌شود؟', 'answer' => 'پشتیبانی ۲۴ ساعته از طریق تیکت، ایمیل و چت آنلاین در دسترس است.'],
        ['question' => 'آیا نسخه آزمایشی رایگان دارید؟', 'answer' => 'بله، ۱۴ روز نسخه آزمایشی رایگان با تمام امکانات در دسترس است.'],
    ];
}

$block_id = dst_block_id($block, 'faq');
?>

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="dst-block dst-faq py-16 lg:py-24"
    style="background-color: <?php echo esc_attr($bg_color); ?>;"
    x-data="{ active: <?php echo $allow_multiple ? '[]' : 'null'; ?> }"
>
    <div class="container mx-auto px-4">
        <?php if ($title || $subtitle): ?>
            <div class="text-center max-w-3xl mx-auto mb-12">
                <?php if ($subtitle): ?>
                    <p class="text-primary-600 font-semibold mb-2"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>
                <?php if ($title): ?>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($layout === 'two-column'): ?>
            <div class="grid md:grid-cols-2 gap-6">
                <?php
                $half = ceil(count($faqs) / 2);
                $columns = array_chunk($faqs, $half);
                foreach ($columns as $col_index => $column):
                ?>
                    <div class="space-y-4">
                        <?php foreach ($column as $index => $faq):
                            $real_index = $col_index * $half + $index;
                            ?>
                            <?php include __DIR__ . '/faq-item.php'; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="max-w-3xl mx-auto space-y-4">
                <?php foreach ($faqs as $index => $faq):
                    $real_index = $index;
                    ?>
                    <?php
                    $is_open = $allow_multiple
                        ? "active.includes($real_index)"
                        : "active === $real_index";
                    $toggle = $allow_multiple
                        ? "active.includes($real_index) ? active = active.filter(i => i !== $real_index) : active.push($real_index)"
                        : "active = active === $real_index ? null : $real_index";
                    ?>
                    <div
                        class="<?php
                        echo $style === 'bordered'
                            ? 'border border-gray-200 rounded-xl'
                            : ($style === 'shadow' ? 'bg-white rounded-xl shadow-md' : '');
                        ?> overflow-hidden transition-all duration-300"
                        :class="{ 'border-primary-300 shadow-lg': <?php echo $is_open; ?> }"
                    >
                        <button
                            @click="<?php echo $toggle; ?>"
                            class="w-full flex items-center justify-between gap-4 p-5 text-right hover:bg-gray-50 transition-colors"
                        >
                            <span class="font-semibold text-gray-900"><?php echo esc_html($faq['question']); ?></span>
                            <span
                                class="flex-shrink-0 w-8 h-8 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center transition-transform duration-300"
                                :class="{ 'rotate-180 bg-primary-600 text-white': <?php echo $is_open; ?> }"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </span>
                        </button>

                        <div
                            x-show="<?php echo $is_open; ?>"
                            x-collapse
                            x-cloak
                        >
                            <div class="px-5 pb-5 text-gray-600 leading-relaxed">
                                <?php echo wp_kses_post($faq['answer']); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
// ثبت فیلدها
add_action('acf/init', function() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key' => 'group_block_faq',
        'title' => 'تنظیمات سوالات',
        'fields' => [
            [
                'key' => 'field_faq_title',
                'label' => 'عنوان',
                'name' => 'title',
                'type' => 'text',
            ],
            [
                'key' => 'field_faq_subtitle',
                'label' => 'زیرعنوان',
                'name' => 'subtitle',
                'type' => 'text',
            ],
            [
                'key' => 'field_faq_items',
                'label' => 'سوالات',
                'name' => 'faqs',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'افزودن سوال',
                'sub_fields' => [
                    [
                        'key' => 'field_faq_question',
                        'label' => 'سوال',
                        'name' => 'question',
                        'type' => 'text',
                        'required' => 1,
                    ],
                    [
                        'key' => 'field_faq_answer',
                        'label' => 'پاسخ',
                        'name' => 'answer',
                        'type' => 'wysiwyg',
                        'toolbar' => 'basic',
                        'media_upload' => 0,
                    ],
                ],
            ],
            [
                'key' => 'field_faq_layout',
                'label' => 'چیدمان',
                'name' => 'layout',
                'type' => 'select',
                'choices' => [
                    'single' => 'تک ستون',
                    'two-column' => 'دو ستون',
                ],
                'default_value' => 'single',
                'wrapper' => ['width' => '33'],
            ],
            [
                'key' => 'field_faq_style',
                'label' => 'استایل',
                'name' => 'style',
                'type' => 'select',
                'choices' => [
                    'bordered' => 'حاشیه‌دار',
                    'shadow' => 'سایه‌دار',
                    'simple' => 'ساده',
                ],
                'default_value' => 'bordered',
                'wrapper' => ['width' => '33'],
            ],
            [
                'key' => 'field_faq_multiple',
                'label' => 'باز شدن همزمان',
                'name' => 'allow_multiple',
                'type' => 'true_false',
                'message' => 'اجازه باز بودن چند سوال همزمان',
                'wrapper' => ['width' => '34'],
            ],
            [
                'key' => 'field_faq_bg',
                'label' => 'رنگ پس‌زمینه',
                'name' => 'bg_color',
                'type' => 'color_picker',
                'default_value' => '#ffffff',
            ],
        ],
        'location' => [
            [['param' => 'block', 'operator' => '==', 'value' => 'acf/faq']],
        ],
    ]);
});
?>
