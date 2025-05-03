<?php
session_start();

require_once 'database/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: index.php");
  exit;
}

$exam_id = intval($_POST['exam_id']);
$answers = $_POST['answers'] ?? [];

if (empty($answers)) {
  die(" no answers provided.");
}

$score = 0;

foreach ($answers as $question_id => $user_answer) {
  $query = "SELECT correct_answer FROM questions WHERE id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "i", $question_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($result);

  if ($row && $user_answer === $row['correct_answer']) {
    $score++;
  }
}

$total_questions = count($answers);
$percentage = round(($score / $total_questions) * 100);

$user_id = $_SESSION['user_id'] ?? 0;
if (!$user_id) {
  die("most be logged in to submit exam results.");
}

$insert_sql = "INSERT INTO user_exam_results (user_id, exam_id, score, passed, taken_at)
               VALUES (?, ?, ?, ?, NOW())";
$stmt = mysqli_prepare($conn, $insert_sql);
$passed = $percentage >= 70 ? 1 : 0;
mysqli_stmt_bind_param($stmt, "iiii", $user_id, $exam_id, $percentage, $passed);
mysqli_stmt_execute($stmt);

header("Location: profile.php");
exit;
