<?php
require '../config/db.php';
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Admin
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email=?");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['role'] = 'admin';
        $_SESSION['admin_id'] = $admin['id'];
        header("Location: ../admin/dashboard.php");
        exit;
    }

    // User
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['role'] = 'user';
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        header("Location: ../user/dashboard.php");
        exit;
    }

    // Provider
    $stmt = $conn->prepare("SELECT * FROM service_providers WHERE email=? AND status='approved'");
    $stmt->execute([$email]);
    $provider = $stmt->fetch();

    if ($provider && password_verify($password, $provider['password'])) {
        $_SESSION['role'] = 'provider';
        $_SESSION['provider_id'] = $provider['id'];
        header("Location: ../provider/dashboard.php");
        exit;
    }

    $error = "Invalid credentials or approval pending.";
}
?>

<?php include '../includes/header.php'; ?>

<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
  <div class="col-md-5">
    <div class="card form-card border-0">
      <div class="card-body p-5">
        <div class="text-center mb-4">
            <h3 class="fw-bold mb-1">Welcome Back</h3>
            <p class="text-muted">Enter your credentials to access your account</p>
        </div>

        <?php if($error): ?>
          <div class="alert alert-danger border-0 small"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
          <div class="mb-3">
            <label class="form-label fw-semibold small">Email Address</label>
            <input type="email" name="email" class="form-control form-control-lg shadow-sm" placeholder="name@example.com" required>
          </div>

          <div class="mb-4">
            <div class="d-flex justify-content-between">
                <label class="form-label fw-semibold small">Password</label>
            </div>
            <input type="password" name="password" class="form-control form-control-lg shadow-sm" placeholder="••••••••" required>
          </div>

          <button class="btn btn-dark btn-lg w-100 fw-bold mb-3 shadow">Sign In</button>
        </form>

        <hr class="my-4 opacity-10">

        <div class="text-center">
            <p class="small text-muted mb-2">Don't have an account yet?</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="register_user.php" class="text-primary text-decoration-none fw-semibold">Join as User</a>
                <span class="text-muted">|</span>
                <a href="register_provider.php" class="text-warning text-decoration-none fw-semibold">Become a Provider</a>
            </div>
        </div>

      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>