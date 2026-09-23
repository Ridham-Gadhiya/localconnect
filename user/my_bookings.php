<?php
include '../includes/header.php';
include '../includes/auth_check.php';
require '../config/db.php';

// Check if user is logged in as a customer
if ($_SESSION['role'] !== 'user') {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Handle User Cancellation
if (isset($_GET['cancel'])) {
    $cancel_id = intval($_GET['cancel']);
    $stmt = $conn->prepare("UPDATE bookings SET status='cancelled' WHERE id = ? AND user_id = ? AND status='pending'");
    $stmt->execute([$cancel_id, $user_id]);
    header("Location: my_bookings.php?msg=cancelled");
    exit;
}

$stmt = $conn->prepare("
    SELECT bookings.*, services.service_name, services.price AS service_price, service_providers.name as provider_name
    FROM bookings
    JOIN services ON bookings.service_id = services.id
    JOIN service_providers ON services.provider_id = service_providers.id
    WHERE bookings.user_id = ?
    ORDER BY bookings.created_at DESC
");
$stmt->execute([$user_id]);
$bookings = $stmt->fetchAll();
?>

<div class="row align-items-center mb-4">
    <div class="col-md-8 d-flex align-items-center">
        <a href="dashboard.php" class="btn btn-light rounded-circle me-3 shadow-sm border" title="Back to Dashboard">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="fw-bold mb-1">My Bookings</h2>
            <p class="text-muted mb-0">Track your service requests, schedule, and booking progress</p>
        </div>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="search_services.php" class="btn btn-outline-primary btn-pill shadow-sm small fw-semibold">
            <i class="fas fa-plus me-2"></i>Book New Service
        </a>
    </div>
</div>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'cancelled'): ?>
    <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center">
        <i class="fas fa-info-circle me-2 fs-5"></i>
        <div>Your booking request has been cancelled successfully.</div>
    </div>
<?php endif; ?>

<?php if (count($bookings) === 0): ?>
    <div class="card border-0 shadow-sm text-center p-5 rounded-4 animate-fade-in">
        <div class="icon-circle bg-light mx-auto mb-4" style="width: 80px; height: 80px; font-size: 35px;">
            <i class="fas fa-calendar-times text-muted opacity-50"></i>
        </div>
        <h4 class="fw-bold">No Bookings Yet</h4>
        <p class="text-muted mb-4 mx-auto" style="max-width: 400px;">You haven't made any service requests yet. Start exploring our trusted local providers today.</p>
        <a href="search_services.php" class="btn btn-primary btn-pill px-5">Browse Services</a>
    </div>
<?php endif; ?>

<div class="row">
<?php foreach ($bookings as $b): 
    $statusClass = 'status-pending';
    $statusIcon = 'fa-clock';
    
    if ($b['status'] === 'accepted') {
        $statusClass = 'status-accepted';
        $statusIcon = 'fa-check-circle';
    } elseif ($b['status'] === 'completed') {
        $statusClass = 'status-completed';
        $statusIcon = 'fa-star';
    } elseif ($b['status'] === 'rejected' || $b['status'] === 'cancelled') {
        $statusClass = 'status-rejected';
        $statusIcon = 'fa-times-circle';
    }
?>
    <div class="col-md-6 mb-4 animate-fade-in">
        <div class="card booking-card border-0 shadow-sm hover-lift h-100" style="border-radius: 20px; overflow: hidden;">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h5 class="fw-bold mb-1 text-dark">
                            <?= htmlspecialchars($b['service_name']) ?>
                        </h5>
                        <p class="small text-muted mb-0">
                            <i class="fas fa-user-tie me-1 text-primary"></i> Provider: <?= htmlspecialchars($b['provider_name']) ?>
                        </p>
                    </div>
                    <span class="status-badge <?= $statusClass ?> shadow-sm">
                        <i class="fas <?= $statusIcon ?> me-1 small"></i> <?= ucfirst($b['status']) ?>
                    </span>
                </div>

                <div class="mb-3">
                    <span class="fw-bold text-dark fs-6">₹<?= htmlspecialchars($b['service_price']) ?></span>
                </div>

                <hr class="opacity-10 my-3 mt-auto">

                <div class="row align-items-center">
                    <div class="col-7">
                        <div class="d-flex align-items-center">
                            <div class="bg-light rounded-3 p-2 me-3 text-center" style="min-width: 45px;">
                                <div class="text-primary fw-bold small lh-1"><?= date('M', strtotime($b['booking_date'])) ?></div>
                                <div class="text-dark fs-5 fw-bold lh-1"><?= date('d', strtotime($b['booking_date'])) ?></div>
                            </div>
                            <div>
                                <p class="small text-muted mb-0">Scheduled Date</p>
                                <p class="small fw-bold mb-0 text-dark"><?= date('D, Y', strtotime($b['booking_date'])) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-5 text-end d-flex justify-content-end gap-1">
                        <?php if ($b['status'] === 'pending'): ?>
                            <a href="?cancel=<?= $b['id'] ?>" class="btn btn-outline-danger btn-sm rounded-pill px-2" title="Cancel Booking" onclick="return confirm('Cancel this pending booking request?');">
                                Cancel
                            </a>
                        <?php endif; ?>
                        <a href="booking_details.php?id=<?= $b['id'] ?>" class="btn btn-light btn-sm rounded-pill px-3 fw-bold border">
                            Details <i class="fas fa-chevron-right ms-1 x-small"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>

<?php include '../includes/footer.php'; ?>