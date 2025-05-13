<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

try {
    $user_id = $_SESSION['user_id'];
    
    // Fetch unread notifications with message details
    $query = "
        SELECT 
            n.id as notification_id,
            n.created_at as notification_time,
            n.is_read,
            m.id as message_id,
            m.sender_name,
            m.message,
            m.department,
            m.is_broadcast
        FROM notifications n
        JOIN messages m ON n.message_id = m.id
        WHERE n.user_id = :user_id 
        AND n.is_read = FALSE
        ORDER BY n.created_at DESC
    ";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // If there are unread notifications, mark them as read
    if (!empty($notifications)) {
        $notification_ids = array_column($notifications, 'notification_id');
        $ids_string = implode(',', $notification_ids);
        
        $updateQuery = "UPDATE notifications SET is_read = TRUE WHERE id IN ($ids_string)";
        $pdo->exec($updateQuery);
    }

    echo json_encode([
        'status' => 'success',
        'notifications' => $notifications
    ]);

} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch notifications: ' . $e->getMessage()
    ]);
}
?>