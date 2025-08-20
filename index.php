<?php
// Check if debug.php exists and show diagnostics if there's an error
if (isset($_GET['debug']) && file_exists(__DIR__ . '/debug.php')) {
    include __DIR__ . '/debug.php';
    exit;
}

// Check if Laravel is working
if (file_exists(__DIR__ . '/public/index.php')) {
    // Get the current URI
    $uri = $_SERVER['REQUEST_URI'];
    
    // Remove query string for route matching
    $path = parse_url($uri, PHP_URL_PATH);
    
    // Handle static assets - redirect to public folder
    if (preg_match('/\.(css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$/i', $path)) {
        header('Location: /public' . $uri);
        exit;
    }
    
    // Handle all other requests through Laravel
    // Set up the request for Laravel
    $_SERVER['SCRIPT_NAME'] = '/index.php';
    $_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/index.php';
    
    // Load Laravel
    require_once __DIR__ . '/azure-bootstrap.php';
    exit;
}

// If we get here, show an error
echo "Laravel application not found. <a href='?debug=1'>Click here for diagnostics</a>";
?>
