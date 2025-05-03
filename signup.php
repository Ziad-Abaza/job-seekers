<?php
session_start();
include("controller/Auth/SignupEmployeeController.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sign Up - Boom</title>
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

        .custom-file-upload {
            border: 2px dashed #ced4da;
            padding: 25px;
            text-align: center;
            border-radius: 10px;
            background-color: #f8f9fa;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .custom-file-upload:hover {
            background-color: #e9ecef;
            border-color: #26577c;
        }

        .custom-file-upload i {
            font-size: 2rem;
            color: #6c757d;
        }

        .custom-file-upload input {
            display: none;
        }

        .image-preview {
            margin-top: 15px;
            text-align: center;
        }

        .image-preview img {
            max-width: 120px;
            border-radius: 50%;
            border: 3px solid #dee2e6;
        }

        .custom-file-upload.hover {
            background-color: #dee2e6;
            border-color: #198754;
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
                <h1 class="fw-bold mb-4 text-light">Start Your Tech Career with Boom</h1>
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

        <!-- Right Side - Signup Form -->
        <div class="col-md-6 d-flex align-items-center justify-content-center bg-white p-5">
            <div class="login-box w-100">
                <h2 class="text-center fw-bold mb-4">Create an Account</h2>
                <p class="text-center text-muted mb-4">Already have an account?
                    <a href="login.php" class="text-primary text-decoration-none">Log in</a>
                </p>

                <!-- Form Start -->
                <form method="post" action="signup.php" enctype="multipart/form-data">
                    <!-- Full Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter your full name" required />
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required />
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter a password" required />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Re-enter your password" required />
                    </div>

                    <!-- Phone -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" name="phone" id="phone" class="form-control" placeholder="Enter your phone number" />
                    </div>

                    <!-- Profile Photo -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Profile Photo</label>
                        <div class="custom-file-upload" id="dropArea">
                            <i class="bi bi-cloud-upload"></i>
                            <p class="mb-0 small text-muted">Click to upload or drag and drop</p>
                            <input type="file" name="image" id="image" accept="image/*" />
                        </div>
                        <div class="image-preview mt-2" id="imagePreview">
                            <img id="previewImg" src="#" alt="Image Preview" style="display:none;" />
                        </div>
                    </div>


                    <!-- Submit Button -->
                    <button type="submit" name="signup" class="btn btn-primary w-100 mb-3">Sign Up</button>

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

    <!-- JavaScript for Preview Image -->
    <script>
        const fileInput = document.getElementById('image');
        const previewImg = document.getElementById('previewImg');
        const dropArea = document.getElementById('dropArea');

        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                previewImg.style.display = 'none';
            }
        });

        dropArea.addEventListener('click', () => {
            fileInput.click();
        });

        dropArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropArea.classList.add('hover');
        });

        dropArea.addEventListener('dragleave', () => {
            dropArea.classList.remove('hover');
        });

        dropArea.addEventListener('drop', (e) => {
            e.preventDefault();
            dropArea.classList.remove('hover');
            const file = e.dataTransfer.files[0];
            if (file) {
                fileInput.files = e.dataTransfer.files;
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

</body>

</html>