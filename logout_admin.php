<?php
session_start();
session_destroy(); // End session
header("Location: admin_login.php"); // Redirect to login
exit;
?>
