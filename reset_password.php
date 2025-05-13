<?php
require 'config.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    // Check if email exists in database
    $stmt = $conn->prepare("SELECT temp_pass FROM auth_users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the result

    if ($user) {
        $tempPassword = $user['temp_pass']; // Get the stored temp password
        
        // Send email
        $mail = new PHPMailer(true);
        
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USER;
            $mail->Password = SMTP_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = SMTP_PORT;
            
            // Recipients
            $mail->setFrom(SMTP_FROM, 'Password Reset');
            $mail->addAddress($email);
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your Password Reset Request';
            $mail->Body = "
                <html>
                <body style='font-family: Arial, sans-serif;'>
                    <h2>Password Reset Request</h2>
                    <p>Your Password is: <strong>$tempPassword</strong></p>
                    <p>Please log in with this password.</p>
                    <a href='http://localhost/HTML/Departments/index.html'>Login</a>
                    <p>If you didn't request this, please ignore this email.</p>
                </body>
                </html>";

            $mail->send();
            redirect('success_e.html'); // Redirect to success page
        } catch (Exception $e) {
            redirect('error_e.html'); // Redirect to error page
        }
    } else {
        redirect('error_e_n.html'); // Redirect to "email not found" page
    }
}

// Redirect function
    function redirect($url) {
        header("Location: $url");
        exit();
    }
?>