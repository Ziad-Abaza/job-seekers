<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: admin-login.php");
  exit;
}

require_once 'database/config.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
  die("Exam ID is required.");
}

$exam_id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM exams WHERE id = ?");
$stmt->bind_param("i", $exam_id);
$stmt->execute();
$exam = $stmt->get_result()->fetch_assoc();

if (!$exam) {
  die("Exam is not found");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $category = mysqli_real_escape_string($conn, $_POST['category']);

  $stmt = $conn->prepare("UPDATE exams SET title=?, description=?, category=? WHERE id=?");
  $stmt->bind_param("sssi", $title, $description, $category, $exam_id);
  $stmt->execute();

  header("Location: dashboard-exams.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Edit Exam - Boom Admin</title>

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
        <div class="card shadow-sm p-4 mb-5">
          <h4 class="mb-4 text-center">Edit Exam</h4>

          <form method="post">
            <div class="mb-3">
              <label for="title" class="form-label">Exam Title</label>
              <input type="text" name="title" id="title"
                value="<?= htmlspecialchars($exam['title']) ?>"
                class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea name="description" id="description" class="form-control" rows="4" required><?= htmlspecialchars($exam['description']) ?></textarea>
            </div>

            <div class="mb-3">
              <label for="category" class="form-label">Category</label>
              <select name="category" id="category" class="form-select" required>
                <option value="Web Development" <?= $exam['category'] === 'Web Development' ? 'selected' : '' ?>>Web Development</option>
                <option value="UI/UX Design" <?= $exam['category'] === 'UI/UX Design' ? 'selected' : '' ?>>UI/UX Design</option>
                <option value="App Development" <?= $exam['category'] === 'App Development' ? 'selected' : '' ?>>App Development</option>
                <option value="Software Development" <?= $exam['category'] === 'Software Development' ? 'selected' : '' ?>>Software Development</option>
                <option value="Database Administration" <?= $exam['category'] === 'Database Administration' ? 'selected' : '' ?>>Database Administration</option>
                <option value="Network Engineering" <?= $exam['category'] === 'Network Engineering' ? 'selected' : '' ?>>Network Engineering</option>
                <option value="Cloud Architecture" <?= $exam['category'] === 'Cloud Architecture' ? 'selected' : '' ?>>Cloud Architecture</option>
                <option value="IoT" <?= $exam['category'] === 'IoT' ? 'selected' : '' ?>>Internet of Things (IoT)</option>
                <option value="Embedded Systems" <?= $exam['category'] === 'Embedded Systems' ? 'selected' : '' ?>>Embedded Systems</option>
              </select>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Update Exam</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php require_once 'components/footer.php'; ?>
  <?php require_once 'components/scripts.php'; ?>
</body>

</html>