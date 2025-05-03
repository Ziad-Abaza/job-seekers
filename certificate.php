<?php
session_start();
require_once 'database/config.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
  die("Invalid certificate ID.");
}

$result_id = intval($_GET['id']);

$sql = "SELECT uer.*, e.title AS exam_title, u.name AS user_name
        FROM user_exam_results uer
        JOIN exams e ON uer.exam_id = e.id
        JOIN users u ON uer.user_id = u.id
        WHERE uer.id = ?";

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
  die("فشل في تجهيز الاستعلام: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $result_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
if (!$result) {
  die("فشل في تنفيذ الاستعلام: " . mysqli_error($conn));
}

$cert = mysqli_fetch_assoc($result);

if (!$cert) {
  die("Certificate not found.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Certificate - <?= htmlspecialchars($cert['exam_title']) ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600&family=Open+Sans&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Open Sans', sans-serif;
      background: linear-gradient(to right bottom, #eef2f3, #cfd9df);
      padding: 60px 20px;
      margin: 0;
    }

    .certificate-container {
      max-width: 900px;
      margin: auto;
      background: white url('img/certificate-bg.png') no-repeat center center fixed;
      background-size: cover;
      border: 8px solid #a5d6a7;
      border-radius: 20px;
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
      position: relative;
      padding: 80px 60px;
    }

    /* Decorative corner elements */
    .corner-decoration {
      position: absolute;
      width: 80px;
      height: 80px;
    }

    .top-left {
      top: 0;
      left: 0;
      background: url('img/decor-top-left.svg') no-repeat;
      background-size: contain;
    }

    .top-right {
      top: 0;
      right: 0;
      background: url('img/decor-top-right.svg') no-repeat;
      background-size: contain;
    }

    .bottom-left {
      bottom: 0;
      left: 0;
      background: url('img/decor-bottom-left.svg') no-repeat;
      background-size: contain;
    }

    .bottom-right {
      bottom: 0;
      right: 0;
      background: url('img/decor-bottom-right.svg') no-repeat;
      background-size: contain;
    }

    .certificate-header {
      text-align: center;
      margin-bottom: 40px;
    }

    .certificate-header img {
      width: 120px;
      height: 120px;
      margin-bottom: 10px;
      border-radius: 50%;
      border: 3px solid #007bff;
    }

    .certificate-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 2.5rem;
      color: #007bff;
      font-weight: bold;
      margin: 0;
      letter-spacing: 2px;
    }

    .certificate-subtitle {
      font-size: 1.2rem;
      color: #555;
      margin-top: 10px;
      font-style: italic;
    }

    .certificate-body {
      text-align: center;
      margin-top: 60px;
    }

    .user-name {
      font-family: 'Cormorant Garamond', serif;
      font-size: 2.2rem;
      font-weight: bold;
      color: #333;
      margin: 20px 0;
    }

    .exam-title {
      font-size: 1.3rem;
      margin: 15px 0;
      color: #333;
    }

    .exam-date {
      font-style: italic;
      color: #666;
      margin-top: 20px;
    }

    .score {
      font-size: 1.2rem;
      margin-top: 30px;
    }

    .badge {
      display: inline-block;
      padding: 8px 15px;
      font-size: 1rem;
      font-weight: bold;
      color: white;
      background-color: <?= $cert['passed'] ? '#28a745' : '#dc3545' ?>;
      border-radius: 6px;
      margin-left: 5px;
    }

    .signature {
      margin-top: 80px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 1rem;
    }

    .signature-line {
      width: 280px;
      text-align: center;
      border-top: 2px solid #000;
      padding-top: 5px;
      font-weight: bold;
      color: #333;
    }

    @media print {
      body {
        background: white;
      }

      .certificate-container {
        box-shadow: none;
        border: 8px solid #a5d6a7;
        background-image: none;
      }
    }
  </style>
</head>

<body>

  <div class="certificate-container">
    <!-- Decorative corners -->
    <div class="corner-decoration top-left"></div>
    <div class="corner-decoration top-right"></div>
    <div class="corner-decoration bottom-left"></div>
    <div class="corner-decoration bottom-right"></div>

    <!-- Header -->
    <div class="certificate-header">
      <img src="img/logo.jpeg" alt="Logo">
      <h1 class="certificate-title">Boom Platform</h1>
      <p class="certificate-subtitle">Certificate of Completion</p>
    </div>

    <!-- Body -->
    <div class="certificate-body">
      <p>This is to certify that</p>
      <h2 class="user-name"><?= htmlspecialchars($cert['user_name']) ?></h2>
      <p class="exam-title">has successfully completed the technical examination in:</p>
      <h4>"<?= htmlspecialchars($cert['exam_title']) ?>"</h4>
      <p class="exam-date">on <?= date('F j, Y', strtotime($cert['taken_at'])) ?></p>

      <div class="score">
        Score: <strong><?= $cert['score'] ?>/100</strong> |
        Status: <span class="badge"><?= $cert['passed'] ? 'Passed' : 'Failed' ?></span>
      </div>
    </div>

    <!-- Footer -->
    <div class="signature">
      <div class="signature-line">
        Boom Admin<br>
        <small>Platform Manager</small>
      </div>
      <div class="signature-line">
        <?= htmlspecialchars($cert['user_name']) ?><br>
        <small>Candidate</small>
      </div>
    </div>
  </div>

</body>

</html>