<?php
header('Content-Type: application/json');
error_reporting(0);

require 'config_1.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $token = filter_var($_POST['token'], FILTER_SANITIZE_STRING);
    try {
        // Check if token is valid
        $stmt = $conn->prepare("SELECT reset_token_otp, reset_expires_otp, fullname, status , department  FROM auth_users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if ($user['reset_token_otp'] == $token && strtotime($user['reset_expires_otp']) > time()) {
                // Update user status to verified
                $updateStmt = $conn->prepare("UPDATE auth_users SET  reset_token_otp = NULL, reset_expires_otp = NULL WHERE email = ?");
                $updateStmt->execute([$email]);
                $fullname=$user['fullname'];
                $status=$user['status'];
                $id=$user['id'];
                $department=$user['department'];
                // Start session and store user data
                session_start();
                $_SESSION['user_email'] = $email;
                $_SESSION['verified'] = true;
                $_SESSION['user_fullname']=$fullname;
                $_SESSION['user_id']=$id;
                if ($status == 'approved') {
                    if ($department == 'Skill Development') {
                        $redirectPage = 'das_s.php';
                    } elseif ($department == 'Labour Department') {
                        $redirectPage = 'das_l.php';
                    } elseif ($department == 'Employment Department') {
                        $redirectPage = 'das_e.php';
                    } else {
                        echo json_encode([
                            "success" => false,
                            "message" => "Unknown department. Cannot redirect."
                        ]);
                        exit();
                    }
                } else {
                    $redirectPage = 'Approval_wait.php';
                }                
                echo json_encode([
                    "success" => true,
                    "message" => "Email verified successfully",
                    "redirect" => $redirectPage
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