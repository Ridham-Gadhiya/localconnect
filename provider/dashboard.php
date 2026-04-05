<?php
include '../includes/header.php';
include '../includes/auth_check.php';
require '../config/db.php';

if ($_SESSION['role'] !== 'provider') {
    header("Location: ../auth/login.php");
    exit;
}

$provider_id = $_SESSION['provider_id'];
$display_name = isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : 'Partner';

// 1. Fetch Service and Booking Counts
$serviceCount = $conn->prepare("SELECT COUNT(*) FROM services WHERE provider_id = ?");
$serviceCount->execute([$provider_id]);
$totalServices = $serviceCount->fetchColumn();

$bookingCount = $conn->prepare("
    SELECT COUNT(*) FROM bookings
    JOIN services ON bookings.service_id = services.id
    WHERE services.provider_id = ?
");
$bookingCount->execute([$provider_id]);
$totalBookings = $bookingCount->fetchColumn();

// 2. NEW: Fetch Total Revenue (Completed Bookings Only)
$earningStmt = $conn->prepare("
    SELECT SUM(services.price) as total_revenue 
    FROM bookings
    JOIN services ON bookings.service_id = services.id
    WHERE services.provider_id = ? AND bookings.status = 'completed'
");
$earningStmt->execute([$provider_id]);
$revenue = $earningStmt->fetchColumn() ?: 0;

// 3. NEW: Fetch 3 Most Recent Booking Requests
$recentStmt = $conn->prepare("
    SELECT bookings.*, services.service_name, users.name as user_name
    FROM bookings
    JOIN services ON bookings.service_id = services.id
    JOIN users ON bookings.user_id = users.id
    WHERE services.provider_id = ?
    ORDER BY bookings.created_at DESC LIMIT 3
");
$recentStmt->execute([$provider_id]);
$recentRequests = $recentStmt->fetchAll();
?>

<div class="row align-items-center mb-4">
    <div class="col-md-8">
        <h2 class="dashboard-title mb-1">Welcome, <?= $display_name ?> 👋</h2>
        <p class="text-muted">Monitor your service performance and manage your business growth.</p>
    </div>
    <div class="col-md-4 text-md-end">
        <a href="add_service.php" class="btn btn-primary btn-pill shadow-sm">
            <i class="fas fa-plus me-2"></i>New Service
        </a>
    </div>
</div>

<div class="row mb-5">
    <div class="col-md-4 mb-3">
        <div class="stat-card border-0 shadow-sm animate-fade-in">
            <div class="icon-circle bg-primary-soft mx-auto mb-3">
                <i class="fas fa-wallet text-primary"></i>
            </div>
            <h6 class="text-uppercase ls-1 small fw-bold text-muted">Total Revenue</h6>
            <h2 class="display-6 fw-bold text-dark">₹<?= number_format($revenue) ?></h2>
            <p class="mb-0 small text-success"><i class="fas fa-check-circle me-1"></i> From completed jobs</p>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card border-0 shadow-sm animate-fade-in" style="animation-delay: 0.1s;">
            <div class="icon-circle bg-success-soft mx-auto mb-3">
                <i class="fas fa-briefcase text-success"></i>
            </div>
            <h6 class="text-uppercase ls-1 small fw-bold text-muted">Active Listings</h6>
            <h2 class="display-6 fw-bold text-dark"><?= $totalServices ?></h2>
            <p class="mb-0 small text-muted">Live offerings</p>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card border-0 shadow-sm animate-fade-in" style="animation-delay: 0.2s;">
            <div class="icon-circle bg-info-soft mx-auto mb-3">
                <i class="fas fa-calendar-check text-info"></i>
            </div>
            <h6 class="text-uppercase ls-1 small fw-bold text-muted">Total Requests</h6>
            <h2 class="display-6 fw-bold text-dark"><?= $totalBookings ?></h2>
            <p class="mb-0 small text-muted">Customer history</p>
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-lg-4">
        <h5 class="fw-bold mb-4">Quick Actions</h5>
        <div class="list-group list-group-flush rounded-4 shadow-sm border overflow-hidden">
            <a href="add_service.php" class="list-group-item list-group-item-action p-3">
                <i class="fas fa-plus-circle text-primary me-3"></i> Create Listing
            </a>
            <a href="manage_services.php" class="list-group-item list-group-item-action p-3">
                <i class="fas fa-tasks text-warning me-3"></i> My Inventory
            </a>
            <a href="bookings.php" class="list-group-item list-group-item-action p-3">
                <i class="fas fa-inbox text-danger me-3"></i> Booking Inbox
            </a>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0">Recent Requests</h5>
            <a href="bookings.php" class="small text-decoration-none fw-bold">View All Requests</a>
        </div>
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table mb-0 align-middle small">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 border-0 py-3">Customer</th>
                            <th class="border-0">Service</th>
                            <th class="border-0">Date</th>
                            <th class="border-0">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($recentRequests as $req): ?>
                        <tr>
                            <td class="ps-4 fw-bold text-dark"><?= htmlspecialchars($req['user_name']) ?></td>
                            <td><?= htmlspecialchars($req['service_name']) ?></td>
                            <td><?= date('d M', strtotime($req['booking_date'])) ?></td>
                            <td>
                                <span class="status-badge status-<?= $req['status'] ?> rounded-pill">
                                    <?= ucfirst($req['status']) ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; if(empty($recentRequests)) echo "<tr><td colspan='4' class='text-center p-4 text-muted'>No requests found</td></tr>"; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>