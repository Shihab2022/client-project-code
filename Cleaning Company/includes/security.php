<?php
/**
 * =====================================================================
 *  SECURITY HELPERS  —  CSRF, sanitization, validation, rate limiting
 *  No database is involved: state lives in the PHP session only.
 * =====================================================================
 */

/** Start a hardened session (called once from the bootstrap). */
function secure_session_start(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');

    /* Reject session ids supplied by the visitor that do not exist server side. */
    @ini_set('session.use_strict_mode', '1');
    /* Only allow the id to travel in the cookie, never in the URL. */
    @ini_set('session.use_only_cookies', '1');

    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'httponly' => true,
        'secure'   => $https,
        'samesite' => 'Lax',
    ]);
    session_name('cleaningsite_session');
    session_start();
}

/* ---------------------------------------------------------------------
 | CSRF
 * -------------------------------------------------------------------*/

/** Current CSRF token (created on first use). */
function csrf_token(): string
{
    secure_session_start();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

/** Hidden CSRF input for a form. */
function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

/** Constant time CSRF check. */
function csrf_verify(?string $token): bool
{
    secure_session_start();

    return is_string($token) && !empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/** Anti-spam time trap: the form records when it was rendered. */
function form_time_field(): string
{
    return '<input type="hidden" name="form_started_at" value="' . time() . '">';
}

/** Honeypot field – must stay empty; bots fill every input they find. */
function form_honeypot_field(): string
{
    return '<div class="hp-field" aria-hidden="true">'
        . '<label for="company_website_hp">Website</label>'
        . '<input type="text" id="company_website_hp" name="company_website" value="" tabindex="-1" autocomplete="off">'
        . '</div>';
}

/* ---------------------------------------------------------------------
 | Sanitization + validation
 * -------------------------------------------------------------------*/

/** Single line text: strips tags, control characters and header-injection attempts. */
function sanitize_line(?string $value, int $maxLength = 190): string
{
    $value = str_replace(["\r", "\n", "%0a", "%0d", "%0A", "%0D"], ' ', (string) $value);
    $value = strip_tags($value);
    $value = preg_replace('/[\x00-\x1F\x7F]/u', '', $value) ?? '';
    $value = trim(preg_replace('/\s+/u', ' ', $value) ?? '');

    return mb_substr($value, 0, $maxLength);
}

/** Multi line text: keeps line breaks, strips markup. */
function sanitize_multiline(?string $value, int $maxLength = 2000): string
{
    $value = strip_tags((string) $value);
    $value = str_replace(["\r\n", "\r"], "\n", $value);
    $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $value) ?? '';
    $value = preg_replace("/\n{3,}/", "\n\n", $value) ?? '';

    return mb_substr(trim($value), 0, $maxLength);
}

/** Valid e-mail address? */
function is_valid_email(?string $value): bool
{
    $value = trim((string) $value);

    return $value !== '' && mb_strlen($value) <= 190 && filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Kuwait friendly phone validation.
 * Accepts +965 XXXXXXXX, 965XXXXXXXX, XXXXXXXX, 6XXXXXXX / 9XXXXXXX mobiles
 * and 1XXXXXXX / 2XXXXXXX landlines. Spaces, dashes and brackets are ignored.
 */
function is_valid_phone(?string $value): bool
{
    $digits = preg_replace('/\D/', '', (string) $value);
    if (str_starts_with($digits, '965')) {
        $digits = substr($digits, 3);
    }

    return (bool) preg_match('/^[12569]\d{6,7}$/', $digits);
}

/** Normalised phone number for storage in the notification e-mail. */
function normalize_phone(?string $value): string
{
    $raw    = sanitize_line($value, 40);
    $digits = preg_replace('/\D/', '', $raw);
    if (str_starts_with($digits, '965')) {
        return '+965 ' . substr($digits, 3);
    }

    return $raw;
}

/**
 * Light spam scoring for the message body.
 *
 * The primary bot defences live elsewhere (honeypot field, CSRF token,
 * timing trap and the session rate limit). This check only catches
 * unsolicited-solicitation text that a real cleaning enquiry would never
 * contain, so it stays deliberately narrow and cannot block a genuine
 * customer message.
 */
function looks_like_spam(string $message, string $name): bool
{
    $haystack = $message . ' ' . $name;

    if (preg_match_all('#https?://#i', $message) >= 4) {
        return true;
    }
    if (preg_match('/\[url=|<\s*a\s+href|viagra|casino|crypto.{0,10}loan|seo\s+services\s+cheap/i', $haystack)) {
        return true;
    }

    /* 2b. Unsolicited outreach that a cleaning customer never writes:
           backlink / SEO / guest-post selling and investment pitches. */
    if (preg_match('/\b(backlinks?|guest\s?post|link\s?building|buy\s+followers|bitcoin\s+investment|forex\s+signals?|loan\s+offer|crypto\s+investment)\b/i', $haystack)) {
        return true;
    }

    /* 2c. The same URL pasted twice in a row. */
    if (preg_match('#(https?://\S+)\s+\1#i', $message)) {
        return true;
    }

    return false;
}

/** Reject submissions that were sent faster than a human can type. */
function form_timing_ok($startedAt, int $minimumSeconds = 3): bool
{
    if (!is_numeric($startedAt)) {
        return false;
    }

    return (time() - (int) $startedAt) >= $minimumSeconds;
}

/** Session based throttle: at most one submission per FORM_MIN_INTERVAL seconds. */
function form_rate_limit_ok(): bool
{
    secure_session_start();
    $last = (int) ($_SESSION['last_contact_submit'] ?? 0);
    if ($last > 0 && (time() - $last) < FORM_MIN_INTERVAL) {
        return false;
    }
    $_SESSION['last_contact_submit'] = time();

    return true;
}

/* ---------------------------------------------------------------------
 | Flash messages (used by actions/contact.php -> contact.php)
 * -------------------------------------------------------------------*/

/** Store a one-time message. */
function flash_set(string $key, string $value): void
{
    secure_session_start();
    $_SESSION['flash'][$key] = $value;
}

/** Read a one-time message and remove it. */
function flash_get(string $key): ?string
{
    secure_session_start();
    if (!isset($_SESSION['flash'][$key])) {
        return null;
    }
    $value = (string) $_SESSION['flash'][$key];
    unset($_SESSION['flash'][$key]);

    return $value;
}
