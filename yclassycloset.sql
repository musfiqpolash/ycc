-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2019 at 01:41 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yclassycloset`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `type` enum('banner','brand') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `name`, `type`, `created_at`, `updated_at`) VALUES
(3, '1548234395.jpg', 'banner', '2019-01-23 09:06:35', '2019-01-27 05:28:09'),
(4, '1548234420.jpg', 'banner', '2019-01-23 09:07:00', '2019-01-27 05:28:14'),
(5, '1548569710.png', 'brand', '2019-01-27 06:15:10', '2019-01-27 00:15:10'),
(6, '1548569824.png', 'brand', '2019-01-27 06:17:04', '2019-01-27 00:17:04'),
(7, '1548569832.png', 'brand', '2019-01-27 06:17:12', '2019-01-27 00:17:12'),
(8, '1548569837.png', 'brand', '2019-01-27 06:17:17', '2019-01-27 00:17:17'),
(9, '1548569841.png', 'brand', '2019-01-27 06:17:21', '2019-01-27 00:17:21'),
(10, '1548569845.png', 'brand', '2019-01-27 06:17:25', '2019-01-27 00:17:25');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Makeup', 1, '2019-01-20 09:24:04', '2019-01-20 05:41:22'),
(2, 'Skin Care', 1, '2019-01-20 09:25:04', '2019-01-20 03:25:04'),
(3, 'Accessories', 1, '2019-01-20 09:25:15', '2019-01-20 03:25:15'),
(4, 'Perfume', 1, '2019-01-20 09:25:31', '2019-01-20 03:25:31'),
(5, 'Dress', 1, '2019-01-20 09:25:39', '2019-01-20 03:25:39'),
(6, 'Shoes', 1, '2019-01-20 09:25:44', '2019-01-20 03:25:44');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `first_name`, `last_name`, `email`, `phone`, `password`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'MD. MUSFIQUR', 'RAHMAN', 'polash@gmail.com', '01888888888', '$2y$10$Q7.dt1dPYoWX69IhgGmq0.loh9Q.8wiT9yuygaagIftIjlwD1uXcO', 1, 'NG25oYzJXRlXhXJx1CZaNn6aWE02huwmiPPX4c3NOgCcKREfWUmxvnNy1w50', '2019-01-14 00:08:40', '2019-01-16 03:36:01');

-- --------------------------------------------------------

--
-- Table structure for table `customer_messages`
--

CREATE TABLE `customer_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `subject` varchar(191) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_messages`
--

INSERT INTO `customer_messages` (`id`, `name`, `email`, `subject`, `message`, `created_at`, `updated_at`) VALUES
(1, 'polash', 'polash@gmail.com', 'greetings', 'hi there', '2019-01-28 12:40:44', '2019-01-28 06:40:44');

-- --------------------------------------------------------

--
-- Table structure for table `informations`
--

CREATE TABLE `informations` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=active 0=blocked',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `informations`
--

INSERT INTO `informations` (`id`, `title`, `description`, `status`, `updated_at`) VALUES
(1, 'RETURN & REFUND POLICY', 'If you are not satisfied with your purchased items, you may return the product(s) for a full refund or exchange the product(s) within 30 day of purchase. Refunds will be processed through the original forms of payment. Any product you return must be in the same condition you received it and in the original packaging. Please keep the receipt. Please contact sspdepot@gmail.com for return & exchange inquiries and to receive further instructions on how to ship products back to us.', 1, '2018-07-12 18:25:31'),
(2, 'SHIPPING INFO', 'Please allow 2-3 business days for domestic purchases (United States) and 7-15 business days for international purchases. Time may vary depending on location.  Email confirmations with tracking information will be provided to customers after products are shipped.', 1, '2018-07-12 18:25:41');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_02_27_054447_create_products_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `p_qty` double NOT NULL,
  `p_sell_price` double NOT NULL,
  `is_discount` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=no discount 1=discount',
  `main_price` double NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `p_id`, `p_qty`, `p_sell_price`, `is_discount`, `main_price`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1, 1500, 0, 1500, 1, '2019-01-28', '2019-01-27 23:57:46'),
(2, 3, 4, 2, 150, 0, 150, 1, '2019-01-28', '2019-01-28 05:10:19'),
(3, 3, 1, 1, 1500, 0, 1500, 1, '2019-01-28', '2019-01-28 05:10:19'),
(4, 3, 2, 1, 999, 0, 999, 1, '2019-01-28', '2019-01-28 05:10:19');

-- --------------------------------------------------------

--
-- Table structure for table `order_info`
--

CREATE TABLE `order_info` (
  `id` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `client_id` int(11) NOT NULL,
  `d_date` date NOT NULL,
  `payment_id` int(11) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `shipping_point` text NOT NULL,
  `order_amount` double NOT NULL DEFAULT '0',
  `comment` varchar(255) NOT NULL,
  `shipping_cost` double NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=active 0=block',
  `created_at` date DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_info`
