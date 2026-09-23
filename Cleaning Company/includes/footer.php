<?php
/**
 * =====================================================================
 *  GLOBAL FOOTER  —  brand block, link columns, contact strip, legal bar
 * =====================================================================
 *  Links are generated from /data/site.php, /data/services.php and
 *  /data/areas.php: adding a service or area updates the footer too.
 *  There are no social profiles and no e-mail address on the website:
 *  visitors reach us on WhatsApp or by phone.
 * =====================================================================
 */

if (!function_exists('t')) {
    require_once __DIR__ . '/bootstrap.php';
}
require __DIR__ . '/../data/site.php';
?>
</main><!-- /#main -->

<?php require __DIR__ . '/floating-actions.php'; ?>

<?php
/* A CTA band directly above the footer paints its own background, so the
   footer is rendered flush against it and no white strip shows in between. */
$footerClass = 'site-footer' . (!empty($GLOBALS['CTA_BAND_RENDERED']) ? ' site-footer--flush' : '');
?>
<footer class="<?= e($footerClass) ?>" role="contentinfo" aria-labelledby="site-footer-title">
    <h2 class="visually-hidden" id="site-footer-title"><?= e(t('footer.quick_links')) ?></h2>
    <div class="container">
        <div class="site-footer__grid">
            <div class="site-footer__col site-footer__col--brand">
                <?= brand_logo('brand--footer') ?>
                <p class="site-footer__about"><?= e(t('footer.about_text')) ?></p>

                <ul class="site-footer__meta">
                    <li>
                        <span class="site-footer__meta-icon"><?= icon('clock', 'icon', 16) ?></span>
                        <span><?= e(COMPANY_WORKING_HOURS) ?></span>
                    </li>
                    <li>
                        <span class="site-footer__meta-icon"><?= icon('map-pin', 'icon', 16) ?></span>
                        <span><?= e(COMPANY_ADDRESS) ?></span>
                    </li>
                </ul>

                <div class="site-footer__actions">
                    <?= wa_button(whatsapp_quote_message(), t('cta.whatsapp_us'), 'whatsapp', ['class' => 'btn--sm']) ?>
                    <?= call_button(t('cta.call_now'), 'light', ['class' => 'btn--sm']) ?>
                </div>
            </div>

            <nav class="site-footer__col" aria-label="<?= e(t('footer.quick_links')) ?>">
                <h3 class="site-footer__title"><?= e(t('footer.quick_links')) ?></h3>
                <ul class="site-footer__list">
                    <?php foreach ($footer_quick_links as $link) : ?>
                        <li><a href="<?= e_url(url($link['url'])) ?>"><?= e(t($link['key'])) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </nav>

            <nav class="site-footer__col" aria-label="<?= e(t('footer.services')) ?>">
                <h3 class="site-footer__title"><?= e(t('footer.services')) ?></h3>
                <ul class="site-footer__list">
                    <?php foreach ($footer_service_slugs as $slug) : ?>
                        <?php if (service($slug)) : ?>
                        <li><a href="<?= e_url(service_url($slug)) ?>"><?= e(service_name($slug)) ?></a></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <li><a class="site-footer__more" href="<?= e_url(url('/services.php')) ?>"><?= e(t('cta.view_all_services')) ?></a></li>
                </ul>
            </nav>

            <nav class="site-footer__col" aria-label="<?= e(t('footer.areas')) ?>">
                <h3 class="site-footer__title"><?= e(t('footer.areas')) ?></h3>
                <ul class="site-footer__list">
                    <?php foreach ($footer_area_slugs as $slug) : ?>
                        <?php if (area($slug)) : ?>
                        <li><a href="<?= e_url(area_url($slug)) ?>"><?= e(area_name($slug)) ?></a></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <li><a class="site-footer__more" href="<?= e_url(url('/service-areas.php')) ?>"><?= e(t('cta.view_all_areas')) ?></a></li>
                </ul>
            </nav>
        </div>

        <div class="site-footer__info">
            <a class="site-footer__info-card site-footer__info-card--wa" href="<?= e_url(whatsapp_url(whatsapp_quote_message())) ?>" target="_blank" rel="noopener noreferrer">
                <span class="site-footer__info-icon"><?= icon('whatsapp', 'icon', 22) ?></span>
                <span class="site-footer__info-body">
                    <span class="site-footer__info-label"><?= e(t('common.whatsapp')) ?></span>
                    <span class="site-footer__info-value" dir="ltr"><?= e(COMPANY_PHONE) ?></span>
                </span>
                <span class="site-footer__info-arrow" aria-hidden="true"><?= icon('arrow-up-right', 'icon', 16) ?></span>
            </a>

            <a class="site-footer__info-card" href="<?= e_url(tel_url()) ?>">
                <span class="site-footer__info-icon"><?= icon('phone', 'icon', 22) ?></span>
                <span class="site-footer__info-body">
                    <span class="site-footer__info-label"><?= e(t('common.phone')) ?></span>
                    <span class="site-footer__info-value" dir="ltr"><?= e(COMPANY_PHONE) ?></span>
                </span>
                <span class="site-footer__info-arrow" aria-hidden="true"><?= icon('arrow-up-right', 'icon', 16) ?></span>
            </a>

            <a class="site-footer__info-card" href="<?= e_url(COMPANY_GOOGLE_MAPS_URL) ?>" target="_blank" rel="noopener noreferrer">
                <span class="site-footer__info-icon"><?= icon('map-pin', 'icon', 22) ?></span>
                <span class="site-footer__info-body">
                    <span class="site-footer__info-label"><?= e(t('common.address')) ?></span>
                    <span class="site-footer__info-value"><?= e(COMPANY_ADDRESS) ?></span>
                </span>
                <span class="site-footer__info-arrow" aria-hidden="true"><?= icon('arrow-up-right', 'icon', 16) ?></span>
            </a>
        </div>

        <div class="site-footer__bottom">
            <p class="site-footer__copy"><?= e(t('footer.copyright', ['year' => date('Y'), 'company' => COMPANY_NAME])) ?></p>
            <p class="site-footer__note"><?= e(t('footer.note')) ?></p>
            <ul class="site-footer__legal">
                <?php foreach ($footer_legal_links as $link) : ?>
                    <li><a href="<?= e_url(url($link['url'])) ?>"><?= e(t($link['key'])) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</footer>

<!-- Mobile sticky action bar -->
<div class="action-bar" data-action-bar>
    <a class="action-bar__btn action-bar__btn--wa" href="<?= e_url(whatsapp_url(whatsapp_quote_message())) ?>" target="_blank" rel="noopener noreferrer">
        <?= icon('whatsapp', 'action-bar__icon', 22) ?><span><?= e(t('common.whatsapp')) ?></span>
    </a>
    <a class="action-bar__btn action-bar__btn--call" href="<?= e_url(tel_url()) ?>">
        <?= icon('phone', 'action-bar__icon', 22) ?><span><?= e(t('cta.call_now')) ?></span>
    </a>
</div>

<?php
$scripts = ['/assets/js/main.js'];
foreach ((array) ($page['scripts'] ?? []) as $extraScript) {
    $scripts[] = $extraScript;
}
foreach (array_unique($scripts) as $script) {
    echo '<script src="' . e_url(asset($script)) . '" defer></script>' . "\n";
}
?>
</body>
</html>