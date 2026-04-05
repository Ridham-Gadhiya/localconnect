<?php
include '../includes/header.php';
include '../includes/auth_check.php';
require '../config/db.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// 1. Handle Approval Action
if (isset($_GET['approve'])) {
    $conn->prepare("UPDATE service_providers SET status='approved' WHERE id=?")->execute([$_GET['approve']]);
    header("Location: manage_providers.php?msg=approved");
    exit;
}

// 2. Handle Rejection Action
if (isset($_GET['reject'])) {
    $conn->prepare("UPDATE service_providers SET status='rejected' WHERE id=?")->execute([$_GET['reject']]);
    header("Location: manage_providers.php?msg=rejected");
    exit;
}

// 3. Fetch Providers (Pending ones first for better workflow)
$providers = $conn->query("SELECT * FROM service_providers ORDER BY CASE WHEN status = 'pending' THEN 1 ELSE 2 END, created_at DESC")->fetchAll();
?>

<div class="row align-items-center mb-4">
    <div class="col-md-8 d-flex align-items-center">
        <a href="dashboard.php" class="btn btn-light rounded-circle me-3 shadow-sm border" title="Back to Dashboard">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="fw-bold mb-1">Provider Verification</h2>
            <p class="text-muted mb-0 small">Review and manage business credentials for service providers</p>
        </div>
    </div>
</div>

<?php if (count($providers) === 0): ?>
    <div class="card border-0 shadow-sm text-center p-5 rounded-4 mt-4">
        <div class="icon-circle bg-light mx-auto mb-4" style="width: 80px; height: 80px; font-size: 35px;">
            <i class="fas fa-user-clock text-muted opacity-30"></i>
        </div>
        <h4 class="fw-bold">No Registrations Yet</h4>
        <p class="text-muted mx-auto mb-0" style="max-width: 400px;">New provider applications will appear here for your manual verification.</p>
    </div>
<?php else: ?>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden mt-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-dark text-white">
                <tr>
                    <th class="ps-4 py-3 border-0 small text-uppercase ls-1">Provider Info</th>
                    <th class="border-0 small text-uppercase ls-1">Contact Details</th>
                    <th class="border-0 small text-uppercase ls-1">Verification Status</th>
                    <th class="border-0 small text-uppercase ls-1 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($providers as $p): 
                    $statusClass = 'status-pending';
                    if ($p['status'] === 'approved') $statusClass = 'status-accepted';
                    if ($p['status'] === 'rejected') $statusClass = 'status-rejected';
                ?>
                <tr class="animate-fade-in">
                    <td class="ps-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 40px; height: 40px;">
                                <?= strtoupper(substr($p['name'], 0, 1)) ?>
                            </div>
                            <div>
                                <div class="fw-bold text-dark"><?= htmlspecialchars($p['name']) ?></div>
                                <div class="x-small text-muted">Joined: <?= date('d M, Y', strtotime($p['created_at'])) ?></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="small fw-bold text-dark mb-1"><i class="fas fa-envelope me-2 text-muted"></i><?= htmlspecialchars($p['email']) ?></div>
                        <div class="small text-muted"><i class="fas fa-phone me-2"></i><?= htmlspecialchars($p['phone'] ?? 'N/A') ?></div>
                    </td>
                    <td>
                        <span class="status-badge <?= $statusClass ?> py-2 px-3">
                            <i class="fas <?= ($p['status'] === 'approved' ? 'fa-check-circle' : ($p['status'] === 'rejected' ? 'fa-times-circle' : 'fa-spinner fa-spin')) ?> me-1"></i> 
                            <?= ucfirst($p['status']) ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <?php if ($p['status'] === 'pending'): ?>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="?approve=<?= $p['id'] ?>" class="btn btn-success btn-sm rounded-pill px-3 shadow-sm fw-bold">
                                    <i class="fas fa-check me-1"></i> Approve
                                </a>
                                <a href="?reject=<?= $p['id'] ?>" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold" 
                                   onclick="return confirm('Are you sure you want to reject this provider?');">
                                    <i class="fas fa-ban me-1"></i> Reject
                                </a>
                            </div>
                        <?php else: ?>
                            <span class="text-muted x-small">Action Logged</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php endif; ?>

<?php include '../includes/footer.php'; ?>