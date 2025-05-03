<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Jobs list</title>
    <?php require_once 'components/head.php'; ?>
</head>

<body>
    <div class="bg-white p-0">
        <!-- Spinner -->
        <?php require_once 'components/spinner.php'; ?>
        <!-- Navbar -->
        <?php require_once 'components/navbar.php'; ?>
        <!-- Search form -->
        <form method="GET" action="">
            <div class="container-fluid bg-primary mb-5 wow fadeIn" data-wow-delay="0.1s" style="padding: 35px;">
                <div class="container">
                    <div class="row g-2">
                        <div class="col-md-10">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <input type="text" class="form-control border-0" placeholder="Keyword" name="keyword" />
                                </div>
                                <div class="col-md-4">
                                    <select class="form-select border-0" name="category">
                                        <option selected>Category</option>
                                        <option value="UI/UX Design">UI/UX Design</option>
                                        <option value="Cloud Architecture">Cloud Architecture</option>
                                        <option value="IoT">IoT</option>
                                        <option value="Embedded Systems">Embedded Systems</option>
                                        <option value="Network Engineering">Network Engineering</option>
                                        <option value="Database Administration">Database Administration</option>
                                        <option value="App Development">App Development</option>
                                        <option value="Web Development">Web Development</option>
                                        <option value="Software Development">Software Development</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-select border-0" name="location">
                                        <option selected>Location</option>
                                        <option value="Alexandria">Alexandria</option>
                                        <option value="Aswan">Aswan</option>
                                        <option value="Asyut">Asyut</option>
                                        <option value="Beheira">Beheira</option>
                                        <option value="Beni Suef">Beni Suef</option>
                                        <option value="Cairo">Cairo</option>
                                        <option value="Dakahlia">Dakahlia</option>
                                        <option value="Damietta">Damietta</option>
                                        <option value="Faiyum">Faiyum</option>
                                        <option value="Gharbia">Gharbia</option>
                                        <option value="Giza">Giza</option>
                                        <option value="Ismailia">Ismailia</option>
                                        <option value="Kafr El Sheikh">Kafr El Sheikh</option>
                                        <option value="Luxor">Luxor</option>
                                        <option value="Matruh">Matruh</option>
                                        <option value="Minya">Minya</option>
                                        <option value="Monufia">Monufia</option>
                                        <option value="New Valley">New Valley</option>
                                        <option value="North Sinai">North Sinai</option>
                                        <option value="Port Said">Port Said</option>
                                        <option value="Qalyubia">Qalyubia</option>
                                        <option value="Qena">Qena</option>
                                        <option value="Red Sea">Red Sea</option>
                                        <option value="Sharqia">Sharqia</option>
                                        <option value="Sohag">Sohag</option>
                                        <option value="South Sinai">South Sinai</option>
                                        <option value="Suez">Suez</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" name="submit" class="btn btn-dark border-0 w-100">Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="container-xxl bg-white p-0">
            <div class="container-xxl py-5">
                <div class="container">
                    <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">Job Listing</h1>
                    <!-- Job -->
                    <?php require_once 'components/jobList.php'; ?>
                    <a class="btn btn-primary w-50 m-auto btn-hover fs-5" href="">Browse More Jobs</a>
                </div>
            </div>
            <!-- footer -->
        </div>
        <?php require_once 'components/footer.php'; ?>
        <!-- scripts -->
    </div>
        <?php require_once 'components/scripts.php'; ?>

</body>

</html>