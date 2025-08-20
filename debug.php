<?php
// Simple diagnostic script
echo "<h1>Laravel Diagnostics</h1>";

// Check basic PHP info
echo "<h2>PHP Version: " . phpversion() . "</h2>";

// Check if Laravel is accessible
try {
    require_once __DIR__ . '/public/../vendor/autoload.php';
    echo "<p>✅ Composer autoload found</p>";
} catch (Exception $e) {
    echo "<p>❌ Composer autoload error: " . $e->getMessage() . "</p>";
}

// Check environment variables
echo "<h2>Environment Variables:</h2>";
$envVars = ['APP_ENV', 'APP_DEBUG', 'APP_KEY', 'DB_CONNECTION', 'DB_HOST', 'DB_DATABASE'];
foreach ($envVars as $var) {
    $value = getenv($var) ?: $_ENV[$var] ?? 'NOT SET';
    if ($var === 'APP_KEY' && $value !== 'NOT SET') {
        $value = substr($value, 0, 10) . '...'; // Hide full key
    }
    echo "<p>$var: $value</p>";
}

// Check file permissions
echo "<h2>File Permissions:</h2>";
$paths = [
    '/home/site/wwwroot/storage',
    '/home/site/wwwroot/bootstrap/cache',
    '/home/site/wwwroot/public'
];

foreach ($paths as $path) {
    if (is_dir($path)) {
        $perms = substr(sprintf('%o', fileperms($path)), -4);
        echo "<p>$path: $perms " . (is_writable($path) ? '✅' : '❌') . "</p>";
    } else {
        echo "<p>$path: Does not exist ❌</p>";
    }
}

// Try to load Laravel
echo "<h2>Laravel Bootstrap Test:</h2>";
try {
    $app = require_once __DIR__ . '/public/../bootstrap/app.php';
    echo "<p>✅ Laravel app created successfully</p>";
    
    // Try to get config
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    echo "<p>✅ HTTP Kernel created</p>";
    
} catch (Exception $e) {
    echo "<p>❌ Laravel bootstrap error: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
