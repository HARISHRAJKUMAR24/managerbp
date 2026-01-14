-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 14, 2026 at 12:02 PM
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
(16, 879456, 27395, 'Deepak C', NULL, '+919345604653', '$2y$10$QPL9d82JH/LNZHoQtKV9.eHxV51h8gC9IGTVP4dgbUmKPv7Rb3Nwi', NULL, '2025-12-27 06:10:11.098'),
(17, 902977, 85960, 'Deepak', 'deepakchitravel@gmail.com', '+919999999999', '$2y$10$6OIlWZCT0QX81qlXrkpGW.M17scGPqEGLxsErNQrjuP3JQA1Zxrme', NULL, '2026-01-08 10:02:05.397'),
(18, 256423, 85960, 'Arun', 'arun@gmail.com', '+918888888888', '$2y$10$1gggU70XYk17tTbE8t5/ze4wv4WALVC.HBoem3n3y2BPF61l7jVvK', NULL, '2026-01-08 10:40:39.829'),
(19, 151380, 85960, 'Harish', 'harish@gmail.com', '+917777777777', '$2y$10$TYtf0qfhBo.E9Lhh8x7I8OGWMNxoEBjC2lizW0BfHgVJ.Vx6SRwcW', NULL, '2026-01-08 11:52:28.741');

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
(92, 'new seller see this This plan is intermeite', 'yes it work visible for This plan is intermeite', 'hours', 1, '2026-01-09 07:22:41', '[\"5\"]', 1, '2026-01-09 06:20:10', '2026-01-09 06:22:41');

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
-- Table structure for table `doctor_appointments`
--

CREATE TABLE `doctor_appointments` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `slot_from` time NOT NULL,
  `slot_to` time NOT NULL,
  `tokens` int(11) DEFAULT 1,
  `notes` text DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT 'confirmed',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_appointments`
--

INSERT INTO `doctor_appointments` (`id`, `customer_id`, `doctor_id`, `appointment_date`, `slot_from`, `slot_to`, `tokens`, `notes`, `amount`, `status`, `created_at`) VALUES
(1, 902977, 25, '2026-01-10', '02:02:00', '05:05:00', 2, 'sd', 886.00, 'confirmed', '2026-01-09 11:09:55'),
(2, 902977, 25, '2026-01-10', '02:02:00', '05:05:00', 2, 'sd', 886.00, 'confirmed', '2026-01-09 11:12:03'),
(3, 902977, 25, '2026-01-17', '02:02:00', '05:05:00', 1, '', 443.00, 'confirmed', '2026-01-12 04:31:20'),
(4, 902977, 25, '2026-01-24', '02:02:00', '05:05:00', 1, '', 443.00, 'confirmed', '2026-01-12 05:23:33');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_appointment_files`
--

