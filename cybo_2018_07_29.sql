-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2018 at 01:13 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

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
-- Table structure for table `seat_maps`
--

CREATE TABLE `seat_maps` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `img` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `user_group_id` int(10) unsigned DEFAULT '1',
  `email` varchar(100) DEFAULT NULL,
  `permission` tinyint(4) NOT NULL DEFAULT '0',
  `username` varchar(100) NOT NULL,
  `short_name` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `img` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_user_group_id_foreign` (`user_group_id`),
  CONSTRAINT `users_user_group_id_foreign` FOREIGN KEY (`user_group_id`) REFERENCES `user_groups` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_groups_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_seats`
--

CREATE TABLE `user_seats` (
  `user_id` int(10) unsigned NOT NULL,
  `seat_map_id` int(10) unsigned NOT NULL,
  `x` smallint(6) NOT NULL,
  `y` smallint(6) NOT NULL,
  KEY `user_seats_user_id_foreign` (`user_id`),
  KEY `user_seats_seat_map_id_foreign` (`seat_map_id`),
  CONSTRAINT `user_seats_seat_map_id_foreign` FOREIGN KEY (`seat_map_id`) REFERENCES `seat_maps` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_seats_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_vietnamese_ci;
ALTER TABLE `user_seat`
  ADD PRIMARY KEY (`user_id`,`seat_map_id`);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `seat_maps`
--
ALTER TABLE `seat_maps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`) USING BTREE,
  ADD KEY `users_group_id` (`user_group_id`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `user_seats`
--
ALTER TABLE `user_seats`
  ADD PRIMARY KEY (`user_id`,`seat_map_id`),
  ADD KEY `seat_map_id` (`seat_map_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `seat_maps`
--
ALTER TABLE `seat_maps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_group_id` FOREIGN KEY (`user_group_id`) REFERENCES `user_groups` (`id`);

--
-- Constraints for table `user_seats`
--
ALTER TABLE `user_seats`
  ADD CONSTRAINT `seat_map_id` FOREIGN KEY (`seat_map_id`) REFERENCES `seat_maps` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_id_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
