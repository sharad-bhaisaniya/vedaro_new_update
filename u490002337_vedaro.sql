-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 12, 2025 at 09:06 AM
-- Server version: 11.8.3-MariaDB-log
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
(15, 6, 'Bhopal', 'Madhya Pradesh', '462044', 0, 'India', 'Bhopal Neelbad', '2025-07-27 19:09:57', '2025-07-27 19:09:57'),
(16, 28, 'Ashta', 'Madhya Pradesh', '466125', 0, 'India', 'Maina, teh: Ashta, Dist: Sehore Madhya Pradesh', '2025-08-17 12:46:51', '2025-08-17 12:46:51'),
(17, 28, 'indore', 'Madhya Pradesh', '466466', 0, 'India', 'Indore vijay nagar', '2025-09-17 05:29:10', '2025-09-17 05:29:10'),
(18, 28, 'Magni repellendus S', 'Voluptatem labore f', '585474', 0, 'India', 'Voluptatem voluptate', '2025-09-17 05:52:34', '2025-09-17 05:52:34');

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
(1, 'Diamonds', 'video', 'banners/SgkLnvxIoWEPoKbGXueg1WSQGb684J21o0a1QM8V.mp4', '2025-07-16 07:31:36', '2025-08-15 03:39:27', 0),
(4, 'Rings', 'image', 'banners/sxcTpd6yTBBibYU5nSaqzshfdiA1qhNCDdX23YDK.jpg', '2025-07-16 10:37:56', '2025-08-15 03:39:27', 0),
(5, 'Rings', 'video', 'banners/WPb69z73lZSnrquK53vyeXbrS9qARfpMANigzzqu.mp4', '2025-07-16 10:39:56', '2025-08-15 03:39:27', 0),
(6, 'Gold Rings', 'video', 'banners/Cf3EWnAyBANkgZtAwB7Sxj2O6J3eOf2YWAjsTtq5.mp4', '2025-07-16 10:40:51', '2025-08-15 03:39:27', 0),
(7, 'Ring', 'image', 'banners/gSLP2d9w4l58jlYz8b0kc8lCbqsmQkE376XhBdSU.jpg', '2025-07-16 10:42:26', '2025-08-15 03:39:27', 0),
(8, 'ring', 'image', 'banners/a6hpKaWfrPAnl7uzj1kcZz3Iw7c60xRJNOQmrY4F.jpg', '2025-07-26 19:24:46', '2025-08-15 03:39:27', 0),
(9, 'new5', 'image', 'banners/QVabcD4ojKAL3AwLbFr7zGZiO0NH0cqQb38fEgg6.png', '2025-07-27 16:06:20', '2025-08-15 03:39:27', 0),
(10, 'Vedaro', 'image', 'banners/mWGKq7Tv9UUntWRYpMEAwC8TcFaPp5oppbw5Rtfw.jpg', '2025-07-30 07:10:30', '2025-08-15 03:39:27', 1),
(11, 'independence day', 'image', 'banners/OR2xxJFxtlZFSRJwzBx0D9aQyt1tjphGSG9h0etW.png', '2025-08-15 03:36:59', '2025-08-15 03:39:27', 0);

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(2, 'E-design', NULL, '2025-11-02 16:29:43', '2025-11-02 16:29:43');

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
  `size` varchar(255) DEFAULT NULL,
  `weight` decimal(8,2) DEFAULT NULL,
  `total` decimal(20,2) DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `reminder_sent` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `product_id`, `product_qty`, `size`, `weight`, `total`, `customer_id`, `created_at`, `updated_at`, `reminder_sent`) VALUES
