<?php
/**
 * Auth Controller
 * 
 * Handles authentication logic: login, register, logout, reset password
 */

class AuthController {
    
    private \;
    
    public function __construct() {
        \->userModel = new User();
    }
    
    /**
     * POST /api/auth/login
     * Body: { username, password }
     * Response: { success, code, message, data: { user, token } }
     */
    public function login() {
        try {
            // Get request body
            \ = file_get_contents('php://input');
            \ = json_decode(\, true);
            
            // Validate input
            if (empty(\['username']) || empty(\['password'])) {
                return Response::json(
                    Response::error('Vui lòng nhập tên đăng nhập và mật khẩu', HTTP_BAD_REQUEST),
                    HTTP_BAD_REQUEST
                );
            }
            
            // Login
            \ = \->userModel->login(\['username'], \['password']);
            
            if (!\['success']) {
                return Response::json(
                    Response::error(\['message'], HTTP_UNAUTHORIZED),
                    HTTP_UNAUTHORIZED
                );
            }
            
            // Generate JWT token
            \ = \['user'];
            \ = JWT::generateToken(
                \['id'],
                \['username'],
                \['role'],
                \['email']
            );
            
            if (!\['success']) {
                return Response::json(
                    Response::error('Lỗi tạo token', HTTP_INTERNAL_ERROR),
                    HTTP_INTERNAL_ERROR
                );
            }
            
            // Return response
            return Response::json(
                Response::success(
                    [
                        'user' => \,
                        'token' => \['token']
                    ],
                    'Đăng nhập thành công',
                    HTTP_OK
                ),
                HTTP_OK
            );
            
        } catch(Exception \) {
            logError('Login Controller Error: ' . \->getMessage());
            return Response::json(
                Response::error('Lỗi hệ thống', HTTP_INTERNAL_ERROR),
                HTTP_INTERNAL_ERROR
            );
        }
    }
    
    /**
     * POST /api/auth/register
     * Body: { username, password, full_name, email, phone, cccd, date_of_birth, gender, role }
     * Response: { success, code, message, data: { user_id } }
     */
    public function register() {
        try {
            // Get request body
            \ = file_get_contents('php://input');
            \ = json_decode(\, true);
            
            // Register
            \ = \->userModel->register(\);
            
            if (!\['success']) {
                return Response::json(
                    Response::error(\['message'], HTTP_BAD_REQUEST),
                    HTTP_BAD_REQUEST
                );
            }
            
            // Return response
            return Response::json(
                Response::success(
                    ['user_id' => \['user_id']],
                    \['message'],
                    HTTP_CREATED
                ),
                HTTP_CREATED
            );
            
        } catch(Exception \) {
            logError('Register Controller Error: ' . \->getMessage());
            return Response::json(
                Response::error('Lỗi hệ thống', HTTP_INTERNAL_ERROR),
                HTTP_INTERNAL_ERROR
            );
        }
    }
    
    /**
     * POST /api/auth/reset-password
     * Body: { username, phone, cccd, new_password }
     * Response: { success, code, message }
     */
    public function resetPassword() {
        try {
            // Get request body
            \ = file_get_contents('php://input');
            \ = json_decode(\, true);
            
            // Validate input
            if (empty(\['username']) || empty(\['phone']) || empty(\['cccd']) || empty(\['new_password'])) {
                return Response::json(
                    Response::error('Vui lòng điền đầy đủ thông tin', HTTP_BAD_REQUEST),
                    HTTP_BAD_REQUEST
                );
            }
            
            // Reset password
            \ = \->userModel->resetPassword(
                \['username'],
                \['phone'],
                \['cccd'],
                \['new_password']
            );
            
            if (!\['success']) {
                return Response::json(
                    Response::error(\['message'], HTTP_BAD_REQUEST),
                    HTTP_BAD_REQUEST
                );
            }
            
            return Response::json(
                Response::success(null, \['message'], HTTP_OK),
                HTTP_OK
            );
            
        } catch(Exception \) {
            logError('Reset Password Controller Error: ' . \->getMessage());
            return Response::json(
                Response::error('Lỗi hệ thống', HTTP_INTERNAL_ERROR),
                HTTP_INTERNAL_ERROR
            );
        }
    }
    
    /**
     * POST /api/auth/logout
     * Body: {}
     * Response: { success, code, message }
     */
    public function logout() {
        try {
            // Clear session
            session_destroy();
            
            return Response::json(
                Response::success(null, 'Đăng xuất thành công', HTTP_OK),
                HTTP_OK
            );
            
        } catch(Exception \) {
            logError('Logout Controller Error: ' . \->getMessage());
            return Response::json(
                Response::error('Lỗi hệ thống', HTTP_INTERNAL_ERROR),
                HTTP_INTERNAL_ERROR
            );
        }
    }
    
    /**
     * GET /api/auth/me
     * Header: Authorization: Bearer <token>
     * Response: { success, code, message, data: { user } }
     */
    public function getCurrentUser() {
        try {
            // Get token from header
            \ = JWT::getTokenFromHeader();
            
            if (!token) {
                return Response::json(
                    Response::error('Token không tìm thấy', HTTP_UNAUTHORIZED),
                    HTTP_UNAUTHORIZED
                );
            }
            
            // Validate token
            \ = JWT::validateToken(\);
            
            if (!\['success']) {
                return Response::json(
                    Response::error(\['message'], HTTP_UNAUTHORIZED),
                    HTTP_UNAUTHORIZED
                );
            }
            
            // Get user
            \ = \['payload'];
            \ = new User();
            \ = \->getUserById(\['user_id']);
            
            if (!\) {
                return Response::json(
                    Response::error('Người dùng không tồn tại', HTTP_NOT_FOUND),
                    HTTP_NOT_FOUND
                );
            }
            
            return Response::json(
                Response::success(\, 'Lấy thông tin người dùng thành công', HTTP_OK),
                HTTP_OK
            );
            
        } catch(Exception \) {
            logError('Get Current User Error: ' . \->getMessage());
            return Response::json(
                Response::error('Lỗi hệ thống', HTTP_INTERNAL_ERROR),
                HTTP_INTERNAL_ERROR
            );
        }
    }
}
?>
