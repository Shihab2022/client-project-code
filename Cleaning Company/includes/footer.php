<?php
/**
 * =====================================================================
 *  GLOBAL FOOTER  —  five column footer, floating CTAs, script loading
 * =====================================================================
 *  Links are generated from /data/site.php, /data/services.php and
 *  /data/areas.php: adding a service or area updates the footer too.
 * =====================================================================
 */

if (!function_exists('t')) {
    require_once __DIR__ . '/bootstrap.php';
}
require __DIR__ . '/../data/site.php';
?>
</main><!-- /#main -->

<?php require __DIR__ . '/floating-actions.php'; ?>

<footer class="site-footer" role="contentinfo" aria-labelledby="site-footer-title">
    <h2 class="visually-hidden" id="site-footer-title"><?= e(t('footer.quick_links')) ?></h2>
    <div class="container">
        <div class="site-footer__grid">
            <div class="site-footer__col site-footer__col--brand">
                <?= brand_logo('brand--footer') ?>
                <p class="site-footer__about"><?= e(t('footer.about_text')) ?></p>

                <ul class="site-footer__social" aria-label="<?= e(t('footer.social')) ?>">
                    <?php foreach ($social_profiles as $profile) : ?>
                        <?php if (str_starts_with((string) $profile['url'], 'http')) : ?>
                        <li>
                            <a href="<?= e_url($profile['url']) ?>" target="_blank" rel="noopener noreferrer">
                                <?= icon($profile['icon'], 'icon', 17) ?>
                                <span><?= e($profile['label']) ?></span>
                            </a>
                        </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
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

        <ul class="site-footer__contact" aria-label="<?= e(t('footer.contact')) ?>">
            <li>
                <?= icon('phone', 'icon', 18) ?>
                <a href="<?= e_url(tel_url()) ?>" dir="ltr"><?= e(COMPANY_PHONE) ?></a>
            </li>
            <li>
                <?= icon('whatsapp', 'icon', 18) ?>
                <a href="<?= e_url(whatsapp_url(whatsapp_quote_message())) ?>" target="_blank" rel="noopener noreferrer"><?= e(t('common.whatsapp')) ?></a>
            </li>
            <li>
                <?= icon('mail', 'icon', 18) ?>
                <a href="<?= e_url(mail_url()) ?>"><?= e(COMPANY_EMAIL) ?></a>
            </li>
            <li>
                <?= icon('map-pin', 'icon', 18) ?>
                <span><?= e(COMPANY_ADDRESS) ?></span>
            </li>
            <li>
                <?= icon('clock', 'icon', 18) ?>
                <span><?= e(COMPANY_WORKING_HOURS) ?></span>
            </li>
        </ul>

        <div class="site-footer__bottom">
            <p class="site-footer__copy"><?= e(t('footer.copyright', ['year' => date('Y'), 'company' => COMPANY_NAME])) ?></p>
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