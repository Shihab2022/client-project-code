<?php
/**
 * =====================================================================
 *  BOOTSTRAP  —  included by every public page (and the form action)
 * =====================================================================
 *  Responsibilities
 *    1. load configuration (local overrides first) + helpers
 *    2. resolve install base path, current page path and URL mode
 *    3. resolve the active language and direction (LTR / RTL)
 *    4. send security headers
 *    5. redirect bare URLs to their language prefixed URL
 * =====================================================================
 */

$__root = dirname(__DIR__);

/* 1. configuration -------------------------------------------------- */
if (is_file($__root . '/config/config.local.php')) {
    require $__root . '/config/config.local.php';   // local overrides win
}
require $__root . '/config/config.php';

require $__root . '/includes/functions.php';
require $__root . '/includes/security.php';
require $__root . '/includes/mailer.php';
require $__root . '/includes/ui.php';
require $__root . '/includes/area-map.php';

/* 2. base path + current page --------------------------------------- */
function normalized_uri_path(): string
{
    $uri = $_SERVER['REQUEST_URI'] ?? '/';
    $uri = parse_url($uri, PHP_URL_PATH) ?? '/';
    $uri = rawurldecode($uri);
    $uri = preg_replace('#/{2,}#', '/', $uri) ?? $uri;

    return $uri === '' ? '/' : $uri;
}

$scriptFile = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_FILENAME'] ?? ''));
$scriptName = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? ''));
$rootReal   = str_replace('\\', '/', (string) (realpath($__root) ?: $__root));

$relativeScript = '';
if ($scriptFile !== '' && str_starts_with($scriptFile, $rootReal)) {
    $relativeScript = substr($scriptFile, strlen($rootReal));
}

if ($relativeScript !== '' && $scriptName !== '' && str_ends_with($scriptName, $relativeScript)) {
    $basePath = substr($scriptName, 0, -strlen($relativeScript));
} else {
    $basePath = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');
}
/* Some SAPIs (e.g. the PHP built-in server with a router script) put the
   whole request path into SCRIPT_NAME. A trailing language segment is the
   language prefix, never an install directory, so it is stripped here. */
if (preg_match('#/(?:en|ar)$#', $basePath)) {
    $basePath = substr($basePath, 0, -3);
}
$basePath = rtrim($basePath, '/');
if ($basePath === '/' || $basePath === '.') {
    $basePath = '';
}
$GLOBALS['BASE_PATH'] = $basePath;

$uriPath = normalized_uri_path();
$pathWithoutBase = $uriPath;
if ($basePath !== '' && str_starts_with($uriPath, $basePath)) {
    $pathWithoutBase = substr($uriPath, strlen($basePath));
}
$pathWithoutBase = '/' . ltrim($pathWithoutBase, '/');

/* 3. language ------------------------------------------------------- */
$uriLang = '';
if (preg_match('#^/(en|ar)(?=/|$)#', $pathWithoutBase, $m)) {
    $uriLang = $m[1];
}

