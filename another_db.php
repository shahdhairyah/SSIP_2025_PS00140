<?php
/**
 * Database conn1ection
 * 
 * This file establishes a conn1ection to the MySQL database.
 */

// Database configuration
error_reporting(E_ALL);
ini_set('display_errors', 1);
$host = "localhost";      
$username = "root";       
$password = "";           
$dbname = "labour_db";    

// Create connection
$conn1 = new mysqli($host, $username, $password, $dbname);

// Check conn1ection
if ($conn1->connect_error) {
    die("conn1ection failed: " . $conn1->connect_error);
}

// Set character set
$conn1->set_charset("utf8mb4");

/**
 * Function to safely close the database connection
 */
function closeLabourconnection() {
    global $conn1;
    if ($conn1) {
        $conn1->close();
    }
}

// Register shutdown function to ensure connection is closed
register_shutdown_function('closeLabourconnection');
?>
