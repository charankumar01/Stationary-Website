-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2025 at 09:09 AM
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
(10, 3, 1, 1, '2025-02-17 06:14:10', '2025-02-17 06:14:10'),
(11, 3, 2, 1, '2025-02-17 06:14:14', '2025-02-17 06:14:14'),
(12, 3, 3, 1, '2025-02-17 06:14:17', '2025-02-17 06:14:17'),
(13, 3, 8, 1, '2025-02-17 07:08:24', '2025-02-17 07:08:24'),
(14, 3, 5, 1, '2025-02-17 07:09:41', '2025-02-17 07:09:41'),
(15, 3, 7, 1, '2025-02-17 07:09:46', '2025-02-17 07:09:46');

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
(13, 'Arts & Craft', 'art-supplies-and-painting_4460x4460.webp', 'A variety of creative supplies including paints, brushes, canvases, and DIY kits for artists of all levels', '2025-02-16 14:13:52', '2025-02-16 14:15:08'),
(14, 'Books', '0009009316-M.jpg', 'A diverse collection of fiction, non-fiction, academic, and self-help books to inspire and educate.', '2025-02-16 14:15:49', '2025-02-16 14:15:49'),
(15, 'Bracelets', 'anchor-bracelet-mens.webp', 'Stylish and trendy bracelets in different designs, from casual to elegant, perfect for any occasion.', '2025-02-16 14:16:19', '2025-02-16 14:16:19'),
(16, 'HandBags', 'leather-handbag-on-bed.webp', 'A selection of fashionable handbags, from everyday totes to elegant purses, to complement your style.', '2025-02-16 14:16:46', '2025-02-16 14:16:46'),
(17, 'Makeup', 'arts-and-crafts-pens-and-paints_4460x4460.webp', 'A wide range of beauty products, including foundations, lipsticks, eyeshadows, and more for a flawless look.', '2025-02-16 14:17:14', '2025-02-16 14:17:14'),
(18, 'Wallets', '461f86b9176ce5c05cb81c84a429988b.jpg_720x720q80.jpg_.webp', 'Durable and stylish wallets to keep your essentials organized, available in various sizes and materials.', '2025-02-16 14:17:40', '2025-02-16 14:17:40'),
(19, 'Stationary', 'dc5137ba54cb536a6646b5a198aa5a5f.jpg_720x720q80.jpg_.webp', 'Essential office and school supplies, including notebooks, pens, planners, and sticky notes.', '2025-02-16 14:17:53', '2025-02-16 14:17:53');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `adress` varchar(50) DEFAULT NULL,
  `service` varchar(50) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `image` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `adress`, `service`, `message`, `image`) VALUES
