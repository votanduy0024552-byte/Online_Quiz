<?php
/**
 * User Controller
 * 
 * Handles user profile management, password change, user approval
 */

class UserController {
    
    private \;
    
    public function __construct() {
        \->userModel = new User();
    }
    
    /**
     * GET /api/users/:id
     * Get user profile by ID
     */
    public function getProfile(\) {
        try {
            \ = \->userModel->getUserById(\);
            
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
            logError('Get Profile Error: ' . \->getMessage());
            return Response::json(
                Response::error('Lỗi hệ thống', HTTP_INTERNAL_ERROR),
                HTTP_INTERNAL_ERROR
            );
        }
    }
    
    /**
     * PUT /api/users/:id
     * Update user profile (email, phone, gender, avatar)
     */
    public function updateProfile(\) {
        try {
            // Get request body
            \ = file_get_contents('php://input');
            \ = json_decode(\, true);
            
            // Update profile
            \ = \->userModel->updateProfile(\, \);
            
            if (!\['success']) {
                return Response::json(
                    Response::error(\['message'], HTTP_BAD_REQUEST),
                    HTTP_BAD_REQUEST
                );
            }
            
            // Get updated user
            \ = \->userModel->getUserById(\);
            
            return Response::json(
                Response::success(\, \['message'], HTTP_OK),
                HTTP_OK
            );
            
        } catch(Exception \) {
            logError('Update Profile Error: ' . \->getMessage());
            return Response::json(
                Response::error('Lỗi hệ thống', HTTP_INTERNAL_ERROR),
                HTTP_INTERNAL_ERROR
            );
        }
    }
    
    /**
     * PUT /api/users/:id/password
     * Change password (require old password)
     */
    public function changePassword(\) {
        try {
            // Get request body
            \ = file_get_contents('php://input');
            \ = json_decode(\, true);
            
            // Validate input
            if (empty(\['old_password']) || empty(\['new_password'])) {
                return Response::json(
                    Response::error('Vui lòng nhập mật khẩu cũ và mới', HTTP_BAD_REQUEST),
                    HTTP_BAD_REQUEST
                );
            }
            
            // Change password
            \ = \->userModel->changePassword(
                \,
                \['old_password'],
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
            logError('Change Password Error: ' . \->getMessage());
            return Response::json(
                Response::error('Lỗi hệ thống', HTTP_INTERNAL_ERROR),
                HTTP_INTERNAL_ERROR
            );
        }
    }
    
    /**
     * GET /api/users/pending
     * Get pending students (for approval)
     */
    public function getPendingStudents() {
        try {
            \ = \->userModel->getPendingStudents();
            
            return Response::json(
                Response::success(\, 'Lấy danh sách học sinh chờ duyệt thành công', HTTP_OK),
                HTTP_OK
            );
            
        } catch(Exception \) {
            logError('Get Pending Students Error: ' . \->getMessage());
            return Response::json(
                Response::error('Lỗi hệ thống', HTTP_INTERNAL_ERROR),
                HTTP_INTERNAL_ERROR
            );
        }
    }
    
    /**
     * PUT /api/users/:id/approve
     * Approve user (set status = Active)
     */
    public function approveUser(\) {
        try {
            \ = \->userModel->approveUser(\);
            
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
            logError('Approve User Error: ' . \->getMessage());
            return Response::json(
                Response::error('Lỗi hệ thống', HTTP_INTERNAL_ERROR),
                HTTP_INTERNAL_ERROR
            );
        }
    }
    
    /**
     * PUT /api/users/:id/reject
     * Reject user (set status = Inactive)
     */
    public function rejectUser(\) {
        try {
            \ = \->userModel->rejectUser(\);
            
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
            logError('Reject User Error: ' . \->getMessage());
            return Response::json(
                Response::error('Lỗi hệ thống', HTTP_INTERNAL_ERROR),
                HTTP_INTERNAL_ERROR
            );
        }
    }
}
?>
