<?php
/**
 * Base Database Class
 * 
 * Provides common database operations for all models
 */

class Database {
    protected \;
    protected \;
    
    public function __construct() {
        try {
            \ = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
            
            \ = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            \->pdo = new PDO(\, DB_USER, DB_PASS, \);
            logMessage('Database connected successfully', 'INFO');
            
        } catch(PDOException \) {
            \Cannot find path 'C:\Users\PC\OneDrive - Hochiminh City University of Education\Documents\Online_Quiz\database\schema.sql' because it does not exist. A parameter cannot be found that matches parameter name 'Chord'. A parameter cannot be found that matches parameter name 'Chord'. A parameter cannot be found that matches parameter name 'Chord'. A parameter cannot be found that matches parameter name 'Chord'. = 'Database Connection Error: ' . \->getMessage();
            logError(\Cannot find path 'C:\Users\PC\OneDrive - Hochiminh City University of Education\Documents\Online_Quiz\database\schema.sql' because it does not exist. A parameter cannot be found that matches parameter name 'Chord'. A parameter cannot be found that matches parameter name 'Chord'. A parameter cannot be found that matches parameter name 'Chord'. A parameter cannot be found that matches parameter name 'Chord'.);
            die(\Cannot find path 'C:\Users\PC\OneDrive - Hochiminh City University of Education\Documents\Online_Quiz\database\schema.sql' because it does not exist. A parameter cannot be found that matches parameter name 'Chord'. A parameter cannot be found that matches parameter name 'Chord'. A parameter cannot be found that matches parameter name 'Chord'. A parameter cannot be found that matches parameter name 'Chord'.);
        }
    }
    
    /**
     * Get PDO instance
     */
    public function getPdo() {
        return \->pdo;
    }
    
    /**
     * Prepare and execute query
     */
    public function query(\, \ = []) {
        try {
            \->stmt = \->pdo->prepare(\);
            \->stmt->execute(\);
            return true;
        } catch(PDOException \) {
            logError('Query Error: ' . \->getMessage() . ' | SQL: ' . \);
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
     * Get row count
     */
    public function rowCount() {
        return \->stmt ? \->stmt->rowCount() : 0;
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
    
    /**
     * Get statement for custom use
     */
    public function getStatement() {
        return \->stmt;
    }
}
?>