CREATE TABLE `doctor_appointment_files` (
  `id` int(11) NOT NULL,
  `doctor_appointment_id` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_appointment_files`
--

INSERT INTO `doctor_appointment_files` (`id`, `doctor_appointment_id`, `file_name`, `file_path`, `file_type`, `file_size`, `created_at`) VALUES
(1, 2, 'Economic System.pdf', '1767957123_Economic System.pdf', 'application/pdf', 106402, '2026-01-09 11:12:03');

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
  `token_limit` int(11) NOT NULL DEFAULT 0,
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
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `leave_dates` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`leave_dates`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_schedule`
--

INSERT INTO `doctor_schedule` (`id`, `user_id`, `category_id`, `name`, `slug`, `amount`, `token_limit`, `description`, `specialization`, `qualification`, `experience`, `doctor_image`, `weekly_schedule`, `meta_title`, `meta_description`, `country`, `state`, `city`, `pincode`, `address`, `map_link`, `created_at`, `updated_at`, `leave_dates`) VALUES
(25, 85960, 49, 'vf', 'vf-fd', 443.00, 2, '', 'fd', 'df', 1, 'sellers/85960/doctors/2025/12/26/1766722795_694e0cebdc8d2.png', '{\"Sun\":{\"enabled\":true,\"slots\":[{\"from\":\"02:02\",\"to\":\"05:05\",\"breakFrom\":\"\",\"breakTo\":\"\",\"token\":\"66\"}]},\"Mon\":{\"enabled\":false,\"slots\":[]},\"Tue\":{\"enabled\":false,\"slots\":[]},\"Wed\":{\"enabled\":false,\"slots\":[]},\"Thu\":{\"enabled\":false,\"slots\":[]},\"Fri\":{\"enabled\":false,\"slots\":[]},\"Sat\":{\"enabled\":false,\"slots\":[]}}', 'sfwer', 'werwer', 'AF', 'BDS', 'Ashkāsham', '6666666', '34wqer', 'https://maps.google.com/maps?q=34wqer%20Ashk%C4%81sham%206666666&z=15&output=embed', '2026-01-09 10:37:54', '2026-01-13 17:35:23', '[\"2026-01-13\",\"2026-01-16\",\"2026-01-27\",\"2026-04-02\"]');

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
-- Table structure for table `manager_login_tokens`
--

CREATE TABLE `manager_login_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expires_at` datetime NOT NULL,
  `used` tinyint(4) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manager_login_tokens`
--

INSERT INTO `manager_login_tokens` (`id`, `user_id`, `token`, `expires_at`, `used`, `created_at`) VALUES
(62, 85960, '62384eca623c4e4819395baf416d07de7e6c585f4238dfa8de4a014cb0157548', '2026-01-14 06:30:35', 0, '2026-01-14 05:28:35'),
(63, 85960, '7d1499fa1827b85daba660095cc5444c87e59d88a0909f44ed636bf56bba9a99', '2026-01-14 06:35:44', 0, '2026-01-14 05:33:44'),
(64, 85960, '1f0d17858f1dcb879d4043940331afe80b7f5914bcd84f6f486601601d48ad5a', '2026-01-14 06:40:50', 0, '2026-01-14 05:38:50'),
(65, 85960, '4f6a605901efeb02da32fd1045a727c64caa4b78dff451f180fc4b09d82e2fb9', '2026-01-14 06:45:27', 0, '2026-01-14 05:43:27'),
(67, 85960, '19d1cba5a9a6e4e7aab629bedefa36c376ae537de930664dd0d6116e06ee7e47', '2026-01-14 06:48:50', 0, '2026-01-14 05:46:50'),
(76, 85960, 'a1b5b2368789ed0bd34f2c288ce67662d4ffbcb7138ac29eff76c8d1598d8796', '2026-01-14 07:32:47', 0, '2026-01-14 06:30:47'),
(77, 85960, 'a3bcc6d7e9c61e04aa5beb2a25cc6ad8811a755669f94f8dfb87c91cf9de6e3b', '2026-01-14 07:33:26', 0, '2026-01-14 06:31:26'),
(79, 85960, '6803bdba8b896252d416fb090777a9add18bceee4a608bfeccbbeeaef3f3fe5f', '2026-01-14 07:56:06', 0, '2026-01-14 06:54:07'),
(80, 85960, '9976bde7edb7be0a94f6686d8c4fdb8785461c478061f0d4d6cbeb1922316a8a', '2026-01-14 07:56:19', 0, '2026-01-14 06:54:19'),
(81, 85960, '50f1cb03b89555369558218b2469469ceb5bffe8be8be7851d41db59b1be7646', '2026-01-14 07:58:16', 0, '2026-01-14 06:56:16'),
(82, 85960, 'e5d202c8f60046bdebf0be191fa916ecc81e9fc8f69ba54e61f91d208e34eb21', '2026-01-14 08:05:50', 0, '2026-01-14 07:03:50'),
(83, 85960, 'ac2ce2bf3ad78a0aa3adbb17879880b725a72a6a486b72c7ddcedd11f3305b3f', '2026-01-14 08:12:49', 0, '2026-01-14 07:10:49'),
(84, 85960, '090f7a21632db92abe8027b113e8d143876119b6dafa85c5765ff89306953d4d', '2026-01-14 08:14:56', 0, '2026-01-14 07:12:56'),
(85, 85960, '1a198b2b9362dcdff8877f949cbb8cfcb38ad7ecf8621d1b8f73907ac8a48d24', '2026-01-14 08:18:42', 0, '2026-01-14 07:16:42');

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

--
-- Dumping data for table `manual_payment_methods`
--

INSERT INTO `manual_payment_methods` (`id`, `user_id`, `name`, `icon`, `instructions`, `image`, `created_at`) VALUES
(12, 32128, 'upi', 'uploads/sellers/32128/manual_payment/logo/2026/01/13/1768283552_logo_airpots.webp', '\r\n\r\n', 'uploads/sellers/32128/manual_payment/image/2026/01/13/1768283552_image_keyboard.webp', '2026-01-13 11:22:32.652'),
(13, 32128, 'phonepay', 'uploads/sellers/32128/manual_payment/logo/2026/01/13/1768304192_logo_smartwatch.webp', 'none', 'uploads/sellers/32128/manual_payment/image/2026/01/13/1768304192_image_keyboard.webp', '2026-01-13 17:06:32.344');

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
(30, 27395, 24, 13, 'Chicken', 'Taste is best.', 22.00, 'veg', 0, '2026-01-02 10:52:39', 'nonveg', 1, 'unlimited', NULL, NULL, 33, 'per_order', '/uploads/sellers/27395/menu-settings/2026/01/02/iphone_1767351159.png', '2026-01-07 11:03:20'),
(31, 27395, 24, 13, 'sd', 'sd', 22.00, 'veg', 0, '2026-01-03 04:39:56', 'veg', 1, 'limited', 33, 'pcs', NULL, NULL, '/uploads/sellers/27395/menu-settings/2026/01/03/mouse_1767415195.webp', '2026-01-07 11:03:19'),
(33, 27395, 23, 15, 'sdf', 'sdf', 33.00, 'veg', 1, '2026-01-07 12:50:43', 'veg', 0, 'unlimited', NULL, NULL, NULL, NULL, '', '2026-01-07 12:50:43');

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
(63, 33, 27395, 'sdf', 33.00, 33.00, 0, NULL, NULL, NULL, 1, '2026-01-07 12:50:43');

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
-- Table structure for table `seller_sso_tokens`
--

CREATE TABLE `seller_sso_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expires_at` datetime NOT NULL,
  `used` tinyint(4) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seller_sso_tokens`
--

INSERT INTO `seller_sso_tokens` (`id`, `user_id`, `token`, `expires_at`, `used`, `created_at`) VALUES
(1, 22431, 'e821835fd68a7054959ca7e5b319f27b3058a39a8035eab2f7dddd1d497fc92f', '2026-01-13 23:52:33', 1, '2026-01-13 18:21:33'),
(2, 27395, '945a22dfd046bb90e6ef2c063abd7e1638436055e7a10afc446a7fe6a15c2b6e', '2026-01-13 23:53:19', 1, '2026-01-13 18:22:19'),
(3, 22431, '9af7ef7d106d02325b730080746a96d3da3c9426f3d0f51952f51b355a41905e', '2026-01-13 23:57:23', 1, '2026-01-13 18:26:23'),
(4, 27395, '24a2db33df00c42b5ced9eedcbbf5be960d14ca70537f555c99428ebc55973e8', '2026-01-13 23:57:43', 1, '2026-01-13 18:26:43'),
(5, 27395, '78057d192d7c2890e1f99e31cc53cfe6564ce69cf96d38d8a29ca4ea725c4509', '2026-01-13 23:57:53', 1, '2026-01-13 18:26:53'),
(6, 22431, 'da73d0e01cd019e1260515b9a06853976a0622bff701d0891cc5e2cf30835115', '2026-01-13 23:59:00', 1, '2026-01-13 18:28:00'),
(7, 85960, '780c77aa9b1b92bc0c0e99ff1821c7cc981d07ec7ef0a9cd990874d624356d58', '2026-01-13 23:59:37', 1, '2026-01-13 18:28:37'),
(8, 85960, '2ae9f83549d0120ac987ad473f48d835cbdb6744753718a71a94936e5da4fe5b', '2026-01-14 00:00:36', 1, '2026-01-13 18:29:36'),
(9, 27395, '9e490fb90e95f4a0ee1dfca2c61deef9180328c52e851b6c845dbfbcd9a8f449', '2026-01-14 00:01:45', 1, '2026-01-13 18:30:45'),
(10, 27395, 'e077e5dec3ed05925485c8ba76e0e2acedd8b4a344809bb2b74b0d873286a90d', '2026-01-14 00:02:16', 1, '2026-01-13 18:31:16'),
(11, 85960, 'f8c817db6aeeb04ec58378246f62bf68f54de3065d455ae318320eb62c2f3684', '2026-01-14 00:04:54', 1, '2026-01-13 18:33:54'),
(12, 85960, '8b41b2db574c12d0fce60f8cc99e1d8286dbf100b8e225daefa426ddae5bb06c', '2026-01-14 00:09:41', 1, '2026-01-13 18:38:41'),
(13, 85960, 'e8d2d6b7ee8076387d0e88996bb1bb6a9780fd624d23d6cd414f317f7a5cb217', '2026-01-14 00:10:00', 1, '2026-01-13 18:39:00'),
(14, 85960, 'f4d76e2d67043b397ed289b34d3aff5a36df876bed83a0c57ce73b81ca348d94', '2026-01-14 00:10:29', 1, '2026-01-13 18:39:29'),
(15, 85960, '991c2f30012aaaeea03bdb2c048722a2b91ee38053c62a32414f8ed613a92e30', '2026-01-14 00:11:04', 1, '2026-01-13 18:40:04'),
(16, 85960, '22dd9f4d4272f669ad4aa95bdbd1d7cbe551c316c3620c348f30c160066e72a1', '2026-01-14 00:11:52', 1, '2026-01-13 18:40:52'),
(17, 85960, 'dc32c6de0dbf2bbd4416b426a8c6cae17f42a9900d895f17f8e8188484d6de33', '2026-01-14 00:12:35', 1, '2026-01-13 18:41:35'),
(18, 85960, '381927a86be1601622e8d9eb08ea5d73eb881aa3fd9e56bfa0873a265faef6bf', '2026-01-14 00:13:57', 0, '2026-01-13 18:42:57'),
(19, 85960, '0826d6bfd6dea88b9d6cd5fcca8fae0a68ad8d7d42bf7f18483a9363973ac3fc', '2026-01-14 00:14:11', 1, '2026-01-13 18:43:11'),
(20, 85960, 'a7f31e63290a7f1cabdba2c68c839998758d9b4a4a1c64d067b0ad2c1494e608', '2026-01-14 00:16:25', 1, '2026-01-13 18:45:25'),
(21, 85960, '2b32bcc6a8c8741a3587b365814d04328fa225bee95f9efc377dc3d372f0981b', '2026-01-14 00:19:03', 1, '2026-01-13 18:48:03'),
(22, 85960, '391e936ff742d8e07a0a72e7c9b69acf7a417c0b79256f25d08ff69e4c916fc1', '2026-01-14 00:20:26', 1, '2026-01-13 18:49:26'),
(23, 85960, '4ed35ffab97df9ce80d5f8a7b1c47fd61213dd714e933b0a835de67a79162bd9', '2026-01-14 00:21:14', 1, '2026-01-13 18:50:14'),
(24, 85960, 'cb58f2f1423c26760d3ca3a0d6a691a844d1585294dad734ad4fddd72e388f7d', '2026-01-14 00:23:59', 0, '2026-01-13 18:52:59'),
(25, 85960, 'ec11b1b2fa3b516b63387985b368332e778a0f3e4324241826578842a5ec0070', '2026-01-14 00:24:51', 0, '2026-01-13 18:53:51'),
(26, 85960, 'e24be76ac711bd32af158a661d775b25bd0f1a6391a48322d957f0fbf54d9cc3', '2026-01-14 09:41:54', 0, '2026-01-14 04:10:54'),
(27, 85960, 'f5d5c12c2b4855a21fc1d984bcd4afef26c51d1052627a29dfc5c9db4f840ce5', '2026-01-14 09:45:17', 0, '2026-01-14 04:14:17'),
(28, 85960, 'a20ffe42852503df7d586949f7db4b91009646eb22e88a8ec38b4ea70c1cc64b', '2026-01-14 09:45:35', 0, '2026-01-14 04:14:35'),
(29, 85960, '94ece43e65d179204f143e9e46a9d24406d4025c9a3e290d4375ebb4a14f2bfc', '2026-01-14 09:46:41', 0, '2026-01-14 04:15:41'),
(30, 32128, 'c3ebcd99647e1abc95e0a1e77989adcfc1ec4dff91e333d1ec08d6a66abc7bf2', '2026-01-14 09:47:07', 0, '2026-01-14 04:16:07'),
(31, 32128, '0867ce7965d471370ebf2668cb72cf28ef10d820e6d2c8f3ec05a357ec5ec678', '2026-01-14 09:54:33', 0, '2026-01-14 04:23:33'),
(32, 85960, '8fdad2eede8942bcc31212a92cdeef94bb1fb73ed15f6601d61d1ad943d185b0', '2026-01-14 09:57:04', 0, '2026-01-14 04:26:04'),
(33, 85960, 'eb6db3b235af1326ba07cb7c734269a7bfdcffa8ad3242bddd6b6de2e2fdfdf7', '2026-01-14 09:58:05', 0, '2026-01-14 04:27:05'),
(34, 85960, '21b7d859d79d93b9d44f0ed7140064b1d8f2ab12ca54c6e31e7410bee82768b2', '2026-01-14 10:10:09', 0, '2026-01-14 04:39:09'),
(35, 85960, '5208cca6bd595057bb3776c6e5bab931545a243b41e53d0e97703cec2db3419c', '2026-01-14 10:12:09', 0, '2026-01-14 04:41:09'),
(36, 32128, '5266529c670dbc272c8a074868ee61c153ae58127481afe78d41a72bac9ec2a7', '2026-01-14 10:13:14', 0, '2026-01-14 04:42:14'),
(37, 85960, '00831a6922a241c3b91a74263a03a9cfc262e18fb415b20845fc37a33a87f74d', '2026-01-14 08:26:01', 0, '2026-01-14 07:24:01'),
(38, 85960, '105a3c4987d97153123b598db352bd54287debc8e4010a42a1227a05955226ec', '2026-01-14 08:29:00', 0, '2026-01-14 07:27:00'),
(39, 85960, '16a3102e5bfdd9cfa5345d181f85d55b4ebd7d1a6cd4fe28c0c2a501d522ddde', '2026-01-14 08:29:16', 0, '2026-01-14 07:27:16'),
(40, 32128, 'e70f86660ffe1f1b7672442c1c82bfafe8bd7483d822ec106ce489be96172a1c', '2026-01-14 08:39:58', 0, '2026-01-14 07:37:58'),
(41, 32128, '72226129dd0ea940d5dab2bf90690bee1e7ce5c4af115d273f4616b16b7559f7', '2026-01-14 08:42:20', 0, '2026-01-14 07:40:20'),
(42, 32128, 'ce718f30f7ca7d4edc9ec67c4e12d1820b0f40acbc091498e9118a888b7cf414', '2026-01-14 13:17:19', 0, '2026-01-14 07:45:19'),
(43, 32128, 'f0b5e82e8bab978bc831de482882c8286c4f0e42e0cb4e43ee952c7a097fa489', '2026-01-14 13:17:56', 0, '2026-01-14 07:45:56'),
(44, 32128, '66f544aa93850dd95deae7435adc3fe87f1df0d4cb246e88b2539f19cedd62f9', '2026-01-14 13:18:13', 0, '2026-01-14 07:46:13'),
(45, 32128, '376d115495dbe40c2abe934196862a3eaeb1061014714eb7ada31e7971a286d2', '2026-01-14 13:21:31', 0, '2026-01-14 07:49:31'),
(46, 32128, 'cde3b833905df69d6c911fd43e88f7baa8d14bbd848327585636944055956058', '2026-01-14 13:21:39', 0, '2026-01-14 07:49:39'),
(47, 85960, '72e5b33266176530a3e89c4040ad3b0c403d8871146c4f44b39360baf60d3917', '2026-01-14 13:30:39', 0, '2026-01-14 07:58:39'),
(48, 85960, '52b033d1b4f4940b7cd46c0263f21416d0f9b08feed95f2a52d15b48146646e8', '2026-01-14 13:30:55', 0, '2026-01-14 07:58:55'),
(49, 85960, '975acf40d63b8244f58664cb8ca89c38dda2ed5990754611062b3c71778be51e', '2026-01-14 13:31:02', 0, '2026-01-14 07:59:02'),
(50, 85960, 'b67bf5e3dec1e0127255f202da453de9f9da40c780bf9d6fe1f50cb280ccfa8e', '2026-01-14 13:31:54', 0, '2026-01-14 07:59:54'),
(51, 85960, 'dcdcd21aa0f19b492adc7b9396f0099eb69996cadeb71014ea87f39c965bed41', '2026-01-14 13:32:19', 0, '2026-01-14 08:00:19'),
(52, 85960, 'aba78b77e280991095a69c6c15b55cad5fd2aacf4e8bc2d03ac4b0ae851f22ff', '2026-01-14 13:32:25', 0, '2026-01-14 08:00:25'),
(53, 85960, '8bf05fe0013f6348f9a4aa9ae6016f212465a96bb604df26cffeb38d23a7d629', '2026-01-14 13:37:28', 1, '2026-01-14 08:05:28'),
(54, 85960, '6865ffc065bed193214e911a39e1d3cd7a2c3c72ebc339c0bae76be95d7a82c3', '2026-01-14 13:48:14', 1, '2026-01-14 08:16:14'),
(55, 85960, 'c793c338e0efdd3cdfa2e814c30b6b3438a55ad52bdcf19bd5321cd0b2c705c6', '2026-01-14 14:00:28', 1, '2026-01-14 08:28:28'),
(56, 85960, '757a65ed6a4a3f17b9517592530380da29ae32d198405c8938f0eca0e44b6e60', '2026-01-14 14:01:44', 1, '2026-01-14 08:29:44'),
(57, 85960, 'e0368a5aeb6091f57cc1b437e85389f3f9dd7b2d5d4d62d4bca0be9bed74404c', '2026-01-14 14:03:57', 1, '2026-01-14 08:31:57'),
(58, 85960, 'f5ecacb4b68de09cfa312cf92183862abe38a90e5f2febda96fb813316b09d7a', '2026-01-14 14:20:54', 0, '2026-01-14 08:48:54'),
(59, 85960, 'c9cc0d379946bbdcf7bec68ac02837f3dad93350b457101d4be3ad4bde6ad4d2', '2026-01-14 14:22:00', 0, '2026-01-14 08:50:00'),
(60, 85960, 'c44cff45b5dde09f6a7e00a7ac2a8a46f1414ba2bc84756e6e7f7030636d431e', '2026-01-14 14:26:06', 0, '2026-01-14 08:54:06'),
(61, 85960, '31a69208b32841c911e9f185a1cf792e497042095a0657e827e5d859766a8ccf', '2026-01-14 14:27:12', 0, '2026-01-14 08:55:12'),
(62, 85960, 'aa2f14ed3571cabd5a7718276b88bf88bdc6d84fed243e0b679db1b37213a7e2', '2026-01-14 14:28:12', 0, '2026-01-14 08:56:12'),
(63, 85960, '844e8fa333459406d320e7f43944a1bf38e5cb4c3f2a0ded4d0f3b92c45433ea', '2026-01-14 14:28:38', 0, '2026-01-14 08:56:38'),
(64, 85960, '276275fbd37a705ed9842f8df003d489ced0e96d02968f502ebace45f4dbe309', '2026-01-14 14:29:20', 0, '2026-01-14 08:57:20'),
(65, 85960, 'ad42ed2a7fa47e9980f09a7366e443910a4a73b12a185e942927b37223100ba1', '2026-01-14 14:32:54', 1, '2026-01-14 09:00:54'),
(66, 85960, 'f40d12a7841ef1af865c2230c6caf22d3b1c90e939b479551fdbf2b0e17d5725', '2026-01-14 14:35:21', 0, '2026-01-14 09:03:21'),
(67, 85960, '6fb5a2e53660b91f07650b7649c8918d85a4747c43783542bcada004d6b63d56', '2026-01-14 14:35:31', 1, '2026-01-14 09:03:31'),
(68, 85960, '45fdbefa3d2436de562cbf2847e2b7eba043f6a47a122cafc3cee6ce9b9e5de1', '2026-01-14 14:37:59', 1, '2026-01-14 09:05:59'),
(69, 85960, 'f9293a85e8455871b95c3aadf93ddbd25e99ecea0c00fad34ca9cc9698dd536d', '2026-01-14 14:38:24', 1, '2026-01-14 09:06:24'),
(70, 85960, '4daec46affb5bd2788bdd6fa0f782d0015c18284ed3696c76f481009945f5c9a', '2026-01-14 14:41:30', 1, '2026-01-14 09:09:30'),
(71, 85960, 'e2d754d4506bffc0a677258b0e51930e69e3a012fd9ae8cfc772bc05a5482c06', '2026-01-14 14:46:43', 1, '2026-01-14 09:14:43'),
(72, 32128, 'a7ffca29be634a21c51a4af7711e4f8c33e3a0d6950a53ba5bff07b34829a9a5', '2026-01-14 14:47:04', 1, '2026-01-14 09:15:04'),
(73, 32128, 'add6fc1536737e5c244bb7b52e9150c122bdc0bdbe7d67fa59d99fad90c8f0af', '2026-01-14 14:47:12', 1, '2026-01-14 09:15:12'),
(74, 32128, 'cad998a66050ab3960540e8febaf06bbac5e55a4abeda4ad4ce6a0f702156196', '2026-01-14 14:54:12', 1, '2026-01-14 09:22:12'),
(75, 32128, '2026a7458d9410174d1f14cb6a741aac57cd4ce75ecd064dc1af906768d55e6c', '2026-01-14 14:54:29', 1, '2026-01-14 09:22:29'),
(76, 32128, '7a3c850b2d30cc132f07d91913c838ed39ae074f51371f32a74a45c7978552d8', '2026-01-14 14:54:40', 1, '2026-01-14 09:22:40'),
(77, 32128, 'd9e96c7cd7b84d96696bfe8aacfd3527097bceeaf7e268a102d760c12b190c75', '2026-01-14 14:54:58', 1, '2026-01-14 09:22:58'),
(78, 32128, 'cf03b4563d50e3775249c4bdf9d50629eece573f5d8fb83c9e50a96d031bffee', '2026-01-14 14:55:07', 1, '2026-01-14 09:23:07'),
(79, 85960, '0919cf52e8b9c3940370bb35e6029cb789831c5958d723e601e3da9a55a91f12', '2026-01-14 14:56:34', 1, '2026-01-14 09:24:34'),
(80, 85960, 'ac0ad2aaa1e3899eaaed97aa05a5819f0d230742de62182235b2fbae2c505513', '2026-01-14 14:56:41', 1, '2026-01-14 09:24:41'),
(81, 22431, '6e9dcba7a4fb02204315b4e92f11c1e6a7c0f6768416b433cbfbc6530ef4c5f5', '2026-01-14 14:57:04', 1, '2026-01-14 09:25:04'),
(82, 32128, '142db00a14388d87bf738cee0521f75865c6d1f7ffc7437673be9b807b4a773b', '2026-01-14 14:57:44', 1, '2026-01-14 09:25:44'),
(83, 32128, 'bd1c3ceb60346921ba91976d84366f8b17215666fa1272bf4b4e20284442ff0b', '2026-01-14 14:58:09', 1, '2026-01-14 09:26:09'),
(84, 32128, '93d598095ed94945da03e411a27d94210722f21326e748eae47fdb2a2c51a1c3', '2026-01-14 14:58:27', 1, '2026-01-14 09:26:27'),
(85, 32128, '59248eec62064db94c6c78ea2ba51ef4920bb76bf77750aa8a7866815261a803', '2026-01-14 15:03:41', 1, '2026-01-14 09:31:41'),
(86, 85960, '4d6c43ee0e8c84ba721c36b88324f6c42f1a8cba227331f65880cd844dd6787b', '2026-01-14 15:04:16', 1, '2026-01-14 09:32:16'),
(87, 85960, 'b1735a27de69885027846d47eb4eba747b1c94e31f8f52c717c0e20b64b337d7', '2026-01-14 15:04:24', 1, '2026-01-14 09:32:24'),
(88, 22431, 'a11abf3d64858f4e7fc99986914128be5f7ecd2e681fb05c4ef3269f97a627bd', '2026-01-14 15:07:31', 1, '2026-01-14 09:35:31'),
(89, 22431, '4968f8e57b808199ee1590be771d6e8d2658f954f985ebe0b114862af7bd2e75', '2026-01-14 15:07:39', 1, '2026-01-14 09:35:39'),
(90, 22431, 'b0bdcd3c8439837796f617adec52ffedc658d774cf442d9c3d59dbf7942c7ee9', '2026-01-14 15:07:54', 1, '2026-01-14 09:35:54'),
(91, 22431, '869040137267d32c14511ef808f9c878ed233204b3137686511fbfff53eb5ea7', '2026-01-14 15:08:34', 1, '2026-01-14 09:36:34'),
(92, 32128, 'b3e6402c3fb143f4d7828ee29ac7199e74080b3ff503b0a1296086e94cbfabdc', '2026-01-14 15:19:38', 0, '2026-01-14 09:47:38'),
(93, 32128, '30fdbbc6154933b3a4b1a9a3de91bed35f22eaf590ade9f2f818812faf0eab31', '2026-01-14 15:20:12', 0, '2026-01-14 09:48:12'),
(94, 32128, '3ddfc71487d1bf00112fd79cc14f703e192ae57522ad17d5cf3b8ca65dab24c8', '2026-01-14 15:20:32', 0, '2026-01-14 09:48:32'),
(95, 32128, 'd72591ccbdabab9a05074c916a9d7dbb7fec4b1c4894fa51967f04580970cb07', '2026-01-14 15:21:24', 1, '2026-01-14 09:49:24'),
(96, 32128, '6a7ebe91fd12e9f6838afcf30c4101a512cde498d18287d422a78e73e9b1215d', '2026-01-14 15:22:53', 1, '2026-01-14 09:50:53'),
(97, 32128, '0ce0716838ea991e5e51fa3eba2f5b62b3f45e71e5eec497d665965f7207f5bc', '2026-01-14 15:25:35', 1, '2026-01-14 09:53:35'),
(98, 32128, '32f81560571c81a1ad6100047069ba853c416adada815e932d3467e7e9caad80', '2026-01-14 15:28:34', 1, '2026-01-14 09:56:34'),
(99, 85960, '77c55e2e2974db309543fae3e41838465c55166d8d17f7e312b26c2958d21ccb', '2026-01-14 15:28:54', 1, '2026-01-14 09:56:54'),
(100, 85960, '1a33e89fdef305f250a022e91f6791946c80a030aa32070c0b569fe7a4c83cd2', '2026-01-14 15:29:04', 1, '2026-01-14 09:57:04'),
(101, 85960, 'e54c92a0c57dffc1a7abe6127ecd73006e047cc668c40d98c56e7161392c61a3', '2026-01-14 15:32:24', 1, '2026-01-14 10:00:24'),
(102, 32128, '67d7b45ccb4b0a574170d7400cdd736d277d7a05d84819a89c14fdffd394c08d', '2026-01-14 15:32:59', 1, '2026-01-14 10:00:59'),
(103, 32128, '4f9f6a5b5aeca3d0cd773e680bd33a4b95a06d9334a709b09b28558761182d9a', '2026-01-14 15:45:42', 1, '2026-01-14 10:13:42'),
(104, 32128, '2af7d0518761fbf2d63cbc31f40d235ab142dd96562fd2af9013d503f67189b6', '2026-01-14 15:48:34', 1, '2026-01-14 10:16:34'),
(105, 22431, 'd313ba618606ef607db0a21a621fc298b3b7e33ce9a337fbb404cc2f862f50e4', '2026-01-14 15:49:16', 1, '2026-01-14 10:17:16'),
(106, 27395, '76a4a28bc4554a65419cbcd26503fe784f22f36ec85546d91a6a3cb24d2bf971', '2026-01-14 15:49:43', 1, '2026-01-14 10:17:43'),
(107, 22431, '5cb09bc45cfb6fcb2047b16856b7a2fa72c31d428db4ce78646e20403725f0a9', '2026-01-14 15:52:01', 1, '2026-01-14 10:20:01'),
(108, 22431, 'fe53c9816dca84adea3865cd5881f736a378bc72957d97d1a0700845bd30dc16', '2026-01-14 15:52:41', 1, '2026-01-14 10:20:41'),
(109, 22431, 'd999531fdcdbfc2f3de2c51f8596a0ae268850f4598841cf289790b3b47eb364', '2026-01-14 15:52:58', 1, '2026-01-14 10:20:58'),
(110, 22431, '9175ba146b925db81da01887c34058128a3676806506e1d898551874a5e0cd39', '2026-01-14 15:53:20', 1, '2026-01-14 10:21:20'),
(111, 22431, '23ec977bc3752f6ef09963698b17450e5f5effe45a643c01dba16349bdea157c', '2026-01-14 15:53:29', 1, '2026-01-14 10:21:29'),
(112, 22431, '350554f8d781c81cc5a4263fcc2cd8addcea6cbb3f06529aaf5c82ca14f67f0e', '2026-01-14 15:53:36', 1, '2026-01-14 10:21:36'),
(113, 22431, '2a6f5e03733dcac3aca55d5db82e4fe6d0dc117525c5d767a06afbc51e480fe2', '2026-01-14 15:53:44', 1, '2026-01-14 10:21:44'),
(114, 22431, '472816f7c115416041d825803f487e6a95969c4bcb149ad31e257817753d81e1', '2026-01-14 15:53:51', 1, '2026-01-14 10:21:51'),
(115, 22431, 'cf6314bef23bfe6681054006ccfe0f2a1f6fb3b7ccff3dab30d14d4b42fb8144', '2026-01-14 15:54:23', 1, '2026-01-14 10:22:23'),
(116, 22431, 'db5f5f971850dc39f4dafb49ce35d44273cdf9a542cd319020f9ea4a87e3a4b4', '2026-01-14 15:54:53', 1, '2026-01-14 10:22:53'),
(117, 22431, '21594f92bb9d69cb9ef92536d5191dbe99069691958b36e3f4b1ae69e518cc92', '2026-01-14 15:55:01', 1, '2026-01-14 10:23:01'),
(118, 22431, '0a50a8fa467407de66de8381000991ce944b198fd1789a3a0ff0e172f886fabd', '2026-01-14 15:55:09', 1, '2026-01-14 10:23:09'),
(119, 22431, '261fbe9ef25e3e7b4b05e870da5bfeccb1f8d4246791dfcfb50c03af6e0004e9', '2026-01-14 15:56:07', 1, '2026-01-14 10:24:07'),
(120, 22431, 'ccab812d30be06e29e9dedc7ed3aa073a2645c07738524e88886de08525fbbb4', '2026-01-14 15:56:41', 1, '2026-01-14 10:24:41'),
(121, 85960, '129c601c74b250c27d926de837de2edc22661841fbc78da2b6301eebde39b5bc', '2026-01-14 15:57:21', 1, '2026-01-14 10:25:21'),
(122, 85960, '71389c6e3812651d179561489b3a5e8a92a3fb235297daa2534dd8481323eef9', '2026-01-14 15:57:33', 1, '2026-01-14 10:25:33'),
(123, 22431, 'd65813c8a3ad810baa8420001bfa22d337d11af15a39bdf528b8d2acfef72be6', '2026-01-14 16:00:12', 1, '2026-01-14 10:28:12'),
(124, 22431, 'bfc20d45a08d3f5854f6c6ed48936d536857960d4d1c005be38b731bd6218e71', '2026-01-14 16:03:31', 1, '2026-01-14 10:31:31'),
(125, 22431, '8dccf28895c38a67657bbaf0bd58a45e57675d99001e2b5c01e1ebaa6bcb67b9', '2026-01-14 16:03:39', 1, '2026-01-14 10:31:39'),
(126, 22431, '0010a419b6a002e3f3e85611a8061ba88d039b2699e6b622c53fdaab2e163f95', '2026-01-14 16:03:46', 1, '2026-01-14 10:31:46'),
(127, 22431, '54164f4f6ddba407749496a2e6493901fa00a1607122a1b678fc3510a44f34a1', '2026-01-14 16:04:03', 1, '2026-01-14 10:32:03'),
(128, 22431, '5791dc24d1a66ad82d0817b6f161776ab9f8e701641ef215ae518c2bd87c1eb9', '2026-01-14 16:04:18', 1, '2026-01-14 10:32:18'),
(129, 22431, '5b14f67fd62bb2019b7c94cd819f817f6440d6fc58d6f220bcfa37b7c3a1f8e4', '2026-01-14 16:04:57', 1, '2026-01-14 10:32:57'),
(130, 22431, 'd4d6bf1126441a49ccc427f4336d66293da1a648b73ce84f79c8c8b9cdb14094', '2026-01-14 16:05:07', 1, '2026-01-14 10:33:07'),
(131, 85960, 'e0e8b3fae91837fe761a045934b36d3508a6230271b3a828da4eca915a4b2bd8', '2026-01-14 16:05:21', 1, '2026-01-14 10:33:21'),
(132, 85960, 'd24180a9e7d70c5936d4f1c31b2ec94557071bd0dfb905a48a051dfc86ef870c', '2026-01-14 16:05:35', 1, '2026-01-14 10:33:35'),
(133, 32128, 'aa5dafc49103ab92dd7d60a256a8beb7dab9e2a4da511282539b14671e885db4', '2026-01-14 16:05:56', 1, '2026-01-14 10:33:56'),
(134, 85960, '260de15607dc31044e82b196a44b685791e1ca6f1c1a16d8466f0adac531869e', '2026-01-14 16:06:40', 1, '2026-01-14 10:34:40'),
(135, 85960, '944855655a21846f8cab2ab6996654bf5fe518e1685219fbf3962982c1336c6d', '2026-01-14 16:06:55', 1, '2026-01-14 10:34:55'),
(136, 85960, 'c586a8fb37fc6e31aa7c16a42a1f139248cfb1817e53c9b1e901695e5690b19b', '2026-01-14 16:07:01', 1, '2026-01-14 10:35:01'),
(137, 32128, '8b4a80eae36a83ff5b0916615deee203b89879e5076d24e5ccc5d81d634e0c91', '2026-01-14 16:07:16', 1, '2026-01-14 10:35:16'),
(138, 32128, '3af1fda83a49d772aaee1734b3d54ce763e12c30a85ec20d80f5271d634d1f1e', '2026-01-14 16:07:26', 1, '2026-01-14 10:35:26'),
(139, 85960, 'ea0d9ba0513f806be6b7b70fdb413bbb8645550aa7f0e35c8df4859d27c464ec', '2026-01-14 16:08:00', 1, '2026-01-14 10:36:00'),
(140, 27395, 'f0f2b057395c898675340ceeae4f94e4f29f09deafeca0574cad0df4d9a780c3', '2026-01-14 16:08:12', 1, '2026-01-14 10:36:12'),
(141, 22431, 'eed4cac1ff3facf9fe51a3f2bb252cafd9bedc92431c5f47a2d9fd5620084e11', '2026-01-14 16:08:26', 1, '2026-01-14 10:36:26'),
(142, 22431, '1d9ef51d5c33e27606d9889692006eb1c1035c1b43ac631aa36cce96e7014c4a', '2026-01-14 16:08:41', 1, '2026-01-14 10:36:41'),
(143, 22431, '57030ee2d79c92a63c8d9504223c5960ad3389d533b69d8f6aa191188f6e5a25', '2026-01-14 16:11:33', 1, '2026-01-14 10:39:33'),
(144, 22431, '169d5215f92804556f17f689353d27aec8fe68e958ced18c0f8a803e742fc95f', '2026-01-14 16:12:06', 1, '2026-01-14 10:40:06'),
(145, 22431, '3e3db46fc1ca7e537bfa07488e12b5e5b3b4fe305c26546ed5554465684426d9', '2026-01-14 16:12:44', 1, '2026-01-14 10:40:44'),
(146, 22431, '91d28cdc90f4e21ca5bd7aac1f21ece95004755e6fc583d83e011e9586363128', '2026-01-14 16:13:55', 1, '2026-01-14 10:41:55'),
(147, 22431, '76cc040e3747198c4684b6c6c4bfb449b4b2676bf37d43f27396d22f0a7d90e7', '2026-01-14 16:15:40', 1, '2026-01-14 10:43:40'),
(148, 85960, 'bbef665f51015a14390052034918a3b516cf2e7d73ddb25d33feb4e70ccffaf1', '2026-01-14 16:16:12', 1, '2026-01-14 10:44:12'),
(149, 85960, '5ff39425546eb1c382cb6385c65f0c051d05a8887db07df213d2211414f75c91', '2026-01-14 16:16:40', 1, '2026-01-14 10:44:40'),
(150, 32128, '0a08580cad83a27d457f3e05a6df9f255731dc8ee89fbc9966f907dc82f8afdf', '2026-01-14 16:17:05', 1, '2026-01-14 10:45:05'),
(151, 32128, '3f5d209596545642992ef7733b2b7a0e872d518c90ef8ec2042dd6276cb0a8d3', '2026-01-14 16:17:31', 0, '2026-01-14 10:45:31'),
(152, 32128, '5392ea5d19dbf3c3730efe492600cef04311464dcf4575ff09ffe0f261647677', '2026-01-14 16:17:50', 1, '2026-01-14 10:45:50'),
(153, 32128, '7fe8b1a21d5a74c3809eced76ff77eef38f89d16cde966fbaebdda0f67f8f981', '2026-01-14 16:20:23', 1, '2026-01-14 10:48:23'),
(154, 32128, 'd188e36fd3c339d32d117fd1f72aea27f18beea2a7064af78af8a3e7d4cc20b8', '2026-01-14 16:20:33', 1, '2026-01-14 10:48:33'),
(155, 32128, '30760829687ec48a9647a1d1a89775fd7b50a158ef7aafdb97d54cacdb6b607a', '2026-01-14 16:22:57', 1, '2026-01-14 10:50:57'),
(156, 85960, '6077f2327e1e1fde2174edb834e494090aede866ad98524eb2ab381c42e5fe70', '2026-01-14 16:25:26', 1, '2026-01-14 10:53:26');

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
(1, 'Book Pannu', 'INR', 'exclusive', '33AACCZ2135N1Z8', 18, 'settings/6933b7691e08d.png', 'simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry', 'settings/6933b7691cc4a.png', 'simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it. ', 'Asia/Kolkata', 'rzp_test_RGZZjGF5vUiIUz', 'V8ToWLDw00mE6BtGNWoCxgwR', '', '', '', 'gtKFFx', '4R38IvwiV57FwVpsgOvTXBdLE4tHUXFW', '39e62683c5fc5436e3aeb84dcf487f63513ef38c1c71df51c8db35d8b131656d', '1cb5eef2cd8c7b79af76d4971bbb777d80da93f14089b3f7a8e071ab1fe912e5');

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
  `razorpay_secret_key` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `user_id`, `logo`, `favicon`, `phone`, `whatsapp`, `email`, `currency`, `country`, `state`, `address`, `meta_title`, `meta_description`, `sharing_image_preview`, `gst_number`, `gst_type`, `tax_percent`, `facebook`, `twitter`, `instagram`, `linkedin`, `youtube`, `pinterest`, `cash_in_hand`, `razorpay_key_id`, `phonepe_salt_key`, `phonepe_salt_index`, `phonepe_merchant_id`, `payu_api_key`, `payu_salt`, `razorpay_secret_key`) VALUES
