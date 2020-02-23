-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2020 at 07:38 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `storepos`
--

-- --------------------------------------------------------

--
-- Table structure for table `daily_sales`
--

CREATE TABLE `daily_sales` (
  `Id` int(11) NOT NULL,
  `OrderId` int(11) NOT NULL,
  `ItemCode` varchar(10) NOT NULL,
  `CategoryCode` int(11) NOT NULL,
  `ItemName` varchar(20) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `OriginalPrice` double NOT NULL,
  `SellingPrice` double NOT NULL,
  `TotalPrice` double NOT NULL,
  `OrderDate` datetime NOT NULL,
  `ReturnStatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `day_end`
--

CREATE TABLE `day_end` (
  `DayId` int(11) NOT NULL,
  `OpenDate` datetime NOT NULL,
  `CloseDate` datetime NOT NULL,
  `StartFloat` double NOT NULL,
  `EndFloat` double NOT NULL,
  `ItemCount` int(11) NOT NULL,
  `Status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `item_category`
--

CREATE TABLE `item_category` (
  `CategoryCode` int(11) NOT NULL,
  `Category` varchar(20) NOT NULL,
  `CategorySinhala` text NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `DateEntered` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `item_category`
--

INSERT INTO `item_category` (`CategoryCode`, `Category`, `CategorySinhala`, `Status`, `DateEntered`) VALUES
(1, 'Cement', 'සිමෙන්ති', 1, '2020-02-15 00:00:00'),
(2, 'Nails', 'ඇන\r\n', 1, '2020-02-15 00:00:00'),
(3, 'screws', 'ස්ක්රූ ඇන ', 1, '2020-02-15 00:00:00'),
(4, 'lights', 'විදුලි පහන්', 1, '2020-02-15 00:00:00'),
(5, 'Paints', 'තීන්ත', 1, '2020-02-15 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `item_list`
--

CREATE TABLE `item_list` (
  `ItemCode` int(11) NOT NULL,
  `supplierCode` varchar(10) NOT NULL,
  `CategoryCode` int(11) NOT NULL,
  `ItemName` varchar(20) NOT NULL,
  `ItemNameSinhala` varchar(20) NOT NULL,
  `SellingPrice` double NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `OtherDescriptions` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `item_list`
--

INSERT INTO `item_list` (`ItemCode`, `supplierCode`, `CategoryCode`, `ItemName`, `ItemNameSinhala`, `SellingPrice`, `CreatedDate`, `Status`, `OtherDescriptions`) VALUES
(1, '00023', 1, 'Sanstha', 'සංස්ථා', 1000, '2020-02-15 00:00:00', 1, 'sanstha cement for tiles'),
(2, '00025', 1, 'Tokyo', 'ටෝකියෝ', 1000, '2020-02-15 00:00:00', 1, 'ටෝකියෝ සාමාන්‍ය පොර්ට්ලන්ඩ් සිමෙන්ති'),
(3, '00026', 1, 'Ramco', 'රැම්කෝ', 930, '2020-02-15 00:00:00', 1, 'රැම්කෝ අඩු මිල සිමෙන්ති \r\n'),
(4, '3265', 2, '1\" Thin', '1\" කද  හීනි ', 200, '2020-02-15 00:00:00', 1, '1\" Thin nails '),
(5, '3265', 2, '1.5\" Fat', '1.5\" කද මහත', 200, '2020-02-15 00:00:00', 1, '1.5\" කද මහත ඇන '),
(6, '478536', 4, '3w led', '3w එල්.ඊ.ඩී.', 220, '2020-02-15 00:00:00', 1, '3w එල්.ඊ.ඩී. බල්බ්'),
(7, '68782', 4, '5W LED', '5w එල්.ඊ.ඩී.', 320, '2020-02-15 00:00:00', 1, '5w එල්.ඊ.ඩී.');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_history`
--

CREATE TABLE `purchase_history` (
  `PurchaseCode` int(11) NOT NULL,
  `ItemCode` int(11) NOT NULL,
  `ItemName` text NOT NULL,
  `CategoryCode` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `PurchasePrice` double NOT NULL,
  `SellingPrice` double NOT NULL,
  `ProfitMargin` int(11) NOT NULL,
  `Supplier` int(11) NOT NULL,
  `PurchaseDate` datetime NOT NULL,
  `Status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `remaining_list`
--

CREATE TABLE `remaining_list` (
  `ItemCode` varchar(20) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `Status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `status`) VALUES
(1, 'Dushan', '$2y$10$csGWTB87uMKUsb4r74kLTOj3lY1o8MIaQimPJFsagU9diytiOE1dG', '2020-02-09 17:19:13', 0),
(3, 'Eranga', '$2y$10$K3CLiFQOMCGqqL9i2nyJm.IRRZzotmaO8NAjXywpthA3y0g3W0dre', '2020-02-17 20:45:36', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daily_sales`
--
ALTER TABLE `daily_sales`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `day_end`
--
ALTER TABLE `day_end`
  ADD PRIMARY KEY (`DayId`);

--
-- Indexes for table `item_category`
--
ALTER TABLE `item_category`
  ADD PRIMARY KEY (`CategoryCode`);

--
-- Indexes for table `item_list`
--
ALTER TABLE `item_list`
  ADD PRIMARY KEY (`ItemCode`);

--
-- Indexes for table `purchase_history`
--
ALTER TABLE `purchase_history`
  ADD PRIMARY KEY (`PurchaseCode`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daily_sales`
--
ALTER TABLE `daily_sales`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `day_end`
--
ALTER TABLE `day_end`
  MODIFY `DayId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_category`
--
ALTER TABLE `item_category`
  MODIFY `CategoryCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `item_list`
--
ALTER TABLE `item_list`
  MODIFY `ItemCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `purchase_history`
--
ALTER TABLE `purchase_history`
  MODIFY `PurchaseCode` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
