<?php
/**
 * =====================================================================
 *  FLOATING CONTACT CONTROLS  (desktop + tablet)
 * =====================================================================
 *  Small, always reachable WhatsApp and call buttons that never cover
 *  the reading area. On mobile the sticky bottom action bar is used
 *  instead (see includes/footer.php).
 * =====================================================================
 */

if (!function_exists('t')) {
    require_once __DIR__ . '/bootstrap.php';
}
?>
<div class="floating-cta" data-floating-cta>
    <a class="floating-cta__btn floating-cta__btn--wa"
       href="<?= e_url(whatsapp_url(whatsapp_quote_message())) ?>"
       target="_blank" rel="noopener noreferrer"
       aria-label="<?= e(t('cta.whatsapp_us')) ?>">
        <?= icon('whatsapp', 'floating-cta__icon', 24) ?>
        <span class="floating-cta__label"><?= e(t('cta.whatsapp_us')) ?></span>
    </a>
    <a class="floating-cta__btn floating-cta__btn--call"
       href="<?= e_url(tel_url()) ?>"
       aria-label="<?= e(t('cta.call_now')) ?>">
        <?= icon('phone', 'floating-cta__icon', 22) ?>
        <span class="floating-cta__label"><?= e(t('cta.call_now')) ?></span>
    </a>
</div>