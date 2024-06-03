<?php
include('controller/PostJobController.php');
?>

<div class="tab-class text-center wow fadeInUp" data-wow-delay="0.3s">
    <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
        <li class="nav-item">
            <a class="d-flex align-items-center text-start mx-3 ms-0 pb-3 active" data-bs-toggle="pill" href="#tab-1">
                <h6 class="mt-n1 mb-0">All</h6>
            </a>
        </li>
        <li class="nav-item">
            <a class="d-flex align-items-center text-start mx-3 pb-3" data-bs-toggle="pill" href="#tab-2">
                <h6 class="mt-n1 mb-0">Full Time</h6>
            </a>
        </li>
        <li class="nav-item">
            <a class="d-flex align-items-center text-start mx-3 me-0 pb-3" data-bs-toggle="pill" href="#tab-3">
                <h6 class="mt-n1 mb-0">Part Time</h6>
            </a>
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
                            <div class="d-flex mb-3">
                                <a class="btn btn-primary btn-sm-hover" href="job-detail.php?jobId=<?php echo $result['id'] ?>">Apply Now</a>
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
        <!-- All Jobs -->
        <div class="tab-pane fade show active" id="tab-1">
            <?php displayJobs($results); ?>
        </div>
        <!-- Full Time Jobs -->
        <div class="tab-pane fade" id="tab-2">
            <?php
            // $fullTimeConditions = $conditions;
            $fullTimeConditions[] = "job.type = 'Full Time'";
            $fullTimeResults = $databaseOperations->getJobs('job_postings', ['companies:id'], $fullTimeConditions);
            displayJobs($fullTimeResults);
            ?>
        </div>
        <!-- Part Time Jobs -->
        <div class="tab-pane fade" id="tab-3">
            <?php
            // $partTimeConditions = $conditions;
            $partTimeConditions[] = "job.type = 'Part Time'";
            $partTimeResults = $databaseOperations->getJobs('job_postings', ['companies:id'], $partTimeConditions);
            displayJobs($partTimeResults);
            ?>
        </div>
    </div>
</div>
