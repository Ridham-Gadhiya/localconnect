<?php
include '../includes/header.php';
include '../includes/auth_check.php';
require '../config/db.php';

// Check if user is logged in as customer
if ($_SESSION['role'] !== 'user') {
    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: my_bookings.php");
    exit;
}

$booking_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Handle Cancellation
if (isset($_POST['action']) && $_POST['action'] === 'cancel') {
    $stmt = $conn->prepare("UPDATE bookings SET status='cancelled' WHERE id = ? AND user_id = ? AND status='pending'");
    $stmt->execute([$booking_id, $user_id]);
    header("Location: booking_details.php?id=" . $booking_id . "&msg=cancelled");
    exit;
}

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
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

// If booking doesn't exist or doesn't belong to the user
if (!$booking) {
    echo "<div class='container my-5 py-5 text-center'>
        <div class='card border-0 shadow-sm p-5 mx-auto rounded-4' style='max-width: 500px;'>
            <div class='icon-circle bg-light mx-auto mb-3' style='width: 70px; height: 70px; font-size: 30px;'>
                <i class='fas fa-search-minus text-muted'></i>
            </div>
            <h4 class='fw-bold mb-2'>Booking Record Not Found</h4>
            <p class='text-muted mb-4'>The requested booking was not found or has been removed.</p>
            <a href='my_bookings.php' class='btn btn-primary btn-pill px-4'>Return to My Bookings</a>
        </div>
    </div>";
    include '../includes/footer.php';
    exit;
}

// Status Logic
$statusClass = 'status-pending';
$statusIcon = 'fa-clock';
if ($booking['status'] === 'accepted') { 
    $statusClass = 'status-accepted'; 
    $statusIcon = 'fa-check-circle'; 
} elseif ($booking['status'] === 'completed') { 
    $statusClass = 'status-completed'; 
    $statusIcon = 'fa-star'; 
} elseif ($booking['status'] === 'rejected' || $booking['status'] === 'cancelled') { 
    $statusClass = 'status-rejected'; 
    $statusIcon = 'fa-times-circle'; 
}
?>

<div class="row justify-content-center py-4">
    <div class="col-lg-8">
        <div class="d-flex align-items-center mb-4">
            <a href="my_bookings.php" class="btn btn-light rounded-circle me-3 shadow-sm border" title="Back to Bookings">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="fw-bold mb-0">Booking Details</h2>
                <p class="text-muted mb-0 small">Reference: #LC-<?= str_pad($booking['id'], 5, '0', STR_PAD_LEFT) ?></p>
            </div>
        </div>

        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'cancelled'): ?>
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center">
                <i class="fas fa-info-circle me-2 fs-5"></i>
                <div>This booking request has been successfully cancelled.</div>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
            <div class="p-4 border-bottom d-flex justify-content-between align-items-center bg-light">
                <span class="status-badge <?= $statusClass ?> shadow-sm">
                    <i class="fas <?= $statusIcon ?> me-1"></i> <?= ucfirst($booking['status']) ?>
                </span>
                <span class="small fw-bold text-muted text-uppercase ls-1">Placed on <?= date('d M Y, h:i A', strtotime($booking['created_at'])) ?></span>
            </div>

            <div class="card-body p-4 p-md-5">
                <div class="row g-4">
                    <div class="col-md-7 border-md-end">
                        <h6 class="text-muted text-uppercase fw-bold small ls-1 mb-3">Service Information</h6>
                        <h3 class="fw-bold mb-2 text-dark"><?= htmlspecialchars($booking['service_name']) ?></h3>
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill mb-4 px-3 py-2 small fw-bold">
                            <?= htmlspecialchars($booking['category_name']) ?>
                        </span>
                        
                        <p class="text-muted small mb-4">
                            <?= nl2br(htmlspecialchars($booking['description'] ?: 'Standard professional service')) ?>
                        </p>

                        <div class="bg-light p-3 rounded-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-secondary small fw-semibold">Agreed Service Price</span>
                                <span class="fw-bold text-dark fs-5">₹<?= htmlspecialchars($booking['price']) ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5 ps-md-4">
                        <div class="mb-4">
                            <h6 class="text-muted text-uppercase fw-bold small ls-1 mb-3">Service Provider</h6>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold" style="width: 45px; height: 45px; font-size: 18px;">
                                    <?= strtoupper(substr($booking['provider_name'], 0, 1)) ?>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark"><?= htmlspecialchars($booking['provider_name']) ?></h6>
                                    <p class="text-muted small mb-0"><?= htmlspecialchars($booking['provider_email']) ?></p>
                                </div>
                            </div>
                            <?php if($booking['status'] === 'accepted' && !empty($booking['provider_phone'])): ?>
                                <a href="tel:<?= htmlspecialchars($booking['provider_phone']) ?>" class="btn btn-outline-primary btn-sm mt-3 w-100 rounded-pill fw-semibold">
                                    <i class="fas fa-phone-alt me-2"></i> Call Provider (<?= htmlspecialchars($booking['provider_phone']) ?>)
                                </a>
                            <?php endif; ?>
                        </div>

                        <hr class="opacity-10">

                        <div class="mb-4">
                            <h6 class="text-muted text-uppercase fw-bold small ls-1 mb-3">Schedule Info</h6>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3 me-3">
                                    <i class="fas fa-calendar-day fs-4"></i>
                                </div>
                                <div>
                                    <p class="small fw-bold mb-0 text-dark"><?= date('l, d F Y', strtotime($booking['booking_date'])) ?></p>
                                    <p class="text-muted x-small mb-0">Confirmed Appointment Date</p>
                                </div>
                            </div>
                        </div>

                        <?php if($booking['status'] === 'pending'): ?>
                            <form method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking request?');">
                                <input type="hidden" name="action" value="cancel">
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100 rounded-pill fw-semibold py-2">
                                    <i class="fas fa-times me-1"></i> Cancel Request
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light border-0 p-4 text-center">
                <p class="small text-muted mb-0">Have an issue with this service? <a href="mailto:support@localconnect.com" class="text-primary fw-bold text-decoration-none">Contact Support</a></p>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>