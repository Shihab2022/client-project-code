<?php
/**
 * CONTACT PAGE
 */

require __DIR__ . '/includes/bootstrap.php';

$formOptions = [
    'title'  => t('contact.form_title'),
    'source' => '/contact.php',
];

/* Post/redirect/get state. Nothing is stored in a database: the action
   keeps the typed values and the error list in the session for exactly
   one redirect, and they are consumed (and deleted) right here. */
$formStatus = (string) ($_GET['status'] ?? '');
if (!in_array($formStatus, ['sent', 'error'], true)) {
    $formStatus = '';
}

$formOld    = [];
$formErrors = [];

if ($formStatus === 'error') {
    $rawOld  = flash_get('contact_old');
    $decoded = json_decode((string) $rawOld, true);
    if (is_array($decoded)) {
        $formOld = $decoded;
    }
    $decoded = json_decode((string) flash_get('contact_errors'), true);
    if (is_array($decoded)) {
        $formErrors = $decoded;
    }
    if (!$formErrors) {
        $formErrors = ['form' => 'form.error_generic'];
    }
} elseif ($formStatus === 'sent') {
    flash_get('contact_old');       // discard any stale values
    flash_get('contact_errors');
}

$page = [
    'slug'        => 'contact',
    'path'        => '/contact.php',
    'title'       => 'Contact Us — Cleaning Services in Kuwait | ' . COMPANY_NAME,
    'description' => 'Contact ' . COMPANY_NAME . ' for residential, commercial or specialised cleaning in Kuwait. Call, WhatsApp or send an inquiry using our contact form. No booking system, no accounts, no database.',
    'keywords'    => 'contact cleaning company Kuwait, cleaning company phone Kuwait, WhatsApp cleaning Kuwait, cleaning quote Kuwait',
    'image'       => '/assets/images/contact-cover.webp',
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
    'image'     => '/assets/images/contact-cover.webp',
    'image_alt' => 'Contact cleaning company in Kuwait',
    'whatsapp'  => whatsapp_quote_message(),
];
require __DIR__ . '/includes/page-hero.php';
?>

<section class="section" aria-labelledby="contact-intro-title">
    <div class="container">
        <?= section_head([
            'title' => t('contact.intro'),
            'level' => 2,
            'align' => 'center',
        ]) ?>
    </div>
</section>

<section class="section" aria-labelledby="contact-info-title">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-info">
                <h2 class="contact-info__title" id="contact-info-title"><?= e(t('contact.hero_eyebrow')) ?></h2>

                <div class="contact-item">
                    <span class="contact-item__icon"><?= icon('phone', 'icon', 22) ?></span>
                    <div class="contact-item__body">
                        <span class="contact-item__label"><?= e(t('contact.phone_label')) ?></span>
                        <a class="contact-item__value" href="<?= e_url(tel_url()) ?>"><?= e(COMPANY_PHONE) ?></a>
                    </div>
                </div>

                <div class="contact-item">
                    <span class="contact-item__icon"><?= icon('whatsapp', 'icon', 22) ?></span>
                    <div class="contact-item__body">
                        <span class="contact-item__label"><?= e(t('common.whatsapp')) ?></span>
                        <a class="contact-item__value" href="<?= e_url(whatsapp_url(whatsapp_quote_message())) ?>" target="_blank" rel="noopener noreferrer"><?= e(COMPANY_WHATSAPP) ?></a>
                    </div>
                </div>

                <div class="contact-item">
                    <span class="contact-item__icon"><?= icon('mail', 'icon', 22) ?></span>
                    <div class="contact-item__body">
                        <span class="contact-item__label"><?= e(t('contact.email_label')) ?></span>
                        <a class="contact-item__value" href="<?= e_url('mailto:' . COMPANY_EMAIL) ?>"><?= e(COMPANY_EMAIL) ?></a>
                    </div>
                </div>

                <div class="contact-item">
                    <span class="contact-item__icon"><?= icon('map-pin', 'icon', 22) ?></span>
                    <div class="contact-item__body">
                        <span class="contact-item__label"><?= e(t('contact.address_label')) ?></span>
                        <span class="contact-item__value"><?= e(COMPANY_ADDRESS) ?></span>
                    </div>
                </div>

                <div class="contact-item">
                    <span class="contact-item__icon"><?= icon('clock', 'icon', 22) ?></span>
                    <div class="contact-item__body">
                        <span class="contact-item__label"><?= e(t('contact.hours_label')) ?></span>
                        <span class="contact-item__value"><?= e(COMPANY_WORKING_HOURS) ?></span>
                    </div>
                </div>

                <?php if (COMPANY_GOOGLE_MAPS_URL !== '' && str_starts_with(COMPANY_GOOGLE_MAPS_URL, 'http')): ?>
                <div class="contact-map">
                    <h3 class="contact-map__title"><?= e(t('contact.google_maps')) ?></h3>
                    <div class="contact-map__frame">
                        <iframe loading="lazy"
                                src="<?= e_url(COMPANY_GOOGLE_MAPS_URL) ?>"
                                width="100%" height="320" style="border:0;"
                                allowfullscreen
                                referrerpolicy="no-referrer-when-downgrade"
                                title="<?= e(COMPANY_NAME) ?> location on Google Maps">
                        </iframe>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <div class="contact-form">
                <?php
                $formStatus  = (string) ($formStatus ?: ($_GET['status'] ?? ''));
                $formOld     = is_array($formOld) ? $formOld : [];
                $formErrors  = is_array($formErrors) ? $formErrors : [];
                require __DIR__ . '/includes/quote-form.php';
                ?>
            </div>
        </div>
    </div>
</section>

<?php
echo cta_band();
require __DIR__ . '/includes/footer.php';