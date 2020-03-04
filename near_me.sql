-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 04, 2020 at 06:38 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `near_me`
--

-- --------------------------------------------------------

--
-- Table structure for table `histories`
--

CREATE TABLE `histories` (
  `id` int(11) NOT NULL,
  `radius` float DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `keyword` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(11,7) DEFAULT NULL,
  `longitude` decimal(11,7) DEFAULT NULL,
  `response` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
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
(4, '2019_09_09_160111_entrust_setup_tables', 2);

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'user-delete', 'user-delete', NULL, NULL, NULL),
(2, 'user-update', 'user-update', NULL, NULL, NULL),
(3, 'user-view', 'user-view', NULL, NULL, NULL),
(4, 'user-create', 'user-create', NULL, NULL, NULL),
(5, 'role-update', 'role-update', NULL, NULL, NULL),
(6, 'role-delete', 'role-delete', NULL, NULL, NULL),
(7, 'role-view', 'role-view', NULL, NULL, NULL),
(8, 'role-create', 'role-create', NULL, NULL, NULL),
(9, 'permission-delete', 'permission-delete', NULL, NULL, NULL),
(10, 'permission-update', 'permission-update', NULL, NULL, NULL),
(11, 'permission-view', 'permission-view', NULL, NULL, NULL),
(12, 'permission-create', 'permission-create', NULL, NULL, NULL);

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
(1, 1),
(2, 1),
(2, 3),
(3, 1),
(3, 3),
(4, 1),
(4, 3),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `priority`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'Super Admin', NULL, 1, NULL, '2019-12-22 03:11:35'),
(3, 'systemadmin', 'System Admin', NULL, 2, '2019-09-16 23:55:11', '2019-12-22 03:11:35');

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
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` int(11) NOT NULL,
  `title` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id`, `title`, `status`) VALUES
(1, 'Accounting', 1),
(2, 'Airport', 1),
(3, 'Amusement Park', 1),
(4, 'Aquarium', 1),
(5, 'Art Gallery', 1),
(6, 'Atm', 1),
(7, 'Bakery', 1),
(8, 'Bank', 1),
(9, 'Bar', 1),
(10, 'Beauty Salon', 1),
(11, 'Bicycle Store', 1),
(12, 'Book Store', 1),
(13, 'Bowling Alley', 1),
(14, 'Bus Station', 1),
(15, 'Cafe', 1),
(16, 'Campground', 1),
(17, 'Car Dealer', 1),
(18, 'Car Rental', 1),
(19, 'Car Repair', 1),
(20, 'Car Wash', 1),
(21, 'Casino', 1),
(22, 'Cemetery', 1),
(23, 'Church', 1),
(24, 'City Hall', 1),
(25, 'Clothing Store', 1),
(26, 'Convenience Store', 1),
(27, 'Courthouse', 1),
(28, 'Dentist', 1),
(29, 'Department Store', 1),
(30, 'Doctor', 1),
(31, 'Drugstore', 1),
(32, 'Electrician', 1),
(33, 'Electronics Store', 1),
(34, 'Embassy', 1),
(35, 'Fire Station', 1),
(36, 'Florist', 1),
(37, 'Funeral Home', 1),
(38, 'Furniture Store', 1),
(39, 'Gas Station', 1),
(40, 'Grocery Or Supermarket', 1),
(41, 'Gym', 1),
(42, 'Hair Care', 1),
(43, 'Hardware Store', 1),
(44, 'Hindu Temple', 1),
(45, 'Home Goods Store', 1),
(46, 'Hospital', 1),
(47, 'Insurance Agency', 1),
(48, 'Jewelry Store', 1),
(49, 'Laundry', 1),
(50, 'Lawyer', 1),
(51, 'Library', 1),
(52, 'Light Rail Station', 1),
(53, 'Liquor Store', 1),
(54, 'Local Government Office', 1),
(55, 'Locksmith', 1),
(56, 'Lodging', 1),
(57, 'Meal Delivery', 1),
(58, 'Meal Takeaway', 1),
(59, 'Mosque', 1),
(60, 'Movie Rental', 1),
(61, 'Movie Theater', 1),
(62, 'Moving Company', 1),
(63, 'Museum', 1),
(64, 'Night Club', 1),
(65, 'Painter', 1),
(66, 'Park', 1),
(67, 'Parking', 1),
(68, 'Pet Store', 1),
(69, 'Pharmacy', 1),
(70, 'Physiotherapist', 1),
(71, 'Plumber', 1),
(72, 'Police', 1),
(73, 'Post Office', 1),
(74, 'Primary School', 1),
(75, 'Real Estate Agency', 1),
(76, 'Restaurant', 1),
(77, 'Roofing Contractor', 1),
(78, 'Rv Park', 1),
(79, 'School', 1),
(80, 'Secondary School', 1),
(81, 'Shoe Store', 1),
(82, 'Shopping Mall', 1),
(83, 'Spa', 1),
(84, 'Stadium', 1),
(85, 'Storage', 1),
(86, 'Store', 1),
(87, 'Subway Station', 1),
(88, 'Supermarket', 1),
(89, 'Synagogue', 1),
(90, 'Taxi Stand', 1),
(91, 'Tourist Attraction', 1),
(92, 'Train Station', 1),
(93, 'Transit Station', 1),
(94, 'Travel Agency', 1),
(95, 'University', 1),
(96, 'Veterinary Care', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(63) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default_avatar.png',
  `client_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `address` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(11,7) DEFAULT NULL,
  `longitude` decimal(11,7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `image`, `client_id`, `status`, `created_at`, `updated_at`, `address`, `latitude`, `longitude`) VALUES
(1, 'Super Admin', 'sdbappi69@gmail.com', NULL, '$2y$10$zVF6XoJpDiARqvw93v6LHOxjb7o1KaP1CIWp2XfL.AotmbyuO6o2S', '516DkFRvSRVMyX3zE03xmEFixPpDeySkiCgWOz5i2JK8WS8B6h6T7nBmtvjG', 'default_avatar.png', NULL, 1, '2019-09-09 03:41:46', '2020-03-04 10:47:03', 'Dhaka University, Dhaka, Bangladesh', '23.7341698', '90.3927502');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `histories`
--
ALTER TABLE `histories`
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
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
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
-- AUTO_INCREMENT for table `histories`
--
ALTER TABLE `histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
