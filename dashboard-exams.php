<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: admin-login.php");
  exit;
}

require_once 'database/config.php';

if (isset($_GET['delete_exam'])) {
  $examId = intval($_GET['delete_exam']);
  $stmt = $conn->prepare("DELETE FROM exams WHERE id = ?");
  $stmt->bind_param("i", $examId);
  $stmt->execute();
  header("Location: dashboard-exams.php");
  exit;
}

$exams = $conn->query("SELECT * FROM exams")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Exam Management - Boom Admin</title>

  <!-- Include Head -->
  <?php require_once 'components/head.php'; ?>
</head>

<body>

  <!-- Navbar -->
  <?php require_once 'components/admin-navbar.php'; ?>

  <!-- Main Content -->
  <div class="container py-5">
    <div class="text-center mb-4">
      <h2 class="fs-1 text-primary">Manage Exams</h2>
      <p class="text-muted">Review and manage all exams from here.</p>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
      <a href="dashboard-add-exam.php" class="btn btn-primary">+ Add New Exam</a>
    </div>

    <div class="card shadow-sm p-4">
      <div class="table-responsive">
        <table class="table table-hover align-middle text-center">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Title</th>
              <th>Category</th>
              <th>Description</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($exams)): ?>
              <?php foreach ($exams as $exam): ?>
                <tr>
                  <td><?= htmlspecialchars($exam['id']) ?></td>
                  <td class="text-start"><?= htmlspecialchars($exam['title']) ?></td>
                  <td><span class="badge bg-primary"><?= htmlspecialchars($exam['category']) ?></span></td>
                  <td><?= htmlspecialchars(substr($exam['description'], 0, 50)) ?><?= strlen($exam['description']) > 50 ? "..." : "" ?></td>
                  <td>
                    <a href="dashboard-edit-exam.php?id=<?= $exam['id'] ?>" class="btn btn-warning btn-sm me-1">Edit</a>
                    <a href="?delete_exam=<?= $exam['id'] ?>"
                      class="btn btn-danger btn-sm"
                      onclick="return confirm('Are you sure you want to delete this exam?');">
                      Delete
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-muted">No exams found at the moment.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php require_once 'components/footer.php'; ?>

  <!-- Scripts -->
  <?php require_once 'components/scripts.php'; ?>
</body>

</html>