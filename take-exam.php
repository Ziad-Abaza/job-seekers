<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

require_once 'database/config.php';
$exam = null;
$questions = [];
$exams_list = [];

// Check if an exam ID is provided in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
  $exam_id = intval($_GET['id']);

  // Get exam details
  $exam_query = "SELECT * FROM exams WHERE id = ?";
  $stmt = mysqli_prepare($conn, $exam_query);
  mysqli_stmt_bind_param($stmt, "i", $exam_id);
  mysqli_stmt_execute($stmt);
  $exam_result = mysqli_stmt_get_result($stmt);
  $exam = mysqli_fetch_assoc($exam_result);

  if (!$exam) {
    $error_message = "Exam not found.";
  } else {
    // Get all questions for this exam
    $question_query = "SELECT * FROM questions WHERE exam_id = ?";
    $stmt = mysqli_prepare($conn, $question_query);
    mysqli_stmt_bind_param($stmt, "i", $exam_id);
    mysqli_stmt_execute($stmt);
    $questions = mysqli_fetch_all($stmt->get_result(), MYSQLI_ASSOC);

    if (empty($questions)) {
      $error_message = "No questions available for this exam.";
    }
  }
} else {
  // No exam ID → fetch all exams
  $exam_query = "SELECT * FROM exams ORDER BY title";
  $result = mysqli_query($conn, $exam_query);
  $exams_list = mysqli_fetch_all($result, MYSQLI_ASSOC);

  if (empty($exams_list)) {
    $error_message = "No exams are available at the moment.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?= isset($exam) ? htmlspecialchars($exam['title']) : 'Select an Exam' ?></title>
  <?php require_once 'components/head.php'; ?>
</head>

<body>
  <div class="bg-white p-0">
    <!-- Navbar -->
    <?php require_once 'components/navbar.php'; ?>

    <div class="container py-5">
      <?php if (isset($error_message)): ?>
        <div class="alert alert-danger alert-custom text-center" role="alert">
          <?= htmlspecialchars($error_message) ?>
        </div>
      <?php elseif (isset($exam) && empty($questions)): ?>
        <div class="alert alert-warning alert-custom text-center" role="alert">
          This exam has no questions yet.
        </div>
      <?php elseif (isset($exam)): ?>
        <!-- Exam Title and Description -->
        <div class="text-center mb-4">
          <h2 class="text-primary"><?= htmlspecialchars($exam['title']) ?></h2>
          <p><?= htmlspecialchars($exam['description']) ?></p>
        </div>

        <!-- Timer -->
        <div class="timer" id="timer">Time Remaining: 00:00</div>

        <!-- Progress Bar -->
        <div class="progress-container mb-4">
          <div class="progress-bar" id="progressBar"></div>
        </div>

        <!-- Exam Form -->
        <form id="examForm" action="submit-exam.php" method="post">
          <input type="hidden" name="exam_id" value="<?= $exam['id'] ?>">

          <?php foreach ($questions as $index => $q): ?>
            <div class="card card-question shadow-sm mb-4">
              <div class="card-body">
                <h5 class="card-title">Question <?= $index + 1 ?> of <?= count($questions) ?></h5>
                <p class="card-text"><?= htmlspecialchars($q['question_text']) ?></p>

                <!-- Option 1 -->
                <label class="answer-option d-flex align-items-center mb-2">
                  <input type="radio" name="answers[<?= $q['id'] ?>]" value="<?= htmlspecialchars($q['option_1']) ?>" required>
                  <span class="check-icon"><i class="bi bi-check-circle-fill"></i></span>
                  <span class="form-check-label flex-grow-1"><?= htmlspecialchars($q['option_1']) ?></span>
                </label>

                <!-- Option 2 -->
                <label class="answer-option d-flex align-items-center mb-2">
                  <input type="radio" name="answers[<?= $q['id'] ?>]" value="<?= htmlspecialchars($q['option_2']) ?>">
                  <span class="check-icon"><i class="bi bi-check-circle-fill"></i></span>
                  <span class="form-check-label flex-grow-1"><?= htmlspecialchars($q['option_2']) ?></span>
                </label>

                <!-- Option 3 -->
                <label class="answer-option d-flex align-items-center mb-2">
                  <input type="radio" name="answers[<?= $q['id'] ?>]" value="<?= htmlspecialchars($q['option_3']) ?>">
                  <span class="check-icon"><i class="bi bi-check-circle-fill"></i></span>
                  <span class="form-check-label flex-grow-1"><?= htmlspecialchars($q['option_3']) ?></span>
                </label>
              </div>
            </div>
          <?php endforeach; ?>

          <!-- Submit Button -->
          <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary btn-submit btn-lg">
              <i class="bi bi-send"></i> Submit Answers
            </button>
          </div>
        </form>
      <?php elseif (!empty($exams_list)): ?>
        <!-- List of Available Exams -->
        <div class="text-center mb-5">
          <h2 class="text-primary">Select an Exam</h2>
          <p class="lead">Please choose an exam from the list below to start.</p>
        </div>
        <div class="row g-4">
          <?php foreach ($exams_list as $exam): ?>
            <div class="col-md-6 col-lg-4">
              <div class="card h-100 shadow-sm hover-lift">
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title"><?= htmlspecialchars($exam['title']) ?></h5>
                  <p class="card-text text-muted flex-grow-1"><?= htmlspecialchars($exam['description']) ?></p>
                  <a href="take-exam.php?id=<?= $exam['id'] ?>" class="btn btn-outline-primary mt-auto">
                    Start Exam
                  </a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- Footer -->
    <?php require_once 'components/footer.php'; ?>
  </div>

  <!-- Scripts -->
  <?php require_once 'components/scripts.php'; ?>

  <!-- JavaScript for Timer and Progress -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const answerOptions = document.querySelectorAll('.answer-option');
      const totalQuestions = <?= count($questions) ?>;
      let answeredCount = 0;

      // --- Timer ---
      const timePerQuestion = 60; // 60 seconds per question
      let timeLeft = totalQuestions * timePerQuestion;
      const timerElement = document.getElementById('timer');

      function updateTimer() {
        let minutes = Math.floor(timeLeft / 60).toString().padStart(2, '0');
        let seconds = (timeLeft % 60).toString().padStart(2, '0');
        timerElement.textContent = `Time Remaining: ${minutes}:${seconds}`;
        if (timeLeft > 0) {
          timeLeft--;
          setTimeout(updateTimer, 1000);
        } else {
          document.getElementById('examForm').submit(); // Auto-submit when time ends
        }
      }

      if (totalQuestions > 0) {
        updateTimer();
      }

      // --- Progress Bar ---
      const progressBar = document.getElementById('progressBar');
      answerOptions.forEach(option => {
        option.addEventListener('change', function() {
          const questionCard = this.closest('.card-question');
          const allRadios = questionCard.querySelectorAll('input[type="radio"]');
          let anySelected = Array.from(allRadios).some(radio => radio.checked);

          if (anySelected) {
            answeredCount++;
            const progress = (answeredCount / totalQuestions) * 100;
            progressBar.style.width = `${progress}%`;
          }
        });
      });

      // --- Select Answer by Clicking Label ---
      document.querySelectorAll('.answer-option').forEach(label => {
        label.addEventListener('click', () => {
          const radio = label.querySelector('input[type="radio"]');
          if (radio && !radio.checked) {
            radio.checked = true;
            label.classList.add('selected');
            label.querySelector('.check-icon')?.classList.remove('d-none');

            // Remove selection from other options in same question
            const others = label.closest('.card-body').querySelectorAll('.answer-option');
            others.forEach(other => {
              if (other !== label) {
                other.classList.remove('selected');
                other.querySelector('.check-icon')?.classList.add('d-none');
              }
            });
          }
        });
      });
    });
  </script>
</body>

</html>