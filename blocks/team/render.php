<?php
/**
 * Team Block - تیم ما
 */

$title = get_field('title') ?: 'تیم ما';
$subtitle = get_field('subtitle') ?: '';
$description = get_field('description') ?: '';
$members = get_field('members') ?: [];
$columns = get_field('columns') ?: 4;
$style = get_field('style') ?: 'card';
$bg_color = get_field('bg_color') ?: '#ffffff';

$block_id = dst_block_id($block, 'team');
?>

<section id="<?php echo esc_attr($block_id); ?>" class="dst-block dst-team py-16 lg:py-24" style="background-color: <?php echo esc_attr($bg_color); ?>;">
    <div class="container mx-auto px-4">
        <!-- عنوان -->
        <?php if ($title || $subtitle || $description): ?>
            <div class="text-center mb-12 max-w-3xl mx-auto">
                <?php if ($subtitle): ?><p class="text-primary-600 font-semibold mb-2"><?php echo esc_html($subtitle); ?></p><?php endif; ?>
                <?php if ($title): ?><h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4"><?php echo esc_html($title); ?></h2><?php endif; ?>
                <?php if ($description): ?><p class="text-gray-600 text-lg"><?php echo esc_html($description); ?></p><?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($members): ?>
            <div class="grid gap-8 <?php
                echo $columns == 2 ? 'md:grid-cols-2' : '';
                echo $columns == 3 ? 'md:grid-cols-2 lg:grid-cols-3' : '';
                echo $columns == 4 ? 'md:grid-cols-2 lg:grid-cols-4' : '';
            ?>">
                <?php foreach ($members as $member): ?>
                    <div class="group" x-data="{ shown: false }" x-intersect:enter="shown = true">
                        <div x-show="shown" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">

                            <?php if ($style === 'card'): ?>
                                <!-- استایل کارت -->
                                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                                    <div class="aspect-square overflow-hidden">
                                        <?php if (!empty($member['image'])): ?>
                                            <img src="<?php echo esc_url($member['image']['url']); ?>" alt="<?php echo esc_attr($member['name']); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        <?php else: ?>
                                            <div class="w-full h-full bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                                                <svg class="w-20 h-20 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="p-6 text-center">
                                        <h3 class="font-bold text-lg text-gray-900 mb-1"><?php echo esc_html($member['name']); ?></h3>
                                        <?php if (!empty($member['position'])): ?>
                                            <p class="text-primary-600 text-sm mb-3"><?php echo esc_html($member['position']); ?></p>
                                        <?php endif; ?>
                                        <?php if (!empty($member['bio'])): ?>
                                            <p class="text-gray-500 text-sm mb-4"><?php echo esc_html($member['bio']); ?></p>
                                        <?php endif; ?>

                                        <!-- شبکه‌های اجتماعی -->
                                        <?php if (!empty($member['social'])): ?>
                                            <div class="flex justify-center gap-3">
                                                <?php foreach ($member['social'] as $social): ?>
                                                    <a href="<?php echo esc_url($social['url']); ?>" target="_blank" rel="noopener" class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-primary-600 hover:text-white transition-colors">
                                                        <?php echo dst_get_social_icon($social['network']); ?>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            <?php elseif ($style === 'overlay'): ?>
                                <!-- استایل اورلی -->
                                <div class="relative aspect-[3/4] rounded-2xl overflow-hidden">
                                    <?php if (!empty($member['image'])): ?>
                                        <img src="<?php echo esc_url($member['image']['url']); ?>" alt="<?php echo esc_attr($member['name']); ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="w-full h-full bg-gradient-to-br from-primary-400 to-primary-600"></div>
                                    <?php endif; ?>
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end p-6 text-white">
                                        <h3 class="font-bold text-xl mb-1"><?php echo esc_html($member['name']); ?></h3>
                                        <?php if (!empty($member['position'])): ?>
                                            <p class="text-white/80 text-sm mb-3"><?php echo esc_html($member['position']); ?></p>
                                        <?php endif; ?>

                                        <?php if (!empty($member['social'])): ?>
                                            <div class="flex gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <?php foreach ($member['social'] as $social): ?>
                                                    <a href="<?php echo esc_url($social['url']); ?>" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-white/20 backdrop-blur flex items-center justify-center text-white hover:bg-white hover:text-gray-900 transition-colors">
                                                        <?php echo dst_get_social_icon($social['network']); ?>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            <?php else: ?>
                                <!-- استایل ساده -->
                                <div class="text-center">
                                    <div class="w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden">
                                        <?php if (!empty($member['image'])): ?>
                                            <img src="<?php echo esc_url($member['image']['url']); ?>" alt="<?php echo esc_attr($member['name']); ?>" class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <div class="w-full h-full bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                                                <svg class="w-12 h-12 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <h3 class="font-bold text-lg text-gray-900 mb-1"><?php echo esc_html($member['name']); ?></h3>
                                    <?php if (!empty($member['position'])): ?>
                                        <p class="text-primary-600 text-sm mb-3"><?php echo esc_html($member['position']); ?></p>
                                    <?php endif; ?>

                                    <?php if (!empty($member['social'])): ?>
                                        <div class="flex justify-center gap-3">
                                            <?php foreach ($member['social'] as $social): ?>
                                                <a href="<?php echo esc_url($social['url']); ?>" target="_blank" rel="noopener" class="text-gray-400 hover:text-primary-600 transition-colors">
                                                    <?php echo dst_get_social_icon($social['network']); ?>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
