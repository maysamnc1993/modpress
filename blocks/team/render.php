<?php
/**
 * Team Members Block
 *
 * @package Developer_Starter
 */

// فیلدها
$title = get_field('title') ?: '';
$subtitle = get_field('subtitle') ?: '';
$members = get_field('members') ?: [];
$columns = get_field('columns') ?: '4';
$style = get_field('style') ?: 'cards';
$bg_color = get_field('bg_color') ?: '#ffffff';

// نمونه داده
if (empty($members)) {
    $members = [
        ['name' => 'علی محمدی', 'role' => 'مدیرعامل', 'bio' => 'بیش از ۱۰ سال تجربه در مدیریت'],
        ['name' => 'سارا احمدی', 'role' => 'مدیر فنی', 'bio' => 'متخصص در توسعه نرم‌افزار'],
        ['name' => 'محمد رضایی', 'role' => 'طراح ارشد', 'bio' => 'طراح UI/UX حرفه‌ای'],
        ['name' => 'زهرا کریمی', 'role' => 'مدیر مارکتینگ', 'bio' => 'استراتژیست دیجیتال مارکتینگ'],
    ];
}

$col_classes = [
    '2' => 'md:grid-cols-2',
    '3' => 'md:grid-cols-3',
    '4' => 'md:grid-cols-2 lg:grid-cols-4',
];

$block_id = dst_block_id($block, 'team');
?>

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="dst-block dst-team py-16 lg:py-24"
    style="background-color: <?php echo esc_attr($bg_color); ?>;"
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

        <div class="grid gap-8 <?php echo esc_attr($col_classes[$columns] ?? 'lg:grid-cols-4'); ?>">
            <?php foreach ($members as $index => $member): ?>
                <div
                    class="group <?php echo $style === 'cards' ? 'bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl' : ''; ?> transition-all duration-300"
                    x-data="{ shown: false }"
                    x-intersect:enter="shown = true"
                    x-show="shown"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 translate-y-8"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    style="transition-delay: <?php echo $index * 100; ?>ms;"
                >
                    <!-- تصویر -->
                    <div class="relative overflow-hidden aspect-[4/5]">
                        <?php if (!empty($member['image'])): ?>
                            <img
                                src="<?php echo esc_url($member['image']['url']); ?>"
                                alt="<?php echo esc_attr($member['name']); ?>"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                            >
                        <?php else: ?>
                            <div class="w-full h-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center">
                                <span class="text-6xl text-white font-bold"><?php echo mb_substr($member['name'], 0, 1); ?></span>
                            </div>
                        <?php endif; ?>

                        <!-- شبکه‌های اجتماعی -->
                        <?php if (!empty($member['social'])): ?>
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-center pb-6">
                                <div class="flex gap-3">
                                    <?php if (!empty($member['social']['linkedin'])): ?>
                                        <a href="<?php echo esc_url($member['social']['linkedin']); ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white hover:bg-white hover:text-gray-900 transition-colors">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($member['social']['twitter'])): ?>
                                        <a href="<?php echo esc_url($member['social']['twitter']); ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white hover:bg-white hover:text-gray-900 transition-colors">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($member['social']['instagram'])): ?>
                                        <a href="<?php echo esc_url($member['social']['instagram']); ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white hover:bg-white hover:text-gray-900 transition-colors">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- اطلاعات -->
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold text-gray-900 mb-1"><?php echo esc_html($member['name']); ?></h3>
                        <?php if (!empty($member['role'])): ?>
                            <p class="text-primary-600 font-medium mb-2"><?php echo esc_html($member['role']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($member['bio'])): ?>
                            <p class="text-gray-600 text-sm"><?php echo esc_html($member['bio']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php
// ثبت فیلدها
add_action('acf/init', function() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key' => 'group_block_team',
        'title' => 'تنظیمات تیم',
        'fields' => [
            [
                'key' => 'field_team_title',
                'label' => 'عنوان',
                'name' => 'title',
                'type' => 'text',
            ],
            [
                'key' => 'field_team_subtitle',
                'label' => 'زیرعنوان',
                'name' => 'subtitle',
                'type' => 'text',
            ],
            [
                'key' => 'field_team_members',
                'label' => 'اعضا',
                'name' => 'members',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'افزودن عضو',
                'sub_fields' => [
                    [
                        'key' => 'field_member_image',
                        'label' => 'تصویر',
                        'name' => 'image',
                        'type' => 'image',
                        'return_format' => 'array',
                        'wrapper' => ['width' => '25'],
                    ],
                    [
                        'key' => 'field_member_name',
                        'label' => 'نام',
                        'name' => 'name',
                        'type' => 'text',
                        'required' => 1,
                        'wrapper' => ['width' => '25'],
                    ],
                    [
                        'key' => 'field_member_role',
                        'label' => 'سمت',
                        'name' => 'role',
                        'type' => 'text',
                        'wrapper' => ['width' => '25'],
                    ],
                    [
                        'key' => 'field_member_bio',
                        'label' => 'بیوگرافی کوتاه',
                        'name' => 'bio',
                        'type' => 'text',
                        'wrapper' => ['width' => '25'],
                    ],
                    [
                        'key' => 'field_member_social',
                        'label' => 'شبکه‌های اجتماعی',
                        'name' => 'social',
                        'type' => 'group',
                        'layout' => 'table',
                        'sub_fields' => [
                            [
                                'key' => 'field_member_linkedin',
                                'label' => 'LinkedIn',
                                'name' => 'linkedin',
                                'type' => 'url',
                            ],
                            [
                                'key' => 'field_member_twitter',
                                'label' => 'Twitter',
                                'name' => 'twitter',
                                'type' => 'url',
                            ],
                            [
                                'key' => 'field_member_instagram',
                                'label' => 'Instagram',
                                'name' => 'instagram',
                                'type' => 'url',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'key' => 'field_team_columns',
                'label' => 'تعداد ستون',
                'name' => 'columns',
                'type' => 'select',
                'choices' => [
                    '2' => '۲ ستون',
                    '3' => '۳ ستون',
                    '4' => '۴ ستون',
                ],
                'default_value' => '4',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_team_style',
                'label' => 'استایل',
                'name' => 'style',
                'type' => 'select',
                'choices' => [
                    'cards' => 'کارتی',
                    'simple' => 'ساده',
                ],
                'default_value' => 'cards',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_team_bg',
                'label' => 'رنگ پس‌زمینه',
                'name' => 'bg_color',
                'type' => 'color_picker',
                'default_value' => '#ffffff',
            ],
        ],
        'location' => [
            [['param' => 'block', 'operator' => '==', 'value' => 'acf/team']],
        ],
    ]);
});
?>
