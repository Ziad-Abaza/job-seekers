<?php
session_start();
include("Controller/companiesController.php");
?>
<?php require_once 'components/navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Company Registration</title>
    <?php require_once 'components/head.php'; ?>
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner -->
        <?php require_once 'components/spinner.php'; ?>
        <!-- Navbar -->
        <?php require_once 'components/navbar.php'; ?>

        <!-- Company Registration Form -->
        <div class="form-container">
            <div class="login-container text-center" id="login">
                <div class="top p-3 m-auto">
                    <header class="fs-3">Company Registration</header>
                </div>
                <form method="post" action="add-company.php" class="body-form" enctype="multipart/form-data">
                    <div class="form-box-section">
                        <input type="text" class="input-field input-form" name="name" id="name" placeholder=" ">
                        <label for="name">Company Name</label>
                        <i class="bx bx-user"></i>
                    </div>
                    <div class="form-box-section">
                        <input type="text" class="input-field input-form" name="description" id="description"
                            placeholder=" ">
                        <label for="description">Description</label>
                        <i class="bx bx-user"></i>
                    </div>
                    <div class="form-box-section">
                        <!-- <input type="text" class="input-field input-form" name="category" id="category" placeholder=" "> -->
                        <select class=" input-field input-form form-select" name="category">
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
                        <!-- <i class="bi bi-collection"></i> -->
                    </div>
                    <div class="form-box-section">
                        <select class="form-select" name="location">
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
                        <!-- <i class="bi bi-geo-alt-fill"></i> -->
                    </div>
                    <div class="form-box-section">
                        <input type="email" class="input-field input-form" name="email" id="email" placeholder=" ">
                        <label for="email">Email</label>
                        <i class="bx bx-mail-send"></i>
                    </div>
                    <div class="form-box-section">
                        <input type="file" class="input-field input-form" name="image" id="image" placeholder=" ">
                        <label for="image">Company Profile Photo</label>
                        <i class="bx bx-use"></i>
                    </div>
                    <div class="form-box-section">
                        <input type="tel" name="phone" class="input-field input-form" id="phone" placeholder=" ">
                        <label for="phone">Company Phone</label>
                        <i class="bx bxs-phone"></i>
                    </div>
                    <div class="form-box-section">
                        <input type="submit" class="submit btn btn-primary" name="signup" value="Sign Up">
                    </div>
                </form>
                <?php ErrorHandler::displayErrors($error_messages); ?>
                <?php ErrorHandler::displayErrors($result); ?>
            </div>
        </div>

        <!-- Footer -->
        <?php require_once 'components/footer.php'; ?>

        <?php require_once 'components/scripts.php'; ?>
</body>

</html>