<?php
/**
 * User Controller
 */

class UserController {
    
    private \;
    
    public function __construct() {
        \->userModel = new User();
    }
    
    /**
     * GET /api/users/:id
     */
    public function getProfile(\) {
        try {
            \ = \->userModel->getUserById(\);
            
            if (!\) {
                Response::json(
                    Response::error('Người dùng không tồn tại', HTTP_NOT_FOUND),
                    HTTP_NOT_FOUND
                );
                return;
            }
            
            Response::json(
                Response::success(\, 'Lấy thông tin thành công'),
                HTTP_OK
            );
            
        } catch(Exception \) {
            logError('Get Profile Error: ' . \->getMessage());
            Response::json(
                Response::error('Lỗi hệ thống', HTTP_INTERNAL_ERROR),
                HTTP_INTERNAL_ERROR
            );
        }
    }
    
    /**
     * PUT /api/users/:id
     */
    public function updateProfile(\) {
        try {
            \ = file_get_contents('php://input');
            \ = json_decode(\, true);
            
            \ = \->userModel->updateProfile(\, \);
            
            if (!\['success']) {
                Response::json(
                    Response::error(\['message'], HTTP_BAD_REQUEST),
                    HTTP_BAD_REQUEST
                );
                return;
            }
            
            \ = \->userModel->getUserById(\);
            
            Response::json(
                Response::success(\, \['message']),
                HTTP_OK
            );
            
        } catch(Exception \) {
            logError('Update Profile Error: ' . \->getMessage());
            Response::json(
                Response::error('Lỗi hệ thống', HTTP_INTERNAL_ERROR),
                HTTP_INTERNAL_ERROR
            );
        }
    }
    
    /**
     * PUT /api/users/:id/password
     */
    public function changePassword(\) {
        try {
            \ = file_get_contents('php://input');
            \ = json_decode(\, true);
            
            if (empty(\['old_password']) || empty(\['new_password'])) {
                Response::json(
                    Response::error('Vui lòng nhập mật khẩu cũ và mới', HTTP_BAD_REQUEST),
                    HTTP_BAD_REQUEST
                );
                return;
            }
            
            \ = \->userModel->changePassword(
                \,
                \['old_password'],
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
                Response::success(null, \['message']),
                HTTP_OK
            );
            
        } catch(Exception \) {
            logError('Change Password Error: ' . \->getMessage());
            Response::json(
                Response::error('Lỗi hệ thống', HTTP_INTERNAL_ERROR),
                HTTP_INTERNAL_ERROR
            );
        }
    }
    
    /**
     * GET /api/users/pending
     */
    public function getPendingStudents() {
        try {
            \ = \->userModel->getPendingStudents();
            
            Response::json(
                Response::success(\, 'Lấy danh sách thành công'),
                HTTP_OK
            );
            
        } catch(Exception \) {
            logError('Get Pending Students Error: ' . \->getMessage());
            Response::json(
                Response::error('Lỗi hệ thống', HTTP_INTERNAL_ERROR),
                HTTP_INTERNAL_ERROR
            );
        }
    }
    
    /**
     * PUT /api/users/:id/approve
     */
    public function approveUser(\) {
        try {
            \ = \->userModel->approveUser(\);
            
            if (!\['success']) {
                Response::json(
                    Response::error(\['message'], HTTP_BAD_REQUEST),
                    HTTP_BAD_REQUEST
                );
                return;
            }
            
            Response::json(
                Response::success(null, \['message']),
                HTTP_OK
            );
            
        } catch(Exception \) {
            logError('Approve User Error: ' . \->getMessage());
            Response::json(
                Response::error('Lỗi hệ thống', HTTP_INTERNAL_ERROR),
                HTTP_INTERNAL_ERROR
            );
        }
    }
    
    /**
     * PUT /api/users/:id/reject
     */
    public function rejectUser(\) {
        try {
            \ = \->userModel->rejectUser(\);
            
            if (!\['success']) {
                Response::json(
                    Response::error(\['message'], HTTP_BAD_REQUEST),
                    HTTP_BAD_REQUEST
                );
                return;
            }
            
            Response::json(
                Response::success(null, \['message']),
                HTTP_OK
            );
            
        } catch(Exception \) {
            logError('Reject User Error: ' . \->getMessage());
            Response::json(
                Response::error('Lỗi hệ th��ng', HTTP_INTERNAL_ERROR),
                HTTP_INTERNAL_ERROR
            );
        }
    }
}
?>
