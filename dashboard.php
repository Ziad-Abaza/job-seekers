<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - BOOM</title>

    <!-- Include Head Components -->
    <?php require_once 'components/head.php'; ?>
</head>

<body>

    <div class=" bg-white p-0">
        <?php require_once 'components/admin-navbar.php'; ?>
        <!-- Navbar -->

        <!-- Admin Dashboard Content -->
        <div class="container py-5 dashboard-welcome text-center">
            <h2>Welcome to the Admin Dashboard</h2>
            <p>Please choose an option from the top menu to manage the system.</p>
        </div>

        <!-- Footer -->
        <?php require_once 'components/footer.php'; ?>
    </div>

    <!-- Scripts -->
    <?php require_once 'components/scripts.php'; ?>
</body>

</html>