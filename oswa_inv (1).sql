-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 17, 2022 at 06:06 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oswa_inv`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(4, 'bottles'),
(5, 'rubber'),
(7, 'Textile');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(11) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `file_name`, `file_type`) VALUES
(1, 'trust.jpg', 'image/jpeg'),
(2, 'index2.jpeg', 'image/jpeg'),
(3, 'logo-black.png', 'image/png'),
(4, 'black-solid-icon-boy-patient-boy-patient-logo-pills-medical-black-solid-icon-boy-patient-pills-medical-147675883.jpg', 'image/jpeg'),
(6, '6430688_preview.png', 'image/png');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` varchar(50) DEFAULT NULL,
  `buy_price` decimal(25,2) DEFAULT NULL,
  `sale_price` decimal(25,2) NOT NULL,
  `categorie_id` int(11) UNSIGNED NOT NULL,
  `media_id` int(11) DEFAULT 0,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `quantity`, `buy_price`, `sale_price`, `categorie_id`, `media_id`, `date`) VALUES
(1, 'fanta', '13', '90.00', '120.00', 4, 1, '2022-06-22 17:21:51'),
(2, 'coca cola', '10', '100.00', '130.00', 4, 2, '2022-06-22 17:22:31'),
(4, 'Bio Clear 1', '93', '1000.00', '1500.00', 7, 4, '2022-07-06 16:41:12'),
(5, 'Rufaida Youghut', '5', '600.00', '900.00', 5, 2, '2022-07-08 15:23:02');

-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE `receipts` (
  `id` int(11) NOT NULL,
  `saleId` int(11) UNSIGNED NOT NULL,
  `buyerName` varchar(50) NOT NULL,
  `buyerPhone` varchar(15) NOT NULL,
  `date` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `receipts`
--

INSERT INTO `receipts` (`id`, `saleId`, `buyerName`, `buyerPhone`, `date`) VALUES
(1, 1, 'muhammad', '08169895827', '2022-06-22'),
(2, 2, 'muhammad', '08169895827', '2022-06-22'),
(3, 3, 'muhammad', '08169895827', '2022-06-22'),
(4, 4, 'idris', '07011922884', '2022-07-01'),
(5, 5, 'idris', '07011922884', '2022-07-01'),
(6, 6, 'idris', '07011922884', '2022-07-01'),
(7, 7, 'iii', '123', '2022-07-01'),
(8, 8, 'iii', '123', '2022-07-01'),
(9, 9, 'bello', '1234', '2022-07-01'),
(10, 10, 'bello', '1234', '2022-07-01'),
(11, 11, 'idi', '444', '2022-07-01'),
(12, 12, 'idi', '444', '2022-07-01'),
(13, 13, 'q', '11', '2022-07-01'),
(14, 14, 'q', '11', '2022-07-01'),
(15, 15, 'a', '55', '2022-07-01'),
(16, 16, 'a', '55', '2022-07-01'),
(17, 17, 'muhammad', '08169895827', '2022-07-01'),
(18, 18, 'muhammad', '07011922884', '2022-07-06'),
(19, 19, 'muhammad', '07011922884', '2022-07-06'),
(20, 20, 'muhammad', '08169895827', '2022-07-07'),
(21, 21, 'muhammad', '08169895827', '2022-07-07'),
(22, 22, 'idris', '08169895827', '2022-07-08'),
(23, 23, 'idris', '08169895827', '2022-07-08'),
(24, 24, 'okljuhydtxursy', '1122', '2022-07-17'),
(25, 25, 'iii', '222', '2022-07-17');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(25,2) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `product_id`, `qty`, `price`, `date`) VALUES
(1, 1, 2, '120.00', '2022-06-22'),
(2, 2, 2, '130.00', '2022-06-22'),
(4, 1, 10, '120.00', '2022-07-01'),
(5, 2, 10, '130.00', '2022-07-01'),
(7, 1, 3, '120.00', '2022-07-01'),
(8, 2, 4, '130.00', '2022-07-01'),
(10, 2, 4, '130.00', '2022-07-01'),
(11, 1, 2, '120.00', '2022-07-01'),
(12, 2, 2, '130.00', '2022-07-01'),
(13, 1, 2, '120.00', '2022-07-01'),
(14, 2, 1, '130.00', '2022-07-01'),
(15, 1, 2, '120.00', '2022-07-01'),
(16, 2, 2, '130.00', '2022-07-01'),
(17, 1, 12, '120.00', '2022-07-01'),
(18, 4, 20, '1400.00', '2022-07-06'),
(19, 2, 15, '110.00', '2022-07-06'),
(20, 4, 14, '1400.00', '2022-07-07'),
(21, 1, 20, '120.00', '2022-07-07'),
(22, 5, 15, '850.00', '2022-07-08'),
(23, 1, 2, '120.00', '2022-07-08'),
(24, 4, 3, '1500.00', '2022-07-17'),
(25, 1, 2, '120.00', '2022-07-17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_level` int(11) NOT NULL,
  `image` varchar(255) DEFAULT 'no_image.jpg',
  `status` int(1) NOT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `user_level`, `image`, `status`, `last_login`) VALUES
(1, ' Admin User', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 'no_image.jpg', 1, '2022-07-17 17:27:30'),
(2, 'Special User new', 'Special', '7c4a8d09ca3762af61e59520943dc26494f8941b', 2, 'no_image.jpg', 1, '2022-06-10 18:03:58'),
(4, 'muhammed garba', 'star', '7c4a8d09ca3762af61e59520943dc26494f8941b', 3, 'no_image.jpg', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(150) NOT NULL,
  `group_level` int(11) NOT NULL,
  `group_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id`, `group_name`, `group_level`, `group_status`) VALUES
(1, 'Admin', 1, 1),
(2, 'special', 2, 1),
(7, 'user', 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `categorie_id` (`categorie_id`),
  ADD KEY `media_id` (`media_id`);

--
-- Indexes for table `receipts`
--
ALTER TABLE `receipts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receipts_ibfk_1` (`saleId`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_level` (`user_level`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_level` (`group_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `receipts`
--
ALTER TABLE `receipts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `FK_products` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `SK` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_user` FOREIGN KEY (`user_level`) REFERENCES `user_groups` (`group_level`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
