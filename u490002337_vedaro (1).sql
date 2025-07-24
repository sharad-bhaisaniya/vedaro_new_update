-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 24, 2025 at 08:27 AM
-- Server version: 10.11.10-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u490002337_vedaro`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `country` varchar(255) NOT NULL DEFAULT 'India',
  `address` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `city`, `state`, `pincode`, `is_default`, `country`, `address`, `created_at`, `updated_at`) VALUES
(2, 1, 'INDORE', 'Madhya Pradesh', '462044', 0, 'india', 'vijay nagar 78 inside main', '2025-07-19 06:41:44', '2025-07-19 11:16:27'),
(4, 1, 'Bhopal', 'Madhya Pradesh', '462044', 0, 'India', 'bhopal  j', '2025-07-19 07:43:24', '2025-07-19 11:16:27'),
(8, 1, 'INDORE', 'Madhya Pradesh', '462044', 0, 'India', 'Apna Sweets near vijay nagar', '2025-07-19 11:13:56', '2025-07-19 11:16:27'),
(9, 1, 'Bhopal', 'Madhya Pradesh', '462044', 0, 'India', 'Bhopal Neelbad', '2025-07-19 11:14:33', '2025-07-19 11:16:27'),
(10, 1, 'Ashta', 'Madhya Pradesh', '466125', 1, 'India', 'Ashta Choupati', '2025-07-19 11:15:10', '2025-07-19 11:16:27'),
(11, 1, 'Ashta', 'Madhya Pradesh', '466125', 0, 'India', 'Maina, teh: Ashta, Dist: Sehore Madhya Pradesh', '2025-07-19 11:15:33', '2025-07-19 11:16:27'),
(12, 1, 'Sehore', 'Madhya Pradesh', '466001', 0, 'India', 'Sehore', '2025-07-19 11:16:12', '2025-07-19 11:16:27'),
(13, 5, 'Shahapur', 'Madhya Pradesh', '460668', 0, 'India', 'Shahapur', '2025-07-22 10:02:00', '2025-07-22 10:03:03'),
(14, 5, 'Shahapur', 'Madhya Pradesh', '460668', 1, 'India', 'Shahapur', '2025-07-22 10:03:03', '2025-07-22 10:03:03');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@example.com', '$2y$12$9WsLlJ0Ju0OavEr.KJyo2OuBPuIZX9AFjSXZG883VG1vJrPxBAN32', NULL, '2025-07-19 11:54:08', '2025-07-19 11:54:08');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` enum('image','video') NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `type`, `file_path`, `created_at`, `updated_at`, `is_active`) VALUES
(1, 'Diamonds', 'video', 'banners/SgkLnvxIoWEPoKbGXueg1WSQGb684J21o0a1QM8V.mp4', '2025-07-16 07:31:36', '2025-07-23 12:55:38', 1),
(2, 'Est nihil est et inv', 'image', 'banners/3OKEZHIILWTOGUvcZiuLLdcj1c78V8f7lJkIYpRp.png', '2025-07-16 07:33:32', '2025-07-23 12:55:38', 0),
(4, 'Rings', 'image', 'banners/sxcTpd6yTBBibYU5nSaqzshfdiA1qhNCDdX23YDK.jpg', '2025-07-16 10:37:56', '2025-07-23 12:55:38', 0),
(5, 'Rings', 'video', 'banners/WPb69z73lZSnrquK53vyeXbrS9qARfpMANigzzqu.mp4', '2025-07-16 10:39:56', '2025-07-23 12:55:38', 0),
(6, 'Gold Rings', 'video', 'banners/Cf3EWnAyBANkgZtAwB7Sxj2O6J3eOf2YWAjsTtq5.mp4', '2025-07-16 10:40:51', '2025-07-23 12:55:38', 0),
(7, 'Ring', 'image', 'banners/gSLP2d9w4l58jlYz8b0kc8lCbqsmQkE376XhBdSU.jpg', '2025-07-16 10:42:26', '2025-07-23 12:55:38', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_qty` int(11) NOT NULL DEFAULT 1,
  `total` decimal(10,2) DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `product_id`, `product_qty`, `total`, `customer_id`, `created_at`, `updated_at`) VALUES
(22, 1, 1, 105780.73, 6, '2025-07-22 10:43:49', '2025-07-24 06:03:53'),
(34, 3, 2, 105780.73, 6, '2025-07-23 10:12:22', '2025-07-24 06:05:16'),
(35, 2, 2, 105780.73, 6, '2025-07-23 10:12:25', '2025-07-24 06:03:53');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `image`, `active`, `created_at`, `updated_at`) VALUES
(7, 'Bangles', 'asgawg', 'products/r9Aemrc6ns7Zsa44OkHQH9l881QnxVYo9h1iz7fU.webp', 0, '2025-07-16 09:47:02', '2025-07-16 12:45:24'),
(8, 'Earings', 'asdasdg', 'products/58HNHq0K1jGVM0Ip4Dtb6Y6wICx2vEHakQkAWV8m.webp', 1, '2025-07-16 09:47:14', '2025-07-16 09:48:28'),
(9, 'rings', 'sdsgdg', 'products/0yZsFD0g7GBv5tJPBfLht3kli8g5mKolJ01HsTNz.webp', 1, '2025-07-16 09:47:28', '2025-07-16 09:48:30'),
(10, 'Bracelate', NULL, 'products/ev6m093XztcJxpPfeFAESPhVbJuXTwdVcwSsWNu4.webp', 1, '2025-07-16 09:47:56', '2025-07-16 09:48:32'),
(11, 'Samuel Oneill', 'Proident iure quis', 'products/eipfdaHNZsB0GY3Yz7mLGSU78dn17P3heQm9ReBu.jpg', 1, '2025-07-16 09:48:17', '2025-07-16 12:45:26'),
(12, 'Necklece', 'dfowaohwhf', 'products/KfiXD7pTu8TdyO45JRRKvw8UnUFnLBOvKxmearNx.jpg', 0, '2025-07-17 12:09:08', '2025-07-17 12:09:08');

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
-- Table structure for table `gift_products`
--

CREATE TABLE `gift_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `size` varchar(255) NOT NULL,
  `weight` varchar(255) NOT NULL,
  `product_description1` text NOT NULL,
  `product_description2` text DEFAULT NULL,
  `product_image1` varchar(255) DEFAULT NULL,
  `product_image2` varchar(255) DEFAULT NULL,
  `product_image3` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gift_products`
--

INSERT INTO `gift_products` (`id`, `product_name`, `price`, `size`, `weight`, `product_description1`, `product_description2`, `product_image1`, `product_image2`, `product_image3`, `created_at`, `updated_at`) VALUES
(1, 'test Gift', 1990.00, '200 X 100 x 50', '500 grams', 'Beatae dolorem omnis', 'Rerum in alias eos d', 'products/zBxPGARP3AR9jIdcjBFqdIdT6Bn5zkWFabWUl9SX.png', 'products/x8RA4F6FT4dQh4DmE3rRrdfjqldOaycaAGrQKLMR.png', NULL, '2025-07-16 07:46:03', '2025-07-16 07:46:03');

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
-- Table structure for table `limited_edition_banners`
--

CREATE TABLE `limited_edition_banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `product_ids` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `limited_edition_banners`
--

INSERT INTO `limited_edition_banners` (`id`, `title`, `description`, `image`, `product_ids`, `created_at`, `updated_at`) VALUES
(9, 'Tenetur quaerat ex p', 'Nobis sunt voluptate', 'products/QCJCgzqnPHsBXjTW2hD9dURzrMUQvexyY8glvF6J.jpg', '17,20', '2025-07-19 07:02:09', '2025-07-24 08:25:15'),
(10, 'Dignissimos ullam te', 'Dolor vel quia adipi', 'products/vQVvoBXnnneSuWLyfujV73DYeq0G12xmprOeNAfZ.jpg', '12,9', '2025-07-19 07:02:46', '2025-07-24 08:25:01'),
(11, 'Vero saepe voluptas', 'Eligendi ad nostrud', 'products/PhzSGV2ukuzKvV51MHmokqmB4WmkanQvyvySLt5p.jpg', '4,6,23', '2025-07-19 07:03:10', '2025-07-24 08:25:09');

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
(4, '2025_01_01_044811_create_tests_table', 1),
(5, '2025_01_01_052018_create_register_table', 1),
(6, '2025_01_02_080138_create_products_table', 1),
(7, '2025_01_03_060002_create_categories_table', 1),
(8, '2025_01_06_223805_create_carts_table', 1),
(9, '2025_01_07_101458_create_gift_products_table', 1),
(17, '2025_01_09_063606_add_profile_fields_v2_to_users_table', 2),
(18, '2025_01_11_073424_create_ratings_table', 2),
(19, '2025_01_17_080919_create_orders_table', 2),
(20, '2025_01_17_080940_create_order_items_table', 2),
(21, '2025_01_31_065113_add_google_id_to_users_table', 2),
(22, '2025_02_04_085527_create_shiprocket_orders_table', 2),
(24, '2025_07_14_120249_create_banners_table', 3),
(25, '2025_07_14_163716_add_is_active_to_banners_table', 3),
(26, '2025_07_16_070814_create_other_banners_table', 4),
(27, '2025_07_16_092318_create_categories_table', 5),
(28, '2025_07_16_114402_add_category_id_to_products_table', 6),
(29, '2025_07_17_105754_create_user_inquiries_table', 7),
(30, '2025_07_18_093505_create_pre_bookings_table', 8),
(31, '2025_07_18_113021_create_limited_edition_banners_table', 9),
(32, '2025_07_19_062041_create_addresses_table', 10),
(33, '2025_07_19_073524_add_product_ids_to_limited_edition_banners_table', 11),
(34, '2025_07_19_091257_add_is_default_to_addresses_table', 12),
(35, '2025_07_19_111648_add_extra_columns_to_products_table', 13),
(36, '2025_07_19_113506_create_admins_table', 14),
(37, '2025_07_22_112137_create_user_inquiries_table', 15);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `txnid` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `postal_code` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `shipping_address` text DEFAULT NULL,
  `billing_address` text DEFAULT NULL,
  `razorpay_order_id` varchar(255) DEFAULT NULL,
  `razorpay_payment_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `awb` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_id`, `txnid`, `full_name`, `email`, `phone`, `amount`, `address`, `city`, `postal_code`, `country`, `status`, `shipping_address`, `billing_address`, `razorpay_order_id`, `razorpay_payment_id`, `created_at`, `updated_at`, `awb`) VALUES
