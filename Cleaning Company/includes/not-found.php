<?php
/** ====================================================================== *\
 *  404 CONTENT  —  callable as not_found() after header.php has loaded
 * ======================================================================= */

if (!function_exists('not_found')) {
    function not_found(): string
    {
        ob_start();
        ?>
<section class="section section--tight">
    <div class="container container--narrow">
        <div class="notfound">
            <p class="eyebrow"><?= icon('alert', 'eyebrow__icon', 18) ?><?= e(t('notfound.eyebrow')) ?></p>
            <h1 class="notfound__title"><?= e(t('notfound.title')) ?></h1>
            <p class="notfound__text"><?= e(t('notfound.text')) ?></p>

            <div class="notfound__actions">
                <?= btn(['label' => t('notfound.go_home'), 'href' => url('/'), 'variant' => 'primary', 'icon' => 'home', 'class' => 'btn--lg']) ?>
                <?= btn(['label' => t('cta.view_all_services'), 'href' => url('/services.php'), 'variant' => 'outline', 'icon' => 'arrow-right', 'icon_pos' => 'right', 'class' => 'btn--lg']) ?>
                <?= wa_button(whatsapp_quote_message(), t('cta.whatsapp_us'), 'whatsapp', ['class' => 'btn--lg']) ?>
                <?= call_button(t('cta.call_now'), 'accent', ['class' => 'btn--lg']) ?>
            </div>

            <div class="notfound__links">
                <h2 class="notfound__subtitle"><?= e(t('common.quick_links')) ?></h2>
                <ul class="chip-list">
                    <li><a class="chip" href="<?= e_url(url('/residential-cleaning.php')) ?>"><?= e(t('nav.residential')) ?></a></li>
                    <li><a class="chip" href="<?= e_url(url('/commercial-cleaning.php')) ?>"><?= e(t('nav.commercial')) ?></a></li>
                    <li><a class="chip" href="<?= e_url(url('/specialized-cleaning.php')) ?>"><?= e(t('nav.specialised')) ?></a></li>
                    <li><a class="chip" href="<?= e_url(url('/service-areas.php')) ?>"><?= e(t('nav.areas')) ?></a></li>
                    <li><a class="chip" href="<?= e_url(url('/gallery.php')) ?>"><?= e(t('nav.gallery')) ?></a></li>
                    <li><a class="chip" href="<?= e_url(url('/faq.php')) ?>"><?= e(t('nav.faq')) ?></a></li>
                    <li><a class="chip" href="<?= e_url(url('/contact.php')) ?>"><?= e(t('nav.contact')) ?></a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php echo cta_band(); ?>
<?php
        return ob_get_clean();
    }
}