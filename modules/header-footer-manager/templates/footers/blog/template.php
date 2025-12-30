<?php
/**
 * Footer Template: Blog & Magazine
 * Blog footer with popular posts, categories, tags cloud, author info, and subscribe section
 */

defined('ABSPATH') || exit;

$settings = dst_get_footer_setting();
$bg_color = $settings['bg_color'] ?? '#1f2937';
$text_color = $settings['text_color'] ?? '#9ca3af';
$link_color = $settings['link_color'] ?? '#f3f4f6';
$link_hover_color = $settings['link_hover_color'] ?? '#f59e0b';
$show_logo = $settings['show_logo'] ?? true;
$show_description = $settings['show_description'] ?? true;
$description_text = $settings['description_text'] ?? 'Sharing stories, insights, and inspiration from around the world.';
$show_social = $settings['show_social'] ?? true;
$show_newsletter = $settings['show_newsletter'] ?? true;
$newsletter_title = $settings['newsletter_title'] ?? 'Subscribe to Our Newsletter';
$newsletter_text = $settings['newsletter_text'] ?? 'Get the latest articles and updates delivered to your inbox.';
$show_contact = $settings['show_contact'] ?? false;
$columns = $settings['columns'] ?? '4';
$show_menu1 = $settings['show_menu1'] ?? true;
$menu1_title = $settings['menu1_title'] ?? 'Categories';
$show_menu2 = $settings['show_menu2'] ?? true;
$menu2_title = $settings['menu2_title'] ?? 'Quick Links';
$show_copyright = $settings['show_copyright'] ?? true;
$copyright_text = $settings['copyright_text'] ?? 'All rights reserved.';
$show_payment_icons = $settings['show_payment_icons'] ?? false;
$show_back_to_top = $settings['show_back_to_top'] ?? true;

$contact = dst_get_contact();
?>

