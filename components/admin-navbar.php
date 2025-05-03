<!-- components/admin-navbar.php -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
  <div class="container-fluid">
    <!-- Logo or Brand -->
    <a class="navbar-brand fw-bold fs-4" href="dashboard.php">BOOM Admin</a>

    <!-- Toggler for mobile view -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar"
      aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar Links -->
    <div class="collapse navbar-collapse" id="adminNavbar">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="dashboard.php"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="dashboard-jobs.php"><i class="bi bi-briefcase me-1"></i>Jobs</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="dashboard-companies.php"><i class="bi bi-building me-1"></i>Companies</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="dashboard-exams.php"><i class="bi bi-pencil-square me-1"></i>Exams</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="dashboard-questions.php"><i class="bi bi-question-circle me-1"></i>Questions</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="dashboard-users.php"><i class="bi bi-people me-1"></i>Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="dashboard-admins.php"><i class="bi bi-person-check me-1"></i>Admins</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="dashboard-profile.php"><i class="bi bi-person-circle me-1"></i>My Account</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-1"></i>Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>