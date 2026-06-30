-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 19, 2026 at 01:27 PM
-- Server version: 8.0.46-0ubuntu0.24.04.2
-- PHP Version: 8.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stautoparts`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `parent_id`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Engine Parts', 'Engine-Parts', NULL, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(2, 'Air Intake Systems', 'Air-Intake-Systems', 1, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(3, 'Air Filters', 'Air-Filters', 2, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(4, 'Intake Manifolds', 'Intake-Manifolds', 2, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(5, 'Throttle Bodies', 'Throttle-Bodies', 2, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(6, 'Fuel Systems', 'Fuel-Systems', 1, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(7, 'Fuel Injectors', 'Fuel-Injectors', 6, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(8, 'Fuel Pumps', 'Fuel-Pumps', 6, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(9, 'Carburetors', 'Carburetors', 6, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(10, 'Cooling Systems', 'Cooling-Systems', 1, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(11, 'Radiators', 'Radiators', 10, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(12, 'Water Pumps', 'Water-Pumps', 10, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(13, 'Thermostats', 'Thermostats', 10, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(14, 'Exhaust Systems', 'Exhaust-Systems', 1, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(15, 'Body & Exterior', 'Body-Exterior', NULL, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(16, 'Body Parts', 'Body-Parts', 15, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(17, 'Mirrors & Glass', 'Mirrors-Glass', 15, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(18, 'Accessories', 'Accessories', 15, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(19, 'Interior Parts', 'Interior-Parts', NULL, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(20, 'Tires', 'Tires', 19, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(21, 'Wheels & Rims', 'Wheels-Rims', 19, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(22, 'Tire Accessories', 'Tire-Accessories', 19, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(23, 'Electrical & Lighting', 'Electrical-Lighting', NULL, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(24, 'Lighting & Lamps', 'Lighting-Lamps', 23, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(25, 'Ignition System', 'Ignition-System', 23, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(26, 'Batteries & Cables', 'Batteries-Cables', 23, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(27, 'Brakes & Brake Parts', 'Brakes-Brake-Parts', NULL, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(28, 'Brake Pads & Shoes', 'Brake-Pads-Shoes', 27, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(29, 'Front Brake Pads', 'Front-Brake-Pads', 28, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(30, 'Rear Brake Pads', 'Rear-Brake-Pads', 28, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(31, 'Rotors & Drums', 'Rotors-Drums', 27, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(32, 'Brake Rotors', 'Brake-Rotors', 31, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(33, 'Brake Drums', 'Brake-Drums', 31, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(34, 'Brake Lines & Hoses', 'Brake-Lines-Hoses', 27, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(35, 'Transmission & Drivetrain', 'Transmission-Drivetrain', NULL, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(36, 'Clutch Parts', 'Clutch-Parts', 35, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(37, 'Clutch Discs', 'Clutch-Discs', 36, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(38, 'Pressure Plates', 'Pressure-Plates', 36, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(39, 'Flywheels', 'Flywheels', 36, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(40, 'Differentials', 'Differentials', 35, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(41, 'Differential Covers', 'Differential-Covers', 40, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(42, 'Gears', 'Gears', 40, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(43, 'Transmission Parts', 'Transmission-Parts', 35, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(44, 'Transmission Filters', 'Transmission-Filters', 43, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(45, 'Seals', 'Seals', 43, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(46, 'Suspension Kits', 'Suspension-Kits', 35, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(47, 'Suspension & Steering', 'Suspension-Steering', NULL, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(48, 'Steering Components', 'Steering-Components', 47, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(49, 'Steering Racks', 'Steering-Racks', 48, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(50, 'Tie Rod Ends', 'Tie-Rod-Ends', 48, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(51, 'Steering Columns', 'Steering-Columns', 48, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(52, 'Shocks & Struts', 'Shocks-Struts', 47, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(53, 'Shock Absorbers', 'Shock-Absorbers', 52, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(54, 'Coil Springs', 'Coil-Springs', 52, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(55, 'Mounts', 'Mounts', 52, NULL, '2026-06-18 02:17:00', '2026-06-18 02:17:00');

-- --------------------------------------------------------

--
-- Table structure for table `compares`
--

CREATE TABLE `compares` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `compares`
--

INSERT INTO `compares` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2026-06-18 04:45:47', '2026-06-18 04:45:47'),
(2, 1, 4, '2026-06-18 04:45:49', '2026-06-18 04:45:49'),
(3, 2, 1, '2026-06-18 05:06:54', '2026-06-18 05:06:54'),
(4, 2, 2, '2026-06-18 05:06:56', '2026-06-18 05:06:56'),
(5, 1, 3, '2026-06-19 00:46:13', '2026-06-19 00:46:13'),
(6, 1, 1, '2026-06-19 00:46:17', '2026-06-19 00:46:17'),
(7, 1, 5, '2026-06-19 00:46:20', '2026-06-19 00:46:20');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `followed_sellers`
--

CREATE TABLE `followed_sellers` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `seller_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `products` int UNSIGNED NOT NULL DEFAULT '0',
  `rating` decimal(3,1) NOT NULL DEFAULT '0.0',
  `followers` int UNSIGNED NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_06_16_000000_create_users_table', 1),
