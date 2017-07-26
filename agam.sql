-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 26, 2017 at 10:25 AM
-- Server version: 5.7.18-0ubuntu0.16.04.1
-- PHP Version: 7.0.18-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agam`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `name`, `company`, `address`, `email`, `phone`) VALUES
(1, 'admin', '83878c91171338902e0fe0fb97a8c47a', 'Telo Master', 'Telo, Inc.', 'Telo City', 'usertelo@useri.us', '080989999');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `ido` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `tanki_id` int(11) NOT NULL,
  `ispaid` int(1) DEFAULT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `volume` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ido`, `owner_id`, `tanki_id`, `ispaid`, `datetime`, `volume`) VALUES
(13, 1, 1, NULL, '2017-07-25 11:44:36', 5),
(24, 2, 14, NULL, '2017-07-26 03:20:27', 5);

-- --------------------------------------------------------

--
-- Table structure for table `owners`
--

CREATE TABLE `owners` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` char(64) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(60) NOT NULL,
  `address` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `owners`
--

INSERT INTO `owners` (`id`, `username`, `password`, `salt`, `name`, `company`, `phone`, `email`, `address`) VALUES
(1, 'penggunator', 'c0581de2b20cd4bd50e6c528344898c6e016a631f89646ddf81392f7c2ee0d81', '5d0cf57761e74365', 'Penggunator Maximus', 'Penggunarit, Inc.', '0000000000', 'penggunator@maxim.us', 'Di hatimu'),
(2, 'sapitenan', '6d8e921dd95df60bebc46f953e345c949156b229d84aa8c927ad4297b3ac408b', '2f966ef959a9f4e9', 'Sapi Tenan', 'Sapi Holdings, LLC.', '08080808080', 'sapitenan@moo.io', 'Sapiland Residence');

-- --------------------------------------------------------

--
-- Table structure for table `tanki`
--

CREATE TABLE `tanki` (
  `id` int(11) NOT NULL,
  `uid` varchar(255) NOT NULL,
  `truck` varchar(255) NOT NULL,
  `capacity` varchar(255) NOT NULL,
  `noplat` varchar(255) NOT NULL,
  `owner_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tanki`
--

INSERT INTO `tanki` (`id`, `uid`, `truck`, `capacity`, `noplat`, `owner_id`) VALUES
(1, 'teloagain', 'TeloCar', '1000', 'AE 7310 TL', 1),
(2, 'abcde', 'Tossa', '1500', 'AE 4343 UG', 1),
(14, '5ap1t3n4n', 'Sapi Real', '5400', 'AE 5461 SP', 2),
(15, 'sapia', 'Sapi A', '1500', 'AE 54P1 A', 2);

-- --------------------------------------------------------

--
-- Table structure for table `temp`
--

CREATE TABLE `temp` (
  `id` int(100) NOT NULL,
  `data1` int(225) NOT NULL,
  `data2` int(225) NOT NULL,
  `temp` int(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `temp`
--

INSERT INTO `temp` (`id`, `data1`, `data2`, `temp`) VALUES
(1, 10, 60, 60);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ido`);

--
-- Indexes for table `owners`
--
ALTER TABLE `owners`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `tanki`
--
ALTER TABLE `tanki`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp`
--
ALTER TABLE `temp`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `ido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `owners`
--
ALTER TABLE `owners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tanki`
--
ALTER TABLE `tanki`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `temp`
--
ALTER TABLE `temp`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
