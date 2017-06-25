-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2017 at 02:50 PM
-- Server version: 5.6.11
-- PHP Version: 5.5.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ordermanagementsystem`
--
CREATE DATABASE IF NOT EXISTS `ordermanagementsystem` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ordermanagementsystem`;

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

CREATE TABLE IF NOT EXISTS `orderitems` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `orderid` bigint(20) unsigned NOT NULL,
  `name` text NOT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `createdat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `orderid` (`orderid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `orderitems`
--

INSERT INTO `orderitems` (`id`, `orderid`, `name`, `price`, `quantity`, `createdat`, `updatedat`) VALUES
(4, 9, '1', 10, 2, '2017-06-17 13:34:51', '2017-06-17 13:34:51'),
(5, 9, '2', 12, 1, '2017-06-17 13:34:51', '2017-06-17 13:34:51'),
(6, 10, '1', 10, 2, '2017-06-17 13:38:07', '2017-06-17 13:38:07'),
(7, 10, '2', 12, 1, '2017-06-17 13:38:07', '2017-06-17 13:38:07'),
(8, 11, '1', 10, 2, '2017-06-17 13:38:24', '2017-06-17 13:38:24'),
(9, 11, '2', 12, 1, '2017-06-17 13:38:24', '2017-06-17 13:38:24'),
(10, 12, '1', 10, 2, '2017-06-17 13:38:57', '2017-06-17 13:38:57'),
(11, 12, '2', 12, 1, '2017-06-17 13:38:57', '2017-06-17 13:38:57'),
(12, 13, '1', 10, 2, '2017-06-17 13:39:46', '2017-06-17 13:39:46'),
(13, 13, '2', 12, 1, '2017-06-17 13:39:46', '2017-06-17 13:39:46'),
(14, 14, '1', 10, 2, '2017-06-17 13:39:50', '2017-06-17 13:39:50'),
(15, 14, '2', 12, 1, '2017-06-17 13:39:50', '2017-06-17 13:39:50'),
(16, 15, '1', 10, 2, '2017-06-17 13:40:22', '2017-06-17 13:40:22'),
(17, 15, '2', 12, 1, '2017-06-17 13:40:22', '2017-06-17 13:40:22'),
(18, 16, '1', 10, 2, '2017-06-21 10:35:23', '2017-06-21 10:35:23'),
(19, 16, '2', 12, 1, '2017-06-21 10:35:23', '2017-06-21 10:35:23'),
(20, 17, '1', 10, 2, '2017-06-22 05:21:43', '2017-06-22 05:21:43'),
(21, 17, '2', 12, 1, '2017-06-22 05:21:43', '2017-06-22 05:21:43'),
(22, 18, '1', 10, 2, '2017-06-25 11:34:49', '2017-06-25 11:34:49'),
(23, 18, '2', 12, 1, '2017-06-25 11:34:49', '2017-06-25 11:34:49');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `orderid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `emailid` text NOT NULL,
  `status` enum('created','processed','delivered','cancelled') NOT NULL DEFAULT 'created',
  `createdat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `userid` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`orderid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderid`, `emailid`, `status`, `createdat`, `updatedat`, `userid`) VALUES
(2, 'issaqsyed918@gmail.com', 'created', '2017-06-17 13:18:50', '2017-06-21 10:58:56', 1),
(3, 'issaqsyed918@gmail.com', 'created', '2017-06-17 13:21:56', '2017-06-17 13:21:56', NULL),
(4, 'issaqsyed918@gmail.com', 'created', '2017-06-17 13:25:36', '2017-06-17 13:25:36', NULL),
(5, 'issaqsyed918@gmail.com', 'created', '2017-06-17 13:26:10', '2017-06-17 13:26:10', NULL),
(6, 'issaqsyed918@gmail.com', 'created', '2017-06-17 13:31:44', '2017-06-17 13:31:44', NULL),
(7, 'issaqsyed918@gmail.com', 'created', '2017-06-17 13:32:35', '2017-06-17 13:32:35', NULL),
(9, 'issaqsyed918@gmail.com', 'created', '2017-06-17 13:34:51', '2017-06-21 11:16:30', 1),
(10, 'issaqsyed918@gmail.com', 'created', '2017-06-17 13:38:07', '2017-06-17 13:38:07', NULL),
(11, 'issaqsyed918@gmail.com', 'created', '2017-06-17 13:38:24', '2017-06-17 13:38:24', NULL),
(12, 'issaqsyed918@gmail.com', 'created', '2017-06-17 13:38:57', '2017-06-17 13:38:57', NULL),
(13, 'issaqsyed918@gmail.com', 'created', '2017-06-17 13:39:46', '2017-06-17 13:39:46', NULL),
(14, 'issaqsyed918@gmail.com', 'created', '2017-06-17 13:39:50', '2017-06-17 13:39:50', NULL),
(15, 'issaqsyed918@gmail.com', 'created', '2017-06-17 13:40:22', '2017-06-17 13:40:22', NULL),
(16, 'issaqsyed918@gmail.com', 'created', '2017-06-21 10:35:22', '2017-06-22 05:11:58', NULL),
(17, 'issaqsyed918@gmail.com', 'created', '2017-06-22 05:21:43', '2017-06-22 05:21:43', NULL),
(18, 'issaqsyed918@gmail.com', 'created', '2017-06-25 11:34:49', '2017-06-25 11:34:49', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD CONSTRAINT `orderitems_ibfk_1` FOREIGN KEY (`orderid`) REFERENCES `orders` (`orderid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
