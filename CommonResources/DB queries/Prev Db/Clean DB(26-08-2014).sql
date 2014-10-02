-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 26, 2014 at 06:53 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.16

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
-- Table structure for table `database_user`
--

CREATE TABLE IF NOT EXISTS `database_user` (
  `database_user_name` varchar(32) NOT NULL,
  `database_user_password` varchar(64) NOT NULL,
  `database_user_hashtag` varchar(64) DEFAULT NULL,
  `database_user_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `database_user_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`database_user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `event_master`
--

CREATE TABLE IF NOT EXISTS `event_master` (
  `event_id` int(8) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(50) NOT NULL,
  `event_description` varchar(200) DEFAULT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `event_master`
--

INSERT INTO `event_master` (`event_id`, `event_name`, `event_description`, `event_start_date`, `event_end_date`, `event_paper_submission_start_date`, `event_paper_submission_end_date`, `event_abstract_submission_end_date`, `event_abstract_acceptance_notification`, `event_paper_submission_notification`, `event_review_info_avail_after`, `event_clear_min_dues_by`, `event_email`, `event_info`, `event_attachment`, `event_hashtag`, `event_dor`, `event_dirty`) VALUES
(1, 'IndiaCom 2015', 'Hello World', '2015-04-08 00:00:00', '2015-04-11 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-07-22 19:22:38', 0),
(2, 'NSC 2015', 'Hello World', '2015-04-12 00:00:00', '2015-04-12 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-07-22 19:23:08', 0);

-- --------------------------------------------------------

--
-- Table structure for table `member_category_master`
--

CREATE TABLE IF NOT EXISTS `member_category_master` (
  `member_category_id` int(4) NOT NULL AUTO_INCREMENT,
  `member_category_name` varchar(64) NOT NULL,
  `member_category_event_id` int(8) NOT NULL,
  `member_category_hashtag` varchar(64) DEFAULT NULL,
  `member_category_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `member_category_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`member_category_id`),
  KEY `member_category_event_id` (`member_category_event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `member_category_master`
--

INSERT INTO `member_category_master` (`member_category_id`, `member_category_name`, `member_category_event_id`, `member_category_hashtag`, `member_category_dor`, `member_category_dirty`) VALUES
(1, 'Research Student', 1, NULL, '2014-07-25 18:01:51', 0),
(2, 'Student', 1, NULL, '2014-07-25 18:01:51', 0),
(5, 'Faculty', 1, NULL, '2014-07-25 18:02:36', 0),
(6, 'Industry Representative', 1, NULL, '2014-07-25 18:02:36', 0);

-- --------------------------------------------------------

--
-- Table structure for table `member_master`
--

CREATE TABLE IF NOT EXISTS `member_master` (
  `member_id` varchar(10) NOT NULL,
  `member_name` varchar(50) NOT NULL,
  `member_address` varchar(100) NOT NULL,
  `member_pincode` varchar(10) NOT NULL,
  `member_email` varchar(100) NOT NULL,
  `member_phone` varchar(20) DEFAULT NULL,
  `member_mobile` varchar(20) NOT NULL,
  `member_fax` varchar(20) DEFAULT NULL,
  `member_designation` varchar(20) DEFAULT NULL,
  `member_csi_mem_no` varchar(30) DEFAULT NULL,
  `member_iete_mem_no` varchar(30) DEFAULT NULL,
  `member_password` varchar(64) NOT NULL,
  `member_organization_id` int(8) DEFAULT NULL,
  `member_department` varchar(100) NOT NULL,
  `member_biodata_path` varchar(100) DEFAULT NULL,
  `member_category_id` int(4) DEFAULT NULL,
  `member_experience` varchar(4) DEFAULT NULL,
  `member_is_activated` tinyint(1) NOT NULL DEFAULT '0',
  `member_hashtag` varchar(64) DEFAULT NULL,
  `member_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `member_dirty` tinyint(1) NOT NULL DEFAULT '0',
  `member_salutation` varchar(5) NOT NULL,
  PRIMARY KEY (`member_id`),
  KEY `member_organization_id` (`member_organization_id`),
  KEY `member_category_id` (`member_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member_master`
--

INSERT INTO `member_master` (`member_id`, `member_name`, `member_address`, `member_pincode`, `member_email`, `member_phone`, `member_mobile`, `member_fax`, `member_designation`, `member_csi_mem_no`, `member_iete_mem_no`, `member_password`, `member_organization_id`, `member_department`, `member_biodata_path`, `member_category_id`, `member_experience`, `member_is_activated`, `member_hashtag`, `member_dor`, `member_dirty`, `member_salutation`) VALUES
('1', 'Jitin', 'Block - 22/2, Nurses Residential Complex, Srinivaspuri', '110065', 'jitin.dominic01@gmail.com', '011-26922416', '9560365906', '09439', '', '3284823', '320948203', '202cb962ac59075b964b07152d234b70', 1, '', '0', 2, '12', 1, NULL, '2014-07-25 19:49:19', 0, ''),
('2', 'Sachin', 'Block - 22/2, Nurses Residential Complex, Srinivaspuri', '110065', 'sachin.dominic08@gmail.com', '011-26922416', '9560365906', '', '', '3284823', '2323', 'EoFRt4jSK7NWdCuw/6DFl/xiKKK0wUs0TpDCpc9o3opIQJlro95Yk4wQyZ+WgW1n', 2, '', '0', 5, '11', 0, NULL, '2014-07-25 19:50:42', 0, ''),
('3', 'Saurav Deb P.', 'E-168, Sector 41, Noida', '201303', 'sauravdebp@gmail.com', '01204319850', '9818865297', '', '', '', '', '10c0500908124a545f373d6a790ef7ef', 2, '', '0', 2, '0', 0, NULL, '2014-07-28 09:57:28', 0, ''),
('31', 'Walter White', 'Albuquerque', '95678', 'jitshi92@gmail.com', '34567892', '987654', '678', 'Professor', '789', '789', '202cb962ac59075b964b07152d234b70', 2, 'Chemistry', '0', 5, '12', 0, NULL, '2014-08-02 13:19:47', 0, 'Prof'),
('9', 'Jitin Dominic', 'Block - 22/2, Nurses Residential Complex, Srinivaspuri', '110065', 'jitinthegreat1@gmail.com', '92929', '948949', '483993', '', '94949', '39893', '81dc9bdb52d04dc20036dbd8313ed055', 2, '', '0', 2, '11', 0, NULL, '2014-07-29 15:06:13', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `news_master`
--

CREATE TABLE IF NOT EXISTS `news_master` (
  `news_id` int(8) NOT NULL AUTO_INCREMENT,
  `news_title` varchar(100) NOT NULL,
  `news_description_url` varchar(100) NOT NULL,
  `news_publisher_id` int(8) NOT NULL,
  `news_publish_date` datetime NOT NULL,
  `news_sticky_date` datetime DEFAULT NULL,
  `news_event_id` int(8) NOT NULL,
  `news_attachments_path` varchar(100) DEFAULT NULL,
  `news_hashtag` varchar(64) DEFAULT NULL,
  `news_dor` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `news_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`news_id`),
  KEY `news_publisher_id` (`news_publisher_id`),
  KEY `news_event_id` (`news_event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `organization_master`
--

CREATE TABLE IF NOT EXISTS `organization_master` (
  `organization_id` int(8) NOT NULL AUTO_INCREMENT,
  `organization_name` varchar(100) NOT NULL,
  `organization_short_name` varchar(20) DEFAULT NULL,
  `organization_address` varchar(200) DEFAULT NULL,
  `organization_email` varchar(50) DEFAULT NULL,
  `organization_phone` varchar(20) DEFAULT NULL,
  `organization_contact_person_name` varchar(50) DEFAULT NULL,
  `organization_fax` varchar(20) DEFAULT NULL,
  `organization_hashtag` varchar(64) DEFAULT NULL,
  `organization_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `organization_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`organization_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `organization_master`
--

INSERT INTO `organization_master` (`organization_id`, `organization_name`, `organization_short_name`, `organization_address`, `organization_email`, `organization_phone`, `organization_contact_person_name`, `organization_fax`, `organization_hashtag`, `organization_dor`, `organization_dirty`) VALUES
(1, 'Bharati Vidyapeeth Institute of Computer Applications and Management', 'BVICAM', NULL, NULL, NULL, NULL, NULL, NULL, '2014-07-25 18:05:42', 0),
(2, 'ABC-Dvluprs', '@abcdvluprs', NULL, NULL, NULL, NULL, NULL, NULL, '2014-07-25 18:05:42', 0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `paper_latest_version`
--
CREATE TABLE IF NOT EXISTS `paper_latest_version` (
`paper_id` int(16)
,`paper_code` varchar(10)
,`paper_title` varchar(200)
,`latest_paper_version_number` int(4)
,`review_result_type_name` varchar(50)
);
-- --------------------------------------------------------

--
-- Table structure for table `paper_master`
--

CREATE TABLE IF NOT EXISTS `paper_master` (
  `paper_id` int(16) NOT NULL AUTO_INCREMENT,
  `paper_code` varchar(10) NOT NULL,
  `paper_title` varchar(200) NOT NULL,
  `paper_subject_id` int(8) NOT NULL,
  `paper_date_of_submission` datetime DEFAULT NULL,
  `paper_presentation_path` varchar(100) DEFAULT NULL,
  `paper_contact_author_id` varchar(10) NOT NULL,
  `paper_isclose` tinyint(1) NOT NULL DEFAULT '0',
  `paper_hashtag` varchar(64) DEFAULT NULL,
  `paper_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `paper_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`paper_id`),
  KEY `paper_contact_author_id` (`paper_contact_author_id`),
  KEY `paper_subject_id` (`paper_subject_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `paper_status_info`
--
CREATE TABLE IF NOT EXISTS `paper_status_info` (
`submission_member_id` varchar(10)
,`paper_id` int(16)
,`paper_title` varchar(200)
,`review_result_type_name` varchar(50)
,`paper_version_number` int(4)
);
-- --------------------------------------------------------

--
-- Table structure for table `paper_version_master`
--

CREATE TABLE IF NOT EXISTS `paper_version_master` (
  `paper_version_id` int(32) NOT NULL AUTO_INCREMENT,
  `paper_id` int(16) NOT NULL,
  `paper_version_number` int(4) NOT NULL,
  `paper_version_date_of_submission` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `paper_version_document_path` varchar(100) NOT NULL,
  `paper_version_compliance_report_path` varchar(100) DEFAULT NULL,
  `paper_version_convener_id` int(8) DEFAULT NULL,
  `paper_version_is_reviewer_assigned` tinyint(1) NOT NULL DEFAULT '0',
  `paper_version_review_date` datetime DEFAULT NULL,
  `paper_version_review_result_id` int(2) DEFAULT NULL,
  `paper_version_review` varchar(300) DEFAULT 'Not reviewed yet',
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `paper_version_review`
--

CREATE TABLE IF NOT EXISTS `paper_version_review` (
  `paper_version_review_id` int(64) NOT NULL AUTO_INCREMENT,
  `paper_version_id` int(32) NOT NULL,
  `paper_version_reviewer_id` int(8) NOT NULL,
  `paper_version_review_comments` varchar(300) NOT NULL DEFAULT 'Not reviewed yet',
  `paper_version_review_comments_file_path` varchar(100) DEFAULT NULL,
  `paper_version_date_sent_for_review` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `paper_version_review_date_of_receipt` datetime DEFAULT NULL,
  `paper_version_review_hashtag` varchar(64) DEFAULT NULL,
  `paper_version_review_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `paper_version_review_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`paper_version_review_id`),
  UNIQUE KEY `paper_version_id_2` (`paper_version_id`,`paper_version_reviewer_id`),
  KEY `paper_version_id` (`paper_version_id`),
  KEY `reviewer_id` (`paper_version_reviewer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Table structure for table `privilege_master`
--

CREATE TABLE IF NOT EXISTS `privilege_master` (
  `privilege_id` varchar(8) NOT NULL,
  `privilege_entity` varchar(50) NOT NULL,
  `privilege_attribute` varchar(50) NOT NULL,
  `privilege_operation` varchar(10) NOT NULL,
  `privilege_hashtag` varchar(64) DEFAULT NULL,
  `privilege_dor` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `privilege_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`privilege_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `reviewer_master`
--

CREATE TABLE IF NOT EXISTS `reviewer_master` (
  `reviewer_id` int(8) NOT NULL DEFAULT '0',
  `reviewer_organization_id` int(8) DEFAULT NULL,
  `reviewer_hashtag` varchar(64) DEFAULT NULL,
  `reviewer_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reviewer_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`reviewer_id`),
  KEY `reviewer_id` (`reviewer_id`),
  KEY `reviewer_organization_id` (`reviewer_organization_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `review_result_master`
--

CREATE TABLE IF NOT EXISTS `review_result_master` (
  `review_result_id` int(2) NOT NULL AUTO_INCREMENT,
  `review_result_type_name` varchar(50) NOT NULL,
  `review_result_description` varchar(150) DEFAULT NULL,
  `review_result_message` varchar(150) DEFAULT NULL,
  `review_result_acronym` varchar(10) DEFAULT NULL,
  `review_result_hashtag` varchar(64) DEFAULT NULL,
  `review_result_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `review_result_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`review_result_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `review_result_master`
--

INSERT INTO `review_result_master` (`review_result_id`, `review_result_type_name`, `review_result_description`, `review_result_message`, `review_result_acronym`, `review_result_hashtag`, `review_result_dor`, `review_result_dirty`) VALUES
(1, 'Rejected', NULL, NULL, NULL, NULL, '2014-07-25 18:06:42', 0),
(2, 'Accepted', NULL, NULL, NULL, NULL, '2014-07-25 18:06:42', 0);

-- --------------------------------------------------------

--
-- Table structure for table `role_master`
--

CREATE TABLE IF NOT EXISTS `role_master` (
  `role_id` int(8) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(32) NOT NULL,
  `role_hashtag` varchar(64) DEFAULT NULL,
  `role_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `role_name` (`role_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `subject_master`
--

CREATE TABLE IF NOT EXISTS `subject_master` (
  `subject_id` int(8) NOT NULL AUTO_INCREMENT,
  `subject_code` varchar(10) NOT NULL,
  `subject_track_id` int(8) NOT NULL,
  `subject_name` varchar(50) NOT NULL,
  `subject_description` varchar(100) DEFAULT NULL,
  `subject_hashtag` varchar(64) DEFAULT NULL,
  `subject_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `subject_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`subject_id`),
  UNIQUE KEY `subject_code` (`subject_code`,`subject_track_id`),
  KEY `subject_track_id` (`subject_track_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `subject_master`
--

INSERT INTO `subject_master` (`subject_id`, `subject_code`, `subject_track_id`, `subject_name`, `subject_description`, `subject_hashtag`, `subject_dor`, `subject_dirty`) VALUES
(1, '101', 1, 'Networking', NULL, NULL, '2014-07-25 18:17:17', 0),
(2, '102', 1, 'Advanced Networking', NULL, NULL, '2014-07-25 18:17:17', 0),
(3, '103', 2, 'Quantum Computing', NULL, NULL, '2014-07-25 18:17:17', 0),
(4, '104', 3, 'Databases', NULL, NULL, '2014-07-25 18:17:17', 0),
(5, '105', 4, 'TOC', NULL, NULL, '2014-07-25 18:17:17', 0),
(6, '101', 5, 'Graphics', NULL, NULL, '2014-07-25 18:17:17', 0),
(7, '102', 8, 'Networking', NULL, NULL, '2014-07-25 18:17:17', 0);

-- --------------------------------------------------------

--
-- Table structure for table `submission_master`
--

CREATE TABLE IF NOT EXISTS `submission_master` (
  `submission_id` int(32) NOT NULL AUTO_INCREMENT,
  `submission_paper_id` int(16) NOT NULL,
  `submission_member_id` varchar(10) NOT NULL,
  `submission_hashtag` varchar(64) DEFAULT NULL,
  `submission_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `submission_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`submission_id`),
  UNIQUE KEY `submission_paper_id_2` (`submission_paper_id`,`submission_member_id`),
  KEY `submission_paper_id` (`submission_paper_id`),
  KEY `submission_member_id` (`submission_member_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `track_master`
--

CREATE TABLE IF NOT EXISTS `track_master` (
  `track_id` int(8) NOT NULL AUTO_INCREMENT,
  `track_number` varchar(10) NOT NULL,
  `track_event_id` int(8) NOT NULL,
  `track_name` varchar(100) NOT NULL,
  `track_description` varchar(200) DEFAULT NULL,
  `track_hashtag` varchar(64) NOT NULL,
  `track_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `track_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`track_id`),
  UNIQUE KEY `track_number` (`track_number`,`track_event_id`),
  KEY `track_event_id` (`track_event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `track_master`
--

INSERT INTO `track_master` (`track_id`, `track_number`, `track_event_id`, `track_name`, `track_description`, `track_hashtag`, `track_dor`, `track_dirty`) VALUES
(1, '1', 1, 'International Conference on Sustainable Computing (ICSC-2015)', NULL, '', '2014-07-25 18:09:47', 0),
(2, '2', 1, 'International Conference on High Performance Computing (ICHPC-2015)', NULL, '', '2014-07-25 18:09:47', 0),
(3, '3', 1, 'International Conference on High Speed Networking and Information Security (ICHNIS-2015)', NULL, '', '2014-07-25 18:09:47', 0),
(4, '4', 1, 'International Conference on Software Engineering and Emerging Technologies (ICSEET-2015)', NULL, '', '2014-07-25 18:09:47', 0),
(5, '1', 2, 'Internet of Things', NULL, '', '2014-07-25 18:10:39', 0),
(8, '2', 2, 'Embedded Computing', NULL, '', '2014-07-25 18:11:57', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_event_role_mapper`
--

CREATE TABLE IF NOT EXISTS `user_event_role_mapper` (
  `user_id` int(8) NOT NULL,
  `event_id` int(8) NOT NULL,
  `role_id` int(8) NOT NULL,
  `user_event_role_mapper_hashtag` varchar(64) DEFAULT NULL,
  `user_event_role_mapper_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_event_role_mapper_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`event_id`,`role_id`),
  KEY `role_id` (`role_id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_master`
--

CREATE TABLE IF NOT EXISTS `user_master` (
  `user_id` int(8) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `user_organization_id` int(8) DEFAULT NULL,
  `user_designation` varchar(50) DEFAULT NULL,
  `user_address` varchar(150) DEFAULT NULL,
  `user_office_address` varchar(150) DEFAULT NULL,
  `user_mobile` varchar(20) DEFAULT NULL,
  `user_department` varchar(50) DEFAULT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(64) NOT NULL,
  `user_registrar` int(8) DEFAULT NULL,
  `user_hashtag` varchar(64) DEFAULT NULL,
  `user_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  KEY `user_registrar` (`user_registrar`),
  KEY `user_organization_id` (`user_organization_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Structure for view `paper_latest_version`
--
DROP TABLE IF EXISTS `paper_latest_version`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `paper_latest_version` AS (select `paper_master`.`paper_id` AS `paper_id`,`paper_master`.`paper_code` AS `paper_code`,`paper_master`.`paper_title` AS `paper_title`,max(`paper_version_master`.`paper_version_number`) AS `latest_paper_version_number`,`review_result_master`.`review_result_type_name` AS `review_result_type_name` from ((`paper_master` join `paper_version_master` on((`paper_master`.`paper_id` = `paper_version_master`.`paper_id`))) left join `review_result_master` on((`review_result_master`.`review_result_id` = `paper_version_master`.`paper_version_review_result_id`))) group by `paper_version_master`.`paper_id`);

-- --------------------------------------------------------

--
-- Structure for view `paper_status_info`
--
DROP TABLE IF EXISTS `paper_status_info`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `paper_status_info` AS (select `submission_master`.`submission_member_id` AS `submission_member_id`,`paper_master`.`paper_id` AS `paper_id`,`paper_master`.`paper_title` AS `paper_title`,`review_result_master`.`review_result_type_name` AS `review_result_type_name`,`paper_version_master`.`paper_version_number` AS `paper_version_number` from (((`submission_master` join `paper_master` on((`paper_master`.`paper_id` = `submission_master`.`submission_paper_id`))) join `paper_version_master` on((`paper_master`.`paper_id` = `paper_version_master`.`paper_id`))) join `review_result_master` on((`paper_version_master`.`paper_version_review_result_id` = `review_result_master`.`review_result_id`))));

--
-- Constraints for dumped tables
--

--
-- Constraints for table `database_user`
--
ALTER TABLE `database_user`
  ADD CONSTRAINT `database_user_ibfk_1` FOREIGN KEY (`database_user_name`) REFERENCES `role_master` (`role_name`);

--
-- Constraints for table `member_category_master`
--
ALTER TABLE `member_category_master`
  ADD CONSTRAINT `member_category_master_ibfk_1` FOREIGN KEY (`member_category_event_id`) REFERENCES `event_master` (`event_id`);

--
-- Constraints for table `member_master`
--
ALTER TABLE `member_master`
  ADD CONSTRAINT `member_master_ibfk_2` FOREIGN KEY (`member_organization_id`) REFERENCES `organization_master` (`organization_id`),
  ADD CONSTRAINT `member_master_ibfk_3` FOREIGN KEY (`member_category_id`) REFERENCES `member_category_master` (`member_category_id`);

--
-- Constraints for table `news_master`
--
ALTER TABLE `news_master`
  ADD CONSTRAINT `news_master_ibfk_1` FOREIGN KEY (`news_publisher_id`) REFERENCES `user_master` (`user_id`),
  ADD CONSTRAINT `news_master_ibfk_2` FOREIGN KEY (`news_event_id`) REFERENCES `event_master` (`event_id`);

--
-- Constraints for table `paper_master`
--
ALTER TABLE `paper_master`
  ADD CONSTRAINT `paper_master_ibfk_4` FOREIGN KEY (`paper_contact_author_id`) REFERENCES `member_master` (`member_id`),
  ADD CONSTRAINT `paper_master_ibfk_5` FOREIGN KEY (`paper_subject_id`) REFERENCES `subject_master` (`subject_id`);

--
-- Constraints for table `paper_version_master`
--
ALTER TABLE `paper_version_master`
  ADD CONSTRAINT `paper_version_master_ibfk_3` FOREIGN KEY (`paper_version_review_result_id`) REFERENCES `review_result_master` (`review_result_id`),
  ADD CONSTRAINT `paper_version_master_ibfk_4` FOREIGN KEY (`paper_id`) REFERENCES `paper_master` (`paper_id`),
  ADD CONSTRAINT `paper_version_master_ibfk_5` FOREIGN KEY (`paper_version_convener_id`) REFERENCES `user_master` (`user_id`);

--
-- Constraints for table `paper_version_review`
--
ALTER TABLE `paper_version_review`
  ADD CONSTRAINT `paper_version_review_ibfk_1` FOREIGN KEY (`paper_version_id`) REFERENCES `paper_version_master` (`paper_version_id`),
  ADD CONSTRAINT `paper_version_review_ibfk_2` FOREIGN KEY (`paper_version_reviewer_id`) REFERENCES `reviewer_master` (`reviewer_id`);

--
-- Constraints for table `privilege_role_mapper`
--
ALTER TABLE `privilege_role_mapper`
  ADD CONSTRAINT `privilege_role_mapper_ibfk_3` FOREIGN KEY (`privilege_id`) REFERENCES `privilege_master` (`privilege_id`),
  ADD CONSTRAINT `privilege_role_mapper_ibfk_4` FOREIGN KEY (`role_id`) REFERENCES `role_master` (`role_id`);

--
-- Constraints for table `reviewer_master`
--
ALTER TABLE `reviewer_master`
  ADD CONSTRAINT `reviewer_master_ibfk_1` FOREIGN KEY (`reviewer_id`) REFERENCES `user_master` (`user_id`),
  ADD CONSTRAINT `reviewer_master_ibfk_2` FOREIGN KEY (`reviewer_organization_id`) REFERENCES `organization_master` (`organization_id`);

--
-- Constraints for table `subject_master`
--
ALTER TABLE `subject_master`
  ADD CONSTRAINT `subject_master_ibfk_1` FOREIGN KEY (`subject_track_id`) REFERENCES `track_master` (`track_id`);

--
-- Constraints for table `submission_master`
--
ALTER TABLE `submission_master`
  ADD CONSTRAINT `submission_master_ibfk_2` FOREIGN KEY (`submission_member_id`) REFERENCES `member_master` (`member_id`),
  ADD CONSTRAINT `submission_master_ibfk_3` FOREIGN KEY (`submission_paper_id`) REFERENCES `paper_master` (`paper_id`);

--
-- Constraints for table `track_master`
--
ALTER TABLE `track_master`
  ADD CONSTRAINT `track_master_ibfk_1` FOREIGN KEY (`track_event_id`) REFERENCES `event_master` (`event_id`);

--
-- Constraints for table `user_event_role_mapper`
--
ALTER TABLE `user_event_role_mapper`
  ADD CONSTRAINT `user_event_role_mapper_ibfk_3` FOREIGN KEY (`event_id`) REFERENCES `event_master` (`event_id`),
  ADD CONSTRAINT `user_event_role_mapper_ibfk_4` FOREIGN KEY (`role_id`) REFERENCES `role_master` (`role_id`),
  ADD CONSTRAINT `user_event_role_mapper_ibfk_5` FOREIGN KEY (`user_id`) REFERENCES `user_master` (`user_id`);

--
-- Constraints for table `user_master`
--
ALTER TABLE `user_master`
  ADD CONSTRAINT `user_master_ibfk_1` FOREIGN KEY (`user_registrar`) REFERENCES `user_master` (`user_id`),
  ADD CONSTRAINT `user_master_ibfk_2` FOREIGN KEY (`user_organization_id`) REFERENCES `organization_master` (`organization_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
