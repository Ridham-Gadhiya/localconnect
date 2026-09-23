<?php
include '../includes/header.php';
include '../includes/auth_check.php';
require '../config/db.php';

// Check if user is logged in as a customer
if ($_SESSION['role'] !== 'user') {
    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: search_services.php");
    exit;
}

$service_id = intval($_GET['id']);

// Fetch service details verifying provider is approved
$stmt = $conn->prepare("
    SELECT services.id, services.service_name, services.price, services.description,
           categories.category_name,
           service_providers.name AS provider_name
    FROM services
    JOIN categories ON services.category_id = categories.id
    JOIN service_providers ON services.provider_id = service_providers.id
    WHERE services.id = ? AND service_providers.status = 'approved'
");
$stmt->execute([$service_id]);
$service = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$service) {
    echo "
    <div class='container my-5 py-5 text-center'>
        <div class='card border-0 shadow-sm p-5 mx-auto rounded-4' style='max-width: 500px;'>
            <div class='icon-circle bg-light mx-auto mb-3' style='width: 70px; height: 70px; font-size: 30px;'>
                <i class='fas fa-exclamation-triangle text-warning'></i>
            </div>
            <h4 class='fw-bold mb-2'>Service Unavailable</h4>
            <p class='text-muted mb-4'>The requested service could not be found or is currently inactive.</p>
            <a href='search_services.php' class='btn btn-primary btn-pill px-4'>Explore Available Services</a>
        </div>
    </div>";
    include '../includes/footer.php';
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_date = $_POST['booking_date'];
    $user_id = $_SESSION['user_id'];

    if (!empty($booking_date)) {
        $stmt = $conn->prepare(
            "INSERT INTO bookings (user_id, service_id, booking_date, status)
             VALUES (?, ?, ?, 'pending')"
        );
        $stmt->execute([$user_id, $service_id, $booking_date]);

        echo "
        <div class='container my-5 py-5 text-center'>
            <div class='card border-0 shadow-sm p-5 mx-auto animate-fade-in' style='max-width: 500px; border-radius: 24px;'>
                <div class='icon-circle bg-success bg-opacity-10 text-success mx-auto mb-4' style='width: 80px; height: 80px; font-size: 40px;'>
                    <i class='fas fa-check-circle'></i>
                </div>
                <h2 class='fw-bold mb-2'>Booking Confirmed!</h2>
                <p class='text-muted mb-4 px-4'>Your request for <strong>" . htmlspecialchars($service['service_name']) . "</strong> on <strong>" . date('D, d M Y', strtotime($booking_date)) . "</strong> has been sent to the provider.</p>
                <div class='d-grid gap-2'>
                    <a href='my_bookings.php' class='btn btn-primary btn-pill py-3 fw-bold'>
                        <i class='fas fa-list-ul me-2'></i>View My Bookings
                    </a>
                    <a href='search_services.php' class='btn btn-link text-decoration-none text-muted small'>Book another service</a>
                </div>
            </div>
        </div>
        ";
        include '../includes/footer.php';
        exit;
    }
}
?>

<div class="row justify-content-center py-4">
    <div class="col-lg-10">
        <div class="d-flex align-items-center mb-4">
            <a href="search_services.php" class="btn btn-light rounded-circle me-3 shadow-sm border" title="Back to Services">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="fw-bold mb-0">Confirm Your Booking</h2>
                <p class="text-muted mb-0 small">Review details and choose your preferred appointment date</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-7">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                    <div class="card-body p-4 p-md-5">
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3 small fw-bold">
                            <i class="fas fa-tag me-1"></i> <?= htmlspecialchars($service['category_name']) ?>
                        </span>
                        <h3 class="fw-bold mb-3 text-dark"><?= htmlspecialchars($service['service_name']) ?></h3>
                        
                        <div class="d-flex align-items-center mb-4 p-3 bg-light rounded-4">
                            <div class="avatar-sm bg-white shadow-sm rounded-circle me-3 d-flex align-items-center justify-content-center text-primary fw-bold" style="width: 48px; height: 48px; font-size: 20px;">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div>
                                <p class="text-muted x-small mb-0 text-uppercase fw-bold ls-1">Verified Provider</p>
                                <h6 class="fw-bold mb-0 text-dark"><?= htmlspecialchars($service['provider_name']) ?></h6>
                            </div>
                        </div>

                        <h6 class="fw-bold mb-2 small text-uppercase ls-1 text-muted">Service Overview</h6>
                        <p class="text-muted small mb-4">
                            <?= nl2br(htmlspecialchars($service['description'] ?: 'Complete professional service with quality equipment and verified craftsmanship.')) ?>
                        </p>

                        <div class="border-top pt-3">
                            <h6 class="fw-bold mb-3 small text-uppercase ls-1 text-muted">Service Guarantees</h6>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2 text-secondary small"><i class="fas fa-check-circle text-success me-2"></i> Quality workmanship guaranteed</li>
                                <li class="mb-2 text-secondary small"><i class="fas fa-check-circle text-success me-2"></i> Verified background-checked professional</li>
                                <li class="mb-2 text-secondary small"><i class="fas fa-check-circle text-success me-2"></i> Transparent pricing with no hidden charges</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card border-0 shadow-sm" style="border-radius: 20px; border-top: 5px solid #2563eb !important;">
                    <div class="card-body p-4 p-md-5">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0">Standard Price</h5>
                            <h3 class="fw-bold text-primary mb-0">₹<?= htmlspecialchars($service['price']) ?></h3>
                        </div>

                        <form method="POST">
                            <div class="mb-4">
                                <label class="form-label fw-bold small text-uppercase ls-1">Appointment Date <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-calendar-alt text-muted"></i></span>
                                    <input type="date" 
                                           name="booking_date" 
                                           class="form-control form-control-lg border-start-0 ps-0 shadow-none" 
                                           min="<?= date('Y-m-d'); ?>" 
                                           required>
                                </div>
                                <div class="form-text small mt-2">Appointments are subject to provider confirmation.</div>
                            </div>

                            <button class="btn btn-dark btn-lg w-100 fw-bold shadow-sm mb-3 btn-pill">
                                <i class="fas fa-paper-plane me-2"></i>Confirm & Book
                            </button>
                            
                            <p class="text-center text-muted x-small mb-0">
                                By booking, you agree to our Terms of Service. Payment is handled upon service delivery.
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>