<?php
/**
 * Database connection
 * 
 * This file establishes a connection to the MySQL database.
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";      
$username = "root";       
$password = "";           
$dbname = "labour_db";    

// Create connection
$conn1 = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn1->connect_error) {
    die("Connection failed: " . $conn1->connect_error);
}

// Set character set
$conn1->set_charset("utf8mb4");

/**
 * Function to safely close the database connection
 */
function closeLabourConnection() {
    global $conn1;
    if ($conn1) {
        $conn1->close();
    }
}

// Register shutdown function to ensure connection is closed
register_shutdown_function('closeLabourConnection');
?>
