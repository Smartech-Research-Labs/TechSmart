<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Send a saved copy of a public page without starting Laravel (see App\Support\PageCache).
if (in_array($_SERVER['REQUEST_METHOD'] ?? '', ['GET', 'HEAD'], true) && ($_SERVER['QUERY_STRING'] ?? '') === '') {
    $pagePath = (string) parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $pageFile = __DIR__.'/../storage/framework/page-cache/'.(@filemtime(__DIR__.'/build/manifest.json') ?: 0)
        .'/'.md5(strtolower($_SERVER['HTTP_HOST'] ?? '').'|'.$pagePath).'.html';
    $pageTime = preg_match('#^/[A-Za-z0-9/_-]{0,200}$#', $pagePath) ? @filemtime($pageFile) : false;

    if ($pageTime && $pageTime > time() - 3600) {
        header('Content-Type: text/html; charset=UTF-8');
        header('Cache-Control: no-cache, private');
        header('X-Page-Cache: hit');
        readfile($pageFile);
        exit;
    }
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
