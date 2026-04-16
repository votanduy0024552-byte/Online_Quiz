<?php
/**
 * LopHoc Model (Classes)
 */

class LopHoc extends Database {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get all classes
     */
    public function getAll() {
        \ = 'SELECT l.*, k.ten_khoi, u.full_name FROM lop_hoc l
                 JOIN khoi_lop k ON l.khoi_id = k.id
                 LEFT JOIN users u ON l.giao_vien_chu_nhiem_id = u.id
                 ORDER BY l.khoi_id, l.ten_lop';
        return \->fetchAll(\);
    }
    
    /**
     * Get by ID
     */
    public function getById(\) {
        \ = 'SELECT l.*, k.ten_khoi, u.full_name FROM lop_hoc l
                 JOIN khoi_lop k ON l.khoi_id = k.id
                 LEFT JOIN users u ON l.giao_vien_chu_nhiem_id = u.id
                 WHERE l.id = ?';
        return \->fetch(\, [\]);
    }
    
    /**
     * Get students in class
     */
    public function getStudents(\) {
        \ = 'SELECT u.* FROM class_students cs
                 JOIN users u ON cs.student_id = u.id
                 WHERE cs.class_id = ? AND u.role = ?
                 ORDER BY u.full_name';
        return \->fetchAll(\, [\, ROLE_STUDENT]);
    }
    
    /**
     * Create new
     */
    public function create(\) {
        try {
            \ = 'INSERT INTO lop_hoc (ten_lop, khoi_id, giao_vien_chu_nhiem_id, nam_hoc, mo_ta) 
                     VALUES (?, ?, ?, ?, ?)';
            \ = [
                \['ten_lop'] ?? '',
                \['khoi_id'] ?? 0,
                \['giao_vien_chu_nhiem_id'] ?? null,
                \['nam_hoc'] ?? date('Y') . '-' . (date('Y') + 1),
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
