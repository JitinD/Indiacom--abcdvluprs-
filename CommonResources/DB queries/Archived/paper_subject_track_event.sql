-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2015 at 08:11 PM
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
-- Structure for view `paper_subject_track_event`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `paper_subject_track_event` AS select `paper_master`.`paper_id` AS `paper_id`,`paper_master`.`paper_code` AS `paper_code`,`subject_master`.`subject_id` AS `subject_id`,`subject_master`.`subject_code` AS `subject_code`,`track_master`.`track_id` AS `track_id`,`track_master`.`track_number` AS `track_number`,`event_master`.`event_id` AS `event_id`,`event_master`.`event_name` AS `event_name` from (((`subject_master` left join `paper_master` on((`paper_master`.`paper_subject_id` = `subject_master`.`subject_id`))) join `track_master` on((`subject_master`.`subject_track_id` = `track_master`.`track_id`))) join `event_master` on((`track_master`.`track_event_id` = `event_master`.`event_id`))) order by `track_master`.`track_event_id`;

--
-- VIEW  `paper_subject_track_event`
-- Data: None
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
