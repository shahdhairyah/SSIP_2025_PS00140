<?php
require 'config_employee.php'; // Database connection

try {
    // Fetch all candidates
    $stmt = $pdo->query("SELECT * FROM job_placements ORDER BY placement_date DESC");
    $candidates = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Candidates</title>
    <link rel="stylesheet" href="style_V.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-family: Arial, sans-serif;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .success {
            color: green;
            font-weight: bold;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Candidate Placement Records</h5>
    </div>
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>Candidate ID</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Company</th>
                    <th>Placement Date</th>
                    <th>Salary Range</th>
                    <th>Status</th>
                    <th>Generated On</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($candidates as $candidate): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($candidate['candidate_id']); ?></td>
                        <td><?php echo htmlspecialchars($candidate['name']); ?></td>
                        <td><?php echo htmlspecialchars($candidate['position']); ?></td>
                        <td><?php echo htmlspecialchars($candidate['company']); ?></td>
                        <td><?php echo htmlspecialchars($candidate['placement_date']); ?></td>
                        <td><?php echo htmlspecialchars($candidate['salary_range']); ?></td>
                        <td class="success">Hired</td>
                        <td><?php echo htmlspecialchars($candidate['generated_on']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<a href="employment.php" class="btn btn-secondary mt-3">Back to Dashboard</a>

</body>
</html>
