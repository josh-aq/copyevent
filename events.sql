-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2026 at 10:27 AM
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
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `event_type` varchar(100) DEFAULT NULL,
  `theme` varchar(120) DEFAULT NULL,
  `budget` decimal(12,2) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `event_time` time DEFAULT NULL,
  `guest_count` int(11) DEFAULT NULL,
  `venue_name` varchar(150) DEFAULT NULL,
  `venue_status` varchar(50) DEFAULT 'pending',
  `venue_address` text DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'planning',
  `clothes` varchar(255) DEFAULT NULL,
  `clothes_status` varchar(50) DEFAULT 'pending',
  `catering` varchar(255) DEFAULT NULL,
  `catering_status` varchar(50) DEFAULT 'pending',
  `host` varchar(255) DEFAULT NULL,
  `host_status` varchar(50) DEFAULT 'pending',
  `soundsnlights` varchar(255) DEFAULT NULL,
  `soundsnlights_status` varchar(50) DEFAULT 'pending',
  `photographer` varchar(255) DEFAULT NULL,
  `photographer_status` varchar(50) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `user_id`, `title`, `event_type`, `theme`, `budget`, `event_date`, `event_time`, `guest_count`, `venue_name`, `venue_status`, `venue_address`, `latitude`, `longitude`, `status`, `clothes`, `clothes_status`, `catering`, `catering_status`, `host`, `host_status`, `soundsnlights`, `soundsnlights_status`, `photographer`, `photographer_status`, `created_at`) VALUES
(1, 2, 'Birthday Event', 'Birthday', NULL, NULL, '2026-06-16', '20:35:00', 123, NULL, 'pending', NULL, NULL, NULL, 'planning', '', 'pending', '', 'pending', '', 'pending', '', 'pending', '', 'pending', '2026-06-03 09:31:50'),
(2, 2, 'Anniversary Event', 'Anniversary', NULL, NULL, '2026-06-25', '12:09:00', 130, NULL, 'pending', NULL, NULL, NULL, 'planning', NULL, 'pending', NULL, 'pending', NULL, 'pending', NULL, 'pending', NULL, 'pending', '2026-06-03 13:09:31'),
(3, 2, 'Reunion Event', 'Reunion', NULL, NULL, '2026-06-12', '21:18:00', 130, 'Casa De Alvin', 'pending', NULL, NULL, NULL, 'planning', NULL, 'pending', NULL, 'pending', NULL, 'pending', NULL, 'pending', NULL, 'pending', '2026-06-03 13:15:16'),
(4, 2, 'Wedding Event', 'Wedding', NULL, NULL, '2026-06-10', '19:10:00', 132, 'Casa De Alvin', 'pending', NULL, NULL, NULL, 'planning', '', 'pending', NULL, 'pending', NULL, 'pending', NULL, 'pending', NULL, 'pending', '2026-06-04 07:10:41'),
(5, 2, 'Birthday Event', 'Birthday', NULL, NULL, '2026-06-18', '19:24:00', 132, 'Casa De Alvin', 'pending', NULL, NULL, NULL, 'planning', '', 'pending', 'Catering', 'pending', 'Vincent Tolentino', 'pending', 'RM Lights & Sounds', 'pending', '', 'pending', '2026-06-04 07:22:39'),
(6, 2, 'Birthday Event', 'Birthday', NULL, NULL, '2026-06-18', '18:50:00', 123, 'Casa De Alvin', 'pending', NULL, NULL, NULL, 'planning', '', 'pending', 'Catering', 'pending', 'Mama Dhel San Antonio', 'pending', 'RM Lights & Sounds', 'pending', 'Photographer', 'pending', '2026-06-04 07:51:16'),
(7, 2, 'Christening Event', 'Christening', NULL, NULL, '2026-06-10', '19:58:00', 145, '', 'pending', NULL, NULL, NULL, 'planning', '', 'pending', 'Antonio\'s Catering', 'pending', '', 'pending', '', 'pending', '', 'pending', '2026-06-04 07:58:23'),
(8, 2, 'Reunion Event', 'Reunion', NULL, NULL, '2026-07-11', '16:03:00', 122, '', 'pending', NULL, NULL, NULL, 'planning', '', 'pending', '', 'pending', '', 'pending', '', 'pending', 'John Doe', 'pending', '2026-06-04 08:00:33'),
(9, 2, 'Christening Event', 'Christening', NULL, NULL, '2026-06-10', '20:15:00', 133, 'Casa De Alvin', 'pending', NULL, NULL, NULL, 'planning', 'Fabrica MNL Inc.', 'pending', 'Antonio\'s Catering', 'pending', 'Mama Dhel San Antonio', 'pending', 'RM Lights & Sounds', 'pending', 'John Doe', 'pending', '2026-06-04 08:15:25'),
(10, 2, 'Birthday Event', 'Birthday', NULL, NULL, '2026-06-09', '20:20:00', 134, 'Casa De Alvin', 'pending', NULL, NULL, NULL, 'planning', 'Fabrica MNL Inc.', 'pending', 'Antonio\'s Catering', 'pending', 'Vincent Tolentino', 'pending', 'RM Lights & Sounds', 'pending', 'John Doe', 'pending', '2026-06-04 08:20:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
