<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: admin-login.php");
  exit;
}

require_once 'database/config.php';

if (isset($_GET['delete_job'])) {
  $jobId = intval($_GET['delete_job']);
  $stmt = $conn->prepare("DELETE FROM job_postings WHERE id = ?");
  $stmt->bind_param("i", $jobId);
  $stmt->execute();
  header("Location: dashboard-jobs.php");
  exit;
}

$sql = "SELECT job_postings.*, companies.name AS company_name 
        FROM job_postings 
        LEFT JOIN companies ON job_postings.company_id = companies.id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$jobs = [];
while ($row = $result->fetch_assoc()) {
  $jobs[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Job Management - Boom Admin</title>

  <!-- Include Head -->
  <?php require_once 'components/head.php'; ?>
</head>

<body>

  <!-- Navbar -->
  <?php require_once 'components/admin-navbar.php'; ?>

  <!-- Main Content -->
  <div class="container py-5">
    <div class="text-center mb-4">
      <h2 class="text-primary mt-2 fs-1">Manage Jobs</h2>
      <p class="text-muted">Review and manage all posted jobs from here.</p>
    </div>

    <div class="card shadow-sm p-4">
      <div class="table-responsive">
        <table class="table table-hover align-middle text-center">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Job Title</th>
              <th>Company</th>
              <th>Category</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($jobs)): ?>
              <?php foreach ($jobs as $job): ?>
                <tr>
                  <td><?= htmlspecialchars($job['id']) ?></td>
                  <td class="text-start"><?= htmlspecialchars($job['title']) ?></td>
                  <td><?= htmlspecialchars($job['company_name'] ?? 'N/A') ?></td>
                  <td><span class="badge bg-primary"><?= htmlspecialchars($job['category'] ?? 'N/A') ?></span></td>
                  <td>
                    <span class="badge bg-success">Active</span>
                  </td>
                  <td>
                    <a href="?delete_job=<?= $job['id'] ?>"
                      class="btn btn-danger btn-sm"
                      onclick="return confirm('Are you sure you want to delete this job?');">
                      Delete
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-muted">No jobs found at the moment.</td>
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