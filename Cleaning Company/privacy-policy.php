<?php
/**
 * PRIVACY POLICY PAGE
 */

require __DIR__ . '/includes/bootstrap.php';

$legal = legal_page('privacy-policy');
$lang  = lang();
$h1    = $lang === 'ar' ? ($legal['h1_ar'] ?? $legal['h1']) : ($legal['h1'] ?? '');
$updated = $lang === 'ar' ? ($legal['updated_ar'] ?? $legal['updated']) : ($legal['updated'] ?? '');
$intro   = $lang === 'ar' ? ($legal['intro_ar'] ?? $legal['intro']) : ($legal['intro'] ?? '');
$sections = $legal['sections'] ?? [];
$contact  = $legal['contact'] ?? [];

$page = [
    'slug'        => 'privacy-policy',
    'path'        => '/privacy-policy.php',
    'title'       => ($legal['title'] ?? 'Privacy Policy') . ' | ' . COMPANY_NAME,
    'description' => 'Privacy policy for ' . COMPANY_NAME . ' cleaning services in Kuwait. Explains what contact form information we collect, how emails are handled, cookies, analytics, WhatsApp links, Google Maps and your rights. No database is used.',
    'keywords'    => 'privacy policy cleaning company Kuwait, privacy policy Kuwait cleaning',
    'image'       => '/assets/images/og-cover.webp',
    'image_alt'   => COMPANY_NAME . ' privacy policy',
    'body_class'  => 'page-legal',
    'robots'      => 'index, follow',
    'breadcrumbs' => [
        t('common.home') => url('/'),
        ($legal['title'] ?? 'Privacy Policy') => '',
    ],
];

require __DIR__ . '/includes/header.php';

$hero = [
    'eyebrow'   => $h1,
    'title'     => $h1,
    'text'      => $intro,
    'image'     => '/assets/images/og-cover.webp',
    'image_alt' => COMPANY_NAME . ' privacy policy',
    'whatsapp'  => whatsapp_quote_message(),
];
require __DIR__ . '/includes/page-hero.php';
?>

<section class="section section--muted" aria-labelledby="privacy-content-title">
    <div class="container container--narrow">
        <p class="legal-meta"><?= e($updated) ?></p>
        <div class="legal-content">
            <p class="legal-intro"><?= $intro ?></p>

            <?php foreach ($sections as $section): ?>
                <div class="legal-section">
                    <h2 class="legal-section__heading" id="privacy-section-<?= e(preg_replace('/[^a-z0-9-]/i', '-', $section['heading'] ?? '')) ?>">
                        <?= e($lang === 'ar' ? ($section['heading_ar'] ?? $section['heading']) : ($section['heading'] ?? '')) ?>
                    </h2>
                    <div class="legal-section__body">
                        <?= $lang === 'ar' ? ($section['body_ar'] ?? '') : ($section['body'] ?? '') ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="legal-contact">
                <h2 class="legal-contact__heading"><?= e($lang === 'ar' ? ($contact['heading_ar'] ?? $contact['heading']) : ($contact['heading'] ?? '')) ?></h2>
                <div class="legal-contact__body">
                    <?= $lang === 'ar' ? ($contact['body_ar'] ?? '') : ($contact['body'] ?? '') ?>
                </div>
            </div>
        </div>

        <div class="legal-note">
            <?= icon('info', 'icon', 18) ?>
            <span><?= e(t('note.no_database')) ?></span>
        </div>
    </div>
</section>

<?php
echo cta_band();
require __DIR__ . '/includes/footer.php';