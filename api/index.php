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
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(HTTP_OK);
    exit;
}

// Initialize router
$router = new Router();

// Register API routes

// Health check
$router->get('api/health', function() {
    Response::json(Response::success(['status' => 'ok'], 'API is running'), HTTP_OK);
});

// Category routes
$router->get('api/khoi-lop', function() {
    $khoi = new KhoiLop();
    $data = $khoi->getAll();
    Response::json(Response::success($data, 'Get all grades'), HTTP_OK);
});

$router->get('api/mon-hoc', function() {
    $khoi_id = $_GET['khoi_id'] ?? null;
    $mon = new MonHoc();
    
    if ($khoi_id) {
        $data = $mon->getByKhoi($khoi_id);
    } else {
        $data = $mon->getAll();
    }
    
    Response::json(Response::success($data, 'Get subjects'), HTTP_OK);
});

$router->get('api/chu-de', function() {
    $mon_id = $_GET['mon_id'] ?? null;
    $chu_de = new ChuDe();
    
    if ($mon_id) {
        $data = $chu_de->getByMon($mon_id);
    } else {
        $data = $chu_de->getAll();
    }
    
    Response::json(Response::success($data, 'Get topics'), HTTP_OK);
});

// Dispatch request
$router->dispatch();
?>
