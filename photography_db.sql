-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2018 at 06:53 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `photography_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `id` int(11) NOT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `image` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail_size_id` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`id`, `name`, `description`, `image`, `thumbnail_size_id`, `priority`, `default`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Default Album', NULL, 'default-album-1522681961.jpg', 1, 1, 1, 0, '2018-04-02 15:12:42', 1, '2018-07-31 09:33:42', 1),
(2, 'Album 1', 'Here the description will go', 'album-1-1523080734.jpg', 3, 2, 0, 1, '2018-04-07 05:55:30', 1, '2018-05-04 01:55:51', 1),
(3, 'Album 2', 'Here the description will go', 'album-2-1523080742.jpg', 3, 3, 0, 1, '2018-04-07 05:55:55', 1, '2018-04-06 23:59:02', 1),
(4, 'Album 3', 'Here the description will go', 'album-3-1523080748.jpg', 3, 4, 0, 1, '2018-04-07 05:56:15', 1, '2018-04-06 23:59:08', 1),
(5, 'Album 4', 'Here the description will go', 'album-4-1523080919.jpg', 3, 5, 0, 1, '2018-04-07 06:01:59', 1, '2018-04-07 00:01:59', 1);

-- --------------------------------------------------------

--
-- Table structure for table `awards`
--

