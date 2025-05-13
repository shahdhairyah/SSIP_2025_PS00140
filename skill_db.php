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
$dbname = "skill_db";    

// Create connection
$conn2 = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn2->connect_error) {
    die("Connection failed: " . $conn2->connect_error);
}

// Set character set
$conn2->set_charset("utf8mb4");

/**
 * Function to safely close the database connection
 */
function closeSkillConnection() {
    global $conn2;
    if ($conn2) {
        $conn2->close();
    }
}

// Register shutdown function to ensure connection is closed
register_shutdown_function('closeSkillConnection');
?>
