<?php
/**
 * WHY CHOOSE US PAGE — reasons in practice + the six-step process.
 * Copy comes from /lang and /data/trust-points.php (with the Arabic
 * overlay in /data/ar-content.php), so both languages stay in sync.
 */

require __DIR__ . '/includes/bootstrap.php';

$whyTeamAlt = alt_text('Professional cleaning team at work in Kuwait', 'فريق تنظيف محترف أثناء العمل في الكويت');

$page = [
    'slug'        => 'why-choose-us',
    'path'        => '/why-choose-us.php',
    'title'       => 'Why Choose Us — Professional Cleaning Services in Kuwait | ' . COMPANY_NAME,
    'description' => 'Discover why homes and businesses across Kuwait trust ' . COMPANY_NAME . ' for residential, commercial and specialised cleaning: trained teams, proper equipment, written checklists and quality checks.',
    'keywords'    => 'cleaning company Kuwait, why choose cleaning company Kuwait, professional cleaners Kuwait, trusted cleaning services Kuwait',
    'image'       => '/assets/images/about-team.webp',
    'image_alt'   => $whyTeamAlt,
    'body_class'  => 'page-why',
    'breadcrumbs' => [
        t('common.home') => url('/'),
        t('nav.why')     => '',
    ],
];

require __DIR__ . '/includes/header.php';

$hero = [
    'eyebrow'   => t('why.hero_eyebrow'),
    'title'     => t('why.hero_title'),
    'text'      => t('why.hero_text'),
    'image'     => '/assets/images/about-team.webp',
    'image_alt' => $whyTeamAlt,
    'whatsapp'  => whatsapp_quote_message(),
];
require __DIR__ . '/includes/page-hero.php';
?>

<section class="section" aria-labelledby="why-reasons-title">
    <div class="container">
        <?= section_head([
            'eyebrow' => t('why.hero_eyebrow'),
            'title'   => t('why.reasons_title'),
            'lead'    => t('why.lead'),
            'level'   => 2,
        ]) ?>
        <div class="reason-grid">
            <?php $reasonIndex = 0; ?>
            <?php foreach (trust_points() as $point): ?>
                <?php $reasonIndex++; ?>
                <article class="reason-card reveal" style="--reason-index:<?= $reasonIndex ?>">
                    <span class="reason-card__num" aria-hidden="true"><?= str_pad((string) $reasonIndex, 2, '0', STR_PAD_LEFT) ?></span>
                    <span class="reason-card__icon"><?= icon($point['icon'], 'icon', 26) ?></span>
                    <h3 class="reason-card__title"><?= e(lx($point, 'title')) ?></h3>
                    <p class="reason-card__text"><?= e(lx($point, 'text')) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section--muted" aria-labelledby="why-process-title">
    <div class="container">
        <?= section_head([
            'eyebrow' => t('common.process'),
            'title'   => t('why.process_title'),
            'lead'    => t('why.process_lead'),
            'level'   => 2,
            'align'   => 'center',
        ]) ?>
        <?= numbered_steps((array) (data('services')['default_process'] ?? [])) ?>
    </div>
</section>

<section class="section" aria-labelledby="why-clients-title">
    <div class="container">
        <?= section_head([
            'title' => t('home.areas_title'),
            'lead'  => t('home.areas_lead'),
            'level' => 2,
        ]) ?>
        <div class="area-grid">
            <?php foreach (array_slice(array_keys(areas()), 0, 8) as $areaSlug) : ?>
                <?php echo area_card($areaSlug); ?>
            <?php endforeach; ?>
        </div>
        <p class="section-cta">
            <?= btn(['label' => t('cta.view_all_areas'), 'href' => url('/service-areas.php'), 'variant' => 'primary', 'icon' => 'arrow-right', 'icon_pos' => 'right']) ?>
        </p>
    </div>
</section>

<?php
echo cta_band();
require __DIR__ . '/includes/footer.php';