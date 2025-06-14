-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2025 at 06:49 AM
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
-- Database: `accu_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `sender` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `total_price` decimal(65,0) DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `address`, `product_id`, `qty`, `total_price`, `status`, `order_date`) VALUES
(1, 1, 'surabaya', 4, 1, 5000000, 'pending', '2025-06-04 04:41:35');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `picture` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `description`, `stock`, `price`, `picture`) VALUES
(4, 'GS Astra X-100N', 'mobil', 'GS Astra merupakan salah satu rekomendasi aki mobil terbaik. Aki keluaran Astra Group ini menjadi aki kebanggaan masyarakat Indonesia.', 40, 5000000.00, '683f06100a225_aki.jpg'),
(5, 'GS Astra X-100N', 'mobil', 'GS Astra merupakan salah satu rekomendasi aki mobil terbaik. Aki keluaran Astra Group ini menjadi aki kebanggaan masyarakat Indonesia.', 40, 5000000.00, '683f06122358b_aki.jpg'),
(6, 'GS Astra X-100N', 'mobil', 'GS Astra merupakan salah satu rekomendasi aki mobil terbaik. Aki keluaran Astra Group ini menjadi aki kebanggaan masyarakat Indonesia.', 60, 600000.00, '683f0655b78be_aki.jpg'),
(7, 'GS Astra X-100N', 'mobil', 'GS Astra merupakan salah satu rekomendasi aki mobil terbaik. Aki keluaran Astra Group ini menjadi aki kebanggaan masyarakat Indonesia.', 60, 600000.00, '683f065635549_aki.jpg'),
(8, 'GS Astra X-100N', 'mobil', 'GS Astra merupakan salah satu rekomendasi aki mobil terbaik. Aki keluaran Astra Group ini menjadi aki kebanggaan masyarakat Indonesia.', 60, 600000.00, '683f065662e6a_aki.jpg'),
(9, 'GS Astra X-100N', 'mobil', 'GS Astra merupakan salah satu rekomendasi aki mobil terbaik. Aki keluaran Astra Group ini menjadi aki kebanggaan masyarakat Indonesia.', 60, 600000.00, '683f0656976a0_aki.jpg'),
(10, 'GS Astra X-100N', 'mobil', 'GS Astra merupakan salah satu rekomendasi aki mobil terbaik. Aki keluaran Astra Group ini menjadi aki kebanggaan masyarakat Indonesia.', 60, 600000.00, '683f0656d8a49_aki.jpg'),
(11, 'GS Astra X-100N', 'mobil', 'GS Astra merupakan salah satu rekomendasi aki mobil terbaik. Aki keluaran Astra Group ini menjadi aki kebanggaan masyarakat Indonesia.', 60, 600000.00, '683f06571d25d_aki.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'dimas', '17agustus45', 'user'),
(2, '3130023010', 'SQSTCCRJO', 'user'),
(3, 'testuser', 'hailsatan22', 'user'),
(4, 'admin1', '17agustus45', 'user'),
(5, 'test', 'admin123', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
