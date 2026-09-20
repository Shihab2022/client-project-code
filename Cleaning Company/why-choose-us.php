<?php
/**
 * WHY CHOOSE US PAGE
 */

require __DIR__ . '/includes/bootstrap.php';

$page = [
    'slug'        => 'why-choose-us',
    'path'        => '/why-choose-us.php',
    'title'       => 'Why Choose Us — Professional Cleaning Services in Kuwait | ' . COMPANY_NAME,
    'description' => 'Discover why homes and businesses across Kuwait trust ' . COMPANY_NAME . ' for residential, commercial and specialised cleaning: trained teams, proper equipment, written checklists and quality checks.',
    'keywords'    => 'cleaning company Kuwait, why choose cleaning company Kuwait, professional cleaners Kuwait, trusted cleaning services Kuwait',
    'image'       => '/assets/images/about-team.webp',
    'image_alt'   => 'Professional cleaning team at work in Kuwait',
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
    'image_alt' => 'Professional cleaning team at work in Kuwait',
    'whatsapp'  => whatsapp_quote_message(),
];
require __DIR__ . '/includes/page-hero.php';
?>

<section class="section" aria-labelledby="why-reasons-title">
    <div class="container">
        <?= section_head([
            'eyebrow' => t('why.hero_eyebrow'),
            'title'   => t('why.reasons_title'),
            'level'   => 2,
        ]) ?>
        <div class="reason-grid">
            <?php foreach (trust_points() as $point): ?>
                <div class="reason-card reveal">
                    <span class="reason-card__icon"><?= icon($point['icon'], 'icon', 28) ?></span>
                    <h3 class="reason-card__title"><?= e($point['title']) ?></h3>
                    <p class="reason-card__text"><?= e($point['text']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section--dark" aria-labelledby="why-stats-title">
    <div class="container">
        <?= section_head([
            'title' => t('stats.title'),
            'level' => 2,
            'align' => 'center',
        ]) ?>
        <p class="section-lead"><?= e(t('stats.subtitle')) ?></p>
        <?php echo stats_block(); ?>
    </div>
</section>

<section class="section" aria-labelledby="why-clients-title">
    <div class="container">
        <?= section_head([
            'title' => t('about.why_title'),
            'level' => 2,
            'align' => 'center',
        ]) ?>
        <?= feature_cards(array_slice(trust_points(), 0, 6), 'grid-3 reveal') ?>
    </div>
</section>

<?php
echo cta_band();
require __DIR__ . '/includes/footer.php';