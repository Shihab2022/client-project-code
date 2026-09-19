<?php
/**
 * Specialised / specialized cleaning category page.
 */
$categoryPage = [
    'key'          => 'specialised',
    'file'         => 'specialized-cleaning.php',
    'title'        => 'Specialised Cleaning Services in Kuwait | ' . (defined('COMPANY_NAME') ? COMPANY_NAME : ''),
    'description'  => 'Deep cleaning, steam cleaning, upholstery, glass & facade cleaning, floor polishing and post-construction cleaning across Kuwait.',
    'keywords'     => 'specialised cleaning Kuwait, deep cleaning Kuwait, steam cleaning Kuwait, floor polishing Kuwait',
    'eyebrow_key'  => 'services.hero_eyebrow',
    'hero_key'     => 'services.hero_title',
    'text_key'     => 'services.hero_text',
    'details'      => [
        [
            'muted'    => true,
            'title'    => 'Heavy-duty and technical cleaning across Kuwait',
            'checks'   => [
                'High-pressure steam sanitisation for deep-pocket cleaning',
                'Specialist glass and facade cleaning with certified equipment',
                'Industrial floor polishing for marble, tiles and hardwood',
                'Post-construction cleaning to exacting standards',
                'Upholstery and fabric restoration using gentle methods',
                'Disinfection and sanitisation with hospital-grade products',
            ],
        ],
    ],
    'why'            => [
        ['icon' => 'award', 'title' => 'Certified specialists', 'text' => 'Teams trained in specialised techniques and safety.'],
        ['icon' => 'tools', 'title' => 'Specialist equipment', 'text' => 'High-end machinery for technical cleaning tasks.'],
        ['icon' => 'shield-check', 'title' => 'Compliance-focused', 'text' => 'We follow safety and quality standards for each job.'],
        ['icon' => 'clock', 'title' => 'Scheduled availability', 'text' => 'Flexible timing including weekends for specialised work.'],
    ],
];
require __DIR__ . '/includes/category-page.php';
