-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 29, 2025 at 03:37 AM
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
-- Database: `event`
--

-- --------------------------------------------------------

--
-- Table structure for table `audience`
--

CREATE TABLE `audience` (
  `id` int NOT NULL,
  `name` text NOT NULL,
  `contact` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `event_id` int NOT NULL,
  `payment_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0= pending, 1 =Paid',
  `attendance_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1= present',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = for verification,  1 = confirmed,2= declined',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `audience`
--

INSERT INTO `audience` (`id`, `name`, `contact`, `email`, `address`, `event_id`, `payment_status`, `attendance_status`, `status`, `date_created`) VALUES
(2, 'George Wilson', '+18456-5455-55', 'gwilson@sample.com', 'Sample', 1, 1, 0, 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `address` text NOT NULL,
  `description` text NOT NULL,
  `venue_name` varchar(150) NOT NULL,
  `schedule` datetime NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Public, 2-Private',
  `audience_capacity` int NOT NULL,
  `payment_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Free, 2=payable',
  `attendance_fees` double NOT NULL DEFAULT '0',
  `banner` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `address`, `description`, `venue_name`, `schedule`, `type`, `audience_capacity`, `payment_type`, `attendance_fees`, `banner`, `date_created`) VALUES
(5, 'Science Fair', 'Motijheel, Dhaka', 'when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &amp;#x2019;Content here, content here&amp;#x2019;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &amp;#x2019;lorem ipsum&amp;#x2019; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like', 'Mitford stedium', '2025-01-31 12:01:00', 1, 150, 1, 300, '1602647220_images3.jpg', '2025-01-24 12:03:28'),
(6, 'demo demo', 'Rajshahi, Khulna, Barishal', '&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; text-align: justify;&quot;&gt;or randomised words which don&rsquo;t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn&rsquo;t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a h&lt;/span&gt;', 'MilonMala Stedium', '2025-05-03 18:00:00', 1, 50, 2, 500, '1737709800_celebration-hall-with-full-guests.jpg', '2025-01-24 14:55:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1=Admin,2=Staff',
  `address` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `type`, `address`, `created_at`) VALUES
(1, 'Administrator', 'admin@gmail.com', '01795891261', '21232f297a57a5a743894a0e4a801fc3', 1, '0', '2025-01-24 17:41:39'),
(2, 'demo demo', 'demo@gmail.com', '01672821', '827ccb0eea8a706c4c34a16891f84e7b', 2, 'demo', '2025-01-24 22:48:14'),
(3, 'Jahid Hasan', 'demo1@gmail.com', '113231', '8542516f8870173d7d1daba1daaaf0a1', 2, 'demo', '2025-01-24 22:54:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audience`
--
ALTER TABLE `audience`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audience`
--
ALTER TABLE `audience`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
