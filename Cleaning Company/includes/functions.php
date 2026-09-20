<?php
/**
 * =====================================================================
 *  CORE HELPERS  —  escaping, i18n, URLs, WhatsApp / call, data access
 * =====================================================================
 */

/* ---------------------------------------------------------------------
 | A. Language + translation
 * -------------------------------------------------------------------*/

/** Currently active language code (en|ar). */
function lang(): string
{
    return $GLOBALS['ACTIVE_LANG'] ?? DEFAULT_LANG;
}

/** True when the active language is written right to left. */
function is_rtl(): bool
{
    return in_array(lang(), ['ar', 'he', 'fa', 'ur'], true);
}

/** Direction value for <html dir="...">. */
function text_direction(): string
{
    return is_rtl() ? 'rtl' : 'ltr';
}

/**
 * Company name in the active language (falls back to COMPANY_NAME).
 * Uses COMPANY_NAME_AR when the visitor is reading Arabic.
 */
function company_name(): string
{
    if (lang() !== DEFAULT_LANG && defined('COMPANY_NAME_AR')) {
        $ar = (string) constant('COMPANY_NAME_AR');
        if ($ar !== '') {
            return $ar;
        }
    }

    return COMPANY_NAME;
}

/**
 * Company tagline in the active language.
 */
function company_tagline(): string
{
    if (lang() !== DEFAULT_LANG && defined('COMPANY_TAGLINE_AR')) {
        $ar = (string) constant('COMPANY_TAGLINE_AR');
        if ($ar !== '') {
            return $ar;
        }
    }

    if (defined('COMPANY_TAGLINE') && COMPANY_TAGLINE !== '') {
        return COMPANY_TAGLINE;
    }

    return t('header.tagline');
}

/**
 * Language aware image ALT text.
 * alt_text('Cleaning team in Kuwait', 'فريق تنظيف في الكويت')
 */
function alt_text(string $en, string $ar = ''): string
{
    if (lang() === 'ar' && $ar !== '') {
        return $ar;
    }

    return $en;
}

/**
 * Translate a key from /lang/{lang}.php with graceful fallback to English.
 * Usage: t('nav.services')  |  t('cta.whatsapp_about', ['service' => 'Villa Cleaning'])
 */
function t(string $key, array $replace = []): string
{
    static $cache = [];

    $current = lang();
    if (!isset($cache[$current])) {
        $cache[$current] = load_lang_file($current);
    }
    $line = $cache[$current][$key] ?? null;

    if ($line === null) {
        if (!isset($cache[DEFAULT_LANG])) {
            $cache[DEFAULT_LANG] = load_lang_file(DEFAULT_LANG);
        }
        $line = $cache[DEFAULT_LANG][$key] ?? $key;
    }

    foreach ($replace as $k => $v) {
        $line = str_replace(':' . $k, (string) $v, $line);
    }

    return $line;
}

/** Load a translation array from disk (returns [] when the file is missing). */
function load_lang_file(string $code): array
{
    $code = preg_replace('/[^a-z]/', '', strtolower($code));
    $file = __DIR__ . '/../lang/' . $code . '.php';
    if (!is_file($file)) {
        return [];
    }
    $data = require $file;

    return is_array($data) ? $data : [];
}

/**
 * Pick the right value from a bilingual data row.
 * lx(['title' => 'Villa Cleaning', 'title_ar' => 'تنظيف الفلل'], 'title')
 */
function lx(array $row, string $key, string $fallback = ''): string
{
    if (lang() !== DEFAULT_LANG) {
        $localized = $row[$key . '_' . lang()] ?? '';
        if ($localized !== '') {
            return (string) $localized;
        }
    }
    if (!empty($row[$key])) {
        return (string) $row[$key];
    }

    return $fallback;
}

/**
 * Pick the right LIST (array) value from a bilingual data row.
 * Companion of lx() for array fields such as 'includes', 'features', 'faq'.
 * The Arabic overlay stores lists as `<key>_ar`, so:
 * lxa(['features' => [...], 'features_ar' => [...]], 'features')
 */
function lxa(array $row, string $key, array $fallback = []): array
{
    if (lang() !== DEFAULT_LANG) {
        $localized = $row[$key . '_' . lang()] ?? null;
        if (is_array($localized) && $localized !== []) {
            return $localized;
        }
    }
    $value = $row[$key] ?? null;

    return is_array($value) ? $value : $fallback;
}

/* ---------------------------------------------------------------------
 | Arabic content overlay
 |
 | All Arabic content for the data-driven sections (services, areas,
 | FAQs, gallery, testimonials, trust points, process steps …) lives in
 | ONE file: /data/ar-content.php. When the site runs in Arabic, data()
 | merges each entry into the matching row as `<field>_ar` keys, so the
 | standard lx()/lxa() helpers pick it up everywhere without any change
 | to the English source files.
 * -------------------------------------------------------------------*/

