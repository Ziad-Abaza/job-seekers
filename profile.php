<?php
session_start();
require_once 'database/config.php';
require_once 'Traits/ValidatorTrait.php';
require_once 'Traits/CrudOperationsTrait.php';

class DatabaseOperations
{
    use CrudOperationsTrait;

    private $connection;

    public function __construct($conn)
    {
        $this->connection = $conn;
    }

    public function getUserDetails($user_id)
    {
        $sql = "SELECT users.*, user_details.*, GROUP_CONCAT(social_links.name) AS social_links_names, GROUP_CONCAT(social_links.url) AS social_links_urls
                FROM users
                LEFT JOIN user_details ON users.user_details_id = user_details.id
                LEFT JOIN social_links ON users.id = social_links.user_id
                WHERE users.id = ?";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $userDetails = $result->fetch_assoc();

        if ($userDetails) {
            $social_links_names = explode(",", $userDetails['social_links_names']);
            $social_links_urls = explode(",", $userDetails['social_links_urls']);
            $social_links = array();
            for ($i = 0; $i < count($social_links_names); $i++) {
                $social_links[] = array(
                    'name' => $social_links_names[$i],
                    'url' => $social_links_urls[$i]
                );
            }

            $userDetails['social_links'] = $social_links;

            return $userDetails;
        } else {
            return false;
        }
    }

    public function findCompanyById($id)
    {
        $sql = "SELECT companies.*, 
                GROUP_CONCAT(DISTINCT job_postings.title SEPARATOR '<br>') AS job_titles,
                GROUP_CONCAT(DISTINCT job_postings.id SEPARATOR '<br>') AS job_ids
                FROM companies
                LEFT JOIN job_postings ON companies.id = job_postings.company_id
                WHERE companies.user_id IN (
                    SELECT companies.user_id FROM companies WHERE companies.user_id = $id
                )
                GROUP BY companies.id";

        return $this->executeQuery($sql);
    }
}

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
} elseif (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
} else {
    header('location: index.php');
    exit;
}

$databaseOperations = new DatabaseOperations($conn);