(1, 'ali', 'az030366@gmail.com', 'abc', 'Mechanical Engineering', 'hello', ''),
(2, 'rafay', 'rafay@gmail.com', 'abcd', 'Mechanical Engineering', 'hello world\r\n', ''),
(3, 'rafay', 'rafay@gmail.com', 'abcd', 'Mechanical Engineering', 'hello world\r\n', ''),
(4, 'rafay', 'rafay@gmail.com', 'abcd', 'Mechanical Engineering', 'hello world\r\n', ''),
(5, 'ali', 'az030366@gmail.com', 'abc', 'Mechanical Engineering', '', NULL),
(6, 'ali', 'az030366@gmail.com', 'abc', 'Mechanical Engineering', '', NULL),
(7, 'ali', 'az030366@gmail.com', 'abc', 'Mechanical Engineering', '', NULL),
(8, 'ali', 'az030366@gmail.com', 'abc', 'Mechanical Engineering', '', NULL),
(9, 'ali', 'az030366@gmail.com', 'abc', 'Mechanical Engineering', '', NULL),
(10, 'ali', 'az030366@gmail.com', 'abc', 'Mechanical Engineering', 'hello world', NULL),
(11, 'ali', 'az030366@gmail.com', 'abc', 'Mechanical Engineering', 'hello world', NULL),
(12, 'ali zaman', 'az030366@gmail.com', 'pechs block 2', 'Mechanical Engineering', 'hello world 1', NULL),
(13, 'Test', 'test@gmail.com', 'P.E.C.H.S block 2', NULL, '12131243214', NULL),
(14, 'Test User', 'test@gmail.com', 'Aptech SFC', NULL, 'Hello, world!', NULL);

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
(2, 'Jane Smith', 'jane.smith@example.com', '0987654321', 'Los Angeles', 'CA', '5678 Oak St', '90001', 'hashed_password2', 'active', '2025-01-22 12:57:35', '2025-01-22 12:57:35'),
(3, 'test', 'test@gmail.com', '03303944082', 'Karachi', 'Pakistan', 'P.E.C.H.S block 2', '74800', '$2y$10$WUyRu3iRMRM1pWSo2amtZ.x7sv5swvbMB7Df0waoXGD9W7uS3NAu2', 'active', '2025-02-14 14:57:24', '2025-02-14 15:00:26');

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
(1, 'abcd@gmail.com', '2025-02-17 06:00:54');

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
(1, 'ORD768404', 3, 'delivered', 135.45, 162.00, '2025-02-17 06:14:54', '2025-02-17 08:02:32'),
(2, 'ORD654805', 3, 'delivered', 40.95, 63.00, '2025-02-17 07:11:01', '2025-02-17 07:11:27');

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
(1, 1, 1, 1, 34.00, '2025-02-17 06:14:54', '2025-02-17 06:14:54'),
(2, 1, 2, 1, 35.00, '2025-02-17 06:14:54', '2025-02-17 06:14:54'),
(3, 1, 3, 3, 60.00, '2025-02-17 06:14:54', '2025-02-17 06:14:54'),
(4, 2, 5, 1, 9.00, '2025-02-17 07:11:01', '2025-02-17 07:11:01'),
(5, 2, 7, 2, 16.00, '2025-02-17 07:11:01', '2025-02-17 07:11:01'),
(6, 2, 8, 2, 14.00, '2025-02-17 07:11:01', '2025-02-17 07:11:01');

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
(1, 14, 'The Art of Being Alone', '...', '8dec15b245b4acd7bd9be0cd7743ef4a.png_200x200q80.png_.webp', 'A2323', 40.00, 34.00, '2025-02-16 14:26:44', '2025-02-16 14:26:44'),
(2, 14, 'Atomic Habits', 'Award Winning Book!', '92494d705b3154b13240b32f0df0e0e2.jpg_200x200q80.jpg_.webp', 'A232134', 50.00, 35.00, '2025-02-16 14:34:10', '2025-02-16 14:34:10'),
(3, 14, 'The Time Maschine', 'Book by HG.Wells', '0009009316-M.webp', 'A123fa', 24.00, 20.00, '2025-02-16 14:35:15', '2025-02-16 14:35:15'),
(4, 14, 'Never Lie', 'By Frieda Mccfadden', 'a01f5108d961b2d8575f3001c3676f8b.jpg_200x200q80.jpg_.webp', 'AA323', 39.00, 25.00, '2025-02-16 14:36:09', '2025-02-16 14:36:09'),
(5, 14, 'The Art of Thinking Clearly', 'By, Robert Gialdini', 'B_163.webp', 'A2easd', 15.00, 9.00, '2025-02-16 14:37:15', '2025-02-16 14:37:15'),
(6, 14, 'The Art of not Overthinking', 'By Shaurya Kapoor', 'B_1830.webp', 'Adsafasfr2', 45.00, 30.00, '2025-02-16 14:38:31', '2025-02-16 14:38:31'),
(7, 13, 'Pain brush set x25', '...', 'paint-bruches-in-bucket_4460x4460 (1).webp', 'AS231', 15.00, 8.00, '2025-02-16 14:39:16', '2025-02-16 14:39:16'),
(8, 13, 'x6 Brush set', '6 Brush set', 'wood-handle-paint-brush-set_925x.webp', 'A231', 9.00, 7.00, '2025-02-16 14:40:02', '2025-02-16 14:40:02'),
(9, 13, 'x24 Colors set', 'lorem ispum dolor sit amet', 'sharpened-pencil-crayons_4460x4460.webp', 'asd23', 12.00, 7.00, '2025-02-16 14:40:46', '2025-02-16 14:40:46');

-- --------------------------------------------------------

--
-- Table structure for table `product_details`
--

CREATE TABLE `product_details` (
  `id` int(11) NOT NULL,
  `prod_id` int(11) DEFAULT NULL,
  `availability` tinyint(1) DEFAULT NULL,
  `stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_details`
--

INSERT INTO `product_details` (`id`, `prod_id`, `availability`, `stock`) VALUES
(1, 1, 1, 49),
(2, 2, 1, 23),
(3, 3, 1, 2),
(4, 4, 1, 8),
(5, 5, 1, 79),
(6, 6, 1, 12),
(7, 7, 1, 8),
(8, 8, 1, 8),
(9, 9, 1, 20);

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
  `rating` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_reviews`
--

INSERT INTO `product_reviews` (`id`, `prod_id`, `review`, `customer_id`, `status`, `rating`, `created_at`, `updated_at`) VALUES
(1, 1, 'Really good book, good quality paper, Highly recommend', 3, 'approved', 5, '2025-02-17 07:45:10', '2025-02-17 07:45:10'),
(2, 7, 'Good quality, with a wide variety of brushes. I like it', 3, 'approved', 4, '2025-02-17 08:06:03', '2025-02-17 08:06:03'),
(3, 8, 'Good product for reasonable price', 3, 'approved', 5, '2025-02-17 08:08:10', '2025-02-17 08:08:10');

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

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `site_title`, `main_logo`, `footer_logo`, `email`, `phone`, `address`, `fb`, `insta`, `x`, `linkedin`, `about`, `created_at`, `updated_at`) VALUES
(1, 'Draftsy', 'logo-rmbgpng.png', NULL, 'draftsy@gmail.com', '123456789', 'A1B2C3', '', '', '', '#', 'About me', '2025-02-14 14:22:11', '2025-02-15 10:11:41');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product_details`
--
ALTER TABLE `product_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_details`
--
ALTER TABLE `product_details`
  ADD CONSTRAINT `product_details_ibfk_1` FOREIGN KEY (`prod_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`prod_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD CONSTRAINT `product_reviews_ibfk_1` FOREIGN KEY (`prod_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_reviews_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
