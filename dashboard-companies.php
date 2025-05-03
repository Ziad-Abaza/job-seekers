<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: admin-login.php");
  exit;
}

require_once 'database/config.php';


if (isset($_GET['delete_company'])) {
  $companyId = intval($_GET['delete_company']);
  $stmt = $conn->prepare("DELETE FROM companies WHERE id = ?");
  $stmt->bind_param("i", $companyId);
  $stmt->execute();
  header("Location: companies.php");
  exit;
}


$stmt = $conn->prepare("SELECT * FROM companies");
$stmt->execute();
$result = $stmt->get_result();
$companies = [];
while ($row = $result->fetch_assoc()) {
  $companies[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Company Management - Boom Admin</title>

  <!-- Include Head -->
  <?php require_once 'components/head.php'; ?>
</head>

<body>

  <!-- Navbar -->
  <?php require_once 'components/admin-navbar.php'; ?>

  <!-- Main Content -->
  <div class="container py-5">
    <div class="text-center mb-4">
      <h2 class="section-title">Manage Companies</h2>
      <p class="text-muted">Review and manage all registered companies from here.</p>
    </div>

    <div class="card shadow-sm p-4">
      <div class="table-responsive">
        <table class="table table-hover align-middle text-center">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Company Name</th>
              <th>Description</th>
              <th>Category</th>
              <th>Email</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($companies)): ?>
              <?php foreach ($companies as $company): ?>
                <tr>
                  <td><?= htmlspecialchars($company['id']) ?></td>
                  <td class="text-start"><?= htmlspecialchars($company['name']) ?></td>
                  <td class="text-start"><?= htmlspecialchars(substr($company['description'], 0, 50)) ?><?= strlen($company['description']) > 50 ? "..." : "" ?></td>
                  <td><span class="badge bg-primary"><?= htmlspecialchars($company['category'] ?? 'N/A') ?></span></td>
                  <td><?= htmlspecialchars($company['email']) ?></td>
                  <td>
                    <a href="?delete_company=<?= $company['id'] ?>"
                      class="btn btn-danger btn-sm"
                      onclick="return confirm('Are you sure you want to delete this company?');">
                      Delete
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-muted">No companies found at the moment.</td>
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