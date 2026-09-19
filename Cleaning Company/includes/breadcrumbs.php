<?php
/**
 * =====================================================================
 *  BREADCRUMBS  (visible trail + BreadcrumbList structured data)
 * =====================================================================
 *  Renders nothing on the home page. The same array that is printed here
 *  is passed to includes/schema.php through $page['breadcrumbs'].
 * =====================================================================
 */

if (!function_exists('t')) {
    require_once __DIR__ . '/bootstrap.php';
}

$crumbs = (array) ($page['breadcrumbs'] ?? []);
if ($crumbs) :
    $lastKey = array_key_last($crumbs);
    ?>
<nav class="breadcrumbs" aria-label="<?= e(t('common.breadcrumbs', ['fallback' => 'Breadcrumb'])) ?>">
    <div class="container">
        <ol class="breadcrumbs__list">
            <?php foreach ($crumbs as $label => $href) : ?>
                <li class="breadcrumbs__item">
                    <?php if ($href !== '' && $label !== $lastKey) : ?>
                        <a href="<?= e_url(str_starts_with((string) $href, 'http') ? (string) $href : base_path() . (string) $href) ?>"><?= e((string) $label) ?></a>
                    <?php else : ?>
                        <span aria-current="page"><?= e((string) $label) ?></span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>
</nav>
    <?php
endif;