<?php
session_start();
include("controller/PostJobController.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Job</title>
    <?php require_once 'components/head.php'; ?>
</head>

<body>
    <div class="bg-white p-0">
        <!-- Spinner -->
        <?php require_once 'components/spinner.php'; ?>
        <!-- Navbar -->
        <?php require_once 'components/navbar.php'; ?>

        <!-- Edit Job -->
        <div class="container-xxl py-5">
            <div class="container">
                <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">Edit Job</h1>
                <div class="rounded-circle border border-primary border-2 m-auto" style="width:170px; height:170px">
                    <img src="<?php echo $jobData['image']; ?>" alt="" class="w-100 h-100 m-auto rounded-circle p-2">
                </div>
                <form method="post" action="modify-post.php" class="body-form w-100" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input type="hidden" class="form-control" name="id" value="<?php echo $jobData['id']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Job Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo $jobData['title']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Job Description</label>
                        <textarea class="form-control" id="description" name="description" rows="5"><?php echo $jobData['description']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="salary" class="form-label">Salary</label>
                        <input type="number" class="form-control" id="salary" name="salary" value="<?php echo $jobData['salary']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Job Type</label>
                        <select class="form-select" id="type" name="type">
                            <option value="full time" <?php if ($jobData['type'] == 'full time') echo 'selected'; ?>>Full Time</option>
                            <option value="part time" <?php if ($jobData['type'] == 'part time') echo 'selected'; ?>>Part Time</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Job Category</label>
                        <select class="form-select" id="category" name="category">
                            <option value="Web Development" <?php if ($jobData['category'] == 'Web Development') echo 'selected'; ?>>Web Development</option>
                            <option value="UI/UX Design" <?php if ($jobData['category'] == 'UI/UX Design') echo 'selected'; ?>>UI/UX Design</option>
                            <option value="App Development" <?php if ($jobData['category'] == 'App Development') echo 'selected'; ?>>App Development</option>
                            <option value="Software Development" <?php if ($jobData['category'] == 'Software Development') echo 'selected'; ?>>Software Development</option>
                            <option value="Database Administration" <?php if ($jobData['category'] == 'Database Administration') echo 'selected'; ?>>Database Administration</option>
                            <option value="Network Engineering" <?php if ($jobData['category'] == 'Network Engineering') echo 'selected'; ?>>Network Engineering</option>
                            <option value="Embedded Systems" <?php if ($jobData['category'] == 'Embedded Systems') echo 'selected'; ?>>Embedded Systems</option>
                            <option value="IoT" <?php if ($jobData['category'] == 'IoT') echo 'selected'; ?>>IoT</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                    <div id="job_requirements">
                        <?php
                        if (!empty($jobData['job_requirement_title'])) {
                            $requirementTitles = explode(",", $jobData['job_requirement_title']);
                            $requirementDescriptions = explode(",", $jobData['job_requirement_description']);

                            foreach ($requirementTitles as $key => $title) {
                                echo '<div class="mb-3">';
                                echo '<label for="requirement_title_' . $key . '" class="form-label">Requirement Title</label>';
                                echo '<input type="text" class="form-control" id="requirement_title_' . $key . '" name="requirement_title[]" value="' . $title . '">';
                                echo '</div>';
                                echo '<div class="mb-3">';
                                echo '<label for="requirement_description_' . $key . '" class="form-label">Requirement Description</label>';
                                echo '<textarea class="form-control" id="requirement_description_' . $key . '" name="requirement_description[]" rows="3">' . $requirementDescriptions[$key] . '</textarea>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>


                    <div class="d-flex gap-2 flex-wrap justify-content-evenly justify-content-md-start">
                        <button type="button" class="btn btn-secondary " onclick="addRequirement()">Add Requirement</button>
                        <button type="submit" class="btn btn-primary ">Save Changes</button>
                    </div>
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