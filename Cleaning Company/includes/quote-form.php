<?php
/**
 * =====================================================================
 *  CONTACT / QUOTATION FORM COMPONENT   (no database involved)
 * =====================================================================
 *  Posts to /actions/contact.php which validates, sanitizes and e-mails
 *  the inquiry, then redirects back here with a flash message.
 *
 *  Options (all optional):
 *    $formOptions['title']           Heading of the form card
 *    $formOptions['text']            Short introduction
 *    $formOptions['source']          Where the form was submitted from
 *    $formOptions['default_service'] Pre-selected service slug or name
 *    $formOptions['id']              Anchor id (default: quote-form)
 * =====================================================================
 */

if (!function_exists('t')) {
    require_once __DIR__ . '/bootstrap.php';
}

$formOptions = is_array($formOptions ?? null) ? $formOptions : [];
$formStatus  = (string) ($formStatus ?? ($_GET['status'] ?? ''));   // sent | error | ''
$formOld     = is_array($formOld ?? null) ? $formOld : [];
$formErrors  = is_array($formErrors ?? null) ? $formErrors : [];
$formSource  = (string) ($formOptions['source'] ?? ($GLOBALS['CURRENT_PATH'] ?? '/contact.php'));
$formAnchor  = (string) ($formOptions['id'] ?? 'quote-form');
$isSent      = $formStatus === 'sent';
$hasErrors   = $formStatus === 'error' && (bool) $formErrors;