(29, 18, 1, 'Free Size', 6.00, 15817.00, 28, '2025-11-05 06:17:23', '2025-11-05 06:21:35', 0),
(32, 4, 1, 'Free Size', 26.03, 15817.00, 28, '2025-11-05 06:21:02', '2025-11-05 06:21:35', 0),
(33, 5, 1, 'Free Size', 26.03, 15817.00, 28, '2025-11-05 06:21:04', '2025-11-05 06:21:35', 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `icon` longtext DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `showOnHome` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `image`, `icon`, `banner_image`, `active`, `showOnHome`, `created_at`, `updated_at`) VALUES
(22, 'rings', 'Handcrafted silver rings that capture elegance in every curve — made to celebrate you, every day', 'categories/F7XAKfBCHkT4r7FWg6hMu5biE12cJhpekSoL83ge.webp', '<svg width=\"13\" height=\"15\" viewBox=\"0 0 13 15\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\n<path d=\"M6.50065 6.08975L3.66732 2.12308L4.80065 0.42308H8.20065L9.33398 2.12308L6.50065 6.08975ZM8.97982 3.82308L8.12982 5.02725C9.68815 5.66475 10.7507 7.15225 10.7507 8.92308C10.7507 10.0503 10.3029 11.1313 9.50586 11.9283C8.70883 12.7253 7.62782 13.1731 6.50065 13.1731C5.37348 13.1731 4.29248 12.7253 3.49545 11.9283C2.69842 11.1313 2.25065 10.0503 2.25065 8.92308C2.25065 7.15225 3.31315 5.66475 4.87148 5.02725L4.02148 3.82308C2.10898 4.74391 0.833984 6.65641 0.833984 8.92308C0.833984 10.426 1.43101 11.8673 2.49371 12.93C3.55642 13.9927 4.99776 14.5897 6.50065 14.5897C8.00354 14.5897 9.44488 13.9927 10.5076 12.93C11.5703 11.8673 12.1673 10.426 12.1673 8.92308C12.1673 6.65641 10.8923 4.74391 8.97982 3.82308Z\" fill=\"#F2ECDD\" fill-opacity=\"0.5\"/>\n</svg>', 'categories/0T1CEnUUWEFpefVUXNmwYsA7l1w2IJhFUxS9BNl0.png', 1, 1, '2025-07-28 18:24:42', '2025-10-09 12:52:28'),
(23, 'mangalsutra', 'A modern expression of sacred tradition — handcrafted silver mangalsutras that blend elegance, purity, and meaning', 'categories/RgLHmevfFXJpRicCZeqHiSoZ7hPh5GN95x8f1hqI.webp', '<svg width=\"20\" height=\"20\" viewBox=\"0 0 20 20\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\r\n<path d=\"M16.569 0.964691C14.9556 0.0564984 11.6178 2.19583 10.39 3.06638C7.25323 5.29028 4.01026 8.56368 1.93959 11.8112C1.20638 12.9606 -0.551421 15.963 0.601876 17.3528C0.99901 17.8312 2.14116 18.9878 2.62064 19.3545C3.91676 20.3463 6.58868 18.8738 7.67755 18.2119C8.47103 17.7296 9.2199 17.1809 9.96144 16.6259C10.7097 16.8974 11.5297 16.9274 11.8634 16.1324C12.5612 14.4727 9.32742 11.619 8.05658 13.0145C7.70356 13.4019 7.90193 13.9181 7.78616 14.0967C7.65799 14.2935 6.96603 14.7519 6.73089 14.9213C5.79121 15.5969 4.65053 16.3018 3.56768 16.7359C3.44464 16.7853 3.19918 16.8874 3.08299 16.9094C3.03586 16.9183 2.96673 16.9746 2.95814 16.8703C2.95453 16.8288 3.21496 16.2287 3.25911 16.1257C5.10455 11.8421 10.7403 6.24372 14.8697 4.12942C15.2583 3.93118 15.7338 3.70694 16.15 3.57145C16.2414 3.54188 16.3442 3.44505 16.412 3.56075C16.0783 4.43427 15.6693 5.27032 15.1845 6.0623C14.8018 6.6864 14.2404 7.5904 13.7625 8.1193C13.6452 8.24844 13.4176 8.09033 13.2387 8.06405C12.6917 7.9848 12.2221 8.11476 11.9632 8.60341C11.1191 10.1954 14.5623 13.4679 15.9474 12.1868C16.4179 11.7516 16.2544 11.0779 16.1019 10.5011C16.6428 9.74628 17.1978 9.00379 17.6814 8.20801C18.3614 7.08933 19.8577 4.3916 18.7683 3.07824C18.4281 2.66853 16.9663 1.18867 16.569 0.964691ZM8.66189 13.6018C9.05246 13.0434 10.286 14.0114 10.607 14.3902C11.4894 15.4307 11.2879 16.6206 9.86118 15.6995C9.36724 15.3807 8.24964 14.1927 8.66189 13.6018ZM15.4424 11.1066C15.6434 12.2602 14.1007 11.3432 13.6767 10.9652C13.3074 10.6366 12.3734 9.46235 12.6924 8.98232C12.9921 8.53347 14.1231 9.27716 14.4274 9.54804C14.8182 9.89637 15.3534 10.595 15.4424 11.1066ZM5.94859 16.427C6.65759 15.9938 7.31773 15.4151 8.00276 15.0049C8.03488 14.9856 8.10921 14.9299 8.14382 14.9591C8.40637 15.413 8.75121 15.8554 9.19264 16.1442C8.06994 17.0097 6.82617 17.8589 5.50404 18.4194C5.07657 18.6005 3.49354 19.1637 3.08866 18.7588L2.26221 17.9324C3.60711 17.7261 4.82088 17.1159 5.94859 16.427ZM15.6627 2.88095C13.1812 3.83418 10.9435 5.65963 9.02274 7.42728C6.4815 9.76633 3.62081 12.9028 2.35049 16.1932C2.29999 16.3241 2.08059 17.0961 2.03831 17.1198C1.8481 17.2275 1.30197 17.0218 1.15784 16.8136C0.678565 16.1248 1.47299 14.3685 1.78825 13.7411C2.79619 11.7369 4.28913 9.87098 5.80365 8.24063C7.81058 6.08058 10.4321 3.74865 13.0722 2.38348C13.7168 2.05013 15.5721 1.19399 16.2831 1.6883C16.4918 1.83293 16.7225 2.44641 16.5675 2.59937C16.5346 2.63233 15.8066 2.82535 15.6627 2.88095ZM18.2284 3.61912C18.6058 4.14467 18.1043 5.52663 17.8889 6.0345C17.3271 7.35799 16.4845 8.60109 15.6138 9.72404C15.2877 9.30222 14.916 8.91424 14.4666 8.62649C14.4066 8.54215 14.7743 8.15775 14.8477 8.05499C15.9633 6.49172 17.0726 4.75229 17.4019 2.79267C17.6223 3.06993 18.0312 3.34518 18.2284 3.61912Z\" fill=\"#F2ECDD\" fill-opacity=\"0.5\"/>\r\n</svg>', NULL, 1, 1, '2025-07-28 18:25:43', '2025-10-09 12:54:13'),
(24, 'bracelets', 'Elegant silver bracelets, handcrafted to wrap your wrist in grace, strength, and timeless charm', 'categories/dZO2WMUHd6IlK9B1jqCAbnIFpRkpoatJdzkS1nQi.webp', '<svg width=\"20\" height=\"20\" viewBox=\"0 0 20 20\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\r\n<path d=\"M16.569 0.964691C14.9556 0.0564984 11.6178 2.19583 10.39 3.06638C7.25323 5.29028 4.01026 8.56368 1.93959 11.8112C1.20638 12.9606 -0.551421 15.963 0.601876 17.3528C0.99901 17.8312 2.14116 18.9878 2.62064 19.3545C3.91676 20.3463 6.58868 18.8738 7.67755 18.2119C8.47103 17.7296 9.2199 17.1809 9.96144 16.6259C10.7097 16.8974 11.5297 16.9274 11.8634 16.1324C12.5612 14.4727 9.32742 11.619 8.05658 13.0145C7.70356 13.4019 7.90193 13.9181 7.78616 14.0967C7.65799 14.2935 6.96603 14.7519 6.73089 14.9213C5.79121 15.5969 4.65053 16.3018 3.56768 16.7359C3.44464 16.7853 3.19918 16.8874 3.08299 16.9094C3.03586 16.9183 2.96673 16.9746 2.95814 16.8703C2.95453 16.8288 3.21496 16.2287 3.25911 16.1257C5.10455 11.8421 10.7403 6.24372 14.8697 4.12942C15.2583 3.93118 15.7338 3.70694 16.15 3.57145C16.2414 3.54188 16.3442 3.44505 16.412 3.56075C16.0783 4.43427 15.6693 5.27032 15.1845 6.0623C14.8018 6.6864 14.2404 7.5904 13.7625 8.1193C13.6452 8.24844 13.4176 8.09033 13.2387 8.06405C12.6917 7.9848 12.2221 8.11476 11.9632 8.60341C11.1191 10.1954 14.5623 13.4679 15.9474 12.1868C16.4179 11.7516 16.2544 11.0779 16.1019 10.5011C16.6428 9.74628 17.1978 9.00379 17.6814 8.20801C18.3614 7.08933 19.8577 4.3916 18.7683 3.07824C18.4281 2.66853 16.9663 1.18867 16.569 0.964691ZM8.66189 13.6018C9.05246 13.0434 10.286 14.0114 10.607 14.3902C11.4894 15.4307 11.2879 16.6206 9.86118 15.6995C9.36724 15.3807 8.24964 14.1927 8.66189 13.6018ZM15.4424 11.1066C15.6434 12.2602 14.1007 11.3432 13.6767 10.9652C13.3074 10.6366 12.3734 9.46235 12.6924 8.98232C12.9921 8.53347 14.1231 9.27716 14.4274 9.54804C14.8182 9.89637 15.3534 10.595 15.4424 11.1066ZM5.94859 16.427C6.65759 15.9938 7.31773 15.4151 8.00276 15.0049C8.03488 14.9856 8.10921 14.9299 8.14382 14.9591C8.40637 15.413 8.75121 15.8554 9.19264 16.1442C8.06994 17.0097 6.82617 17.8589 5.50404 18.4194C5.07657 18.6005 3.49354 19.1637 3.08866 18.7588L2.26221 17.9324C3.60711 17.7261 4.82088 17.1159 5.94859 16.427ZM15.6627 2.88095C13.1812 3.83418 10.9435 5.65963 9.02274 7.42728C6.4815 9.76633 3.62081 12.9028 2.35049 16.1932C2.29999 16.3241 2.08059 17.0961 2.03831 17.1198C1.8481 17.2275 1.30197 17.0218 1.15784 16.8136C0.678565 16.1248 1.47299 14.3685 1.78825 13.7411C2.79619 11.7369 4.28913 9.87098 5.80365 8.24063C7.81058 6.08058 10.4321 3.74865 13.0722 2.38348C13.7168 2.05013 15.5721 1.19399 16.2831 1.6883C16.4918 1.83293 16.7225 2.44641 16.5675 2.59937C16.5346 2.63233 15.8066 2.82535 15.6627 2.88095ZM18.2284 3.61912C18.6058 4.14467 18.1043 5.52663 17.8889 6.0345C17.3271 7.35799 16.4845 8.60109 15.6138 9.72404C15.2877 9.30222 14.916 8.91424 14.4666 8.62649C14.4066 8.54215 14.7743 8.15775 14.8477 8.05499C15.9633 6.49172 17.0726 4.75229 17.4019 2.79267C17.6223 3.06993 18.0312 3.34518 18.2284 3.61912Z\" fill=\"#F2ECDD\" fill-opacity=\"0.5\"/>\r\n</svg>', NULL, 1, 1, '2025-07-28 18:26:33', '2025-10-09 12:56:28'),
(25, 'pendants', 'Timeless pendants, handcrafted in pure silver — each piece tells a story of grace, strength, and subtle luxury', 'categories/CY4YGnIcJltBm7ex3sbcPodOIvqMhk4KvhfImcMa.webp', '<svg width=\"15\" height=\"16\" viewBox=\"0 0 15 16\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\r\n<path d=\"M0.16726 0.596253C0.0850724 0.918034 0.168729 1.275 0.418635 1.525C0.732229 1.83857 1.21426 1.8905 1.58395 1.68125C1.76174 1.84218 1.94257 1.99971 2.12635 2.15375C2.11556 2.21143 2.1101 2.26998 2.11004 2.32866C2.11004 2.86066 2.54779 3.29741 3.07973 3.29741C3.23339 3.29741 3.37898 3.26085 3.50848 3.19616C3.68876 3.3185 3.87088 3.4381 4.05479 3.55491C4.03965 3.62299 4.03198 3.69251 4.03192 3.76225C4.03192 4.29425 4.46967 4.731 5.0016 4.731C5.23838 4.731 5.45629 4.64438 5.62548 4.50147L6.05901 4.75538C6.05052 4.80421 6.04619 4.85368 6.04607 4.90325V6.119L2.82513 7.9836V12.9856L7.14651 15.4873L11.4679 12.9856V7.9836L8.21638 6.10132V4.90328C8.21638 4.87257 8.21429 4.84247 8.21101 4.81275C8.37954 4.71681 8.54398 4.62275 8.70154 4.53169C8.86485 4.65644 9.06829 4.73097 9.28785 4.73097C9.81982 4.73097 10.2566 4.29422 10.2566 3.76222C10.2566 3.70388 10.2511 3.64675 10.241 3.5911C10.4305 3.46629 10.6178 3.33816 10.8029 3.20678C10.9269 3.26475 11.0647 3.29741 11.2097 3.29741C11.7417 3.29741 12.1794 2.86066 12.1794 2.32866C12.1794 2.26804 12.1736 2.20756 12.1621 2.14803C12.3338 2.00301 12.5038 1.85596 12.6721 1.70691C13.0346 1.88547 13.4888 1.82497 13.7888 1.52497C14.0388 1.27503 14.1224 0.918097 14.0402 0.596222H13.4023C13.5279 0.748972 13.5191 0.968597 13.3758 1.11185C13.223 1.2646 12.9836 1.26466 12.8309 1.11185C12.6876 0.968566 12.6788 0.748909 12.8043 0.596222H12.1664C12.1065 0.830597 12.1351 1.08347 12.2514 1.30022C12.127 1.41003 12.0016 1.51872 11.8753 1.62628C11.7011 1.46103 11.4664 1.35894 11.2098 1.35894C10.6778 1.35894 10.2401 1.79675 10.2401 2.32869C10.2401 2.499 10.285 2.65941 10.3634 2.799C10.2313 2.89106 10.098 2.98141 9.96354 3.07003C9.78854 2.89878 9.54979 2.79253 9.28792 2.79253C8.75589 2.79253 8.31817 3.23035 8.31817 3.76228C8.31817 3.86122 8.33329 3.95682 8.36139 4.04697C8.2292 4.12338 8.08814 4.2041 7.94742 4.28463C7.91579 4.25382 7.88188 4.22545 7.84598 4.19975C7.63685 4.05075 7.38598 3.98469 7.13617 3.98057C6.88629 3.97644 6.63148 4.03425 6.41835 4.18382C6.39292 4.20167 6.36854 4.22098 6.34532 4.24163C6.20885 4.16122 6.07145 4.08025 5.94073 4.00344C5.96079 3.92625 5.97148 3.84544 5.97148 3.76232C5.97148 3.23032 5.53376 2.79257 5.00179 2.79257C4.75251 2.79257 4.52398 2.88866 4.35142 3.0455C4.2124 2.95754 4.07439 2.86799 3.93742 2.77688C4.01048 2.63881 4.04867 2.48496 4.04867 2.32875C4.04867 1.79672 3.61189 1.35897 3.07992 1.35897C2.82179 1.35897 2.58604 1.46222 2.41154 1.62903C2.26594 1.50559 2.12228 1.37988 1.9806 1.25194C2.07632 1.04647 2.0967 0.813503 2.04123 0.596316H1.4032C1.52876 0.749034 1.51995 0.968659 1.37664 1.11194C1.22392 1.26466 0.984447 1.26469 0.831729 1.11194C0.688479 0.968628 0.679697 0.748972 0.805229 0.596316H0.16726V0.596253ZM3.07976 1.94294C3.29613 1.94294 3.46454 2.11232 3.46454 2.32866C3.46454 2.545 3.2962 2.71341 3.07985 2.71341C2.86342 2.71341 2.69407 2.54497 2.69407 2.32863C2.69407 2.11228 2.86345 1.94291 3.07982 1.94291L3.07976 1.94294ZM11.2097 1.94294C11.426 1.94294 11.5954 2.11232 11.5954 2.32866C11.5954 2.545 11.426 2.71341 11.2096 2.71341C10.9933 2.71341 10.8239 2.54497 10.8239 2.32863C10.8239 2.11228 10.9933 1.94291 11.2097 1.94291V1.94294ZM5.0017 3.3765C5.21801 3.3765 5.38742 3.54588 5.38742 3.76225C5.38742 3.97863 5.21804 4.147 5.00167 4.147C4.78523 4.147 4.61588 3.97857 4.61588 3.76222C4.61588 3.54588 4.78526 3.3765 5.00164 3.3765H5.0017ZM9.28779 3.3765C9.50417 3.3765 9.67257 3.54588 9.67257 3.76225C9.67257 3.97863 9.50414 4.147 9.28779 4.147C9.07145 4.147 8.90204 3.97857 8.90204 3.76222C8.90204 3.54588 9.07142 3.3765 9.28782 3.3765H9.28779ZM7.12642 4.56441C7.27314 4.56685 7.41876 4.61241 7.50704 4.67535C7.59535 4.73822 7.63235 4.79425 7.63235 4.90322V5.76322L7.14654 5.48197L6.6301 5.78088V4.90328C6.6301 4.77547 6.66942 4.72094 6.75363 4.66188C6.83788 4.60282 6.97979 4.56203 7.12645 4.56444L7.12642 4.56441ZM6.8726 6.31535V7.3381L4.55442 8.68841L3.66198 8.17397L6.8726 6.31535ZM7.45657 6.33628L10.6491 8.18435L9.75457 8.70004L7.45667 7.3616L7.45657 6.33628ZM7.14445 7.85566L9.40245 9.17082L9.40238 11.8057L7.14448 13.1209L4.88648 11.8057L4.88657 9.17088L7.14451 7.85563L7.14445 7.85566ZM7.15898 8.42847L5.38138 11.4957V11.5183L7.14907 12.5488L8.9167 11.5183V9.45313L7.15898 8.42847ZM3.40917 8.70235L4.30248 9.21735V11.8432L3.40917 12.3582V8.70241V8.70235ZM10.8839 8.72322L10.8838 12.3372L9.98642 11.8199V9.24057L10.8839 8.72322ZM9.6821 12.3186L10.57 12.8305L7.4566 14.6329V13.6149L9.6821 12.3186ZM4.62679 12.3303L6.87254 13.6384V14.6539L3.74098 12.841L4.62676 12.3303L4.62679 12.3303Z\" fill=\"#F2ECDD\" fill-opacity=\"0.5\"/>\r\n</svg>', 'categories/y6WG4neXqvHU94tKWssbB2prEJt5L3EqCLFHQyYY.png', 1, 1, '2025-07-28 18:27:26', '2025-10-09 12:58:55'),
(26, 'necklaces', 'Statement necklaces in pure silver — where craftsmanship meets quiet luxury, made to be worn close to the heart', 'categories/A6KOxjoFli5KIomHoV7QRPpRZEBe0hwRgfEF32N5.webp', '<svg width=\"16\" height=\"16\" viewBox=\"0 0 16 16\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\r\n<path d=\"M14.9821 0.962036L15.5384 1.05079C15.5384 1.05079 15.1352 3.57204 14.2634 6.40954C14.4321 6.55329 14.5415 6.76891 14.5415 7.00641C14.5415 7.41891 14.2134 7.76266 13.8071 7.78766C13.2446 9.36266 12.5384 10.9314 11.6571 12.1408C11.3727 12.5314 11.0696 12.8845 10.7446 13.1908C10.6227 13.0439 10.4665 12.922 10.2915 12.8408C10.6102 12.5564 10.9134 12.2095 11.204 11.8095C12.029 10.6783 12.7196 9.15641 13.2696 7.61266C13.0915 7.46891 12.979 7.25016 12.979 7.00641C12.979 6.58766 13.3165 6.24391 13.729 6.22516C14.5852 3.44391 14.9821 0.962036 14.9821 0.962036ZM1.53867 0.962036C1.53867 0.962036 1.93867 3.44391 2.7918 6.22516C3.2043 6.24079 3.54148 6.58766 3.54148 7.00641C3.54148 7.25016 3.42586 7.46891 3.25117 7.61266C3.80086 9.15641 4.49148 10.6783 5.31648 11.8095C5.60711 12.2095 5.91023 12.5564 6.22898 12.8408C6.05398 12.922 5.89773 13.0439 5.77586 13.1908C5.45086 12.8845 5.14773 12.5314 4.86336 12.1408C3.98211 10.9314 3.2793 9.36266 2.71367 7.78766C2.30742 7.76266 1.9793 7.41891 1.9793 7.00641C1.9793 6.76891 2.08867 6.55329 2.25742 6.40954C1.38555 3.57204 0.982422 1.05079 0.982422 1.05079L1.53867 0.962036ZM12.9821 1.96016L13.5384 2.05266C13.5384 2.05266 13.2915 3.55016 12.5415 5.07516V6.50641H11.979V6.05329C11.679 6.50016 11.329 6.92516 10.9134 7.28141C10.7946 7.38141 10.6696 7.47829 10.5415 7.56891V9.00641H9.97898V7.89704C9.54774 8.10641 9.06648 8.24079 8.54148 8.27829V9.50641H7.97898V8.27829C7.45398 8.24079 6.97273 8.10641 6.54148 7.89704V9.00641H5.97898V7.56891C5.85086 7.47829 5.72586 7.38141 5.60711 7.28141C5.19148 6.92516 4.84148 6.50016 4.54148 6.05329V6.50641H3.97898V5.07516C3.2293 3.55016 2.98242 2.05266 2.98242 2.05266L3.53836 1.96016C3.53836 1.96016 3.78523 3.42516 4.51336 4.88141C4.87586 5.60954 5.35711 6.32829 5.97586 6.85641C6.59148 7.38454 7.32898 7.72516 8.26023 7.72516C9.19148 7.72516 9.92898 7.38454 10.5446 6.85641C11.1634 6.32829 11.6446 5.60954 12.0071 4.88141C12.7352 3.42516 12.9821 1.96016 12.9821 1.96016ZM9.76023 13.2877C10.1602 13.2877 10.479 13.6064 10.479 14.0064C10.479 14.4064 10.1602 14.7252 9.76023 14.7252C9.67898 14.7252 9.60086 14.7127 9.52898 14.6877C9.53523 14.6283 9.54148 14.5689 9.54148 14.5064C9.54148 14.1533 9.39773 13.8345 9.16336 13.6033C9.29148 13.4127 9.51023 13.2877 9.76023 13.2877ZM6.76023 13.2877C7.01023 13.2877 7.22898 13.4127 7.35711 13.6033C7.12273 13.8345 6.97898 14.1533 6.97898 14.5064C6.97898 14.5689 6.98523 14.6283 6.99148 14.6877C6.91961 14.7127 6.84148 14.7252 6.76023 14.7252C6.36023 14.7252 6.04148 14.4064 6.04148 14.0064C6.04148 13.6064 6.36023 13.2877 6.76023 13.2877ZM8.26023 13.7877C8.66023 13.7877 8.97898 14.1064 8.97898 14.5064C8.97898 14.9064 8.66023 15.2252 8.26023 15.2252C7.86023 15.2252 7.54148 14.9064 7.54148 14.5064C7.54148 14.1064 7.86023 13.7877 8.26023 13.7877Z\" fill=\"#F2ECDD\" fill-opacity=\"0.5\"/>\r\n</svg>', 'categories/8a4TioTfhIEbQhHehXh0UimipzwCrRocT2dSgUyP.png', 1, 1, '2025-07-28 18:31:34', '2025-10-09 13:00:59'),
(28, 'Earings', 'Get that perfect pair of Earring Designs that you\'re looking', 'categories/c4JHubxwjBAPnjvwr7sFkjBEBK2DIXLvR6w9GWjq.webp', '<svg width=\"17\" height=\"16\" viewBox=\"0 0 17 16\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\r\n<path d=\"M2.92578 9.34373C5.32578 9.34373 4.52578 12.0104 6.92578 12.0104M9.59245 9.34373C11.9924 9.34373 11.1924 12.0104 13.5924 12.0104\" stroke=\"#F2ECDD\" stroke-opacity=\"0.5\"/>\r\n<path d=\"M4.92578 14.0064C6.03045 14.0064 6.92578 12.3651 6.92578 10.3411C6.92578 8.31707 6.03045 6.67574 4.92578 6.67574C3.82111 6.67574 2.92578 8.3164 2.92578 10.3411C2.92578 12.3651 3.82111 14.0064 4.92578 14.0064ZM11.5924 14.0064C12.6971 14.0064 13.5924 12.3651 13.5924 10.3411C13.5924 8.31707 12.6971 6.67574 11.5924 6.67574C10.4878 6.67574 9.59245 8.3164 9.59245 10.3411C9.59245 12.3651 10.4878 14.0064 11.5924 14.0064Z\" stroke=\"#F2ECDD\" stroke-opacity=\"0.5\" stroke-linecap=\"round\"/>\r\n<path d=\"M6.89561 4.82907C6.66227 4.69507 6.29961 4.48241 6.21427 3.19841C6.13894 2.06041 5.10494 1.94641 4.70961 2.02641C4.33827 2.10174 3.64294 2.49374 3.59761 3.30907C3.56694 3.85574 3.90561 4.37974 4.70761 4.69907C4.84227 4.75241 4.93761 4.87907 4.93761 5.02507V6.51441M13.5503 4.82907C13.3169 4.69507 12.9536 4.48241 12.8689 3.19841C12.7936 2.06041 11.7596 1.94641 11.3643 2.02641C10.9929 2.10174 10.2976 2.49374 10.2523 3.30907C10.2216 3.85574 10.5603 4.37974 11.3623 4.69907C11.4969 4.75241 11.5923 4.87907 11.5923 5.02507V6.51441\" stroke=\"#F2ECDD\" stroke-opacity=\"0.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>\r\n</svg>', NULL, 1, 0, '2025-07-30 05:39:15', '2025-10-09 13:02:05'),
(31, 'Rakhi', NULL, 'categories/W4vHR836oN2yeJmcEcJUd6srt4tUWR3HOplAtr2e.jpg', 'categories/quD1lCkFiVSTYySZPUpEY4p6qXlRyx0vaSlxx1oj.jpg', 'categories/bilUsxIxyzenrnN8ThpTqYLvPuE25O8jaHnFUhdF.jpg', 0, 0, '2025-10-31 14:31:57', '2025-11-01 05:28:12');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `discount_percentage` decimal(5,2) NOT NULL,
  `is_universal` tinyint(1) NOT NULL DEFAULT 0,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`product_ids`)),
  `valid_from` timestamp NULL DEFAULT NULL,
  `valid_to` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `discount_percentage`, `is_universal`, `category_id`, `product_ids`, `valid_from`, `valid_to`, `created_at`, `updated_at`) VALUES
