-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Nov 05, 2022 at 12:50 PM
-- Server version: 8.0.30
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `cart` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `cart`) VALUES
(1667646769, 1, 0x613a313a7b693a313b4f3a32363a224170705c4d6f64656c735c50726f647563745c50726f64756374223a373a7b733a33303a22004170705c4d6f64656c735c50726f647563745c50726f64756374006964223b693a313b733a33323a22004170705c4d6f64656c735c50726f647563745c50726f64756374006e616d65223b733a31303a22436c6561722076696577223b733a34303a22004170705c4d6f64656c735c50726f647563745c50726f64756374006d616e756661637475726572223b733a343a22536f6e79223b733a33353a22004170705c4d6f64656c735c50726f647563745c50726f647563740072656c65617365223b733a31303a22323032322d30332d3132223b733a33323a22004170705c4d6f64656c735c50726f647563745c50726f6475637400636f7374223b643a3339393b733a33363a22004170705c4d6f64656c735c50726f647563745c50726f647563740063617465676f7279223b733a333a22545673223b733a33363a22004170705c4d6f64656c735c50726f647563745c50726f64756374007365727669636573223b613a303a7b7d7d7d),
(1667649504, 2, 0x613a333a7b693a383b4f3a32363a224170705c4d6f64656c735c50726f647563745c50726f64756374223a373a7b733a33303a22004170705c4d6f64656c735c50726f647563745c50726f64756374006964223b693a383b733a33323a22004170705c4d6f64656c735c50726f647563745c50726f64756374006e616d65223b733a31313a2253757065722046726f7374223b733a34303a22004170705c4d6f64656c735c50726f647563745c50726f64756374006d616e756661637475726572223b733a373a2253616d73756e67223b733a33353a22004170705c4d6f64656c735c50726f647563745c50726f647563740072656c65617365223b733a31303a22323032312d30332d3132223b733a33323a22004170705c4d6f64656c735c50726f647563745c50726f6475637400636f7374223b643a3439393b733a33363a22004170705c4d6f64656c735c50726f647563745c50726f647563740063617465676f7279223b733a373a2246726964676573223b733a33363a22004170705c4d6f64656c735c50726f647563745c50726f64756374007365727669636573223b613a303a7b7d7d693a31303b4f3a32363a224170705c4d6f64656c735c50726f647563745c50726f64756374223a373a7b733a33303a22004170705c4d6f64656c735c50726f647563745c50726f64756374006964223b693a31303b733a33323a22004170705c4d6f64656c735c50726f647563745c50726f64756374006e616d65223b733a383a2247616d652d70726f223b733a34303a22004170705c4d6f64656c735c50726f647563745c50726f64756374006d616e756661637475726572223b733a343a2241737573223b733a33353a22004170705c4d6f64656c735c50726f647563745c50726f647563740072656c65617365223b733a31303a22323032322d30342d3132223b733a33323a22004170705c4d6f64656c735c50726f647563745c50726f6475637400636f7374223b643a313639393b733a33363a22004170705c4d6f64656c735c50726f647563745c50726f647563740063617465676f7279223b733a373a224c6170746f7073223b733a33363a22004170705c4d6f64656c735c50726f647563745c50726f64756374007365727669636573223b613a323a7b693a31303b4f3a32363a224170705c4d6f64656c735c536572766963655c53657276696365223a353a7b733a33303a22004170705c4d6f64656c735c536572766963655c53657276696365006964223b693a31303b733a33323a22004170705c4d6f64656c735c536572766963655c536572766963650074797065223b733a373a22696e7374616c6c223b733a33323a22004170705c4d6f64656c735c536572766963655c5365727669636500636f7374223b643a32303b733a33363a22004170705c4d6f64656c735c536572766963655c5365727669636500646561646c696e65223b693a333b733a33363a22004170705c4d6f64656c735c536572766963655c536572766963650063617465676f7279223b733a373a224c6170746f7073223b7d693a363b4f3a32363a224170705c4d6f64656c735c536572766963655c53657276696365223a353a7b733a33303a22004170705c4d6f64656c735c536572766963655c53657276696365006964223b693a363b733a33323a22004170705c4d6f64656c735c536572766963655c536572766963650074797065223b733a383a2264656c6976657279223b733a33323a22004170705c4d6f64656c735c536572766963655c5365727669636500636f7374223b643a32303b733a33363a22004170705c4d6f64656c735c536572766963655c5365727669636500646561646c696e65223b693a31303b733a33363a22004170705c4d6f64656c735c536572766963655c536572766963650063617465676f7279223b733a373a224c6170746f7073223b7d7d7d693a31313b4f3a32363a224170705c4d6f64656c735c50726f647563745c50726f64756374223a373a7b733a33303a22004170705c4d6f64656c735c50726f647563745c50726f64756374006964223b693a31313b733a33323a22004170705c4d6f64656c735c50726f647563745c50726f64756374006e616d65223b733a31333a225265644d65204e6f7465203131223b733a34303a22004170705c4d6f64656c735c50726f647563745c50726f64756374006d616e756661637475726572223b733a363a225869616f6d69223b733a33353a22004170705c4d6f64656c735c50726f647563745c50726f647563740072656c65617365223b733a31303a22323032322d30322d3232223b733a33323a22004170705c4d6f64656c735c50726f647563745c50726f6475637400636f7374223b643a3239393b733a33363a22004170705c4d6f64656c735c50726f647563745c50726f647563740063617465676f7279223b733a31333a224d6f62696c652070686f6e6573223b733a33363a22004170705c4d6f64656c735c50726f647563745c50726f64756374007365727669636573223b613a303a7b7d7d7d);

