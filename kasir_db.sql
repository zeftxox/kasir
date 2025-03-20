-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 20, 2025 at 02:04 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasir_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `kategori`, `created_at`, `updated_at`) VALUES
(1, 'Elektronik', '2025-03-18 02:07:47', '2025-03-18 02:07:47'),
(2, 'Fashion', '2025-03-18 02:07:47', '2025-03-18 02:07:47'),
(3, 'Makanan & Minuman', '2025-03-18 02:07:47', '2025-03-18 02:07:47'),
(4, 'Alat Rumah Tangga', '2025-03-18 02:07:47', '2025-03-18 02:07:47');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_pelanggan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_pelanggan` text COLLATE utf8mb4_unicode_ci,
  `nomor_hp` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `nama_pelanggan`, `alamat_pelanggan`, `nomor_hp`, `isDeleted`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, '0000000000000', 0, '2025-03-18 02:25:37', '2025-03-18 02:25:37'),
(2, 'Andrean', '1231', '099999', 0, '2025-03-18 18:53:15', '2025-03-18 18:53:15'),
(3, 'Andrean', '1231', '0999991', 0, '2025-03-18 20:32:33', '2025-03-18 20:32:33');

-- --------------------------------------------------------

--
-- Table structure for table `detail_penjualans`
--

CREATE TABLE `detail_penjualans` (
  `id` bigint UNSIGNED NOT NULL,
  `id_penjualan` bigint UNSIGNED NOT NULL,
  `id_products` bigint UNSIGNED NOT NULL,
  `harga_jual` decimal(15,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `harga_discount` decimal(15,2) NOT NULL,
  `qty` int NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `tanggal_penjualan` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_penjualans`
--

