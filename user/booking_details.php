<?php
include '../includes/header.php';
include '../includes/auth_check.php';
require '../config/db.php';

// Check if ID is provided
if (!isset($_GET['id'])) {
    header("Location: my_bookings.php");
    exit;
}

$booking_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Fetch detailed booking information
$stmt = $conn->prepare("
    SELECT b.*, 
           s.service_name, s.price, s.description,
           p.name AS provider_name, p.phone AS provider_phone, p.email AS provider_email,
           c.category_name
    FROM bookings b
    JOIN services s ON b.service_id = s.id
    JOIN service_providers p ON s.provider_id = p.id
    JOIN categories c ON s.category_id = c.id
    WHERE b.id = ? AND b.user_id = ?
");
$stmt->execute([$booking_id, $user_id]);
$booking = $stmt->fetch();

// If booking doesn't exist or doesn't belong to the user
if (!$booking) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Booking not found.</div></div>";
    include '../includes/footer.php';
    exit;
}

// Status Logic
$statusClass = 'status-pending';
$statusIcon = 'fa-clock';
if ($booking['status'] === 'accepted') { $statusClass = 'status-accepted'; $statusIcon = 'fa-check-circle'; }
elseif ($booking['status'] === 'completed') { $statusClass = 'status-completed'; $statusIcon = 'fa-star'; }
elseif ($booking['status'] === 'rejected') { $statusClass = 'status-rejected'; $statusIcon = 'fa-times-circle'; }
?>

<div class="row justify-content-center py-4">
    <div class="col-lg-8">
        <div class="d-flex align-items-center mb-4">
            <a href="my_bookings.php" class="btn btn-light rounded-circle me-3 shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="fw-bold mb-0">Booking Details</h2>
                <p class="text-muted mb-0 small">Booking ID: #LC-<?= str_pad($booking['id'], 5, '0', STR_PAD_LEFT) ?></p>
            </div>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
            <div class="p-4 border-bottom d-flex justify-content-between align-items-center <?= $statusClass ?>-bg">
                <span class="status-badge <?= $statusClass ?> shadow-sm bg-white">
                    <i class="fas <?= $statusIcon ?> me-1"></i> <?= ucfirst($booking['status']) ?>
                </span>
                <span class="small fw-bold opacity-75 text-uppercase ls-1">Placed on <?= date('d M Y', strtotime($booking['created_at'])) ?></span>
            </div>

            <div class="card-body p-4 p-md-5">
                <div class="row g-4">
                    <div class="col-md-7 border-md-end">
                        <h6 class="text-muted text-uppercase fw-bold small ls-1 mb-3">Service Information</h6>
                        <h3 class="fw-bold mb-2"><?= htmlspecialchars($booking['service_name']) ?></h3>
                        <p class="badge bg-primary-soft text-primary rounded-pill mb-4"><?= htmlspecialchars($booking['category_name']) ?></p>
                        
                        <p class="text-muted small mb-4">
                            <?= htmlspecialchars($booking['description']) ?>
                        </p>

                        <div class="bg-light p-3 rounded-4">
                            <div class="d-flex justify-content-between">
                                <span class="text-secondary small">Service Price</span>
                                <span class="fw-bold text-dark">₹<?= htmlspecialchars($booking['price']) ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5 ps-md-4">
                        <div class="mb-4">
                            <h6 class="text-muted text-uppercase fw-bold small ls-1 mb-3">Service Provider</h6>
                            <div class="d-flex align-items-center">
                                <div class="icon-circle bg-dark text-white mb-0 me-3" style="width: 45px; height: 45px; font-size: 18px;">
                                    <?= strtoupper(substr($booking['provider_name'], 0, 1)) ?>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0"><?= htmlspecialchars($booking['provider_name']) ?></h6>
                                    <p class="text-muted small mb-0"><?= htmlspecialchars($booking['provider_email']) ?></p>
                                </div>
                            </div>
                            <?php if($booking['status'] === 'accepted'): ?>
                                <a href="tel:<?= $booking['provider_phone'] ?>" class="btn btn-outline-primary btn-sm mt-3 w-100 rounded-pill">
                                    <i class="fas fa-phone-alt me-2"></i> Contact Provider
                                </a>
                            <?php endif; ?>
                        </div>

                        <hr class="opacity-10">

                        <div>
                            <h6 class="text-muted text-uppercase fw-bold small ls-1 mb-3">Schedule Info</h6>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary-soft text-primary rounded-3 p-2 me-3">
                                    <i class="fas fa-calendar-day fs-4"></i>
                                </div>
                                <div>
                                    <p class="small fw-bold mb-0"><?= date('l, d F Y', strtotime($booking['booking_date'])) ?></p>
                                    <p class="text-muted small mb-0">Scheduled Appointment Date</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light border-0 p-4 text-center">
                <p class="small text-muted mb-0">Need help? <a href="#" class="text-primary fw-bold text-decoration-none">Contact Support</a></p>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>