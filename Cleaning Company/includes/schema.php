<?php
/**
 * =====================================================================
 *  STRUCTURED DATA (Schema.org JSON-LD)
 * =====================================================================
 *  Only facts that are actually configured are emitted: no invented
 *  ratings, review counts, addresses or certifications.
 * =====================================================================
 */

/** Site wide organisation / cleaning service entity. */
function schema_local_business(): array
{
    $data = [
        '@context'    => 'https://schema.org',
        '@type'       => ['CleaningService', 'LocalBusiness'],
        '@id'         => abs_url('/') . '#organization',
        'name'        => company_name(),
        'legalName'   => COMPANY_LEGAL_NAME,
        'url'         => rtrim(SITE_URL, '/') . url('/'),
        'telephone'   => COMPANY_PHONE_E164,
        'email'       => COMPANY_EMAIL,
        'description' => company_name() . ' provides residential, commercial and specialised cleaning services in Kuwait.',
        'address'     => array_filter([
            '@type'           => 'PostalAddress',
            'streetAddress'   => COMPANY_ADDRESS,
            'addressLocality' => COMPANY_CITY,
            'addressCountry'  => 'KW',
            'postalCode'      => COMPANY_POSTAL_CODE !== '' ? COMPANY_POSTAL_CODE : null,
        ], static fn($value) => $value !== null && $value !== ''),
        'areaServed'        => [['@type' => 'Country', 'name' => COMPANY_SERVICE_COUNTRY]],
        'availableLanguage' => array_values(array_filter(array_map('trim', explode(',', COMPANY_LANGUAGES)))),
        'serviceType'       => [
            'Residential cleaning',
            'Commercial cleaning',
            'Deep cleaning',
            'Sofa cleaning',
            'Carpet cleaning',
            'Office cleaning',
        ],
    ];

    $hours = schema_opening_hours();
    if ($hours) {
        $data['openingHoursSpecification'] = $hours;
    }

    $sameAs = schema_social_profiles();
    if ($sameAs) {
        $data['sameAs'] = $sameAs;
    }

    if (COMPANY_GOOGLE_MAPS_URL !== '' && str_starts_with(COMPANY_GOOGLE_MAPS_URL, 'http')) {
        $data['hasMap'] = COMPANY_GOOGLE_MAPS_URL;
    }

    return $data;
}

/** openingHoursSpecification entries from COMPANY_OPENING_HOURS. */
function schema_opening_hours(): array
{
    $specs = [];
    foreach ((array) COMPANY_OPENING_HOURS as $day => $range) {
        if (!is_array($range) || count($range) < 2) {
            continue;
        }
        $specs[] = [
            '@type'     => 'OpeningHoursSpecification',
            'dayOfWeek' => 'https://schema.org/' . $day,
            'opens'     => $range[0],
            'closes'    => $range[1],
        ];
    }

    return $specs;
}

/** Social profile URLs that are actually configured. */
function schema_social_profiles(): array
{
        // Read social URLs from site config if defined; fall back to constants.
    $candidates = [];
    if (defined('COMPANY_INSTAGRAM')) { $candidates[] = COMPANY_INSTAGRAM; }
    if (defined('COMPANY_FACEBOOK'))  { $candidates[] = COMPANY_FACEBOOK; }
    if (defined('COMPANY_TIKTOK'))   { $candidates[] = COMPANY_TIKTOK; }
    // Also pick up any profile list that data/site.php may have registered.
    global $social_profiles;
    foreach ((array) ($social_profiles ?? []) as $profile) {
        if (is_array($profile) && isset($profile['url'])) {
            $candidates[] = $profile['url'];
        }
    }

    $urls = [];
    foreach ($candidates as $url) {
        if (is_string($url) && str_starts_with($url, 'http')) {
            $urls[] = $url;
        }
    }

    return $urls;
}

/** WebSite entity. */
function schema_website(): array
{
    return [
        '@context'   => 'https://schema.org',
        '@type'      => 'WebSite',
        '@id'        => rtrim(SITE_URL, '/') . '#website',
        'url'        => rtrim(SITE_URL, '/') . url('/'),
        'name'       => company_name(),
        'inLanguage' => lang(),
        'publisher'  => ['@id' => abs_url('/') . '#organization'],
    ];
}

/** BreadcrumbList built from $page['breadcrumbs'] (label => url). */
function schema_breadcrumbs(array $breadcrumbs): ?array
{
    if (!$breadcrumbs) {
        return null;
    }
    $items    = [];
    $position = 1;
    foreach ($breadcrumbs as $label => $href) {
        $entry = [
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => $label,
        ];
        if ($href !== '') {
            $entry['item'] = str_starts_with($href, 'http') ? $href : rtrim(SITE_URL, '/') . $href;
        }
        $items[] = $entry;
    }

    return [
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $items,
    ];
}

/** FAQPage schema – emitted only when the same Q&A is visible on the page. */
function schema_faq(array $items): ?array
{
    $entities = [];
    foreach ($items as $item) {
        $question = is_array($item) ? (string) ($item['q'] ?? '') : '';
        $answer   = is_array($item) ? trim(strip_tags((string) ($item['a'] ?? ''))) : '';
        if ($question === '' || $answer === '') {
            continue;
        }
        $entities[] = [
            '@type'          => 'Question',
            'name'           => $question,
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $answer],
        ];
    }

    if (!$entities) {
        return null;
    }

    return [
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        'mainEntity' => $entities,
    ];
}

/** Service schema for one service page. */
function schema_service(array $service, string $slug): array
{
    return [
        '@context'         => 'https://schema.org',
        '@type'            => 'Service',
        'name'             => lx($service, 'name', $slug) . ' in Kuwait',
        'serviceType'      => lx($service, 'name', $slug),
        'description'      => lx($service, 'meta_description', ''),
        'url'              => abs_url('/services/' . $slug . '.php'),
        'provider'         => ['@id' => abs_url('/') . '#organization'],
        'areaServed'       => ['@type' => 'Country', 'name' => COMPANY_SERVICE_COUNTRY],
        'availableChannel' => [
            '@type'             => 'ServiceChannel',
            'serviceUrl'        => abs_url('/services/' . $slug . '.php'),
            'availableLanguage' => SUPPORTED_LANGS,
        ],
    ];
}

/** All JSON-LD blocks for the current page. */
function schema_for_page(array $page): array
{
    $blocks = [schema_local_business()];

    if (($page['slug'] ?? '') === 'home') {
        $blocks[] = schema_website();
    }
    if (!empty($page['faq'])) {
        $faq = schema_faq((array) $page['faq']);
        if ($faq) {
            $blocks[] = $faq;
        }
    }
    if (!empty($page['breadcrumbs'])) {
        $breadcrumbs = schema_breadcrumbs((array) $page['breadcrumbs']);
        if ($breadcrumbs) {
            $blocks[] = $breadcrumbs;
        }
    }
    foreach ((array) ($page['schema'] ?? []) as $extra) {
        if (is_array($extra) && $extra) {
            $blocks[] = $extra;
        }
    }

    return $blocks;
}

/** Render the JSON-LD script tags. */
function schema_render(array $page): string
{
    $html = '';
    foreach (schema_for_page($page) as $block) {
        $json = json_encode($block, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        if ($json === false) {
            continue;
        }
        $html .= '<script type="application/ld+json">' . $json . '</script>' . "\n";
    }

    return $html;
}