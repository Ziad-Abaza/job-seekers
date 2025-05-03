<?php
session_start();
require_once 'database/config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();
    if (password_verify($password, $admin['password'])) {
      $_SESSION['admin_id'] = $admin['id'];
      // $_SESSION['role'] = $admin['role']; 
      header("Location: dashboard.php");
      exit;
    }
  }

  $error = "البريد الإلكتروني أو كلمة المرور غير صحيحة.";
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <title>login Admin - BOOM</title>
  <?php require_once 'components/head.php'; ?>
  <style>
    body {
      font-family: 'Tajawal', sans-serif;
      background-color: #f0f4f8;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }
  </style>
</head>

<body>

  <div class="login-card mx-auto">
    <div class="login-header">
      <h3>.BOOM | لوحة تحكم الإداري</h3>
      <p>يرجى إدخال بياناتك لتسجيل الدخول</p>
    </div>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger error-message" role="alert">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form method="post">
      <div class="mb-3">
        <label for="email" class="form-label">البريد الإلكتروني</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="أدخل البريد الإلكتروني" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">كلمة المرور</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="أدخل كلمة المرور" required>
      </div>

      <button type="submit" class="btn btn-primary w-100 mt-3">تسجيل الدخول</button>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>