$fieldValue = static fn(string $key, string $default = ''): string => (string) ($formOld[$key] ?? $default);
$fieldError = static fn(string $key): string => (string) ($formErrors[$key] ?? '');
?>
<section class="quote-form" id="<?= e($formAnchor) ?>" aria-labelledby="<?= e($formAnchor) ?>-title">
    <div class="quote-form__card">
        <h2 class="quote-form__title" id="<?= e($formAnchor) ?>-title">
            <?= e((string) ($formOptions['title'] ?? t('contact.form_title'))) ?>
        </h2>
        <p class="quote-form__text"><?= e((string) ($formOptions['text'] ?? t('contact.form_text'))) ?></p>

        <?php if ($isSent) : ?>
            <div class="alert alert--success" role="status">
                <?= icon('check-circle', 'alert__icon', 22) ?>
                <div>
                    <p class="alert__title"><?= e(t('form.success_title')) ?></p>
                    <p class="alert__text"><?= e(t('form.success_text')) ?></p>
                    <div class="alert__actions">
                        <?= wa_button(whatsapp_quote_message(), t('cta.whatsapp_us'), 'whatsapp', ['class' => 'btn--sm']) ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($hasErrors) : ?>
            <div class="alert alert--error" role="alert">
                <?= icon('alert', 'alert__icon', 22) ?>
                <div>
                    <p class="alert__title"><?= e(t('form.error_title')) ?></p>
                    <p class="alert__text"><?= e(t('form.error_summary')) ?></p>
                </div>
            </div>
        <?php endif; ?>

        <form class="form" action="<?= e_url(base_path() . '/actions/contact.php') ?>" method="post" novalidate data-contact-form>
            <?= csrf_field() ?>
            <?= form_time_field() ?>
            <?= form_honeypot_field() ?>
            <input type="hidden" name="lang" value="<?= e(lang()) ?>">
            <input type="hidden" name="source" value="<?= e($formSource) ?>">
            <p class="form__hint"><?= e(t('form.required_hint')) ?></p>

            <div class="form__row">
                <div class="form__field<?= $fieldError('name') !== '' ? ' has-error' : '' ?>">
                    <label class="form__label" for="cf-name"><?= e(t('form.name')) ?> <span aria-hidden="true">*</span></label>
                    <input class="form__input" type="text" id="cf-name" name="name" required maxlength="80"
                           autocomplete="name" placeholder="<?= e(t('form.name_ph')) ?>"
                           value="<?= e($fieldValue('name')) ?>"<?= $fieldError('name') !== '' ? ' aria-invalid="true" aria-describedby="cf-name-error"' : '' ?>>
                    <?php if ($fieldError('name') !== '') : ?>
                        <p class="form__error" id="cf-name-error"><?= e(t($fieldError('name'))) ?></p>
                    <?php endif; ?>
                </div>

                <div class="form__field<?= $fieldError('phone') !== '' ? ' has-error' : '' ?>">
                    <label class="form__label" for="cf-phone"><?= e(t('form.phone')) ?> <span aria-hidden="true">*</span></label>
                    <input class="form__input" type="tel" id="cf-phone" name="phone" required maxlength="24"
                           inputmode="tel" autocomplete="tel" placeholder="<?= e(t('form.phone_ph')) ?>"
                           value="<?= e($fieldValue('phone')) ?>"<?= $fieldError('phone') !== '' ? ' aria-invalid="true" aria-describedby="cf-phone-error"' : '' ?>>
                    <?php if ($fieldError('phone') !== '') : ?>
                        <p class="form__error" id="cf-phone-error"><?= e(t($fieldError('phone'))) ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form__row">
                <div class="form__field<?= $fieldError('service') !== '' ? ' has-error' : '' ?>">
                    <label class="form__label" for="cf-service"><?= e(t('form.service')) ?> <span aria-hidden="true">*</span></label>
                    <select class="form__select" id="cf-service" name="service" required<?= $fieldError('service') !== '' ? ' aria-invalid="true" aria-describedby="cf-service-error"' : '' ?>>
                        <option value=""><?= e(t('form.service_select')) ?></option>
                        <?php
                        $selectedService = $fieldValue('service', (string) ($formOptions['default_service'] ?? ''));
                        foreach (services() as $slug => $row) :
                            $optionValue = lx($row, 'name', $slug);
                            ?>
                            <option value="<?= e($optionValue) ?>"<?= ($selectedService === $optionValue || $selectedService === $slug) ? ' selected' : '' ?>><?= e($optionValue) ?></option>
                        <?php endforeach; ?>
                        <option value="Other"<?= $selectedService === 'Other' ? ' selected' : '' ?>><?= e(t('form.service_other')) ?></option>
                    </select>
                    <?php if ($fieldError('service') !== '') : ?>
                        <p class="form__error" id="cf-service-error"><?= e(t($fieldError('service'))) ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form__row">
                <div class="form__field<?= $fieldError('area') !== '' ? ' has-error' : '' ?>">
                    <label class="form__label" for="cf-area"><?= e(t('form.area')) ?> <span aria-hidden="true">*</span></label>
                    <select class="form__select" id="cf-area" name="area" required<?= $fieldError('area') !== '' ? ' aria-invalid="true" aria-describedby="cf-area-error"' : '' ?>>
                        <option value=""><?= e(t('form.area_select')) ?></option>
                        <?php
                        $selectedArea = $fieldValue('area', (string) ($formOptions['default_area'] ?? ''));
                        foreach (areas() as $slug => $row) :
                            $optionValue = lx($row, 'name', $slug);
                            ?>
                            <option value="<?= e($optionValue) ?>"<?= ($selectedArea === $optionValue || $selectedArea === $slug) ? ' selected' : '' ?>><?= e($optionValue) ?></option>
                        <?php endforeach; ?>
                        <option value="Other area in Kuwait"<?= $selectedArea === 'Other area in Kuwait' ? ' selected' : '' ?>><?= e(t('form.area_other')) ?></option>
                    </select>
                    <?php if ($fieldError('area') !== '') : ?>
                        <p class="form__error" id="cf-area-error"><?= e(t($fieldError('area'))) ?></p>
                    <?php endif; ?>
                </div>

                <fieldset class="form__field form__field--choice<?= $fieldError('contact_method') !== '' ? ' has-error' : '' ?>">
                    <legend class="form__label"><?= e(t('form.contact_method')) ?> <span aria-hidden="true">*</span></legend>
                    <div class="choice-group">
                        <?php
                                                $methods = [
                            'whatsapp' => t('form.contact_whatsapp'),
                            'phone'    => t('form.contact_phone'),
                        ];
                        $selectedMethod = $fieldValue('contact_method', 'whatsapp');
                        foreach ($methods as $value => $label) :
                            $inputId = 'cf-method-' . $value;
                            ?>
                            <label class="choice" for="<?= e($inputId) ?>">
                                <input type="radio" id="<?= e($inputId) ?>" name="contact_method" value="<?= e($value) ?>"
                                    <?= $selectedMethod === $value ? 'checked' : '' ?>>
                                <span><?= e($label) ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <?php if ($fieldError('contact_method') !== '') : ?>
                        <p class="form__error" id="cf-method-error"><?= e(t($fieldError('contact_method'))) ?></p>
                    <?php endif; ?>
                </fieldset>
            </div>

            <div class="form__field form__field--full<?= $fieldError('message') !== '' ? ' has-error' : '' ?>">
                <label class="form__label" for="cf-message"><?= e(t('form.message')) ?> <span aria-hidden="true">*</span></label>
                <textarea class="form__textarea" id="cf-message" name="message" rows="5" required maxlength="1500"
                          placeholder="<?= e(t('form.message_ph')) ?>"<?= $fieldError('message') !== '' ? ' aria-invalid="true" aria-describedby="cf-message-error"' : '' ?>><?= e($fieldValue('message')) ?></textarea>
                <?php if ($fieldError('message') !== '') : ?>
                    <p class="form__error" id="cf-message-error"><?= e(t($fieldError('message'))) ?></p>
                <?php endif; ?>
            </div>

            <div class="form__actions">
                <button class="btn btn--primary btn--lg" type="submit" data-submit>
                    <?= icon('mail', 'btn__icon', 20) ?>
                    <span class="btn__label" data-submit-label><?= e(t('form.submit')) ?></span>
                </button>
                <?= wa_button(whatsapp_quote_message(), t('cta.whatsapp_us'), 'whatsapp', ['class' => 'btn--lg']) ?>
                <p class="form__privacy">
                    <?= icon('shield', 'form__privacy-icon', 16) ?>
                    <span><?= e(t('form.privacy_note')) ?></span>
                    <a href="<?= e_url(url('/privacy-policy.php')) ?>"><?= e(t('footer.privacy')) ?></a>
                </p>
            </div>
        </form>
    </div>
</section>