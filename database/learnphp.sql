-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 07, 2026 at 07:49 AM
-- Server version: 10.11.14-MariaDB-0ubuntu0.24.04.1
-- PHP Version: 8.3.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `learnphp`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `slug` varchar(180) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `image`, `created_at`) VALUES
(3, 'rth', 'trhtrh', 'uploads/745faf5d7ac061fa45d615a4263583a4.jpg', '2026-10-19 03:58:06'),
(5, 'Lori', 'Lori', 'uploads/f0e0b04d58933f87dbbcba8968fddffe.jpg', '2026-10-19 03:59:05'),
(7, 'Marius', 'm', 'uploads/c8a0d1c9ba493df43baa03d6f5340e71.jpg', '2026-10-19 03:59:42'),
(11, 'g', '5', 'uploads/12bf25d1910b0b3cfd941b3ed6448ee8.jpg', '2026-10-19 04:11:16'),
(13, 'Marius', 'rrr', 'uploads/3a200d172513702190550059f828116a.jpg', '2026-10-19 04:11:53');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categoryID` int(11) NOT NULL,
  `categoryName` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categoryID`, `categoryName`, `created_at`) VALUES
(1, 'electronice', '2026-10-18 07:29:31'),
(2, 'calculator', '2026-10-18 11:29:44'),
(3, 'frigidere', '2026-10-18 11:29:54');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'Marius', 'admin@example.com', 'hello', 'the test massage', '2026-10-31 13:25:02');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_code` varchar(20) DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(190) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `status` enum('active','blocked') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_code`, `name`, `email`, `phone`, `avatar`, `status`, `created_at`) VALUES
(1, 'CUST-001', 'Rosie Silva133', 'rosie@example.com', '+1 234 567 890', NULL, 'active', '2024-01-11 22:00:00'),
(2, 'CUST-002', 'Aidyn Cody', 'aidyn@example.com', '+1 555 000 123', NULL, 'active', '2024-01-31 22:00:00'),
(3, 'CUST-003', 'John Doe', 'john.d@example.com', '+44 7700 900077', NULL, 'blocked', '2024-03-09 22:00:00'),
(4, 'CUST-004', 'Alice Smith', 'alice.s@example.com', '+1 987 654 321', NULL, 'active', '2024-04-04 21:00:00'),
(5, 'CUST-006', 'Molestiae ipsam22', 'manmarius42@yahoo.com', '1234567890', NULL, 'active', '2026-10-26 16:50:43'),
(7, '#cust1245', 'valerius', 'valerius@gmail.com', '1234567824', NULL, 'active', '2026-10-28 07:13:38');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` varchar(30) NOT NULL DEFAULT 'completed',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `total`, `status`, `created_at`) VALUES
(13, 1, 700.00, 'completed', '2026-10-26 16:01:00'),
(14, 1, 540.00, 'completed', '2026-10-26 16:01:00'),
(15, 2, 245.50, 'completed', '2026-10-26 16:01:00'),
(16, 4, 400.00, 'completed', '2026-10-26 16:01:00'),
(17, 4, 250.00, 'completed', '2026-10-26 16:01:00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productID` int(14) NOT NULL,
  `productCode` varchar(100) NOT NULL,
  `categoryID` int(11) NOT NULL,
  `productName` varchar(100) NOT NULL,
  `listPrice` varchar(100) NOT NULL,
  `information` varchar(250) NOT NULL,
  `short_description` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Activ',
  `quantity` int(11) NOT NULL,
  `stock_status` varchar(50) NOT NULL DEFAULT 'in_stock',
  `image` varchar(255) DEFAULT NULL,
  `old_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productID`, `productCode`, `categoryID`, `productName`, `listPrice`, `information`, `short_description`, `status`, `quantity`, `stock_status`, `image`, `old_price`) VALUES
(6, '32010', 1, 'televizor samsung', '3200', '', '', 'Activ', 0, '', NULL, NULL),
(7, '32010', 1, 'tv smart', '1500', '', '', 'Activ', 0, '', NULL, NULL),
(17, '32010q11', 1, 'televizor samsung', '3200', 'informatie scurta', 'descriere scurta', 'Activ', 0, '', NULL, NULL),
(19, '32010', 1, 'tv 1300', '2300', '', '', 'Activ', 0, '', NULL, NULL),
(20, '150045', 1, 'tv smart 2300', '6300', '', '', 'Activ', 0, '', NULL, NULL),
(21, '6200', 1, 'laptopt hp', '6500', '', '', 'Activ', 0, '', NULL, NULL),
(28, '5210345', 1, 'frigider Artic', '123', 'information', 'short information', 'active', 3, 'in_stock', 'uploads/products/product_6aed83838e89e4.82243896.jpg', 20.00),
(29, '542100', 1, 'Mouse', '50321', 'long information', 'mose shorr information', 'active', 10, 'in_stock', 'uploads/products/product_6aed83cd6059a3.69576107.jpg', 45612.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `two_factor_secret` varchar(255) DEFAULT NULL,
  `two_factor_pending_secret` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `photo`, `password`, `created_at`, `role`, `two_factor_secret`, `two_factor_pending_secret`) VALUES
(7, 'x-man11', 'Baciu', 'baciu@yahoo.com', 'uploads/1758447850_man_natura.jpg', '$2y$10$LvsgsZ2MfLLgbsSsOyO13uk8pc.5XmRN58e4xiAwqEIHWGfO.DLtW', '2025-09-21 06:44:10', 'admin', NULL, NULL),
(8, 'vasile344', 'Vasile', 'vasile@gmail.com', 'uploads/1758450631_1758450198_20151004_155332.jpg', '$2y$10$ITdd0IE5bjAomz/PpaUS5e/66IAxG7ynEoZEks3RKPnLV4FLZK1/y', '2025-09-21 07:30:31', 'user', NULL, NULL),
(10, 'Adinayyy', 'Adina', 'adina@yahoo.com', 'uploads/093c8dcb8905f128468d8887f4503f5c.jpeg', '$2y$10$Yit3UPN5sh80rfYTI4pa.OkRmUKkP8Wu0B1BuEXQj49qMNvND5kLm', '2026-10-31 10:29:17', 'user', NULL, NULL),
(11, 'Bacu11', 'Baciu', 'baciu@gmail', 'uploads/users/377e21f86c6f735892043d47e0dfdffb.jpeg', '$2y$10$BsWiBuggeMbL6zPmIuQWf.Ah.6jxWeWajFPvFRzsL4qZNjBiM.t32', '2026-10-31 16:02:39', 'user', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `customer_code` (`customer_code`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `productID` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
