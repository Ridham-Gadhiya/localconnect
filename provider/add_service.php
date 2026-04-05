<?php
include '../includes/header.php';
include '../includes/auth_check.php';
require '../config/db.php';

if ($_SESSION['role'] !== 'provider') {
    header("Location: ../auth/login.php");
    exit;
}

$provider_id = $_SESSION['provider_id'];

// Fetch categories for the dropdown
$catStmt = $conn->prepare("SELECT * FROM categories ORDER BY category_name ASC");
$catStmt->execute();
$categories = $catStmt->fetchAll();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service_name = $_POST['service_name'];
    $category_id = $_POST['category_id'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $stmt = $conn->prepare(
        "INSERT INTO services (provider_id, category_id, service_name, description, price)
         VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->execute([$provider_id, $category_id, $service_name, $description, $price]);

    header("Location: manage_services.php");
    exit;
}
?>

<div class="row align-items-center mb-4">
    <div class="col-md-8 d-flex align-items-center">
        <a href="dashboard.php" class="btn btn-light rounded-circle me-3 shadow-sm border" title="Back to Dashboard">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="fw-bold mb-1">Add New Service</h2>
            <p class="text-muted mb-0 small">Showcase your expertise to potential customers</p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card form-card border-0 shadow-sm" style="border-radius: 24px;">
            <div class="card-body p-4 p-md-5">
                
                <div class="mb-4 pb-3 border-bottom">
                    <h5 class="fw-bold"><i class="fas fa-info-circle text-primary me-2"></i>Service Information</h5>
                    <p class="text-muted small">Provide clear details to help users understand what you offer.</p>
                </div>

                <form method="POST">
                    <div class="row g-4">
                        <div class="col-md-7">
                            <label class="form-label fw-bold small text-uppercase ls-1">Service Title</label>
                            <input name="service_name" class="form-control form-control-lg shadow-none" 
                                   placeholder="e.g. Professional Home Plumbing" required>
                        </div>

                        <div class="col-md-5">
                            <label class="form-label fw-bold small text-uppercase ls-1">Category</label>
                            <select name="category_id" class="form-select form-select-lg shadow-none" required>
                                <option value="">Choose...</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>">
                                        <?= htmlspecialchars($cat['category_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold small text-uppercase ls-1">Service Description</label>
                            <textarea name="description" class="form-control shadow-none" rows="4" 
                                      placeholder="Explain exactly what is included in this service..."></textarea>
                            <div class="form-text small">Briefly describe the tasks you will perform.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase ls-1">Price per Task</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted">₹</span>
                                <input type="number" name="price" class="form-control form-control-lg border-start-0 shadow-none ps-0" 
                                       placeholder="0.00" required>
                            </div>
                        </div>

                        <div class="col-12 pt-3">
                            <hr class="opacity-10 mb-4">
                            <div class="d-flex gap-3">
                                <button type="submit" class="btn btn-primary btn-lg btn-pill px-5 fw-bold shadow">
                                    <i class="fas fa-plus-circle me-2"></i>Publish Service
                                </button>
                                <a href="dashboard.php" class="btn btn-light btn-lg btn-pill px-4">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>