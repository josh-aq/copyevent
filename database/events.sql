-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2026 at 06:26 PM
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
-- Database: `copyeventintel`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `full_name` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('client','supplier','coordinator','admin') DEFAULT 'client',
  `status` enum('approved','pending','rejected') DEFAULT 'approved',
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `middle_initial` varchar(10) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `municipality` varchar(100) DEFAULT NULL,
  `barangay` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `business_name` varchar(150) DEFAULT NULL,
  `business_address` text DEFAULT NULL,
  `valid_id` varchar(255) DEFAULT NULL,
  `business_permit` varchar(255) DEFAULT NULL,
  `face_capture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `full_name`, `email`, `password`, `role`, `status`, `first_name`, `last_name`, `middle_initial`, `age`, `gender`, `phone`, `province`, `municipality`, `barangay`, `postal_code`, `business_name`, `business_address`, `valid_id`, `business_permit`, `face_capture`, `created_at`) VALUES
(1, 'admin', 'Admin User', 'admin@test.com', '$2y$10$5OEhKWqJU/XxtA0w/smNG.bkkgHwonn7lt3HQc498.S0AxBqWTEve', 'admin', 'approved', 'Admin', 'User', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-03 09:28:20'),
(2, 'client', 'Client User', 'client@test.com', '$2y$10$5OEhKWqJU/XxtA0w/smNG.bkkgHwonn7lt3HQc498.S0AxBqWTEve', 'client', 'approved', 'Client', 'User', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-03 09:28:20'),
(3, 'supplier', 'Supplier User', 'supplier@test.com', '$2y$10$5OEhKWqJU/XxtA0w/smNG.bkkgHwonn7lt3HQc498.S0AxBqWTEve', 'supplier', 'approved', 'Supplier', 'User', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Events Supplier Inc', 'Apalit, Pampanga', NULL, NULL, NULL, '2026-06-03 09:28:20'),
(4, 'coordinator', 'Vincent Tolentino', 'coord@test.com', '$2y$10$5OEhKWqJU/XxtA0w/smNG.bkkgHwonn7lt3HQc498.S0AxBqWTEve', 'coordinator', 'approved', 'Vincent', 'Tolentino', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Apalit Event Coordination', 'Apalit, Pampanga', NULL, NULL, NULL, '2026-06-03 09:28:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
