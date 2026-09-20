<?php
/**
 * =====================================================================
 *  UI HELPERS  —  original inline SVG icons + reusable render blocks
 * =====================================================================
 *  Plain PHP/HTML output: no framework, no third party icon font, no
 *  extra HTTP requests (icons are inlined from the array below).
 * =====================================================================
 */

/** Stroke based icon set (24x24, currentColor) drawn for this project. */
function icon_paths(): array
{
    return [
        'sparkle'      => '<path d="M12 3l1.6 4.4L18 9l-4.4 1.6L12 15l-1.6-4.4L6 9l4.4-1.6L12 3z"/><path d="M18.5 15.5l.7 1.8 1.8.7-1.8.7-.7 1.8-.7-1.8-1.8-.7 1.8-.7.7-1.8z"/>',
        'droplet'      => '<path d="M12 3.5c3.2 3.1 5.5 6 5.5 9a5.5 5.5 0 0 1-11 0c0-3 2.3-5.9 5.5-9z"/><path d="M9.5 13.8a2.6 2.6 0 0 0 2.2 2.4"/>',
        'bubble'       => '<circle cx="9" cy="10" r="5.5"/><circle cx="16.5" cy="15.5" r="3"/><path d="M7 8.5a2.7 2.7 0 0 1 2-1.4"/>',
        'spray'        => '<path d="M9 8h5.5a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2v-9a2 2 0 0 1 2-2z"/><path d="M9.8 8V5.5A1.5 1.5 0 0 1 11.3 4h1.4a1.5 1.5 0 0 1 1.5 1.5V8"/><path d="M17.5 6.5h2M17.5 9.5h2.5M17.5 12.5h2"/>',
        'brush'        => '<path d="M14.5 4.5l5 5-8 8-5-5 8-8z"/><path d="M6.5 12.5L3.8 19l6.7-2.6"/>',
        'broom'        => '<path d="M15.5 4.5l4 4-6.6 6.6-4-4 6.6-6.6z"/><path d="M8.9 11.1l-4.4 4.4a3 3 0 0 0-.8 1.5L3 21l4-.7a3 3 0 0 0 1.5-.8l4.4-4.4"/>',
        'window'       => '<rect x="4" y="3.5" width="16" height="17" rx="2"/><path d="M12 3.5v17M4 12h16"/>',
        'kitchen'      => '<path d="M5 4h14v16H5z"/><path d="M5 12h14M8.5 7.5h.01M8.5 15.5h.01M15 6.5v4M11 14v4"/>',
        'bath'         => '<path d="M4 12h16v3a4 4 0 0 1-4 4H8a4 4 0 0 1-4-4v-3z"/><path d="M7 12V6.5A2.5 2.5 0 0 1 9.5 4c1.1 0 2 .7 2.3 1.7M6 21l1-2M18 21l-1-2"/>',
        'sofa'         => '<path d="M5 11V8.5A3.5 3.5 0 0 1 8.5 5h7A3.5 3.5 0 0 1 19 8.5V11"/><path d="M5 11a2.5 2.5 0 0 0-2.5 2.5V17h19v-3.5A2.5 2.5 0 0 0 19 11"/><path d="M6.5 17v2M17.5 17v2M8.5 11h7"/>',
        'carpet'       => '<rect x="4" y="5" width="16" height="14" rx="2"/><path d="M7.5 8.5h9v7h-9z"/><path d="M4 9h1.5M4 15h1.5M18.5 9H20M18.5 15H20"/>',
        'mattress'     => '<rect x="3" y="8" width="18" height="8" rx="2.5"/><path d="M3 13h18M7 8V6.5M17 8V6.5"/>',
        'home'         => '<path d="M4 10.5L12 4l8 6.5V19a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 4 19v-8.5z"/><path d="M9.5 20.5v-6h5v6"/>',
        'building'     => '<path d="M6 20.5V4.5h9v16"/><path d="M15 9.5h3.5v11"/><path d="M9 8h3M9 11.5h3M9 15h3M3 20.5h18"/>',
        'office'       => '<rect x="3.5" y="4" width="17" height="16.5" rx="2"/><path d="M8 8h3M13 8h3M8 12h3M13 12h3M10 20.5v-4h4v4"/>',
        'shop'         => '<path d="M4 9.5V19a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 20 19V9.5"/><path d="M3 9.5L5 4.5h14l2 5"/><path d="M9.5 20.5v-6h5v6"/>',
        'restaurant'   => '<path d="M8 3.5v8a2.5 2.5 0 0 0 5 0v-8"/><path d="M10.5 11.5v9M17 3.5c1.6 1.6 1.6 4.4 0 6v11"/>',
        'cafe'         => '<path d="M4.5 6.5h12v6a5 5 0 0 1-5 5h-2a5 5 0 0 1-5-5v-6z"/><path d="M16.5 8h1.8a2.7 2.7 0 0 1 0 5.4h-1.8"/><path d="M4 20.5h13"/>',
        'clinic'       => '<rect x="4" y="4" width="16" height="16" rx="4"/><path d="M12 8.5v7M8.5 12h7"/>',
        'school'       => '<path d="M12 4l8.5 4-8.5 4L3.5 8 12 4z"/><path d="M6.5 10v5.5c0 1.7 2.5 3 5.5 3s5.5-1.3 5.5-3V10"/><path d="M20 9v5"/>',
        'hotel'        => '<path d="M3.5 20V6.5A1.5 1.5 0 0 1 5 5h9a1.5 1.5 0 0 1 1.5 1.5V20"/><path d="M15.5 10h3.5a1.5 1.5 0 0 1 1.5 1.5V20"/><path d="M7 8.5h5M7 12h5M7 15.5h5M2.5 20h19"/>',
        'warehouse'    => '<path d="M3 20V9l9-4.5L21 9v11"/><path d="M7 20v-6h10v6M3 20h18"/>',
        'showroom'     => '<path d="M3 20V8.5l9-4 9 4V20"/><path d="M8 20v-6.5h8V20"/><path d="M8 17h8"/>',
        'steam'        => '<path d="M6 20h12M4.5 16.5h15"/><path d="M9 13.5c-1.5-1.6 1.5-2.6 0-4.4"/><path d="M13 13.5c-1.5-1.6 1.5-2.6 0-4.4"/><path d="M9.5 7.5C8 5.9 11 4.9 9.5 3"/>',
        'glass'        => '<path d="M8 4.5L6.5 20h11L16 4.5H8z"/><path d="M7.2 9h9.6M6.7 14h10.6"/>',
        'facade'       => '<rect x="5" y="3.5" width="14" height="17" rx="2"/><path d="M8.5 7.5h7M8.5 11h7M8.5 14.5h7M12 3.5v17"/><path d="M2.5 20.5h19"/>',
        'floor'        => '<path d="M3 8.5h18M3 15.5h18"/><path d="M8 8.5v7M14 8.5v7M11 15.5v5M5.5 20.5h13M5.5 4h13v4.5h-13z"/>',
        'shield'       => '<path d="M12 3.5l7 2.5v6c0 4-3 7-7 8.5-4-1.5-7-4.5-7-8.5V6l7-2.5z"/><path d="M9 12l2.2 2.2L15.2 10"/>',
        'users'        => '<circle cx="9" cy="9" r="3.2"/><path d="M3.5 20c.6-3 2.8-4.8 5.5-4.8S14 17 14.6 20"/><path d="M15.5 6.6a3.2 3.2 0 0 1 0 6.3M17 15.6c2 .6 3.2 2.2 3.6 4.4"/>',
        'award'        => '<circle cx="12" cy="9.5" r="5"/><path d="M9 14l-1.5 6.5L12 18l4.5 2.5L15 14"/>',
        'star'         => '<path d="M12 4l2.4 4.9 5.4.8-3.9 3.8.9 5.4-4.8-2.6-4.8 2.6.9-5.4L4.2 9.7l5.4-.8L12 4z"/>',
        'clock'        => '<circle cx="12" cy="12" r="8.2"/><path d="M12 7.8V12l3 2"/>',
        'calendar'     => '<rect x="3.5" y="5.5" width="17" height="15" rx="2"/><path d="M3.5 10h17M8 3.5v4M16 3.5v4"/><path d="M8 14h3"/>',
        'map-pin'      => '<path d="M12 21s6.5-6 6.5-11a6.5 6.5 0 1 0-13 0C5.5 15 12 21 12 21z"/><circle cx="12" cy="10" r="2.6"/>',
        'mail'         => '<rect x="3.5" y="5.5" width="17" height="13" rx="2.5"/><path d="M4 7.5l8 5.5 8-5.5"/>',
        'phone'        => '<path d="M7.5 3.8l2.3 3.1-1.6 2.3a12 12 0 0 0 5.9 5.9l2.3-1.6 3.1 2.3v2.6a2 2 0 0 1-2.2 2A16.5 16.5 0 0 1 3.5 6a2 2 0 0 1 2-2.2h2z"/>',
        'check'        => '<path d="M5 12.5l4.5 4.5L19 7.5"/>',
        'check-circle' => '<circle cx="12" cy="12" r="8.5"/><path d="M8.5 12.3l2.4 2.4 4.6-5"/>',
        'arrow-right'  => '<path d="M5 12h13M13 6.5l5.5 5.5L13 17.5"/>',
        'arrow-up-right' => '<path d="M7 17L17 7M9 7h8v8"/>',
        'chevron-down' => '<path d="M6.5 9.5l5.5 5.5 5.5-5.5"/>',
        'chevron-left' => '<path d="M14.5 6.5L9 12l5.5 5.5"/>',
        'chevron-right'=> '<path d="M9.5 6.5L15 12l-5.5 5.5"/>',
        'close'        => '<path d="M6.5 6.5l11 11M17.5 6.5l-11 11"/>',
        'menu'         => '<path d="M4 7h16M4 12h16M4 17h16"/>',
        'globe'        => '<circle cx="12" cy="12" r="8.4"/><path d="M3.6 12h16.8M12 3.6c2.4 2.4 3.6 5.2 3.6 8.4S14.4 18 12 20.4C9.6 18 8.4 15.2 8.4 12S9.6 6 12 3.6z"/>',
        'info'         => '<circle cx="12" cy="12" r="8.5"/><path d="M12 11v5.5M12 7.8h.01"/>',
        'alert'        => '<path d="M12 4.5l8.5 15h-17l8.5-15z"/><path d="M12 10v4M12 17h.01"/>',
        'leaf'         => '<path d="M20 4c-9 0-14 4-14 10a5.5 5.5 0 0 0 5.6 5.5C18 19.5 20 13 20 4z"/><path d="M8 20c1.5-4.5 4-8 8-10.5"/>',
        'tools'        => '<path d="M14.5 4.5a4.5 4.5 0 0 0 5.4 6.5l-9 9a2.6 2.6 0 0 1-3.7-3.7l9-9a4.5 4.5 0 0 0-1.7-2.8z"/><path d="M6.5 4.5l3 3M4 7l3 3"/>',
        'truck'        => '<path d="M3.5 6.5h9v10h-9z"/><path d="M12.5 9.5H17l3 3v4h-7.5z"/><circle cx="7" cy="18" r="1.8"/><circle cx="16.5" cy="18" r="1.8"/>',
        'sun'          => '<circle cx="12" cy="12" r="4"/><path d="M12 3v2.2M12 18.8V21M3 12h2.2M18.8 12H21M5.6 5.6l1.6 1.6M16.8 16.8l1.6 1.6M18.4 5.6l-1.6 1.6M7.2 16.8l-1.6 1.6"/>',
        'quote'        => '<path d="M9.5 6.5C6.5 8 5 10.5 5 13.5c0 2.3 1.3 4 3.3 4 1.7 0 3-1.2 3-2.9 0-1.6-1.1-2.8-2.7-2.8h-.4c.2-1.4 1.1-2.6 2.6-3.5l-.7-1.8z"/><path d="M18 6.5c-3 1.5-4.5 4-4.5 7 0 2.3 1.3 4 3.3 4 1.7 0 3-1.2 3-2.9 0-1.6-1.1-2.8-2.7-2.8h-.4c.2-1.4 1.1-2.6 2.6-3.5L18 6.5z"/>',
        'whatsapp'     => '<path d="M4 20l1.3-4A8 8 0 1 1 8 19.1L4 20z"/><path d="M9 9.5c0 3 2.4 5.4 5.3 5.4.7 0 1-.5 1-1 0-.4-.2-.6-.7-.9-.6-.3-1 .4-1.4.1-1-.6-1.9-1.5-2.4-2.5-.2-.4.4-.8.1-1.3-.3-.5-.5-.8-1-.8-.5 0-.9.4-.9 1z"/>',
        'instagram'    => '<rect x="4" y="4" width="16" height="16" rx="4.5"/><circle cx="12" cy="12" r="3.6"/><path d="M16.8 7.4h.01"/>',
        'facebook'     => '<path d="M14.5 20.5v-6.4h2.2l.5-3h-2.7V9.2c0-.9.3-1.4 1.5-1.4h1.3V5.1c-.6-.1-1.4-.2-2.2-.2-2.3 0-3.8 1.4-3.8 3.9v2.3H9.2v3h2.1v6.4"/>',
        'tiktok'       => '<path d="M14.5 4v9.6a3.1 3.1 0 1 1-3.1-3.1"/><path d="M14.5 6.2c1 1.5 2.3 2.3 4 2.5V6.2c-1.7-.2-3-1-4-2.2z"/>',
    ];
}

