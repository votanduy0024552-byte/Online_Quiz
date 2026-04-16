<?php
/**
 * API Entry Point - Tuần 2: Authentication & User Management
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

// Handle CORS preflight
if (\['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(HTTP_OK);
    exit;
}

// Initialize router
\ = new Router();

// Initialize controllers
\ = new AuthController();
\ = new UserController();

// ============================================================
// HEALTH CHECK ENDPOINT
// ============================================================
\->get('api/health', function() {
    Response::json(Response::success(['status' => 'ok', 'timestamp' => date('Y-m-d H:i:s')], 'API is running'), HTTP_OK);
});

// ============================================================
// AUTHENTICATION ENDPOINTS (TUẦN 2)
// ============================================================

// POST /api/auth/login
\->post('api/auth/login', function() {
    global \;
    \->login();
});

// POST /api/auth/register
\->post('api/auth/register', function() {
    global \;
    \->register();
});

// POST /api/auth/logout
\->post('api/auth/logout', function() {
    global \;
    \->logout();
});

// POST /api/auth/reset-password
\->post('api/auth/reset-password', function() {
    global \;
    \->resetPassword();
});

// GET /api/auth/me
\->get('api/auth/me', function() {
    global \;
    \->getCurrentUser();
});

// ============================================================
// USER PROFILE ENDPOINTS (TUẦN 2)
// ============================================================

// GET /api/users/:id
\->get('api/users/:id', function(\) {
    global \;
    \ = \[0] ?? null;
    if (!\) {
        Response::json(Response::error('User ID không hợp lệ', HTTP_BAD_REQUEST), HTTP_BAD_REQUEST);
    }
    \->getProfile(\);
});

// PUT /api/users/:id
\->put('api/users/:id', function(\) {
    global \;
    \ = \[0] ?? null;
    if (!\) {
        Response::json(Response::error('User ID không hợp lệ', HTTP_BAD_REQUEST), HTTP_BAD_REQUEST);
    }
    \->updateProfile(\);
});

// PUT /api/users/:id/password
\->put('api/users/:id/password', function(\) {
    global \;
    \ = \[0] ?? null;
    if (!\) {
        Response::json(Response::error('User ID không hợp lệ', HTTP_BAD_REQUEST), HTTP_BAD_REQUEST);
    }
    \->changePassword(\);
});

// GET /api/users/pending
\->get('api/users/pending', function() {
    global \;
    \->getPendingStudents();
});

// PUT /api/users/:id/approve
\->put('api/users/:id/approve', function(\) {
    global \;
    \ = \[0] ?? null;
    if (!\) {
        Response::json(Response::error('User ID không hợp lệ', HTTP_BAD_REQUEST), HTTP_BAD_REQUEST);
    }
    \->approveUser(\);
});

// PUT /api/users/:id/reject
\->put('api/users/:id/reject', function(\) {
    global \;
    \ = \[0] ?? null;
    if (!\) {
        Response::json(Response::error('User ID không hợp lệ', HTTP_BAD_REQUEST), HTTP_BAD_REQUEST);
    }
    \->rejectUser(\);
});

// ============================================================
// CATEGORY ENDPOINTS (TUẦN 1)
// ============================================================

// GET /api/khoi-lop
\->get('api/khoi-lop', function() {
    \ = new KhoiLop();
    \ = \->getAll();
    Response::json(Response::success(\, 'Lấy danh sách khối lớp thành công'), HTTP_OK);
});

// GET /api/mon-hoc
\->get('api/mon-hoc', function() {
    \ = \['khoi_id'] ?? null;
    \ = new MonHoc();
    
    if (\) {
        \ = \->getByKhoi(\);
    } else {
        \ = \->getAll();
    }
    
    Response::json(Response::success(\, 'Lấy danh sách môn học thành công'), HTTP_OK);
});

// GET /api/chu-de
\->get('api/chu-de', function() {
    \ = \['mon_id'] ?? null;
    \ = new ChuDe();
    
    if (\) {
        \ = \->getByMon(\);
    } else {
        \ = \->getAll();
    }
    
    Response::json(Response::success(\, 'Lấy danh sách chủ đề thành công'), HTTP_OK);
});

// Dispatch request
\->dispatch();
?>