(3, 'COUPON-5UP8DZ', 20.00, 0, NULL, '[\"94\"]', NULL, NULL, '2025-08-07 07:53:38', '2025-08-07 07:53:38'),
(6, 'COUPON-0S7OJ3', 20.00, 0, 22, NULL, NULL, NULL, '2025-08-12 05:55:19', '2025-08-12 05:55:19'),
(7, 'COUPON-Z7KHUQ', 20.00, 0, NULL, '[\"66\"]', NULL, NULL, '2025-08-12 05:56:53', '2025-08-12 05:57:33'),
(9, 'COUPON-GA16QW', 20.00, 1, NULL, NULL, NULL, NULL, '2025-09-17 11:06:36', '2025-09-17 11:06:36'),
(10, 'COUPON-DJ0ZEG', 40.00, 1, NULL, NULL, NULL, NULL, '2025-10-08 08:39:27', '2025-10-08 08:39:27');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `payment_status` enum('pending','paid','failed') NOT NULL DEFAULT 'pending',
  `razorpay_order_id` varchar(255) DEFAULT NULL,
  `razorpay_payment_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `user_id`, `email`, `first_name`, `last_name`, `address`, `city`, `pincode`, `state`, `country`, `phone`, `payment_status`, `razorpay_order_id`, `razorpay_payment_id`, `created_at`, `updated_at`) VALUES
(8, 28, 'bhaisaniyasharad@gmail.com', 'Sharad', 'Verma', 'Bhopal Neelbad', 'Bhopal', '462044', 'Madhya Pradesh', 'India', '9752008368', 'paid', 'order_R4sxLrlNOQDtZ2', 'pay_R4szo72glnq0hR', '2025-08-13 16:30:35', '2025-08-13 16:33:13'),
(9, 28, 'bhaisaniyasharad@gmail.com', 'Marah', 'Collins', 'Maina, teh: Ashta, Dist: Sehore Madhya Pradesh', 'Ashta', '466125', 'Madhya Pradesh', 'India', '9752008368', 'paid', 'order_R58ISgpUYAiXRg', 'pay_R58IdzUxB90dcB', '2025-08-14 07:30:58', '2025-08-14 07:31:28'),
(10, 16, 'bhavyagarodia9@gmail.com', 'bhavya', 'Garodia', 'Near bank', 'Chirawa', '333026', 'Rajasthan', 'India', '8290210109', 'paid', 'order_R58P27vojbUWfu', 'pay_R58P9JC7CF0esY', '2025-08-14 07:37:12', '2025-08-14 07:37:46');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `expense_type` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `expense_date` date NOT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `transaction_number` varchar(255) DEFAULT NULL,
  `bill_image` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `expense_type`, `description`, `amount`, `expense_date`, `payment_type`, `transaction_number`, `bill_image`, `note`, `created_at`, `updated_at`) VALUES
(1, 'Courier / Shipping', 'new', 2000.00, '2025-11-12', 'UPI', '64489846465448', 'uploads/expenses/FlKy5CMJQ1tgcE0TR2CQuTObQpAJawGu5lWiTMZB.pdf', NULL, '2025-11-12 08:40:31', '2025-11-12 08:40:31');

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
  `product_image1` varchar(255) NOT NULL,
  `product_image2` varchar(255) DEFAULT NULL,
  `product_image3` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `valid_from` datetime DEFAULT NULL,
  `valid_to` datetime DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `minimum_cart_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gift_products`
--

INSERT INTO `gift_products` (`id`, `product_name`, `price`, `size`, `weight`, `product_description1`, `product_description2`, `product_image1`, `product_image2`, `product_image3`, `is_active`, `valid_from`, `valid_to`, `stock_quantity`, `minimum_cart_amount`, `created_at`, `updated_at`) VALUES
(1, 'Test Gift', 200.00, '15', '600', 'df sf sdfo fo', 'dfh h fsf ihf', 'products/gmYLakPw0929wzRIHikV5bfYr9dymRDYA6tNDQVg.jpg', 'products/ZPngVcQ0wO3LGcKeb5Qqb842oVDg2yzauzphxhTO.jpg', 'products/yaXSDen94ZlivZhqRzImr6SnntoRcdQxdS5hBfLs.jpg', 1, NULL, NULL, 0, 0.00, '2025-08-07 05:59:14', '2025-10-30 07:27:59'),
(2, 'Bert England', 854.00, '12', '600', 'Sed nisi possimus c', 'Non quis suscipit do', 'products/Z66hqntRTkMlcY3F9hAyC4yY4ewoOjFVp0mLYIeu.jpg', 'products/lLnQW04dAdLJVtfEbOMh9ww6bPMVhv5pZXlNapFp.jpg', 'products/8duXB21O3ebI1EHiKR98Vb4jGOBylhBnIBRGeG8y.jpg', 0, NULL, NULL, 0, 11.00, '2025-08-07 06:11:29', '2025-10-30 07:27:59'),
(3, 'Bracelate', 200.00, '22', '222', 'dsgdgxcnvbn', 'gfh fghdfghgf', 'products/LSpqIYG3hdgwvBM5fL2OvqlSO7qYXbMRoFfB4XSq.jpg', 'products/QOcxeaZVNmsPvoVAKJm8MepOx6dnha7Fd5EI3Pge.jpg', NULL, 0, NULL, NULL, 0, 223.00, '2025-08-07 13:02:52', '2025-10-30 07:27:59');

-- --------------------------------------------------------

--
-- Table structure for table `hsn_codes`
--

CREATE TABLE `hsn_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hsn_codes`
--

INSERT INTO `hsn_codes` (`id`, `code`, `description`, `created_at`, `updated_at`) VALUES
(2, '7113', 'Jewellery', '2025-11-02 16:29:18', '2025-11-02 16:29:18');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `offline_online` enum('offline','online') NOT NULL DEFAULT 'online',
  `customer_name` varchar(255) NOT NULL,
  `customer_address` text DEFAULT NULL,
  `customer_gstin` varchar(255) DEFAULT NULL,
  `admin_gstin` varchar(255) DEFAULT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `order_number` varchar(255) DEFAULT NULL,
  `invoice_date` date NOT NULL,
  `paid_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `due_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `rate` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(5,2) NOT NULL DEFAULT 0.00,
  `taxes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`taxes`)),
  `eligible_for_itc` tinyint(1) NOT NULL DEFAULT 0,
  `amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(9, 'Bracelet', NULL, 'products/QCJCgzqnPHsBXjTW2hD9dURzrMUQvexyY8glvF6J.jpg', '', '2025-07-19 07:02:09', '2025-08-05 06:00:03'),
(10, 'Pendent', NULL, 'products/vQVvoBXnnneSuWLyfujV73DYeq0G12xmprOeNAfZ.jpg', '', '2025-07-19 07:02:46', '2025-08-08 07:11:56'),
(11, 'mangalsutra', NULL, 'products/PhzSGV2ukuzKvV51MHmokqmB4WmkanQvyvySLt5p.jpg', '', '2025-07-19 07:03:10', '2025-08-13 13:20:44');

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
(37, '2025_07_22_112137_create_user_inquiries_table', 15),
(40, '2025_07_25_082545_add_multiple_weights_to_products_table', 16),
(41, '2025_07_26_062217_add_multiple_sizes_to_products_table', 17),
(42, '2025_07_29_061453_add_channel_order_id_to_shiprocket_orders_table', 18),
(43, '2025_07_31_055727_update_products_table_add_size_stocks', 19),
(44, '2025_07_31_101802_add_size_and_weight_to_order_items_table', 19),
(45, '2025_08_05_075754_add_reminder_sent_to_carts_table', 20),
(46, '2025_08_07_054625_create_gift_products_table', 21),
(47, '2025_08_07_062220_create_coupons_table', 22),
(48, '2025_08_12_090757_add_show_on_home_to_categories_table', 23),
(49, '2025_08_13_062246_add_size_and_weight_to_carts_table', 24),
(50, '2025_08_13_095157_create_events_table', 25),
(51, '2025_08_13_102603_create_events_table', 26),
(52, '2025_08_13_105755_create_events_table', 27),
(53, '2025_08_13_115852_add_razorpay_columns_to_events_table', 28),
(54, '2025_09_05_094905_update_products_table_with_billing_brand_rfid', 29),
(55, '2025_09_05_095225_create_taxes_table', 30),
(56, '2025_09_05_095256_create_tax_groups_table', 30),
(57, '2025_09_05_095526_create_vendors_table', 31),
(58, '2025_09_05_095547_create_purchases_table', 31),
(59, '2025_09_05_095627_create_purchase_items_table', 31),
(60, '2025_09_05_100054_create_offline_customers_table', 32),
(61, '2025_09_05_100123_create_invoices_table', 32),
(62, '2025_09_16_131841_add_icon_and_banner_to_categories_table', 33),
(64, '2025_09_17_061324_alter_categories_icon_column_to_longtext', 34),
(65, '2025_09_17_123225_create_product_identifiers_table', 35),
(66, '2025_09_19_114442_create_wishlist_items_table', 36),
(67, '2025_09_27_083241_create_product_variants_table', 37),
(68, '2025_09_27_083357_add_product_type_to_products_table', 37),
(69, '2025_10_08_052311_create_performa_invoices_tables', 38),
(70, '2025_11_01_185603_hsn_codes_table', 39),
(71, '2025_11_01_185620_brands_table', 39),
(72, '2025_11_03_082136_create_purchase_product_names_table', 40),
(73, '2025_11_11_093407_create_expenses_table', 41);

-- --------------------------------------------------------

--
-- Table structure for table `offline_customers`
--

CREATE TABLE `offline_customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offline_customers`
--

INSERT INTO `offline_customers` (`id`, `user_id`, `name`, `email`, `phone`, `address`, `city`, `pincode`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Dolor Morkal', 'bhaisaniyasharad@gmail.com', '9752008368', 'Maina, teh: Ashta, Dist: Sehore Madhya Pradesh', 'Ashta', '466125', '2025-09-05 11:11:33', '2025-09-19 07:05:49'),
(2, NULL, 'Sharad', 'asd@gmail.com', '09752008393', 'Maina, teh: Ashta, Dist: Sehore Madhya Pradesh', 'Ashta', '466125', '2025-10-08 06:12:00', '2025-10-10 06:56:46');

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
  `size` varchar(255) DEFAULT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('bhaisaniyasharad@gmail.com', '$2y$12$KeTd4ZoLe6aew1JC3iEwoeABVXTtsk1CsQwEXo6P.3.ue0a.9Fese', '2025-07-29 12:51:47');

-- --------------------------------------------------------

--
-- Table structure for table `performa_invoices`
--

CREATE TABLE `performa_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `offline_online` enum('offline','online') NOT NULL DEFAULT 'online',
  `customer_name` varchar(255) NOT NULL,
  `customer_address` text DEFAULT NULL,
  `customer_gstin` varchar(255) DEFAULT NULL,
  `admin_gstin` varchar(255) DEFAULT NULL,
  `performa_number` varchar(255) NOT NULL,
  `order_number` varchar(255) DEFAULT NULL,
  `performa_date` date NOT NULL,
  `paid_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `due_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `performa_invoice_items`
