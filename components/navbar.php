<?php
// session_start();
$logged_in = isset($_SESSION['user_id']);
$link_url = $logged_in ? "profile.php" : "login.php";
$user_id = $logged_in ? $_SESSION['user_id'] : "";
$icon_class = $logged_in ? "bi bi-person-circle" : "bi bi-box-arrow-right";
$btn_text = $logged_in ? "profile" : "login";
?>

<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="index.php" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
        <h1 class="m-0 text-primary">Boom</h1>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="index.php" class="nav-item nav-link">Home</a>
            <a href="about.php" class="nav-item nav-link">About</a>
            <a href="job-list.php" class="nav-item nav-link">Job List</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Job Category</a>
                <div class="dropdown-menu rounded-0 m-0">
                    <a href="category.php?category=Web Development" class="dropdown-item">Web Development</a>
                    <a href="category.php?category=UI/UX Design" class="dropdown-item">UI/UX Design</a>
                    <a href="category.php?category=App Development" class="dropdown-item">App Development</a>
                    <a href="category.php?category=Software Development" class="dropdown-item">Software Development</a>
                    <a href="category.php?category=Database Administration" class="dropdown-item">Database Administration</a>
                    <a href="category.php?category=Network Engineering" class="dropdown-item">Network Engineering</a>
                    <a href="category.php?category=Embedded Systems" class="dropdown-item">Embedded Systems</a>
                    <a href="category.php?category=IoT" class="dropdown-item">IoT</a>
                </div>
            </div>
            <a href="contact.php" class="nav-item nav-link">Contact</a>
        </div>
        <a href="<?php echo $link_url; ?>" class="btn btn-primary rounded-0 py-3 px-lg-5 d-none d-lg-block btn-hover fs-4"><?php echo $btn_text; ?><i class="<?php echo $icon_class; ?> ms-3 "></i></a>
    </div>
</nav>

<!-- Script to activate current link -->
<script>
    const currentLocation = window.location.href;
    document.querySelectorAll('.navbar-nav a.nav-link').forEach(link => {
        if (link.href === currentLocation) {
            link.classList.add('active');
        }
    });
</script>
<?php if (isset($_SESSION['user_id'])) {
    require_once "header.php";
}
?>