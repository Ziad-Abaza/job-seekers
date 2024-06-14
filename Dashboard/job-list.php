<div class="container">
    <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.3s">
        <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5" style="margin-top: 20px;">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="pill" href="#tab-1" onclick="fetchItems('job_postings', updateJobsUI)">All</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="pill" href="#tab-2" onclick="fetchItems('job_postings', updateJobsUI)">Full Time</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="pill" href="#tab-3" onclick="fetchItems('job_postings', updateJobsUI)">Part Time</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="tab-1" style="height: 100vh; overflow-y: auto;">
                <div id="all-jobs"></div>
            </div>
            <div class="tab-pane fade" id="tab-2" style="height: 100vh; overflow-y: auto;">
                <div id="full-time-jobs"></div>
            </div>
            <div class="tab-pane fade" id="tab-3" style="height: 100vh; overflow-y: auto;">
                <div id="part-time-jobs"></div>
            </div>
        </div>
    </div>
</div>