/** Render an inline SVG icon. */
function icon(string $name, string $class = 'icon', int $size = 24): string
{
    $paths = icon_paths();
    $body  = $paths[$name] ?? $paths['sparkle'];

    return '<svg class="' . e($class) . '" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24"'
        . ' fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"'
        . ' aria-hidden="true" focusable="false">' . $body . '</svg>';
}

/* ---------------------------------------------------------------------
 | Links and buttons
 * -------------------------------------------------------------------*/

/** Attributes a caller may never override on a button. */
function button_reserved_attrs(): array
{
    return ['href', 'class', 'target', 'rel'];
}

/**
 * Render a link styled as a button.
 * btn(['label' => 'Call now', 'href' => tel_url(), 'variant' => 'accent', 'icon' => 'phone'])
 */
function btn(array $options): string
{
    $variant = $options['variant'] ?? 'primary';
    $iconPos = $options['icon_pos'] ?? 'left';
    $classes = trim('btn btn--' . $variant . ' ' . ($options['class'] ?? ''));
    $attrs   = '';

    foreach (($options['attrs'] ?? []) as $key => $value) {
        if (in_array(strtolower((string) $key), button_reserved_attrs(), true)) {
            continue;
        }
        $attrs .= ' ' . e((string) $key) . '="' . e((string) $value) . '"';
    }

    $target = $options['target'] ?? '';
    if ($target !== '') {
        $attrs .= ' target="' . e($target) . '"';
    }
    if ($target === '_blank' && empty($options['no_rel'])) {
        $attrs .= ' rel="' . e($options['rel'] ?? 'noopener noreferrer') . '"';
    }

    $iconName = $options['icon'] ?? '';
    $glyph    = $iconName !== '' ? icon($iconName, 'btn__icon', 20) : '';
    $label    = '<span class="btn__label">' . e($options['label'] ?? '') . '</span>';

    return '<a class="' . e($classes) . '" href="' . e_url($options['href'] ?? '#') . '"' . $attrs . '>'
        . ($iconPos === 'left' ? $glyph : '')
        . $label
        . ($iconPos === 'right' ? $glyph : '')
        . '</a>';
}

