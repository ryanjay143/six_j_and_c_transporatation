-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2023 at 02:00 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `6j&c_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `billings`
--

CREATE TABLE `billings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_num` varchar(200) NOT NULL,
  `billing_start_date` date DEFAULT NULL,
  `billing_end_date` date DEFAULT NULL,
  `total_amount` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 0 COMMENT '0 = Unpaid 1 = Paid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `billings`
--

INSERT INTO `billings` (`id`, `client_id`, `invoice_num`, `billing_start_date`, `billing_end_date`, `total_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'INV-2-20231031175707', '2023-09-15', '2023-09-30', '5,700', 1, '2023-10-03 01:45:50', '2023-10-03 12:22:06'),
(2, 45, 'INV-45-20231031175708', '2023-09-16', '2023-09-30', '4,500', 1, '2023-10-03 11:13:08', '2023-10-03 13:21:26'),
(4, 2, 'INV-3-202310311757010', '2023-09-21', '2023-09-30', '5,700', 1, '2023-10-20 05:56:09', '2023-10-20 05:58:16'),
(5, 2, 'INV-2-202310311757011', '2023-09-21', '2023-09-30', '5,700', 1, '2023-10-31 08:12:44', '2023-10-31 08:19:01'),
(6, 2, 'INV-2-202310311757012', '2023-10-01', '2023-10-15', '3,000', 1, '2023-10-21 01:33:51', '2023-10-21 01:35:29'),
(11, 45, 'INV-45-20231031175706', '2023-09-22', '2023-10-31', '5,600', 1, '2023-10-31 09:57:06', '2023-10-31 10:07:42'),
(12, 2, 'INV-2-20231109003754', '2023-09-21', '2023-09-30', '8,900', 1, '2023-11-08 16:37:54', '2023-11-26 01:25:06'),
(13, 2, 'INV-2-20231020181218', '2023-10-16', '2023-10-31', '13,000', 1, '2023-10-20 10:12:18', '2023-12-07 17:51:32'),
(14, 2, 'INV-2-20231124235439', '2023-11-16', '2023-11-30', '2,000', 0, '2023-11-24 23:54:39', '2023-11-24 23:54:39');

-- --------------------------------------------------------

--
-- Table structure for table `billing_details`
--

CREATE TABLE `billing_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `billing_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transportation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `tons` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `billing_details`
--

INSERT INTO `billing_details` (`id`, `billing_id`, `transportation_id`, `price`, `tons`, `created_at`, `updated_at`) VALUES
(1, 1, 6, '100', '20', '2023-10-03 01:45:50', '2023-10-03 01:45:50'),
(2, 1, 8, '100', '24', '2023-10-03 01:45:50', '2023-10-03 01:45:50'),
(3, 1, 16, '100', '13', '2023-10-03 01:45:50', '2023-10-03 01:45:50'),
(4, 2, 9, '100', '20', '2023-10-03 11:13:08', '2023-10-03 11:13:08'),
(5, 2, 10, '100', '12', '2023-10-03 11:13:08', '2023-10-03 11:13:08'),
(6, 2, 11, '100', '13', '2023-10-03 11:13:08', '2023-10-03 11:13:08'),
(10, 4, 6, '100', '20', '2023-10-20 05:56:09', '2023-10-20 05:56:09'),
(11, 4, 8, '100', '24', '2023-10-20 05:56:09', '2023-10-20 05:56:09'),
(12, 4, 16, '100', '13', '2023-10-20 05:56:09', '2023-10-20 05:56:09'),
(13, 5, 6, '100', '20', '2023-10-31 08:12:44', '2023-10-31 08:12:44'),
(14, 5, 8, '100', '24', '2023-10-31 08:12:44', '2023-10-31 08:12:44'),
(15, 5, 16, '100', '13', '2023-10-31 08:12:44', '2023-10-31 08:12:44'),
(16, 6, 22, '100', '17', '2023-10-21 01:33:51', '2023-10-21 01:33:51'),
(17, 6, 23, '100', '13', '2023-10-21 01:33:51', '2023-10-21 01:33:51'),
(26, 11, 9, '100', '20', '2023-10-31 09:57:06', '2023-10-31 09:57:06'),
(27, 11, 11, '100', '13', '2023-10-31 09:57:06', '2023-10-31 09:57:06'),
(28, 11, 10, '100', '12', '2023-10-31 09:57:06', '2023-10-31 09:57:06'),
(29, 11, 13, '100', '11', '2023-10-31 09:57:06', '2023-10-31 09:57:06'),
(30, 12, 6, '100', '20', '2023-11-08 16:37:54', '2023-11-08 16:37:54'),
(31, 12, 8, '100', '24', '2023-11-08 16:37:54', '2023-11-08 16:37:54'),
(32, 12, 16, '100', '13', '2023-11-08 16:37:54', '2023-11-08 16:37:54'),
(33, 12, 35, '100', '11', '2023-11-08 16:37:54', '2023-11-08 16:37:54'),
(34, 12, 17, '100', '9', '2023-11-08 16:37:54', '2023-11-08 16:37:54'),
(35, 12, 34, '100', '12', '2023-11-08 16:37:54', '2023-11-08 16:37:54'),
(36, 13, 36, '1000', '13', '2023-10-20 10:12:18', '2023-10-20 10:12:18'),
(37, 14, 38, NULL, NULL, '2023-11-24 23:54:39', '2023-11-24 23:54:39'),
(38, 14, 39, NULL, NULL, '2023-11-24 23:54:39', '2023-11-24 23:54:39'),
(39, 14, 41, NULL, NULL, '2023-11-24 23:54:39', '2023-11-24 23:54:39'),
(40, 14, 42, '100', '20', '2023-11-24 23:54:39', '2023-11-24 23:54:39'),
(41, 14, 43, NULL, NULL, '2023-11-24 23:54:39', '2023-11-24 23:54:39');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pickUp_date` date NOT NULL,
  `transportation_date` date NOT NULL,
  `origin` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `tons` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 = Pending 1 = Approved',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `pickUp_date`, `transportation_date`, `origin`, `destination`, `tons`, `status`, `created_at`, `updated_at`) VALUES
(9, 2, '2023-09-21', '2023-09-22', 'Cagayan de Oro', 'Ozamiz City', 20, 1, '2023-09-21 01:56:57', '2023-09-21 11:13:05'),
(10, 2, '2023-09-22', '2023-09-23', 'Cagayan de Oro', 'Iligan City', 24, 1, '2023-09-22 00:26:05', '2023-09-22 11:18:02'),
(11, 45, '2023-09-22', '2023-09-23', 'Iligan City', 'Pagadian City', 20, 1, '2023-09-22 01:26:23', '2023-09-22 06:08:24'),
(12, 45, '2023-09-27', '2023-09-28', 'Pagadian City', 'Zamboanga', 13, 1, '2023-09-22 02:53:26', '2023-09-27 10:59:31'),
(13, 45, '2023-09-26', '2023-09-27', 'Iligan City', 'Zamboanga', 12, 1, '2023-09-22 04:19:11', '2023-09-26 13:33:48'),
(14, 45, '2023-09-28', '2023-09-29', 'Iligan City', 'Ozamiz City', 11, 1, '2023-09-22 04:31:30', '2023-09-28 09:47:24'),
(16, 2, '2023-09-26', '2023-09-27', 'Pagadian City', 'Cagayan de Oro', 13, 1, '2023-09-25 23:53:55', '2023-09-26 09:09:16'),
(18, 2, '2023-09-28', '2023-09-29', 'Zamboanga', 'Ozamiz City', 11, 1, '2023-09-26 01:46:34', '2023-09-28 09:12:00'),
(19, 2, '2023-09-29', '2023-09-30', 'Cagayan de Oro', 'Iligan City', 9, 1, '2023-09-26 06:15:57', '2023-09-29 13:51:55'),
(20, 2, '2023-09-27', '2023-09-28', 'Cagayan de Oro', 'Iligan City', 12, 1, '2023-09-02 00:34:18', '2023-09-27 15:05:59'),
(23, 2, '2023-10-13', '2023-10-14', 'Cagayan de Oro', 'Iligan City', 17, 1, '2023-10-06 02:32:55', '2023-10-13 03:10:09'),
(24, 2, '2023-10-06', '2023-10-07', 'Cagayan de Oro', 'Iligan City', 13, 1, '2023-10-06 02:36:28', '2023-10-06 07:21:54'),
(25, 3, '2023-10-19', '2023-10-20', 'Iligan City', 'Zamboanga', 14, 1, '2023-10-11 00:25:43', '2023-10-19 09:21:04'),
(26, 3, '2023-10-13', '2023-10-14', 'Cagayan de Oro', 'Iligan City', 15, 1, '2023-10-11 06:26:15', '2023-10-13 11:26:23'),
(27, 3, '2023-10-17', '2023-10-18', 'Cagayan de Oro', 'Ozamiz City', 7, 1, '2023-10-16 04:26:14', '2023-10-17 15:32:13'),
(29, 2, '2023-10-18', '2023-10-19', 'Iligan City', 'Zamboanga', 10, 1, '2023-10-17 16:56:54', '2023-10-18 12:39:25'),
(31, 3, '2023-10-20', '2023-10-21', 'Pagadian City', 'Zamboanga', 19, 1, '2023-10-19 16:22:57', '2023-10-20 10:41:46'),
(36, 2, '2023-10-21', '2023-10-21', 'Cagayan de Oro', 'Iligan City', 13, 1, '2023-10-21 01:24:19', '2023-10-21 01:30:44'),
(37, 2, '2023-11-11', '2023-11-11', 'Cagayan de Oro', 'Iligan City', NULL, 1, '2023-11-11 01:22:51', '2023-11-11 01:22:51'),
(38, 2, '2023-11-25', '2023-11-26', 'Cagayan de Oro', 'Iligan City', NULL, 1, '2023-11-16 15:24:53', '2023-11-21 10:04:40'),
(39, 2, '2023-11-17', '2023-11-18', 'Cagayan de Oro', 'Pagadian City', NULL, 1, '2023-11-16 15:26:59', '2023-11-16 17:16:04'),
(40, 2, '2023-11-20', '2023-11-21', 'Ozamiz City', 'Pagadian City', NULL, 1, '2023-11-16 15:28:15', '2023-12-03 18:54:59'),
(41, 2, '2023-11-21', '2023-11-23', 'Cagayan de Oro', 'Davao', NULL, 1, '2023-11-16 15:34:12', '2023-11-21 10:32:14'),
(42, 2, '2023-11-27', '2023-11-27', 'Cagayan de Oro', 'Iligan City', 13, 1, '2023-11-16 15:37:58', '2023-11-27 09:05:38'),
(43, 2, '2023-11-29', '2023-11-30', 'Iligan City', 'Ozamiz City', NULL, 0, '2023-11-16 15:42:04', '2023-11-16 15:42:04'),
(44, 2, '2023-11-24', '2023-11-25', 'Iligan City', 'Iligan City', 20, 1, '2023-11-16 15:57:07', '2023-11-24 23:33:14'),
(45, 2, '2023-11-30', '2023-11-30', 'Iligan City', 'Pagadian City', NULL, 1, '2023-11-16 16:01:03', '2023-11-30 15:18:53'),
(49, 3, '2023-11-27', '2023-11-28', 'Iligan City', 'Pagadian City', 11, 1, '2023-11-16 17:35:26', '2023-11-27 09:18:41'),
(50, 2, '2023-12-01', '2023-12-02', 'Cagayan de Oro', 'Zamboanga', NULL, 1, '2023-11-16 18:27:13', '2023-12-01 13:51:17'),
(51, 2, '2023-11-23', '2023-11-24', 'Cagayan de Oro', 'Iligan City', NULL, 1, '2023-11-23 21:51:14', '2023-11-23 21:51:14'),
(52, 2, '2023-12-08', '2023-12-08', 'Cagayan de Oro', 'Iligan City', NULL, 0, '2023-12-07 16:12:14', '2023-12-07 16:12:14');

-- --------------------------------------------------------

--
-- Table structure for table `cash_advances`
--

CREATE TABLE `cash_advances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `c_amount` varchar(255) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `pay_seq` int(11) DEFAULT NULL,
  `c_pay_sequence` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 0 COMMENT '0 = Not Complete 1 = Completed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cash_advances`
