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
$dbname = "chatbot_db";    

// Create connection
$conn4 = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn4->connect_error) {
    die("Connection failed: " . $conn4->connect_error);
}

// Set character set
$conn2->set_charset("utf8mb4");

/**
 * Function to safely close the database connection
 */
function closeChatBotConnection() {
    global $conn4;
    if ($conn4) {
        $conn4->close();
    }
}

// Register shutdown function to ensure connection is closed
register_shutdown_function('closeChatBotConnection');
?>
