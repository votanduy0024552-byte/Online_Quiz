<?php
/**
 * Auth Controller
 */

class AuthController {
    
    private \;
    
    public function __construct() {
        \->userModel = new User();
    }
    
    /**
     * POST /api/auth/login
     */
    public function login() {
        try {
            \ = file_get_contents('php://input');
            \ = json_decode(\, true);
            
            if (empty(\['username']) || empty(\['password'])) {
                Response::json(
                    Response::error('Vui lòng nhập tên đăng nhập và mật khẩu', HTTP_BAD_REQUEST),
                    HTTP_BAD_REQUEST
                );
                return;
            }
            
            \ = \->userModel->login(\['username'], \['password']);
            
            if (!\['success']) {
                Response::json(
                    Response::error(\['message'], HTTP_UNAUTHORIZED),
                    HTTP_UNAUTHORIZED
                );
                return;
            }
            
            \ = \['user'];
            \ = JWT::generateToken(
                \['id'],
                \['username'],
                \['role'],
                \['email']
            );
            
            if (!\['success']) {
                Response::json(
                    Response::error('Lỗi tạo token', HTTP_INTERNAL_ERROR),
                    HTTP_INTERNAL_ERROR
                );
                return;
            }
            
            Response::json(
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
            logError('Login Error: ' . \->getMessage());
            Response::json(
                Response::error('Lỗi hệ thống', HTTP_INTERNAL_ERROR),
                HTTP_INTERNAL_ERROR
            );
        }
    }
    
    /**
     * POST /api/auth/register
     */
    public function register() {
        try {
            \ = file_get_contents('php://input');
            \ = json_decode(\, true);
            
            \ = \->userModel->register(\);
            
            if (!\['success']) {
                Response::json(
                    Response::error(\['message'], HTTP_BAD_REQUEST),
                    HTTP_BAD_REQUEST
                );
                return;
            }
            
            Response::json(
                Response::success(
                    ['user_id' => \['user_id']],
                    \['message'],
                    HTTP_CREATED
                ),
                HTTP_CREATED
            );
            
        } catch(Exception \) {
            logError('Register Error: ' . \->getMessage());
            Response::json(
                Response::error('Lỗi hệ thống', HTTP_INTERNAL_ERROR),
                HTTP_INTERNAL_ERROR
            );
        }
    }
    
    /**
     * POST /api/auth/reset-password
     */
    public function resetPassword() {
        try {
            \ = file_get_contents('php://input');
            \ = json_decode(\, true);
            
            if (empty(\['username']) || empty(\['phone']) || empty(\['cccd']) || empty(\['new_password'])) {
                Response::json(
                    Response::error('Vui lòng điền đầy đủ thông tin', HTTP_BAD_REQUEST),
                    HTTP_BAD_REQUEST
                );
                return;
            }
            
            \ = \->userModel->resetPassword(
                \['username'],
                \['phone'],
                \['cccd'],
                \['new_password']
            );
            
            if (!\['success']) {
                Response::json(
                    Response::error(\['message'], HTTP_BAD_REQUEST),
                    HTTP_BAD_REQUEST
                );
                return;
            }
            
            Response::json(
                Response::success(null, \['message'], HTTP_OK),
                HTTP_OK
            );
            
        } catch(Exception \) {
            logError('Reset Password Error: ' . \->getMessage());
            Response::json(
                Response::error('Lỗi hệ thống', HTTP_INTERNAL_ERROR),
                HTTP_INTERNAL_ERROR
            );
        }
    }
    
    /**
     * POST /api/auth/logout
     */
    public function logout() {
        try {
            session_destroy();
            
            Response::json(
                Response::success(null, 'Đăng xuất thành công', HTTP_OK),
                HTTP_OK
            );
            
        } catch(Exception \) {
            logError('Logout Error: ' . \->getMessage());
            Response::json(
                Response::error('Lỗi hệ thống', HTTP_INTERNAL_ERROR),
                HTTP_INTERNAL_ERROR
            );
        }
    }
    
    /**
     * GET /api/auth/me
     */
    public function getCurrentUser() {
        try {
            \ = JWT::getTokenFromHeader();
            
            if (!token) {
                Response::json(
                    Response::error('Token không tìm thấy', HTTP_UNAUTHORIZED),
                    HTTP_UNAUTHORIZED
                );
                return;
            }
            
            \ = JWT::validateToken(\);
            
            if (!\['success']) {
                Response::json(
                    Response::error(\['message'], HTTP_UNAUTHORIZED),
                    HTTP_UNAUTHORIZED
                );
                return;
            }
            
            \ = \['payload'];
            \ = new User();
            \ = \->getUserById(\['user_id']);
            
            if (!\) {
                Response::json(
                    Response::error('Người dùng không tồn tại', HTTP_NOT_FOUND),
                    HTTP_NOT_FOUND
                );
                return;
            }
            
            Response::json(
                Response::success(\, 'Lấy thông tin người dùng thành công', HTTP_OK),
                HTTP_OK
            );
            
        } catch(Exception \) {
            logError('Get Current User Error: ' . \->getMessage());
            Response::json(
                Response::error('Lỗi hệ thống', HTTP_INTERNAL_ERROR),
                HTTP_INTERNAL_ERROR
            );
        }
    }
}
?>
