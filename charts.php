<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "labour_db");

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Fetch department performance data
if ($_GET['chart'] == 'department_performance') {
    $sql = "SELECT month, performance_score FROM department_performance WHERE department='Labour'";
    $result = $conn->query($sql);
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data['labels'][] = $row['month'];
        $data['data'][] = $row['performance_score'];
    }
    echo json_encode($data);
}

// Fetch labour welfare scheme data
if ($_GET['chart'] == 'labour_welfare') {
    $sql = "SELECT project_name, target, achieved FROM labour_welfare_schemes";
    $result = $conn->query($sql);
    
    $data = ["labels" => [], "target" => [], "achieved" => []];
    while ($row = $result->fetch_assoc()) {
        $data['labels'][] = $row['project_name'];
        $data['target'][] = $row['target'];
        $data['achieved'][] = $row['achieved'];
    }
    echo json_encode($data);
}

$conn->close();
?>
