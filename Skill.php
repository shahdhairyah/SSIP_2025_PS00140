<?php
// Include database connection and functions
require_once 'functions_s.php';

// Get dashboard data
$stats = getDashboardMetrics_s();
$topskills = getTopSkills();
$trainigenrolls = getTrainingEnrollment();
$projects = getProjects_s();
$reports = getReports_s();
$trainigpro=getTrainingPrograms();
$notifications1 = getNotifications_s();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skill Development Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="style_L_A.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include 'sidebar_s.php'; ?>

            <!-- Main Content -->
            <main class="col-lg-10 col-md-9 ms-auto main-content">
                <!-- Top Navigation -->
                <?php include 'topnav.php'; ?>

                <!-- Department Header -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h2 class="page-title">Skill Development Dashboard</h2>
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
                            <h5 class="card-title mb-0">Training Program Enrollment</h5>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                    <canvas id="training_enrollment"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                <div class="card dashboard-card">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Top Skills in Demand</h5>
                    </div>
                    <div class="card-body">
                        <?php foreach ($topskills as $skill): ?>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span><?php echo htmlspecialchars($skill['skill_name']); ?></span>
                                    <span><?php echo htmlspecialchars($skill['demand_percentage']) . '%'; ?></span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: <?php echo htmlspecialchars($skill['demand_percentage']); ?>%; background-color: #007bff;"
                                        aria-valuenow="<?php echo htmlspecialchars($skill['demand_percentage']); ?>"
                                        aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
                                  

                <!-- Upcoming Training Programs -->
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="card dashboard-card">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Upcoming Training Programs</h5>
                                <button class="btn btn-sm btn-outline-primary">View All</button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Program ID</th>
                                                <th>Program Name</th>
                                                <th>Start Date</th>
                                                <th>Duration</th>
                                                <th>Location</th>
                                                <th>Seats</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($trainigpro as $training): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($training['program_id']); ?></td>
                                                <td><?php echo htmlspecialchars($training['program_name']); ?></td>
                                                <td><?php echo htmlspecialchars($training['start_date']); ?></td>
                                                <td><?php echo htmlspecialchars($training['duration']); ?></td>
                                                <td><?php echo htmlspecialchars($training['location']); ?></td>
                                                <td><?php echo htmlspecialchars($training['booked_seats']); echo'/'; echo htmlspecialchars($training['total_seats']); ?></td>
                                                <td>
                                                    <span class="badge bg-<?php echo htmlspecialchars($training['status_class'] ?? 'secondary'); ?>">
                                                        <?php echo htmlspecialchars($training['status']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="training_program.php?id=<?php echo htmlspecialchars($training['id']); ?>" class="btn btn-sm btn-outline-primary">View Report</a>
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
                                        <td><?php echo htmlspecialchars($project['project_name']); ?></td>
                                        <td><?php echo htmlspecialchars($project['department']); ?></td>
                                        <td><?php echo htmlspecialchars($project['start_date']); ?></td>
                                        <td><?php echo htmlspecialchars($project['deadline']); ?></td>
                                        <td><?php echo htmlspecialchars($project['budget']); ?></td>
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
                                            <a href="view_project_s.php?id=<?php echo htmlspecialchars($project['id']); ?>" class="btn btn-sm btn-outline-primary">View</a>
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
                                <td><?php echo htmlspecialchars($report['report_name']); ?></td>
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
    // Fetch and render 
    fetch('charts_s.php?chart=training_enrollment')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('training_enrollment').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [
                        {
                            label: 'IT Software',
                            data: data.it_software,
                            borderColor: '#3498db',
                            backgroundColor: 'rgba(52, 152, 219, 0.1)',
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'Manufacturing',
                            data: data.manufacturing,
                            borderColor: '#e67e22',
                            backgroundColor: 'rgba(230, 126, 34, 0.1)',
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'Healthcare',
                            data: data.healthcare,
                            borderColor: '#2ecc71',
                            backgroundColor: 'rgba(46, 204, 113, 0.1)',
                            tension: 0.4,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: { display: true, text: 'Performance Score' }
                        }
                    }
                }
            });
        })
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