(5, '2026_06_17_045442_create_orders_table', 1),
(6, '2026_06_17_045514_create_order_items_table', 1),
(7, '2026_06_17_045535_create_wishlists_table', 1),
(8, '2026_06_17_045554_create_vehicles_table', 1),
(9, '2026_06_17_045617_create_addresses_table', 1),
(10, '2026_06_17_045650_create_notifications_table', 1),
(11, '2026_06_17_061020_create_products_table', 1),
(12, '2026_06_17_070000_create_compares_table', 1),
(13, '2026_06_18_000001_create_followed_sellers_table', 1),
(14, '2026_06_18_000002_add_category_fields_to_products_table', 1),
(15, '2026_06_18_000003_add_childcategory_field_to_products_table', 1),
(16, '2026_06_18_100000_create_categories_table_and_update_products', 1),
(17, '2026_06_18_115746_create_blogs_table', 2),
(18, '2026_06_19_073425_add_role_status_to_users_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `qty` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `old_price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `badge` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` decimal(3,1) NOT NULL DEFAULT '0.0',
  `reviews` int NOT NULL DEFAULT '0',
  `featured` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `description`, `price`, `old_price`, `image`, `badge`, `rating`, `reviews`, `featured`, `created_at`, `updated_at`) VALUES
(1, 53, 'Front Shock Absorber Pair', 'front-shock-absorber-pair', 'High-performance front shock absorbers for enhanced stability and road handling.', 85.50, 120.00, '1730865630xEquqqNt.jpg', 'Best Sale', 4.8, 120, 1, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(2, 54, 'Coil Springs Suspension Kit', 'coil-springs-suspension-kit', 'Heavy duty coil springs suspension kit for rear axle load leveling.', 145.00, 180.00, '173086542025g2VBYv.jpg', 'Hot', 4.6, 54, 1, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(3, 49, 'Power Steering Rack & Pinion', 'power-steering-rack-pinion', 'Premium replacement power steering rack and pinion gear assembly.', 295.00, NULL, '1730865535QZpTcXXv.jpg', 'New', 4.7, 38, 1, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(4, 29, 'Premium Front Brake Pads Set', 'premium-front-brake-pads-set', 'Ceramic front brake pads with superior stopping power and low dust.', 45.00, 65.00, '1730865270Fc0QRDl8.jpg', 'Best Seller', 4.5, 89, 1, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(5, 30, 'Rear Brake Pads Replacement', 'rear-brake-pads-replacement', 'Quiet rear semi-metallic brake pads to restore original performance.', 35.00, NULL, '1730865270Fc0QRDl8.jpg', NULL, 4.2, 27, 1, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(6, 32, 'Cross-Drilled Front Brake Rotors', 'cross-drilled-front-brake-rotors', 'Performance cross-drilled and slotted brake rotors for cooling.', 125.00, 160.00, '1730865303Q1nWwYLE.jpg', 'Sale', 4.9, 112, 1, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(7, 3, 'High-Flow Cold Air Intake System', 'high-flow-cold-air-intake-system', 'Cold air intake system with reusable filter to unlock horsepower.', 189.99, 240.00, '173086523535Ifn9IA.jpg', 'Hot', 4.7, 210, 1, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(8, 4, 'Intake Manifold Runner Control', 'intake-manifold-runner-control', 'Replacement intake manifold for optimal air flow and fuel efficiency.', 115.00, NULL, '1730865490RFxdWzUS.jpg', NULL, 4.4, 43, 1, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(9, 5, 'Electronic Throttle Body Assembly', 'electronic-throttle-body-assembly', 'Calibrated electronic throttle body with position sensor.', 175.00, 210.00, '1730865363ZJZiG4PY.jpg', 'Sale', 4.6, 67, 1, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(10, 7, 'Multi-Port Fuel Injectors Set', 'multi-port-fuel-injectors-set', 'Matching set of 4 fuel injectors for complete combustion.', 120.00, 150.00, '1730865580GPHzRyFS.jpg', 'New', 4.8, 52, 1, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(11, 11, 'Dual Core Aluminum Radiator', 'dual-core-aluminum-radiator', 'Lightweight dual row aluminum radiator for maximum heat dissipation.', 155.00, 195.00, '1730865303Q1nWwYLE.jpg', 'Best Sale', 4.9, 143, 1, '2026-06-18 02:17:00', '2026-06-18 02:17:00'),
(12, 37, 'Stage 2 Organic Clutch Disc', 'stage-2-organic-clutch-disc', 'Heavy duty street organic clutch disc for high torque capacity.', 210.00, 280.00, '1730865580GPHzRyFS.jpg', 'Hot', 4.7, 31, 1, '2026-06-18 02:17:00', '2026-06-18 02:17:00');

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

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `phone`, `address`, `city`, `country`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `status`) VALUES
(1, 'test', 'test@test.test', 'admin', '99999999999', 'test', 'test', 'United States', NULL, '$2y$12$7G3iLPlEjh9YkkxynLx8Je8sveU3J7Qo1Jg1vIci/VJIuRivvnloC', NULL, '2026-06-18 02:48:48', '2026-06-18 04:41:58', ''),
(2, 'Purvi Dalsaniya', 'purvi.d@ociustechnologies.com', 'customer', NULL, NULL, NULL, NULL, NULL, '$2y$12$5uBS3u6Rr3DNRa.6iPqh0e2djvaW4E/Wphhc./0cygMMM.OmSolBi', NULL, '2026-06-18 05:04:49', '2026-06-18 05:04:49', ''),
(3, 'test2', 'test2@test.test', 'staff', NULL, NULL, NULL, NULL, NULL, '$2y$12$KpbbG3p4kOvIfepmxb8BseLmuh6MeleY2/beHpSAXWms.XjoAUhCy', NULL, '2026-06-19 05:43:20', '2026-06-19 05:43:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `make` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `engine` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2026-06-18 04:45:30', '2026-06-18 04:45:30'),
(4, 1, 3, '2026-06-19 00:46:09', '2026-06-19 00:46:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_parent_id_slug_index` (`parent_id`,`slug`);

--
-- Indexes for table `compares`
--
ALTER TABLE `compares`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compares_user_id_foreign` (`user_id`),
  ADD KEY `compares_product_id_foreign` (`product_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `followed_sellers`
--
ALTER TABLE `followed_sellers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `followed_sellers_user_id_foreign` (`user_id`);

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
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicles_user_id_foreign` (`user_id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlists_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `compares`
--
ALTER TABLE `compares`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `followed_sellers`
--
ALTER TABLE `followed_sellers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `compares`
--
ALTER TABLE `compares`
  ADD CONSTRAINT `compares_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `compares_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `followed_sellers`
--
ALTER TABLE `followed_sellers`
  ADD CONSTRAINT `followed_sellers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
