<?php
/*
|--------------------------------------------------------------------------
| Organization Companies Section
|--------------------------------------------------------------------------
*/

class organizationCompanies
{
    use CrudOperationsTrait;

    public function getCompanies()
    {
         $sql = "SELECT * FROM companies";
        return $this->executeQuery($sql);
    }
}
$organizationCompanies = new organizationCompanies();
$companies = $organizationCompanies->getCompanies();
?>

<div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <h1 class="text-center mb-5">Our Organization Companies</h1>
        <div class="owl-carousel testimonial-carousel">
            <?php if ($companies->num_rows > 0) : ?>
                <?php while ($company = $companies->fetch_assoc()) : ?>
                    <div class="testimonial-item bg-light rounded p-4 position-relative" style="height: 380px;">
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
                <?php endwhile; ?>
            <?php else : ?>
                <p>No companies found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