--

INSERT INTO `cash_advances` (`id`, `employee_id`, `amount`, `c_amount`, `purpose`, `pay_seq`, `c_pay_sequence`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '0', '2000', 'utang', 0, 3, 1, '2023-09-21 00:52:12', '2023-09-27 17:03:26'),
(2, 1, '0', '1000', 'pang gatas', 0, 3, 1, '2023-09-27 14:27:51', '2023-10-30 03:44:31'),
(3, 2, '750', '3000', 'pang gatas', 1, 4, 0, '2023-09-27 14:42:46', '2023-11-24 23:49:44'),
(4, 4, '2000', '2000', 'hospital bill', 4, 4, 0, '2023-09-27 15:00:56', '2023-09-27 15:00:56'),
(5, 1, '0', '3000', 'pang check-up', 0, 4, 1, '2023-09-27 17:04:42', '2023-09-30 11:39:16');

-- --------------------------------------------------------

--
-- Table structure for table `ca_details`
--

CREATE TABLE `ca_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ca_id` bigint(20) UNSIGNED DEFAULT NULL,
  `paid_amount` varchar(255) DEFAULT NULL,
  `balance` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ca_details`
--

INSERT INTO `ca_details` (`id`, `ca_id`, `paid_amount`, `balance`, `created_at`, `updated_at`) VALUES
(5, 1, '667', '1333', '2023-09-27 16:27:01', '2023-09-27 16:27:01'),
(6, 1, '667', '666.3333333333', '2023-09-27 16:55:48', '2023-09-27 16:55:48'),
(8, 1, '667', '0', '2023-09-27 17:03:26', '2023-09-27 17:03:26'),
(9, 2, '333', '667', '2023-09-30 08:37:49', '2023-09-30 08:37:49'),
(10, 2, '333', '333.66666666667', '2023-10-01 01:43:02', '2023-10-01 01:43:02'),
(11, 2, '333', '0.33333333334002', '2023-10-30 03:44:31', '2023-10-30 03:44:31'),
(12, 5, '750', '2250', '2023-09-30 10:58:58', '2023-09-30 10:58:58'),
(13, 5, '750', '1500', '2023-09-30 11:07:18', '2023-09-30 11:07:18'),
(14, 5, '750', '750', '2023-09-30 11:14:24', '2023-09-30 11:14:24'),
(15, 5, '750', '0', '2023-09-30 11:37:15', '2023-09-30 11:37:15'),
(16, 5, '750', '0', '2023-09-30 11:39:16', '2023-09-30 11:39:16'),
(17, 3, '750', '2250', '2023-11-20 09:35:20', '2023-11-20 09:35:20'),
(18, 3, '750', '1500', '2023-11-20 09:49:08', '2023-11-20 09:49:08'),
(19, 3, '750', '750', '2023-11-24 23:49:44', '2023-11-24 23:49:44'),
(20, NULL, NULL, '0', '2023-11-27 01:08:39', '2023-11-27 01:08:39'),
(21, NULL, NULL, '0', '2023-12-01 13:43:14', '2023-12-01 13:43:14'),
(22, NULL, NULL, '0', '2023-12-01 13:43:45', '2023-12-01 13:43:45');

-- --------------------------------------------------------

--
-- Table structure for table `damages`
--

CREATE TABLE `damages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date_of_incidence` date DEFAULT NULL,
  `deduction` int(11) DEFAULT NULL,
  `c_deduction` varchar(200) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `damage_sequence` int(11) DEFAULT NULL,
  `c_term` int(11) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `damages`
--

INSERT INTO `damages` (`id`, `employee_id`, `date_of_incidence`, `deduction`, `c_deduction`, `description`, `damage_sequence`, `c_term`, `photo`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '2023-09-01', 0, '5000', 'bagngga', 0, 4, 'damage_photos/baEaoeJeyTFG9luKgDl2Qapf9LDmj7Tl4k38W4sC.png', 1, '2023-09-21 00:54:24', '2023-09-27 17:03:26'),
(2, 1, '2023-09-21', 0, '3500', 'bangga', 0, 3, 'damage_photos/X8vTKz7fp7NxtsGvY6sgkBE9bcd2Bf5ooEFki1Qc.png', 1, '2023-09-26 15:15:05', '2023-10-01 01:43:02'),
(3, 2, '2023-09-07', 2501, '5000', 'bangga', 3, 6, 'damage_photos/seqb1NeAXTIY0vveaqHCjZATCUJe9TsUITZC0RzR.png', 0, '2023-09-27 14:44:25', '2023-11-24 23:49:44'),
(4, 1, '2023-09-26', 0, '5000', 'bangga', 0, 4, 'damage_photos/MBYLUXAJbmUjzZacTaDtkU6VcugIIG2kCUlGmELN.png', 1, '2023-09-27 17:05:39', '2023-09-30 11:14:24');

-- --------------------------------------------------------

--
-- Table structure for table `damage_details`
--

CREATE TABLE `damage_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `d_id` bigint(20) UNSIGNED DEFAULT NULL,
  `paid_amount` varchar(255) NOT NULL,
  `balance` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `damage_details`
--

