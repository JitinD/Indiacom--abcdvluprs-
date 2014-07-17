-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2014 at 06:49 PM
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
CREATE DATABASE IF NOT EXISTS `indiacom` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `indiacom`;

-- --------------------------------------------------------

--
-- Table structure for table `event_master`
--

CREATE TABLE IF NOT EXISTS `event_master` (
  `event_id` varchar(10) NOT NULL,
  `event_name` varchar(50) DEFAULT NULL,
  `event_description` varchar(200) NOT NULL,
  `event_start_date` datetime NOT NULL,
  `event_end_date` datetime NOT NULL,
  `event_paper_submission_start_date` datetime DEFAULT NULL,
  `event_paper_submission_end_date` datetime DEFAULT NULL,
  `event_abstract_submission_end_date` datetime DEFAULT NULL,
  `event_abstract_acceptance_notification` datetime DEFAULT NULL,
  `event_paper_submission_notification` datetime DEFAULT NULL,
  `event_review_info_avail_after` datetime DEFAULT NULL,
  `event_clear_min_dues_by` datetime DEFAULT NULL,
  `event_email` varchar(150) DEFAULT NULL,
  `event_info` varchar(300) DEFAULT NULL,
  `event_attachment` varchar(300) DEFAULT NULL,
  `event_hashtag` varchar(64) DEFAULT NULL,
  `event_dor` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `event_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `member_category_master`
--

CREATE TABLE IF NOT EXISTS `member_category_master` (
  `member_category_id` int(4) NOT NULL,
  `member_category_name` varchar(64) NOT NULL,
  `member_category_event_id` varchar(10) NOT NULL,
  `member_category_hashtag` varchar(64) DEFAULT NULL,
  `member_category_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `member_category_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`member_category_id`),
  KEY `member_category_event_id` (`member_category_event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `member_category_master`:
--   `member_category_event_id`
--       `event_master` -> `event_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `member_master`
--

CREATE TABLE IF NOT EXISTS `member_master` (
  `member_id` varchar(10) NOT NULL,
  `member_name` varchar(50) NOT NULL,
  `member_address` varchar(100) DEFAULT NULL,
  `member_pincode` varchar(10) DEFAULT NULL,
  `member_email` varchar(100) DEFAULT NULL,
  `member_phone` varchar(20) DEFAULT NULL,
  `member_mobile` varchar(20) DEFAULT NULL,
  `member_fax` varchar(20) DEFAULT NULL,
  `member_designation` varchar(20) DEFAULT NULL,
  `member_csi_mem_no` varchar(30) DEFAULT NULL,
  `member_iete_mem_no` varchar(30) DEFAULT NULL,
  `member_pass` varchar(20) NOT NULL,
  `member_organization_id` varchar(10) DEFAULT NULL,
  `member_biodata_path` varchar(50) DEFAULT NULL,
  `member_category_id` int(4) DEFAULT NULL,
  `member_experience` varchar(4) DEFAULT NULL,
  `member_hashtag` varchar(64) DEFAULT NULL,
  `member_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `member_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`member_id`),
  KEY `member_category_id` (`member_category_id`),
  KEY `member_organization_id` (`member_organization_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `member_master`:
--   `member_category_id`
--       `member_category_master` -> `member_category_id`
--   `member_organization_id`
--       `organization_master` -> `organization_id`
--

--
-- Dumping data for table `member_master`
--

INSERT INTO `member_master` (`member_id`, `member_name`, `member_address`, `member_pincode`, `member_email`, `member_phone`, `member_mobile`, `member_fax`, `member_designation`, `member_csi_mem_no`, `member_iete_mem_no`, `member_pass`, `member_organization_id`, `member_biodata_path`, `member_category_id`, `member_experience`, `member_hashtag`, `member_dor`, `member_dirty`) VALUES
('12', 'Rana', 'Gadhbadh Nagar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '123', NULL, NULL, NULL, NULL, NULL, '2014-07-15 09:46:52', 0);

-- --------------------------------------------------------

--
-- Table structure for table `organization_master`
--

CREATE TABLE IF NOT EXISTS `organization_master` (
  `organization_id` varchar(10) NOT NULL,
  `organization_name` varchar(100) NOT NULL,
  `organization_short_name` varchar(20) DEFAULT NULL,
  `organization_address` varchar(200) NOT NULL,
  `organization_email` varchar(50) NOT NULL,
  `organization_phone` varchar(20) NOT NULL,
  `organization_contact_person_name` varchar(50) DEFAULT NULL,
  `organization_fax` varchar(20) DEFAULT NULL,
  `organization_hashtag` varchar(64) DEFAULT NULL,
  `organization_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `organization_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`organization_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `paper_master`
--

CREATE TABLE IF NOT EXISTS `paper_master` (
  `paper_id` varchar(20) NOT NULL,
  `paper_code` varchar(10) NOT NULL,
  `paper_title` varchar(200) NOT NULL,
  `paper_subject_id` varchar(10) NOT NULL,
  `paper_date_of_submission` datetime DEFAULT NULL,
  `paper_presentation_path` varchar(50) DEFAULT NULL,
  `paper_contact_author_id` varchar(10) NOT NULL,
  `paper_isclose` tinyint(4) NOT NULL DEFAULT '0',
  `paper_hashtag` varchar(64) DEFAULT NULL,
  `paper_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `paper_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`paper_id`),
  UNIQUE KEY `paper_code` (`paper_code`,`paper_subject_id`),
  KEY `paper_contact_author_id` (`paper_contact_author_id`),
  KEY `paper_subject_id` (`paper_subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `paper_master`:
--   `paper_contact_author_id`
--       `member_master` -> `member_id`
--   `paper_subject_id`
--       `subject_master` -> `subject_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `paper_version_master`
--

CREATE TABLE IF NOT EXISTS `paper_version_master` (
  `paper_version_id` varchar(10) NOT NULL,
  `paper_id` varchar(10) NOT NULL,
  `paper_version` int(2) NOT NULL,
  `paper_version_date_of_submission` datetime NOT NULL,
  `paper_version_document_path` varchar(100) NOT NULL,
  `paper_version_compliance_report_path` varchar(100) DEFAULT NULL,
  `paper_version_convener_id` int(11) DEFAULT NULL,
  `paper_version_is_reviewer_assigned` tinyint(1) NOT NULL DEFAULT '0',
  `paper_version_review_date` datetime DEFAULT NULL,
  `paper_version_review_result_id` int(2) DEFAULT NULL,
  `paper_version_review` varchar(300) DEFAULT NULL,
  `paper_version_comments_path` varchar(100) DEFAULT NULL,
  `paper_version_review_is_read_by_author` tinyint(1) NOT NULL DEFAULT '0',
  `paper_version_hashtag` varchar(64) DEFAULT NULL,
  `paper_version_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `paper_version_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`paper_version_id`),
  KEY `paper_id` (`paper_id`),
  KEY `paper_id_2` (`paper_id`),
  KEY `paper_version_convener_id` (`paper_version_convener_id`),
  KEY `paper_version_review_result_id` (`paper_version_review_result_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `paper_version_master`:
--   `paper_id`
--       `paper_master` -> `paper_id`
--   `paper_version_convener_id`
--       `user_master` -> `user_id`
--   `paper_version_review_result_id`
--       `review_result_master` -> `review_result_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `reviewer_master`
--

CREATE TABLE IF NOT EXISTS `reviewer_master` (
  `reviewer_id` int(11) NOT NULL,
  `reviewer_name` varchar(100) NOT NULL,
  `reviewer_organization` varchar(255) NOT NULL,
  `reviewer_designation` varchar(255) DEFAULT NULL,
  `reviewer_address` varchar(255) DEFAULT NULL,
  `reviewer_email` varchar(100) NOT NULL,
  `reviewer_office` varchar(18) DEFAULT NULL,
  `reviewer_residence` varchar(50) DEFAULT NULL,
  `reviewer_mobile` varchar(20) DEFAULT NULL,
  `reviewer_department` varchar(75) DEFAULT NULL,
  `reviewer_hashtag` varchar(64) DEFAULT NULL,
  `reviewer_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reviewer_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`reviewer_id`),
  KEY `reviewer_id` (`reviewer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `reviewer_master`:
--   `reviewer_id`
--       `user_master` -> `user_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `review_result_master`
--

CREATE TABLE IF NOT EXISTS `review_result_master` (
  `review_result_id` int(2) NOT NULL,
  `review_result_type_name` varchar(50) NOT NULL,
  `review_result_description` varchar(150) NOT NULL,
  `review_result_message` varchar(150) NOT NULL,
  `review_result_acronym` varchar(10) NOT NULL,
  `review_result_hashtag` varchar(64) DEFAULT NULL,
  `review_result_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `review_result_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`review_result_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `role_master`
--

CREATE TABLE IF NOT EXISTS `role_master` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(32) NOT NULL,
  `role_hashtag` varchar(64) DEFAULT NULL,
  `role_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subject_master`
--

CREATE TABLE IF NOT EXISTS `subject_master` (
  `subject_id` varchar(10) NOT NULL,
  `subject_code` varchar(50) NOT NULL,
  `subject_track_id` varchar(50) NOT NULL,
  `subject_name` varchar(50) NOT NULL,
  `subject_description` varchar(200) DEFAULT NULL,
  `subject_hashtag` varchar(64) DEFAULT NULL,
  `subject_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `subject_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`subject_id`),
  UNIQUE KEY `subject_code` (`subject_code`,`subject_track_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `submission_master`
--

CREATE TABLE IF NOT EXISTS `submission_master` (
  `submission_id` varchar(10) NOT NULL,
  `submission_paper_id` varchar(20) NOT NULL,
  `submission_member_id` varchar(10) NOT NULL,
  `submission_hashtag` varchar(64) DEFAULT NULL,
  `submission_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `submission_dirty` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `track_master`
--

CREATE TABLE IF NOT EXISTS `track_master` (
  `track_id` varchar(10) NOT NULL,
  `track_number` varchar(10) NOT NULL,
  `track_event_id` varchar(10) NOT NULL,
  `track_name` varchar(100) DEFAULT NULL,
  `track_description` varchar(200) DEFAULT NULL,
  `track_hashtag` varchar(64) NOT NULL,
  `track_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `track_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`track_id`),
  UNIQUE KEY `track_number` (`track_number`,`track_event_id`),
  KEY `track_event_id` (`track_event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `track_master`:
--   `track_event_id`
--       `event_master` -> `event_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_event_role_mapper`
--

CREATE TABLE IF NOT EXISTS `user_event_role_mapper` (
  `user_id` int(11) NOT NULL,
  `event_id` varchar(10) NOT NULL,
  `role_id` int(11) NOT NULL,
  `user_event_role_mapper_hashtag` varchar(64) DEFAULT NULL,
  `user_event_role_mapper_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_event_role_mapper_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`event_id`,`role_id`),
  KEY `role_id` (`role_id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `user_event_role_mapper`:
--   `user_id`
--       `user_master` -> `user_id`
--   `role_id`
--       `role_master` -> `role_id`
--   `event_id`
--       `event_master` -> `event_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_master`
--

CREATE TABLE IF NOT EXISTS `user_master` (
  `user_id` int(11) NOT NULL,
  `user_name` text NOT NULL,
  `user_email` varchar(128) NOT NULL,
  `user_pass` varchar(64) NOT NULL,
  `user_registrar` int(11) DEFAULT NULL,
  `user_hashtag` varchar(64) DEFAULT NULL,
  `user_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  KEY `user_registrar` (`user_registrar`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `user_master`:
--   `user_registrar`
--       `user_master` -> `user_id`
--

--
-- Constraints for dumped tables
--

--
-- Constraints for table `member_category_master`
--
ALTER TABLE `member_category_master`
  ADD CONSTRAINT `member_category_master_ibfk_1` FOREIGN KEY (`member_category_event_id`) REFERENCES `event_master` (`event_id`);

--
-- Constraints for table `member_master`
--
ALTER TABLE `member_master`
  ADD CONSTRAINT `member_master_ibfk_1` FOREIGN KEY (`member_category_id`) REFERENCES `member_category_master` (`member_category_id`),
  ADD CONSTRAINT `member_master_ibfk_2` FOREIGN KEY (`member_organization_id`) REFERENCES `organization_master` (`organization_id`);

--
-- Constraints for table `paper_master`
--
ALTER TABLE `paper_master`
  ADD CONSTRAINT `paper_master_ibfk_2` FOREIGN KEY (`paper_contact_author_id`) REFERENCES `member_master` (`member_id`),
  ADD CONSTRAINT `paper_master_ibfk_3` FOREIGN KEY (`paper_subject_id`) REFERENCES `subject_master` (`subject_id`);

--
-- Constraints for table `paper_version_master`
--
ALTER TABLE `paper_version_master`
  ADD CONSTRAINT `paper_version_master_ibfk_1` FOREIGN KEY (`paper_id`) REFERENCES `paper_master` (`paper_id`),
  ADD CONSTRAINT `paper_version_master_ibfk_2` FOREIGN KEY (`paper_version_convener_id`) REFERENCES `user_master` (`user_id`),
  ADD CONSTRAINT `paper_version_master_ibfk_3` FOREIGN KEY (`paper_version_review_result_id`) REFERENCES `review_result_master` (`review_result_id`);

--
-- Constraints for table `reviewer_master`
--
ALTER TABLE `reviewer_master`
  ADD CONSTRAINT `reviewer_master_ibfk_1` FOREIGN KEY (`reviewer_id`) REFERENCES `user_master` (`user_id`);

--
-- Constraints for table `track_master`
--
ALTER TABLE `track_master`
  ADD CONSTRAINT `track_master_ibfk_1` FOREIGN KEY (`track_event_id`) REFERENCES `event_master` (`event_id`);

--
-- Constraints for table `user_event_role_mapper`
--
ALTER TABLE `user_event_role_mapper`
  ADD CONSTRAINT `user_event_role_mapper_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_master` (`user_id`),
  ADD CONSTRAINT `user_event_role_mapper_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `role_master` (`role_id`),
  ADD CONSTRAINT `user_event_role_mapper_ibfk_3` FOREIGN KEY (`event_id`) REFERENCES `event_master` (`event_id`);

--
-- Constraints for table `user_master`
--
ALTER TABLE `user_master`
  ADD CONSTRAINT `user_master_ibfk_1` FOREIGN KEY (`user_registrar`) REFERENCES `user_master` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
