<?php
include '../includes/header.php';
include '../includes/auth_check.php';
require '../config/db.php';

if ($_SESSION['role'] !== 'provider') {
    header("Location: ../auth/login.php");
    exit;
}

$provider_id = $_SESSION['provider_id'];

// Handle Deletion
if (isset($_GET['delete'])) {
    $stmt = $conn->prepare("DELETE FROM services WHERE id = ? AND provider_id = ?");
    $stmt->execute([$_GET['delete'], $provider_id]);
    header("Location: manage_services.php?msg=deleted");
    exit;
}

// Fetch services
$stmt = $conn->prepare("
    SELECT services.*, categories.category_name
    FROM services
    JOIN categories ON services.category_id = categories.id
    WHERE services.provider_id = ?
    ORDER BY services.created_at DESC
");
$stmt->execute([$provider_id]);
$services = $stmt->fetchAll();
?>

<div class="row align-items-center mb-4">
    <div class="col-md-8 d-flex align-items-center">
        <a href="dashboard.php" class="btn btn-light rounded-circle me-3 shadow-sm border" title="Back to Dashboard">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="fw-bold mb-1">Manage Services</h2>
            <p class="text-muted mb-0 small">View and manage all services you offer on the platform</p>
        </div>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="add_service.php" class="btn btn-primary btn-pill shadow-sm fw-bold">
            <i class="fas fa-plus me-2"></i>Add New Service
        </a>
    </div>
</div>

<?php if (count($services) === 0): ?>
    <div class="card border-0 shadow-sm text-center p-5 rounded-4 mt-4 animate-fade-in">
        <div class="icon-circle bg-light mx-auto mb-4" style="width: 80px; height: 80px; font-size: 35px;">
            <i class="fas fa-concierge-bell text-muted opacity-30"></i>
        </div>
        <h4 class="fw-bold">Your Inventory is Empty</h4>
        <p class="text-muted mx-auto mb-4" style="max-width: 400px;">Start reaching customers by adding your first service offering to the platform.</p>
        <a href="add_service.php" class="btn btn-primary btn-pill px-5">Add My First Service</a>
    </div>
<?php else: ?>

<div class="row g-4 mt-2">
    <?php foreach ($services as $s): ?>
    <div class="col-12 animate-fade-in">
        <div class="card border-0 shadow-sm overflow-hidden h-100" style="border-radius: 18px;">
            <div class="card-body p-0">
                <div class="row g-0 align-items-center">
                    <div class="col-md-auto bg-primary bg-opacity-10 d-flex align-items-center justify-content-center py-4 px-3" style="min-width: 120px;">
                        <span class="text-primary fw-bold small text-uppercase ls-1" style="writing-mode: vertical-lr; transform: rotate(180deg);">
                            <?= htmlspecialchars($s['category_name']) ?>
                        </span>
                    </div>
                    
                    <div class="col-md p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="fw-bold mb-1 text-dark"><?= htmlspecialchars($s['service_name']) ?></h5>
                                <p class="text-muted small mb-0"><?= htmlspecialchars(substr($s['description'], 0, 100)) ?>...</p>
                            </div>
                            <div class="text-end ps-3">
                                <p class="x-small text-muted mb-0 fw-bold ls-1 text-uppercase">Standard Rate</p>
                                <h4 class="fw-bold text-dark mb-0">₹<?= htmlspecialchars($s['price']) ?></h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-auto p-4 bg-light border-start text-center" style="min-width: 150px;">
                        <div class="d-flex d-md-block gap-2 justify-content-center">
                            <a href="?delete=<?= $s['id'] ?>" 
                               class="btn btn-outline-danger btn-sm w-100 rounded-pill mb-md-2"
                               onclick="return confirm('Delete this service permanently?');">
                                <i class="fas fa-trash-alt me-1"></i> Delete
                            </a>
                            <button class="btn btn-light btn-sm w-100 rounded-pill border" disabled title="Editing coming soon">
                                <i class="fas fa-edit me-1"></i> Edit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php endif; ?>

<?php include '../includes/footer.php'; ?>