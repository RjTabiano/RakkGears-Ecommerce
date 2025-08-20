<?php
echo "<h1>Direct Laravel Test</h1>";

// Show current request info
echo "<h2>Request Info:</h2>";
echo "<p><strong>REQUEST_URI:</strong> " . ($_SERVER['REQUEST_URI'] ?? 'Not set') . "</p>";
echo "<p><strong>HTTP_HOST:</strong> " . ($_SERVER['HTTP_HOST'] ?? 'Not set') . "</p>";
echo "<p><strong>SERVER_NAME:</strong> " . ($_SERVER['SERVER_NAME'] ?? 'Not set') . "</p>";
echo "<p><strong>SCRIPT_NAME:</strong> " . ($_SERVER['SCRIPT_NAME'] ?? 'Not set') . "</p>";

// Test Laravel directly
try {
    require_once __DIR__ . '/vendor/autoload.php';
    $app = require_once __DIR__ . '/bootstrap/app.php';
    
    echo "<h2>✅ Laravel App Loaded Successfully</h2>";
    
    // Test a specific route manually
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    
    // Create a fake request for /product_list
    $request = Illuminate\Http\Request::create('/product_list', 'GET');
    
    echo "<h2>Testing /product_list route:</h2>";
    
    try {
        $response = $kernel->handle($request);
        echo "<p>✅ Route handled successfully!</p>";
        echo "<p><strong>Status:</strong> " . $response->getStatusCode() . "</p>";
        echo "<p><strong>Content type:</strong> " . $response->headers->get('content-type') . "</p>";
        
        // Show first 500 chars of response
        $content = $response->getContent();
        echo "<p><strong>Response preview:</strong></p>";
        echo "<div style='border:1px solid #ccc; padding:10px; max-height:200px; overflow:auto;'>";
        echo htmlspecialchars(substr($content, 0, 500));
        echo "</div>";
        
    } catch (Exception $e) {
        echo "<p>❌ Route failed: " . $e->getMessage() . "</p>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    }
    
    $kernel->terminate($request, $response ?? null);
    
} catch (Exception $e) {
    echo "<p>❌ Laravel failed to load: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<h2>Manual Route Test Links:</h2>";
echo "<p><a href='/direct_test.php?route=/'>Test Home Route</a></p>";
echo "<p><a href='/direct_test.php?route=/product_list'>Test Product List Route</a></p>";
echo "<p><a href='/direct_test.php?route=/about'>Test About Route</a></p>";

// Test specific route if provided
if (isset($_GET['route'])) {
    $testRoute = $_GET['route'];
    echo "<h2>Testing Route: $testRoute</h2>";
    
    try {
        require_once __DIR__ . '/vendor/autoload.php';
        $app = require_once __DIR__ . '/bootstrap/app.php';
        $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
        
        $request = Illuminate\Http\Request::create($testRoute, 'GET');
        $response = $kernel->handle($request);
        
        echo "<p>✅ Status: " . $response->getStatusCode() . "</p>";
        echo "<div style='border:1px solid #ccc; padding:10px;'>";
        echo $response->getContent();
        echo "</div>";
        
        $kernel->terminate($request, $response);
        
    } catch (Exception $e) {
        echo "<p>❌ Error: " . $e->getMessage() . "</p>";
    }
}
?>
