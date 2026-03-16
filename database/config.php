<?php
/**
 * Lion Equipment Company - Database Connection
 * Secure database connection with error handling
 */

class Database {
    private $host = 'localhost';
    private $dbname = 'lion_equipment_db';
    private $username = 'root';
    private $password = '';
    private $charset = 'utf8mb4';
    
    public $pdo;
    
    public function __construct() {
        $this->connect();
    }
    
    /**
     * Establish database connection
     */
    private function connect() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
            
        } catch (PDOException $e) {
            // Log error and display user-friendly message
            error_log("Database Connection Error: " . $e->getMessage());
            
            // In production, show generic error
            if (defined('ENVIRONMENT') && ENVIRONMENT === 'production') {
                die("Database connection failed. Please try again later.");
            } else {
                // In development, show detailed error
                die("Connection failed: " . $e->getMessage());
            }
        }
    }
    
    /**
     * Prepare and execute SQL statements
     */
    public function prepare($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get single record
     */
    public function fetch($sql, $params = []) {
        $stmt = $this->prepare($sql, $params);
        return $stmt->fetch();
    }
    
    /**
     * Get multiple records
     */
    public function fetchAll($sql, $params = []) {
        $stmt = $this->prepare($sql, $params);
        return $stmt->fetchAll();
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
    public function rollback() {
        return $this->pdo->rollBack();
    }
    
    /**
     * Close connection
     */
    public function close() {
        $this->pdo = null;
    }
}

// Create database instance
$db = new Database();
?>
