<?php
/**
 * =====================================================================
 *  SITE NAVIGATION + shared page/menu maps
 * =====================================================================
 *  Everything the header, footer and internal-linking components need
 *  in one place. Service entries are generated from /data/services.php
 *  so a new service automatically appears in the mega menu, the footer
 *  and the services grid.
 */

/**
 * Top level pages (the header renders these in order).
 *
 * The list stays short on purpose: every entry has to fit on one desktop
 * row next to the logo and the phone call-to-action, on screens from
 * 1280px up to 1920px. Secondary pages are grouped into dropdowns
 * ("Company ▾") so nothing is more than one click away, and the mobile
 * drawer expands the very same structure as accordions.
 *
 * Supported keys per entry:
 *   key      translation key of the label
 *   url      landing page
 *   match    request paths that mark the entry as "current"
 *   mega     true  → wide mega menu with one column per service category
 *   category residential|commercial|specialised → dropdown of that category
 *   children [['key' => …, 'url' => …], …]       → plain dropdown
 *   areas    true  → dropdown built from /data/areas.php
 *   mobile_only true → drawer only (keeps the desktop row from overflowing)
 */
$site_nav = [
    /* The main navigation is intentionally short and predictable: Home,
       one Services tab that opens the full mega menu (all services in
       three columns), About, Why choose us, Service areas and Contact.
       Residential / commercial / specialised are NOT separate tabs — they
       live inside the Services panel and as anchor sections of
       /services.php. */
    ['key' => 'nav.home',     'url' => '/index.php',         'match' => ['index.php']],
    ['key' => 'nav.services', 'url' => '/services.php',      'match' => ['services.php'],      'mega' => true],
    ['key' => 'nav.about',    'url' => '/about.php',         'match' => ['about.php']],
    ['key' => 'nav.why',      'url' => '/why-choose-us.php', 'match' => ['why-choose-us.php']],
    ['key' => 'nav.areas',    'url' => '/service-areas.php', 'match' => ['service-areas.php'], 'areas' => true],
    ['key' => 'nav.contact',  'url' => '/contact.php',       'match' => ['contact.php']],
];

/**
 * Footer column: quick links.
 *
 * The FAQ page was merged into the home page (the FAQs are the same
 * Q&A set), so both the FAQ and the testimonial entries point at the
 * matching section of the home page instead of a separate URL.
 */
$footer_quick_links = [
    ['key' => 'nav.home',         'url' => '/index.php'],
    ['key' => 'nav.about',        'url' => '/about.php'],
    ['key' => 'nav.why',          'url' => '/why-choose-us.php'],
    ['key' => 'nav.areas',        'url' => '/service-areas.php'],
    ['key' => 'nav.gallery',      'url' => '/gallery.php'],
    ['key' => 'nav.testimonials', 'url' => '/index.php#testimonials'],
    ['key' => 'nav.faq',          'url' => '/index.php#faqs'],
];

/** Footer column: legal links. */
$footer_legal_links = [
    ['key' => 'footer.privacy', 'url' => '/privacy-policy.php'],
    ['key' => 'footer.terms',   'url' => '/terms.php'],
];

/** Footer column: featured services (slugs from /data/services.php). */
$footer_service_slugs = [
    'villa-cleaning', 'apartment-cleaning', 'deep-cleaning', 'sofa-cleaning',
    'carpet-cleaning', 'kitchen-cleaning', 'office-cleaning', 'shop-cleaning',
];

/** Footer column: featured areas (slugs from /data/areas.php). */
$footer_area_slugs = ['kuwait-city', 'salmiya', 'hawally', 'farwaniya', 'ahmadi', 'jahra'];

/** Social profiles (empty strings are skipped automatically). */
$social_profiles = [
    ['key' => 'instagram', 'label' => 'Instagram', 'url' => COMPANY_INSTAGRAM, 'icon' => 'instagram'],
    ['key' => 'facebook',  'label' => 'Facebook',  'url' => COMPANY_FACEBOOK,  'icon' => 'facebook'],
    ['key' => 'tiktok',    'label' => 'TikTok',    'url' => COMPANY_TIKTOK,    'icon' => 'tiktok'],
];