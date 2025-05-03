<?php
session_start();
include("Controller/companiesController.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Company Registration</title>
    <?php require_once 'components/head.php'; ?>
</head>

<body>
    <div class=" bg-white p-0">
        <!-- Spinner -->
        <?php require_once 'components/spinner.php'; ?>
        <!-- Navbar -->
        <?php require_once 'components/navbar.php'; ?>

        <!-- Company Registration Form -->
        <div class="form-container">
            <div class="login-container text-center" id="login">
                <div class="top p-3 m-auto">
                    <header class="fs-3">modify Company</header>
                </div>
                <form method="post" action="modify-company.php" class="body-form" enctype="multipart/form-data">
                    <div class="form-box-section">
                        <input type="text" class="input-field input-form" name="name" id="name" placeholder=" " value="<?php echo isset($companyInfo['name']) ? $companyInfo['name'] : ''; ?>">
                        <label for="name">Company Name</label>
                        <i class="bx bx-user"></i>
                    </div>
                    <div class="form-box-section">
                        <input type="text" class="input-field input-form" name="description" id="description" placeholder=" " value="<?php echo isset($companyInfo['description']) ? $companyInfo['description'] : ''; ?>">
                        <label for="description">Description</label>
                        <i class="bx bx-user"></i>
                    </div>
                    <div class="form-box-section">
                        <select class="input-field input-form form-select" name="category">
                            <?php
                            $categories = ['UI/UX Design', 'Cloud Architecture', 'IoT', 'Embedded Systems', 'Network Engineering', 'Database Administration', 'App Development', 'Web Development', 'Software Development'];
                            foreach ($categories as $cat) {
                                $selected = isset($companyInfo['category']) && $companyInfo['category'] == $cat ? 'selected' : '';
                                echo "<option value=\"$cat\" $selected>$cat</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-box-section">
                        <select class="form-select" name="location">
                            <option selected>Location</option>
                            <?php
                            $locations = ['Alexandria', 'Aswan', 'Asyut', 'Beheira', 'Beni Suef', 'Cairo', 'Dakahlia', 'Damietta', 'Faiyum', 'Gharbia', 'Giza', 'Ismailia', 'Kafr El Sheikh', 'Luxor', 'Matruh', 'Minya', 'Monufia', 'New Valley', 'North Sinai', 'Port Said', 'Qalyubia', 'Qena', 'Red Sea', 'Sharqia', 'Sohag', 'South Sinai', 'Suez'];
                            foreach ($locations as $loc) {
                                $selected = isset($companyInfo['location']) && $companyInfo['location'] == $loc ? 'selected' : '';
                                echo "<option value=\"$loc\" $selected>$loc</option>";
                            }
                            ?>
                        </select>
                        <!-- <i class="bi bi-geo-alt-fill"></i> -->
                    </div>
                    <div class="form-box-section">
                        <input type="email" class="input-field input-form" name="email" id="email" placeholder=" " value="<?php echo isset($companyInfo['email']) ? $companyInfo['email'] : ''; ?>">
                        <label for="email">Email</label>
                        <i class="bx bx-mail-send"></i>
                    </div>
                    <div class="form-box-section">
                        <input type="file" class="input-field input-form" name="image" id="image" placeholder=" ">
                        <label for="image">Company Profile Photo</label>
                        <i class="bx bx-use"></i>
                    </div>
                    <div class="form-box-section">
                        <input type="tel" name="phone" class="input-field input-form" id="phone" placeholder=" " value="<?php echo isset($companyInfo['phone']) ? $companyInfo['phone'] : ''; ?>">
                        <label for="phone">Company Phone</label>
                        <i class="bx bxs-phone"></i>
                    </div>
                    <input type="hidden" name="id" value="<?php echo isset($companyInfo['id']) ? $companyInfo['id'] : ''; ?>">
                    <div class="form-box-section">
                        <input type="submit" class="submit btn btn-primary" name="Update" value="Update">
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