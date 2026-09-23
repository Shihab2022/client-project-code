<?php
/**
 * ABOUT PAGE
 * Story, mission, vision, values, team, equipment, quality promise,
 * statistics, why customers choose us and a final CTA.
 * All copy comes from /lang so the Arabic page is fully translated.
 */

require __DIR__ . '/includes/bootstrap.php';

$aboutTeamAlt = alt_text(
    'Cleaning team of ' . COMPANY_NAME . ' in Kuwait',
    'فريق التنظيف التابع لـ ' . COMPANY_NAME . ' في الكويت'
);
$aboutImage = project_image('about-page');

$page = [
    'slug'        => 'about',
    'path'        => '/about.php',
    'title'       => 'About Us | ' . COMPANY_NAME . ' – Cleaning Services in Kuwait',
    'description' => 'Learn about ' . COMPANY_NAME . ': our story, trained cleaning teams, equipment, quality checks and how we work with homes and businesses across Kuwait.',
    'keywords'    => 'about cleaning company Kuwait, cleaning company Kuwait, professional cleaners Kuwait',
    'image'       => $aboutImage,
    'image_alt'   => $aboutTeamAlt,
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
    'image'     => $aboutImage,
    'image_alt' => $aboutTeamAlt,
    'whatsapp'  => whatsapp_quote_message(),
    'eager'     => true,
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
                <p><?= e(t('about.story_p1')) ?></p>
                <p><?= e(t('about.story_p2')) ?></p>
            </div>
            <div class="split__aside">
                <div class="media-card reveal">
                    <?= img_tag([
                        'src'        => project_image('about-story'),
                        'alt'        => $aboutTeamAlt,
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
                <p class="info-card__text"><?= e(t('about.mission_text')) ?></p>
            </article>
            <article class="info-card reveal">
                <span class="info-card__icon"><?= icon('award', 'icon', 26) ?></span>
                <h2 class="info-card__title"><?= e(t('about.vision_title')) ?></h2>
                <p class="info-card__text"><?= e(t('about.vision_text')) ?></p>
            </article>
        </div>
    </div>
</section>

<section class="section" aria-labelledby="about-values-title">
    <div class="container">
        <?= section_head([
            'title' => t('about.values_title'),
            'lead'  => t('about.values_lead'),
            'level' => 2,
        ]) ?>
        <div class="card-grid grid-3">
            <?php
            $values = [
                ['quality', 'about.value_1_title', 'about.value_1_text'],
                ['shield', 'about.value_2_title', 'about.value_2_text'],
                ['users', 'about.value_3_title', 'about.value_3_text'],
                ['leaf', 'about.value_4_title', 'about.value_4_text'],
                ['check-circle', 'about.value_5_title', 'about.value_5_text'],
                ['award', 'about.value_6_title', 'about.value_6_text'],
            ];
            foreach ($values as [$icon, $titleKey, $textKey]) :
                ?>
                <article class="info-card reveal">
                    <span class="info-card__icon"><?= icon($icon, 'icon', 26) ?></span>
                    <h3 class="info-card__title"><?= e(t($titleKey)) ?></h3>
                    <p class="info-card__text"><?= e(t($textKey)) ?></p>
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
                    t('about.team_point_1'),
                    t('about.team_point_2'),
                    t('about.team_point_3'),
                    t('about.team_point_4'),
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
            'lead'  => t('about.why_lead'),
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