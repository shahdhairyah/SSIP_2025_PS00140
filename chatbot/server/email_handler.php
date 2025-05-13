<?php
require_once 'send_email.php';
require_once __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailHandler {
    private $pdo;
    private $mailer;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->initializeMailer();
    }

    private function initializeMailer() {
        $this->mailer = new PHPMailer(true);
        $this->mailer->isSMTP();
        $this->mailer->Host = SMTP_HOST;
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = SMTP_USER;
        $this->mailer->Password = SMTP_PASS;
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = SMTP_PORT;
        $this->mailer->setFrom(SMTP_FROM, 'Department Chat System');
        $this->mailer->isHTML(true);
    }

    public function sendNotifications($message, $sender, $recipients, $isBroadcast, $department) {
        try {
            // Get recipient emails based on user roles
            $query = "SELECT email, user_type, department FROM users WHERE ";
            $params = [];
            
            if ($isBroadcast) {
                $query .= "department = ? OR user_type IN ('department_admin', 'super_admin')";
                $params = [$department];
            } elseif ($sender['user_type'] === 'super_admin') {
                $placeholders = str_repeat('?,', count($recipients) - 1) . '?';
                $query .= "id IN ($placeholders)";
                $params = $recipients;
            } elseif ($sender['user_type'] === 'department_admin') {
                $query .= "department = ? AND user_type = 'employee'";
                $params = [$sender['department']];
            } else {
                return false;
            }

            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($users as $user) {
                $this->sendEmail($user['email'], $sender);
            }

            return true;
        } catch (Exception $e) {
            error_log("Email notification error: " . $e->getMessage());
            return false;
        }
    }

    private function sendEmail($to, $sender) {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($to);
            $this->mailer->Subject = 'New Message Notification - Department Chat System';
            
            $messageBody = "
                <html>
                <head>
                    <title>New Message Notification</title>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                        .header { background: #f8f9fa; padding: 20px; border-radius: 5px; }
                        .content { padding: 20px 0; }
                        .footer { font-size: 12px; color: #666; border-top: 1px solid #eee; padding-top: 20px; }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>
                            <h2>New Message Notification</h2>
                        </div>
                        <div class='content'>
                            <p>You have a new message from <strong>{$sender['fullname']}</strong> ({$sender['user_type']})</p>
                            <p>Department: {$sender['department']}</p>
                            <p><strong>Please log in to the chat system to view the message.</strong></p>
                        </div>
                        <div class='footer'>
                            <p>This is an automated notification. Please do not reply to this email.</p>
                        </div>
                    </div>
                </body>
                </html>
            ";

            $this->mailer->Body = $messageBody;
            $this->mailer->AltBody = strip_tags(str_replace(['<br>', '</p>'], ["\n", "\n\n"], $messageBody));

            return $this->mailer->send();
        } catch (Exception $e) {
            error_log("Failed to send email to $to: " . $e->getMessage());
            return false;
        }
    }
}
?>