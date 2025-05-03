<?php
session_start();
include("controller/ProfileController.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Profile - <?= htmlspecialchars($userDetails['name'] ?? 'User') ?></title>
    <?php require_once 'components/head.php'; ?>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
            color: #1e293b;
        }

        .account-section {
            padding: 100px 20px;
            max-width: 1200px;
            margin: auto;
        }

        .account-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .account-header h1 {
            font-size: 2.4rem;
            color: #26577c;
            margin-bottom: 10px;
        }

        .account-header p {
            color: #64748b;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .account-content {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 30px;
        }

        .profile-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .profile-pic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 20px;
            border: 4px solid #f0f4ff;
        }

        .profile-name {
            font-size: 1.4rem;
            font-weight: 600;
            margin: 0 0 5px 0;
        }

        .profile-title {
            color: #4361ee;
            font-size: 0.9rem;
            margin: 0 0 20px 0;
            background-color: #f0f4ff;
            padding: 5px 10px;
            border-radius: 20px;
            display: inline-block;
        }

        .profile-location {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .profile-stats {
            display: flex;
            justify-content: space-around;
            margin-top: 25px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-size: 1.2rem;
            font-weight: 600;
            margin: 0;
        }

        .stat-label {
            font-size: 0.8rem;
            color: #94a3b8;
            margin: 5px 0 0 0;
        }

        .details-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #26577c;
            margin: 0 0 25px 0;
            padding-bottom: 10px;
            border-bottom: 1px solid #e2e8f0;
        }

        .info-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px 0;
        }

        .info-col {
            width: 48%;
            margin-bottom: 20px;
        }

        .info-label {
            font-size: 0.9rem;
            color: #64748b;
            display: block;
        }

        .info-value {
            font-size: 1rem;
            font-weight: 500;
            margin: 0;
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .social-icon {
            font-size: 1.5rem;
            color: #4361ee;
            transition: color 0.3s;
        }

        .social-icon:hover {
            color: #26577c;
        }

        .skills-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        .skill-tag {
            background-color: #f0f4ff;
            color: #4361ee;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .progress-bar-container {
            background-color: #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
            height: 10px;
            margin-top: 5px;
        }

        .progress-bar {
            height: 100%;
            background-color: #4361ee;
            width: 0;
            transition: width 0.4s ease-in-out;
        }

        .certificates-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .certificate-card {
            background-color: #fff;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border-radius: 10px;
            position: relative;
        }

        .certificate-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .certificate-title {
            font-size: 1.1rem;
            color: #26577c;
        }

        .badge {
            font-size: 0.9rem;
            padding: 5px 10px;
        }

        @media (max-width: 576px) {
            .certificates-grid {
                grid-template-columns: 1fr;
            }
        }


        .job-item {
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        @media (max-width: 992px) {
            .account-content {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <?php require_once 'components/navbar.php'; ?>

    <!-- Account Section -->
    <section class="account-section">
        <div class="account-header">
            <h1>My Profile</h1>
            <p>View and manage your profile information</p>
        </div>

        <div class="account-content">

            <!-- Sidebar Card -->
            <div class="profile-card">
                <?php if (!empty($userDetails['image'])): ?>
                    <img src="<?= $userDetails['image'] ?>" alt="Profile Picture" class="profile-pic">
                <?php else: ?>
                    <div class="profile-pic">👤</div>
                <?php endif; ?>

                <h3 class="profile-name"><?= htmlspecialchars($userDetails['name']) ?></h3>
                <p class="profile-title"><?= htmlspecialchars($userDetails['specialization'] ?? 'Developer') ?></p>
                <p class="profile-location"><?= htmlspecialchars($userDetails['location'] ?? 'Location') ?></p>

                <?php
                // calculate average score
                $totalScore = 0;
                $count = 0;

                $user_id = $_SESSION['user_id'] ?? 0;
                if ($user_id > 0) {
                    $cert_sql = "SELECT score FROM user_exam_results WHERE user_id = ?";
                    $stmt = mysqli_prepare($conn, $cert_sql);
                    mysqli_stmt_bind_param($stmt, "i", $user_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $totalScore += $row['score'];
                        $count++;
                    }
                }

                $avgScore = $count ? round($totalScore / $count, 1) : null;
                if ($avgScore !== null): ?>
                    <div class="profile-level">
                        <div>Marks Average: <?= $avgScore ?>/100</div>
                        <div class="progress-bar-container">
                            <div class="progress-bar" style="width: <?= $avgScore ?>%"></div>
                        </div>
                        <small><?= $avgScore ?>% from total exams</small>
                    </div>
                <?php else: ?>
                    <div class="profile-level">
                        <div>No exams taken yet.</div>
                    </div>
                <?php endif; ?>

                <?php
                // calculate years of experience and total certificates
                $user_id = $_SESSION['user_id'] ?? 0;
                $totalCertificates = 0;
                $yearsOfExperience = 0;
                $totalTestsTaken = 0;

                if ($user_id > 0) {
                    // select total certificates and years of experience
                    $cert_sql = "SELECT COUNT(*) as total, AVG(score) as avg_score, MIN(taken_at) as first_taken 
                 FROM user_exam_results WHERE user_id = ?";
                    $stmt = mysqli_prepare($conn, $cert_sql);
                    mysqli_stmt_bind_param($stmt, "i", $user_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $row = mysqli_fetch_assoc($result);

                    $totalCertificates = $row['total'];
                    $totalTestsTaken = $row['total'];

                    if ($row['first_taken']) {
                        $firstDate = new DateTime($row['first_taken']);
                        $now = new DateTime();
                        $yearsOfExperience = $now->diff($firstDate)->y;
                    }
                }
                ?>

                <div class="profile-stats">
                    <div class="stat-item">
                        <div class="stat-value"><?= $totalCertificates ?? 0 ?></div>
                        <p class="stat-label">Certificates</p>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value"><?= $yearsOfExperience ?? 0 ?></div>
                        <p class="stat-label">Years of Experience</p>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value"><?= $totalTestsTaken ?? 0 ?></div>
                        <p class="stat-label">Total exams Taken</p>
                    </div>
                </div>

                <div class="mt-2">
                    <?php if (!empty($userDetails['social_links']) && is_array($userDetails['social_links']) && count($userDetails['social_links']) > 0): ?>
                        <div class="d-flex justify-content-center gap-3">
                            <?php foreach ($userDetails['social_links'] as $link):
                                $platform = $link['name'];
                                $iconClass = match ($platform) {
                                    'facebook' => 'bi bi-facebook text-primary',
                                    'twitter' => 'bi bi-twitter text-info',
                                    'linkedin' => 'bi bi-linkedin text-primary',
                                    'instagram' => 'bi bi-instagram text-danger',
                                    'youtube' => 'bi bi-youtube text-danger',
                                    'snapchat' => 'bi bi-snapchat-ghost text-warning',
                                    'whatsapp' => 'bi bi-whatsapp text-success',
                                    'tiktok' => 'bi bi-tiktok text-dark',
                                    'pinterest' => 'bi bi-pinterest text-danger',
                                    default => 'bi bi-link',
                                };
                            ?>
                                <a href="<?= htmlspecialchars($link['url']) ?>" target="_blank" class="text-decoration-none" title="<?= ucfirst($platform) ?>">
                                    <i class="<?= $iconClass ?>" style="font-size: 1.5rem;"></i>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">You haven't social links.</p>
                        <a href="social.php" class="add-social-btn btn btn-outline-primary btn-sm">Add Social Links</a>
                    <?php endif; ?>
                </div>

                <?php if ($_SESSION['user_id'] === $userId): ?>
                    <a href="edit-profile.php" class="btn btn-primary mt-3 d-block">Edit Profile</a>
                <?php endif; ?>
            </div>

            <!-- Main Details -->
            <div class="details-card">
                <h3 class="section-title">Personal Information</h3>
                <div class="info-row">
                    <div class="info-col">
                        <span class="info-label">Email</span>
                        <p class="info-value"><?= htmlspecialchars($userDetails['email']) ?></p>
                    </div>
                    <div class="info-col">
                        <span class="info-label">Phone</span>
                        <p class="info-value"><?= htmlspecialchars($userDetails['phone']) ?></p>
                    </div>
                    <div class="info-col">
                        <span class="info-label">Location</span>
                        <p class="info-value"><?= htmlspecialchars($userDetails['location']) ?></p>
                    </div>
                    <div class="info-col">
                        <span class="info-label">Specialization</span>
                        <p class="info-value"><?= htmlspecialchars($userDetails['specialization'] ?? '-') ?></p>
                    </div>
                    <div class="info-col">
                        <span class="info-label">Education</span>
                        <p class="info-value"><?= htmlspecialchars($userDetails['education'] ?? '-') ?></p>
                    </div>
                    <div class="info-col">
                        <span class="info-label">CV</span>
                        <p class="info-value">
                            <?php if (!empty($userDetails['cv'])): ?>
                                <a href="<?= $userDetails['cv'] ?>" class="btn btn-sm btn-outline-primary" download>Download</a>
                            <?php else: ?>
                                No CV uploaded
                            <?php endif; ?>
                        </p>
                    </div>
                </div>

                <!-- Certificates Section -->
                <div class="certificates-list">
                    <?php if ($userDetails['role'] === 'employee' && $user_id > 0): ?>
                        <?php
                        // fetch user certificates
                        $sql_certificates = "SELECT e.title, uer.score, uer.taken_at, uer.passed, uer.id AS result_id
                         FROM user_exam_results uer
                         JOIN exams e ON uer.exam_id = e.id
                         WHERE uer.user_id = ?";
                        $stmt = mysqli_prepare($conn, $sql_certificates);
                        mysqli_stmt_bind_param($stmt, "i", $user_id);
                        mysqli_stmt_execute($stmt);
                        $certificates = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
                        ?>

                        <?php if (!empty($certificates)): ?>
                            <h3 class="section-title mt-5">Certificates</h3>
                            <div class="certificates-grid">
                                <?php foreach ($certificates as $cert): ?>
                                    <div class="certificate-card shadow-sm p-4 rounded border-start border-4 <?= $cert['passed'] ? 'border-success' : 'border-danger' ?>">
                                        <h5 class="certificate-title fw-bold mb-3"><?= htmlspecialchars($cert['title']) ?></h5>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-muted small">Score</span>
                                            <span class="badge bg-<?= $cert['passed'] ? 'success' : 'danger' ?> fs-6"><?= $cert['score'] ?>/100</span>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="text-muted small">Date Taken</span>
                                            <span><?= date('F j, Y', strtotime($cert['taken_at'])) ?></span>
                                        </div>

                                        <a href="certificate.php?id=<?= $cert['result_id'] ?>" target="_blank" class="btn btn-outline-primary w-100 btn-sm">
                                            View Certificate
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info mt-4 text-center" role="alert">
                                You haven't taken any tests yet.
                            </div>
                            <a href="take-exam.php" class="btn btn-success mt-2 d-block w-100">Start a Test</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <!-- Option to Take New Test -->
                <?php if ($user_id > 0 && empty($certificates)): ?>
                    <div class="mt-4">
                        <a href="take-exam.php" class="btn btn-success btn-sm">Start a Test</a>
                    </div>
                <?php endif; ?>

                <!-- Start a Test Button -->
                <?php if ($user_id > 0 && !empty($certificates)): ?>
                    <div class="mt-4">
                        <a href="take-exam.php" class="btn btn-primary btn-sm">Start a Test</a>
                    </div>
                <?php endif; ?>


                <!-- Companies & Jobs for Recruiter -->
                <?php if ($userDetails['role'] === 'recruiter'): ?>
                    <h3 class="section-title">Companies</h3>
                    <?php foreach ($companyData as $company):
                        $names = explode("<br>", $company['name']);
                        $ids = explode("<br>", $company['id']);
                        foreach ($names as $key => $name): ?>
                            <div class="job-item">
                                <div><?= htmlspecialchars($name) ?></div>
                                <div>
                                    <a href="modify-company.php?delete=<?= $ids[$key] ?>" class="btn btn-danger btn-sm-hover">Delete</a>
                                    <a href="modify-company.php?companyId=<?= $ids[$key] ?>" class="btn btn-primary btn-sm-hover">Modify</a>
                                    <a href="company-detail.php?companyId=<?= $ids[$key] ?>" class="btn btn-primary btn-sm-hover">View</a>
                                </div>
                            </div>
                    <?php endforeach;
                    endforeach; ?>


                    <h3 class="section-title">Jobs Posted</h3>
                    <?php foreach ($companyData as $company):
                        $titles = explode("<br>", $company['job_titles']);
                        $j_ids = explode("<br>", $company['job_ids']);
                        foreach ($titles as $key => $title): ?>
                            <div class="job-item">
                                <div><?= htmlspecialchars($title) ?></div>
                                <div>
                                    <a href="modify-post.php?delete=<?= $j_ids[$key] ?>" class="btn btn-danger btn-sm-hover">Delete</a>
                                    <a href="modify-post.php?jobId=<?= $j_ids[$key] ?>" class="btn btn-primary btn-sm-hover">Modify</a>
                                    <a href="job-detail.php?jobId=<?= $j_ids[$key] ?>" class="btn btn-primary btn-sm-hover">View</a>
                                </div>
                            </div>
                    <?php endforeach;
                    endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php require_once 'components/footer.php'; ?>
    <!-- Scripts -->
    <?php require_once 'components/scripts.php'; ?>
</body>

</html>