/** The Arabic overlay file (loaded once per request). */
function ar_overlay(): array
{
    static $overlay = null;
    if ($overlay === null) {
        $file    = __DIR__ . '/../data/ar-content.php';
        $overlay = is_file($file) ? (array) require $file : [];
    }

    return $overlay;
}

/** Merge one overlay entry into a data row as `<field>_ar` keys. */
function merge_overlay_row(array &$row, array $overlayRow): void
{
    foreach ($overlayRow as $key => $value) {
        if ($value === null || $value === '' || $value === []) {
            continue;
        }
        $row[$key . '_ar'] = $value;
    }
}

/** Apply /data/ar-content.php to a /data array (no-op outside Arabic). */
function apply_ar_overlay(string $name, array $data): array
{
    if (lang() !== 'ar') {
        return $data;
    }

    $overlay = ar_overlay();
    if (!$overlay) {
        return $data;
    }

    switch ($name) {
        case 'services':
            foreach ((array) ($overlay['services'] ?? []) as $slug => $row) {
                if (isset($data['services'][$slug]) && is_array($row)) {
                    merge_overlay_row($data['services'][$slug], $row);
                }
            }
            foreach ((array) ($overlay['categories'] ?? []) as $catKey => $row) {
                if (isset($data['categories'][$catKey]) && is_array($row)) {
                    merge_overlay_row($data['categories'][$catKey], $row);
                }
            }
            foreach ((array) ($overlay['default_process'] ?? []) as $i => $row) {
                if (isset($data['default_process'][$i]) && is_array($row)) {
                    merge_overlay_row($data['default_process'][$i], $row);
                }
            }
            foreach ((array) ($overlay['default_why'] ?? []) as $i => $row) {
                if (isset($data['default_why'][$i]) && is_array($row)) {
                    merge_overlay_row($data['default_why'][$i], $row);
                }
            }
            break;

        case 'areas':
            foreach ((array) ($overlay['areas'] ?? []) as $slug => $row) {
                if (isset($data['areas'][$slug]) && is_array($row)) {
                    merge_overlay_row($data['areas'][$slug], $row);
                }
            }
            break;

        case 'faqs':
            foreach ((array) ($overlay['faqs'] ?? []) as $groupKey => $items) {
                if (isset($data['groups'][$groupKey]) && is_array($items) && $items !== []) {
                    $data['groups'][$groupKey]['items_ar'] = $items;
                }
            }
            break;

        case 'testimonials':
            foreach ((array) ($overlay['testimonials'] ?? []) as $i => $row) {
                if (isset($data['testimonials'][$i]) && is_array($row)) {
                    merge_overlay_row($data['testimonials'][$i], $row);
                }
            }
            break;

        case 'trust-points':
            foreach ((array) ($overlay['trust_points'] ?? []) as $i => $row) {
                if (isset($data['points'][$i]) && is_array($row)) {
                    merge_overlay_row($data['points'][$i], $row);
                }
            }
            break;

        case 'gallery':
            foreach ((array) ($overlay['gallery_items'] ?? []) as $i => $row) {
                if (isset($data['items'][$i]) && is_array($row)) {
                    merge_overlay_row($data['items'][$i], $row);
                }
            }
            break;

        case 'before-after':
            foreach ((array) ($overlay['before_after'] ?? []) as $i => $row) {
                if (isset($data['items'][$i]) && is_array($row)) {
                    merge_overlay_row($data['items'][$i], $row);
                }
            }
            break;
    }

    return $data;
}

/* ---------------------------------------------------------------------
 | B. Escaping
 * -------------------------------------------------------------------*/

/** Escape for HTML text / attribute context. */
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Escape a URL for an attribute (blocks javascript:/data: URIs). */
function e_url(?string $value): string
{
    $value = trim((string) $value);
    if ($value === '' || preg_match('#^(javascript|data|vbscript):#i', $value)) {
        return '#';
    }

    return e($value);
}

/* ---------------------------------------------------------------------
 | C. URLs  (language aware, works with and without mod_rewrite)
 * -------------------------------------------------------------------*/

/** Base path the project lives in, e.g. '' or '/cleaning-company'. */
function base_path(): string
{
    return $GLOBALS['BASE_PATH'] ?? '';
}

/** Files that must never carry a language prefix. */
function is_unprefixed_path(string $path): bool
{
    foreach (['/actions/', '/sitemap', '/robots', '/config/', '/tools/', '/assets/'] as $skip) {
        if (str_starts_with($path, $skip)) {
            return true;
        }
    }

    return false;
}