/** WhatsApp button – new tab, contextual pre-filled message. */
function wa_button(string $message, ?string $label = null, string $variant = 'whatsapp', array $extra = []): string
{
    return btn(array_merge([
        'label'   => $label ?? t('cta.whatsapp_us'),
        'href'    => whatsapp_url($message),
        'variant' => $variant,
        'icon'    => 'whatsapp',
        'target'  => '_blank',
    ], $extra));
}

/** Direct call button. */
function call_button(?string $label = null, string $variant = 'outline', array $extra = []): string
{
    return btn(array_merge([
        'label'   => $label ?? t('cta.call_now'),
        'href'    => tel_url(),
        'variant' => $variant,
        'icon'    => 'phone',
    ], $extra));
}

/** E-mail button. */
function email_button(?string $label = null, string $variant = 'ghost', array $extra = []): string
{
    return btn(array_merge([
        'label'   => $label ?? t('cta.email_us'),
        'href'    => mail_url(),
        'variant' => $variant,
        'icon'    => 'mail',
    ], $extra));
}

/* ---------------------------------------------------------------------
 | Media
 * -------------------------------------------------------------------*/

/**
 * Responsive, CLS-safe <img>.
 * img_tag(['src' => '/assets/images/project-image/villa-cleaning.avif', 'alt' => '...',
 *          'sizes' => '(max-width: 767px) 92vw, 420px', 'eager' => false])
 */
