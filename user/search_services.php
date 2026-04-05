<?php
include '../includes/header.php';
include '../includes/auth_check.php';
require '../config/db.php';

// Check if user is logged in
if ($_SESSION['role'] !== 'user') {
    header("Location: ../auth/login.php");
    exit;
}

// 1. GET FILTER PARAMETERS
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';

// 2. FETCH CATEGORIES FOR DROPDOWN
$cat_stmt = $conn->prepare("SELECT * FROM categories ORDER BY category_name ASC");
$cat_stmt->execute();
$all_categories = $cat_stmt->fetchAll();

// 3. BUILD DYNAMIC SQL QUERY
$sql = "SELECT services.*, 
               categories.category_name, 
               service_providers.name AS provider_name
        FROM services
        JOIN categories ON services.category_id = categories.id
        JOIN service_providers ON services.provider_id = service_providers.id
        WHERE 1=1"; // Placeholder to allow easy appending of AND clauses

$params = [];

if (!empty($search)) {
    $sql .= " AND services.service_name LIKE ?";
    $params[] = "%$search%";
}

if (!empty($category_id) && $category_id !== 'All Categories') {
    $sql .= " AND services.category_id = ?";
    $params[] = $category_id;
}

$sql .= " ORDER BY services.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$services = $stmt->fetchAll();
?>

<div class="row align-items-center mb-4">
    <div class="col-md-8 d-flex align-items-center">
        <a href="dashboard.php" class="btn btn-light rounded-circle me-3 shadow-sm border" title="Back to Dashboard">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="fw-bold mb-1">Find Local Services</h2>
            <p class="text-muted mb-0">Browse verified professionals and book high-quality services instantly.</p>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm p-3 mb-5" style="border-radius: 20px; background: #ffffff;">
    <form method="GET" action="search_services.php" class="row g-2 align-items-center">
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-search"></i></span>
                <input type="text" name="search" class="form-control border-start-0 ps-0 shadow-none" 
                       placeholder="Search by service name..." value="<?= htmlspecialchars($search) ?>">
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-th-large"></i></span>
                <select name="category_id" class="form-select border-start-0 ps-0 shadow-none">
                    <option value="">All Categories</option>
                    <?php foreach ($all_categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= ($category_id == $cat['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['category_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100 btn-pill fw-bold py-2">Search Services</button>
        </div>
    </form>
</div>

<?php if (!empty($search) || !empty($category_id)): ?>
    <div class="mb-4">
        <p class="text-muted">Showing results for: 
            <strong><?= !empty($search) ? htmlspecialchars($search) : 'All Services' ?></strong> 
            in <strong><?= !empty($category_id) ? 'Selected Category' : 'All Categories' ?></strong>
            <a href="search_services.php" class="ms-2 small text-danger text-decoration-none">Clear Filters</a>
        </p>
    </div>
<?php endif; ?>

<div class="row">
<?php if (count($services) === 0): ?>
    <div class="col-12 text-center py-5 card border-0 shadow-sm rounded-4">
        <div class="icon-circle bg-light mx-auto mb-3" style="width: 80px; height: 80px; font-size: 40px;">
            <i class="fas fa-search-minus text-muted opacity-30"></i>
        </div>
        <h4 class="fw-bold">No services found</h4>
        <p class="text-muted">Try adjusting your keywords or category filters.</p>
        <a href="search_services.php" class="btn btn-outline-primary btn-pill px-4">View All Services</a>
    </div>
<?php endif; ?>

<?php foreach ($services as $service): ?>
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card service-card h-100 border-0 shadow-sm hover-lift" style="border-radius: 20px;">
            <div class="card-body p-4 d-flex flex-column">
                
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="badge bg-primary-soft text-primary rounded-pill px-3 py-2 small">
                        <?= htmlspecialchars($service['category_name']) ?>
                    </span>
                    <div class="text-warning small">
                        <i class="fas fa-star"></i> 4.8
                    </div>
                </div>

                <h5 class="fw-bold mb-1 text-dark">
                    <?= htmlspecialchars($service['service_name']) ?>
                </h5>

                <p class="small text-muted mb-3">
                    <i class="fas fa-user-circle me-1"></i> <?= htmlspecialchars($service['provider_name']) ?>
                </p>

                <p class="card-text text-muted small mb-4">
                    <?= htmlspecialchars($service['description']) ?>
                </p>

                <div class="mt-auto pt-3 border-top">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted small fw-semibold">Service Price</span>
                        <span class="fs-4 fw-bold text-dark">₹<?= htmlspecialchars($service['price']) ?></span>
                    </div>

                    <a href="book_service.php?id=<?= $service['id'] ?>"
                       class="btn btn-dark w-100 btn-pill py-2 fw-bold">
                        Book Now <i class="fas fa-arrow-right ms-2 small"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>

<?php include '../includes/footer.php'; ?>