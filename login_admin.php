<?php
session_start();
include 'db_admin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['login-email'];
    $password = $_POST['login-password'];

    // Sanitize input
    $email = mysqli_real_escape_string($conn, trim($email));
    $password = mysqli_real_escape_string($conn, trim($password));

    $query = "SELECT * FROM admins WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        if ($user['password'] == $password) {
            $_SESSION['admin'] = $email;

            $department = $user['department'];
            if ($department == 'Admin Department') {
                $redirect = 'admin.php';
            } else if ($department == 'Admin - Skill Development') {
                $redirect = 'admin_s.php';
            } else if ($department == 'Admin - Labour Department') {
                $redirect = 'admin_l.php';
            } else {
                $redirect = 'admin_e.php';
            }

            $_SESSION['redirect'] = $redirect;

            echo json_encode(['success' => true, 'redirect' => $redirect]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Incorrect password']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Email not found']);
    }
}
?>
