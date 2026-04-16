<?php
/**
 * Application Configuration
 * 
 * @author votanduy0024552-byte
 * @date 2025-04-16
 */

// Application Settings
define('APP_NAME', 'MyExam Mobile - Learning Management System');
define('APP_VERSION', '1.0.0');
define('APP_URL', 'http://localhost:8000');
define('APP_ENV', 'development'); // development, staging, production

// Directories
define('APP_ROOT', dirname(dirname(__FILE__)));
define('CONFIG_DIR', APP_ROOT . '/config');
define('MODELS_DIR', APP_ROOT . '/models');
define('CONTROLLERS_DIR', APP_ROOT . '/controllers');
define('VIEWS_DIR', APP_ROOT . '/views');
define('PUBLIC_DIR', APP_ROOT . '/public');
define('UTILS_DIR', APP_ROOT . '/utils');
define('LOGS_DIR', APP_ROOT . '/logs');
define('DATABASE_DIR', APP_ROOT . '/database');
define('UPLOADS_DIR', PUBLIC_DIR . '/uploads');

// Time Settings
define('SESSION_TIMEOUT', 3600); // 1 hour
define('DEFAULT_TIMEZONE', 'Asia/Ho_Chi_Minh');
date_default_timezone_set(DEFAULT_TIMEZONE);

// Security
define('JWT_SECRET', 'your-secret-key-here-change-in-production');
define('PASSWORD_HASH_ALGO', PASSWORD_BCRYPT);

// ImgBB API
define('IMGBB_API_KEY', 'your-imgbb-api-key-here');

// Database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'myexam_db');
define('DB_PORT', 3306);
define('DB_CHARSET', 'utf8mb4');

// Error Handling
define('SHOW_ERRORS', APP_ENV === 'development');
if (SHOW_ERRORS) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

// Logging
define('LOG_ERRORS', true);
define('LOG_LEVEL', 'INFO'); // DEBUG, INFO, WARNING, ERROR

// CORS Settings
define('ALLOWED_ORIGINS', ['http://localhost:8000', 'http://localhost:3000']);

// File Upload
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp']);

// Pagination
define('ITEMS_PER_PAGE', 20);

// Cache
define('USE_CACHE', false);
define('CACHE_DURATION', 3600); // 1 hour
?>
