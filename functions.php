<?php
require_once 'config_labour.php';

function getDashboardMetrics() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM dashboard_metrics");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getName() {
    global $pdo;
    if(isset($_SESSION['user_fullname'])){
        return $_SESSION['user_fullname'];
    }else{
        return ' ';
    }
}

function getEmployees() {
    global $pdo;
    $stmt = $pdo->query("SELECT e.*, d.name as department_name 
                         FROM employees e 
                         LEFT JOIN departments d ON e.department_id = d.id");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getInspections() {
    global $pdo;
    $stmt = $pdo->query("SELECT i.*, e.name as inspector_name 
                         FROM inspections i 
                         LEFT JOIN employees e ON i.inspector_id = e.id 
                         ORDER BY i.date DESC 
                         LIMIT 5");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getProjects() {
    global $pdo;
    $stmt = $pdo->query("SELECT p.*, d.name as department_name 
                         FROM projects p 
                         LEFT JOIN departments d ON p.department_id = d.id");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getReports() {
    global $pdo;
    $stmt = $pdo->query("SELECT r.*, d.name as department_name 
                         FROM reports r 
                         LEFT JOIN departments d ON r.department_id = d.id 
                         ORDER BY r.generated_on DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getNotifications() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM notifications ORDER BY id DESC");
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $notifications;
}


function getChartData() {
    global $pdo;
    $stmt = $pdo->query("SELECT 
                            MONTH(date) as month,
                            COUNT(*) as total,
                            SUM(CASE WHEN status = 'Compliant' THEN 1 ELSE 0 END) as compliant
                         FROM inspections 
                         WHERE YEAR(date) = YEAR(CURRENT_DATE)
                         GROUP BY MONTH(date)
                         ORDER BY month");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>