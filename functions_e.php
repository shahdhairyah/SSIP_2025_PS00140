<?php
require_once 'config_employee.php';

function getDashboardMetrics_e() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM dashboard_metrics");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getNotifications_e() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM notifications ORDER BY id DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getProjects_e() {
    global $pdo;
    $stmt = $pdo->query("SELECT p.*, d.name as department_name 
                         FROM projects p 
                         LEFT JOIN departments d ON p.department = d.id");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getReports_e() {
    global $pdo;
    $stmt = $pdo->query("SELECT r.*, d.name as department_name 
                         FROM reports r 
                         LEFT JOIN departments d ON r.department = d.id 
                         ORDER BY r.generated_on DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getJobPlacement_e() {
    global $pdo;
    $stmt = $pdo->query("SELECT j.* FROM job_placements j ORDER BY j.generated_on DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getJobSectors_e() {
    global $pdo;
    $stmt = $pdo->query("SELECT j_d.* FROM job_placements j_d;");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getSafetyCertifications_e()
{
    global $pdo;
    $stmt = $pdo->query("SELECT s.*FROM safety_certifications s ORDER BY s.generated_on DESC");
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