--

INSERT INTO `order_info` (`id`, `slug`, `client_id`, `d_date`, `payment_id`, `transaction_id`, `shipping_point`, `order_amount`, `comment`, `shipping_cost`, `status`, `created_at`, `updated_at`) VALUES
(2, '5c4e99d', 1, '2019-01-28', 2, 'PAYID-LRHJTRA39F65925NB740252Y', '{\"recipient_name\":\"musfiq polash\",\"line1\":\"1 Main St\",\"city\":\"San Jose\",\"state\":\"CA\",\"postal_code\":\"95131\",\"country_code\":\"US\"}', 1515, '', 15, 1, '2019-01-28', '2019-01-28 09:34:03'),
(3, '5c4ee31', 1, '2019-01-28', 3, 'PAYID-LRHOFXQ7YJ66351CR6679641', '{\"recipient_name\":\"musfiq polash\",\"line1\":\"1 Main St\",\"city\":\"San Jose\",\"state\":\"CA\",\"postal_code\":\"95131\",\"country_code\":\"US\"}', 2814, '', 15, 1, '2019-01-28', '2019-01-28 05:10:19');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_info`
--

CREATE TABLE `payment_info` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `payer_id` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=active 0=block',
  `created_at` date DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_info`
--

INSERT INTO `payment_info` (`id`, `email`, `first_name`, `last_name`, `payer_id`, `payment_method`, `status`, `created_at`, `updated_at`) VALUES
(2, 'polash098@gmail.com', 'musfiq', 'polash', 'MXQXJHDZMSSKE', 'paypal', 1, '2019-01-28', '2019-01-27 23:57:46'),
(3, 'polash098@gmail.com', 'musfiq', 'polash', 'MXQXJHDZMSSKE', 'paypal', 1, '2019-01-28', '2019-01-28 05:10:19');

-- --------------------------------------------------------

--
-- Table structure for table `product_image`
--

