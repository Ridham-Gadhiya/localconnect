<?php
require '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = $_POST['phone'];

    $stmt = $conn->prepare(
        "INSERT INTO users (name,email,password,phone) VALUES (?,?,?,?)"
    );
    $stmt->execute([$name,$email,$password,$phone]);

    header("Location: login.php");
}
?>

<?php include '../includes/header.php'; ?>

<div class="row justify-content-center align-items-center" style="min-height: 75vh;">
  <div class="col-md-6">
    <div class="card form-card border-0">
      <div class="card-body p-5">
        <div class="text-center mb-4">
            <h3 class="fw-bold mb-1">Create User Account</h3>
            <p class="text-muted">Join LocalConnect to find trusted service providers</p>
        </div>

        <form method="POST">
          <div class="row">
              <div class="col-md-12 mb-3">
                <label class="form-label fw-semibold small">Full Name</label>
                <input name="name" class="form-control form-control-lg shadow-sm" placeholder="John Doe" required>
              </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold small">Email Address</label>
            <input type="email" name="email" class="form-control form-control-lg shadow-sm" placeholder="john@example.com" required>
          </div>

          <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold small">Password</label>
                <input type="password" name="password" class="form-control form-control-lg shadow-sm" placeholder="••••••••" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold small">Phone Number</label>
                <input name="phone" class="form-control form-control-lg shadow-sm" placeholder="+1 (555) 000-0000">
              </div>
          </div>

          <button class="btn btn-success btn-lg w-100 fw-bold mt-3 shadow border-0">Create Account</button>
        </form>

        <div class="text-center mt-4">
          <p class="small text-muted">Already have an account? <a href="login.php" class="text-primary fw-bold text-decoration-none">Log in here</a></p>
        </div>

      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>