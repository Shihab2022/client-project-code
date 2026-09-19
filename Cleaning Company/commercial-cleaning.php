<?php
/**
 * Commercial cleaning category page.
 */
$categoryPage = [
    'key'          => 'commercial',
    'file'         => 'commercial-cleaning.php',
    'title'        => 'Commercial Cleaning Services in Kuwait | ' . (defined('COMPANY_NAME') ? COMPANY_NAME : ''),
    'description'  => 'Office, shop, restaurant, school, clinic, hotel and warehouse cleaning across Kuwait. After-hours service with quality supervision.',
    'keywords'     => 'commercial cleaning Kuwait, office cleaning Kuwait, restaurant cleaning Kuwait, school cleaning Kuwait',
        'eyebrow_key'  => 'services.hero_eyebrow',
    'hero_key'     => 'services.hero_title',
    'text_key'     => 'services.hero_text',
    'details'      => [
        [
            'muted'    => true,
            'title'    => 'Business benefits of professional commercial cleaning',
            'checks'   => [
                'Maintains a professional appearance for clients and staff',
                'Promotes a healthier working environment',
                'Flexible scheduling including after-hours and weekends',
                'Recurring service plans to suit your budget',
                'Quality supervision on every visit',
                'Fully insured teams with security clearance available',
            ],
        ],
        [
            'title'    => 'Commercial cleaning across Kuwait',
            'lead'     => 'We serve offices, retail stores, restaurants, cafes, schools, clinics, hotels, warehouses and showrooms with tailored solutions.',
        ],
    ],
    'why'            => [
        ['icon' => 'clock', 'title' => 'After-hours service', 'text' => 'Cleaning scheduled when it suits your business hours.'],
        ['icon' => 'shield-check', 'title' => 'Background-checked staff', 'text' => 'All team members are vetted and trained.'],
        ['icon' => 'clipboard-check', 'title' => 'Quality supervision', 'text' => 'On-site supervisors ensure consistent results.'],
        ['icon' => 'repeat', 'title' => 'Recurring plans', 'text' => 'Weekly, monthly or project-based scheduling available.'],
    ],
];
require __DIR__ . '/includes/category-page.php';
