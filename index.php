<?php session_start();?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Home</title>
    <?php require_once 'components/head.php'; ?>
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner -->
        <?php require_once 'components/spinner.php'; ?>
        <!-- Navbar -->
        <?php require_once 'components/navbar.php'; ?>

        <div class="container-xxl py-5 bg-dark page-header">
            <div class="container">
                <div class="row justify-content-start">
                    <div class="col-10 col-lg-8">
                        <h1 class="display-3 text-white animated slideInDown mb-4">Welcome to Tech Jobs</h1>
                        <p class="fs-5 fw-medium text-white mb-4 pb-2">Find the perfect job in the field of information technology or discover talented professionals to join your team. Vero elitr justo clita lorem. Ipsum dolor at sed stet sit diam no. Kasd rebum ipsum et diam justo clita et kasd rebum sea elitr.</p>
                        <a href="job-list.php" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Search Jobs</a>
                        <a href="" class="btn btn-secondary py-md-3 px-md-5 animated slideInRight">Employer Hub</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category -->
        <?php require_once 'components/category.php'; ?>

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
                        <a class="btn btn-primary btn-sm-hover py-3 px-5 mt-3" href="">Read More</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Job List -->
        <?php require_once 'components/jobList.php'; ?>
        <a class="btn btn-primary w-50 m-auto btn-hover fs-5" href="job-list.php">Browse More Jobs</a>
        <!-- Our Organization Companies -->
        <?php require_once 'components/bestCompany.php'; ?>
        <?php require_once 'components/footer.php'; ?>
    </div>
    <?php require_once 'components/scripts.php'; ?>
</body>

</html>