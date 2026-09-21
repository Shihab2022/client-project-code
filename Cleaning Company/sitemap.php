<?php
/**
 * =====================================================================
 *  SITEMAP  —  served at /sitemap.xml through an .htaccess rewrite
 * =====================================================================
 *  Generated live from the same /data files that build the menus, so a
 *  new service or area is picked up automatically. English URLs carry
 *  hreflang alternates for the Arabic version (Google indexes both).
 *
 *  Excluded on purpose: /actions/ (form handler), /tools/, 404.
 * =====================================================================
 */

require __DIR__ . '/includes/bootstrap.php';

header('Content-Type: application/xml; charset=UTF-8');

$base = rtrim(SITE_URL, '/');
$root = base_path();

/** Absolute (en, ar) URL pair for one internal path such as /about.php. */
$pair = static function (string $path) use ($base, $root): array {
    $path = '/' . ltrim($path, '/');
    if ($path === '/index.php' || $path === '/') {
        return [$base . $root . '/en/', $base . $root . '/ar/'];
    }

    return [$base . $root . '/en' . $path, $base . $root . '/ar' . $path];
};

/** <lastmod> from the page file, when it exists on disk. */
$modified = static function (string $path): string {
    $file = __DIR__ . str_replace('/', DIRECTORY_SEPARATOR, $path);
    return is_file($file) ? date('Y-m-d', (int) filemtime($file)) : date('Y-m-d');
};

/** One <url> block with hreflang alternates. */
$entry = static function (string $en, string $ar, string $lastmod, string $priority): string {
    return '    <url>' . "\n"
        . '        <loc>' . e_url($en) . '</loc>' . "\n"
        . '        <xhtml:link rel="alternate" hreflang="en" href="' . e_url($en) . '"/>' . "\n"
        . '        <xhtml:link rel="alternate" hreflang="ar" href="' . e_url($ar) . '"/>' . "\n"
        . '        <xhtml:link rel="alternate" hreflang="x-default" href="' . e_url($en) . '"/>' . "\n"
        . '        <lastmod>' . e($lastmod) . '</lastmod>' . "\n"
        . '        <priority>' . e($priority) . '</priority>' . "\n"
        . '    </url>' . "\n";
};

/* ------------------------------------------------------- url list --- */
$urls = [
    ['/',                              '1.0'],
    ['/services.php',                  '0.9'],
    ['/about.php',                     '0.8'],
    ['/why-choose-us.php',             '0.7'],
    ['/service-areas.php',             '0.8'],
    ['/contact.php',                   '0.9'],
    ['/privacy-policy.php',            '0.4'],
    ['/terms.php',                     '0.4'],
];

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n"
   . '        xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";

foreach ($urls as [$path, $priority]) {
    [$en, $ar] = $pair($path);
    echo $entry($en, $ar, $modified($path), $priority);
}

/* Service detail pages, generated from the service data. */
foreach (array_keys(services()) as $slug) {
    [$en, $ar] = $pair('/services/' . $slug . '.php');
    echo $entry($en, $ar, $modified('/services/' . $slug . '.php'), '0.8');
}

/* Area pages, generated from the area data. */
foreach (array_keys(areas()) as $slug) {
    [$en, $ar] = $pair('/areas/' . $slug . '.php');
    echo $entry($en, $ar, $modified('/areas/' . $slug . '.php'), '0.7');
}

echo '</urlset>' . "\n";