<?php
// Initialize session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Include database connection
require_once 'db_connect.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Initialize variables
$email = $password = $department = "";
$emailErr = $passwordErr = $departmentErr  = $loginErr = "";
$success = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email
    if (empty($_POST["login-email"])) {
        $emailErr = "Email is required";
    } else {
        $email = filter_var($_POST["login-email"], FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Please enter a valid email address";
        }
    }
    
    // Validate department
    if (empty($_POST["login-department"])) {
        $departmentErr = "Please select a department";
    } else {
        $department = $_POST["login-department"];
    }
    
    // Validate password
    if (empty($_POST["login-password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = $_POST["login-password"];
    }
    // If no errors, proceed with login
    if (empty($emailErr) && empty($passwordErr) && empty($departmentErr)) {
        // Sanitize inputs to prevent SQL injection
        $email = $conn->real_escape_string($email);
        $department = $conn->real_escape_string($department);
        
        // Query the database
        $sql = "SELECT * FROM auth_users WHERE email = ? AND department = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $department);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_fullname'] = $user['fullname'];
                $_SESSION['user_department'] = $user['department'];
                
                // Set success message
                $success = "Login successful! Redirecting...";
                
                // Redirect to dashboard or home page after a short delay
                echo "<script>
                    setTimeout(function() {
                        window.location.href = 'dashboard.html';
                    }, 2000);
                </script>";
                echo json_encode(["name" => $_SESSION['user_fullname']]);
            } else {
                $loginErr = "Invalid email, department, or password";
            }
        } else {
            $loginErr = "Invalid email, department, or password";
            echo json_encode(["name" => "Guest"]);
        }
        
        $stmt->close();
    }
}