-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2026 at 06:41 AM
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
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `coordinator` varchar(255) DEFAULT NULL,
  `coordinator_status` varchar(255) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `user_id`, `title`, `event_type`, `theme`, `budget`, `event_date`, `event_time`, `guest_count`, `venue_name`, `venue_status`, `venue_address`, `latitude`, `longitude`, `status`, `clothes`, `clothes_status`, `catering`, `catering_status`, `host`, `host_status`, `soundsnlights`, `soundsnlights_status`, `photographer`, `photographer_status`, `coordinator`, `coordinator_status`, `created_at`) VALUES
(1, 2, 'Birthday Event', 'Birthday', NULL, NULL, '2026-06-16', '20:35:00', 123, NULL, 'pending', NULL, NULL, NULL, 'planning', '', 'pending', '', 'pending', '', 'pending', '', 'pending', '', 'pending', NULL, NULL, '2026-06-03 09:31:50'),
(2, 2, 'Anniversary Event', 'Anniversary', NULL, NULL, '2026-06-25', '12:09:00', 130, NULL, 'pending', NULL, NULL, NULL, 'planning', NULL, 'pending', NULL, 'pending', NULL, 'pending', NULL, 'pending', NULL, 'pending', NULL, NULL, '2026-06-03 13:09:31'),
(3, 2, 'Reunion Event', 'Reunion', NULL, NULL, '2026-06-12', '21:18:00', 130, 'Casa De Alvin', 'pending', NULL, NULL, NULL, 'planning', NULL, 'pending', NULL, 'pending', NULL, 'pending', NULL, 'pending', NULL, 'pending', NULL, NULL, '2026-06-03 13:15:16'),
(4, 2, 'Wedding Event', 'Wedding', NULL, NULL, '2026-06-10', '19:10:00', 132, 'Casa De Alvin', 'pending', NULL, NULL, NULL, 'planning', '', 'pending', NULL, 'pending', NULL, 'pending', NULL, 'pending', NULL, 'pending', NULL, NULL, '2026-06-04 07:10:41'),
(5, 2, 'Birthday Event', 'Birthday', NULL, NULL, '2026-06-18', '19:24:00', 132, 'Casa De Alvin', 'pending', NULL, NULL, NULL, 'planning', '', 'pending', 'Catering', 'pending', 'Vincent Tolentino', 'pending', 'RM Lights & Sounds', 'pending', '', 'pending', NULL, NULL, '2026-06-04 07:22:39'),
(6, 2, 'Birthday Event', 'Birthday', NULL, NULL, '2026-06-18', '18:50:00', 123, 'Casa De Alvin', 'pending', NULL, NULL, NULL, 'planning', '', 'pending', 'Catering', 'pending', 'Mama Dhel San Antonio', 'pending', 'RM Lights & Sounds', 'pending', 'Photographer', 'pending', NULL, NULL, '2026-06-04 07:51:16'),
(7, 2, 'Christening Event', 'Christening', NULL, NULL, '2026-06-10', '19:58:00', 145, '', 'pending', NULL, NULL, NULL, 'planning', '', 'pending', 'Antonio\'s Catering', 'accepted', '', 'pending', '', 'pending', '', 'pending', NULL, NULL, '2026-06-04 07:58:23'),
(8, 2, 'Reunion Event', 'Reunion', NULL, NULL, '2026-07-11', '16:03:00', 122, '', 'pending', NULL, NULL, NULL, 'planning', '', 'pending', '', 'pending', '', 'pending', '', 'pending', 'John Doe', 'accepted', NULL, NULL, '2026-06-04 08:00:33'),
(10, 2, 'Birthday Event', 'Birthday', NULL, NULL, '2026-06-09', '20:20:00', 134, 'Casa De Alvin', 'pending', NULL, NULL, NULL, 'planning', 'Aquino\'s Clothing', 'declined', 'Antonio\'s Catering', 'pending', 'Vincent Tolentino', 'pending', 'RM Lights & Sounds', 'accepted', 'John Doe', 'accepted', NULL, NULL, '2026-06-04 08:20:46'),
(11, 2, 'Wedding Event', 'Wedding', NULL, NULL, '2026-06-12', '11:58:00', 122, 'Casa de Alvin', 'pending', NULL, NULL, NULL, 'planning', 'Aquino\'s Clothing', 'accepted', 'Antonio\'s Catering', 'declined', 'Vincent Tolentino', 'pending', 'RM Lights & Sounds', 'pending', 'John Doe', 'accepted', NULL, NULL, '2026-06-04 14:58:28'),
(13, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', NULL, NULL, NULL, 'planning', NULL, 'pending', NULL, 'pending', NULL, 'pending', NULL, 'pending', NULL, 'pending', 'Vincent Tolentino', 'declined', '2026-06-04 15:40:35'),
(16, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', NULL, NULL, NULL, 'planning', NULL, 'pending', NULL, 'pending', NULL, 'pending', NULL, 'pending', NULL, 'pending', 'Vincent Tolentino', 'accepted', '2026-06-04 16:08:32'),
(17, 2, 'Gender Reveal Event', 'Gender Reveal', NULL, NULL, '2026-06-11', '16:28:00', 122, 'Casa de Alvin', 'pending', NULL, NULL, NULL, 'planning', 'Aquino\'s Clothing', 'pending', 'Antonio\'s Catering', 'pending', 'Vincent Tolentino', 'pending', 'RM Lights & Sounds', 'pending', 'John Doe', 'pending', NULL, 'pending', '2026-06-05 05:30:52'),
(18, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', NULL, NULL, NULL, 'planning', NULL, 'pending', NULL, 'pending', NULL, 'pending', NULL, 'pending', NULL, 'pending', 'Vincent Tolentino', 'pending', '2026-06-05 05:32:18'),
(19, 2, 'Birthday Event', 'Birthday', NULL, NULL, '2026-06-30', '11:33:00', 133, 'Casa de Alvin', 'pending', NULL, NULL, NULL, 'planning', 'Aquino\'s Clothing', 'pending', 'Antonio\'s Catering', 'pending', 'Vincent Tolentino', 'pending', 'RM Lights & Sounds', 'pending', 'John Doe', 'pending', NULL, 'pending', '2026-06-20 03:31:41');

-- --------------------------------------------------------

--
-- Table structure for table `event_services`
--

CREATE TABLE `event_services` (
  `id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `service_name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_services`
--

INSERT INTO `event_services` (`id`, `event_id`, `service_name`, `created_at`) VALUES
(1, 1, 'venue', '2026-06-03 09:31:50'),
(2, 1, 'clothes', '2026-06-03 09:31:50'),
(3, 1, 'catering', '2026-06-03 09:31:50'),
(4, 1, 'host', '2026-06-03 09:31:50'),
(5, 1, 'sounds_lights', '2026-06-03 09:31:50'),
(6, 1, 'photographer', '2026-06-03 09:31:50'),
(7, 2, 'venue', '2026-06-03 13:09:31'),
(8, 2, 'clothes', '2026-06-03 13:09:31'),
(9, 2, 'catering', '2026-06-03 13:09:31'),
(10, 2, 'host', '2026-06-03 13:09:31'),
(11, 2, 'sounds_lights', '2026-06-03 13:09:31'),
(12, 2, 'photographer', '2026-06-03 13:09:31'),
(13, 3, 'venue', '2026-06-03 13:15:16'),
(14, 3, 'clothes', '2026-06-03 13:15:16'),
(15, 3, 'catering', '2026-06-03 13:15:16'),
(16, 3, 'host', '2026-06-03 13:15:16'),
(17, 3, 'sounds_lights', '2026-06-03 13:15:16'),
(18, 3, 'photographer', '2026-06-03 13:15:16'),
(19, 4, 'venue', '2026-06-04 07:10:41'),
(20, 4, 'clothes', '2026-06-04 07:10:41'),
(21, 4, 'catering', '2026-06-04 07:10:41'),
(22, 4, 'host', '2026-06-04 07:10:41'),
(23, 4, 'sounds_lights', '2026-06-04 07:10:41'),
(24, 4, 'photographer', '2026-06-04 07:10:41'),
(25, 5, 'venue', '2026-06-04 07:22:39'),
(26, 5, 'clothes', '2026-06-04 07:22:39'),
(27, 5, 'catering', '2026-06-04 07:22:39'),
(28, 5, 'host', '2026-06-04 07:22:39'),
(29, 5, 'sounds_lights', '2026-06-04 07:22:39'),
(30, 5, 'photographer', '2026-06-04 07:22:39'),
(31, 6, 'venue', '2026-06-04 07:51:16'),
(32, 6, 'clothes', '2026-06-04 07:51:16'),
(33, 6, 'catering', '2026-06-04 07:51:16'),
(34, 6, 'host', '2026-06-04 07:51:16'),
(35, 6, 'sounds_lights', '2026-06-04 07:51:16'),
(36, 6, 'photographer', '2026-06-04 07:51:16'),
(37, 7, 'clothes', '2026-06-04 07:58:23'),
(38, 7, 'catering', '2026-06-04 07:58:23'),
(39, 8, 'photographer', '2026-06-04 08:00:33'),
(40, 9, 'venue', '2026-06-04 08:15:25'),
(41, 9, 'clothes', '2026-06-04 08:15:25'),
(42, 9, 'catering', '2026-06-04 08:15:25'),
(43, 9, 'host', '2026-06-04 08:15:25'),
(44, 9, 'sounds_lights', '2026-06-04 08:15:25'),
(45, 9, 'photographer', '2026-06-04 08:15:25'),
(46, 10, 'venue', '2026-06-04 08:20:46'),
(47, 10, 'clothes', '2026-06-04 08:20:46'),
(48, 10, 'catering', '2026-06-04 08:20:46'),
(49, 10, 'host', '2026-06-04 08:20:46'),
(50, 10, 'sounds_lights', '2026-06-04 08:20:46'),
(51, 10, 'photographer', '2026-06-04 08:20:46'),
(52, 11, 'venue', '2026-06-04 14:58:28'),
(53, 11, 'clothes', '2026-06-04 14:58:28'),
(54, 11, 'catering', '2026-06-04 14:58:28'),
(55, 11, 'host', '2026-06-04 14:58:28'),
(56, 11, 'sounds_lights', '2026-06-04 14:58:28'),
(57, 11, 'photographer', '2026-06-04 14:58:28'),
(58, 14, 'venue', '2026-06-04 15:42:12'),
(59, 14, 'clothes', '2026-06-04 15:42:12'),
(60, 14, 'catering', '2026-06-04 15:42:12'),
(61, 14, 'host', '2026-06-04 15:42:12'),
(62, 14, 'sounds_lights', '2026-06-04 15:42:12'),
(63, 14, 'photographer', '2026-06-04 15:42:12'),
(64, 15, 'venue', '2026-06-04 16:08:25'),
(65, 15, 'clothes', '2026-06-04 16:08:25'),
(66, 15, 'catering', '2026-06-04 16:08:25'),
(67, 15, 'host', '2026-06-04 16:08:25'),
(68, 15, 'sounds_lights', '2026-06-04 16:08:25'),
(69, 15, 'photographer', '2026-06-04 16:08:25'),
(70, 17, 'venue', '2026-06-05 05:30:52'),
(71, 17, 'clothes', '2026-06-05 05:30:52'),
(72, 17, 'catering', '2026-06-05 05:30:52'),
(73, 17, 'host', '2026-06-05 05:30:52'),
(74, 17, 'sounds_lights', '2026-06-05 05:30:52'),
(75, 17, 'photographer', '2026-06-05 05:30:52'),
(76, 19, 'venue', '2026-06-20 03:31:41'),
(77, 19, 'clothes', '2026-06-20 03:31:41'),
(78, 19, 'catering', '2026-06-20 03:31:41'),
(79, 19, 'host', '2026-06-20 03:31:41'),
(80, 19, 'sounds_lights', '2026-06-20 03:31:41'),
(81, 19, 'photographer', '2026-06-20 03:31:41');

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--

CREATE TABLE `guests` (
  `guest_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `qr_code` varchar(100) DEFAULT NULL,
  `rsvp_status` varchar(50) DEFAULT 'pending',
  `attended` tinyint(1) DEFAULT 0,
  `scanned_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invitations`
--

CREATE TABLE `invitations` (
  `invitation_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `theme_color` varchar(20) DEFAULT NULL,
  `font_style` varchar(80) DEFAULT 'Segoe UI',
  `button_text` varchar(100) DEFAULT NULL,
  `background_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invitations`
--

INSERT INTO `invitations` (`invitation_id`, `event_id`, `title`, `message`, `theme_color`, `font_style`, `button_text`, `background_image`, `created_at`) VALUES
(1, 1, 'You\'re Invited to Birthday Event', 'Please confirm your attendance.', '#f3c547', 'Segoe UI', 'Confirm RSVP', NULL, '2026-06-03 09:31:50'),
(2, 2, 'You\'re Invited to Anniversary Event', 'Please confirm your attendance.', '#f3c547', 'Segoe UI', 'Confirm RSVP', NULL, '2026-06-03 13:09:31'),
(3, 3, 'You\'re Invited to Reunion Event', 'Please confirm your attendance.', '#f3c547', 'Segoe UI', 'Confirm RSVP', NULL, '2026-06-03 13:15:16'),
(4, 4, 'You\'re Invited to Wedding Event', 'Please confirm your attendance.', '#f3c547', 'Segoe UI', 'Confirm RSVP', NULL, '2026-06-04 07:10:41'),
(5, 5, 'You\'re Invited to Birthday Event', 'Please confirm your attendance.', '#f3c547', 'Segoe UI', 'Confirm RSVP', NULL, '2026-06-04 07:22:39'),
(6, 6, 'You\'re Invited to Birthday Event', 'Please confirm your attendance.', '#f3c547', 'Segoe UI', 'Confirm RSVP', NULL, '2026-06-04 07:51:16'),
(7, 7, 'You\'re Invited to Christening Event', 'Please confirm your attendance.', '#f3c547', 'Segoe UI', 'Confirm RSVP', NULL, '2026-06-04 07:58:23'),
(8, 8, 'You\'re Invited to Reunion Event', 'Please confirm your attendance.', '#f3c547', 'Segoe UI', 'Confirm RSVP', NULL, '2026-06-04 08:00:33'),
(9, 9, 'You\'re Invited to Christening Event', 'Please confirm your attendance.', '#f3c547', 'Segoe UI', 'Confirm RSVP', NULL, '2026-06-04 08:15:25'),
(10, 10, 'You\'re Invited to Birthday Event', 'Please confirm your attendance.', '#f3c547', 'Segoe UI', 'Confirm RSVP', NULL, '2026-06-04 08:20:46'),
(11, 11, 'You\'re Invited to Wedding Event', 'Please confirm your attendance.', '#f3c547', 'Segoe UI', 'Confirm RSVP', NULL, '2026-06-04 14:58:28'),
(12, 14, 'You\'re Invited to Racing Event', 'Please confirm your attendance.', '#f3c547', 'Segoe UI', 'Confirm RSVP', NULL, '2026-06-04 15:42:12'),
(13, 15, 'You\'re Invited to Class Event', 'Please confirm your attendance.', '#f3c547', 'Segoe UI', 'Confirm RSVP', NULL, '2026-06-04 16:08:25'),
(14, 17, 'You\'re Invited to Gender Reveal Event', 'Please confirm your attendance.', '#f3c547', 'Segoe UI', 'Confirm RSVP', NULL, '2026-06-05 05:30:52'),
(15, 19, 'You\'re Invited to Birthday Event', 'Please confirm your attendance.', '#f3c547', 'Segoe UI', 'Confirm RSVP', NULL, '2026-06-20 03:31:41');

-- --------------------------------------------------------

--
-- Table structure for table `post_comments`
--

CREATE TABLE `post_comments` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_likes`
--

CREATE TABLE `post_likes` (
  `like_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_services`
--

CREATE TABLE `supplier_services` (
  `service_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `rating` decimal(3,2) DEFAULT 5.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier_services`
--

INSERT INTO `supplier_services` (`service_id`, `user_id`, `category`, `name`, `description`, `price`, `address`, `latitude`, `longitude`, `rating`, `created_at`) VALUES
(1, 3, 'Venue', 'Casa de Alvin', 'Elegant venue for weddings and birthdays', 25000.00, 'Apalit, Pampanga', 14.9533000, 120.7690000, 4.90, '2026-06-03 09:28:20'),
(2, 3, 'Catering', 'Antonio\'s Catering', 'Food package for 50-150 guests', 18000.00, 'Apalit, Pampanga', 14.9550000, 120.7700000, 4.80, '2026-06-03 09:28:20'),
(3, 3, 'Host', 'Vincent Tolentino', 'Experienced MC for formal and casual events', 7000.00, 'Apalit, Pampanga', 14.9500000, 120.7650000, 4.70, '2026-06-03 09:28:20'),
(4, 3, 'Photographer', 'John Doe', 'Photo coverage and edited photos', 12000.00, 'Apalit, Pampanga', 14.9510000, 120.7680000, 4.80, '2026-06-03 09:28:20'),
(5, 3, 'Sounds & Lights', 'RM Lights & Sounds', 'Audio system, microphones, lighting rig', 15000.00, 'Apalit, Pampanga', 14.9540000, 120.7660000, 4.60, '2026-06-03 09:28:20'),
(8, 3, 'Clothing', 'Aquino\'s Clothing', 'This is where you find the most elegant and beautiful clothes for your events', 5000.00, 'Apalit, Pampanga', NULL, NULL, 5.00, '2026-06-04 14:57:19');

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

-- --------------------------------------------------------

--
-- Table structure for table `user_posts`
--

CREATE TABLE `user_posts` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `likes` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `event_services`
--
ALTER TABLE `event_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`guest_id`);

--
-- Indexes for table `invitations`
--
ALTER TABLE `invitations`
  ADD PRIMARY KEY (`invitation_id`);

--
-- Indexes for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`like_id`),
  ADD UNIQUE KEY `unique_like` (`post_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `supplier_services`
--
ALTER TABLE `supplier_services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_posts`
--
ALTER TABLE `user_posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `created_at` (`created_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `event_services`
--
ALTER TABLE `event_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `guests`
--
ALTER TABLE `guests`
  MODIFY `guest_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invitations`
--
ALTER TABLE `invitations`
  MODIFY `invitation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `post_comments`
--
ALTER TABLE `post_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_likes`
--
ALTER TABLE `post_likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier_services`
--
ALTER TABLE `supplier_services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_posts`
--
ALTER TABLE `user_posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD CONSTRAINT `post_comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `user_posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD CONSTRAINT `post_likes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `user_posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_posts`
--
ALTER TABLE `user_posts`
  ADD CONSTRAINT `user_posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
