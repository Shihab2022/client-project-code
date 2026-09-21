<?php
/**
 * =====================================================================
 *  ROBOTS.TXT  —  served at /robots.txt through an .htaccess rewrite
 * =====================================================================
 *  Generated so the sitemap URL always matches SITE_URL, even when the
 *  site is installed in a sub-directory.
 * =====================================================================
 */

require __DIR__ . '/includes/bootstrap.php';

header('Content-Type: text/plain; charset=UTF-8');

echo 'User-agent: *' . "\n"
   . 'Allow: /' . "\n"
   . "\n"
   . '# Internal resources that are not part of the public website.' . "\n"
   . 'Disallow: /actions/' . "\n"
   . 'Disallow: /config/' . "\n"
   . 'Disallow: /includes/' . "\n"
   . 'Disallow: /data/' . "\n"
   . 'Disallow: /tools/' . "\n"
   . 'Disallow: /lang/' . "\n"
   . 'Disallow: /404.php' . "\n"
   . 'Disallow: /*/actions/' . "\n"
   . 'Disallow: /*/config/' . "\n"
   . 'Disallow: /*/includes/' . "\n"
   . 'Disallow: /*/data/' . "\n"
   . 'Disallow: /*/tools/' . "\n"
   . 'Disallow: /*/lang/' . "\n"
   . 'Disallow: /*/404.php' . "\n"
   . "\n"
   . '# Sitemap (contains the English URLs plus hreflang links to Arabic)' . "\n"
   . 'Sitemap: ' . rtrim(SITE_URL, '/') . base_path() . '/sitemap.xml' . "\n";