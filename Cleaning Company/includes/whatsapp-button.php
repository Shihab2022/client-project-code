<?php
/**
 * =====================================================================
 *  REUSABLE WHATSAPP COMPONENT
 * =====================================================================
 *  Every WhatsApp CTA on the website goes through this component so the
 *  number, the icon, the target and the contextual message stay in sync.
 *  The base implementation lives in includes/ui.php (wa_button()).
 *
 *  Usage:
 *      require_once __DIR__ . '/includes/whatsapp-button.php';
 *      echo whatsapp_button(whatsapp_service_message('Villa Cleaning'));
 * =====================================================================
 */

if (!function_exists('whatsapp_button')) {
    /**
     * @param string      $message Contextual, pre-filled WhatsApp message.
     * @param string|null $label   Button label (default: "WhatsApp Us").
     * @param string      $variant Button style: whatsapp | primary | light | ghost.
     * @param array       $extra   Extra btn() options (class, attrs, icon_pos…).
     */
    function whatsapp_button(string $message, ?string $label = null, string $variant = 'whatsapp', array $extra = []): string
    {
        return wa_button($message, $label, $variant, $extra);
    }
}

if (!function_exists('whatsapp_icon_link')) {
    /** Icon-only WhatsApp link (used in compact layouts). */
    function whatsapp_icon_link(string $message, string $label): string
    {
        return '<a class="icon-link icon-link--whatsapp" href="' . e_url(whatsapp_url($message)) . '"'
            . ' target="_blank" rel="noopener noreferrer" aria-label="' . e($label) . '">'
            . icon('whatsapp', 'icon', 20) . '</a>';
    }
}