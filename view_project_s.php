<?php
require 'config_skill.php'; // Connect to database

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid Project ID.");
}

$project_id = intval($_GET['id']);

try {
    // Fetch project details
    $stmt = $pdo->prepare("SELECT id, project_name, start_date, deadline, budget, status, progress, status_class 
                           FROM projects WHERE id = ?");
    $stmt->execute([$project_id]);
    $project = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$project) {
        die("Project not found.");
    }

    // Fetch department name
    // $stmt = $pdo->prepare("SELECT name FROM departments WHERE id = ?");
    // $stmt->execute([$project['department']]);
    // $department = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project Details - Skill Development Department</title>
    <link rel="stylesheet" href="style_V.css">
</head>
<body>

<h2><?php echo htmlspecialchars($project['project_name']); ?></h2>
<p><strong>Department:</strong> <?php echo htmlspecialchars($department['name'] ?? 'Unknown'); ?></p>
<p><strong>Start Date:</strong> <?php echo htmlspecialchars($project['start_date']); ?></p>
<p><strong>Deadline:</strong> <?php echo htmlspecialchars($project['deadline']); ?></p>
<p><strong>Budget:</strong> ₹<?php echo htmlspecialchars($project['budget'])?></p>
<p><strong>Status:</strong> <span class="badge bg-<?php echo htmlspecialchars($project['status_class']); ?>">
    <?php echo htmlspecialchars($project['status']); ?></span></p>
<p><strong>Progress:</strong> <?php echo htmlspecialchars($project['progress']); ?>%</p>

<div class="progress" style="height: 10px; width: 200px;">
    <div class="progress-bar bg-<?php echo htmlspecialchars($project['status_class']); ?>" 
         role="progressbar" 
         style="width: <?php echo htmlspecialchars($project['progress']); ?>%;" 
         aria-valuenow="<?php echo htmlspecialchars($project['progress']); ?>" 
         aria-valuemin="0" aria-valuemax="100">
    </div>
</div>

<a href="skill.php">Back to Dashboard</a>

</body>
</html>
