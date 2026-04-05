<?php
include '../includes/header.php';
include '../includes/auth_check.php';
require '../config/db.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Handle Add Category
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['category_name'])) {
    $category_name = trim($_POST['category_name']);
    if (!empty($category_name)) {
        $stmt = $conn->prepare("INSERT INTO categories (category_name) VALUES (?)");
        $stmt->execute([$category_name]);
        header("Location: manage_categories.php?msg=added");
        exit;
    }
}

// Handle Delete Category
if (isset($_GET['delete'])) {
    $stmt = $conn->prepare("DELETE FROM categories WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    header("Location: manage_categories.php?msg=deleted");
    exit;
}

$categories = $conn->query("SELECT * FROM categories ORDER BY category_name ASC")->fetchAll();
?>

<div class="row align-items-center mb-4">
    <div class="col-md-8 d-flex align-items-center">
        <a href="dashboard.php" class="btn btn-light rounded-circle me-3 shadow-sm border" title="Back to Admin Dashboard">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="fw-bold mb-1">Service Categories</h2>
            <p class="text-muted mb-0 small">Manage the classification system for all platform services</p>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm p-3" style="border-radius: 20px;">
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <div class="icon-sm bg-primary-soft text-primary rounded-3 me-3">
                        <i class="fas fa-folder-plus"></i>
                    </div>
                    <h5 class="fw-bold mb-0">New Category</h5>
                </div>
                
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase ls-1">Category Title</label>
                        <input name="category_name" class="form-control form-control-lg shadow-none" 
                               placeholder="e.g., Home Maintenance" required>
                    </div>
                    <button class="btn btn-primary btn-lg btn-pill w-100 fw-bold shadow-sm">
                        <i class="fas fa-plus-circle me-2"></i>Create Category
                    </button>
                </form>
            </div>
        </div>
        
        <div class="alert alert-light border-0 mt-4 small shadow-sm rounded-4">
            <i class="fas fa-info-circle text-info me-2"></i>
            Categories help users find services faster. Use clear, broad terms.
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th class="ps-4 py-3 border-0 small text-uppercase ls-1">Category Name</th>
                            <th class="border-0 small text-uppercase ls-1 text-center">Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $c): ?>
                        <tr class="animate-fade-in">
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="icon-sm bg-light rounded-circle me-3 text-secondary" style="width: 32px; height: 32px; font-size: 12px;">
                                        <i class="fas fa-tag"></i>
                                    </div>
                                    <span class="fw-bold text-dark"><?= htmlspecialchars($c['category_name']) ?></span>
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="?delete=<?= $c['id'] ?>" 
                                   class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold shadow-sm"
                                   onclick="return confirm('Deleting a category may affect existing services. Proceed?');">
                                    <i class="fas fa-trash-alt me-1"></i> Delete
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; if(empty($categories)) echo "<tr><td colspan='2' class='text-center p-5 text-muted'>No categories defined yet.</td></tr>"; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>