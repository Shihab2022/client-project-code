<?php
/**
 * GALLERY PAGE
 */

require __DIR__ . '/includes/bootstrap.php';

$galleryItems = gallery_items();
$categories    = [];
foreach ($galleryItems as $item) {
    $cat = $item['category'] ?? 'other';
    if (!isset($categories[$cat])) {
        $categories[$cat] = ['key' => $cat, 'label' => $cat === 'other' ? t('gallery.filter_title') : lx($item, 'category', $cat)];
    }
}

$page = [
    'slug'        => 'gallery',
    'path'        => '/gallery.php',
    'title'       => 'Cleaning Gallery — Before & After Results in Kuwait | ' . COMPANY_NAME,
    'description' => 'Browse real cleaning results across Kuwait: villa, apartment, office, shop, sofa, carpet and specialised cleaning photos, with before and after comparisons.',
    'keywords'    => 'cleaning gallery Kuwait, before and after cleaning Kuwait, villa cleaning photos Kuwait, office cleaning photos Kuwait, carpet cleaning photos Kuwait',
    'image'       => '/assets/images/gallery-cover.webp',
    'image_alt'   => 'Cleaning results gallery in Kuwait',
    'body_class'  => 'page-gallery',
    'breadcrumbs' => [
        t('common.home') => url('/'),
        t('nav.gallery') => '',
    ],
];

require __DIR__ . '/includes/header.php';

$hero = [
    'eyebrow'   => t('gallery.hero_eyebrow'),
    'title'     => t('gallery.hero_title'),
    'text'      => t('gallery.hero_text'),
    'image'     => '/assets/images/gallery-cover.webp',
    'image_alt' => 'Cleaning results gallery in Kuwait',
    'whatsapp'  => whatsapp_quote_message(),
];
require __DIR__ . '/includes/page-hero.php';

$activeCat = $_GET['cat'] ?? 'all';
?>

<section class="section" aria-labelledby="gallery-filter-title">
    <div class="container container--narrow">
        <div class="gallery-filter" role="tablist" aria-label="<?= e(t('gallery.filter_title')) ?>">
            <button type="button" class="gallery-filter__btn <?= $activeCat === 'all' ? 'is-active' : '' ?>" data-gallery-filter="all" role="tab" aria-selected="<?= $activeCat === 'all' ? 'true' : 'false' ?>">
                <?= e(t('gallery.filter_title')) ?>
            </button>
            <?php foreach ($categories as $cat => $info): ?>
                <?php if ($cat === 'all') continue; ?>
                <button type="button" class="gallery-filter__btn <?= $activeCat === $cat ? 'is-active' : '' ?>" data-gallery-filter="<?= e($cat) ?>" role="tab" aria-selected="<?= $activeCat === $cat ? 'true' : 'false' ?>">
                    <?= e($info['label']) ?>
                </button>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section" aria-labelledby="gallery-grid-title">
    <div class="container">
        <?= section_head([
            'title' => t('gallery.grid_title'),
            'level' => 2,
        ]) ?>
        <div class="gallery-grid" data-gallery-grid>
            <?php if (!$galleryItems): ?>
                <p class="gallery-empty"><?= e(t('gallery.grid_empty')) ?></p>
            <?php endif; ?>
            <?php foreach ($galleryItems as $item): ?>
                <?php
                $cat = $item['category'] ?? 'other';
                if ($activeCat !== 'all' && $cat !== $activeCat) {
                    continue;
                }
                ?>
                <div class="gallery-item reveal" data-gallery-item data-category="<?= e($cat) ?>">
                    <button type="button" class="gallery-item__btn" data-gallery-open
                            aria-label="<?= e($item['alt'] ?? t('gallery.grid_title')) ?>">
                        <?= img_tag([
                            'src'        => $item['src'] ?? '/assets/images/placeholder.webp',
                            'alt'        => $item['alt'] ?? t('gallery.grid_title'),
                            'width'      => 600,
                            'height'     => 400,
                            'loading'    => 'lazy',
                            'class'      => 'gallery-item__img',
                        ]) ?>
                        <span class="gallery-item__overlay"><?= icon('expand', 'icon', 24) ?></span>
                    </button>
                    <p class="gallery-item__caption"><?= e(lx($item, 'name', '')) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if ($activeCat !== 'all'): ?>
            <div class="gallery-back">
                <a class="btn btn--ghost" href="<?= e_url(url('/gallery.php')) ?>">
                    <?= icon('arrow-left', 'icon', 18) ?> <?= e(t('gallery.filter_title')) ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<div class="gallery-lightbox" id="gallery-lightbox" data-gallery-lightbox hidden role="dialog" aria-modal="true" aria-label="<?= e(t('gallery.lightbox_title')) ?>">
    <div class="gallery-lightbox__backdrop" data-gallery-close></div>
    <div class="gallery-lightbox__panel">
        <button type="button" class="gallery-lightbox__close" data-gallery-close aria-label="<?= e(t('gallery.lightbox_close')) ?>">
            <?= icon('close', 'icon', 24) ?>
        </button>
        <div class="gallery-lightbox__stage" data-gallery-stage>
            <img class="gallery-lightbox__img" data-gallery-img src="" alt="">
            <p class="gallery-lightbox__caption" data-gallery-caption></p>
        </div>
        <div class="gallery-lightbox__nav">
            <button type="button" class="gallery-lightbox__prev" data-gallery-prev aria-label="Previous image">
                <?= icon('chevron-left', 'icon', 24) ?>
            </button>
            <button type="button" class="gallery-lightbox__next" data-gallery-next aria-label="Next image">
                <?= icon('chevron-right', 'icon', 24) ?>
            </button>
        </div>
    </div>
</div>

<?php
echo cta_band();
require __DIR__ . '/includes/footer.php';