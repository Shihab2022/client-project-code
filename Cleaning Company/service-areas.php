<?php
/**
 * SERVICE AREAS PAGE
 */

require __DIR__ . '/includes/bootstrap.php';

$areasList = areas();
$areaCount = count($areasList);

$page = [
    'slug'        => 'service-areas',
    'path'        => '/service-areas.php',
    'title'       => 'Service Areas in Kuwait — Cleaning Company Coverage | ' . COMPANY_NAME,
    'description' => 'We provide residential and commercial cleaning across many districts in Kuwait. Browse the areas we cover, from Kuwait City and Salmiya to Hawally, Farwaniya, Ahmadi and more.',
    'keywords'    => 'cleaning services Kuwait areas, cleaning company Kuwait districts, villa cleaning Kuwait City, apartment cleaning Salmiya, office cleaning Hawally',
    'image'       => '/assets/images/service-areas.webp',
    'image_alt'   => 'Map of Kuwait cleaning service areas',
    'body_class'  => 'page-areas',
    'breadcrumbs' => [
        t('common.home') => url('/'),
        t('nav.areas')   => '',
    ],
];

require __DIR__ . '/includes/header.php';

$hero = [
    'eyebrow'   => t('areas.hero_eyebrow'),
    'title'     => t('areas.hero_title'),
    'text'      => t('areas.hero_text'),
    'image'     => '/assets/images/service-areas.webp',
    'image_alt' => 'Map of Kuwait cleaning service areas',
    'whatsapp'  => whatsapp_quote_message(),
];
require __DIR__ . '/includes/page-hero.php';
?>

<section class="section" aria-labelledby="areas-grid-title">
    <div class="container">
        <?= section_head([
            'title' => t('areas.grid_title'),
            'level' => 2,
        ]) ?>
        <div class="areas-grid">
            <?php foreach ($areasList as $slug => $area): ?>
                <div class="area-card reveal">
                    <a class="area-card__link" href="<?= e_url(area_url($slug)) ?>" aria-label="<?= e(lx($area, 'name', $slug)) ?> — <?= e(t('nav.areas')) ?>">
                        <span class="area-card__icon"><?= icon('map-pin', 'icon', 22) ?></span>
                        <span class="area-card__name"><?= e(lx($area, 'name', $slug)) ?></span>
                        <span class="area-card__governorate"><?= e(lx($area, 'governorate', COMPANY_CITY)) ?></span>
                        <span class="area-card__arrow"><?= icon('arrow-right', 'icon', 18) ?></span>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <p class="areas-note"><?= icon('info', 'icon', 18) ?> <?= e(t('areas.note')) ?></p>
        <div class="areas-cta">
            <p class="areas-cta__text"><?= e(t('areas.cta')) ?></p>
            <?= wa_button(whatsapp_quote_message(), t('cta.whatsapp_us'), 'whatsapp') ?>
            <?= call_button(t('cta.call_now'), 'outline') ?>
        </div>
        <?= related_links([
            t('nav.residential') => url('/residential-cleaning.php'),
            t('nav.commercial')  => url('/commercial-cleaning.php'),
            t('nav.specialised') => url('/specialized-cleaning.php'),
            t('nav.contact')     => url('/contact.php'),
        ], t('common.related_pages')) ?>
    </div>
</section>

<?php
echo cta_band();
require __DIR__ . '/includes/footer.php';