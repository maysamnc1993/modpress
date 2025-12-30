<?php
/**
 * Footer Template: Business Professional
 * Professional 4-column footer with logo, about, services menu, contact info, and newsletter
 */

defined('ABSPATH') || exit;

$settings = dst_get_footer_setting();
$bg_color = $settings['bg_color'] ?? '#1e293b';
$text_color = $settings['text_color'] ?? '#94a3b8';
$link_color = $settings['link_color'] ?? '#ffffff';
$link_hover_color = $settings['link_hover_color'] ?? '#3b82f6';
$show_logo = $settings['show_logo'] ?? true;
$show_description = $settings['show_description'] ?? true;
$description_text = $settings['description_text'] ?? 'We are a professional business providing high-quality services to our clients worldwide.';
$show_social = $settings['show_social'] ?? true;
$show_newsletter = $settings['show_newsletter'] ?? true;
$newsletter_title = $settings['newsletter_title'] ?? 'Subscribe to Newsletter';
$newsletter_text = $settings['newsletter_text'] ?? 'Get the latest updates and offers directly in your inbox.';
$show_contact = $settings['show_contact'] ?? true;
$columns = $settings['columns'] ?? '4';
$show_menu1 = $settings['show_menu1'] ?? true;
$menu1_title = $settings['menu1_title'] ?? 'Our Services';
$show_menu2 = $settings['show_menu2'] ?? true;
$menu2_title = $settings['menu2_title'] ?? 'Company';
$show_copyright = $settings['show_copyright'] ?? true;
$copyright_text = $settings['copyright_text'] ?? 'All rights reserved.';
$show_payment_icons = $settings['show_payment_icons'] ?? false;
$show_back_to_top = $settings['show_back_to_top'] ?? true;

$contact = dst_get_contact();
?>

