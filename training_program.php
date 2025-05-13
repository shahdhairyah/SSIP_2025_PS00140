<?php
require 'config_skill.php'; // Connect to database

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid Training Program ID.");
}

$program_id = intval($_GET['id']);

try {
    // Fetch training program details
    $stmt = $pdo->prepare("SELECT * FROM training_programs WHERE id = ?");
    $stmt->execute([$program_id]);
    $program = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$program) {
        die("Training Program not found.");
    }

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Training Program Details - <?php echo htmlspecialchars($program['program_name']); ?></title>
    <link rel="stylesheet" href="style_V.css">
</head>
<body>

<h2>Training Program Details</h2>
<p><strong>Program ID:</strong> <?php echo htmlspecialchars($program['program_id']); ?></p>
<p><strong>Name:</strong> <?php echo htmlspecialchars($program['program_name']); ?></p>
<p><strong>Start Date:</strong> <?php echo htmlspecialchars($program['start_date']); ?></p>
<p><strong>Duration:</strong> <?php echo htmlspecialchars($program['duration']); ?></p>
<p><strong>Location:</strong> <?php echo htmlspecialchars($program['location']); ?></p>
<p><strong>Total Seats:</strong> <?php echo htmlspecialchars($program['total_seats']); ?></p>
<p><strong>Booked Seats:</strong> <?php echo htmlspecialchars($program['booked_seats']); ?></p>
<p><strong>Status:</strong> <span class="badge bg-<?php echo htmlspecialchars($program['status_class']); ?>">
    <?php echo htmlspecialchars($program['status']); ?></span></p>

<a href="skill.php">Back to Dashboard</a>

</body>
</html>
