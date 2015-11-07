-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2015 at 03:42 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

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
-- Table structure for table `privilege_role_mapper`
--

CREATE TABLE IF NOT EXISTS `privilege_role_mapper` (
  `privilege_id` varchar(8) NOT NULL,
  `role_id` int(8) NOT NULL,
  `privilege_role_mapper_hashtag` varchar(64) DEFAULT NULL,
  `privilege_role_mapper_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `privilege_role_mapper_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`privilege_id`,`role_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `privilege_role_mapper`
--

INSERT INTO `privilege_role_mapper` (`privilege_id`, `role_id`, `privilege_role_mapper_hashtag`, `privilege_role_mapper_dor`, `privilege_role_mapper_dirty`) VALUES
('AM0', 37, NULL, '2015-09-15 05:05:54', 0),
('AM1', 37, NULL, '2015-09-15 05:05:54', 0),
('CM0', 37, NULL, '2015-09-15 05:05:54', 0),
('CM1', 37, NULL, '2015-09-15 05:05:54', 0),
('CM2', 37, NULL, '2015-09-15 05:05:54', 0),
('D0', 51, NULL, '2015-09-15 05:27:24', 0),
('D1', 51, NULL, '2015-09-17 13:39:49', 0),
('D10', 51, NULL, '2015-09-17 13:40:25', 0),
('D11', 51, NULL, '2015-09-17 13:40:30', 0),
('D12', 51, NULL, '2015-09-17 13:40:34', 0),
('D13', 51, NULL, '2015-09-17 13:40:37', 0),
('D14', 51, NULL, '2015-09-17 13:41:01', 0),
('D15', 51, NULL, '2015-09-17 13:41:00', 0),
('D16', 51, NULL, '2015-09-17 13:40:58', 0),
('D17', 51, NULL, '2015-09-17 13:40:56', 0),
('D18', 51, NULL, '2015-09-17 13:40:49', 0),
('D19', 51, NULL, '2015-09-17 13:40:47', 0),
('D2', 51, NULL, '2015-09-17 13:39:51', 0),
('D20', 51, NULL, '2015-09-17 13:40:45', 0),
('D21', 51, NULL, '2015-09-17 13:40:43', 0),
('D22', 51, NULL, '2015-09-17 13:40:41', 0),
('D23', 51, NULL, '2015-09-17 13:40:39', 0),
('D3', 51, NULL, '2015-09-17 13:39:53', 0),
('D4', 51, NULL, '2015-09-17 13:40:02', 0),
('D5', 51, NULL, '2015-09-17 13:40:06', 0),
('D6', 51, NULL, '2015-09-17 13:40:12', 0),
('D7', 51, NULL, '2015-09-17 13:40:16', 0),
('D8', 51, NULL, '2015-09-17 13:40:18', 0),
('D9', 51, NULL, '2015-09-17 13:40:20', 0),
('DeM0', 37, NULL, '2015-09-15 05:05:54', 0),
('DeM1', 37, NULL, '2015-09-15 05:05:54', 0),
('DeM2', 37, NULL, '2015-09-15 05:05:54', 0),
('DM0', 37, NULL, '2015-09-15 05:05:54', 0),
('DM1', 37, NULL, '2015-09-15 05:05:54', 0),
('DM2', 37, NULL, '2015-09-15 05:05:54', 0),
('FPR0', 37, NULL, '2015-09-15 05:05:54', 0),
('FPR1', 37, NULL, '2015-09-15 05:05:54', 0),
('FPR2', 37, NULL, '2015-09-15 05:05:54', 0),
('IPR0', 37, NULL, '2015-09-15 05:05:54', 0),
('IPR1', 37, NULL, '2015-09-15 05:05:54', 0),
('MC0', 31, NULL, '2015-09-15 05:26:03', 0),
('MC0', 51, NULL, '2015-09-17 13:38:34', 0),
('MC1', 31, NULL, '2015-09-15 06:08:09', 0),
('MC1', 51, NULL, '2015-09-17 13:38:35', 0),
('N0', 31, NULL, '2015-09-17 13:39:13', 0),
('N1', 31, NULL, '2015-09-17 13:39:08', 0),
('NM0', 37, NULL, '2015-09-15 05:05:54', 0),
('NM_IOS0', 37, NULL, '2015-09-15 05:05:54', 0),
('NM_IOS1', 37, NULL, '2015-09-15 05:05:54', 0),
('NM_IOS2', 37, NULL, '2015-09-15 05:05:54', 0),
('NM_IOS3', 37, NULL, '2015-09-15 05:05:54', 0),
('P0', 37, NULL, '2015-09-15 05:05:54', 0),
('PM0', 37, NULL, '2015-09-15 05:05:54', 0),
('PM1', 37, NULL, '2015-09-15 05:05:54', 0),
('PM2', 37, NULL, '2015-09-15 05:05:54', 0),
('PM3', 37, NULL, '2015-09-15 05:05:54', 0),
('PM4', 37, NULL, '2015-09-15 05:05:54', 0),
('PM5', 37, NULL, '2015-09-15 05:05:54', 0),
('PM6', 37, NULL, '2015-09-15 05:05:54', 0),
('PM7', 37, NULL, '2015-09-15 05:05:54', 0),
('PM8', 37, NULL, '2015-09-15 05:05:54', 0),
('R0', 31, NULL, '2015-09-17 13:38:53', 0),
('R1', 31, NULL, '2015-09-17 13:38:55', 0),
('R2', 31, NULL, '2015-09-17 13:38:56', 0),
('R3', 31, NULL, '2015-09-17 13:38:56', 0),
('R4', 31, NULL, '2015-09-17 13:38:59', 0),
('R5', 31, NULL, '2015-09-17 13:38:58', 0),
('ReM0', 37, NULL, '2015-09-15 05:05:54', 0),
('ReM1', 37, NULL, '2015-09-15 05:05:54', 0),
('ReM2', 37, NULL, '2015-09-15 05:05:54', 0),
('ReM3', 37, NULL, '2015-09-15 05:05:54', 0),
('RM0', 37, NULL, '2015-09-15 05:05:54', 0),
('RM1', 37, NULL, '2015-09-15 05:05:54', 0),
('RM2', 37, NULL, '2015-09-15 05:05:54', 0),
('RM3', 37, NULL, '2015-09-15 05:05:54', 0),
('RM4', 37, NULL, '2015-09-15 05:05:54', 0),
('RM5', 37, NULL, '2015-09-15 05:05:54', 0),
('RM6', 37, NULL, '2015-09-15 05:05:54', 0),
('RM7', 37, NULL, '2015-09-15 05:05:54', 0),
('RM8', 37, NULL, '2015-09-15 05:05:54', 0),
('RM9', 37, NULL, '2015-09-15 05:05:54', 0),
('SSR0', 37, NULL, '2015-09-15 05:05:54', 0),
('SSR1', 37, NULL, '2015-09-15 05:05:54', 0),
('SSR2', 37, NULL, '2015-09-15 05:05:54', 0),
('SSR3', 37, NULL, '2015-09-15 05:05:54', 0),
('SSR4', 37, NULL, '2015-09-15 05:05:54', 0),
('SSR5', 37, NULL, '2015-09-15 05:05:54', 0),
('TM0', 37, NULL, '2015-09-15 05:05:54', 0),
('TM1', 37, NULL, '2015-09-15 05:05:54', 0),
('TM2', 37, NULL, '2015-09-15 05:05:54', 0),
('TM3', 37, NULL, '2015-09-15 05:05:54', 0),
('TM4', 37, NULL, '2015-09-15 05:05:54', 0),
('TraM0', 37, NULL, '2015-09-15 05:05:54', 0),
('TraM1', 37, NULL, '2015-09-15 05:05:54', 0),
('TraM2', 37, NULL, '2015-09-15 05:05:54', 0),
('UM0', 37, NULL, '2015-09-15 05:05:54', 0),
('UM1', 37, NULL, '2015-09-15 05:05:54', 0),
('UM2', 37, NULL, '2015-09-15 05:05:54', 0),
('UM3', 37, NULL, '2015-09-15 05:05:54', 0),
('UM4', 37, NULL, '2015-09-15 05:05:54', 0),
('UM5', 37, NULL, '2015-09-15 05:05:54', 0),
('UM6', 37, NULL, '2015-09-15 05:05:54', 0),
('UM7', 37, NULL, '2015-09-15 05:05:54', 0),
('UM8', 37, NULL, '2015-09-15 05:05:54', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `privilege_role_mapper`
--
ALTER TABLE `privilege_role_mapper`
  ADD CONSTRAINT `privilege_role_mapper_ibfk_3` FOREIGN KEY (`privilege_id`) REFERENCES `privilege_master` (`privilege_id`),
  ADD CONSTRAINT `privilege_role_mapper_ibfk_4` FOREIGN KEY (`role_id`) REFERENCES `role_master` (`role_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