INSERT INTO `damage_details` (`id`, `d_id`, `paid_amount`, `balance`, `created_at`, `updated_at`) VALUES
(1, 1, '1250', '3750', '2023-09-26 15:16:34', '2023-09-26 15:16:34'),
(2, 1, '1250', '2500', '2023-09-27 16:10:11', '2023-09-27 16:10:11'),
(4, 1, '1250', '1250', '2023-09-27 16:20:49', '2023-09-27 16:20:49'),
(7, 2, '1166.6666666667', '2333.3333333333', '2023-09-27 16:58:17', '2023-09-27 16:58:17'),
(8, 1, '1250', '0', '2023-09-27 17:03:26', '2023-09-27 17:03:26'),
(9, 2, '1166.5', '1166.5', '2023-09-30 08:37:49', '2023-09-30 08:37:49'),
(10, 2, '1167', '0', '2023-10-01 01:43:02', '2023-10-01 01:43:02'),
(11, 4, '1250', '3750', '2023-10-30 03:44:31', '2023-10-30 03:44:31'),
(12, 4, '1250', '2500', '2023-09-30 10:58:58', '2023-09-30 10:58:58'),
(13, 4, '1250', '1250', '2023-09-30 11:07:18', '2023-09-30 11:07:18'),
(14, 4, '1250', '0', '2023-09-30 11:14:24', '2023-09-30 11:14:24'),
(15, NULL, '0', '0', '2023-09-30 11:39:16', '2023-09-30 11:39:16'),
(16, 3, '833.33333333333', '4166.6666666667', '2023-11-20 09:35:20', '2023-11-20 09:35:20'),
(17, 3, '833.4', '3333.6', '2023-11-20 09:49:08', '2023-11-20 09:49:08'),
(18, 3, '833.5', '2500.5', '2023-11-24 23:49:44', '2023-11-24 23:49:44'),
(19, NULL, '0', '0', '2023-11-27 01:08:39', '2023-11-27 01:08:39'),
(20, NULL, '0', '0', '2023-12-01 13:43:14', '2023-12-01 13:43:14'),
(21, NULL, '0', '0', '2023-12-01 13:43:45', '2023-12-01 13:43:45');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `dob` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `position` varchar(255) NOT NULL DEFAULT '0' COMMENT '0 = driver 1 = helper',
  `photo` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `user_id`, `dob`, `address`, `position`, `photo`, `created_at`, `updated_at`) VALUES
(1, 4, '1998-09-06', 'Santa Ana Tagoloan Misamis Oriental', '0', 'profile_photos/tChfAGnEx6LyIBZJlt4eVNKgMcoUIAxafdDCACaL.jpg', '2023-06-17 08:09:01', '2023-12-01 13:47:43'),
(2, 5, '1995-01-17', 'abellanosa st. brgy 17', '0', 'profile_photos/z7v5p8sUMibsxCS0U5LGfMke5zw2YjCYS1t3pvx4.jpg', '2023-06-17 19:44:26', '2023-11-30 00:33:31'),
(3, 18, '2023-06-22', 'CDO', '1', 'profile-photos/zVE9nFneXwS3VIGQz3FWTSoFSfR9wVYFqVHMX7Zr.jpg', '2023-06-22 08:41:24', '2023-11-30 00:55:11'),
(4, 19, '1998-03-15', 'Cugman, Cagayan de Oro', '0', 'profile_photos/umjGyaRnhtfa0xsi9PDWhT5BPf2qSRVi8HNk0x08.jpg', '2023-06-28 02:59:38', '2023-11-30 00:37:18'),
(5, 22, '2023-07-12', 'Nazareth, Cagayan de Oro, City', '1', 'profile-photos/xpJGodOyjwVwvfBQLblVVt1LF4Fv9juAOT7SurFq.jpg', '2023-07-12 15:24:53', '2023-08-11 00:22:49'),
(6, 29, '2003-08-09', 'CDO', '0', 'profile_photos/bkdOt8q0RO9g5KjcxILfOYjRZfVDG3AnZYRAuVmK.jpg', '2023-07-20 15:17:38', '2023-11-30 00:38:53'),
(10, 33, '1997-09-14', 'Agora, Lapasan CDO', '1', 'profile-photos/ebIqRAFm8WqmDAMT8Cv8quuYiVGB3YA2Xaju8AD4.jpg', '2023-08-01 05:56:42', '2023-08-09 14:54:28'),
(11, 34, '1998-01-01', 'CDO', '0', 'profile_photos/sVwor5gDu5RYdUGALU50H74KTRt4gTjp7PI7hqrU.jpg', '2023-08-01 05:58:32', '2023-11-30 00:45:54'),
(12, 35, '1998-02-26', 'CDO', '1', 'profile-photos/d33UfdRniC5ek3kdRih3CF8raUhVGzFF4vT5DJOP.jpg', '2023-08-01 05:59:22', '2023-08-09 14:55:05'),
(14, 37, '1997-02-01', 'CDO', '1', 'profile-photos/Q0Obf6uXm2O1FmpweuDFqogA7yRlEzw7LTY5X2rd.jpg', '2023-08-01 06:03:51', '2023-08-09 14:55:37'),
(15, 38, '1998-10-08', 'Santa Ana Tagoloan Misamis Oriental', '0', '', '2023-08-08 09:23:47', '2023-08-08 09:23:47');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(8, '2023_07_15_133931_create_billing_details_table', 5),
(11, '2023_07_26_004944_create_biilings_table', 8),
(42, '2023_06_22_213651_create_trucks_table', 31),
(57, '2023_07_26_004944_create_billings_table', 45),
(58, '2023_07_26_005613_create_billing_details_table', 46),
(59, '2023_06_24_122656_create_bookings_table', 47),
(60, '2023_07_24_181826_create_cash_advances_table', 48),
(61, '2023_08_28_192344_create_ca_details_table', 49),
(62, '2023_07_24_210643_create_damages_table', 50),
(63, '2023_09_04_095654_create_damage_details_table', 51),
(64, '2023_08_20_103922_create_payments_table', 52),
(65, '2023_07_27_194714_create_payrolls_table', 53),
(66, '2023_07_29_213552_create_payroll_details_table', 54),
(67, '2023_06_28_094043_create_transportation_details_table', 55),
(68, '2023_09_22_133837_create_transportation_statuses_table', 56),
(69, '2023_09_22_133837_create_transportation_status_table', 57),
(70, '2023_09_22_140401_create_updated_times_table', 58),
(71, '2023_10_06_100443_create_truck_information_table', 59);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('alpha@gmail.com', '$2y$10$r8WUpQnerefD9hwBWKssv.JR9EY/XioKmH26VdMithnbTqz7b/jce', '2023-08-15 07:03:27'),
('judphiland@gmail.com', '$2y$10$xDQii5w0OPa6fmCv7/5yuO5U6sVa7t/TzBDzG7nMcwb4ytoUZ7F7K', '2023-08-17 14:39:28'),
('nicolas@gmail.com', '$2y$10$ytGSXNuJeeTTSNKCkS6ZDOlTWjUqN2onfA1N/cwRmDZthtEBfrGJu', '2023-08-17 14:42:33'),
('admin@gmail.com', '$2y$10$6uu.lEkuCiCqI1MrnkTTAukL4L8S8w.o0Yz6bsRqvbCr.6MzdWSK6', '2023-11-10 14:39:45'),
('ryanjaytagolimotreyes@gmail.com', '$2y$10$i4OeYjHfVfcb2le.0MRcUOWculO29InJIt0yrQK0gHFndbNQN.YA6', '2023-11-29 21:01:51');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `billing_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `ref_num` varchar(255) DEFAULT NULL,
  `chique_num` varchar(255) DEFAULT NULL,
  `or_num` varchar(255) DEFAULT NULL,
  `amount` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `billing_id`, `payment_method`, `ref_num`, `chique_num`, `or_num`, `amount`, `created_at`, `updated_at`) VALUES
(1, 1, 'Bank Transfer', '1001112', NULL, '202310032022063627', '5700', '2023-10-03 12:22:06', '2023-10-03 12:22:06'),
(2, 2, 'Cash', 'CASHREF773', NULL, '202310032121261591', '4500', '2023-10-03 13:21:26', '2023-10-03 13:21:26'),
(3, 4, 'Bank Transfer', '1001112', NULL, '202310201358162545', '5700', '2023-10-20 05:58:16', '2023-10-20 05:58:16'),
(4, 5, 'Cash', 'CASHREF7738', NULL, '202310311619019495', '5700', '2023-10-31 08:19:01', '2023-10-31 08:19:01'),
(5, 6, 'Cash', 'CASHREF7739', NULL, '202310210935293784', '3000', '2023-10-21 01:35:29', '2023-10-21 01:35:29'),
(6, 11, 'Cheque', NULL, '11122233', '202310311807421303', '5600', '2023-10-31 10:07:42', '2023-10-31 10:07:42'),
(7, 12, 'Cash', 'CASHREF6397', NULL, '202311260125067815', '8900', '2023-11-26 01:25:06', '2023-11-26 01:25:06'),
(8, 13, 'Cheque', NULL, '11110000', '202312080151328852', '13000', '2023-12-07 17:51:32', '2023-12-07 17:51:32');

-- --------------------------------------------------------

--
-- Table structure for table `payrolls`
--

CREATE TABLE `payrolls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `total_deduction` varchar(255) DEFAULT NULL,
  `ca_deduction` varchar(255) DEFAULT NULL,
  `df_deduction` varchar(255) DEFAULT NULL,
  `total_rate` varchar(255) DEFAULT NULL,
  `total_net_salary` varchar(255) DEFAULT NULL,
  `payroll_start_date` date DEFAULT NULL,
  `payroll_end_date` date DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 = Unpaid 1 = Paid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payrolls`
--

INSERT INTO `payrolls` (`id`, `employee_id`, `total_deduction`, `ca_deduction`, `df_deduction`, `total_rate`, `total_net_salary`, `payroll_start_date`, `payroll_end_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '1917', '667', '1250', '5000', '3083', '2023-09-12', '2023-09-26', 1, '2023-09-26 15:16:34', '2023-11-11 08:20:38'),
(2, 1, '1917', '667', '1250', '5000', '3083', '2023-09-14', '2023-09-28', 1, '2023-09-27 16:10:11', '2023-09-30 08:39:14'),
(9, 1, '1500', '333', '1167', '5000', '3500', '2023-09-15', '2023-09-30', 1, '2023-09-30 08:37:49', '2023-09-30 08:38:59'),
(10, 1, '1500', '333', '1167', '3000', '1500', '2023-09-16', '2023-09-30', 1, '2023-10-01 01:43:02', '2023-11-21 02:37:59'),
(11, 1, '1583', '333', '1250', '2000', '417', '2023-10-17', '2023-10-18', 0, '2023-10-30 03:44:30', '2023-10-30 03:44:30'),
(12, 1, '2000', '750', '1250', '3000', '1000', '2023-09-16', '2023-09-30', 0, '2023-09-30 10:58:58', '2023-09-30 10:58:58'),
(13, 1, '2000', '750', '1250', '3000', '1000', '2023-09-15', '2023-09-30', 0, '2023-09-30 11:07:18', '2023-09-30 11:07:18'),
(14, 1, '2000', '750', '1250', '3000', '1000', '2023-09-15', '2023-09-30', 0, '2023-09-30 11:14:24', '2023-09-30 11:14:24'),
(15, 1, '750', '750', NULL, '3000', '2250', '2023-09-16', '2023-09-30', 0, '2023-09-30 11:37:15', '2023-09-30 11:37:15'),
(16, 1, '750', '750', NULL, '3000', '2250', '2023-09-16', '2023-09-30', 1, '2023-09-30 11:39:16', '2023-11-11 08:20:52'),
(17, 1, NULL, NULL, NULL, '1000', '1000', '2023-10-01', '2023-10-15', 1, '2023-10-15 11:40:50', '2023-10-31 09:39:01'),
(19, 2, '1583', '750', '833', '3000', '1417', '2023-11-16', '2023-11-30', 1, '2023-11-20 09:49:08', '2023-11-22 13:24:23'),
(20, 2, '1584', '750', '834', '5000', '3416', '2023-11-16', '2023-11-30', 1, '2023-11-24 23:49:44', '2023-11-24 23:52:33'),
(21, 5, NULL, NULL, NULL, '4000', '4000', '2023-11-16', '2023-11-30', 0, '2023-11-27 01:08:39', '2023-11-27 01:08:39'),
(22, 12, NULL, NULL, NULL, '3000', '3000', '2023-11-16', '2023-11-30', 0, '2023-12-01 13:43:14', '2023-12-01 13:43:14'),
(23, 1, NULL, NULL, NULL, '3000', '3000', '2023-11-16', '2023-11-30', 0, '2023-12-01 13:43:45', '2023-12-01 13:43:45');

