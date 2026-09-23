<?php
include '../includes/header.php';
include '../includes/auth_check.php';
require '../config/db.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$error = "";

// Handle Add Category
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['category_name'])) {
    $category_name = trim($_POST['category_name']);
    if (!empty($category_name)) {
        // Check for duplicate category name
        $check = $conn->prepare("SELECT id FROM categories WHERE LOWER(category_name) = LOWER(?)");
        $check->execute([$category_name]);
        if ($check->fetch()) {
            $error = "A category with this name already exists.";
        } else {
            $stmt = $conn->prepare("INSERT INTO categories (category_name) VALUES (?)");
            $stmt->execute([$category_name]);
            header("Location: manage_categories.php?msg=added");
            exit;
        }
    }
}

// Handle Delete Category
if (isset($_GET['delete'])) {
    $delId = intval($_GET['delete']);
    // Check if services are currently assigned to this category
    $svcCheck = $conn->prepare("SELECT COUNT(*) FROM services WHERE category_id = ?");
    $svcCheck->execute([$delId]);
    $svcCount = $svcCheck->fetchColumn();

    if ($svcCount > 0) {
        header("Location: manage_categories.php?msg=in_use&count=" . $svcCount);
        exit;
    } else {
        $stmt = $conn->prepare("DELETE FROM categories WHERE id=?");
        $stmt->execute([$delId]);
        header("Location: manage_categories.php?msg=deleted");
        exit;
    }
}

$categories = $conn->query("
    SELECT c.*, COUNT(s.id) as service_count 
    FROM categories c 
    LEFT JOIN services s ON c.id = s.category_id 
    GROUP BY c.id 
    ORDER BY c.category_name ASC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="row align-items-center mb-4">
    <div class="col-md-8 d-flex align-items-center">
        <a href="dashboard.php" class="btn btn-light rounded-circle me-3 shadow-sm border" title="Back to Admin Dashboard">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="fw-bold mb-1">Service Categories</h2>
            <p class="text-muted mb-0 small">Manage the taxonomy and classification system for all platform services</p>
        </div>
    </div>
</div>

<?php if (isset($_GET['msg'])): ?>
    <?php if ($_GET['msg'] === 'added'): ?>
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">New category created successfully.</div>
    <?php elseif ($_GET['msg'] === 'deleted'): ?>
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">Category deleted successfully.</div>
    <?php elseif ($_GET['msg'] === 'in_use'): ?>
        <div class="alert alert-warning border-0 shadow-sm rounded-4 mb-4">Cannot delete category: <?= intval($_GET['count'] ?? 1) ?> active services are currently assigned to it.</div>
    <?php endif; ?>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm p-3" style="border-radius: 20px;">
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <div class="icon-sm bg-primary bg-opacity-10 text-primary rounded-3 me-3 p-2">
                        <i class="fas fa-folder-plus fs-5"></i>
                    </div>
                    <h5 class="fw-bold mb-0">New Category</h5>
                </div>
                
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase ls-1">Category Title <span class="text-danger">*</span></label>
                        <input name="category_name" class="form-control form-control-lg shadow-none" 
                               placeholder="e.g., Appliance Repair" required>
                    </div>
                    <button class="btn btn-primary btn-lg btn-pill w-100 fw-bold shadow-sm">
                        <i class="fas fa-plus-circle me-2"></i>Create Category
                    </button>
                </form>
            </div>
        </div>
        
        <div class="alert alert-light border-0 mt-4 small shadow-sm rounded-4">
            <i class="fas fa-info-circle text-info me-2"></i>
            Categories help customers discover relevant local pros quickly.
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th class="ps-4 py-3 border-0 small text-uppercase ls-1">Category Name</th>
                            <th class="border-0 small text-uppercase ls-1">Linked Services</th>
                            <th class="border-0 small text-uppercase ls-1 text-center">Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $c): ?>
                        <tr class="animate-fade-in">
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="icon-sm bg-light rounded-circle me-3 text-secondary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 12px;">
                                        <i class="fas fa-tag text-primary"></i>
                                    </div>
                                    <span class="fw-bold text-dark"><?= htmlspecialchars($c['category_name']) ?></span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border rounded-pill px-3 py-1 small">
                                    <?= $c['service_count'] ?> active listings
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="?delete=<?= $c['id'] ?>" 
                                   class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold shadow-sm"
                                   onclick="return confirm('Are you sure you want to delete this category?');">
                                    <i class="fas fa-trash-alt me-1"></i> Delete
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; if(empty($categories)) echo "<tr><td colspan='3' class='text-center p-5 text-muted'>No categories defined yet.</td></tr>"; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>