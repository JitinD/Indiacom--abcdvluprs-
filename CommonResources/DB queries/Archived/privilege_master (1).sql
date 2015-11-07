-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2015 at 08:10 PM
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
-- Table structure for table `privilege_master`
--

CREATE TABLE IF NOT EXISTS `privilege_master` (
  `privilege_id` varchar(8) NOT NULL,
  `privilege_entity` varchar(50) NOT NULL,
  `privilege_application` int(4) NOT NULL,
  `privilege_operation` varchar(50) NOT NULL,
  `privilege_hashtag` varchar(64) DEFAULT NULL,
  `privilege_dor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `privilege_dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`privilege_id`,`privilege_application`),
  KEY `privilege_application` (`privilege_application`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `privilege_master`
--

INSERT INTO `privilege_master` (`privilege_id`, `privilege_entity`, `privilege_application`, `privilege_operation`, `privilege_hashtag`, `privilege_dor`, `privilege_dirty`) VALUES
('A0', 'AJAX', 1, 'fetchOrganisationNames', NULL, '2015-09-15 05:04:07', 0),
('A1', 'AJAX', 1, 'tracks', NULL, '2015-09-15 05:04:07', 0),
('A2', 'AJAX', 1, 'subjects', NULL, '2015-09-15 05:04:07', 0),
('AM0', 'AttendanceManager', 2, 'markDeskAttendance_AJAX', NULL, '2015-09-15 05:03:28', 0),
('AM1', 'AttendanceManager', 2, 'markTrackAttendance_AJAX', NULL, '2015-09-15 05:03:28', 0),
('CM0', 'CertificateManager', 2, 'markOutwardNumber_AJAX', NULL, '2015-09-15 05:03:28', 0),
('CM1', 'CertificateManager', 2, 'markCertificateGiven_AJAX', NULL, '2015-09-15 05:03:28', 0),
('CM2', 'CertificateManager', 2, 'removeCertificateRecord_AJAX', NULL, '2015-09-15 05:03:28', 0),
('D0', 'Dashboard', 1, 'home', NULL, '2015-09-15 05:04:07', 0),
('D1', 'Dashboard', 1, 'uploadBiodata', NULL, '2015-09-15 05:04:07', 0),
('D10', 'Dashboard', 1, 'validateConfirmPassword', NULL, '2015-09-15 05:04:07', 0),
('D11', 'Dashboard', 1, 'downloadBiodata', NULL, '2015-09-15 05:04:07', 0),
('D12', 'Dashboard', 1, 'editProfile', NULL, '2015-09-15 05:04:07', 0),
('D13', 'Dashboard', 1, 'payment', NULL, '2015-09-15 05:04:07', 0),
('D14', 'Dashboard', 1, 'transaction', NULL, '2015-09-15 05:04:07', 0),
('D15', 'Dashboard', 1, 'payablesChart', NULL, '2015-09-15 05:04:07', 0),
('D16', 'Dashboard', 1, 'request_special_session', NULL, '2015-09-15 05:04:07', 0),
('D17', 'Dashboard', 1, 'special_sessions_list', NULL, '2015-09-15 05:04:07', 0),
('D18', 'Dashboard', 1, 'my_special_session', NULL, '2015-09-15 05:04:07', 0),
('D19', 'Dashboard', 1, 'special_session', NULL, '2015-09-15 05:04:07', 0),
('D2', 'Dashboard', 1, 'submitpaper', NULL, '2015-09-15 05:04:07', 0),
('D20', 'Dashboard', 1, 'special_session_details', NULL, '2015-09-15 05:04:07', 0),
('D21', 'Dashboard', 1, 'edit_session_Chairperson', NULL, '2015-09-15 05:04:07', 0),
('D22', 'Dashboard', 1, 'add_aoc', NULL, '2015-09-15 05:04:07', 0),
('D23', 'Dashboard', 1, 'add_tpc', NULL, '2015-09-15 05:04:07', 0),
('D3', 'Dashboard', 1, 'authorsCheck', NULL, '2015-09-15 05:04:07', 0),
('D4', 'Dashboard', 1, 'paperTitleCheck', NULL, '2015-09-15 05:04:07', 0),
('D5', 'Dashboard', 1, 'submitPaperRevision', NULL, '2015-09-15 05:04:07', 0),
('D6', 'Dashboard', 1, 'paperInfo', NULL, '2015-09-15 05:04:07', 0),
('D7', 'Dashboard', 1, 'changePassword', NULL, '2015-09-15 05:04:07', 0),
('D8', 'Dashboard', 1, 'resetPassword', NULL, '2015-09-15 05:04:07', 0),
('D9', 'Dashboard', 1, 'validateCurrentPassword', NULL, '2015-09-15 05:04:07', 0),
('DeM0', 'DeliverablesManager', 2, 'assignDeliverables_AJAX', NULL, '2015-09-15 05:03:28', 0),
('DeM1', 'DeliverablesManager', 2, 'assignMemberDeliverables', NULL, '2015-09-15 05:03:28', 0),
('DeM2', 'DeliverablesManager', 2, 'assignPaperDeliverables', NULL, '2015-09-15 05:03:28', 0),
('DM0', 'DeskManager', 2, 'home', NULL, '2015-09-15 05:03:28', 0),
('DM1', 'DeskManager', 2, 'viewPaperAuthorsPayments', NULL, '2015-09-15 05:03:28', 0),
('DM2', 'DeskManager', 2, 'viewAuthorPapersPayments', NULL, '2015-09-15 05:03:28', 0),
('EM0', 'EventManager', 2, 'load', NULL, '2015-09-20 18:07:41', 0),
('EM1', 'EventManager', 2, 'newEvent', NULL, '2015-09-20 18:07:41', 0),
('EM2', 'EventManager', 2, 'viewEvent', NULL, '2015-09-20 18:08:03', 0),
('FPR0', 'FinalPaperReviewer', 2, 'load', NULL, '2015-09-15 05:03:28', 0),
('FPR1', 'FinalPaperReviewer', 2, 'setReviewerAssigned', NULL, '2015-09-15 05:03:28', 0),
('FPR2', 'FinalPaperReviewer', 2, 'paperInfo', NULL, '2015-09-15 05:03:28', 0),
('IPR0', 'InitialPaperReviewer', 2, 'load', NULL, '2015-09-15 05:03:28', 0),
('IPR1', 'InitialPaperReviewer', 2, 'reviewPaperInfo', NULL, '2015-09-15 05:03:28', 0),
('L0', 'Login', 1, 'index', NULL, '2015-09-15 05:04:06', 0),
('L1', 'Login', 1, 'usernameCheck', NULL, '2015-09-15 05:04:07', 0),
('L2', 'Login', 1, 'passwordCheck', NULL, '2015-09-15 05:04:07', 0),
('L3', 'Login', 1, 'logout', NULL, '2015-09-15 05:04:07', 0),
('MC0', 'MainController', 1, 'viewPage', NULL, '2015-09-15 05:04:06', 0),
('MC1', 'MainController', 1, 'index', NULL, '2015-09-15 05:04:06', 0),
('N0', 'News', 1, 'load', NULL, '2015-09-15 05:04:07', 0),
('N1', 'News', 1, 'viewNews', NULL, '2015-09-15 05:04:07', 0),
('NM0', 'NewsManager', 2, 'load', NULL, '2015-09-15 05:03:27', 0),
('NM_IOS0', 'NewsManager_IndiacomOnlineSystem', 2, 'addNews', NULL, '2015-09-15 05:03:27', 0),
('NM_IOS1', 'NewsManager_IndiacomOnlineSystem', 2, 'disableNews', NULL, '2015-09-15 05:03:27', 0),
('NM_IOS2', 'NewsManager_IndiacomOnlineSystem', 2, 'enableNews', NULL, '2015-09-15 05:03:27', 0),
('NM_IOS3', 'NewsManager_IndiacomOnlineSystem', 2, 'deleteNews', NULL, '2015-09-15 05:03:27', 0),
('P0', 'Page', 2, 'home', NULL, '2015-09-15 05:03:29', 0),
('PM0', 'PaymentsManager', 2, 'load', NULL, '2015-09-15 05:03:28', 0),
('PM1', 'PaymentsManager', 2, 'viewPaymentsMemberWise', NULL, '2015-09-15 05:03:28', 0),
('PM2', 'PaymentsManager', 2, 'viewPaymentsPaperWise', NULL, '2015-09-15 05:03:28', 0),
('PM3', 'PaymentsManager', 2, 'newPayment', NULL, '2015-09-15 05:03:28', 0),
('PM4', 'PaymentsManager', 2, 'paymentBreakup', NULL, '2015-09-15 05:03:28', 0),
('PM5', 'PaymentsManager', 2, 'changePayableClass', NULL, '2015-09-15 05:03:28', 0),
('PM6', 'PaymentsManager', 2, 'changeDiscountType', NULL, '2015-09-15 05:03:28', 0),
('PM7', 'PaymentsManager', 2, 'paymentWaiveOffAJAX', NULL, '2015-09-15 05:03:28', 0),
('PM8', 'PaymentsManager', 2, 'spotPayments', NULL, '2015-09-15 05:03:28', 0),
('R0', 'Registration', 1, 'validate_captcha', NULL, '2015-09-15 05:04:06', 0),
('R1', 'Registration', 1, 'validate_mobileNumber', NULL, '2015-09-15 05:04:06', 0),
('R2', 'Registration', 1, 'validate_confirm_password', NULL, '2015-09-15 05:04:06', 0),
('R3', 'Registration', 1, 'formFilledCheck', NULL, '2015-09-15 05:04:06', 0),
('R4', 'Registration', 1, 'forgotPassword', NULL, '2015-09-15 05:04:06', 0),
('R5', 'Registration', 1, 'signUp', NULL, '2015-09-15 05:04:06', 0),
('R6', 'Registration', 1, 'EnterPassword', NULL, '2015-09-15 05:04:06', 0),
('ReM0', 'ReportManager', 2, 'downloadReport', NULL, '2015-09-15 05:03:28', 0),
('ReM1', 'ReportManager', 2, 'getReport', NULL, '2015-09-15 05:03:28', 0),
('ReM2', 'ReportManager', 2, 'home', NULL, '2015-09-15 05:03:28', 0),
('ReM3', 'ReportManager', 2, 'paymentsReport', NULL, '2015-09-15 05:03:28', 0),
('RM0', 'RoleManager', 2, 'load', NULL, '2015-09-15 05:03:27', 0),
('RM1', 'RoleManager', 2, 'newRole', NULL, '2015-09-15 05:03:27', 0),
('RM2', 'RoleManager', 2, 'viewRole', NULL, '2015-09-15 05:03:27', 0),
('RM3', 'RoleManager', 2, 'enableRolePrivilege', NULL, '2015-09-15 05:03:27', 0),
('RM4', 'RoleManager', 2, 'disableRolePrivilege', NULL, '2015-09-15 05:03:27', 0),
('RM5', 'RoleManager', 2, 'addRolePrivilege', NULL, '2015-09-15 05:03:27', 0),
('RM6', 'RoleManager', 2, 'deleteRolePrivilege', NULL, '2015-09-15 05:03:27', 0),
('RM7', 'RoleManager', 2, 'disableRole', NULL, '2015-09-15 05:03:27', 0),
('RM8', 'RoleManager', 2, 'enableRole', NULL, '2015-09-15 05:03:27', 0),
('RM9', 'RoleManager', 2, 'deleteRole', NULL, '2015-09-15 05:03:27', 0),
('SSR0', 'SpecialSessionRequests', 2, 'session_details', NULL, '2015-09-15 05:03:29', 0),
('SSR1', 'SpecialSessionRequests', 2, 'add_sessions', NULL, '2015-09-15 05:03:29', 0),
('SSR2', 'SpecialSessionRequests', 2, 'view_sessions', NULL, '2015-09-15 05:03:29', 0),
('SSR3', 'SpecialSessionRequests', 2, 'verify_sessions_tracks', NULL, '2015-09-15 05:03:29', 0),
('SSR4', 'SpecialSessionRequests', 2, 'view_request_fail', NULL, '2015-09-15 05:03:29', 0),
('SSR5', 'SpecialSessionRequests', 2, 'view_request_success', NULL, '2015-09-15 05:03:29', 0),
('TM0', 'TransactionManager', 2, 'newTransaction', NULL, '2015-09-15 05:03:28', 0),
('TM1', 'TransactionManager', 2, 'loadUnusedTransactions', NULL, '2015-09-15 05:03:28', 0),
('TM2', 'TransactionManager', 2, 'load', NULL, '2015-09-15 05:03:28', 0),
('TM3', 'TransactionManager', 2, 'viewTransaction', NULL, '2015-09-15 05:03:28', 0),
('TM4', 'TransactionManager', 2, 'setTransactionVerificationStatus_AJAX', NULL, '2015-09-15 05:03:28', 0),
('TraM0', 'TrackManager', 2, 'home', NULL, '2015-09-15 05:03:28', 0),
('TraM1', 'TrackManager', 2, 'markAuthorAttendance', NULL, '2015-09-15 05:03:28', 0),
('TraM2', 'TrackManager', 2, 'markPaperAttendance', NULL, '2015-09-15 05:03:28', 0),
('UM0', 'UserManager', 2, 'load', NULL, '2015-09-15 05:03:27', 0),
('UM1', 'UserManager', 2, 'newUser', NULL, '2015-09-15 05:03:27', 0),
('UM2', 'UserManager', 2, 'viewUser', NULL, '2015-09-15 05:03:27', 0),
('UM3', 'UserManager', 2, 'enableUser', NULL, '2015-09-15 05:03:27', 0),
('UM4', 'UserManager', 2, 'disableUser', NULL, '2015-09-15 05:03:27', 0),
('UM5', 'UserManager', 2, 'deleteUser', NULL, '2015-09-15 05:03:27', 0),
('UM6', 'UserManager', 2, 'enableUserRole', NULL, '2015-09-15 05:03:27', 0),
('UM7', 'UserManager', 2, 'disableUserRole', NULL, '2015-09-15 05:03:28', 0),
('UM8', 'UserManager', 2, 'deleteUserRole', NULL, '2015-09-15 05:03:28', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `privilege_master`
--
ALTER TABLE `privilege_master`
  ADD CONSTRAINT `privilege_master_ibfk_1` FOREIGN KEY (`privilege_application`) REFERENCES `application_master` (`application_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
