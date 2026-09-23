<?php
include '../includes/header.php';
include '../includes/auth_check.php';
require '../config/db.php';

if ($_SESSION['role'] !== 'provider') {
    header("Location: ../auth/login.php");
    exit;
}

$provider_id = $_SESSION['provider_id'];

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: manage_services.php");
    exit;
}

$service_id = intval($_GET['id']);

// Fetch service details verifying provider ownership
$stmt = $conn->prepare("SELECT * FROM services WHERE id = ? AND provider_id = ?");
$stmt->execute([$service_id, $provider_id]);
$service = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$service) {
    header("Location: manage_services.php?msg=not_found");
    exit;
}

// Fetch categories for the dropdown
$catStmt = $conn->query("SELECT * FROM categories ORDER BY category_name ASC");
$categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $service_name = trim($_POST['service_name']);
    $category_id = intval($_POST['category_id']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);

    if (empty($service_name) || empty($category_id) || $price <= 0) {
        $error = "Please fill in all required fields with a valid price.";
    } else {
        $updateStmt = $conn->prepare("
            UPDATE services 
            SET service_name = ?, category_id = ?, description = ?, price = ?
            WHERE id = ? AND provider_id = ?
        ");
        $updateStmt->execute([$service_name, $category_id, $description, $price, $service_id, $provider_id]);

        header("Location: manage_services.php?msg=updated");
        exit;
    }
}
?>

<div class="row align-items-center mb-4">
    <div class="col-md-8 d-flex align-items-center">
        <a href="manage_services.php" class="btn btn-light rounded-circle me-3 shadow-sm border" title="Back to Services">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="fw-bold mb-1">Edit Service Listing</h2>
            <p class="text-muted mb-0 small">Update your service description, category, or pricing</p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card form-card border-0 shadow-sm" style="border-radius: 24px;">
            <div class="card-body p-4 p-md-5">
                
                <div class="mb-4 pb-3 border-bottom">
                    <h5 class="fw-bold"><i class="fas fa-edit text-primary me-2"></i>Service Information</h5>
                    <p class="text-muted small mb-0">Changes will be reflected immediately in search results.</p>
                </div>

                <?php if(!empty($error)): ?>
                  <div class="alert alert-danger border-0 small rounded-3 mb-4 d-flex align-items-center">
                    <i class="fas fa-exclamation-circle me-2 fs-5"></i>
                    <div><?= htmlspecialchars($error) ?></div>
                  </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="row g-4">
                        <div class="col-md-7">
                            <label class="form-label fw-bold small text-uppercase ls-1">Service Title <span class="text-danger">*</span></label>
                            <input name="service_name" class="form-control form-control-lg shadow-none" 
                                   placeholder="e.g. Professional Home Plumbing" 
                                   value="<?= htmlspecialchars($service['service_name']) ?>" required>
                        </div>

                        <div class="col-md-5">
                            <label class="form-label fw-bold small text-uppercase ls-1">Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select form-select-lg shadow-none" required>
                                <option value="">Choose Category...</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>" <?= ($service['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cat['category_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold small text-uppercase ls-1">Service Description</label>
                            <textarea name="description" class="form-control shadow-none" rows="4" 
                                      placeholder="Explain exactly what is included in this service..."><?= htmlspecialchars($service['description']) ?></textarea>
                            <div class="form-text small">Briefly describe the tasks you will perform.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase ls-1">Price per Task (₹) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted">₹</span>
                                <input type="number" step="0.01" name="price" class="form-control form-control-lg border-start-0 shadow-none ps-0" 
                                       placeholder="0.00" value="<?= htmlspecialchars($service['price']) ?>" required>
                            </div>
                        </div>

                        <div class="col-12 pt-3">
                            <hr class="opacity-10 mb-4">
                            <div class="d-flex gap-3">
                                <button type="submit" class="btn btn-primary btn-lg btn-pill px-5 fw-bold shadow-sm">
                                    <i class="fas fa-save me-2"></i>Update Service
                                </button>
                                <a href="manage_services.php" class="btn btn-light btn-lg btn-pill px-4">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
