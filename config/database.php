<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');              // Leave empty if no password
define('DB_NAME', 'todo_list');
define('BASE_URL', 'http://localhost/adhilproject-2/public/');

// Create connection
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        throw new Exception('Connection failed: ' . $conn->connect_error);
    }
    
    // Set charset to utf8
    $conn->set_charset('utf8mb4');
} catch (Exception $e) {
    die('Database Error: ' . $e->getMessage());
}
?>