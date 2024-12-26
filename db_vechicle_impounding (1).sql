-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2024 at 05:13 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_vechicle_impounding`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('6c5a6291270da9accc4b4ec5817d4b83', 'i:1;', 1734313539),
('6c5a6291270da9accc4b4ec5817d4b83:timer', 'i:1734313539;', 1734313539),
('a524511b3e6aad7e42985ce38d616279', 'i:2;', 1734322216),
('a524511b3e6aad7e42985ce38d616279:timer', 'i:1734322216;', 1734322216);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_09_14_064113_add_two_factor_columns_to_users_table', 1),
(5, '2024_09_14_064145_create_personal_access_tokens_table', 1),
(6, '2024_10_09_004841_create_t_entries_violations_table', 1),
(7, '2024_10_09_035338_create_t_traffic_citations_table', 2),
(9, '2024_10_11_065307_create_t_vehicle_impoundings_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('sp3YeHYghPocWt5yhEXKJoIdkXpifQIDeFd9ok0H', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiS2dDR2hwb0o4VXVYdGxqT2lMcE82TFBLS0xiQzRsdnNpTkJMbFFHVCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pbXBvdW5kaW5ncyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7czoyMToicGFzc3dvcmRfaGFzaF9zYW5jdHVtIjtzOjYwOiIkMnkkMTIkYXdxN0FWYVBzU0l1bS5sWmNYalljTzFxYVFtVlRVOGNKUkJaVkIyYUx6QUhVeG50SEtmaTIiO30=', 1734322357);

-- --------------------------------------------------------

--
-- Table structure for table `t_entries_violations`
--

CREATE TABLE `t_entries_violations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `violation` varchar(255) NOT NULL,
  `penalty` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_entries_violations`
--

INSERT INTO `t_entries_violations` (`id`, `violation`, `penalty`, `created_at`, `updated_at`) VALUES
(2, 'Driving Without Driver’s License', '3000.00', '2024-10-08 17:14:50', '2024-10-08 17:14:50'),
(3, 'Illegal Parking', '1000.00', '2024-10-08 17:14:50', '2024-10-08 17:14:50'),
(4, 'Disregarding Traffic Signs', '2000.00', '2024-10-08 17:14:50', '2024-10-08 17:14:50'),
(5, 'Driving Under the Influence', '10000.00', '2024-10-08 17:14:50', '2024-10-08 17:14:50'),
(6, 'Minor Driving Motorcycle', '3000.00', '2024-10-08 17:14:50', '2024-10-08 17:14:50'),
(7, 'Overloading', '1000.00', '2024-10-08 17:14:50', '2024-10-08 17:14:50'),
(8, 'No O.R./C.R', '1000.00', '2024-10-08 17:14:50', '2024-10-08 17:53:51'),
(9, 'No Plate Number', '5000.00', '2024-10-08 17:14:50', '2024-10-08 17:14:50'),
(10, 'Dirty Plate Number', '5000.00', '2024-10-08 17:14:50', '2024-10-08 17:14:50'),
(11, 'Not Firmly Attached Plate Number', '5000.00', '2024-10-08 17:14:50', '2024-10-08 17:14:50'),
(12, 'No Muffler', '5000.00', '2024-10-08 17:14:50', '2024-10-08 17:14:50'),
(13, 'Improvised Muffler', '5000.00', '2024-10-08 17:14:50', '2024-10-08 17:14:50'),
(14, 'No Signal Lights', '5000.00', '2024-10-08 17:14:50', '2024-10-08 17:14:50'),
(15, 'No Tail Lights', '5000.00', '2024-10-08 17:14:50', '2024-10-08 17:14:50'),
(16, 'No Brake Lights', '5000.00', '2024-10-08 17:14:50', '2024-10-08 17:14:50'),
(17, 'No Head Lights', '5000.00', '2024-10-08 17:14:50', '2024-10-08 17:14:50'),
(18, 'Defective Brakes', '5000.00', '2024-10-08 17:14:50', '2024-10-08 17:14:50'),
(19, 'No Side Mirror', '5000.00', '2024-10-08 17:14:50', '2024-10-08 17:14:50'),
(20, 'No Horn', '5000.00', '2024-10-08 17:14:50', '2024-10-08 17:14:50'),
(22, 'Others', '0.00', '2024-12-15 18:40:38', '2024-12-15 18:40:38');

-- --------------------------------------------------------

--
-- Table structure for table `t_traffic_citations`
--

CREATE TABLE `t_traffic_citations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `plate_number` varchar(255) NOT NULL,
  `violator_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `municipal_ordinance_number` varchar(255) NOT NULL,
  `specific_offense` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_traffic_citations`
--

