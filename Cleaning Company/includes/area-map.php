<?php
/**
 * =====================================================================
 *  SERVICE AREA MAP  —  interactive Kuwait coverage map (no API key)
 * =====================================================================
 *  Renders an inline SVG map of Kuwait with one pin per district taken
 *  from /data/areas.php (the 'lat' / 'lng' keys). Every pin is a real
 *  link to its area page and the built-in search filters the pins and
 *  the district list at the same time.
 *
 *  Why an inline SVG instead of an embedded map service?
 *    · no API key, no third-party requests, no cookie banner,
 *    · works with the strict Content-Security-Policy of the site
 *      (script-src 'self') and without JavaScript at all,
 *    · the pins are crawlable links, so the map doubles as internal
 *      linking between the home page and the area pages.
 *
 *  The projection below is an equirectangular projection over the
 *  bounding box of Kuwait, corrected for the latitude of the country
 *  (1° of longitude is shorter than 1° of latitude). The outline and
 *  the pins use the very same function, so a pin always lands exactly
 *  on the shape.
 * =====================================================================
 */

/** Approximate outline of Kuwait (lat, lng) – decorative only. */
function area_map_outline(): array
{
    return [
        [29.99, 47.98], [29.92, 48.22], [29.77, 48.42], [29.60, 48.30], [29.60, 48.14],
        [29.56, 47.95], [29.52, 47.78], [29.44, 47.86], [29.40, 48.00], [29.37, 48.10],
        [29.36, 48.17], [29.20, 48.13], [28.99, 48.20], [28.55, 48.42], [28.53, 47.71],
        [29.00, 47.46], [29.10, 46.57], [30.06, 47.30],
    ];
}

/**
 * Project a latitude / longitude pair onto the SVG canvas.
 * Returns [$x, $y] in the viewBox "0 0 1000 960" used by the map.
 */
function area_map_point(float $lat, float $lng): array
{
    $x = 60 + ($lng - 46.50) * 420.0;    // ~420 px per degree of longitude
    $y = 60 + (30.12 - $lat) * 480.5;    // ~480 px per degree of latitude

    return [round($x, 1), round($y, 1)];
}

