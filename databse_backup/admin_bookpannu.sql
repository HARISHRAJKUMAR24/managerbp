-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 06, 2026 at 01:50 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admin_bookpannu`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `appointment_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `service_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `date` datetime(3) NOT NULL,
  `time` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `charges` varchar(255) NOT NULL,
  `gst_amount` varchar(255) DEFAULT NULL,
  `total_amount` varchar(255) NOT NULL,
  `gst_number` varchar(191) DEFAULT NULL,
  `gst_type` varchar(191) DEFAULT NULL,
  `gst_percentage` int(11) DEFAULT NULL,
  `payment_method` varchar(255) NOT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `employee_commission` varchar(191) DEFAULT NULL,
  `area` varchar(255) NOT NULL,
  `postalCode` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `remark` text DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `paymentStatus` varchar(255) NOT NULL,
  `paidAt` datetime(3) DEFAULT NULL,
  `created_at` datetime(3) NOT NULL DEFAULT current_timestamp(3)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointment_settings`
--

CREATE TABLE `appointment_settings` (
  `id` int(11) NOT NULL,
  `service_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `doctor_fee` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `time_slot_interval` varchar(255) NOT NULL,
  `interval_type` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `gst_percentage` int(11) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime(3) NOT NULL DEFAULT current_timestamp(3)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment_settings`
--

INSERT INTO `appointment_settings` (`id`, `service_id`, `user_id`, `name`, `slug`, `doctor_fee`, `image`, `category_id`, `time_slot_interval`, `interval_type`, `description`, `gst_percentage`, `meta_title`, `meta_description`, `status`, `created_at`) VALUES
(10, 'SRV_694247d743282', 85698, 'ddd', 'ddd', NULL, '/uploads/sellers/85698/services/2025/12/17/srv_69424d4337f04.png', 7, '', 'minutes', 'ssss', 28, 'ssss', 'dddd', 1, '2025-12-17 11:34:07.275'),
(11, 'SRV_694383508eb5a', 85960, 'deepak', 'dee', NULL, '', NULL, '3', 'minutes', 'sdfsdfsdf', 18, '', '', 0, '2025-12-18 10:00:08.585');

-- --------------------------------------------------------

--
-- Table structure for table `available_areas`
--

CREATE TABLE `available_areas` (
  `id` int(11) NOT NULL,
  `area_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `area` varchar(255) NOT NULL,
  `charges` varchar(255) NOT NULL,
  `created_at` datetime(3) NOT NULL DEFAULT current_timestamp(3)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `created_at` datetime(3) NOT NULL DEFAULT current_timestamp(3),
  `doctor_name` varchar(255) DEFAULT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  `reg_number` varchar(255) DEFAULT NULL,
  `doctor_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_id`, `user_id`, `name`, `slug`, `meta_title`, `meta_description`, `created_at`, `doctor_name`, `specialization`, `qualification`, `experience`, `reg_number`, `doctor_image`) VALUES
(49, 'CAT_694e0cf7aa550', 85960, 'dddddd', 'dddddd', 'fdff', 'ddd', '2025-12-26 09:50:07.697', 'vf', 'fd', 'df', 1, 'dfs', 'sellers/85960/doctors/2025/12/26/1766722795_694e0cebdc8d2.png');

-- --------------------------------------------------------

--
-- Table structure for table `configured_plugins`
--

CREATE TABLE `configured_plugins` (
  `id` int(11) NOT NULL,
  `plugin_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `coupon_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `discount_type` varchar(255) NOT NULL,
  `discount` int(11) NOT NULL,
  `start_date` datetime(3) NOT NULL,
  `end_date` datetime(3) NOT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `min_booking_amount` int(11) DEFAULT NULL,
  `created_at` datetime(3) NOT NULL DEFAULT current_timestamp(3)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `coupon_id`, `user_id`, `name`, `code`, `discount_type`, `discount`, `start_date`, `end_date`, `usage_limit`, `min_booking_amount`, `created_at`) VALUES
(20, 'CPN_694e5e747109b_8950', 85960, 'dfw', 'SDFWE', 'percentage', 4, '2025-12-10 18:30:00.000', '2025-12-26 18:30:00.000', 4, 3, '2025-12-26 15:37:48.463');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` datetime(3) NOT NULL DEFAULT current_timestamp(3)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_id`, `user_id`, `name`, `email`, `phone`, `password`, `photo`, `created_at`) VALUES
(16, 879456, 27395, 'Deepak C', NULL, '+919345604653', '$2y$10$QPL9d82JH/LNZHoQtKV9.eHxV51h8gC9IGTVP4dgbUmKPv7Rb3Nwi', NULL, '2025-12-27 06:10:11.098');

-- --------------------------------------------------------

--
-- Table structure for table `dashboard_messages`
--

CREATE TABLE `dashboard_messages` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `expiry_type` enum('hours','days','weeks','months') DEFAULT 'hours',
  `expiry_value` int(11) NOT NULL,
  `expiry_date` datetime NOT NULL,
  `seller_type` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`seller_type`)),
  `just_created_seller` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dashboard_messages`
--

INSERT INTO `dashboard_messages` (`id`, `title`, `description`, `expiry_type`, `expiry_value`, `expiry_date`, `seller_type`, `just_created_seller`, `created_at`, `updated_at`) VALUES
(79, 'Date 1-12-2025 Time Now 3:59 pm', 'Date 1-12-2025 Time Now 3:59 pm', 'weeks', 1, '2026-01-13 06:25:20', '[\"1\",\"8\",\"5\"]', 0, '2025-12-01 10:29:01', '2026-01-06 06:25:20'),
(86, 'wer', 'wer', 'days', 3, '2026-01-09 06:24:22', NULL, 0, '2026-01-06 05:20:17', '2026-01-06 06:24:22');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `department_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type_main_name` varchar(255) DEFAULT NULL,
  `type_main_amount` decimal(10,2) DEFAULT NULL,
  `type_1_name` varchar(255) DEFAULT NULL,
  `type_1_amount` decimal(10,2) DEFAULT NULL,
  `type_2_name` varchar(255) DEFAULT NULL,
  `type_2_amount` decimal(10,2) DEFAULT NULL,
  `type_3_name` varchar(255) DEFAULT NULL,
  `type_3_amount` decimal(10,2) DEFAULT NULL,
  `type_4_name` varchar(255) DEFAULT NULL,
  `type_4_amount` decimal(10,2) DEFAULT NULL,
  `type_5_name` varchar(255) DEFAULT NULL,
  `type_5_amount` decimal(10,2) DEFAULT NULL,
  `type_6_name` varchar(255) DEFAULT NULL,
  `type_6_amount` decimal(10,2) DEFAULT NULL,
  `type_7_name` varchar(255) DEFAULT NULL,
  `type_7_amount` decimal(10,2) DEFAULT NULL,
  `type_8_name` varchar(255) DEFAULT NULL,
  `type_8_amount` decimal(10,2) DEFAULT NULL,
  `type_9_name` varchar(255) DEFAULT NULL,
  `type_9_amount` decimal(10,2) DEFAULT NULL,
  `type_10_name` varchar(255) DEFAULT NULL,
  `type_10_amount` decimal(10,2) DEFAULT NULL,
  `type_11_name` varchar(255) DEFAULT NULL,
  `type_11_amount` decimal(10,2) DEFAULT NULL,
  `type_12_name` varchar(255) DEFAULT NULL,
  `type_12_amount` decimal(10,2) DEFAULT NULL,
  `type_13_name` varchar(255) DEFAULT NULL,
  `type_13_amount` decimal(10,2) DEFAULT NULL,
  `type_14_name` varchar(255) DEFAULT NULL,
  `type_14_amount` decimal(10,2) DEFAULT NULL,
  `type_15_name` varchar(255) DEFAULT NULL,
  `type_15_amount` decimal(10,2) DEFAULT NULL,
  `type_16_name` varchar(255) DEFAULT NULL,
  `type_16_amount` decimal(10,2) DEFAULT NULL,
  `type_17_name` varchar(255) DEFAULT NULL,
  `type_17_amount` decimal(10,2) DEFAULT NULL,
  `type_18_name` varchar(255) DEFAULT NULL,
  `type_18_amount` decimal(10,2) DEFAULT NULL,
  `type_19_name` varchar(255) DEFAULT NULL,
  `type_19_amount` decimal(10,2) DEFAULT NULL,
  `type_20_name` varchar(255) DEFAULT NULL,
  `type_20_amount` decimal(10,2) DEFAULT NULL,
  `type_21_name` varchar(255) DEFAULT NULL,
  `type_21_amount` decimal(10,2) DEFAULT NULL,
  `type_22_name` varchar(255) DEFAULT NULL,
  `type_22_amount` decimal(10,2) DEFAULT NULL,
  `type_23_name` varchar(255) DEFAULT NULL,
  `type_23_amount` decimal(10,2) DEFAULT NULL,
  `type_24_name` varchar(255) DEFAULT NULL,
  `type_24_amount` decimal(10,2) DEFAULT NULL,
  `type_25_name` varchar(255) DEFAULT NULL,
  `type_25_amount` decimal(10,2) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `created_at` datetime(3) NOT NULL DEFAULT current_timestamp(3),
  `updated_at` datetime(3) DEFAULT NULL ON UPDATE current_timestamp(3),
  `appointment_settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`appointment_settings`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department_id`, `user_id`, `name`, `type_main_name`, `type_main_amount`, `type_1_name`, `type_1_amount`, `type_2_name`, `type_2_amount`, `type_3_name`, `type_3_amount`, `type_4_name`, `type_4_amount`, `type_5_name`, `type_5_amount`, `type_6_name`, `type_6_amount`, `type_7_name`, `type_7_amount`, `type_8_name`, `type_8_amount`, `type_9_name`, `type_9_amount`, `type_10_name`, `type_10_amount`, `type_11_name`, `type_11_amount`, `type_12_name`, `type_12_amount`, `type_13_name`, `type_13_amount`, `type_14_name`, `type_14_amount`, `type_15_name`, `type_15_amount`, `type_16_name`, `type_16_amount`, `type_17_name`, `type_17_amount`, `type_18_name`, `type_18_amount`, `type_19_name`, `type_19_amount`, `type_20_name`, `type_20_amount`, `type_21_name`, `type_21_amount`, `type_22_name`, `type_22_amount`, `type_23_name`, `type_23_amount`, `type_24_name`, `type_24_amount`, `type_25_name`, `type_25_amount`, `slug`, `image`, `meta_title`, `meta_description`, `created_at`, `updated_at`, `appointment_settings`) VALUES
(23, 'DEPT_694bdf9d1cab2', 32128, 'test mama', '123', 123.00, '234', 234.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'test-mama', 'sellers/32128/departments/2025/12/24/1766580124_694bdf9c253b8.webp', NULL, NULL, '2025-12-24 18:12:05.117', '2025-12-26 15:11:53.488', '{\"Sun\":{\"enabled\":true,\"slots\":[{\"from\":\"05:10\",\"to\":\"07:10\",\"breakFrom\":\"\",\"breakTo\":\"\",\"token\":7}]},\"Mon\":{\"enabled\":true,\"slots\":[{\"from\":\"05:11\",\"to\":\"08:14\",\"breakFrom\":\"\",\"breakTo\":\"\",\"token\":44},{\"from\":\"02:22\",\"to\":\"05:55\",\"breakFrom\":\"\",\"breakTo\":\"\",\"token\":44}]},\"Tue\":{\"enabled\":false,\"slots\":[]},\"Wed\":{\"enabled\":false,\"slots\":[]},\"Thu\":{\"enabled\":false,\"slots\":[]},\"Fri\":{\"enabled\":false,\"slots\":[]},\"Sat\":{\"enabled\":false,\"slots\":[]}}'),
(29, 'DEPT_694e7e0c8ea29', 32128, 'qqq', 'hair cut', 100.00, 'shave', 200.01, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'qqq', 'sellers/32128/departments/2025/12/26/1766751755_694e7e0b4e395.webp', NULL, NULL, '2025-12-26 17:52:36.585', '2026-01-03 13:41:21.200', '{\"Sun\":{\"enabled\":true,\"slots\":[{\"from\":\"03:50\",\"to\":\"17:50\",\"breakFrom\":\"\",\"breakTo\":\"\",\"token\":33}]},\"Mon\":{\"enabled\":false,\"slots\":[]},\"Tue\":{\"enabled\":false,\"slots\":[]},\"Wed\":{\"enabled\":false,\"slots\":[]},\"Thu\":{\"enabled\":false,\"slots\":[]},\"Fri\":{\"enabled\":false,\"slots\":[]},\"Sat\":{\"enabled\":false,\"slots\":[]}}');

-- --------------------------------------------------------

--
-- Table structure for table `department_additional_images`
--

CREATE TABLE `department_additional_images` (
  `id` int(11) NOT NULL,
  `department_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department_additional_images`
--

INSERT INTO `department_additional_images` (`id`, `department_id`, `user_id`, `image`, `created_at`) VALUES
(73, 'DEPT_694b91471ef90', 0, 'sellers/32128/departments/2025/12/24/1766560069_694b9145dcabf.webp', '2025-12-24 12:41:49'),
(74, 'DEPT_694b91471ef90', 0, 'sellers/32128/departments/2025/12/24/1766560069_694b9145e07f4.webp', '2025-12-24 12:41:49');

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `id` int(11) NOT NULL,
  `code` varchar(191) NOT NULL,
  `type` varchar(191) NOT NULL,
  `discount` int(11) NOT NULL,
  `eligibility` int(11) DEFAULT NULL,
  `created_at` datetime(3) NOT NULL DEFAULT current_timestamp(3)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id`, `code`, `type`, `discount`, `eligibility`, `created_at`) VALUES
(12, '123', 'percentage', 10, NULL, '2025-12-09 11:01:18.084'),
(13, '456', 'fixed', 10, 8, '2025-12-09 11:30:58.539');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `doctor_name` varchar(255) NOT NULL,
  `specialization` varchar(255) NOT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  `reg_number` varchar(255) DEFAULT NULL,
  `doctor_image` varchar(255) DEFAULT NULL,
  `created_at` datetime(3) NOT NULL DEFAULT current_timestamp(3)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_schedule`
--

CREATE TABLE `doctor_schedule` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  `doctor_image` varchar(255) DEFAULT NULL,
  `weekly_schedule` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`weekly_schedule`)),
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `country` varchar(10) DEFAULT NULL,
  `state` varchar(10) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `pincode` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `map_link` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_schedule`
--

INSERT INTO `doctor_schedule` (`id`, `user_id`, `category_id`, `name`, `slug`, `amount`, `description`, `specialization`, `qualification`, `experience`, `doctor_image`, `weekly_schedule`, `meta_title`, `meta_description`, `country`, `state`, `city`, `pincode`, `address`, `map_link`, `created_at`, `updated_at`) VALUES
(22, 85960, 49, 'vf', 'vf-fd', 12.00, '', 'fd', 'df', 1, 'sellers/85960/doctors/2025/12/26/1766722795_694e0cebdc8d2.png', '[]', '', '', '', '', '', '', '', '', '2026-01-05 15:09:04', '2026-01-05 15:09:04');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime(3) NOT NULL DEFAULT current_timestamp(3)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `employee_id`, `user_id`, `name`, `position`, `email`, `phone`, `address`, `joining_date`, `image`, `created_at`) VALUES
(11, '1affbae8-55e1-40b6-aba1-b404a5ecb4b6', 27395, 'Deepak', 'Developer', 'deepakchitravel@gmail.com', '+919345604653', '1/60 Middle street ,Cholapandi', '2026-01-02', '/uploads/sellers/27395/employees/2026/01/02/emp_69574f7710837.png', '2026-01-02 10:24:16.049');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `date` date DEFAULT NULL,
  `start_time` varchar(50) DEFAULT NULL,
  `end_time` varchar(50) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `organizer` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `pincode` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `map_link` varchar(500) DEFAULT NULL,
  `comfort` varchar(255) DEFAULT NULL,
  `things_to_know` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`things_to_know`)),
  `terms` text DEFAULT NULL,
  `videos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`videos`)),
  `seat_layout` varchar(255) DEFAULT NULL,
  `created_at` datetime(3) NOT NULL DEFAULT current_timestamp(3)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_seat_layouts`
--

CREATE TABLE `event_seat_layouts` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `layout_json` longtext NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hotel_settings`
--

