<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="col-lg-2 col-md-3 p-0 sidebar" id="sidebar1">
    <div class="logo d-flex align-items-center">
        <i class="bi bi-building me-2 fs-4"></i>
        <h5 class="mb-0">Employment Department</h5>
    </div>
    <div class="mt-4">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="dashboard.html" class="nav-link <?php echo $current_page == 'dashboard.html' ? 'active' : ''; ?>">
                    <i class="bi bi-diagram-3"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#deptSubmenu">
                    <i class="bi bi-building"></i> Departments
                    <i class="bi bi-chevron-down float-end"></i>
                </a>
                <div class="collapse" id="deptSubmenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="labour.php" class="nav-link department-item <?php echo $current_page == 'labour.php' ? 'active' : ''; ?>">
                                Labour Department
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="skill.php" class="nav-link department-item <?php echo $current_page == 'skill.php' ? 'active' : ''; ?>">
                                Skill Development
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="employment.php" class="nav-link department-item <?php echo $current_page == 'employment.php' ? 'active' : ''; ?>">
                                Employment Department
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a href="chatbot\index.php" class="nav-link department-item <?php echo $current_page == '../chat-app/login.php' ? 'active' : ''; ?>">
                <i class="bi bi-chat-dots"></i> Message App
                </a>
            </li>
        </ul>
    </div>
</div>