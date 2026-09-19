<?php
/**
 * ABOUT PAGE
 * Story, mission, vision, values, team, equipment, quality promise,
 * statistics, why customers choose us and a final CTA.
 */

require __DIR__ . '/includes/bootstrap.php';

$page = [
    'slug'        => 'about',
    'path'        => '/about.php',
    'title'       => 'About Us | ' . COMPANY_NAME . ' – Cleaning Services in Kuwait',
    'description' => 'Learn about ' . COMPANY_NAME . ': our story, trained cleaning teams, equipment, quality checks and how we work with homes and businesses across Kuwait.',
    'keywords'    => 'about cleaning company Kuwait, cleaning company Kuwait, professional cleaners Kuwait',
    'image'       => '/assets/images/about-team.webp',
    'image_alt'   => 'Cleaning team of ' . COMPANY_NAME . ' in Kuwait',
    'body_class'  => 'page-about',
    'breadcrumbs' => [
        t('common.home') => url('/'),
        t('nav.about')   => '',
    ],
];

require __DIR__ . '/includes/header.php';

$hero = [
    'eyebrow'   => t('about.hero_eyebrow'),
    'title'     => t('about.hero_title'),
    'text'      => t('about.hero_text'),
    'image'     => '/assets/images/about-team.webp',
    'image_alt' => 'Cleaning team of ' . COMPANY_NAME . ' in Kuwait',
    'whatsapp'  => whatsapp_quote_message(),
];
require __DIR__ . '/includes/page-hero.php';
?>

<section class="section" aria-labelledby="about-story-title">
    <div class="container">
        <div class="split">
            <div class="split__body">
                <?= section_head([
                    'eyebrow' => t('about.hero_eyebrow'),
                    'title'   => t('about.story_title'),
                    'level'   => 2,
                ]) ?>
                <p><?= e(COMPANY_NAME) ?> is a cleaning company serving homes and businesses across Kuwait. We built the company around a simple idea: a cleaning visit should be planned, written down, checked and handed back to you properly explained. Every job starts with a short conversation on WhatsApp or by phone, continues with a written task list, and ends with a quality check before the team leaves.</p>
                <p>Our teams are trained on surface-specific methods and on the safe use of cleaning chemicals, so marble, glass, upholstery and bathroom fittings are each treated the way their material requires. We work in English and Arabic, and every customer deals directly with a person from our team rather than an automated booking system.</p>
                <div class="timeline-note reveal">
                    <p><?= icon('info', 'icon', 18) ?> <?= e(t('note.legal_review')) ?></p>
                </div>
            </div>
            <div class="split__aside">
                <div class="media-card reveal">
                    <?= img_tag([
                        'src'        => '/assets/images/about-team.webp',
                        'alt'        => 'Cleaning team of ' . COMPANY_NAME . ' with professional equipment in Kuwait',
                        'responsive' => true,
                        'sizes'      => '(max-width: 899px) 92vw, 460px',
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section--muted" aria-labelledby="about-mission-title">
    <div class="container">
        <div class="card-grid grid-2">
            <article class="info-card reveal">
                <span class="info-card__icon"><?= icon('sun', 'icon', 26) ?></span>
                <h2 class="info-card__title" id="about-mission-title"><?= e(t('about.mission_title')) ?></h2>
                <p class="info-card__text">To give homes and businesses in Kuwait a cleaning service they can plan around: clear scope, trained staff, safe products and a quality check on every visit, so customers know exactly what they are paying for.</p>
            </article>
            <article class="info-card reveal">
                <span class="info-card__icon"><?= icon('award', 'icon', 26) ?></span>
                <h2 class="info-card__title"><?= e(t('about.vision_title')) ?></h2>
                <p class="info-card__text">To be the cleaning company Kuwait customers call first, because the team arrives on time, works carefully inside the property and communicates in a language and manner the customer prefers.</p>
            </article>
        </div>
    </div>
</section>

<section class="section" aria-labelledby="about-values-title">
    <div class="container">
        <?= section_head([
            'title' => t('about.values_title'),
            'lead'  => 'These values decide how our teams behave inside your property and how we handle a problem when something goes wrong.',
            'level' => 2,
        ]) ?>
        <div class="card-grid grid-3">
            <?php
            $values = [
                ['quality', 'Quality', 'The job is finished to the written task list, not to a subjective impression of clean.'],
                ['shield', 'Reliability', 'Confirmed arrival windows, honest answers about availability, and no unexplained delays.'],
                ['users', 'Respect', 'Teams work carefully around furniture, privacy and the routines of the household or business.'],
                ['leaf', 'Safety', 'Products matched to each surface, used at the recommended dilution and rinsed where needed.'],
                ['check-circle', 'Customer satisfaction', 'If something was missed, you tell us and we return to complete it.'],
                ['award', 'Professionalism', 'Briefed teams with a team leader who is accountable for the visit.'],
            ];
            foreach ($values as [$icon, $title, $text]) :
                ?>
                <article class="info-card reveal">
                    <span class="info-card__icon"><?= icon($icon, 'icon', 26) ?></span>
                    <h3 class="info-card__title"><?= e($title) ?></h3>
                    <p class="info-card__text"><?= e($text) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section--muted" aria-labelledby="about-team-title">
    <div class="container">
        <div class="split">
            <div class="split__body">
                <?= section_head([
                    'eyebrow' => t('about.team_title'),
                    'title'   => t('about.team_title'),
                    'lead'    => t('about.team_text'),
                    'level'   => 2,
                ]) ?>
                <?= check_list([
                    'Trained on surface-specific cleaning methods',
                    'Briefed on the safe use of cleaning chemicals',
                    'Supervised by a team leader on every visit',
                    'Working in English and Arabic',
                ]) ?>
            </div>
            <div class="split__aside">
                <div class="aside-card aside-card--light reveal">
                    <h3 class="aside-card__title"><?= icon('tools', 'icon', 20) ?><?= e(t('about.equipment_title')) ?></h3>
                    <p class="aside-card__text"><?= e(t('about.equipment_text')) ?></p>
                    <h3 class="aside-card__title" style="margin-top:.6rem"><?= icon('shield', 'icon', 20) ?><?= e(t('about.quality_title')) ?></h3>
                    <p class="aside-card__text"><?= e(t('about.quality_text')) ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section--dark" aria-labelledby="about-stats-title">
    <div class="container">
        <?= section_head([
            'title' => t('about.stats_title'),
            'level' => 2,
            'align' => 'center',
        ]) ?>
        <?php echo stats_block('dark'); ?>
    </div>
</section>

<section class="section" aria-labelledby="about-why-title">
    <div class="container">
        <?= section_head([
            'title' => t('about.why_title'),
            'level' => 2,
            'align' => 'center',
        ]) ?>
        <?= feature_cards(array_slice(trust_points(), 0, 6)) ?>
        <p class="section-cta">
            <?= btn(['label' => t('nav.why'), 'href' => url('/why-choose-us.php'), 'variant' => 'ghost', 'icon' => 'arrow-right', 'icon_pos' => 'right']) ?>
        </p>
    </div>
</section>

<?php
echo cta_band();

require __DIR__ . '/includes/footer.php';