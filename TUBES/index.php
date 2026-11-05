<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 * 
 * Redirect/Forward to public directory for XAMPP htdocs compatibility
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? ''
);

// If running via built-in web server and file exists in public, serve it
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

require_once __DIR__.'/public/index.php';
