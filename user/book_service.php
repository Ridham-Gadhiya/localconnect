<?php
include '../includes/header.php';
include '../includes/auth_check.php';
require '../config/db.php';

$service_id = $_GET['id'];

// Fetch service details
$stmt = $conn->prepare("
    SELECT services.service_name, services.price,
           categories.category_name,
           service_providers.name AS provider_name
    FROM services
    JOIN categories ON services.category_id = categories.id
    JOIN service_providers ON services.provider_id = service_providers.id
    WHERE services.id = ?
");
$stmt->execute([$service_id]);
$service = $stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_date = $_POST['booking_date'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare(
        "INSERT INTO bookings (user_id, service_id, booking_date)
         VALUES (?, ?, ?)"
    );
    $stmt->execute([$user_id, $service_id, $booking_date]);

    // Enhanced UX confirmation
    echo "
    <div class='container mt-5 py-5 text-center'>
        <div class='card border-0 shadow-sm p-5 mx-auto animate-fade-in' style='max-width: 500px; border-radius: 24px;'>
            <div class='icon-circle bg-success-soft mx-auto mb-4' style='width: 80px; height: 80px; font-size: 40px;'>
                <i class='fas fa-check-circle text-success'></i>
            </div>
            <h2 class='fw-bold mb-2'>Booking Confirmed!</h2>
            <p class='text-muted mb-4 px-4'>Your request for <strong>" . htmlspecialchars($service['service_name']) . "</strong> has been sent to the provider successfully.</p>
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
?>

<div class="row justify-content-center py-4">
    <div class="col-lg-10">
        <div class="d-flex align-items-center mb-4">
            <a href="search_services.php" class="btn btn-light rounded-circle me-3 shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="fw-bold mb-0">Confirm Your Booking</h2>
                <p class="text-muted mb-0 small">Review the details before finalizing your request</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-7">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                    <div class="card-body p-4">
                        <span class="badge bg-primary-soft text-primary px-3 py-2 rounded-pill mb-3">
                            <i class="fas fa-tag me-1"></i> <?= htmlspecialchars($service['category_name']) ?>
                        </span>
                        <h3 class="fw-bold mb-3"><?= htmlspecialchars($service['service_name']) ?></h3>
                        
                        <div class="d-flex align-items-center mb-4 p-3 bg-light rounded-4">
                            <div class="icon-circle bg-white shadow-sm mb-0 me-3" style="width: 50px; height: 50px; font-size: 20px;">
                                <i class="fas fa-user-tie text-dark"></i>
                            </div>
                            <div>
                                <p class="text-muted small mb-0">Service Provider</p>
                                <h6 class="fw-bold mb-0"><?= htmlspecialchars($service['provider_name']) ?></h6>
                            </div>
                        </div>

                        <h6 class="fw-bold mb-3">Service Includes:</h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2 text-muted small"><i class="fas fa-check text-success me-2"></i> Quality workmanship guaranteed</li>
                            <li class="mb-2 text-muted small"><i class="fas fa-check text-success me-2"></i> Verified professional service</li>
                            <li class="mb-2 text-muted small"><i class="fas fa-check text-success me-2"></i> Standard tools and equipment</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card border-0 shadow-sm" style="border-radius: 20px; border-top: 5px solid #2563eb !important;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0">Final Price</h5>
                            <h3 class="fw-bold text-primary mb-0">₹<?= htmlspecialchars($service['price']) ?></h3>
                        </div>

                        <form method="POST">
                            <div class="mb-4">
                                <label class="form-label fw-bold small text-uppercase">Pick a Date</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-calendar-alt text-muted"></i></span>
                                    <input type="date" 
                                           name="booking_date" 
                                           class="form-control form-control-lg border-start-0 ps-0" 
                                           min="<?= date('Y-m-d'); ?>" 
                                           required>
                                </div>
                                <div class="form-text small mt-2">Bookings are subject to provider's schedule.</div>
                            </div>

                            <button class="btn btn-dark btn-lg w-100 fw-bold shadow-sm mb-3">
                                <i class="fas fa-paper-plane me-2"></i>Confirm & Book
                            </button>
                            
                            <p class="text-center text-muted x-small mb-0" style="font-size: 11px;">
                                By clicking confirm, you agree to our Terms of Service and Privacy Policy.
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>  