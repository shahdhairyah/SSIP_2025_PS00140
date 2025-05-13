<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "skill_db");

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Check if 'chart' is set in the GET request
if (isset($_GET['chart']) && $_GET['chart'] == 'training_enrollment') {
    $sql = "SELECT month, it_software, manufacturing, healthcare FROM training_enrollment";
    $result = $conn->query($sql);
    
    $data = ["labels" => [], "it_software" => [], "manufacturing" => [], "healthcare" => []];

    while ($row = $result->fetch_assoc()) {
        $data['labels'][] = $row['month'];
        $data['it_software'][] = $row['it_software'];
        $data['manufacturing'][] = $row['manufacturing'];
        $data['healthcare'][] = $row['healthcare'];
    }
    echo json_encode($data);
} else {
    echo json_encode(["error" => "Invalid or missing 'chart' parameter"]);
}

$conn->close();
?>