CREATE TABLE `hotel_settings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `day` enum('sun','mon','tue','wed','thu','fri','sat') NOT NULL,
  `time_slot` enum('morning','afternoon','evening','night') NOT NULL,
  `time_from` time NOT NULL,
  `time_to` time NOT NULL,
  `menu` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`menu`)),
  `tables_enabled` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_categories`
--

CREATE TABLE `item_categories` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_categories`
--

INSERT INTO `item_categories` (`id`, `user_id`, `name`, `created_at`) VALUES
(13, 27395, 'Chickenk', '2025-12-31 05:46:02'),
(14, 27395, 'Mutton', '2025-12-31 05:46:07'),
(15, 27395, 'Fish', '2025-12-31 05:46:11'),
(16, 27395, 'Pizza', '2025-12-31 05:46:16'),
(17, 27395, 'Burger', '2025-12-31 05:46:21'),
(18, 27395, 'Brotta', '2025-12-31 05:46:32'),
(19, 27395, 'Samza', '2025-12-31 05:46:37'),
(20, 27395, 'Samosa', '2025-12-31 05:46:43'),
(21, 27395, 'Vada', '2025-12-31 05:46:48'),
(22, 27395, 'Idli', '2025-12-31 05:46:54'),
(23, 27395, 'Sambar', '2025-12-31 05:47:01'),
(24, 27395, 'Pongal', '2025-12-31 05:47:07');

-- --------------------------------------------------------

--
-- Table structure for table `managers`
--

CREATE TABLE `managers` (
  `id` int(11) NOT NULL,
  `manager_id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `image` varchar(191) NOT NULL,
  `created_at` datetime(3) NOT NULL DEFAULT current_timestamp(3),
  `role` varchar(191) NOT NULL DEFAULT 'staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `managers`
