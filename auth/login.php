<?php
require '../config/db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = "";
$info = "";

if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'registered_user') {
        $info = "Account created successfully! Please sign in with your credentials.";
    } elseif ($_GET['msg'] === 'pending_approval') {
        $info = "Application submitted! Our admin team will verify your details. You can log in once approved.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // 1. Admin Authentication
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email=?");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['role'] = 'admin';
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['name'] = 'System Administrator';
        $_SESSION['email'] = $admin['email'];
        header("Location: ../admin/dashboard.php");
        exit;
    }

    // 2. Customer User Authentication
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['role'] = 'user';
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        header("Location: ../user/dashboard.php");
        exit;
    }

    // 3. Service Provider Authentication
    $stmt = $conn->prepare("SELECT * FROM service_providers WHERE email=?");
    $stmt->execute([$email]);
    $provider = $stmt->fetch();

    if ($provider && password_verify($password, $provider['password'])) {
        if ($provider['status'] === 'approved') {
            $_SESSION['role'] = 'provider';
            $_SESSION['provider_id'] = $provider['id'];
            $_SESSION['name'] = $provider['name'];
            $_SESSION['email'] = $provider['email'];
            header("Location: ../provider/dashboard.php");
            exit;
        } elseif ($provider['status'] === 'pending') {
            $error = "Your provider account is currently pending admin verification. Please check back soon.";
        } elseif ($provider['status'] === 'rejected') {
            $error = "Your provider account application was declined. Please contact support for details.";
        }
    } else {
        $error = "Invalid email address or password. Please try again.";
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
  <div class="col-md-5">
    <div class="card form-card border-0 shadow-sm rounded-4">
      <div class="card-body p-5">
        <div class="text-center mb-4">
            <div class="icon-circle bg-primary bg-opacity-10 text-primary mx-auto mb-3" style="width: 60px; height: 60px; font-size: 24px;">
                <i class="fas fa-lock"></i>
            </div>
            <h3 class="fw-bold mb-1">Welcome Back</h3>
            <p class="text-muted small">Enter your credentials to access your portal</p>
        </div>

        <?php if($info): ?>
          <div class="alert alert-success border-0 small rounded-3 mb-4 d-flex align-items-center">
            <i class="fas fa-check-circle me-2 fs-5"></i>
            <div><?= htmlspecialchars($info) ?></div>
          </div>
        <?php endif; ?>

        <?php if($error): ?>
          <div class="alert alert-danger border-0 small rounded-3 mb-4 d-flex align-items-center">
            <i class="fas fa-exclamation-triangle me-2 fs-5"></i>
            <div><?= htmlspecialchars($error) ?></div>
          </div>
        <?php endif; ?>

        <form method="POST">
          <div class="mb-3">
            <label class="form-label fw-semibold small">Email Address</label>
            <input type="email" name="email" class="form-control form-control-lg shadow-none" placeholder="name@example.com" required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
          </div>

          <div class="mb-4">
            <div class="d-flex justify-content-between">
                <label class="form-label fw-semibold small">Password</label>
            </div>
            <input type="password" name="password" class="form-control form-control-lg shadow-none" placeholder="••••••••" required>
          </div>

          <button class="btn btn-dark btn-lg w-100 fw-bold mb-3 shadow-sm btn-pill">Sign In</button>
        </form>

        <hr class="my-4 opacity-10">

        <div class="text-center">
            <p class="small text-muted mb-2">Don't have an account yet?</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="register_user.php" class="text-primary text-decoration-none fw-bold small">Join as Customer</a>
                <span class="text-muted">|</span>
                <a href="register_provider.php" class="text-warning text-dark text-decoration-none fw-bold small">Become a Provider</a>
            </div>
        </div>

      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>