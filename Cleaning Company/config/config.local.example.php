<?php
/**
 * =====================================================================
 *  LOCAL OVERRIDES  —  copy this file to config/config.local.php
 * =====================================================================
 *  config/config.local.php is loaded BEFORE config/config.php, so any
 *  constant defined here replaces the placeholder value.
 *  It is git-ignored and blocked from direct web access by .htaccess.
 *
 *  Never commit real SMTP passwords into this file: set them as
 *  environment variables on the server instead (see $smtp below).
 */

/* --- 1. Business information ---------------------------------------- */
define('COMPANY_NAME', 'YOUR COMPANY NAME');
define('COMPANY_LEGAL_NAME', 'YOUR COMPANY NAME (W.L.L.)');
define('COMPANY_SHORT_NAME', 'YOUR BRAND');
define('COMPANY_TAGLINE', 'Professional Cleaning Services in Kuwait');
define('COMPANY_FOUNDED_YEAR', '');

/* --- 2. Contact details --------------------------------------------- */
define('COMPANY_PHONE', '+965 9787 6711');
define('COMPANY_PHONE_E164', '+96597876711');      // digits only behind the + sign
define('COMPANY_WHATSAPP', '96597876711');         // digits only – used for wa.me links
define('COMPANY_EMAIL', 'info@example.com');
define('COMPANY_ADDRESS', 'Your street, Block X, Kuwait City, Kuwait');
define('COMPANY_GOOGLE_MAPS_URL', 'https://maps.google.com/...');
define('COMPANY_MAP_EMBED_URL', 'https://www.google.com/maps/embed?pb=...');
define('COMPANY_WORKING_HOURS', 'Saturday – Thursday: 7:00 AM – 10:00 PM | Friday: 2:00 PM – 10:00 PM');

/* --- 3. Website ----------------------------------------------------- */
define('SITE_URL', 'https://your-domain.com');     // no trailing slash

/* --- 4. Optional: analytics + email -------------------------------- */
// define('GOOGLE_ANALYTICS_ID', 'G-XXXXXXXXXX');
// define('CONTACT_RECIPIENT', 'info@example.com');
// define('MAIL_FROM', 'no-reply@your-domain.com');

/**
 * --- 5. SMTP -------------------------------------------------------
 * Preferred: set these as environment variables on the server
 *   CLEANING_SMTP_HOST, CLEANING_SMTP_PORT, CLEANING_SMTP_USER,
 *   CLEANING_SMTP_PASS, CLEANING_SMTP_SECURE (tls|ssl)
 * cPanel -> "MultiPHP INI Editor" or the SetEnv/SetEnvIf directive in
 * .htaccess can be used on hosts where environment variables are
 * limited. Do not paste the password into a tracked file.
 *
 * define('MAIL_METHOD', 'smtp');
 * define('SMTP_HOST', 'smtp.your-host.com');
 * define('SMTP_PORT', 587);
 * define('SMTP_USER', 'postmaster@your-domain.com');
 * define('SMTP_PASS', getenv('CLEANING_SMTP_PASS') ?: '');
 */

/* --- 6. Go live ----------------------------------------------------- */
// define('PRODUCTION', true);