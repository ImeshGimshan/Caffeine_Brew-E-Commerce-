<?php
/**
 * Database Configuration
 * Handles database connection and operations
 */

class Database {
    private static $instance = null;
    private $connection;
    
    // Database credentials
    private $host = '127.0.0.1';  // Using 127.0.0.1 instead of localhost for XAMPP
    private $username = 'root';
    private $password = '';
    private $database = 'caffienebrewdb';
    
    /**
     * Private constructor to prevent direct instantiation
     */
    private function __construct() {
        try {
            $this->connection = new mysqli(
                $this->host,
                $this->username,
                $this->password,
                $this->database
            );
            
            if ($this->connection->connect_error) {
                throw new Exception("Connection failed: " . $this->connection->connect_error);
            }
            
            // Set charset to utf8mb4 for better character support
            $this->connection->set_charset("utf8mb4");
            
        } catch (Exception $e) {
            die("Database Error: " . $e->getMessage());
        }
    }
    
    /**
     * Get singleton instance of Database
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Get database connection
     */
    public function getConnection() {
        return $this->connection;
    }
    
    /**
     * Prepare statement
     */
    public function prepare($query) {
        return $this->connection->prepare($query);
    }
    
    /**
     * Escape string to prevent SQL injection
     */
    public function escape($value) {
        return $this->connection->real_escape_string($value);
    }
    
    /**
     * Close connection
     */
    public function close() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
    
    /**
     * Prevent cloning of singleton
     */
    private function __clone() {}
    
    /**
     * Prevent unserialization of singleton
     */
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
}

// Create global database connection function
function getDB() {
    return Database::getInstance()->getConnection();
}