(39, '#MAHA-F6bqJV5', 'pay_Qw58hELNenqS4u', 'Bhupendra Dhote', 'bhudhote998@gmail.com', '08109010648', 9.15, 'Shahapur', 'Shahapur', '460668', 'India', 'Shipped', 'Shahapur', 'Shahapur', 'order_Qw57nnyvk1LYjM', 'pay_Qw58hELNenqS4u', '2025-07-22 10:33:47', '2025-07-22 12:17:37', ''),
(40, '#MAHA-dNpTNW5', 'pay_Qw76vF0E5mpGgS', 'Bhupendra Dhote', 'bhudhote998@gmail.com', '08109010648', 9.15, 'Shahapur', 'Shahapur', '460668', 'India', 'Shipped', 'Shahapur', 'Shahapur', 'order_Qw76eQJ1gmdCOX', 'pay_Qw76vF0E5mpGgS', '2025-07-22 12:30:03', '2025-07-22 12:30:49', ''),
(41, '#MAHA-y7pOoe5', 'pay_Qw79cIEmmRtD5i', 'Bhupendra Dhote', 'bhudhote998@gmail.com', '08109010648', 1389.15, 'Shahapur', 'Shahapur', '460668', 'India', 'Shipped', 'Shahapur', 'Shahapur', 'order_Qw78t2ZqFipWqc', 'pay_Qw79cIEmmRtD5i', '2025-07-22 12:32:12', '2025-07-22 12:33:19', '');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_qty` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `total` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_qty`, `price`, `total`, `created_at`, `updated_at`) VALUES
(35, 39, 10, 1, 15.00, 15.00, '2025-07-22 10:33:47', '2025-07-22 10:33:47'),
(36, 40, 10, 1, 15.00, 15.00, '2025-07-22 12:30:03', '2025-07-22 12:30:03'),
(37, 41, 5, 1, 1500.00, 1500.00, '2025-07-22 12:32:12', '2025-07-22 12:32:12'),
(38, 41, 10, 1, 15.00, 15.00, '2025-07-22 12:32:12', '2025-07-22 12:32:12');

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
-- Table structure for table `pre_bookings`
--

