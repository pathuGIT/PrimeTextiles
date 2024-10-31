-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2024 at 08:06 AM
-- Server version: 8.0.34
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `primetextiles`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_table`
--

CREATE TABLE `admin_table` (
  `admin_id` int NOT NULL,
  `admin_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `admin_email` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `admin_image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `admin_password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_table`
--

INSERT INTO `admin_table` (`admin_id`, `admin_name`, `admin_email`, `admin_image`, `admin_password`) VALUES
(1, 'abdo', 'abdo@gmail.com', 'logo after 3d_2.png', '$2y$10$M/A/r5j/GSeJrAZxI8NtRu9eG5yNltfgTrfQVoClfSIF/pzNUXa2W'),
(2, 'admin', 'admin@gmail.com', '2560px-SpaCy_logo.svg.png', '$2y$10$7dCNcPJcKURLG0CGJ/ef5.hgQT4uD9r6IIfQIPSgRP9WpKydrAuXK'),
(3, 'admin2', 'admin@gmail.com', 'admin_1730266379.jpg', '$2y$10$uDVuEnHPJVBsg1VjZUnDBetilOV0mi.QGqAeUFk0ORdyE5zYkRojW');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int NOT NULL,
  `brand_title` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `brand_logo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_title`, `brand_logo`) VALUES
(1, 'Nike', NULL),
(2, 'Adidas', NULL),
(3, 'Puma', NULL),
(4, 'Under Armou', NULL),
(5, 'Reebok', NULL),
(7, 'Zara', NULL),
(8, 'H&M', NULL),
(14, 'zcssfd', 'brand_1730262508.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `card_details`
--

CREATE TABLE `card_details` (
  `product_id` int NOT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int NOT NULL,
  `category_title` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `banner_image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_title`, `banner_image`) VALUES
(1, 'Men\'s Clothing', NULL),
(3, 'Kid\'s Clothing', NULL),
(4, 'Footwear', NULL),
(5, 'Accessorie', NULL),
(6, 'Seasonal & Special Collections', NULL),
(7, 'Sportswear', NULL),
(9, 'Women\\\'s Clothind', 'category_1730261501.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders_pending`
--

