<?php
require 'config_employee.php'; // Database connection

try {
    // Fetch all certificates
    $stmt = $pdo->query("SELECT * FROM safety_certifications ORDER BY issue_date DESC");
    $certificates = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Certificates</title>
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
        .badge {
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 12px;
        }
        .bg-success {
            background-color: #28a745;
            color: white;
        }
        .bg-danger {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>

<h2>All Certificates</h2>

<table border="1">
    <thead>
        <tr>
            <th>Certificate ID</th>
            <th>Factory Name</th>
            <th>Type</th>
            <th>Issue Date</th>
            <th>Valid Until</th>
            <th>Status</th>
            <th>Generated On</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($certificates as $certificate): ?>
        <tr>
            <td><?php echo htmlspecialchars($certificate['certificate_id']); ?></td>
            <td><?php echo htmlspecialchars($certificate['factory_name']); ?></td>
            <td><?php echo htmlspecialchars($certificate['type']); ?></td>
            <td><?php echo htmlspecialchars($certificate['issue_date']); ?></td>
            <td><?php echo htmlspecialchars($certificate['valid_until']); ?></td>
            <td><span class="badge bg-<?php echo htmlspecialchars($certificate['status_class']); ?>">
                <?php echo htmlspecialchars($certificate['status']); ?></span></td>
            <td><?php echo htmlspecialchars($certificate['generated_on']); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="employment.php">Back to Dashboard</a>

</body>
</html>
