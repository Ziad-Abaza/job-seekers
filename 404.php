<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>404</title>
    <?php require_once 'components/head.php'; ?>
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner -->
        <?php require_once 'components/spinner.php'; ?>
        <!-- Navbar -->
        <?php require_once 'components/navbar.php'; ?>

        <!-- 404 -->
        <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container text-center">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="wow fadeInUp w-100 d-flex justify-content-center " data-wow-delay="0.3s">
                            <img src="img/404.gif" alt="" class="w-75">
                        </div>
                        <a class="btn btn-primary py-3 px-5 btn-sm-hover" href="index.php">Go Back To Home</a>
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