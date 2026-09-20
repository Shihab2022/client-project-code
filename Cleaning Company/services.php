<?php
/**
 * SERVICES OVERVIEW — the single page for all 30 services.
 * One Services tab in the navigation; Residential / Commercial /
 * Specialised live here as anchor sections instead of separate pages.
 */

require __DIR__ . '/includes/bootstrap.php';

$page = [
    'slug'        => 'services',
    'path'        => '/services.php',
    'title'       => 'Cleaning Services in Kuwait | ' . COMPANY_NAME,
    'description' => 'All cleaning services in ' . COMPANY_NAME . ': villa, apartment, deep, sofa, carpet, kitchen, office, shop, facade and post-construction cleaning across Kuwait.',
    'keywords'    => 'cleaning services Kuwait, cleaning company in Kuwait, deep cleaning Kuwait, sofa cleaning Kuwait',
    'image'       => '/assets/images/og-cover.webp',
    'body_class'  => 'page-services',
    'breadcrumbs' => [
        t('common.home')  => url('/'),
        t('nav.services') => '',
    ],
];

require __DIR__ . '/includes/header.php';

$hero = [
    'eyebrow'  => t('services.hero_eyebrow'),
    'title'    => t('services.hero_title'),
    'text'     => t('services.hero_text'),
    'whatsapp' => whatsapp_quote_message(),
    'points'   => [
        t('services.point_1'),
        t('services.point_2'),
        t('services.point_3'),
    ],
];
require __DIR__ . '/includes/page-hero.php';
?>

<?php /* Category quick-jump + short intro about the three service families */ ?>
<section class="section section--tight" aria-labelledby="services-intro-title">
    <div class="container">
        <?= section_head([
            'eyebrow' => t('nav.services'),
            'title'   => t('services.intro_title'),
            'lead'    => t('services.intro_text'),
            'level'   => 2,
        ]) ?>
        <nav class="category-jump" aria-label="<?= e(t('services.jump_title')) ?>">
            <ul class="category-jump__list">
                <?php foreach (service_categories() as $categoryKey => $category) : ?>
                    <li>
                        <a class="category-jump__link" href="#<?= e($categoryKey) ?>">
                            <?= icon($category['icon'] ?? 'sparkle', 'icon', 18) ?>
                            <span><?= e(lx($category, 'name', ucfirst($categoryKey))) ?></span>
                            <span class="category-jump__count"><?= e((string) count(services_by_category((string) $categoryKey))) ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </div>
</section>

<?php foreach (service_categories() as $categoryKey => $category) :
    ?>
<section class="section<?= $categoryKey !== 'residential' ? ' section--muted' : '' ?> category-section" id="<?= e($categoryKey) ?>" aria-labelledby="cat-<?= e($categoryKey) ?>-title">
    <div class="container">
        <div class="service-section-head">
            <?= section_head([
                'eyebrow' => lx($category, 'short_name', ucfirst($categoryKey)),
                'title'   => lx($category, 'name', ucfirst($categoryKey)),
                'lead'    => lx($category, 'description', ''),
                'level'   => 2,
            ]) ?>
        </div>
        <div class="card-grid grid-3">
            <?php foreach (services_by_category($categoryKey) as $serviceSlug => $serviceRow) : ?>
                <?php echo service_card($serviceSlug); ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endforeach; ?>

<?php /* Help box: many visitors do not know which service they need */ ?>
<section class="section section--tight" aria-labelledby="services-help-title">
    <div class="container">
        <div class="help-band reveal">
            <span class="help-band__icon"><?= icon('whatsapp', 'icon', 26) ?></span>
            <div class="help-band__body">
                <h2 class="help-band__title" id="services-help-title"><?= e(t('services.help_title')) ?></h2>
                <p class="help-band__text"><?= e(t('services.help_text')) ?></p>
            </div>
            <div class="help-band__actions">
                <?= wa_button(whatsapp_quote_message(), t('cta.whatsapp_us'), 'whatsapp') ?>
                <?= call_button(t('cta.call_now'), 'outline') ?>
            </div>
        </div>
    </div>
</section>

<section class="section" aria-labelledby="services-process-title">
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

<?php
echo cta_band();

require __DIR__ . '/includes/footer.php';