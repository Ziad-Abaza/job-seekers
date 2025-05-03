<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: admin-login.php");
  exit;
}
require_once 'database/config.php';

$exam = null;
$questions = [];

// Fetch exam if `exam_id` is provided
if (isset($_GET['exam_id']) && !empty($_GET['exam_id'])) {
  $exam_id = intval($_GET['exam_id']);

  // Get exam details
  $stmt = $conn->prepare("SELECT * FROM exams WHERE id = ?");
  $stmt->bind_param("i", $exam_id);
  $stmt->execute();
  $exam = $stmt->get_result()->fetch_assoc();

  if ($exam) {
    // Add new question
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_question'])) {
      $question_text = $_POST['question_text'];
      $correct_answer = $_POST['correct_answer'];
      $option_1 = $_POST['option_1'];
      $option_2 = $_POST['option_2'];
      $option_3 = $_POST['option_3'];

      $stmt = $conn->prepare("INSERT INTO questions (exam_id, question_text, correct_answer, option_1, option_2, option_3)
                                    VALUES (?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("isssss", $exam_id, $question_text, $correct_answer, $option_1, $option_2, $option_3);
      $stmt->execute();
      header("Location: dashboard-questions.php?exam_id=$exam_id");
      exit;
    }

    // Edit existing question
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_question'])) {
      $question_id = intval($_POST['question_id']);
      $question_text = $_POST['question_text'];
      $correct_answer = $_POST['correct_answer'];
      $option_1 = $_POST['option_1'];
      $option_2 = $_POST['option_2'];
      $option_3 = $_POST['option_3'];

      $stmt = $conn->prepare("UPDATE questions SET 
                    question_text=?, correct_answer=?, option_1=?, option_2=?, option_3=? WHERE id=?");
      $stmt->bind_param("sssssi", $question_text, $correct_answer, $option_1, $option_2, $option_3, $question_id);
      $stmt->execute();
      header("Location: dashboard-questions.php?exam_id=$exam_id");
      exit;
    }

    // Delete question
    if (isset($_GET['delete_question'])) {
      $question_id = intval($_GET['delete_question']);
      $stmt = $conn->prepare("DELETE FROM questions WHERE id = ?");
      $stmt->bind_param("i", $question_id);
      $stmt->execute();
      header("Location: dashboard-questions.php?exam_id=$exam_id");
      exit;
    }

    // Get all questions for this exam
    $stmt = $conn->prepare("SELECT * FROM questions WHERE exam_id = ?");
    $stmt->bind_param("i", $exam_id);
    $stmt->execute();
    $questions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  } else {
    die("Exam not found.");
  }
} else {
  // No exam selected → get all exams
  $stmt = $conn->prepare("SELECT * FROM exams ORDER BY title ASC");
  $stmt->execute();
  $allExams = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title><?= isset($exam) ? 'Manage Questions - ' . htmlspecialchars($exam['title']) : 'Select an Exam' ?></title>
  <?php require_once 'components/head.php'; ?>
</head>

<body>
  <?php require_once 'components/admin-navbar.php'; ?>

  <div class="container py-5">
    <!-- Case: No exam selected -->
    <?php if (!isset($exam)): ?>
      <div class="text-center mb-4">
        <h2 class="mb-3">Select an Exam to Manage Questions</h2>
        <p class="text-muted">Click on one of the exams below to view or add questions.</p>
      </div>

      <div class="row g-4">
        <?php foreach ($allExams as $e): ?>
          <div class="col-md-6 col-lg-4">
            <a href="dashboard-questions.php?exam_id=<?= $e['id'] ?>" class="text-decoration-none">
              <div class="card shadow-sm h-100 exam-card p-4 text-center">
                <h5 class="mb-0"><?= htmlspecialchars($e['title']) ?></h5>
                <small class="text-muted mt-2 d-block"><?= htmlspecialchars($e['description']) ?></small>
                <span class="badge bg-primary mt-2"><?= htmlspecialchars($e['category']) ?></span>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>

    <?php else: ?>
      <!-- Case: Exam selected -->
      <div class="text-center mb-4">
        <h3><?= htmlspecialchars($exam['title']) ?></h3>
        <p class="text-muted"><?= htmlspecialchars($exam['description']) ?></p>
      </div>

      <!-- Add New Question Form -->
      <div class="card shadow-sm mb-4">
        <div class=" bg-primary text-white">
          Add New Question
        </div>
        <div class="card-body">
          <form method="post">
            <input type="hidden" name="add_question" value="1">
            <div class="mb-3">
              <label class="form-label">Question Text</label>
              <input type="text" name="question_text" class="form-control" required>
            </div>
            <div class="row g-3 mb-3">
              <div class="col-md-4">
                <label class="form-label">Option 1</label>
                <input type="text" name="option_1" class="form-control" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Option 2</label>
                <input type="text" name="option_2" class="form-control" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Option 3</label>
                <input type="text" name="option_3" class="form-control" required>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Correct Answer</label>
              <input type="text" name="correct_answer" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Add Question</button>
          </form>
        </div>
      </div>

      <!-- List of Questions -->
      <h4 class="mb-3">Questions</h4>
      <?php if (!empty($questions)): ?>
        <div class="row g-4">
          <?php foreach ($questions as $q): ?>
            <div class="col-md-6 col-lg-4">
              <div class="card shadow-sm h-100 question-card">
                <div class="card-body">
                  <h5 class="card-title">Question</h5>
                  <p class="card-text"><?= htmlspecialchars($q['question_text']) ?></p>
                  <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      Option 1:
                      <strong><?= htmlspecialchars($q['option_1']) ?></strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      Option 2:
                      <strong><?= htmlspecialchars($q['option_2']) ?></strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      Option 3:
                      <strong><?= htmlspecialchars($q['option_3']) ?></strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center text-success fw-bold">
                      Correct Answer:
                      <strong><?= htmlspecialchars($q['correct_answer']) ?></strong>
                    </li>
                  </ul>
                  <div class="d-flex justify-content-between">
                    <a href="?exam_id=<?= $exam_id ?>&delete_question=<?= $q['id'] ?>"
                      class="btn btn-danger btn-sm"
                      onclick="return confirm('Are you sure you want to delete this question?');">
                      Delete
                    </a>
                    <button class="btn btn-warning btn-sm"
                      data-bs-toggle="modal"
                      data-bs-target="#editQuestionModal<?= $q['id'] ?>">
                      Edit
                    </button>
                  </div>
                </div>
              </div>

              <!-- Edit Question Modal -->
              <div class="modal fade" id="editQuestionModal<?= $q['id'] ?>" tabindex="-1"
                aria-labelledby="editQuestionModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Edit Question</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post">
                      <div class="modal-body">
                        <input type="hidden" name="question_id" value="<?= $q['id'] ?>">
                        <div class="mb-3">
                          <label class="form-label">Question Text</label>
                          <input type="text" name="question_text"
                            value="<?= htmlspecialchars($q['question_text']) ?>"
                            class="form-control" required>
                        </div>
                        <div class="row g-3 mb-3">
                          <div class="col-md-12">
                            <label class="form-label">Option 1</label>
                            <input type="text" name="option_1"
                              value="<?= htmlspecialchars($q['option_1']) ?>"
                              class="form-control" required>
                          </div>
                          <div class="col-md-12 mt-2">
                            <label class="form-label">Option 2</label>
                            <input type="text" name="option_2"
                              value="<?= htmlspecialchars($q['option_2']) ?>"
                              class="form-control" required>
                          </div>
                          <div class="col-md-12 mt-2">
                            <label class="form-label">Option 3</label>
                            <input type="text" name="option_3"
                              value="<?= htmlspecialchars($q['option_3']) ?>"
                              class="form-control" required>
                          </div>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Correct Answer</label>
                          <input type="text" name="correct_answer"
                            value="<?= htmlspecialchars($q['correct_answer']) ?>"
                            class="form-control" required>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="edit_question" class="btn btn-primary">Save Changes</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="alert alert-info text-center" role="alert">
          No questions added yet.
        </div>
      <?php endif; ?>
    <?php endif; ?>
  </div>

  <!-- Footer -->
  <?php require_once 'components/footer.php'; ?>
  <?php require_once 'components/scripts.php'; ?>
</body>

</html>