<footer class="hf-footer hf-footer-business" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;">
    <style>
        .hf-footer-business a {
            color: <?php echo esc_attr($link_color); ?>;
        }
        .hf-footer-business a:hover {
            color: <?php echo esc_attr($link_hover_color); ?>;
        }
    </style>

    <!-- Main Footer -->
    <div class="hf-container py-12 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-<?php echo esc_attr($columns); ?> gap-8 lg:gap-12">

            <!-- Column 1: About Company -->
            <div class="space-y-4">
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
                    <div class="flex gap-3 pt-2">
                        <?php
                        $socials = dst_get_socials();
                        $social_icons = [
                            'instagram' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>',
                            'telegram' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>',
                            'whatsapp' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>',
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
                <?php endif; ?>
            </div>

            <!-- Column 2: Services Menu -->
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
                    ?>
                </div>
            <?php endif; ?>

            <!-- Column 3: Company Menu -->
            <?php if ($show_menu2): ?>
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold" style="color: <?php echo esc_attr($link_color); ?>;">
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
            <?php endif; ?>

            <!-- Column 4: Contact & Newsletter -->
            <div class="space-y-6">
                <?php if ($show_contact && !empty($contact)): ?>
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold" style="color: <?php echo esc_attr($link_color); ?>;">
                            Contact Us
                        </h3>
                        <div class="space-y-2 text-sm">
                            <?php if (!empty($contact['phone'])): ?>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <a href="tel:<?php echo esc_attr($contact['phone']); ?>" class="hover:underline">
                                        <?php echo esc_html($contact['phone']); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($contact['email'])): ?>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <a href="mailto:<?php echo esc_attr($contact['email']); ?>" class="hover:underline">
                                        <?php echo esc_html($contact['email']); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($contact['address'])): ?>
                                <div class="flex items-start gap-2">
                                    <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span><?php echo esc_html($contact['address']); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($show_newsletter): ?>
                    <div class="space-y-3">
                        <h4 class="font-semibold" style="color: <?php echo esc_attr($link_color); ?>;">
                            <?php echo esc_html($newsletter_title); ?>
                        </h4>
                        <p class="text-xs">
                            <?php echo esc_html($newsletter_text); ?>
                        </p>
                        <form class="flex gap-2" onsubmit="return false;">
                            <input
                                type="email"
                                placeholder="Your email"
                                class="flex-1 px-3 py-2 text-sm rounded bg-white/10 border border-white/20 focus:outline-none focus:border-white/40 placeholder:text-white/50"
                                style="color: <?php echo esc_attr($link_color); ?>;"
                            >
                            <button
                                type="submit"
                                class="px-4 py-2 text-sm font-medium rounded transition-colors"
                                style="background-color: <?php echo esc_attr($link_hover_color); ?>; color: white;"
                            >
                                Subscribe
                            </button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>

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

                <?php if ($show_payment_icons): ?>
                    <div class="flex items-center gap-3">
                        <span class="text-xs">We Accept:</span>
                        <div class="flex gap-2">
                            <svg class="h-6 w-auto" viewBox="0 0 38 24" fill="none"><rect width="38" height="24" rx="3" fill="#252525"/><path d="M23.21 17.389h-8.52v-10.86h8.52v10.86z" fill="#FF5F00"/><path d="M15.237 11.959a6.902 6.902 0 0 1 2.632-5.43 6.903 6.903 0 1 0 0 10.86 6.902 6.902 0 0 1-2.632-5.43z" fill="#EB001B"/><path d="M29.042 11.959a6.904 6.904 0 0 1-11.173 5.43 6.902 6.902 0 0 0 0-10.86 6.904 6.904 0 0 1 11.173 5.43z" fill="#F79E1B"/></svg>
                            <svg class="h-6 w-auto" viewBox="0 0 38 24" fill="none"><rect width="38" height="24" rx="3" fill="#0E4C96"/><path d="M14.063 17.389l1.594-9.86H18.2l-1.594 9.86h-2.543zm12.133-9.643c-.506-.2-1.306-.413-2.3-.413-2.537 0-4.325 1.314-4.338 3.198-.012 1.392 1.275 2.169 2.25 2.632.994.475 1.331.781 1.325 1.206-.006.65-.8 .944-1.537.944-1.025 0-1.569-.144-2.407-.5l-.331-.15-.356 2.157c.6.269 1.707.5 2.857.513 2.7 0 4.45-1.3 4.469-3.313.006-1.1-.675-1.944-2.156-2.638-.9-.444-1.45-.744-1.444-1.194 0-.4.462-.825 1.462-.825.831-.013 1.431.175 1.9.369l.225.112.381-2.3zm5.668-.217h-1.969c-.612 0-1.068.169-1.337.794l-3.794 8.866h2.694l.537-1.45h3.3c.075.331.306 1.45.306 1.45h2.381l-2.081-9.66h-.037zm-3.206 6.232c.212-.556 1.025-2.713 1.025-2.713-.019.031.213-.569.344-.938l.175.838s.494 2.325.6 2.813h-2.144zm-12.781-6.233l-2.494 6.726-.269-1.332c-.462-1.532-1.906-3.194-3.525-4.025l2.275 8.478h2.718l4.044-9.847h-2.75z" fill="#fff"/><path d="M8.738 7.53H4.381l-.031.188c3.219.8 5.35 2.732 6.231 5.057l-.9-4.438c-.156-.619-.606-.788-1.162-.806l.219-.001z" fill="#FAA61A"/></svg>
                            <svg class="h-6 w-auto" viewBox="0 0 38 24" fill="none"><rect width="38" height="24" rx="3" fill="#00579F"/><path fill-rule="evenodd" clip-rule="evenodd" d="M13.025 17.389h-2.175l-1.35-5.263a1.013 1.013 0 0 0-.563-.732 6.506 6.506 0 0 0-1.462-.469v-.196h2.512c.338 0 .619.244.675.563l.619 3.319 1.575-3.882h2.119l-3.15 6.66zm4.331 0h-2.062l1.631-6.66h2.063l-1.632 6.66zm3.525-4.819c.056-.319.338-.525.675-.525.394-.056.844 0 1.238.188l.225-1.05a3.548 3.548 0 0 0-1.294-.225c-1.969 0-3.375 1.05-3.375 2.55 0 1.106.994 1.725 1.744 2.1.788.375 1.069.619 1.069.956 0 .507-.619.732-1.182.732-.563 0-1.125-.113-1.575-.338l-.225 1.107c.45.169 1.069.281 1.688.281 2.175 0 3.544-1.05 3.544-2.663 0-1.969-2.756-2.1-2.756-2.944l.225-.169zm8.494 4.819l-1.631-6.66h-1.688c-.281 0-.563.169-.675.45l-2.4 6.21h2.119l.393-1.106h2.513l.225 1.106h1.856l-.712-.169zm-2.85-2.55l1.069-2.944.563 2.944h-1.632z" fill="#fff"/></svg>
                        </div>
                    </div>
                <?php endif; ?>

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