(14, 27395, 'sellers/27395/site-settings/logo/2025/12/17/logo_6942a478ae072.png', 'sellers/27395/site-settings/favicon/2025/12/17/favicon_6942a47bb6819.png', '', '', '', 'INR', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 85960, 'sellers/85960/site-settings/logo/2026/01/03/logo_6958cdda803ce.png', 'sellers/85960/site-settings/favicon/2026/01/03/favicon_6958cdde20219.png', '88888 88888', '88888 88888', 'deepakchitravel@gmail.com', 'GTQ', 'AS', '03', '1/60 Middle street ,Cholapandi', NULL, NULL, NULL, NULL, NULL, NULL, 'facebook', NULL, NULL, NULL, NULL, NULL, 1, 'dsf', 'wer', 'er', 'wer', 'dfg', 'sdf', 'sdf'),
(16, 32128, 'sellers/32128/site-settings/logo/2026/01/05/logo_695ba749bc174.jpg', 'sellers/32128/site-settings/favicon/2026/01/05/favicon_695ba6573524e.jpg', '8015021359', '8015021359', 'harish@gmail.com', 'INR', 'IN', '', '1Milestone Technology Solution Private Limited\nNO 1, SIVAN KOVIL STREET,\nNeedamangalam,\nTamil Nadu - 614404', 'fd', 'fdhdf', 'sellers/32128/seo-settings/preview-image/2026/01/05/seo_695bb08e43c0b.png', '33AACCZ2135N1Z7', 'inclusive', 5.00, 'https://wwww', NULL, 'https://4r4r', NULL, NULL, NULL, 1, '8015021359', NULL, NULL, NULL, NULL, NULL, '123');

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
(97, 1, 1, 32128, 'payu', '7a5e158b8e7accfbe398', 'INR', 1, 0, NULL, NULL, 0, 0, 'Harish', 'harish@gmail.com', '8015021359', 'Manojipatti', '', 'Tamil Nadu', 'Thanjavur', '613004', 'India', '2026-01-07 14:40:22.000', '₹'),
(98, 2, 1, 32128, 'payu', '98e57dff07b8a7f060d2', 'INR', 1, 0, NULL, NULL, 0, 0, 'Harish', 'harish@gmail.com', '8015021359', 'Manojipatti', '', 'Tamil Nadu', 'Thanjavur', '613004', 'India', '2026-01-07 14:41:35.000', '₹'),
(99, 3, 4, 32128, 'payu', 'edcc7d707815ac05700c', 'INR', 199, 0, NULL, NULL, 0, 0, 'Harish', 'harish@gmail.com', '8015021359', 'Manojipatti', '', 'Tamil Nadu', 'Thanjavur', '613004', 'India', '2026-01-07 14:43:41.000', '₹'),
(100, 4, 4, 32128, 'payu', '4aa10775f3c8304033a8', 'INR', 199, 0, NULL, NULL, 0, 0, 'Harish', 'harish@gmail.com', '8015021359', 'Manojipatti', '', 'Tamil Nadu', 'Thanjavur', '613004', 'India', '2026-01-07 14:46:54.000', '₹'),
(101, 5, 1, 32128, 'payu', 'e305439ba7c5ec1acd2e', 'INR', 1, 0, NULL, NULL, 0, 0, 'Harish', 'harish@gmail.com', '8015021359', 'Manojipatti', '', 'Tamil Nadu', 'Thanjavur', '613004', 'India', '2026-01-07 14:48:37.000', '₹'),
(102, 6, 1, 27395, 'payu', '3011b21ce850bbe854a4', 'INR', 1, 0, NULL, NULL, 0, 0, 'Deepak', 'deepakchitravel@gmail.com', '9999999999', 'Gopalasamudram', '', 'Tamil Nadu', 'Tiruvarur', '614001', 'India', '2026-01-07 18:14:17.000', '₹'),
(103, 7, 1, 22431, 'razorpay', 'pay_S1gF0nMHmK7c7A', 'INR', 1, 0, 'exclusive', '', 18, 0, 'Test', 'deepak@gmail.com', '7777777777', 'kathayee amman kovil street', 'uppukaratheru', 'Tamil Nadu', 'mannargudi', '614001', 'IN', '2026-01-09 11:55:40.000', '₹'),
(104, 8, 5, 22431, 'razorpay', 'pay_S1gGnq08kcE4YO', 'INR', 1999, 305, 'exclusive', '33AACCZ2135N1Z7', 18, 0, 'Test', 'deepak@gmail.com', '7777777777', 'Gopalasamudram', 'uppukaratheru', 'Tamil Nadu', 'Tiruvarur', '614001', 'India', '2026-01-09 11:57:22.000', '₹'),
(105, 9, 8, 22431, 'razorpay', 'pay_S1gIIIeZNPho8r', 'INR', 3000, 458, 'exclusive', '33AACCZ2135N1Z7', 18, 0, 'Test', 'deepak@gmail.com', '7777777777', 'Gopalasamudram', 'uppukaratheru', 'Tamil Nadu', 'Tiruvarur', '614001', 'India', '2026-01-09 11:58:47.000', '₹');

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
  `customers_limit` varchar(191) NOT NULL,
  `services_limit` varchar(191) NOT NULL,
  `menu_limit` varchar(191) NOT NULL DEFAULT 'unlimited',
  `coupons_limit` varchar(191) NOT NULL,
  `manual_payment_methods_limit` varchar(191) NOT NULL,
  `free_credits` varchar(191) NOT NULL DEFAULT 'unlimited',
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

