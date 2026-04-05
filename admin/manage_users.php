<?php
include '../includes/header.php';
include '../includes/auth_check.php';
require '../config/db.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Handle User Deletion
if (isset($_GET['delete'])) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    header("Location: manage_users.php?msg=deleted");
    exit;
}

// Fetch all registered customers
$users = $conn->query("SELECT * FROM users ORDER BY created_at DESC")->fetchAll();
?>

<div class="row align-items-center mb-4">
    <div class="col-md-8 d-flex align-items-center">
        <a href="dashboard.php" class="btn btn-light rounded-circle me-3 shadow-sm border" title="Back to Admin Dashboard">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="fw-bold mb-1">Customer Directory</h2>
            <p class="text-muted mb-0 small">Manage registered user accounts and platform access</p>
        </div>
    </div>
</div>

<?php if (count($users) === 0): ?>
    <div class="card border-0 shadow-sm text-center p-5 rounded-4 mt-4 animate-fade-in">
        <div class="icon-circle bg-light mx-auto mb-4" style="width: 80px; height: 80px; font-size: 35px;">
            <i class="fas fa-users-slash text-muted opacity-30"></i>
        </div>
        <h4 class="fw-bold text-muted">No Users Registered</h4>
        <p class="text-muted mx-auto mb-0" style="max-width: 400px;">When customers sign up for LocalConnect, they will be listed here.</p>
    </div>
<?php else: ?>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden mt-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-dark text-white">
                <tr>
                    <th class="ps-4 py-3 border-0 small text-uppercase ls-1">User Profile</th>
                    <th class="border-0 small text-uppercase ls-1">Contact Information</th>
                    <th class="border-0 small text-uppercase ls-1">Registration Date</th>
                    <th class="border-0 small text-uppercase ls-1 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                <tr class="animate-fade-in">
                    <td class="ps-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 40px; height: 40px;">
                                <?= strtoupper(substr($u['name'], 0, 1)) ?>
                            </div>
                            <div>
                                <div class="fw-bold text-dark"><?= htmlspecialchars($u['name']) ?></div>
                                <div class="x-small text-muted text-uppercase fw-bold ls-1">Customer Account</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="small text-dark mb-1 fw-bold"><i class="fas fa-envelope me-2 text-muted"></i><?= htmlspecialchars($u['email']) ?></div>
                        <div class="small text-muted"><i class="fas fa-phone me-2"></i><?= htmlspecialchars($u['phone'] ?: 'No phone provided') ?></div>
                    </td>
                    <td>
                        <div class="small fw-bold text-dark"><?= date('M d, Y', strtotime($u['created_at'])) ?></div>
                    </td>
                    <td class="text-center">
                        <a href="?delete=<?= $u['id'] ?>" 
                           class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold"
                           onclick="return confirm('WARNING: This will permanently delete this user account. Proceed?');">
                            <i class="fas fa-user-minus me-1"></i> Delete
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php endif; ?>

<?php include '../includes/footer.php'; ?>