$userDetails = $databaseOperations->getUserDetails($userId);
$companyData = $databaseOperations->findCompanyById($userId);
?>
<!--
|--------------------------------------------------------------------------
| Profile Page
|--------------------------------------------------------------------------
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Profile</title>
    <?php require_once 'components/head.php'; ?>
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner -->
        <?php require_once 'components/spinner.php'; ?>
        <!-- Navbar -->
        <?php require_once 'components/navbar.php'; ?>

        <!-- Contact -->
        <div class="container-xxl py-5">
            <div class="container">
                <?php if ($userDetails) : ?>
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="col-12">
                                <div class="col-12">
                                    <div class="d-flex flex-column flex-md-row align-items-md-center mb-5">
                                        <?php if (isset($userDetails['image'])) : ?>
                                            <img class="flex-shrink-0 img-fluid border rounded mb-3 mb-md-0 me-md-4" src="<?php echo $userDetails['image']; ?>" alt="" style="width: 80px; height: 80px;">
                                        <?php endif; ?>
                                        <div class="text-start">
                                            <?php if (isset($userDetails['name'])) : ?>
                                                <h3 class="mb-3"><?php echo $userDetails['name']; ?></h3>
                                            <?php endif; ?>
                                            <?php if (isset($userDetails['location'])) : ?>
                                                <span class="d-block text-truncate mb-2" style="font-size: 14px;"><i class="fa fa-map-marker-alt text-primary me-2"></i><?php echo $userDetails['location']; ?></span>
                                            <?php endif; ?>
                                            <?php if (isset($userDetails['email'])) : ?>
                                                <span class="d-block text-truncate mb-2" style="font-size: 14px;"><i class="far fa-envelope fs-6 text-primary me-2"></i><?php echo $userDetails['email']; ?></span>
                                            <?php endif; ?>
                                            <?php if (isset($userDetails['specialization'])) : ?>
                                                <span class="d-block text-truncate mb-2" style="font-size: 14px;"><i class="fa fa-certificate text-primary me-2"></i><?php echo $userDetails['specialization']; ?></span>
                                            <?php endif; ?>
                                            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $userId) : ?>
                                                <a href="edit-profile.php" class="btn btn-primary btn-sm mt-2">Edit Profile</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row gy-4">
                                    <?php if (isset($userDetails['location'])) : ?>
                                        <div class="col-md-4 wow fadeIn" data-wow-delay="0.1s">
                                            <div class="d-flex align-items-center bg-light rounded p-4">
                                                <div class="bg-white border rounded d-flex flex-shrink-0 align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                                    <i class="fa fa-map-marker-alt text-primary"></i>
                                                </div>
                                                <div>
                                                    <h5 class="mb-0">Location</h5>
                                                    <span><?php echo $userDetails['location']; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (isset($userDetails['email'])) : ?>
                                        <div class="col-md-4 wow fadeIn" data-wow-delay="0.1s">
                                            <a href="mailto:<?php echo $userDetails['email']; ?>" class="text-decoration-none">
                                                <div class="d-flex align-items-center bg-light rounded p-4">
                                                    <div class="bg-white border rounded d-flex flex-shrink-0 align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                                        <i class="far fa-envelope text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="mb-0">Email</h5>
                                                        <span>Send Message<span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (isset($userDetails['phone'])) : ?>
                                        <div class="col-md-4 wow fadeIn" data-wow-delay="0.3s">
                                            <a href="tel:<?php echo $userDetails['phone']; ?>" class="text-decoration-none">
                                                <div class="d-flex align-items-center bg-light rounded p-4">
                                                    <div class="bg-white border rounded d-flex flex-shrink-0 align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                                        <i class="fa fa-phone-alt text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="mb-0">Phone</h5>
                                                        <span><?php echo $userDetails['phone']; ?></span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="row w-100 justify-content-between mt-5" style="margin:auto;">
                                    <?php if (isset($userDetails['social_links'])) : ?>
                                        <div class="section col-md-4 col-12 mt-2">
                                            <h3 class="section-title ps-3">Social Links</h3>
                                            <div class="row gy-4">
                                                <div class="col-md-12 p-3">
                                                    <div class="social-link bg-light rounded p-4 d-flex align-items-center justify-content-evenly shadow rounded-5 " style="min-height:120px; height:fit-content;">
                                                        <?php foreach ($userDetails['social_links'] as $link) : ?>
                                                            <a href="<?php echo $link['url']; ?>" target="_blank" class="text-decoration-none">
                                                                <i class="bi bi-<?php echo $link['name']; ?> text-primary me-3 fs-1 "></i>
                                                            </a>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php if (isset($userDetails['cv'])) : ?>
                                            <div class="section col-md-4 col-12 mt-2">
                                                <h3 class="section-title ps-3">Download CV</h3>
                                                <div class="row gy-4">
                                                    <div class="col-md-12 p-3">
                                                        <div class="cv-download bg-light rounded p-4 d-flex align-items-center shadow rounded-5 " style="min-height:120px; height:fit-content;">
                                                            <i class="fa fa-file-download text-primary me-3"></i>
                                                            <a href="<?php echo $userDetails['cv']; ?>" class="btn btn-primary btn-sm">Download</a>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                </div>
                                            </div>
                                            <?php if (isset($userDetails['specialization'])) : ?>
                                                <div class="section col-md-4 col-12 mt-2">
                                                    <h3 class="section-title ps-3">Specialization</h3>
                                                    <div class="row gy-4">
                                                        <div class="col-md-12 p-3">
                                                            <div class="specialization bg-light rounded p-4 d-flex align-items-center shadow rounded-5 " style="min-height:120px; height:fit-content;">
                                                                <i class="fa fa-certificate text-primary me-3"></i>
                                                                <h5><?php echo $userDetails['specialization']; ?></h5>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                    </div>
                                                </div>
                                </div>
                            </div>
                            <?php
                            if ($userDetails['role'] === 'recruiter') {
                                echo '<h4 class="mt-4 mb-3">companies</h4>';
                                foreach ($companyData as $company) {

                                    $companyName = explode("<br>", $company['name']);
                                    $companyID = explode("<br>", $company['id']);

                                    if (empty($companyName[0])) {
                                        // echo '<p>No jobs posted.</p>';
                                    } else {
                                        foreach ($companyName as $key => $name) {
                                            echo '<div class="job-item p-2 mb-4">
                                                        <div class="row g-4 justify-content-between">
                                                            <div class="col-sm-12 col-md-6 d-flex align-items-center">
                                                                <div class="text-start ps-4">
                                                                    <h5 class="mb-3">' . $name . '</h5>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                                                <div class="d-flex mb-3 gap-2">
                                                                    <a class="btn btn-danger btn-sm-hover" href="modify-company.php?delete=' . $companyID[$key] . '">Delete</a>
                                                                    <a class="btn btn-primary btn-sm-hover" href="modify-company.php?companyId=' . $companyID[$key] . '">Modify</a>
                                                                    <a class="btn btn-primary btn-sm-hover" href="company-detail.php?companyId=' . $companyID[$key] . '">View</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>';
                                        }
                                    }
                                }
                            }
                            ?>
                            <?php
                            if ($userDetails['role'] === 'recruiter') {
                                echo '<h4 class="mt-4 mb-3">Jobs Posted</h4>';
                                foreach ($companyData as $company) {

                                    $job_titles = explode("<br>", $company['job_titles']);
                                    $job_ids = explode("<br>", $company['job_ids']);

                                    if (empty($job_titles[0])) {
                                        echo '<p>No jobs posted.</p>';
                                    } else {
                                        foreach ($job_titles as $key => $title) {
                                            echo '<div class="job-item p-2 mb-4">
                                                    <div class="row g-4 justify-content-between">
                                                        <div class="col-sm-12 col-md-6 d-flex align-items-center">
                                                            <div class="text-start ps-4">
                                                                <h5 class="mb-3">' . $title . '</h5>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                                            <div class="d-flex mb-3 gap-2">
                                                                <a class="btn btn-danger btn-sm-hover" href="modify-post.php?delete=' . $job_ids[$key] . '">Delete</a>
                                                                <a class="btn btn-primary btn-sm-hover" href="modify-post.php?jobId=' . $job_ids[$key] . '">Modify</a>
                                                                <a class="btn btn-primary btn-sm-hover" href="job-detail.php?jobId=' . $job_ids[$key] . '">View</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>';
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
            </div>

        </div>
    <?php endif; ?>
    <!-- footer -->
    <?php require_once 'components/footer.php'; ?>
    </div>
    <!-- script -->
    <?php require_once 'components/scripts.php'; ?>
</body>

</html>