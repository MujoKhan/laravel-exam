-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2022 at 05:23 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laraexam`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `email_verified_at`, `password`, `permission`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'admin', 'admin1@gmail.com', NULL, '$2y$10$SzUZgxr1t805W0odzAK7Suz9Q6t9U24u288JgWDQMjSJdBPVEKiO2', 'Yes', '2022-03-14 07:17:43', '2022-03-14 23:15:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `class_and_teachers`
--

CREATE TABLE `class_and_teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `class_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `class_and_teachers`
--

INSERT INTO `class_and_teachers` (`id`, `class_id`, `teacher_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 12, 1, NULL, NULL, NULL),
(2, 11, 1, NULL, NULL, NULL),
(3, 11, 2, NULL, NULL, NULL),
(5, 1, 2, '2022-03-15 01:44:53', '2022-03-15 01:44:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exam_attempts`
--

CREATE TABLE `exam_attempts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `std_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_attempts`
--

INSERT INTO `exam_attempts` (`id`, `std_id`, `exam_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 5, 1, 'Yes', '2022-03-12 23:22:12', '2022-03-12 23:22:23', NULL),
(3, 3, 1, 'No', '2022-03-13 00:57:27', '2022-03-13 00:57:27', NULL),
(4, 4, 2, 'Yes', '2022-03-13 01:45:13', '2022-03-13 01:45:15', NULL),
(5, 3, 3, 'Yes', '2022-03-13 05:30:22', '2022-03-13 05:30:27', NULL),
(6, 3, 4, 'Yes', '2022-03-14 00:17:01', '2022-03-14 00:17:02', NULL),
(7, 5, 4, 'Yes', '2022-03-14 00:17:34', '2022-03-14 00:17:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exam_questions`
--

CREATE TABLE `exam_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` int(11) NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `opt1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opt2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opt3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opt4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `answer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ques_num` int(11) DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_questions`
--

INSERT INTO `exam_questions` (`id`, `exam_id`, `question`, `opt1`, `opt2`, `opt3`, `opt4`, `answer`, `ques_num`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'PHP stands for-', 'Hypertext Preprocessor', 'Pretext Hypertext Preprocessor', 'Personal Home Processor', 'None of the above', 'opt1', 2, NULL, '2022-03-12 23:19:32', '2022-03-12 23:19:32', NULL),
(2, 1, 'Variable name in PHP starts with -', '! (Exclamation)', '$ (Dollar)', '& (Ampersand)', '# (Hash)', 'opt2', 2, NULL, '2022-03-12 23:20:06', '2022-03-12 23:20:06', NULL),
(3, 1, 'Which of the following is the default file extension of PHP?', '.php', '.hphp', '.xml', '.html', 'opt1', 1, NULL, '2022-03-12 23:21:15', '2022-03-12 23:21:15', NULL),
(4, 2, 'What is java?', 'Framework', 'tool', 'Programming language', 'None of these', 'opt3', 3, NULL, '2022-03-13 01:43:29', '2022-03-13 01:43:29', NULL),
(5, 3, 'Php exam 2', 'answer a', 'answer b', 'answer c', 'answer d', 'opt2', 1, NULL, '2022-03-13 05:29:31', '2022-03-13 05:29:31', NULL),
(6, 4, 'DS stand for', 'Data Structure', 'Dot space', 'Data Science', 'None of these', 'opt1', 2, NULL, '2022-03-14 00:15:57', '2022-03-14 00:15:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exam_times`
--

CREATE TABLE `exam_times` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `teacher_id` int(100) NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exam_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exam_time` time NOT NULL,
  `exam_date` date NOT NULL,
  `exam_hr` int(50) NOT NULL,
  `exam_min` int(50) NOT NULL,
  `exam_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exam_status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Deactive',
  `exam_done` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_times`
--

INSERT INTO `exam_times` (`id`, `class`, `teacher_id`, `subject`, `exam_title`, `exam_time`, `exam_date`, `exam_hr`, `exam_min`, `exam_description`, `exam_status`, `exam_done`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '11', 1, '1', 'Php 1st exam', '11:48:00', '2022-03-13', 0, 25, 'MCQ base', 'Active', 'Yes', '2022-03-12 23:17:45', '2022-03-14 00:20:30', NULL),
(2, '12', 1, '2', 'Java 1st exam', '12:39:00', '2022-03-13', 0, 20, 'MCQ', 'Active', 'Yes', '2022-03-12 23:18:25', '2022-03-14 00:20:33', NULL),
(3, '11', 1, '1', 'Php exam 2', '16:30:00', '2022-03-13', 0, 20, 'MCQ', 'Active', 'Yes', '2022-03-13 05:28:55', '2022-03-14 00:20:36', NULL),
(4, '11', 1, '4', 'DS 1st term', '11:16:00', '2022-03-14', 0, 20, 'MCQ', 'Active', 'Yes', '2022-03-14 00:14:06', '2022-03-14 00:20:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fedd_backs`
--

CREATE TABLE `fedd_backs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `std_id` int(11) DEFAULT NULL,
  `std_as` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `std_feedback` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_02_22_115044_create_students_table', 2),
(6, '2022_02_22_121626_create_teachers_table', 2),
(7, '2022_02_26_061417_create_subjects_table', 2),
(8, '2022_02_26_062454_create_student_answers_table', 2),
(9, '2022_02_26_062816_create_exam_attempts_table', 2),
(10, '2022_02_26_062945_create_exam_questions_table', 2),
(11, '2022_02_26_064658_create_exam_times_table', 2),
(12, '2022_02_26_065011_create_fedd_backs_table', 2),
(13, '2022_02_26_094152_create_std_classes_table', 3),
(14, '2022_02_27_035624_create_class_and_teachers_table', 4),
(15, '2022_02_27_045526_add_deleted_at_to_subjects_table', 5),
(16, '2022_02_27_045542_add_deleted_at_to_students_table', 5),
(17, '2022_02_27_045602_add_deleted_at_to_teachers_table', 5),
(18, '2022_02_27_045626_add_deleted_at_to_student_answers_table', 5),
(19, '2022_02_27_045650_add_deleted_at_to_exam_attempts_table', 5),
(20, '2022_02_27_045713_add_deleted_at_to_exam_questions_table', 5),
(21, '2022_02_27_045726_add_deleted_at_to_exam_times_table', 5),
(22, '2022_02_27_045744_add_deleted_at_to_fedd_backs_table', 5),
(23, '2022_02_27_045810_add_deleted_at_to_std_classes_table', 5),
(24, '2022_02_27_045828_add_deleted_at_to_class_and_teachers_table', 5),
(25, '2022_03_14_055817_create_supers_table', 6),
(26, '2022_03_14_062045_create_admins_table', 6),
(27, '2022_03_14_062158_add_deleted_at_to_admins_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `std_classes`
--

CREATE TABLE `std_classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `class_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `std_classes`
--

INSERT INTO `std_classes` (`id`, `class_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1', NULL, '2022-03-15 01:11:39', NULL),
(2, '2', NULL, NULL, NULL),
(3, '3', NULL, NULL, NULL),
(4, '4', NULL, NULL, NULL),
(5, '5', NULL, NULL, NULL),
(6, '6', NULL, NULL, NULL),
(7, '7', NULL, NULL, NULL),
(8, '8', NULL, NULL, NULL),
(9, '9', NULL, NULL, NULL),
(10, '10', NULL, NULL, NULL),
(11, '11', NULL, NULL, NULL),
(12, '12', NULL, NULL, NULL),
(14, 'BCA', '2022-03-15 08:46:43', '2022-03-15 08:46:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `dp` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `email`, `phone`, `gender`, `class`, `dob`, `dp`, `email_verified_at`, `password`, `permission`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'khan', 'raja1@gmail.com', '8878789989', 'male', '11', '2022-03-02', NULL, NULL, '$2y$10$Z7oGxWl466uAP/sPrrSnPu7DArlY2/pHKYBLyxuX7vvvUp/UBeazi', 'Yes', NULL, '2022-03-02 07:20:30', '2022-03-15 06:14:48', NULL),
(3, 'Naveen', 'naveen@gmail.com', '1234567890', 'male', '11', '2022-03-03', NULL, NULL, '$2y$10$qwY/DuxItgwz705yvZa6Zeqkn5NqP70X9568sipcLEPSlZ/VHFgwG', 'Yes', NULL, '2022-03-02 07:28:57', '2022-03-06 02:08:48', NULL),
(4, 'mohan', 'mohan@gmail.com', '9787656787', 'male', '12', '2022-03-08', NULL, NULL, '$2y$10$RB7ApsT41iblFwlHPRxFVOYP/g720bRT/CsrHaQ45rSi0Pdh4uR8W', 'Yes', NULL, NULL, '2022-03-06 02:08:36', NULL),
(5, 'arjun', 'arjun@gmail.com', '8878789989', 'male', '11', '2022-03-03', '1647157957.jpg', NULL, '$2y$10$.CAO9q1gFRp5tMjMdSiEyefEb38toWzsPsqXzVtENHcMNqthuhC1K', 'Yes', NULL, '2022-03-06 07:03:57', '2022-03-13 02:22:37', NULL),
(6, 'prakash', 'prakash@gmail.com', '7687656765', 'male', '12', '2003-06-18', NULL, NULL, '$2y$10$niVyqcmjpx8JXIGkwUztyeVeem3enYKm6bVCDZ8QOflvllcUx.V42', 'No', NULL, '2022-03-15 05:34:11', '2022-03-15 05:34:11', NULL),
(7, 'danish', 'danish@gmail.com', '5676567898', 'male', 'Class:-', '2022-03-16', NULL, NULL, '$2y$10$PqIz/ks74pM0Len4OlFXMuyMf1J7ox5CcAXZI8tkklY9sDZGBhacC', 'No', NULL, '2022-03-15 05:42:52', '2022-03-15 05:42:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_answers`
--

CREATE TABLE `student_answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `std_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `std_answer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_answers`
--

INSERT INTO `student_answers` (`id`, `std_id`, `exam_id`, `question_id`, `std_answer`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 5, 1, 1, 'opt1', '2022-03-12 23:22:12', '2022-03-12 23:22:12', NULL),
(2, 5, 1, 2, 'opt3', '2022-03-12 23:22:18', '2022-03-12 23:22:18', NULL),
(3, 5, 1, 3, 'opt2', '2022-03-12 23:22:22', '2022-03-12 23:22:22', NULL),
(7, 3, 1, 1, 'opt1', '2022-03-13 00:57:27', '2022-03-13 00:57:27', NULL),
(8, 3, 1, 2, 'opt2', '2022-03-13 00:57:30', '2022-03-13 00:57:30', NULL),
(9, 4, 2, 4, 'opt3', '2022-03-13 01:45:13', '2022-03-13 01:45:13', NULL),
(10, 3, 3, 5, 'opt3', '2022-03-13 05:30:22', '2022-03-13 05:30:22', NULL),
(11, 3, 4, 6, 'opt2', '2022-03-14 00:17:01', '2022-03-14 00:17:01', NULL),
(12, 5, 4, 6, 'opt1', '2022-03-14 00:17:34', '2022-03-14 00:17:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sub_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_id` int(100) NOT NULL,
  `teacher_id` int(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `sub_name`, `class_id`, `teacher_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Php', 11, 1, '2022-03-12 23:16:53', '2022-03-12 23:16:53', NULL),
(2, 'Java', 12, 1, '2022-03-12 23:16:59', '2022-03-12 23:16:59', NULL),
(3, 'English', 11, 2, '2022-03-13 01:21:43', '2022-03-13 01:21:43', NULL),
(4, 'DS', 11, 1, '2022-03-14 00:13:24', '2022-03-14 00:13:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supers`
--

CREATE TABLE `supers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supers`
--

INSERT INTO `supers` (`id`, `name`, `email`, `email_verified_at`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Super', 'superadmin@gmail.com', NULL, '$2y$10$auixzEZvMoyt5HmTTa0EyOYycG3GcXW8YCR1uiYUtOXg4b7bET73i', '2022-03-14 06:11:50', '2022-03-14 06:29:38');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dp` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permission` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `email`, `phone`, `dob`, `gender`, `password`, `dp`, `permission`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'khan', 'khan@gmail.com', '5665678756', '2012-02-22', 'male', '$2y$10$uwnAEp10qC3ruYHTPO9FkuR7A1/es7TN22TsOVIQ1iXxRQX0kTGyu', '1647157967.jpg', 'Yes', NULL, '2022-03-15 00:21:28', NULL),
(2, 'anant', 'anant@gmail.com', '6567766567', '2012-03-15', 'male', '$2y$10$m4fnxEmEA/xdP.UhRShhp.R777kU2cqq5LuLOFL4Q2bLLzBPM3JGq', '1647154327.jpg', 'Yes', NULL, '2022-03-15 00:21:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Indexes for table `class_and_teachers`
--
ALTER TABLE `class_and_teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_attempts`
--
ALTER TABLE `exam_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_questions`
--
ALTER TABLE `exam_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_times`
--
ALTER TABLE `exam_times`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fedd_backs`
--
ALTER TABLE `fedd_backs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `std_classes`
--
ALTER TABLE `std_classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_email_unique` (`email`);

--
-- Indexes for table `student_answers`
--
ALTER TABLE `student_answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supers`
--
ALTER TABLE `supers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `supers_email_unique` (`email`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `class_and_teachers`
--
ALTER TABLE `class_and_teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `exam_attempts`
--
ALTER TABLE `exam_attempts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `exam_questions`
--
ALTER TABLE `exam_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `exam_times`
--
ALTER TABLE `exam_times`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fedd_backs`
--
ALTER TABLE `fedd_backs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `std_classes`
--
ALTER TABLE `std_classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `student_answers`
--
ALTER TABLE `student_answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `supers`
--
ALTER TABLE `supers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
