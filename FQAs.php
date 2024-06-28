<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>FAQs - Tech Career Hub</title>
    <?php require_once 'components/head.php'; ?>
</head>

<body>


    <!-- Contact -->
    <div class="container-xxl py-5">
        <div class="container">
            <h1>Frequently Asked Questions</h1>
            <div class="faq-item">
                <h2>1. What kind of jobs are available in Web Development?</h2>
                <p>Web Development offers a wide range of job opportunities including Frontend Developer, Backend
                    De
                <div class="container-xxl bg-white p-0">
                    <!-- Spinner -->
                    <?php require_once 'components/spinner.php'; ?>
                    <!-- Navbar -->
                    <?php require_once 'components/navbar.php'; ?>veloper, Full-Stack Developer, UI/UX Designer, and
                    more.</p>
                </div>
                <div class="faq-item">
                    <h2>2. What skills are required for UI/UX Design roles?</h2>
                    <p>UI/UX Designers need skills in user research, wireframing, prototyping, visual design, and
                        proficiency in design tools like Sketch, Adobe XD, or Figma.</p>
                </div>
                <div class="faq-item">
                    <h2>3. How can I start a career in App Development?</h2>
                    <p>To start a career in App Development, you should learn programming languages like Java (for
                        Android),
                        Swift or Objective-C (for iOS), and frameworks like React Native or Flutter.</p>
                </div>
                <div class="faq-item">
                    <h2>4. What does a Software Developer do?</h2>
                    <p>Software Developers are responsible for designing, coding, testing, and maintaining software
                        applications. They work on various platforms and may specialize in specific programming
                        languages.
                    </p>
                </div>
                <div class="faq-item">
                    <h2>5. What skills are important for Database Administration?</h2>
                    <p>Database Administrators need skills in database management systems like MySQL, SQL Server, or
                        Oracle.
                        They should also have knowledge of database security, backup and recovery, and performance
                        tuning.
                    </p>
                </div>
                <div class="faq-item">
                    <h2>6. What roles are available in Network Engineering?</h2>
                    <p>Network Engineers are responsible for designing, implementing, and managing computer networks.
                        They
                        may specialize in areas like network security, routing and switching, or wireless technologies.
                    </p>
                </div>
                <div class="faq-item">
                    <h2>7. What is involved in Embedded Systems development?</h2>
                    <p>Embedded Systems developers design and develop software for embedded devices like
                        microcontrollers
                        and microprocessors. They work closely with hardware engineers to create efficient and reliable
                        systems.</p>
                </div>
                <div class="faq-item">
                    <h2>8. What is IoT and what career opportunities does it offer?</h2>
                    <p>IoT (Internet of Things) involves connecting everyday objects to the internet to collect and
                        exchange
                        data. Career opportunities in IoT include IoT Developer, IoT Solution Architect, and IoT
                        Security
                        Specialist.</p>
                </div>
            </div>
        </div>
        <!-- Contact End -->

        <?php require_once 'components/footer.php'; ?>
    </div>
    <?php require_once 'components/scripts.php'; ?>
</body>

</html>