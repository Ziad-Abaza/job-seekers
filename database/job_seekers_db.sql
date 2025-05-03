-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2024 at 09:19 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('full time','part time', 'remote') NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `job_posting_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `type`, `user_id`, `job_posting_id`, `created_at`, `updated_at`) VALUES
(1, 'part time', 1, 10, '2024-05-13 18:17:29', '2024-05-13 18:17:29'),
(2, 'full time', 3, 10, '2024-05-13 18:18:32', '2024-05-13 18:18:32'),
(3, 'part time', 3, 12, '2024-05-13 18:19:00', '2024-05-13 18:19:00'),
(4, 'part time', 1, 9, '2024-05-13 18:19:33', '2024-05-13 18:19:33');

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
(3, 'IT-CLUB', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio at repudiandae, voluptas adipisci eveniet sapiente aspernatur! Animi, culpa eligendi doloribus iusto nostrum, quibusdam sequi nulla commodi, maiores quas veritatis nisi.', 'img/66425431cca07_itclub (1).png', 'Software Development', 'Alexandria', 'IT-CLUB@gmail.com', '01002888377', 2, '2024-05-13 17:56:01', '2024-05-13 17:56:01'),
(4, '3-p0ox', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio at repudiandae, voluptas adipisci eveniet sapiente aspernatur! Animi, culpa eligendi doloribus iusto nostrum, quibusdam sequi nulla commodi, maiores quas veritatis nisi.', 'img/66425a51cb766_6642508e8b490_download.jpg', 'App Development', 'Giza', '3p0x@gmail.com', '01027981725', 4, '2024-05-13 18:22:09', '2024-05-13 18:22:09');

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
  `type` enum('full time','part time', 'remote') DEFAULT NULL,
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
(8, 'LARAVEL DEVELOPER', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio at repudiandae, voluptas adipisci eveniet sapiente aspernatur! Animi, culpa eligendi doloribus iusto nostrum, quibusdam sequi nulla commodi, maiores quas veritatis nisi.', 12000, 1, 'part time', 'Web Development', 'img/664254d4d9eae_.laravel.jpg', 2, 3, '2024-05-13 17:58:44', '2024-05-13 17:58:44'),
(9, 'Flutter Developer', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio at repudiandae, voluptas adipisci eveniet sapiente aspernatur! Animi, culpa eligendi doloribus iusto nostrum, quibusdam sequi nulla commodi, maiores quas veritatis nisi.', 17000, 1, 'full time', 'App Development', 'img/664256f6ce407_تطبييق.png', 2, 3, '2024-05-13 18:07:50', '2024-05-13 18:07:50'),
(10, 'Python Developer', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio at repudiandae, voluptas adipisci eveniet sapiente aspernatur! Animi, culpa eligendi doloribus iusto nostrum, quibusdam sequi nulla commodi, maiores quas veritatis nisi.', 22000, 1, 'full time', 'IoT', 'img/664257a0c3848_istockphoto-1221006408-612x612.png', 2, 3, '2024-05-13 18:10:40', '2024-05-13 18:10:40'),
(11, 'Full Stack Web Developer', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio at repudiandae, voluptas adipisci eveniet sapiente aspernatur! Animi, culpa eligendi doloribus iusto nostrum, quibusdam sequi nulla commodi, maiores quas veritatis nisi.', 7000, 1, 'part time', 'Web Development', 'img/66425ac6eeeaf_Developer activity-bro.png', 4, 4, '2024-05-13 18:24:06', '2024-05-13 18:24:06'),
(12, 'Figma Designer', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio at repudiandae, voluptas adipisci eveniet sapiente aspernatur! Animi, culpa eligendi doloribus iusto nostrum, quibusdam sequi nulla commodi, maiores quas veritatis nisi.', 220000, 1, 'full time', 'UI/UX Design', 'img/66425b134b241_UIUXDesign.png', 4, 4, '2024-05-13 18:25:23', '2024-05-13 18:25:23'),
(13, 'Front-end Developer', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio at repudiandae, voluptas adipisci eveniet sapiente aspernatur! Animi, culpa eligendi doloribus iusto nostrum, quibusdam sequi nulla commodi, maiores quas veritatis nisi.', 6000, 1, 'part time', 'Web Development', 'img/66425b9dbdf9b_webDeveloper.jpg', 4, 4, '2024-05-13 18:27:41', '2024-05-13 18:27:41');

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
(10, 'PHP', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio at repudiandae, voluptas adipisci eveniet sapiente aspernatur! Animi, culpa eligendi doloribus iusto nostrum, quibusdam sequi nulla commodi, maiores quas veritatis nisi.', 8, '2024-05-13 17:58:44', '2024-05-13 17:58:44'),
(11, 'MYSQL', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio at repudiandae, voluptas adipisci eveniet sapiente aspernatur! Animi, culpa eligendi doloribus iusto nostrum, quibusdam sequi nulla commodi, maiores quas veritatis nisi.', 8, '2024-05-13 17:58:44', '2024-05-13 17:58:44'),
(12, 'OOP', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio at repudiandae, voluptas adipisci eveniet sapiente aspernatur! Animi, culpa eligendi doloribus iusto nostrum, quibusdam sequi nulla commodi, maiores quas veritatis nisi.', 8, '2024-05-13 17:58:44', '2024-05-13 17:58:44'),
(13, 'Dart', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio at repudiandae, voluptas adipisci eveniet sapiente aspernatur! Animi, culpa eligendi doloribus iusto nostrum, quibusdam sequi nulla commodi, maiores quas veritatis nisi.', 9, '2024-05-13 18:07:50', '2024-05-13 18:07:50'),
(14, 'Flutter', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio at repudiandae, voluptas adipisci eveniet sapiente aspernatur! Animi, culpa eligendi doloribus iusto nostrum, quibusdam sequi nulla commodi, maiores quas veritatis nisi.', 9, '2024-05-13 18:07:50', '2024-05-13 18:07:50'),
(15, 'Python', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio at repudiandae, voluptas adipisci eveniet sapiente aspernatur! Animi, culpa eligendi doloribus iusto nostrum, quibusdam sequi nulla commodi, maiores quas veritatis nisi.', 10, '2024-05-13 18:10:40', '2024-05-13 18:10:40'),
(16, 'OOP', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio at repudiandae, voluptas adipisci eveniet sapiente aspernatur! Animi, culpa eligendi doloribus iusto nostrum, quibusdam sequi nulla commodi, maiores quas veritatis nisi.', 10, '2024-05-13 18:10:40', '2024-05-13 18:10:40'),
(17, 'Micro Python', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio at repudiandae, voluptas adipisci eveniet sapiente aspernatur! Animi, culpa eligendi doloribus iusto nostrum, quibusdam sequi nulla commodi, maiores quas veritatis nisi.', 10, '2024-05-13 18:10:40', '2024-05-13 18:10:40'),
(18, 'C Arduino', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio at repudiandae, voluptas adipisci eveniet sapiente aspernatur! Animi, culpa eligendi doloribus iusto nostrum, quibusdam sequi nulla commodi, maiores quas veritatis nisi.', 10, '2024-05-13 18:10:40', '2024-05-13 18:10:40'),
(19, 'THML', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio at repudiandae, voluptas adipisci eveniet sapiente aspernatur! Animi, culpa eligendi doloribus iusto nostrum, quibusdam sequi nulla commodi, maiores quas veritatis nisi.', 11, '2024-05-13 18:24:06', '2024-05-13 18:24:06'),
(20, 'CSS, BOOTSTRAP, TAILWIND', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio at repudiandae, voluptas adipisci eveniet sapiente aspernatur! Animi, culpa eligendi doloribus iusto nostrum, quibusdam sequi nulla commodi, maiores quas veritatis nisi.', 11, '2024-05-13 18:24:07', '2024-05-13 18:24:07'),
(21, 'JAVA SCRIPT', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio at repudiandae, voluptas adipisci eveniet sapiente aspernatur! Animi, culpa eligendi doloribus iusto nostrum, quibusdam sequi nulla commodi, maiores quas veritatis nisi.', 11, '2024-05-13 18:24:07', '2024-05-13 18:24:07'),
(22, 'PHP, LARAVEL', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio at repudiandae, voluptas adipisci eveniet sapiente aspernatur! Animi, culpa eligendi doloribus iusto nostrum, quibusdam sequi nulla commodi, maiores quas veritatis nisi.', 11, '2024-05-13 18:24:07', '2024-05-13 18:24:07'),
(23, 'MYSQL', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio at repudiandae, voluptas adipisci eveniet sapiente aspernatur! Animi, culpa eligendi doloribus iusto nostrum, quibusdam sequi nulla commodi, maiores quas veritatis nisi.', 11, '2024-05-13 18:24:07', '2024-05-13 18:24:07'),
(24, 'Figma', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio at repudiandae, voluptas adipisci eveniet sapiente aspernatur! Animi, culpa eligendi doloribus iusto nostrum, quibusdam sequi nulla commodi, maiores quas veritatis nisi.', 12, '2024-05-13 18:25:23', '2024-05-13 18:25:23'),
(25, '', '', 12, '2024-05-13 18:25:23', '2024-05-13 18:25:23'),
(26, 'HTML', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio at repudiandae, voluptas adipisci eveniet sapiente aspernatur! Animi, culpa eligendi doloribus iusto nostrum, quibusdam sequi nulla commodi, maiores quas veritatis nisi.', 13, '2024-05-13 18:27:41', '2024-05-13 18:27:41'),
(27, 'CSS, SASS', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio at repudiandae, voluptas adipisci eveniet sapiente aspernatur! Animi, culpa eligendi doloribus iusto nostrum, quibusdam sequi nulla commodi, maiores quas veritatis nisi.', 13, '2024-05-13 18:27:41', '2024-05-13 18:27:41'),
(28, 'REACT JS', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio at repudiandae, voluptas adipisci eveniet sapiente aspernatur! Animi, culpa eligendi doloribus iusto nostrum, quibusdam sequi nulla commodi, maiores quas veritatis nisi.', 13, '2024-05-13 18:27:41', '2024-05-13 18:27:41'),
(29, 'JS', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio at repudiandae, voluptas adipisci eveniet sapiente aspernatur! Animi, culpa eligendi doloribus iusto nostrum, quibusdam sequi nulla commodi, maiores quas veritatis nisi.', 13, '2024-05-13 18:27:41', '2024-05-13 18:27:41');

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
(1, 'facebook', 'https://www.facebook.com/unsupportedbrowser', 4, NULL, NULL, NULL),
(2, 'linkedin', 'https://www.facebook.com/unsupportedbrowser', 4, NULL, NULL, NULL),
(3, 'instagram', 'https://www.facebook.com/unsupportedbrowser', 4, NULL, NULL, NULL),
(4, 'facebook', 'https://www.facebook.com/unsupportedbrowser', 1, NULL, NULL, NULL),
(5, 'youtube', 'https://www.facebook.com/unsupportedbrowser', 1, NULL, NULL, NULL),
(6, 'twitter', 'https://www.facebook.com/unsupportedbrowser', 1, NULL, NULL, NULL),
(7, 'facebook', 'https://www.facebook.com/unsupportedbrowser', 2, NULL, NULL, NULL),
(8, 'linkedin', 'https://www.facebook.com/unsupportedbrowser', 2, NULL, NULL, NULL),
(9, 'instagram', 'https://www.facebook.com/unsupportedbrowser', 2, NULL, NULL, NULL),
(10, 'snapchat', 'https://www.facebook.com/unsupportedbrowser', 3, NULL, NULL, NULL),
(11, 'facebook', 'https://www.facebook.com/unsupportedbrowser', 3, NULL, NULL, NULL),
(12, 'facebook', 'https://www.facebook.com/unsupportedbrowser', NULL, 3, NULL, NULL),
(13, 'linkedin', 'https://www.facebook.com/unsupportedbrowser', NULL, 3, NULL, NULL),
(14, 'instagram', 'https://www.facebook.com/unsupportedbrowser', NULL, 3, NULL, NULL),
(15, 'youtube', 'https://www.facebook.com/unsupportedbrowser', NULL, 3, NULL, NULL),
(16, 'whatsapp', 'https://www.facebook.com/unsupportedbrowser', NULL, 3, NULL, NULL),
(17, 'facebook', 'https://www.facebook.com/unsupportedbrowser', NULL, 4, NULL, NULL),
(18, 'twitter', 'https://www.facebook.com/unsupportedbrowser', NULL, 4, NULL, NULL),
(19, 'linkedin', 'https://www.facebook.com/unsupportedbrowser', NULL, 4, NULL, NULL);

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
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `image` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `user_details_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`, `image`, `phone`, `user_details_id`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', 'john.doe@example.com', '$2y$10$AV8NfbM0kW4Vx62O5klFZ.et/1iaFd2qB5mL/a48yZ27pSZNkYPmS', 'employee', 1, 'img/profile_picture.png', '01500403927', 1, '2024-05-05 10:35:42', '2024-05-05 10:35:42'),
(2, 'Jane Smith', 'jane.smith@example.com', '$2y$10$AV8NfbM0kW4Vx62O5klFZ.et/1iaFd2qB5mL/a48yZ27pSZNkYPmS', 'recruiter', 1, 'img/profile_picture.png', '01206403927', 2, '2024-05-05 10:35:42', '2024-05-05 10:35:42'),
(3, 'Michael Johnson', 'michael.johnson@example.com', '$2y$10$AV8NfbM0kW4Vx62O5klFZ.et/1iaFd2qB5mL/a48yZ27pSZNkYPmS', 'employee', 1, 'img/profile_picture.png', '01006805927', 3, '2024-05-05 10:35:42', '2024-05-05 10:35:42'),
(4, 'ziad hassan', 'ziadabaza12345@gmail.com', '$2y$10$zuos77XvdBj.tA/jJio4q.7F4Iloz/8gAcFHcP8lAAIDPEc4GAXIO', 'recruiter', 1, 'img/66425a1643cd9_ziad_hassan.jpg', '01006403927', NULL, NULL, NULL);

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
(1, 'Software Engineer', 'Cairo', 'Bachelor of Science in Computer Science', NULL, '2024-05-05 10:34:13', '2024-05-13 18:19:33'),
(2, 'Network Engineer', 'Alexandria', 'Bachelor of Science in Network Engineering', NULL, '2024-05-05 10:34:13', '2024-05-05 10:34:13'),
(3, 'Data Scientist', 'Giza', 'Master of Science in Data Science', NULL, '2024-05-05 10:34:13', '2024-05-05 10:34:13');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `job_postings`
--
ALTER TABLE `job_postings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `job_requirements`
--
ALTER TABLE `job_requirements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `social_links`
--
ALTER TABLE `social_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
