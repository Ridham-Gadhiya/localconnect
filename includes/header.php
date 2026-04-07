<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Logic to determine the correct dashboard path based on role
$dashboard_path = "../index.php"; // Default fallback
if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
    if ($role === 'admin') {
        $dashboard_path = "admin/dashboard.php";
    } elseif ($role === 'provider') {
        $dashboard_path = "provider/dashboard.php";
    } elseif ($role === 'user') {
        $dashboard_path = "user/dashboard.php";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LocalConnect | Premium Service Marketplace</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- <link rel="stylesheet" href="../assets/css/style.css"> -->
    <link rel="stylesheet" href="../assets/css/landing.css">
</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm py-3">
  <div class="container">
    <a class="navbar-brand fw-bold d-flex align-items-center" href="/localconnect/index.php">
        <div class="bg-primary rounded-3 p-2 me-2 d-flex align-items-center justify-content-center shadow" style="width: 35px; height: 35px;">
            <i class="fas fa-plug-circle-check fs-6 text-white"></i>
        </div>
        <span class="ls-tight text-white">LocalConnect</span>
    </a>
    
    <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto align-items-center gap-3">
        
        <li class="nav-item">
            <a class="nav-link fw-medium small text-uppercase ls-1" href="/localconnect/index.php">Home</a>
        </li>

        <?php if(!isset($_SESSION['role'])): ?>
            <li class="nav-item">
                <a class="nav-link fw-medium px-3 small text-uppercase ls-1" href="/localconnect/auth/login.php">Login</a>
            </li>
            <li class="nav-item">
                <a class="btn btn-primary btn-pill px-4 fw-bold shadow-sm animate-pulse-slow" href="../auth/register_user.php">
                    Get Started
                </a>
            </li>
        <?php else: ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle bg-white bg-opacity-10 rounded-pill px-3 py-2 d-flex align-items-center border border-white border-opacity-10" 
                   href="#" role="button" data-bs-toggle="dropdown">
                    <div class="avatar-sm me-2 bg-primary rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width: 24px; height: 24px; font-size: 10px;">
                        <?= strtoupper(substr($_SESSION['role'], 0, 1)) ?>
                    </div>
                    <span class="text-capitalize small fw-bold text-white"><?= $_SESSION['role'] ?> Portal</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 mt-3 py-2">
                    <li class="px-3 py-2">
                        <p class="mb-0 x-small text-muted text-uppercase fw-bold ls-1">Management</p>
                    </li>
                    <li>
                        <a class="dropdown-item py-2 d-flex align-items-center" href="<?= $dashboard_path ?>">
                            <i class="fas fa-th-large me-3 text-primary opacity-75"></i> 
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <?php if($_SESSION['role'] === 'user'): ?>
                        <li>
                            <a class="dropdown-item py-2 d-flex align-items-center" href="../user/my_bookings.php">
                                <i class="fas fa-calendar-alt me-3 text-primary opacity-75"></i> 
                                <span>My Bookings</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li><hr class="dropdown-divider opacity-50"></li>
                    <li>
                        <a class="dropdown-item py-2 text-danger d-flex align-items-center" href="/localconnect/auth/logout.php">
                            <i class="fas fa-sign-out-alt me-3"></i> 
                            <span class="fw-bold">Logout</span>
                        </a>
                    </li>
                </ul>
            </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<div class="container my-5 pb-5">