/** All districts that have coordinates, in the configured order. */
function area_map_rows(): array
{
    $rows = [];
    foreach (areas() as $slug => $row) {
        if (!isset($row['lat'], $row['lng'])) {
            continue;
        }
        $points = area_map_point((float) $row['lat'], (float) $row['lng']);

        $rows[$slug] = [
            'slug'        => $slug,
            'name'        => lx($row, 'name', $slug),
            'governorate' => lx($row, 'governorate', COMPANY_CITY),
            'url'         => area_url($slug),
            'x'           => $points[0],
            'y'           => $points[1],
            'coverage'    => $slug === 'other-areas',
            /* Search haystack: both languages, slug words and governorate. */
            'search'      => trim(
                (string) ($row['name'] ?? '') . ' '
                . (string) ($row['name_ar'] ?? '') . ' '
                . (string) ($row['governorate'] ?? '') . ' '
                . (string) ($row['governorate_ar'] ?? '') . ' '
                . str_replace('-', ' ', (string) $slug) . ' '
                . lx($row, 'name', $slug) . ' ' . lx($row, 'governorate', '')
            ),
        ];
    }

/**
 * Interactive coverage map + searchable district list.
 *
 * Options
 *   'title'  Accessible name of the svg (string)
 *   'list'   Print the searchable district list next to the map (bool)
 *   'class'  Extra class on the wrapper
 */
function area_map(array $options = []): string
{
    $rows = area_map_rows();
    if (!$rows) {
        return '';
    }

    $total    = count($rows);
    $listOn   = $options['list'] ?? true;
    $class    = trim('area-map reveal ' . (string) ($options['class'] ?? ''));
    $searchId = 'area-map-search';

    /* ---- land outline ------------------------------------------------ */
    $outline = area_map_outline();
    $path    = '';
    foreach ($outline as $index => $pair) {
        [$x, $y] = area_map_point((float) $pair[0], (float) $pair[1]);
        $path .= ($index === 0 ? 'M' : 'L') . $x . ' ' . $y . ' ';
    }
    $path .= 'Z';

    /* ---- decorative grid -------------------------------------------- */
    $grid = '';
    for ($gx = 160; $gx < 1000; $gx += 120) {
        $grid .= '<line x1="' . $gx . '" y1="0" x2="' . $gx . '" y2="960"/>';
    }
    for ($gy = 160; $gy < 960; $gy += 120) {
        $grid .= '<line x1="0" y1="' . $gy . '" x2="1000" y2="' . $gy . '"/>';
    }

    /* ---- pins -------------------------------------------------------- */
    $pins = '';
    foreach ($rows as $row) {
        $labelLeft = $row['x'] > 690;
        $labelX    = $labelLeft ? -14 : 14;
        $anchor    = $labelLeft ? 'end' : 'start';
        $classes   = 'area-map__pin' . ($row['coverage'] ? ' area-map__pin--coverage' : '');

        $pins .= '<a class="' . $classes . '" href="' . e_url($row['url']) . '"'
            . ' xlink:href="' . e_url($row['url']) . '"'
            . ' data-area-pin data-search="' . e($row['search']) . '"'
            . ' aria-label="' . e($row['name'] . ' — ' . $row['governorate']) . '">'
            . '<title>' . e($row['name'] . ' — ' . $row['governorate']) . '</title>'
            . '<g transform="translate(' . $row['x'] . ' ' . $row['y'] . ')">'
            . '<circle class="area-map__pin-halo" r="17"/>'
            . '<circle class="area-map__pin-dot" r="7"/>'
            . '<text class="area-map__pin-label" x="' . $labelX . '" y="5" text-anchor="' . $anchor . '">'
            . e($row['name']) . '</text>'
            . '</g></a>';
    }

    /* ---- searchable list -------------------------------------------- */
    $list = '';
    if ($listOn) {
        $list = '<ul class="area-map__list" data-area-list>';
        foreach ($rows as $row) {
            $list .= '<li class="area-map__list-item" data-area-item data-search="' . e($row['search']) . '">'
                . '<a class="area-map__list-link" href="' . e_url($row['url']) . '">'
                . '<span class="area-map__list-icon" aria-hidden="true">' . icon('map-pin', 'icon', 18) . '</span>'
                . '<span class="area-map__list-body">'
                . '<span class="area-map__list-name">' . e($row['name']) . '</span>'
                . '<span class="area-map__list-meta">' . e($row['governorate']) . '</span>'
                . '</span>'
                . '<span class="area-map__list-arrow" aria-hidden="true">' . icon('arrow-right', 'icon', 16) . '</span>'
                . '</a></li>';
        }
        $list .= '</ul>';
    }

    /* ---- toolbar ----------------------------------------------------- */
    $html = '<div class="' . e($class) . '" data-area-map'
        . ' data-count-label="' . e(t('areas.search_count')) . '">';

    $html .= '<div class="area-map__toolbar">'
        . '<div class="area-map__search">'
        . '<label class="visually-hidden" for="' . e($searchId) . '">' . e(t('areas.search_label')) . '</label>'
        . '<span class="area-map__search-icon" aria-hidden="true">' . icon('search', 'icon', 20) . '</span>'
        . '<input class="area-map__input" id="' . e($searchId) . '" type="search" data-area-search'
        . ' placeholder="' . e(t('areas.search_placeholder')) . '" autocomplete="off" spellcheck="false">'
        . '<button class="area-map__clear" type="button" data-area-clear hidden'
        . ' aria-label="' . e(t('areas.search_clear')) . '">' . icon('close', 'icon', 18) . '</button>'
        . '</div>'
        . '<p class="area-map__status" data-area-status aria-live="polite">'
        . e(t('areas.search_count', ['count' => (string) $total])) . '</p>'
        . '</div>';

    /* ---- map + list -------------------------------------------------- */
    $html .= '<div class="area-map__body' . ($listOn ? '' : ' area-map__body--single') . '">';
    $html .= '<div class="area-map__canvas">'
        . '<svg class="area-map__svg" viewBox="0 0 1000 960" role="group"'
        . ' aria-label="' . e((string) ($options['title'] ?? t('areas.map_title'))) . '"'
        . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">'
        . '<g class="area-map__grid" aria-hidden="true">' . $grid . '</g>'
        . '<path class="area-map__land" d="' . $path . '"/>'
        . '<path class="area-map__coast" d="' . $path . '"/>'
        . '<g class="area-map__pins">' . $pins . '</g>'
        . '</svg>'
        . '<p class="area-map__hint">' . icon('info', 'area-map__hint-icon', 16)
        . '<span>' . e(t('areas.map_hint')) . '</span></p>'
        . '<p class="area-map__empty" data-area-empty hidden>' . e(t('areas.search_empty')) . '</p>'
        . '</div>';
    $html .= $list;
    $html .= '</div>';

    return $html . '</div>';
}


    return $rows;
}
