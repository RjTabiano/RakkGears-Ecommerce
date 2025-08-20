<?php
// Laravel bootstrap for Azure App Service
// This file ensures Laravel works correctly in Azure environment

// Set timezone
date_default_timezone_set('UTC');

// Ensure storage and cache directories exist and are writable
$dirs = [
    __DIR__ . '/storage/app',
    __DIR__ . '/storage/app/public',
    __DIR__ . '/storage/framework',
    __DIR__ . '/storage/framework/cache',
    __DIR__ . '/storage/framework/cache/data',
    __DIR__ . '/storage/framework/sessions',
    __DIR__ . '/storage/framework/testing',
    __DIR__ . '/storage/framework/views',
    __DIR__ . '/storage/logs',
    __DIR__ . '/bootstrap/cache'
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
    @chmod($dir, 0755);
}

// Fix the request URI for Laravel routing
$requestUri = $_SERVER['REQUEST_URI'];

// Remove /index.php from the URI if present
if (strpos($requestUri, '/index.php') === 0) {
    $requestUri = substr($requestUri, 10); // Remove '/index.php'
    if (empty($requestUri)) {
        $requestUri = '/';
    }
}

// Update server variables for Laravel
$_SERVER['REQUEST_URI'] = $requestUri;
$_SERVER['SCRIPT_NAME'] = '/public/index.php';
$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/public/index.php';

// Set document root to public folder
$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/public';

// Now load Laravel
require_once __DIR__ . '/public/index.php';
?>
