<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Chat System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        :root {
    font-family: Inter, system-ui, Avenir, Helvetica, Arial, sans-serif;
    line-height: 1.5;
    font-weight: 400;
}

body {
    margin: 0;
    min-height: 100vh;
    background-color: #f0f2f5;
}

#app {
    max-width: 1280px;
    margin: 0 auto;
    padding: 1rem;
}

.app-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: white;
    border-radius: 8px;
    margin-bottom: 1rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.user-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.logout-btn {
    padding: 0.5rem 1rem;
    background: #ff4444;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    font-weight: 500;
}

.chat-container {
    display: grid;
    grid-template-columns: 250px 1fr;
    gap: 1rem;
    height: calc(100vh - 150px);
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.users-list {
    background: #f8f9fa;
    border-right: 1px solid #dee2e6;
    padding: 1rem;
    overflow-y: auto;
}

.department-filter,
.view-type-filter {
    margin-bottom: 1rem;
    padding: 0.5rem;
    background: white;
    border-radius: 4px;
}

.department-filter select,
.view-type-filter select {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    font-size: 0.9375rem;
}

.scroll-container {
    width: 100%;
    height: 100%;
    overflow-y: auto;
    overflow-x: hidden;
    scrollbar-width: thin;
    scrollbar-color: #888 #f0f2f5;
}

.scroll-container::-webkit-scrollbar {
    width: 8px;
}

.scroll-container::-webkit-scrollbar-track {
    background: #f0f2f5;
}

.scroll-container::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

.scroll-container::-webkit-scrollbar-thumb:hover {
    background: #555;
}

.chat-main {
    display: flex;
    flex-direction: column;
    min-height: 100%;
}

.chat-messages {
    flex: 1;
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.broadcast-option {
    margin-bottom: 1rem;
    padding: 0.5rem;
    background: #f8f9fa;
    border-radius: 4px;
    display: flex;
    align-items: center;
}

.broadcast-option label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
}

.broadcast-option input[type="checkbox"] {
    width: 1rem;
    height: 1rem;
}

.user-item {
    padding: 0.75rem;
    border-radius: 4px;
    margin-bottom: 0.5rem;
    background: white;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.user-name {
    font-weight: 500;
    display: block;
}

.user-type {
    font-size: 0.875rem;
    color: #6c757d;
}

.user-department {
    font-size: 0.75rem;
    color: #6c757d;
    display: block;
    margin-top: 0.25rem;
}

.chat-input-container {
    padding: 1rem;
    border-top: 1px solid #dee2e6;
    background: white;
}

.recipient-selection {
    margin-bottom: 0.75rem;
}

.recipient-selection select {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    font-size: 0.9375rem;
    min-height: 100px;
}

.recipient-selection select:disabled {
    background-color: #e9ecef;
    cursor: not-allowed;
}

.input-wrapper {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: #f8f9fa;
    border-radius: 24px;
    padding: 0.5rem 1rem;
    border: 2px solid transparent;
    margin-bottom: 0.75rem;
}

.input-wrapper:focus-within {
    border-color: #0084ff;
    background: white;
}

#message-input {
    flex: 1;
    border: none;
    background: transparent;
    outline: none;
    font-size: 0.9375rem;
}

.file-label {
    cursor: pointer;
    font-size: 1.25rem;
    opacity: 0.7;
    transition: opacity 0.2s;
}

.file-label:hover {
    opacity: 1;
}

#file-input {
    display: none;
}

#send-button {
    width: 100%;
    background-color: #0084ff;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 24px;
    cursor: pointer;
    font-weight: 600;
    font-size: 0.9375rem;
    transition: all 0.2s;
}

#send-button:hover {
    background-color: #0073e6;
    transform: translateY(-1px);
}

.notification-popup {
    position: fixed;
    top: 20px;
    right: 20px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    z-index: 1000;
    max-width: 400px;
    width: 100%;
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.notification-content {
    padding: 1rem;
}

.notification-content h4 {
    margin: 0 0 0.5rem 0;
    color: #1a1a1a;
}

.notification-content ul {
    list-style: none;
    padding: 0;
    margin: 0 0 1rem 0;
}

.notification-content li {
    padding: 0.5rem 0;
    border-bottom: 1px solid #eee;
}

.notification-content li:last-child {
    border-bottom: none;
}

.dismiss-btn {
    background: #0084ff;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
    font-weight: 500;
    transition: background-color 0.2s;
}

.dismiss-btn:hover {
    background: #0073e6;
}

@media (max-width: 768px) {
    .chat-container {
        grid-template-columns: 1fr;
    }

    .users-list {
        display: none;
    }
}
    </style>
</head>
<body>
    <div id="app">
        <header class="app-header">
            <h1>Department Chat System</h1>
            <div class="user-info">
                Welcome, <?php echo htmlspecialchars($_SESSION['user_fullname']); ?> 
                (<?php echo htmlspecialchars($_SESSION['user_type']); ?>
                <?php if ($_SESSION['department']): ?> 
                    - <?php echo htmlspecialchars($_SESSION['department']); ?>
                <?php endif; ?>)
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        </header>
        <div class="chat-container">
            <div class="users-list">
                <h2>Users & Departments</h2>
                <?php if ($_SESSION['user_type'] === 'super_admin'): ?>
                <div class="department-filter">
                    <select id="department-select">
                        <option value="">All Departments</option>
                        <option value="Labour Department">Labour Department</option>
                        <option value="Skill Development">Skill Development</option>
                        <option value="Employment Department">Employment Department</option>
                    </select>
                </div>
                <?php endif; ?>
                <?php if ($_SESSION['user_type'] === 'employee'): ?>
                <div class="view-type-filter">
                    <select id="view-type-select">
                        <option value="all">All Department Users</option>
                        <option value="admin">Department Admin</option>
                    </select>
                </div>
                <?php endif; ?>
                <div id="users-container"></div>
            </div>
            <div class="scroll-container">
                <div class="chat-main">
                    <div id="chat-messages" class="chat-messages"></div>
                    <div class="chat-input-container">
                        <div class="recipient-selection">
                            <select id="recipient-select" multiple>
                                <option value="">Select Recipients</option>
                            </select>
                        </div>
                        <div class="input-wrapper">
                            <input type="text" id="message-input" placeholder="Type a message...">
                            <label for="file-input" class="file-label">
                                📎
                                <input type="file" id="file-input" accept="image/*,.pdf,.doc,.docx" multiple>
                            </label>
                        </div>
                        <button id="send-button">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const currentUserId = <?php echo json_encode($_SESSION['user_id']); ?>;
        const userType = <?php echo json_encode($_SESSION['user_type']); ?>;
        const userDepartment = <?php echo json_encode($_SESSION['department']); ?>;
    </script>
    <script src="chat.js"></script>
</body>
</html>