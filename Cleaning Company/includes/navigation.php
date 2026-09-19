<?php
/**
 * =====================================================================
 *  NAVIGATION  —  desktop mega menu + mobile drawer + language switch
 * =====================================================================
 *  Menu entries come from /data/site.php and /data/services.php, so a
 *  new service automatically appears in the menu without code changes.
 * =====================================================================
 */

/** Is the given nav entry the page currently being viewed? */
function nav_is_active(array $item): bool
{
    $current = (string) ($GLOBALS['CURRENT_PATH'] ?? '');
    foreach ((array) ($item['match'] ?? []) as $needle) {
        if ($current === '/' . ltrim($needle, '/')) {
            return true;
        }
    }

    // Service pages keep the matching top level section highlighted.
    if (str_starts_with($current, '/services/')) {
        foreach ((array) ($item['match'] ?? []) as $needle) {
            if (in_array($needle, ['services.php', 'residential-cleaning.php', 'commercial-cleaning.php', 'specialized-cleaning.php'], true)) {
                return true;
            }
        }
    }
    if (str_starts_with($current, '/areas/') && in_array('service-areas.php', (array) ($item['match'] ?? []), true)) {
        return true;
    }

    return false;
}

/** Category name for a top level nav entry. */
function nav_category_for(string $file): string
{
    return match ($file) {
        'residential-cleaning.php' => 'residential',
        'commercial-cleaning.php'  => 'commercial',
        default                    => 'specialised',
    };
}

/** One column of the mega menu (a service category). */
function nav_category_column(string $category): string
{
    $meta = service_categories()[$category] ?? [];
    if (!$meta) {
        return '';
    }

    $html = '<div class="mega__column">'
        . '<a class="mega__column-title" href="' . e_url((string) $meta['url']) . '">'
        . icon($meta['icon'] ?? 'sparkle', 'mega__column-icon', 20)
        . '<span>' . e(lx($meta, 'name', ucfirst($category))) . '</span>'
        . '</a><ul class="mega__list">';

    foreach (services_by_category($category) as $slug => $row) {
        $html .= '<li><a href="' . e_url(service_url($slug)) . '">' . e(lx($row, 'name', $slug)) . '</a></li>';
    }

    return $html . '</ul></div>';
}

/** Desktop navigation with mega menu and single level dropdowns. */
function nav_desktop(array $site_nav): string
{
    $html = '<ul class="main-nav__list" id="primary-menu">';

    foreach ($site_nav as $item) {
        $isServicesMega = !empty($item['mega']);
        $isCategory     = !$isServicesMega
            && in_array($item['match'][0] ?? '', ['residential-cleaning.php', 'commercial-cleaning.php', 'specialized-cleaning.php'], true);

        $classes = 'main-nav__item';
        if ($isServicesMega) {
            $classes .= ' main-nav__item--mega';
        }
        if ($isCategory) {
            $classes .= ' main-nav__item--has-children';
        }
        if (nav_is_active($item)) {
            $classes .= ' is-active';
        }

        $html .= '<li class="' . e($classes) . '">'
            . '<a class="main-nav__link" href="' . e_url($item['url']) . '"'
            . (nav_is_active($item) ? ' aria-current="page"' : '') . '>'
            . '<span>' . e(t($item['key'])) . '</span>'
            . ($isServicesMega || $isCategory ? icon('chevron-down', 'main-nav__chevron', 16) : '')
            . '</a>';

        if ($isServicesMega) {
            $html .= '<div class="mega" role="group" aria-label="' . e(t('nav.all_services')) . '">'
                . '<div class="mega__inner">'
                . nav_category_column('residential')
                . nav_category_column('commercial')
                . nav_category_column('specialised')
                . '<div class="mega__promo">'
                . '<p class="mega__promo-title">' . e(t('cta.band_title')) . '</p>'
                . '<p class="mega__promo-text">' . e(t('cta.band_text')) . '</p>'
                . wa_button(whatsapp_quote_message(), t('cta.whatsapp_us'), 'whatsapp', ['class' => 'btn--sm'])
                . call_button(t('cta.call_now'), 'light', ['class' => 'btn--sm'])
                . '</div></div></div>';
        } elseif ($isCategory) {
            $category = nav_category_for($item['match'][0]);
            $html .= '<div class="dropdown" role="group"><ul class="dropdown__list">';
            foreach (services_by_category($category) as $slug => $row) {
                $html .= '<li><a href="' . e_url(service_url($slug)) . '">' . e(lx($row, 'name', $slug)) . '</a></li>';
            }
            $html .= '</ul></div>';
        }

        $html .= '</li>';
    }

    return $html . '</ul>';
}

