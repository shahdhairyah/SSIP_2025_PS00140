<?php
// Include database connection and functions
require_once 'functions.php';

// Get dashboard data
$stats = getDashboardMetrics();
$employees = getEmployees();
$inspections = getInspections();
$projects = getProjects();
$reports = getReports();
$notifications1 = getNotifications();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Labour Department Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="style_L_A.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include 'sidebar.php'; ?>

            <!-- Main Content -->
            <main class="col-lg-10 col-md-9 ms-auto main-content">
                <!-- Top Navigation -->
                <?php include 'topnav.php'; ?>

                <!-- Department Header -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h2 class="page-title">Labour Department Dashboard</h2>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="row mb-4">
                    <?php foreach ($stats as $stat): ?>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card dashboard-card stat-card labour-dept">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted"><?php echo htmlspecialchars($stat['metric_name']); ?></h6>
                                        <h3 class="mb-0"><?php echo htmlspecialchars($stat['metric_value']); ?></h3>
                                    </div>
                                    <div class="card-icon bg-primary bg-opacity-10 text-primary">
                                        <i class="bi <?php echo htmlspecialchars($stat['icon']); ?>"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Charts Section -->
                <div class="row">
                    <div class="col-lg-8 mb-4">
                        <div class="card dashboard-card">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0">Department Performance</h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="departmentPerformanceChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 mb-4">
                        <div class="card dashboard-card">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0">Key Personnel</h5>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($employees as $person): ?>
                                    <li class="list-group-item d-flex align-items-center">
                                        <img src="<?php echo htmlspecialchars($person['img']); ?>" 
                                             class="rounded-circle me-3" 
                                             width="40" height="40" 
                                             alt="<?php echo htmlspecialchars($person['name']); ?>">
                                        <div>
                                            <h6 class="mb-0"><?php echo htmlspecialchars($person['name']); ?></h6>
                                            <small class="text-muted"><?php echo htmlspecialchars($person['role']); ?></small>
                                        </div>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                                  
                <!-- Welfare Projects Chart -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card dashboard-card">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0">Labour Welfare Schemes Performance</h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="labourWelfareChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Inspections -->
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="card dashboard-card">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Recent Inspections</h5>
                                <button class="btn btn-sm btn-outline-primary">View All</button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Establishment</th>
                                                <th>Date</th>
                                                <th>Inspector</th>
                                                <th>Status</th>
                                                <th>Action</th> <!-- New Action Column -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($inspections as $inspection): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($inspection['id']); ?></td>
                                                <td><?php echo htmlspecialchars($inspection['establishment']); ?></td>
                                                <td><?php echo htmlspecialchars($inspection['date']); ?></td>
                                                <td><?php echo htmlspecialchars($inspection['inspector']); ?></td>
                                                <td>
                                                    <span class="badge bg-<?php echo htmlspecialchars($inspection['status_class'] ?? 'secondary'); ?>">
                                                        <?php echo htmlspecialchars($inspection['status']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="inspection_details.php?id=<?php echo htmlspecialchars($inspection['id']); ?>" class="btn btn-sm btn-outline-primary">View Report</a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Projects Section -->
                <section id="projects-section" class="content-section">
                <h2 class="page-title">Projects</h2>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="card dashboard-card">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Project Overview</h5>
                                <button class="btn btn-sm btn-outline-primary">View All</button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Project Name</th>
                                        <th>Department</th>
                                        <th>Start Date</th>
                                        <th>Deadline</th>
                                        <th>Budget</th>
                                        <th>Status</th>
                                        <th>Progress</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($projects as $project): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($project['name']); ?></td>
                                        <td><?php echo htmlspecialchars($project['department']); ?></td>
                                        <td><?php echo htmlspecialchars($project['start_date']); ?></td>
                                        <td><?php echo htmlspecialchars($project['deadline']); ?></td>
                                        <td>₹<?php echo htmlspecialchars($project['budget']); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo htmlspecialchars($project['status_class'] ?? 'secondary'); ?>">
                                                <?php echo htmlspecialchars($project['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 10px;">
                                                <div class="progress-bar bg-<?php echo htmlspecialchars($project['status_class'] ?? 'primary'); ?>" 
                                                    role="progressbar" 
                                                    style="width: <?php echo htmlspecialchars($project['progress']); ?>%;" 
                                                    aria-valuenow="<?php echo htmlspecialchars($project['progress']); ?>" 
                                                    aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                            <small><?php echo htmlspecialchars($project['progress']); ?>%</small>
                                        </td>
                                        <td>
                                            <a href="view_project.php?id=<?php echo htmlspecialchars($project['id']); ?>" class="btn btn-sm btn-outline-primary">View</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container mt-4">
                <h2>Reports</h2>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Report Name</th>
                            <th>Department</th>
                            <th>Generated On</th>
                            <th>Generated By</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php foreach ($reports as $report): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($report['name']); ?></td>
                                <td><?php echo htmlspecialchars($report['department']); ?></td>
                                <td><?php echo htmlspecialchars($report['generated_on']); ?></td>
                                <td><?php echo htmlspecialchars($report['generated_by']); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo htmlspecialchars($report['type_class']); ?>">
                                        <?php echo htmlspecialchars($report['type']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="view_report.php?id=<?php echo $report['id']; ?>" class="btn btn-outline-primary btn-sm">View</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <section id="notifications-section" class="content-section">
            <h2 class="page-title">Notifications</h2>

            <div class="row mb-4">
                <div class="col-12">
                <div class="card dashboard-card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Recent Notifications</h5>
                    </div>
                    <div class="card-body p-0">
                    <div class="list-group list-group-flush" id="notifications-list">
                        <!-- Notifications will be loaded here dynamically -->
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </section>
        </main>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Department Performance Chart (Dynamic)
        fetch('charts.php?chart=department_performance')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('departmentPerformanceChart').getContext('2d');
            new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [{
                label: 'Labour',
                data: data.data,
                borderColor: '#3498db',
                backgroundColor: 'rgba(52, 152, 219, 0.1)',
                tension: 0.4,
                fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    title: { display: true, text: 'Performance Score' }
                }
                }
            }
            });
        });

        // Labour Welfare Chart (Dynamic)
        fetch('charts.php?chart=labour_welfare')
        .then(response => response.json())
        .then(data => {
            if (document.getElementById('labourWelfareChart')) {
            const ctx = document.getElementById('labourWelfareChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                labels: data.labels,
                datasets: [
                    {
                    label: 'Target',
                    data: data.target,
                    backgroundColor: 'rgba(52, 152, 219, 0.2)',
                    borderColor: 'rgba(52, 152, 219, 1)',
                    borderWidth: 1
                    },
                    {
                    label: 'Achieved',
                    data: data.achieved,
                    backgroundColor: 'rgba(46, 204, 113, 0.2)',
                    borderColor: 'rgba(46, 204, 113, 1)',
                    borderWidth: 1
                    }
                ]
                },
                options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Beneficiaries' }
                    }
                }
                }
            });
            }
        });
        document.addEventListener("DOMContentLoaded", function () {
    fetch("fetch_notifications.php")
      .then(response => response.json())
      .then(data => {
        const container = document.getElementById("notifications-list");
        container.innerHTML = ""; // Clear previous notifications

        data.forEach(notification => {
          const notificationItem = `
            <div class="notification-item d-flex p-3 border-bottom">
              <div class="flex-shrink-0">
                <div class="bg-${notification.type} bg-opacity-10 text-${notification.type} rounded-circle p-2">
                  <i class="bi ${notification.icon}"></i>
                </div>
              </div>
              <div class="ms-3 flex-grow-1">
                <div class="d-flex justify-content-between align-items-center">
                  <h6 class="mb-1">${notification.title}</h6>
                  <small class="notification-time">${notification.time_elapsed}</small>
                </div>
                <p class="text-muted mb-0">${notification.message}</p>
              </div>
            </div>
          `;
          container.innerHTML += notificationItem;
        });
      })
      .catch(error => console.error("Error loading notifications:", error));
  });
    </script>
</body>
</html>
