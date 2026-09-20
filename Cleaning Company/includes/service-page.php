<?php
/**
 * =====================================================================
 *  SERVICE DETAIL PAGE TEMPLATE
 * =====================================================================
 *  Renders a complete service page from /data/services/<slug>.php.
 *  Every service page in /services/ just sets $serviceSlug and includes
 *  this file, so content stays unique while the layout stays consistent.
 *
 *  Sections: hero · problems · solution · what's included ·
 *  process · why choose us · good to know · before/after · area coverage ·
 *  FAQ · related services · final CTA
 * =====================================================================
 */

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/seo.php';        // canonical_url(), alternate_language_urls()
require_once __DIR__ . '/schema.php';     // schema_service(), schema_render()
require_once __DIR__ . '/not-found.php';  // not_found() for unresolved slugs

if (!isset($serviceSlug) || !is_string($serviceSlug) || $serviceSlug === '') {
    http_response_code(404);
    $page = ['slug' => '404', 'title' => t('notfound.title'), 'robots' => 'noindex, follow'];
    require __DIR__ . '/header.php';
    echo not_found();
    require __DIR__ . '/footer.php';
    exit;
}

$service = service($serviceSlug);
if (!$service) {
    http_response_code(404);
    $page = ['slug' => '404', 'title' => t('notfound.title'), 'robots' => 'noindex, follow'];
    require __DIR__ . '/header.php';
    echo not_found();
    require __DIR__ . '/footer.php';
    exit;
}

$serviceName = lx($service, 'name', $serviceSlug);
$categoryKey = (string) ($service['category'] ?? 'residential');
$categories  = service_categories();
$category    = $categories[$categoryKey] ?? [];
$waMessage   = whatsapp_service_message($serviceName);

/* FAQ items (service specific, with a fallback to the generic set) */
$faqItems = [];
foreach ((array) ($service['faq'] ?? []) as $item) {
    if (!empty($item['q']) && !empty($item['a'])) {
        $faqItems[] = $item;
    }
}

/* Process + reasons: service specific or the shared defaults */
$process = (array) ($service['process'] ?? data('services')['default_process'] ?? []);
$reasons = (array) ($service['why'] ?? data('services')['default_why'] ?? []);

/* Before / after examples exist for these categories */
$beforeAfter = (array) data('before-after')['items'] ?? [];

$page = [
    'slug'    => 'service-' . $serviceSlug,
    'path'    => '/services/' . $serviceSlug . '.php',
    'title'   => lx($service, 'meta_title', $serviceName . ' in Kuwait | ' . COMPANY_NAME),
    'description' => lx($service, 'meta_description', ''),
    'keywords' => lx($service, 'keywords', ''),
    'image'   => (string) ($service['image'] ?? '/assets/images/og-cover.webp'),
    'image_alt' => lx($service, 'image_alt', $serviceName . ' in Kuwait'),
    'og_type' => 'article',
    'body_class' => 'page-service page-service--' . $serviceSlug,
    'preload_image' => (string) ($service['image'] ?? ''),
    'scripts' => ['/assets/js/before-after.js'],
    'faq'     => $faqItems,
    'schema'  => [schema_service($service, $serviceSlug)],
    'breadcrumbs' => array_filter([
        t('common.home') => url('/'),
        t('nav.services') => url('/services.php'),
        lx($category, 'name', t('category.' . $categoryKey)) => url((string) ($category['url'] ?? '/services.php')),
        $serviceName => '',
    ]),
];

require __DIR__ . '/header.php';

/* Hero content for this service */
$hero = [
    'eyebrow'   => lx($category, 'name', t('category.' . $categoryKey)),
    'title'     => $serviceName . ' in Kuwait',
    'text'      => lx($service, 'hero_intro', lx($service, 'short', '')),
    'image'     => (string) ($service['image'] ?? ''),
    'image_alt' => lx($service, 'image_alt', $serviceName . ' in Kuwait'),
    'whatsapp'  => $waMessage,
    'eager'     => true,
    'points'    => array_slice((array) ($service['includes'] ?? []), 0, 3),
];
require __DIR__ . '/page-hero.php';

