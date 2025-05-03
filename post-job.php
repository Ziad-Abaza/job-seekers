<?php
session_start();
include("controller/PostJobController.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Post A Job</title>
    <?php require_once 'components/head.php'; ?>
</head>

<body>
    <div class="bg-white p-0">
        <!-- Spinner -->
        <?php require_once 'components/spinner.php'; ?>
        <!-- Navbar -->
        <?php require_once 'components/navbar.php'; ?>

        <!-- Post A Job -->
        <div class="container-xxl py-5">
            <div class="container">
                <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">Post A Job</h1>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" >
                    <div class="mb-3">
                        <label for="title" class="form-label">Job Title</label>
                        <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Job Description</label>
                        <textarea class="form-control" id="description" name="description" rows="5"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="salary" class="form-label">Salary</label>
                        <input type="number" class="form-control" id="salary" name="salary">
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Job Type</label>
                        <select class="form-select" id="type" name="type">
                            <option value="full time">Full Time</option>
                            <option value="part time">Part Time</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Job Category</label>
                        <select class="form-select" id="category" name="category">
                            <option value="Web Development">Web Development</option>
                            <option value="UI/UX Design">UI/UX Design</option>
                            <option value="App Development">App Development</option>
                            <option value="Software Development">Software Development</option>
                            <option value="Database Administration">Database Administration</option>
                            <option value="Network Engineering">Network Engineering</option>
                            <option value="Embedded Systems">Embedded Systems</option>
                            <option value="IoT">IoT</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                    <div id="job_requirements">
                        <div class="mb-3">
                            <label for="requirement_title_1" class="form-label">Requirement Title</label>
                            <input type="text" class="form-control" id="requirement_title_1" name="requirement_title[]">
                        </div>
                        <div class="mb-3">
                            <label for="requirement_description_1" class="form-label">Requirement Description</label>
                            <textarea class="form-control" id="requirement_description_1" name="requirement_description[]" rows="3"></textarea>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" onclick="addRequirement()">Add Requirement</button>

                    <button type="submit" class="btn btn-primary">Post Job</button>
                </form>
                <?php ErrorHandler::displayErrors($error_messages); ?>
                <?php ErrorHandler::displayErrors($result); ?>
            </div>
        </div>

        <?php require_once 'components/footer.php'; ?>
    </div>
    <?php require_once 'components/scripts.php'; ?>
    <script>
        var requirementCount = 1;

        function addRequirement() {
            requirementCount++;
            var requirementHTML = `
            <div class="mb-3">
                <label for="requirement_title_${requirementCount}" class="form-label">Requirement Title</label>
                <input type="text" class="form-control" id="requirement_title_${requirementCount}" name="requirement_title[]">
            </div>
            <div class="mb-3">
                <label for="requirement_description_${requirementCount}" class="form-label">Requirement Description</label>
                <textarea class="form-control" id="requirement_description_${requirementCount}" name="requirement_description[]" rows="3"></textarea>
            </div>
        `;
            document.getElementById('job_requirements').insertAdjacentHTML('beforeend', requirementHTML);
        }
    </script>
</body>

</html>