function img_tag(array $options): string
{
    $src = $options['src'] ?? '/assets/images/placeholder.webp';
    $alt = $options['alt'] ?? '';
    $size = image_size($src);

    $width  = (int) ($options['width'] ?? $size[0]);
    $height = (int) ($options['height'] ?? $size[1]);

    $attrs = '';
    foreach (($options['attrs'] ?? []) as $key => $value) {
        $attrs .= ' ' . e((string) $key) . '="' . e((string) $value) . '"';
    }

    $class = trim('img ' . ($options['class'] ?? ''));

    // Optional WebP responsive variants created by tools/generate-images.php
    $srcset = '';
    if (!empty($options['responsive'])) {
        $base = preg_replace('/\.webp$/', '', $src);
        $w400 = $base . '-400.webp';
        $w800 = $base . '-800.webp';
        if (is_file(__DIR__ . '/..' . $w400) && is_file(__DIR__ . '/..' . $w800)) {
            $srcset = ' srcset="' . e(media($w400)) . ' 400w, ' . e(media($w800)) . ' 800w"'
                . ' sizes="' . e($options['sizes'] ?? '(max-width: 767px) 92vw, 480px') . '"';
        }
    }

    $eager = !empty($options['eager']);

    return '<img class="' . e($class) . '" src="' . e_url(media($src)) . '"' . $srcset
        . ' alt="' . e($alt) . '" width="' . $width . '" height="' . $height . '"'
        . ' loading="' . ($eager ? 'eager' : 'lazy') . '" decoding="' . ($eager ? 'sync' : 'async') . '"'
        . ($eager ? ' fetchpriority="high"' : '') . $attrs . '>';
}

/* ---------------------------------------------------------------------
 | Layout blocks
 * -------------------------------------------------------------------*/

/** Section heading (eyebrow + h2 + lead paragraph). */
function section_head(array $o): string
{
    $align = $o['align'] ?? 'left';
    $level = (int) ($o['level'] ?? 2);
    $tag   = 'h' . max(2, min(6, $level));

    $html = '<div class="section-head section-head--' . e($align) . '">';
    if (!empty($o['eyebrow'])) {
        $html .= '<p class="eyebrow">' . icon($o['eyebrow_icon'] ?? 'sparkle', 'eyebrow__icon', 18) . e($o['eyebrow']) . '</p>';
    }
    if (!empty($o['title'])) {
        $html .= '<' . $tag . ' class="section-head__title">' . e($o['title']) . '</' . $tag . '>';
    }
    if (!empty($o['lead'])) {
        $html .= '<p class="section-head__lead">' . e($o['lead']) . '</p>';
    }

    return $html . '</div>';
}

