-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 27, 2014 at 03:50 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

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
-- Structure for view `paper_latest_version`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `paper_latest_version` AS (select `paper_master`.`paper_id` AS `paper_id`,`paper_master`.`paper_code` AS `paper_code`,`paper_master`.`paper_title` AS `paper_title`,max(`paper_version_master`.`paper_version_number`) AS `latest_paper_version_number`,`review_result_master`.`review_result_type_name` AS `review_result_type_name` from ((`paper_master` join `paper_version_master` on((`paper_master`.`paper_id` = `paper_version_master`.`paper_id`))) left join `review_result_master` on((`review_result_master`.`review_result_id` = `paper_version_master`.`paper_version_review_result_id`))) group by `paper_version_master`.`paper_id`);

--
-- VIEW  `paper_latest_version`
-- Data: None
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
