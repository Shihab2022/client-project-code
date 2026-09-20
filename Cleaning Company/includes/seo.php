<?php
/**
 * =====================================================================
 *  SEO HEAD BLOCK
 * =====================================================================
 *  Prints a unique title, meta description, canonical URL, Open Graph,
 *  Twitter card, hreflang alternates and optional analytics tag for the
 *  current page. $page is prepared by the individual page file.
 * =====================================================================
 */

/** Canonical URL of the current page. */
function canonical_url(array $page): string
{
    if (!empty($page['canonical'])) {
        return (string) $page['canonical'];
    }

    $path = (string) ($page['path'] ?? $GLOBALS['CURRENT_PATH'] ?? '/index.php');
    $path = '/' . ltrim($path, '/');

    /* The homepage canonical is the language root: /en/ or /ar/.
       This must match the hreflang pairs and the language switcher,
       otherwise the homepage would declare two different URLs. */
    if ($path === '/index.php') {
        return rtrim(SITE_URL, '/') . base_path() . '/' . lang() . '/';
    }

    return abs_url($path);
}

/** Alternate language URLs for hreflang tags. */
function alternate_language_urls(array $page): array
{
    $path = (string) ($page['path'] ?? $GLOBALS['CURRENT_PATH'] ?? '/index.php');
    $path = '/' . ltrim($path, '/');
    $base = rtrim(SITE_URL, '/');
    $links = [];

    if (($GLOBALS['URL_MODE'] ?? 'prefixed') === 'prefixed') {
        foreach (SUPPORTED_LANGS as $code) {
            $links[$code] = $base . base_path() . '/' . $code . ($path === '/index.php' ? '/' : $path);
        }
        $links['x-default'] = $base . base_path() . '/' . DEFAULT_LANG . ($path === '/index.php' ? '/' : $path);
    } else {
        foreach (SUPPORTED_LANGS as $code) {
            $links[$code] = $base . base_path() . $path . '?lang=' . $code;
        }
    }

    return $links;
}

/**
 * Arabic SEO overrides for the current page.
 *
 * English titles live inside the page files and the /data files. The Arabic
 * equivalents live in /data/seo-ar.php so that /ar/ pages can have a fully
 * Arabic <title> and meta description without duplicating content.
 *
 * Returns ['title' => ..., 'description' => ...] (possibly empty), and an
 * empty array for the default language or when no entry exists.
 */
function ar_seo_override(string $slug): array
{
    if (lang() === DEFAULT_LANG || $slug === '') {
        return [];
    }

    $map = data('seo-ar');
    if (!$map) {
        return [];
    }

    /* Exact page entry first (e.g. 'service-areas' is a page, not a service),
       then fall back to the prefixed service / area / category entries. */
    $entry = $map['pages'][$slug] ?? null;
    if ($entry === null && str_starts_with($slug, 'service-')) {
        $entry = $map['services'][substr($slug, 8)] ?? null;
    }
    if ($entry === null && str_starts_with($slug, 'area-')) {
        $entry = $map['areas'][substr($slug, 5)] ?? null;
    }
    if ($entry === null && str_starts_with($slug, 'category-')) {
        $entry = $map['categories'][substr($slug, 9)] ?? null;
    }

    if (!is_array($entry)) {
        return [];
    }

    return array_filter([
        'title'       => (string) ($entry['title'] ?? ''),
        'description' => (string) ($entry['description'] ?? ''),
    ], static fn($value) => $value !== '');
}

/** Full <head> meta block for a page. */
function seo_head(array $page): string
{
    /* Arabic SEO copy wins when the active language is not the default one. */
    $override    = ar_seo_override((string) ($page['slug'] ?? ''));
    $title       = (string) ($override['title'] ?? $page['title']);
    $description = (string) ($override['description'] ?? $page['description']);
    $canonical   = canonical_url($page);
    $image       = str_starts_with((string) $page['image'], 'http')
        ? (string) $page['image']
        : rtrim(SITE_URL, '/') . media((string) $page['image']);

    $html  = '<title>' . e($title) . '</title>' . "\n";
    $html .= '<meta name="description" content="' . e($description) . '">' . "\n";
    if (!empty($page['keywords'])) {
        $html .= '<meta name="keywords" content="' . e((string) $page['keywords']) . '">' . "\n";
    }
    $html .= '<meta name="robots" content="' . e((string) ($page['robots'] ?? 'index, follow')) . '">' . "\n";
    $html .= '<link rel="canonical" href="' . e_url($canonical) . '">' . "\n";

    foreach (alternate_language_urls($page) as $code => $href) {
        $html .= '<link rel="alternate" hreflang="' . e($code) . '" href="' . e_url($href) . '">' . "\n";
    }

    /* Open Graph */
    $html .= '<meta property="og:type" content="' . e((string) ($page['og_type'] ?? 'website')) . '">' . "\n";
    $html .= '<meta property="og:site_name" content="' . e(company_name()) . '">' . "\n";
    $html .= '<meta property="og:title" content="' . e($title) . '">' . "\n";
    $html .= '<meta property="og:description" content="' . e($description) . '">' . "\n";
    $html .= '<meta property="og:url" content="' . e_url($canonical) . '">' . "\n";
    $html .= '<meta property="og:image" content="' . e_url($image) . '">' . "\n";
    $html .= '<meta property="og:image:alt" content="' . e((string) ($page['image_alt'] ?? $title)) . '">' . "\n";
    $html .= '<meta property="og:locale" content="' . e(lang() === 'ar' ? 'ar_KW' : 'en_US') . '">' . "\n";
    foreach (SUPPORTED_LANGS as $code) {
        if ($code !== lang()) {
            $html .= '<meta property="og:locale:alternate" content="' . e($code === 'ar' ? 'ar_KW' : 'en_US') . '">' . "\n";
        }
    }

    /* Twitter card */
    $html .= '<meta name="twitter:card" content="summary_large_image">' . "\n";
    $html .= '<meta name="twitter:title" content="' . e($title) . '">' . "\n";
    $html .= '<meta name="twitter:description" content="' . e($description) . '">' . "\n";
    $html .= '<meta name="twitter:image" content="' . e_url($image) . '">' . "\n";

    if (GOOGLE_SEARCH_CONSOLE_ID !== '') {
        $html .= '<meta name="google-site-verification" content="' . e(GOOGLE_SEARCH_CONSOLE_ID) . '">' . "\n";
    }

    return $html;
}

/** Optional analytics snippet (only when an ID is configured). */
function analytics_snippet(): string
{
    if (GOOGLE_ANALYTICS_ID === '') {
        return '';
    }
    $id = preg_replace('/[^A-Za-z0-9\-]/', '', GOOGLE_ANALYTICS_ID);

    return '<script async src="https://www.googletagmanager.com/gtag/js?id=' . e($id) . '"></script>' . "\n"
        . '<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}'
        . 'gtag("js",new Date());gtag("config","' . e($id) . '");</script>' . "\n";
}