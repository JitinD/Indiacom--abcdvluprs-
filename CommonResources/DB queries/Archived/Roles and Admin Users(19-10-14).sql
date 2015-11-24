-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2014 at 05:36 AM
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
-- Table structure for table `application_master`
--

CREATE TABLE IF NOT EXISTS `application_master` (
  `application_id` int(4) NOT NULL AUTO_INCREMENT,
  `application_name` varchar(50) NOT NULL,
  `DIRTY` tinyint(1) NOT NULL DEFAULT '0',
  `DOR` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `HASHTAG` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`application_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `application_master`
--

INSERT INTO `application_master` (`application_id`, `application_name`, `DIRTY`, `DOR`, `HASHTAG`) VALUES
(1, 'Indiacom Online System', 0, '2014-09-29 17:15:31', NULL),
(2, 'Bvicam Admin System', 0, '2014-09-29 17:15:31', NULL);

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

--
-- Dumping data for table `database_user`
--

INSERT INTO `database_user` (`database_user_name`, `database_user_password`, `database_user_hashtag`, `database_user_dor`, `database_user_dirty`) VALUES
('Author', '1234', NULL, '2014-10-06 07:21:17', 0),
('Minimal', '1234', NULL, '2014-10-06 07:21:19', 0),
('Minimal_Admin', '1234', NULL, '2014-10-06 07:21:18', 0),
('Role Manager', '1234', NULL, '2014-10-06 07:21:19', 0),
('Sample Role', '1234', NULL, '2014-10-06 07:21:17', 0),
('Super Admin', '1234', NULL, '2014-10-06 07:21:16', 0);

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

--
-- Dumping data for table `privilege_master`
--

INSERT INTO `privilege_master` (`privilege_id`, `privilege_entity`, `privilege_attribute`, `privilege_operation`, `privilege_hashtag`, `privilege_dor`, `privilege_dirty`) VALUES
('1', 'user_master', '', 'Select', NULL, '2014-09-30 19:43:56', 0),
('10', 'track_master', '', 'Update', NULL, '2014-09-30 19:43:56', 0),
('11', 'track_master', '', 'Insert', NULL, '2014-09-30 19:43:56', 0),
('12', 'track_master', '', 'Delete', NULL, '2014-09-30 19:43:56', 0),
('13', 'submission_master', '', 'Select', NULL, '2014-09-30 19:43:56', 0),
('14', 'submission_master', '', 'Update', NULL, '2014-09-30 19:43:56', 0),
('15', 'submission_master', '', 'Insert', NULL, '2014-09-30 19:43:56', 0),
('16', 'submission_master', '', 'Delete', NULL, '2014-09-30 19:43:56', 0),
('17', 'subject_master', '', 'Select', NULL, '2014-09-30 19:43:56', 0),
('18', 'subject_master', '', 'Update', NULL, '2014-09-30 19:43:56', 0),
('19', 'subject_master', '', 'Insert', NULL, '2014-09-30 19:43:56', 0),
('2', 'user_master', '', 'Update', NULL, '2014-09-30 19:43:56', 0),
('20', 'subject_master', '', 'Delete', NULL, '2014-09-30 19:43:56', 0),
('21', 'role_master', '', 'Select', NULL, '2014-09-30 19:43:56', 0),
('22', 'role_master', '', 'Update', NULL, '2014-09-30 19:43:56', 0),
('23', 'role_master', '', 'Insert', NULL, '2014-09-30 19:43:56', 0),
('24', 'role_master', '', 'Delete', NULL, '2014-09-30 19:43:56', 0),
('25', 'review_result_master', '', 'Select', NULL, '2014-09-30 19:43:56', 0),
('26', 'review_result_master', '', 'Update', NULL, '2014-09-30 19:43:56', 0),
('27', 'review_result_master', '', 'Insert', NULL, '2014-09-30 19:43:56', 0),
('28', 'review_result_master', '', 'Delete', NULL, '2014-09-30 19:43:56', 0),
('29', 'reviewer_master', '', 'Select', NULL, '2014-09-30 19:43:56', 0),
('3', 'user_master', '', 'Insert', NULL, '2014-09-30 19:43:56', 0),
('30', 'reviewer_master', '', 'Update', NULL, '2014-09-30 19:43:56', 0),
('31', 'reviewer_master', '', 'Insert', NULL, '2014-09-30 19:43:56', 0),
('32', 'reviewer_master', '', 'Delete', NULL, '2014-09-30 19:43:56', 0),
('33', 'privilege_role_mapper', '', 'Select', NULL, '2014-09-30 19:43:56', 0),
('34', 'privilege_role_mapper', '', 'Update', NULL, '2014-09-30 19:43:56', 0),
('35', 'privilege_role_mapper', '', 'Insert', NULL, '2014-09-30 19:43:56', 0),
('36', 'privilege_role_mapper', '', 'Delete', NULL, '2014-09-30 19:43:57', 0),
('37', 'privilege_master', '', 'Select', NULL, '2014-09-30 19:43:57', 0),
('38', 'privilege_master', '', 'Update', NULL, '2014-09-30 19:43:57', 0),
('39', 'privilege_master', '', 'Insert', NULL, '2014-09-30 19:43:57', 0),
('4', 'user_master', '', 'Delete', NULL, '2014-09-30 19:43:56', 0),
('40', 'privilege_master', '', 'Delete', NULL, '2014-09-30 19:43:57', 0),
('41', 'paper_version_review', '', 'Select', NULL, '2014-09-30 19:43:57', 0),
('42', 'paper_version_review', '', 'Update', NULL, '2014-09-30 19:43:57', 0),
('43', 'paper_version_review', '', 'Insert', NULL, '2014-09-30 19:43:57', 0),
('44', 'paper_version_review', '', 'Delete', NULL, '2014-09-30 19:43:57', 0),
('45', 'paper_version_master', '', 'Select', NULL, '2014-09-30 19:43:57', 0),
('46', 'paper_version_master', '', 'Update', NULL, '2014-09-30 19:43:57', 0),
('47', 'paper_version_master', '', 'Insert', NULL, '2014-09-30 19:43:57', 0),
('48', 'paper_version_master', '', 'Delete', NULL, '2014-09-30 19:43:57', 0),
('49', 'paper_master', '', 'Select', NULL, '2014-09-30 19:43:57', 0),
('5', 'user_event_role_mapper', '', 'Select', NULL, '2014-09-30 19:43:56', 0),
('50', 'paper_master', '', 'Update', NULL, '2014-09-30 19:43:57', 0),
('51', 'paper_master', '', 'Insert', NULL, '2014-09-30 19:43:57', 0),
('52', 'paper_master', '', 'Delete', NULL, '2014-09-30 19:43:57', 0),
('53', 'paper_latest_version', '', 'Select', NULL, '2014-09-30 19:43:57', 0),
('54', 'paper_latest_version', '', 'Update', NULL, '2014-09-30 19:43:57', 0),
('55', 'paper_latest_version', '', 'Insert', NULL, '2014-09-30 19:43:57', 0),
('56', 'paper_latest_version', '', 'Delete', NULL, '2014-09-30 19:43:57', 0),
('57', 'organization_master', '', 'Select', NULL, '2014-09-30 19:43:57', 0),
('58', 'organization_master', '', 'Update', NULL, '2014-09-30 19:43:57', 0),
('59', 'organization_master', '', 'Insert', NULL, '2014-09-30 19:43:57', 0),
('6', 'user_event_role_mapper', '', 'Update', NULL, '2014-09-30 19:43:56', 0),
('60', 'organization_master', '', 'Delete', NULL, '2014-09-30 19:43:57', 0),
('61', 'news_master', '', 'Select', NULL, '2014-09-30 19:43:57', 0),
('62', 'news_master', '', 'Update', NULL, '2014-09-30 19:43:57', 0),
('63', 'news_master', '', 'Insert', NULL, '2014-09-30 19:43:57', 0),
('64', 'news_master', '', 'Delete', NULL, '2014-09-30 19:43:57', 0),
('65', 'member_master', '', 'Select', NULL, '2014-09-30 19:43:57', 0),
('66', 'member_master', '', 'Update', NULL, '2014-09-30 19:43:57', 0),
('67', 'member_master', '', 'Insert', NULL, '2014-09-30 19:43:57', 0),
('68', 'member_master', '', 'Delete', NULL, '2014-09-30 19:43:57', 0),
('69', 'member_category_master', '', 'Select', NULL, '2014-09-30 19:43:57', 0),
('7', 'user_event_role_mapper', '', 'Insert', NULL, '2014-09-30 19:43:56', 0),
('70', 'member_category_master', '', 'Update', NULL, '2014-09-30 19:43:57', 0),
('71', 'member_category_master', '', 'Insert', NULL, '2014-09-30 19:43:57', 0),
('72', 'member_category_master', '', 'Delete', NULL, '2014-09-30 19:43:57', 0),
('73', 'event_master', '', 'Select', NULL, '2014-09-30 19:43:57', 0),
('74', 'event_master', '', 'Update', NULL, '2014-09-30 19:43:57', 0),
('75', 'event_master', '', 'Insert', NULL, '2014-09-30 19:43:57', 0),
('76', 'event_master', '', 'Delete', NULL, '2014-09-30 19:43:57', 0),
('77', 'database_user', '', 'Select', NULL, '2014-09-30 19:43:57', 0),
('78', 'database_user', '', 'Update', NULL, '2014-09-30 19:43:57', 0),
('79', 'database_user', '', 'Insert', NULL, '2014-09-30 19:43:57', 0),
('8', 'user_event_role_mapper', '', 'Delete', NULL, '2014-09-30 19:43:56', 0),
('80', 'database_user', '', 'Delete', NULL, '2014-09-30 19:43:57', 0),
('81', 'application_master', '', 'Select', NULL, '2014-09-30 19:43:57', 0),
('82', 'application_master', '', 'Update', NULL, '2014-09-30 19:43:57', 0),
('83', 'application_master', '', 'Insert', NULL, '2014-09-30 19:43:57', 0),
('84', 'application_master', '', 'Delete', NULL, '2014-09-30 19:43:57', 0),
('9', 'track_master', '', 'Select', NULL, '2014-09-30 19:43:56', 0);

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
('1', 23, NULL, '2014-09-30 14:13:57', 0),
('10', 23, NULL, '2014-09-30 14:13:57', 0),
('11', 23, NULL, '2014-09-30 14:13:57', 0),
('12', 23, NULL, '2014-09-30 14:13:58', 0),
('13', 23, NULL, '2014-09-30 14:13:58', 0),
('13', 24, NULL, '2014-09-30 14:16:51', 0),
('14', 23, NULL, '2014-09-30 14:13:58', 0),
('14', 24, NULL, '2014-09-30 14:16:51', 0),
('15', 23, NULL, '2014-09-30 14:13:58', 0),
('15', 24, NULL, '2014-09-30 14:16:51', 0),
('16', 23, NULL, '2014-09-30 14:13:58', 0),
('17', 23, NULL, '2014-09-30 14:13:58', 0),
('17', 24, NULL, '2014-09-30 14:16:51', 0),
('18', 23, NULL, '2014-09-30 14:13:58', 0),
('19', 23, NULL, '2014-09-30 14:13:58', 0),
('2', 23, NULL, '2014-09-30 14:13:57', 0),
('20', 23, NULL, '2014-09-30 14:13:58', 0),
('21', 23, NULL, '2014-09-30 14:13:58', 0),
('21', 32, NULL, '2014-10-01 13:02:27', 0),
('22', 23, NULL, '2014-09-30 14:13:58', 0),
('23', 23, NULL, '2014-09-30 14:13:58', 0),
('23', 32, NULL, '2014-10-01 13:02:27', 0),
('24', 23, NULL, '2014-09-30 14:13:58', 0),
('25', 23, NULL, '2014-09-30 14:13:58', 0),
('25', 24, NULL, '2014-09-30 14:16:51', 0),
('26', 23, NULL, '2014-09-30 14:13:58', 0),
('27', 23, NULL, '2014-09-30 14:13:58', 0),
('28', 23, NULL, '2014-09-30 14:13:58', 0),
('29', 23, NULL, '2014-09-30 14:13:58', 0),
('3', 23, NULL, '2014-09-30 14:13:57', 0),
('30', 23, NULL, '2014-09-30 14:13:58', 0),
('31', 23, NULL, '2014-09-30 14:13:58', 0),
('32', 23, NULL, '2014-09-30 14:13:58', 0),
('33', 23, NULL, '2014-09-30 14:13:58', 0),
('34', 23, NULL, '2014-09-30 14:13:58', 0),
('35', 23, NULL, '2014-09-30 14:13:58', 0),
('35', 32, NULL, '2014-10-01 13:02:27', 0),
('36', 23, NULL, '2014-09-30 14:13:58', 0),
('37', 23, NULL, '2014-09-30 14:13:58', 0),
('37', 32, NULL, '2014-10-01 13:02:27', 0),
('38', 23, NULL, '2014-09-30 14:13:58', 0),
('39', 23, NULL, '2014-09-30 14:13:58', 0),
('39', 32, NULL, '2014-10-01 13:02:27', 0),
('4', 23, NULL, '2014-09-30 14:13:57', 0),
('40', 23, NULL, '2014-09-30 14:13:58', 0),
('41', 23, NULL, '2014-09-30 14:13:58', 0),
('41', 29, NULL, '2014-10-01 07:30:15', 0),
('42', 23, NULL, '2014-09-30 14:13:58', 0),
('43', 23, NULL, '2014-09-30 14:13:58', 0),
('44', 23, NULL, '2014-09-30 14:13:58', 0),
('45', 23, NULL, '2014-09-30 14:13:58', 0),
('45', 24, NULL, '2014-09-30 14:16:51', 0),
('46', 23, NULL, '2014-09-30 14:13:58', 0),
('47', 23, NULL, '2014-09-30 14:13:58', 0),
('47', 24, NULL, '2014-09-30 14:16:51', 0),
('48', 23, NULL, '2014-09-30 14:13:58', 0),
('49', 23, NULL, '2014-09-30 14:13:58', 0),
('49', 24, NULL, '2014-09-30 14:16:51', 0),
('5', 23, NULL, '2014-09-30 14:13:57', 0),
('50', 23, NULL, '2014-09-30 14:13:58', 0),
('51', 23, NULL, '2014-09-30 14:13:58', 0),
('51', 24, NULL, '2014-09-30 14:16:51', 0),
('52', 23, NULL, '2014-09-30 14:13:58', 0),
('53', 23, NULL, '2014-09-30 14:13:58', 0),
('53', 24, NULL, '2014-09-30 14:16:51', 0),
('54', 23, NULL, '2014-09-30 14:13:58', 0),
('55', 23, NULL, '2014-09-30 14:13:58', 0),
('56', 23, NULL, '2014-09-30 14:13:58', 0),
('57', 23, NULL, '2014-09-30 14:13:58', 0),
('57', 24, NULL, '2014-09-30 14:16:51', 0),
('57', 31, NULL, '2014-10-01 11:53:30', 0),
('58', 23, NULL, '2014-09-30 14:13:58', 0),
('59', 23, NULL, '2014-09-30 14:13:58', 0),
('6', 23, NULL, '2014-09-30 14:13:57', 0),
('60', 23, NULL, '2014-09-30 14:13:58', 0),
('61', 23, NULL, '2014-09-30 14:13:58', 0),
('61', 24, NULL, '2014-09-30 14:16:51', 0),
('61', 31, NULL, '2014-10-01 11:53:30', 0),
('62', 23, NULL, '2014-09-30 14:13:58', 0),
('63', 23, NULL, '2014-09-30 14:13:58', 0),
('64', 23, NULL, '2014-09-30 14:13:58', 0),
('65', 23, NULL, '2014-09-30 14:13:58', 0),
('65', 24, NULL, '2014-09-30 14:16:51', 0),
('65', 31, NULL, '2014-10-01 11:53:30', 0),
('66', 23, NULL, '2014-09-30 14:13:58', 0),
('66', 24, NULL, '2014-09-30 14:16:51', 0),
('66', 31, NULL, '2014-10-04 10:36:30', 0),
('67', 23, NULL, '2014-09-30 14:13:58', 0),
('67', 31, NULL, '2014-10-01 11:53:30', 0),
('68', 23, NULL, '2014-09-30 14:13:59', 0),
('69', 23, NULL, '2014-09-30 14:13:59', 0),
('69', 24, NULL, '2014-09-30 14:16:51', 0),
('69', 31, NULL, '2014-10-01 11:53:30', 0),
('7', 23, NULL, '2014-09-30 14:13:57', 0),
('70', 23, NULL, '2014-09-30 14:13:59', 0),
('71', 23, NULL, '2014-09-30 14:13:59', 0),
('72', 23, NULL, '2014-09-30 14:13:59', 0),
('73', 23, NULL, '2014-09-30 14:13:59', 0),
('73', 24, NULL, '2014-09-30 14:16:51', 0),
('73', 30, NULL, '2014-10-01 11:52:18', 0),
('74', 23, NULL, '2014-09-30 14:13:59', 0),
('75', 23, NULL, '2014-09-30 14:13:59', 0),
('76', 23, NULL, '2014-09-30 14:13:59', 0),
('77', 23, NULL, '2014-09-30 14:13:59', 0),
('78', 23, NULL, '2014-09-30 14:13:59', 0),
('79', 23, NULL, '2014-09-30 14:13:59', 0),
('79', 32, NULL, '2014-10-01 13:02:27', 0),
('8', 23, NULL, '2014-09-30 14:13:57', 0),
('80', 23, NULL, '2014-09-30 14:13:59', 0),
('81', 23, NULL, '2014-09-30 14:13:59', 0),
('82', 23, NULL, '2014-09-30 14:13:59', 0),
('83', 23, NULL, '2014-09-30 14:13:59', 0),
('84', 23, NULL, '2014-09-30 14:13:59', 0),
('9', 23, NULL, '2014-09-30 14:13:57', 0),
('9', 24, NULL, '2014-09-30 14:16:51', 0);

-- --------------------------------------------------------

--
-- Table structure for table `role_master`
--

CREATE TABLE IF NOT EXISTS `role_master` (
  `role_id` int(8) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(32) NOT NULL,
  `role_application_id` int(4) NOT NULL,
  `role_hashtag` varchar(64) DEFAULT NULL,
  `role_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `role_name` (`role_name`),
  KEY `application_id` (`role_application_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `role_master`
--

INSERT INTO `role_master` (`role_id`, `role_name`, `role_application_id`, `role_hashtag`, `role_dor`, `role_dirty`) VALUES
(23, 'Super Admin', 2, NULL, '2014-09-30 14:13:56', 0),
(24, 'Author', 1, NULL, '2014-09-30 14:16:51', 0),
(29, 'Sample Role', 2, NULL, '2014-10-01 07:30:15', 0),
(30, 'Minimal_Admin', 2, NULL, '2014-10-01 11:52:17', 0),
(31, 'Minimal', 1, NULL, '2014-10-01 11:53:30', 0),
(32, 'Role Manager', 2, NULL, '2014-10-01 13:02:26', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_event_role_mapper`
--

CREATE TABLE IF NOT EXISTS `user_event_role_mapper` (
  `user_id` int(8) NOT NULL,
  `role_id` int(8) NOT NULL,
  `user_event_role_mapper_hashtag` varchar(64) DEFAULT NULL,
  `user_event_role_mapper_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_event_role_mapper_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_event_role_mapper`
--

INSERT INTO `user_event_role_mapper` (`user_id`, `role_id`, `user_event_role_mapper_hashtag`, `user_event_role_mapper_dor`, `user_event_role_mapper_dirty`) VALUES
(7, 23, NULL, '2014-10-01 07:02:42', 0),
(7, 24, NULL, '2014-10-01 11:47:28', 0),
(7, 29, NULL, '2014-10-01 07:45:42', 0),
(7, 32, NULL, '2014-10-01 13:02:37', 0),
(23, 24, NULL, '2014-10-01 07:53:14', 0),
(23, 29, NULL, '2014-10-01 07:53:14', 0);

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
  UNIQUE KEY `user_email` (`user_email`),
  KEY `user_registrar` (`user_registrar`),
  KEY `user_organization_id` (`user_organization_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `user_master`
--

INSERT INTO `user_master` (`user_id`, `user_name`, `user_organization_id`, `user_designation`, `user_address`, `user_office_address`, `user_mobile`, `user_department`, `user_email`, `user_password`, `user_registrar`, `user_hashtag`, `user_dor`, `user_dirty`) VALUES
(7, 'Saurav Deb Purkayastha', NULL, NULL, NULL, NULL, NULL, NULL, 'sauravdebp@gmail.com', '1234', NULL, NULL, '2014-09-30 18:52:58', 0),
(23, 'Sample User', NULL, NULL, NULL, NULL, NULL, NULL, 'sample@mail.com', '1234', 7, NULL, '2014-10-01 07:53:14', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `database_user`
--
ALTER TABLE `database_user`
  ADD CONSTRAINT `database_user_ibfk_1` FOREIGN KEY (`database_user_name`) REFERENCES `role_master` (`role_name`);

--
-- Constraints for table `privilege_role_mapper`
--
ALTER TABLE `privilege_role_mapper`
  ADD CONSTRAINT `privilege_role_mapper_ibfk_3` FOREIGN KEY (`privilege_id`) REFERENCES `privilege_master` (`privilege_id`),
  ADD CONSTRAINT `privilege_role_mapper_ibfk_4` FOREIGN KEY (`role_id`) REFERENCES `role_master` (`role_id`);

--
-- Constraints for table `role_master`
--
ALTER TABLE `role_master`
  ADD CONSTRAINT `role_master_ibfk_1` FOREIGN KEY (`role_application_id`) REFERENCES `application_master` (`application_id`);

--
-- Constraints for table `user_event_role_mapper`
--
ALTER TABLE `user_event_role_mapper`
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
