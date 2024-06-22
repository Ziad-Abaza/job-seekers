-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2024 at 10:59 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `job_seekers_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `role` enum('superAdmin','admin','editor') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `image`, `role`, `created_at`, `updated_at`) VALUES
(1, 'superAdmin', 'egytech@gmail.com', '$2y$10$FpnIcvpiXyiZ1E1OkGeVHeqUUR35jZrIRsaODvBiC0ly8mywLhfDa', 'img/profile_picture.png', 'superAdmin', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('full time','part time') NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `job_posting_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `job_posting_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` enum('Web Development','UI/UX Design','App Development','Software Development','Database Administration','Network Engineering','Embedded Systems','IoT') DEFAULT NULL,
  `location` enum('Alexandria','Aswan','Asyut','Beheira','Beni Suef','Cairo','Dakahlia','Damietta','Faiyum','Gharbia','Giza','Ismailia','Kafr El Sheikh','Luxor','Matruh','Minya','Monufia','New Valley','North Sinai','Port Said','Qalyubia','Qena','Red Sea','Sharqia','Sohag','South Sinai','Suez') DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `description`, `image`, `category`, `location`, `email`, `phone`, `user_id`, `created_at`, `updated_at`) VALUES
(5, 'Tech Innovators', 'Leading company in software development and web solutions.', 'img/6677299ebb61f_robotics-backgrounds-247250-1737017-422841.png', 'Software Development', 'Giza', 'ziad.h.abaza@gmail.com', '01235645558', 9, '2024-06-22 19:44:30', '2024-06-22 19:44:30'),
(6, 'Creative Designs', 'Pioneers in UI/UX design and creative solutions.', 'img/Creative Designs.jpg', 'UI/UX Design', 'Alexandria', 'contact@creativedesigns.com', '234-567-8901', 11, NULL, NULL),
(7, 'App Masters', 'Specializing in mobile app development and consulting.', 'img/App Masters.jpg', 'App Development', 'Giza', 'support@appmasters.com', '345-678-9012', 13, NULL, NULL),
(8, 'Network Solutions', 'Experts in network engineering and IT infrastructure.', 'img/Network Solutions.jpg', 'Network Engineering', 'Aswan', 'services@networksolutions.com', '456-789-0123', 11, NULL, NULL),
(9, 'Embedded Innovations', 'Leaders in embedded systems and IoT solutions.', 'img/Embedded Innovations.jpg', 'Embedded Systems', 'Luxor', 'info@embeddedinnovations.com', '567-890-1234', 9, NULL, NULL),
(10, 'Database Pros', 'Providing top-notch database administration services.', 'img/Database Pros.jpg', 'Database Administration', 'Suez', 'contact@databasepros.com', '678-901-2345', 13, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `job_postings`
--

CREATE TABLE `job_postings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `salary` double DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `type` enum('full time','part time') DEFAULT NULL,
  `category` enum('Web Development','UI/UX Design','App Development','Software Development','Database Administration','Network Engineering','Embedded Systems','IoT') DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_postings`
--

INSERT INTO `job_postings` (`id`, `title`, `description`, `salary`, `status`, `type`, `category`, `image`, `user_id`, `company_id`, `created_at`, `updated_at`) VALUES
(66, 'Senior PHP Developer', 'We are seeking a skilled Senior PHP Developer to join our dynamic team. The ideal candidate will have strong experience in PHP, Laravel, and MySQL, and will be responsible for developing and maintaining high-quality web applications.', 18000, 1, 'full time', 'Web Development', 'img/senior_php_developer.jpg', 13, 7, '2024-05-13 14:58:44', '2024-05-13 14:58:44'),
(67, 'Mobile App Developer', 'Join our team as a Mobile App Developer and contribute to cutting-edge mobile application projects. The role involves designing and developing Android and iOS applications using Flutter or native languages.', 20000, 1, 'full time', 'App Development', 'img/mobile_app_developer.jpg', 13, 10, '2024-05-13 15:07:50', '2024-05-13 15:07:50'),
(68, 'Python Data Scientist', 'We are looking for a talented Python Data Scientist to drive data-driven insights and solutions. The role requires expertise in Python, data analysis, machine learning, and statistical modeling.', 25000, 1, 'full time', '', 'img/python_data_scientist.jpg', 9, 5, '2024-05-13 15:10:40', '2024-05-13 15:10:40'),
(69, 'Front-end Web Developer', 'Seeking a creative Front-end Web Developer to build responsive and user-friendly interfaces. The ideal candidate will be proficient in HTML, CSS, JavaScript, and frameworks like React or Vue.js.', 14000, 1, 'part time', 'Web Development', 'img/frontend_web_developer.jpg', 9, 9, '2024-05-13 15:24:06', '2024-05-13 15:24:06'),
(70, 'UX/UI Designer', 'Join our team as a UX/UI Designer to create intuitive and visually appealing designs. The role requires expertise in user experience research, wireframing, prototyping, and collaboration with development teams.', 18000, 1, 'full time', 'UI/UX Design', 'img/ux_ui_designer.jpg', 11, 6, '2024-05-13 15:25:23', '2024-05-13 15:25:23'),
(71, 'Backend Software Engineer', 'We are hiring a skilled Backend Software Engineer to develop robust server-side logic. The ideal candidate will have strong proficiency in Node.js, Python, or Java, and experience with databases like MongoDB or MySQL.', 21000, 1, 'full time', 'Web Development', 'img/backend_software_engineer.jpg', 13, 7, '2024-05-13 15:30:00', '2024-05-13 15:30:00'),
(72, 'Full Stack Developer', 'Seeking a versatile Full Stack Developer to design and build scalable web applications. The role involves working with both front-end and back-end technologies such as JavaScript, PHP, and frameworks like Laravel or React.', 19000, 1, 'full time', 'Web Development', 'img/full_stack_developer.jpg', 13, 10, '2024-05-13 15:35:00', '2024-05-13 15:35:00'),
(73, 'Cloud DevOps Engineer', 'We are looking for a Cloud DevOps Engineer to manage cloud infrastructure and deployment pipelines. The role requires expertise in AWS, Azure, or Google Cloud Platform, and experience with CI/CD tools like Jenkins or GitLab.', 23000, 1, 'full time', '', 'img/cloud_devops_engineer.jpg', 11, 8, '2024-05-13 15:55:00', '2024-05-13 15:55:00');

-- --------------------------------------------------------

--
-- Table structure for table `job_requirements`
--

CREATE TABLE `job_requirements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `job_posting_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_requirements`
--

INSERT INTO `job_requirements` (`id`, `title`, `description`, `job_posting_id`, `created_at`, `updated_at`) VALUES
(38, 'Senior PHP Developer Requirements', '1. Strong proficiency in PHP, Laravel, and MySQL.\r\n2. Experience in developing RESTful APIs.\r\n3. Familiarity with front-end technologies such as JavaScript, HTML5, and CSS3.\r\n4. Ability to troubleshoot, test, and maintain the core product software and databases.', 66, '2024-05-13 14:58:44', '2024-05-13 14:58:44'),
(39, 'Mobile App Developer Requirements', '1. Proficiency in Flutter for developing Android and iOS applications.\r\n2. Knowledge of native Android and iOS development using Java/Kotlin and Swift respectively.\r\n3. Experience in integrating third-party libraries and APIs.\r\n4. Strong understanding of UI design principles and best practices for performance and usability.', 67, '2024-05-13 15:07:50', '2024-05-13 15:07:50'),
(40, 'Python Data Scientist Requirements', '1. Advanced proficiency in Python and its libraries such as NumPy, Pandas, and Scikit-learn.\r\n2. Experience in data mining, statistical analysis, and machine learning algorithms.\r\n3. Familiarity with databases and data visualization tools.\r\n4. Strong analytical and problem-solving skills.', 68, '2024-05-13 15:10:40', '2024-05-13 15:10:40'),
(41, 'Front-end Web Developer Requirements', '1. Proficiency in HTML, CSS, JavaScript, and front-end frameworks like React or Vue.js.\r\n2. Experience with responsive and adaptive design principles.\r\n3. Knowledge of SEO principles and ensuring that the application will adhere to them.\r\n4. Ability to optimize applications for maximum speed and scalability.', 69, '2024-05-13 15:24:06', '2024-05-13 15:24:06'),
(42, 'UX/UI Designer Requirements', '1. Proficiency in design tools like Adobe XD, Sketch, or Figma.\r\n2. Experience in creating wireframes, prototypes, and user flows.\r\n3. Understanding of user-centered design principles and best practices.\r\n4. Ability to collaborate closely with developers, marketers, and product managers.', 70, '2024-05-13 15:25:23', '2024-05-13 15:25:23'),
(43, 'Backend Software Engineer Requirements', '1. Strong proficiency in server-side languages such as Node.js, Python, or Java.\r\n2. Experience in designing and developing APIs.\r\n3. Familiarity with SQL and NoSQL databases like MongoDB or MySQL.\r\n4. Knowledge of software engineering best practices including design patterns and SOLID principles.', 71, '2024-05-13 15:30:00', '2024-05-13 15:30:00'),
(44, 'Full Stack Developer Requirements', '1. Proficiency in both front-end and back-end technologies such as JavaScript, PHP, and frameworks like Laravel or React.\r\n2. Experience in designing and building scalable web applications.\r\n3. Understanding of version control systems such as Git.\r\n4. Ability to work independently and as part of a team.', 72, '2024-05-13 15:35:00', '2024-05-13 15:35:00'),
(45, 'Cloud DevOps Engineer Requirements', '1. Experience with cloud platforms such as AWS, Azure, or Google Cloud Platform.\r\n2. Knowledge of infrastructure as code tools like Terraform or CloudFormation.\r\n3. Proficiency in CI/CD pipelines and automation tools like Jenkins or GitLab CI/CD.\r\n4. Ability to troubleshoot complex issues in cloud environments.', 73, '2024-05-13 15:55:00', '2024-05-13 15:55:00');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `social_links`
--

CREATE TABLE `social_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` enum('facebook','twitter','linkedin','instagram','youtube','snapchat','whatsapp','tiktok','pinterest') NOT NULL,
  `url` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `social_links`
--

INSERT INTO `social_links` (`id`, `name`, `url`, `user_id`, `company_id`, `created_at`, `updated_at`) VALUES
(40, 'facebook', 'https://www.facebook.com/johndoe', 5, NULL, NULL, NULL),
(41, 'twitter', 'https://www.twitter.com/janesmith', 5, NULL, NULL, NULL),
(42, 'linkedin', 'https://www.linkedin.com/in/alicejohnson', 5, NULL, NULL, NULL),
(43, 'instagram', 'https://www.instagram.com/bobbrown', 5, NULL, NULL, NULL),
(44, 'youtube', 'https://www.youtube.com/channel/charliedavis', 6, NULL, NULL, NULL),
(45, 'facebook', 'https://www.facebook.com/techinnovators', 6, NULL, NULL, NULL),
(46, 'twitter', 'https://www.twitter.com/creativedesigns', 6, NULL, NULL, NULL),
(47, 'linkedin', 'https://www.linkedin.com/company/appmasters', 7, NULL, NULL, NULL),
(48, 'instagram', 'https://www.instagram.com/networksolutions', 7, NULL, NULL, NULL),
(49, 'youtube', 'https://www.youtube.com/channel/embeddedinnovations', 8, NULL, NULL, NULL),
(50, 'facebook', 'https://www.facebook.com/johndoe', 8, NULL, NULL, NULL),
(51, 'twitter', 'https://www.twitter.com/janesmith', 9, NULL, NULL, NULL),
(52, 'linkedin', 'https://www.linkedin.com/in/alicejohnson', 10, NULL, NULL, NULL),
(53, 'instagram', 'https://www.instagram.com/bobbrown', 10, NULL, NULL, NULL),
(54, 'youtube', 'https://www.youtube.com/channel/charliedavis', 10, NULL, NULL, NULL),
(55, 'facebook', 'https://www.facebook.com/techinnovators', 10, NULL, NULL, NULL),
(56, 'twitter', 'https://www.twitter.com/creativedesigns', 13, NULL, NULL, NULL),
(57, 'linkedin', 'https://www.linkedin.com/company/appmasters', 13, NULL, NULL, NULL),
(58, 'instagram', 'https://www.instagram.com/networksolutions', 12, NULL, NULL, NULL),
(59, 'youtube', 'https://www.youtube.com/channel/embeddedinnovations', 12, NULL, NULL, NULL),
(60, 'facebook', 'https://www.facebook.com/johndoe', NULL, 5, NULL, NULL),
(61, 'twitter', 'https://www.twitter.com/janesmith', NULL, 5, NULL, NULL),
(62, 'linkedin', 'https://www.linkedin.com/in/alicejohnson', NULL, 5, NULL, NULL),
(63, 'instagram', 'https://www.instagram.com/bobbrown', NULL, 6, NULL, NULL),
(64, 'youtube', 'https://www.youtube.com/channel/charliedavis', NULL, 6, NULL, NULL),
(65, 'facebook', 'https://www.facebook.com/techinnovators', NULL, 7, NULL, NULL),
(66, 'twitter', 'https://www.twitter.com/creativedesigns', NULL, 7, NULL, NULL),
(67, 'linkedin', 'https://www.linkedin.com/company/appmasters', NULL, 7, NULL, NULL),
(68, 'instagram', 'https://www.instagram.com/networksolutions', NULL, 8, NULL, NULL),
(69, 'youtube', 'https://www.youtube.com/channel/embeddedinnovations', NULL, 8, NULL, NULL),
(70, 'facebook', 'https://www.facebook.com/johndoe', NULL, 8, NULL, NULL),
(71, 'twitter', 'https://www.twitter.com/janesmith', NULL, 9, NULL, NULL),
(72, 'linkedin', 'https://www.linkedin.com/in/alicejohnson', NULL, 9, NULL, NULL),
(73, 'instagram', 'https://www.instagram.com/bobbrown', NULL, 9, NULL, NULL),
(74, 'youtube', 'https://www.youtube.com/channel/charliedavis', NULL, 9, NULL, NULL),
(75, 'facebook', 'https://www.facebook.com/techinnovators', NULL, 10, NULL, NULL),
(76, 'twitter', 'https://www.twitter.com/creativedesigns', NULL, 10, NULL, NULL),
(77, 'linkedin', 'https://www.linkedin.com/company/appmasters', NULL, 10, NULL, NULL),
(78, 'instagram', 'https://www.instagram.com/networksolutions', NULL, 10, NULL, NULL),
(79, 'youtube', 'https://www.youtube.com/channel/embeddedinnovations', NULL, 10, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('recruiter','employee') NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `user_details_id` bigint(20) UNSIGNED DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `token_expiration` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`, `image`, `phone`, `user_details_id`, `token`, `token_expiration`, `created_at`, `updated_at`) VALUES
(5, 'john doe', 'john.doe@example.com', '$2y$10$FpnIcvpiXyiZ1E1OkGeVHeqUUR35jZrIRsaODvBiC0ly8mywLhfDa', 'employee', 1, 'img/profile_picture.png', '01065234853', 8, 'a435fdefb54402ed947b04d275317f7ca2777582444483125153fd5ba86870d7', '2024-06-22 20:05:28', NULL, NULL),
(6, 'bob brown', 'bob.brown@example.com', '$2y$10$0z0rOiS4CLrYEtcBnYanDuJBRjogy4it.YzSUdonImXhs2lCBkJAm', 'employee', 1, 'img/profile_picture.png', '01006523458', 10, 'f87c64fb6fd85b34d37611d0fb1a2bcdbd528c5f72b380e9ce9925a11b16c5a2', '2024-06-22 20:05:34', NULL, NULL),
(7, 'henry king', 'henry.king@example.com', '$2y$10$7BH8jUvkpHMr3OxLqph1suOd6g40QEzXYxOw0P0ZOObVPnCTVQcYi', 'employee', 1, 'img/profile_picture.png', '01245362589', 6, 'e3d896d7c97db7a19f7ef349934048cc607f8fa33b3d5663735663f12d2f7e9c', '2024-06-22 20:05:44', NULL, NULL),
(8, 'ziad hassan', 'ziad.h.abaza@gmail.com', '$2y$10$ey3oEMkYLcugHJtWduN6jetcqtLQ1xBLew3luB7NqNz/mZ//J4FG2', 'employee', 1, 'img/profile_picture.png', '01002352642', 12, 'dbcb3c95ae1e78963393484a96a7314e844538c7adcfea5911cda580c064b39e', '2024-06-22 20:05:53', NULL, NULL),
(9, 'omer ahmed', 'ziadabaza12345@gmail.com', '$2y$10$Xa2Ahz6lbiUi2lRrPJbyqOwFb4bgDhuklrf6w7iddvqsBGKyO/pnO', 'recruiter', 1, 'img/profile_picture.png', '01006403927', NULL, '64791d9d9d4d72e2459b4e585f3fa76ce5f2caf0702b1f49edeceae2a2e79bb9', '2024-06-22 19:46:58', NULL, NULL),
(10, 'Diana Evans', 'diana.evans@example.com', '$2y$10$Xa2Ahz6lbiUi2lRrPJbyqOwFb4bgDhuklrf6w7iddvqsBGKyO/pnO', 'employee', 1, 'img/profile_picture.png', '678-901-2345', 7, NULL, '2024-06-22 20:06:02', NULL, NULL),
(11, 'Frank Green', 'frank.green@example.com', '$2y$10$Xa2Ahz6lbiUi2lRrPJbyqOwFb4bgDhuklrf6w7iddvqsBGKyO/pnO', 'recruiter', 1, 'img/profile_picture.png', '789-012-3456', NULL, NULL, '2024-06-22 19:52:14', NULL, NULL),
(12, 'Grace Hill', 'grace.hill@example.com', '$2y$10$Xa2Ahz6lbiUi2lRrPJbyqOwFb4bgDhuklrf6w7iddvqsBGKyO/pnO', 'employee', 1, 'img/profile_picture.png', '890-123-4567', 9, NULL, '2024-06-22 20:06:21', NULL, NULL),
(13, 'Henry King', 'henry.king@example.com', '$2y$10$Xa2Ahz6lbiUi2lRrPJbyqOwFb4bgDhuklrf6w7iddvqsBGKyO/pnO', 'recruiter', 1, 'img/profile_picture.png', '901-234-5678', NULL, NULL, '2024-06-22 19:52:22', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `location` enum('Alexandria','Aswan','Asyut','Beheira','Beni Suef','Cairo','Dakahlia','Damietta','Faiyum','Gharbia','Giza','Ismailia','Kafr El Sheikh','Luxor','Matruh','Minya','Monufia','New Valley','North Sinai','Port Said','Qalyubia','Qena','Red Sea','Sharqia','Sohag','South Sinai','Suez') DEFAULT NULL,
  `education` varchar(255) DEFAULT NULL,
  `cv` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `specialization`, `location`, `education`, `cv`, `created_at`, `updated_at`) VALUES
