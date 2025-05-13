<?php
session_start(); // Make sure session is started
if (isset($_SESSION['user_email'])) {
    require 'db_connect.php';
    $email = $_SESSION['user_email'];
    $stmt = $conn->prepare("SELECT status, department FROM auth_users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($status, $department); // ✅ Corrected here
    $stmt->fetch();
    $stmt->close();

    // Redirect only if approved
    if ($status === 'approved') {
        if ($department == 'Skill Development') {
            header("Location: das_s.php");
            exit;
        } elseif ($department == 'Labour Department') {
            header("Location: das_l.php");
            exit;
        } elseif ($department == 'Employment Department') {
            header("Location: das_e.php");
            exit;
        } else {
            echo "Unknown department for redirect.";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approval Waiting Page</title>
    <style>
        /* Background with animated gradient */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(-45deg,rgb(229, 253, 184),rgb(250, 249, 249),rgb(254, 178, 220),rgb(149, 215, 251));
            background-size: 400% 400%;
            animation: gradientBG 8s ease infinite;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Container with Glassmorphism Effect */
        .container {
            text-align: center;
            padding: 30px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 90%;
        }

        .message {
            font-size: 22px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
        }

        /* Loader Animation */
        .loader {
            margin: 20px auto;
            width: 50px;
            height: 50px;
            border: 5px solid rgba(255, 255, 255, 0.3);
            border-top: 5px solid #ff5e62;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .container {
                width: 95%;
                padding: 20px;
            }
            .message {
                font-size: 18px;
            }
            .loader {
                width: 40px;
                height: 40px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="message">⏳ Waiting for Admin Approval...</div>
        <div class="loader"></div>
        <p style="color: #555; font-size: 14px;">This may take a few Days.</p>
    </div>
</body>
</html>
