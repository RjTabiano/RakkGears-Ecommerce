<?php
// Simple route test - visit /?route_test=1
if (isset($_GET['route_test'])) {
    echo "<h1>Route Test</h1>";
    
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
        
        echo "<h2>Test Links:</h2>";
        echo "<p><a href='/'>Home</a></p>";
        echo "<p><a href='/about'>About</a></p>";
        echo "<p><a href='/product_list'>Product List</a></p>";
        echo "<p><a href='/tracking'>Tracking</a></p>";
        
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    exit;
}
?>
