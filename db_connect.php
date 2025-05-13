<?php
/**
 * Database Connection
 * 
 * This file establishes a connection to the MySQL database.
 */

// Database configuration
error_reporting(E_ALL);
ini_set('display_errors', 1);
$host = "localhost";      
$username = "root";       
$password = "";           
$dbname = "departments_db";    

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character set
$conn->set_charset("utf8mb4");

/**
 * Function to safely close the database connection
 */
function closeConnection() {
    global $conn;
    if ($conn) {
        $conn->close();
    }
}

// Register shutdown function to ensure connection is closed
register_shutdown_function('closeConnection');
?>