// تابع کمکی برای آیکون شبکه‌های اجتماعی
if (!function_exists('dst_get_social_icon')) {
    function dst_get_social_icon($network) {
        $icons = [
            'instagram' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>',
            'telegram' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>',
            'twitter' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
            'linkedin' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
            'whatsapp' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>',
            'facebook' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
            'youtube' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
        ];
        return $icons[$network] ?? '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>';
    }
}

add_action('acf/init', function() {
    if (!function_exists('acf_add_local_field_group')) return;
    acf_add_local_field_group([
        'key' => 'group_block_team', 'title' => 'تنظیمات تیم ما',
        'fields' => [
            ['key' => 'field_team_title', 'label' => 'عنوان', 'name' => 'title', 'type' => 'text', 'default_value' => 'تیم ما'],
            ['key' => 'field_team_subtitle', 'label' => 'زیرعنوان', 'name' => 'subtitle', 'type' => 'text'],
            ['key' => 'field_team_desc', 'label' => 'توضیحات', 'name' => 'description', 'type' => 'textarea', 'rows' => 2],
            ['key' => 'field_team_style', 'label' => 'استایل', 'name' => 'style', 'type' => 'button_group', 'choices' => ['card' => 'کارت', 'overlay' => 'اورلی', 'simple' => 'ساده'], 'default_value' => 'card'],
            ['key' => 'field_team_columns', 'label' => 'تعداد ستون', 'name' => 'columns', 'type' => 'button_group', 'choices' => [2 => '۲', 3 => '۳', 4 => '۴'], 'default_value' => 4],
            ['key' => 'field_team_members', 'label' => 'اعضای تیم', 'name' => 'members', 'type' => 'repeater', 'layout' => 'block', 'button_label' => 'افزودن عضو', 'sub_fields' => [
                ['key' => 'field_team_member_name', 'label' => 'نام', 'name' => 'name', 'type' => 'text', 'wrapper' => ['width' => '50']],
                ['key' => 'field_team_member_position', 'label' => 'سمت', 'name' => 'position', 'type' => 'text', 'wrapper' => ['width' => '50']],
                ['key' => 'field_team_member_image', 'label' => 'تصویر', 'name' => 'image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium', 'wrapper' => ['width' => '30']],
                ['key' => 'field_team_member_bio', 'label' => 'بیوگرافی', 'name' => 'bio', 'type' => 'textarea', 'rows' => 2, 'wrapper' => ['width' => '70']],
                ['key' => 'field_team_member_social', 'label' => 'شبکه‌های اجتماعی', 'name' => 'social', 'type' => 'repeater', 'layout' => 'table', 'button_label' => 'افزودن', 'sub_fields' => [
                    ['key' => 'field_team_social_network', 'label' => 'شبکه', 'name' => 'network', 'type' => 'select', 'choices' => ['instagram' => 'اینستاگرام', 'telegram' => 'تلگرام', 'twitter' => 'توییتر', 'linkedin' => 'لینکدین', 'whatsapp' => 'واتساپ', 'facebook' => 'فیسبوک', 'youtube' => 'یوتیوب']],
                    ['key' => 'field_team_social_url', 'label' => 'لینک', 'name' => 'url', 'type' => 'url'],
                ]],
            ]],
            ['key' => 'field_team_bg', 'label' => 'رنگ پس‌زمینه', 'name' => 'bg_color', 'type' => 'color_picker', 'default_value' => '#ffffff'],
        ],
        'location' => [[['param' => 'block', 'operator' => '==', 'value' => 'acf/team']]],
    ]);
});
?>
