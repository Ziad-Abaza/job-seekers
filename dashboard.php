<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <?php require_once 'components/head.php'; ?>
</head>
<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner -->
        <?php require_once 'components/spinner.php'; ?>
        <!-- Navbar -->
        <?php require_once 'components/navbar.php'; ?>

        <div class="row mx-0">
            <!-- Sidebar -->
            <nav class="col-md-2  d-block dashboard-sidebar">
                <div class="sidebar-sticky">
                    <h5 class="sidebar-heading text-secondary text-center pt-3">Dashboard</h5>
                    <ul class="nav flex-column" id="sidebar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="loadContent('Dashboard/users.php', this)">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="loadContent('Dashboard/job-list.php', this)">Jobs List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="loadContent('Dashboard/companies.php', this)">Companies</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="loadContent('Dashboard/permissions.php', this)">Permissions</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4 main-content" style="min-height: 100vh;" id="main-content">
                <div class="dashboard-header">Welcome to the Dashboard</div>
            </main>
        </div>

        <?php require_once 'components/footer.php'; ?>
    </div>
    <?php require_once 'components/scripts.php'; ?>

    <!-- Custom JS to load content dynamically -->
    <script src="js/dashboard.js"></script>
</body>
</html>