/** Path of a page including the language prefix, e.g. /en/services/villa-cleaning.php */
function path_with_lang(string $path): string
{
    $path = '/' . ltrim($path, '/');
    if (is_unprefixed_path($path)) {
        return $path;
    }

    $prefix = ($GLOBALS['URL_MODE'] ?? 'prefixed') === 'prefixed' ? '/' . lang() : '';

    return $prefix . $path;
}

/** Browser URL of a page (language prefix + install sub-directory included). */
function url(string $path = '/'): string
{
    if ($path === '/' || $path === '') {
        return base_path() . path_with_lang('/');
    }

    return base_path() . path_with_lang($path);
}

/** Absolute URL used for canonical / Open Graph / JSON-LD. */
function abs_url(string $path = '/'): string
{
    return rtrim(SITE_URL, '/') . url($path);
}

/** Language switcher target: the same page in the other language. */
function lang_switch_url(string $code): string
{
    $current = $GLOBALS['CURRENT_PATH'] ?? '/index.php';
    $query   = $GLOBALS['CURRENT_QUERY'] ?? '';
    $mode    = $GLOBALS['URL_MODE'] ?? 'prefixed';

    /* Normalise: strip any language prefix that leaked into CURRENT_PATH
       (happens when /en/index.php or /ar/index.php are served directly). */
    if ($mode === 'prefixed') {
        $current = preg_replace('#^/(en|ar)(?=/|$)#', '', $current);
        if ($current === '' || $current === null) {
            $current = '/index.php';
        } elseif ($current === '/') {
            $current = '/index.php';
        }
    }

    if ($mode === 'prefixed') {
        $target = base_path() . '/' . $code . ($current === '/index.php' ? '/' : $current);
    } else {
        $target = base_path() . $current;
        if (preg_match('/lang=[a-z]{2}/', $query)) {
            $query = preg_replace('/lang=[a-z]{2}/', 'lang=' . $code, $query);
        } else {
            $query = ltrim($query . '&lang=' . $code, '&');
        }
    }

    return $query === '' ? $target : $target . '?' . $query;
}

/* ---------------------------------------------------------------------
 | D. Assets and media
 * -------------------------------------------------------------------*/

/** Static asset URL with cache busting and optional minified replacement. */
function asset(string $path): string
{
    $path = '/' . ltrim($path, '/');
    $fs   = __DIR__ . '/..' . $path;

    if (PRODUCTION) {
        $min = preg_replace('#\.(css|js)$#', '.min.$1', $path);
        if ($min !== $path && is_file(__DIR__ . '/..' . $min)) {
            $path = $min;
        }
    }

    $version = is_file($fs) ? (string) filemtime($fs) : ASSET_VERSION;

    return base_path() . $path . '?v=' . $version;
}

/** Media URL (images, icons, fonts). */
function media(string $path): string
{
    return base_path() . '/' . ltrim($path, '/');
}

/** Image URL that falls back to the neutral placeholder graphic when missing. */
function img(string $path): string
{
    $path = '/' . ltrim($path, '/');
    if (!is_file(__DIR__ . '/..' . $path)) {
        $path = '/assets/images/placeholder.webp';
    }

    return base_path() . $path;
}

/** Pixel size of an image file, used to print CLS-free <img> tags. */
function image_size(string $path): array
{
    static $cache = [];
    $fs = __DIR__ . '/../' . ltrim($path, '/');
    if (isset($cache[$fs])) {
        return $cache[$fs];
    }
    $size = @getimagesize($fs);
    if (!$size) {
        $size = [800, 600];
    }

    return $cache[$fs] = [(int) $size[0], (int) $size[1]];
}

/* ---------------------------------------------------------------------
 | E. WhatsApp / direct call / e-mail
 * -------------------------------------------------------------------*/

/** Contextual WhatsApp deep link (opens in a new tab from the components). */
function whatsapp_url(string $message): string
{
    $number = preg_replace('/\D/', '', COMPANY_WHATSAPP);

    return 'https://wa.me/' . $number . '?text=' . rawurlencode($message);
}

/** Generic quotation message. */
function whatsapp_quote_message(): string
{
    return t('wa.quote_message');
}

/** Service specific message, optionally naming the customer's area in Kuwait. */
function whatsapp_service_message(string $serviceName, string $area = ''): string
{
    $message = t('wa.service_message', ['service' => $serviceName]);
    if ($area !== '') {
        $message .= ' ' . t('wa.area_message', ['area' => $area]);
    }

    return $message;
}

