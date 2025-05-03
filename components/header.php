<?php
/*
|--------------------------------------------------------------------------
| User Authentication and Navigation
|--------------------------------------------------------------------------
*/

$logged_in = isset($_SESSION['user_id']);
$link_url = $logged_in ? "profile.php" : "login.php";
$user_id = $logged_in ? $_SESSION['user_id'] : "";
$icon_class = $logged_in ? "bi bi-person-circle" : "bi bi-box-arrow-right";
$btn_text = $logged_in ? "profile" : "login";

/*
|--------------------------------------------------------------------------
| Header Navigation
|--------------------------------------------------------------------------
*/
?>

<!-- Header  -->
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary p-0">
        <div class="container">
            <?php
            $username = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;
            ?>
            <a class="navbar-brand fw-bold fs-5" href="#">Welcome <?php echo $username; ?></a>
            <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php
                    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'recruiter') { ?>
                        <li class="nav-item">
                            <a class="nav-link link-secondary fw-bold fs-6 py-2" href="post-job.php">Post a Job</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link-secondary fw-bold fs-6 py-2" href="./recruiter-posts.php">MY Posts</a>
                        </li>
                    <?php } ?>
                    <!-- <li class="nav-item">
                        <a class="nav-link link-secondary fw-bold fs-6 py-2" href="#"><i class="bi bi-chat-dots-fill"></i> Chats </a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link link-secondary fw-bold fs-6 py-2" href="#"></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-secondary fw-bold fs-6 py-2" href="./logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>