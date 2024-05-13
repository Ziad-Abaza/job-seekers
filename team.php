<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Team</title>
    <?php require_once 'components/head.php'; ?>
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner -->
        <?php require_once 'components/spinner.php'; ?>
        <!-- Navbar -->
        <?php require_once 'components/navbar.php'; ?>

        <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container-xxl py-5 ">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 class="section-title text-center mb-4">Our Members</h4>
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        <div class="col">
                            <div class="custom-card">
                                <div class="custom-card-img"><img loading="lazy" class="bg-img" src="img/team/bg.jpg" alt=""></div>
                                <div class="custom-card-avatar"><img src="img/team/ziad_hassan.jpg" alt=""></div>
                                <div class="custom-card-title">Ziad Hassan</div>
                                <div class="d-flex pt-2 justify-content-center justify-content-md-start">
                                    <a class="btn btn-sm-square btn-outline-body me-1" href="https://chat.whatsapp.com/CTTKCD46siZDCNlH41kHKO">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                    <a class="btn btn-sm-square btn-outline-body me-1" href="https://www.facebook.com/profile.php?id=100092738074559&mibextid=ZbWKwL">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a class="btn btn-sm-square btn-outline-body me-0" href="https://www.instagram.com/information.technology_club">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="custom-card">
                                <div class="custom-card-img"><img loading="lazy" class="bg-img" src="img/team/bg.jpg" alt=""></div>
                                <div class="custom-card-avatar"><img src="img/team/ziad(3).jpg" alt=""></div>
                                <div class="custom-card-title">Ashji Mohamed 🧡</div>
                                <div class="d-flex pt-2 justify-content-center justify-content-md-start">
                                    <a class="btn btn-sm-square btn-outline-body me-1" href="https://chat.whatsapp.com/CTTKCD46siZDCNlH41kHKO">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                    <a class="btn btn-sm-square btn-outline-body me-1" href="https://www.facebook.com/profile.php?id=100092738074559&mibextid=ZbWKwL">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a class="btn btn-sm-square btn-outline-body me-0" href="https://www.instagram.com/information.technology_club">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </div>
                            </div>
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