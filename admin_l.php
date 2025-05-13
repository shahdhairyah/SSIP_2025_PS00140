<?php
// Initialize session
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if (isset($_SESSION['user_email_admin']))
{
  $user_email_admin = $_SESSION['user_email_admin'];
}else{
  header("Location: admin_login.php");
}
// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$databases = ['labour_db'];

// Function to connect to specific database
function connectToDb($dbname) {
    global $host, $username, $password;
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

// Function to get pending users
function getPendingUsers() {
    $conn = connectToDb('departments_db');
    $stmt = $conn->query("SELECT * FROM auth_users WHERE department = 'Labour Department' AND status = 'pending'");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to approve user
function approveUser($userId) {
    global $user_email_admin; // ✅ Add this line
    $conn = connectToDb('departments_db');
    $stmt = $conn->prepare("UPDATE auth_users SET status = 'approved', approved_by = :approved_by WHERE id = :id");
    $stmt->bindParam(':id', $userId);
    $stmt->bindParam(':approved_by', $user_email_admin);
    $stmt->execute();
}


// Function to reject user
function rejectUser($userId) {
    $conn = connectToDb('departments_db');
    $stmt = $conn->prepare("DELETE FROM auth_users WHERE id = :id");
    return $stmt->execute([':id' => $userId]);
}

// Function to delete record
function deleteRecord($dbname, $table, $id) {
    $conn = connectToDb($dbname);
    try {
        $sql = "DELETE FROM $table WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    } catch(PDOException $e) {
        return false;
    }
}

// Get all tables from a database
function getTables($dbname) {
    $conn = connectToDb($dbname);
    $tables = [];
    
    $stmt = $conn->query("SHOW TABLES");
    while($row = $stmt->fetch(PDO::FETCH_NUM)) {
        $tables[] = $row[0];
    }
    
    return $tables;
}

// Get table data
function getTableData($dbname, $table, $department = null) {
    $conn = connectToDb($dbname);
    
    $sql = "SELECT * FROM $table";
    if ($department && hasColumn($conn, $table, 'department')) {
        $sql .= " WHERE department = :department";
    }
    
    $stmt = $conn->prepare($sql);
    if ($department && hasColumn($conn, $table, 'department')) {
        $stmt->bindParam(':department', $department);
    }
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Check if table has specific column
function hasColumn($conn, $table, $column) {
    $stmt = $conn->query("DESCRIBE $table");
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($row['Field'] == $column) {
            return true;
        }
    }
    return false;
}

// Handle form submissions and delete actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'approve' && isset($_POST['user_id'])) {
            approveUser($_POST['user_id']);
        } elseif ($_POST['action'] === 'reject' && isset($_POST['user_id'])) {
            rejectUser($_POST['user_id']);
        } else {
            $conn = connectToDb($_POST['database']);
            
            switch($_POST['action']) {
                case 'delete_record':
                    if (isset($_POST['table']) && isset($_POST['id'])) {
                        deleteRecord($_POST['database'], $_POST['table'], $_POST['id']);
                    }
                    break;
                case 'add_project':
                    $sql = "INSERT INTO projects (project_name, department, start_date, deadline, budget, status, progress) 
                            VALUES (:name, :dept, :start, :deadline, :budget, :status, :progress)";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([
                        ':name' => $_POST['project_name'],
                        ':dept' => $_POST['department'],
                        ':start' => $_POST['start_date'],
                        ':deadline' => $_POST['deadline'],
                        ':budget' => $_POST['budget'],
                        ':status' => $_POST['status'],
                        ':progress' => $_POST['progress']
                    ]);
                    break;
                case 'edit_project':
                    $sql = "UPDATE projects SET project_name = :name, department = :dept, start_date = :start, deadline = :deadline, budget = :budget, status = :status, progress = :progress WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([
                        ':id' => $_POST['id'],
                        ':name' => $_POST['project_name'],
                        ':dept' => $_POST['department'],
                        ':start' => $_POST['start_date'],
                        ':deadline' => $_POST['deadline'],
                        ':budget' => $_POST['budget'],
                        ':status' => $_POST['status'],
                        ':progress' => $_POST['progress']
                    ]);
                    break;
                case 'edit_metrices':
                    $sql = "UPDATE dashboard_metrics SET metric_name = :metric_name, metric_value = :metric_value, icon = :icon WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([
                        ':metric_name' => $_POST['metric_name'],
                        ':metric_value' => $_POST['metric_value'],
                        ':icon' => $_POST['icon'],
                        ':id' => $_POST['id']
                    ]);
                    break;
                case 'add_notification':
                    $sql = "INSERT INTO notifications (title, description, department, icon, timestamp) 
                            VALUES (:title, :desc, :dept, :icon, :timestamp)";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([
                        ':title' => $_POST['title'],
                        ':desc' => $_POST['description'],
                        ':dept' => $_POST['department'],
                        ':icon' => $_POST['icon'],
                        ':timestamp' => date('Y-m-d H:i:s')
                    ]);
                    break;
                case 'edit_notification':
                    $sql = "UPDATE notifications SET title = :title, description = :desc, department = :dept, icon = :icon, timestamp = :timestamp WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([
                        ':id' => $_POST['id'],
                        ':title' => $_POST['title'],
                        ':desc' => $_POST['description'],
                        ':dept' => $_POST['department'],
                        ':icon' => $_POST['icon'],
                        ':timestamp' => date('Y-m-d H:i:s')
                    ]);
                    break;
                case 'update_department':
                    $sql = "UPDATE departments SET name = :name, description = :description WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([
                        ':name' => $_POST['name'],
                        ':description' => $_POST['description'],
                        ':id' => $_POST['dept_id']
                    ]);
                    break;
                case 'add_metrices':
                    $sql = "INSERT INTO dashboard_metrics (metric_name, metric_value, icon) 
                            VALUES (:metric_name, :metric_value, :icon)";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([
                        ':metric_name' => $_POST['metric_name'],
                        ':metric_value' => $_POST['metric_value'],
                        ':icon' => $_POST['icon']
                    ]);
                    break;
            }
        }
    }
}