--

CREATE TABLE `performa_invoice_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `performa_invoice_id` bigint(20) UNSIGNED NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `rate` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(5,2) NOT NULL DEFAULT 0.00,
  `taxes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`taxes`)),
  `eligible_for_itc` tinyint(1) NOT NULL DEFAULT 0,
  `amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(6, 14, 100, 10, 'bhaisaniyasharad@gmail.com', '9752008368', 'jsdjfj df', '2025-08-04 11:08:53', '2025-08-04 11:08:53');

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
  `multiple_sizes` text DEFAULT NULL,
  `size_stock` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`size_stock`)),
  `weight` varchar(255) NOT NULL,
  `multiple_weights` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`multiple_weights`)),
  `productDescription1` text NOT NULL,
  `productDescription2` text DEFAULT NULL,
  `material` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `variants` text DEFAULT NULL,
  `hsn_code` varchar(255) DEFAULT NULL,
  `tax_rate` decimal(5,2) NOT NULL DEFAULT 0.00,
  `purchase_price` decimal(10,2) DEFAULT NULL,
  `mrp` decimal(10,2) DEFAULT NULL,
  `is_tax_inclusive` tinyint(1) NOT NULL DEFAULT 1,
  `sku` varchar(255) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `product_type` enum('simple','variant') NOT NULL DEFAULT 'simple',
  `rfid` varchar(255) DEFAULT NULL,
  `supplier_name` varchar(255) DEFAULT NULL,
  `cost_price_per_unit` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `discountPercentage` decimal(10,2) NOT NULL,
  `discountPrice` decimal(10,2) DEFAULT NULL,
  `image1` varchar(255) NOT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `current_stock` int(11) NOT NULL,
  `total_stock` int(11) NOT NULL DEFAULT 0,
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

INSERT INTO `products` (`id`, `productName`, `coupon_code`, `category`, `size`, `multiple_sizes`, `size_stock`, `weight`, `multiple_weights`, `productDescription1`, `productDescription2`, `material`, `color`, `variants`, `hsn_code`, `tax_rate`, `purchase_price`, `mrp`, `is_tax_inclusive`, `sku`, `barcode`, `brand`, `product_type`, `rfid`, `supplier_name`, `cost_price_per_unit`, `price`, `discountPercentage`, `discountPrice`, `image1`, `image2`, `image3`, `current_stock`, `total_stock`, `shipping_fee`, `availability`, `on_sell`, `add_timer`, `timer_end_at`, `created_at`, `updated_at`) VALUES
(1, 'BhaiRatna Rakhi', 'DISC-MBEJ7Z', '31', '', NULL, NULL, '2.30', NULL, 'A blend of “Bhai” (brother) and “Ratna” (gem), symbolizing a brother as the most precious jewel in life.\r\nIt reflects purity, love, and timeless bond — perfectly matching the elegant silver design.', NULL, NULL, NULL, NULL, '7113', 1.00, NULL, 728.00, 1, NULL, NULL, 'E-designs', 'simple', '0', NULL, NULL, 728.00, 0.00, 728.00, 'products/1761924383_pwpRatkAtD.jpg', NULL, NULL, 5, 5, 0.00, 1, 1, 0, NULL, '2025-10-31 15:26:23', '2025-10-31 15:26:23'),
(2, 'Omkaar Rakhi', 'DISC-J6PYTX', '31', '', NULL, NULL, '2.00', NULL, 'Crafted in pure silver, the Omkaar Rakhi symbolizes divinity and protection.\r\nThe sacred “Om” at its center blesses your brother with peace, strength, and prosperity.\r\nA perfect blend of simplicity and elegance — a bond that connects souls. ✨', NULL, NULL, NULL, NULL, '7113', 1.00, NULL, 633.00, 1, NULL, NULL, 'E-design', 'simple', '0', NULL, NULL, 633.00, 0.00, 633.00, 'products/1761924383_gvOxUkRhvx.jpg', NULL, NULL, 5, 5, 0.00, 1, 1, 0, NULL, '2025-10-31 15:26:23', '2025-10-31 15:26:23'),
(3, 'Trishakti Rakhi', 'DISC-XP9XQ3', '31', '', NULL, NULL, '1.15', NULL, 'The Trishakti Rakhi, crafted in pure silver, embodies the divine energy of Lord Shiva’s trident.\r\nIt symbolizes strength, protection, and courage — a reminder that your brother is always guarded by Mahadev’s blessings.', NULL, NULL, NULL, NULL, '7113', 1.00, NULL, 364.00, 1, NULL, NULL, 'E-designs', 'simple', '0', NULL, NULL, 364.00, 0.00, 364.00, 'products/1761924383_bEmHIH43pF.jpg', NULL, NULL, 10, 10, 0.00, 1, 1, 0, NULL, '2025-10-31 15:26:23', '2025-10-31 15:26:23'),
(4, 'Ruhara', 'DISC-TS7ST2', '26', '', NULL, NULL, '26.03', NULL, 'A graceful blend of elegance and charm — the Ruhara Set features stunning ruby-red stones framed in delicate silver hearts, creating a timeless design that symbolizes love and radiance.\r\n\r\n✨ Perfect for festive occasions or evening elegance\r\n💎 92.5 Sterling Silver | Ruby Stones | CZ Detailing\r\nBy Vedaro – Purity Meets Perfection.', NULL, NULL, NULL, NULL, '7113', 1.00, NULL, 5962.00, 1, NULL, NULL, 'E-designs', 'simple', '0', NULL, NULL, 5962.00, 0.00, 5962.00, 'products/1761977353_8Y3PnhjWHC.jpg', 'products/1761977353_k9rhlvyBjg.jpg', NULL, 1, 1, 0.00, 1, 1, 0, NULL, '2025-11-01 06:09:13', '2025-11-01 06:09:13'),
(5, 'Neelkamal Set', 'DISC-5XVWJ4', '26', '', NULL, NULL, '26.03', NULL, 'Grace meets grandeur in the Neelkamal Set — an exquisite handcrafted necklace and earring duo in pure 925 silver. Studded with deep blue and radiant white stones, its floral and teardrop motifs bloom with elegance. A perfect blend of timeless tradition and luxury, this piece is crafted to leave a lasting impression at every special occasion.', NULL, NULL, NULL, NULL, '7113', 1.00, NULL, 6899.00, 1, NULL, NULL, 'E-designs', 'simple', '0', NULL, NULL, 6899.00, 0.00, 6899.00, 'products/1761977353_V66oOMGgXY.jpg', 'products/1761977353_UvumYmaIzE.jpg', NULL, 1, 1, 0.00, 1, 1, 0, NULL, '2025-11-01 06:09:13', '2025-11-01 06:09:13'),
(7, 'Veloura Bracelet', 'DISC-JJESDS', '24', '', NULL, NULL, '13', NULL, 'The Veloura Silver Bracelet embodies timeless elegance with its sleek design and sparkling brilliance.\nCrafted in 92.5 pure silver, each precisely set stone enhances its luxurious shimmer — perfect for both daily wear and special occasions. ✨', '💠 Material: 92.5 Sterling Silver\n⚖️ Lightweight & Comfortable Fit\n💫 Style: Modern Minimalist\n💍 Category: Bracelet', NULL, NULL, NULL, '7113', 1.00, NULL, 6560.00, 1, NULL, '', 'E-design', 'simple', NULL, NULL, NULL, 6560.00, 0.00, 6560.00, 'products/1762104325_uGglZUqyIh.jpg', '', '', 1, 1, 0.00, 0, 0, 0, NULL, '2025-11-02 17:25:25', '2025-11-10 04:54:10'),
(8, 'Phoolvara', 'DISC-SLY3Y2', '24', '', NULL, NULL, '7', NULL, 'Where timeless charm blossoms into grace.\nPhoolvara is a handcrafted bracelet in pure 925 silver, adorned with delicate floral motifs and shimmering stones that flow like vines across your wrist. Feminine, ethereal, and full of life — it’s made for those who bloom in their own light.', '', NULL, NULL, NULL, '7113', 1.00, NULL, 5577.00, 1, NULL, '', 'E-design', 'simple', NULL, NULL, NULL, 5577.00, 0.00, 5577.00, 'products/1762447220_WNspgfIkHM.jpg', '', '', 1, 1, 0.00, 0, 0, 0, NULL, '2025-11-02 17:25:25', '2025-11-10 04:54:10'),
(9, 'Azurelia Bracele', 'DISC-VP1JHX', '24', '', NULL, NULL, '4.5', NULL, 'Grace your wrist with the Azurelia Silver Bracelet — a symbol of calm elegance and refined luxury.\nCrafted in 92.5 pure silver, its radiant blue centerpiece is beautifully flanked by sparkling stones, creating a mesmerizing contrast of serenity and shine.', '', NULL, NULL, NULL, '7113', 1.00, NULL, 2813.00, 1, NULL, '', 'E-design', 'simple', NULL, NULL, NULL, 2813.00, 0.00, 2813.00, 'products/1762447033_NvurcWjSfw.jpg', '', '', 3, 3, 0.00, 0, 0, 0, NULL, '2025-11-02 17:25:25', '2025-11-10 04:54:10'),
(10, 'Rosavine Bracelet', 'DISC-60KLGP', '24', '', NULL, NULL, '4.3', NULL, 'Delicate, dreamy, and dazzling — the Rosavine Silver Bracelet is crafted to add a touch of soft romance to your look.\nMade in 92.5 pure silver, it features a blush-pink teardrop stone surrounded by sparkling white zircons that radiate pure sophistication.', '', NULL, NULL, NULL, '7113', 1.00, NULL, 2750.00, 1, NULL, '', 'E-design', 'simple', NULL, NULL, NULL, 2750.00, 0.00, 2750.00, 'products/1762447033_zFK6n1FJEw.jpg', '', '', 3, 3, 0.00, 0, 0, 0, NULL, '2025-11-02 17:25:25', '2025-11-10 04:54:10'),
(11, 'Celestara Bracelet', 'DISC-R66SYO', '24', '', NULL, NULL, '5.2', NULL, 'Elegant and timeless — the Celestara Silver Bracelet shines with a row of marquise-cut zircon stones, gracefully aligned like twinkling stars in the night sky.\nCrafted in 92.5 pure silver, this adjustable bracelet perfectly blends minimalism and sophistication, making it ideal for both everyday wear and special evenings.', '', NULL, NULL, NULL, '7113', 1.00, NULL, 2578.00, 1, NULL, '', 'E-design', 'simple', NULL, NULL, NULL, 2578.00, 0.00, 2578.00, 'products/1762447033_QQqclKoQDu.jpg', '', '', 3, 3, 0.00, 0, 0, 0, NULL, '2025-11-02 17:25:25', '2025-11-10 04:54:10'),
(15, 'Eterna Heart Bracelet 💖', 'DISC-J7VXEL', '24', '', NULL, NULL, '3.2', NULL, 'A timeless symbol of love and grace — the Eterna Heart Silver Bracelet features a sparkling heart-shaped zircon embraced by a halo of tiny brilliance.\nCrafted in 92.5 pure silver, this adjustable bracelet adds a romantic charm to your wrist, making it a perfect gift for someone special or a gentle reminder of self-love.', '💎 Material: 92.5 Sterling Silver\n✨ Stone: Heart-cut White Zircon with halo detailing\n🔗 Design: Adjustable chain with slider clasp\n💫 Style: Romantic • Elegant • Everyday Luxury', NULL, NULL, NULL, '7113', 1.00, NULL, 2551.00, 1, NULL, '', 'E-design', 'simple', NULL, NULL, NULL, 2551.00, 0.00, 2551.00, 'products/1762447033_CtPeCgHgOx.jpg', '', '', 3, 3, 0.00, 0, 0, 0, NULL, '2025-11-03 16:36:53', '2025-11-10 04:54:10'),
(16, 'Blush Drop Bracelet', 'DISC-RW6BIR', '24', '', NULL, NULL, '3.2', NULL, 'A delicate fusion of grace and charm — the Blush Drop Silver Bracelet features a stunning teardrop-shaped pink zircon at its center, surrounded by a halo of brilliant white stones. Crafted in 92.5 sterling silver, this bracelet symbolizes softness and strength in one timeless design.\n\nPerfect for gifting or elevating your everyday elegance, its adjustable chain ensures a flawless fit for every wrist.', '✨ Material: 92.5 Sterling Silver\n💎 Stone: Pink Zircon with Halo Setting\n🔗 Type: Adjustable Bracelet\n🌸 Finish: High Polish Silver', NULL, NULL, NULL, '7113', 1.00, NULL, 2319.00, 1, NULL, '', 'E-design', 'simple', NULL, NULL, NULL, 2319.00, 0.00, 2319.00, 'products/1762187813_ttoiapTNFr.jpg', '', '', 3, 3, 0.00, 0, 0, 0, NULL, '2025-11-03 16:36:53', '2025-11-10 04:54:10'),
(17, 'Aqua Radiance Ring ', 'DISC-IIJ40H', '22', '', NULL, NULL, '', NULL, 'Ethereal and elegant — the Aqua Radiance Silver Ring features a captivating pear-shaped aquamarine stone, surrounded by a double halo of sparkling white zircons. Handcrafted in 92.5 sterling silver, this masterpiece radiates sophistication and calm — symbolizing purity, peace, and timeless beauty.\n\nWhether for a grand evening or a graceful everyday look, this ring adds a touch of luxury to every gesture.', '✨ Material: 92.5 Sterling Silver\n💎 Stone: Aquamarine with Double Zircon Halo\n🌊 Design: Teardrop Radiant Setting\n💫 Finish: Mirror-Polished Silver', NULL, NULL, NULL, '7113', 1.00, NULL, 0.00, 1, NULL, '', 'E-design', 'variant', NULL, NULL, NULL, 0.00, 0.00, 0.00, 'products/1762188327_HiPTI0wjAN.jpg', '', '', 1, 1, 0.00, 0, 0, 0, NULL, '2025-11-03 16:45:27', '2025-11-10 04:54:10'),
(18, 'Maharani bloom', 'DISC-TFSE4D', '22', '', NULL, NULL, '6', NULL, 'Where regality meets delicate charm — the Maharani Bloom Ring is an opulent tribute to timeless queenship. A stunning blush-pink solitaire rests in the center, surrounded by a blooming halo of precision-cut white stones that mirror the elegance of a royal flower in full blossom.', '', NULL, NULL, NULL, '7113', 1.00, NULL, 2956.00, 1, NULL, '', 'E-design', 'simple', NULL, NULL, NULL, 2956.00, 0.00, 2956.00, 'products/1762193844_xbVOXgr7sR.jpg', '', '', 1, 1, 0.00, 0, 0, 0, NULL, '2025-11-03 18:17:24', '2025-11-10 04:54:10'),
(19, 'Eternal Promise Ring', 'DISC-UKRSC6', '22', '', NULL, NULL, '', NULL, 'Graceful and timeless — the Eternal Promise Silver Ring captures the essence of everlasting love. Crafted in pure 92.5 sterling silver, this elegant piece features a shimmering solitaire-style zircon at its heart, embraced by a band of finely set stones that sparkle with every move.\n\nA perfect symbol of commitment, simplicity, and modern charm — ideal for engagements, anniversaries, or everyday elegance.', '', NULL, NULL, NULL, '7113', 1.00, NULL, 0.00, 1, NULL, '', 'E-design', 'variant', NULL, NULL, NULL, 0.00, 0.00, 0.00, 'products/1762193844_proxTXfwhC.jpg', '', '', 2, 2, 0.00, 0, 0, 0, NULL, '2025-11-03 18:17:24', '2025-11-10 04:54:10'),
(20, 'Rose Halo Ring', 'DISC-TNGWTM', '22', '', NULL, NULL, '', NULL, 'Elegance meets romance in the Rosé Halo Ring. This stunning piece features a soft pink cushion-cut stone surrounded by a halo of shimmering crystals, set on a finely polished silver band. Its delicate design and radiant sparkle make it a perfect choice for both everyday grace and special occasions.', '', NULL, NULL, NULL, '7113', 1.00, NULL, 0.00, 1, NULL, '', 'E-design', 'variant', NULL, NULL, NULL, 0.00, 0.00, 0.00, 'products/1762193844_U3qcfyTtTX.jpg', '', '', 3, 3, 0.00, 0, 0, 0, NULL, '2025-11-03 18:17:24', '2025-11-10 04:54:10'),
(21, 'Eternal Radiance Band ', 'DISC-48NTZ1', '22', '', NULL, NULL, '', NULL, 'An exquisite ring that captures timeless grace — the Eternal Radiance Band features a seamless row of baguette-cut crystals set in a sleek silver base. Each stone reflects light with unmatched brilliance, symbolizing endless elegance and strength.', '', NULL, NULL, NULL, '7113', 1.00, NULL, 0.00, 1, NULL, '', 'E-design', 'variant', NULL, NULL, NULL, 0.00, 0.00, 0.00, 'products/1762193844_ZVyzbXKVlb.jpg', '', '', 2, 2, 0.00, 0, 0, 0, NULL, '2025-11-03 18:17:24', '2025-11-10 04:54:10'),
(22, 'Suryansh Ring', 'DISC-YCJTFE', '22', '', NULL, NULL, '', NULL, 'Radiating the warmth of the sun, the Suryansh Ring features a brilliant golden centerpiece surrounded by shimmering baguette-cut crystals. The design represents divine light emerging from purity — a perfect fusion of elegance and strength.', '', NULL, NULL, NULL, '7113', 1.00, NULL, 0.00, 1, NULL, '', 'E-design', 'variant', NULL, NULL, NULL, 0.00, 0.00, 0.00, 'products/1762193844_TVSjtJPNs3.jpg', '', '', 2, 2, 0.00, 0, 0, 0, NULL, '2025-11-03 18:17:24', '2025-11-10 04:54:10'),
(23, 'Luvetta', 'DISC-ZDZGSS', '22', '', NULL, NULL, '', NULL, 'Soft, romantic, and timeless — the Luvette Ring celebrates pure love with its elegant line of radiant baguette stones. Each facet reflects the beauty of togetherness, making it a perfect piece for everyday elegance or special moments of affection.', '', NULL, NULL, NULL, '7113', 1.00, NULL, 0.00, 1, NULL, '', 'E-design', 'variant', NULL, NULL, NULL, 0.00, 0.00, 0.00, 'products/1762193844_QcX1yLXLg8.jpg', '', '', 1, 1, 0.00, 0, 0, 0, NULL, '2025-11-03 18:17:24', '2025-11-10 04:54:10'),
(26, 'Elara Ring', 'DISC-Y9PIZG', '22', '', NULL, NULL, '', NULL, 'The Elara Ring captures celestial elegance with its stunning pear-cut center stone — symbolizing purity, grace, and divine light. Flanked by delicate baguette stones, it reflects harmony and sophistication in every glance. A timeless piece for the one who shines effortlessly.', '', NULL, NULL, NULL, '7113', 1.00, NULL, 0.00, 1, NULL, '', 'E-design', 'variant', NULL, NULL, NULL, 0.00, 0.00, 0.00, 'products/1762197152_HgzDPt9Pwo.jpg', '', '', 2, 2, 0.00, 0, 0, 0, NULL, '2025-11-03 19:12:32', '2025-11-10 04:54:10'),
(27, 'Amora Ring', 'DISC-LNDRUR', '22', '', NULL, NULL, '', NULL, 'The Amora Ring is a symbol of pure affection — a heart within a heart, crafted to capture the essence of eternal love. Encrusted with delicate white stones that shimmer with every heartbeat, it’s a timeless reminder of connection, care, and devotion.', '', NULL, NULL, NULL, '7113', 1.00, NULL, 0.00, 1, NULL, '', 'E-design', 'variant', NULL, NULL, NULL, 0.00, 0.00, 0.00, 'products/1762198184_IsqIXwMBac.jpg', '', '', 2, 2, 0.00, 0, 0, 0, NULL, '2025-11-03 19:15:13', '2025-11-10 04:54:10'),
(28, 'Amora Heart', 'DISC-9SCMPB', '22', '', NULL, NULL, '', NULL, 'The Amora Heart Ring celebrates pure, uncomplicated love with a single dazzling heart-shaped stone set on a sleek, polished band. Elegant and timeless, this piece radiates warmth and devotion — perfect for expressing affection or marking life’s most cherished moments.\n\n✨ By Vedaro – crafted to speak the language of love.', '', NULL, NULL, NULL, '7113', 1.00, NULL, 0.00, 1, NULL, '', 'E-design', 'variant', NULL, NULL, NULL, 0.00, 0.00, 0.00, 'products/1762197848_qVi3ZJUDnL.jpg', '', '', 6, 6, 0.00, 0, 0, 0, NULL, '2025-11-03 19:24:08', '2025-11-10 04:54:10'),
(29, 'Seraphine Heart Ring', 'DISC-LEY8ZB', '22', '', NULL, NULL, '', NULL, 'The Seraphine Heart Ring blends intricate artistry with timeless romance. Its openwork band weaves an elegant pattern of infinity knots, leading to a radiant heart-cut stone at the center — symbolizing eternal love and divine connection. A perfect piece for those who believe love is both strength and serenity.', '', NULL, NULL, NULL, '7113', 1.00, NULL, 0.00, 1, NULL, '', 'E-design', 'variant', NULL, NULL, NULL, 0.00, 0.00, 0.00, 'products/1762198472_0or2n2peso.jpg', '', '', 3, 3, 0.00, 0, 0, 0, NULL, '2025-11-03 19:34:32', '2025-11-10 04:54:10'),
(30, 'Calesto Halo', 'DISC-EAMD9B', '22', '', NULL, NULL, '', NULL, 'The Calesto Halo Ring embodies celestial beauty — a shimmering round centerpiece encircled by a delicate halo of brilliance. Designed to capture light from every angle, it symbolizes eternal radiance and divine harmony. Perfect for those who believe elegance lies in simplicity and grace.', '', NULL, NULL, NULL, '7113', 1.00, NULL, 0.00, 1, NULL, '', 'E-design', 'variant', NULL, NULL, NULL, 0.00, 0.00, 0.00, 'products/1762198750_dlTTaQQjAA.jpg', '', '', 3, 3, 0.00, 0, 0, 0, NULL, '2025-11-03 19:39:10', '2025-11-10 04:54:10'),
(31, 'Elara Duo', 'DISC-TYRTK9', '22', '', NULL, NULL, '', NULL, 'The Elara Duo Ring features a modern, geometric open-band design with two brilliant round-cut stones at its heart, framed by sleek baguette accents on either side. Crafted in pure silver, this ring represents balance — where elegance meets edge. A perfect blend of contemporary style and timeless charm, ideal for daily wear or special evenings.', '', NULL, NULL, NULL, '7113', 1.00, NULL, 0.00, 1, NULL, '', 'E-design', 'variant', NULL, NULL, NULL, 0.00, 0.00, 0.00, 'products/1762199117_xUG6y32viH.jpg', '', '', 3, 3, 0.00, 0, 0, 0, NULL, '2025-11-03 19:45:17', '2025-11-10 04:54:10'),
(32, 'Elara Grace', 'DISC-2W6UKL', '22', '', NULL, NULL, '', NULL, 'The Elara Grace Ring radiates timeless charm with its intricate silver craftsmanship and a delicately sculpted floral-inspired design. Every curve reflects purity and devotion — a piece that seamlessly blends divine elegance with modern artistry. Perfect for those who appreciate understated luxury and grace.', '', NULL, NULL, NULL, '7113', 1.00, NULL, 0.00, 1, NULL, '', 'E-design', 'variant', NULL, NULL, NULL, 0.00, 0.00, 0.00, 'products/1762199117_nGZ2l3IgZX.jpg', '', '', 3, 3, 0.00, 0, 0, 0, NULL, '2025-11-03 19:45:17', '2025-11-10 04:54:10'),
(33, 'Tearora ', 'DISC-RZ1BKP', '24', '', NULL, NULL, '13', NULL, 'The Tearora Bangle radiates refined beauty with its dual teardrop design, symbolizing balance and grace. Crafted in pure 92.5 silver, each teardrop is outlined with sparkling stones that capture the light beautifully. Minimal yet striking, this bangle is the perfect blend of modern charm and timeless elegance — ideal for both daily wear and festive occasions.', '', NULL, NULL, NULL, '7113', 1.00, NULL, 4908.00, 1, NULL, '', 'E-design', 'simple', NULL, NULL, NULL, 4908.00, 0.00, 4908.00, 'products/1762449080_oY8dA61frj.jpg', '', '', 1, 1, 0.00, 0, 0, 0, NULL, '2025-11-04 17:22:12', '2025-11-10 04:54:10');

-- --------------------------------------------------------

--
-- Table structure for table `product_identifiers`
--

CREATE TABLE `product_identifiers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `qr_code` varchar(255) NOT NULL,
  `rfid` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_identifiers`
--

INSERT INTO `product_identifiers` (`id`, `product_id`, `qr_code`, `rfid`, `created_at`, `updated_at`) VALUES
(1, 1, 'PRODCKntkc', NULL, '2025-11-01 05:47:15', '2025-11-01 05:47:15'),
(2, 1, 'PRODdM0A0C', NULL, '2025-11-01 05:47:15', '2025-11-01 05:47:15'),
(3, 1, 'PRODaF2lB9', NULL, '2025-11-01 05:47:15', '2025-11-01 05:47:15'),
(4, 1, 'PRODOI4L6j', NULL, '2025-11-01 05:47:15', '2025-11-01 05:47:15'),
(5, 1, 'PRODz8sISv', NULL, '2025-11-01 05:47:15', '2025-11-01 05:47:15');

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `size` varchar(255) DEFAULT NULL,
  `weight` decimal(8,0) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `attributes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attributes`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `size`, `weight`, `price`, `stock`, `discount_price`, `sku`, `attributes`, `created_at`, `updated_at`) VALUES
(3, 1, 'default', 2, 728.00, 5, 728.00, NULL, NULL, '2025-10-31 15:26:23', '2025-10-31 15:26:23'),
(4, 2, 'default', 2, 633.00, 5, 633.00, NULL, NULL, '2025-10-31 15:26:23', '2025-10-31 15:26:23'),
(5, 3, 'default', 1, 364.00, 10, 364.00, NULL, NULL, '2025-10-31 15:26:23', '2025-10-31 15:26:23'),
(6, 4, 'default', 26, 5962.00, 1, 5962.00, NULL, NULL, '2025-11-01 06:09:13', '2025-11-01 06:09:13'),
(7, 5, 'default', 26, 6899.00, 1, 6899.00, NULL, NULL, '2025-11-01 06:09:13', '2025-11-01 06:09:13'),
(737, 7, 'default', 13, 0.00, 1, 0.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(738, 8, 'default', 7, 0.00, 1, 0.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(739, 9, 'default', 5, 0.00, 3, 0.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(740, 10, 'default', 4, 0.00, 3, 0.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(741, 11, 'default', 5, 0.00, 3, 0.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(742, 15, 'default', 3, 0.00, 3, 0.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(743, 16, 'default', 3, 0.00, 3, 0.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(744, 17, '13', 5, 3294.00, 1, 3294.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(745, 18, 'default', 6, 0.00, 1, 0.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(746, 19, '12', 4, 2848.00, 1, 2848.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(747, 19, '14', 4, 2948.00, 1, 2948.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(748, 20, '13', 5, 3449.00, 1, 3449.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(749, 20, '14', 5, 3549.00, 1, 3549.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(750, 20, '16', 6, 3649.00, 1, 3649.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(751, 21, '13', 5, 2428.00, 1, 2428.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(752, 21, '16', 5, 2528.00, 1, 2528.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(753, 22, '12', 5, 2226.00, 1, 2226.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(754, 22, '10', 4, 2126.00, 1, 2126.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(755, 23, '16', 4, 2564.00, 1, 2564.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(756, 26, '10', 4, 1932.00, 1, 1932.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(757, 26, '16', 4, 1999.00, 1, 1999.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(758, 27, '12', 4, 1830.00, 1, 1830.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(759, 27, '14', 4, 1899.00, 1, 1899.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(760, 28, '12', 3, 1294.00, 1, 1294.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(761, 28, '13', 3, 1299.00, 1, 1299.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(762, 28, '14', 4, 1329.00, 1, 1329.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(763, 28, '15', 4, 1379.00, 1, 1379.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(764, 28, '16', 4, 1399.00, 2, 1399.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(765, 29, '10', 4, 1612.00, 1, 1612.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(766, 29, '12', 38, 1712.00, 1, 1712.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(767, 29, '16', 4, 1749.00, 1, 1749.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(768, 30, '12', 3, 1031.00, 1, 1031.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(769, 30, '14', 4, 1059.00, 1, 1059.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(770, 30, '16', 3, 1099.00, 1, 1099.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(771, 31, '12', 3, 1023.00, 1, 1023.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(772, 31, '14', 4, 1079.00, 1, 1079.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(773, 31, '16', 4, 1159.00, 1, 1159.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(774, 32, '12', 3, 663.00, 1, 663.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(775, 32, '14', 4, 721.00, 1, 721.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(776, 32, '16', 4, 749.00, 1, 749.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10'),
(777, 33, 'default', 13, 0.00, 1, 0.00, NULL, NULL, '2025-11-10 04:54:10', '2025-11-10 04:54:10');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `invoice_date` date NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `vendor_gstin` varchar(255) DEFAULT NULL,
  `grand_total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `invoice_number`, `invoice_date`, `vendor_id`, `vendor_gstin`, `grand_total`, `created_at`, `updated_at`) VALUES
