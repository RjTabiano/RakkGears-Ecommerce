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
    
    // If we're at the root, redirect to public
    if ($uri === '/' || $uri === '/index.php') {
        header('Location: /public/');
        exit;
    }
    
    // For other requests, redirect to public with the path
    if (strpos($uri, '/public/') !== 0) {
        header('Location: /public' . $uri);
        exit;
    }
}

// If we get here, show an error
echo "Laravel application not found. <a href='?debug=1'>Click here for diagnostics</a>";
?>
