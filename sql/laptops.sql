-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2022 at 06:33 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laptops`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `gender` enum('M','F') NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `laptop_specs`
--

CREATE TABLE `laptop_specs` (
  `laptop_id` int(11) NOT NULL,
  `Name` varchar(60) DEFAULT NULL,
  `Brand` varchar(40) DEFAULT NULL,
  `CPU` varchar(40) DEFAULT NULL,
  `GPU` varchar(40) DEFAULT NULL,
  `RAM` int(11) DEFAULT NULL,
  `Price` int(11) DEFAULT NULL,
  `Image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `laptop_specs`
--

INSERT INTO `laptop_specs` (`laptop_id`, `Name`, `Brand`, `CPU`, `GPU`, `RAM`, `Price`, `Image`) VALUES
(2, 'Acer Nitro 5', 'Acer', 'Intel® Core™ i5-9300H', 'NVIDIA® GeForce RTX™ 2060', 16, 18800, 'img/Nitro%205.png'),
(3, 'Dell Alienware m15 R5', 'Dell', 'Intel® Core™ i7-11800H', 'NVIDIA® GeForce® RTX™ 3080', 32, 55555, 'img/Alienware.png'),
(4, 'Acer Predator Triton 500 SE', 'Acer', 'Intel® Core™ i7-11800H', 'NVIDIA® GeForce® RTX™ 3070', 64, 149999, 'img/Predator.png'),
(6, 'HP OMEN 15', 'HP', 'AMD Ryzen™ 9 5900HX', 'NVIDIA® GeForce® RTX™ 3070', 64, 150000, 'img/Omen.png'),
(7, 'Lenovo Legion 5', 'Lenovo', 'AMD Ryzen™ 7 4800H', 'NVIDIA® GeForce® GTX 1650', 16, 21500, 'img/Legion%205.png'),
(8, 'Lenovo Legion 7i', 'Lenovo', 'Intel® Core™ i9-10980HK', 'NVIDIA® GeForce® RTX™ 2080 Super Max-Q', 32, 44000, 'img/Legion%207i.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `laptop_specs`
--
ALTER TABLE `laptop_specs`
  ADD PRIMARY KEY (`laptop_id`),
  ADD UNIQUE KEY `Image` (`Image`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `laptop_specs`
--
ALTER TABLE `laptop_specs`
  MODIFY `laptop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
