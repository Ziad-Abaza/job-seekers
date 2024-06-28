<?php
session_start();
include("controller/DetailsController.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'components/head.php'; ?>
    <title>Jobs Details</title>

</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner -->
        <?php require_once 'components/spinner.php'; ?>
        <!-- Navbar -->
        <?php require_once 'components/navbar.php'; ?>

        <!-- Job Detail -->
        <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container">
                <div class="row gy-5 gx-4">
                    <div class="col-lg-8">
                        <?php if (isset($jobData)) : ?>
                        <?php foreach ($jobData as $job) : ?>
                        <div class="d-flex align-items-center mb-5">
                            <img class="flex-shrink-0 img-fluid border rounded" src="<?php echo $job['image']; ?>"
                                alt="" style="width: 80px; height: 80px;">
                            <div class="text-start ps-4">
                                <h3 class="mb-3"><?php echo $job['title']; ?></h3>
                                <span class="text-truncate me-3"><i
                                        class="fa fa-map-marker-alt text-primary me-2"></i><?php echo $job['company_location']; ?></span>
                                <span class="text-truncate me-3"><i
                                        class="far fa-clock text-primary me-2"></i><?php echo $job['type']; ?></span>
                                <span class="text-truncate me-0"><i
                                        class="far fa-money-bill-alt text-primary me-2"></i>$<?php echo $job['salary']; ?></span>
                            </div>
                        </div>

                        <div class="mb-5">
                            <h4 class="mb-3">Job Description</h4>
                            <p><?php echo $job['description']; ?></p>
                            <h4 class="mb-3">Job Requirements</h4>
                            <?php if (!empty($job['job_requirement_title'])) : ?>
                            <?php foreach ($jobData as $requirement) : ?>
                            <p class="fw-bold fs-5 text-primary"><?php echo $requirement['job_requirement_title']; ?>
                            </p>
                            <p><?php echo $requirement['job_requirement_description']; ?></p>
                            <?php endforeach; ?>
                            <?php else : ?>
                            <p>No job requirements found.</p>
                            <?php endif; ?>
                        </div>

                        <!-- Comment Section -->
                        <div class="mb-5">
                            <h3 class="mb-3">Comments</h3>
                            <button class="btn btn-primary"
                                onclick="openCommentModal(<?php echo $job['id']; ?>)">Show</button>
                        </div>

                        <!-- comments Modal -->
                        <div class="modal" id="jobDetailsModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Comments</h4>
                                        <button type="button" class="close btn btn-outline-primary"
                                            data-bs-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <?php foreach ($comments as $comment) : ?>
                                        <div class="mb-3">
                                            <div class="comment d-flex gap-1">
                                                <p class="comment-user text-primary">
                                                    <em><?php echo $comment['user_name']; ?>:</em></p>
                                                <p class="comment-content">
                                                    <strong><?php echo $comment['content']; ?></strong></p>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="modal-footer d-block">
                                        <?php if (isset($_SESSION['user_id'])) { ?>
                                        <?php if (isset($_SESSION['user_status']) && $_SESSION['user_status'] == 1) { ?>
                                        <!-- Comment Form -->
                                        <form id="commentForm">
                                            <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                                            <div class="mb-3">
                                                <label for="comment" class="form-label">Add a Comment</label>
                                                <textarea class="form-control" id="comment" name="comment" rows="3"
                                                    required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>
                                        <?php } else { ?>
                                        <div class="container mt-4">
                                            <div class="row justify-content-center">
                                                <div class="col-md-8">
                                                    <div class="alert alert-warning text-center" role="alert">
                                                        <strong>Attention!</strong> You need to activate your account
                                                        first to add a comment.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <?php } else { ?>
                                        <p class="text-muted">You must login to add a comment.</p>
                                        <?php } ?>
                                    </div>
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php else : ?>
                        <p>No job data found.</p>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-4">
                        <div class="bg-light rounded p-5 mb-4 wow slideInUp" data-wow-delay="0.1s">
                            <h4 class="mb-4">Company Detail</h4>
                            <img class="flex-shrink-0 img-fluid border rounded mb-2"
                                src="<?php echo $job['company_image']; ?>" alt="" style="width: 80px; height: 80px;">
                            <br>
                            <a class="m-0" href="company-detail.php?companyId=<?php echo $job['company_id']; ?>"><span
                                    class="fw-bold text-primary">Name:</span> <?php echo $job['company_name']; ?></a>
                            <p class="m-0"><span class="fw-bold text-primary">Company Description:</span>
                                <?php echo $job['company_description']; ?></p>
                            <p class="m-0"><span class="fw-bold text-primary">Company Location:</span>
                                <?php echo $job['company_location']; ?></p>
                            <p class="m-0"><span class="fw-bold text-primary">Company Field:</span>
                                <?php echo $job['company_category']; ?></p>
                        </div>
                    </div>
                </div>
                <!-- Company Registration Form -->
                <?php if (isset($user_details) && $user_details['role'] !== 'recruiter') {
                    require "components/application-form.php";
                } ?>
                <!-- Company Applying -->
                <?php if (isset($userId) && $userId == $jobDataArray['user_id']) {
                    require "components/apply-details.php";
                } ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require_once 'components/footer.php'; ?>

    <!-- Script -->
    <?php require_once 'components/scripts.php'; ?>
</body>

</html>
<script src="js/comments.js"></script>