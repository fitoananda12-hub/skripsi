<?php

/**
 * Laravel Vercel Entry Point
 * Routes all requests through Laravel's public/index.php
 */

// Set the document root to the public directory
$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/../public';
chdir($_SERVER['DOCUMENT_ROOT']);

// Bootstrap the Laravel application
require __DIR__ . '/../public/index.php';
