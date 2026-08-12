<?php

/**
 * Laravel Vercel Entry Point
 */

$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/../public';
chdir($_SERVER['DOCUMENT_ROOT']);

// Vercel Serverless environment makes /var/task read-only.
// We must redirect storage and cache paths to /tmp which is writable.
$storagePath = '/tmp/storage';
$dirs = [
    '/framework/views',
    '/framework/cache/data',
    '/framework/sessions',
    '/logs',
    '/bootstrap/cache',
];

foreach ($dirs as $dir) {
    if (!is_dir($storagePath . $dir)) {
        mkdir($storagePath . $dir, 0755, true);
    }
}

// Override Laravel Cache & View paths
$_ENV['VIEW_COMPILED_PATH'] = $storagePath . '/framework/views';
$_ENV['APP_SERVICES_CACHE'] = $storagePath . '/bootstrap/cache/services.php';
$_ENV['APP_PACKAGES_CACHE'] = $storagePath . '/bootstrap/cache/packages.php';
$_ENV['APP_CONFIG_CACHE'] = $storagePath . '/bootstrap/cache/config.php';
$_ENV['APP_ROUTES_CACHE'] = $storagePath . '/bootstrap/cache/routes.php';
$_ENV['APP_EVENTS_CACHE'] = $storagePath . '/bootstrap/cache/events.php';

// Panggil autoloader (PENTING: Harus sebelum require app.php!)
require __DIR__.'/../vendor/autoload.php';

// Atur aplikasi agar merujuk storage ke /tmp
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->useStoragePath($storagePath);

// Jalankan request (sama seperti public/index.php)
$app->handleRequest(Illuminate\Http\Request::capture());
