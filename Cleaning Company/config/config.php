<?php
/**
 * =====================================================================
 *  CENTRAL CONFIGURATION  —  replace every placeholder with real data
 * =====================================================================
 *  This is the ONLY file that holds business information.
 *  No business value is hard-coded anywhere else in the project.
 *
 *  Recommended workflow
 *  --------------------
 *  1. Copy config/config.local.example.php  ->  config/config.local.php
 *  2. Put the real values in config.local.php (it is git-ignored and is
 *     blocked from direct web access by .htaccess).
 *  3. config.local.php is loaded BEFORE this file, so it always wins and
 *     your values survive future updates of this file.
 *
 *  SMTP credentials are NEVER stored in this file. Use the environment
 *  variables documented in config/config.local.example.php instead.
 *
 *  PHP 8+
 */

/* ---------------------------------------------------------------------
 | 1. COMPANY IDENTITY
 * -------------------------------------------------------------------*/
if (!defined('COMPANY_NAME'))            define('COMPANY_NAME', 'YOUR COMPANY NAME');
if (!defined('COMPANY_LEGAL_NAME'))      define('COMPANY_LEGAL_NAME', 'YOUR COMPANY NAME (W.L.L.)');
if (!defined('COMPANY_SHORT_NAME'))      define('COMPANY_SHORT_NAME', 'YOUR BRAND');
if (!defined('COMPANY_TAGLINE'))         define('COMPANY_TAGLINE', 'Professional Cleaning Services in Kuwait');
if (!defined('COMPANY_FOUNDED_YEAR'))    define('COMPANY_FOUNDED_YEAR', '');

/* ---------------------------------------------------------------------
 | 2. CONTACT DETAILS
 * -------------------------------------------------------------------*/
if (!defined('COMPANY_PHONE'))           define('COMPANY_PHONE', 'YOUR KUWAITI PHONE (+965 XXXX XXXX)');
if (!defined('COMPANY_PHONE_E164'))      define('COMPANY_PHONE_E164', '+965XXXXXXXX');
if (!defined('COMPANY_WHATSAPP'))        define('COMPANY_WHATSAPP', '965XXXXXXXX');
if (!defined('COMPANY_EMAIL'))           define('COMPANY_EMAIL', 'info@example.com');
if (!defined('COMPANY_ADDRESS'))         define('COMPANY_ADDRESS', 'Your street, Block X, Kuwait City, Kuwait');
if (!defined('COMPANY_CITY'))            define('COMPANY_CITY', 'Kuwait City');
if (!defined('COMPANY_COUNTRY'))         define('COMPANY_COUNTRY', 'Kuwait');
if (!defined('COMPANY_POSTAL_CODE'))     define('COMPANY_POSTAL_CODE', '');
if (!defined('COMPANY_GOOGLE_MAPS_URL')) define('COMPANY_GOOGLE_MAPS_URL', 'YOUR GOOGLE MAPS URL');
if (!defined('COMPANY_MAP_EMBED_URL'))   define('COMPANY_MAP_EMBED_URL', 'YOUR GOOGLE MAPS EMBED URL');
if (!defined('COMPANY_WORKING_HOURS'))   define('COMPANY_WORKING_HOURS', 'Saturday – Thursday: 7:00 AM – 10:00 PM | Friday: 2:00 PM – 10:00 PM');

/* Machine readable working hours used for Schema.org + the contact page.
   Format: day => [open, close] (24h "HH:MM"). Remove a day when closed. */
if (!defined('COMPANY_OPENING_HOURS')) {
    define('COMPANY_OPENING_HOURS', [
        'Saturday'  => ['07:00', '22:00'],
        'Sunday'    => ['07:00', '22:00'],
        'Monday'    => ['07:00', '22:00'],
        'Tuesday'   => ['07:00', '22:00'],
        'Wednesday' => ['07:00', '22:00'],
        'Thursday'  => ['07:00', '22:00'],
        'Friday'    => ['14:00', '22:00'],
    ]);
}

/* ---------------------------------------------------------------------
 | 3. SOCIAL PROFILES and SERVICE GEOGRAPHY
 * -------------------------------------------------------------------*/
if (!defined('COMPANY_INSTAGRAM'))       define('COMPANY_INSTAGRAM', 'YOUR INSTAGRAM URL');
if (!defined('COMPANY_FACEBOOK'))        define('COMPANY_FACEBOOK', 'YOUR FACEBOOK URL');
if (!defined('COMPANY_TIKTOK'))          define('COMPANY_TIKTOK', 'YOUR TIKTOK URL');
if (!defined('COMPANY_SERVICE_COUNTRY')) define('COMPANY_SERVICE_COUNTRY', 'Kuwait');
if (!defined('COMPANY_LANGUAGES'))       define('COMPANY_LANGUAGES', 'English, Arabic');

