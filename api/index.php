<?php
/**
 * API Entry Point - Week 2: Authentication & User Management
 */

// Load config
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/constants.php';

// Load utilities
require_once __DIR__ . '/../utils/response.php';
require_once __DIR__ . '/../utils/helpers.php';
require_once __DIR__ . '/../utils/jwt.php';

// Load router
require_once __DIR__ . '/router.php';

// Load models
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/KhoiLop.php';
require_once __DIR__ . '/../models/MonHoc.php';
require_once __DIR__ . '/../models/ChuDe.php';
require_once __DIR__ . '/../models/LopHoc.php';

// Load controllers
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/UserController.php';

// Start session
session_start();

// Set headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=utf-8');

// Handle CORS
if (\['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(HTTP_OK);
    exit;
}

// Initialize router
\ = new Router();

// Controllers
\ = new AuthController();
\ = new UserController();

// ============================================================
// HEALTH CHECK
// ============================================================
\->get('api/health', function() {
    Response::json(Response::success(['status' => 'ok'], 'API running'), HTTP_OK);
});

// ============================================================
// AUTH ENDPOINTS
// ============================================================
\->post('api/auth/login', function() {
    global \;
    \->login();
});

\->post('api/auth/register', function() {
    global \;
    \->register();
});

\->post('api/auth/logout', function() {
    global \;
    \->logout();
});

\->post('api/auth/reset-password', function() {
    global \;
    \->resetPassword();
});

\->get('api/auth/me', function() {
    global \;
    \->getCurrentUser();
});

// ============================================================
// USER ENDPOINTS
// ============================================================
\->get('api/users/:id', function(\) {
    global \;
    \ = \[0] ?? null;
    if (!\) {
        Response::json(Response::error('Invalid user ID', HTTP_BAD_REQUEST), HTTP_BAD_REQUEST);
        return;
    }
    \->getProfile(\);
});

\->put('api/users/:id', function(\) {
    global \;
    \ = \[0] ?? null;
    if (!\) {
        Response::json(Response::error('Invalid user ID', HTTP_BAD_REQUEST), HTTP_BAD_REQUEST);
        return;
    }
    \->updateProfile(\);
});

\->put('api/users/:id/password', function(\) {
    global \;
    \ = \[0] ?? null;
    if (!\) {
        Response::json(Response::error('Invalid user ID', HTTP_BAD_REQUEST), HTTP_BAD_REQUEST);
        return;
    }
    \->changePassword(\);
});

\->get('api/users/pending', function() {
    global \;
    \->getPendingStudents();
});

\->put('api/users/:id/approve', function(\) {
    global \;
    \ = \[0] ?? null;
    if (!\) {
        Response::json(Response::error('Invalid user ID', HTTP_BAD_REQUEST), HTTP_BAD_REQUEST);
        return;
    }
    \->approveUser(\);
});

\->put('api/users/:id/reject', function(\) {
    global \;
    \ = \[0] ?? null;
    if (!\) {
        Response::json(Response::error('Invalid user ID', HTTP_BAD_REQUEST), HTTP_BAD_REQUEST);
        return;
    }
    \->rejectUser(\);
});

// ============================================================
// CATEGORY ENDPOINTS
// ============================================================
\->get('api/khoi-lop', function() {
    \ = new KhoiLop();
    \ = \->getAll();
    Response::json(Response::success(\, 'Get grades'), HTTP_OK);
});

\->get('api/mon-hoc', function() {
    \ = \['khoi_id'] ?? null;
    \ = new MonHoc();
    \ = \ ? \->getByKhoi(\) : \->getAll();
    Response::json(Response::success(\, 'Get subjects'), HTTP_OK);
});

\->get('api/chu-de', function() {
    \ = \['mon_id'] ?? null;
    \ = new ChuDe();
    \ = \ ? \->getByMon(\) : \->getAll();
    Response::json(Response::success(\, 'Get topics'), HTTP_OK);
});

// Dispatch
\->dispatch();
?>
