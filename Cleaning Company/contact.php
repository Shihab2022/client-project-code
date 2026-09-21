<?php
/**
 * CONTACT PAGE
 */

require __DIR__ . '/includes/bootstrap.php';

$page = [
    'slug'        => 'contact',
    'path'        => '/contact.php',
    'title'       => 'Contact Us — Cleaning Services in Kuwait | ' . COMPANY_NAME,
    'description' => 'Contact ' . COMPANY_NAME . ' for residential, commercial or specialised cleaning in Kuwait. Call, WhatsApp or send an inquiry using our contact form. No booking system, no accounts, no database.',
    'keywords'    => 'contact cleaning company Kuwait, cleaning company phone Kuwait, WhatsApp cleaning Kuwait, cleaning quote Kuwait',
    'image'       => '/assets/images/hero-cleaning.webp',
    'image_alt'   => 'Contact cleaning company in Kuwait',
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
    'image'     => '/assets/images/hero-cleaning.webp',
    'image_alt' => 'Contact cleaning company in Kuwait',
    'whatsapp'  => whatsapp_quote_message(),
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

        <div class="contact-cards">
            <a class="contact-card reveal" href="<?= e_url(tel_url()) ?>">
                <span class="contact-card__icon"><?= icon('phone', 'icon', 26) ?></span>
                <span class="contact-card__label"><?= e(t('contact.phone_label')) ?></span>
                <span class="contact-card__value" dir="ltr"><?= e(COMPANY_PHONE) ?></span>
                <span class="contact-card__hint"><?= e(t('cta.call_now')) ?><?= icon('arrow-right', 'icon', 16) ?></span>
            </a>

            <a class="contact-card contact-card--wa reveal" href="<?= e_url(whatsapp_url(whatsapp_quote_message())) ?>" target="_blank" rel="noopener noreferrer">
                <span class="contact-card__icon"><?= icon('whatsapp', 'icon', 26) ?></span>
                <span class="contact-card__label"><?= e(t('common.whatsapp')) ?></span>
                <span class="contact-card__value" dir="ltr"><?= e(COMPANY_WHATSAPP) ?></span>
                <span class="contact-card__hint"><?= e(t('cta.whatsapp_now')) ?><?= icon('arrow-right', 'icon', 16) ?></span>
            </a>

            <a class="contact-card reveal" href="<?= e_url('mailto:' . COMPANY_EMAIL) ?>">
                <span class="contact-card__icon"><?= icon('mail', 'icon', 26) ?></span>
                <span class="contact-card__label"><?= e(t('contact.email_label')) ?></span>
                <span class="contact-card__value"><?= e(COMPANY_EMAIL) ?></span>
                <span class="contact-card__hint"><?= e(t('cta.email_us')) ?><?= icon('arrow-right', 'icon', 16) ?></span>
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

        <?php if (COMPANY_MAP_EMBED_URL !== '' && str_starts_with(COMPANY_MAP_EMBED_URL, 'https://')) : ?>
        <div class="contact-map reveal">
            <h3 class="contact-map__title"><?= icon('map-pin', 'icon', 20) ?> <?= e(t('contact.google_maps')) ?></h3>
            <div class="contact-map__frame">
                <iframe loading="lazy"
                        src="<?= e_url(COMPANY_MAP_EMBED_URL) ?>"
                        width="100%" height="360" style="border:0;"
                        allowfullscreen
                        referrerpolicy="no-referrer-when-downgrade"
                        title="<?= e(COMPANY_NAME) ?> location on Google Maps">
                </iframe>
            </div>
            <?php if (COMPANY_GOOGLE_MAPS_URL !== '' && str_starts_with(COMPANY_GOOGLE_MAPS_URL, 'http')) : ?>
            <p class="contact-map__actions">
                <a class="btn btn--outline btn--sm" href="<?= e_url(COMPANY_GOOGLE_MAPS_URL) ?>" target="_blank" rel="noopener noreferrer">
                    <?= icon('map-pin', 'btn__icon', 16) ?><span class="btn__label"><?= e(t('contact.directions')) ?></span>
                </a>
            </p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php
echo cta_band();
require __DIR__ . '/includes/footer.php';