CREATE TABLE `pre_bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pre_bookings`
--

INSERT INTO `pre_bookings` (`id`, `user_id`, `product_id`, `quantity`, `email`, `phone`, `note`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 590, 'bhaisaniyasharad@gmail.com', '9784848457', 'Et sit quasi dolores', '2025-07-18 09:58:44', '2025-07-18 09:58:44'),
(2, 5, 1, 1, 'bhaisaniyasharad@gmail.com', '9784848457', '8hg6g6g', '2025-07-18 10:44:42', '2025-07-18 10:44:42'),
(3, 6, 1, 1, 'bhudhote998@gmail.com', '08109010648', NULL, '2025-07-22 08:56:37', '2025-07-22 08:56:37'),
(4, 6, 1, 10, 'bhaisaniyasharad@gmail.com', '9784848457', 'dfffog', '2025-07-23 07:48:11', '2025-07-23 07:48:11');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `productName` varchar(255) NOT NULL,
  `coupon_code` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `weight` varchar(255) NOT NULL,
  `productDescription1` text NOT NULL,
  `productDescription2` text DEFAULT NULL,
  `material` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `variants` text DEFAULT NULL,
  `hsn_code` varchar(255) DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `supplier_name` varchar(255) DEFAULT NULL,
  `cost_price_per_unit` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `discountPercentage` decimal(5,2) NOT NULL,
  `discountPrice` decimal(10,2) DEFAULT NULL,
  `image1` varchar(255) NOT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `shipping_fee` decimal(10,2) NOT NULL,
  `availability` tinyint(1) NOT NULL DEFAULT 1,
  `on_sell` tinyint(1) NOT NULL DEFAULT 1,
  `add_timer` tinyint(1) NOT NULL DEFAULT 0,
  `timer_end_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `productName`, `coupon_code`, `category`, `size`, `weight`, `productDescription1`, `productDescription2`, `material`, `color`, `variants`, `hsn_code`, `sku`, `barcode`, `supplier_name`, `cost_price_per_unit`, `price`, `discountPercentage`, `discountPrice`, `image1`, `image2`, `image3`, `stock`, `shipping_fee`, `availability`, `on_sell`, `add_timer`, `timer_end_at`, `created_at`, `updated_at`) VALUES
(1, 'Wyatt Sullivan', 'COUPON-RJX7B8', '1', '200 X 100 x 50', '500 ', 'Facere eu similique\nThe imported diamond ring\nThe imported diamond ring\nThe imported diamond ring\nThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ring', 'Nihil est ratione m', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 577.00, 0.00, 398.13, 'products/lPKQLNrFt7j11412wdWluZGWW9qgwvMKst60P2ad.jpg', 'products/qluPNKY9xQKnvzYRUwLlXpXLuEKBO8ARF7S6Fha9.jpg', 'products/HJpI1ubLPVRsCgfVcwUreiU7FD8vBFLhbISe5nSs.jpg', 0, 89.00, 0, 0, 1, '2025-07-16 02:15:50', '2025-07-16 07:09:50', '2025-07-16 07:09:50'),
(2, 'Diamond-ring', 'DISCOUNT10', '9', '25 x 16  x 8', '32', 'The imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ring', 'The imported diamond ring', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 50000.00, 0.00, 44000.00, 'products/15Y6COAjI9YP7BEg5vBS24pjuTcGKLRmEouQTeKm.jpg', 'products/ddyjm9SFfzKvhQ7QU0GfWAfFRktmsDo2PKLmAdaU.jpg', NULL, 1, 59.00, 1, 1, 1, '2025-07-20 18:29:57', '2025-07-16 10:19:32', '2025-07-16 10:19:32'),
(3, 'Bracelate', 'DISCOUNT10', '10', '25 x 16 x 8', '100', 'The imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ring', 'dfkasfiherififr', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9990.00, 0.00, 8691.30, 'products/eoaRrzpzG2NiijXCl6y7tNArNMfEMzfzin5HGTGK.jpg', 'products/xz8bSgj6l8fXtJdbVHz7koug87ZDvCs3fbqcwH28.jpg', NULL, 10, 30.00, 0, 1, 1, '2025-07-21 12:24:17', '2025-07-16 10:22:14', '2025-07-16 10:22:14'),
(4, 'Green Earings', 'DISCOUNT10', '8', '8*8*8', '32', 'gfsgerghei', 'g;jroergn', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4000.00, 0.00, 3280.00, 'products/u4HNsDnRZIXTW2NLT0B63eM53PURlQINOxvfxx6s.jpg', 'products/PqzCQViogBgmBFeYLYN1aQ7QowifRzqqrLk3fG4q.jpg', NULL, 20, 30.00, 0, 1, 1, '2025-07-24 18:32:01', '2025-07-16 10:23:53', '2025-07-16 10:23:53'),
(5, 'Earings', 'COUPON-QPPGRD', '8', '8*8*8', '32', 'The imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ringThe imported diamond ring', 'dfggsdfgg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1500.00, 0.00, 1380.00, 'products/zei8MgzcFlyl0MuTTEiv1bKrE1OdLBeKnEILIUtj.jpg', 'products/S5NuRJXLNIkG45GQZ3dosbjJFSyZ9JFa6kEI2t6O.jpg', NULL, 33, 30.00, 0, 1, 1, '2025-07-21 15:30:19', '2025-07-16 10:25:14', '2025-07-16 10:25:14'),
(6, 'Farrah Fry', 'COUPON-1FJM7Z', '8', '8*8*8', '32', 'Voluptatem corporis', 'Atque eveniet in es', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 679.00, 0.00, 617.89, 'products/TsJCePIP4yh7RkqNJs2N2bSZvTjdGRiKiYQLWUDs.jpg', 'products/JDeNk36nHo7i5ph31EcTB22Qlpkz96roFZHMRAFS.jpg', NULL, 12, 95.00, 0, 1, 1, '2025-08-03 02:34:07', '2025-07-16 10:26:28', '2025-07-16 10:26:28'),
(7, 'May Cortez', 'COUPON-S9PVTM', '7', 'Facere est est aut', 'Cupiditate incidunt', 'Fugiat perspiciatis', 'Quo culpa nobis pos', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 418.00, 0.00, 372.02, 'products/KbSTn11ZtQctSRm6iph9IVj2yiTNrOHStJJkRNs2.jpg', 'products/llvV9vFzSDgoHEgChRDpAcVhsZhSZs7028M9iNEP.jpg', NULL, 75, 92.00, 0, 0, 1, '2025-07-24 03:01:10', '2025-07-16 10:27:46', '2025-07-16 10:27:46'),
(8, 'Amethyst Mullen', 'COUPON-DRUASM', '7', '25 x 16 x 8', '600', 'Pariatur Molestiae', 'Sed incidunt ducimu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 551.00, 0.00, 446.31, 'products/Ic1fc5udQMM25U4EGM4QcigG2mgKP297pnXwmyaf.jpg', 'products/d3TEpTaaHdH40o9a3A5FE6BXCYLOo4xrI6QP7lBu.jpg', NULL, 8, 62.00, 0, 0, 1, '2025-07-19 21:32:33', '2025-07-16 10:28:39', '2025-07-16 10:28:39'),
(9, 'Rhona Freeman', 'COUPON-4X88WL', '8', '25 x 16 x 8', '32', 'Ab delectus eos am', 'Velit dignissimos si', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 798.00, 0.00, 135.66, 'products/BcIr1yLg11CvVPfRDC1VD4JwZUErMZxT6Wttjve5.jpg', NULL, NULL, 42, 14.00, 0, 0, 1, '2025-07-29 16:26:13', '2025-07-16 10:44:21', '2025-07-16 10:44:21'),
(10, 'Daryl Bauer', 'COUPON-N6QIE3', '10', '25 x 16 x 8', '250', 'Sint ratione numquam', 'Sed minus quisquam n', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15.00, 0.00, 9.15, 'products/RLe5JGxQuUxICmWPN4MKXYYN9ekn5Zjkr5yBVJf1.jpg', 'products/ZmYkxu7LFMtIenBL5BMdeN1aYM3oZ92n27HHVhkx.jpg', NULL, 86, 44.00, 0, 1, 0, NULL, '2025-07-16 10:48:43', '2025-07-16 10:48:43'),
(11, 'Necklece', 'COUPON-J84N1G', '12', '25 x 16  x 8', '250', 'egnihgihrg', 'fihghihrg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 50000.00, 0.00, 44000.00, 'products/ZOm1KV5yFOTaMDKno38lw7MSOBeNRd0pTdRsEZQ6.jpg', NULL, NULL, 12, 20.00, 1, 1, 1, '2025-07-21 16:14:36', '2025-07-17 12:10:32', '2025-07-17 12:10:32'),
(12, 'Gold Necklece', 'COUPON-7EOZIO', '12', 'Sint officia suscipi', 'Expedita corporis si', 'Eligendi quis cumque', 'Deleniti eveniet ut', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 73000.00, 0.00, 60590.00, 'products/qT3z4RQfpUMbroxCwTbvyMAqJYIKr8Vmd3tyoVIW.webp', NULL, NULL, 91, 105.00, 1, 0, 1, '2025-07-25 16:12:10', '2025-07-17 12:13:54', '2025-07-17 12:13:54'),
(13, 'kkkkkkkkkk', 'COUPON-BACKY1', '11', '25 x 16 x 8', '250', 'Maiores unde fugiat', 'Nobis velit qui veli', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 709.00, 0.00, 680.64, 'products/RtUMOKZ76nMsbsdDhy8cpkfTdU6OrgGHSnoQR1vA.jpg', 'products/EqZX69MG7FaixJZLNnYKtsn1wEVhJAXVAkR2j0oK.webp', NULL, 5, 76.00, 0, 1, 1, '2025-07-23 15:22:48', '2025-07-19 11:18:44', '2025-07-19 11:18:44'),
(17, 'New Product', 'COUPON-44AP3O', '11', '25 x 16 x 8', '32', 'Dolore dolor earum u', 'Inventore expedita e', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 106.00, 0.00, 106.00, 'products/3j10KS1tkd5IiExXftyQdZFfVYscZ8FCgi57LKo1.webp', 'products/1ucltGX5pFMyXLj2OQaDCikb42Eg3IQqrDDC6Y1a.webp', 'products/P461we4KbIGdSl632G0wYhUqZG5j3I2i9tDAtv1c.webp', 59, 4.00, 1, 1, 1, '2025-07-26 11:12:44', '2025-07-23 08:09:41', '2025-07-23 08:09:41'),
(18, 'Kylan Winters', 'COUPON-07HL8G', '9', '25 x 16  x 8', '32', 'Incidunt exercitati', 'Consectetur repellen', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 640.00, 0.00, 640.00, 'products/m5Kfmj4Yfz6koJnBVeW4b6XMXomQuXOHlzofKvrT.webp', 'products/KoUqbVoQUockMCNIF8wZyJQjfqOoUPdLOLZXOP0d.jpg', 'products/W8CLYMQCXDmzF0J0hJdyXNY54KhoxNDlrRVl4cOl.webp', 5, 55.00, 1, 0, 0, NULL, '2025-07-23 08:14:45', '2025-07-23 08:14:45'),
(19, 'Patrick Pugh', 'COUPON-O43IIN', '11', '25 x 16 x 8', '32', 'Nostrum voluptas qui', 'Cupidatat sequi omni', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 183.00, 96.00, 7.32, 'products/Nx1qV0MEYCz3ZdMMC70ZL9cRojiHst88kxouQa6W.jpg', 'products/0jERp1adVlslfm0XoOICSMUBZ8nU6KpNDKAvxJtJ.jpg', NULL, 9, 3.00, 0, 1, 0, NULL, '2025-07-23 08:17:14', '2025-07-23 08:17:14'),
(20, 'Jelani Kemp', 'COUPON-MLZZYY', '8', '25 x 16  x 8', '32', 'Quibusdam alias nisi', 'Ex sequi voluptatem', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 81.00, 0.00, 81.00, 'products/f2pinSPNLBTZmh56DjsM4Y41ZVevRpJmPi8wPss3.jpg', 'products/4cc6juSbyfAyfxAbEsOZpqfreH8J730f5GmGTauJ.jpg', NULL, 34, 23.00, 1, 1, 1, '2025-08-01 14:39:37', '2025-07-23 08:17:40', '2025-07-23 08:17:40'),
(21, 'Marshall Huff', 'COUPON-PFHRW3', '7', '25 x 16  x 8', '32', 'Ipsa iste dolor dis', 'Velit sunt duis reic', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 329.00, 69.00, 101.99, 'products/FmzIRqfGSELThZanTGPkrNacpfwX1scOtDy89EeN.jpg', 'products/tVKDdaBmXEUrJXgViftE1TzVSl7ljI0QrkkDWynV.jpg', NULL, 32, 18.00, 0, 1, 0, NULL, '2025-07-23 08:18:02', '2025-07-23 08:18:02'),
(22, 'Keith Maynard', 'COUPON-T5XAM4', '8', '25 x 16  x 8', '32', 'Porro adipisicing de', 'Fuga Tempora eum si', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 378.00, 0.00, 378.00, 'products/IHs2307Q24o7CKhyXdn1izVL2ZGwKMK2xhveU3UO.jpg', 'products/EMcNWYBogwFUWkM6L7VTnvSRcJc7RRSw5kPHSQWL.jpg', NULL, 3, 32.00, 0, 1, 0, NULL, '2025-07-23 08:18:24', '2025-07-23 08:18:24'),
(23, 'Lysandra Knox', 'COUPON-PV56XP', '10', '25 x 16  x 8', '32', 'Totam reprehenderit', 'Non id velit quod vo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 864.00, 0.00, 864.00, 'products/PzmssJIsjomgd4eAQwRwHvZsABxvlVvITf2z4oaF.jpg', 'products/28AaPubpVa7D0V98p4JvYbdE0yWITKpG99sHXOcX.jpg', NULL, 81, 29.00, 0, 0, 1, '2025-07-25 07:06:34', '2025-07-23 08:18:50', '2025-07-23 08:18:50'),
(24, 'Barclay Perry', 'COUPON-1ZW1AI', '8', '25 x 16 x 8', '32', 'Rerum dolor elit cu', 'Ut autem ratione acc', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 933.00, 0.00, 933.00, 'products/AvqbP2z3SgWzZcQiZKS1otKPZJObHd0z4wqWLP8r.jpg', 'products/dDx3qhpytRwwUQjMf8LJuycqOxh8aqVXb7ajmJR7.jpg', NULL, 11, 97.00, 0, 0, 0, NULL, '2025-07-23 08:19:15', '2025-07-23 08:19:15');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` text DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `review_title` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `product_id`, `user_id`, `rating`, `review`, `name`, `review_title`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 4, 'Iure quod eiusmod te', 'Lamar Ortiz', 'Illum rem in cillum', NULL, '2025-07-16 07:12:16', '2025-07-16 07:12:16'),
(2, 2, 2, 5, 'qwertyuiop', 'Bhupendra Dhote', 'new pro sdfgsdfg', 'reviews/1O5aqCYGR6fRIkZ0QdTI2gcaznkHgIN9Y4ZykUMO.jpg', '2025-07-16 11:05:57', '2025-07-16 11:05:57'),
(3, 1, 2, 3, 'df', 'Bhupendra Dhote', 'asdf', NULL, '2025-07-16 12:01:26', '2025-07-16 12:01:26');

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `shiprocket_orders`
--

