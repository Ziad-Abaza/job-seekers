<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Our Team - Boom</title>

    <!-- Include Head -->
    <?php require_once 'components/head.php'; ?>

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f0f4f8;
        }

        .section-title {
            color: #26577c;
            font-weight: bold;
        }

        .member-card {
            background-color: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .member-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
        }

        .avatar-circle {
            width: 100px;
            height: 100px;
            margin: 0 auto 1rem;
            background-color: #e9f0ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            font-weight: bold;
            color: #26577c;
            border: 3px solid #d6eaff;
        }

        .member-name {
            font-size: 1.25rem;
            color: #26577c;
            font-weight: 600;
        }

        .member-role {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 1rem;
        }

        .social-icons a {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 1rem;
            margin: 0 5px;
            color: #26577c;
            border: 1px solid #26577c;
            transition: all 0.3s ease;
        }

        .social-icons a:hover {
            background-color: #26577c;
            color: white;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="bg-white p-0">
        <!-- Spinner -->
        <?php require_once 'components/spinner.php'; ?>
        <!-- Navbar -->
        <?php require_once 'components/navbar.php'; ?>

        <!-- Our Team Section -->
        <div class="container py-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="text-center mb-5">
                <h2 class="section-title">Meet Our Team</h2>
                <p class="text-muted">The talented developers and designers behind the Boom platform.</p>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

                <!-- Member Card Template -->
                <?php
                $team = [
                    ['name' => 'Mohamed Ashraf', 'role' => 'Full Stack Developer', 'social' => ['whatsapp', 'facebook', 'instagram']],
                    ['name' => 'Ahmed Khalid',   'role' => 'UI/UX Designer',     'social' => ['whatsapp', 'linkedin', 'github']],
                    ['name' => 'Sarah Ahmed',    'role' => 'Project Manager',     'social' => ['twitter', 'instagram', 'dribbble']],
                    ['name' => 'John Smith',     'role' => 'Cloud Architect',     'social' => ['linkedin', 'twitter', 'stack-overflow']]
                ];

                foreach ($team as $member):
                ?>
                    <div class="col">
                        <div class="member-card h-100">
                            <div class="avatar-circle"><?= strtoupper(substr($member['name'], 0, 1)) ?></div>
                            <h5 class="member-name"><?= htmlspecialchars($member['name']) ?></h5>
                            <p class="member-role"><?= htmlspecialchars($member['role']) ?></p>
                            <div class="social-icons d-flex justify-content-center">
                                <?php foreach ($member['social'] as $icon): ?>
                                    <a href="#" title="<?= ucfirst($icon) ?>">
                                        <i class="fab fa-<?= $icon ?>"></i>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Footer -->
        <?php require_once 'components/footer.php'; ?>
    </div>

    <!-- Scripts -->
    <?php require_once 'components/scripts.php'; ?>
</body>

</html>