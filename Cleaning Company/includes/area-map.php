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
 *  The base map is a real country outline (mainland plus Bubiyan,
 *  Warbah and Failaka) taken from the Natural Earth 1:10m data set and
 *  projected once, offline, into the SVG path below. The very same
 *  projection (area_map_point) is used for the pins, so a pin always
 *  lands exactly on the shape.
 *
 *  Projection: equirectangular over the bounding box of Kuwait with a
 *  latitude correction of 1 / cos(29.32°) ≈ 1.1467 (one degree of
 *  longitude is shorter than one degree of latitude at this latitude).
 *  Source data: Natural Earth (public domain).
 * =====================================================================
 */

/** SVG path of the Kuwait boundary in the "0 0 1000 960" viewBox. */
function area_map_path(): string
{
    return 'M727.7 98.3L731.2 107.8L736.5 116.3L741.8 127.7L743.6 139.1L743.6 160L745.4 173.3L750.7 192.3L764.8 218.9L778.9 239.8L793 239.8L800.1 264.5L812.4 289.1L833.6 319.5L842.4 341.4L840.7 352.8L830.1 354.7L808.9 346.1L798.3 339.5L796.5 334.7L786 332.8L773.6 330L764.8 329L736.5 333.8L722.4 346.1L710.1 358.5L680 375.6L658.9 394.5L648.3 411.6L637.7 425.9L614.7 436.3L613 444.9L609.4 453.4L620 454.4L637.7 450.6L651.8 448.7L662.4 443.9L674.8 440.1L680 443.9L665.9 453.4L665.9 460.1L664.2 467.7L676.5 476.2L683.6 476.2L694.2 472.4L704.8 469.6L706.5 455.3L715.3 452.5L724.2 455.3L733 448.7L738.3 440.1L747.1 436.3L750.7 439.2L757.7 449.6L759.5 451.5L766.5 458.2L771.8 460.1L784.2 464.8L803.6 461L800.1 485.7L798.3 496.1L800.1 512.3L805.4 537.9L810.7 549.3L816 559.8L819.5 571.2L831.8 648.1L840.7 667.1L863.6 704.1L872.4 710.7L890.1 717.4L891.9 725.9L890.1 736.4L890.1 747.8L893.6 759.2L907.8 778.2L909.5 784.8L914.8 792.4L927.2 797.1L946.6 801.9L941.3 810.4L939.5 820.9L939.5 830.4L943.1 840.8L936 835.1L932.5 832.3L932.5 837L932.5 839.9L936 841.8L939.5 844.6L936 849.4L934.2 850.3L932.5 850.3L930.7 848.4L927.2 848.4L925.4 859.8L930.7 862.7L937.8 858.9L943.1 852.2L944.8 857.9L946.6 885.5L948.3 892.1L951.9 899.7L960.7 910.1L966 915.8L879.5 916.8L791.2 917.7L704.8 918.7L616.5 919.6L591.8 919.6L586.5 905.4L577.7 894.9L567.1 887.4L556.5 877.9L547.7 864.6L542.4 848.4L537.1 831.3L535.3 800.9L533.5 786.7L505.3 711.7L482.3 670.9L477.1 660.4L475.3 660.4L448.8 656.6L399.4 650.9L350 644.3L302.3 637.6L252.9 631L198.2 624.3L143.4 617.7L88.7 611L34 603.4L48.1 588.2L122.3 504.7L152.3 453.4L184 418.3L191.1 407.8L205.2 369.9L242.3 309.1L252.9 287.2L252.9 281.5L254.6 265.4L258.2 256.9L275.8 223.6L318.2 117.3L334.1 93.5L360.6 76.4L438.2 43.2L466.5 40.4L593.6 40.4L621.8 45.1L727.7 98.3ZM920.1 397.4L927.2 400.2L930.7 404L936 408.8L941.3 413.5L944.8 418.3L950.1 434.4L948.3 440.1L941.3 437.3L936 436.3L932.5 433.5L918.3 421.1L909.5 417.3L895.4 415.4L884.8 416.4L886.6 401.2L891.9 392.6L900.7 391.7L920.1 397.4ZM927.2 258.8L916.6 275.8L902.5 294.8L884.8 311L865.4 320.5L861.9 319.5L844.2 317.6L833.6 303.4L816 262.6L794.8 225.5L793 222.7L789.5 218.9L780.7 213.2L775.4 207.5L786 200.8L791.2 198L801.8 190.4L807.1 189.4L808.9 185.6L812.4 166.7L803.6 162.9L800.1 162.9L794.8 162.9L800.1 154.3L807.1 155.3L819.5 162.9L824.8 163.8L831.8 162.9L835.4 159.1L831.8 150.5L840.7 146.7L849.5 142L851.3 137.2L842.4 131.5L837.1 131.5L830.1 134.4L826.6 131.5L823 127.7L823 122L821.3 116.3L823 112.5L814.2 112.5L812.4 111.6L810.7 109.7L812.4 105.9L819.5 101.1L826.6 98.3L833.6 97.3L840.7 100.2L846 104.9L921.9 213.2L930.7 233.1L927.2 258.8ZM793 92.6L789.5 96.4L784.2 102.1L782.4 104.9L768.3 111.6L764.8 112.5L761.2 109.7L759.5 105.9L757.7 103L764.8 98.3L775.4 85L780.7 81.2L800.1 79.3L807.1 79.3L805.4 85L793 92.6Z';
}

