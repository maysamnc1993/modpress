<?php
/**
 * Footer Template: FAQ
 * Footer with FAQ accordion section and contact CTA
 */

defined('ABSPATH') || exit;

$settings = dst_get_footer_setting();
$bg_color = $settings['bg_color'] ?? '#ffffff';
$text_color = $settings['text_color'] ?? '#374151';
$heading_color = $settings['heading_color'] ?? '#111827';
$accent_color = $settings['accent_color'] ?? '#3b82f6';
$border_color = $settings['border_color'] ?? '#e5e7eb';
$faq_count = $settings['faq_count'] ?? 5;
$faq_style = $settings['faq_style'] ?? 'accordion';
$show_contact_cta = $settings['show_contact_cta'] ?? true;
$cta_heading = $settings['cta_heading'] ?? 'Still Have Questions?';
$cta_text = $settings['cta_text'] ?? "Our team is here to help. Get in touch and we'll answer any questions you may have.";
$cta_button_text = $settings['cta_button_text'] ?? 'Contact Us';
$show_logo = $settings['show_logo'] ?? true;
$show_social = $settings['show_social'] ?? true;
$show_copyright = $settings['show_copyright'] ?? true;
$copyright_text = $settings['copyright_text'] ?? 'All rights reserved.';
$spacing_top = $settings['spacing_top'] ?? 'large';
$spacing_bottom = $settings['spacing_bottom'] ?? 'medium';

$spacing_map = [
    'none' => 'py-0',
    'small' => 'py-8',
    'medium' => 'py-12',
    'large' => 'py-16 lg:py-20'
];

$contact = dst_get_contact();

// Sample FAQ items
$faq_items = [
    [
        'question' => 'What payment methods do you accept?',
        'answer' => 'We accept all major credit cards, PayPal, and bank transfers. All payments are processed securely through our payment gateway.'
    ],
    [
        'question' => 'How long does shipping take?',
        'answer' => 'Standard shipping typically takes 3-5 business days. Express shipping options are available at checkout for faster delivery.'
    ],
    [
        'question' => 'What is your return policy?',
        'answer' => 'We offer a 30-day money-back guarantee. If you\'re not satisfied with your purchase, you can return it for a full refund within 30 days.'
    ],
    [
        'question' => 'Do you offer customer support?',
        'answer' => 'Yes! Our customer support team is available 24/7 via email, phone, and live chat to assist you with any questions or concerns.'
    ],
    [
        'question' => 'Can I track my order?',
        'answer' => 'Absolutely! Once your order ships, you\'ll receive a tracking number via email that you can use to monitor your delivery status.'
    ],
    [
        'question' => 'Do you ship internationally?',
        'answer' => 'Yes, we ship to most countries worldwide. International shipping rates and delivery times vary by location.'
    ],
    [
        'question' => 'How do I create an account?',
        'answer' => 'Click the "Sign Up" button in the top right corner, fill in your details, and you\'ll be ready to start shopping in minutes.'
    ],
    [
        'question' => 'Are my personal details secure?',
        'answer' => 'Yes, we use industry-standard SSL encryption to protect all your personal and payment information.'
    ]
];

$faq_items = array_slice($faq_items, 0, $faq_count);
?>