--

INSERT INTO `managers` (`id`, `manager_id`, `name`, `email`, `password`, `image`, `created_at`, `role`) VALUES
(1, 123, 'Harish', 'admin@demo.com', '$2y$10$e2dZtcN/.C1jekx25lRGu.P/Hz0LqxBOpkxgFImwxhFwYrEdAZKB6', 'managers/6932cda0557ae.jpg', '2024-11-14 06:43:53.000', 'admin'),
(5, 6917, '', 'admin@ztorespot.com', '$2y$10$gQ4ofBHlmsg8YaJ0fL.hrujcJcA36pHZUuN3K6PsyTThO1FXinoyG', 'static/user.png', '2025-12-01 16:14:45.922', 'staff');

-- --------------------------------------------------------

--
-- Table structure for table `manual_payment_methods`
--

CREATE TABLE `manual_payment_methods` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `instructions` longtext NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime(3) NOT NULL DEFAULT current_timestamp(3)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `user_id`, `name`, `active`, `created_at`) VALUES
(21, 27395, 'South Indian Style', 1, '2025-12-30 08:31:55'),
(22, 27395, 'Korean Style', 1, '2025-12-30 08:32:07'),
(23, 27395, 'Chinese style', 1, '2025-12-30 12:56:13'),
(24, 27395, 'North Indian Style', 1, '2025-12-31 06:03:05');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `type` enum('veg','nonveg') DEFAULT 'veg',
  `active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `food_type` enum('veg','nonveg') NOT NULL DEFAULT 'veg',
  `halal` tinyint(1) NOT NULL DEFAULT 0,
  `stock_type` enum('unlimited','limited','out') NOT NULL DEFAULT 'unlimited',
  `stock_qty` int(11) DEFAULT NULL,
  `stock_unit` varchar(50) DEFAULT NULL,
  `customer_limit` int(11) DEFAULT NULL,
  `customer_limit_period` enum('per_order','per_day','per_week','per_month') DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `user_id`, `menu_id`, `category_id`, `name`, `description`, `price`, `type`, `active`, `created_at`, `food_type`, `halal`, `stock_type`, `stock_qty`, `stock_unit`, `customer_limit`, `customer_limit_period`, `image`, `updated_at`) VALUES
(30, 27395, 24, 13, 'Chicken', 'Taste is best.', 22.00, 'veg', 1, '2026-01-02 10:52:39', 'nonveg', 1, 'unlimited', NULL, NULL, 33, 'per_order', '/uploads/sellers/27395/menu-settings/2026/01/02/iphone_1767351159.png', '2026-01-06 06:49:12'),
(31, 27395, 24, 13, 'sd', 'sd', 22.00, 'veg', 1, '2026-01-03 04:39:56', 'veg', 1, 'limited', 33, 'pcs', NULL, NULL, '/uploads/sellers/27395/menu-settings/2026/01/03/mouse_1767415195.webp', '2026-01-06 08:19:35'),
(32, 27395, 24, 23, 'xdv', 'sdf', 22.00, 'veg', 1, '2026-01-06 08:19:50', '', 1, 'unlimited', NULL, NULL, NULL, NULL, '', '2026-01-06 08:19:50');

-- --------------------------------------------------------

--
-- Table structure for table `menu_item_variations`
--

CREATE TABLE `menu_item_variations` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mrp_price` decimal(10,2) NOT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `discount_percent` int(11) DEFAULT 0,
  `dine_in_price` decimal(10,2) DEFAULT NULL,
  `takeaway_price` decimal(10,2) DEFAULT NULL,
  `delivery_price` decimal(10,2) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_item_variations`
--

INSERT INTO `menu_item_variations` (`id`, `item_id`, `user_id`, `name`, `mrp_price`, `selling_price`, `discount_percent`, `dine_in_price`, `takeaway_price`, `delivery_price`, `is_active`, `created_at`) VALUES
(56, 30, 27395, 'Small', 55.00, 44.00, 20, 55.00, 33.00, 44.00, 1, '2026-01-02 12:36:07'),
(57, 30, 27395, 'Medium', 332.00, 22.00, 93, 321.00, 22.00, 33.00, 1, '2026-01-02 12:36:07'),
(59, 31, 27395, 'sdf', 33.00, 22.00, 33, NULL, NULL, NULL, 1, '2026-01-03 04:46:14'),
(60, 32, 27395, 'sdf', 33.00, 22.00, 33, NULL, NULL, NULL, 1, '2026-01-06 08:19:50');

-- --------------------------------------------------------

--
-- Table structure for table `plugins`
--

CREATE TABLE `plugins` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `field_label` varchar(255) NOT NULL,
  `field_placeholder` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_settings`
