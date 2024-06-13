<?php
include(__DIR__ . '/../controller/PostJobController.php');

// Fetch all jobs
$allJobs = $databaseOperations->getJobs('job_postings', ['companies:id']);
$fullTimeJobs = $databaseOperations->getJobs('job_postings', ['companies:id'], ["job.type = 'Full Time'"]);
$partTimeJobs = $databaseOperations->getJobs('job_postings', ['companies:id'], ["job.type = 'Part Time'"]);

?>

<div class="container">
    <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.3s">
        <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="pill" href="#tab-1">All</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="pill" href="#tab-2">Full Time</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="pill" href="#tab-3">Part Time</a>
            </li>
        </ul>
        <?php
        function displayJobs($results)
        {
            if (!empty($results)) {
                foreach ($results as $result) : ?>
                    <div class="job-item p-4 mb-4">
                        <div class="row g-4">
                            <div class="col-sm-12 col-md-8 d-flex align-items-center">
                                <img class="flex-shrink-0 img-fluid border rounded" src="<?php echo $result['image']; ?>" alt="" style="width: 80px; height: 80px;">
                                <div class="text-start ps-4">
                                    <h5 class="mb-3"><?php echo $result['title']; ?></h5>
                                    <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i><?php echo $result['location']; ?></span>
                                    <span class="text-truncate me-3"><i class="far fa-clock text-primary me-2"></i><?php echo $result['type']; ?></span>
                                    <span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i><?php echo $result['salary']; ?></span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                <div class="d-flex mb-3 gap-2">
                                    <a class="btn btn-primary btn-sm-hover" href="job-detail.php?jobId=<?php echo $result['id'] ?>">Show</a>
                                    <button class="btn btn-danger btn-sm" onclick="deleteJob(<?php echo htmlspecialchars($result['id']); ?>)">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </div>
                                <small class="text-truncate"><i class="far fa-calendar-alt text-primary me-2"></i><?php echo $result['created_at']; ?></small>
                            </div>
                        </div>
                    </div>
        <?php endforeach;
            } else {
                echo "No jobs found!";
            }
        }
        ?>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="tab-1">
                <?php displayJobs($allJobs); ?>
            </div>
            <div class="tab-pane fade" id="tab-2">
                <?php displayJobs($fullTimeJobs); ?>
            </div>
            <div class="tab-pane fade" id="tab-3">
                <?php displayJobs($partTimeJobs); ?>
            </div>
        </div>
    </div>
</div>