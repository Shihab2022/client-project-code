<?php
/**
 * =====================================================================
 *  PAGE GENERATOR (developer tool – run once, or after changing data)
 * =====================================================================
 *  Creates the thin wrapper files that render each service page, each
 *  Kuwait area page and the Arabic mirror pages. Content lives in /data,
 *  so these files only declare the slug and include the template.
 *
 *  Usage:  php tools/generate-pages.php
 * =====================================================================
 */

$root = dirname(__DIR__) . DIRECTORY_SEPARATOR;
require $root . 'config/config.php';
require $root . 'includes/functions.php';

$serviceData = require $root . 'data/services.php';
$areaData    = require $root . 'data/areas.php';

$serviceStub = <<<'PHP'
<?php
/**
 * Service page wrapper – %SERVICE% in Kuwait.
 * Content: /data/services/%SLUG%.php   Layout: /includes/service-page.php
 */

$serviceSlug = '%SLUG%';
require dirname(__DIR__) . '/includes/service-page.php';
PHP;

$areaStub = <<<'PHP'
<?php
/**
 * Service area page wrapper – %AREA%.
 * Content: /data/areas.php   Layout: /includes/area-page.php
 */

$areaSlug = '%SLUG%';
require dirname(__DIR__) . '/includes/area-page.php';
PHP;

$langStub = <<<'PHP'
<?php
/**
 * Language entry point (%LANG%) — /%LANG%/ resolves here.
 * The language is taken from the first URL segment by includes/bootstrap.php,
 * which then redirects to the language prefixed page of the default entry.
 */

require dirname(__DIR__, 2) . '/includes/bootstrap.php';

$target = base_path() . '/%LANG%' . ($GLOBALS['CURRENT_PATH'] === '/index.php' ? '/' : $GLOBALS['CURRENT_PATH']);
header('Location: ' . $target, true, 302);
exit;
PHP;

$created = 0;

/* --- Service pages --------------------------------------------------- */
if (!is_dir($root . 'services')) {
    mkdir($root . 'services', 0755, true);
}
foreach (array_keys($serviceData['services']) as $slug) {
    $file = $root . 'services' . DIRECTORY_SEPARATOR . $slug . '.php';
    if (!is_file($file)) {
        file_put_contents($file, str_replace('%%', '%', str_replace(
            ['%SERVICE%', '%SLUG%'],
            [$serviceData['services'][$slug]['name'] ?? $slug, $slug],
            $serviceStub
        )));
        $created++;
    }
}

/* --- Area pages ------------------------------------------------------ */
if (!is_dir($root . 'areas')) {
    mkdir($root . 'areas', 0755, true);
}
foreach ($areaData['areas'] as $slug => $row) {
    $file = $root . 'areas' . DIRECTORY_SEPARATOR . $slug . '.php';
    if (!is_file($file)) {
        file_put_contents($file, str_replace('%%', '%', str_replace(
            ['%AREA%', '%SLUG%'],
            [$row['name'] ?? $slug, $slug],
            $areaStub
        )));
        $created++;
    }
}

/* --- Language entry points (used when mod_rewrite is available) ------ */
foreach (SUPPORTED_LANGS as $code) {
    if ($code === DEFAULT_LANG) {
        continue;
    }
    $dir = $root . $code;
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    file_put_contents($dir . DIRECTORY_SEPARATOR . 'index.php', str_replace('%LANG%', $code, $langStub));
    $created++;
}

echo 'Generated ' . $created . " page wrapper file(s).\n";
echo 'Services: ' . count($serviceData['services']) . ' | Areas: ' . count($areaData['areas']) . "\n";