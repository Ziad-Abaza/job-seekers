<?php
session_start();
include("controller/Auth/LoginController.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - Boom</title>
    <?php require_once 'components/head.php'; ?>
    <style>
        .half-bg {
            background-color: #26577c;
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            max-width: 450px;
            width: 100%;
        }

        .form-floating-input {
            position: relative;
            margin-bottom: 20px;
        }

        .form-floating-input input {
            width: 100%;
            padding: 10px 0 5px 0;
            border: none;
            border-bottom: 2px solid #ced4da;
            background: transparent;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-floating-input input:focus {
            outline: none;
            border-bottom-color: #26577c;
        }

        .form-floating-label {
            position: absolute;
            top: 10px;
            left: 0;
            pointer-events: none;
            transition: 0.3s ease all;
            color: #6c757d;
        }

        .form-floating-input input:focus~.form-floating-label,
        .form-floating-input input:not(:placeholder-shown)~.form-floating-label {
            top: -10px;
            font-size: 0.8rem;
            color: #26577c;
        }
    </style>
</head>

<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-dark text-white shadow sticky-top">
        <div class="container-fluid">
            <a href="index.php" class="navbar-brand text-white fs-4 fw-bold">Boom</a>
        </div>
    </nav>

    <!-- Split Layout -->
    <div class="row g-0">
        <!-- Left Side - Info Section -->
        <div class="col-md-6 half-bg d-flex align-items-center justify-content-center text-center p-5">
            <div>
                <h1 class="fw-bold mb-4 text-white">Start Your Tech Career with Boom</h1>
                <p class="text-white-75 mb-4">
                    Boom is your gateway to the world of technology employment. We connect skilled professionals and fresh graduates with top tech companies seeking talent in software development, cybersecurity, AI, data science, and more.
                </p>
                <ul class="list-unstyled text-start text-white-75" dir="ltr">
                    <li class="mb-2"><i class="bi bi-check-circle-fill me-2 text-white"></i> Over 700 technology-related job categories</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill me-2 text-white"></i> Quality job opportunities vetted by experts</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill me-2 text-white"></i> Access to startups, mid-sized firms, and global tech giants</li>
                    <li><i class="bi bi-check-circle-fill me-2 text-white"></i> Tools for employers to post jobs and find qualified candidates quickly</li>
                </ul>
                <p class="text-white-75 mt-3">
                    Whether you're looking to hire or get hired, Boom is your one-stop platform for all things tech employment.
                </p>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="col-md-6 d-flex align-items-center justify-content-center bg-white p-5">
            <div class="login-box w-100">
                <h2 class="text-center fw-bold mb-4">Sign In to Your Account</h2>
                <p class="text-center text-muted mb-4">Don’t have an account?
                    <a href="signup.php" class="text-primary text-decoration-none">Join here</a>
                </p>

                <!-- Form Start -->
                <form method="post" action="login.php">
                    <!-- Email Input -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email or Phone Number</label>
                        <input type="text" name="email" id="email" class="form-control" required />
                    </div>

                    <!-- Password Input -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required />
                    </div>

                    <!-- Remember Me & Forget Password -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input id="remember" type="checkbox" name="remember" value="Remember Me" class="form-check-input" />
                            <label for="remember" class="form-check-label">Remember Me</label>
                        </div>
                        <a href="#" class="text-decoration-none text-primary">Forget Password?</a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" name="submit" class="btn btn-primary w-100 mb-3">Log In</button>

                    <!-- Terms -->
                    <p class="small text-center text-muted">
                        By joining, you agree to the Boom <a href="#" class="text-decoration-none">Terms of Service</a> and to occasionally receive emails from us. Please read our <a href="#" class="text-decoration-none">Privacy Policy</a>.
                    </p>
                </form>
                <!-- Form End -->

                <?php ErrorHandler::displayErrors($error_messages); ?>
                <?php ErrorHandler::displayErrors($result); ?>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer class="bg-dark text-white py-3">
        <div class="container text-center text-md-start">
            <div class="row">
                <div class="col-md-6 mb-3 mb-md-0">
                    <p class="m-0">&copy; 2025 Boom. All Rights Reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="index.php" class="text-white text-decoration-none me-3">Home</a>
                    <a href="cookies.php" class="text-white text-decoration-none me-3">Cookies</a>
                    <a href="FQAs.php" class="text-white text-decoration-none">FQAs</a>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>