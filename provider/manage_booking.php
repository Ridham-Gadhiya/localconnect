<?php
include '../includes/header.php';
include '../includes/auth_check.php';
require '../config/db.php';

if ($_SESSION['role'] !== 'provider') {
    header("Location: ../auth/login.php");
    exit;
}

$provider_id = $_SESSION['provider_id'];

if (isset($_GET['accept'])) {
    $stmt = $conn->prepare("
        UPDATE bookings
        JOIN services ON bookings.service_id = services.id
        SET bookings.status = 'accepted'
        WHERE bookings.id = ? AND services.provider_id = ? AND bookings.status = 'pending'
    ");
    $stmt->execute([$_GET['accept'], $provider_id]);
    header("Location: manage_booking.php?success=1");
    exit;
}

if (isset($_GET['complete'])) {
    $stmt = $conn->prepare("
        UPDATE bookings
        JOIN services ON bookings.service_id = services.id
        SET bookings.status = 'completed'
        WHERE bookings.id = ? AND services.provider_id = ? AND bookings.status = 'accepted'
    ");
    $stmt->execute([$_GET['complete'], $provider_id]);
    header("Location: manage_booking.php?success=2");
    exit;
}

$stmt = $conn->prepare("
    SELECT bookings.*,
           services.service_name,
           services.price AS service_price,
           users.name AS user_name,
           users.phone AS user_phone
    FROM bookings
    JOIN services ON bookings.service_id = services.id
    JOIN users ON bookings.user_id = users.id
    WHERE services.provider_id = ?
    ORDER BY bookings.created_at DESC
");
$stmt->execute([$provider_id]);
$bookings = $stmt->fetchAll();
?>

<div class="row align-items-center mb-4">
    <div class="col-md-8 d-flex align-items-center">
        <a href="dashboard.php" class="btn btn-light rounded-circle me-3 shadow-sm border" title="Back to Dashboard">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="fw-bold mb-1">Manage Bookings</h2>
            <p class="text-muted mb-0 small">Review requests, contact customers, and close completed jobs.</p>
        </div>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">
            <?= count($bookings) ?> Total Requests
        </span>
    </div>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success border-0 shadow-sm rounded-4">
        <?php if ($_GET['success'] === '1'): ?>
            Booking accepted successfully.
        <?php elseif ($_GET['success'] === '2'): ?>
            Booking marked as completed.
        <?php else: ?>
            Booking updated successfully.
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php if (count($bookings) === 0): ?>
    <div class="card border-0 shadow-sm text-center p-5 rounded-4 mt-4 animate-fade-in">
        <div class="icon-circle bg-light mx-auto mb-4" style="width: 80px; height: 80px; font-size: 35px;">
            <i class="fas fa-inbox text-muted opacity-30"></i>
        </div>
        <h4 class="fw-bold">No Requests Yet</h4>
        <p class="text-muted mx-auto mb-0" style="max-width: 400px;">When customers book your services, they will appear here for your review.</p>
    </div>
<?php else: ?>

<div class="row g-4 mt-2">
    <?php foreach ($bookings as $b):
        $statusClass = 'status-pending';
        $iconClass = 'fa-clock';

        if ($b['status'] === 'accepted') {
            $statusClass = 'status-accepted';
            $iconClass = 'fa-check-circle';
        }

        if ($b['status'] === 'completed') {
            $statusClass = 'status-completed';
            $iconClass = 'fa-check-double';
        }
    ?>
    <div class="col-lg-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100 hover-lift animate-fade-in" style="border-radius: 20px;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="status-badge <?= $statusClass ?> shadow-sm">
                        <i class="fas <?= $iconClass ?> me-1 small"></i> <?= ucfirst($b['status']) ?>
                    </span>
                    <div class="text-end">
                        <p class="x-small text-muted mb-0 fw-bold">SCHEDULED DATE</p>
                        <p class="small fw-bold text-dark mb-0"><?= date('D, d M Y', strtotime($b['booking_date'])) ?></p>
                    </div>
                </div>

                <h5 class="fw-bold mb-1"><?= htmlspecialchars($b['service_name']) ?></h5>
                <p class="text-muted small mb-3">Estimated earnings: ₹<?= number_format((float) $b['service_price'], 2) ?></p>

                <div class="bg-light rounded-4 p-3 mb-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-sm bg-white shadow-sm rounded-circle me-3 text-primary">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <p class="x-small text-muted mb-0">Customer</p>
                            <h6 class="fw-bold mb-0 small"><?= htmlspecialchars($b['user_name']) ?></h6>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top">
                    <?php if ($b['status'] === 'pending'): ?>
                        <div class="row g-2">
                            <div class="col-12">
                                <a href="?accept=<?= $b['id'] ?>" class="btn btn-success btn-pill w-100 fw-bold py-2 shadow-sm">
                                    <i class="fas fa-check me-2"></i>Accept Request
                                </a>
                            </div>
                            <?php if (!empty($b['user_phone'])): ?>
                                <div class="col-12">
                                    <a href="tel:<?= htmlspecialchars($b['user_phone']) ?>" class="btn btn-outline-dark btn-pill w-100 py-2 shadow-sm">
                                        <i class="fas fa-phone-alt me-2"></i>Call Customer
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php elseif ($b['status'] === 'accepted'): ?>
                        <div class="row g-2">
                            <div class="col-8">
                                <a href="?complete=<?= $b['id'] ?>" class="btn btn-primary btn-pill w-100 fw-bold py-2 shadow-sm">
                                    Mark Completed
                                </a>
                            </div>
                            <div class="col-4">
                                <?php if (!empty($b['user_phone'])): ?>
                                    <a href="tel:<?= htmlspecialchars($b['user_phone']) ?>" class="btn btn-outline-dark btn-pill w-100 py-2 shadow-sm">
                                        <i class="fas fa-phone-alt"></i>
                                    </a>
                                <?php else: ?>
                                    <button class="btn btn-outline-dark btn-pill w-100 py-2 shadow-sm" disabled>
                                        <i class="fas fa-phone-alt"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <button class="btn btn-light btn-pill w-100 fw-bold py-2 disabled opacity-50">
                            Service Completed
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php endif; ?>

<?php include '../includes/footer.php'; ?>
