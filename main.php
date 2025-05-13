<?php
// Get the data
include_once 'functions.php';
$inspections = getInspections();
$stats = getDashboardMetrics();
$employees = getEmployees();
include_once 'functions_s.php';
$trainingPrograms = getTrainingPrograms();
$dept_progress = getDepartmentProgress();
$stats_s = getDashboardMetrics_s();
$topskills = getTopSkills();
$reports = getReports_s();
include_once 'functions_e.php';
$jobPlacements = getJobPlacement_e();
$stats_e = getDashboardMetrics_e();
$projects = getProjects_e();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="style_main.css">
</head>
<body class="bg-light">
    <div class="container-fluid py-4">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
           <?php include 'sidebar_main.php'; ?>
           <main class="col-lg-10 col-md-9 ms-auto main-content">
           <!-- Top Nav -->
            <?php include 'topnav.php'; ?>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


            <!-- Main Content -->
            <!-- <main class="col-lg-10 col-md-9 ms-auto main-content"> -->
                <!-- Department Header -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h2 class="page-title">All Department Info</h2>
                    </div>
                </div>
            <!-- Recent Activities & Project Status -->
            <div class="row">
              <div class="col-lg-6 mb-4">
                <div class="card dashboard-card">
                  <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Recent Activities</h5>
                    <button class="btn btn-sm btn-outline-primary">View All</button>
                  </div>
                  <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                      <div class="list-group-item border-0 py-3">
                        <div class="d-flex">
                          <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2">
                              <i class="bi bi-file-earmark-text"></i>
                            </div>
                          </div>
                          <div class="ms-3">
                            <h6 class="mb-1">New policy document uploaded</h6>
                            <p class="text-muted mb-0">Labour Department • 2 hours ago</p>
                          </div>
                        </div>
                      </div>
                      <div class="list-group-item border-0 py-3">
                        <div class="d-flex">
                          <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 text-success rounded-circle p-2">
                              <i class="bi bi-calendar-event"></i>
                            </div>
                          </div>
                          <div class="ms-3">
                            <h6 class="mb-1">Quarterly review meeting scheduled</h6>
                            <p class="text-muted mb-0">Skill Development • Yesterday</p>
                          </div>
                        </div>
                      </div>
                      <div class="list-group-item border-0 py-3">
                        <div class="d-flex">
                          <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-2">
                              <i class="bi bi-graph-up"></i>
                            </div>
                          </div>
                          <div class="ms-3">
                            <h6 class="mb-1">Employment statistics updated</h6>
                            <p class="text-muted mb-0">Employment Department • 2 days ago</p>
                          </div>
                        </div>
                      </div>
                      <div class="list-group-item border-0 py-3">
                        <div class="d-flex">
                          <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 text-info rounded-circle p-2">
                              <i class="bi bi-people"></i>
                            </div>
                          </div>
                          <div class="ms-3">
                            <h6 class="mb-1">New staff onboarding completed</h6>
                            <p class="text-muted mb-0">Industrial Relations • 3 days ago</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 mb-4">
        <div class="card dashboard-card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Project Status</h5>
        </div>
        <div class="card-body">
            <?php foreach ($dept_progress as $progress): ?>
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-1">
                        <span><?php echo htmlspecialchars($progress['dept_name']); ?></span>
                        <span><?php echo $progress['dept_progress']; ?></span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-<?php echo $progress['status_class']; ?>" role="progressbar" style="width: <?php echo $progress['dept_progress']; ?>" aria-valuenow="<?php echo $progress['dept_progress']; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            <?php endforeach; ?>
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
                                            <a href="view_project_e.php?id=<?php echo htmlspecialchars($project['id']); ?>" class="btn btn-sm btn-outline-primary">View</a>
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
                <div class="row">
              <div class="col-lg-6 mb-4">
                <div class="card dashboard-card">
                  <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Project Budget Allocation</h5>
                  </div>
                  <div class="card-body">
                    <div class="chart-container">
                      <canvas id="projectBudgetChart"></canvas>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-lg-6 mb-4">
                <div class="card dashboard-card">
                  <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Project Status Distribution</h5>
                  </div>
                  <div class="card-body">
                    <div class="chart-container">
                      <canvas id="projectStatusChart"></canvas>
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
            <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card dashboard-card">
                  <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Report Generation Frequency</h5>
                  </div>
                  <div class="card-body">
                    <div class="chart-container">
                    <canvas id="reportFrequencyChart"></canvas>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-lg-6 mb-4">
                <div class="card dashboard-card">
                  <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Reports by Department</h5>
                  </div>
                  <div class="card-body">
                    <div class="chart-container">
                      <canvas id="reportDepartmentChart"></canvas>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Department Structure -->
                  <div class="department-section">
                      <div class="department-header">
                        <h3 class="department-title">Labour Department</h3>
                        <span class="badge bg-primary">12 Sub-departments</span>
                      </div>
                      <div class="row">
                        <div class="col-md-4 mb-3">
                          <div class="sub-department-card labour-dept">
                            <h5>Labour Welfare</h5>
                            <p class="mb-0 text-muted">Manages welfare schemes for laborers</p>
                          </div>
                        </div>
                        <div class="col-md-4 mb-3">
                          <div class="sub-department-card labour-dept">
                            <h5>Labour Enforcement</h5>
                            <p class="mb-0 text-muted">Ensures compliance with labour laws</p>
                          </div>
                        </div>
                        <div class="col-md-4 mb-3">
                          <div class="sub-department-card labour-dept">
                            <h5>Labour Statistics</h5>
                            <p class="mb-0 text-muted">Collects and analyzes labour data</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <div class="department-section">
                      <div class="department-header">
                        <h3 class="department-title">Skill Development Department</h3>
                        <span class="badge bg-success">8 Sub-departments</span>
                      </div>
                      <div class="row">
                        <div class="col-md-4 mb-3">
                          <div class="sub-department-card skill-dept">
                            <h5>Training Programs</h5>
                            <p class="mb-0 text-muted">Manages vocational training initiatives</p>
                          </div>
                        </div>
                        <div class="col-md-4 mb-3">
                          <div class="sub-department-card skill-dept">
                            <h5>Certification</h5>
                            <p class="mb-0 text-muted">Handles skill certification processes</p>
                          </div>
                        </div>
                        <div class="col-md-4 mb-3">
                          <div class="sub-department-card skill-dept">
                            <h5>Industry Partnerships</h5>
                            <p class="mb-0 text-muted">Coordinates with industry for skill needs</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <div class="department-section">
                      <div class="department-header">
                        <h3 class="department-title">Employment Department</h3>
                        <span class="badge bg-danger">10 Sub-departments</span>
                      </div>
                      <div class="row">
                        <div class="col-md-4 mb-3">
                          <div class="sub-department-card employment-dept">
                            <h5>Job Placement</h5>
                            <p class="mb-0 text-muted">Facilitates employment opportunities</p>
                          </div>
                        </div>
                        <div class="col-md-4 mb-3">
                          <div class="sub-department-card employment-dept">
                            <h5>Career Counseling</h5>
                            <p class="mb-0 text-muted">Provides guidance on career paths</p>
                          </div>
                        </div>
                        <div class="col-md-4 mb-3">
                          <div class="sub-department-card employment-dept">
                            <h5>Employment Exchanges</h5>
                            <p class="mb-0 text-muted">Manages employment registration centers</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
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
            </div>
            </section>
        </main>
      </div>
    </div>
  </div>
    <script>
  //       // Department Performance Chart (Dynamic)
  //       fetch('charts.php?chart=department_performance')
  //       .then(response => response.json())
  //       .then(data => {
  //           const ctx = document.getElementById('departmentPerformanceChart').getContext('2d');
  //           new Chart(ctx, {
  //           type: 'line',
  //           data: {
  //               labels: data.labels,
  //               datasets: [{
  //               label: 'Labour',
  //               data: data.data,
  //               borderColor: '#3498db',
  //               backgroundColor: 'rgba(52, 152, 219, 0.1)',
  //               tension: 0.4,
  //               fill: true
  //               }]
  //           },
  //           options: {
  //               responsive: true,
  //               maintainAspectRatio: false,
  //               scales: {
  //               y: {
  //                   beginAtZero: true,
  //                   max: 100,
  //                   title: { display: true, text: 'Performance Score' }
  //               }
  //               }
  //           }
  //           });
  //       });

  //       // // Labour Welfare Chart (Dynamic)
  //       fetch('charts.php?chart=labour_welfare')
  //       .then(response => response.json())
  //       .then(data => {
  //           if (document.getElementById('labourWelfareChart')) {
  //           const ctx = document.getElementById('labourWelfareChart').getContext('2d');
  //           new Chart(ctx, {
  //               type: 'bar',
  //               data: {
  //               labels: data.labels,
  //               datasets: [
  //                   {
  //                   label: 'Target',
  //                   data: data.target,
  //                   backgroundColor: 'rgba(52, 152, 219, 0.2)',
  //                   borderColor: 'rgba(52, 152, 219, 1)',
  //                   borderWidth: 1
  //                   },
  //                   {
  //                   label: 'Achieved',
  //                   data: data.achieved,
  //                   backgroundColor: 'rgba(46, 204, 113, 0.2)',
  //                   borderColor: 'rgba(46, 204, 113, 1)',
  //                   borderWidth: 1
  //                   }
  //               ]
  //               },
  //               options: {
  //               responsive: true,
  //               maintainAspectRatio: false,
  //               scales: {
  //                   y: {
  //                   beginAtZero: true,
  //                   title: { display: true, text: 'Beneficiaries' }
  //                   }
  //               }
  //               }
  //           });
  //           }
  //       });
  // // Fetch and render 
  // fetch('charts_e.php?chart=employment_trends')
  //   .then(response => response.json())
  //   .then(data => {
  //       const ctx = document.getElementById('employmentTrendsChart').getContext('2d');
  //       new Chart(ctx, {
  //           type: 'line',
  //           data: {
  //               labels: data.labels,
  //               datasets: [
  //                   {
  //                       label: 'Job Seekers',
  //                       data: data.job_seekers,
  //                       borderColor: '#e74c3c',
  //                       backgroundColor: 'rgba(231, 76, 60, 0.1)',
  //                       tension: 0.4,
  //                       fill: true
  //                   },
  //                   {
  //                       label: 'Placements',
  //                       data: data.placements,
  //                       borderColor: '#2ecc71',
  //                       backgroundColor: 'rgba(46, 204, 113, 0.1)',
  //                       tension: 0.4,
  //                       fill: true
  //                   }
  //               ]
  //           },
  //           options: {
  //               responsive: true,
  //               maintainAspectRatio: false,
  //               scales: {
  //                   y: {
  //                       beginAtZero: true,
  //                       title: { display: true, text: 'Number of People' }
  //                   }
  //               }
  //           }
  //       });
  //   });

  //   fetch('charts_e.php?chart=job_sectors')
  //   .then(response => response.json())
  //   .then(data => {
  //       const ctx = document.getElementById('jobSectorsChart').getContext('2d');
  //       new Chart(ctx, {
  //           type: 'pie',
  //           data: {
  //               labels: data.labels,
  //               datasets: [{
  //                   label: 'Number of Employees',
  //                   data: data.count,
  //                   backgroundColor: [
  //                       '#3498db', // IT & Software (Blue)
  //                       '#2ecc71', // Manufacturing (Green)
  //                       '#e74c3c', // Healthcare (Red)
  //                       '#f1c40f', // Education (Yellow)
  //                       '#9b59b6', // Retail (Purple)
  //                       '#34495e'  // Others (Dark Gray)
  //                   ]
  //               }]
  //           },
  //           options: {
  //               responsive: true,
  //               maintainAspectRatio: false
  //           }
  //       });
  //   });
  //   fetch('charts_s.php?chart=training_enrollment')
  //       .then(response => response.json())
  //       .then(data => {
  //           const ctx = document.getElementById('training_enrollment').getContext('2d');
  //           new Chart(ctx, {
  //               type: 'line',
  //               data: {
  //                   labels: data.labels,
  //                   datasets: [
  //                       {
  //                           label: 'IT Software',
  //                           data: data.it_software,
  //                           borderColor: '#3498db',
  //                           backgroundColor: 'rgba(52, 152, 219, 0.1)',
  //                           tension: 0.4,
  //                           fill: true
  //                       },
  //                       {
  //                           label: 'Manufacturing',
  //                           data: data.manufacturing,
  //                           borderColor: '#e67e22',
  //                           backgroundColor: 'rgba(230, 126, 34, 0.1)',
  //                           tension: 0.4,
  //                           fill: true
  //                       },
  //                       {
  //                           label: 'Healthcare',
  //                           data: data.healthcare,
  //                           borderColor: '#2ecc71',
  //                           backgroundColor: 'rgba(46, 204, 113, 0.1)',
  //                           tension: 0.4,
  //                           fill: true
  //                       }
  //                   ]
  //               },
  //               options: {
  //                   responsive: true,
  //                   maintainAspectRatio: false,
  //                   scales: {
  //                       y: {
  //                           beginAtZero: true,
  //                           title: { display: true, text: 'Performance Score' }
  //                       }
  //                   }
  //               }
  //           });
  //       })
        fetch('charts_main.php?chart=project_budget')
    .then(response => response.json())
    .then(data => {
        const ctx = document.getElementById('projectBudgetChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [
                    {
                        label: 'Allocated Budget',
                        data: data.allocated_budget,
                        backgroundColor: 'rgba(52, 152, 219, 0.5)',
                        borderColor: '#3498db',
                        borderWidth: 1
                    },
                    {
                        label: 'Utilized Budget',
                        data: data.utilized_budget,
                        backgroundColor: 'rgba(46, 204, 113, 0.5)',
                        borderColor: '#2ecc71',
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
                        title: { display: true, text: 'Budget (in Lakhs ₹)' }
                    }
                }
            }
        });
    })
    .catch(error => console.error('Error fetching data:', error));

    fetch('charts_main.php?chart=project_status')
    .then(response => response.json())
    .then(data => {
      const ctx = document.getElementById('projectStatusChart').getContext('2d');
      new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: data.labels,
          datasets: [
            {
              label: 'Status',
              data: data.percentage,
              backgroundColor: [
                '#2ecc71',
              '#f39c12',
              '#e74c3c',
              '#3498db' // Completed (Blue)// Delayed (Red)
              ]
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false
        }
      });
    });
// Fetch and render Report Frequency Bar Chart
fetch('charts_main.php?chart=report_frequency')
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('reportFrequencyChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Number of Reports',
                            data: data.reports,
                            backgroundColor: ['#3498db', '#2ecc71', '#f39c12', '#e74c3c', '#9b59b6'],
                            borderColor: '#333',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: { display: true, text: 'Number of Reports' }
                            }
                        }
                    }
                });
            });

        // Fetch and render Reports by Department Pie Chart
        fetch('charts_main.php?chart=report_department')
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('reportDepartmentChart').getContext('2d');
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            data: data.percentages,
                            backgroundColor: ['#3498db', '#2ecc71', '#e74c3c', '#f39c12', '#9b59b6']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
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