// Get selected database and department
$selectedDb = isset($_GET['database']) ? $_GET['database'] : $databases[0];
$selectedDept = isset($_GET['department']) ? $_GET['department'] : null;

// Get departments for modals
$departments = [];
try {
    $departments = getTableData($selectedDb, 'departments');
} catch(Exception $e) {
    // If departments table doesn't exist, we'll have an empty array
}

// Get pending users
$pendingUsers = getPendingUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style_admin.css" rel="stylesheet">
    <!-- Your existing styles here -->
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <div class="position-sticky pt-3">
                    <h6 class="sidebar-heading px-3 mt-4 mb-1 text">
                        Pending User Approvals
                    </h6>
                    <div class="nav flex-column">
                        <?php foreach($pendingUsers as $user): ?>
                        <div class="nav-item p-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><?php echo htmlspecialchars($user['fullname']); ?></strong><br>
                                    <small><?php echo htmlspecialchars($user['email']); ?></small><br>
                                    <small>Department: <?php echo htmlspecialchars($user['department']); ?></small>
                                </div>
                                <div class="btn-group-vertical">
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                        <input type="hidden" name="action" value="approve">
                                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                    </form>
                                    <form method="POST" class="d-inline ms-1">
                                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                        <input type="hidden" name="action" value="reject">
                                        <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <h6 class="sidebar-heading px-3 mt-4 mb-1 unmuted-text">
                        Databases
                    </h6>
                    <ul class="nav flex-column">
                        <?php foreach($databases as $db): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $selectedDb === $db ? 'active' : ''; ?>" 
                               href="?database=<?php echo $db; ?>">
                                <?php echo $db; ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="profile-section" id="profile-toggle">
                    <div class="profile-circle" id="profile-initial"><?php $string = $user_email_admin; $string= strtoupper($string); $string = substr($string,0,3); ?></div>
                    <div class="profile-info">
                        <div id="username"><?php echo $user_email_admin; ?></div>
                        <small id="department">Admin of <br> Labour Department</small>
                    </div>
                    <div class="dropdown-menu-custom" id="dropdown-menu">
                        <a href="logout_admin.php" id="logout-btn">Logout</a>
                    </div>
                </div>
            </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><?php echo htmlspecialchars($selectedDb); ?> Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button type="button" class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#editProjectModal">
                            Edit Project
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                            Add Project
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary me-2" data-bs-toggle="modal" data-bs-target="#editNotificationModal">
                            Edit Notification
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary me-2" data-bs-toggle="modal" data-bs-target="#addNotificationModal">
                            Add Notification
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#addMetricesModal">
                            Add Metrices
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#editMetricesModal">
                            Edit Metrices
                        </button>
                    </div>
                </div>

                <?php
                $tables = getTables($selectedDb);
                foreach($tables as $table):
                    $data = getTableData($selectedDb, $table, $selectedDept);
                    if (!empty($data)):
                ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h4><?php echo ucfirst($table); ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <?php foreach(array_keys($data[0]) as $column): ?>
                                        <th><?php echo ucfirst(str_replace('_', ' ', $column)); ?></th>
                                        <?php endforeach; ?>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($data as $row): ?>
                                    <tr>
                                        <?php foreach($row as $value): ?>
                                        <td><?php echo htmlspecialchars($value); ?></td>
                                        <?php endforeach; ?>
                                        <td>
                                            <form method="POST" style="display: inline;">
                                                <input type="hidden" name="action" value="delete_record">
                                                <input type="hidden" name="database" value="<?php echo $selectedDb; ?>">
                                                <input type="hidden" name="table" value="<?php echo $table; ?>">
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php 
                    endif;
                endforeach; 
                ?>
            </main>
        </div>
    </div>

    <!-- Modals -->
    <?php include 'modals.php'; ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.body.style.zoom = "85%";
        });
        const userName = "<?php echo $user_email_admin; ?>";
        document.getElementById('profile-initial').innerText = userName.slice(0, 2).toUpperCase();
        document.getElementById('username').innerText = userName;
        const profileToggle = document.getElementById('profile-toggle');
        const dropdownMenu = document.getElementById('dropdown-menu');
        profileToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
        });
        window.addEventListener('click', function () {
            dropdownMenu.style.display = 'none';
        });
        document.getElementById('logout-btn').addEventListener('click', function (e) {
            e.preventDefault();
            window.location.href = 'logout_admin.php';
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>