<?php
/**
 * Shared renderer for the three category pages:
 * residential-cleaning.php · commercial-cleaning.php · specialized-cleaning.php
 * Set $categoryPage['key'|'title'|'description'|'body_class'] and include.
 */

require_once __DIR__ . '/bootstrap.php';

$categoryKey = (string) ($categoryPage['key'] ?? 'residential');
$categories  = service_categories();
$category    = $categories[$categoryKey] ?? [];

$page = [
    'slug'        => 'category-' . $categoryKey,
    'path'        => '/' . ($categoryPage['file'] ?? $categoryKey . '.php'),
    'title'       => (string) ($categoryPage['title'] ?? t('category.' . $categoryKey) . ' in Kuwait | ' . COMPANY_NAME),
    'description' => (string) ($categoryPage['description'] ?? lx($category, 'description', '')),
    'keywords'    => (string) ($categoryPage['keywords'] ?? ''),
    'image'       => '/assets/images/og-cover.webp',
    'body_class'  => 'page-category page-category--' . $categoryKey,
    'breadcrumbs' => [
        t('common.home')  => url('/'),
        t('nav.services') => url('/services.php'),
        lx($category, 'name', ucfirst($categoryKey)) => '',
    ],
];

require __DIR__ . '/header.php';

$hero = [
    'eyebrow'  => t(($categoryPage['eyebrow_key'] ?? 'services.hero_eyebrow')),
    'title'    => t(($categoryPage['hero_key'] ?? 'services.hero_title')),
    'text'     => t(($categoryPage['text_key'] ?? 'services.hero_text')),
    'whatsapp' => t('wa.' . ($categoryKey === 'commercial' ? 'commercial_message' : ($categoryKey === 'specialised' ? 'specialized_message' : 'residential_message'))),
    'points'   => [
        (string) (count(services_by_category($categoryKey))) . ' services in this category',
        'Trained teams with the right equipment for the job',
        'WhatsApp or phone contact with a real person',
    ],
];
require __DIR__ . '/page-hero.php';

$otherCategories = array_filter(service_categories(), static fn($key) => $key !== $categoryKey, ARRAY_FILTER_USE_KEY);
$waCategoryMessage = $hero['whatsapp'];
?>

<section class="section" aria-labelledby="cat-services-title">
    <div class="container">
        <?= section_head([
            'title' => lx($category, 'name', t('category.' . $categoryKey)),
            'lead'  => lx($category, 'description', t('services.hero_text')),
            'level' => 2,
        ]) ?>
        <div class="card-grid grid-3">
            <?php foreach (services_by_category($categoryKey) as $serviceSlug => $serviceRow) : ?>
                <?php echo service_card($serviceSlug); ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php /* Category specific detail sections (residential / commercial / specialised) */
$details = (array) ($categoryPage['details'] ?? []);
foreach ($details as $detail) :
    ?>
<section class="section<?= !empty($detail['muted']) ? ' section--muted' : '' ?>" aria-labelledby="detail-<?= e(preg_replace('/[^a-z0-9]+/i', '-', (string) $detail['title'])) ?>">
    <div class="container">
        <?= section_head([
            'eyebrow' => (string) ($detail['eyebrow'] ?? ''),
            'title'   => (string) $detail['title'],
            'lead'    => (string) ($detail['lead'] ?? ''),
            'level'   => 2,
        ]) ?>
        <?php if (!empty($detail['cards'])) : ?>
            <?= feature_cards((array) $detail['cards']) ?>
        <?php endif; ?>
        <?php if (!empty($detail['checks'])) : ?>
            <?= check_list((array) $detail['checks'], 'check-list--two-col') ?>
        <?php endif; ?>
    </div>
</section>
<?php endforeach; ?>

<?php /* Process */ ?>
<section class="section" aria-labelledby="cat-process-title">
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

<?php /* Why choose us (category specific) */
$whyCards = (array) ($categoryPage['why'] ?? []);
if ($whyCards) :
?>
<section class="section section--muted" aria-labelledby="cat-why-title">
    <div class="container">
        <?= section_head([
            'title' => t('home.why_title'),
            'level' => 2,
            'align' => 'center',
        ]) ?>
        <?= feature_cards($whyCards) ?>
        <p class="section-cta">
            <?= btn(['label' => t('nav.why'), 'href' => url('/why-choose-us.php'), 'variant' => 'ghost', 'icon' => 'arrow-right', 'icon_pos' => 'right']) ?>
        </p>
    </div>
</section>
<?php endif; ?>

<?php /* Areas + other categories + internal links */ ?>
<section class="section" aria-labelledby="cat-links-title">
    <div class="container">
        <?= section_head([
            'title' => t('nav.all_areas'),
            'lead'  => t('home.areas_lead'),
            'level' => 2,
        ]) ?>
        <div class="area-grid">
            <?php foreach (array_keys(areas()) as $areaSlug) : ?>
                <?php echo area_card($areaSlug); ?>
            <?php endforeach; ?>
        </div>
        <p class="section-cta">
            <?= btn(['label' => t('cta.view_all_areas'), 'href' => url('/service-areas.php'), 'variant' => 'ghost', 'icon' => 'arrow-right', 'icon_pos' => 'right']) ?>
        </p>

        <?= related_links(
            array_merge(
                [t('nav.services') => url('/services.php')],
                array_map(static fn($row) => url((string) $row['url']), $otherCategories),
                [
                    t('nav.contact')   => url('/contact.php'),
                    t('footer.privacy') => url('/privacy-policy.php'),
                ]
            ),
            t('common.quick_links')
        ) ?>
    </div>
</section>

<?php
echo cta_band([
    'title'            => t('cta.band_commercial'),
    'text'             => t('cta.band_text'),
        'whatsapp_message' => $waCategoryMessage,
]);

require __DIR__ . '/footer.php';