/** Mobile drawer navigation (accordion style, keyboard accessible). */
function nav_mobile(array $site_nav): string
{
    $html = '<ul class="drawer__list">';
    foreach ($site_nav as $item) {
        $isExpandable = in_array($item['match'][0] ?? '', ['services.php', 'residential-cleaning.php', 'commercial-cleaning.php', 'specialized-cleaning.php'], true);
        $panelId      = 'drawer-sub-' . preg_replace('/[^a-z0-9]+/i', '-', (string) ($item['url'] ?? ''));

        $html .= '<li class="drawer__item"><div class="drawer__row">'
            . '<a class="drawer__link' . (nav_is_active($item) ? ' is-active' : '') . '" href="' . e_url($item['url']) . '">'
            . e(t($item['key'])) . '</a>';
        if ($isExpandable) {
            $html .= '<button type="button" class="drawer__toggle" aria-expanded="false" aria-controls="' . e($panelId) . '">'
                . '<span class="visually-hidden">' . e(t($item['key'])) . '</span>'
                . icon('chevron-down', 'drawer__chevron', 20) . '</button>';
        }
        $html .= '</div>';

        if ($isExpandable) {
            $categories = $item['match'][0] === 'services.php'
                ? ['residential', 'commercial', 'specialised']
                : [nav_category_for($item['match'][0])];

            $html .= '<ul class="drawer__sublist" id="' . e($panelId) . '" hidden>';
            foreach ($categories as $category) {
                foreach (services_by_category($category) as $slug => $row) {
                    $html .= '<li><a href="' . e_url(service_url($slug)) . '">' . e(lx($row, 'name', $slug)) . '</a></li>';
                }
            }
            $html .= '</ul>';
        }
        $html .= '</li>';
    }

    return $html . '</ul>';
}

/** Language switcher (English | العربية). */
function language_switcher(string $class = ''): string
{
    $html = '<div class="lang-switch ' . e($class) . '" role="group" aria-label="' . e(t('nav.lang_label')) . '">';
    foreach (SUPPORTED_LANGS as $code) {
        $isActive = $code === lang();
        $html .= '<a class="lang-switch__link' . ($isActive ? ' is-active' : '') . '"'
            . ' href="' . e_url(lang_switch_url($code)) . '" hreflang="' . e($code) . '"'
            . ($isActive ? ' aria-current="true"' : '') . '>'
            . ($code === 'ar' ? 'العربية' : 'English') . '</a>';
    }

    return $html . '</div>';
}

/** Brand logo: original SVG mark + COMPANY_NAME from config. */
function brand_logo(string $class = ''): string
{
    $mark = '<svg class="brand__mark" width="42" height="42" viewBox="0 0 48 48" aria-hidden="true" focusable="false">'
        . '<circle cx="24" cy="24" r="22" fill="url(#brandGradient)"/>'
        . '<path d="M24 10c4.7 5 8 9.5 8 14.2A8 8 0 0 1 16 24.2C16 19.5 19.3 15 24 10z" fill="#ffffff" opacity=".95"/>'
        . '<path d="M34 30.5l1.1 2.7 2.7 1.1-2.7 1.1-1.1 2.7-1.1-2.7-2.7-1.1 2.7-1.1 1.1-2.7z" fill="#ffffff"/>'
        . '<defs><linearGradient id="brandGradient" x1="0" y1="0" x2="48" y2="48">'
        . '<stop offset="0%" stop-color="#0e7c86"/><stop offset="100%" stop-color="#0b5f74"/></linearGradient></defs></svg>';

    return '<a class="brand ' . e($class) . '" href="' . e_url(url('/')) . '"'
        . ' aria-label="' . e(COMPANY_NAME) . ' – ' . e(t('nav.home')) . '">'
        . $mark
        . '<span class="brand__text"><span class="brand__name">' . e(COMPANY_NAME) . '</span>'
        . '<span class="brand__tagline">' . e(t('header.tagline')) . '</span></span></a>';
}