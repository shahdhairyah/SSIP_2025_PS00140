<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Redirect only if both session variables ARE set
if (!isset($_SESSION['user_email']) && !isset($_SESSION['user_fullname'])) {
  header("Location: index.html");
  exit;
}
// Set the name if available
$userFullName = $_SESSION['user_fullname'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #0d6efd;
      --secondary-color: #6c757d;
      --accent-color: #ffc107;
      --dark-color: #343a40;
      --light-color: #f8f9fa;
    }
    
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f5f7fa;
    }
    
    .navbar-brand img {
      height: 50px;
    }
    
    .navbar {
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    .hero-section {
      background: linear-gradient(rgba(13, 110, 253, 0.8), rgba(13, 110, 253, 0.9)), url('https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80');
      background-size: cover;
      background-position: center;
      color: white;
      padding: 5rem 0;
      margin-bottom: 2rem;
    }
    
    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      margin-bottom: 20px;
      overflow: hidden;
    }
    
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    
    .card-img-top {
      height: 180px;
      object-fit: cover;
    }
    
    .department-card .card-header {
      background-color: var(--primary-color);
      color: white;
      font-weight: bold;
      padding: 15px;
    }
    
    .department-card .card-body {
      padding: 20px;
    }
    
    .btn-primary {
      background-color: var(--primary-color);
      border: none;
      padding: 8px 20px;
      border-radius: 5px;
    }
    
    .btn-primary:hover {
      background-color: #0b5ed7;
    }
    
    .stats-card {
      background-color: white;
      border-radius: 10px;
      padding: 20px;
      text-align: center;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }
    
    .stats-card i {
      font-size: 2.5rem;
      color: var(--primary-color);
      margin-bottom: 15px;
    }
    
    .stats-card h3 {
      font-size: 2rem;
      font-weight: bold;
      margin-bottom: 5px;
    }
    
    .stats-card p {
      color: var(--secondary-color);
      margin-bottom: 0;
    }
    
    .news-card {
      height: 100%;
    }
    
    .news-date {
      font-size: 0.8rem;
      color: var(--secondary-color);
    }
    
    .sidebar {
      background-color: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .sidebar h4 {
      border-bottom: 2px solid var(--primary-color);
      padding-bottom: 10px;
      margin-bottom: 15px;
    }
    
    .sidebar ul {
      padding-left: 0;
      list-style-type: none;
    }
    
    .sidebar ul li {
      padding: 8px 0;
      border-bottom: 1px solid #eee;
    }
    
    .sidebar ul li:last-child {
      border-bottom: none;
    }
    
    .sidebar ul li a {
      color: var(--dark-color);
      text-decoration: none;
      transition: color 0.3s ease;
    }
    
    .sidebar ul li a:hover {
      color: var(--primary-color);
    }
    
    footer {
      background-color: var(--dark-color);
      color: white;
      padding: 3rem 0;
      margin-top: 3rem;
    }
    
    .footer-links h5 {
      color: var(--accent-color);
      margin-bottom: 15px;
    }
    
    .footer-links ul {
      padding-left: 0;
      list-style-type: none;
    }
    
    .footer-links ul li {
      margin-bottom: 10px;
    }
    
    .footer-links ul li a {
      color: #adb5bd;
      text-decoration: none;
      transition: color 0.3s ease;
    }
    
    .footer-links ul li a:hover {
      color: white;
    }
    
    .social-icons a {
      color: white;
      font-size: 1.5rem;
      margin-right: 15px;
      transition: color 0.3s ease;
    }
    
    .social-icons a:hover {
      color: var(--accent-color);
    }
    
    .dashboard-tabs .nav-link {
      color: var(--dark-color);
      border: none;
      padding: 15px 20px;
      border-radius: 0;
      font-weight: 500;
    }
    
    .dashboard-tabs .nav-link.active {
      color: var(--primary-color);
      background-color: transparent;
      border-bottom: 3px solid var(--primary-color);
    }
    
    .dashboard-tabs .tab-content {
      padding: 20px 0;
    }
    
    .announcement {
      background-color: #e7f5ff;
      border-left: 4px solid var(--primary-color);
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 5px;
    }
    
    .modal-content {
      border-radius: 10px;
      overflow: hidden;
    }
    
    .modal-header {
      background-color: var(--primary-color);
      color: white;
    }
    
    .modal-body {
      padding: 20px;
    }
    
    #departmentChart {
      width: 100%;
      height: 300px;
    }
    
    .search-box {
      position: relative;
      margin-bottom: 20px;
    }
    
    .search-box input {
      padding-left: 40px;
      border-radius: 20px;
    }
    
    .search-box i {
      position: absolute;
      left: 15px;
      top: 10px;
      color: var(--secondary-color);
    }
    
    @media (max-width: 768px) {
      .hero-section {
        padding: 3rem 0;
      }
      
      .stats-card {
        margin-bottom: 15px;
      }
      
      .sidebar {
        margin-top: 20px;
      }
    }
  </style>
