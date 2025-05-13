<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "employment_db");

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Fetch project budget data
if (isset($_GET['chart']) && $_GET['chart'] == 'project_budget') {
    $sql = "SELECT category, allocated_budget, utilized_budget FROM project_budget";
    $result = $conn->query($sql);

    $data = ["labels" => [], "allocated_budget" => [], "utilized_budget" => []];
    while ($row = $result->fetch_assoc()) {
        $data['labels'][] = $row['category'];
        $data['allocated_budget'][] = $row['allocated_budget'];
        $data['utilized_budget'][] = $row['utilized_budget'];
    }
    echo json_encode($data);
}

// Fetch project status data
if (isset($_GET['chart']) && $_GET['chart'] == 'project_status') {
    $sql = "SELECT status, percentage FROM project_status";
    $result = $conn->query($sql);

    $data = ["labels" => [], "percentage" => []];
    while ($row = $result->fetch_assoc()) {
        $data['labels'][] = $row['status'];
        $data['percentage'][] = $row['percentage'];
    }
    echo json_encode($data);
}

// Fetch Report Generation Frequency Data
if (isset($_GET['chart']) && $_GET['chart'] == 'report_frequency') {
    $sql = "SELECT frequency, reports_count FROM report_frequency";
    $result = $conn->query($sql);

    $data = ["labels" => [], "reports" => []];
    while ($row = $result->fetch_assoc()) {
        $data['labels'][] = $row['frequency'];
        $data['reports'][] = $row['reports_count'];
    }
    echo json_encode($data);
}

// Fetch Reports by Department Data
if (isset($_GET['chart']) && $_GET['chart'] == 'report_department') {
    $sql = "SELECT department, percentage FROM report_department";
    $result = $conn->query($sql);

    $data = ["labels" => [], "percentages" => []];
    while ($row = $result->fetch_assoc()) {
        $data['labels'][] = $row['department'];
        $data['percentages'][] = $row['percentage'];
    }
    echo json_encode($data);
}

$conn->close();
?>
