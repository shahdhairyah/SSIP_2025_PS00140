<?php
require 'db_admin.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $l_password = $_POST['password'];

    // Fetch user with hashed password
    $stmt = $conn->prepare("SELECT id, password FROM admins WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $l_password == $user['password']){
        // Generate a 6-digit token
        $token = rand(100000, 999999);
        $expires_at = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        // Store token in database
        $stmt = $conn->prepare("UPDATE admins SET reset_token_otp = ?, reset_expires_otp = ? WHERE email = ?");
        $stmt->execute([$token, $expires_at, $email]);

        // Send email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USER;
            $mail->Password = SMTP_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = SMTP_PORT;

            $mail->setFrom(SMTP_FROM, 'Verification Code');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Your Verification Code';
            $mail->Body = "
                <html>
                <body style='font-family: Arial, sans-serif; text-align: center;'>
                    <h2>Your Verification Code</h2>
                    <p>Use this code to verify your request:</p>
                    <h1 style='color: #007bff; font-size: 36px; letter-spacing: 5px;'>{$token}</h1>
                    <p>This code will expire in 10 minutes.</p>
                    <p>If you didn't request this code, please ignore this email.</p>
                </body>
                </html>";

            $mail->send();
            echo json_encode(['success' => true, 'message' => 'Verification code sent successfully']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Failed to send verification code']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
    }
}