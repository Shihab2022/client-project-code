<?php
/**
 * =====================================================================
 *  IMAGE GENERATOR (developer tool)
 * =====================================================================
 *  Creates ORIGINAL placeholder artwork (WebP) for every image used by
 *  the website: hero, service cards, area pages, gallery and before/after
 *  pairs. Nothing is copied from another website.
 *
 *  Replace these files with real photos of your own cleaning work
 *  (same file names) before going live.
 *
 *  Usage:  php -d extension=gd tools/generate-images.php
 * =====================================================================
 */

$root = dirname(__DIR__) . DIRECTORY_SEPARATOR;

/* ------------------------------------------------------------- helpers */
function img_target(string $rel, int $w, int $h, array $a, array $b, array $c, bool $dull = false): void
{
    global $root;
    $path = $root . ltrim($rel, '/');
    $dir  = dirname($path);
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    $im = imagecreatetruecolor($w, $h);

    /* 1. diagonal gradient background from three brand stops */
    $stops = [$a, $b, $c];
    if ($dull) {
        $stops = array_map(static function (array $rgb) {
            $grey = (int) (($rgb[0] * 0.35 + $rgb[1] * 0.42 + $rgb[2] * 0.23));
            return [
                (int) round($rgb[0] * 0.55 + $grey * 0.45),
                (int) round($rgb[1] * 0.55 + $grey * 0.45),
                (int) round($rgb[2] * 0.55 + $grey * 0.45),
            ];
        }, $stops);
    }
    for ($y = 0; $y < $h; $y++) {
        $t = $y / max(1, $h - 1);
        if ($t < 0.5) {
            $f = $t / 0.5;
            $from = $stops[0];
            $to   = $stops[1];
        } else {
            $f = ($t - 0.5) / 0.5;
            $from = $stops[1];
            $to   = $stops[2];
        }
        $line = imagecolorallocate(
            $im,
            (int) round($from[0] + ($to[0] - $from[0]) * $f),
            (int) round($from[1] + ($to[1] - $from[1]) * $f),
            (int) round($from[2] + ($to[2] - $from[2]) * $f)
        );
        imageline($im, 0, $y, $w, $y, $line);
    }

    imagealphablending($im, true);

    /* 2. soft "soap bubble" circles */
    mt_srand(crc32($rel));
    for ($i = 0; $i < 9; $i++) {
        $cx   = mt_rand(-120, $w + 120);
        $cy   = mt_rand(-80, $h + 80);
        $rad  = mt_rand(30, max(46, (int) (min($w, $h) * 0.22)));
        $alpha = mt_rand(14, 34);
        imagefilledellipse($im, $cx, $cy, $rad * 2, $rad * 2, imagecolorallocatealpha($im, 255, 255, 255, $alpha));
        imagesetthickness($im, 2);
        imageellipse($im, $cx, $cy, $rad * 2, $rad * 2, imagecolorallocatealpha($im, 255, 255, 255, $alpha + 34));
    }

    /* 3. sweeping light diagonal */
    imagefilledpolygon($im, [
        (int) ($w * 0.55), 0,
        $w, 0,
        $w, (int) ($h * 0.78),
        (int) ($w * 0.30), $h,
    ], imagecolorallocatealpha($im, 255, 255, 255, 96));

    /* 4. sparkle motif in the centre */
    $white = imagecolorallocate($im, 255, 255, 255);
    $cx   = (int) ($w * 0.5);
    $cy   = (int) ($h * 0.52);
    $size = (int) (min($w, $h) * 0.15);
    $points = [
        $cx, $cy - $size,
        (int) ($cx + $size * 0.22), (int) ($cy - $size * 0.22),
        $cx + $size, $cy,
        (int) ($cx + $size * 0.22), (int) ($cy + $size * 0.22),
        $cx, $cy + $size,
        (int) ($cx - $size * 0.22), (int) ($cy + $size * 0.22),
        $cx - $size, $cy,
        (int) ($cx - $size * 0.22), (int) ($cy - $size * 0.22),
    ];
    imagefilledpolygon($im, $points, imagecolorallocatealpha($im, 255, 255, 255, 70));
    imagepolygon($im, $points, $white);

    /* 5. small secondary sparkle */
    $s2 = (int) ($size * 0.45);
    $x2 = (int) ($w * 0.66);
    $y2 = (int) ($h * 0.36);
    imagepolygon($im, [
        $x2, $y2 - $s2, $x2 + $s2, $y2, $x2, $y2 + $s2, $x2 - $s2, $y2,
    ], imagecolorallocatealpha($im, 255, 255, 255, 40));

    imagewebp($im, $path, 82);
    imagedestroy($im);
    echo '  + ' . $rel . "\n";
}

function img_set(string $rel, int $w, int $h, array $palette, bool $dull = false): void
{
    /* main image + the -400 / -800 variants consumed by the srcset */
    img_target($rel, $w, $h, $palette[0], $palette[1], $palette[2], $dull);
    img_target(preg_replace('/\.webp$/', '-400.webp', $rel), (int) round($w * 0.5), (int) round($h * 0.5), $palette[0], $palette[1], $palette[2], $dull);
    img_target(preg_replace('/\.webp$/', '-800.webp', $rel), $w, $h, $palette[0], $palette[1], $palette[2], $dull);
}

/* Palettes: teal (residential), navy (commercial), violet (specialised) … */
$P = [
    'teal'   => [[24, 150, 160], [11, 79, 90], [214, 236, 238]],
    'navy'   => [[18, 49, 74], [11, 31, 42], [206, 222, 232]],
    'fresh'  => [[23, 134, 92], [14, 124, 134], [224, 242, 238]],
    'warm'   => [[242, 163, 44], [217, 138, 19], [253, 243, 224]],
    'stone'  => [[122, 138, 148], [91, 107, 120], [232, 238, 242]],
    'violet' => [[92, 108, 168], [56, 68, 116], [228, 232, 244]],
];

echo "Generating placeholder WebP images...\n";

/* Core brand images */
img_set('/assets/images/hero-cleaning.webp', 1280, 960, $P['teal']);
img_set('/assets/images/og-cover.webp', 1200, 630, $P['teal']);
img_set('/assets/images/placeholder.webp', 800, 600, $P['stone']);
img_set('/assets/images/about-team.webp', 1080, 810, $P['fresh']);

/* Service images (palette follows the category) */
$servicesIndex = require $root . 'data/services.php';
foreach ($servicesIndex['services'] as $slug => $row) {
    $category = $row['category'] ?? 'residential';
    $palette  = $category === 'commercial' ? $P['navy'] : ($category === 'specialised' ? $P['violet'] : $P['teal']);
    img_set('/assets/images/services/' . $slug . '.webp', 800, 600, $palette);
}

/* Area images */
$areaData = require $root . 'data/areas.php';
foreach (array_keys($areaData['areas']) as $slug) {
    img_set('/assets/images/areas/' . $slug . '.webp', 800, 560, $P['fresh']);
}

/* Gallery images */
$gallery = require $root . 'data/gallery.php';
foreach ($gallery['items'] as $item) {
    img_set($item['image'], 800, 600, $P['teal']);
}

/* Before / after pairs (before = duller, after = fresher) */
$beforeAfter = require $root . 'data/before-after.php';
foreach ($beforeAfter['items'] as $item) {
    img_set($item['before'], 960, 640, $P['stone'], true);
    img_set($item['after'], 960, 640, $P['fresh']);
}

echo "Done.\n";