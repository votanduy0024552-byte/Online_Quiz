<?php
/**
 * ChuDe Model (Topics/Chapters)
 */

class ChuDe extends Database {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get all topics
     */
    public function getAll() {
        \ = 'SELECT c.*, m.ten_mon, k.ten_khoi FROM chu_de c
                 JOIN mon_hoc m ON c.mon_id = m.id
                 JOIN khoi_lop k ON c.khoi_id = k.id
                 ORDER BY c.khoi_id, c.mon_id, c.ten_chu_de';
        return \->fetchAll(\);
    }
    
    /**
     * Get by subject
     */
    public function getByMon(\) {
        \ = 'SELECT * FROM chu_de WHERE mon_id = ? ORDER BY ten_chu_de';
        return \->fetchAll(\, [\]);
    }
    
    /**
     * Get by subject and grade
     */
    public function getByMonKhoi(\, \) {
        \ = 'SELECT * FROM chu_de WHERE mon_id = ? AND khoi_id = ? ORDER BY ten_chu_de';
        return \->fetchAll(\, [\, \]);
    }
    
    /**
     * Get by ID
     */
    public function getById(\) {
        \ = 'SELECT * FROM chu_de WHERE id = ?';
        return \->fetch(\, [\]);
    }
    
    /**
     * Create new
     */
    public function create(\) {
        try {
            \ = 'INSERT INTO chu_de (ten_chu_de, mon_id, khoi_id, mo_ta) VALUES (?, ?, ?, ?)';
            \ = [
                \['ten_chu_de'] ?? '',
                \['mon_id'] ?? 0,
                \['khoi_id'] ?? 0,
                \['mo_ta'] ?? null
            ];
            
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
