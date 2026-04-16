<?php
/**
 * Base Database Class
 * 
 * Provides common database operations for all models
 */

class Database {
    protected \;
    protected \;
    protected \;
    
    public function __construct(\) {
        \->pdo = \;
    }
    
    /**
     * Prepare and execute query
     */
    public function query(\, \ = []) {
        try {
            \->stmt = \->pdo->prepare(\);
            return \->stmt->execute(\);
        } catch(PDOException \) {
            error_log('Query Error: ' . \->getMessage());
            return false;
        }
    }
    
    /**
     * Fetch single row
     */
    public function fetch(\, \ = []) {
        if (\->query(\, \)) {
            return \->stmt->fetch();
        }
        return null;
    }
    
    /**
     * Fetch all rows
     */
    public function fetchAll(\, \ = []) {
        if (\->query(\, \)) {
            return \->stmt->fetchAll();
        }
        return [];
    }
    
    /**
     * Get last insert ID
     */
    public function lastInsertId() {
        return \->pdo->lastInsertId();
    }
    
    /**
     * Begin transaction
     */
    public function beginTransaction() {
        return \->pdo->beginTransaction();
    }
    
    /**
     * Commit transaction
     */
    public function commit() {
        return \->pdo->commit();
    }
    
    /**
     * Rollback transaction
     */
    public function rollBack() {
        return \->pdo->rollBack();
    }
}
?>
