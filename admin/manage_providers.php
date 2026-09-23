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
    $conn->prepare("UPDATE service_providers SET status='approved' WHERE id=?")->execute([intval($_GET['approve'])]);
    header("Location: manage_providers.php?msg=approved");
    exit;
}

// 2. Handle Rejection Action
if (isset($_GET['reject'])) {
    $conn->prepare("UPDATE service_providers SET status='rejected' WHERE id=?")->execute([intval($_GET['reject'])]);
    header("Location: manage_providers.php?msg=rejected");
    exit;
}

// 3. Handle Deletion Action
if (isset($_GET['delete'])) {
    $delId = intval($_GET['delete']);
    // Remove services and bookings or delete provider
    $conn->prepare("DELETE FROM service_providers WHERE id=?")->execute([$delId]);
    header("Location: manage_providers.php?msg=deleted");
    exit;
}

// 4. Fetch Providers
$providers = $conn->query("SELECT * FROM service_providers ORDER BY CASE WHEN status = 'pending' THEN 1 ELSE 2 END, created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="row align-items-center mb-4">
    <div class="col-md-8 d-flex align-items-center">
        <a href="dashboard.php" class="btn btn-light rounded-circle me-3 shadow-sm border" title="Back to Dashboard">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="fw-bold mb-1">Provider Verification & Control</h2>
            <p class="text-muted mb-0 small">Review credentials, grant platform access, and manage verified partners</p>
        </div>
    </div>
</div>

<?php if (isset($_GET['msg'])): ?>
    <?php if ($_GET['msg'] === 'approved'): ?>
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">Provider approved successfully. They can now log in and offer services.</div>
    <?php elseif ($_GET['msg'] === 'rejected'): ?>
        <div class="alert alert-warning border-0 shadow-sm rounded-4 mb-4">Provider status set to rejected.</div>
    <?php elseif ($_GET['msg'] === 'deleted'): ?>
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">Provider account permanently removed.</div>
    <?php endif; ?>
<?php endif; ?>

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
                    <th class="border-0 small text-uppercase ls-1 text-center">Manage Status</th>
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
                        <div class="small text-muted"><i class="fas fa-phone me-2"></i><?= htmlspecialchars($p['phone'] ?: 'N/A') ?></div>
                    </td>
                    <td>
                        <span class="status-badge <?= $statusClass ?> py-2 px-3">
                            <i class="fas <?= ($p['status'] === 'approved' ? 'fa-check-circle' : ($p['status'] === 'rejected' ? 'fa-times-circle' : 'fa-clock')) ?> me-1"></i> 
                            <?= ucfirst($p['status']) ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <?php if ($p['status'] !== 'approved'): ?>
                                <a href="?approve=<?= $p['id'] ?>" class="btn btn-success btn-sm rounded-pill px-3 shadow-sm fw-bold">
                                    <i class="fas fa-check me-1"></i> Approve
                                </a>
                            <?php endif; ?>
                            
                            <?php if ($p['status'] !== 'rejected'): ?>
                                <a href="?reject=<?= $p['id'] ?>" class="btn btn-outline-warning btn-sm rounded-pill px-3 fw-bold" 
                                   onclick="return confirm('Revoke approval or reject this provider?');">
                                    <i class="fas fa-ban me-1"></i> Reject
                                </a>
                            <?php endif; ?>

                            <a href="?delete=<?= $p['id'] ?>" class="btn btn-outline-danger btn-sm rounded-pill px-2 fw-bold" 
                               onclick="return confirm('Permanently delete this provider account? This cannot be undone.');" title="Delete Account">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php endif; ?>

<?php include '../includes/footer.php'; ?>