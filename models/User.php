<?php
/**
 * User Model
 * 
 * Handles user authentication and management
 */

class User extends Database {
    
    public function __construct(\) {
        parent::__construct(\);
        \->table = 'users';
    }
    
    /**
     * Get user by ID
     */
    public function getUserById(\) {
        \ = "SELECT * FROM {\->table} WHERE id = ? AND status = ?";
        return \->fetch(\, [\, STATUS_ACTIVE]);
    }
    
    /**
     * Get user by username
     */
    public function getUserByUsername(\) {
        \ = "SELECT * FROM {\->table} WHERE username = ?";
        return \->fetch(\, [\]);
    }
    
    /**
     * Login
     */
    public function login(\, \) {
        \ = \->getUserByUsername(\);
        
        if (!\) {
            return ['success' => false, 'message' => 'Username hoặc password sai'];
        }
        
        if (\['status'] !== STATUS_ACTIVE) {
            return ['success' => false, 'message' => 'Tài khoản chưa được duyệt hoặc bị khóa'];
        }
        
        if (!password_verify(\, \['password'])) {
            return ['success' => false, 'message' => 'Username hoặc password sai'];
        }
        
        return ['success' => true, 'user' => \];
    }
    
    /**
     * Register new user
     */
    public function register(\) {
        try {
            \->beginTransaction();
            
            // Check if user exists
            \ = \->getUserByUsername(\['username']);
            if (\) {
                return ['success' => false, 'message' => 'Username đã tồn tại'];
            }
            
            // Hash password
            \ = password_hash(\['password'], PASSWORD_BCRYPT);
            \ = \['role'] ?? ROLE_STUDENT;
            \ = (\ === ROLE_TEACHER) ? STATUS_ACTIVE : STATUS_PENDING;
            
            \ = "INSERT INTO {\->table} (username, password, full_name, email, phone, cccd, date_of_birth, gender, role, status, created_at) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
            
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
            
            if (\->query(\, \)) {
                \->commit();
                return ['success' => true, 'message' => 'Đăng ký thành công. Vui lòng chờ duyệt.'];
            }
            
            \->rollBack();
            return ['success' => false, 'message' => 'Lỗi tạo tài khoản'];
            
        } catch(Exception \) {
            \->rollBack();
            error_log('Register Error: ' . \->getMessage());
            return ['success' => false, 'message' => 'Lỗi hệ thống'];
        }
    }
}
?>