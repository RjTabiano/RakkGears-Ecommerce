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

// Now load Laravel
require_once __DIR__ . '/public/index.php';
?>