INSERT INTO `t_traffic_citations` (`id`, `plate_number`, `violator_name`, `address`, `date`, `municipal_ordinance_number`, `specific_offense`, `remarks`, `status`, `created_at`, `updated_at`) VALUES
(1, 'asdasdasda', 'Kent Russell Casiño', 'eee', '2024-10-14', 'eeee1213', '[\"3\",\"7\"]', NULL, NULL, '2024-10-13 12:11:26', '2024-12-15 18:08:10'),
(3, 'e', 'Kent Russell Casiño', 'e', '2024-12-12', '1095676', '[\"3\",\"4\"]', NULL, 'Paid', '2024-12-12 06:29:48', '2024-12-12 07:15:25'),
(4, 'adasd', 'Judy', 'qwewq', '2024-12-12', '123213', '[\"3\"]', NULL, NULL, '2024-12-12 07:04:27', '2024-12-12 07:04:27'),
(5, '123', '123', '123', '2024-12-11', '123', '[\"3\"]', NULL, 'Paid', '2024-12-12 07:07:20', '2024-12-12 07:18:12'),
(6, 'a', 'Kent Russell Casiño', 'asda', '2024-12-12', '123213', '[\"2\",\"3\"]', NULL, NULL, '2024-12-12 08:05:27', '2024-12-12 08:05:27'),
(7, 'KTV1532', 'Kent Russell Casiño', 'Tagoloan, Misamis Oriental', '2024-12-15', '-', '[\"3\",\"4\"]', NULL, NULL, '2024-12-15 17:43:55', '2024-12-15 17:47:52');

-- --------------------------------------------------------

--
-- Table structure for table `t_vehicle_impoundings`
--

CREATE TABLE `t_vehicle_impoundings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_number` varchar(255) NOT NULL,
  `owner_name` varchar(255) NOT NULL,
  `vehicle_type` varchar(255) NOT NULL,
  `violation_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`violation_id`)),
  `date_of_impounding` date NOT NULL,
  `reason_for_impounding` varchar(255) DEFAULT NULL,
  `fine_amount` decimal(10,2) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `incident_location` longtext NOT NULL,
  `document_attachment` longtext NOT NULL,
  `photo_attachment` longtext NOT NULL,
  `license_no` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `birthdate` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `reason_of_impoundment` varchar(255) DEFAULT NULL,
  `reason_of_impoundment_reason` varchar(255) DEFAULT NULL,
  `incident_address` varchar(255) DEFAULT NULL,
  `condition_x` varchar(255) DEFAULT NULL,
  `officer_name` varchar(255) DEFAULT NULL,
  `officer_rank` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_vehicle_impoundings`
--

