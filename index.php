<?php
/**
 * Laravel Application Entry Point for Azure App Service
 */

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

// Check if we have Laravel
if (!file_exists(__DIR__ . '/public/index.php') || !file_exists(__DIR__ . '/bootstrap/app.php')) {
    die('Laravel application not found. Missing files.');
}

// Get the request URI and clean it
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($requestUri, PHP_URL_PATH);

// Handle static assets by redirecting to public folder
if (preg_match('/\.(css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot|map)$/i', $path)) {
    $publicPath = '/public' . $requestUri;
    header("Location: $publicPath");
    exit;
}

// Set up environment for Laravel
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/public/index.php';
$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/public';

// Clean the request URI for Laravel
if (strpos($requestUri, '/index.php') === 0) {
    $requestUri = substr($requestUri, 10) ?: '/';
    $_SERVER['REQUEST_URI'] = $requestUri;
}

try {
    // Load Laravel
    require __DIR__ . '/public/index.php';
} catch (Exception $e) {
    echo "Laravel Error: " . $e->getMessage();
    echo "<br><a href='?test=1'>Run Tests</a> | <a href='?debug=1'>Show Debug</a>";
}
?>
