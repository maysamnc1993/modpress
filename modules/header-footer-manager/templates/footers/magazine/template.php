<?php
/**
 * Footer Template: Magazine
 * فوتر مجله‌ای با آخرین مطالب و دسته‌بندی‌ها
 */

defined('ABSPATH') || exit;

$settings = dst_get_footer_setting();
$bg_color = $settings['bg_color'] ?? '#0f172a';
$text_color = $settings['text_color'] ?? '#ffffff';
$link_color = $settings['link_color'] ?? '#94a3b8';
$link_hover_color = $settings['link_hover_color'] ?? '#f59e0b';
$show_logo = $settings['show_logo'] ?? true;
$show_description = $settings['show_description'] ?? true;
$description_text = $settings['description_text'] ?? 'منبع خبری معتبر با پوشش جامع رویدادها، تحلیل‌های عمیق و گزارش‌های ویژه.';
$show_social = $settings['show_social'] ?? true;
$show_newsletter = $settings['show_newsletter'] ?? true;
$newsletter_title = $settings['newsletter_title'] ?? 'خبرنامه روزانه';
$newsletter_text = $settings['newsletter_text'] ?? 'اخبار مهم روز را مستقیماً در ایمیل خود دریافت کنید';
$show_contact = $settings['show_contact'] ?? true;
$columns = $settings['columns'] ?? '4';
$show_menu1 = $settings['show_menu1'] ?? true;
$menu1_title = $settings['menu1_title'] ?? 'دسته‌بندی‌ها';
$show_menu2 = $settings['show_menu2'] ?? true;
$menu2_title = $settings['menu2_title'] ?? 'بخش‌های سایت';
$show_copyright = $settings['show_copyright'] ?? true;
$copyright_text = $settings['copyright_text'] ?? 'تمامی حقوق محفوظ است';
$show_payment_icons = $settings['show_payment_icons'] ?? false;
$show_back_to_top = $settings['show_back_to_top'] ?? true;
$show_latest_posts = $settings['show_latest_posts'] ?? true;
$latest_posts_title = $settings['latest_posts_title'] ?? 'تازه‌ترین مطالب';
$latest_posts_count = $settings['latest_posts_count'] ?? '4';
$show_popular_categories = $settings['show_popular_categories'] ?? true;
$popular_categories_title = $settings['popular_categories_title'] ?? 'موضوعات پرطرفدار';
$show_authors = $settings['show_authors'] ?? true;
$authors_title = $settings['authors_title'] ?? 'نویسندگان ما';
$accent_color = $settings['accent_color'] ?? '#f59e0b';
?>

<footer
    class="hf-footer hf-footer-magazine"
    style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;"
    dir="rtl"