INSERT INTO `subscription_plans` (`id`, `name`, `amount`, `previous_amount`, `duration`, `description`, `feature_lists`, `appointments_limit`, `customers_limit`, `services_limit`, `menu_limit`, `coupons_limit`, `manual_payment_methods_limit`, `free_credits`, `razorpay`, `phonepe`, `payu`, `created_at`, `plan_id`, `is_disabled`, `is_trial`, `gst_type`) VALUES
(1, 'Free Trial', 1, 0, 30, 'Start your dream online store for free for 3 days +GST\r\n\r\n', 'Appointments Limit - 2.,\r\nCustomers Limit - 2.,\r\nCategories Limit - 2.,\r\nServices Limit - 2.,\r\nCoupons Limit - 2.,\r\nManual Pay - 2.', '2', '2', '2', '2', '2', '2', '2', 1, 0, 1, '2024-11-14 06:55:02.000', '65b9324d-7a3d-42f1-b4a9-50be0a4a2021', 1, 1, 'exclusive'),
(4, 'Welcome', 169, 597, 180, 'Start your dream online store for Just ₹199/2 month with GST.\r\n', 'Appointments Limit - 6.,\r\nCustomers Limit - 6.,\r\nCategories Limit -6.,\r\nServices Limit - 6.,\r\nCoupons Limit - 6.,\r\nManual Pay - 6.', '6', '6', '6', 'unlimited', '6', '6', '6', 1, 0, 1, '2024-11-16 08:10:42.670', '91272600-4e06-6e9b-d015-f7ed634828c2', 1, 0, 'exclusive'),
(5, 'Intermediate', 1694, 3999, 365, 'Normal Plan 499/3months', 'Appointments Limit - 10.,\r\nCustomers Limit - 10.,\r\nCategories Limit - 10.,\r\nServices Limit - 10.,\r\nCoupons Limit - 10.,\r\nManual Pay - 10.', '10', '10', '10', 'unlimited', '10', '10', '10', 1, 0, 1, '2024-11-17 14:00:20.721', 'f8b5fc4c-8325-5380-8e99-3ac8f709c7a1', 1, 0, 'exclusive'),
(8, 'Professional', 2542, 4999, 365, 'mass da mama', 'Appointments Limit - unlimited.,\r\nCustomers Limit - unlimited.,\r\nCategories Limit - unlimited.,\r\nServices Limit - unlimited.,\r\nCoupons Limit - unlimited.,\r\nManual Pay - unlimited.', 'unlimited', 'unlimited', 'unlimited', 'unlimited', '5', 'unlimited', 'unlimited', 1, 0, 1, '2025-12-03 11:38:37.639', 'b187cf4c-158c-11e0-15cc-b58e78e900d0', 1, 0, 'exclusive');