/** Bullet list with check icons. */
function check_list(array $items, string $class = ''): string
{
    $html = '<ul class="check-list ' . e($class) . '">';
    foreach ($items as $item) {
        $html .= '<li>' . icon('check', 'check-list__icon', 18) . '<span>' . e($item) . '</span></li>';
    }

    return $html . '</ul>';
}

/** Numbered process steps (1..n). */
function numbered_steps(array $steps): string
{
    $html = '<ol class="steps">';
    $i    = 0;
    foreach ($steps as $step) {
        $i++;
        $title = is_array($step) ? ($step['title'] ?? '') : (string) $step;
        $text  = is_array($step) ? ($step['text'] ?? '') : '';
        $icon  = is_array($step) ? ($step['icon'] ?? 'check-circle') : 'check-circle';
        $html .= '<li class="steps__item reveal">'
            . '<span class="steps__num" aria-hidden="true">' . $i . '</span>'
            . '<div class="steps__body"><h3 class="steps__title">' . icon($icon, 'steps__icon', 20) . e($title) . '</h3>'
            . ($text !== '' ? '<p class="steps__text">' . e($text) . '</p>' : '')
            . '</div></li>';
    }

    return $html . '</ol>';
}

/** Icon feature cards. */
function feature_cards(array $cards, string $class = 'grid-3'): string
{
    $html = '<div class="card-grid ' . e($class) . '">';
    foreach ($cards as $card) {
        $html .= '<article class="info-card reveal">'
            . '<span class="info-card__icon">' . icon($card['icon'] ?? 'sparkle', 'icon', 26) . '</span>'
            . '<h3 class="info-card__title">' . e($card['title'] ?? '') . '</h3>'
            . '<p class="info-card__text">' . e($card['text'] ?? '') . '</p>'
            . (isset($card['url'])
                ? '<a class="link-arrow" href="' . e_url($card['url']) . '">' . e($card['link_label'] ?? t('cta.learn_more'))
                    . icon('arrow-right', 'link-arrow__icon', 18) . '</a>'
                : '')
            . '</article>';
    }

    return $html . '</div>';
}

/** Accessible accordion from an array of ['q' => '', 'a' => ''] items. */
function accordion(array $items, string $idPrefix, bool $openFirst = false): string
{
    $html = '<div class="accordion" data-accordion>';
    foreach ($items as $index => $item) {
        $question = is_array($item) ? ($item['q'] ?? '') : (string) $item;
        $answer   = (string) (is_array($item) ? ($item['a'] ?? '') : '');
        $id       = $idPrefix . '-' . ($index + 1);
        $open     = ($openFirst && $index === 0);

        $html .= '<div class="accordion__item' . ($open ? ' is-open' : '') . '">'
            . '<h3 class="accordion__heading">'
            . '<button type="button" class="accordion__trigger" id="' . e($id) . '-trigger"'
            . ' aria-expanded="' . ($open ? 'true' : 'false') . '" aria-controls="' . e($id) . '-panel">'
            . '<span class="accordion__question">' . e($question) . '</span>'
            . icon('chevron-down', 'accordion__chevron', 22)
            . '</button></h3>'
            . '<div class="accordion__panel" id="' . e($id) . '-panel" role="region"'
            . ' aria-labelledby="' . e($id) . '-trigger"' . ($open ? '' : ' hidden') . '>'
            . '<div class="accordion__answer">' . $answer . '</div>'
            . '</div></div>';
    }

    return $html . '</div>';
}

/** Statistics band (prints an honesty note while the figures are placeholders). */
function stats_block(string $variant = 'light'): string
{
    $html = '<div class="stats stats--' . e($variant) . '" data-stats>';
    foreach ((array) COMPANY_STATS as $stat) {
        $html .= '<div class="stats__item reveal">'
            . '<p class="stats__value"><span class="stats__number" data-count="' . (int) ($stat['value'] ?? 0) . '">0</span>'
            . '<span class="stats__suffix">' . e($stat['suffix'] ?? '') . '</span></p>'
            . '<p class="stats__label">' . e($stat['label'] ?? '') . '</p>'
            . '</div>';
    }
    $html .= '</div>';

    if (SHOW_PLACEHOLDER_NOTE_STATS) {
        $html .= placeholder_note(t('note.stats_placeholder'));
    }

    return $html;
}

/** Visible honesty note for content that is still a placeholder. */
function placeholder_note(string $text): string
{
    return '<p class="placeholder-note">' . icon('info', 'placeholder-note__icon', 16)
        . '<span>' . e($text) . '</span></p>';
}

