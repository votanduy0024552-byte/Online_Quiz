<?php
/**
 * API Entry Point
 * 
 * All API requests go through this file
 */

// Load config
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/constants.php';

// Load utilities
require_once __DIR__ . '/../utils/response.php';
require_once __DIR__ . '/../utils/helpers.php';

// Load router
require_once __DIR__ . '/router.php';

// Load models
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/KhoiLop.php';
require_once __DIR__ . '/../models/MonHoc.php';
require_once __DIR__ . '/../models/ChuDe.php';
require_once __DIR__ . '/../models/LopHoc.php';

// Start session
session_start();

// Set headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=utf-8');

// Handle CORS preflight
if (\['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(HTTP_OK);
    exit;
}

// Initialize router
\ = new Router();

// Register API routes

// Health check
\->get('api/health', function() {
    Response::json(Response::success(['status' => 'ok'], 'API is running'), HTTP_OK);
});

// Category routes
\->get('api/khoi-lop', function() {
    \ = new KhoiLop();
    \ = \->getAll();
    Response::json(Response::success(\, 'Get all grades'), HTTP_OK);
});

\->get('api/mon-hoc', function() {
    \ = \['khoi_id'] ?? null;
    \ = new MonHoc();
    
    if (\) {
        \ = \->getByKhoi(\);
    } else {
        \ = \->getAll();
    }
    
    Response::json(Response::success(\, 'Get subjects'), HTTP_OK);
});

\->get('api/chu-de', function() {
    \ = \['mon_id'] ?? null;
    \ = new ChuDe();
    
    if (\) {
        \ = \->getByMon(\);
    } else {
        \ = \->getAll();
    }
    
    Response::json(Response::success(\, 'Get topics'), HTTP_OK);
});

// Dispatch request
\->dispatch();
?>
