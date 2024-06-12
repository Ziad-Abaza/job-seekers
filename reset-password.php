<?php
session_start();
include("controller/Auth/reset_password_process.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Reset Password</title>
    <?php require_once 'components/head.php'; ?>
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner -->
        <?php require_once 'components/spinner.php'; ?>
        <nav class="navbar navbar-expand-lg w-100 bg-primary navbar-light shadow sticky-top p-0">
            <a href="index.php" class="navbar-brand w-100 d-flex align-items-center text-center py-0 px-4 px-lg-5">
                <h1 class="m-0 text-white">Tech Jobs</h1>
            </a>
        </nav>
        <div class="form-container">
            <div class="reset-container text-center h-100" id="reset-password">
                <div class="top p-3 m-auto">
                    <header class="fs-3">Reset Password</header>
                </div>
                <form method="post" action="#" class="body-form">
                    <div class="form-box-section">
                        <input type="email" class="input-field input-form" name="email" placeholder="Enter your email" required>
                        <i class="bx bx-envelope"></i>
                    </div>
                    <div class="form-box-section">
                        <input type="password" class="input-field input-form" name="new_password" placeholder="New Password" required>
                        <i class="bx bx-lock-alt"></i>
                    </div>
                    <div class="form-box-section">
                        <input type="password" class="input-field input-form" name="confirm_password" placeholder="Confirm Password" required>
                        <i class="bx bx-lock-alt"></i>
                    </div>
                    <div class="form-box-section">
                        <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                    </div>
                    <div class="form-box-section">
                        <input type="submit" class="submit btn btn-primary" name="submit" value="Reset Password">
                    </div>
                </form>
                <?php ErrorHandler::displayErrors($error_messages); ?>
                <?php ErrorHandler::displayMessage($success_messages); ?>
            </div>
            <div class="container-fluid bg-dark text-white-50 footer mt-3 wow fadeIn" data-wow-delay="0.1s">
                <div class="container">
                    <div class="copyright">
                        <div class="row">
                            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                                <a href="./team" class="copyling-link">&copy; Developed by <span class="team-span">EgyTech</span> Team</a>
                            </div>
                            <div class="col-md-6 text-center text-md-end">
                                <div class="footer-menu">
                                    <a href="index.php">Home</a>
                                    <a href="cookies.php">Cookies</a>
                                    <a href="FQAs.php">FQAs</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require_once 'components/scripts.php'; ?>
</body>

</html>
