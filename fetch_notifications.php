<?php
header('Content-Type: application/json');

$host = "localhost";
$username = "root";
$password = "";
$database = "labour_db";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Update icon column based on type
$updateQuery = "
    UPDATE notifications
    SET icon = 
        CASE 
            WHEN type = 'info' THEN 'bi-file-earmark-text'
            WHEN type = 'success' THEN 'bi-calendar-check'
            WHEN type = 'warning' THEN 'bi-exclamation-triangle'
            WHEN type = 'danger' THEN 'bi-x-circle'
            ELSE 'bi-bell'
        END
";

$conn->query($updateQuery);

// Fetch updated notifications
$sql = "SELECT title, message, type, icon, time_elapsed FROM notifications ORDER BY id asc";
$result = $conn->query($sql);

$notifications = [];

while ($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}

$conn->close();
echo json_encode($notifications);
?>