-- --------------------------------------------------------

--
-- Table structure for table `payroll_details`
--

CREATE TABLE `payroll_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payroll_id` bigint(20) UNSIGNED NOT NULL,
  `transportation_id` bigint(20) UNSIGNED NOT NULL,
  `rate` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payroll_details`
--

INSERT INTO `payroll_details` (`id`, `payroll_id`, `transportation_id`, `rate`, `created_at`, `updated_at`) VALUES
(1, 1, 6, '5000', '2023-09-26 15:16:34', '2023-09-26 15:16:34'),
(2, 2, 6, '5000', '2023-09-27 16:10:11', '2023-09-27 16:10:11'),
(9, 9, 6, '5000', '2023-09-30 08:37:49', '2023-09-30 08:37:49'),
(10, 10, 6, '1000', '2023-10-01 01:43:02', '2023-10-01 01:43:02'),
(11, 10, 9, '1000', '2023-10-01 01:43:02', '2023-10-01 01:43:02'),
(12, 10, 10, '1000', '2023-10-01 01:43:02', '2023-10-01 01:43:02'),
(13, 11, 26, '1000', '2023-10-30 03:44:30', '2023-10-30 03:44:30'),
(14, 11, 28, '1000', '2023-10-30 03:44:30', '2023-10-30 03:44:30'),
(15, 15, 6, '1000', '2023-09-30 11:37:15', '2023-09-30 11:37:15'),
(16, 15, 9, '1000', '2023-09-30 11:37:15', '2023-09-30 11:37:15'),
(17, 15, 10, '1000', '2023-09-30 11:37:15', '2023-09-30 11:37:15'),
(18, 16, 6, '1000', '2023-09-30 11:39:16', '2023-09-30 11:39:16'),
(19, 16, 9, '1000', '2023-09-30 11:39:16', '2023-09-30 11:39:16'),
(20, 16, 10, '1000', '2023-09-30 11:39:16', '2023-09-30 11:39:16'),
(21, 17, 25, '1000', '2023-10-15 11:40:50', '2023-10-15 11:40:50'),
(26, 19, 17, '1000', '2023-11-20 09:49:08', '2023-11-20 09:49:08'),
(27, 19, 22, '1000', '2023-11-20 09:49:08', '2023-11-20 09:49:08'),
(28, 19, 24, '1000', '2023-11-20 09:49:08', '2023-11-20 09:49:08'),
(29, 20, 42, '5000', '2023-11-24 23:49:44', '2023-11-24 23:49:44'),
(30, 23, 25, '1000', '2023-12-01 13:43:45', '2023-12-01 13:43:45'),
(31, 23, 26, '1000', '2023-12-01 13:43:45', '2023-12-01 13:43:45'),
(32, 23, 28, '1000', '2023-12-01 13:43:45', '2023-12-01 13:43:45');

-- --------------------------------------------------------

--
-- Table structure for table `transportation_details`
--

CREATE TABLE `transportation_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `driver_id` bigint(20) UNSIGNED DEFAULT NULL,
  `helper_id` bigint(20) UNSIGNED DEFAULT NULL,
  `truck_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(255) DEFAULT '1' COMMENT '1 = To be pick-up 2 = To be picked-up 3 = Departure 4 = In Route 5 = Delivered',
  `b_status` int(200) NOT NULL DEFAULT 0 COMMENT '0 = Unpaid 1 = Paid',
  `p_status` int(200) NOT NULL DEFAULT 0 COMMENT '0 = unpaid 1 = paid',
  `h_status` int(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transportation_details`
--

INSERT INTO `transportation_details` (`id`, `booking_id`, `driver_id`, `helper_id`, `truck_id`, `status`, `b_status`, `p_status`, `h_status`, `created_at`, `updated_at`) VALUES
(6, 9, 1, 3, 2, '5', 1, 1, 0, '2023-09-21 02:11:37', '2023-11-08 16:37:54'),
(8, 10, 2, 3, 2, '6', 1, 1, 0, '2023-09-22 00:26:05', '2023-11-20 09:35:20'),
(9, 11, 1, 5, 3, '6', 1, 1, 1, '2023-09-22 01:29:18', '2023-10-31 09:57:06'),
(10, 13, 1, 3, 1, '6', 1, 1, 0, '2023-09-24 23:26:01', '2023-10-31 09:57:06'),
(11, 12, 4, 10, 3, '6', 1, 0, 0, '2023-09-25 23:37:41', '2023-10-31 09:57:06'),
(13, 14, 6, 12, 5, '5', 1, 0, 0, '2023-09-25 23:38:32', '2023-10-31 09:57:06'),
(16, 16, 11, 5, 2, '6', 1, 0, 0, '2023-09-25 23:57:35', '2023-11-08 16:37:54'),
(17, 19, 2, 3, 3, '6', 1, 1, 0, '2023-09-26 06:18:29', '2023-11-20 09:49:08'),
(22, 23, 2, 5, 4, '6', 1, 1, 1, '2023-10-06 02:33:10', '2023-11-20 09:49:08'),
(23, 24, 4, 5, 3, '6', 1, 0, 1, '2023-10-06 02:36:41', '2023-10-30 03:27:57'),
(24, 25, 2, 12, 1, '6', 1, 1, 0, '2023-10-11 00:25:43', '2023-11-20 09:49:08'),
(25, 26, 1, 3, 1, '6', 1, 1, NULL, '2023-10-11 06:26:15', '2023-12-01 13:43:45'),
(26, 27, 1, 3, 3, '6', 1, 1, NULL, '2023-10-16 04:26:14', '2023-12-01 13:43:45'),
(28, 29, 1, 3, 2, '6', 1, 1, NULL, '2023-10-17 17:09:41', '2023-12-01 13:43:45'),
(30, 31, 4, 10, 3, '6', 1, 0, 0, '2023-10-19 16:22:57', '2023-10-30 03:32:37'),
(34, 20, 11, 5, 5, '6', 1, 0, 0, '2023-09-20 14:08:36', '2023-11-08 16:37:54'),
(35, 18, 4, 5, 4, '6', 1, 0, 0, '2023-09-20 14:08:50', '2023-11-08 16:37:54'),
(36, 36, 6, 12, 4, '6', 1, 0, 0, '2023-10-21 01:25:26', '2023-10-20 10:12:18'),
(37, 37, 1, 3, 1, '2', 0, 0, 0, '2023-11-11 01:22:51', '2023-11-11 07:51:12'),
(38, 38, 1, 3, 1, '1', 1, 0, 0, '2023-11-16 17:06:39', '2023-11-24 23:54:39'),
(39, 39, 2, 5, 2, '1', 1, 0, 0, '2023-11-16 17:16:04', '2023-11-24 23:54:39'),
(40, 49, 4, 5, 3, '6', 0, 0, 0, '2023-11-16 17:35:26', '2023-11-27 09:18:56'),
(41, 41, 2, 10, 4, '2', 1, 0, 0, '2023-11-21 01:12:41', '2023-11-24 23:54:39'),
(42, 44, 2, 5, 3, '6', 1, 1, 0, '2023-11-22 00:05:14', '2023-11-24 23:54:39'),
(43, 51, 6, 12, 2, '2', 1, 0, 0, '2023-11-23 21:51:14', '2023-11-24 23:54:39'),
(44, 45, 1, 12, 5, '1', 0, 0, NULL, '2023-11-30 15:18:53', '2023-11-30 15:18:53'),
(45, 42, 1, 10, 2, '6', 0, 0, NULL, '2023-12-01 13:39:49', '2023-11-27 09:06:04'),
(46, 50, 2, 5, 3, '1', 0, 0, NULL, '2023-12-01 13:51:17', '2023-12-01 13:51:17'),
(47, 40, 2, 10, 2, '1', 0, 0, NULL, '2023-12-03 18:54:59', '2023-12-03 18:54:59');

