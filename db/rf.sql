-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2024 at 03:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rf`
--

-- --------------------------------------------------------

--
-- Table structure for table `rf_user`
--

CREATE TABLE `rf_user` (
  `user_id` int(16) NOT NULL,
  `name` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `ph_no` int(13) NOT NULL,
  `pass` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_booking`
--

CREATE TABLE `tbl_booking` (
  `booking_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `booking_date` varchar(15) NOT NULL,
  `leave_date` varchar(15) NOT NULL,
  `isDeleted` int(2) NOT NULL COMMENT '1-Deleted, 0-none'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_booking`
--

INSERT INTO `tbl_booking` (`booking_id`, `room_id`, `user_id`, `booking_date`, `leave_date`, `isDeleted`) VALUES
(1, 2, 2, '2022-06-06', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_booking_user`
--

CREATE TABLE `tbl_booking_user` (
  `booking_user_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_age` int(11) NOT NULL,
  `user_gender` varchar(50) NOT NULL,
  `isDeleted` int(2) NOT NULL DEFAULT 0 COMMENT '1-Deleted, 0-none'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_booking_user`
--

INSERT INTO `tbl_booking_user` (`booking_user_id`, `booking_id`, `user_name`, `user_age`, `user_gender`, `isDeleted`) VALUES
(1, 1, 'Subhankar Barman', 22, 'Male', 0),
(2, 1, 'Bhaskar Sarkar', 22, 'Male', 0),
(3, 1, 'Dipankar Roy', 22, 'Male', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_room`
--

CREATE TABLE `tbl_room` (
  `room_id` int(11) NOT NULL,
  `room_title` text NOT NULL,
  `room_type` int(2) NOT NULL DEFAULT 3 COMMENT '1-Single, 2-double, 3-family',
  `room_price` int(11) NOT NULL,
  `room_location` text NOT NULL,
  `room_img` varchar(255) NOT NULL,
  `room_srch_key_words` text NOT NULL,
  `isBooked` int(2) NOT NULL DEFAULT 0 COMMENT '0-not,1-booked',
  `room_owner_user_id` int(11) NOT NULL,
  `isDeleted` int(2) NOT NULL DEFAULT 0 COMMENT '0-notDeleted,1-Deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_room`
--

INSERT INTO `tbl_room` (`room_id`, `room_title`, `room_type`, `room_price`, `room_location`, `room_img`, `room_srch_key_words`, `isBooked`, `room_owner_user_id`, `isDeleted`) VALUES
(1, 'Rudra Vila', 1, 2000, 'Front of MAKAUT', '1', 'makaut , single', 0, 1, 0),
(2, 'Roy Vaban', 2, 3000, 'Jaguli', '', 'Jaguli , double', 1, 1, 0),
(3, 'Mess', 2, 1500, 'Mangalbari', '', 'mangalbari , malda , family', 0, 1, 0),
(4, 'Sivaji Castle', 3, 5000, 'Kalyani', '', 'kalyani , family', 0, 1, 0),
(5, 'Roy House', 3, 5000, 'Gangarampur', '', 'gangarampur , family', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_mobile` varchar(15) NOT NULL,
  `user_address` text NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `isAdmin` int(2) NOT NULL DEFAULT 0,
  `isDeleted` int(2) NOT NULL DEFAULT 0 COMMENT '1-Deleted, 0-No',
  `user_citizenship` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `user_name`, `user_mobile`, `user_address`, `user_password`, `isAdmin`, `isDeleted`, `user_citizenship`) VALUES
(7, 'ram', '123', 'qq', '202cb962ac59075b964b07152d234b70', 0, 0, '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rf_user`
--
ALTER TABLE `rf_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_booking`
--
ALTER TABLE `tbl_booking`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `tbl_booking_user`
--
ALTER TABLE `tbl_booking_user`
  ADD PRIMARY KEY (`booking_user_id`);

--
-- Indexes for table `tbl_room`
--
ALTER TABLE `tbl_room`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rf_user`
--
ALTER TABLE `rf_user`
  MODIFY `user_id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_booking`
--
ALTER TABLE `tbl_booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_booking_user`
--
ALTER TABLE `tbl_booking_user`
  MODIFY `booking_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_room`
--
ALTER TABLE `tbl_room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
