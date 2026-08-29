-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 09, 2026 at 07:33 PM
-- Server version: 8.0.44
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL,
  `payment_status` enum('paid','unpaid') NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Rice & Curry', 'Sri Lankan rice meals', 1, '2026-05-16 11:25:11', '2026-05-16 11:25:11'),
(2, 'Short Eats', 'Snacks and pastries', 1, '2026-05-16 11:25:11', '2026-05-16 11:25:11'),
(3, 'Beverages', 'Hot and cold drinks', 1, '2026-05-16 11:25:11', '2026-05-16 11:25:11'),
(4, 'Desserts', 'Sweet treats', 1, '2026-05-16 11:25:11', '2026-05-16 11:25:11');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `category_id`, `name`, `description`, `price`, `image`, `is_available`, `created_at`, `updated_at`) VALUES
(1, 1, 'Chicken Rice & Curry', NULL, 350.00, NULL, 1, '2026-05-16 11:25:11', '2026-05-16 11:25:11'),
(2, 1, 'Fish Rice & Curry', NULL, 320.00, NULL, 1, '2026-05-16 11:25:11', '2026-05-16 11:25:11'),
(3, 1, 'Vegetable Rice', NULL, 250.00, NULL, 1, '2026-05-16 11:25:11', '2026-05-16 11:25:11'),
(4, 1, 'Beef Rice & Curry', NULL, 380.00, NULL, 1, '2026-05-16 11:25:11', '2026-05-16 11:25:11'),
(5, 2, 'Egg Roll', NULL, 80.00, NULL, 1, '2026-05-16 11:25:11', '2026-05-16 11:25:11'),
(6, 2, 'Patties', NULL, 70.00, NULL, 0, '2026-05-16 11:25:11', '2026-05-16 11:25:11'),
(7, 2, 'Fish Bun', NULL, 60.00, NULL, 1, '2026-05-16 11:25:11', '2026-05-16 11:25:11'),
(8, 2, 'Cutlets (2 pcs)', NULL, 130.00, NULL, 1, '2026-05-16 11:25:11', '2026-05-16 11:25:11'),
(9, 3, 'Tea', NULL, 50.00, NULL, 1, '2026-05-16 11:25:11', '2026-05-16 11:25:11'),
(10, 3, 'Coffee', NULL, 60.00, NULL, 1, '2026-05-16 11:25:11', '2026-05-16 11:25:11'),
(11, 3, 'Fresh Juice', NULL, 120.00, NULL, 1, '2026-05-16 11:25:11', '2026-05-16 11:25:11'),
(12, 3, 'Soft Drink', NULL, 90.00, NULL, 1, '2026-05-16 11:25:11', '2026-05-16 11:25:11'),
(13, 4, 'Ice Cream', NULL, 150.00, NULL, 1, '2026-05-16 11:25:11', '2026-05-16 11:25:11'),
(14, 4, 'Watalappan', NULL, 180.00, NULL, 1, '2026-05-16 11:25:11', '2026-05-16 11:25:11');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2024_01_01_000001_create_users_table', 1),
(4, '2024_01_01_000002_create_categories_table', 1),
(5, '2024_01_01_000003_create_menu_items_table', 1),
(6, '2024_01_01_000004_create_orders_table', 1),
(7, '2024_01_01_000005_create_order_items_table', 1),
(8, '2024_01_01_000006_create_bills_table', 1),
(9, '2026_05_16_164952_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `table_number` tinyint UNSIGNED DEFAULT NULL,
  `type` enum('dine_in','takeaway') NOT NULL DEFAULT 'dine_in',
  `status` enum('pending','preparing','ready','completed','cancelled') NOT NULL DEFAULT 'pending',
  `notes` text,
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `table_number`, `type`, `status`, `notes`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'takeaway', 'pending', 'SASA', 380.00, '2026-05-16 11:27:40', '2026-05-16 11:27:40');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `menu_item_id` bigint UNSIGNED NOT NULL,
  `quantity` smallint UNSIGNED NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `menu_item_id`, `quantity`, `unit_price`, `subtotal`) VALUES
(1, 1, 4, 1, 380.00, 380.00);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(2, 'App\\Models\\User', 1, 'rms-token', '70ef08f65bfc82106848b5456beffdca4d6977ebbc5d2d9ee65f236ce2f7d8f2', '[\"*\"]', '2026-05-16 11:30:40', NULL, '2026-05-16 11:30:39', '2026-05-16 11:30:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff') NOT NULL DEFAULT 'staff',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@street160.lk', '$2y$12$qDR1LjqQ.5FbBwuIudhOAe1icRRGxb9u6wmOAH/8t3WiVe.ju.X9e', 'admin', NULL, NULL, '2026-05-16 11:25:11', '2026-05-16 11:25:11'),
(2, 'Staff One', 'staff1@street160.lk', '$2y$12$XcDCeTur/Az4Z35S7JnJfO3Y7./zaLboTVCGx3sbTrnE8jhYKVAqO', 'staff', NULL, NULL, '2026-05-16 11:25:11', '2026-05-16 11:25:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bills_order_id_unique` (`order_id`);

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
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_items_category_id_foreign` (`category_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_menu_item_id_foreign` (`menu_item_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

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
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_menu_item_id_foreign` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
