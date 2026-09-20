<?php
/**
 * 404 PAGE
 *
 * Served when a request cannot be matched to a real page. Also included
 * by service-page.php and area-page.php when a slug cannot be resolved.
 */

require __DIR__ . '/includes/bootstrap.php';
require __DIR__ . '/includes/not-found.php';   // defines not_found()

$page = [
    'slug'        => '404',
    'path'        => '/404.php',
    'title'       => 'Page Not Found — Cleaning Services in Kuwait | ' . COMPANY_NAME,
    'description' => 'The page you are looking for was not found on the ' . COMPANY_NAME . ' website. Return home, view our cleaning services or message us on WhatsApp.',
    'image'       => '/assets/images/og-cover.webp',
    'image_alt'   => COMPANY_NAME . ' page not found',
    'robots'      => 'noindex, follow',
    'body_class'  => 'page-404',
];

require __DIR__ . '/includes/header.php';
?>

<main id="main" class="main">
    <?php echo not_found(); ?>
</main>

<?php
require __DIR__ . '/includes/footer.php';