<?php
session_start();
require_once 'db_connect.php';
require 'labour_db.php';
require 'employment_db.php';
require 'skill_db.php';
require 'chatbot_db.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST["fullname"] ?? '';
    $email = $_POST["email"] ?? '';
    $phone = $_POST["phone"] ?? '';
    $password = $_POST["password"] ?? '';
    $temp_pass = $_POST["password"] ?? '';
    $confirmpassword = $_POST["confirmpassword"] ?? '';
    $department = $_POST["department"] ?? '';
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert into auth_users
    $stmt = $conn->prepare("INSERT INTO auth_users (fullname, email, phone, password, temp_pass, department) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $fullname, $email, $phone, $hashedPassword, $temp_pass, $department);

    if (!$stmt->execute()) {
        die("Database Insert Error (auth_users): " . $stmt->error);
    }

    // Extract first name
    $fname = $fullname;
    $username = $fullname;
    $password = $temp_pass;
    $user_type = $department;
    // Insert into f_name
    $stmt1 = $conn1->prepare("INSERT INTO f_name (fname) VALUES (?)");
    $stmt1->bind_param("s", $fname);

    if (!$stmt1->execute()) {
        die("Database Insert Error (f_name): " . $stmt1->error);
    }
    $stmt2 = $conn2->prepare("INSERT INTO f_name (fname) VALUES (?)");
    $stmt2->bind_param("s", $fname);

    if (!$stmt2->execute()) {
        die("Database Insert Error (f_name): " . $stmt2->error);
    }
    $stmt3 = $conn3->prepare("INSERT INTO f_name (fname) VALUES (?)");
    $stmt3->bind_param("s", $fname);

    if (!$stmt3->execute()) {
        die("Database Insert Error (f_name): " . $stmt3->error);
    }
     // Check for the latest user in the same department
     $stmtCheck = $conn4->prepare("SELECT fullname FROM users WHERE fullname LIKE ? ORDER BY id DESC LIMIT 1");
     $searchPattern = "$deptPrefix User%";
     $stmtCheck->bind_param("s", $searchPattern);
    $stmtCheck->execute();
    $result = $stmtCheck->get_result();

    // Determine user number
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        preg_match('/\d+$/', $row['fullname'], $matches);
        $userCount = isset($matches[0]) ? intval($matches[0]) + 1 : 1;
    } else {
        $userCount = 1;
    }

    // Generate fullname and username
    $generatedFullname = "$deptPrefix User $userCount";  // Example: "Labour User 1"
    $generatedUsername = $fullname;  // Username remains the original input

    // Hash password before storing
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert into users table
    $stmtInsertUser = $conn4->prepare("INSERT INTO users (username, password, fullname, user_type, department) VALUES (?, ?, ?, ?, ?)");
    $stmtInsertUser->bind_param("sssss", $generatedUsername, $hashedPassword, $generatedFullname, $userType, $department);

    if (!$stmtInsertUser->execute()) {
        die("Database Insert Error (conn4 - users): " . $stmtInsertUser->error);
    }

 
     // After successful signup
     $_SESSION['user_fullname'] = $fullname;// Store user's fullname in session

    // Return JSON response instead of redirecting
    $response = [
    "success" => true,
    "message" => "Signup successful! Please verify your email."
    ];

    echo json_encode($response);
    exit();

}
?>
