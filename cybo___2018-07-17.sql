-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2018 at 12:03 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cybo`
--

-- --------------------------------------------------------

--
-- Table structure for table `seat_map`
--

CREATE TABLE `seat_map` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf32_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf32_vietnamese_ci NOT NULL,
  `group_id` int(11) DEFAULT '1',
  `email` varchar(100) COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `permisson` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_vietnamese_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `group_id`, `email`, `permisson`) VALUES
(4, 'admin', '$2y$10$O/3fShfxDZDgQq/mFjpB2eJ1DyAeHtQybYNLeNHmdR4x7CXVfVrv.', 1, 'admin@admin.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

CREATE TABLE `user_group` (
  `name` varchar(100) COLLATE utf32_vietnamese_ci NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_vietnamese_ci;

--
-- Dumping data for table `user_group`
--

INSERT INTO `user_group` (`name`, `id`) VALUES
('Unassigned users', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_seat`
--

CREATE TABLE `user_seat` (
  `user_id` int(11) DEFAULT NULL,
  `seat_map_id` int(11) DEFAULT NULL,
  `x` float DEFAULT NULL,
  `y` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_vietnamese_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `seat_map`
--
ALTER TABLE `seat_map`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_group_id` (`group_id`);

--
-- Indexes for table `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_seat`
--
ALTER TABLE `user_seat`
  ADD KEY `user_seat_user_id` (`user_id`),
  ADD KEY `user_seat_seat_map` (`seat_map_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `seat_map`
--
ALTER TABLE `seat_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_group`
--
ALTER TABLE `user_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_group_id` FOREIGN KEY (`group_id`) REFERENCES `user_group` (`id`);

--
-- Constraints for table `user_seat`
--
ALTER TABLE `user_seat`
  ADD CONSTRAINT `user_seat_seat_map` FOREIGN KEY (`seat_map_id`) REFERENCES `seat_map` (`id`),
  ADD CONSTRAINT `user_seat_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
