<!DOCTYPE html>
<html lang="en">

<head>
    <title>Contact</title>
    <?php require_once 'components/head.php'; ?>
    <style>
        .post-job-btn {
            background-color: #007bff;
            color: #fff !important;
            padding: 8px 20px;
            border-radius: 10px;
            transition: all 0.3s;
            margin-left: 20px;
            font-weight: bold;
        }

        .post-job-btn:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .hero-section {
            background-image: url('https://images.unsplash.com/photo-1527689368864-3a821dbccc34?auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
            height: 400px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding-left: 50px;
        }

        .hero-section h1 {
            font-size: 4rem;
            font-weight: bold;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 10px 20px;
            border-radius: 10px;
        }

        @media screen and (max-width: 480px) {
            .hero-section {
                padding: 0;
                justify-content: center;
            }

            .hero-section h1 {
                width: 80%;
                font-size: 3rem;
            }
        }
    </style>
</head>

<body>
    <div class="bg-white p-0">
        <!-- Spinner -->
        <?php require_once 'components/spinner.php'; ?>
        <!-- Navbar -->
        <?php require_once 'components/navbar.php'; ?>



        <!-- Hero Section -->
        <section class="hero-section">
            <h1 class="animateanimated animatefadeInLeft text-primary">Contact Us</h1>
        </section>


        <!-- Contact Section -->
        <section class="contact-section py-5">
            <div class="container">
                <div class="row align-items-center">

                    <!-- Contact Info -->
                    <div class="col-md-6 mb-4 mb-md-0 animate__animated animate__fadeInLeft">
                        <h2 class="mb-4">Contact for Any Query</h2>
                        <p><strong>Address:</strong> 123 Tech Street, Cairo, Egypt</p>
                        <p><strong>Phone:</strong> +20 100 123 4567</p>
                        <p><strong>Email:</strong> support@boom.com</p>
                    </div>

                    <!-- Contact Form -->
                    <div class="col-md-6 animate__animated animate__fadeInRight">
                        <h2 class="mb-4">Send Us a Message</h2>
                        <form>
                            <input type="text" class="form-control mb-3" placeholder="Your Name" required />
                            <input type="email" class="form-control mb-3" placeholder="Your Email" required />
                            <input type="tel" class="form-control mb-3" placeholder="Your Phone Number" required />
                            <textarea class="form-control mb-3" rows="4" placeholder="Your Message" required></textarea>
                            <button type="submit" class="btn btn-primary w-100">Send Message</button>
                        </form>
                    </div>

                </div>
            </div>
        </section>
        <?php require_once 'components/footer.php'; ?>
    </div>
    <?php require_once 'components/scripts.php'; ?>
</body>

</html>