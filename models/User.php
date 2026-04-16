<?php
/**
 * User Model
 * 
 * Handles user authentication, registration, and profile management
 */

class User extends Database {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get user by ID
     */
    public function getUserById(\) {
        \ = 'SELECT id, username, full_name, email, phone, cccd, avatar_url, date_of_birth, gender, role, status, created_at, updated_at 
                 FROM users WHERE id = ?';
        return \->fetch(\, [\]);
    }
    
    /**
     * Get user by username
     */
    public function getUserByUsername(\) {
        \ = 'SELECT * FROM users WHERE username = ?';
        return \->fetch(\, [\]);
    }
    
    /**
     * Get user by email
     */
    public function getUserByEmail(\) {
        \ = 'SELECT * FROM users WHERE email = ?';
        return \->fetch(\, [\]);
    }
    
    /**
     * Login - Validate username and password
     * Returns: ['success' => bool, 'user' => array, 'message' => string]
     */
    public function login(\, \) {
        try {
            // Check if user exists
            \ = \->getUserByUsername(\);
            
            if (!\) {
                return [
                    'success' => false,
                    'message' => 'Tên đăng nhập hoặc mật khẩu không chính xác'
                ];
            }
            
            // Check if account is active
            if (\['status'] !== STATUS_ACTIVE) {
                return [
                    'success' => false,
                    'message' => 'Tài khoản chưa được duyệt hoặc đã bị khóa'
                ];
            }
            
            // Verify password
            if (!password_verify(\, \['password'])) {
                return [
                    'success' => false,
                    'message' => 'Tên đăng nhập hoặc mật khẩu không chính xác'
                ];
            }
            
            // Return user without password
            unset(\['password']);
            return [
                'success' => true,
                'user' => \,
                'message' => 'Đăng nhập thành công'
            ];
            
        } catch(Exception \) {
            logError('Login Error: ' . \->getMessage());
            return [
                'success' => false,
                'message' => 'Lỗi hệ thống'
            ];
        }
    }
    
    /**
     * Register - Create new user account
     */
    public function register(\) {
        try {
            // Validate required fields
            if (empty(\['username']) || empty(\['password']) || empty(\['full_name']) || empty(\['email'])) {
                return [
                    'success' => false,
                    'message' => 'Vui lòng điền đầy đủ thông tin'
                ];
            }
            
            // Check if username exists
            \ = \->getUserByUsername(\['username']);
            if (\) {
                return [
                    'success' => false,
                    'message' => 'Tên đăng nhập đã tồn tại'
                ];
            }
            
            // Check if email exists
            \ = \->getUserByEmail(\['email']);
            if (\) {
                return [
                    'success' => false,
                    'message' => 'Email đã được sử dụng'
                ];
            }
            
            // Start transaction
            \->beginTransaction();
            
            try {
                // Determine role and status
                \ = \['role'] ?? ROLE_STUDENT;
                \ = (\ === ROLE_TEACHER) ? STATUS_ACTIVE : STATUS_PENDING;
                
                // Hash password
                \ = password_hash(\['password'], PASSWORD_HASH_ALGO);
                
                // Insert user
                \ = 'INSERT INTO users (username, password, full_name, email, phone, cccd, date_of_birth, gender, role, status) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
                
                \ = [
                    \['username'],
                    \,
                    \['full_name'],
                    \['email'],
                    \['phone'] ?? null,
                    \['cccd'] ?? null,
                    \['date_of_birth'] ?? null,
                    \['gender'] ?? null,
                    \,
                    \
                ];
                
                if (!\->query(\, \)) {
                    throw new Exception('Không thể tạo tài khoản');
                }
                
                \ = \->lastInsertId();
                
                \->commit();
                
                \ = (\ === STATUS_PENDING) 
                    ? 'Đăng ký thành công. Vui lòng chờ duyệt từ giáo viên.' 
                    : 'Đăng ký thành công';
                
                return [
                    'success' => true,
                    'user_id' => \,
                    'message' => \
                ];
                
            } catch(Exception \) {
                \->rollBack();
                throw \;
            }
            
        } catch(Exception \) {
            logError('Register Error: ' . \->getMessage());
            return [
                'success' => false,
                'message' => 'Lỗi hệ thống'
            ];
        }
    }
    
