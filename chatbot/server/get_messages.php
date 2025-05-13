<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

try {
    $user_id = $_SESSION['user_id'];
    $user_type = $_SESSION['user_type'];
    $department = $_SESSION['department'];

    $query = "
        SELECT m.*, 
               m2.id as reply_to_id,
               m2.message as reply_to_message,
               m2.sender_name as reply_to_sender_name,
               GROUP_CONCAT(mr.recipient_id) as recipients,
               m.is_broadcast
        FROM messages m
        LEFT JOIN messages m2 ON m.reply_to = m2.id
        LEFT JOIN message_recipients mr ON m.id = mr.message_id
        WHERE 1=1
    ";

    // Filter messages based on user type and department
    if ($user_type === 'department_admin') {
        $query .= " AND (
            m.sender_id = ? 
            OR m.id IN (SELECT message_id FROM message_recipients WHERE recipient_id = ?)
            OR (m.department = ? AND (m.is_broadcast = 1 OR m.sender_id IN (
                SELECT id FROM users WHERE department = ? AND user_type = 'employee'
            )))
        )";
        $params = [$user_id, $user_id, $department, $department];
    } else if ($user_type === 'employee') {
        $query .= " AND (
            m.sender_id = ? 
            OR m.id IN (SELECT message_id FROM message_recipients WHERE recipient_id = ?)
            OR (m.department = ? AND m.is_broadcast = 1)
        )";
        $params = [$user_id, $user_id, $department];
    }

    $query .= " GROUP BY m.id ORDER BY m.created_at ASC";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute($params ?? []);
    $messages = $stmt->fetchAll();
    
    // Process messages
    foreach ($messages as &$message) {
        if ($message['files']) {
            $message['files'] = json_decode($message['files'], true);
        }
        
        if ($message['recipients']) {
            $message['recipients'] = explode(',', $message['recipients']);
        }
        
        if ($message['reply_to']) {
            $message['reply_to'] = [
                'id' => $message['reply_to_id'],
                'message' => $message['reply_to_message'],
                'sender_name' => $message['reply_to_sender_name']
            ];
        }
        
        unset($message['reply_to_id']);
        unset($message['reply_to_message']);
        unset($message['reply_to_sender_name']);
    }
    
    echo json_encode([
        'status' => 'success',
        'messages' => $messages
    ]);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch messages: ' . $e->getMessage()
    ]);
}
?>