<?php
session_start();
require_once 'config_labour.php';
require_once 'functions.php';
$notifications = [
    "New report from Labour Department",
    "Skill Development meeting scheduled",
    "Employment statistics updated",
    "New policy document uploaded",
    "System maintenance scheduled"
];
$notification_count = count($notifications);
$name = getName();
if($name == ' ')
{
    header("Location: index.html");
}
$profile_image = isset($_SESSION['profile_image']) ? $_SESSION['profile_image'] : 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80';
?>

<!-- Top Navigation -->
<div class="row mb-4">
    <div class="col-12">
        <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow-sm">
            <div class="container-fluid">
                <form class="d-flex me-auto"></form>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown me-3">
                        <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-bell fs-5 position-relative">
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <?php echo $notification_count; ?>
                                </span>
                            </i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header">Notifications</h6></li>
                            <li><hr class="dropdown-divider"></li>
                            <?php foreach ($notifications as $notification) : ?>
                                <li><a class="dropdown-item" href="#"><?php echo $notification; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link profile-dropdown d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <img src="<?php echo $profile_image; ?>" alt="Profile">
                            <span class="ms-2 d-none d-lg-inline"><?php echo $name; ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
