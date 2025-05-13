<?php
require 'config_labour.php'; // Connect to database

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid Inspection ID.");
}

$inspection_id = intval($_GET['id']);

try {
    // Fetch inspection details
    $stmt = $pdo->prepare("SELECT id, establishment, date, inspector_id, status, status_class FROM inspections WHERE id = ?");
    $stmt->execute([$inspection_id]);
    $inspection = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$inspection) {
        die("Inspection not found.");
    }

    // Fetch inspector name
    $stmt = $pdo->prepare("SELECT fullname FROM f_name WHERE id =?");
    $stmt->execute([$inspection['inspector_id']]);
    $inspector = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inspection Details - <?php echo htmlspecialchars($inspection['establishment']); ?></title>
    <link rel="stylesheet" href="style_V.css">
</head>
<body>

<h2>Inspection Details</h2>
<p><strong>Establishment:</strong> <?php echo htmlspecialchars($inspection['establishment']); ?></p>
<p><strong>Date:</strong> <?php echo htmlspecialchars($inspection['date']); ?></p>
<p><strong>Inspector:</strong> <?php echo htmlspecialchars($inspector['name'] ?? 'Unknown'); ?></p>
<p><strong>Status:</strong> <span class="badge bg-<?php echo htmlspecialchars($inspection['status_class']); ?>">
    <?php echo htmlspecialchars($inspection['status']); ?></span></p>

<a href="labour.php">Back to Dashboard</a>

</body>
</html>
