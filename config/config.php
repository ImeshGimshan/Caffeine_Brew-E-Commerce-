<?php
/**
 * Application Configuration
 * This file contains all configuration settings for the application
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define base paths
define('BASE_PATH', dirname(__DIR__));
define('CONFIG_PATH', BASE_PATH . '/config');
define('SRC_PATH', BASE_PATH . '/src');
define('PUBLIC_PATH', BASE_PATH . '/public');
define('ADMIN_PATH', BASE_PATH . '/admin');
define('USER_PATH', BASE_PATH . '/user');
define('UPLOADS_PATH', BASE_PATH . '/assets/uploads');

// Define base URL - Update this according to your server setup
define('BASE_URL', 'http://localhost:8000');
define('ASSETS_URL', BASE_URL . '/assets');
define('CSS_URL', BASE_URL . '/public/css');
define('JS_URL', BASE_URL . '/public/js');
define('IMG_URL', BASE_URL . '/public/images');

// Error reporting (Set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('Asia/Colombo');

// Application settings
define('APP_NAME', 'Caffeine Brew');
define('APP_VERSION', '2.0.0');

// Load database configuration
require_once CONFIG_PATH . '/database.php';