-- --------------------------------------------------------

--
-- Table structure for table `trucks`
--

CREATE TABLE `trucks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `truck_type` varchar(255) DEFAULT NULL,
  `plate_number` varchar(255) DEFAULT NULL,
  `truck_image` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 0 COMMENT ' 0 = Active 1 = Under Maintainance 2 = Assigned',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trucks`
--

INSERT INTO `trucks` (`id`, `truck_type`, `plate_number`, `truck_image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'isuzu forward', 'CBR-4861', 'truck_photos/Xrq4e6rpAZzOX632Yev18xXYUwTmI62LhxwiJW7V.jpg', 0, '2023-08-25 01:44:25', '2023-10-20 07:45:05'),
(2, 'isuzu forward', 'CBN-3142', 'truck_photos/XaaUMl96ShozFGYcGaSex0Kaw8IKCzoHBWW1zQUL.jpg', 0, '2023-08-25 02:02:44', '2023-08-25 02:02:44'),
(3, 'isuzu forward', 'CBR-4869', 'truck_photos/G8MwTIkIdCddVFrHaVJoT8lKDVB6m7Xt1iNEOGMV.jpg', 0, '2023-08-25 02:04:44', '2023-08-25 02:04:44'),
(4, 'isuzu forward', 'CBN-3145', 'truck_photos/QC9Uc1nwHPSfW1lYzukY8AGElEbmTjbwG0tS18bW.jpg', 0, '2023-08-25 02:05:25', '2023-08-26 19:01:58'),
(5, 'isuzu forward', 'CCN-9345', 'truck_photos/xTpJ1GIlZ1ghxPcWnW41Uk80uz612ZjwPgNB9FJt.jpg', 0, '2023-08-25 02:05:57', '2023-08-25 02:05:57'),
(6, 'isuzu forward', 'CBN-3143', 'truck_photos/A1EaDmeGKW1nKvKvzM45MZYnjKodfp1C1cLs9xkh.jpg', 0, '2023-11-29 23:59:32', '2023-11-29 23:59:32');

-- --------------------------------------------------------

--
-- Table structure for table `truck_information`
--

CREATE TABLE `truck_information` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `truck_id` bigint(20) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 = Assigned 2 = Picked-up 3 = Departure 4 = Delivey on the way 5 = Delivered 6 = Arrived at the station',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `truck_information`
--

INSERT INTO `truck_information` (`id`, `truck_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '2023-10-06 02:36:41', '2023-10-06 02:36:41'),
(2, 3, 2, '2023-10-06 04:37:21', '2023-10-06 04:37:21'),
(3, 3, 3, '2023-10-06 04:45:17', '2023-10-06 04:45:17'),
(4, 3, 4, '2023-10-06 06:32:47', '2023-10-06 06:32:47'),
(5, 3, 5, '2023-10-06 07:21:54', '2023-10-06 07:21:54'),
(7, 3, 6, '2023-10-06 08:30:45', '2023-10-06 08:30:45'),
(8, 1, 2, '2023-10-11 06:31:33', '2023-10-11 06:31:33'),
(9, 1, 3, '2023-10-11 06:35:25', '2023-10-11 06:35:25'),
(10, 1, 2, '2023-10-11 06:37:16', '2023-10-11 06:37:16'),
(11, 4, 2, '2023-10-13 02:55:52', '2023-10-13 02:55:52'),
(12, 4, 3, '2023-10-13 03:03:05', '2023-10-13 03:03:05'),
(13, 4, 4, '2023-10-13 03:08:13', '2023-10-13 03:08:13'),
(14, 4, 5, '2023-10-13 03:10:09', '2023-10-13 03:10:09'),
(15, 2, 1, '2023-10-17 17:09:41', '2023-10-17 17:09:41'),
(16, 1, 2, '2023-10-19 05:01:18', '2023-10-19 05:01:18'),
(17, 1, 3, '2023-10-19 05:31:26', '2023-10-19 05:31:26'),
(18, 1, 4, '2023-10-19 08:05:00', '2023-10-19 08:05:00'),
(19, 1, 5, '2023-10-19 09:21:04', '2023-10-19 09:21:04'),
(20, 1, 6, '2023-10-19 11:25:31', '2023-10-19 11:25:31'),
(21, 3, 2, '2023-10-20 08:24:53', '2023-10-20 08:24:53'),
(22, 3, 3, '2023-10-20 08:29:27', '2023-10-20 08:29:27'),
(23, 3, 4, '2023-10-20 10:40:32', '2023-10-20 10:40:32'),
(24, 3, 5, '2023-10-20 10:41:46', '2023-10-20 10:41:46'),
(25, 3, 5, '2023-10-20 10:43:20', '2023-10-20 10:43:20'),
(26, 3, 6, '2023-10-20 10:46:21', '2023-10-20 10:46:21'),
(27, 2, 1, '2023-10-20 07:55:07', '2023-10-20 07:55:07'),
(28, 2, 2, '2023-10-31 08:00:10', '2023-10-31 08:00:10'),
(29, 2, 3, '2023-10-31 08:02:27', '2023-10-31 08:02:27'),
(30, 2, 4, '2023-10-31 08:04:11', '2023-10-31 08:04:11'),
(31, 2, 5, '2023-10-31 08:04:49', '2023-10-31 08:04:49'),
(32, 2, 6, '2023-10-31 08:07:06', '2023-10-31 08:07:06'),
(33, 1, 2, '2023-10-24 12:55:10', '2023-10-24 12:55:10'),
(34, 1, 3, '2023-10-24 13:01:54', '2023-10-24 13:01:54'),
(35, 1, 4, '2023-10-24 13:03:34', '2023-10-24 13:03:34'),
(36, 1, 5, '2023-10-24 13:05:02', '2023-10-24 13:05:02'),
(37, 1, 6, '2023-10-24 13:17:00', '2023-10-24 13:17:00'),
(38, 5, 1, '2023-09-20 14:08:36', '2023-09-20 14:08:36'),
(39, 4, 1, '2023-09-20 14:08:50', '2023-09-20 14:08:50'),
(40, 5, 2, '2023-09-27 03:27:02', '2023-09-27 03:27:02'),
(42, 5, 3, '2023-09-27 04:37:57', '2023-09-27 04:37:57'),
(43, 5, 4, '2023-09-27 06:00:30', '2023-09-27 06:00:30'),
(44, 5, 5, '2023-09-27 15:05:59', '2023-09-27 15:05:59'),
(45, 5, 6, '2023-09-27 15:06:22', '2023-09-27 15:06:22'),
(46, 4, 2, '2023-09-28 15:10:40', '2023-09-28 15:10:40'),
(47, 4, 3, '2023-09-28 04:11:05', '2023-09-28 04:11:05'),
(48, 4, 4, '2023-09-28 09:11:52', '2023-09-28 09:11:52'),
(49, 4, 5, '2023-09-28 09:12:00', '2023-09-28 09:12:00'),
(50, 4, 6, '2023-09-28 09:12:12', '2023-09-28 09:12:12'),
(51, 5, 3, '2023-09-28 09:14:19', '2023-09-28 09:14:19'),
(52, 5, 4, '2023-09-28 09:47:18', '2023-09-28 09:47:18'),
(53, 5, 5, '2023-09-28 09:47:24', '2023-09-28 09:47:24'),
(54, 3, 2, '2023-09-28 16:42:05', '2023-09-28 16:42:05'),
(55, 3, 3, '2023-09-29 09:51:03', '2023-09-29 09:51:03'),
(56, 3, 4, '2023-09-29 13:51:50', '2023-09-29 13:51:50'),
(57, 3, 5, '2023-09-29 13:51:55', '2023-09-29 13:51:55'),
(58, 3, 6, '2023-09-29 13:52:13', '2023-09-29 13:52:13'),
(59, 4, 6, '2023-10-13 11:25:36', '2023-10-13 11:25:36'),
(60, 1, 4, '2023-10-13 11:26:17', '2023-10-13 11:26:17'),
(61, 1, 5, '2023-10-13 11:26:23', '2023-10-13 11:26:23'),
(62, 1, 6, '2023-10-13 11:26:42', '2023-10-13 11:26:42'),
(63, 3, 2, '2023-10-17 11:30:27', '2023-10-17 11:30:27'),
(64, 3, 3, '2023-10-17 14:31:49', '2023-10-17 14:31:49'),
(65, 3, 4, '2023-10-17 14:31:54', '2023-10-17 14:31:54'),
(66, 3, 5, '2023-10-17 15:32:13', '2023-10-17 15:32:13'),
(67, 3, 6, '2023-10-17 15:32:34', '2023-10-17 15:32:34'),
(68, 2, 2, '2023-10-18 10:33:50', '2023-10-18 10:33:50'),
(69, 2, 3, '2023-10-18 12:37:23', '2023-10-18 12:37:23'),
(70, 2, 4, '2023-10-18 12:37:31', '2023-10-18 12:37:31'),
(71, 2, 5, '2023-10-18 12:39:25', '2023-10-18 12:39:25'),
(72, 2, 6, '2023-10-18 12:48:18', '2023-10-18 12:48:18'),
(73, 4, 1, '2023-10-21 01:25:26', '2023-10-21 01:25:26'),
(74, 4, 2, '2023-10-21 01:26:22', '2023-10-21 01:26:22'),
(75, 4, 3, '2023-10-21 01:28:52', '2023-10-21 01:28:52'),
(76, 4, 4, '2023-10-21 01:29:16', '2023-10-21 01:29:16'),
(77, 4, 5, '2023-10-21 01:30:44', '2023-10-21 01:30:44'),
(78, 4, 6, '2023-10-21 01:31:33', '2023-10-21 01:31:33'),
(79, 1, 1, '2023-11-16 17:06:39', '2023-11-16 17:06:39'),
(80, 2, 1, '2023-11-16 17:16:04', '2023-11-16 17:16:04'),
(81, 1, 2, '2023-11-11 07:51:12', '2023-11-11 07:51:12'),
(82, 4, 1, '2023-11-21 01:12:41', '2023-11-21 01:12:41'),
(83, 4, 2, '2023-11-21 11:17:45', '2023-11-21 11:17:45'),
(84, 3, 1, '2023-11-22 00:05:14', '2023-11-22 00:05:14'),
(85, 2, 2, '2023-11-23 21:59:28', '2023-11-23 21:59:28'),
(86, 3, 2, '2023-11-24 01:15:42', '2023-11-24 01:15:42'),
(87, 3, 3, '2023-11-24 01:45:30', '2023-11-24 01:45:30'),
(88, 3, 4, '2023-11-24 15:36:18', '2023-11-24 15:36:18'),
(89, 3, 5, '2023-11-24 23:33:14', '2023-11-24 23:33:14'),
(90, 3, 6, '2023-11-24 23:35:45', '2023-11-24 23:35:45'),
(91, 5, 1, '2023-11-30 15:18:53', '2023-11-30 15:18:53'),
(92, 2, 1, '2023-12-01 13:39:49', '2023-12-01 13:39:49'),
(93, 3, 1, '2023-12-01 13:51:17', '2023-12-01 13:51:17'),
(94, 2, 1, '2023-12-03 18:54:59', '2023-12-03 18:54:59'),
(95, 2, 2, '2023-11-27 09:02:55', '2023-11-27 09:02:55'),
(96, 2, 3, '2023-11-27 09:03:56', '2023-11-27 09:03:56'),
(97, 2, 4, '2023-11-27 09:05:23', '2023-11-27 09:05:23'),
(98, 2, 5, '2023-11-27 09:05:38', '2023-11-27 09:05:38'),
(99, 2, 6, '2023-11-27 09:06:05', '2023-11-27 09:06:05'),
(100, 3, 2, '2023-11-27 09:18:18', '2023-11-27 09:18:18'),
(101, 3, 3, '2023-11-27 09:18:23', '2023-11-27 09:18:23'),
(102, 3, 4, '2023-11-27 09:18:28', '2023-11-27 09:18:28'),
(103, 3, 5, '2023-11-27 09:18:41', '2023-11-27 09:18:41'),
(104, 3, 6, '2023-11-27 09:18:56', '2023-11-27 09:18:56');

