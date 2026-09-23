<?php
/**
 * CONTACT PAGE
 * Phone / WhatsApp cards plus a map section centred on the configured
 * business address. There is deliberately no contact form on this page:
 * visitors reach the team directly on WhatsApp or by phone. No e-mail
 * address is published. No booking system, no accounts, no database.
 */

require __DIR__ . '/includes/bootstrap.php';

$contactImage    = project_image('contact-page');
$contactImageAlt = alt_text(
    'Cleaning team of ' . COMPANY_NAME . ' at work in Kuwait',
    'فريق التنظيف التابع لـ ' . COMPANY_NAME . ' أثناء العمل في الكويت'
);

$page = [
    'slug'        => 'contact',
    'path'        => '/contact.php',
    'title'       => 'Contact Us — Cleaning Services in Kuwait | ' . COMPANY_NAME,
    'description' => 'Contact ' . COMPANY_NAME . ' for residential, commercial or specialised cleaning in Kuwait. Call us or send a WhatsApp message for a quote and free inspection. No booking system, no accounts, no database.',
    'keywords'    => 'contact cleaning company Kuwait, cleaning company phone Kuwait, WhatsApp cleaning Kuwait, cleaning quote Kuwait',
    'image'       => $contactImage,
    'image_alt'   => $contactImageAlt,
    'body_class'  => 'page-contact',
    'breadcrumbs' => [
        t('common.home') => url('/'),
        t('nav.contact') => '',
    ],
];

require __DIR__ . '/includes/header.php';

$hero = [
    'eyebrow'   => t('contact.hero_eyebrow'),
    'title'     => t('contact.hero_title'),
    'text'      => t('contact.hero_text'),
    'image'     => $contactImage,
    'image_alt' => $contactImageAlt,
    'whatsapp'  => whatsapp_quote_message(),
    'eager'     => true,
];
require __DIR__ . '/includes/page-hero.php';
?>

<section class="section" aria-labelledby="contact-cards-title">
    <div class="container">
        <?= section_head([
            'eyebrow' => t('contact.hero_eyebrow'),
            'title'   => t('contact.hero_title'),
            'lead'    => t('contact.hero_text'),
            'level'   => 2,
            'align'   => 'center',
        ]) ?>

        <div class="contact-cards contact-cards--pair">
            <a class="contact-card contact-card--wa reveal" href="<?= e_url(whatsapp_url(whatsapp_quote_message())) ?>" target="_blank" rel="noopener noreferrer">
                <span class="contact-card__icon"><?= icon('whatsapp', 'icon', 26) ?></span>
                <span class="contact-card__label"><?= e(t('common.whatsapp')) ?></span>
                <span class="contact-card__value" dir="ltr"><?= e(COMPANY_WHATSAPP) ?></span>
                <span class="contact-card__hint"><?= e(t('cta.whatsapp_now')) ?><?= icon('arrow-right', 'icon', 16) ?></span>
            </a>

            <a class="contact-card reveal" href="<?= e_url(tel_url()) ?>">
                <span class="contact-card__icon"><?= icon('phone', 'icon', 26) ?></span>
                <span class="contact-card__label"><?= e(t('contact.phone_label')) ?></span>
                <span class="contact-card__value" dir="ltr"><?= e(COMPANY_PHONE) ?></span>
                <span class="contact-card__hint"><?= e(t('cta.call_now')) ?><?= icon('arrow-right', 'icon', 16) ?></span>
            </a>
        </div>

        <div class="contact-details">
            <div class="contact-detail reveal">
                <span class="contact-detail__icon"><?= icon('map-pin', 'icon', 22) ?></span>
                <div class="contact-detail__body">
                    <span class="contact-detail__label"><?= e(t('contact.address_label')) ?></span>
                    <span class="contact-detail__value"><?= e(COMPANY_ADDRESS) ?></span>
                </div>
            </div>
            <div class="contact-detail reveal">
                <span class="contact-detail__icon"><?= icon('clock', 'icon', 22) ?></span>
                <div class="contact-detail__body">
                    <span class="contact-detail__label"><?= e(t('contact.hours_label')) ?></span>
                    <span class="contact-detail__value"><?= e(COMPANY_WORKING_HOURS) ?></span>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if (map_embed_url() !== '') : ?>
<section class="section section--muted" aria-labelledby="contact-map-title">
    <div class="container">
        <div class="contact-map reveal">
            <div class="contact-map__card">
                <p class="eyebrow"><?= icon('map-pin', 'eyebrow__icon', 18) ?><?= e(t('contact.hero_eyebrow')) ?></p>
                <h2 class="contact-map__title" id="contact-map-title"><?= e(t('contact.google_maps')) ?></h2>
                <p class="contact-map__lead"><?= e(t('contact.map_lead')) ?></p>

                <ul class="contact-map__facts">
                    <li>
                        <span class="contact-map__fact-icon"><?= icon('map-pin', 'icon', 20) ?></span>
                        <span class="contact-map__fact-body">
                            <span class="contact-map__fact-label"><?= e(t('contact.address_label')) ?></span>
                            <span class="contact-map__fact-value"><?= e(COMPANY_ADDRESS) ?></span>
                        </span>
                    </li>
                    <li>
                        <span class="contact-map__fact-icon"><?= icon('clock', 'icon', 20) ?></span>
                        <span class="contact-map__fact-body">
                            <span class="contact-map__fact-label"><?= e(t('contact.hours_label')) ?></span>
                            <span class="contact-map__fact-value"><?= e(COMPANY_WORKING_HOURS) ?></span>
                        </span>
                    </li>
                    <li>
                        <span class="contact-map__fact-icon"><?= icon('phone', 'icon', 20) ?></span>
                        <span class="contact-map__fact-body">
                            <span class="contact-map__fact-label"><?= e(t('contact.phone_label')) ?></span>
                            <span class="contact-map__fact-value" dir="ltr"><?= e(COMPANY_PHONE) ?></span>
                        </span>
                    </li>
                </ul>

                <div class="contact-map__actions">
                    <a class="btn btn--primary" href="<?= e_url(COMPANY_GOOGLE_MAPS_URL) ?>" target="_blank" rel="noopener noreferrer">
                        <?= icon('map-pin', 'btn__icon', 18) ?><span class="btn__label"><?= e(t('contact.directions')) ?></span>
                    </a>
                    <?= wa_button(whatsapp_quote_message(), t('cta.whatsapp_us'), 'whatsapp') ?>
                </div>
            </div>

            <div class="contact-map__frame">
                <iframe loading="lazy"
                        src="<?= e_url(map_embed_url()) ?>"
                        width="100%" height="100%" style="border:0;"
                        allowfullscreen
                        referrerpolicy="no-referrer-when-downgrade"
                        title="<?= e(COMPANY_NAME) ?> — <?= e(COMPANY_ADDRESS) ?>">
                </iframe>
                <a class="contact-map__badge" href="<?= e_url(COMPANY_GOOGLE_MAPS_URL) ?>" target="_blank" rel="noopener noreferrer">
                    <?= icon('map-pin', 'contact-map__badge-icon', 16) ?><span><?= e(COMPANY_CITY) ?></span>
                </a>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php
echo cta_band();
require __DIR__ . '/includes/footer.php';