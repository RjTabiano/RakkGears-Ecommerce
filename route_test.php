<?php
// Simple route test - visit /?route_test=1
if (isset($_GET['route_test'])) {
    echo "<h1>Route Test</h1>";
    
    echo "<h2>Server Variables:</h2>";
    echo "<p><strong>REQUEST_URI:</strong> " . ($_SERVER['REQUEST_URI'] ?? 'Not set') . "</p>";
    echo "<p><strong>PATH_INFO:</strong> " . ($_SERVER['PATH_INFO'] ?? 'Not set') . "</p>";
    echo "<p><strong>QUERY_STRING:</strong> " . ($_SERVER['QUERY_STRING'] ?? 'Not set') . "</p>";
    
    // Test if we can access Laravel routes
    try {
        require_once __DIR__ . '/vendor/autoload.php';
        $app = require_once __DIR__ . '/bootstrap/app.php';
        
        // Get the router
        $router = $app->make('router');
        $routes = $router->getRoutes();
        
        echo "<h2>Available Routes:</h2>";
        echo "<ul>";
        foreach ($routes as $route) {
            $methods = implode(', ', $route->methods());
            $uri = $route->uri();
            echo "<li><strong>$methods</strong> /$uri</li>";
        }
        echo "</ul>";
        
        echo "<h2>Test Links (should work with proper routing):</h2>";
        echo "<p><a href='/'>Home</a></p>";
        echo "<p><a href='/about'>About</a></p>";
        echo "<p><a href='/product_list'>Product List</a></p>";
        echo "<p><a href='/tracking'>Tracking</a></p>";
        echo "<p><a href='/warranty'>Warranty</a></p>";
        
        echo "<h2>Direct Laravel Route Test:</h2>";
        echo "<p>Try manually: <code>https://your-app.azurewebsites.net/product_list</code></p>";
        
    } catch (Exception $e) {
        echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    }
    exit;
}
?>