CREATE TABLE `shiprocket_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `shipment_id` bigint(20) DEFAULT NULL,
  `awb_code` varchar(255) DEFAULT NULL,
  `courier_name` varchar(255) DEFAULT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `origin` varchar(255) DEFAULT NULL,
  `packages` int(11) DEFAULT 1,
  `pod` varchar(255) DEFAULT NULL,
  `pod_status` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `tracking_url` varchar(255) DEFAULT NULL,
  `weight` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shiprocket_orders`
--

INSERT INTO `shiprocket_orders` (`id`, `order_id`, `shipment_id`, `awb_code`, `courier_name`, `destination`, `origin`, `packages`, `pod`, `pod_status`, `status`, `tracking_url`, `weight`, `created_at`, `updated_at`) VALUES
(1, 897594966, NULL, 'JH020627491IN', 'India Post-Speed Post Air Prepaid', 'Sehore, Madhya Pradesh', NULL, NULL, NULL, NULL, 'CANCELED', 'https://shiprocket.co/tracking/JH020627491IN', 0.60, '2025-07-19 12:35:41', '2025-07-22 07:05:46'),
(2, 897577607, NULL, 'JH020624915IN', 'India Post-Speed Post Air Prepaid', 'Sehore, Madhya Pradesh', NULL, NULL, NULL, NULL, 'CANCELED', 'https://shiprocket.co/tracking/JH020624915IN', 0.60, '2025-07-19 12:35:41', '2025-07-22 07:05:46'),
(3, 897560138, NULL, '362062695991', 'Amazon Shipping Surface 1kg', 'Sehore, Madhya Pradesh', NULL, NULL, NULL, NULL, 'CANCELED', 'https://shiprocket.co/tracking/362062695991', 0.60, '2025-07-19 12:35:41', '2025-07-22 07:05:46'),
(4, 897532135, NULL, 'FH005416889IN', 'India Post-Business Parcel Surface ', 'Indore, Madhya Pradesh', NULL, NULL, NULL, NULL, 'CANCELED', 'https://shiprocket.co/tracking/FH005416889IN', 0.60, '2025-07-22 09:21:18', '2025-07-22 12:36:15'),
(5, 903335353, NULL, '', '', 'Betul, Madhya Pradesh', NULL, NULL, NULL, NULL, 'NEW', 'https://shiprocket.co/tracking/', 0.60, '2025-07-22 12:23:01', '2025-07-22 12:36:15'),
(6, 903347261, NULL, '', '', 'Betul, Madhya Pradesh', NULL, NULL, NULL, NULL, 'NEW', 'https://shiprocket.co/tracking/', 0.60, '2025-07-22 12:31:12', '2025-07-22 12:36:15'),
(7, 903349742, NULL, 'JH020487180IN', 'India Post-Speed Post Air Prepaid', 'Betul, Madhya Pradesh', NULL, NULL, NULL, NULL, 'CANCELED', 'https://shiprocket.co/tracking/JH020487180IN', 0.60, '2025-07-22 12:33:45', '2025-07-22 12:36:15');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `pincode` int(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `phone`, `email`, `password`, `created_at`, `updated_at`, `profile_image`, `dob`, `gender`, `city`, `pincode`, `country`, `address`, `google_id`) VALUES
(6, 'sharad', 'verma', '9752008368', 'bhaisaniyasharad@gmail.com', '$2y$12$1NWqZADddgx3u2vsB.tkPekd8lHtWPmcnDk8KCCmAyp4ArZMLIq2O', '2025-07-22 09:40:30', '2025-07-23 11:32:13', NULL, NULL, 'Male', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_inquiries`
--

CREATE TABLE `user_inquiries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_inquiries`
--

INSERT INTO `user_inquiries` (`id`, `name`, `email`, `phone`, `subject`, `message`, `created_at`, `updated_at`) VALUES
(1, 'Armand Nunez', 'kekapusow@mailinator.com', '9784848457', 'Inventore incidunt', 'Rem voluptatem conse', '2025-07-22 11:38:58', '2025-07-22 11:38:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `gift_products`
--
ALTER TABLE `gift_products`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `limited_edition_banners`
--
ALTER TABLE `limited_edition_banners`
  ADD PRIMARY KEY (`id`);

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
  ADD UNIQUE KEY `orders_order_id_unique` (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pre_bookings`
--
ALTER TABLE `pre_bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `register_phone_unique` (`phone`),
  ADD UNIQUE KEY `register_email_unique` (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `shiprocket_orders`
--
ALTER TABLE `shiprocket_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shiprocket_orders_order_id_unique` (`order_id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tests_email_unique` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_inquiries`
--
ALTER TABLE `user_inquiries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gift_products`
--
ALTER TABLE `gift_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `limited_edition_banners`
--
ALTER TABLE `limited_edition_banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `pre_bookings`
--
ALTER TABLE `pre_bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shiprocket_orders`
--
ALTER TABLE `shiprocket_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_inquiries`
--
ALTER TABLE `user_inquiries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
