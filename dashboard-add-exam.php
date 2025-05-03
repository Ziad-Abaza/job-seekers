<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: admin-login.php");
  exit;
}

require_once 'database/config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $category = mysqli_real_escape_string($conn, $_POST['category']);

  if (!empty($title) && !empty($description) && !empty($category)) {
    $stmt = $conn->prepare("INSERT INTO exams (title, description, category) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $description, $category);

    if ($stmt->execute()) {
      $success = "Exam added successfully!";
      header("refresh:1;url=dashboard-exams.php");
    } else {
      $error = "Failed to add exam.";
    }
  } else {
    $error = "Please fill in all fields.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Add New Exam - Boom Admin</title>

  <!-- Include Head Components -->
  <?php require_once 'components/head.php'; ?>
</head>

<body>

  <!-- Navbar -->
  <?php require_once 'components/admin-navbar.php'; ?>

  <!-- Main Content -->
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm p-4 mb-5">
          <h4 class="mb-4 text-center">Add New Exam</h4>

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
            <div class="mb-3">
              <label for="title" class="form-label">Exam Title</label>
              <input type="text" name="title" id="title" class="form-control" placeholder="Enter exam title" required>
            </div>

            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea name="description" id="description" rows="4" class="form-control" placeholder="Describe the exam content..." required><?= htmlspecialchars($description ?? '') ?></textarea>
            </div>

            <div class="mb-3">
              <label for="category" class="form-label">Category</label>
              <select name="category" id="category" class="form-select" required>
                <option value="">Select Category</option>
                <option value="Web Development">Web Development</option>
                <option value="UI/UX Design">UI/UX Design</option>
                <option value="App Development">App Development</option>
                <option value="Software Development">Software Development</option>
                <option value="Database Administration">Database Administration</option>
                <option value="Network Engineering">Network Engineering</option>
                <option value="Cloud Architecture">Cloud Architecture</option>
                <option value="IoT">Internet of Things (IoT)</option>
                <option value="Embedded Systems">Embedded Systems</option>
              </select>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Save Exam</button>
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