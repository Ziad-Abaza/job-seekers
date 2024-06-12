<?php 
session_start();
include("controller/Auth/verify.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Verify Account</title>
    <?php require_once 'components/head.php'; ?>
</head>
<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner -->
        <?php require_once 'components/spinner.php'; ?>
        <!-- Navbar -->
        <?php require_once 'components/navbar.php'; ?>
        
        <!-- Main Content -->
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="w-100 d-flex align-items-center justify-content-center wow fadeIn" data-wow-delay="0.5s">
                    <img src="img/Verified.gif" alt="Verified" class="wow bounceIn">
                </div>
                <div class="col-md-6 text-center wow fadeInUp" data-wow-delay="1s">
                    <?php ErrorHandler::displayErrors($error_messages); ?>
                    <?php ErrorHandler::displayMessage($success_messages); ?>
                    <a href="index.php" class="btn btn-primary wow fadeInUp" data-wow-delay="1.5s">Go to Home</a>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <?php require_once 'components/footer.php'; ?>
    </div>
    <?php require_once 'components/scripts.php'; ?>
</body>
</html>
