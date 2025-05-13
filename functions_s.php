<?php
require_once 'config_skill.php';

function getDashboardMetrics_s() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM dashboard_metrics");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getNotifications_s() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM notifications ORDER BY id DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getProjects_s() {
    global $pdo;
    $stmt = $pdo->query("SELECT p.*, d.name as department_name 
                         FROM projects p 
                         LEFT JOIN departments d ON p.department = d.id");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getReports_s() {
    global $pdo;
    $stmt = $pdo->query("SELECT r.*, d.name as department_name 
                         FROM reports r 
                         LEFT JOIN departments d ON r.department = d.id 
                         ORDER BY r.generated_on DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTopSkills() {
    global $pdo;
    $stmt = $pdo->query("SELECT e.*
                         FROM top_skills e");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTrainingEnrollment() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM training_enrollment");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTrainingPrograms() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM training_programs");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getDepartmentProgress(){
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM department_progress");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// function getChartData() {
//     global $pdo;
//     $stmt = $pdo->query("SELECT 
//                             MONTH(date) as month,
//                             COUNT(*) as total,
//                             SUM(CASE WHEN status = 'Compliant' THEN 1 ELSE 0 END) as compliant
//                          FROM inspections 
//                          WHERE YEAR(date) = YEAR(CURRENT_DATE)
//                          GROUP BY MONTH(date)
//                          ORDER BY month");
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }

?>