/** tel: link for direct calls (opens the dialler on mobile). */
function tel_url(): string
{
    return 'tel:' . preg_replace('/[^0-9+]/', '', COMPANY_PHONE_E164);
}

/** mailto: link with an optional prefilled subject. */
function mail_url(string $subject = ''): string
{
    return 'mailto:' . COMPANY_EMAIL . ($subject !== '' ? '?subject=' . rawurlencode($subject) : '');
}

/** True when a real phone number has been configured (placeholders contain "X"). */
function has_real_phone(): bool
{
    return (bool) preg_match('/\d{6,}/', COMPANY_PHONE_E164) && !str_contains(COMPANY_PHONE_E164, 'X');
}

/** True when a real WhatsApp number has been configured. */
function has_real_whatsapp(): bool
{
    return (bool) preg_match('/^\d{7,15}$/', preg_replace('/\D/', '', COMPANY_WHATSAPP));
}

/* ---------------------------------------------------------------------
 | F. Content data accessors (everything lives in /data – no database)
 * -------------------------------------------------------------------*/

/** Load and cache a /data file (Arabic overlay applied when lang = ar). */
function data(string $name): array
{
    static $cache = [];
    if (!isset($cache[$name])) {
        $file = __DIR__ . '/../data/' . $name . '.php';
        $cache[$name] = is_file($file) ? (array) require $file : [];
        $cache[$name] = apply_ar_overlay($name, $cache[$name]);
    }

    return $cache[$name];
}

/** All services keyed by slug. */
function services(): array
{
    return data('services')['services'] ?? [];
}

/** One service definition or null. */
function service(string $slug): ?array
{
    return services()[$slug] ?? null;
}

/** Service name in the active language. */
function service_name(string $slug): string
{
    $service = service($slug);

    return $service ? lx($service, 'name', $slug) : $slug;
}

/** Public URL of a service page. */
function service_url(string $slug): string
{
    return url('/services/' . $slug . '.php');
}

/** Service categories (residential | commercial | specialised). */
function service_categories(): array
{
    return data('services')['categories'] ?? [];
}

/** Services of one category, keeping the configured order. */
function services_by_category(string $category): array
{
    $result = [];
    foreach (services() as $slug => $row) {
        if (($row['category'] ?? '') === $category) {
            $result[$slug] = $row;
        }
    }

    return $result;
}

/** Short list of related services (used for internal linking). */
function related_services(string $slug, int $limit = 4): array
{
    $service = service($slug);
    $picked  = [];
    foreach ((array) ($service['related'] ?? []) as $related) {
        if (isset(services()[$related]) && $related !== $slug) {
            $picked[$related] = services()[$related];
        }
        if (count($picked) >= $limit) {
            return $picked;
        }
    }
    // Fill up with siblings from the same category.
    foreach (services() as $other => $row) {
        if ($other !== $slug && ($row['category'] ?? '') === ($service['category'] ?? '') && !isset($picked[$other])) {
            $picked[$other] = $row;
        }
        if (count($picked) >= $limit) {
            break;
        }
    }

    return $picked;
}

/** All Kuwait service areas keyed by slug. */
function areas(): array
{
    return data('areas')['areas'] ?? [];
}

/** One area definition or null. */
function area(string $slug): ?array
{
    return areas()[$slug] ?? null;
}

/** Area name in the active language. */
function area_name(string $slug): string
{
    $area = area($slug);

    return $area ? lx($area, 'name', $slug) : $slug;
}

/** Public URL of an area page. */
function area_url(string $slug): string
{
    return url('/areas/' . $slug . '.php');
}

/** Flat list of area names, used by the contact form select. */
function area_options(): array
{
    $options = [];
    foreach (areas() as $slug => $row) {
        $options[$slug] = lx($row, 'name', $slug);
    }

    return $options;
}

/** Service select options for forms (slug => localized name). */
function service_options(): array
{
    $options = [];
    foreach (services() as $slug => $row) {
        $options[$slug] = lx($row, 'name', $slug);
    }

    return $options;
}

/** FAQ groups (used by the FAQ page and per-service FAQ blocks). */
function faq_groups(): array
{
    return data('faqs')['groups'] ?? [];
}

/** Placeholder-marked testimonials. */
function testimonials(): array
{
    return data('testimonials')['testimonials'] ?? [];
}

/** Gallery items. */
function gallery_items(): array
{
    return data('gallery')['items'] ?? [];
}

/** Legal page content (privacy-policy | terms). */
function legal_page(string $key): array
{
    return data('legal')[$key] ?? [];
}

/** Trust / USP blocks used on several pages. */
function trust_points(): array
{
    return data('trust-points')['points'] ?? [];
}