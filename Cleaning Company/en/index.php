<?php
/**
 * =====================================================================
 *  ENGLISH LANGUAGE ENTRY POINT  —  /en/ resolves here
 * =====================================================================
 *  Mirrors /ar/index.php so both language roots behave identically on
 *  hosts that use DirectoryIndex instead of URL rewriting.
 *
 *  It does not load bootstrap.php itself — index.php does that.
 * =====================================================================
 */

$_GET['lang'] = 'en';

require dirname(__DIR__) . '/index.php';