<footer class="hf-footer hf-footer-blog" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;">
    <style>
        .hf-footer-blog a {
            color: <?php echo esc_attr($link_color); ?>;
        }
        .hf-footer-blog a:hover {
            color: <?php echo esc_attr($link_hover_color); ?>;
        }
    </style>

    <!-- Newsletter Bar -->
    <?php if ($show_newsletter): ?>
        <div class="border-b border-white/10">
            <div class="hf-container py-12 lg:py-16">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                    <div class="space-y-3">
                        <h3 class="text-2xl lg:text-3xl font-bold" style="color: <?php echo esc_attr($link_color); ?>;">
                            <?php echo esc_html($newsletter_title); ?>
                        </h3>
                        <p class="text-base">
                            <?php echo esc_html($newsletter_text); ?>
                        </p>
                    </div>

                    <div>
                        <form class="flex flex-col sm:flex-row gap-3" onsubmit="return false;">
                            <input
                                type="email"
                                placeholder="Enter your email"
                                class="flex-1 px-5 py-3 rounded-lg bg-white/10 border border-white/20 focus:outline-none focus:border-white/40 placeholder:text-white/50"
                                style="color: <?php echo esc_attr($link_color); ?>;"
                            >
                            <button
                                type="submit"
                                class="px-8 py-3 font-semibold rounded-lg transition-all duration-300 hover:scale-105"
                                style="background-color: <?php echo esc_attr($link_hover_color); ?>; color: white;"
                            >
                                Subscribe
                            </button>
                        </form>
                        <p class="text-xs mt-3 opacity-75">
                            Join 10,000+ subscribers who get our weekly newsletter.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Footer -->
    <div class="hf-container py-12 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-<?php echo esc_attr($columns); ?> gap-8 lg:gap-12">

            <!-- Column 1: About Blog -->
            <div class="space-y-5">
                <?php if ($show_logo): ?>
                    <div class="mb-4">
                        <?php
                        $logo = dst_get_logo('light');
                        if ($logo): ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block">
                                <img src="<?php echo esc_url($logo); ?>" alt="<?php bloginfo('name'); ?>" class="h-10 w-auto">
                            </a>
                        <?php else: ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-xl font-bold" style="color: <?php echo esc_attr($link_color); ?>;">
                                <?php bloginfo('name'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ($show_description): ?>
                    <p class="text-sm leading-relaxed">
                        <?php echo esc_html($description_text ?: get_bloginfo('description')); ?>
                    </p>
                <?php endif; ?>

                <?php if ($show_social): ?>
                    <div>
                        <div class="text-sm font-semibold mb-3" style="color: <?php echo esc_attr($link_color); ?>;">
                            Follow Us
                        </div>
                        <div class="flex gap-3">
                            <?php
                            $socials = dst_get_socials();
                            $social_icons = [
                                'instagram' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>',
                                'twitter' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>',
                                'facebook' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
                                'linkedin' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
                                'youtube' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>'
                            ];

                            foreach ($socials as $network => $url):
                                if (!empty($url) && isset($social_icons[$network])): ?>
                                    <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="hover:opacity-80 transition-opacity" aria-label="<?php echo esc_attr(ucfirst($network)); ?>">
                                        <?php echo $social_icons[$network]; ?>
                                    </a>
                                <?php endif;
                            endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Column 2: Popular Posts -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold" style="color: <?php echo esc_attr($link_color); ?>;">
                    Popular Posts
                </h3>
                <div class="space-y-4">
                    <?php
                    $popular_posts = new WP_Query([
                        'posts_per_page' => 3,
                        'orderby' => 'comment_count',
                        'order' => 'DESC',
                    ]);

                    if ($popular_posts->have_posts()):
                        while ($popular_posts->have_posts()): $popular_posts->the_post(); ?>
                            <article class="flex gap-3 group">
                                <?php if (has_post_thumbnail()): ?>
                                    <div class="flex-shrink-0 w-16 h-16 rounded overflow-hidden bg-gray-700">
                                        <?php the_post_thumbnail('thumbnail', ['class' => 'w-full h-full object-cover']); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-medium line-clamp-2 group-hover:underline">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h4>
                                    <div class="text-xs mt-1 opacity-75">
                                        <?php echo get_the_date(); ?>
                                    </div>
                                </div>
                            </article>
                        <?php endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>

            <!-- Column 3: Categories -->
            <?php if ($show_menu1): ?>
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold" style="color: <?php echo esc_attr($link_color); ?>;">
                        <?php echo esc_html($menu1_title); ?>
                    </h3>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer-menu-1',
                        'container'      => false,
                        'menu_class'     => 'space-y-2 text-sm',
                        'fallback_cb'    => false,
                        'depth'          => 1,
                    ]);

                    // Fallback to categories if no menu
                    if (!has_nav_menu('footer-menu-1')):
                        $categories = get_categories(['number' => 6]);
                        if ($categories): ?>
                            <ul class="space-y-2 text-sm">
                                <?php foreach ($categories as $category): ?>
                                    <li>
                                        <a href="<?php echo get_category_link($category->term_id); ?>" class="hover:underline">
                                            <?php echo esc_html($category->name); ?> (<?php echo $category->count; ?>)
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif;
                    endif;
                    ?>
                </div>
            <?php endif; ?>

            <!-- Column 4: Quick Links & Tags -->
            <?php if ($show_menu2): ?>
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-semibold mb-4" style="color: <?php echo esc_attr($link_color); ?>;">
                            <?php echo esc_html($menu2_title); ?>
                        </h3>
                        <?php
                        wp_nav_menu([
                            'theme_location' => 'footer-menu-2',
                            'container'      => false,
                            'menu_class'     => 'space-y-2 text-sm',
                            'fallback_cb'    => false,
                            'depth'          => 1,
                        ]);
                        ?>
                    </div>

                    <!-- Tags Cloud -->
                    <div>
                        <h4 class="text-sm font-semibold mb-3" style="color: <?php echo esc_attr($link_color); ?>;">
                            Popular Tags
                        </h4>
                        <div class="flex flex-wrap gap-2">
                            <?php
                            $tags = get_tags(['number' => 8, 'orderby' => 'count', 'order' => 'DESC']);
                            foreach ($tags as $tag): ?>
                                <a
                                    href="<?php echo get_tag_link($tag->term_id); ?>"
                                    class="px-3 py-1 text-xs rounded-full bg-white/10 hover:bg-white/20 transition-colors"
                                >
                                    <?php echo esc_html($tag->name); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="border-t border-white/10">
        <div class="hf-container py-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">

                <?php if ($show_copyright): ?>
                    <div class="text-sm text-center md:text-<?php echo is_rtl() ? 'right' : 'left'; ?>">
                        &copy; <?php echo date('Y'); ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:underline">
                            <?php bloginfo('name'); ?>
                        </a>
                        <?php if ($copyright_text): ?>
                            - <?php echo esc_html($copyright_text); ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="flex items-center gap-6 text-sm">
                    <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>" class="hover:underline">Privacy</a>
                    <a href="<?php echo esc_url(home_url('/terms')); ?>" class="hover:underline">Terms</a>
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="hover:underline">Contact</a>
                </div>

            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <?php if ($show_back_to_top): ?>
        <button
            x-data="{show: false}"
            @scroll.window="show = window.pageYOffset > 300"
            x-show="show"
            @click="window.scrollTo({top: 0, behavior: 'smooth'})"
            class="fixed <?php echo is_rtl() ? 'left-4' : 'right-4'; ?> bottom-4 p-3 rounded-full shadow-lg transition-all duration-300 hover:scale-110"
            style="background-color: <?php echo esc_attr($link_hover_color); ?>; color: white;"
            aria-label="Back to top"
            x-cloak
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
            </svg>
        </button>
    <?php endif; ?>
</footer>
