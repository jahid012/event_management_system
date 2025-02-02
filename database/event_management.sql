-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 02, 2025 at 05:16 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `audience`
--

CREATE TABLE `audience` (
  `id` int NOT NULL,
  `event_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0= pending, 1 =Paid',
  `attendance_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1= present',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = for verification,  1 = confirmed,2= declined',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audience`
--

INSERT INTO `audience` (`id`, `event_id`, `name`, `phone`, `email`, `address`, `payment_status`, `attendance_status`, `status`, `date_created`) VALUES
(17, 13, 'Jahid Hasan', '1234324', 'demo@gmail.com', 'demo', 0, 0, 1, '2025-02-02 23:14:37'),
(18, 13, 'demo demo', '01672821', 'demo@gmail.com', 'demo', 0, 0, 1, '2025-02-02 23:14:53'),
(19, 13, 'Jahid Hasan', '89698686', 'demo@gmail.com', 'demo', 0, 0, 1, '2025-02-02 23:15:07'),
(20, 6, 'Jahid Hasan', '87575859', 'demo@gmail.com', 'demo', 0, 0, 1, '2025-02-02 23:15:26'),
(21, 9, 'demo demo', '9868609', 'demo@gmail.com', 'demo', 0, 0, 1, '2025-02-02 23:15:39'),
(22, 9, 'demo demo', '01672821', 'demo@gmail.com', 'demo', 0, 0, 1, '2025-02-02 23:15:55');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `venue_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schedule` datetime NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Public, 2-Private',
  `audience_capacity` int NOT NULL,
  `payment_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Free, 2=payable',
  `attendance_fees` decimal(10,2) NOT NULL DEFAULT '0.00',
  `banner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `user_id`, `name`, `address`, `description`, `venue_name`, `schedule`, `type`, `audience_capacity`, `payment_type`, `attendance_fees`, `banner`, `date_created`) VALUES
(5, 1, 'Annual Tech Conference', '123 Main Street, Anytown, CA 91234', 'when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &rsquo;Content here, content here&rsquo;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &rsquo;lorem ipsum&rsquo; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the likeJoin us for the premier tech event of the year, featuring keynote speakers, workshops, and networking opportunities with industry leaders.', 'Grand Ballroom', '2025-01-29 12:01:00', 1, 150, 1, 300.00, '1602647220_images3.jpg', '2025-01-24 12:03:28'),
(6, 1, 'Summer Music Festival', '456 Oak Avenue, Springfield, IL 62701', 'A weekend of live music, food, and fun in the sun! Featuring a diverse lineup of bands and artists.', 'Convention Center', '2025-05-03 18:00:00', 1, 2, 2, 500.00, '1737709800_celebration-hall-with-full-guests.jpg', '2025-01-24 14:55:37'),
(8, 1, 'Community Food Fair', '789 Pine Lane, Smallville, OH 45678', 'Celebrate local cuisine with food trucks, cooking demonstrations, and family-friendly activities.', 'City Park', '2025-01-29 12:01:00', 1, 150, 1, 300.00, '1602647220_images3.jpg', '2025-01-24 12:03:28'),
(9, 1, 'Business Networking Mixer', '101 Elm Street, Big City, NY 10001', 'Connect with professionals from various industries and expand your network at this exciting event.', 'Community Hall', '2025-05-21 18:00:00', 1, 50, 2, 500.00, '1737709800_celebration-hall-with-full-guests.jpg', '2025-01-24 14:55:37'),
(10, 1, 'Charity Gala Dinner', '222 Maple Drive, Suburbia, NJ 07000', 'Be the first to see our latest innovation! Join us for the unveiling of our groundbreaking new product.', 'Tech Hub', '2025-05-23 18:00:00', 1, 50, 2, 500.00, '1737709800_celebration-hall-with-full-guests.jpg', '2025-01-24 14:55:37'),
(13, 1, 'Art Exhibition', '333 Cherry Court, Hillside, GA 30303', 'Discover the works of talented local artists at this captivating exhibition.', 'Outdoor Amphitheater', '2025-02-28 21:00:00', 1, 5, 2, 100.00, '1738509780_470873739_2866096803557197_5838531931039365827_n.jpg', '2025-02-02 21:22:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1=Admin,2=Staff',
  `address` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `type`, `address`, `created_at`) VALUES
(1, 'Administrator', 'admin@gmail.com', '01795891261', '21232f297a57a5a743894a0e4a801fc3', 1, '0', '2025-01-24 17:41:39'),
(2, 'demo demo', 'demo@gmail.com', '01672821', '827ccb0eea8a706c4c34a16891f84e7b', 2, 'demo', '2025-01-24 22:48:14'),
(3, 'Jahid Hasan', 'demo1@gmail.com', '113231', '8542516f8870173d7d1daba1daaaf0a1', 2, 'demo', '2025-01-24 22:54:38'),
(4, 'Jahid Hasan', 'demo123@gmail.com', '0167284321', 'e10adc3949ba59abbe56e057f20f883e', 2, 'demo', '2025-02-02 02:39:00'),
(5, 'demo demo', 'dem3o@gmail.com', '016723821', 'e10adc3949ba59abbe56e057f20f883e', 2, 'demo', '2025-02-02 05:19:41'),
(6, 'demo demo', 'demo12@gmail.com', '1234324', 'e10adc3949ba59abbe56e057f20f883e', 2, 'address', '2025-02-02 21:03:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audience`
--
ALTER TABLE `audience`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audience`
--
ALTER TABLE `audience`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audience`
--
ALTER TABLE `audience`
  ADD CONSTRAINT `audience_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
