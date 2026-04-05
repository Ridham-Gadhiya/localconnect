<?php
require '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = $_POST['phone'];

    $stmt = $conn->prepare(
        "INSERT INTO service_providers (name,email,password,phone)
         VALUES (?,?,?,?)"
    );
    $stmt->execute([$name,$email,$password,$phone]);

    header("Location: login.php");
}
?>

<?php include '../includes/header.php'; ?>

<div class="row justify-content-center align-items-center" style="min-height: 80vh;">
  <div class="col-md-6 col-lg-5">
    <div class="card form-card border-0">
      <div class="card-body p-5">
        <div class="text-center mb-4">
            <div class="icon-circle bg-primary-soft mx-auto mb-3">
                <i class="fas fa-briefcase text-primary"></i>
            </div>
            <h3 class="fw-bold mb-1">Partner Registration</h3>
            <p class="text-muted">Fill in your business details to join our network</p>
        </div>

        <form method="POST">
          <div class="mb-3">
            <label class="form-label fw-semibold small">Business / Provider Name</label>
            <input name="name" class="form-control form-control-lg shadow-sm" placeholder="e.g. Apex Plumbing Services" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold small">Work Email Address</label>
            <input type="email" name="email" class="form-control form-control-lg shadow-sm" placeholder="contact@business.com" required>
          </div>

          <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold small">Password</label>
                <input type="password" name="password" class="form-control form-control-lg shadow-sm" placeholder="••••••••" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold small">Phone</label>
                <input name="phone" class="form-control form-control-lg shadow-sm" placeholder="+1 (555) 000-0000">
              </div>
          </div>

          <button class="btn btn-warning btn-lg w-100 fw-bold mt-3 shadow text-dark border-0">Submit for Approval</button>
        </form>

        <div class="alert alert-light border-0 mt-4 d-flex align-items-center shadow-sm">
          <i class="fas fa-info-circle text-info me-3 h4 mb-0"></i>
          <span class="small text-secondary">
            <strong>Note:</strong> To maintain quality, your account will be manually reviewed by our admin team before activation.
          </span>
        </div>

        <div class="text-center mt-4">
          <p class="small text-muted">Already a partner? <a href="login.php" class="text-primary fw-bold text-decoration-none">Login here</a></p>
        </div>

      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>