-- --------------------------------------------------------

--
-- Table structure for table `suspend_users`
--

CREATE TABLE `suspend_users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reason` text DEFAULT NULL,
  `action_type` enum('suspend','unsuspend') NOT NULL,
  `created_at` datetime(3) NOT NULL DEFAULT current_timestamp(3)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suspend_users`
--

INSERT INTO `suspend_users` (`id`, `user_id`, `reason`, `action_type`, `created_at`) VALUES
(1, 22431, '', 'suspend', '2026-01-14 16:29:49.028');

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
(19, 27395, 'Deepak', 'deepakchitravel@gmail.com', '9999999999', '$2y$10$Vf7t3oIdH96mti70dVzHd.3a.oHPGKQ8osGKXoJcKaMHvTmBQqNM2', 'IN', '/uploads/sellers/27395/profile/2025/12/26/profile_694e78e003a25_iphone.png', 'dee', 'dee', 2, '2025-12-17 14:56:55.000', NULL, '2026-02-06 13:44:17.000', 0, 1, '5ab608d91d40dc8617365aafe03e1ade4695c5c90e7ac8ef89fbc5c0788158c8'),
(20, 32128, 'Harish', 'harish@gmail.com', '8015021359', '$2y$10$URaYlOqpg7kNxJD6iPRvqOYmdQubbWO2nMCXwpm/5.1MNUVRWbxRK', 'IN', '/uploads/sellers/32128/profile/2026/01/05/profile_695b94bf6ddd3_WIN_20251007_16_32_05_Pro.jpg', 'harish', 'harish', 3, '2025-12-17 16:33:20.000', NULL, '2026-02-06 10:18:37.000', 0, 1, '188e3a2e05ab86bbeb61d831d49ceef0dddb6d81dc4c27ee6350ff3a47f61d4f'),
(21, 85960, 'Barani', 'barani@gmail.com', '8888888888', '$2y$10$O2IXDlnxui79fRrLa1urfekm36QJyExJCoYFfiTZfemObqxdfZjDq', 'IN', NULL, 'sorry_sir', 'sorry_sir', 1, '2025-12-17 17:46:24.000', NULL, '2029-01-05 06:42:14.000', 0, 5, '14d68075380ae070ed5d4bc2b24674d61e878c5de7ae5079116b0222efb5528c'),
(22, 22431, 'Test', NULL, '7777777777', '$2y$10$Ved5KWItauFSS6B2kyRy7u21zlqjCUS/Q44XEQTtGcIqnCkJgskMO', 'IN', NULL, 'test', 'test', 3, '2026-01-09 11:53:56.000', NULL, '2027-01-09 07:28:47.000', 1, 8, '75ff1a6967dedc30d2f677ef229f89778fb8c00e2210779ab48292edc76e9fbf');

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
  `banners` longtext DEFAULT NULL,
  `nav_links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`nav_links`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `website_settings`
