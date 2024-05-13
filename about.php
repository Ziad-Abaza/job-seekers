<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>About Tech Jobs</title>
    <?php require_once 'components/head.php'; ?>
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner -->
        <?php require_once 'components/spinner.php';?>
        <!-- Navbar -->
        <?php require_once 'components/navbar.php';?>

        <!-- About -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="row g-0 about-bg rounded overflow-hidden">
                            <div class="col-6 text-start">
                                <img class="img-fluid w-100" src="img/about-1.jpg">
                            </div>
                            <div class="col-6 text-start">
                                <img class="img-fluid" src="img/about-2.jpg" style="width: 85%; margin-top: 15%;">
                            </div>
                            <div class="col-6 text-end">
                                <img class="img-fluid" src="img/about-3.jpg" style="width: 85%;">
                            </div>
                            <div class="col-6 text-end">
                                <img class="img-fluid w-100" src="img/about-4.jpg">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                        <h1 class="mb-4">Welcome to Tech Jobs</h1>
                        <p class="mb-4">Tech Jobs is your gateway to a world of opportunities in the field of information technology. Whether you are a developer, designer, or application specialist, we help you find the perfect job or talent for your needs.</p>
                        <p><i class="fa fa-check text-primary me-3"></i>Explore a wide range of job listings in technology fields</p>
                        <p><i class="fa fa-check text-primary me-3"></i>Connect with top companies and employers</p>
                        <p><i class="fa fa-check text-primary me-3"></i>Find talented professionals to join your team</p>
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
