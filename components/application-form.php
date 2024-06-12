<div class="form-container">
    <div class="login-container text-center" id="login">
        <div class="top p-3 m-auto">
            <span>Do You Want to Apply For the Job? </span>
            <header class="fs-3">Apply Form</header>
        </div>
        <?php if(isset($_SESSION['user_status']) && $_SESSION['user_status'] == 1){?>
        <form method="post" action="controller/ApplyController.php" class="body-form w-100" enctype="multipart/form-data">
            <input type="hidden" name="user_id" value="<?php echo isset($user_details['id']) ? $user_details['id'] : $_SESSION['user_id']; ?>">
            <input type="hidden" name="job_posting_id" value="<?php echo isset($id) ? $id : $_GET['jobId']; ?>">
            <div class="form-box-section">
                <input type="text" class="input-field input-form" name="name" id="name" placeholder=" " value="<?php echo isset($user_details['name']) ? $user_details['name'] : ''; ?>">
                <label for="name">Name</label>
                <i class="bx bx-user"></i>
            </div>
            <div class="form-box-section">
                <input type="text" class="input-field input-form" name="email" id="email" placeholder=" " value="<?php echo isset($user_details['email']) ? $user_details['email'] : ''; ?>">
                <label for="email">Email</label>
                <i class="bx bx-user"></i>
            </div>
            <div class="form-box-section">
                <input type="tel" class="input-field input-form" name="phone" id="phone" placeholder=" " value="<?php echo isset($user_details['phone']) ? $user_details['phone'] : ''; ?>">
                <label for="phone">Phone Number</label>
                <i class="bx bx-mail-send"></i>
            </div>
            <div class="form-box-section">
                <select class="form-select input-field input-form" name="type">
                    <option value="part time">Part Time</option>
                    <option value="full time">Full Time</option>
                </select>
                <!-- <i class="bi bi-geo-alt-fill"></i> -->
            </div>
            <div class="form-box-section">
                <input type="text" class="input-field input-form" name="education" id="education" placeholder=" " value="<?php echo isset($user_details['education']) ? $user_details['education'] : ''; ?>">
                <label for="education">Education</label>
                <i class="bx bx-mail-send"></i>
            </div>
            <div class="form-box-section">
                <select class="form-select input-field input-form" name="location" id="location">
                    <?php
                    $locations = ['Alexandria', 'Aswan', 'Asyut', 'Beheira', 'Beni Suef', 'Cairo', 'Dakahlia', 'Damietta', 'Faiyum', 'Gharbia', 'Giza', 'Ismailia', 'Kafr El Sheikh', 'Luxor', 'Matruh', 'Minya', 'Monufia', 'New Valley', 'North Sinai', 'Port Said', 'Qalyubia', 'Qena', 'Red Sea', 'Sharqia', 'Sohag', 'South Sinai', 'Suez'];
                    foreach ($locations as $loc) {
                        $selected = isset($user_details['location']) && $user_details['location'] == $loc ? 'selected' : '';
                        echo "<option value=\"$loc\" $selected>$loc</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-box-section">
                <input type="text" class="input-field input-form" name="specialization" id="specialization" placeholder=" " value="<?php echo isset($user_details['specialization']) ? $user_details['specialization'] : ''; ?>">
                <label for="specialization">Specialization</label>
                <i class="bx bx-mail-send"></i>
            </div>
            <div class="form-box-section">
                <input type="file" class="input-field input-form" name="cv" id="cv" placeholder=" ">
                <label for="cv">CV</label>
                <i class="bx bx-use"></i>
            </div>
            <div class="form-box-section">
                <input type="submit" class="submit btn btn-primary px-5" name="signup" value="Apply Now">
            </div>
        </form>
        <?php }else{?>
            <div class="container mt-4">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="alert alert-warning text-center" role="alert">
                            <strong>Attention!</strong> You need to activate your account first to apply for the job.
                        </div>
                    </div>
                </div>
            </div>
        <?php }?>
    </div>
</div>