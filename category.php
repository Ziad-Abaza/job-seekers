<?php
session_start();
require_once 'database/config.php';
require_once 'Traits/CrudOperationsTrait.php';

class organizationCompanies
{
    use CrudOperationsTrait;
    public function getCompaniesByCategory($category)
    {
        $sql = "SELECT * FROM companies WHERE category = ?";
        $stmt = $this->connection->prepare($sql);

        if (!$stmt) {
            die("Error in SQL statement: " . $this->connection->error);
        }
        $stmt->bind_param("s", $category);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
}

$organizationCompanies = new organizationCompanies();

$category = $_GET['category'] ?? null;

if ($category) {
    $companies = $organizationCompanies->getCompaniesByCategory($category);
} else {
    header('location:index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Category</title>
    <?php require_once 'components/head.php'; ?>
</head>

<body>
    <div class="bg-white p-0">
        <!-- Spinner Start -->
        <?php require_once 'components/spinner.php'; ?>
        <!-- Navbar Start -->
        <?php require_once 'components/navbar.php'; ?>

        <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container">
                <h1 class="text-center mb-5">Companies</h1>
                <?php if ($companies->num_rows > 0) : ?>
                    <?php while ($company = $companies->fetch_assoc()) : ?>
                        <div class="d-flex align-items-center justify-content-evenly flex-wrap gap-1">
                            <div class="testimonial-item col-lg-4 col-md-6 mb-4 bg-light rounded p-4 position-relative" style="height: 380px;">
                                <div class="d-flex align-items-center" style="width: 100%; height: 40%;">
                                    <img class="img-fluid flex-shrink-0 rounded w-100 h-100" src="<?php echo $company['image']; ?>">
                                </div>
                                <div class="py-3">
                                    <h5 class="mb-1"><?php echo $company['name']; ?></h5>
                                    <small><?php echo $company['category']; ?></small>
                                </div>
                                <p style="max-height: 69px !important; overflow: hidden;"><?php echo $company['description']; ?></p>
                                <div class="position-absolute bottom-0 start-50 translate-middle-x p-2 w-100">
                                    <a class="btn btn-primary btn-sm-hover btn-testimonial" href="company-detail.php?companyId=<?php echo $company['id'] ?>">View</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p>No companies found.</p>
                <?php endif; ?>
            </div>
        </div>
        <!-- Footer Start -->
        <?php require_once 'components/footer.php'; ?>
    </div>
    <?php require_once 'components/scripts.php'; ?>
</body>

</html>