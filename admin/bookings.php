<?php
include '../includes/header.php';
include '../includes/auth_check.php';
require '../config/db.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Enhanced Query to include Provider Name for better Admin oversight
$stmt = $conn->prepare("
    SELECT b.*, 
           u.name AS user_name,
           s.service_name,
           p.name AS provider_name
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    JOIN services s ON b.service_id = s.id
    JOIN service_providers p ON s.provider_id = p.id
    ORDER BY b.created_at DESC
");
$stmt->execute();
$bookings = $stmt->fetchAll();
?>

<div class="row align-items-center mb-4">
    <div class="col-md-8 d-flex align-items-center">
        <a href="dashboard.php" class="btn btn-light rounded-circle me-3 shadow-sm border" title="Back to Admin Dashboard">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="fw-bold mb-1">Global Booking Monitor</h2>
            <p class="text-muted mb-0 small">Audit all service transactions occurring across the platform</p>
        </div>
    </div>
</div>

<?php if (count($bookings) === 0): ?>
    <div class="card border-0 shadow-sm text-center p-5 rounded-4 mt-4">
        <div class="icon-circle bg-light mx-auto mb-4" style="width: 80px; height: 80px; font-size: 35px;">
            <i class="fas fa-history text-muted opacity-30"></i>
        </div>
        <h4 class="fw-bold text-muted">No System Activity</h4>
        <p class="text-muted mx-auto mb-0" style="max-width: 400px;">When users start booking services, the transaction log will populate here.</p>
    </div>
<?php else: ?>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden mt-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-dark text-white">
                <tr>
                    <th class="ps-4 py-3 border-0 small text-uppercase ls-1">Customer</th>
                    <th class="border-0 small text-uppercase ls-1">Service & Provider</th>
                    <th class="border-0 small text-uppercase ls-1">Scheduled Date</th>
                    <th class="border-0 small text-uppercase ls-1">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $b):
                    $statusClass = 'status-pending';
                    $icon = 'fa-clock';
                    if ($b['status'] === 'accepted') { $statusClass = 'status-accepted'; $icon = 'fa-check-circle'; }
                    if ($b['status'] === 'completed') { $statusClass = 'status-completed'; $icon = 'fa-star'; }
                    if ($b['status'] === 'rejected') { $statusClass = 'status-rejected'; $icon = 'fa-times-circle'; }
                ?>
                <tr class="animate-fade-in">
                    <td class="ps-4">
                        <div class="fw-bold text-dark"><?= htmlspecialchars($b['user_name']) ?></div>
                        <div class="x-small text-muted">ID: #USR-<?= $b['user_id'] ?></div>
                    </td>
                    <td>
                        <div class="fw-bold text-primary"><?= htmlspecialchars($b['service_name']) ?></div>
                        <div class="small text-muted"><i class="fas fa-user-tie me-1"></i> <?= htmlspecialchars($b['provider_name']) ?></div>
                    </td>
                    <td>
                        <div class="fw-bold text-dark small"><?= date('D, d M Y', strtotime($b['booking_date'])) ?></div>
                    </td>
                    <td>
                        <span class="status-badge <?= $statusClass ?> py-2 px-3">
                            <i class="fas <?= $icon ?> me-1"></i> <?= ucfirst($b['status']) ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php endif; ?>

<?php include '../includes/footer.php'; ?>