--

CREATE TABLE `restaurant_settings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_time` varchar(10) DEFAULT NULL,
  `start_meridiem` varchar(2) DEFAULT NULL,
  `end_time` varchar(10) DEFAULT NULL,
  `end_meridiem` varchar(2) DEFAULT NULL,
  `break_start` varchar(10) DEFAULT NULL,
  `break_end` varchar(10) DEFAULT NULL,
  `operating_days` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`operating_days`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurant_settings`
--

INSERT INTO `restaurant_settings` (`id`, `user_id`, `start_time`, `start_meridiem`, `end_time`, `end_meridiem`, `break_start`, `break_end`, `operating_days`, `created_at`) VALUES
(47, 27395, '09:00', 'AM', '10:00', 'PM', NULL, NULL, '[\"Mon\",\"Tue\",\"Wed\",\"Thu\",\"Fri\",\"Sat\"]', '2026-01-06 10:06:42');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_tables`
--

CREATE TABLE `restaurant_tables` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `table_number` varchar(10) NOT NULL,
  `seats` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurant_tables`
--

INSERT INTO `restaurant_tables` (`id`, `user_id`, `table_number`, `seats`, `created_at`) VALUES
(18, 27395, 'T01', 4, '2026-01-06 11:07:02'),
(19, 27395, 'T02', 2, '2026-01-06 11:07:02'),
(20, 27395, 'XC', 4, '2026-01-06 11:07:02');

-- --------------------------------------------------------

--
-- Table structure for table `service_images`
--

CREATE TABLE `service_images` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime(3) NOT NULL DEFAULT current_timestamp(3)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_images`
--

INSERT INTO `service_images` (`id`, `service_id`, `image`, `created_at`) VALUES
(118, 10, '/uploads/sellers/85698/services/additional/2025/12/17/add_694247cb42188.webp', '2025-12-17 11:57:16.437'),
(119, 10, '/uploads/sellers/85698/services/additional/2025/12/17/add_694247cb42ebd.png', '2025-12-17 11:57:16.440');

-- --------------------------------------------------------

--
-- Table structure for table `service_types`
--

