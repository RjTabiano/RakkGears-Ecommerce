<?php
// Redirect to Laravel's public directory
header('Location: /public/index.php' . ($_SERVER['REQUEST_URI'] !== '/' ? $_SERVER['REQUEST_URI'] : ''));
exit;