$requestedLang = '';
if (isset($_GET['lang']) && is_string($_GET['lang'])) {
    $requestedLang = strtolower(preg_replace('/[^A-Za-z]/', '', $_GET['lang']));
} elseif ($uriLang !== '') {
    $requestedLang = $uriLang;
} elseif (!empty($_COOKIE['site_lang'])) {
    $requestedLang = strtolower(preg_replace('/[^A-Za-z]/', '', (string) $_COOKIE['site_lang']));
}
if (!in_array($requestedLang, SUPPORTED_LANGS, true)) {
    $requestedLang = DEFAULT_LANG;
}
$GLOBALS['ACTIVE_LANG'] = $requestedLang;
if (empty($_COOKIE['site_lang']) || $_COOKIE['site_lang'] !== $requestedLang) {
    setcookie('site_lang', $requestedLang, [
        'expires'  => time() + 31536000,
        'path'     => '/',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
}

/* URL mode: prefixed (/en/...) or query (?lang=..) */
$urlMode = URL_LANG_MODE;
if ($urlMode === 'auto') {
    $urlMode = ($uriLang !== '' || isset($_GET['lang'])) ? 'prefixed' : 'query';
}
$GLOBALS['URL_MODE'] = $urlMode;

/* Current page path (relative to the install root) + query string */
if ($relativeScript !== '' && is_file($__root . $relativeScript)) {
    $currentPath = $relativeScript;
} else {
    $currentPath = preg_replace('#^/(en|ar)#', '', $pathWithoutBase) ?: '/index.php';
    if ($currentPath === '/') {
        $currentPath = '/index.php';
    }
}

/* In prefixed mode, CURRENT_PATH must never carry the /en or /ar prefix:
   when /ar/index.php is served directly (e.g. via Apache or the dev router),
   $relativeScript contains the prefix and must be normalised. */
if ($urlMode === 'prefixed' && $uriLang !== '') {
    $currentPath = preg_replace('#^/(en|ar)(?=/|$)#', '', $currentPath) ?: '/index.php';
    if ($currentPath === '/') {
        $currentPath = '/index.php';
    }
}
$GLOBALS['CURRENT_PATH'] = $currentPath;

$queryForLinks = $_SERVER['QUERY_STRING'] ?? '';
$queryForLinks = preg_replace('/(?:^|&)lang=[a-z]{2}/i', '', $queryForLinks) ?? '';
$GLOBALS['CURRENT_QUERY'] = ltrim($queryForLinks, '&');

/* ---------------------------------------------------------------------
 | 6. Session (CSRF token, flash messages, form rate limiting)
 |
 |  Started here – before any output – so that the cookie can be delivered
 |  with the response headers. The contact form is rendered deep inside the
 |  page markup; if the session were started there, session_start() would
 |  fail ("headers already sent") and the CSRF token could never persist.
 * -------------------------------------------------------------------*/
if (PHP_SAPI !== 'cli') {
    secure_session_start();
}

/* 4. redirect the bare URL to its language prefixed URL ------------- */
if ($urlMode === 'prefixed' && REDIRECT_TO_LANG_PREFIX && $uriLang === '' && PHP_SAPI !== 'cli') {
    $method       = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    $hasLangQuery = isset($_GET['lang']);
    $skip         = is_unprefixed_path($currentPath) || $hasLangQuery;
    if (!$skip && ($method === 'GET' || $method === 'HEAD') && empty($_POST)) {
        /* Remembered language wins: an Arabic-preferring visitor who types
           the bare domain should land on /ar/, not be forced back to /en/. */
        $targetLang = DEFAULT_LANG;
        if (!empty($_COOKIE['site_lang']) && in_array((string) $_COOKIE['site_lang'], SUPPORTED_LANGS, true)) {
            $targetLang = (string) $_COOKIE['site_lang'];
        }
        $target = $basePath . '/' . $targetLang . ($currentPath === '/index.php' ? '/' : $currentPath);
        if ($GLOBALS['CURRENT_QUERY'] !== '') {
            $target .= '?' . $GLOBALS['CURRENT_QUERY'];
        }
        header('Location: ' . $target, true, 301);
        exit;
    }
}

/* 5. security headers ---------------------------------------------- */
if (PHP_SAPI !== 'cli' && !headers_sent()) {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
    header('Cross-Origin-Opener-Policy: same-origin');
    if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https')) {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
    }
    header("Content-Security-Policy: default-src 'self'; img-src 'self' data:; "
        . "style-src 'self' 'unsafe-inline'; script-src 'self'; font-src 'self' data:; "
        . "frame-src https://www.google.com https://maps.google.com https://www.google.com/maps; "
        . "form-action 'self'; base-uri 'self'; object-src 'none'");
}

/* Page defaults – individual pages override them before the header runs */
if (!isset($page) || !is_array($page)) {
    $page = [];
}
$page = array_merge([
    'slug'        => 'home',
    'title'       => t('seo.default_title', ['company' => COMPANY_NAME]),
    'description' => t('seo.default_description', ['company' => COMPANY_NAME]),
    'keywords'    => '',
    'image'       => '/assets/images/og-cover.webp',
    'breadcrumbs' => [],
    'schema'      => [],
    'body_class'  => '',
    'robots'      => 'index, follow',
], $page);