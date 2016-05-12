-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2016 at 06:09 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vinareate`
--

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

CREATE TABLE `district` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `province_id` int(11) NOT NULL,
  `type` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`id`, `name`, `province_id`, `type`) VALUES
(5, 'bình chánh', 35, 'Huyện'),
(6, 'hoc môn', 35, 'Huyện'),
(7, ' cần giờ', 35, 'Huyện'),
(9, '12', 0, 'Quận'),
(10, '11', 0, 'Quận'),
(20, '20', 0, 'Quận'),
(24, 'tân phú', 35, 'Quận'),
(25, 'Tân Bình', 35, 'Quận'),
(27, 'Bình Thạnh', 35, 'Quận'),
(28, '16', 35, 'Quận'),
(29, '10', 35, 'Quận'),
(31, '66', 35, 'Quận'),
(55, '10', 35, 'Huyện'),
(60, 'Củ Chi', 29, 'Quận'),
(63, 'Thủ đức', 35, 'Quận');

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE `province` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `province`
--

INSERT INTO `province` (`id`, `name`, `type`) VALUES
(29, 'Bình Dương', ''),
(35, 'Hồ chí minh', ''),
(41, 'Đồng Nai', ''),
(42, 'Long An', ''),
(43, 'Vũng Tàu', ''),
(55, 'Hà Nội', ''),
(57, 'Hải Phòng', ''),
(59, 'Bình Phước', ''),
(65, 'Đà Nẳng', ''),
(71, 'Hà Tỉnh 2', ''),
(72, 'Nghệ An', ''),
(73, 'Tiền Giang', ''),
(74, 'Hà Tỉnh', '');

-- --------------------------------------------------------

--
-- Table structure for table `ward`
--

CREATE TABLE `ward` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `province_id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ward`
--

INSERT INTO `ward` (`id`, `name`, `type`, `province_id`, `district_id`) VALUES
(1, '5', 'phường', 0, 1),
(3, '2', 'Phường', 0, 0),
(4, '3', 'Phường', 0, 0),
(6, '6', 'Phường', 0, 0),
(7, '7', 'Phường', 0, 0),
(8, '9', 'Phường', 0, 0),
(9, 'cat lai', 'Phường', 29, 26),
(12, '9', 'Phường', 35, 27),
(13, 'hoc mon  phuong 444', 'Phường', 35, 6),
(14, 'hoc mon  phuong', 'Phường', 35, 6),
(18, 'hoc mon  xã', 'Xã', 35, 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ward`
--
ALTER TABLE `ward`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `district`
--
ALTER TABLE `district`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT for table `province`
--
ALTER TABLE `province`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
--
-- AUTO_INCREMENT for table `ward`
--
ALTER TABLE `ward`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
