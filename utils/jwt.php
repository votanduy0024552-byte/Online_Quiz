<?php
/**
 * JWT Token Helper
 * 
 * Handles JWT token generation and validation
 */

class JWT {
    
    /**
     * Generate JWT token
     * Payload: user_id, username, role, email, iat, exp
     */
    public static function generateToken(\, \, \, \) {
        try {
            // Token header
            \ = [
                'alg' => 'HS256',
                'typ' => 'JWT'
            ];
            
            // Token payload
            \ = [
                'user_id' => \,
                'username' => \,
                'role' => \,
                'email' => \,
                'iat' => time(),
                'exp' => time() + (60 * 60 * 24) // 24 hours
            ];
            
            // Encode header and payload
            \ = base64_encode(json_encode(\));
            \ = base64_encode(json_encode(\));
            
            // Create signature
            \ = \ . '.' . \;
            \ = hash_hmac('sha256', \, JWT_SECRET, true);
            \ = base64_encode(\);
            
            // Create token
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
     * Returns: ['success' => bool, 'payload' => array, 'message' => string]
     */
    public static function validateToken(\) {
        try {
            // Check token format
            \ = explode('.', \);
            if (count(\) !== 3) {
                return [
                    'success' => false,
                    'message' => 'Token không hợp lệ'
                ];
            }
            
            list(\, \, \) = \;
            
            // Verify signature
            \ = \ . '.' . \;
            \ = base64_decode(\);
            \ = hash_hmac('sha256', \, JWT_SECRET, true);
            
            if (!hash_equals(\, \)) {
                return [
                    'success' => false,
                    'message' => 'Chữ ký token không hợp lệ'
                ];
            }
            
            // Decode payload
            \ = json_decode(base64_decode(\), true);
            
            if (!\) {
                return [
                    'success' => false,
                    'message' => 'Payload token không hợp lệ'
                ];
            }
            
            // Check expiration
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
     * Authorization: Bearer <token>
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
