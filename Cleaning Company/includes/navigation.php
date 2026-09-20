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
    if ($current === '') {
        return false;
    }

    foreach ((array) ($item['match'] ?? []) as $needle) {
        if ($current === '/' . ltrim($needle, '/')) {
            return true;
        }
    }

    // Grouped entries ("Company ▾") stay highlighted on their child pages.
    foreach ((array) ($item['children'] ?? []) as $child) {
        $childPath = '/' . ltrim((string) strtok((string) ($child['url'] ?? ''), '#'), '/');
        if ($childPath !== '/' && $current === $childPath) {
            return true;
        }
    }

    // Area pages keep "Service areas" highlighted.
    if (!empty($item['areas']) && str_starts_with($current, '/areas/')) {
        return true;
    }

    // A service page highlights "Services" and the category it belongs to.
    if (str_starts_with($current, '/services/')) {
        if (!empty($item['mega'])) {
            return true;
        }
        if (!empty($item['category'])) {
            $slug    = str_replace('.php', '', substr($current, strlen('/services/')));
            $service = service($slug);
            if ($service && ($service['category'] ?? '') === $item['category']) {
                return true;
            }
        }
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

/** Category of a nav entry: explicit "category" key first, then the legacy URL map. */
function nav_entry_category(array $item): string
{
    if (!empty($item['category'])) {
        return (string) $item['category'];
    }

    return nav_category_for((string) ($item['match'][0] ?? ''));
}

/** True when the entry opens a panel (sub menu) on desktop. */
function nav_has_panel(array $item): bool
{
    return !empty($item['mega']) || !empty($item['children']) || !empty($item['areas']) || !empty($item['category']);
}

/** Featured area slugs used by the "Service areas" dropdown. */
function nav_area_slugs(int $limit = 8): array
{
    $slugs = array_keys(areas());
    if (count($slugs) > $limit) {
        $slugs = array_slice($slugs, 0, $limit);
    }

    return $slugs;
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
        if (!empty($item['mobile_only'])) {
            continue;
        }

        $isServicesMega = !empty($item['mega']);
        $hasPanel       = nav_has_panel($item);

        $classes = 'main-nav__item';
        if ($isServicesMega) {
            $classes .= ' main-nav__item--mega';
        }
        if ($hasPanel) {
            $classes .= ' main-nav__item--has-children';
        }
        if (nav_is_active($item)) {
            $classes .= ' is-active';
        }

        $html .= '<li class="' . e($classes) . '">'
            . '<a class="main-nav__link" href="' . e_url($item['url']) . '"'
            . ($hasPanel ? ' aria-haspopup="true"' : '')
            . (nav_is_active($item) ? ' aria-current="page"' : '') . '>'
            . '<span>' . e(t($item['key'])) . '</span>'
            . ($hasPanel ? icon('chevron-down', 'main-nav__chevron', 16) : '')
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
        } elseif (!empty($item['children'])) {
            $html .= nav_dropdown_children((array) $item['children'], t($item['key']));
        } elseif (!empty($item['areas'])) {
            $html .= nav_dropdown_areas();
        } elseif (nav_has_panel($item)) {
            $category = nav_entry_category($item);
            $html .= '<div class="dropdown" role="group" aria-label="' . e(t($item['key'])) . '">'
                . '<ul class="dropdown__list">';
            foreach (services_by_category($category) as $slug => $row) {
                $html .= '<li><a href="' . e_url(service_url($slug)) . '">' . e(lx($row, 'name', $slug)) . '</a></li>';
            }
            $html .= '<li><a class="dropdown__all" href="' . e_url($item['url']) . '">'
                . e(t('cta.view_all_services')) . '</a></li>';
            $html .= '</ul></div>';
        }

        $html .= '</li>';
    }

    return $html . '</ul>';
}

/** Simple dropdown built from an explicit list of links. */
function nav_dropdown_children(array $children, string $label): string
{
    $html = '<div class="dropdown" role="group" aria-label="' . e($label) . '"><ul class="dropdown__list">';
    foreach ($children as $child) {
        $html .= '<li><a href="' . e_url(url((string) ($child['url'] ?? '/'))) . '">'
            . e(t((string) ($child['key'] ?? ''))) . '</a></li>';
    }

    return $html . '</ul></div>';
}

/** Dropdown listing the featured service areas plus a link to all of them. */
function nav_dropdown_areas(): string
{
    $html = '<div class="dropdown dropdown--areas" role="group" aria-label="' . e(t('nav.areas')) . '">';
    $html .= '<ul class="dropdown__list">';
    foreach (nav_area_slugs() as $slug) {
        $html .= '<li><a href="' . e_url(area_url($slug)) . '">' . e(area_name($slug)) . '</a></li>';
    }
    $html .= '<li><a class="dropdown__all" href="' . e_url(url('/service-areas.php')) . '">'
        . e(t('cta.view_all_areas')) . '</a></li>';

    return $html . '</ul></div>';
}

