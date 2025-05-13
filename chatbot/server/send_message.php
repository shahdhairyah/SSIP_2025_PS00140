<?php
require_once 'config.php';
require_once 'email_handler.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';
    $sender_id = $_SESSION['user_id'];
    $sender_name = $_SESSION['user_fullname'];
    $department = $_SESSION['department'];
    $user_type = $_SESSION['user_type'];
    $recipients = isset($_POST['recipients']) ? json_decode($_POST['recipients'], true) : [];
    $reply_to = isset($_POST['reply_to']) ? intval($_POST['reply_to']) : null;
    
    // Handle file uploads
    $files = [];
    if (isset($_FILES['files'])) {
        $upload_dir = __DIR__ . '/uploads/';
        
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['files']['error'][$key] === UPLOAD_ERR_OK) {
                $file_name = uniqid() . '_' . basename($_FILES['files']['name'][$key]);
                $target_path = $upload_dir . $file_name;
                
                if (move_uploaded_file($tmp_name, $target_path)) {
                    $files[] = [
                        'path' => 'uploads/' . $file_name,
                        'type' => $_FILES['files']['type'][$key],
                        'name' => $_FILES['files']['name'][$key]
                    ];
                }
            }
        }
    }
    
    try {
        $pdo->beginTransaction();

        // Handle "All Department Members" for department admin
        if ($_SESSION['user_type'] === 'department_admin' && in_array('all_department', $recipients)) {
            $stmt = $pdo->prepare("
                SELECT id FROM users 
                WHERE department = ? 
                AND id != ? 
                AND user_type = 'employee'
            ");
            $stmt->execute([$department, $sender_id]);
            $recipients = array_column($stmt->fetchAll(), 'id');
        }

        // Insert the message
        $stmt = $pdo->prepare("
            INSERT INTO messages (
                sender_id, sender_name, department, message, 
                files, reply_to, created_at
            ) VALUES (?, ?, ?, ?, ?, ?, NOW())
        ");
        
        $stmt->execute([
            $sender_id, 
            $sender_name, 
            $department,
            $message, 
            json_encode($files), 
            $reply_to
        ]);
        
        $message_id = $pdo->lastInsertId();

        // Insert recipients
        if (!empty($recipients)) {
            $stmt = $pdo->prepare("
                INSERT INTO message_recipients (message_id, recipient_id) 
                VALUES (?, ?)
            ");
            
            foreach ($recipients as $recipient_id) {
                $stmt->execute([$message_id, $recipient_id]);
            }

            // Add notifications for direct messages
            $stmt = $pdo->prepare("
                INSERT INTO notifications (message_id, user_id, created_at)
                VALUES (?, ?, NOW())
            ");
            foreach ($recipients as $recipient_id) {
                $stmt->execute([$message_id, $recipient_id]);
            }
        }
        
        $pdo->commit();

        // Send email notifications
        $emailHandler = new EmailHandler($pdo);
        $emailHandler->sendNotifications(
            $message,
            [
                'id' => $sender_id,
                'fullname' => $sender_name,
                'department' => $department,
                'user_type' => $user_type
            ],
            $recipients,
            false,
            $department
        );
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Message sent successfully'
        ]);
    } catch(PDOException $e) {
        $pdo->rollBack();
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to send message: ' . $e->getMessage()
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'Method not allowed'
    ]);
}
?>