(4, 'Software Engineer', 'Cairo', 'B.Sc. in Computer Science', NULL, NULL, NULL),
(5, 'Graphic Designer', 'Alexandria', 'B.A. in Graphic Design', NULL, NULL, NULL),
(6, 'Data Analyst', 'Giza', 'B.Sc. in Statistics', NULL, NULL, NULL),
(7, 'Project Manager', 'Cairo', 'MBA', NULL, NULL, NULL),
(8, 'Network Engineer', 'Aswan', 'B.Sc. in Information Technology', NULL, NULL, NULL),
(9, 'HR Specialist', 'Minya', 'B.A. in Business Administration', NULL, NULL, NULL),
(10, 'Marketing Coordinator', 'Luxor', 'B.A. in Marketing', NULL, NULL, NULL),
(11, 'Web Developer', 'Port Said', 'B.Sc. in Software Engineering', NULL, NULL, NULL),
(12, 'Mechanical Engineer', 'Suez', 'B.Sc. in Mechanical Engineering', NULL, NULL, NULL),
(13, 'Electrical Engineer', 'Dakahlia', 'B.Sc. in Electrical Engineering', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applications_user_id_foreign` (`user_id`),
  ADD KEY `applications_job_posting_id_foreign` (`job_posting_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_job_posting_id_foreign` (`job_posting_id`),
  ADD KEY `comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companies_user_id_foreign` (`user_id`);

--
-- Indexes for table `job_postings`
--
ALTER TABLE `job_postings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_postings_user_id_foreign` (`user_id`),
  ADD KEY `job_postings_company_id_foreign` (`company_id`);

--
-- Indexes for table `job_requirements`
--
ALTER TABLE `job_requirements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_requirements_job_posting_id_foreign` (`job_posting_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `social_links`
--
ALTER TABLE `social_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `social_links_user_id_foreign` (`user_id`),
  ADD KEY `social_links_company_id_foreign` (`company_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_user_details_id_unique` (`user_details_id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `job_postings`
--
ALTER TABLE `job_postings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `job_requirements`
--
ALTER TABLE `job_requirements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `social_links`
--
ALTER TABLE `social_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_job_posting_id_foreign` FOREIGN KEY (`job_posting_id`) REFERENCES `job_postings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `applications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_job_posting_id_foreign` FOREIGN KEY (`job_posting_id`) REFERENCES `job_postings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `job_postings`
--
ALTER TABLE `job_postings`
  ADD CONSTRAINT `job_postings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_postings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_requirements`
--
ALTER TABLE `job_requirements`
  ADD CONSTRAINT `job_requirements_job_posting_id_foreign` FOREIGN KEY (`job_posting_id`) REFERENCES `job_postings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `social_links`
--
ALTER TABLE `social_links`
  ADD CONSTRAINT `social_links_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `social_links_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_user_details_id_foreign` FOREIGN KEY (`user_details_id`) REFERENCES `user_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
