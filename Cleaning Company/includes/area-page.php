<?php
/**
 * =====================================================================
 *  AREA PAGE TEMPLATE  (Kuwait districts)
 * =====================================================================
 *  Renders a local SEO page for one district from /data/areas.php.
 *  Every file in /areas/ sets $areaSlug and includes this template.
 * =====================================================================
 */

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/not-found.php';  // not_found() for unknown area slugs

$area = isset($areaSlug) && is_string($areaSlug) ? area($areaSlug) : null;
if (!$area) {
    http_response_code(404);
    $page = ['slug' => '404', 'title' => t('notfound.title'), 'robots' => 'noindex, follow'];
    require __DIR__ . '/header.php';
    echo not_found();
    require __DIR__ . '/footer.php';
    exit;
}

$areaFullName = lx($area, 'name', $areaSlug);
$governorate  = lx($area, 'governorate', COMPANY_CITY);
$waMessage    = t('wa.area_page_message', ['area' => $areaFullName]);

$areaFaq = [];
foreach ((array) ($area['faq'] ?? []) as $item) {
    if (!empty($item['q']) && !empty($item['a'])) {
        $areaFaq[] = $item;
    }
}

/* Services highlighted for this district, plus the rest of the catalogue */
$popularSlugs = array_values(array_filter((array) ($area['popular'] ?? []), static fn($s) => (bool) service($s)));
$popular      = $popularSlugs ?: array_slice(array_keys(services()), 0, 4);

$page = [
    'slug'        => 'area-' . $areaSlug,
    'path'        => '/areas/' . $areaSlug . '.php',
    'title'       => lx($area, 'meta_title', t('areas.local_title', ['area' => $areaFullName])),
    'description' => lx($area, 'meta_description', ''),
    'image'       => (string) ($area['image'] ?? '/assets/images/og-cover.webp'),
    'image_alt'   => lx($area, 'image_alt', 'Cleaning services in ' . $areaFullName . ', Kuwait'),
    'og_type'     => 'article',
    'body_class'  => 'page-area page-area--' . $areaSlug,
    'faq'         => $areaFaq,
    'breadcrumbs' => array_filter([
        t('common.home')      => url('/'),
        t('nav.areas')        => url('/service-areas.php'),
        $areaFullName         => '',
    ]),
];

require __DIR__ . '/header.php';
require __DIR__ . '/breadcrumbs.php';

$hero = [
    'eyebrow'   => t('areas.governorate') . ': ' . $governorate,
    'title'     => t('areas.local_title', ['area' => $areaFullName]),
    'text'      => lx($area, 'intro', t('areas.hero_text')),
    'image'     => (string) ($area['image'] ?? ''),
    'image_alt' => lx($area, 'image_alt', 'Cleaning services in ' . $areaFullName . ', Kuwait'),
    'whatsapp'  => $waMessage,
    'eager'     => true,
    'points'    => array_slice((array) ($area['features'] ?? []), 0, 3),
];
require __DIR__ . '/page-hero.php';

/* ---------------- Local content ---------------- */
if (!empty($area['about'])) : ?>
<section class="section" aria-labelledby="area-about-title">
    <div class="container">
        <div class="split">
            <div class="split__body">
                <?= section_head([
                    'eyebrow' => t('nav.areas'),
                    'title'   => t('areas.district_info', ['area' => $areaFullName]),
                    'lead'    => (string) $area['about'],
                    'level'   => 2,
                ]) ?>
                <?php if (!empty($area['features'])) : ?>
                    <?= check_list((array) $area['features']) ?>
                <?php endif; ?>
            </div>
            <aside class="split__aside reveal">
                <div class="aside-card">
                    <h3 class="aside-card__title"><?= e(t('cta.get_quote')) ?></h3>
                    <p class="aside-card__text"><?= e(t('home.hero_card_text')) ?></p>
                    <?= wa_button($waMessage, t('cta.whatsapp_us'), 'whatsapp') ?>
                    <?= call_button(t('cta.call_now'), 'outline') ?>
                </div>
            </aside>
        </div>
    </div>
</section>
<?php endif; ?>

<?php /* ---------------- Services available in this area ---------------- */ ?>
<section class="section section--muted" aria-labelledby="area-services-title">
    <div class="container">
        <?= section_head([
            'eyebrow' => t('nav.services'),
            'title'   => t('areas.services_available', ['area' => $areaFullName]),
            'lead'    => t('services.hero_text'),
            'level'   => 2,
        ]) ?>
        <div class="card-grid grid-3">
            <?php foreach ($popular as $serviceSlug) : ?>
                <?php echo service_card($serviceSlug); ?>
            <?php endforeach; ?>
        </div>
        <p class="section-cta">
            <?= btn(['label' => t('cta.view_all_services'), 'href' => url('/services.php'), 'variant' => 'primary', 'icon' => 'arrow-right', 'icon_pos' => 'right']) ?>
        </p>
    </div>
</section>

<?php /* ---------------- Process ---------------- */ ?>
<section class="section" aria-labelledby="area-process-title">
    <div class="container">
        <?= section_head([
            'eyebrow' => t('common.process'),
            'title'   => t('home.process_title'),
            'level'   => 2,
            'align'   => 'center',
        ]) ?>
        <?= numbered_steps((array) (data('services')['default_process'] ?? [])) ?>
    </div>
</section>

<?php /* ---------------- Area FAQ ---------------- */ ?>
<?php if ($areaFaq) : ?>
<section class="section section--muted" aria-labelledby="area-faq-title">
    <div class="container container--narrow">
        <?= section_head([
            'eyebrow' => t('nav.faq'),
            'title'   => t('faq.hero_title'),
            'level'   => 2,
            'align'   => 'center',
        ]) ?>
        <?= accordion($areaFaq, 'area-faq-' . $areaSlug, true) ?>
    </div>
</section>
<?php endif; ?>

<?php /* ---------------- Nearby areas + internal links ---------------- */ ?>
<section class="section" aria-labelledby="area-nearby-title">
    <div class="container">
        <?= section_head([
            'title' => t('nav.all_areas'),
            'level' => 2,
        ]) ?>
        <div class="area-grid">
            <?php
            $otherAreas = array_filter(areas(), static fn($slug) => $slug !== $areaSlug, ARRAY_FILTER_USE_KEY);
            foreach (array_slice($otherAreas, 0, 12, true) as $otherSlug => $otherRow) :
                echo area_card($otherSlug);
            endforeach;
            ?>
        </div>
        <p class="section-cta">
            <?= btn(['label' => t('cta.view_all_areas'), 'href' => url('/service-areas.php'), 'variant' => 'ghost', 'icon' => 'arrow-right', 'icon_pos' => 'right']) ?>
        </p>
        <?= related_links([
            t('nav.residential')  => url('/residential-cleaning.php'),
            t('nav.commercial')   => url('/commercial-cleaning.php'),
            t('nav.specialised')  => url('/specialized-cleaning.php'),
            t('nav.why')          => url('/why-choose-us.php'),
            t('nav.contact')      => url('/contact.php'),
        ], t('common.quick_links')) ?>
    </div>
</section>

<?php
echo cta_band([
    'title'            => t('cta.band_title'),
    'text'             => t('areas.hero_text'),
    'whatsapp_message' => $waMessage,
]);

require __DIR__ . '/footer.php';