</head>
<body>
  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="#">
        <i class="fas fa-building text-primary me-2" style="font-size: 2rem;"></i>
        <span class="fw-bold">Departments</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" href="./dashboard.html">Home</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
              Departments
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="./Labour.php" data-bs-toggle="modal">Labour Department</a></li>
              <li><a class="dropdown-item" href="./Skill.html" data-bs-toggle="modal">Skill department</a></li>
              <li><a class="dropdown-item" href="./Employment.html" data-bs-toggle="modal">Employment department</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#contact">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero-section" id="home">
    <div class="container text-center">
      <h1 class="display-4 fw-bold mb-4">Labour, Skill Development & Employment Department</h1>
      <p class="lead mb-4">Connecting departments, empowering citizens, and streamlining services</p>
      <div class="d-flex justify-content-center">
        <a href="#departments" class="btn btn-light btn-lg me-3">Explore Departments</a>
        <a href="#services" class="btn btn-outline-light btn-lg">Our Services</a>
      </div>
    </div>
  </section>

  <!-- Main Content -->
  <div class="container">
    <div class="row">
      <!-- Main Content Area -->
      <div class="col-lg-8">
        <!-- Department Stats -->
        <div class="row mb-4">
          <div class="col-12">
            <h2 class="mb-4">Department Overview</h2>
          </div>
          <div class="col-md-3 col-6">
            <div class="stats-card">
              <i class="fas fa-building"></i>
              <h3>12</h3>
              <p>Departments</p>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="stats-card">
              <i class="fas fa-users"></i>
              <h3>5.2K</h3>
              <p>Employees</p>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="stats-card">
              <i class="fas fa-file-alt"></i>
              <h3>850+</h3>
              <p>Active Projects</p>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="stats-card">
              <i class="fas fa-handshake"></i>
              <h3>320+</h3>
              <p>Partnerships</p>
            </div>
          </div>
        </div>

        <!-- Announcements -->
        <div class="announcement mb-4">
          <h5><i class="fas fa-bullhorn me-2"></i> Important Announcement</h5>
          <p class="mb-0">New employment scheme for youth to be launched next month. Registration starts from June 15, 2025.</p>
        </div>

        <!-- Dashboard Tabs -->
        <div class="dashboard-tabs mb-4">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="departments-tab" data-bs-toggle="tab" data-bs-target="#departments-tab-pane" type="button" role="tab">Departments</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="services-tab" data-bs-toggle="tab" data-bs-target="#services-tab-pane" type="button" role="tab">Services</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="initiatives-tab" data-bs-toggle="tab" data-bs-target="#initiatives-tab-pane" type="button" role="tab">Initiatives</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="reports-tab" data-bs-toggle="tab" data-bs-target="#reports-tab-pane" type="button" role="tab">Reports</button>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <!-- Departments Tab -->
            <div class="tab-pane fade show active" id="departments-tab-pane" role="tabpanel" aria-labelledby="departments-tab" tabindex="0">
              <div class="row" id="departments">
                <div class="col-md-6">
                  <div class="card department-card mb-4">
                    <div class="card-header">
                      <i class="fas fa-hard-hat me-2"></i> Labour Department
                    </div>
                    <div class="card-body">
                      <p>Oversees labor laws, industrial relations, and worker welfare programs.</p>
                      <div class="d-flex justify-content-between align-items-center">
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#departmentModal" data-department="Labour Department">View Details</a>
                        <span class="badge bg-success">Active</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card department-card mb-4">
                    <div class="card-header">
                      <i class="fas fa-graduation-cap me-2"></i> Skill Development
                    </div>
                    <div class="card-body">
                      <p>Focuses on vocational training, skill enhancement, and certification programs.</p>
                      <div class="d-flex justify-content-between align-items-center">
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#departmentModal" data-department="Skill Development">View Details</a>
                        <span class="badge bg-success">Active</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card department-card mb-4">
                    <div class="card-header">
                      <i class="fas fa-briefcase me-2"></i> Employment Exchange
                    </div>
                    <div class="card-body">
                      <p>Facilitates job matching, career counseling, and employment opportunities.</p>
                      <div class="d-flex justify-content-between align-items-center">
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#departmentModal" data-department="Employment Exchange">View Details</a>
                        <span class="badge bg-success">Active</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card department-card mb-4">
                    <div class="card-header">
                      <i class="fas fa-industry me-2"></i> Industrial Safety
                    </div>
                    <div class="card-body">
                      <p>Ensures workplace safety standards, inspections, and regulatory compliance.</p>
                      <div class="d-flex justify-content-between align-items-center">
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#departmentModal" data-department="Industrial Safety">View Details</a>
                        <span class="badge bg-success">Active</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Services Tab -->
            <div class="tab-pane fade" id="services-tab-pane" role="tabpanel" aria-labelledby="services-tab" tabindex="0">
              <div class="row" id="services">
                <div class="col-md-6">
                  <div class="card mb-4">
                    <div class="card-body">
                      <h5 class="card-title"><i class="fas fa-id-card me-2 text-primary"></i> Labor Registration</h5>
                      <p class="card-text">Register as a worker to access various government schemes and benefits.</p>
                      <a href="#" class="btn btn-primary">Apply Now</a>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card mb-4">
                    <div class="card-body">
                      <h5 class="card-title"><i class="fas fa-building me-2 text-primary"></i> Employer Registration</h5>
                      <p class="card-text">Register your business to comply with labor laws and access talent pool.</p>
                      <a href="#" class="btn btn-primary">Register</a>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card mb-4">
                    <div class="card-body">
                      <h5 class="card-title"><i class="fas fa-certificate me-2 text-primary"></i> Skill Certification</h5>
                      <p class="card-text">Get your skills certified through government-recognized programs.</p>
                      <a href="#" class="btn btn-primary">Apply</a>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card mb-4">
                    <div class="card-body">
                      <h5 class="card-title"><i class="fas fa-search me-2 text-primary"></i> Job Search</h5>
                      <p class="card-text">Find employment opportunities across various sectors and locations.</p>
                      <a href="#" class="btn btn-primary">Search Jobs</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Initiatives Tab -->
            <div class="tab-pane fade" id="initiatives-tab-pane" role="tabpanel" aria-labelledby="initiatives-tab" tabindex="0">
              <div class="row">
                <div class="col-md-6">
                  <div class="card mb-4">
                    <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80" class="card-img-top" alt="Youth Skill Development">
                    <div class="card-body">
                      <h5 class="card-title">Youth Skill Development Program</h5>
                      <p class="card-text">Comprehensive training program for youth to enhance employability.</p>
                      <a href="#" class="btn btn-primary">Learn More</a>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card mb-4">
                    <img src="https://images.unsplash.com/photo-1573497620053-ea5300f94f21?ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80" class="card-img-top" alt="Women Empowerment">
                    <div class="card-body">
                      <h5 class="card-title">Women Empowerment Initiative</h5>
                      <p class="card-text">Special programs for women to enter workforce and develop entrepreneurial skills.</p>
                      <a href="#" class="btn btn-primary">Learn More</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Reports Tab -->
            <div class="tab-pane fade" id="reports-tab-pane" role="tabpanel" aria-labelledby="reports-tab" tabindex="0">
              <div class="row">
                <div class="col-12 mb-4">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Department Performance Overview</h5>
                      <canvas id="departmentChart"></canvas>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card mb-4">
                    <div class="card-body">
                      <h5 class="card-title"><i class="fas fa-file-pdf me-2 text-danger"></i> Annual Report 2024</h5>
                      <p class="card-text">Comprehensive report on department activities and achievements.</p>
                      <a href="#" class="btn btn-primary">Download</a>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card mb-4">
                    <div class="card-body">
                      <h5 class="card-title"><i class="fas fa-chart-line me-2 text-success"></i> Employment Statistics</h5>
                      <p class="card-text">Detailed statistics on employment trends and job market analysis.</p>
                      <a href="#" class="btn btn-primary">View Report</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Latest News -->
        <div class="mb-4" id="news">
          <h2 class="mb-4">Latest News & Updates</h2>
          <div class="row">
            <div class="col-md-6">
              <div class="card news-card mb-4">
                <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80" class="card-img-top" alt="News Image">
                <div class="card-body">
                  <span class="news-date">June 10, 2025</span>
                  <h5 class="card-title">New Skill Development Centers Launched</h5>
                  <p class="card-text">The department has launched 15 new skill development centers across the state to enhance vocational training opportunities.</p>
                  <a href="#" class="btn btn-primary">Read More</a>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card news-card mb-4">
                <img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80" class="card-img-top" alt="News Image">
                <div class="card-body">
                  <span class="news-date">June 5, 2025</span>
                  <h5 class="card-title">Labor Law Amendments Approved</h5>
                  <p class="card-text">The state assembly has approved amendments to labor laws aimed at improving working conditions and benefits for workers.</p>
                  <a href="#" class="btn btn-primary">Read More</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="col-lg-4">
        <div class="sidebar mb-4">
          <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" class="form-control" placeholder="Search departments, services...">
          </div>
          
          <h4>Quick Links</h4>
          <ul>
            <li><a href="#"><i class="fas fa-angle-right me-2"></i> Employment Registration</a></li>
            <li><a href="#"><i class="fas fa-angle-right me-2"></i> Skill Training Programs</a></li>
            <li><a href="#"><i class="fas fa-angle-right me-2"></i> Labor Welfare Schemes</a></li>
            <li><a href="#"><i class="fas fa-angle-right me-2"></i> Industrial Safety Guidelines</a></li>
            <li><a href="#"><i class="fas fa-angle-right me-2"></i> Career Counseling</a></li>
          </ul>
        </div>

        <div class="sidebar mb-4">
          <h4>Upcoming Events</h4>
          <div class="card mb-3">
            <div class="card-body">
              <h5 class="card-title">Job Fair 2025</h5>
              <p class="card-text"><i class="far fa-calendar-alt me-2"></i> June 25-27, 2025</p>
              <p class="card-text"><i class="fas fa-map-marker-alt me-2"></i> Convention Center</p>
              <a href="#" class="btn btn-sm btn-primary">Register</a>
            </div>
          </div>
          <div class="card mb-3">
            <div class="card-body">
              <h5 class="card-title">Skill Development Workshop</h5>
              <p class="card-text"><i class="far fa-calendar-alt me-2"></i> July 10, 2025</p>
              <p class="card-text"><i class="fas fa-map-marker-alt me-2"></i> Training Center</p>
              <a href="#" class="btn btn-sm btn-primary">Register</a>
            </div>
          </div>
        </div>

        <div class="sidebar mb-4">
          <h4>Important Documents</h4>
          <ul>
            <li><a href="#"><i class="fas fa-file-pdf me-2 text-danger"></i> Labor Law Handbook</a></li>
            <li><a href="#"><i class="fas fa-file-pdf me-2 text-danger"></i> Skill Development Policy</a></li>
            <li><a href="#"><i class="fas fa-file-pdf me-2 text-danger"></i> Employment Schemes Guide</a></li>
            <li><a href="#"><i class="fas fa-file-pdf me-2 text-danger"></i> Industrial Safety Manual</a></li>
          </ul>
        </div>

        <div class="sidebar">
          <h4>Contact Information</h4>
          <p><i class="fas fa-phone me-2"></i> Helpline: 1800-123-4567</p>
          <p><i class="fas fa-envelope me-2"></i> Email: info@labourskills.gov.in</p>
          <p><i class="fas fa-map-marker-alt me-2"></i> Address: Labour Department Building, Government Complex, Capital City</p>
          <div class="mt-3">
            <a href="#" class="btn btn-primary w-100" id="contact">Contact Us</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-4 mb-4 mb-md-0">
          <h5>About the Department</h5>
          <p>The Labour, Skill Development and Employment Department is committed to enhancing the welfare of workers, developing skills, and creating employment opportunities for citizens.</p>
          <div class="social-icons mt-3">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
          </div>
        </div>
        <div class="col-md-2 mb-4 mb-md-0">
          <div class="footer-links">
            <h5>Quick Links</h5>
            <ul>
              <li><a href="#">Home</a></li>
              <li><a href="#departments">Departments</a></li>
              <li><a href="#news">News</a></li>
              <li><a href="#contact">Contact</a></li>
            </ul>
          </div>
        </div>
        <div class="col-md-3 mb-4 mb-md-0">
          <div class="footer-links">
            <h5>Departments</h5>
            <ul>
              <li><a href="./Labour.php">Labour Department</a></li>
              <li><a href="./Skill.html">Skill Development</a></li>
              <li><a href="./Employment.html">Employment Development</a></li>
            </ul>
          </div>
        </div>
        
      </div>
      <hr class="mt-4 mb-4" style="border-color: #6c757d;">
      <div class="row">
        <div class="col-md-6 text-center text-md-start">
          <p class="mb-0">&copy; 2025 Labour, Skill Development & Employment Department. All rights reserved.</p>
        </div>
        <div class="col-md-6 text-center text-md-end">
          <p class="mb-0">
            <a href="#" class="text-white me-3">Privacy Policy</a>
            <a href="#" class="text-white me-3">Terms of Service</a>
            <a href="#" class="text-white">Accessibility</a>
          </p>
        </div>
      </div>
    </div>
  </footer>

  <!-- Department Modal -->
  <div class="modal fade" id="departmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="departmentModalLabel">Department Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="departmentContent">
            <!-- Content will be loaded dynamically -->
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Login Modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Department Login</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" required>
            </div>
            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="rememberMe">
              <label class="form-check-label" for="rememberMe">Remember me</label>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-primary">Login</button>
            </div>
            <div class="text-center mt-3">
              <a href="#" class="text-decoration-none">Forgot Password?</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap JS and Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
  <script>
    // Department Modal Content
    const departmentData = {
      'Labour Department': {
        description: 'The Labour Department is responsible for enforcing labor laws, resolving industrial disputes, and ensuring fair working conditions for all workers.',
        subDepartments: ['Labour Welfare', 'Industrial Relations', 'Labour Law Enforcement', 'Wage Board'],
        services: ['Labour Registration', 'Dispute Resolution', 'Minimum Wage Enforcement', 'Child Labour Prevention'],
        contact: {
          head: 'Dr. Rajesh Kumar',
          email: 'labour.head@labourskills.gov.in',
          phone: '1800-123-4567 (Ext. 101)'
        }
      },
      'Skill Development': {
        description: 'The Skill Development department focuses on enhancing vocational skills, providing training programs, and certifying skilled workers to improve employability.',
        subDepartments: ['Vocational Training', 'Certification', 'Entrepreneurship Development', 'Industry Partnerships'],
        services: ['Skill Training Programs', 'Certification Exams', 'Apprenticeship Programs', 'Entrepreneurship Workshops'],
        contact: {
          head: 'Ms. Priya Sharma',
          email: 'skill.head@labourskills.gov.in',
          phone: '1800-123-4567 (Ext. 102)'
        }
      },
      'Employment Exchange': {
        description: 'The Employment Exchange facilitates job matching, provides career counseling, and connects job seekers with potential employers across various sectors.',
        subDepartments: ['Job Registration', 'Career Counseling', 'Employer Services', 'Special Employment Programs'],
        services: ['Job Seeker Registration', 'Job Fairs', 'Career Guidance', 'Employer-Employee Matching'],
        contact: {
          head: 'Mr. Anand Verma',
          email: 'employment.head@labourskills.gov.in',
          phone: '1800-123-4567 (Ext. 103)'
        }
      },
      'Industrial Safety': {
        description: 'The Industrial Safety department ensures workplace safety standards, conducts inspections, and enforces safety regulations to prevent industrial accidents.',
        subDepartments: ['Safety Inspections', 'Accident Prevention', 'Safety Training', 'Hazard Management'],
        services: ['Safety Audits', 'Safety Certification', 'Accident Investigation', 'Safety Training Programs'],
        contact: {
          head: 'Dr. Suresh Patel',
          email: 'safety.head@labourskills.gov.in',
          phone: '1800-123-4567 (Ext. 104)'
        }
      }
    };

    // Handle Department Modal
    const departmentModal = document.getElementById('departmentModal');
    departmentModal.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      const department = button.getAttribute('data-department');
      const modalTitle = departmentModal.querySelector('.modal-title');
      const departmentContent = document.getElementById('departmentContent');
      
      modalTitle.textContent = department;
      
      if (departmentData[department]) {
        const data = departmentData[department];
        let content = `
          <div class="mb-4">
            <h5>Description</h5>
            <p>${data.description}</p>
          </div>
          
          <div class="mb-4">
            <h5>Sub-Departments</h5>
            <ul class="list-group">
              ${data.subDepartments.map(sub => `<li class="list-group-item">${sub}</li>`).join('')}
            </ul>
          </div>
          
          <div class="mb-4">
            <h5>Services</h5>
            <ul class="list-group">
              ${data.services.map(service => `<li class="list-group-item">${service}</li>`).join('')}
            </ul>
          </div>
          
          <div>
            <h5>Contact Information</h5>
            <p><strong>Department Head:</strong> ${data.contact.head}</p>
            <p><strong>Email:</strong> ${data.contact.email}</p>
            <p><strong>Phone:</strong> ${data.contact.phone}</p>
          </div>
          
          <div class="mt-4">
            <a href="#" class="btn btn-primary">Visit Department Website</a>
          </div>
        `;
        
        departmentContent.innerHTML = content;
      } else {
        departmentContent.innerHTML = '<p>Department information not available.</p>';
      }
    });

    // Initialize Chart
    document.addEventListener('DOMContentLoaded', function() {
      const ctx = document.getElementById('departmentChart');
      if (ctx) {
        new Chart(ctx, {
          type: 'bar',
          data: {
            labels: ['Labour', 'Skill Dev', 'Employment', 'Industrial Safety', 'Labour Welfare'],
            datasets: [{
              label: 'Budget Allocation (in millions)',
              data: [120, 150, 100, 80, 70],
              backgroundColor: [
                'rgba(13, 110, 253, 0.7)',
                'rgba(25, 135, 84, 0.7)',
                'rgba(255, 193, 7, 0.7)',
                'rgba(220, 53, 69, 0.7)',
                'rgba(108, 117, 125, 0.7)'
              ],
              borderColor: [
                'rgba(13, 110, 253, 1)',
                'rgba(25, 135, 84, 1)',
                'rgba(255, 193, 7, 1)',
                'rgba(220, 53, 69, 1)',
                'rgba(108, 117, 125, 1)'
              ],
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      }
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        if (this.getAttribute('href') !== '#' && !this.getAttribute('data-bs-toggle')) {
          e.preventDefault();
          const target = document.querySelector(this.getAttribute('href'));
          if (target) {
            window.scrollTo({
              top: target.offsetTop - 70,
              behavior: 'smooth'
            });
          }
        }
      });
    });
    const userName = "<?php echo addslashes($userFullName); ?>";
    console.log("Logged in as:", userName);
  </script>
</body>
</html>