/** Star rating markup (text label included for screen readers). */
function star_rating(int $rating): string
{
    $rating = max(0, min(5, $rating));
    $html   = '<p class="rating" aria-label="' . e(t('common.rating_of', ['rating' => (string) $rating])) . '">';
    for ($i = 1; $i <= 5; $i++) {
        $html .= '<span class="rating__star' . ($i <= $rating ? ' is-filled' : '') . '" aria-hidden="true">'
            . icon('star', 'rating__icon', 18) . '</span>';
    }

    return $html . '<span class="rating__value">' . e(number_format((float) $rating, 1)) . '/5</span></p>';
}

/** Contextual quote hook for EverClean style service card highlights. */
function service_quote_hook(string $slug, string $lang): string
{
    $hooks = [
        'en' => [
            'villa-cleaning'              => 'Get rid of annoying traces and stubborn dust before moving in.',
            'apartment-cleaning'          => 'A fresh, spotless home with guaranteed highest hygiene standards.',
            'deep-cleaning'               => 'Reach every hidden corner and sterilize every surface thoroughly.',
            'sofa-cleaning'               => 'Say goodbye to stains and waiting days for your sofa to dry.',
            'carpet-cleaning'             => 'Deep steam extraction that revives fabrics and eliminates allergens.',
            'kitchen-cleaning'            => 'The heart of your home, returned 100% grease-free and sanitized.',
            'bathroom-cleaning'           => 'Limescale removal, tile shine, and medical-grade sterilization.',
            'window-cleaning'             => 'Crystal clear glass that enhances the natural light in your space.',
            'office-cleaning'             => 'A clean work environment that boosts productivity and impressions.',
            'commercial-building-cleaning'=> 'Maintain the prestige and property value of your facility.',
            'steam-cleaning'              => 'High-temperature steam that kills bacteria without harsh chemicals.',
            'chalet-cleaning'             => 'Your weekend gathering place deserves special care and ready comfort.',
            'post-construction-cleaning'  => 'Eliminate all paint residues, cement dust, and post-work debris.',
            'floor-polishing'             => 'Restore the radiant mirror shine of your marble and tile floors.',
        ],
        'ar' => [
            'villa-cleaning'              => 'تخلص من آثار الأتربة والغبار المزعجة قبل السكن.',
            'apartment-cleaning'          => 'استلم شقتك برائحة منعشة ونظافة استثنائية متكاملة.',
            'deep-cleaning'               => 'نصل لأدق التفاصيل والزوايا المخفية لتعقيم يدوم طويلاً.',
            'sofa-cleaning'               => 'وداعاً للانتظار لأيام حتى يجف الكنب بعد الغسيل.',
            'carpet-cleaning'             => 'تنظيف عميق يعيد رونق السجاد ويزيل أصعب البقع والروائح.',
            'kitchen-cleaning'            => 'المطبخ قلب المنزل، نعيده إليك كالجديد وصحياً 100%.',
            'bathroom-cleaning'           => 'إزالة الترسبات الكلسية وتطهير شامل يضمن أعلى درجات التعقيم.',
            'window-cleaning'             => 'وداعاً للزجاج الباهت، استمتع بإطلالة ناصعة ومشرقة.',
            'office-cleaning'             => 'بيئة عمل نظيفة تعزز الإنتاجية وتعكس احترافية شركتك.',
            'commercial-building-cleaning'=> 'الحفاظ على المظهر الراقي وقيمة المبنى والمنشأة.',
            'steam-cleaning'              => 'بخار فائق الحرارة يقضي على الجراثيم بأعلى معايير الأمان.',
            'chalet-cleaning'             => 'مكان جمعاتكم يستحق عناية خاصة واستعداداً تاماً.',
            'post-construction-cleaning'  => 'إزالة بقايا الدهان والإسمنت وغبار التشطيبات بدقة متناهية.',
            'floor-polishing'             => 'استعادة البريق واللمعان الأصلي للرخام والأرضيات.',
        ],
    ];

    return $hooks[$lang][$slug] ?? ($lang === 'ar' ? 'عناية متخصصة بأعلى معايير الجودة لراحتك وسلامتك.' : 'Specialized care with the highest standards for your comfort.');
}

/** One testimonial card (placeholders stay visibly marked). */
function testimonial_card(array $item): string
{
    $location = (string) ($item['location'] ?? '');
    $rating   = (int) ($item['rating'] ?? 5);
    $initial  = mb_substr($item['name'] ?? 'C', 0, 1);

    $html = '<figure class="testimonial reveal">'
        . '<div class="testimonial__top">'
        . star_rating($rating)
        . '<span class="testimonial__verified">' . icon('shield', 'icon', 14) . '<span>' . (lang() === 'ar' ? 'عميل موثق' : 'Verified Client') . '</span></span>'
        . '</div>'
        . '<span class="testimonial__quote" aria-hidden="true">' . icon('quote', 'icon', 26) . '</span>'
        . '<blockquote class="testimonial__text">' . e($item['text'] ?? '') . '</blockquote>'
        . '<figcaption class="testimonial__meta">'
        . '<span class="testimonial__avatar" aria-hidden="true">' . e($initial) . '</span>'
        . '<div class="testimonial__person">'
        . '<span class="testimonial__name">' . e($item['name'] ?? '') . '</span>';
    if ($location !== '') {
        $html .= '<span class="testimonial__location">' . icon('map-pin', 'icon', 13) . e($location) . '</span>';
    }
    $html .= '</div>';
    if (!empty($item['placeholder'])) {
        $html .= '<span class="badge badge--muted">' . e(t('note.sample_badge')) . '</span>';
    }

    return $html . '</figcaption></figure>';
}

