<?php
/**
 * Residential cleaning category page.
 */
$categoryPage = [
    'key'          => 'residential',
    'file'         => 'residential-cleaning.php',
    'title'        => 'Residential Cleaning Services in Kuwait | ' . (defined('COMPANY_NAME') ? COMPANY_NAME : ''),
    'description'  => 'Villa, apartment, deep, sofa, carpet, kitchen and window cleaning for homes across Kuwait. Professional, reliable and fully equipped teams.',
    'keywords'     => 'residential cleaning Kuwait, villa cleaning Kuwait, apartment cleaning Kuwait, deep cleaning Kuwait, home cleaning Kuwait',
    'eyebrow_key'  => 'services.hero_eyebrow',
    'hero_key'     => 'services.hero_title',
    'text_key'     => 'services.hero_text',
    'details'      => [
        [
            'muted'    => true,
            'title'    => 'Why homeowners choose professional cleaning in Kuwait',
            'lead'     => 'From move-in deep cleans to weekly maintenance, our trained teams keep Kuwait homes spotless with safe, high-quality products.',
            'checks'   => [
                'Regular deep cleaning removes dust and allergens common in Kuwait\'s climate',
                'Professional-grade equipment reaches areas household cleaning cannot',
                'Flexible scheduling including evenings and weekends',
                'Fully insured teams treat your home with respect',
                'Child- and pet-safe cleaning products available on request',
            ],
        ],
        [
            'title'    => 'Our residential cleaning process',
            'cards'    => [
                ['icon' => 'phone', 'title' => 'Contact', 'text' => 'WhatsApp or call us to discuss your needs and property size.'],
                ['icon' => 'calendar', 'title' => 'Schedule', 'text' => 'We confirm a time that suits your schedule across Kuwait.'],
                ['icon' => 'team', 'title' => 'Clean', 'text' => 'Our uniformed team arrives with all professional equipment.'],
                ['icon' => 'check', 'title' => 'Inspect', 'text' => 'We perform a quality check before final handover.'],
            ],
        ],
    ],
    'why'            => [
        ['icon' => 'award', 'title' => 'Experienced team', 'text' => 'Trained cleaners with years of residential experience.'],
        ['icon' => 'tools', 'title' => 'Professional equipment', 'text' => 'High-quality tools and products for every surface.'],
        ['icon' => 'shield-check', 'title' => 'Safe products', 'text' => 'Child- and pet-safe, eco-friendly cleaning materials.'],
        ['icon' => 'star', 'title' => 'Quality guarantee', 'text' => 'We revisit any area of concern at no extra charge.'],
    ],
];
require __DIR__ . '/includes/category-page.php';