>
    <style>
        .hf-footer-magazine a {
            color: <?php echo esc_attr($link_color); ?>;
            transition: color 0.3s ease;
        }
        .hf-footer-magazine a:hover {
            color: <?php echo esc_attr($link_hover_color); ?>;
        }
        .hf-accent-border {
            border-color: <?php echo esc_attr($accent_color); ?>;
        }
        .hf-accent-bg {
            background-color: <?php echo esc_attr($accent_color); ?>;
        }
    </style>

    <!-- Newsletter Bar -->
    <?php if ($show_newsletter): ?>
        <div class="border-b border-white/10">
            <div class="hf-container py-8">
                <div class="max-w-4xl mx-auto text-center">
                    <div class="flex items-center justify-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-full hf-accent-bg flex items-center justify-center">
                            <?php echo dst_get_icon('mail', 'w-6 h-6 text-white'); ?>
                        </div>
                        <h3 class="text-2xl font-bold"><?php echo esc_html($newsletter_title); ?></h3>
                    </div>
                    <p class="text-sm mb-6 opacity-90"><?php echo esc_html($newsletter_text); ?></p>
                    <form class="flex flex-col sm:flex-row gap-3 max-w-xl mx-auto" x-data="newsletter">
                        <input
                            type="email"
                            placeholder="ایمیل شما"
                            class="flex-1 px-6 py-4 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/60 focus:outline-none focus:border-white/40"
                            required
                        />
                        <button
                            type="submit"
                            class="px-8 py-4 hf-accent-bg text-white font-bold rounded-lg hover:opacity-90 transition-opacity"
                        >
                            اشتراک
                        </button>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Footer Content -->
    <div class="hf-container py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-<?php echo esc_attr($columns); ?> gap-8 lg:gap-12">

            <!-- Latest Posts -->
            <?php if ($show_latest_posts): ?>
                <div class="lg:col-span-<?php echo $columns >= 4 ? '1' : '2'; ?>">
                    <h3 class="text-lg font-bold mb-6 pb-3 border-b-2 hf-accent-border">
                        <?php echo esc_html($latest_posts_title); ?>
                    </h3>
                    <div class="space-y-4">
                        <?php
                        $latest_posts = new WP_Query([
                            'posts_per_page' => intval($latest_posts_count),
                            'post_status' => 'publish',
                            'ignore_sticky_posts' => true,
                        ]);

                        if ($latest_posts->have_posts()):
                            while ($latest_posts->have_posts()): $latest_posts->the_post();
                        ?>
                                <article class="flex gap-3 group">
                                    <?php if (has_post_thumbnail()): ?>
                                        <a href="<?php the_permalink(); ?>" class="flex-shrink-0">
                                            <?php the_post_thumbnail('thumbnail', ['class' => 'w-20 h-20 object-cover rounded-lg']); ?>
                                        </a>
                                    <?php endif; ?>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-semibold mb-1 line-clamp-2">
                                            <a href="<?php the_permalink(); ?>" class="hover:text-white">
                                                <?php the_title(); ?>
                                            </a>
                                        </h4>
                                        <div class="flex items-center gap-2 text-xs opacity-70">
                                            <time datetime="<?php echo get_the_date('c'); ?>">
                                                <?php echo get_the_date(); ?>
                                            </time>
                                            <span>•</span>
                                            <span><?php echo get_the_category()[0]->name ?? ''; ?></span>
                                        </div>
                                    </div>
                                </article>
                        <?php
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Popular Categories -->
            <?php if ($show_popular_categories && $show_menu1): ?>
                <div>
                    <h3 class="text-lg font-bold mb-6 pb-3 border-b-2 hf-accent-border">
                        <?php echo esc_html($popular_categories_title); ?>
                    </h3>
                    <?php
                    $categories = get_categories([
                        'orderby' => 'count',
                        'order' => 'DESC',
                        'number' => 8,
                        'hide_empty' => true,
                    ]);

                    if (!empty($categories)):
                    ?>
                        <ul class="space-y-3 text-sm">
                            <?php foreach ($categories as $category): ?>
                                <li class="flex items-center justify-between">
                                    <a href="<?php echo get_category_link($category); ?>" class="hover:text-white flex-1">
                                        <?php echo esc_html($category->name); ?>
                                    </a>
                                    <span class="text-xs opacity-60">(<?php echo $category->count; ?>)</span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Sections Menu -->
            <?php if ($show_menu2): ?>
                <div>
                    <h3 class="text-lg font-bold mb-6 pb-3 border-b-2 hf-accent-border">
                        <?php echo esc_html($menu2_title); ?>
                    </h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="<?php echo home_url('/news'); ?>">اخبار</a></li>
                        <li><a href="<?php echo home_url('/analysis'); ?>">تحلیل و گزارش</a></li>
                        <li><a href="<?php echo home_url('/interviews'); ?>">مصاحبه‌ها</a></li>
                        <li><a href="<?php echo home_url('/opinion'); ?>">یادداشت‌ها</a></li>
                        <li><a href="<?php echo home_url('/multimedia'); ?>">چندرسانه‌ای</a></li>
                        <li><a href="<?php echo home_url('/special'); ?>">گزارش‌های ویژه</a></li>
                        <li><a href="<?php echo home_url('/archive'); ?>">آرشیو</a></li>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- About & Contact -->
            <div>
                <?php if ($show_logo): ?>
                    <div class="mb-6">
                        <?php dst_the_logo('light', 'h-12 w-auto'); ?>
                    </div>
                <?php endif; ?>

                <?php if ($show_description): ?>
                    <p class="mb-6 text-sm leading-relaxed opacity-90">
                        <?php echo esc_html($description_text); ?>
                    </p>
                <?php endif; ?>

                <?php if ($show_authors): ?>
                    <div class="mb-6">
                        <h4 class="text-sm font-bold mb-3"><?php echo esc_html($authors_title); ?></h4>
                        <div class="flex gap-2">
                            <?php
                            $authors = get_users([
                                'orderby' => 'post_count',
                                'order' => 'DESC',
                                'number' => 4,
                                'who' => 'authors',
                            ]);
                            foreach ($authors as $author):
                            ?>
                                <a
                                    href="<?php echo get_author_posts_url($author->ID); ?>"
                                    class="w-10 h-10 rounded-full overflow-hidden border-2 border-white/20 hover:border-white/40 transition-colors"
                                    title="<?php echo esc_attr($author->display_name); ?>"
                                >
                                    <?php echo get_avatar($author->ID, 40); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($show_contact): ?>
                    <div class="space-y-2 text-sm mb-6">
                        <?php if (dst_get_contact('email')): ?>
                            <div class="flex items-center gap-2">
                                <?php echo dst_get_icon('mail', 'w-4 h-4'); ?>
                                <a href="mailto:<?php echo esc_attr(dst_get_contact('email')); ?>">
                                    <?php echo esc_html(dst_get_contact('email')); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php if (dst_get_contact('phone')): ?>
                            <div class="flex items-center gap-2">
                                <?php echo dst_get_icon('phone', 'w-4 h-4'); ?>
                                <a href="tel:<?php echo esc_attr(dst_get_contact('phone')); ?>">
                                    <?php echo esc_html(dst_get_contact('phone')); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ($show_social): ?>
                    <div class="flex gap-3">
                        <?php
                        $social_networks = ['twitter', 'instagram', 'telegram', 'youtube', 'linkedin'];
                        foreach ($social_networks as $network):
                            $url = dst_get_social($network);
                            if (!$url) continue;
                        ?>
                            <a
                                href="<?php echo esc_url($url); ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="w-10 h-10 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 transition-colors"
                                aria-label="<?php echo esc_attr($network); ?>"
                            >
                                <?php echo dst_get_icon($network, 'w-5 h-5'); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="border-t border-white/10">
        <div class="hf-container py-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm">

                <!-- Copyright -->
                <?php if ($show_copyright): ?>
                    <div class="opacity-80 text-center md:text-right">
                        &copy; <?php echo date('Y'); ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="font-semibold">
                            <?php bloginfo('name'); ?>
                        </a>
                        - <?php echo esc_html($copyright_text); ?>
                    </div>
                <?php endif; ?>

                <!-- Legal & Info Links -->
                <div class="flex items-center gap-6">
                    <a href="<?php echo home_url('/about'); ?>">درباره ما</a>
                    <a href="<?php echo home_url('/contact'); ?>">تماس با ما</a>
                    <a href="<?php echo home_url('/advertise'); ?>">تبلیغات</a>
                    <a href="<?php echo home_url('/privacy'); ?>">حریم خصوصی</a>
                    <a href="<?php echo home_url('/rss'); ?>" class="flex items-center gap-1">
                        <?php echo dst_get_icon('rss', 'w-4 h-4'); ?>
                        RSS
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <?php if ($show_back_to_top): ?>
        <button
            @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            x-data
            x-show="window.pageYOffset > 300"
            x-transition
            class="fixed bottom-8 left-8 rtl:left-auto rtl:right-8 w-12 h-12 hf-accent-bg text-white rounded-full shadow-lg hover:shadow-xl transition-all flex items-center justify-center z-50"
            aria-label="بازگشت به بالا"
        >
            <?php echo dst_get_icon('arrow-up', 'w-5 h-5'); ?>
        </button>
    <?php endif; ?>
</footer>
