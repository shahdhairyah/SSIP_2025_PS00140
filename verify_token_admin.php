<?php
header('Content-Type: application/json');
error_reporting(0);

require 'db_admin.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $token = filter_var($_POST['token'], FILTER_SANITIZE_STRING);
    try {
        // Check if token is valid
        $stmt = $conn->prepare("SELECT reset_token_otp, reset_expires_otp, department FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if ($user['reset_token_otp'] == $token && strtotime($user['reset_expires_otp']) > time()) {
                // Update user status to verified
                $updateStmt = $conn->prepare("UPDATE admins SET reset_token_otp = NULL, reset_expires_otp = NULL WHERE email = ?");
                $updateStmt->execute([$email]);
                $department=$user['department'];

                if ($department == 'Admin Department') {
                    $redirect = "admin.php";
                } else if ($department == 'Admin - Skill Development') {
                    $redirect = "admin_s.php";
                } else if ($department == 'Admin - Labour Department') {
                    $redirect = "admin_l.php";
                }else if($department == 'Admin - Employment Department'){
                    $redirect= "admin_e.php";
                }else{
                    $redirect = "admin_login.php";
                }
                // Start session and store user data
                session_start();
                $_SESSION['user_email_admin'] = $email;
                $_SESSION['verified'] = true;
                $_SESSION['redirect'] = $redirect;
                echo json_encode([
                    "success" => true,
                    "message" => "Email verified successfully",
                    "redirect" => $redirect
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Invalid or expired verification code"
                ]);
            }
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Email not found"
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            "success" => false,
            "message" => "Server error occurred"
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method"
    ]);
}