CREATE TABLE `orders_pending` (
  `order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `invoice_number` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `order_status` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders_pending`
--

INSERT INTO `orders_pending` (`order_id`, `user_id`, `invoice_number`, `product_id`, `quantity`, `order_status`) VALUES
(1, 1, 312346784, 1, 3, 'pending'),
(2, 1, 312346784, 2, 1, 'pending'),
(3, 1, 312346784, 4, 1, 'pending'),
(4, 1, 1918753782, 3, 2, 'pending'),
(5, 1, 351837813, 1, 2, 'pending'),
(6, 1, 1380115601, 2, 5, 'pending'),
(7, 1, 1380115601, 3, 1, 'pending'),
(8, 1, 1796387283, 5, 1, 'pending'),
(9, 1, 282551660, 1, 1, 'pending'),
(10, 1, 282551660, 6, 1, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int NOT NULL,
  `product_title` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `product_description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `product_keywords` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `category_id` int NOT NULL,
  `brand_id` int NOT NULL,
  `product_image_one` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `product_image_two` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `product_image_three` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `product_price` float NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_title`, `product_description`, `product_keywords`, `category_id`, `brand_id`, `product_image_one`, `product_image_two`, `product_image_three`, `product_price`, `date`, `status`) VALUES
(1, 'HAVIT HV-G92 Gamepad', 'Allows you to use the familiar layout and buttons for gaming on PC and Android.', 'gamepad, havit, HV-G92, controller', 6, 9, '', 'havit2.png', 'havit3.png', 120, '2024-10-29 12:07:54', 'true'),
(2, 'Nike Air Max Sneakers', 'Comfortable and stylish sneakers designed for all-day wear.', 'sneakers, Nike, Air Max, shoes', 1, 1, '', 'nike_air_max2.png', 'nike_air_max3.png', 180, '2024-10-29 11:59:55', 'true'),
(3, 'Adidas Ultraboost Shoes', 'High-performance shoes with advanced cushioning for running.', 'running shoes, Adidas, Ultraboost, sports', 2, 2, '', 'ultraboost2.png', 'ultraboost3.png', 200, '2024-10-29 12:07:17', 'true'),
(4, 'Levi\'s 501 Original Jeans', 'Classic straight-leg jeans with a comfortable fit.', 'jeans, Levi\'s, 501, denim', 3, 6, '', 'levis501_2.png', 'levis501_3.png', 75, '2024-10-29 12:07:20', 'true'),
(5, 'Gucci GG Marmont Bag', 'A luxurious leather bag with Gucci\'s signature GG logo.', 'bag, Gucci, Marmont, luxury', 4, 9, '', 'gucci_bag2.png', 'gucci_bag3.png', 1500, '2024-10-29 12:07:23', 'true'),
(6, 'Puma Evospeed Backpack', 'Lightweight and durable backpack for daily use.', 'backpack, Puma, Evospeed, travel', 5, 3, '', 'puma_backpack2.png', 'puma_backpack3.png', 50, '2024-10-29 12:07:27', 'true'),
(7, 'Under Armour HeatGear Shirt', 'Breathable shirt that keeps you cool and comfortable.', 'shirt, Under Armour, HeatGear, sportswear', 1, 4, '', 'under_armour_shirt2.png', 'under_armour_shirt3.png', 35, '2024-10-29 12:07:29', 'true'),
(11, 'test', 'dsads', 'dsad dfsdf sdsad', 1, 3, '20220905_191740.jpg', 'Screenshot (13).png', '20220905_191740f.jpg', 200, '2024-10-30 03:57:59', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `user_orders`
--

CREATE TABLE `user_orders` (
  `order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `amount_due` int NOT NULL,
  `invoice_number` int NOT NULL,
  `total_products` int NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `order_status` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_orders`
--

INSERT INTO `user_orders` (`order_id`, `user_id`, `amount_due`, `invoice_number`, `total_products`, `order_date`, `order_status`) VALUES
(1, 1, 1160, 312346784, 3, '2023-10-22 15:31:20', 'paid'),
(2, 1, 760, 1918753782, 1, '2023-10-24 00:25:10', 'pending'),
(3, 1, 240, 351837813, 1, '2023-10-24 18:41:02', 'pending'),
(4, 1, 1100, 1380115601, 2, '2024-10-29 14:47:30', 'pending'),
(5, 1, 1500, 1796387283, 1, '2024-10-29 16:39:37', 'pending'),
(6, 1, 170, 282551660, 2, '2024-10-30 07:02:07', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `user_payments`
--

CREATE TABLE `user_payments` (
  `payment_id` int NOT NULL,
  `order_id` int NOT NULL,
  `invoice_number` int NOT NULL,
  `amount` int NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `user_id` int NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `user_email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `user_password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_ip` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `user_address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_mobile` varchar(20) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`user_id`, `username`, `user_email`, `user_password`, `user_image`, `user_ip`, `user_address`, `user_mobile`) VALUES
(1, 'abdo', 'abdo@gmail.com', '$2y$10$5ynby9fq7wf2ZmHlkvehu.JGbK6r7zZLtLzuJz9Jt5FP03rGZ9Mj.', 'new logo after Edit1920.png', '::1', 'Cairo', '123456789'),
(3, 'user', 'anjanarefe@gmail.com', '$2y$10$6bfPPuFXN5d8R6eFZZFR.OwCpqtCbNin6JQRZPV5RF4sIR6TuYwYu', 'R.png', '::1', 'sdasd', '0762414405');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_table`
--
ALTER TABLE `admin_table`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `card_details`
--
ALTER TABLE `card_details`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `orders_pending`
--
ALTER TABLE `orders_pending`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `user_orders`
--
ALTER TABLE `user_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `user_payments`
--
ALTER TABLE `user_payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_table`
--
ALTER TABLE `admin_table`
  MODIFY `admin_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders_pending`
--
ALTER TABLE `orders_pending`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_orders`
--
ALTER TABLE `user_orders`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_payments`
--
ALTER TABLE `user_payments`
  MODIFY `payment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
