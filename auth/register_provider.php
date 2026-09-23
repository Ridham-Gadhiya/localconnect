<?php
require '../config/db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $phone = trim($_POST['phone']);

    if (empty($name) || empty($email) || empty($password)) {
        $error = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid work email address.";
    } else {
        // Check if email is already taken across users, providers, or admin
        $check = $conn->prepare("SELECT id FROM service_providers WHERE email = ? UNION SELECT id FROM users WHERE email = ? UNION SELECT id FROM admin WHERE email = ?");
        $check->execute([$email, $email, $email]);
        
        if ($check->fetch()) {
            $error = "This email address is already registered. Please sign in or use another email.";
        } else {
            try {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare(
                    "INSERT INTO service_providers (name, email, password, phone, status)
                     VALUES (?, ?, ?, ?, 'pending')"
                );
                $stmt->execute([$name, $email, $hash, $phone]);

                header("Location: login.php?msg=pending_approval");
                exit;
            } catch (PDOException $e) {
                $error = "An unexpected error occurred during partner registration. Please try again.";
            }
        }
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="row justify-content-center align-items-center" style="min-height: 80vh;">
  <div class="col-md-6 col-lg-5">
    <div class="card form-card border-0 shadow-sm rounded-4">
      <div class="card-body p-4 p-md-5">
        <div class="text-center mb-4">
            <div class="icon-circle bg-warning bg-opacity-10 text-dark mx-auto mb-3" style="width: 60px; height: 60px; font-size: 24px;">
                <i class="fas fa-briefcase text-warning"></i>
            </div>
            <h3 class="fw-bold mb-1">Partner Registration</h3>
            <p class="text-muted small">Fill in your business details to join our professional network</p>
        </div>

        <?php if(!empty($error)): ?>
          <div class="alert alert-danger border-0 small rounded-3 mb-4 d-flex align-items-center">
            <i class="fas fa-exclamation-circle me-2 fs-5"></i>
            <div><?= htmlspecialchars($error) ?></div>
          </div>
        <?php endif; ?>

        <form method="POST">
          <div class="mb-3">
            <label class="form-label fw-semibold small">Business / Provider Name <span class="text-danger">*</span></label>
            <input name="name" class="form-control form-control-lg shadow-none" placeholder="e.g. Apex Plumbing Services" required value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold small">Work Email Address <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control form-control-lg shadow-none" placeholder="contact@business.com" required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
          </div>

          <div class="row g-2">
              <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold small">Password <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control form-control-lg shadow-none" placeholder="••••••••" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold small">Phone Number</label>
                <input name="phone" class="form-control form-control-lg shadow-none" placeholder="+91 98765 43210" value="<?= isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '' ?>">
              </div>
          </div>

          <button class="btn btn-warning btn-lg w-100 fw-bold mt-2 shadow-sm text-dark border-0 btn-pill">Submit for Approval</button>
        </form>

        <div class="alert alert-light border-0 mt-4 d-flex align-items-center shadow-sm rounded-3">
          <i class="fas fa-info-circle text-info me-3 fs-5 mb-0"></i>
          <span class="small text-secondary">
            <strong>Verification Note:</strong> To maintain community quality, new provider accounts are verified by an administrator before activation.
          </span>
        </div>

        <div class="text-center mt-4">
          <p class="small text-muted mb-0">Already a registered partner? <a href="login.php" class="text-primary fw-bold text-decoration-none">Log in here</a></p>
        </div>

      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>