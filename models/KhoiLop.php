<?php
/**
 * KhoiLop Model (Grade Levels)
 */

class KhoiLop extends Database {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get all grade levels
     */
    public function getAll() {
        \ = 'SELECT * FROM khoi_lop ORDER BY id ASC';
        return \->fetchAll(\);
    }
    
    /**
     * Get by ID
     */
    public function getById(\) {
        \ = 'SELECT * FROM khoi_lop WHERE id = ?';
        return \->fetch(\, [\]);
    }
    
    /**
     * Create new
     */
    public function create(\) {
        try {
            \ = 'INSERT INTO khoi_lop (ten_khoi, mo_ta) VALUES (?, ?)';
            \ = [\['ten_khoi'] ?? '', \['mo_ta'] ?? null];
            
            if (\->query(\, \)) {
                return ['success' => true, 'id' => \->lastInsertId()];
            }
            return ['success' => false, 'message' => 'Create failed'];
        } catch(Exception \) {
            return ['success' => false, 'message' => \->getMessage()];
        }
    }
}
?>
