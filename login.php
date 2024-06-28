<?php
session_start();
include ("controller/Auth/LoginController.php");
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
        <nav class="navbar navbar-expand-lg w-100 bg-primary navbar-light shadow sticky-top p-0">
            <a href="index.php" class="navbar-brand w-100 d-flex align-items-center text-center py-0 px-4 px-lg-5">
                <h1 class="m-0 text-white">Tech Jobs</h1>
            </a>
            <!-- Nav Bar -------------------------------------------------------------------------- -->
        </nav>
        <div class="form-container">
            <div class="login-container text-center h-100" id="login">
                <div class="top p-3 m-auto">
                    <a href="signup.php">Don't have an account?<span></span> Sign Up</a>
                    <header class="fs-3">Login</header>
                </div>
                <div class="form-box-section">
                    <input type="password" name="password" class=" input-field input-form" placeholder="Password">
                    <i class="bx bx-lock-alt"></i>
                </div>
                <form method="post" action="login.php" class="body-form">
                    <div class="form-box-section">
                        <input type="email" class="input-field input-field input-form" name="email"
                            placeholder="Username or Email">
                        <i class="bx bx-user"></i>
                    </div>


                    <div class="form-box-section">
                        <input type="submit" class="submit btn btn-primary" name="submit" value="Sign In">
                    </div>
                </form>
                <?php ErrorHandler::displayErrors($error_messages); ?>
                <?php ErrorHandler::displayErrors($result); ?>
            </div>
            <div class="container-fluid bg-dark text-white-50 footer mt-3 wow fadeIn" data-wow-delay="0.1s">
                <div class="container">
                    <div class="copyright">
                        <div class="row">
                            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                                <a href="./team" class="copyling-link">&copy; Developer by<span class="team-span">
                                        EgyTech</span> Team</a>
                            </div>
                            <div class="col-md-6 text-center text-md-end">
                                <div class="footer-menu">
                                    <a href="index.php">Home</a>
                                    <a href="cookies.php">Cookies</a>
                                    <a href="FQAs.php">FQAs</a>
                                </div>
                            </div>

                            <?php require_once 'components/scripts.php'; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>