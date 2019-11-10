-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2019 at 11:04 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jasper_jeans_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `log_id` int(255) NOT NULL,
  `log_msg` longtext NOT NULL,
  `log_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`log_id`, `log_msg`, `log_datetime`) VALUES
(1, 'PRODUCT 1 has been added to products.', '2019-11-05 22:33:39'),
(2, 'PRODUCT 1 details has been modified.', '2019-11-05 22:34:06'),
(3, 'Shaira Bucag ordered PRODUCT 1 for BUS SAMPLE.', '2019-11-05 22:34:42'),
(4, 'Order ID #1 has been approved.', '2019-11-05 22:35:03');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(255) NOT NULL,
  `order_name` varchar(100) NOT NULL,
  `order_product` mediumint(8) NOT NULL,
  `order_quantity` int(10) NOT NULL,
  `order_bus` varchar(100) NOT NULL,
  `order_date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_status` enum('PENDING','APPROVED') NOT NULL DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_name`, `order_product`, `order_quantity`, `order_bus`, `order_date_added`, `order_status`) VALUES
(1, 'Shaira Bucag', 1, 2, 'BUS SAMPLE', '2019-11-05 22:34:42', 'APPROVED');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(255) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_description` longtext NOT NULL,
  `product_amount` varchar(45) NOT NULL,
  `product_seller` longtext NOT NULL,
  `product_date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `product_active_flag` enum('Y','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_description`, `product_amount`, `product_seller`, `product_date_added`, `product_active_flag`) VALUES
(1, 'PRODUCT 1', 'PRODUCT 1 Description', '1,000.00', 'Tristan Rosales', '2019-11-05 22:33:39', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `product_qty`
--

CREATE TABLE `product_qty` (
  `product_id` mediumint(8) NOT NULL,
  `quantity` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_qty`
--

INSERT INTO `product_qty` (`product_id`, `quantity`) VALUES
(1, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD UNIQUE KEY `log_id_UNIQUE` (`log_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `order_id_UNIQUE` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_id_UNIQUE` (`product_id`),
  ADD UNIQUE KEY `product_name_UNIQUE` (`product_name`);

--
-- Indexes for table `product_qty`
--
ALTER TABLE `product_qty`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_id_UNIQUE` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `log_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