(1, 'JUL-012-25-26', '2025-07-03', 1, '27AAAPJ5733D1Z2', 6455.01, '2025-10-31 15:26:23', '2025-10-31 15:26:23'),
(4, 'JUL-011-25-26', '2025-07-03', 1, '27AAAPJ5733D1Z2', 7869.20, '2025-11-01 06:09:13', '2025-11-01 06:09:13'),
(6, 'JUL-010-25-26', '2025-07-03', 1, '27AAAPJ5733D1Z2', 69062.12, '2025-11-02 17:25:25', '2025-11-10 04:54:10');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

CREATE TABLE `purchase_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `item_code` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `discount_percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `net_price` decimal(10,2) NOT NULL,
  `tax_amount` decimal(10,2) NOT NULL,
  `total_incl_tax` decimal(10,2) NOT NULL,
  `tax_group_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_items`
--

INSERT INTO `purchase_items` (`id`, `purchase_id`, `product_id`, `product_name`, `item_code`, `quantity`, `unit_price`, `discount_percentage`, `net_price`, `tax_amount`, `total_incl_tax`, `tax_group_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'E-Rakhi', 'R018', 5, 728.00, 40.00, 436.80, 65.52, 2249.52, 1, '2025-10-31 15:26:23', '2025-10-31 15:26:23'),
(2, 1, 2, 'E-Rakhi', 'R009', 5, 633.00, 40.00, 379.80, 56.97, 1955.97, 1, '2025-10-31 15:26:23', '2025-10-31 15:26:23'),
(3, 1, 3, 'E-Rakhi', 'R037', 10, 364.00, 40.00, 218.40, 65.52, 2249.52, 1, '2025-10-31 15:26:23', '2025-10-31 15:26:23'),
(6, 4, 4, 'E-Silver Jew', 'Silver Ornaments', 1, 3546.00, 0.00, 3546.00, 106.38, 3652.38, 1, '2025-11-01 06:09:13', '2025-11-01 06:09:13'),
(7, 4, 5, 'E-Silver Jew', 'Silver Ornaments', 1, 4094.00, 0.00, 4094.00, 122.82, 4216.82, 1, '2025-11-01 06:09:13', '2025-11-01 06:09:13'),
(9, 6, 7, 'E-Bracelates', 'SW66BRC104', 1, 6560.00, 40.00, 3936.00, 118.08, 4054.08, 1, '2025-11-02 17:25:25', '2025-11-03 11:20:37'),
(10, 6, 8, 'E-Bracelates', 'SW34BRC899', 1, 5577.00, 40.00, 3346.20, 100.39, 3446.59, 1, '2025-11-02 17:25:25', '2025-11-03 16:24:13'),
(11, 6, 9, 'E-Bracelates', 'SW34BRC280', 3, 2613.00, 40.00, 1567.80, 141.10, 4844.50, 1, '2025-11-02 17:25:25', '2025-11-03 16:24:13'),
(12, 6, 10, 'E-Bracelates', 'SW34BRC797', 3, 2550.00, 40.00, 1530.00, 137.70, 4727.70, 1, '2025-11-02 17:25:25', '2025-11-03 16:25:12'),
(13, 6, 11, 'E-Bracelates', 'SW34BRC645', 3, 2378.00, 40.00, 1426.80, 128.41, 4408.81, 1, '2025-11-02 17:25:25', '2025-11-03 16:25:12'),
(18, 6, 15, 'E-Bracelates', 'SW34BRC769', 3, 2351.00, 40.00, 1410.60, 126.95, 4358.75, 1, '2025-11-03 16:36:53', '2025-11-03 16:36:53'),
(19, 6, 16, 'E-Bracelates', 'SW34BRC767', 3, 2119.00, 40.00, 1271.40, 114.43, 3928.63, 1, '2025-11-03 16:36:53', '2025-11-03 16:36:53'),
(20, 6, 17, 'E-Fingering', 'SW33RING187', 1, 3294.00, 40.00, 1976.40, 59.29, 2035.69, 1, '2025-11-03 16:45:27', '2025-11-03 16:45:27'),
(21, 6, 18, 'E-Fingering', 'SW12RING213', 1, 2956.00, 40.00, 1773.60, 53.21, 1826.81, 1, '2025-11-03 18:17:24', '2025-11-03 18:17:24'),
(22, 6, 19, 'E-Fingering', 'SW09RING198', 2, 2748.00, 40.00, 1648.80, 98.93, 3396.53, 1, '2025-11-03 18:17:24', '2025-11-03 18:17:24'),
(23, 6, 20, 'E-Fingering', 'SW33RING061', 3, 2449.00, 40.00, 1469.40, 132.25, 4540.45, 1, '2025-11-03 18:17:24', '2025-11-03 18:17:24'),
(24, 6, 21, 'E-Fingering', 'SW66RING40', 2, 2328.00, 40.00, 1396.80, 83.81, 2877.41, 1, '2025-11-03 18:17:24', '2025-11-03 18:17:24'),
(25, 6, 22, 'E-Fingering', 'SW66RING40', 2, 2326.00, 40.00, 1395.60, 83.74, 2874.94, 1, '2025-11-03 18:17:24', '2025-11-03 18:17:24'),
(26, 6, 23, 'E-Fingering', 'SW34RING102', 1, 2164.00, 40.00, 1298.40, 38.95, 1337.35, 1, '2025-11-03 18:17:24', '2025-11-03 18:17:24'),
(30, 6, 26, 'E-Fingering', 'SW22RING377', 2, 1932.00, 40.00, 1159.20, 69.55, 2387.95, 1, '2025-11-03 19:12:32', '2025-11-03 19:12:32'),
(31, 6, 27, 'E-Fingering', 'SW01RING177', 2, 1830.00, 40.00, 1098.00, 65.88, 2261.88, 1, '2025-11-03 19:15:13', '2025-11-03 19:29:44'),
(32, 6, 28, 'E-Fingering', 'SW29RING072', 6, 1294.00, 40.00, 776.40, 139.75, 4798.15, 1, '2025-11-03 19:24:08', '2025-11-03 19:24:08'),
(33, 6, 29, 'E-Fingering', 'SW01RING566', 3, 1612.00, 40.00, 967.20, 87.05, 2988.65, 1, '2025-11-03 19:34:32', '2025-11-03 19:34:32'),
(34, 6, 30, 'E-Fingering', 'SW14RING266', 3, 1042.00, 40.00, 625.20, 56.27, 1931.87, 1, '2025-11-03 19:39:10', '2025-11-03 19:39:10'),
(35, 6, 31, 'E-Fingering', 'SW34RING605', 3, 1023.00, 40.00, 613.80, 55.24, 1896.64, 1, '2025-11-03 19:45:17', '2025-11-03 19:45:17'),
(36, 6, 32, 'E-Fingering', 'SW66RING160', 3, 663.00, 40.00, 397.80, 35.80, 1229.20, 1, '2025-11-03 19:45:17', '2025-11-03 19:45:17'),
(37, 6, 33, 'E-Kada Bracelet', 'SW22BRC062', 1, 4708.00, 40.00, 2824.80, 84.74, 2909.54, 1, '2025-11-04 17:22:12', '2025-11-06 17:11:20');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_product_names`
--

CREATE TABLE `purchase_product_names` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_product_names`
--

INSERT INTO `purchase_product_names` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'E-Bracelates', '2025-11-03 08:25:10', '2025-11-03 08:25:10'),
(2, 'E-Earing', '2025-11-03 16:37:07', '2025-11-03 16:37:07'),
(4, 'E-Silver Jew', '2025-11-03 16:38:10', '2025-11-03 16:38:10'),
(5, 'E-Kada Bracelet', '2025-11-03 16:38:34', '2025-11-03 16:38:34'),
(6, 'E-Fingering', '2025-11-03 16:38:54', '2025-11-03 16:38:54'),
(7, 'E-Pendent', '2025-11-03 16:39:12', '2025-11-03 16:39:12'),
(8, 'E-P.Set', '2025-11-03 16:39:30', '2025-11-03 16:39:30');

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
  `channel_order_id` varchar(255) DEFAULT NULL,
  `shipment_id` bigint(20) DEFAULT NULL,
  `awb_code` varchar(255) DEFAULT NULL,
  `courier_name` varchar(255) DEFAULT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `origin` varchar(255) DEFAULT NULL,
  `packages` int(11) DEFAULT 1,
  `pod` varchar(255) DEFAULT NULL,
  `pod_status` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `tracking_url` varchar(255) DEFAULT NULL,
  `weight` decimal(8,2) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `tax_group` varchar(255) DEFAULT NULL,
  `rate` decimal(10,2) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `code` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`id`, `name`, `tax_group`, `rate`, `is_active`, `code`, `description`, `created_at`, `updated_at`) VALUES
(1, 'IGST1.5', 'IGST', 1.50, 1, NULL, NULL, '2025-09-05 10:51:58', '2025-09-05 10:51:58'),
(2, 'CGST1.5', 'CGST', 1.50, 1, NULL, NULL, '2025-09-05 10:52:43', '2025-09-05 10:52:43');

-- --------------------------------------------------------

--
-- Table structure for table `tax_groups`
--

CREATE TABLE `tax_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tax_groups`
--

INSERT INTO `tax_groups` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'GST3', '2025-09-05 10:53:34', '2025-09-05 10:53:34');

-- --------------------------------------------------------

--
-- Table structure for table `tax_group_tax`
--

CREATE TABLE `tax_group_tax` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tax_group_id` bigint(20) UNSIGNED NOT NULL,
  `tax_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tax_group_tax`
--

INSERT INTO `tax_group_tax` (`id`, `tax_group_id`, `tax_id`) VALUES
(1, 1, 2),
(2, 1, 1);

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
(16, 'Bhavya', 'Garodia', '8290210109', 'bhavyagarodia9@gmail.com', '$2y$12$wSyyTkSt2ryDn6zQVPdQDuo6wQvPpQZJ7rvAuIIxf7Wf6Dll3B3hK', '2025-08-03 13:55:57', '2025-08-03 13:55:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'Bhupendra', 'Dhote', '8109010648', 'bhudhote998@gmail.com', '$2y$12$VHia9x2APRaXy9a0g6bE3ePYlLTZrs.QBof2s3ky4mJkk5G.BUWiC', '2025-08-04 14:49:00', '2025-08-04 14:49:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'Honey', 'jain', '8128827478', 'jainhoney0299@gmail.com', '$2y$12$tZhKEldY05Cc27TXbnkT/uQJMaUhTbOXYv4nql0y2xi0SNV6aB3qm', '2025-08-04 14:52:19', '2025-08-04 14:52:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'Ritu', 'Garodia', '9461280001', 'ritumukesh15@gmail.com', '$2y$12$O3xoZc5BdgSDaTeqLBBEYOKOIhnftk74Uw2pH2CM7i2uHLqMiLmqy', '2025-08-04 15:22:53', '2025-08-04 15:22:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 'Sharad', 'Bhaisaniya', '9752008368', 'bhaisaniya@gmail.com', '$2y$12$X6KTwWeZQAOT3sBh96HXxuC673inGQmH4wwfRVtEQrsg51Z1s5vH2', '2025-08-07 07:59:45', '2025-10-08 07:56:27', NULL, NULL, 'Male', 'Ashta', 466125, NULL, 'Maina, teh: Ashta, Dist: Sehore Madhya Pradesh', NULL),
(29, 'Shreyash', 'Gupta', '7877654479', 'shreyashgupta326@gmail.com', '$2y$12$psjOJoTaLbXbiNbZo8vpOO0Gao/cao7B5T62juZriqwONc6jWblHi', '2025-08-07 08:21:55', '2025-08-07 08:21:55', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 'Test', 'Test', '8817440858', 'test1@gmail.com', '$2y$12$9WACZr9LMZcQ/c/0Ybe3W.fa8HdQF/eOIsR4kGb06iPfp7uajQls6', '2025-08-12 07:49:26', '2025-08-12 07:49:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 'Vasanth', 'v', '8754986679', 'vasanthkumarv121212@gmail.com', '$2y$12$9hgbu3xckIa608x/6LOElOjop1b3TMT/Id3/BPQfe7.E01ODFCcfW', '2025-08-13 09:42:23', '2025-08-13 09:42:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
(6, 'Eric G', 'rachel@oval9.com', '3128780396', 'design work', 'Do you need help with graphic design - brochures, banners, flyers, advertisements, social media posts, logos etc? We charge a low fixed monthly fee. Let me know if you\'re interested and would like to see our portfolio.', '2025-08-06 05:35:06', '2025-08-06 05:35:06'),
(7, 'Eric G', 'rachel@oval9.com', '3128780396', 'design work', 'Do you need help with graphic design - brochures, banners, flyers, advertisements, social media posts, logos etc? We charge a low fixed monthly fee. Let me know if you\'re interested and would like to see our portfolio.', '2025-08-06 05:45:03', '2025-08-06 05:45:03'),
(8, 'Eric G', 'rachel@oval9.com', '3128780396', 'design work', 'Do you need help with graphic design - brochures, banners, flyers, advertisements, social media posts, logos etc?\r\nWe charge a low fixed monthly fee. Let me know if you\'re interested and would like to see our portfolio.', '2025-08-07 07:47:01', '2025-08-07 07:47:01'),
(9, 'Eric G', 'rachel@oval9.com', '3128780396', 'design work', 'Do you need help with graphic design - brochures, banners, flyers, advertisements, social media posts, logos etc? We charge a low fixed monthly fee. Let me know if you\'re interested and would like to see our portfolio.', '2025-08-12 06:22:08', '2025-08-12 06:22:08');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `salutation` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `gst_no` varchar(255) DEFAULT NULL,
  `pan_no` varchar(255) DEFAULT NULL,
  `hsn_code` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `billing_address` text DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `ifsc_code` varchar(255) DEFAULT NULL,
  `branch_name` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `notes` text DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `display_name`, `company_name`, `salutation`, `first_name`, `last_name`, `email`, `phone`, `mobile`, `gst_no`, `pan_no`, `hsn_code`, `address`, `billing_address`, `shipping_address`, `account_number`, `bank_name`, `ifsc_code`, `branch_name`, `status`, `notes`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Essense', 'Essense', 'Mr.', 'Vivad', 'Jain', 'edmumbai@gmail.com', '7045623550', '9819000987', '27AAAPJ5733D1Z2', NULL, NULL, '2nd Floor, Above E-designs,62/62A,Zaveri Bazar, Mumbai - 400002', NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2025-10-31 14:19:41', '2025-10-31 14:19:41');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist_items`
--

CREATE TABLE `wishlist_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_name_unique` (`name`);

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
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`),
  ADD KEY `coupons_category_id_foreign` (`category_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_user_id_foreign` (`user_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
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
-- Indexes for table `hsn_codes`
--
ALTER TABLE `hsn_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hsn_codes_code_unique` (`code`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoices_invoice_number_unique` (`invoice_number`),
  ADD KEY `invoices_user_id_index` (`user_id`),
  ADD KEY `invoices_offline_online_index` (`offline_online`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_items_invoice_id_index` (`invoice_id`);

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
-- Indexes for table `offline_customers`
--
ALTER TABLE `offline_customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `offline_customers_email_unique` (`email`),
  ADD UNIQUE KEY `offline_customers_phone_unique` (`phone`),
  ADD KEY `offline_customers_user_id_foreign` (`user_id`);

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
-- Indexes for table `performa_invoices`
--
ALTER TABLE `performa_invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `performa_invoices_performa_number_unique` (`performa_number`),
  ADD KEY `performa_invoices_user_id_index` (`user_id`),
  ADD KEY `performa_invoices_offline_online_index` (`offline_online`);

--
-- Indexes for table `performa_invoice_items`
--
ALTER TABLE `performa_invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `performa_invoice_items_performa_invoice_id_index` (`performa_invoice_id`);

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
-- Indexes for table `product_identifiers`
--
ALTER TABLE `product_identifiers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_identifiers_qr_code_unique` (`qr_code`),
  ADD UNIQUE KEY `product_identifiers_rfid_unique` (`rfid`),
  ADD KEY `product_identifiers_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_variants_sku_unique` (`sku`),
  ADD KEY `product_variants_product_id_foreign` (`product_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchases_invoice_number_unique` (`invoice_number`),
  ADD KEY `purchases_vendor_id_foreign` (`vendor_id`);

--
-- Indexes for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_items_purchase_id_foreign` (`purchase_id`),
  ADD KEY `purchase_items_product_id_foreign` (`product_id`),
  ADD KEY `purchase_items_tax_group_id_foreign` (`tax_group_id`);

--
-- Indexes for table `purchase_product_names`
--
ALTER TABLE `purchase_product_names`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchase_product_names_name_unique` (`name`);

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
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tax_groups`
--
ALTER TABLE `tax_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tax_group_tax`
--
ALTER TABLE `tax_group_tax`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tax_group_tax_tax_group_id_foreign` (`tax_group_id`),
  ADD KEY `tax_group_tax_tax_id_foreign` (`tax_id`);

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
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vendors_display_name_unique` (`display_name`);

--
-- Indexes for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wishlist_items_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `wishlist_items_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gift_products`
--
ALTER TABLE `gift_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hsn_codes`
--
ALTER TABLE `hsn_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `offline_customers`
--
ALTER TABLE `offline_customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `performa_invoices`
--
ALTER TABLE `performa_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `performa_invoice_items`
--
ALTER TABLE `performa_invoice_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pre_bookings`
--
ALTER TABLE `pre_bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `product_identifiers`
--
ALTER TABLE `product_identifiers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=778;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `purchase_product_names`
--
ALTER TABLE `purchase_product_names`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shiprocket_orders`
--
ALTER TABLE `shiprocket_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tax_groups`
--
ALTER TABLE `tax_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tax_group_tax`
--
ALTER TABLE `tax_group_tax`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user_inquiries`
--
ALTER TABLE `user_inquiries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `coupons`
--
ALTER TABLE `coupons`
  ADD CONSTRAINT `coupons_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `invoice_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `offline_customers`
--
ALTER TABLE `offline_customers`
  ADD CONSTRAINT `offline_customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `performa_invoice_items`
--
ALTER TABLE `performa_invoice_items`
  ADD CONSTRAINT `performa_invoice_items_performa_invoice_id_foreign` FOREIGN KEY (`performa_invoice_id`) REFERENCES `performa_invoices` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_identifiers`
--
ALTER TABLE `product_identifiers`
  ADD CONSTRAINT `product_identifiers_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD CONSTRAINT `purchase_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `purchase_items_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_items_tax_group_id_foreign` FOREIGN KEY (`tax_group_id`) REFERENCES `tax_groups` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tax_group_tax`
--
ALTER TABLE `tax_group_tax`
  ADD CONSTRAINT `tax_group_tax_tax_group_id_foreign` FOREIGN KEY (`tax_group_id`) REFERENCES `tax_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tax_group_tax_tax_id_foreign` FOREIGN KEY (`tax_id`) REFERENCES `taxes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  ADD CONSTRAINT `wishlist_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
