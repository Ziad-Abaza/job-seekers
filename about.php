<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>About Boom</title>
    <?php require_once 'components/head.php'; ?>
</head>

<body>
    <div class="bg-white p-0">
        <!-- Spinner -->
        <?php require_once 'components/spinner.php'; ?>
        <!-- Navbar -->
        <?php require_once 'components/navbar.php'; ?>

        <!-- About -->
        <div class="container-xxl py-5">
            <div class="container my-5">
                <div class="text-center mb-5">
                    <h1 class="display-5 fw-bold text-primary">About Us</h1>
                    <hr class="w-25 mx-auto border-primary" />
                </div>

                <div class="row g-5 align-items-center">
                    <div class="col-md-6 text-center">
                        <img src="https://images.pexels.com/photos/1181675/pexels-photo-1181675.jpeg"
                            alt="Programming" class="img-fluid rounded-4 shadow" style="max-height: 400px;" />
                    </div>
                    <div class="col-md-6">
                        <p class="lead text-muted">
                            BOOM is a dynamic platform that connects programmers of all levels with companies seeking to bring their projects to life.
                        </p>
                        <p>
                            Our mission is to empower developers by providing them with opportunities to work on real-world projects, improve their skills,
                            and build a strong professional portfolio that showcases their talent.
                        </p>
                        <p>
                            We collaborate with universities, training centers, and leading tech companies to ensure every developer finds the right opportunity based on their experience level.
                            Whether you're just starting out or already an experienced professional, BOOM offers something for everyone.
                        </p>
                        <p>
                            We strongly believe in hands-on learning, teamwork, and delivering quality results. Join our growing community today — a place where innovation meets success.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->

        <!-- Our Services -->
        <div class="container-xxl py-5 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center wow fadeIn" data-wow-delay="0.1s">
                        <h2 class="mb-4">Our Services</h2>
                        <p class="text-muted">We offer a range of services to cater to the needs of both job seekers and employers in the tech industry:</p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 wow fadeIn" data-wow-delay="0.2s">
                        <div class="service-item text-center">
                            <i class="fas fa-laptop-code fa-3x mb-4 text-primary"></i>
                            <h4 class="mb-3">Job Listings</h4>
                            <p class="text-muted">Explore our extensive database of job listings in various technology fields.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeIn" data-wow-delay="0.3s">
                        <div class="service-item text-center">
                            <i class="fas fa-users fa-3x mb-4 text-primary"></i>
                            <h4 class="mb-3">Talent Recruitment</h4>
                            <p class="text-muted">Connect with top talent in the tech industry and build your dream team.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeIn" data-wow-delay="0.4s">
                        <div class="service-item text-center">
                            <i class="fas fa-handshake fa-3x mb-4 text-primary"></i>
                            <h4 class="mb-3">Career Guidance</h4>
                            <p class="text-muted">Get expert advice and guidance on your career path in the tech industry.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Our Services End -->

        <!-- Why Choose Us -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center wow fadeIn" data-wow-delay="0.1s">
                        <h2 class="mb-4">Why Choose Us</h2>
                        <p class="text-muted">We strive to provide the best experience for both job seekers and employers:</p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 wow fadeIn" data-wow-delay="0.2s">
                        <div class="service-item text-center">
                            <i class="fas fa-chart-line fa-3x mb-4 text-primary"></i>
                            <h4 class="mb-3">Expertise</h4>
                            <p class="text-muted">Our team consists of industry experts with years of experience in the tech sector.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeIn" data-wow-delay="0.3s">
                        <div class="service-item text-center">
                            <i class="fas fa-hand-holding-heart fa-3x mb-4 text-primary"></i>
                            <h4 class="mb-3">Support</h4>
                            <p class="text-muted">We provide dedicated support to help you navigate through the job search or recruitment process.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeIn" data-wow-delay="0.4s">
                        <div class="service-item text-center">
                            <i class="fas fa-users-cog fa-3x mb-4 text-primary"></i>
                            <h4 class="mb-3">Customization</h4>
                            <p class="text-muted">Tailored solutions to meet the unique needs of each individual and organization.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Footer -->
        <?php require_once 'components/footer.php'; ?>
    </div>
    <?php require_once 'components/scripts.php'; ?>
</body>

</html>