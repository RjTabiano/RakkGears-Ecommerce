<?php
echo "<h1>Debug Info</h1>";
echo "<h2>Server Variables:</h2>";
echo "<pre>";
print_r($_SERVER);
echo "</pre>";

echo "<h2>Request Info:</h2>";
echo "REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'Not set') . "<br>";
echo "SCRIPT_NAME: " . ($_SERVER['SCRIPT_NAME'] ?? 'Not set') . "<br>";
echo "PHP_SELF: " . ($_SERVER['PHP_SELF'] ?? 'Not set') . "<br>";

echo "<h2>Environment Variables:</h2>";
echo "APP_ENV: " . (getenv('APP_ENV') ?: 'Not set') . "<br>";
echo "APP_KEY: " . (getenv('APP_KEY') ? 'Set (' . substr(getenv('APP_KEY'), 0, 20) . '...)' : 'Not set') . "<br>";

echo "<h2>File System:</h2>";
echo "Current Directory: " . getcwd() . "<br>";
echo "Document Root: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Not set') . "<br>";
echo "Laravel Public exists: " . (file_exists(__DIR__ . '/public/index.php') ? 'Yes' : 'No') . "<br>";
echo "Laravel App exists: " . (file_exists(__DIR__ . '/bootstrap/app.php') ? 'Yes' : 'No') . "<br>";

echo "<h2>Test Laravel:</h2>";
try {
    if (file_exists(__DIR__ . '/vendor/autoload.php')) {
        require_once __DIR__ . '/vendor/autoload.php';
        echo "✅ Autoload loaded<br>";
        
        if (file_exists(__DIR__ . '/bootstrap/app.php')) {
            $app = require_once __DIR__ . '/bootstrap/app.php';
            echo "✅ Laravel app created<br>";
        }
    } else {
        echo "❌ Vendor autoload not found<br>";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}
?>
