<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>FAQs - Tech Career Hub</title>

    <!-- Include Head -->
    <?php require_once 'components/head.php'; ?>

    <!-- Custom Styles for FAQs -->
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f0f4f8;
        }

        .faq-section {
            padding: 5rem 0;
        }

        .faq-card {
            background-color: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.03);
            transition: transform 0.3s ease;
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .faq-card:hover {
            transform: translateY(-5px);
        }

        .faq-question {
            padding: 1.5rem;
            border-bottom: 1px solid #e9ecef;
        }

        .faq-question h2 {
            color: #26577c;
            font-weight: bold;
        }

        .faq-answer {
            padding: 1.5rem;
            line-height: 1.8;
        }
    </style>
</head>

<body>
    <div class="bg-white p-0">
        <!-- Spinner -->
        <?php require_once 'components/spinner.php'; ?>
        <!-- Navbar -->
        <?php require_once 'components/navbar.php'; ?>

        <!-- FAQ Section -->
        <section class="faq-section">
            <div class="container">
                <h1 class="text-center mb-5">Frequently Asked Questions</h1>

                <div class="faq-list">
                    <!-- FAQ Item 1 -->
                    <div class="faq-card shadow-sm wow fadeInUp" data-wow-delay="0.1s">
                        <div class="faq-question">
                            <h2>1. What kind of jobs are available in Web Development?</h2>
                        </div>
                        <div class="faq-answer">
                            <p>Web Development offers a wide range of job opportunities including Frontend Developer, Backend Developer, Full-Stack Developer, UI/UX Designer, and more.</p>
                        </div>
                    </div>

                    <!-- FAQ Item 2 -->
                    <div class="faq-card shadow-sm wow fadeInUp" data-wow-delay="0.2s">
                        <div class="faq-question">
                            <h2>2. What skills are required for UI/UX Design roles?</h2>
                        </div>
                        <div class="faq-answer">
                            <p>UI/UX Designers need skills in user research, wireframing, prototyping, visual design, and proficiency in tools like Sketch, Adobe XD, or Figma.</p>
                        </div>
                    </div>

                    <!-- FAQ Item 3 -->
                    <div class="faq-card shadow-sm wow fadeInUp" data-wow-delay="0.3s">
                        <div class="faq-question">
                            <h2>3. How can I start a career in App Development?</h2>
                        </div>
                        <div class="faq-answer">
                            <p>To start a career in App Development, you should learn programming languages like Java (for Android), Swift or Objective-C (for iOS), and frameworks like React Native or Flutter.</p>
                        </div>
                    </div>

                    <!-- FAQ Item 4 -->
                    <div class="faq-card shadow-sm wow fadeInUp" data-wow-delay="0.4s">
                        <div class="faq-question">
                            <h2>4. What does a Software Developer do?</h2>
                        </div>
                        <div class="faq-answer">
                            <p>Software Developers are responsible for designing, coding, testing, and maintaining software applications. They work on various platforms and may specialize in specific programming languages.</p>
                        </div>
                    </div>

                    <!-- FAQ Item 5 -->
                    <div class="faq-card shadow-sm wow fadeInUp" data-wow-delay="0.5s">
                        <div class="faq-question">
                            <h2>5. What skills are important for Database Administration?</h2>
                        </div>
                        <div class="faq-answer">
                            <p>Database Administrators need skills in database management systems like MySQL, SQL Server, or Oracle. They should also understand database security, backup and recovery, and performance tuning.</p>
                        </div>
                    </div>

                    <!-- FAQ Item 6 -->
                    <div class="faq-card shadow-sm wow fadeInUp" data-wow-delay="0.6s">
                        <div class="faq-question">
                            <h2>6. What roles are available in Network Engineering?</h2>
                        </div>
                        <div class="faq-answer">
                            <p>Network Engineers are responsible for designing, implementing, and managing computer networks. Roles include Network Administrator, Security Engineer, Cloud Networking Specialist, and more.</p>
                        </div>
                    </div>

                    <!-- FAQ Item 7 -->
                    <div class="faq-card shadow-sm wow fadeInUp" data-wow-delay="0.7s">
                        <div class="faq-question">
                            <h2>7. What is involved in Embedded Systems development?</h2>
                        </div>
                        <div class="faq-answer">
                            <p>Embedded Systems developers design and develop software for embedded devices like microcontrollers and microprocessors. They work closely with hardware engineers to create efficient and reliable systems.</p>
                        </div>
                    </div>

                    <!-- FAQ Item 8 -->
                    <div class="faq-card shadow-sm wow fadeInUp" data-wow-delay="0.8s">
                        <div class="faq-question">
                            <h2>8. What is IoT and what career opportunities does it offer?</h2>
                        </div>
                        <div class="faq-answer">
                            <p>IoT (Internet of Things) involves connecting everyday objects to the internet to collect and exchange data. Career opportunities in IoT include IoT Developer, IoT Solution Architect, and IoT Security Specialist.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <?php require_once 'components/footer.php'; ?>
    </div>

    <!-- Scripts -->
    <?php require_once 'components/scripts.php'; ?>
</body>

</html>