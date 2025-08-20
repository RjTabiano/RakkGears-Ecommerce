<?php
/**
 * Laravel Application Entry Point for Azure App Service
 * This file works around Azure's default nginx configuration
 */

// Show direct test if requested
if (isset($_GET['direct'])) {
    include __DIR__ . '/direct_test.php';
    exit;
}

// Show route test if requested
if (isset($_GET['route_test'])) {
    include __DIR__ . '/route_test.php';
    exit;
}

// Show test page if requested
if (isset($_GET['test'])) {
    include __DIR__ . '/test.php';
    exit;
}

// Show debug page if requested
if (isset($_GET['debug'])) {
    include __DIR__ . '/debug.php';
    exit;
}

// Clear Laravel caches if requested
if (isset($_GET['clear'])) {
    exec('cd ' . __DIR__ . ' && php artisan cache:clear 2>&1', $output);
    exec('cd ' . __DIR__ . ' && php artisan route:clear 2>&1', $output2);
    exec('cd ' . __DIR__ . ' && php artisan config:clear 2>&1', $output3);
    echo "<h1>Caches Cleared!</h1>";
    echo "<pre>" . implode("\n", array_merge($output, $output2, $output3)) . "</pre>";
    echo "<p><a href='/'>Go to Home</a> | <a href='/about'>Test About</a></p>";
    exit;
}

// Ensure Laravel directories exist and are writable
$dirs = [
    __DIR__ . '/storage/logs',
    __DIR__ . '/storage/framework/cache',
    __DIR__ . '/storage/framework/sessions',
    __DIR__ . '/storage/framework/views',
    __DIR__ . '/bootstrap/cache'
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Get current request info
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($requestUri, PHP_URL_PATH);

// Handle static assets by redirecting to public folder
if (preg_match('/\.(css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot|map)$/i', $path)) {
    $publicPath = '/public' . $requestUri;
    header("Location: $publicPath");
    exit;
}

// Since Azure nginx doesn't have proper try_files, we need to handle routing in PHP
// Check if the request is for a Laravel route

// Backup original server variables
$originalRequestUri = $_SERVER['REQUEST_URI'];
$originalScriptName = $_SERVER['SCRIPT_NAME'] ?? '';

// Set up Laravel environment properly
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/public/index.php';
$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/public';

// The key fix: Set the REQUEST_URI correctly for Laravel
// Laravel expects the path without /index.php prefix
if ($path !== '/') {
    $_SERVER['REQUEST_URI'] = $path . (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '');
}

try {
    // Load Laravel's public/index.php which contains the actual application bootstrap
    require __DIR__ . '/public/index.php';
} catch (Exception $e) {
    // Restore original values in case of error
    $_SERVER['REQUEST_URI'] = $originalRequestUri;
    $_SERVER['SCRIPT_NAME'] = $originalScriptName;
    
    echo "Laravel Error: " . $e->getMessage();
    echo "<br><br><a href='?test=1'>Run Tests</a> | <a href='?debug=1'>Show Debug</a> | <a href='?direct=1'>Direct Test</a>";
}
?>
?>
