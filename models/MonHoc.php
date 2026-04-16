<?php
/**
 * MonHoc Model (Subjects)
 */

class MonHoc extends Database {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get all subjects
     */
    public function getAll() {
        \ = 'SELECT m.*, k.ten_khoi FROM mon_hoc m 
                 JOIN khoi_lop k ON m.khoi_id = k.id 
                 ORDER BY m.khoi_id, m.ten_mon';
        return \->fetchAll(\);
    }
    
    /**
     * Get by grade level
     */
    public function getByKhoi(\) {
        \ = 'SELECT * FROM mon_hoc WHERE khoi_id = ? ORDER BY ten_mon';
        return \->fetchAll(\, [\]);
    }
    
    /**
     * Get by ID
     */
    public function getById(\) {
        \ = 'SELECT * FROM mon_hoc WHERE id = ?';
        return \->fetch(\, [\]);
    }
    
    /**
     * Create new
     */
    public function create(\) {
        try {
            \ = 'INSERT INTO mon_hoc (ten_mon, khoi_id, mo_ta) VALUES (?, ?, ?)';
            \ = [\['ten_mon'] ?? '', \['khoi_id'] ?? 0, \['mo_ta'] ?? null];
            
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
