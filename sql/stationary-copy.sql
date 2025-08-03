-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2025 at 07:04 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stationary`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `customer_id`, `product_id`, `amount`, `created_at`, `updated_at`) VALUES
(1, 9, 1, 3, '2025-02-05 14:29:01', '2025-02-09 19:39:33'),
(3, 9, 2, 4, '2025-02-08 19:40:01', '2025-02-11 12:56:51'),
(5, 9, 8, 2, '2025-02-09 13:40:42', '2025-02-09 13:40:42'),
(7, 9, 6, 2, '2025-02-09 19:28:49', '2025-02-10 12:44:47');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Notebooks', 'notebooks.png', 'A variety of notebooks for school and office use.', '2025-02-05 08:10:28', '2025-02-05 08:10:28'),
(2, 'Writing Tools', 'writing-tools.png', 'Pens, pencils, and markers for all writing needs.', '2025-02-05 08:10:28', '2025-02-05 08:10:28'),
(3, 'Art Supplies', 'art-supplies.png', 'Paints, brushes, and sketchbooks for artists.', '2025-02-05 08:10:28', '2025-02-05 08:10:28'),
(4, 'Office Essentials', 'office-essentials.png', 'Office supplies like staplers, paper, and more.', '2025-02-05 08:10:28', '2025-02-05 08:10:28');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `adress` text NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `adress`, `message`, `created_at`) VALUES
(1, 'Test', 'test@gmail.com', '12asdasdasd', 'asdasdas das dasd asd asd asd asd asd a', '2025-02-05 15:30:30'),
(5, 'Test', 'testtt@gmail.com', 'asdasdd', 'asdasdasda', '2025-02-08 18:00:15');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `zipcode` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('active','inactive','suspended') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `city`, `state`, `address`, `zipcode`, `password`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Alice Johnson', 'alice@example.com', '1234567890', 'New York', 'NY', '123 Street', '10001', 'hashedpassword', 'active', '2025-02-05 08:10:18', '2025-02-05 08:10:18'),
(2, 'Bob Smith', 'bob@example.com', '0987654321', 'Los Angeles', 'CA', '456 Avenue', '90001', 'hashedpassword', 'active', '2025-02-05 08:10:18', '2025-02-05 08:10:18'),
(3, 'Charlie Brown', 'charlie@example.com', '1122334455', 'Chicago', 'IL', '789 Blvd', '60601', 'hashedpassword', 'active', '2025-02-05 08:10:18', '2025-02-05 08:10:18'),
(4, 'David Miller', 'david@example.com', '2233445566', 'Houston', 'TX', '1011 Street', '77001', 'hashedpassword', 'active', '2025-02-05 08:10:18', '2025-02-05 08:10:18'),
(5, 'Emily White', 'emily@example.com', '3344556677', 'Miami', 'FL', '1213 Road', '33101', 'hashedpassword', 'active', '2025-02-05 08:10:18', '2025-02-05 08:10:18'),
(6, 'Frank Green', 'frank@example.com', '4455667788', 'San Francisco', 'CA', '1415 Lane', '94101', 'hashedpassword', 'active', '2025-02-05 08:10:18', '2025-02-05 08:10:18'),
(7, 'Grace Lee', 'grace@example.com', '5566778899', 'Seattle', 'WA', '1617 Street', '98101', 'hashedpassword', 'active', '2025-02-05 08:10:18', '2025-02-05 08:10:18'),
(8, 'Henry Adams', 'henry@example.com', '6677889900', 'Denver', 'CO', '1819 Ave', '80201', 'hashedpassword', 'active', '2025-02-05 08:10:18', '2025-02-05 08:10:18'),
(9, 'Test', 'test@gmail.com', '12345678', 'Karachi', 'Pakistan', 'test', '123456', '$2y$10$TVDsy66YKitMvINORw6uBuxXnGtW0nQwwpM58X.Q0E6EIRssMblv2', 'active', '2025-02-05 13:37:45', '2025-02-09 18:43:38');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE `newsletter` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `newsletter`
--

INSERT INTO `newsletter` (`id`, `email`, `created_at`) VALUES
(1, 'test@gmail.com', '2025-02-05 12:25:00'),
(2, 'te2st@gmail.com', '2025-02-05 12:29:18'),
(3, 'test2323@gmail.com', '2025-02-05 14:09:55'),
(4, 't1234234@gmail.com', '2025-02-11 12:58:26');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_num` varchar(100) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `status` enum('pending','shipped','delivered','cancelled') DEFAULT 'pending',
  `total_amount` decimal(10,2) DEFAULT NULL,
  `sub_total` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_num`, `customer_id`, `status`, `total_amount`, `sub_total`, `created_at`, `updated_at`) VALUES
(1, 'ORD123456', 9, 'shipped', 499.99, 499.99, '2025-01-22 12:57:36', '2025-02-09 18:53:33'),
(2, 'ORD654321', 9, 'delivered', 134.98, 134.98, '2025-01-22 12:57:36', '2025-02-09 18:50:56'),
(6, 'ORD566164', 9, 'pending', 22.01, 25.96, '2025-02-09 18:50:26', '2025-02-09 18:50:26'),
(7, 'ORD686748', 9, 'cancelled', 5.76, 6.99, '2025-02-09 19:02:07', '2025-02-09 19:40:28'),
(8, 'ORD142298', 9, 'pending', 40.89, 46.94, '2025-02-09 19:40:08', '2025-02-09 19:40:08'),
(9, 'ORD203622', 9, 'pending', 38.78, 45.93, '2025-02-11 12:57:20', '2025-02-11 12:57:20');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT 1,
  `amount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `qty`, `amount`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 399.99, '2025-01-22 12:57:36', '2025-01-22 12:57:36'),
