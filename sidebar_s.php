<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="col-lg-2 col-md-3 p-0 sidebar" id="sidebar1">
    <div class="logo d-flex align-items-center">
        <i class="bi bi-building me-2 fs-4"></i>
        <h5 class="mb-0">
            <a href="skill.php" class="text-decoration-none text-white">Skill Development Department</a>
        </h5>


    </div>
    <div class="mt-4">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="das_s.php" class="nav-link <?php echo $current_page == 'das_s.php' ? 'active' : ''; ?>">
                    <i class="bi bi-diagram-3"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="chatbot\index.php" class="nav-link department-item <?php echo $current_page == '../chat-app/login.php' ? 'active' : ''; ?>">
                <i class="bi bi-chat-dots"></i> Message App
                </a>
            </li>
        </ul>
    </div>
</div>