/* ---------------- 3. Problems ---------------- */
if (!empty($service['problems'])) : ?>
<section class="section section--muted" aria-labelledby="service-problems-title">
    <div class="container">
        <div class="split">
            <div class="split__body">
                <?= section_head([
                    'eyebrow' => t('common.problems'),
                    'title'   => t('service.problems_title'),
                    'level'   => 2,
                ]) ?>
                <ul class="problem-list">
                    <?php foreach ((array) $service['problems'] as $problem) : ?>
                        <li class="problem-list__item reveal">
                            <?= icon('alert', 'problem-list__icon', 20) ?>
                            <span><?= e((string) $problem) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <aside class="split__aside reveal">
                <div class="aside-card">
                    <h3 class="aside-card__title"><?= e(t('service.cta_title')) ?></h3>
                    <p class="aside-card__text"><?= e(t('home.hero_card_text')) ?></p>
                    <?= wa_button($waMessage, t('cta.whatsapp_us'), 'whatsapp') ?>
                    <?= call_button(t('cta.call_now'), 'outline') ?>
                </div>
            </aside>
        </div>
    </div>
</section>
<?php endif; ?>

<?php /* ---------------- 4. Our solution ---------------- */ ?>
<?php if (!empty($service['solutions'])) : ?>
<section class="section" aria-labelledby="service-solution-title">
    <div class="container">
        <?= section_head([
            'eyebrow' => t('common.solution'),
            'title'   => t('service.solution_title') . ' – ' . $serviceName,
            'level'   => 2,
        ]) ?>
        <div class="card-grid grid-3">
            <?php foreach ((array) $service['solutions'] as $index => $solution) : ?>
                <article class="info-card reveal">
                    <span class="info-card__icon"><?= icon(['check-circle', 'shield', 'tools'][$index % 3], 'icon', 26) ?></span>
                    <p class="info-card__text"><?= e((string) $solution) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php /* ---------------- 5. What is included ---------------- */ ?>
<?php if (!empty($service['includes'])) : ?>
<section class="section section--muted" aria-labelledby="service-included-title">
    <div class="container">
        <div class="split split--wide">
            <div class="split__body">
                <?= section_head([
                    'eyebrow' => t('common.included'),
                    'title'   => t('service.included_title'),
                    'level'   => 2,
                ]) ?>
                <?= check_list((array) $service['includes'], 'check-list--two-col') ?>
            </div>
            <div class="split__aside">
                <?php if (!empty($service['duration'])) : ?>
                <div class="aside-card aside-card--light reveal">
                    <h3 class="aside-card__title"><?= icon('clock', 'icon', 20) ?><?= e(t('common.duration')) ?></h3>
                    <p class="aside-card__text"><?= e((string) $service['duration']) ?></p>
                </div>
                <?php endif; ?>
                <?php if (!empty($service['surfaces'])) : ?>
                <div class="aside-card aside-card--light reveal">
                    <h3 class="aside-card__title"><?= icon('sparkle', 'icon', 20) ?><?= e(t('common.surfaces')) ?></h3>
                    <?= check_list((array) $service['surfaces']) ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php /* ---------------- 6. Process ---------------- */ ?>
<section class="section" aria-labelledby="service-process-title">
    <div class="container">
        <?= section_head([
            'eyebrow' => t('common.process'),
            'title'   => t('service.process_title'),
            'lead'    => t('home.process_title'),
            'level'   => 2,
            'align'   => 'center',
        ]) ?>
        <?= numbered_steps(array_slice($process, 0, 6)) ?>
    </div>
</section>

<?php /* ---------------- 7. Why choose us ---------------- */ ?>
<section class="section section--muted" aria-labelledby="service-why-title">
    <div class="container">
        <?= section_head([
            'eyebrow' => t('home.why_eyebrow'),
            'title'   => t('service.why_title', ['service' => $serviceName]),
            'level'   => 2,
            'align'   => 'center',
        ]) ?>
        <?= feature_cards(array_slice($reasons, 0, 6)) ?>
        <p class="section-cta">
            <?= btn(['label' => t('cta.learn_more'), 'href' => url('/why-choose-us.php'), 'variant' => 'ghost', 'icon' => 'arrow-right', 'icon_pos' => 'right']) ?>
        </p>
    </div>
</section>

