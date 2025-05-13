<?php
session_start();
session_destroy(); // End session
header("Location: index.html"); // Redirect to login
exit;
?>