/** Mobile drawer navigation (accordion style, keyboard accessible). */
function nav_mobile(array $site_nav): string
{
    $html = '<ul class="drawer__list">';
    foreach ($site_nav as $item) {
        $panelId = 'drawer-sub-' . preg_replace('/[^a-z0-9]+/i', '-', (string) ($item['url'] ?? ''));
        $groups  = nav_mobile_groups($item);

        $html .= '<li class="drawer__item"><div class="drawer__row">'
            . '<a class="drawer__link' . (nav_is_active($item) ? ' is-active' : '') . '" href="' . e_url($item['url']) . '">'
            . e(t($item['key'])) . '</a>';
        if ($groups) {
            $html .= '<button type="button" class="drawer__toggle" aria-expanded="false" aria-controls="' . e($panelId) . '">'
                . '<span class="visually-hidden">' . e(t($item['key'])) . '</span>'
                . icon('chevron-down', 'drawer__chevron', 20) . '</button>';
        }
        $html .= '</div>';

        if ($groups) {
            $html .= '<div class="drawer__sublist" id="' . e($panelId) . '" hidden>';
            foreach ($groups as $group) {
                if (!empty($group['title'])) {
                    $html .= '<p class="drawer__sublist-title">' . e($group['title']) . '</p>';
                }
                $html .= '<ul class="drawer__sublist-list">';
                foreach ($group['links'] as $link) {
                    $html .= '<li><a href="' . e_url($link['url']) . '">' . e($link['label']) . '</a></li>';
                }
                $html .= '</ul>';
            }
            $html .= '</div>';
        }
        $html .= '</li>';
    }

    return $html . '</ul>';
}

/**
 * Sub links of a drawer entry, grouped with an optional heading.
 * Returns [] when the entry has no children.
 */
function nav_mobile_groups(array $item): array
{
    $groups = [];

    if (!empty($item['mega'])) {
        foreach (service_categories() as $categoryKey => $categoryMeta) {
            $links = [];
            foreach (services_by_category((string) $categoryKey) as $slug => $row) {
                $links[] = ['label' => lx($row, 'name', $slug), 'url' => service_url($slug)];
            }
            if ($links) {
                $groups[] = [
                    'title' => lx($categoryMeta, 'name', ucfirst((string) $categoryKey)),
                    'links' => $links,
                ];
            }
        }

        return $groups;
    }

    if (!empty($item['children'])) {
        $links = [];
        foreach ((array) $item['children'] as $child) {
            $links[] = ['label' => t((string) ($child['key'] ?? '')), 'url' => url((string) ($child['url'] ?? '/'))];
        }

        return $links ? [['title' => '', 'links' => $links]] : [];
    }

    if (!empty($item['areas'])) {
        $links = [];
        foreach (array_keys(areas()) as $slug) {
            $links[] = ['label' => area_name($slug), 'url' => area_url($slug)];
        }

        return $links ? [['title' => '', 'links' => $links]] : [];
    }

    if (nav_has_panel($item)) {
        $links = [];
        foreach (services_by_category(nav_entry_category($item)) as $slug => $row) {
            $links[] = ['label' => lx($row, 'name', $slug), 'url' => service_url($slug)];
        }

        return $links ? [['title' => '', 'links' => $links]] : [];
    }

    return $groups;
}

/** Language switcher (English | العربية) – modern button toggle. */
function language_switcher(string $class = ''): string
{
    $current = lang();
    $target  = $current === 'ar' ? 'en' : 'ar';
    $targetLabel = $target === 'ar' ? 'العربية' : 'English';

    $html = '<div class="lang-switch ' . e($class) . '" role="group" aria-label="' . e(t('nav.lang_label')) . '">';
    $html .= '<a class="lang-switch__btn" href="' . e_url(lang_switch_url($target)) . '" hreflang="' . e($target) . '">'
        . icon('globe', 'lang-switch__icon', 15)
        . '<span class="lang-switch__label">' . e($targetLabel) . '</span>'
        . '</a>';
    $html .= '</div>';

    return $html;
}

/** Brand logo: original SVG mark + COMPANY_NAME from config. */
function brand_logo(string $class = ''): string
{
    $mark = '<svg class="brand__mark" width="44" height="44" viewBox="0 0 48 48" aria-hidden="true" focusable="false">'
        . '<defs><linearGradient id="brandGradient" x1="0" y1="0" x2="48" y2="48">'
        . '<stop offset="0%" stop-color="#0043ec"/><stop offset="100%" stop-color="#07152f"/></linearGradient></defs>'
        . '<circle cx="24" cy="24" r="22" fill="url(#brandGradient)"/>'
        . '<path d="M24 9c4.8 5.2 8.2 9.8 8.2 14.5A8.2 8.2 0 0 1 15.8 23.5C15.8 18.8 19.2 14.1 24 9z" fill="#ffffff" opacity=".95"/>'
        . '<path d="M34 30.5l1.1 2.7 2.7 1.1-2.7 1.1-1.1 2.7-1.1-2.7-2.7-1.1 2.7-1.1 1.1-2.7z" fill="#f1d115"/>'
        . '</svg>';

    return '<a class="brand ' . e($class) . '" href="' . e_url(url('/')) . '"'
        . ' aria-label="' . e(COMPANY_NAME) . ' – ' . e(t('nav.home')) . '">'
        . $mark
        . '<span class="brand__text"><span class="brand__name">' . e(COMPANY_NAME) . '</span>'
        . '<span class="brand__tagline">' . e(t('header.tagline')) . '</span></span></a>';
}