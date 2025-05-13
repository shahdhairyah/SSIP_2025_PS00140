<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

try {
    $department = isset($_GET['department']) ? $_GET['department'] : '';
    $current_user_type = $_SESSION['user_type'];
    $current_user_department = $_SESSION['department'];
    $view_type = isset($_GET['view_type']) ? $_GET['view_type'] : 'all';

    $query = "SELECT id, fullname, user_type, department FROM users WHERE 1=1";
    $params = [];

    if ($current_user_type === 'employee') {
        if ($view_type === 'all') {
            // Show all department users except themselves
            $query .= " AND department = ? AND id != ? AND user_type = 'employee'";
            $params = [$current_user_department, $_SESSION['user_id']];
        } else {
            // Show only department admin
            $query .= " AND department = ? AND user_type = 'department_admin'";
            $params = [$current_user_department];
        }
    } else if ($current_user_type === 'department_admin') {
        // Department admins can only see users in their department and super admin
        $query .= " AND (department = ? OR user_type = 'super_admin')";
        $params[] = $current_user_department;
    } else if ($current_user_type === 'super_admin' && $department) {
        // Super admin can filter by department
        $query .= " AND department = ?";
        $params[] = $department;
    }

    $query .= " ORDER BY user_type, department, fullname";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $users = $stmt->fetchAll();
    
    // Add "All" option for regular users
    if ($current_user_type === 'employee') {
        array_unshift($users, [
            'id' => 'all',
            'fullname' => 'All Department Members',
            'user_type' => 'group',
            'department' => $current_user_department
        ]);
    }
    
    echo json_encode([
        'status' => 'success',
        'users' => $users
    ]);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch users: ' . $e->getMessage()
    ]);
}
?>