<?php
/**
 * =====================================================================
 *  GLOBAL HEADER  —  <head>, top contact bar, sticky navigation
 * =====================================================================
 *  Usage from any page (any directory depth):
 *      require __DIR__ . '/includes/bootstrap.php';
 *      $page = [...];
 *      require __DIR__ . '/includes/header.php';
 * =====================================================================
 */

if (!function_exists('t')) {
    require_once __DIR__ . '/bootstrap.php';
}
require_once __DIR__ . '/seo.php';
require_once __DIR__ . '/schema.php';
require_once __DIR__ . '/navigation.php';

require __DIR__ . '/../data/site.php';   // $site_nav, footer link groups, $social_profiles

if (empty($page['title'])) {
    $page['title'] = t('seo.default_title', ['company' => COMPANY_NAME]);
}
if (empty($page['description'])) {
    $page['description'] = t('seo.default_description', ['company' => COMPANY_NAME]);
}
$page['path'] = $page['path'] ?? (string) ($GLOBALS['CURRENT_PATH'] ?? '/index.php');
$bodyClass    = trim('site ' . (string) ($page['body_class'] ?? '') . (is_rtl() ? ' site--rtl' : ''));
?>
<!DOCTYPE html>
<html lang="<?= e(lang()) ?>" dir="<?= e(text_direction()) ?>" class="no-js">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0e7c86">
    <script>document.documentElement.classList.remove('no-js');</script>
    <?= seo_head($page) ?>
    <link rel="icon" href="<?= e_url(media('/assets/images/favicon.svg')) ?>" type="image/svg+xml">
    <link rel="apple-touch-icon" href="<?= e_url(media('/assets/images/favicon.svg')) ?>">
    <?php if (!empty($page['preload_image'])) : ?>
    <link rel="preload" as="image" href="<?= e_url(media((string) $page['preload_image'])) ?>" fetchpriority="high">
    <?php endif; ?>
    <link rel="stylesheet" href="<?= e_url(asset('/assets/css/style.css')) ?>">
    <link rel="stylesheet" href="<?= e_url(asset('/assets/css/components.css')) ?>">
    <link rel="stylesheet" href="<?= e_url(asset('/assets/css/responsive.css')) ?>">
    <?php if (is_rtl()) : ?>
    <link rel="stylesheet" href="<?= e_url(asset('/assets/css/rtl.css')) ?>">
    <?php endif; ?>
    <?= schema_render($page) ?>
    <?= analytics_snippet() ?>
</head>
<body class="<?= e($bodyClass) ?>">
<a class="skip-link" href="#main"><?= e(t('common.skip_to_content')) ?></a>

<!-- Top contact bar -->
<div class="topbar">
    <div class="container topbar__inner">
        <ul class="topbar__list">
            <li class="topbar__item">
                <?= icon('phone', 'topbar__icon', 16) ?>
                <a href="<?= e_url(tel_url()) ?>"><?= e(t('header.call_us')) ?>: <?= e(COMPANY_PHONE) ?></a>
            </li>
            <li class="topbar__item topbar__item--whatsapp">
                <?= icon('whatsapp', 'topbar__icon', 16) ?>
                <a href="<?= e_url(whatsapp_url(whatsapp_quote_message())) ?>" target="_blank" rel="noopener noreferrer"><?= e(t('header.whatsapp')) ?></a>
            </li>
            <li class="topbar__item topbar__item--hours">
                <?= icon('clock', 'topbar__icon', 16) ?>
                <span><?= e(t('header.hours')) ?>: <?= e(COMPANY_WORKING_HOURS) ?></span>
            </li>
        </ul>
        <div class="topbar__meta">
            <?= language_switcher('lang-switch--topbar') ?>
            <ul class="topbar__social">
                <?php foreach ($social_profiles as $profile) : ?>
                    <?php if (str_starts_with((string) $profile['url'], 'http')) : ?>
                    <li><a href="<?= e_url($profile['url']) ?>" target="_blank" rel="noopener noreferrer"
                           aria-label="<?= e($profile['label']) ?>"><?= icon($profile['icon'], 'icon', 16) ?></a></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

<!-- Main header -->
<header class="site-header" data-header>
    <div class="container site-header__inner">
        <?= brand_logo('brand--header') ?>

        <nav class="main-nav" aria-label="<?= e(t('nav.menu')) ?>">
            <?= nav_desktop($site_nav) ?>
        </nav>

        <div class="site-header__actions">
            <?= language_switcher('lang-switch--header') ?>
            <?= wa_button(whatsapp_quote_message(), t('cta.whatsapp_us'), 'whatsapp', ['class' => 'btn--sm site-header__wa']) ?>
            <?= call_button(t('cta.call_now'), 'outline', ['class' => 'btn--sm site-header__call']) ?>
            <button type="button" class="nav-toggle" data-nav-toggle aria-expanded="false" aria-controls="mobile-drawer">
                <span class="visually-hidden"><?= e(t('nav.menu')) ?></span>
                <?= icon('menu', 'nav-toggle__icon nav-toggle__icon--open', 24) ?>
                <?= icon('close', 'nav-toggle__icon nav-toggle__icon--close', 24) ?>
            </button>
        </div>
    </div>
</header>

<!-- Mobile drawer -->
<div class="drawer" id="mobile-drawer" data-drawer hidden>
    <div class="drawer__panel" role="dialog" aria-modal="true" aria-label="<?= e(t('nav.menu')) ?>">
        <div class="drawer__head">
            <?= brand_logo('brand--drawer') ?>
            <button type="button" class="drawer__close" data-drawer-close>
                <span class="visually-hidden"><?= e(t('nav.menu_close')) ?></span>
                <?= icon('close', 'icon', 24) ?>
            </button>
        </div>
        <nav class="drawer__nav" aria-label="<?= e(t('nav.menu')) ?>">
            <?= nav_mobile($site_nav) ?>
        </nav>
        <div class="drawer__foot">
            <?= language_switcher('lang-switch--drawer') ?>
            <div class="drawer__cta">
                <?= wa_button(whatsapp_quote_message(), t('cta.whatsapp_us'), 'whatsapp') ?>
                <?= call_button(t('cta.call_now'), 'outline') ?>
            </div>
            <p class="drawer__contact">
                <?= icon('clock', 'icon', 16) ?><span><?= e(COMPANY_WORKING_HOURS) ?></span>
            </p>
        </div>
    </div>
</div>

<main id="main" class="main">