<footer class="hf-footer hf-footer-faq" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;">
    <style>
        .hf-footer-faq a {
            color: <?php echo esc_attr($accent_color); ?>;
            transition: opacity 0.3s ease;
        }
        .hf-footer-faq a:hover {
            opacity: 0.8;
        }
        .hf-faq-item {
            border-bottom: 1px solid <?php echo esc_attr($border_color); ?>;
        }
        .hf-faq-question {
            color: <?php echo esc_attr($heading_color); ?>;
        }
        .hf-faq-answer {
            color: <?php echo esc_attr($text_color); ?>;
        }
        <?php if ($faq_style === 'accordion'): ?>
        .hf-faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        .hf-faq-item.active .hf-faq-answer {
            max-height: 500px;
        }
        .hf-faq-item.active .hf-faq-toggle {
            transform: rotate(180deg);
        }
        <?php endif; ?>
        .hf-faq-toggle {
            transition: transform 0.3s ease;
            color: <?php echo esc_attr($accent_color); ?>;
        }
    </style>

    <!-- FAQ Section -->
    <div class="<?php echo esc_attr($spacing_map[$spacing_top]); ?>">
        <div class="hf-container">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl lg:text-4xl font-bold mb-4" style="color: <?php echo esc_attr($heading_color); ?>;">
                        Frequently Asked Questions
                    </h2>
                    <p class="text-lg">
                        Find answers to common questions about our products and services
                    </p>
                </div>

                <div class="space-y-0">
                    <?php foreach ($faq_items as $index => $faq): ?>
                        <div class="hf-faq-item <?php echo $faq_style === 'accordion' ? 'cursor-pointer' : ''; ?>"
                             <?php if ($faq_style === 'accordion'): ?>
                             onclick="this.classList.toggle('active')"
                             <?php endif; ?>>
                            <div class="py-6 flex items-start justify-between gap-4">
                                <div class="flex-1">
                                    <h3 class="hf-faq-question text-lg font-semibold mb-2 <?php echo is_rtl() ? 'text-right' : 'text-left'; ?>">
                                        <?php echo esc_html($faq['question']); ?>
                                    </h3>
                                    <div class="hf-faq-answer <?php echo is_rtl() ? 'text-right' : 'text-left'; ?> <?php echo $faq_style === 'list' ? 'mt-2' : 'mt-0'; ?>">
                                        <p class="leading-relaxed">
                                            <?php echo esc_html($faq['answer']); ?>
                                        </p>
                                    </div>
                                </div>
                                <?php if ($faq_style === 'accordion'): ?>
                                    <div class="hf-faq-toggle flex-shrink-0 mt-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact CTA Section -->
    <?php if ($show_contact_cta): ?>
        <div class="py-12 lg:py-16" style="background-color: <?php echo esc_attr($accent_color); ?>10;">
            <div class="hf-container">
                <div class="max-w-3xl mx-auto text-center">
                    <h3 class="text-2xl lg:text-3xl font-bold mb-4" style="color: <?php echo esc_attr($heading_color); ?>;">
                        <?php echo esc_html($cta_heading); ?>
                    </h3>
                    <p class="text-lg mb-6">
                        <?php echo esc_html($cta_text); ?>
                    </p>

                    <?php if (!empty($contact['email']) || !empty($contact['phone'])): ?>
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-6">
                            <?php if (!empty($contact['email'])): ?>
                                <a href="mailto:<?php echo esc_attr($contact['email']); ?>" class="inline-flex items-center gap-2 font-medium">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <?php echo esc_html($contact['email']); ?>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($contact['phone'])): ?>
                                <a href="tel:<?php echo esc_attr($contact['phone']); ?>" class="inline-flex items-center gap-2 font-medium">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <?php echo esc_html($contact['phone']); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>"
                       class="inline-block px-8 py-4 text-base font-bold rounded-lg transition-all duration-300 hover:opacity-90"
                       style="background-color: <?php echo esc_attr($accent_color); ?>; color: white;">
                        <?php echo esc_html($cta_button_text); ?>
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Bottom Bar -->
    <div class="<?php echo esc_attr($spacing_map[$spacing_bottom]); ?> border-t" style="border-color: <?php echo esc_attr($border_color); ?>;">
        <div class="hf-container">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">

                <?php if ($show_logo): ?>
                    <div class="flex items-center gap-6">
                        <?php
                        $logo = dst_get_logo();
                        if ($logo): ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block">
                                <img src="<?php echo esc_url($logo); ?>" alt="<?php bloginfo('name'); ?>" class="h-10 w-auto">
                            </a>
                        <?php else: ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-xl font-bold" style="color: <?php echo esc_attr($heading_color); ?>;">
                                <?php bloginfo('name'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

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

                <?php if ($show_social): ?>
                    <div class="flex gap-4">
                        <?php
                        $socials = dst_get_socials();
                        $social_icons = [
                            'instagram' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>',
                            'twitter' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>',
                            'facebook' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
                            'linkedin' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>'
                        ];

                        foreach ($socials as $network => $url):
                            if (!empty($url) && isset($social_icons[$network])): ?>
                                <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="hover:opacity-70 transition-opacity" aria-label="<?php echo esc_attr(ucfirst($network)); ?>">
                                    <?php echo $social_icons[$network]; ?>
                                </a>
                            <?php endif;
                        endforeach; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</footer>
