<?php
/**
 * =====================================================================
 *  CONTACT FORM HANDLER   (actions/contact.php)
 * =====================================================================
 *  Receives the inquiry form, validates + sanitizes every field and
 *  e-mails the result to CONTACT_RECIPIENT.
 *
 *  There is NO database anywhere in this flow:
 *    - nothing is written to MySQL, SQLite, Mongo or any storage engine
 *    - nothing is appended to a log file
 *    - the old input and the error list live in the PHP session only
 *      for the single redirect that follows (post/redirect/get), and
 *      are removed again as soon as the page is rendered.
 *
 *  Protections
 *    - CSRF token check (hash_equals)
 *    - honeypot field (bots fill it, humans never see it)
 *    - timing trap (a form sent in under 3 seconds is rejected)
 *    - session based rate limit (FORM_MIN_INTERVAL seconds)
 *    - every value goes through sanitize_line()/sanitize_multiline(),
 *      which strip CR/LF so header injection is impossible
 *    - the return path is restricted to a page of this website, so the
 *      redirect cannot be abused as an open redirect
 * =====================================================================
 */

require __DIR__ . '/../includes/bootstrap.php';

/** Send the visitor back to the form with a status flag. */
function contact_redirect(string $status, string $source): void
{
    $target  = url($source);
    $target .= (str_contains($target, '?') ? '&' : '?') . 'status=' . rawurlencode($status);

    header('Location: ' . $target . '#quote-form', true, 303);
    exit;
}

/* 1. POST only – a direct GET goes back to the contact page ---------- */
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Location: ' . url('/contact.php'), true, 303);
    exit;
}

/* 2. Where to send the visitor afterwards ---------------------------- */
$source = sanitize_line($_POST['source'] ?? '', 120);
if ($source === '' || !preg_match('#^/[A-Za-z0-9._/\-]*\.php$#', $source) || str_contains($source, '..')) {
    $source = '/contact.php';
}
$source = '/' . ltrim($source, '/');

/* Language of the submission (used in the notification e-mail). */
$formLang = strtolower(preg_replace('/[^A-Za-z]/', '', (string) ($_POST['lang'] ?? '')));
if (!in_array($formLang, SUPPORTED_LANGS, true)) {
    $formLang = lang();
}

/* 3. Raw -> sanitized input ----------------------------------------- */
$input = [
    'name'           => sanitize_line($_POST['name'] ?? '', 80),
    'phone'          => sanitize_line($_POST['phone'] ?? '', 24),
    'email'          => sanitize_line($_POST['email'] ?? '', 120),
    'service'        => sanitize_line($_POST['service'] ?? '', 120),
    'area'           => sanitize_line($_POST['area'] ?? '', 120),
    'contact_method' => sanitize_line($_POST['contact_method'] ?? '', 20),
    'message'        => sanitize_multiline($_POST['message'] ?? '', 1500),
];

if (!in_array($input['contact_method'], ['whatsapp', 'phone', 'email'], true)) {
    $input['contact_method'] = 'whatsapp';
}

/* 4. Spam / abuse checks -------------------------------------------- */
$errors = [];

/* Honeypot: a real visitor never fills this hidden field. It is treated
   as a successful send so a bot cannot learn that it was detected. */
if (!empty($_POST['company_website'])) {
    contact_redirect('sent', $source);
}

if (!csrf_verify($_POST['csrf_token'] ?? null)) {
    $errors['form'] = 'form.error_csrf';
}

if (!isset($errors['form']) && !form_timing_ok($_POST['form_started_at'] ?? null)) {
    $errors['form'] = 'form.error_spam';
}

if (!isset($errors['form']) && !form_rate_limit_ok()) {
    $errors['form'] = 'form.error_rate';
}

/* 5. Field validation (mirrors the messages used in the markup) ----- */
if (mb_strlen($input['name']) < 2) {
    $errors['name'] = 'form.error_name';
}
if ($input['phone'] === '' || !is_valid_phone($input['phone'])) {
    $errors['phone'] = 'form.error_phone';
}
if ($input['email'] !== '' && !is_valid_email($input['email'])) {
    $errors['email'] = 'form.error_email';
}
if ($input['service'] === '') {
    $errors['service'] = 'form.error_service';
}
if ($input['area'] === '') {
    $errors['area'] = 'form.error_area';
}
if (mb_strlen($input['message']) < 10) {
    $errors['message'] = 'form.error_message';
}

if (!isset($errors['form']) && !isset($errors['message'])
    && looks_like_spam($input['message'], $input['name'])) {
    $errors['form'] = 'form.error_spam';
}

/* 6. Errors -> keep the typed values in the session, redirect back --- */
if ($errors) {
    flash_set('contact_old', json_encode($input, JSON_UNESCAPED_UNICODE));
    flash_set('contact_errors', json_encode($errors, JSON_UNESCAPED_UNICODE));
    contact_redirect('error', $source);
}

/* 7. Delivery – e-mail only, no database write ---------------------- */
$fields = [
    'name'           => $input['name'],
    'phone'          => normalize_phone($input['phone']),
    'email'          => $input['email'],
    'service'        => $input['service'],
    'area'           => $input['area'],
    'contact_method' => $input['contact_method'],
    'message'        => $input['message'],
    'lang'           => $formLang,
    'page'           => $source,
];

[$sent, $errorKey] = send_inquiry($fields);

if (!$sent) {
    flash_set('contact_old', json_encode($input, JSON_UNESCAPED_UNICODE));
    flash_set('contact_errors', json_encode(['form' => 'form.error_send'], JSON_UNESCAPED_UNICODE));
    contact_redirect('error', $source);
}

/* 8. Success -------------------------------------------------------- */
contact_redirect('sent', $source);
