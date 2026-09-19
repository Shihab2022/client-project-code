<?php
/**
 * SERVICES OVERVIEW — all services grouped by category with internal links.
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
    'points'   => ['30 cleaning services in three categories', 'Every service has its own detailed page', 'Available across the districts listed on our areas page'],
];
require __DIR__ . '/includes/page-hero.php';

foreach (service_categories() as $categoryKey => $category) :
    ?>
<section class="section<?= $categoryKey !== 'residential' ? ' section--muted' : '' ?>" id="<?= e($categoryKey) ?>" aria-labelledby="cat-<?= e($categoryKey) ?>-title">
    <div class="container">
        <div class="service-section-head">
            <?= section_head([
                'eyebrow' => lx($category, 'short_name', ucfirst($categoryKey)),
                'title'   => lx($category, 'name', ucfirst($categoryKey)),
                'lead'    => lx($category, 'description', ''),
                'level'   => 2,
            ]) ?>
            <?= btn(['label' => t('cta.view_all_services'), 'href' => url((string) $category['url']), 'variant' => 'ghost', 'icon' => 'arrow-right', 'icon_pos' => 'right', 'class' => 'btn--sm']) ?>
        </div>
        <div class="card-grid grid-3">
            <?php foreach (services_by_category($categoryKey) as $serviceSlug => $serviceRow) : ?>
                <?php echo service_card($serviceSlug); ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endforeach; ?>

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