INSERT INTO `detail_penjualans` (`id`, `id_penjualan`, `id_products`, `harga_jual`, `discount`, `harga_discount`, `qty`, `subtotal`, `tanggal_penjualan`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 5000000.00, 100.00, 0.00, 2, 10000000.00, '2025-03-18 09:25:37', '2025-03-18 02:25:37', '2025-03-18 02:25:37'),
(2, 2, 1, 5000000.00, 34.00, 3300000.00, 1, 5000000.00, '2025-03-18 09:32:37', '2025-03-18 02:32:37', '2025-03-18 02:32:37'),
(3, 3, 1, 5000000.00, 5.00, 4750000.00, 1, 5000000.00, '2025-03-18 09:45:55', '2025-03-18 02:45:55', '2025-03-18 02:45:55'),
(4, 4, 4, 250000.00, 5.00, 475000.00, 2, 500000.00, '2025-03-18 09:46:59', '2025-03-18 02:46:59', '2025-03-18 02:46:59'),
(5, 4, 1, 5000000.00, 2.00, 4900000.00, 1, 5000000.00, '2025-03-18 09:46:59', '2025-03-18 02:46:59', '2025-03-18 02:46:59'),
(6, 4, 2, 75000.00, 1.00, 74250.00, 1, 75000.00, '2025-03-18 09:46:59', '2025-03-18 02:46:59', '2025-03-18 02:46:59'),
(7, 5, 3, 150000.00, 5.00, 142500.00, 1, 150000.00, '2025-03-18 09:49:55', '2025-03-18 02:49:55', '2025-03-18 02:49:55'),
(8, 5, 4, 250000.00, 2.00, 245000.00, 1, 250000.00, '2025-03-18 09:49:55', '2025-03-18 02:49:55', '2025-03-18 02:49:55'),
(9, 5, 5, 150100.00, 1.00, 148599.00, 1, 150100.00, '2025-03-18 09:49:55', '2025-03-18 02:49:55', '2025-03-18 02:49:55'),
(10, 6, 2, 75000.00, 5.00, 71250.00, 1, 75000.00, '2025-03-18 09:52:59', '2025-03-18 02:52:59', '2025-03-18 02:52:59'),
(11, 6, 3, 150000.00, 5.00, 142500.00, 1, 150000.00, '2025-03-18 09:52:59', '2025-03-18 02:52:59', '2025-03-18 02:52:59'),
(12, 6, 4, 250000.00, 5.00, 237500.00, 1, 250000.00, '2025-03-18 09:52:59', '2025-03-18 02:52:59', '2025-03-18 02:52:59'),
(13, 6, 5, 150100.00, 5.00, 142595.00, 1, 150100.00, '2025-03-18 09:52:59', '2025-03-18 02:52:59', '2025-03-18 02:52:59'),
(14, 7, 1, 5000000.00, 0.00, 5000000.00, 1, 5000000.00, '2025-03-19 03:17:51', '2025-03-18 20:17:51', '2025-03-18 20:17:51'),
(15, 8, 1, 5000000.00, 10.00, 4500000.00, 1, 5000000.00, '2025-03-19 03:31:31', '2025-03-18 20:31:31', '2025-03-18 20:31:31'),
(16, 9, 1, 5000000.00, 0.00, 5000000.00, 1, 5000000.00, '2025-03-20 01:03:28', '2025-03-19 18:03:28', '2025-03-19 18:03:28');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '2025_01_30_010714_create_categories_table', 1),
(3, '2025_01_30_010722_create_transactions_table', 1),
(4, '2025_01_30_012657_create_users_table', 1),
(5, '2025_01_30_021116_create_personal_access_tokens_table', 1),
(6, '2025_01_30_025434_create_sessions_table', 1),
(7, '2025_02_17_033726_create_products_table', 1),
(8, '2025_03_04_152851_create_customers_table', 1),
(9, '2025_03_04_152912_create_penjualan_table', 1),
(10, '2025_03_04_152918_create_detail_penjualan_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `penjualans`
--

CREATE TABLE `penjualans` (
  `id` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `id_customer` bigint UNSIGNED DEFAULT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_harga` decimal(15,2) NOT NULL,
  `penyesuaian` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_bayar` decimal(15,2) NOT NULL,
  `nominal_bayar` decimal(15,2) NOT NULL,
  `kembalian` decimal(15,2) NOT NULL,
  `tanggal_penjualan` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isDeleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penjualans`
--

INSERT INTO `penjualans` (`id`, `id_user`, `id_customer`, `discount`, `total_harga`, `penyesuaian`, `total_bayar`, `nominal_bayar`, `kembalian`, `tanggal_penjualan`, `isDeleted`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0.00, 0.00, 0.00, 0.00, 100.00, 100.00, '2025-03-18 09:25:37', 0, '2025-03-18 02:25:37', '2025-03-18 02:25:37'),
(2, 1, 1, 0.00, 3300000.00, 0.00, 3300000.00, 4000000.00, 700000.00, '2025-03-18 09:32:37', 0, '2025-03-18 02:32:37', '2025-03-18 02:32:37'),
(3, 1, 1, 0.00, 4750000.00, 0.00, 4750000.00, 5000000.00, 250000.00, '2025-03-18 09:45:55', 0, '2025-03-18 02:45:55', '2025-03-18 02:45:55'),
(4, 1, 1, 0.00, 5449250.00, 0.00, 5449250.00, 6000000.00, 550750.00, '2025-03-18 09:46:59', 0, '2025-03-18 02:46:59', '2025-03-18 02:46:59'),
(5, 1, 1, 0.00, 536099.00, 0.00, 536099.00, 600000.00, 63901.00, '2025-03-18 09:49:55', 0, '2025-03-18 02:49:55', '2025-03-18 02:49:55'),
(6, 1, 1, 0.00, 593845.00, 0.00, 593845.00, 600000.00, 6155.00, '2025-03-18 09:52:59', 0, '2025-03-18 02:52:59', '2025-03-18 02:52:59'),
(7, 1, 1, 0.00, 5000000.00, 0.00, 5000000.00, 5000000.00, 0.00, '2025-03-19 03:17:51', 0, '2025-03-18 20:17:51', '2025-03-18 20:17:51'),
(8, 1, 2, 0.00, 4500000.00, 0.00, 4275000.00, 5000000.00, 725000.00, '2025-03-19 03:31:31', 0, '2025-03-18 20:31:31', '2025-03-18 20:31:31'),
(9, 1, 1, 0.00, 5000000.00, 0.00, 5000000.00, 10000000.00, 5000000.00, '2025-03-20 01:03:28', 0, '2025-03-19 18:03:28', '2025-03-19 18:03:28');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `id_kategori` bigint UNSIGNED DEFAULT NULL,
  `nama_produk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_jual` decimal(12,2) NOT NULL,
  `harga_beli` decimal(12,2) NOT NULL,
  `stok` bigint NOT NULL,
  `barcode` char(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `id_kategori`, `nama_produk`, `harga_jual`, `harga_beli`, `stok`, `barcode`, `created_at`, `updated_at`, `isDeleted`) VALUES
(1, 1, 'Smartphone Samsung', 5000000.00, 4500000.00, 2, '1234567890123', '2025-03-18 02:07:47', '2025-03-19 18:03:28', 0),
(2, 2, 'Kaos Polos Hitam', 75000.00, 50000.00, 48, '1234567890124', '2025-03-18 02:07:47', '2025-03-18 02:52:59', 0),
(3, 3, 'Kopi Luwak', 150000.00, 120000.00, 18, '1234567890125', '2025-03-18 02:07:47', '2025-03-18 02:52:59', 0),
(4, 3, 'Roti', 250000.00, 150000.00, 46, '1234567890126', '2025-03-18 02:07:47', '2025-03-18 02:52:59', 0),
(5, 3, 'Teh', 150100.00, 120055.00, 18, '1234567890127', '2025-03-18 02:07:47', '2025-03-18 02:52:59', 0),
(6, 3, 'Sate', 150000.00, 120000.00, 50, '1234567890128', '2025-03-18 02:07:47', '2025-03-18 02:07:47', 0),
(7, 3, 'Jahe', 150000.00, 120000.00, 20, '1234567890129', '2025-03-18 02:07:47', '2025-03-18 02:07:47', 0),
(8, 3, 'Donat', 150000.00, 120000.00, 20, '1234567890130', '2025-03-18 02:07:47', '2025-03-18 02:07:47', 0),
(9, 3, 'Rambutan', 150000.00, 120000.00, 20, '1234567890131', '2025-03-18 02:07:47', '2025-03-18 02:07:47', 0),
(10, 3, 'Beras', 150000.00, 120000.00, 20, '1234567890132', '2025-03-18 02:07:47', '2025-03-18 02:07:47', 0),
(11, 3, 'Kacang', 150000.00, 120000.00, 20, '1234567890133', '2025-03-18 02:07:47', '2025-03-18 02:07:47', 0),
(12, 3, 'Sarden', 150000.00, 120000.00, 20, '1234567890134', '2025-03-18 02:07:47', '2025-03-18 02:07:47', 0),
(13, 3, 'Telur', 150000.00, 120000.00, 20, '1234567890135', '2025-03-18 02:07:47', '2025-03-18 02:07:47', 0),
(14, 3, 'Dancow', 150000.00, 120000.00, 20, '1234567890136', '2025-03-18 02:07:47', '2025-03-18 02:07:47', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('iHgvPiHctOvKQQ5SUMZhUqMYNlvmjaPEa8EBJgfK', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiY0xqNHlvR0VDRTNWazhrcWZGVGdZYndVRDdXUjZERDhmVE15anlkQyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZW5qdWFsYW4vc2hvdy85Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1742432635),
('ROImFaSCCSgcN002oSfxHXAsXrN4R7lN7GZZYptU', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWGUwVDE5ZVBTNmR6VGFKWDFaa044aFIwVHh6REttNUVRWmRhRmZOZiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9tYW5hZ2UtcHJvZHVjdCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1742365172);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_level` enum('admin','officer') COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `no_handphone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `user_level`, `username`, `password`, `alamat`, `no_handphone`, `isDeleted`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin', 'admin123', '$2y$12$d3Og1DX1xAMeUGx2aD3THOebkIWobapqVNHoN3dfhX.lEqIczKaFe', 'Jl. Admin No.1', '081234567890', 0, '2025-03-18 02:07:47', '2025-03-18 02:07:47'),
(2, 'Officer User', 'officer', 'officer123', '$2y$12$Xfwd8XLjBrrtZoQLBCeRAeC1rDABzfW2UalbZjBnUMMo3X.KY0BFm', 'Jl. Officer No.2', '081234567891', 0, '2025-03-18 02:07:47', '2025-03-18 02:07:47');

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
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_kategori_unique` (`kategori`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_nomor_hp_unique` (`nomor_hp`);

--
-- Indexes for table `detail_penjualans`
--
ALTER TABLE `detail_penjualans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_penjualans_id_penjualan_foreign` (`id_penjualan`),
  ADD KEY `detail_penjualans_id_products_foreign` (`id_products`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penjualans`
--
ALTER TABLE `penjualans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penjualans_id_user_foreign` (`id_user`),
  ADD KEY `penjualans_id_customer_foreign` (`id_customer`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_barcode_unique` (`barcode`),
  ADD KEY `products_id_kategori_foreign` (`id_kategori`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `detail_penjualans`
--
ALTER TABLE `detail_penjualans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `penjualans`
--
ALTER TABLE `penjualans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_penjualans`
--
ALTER TABLE `detail_penjualans`
  ADD CONSTRAINT `detail_penjualans_id_penjualan_foreign` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_penjualans_id_products_foreign` FOREIGN KEY (`id_products`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `penjualans`
--
ALTER TABLE `penjualans`
  ADD CONSTRAINT `penjualans_id_customer_foreign` FOREIGN KEY (`id_customer`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `penjualans_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