CREATE TABLE `service_types` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_types`
--

INSERT INTO `service_types` (`id`, `code`, `name`, `created_at`) VALUES
(1, 'HOSPITAL', 'Hospital', '2025-12-17 14:29:20'),
(2, 'HOTEL', 'Hotel', '2025-12-17 14:29:20'),
(3, 'OTHER', 'Others', '2025-12-17 14:29:20');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `app_name` varchar(191) NOT NULL,
  `currency` varchar(191) NOT NULL,
  `gst_tax_type` varchar(255) DEFAULT NULL,
  `gst_number` varchar(255) DEFAULT NULL,
  `gst_percentage` int(11) NOT NULL DEFAULT 0,
  `favicon` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `logo` varchar(255) NOT NULL,
  `disclaimer` text DEFAULT NULL,
  `timezone` varchar(100) NOT NULL DEFAULT 'Asia/Kolkata',
  `razorpay_key_id` varchar(255) DEFAULT NULL,
  `razorpay_key_secret` varchar(255) DEFAULT NULL,
  `phonepe_key_merchant_id` varchar(255) DEFAULT NULL,
  `phonepe_key_index` varchar(255) DEFAULT NULL,
  `phonepe_key` varchar(255) DEFAULT NULL,
  `payu_merchant_key` varchar(255) DEFAULT NULL,
  `payu_salt` varchar(255) DEFAULT NULL,
  `payu_client_id` varchar(255) DEFAULT NULL,
  `payu_client_secret` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `app_name`, `currency`, `gst_tax_type`, `gst_number`, `gst_percentage`, `favicon`, `address`, `logo`, `disclaimer`, `timezone`, `razorpay_key_id`, `razorpay_key_secret`, `phonepe_key_merchant_id`, `phonepe_key_index`, `phonepe_key`, `payu_merchant_key`, `payu_salt`, `payu_client_id`, `payu_client_secret`) VALUES
(1, 'Book Pannu', 'USD', 'exclusive', '33AACCZ2135N1Z8', 18, 'settings/6933b7691e08d.png', 'simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry', 'settings/6933b7691cc4a.png', 'simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it. ', 'America/New_York', 'rzp_test_RGZZjGF5vUiIUz', 'V8ToWLDw00mE6BtGNWoCxgwR', '', '', '', 'gtKFFx', '4R38IvwiV57FwVpsgOvTXBdLE4tHUXFW', '39e62683c5fc5436e3aeb84dcf487f63513ef38c1c71df51c8db35d8b131656d', '1cb5eef2cd8c7b79af76d4971bbb777d80da93f14089b3f7a8e071ab1fe912e5');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `currency` varchar(255) NOT NULL DEFAULT 'INR',
  `country` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `sharing_image_preview` varchar(255) DEFAULT NULL,
  `gst_number` varchar(191) DEFAULT NULL,
  `gst_type` varchar(191) DEFAULT NULL,
  `tax_percent` decimal(5,2) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `pinterest` varchar(255) DEFAULT NULL,
  `cash_in_hand` tinyint(1) DEFAULT NULL,
  `razorpay_key_id` varchar(255) DEFAULT NULL,
  `phonepe_salt_key` varchar(255) DEFAULT NULL,
  `phonepe_salt_index` varchar(255) DEFAULT NULL,
  `phonepe_merchant_id` varchar(255) DEFAULT NULL,
  `payu_api_key` varchar(255) DEFAULT NULL,
  `payu_salt` varchar(255) DEFAULT NULL,
  `sunday` tinyint(1) NOT NULL DEFAULT 0,
  `sunday_starts` varchar(255) DEFAULT NULL,
  `sunday_ends` varchar(255) DEFAULT NULL,
  `monday` tinyint(1) NOT NULL DEFAULT 1,
  `monday_starts` varchar(255) DEFAULT NULL,
  `monday_ends` varchar(255) DEFAULT NULL,
  `tuesday` tinyint(1) NOT NULL DEFAULT 1,
  `tuesday_starts` varchar(255) DEFAULT NULL,
  `tuesday_ends` varchar(255) DEFAULT NULL,
  `wednesday` tinyint(1) NOT NULL DEFAULT 1,
  `wednesday_starts` varchar(255) DEFAULT NULL,
  `wednesday_ends` varchar(255) DEFAULT NULL,
  `thursday` tinyint(1) NOT NULL DEFAULT 1,
  `thursday_starts` varchar(255) DEFAULT NULL,
  `thursday_ends` varchar(255) DEFAULT NULL,
  `friday` tinyint(1) NOT NULL DEFAULT 1,
  `friday_starts` varchar(255) DEFAULT NULL,
  `friday_ends` varchar(255) DEFAULT NULL,
  `saturday` tinyint(1) NOT NULL DEFAULT 0,
  `saturday_starts` varchar(255) DEFAULT NULL,
  `saturday_ends` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `user_id`, `logo`, `favicon`, `phone`, `whatsapp`, `email`, `currency`, `country`, `state`, `address`, `meta_title`, `meta_description`, `sharing_image_preview`, `gst_number`, `gst_type`, `tax_percent`, `facebook`, `twitter`, `instagram`, `linkedin`, `youtube`, `pinterest`, `cash_in_hand`, `razorpay_key_id`, `phonepe_salt_key`, `phonepe_salt_index`, `phonepe_merchant_id`, `payu_api_key`, `payu_salt`, `sunday`, `sunday_starts`, `sunday_ends`, `monday`, `monday_starts`, `monday_ends`, `tuesday`, `tuesday_starts`, `tuesday_ends`, `wednesday`, `wednesday_starts`, `wednesday_ends`, `thursday`, `thursday_starts`, `thursday_ends`, `friday`, `friday_starts`, `friday_ends`, `saturday`, `saturday_starts`, `saturday_ends`) VALUES
(14, 27395, 'sellers/27395/site-settings/logo/2025/12/17/logo_6942a478ae072.png', 'sellers/27395/site-settings/favicon/2025/12/17/favicon_6942a47bb6819.png', '', '', '', 'INR', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL),
(15, 85960, 'sellers/85960/site-settings/logo/2026/01/03/logo_6958cdda803ce.png', 'sellers/85960/site-settings/favicon/2026/01/03/favicon_6958cdde20219.png', '88888 88888', '88888 88888', 'deepakchitravel@gmail.com', 'GTQ', 'AS', '03', '1/60 Middle street ,Cholapandi', NULL, NULL, NULL, NULL, NULL, NULL, 'facebook', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 0, NULL, NULL),
(16, 32128, 'sellers/32128/site-settings/logo/2026/01/05/logo_695ba749bc174.jpg', 'sellers/32128/site-settings/favicon/2026/01/05/favicon_695ba6573524e.jpg', '8015021359', '8015021359', 'harish@gmail.com', 'INR', 'IN', '', '1Milestone Technology Solution Private Limited\nNO 1, SIVAN KOVIL STREET,\nNeedamangalam,\nTamil Nadu - 614404', 'fd', 'fdhdf', 'sellers/32128/seo-settings/preview-image/2026/01/05/seo_695bb08e43c0b.png', '33AACCZ2135N1Z7', 'inclusive', 5.00, 'https://wwww', NULL, 'https://4r4r', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subscription_histories`
--