/* ---------------------------------------------------------------------
 | 4. WEBSITE / URL CONFIGURATION
 * -------------------------------------------------------------------*/
if (!defined('SITE_URL'))                define('SITE_URL', 'https://example.com');   // no trailing slash
if (!defined('DEFAULT_LANG'))            define('DEFAULT_LANG', 'en');
if (!defined('SUPPORTED_LANGS'))         define('SUPPORTED_LANGS', ['en', 'ar']);

/**
 * URL_LANG_MODE
 *   'prefixed' -> /en/services/villa-cleaning.php  and  /ar/services/villa-cleaning.php
 *                 (requires Apache mod_rewrite + the bundled .htaccess, or router.php)
 *   'query'    -> /services/villa-cleaning.php?lang=ar  (works on any PHP host)
 */
if (!defined('URL_LANG_MODE'))           define('URL_LANG_MODE', 'prefixed');

/** Redirect bare URLs to their language prefixed URL (only with URL_LANG_MODE = 'prefixed'). */
if (!defined('REDIRECT_TO_LANG_PREFIX')) define('REDIRECT_TO_LANG_PREFIX', true);

/** Minimum seconds between two contact form submissions from one visitor. */
if (!defined('FORM_MIN_INTERVAL'))       define('FORM_MIN_INTERVAL', 30);

/** Set to true on the production host: enables minified assets + caching headers. */
if (!defined('PRODUCTION'))              define('PRODUCTION', false);

/** Cache-busting version appended to CSS/JS URLs. Bump after editing assets. */
if (!defined('ASSET_VERSION'))           define('ASSET_VERSION', '1.0.0');

/* ---------------------------------------------------------------------
 | 5. EMAIL DELIVERY (contact form)
 * -------------------------------------------------------------------*/
if (!defined('MAIL_METHOD'))             define('MAIL_METHOD', 'mail');      // 'mail' or 'smtp'
if (!defined('CONTACT_RECIPIENT'))       define('CONTACT_RECIPIENT', 'info@example.com');
if (!defined('MAIL_FROM'))               define('MAIL_FROM', 'no-reply@example.com');
if (!defined('MAIL_FROM_NAME'))          define('MAIL_FROM_NAME', COMPANY_NAME);

/* SMTP – credentials come from the environment, never from the codebase. */
if (!defined('SMTP_HOST'))               define('SMTP_HOST', getenv('CLEANING_SMTP_HOST') ?: '');
if (!defined('SMTP_PORT'))               define('SMTP_PORT', (int) (getenv('CLEANING_SMTP_PORT') ?: 587));
if (!defined('SMTP_USER'))               define('SMTP_USER', getenv('CLEANING_SMTP_USER') ?: '');
if (!defined('SMTP_PASS'))               define('SMTP_PASS', getenv('CLEANING_SMTP_PASS') ?: '');
if (!defined('SMTP_SECURE'))             define('SMTP_SECURE', getenv('CLEANING_SMTP_SECURE') ?: 'tls'); // tls | ssl
if (!defined('SMTP_TIMEOUT'))            define('SMTP_TIMEOUT', 15);

/* ---------------------------------------------------------------------
 | 6. ANALYTICS (optional – leave empty to disable completely)
 * -------------------------------------------------------------------*/
if (!defined('GOOGLE_ANALYTICS_ID'))      define('GOOGLE_ANALYTICS_ID', '');
if (!defined('GOOGLE_SEARCH_CONSOLE_ID')) define('GOOGLE_SEARCH_CONSOLE_ID', '');

/* ---------------------------------------------------------------------
 | 7. CONTENT HONESTY FLAGS
 * -------------------------------------------------------------------*/
/**
 * COMPANY_STATS and the testimonials in /data are shipped as clearly
 * marked placeholders. While the flags below are true the website shows
 * a visible note, so no placeholder figure or sample review is ever
 * presented publicly as a verified fact.
 * Set a flag to false once the real figures / real reviews exist.
 */
if (!defined('SHOW_PLACEHOLDER_NOTE_STATS'))        define('SHOW_PLACEHOLDER_NOTE_STATS', true);
if (!defined('SHOW_PLACEHOLDER_NOTE_TESTIMONIALS')) define('SHOW_PLACEHOLDER_NOTE_TESTIMONIALS', true);

/** Statistics shown on the website. Replace with verified company data. */
if (!defined('COMPANY_STATS')) {
    define('COMPANY_STATS', [
        ['value' => 10,   'suffix' => '+', 'label' => 'Years of experience',     'placeholder' => true],
        ['value' => 5000, 'suffix' => '+', 'label' => 'Completed cleaning jobs', 'placeholder' => true],
        ['value' => 100,  'suffix' => '+', 'label' => 'Trained cleaning staff',  'placeholder' => true],
        ['value' => 100,  'suffix' => '%', 'label' => 'Kuwait coverage areas',   'placeholder' => true],
    ]);
}