<?php /* ---------------- 8. Good to know (prepare) ---------------- */ ?>
<?php if (!empty($service['prepare'])) : ?>
<section class="section" aria-labelledby="service-prepare-title">
    <div class="container">
        <div class="split">
            <div class="split__body">
                <?= section_head([
                    'eyebrow' => t('common.good_to_know'),
                    'title'   => t('common.prepare'),
                    'level'   => 2,
                ]) ?>
                <?= check_list((array) $service['prepare']) ?>
            </div>
            <div class="split__aside reveal">
                <?php
                $relatedBa = null;
                foreach ($beforeAfter as $baItem) {
                    if (($baItem['service'] ?? '') === $serviceSlug) {
                        $relatedBa = $baItem;
                        break;
                    }
                }
                ?>
                <?php if ($relatedBa) : ?>
                    <?= before_after($relatedBa) ?>
                <?php else : ?>
                    <div class="media-card reveal">
                        <?= img_tag([
                            'src'        => (string) ($service['image'] ?? '/assets/images/og-cover.webp'),
                            'alt'        => lx($service, 'image_alt', $serviceName . ' in Kuwait'),
                            'responsive' => true,
                            'sizes'      => '(max-width: 899px) 92vw, 520px',
                        ]) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php /* ---------------- 9. Area coverage ---------------- */ ?>
<section class="section section--tight" aria-labelledby="service-areas-title">
    <div class="container">
        <?= section_head([
            'title' => t('service.areas_title'),
            'lead'  => t('home.areas_lead'),
            'level' => 2,
        ]) ?>
        <ul class="chip-list">
            <?php foreach (areas() as $areaSlug => $areaRow) : ?>
                <li>
                    <a class="chip" href="<?= e_url(area_url($areaSlug)) ?>">
                        <?= icon('map-pin', 'chip__icon', 16) ?><?= e(lx($areaRow, 'name', $areaSlug)) ?>
                    </a>
                </li>
            <?php endforeach; ?>
            <li>
                <a class="chip chip--accent" href="<?= e_url(url('/service-areas.php')) ?>">
                    <?= icon('arrow-right', 'chip__icon', 16) ?><?= e(t('cta.view_all_areas')) ?>
                </a>
            </li>
        </ul>
    </div>
</section>

<?php /* ---------------- 10. FAQ ---------------- */ ?>
<?php if ($faqItems) : ?>
<section class="section section--muted" aria-labelledby="service-faq-title">
    <div class="container container--narrow">
        <?= section_head([
            'eyebrow' => t('nav.faq'),
            'title'   => t('service.faq_title'),
            'lead'    => t('faq.hero_text'),
            'level'   => 2,
            'align'   => 'center',
        ]) ?>
        <?= accordion($faqItems, 'service-faq-' . $serviceSlug, true) ?>
        <p class="section-cta">
            <?= btn(['label' => t('cta.read_faqs'), 'href' => url('/faq.php'), 'variant' => 'ghost', 'icon' => 'arrow-right', 'icon_pos' => 'right']) ?>
        </p>
    </div>
</section>
<?php endif; ?>

<?php /* ---------------- 11. Related services + internal links ---------------- */ ?>
<section class="section" aria-labelledby="service-related-title">
    <div class="container">
        <?= section_head([
            'title' => t('service.related_title'),
            'level' => 2,
        ]) ?>
        <div class="card-grid grid-4">
            <?php foreach (related_services($serviceSlug, 4) as $relatedSlug => $relatedRow) : ?>
                <?php
                $relatedLabel = lx($relatedRow, 'name', $relatedSlug);
                ?>
                <article class="mini-card reveal">
                    <h3 class="mini-card__title">
                        <a href="<?= e_url(service_url($relatedSlug)) ?>"><?= e($relatedLabel) ?></a>
                    </h3>
                    <p class="mini-card__text"><?= e(lx($relatedRow, 'short', '')) ?></p>
                    <div class="mini-card__actions">
                        <?= btn(['label' => t('cta.view_service'), 'href' => service_url($relatedSlug), 'variant' => 'ghost', 'icon' => 'arrow-right', 'icon_pos' => 'right', 'class' => 'btn--sm']) ?>
                        <?= wa_button(whatsapp_service_message($relatedLabel), t('cta.whatsapp_us'), 'whatsapp', ['class' => 'btn--sm']) ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <?= related_links([
            t('common.explore') . ' – ' . lx($category, 'name', t('category.' . $categoryKey)) => url((string) ($category['url'] ?? '/services.php')),
            t('cta.view_all_services')      => url('/services.php'),
            t('nav.all_areas')              => url('/service-areas.php'),
            t('footer.privacy')             => url('/privacy-policy.php'),
            t('nav.contact')                => url('/contact.php'),
        ], t('common.quick_links')) ?>
    </div>
</section>

<?php
/* ---------------- 12. Final CTA ---------------- */
echo cta_band([
    'title'            => t('service.cta_title'),
    'text'             => t('service.cta_text', ['service' => $serviceName]),
    'whatsapp_message' => $waMessage,
]);

require __DIR__ . '/footer.php';