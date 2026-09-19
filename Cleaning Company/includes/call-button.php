<?php
/**
 * =====================================================================
 *  REUSABLE DIRECT CALL COMPONENT
 * =====================================================================
 *  Produces a tel: link so mobile visitors open the dialler immediately.
 *  The base implementation lives in includes/ui.php (call_button()).
 *
 *  Usage:
 *      require_once __DIR__ . '/includes/call-button.php';
 *      echo call_button(t('cta.call_now'), 'accent');
 * =====================================================================
 */

if (!function_exists('call_button_partial')) {
    /** @param array $extra Extra btn() options (class, attrs…). */
    function call_button_partial(?string $label = null, string $variant = 'outline', array $extra = []): string
    {
        return call_button($label, $variant, $extra);
    }
}

if (!function_exists('phone_link')) {
    /** Inline phone link with the configured number. */
    function phone_link(string $class = ''): string
    {
        return '<a class="phone-link ' . e($class) . '" href="' . e_url(tel_url()) . '">'
            . icon('phone', 'phone-link__icon', 18) . '<span>' . e(COMPANY_PHONE) . '</span></a>';
    }
}