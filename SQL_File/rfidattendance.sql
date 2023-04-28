-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2023 at 06:07 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rfidattendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin-login`
--

CREATE TABLE `admin-login` (
  `slno` int(11) NOT NULL,
  `admin_uid` varchar(100) NOT NULL,
  `admin_pass` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin-login`
--

INSERT INTO `admin-login` (`slno`, `admin_uid`, `admin_pass`) VALUES
(1, '9590651068', '$2y$10$g2T6HG40H1ETqHGJNatho.U4pT5rCe5ERkMdGO7eqMg.SoVjbpEle'),
(2, '9663536294', '$2y$10$HHab.tU58lZu1MAdEuOf6.gfF9Wp1.4HfKaBTzHjtO90SEqpzKDdq');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `slno` int(11) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `user_fname` varchar(30) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `user_reg_no` varchar(20) NOT NULL,
  `user_number` varchar(10) NOT NULL,
  `user_address` varchar(100) NOT NULL,
  `add_card` varchar(5) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users-login`
--

CREATE TABLE `users-login` (
  `slno` int(11) NOT NULL,
  `user_uid` varchar(10) NOT NULL,
  `user_pass` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users-logs`
--

CREATE TABLE `users-logs` (
  `slno` int(11) NOT NULL,
  `date` varchar(30) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_reg_no` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `user_number` varchar(10) NOT NULL,
  `user_login` varchar(30) NOT NULL,
  `user_logout` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin-login`
--
ALTER TABLE `admin-login`
  ADD PRIMARY KEY (`slno`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`slno`),
  ADD UNIQUE KEY `user_id` (`user_id`,`user_reg_no`,`user_number`);

--
-- Indexes for table `users-login`
--
ALTER TABLE `users-login`
  ADD PRIMARY KEY (`slno`),
  ADD UNIQUE KEY `user_uid` (`user_uid`);

--
-- Indexes for table `users-logs`
--
ALTER TABLE `users-logs`
  ADD PRIMARY KEY (`slno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin-login`
--
ALTER TABLE `admin-login`
  MODIFY `slno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `slno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users-login`
--
ALTER TABLE `users-login`
  MODIFY `slno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users-logs`
--
ALTER TABLE `users-logs`
  MODIFY `slno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