/** Service card used on the home page, category pages and related blocks (EverClean SA inspired). */
/**
 * Service card used on the home page, the services overview and the
 * related-service blocks.
 *
 * Deliberately kept to two actions only — “More details” and “WhatsApp” —
 * so the card stays readable instead of turning into a row of buttons.
 */
function service_card(string $slug, array $options = []): string
{
    $service = service($slug);
    if (!$service) {
        return '';
    }
    $name          = lx($service, 'name', $slug);
    $image         = $service['image'] ?? '/assets/images/placeholder.webp';
    $category      = (string) ($service['category'] ?? 'residential');
    $categoryLabel = lx(service_categories()[$category] ?? [], 'short_name', ucfirst($category));
    $summary       = lx($service, 'short', '');
    $waMsg         = whatsapp_service_message($name);

    /* Three “what is included” points keep the card informative without
       turning it into a wall of text. */
    $highlights = array_slice((array) lxa($service, 'includes', []), 0, 3);

    $html = '<article class="service-card reveal' . (!empty($options['class']) ? ' ' . e($options['class']) : '') . '"'
        . ' data-category="' . e($category) . '">'
        . '<a class="service-card__media" href="' . e_url(service_url($slug)) . '" tabindex="-1" aria-hidden="true">'
        . img_tag([
            'src'        => $image,
            'alt'        => lx($service, 'image_alt', $name),
            'class'      => 'service-card__img',
            'responsive' => true,
            'sizes'      => '(max-width: 599px) 92vw, (max-width: 1023px) 46vw, 380px',
        ])
        . '<span class="service-card__tag">' . e($categoryLabel) . '</span>'
        . '</a>'
        . '<div class="service-card__body">'
        . '<h3 class="service-card__title"><a href="' . e_url(service_url($slug)) . '">' . e($name) . '</a></h3>';

    if ($summary !== '') {
        $html .= '<p class="service-card__text">' . e($summary) . '</p>';
    }

    if ($highlights) {
        $html .= '<ul class="service-card__list">';
        foreach ($highlights as $point) {
            $html .= '<li>' . icon('check', 'service-card__list-icon', 15) . '<span>' . e($point) . '</span></li>';
        }
        $html .= '</ul>';
    }

    $html .= '<div class="service-card__actions">'
        . '<a class="btn btn--primary btn--sm service-card__btn-details" href="' . e_url(service_url($slug)) . '">'
        . '<span class="btn__label">' . e(t('cta.more_details')) . '</span>'
        . icon('arrow-right', 'btn__icon service-card__arrow', 16)
        . '</a>'
        . '<a class="btn btn--whatsapp btn--sm service-card__btn-wa" href="' . e_url(whatsapp_url($waMsg)) . '"'
        . ' target="_blank" rel="noopener noreferrer">'
        . icon('whatsapp', 'btn__icon', 16)
        . '<span class="btn__label">' . e(t('cta.whatsapp_us')) . '</span>'
        . '</a>'
        . '</div>';

    return $html . '</div></article>';
}

/** Quick contact cards ("Get in touch" — EverClean SA inspired). */
function quick_contact_cards(): string
{
    $items = [
        [
            'variant'  => 'call',
            'icon'     => 'phone',
            'label'    => t('home.quick_call_label'),
            'value'    => COMPANY_PHONE,
            'href'     => tel_url(),
            'ltr'      => true,
        ],
        [
            'variant'  => 'wa',
            'icon'     => 'whatsapp',
            'label'    => t('home.quick_wa_label'),
            'value'    => COMPANY_PHONE,
            'href'     => whatsapp_url(whatsapp_quote_message()),
            'external' => true,
            'ltr'      => true,
        ],
        [
            'variant'  => 'mail',
            'icon'     => 'mail',
            'label'    => t('home.quick_mail_label'),
            'value'    => COMPANY_EMAIL,
            'href'     => mail_url(),
            'ltr'      => true,
        ],
        [
            'variant'  => 'hours',
            'icon'     => 'clock',
            'label'    => t('home.quick_hours_label'),
            'value'    => COMPANY_WORKING_HOURS,
        ],
    ];

    $html = '<div class="quick-contact">';
    foreach ($items as $item) {
        $tag     = empty($item['href']) ? 'div' : 'a';
        $classes = 'quick-card quick-card--' . e((string) $item['variant']) . ' reveal';
        $html .= '<' . $tag . ' class="' . e($classes) . '"';
        if (!empty($item['href'])) {
            $html .= ' href="' . e_url((string) $item['href']) . '"';
        }
        if (!empty($item['external'])) {
            $html .= ' target="_blank" rel="noopener noreferrer"';
        }
        $html .= '>';
        $html .= '<span class="quick-card__icon">' . icon((string) $item['icon'], 'icon', 22) . '</span>';
        $html .= '<span class="quick-card__body">'
            . '<span class="quick-card__label">' . e((string) $item['label']) . '</span>'
            . '<span class="quick-card__value"' . (empty($item['ltr']) ? '' : ' dir="ltr"') . '>'
            . e((string) $item['value']) . '</span>'
            . '</span>'
            . (!empty($item['href']) ? icon('arrow-right', 'quick-card__arrow', 18) : '')
            . '</' . $tag . '>';
    }

    return $html . '</div>';
}

