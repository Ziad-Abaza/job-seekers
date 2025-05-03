<?php
session_start();
include("controller/DetailsController.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Company Details</title>
    <?php require_once 'components/head.php'; ?>
</head>

<body>
    <div class="bg-white p-0">
        <!-- Spinner -->
        <?php require_once 'components/spinner.php'; ?>
        <!-- Navbar -->
        <?php require_once 'components/navbar.php'; ?>


        <!-- Company Detail -->
        <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container">
                <div class="row gy-5 gx-4">
                    <div class="col-lg-8">
                        <?php if ($companyData) : ?>
                            <?php foreach ($companyData as $company) : ?>
                                <div class="mt-5 mb-1 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <img src="<?php echo $company['image']; ?>" alt="" class="w-100 h-100">
                                </div>
                                <div class="mb-5">
                                    <h3 class="mb-3"><?php echo $company['name']; ?></h3>
                                    <p><?php echo $company['description']; ?></p>
                                    <h4 class="mb-3">Social Links</h4>
                                    <div class="social-icons">
                                        <?php
                                        $social_name = explode("<br>", $company['social_link']);
                                        $social_names = explode("<br>", $company['social_name']);
                                        foreach ($social_name as $key => $link) {
                                            echo '<a href="' . $link . '" target="_blank" rel="noopener noreferrer" class="fs-1"><i class="bi bi-' . $social_names[$key] . '"></i></a>';
                                        }
                                        ?>
                                    </div>
                                    <h4 class="mt-4 mb-3">Jobs Posted</h4>
                                    <?php
                                    $job_titles = explode("<br>", $company['job_titles']);
                                    $job_ids = explode("<br>", $company['job_ids']);

                                    if (empty($job_titles[0])) {
                                        echo '<p>No jobs posted.</p>';
                                    } else {
                                        foreach ($job_titles as $key => $title) {
                                            echo '<div class="job-item p-2 mb-4">
                                                    <div class="row g-4 justify-content-between">
                                                        <div class="col-sm-12 col-md-6 d-flex align-items-center">
                                                            <div class="text-start ps-4">
                                                                <h5 class="mb-3">' . $title . '</h5>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                                            <div class="d-flex w-100">
                                                                <a class="btn btn-primary btn-sm-hover w-100" href="job-detail.php?jobId=' . $job_ids[$key] . '">View</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>';
                                        }
                                    }
                                    ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p>No company data found.</p>
                        <?php endif; ?>
                    </div>

                    <div class="col-lg-4">
                        <div class="bg-light rounded p-5 mb-4 wow slideInUp" data-wow-delay="0.1s">
                            <h4 class="mb-4">Company Owner</h4>
                            <?php foreach ($companyData as $owner) : ?>
                                <div style="width: 170px; height:170px; border:2px solid;" class=" mb-2 rounded-circle border-primary overflow-hidden d-flex justify-content-center align-items-center">
                                    <img class="img-fluid rounded-circle" src="<?php echo $owner['owner_image']; ?>" alt="<?php echo $owner['owner_name']; ?>" style="width: 160px; height:160px; padding:2px;">
                                </div>
                                <p class="m-0"><span class="fw-bold text-primary">Name:</span> <?php echo $owner['owner_name']; ?></p>
                                <p class="m-0"><span class="fw-bold text-primary">Email:</span> <?php echo $owner['owner_email']; ?></p>
                                <ul class="list-unstyled mt-3 d-flex gap-2">
                                    <?php
                                    $social_name = explode("<br>", $owner['social_link']);
                                    $social_names = explode("<br>", $owner['social_name']);
                                    foreach ($social_name as $key => $link) {
                                        echo '<li class="my-2"><a href="' . $link . '" target="_blank" rel="noopener noreferrer" class="fs-1"><i class="bi bi-' . $social_names[$key] . '"></i></a></li>';
                                    }
                                    ?>
                                </ul>
                            <?php endforeach; ?>
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