/**
 * Project a latitude / longitude pair onto the SVG canvas.
 * Returns [$x, $y] in the viewBox "0 0 1000 960" used by the map.
 */
function area_map_point(float $lat, float $lng): array
{
    $x = $lng * 490.3150 - 22781.4659;    // ~490 px per degree of longitude
    $y = 16965.2655 - $lat * 562.3310;    // ~562 px per degree of latitude

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

    return $rows;
}

/**
 * Interactive coverage map + searchable district list.
 *
 * Options
 *   'title'  Accessible name of the base map (string)
 *   'list'   Print the searchable district list next to the map (bool)
 *   'class'  Extra class on the wrapper
 *   'base'   'google' → embedded Google base map (same embed as the
 *                       contact page, centred on the business address)
 *            'svg'    → inline SVG outline of Kuwait with one pin per area
 *            Default: 'google' whenever COMPANY_MAP_EMBED_URL is set,
 *            otherwise the SVG (the map still works without an API key).
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

    /* ---- base map: embedded Google map or the inline SVG ------------- */
    $base = (string) ($options['base'] ?? '');
    if ($base !== 'google' && $base !== 'svg') {
        $base = map_embed_url() !== '' ? 'google' : 'svg';
    }
    if ($base === 'google' && map_embed_url() === '') {
        $base = 'svg';   /* no embed configured: keep the crawlable SVG map */
    }

    /* ---- land outline (Natural Earth base map) ----------------------- */
    $path = area_map_path();

    /* ---- decorative grid -------------------------------------------- */
    $grid = '';
    for ($gx = 100; $gx < 1000; $gx += 100) {
        $grid .= '<line x1="' . $gx . '" y1="0" x2="' . $gx . '" y2="960"/>';
    }
    for ($gy = 100; $gy < 960; $gy += 100) {
        $grid .= '<line x1="0" y1="' . $gy . '" x2="1000" y2="' . $gy . '"/>';
    }

    /* ---- pins -------------------------------------------------------- */
    $pins = '';
    foreach ($rows as $row) {
        $labelLeft = $row['x'] > 690;
        $labelX    = $labelLeft ? -15 : 15;
        $anchor    = $labelLeft ? 'end' : 'start';
        $classes   = 'area-map__pin' . ($row['coverage'] ? ' area-map__pin--coverage' : '');

        $pins .= '<a class="' . $classes . '" href="' . e_url($row['url']) . '"'
            . ' xlink:href="' . e_url($row['url']) . '"'
            . ' data-area-pin data-search="' . e($row['search']) . '"'
            . ' aria-label="' . e($row['name'] . ' — ' . $row['governorate']) . '">'
            . '<title>' . e($row['name'] . ' — ' . $row['governorate']) . '</title>'
            . '<g transform="translate(' . $row['x'] . ' ' . $row['y'] . ')">'
            . '<circle class="area-map__pin-halo" r="15"/>'
            . '<circle class="area-map__pin-dot" r="6.5"/>'
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
    $html .= '<div class="area-map__canvas' . ($base === 'google' ? ' area-map__canvas--embed' : '') . '">';

    if ($base === 'google') {
        /* The very same key-less embed that the contact page uses: a real,
           zoomable Google base map centred on the business address. The
           districts stay reachable through the searchable list beside it. */
        $html .= '<div class="area-map__frame">'
            . '<iframe loading="lazy"'
            . ' src="' . e_url(map_embed_url()) . '"'
            . ' width="100%" height="100%" style="border:0;"'
            . ' allowfullscreen referrerpolicy="no-referrer-when-downgrade"'
            . ' title="' . e((string) ($options['title'] ?? t('areas.map_title'))) . '">'
            . '</iframe>'
            . '<a class="area-map__frame-btn" href="' . e_url(COMPANY_GOOGLE_MAPS_URL) . '"'
            . ' target="_blank" rel="noopener noreferrer">'
            . icon('arrow-up-right', 'area-map__frame-btn-icon', 16)
            . '<span>' . e(t('contact.directions')) . '</span></a>'
            . '</div>'
            . '<p class="area-map__hint">' . icon('info', 'area-map__hint-icon', 16)
            . '<span>' . e(t('areas.map_hint_google')) . '</span></p>';
    } else {
        $html .= '<svg class="area-map__svg" viewBox="0 0 1000 960" role="group"'
            . ' aria-label="' . e((string) ($options['title'] ?? t('areas.map_title'))) . '"'
            . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">'
            . '<g class="area-map__grid" aria-hidden="true">' . $grid . '</g>'
            . '<path class="area-map__land" d="' . $path . '"/>'
            . '<path class="area-map__coast" d="' . $path . '"/>'
            . '<text class="area-map__name" x="300" y="520" aria-hidden="true">' . e(t('areas.map_label')) . '</text>'
            . '<g class="area-map__pins">' . $pins . '</g>'
            . '</svg>'
            . '<p class="area-map__hint">' . icon('info', 'area-map__hint-icon', 16)
            . '<span>' . e(t('areas.map_hint')) . '</span></p>';
    }

    $html .= '<p class="area-map__empty" data-area-empty hidden>' . e(t('areas.search_empty')) . '</p>'
        . '</div>';
    $html .= $list;
    $html .= '</div>';

    return $html . '</div>';
}

