-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2015 at 05:35 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `indiacom`
--

-- --------------------------------------------------------

--
-- Table structure for table `payable_class`
--

CREATE TABLE IF NOT EXISTS `payable_class` (
  `payable_class_id` int(2) NOT NULL AUTO_INCREMENT,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_general` tinyint(1) NOT NULL DEFAULT '0',
  `payable_class_registration_category` int(2) NOT NULL,
  `payable_class_nationality` int(2) NOT NULL,
  `payable_class_payhead_id` int(2) NOT NULL,
  `payable_class_amount` int(5) NOT NULL,
  `payable_class_hashtag` varchar(64) DEFAULT NULL,
  `payable_class_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payable_class_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`payable_class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- RELATIONS FOR TABLE `payable_class`:
--   `payable_class_nationality`
--       `nationality_master` -> `Nationality_id`
--   `payable_class_payhead_id`
--       `payment_head_master` -> `payment_head_id`
--   `payable_class_registration_category`
--       `registration_category_master` -> `registration_category_id`
--

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
