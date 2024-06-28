<?php
session_start();
include("controller/Auth/SignupEmployeeController.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Registration</title>
    <?php require_once 'components/head.php'; ?>
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner -->
        <?php require_once 'components/spinner.php'; ?>
        <!-- navbar -->
        <nav class="navbar navbar-expand-lg w-100 bg-primary navbar-light shadow sticky-top p-0">
            <a href="index.php" class="navbar-brand w-100 d-flex align-items-center text-center py-0 px-4 px-lg-5">
                <h1 class="m-0 text-white">Tech Jobs</h1>
            </a>
        </nav>

        <body>
            <div class="container-xxl bg-white p-0">
                <!-- Spinner -->
                <?php require_once 'components/spinner.php'; ?>
                <!-- navbar -->
                <nav class="navbar navbar-expand-lg w-100 bg-primary navbar-light shadow sticky-top p-0">
                    <a href="index.php"
                        class="navbar-brand w-100 d-flex align-items-center text-center py-0 px-4 px-lg-5">
                        <h1 class="m-0 text-white">Tech Jobs</h1>
                    </a>
                    <div class="form-container h-100">
                        <div class="login-container text-center" id="login">
                            <div class="top p-3 m-auto">
                                <span>Already have an account? <a href="login.php" class="text-primary">Login</a></span>
                                <header class="fs-3">Sign Up</header>
                            </div>
                            <form method="post" action="signup.php" class="body-form" enctype="multipart/form-data">
                                <div class="form-box-section">
                                    <input type="text" class="input-field input-form" name="name" id="name"
                                        placeholder=" ">
                                    <label for="name">Full Name</label>
                                    <i class="bx bx-user"></i>
                                </div>
                                <div class="form-box-section">
                                    <input type="email" class="input-field input-form" name="email" id="email"
                                        placeholder=" ">
                                    <label for="email">Email</label>
                                    <i class="bx bx-mail-send"></i>
                                </div>
                                <div class="form-box-section">
                                    <input type="password" name="password" class="input-field input-form" id="password"
                                        placeholder=" ">
                                    <label for="password">Password</label>
                                    <i class="bx bx-lock-alt"></i>
                                </div>
                                <div class="form-box-section">
                                    <input type="password" name="confirm_password" class="input-field input-form"
                                        id="confirm_password" placeholder=" ">
                                    <label for="confirm_password">Confirm Password</label>
                                    <i class="bx bx-lock-alt"></i>
                                </div>
                                <div class="form-box-section">
                                    <input type="file" class="input-field input-form" name="image" id="image"
                                        placeholder=" ">
                                    <label for="image">Profile Photo</label>
                                    <i class="bx bx-use"></i>
                                </div>
                                <div class="form-box-section">
                                    <input type="tel" name="phone" class="input-field input-form" id="phone"
                                        placeholder=" ">
                                    <label for="phone">Phone</label>
                                    <i class="bx bxs-phone"></i>
                                </div>
                                <div class="form-box-section">
                                    <input type="submit" class="submit btn btn-primary" name="signup" value="Sign Up">
                                </div>
                            </form>
                            <?php ErrorHandler::displayErrors($error_messages); ?>
                            <?php ErrorHandler::displayErrors($result); ?>
                        </div>
                        <!-- footer -->
                        <div class="container-fluid bg-dark text-white-50 footer mt-3 wow fadeIn" data-wow-delay="0.1s">
                            <div class="container">
                                <div class="copyright">
                                    <div class="row">
                                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                                            <a href="./team" class="copyling-link">&copy; Developer by<span
                                                    class="team-span"> EgyTech</span> Team</a>
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