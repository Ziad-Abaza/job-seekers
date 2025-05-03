<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: admin-login.php");
  exit;
}

require_once 'database/config.php';
$admin_id = $_SESSION['admin_id'];

$stmt = $conn->prepare("SELECT * FROM admins WHERE id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$admin = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $new_password = $_POST['password'];

  if (!empty($new_password)) {
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE admins SET name=?, email=?, password=? WHERE id=?");
    $stmt->bind_param("sssi", $name, $email, $hashed_password, $admin_id);
  } else {
    $stmt = $conn->prepare("UPDATE admins SET name=?, email=? WHERE id=?");
    $stmt->bind_param("ssi", $name, $email, $admin_id);
  }

  $stmt->execute();
  header("Location: dashboard-profile.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Edit Profile - Boom Admin</title>

  <!-- Include Head -->
  <?php require_once 'components/head.php'; ?>

</head>

<body>

  <!-- Navbar -->
  <?php require_once 'components/admin-navbar.php'; ?>

  <!-- Main Content -->
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="card profile-card p-4 shadow-sm">
          <h4 class="mb-4 text-center">Edit Your Account</h4>

          <form method="post">
            <div class="mb-3">
              <label for="name" class="form-label">Full Name</label>
              <input type="text" name="name" id="name"
                value="<?= htmlspecialchars($admin['name']) ?>"
                class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email Address</label>
              <input type="email" name="email" id="email"
                value="<?= htmlspecialchars($admin['email']) ?>"
                class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">New Password (Optional)</label>
              <input type="password" name="password" id="password" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Update Profile</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php require_once 'components/footer.php'; ?>

  <!-- Scripts -->
  <?php require_once 'components/scripts.php'; ?>
</body>

</html>