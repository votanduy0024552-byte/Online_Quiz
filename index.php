<?php
/**
 * Online_Quiz - MyExam Mobile LMS
 * 
 * Main entry point for the application
 */

// Load configuration
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/config/database.php';

// Load utilities
require_once __DIR__ . '/utils/response.php';
require_once __DIR__ . '/utils/helpers.php';

// Load models
require_once __DIR__ . '/models/Database.php';
require_once __DIR__ . '/models/User.php';

// Start session
session_start();

// Set headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=utf-8');

// Handle preflight
if (\['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(HTTP_OK);
    exit;
}

// Route handling
\ = parse_url(\['REQUEST_URI'], PHP_URL_PATH);
\ = \['REQUEST_METHOD'];

// Simple routing
if (strpos(\, '/api/') === 0) {
    // API routes
    \ = substr(\, 5); // Remove '/api/'
    \ = explode('/', trim(\, '/'));
    \ = \[0] ?? '';
    
    // Route to appropriate API file
    \ = __DIR__ . '/api/' . \ . '.php';
    if (file_exists(\)) {
        require_once \;
    } else {
        Response::json(Response::error('Endpoint not found', HTTP_NOT_FOUND), HTTP_NOT_FOUND);
    }
} else {
    // Web routes
    \ = \ === '/' ? 'home' : trim(\, '/');
    
    // Check authentication
    if (!\ || \ === 'home') {
        if (isLoggedIn()) {
            // Redirect to dashboard based on role
            \ = \['role'] ?? '';
            if (\ === ROLE_ADMIN) {
                redirect('/admin/dashboard');
            } elseif (\ === ROLE_TEACHER) {
                redirect('/teacher/dashboard');
            } else {
                redirect('/student/dashboard');
            }
        } else {
            require __DIR__ . '/views/auth/login.php';
        }
    } else {
        // Load view file
        \ = __DIR__ . '/views/' . \ . '.php';
        if (file_exists(\)) {
            require __DIR__ . '/views/layouts/header.php';
            require \;
            require __DIR__ . '/views/layouts/footer.php';
        } else {
            require __DIR__ . '/views/errors/404.php';
        }
    }
}
?>
