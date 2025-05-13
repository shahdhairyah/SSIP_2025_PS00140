<?php
session_start();
require_once 'server/config.php';

// If already logged in, redirect to index
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Direct login check for hardcoded credentials
    if ($username == 'nandP' && $password == 'password') {
        // Setting session variables directly for this case
        $_SESSION['user_id'] = 6;  // Assign appropriate ID
        $_SESSION['user_fullname'] = 'nandP';  // Assign a default fullname
        $_SESSION['user_type'] = 'employee';  // Set a default user type
        $_SESSION['department'] = 'Skill Department';  // Set a default department
        header("Location: index.php");
        exit;
    }

    // Check credentials against the database
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user) {
            $db_password = $user['password'];
            if ($password == $db_password) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_fullname'] = $user['fullname'];
                $_SESSION['user_type'] = $user['user_type'];
                $_SESSION['department'] = $user['department'];
                header('Location: index.php');
                exit;
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "User not found.";
        }
    } catch(PDOException $e) {
        $error = "Login failed. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Messaging System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .note {
      background-color: #ffe5e5;
      border-left: 5px solid #ff0000;
      padding: 5px;
      margin: 4px 0;
      color: #cc0000;
      font-weight: bold;
      font-family: Arial, sans-serif;
    }
    </style>
</head>
<body>
    <div class="login-container">
        <form class="login-form" method="POST" action="">
            <h1>Login</h1>
            <?php if ($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <div class="note">
                    ⚠️ Note :<strong>All Crenditals is same.</strong> Given by you in signup page.
            </div>
            <div class="form-group">
                <label for="username">Username Or Fullname</label>
                <input type="text" id="username" name="username" required>
                <!-- <div class="note">
                    ⚠️ Note :<strong>Username is Same as Fullname</strong> given by you in signup page.
                </div> -->
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
