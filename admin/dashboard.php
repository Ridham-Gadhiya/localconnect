<?php
include '../includes/header.php';
include '../includes/auth_check.php';
require '../config/db.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// 1. Fetch System Stats
$userCount = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
$providerCount = $conn->query("SELECT COUNT(*) FROM service_providers")->fetchColumn();
$bookingCount = $conn->query("SELECT COUNT(*) FROM bookings")->fetchColumn();

// 2. NEW: Fetch Pending Provider Approvals
$pendingProviders = $conn->query("SELECT COUNT(*) FROM service_providers WHERE status = 'pending'")->fetchColumn();

// 3. NEW: Fetch Recent Bookings for a System Overview
$recentStmt = $conn->query("
    SELECT b.*, s.service_name, u.name as user_name 
    FROM bookings b 
    JOIN services s ON b.service_id = s.id 
    JOIN users u ON b.user_id = u.id 
    ORDER BY b.created_at DESC LIMIT 5
");
$recentBookings = $recentStmt->fetchAll();
?>

<div class="row align-items-center mb-4">
    <div class="col-md-8">
        <h2 class="dashboard-title mb-1">System Administration 🛠️</h2>
        <p class="text-muted">Global oversight and platform management center.</p>
    </div>
</div>

<div class="row mb-5">
    <div class="col-md-3 mb-3">
        <div class="stat-card border-0 shadow-sm animate-fade-in">
            <div class="icon-circle bg-primary-soft mx-auto mb-3">
                <i class="fas fa-users text-primary"></i>
            </div>
            <h6 class="text-uppercase ls-1 small fw-bold text-muted">Total Users</h6>
            <h2 class="display-6 fw-bold text-dark"><?= $userCount ?></h2>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card border-0 shadow-sm animate-fade-in" style="animation-delay: 0.1s;">
            <div class="icon-circle bg-success-soft mx-auto mb-3">
                <i class="fas fa-briefcase text-success"></i>
            </div>
            <h6 class="text-uppercase ls-1 small fw-bold text-muted">Providers</h6>
            <h2 class="display-6 fw-bold text-dark"><?= $providerCount ?></h2>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card border-0 shadow-sm animate-fade-in" style="animation-delay: 0.2s;">
            <div class="icon-circle bg-info-soft mx-auto mb-3">
                <i class="fas fa-clipboard-list text-info"></i>
            </div>
            <h6 class="text-uppercase ls-1 small fw-bold text-muted">Total Bookings</h6>
            <h2 class="display-6 fw-bold text-dark"><?= $bookingCount ?></h2>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card border-0 shadow-sm animate-fade-in bg-warning bg-opacity-10 border-warning border" style="animation-delay: 0.3s;">
            <div class="icon-circle bg-white mx-auto mb-3">
                <i class="fas fa-user-clock text-warning"></i>
            </div>
            <h6 class="text-uppercase ls-1 small fw-bold text-muted">Pending Pros</h6>
            <h2 class="display-6 fw-bold text-warning"><?= $pendingProviders ?></h2>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <h5 class="fw-bold mb-4">Core Management</h5>
        <div class="row g-3">
            <div class="col-6">
                <a href="manage_providers.php" class="card text-center p-4 action-card border-0 shadow-sm hover-lift text-decoration-none">
                    <i class="fas fa-check-circle text-primary fs-3 mb-2"></i>
                    <h6 class="text-dark fw-bold mb-0">Approvals</h6>
                </a>
            </div>
            <div class="col-6">
                <a href="manage_users.php" class="card text-center p-4 action-card border-0 shadow-sm hover-lift text-decoration-none">
                    <i class="fas fa-user-gear text-dark fs-3 mb-2"></i>
                    <h6 class="text-dark fw-bold mb-0">Users</h6>
                </a>
            </div>
            <div class="col-6">
                <a href="manage_categories.php" class="card text-center p-4 action-card border-0 shadow-sm hover-lift text-decoration-none">
                    <i class="fas fa-tags text-info fs-3 mb-2"></i>
                    <h6 class="text-dark fw-bold mb-0">Categories</h6>
                </a>
            </div>
            <div class="col-6">
                <a href="bookings.php" class="card text-center p-4 action-card border-0 shadow-sm hover-lift text-decoration-none">
                    <i class="fas fa-receipt text-success fs-3 mb-2"></i>
                    <h6 class="text-dark fw-bold mb-0">Sales</h6>
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0">Global Activity Feed</h5>
            <span class="badge bg-light text-dark border">Live Updates</span>
        </div>
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table mb-0 align-middle small">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 border-0 py-3">User</th>
                            <th class="border-0">Service</th>
                            <th class="border-0">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($recentBookings as $rb): ?>
                        <tr>
                            <td class="ps-4 fw-bold"><?= htmlspecialchars($rb['user_name']) ?></td>
                            <td><?= htmlspecialchars($rb['service_name']) ?></td>
                            <td>
                                <span class="status-badge status-<?= $rb['status'] ?> rounded-pill">
                                    <?= ucfirst($rb['status']) ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>