CREATE TABLE `subscription_histories` (
  `id` int(11) NOT NULL,
  `invoice_number` int(11) NOT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `payment_method` varchar(191) NOT NULL,
  `payment_id` varchar(191) NOT NULL,
  `currency` varchar(191) NOT NULL,
  `amount` int(11) NOT NULL,
  `gst_amount` int(11) DEFAULT NULL,
  `gst_type` varchar(191) DEFAULT NULL,
  `gst_number` varchar(191) DEFAULT NULL,
  `gst_percentage` int(11) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `phone` varchar(191) NOT NULL,
  `address_1` varchar(191) NOT NULL,
  `address_2` varchar(191) DEFAULT NULL,
  `state` varchar(191) NOT NULL,
  `city` varchar(191) NOT NULL,
  `pin_code` varchar(191) NOT NULL,
  `country` varchar(191) NOT NULL,
  `created_at` datetime(3) NOT NULL DEFAULT current_timestamp(3),
  `currency_symbol` varchar(10) DEFAULT '₹'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscription_histories`
--

INSERT INTO `subscription_histories` (`id`, `invoice_number`, `plan_id`, `user_id`, `payment_method`, `payment_id`, `currency`, `amount`, `gst_amount`, `gst_type`, `gst_number`, `gst_percentage`, `discount`, `name`, `email`, `phone`, `address_1`, `address_2`, `state`, `city`, `pin_code`, `country`, `created_at`, `currency_symbol`) VALUES
(43, 1, 5, 32128, 'razorpay', 'pay_S0aReDx6lnyazS', 'INR', 1999, 305, 'exclusive', '', 18, 0, 'Harish', 'harish@gmail.com', '8015021359', 'Manojipatti', 'church', 'Tamil Nadu', 'Thanjavur', '613004', 'IN', '2026-01-06 17:36:26.000', '₹');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_plans`
--

CREATE TABLE `subscription_plans` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `previous_amount` int(11) DEFAULT NULL,
  `duration` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `feature_lists` longtext NOT NULL,
  `appointments_limit` varchar(191) NOT NULL,
  `events_limit` varchar(191) NOT NULL DEFAULT 'unlimited',
  `customers_limit` varchar(191) NOT NULL,
  `categories_limit` varchar(191) NOT NULL,
  `services_limit` varchar(191) NOT NULL,
  `coupons_limit` varchar(191) NOT NULL,
  `manual_payment_methods_limit` varchar(191) NOT NULL,
  `razorpay` tinyint(1) NOT NULL,
  `phonepe` tinyint(1) NOT NULL,
  `payu` tinyint(1) NOT NULL,
  `created_at` datetime(3) NOT NULL DEFAULT current_timestamp(3),
  `plan_id` varchar(255) NOT NULL,
  `is_disabled` tinyint(1) NOT NULL DEFAULT 0,
  `is_trial` tinyint(1) NOT NULL DEFAULT 0,
  `gst_type` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscription_plans`
--

INSERT INTO `subscription_plans` (`id`, `name`, `amount`, `previous_amount`, `duration`, `description`, `feature_lists`, `appointments_limit`, `events_limit`, `customers_limit`, `categories_limit`, `services_limit`, `coupons_limit`, `manual_payment_methods_limit`, `razorpay`, `phonepe`, `payu`, `created_at`, `plan_id`, `is_disabled`, `is_trial`, `gst_type`) VALUES
(1, 'Free Trial', 1, 0, 30, 'Start your dream online store for free for 3 days +GST\r\n\r\n', 'Appointments Limit - 2.,\r\nCustomers Limit - 2.,\r\nCategories Limit - 2.,\r\nServices Limit - 2.,\r\nCoupons Limit - 2.,\r\nManual Pay - 2.', '2', '2', '2', '2', '2', '2', '2', 1, 0, 1, '2024-11-14 06:55:02.000', '65b9324d-7a3d-42f1-b4a9-50be0a4a2021', 1, 1, 'exclusive'),
(4, 'Welcome', 169, 597, 180, 'Start your dream online store for Just ₹199/2 month with GST.\r\n', 'Appointments Limit - 6.,\r\nCustomers Limit - 6.,\r\nCategories Limit -6.,\r\nServices Limit - 6.,\r\nCoupons Limit - 6.,\r\nManual Pay - 6.', '6', '6', '6', '6', '6', '6', '6', 1, 0, 0, '2024-11-16 08:10:42.670', '91272600-4e06-6e9b-d015-f7ed634828c2', 1, 0, 'exclusive'),
(5, 'Intermediate', 1694, 3999, 365, 'Normal Plan 499/3months', 'Appointments Limit - 10.,\r\nCustomers Limit - 10.,\r\nCategories Limit - 10.,\r\nServices Limit - 10.,\r\nCoupons Limit - 10.,\r\nManual Pay - 10.', '10', '10', '10', '10', '10', '10', '10', 1, 0, 0, '2024-11-17 14:00:20.721', 'f8b5fc4c-8325-5380-8e99-3ac8f709c7a1', 1, 0, 'exclusive'),
(8, 'Professional', 2542, 4999, 365, 'mass da mama', 'Appointments Limit - unlimited.,\r\nCustomers Limit - unlimited.,\r\nCategories Limit - unlimited.,\r\nServices Limit - unlimited.,\r\nCoupons Limit - unlimited.,\r\nManual Pay - unlimited.', 'unlimited', 'unlimited', 'unlimited', 'unlimited', 'unlimited', '5', 'unlimited', 1, 0, 0, '2025-12-03 11:38:37.639', 'b187cf4c-158c-11e0-15cc-b58e78e900d0', 1, 0, 'exclusive');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` int(11) NOT NULL,
  `table_number` varchar(10) DEFAULT NULL,
  `seats` int(11) DEFAULT NULL,
  `settings_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `site_name` varchar(255) NOT NULL,
  `site_slug` varchar(255) NOT NULL,
  `service_type_id` int(11) DEFAULT NULL,
  `created_at` datetime(3) NOT NULL DEFAULT current_timestamp(3),
  `customersId` int(11) DEFAULT NULL,
  `expires_on` datetime(3) DEFAULT NULL,
  `is_suspended` tinyint(1) NOT NULL DEFAULT 0,
  `plan_id` int(11) DEFAULT NULL,
  `api_token` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `name`, `email`, `phone`, `password`, `country`, `image`, `site_name`, `site_slug`, `service_type_id`, `created_at`, `customersId`, `expires_on`, `is_suspended`, `plan_id`, `api_token`) VALUES
(19, 27395, 'Deepak', 'deepakchitravel@gmail.com', '9999999999', '$2y$10$Vf7t3oIdH96mti70dVzHd.3a.oHPGKQ8osGKXoJcKaMHvTmBQqNM2', 'IN', '/uploads/sellers/27395/profile/2025/12/26/profile_694e78e003a25_iphone.png', 'dee', 'dee', 2, '2025-12-17 14:56:55.000', NULL, NULL, 0, NULL, 'b7f44d79343e5faa14e334f4901206cddcdd5d6c923a118e9386344b1fe9c4a3'),
(20, 32128, 'Harish', 'harish@gmail.com', '8015021359', '$2y$10$URaYlOqpg7kNxJD6iPRvqOYmdQubbWO2nMCXwpm/5.1MNUVRWbxRK', 'IN', '/uploads/sellers/32128/profile/2026/01/05/profile_695b94bf6ddd3_WIN_20251007_16_32_05_Pro.jpg', 'harish', 'harish', 3, '2025-12-17 16:33:20.000', NULL, NULL, 0, NULL, 'da88d1aa322a7d254c18229f15da6198afa6a9d6f73c97ce7f9efd7e08def2d7'),
(21, 85960, 'Barani', 'barani@gmail.com', '8888888888', '$2y$10$O2IXDlnxui79fRrLa1urfekm36QJyExJCoYFfiTZfemObqxdfZjDq', 'IN', NULL, 'sorry_sir', 'sorry_sir', 1, '2025-12-17 17:46:24.000', NULL, '2029-01-05 06:42:14.000', 0, 5, 'bcf299234450ff2bd788840008d7b2564d4006c6d935e1fd45e7b5f81b86db6a');

-- --------------------------------------------------------

--
-- Table structure for table `website_pages`
--

CREATE TABLE `website_pages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext DEFAULT NULL,
  `page_id` varchar(255) NOT NULL,
  `created_at` datetime(3) NOT NULL DEFAULT current_timestamp(3)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `website_settings`
--

CREATE TABLE `website_settings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hero_title` varchar(255) NOT NULL,
  `hero_description` longtext NOT NULL,
  `hero_image` varchar(255) NOT NULL,
  `nav_links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`nav_links`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `_prisma_migrations`
--

CREATE TABLE `_prisma_migrations` (
  `id` varchar(36) NOT NULL,
  `checksum` varchar(64) NOT NULL,
  `finished_at` datetime(3) DEFAULT NULL,
  `migration_name` varchar(255) NOT NULL,
  `logs` text DEFAULT NULL,
  `rolled_back_at` datetime(3) DEFAULT NULL,
  `started_at` datetime(3) NOT NULL DEFAULT current_timestamp(3),
  `applied_steps_count` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `_prisma_migrations`
--

INSERT INTO `_prisma_migrations` (`id`, `checksum`, `finished_at`, `migration_name`, `logs`, `rolled_back_at`, `started_at`, `applied_steps_count`) VALUES
('09244bc7-506b-455c-84fd-a906a560b7e2', 'e740a6dce962ce1da376938b97cc139bb7c1373f92eb3d2fa55abffb6d0430b7', '2024-11-14 00:39:00.943', '20241110090106_', NULL, NULL, '2024-11-14 00:39:00.941', 1),
('1e529ef0-3622-410b-901b-6dd7ec109991', 'ab7f4882c05896de13a3a7767721fd0644a8279c9aaaeb4bfd4434556669edad', '2024-11-14 00:39:00.863', '20240908135704_', NULL, NULL, '2024-11-14 00:39:00.860', 1),
('1e816e6d-cc27-47ef-a1aa-cad46c5545a7', '66c09bb1430897332e55daeae3efcb7b28b4119800044ad76f0ac5b287bb2bfd', '2024-11-14 00:39:00.922', '20241109013123_', NULL, NULL, '2024-11-14 00:39:00.920', 1),
('26cb7145-4e9d-4794-8ad3-9f1ba02ffc6b', '38a8d7498e94fc36f6704adc8d3438651dca3fcc05aee48939a7de495ed9312d', '2024-11-14 00:39:00.919', '20241109002530_', NULL, NULL, '2024-11-14 00:39:00.917', 1),
('36fbd5bf-b5f9-4418-9db5-bb39be2e18f3', '92c049148f580b6c55040337e08a139dc0e2c5d9225ea0efcd7e99970e03d50e', '2024-11-16 01:55:51.946', '20241116015551_', NULL, NULL, '2024-11-16 01:55:51.942', 1),
('3af53457-9105-4962-8249-63d21199c88b', 'e20c2fd5db7f2ca0f40aaf3676785cc9705f20c10a6279a5c3b4d7f338e20fc5', '2024-11-14 00:39:00.823', '20240903102652_', NULL, NULL, '2024-11-14 00:39:00.806', 1),
('488ba3a3-6b16-42d4-9a6e-4fb1aebcab1e', 'fa895d3cf47dbc13f91339500bf2fae07385d36de2f7ac16be737d6a1017b08b', '2024-11-14 00:39:00.897', '20240909075429_', NULL, NULL, '2024-11-14 00:39:00.865', 1),
('6ce13c0d-76ec-447a-92b6-e09ddc06cf29', '250a30145becf1e36d2cd0d0ef7dbe8eb2b175b2fddcabeef23dab201d6611e2', '2024-11-17 04:38:18.124', '20241117043818_', NULL, NULL, '2024-11-17 04:38:18.107', 1),
('70df7102-69b3-4ec9-a4a1-d9e7007cf68b', 'd301a6f7efb9fd5d6ac108722e169163132f8d8581665c4ac05835023b772bbc', '2024-11-16 04:39:55.395', '20241116043955_', NULL, NULL, '2024-11-16 04:39:55.366', 1),
('712d0196-6b26-4395-916a-4b3d5451e13a', 'b13d506647675c8c5e7bb66a32c10f75e1dafb18f50898c38ff95d3febbfc738', '2024-11-14 00:39:00.901', '20240910001952_', NULL, NULL, '2024-11-14 00:39:00.897', 1),
('75870991-11ef-477b-a90c-bad0b9d439b4', '603baf253f952d970c7770402c2890481977908dac72ad6efd6392a8ec48522b', '2024-11-14 00:39:00.915', '20240911112218_', NULL, NULL, '2024-11-14 00:39:00.901', 1),
('8b735286-36a7-456b-8fa4-e49db9d6990a', '4a1113aae89840cd1f01b42936690065c9763f959c9b7c2eef64a44e479ac7ec', '2024-11-14 00:39:00.865', '20240909002158_', NULL, NULL, '2024-11-14 00:39:00.863', 1),
('8ea421b3-e2df-4474-8834-18f9462d7422', 'a2077d8bf6f6f2527dcc6518cc076a21932ad0f92383553839d3372cf4cddacb', '2024-11-14 00:54:50.905', '20241114005450_', NULL, NULL, '2024-11-14 00:54:50.897', 1),
('a1b001a8-fc30-4552-b346-0aebc53ce621', '2c155ccdae8f4ec4c2bcc7630207cd44128b11d48534efd8b118567ab2079e7a', '2024-11-16 02:38:58.707', '20241116023858_', NULL, NULL, '2024-11-16 02:38:58.686', 1),
('a8a20513-3b9f-4e78-9602-5cd9ca7d6ad2', '27222a3c7e8eb9b359b71670fad0b93defbb82f2b44fb297ad3ac0203c1a0929', '2024-11-14 00:39:00.962', '20241114003815_', NULL, NULL, '2024-11-14 00:39:00.944', 1),
('ac511439-b437-422b-9b45-19ac6f84fdd5', '2b8a851fa460c8a1ab2c7f591b2801d54d98e946f4712bda413633a0d1faabd7', '2024-11-14 00:39:00.941', '20241110085638_', NULL, NULL, '2024-11-14 00:39:00.932', 1),
('ad312240-a04f-4259-a224-f1547ced7d11', '2f781ac3639ab9d76eba792a6fc537eef905813fab974cc491f5c6bb695315b5', '2024-11-14 00:39:00.806', '20240820102253_', NULL, NULL, '2024-11-14 00:39:00.485', 1),
('bf88fe4c-baec-43fa-aebd-de7cac864130', '7a6c16d8ab0e0a8fb78e970c899d18d73f83ceba39a6953469636116f86607e6', '2024-11-14 00:39:00.859', '20240908135217_', NULL, NULL, '2024-11-14 00:39:00.839', 1),
('cbdee804-d018-4a1a-97fb-b8ea1fb8b134', 'ca8fa5ab781c7d08cb200855d32e5dfb126c52ddffc7a512d80d879f82818094', '2024-11-14 00:39:00.917', '20240911112333_', NULL, NULL, '2024-11-14 00:39:00.915', 1),
('d19f1886-b354-4ddd-bfe2-39d40721f6a3', '231c86e551593d49aac005ccaee17571eee422c4dfd5d9a84507575df268fede', '2024-11-14 01:47:26.891', '20241114014726_', NULL, NULL, '2024-11-14 01:47:26.885', 1),
('e1e1ed63-cae3-4e21-957b-44489c3e575e', '3aa252b64a539d8f2512d545890170af65b3e1232ef53414bcc8801ddb5569d7', '2024-11-14 00:39:03.253', '20241114003903_', NULL, NULL, '2024-11-14 00:39:03.226', 1),
('ea627bd5-8e2e-4f28-a460-3be5560a997e', 'c2eab32a876380cdd473e435f1f6320a6edce46f6ab2afed3c48f5a82f88b787', '2024-11-14 00:39:00.932', '20241109103135_', NULL, NULL, '2024-11-14 00:39:00.922', 1),
('eeba9adb-85da-4811-bc58-9549e41e6c3c', 'd2a546b543750e4e54082cf7bf57955c5b56eb4c7488732e3fedeac053aa1935', '2024-11-14 00:39:00.839', '20240908134722_', NULL, NULL, '2024-11-14 00:39:00.823', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `appointments_appointment_id_key` (`appointment_id`),
  ADD KEY `appointments_user_id_fkey` (`user_id`),
  ADD KEY `appointments_customer_id_fkey` (`customer_id`),
  ADD KEY `appointments_service_id_fkey` (`service_id`),
  ADD KEY `appointments_employee_id_fkey` (`employee_id`);

--
-- Indexes for table `appointment_settings`
--
ALTER TABLE `appointment_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `service_id` (`service_id`);

--
-- Indexes for table `available_areas`
--
ALTER TABLE `available_areas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `available_areas_area_id_key` (`area_id`),
  ADD KEY `available_areas_user_id_fkey` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_category_id_key` (`category_id`),
  ADD KEY `categories_user_id_fkey` (`user_id`);

--
-- Indexes for table `configured_plugins`
--
ALTER TABLE `configured_plugins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `configured_plugins_plugin_id_fkey` (`plugin_id`),
  ADD KEY `configured_plugins_user_id_fkey` (`user_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_coupon_id_key` (`coupon_id`),
  ADD KEY `coupons_user_id_fkey` (`user_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_customer_id_key` (`customer_id`),
  ADD KEY `customers_user_id_fkey` (`user_id`);

--
-- Indexes for table `dashboard_messages`
--
ALTER TABLE `dashboard_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_department_id_key` (`department_id`),
  ADD KEY `departments_user_id_fkey` (`user_id`);

--
-- Indexes for table `department_additional_images`
--
ALTER TABLE `department_additional_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `discounts_eligibility_fkey` (`eligibility`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `doctor_schedule`
--
ALTER TABLE `doctor_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_employee_id_key` (`employee_id`),
  ADD KEY `employees_user_id_fkey` (`user_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_user_id_fkey` (`user_id`);

--
-- Indexes for table `event_seat_layouts`
--
ALTER TABLE `event_seat_layouts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_event` (`event_id`);

--
-- Indexes for table `hotel_settings`
--
ALTER TABLE `hotel_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `day` (`day`),
  ADD KEY `time_slot` (`time_slot`);

--
-- Indexes for table `item_categories`
--
ALTER TABLE `item_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `managers`
--
ALTER TABLE `managers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `managers_manager_id_key` (`manager_id`);

--
-- Indexes for table `manual_payment_methods`
--
ALTER TABLE `manual_payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `manual_payment_methods_user_id_fkey` (`user_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `menu_item_variations`
--
ALTER TABLE `menu_item_variations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `plugins`
--
ALTER TABLE `plugins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_settings`
--
ALTER TABLE `restaurant_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_restaurant_settings_user` (`user_id`);

--
-- Indexes for table `restaurant_tables`
--
ALTER TABLE `restaurant_tables`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_table_per_user` (`user_id`,`table_number`);

--
-- Indexes for table `service_images`
--
ALTER TABLE `service_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_images_service_id_fkey` (`service_id`);

--
-- Indexes for table `service_types`
--
ALTER TABLE `service_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `site_settings_user_id_key` (`user_id`),
  ADD UNIQUE KEY `site_settings_gst_number_key` (`gst_number`);

--
-- Indexes for table `subscription_histories`
--
ALTER TABLE `subscription_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscription_histories_plan_id_fkey` (`plan_id`),
  ADD KEY `subscription_histories_user_id_fkey` (`user_id`);

--
-- Indexes for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscription_plans_plan_id_key` (`plan_id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `settings_id` (`settings_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_user_id_key` (`user_id`),
  ADD UNIQUE KEY `users_phone_key` (`phone`),
  ADD UNIQUE KEY `users_site_name_key` (`site_name`),
  ADD UNIQUE KEY `users_site_slug_key` (`site_slug`),
  ADD UNIQUE KEY `users_email_key` (`email`),
  ADD KEY `users_plan_id_fkey` (`plan_id`),
  ADD KEY `fk_users_service_type` (`service_type_id`);

--
-- Indexes for table `website_pages`
--
ALTER TABLE `website_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `website_pages_user_id_key` (`user_id`),
  ADD UNIQUE KEY `website_pages_page_id_key` (`page_id`);

--
-- Indexes for table `website_settings`
--
ALTER TABLE `website_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `website_settings_user_id_key` (`user_id`);

--
-- Indexes for table `_prisma_migrations`
--
ALTER TABLE `_prisma_migrations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointment_settings`
--
ALTER TABLE `appointment_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `available_areas`
--
ALTER TABLE `available_areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `configured_plugins`
--
ALTER TABLE `configured_plugins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `dashboard_messages`
--
ALTER TABLE `dashboard_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `department_additional_images`
--
ALTER TABLE `department_additional_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `doctor_schedule`
--
ALTER TABLE `doctor_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `event_seat_layouts`
--
ALTER TABLE `event_seat_layouts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `hotel_settings`
--
ALTER TABLE `hotel_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_categories`
--
ALTER TABLE `item_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `managers`
--
ALTER TABLE `managers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `manual_payment_methods`
--
ALTER TABLE `manual_payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `menu_item_variations`
--
ALTER TABLE `menu_item_variations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `plugins`
--
ALTER TABLE `plugins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `restaurant_settings`
--
ALTER TABLE `restaurant_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `restaurant_tables`
--
ALTER TABLE `restaurant_tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `service_images`
--
ALTER TABLE `service_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `service_types`
--
ALTER TABLE `service_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `subscription_histories`
--
ALTER TABLE `subscription_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `website_pages`
--
ALTER TABLE `website_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `website_settings`
--
ALTER TABLE `website_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_customer_id_fkey` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `appointments_employee_id_fkey` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `appointments_service_id_fkey` FOREIGN KEY (`service_id`) REFERENCES `appointment_settings` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `appointments_user_id_fkey` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `available_areas`
--
ALTER TABLE `available_areas`
  ADD CONSTRAINT `available_areas_user_id_fkey` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_user_id_fkey` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `configured_plugins`
--
ALTER TABLE `configured_plugins`
  ADD CONSTRAINT `configured_plugins_plugin_id_fkey` FOREIGN KEY (`plugin_id`) REFERENCES `plugins` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `configured_plugins_user_id_fkey` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `coupons`
--
ALTER TABLE `coupons`
  ADD CONSTRAINT `coupons_user_id_fkey` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `fk_customers_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_user_id_fkey` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `discounts`
--
ALTER TABLE `discounts`
  ADD CONSTRAINT `discounts_eligibility_fkey` FOREIGN KEY (`eligibility`) REFERENCES `subscription_plans` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `fk_doctors_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_user_id_fkey` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_user_id_fkey` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_seat_layouts`
--
ALTER TABLE `event_seat_layouts`
  ADD CONSTRAINT `fk_event_layout` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `manual_payment_methods`
--
ALTER TABLE `manual_payment_methods`
  ADD CONSTRAINT `manual_payment_methods_user_id_fkey` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menu_item_variations`
--
ALTER TABLE `menu_item_variations`
  ADD CONSTRAINT `fk_variation_item` FOREIGN KEY (`item_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_images`
--
ALTER TABLE `service_images`
  ADD CONSTRAINT `service_images_service_id_fkey` FOREIGN KEY (`service_id`) REFERENCES `appointment_settings` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD CONSTRAINT `site_settings_user_id_fkey` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subscription_histories`
--
ALTER TABLE `subscription_histories`
  ADD CONSTRAINT `subscription_histories_plan_id_fkey` FOREIGN KEY (`plan_id`) REFERENCES `subscription_plans` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `subscription_histories_user_id_fkey` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tables`
--
ALTER TABLE `tables`
  ADD CONSTRAINT `tables_ibfk_1` FOREIGN KEY (`settings_id`) REFERENCES `restaurant_settings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_service_type` FOREIGN KEY (`service_type_id`) REFERENCES `service_types` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `users_plan_id_fkey` FOREIGN KEY (`plan_id`) REFERENCES `subscription_plans` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `website_pages`
--
ALTER TABLE `website_pages`
  ADD CONSTRAINT `website_pages_user_id_fkey` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `website_settings`
--
ALTER TABLE `website_settings`
  ADD CONSTRAINT `website_settings_user_id_fkey` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