-- --------------------------------------------------------

--
-- Table structure for table `login_block`
--

CREATE TABLE `login_block` (
  `ip` int UNSIGNED NOT NULL,
  `attempts` int UNSIGNED NOT NULL,
  `end_block` bigint DEFAULT NULL,
  `begin_attempts` bigint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `login_block_log`
--

CREATE TABLE `login_block_log` (
  `id` int UNSIGNED NOT NULL,
  `ip` int UNSIGNED NOT NULL,
  `email` varchar(320) NOT NULL,
  `start_block` timestamp NOT NULL,
  `end_block` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int UNSIGNED NOT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE `order_products` (
  `id` int UNSIGNED NOT NULL,
  `order_id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `order_services`
--

CREATE TABLE `order_services` (
  `order_products_id` int UNSIGNED NOT NULL,
  `services_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `manufacturer` varchar(120) NOT NULL,
  `release` date NOT NULL,
  `cost` decimal(8,2) NOT NULL,
  `category` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `manufacturer`, `release`, `cost`, `category`) VALUES
(1, 'Clear view', 'Sony', '2022-03-12', '399.00', 'TVs'),
(2, 'Game-pro', 'Asus', '2022-04-12', '1699.00', 'Laptops'),
(3, 'RedMe Note 11', 'Xiaomi', '2022-02-22', '299.00', 'Mobile phones'),
(4, 'Super Frost', 'Samsung', '2021-03-12', '499.00', 'Fridges'),
(5, 'Clear view', 'Sony', '2022-03-12', '399.00', 'TVs'),
(6, 'Game-pro', 'Asus', '2022-04-12', '1699.00', 'Laptops'),
(7, 'RedMe Note 11', 'Xiaomi', '2022-02-22', '299.00', 'Mobile phones'),
(8, 'Super Frost', 'Samsung', '2021-03-12', '499.00', 'Fridges'),
(9, 'Clear view', 'Sony', '2022-03-12', '399.00', 'TVs'),
(10, 'Game-pro', 'Asus', '2022-04-12', '1699.00', 'Laptops'),
(11, 'RedMe Note 11', 'Xiaomi', '2022-02-22', '299.00', 'Mobile phones'),
(12, 'Super Frost', 'Samsung', '2021-03-12', '499.00', 'Fridges');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int UNSIGNED NOT NULL,
  `type` varchar(120) NOT NULL,
  `cost` decimal(8,2) NOT NULL,
  `deadline` int NOT NULL,
  `category` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `type`, `cost`, `deadline`, `category`) VALUES
(1, 'warranty', '100.00', 365, 'TVs'),
(2, 'warranty', '50.00', 365, 'Laptops'),
(3, 'warranty', '30.00', 365, 'Mobile phones'),
(4, 'warranty', '50.00', 365, 'Fridges'),
(5, 'delivery', '30.00', 10, 'TVs'),
(6, 'delivery', '20.00', 10, 'Laptops'),
(7, 'delivery', '10.00', 10, 'Mobile phones'),
(8, 'delivery', '50.00', 15, 'Fridges'),
(9, 'install', '20.00', 3, 'TVs'),
(10, 'install', '20.00', 3, 'Laptops'),
(11, 'install', '10.00', 1, 'Mobile phones'),
(12, 'install', '20.00', 3, 'Fridges'),
(13, 'configure', '10.00', 3, 'TVs'),
(14, 'configure', '15.00', 3, 'Laptops'),
(15, 'configure', '10.00', 1, 'Mobile phones'),
(16, 'configure', '10.00', 3, 'Fridges');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(320) NOT NULL,
  `firstname` varchar(120) NOT NULL,
  `lastname` varchar(120) NOT NULL,
  `password` char(255) NOT NULL,
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `firstname`, `lastname`, `password`, `created_date`) VALUES
(1, 'first@net.com', 'Sam', 'Peters', '$2y$10$ABog2hUzfB12qxat3GYJxeiCbnh0P626CBN9.nGLIXHJIoIMoDa76', '2022-11-05 09:57:45'),
(2, 'second@net.com', 'Tania', 'Solid', '$2y$10$Bro709KP8batJaC7RKIr4OvSlIiiLpr//g8JOp76hdQSuDs52GR5q', '2022-11-05 11:57:52');

-- --------------------------------------------------------

--
-- Table structure for table `user_tokens`
--

CREATE TABLE `user_tokens` (
  `id` int UNSIGNED NOT NULL,
  `selector` varchar(255) NOT NULL,
  `validator` char(255) NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `expiration` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `login_block`
--
ALTER TABLE `login_block`
  ADD PRIMARY KEY (`ip`);

--
-- Indexes for table `login_block_log`
--
ALTER TABLE `login_block_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `order_services`
--
ALTER TABLE `order_services`
  ADD PRIMARY KEY (`order_products_id`,`services_id`),
  ADD KEY `services_id` (`services_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login_block_log`
--
ALTER TABLE `login_block_log`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_products`
--
ALTER TABLE `order_products`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_tokens`
--
ALTER TABLE `user_tokens`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_products`
--
ALTER TABLE `order_products`
  ADD CONSTRAINT `order_products_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`),
  ADD CONSTRAINT `order_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `order_services`
--
ALTER TABLE `order_services`
  ADD CONSTRAINT `order_services_ibfk_1` FOREIGN KEY (`order_products_id`) REFERENCES `order_products` (`id`),
  ADD CONSTRAINT `order_services_ibfk_2` FOREIGN KEY (`services_id`) REFERENCES `services` (`id`);

--
-- Constraints for table `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD CONSTRAINT `user_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
