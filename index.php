<?php session_start();
require_once 'controller/HomeController.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Home</title>
    <?php require_once 'components/head.php'; ?>
</head>

<body>
    <div class="bg-white p-0">
        <!-- Spinner -->
        <?php require_once 'components/spinner.php'; ?>
        <!-- Navbar -->
        <?php require_once 'components/navbar.php'; ?>

        <!-- hero section -->
        <section class="hero">
            <div class="container">
                <div class="hero-content">
                    <h1>Find the Perfect Project That Matches Your Skills </h1>
                    <p>
                        BOOM platform connects talented developers with the best tech projects. Whether you're a beginner or professional, you'll find the right opportunity for you.
                    </p>
                    <div class="search-box">
                        <div class="search-filter">
                            <form action="job-list.php" method="GET" class="d-flex flex-wrap justify-content-start align-items-center gap-3">
                                <select name="category">
                                    <option value="">Specialization</option>
                                    <?php foreach ($data['categories'] as $cat): ?>
                                        <option value="<?= htmlspecialchars($cat['name']) ?>">
                                            <?= htmlspecialchars($cat['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="hidden" class="form-control border-0" name="keyword" />
                                <select name="location">
                                    <option value="">Location</option>
                                    <?php foreach ($data['locations'] as $location): ?>
                                        <option value="<?= htmlspecialchars($location) ?>">
                                            <?= htmlspecialchars($location) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="hidden" name="submit" value="1">
                                <button type="submit" class="btn btn-primary py-md-2 px-md-5 me-3 animated slideInLeft">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="hero-image">
                    <img src="https://dataisgood.com/wp-content/uploads/2023/02/image1-min.jpg" alt="Devolpers Working">
                </div>
            </div>
        </section>

        <section class="categories">
            <div class="container">
                <h2 class="section-title">Explore By Specialization</h2>
                <div class="categories-grid">
                    <?php foreach ($data['categories'] as $category): ?>
                        <a href="./category.php?category=<?= urlencode($category['name']) ?>" class="category-card">
                            <div class="category-icon">
                                <?php
                                // Icons based on category
                                if (strpos(strtolower($category['name']), 'web') !== false) {
                                    echo '<i class="fas fa-code"></i>';
                                } elseif (strpos(strtolower($category['name']), 'app') !== false) {
                                    echo '<i class="fas fa-mobile-alt"></i>';
                                } elseif (strpos(strtolower($category['name']), 'ai') !== false || strpos(strtolower($category['name']), 'intelligence') !== false) {
                                    echo '<i class="fas fa-brain"></i>';
                                } elseif (strpos(strtolower($category['name']), 'security') !== false) {
                                    echo '<i class="fas fa-shield-alt"></i>';
                                } else {
                                    echo '<i class="fas fa-briefcase"></i>';
                                }
                                ?>
                            </div>
                            <h3><?= htmlspecialchars($category['name']) ?></h3>
                            <p><?= $category['count'] ?> Projects Available</p>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- قسم المشاريع المتاحة -->
        <section class="projects">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Available jobs</h2>
                    <div class="filter-options" id="projectFilters">
                        <button class="filter-btn active" data-filter="all">All</button>
                        <button class="filter-btn" data-filter="full-time">Full-time</button>
                        <button class="filter-btn" data-filter="part-time">Part-time</button>
                        <button class="filter-btn" data-filter="remote">Remote</button>
                    </div>
                </div>

                <div class="projects-grid" id="projectsContainer">
                    <?php while ($job = $data['jobs']->fetch_assoc()): ?>
                        <div class="project-card <?= strtolower(str_replace(' ', '-', $job['type'])) ?>" data-type="<?= strtolower($job['type']) ?>">
                            <div class="project-header">
                                <div class="project-badge">Featured</div>
                                <h3><?= htmlspecialchars($job['title']) ?></h3>
                            </div>
                            <div class="project-details">
                                <p><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($job['location'] ?? 'N/A') ?></p>
                                <p><i class="fas fa-briefcase"></i> <?= htmlspecialchars($job['type']) ?></p>
                                <p><i class="fas fa-dollar-sign"></i> <?= htmlspecialchars($job['salary'] ?? 'Negotiable') ?></p>
                                <p><i class="fas fa-star"></i>Required Level: Intermediate</p>
                            </div>
                            <a href="job-detail.php?jobId=<?= $job['id'] ?>" class="btn btn-primary">Apply Now</a>
                        </div>
                    <?php endwhile; ?>
                </div>

                <div class="view-more">
                    <a href="job-list.php" class="btn btn-primary py-md-2 px-md-5 me-3 animated slideInLeft">View More</a>
                </div>
            </div>
        </section>

        <section class="testimonials">
            <div class="container">
                <h2 class="section-title">What Our Clients Say</h2>
                <div class="testimonials-grid">

                    <div class="testimonial-card">
                        <div class="quote-icon">
                            <i class="fas fa-quote-right"></i>
                        </div>
                        <p class="testimonial-text">
                            "Thanks to Boom, I was able to land my first role as a frontend developer in less than a month!"
                        </p>
                        <div class="client-info">
                            <div class="client-name">Zeinab Youssef</div>
                            <div class="client-position">Junior Frontend Developer</div>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <div class="quote-icon">
                            <i class="fas fa-quote-right"></i>
                        </div>
                        <p class="testimonial-text">
                            "Boom gave me access to a pool of experienced developers I could trust to build my product fast."
                        </p>
                        <div class="client-info">
                            <div class="client-name">Mohamed Nabil</div>
                            <div class="client-position">Founder at TechStart</div>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <div class="quote-icon">
                            <i class="fas fa-quote-right"></i>
                        </div>
                        <p class="testimonial-text">
                            "I loved how the site matched me with jobs that fit my exact skills and career goals in AI."
                        </p>
                        <div class="client-info">
                            <div class="client-name">Rana El Sayed</div>
                            <div class="client-position">Machine Learning Engineer</div>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <div class="quote-icon">
                            <i class="fas fa-quote-right"></i>
                        </div>
                        <p class="testimonial-text">
                            "Easy to use, smart job suggestions, and a huge advantage for anyone seeking Boom remotely."
                        </p>
                        <div class="client-info">
                            <div class="client-name">Hassan Tarek</div>
                            <div class="client-position">Remote Software Engineer</div>
                        </div>
                    </div>

                </div>
            </div>
        </section>


        <section class="cta bg-light m-0 p-0">
            <div class="container py-5">
                <h2>Ready to Get Started?</h2>
                <p>Register now and begin your journey in professional programming</p>
                <div class="cta-buttons d-flex flex-wrap justify-content-center">
                    <a href="#" class="btn btn-primary py-md-2 px-md-5 me-3 animated slideInLeft">Register as Developer</a>
                    <a href="#" class="btn btn-outline-primary btn-sm-hover border border-primary border-2  py-md-2 px-md-5 me-3 animated slideInLeft" style="max-width: fit-content; color: #26577d !important;">Register as Client</a>
                </div>
            </div>
        </section>

        <?php require_once 'components/footer.php'; ?>
    </div>
    <?php require_once 'components/scripts.php'; ?>

    <!-- Filter Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filters = document.querySelectorAll('.filter-btn');
            const projects = document.querySelectorAll('.project-card');

            filters.forEach(filter => {
                filter.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filters.forEach(btn => btn.classList.remove('active'));
                    // Add active class to clicked button
                    this.classList.add('active');

                    const filterType = this.getAttribute('data-filter');

                    projects.forEach(project => {
                        if (filterType === 'all' || project.classList.contains(filterType)) {
                            project.style.display = 'block';
                        } else {
                            project.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>