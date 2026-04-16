<?php
/**
 * JWT Token Helper
 */

class JWT {
    
    /**
     * Generate JWT token
     */
    public static function generateToken(\, \, \, \) {
        try {
            \ = [
                'alg' => 'HS256',
                'typ' => 'JWT'
            ];
            
            \ = [
                'user_id' => \,
                'username' => \,
                'role' => \,
                'email' => \,
                'iat' => time(),
                'exp' => time() + (60 * 60 * 24)
            ];
            
            \ = base64_encode(json_encode(\));
            \ = base64_encode(json_encode(\));
            
            \ = \ . '.' . \;
            \ = hash_hmac('sha256', \, JWT_SECRET, true);
            \ = base64_encode(\);
            
            \ = \ . '.' . \;
            
            return [
                'success' => true,
                'token' => \
            ];
            
        } catch(Exception \) {
            logError('JWT Generate Error: ' . \->getMessage());
            return [
                'success' => false,
                'message' => 'Lỗi tạo token'
            ];
        }
    }
    
    /**
     * Validate JWT token
     */
    public static function validateToken(\) {
        try {
            \ = explode('.', \);
            if (count(\) !== 3) {
                return [
                    'success' => false,
                    'message' => 'Token không hợp lệ'
                ];
            }
            
            list(\, \, \) = \;
            
            \ = \ . '.' . \;
            \ = base64_decode(\);
            \ = hash_hmac('sha256', \, JWT_SECRET, true);
            
            if (!hash_equals(\, \)) {
                return [
                    'success' => false,
                    'message' => 'Chữ ký token không hợp lệ'
                ];
            }
            
            \ = json_decode(base64_decode(\), true);
            
            if (!\) {
                return [
                    'success' => false,
                    'message' => 'Payload token không hợp lệ'
                ];
            }
            
            if (\['exp'] < time()) {
                return [
                    'success' => false,
                    'message' => 'Token đã hết hạn'
                ];
            }
            
            return [
                'success' => true,
                'payload' => \
            ];
            
        } catch(Exception \) {
            logError('JWT Validate Error: ' . \->getMessage());
            return [
                'success' => false,
                'message' => 'Lỗi xác thực token'
            ];
        }
    }
    
    /**
     * Get token from header
     */
    public static function getTokenFromHeader() {
        \ = getallheaders();
        
        if (!isset(\['Authorization'])) {
            return null;
        }
        
        \ = \['Authorization'];
        
        if (preg_match('/Bearer\s+(.+)/', \, \)) {
            return \[1];
        }
        
        return null;
    }
}
?>