CREATE TABLE `product_image` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=active 0=blocked',
  `main_img` varchar(255) NOT NULL,
  `p_main_image` varchar(255) DEFAULT 'no_image.png',
  `color_img` varchar(255) NOT NULL,
  `thum_img` varchar(255) NOT NULL,
  `zoom_img` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_image`
--

INSERT INTO `product_image` (`id`, `product_id`, `status`, `main_img`, `p_main_image`, `color_img`, `thum_img`, `zoom_img`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'details_main_img_1_0.jpeg', 'main_image_1_0.jpeg', 'thum_image_1_0.jpeg', 'thum_image_1_0.jpeg', 'zoom_img_1_0.jpeg', '2019-01-21', '2019-01-21 02:43:58'),
(2, 2, 1, 'details_main_img_2_0.jpeg', 'main_image_2_0.jpeg', 'thum_image_2_0.jpeg', 'thum_image_2_0.jpeg', 'zoom_img_2_0.jpeg', '2019-01-21', '2019-01-21 03:13:42'),
(3, 4, 1, 'details_main_img_4_0.jpg', 'main_image_4_0.jpg', 'thum_image_4_0.jpg', 'thum_image_4_0.jpg', 'zoom_img_4_0.jpg', '2019-01-21', '2019-01-21 04:59:30');

-- --------------------------------------------------------

--
-- Table structure for table `product_info`
--

CREATE TABLE `product_info` (
  `id` int(11) NOT NULL,
  `p_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `sub_category_id` int(11) NOT NULL,
  `is_accessories` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0=accessories 1=mobile',
  `product_condition` varchar(255) NOT NULL DEFAULT 'GARDE A',
  `size` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `main_image` varchar(255) NOT NULL,
  `description` text,
  `carrier_details` text,
  `label` varchar(255) NOT NULL,
  `label_css` varchar(255) NOT NULL DEFAULT ' ',
  `is_discount` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=no discount 1=has discount',
  `discount_price` double NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=active 0=blocked',
  `created_at` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_info`
--

INSERT INTO `product_info` (`id`, `p_code`, `name`, `group_name`, `category`, `sub_category_id`, `is_accessories`, `product_condition`, `size`, `color`, `quantity`, `main_image`, `description`, `carrier_details`, `label`, `label_css`, `is_discount`, `discount_price`, `status`, `created_at`, `updated_at`) VALUES
(1, '55781', 'SHARI', '5c45864c97cc3', '5', 27, 1, 'GRADE A', '0', 'RED', 20, 'main_image_1_0.jpeg', NULL, NULL, 'FEATURED', 'colorLimited', 0, 0, 1, '2019-01-21', '2019-01-23 04:11:59'),
(2, '53454', 'FLOWER HEAVY CAMBRIC COTTON PRINTED KURTI PLAZZO SET', '5c458d455cc0a', '5', 26, 1, 'GRADE A', '0', 'YELLOW', 55, 'main_image_2_0.jpeg', '<p>Express your passion for a liberating life with this kurti plazzo set. The top is made of cotton fabric which is stylized with cotton fabric bottom all synchronized well with the latest trend and style. Get this stitched suit stitched as per your desired fit and comfort. This outfit is perfect to wear on weekend get-together, officewear, parties, functions &amp; occasions. Team this suit with ethnic accessories and high heel for a complete look and fetch compliments for your rich sense of style.</p>', NULL, 'NEW', 'colorNEW', 0, 0, 1, '2019-01-21', '2019-01-23 04:13:15'),
(3, '31776', 'HABIJABI', '5c45a58fcf763', '3', 21, 1, 'GRADE A', 'DECENT', 'YOGAT', 20, 'no-img.png', NULL, NULL, '', '', 0, 0, 0, '2019-01-21', '2019-01-21 04:58:46'),
(4, '38780', 'WALLET', '5c45a6121e738', '3', 21, 1, 'GRADE A', 'DECENT', 'black', 20, 'main_image_4_0.jpg', NULL, NULL, '', '', 0, 0, 1, '2019-01-21', '2019-01-21 05:02:52');

-- --------------------------------------------------------

--
-- Table structure for table `product_price`
--

CREATE TABLE `product_price` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `min_quantity` int(11) NOT NULL,
  `max_quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_price`
--

INSERT INTO `product_price` (`id`, `product_id`, `min_quantity`, `max_quantity`, `price`, `created_at`, `updated_at`) VALUES
(4, 4, 1, 1, 150, '2019-01-21 11:02:52', '2019-01-21 05:02:52'),
(6, 1, 1, 1, 1500, '2019-01-23 10:12:09', '2019-01-23 04:12:09'),
(7, 2, 1, 1, 999, '2019-01-23 10:13:15', '2019-01-23 04:13:15');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `logo_smll` varchar(255) NOT NULL,
  `mail_address` varchar(255) NOT NULL,
  `shipping_cost` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `logo`, `logo_smll`, `mail_address`, `shipping_cost`) VALUES
(1, 'sslogo.png', 'logo.png', 'sspdepot@gmail.com', 15);

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `category_id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Foundation', 1, '2019-01-20 11:52:19', '2019-01-20 05:55:52'),
(2, 1, 'Eyeshadow', 1, '2019-01-20 11:56:37', '2019-01-20 05:56:37'),
(3, 1, 'Eye Liner', 1, '2019-01-20 11:56:46', '2019-01-20 05:56:46'),
(4, 1, 'Mascara', 1, '2019-01-20 11:56:51', '2019-01-20 05:56:51'),
(5, 1, 'Concealer', 1, '2019-01-20 11:57:10', '2019-01-20 05:57:10'),
(6, 1, 'Highlighter', 1, '2019-01-20 11:57:20', '2019-01-20 05:57:20'),
(7, 1, 'Lipsticks', 1, '2019-01-20 11:57:31', '2019-01-20 05:57:31'),
(8, 1, 'Nail Art', 1, '2019-01-20 11:57:38', '2019-01-20 05:57:38'),
(9, 1, 'Setting Spray', 1, '2019-01-20 11:57:57', '2019-01-20 05:57:57'),
(10, 1, 'Brushes', 1, '2019-01-20 11:58:10', '2019-01-20 05:58:10'),
(11, 2, 'Moisteriser', 1, '2019-01-20 11:59:19', '2019-01-20 05:59:19'),
(12, 2, 'Miceller Water', 1, '2019-01-20 11:59:56', '2019-01-20 05:59:56'),
(13, 2, 'Soap', 1, '2019-01-20 12:00:00', '2019-01-20 06:00:00'),
(14, 2, 'Dental Care', 1, '2019-01-20 12:00:09', '2019-01-20 06:00:09'),
(15, 2, 'Hair Products', 1, '2019-01-20 12:00:16', '2019-01-20 06:00:16'),
(16, 3, 'Jwellery', 1, '2019-01-20 12:02:43', '2019-01-20 06:02:43'),
(17, 3, 'Belt', 1, '2019-01-20 12:02:48', '2019-01-20 06:02:48'),
(18, 3, 'Hair Band And Clips', 1, '2019-01-20 12:03:01', '2019-01-20 06:03:01'),
(19, 3, 'Watch', 1, '2019-01-20 12:03:06', '2019-01-20 06:03:06'),
(20, 3, 'Sunglass', 1, '2019-01-20 12:03:12', '2019-01-20 06:03:12'),
(21, 3, 'Wallet', 1, '2019-01-20 12:03:21', '2019-01-20 06:03:21'),
(22, 4, 'Gift Set', 1, '2019-01-20 12:05:13', '2019-01-20 06:05:13'),
(23, 4, 'Body Spray', 1, '2019-01-20 12:05:25', '2019-01-20 06:05:25'),
(24, 4, 'Perfumes', 1, '2019-01-20 12:05:39', '2019-01-20 06:05:39'),
(25, 4, 'Body Mist', 1, '2019-01-20 12:05:48', '2019-01-20 06:05:48'),
(26, 5, 'Kurti', 1, '2019-01-20 12:07:26', '2019-01-20 06:07:26'),
(27, 5, 'Shari', 1, '2019-01-20 12:07:34', '2019-01-20 06:07:34'),
(28, 5, 'Salwar Kamiz', 1, '2019-01-20 12:07:43', '2019-01-20 06:07:43'),
(29, 5, 'Shawl', 1, '2019-01-20 12:07:49', '2019-01-20 06:07:49'),
(30, 5, 'Skirf', 1, '2019-01-20 12:07:55', '2019-01-20 06:07:55'),
(31, 5, 'T-Shirt', 1, '2019-01-20 12:08:03', '2019-01-20 06:08:03'),
(32, 5, 'Shirt', 1, '2019-01-20 12:08:10', '2019-01-20 06:08:10'),
(33, 5, 'Pant', 1, '2019-01-20 12:08:14', '2019-01-20 06:08:14'),
(34, 5, 'Panjabi', 1, '2019-01-20 12:08:19', '2019-01-20 06:08:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Smartphone Depot', 'admin@gmail.com', '$2y$10$VqYNadMOLTkg3cMy67ObZ.NW68sqkMIWG4Y8WXXaUeI2C2ZUanKCK', 1, '7dAMEjTX6nctx4EgzjELcuFVZ256BdYwT9JiTPhC5TTpFDKVJwDeDnK0hIbE', '2018-03-01 04:03:16', '2018-03-12 18:00:09');