INSERT INTO `t_vehicle_impoundings` (`id`, `vehicle_number`, `owner_name`, `vehicle_type`, `violation_id`, `date_of_impounding`, `reason_for_impounding`, `fine_amount`, `release_date`, `incident_location`, `document_attachment`, `photo_attachment`, `license_no`, `address`, `birthdate`, `phone`, `reason_of_impoundment`, `reason_of_impoundment_reason`, `incident_address`, `condition_x`, `officer_name`, `officer_rank`, `created_at`, `updated_at`) VALUES
(7, 'KTV4891', 'Kent Russell N. Casino', '2011 Kia Sportage 4x4 EX', '[\"2\",\"4\",\"6\",\"7\",\"9\"]', '2024-10-24', '[\"ACCIDENT\",\"OTHER\"]', '2400.00', '2024-10-28', 'Tagoloan Plaza, Mimisa Oriental', '[]', '[\"photos\\/q6ZmQkrAyQJjQoL3CnEoO70q5EuLvh2IPAVqxScg.png\",\"photos\\/cxNxkNzXEB1fk2DtUXxQaNzvPiZEdHXjTXLwPfht.png\",\"photos\\/bm1qB91HfCQaY08DAhf9ylpVyirolZ9IQ4mSLxNQ.png\",\"photos\\/jfpxjkN0DQgMEnUHf6AhJQwap03aAkyDKhuIUxFe.png\"]', '', '', '', '', '', 'xhjjlkgdfdg', '', '', NULL, NULL, '2024-10-23 22:36:47', '2024-12-15 19:22:06'),
(8, 'qwe', 'qwewqe', 'qwe', '[\"2\"]', '2024-09-10', 'qwewewe', '0.00', NULL, 'asdsadsa', '[]', '[\"photos\\/FMrJwCitpZ9GQBFt5FRVtTlwBNhaYbA77HxsHz7k.jpg\"]', '', '', '', '', '', '', '', '', NULL, NULL, '2024-11-02 21:39:02', '2024-12-12 10:37:08'),
(9, 'asd', 'asd', 'asd', '[\"2\",\"3\"]', '2024-12-12', NULL, NULL, NULL, 'asdad', '[]', '[]', 'asd', 'asd', 'asd', 'asd', 'DWI', 'asdad', 'asd', 'asdasd', NULL, NULL, '2024-12-12 08:55:29', '2024-12-12 08:55:29'),
(10, 'a', 'Kent Russell Casiño', '123', '[\"2\",\"3\"]', '2024-12-12', NULL, NULL, NULL, 'qwe', '[]', '[]', '123', 'qwe', '2024-12-10', '123', 'ILLEGALLY PARKED', NULL, 'qwe', NULL, NULL, NULL, '2024-12-12 10:13:48', '2024-12-12 10:13:48'),
(11, 'adasd', 'Judy', 'Kia', '[\"3\"]', '2024-12-12', '[\"OTHER\"]', '150.00', NULL, 'QWEQWE', '[]', '[]', 'K20-123', 'address', '2024-12-02', '123123', 'BURNED', 'kkkk', NULL, NULL, NULL, NULL, '2024-12-12 10:15:05', '2024-12-15 19:21:46'),
(12, 'e', 'Kent Russell Casiño', '123', '[\"3\",\"4\"]', '2024-12-12', '[\"OTHER\"]', '100.00', '2024-12-13', 'ASDAD', '[]', '[]', 'ASD', '123213', '2024-12-10', '123', 'STOLEN', 'cxxcx', NULL, NULL, 'Kent', 'PO1', '2024-12-12 10:17:19', '2024-12-15 19:21:14'),
(13, 'a', 'Kent Russell Casiño', '123asdasd', '[\"2\",\"3\"]', '2024-12-12', '[\"ACCIDENT\",\"BURNED\"]', '100.00', '2024-12-13', 'asdsad', '[]', '[\"photos\\/k1njaYMfrCHEJ9fuslEtg5scuyLQ3lM2w8CDdSTa.png\",\"photos\\/iLEal133rmTcOUD91U8hItojtCho7jKKgbCaQN3y.png\",\"photos\\/JZn8xXLFDJesj91a3Xq0sER5OiKyCCf0UbntRPtB.jpg\"]', 'rqweqew', 'qasd', '2024-12-11', '213', 'ACCIDENT', '262255', NULL, NULL, 'Judy', 'PO2', '2024-12-12 11:07:35', '2024-12-15 19:20:59'),
(14, 'test', 'Kent Russell Casiño', 'test', '[\"2\"]', '2024-12-16', '[\"OTHER\",\"STOLEN\"]', '0.00', NULL, 'test', '[]', '[]', 'test1', 'test', '2024-11-11', 'test', 'ACCIDENT', 'asdsadsd', NULL, NULL, NULL, NULL, '2024-12-15 18:40:03', '2024-12-15 19:19:16'),
(15, 'KTV1532', 'Kent Russell Casiño', 'test', '[\"3\",\"4\"]', '2024-12-16', '[\"ACCIDENT\",\"STOLEN\"]', '0.00', NULL, 'test', '[]', '[\"photos\\/9MYwfglm173hfatbcYWtsc87nt6BvYwZCHcu2Tl0.png\",\"photos\\/y5bog3TrIvsZDS0sJYOEbkITxaZSxJlvQX2KGKY3.png\"]', 'test', 'test', '1998-12-01', 'test', 'BURNED', NULL, NULL, NULL, NULL, NULL, '2024-12-15 19:06:31', '2024-12-15 19:16:48'),
(16, 'asdasdasda', 'Kent Russell Casiño', 'test', '[\"3\",\"7\"]', '2024-12-16', '[\"ACCIDENT\",\"BURNED\",\"OTHER\",\"ABANDONED\",\"ILLEGALLY PARKED\"]', '0.00', '2024-12-16', 'test', '[]', '[\"photos\\/4XZdtfVvfok7XEUh5I8hv1UZj26zR8yAF3iRuiTh.png\",\"photos\\/O1nrG2pspgTp0BT93FK4KC4rlQ4KemJnluY8RNXV.png\"]', 'test', 'test', '2024-12-02', 'test', 'BURNED', 'dsdsdsds', NULL, NULL, 'jdssf', 'sffsf', '2024-12-15 19:08:55', '2024-12-15 19:23:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `account_type` varchar(200) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `account_type`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, 'Kent Russell Casiño', 'Administrator', 'kent@tcc.edu.ph', NULL, '$2y$12$jNRwKOeSoo88g1uqP/lD2OHbB0yWm3K.BQBEH4DC3ps6NB3GJ4Tn.', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-13 12:04:23', '2024-10-13 12:04:23'),
(4, 'Kent Russell Casiño', 'Officer', 'kent1@tcc.edu.ph', NULL, '$2y$12$awq7AVaPsSIum.lZcXjYcO1qaQmVTU8cJRBZVB2aLzAHUxntHKfi2', NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-15 20:09:06', '2024-12-15 20:09:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `t_entries_violations`
--
ALTER TABLE `t_entries_violations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_traffic_citations`
--
ALTER TABLE `t_traffic_citations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_vehicle_impoundings`
--
ALTER TABLE `t_vehicle_impoundings`
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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_entries_violations`
--
ALTER TABLE `t_entries_violations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `t_traffic_citations`
--
ALTER TABLE `t_traffic_citations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `t_vehicle_impoundings`
--
ALTER TABLE `t_vehicle_impoundings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