--

INSERT INTO `website_settings` (`id`, `user_id`, `hero_title`, `hero_description`, `hero_image`, `banners`, `nav_links`) VALUES
(10, 32128, 'werwer', 'uihiui', 'sellers/32128/website-settings/homepage/2026/01/13/hero_1768295109.webp', '[{\"path\":\"seller/32128/website-settings/homepage/banners/2026/01/13/banner_696621c2104ad0.29068474.webp\",\"title\":\"\",\"link\":\"\",\"order\":0},{\"path\":\"seller/32128/website-settings/homepage/banners/2026/01/13/banner_69662c50e37e64.77469248.webp\",\"title\":\"\",\"link\":\"\",\"order\":1},{\"path\":\"seller/32128/website-settings/homepage/banners/2026/01/13/banner_69662c57a620a1.70846872.webp\",\"title\":\"\",\"link\":\"\",\"order\":2}]', NULL);

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
-- Indexes for table `doctor_appointments`
--
ALTER TABLE `doctor_appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `appointment_date` (`appointment_date`);

--
-- Indexes for table `doctor_appointment_files`
--
ALTER TABLE `doctor_appointment_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_appointment_id` (`doctor_appointment_id`);

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
-- Indexes for table `manager_login_tokens`
--
ALTER TABLE `manager_login_tokens`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `seller_sso_tokens`
--
ALTER TABLE `seller_sso_tokens`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `suspend_users`
--
ALTER TABLE `suspend_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_suspend_users_user` (`user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `dashboard_messages`
--
ALTER TABLE `dashboard_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

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
-- AUTO_INCREMENT for table `doctor_appointments`
--
ALTER TABLE `doctor_appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `doctor_appointment_files`
--
ALTER TABLE `doctor_appointment_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `doctor_schedule`
--
ALTER TABLE `doctor_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `managers`
--
ALTER TABLE `managers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `manager_login_tokens`
--
ALTER TABLE `manager_login_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `manual_payment_methods`
--
ALTER TABLE `manual_payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `menu_item_variations`
--
ALTER TABLE `menu_item_variations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

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
-- AUTO_INCREMENT for table `seller_sso_tokens`
--
ALTER TABLE `seller_sso_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `suspend_users`
--
ALTER TABLE `suspend_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `website_pages`
--
ALTER TABLE `website_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `website_settings`
--
ALTER TABLE `website_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
-- Constraints for table `doctor_appointment_files`
--
ALTER TABLE `doctor_appointment_files`
  ADD CONSTRAINT `doctor_appointment_files_ibfk_1` FOREIGN KEY (`doctor_appointment_id`) REFERENCES `doctor_appointments` (`id`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `manual_payment_methods_user_id_fkey` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `suspend_users`
--
ALTER TABLE `suspend_users`
  ADD CONSTRAINT `fk_suspend_users_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `website_settings_user_id_fkey` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
