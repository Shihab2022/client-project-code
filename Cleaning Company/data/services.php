<?php
/**
 * =====================================================================
 *  SERVICE INDEX  —  the single source of truth for every service
 * =====================================================================
 *  Each service is defined in /data/services/<slug>.php and listed in
 *  $service_index below. Add a slug to the list, create the matching
 *  file and the service appears automatically in:
 *      the mega menu · the services grid · category pages · the footer ·
 *      the contact form · the sitemap · related-service blocks
 *  No database and no duplicated content anywhere.
 * =====================================================================
 */

$service_index = [
    /* Residential */
    'villa-cleaning',
    'apartment-cleaning',
    'deep-cleaning',
    'sofa-cleaning',
    'carpet-cleaning',
    'mattress-cleaning',
    'kitchen-cleaning',
    'bathroom-cleaning',
    'window-cleaning',
    'move-in-cleaning',
    'move-out-cleaning',
    'chalet-cleaning',
    /* Commercial */
    'office-cleaning',
    'shop-cleaning',
    'restaurant-cleaning',
    'cafe-cleaning',
    'school-cleaning',
    'clinic-cleaning',
    'hotel-cleaning',
    'warehouse-cleaning',
    'showroom-cleaning',
    'commercial-building-cleaning',
    /* Specialised */
    'steam-cleaning',
    'upholstery-cleaning',
    'glass-cleaning',
    'facade-cleaning',
    'post-construction-cleaning',
    'disinfection-cleaning',
    'kitchen-degreasing',
    'floor-polishing',
];

$services = [];
foreach ($service_index as $slug) {
    $file = __DIR__ . '/services/' . $slug . '.php';
    if (is_file($file)) {
        $data = require $file;
        if (is_array($data) && $data) {
            $data['slug'] = $slug;
            $services[$slug] = $data;
        }
    }
}

return [
    'index'    => $service_index,
    'services' => $services,

    /* ----------------------------------------------------------------
     | Service categories (used by the menu, category pages and cards)
     * --------------------------------------------------------------*/
    'categories' => [
        'residential' => [
            'name'       => 'Residential Cleaning',
            'name_ar'    => 'تنظيف المنازل',
            'short_name' => 'Residential',
            'icon'       => 'home',
            'url'        => '/services.php#residential',
            'description'=> 'Villa, apartment, sofa, carpet, kitchen, bathroom and deep cleaning for homes across Kuwait.',
        ],
        'commercial' => [
            'name'       => 'Commercial Cleaning',
            'name_ar'    => 'تنظيف الشركات',
            'short_name' => 'Commercial',
            'icon'       => 'building',
            'url'        => '/services.php#commercial',
            'description'=> 'Offices, shops, restaurants, clinics, schools and other business premises cleaned around your working hours.',
        ],
        'specialised' => [
            'name'       => 'Specialised Cleaning',
            'name_ar'    => 'الخدمات المتخصصة',
            'short_name' => 'Specialised',
            'icon'       => 'tools',
            'url'        => '/services.php#specialised',
            'description'=> 'Deep, steam, facade, glass, floor and post-construction cleaning that needs professional equipment.',
        ],
    ],

    /* ----------------------------------------------------------------
     | Default cleaning process used by every service page
     | (a service may override it with its own 'process' array)
     * --------------------------------------------------------------*/
    'default_process' => [
        ['title' => 'Contact us', 'text' => 'Send a WhatsApp message or call us with the type of space, the area in Kuwait and what you need cleaned.', 'icon' => 'whatsapp'],
        ['title' => 'Understand your requirements', 'text' => 'We ask about size, surfaces, materials, access and the condition of the space so nothing is assumed.', 'icon' => 'info'],
        ['title' => 'Prepare the cleaning plan', 'text' => 'We agree the scope, the number of cleaners, the equipment and the time window that suits you.', 'icon' => 'calendar'],
        ['title' => 'Professional cleaning', 'text' => 'The team works through a written task list using the right products and machines for each surface.', 'icon' => 'broom'],
        ['title' => 'Quality inspection', 'text' => 'A supervisor or team leader checks the finished areas against the task list before handover.', 'icon' => 'shield'],
        ['title' => 'Final handover', 'text' => 'We walk you through the result, answer your questions and agree on any follow-up if needed.', 'icon' => 'check-circle'],
    ],

    /* ----------------------------------------------------------------
     | Default reasons to choose us (services may override with 'why')
     * --------------------------------------------------------------*/
    'default_why' => [
        ['title' => 'Trained cleaning staff', 'text' => 'Cleaners are trained on surface-specific methods and the safe use of cleaning chemicals.', 'icon' => 'users'],
        ['title' => 'Professional equipment', 'text' => 'Commercial vacuum systems, steam machines, rotary machines and microfibre systems.', 'icon' => 'tools'],
        ['title' => 'Safe cleaning materials', 'text' => 'Products are selected for the material being cleaned and used at the recommended dilution.', 'icon' => 'leaf'],
        ['title' => 'Reliable scheduling', 'text' => 'We confirm the appointment, arrive in the agreed window and keep you informed of any change.', 'icon' => 'clock'],
        ['title' => 'Quality supervision', 'text' => 'A team leader checks the work against a written task list before the job is closed.', 'icon' => 'shield'],
        ['title' => 'Flexible appointment times', 'text' => 'Morning, evening and after-hours visits for homes and businesses, subject to availability.', 'icon' => 'calendar'],
    ],
];