CREATE TABLE `awards` (
  `id` int(11) NOT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail_size_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `date` date DEFAULT NULL,
  `url` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `video_url` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `social_url` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `youtube` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `priority` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `biographies`
--

CREATE TABLE `biographies` (
  `id` int(11) NOT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail_size_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `date` date DEFAULT NULL,
  `url` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `video_url` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `social_url` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `youtube` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `priority` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `biographies`
--

INSERT INTO `biographies` (`id`, `name`, `image`, `thumbnail_size_id`, `size_id`, `description`, `date`, `url`, `video_url`, `social_url`, `youtube`, `priority`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Biography Title', 'biography-title-1525426734.jpg', 3, 5, '<p>Here the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.\r\n\r\n\r\nHere the description will go.</p>\r\n\r\n\r\n\r\n<p></p>', '2018-05-10', 'https://www.facebook.com', 'https://www.youtube.com/watch?v=psuRGfAaju4', 'https://www.facebook.com', 'psuRGfAaju4', 1, 1, '2018-05-04 08:52:24', 1, '2018-05-04 03:47:03', 1),
(2, 'Biography Title 2', 'biography-title-2-1525430000.jpg', 3, 5, '<p>dsfsdfsdfsdfsdfsdf<br></p>', NULL, NULL, NULL, NULL, NULL, 2, 1, '2018-05-04 10:33:21', 1, '2018-05-04 04:33:21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail_size_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `date` date DEFAULT NULL,
  `url` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `video_url` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `social_url` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `youtube` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `priority` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `image` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail_size_id` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `image`, `thumbnail_size_id`, `priority`, `default`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Default Category', NULL, 'default-category-1522681935.jpg', 1, 1, 0, 0, '2018-04-02 15:12:16', 1, '2018-04-20 01:53:03', 1),
(2, 'Category 1', NULL, 'category-1-1524208960.jpg', 3, 2, 0, 1, '2018-04-20 07:22:41', 1, '2018-05-04 01:55:35', 1),
(3, 'Category 2', NULL, 'category-2-1524208983.jpg', 3, 3, 0, 1, '2018-04-20 07:23:03', 1, '2018-04-20 01:23:03', 1),
(4, 'Category 3', NULL, 'category-3-1524209042.jpg', 3, 4, 0, 1, '2018-04-20 07:24:02', 1, '2018-04-20 01:24:02', 1);

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
(1, '2018_03_26_100230_entrust_setup_tables', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders_print_sales`
--

CREATE TABLE `orders_print_sales` (
  `id` int(11) NOT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `order_id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `print_sale_id` int(11) NOT NULL,
  `email` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders_print_sales`
--

INSERT INTO `orders_print_sales` (`id`, `name`, `order_id`, `print_sale_id`, `email`, `description`, `contact`, `status`, `created_at`, `updated_at`, `updated_by`) VALUES
(2, 'dsfdsf', '1524224836', 3, 'admin@domain.com', 'sdfsfsf', '01681692786', 1, '2018-04-20 11:47:16', '2018-04-20 11:47:16', NULL),
(3, 'sadsad', '1524224927', 1, 'sdbappi69@gmail.com', 'sadsadasd', '01681692786', 1, '2018-04-20 11:48:47', '2018-04-20 11:48:47', NULL),
(4, 'Test 2', '1524229453', 3, 'sdbappi69@gmail.com', 'fdsfdsf', '01681692786', 1, '2018-04-20 13:04:13', '2018-04-20 13:04:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders_sales`
--

CREATE TABLE `orders_sales` (
  `id` int(11) NOT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `order_id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `sale_id` int(11) NOT NULL,
  `email` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders_sales`
--

INSERT INTO `orders_sales` (`id`, `name`, `order_id`, `sale_id`, `email`, `description`, `contact`, `status`, `created_at`, `updated_at`, `updated_by`) VALUES
(1, 'sasadsad', '1524229468', 1, 'bappi@lolonader.com', 'sadsadsad', '01681692786', 1, '2018-04-20 13:04:28', '2018-04-20 13:04:28', NULL),
(2, 'Test', '1527693793', 1, 'sdbappi69@gmail.com', 'dsfdsfsdf', '01681692786', 1, '2018-05-30 15:23:13', '2018-05-30 15:23:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders_tearsheets`
--

CREATE TABLE `orders_tearsheets` (
  `id` int(11) NOT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `order_id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `tearsheet_id` int(11) NOT NULL,
  `email` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'user-create', 'User - Create', NULL, '2018-03-26 04:17:54', '2018-07-30 09:10:11'),
(2, 'user-view', 'User - View', NULL, '2018-07-30 08:01:43', '2018-07-30 09:10:17'),
(3, 'user-update', 'User - Update', NULL, '2018-07-30 09:10:02', '2018-07-30 09:10:02'),
(4, 'user-delete', 'User - Delete', NULL, '2018-07-30 09:10:35', '2018-07-30 09:10:35'),
(5, 'album-create', 'Album - Create', NULL, '2018-03-26 04:17:00', '2018-07-30 09:10:00'),
(6, 'album-view', 'Album - View', NULL, '2018-07-30 08:01:00', '2018-07-30 09:10:00'),
(7, 'album-update', 'Album - Update', NULL, '2018-07-30 09:10:00', '2018-07-30 09:10:00'),
(8, 'album-delete', 'Album - Delete', NULL, '2018-07-30 09:10:00', '2018-07-30 09:10:00'),
(9, 'award-create', 'Award - Create', NULL, '2018-03-26 04:17:00', '2018-07-30 09:10:00'),
(10, 'award-view', 'Award - View', NULL, '2018-07-30 08:01:00', '2018-07-30 09:10:00'),
(11, 'award-update', 'Award - Update', NULL, '2018-07-30 09:10:00', '2018-07-30 09:10:00'),
(12, 'award-delete', 'Award - Delete', NULL, '2018-07-30 09:10:00', '2018-07-30 09:10:00'),
(13, 'biography-create', 'Biography - Create', NULL, '2018-03-26 04:17:00', '2018-07-30 09:10:00'),
(14, 'biography-view', 'Biography - View', NULL, '2018-07-30 08:01:00', '2018-07-30 09:10:00'),
(15, 'biography-update', 'Biography - Update', NULL, '2018-07-30 09:10:00', '2018-07-30 09:10:00'),
(16, 'biography-delete', 'Biography - Delete', NULL, '2018-07-30 09:10:00', '2018-07-30 09:10:00'),
(17, 'book-create', 'Book - Create', NULL, '2018-03-26 04:17:00', '2018-07-30 09:10:00'),
(18, 'book-view', 'Book - View', NULL, '2018-07-30 08:01:00', '2018-07-30 09:10:00'),
(19, 'book-update', 'Book - Update', NULL, '2018-07-30 09:10:00', '2018-07-30 09:10:00'),
(20, 'book-delete', 'Book - Delete', NULL, '2018-07-30 09:10:00', '2018-07-30 09:10:00'),
(21, 'category-create', 'Category - Create', NULL, '2018-03-26 04:17:00', '2018-07-30 09:10:00'),
(22, 'category-view', 'Category - View', NULL, '2018-07-30 08:01:00', '2018-07-30 09:10:00'),
(23, 'category-update', 'Category - Update', NULL, '2018-07-30 09:10:00', '2018-07-30 09:10:00'),
(24, 'category-delete', 'Category - Delete', NULL, '2018-07-30 09:10:00', '2018-07-30 09:10:00'),
(25, 'permission-create', 'Permission - Create', NULL, '2018-03-26 04:17:00', '2018-07-30 09:10:00'),
(26, 'permission-view', 'Permission - View', NULL, '2018-07-30 08:01:00', '2018-07-30 09:10:00'),
(27, 'permission-update', 'Permission - Update', NULL, '2018-07-30 09:10:00', '2018-07-30 09:10:00'),
(28, 'permission-delete', 'Permission - Delete', NULL, '2018-07-30 09:10:00', '2018-07-30 09:10:00'),
(29, 'photo-create', 'Photo - Create', NULL, '2018-03-26 04:17:00', '2018-07-30 09:10:00'),
(30, 'photo-view', 'Photo - View', NULL, '2018-07-30 08:01:00', '2018-07-30 09:10:00'),
(31, 'photo-update', 'Photo - Update', NULL, '2018-07-30 09:10:00', '2018-07-30 09:10:00'),
(32, 'photo-delete', 'Photo - Delete', NULL, '2018-07-30 09:10:00', '2018-07-30 09:10:00'),
(33, 'printsell-create', 'PrintSell - Create', NULL, '2018-03-26 04:17:00', '2018-07-30 10:21:50'),
(34, 'printsell-view', 'PrintSell - View', NULL, '2018-07-30 08:01:00', '2018-07-30 10:21:56'),
(35, 'printsell-update', 'PrintSell - Update', NULL, '2018-07-30 09:10:00', '2018-07-30 10:21:54'),
(36, 'printsell-delete', 'PrintSell - Delete', NULL, '2018-07-30 09:10:00', '2018-07-30 10:21:52'),
(37, 'role-create', 'Role - Create', NULL, '2018-03-26 04:17:00', '2018-07-30 09:10:00'),
(38, 'role-view', 'Role - View', NULL, '2018-07-30 08:01:00', '2018-07-30 09:10:00'),
(39, 'role-update', 'Role - Update', NULL, '2018-07-30 09:10:00', '2018-07-30 09:10:00'),
(40, 'role-delete', 'Role - Delete', NULL, '2018-07-30 09:10:00', '2018-07-30 09:10:00'),
(41, 'sell-create', 'Sell - Create', NULL, '2018-03-26 04:17:00', '2018-07-30 10:18:30'),
(42, 'sell-view', 'Sell - View', NULL, '2018-07-30 08:01:00', '2018-07-30 10:19:55'),
(43, 'sell-update', 'Sell - Update', NULL, '2018-07-30 09:10:00', '2018-07-30 10:20:01'),
(44, 'sell-delete', 'Sell - Delete', NULL, '2018-07-30 09:10:00', '2018-07-30 10:20:17'),
(45, 'size-create', 'Size - Create', NULL, '2018-03-26 04:17:00', '2018-07-30 09:10:00'),
(46, 'size-view', 'Size - View', NULL, '2018-07-30 08:01:00', '2018-07-30 09:10:00'),
(47, 'size-update', 'Size - Update', NULL, '2018-07-30 09:10:00', '2018-07-30 09:10:00'),
(48, 'size-delete', 'Size - Delete', NULL, '2018-07-30 09:10:00', '2018-07-30 09:10:00'),
(49, 'slider-create', 'Slider - Create', NULL, '2018-03-26 04:17:00', '2018-07-30 09:10:00'),
(50, 'slider-view', 'Slider - View', NULL, '2018-07-30 08:01:00', '2018-07-30 09:10:00'),
(51, 'slider-update', 'Slider - Update', NULL, '2018-07-30 09:10:00', '2018-07-30 09:10:00'),
(52, 'slider-delete', 'Slider - Delete', NULL, '2018-07-30 09:10:00', '2018-07-30 09:10:00'),
(53, 'social-create', 'Social - Create', NULL, '2018-03-26 04:17:00', '2018-07-30 09:10:00'),
(54, 'social-view', 'Social - View', NULL, '2018-07-30 08:01:00', '2018-07-30 09:10:00'),
(55, 'social-update', 'Social - Update', NULL, '2018-07-30 09:10:00', '2018-07-30 09:10:00'),
(56, 'social-delete', 'Social - Delete', NULL, '2018-07-30 09:10:00', '2018-07-30 09:10:00'),
(57, 'tearsheet-create', 'Tearsheet - Create', NULL, '2018-03-26 04:17:00', '2018-07-30 09:10:00'),
(58, 'tearsheet-view', 'Tearsheet - View', NULL, '2018-07-30 08:01:00', '2018-07-30 09:10:00'),
(59, 'tearsheet-update', 'Tearsheet - Update', NULL, '2018-07-30 09:10:00', '2018-07-30 09:10:00'),
(60, 'tearsheet-delete', 'Tearsheet - Delete', NULL, '2018-07-30 09:10:00', '2018-07-30 09:10:00'),
(61, 'testimonial-create', 'Testimonial - Create', NULL, '2018-03-26 04:17:00', '2018-07-30 09:10:00'),
(62, 'testimonial-view', 'Testimonial - View', NULL, '2018-07-30 08:01:00', '2018-07-30 09:10:00'),
(63, 'testimonial-update', 'Testimonial - Update', NULL, '2018-07-30 09:10:00', '2018-07-30 09:10:00'),
(64, 'testimonial-delete', 'Testimonial - Delete', NULL, '2018-07-30 09:10:00', '2018-07-30 09:10:00'),
(65, 'theme-create', 'Theme - Create', NULL, '2018-03-26 04:17:00', '2018-07-30 09:10:00'),
(66, 'theme-view', 'Theme - View', NULL, '2018-07-30 08:01:00', '2018-07-30 09:10:00'),
(67, 'theme-update', 'Theme - Update', NULL, '2018-07-30 09:10:00', '2018-07-30 09:10:00'),
(68, 'theme-delete', 'Theme - Delete', NULL, '2018-07-30 09:10:00', '2018-07-30 09:10:00'),
(69, 'video-create', 'Video - Create', NULL, '2018-03-26 04:17:00', '2018-07-30 09:10:00'),
(70, 'video-view', 'Video - View', NULL, '2018-07-30 08:01:00', '2018-07-30 09:10:00'),
(71, 'video-update', 'Video - Update', NULL, '2018-07-30 09:10:00', '2018-07-30 09:10:00'),
(72, 'video-delete', 'Video - Delete', NULL, '2018-07-30 09:10:00', '2018-07-30 09:10:00'),
(73, 'orderprintsell-view', 'Order PrintSell - View', NULL, '2018-07-30 10:16:57', '2018-07-30 10:23:04'),
(74, 'orderprintsell-delete', 'Order PrintSell - Delete', NULL, '2018-07-30 10:17:08', '2018-07-30 10:23:02'),
(75, 'ordersell-view', 'Order Sell - View', NULL, '2018-07-30 10:17:29', '2018-07-30 10:23:59'),
(76, 'ordersell-delete', 'Order Sell - Delete', NULL, '2018-07-30 10:17:41', '2018-07-30 10:23:52'),
(77, 'setting', 'Site Setting', NULL, '2018-07-30 10:44:02', '2018-07-30 10:45:36'),
(78, 'ordertearsheet-view', 'Order Tearsheet - View', NULL, '2018-07-30 10:55:16', '2018-07-30 10:55:16'),
(79, 'ordertearsheet-delete', 'Order Tearsheet - Delete', NULL, '2018-07-30 10:55:30', '2018-07-30 10:55:30');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 5),
(1, 6),
(2, 5),
(2, 6),
(3, 5),
(3, 6),
(4, 5),
(4, 6),
(5, 5),
(5, 6),
(6, 5),
(6, 6),
(7, 5),
(7, 6),
(8, 5),
(8, 6),
(9, 5),
(9, 6),
(10, 5),
(10, 6),
(11, 5),
(11, 6),
(12, 5),
(12, 6),
(13, 5),
(13, 6),
(14, 5),
(14, 6),
(15, 5),
(15, 6),
(16, 5),
(16, 6),
(17, 5),
(17, 6),
(18, 5),
(18, 6),
(19, 5),
(19, 6),
(20, 5),
(20, 6),
(21, 5),
(21, 6),
(22, 5),
(22, 6),
(23, 5),
(23, 6),
(24, 5),
(24, 6),
(25, 5),
(25, 6),
(26, 5),
(26, 6),
(27, 5),
(27, 6),
(28, 5),
(28, 6),
(29, 5),
(29, 6),
(30, 5),
(30, 6),
(31, 5),
(31, 6),
(32, 5),
(32, 6),
(33, 5),
(33, 6),
(34, 5),
(34, 6),
(35, 5),
(35, 6),
(36, 5),
(36, 6),
(37, 5),
(37, 6),
(38, 5),
(38, 6),
(39, 5),
(39, 6),
(40, 5),
(40, 6),
(41, 5),
(42, 5),
(43, 5),
(44, 5),
(45, 5),
(46, 5),
(47, 5),
(48, 5),
(49, 5),
(50, 5),
(51, 5),
(52, 5),
(53, 5),
(54, 5),
(55, 5),
(56, 5),
(57, 5),
(58, 5),
(59, 5),
(60, 5),
(61, 5),
(62, 5),
(63, 5),
(64, 5),
(65, 5),
(66, 5),
(67, 5),
(68, 5),
(69, 5),
(70, 5),
(71, 5),
(72, 5),
(73, 5),
(73, 6),
(74, 5),
(74, 6),
(75, 5),
(75, 6),
(76, 5),
(76, 6),
(77, 5),
(78, 5),
(78, 6),
(79, 5),
(79, 6);

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail_size_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `price` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `priority` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`id`, `name`, `product_id`, `image`, `thumbnail_size_id`, `size_id`, `description`, `price`, `priority`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Photo 1', 'P-1', 'photo-1-1524068981.jpg', 9, 6, 'Here the description will go', NULL, 1, 1, '2018-04-18 16:23:03', 1, '2018-06-09 09:19:10', 1),
(4, 'Photo 4', 'P-4', 'photo-4-1524069868.jpg', 9, 6, 'Here the Description will go', '8000 BDT', 3, 1, '2018-04-18 16:44:28', 1, '2018-06-09 09:19:10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `photo_album`
--

CREATE TABLE `photo_album` (
  `id` int(11) NOT NULL,
  `photo_id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `photo_album`
--

INSERT INTO `photo_album` (`id`, `photo_id`, `album_id`, `priority`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, 2, 1, '2018-04-18 16:23:03', 1, '2018-04-18 16:23:03', 1),
(2, 1, 3, 2, '2018-04-18 16:23:03', 1, '2018-04-18 16:23:03', 1),
(3, 1, 4, 3, '2018-04-18 16:23:03', 1, '2018-04-18 16:23:03', 1),
(4, 1, 5, 4, '2018-04-18 16:23:03', 1, '2018-04-18 16:23:03', 1),
(11, 4, 2, 9, '2018-04-18 16:44:28', 1, '2018-04-18 16:56:52', 1),
(12, 4, 3, 12, '2018-04-18 16:44:28', 1, '2018-04-18 16:44:28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `photo_category`
--

CREATE TABLE `photo_category` (
  `id` int(11) NOT NULL,
  `photo_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `photo_category`
--

INSERT INTO `photo_category` (`id`, `photo_id`, `category_id`, `priority`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(4, 4, 1, 4, '2018-04-18 16:44:29', 1, '2018-04-18 16:44:29', 1),
(5, 1, 2, 5, '2018-04-20 07:24:28', 1, '2018-04-20 07:24:28', 1),
(7, 4, 2, 7, '2018-04-20 07:24:28', 1, '2018-04-20 07:24:28', 1),
(9, 4, 3, 9, '2018-04-20 07:24:50', 1, '2018-04-20 07:24:50', 1),
(11, 1, 4, 11, '2018-04-20 07:25:06', 1, '2018-04-20 07:25:06', 1),
(12, 4, 4, 12, '2018-04-20 07:25:06', 1, '2018-04-20 07:25:06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `print_sales`
--

CREATE TABLE `print_sales` (
  `id` int(11) NOT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `image` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail_size_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `price` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `priority` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `print_sales`
--

INSERT INTO `print_sales` (`id`, `name`, `product_id`, `category_id`, `image`, `thumbnail_size_id`, `size_id`, `description`, `price`, `priority`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Print Photo 1', 'PP-1', 3, 'print-photo-1-1524213507.jpg', 9, 6, 'Here the description will go', '5000 BDT', 1, 1, '2018-04-20 08:35:16', 1, '2018-04-20 02:38:27', 1),
(3, 'Print Photo 3', 'PP-3', 2, 'print-photo-3-1524214291.jpg', 7, 8, 'Here the description will go', '8000 BDT', 2, 1, '2018-04-20 08:44:56', 1, '2018-04-20 02:51:32', 1),
(4, 'Print Photo 4', 'PP-4', 3, 'print-photo-4-1524214310.jpg', 7, 8, 'Here the description will go', '8000 BDT', 4, 1, '2018-04-20 08:44:56', 1, '2018-04-20 02:51:50', 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `priority`, `created_at`, `updated_at`) VALUES
(5, 'superadministrator', 'Super Administrator', NULL, 1, '2018-03-26 04:22:36', '2018-07-31 10:48:28'),
(6, 'administrator', 'Administrator', NULL, 2, '2018-07-31 10:31:47', '2018-07-31 10:48:28');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(1, 5),
(2, 6);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `image` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail_size_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `price` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `priority` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `name`, `product_id`, `category_id`, `image`, `thumbnail_size_id`, `size_id`, `description`, `price`, `priority`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Sall Photo 1', 'P-1', 2, 'sall-photo-1-1524228621.jpg', 9, 6, 'Here the description will go', '5000 BDT', 1, 1, '2018-04-20 12:50:21', 1, '2018-04-20 06:50:50', 1),
(2, 'Sall Photo 1', 'P-1', 3, 'sall-photo-1-1524228621.jpg', 9, 6, 'Here the description will go', '5000 BDT', 3, 1, '2018-04-20 12:50:21', 1, '2018-04-20 06:51:39', 1),
(3, 'Sale Photo 3', 'P-2', 2, 'sale-photo-3-1524228691.jpg', 7, 8, NULL, NULL, 2, 1, '2018-04-20 12:51:32', 1, '2018-04-20 06:51:39', 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `sub_title` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `size_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `sub_title`, `email`, `phone`, `description`, `image`, `size_id`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Photography', 'Here the sub-title will go', 'sdbappi69@gmail.com', '+8801681692786', '<p><b>Here the description will go</b></p><p><b><br></b></p><p>Hello</p><p><br></p><p><i>Hi</i><i></i><br></p><br><br><br>', 'photography-1523022011.png', 2, '2018-04-03 16:53:42', 1, '2018-05-26 00:46:41', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` int(11) NOT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `height` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `name`, `height`, `width`, `default`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Default Size (200 X 200)', 200, 200, 0, 1, '2018-04-02 15:05:21', 1, '2018-04-06 23:50:46', 1),
(2, 'Airy - Logo (360 X 72)', 72, 360, 0, 1, '2018-04-06 13:38:54', 1, '2018-04-06 23:46:15', 1),
(3, 'Airy - Thumbnail (560 X 384)', 384, 560, 0, 1, '2018-04-07 05:50:46', 1, '2018-05-04 01:55:21', 1),
(4, '32px Icon (32 X 32)', 32, 32, 0, 1, '2018-04-07 08:02:38', 1, '2018-04-07 02:02:57', 1),
(5, 'Airy - Full Screen (1920 X 1080)', 1080, 1920, 0, 1, '2018-04-07 08:23:42', 1, '2018-04-07 03:16:16', 1),
(6, 'Portrait Photo (720 X 1080)', 1080, 720, 0, 1, '2018-04-18 16:10:10', 1, '2018-04-18 10:27:15', 1),
(7, 'Landscape Photo Thumbnail (640 X 360)', 360, 640, 0, 1, '2018-04-18 16:14:18', 1, '2018-04-18 10:20:15', 1),
(8, 'Landscape Photo (1920 X 1080)', 1080, 1920, 0, 1, '2018-04-18 16:19:12', 1, '2018-04-18 10:19:12', 1),
(9, 'Portrait Photo Thumbnail (360 X 640)', 640, 360, 0, 1, '2018-04-18 16:20:54', 1, '2018-04-18 10:20:54', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` int(11) NOT NULL,
  `name` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `size_id` int(11) NOT NULL,
  `url` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `priority` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `name`, `description`, `image`, `size_id`, `url`, `priority`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Slider 1', 'Here the description will go for slider 1', 'slider-1-1523092583.jpg', 5, NULL, 1, 1, '2018-04-07 08:59:24', 1, '2018-04-07 03:16:24', 1),
(2, 'Slider 2', 'Here the description will go for slider 2', 'slider-2-1523092092.jpg', 5, NULL, 2, 1, '2018-04-07 08:59:49', 1, '2018-04-07 03:08:12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `socials`
--

CREATE TABLE `socials` (
  `id` int(11) NOT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `size_id` int(11) DEFAULT NULL,
  `font_awesome` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `priority` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `socials`
--

INSERT INTO `socials` (`id`, `name`, `image`, `size_id`, `font_awesome`, `url`, `priority`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Facebook', 'facebook-1523088442.png', 4, 'fa-facebook', 'https://www.facebook.com', 1, 1, '2018-04-07 08:07:22', 1, '2018-04-07 03:01:04', 1),
(2, 'Instagram', 'instagram-1523088485.png', 4, 'fa-instagram', 'https://www.instagram.com', 2, 1, '2018-04-07 08:08:05', 1, '2018-04-07 03:01:04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tearsheets`
--

CREATE TABLE `tearsheets` (
  `id` int(11) NOT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `image` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail_size_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `price` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `priority` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tearsheets`
--

INSERT INTO `tearsheets` (`id`, `name`, `product_id`, `category_id`, `image`, `thumbnail_size_id`, `size_id`, `description`, `price`, `priority`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(3, 'Test Photo', 'P-1', 2, 'test-photo-1527693998.jpg', 9, 6, NULL, NULL, 1, 1, '2018-05-30 15:26:39', 1, '2018-05-30 09:26:39', 1);

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail_size_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `date` date DEFAULT NULL,
  `url` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `video_url` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `social_url` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `youtube` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `priority` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE `themes` (
  `id` int(11) NOT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `folder` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`id`, `name`, `image`, `description`, `folder`, `default`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Airy', 'airy-1523015251.png', NULL, 'airy', 1, 1, '2018-04-06 11:47:31', 1, '2018-07-30 07:31:18', 1),
(2, 'Simple', 'simple-1527682223.png', NULL, 'simple', 0, 1, '2018-05-30 12:10:23', 1, '2018-07-23 09:47:04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `image`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'sdbappi69@gmail.com', '$2y$10$Ti9fZqHdxmQ5W2lRQenClusQ1yEs9xtNvq.DHsn.cwriwVbmNUY8a', 'default_avatar.png', 'Bac4CTHlLpW7P1TYWVymffV7TdCCQP7pahstEkKXiAXW9RhyFzwXSbNl1PnZ', '2018-03-25 18:00:00', '2018-05-06 10:53:59'),
(2, 'Administrator', 'bappi_ifci@yahoo.com', '$2y$10$.gcjC0s4Wsfd7JR8gHxo1OGG.nh2RBmmH80Uc/XVhnJXAjaPBo6gO', 'default_avatar.png', NULL, '2018-07-31 10:32:22', '2018-07-31 10:32:22');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail_size_id` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `date` date DEFAULT NULL,
  `url` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `video_url` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `social_url` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `youtube` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `priority` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `priority` (`priority`),
  ADD KEY `albums_fk0` (`thumbnail_size_id`);

--
-- Indexes for table `awards`
--
ALTER TABLE `awards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `awards_fk0` (`thumbnail_size_id`),
  ADD KEY `awards_fk1` (`size_id`);

--
-- Indexes for table `biographies`
--
ALTER TABLE `biographies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `biographies_fk0` (`thumbnail_size_id`),
  ADD KEY `biographies_fk1` (`size_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `books_fk0` (`thumbnail_size_id`),
  ADD KEY `books_fk1` (`size_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `priority` (`priority`),
  ADD KEY `categories_fk0` (`thumbnail_size_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders_print_sales`
--
ALTER TABLE `orders_print_sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_id` (`order_id`),
  ADD KEY `orders_print_sales_fk0` (`print_sale_id`);

--
-- Indexes for table `orders_sales`
--
ALTER TABLE `orders_sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_id` (`order_id`),
  ADD KEY `orders_sales_fk0` (`sale_id`);

--
-- Indexes for table `orders_tearsheets`
--
ALTER TABLE `orders_tearsheets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_id` (`order_id`),
  ADD KEY `orders_tearsheets_fk0` (`tearsheet_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `photos_fk0` (`thumbnail_size_id`),
  ADD KEY `photos_fk1` (`size_id`);

--
-- Indexes for table `photo_album`
--
ALTER TABLE `photo_album`
  ADD PRIMARY KEY (`id`),
  ADD KEY `photo_album_fk0` (`photo_id`),
  ADD KEY `photo_album_fk1` (`album_id`);

--
-- Indexes for table `photo_category`
--
ALTER TABLE `photo_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `photo_category_fk0` (`photo_id`),
  ADD KEY `photo_category_fk1` (`category_id`);

--
-- Indexes for table `print_sales`
--
ALTER TABLE `print_sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `priority` (`priority`),
  ADD KEY `print_sales_fk0` (`category_id`),
  ADD KEY `print_sales_fk1` (`thumbnail_size_id`),
  ADD KEY `print_sales_fk2` (`size_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`),
  ADD UNIQUE KEY `priority` (`priority`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `priority` (`priority`),
  ADD KEY `sales_fk0` (`category_id`),
  ADD KEY `sales_fk1` (`thumbnail_size_id`),
  ADD KEY `sales_fk2` (`size_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `setting_fk0` (`size_id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `priority` (`priority`),
  ADD KEY `sliders_fk0` (`size_id`);

--
-- Indexes for table `socials`
--
ALTER TABLE `socials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `social_fk0` (`size_id`);

--
-- Indexes for table `tearsheets`
--
ALTER TABLE `tearsheets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `priority` (`priority`),
  ADD KEY `tearsheets_fk0` (`category_id`),
  ADD KEY `tearsheets_fk1` (`thumbnail_size_id`),
  ADD KEY `tearsheets_fk2` (`size_id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `testimonials_fk0` (`thumbnail_size_id`),
  ADD KEY `testimonials_fk1` (`size_id`);

--
-- Indexes for table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `videos_fk0` (`thumbnail_size_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `awards`
--
ALTER TABLE `awards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `biographies`
--
ALTER TABLE `biographies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders_print_sales`
--
ALTER TABLE `orders_print_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders_sales`
--
ALTER TABLE `orders_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders_tearsheets`
--
ALTER TABLE `orders_tearsheets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `photo_album`
--
ALTER TABLE `photo_album`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `photo_category`
--
ALTER TABLE `photo_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `print_sales`
--
ALTER TABLE `print_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `socials`
--
ALTER TABLE `socials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tearsheets`
--
ALTER TABLE `tearsheets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE `themes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `albums`
--
ALTER TABLE `albums`
  ADD CONSTRAINT `albums_fk0` FOREIGN KEY (`thumbnail_size_id`) REFERENCES `sizes` (`id`);

--
-- Constraints for table `awards`
--
ALTER TABLE `awards`
  ADD CONSTRAINT `awards_fk0` FOREIGN KEY (`thumbnail_size_id`) REFERENCES `sizes` (`id`),
  ADD CONSTRAINT `awards_fk1` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`);

--
-- Constraints for table `biographies`
--
ALTER TABLE `biographies`
  ADD CONSTRAINT `biographies_fk0` FOREIGN KEY (`thumbnail_size_id`) REFERENCES `sizes` (`id`),
  ADD CONSTRAINT `biographies_fk1` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`);

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_fk0` FOREIGN KEY (`thumbnail_size_id`) REFERENCES `sizes` (`id`),
  ADD CONSTRAINT `books_fk1` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`);

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_fk0` FOREIGN KEY (`thumbnail_size_id`) REFERENCES `sizes` (`id`);

--
-- Constraints for table `orders_print_sales`
--
ALTER TABLE `orders_print_sales`
  ADD CONSTRAINT `orders_print_sales_fk0` FOREIGN KEY (`print_sale_id`) REFERENCES `print_sales` (`id`);

--
-- Constraints for table `orders_sales`
--
ALTER TABLE `orders_sales`
  ADD CONSTRAINT `orders_sales_fk0` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`);

--
-- Constraints for table `orders_tearsheets`
--
ALTER TABLE `orders_tearsheets`
  ADD CONSTRAINT `orders_tearsheets_fk0` FOREIGN KEY (`tearsheet_id`) REFERENCES `tearsheets` (`id`);

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `photos_fk0` FOREIGN KEY (`thumbnail_size_id`) REFERENCES `sizes` (`id`),
  ADD CONSTRAINT `photos_fk1` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`);

--
-- Constraints for table `photo_album`
--
ALTER TABLE `photo_album`
  ADD CONSTRAINT `photo_album_fk0` FOREIGN KEY (`photo_id`) REFERENCES `photos` (`id`),
  ADD CONSTRAINT `photo_album_fk1` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`);

--
-- Constraints for table `photo_category`
--
ALTER TABLE `photo_category`
  ADD CONSTRAINT `photo_category_fk0` FOREIGN KEY (`photo_id`) REFERENCES `photos` (`id`),
  ADD CONSTRAINT `photo_category_fk1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `print_sales`
--
ALTER TABLE `print_sales`
  ADD CONSTRAINT `print_sales_fk0` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `print_sales_fk1` FOREIGN KEY (`thumbnail_size_id`) REFERENCES `sizes` (`id`),
  ADD CONSTRAINT `print_sales_fk2` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`);

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_fk0` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `sales_fk1` FOREIGN KEY (`thumbnail_size_id`) REFERENCES `sizes` (`id`),
  ADD CONSTRAINT `sales_fk2` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`);

--
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `setting_fk0` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`);

--
-- Constraints for table `sliders`
--
ALTER TABLE `sliders`
  ADD CONSTRAINT `sliders_fk0` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`);

--
-- Constraints for table `socials`
--
ALTER TABLE `socials`
  ADD CONSTRAINT `social_fk0` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`);

--
-- Constraints for table `tearsheets`
--
ALTER TABLE `tearsheets`
  ADD CONSTRAINT `tearsheets_fk0` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `tearsheets_fk1` FOREIGN KEY (`thumbnail_size_id`) REFERENCES `sizes` (`id`),
  ADD CONSTRAINT `tearsheets_fk2` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`);

--
-- Constraints for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD CONSTRAINT `testimonials_fk0` FOREIGN KEY (`thumbnail_size_id`) REFERENCES `sizes` (`id`),
  ADD CONSTRAINT `testimonials_fk1` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`);

--
-- Constraints for table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_fk0` FOREIGN KEY (`thumbnail_size_id`) REFERENCES `sizes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
