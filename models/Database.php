<?php
/**
 * Base Database Class
 * 
 * Provides common database operations for all models
 */

class Database {
    protected $pdo;
    protected $stmt;
    
    public function __construct() {
        try {
            $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
            logMessage('Database connected successfully', 'INFO');
            
        } catch(PDOException $e) {
            $error = 'Database Connection Error: ' . $e->getMessage();
            logError($error);
            die($error);
        }
    }
    
    /**
     * Get PDO instance
     */
    public function getPdo() {
        return $this->pdo;
    }
    
    /**
     * Prepare and execute query
     */
    public function query($sql, $params = []) {
        try {
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute($params);
            return true;
        } catch(PDOException $e) {
            logError('Query Error: ' . $e->getMessage() . ' | SQL: ' . $sql);
            return false;
        }
    }
    
    /**
     * Fetch single row
     */
    public function fetch($sql, $params = []) {
        if ($this->query($sql, $params)) {
            return $this->stmt->fetch();
        }
        return null;
    }
    
    /**
     * Fetch all rows
     */
    public function fetchAll($sql, $params = []) {
        if ($this->query($sql, $params)) {
            return $this->stmt->fetchAll();
        }
        return [];
    }
    
    /**
     * Get row count
     */
    public function rowCount() {
        return $this->stmt ? $this->stmt->rowCount() : 0;
    }
    
    /**
     * Get last insert ID
     */
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
    
    /**
     * Begin transaction
     */
    public function beginTransaction() {
        return $this->pdo->beginTransaction();
    }
    
    /**
     * Commit transaction
     */
    public function commit() {
        return $this->pdo->commit();
    }
    
    /**
     * Rollback transaction
     */
    public function rollBack() {
        return $this->pdo->rollBack();
    }
    
    /**
     * Get statement for custom use
     */
    public function getStatement() {
        return $this->stmt;
    }
}
?>