/** Service area card. */
function area_card(string $slug): string
{
    $row = area($slug);
    if (!$row) {
        return '';
    }

    return '<a class="area-card reveal" href="' . e_url(area_url($slug)) . '">'
        . '<span class="area-card__icon">' . icon('map-pin', 'icon', 22) . '</span>'
        . '<span class="area-card__name">' . e(lx($row, 'name', $slug)) . '</span>'
        . '<span class="area-card__meta">' . e(lx($row, 'governorate', COMPANY_CITY)) . '</span>'
        . icon('arrow-right', 'area-card__arrow', 18) . '</a>';
}

/** Dark call-to-action band used at the end of most pages. */
function cta_band(array $o = []): string
{
    $title = $o['title'] ?? t('cta.band_title');
    $text  = $o['text'] ?? t('cta.band_text');
    $waMsg = $o['whatsapp_message'] ?? whatsapp_quote_message();

    return '<section class="cta-band" aria-labelledby="cta-band-title">'
        . '<div class="container cta-band__inner">'
        . '<div class="cta-band__content reveal">'
        . '<h2 class="cta-band__title" id="cta-band-title">' . e($title) . '</h2>'
        . '<p class="cta-band__text">' . e($text) . '</p>'
        . '</div>'
        . '<div class="cta-band__actions reveal">'
        . wa_button($waMsg, t('cta.whatsapp_now'), 'whatsapp', ['class' => 'btn--lg'])
        . call_button(t('cta.call_now'), 'light', ['class' => 'btn--lg'])
        . '</div></div></section>';
}

/** Before / after comparison slider (pure JS, no library). */
function before_after(array $item): string
{
    $before = $item['before'] ?? '/assets/images/placeholder.webp';
    $after  = $item['after'] ?? '/assets/images/placeholder.webp';
    $label  = (string) ($item['label'] ?? '');

    return '<div class="ba reveal" data-before-after>'
        . '<div class="ba__frame">'
        . img_tag([
            'src' => $before, 'alt' => $item['before_alt'] ?? t('gallery.before_alt'),
            'class' => 'ba__img ba__img--before', 'responsive' => true,
            'sizes' => '(max-width: 767px) 92vw, 620px',
        ])
        . '<div class="ba__after-wrap" data-ba-after>'
        . img_tag([
            'src' => $after, 'alt' => $item['after_alt'] ?? t('gallery.after_alt'),
            'class' => 'ba__img ba__img--after', 'responsive' => true,
            'sizes' => '(max-width: 767px) 92vw, 620px',
        ])
        . '</div>'
        . '<span class="ba__handle" aria-hidden="true">' . icon('chevron-left', 'icon', 18) . icon('chevron-right', 'icon', 18) . '</span>'
        . '<input class="ba__range" type="range" min="0" max="100" value="50" step="1" data-ba-range'
        . ' aria-label="' . e(t('gallery.before_after_slider')) . '">'
        . '<span class="ba__caption ba__caption--left">' . e(t('gallery.before')) . '</span>'
        . '<span class="ba__caption ba__caption--right">' . e(t('gallery.after')) . '</span>'
        . '</div>'
        . ($label !== '' ? '<p class="ba__label">' . e($label) . '</p>' : '')
        . '</div>';
}

/** Internal linking list ("related pages"). */
function related_links(array $links, string $title = ''): string
{
    $heading = $title !== '' ? $title : t('common.related_pages');
    $html = '<nav class="related-links" aria-label="' . e($heading) . '">';
    if ($title !== '') {
        $html .= '<h2 class="related-links__title">' . e($title) . '</h2>';
    }
    $html .= '<ul class="related-links__list">';
    foreach ($links as $label => $href) {
        $html .= '<li>' . icon('arrow-right', 'related-links__icon', 16)
            . '<a href="' . e_url($href) . '">' . e($label) . '</a></li>';
    }

    return $html . '</ul></nav>';
}