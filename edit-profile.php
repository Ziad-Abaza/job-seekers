<?php
session_start();
include("controller/ProfileController.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Profile</title>
    <?php require_once 'components/head.php'; ?>
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner -->
        <?php require_once 'components/spinner.php'; ?>
        <!-- Navbar -->
        <?php require_once 'components/navbar.php'; ?>

        <!-- Edit Profile Form -->
        <div class="form-container">
            <div class="login-container text-center" id="login">
                <div class="top p-3 m-auto">
                    <header class="fs-3">Edit Profile</header>
                </div>
                <form method="post" action="edit-profile.php" class="body-form w-100" enctype="multipart/form-data">
                    <div class="form-box-section">
                        <input type="text" class="input-field input-form" id="name" name="name" value="<?php echo $userDetails['name']; ?>">
                        <label for="name">Name</label>
                        <i class="bx bx-user"></i>
                    </div>
                    <div class="form-box-section">
                        <select class="form-select" name="location">
                            <?php
                            $locations = ['Alexandria', 'Aswan', 'Asyut', 'Beheira', 'Beni Suef', 'Cairo', 'Dakahlia', 'Damietta', 'Faiyum', 'Gharbia', 'Giza', 'Ismailia', 'Kafr El Sheikh', 'Luxor', 'Matruh', 'Minya', 'Monufia', 'New Valley', 'North Sinai', 'Port Said', 'Qalyubia', 'Qena', 'Red Sea', 'Sharqia', 'Sohag', 'South Sinai', 'Suez'];
                            foreach ($locations as $loc) {
                                $selected = isset($userDetails['location']) && $userDetails['location'] == $loc ? 'selected' : '';
                                echo "<option value=\"$loc\" $selected>$loc</option>";
                            }
                            ?>
                        </select>
                        <!-- <i class="bi bi-geo-alt-fill"></i> -->
                    </div>
                    <div class="form-box-section">
                        <input type="email" class="input-field input-form" id="email" name="email" value="<?php echo $userDetails['email']; ?>">
                        <label for="email">Email</label>
                        <i class="bx bx-mail-send"></i>
                    </div>
                    <div class="form-box-section">
                        <input type="text" class="input-field input-form" id="specialization" name="specialization" value="<?php echo $userDetails['specialization']; ?>">
                        <label for="email">Specialization</label>
                        <i class="bx bx-mail-send"></i>
                    </div>
                    <div class="form-box-section">
                        <input type="text" class="input-field input-form" id="education" name="education" value="<?php echo $userDetails['education']; ?>">
                        <label for="email">Education</label>
                        <i class="bx bx-mail-send"></i>
                    </div>
                    <div class="form-box-section">
                        <input type="file" class="input-field input-form" name="image" id="image" placeholder=" ">
                        <label for="image">Profile Photo</label>
                        <i class="bx bx-use"></i>
                    </div>
                    <div class="form-box-section">
                        <input type="file" class="input-field input-form" name="cv" id="cv" placeholder=" ">
                        <label for="cv">CV</label>
                        <i class="bx bx-use"></i>
                    </div>
                    <div class="form-box-section">
                        <input type="text" class="input-field input-form" id="phone" name="phone" value="<?php echo $userDetails['phone']; ?>">
                        <label for="phone">Phone</label>
                        <i class="bx bxs-phone"></i>
                    </div>
                    <?php foreach ($userDetails['social_links'] as $social_link) : ?>
                        <div class="form-box-section">
                            <input type="text" class="input-field input-form" id="<?php echo $social_link['name']; ?>" name="<?php echo $social_link['name']; ?>" value="<?php echo $social_link['url']; ?>">
                            <label for="<?php echo $social_link['name']; ?>"><?php echo ucfirst($social_link['name']); ?></label>
                        </div>
                    <?php endforeach; ?>
                    <div class="form-box-section">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
                <?php ErrorHandler::displayErrors($error_messages); ?>
            </div>

        </div>

        <!-- Footer -->
        <?php require_once 'components/footer.php'; ?>
    </div>
    <!-- Scripts -->
    <?php require_once 'components/scripts.php'; ?>
</body>

</html>