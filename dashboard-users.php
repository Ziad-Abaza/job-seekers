<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: admin-login.php");
  exit;
}

require_once 'database/config.php';

// Delete User
if (isset($_GET['delete_user'])) {
  $userId = intval($_GET['delete_user']);
  $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
  $stmt->bind_param("i", $userId);
  $stmt->execute();
  header("Location: dashboard-users.php");
  exit;
}

$users = $conn->query("SELECT * FROM users")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>User Management - BOOM</title>
  <?php require_once 'components/head.php'; ?>
</head>

<body>
  <?php require_once 'components/admin-navbar.php'; ?>

  <div class="container mt-5">
    <h4 class="text-primary my-5 text-center fs-1">User Management</h4>

    <div class="card-user p-4 shadow-sm">
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
            <?php if (!empty($users)): ?>
              <?php foreach ($users as $user): ?>
                <tr>
                  <td><?= htmlspecialchars($user['id']) ?></td>
                  <td><?= htmlspecialchars($user['name']) ?></td>
                  <td><?= htmlspecialchars($user['email']) ?></td>
                  <td>
                    <span class="badge bg-primary"><?= htmlspecialchars(ucfirst($user['role'])) ?></span>
                  </td>
                  <td>
                    <a href="?delete_user=<?= $user['id'] ?>"
                      class="btn btn-danger btn-sm"
                      onclick="return confirm('Are you sure you want to delete this user?');">
                      Delete
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-muted">No users found at the moment.</td>
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