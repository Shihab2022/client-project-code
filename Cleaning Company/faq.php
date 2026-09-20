<?php
/**
 * FAQ PAGE
 */

require __DIR__ . '/includes/bootstrap.php';

$lang  = lang();
$activeCat = $_GET['cat'] ?? 'all';
$groups = faq_groups();
$groupKeys = array_keys($groups);

$page = [
    'slug'        => 'faq',
    'path'        => '/faq.php',
    'title'       => 'FAQs — Cleaning Services in Kuwait | ' . COMPANY_NAME,
    'description' => 'Frequently asked questions about residential, commercial and specialised cleaning services in Kuwait. Find answers about our process, products, areas, scheduling and contact options.',
    'keywords'    => 'cleaning FAQ Kuwait, cleaning questions Kuwait, villa cleaning FAQ Kuwait, office cleaning FAQ Kuwait, deep cleaning FAQ Kuwait',
    'image'       => '/assets/images/services/deep-cleaning.webp',
    'image_alt'   => 'Cleaning FAQ page in Kuwait',
    'body_class'  => 'page-faq',
    'breadcrumbs' => [
        t('common.home') => url('/'),
        t('nav.faq')     => '',
    ],
    'faq'         => array_reduce($groupKeys, function ($carry, $key) use ($groups) {
        foreach (($groups[$key]['items'] ?? []) as $item) {
            if (!empty($item['q']) && !empty($item['a'])) {
                $carry[] = $item;
            }
        }
        return $carry;
    }, []),
];

require __DIR__ . '/includes/header.php';

$hero = [
    'eyebrow'   => t('faq.hero_eyebrow'),
    'title'     => t('faq.hero_title'),
    'text'      => t('faq.hero_text'),
    'image'     => '/assets/images/services/deep-cleaning.webp',
    'image_alt' => 'Cleaning FAQ page in Kuwait',
    'whatsapp'  => whatsapp_quote_message(),
];
require __DIR__ . '/includes/page-hero.php';
?>

<section class="section" aria-labelledby="faq-filters-title">
    <div class="container container--narrow">
        <div class="faq-filters" role="tablist" aria-label="<?= e(t('faq.tab_all')) ?>">
            <button type="button" class="faq-filter__btn <?= $activeCat === 'all' ? 'is-active' : '' ?>" data-faq-filter="all" role="tab" aria-selected="<?= $activeCat === 'all' ? 'true' : 'false' ?>">
                <?= e(t('faq.tab_all')) ?>
            </button>
            <?php foreach ($groupKeys as $key): ?>
                <button type="button" class="faq-filter__btn <?= $activeCat === $key ? 'is-active' : '' ?>" data-faq-filter="<?= e($key) ?>" role="tab" aria-selected="<?= $activeCat === $key ? 'true' : 'false' ?>">
                    <?= e($groups[$key]['title'] ?? $key) ?>
                </button>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section" aria-labelledby="faq-list-title">
    <div class="container">
        <div class="faq-list" id="faq-list">
            <?php
            $visibleGroups = $activeCat === 'all' ? $groupKeys : [$activeCat];
            foreach ($visibleGroups as $key):
                $group = $groups[$key] ?? null;
                if (!$group) {
                    continue;
                }
                ?>
                <div class="faq-group">
                    <h2 class="faq-group__title"><?= e($group['title'] ?? $key) ?></h2>
                    <div class="faq-accordion">
                        <?php foreach (($group['items'] ?? []) as $item): ?>
                            <?php
                            $q = is_array($item) ? ($item['q'] ?? '') : (string) $item;
                            $a = is_array($item) ? ($item['a'] ?? '') : '';
                            if ($q === '' || $a === '') {
                                continue;
                            }
                            $id = 'faq-' . preg_replace('/[^a-z0-9-]/i', '-', $key) . '-' . preg_replace('/[^a-z0-9-]/i', '-', $q);
                            ?>
                            <div class="faq-item">
                                <h3 class="faq-question">
                                    <button type="button" class="faq-question__btn" data-faq-toggle aria-expanded="false" aria-controls="<?= e($id) ?>-answer">
                                        <span class="faq-question__text"><?= e($q) ?></span>
                                        <span class="faq-question__icon" aria-hidden="true"><?= icon('chevron-down', 'icon', 20) ?></span>
                                    </button>
                                </h3>
                                <div class="faq-answer" id="<?= e($id) ?>-answer" hidden>
                                    <div class="faq-answer__inner"><?= $a ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <p class="section-cta">
            <?= wa_button(whatsapp_quote_message(), t('cta.whatsapp_us'), 'whatsapp', ['class' => 'btn--lg']) ?>
        </p>
    </div>
</section>

<?php
echo cta_band();
require __DIR__ . '/includes/footer.php';