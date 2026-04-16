<?php
/**
 * API Response Helper
 * 
 * Formats API responses consistently
 */

class Response {
    
    public static function success(\ = null, \ = 'Success', \ = HTTP_OK) {
        return [
            'success' => true,
            'code' => \,
            'message' => \,
            'data' => \,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }
    
    public static function error(\ = 'Error', \ = HTTP_INTERNAL_ERROR, \ = null) {
        return [
            'success' => false,
            'code' => \,
            'message' => \,
            'data' => \,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }
    
    public static function json(\, \ = 200) {
        http_response_code(\);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(\, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
?>
