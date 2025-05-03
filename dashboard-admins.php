<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: admin-login.php");
  exit;
}

require_once 'database/config.php';

$error = '';
$success = '';


$stmt = $conn->prepare("SELECT * FROM admins WHERE id = ?");
$stmt->bind_param("i", $_SESSION['admin_id']);
$stmt->execute();
$currentUser = $stmt->get_result()->fetch_assoc();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_admin'])) {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = $_POST['password'];
  $role = isset($_POST['role']) ? $_POST['role'] : 'admin'; 

  if (!empty($name) && !empty($email) && !empty($password)) {
    if ($currentUser['role'] !== 'superAdmin' && $role === 'superAdmin') {
      $error = "You don't have permission to assign superAdmin role.";
    } else {
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      $stmt = $conn->prepare("INSERT INTO admins (name, email, password, role) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("ssss", $name, $email, $hashedPassword, $role);
      if ($stmt->execute()) {
        $success = "Admin added successfully.";
        header("refresh:1;url=dashboard-admins.php");
        exit;
      } else {
        $error = "Failed to add admin.";
      }
    }
  } else {
    $error = "Please fill in all fields.";
  }
}


if (isset($_GET['delete_admin'])) {
  $adminId = intval($_GET['delete_admin']);


  $stmt = $conn->prepare("SELECT * FROM admins WHERE id = ?");
  $stmt->bind_param("i", $adminId);
  $stmt->execute();
  $targetUser = $stmt->get_result()->fetch_assoc();


  if (!$targetUser) {
    die("Admin not found.");
  }

  if ($currentUser['role'] === 'superAdmin') {

    $stmt = $conn->prepare("DELETE FROM admins WHERE id = ?");
    $stmt->bind_param("i", $adminId);
    $stmt->execute();
  } elseif ($currentUser['role'] === 'admin') {
    if ($targetUser['role'] === 'superAdmin') {
      $error = "You can't delete a Super Admin.";
    } else {
      $stmt = $conn->prepare("DELETE FROM admins WHERE id = ?");
      $stmt->bind_param("i", $adminId);
      $stmt->execute();
    }
  } else {
    $error = "You don't have permission to delete admins.";
  }

  header("Location: dashboard-admins.php");
  exit;
}


$admins = $conn->query("SELECT * FROM admins")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Admin Management - Boom</title>
  <?php require_once 'components/head.php'; ?>
</head>

<body>

  <!-- Navbar -->
  <?php require_once 'components/admin-navbar.php'; ?>

  <!-- Main Content -->
  <div class="container py-5">
    <div class="text-center mb-4">
      <h2 class="section-title">Manage Admins</h2>
      <p class="text-muted">Add new admin or manage existing ones.</p>
    </div>

    <div class="card shadow-sm p-4 mb-5">
      <h5 class="mb-4">Add New Admin</h5>

      <?php if ($error): ?>
        <div class="alert alert-danger text-center" role="alert">
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <?php if ($success): ?>
        <div class="alert alert-success text-center" role="alert">
          <?= htmlspecialchars($success) ?>
        </div>
      <?php endif; ?>

      <form method="post">
        <input type="hidden" name="add_admin" value="1">
        <div class="row g-3 mb-3">
          <div class="col-md-4">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter full name" required>
          </div>
          <div class="col-md-4">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" required>
          </div>
          <div class="col-md-4">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
          </div>

          <?php if ($currentUser['role'] === 'superAdmin'): ?>
            <div class="col-md-12 mt-3">
              <label for="role" class="form-label">Select Role</label>
              <select name="role" class="form-select" required>
                <option value="admin">Admin</option>
                <option value="editor">Editor</option>
                <option value="superAdmin">Super Admin</option>
              </select>
            </div>
          <?php else: ?>
            <input type="hidden" name="role" value="admin">
          <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary w-100 mt-3">Add Admin</button>
      </form>
    </div>


    <div class="card shadow-sm p-4">
      <h5 class="mb-4">Existing Admins</h5>

      <div class="table-responsive">
        <table class="table table-hover align-middle text-center">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($admins)): ?>
              <?php foreach ($admins as $admin): ?>
                <tr>
                  <td><?= htmlspecialchars($admin['id']) ?></td>
                  <td><?= htmlspecialchars($admin['name']) ?></td>
                  <td><?= htmlspecialchars($admin['email']) ?></td>
                  <td><span class="badge bg-secondary"><?= htmlspecialchars(ucfirst($admin['role'])) ?></span></td>
                  <td>
                    <?php if ($currentUser['role'] === 'superAdmin'): ?>

                      <a href="?delete_admin=<?= $admin['id'] ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Are you sure you want to delete this admin?');">
                        Delete
                      </a>
                    <?php elseif ($currentUser['role'] === 'admin' && $admin['role'] !== 'superAdmin'): ?>

                      <a href="?delete_admin=<?= $admin['id'] ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Are you sure you want to delete this admin?');">
                        Delete
                      </a>
                    <?php else: ?>

                      <button class="btn btn-danger btn-sm disabled">Delete</button>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-muted">No admins found at the moment.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php require_once 'components/footer.php'; ?>
  <?php require_once 'components/scripts.php'; ?>
</body>

</html>