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
$dbname = "employment_db";    

// Create connection
$conn3 = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn3->connect_error) {
    die("Connection failed: " . $conn3->connect_error);
}

// Set character set
$conn3->set_charset("utf8mb4");

/**
 * Function to safely close the database connection
 */
function closeEmploymentConnection() {
    global $conn3;
    if ($conn3) {
        $conn3->close();
    }
}

// Register shutdown function to ensure connection is closed
register_shutdown_function('closeEmploymentConnection');
?>