-- --------------------------------------------------------

--
-- Table structure for table `updated_times`
--

CREATE TABLE `updated_times` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `t_id` bigint(20) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL COMMENT '2 = Picked-up 3 = Departure 5 = Delivered',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `updated_times`
--

INSERT INTO `updated_times` (`id`, `t_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 9, 2, '2023-09-22 06:07:39', '2023-09-22 06:07:39'),
(2, 9, 3, '2023-09-22 06:08:00', '2023-09-22 06:08:00'),
(3, 9, 4, '2023-09-22 06:08:24', '2023-09-22 06:08:24'),
(4, 8, 2, '2023-09-22 06:52:17', '2023-09-22 06:52:17'),
(5, 8, 3, '2023-09-22 07:02:36', '2023-09-22 07:02:36'),
(6, 8, 4, '2023-09-22 07:55:08', '2023-09-22 07:55:08'),
(8, 6, 2, '2023-09-21 09:12:13', '2023-09-21 09:12:13'),
(9, 6, 3, '2023-09-21 10:12:34', '2023-09-21 10:12:34'),
(10, 6, 5, '2023-09-21 11:13:05', '2023-09-21 11:13:05'),
(15, 8, 5, '2023-09-22 11:29:48', '2023-09-22 11:29:48'),
(16, 9, 5, '2023-09-22 11:40:12', '2023-09-22 11:40:12'),
(17, 8, 6, '2023-09-22 11:49:54', '2023-09-22 11:49:54'),
(18, 9, 6, '2023-09-22 11:53:35', '2023-09-22 11:53:35'),
(26, 16, 2, '2023-09-26 04:25:43', '2023-09-26 04:25:43'),
(30, 16, 3, '2023-09-26 06:07:16', '2023-09-26 06:07:16'),
(31, 16, 4, '2023-09-26 06:08:00', '2023-09-26 06:08:00'),
(32, 16, 5, '2023-09-26 09:09:16', '2023-09-26 09:09:16'),
(34, 16, 6, '2023-09-26 11:03:16', '2023-09-26 11:03:16'),
(36, 10, 2, '2023-09-26 11:13:10', '2023-09-26 11:13:10'),
(37, 10, 3, '2023-09-26 11:13:30', '2023-09-26 11:13:30'),
(38, 10, 4, '2023-09-26 11:30:55', '2023-09-26 11:30:55'),
(39, 10, 5, '2023-09-26 13:33:48', '2023-09-26 13:33:48'),
(41, 10, 6, '2023-09-26 15:35:42', '2023-09-26 15:35:42'),
(42, 13, 2, '2023-09-28 10:02:26', '2023-09-28 10:02:26'),
(44, 11, 3, '2023-09-27 10:13:53', '2023-09-27 10:13:53'),
(45, 11, 4, '2023-09-27 10:45:46', '2023-09-27 10:45:46'),
(47, 11, 5, '2023-09-27 15:04:22', '2023-09-27 15:04:22'),
(48, 11, 6, '2023-09-27 15:05:31', '2023-09-27 15:05:31'),
(50, 23, 2, '2023-10-06 04:37:21', '2023-10-06 04:37:21'),
(51, 23, 3, '2023-10-06 04:45:17', '2023-10-06 04:45:17'),
(52, 23, 4, '2023-10-06 06:32:47', '2023-10-06 06:32:47'),
(53, 23, 5, '2023-10-06 07:21:54', '2023-10-06 07:21:54'),
(56, 23, 6, '2023-10-06 08:30:45', '2023-10-06 08:30:45'),
(57, 25, 2, '2023-10-11 06:31:33', '2023-10-11 06:31:33'),
(58, 25, 3, '2023-10-11 06:35:25', '2023-10-11 06:35:25'),
(60, 22, 2, '2023-10-13 02:55:52', '2023-10-13 02:55:52'),
(61, 22, 3, '2023-10-13 03:03:05', '2023-10-13 03:03:05'),
(62, 22, 4, '2023-10-13 03:08:13', '2023-10-13 03:08:13'),
(63, 22, 5, '2023-10-13 03:10:09', '2023-10-13 03:10:09'),
(64, 24, 2, '2023-10-19 05:01:18', '2023-10-19 05:01:18'),
(65, 24, 3, '2023-10-19 05:31:26', '2023-10-19 05:31:26'),
(66, 24, 4, '2023-10-19 08:05:00', '2023-10-19 08:05:00'),
(67, 24, 5, '2023-10-19 09:21:04', '2023-10-19 09:21:04'),
(68, 24, 6, '2023-10-19 11:25:31', '2023-10-19 11:25:31'),
(69, 30, 2, '2023-10-20 08:24:53', '2023-10-20 08:24:53'),
(70, 30, 3, '2023-10-20 08:29:27', '2023-10-20 08:29:27'),
(71, 30, 4, '2023-10-20 10:40:32', '2023-10-20 10:40:32'),
(73, 30, 5, '2023-10-20 10:43:20', '2023-10-20 10:43:20'),
(74, 30, 6, '2023-10-20 10:46:21', '2023-10-20 10:46:21'),
(85, 34, 2, '2023-09-27 03:27:02', '2023-09-27 03:27:02'),
(87, 34, 3, '2023-09-27 04:37:57', '2023-09-27 04:37:57'),
(88, 34, 4, '2023-09-27 06:00:30', '2023-09-27 06:00:30'),
(89, 34, 5, '2023-09-27 15:05:59', '2023-09-27 15:05:59'),
(90, 34, 6, '2023-09-27 15:06:22', '2023-09-27 15:06:22'),
(91, 35, 2, '2023-09-28 15:10:40', '2023-09-28 15:10:40'),
(92, 35, 3, '2023-09-28 04:11:05', '2023-09-28 04:11:05'),
(93, 35, 4, '2023-09-28 09:11:52', '2023-09-28 09:11:52'),
(94, 35, 5, '2023-09-28 09:12:00', '2023-09-28 09:12:00'),
(95, 35, 6, '2023-09-28 09:12:12', '2023-09-28 09:12:12'),
(96, 13, 3, '2023-09-28 09:14:19', '2023-09-28 09:14:19'),
(97, 13, 4, '2023-09-28 09:47:18', '2023-09-28 09:47:18'),
(98, 13, 5, '2023-09-28 09:47:24', '2023-09-28 09:47:24'),
(99, 17, 2, '2023-09-28 16:42:05', '2023-09-28 16:42:05'),
(100, 17, 3, '2023-09-29 09:51:03', '2023-09-29 09:51:03'),
(101, 17, 4, '2023-09-29 13:51:50', '2023-09-29 13:51:50'),
(102, 17, 5, '2023-09-29 13:51:55', '2023-09-29 13:51:55'),
(103, 17, 6, '2023-09-29 13:52:13', '2023-09-29 13:52:13'),
(104, 22, 6, '2023-10-13 11:25:36', '2023-10-13 11:25:36'),
(105, 25, 4, '2023-10-13 11:26:17', '2023-10-13 11:26:17'),
(106, 25, 5, '2023-10-13 11:26:23', '2023-10-13 11:26:23'),
(107, 25, 6, '2023-10-13 11:26:42', '2023-10-13 11:26:42'),
(108, 26, 2, '2023-10-17 11:30:27', '2023-10-17 11:30:27'),
(109, 26, 3, '2023-10-17 14:31:49', '2023-10-17 14:31:49'),
(110, 26, 4, '2023-10-17 14:31:54', '2023-10-17 14:31:54'),
(111, 26, 5, '2023-10-17 15:32:13', '2023-10-17 15:32:13'),
(112, 26, 6, '2023-10-17 15:32:34', '2023-10-17 15:32:34'),
(113, 28, 2, '2023-10-18 10:33:50', '2023-10-18 10:33:50'),
(114, 28, 3, '2023-10-18 12:37:23', '2023-10-18 12:37:23'),
(115, 28, 4, '2023-10-18 12:37:31', '2023-10-18 12:37:31'),
(116, 28, 5, '2023-10-18 12:39:25', '2023-10-18 12:39:25'),
(117, 28, 6, '2023-10-18 12:48:18', '2023-10-18 12:48:18'),
(118, 36, 2, '2023-10-21 01:26:22', '2023-10-21 01:26:22'),
(119, 36, 3, '2023-10-21 01:28:52', '2023-10-21 01:28:52'),
(120, 36, 4, '2023-10-21 01:29:16', '2023-10-21 01:29:16'),
(121, 36, 5, '2023-10-21 01:30:44', '2023-10-21 01:30:44'),
(122, 36, 6, '2023-10-21 01:31:33', '2023-10-21 01:31:33'),
(123, 37, 2, '2023-11-11 07:51:12', '2023-11-11 07:51:12'),
(124, 41, 2, '2023-11-21 11:17:45', '2023-11-21 11:17:45'),
(125, 43, 2, '2023-11-23 21:59:28', '2023-11-23 21:59:28'),
(126, 42, 2, '2023-11-24 01:15:42', '2023-11-24 01:15:42'),
(127, 42, 3, '2023-11-24 01:45:30', '2023-11-24 01:45:30'),
(128, 42, 4, '2023-11-24 15:36:18', '2023-11-24 15:36:18'),
(129, 42, 5, '2023-11-24 23:33:14', '2023-11-24 23:33:14'),
(130, 42, 6, '2023-11-24 23:35:45', '2023-11-24 23:35:45'),
(131, 45, 2, '2023-11-27 09:02:55', '2023-11-27 09:02:55'),
(132, 45, 3, '2023-11-27 09:03:56', '2023-11-27 09:03:56'),
(133, 45, 4, '2023-11-27 09:05:23', '2023-11-27 09:05:23'),
(134, 45, 5, '2023-11-27 09:05:38', '2023-11-27 09:05:38'),
(135, 45, 6, '2023-11-27 09:06:05', '2023-11-27 09:06:05'),
(136, 40, 2, '2023-11-27 09:18:18', '2023-11-27 09:18:18'),
(137, 40, 3, '2023-11-27 09:18:23', '2023-11-27 09:18:23'),
(138, 40, 4, '2023-11-27 09:18:28', '2023-11-27 09:18:28'),
(139, 40, 5, '2023-11-27 09:18:41', '2023-11-27 09:18:41'),
(140, 40, 6, '2023-11-27 09:18:56', '2023-11-27 09:18:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `lname` varchar(200) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone_num` varchar(200) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `is_disabled` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `lname`, `email`, `phone_num`, `email_verified_at`, `password`, `type`, `is_disabled`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', '+639358554398', NULL, '$2y$10$UoJcEc8/7n9AaShr04cdN.5ikgCQraEYVBYAwHbmokjyBRBs5ncAq', 1, 0, 'fUmEn8RwBkNgjbA429MOBymdUtoRxo4WIY0OG31eVC5YHCg6FzbfIVn9IxWX', '2023-06-17 07:59:07', '2023-11-25 18:49:52'),
(2, 'Alpha Food', NULL, 'alpha@gmail.com', '+639358554398', NULL, '$2y$10$kxC9D6uF66uq8n1px2aAiuSH7pwxJBY9m6zgeDarK1cz7XLCJDtke', 0, 0, 'p1kaFIBa9haQME0K0d2vUk9cqMXoCWcNHeVsxKmDiwVByaqMPyUovGhNi3Q8', '2023-06-17 08:02:57', '2023-11-10 14:15:35'),
(3, 'Judphiland', NULL, 'judphiland@gmail.com', '+639358554398', NULL, '$2y$10$fhn5BLqQ5JHGjXlZslfTV.NWhjzqVxXC0ygRontORHsHxiJO5Tere', 0, 0, NULL, '2023-06-17 08:03:42', '2023-08-04 14:25:02'),
(4, 'Ryan Jay', 'Reyes', 'ryanjaytagolimotreyes@gmail.com', '+639358554398', NULL, '$2y$10$S4IOfV7qzxYq0WSHFkbmWuObNuLruVO7qeu2TTgqBQMDgBqV3qCAy', 2, 0, 'YyGVflwg8tGe6mUHCmrEG9hhZyhJEwQilbWptetQP4eMqiWvc01Nv04VIzYh', '2023-06-17 08:09:01', '2023-11-30 01:12:35'),
(5, 'Nicholas', 'Manay', 'nicolas@gmail.com', '+639358554398', NULL, '$2y$10$uQQcxHkGR8V2mXb9ZsPz0.leHbtRwzWFhatHeru6odUHFJjbzmioC', 2, 0, 'EljAQJkMa48UEg7t4wibPYokYXsyvzxFCZ6s6TmgkmKBUZ6LuYogZW6dmGDo', '2023-06-17 19:44:26', '2023-09-27 15:10:42'),
(18, 'Renzo', 'Banquerigo', 'renzo@gmail.com', '+639358554398', NULL, '$2y$10$VADS5pCu0/tfBU78iy9FkeS74MPa/ibdcMlg55nsGZ2TeKquw7IZ2', 2, 0, 'XPtr220RH9rSQeJ3FSmP3m6GXQkv3rrles5g5nA66rGiXBsGqQwJ9YiEth2V', '2023-06-22 08:41:24', '2023-08-09 13:38:34'),
(19, 'Felix', 'Quieta', 'felix@gmail.com', '+639358554398', NULL, '$2y$10$eli7h28wUxby7r9ovI.cD.fu95yWb7rHIKsqIMdWutXPNqTNIm2f.', 2, 0, 'XIihDDNOcBphQlehriLCVUlknRuk2enwou2foefxlwOPgOonLFaWNIkVB5oH', '2023-06-28 02:59:38', '2023-11-27 09:16:53'),
(22, 'Mark Dave', 'Sacayan', 'mark@gmail.com', '+639358554398', NULL, '$2y$10$GLMspeJM872nmfp2uPQ4neCNpKGJQGrozMo2qPapSZbYaGD6rn4Eq', 2, 0, NULL, '2023-07-12 15:24:53', '2023-07-12 15:24:53'),
(28, 'khate Compound', NULL, 'khateanastacio@gmail.com', '+639358554398', NULL, '$2y$10$p0cHz1UgJvXVzGXUbONp9.zG6MAwKoQF.Tl8.3mz2JvMvN.VKwW/K', 0, 0, 'FEpESK9IsHkqGG8w1fhjrDZNcjgO7TwxD6ygy2ttokFjSCbz4QLul9SFsACD', '2023-07-20 14:35:28', '2023-08-18 06:39:40'),
(29, 'Aeron', 'Alajenio', 'aeron@gmail.com', '+639358554398', NULL, '$2y$10$eY.fAWU5ncoAfX1/A4dnIOaTRIK.PUzksiwopM2N0UjE/bMekcsZi', 2, 0, 'XDEmtVhXwPQEucOyuqfojvQfeptbxdv260HnHxvvMK1GAdqmxI0vQjWdYIYB', '2023-07-20 15:17:38', '2023-09-27 16:06:53'),
(30, 'Reyes Compound', NULL, 'jay@gmail.com', '+639358554398', NULL, '$2y$10$Xz7gQie8vMIp3/E144aAle7DUQWbGTq/yjznxZLZayJL2YwA8kuV6', 0, 1, NULL, '2023-07-22 04:16:38', '2023-10-03 12:49:03'),
(33, 'Joemar', 'Questadio', 'joemar@gmail.com', '+639358554398', NULL, NULL, 2, 0, NULL, '2023-08-01 05:56:42', '2023-08-01 05:56:42'),
(34, 'Richard', 'Rafal', 'richard@gmail.com', '+639358554398', NULL, '$2y$10$qCvr5Lhho35eAHAzfrba6OZ7zSSijjsf17dcX/mt75wJ06PxCr5sm', 2, 0, 'tet2ROQT66pp8CzXAlH6BkE9Q2e1VMYyLjfJeyKlcGG2ybk1nwSxTyV61n7s', '2023-08-01 05:58:32', '2023-10-20 14:17:17'),
(35, 'Sunny', 'Magsalos', 'sunny@gmailcom', '+639358554398', NULL, NULL, 2, 0, NULL, '2023-08-01 05:59:22', '2023-08-01 05:59:22'),
(37, 'Jiro', 'Lobaton', 'jiro@gmail.com', '+639358554398', NULL, NULL, 2, 0, NULL, '2023-08-01 06:03:51', '2023-08-01 06:03:51'),
(38, 'Loydi', 'Tagolimot', 'loyditagolimot@gmail.com', '+639358554398', NULL, '$2y$10$B82ow4E2lq5kvaqSB3Cb9Oe8Ibd5SVkwlc2GfBE1KtgjYyICgsQD2', 2, 1, NULL, '2023-08-08 09:23:47', '2023-09-27 11:01:59'),
(41, 'Ryan Jay Compund', NULL, 'jaytagolimotreyes@gmail.com', '+639358554398', NULL, '$2y$10$mrP1vueHwYCftao3xw.KieuNIajj6sqT./8kvlSChJBjo8Q4.lU8C', 1, 0, 'ETfWMqNGBPJvJvSyNJOnc43HSZVT1eYwQrZ9yQbvIGtiiutIAwsuy6DmTYRw', '2023-08-17 14:51:54', '2023-08-30 16:14:22'),
(45, 'Southern Philippines College', NULL, 'spc@gmail.com', '+639358554398', NULL, '$2y$10$mrP1vueHwYCftao3xw.KieuNIajj6sqT./8kvlSChJBjo8Q4.lU8C', 0, 0, NULL, '2023-09-18 05:43:14', '2023-09-22 02:50:57'),
(46, 'Reyes Family', NULL, 'reyesfamily@gmail.com', '+639358554398', NULL, '$2y$10$r33jHA4BJC4NAs.V6/lXuOYiTsd2c8YeTfShz0JjomqdeRswWeUyi', 0, 0, NULL, '2023-11-27 08:10:16', '2023-11-27 08:10:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `billings`
--
ALTER TABLE `billings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `billing_details`
--
ALTER TABLE `billing_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `billing_id` (`billing_id`),
  ADD KEY `transportation_id` (`transportation_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cash_advances`
--
ALTER TABLE `cash_advances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `ca_details`
--
ALTER TABLE `ca_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ca_id` (`ca_id`);

--
-- Indexes for table `damages`
--
ALTER TABLE `damages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `damage_details`
--
ALTER TABLE `damage_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `d_id` (`d_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `billing_id` (`billing_id`);

--
-- Indexes for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `payroll_details`
--
ALTER TABLE `payroll_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payroll_id` (`payroll_id`),
  ADD KEY `transportation_id` (`transportation_id`);

--
-- Indexes for table `transportation_details`
--
ALTER TABLE `transportation_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `driver_id` (`driver_id`),
  ADD KEY `helper_id` (`helper_id`),
  ADD KEY `truck_id` (`truck_id`);

--
-- Indexes for table `trucks`
--
ALTER TABLE `trucks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `truck_information`
--
ALTER TABLE `truck_information`
  ADD PRIMARY KEY (`id`),
  ADD KEY `truck_id` (`truck_id`);

--
-- Indexes for table `updated_times`
--
ALTER TABLE `updated_times`
  ADD PRIMARY KEY (`id`),
  ADD KEY `t_id` (`t_id`);

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
-- AUTO_INCREMENT for table `billings`
--
ALTER TABLE `billings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `billing_details`
--
ALTER TABLE `billing_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `cash_advances`
--
ALTER TABLE `cash_advances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ca_details`
--
ALTER TABLE `ca_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `damages`
--
ALTER TABLE `damages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `damage_details`
--
ALTER TABLE `damage_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payrolls`
--
ALTER TABLE `payrolls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `payroll_details`
--
ALTER TABLE `payroll_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `transportation_details`
--
ALTER TABLE `transportation_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `trucks`
--
ALTER TABLE `trucks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `truck_information`
--
ALTER TABLE `truck_information`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `updated_times`
--
ALTER TABLE `updated_times`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `billings`
--
ALTER TABLE `billings`
  ADD CONSTRAINT `billings_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `billing_details`
--
ALTER TABLE `billing_details`
  ADD CONSTRAINT `billing_details_ibfk_2` FOREIGN KEY (`transportation_id`) REFERENCES `transportation_details` (`id`),
  ADD CONSTRAINT `billing_details_ibfk_3` FOREIGN KEY (`billing_id`) REFERENCES `billings` (`id`);

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `cash_advances`
--
ALTER TABLE `cash_advances`
  ADD CONSTRAINT `cash_advances_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`id`);

--
-- Constraints for table `ca_details`
--
ALTER TABLE `ca_details`
  ADD CONSTRAINT `ca_details_ibfk_1` FOREIGN KEY (`ca_id`) REFERENCES `cash_advances` (`id`);

--
-- Constraints for table `damages`
--
ALTER TABLE `damages`
  ADD CONSTRAINT `damages_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`id`);

--
-- Constraints for table `damage_details`
--
ALTER TABLE `damage_details`
  ADD CONSTRAINT `damage_details_ibfk_1` FOREIGN KEY (`d_id`) REFERENCES `damages` (`id`);

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`billing_id`) REFERENCES `billings` (`id`);

--
-- Constraints for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD CONSTRAINT `payrolls_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`id`);

--
-- Constraints for table `payroll_details`
--
ALTER TABLE `payroll_details`
  ADD CONSTRAINT `payroll_details_ibfk_1` FOREIGN KEY (`payroll_id`) REFERENCES `payrolls` (`id`),
  ADD CONSTRAINT `payroll_details_ibfk_2` FOREIGN KEY (`transportation_id`) REFERENCES `transportation_details` (`id`);

--
-- Constraints for table `transportation_details`
--
ALTER TABLE `transportation_details`
  ADD CONSTRAINT `transportation_details_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`),
  ADD CONSTRAINT `transportation_details_ibfk_2` FOREIGN KEY (`driver_id`) REFERENCES `employee` (`id`),
  ADD CONSTRAINT `transportation_details_ibfk_3` FOREIGN KEY (`helper_id`) REFERENCES `employee` (`id`),
  ADD CONSTRAINT `transportation_details_ibfk_4` FOREIGN KEY (`truck_id`) REFERENCES `trucks` (`id`);

--
-- Constraints for table `truck_information`
--
ALTER TABLE `truck_information`
  ADD CONSTRAINT `truck_information_ibfk_1` FOREIGN KEY (`truck_id`) REFERENCES `trucks` (`id`);

--
-- Constraints for table `updated_times`
--
ALTER TABLE `updated_times`
  ADD CONSTRAINT `updated_times_ibfk_1` FOREIGN KEY (`t_id`) REFERENCES `transportation_details` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
