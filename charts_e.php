<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "employment_db");

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Fetch employment trends data
if ($_GET['chart'] == 'employment_trends') {
    $sql = "SELECT year, job_seekers, placements FROM employment_trends";
    $result = $conn->query($sql);
    
    $data = ["labels" => [], "job_seekers" => [], "placements" => []];
    while ($row = $result->fetch_assoc()) {
        $data['labels'][] = $row['year'];
        $data['job_seekers'][] = $row['job_seekers'];
        $data['placements'][] = $row['placements'];
    }
    echo json_encode($data);
}

// Fetch job sector data
if ($_GET['chart'] == 'job_sectors') {
    $sql = "SELECT sector, count FROM job_sectors";
    $result = $conn->query($sql);
    
    $data = ["labels" => [], "count" => []];
    while ($row = $result->fetch_assoc()) {
        $data['labels'][] = $row['sector'];
        $data['count'][] = $row['count'];
    }
    echo json_encode($data);
}

$conn->close();
?>