(2, 2, 2, 2, 29.98, '2025-01-22 12:57:36', '2025-01-22 12:57:36'),
(3, 2, 4, 1, 12.99, '2025-02-08 16:36:01', '2025-02-08 16:36:01'),
(4, 2, 6, 2, 20.00, '2025-02-08 16:36:31', '2025-02-08 16:36:31'),
(11, 6, 1, 2, 9.98, '2025-02-09 18:50:26', '2025-02-09 18:50:26'),
(12, 6, 2, 2, 10.98, '2025-02-09 18:50:26', '2025-02-09 18:50:26'),
(13, 7, 2, 1, 5.49, '2025-02-09 19:02:07', '2025-02-09 19:02:07'),
(14, 8, 1, 3, 14.97, '2025-02-09 19:40:08', '2025-02-09 19:40:08'),
(15, 8, 2, 2, 10.98, '2025-02-09 19:40:08', '2025-02-09 19:40:08'),
(16, 8, 5, 1, 12.99, '2025-02-09 19:40:08', '2025-02-09 19:40:08'),
(17, 9, 1, 3, 14.97, '2025-02-11 12:57:20', '2025-02-11 12:57:20'),
(18, 9, 2, 4, 21.96, '2025-02-11 12:57:20', '2025-02-11 12:57:20');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sku` varchar(100) DEFAULT NULL,
  `regular_price` decimal(10,2) DEFAULT NULL,
  `discounted_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `cat_id`, `name`, `description`, `image`, `sku`, `regular_price`, `discounted_price`, `created_at`, `updated_at`) VALUES
(1, 1, 'A5 Notebook', 'A high-quality A5 ruled notebook.', 'a5-notebook.png', 'NB001', 5.99, 4.99, '2025-02-05 08:10:28', '2025-02-05 08:10:28'),
(2, 1, 'Spiral Notebook', 'A durable spiral-bound notebook for easy page turning.', 'spiral-notebook.png', 'NB002', 6.99, 5.49, '2025-02-05 08:10:28', '2025-02-05 08:10:28'),
(3, 2, 'Ballpoint Pen', 'Smooth writing ballpoint pen with blue ink.', 'ballpoint-pen.png', 'WP001', 1.99, 1.49, '2025-02-05 08:10:28', '2025-02-05 08:10:28'),
(4, 2, 'Gel Pen Set', 'A set of 5 colored gel pens.', 'gel-pen-set.png', 'WP002', 7.99, 6.99, '2025-02-05 08:10:28', '2025-02-05 08:10:28'),
(5, 3, 'Watercolor Paint Set', '12-color watercolor set for painting.', 'watercolor-set.png', 'AS001', 14.99, 12.99, '2025-02-05 08:10:28', '2025-02-05 08:10:28'),
(6, 3, 'Sketchbook', 'A4 sketchbook with 100 pages.', 'sketchbook.png', 'AS002', 9.99, 8.49, '2025-02-05 08:10:28', '2025-02-05 08:10:28'),
(7, 4, 'Stapler', 'A heavy-duty stapler for office use.', 'stapler.png', 'OE001', 11.99, 10.49, '2025-02-05 08:10:28', '2025-02-05 08:10:28'),
(8, 4, 'Paper Ream', '500 sheets of A4-sized paper.', 'paper-ream.png', 'OE002', 8.99, 7.99, '2025-02-05 08:10:28', '2025-02-05 08:10:28');

-- --------------------------------------------------------

--
-- Table structure for table `product_details`
--

