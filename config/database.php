<?php
/**
 * Database Configuration
 * Smart Laundry Pickup & Delivery System
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'door2dry');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Database connection class
class Database {
    private $host = DB_HOST;
    private $db_name = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;
    private $charset = DB_CHARSET;
    private $pdo;
    
    public function connect() {
        $this->pdo = null;
        
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
        } catch(PDOException $e) {
            // Log the error and throw a generic message to avoid exposing database details
            error_log("Database connection error: " . $e->getMessage());
            throw new PDOException("Unable to connect to database. Please try again later.");
        }
        
        return $this->pdo;
    }
    
    public function getConnection() {
        return $this->connect();
    }
}

// Function to get database connection
function getDB() {
    try {
        $database = new Database();
        $connection = $database->getConnection();
        
        if (!$connection) {
            throw new PDOException("Failed to establish database connection");
        }
        
        return $connection;
    } catch (PDOException $e) {
        error_log("Database connection error in getDB(): " . $e->getMessage());
        throw $e;
    }
}
?> 