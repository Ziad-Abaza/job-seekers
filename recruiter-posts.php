<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

include("database/config.php");
include("Traits/CrudOperationsTrait.php");
include("controller/ErrorHandlerController.php");

class DatabaseOperations
{
    use CrudOperationsTrait;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getJobs($table, $userID)
    {
        $sql = "SELECT * FROM $table WHERE user_id = $userID";
        return $this->executeQuery($sql);
    }
}

$databaseOperations = new DatabaseOperations($conn);
$error_messages = [];

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
}

$results = $databaseOperations->getJobs("job_postings", $userId);

if (!$results) {
    $error_messages['error fetch'] = "Failed to fetch job postings.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Posts</title>
    <?php require_once 'components/head.php'; ?>
</head>

<body>
    <div class=" bg-white p-0">
        <!-- Spinner Start -->
        <?php require_once 'components/spinner.php'; ?>
        <!-- Navbar Start -->
        <?php require_once 'components/navbar.php'; ?>

        <!-- Contact Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">My Posts</h1>
                <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.3s">
                    <?php
                    if (empty($results)) {
                        echo "<p>No job found.</p>";
                    }
                    foreach ($results as $result) : ?>
                        <div class="job-item p-4 mb-4">
                            <div class="row g-4">
                                <div class="col-sm-12 col-md-8 d-flex align-items-center">
                                    <img class="flex-shrink-0 img-fluid border rounded" src="<?php echo $result['image']; ?>" alt="" style="width: 80px; height: 80px;">
                                    <div class="text-start ps-4">
                                        <h5 class="mb-3"><?php echo $result['title']; ?></h5>
                                        <span class="text-truncate me-3"><i class="far fa-clock text-primary me-2"></i><?php echo $result['type']; ?></span>
                                        <span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i><?php echo $result['salary']; ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                    <div class="d-flex mb-3 gap-2 ">
                                        <a class="btn btn-danger btn-sm-hover" href="modify-post.php?delete=<?php echo $result['id'] ?>">Delete</a>
                                        <a class="btn btn-primary btn-sm-hover" href="modify-post.php?jobId=<?php echo $result['id'] ?>">Modify</a>
                                        <a class="btn btn-primary btn-sm-hover" href="job-detail.php?jobId=<?php echo $result['id'] ?>">View</a>
                                    </div>
                                    <small class="text-truncate"><i class="far fa-calendar-alt text-primary me-2"></i><?php echo $result['created_at']; ?></small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php ErrorHandler::displayErrors($error_messages); ?>
            </div>
        </div>
        <?php require_once 'components/footer.php'; ?>
    </div>
    <?php require_once 'components/scripts.php'; ?>
</body>

</html>