    /**
     * Reset Password - 3-layer authentication
     */
    public function resetPassword(\, \, \, \) {
        try {
            // Get user by username
            \ = \->getUserByUsername(\);
            
            if (!\) {
                return [
                    'success' => false,
                    'message' => 'Tài khoản không tồn tại'
                ];
            }
            
            // 3-layer authentication: username + phone + cccd
            if (\['phone'] !== \ || \['cccd'] !== \) {
                return [
                    'success' => false,
                    'message' => 'Thông tin xác thực không chính xác'
                ];
            }
            
            // Hash new password
            \ = password_hash(\, PASSWORD_HASH_ALGO);
            
            // Update password
            \ = 'UPDATE users SET password = ? WHERE id = ?';
            
            if (\->query(\, [\, \['id']])) {
                return [
                    'success' => true,
                    'message' => 'Đổi mật khẩu thành công'
                ];
            }
            
            return [
                'success' => false,
                'message' => 'Lỗi khi cập nhật mật khẩu'
            ];
            
        } catch(Exception \) {
            logError('Reset Password Error: ' . \->getMessage());
            return [
                'success' => false,
                'message' => 'Lỗi hệ thống'
            ];
        }
    }
    
    /**
     * Update Profile
     */
    public function updateProfile(\, \) {
        try {
            \ = [];
            \ = [];
            
            if (!empty(\['email'])) {
                \[] = 'email = ?';
                \[] = \['email'];
            }
            
            if (!empty(\['phone'])) {
                \[] = 'phone = ?';
                \[] = \['phone'];
            }
            
            if (!empty(\['gender'])) {
                \[] = 'gender = ?';
                \[] = \['gender'];
            }
            
            if (!empty(\['avatar_url'])) {
                \[] = 'avatar_url = ?';
                \[] = \['avatar_url'];
            }
            
            if (empty(\)) {
                return [
                    'success' => false,
                    'message' => 'Không có dữ liệu để cập nhật'
                ];
            }
            
            \[] = \;
            \ = 'UPDATE users SET ' . implode(', ', \) . ' WHERE id = ?';
            
            if (\->query(\, \)) {
                return [
                    'success' => true,
                    'message' => 'Cập nhật hồ sơ thành công'
                ];
            }
            
            return [
                'success' => false,
                'message' => 'Lỗi cập nhật hồ sơ'
            ];
            
        } catch(Exception \) {
            logError('Update Profile Error: ' . \->getMessage());
            return [
                'success' => false,
                'message' => 'Lỗi hệ thống'
            ];
        }
    }
    
    /**
     * Change Password
     */
    public function changePassword(\, \, \) {
        try {
            \ = \->getUserById(\);
            
            if (!\) {
                return [
                    'success' => false,
                    'message' => 'Tài khoản không tồn tại'
                ];
            }
            
            // Get full user record with password
            \ = 'SELECT password FROM users WHERE id = ?';
            \ = \->fetch(\, [\]);
            
            // Verify old password
            if (!password_verify(\, \['password'])) {
                return [
                    'success' => false,
                    'message' => 'Mật khẩu cũ không chính xác'
                ];
            }
            
            // Hash new password
            \ = password_hash(\, PASSWORD_HASH_ALGO);
            
            // Update password
            \ = 'UPDATE users SET password = ? WHERE id = ?';
            
            if (\->query(\, [\, \])) {
                return [
                    'success' => true,
                    'message' => 'Đổi mật khẩu thành công'
                ];
            }
            
            return [
                'success' => false,
                'message' => 'Lỗi khi đổi mật khẩu'
            ];
            
        } catch(Exception \) {
            logError('Change Password Error: ' . \->getMessage());
            return [
                'success' => false,
                'message' => 'Lỗi hệ thống'
            ];
        }
    }
    
    /**
     * Get pending students
     */
    public function getPendingStudents() {
        \ = 'SELECT id, username, full_name, email, phone, cccd, role, status, created_at 
                 FROM users 
                 WHERE role = ? AND status = ? 
                 ORDER BY created_at DESC';
        return \->fetchAll(\, [ROLE_STUDENT, STATUS_PENDING]);
    }
    
    /**
     * Approve user
     */
    public function approveUser(\) {
        try {
            \ = 'UPDATE users SET status = ? WHERE id = ?';
            
            if (\->query(\, [STATUS_ACTIVE, \])) {
                return [
                    'success' => true,
                    'message' => 'Duyệt tài khoản thành công'
                ];
            }
            
            return [
                'success' => false,
                'message' => 'Lỗi duyệt tài khoản'
            ];
            
        } catch(Exception \) {
            logError('Approve User Error: ' . \->getMessage());
            return [
                'success' => false,
                'message' => 'Lỗi hệ thống'
            ];
        }
    }
    
    /**
     * Reject user
     */
    public function rejectUser(\) {
        try {
            \ = 'UPDATE users SET status = ? WHERE id = ?';
            
            if (\->query(\, [STATUS_INACTIVE, \])) {
                return [
                    'success' => true,
                    'message' => 'Từ chối tài khoản thành công'
                ];
            }
            
            return [
                'success' => false,
                'message' => 'Lỗi từ chối tài khoản'
            ];
            
        } catch(Exception \) {
            logError('Reject User Error: ' . \->getMessage());
            return [
                'success' => false,
                'message' => 'Lỗi hệ thống'
            ];
        }
    }
}
?>
