<?php
include '../includes/header.php';
include '../includes/auth_check.php';
require '../config/db.php'; // Required for database connection

// Check if user is logged in, otherwise redirect
if ($_SESSION['role'] !== 'user') {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// 1. Fetch Total Bookings for this user
$stmt_total = $conn->prepare("SELECT COUNT(*) AS total FROM bookings WHERE user_id = ?");
$stmt_total->execute([$user_id]);
$total_bookings = $stmt_total->fetch()['total'];

// 2. Fetch Active Services (Available in the system)
// You can adjust this to count specifically "approved" providers' services
$stmt_active = $conn->prepare("SELECT COUNT(*) AS total FROM services");
$stmt_active->execute();
$active_services = $stmt_active->fetch()['total'];

// Fallback to 'User' if the session name isn't set
$display_name = isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : 'User';
?>

<div class="row align-items-center mb-4">
    <div class="col-md-8">
        <h2 class="dashboard-title mb-1">Welcome back, <?php echo $display_name; ?> 👋</h2>
        <p class="text-muted">
            Find trusted local services and manage your bookings effortlessly.
        </p>
    </div>
    <div class="col-md-4 text-md-end">
        <a href="search_services.php" class="btn btn-primary btn-pill shadow-sm">
            <i class="fas fa-plus me-2"></i>New Booking
        </a>
    </div>
</div>

<div class="row mb-5">
    <div class="col-md-6 mb-3">
        <div class="stat-card border-0 shadow-sm animate-fade-in">
            <div class="icon-circle bg-primary-soft mx-auto mb-3">
                <i class="fas fa-calendar-check text-primary"></i>
            </div>
            <h6 class="text-uppercase ls-1 small fw-bold text-muted">Total Bookings</h6>
            <h2 class="display-6 fw-bold text-dark"><?php echo $total_bookings; ?></h2>
            <p class="mb-0 small text-success"><i class="fas fa-history me-1"></i> Lifetime history</p>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="stat-card border-0 shadow-sm animate-fade-in" style="animation-delay: 0.1s;">
            <div class="icon-circle bg-success-soft mx-auto mb-3">
                <i class="fas fa-bolt text-success"></i>
            </div>
            <h6 class="text-uppercase ls-1 small fw-bold text-muted">Available Services</h6>
            <h2 class="display-6 fw-bold text-dark"><?php echo $active_services; ?></h2>
            <p class="mb-0 small text-muted">Available in your area</p>
        </div>
    </div>
</div>

<div class="d-flex align-items-center mb-4">
    <h4 class="fw-bold mb-0">Quick Actions</h4>
    <div class="flex-grow-1 ms-3 border-top opacity-10"></div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card action-card h-100 border-0 shadow-sm hover-lift">
            <div class="card-body p-4 text-center">
                <div class="icon-circle bg-info-soft mx-auto mb-4" style="width: 70px; height: 70px; font-size: 30px;">
                    <i class="fas fa-search text-info"></i>
                </div>
                <h5 class="fw-bold">Search Services</h5>
                <p class="text-muted px-lg-4">
                    Explore verified professionals near you by category, ratings, and pricing.
                </p>
                <a href="search_services.php" class="btn btn-dark btn-pill px-4 mt-2">
                    Explore Categories
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card action-card h-100 border-0 shadow-sm hover-lift">
            <div class="card-body p-4 text-center">
                <div class="icon-circle bg-warning-soft mx-auto mb-4" style="width: 70px; height: 70px; font-size: 30px;">
                    <i class="fas fa-list-ul text-warning"></i>
                </div>
                <h5 class="fw-bold">My Bookings</h5>
                <p class="text-muted px-lg-4">
                    Track your current service progress and review your past completed tasks.
                </p>
                <a href="my_bookings.php" class="btn btn-outline-dark btn-pill px-4 mt-2">
                    Manage History
                </a>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>