CREATE TABLE `product_details` (
  `id` int(11) NOT NULL,
  `prod_id` int(11) DEFAULT NULL,
  `availability` tinyint(1) DEFAULT 1,
  `stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_details`
--

INSERT INTO `product_details` (`id`, `prod_id`, `availability`, `stock`) VALUES
(1, 1, 1, 40),
(2, 2, 1, 29),
(3, 3, 1, 100),
(4, 4, 1, 80),
(5, 5, 1, 29),
(6, 6, 1, 20),
(7, 7, 1, 25),
(8, 8, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `prod_id` int(11) DEFAULT NULL,
  `images` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `prod_id`, `images`, `created_at`, `updated_at`) VALUES
(1, 1, 'a5-notebook.png', '2025-02-05 08:10:28', '2025-02-05 08:10:28'),
(2, 2, 'spiral-notebook.png', '2025-02-05 08:10:28', '2025-02-05 08:10:28'),
(3, 3, 'ballpoint-pen.png', '2025-02-05 08:10:28', '2025-02-05 08:10:28'),
(4, 4, 'gel-pen-set.png', '2025-02-05 08:10:28', '2025-02-05 08:10:28'),
(5, 5, 'watercolor-set.png', '2025-02-05 08:10:28', '2025-02-05 08:10:28'),
(6, 6, 'sketchbook.png', '2025-02-05 08:10:28', '2025-02-05 08:10:28'),
(7, 7, 'stapler.png', '2025-02-05 08:10:28', '2025-02-05 08:10:28'),
(8, 8, 'paper-ream.png', '2025-02-05 08:10:28', '2025-02-05 08:10:28'),
(9, 1, 'notebook.png', '2025-02-08 19:27:08', '2025-02-08 19:27:08');

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` int(11) NOT NULL,
  `prod_id` int(11) DEFAULT NULL,
  `review` text DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `status` enum('approved','pending','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `rating` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_reviews`
--

INSERT INTO `product_reviews` (`id`, `prod_id`, `review`, `customer_id`, `status`, `created_at`, `updated_at`, `rating`) VALUES
(1, 1, 'Great notebook for journaling!', 1, 'approved', '2025-02-05 08:10:28', '2025-02-08 18:38:36', 2),
(2, 2, 'Pages are thick and nice to write on.', 2, 'approved', '2025-02-05 08:10:28', '2025-02-08 18:38:39', 4),
(3, 3, 'Writes smoothly without smudging.', 3, 'approved', '2025-02-05 08:10:28', '2025-02-08 18:38:42', 3),
(4, 4, 'Love these gel pens, very vibrant colors.', 4, 'approved', '2025-02-05 08:10:28', '2025-02-05 08:10:28', NULL),
(5, 5, 'The colors blend well, great for beginners.', 5, 'approved', '2025-02-05 08:10:28', '2025-02-08 18:38:45', 5),
(6, 6, 'Good quality sketchbook, paper is thick.', 6, 'approved', '2025-02-05 08:10:28', '2025-02-05 08:10:28', NULL),
(7, 7, 'Sturdy and works well for heavy stapling.', 7, 'approved', '2025-02-05 08:10:28', '2025-02-08 18:38:48', 2),
(8, 6, 'Good quality paper, doesn’t tear easily.', 8, 'approved', '2025-02-05 08:10:28', '2025-02-08 20:36:46', NULL),
(9, 1, 'Quality is fantastic, I Recommend!', 9, 'approved', '2025-02-08 18:51:58', '2025-02-08 20:27:10', 3),
(10, 1, 'test', 6, 'approved', '2025-02-08 20:35:28', '2025-02-08 20:35:28', 4);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `site_title` varchar(255) NOT NULL,
  `main_logo` varchar(255) DEFAULT NULL,
  `footer_logo` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `fb` varchar(255) DEFAULT NULL,
  `insta` varchar(255) DEFAULT NULL,
  `x` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `about` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_details`
--

CREATE TABLE `shipping_details` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `zipcode` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipping_details`
--

INSERT INTO `shipping_details` (`id`, `name`, `email`, `phone`, `city`, `state`, `address`, `zipcode`) VALUES
(1, 'John Doe', 'john.doe@example.com', '1234567890', 'New York', 'NY', '1234 Elm St, Apt 56', '10001'),
(2, 'Jane Smith', 'jane.smith@example.com', '0987654321', 'Los Angeles', 'CA', '5678 Oak St', '90001');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_id` (`customer_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_num` (`order_num`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `product_details`
--
ALTER TABLE `product_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prod_id` (`prod_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prod_id` (`prod_id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prod_id` (`prod_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_details`
--
ALTER TABLE `shipping_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_details`
--
ALTER TABLE `product_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_details`
--
ALTER TABLE `shipping_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `product_details`
--
ALTER TABLE `product_details`
  ADD CONSTRAINT `product_details_ibfk_1` FOREIGN KEY (`prod_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`prod_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD CONSTRAINT `product_reviews_ibfk_1` FOREIGN KEY (`prod_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `product_reviews_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
