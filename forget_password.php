<?php
require_once 'db_connect-1.php.php';
session_start();

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Check if email exists in database
        $stmt = $pdo->prepare("SELECT id, fullname FROM auth_users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user) {
            // Generate unique reset token
            $reset_token = bin2hex(random_bytes(32));
            $reset_token_hash = password_hash($reset_token, PASSWORD_DEFAULT);
            $reset_token_expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            // Store reset token in database
            $update_stmt = $pdo->prepare("UPDATE auth_users SET reset_token = ?, reset_token_expires = ? WHERE id = ?");
            $update_stmt->execute([$reset_token_hash, $reset_token_expires, $user['id']]);
            
            // Create reset link
            $reset_link = "http://" . $_SERVER['HTTP_HOST'] . "/reset_password.php?token=" . $reset_token . "&email=" . urlencode($email);
            
            // Email content
            $to = $email;
            $subject = "Password Reset Request";
            $message_body = "Dear " . htmlspecialchars($user['name']) . ",\n\n";
            $message_body .= "You have requested to reset your password. Please click the link below to reset your password:\n\n";
            $message_body .= $reset_link . "\n\n";
            $message_body .= "This link will expire in 1 hour.\n\n";
            $message_body .= "If you did not request this password reset, please ignore this email.\n\n";
            $message_body .= "Best regards,\nLabour Department Team";
            
            $headers = "From: noreply@labourdepartment.com";
            
            if (mail($to, $subject, $message_body, $headers)) {
                $message = "Password reset instructions have been sent to your email address.";
                $messageType = "success";
            } else {
                $message = "Failed to send password reset email. Please try again later.";
                $messageType = "danger";
            }
        } else {
            $message = "If the email address exists in our system, you will receive password reset instructions.";
            $messageType = "info";
        }
    } else {
        $message = "Please enter a valid email address.";
        $messageType = "danger";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Labour Department</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --background-color: #ecf0f1;
            --text-color: #2c3e50;
            --card-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-color);
        }

        .forgot-password-container {
            max-width: 500px;
            width: 100%;
            margin: 20px auto;
            padding: 0 15px;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .card-header {
            background: var(--primary-color);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 25px;
            text-align: center;
            border-bottom: none;
        }

        .card-header h4 {
            margin: 0;
            font-weight: 600;
            font-size: 1.5rem;
        }

        .card-body {
            padding: 35px;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        .form-text {
            color: #6c757d;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .btn-primary {
            background-color: var(--secondary-color);
            border: none;
            border-radius: 10px;
            padding: 12px 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }

        .back-to-login {
            text-align: center;
            margin-top: 25px;
        }

        .back-to-login a {
            color: var(--secondary-color);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .back-to-login a:hover {
            color: var(--primary-color);
        }

        .alert {
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 25px;
            border: none;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .input-group-text {
            background-color: transparent;
            border: 2px solid #e9ecef;
            border-right: none;
            border-radius: 10px 0 0 10px;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }

        @media (max-width: 576px) {
            .card-body {
                padding: 25px;
            }

            .forgot-password-container {
                margin: 10px auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="forgot-password-container">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-lock me-2"></i>Forgot Password</h4>
                </div>
                <div class="card-body">
                    <?php if ($message): ?>
                        <div class="alert alert-<?php echo $messageType; ?>" role="alert">
                            <?php echo $message; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="">
                        <div class="mb-4">
                            <label for="email" class="form-label">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" class="form-control" id="email" name="email" required 
                                       placeholder="Enter your registered email address">
                            </div>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Enter the email address you used during registration. We'll send you instructions to reset your password.
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Send Reset Instructions
                            </button>
                        </div>
                    </form>
                    
                    <div class="back-to-login">
                        <a href="index.html">
                            <i class="fas fa-arrow-left me-2"></i>Back to Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>