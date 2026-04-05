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

<h3>User Registration</h3>
<form method="POST">
    <input name="name" class="form-control mb-2" placeholder="Name" required>
    <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
    <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
    <input name="phone" class="form-control mb-2" placeholder="Phone">
    <button class="btn btn-success">Register</button>
</form>

<?php include '../includes/footer.php'; ?>
