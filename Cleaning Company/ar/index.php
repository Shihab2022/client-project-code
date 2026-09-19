<?php
/**
 * =====================================================================
 *  ARABIC LANGUAGE ENTRY POINT  —  /ar/ resolves here
 * =====================================================================
 *  On Apache/Nginx the rewrite rules map /ar/ and /ar/index.php to the
 *  real homepage in the project root, so this file is a fallback for
 *  hosts that rely on DirectoryIndex instead of URL rewriting.
 *
 *  It intentionally does NOT load bootstrap.php itself — index.php does
 *  that. Forcing $_GET['lang'] makes the language resolver pick Arabic
 *  even when a cookie from an earlier English visit exists.
 * =====================================================================
 */

$_GET['lang'] = 'ar';

require dirname(__DIR__) . '/index.php';