<?php
/**
 * SERVICE AREAS PAGE
 */

require __DIR__ . '/includes/bootstrap.php';

$areasList = areas();
$areaCount = count($areasList);   // kept for page copy / future use
$areasImage = project_image('service-areas');

$page = [
    'slug'        => 'service-areas',
    'path'        => '/service-areas.php',
    'title'       => 'Service Areas in Kuwait — Cleaning Company Coverage | ' . COMPANY_NAME,
    'description' => 'We provide residential and commercial cleaning across many districts in Kuwait. Browse the areas we cover, from Kuwait City and Salmiya to Hawally, Farwaniya, Ahmadi and more.',
    'keywords'    => 'cleaning services Kuwait areas, cleaning company Kuwait districts, villa cleaning Kuwait City, apartment cleaning Salmiya, office cleaning Hawally',
    'image'       => $areasImage,
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
    'image'     => $areasImage,
    'image_alt' => 'Map of Kuwait cleaning service areas',
    'whatsapp'  => whatsapp_quote_message(),
    'eager'     => true,
];
require __DIR__ . '/includes/page-hero.php';
?>

<section class="section" aria-labelledby="areas-map-title">
    <div class="container">
        <?= section_head([
            'eyebrow' => t('areas.hero_eyebrow'),
            'title'   => t('areas.grid_title'),
            'lead'    => t('areas.map_lead'),
            'level'   => 2,
        ]) ?>
        <?= area_map(['title' => t('areas.map_title')]) ?>
        <p class="areas-note"><?= icon('info', 'icon', 18) ?> <?= e(t('areas.note')) ?></p>
        <div class="areas-cta">
            <p class="areas-cta__text"><?= e(t('areas.cta')) ?></p>
            <?= wa_button(whatsapp_quote_message(), t('cta.whatsapp_us'), 'whatsapp') ?>
            <?= call_button(t('cta.call_now'), 'outline') ?>
        </div>
        <?= related_links([
            t('nav.services') => url('/services.php'),
            t('nav.about')    => url('/about.php'),
            t('nav.why')      => url('/why-choose-us.php'),
            t('nav.contact')  => url('/contact.php'),
        ], t('common.related_pages')) ?>
    </div>
</section>

<?php
echo cta_band();
require __DIR__ . '/includes/footer.php';