-- --------------------------------------------------------

--
-- Table structure for table `visitor`
--

CREATE TABLE `visitor` (
  `id` int(11) NOT NULL,
  `d_date` varchar(255) NOT NULL,
  `total_count` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visitor`
--

INSERT INTO `visitor` (`id`, `d_date`, `total_count`, `created_at`, `updated_at`) VALUES
(1, '2019-01-09', 142, '2019-01-09', '2019-01-09 07:05:32'),
(2, '2019-01-10', 172, '2019-01-10', '2019-01-10 06:44:18'),
(3, '2019-01-13', 63, '2019-01-13', '2019-01-13 06:26:28'),
(4, '2019-01-14', 26, '2019-01-14', '2019-01-14 01:53:42'),
(5, '2019-01-15', 13, '2019-01-15', '2019-01-15 03:19:45'),
(6, '2019-01-16', 7, '2019-01-16', '2019-01-16 06:40:16'),
(7, '2019-01-17', 30, '2019-01-17', '2019-01-17 06:18:12'),
(8, '2019-01-20', 37, '2019-01-20', '2019-01-20 06:41:54'),
(9, '2019-01-21', 82, '2019-01-21', '2019-01-21 06:48:15'),
(10, '2019-01-23', 28, '2019-01-23', '2019-01-23 05:17:48'),
(11, '2019-01-24', 18, '2019-01-24', '2019-01-24 03:40:35'),
(12, '2019-01-27', 39, '2019-01-27', '2019-01-27 06:53:35'),
(13, '2019-01-28', 71, '2019-01-28', '2019-01-28 06:40:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `customer_messages`
--
ALTER TABLE `customer_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `informations`
--
ALTER TABLE `informations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_info`
--
ALTER TABLE `order_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_info`
--
ALTER TABLE `payment_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_info`
--
ALTER TABLE `product_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_price`
--
ALTER TABLE `product_price`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `visitor`
--
ALTER TABLE `visitor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_messages`
--
ALTER TABLE `customer_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `informations`
--
ALTER TABLE `informations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_info`
--
ALTER TABLE `order_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment_info`
--
ALTER TABLE `payment_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_image`
--
ALTER TABLE `product_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_info`
--
ALTER TABLE `product_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_price`
--
ALTER TABLE `product_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `visitor`
--
ALTER TABLE `visitor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
