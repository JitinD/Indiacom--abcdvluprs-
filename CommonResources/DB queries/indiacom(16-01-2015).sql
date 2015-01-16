--
-- MySQL 5.5.36
-- Fri, 16 Jan 2015 15:10:43 +0000
--

CREATE TABLE `application_master` (
   `application_id` int(4) not null auto_increment,
   `application_name` varchar(50) not null,
   `DIRTY` tinyint(1) not null default '0',
   `DOR` timestamp not null default CURRENT_TIMESTAMP,
   `HASHTAG` varchar(64),
   PRIMARY KEY (`application_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=3;

INSERT INTO `application_master` (`application_id`, `application_name`, `DIRTY`, `DOR`, `HASHTAG`) VALUES 
('1', 'Indiacom Online System', '0', '2014-09-29 10:15:31', ''),
('2', 'Bvicam Admin System', '0', '2014-09-29 10:15:31', '');

CREATE TABLE `database_user` (
   `database_user_name` varchar(32) not null,
   `database_user_password` varchar(64) not null,
   `database_user_hashtag` varchar(64),
   `database_user_dor` timestamp not null default CURRENT_TIMESTAMP,
   `database_user_dirty` tinyint(1) not null default '0',
   PRIMARY KEY (`database_user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `database_user` (`database_user_name`, `database_user_password`, `database_user_hashtag`, `database_user_dor`, `database_user_dirty`) VALUES 
('Author', '1234', '', '2014-10-18 21:15:33', '0'),
('LimitedAuthor', '1234', '', '2014-10-25 00:39:44', '0'),
('Minimal', '1234', '', '2014-10-18 21:11:41', '0'),
('Minimal_Admin', '1234', '', '2014-10-18 21:11:41', '0'),
('Reviewer', '1234', '', '2014-11-01 03:53:17', '0'),
('Role Manager', '1234', '', '2014-10-18 21:11:41', '0'),
('Sample Role', '1234', '', '2014-10-18 21:15:34', '0'),
('Super Admin', '1234', '', '2014-10-18 21:11:04', '0');

CREATE TABLE `event_master` (
   `event_id` int(8) not null auto_increment,
   `event_name` varchar(50) not null,
   `event_description` varchar(200),
   `event_start_date` datetime not null,
   `event_end_date` datetime not null,
   `event_paper_submission_start_date` datetime,
   `event_paper_submission_end_date` datetime,
   `event_abstract_submission_end_date` datetime,
   `event_abstract_acceptance_notification` datetime,
   `event_paper_submission_notification` datetime,
   `event_review_info_avail_after` datetime,
   `event_clear_min_dues_by` datetime,
   `event_email` varchar(150),
   `event_info` varchar(300),
   `event_attachment` varchar(300),
   `event_hashtag` varchar(64),
   `event_dor` timestamp not null default CURRENT_TIMESTAMP,
   `event_dirty` tinyint(1) not null default '0',
   PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=3;

INSERT INTO `event_master` (`event_id`, `event_name`, `event_description`, `event_start_date`, `event_end_date`, `event_paper_submission_start_date`, `event_paper_submission_end_date`, `event_abstract_submission_end_date`, `event_abstract_acceptance_notification`, `event_paper_submission_notification`, `event_review_info_avail_after`, `event_clear_min_dues_by`, `event_email`, `event_info`, `event_attachment`, `event_hashtag`, `event_dor`, `event_dirty`) VALUES 
('1', 'IndiaCom 2015', 'Hello World', '2015-04-08 00:00:00', '2015-04-11 00:00:00', '', '', '', '', '', '', '', '', '', '', '', '2014-07-22 06:52:38', '0'),
('2', 'NSC 2015', 'Hello World', '2015-04-12 00:00:00', '2015-04-22 00:00:00', '', '', '', '', '', '', '', '', '', '', '', '2014-07-22 06:53:08', '0');

CREATE TABLE `indiacom_news_attachments` (
   `attachment_id` int(8) not null auto_increment,
   `news_id` int(8) not null,
   `attachment_name` varchar(50),
   `attachment_url` varchar(100) not null,
   `news_attachments_dirty` tinyint(1) not null default '0',
   `news_attachments_dor` timestamp not null default CURRENT_TIMESTAMP,
   `news_attachments_hashtag` varchar(64),
   PRIMARY KEY (`attachment_id`),
   KEY `news_id` (`news_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=10;

INSERT INTO `indiacom_news_attachments` (`attachment_id`, `news_id`, `attachment_name`, `attachment_url`, `news_attachments_dirty`, `news_attachments_dor`, `news_attachments_hashtag`) VALUES 
('5', '1', 'Minimal Privileges.pdf', 'Indiacom2015/uploads/News/Attachments/attachment_1_0.pdf', '0', '2014-10-24 10:49:15', ''),
('6', '2', 'A4_Q3.docx', 'indiacom2015/uploads/News/Attachments/attachment_2_0.docx', '0', '2014-12-12 07:15:20', ''),
('7', '2', 'A7Q2.docx', 'indiacom2015/uploads/News/Attachments/attachment_2_1.docx', '0', '2014-12-12 07:15:20', ''),
('8', '2', 'A7Q4.docx', 'indiacom2015/uploads/News/Attachments/attachment_2_2.docx', '0', '2014-12-12 07:15:20', ''),
('9', '3', 'test document', 'indiacom2015/uploads/News/Attachments/attachment_3_0.docx', '0', '2014-12-28 12:04:54', '');

CREATE TABLE `indiacom_news_master` (
   `news_id` int(8) not null,
   `news_sticky_date` datetime,
   `news_event_id` int(8) not null,
   `news_master_dirty` tinyint(1) not null default '0',
   `news_master_dor` timestamp not null default CURRENT_TIMESTAMP,
   `news_master_hashtag` varchar(64),
   PRIMARY KEY (`news_id`),
   KEY `news_event_id` (`news_event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `indiacom_news_master` (`news_id`, `news_sticky_date`, `news_event_id`, `news_master_dirty`, `news_master_dor`, `news_master_hashtag`) VALUES 
('1', '', '1', '0', '2014-10-24 10:49:14', ''),
('2', '', '1', '0', '2014-12-12 07:15:19', ''),
('3', '2014-12-30 00:00:00', '1', '0', '2014-12-28 12:04:54', '');

CREATE TABLE `member_category_master` (
   `member_category_id` int(4) not null auto_increment,
   `member_category_name` varchar(64) not null,
   `member_category_event_id` int(8) not null,
   `member_category_hashtag` varchar(64),
   `member_category_dor` timestamp not null default CURRENT_TIMESTAMP,
   `member_category_dirty` tinyint(1) not null default '0',
   PRIMARY KEY (`member_category_id`),
   KEY `member_category_event_id` (`member_category_event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=7;

INSERT INTO `member_category_master` (`member_category_id`, `member_category_name`, `member_category_event_id`, `member_category_hashtag`, `member_category_dor`, `member_category_dirty`) VALUES 
('1', 'Research Student', '1', '', '2014-07-25 11:01:51', '0'),
('2', 'Student', '1', '', '2014-07-25 11:01:51', '0'),
('5', 'Faculty', '1', '', '2014-07-25 11:02:36', '0'),
('6', 'Industry Representative', '1', '', '2014-07-25 11:02:36', '0');

CREATE TABLE `member_master` (
   `member_id` varchar(10) not null,
   `member_salutation` varchar(5) not null,
   `member_name` varchar(50) not null,
   `member_address` varchar(100) not null,
   `member_pincode` varchar(10) not null,
   `member_email` varchar(100) not null,
   `member_phone` varchar(20),
   `member_country_code` varchar(5) not null,
   `member_mobile` varchar(20) not null,
   `member_fax` varchar(20),
   `member_designation` varchar(20),
   `member_csi_mem_no` varchar(30),
   `member_iete_mem_no` varchar(30),
   `member_password` varchar(64) not null,
   `member_organization_id` int(8),
   `member_department` varchar(100) not null,
   `member_biodata_path` varchar(100),
   `member_category_id` int(4),
   `member_experience` varchar(4),
   `member_is_activated` tinyint(1) not null default '0',
   `member_hashtag` varchar(64),
   `member_dor` timestamp not null default CURRENT_TIMESTAMP,
   `member_dirty` tinyint(1) not null default '0',
   PRIMARY KEY (`member_id`),
   KEY `member_organization_id` (`member_organization_id`),
   KEY `member_category_id` (`member_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `member_master` (`member_id`, `member_salutation`, `member_name`, `member_address`, `member_pincode`, `member_email`, `member_phone`, `member_country_code`, `member_mobile`, `member_fax`, `member_designation`, `member_csi_mem_no`, `member_iete_mem_no`, `member_password`, `member_organization_id`, `member_department`, `member_biodata_path`, `member_category_id`, `member_experience`, `member_is_activated`, `member_hashtag`, `member_dor`, `member_dirty`) VALUES 
('1', '', 'Jitin', 'Block - 22/2, Nurses Residential Complex, Srinivaspuri', '110065', 'jitin.dominic01@gmail.com', '011-26922416', '', '9560365906', '09439', '', '3284823', '320948203', '202cb962ac59075b964b07152d234b70', '1', '', '0', '2', '12', '1', '', '2014-07-25 12:49:19', '0'),
('2', '', 'Sachin', 'Block - 22/2, Nurses Residential Complex, Srinivaspuri', '110065', 'sachin.dominic08@gmail.com', '011-26922416', '', '9560365906', '', '', '3284823', '2323', 'EoFRt4jSK7NWdCuw/6DFl/xiKKK0wUs0TpDCpc9o3opIQJlro95Yk4wQyZ+WgW1n', '2', '', '0', '5', '11', '0', '', '2014-07-25 12:50:42', '0'),
('3', '', 'Saurav Deb P.', 'E-168, Sector 41, Noida', '201303', 'sauravdebp@gmail.com', '01204319850', '', '9818865297', '', '', '', '', '81dc9bdb52d04dc20036dbd8313ed055', '2', '', '0', '2', '0', '0', '', '2014-07-28 02:57:28', '0'),
('31', '', 'Walter', 'Albuquerque', '95678', 'jitshi92@gmail.com', '34567892', '', '987654', '678', 'Professor', '789', '789', '202cb962ac59075b964b07152d234b70', '2', 'Meth Department', '0', '5', '12', '0', '', '2014-08-02 06:19:47', '0'),
('32', '', 'Jitin Dominic', 'New Delhi', '9399', 'jitin.dominic01@gmail.com', '080980980', '', '80980808', '', '', '', '', '67891432', '2', 'CS', '0', '2', '5', '0', '', '2014-08-27 18:10:02', '0'),
('33', 'Mr', 'Tywin Lannister', '23434', '212332', 'sauravdebp@gmail.com', '4319850', '91', '9818865297', '', 'CEO', '4354534', '2216445', '81dc9bdb52d04dc20036dbd8313ed055', '2', 'Products Research', 'Indiacom2015/uploads/biodata_temp/1_biodata.pdf', '6', '1', '1', '', '2014-10-25 01:22:14', '0'),
('34', 'Mr', 'Saurav Deb Purkayastha', 'E-168, Sector 41', '201303', 'sauravdebp@gmail.com', '09818865297', '09818', '0981886529', '', '', '', '', '81dc9bdb52d04dc20036dbd8313ed055', '1', 'MCA', '0', '2', '', '1', '', '2014-11-27 05:12:50', '0'),
('35', 'Mr', 'Claire Dunphy', 'New York', '111222', 'sauravdebp@gmail.com', '882832371', '88', '9928381232', '', '', '', '', '81dc9bdb52d04dc20036dbd8313ed055', '1', 'MCA', '0', '2', '', '1', '', '2014-11-27 06:01:36', '0'),
('36', 'Mr', 'Saurav Deb Purkayastha', 'E-168, Sector 41', '201303', 'sauravdebp@gmail.com', '09818865297', '09818', '0981886529', '', '', '', '', '81dc9bdb52d04dc20036dbd8313ed055', '1', 'MCA', '0', '2', '', '1', '', '2014-11-27 07:57:35', '0'),
('37', 'Mr', 'Saurav Deb Purkayastha', 'E-168, Sector 41', '201303', 'sauravdebp@gmail.com', '09818865297', '09818', '0981886529', '', '', '', '', '81dc9bdb52d04dc20036dbd8313ed055', '1', 'MCA', 'indiacom2015/uploads/biodata_temp/7_biodata.pdf', '2', '', '1', '', '2014-11-27 08:04:16', '0'),
('38', 'Mr', 'Saurav Deb Purkayastha', 'E-168, Sector 41', '201303', 'sauravdebp@gmail.com', '09818865297', '09818', '0981886529', '', '', '', '', '81dc9bdb52d04dc20036dbd8313ed055', '1', 'MCA', 'indiacom2015/uploads/biodata_temp/7_biodata.pdf', '2', '', '1', '', '2014-11-27 08:08:03', '0'),
('39', 'Mr', 'Phillip Hughes', 'New Delhi', '110065', 'jitinthegreat1@gmail.com', '20202020202020', '91', '9560365906', '', 'Batsman', '', '', '81dc9bdb52d04dc20036dbd8313ed055', '2', 'Cricket', '0', '6', '5', '1', '', '2014-12-01 06:34:54', '0'),
('40', 'Mrs', 'shalini singh', 'delhi', '110063', 'shalini.jaspal@gmail.com', '+911123711234', '+9111', '1234567890', '', 'Asst. Proffesor', '1234', '', 'fc7aabdf0051aa1f4c9a2c6c2d53ae94', '1', 'MCA', '0', '5', '10', '0', '', '2014-12-02 21:09:13', '0'),
('41', 'Mr', 'Samuel', 'E-168, Sector 41', '201303', 'sauravdebp@gmail.com', '01204319850', '91', '9818865297', '', '', '', '', 'e10adc3949ba59abbe56e057f20f883e', '1', 'MCA', 'indiacom2015/uploads/biodata_temp/1_biodata.pdf', '2', '', '1', '', '2014-12-02 23:33:51', '0'),
('42', 'Mrs', 'shalini', 'delhi', '110088', 'ssj_bvicam@yahoo.com', '1234567890', '91', '1234567890', '1111111', 'Asst. Proffesor', '1234', '', '400a852ae8f149ef9aa2d1ecc0959600', '1', 'MCA', '0', '5', '10', '1', '', '2014-12-28 21:50:51', '0'),
('9', '', 'Jitin Dominic', 'Block - 22/2, Nurses Residential Complex, Srinivaspuri', '110065', 'jitinthegreat1@gmail.com', '92929', '', '948949', '483993', '', '94949', '39893', '81dc9bdb52d04dc20036dbd8313ed055', '2', '', '0', '2', '11', '0', '', '2014-07-29 08:06:13', '0');

CREATE TABLE `news_master` (
   `news_id` int(8) not null auto_increment,
   `news_title` varchar(100) not null,
   `news_content` varchar(500),
   `news_publisher_id` int(8) not null,
   `news_publish_date` datetime not null,
   `news_application_id` int(4) not null,
   `news_hashtag` varchar(64),
   `news_dor` timestamp not null default CURRENT_TIMESTAMP,
   `news_dirty` tinyint(1) not null default '0',
   PRIMARY KEY (`news_id`),
   KEY `news_publisher_id` (`news_publisher_id`),
   KEY `news_application_id` (`news_application_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=4;

INSERT INTO `news_master` (`news_id`, `news_title`, `news_content`, `news_publisher_id`, `news_publish_date`, `news_application_id`, `news_hashtag`, `news_dor`, `news_dirty`) VALUES 
('1', 'Sample News', 'Random Content ', '7', '2014-10-24 00:00:00', '1', '', '2014-10-24 10:49:14', '0'),
('2', 'Test News', 'Abracadabra', '7', '2014-12-10 00:00:00', '1', '', '2014-12-12 07:15:19', '0'),
('3', 'Another News', 'Trial', '7', '2014-12-28 00:00:00', '1', '', '2014-12-28 12:04:54', '0');

CREATE TABLE `organization_master` (
   `organization_id` int(8) not null auto_increment,
   `organization_name` varchar(100) not null,
   `organization_short_name` varchar(20),
   `organization_address` varchar(200),
   `organization_email` varchar(50),
   `organization_phone` varchar(20),
   `organization_contact_person_name` varchar(50),
   `organization_fax` varchar(20),
   `organization_hashtag` varchar(64),
   `organization_dor` timestamp not null default CURRENT_TIMESTAMP,
   `organization_dirty` tinyint(1) not null default '0',
   PRIMARY KEY (`organization_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=3;

INSERT INTO `organization_master` (`organization_id`, `organization_name`, `organization_short_name`, `organization_address`, `organization_email`, `organization_phone`, `organization_contact_person_name`, `organization_fax`, `organization_hashtag`, `organization_dor`, `organization_dirty`) VALUES 
('1', 'Bharati Vidyapeeth Institute of Computer Applications and Management', 'BVICAM', '', '', '', '', '', '', '2014-07-25 11:05:42', '0'),
('2', 'ABC-Dvluprs', '@abcdvluprs', '', '', '', '', '', '', '2014-07-25 11:05:42', '0');

CREATE TABLE `paper_latest_version` (
   `paper_id` int(16) not null default '0',
   `paper_code` varchar(10) CHARSET latin1 not null,
   `paper_title` varchar(200) CHARSET latin1 not null,
   `latest_paper_version_number` int(4),
   `review_result_type_name` varchar(50) CHARSET latin1
);

INSERT INTO `paper_latest_version` (`paper_id`, `paper_code`, `paper_title`, `latest_paper_version_number`, `review_result_type_name`) VALUES 
('1', '1', 'Sample Paper', '1', ''),
('2', '2', 'Agile Debt Paying', '3', ''),
('3', '3', 'A super duper paper', '1', ''),
('4', '4', 'Interstellar', '2', ''),
('5', '5', 'Testing paper submission', '1', ''),
('6', '6', 'test paper', '2', ''),
('7', '7', 'Random Paper 2', '2', '');

CREATE TABLE `paper_master` (
   `paper_id` int(16) not null auto_increment,
   `paper_code` varchar(10) not null,
   `paper_title` varchar(200) not null,
   `paper_subject_id` int(8) not null,
   `paper_date_of_submission` datetime,
   `paper_presentation_path` varchar(100),
   `paper_contact_author_id` varchar(10) not null,
   `paper_isclose` tinyint(1) not null default '0',
   `paper_hashtag` varchar(64),
   `paper_dor` timestamp not null default CURRENT_TIMESTAMP,
   `paper_dirty` tinyint(1) not null default '0',
   PRIMARY KEY (`paper_id`),
   KEY `paper_contact_author_id` (`paper_contact_author_id`),
   KEY `paper_subject_id` (`paper_subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=8;

INSERT INTO `paper_master` (`paper_id`, `paper_code`, `paper_title`, `paper_subject_id`, `paper_date_of_submission`, `paper_presentation_path`, `paper_contact_author_id`, `paper_isclose`, `paper_hashtag`, `paper_dor`, `paper_dirty`) VALUES 
('1', '1', 'Sample Paper', '1', '2014-10-24 18:13:44', '', '3', '0', '', '2014-10-24 09:13:44', '0'),
('2', '2', 'Agile Debt Paying', '1', '2014-10-25 14:59:54', '', '33', '0', '', '2014-10-25 05:59:54', '0'),
('3', '3', 'A super duper paper', '3', '2014-11-27 12:49:08', '', '34', '0', '', '2014-11-27 05:49:08', '0'),
('4', '4', 'Interstellar', '5', '2014-11-27 12:52:41', '', '34', '0', '', '2014-11-27 05:52:41', '0'),
('5', '5', 'Testing paper submission', '3', '2014-11-27 12:56:24', '', '34', '0', '', '2014-11-27 05:56:24', '0'),
('6', '6', 'test paper', '1', '2014-12-03 04:17:34', '', '40', '0', '', '2014-12-02 21:17:34', '0'),
('7', '7', 'Random Paper 2', '5', '2014-12-03 06:35:26', '', '41', '0', '', '2014-12-02 23:35:26', '0');

CREATE TABLE `paper_status_info` (
   `submission_member_id` varchar(10),
   `paper_id` int(16),
   `paper_title` varchar(200),
   `review_result_type_name` varchar(50),
   `paper_version_number` int(4)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- [Table `paper_status_info` is empty]

CREATE TABLE `paper_version_master` (
   `paper_version_id` int(32) not null auto_increment,
   `paper_id` int(16) not null,
   `paper_version_number` int(4) not null,
   `paper_version_date_of_submission` timestamp,
   `paper_version_document_path` varchar(100) not null,
   `paper_version_compliance_report_path` varchar(100),
   `paper_version_convener_id` int(8),
   `paper_version_is_reviewer_assigned` tinyint(1) not null default '0',
   `paper_version_is_reviewed_convener` tinyint(1) not null default '0',
   `paper_version_review_date` datetime,
   `paper_version_review_result_id` int(2),
   `paper_version_review` varchar(300),
   `paper_version_comments_path` varchar(100),
   `paper_version_review_is_read_by_author` tinyint(1) not null default '0',
   `paper_version_hashtag` varchar(64),
   `paper_version_dor` timestamp not null default CURRENT_TIMESTAMP,
   `paper_version_dirty` tinyint(1) not null default '0',
   PRIMARY KEY (`paper_version_id`),
   KEY `paper_id` (`paper_id`),
   KEY `paper_id_2` (`paper_id`),
   KEY `paper_version_convener_id` (`paper_version_convener_id`),
   KEY `paper_version_review_result_id` (`paper_version_review_result_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=13;

INSERT INTO `paper_version_master` (`paper_version_id`, `paper_id`, `paper_version_number`, `paper_version_date_of_submission`, `paper_version_document_path`, `paper_version_compliance_report_path`, `paper_version_convener_id`, `paper_version_is_reviewer_assigned`, `paper_version_is_reviewed_convener`, `paper_version_review_date`, `paper_version_review_result_id`, `paper_version_review`, `paper_version_comments_path`, `paper_version_review_is_read_by_author`, `paper_version_hashtag`, `paper_version_dor`, `paper_version_dirty`) VALUES 
('1', '1', '1', '2014-10-24 05:43:44', 'Indiacom2015/uploads/1/papers/Paper_1v1.docx', '', '', '0', '0', '', '', '', '', '0', '', '2014-10-24 09:13:44', '0'),
('2', '2', '1', '2014-10-25 02:29:54', 'Indiacom2015/uploads/1/papers/Paper_2v1.docx', '', '', '0', '0', '', '', '', '', '0', '', '2014-10-25 05:59:54', '0'),
('3', '2', '2', '2014-10-25 02:32:01', 'Indiacom2015/uploads/1/papers/Paper_2v2.docx', 'Indiacom2015/uploads/1/compliance_reports/Report_2v2.pdf', '', '0', '0', '', '', '', '', '0', '', '2014-10-25 06:02:01', '0'),
('4', '3', '1', '2014-11-27 12:49:08', 'indiacom2015/uploads/1/papers/Paper_3v1.docx', '', '', '0', '0', '', '', '', '', '0', '', '2014-11-27 05:49:08', '0'),
('5', '4', '1', '2014-11-27 12:52:41', 'indiacom2015/uploads/1/papers/Paper_4v1.docx', '', '', '0', '0', '', '', '', '', '0', '', '2014-11-27 05:52:41', '0'),
('6', '5', '1', '2014-11-27 12:56:24', 'indiacom2015/uploads/1/papers/Paper_5v1.docx', '', '', '0', '0', '', '', '', '', '0', '', '2014-11-27 05:56:24', '0'),
('7', '4', '2', '2014-11-27 12:58:47', 'indiacom2015/uploads/1/papers/Paper_4v2.docx', 'indiacom2015/uploads/1/compliance_reports/Report_4v2.pdf', '', '0', '0', '', '', '', '', '0', '', '2014-11-27 05:58:47', '0'),
('8', '2', '3', '2014-11-28 17:47:39', 'indiacom2015/uploads/1/papers/Paper_2v3.docx', 'indiacom2015/uploads/1/compliance_reports/Report_2v3.pdf', '', '0', '0', '', '', '', '', '0', '', '2014-11-28 10:47:39', '0'),
('9', '6', '1', '2014-12-03 04:17:34', 'indiacom2015/uploads/1/papers/Paper_6v1.doc', '', '', '0', '0', '', '', '', '', '0', '', '2014-12-02 21:17:34', '0'),
('10', '6', '2', '2014-12-03 04:19:24', 'indiacom2015/uploads/1/papers/Paper_6v2.docx', 'indiacom2015/uploads/1/compliance_reports/Report_6v2.pdf', '', '0', '0', '', '', '', '', '0', '', '2014-12-02 21:19:24', '0'),
('11', '7', '1', '2014-12-03 06:35:26', 'indiacom2015/uploads/1/papers/Paper_7v1.docx', '', '', '0', '0', '', '', '', '', '0', '', '2014-12-02 23:35:26', '0'),
('12', '7', '2', '2014-12-03 06:36:05', 'indiacom2015/uploads/1/papers/Paper_7v2.docx', 'indiacom2015/uploads/1/compliance_reports/Report_7v2.pdf', '', '0', '0', '', '', '', '', '0', '', '2014-12-02 23:36:05', '0');

CREATE TABLE `paper_version_review` (
   `paper_version_review_id` int(64) not null auto_increment,
   `paper_version_id` int(32) not null,
   `paper_version_reviewer_id` int(8) not null,
   `paper_version_review_comments` varchar(300),
   `paper_version_review_comments_file_path` varchar(100),
   `paper_version_date_sent_for_review` timestamp,
   `paper_version_review_date_of_receipt` datetime,
   `paper_version_review_hashtag` varchar(64),
   `paper_version_review_dor` timestamp not null default CURRENT_TIMESTAMP,
   `paper_version_review_dirty` tinyint(1) not null default '0',
   PRIMARY KEY (`paper_version_review_id`),
   UNIQUE KEY (`paper_version_id`,`paper_version_reviewer_id`),
   KEY `paper_version_id` (`paper_version_id`),
   KEY `reviewer_id` (`paper_version_reviewer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- [Table `paper_version_review` is empty]

CREATE TABLE `privilege_master` (
   `privilege_id` varchar(8) not null,
   `privilege_entity` varchar(50) not null,
   `privilege_attribute` varchar(50) not null,
   `privilege_operation` varchar(10) not null,
   `privilege_hashtag` varchar(64),
   `privilege_dor` timestamp not null default CURRENT_TIMESTAMP,
   `privilege_dirty` tinyint(1) not null default '0',
   PRIMARY KEY (`privilege_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `privilege_master` (`privilege_id`, `privilege_entity`, `privilege_attribute`, `privilege_operation`, `privilege_hashtag`, `privilege_dor`, `privilege_dirty`) VALUES 
('1', 'user_master', '', 'Select', '', '2014-09-30 07:13:56', '0'),
('10', 'track_master', '', 'Update', '', '2014-09-30 07:13:56', '0'),
('11', 'track_master', '', 'Insert', '', '2014-09-30 07:13:56', '0'),
('12', 'track_master', '', 'Delete', '', '2014-09-30 07:13:56', '0'),
('13', 'submission_master', '', 'Select', '', '2014-09-30 07:13:56', '0'),
('14', 'submission_master', '', 'Update', '', '2014-09-30 07:13:56', '0'),
('15', 'submission_master', '', 'Insert', '', '2014-09-30 07:13:56', '0'),
('16', 'submission_master', '', 'Delete', '', '2014-09-30 07:13:56', '0'),
('17', 'subject_master', '', 'Select', '', '2014-09-30 07:13:56', '0'),
('18', 'subject_master', '', 'Update', '', '2014-09-30 07:13:56', '0'),
('19', 'subject_master', '', 'Insert', '', '2014-09-30 07:13:56', '0'),
('2', 'user_master', '', 'Update', '', '2014-09-30 07:13:56', '0'),
('20', 'subject_master', '', 'Delete', '', '2014-09-30 07:13:56', '0'),
('21', 'role_master', '', 'Select', '', '2014-09-30 07:13:56', '0'),
('22', 'role_master', '', 'Update', '', '2014-09-30 07:13:56', '0'),
('23', 'role_master', '', 'Insert', '', '2014-09-30 07:13:56', '0'),
('24', 'role_master', '', 'Delete', '', '2014-09-30 07:13:56', '0'),
('25', 'review_result_master', '', 'Select', '', '2014-09-30 07:13:56', '0'),
('26', 'review_result_master', '', 'Update', '', '2014-09-30 07:13:56', '0'),
('27', 'review_result_master', '', 'Insert', '', '2014-09-30 07:13:56', '0'),
('28', 'review_result_master', '', 'Delete', '', '2014-09-30 07:13:56', '0'),
('29', 'reviewer_master', '', 'Select', '', '2014-09-30 07:13:56', '0'),
('3', 'user_master', '', 'Insert', '', '2014-09-30 07:13:56', '0'),
('30', 'reviewer_master', '', 'Update', '', '2014-09-30 07:13:56', '0'),
('31', 'reviewer_master', '', 'Insert', '', '2014-09-30 07:13:56', '0'),
('32', 'reviewer_master', '', 'Delete', '', '2014-09-30 07:13:56', '0'),
('33', 'privilege_role_mapper', '', 'Select', '', '2014-09-30 07:13:56', '0'),
('34', 'privilege_role_mapper', '', 'Update', '', '2014-09-30 07:13:56', '0'),
('35', 'privilege_role_mapper', '', 'Insert', '', '2014-09-30 07:13:56', '0'),
('36', 'privilege_role_mapper', '', 'Delete', '', '2014-09-30 07:13:57', '0'),
('37', 'privilege_master', '', 'Select', '', '2014-09-30 07:13:57', '0'),
('38', 'privilege_master', '', 'Update', '', '2014-09-30 07:13:57', '0'),
('39', 'privilege_master', '', 'Insert', '', '2014-09-30 07:13:57', '0'),
('4', 'user_master', '', 'Delete', '', '2014-09-30 07:13:56', '0'),
('40', 'privilege_master', '', 'Delete', '', '2014-09-30 07:13:57', '0'),
('41', 'paper_version_review', '', 'Select', '', '2014-09-30 07:13:57', '0'),
('42', 'paper_version_review', '', 'Update', '', '2014-09-30 07:13:57', '0'),
('43', 'paper_version_review', '', 'Insert', '', '2014-09-30 07:13:57', '0'),
('44', 'paper_version_review', '', 'Delete', '', '2014-09-30 07:13:57', '0'),
('45', 'paper_version_master', '', 'Select', '', '2014-09-30 07:13:57', '0'),
('46', 'paper_version_master', '', 'Update', '', '2014-09-30 07:13:57', '0'),
('47', 'paper_version_master', '', 'Insert', '', '2014-09-30 07:13:57', '0'),
('48', 'paper_version_master', '', 'Delete', '', '2014-09-30 07:13:57', '0'),
('49', 'paper_master', '', 'Select', '', '2014-09-30 07:13:57', '0'),
('5', 'user_event_role_mapper', '', 'Select', '', '2014-09-30 07:13:56', '0'),
('50', 'paper_master', '', 'Update', '', '2014-09-30 07:13:57', '0'),
('51', 'paper_master', '', 'Insert', '', '2014-09-30 07:13:57', '0'),
('52', 'paper_master', '', 'Delete', '', '2014-09-30 07:13:57', '0'),
('53', 'paper_latest_version', '', 'Select', '', '2014-09-30 07:13:57', '0'),
('54', 'paper_latest_version', '', 'Update', '', '2014-09-30 07:13:57', '0'),
('55', 'paper_latest_version', '', 'Insert', '', '2014-09-30 07:13:57', '0'),
('56', 'paper_latest_version', '', 'Delete', '', '2014-09-30 07:13:57', '0'),
('57', 'organization_master', '', 'Select', '', '2014-09-30 07:13:57', '0'),
('58', 'organization_master', '', 'Update', '', '2014-09-30 07:13:57', '0'),
('59', 'organization_master', '', 'Insert', '', '2014-09-30 07:13:57', '0'),
('6', 'user_event_role_mapper', '', 'Update', '', '2014-09-30 07:13:56', '0'),
('60', 'organization_master', '', 'Delete', '', '2014-09-30 07:13:57', '0'),
('61', 'news_master', '', 'Select', '', '2014-09-30 07:13:57', '0'),
('62', 'news_master', '', 'Update', '', '2014-09-30 07:13:57', '0'),
('63', 'news_master', '', 'Insert', '', '2014-09-30 07:13:57', '0'),
('64', 'news_master', '', 'Delete', '', '2014-09-30 07:13:57', '0'),
('65', 'member_master', '', 'Select', '', '2014-09-30 07:13:57', '0'),
('66', 'member_master', '', 'Update', '', '2014-09-30 07:13:57', '0'),
('67', 'member_master', '', 'Insert', '', '2014-09-30 07:13:57', '0'),
('68', 'member_master', '', 'Delete', '', '2014-09-30 07:13:57', '0'),
('69', 'member_category_master', '', 'Select', '', '2014-09-30 07:13:57', '0'),
('7', 'user_event_role_mapper', '', 'Insert', '', '2014-09-30 07:13:56', '0'),
('70', 'member_category_master', '', 'Update', '', '2014-09-30 07:13:57', '0'),
('71', 'member_category_master', '', 'Insert', '', '2014-09-30 07:13:57', '0'),
('72', 'member_category_master', '', 'Delete', '', '2014-09-30 07:13:57', '0'),
('73', 'event_master', '', 'Select', '', '2014-09-30 07:13:57', '0'),
('74', 'event_master', '', 'Update', '', '2014-09-30 07:13:57', '0'),
('75', 'event_master', '', 'Insert', '', '2014-09-30 07:13:57', '0'),
('76', 'event_master', '', 'Delete', '', '2014-09-30 07:13:57', '0'),
('77', 'database_user', '', 'Select', '', '2014-09-30 07:13:57', '0'),
('78', 'database_user', '', 'Update', '', '2014-09-30 07:13:57', '0'),
('79', 'database_user', '', 'Insert', '', '2014-09-30 07:13:57', '0'),
('8', 'user_event_role_mapper', '', 'Delete', '', '2014-09-30 07:13:56', '0'),
('80', 'database_user', '', 'Delete', '', '2014-09-30 07:13:57', '0'),
('81', 'application_master', '', 'Select', '', '2014-09-30 07:13:57', '0'),
('82', 'application_master', '', 'Update', '', '2014-09-30 07:13:57', '0'),
('83', 'application_master', '', 'Insert', '', '2014-09-30 07:13:57', '0'),
('84', 'application_master', '', 'Delete', '', '2014-09-30 07:13:57', '0'),
('85', 'indiacom_news_attachments', '', 'Select', '', '2014-10-19 02:23:23', '0'),
('86', 'indiacom_news_attachments', '', 'Update', '', '2014-10-19 02:23:29', '0'),
('87', 'indiacom_news_attachments', '', 'Insert', '', '2014-10-19 02:23:35', '0'),
('88', 'indiacom_news_attachments', '', 'Delete', '', '2014-10-19 02:23:40', '0'),
('89', 'indiacom_news_master', '', 'Select', '', '2014-10-19 02:24:02', '0'),
('9', 'track_master', '', 'Select', '', '2014-09-30 07:13:56', '0'),
('90', 'indiacom_news_master', '', 'Update', '', '2014-10-19 02:24:06', '0'),
('91', 'indiacom_news_master', '', 'Insert', '', '2014-10-19 02:24:10', '0'),
('92', 'indiacom_news_master', '', 'Delete', '', '2014-10-19 02:24:14', '0'),
('93', 'temp_member_master', '', 'Select', '', '2014-10-24 22:36:36', '0'),
('94', 'temp_member_master', '', 'Insert', '', '2014-10-24 22:37:58', '0'),
('95', 'temp_member_master', '', 'Delete', '', '2014-10-24 22:41:10', '0');

CREATE TABLE `privilege_role_mapper` (
   `privilege_id` varchar(8) not null,
   `role_id` int(8) not null,
   `privilege_role_mapper_hashtag` varchar(64),
   `privilege_role_mapper_dor` timestamp not null default CURRENT_TIMESTAMP,
   `privilege_role_mapper_dirty` tinyint(1) not null default '0',
   PRIMARY KEY (`privilege_id`,`role_id`),
   KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `privilege_role_mapper` (`privilege_id`, `role_id`, `privilege_role_mapper_hashtag`, `privilege_role_mapper_dor`, `privilege_role_mapper_dirty`) VALUES 
('1', '23', '', '2014-09-30 07:13:57', '0'),
('10', '23', '', '2014-09-30 07:13:57', '0'),
('11', '23', '', '2014-09-30 07:13:57', '0'),
('12', '23', '', '2014-09-30 07:13:58', '0'),
('13', '23', '', '2014-09-30 07:13:58', '0'),
('13', '24', '', '2014-09-30 07:16:51', '0'),
('14', '23', '', '2014-09-30 07:13:58', '0'),
('14', '24', '', '2014-09-30 07:16:51', '0'),
('15', '23', '', '2014-09-30 07:13:58', '0'),
('15', '24', '', '2014-09-30 07:16:51', '0'),
('16', '23', '', '2014-09-30 07:13:58', '0'),
('17', '23', '', '2014-09-30 07:13:58', '0'),
('17', '24', '', '2014-09-30 07:16:51', '0'),
('18', '23', '', '2014-09-30 07:13:58', '0'),
('19', '23', '', '2014-09-30 07:13:58', '0'),
('2', '23', '', '2014-09-30 07:13:57', '0'),
('20', '23', '', '2014-09-30 07:13:58', '0'),
('21', '23', '', '2014-09-30 07:13:58', '0'),
('21', '32', '', '2014-10-01 06:02:27', '0'),
('22', '23', '', '2014-09-30 07:13:58', '0'),
('23', '23', '', '2014-09-30 07:13:58', '0'),
('23', '32', '', '2014-10-01 06:02:27', '0'),
('24', '23', '', '2014-09-30 07:13:58', '0'),
('25', '23', '', '2014-09-30 07:13:58', '0'),
('25', '24', '', '2014-09-30 07:16:51', '0'),
('26', '23', '', '2014-09-30 07:13:58', '0'),
('27', '23', '', '2014-09-30 07:13:58', '0'),
('28', '23', '', '2014-09-30 07:13:58', '0'),
('29', '23', '', '2014-09-30 07:13:58', '0'),
('3', '23', '', '2014-09-30 07:13:57', '0'),
('30', '23', '', '2014-09-30 07:13:58', '0'),
('31', '23', '', '2014-09-30 07:13:58', '0'),
('32', '23', '', '2014-09-30 07:13:58', '0'),
('33', '23', '', '2014-09-30 07:13:58', '0'),
('34', '23', '', '2014-09-30 07:13:58', '0'),
('35', '23', '', '2014-09-30 07:13:58', '0'),
('35', '32', '', '2014-10-01 06:02:27', '0'),
('36', '23', '', '2014-09-30 07:13:58', '0'),
('37', '23', '', '2014-09-30 07:13:58', '0'),
('37', '32', '', '2014-10-01 06:02:27', '0'),
('38', '23', '', '2014-09-30 07:13:58', '0'),
('39', '23', '', '2014-09-30 07:13:58', '0'),
('39', '32', '', '2014-10-01 06:02:27', '0'),
('4', '23', '', '2014-09-30 07:13:57', '0'),
('40', '23', '', '2014-09-30 07:13:58', '0'),
('41', '23', '', '2014-09-30 07:13:58', '0'),
('41', '29', '', '2014-10-01 00:30:15', '0'),
('42', '23', '', '2014-09-30 07:13:58', '0'),
('43', '23', '', '2014-09-30 07:13:58', '0'),
('43', '34', '', '2014-11-01 03:53:17', '0'),
('44', '23', '', '2014-09-30 07:13:58', '0'),
('45', '23', '', '2014-09-30 07:13:58', '0'),
('45', '24', '', '2014-09-30 07:16:51', '0'),
('46', '23', '', '2014-09-30 07:13:58', '0'),
('47', '23', '', '2014-09-30 07:13:58', '0'),
('47', '24', '', '2014-09-30 07:16:51', '0'),
('48', '23', '', '2014-09-30 07:13:58', '0'),
('49', '23', '', '2014-09-30 07:13:58', '0'),
('49', '24', '', '2014-09-30 07:16:51', '0'),
('5', '23', '', '2014-09-30 07:13:57', '0'),
('50', '23', '', '2014-09-30 07:13:58', '0'),
('51', '23', '', '2014-09-30 07:13:58', '0'),
('51', '24', '', '2014-09-30 07:16:51', '0'),
('52', '23', '', '2014-09-30 07:13:58', '0'),
('53', '23', '', '2014-09-30 07:13:58', '0'),
('53', '24', '', '2014-09-30 07:16:51', '0'),
('54', '23', '', '2014-09-30 07:13:58', '0'),
('55', '23', '', '2014-09-30 07:13:58', '0'),
('56', '23', '', '2014-09-30 07:13:58', '0'),
('57', '23', '', '2014-09-30 07:13:58', '0'),
('57', '24', '', '2014-09-30 07:16:51', '0'),
('57', '31', '', '2014-10-01 04:53:30', '0'),
('58', '23', '', '2014-09-30 07:13:58', '0'),
('59', '23', '', '2014-09-30 07:13:58', '0'),
('6', '23', '', '2014-09-30 07:13:57', '0'),
('60', '23', '', '2014-09-30 07:13:58', '0'),
('61', '23', '', '2014-09-30 07:13:58', '0'),
('61', '24', '', '2014-09-30 07:16:51', '0'),
('61', '31', '', '2014-10-01 04:53:30', '0'),
('62', '23', '', '2014-09-30 07:13:58', '0'),
('63', '23', '', '2014-09-30 07:13:58', '0'),
('64', '23', '', '2014-09-30 07:13:58', '0'),
('65', '23', '', '2014-09-30 07:13:58', '0'),
('65', '24', '', '2014-09-30 07:16:51', '0'),
('65', '31', '', '2014-10-01 04:53:30', '0'),
('66', '23', '', '2014-09-30 07:13:58', '0'),
('66', '24', '', '2014-09-30 07:16:51', '0'),
('66', '33', '', '2014-10-25 00:39:44', '0'),
('67', '23', '', '2014-09-30 07:13:58', '0'),
('67', '31', '', '2014-10-01 04:53:30', '0'),
('68', '23', '', '2014-09-30 07:13:59', '0'),
('69', '23', '', '2014-09-30 07:13:59', '0'),
('69', '24', '', '2014-09-30 07:16:51', '0'),
('69', '31', '', '2014-10-01 04:53:30', '0'),
('7', '23', '', '2014-09-30 07:13:57', '0'),
('70', '23', '', '2014-09-30 07:13:59', '0'),
('71', '23', '', '2014-09-30 07:13:59', '0'),
('72', '23', '', '2014-09-30 07:13:59', '0'),
('73', '23', '', '2014-09-30 07:13:59', '0'),
('73', '24', '', '2014-09-30 07:16:51', '0'),
('73', '30', '', '2014-10-01 04:52:18', '0'),
('74', '23', '', '2014-09-30 07:13:59', '0'),
('75', '23', '', '2014-09-30 07:13:59', '0'),
('76', '23', '', '2014-09-30 07:13:59', '0'),
('77', '23', '', '2014-09-30 07:13:59', '0'),
('78', '23', '', '2014-09-30 07:13:59', '0'),
('79', '23', '', '2014-09-30 07:13:59', '0'),
('79', '32', '', '2014-10-01 06:02:27', '0'),
('8', '23', '', '2014-09-30 07:13:57', '0'),
('80', '23', '', '2014-09-30 07:13:59', '0'),
('81', '23', '', '2014-09-30 07:13:59', '0'),
('82', '23', '', '2014-09-30 07:13:59', '0'),
('83', '23', '', '2014-09-30 07:13:59', '0'),
('84', '23', '', '2014-09-30 07:13:59', '0'),
('85', '23', '', '2014-10-19 02:23:23', '0'),
('85', '24', '', '2014-10-24 09:03:49', '0'),
('85', '31', '', '2014-10-19 09:04:21', '0'),
('86', '23', '', '2014-10-19 02:23:29', '0'),
('87', '23', '', '2014-10-19 02:23:35', '0'),
('88', '23', '', '2014-10-19 02:23:40', '0'),
('89', '23', '', '2014-10-19 02:24:02', '0'),
('89', '24', '', '2014-10-24 06:06:46', '0'),
('89', '31', '', '2014-10-19 09:04:14', '0'),
('9', '23', '', '2014-09-30 07:13:57', '0'),
('9', '24', '', '2014-09-30 07:16:51', '0'),
('90', '23', '', '2014-10-19 02:24:06', '0'),
('91', '23', '', '2014-10-19 02:24:10', '0'),
('92', '23', '', '2014-10-19 02:24:14', '0'),
('93', '31', '', '2014-10-24 22:36:37', '0'),
('94', '31', '', '2014-10-24 22:37:58', '0'),
('95', '31', '', '2014-10-24 22:41:10', '0');

CREATE TABLE `review_result_master` (
   `review_result_id` int(2) not null auto_increment,
   `review_result_type_name` varchar(50) not null,
   `review_result_description` varchar(150),
   `review_result_message` varchar(150),
   `review_result_acronym` varchar(10),
   `review_result_hashtag` varchar(64),
   `review_result_dor` timestamp not null default CURRENT_TIMESTAMP,
   `review_result_dirty` tinyint(1) not null default '0',
   PRIMARY KEY (`review_result_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=3;

INSERT INTO `review_result_master` (`review_result_id`, `review_result_type_name`, `review_result_description`, `review_result_message`, `review_result_acronym`, `review_result_hashtag`, `review_result_dor`, `review_result_dirty`) VALUES 
('1', 'Rejected', '', '', '', '', '2014-07-25 11:06:42', '0'),
('2', 'Accepted', '', '', '', '', '2014-07-25 11:06:42', '0');

CREATE TABLE `reviewer_master` (
   `reviewer_id` int(8) not null default '0',
   `reviewer_organization_id` int(8),
   `reviewer_hashtag` varchar(64),
   `reviewer_dor` timestamp not null default CURRENT_TIMESTAMP,
   `reviewer_dirty` tinyint(1) not null default '0',
   PRIMARY KEY (`reviewer_id`),
   KEY `reviewer_id` (`reviewer_id`),
   KEY `reviewer_organization_id` (`reviewer_organization_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- [Table `reviewer_master` is empty]

CREATE TABLE `role_master` (
   `role_id` int(8) not null auto_increment,
   `role_name` varchar(32) not null,
   `role_application_id` int(4) not null,
   `role_hashtag` varchar(64),
   `role_dor` timestamp not null default CURRENT_TIMESTAMP,
   `role_dirty` tinyint(1) not null default '0',
   PRIMARY KEY (`role_id`),
   UNIQUE KEY (`role_name`),
   KEY `application_id` (`role_application_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=35;

INSERT INTO `role_master` (`role_id`, `role_name`, `role_application_id`, `role_hashtag`, `role_dor`, `role_dirty`) VALUES 
('23', 'Super Admin', '2', '', '2014-09-30 07:13:56', '0'),
('24', 'Author', '1', '', '2014-09-30 07:16:51', '0'),
('29', 'Sample Role', '2', '', '2014-10-01 00:30:15', '0'),
('30', 'Minimal_Admin', '2', '', '2014-10-01 04:52:17', '0'),
('31', 'Minimal', '1', '', '2014-10-01 04:53:30', '0'),
('32', 'Role Manager', '2', '', '2014-10-01 06:02:26', '0'),
('33', 'LimitedAuthor', '1', '', '2014-10-25 00:39:44', '0'),
('34', 'Reviewer', '2', '', '2014-11-01 03:53:17', '0');

CREATE TABLE `subject_master` (
   `subject_id` int(8) not null auto_increment,
   `subject_code` varchar(10) not null,
   `subject_track_id` int(8) not null,
   `subject_name` varchar(50) not null,
   `subject_description` varchar(100),
   `subject_hashtag` varchar(64),
   `subject_dor` timestamp not null default CURRENT_TIMESTAMP,
   `subject_dirty` tinyint(1) not null default '0',
   PRIMARY KEY (`subject_id`),
   UNIQUE KEY (`subject_code`,`subject_track_id`),
   KEY `subject_track_id` (`subject_track_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=8;

INSERT INTO `subject_master` (`subject_id`, `subject_code`, `subject_track_id`, `subject_name`, `subject_description`, `subject_hashtag`, `subject_dor`, `subject_dirty`) VALUES 
('1', '101', '1', 'Networking', '', '', '2014-07-25 11:17:17', '0'),
('2', '102', '1', 'Advanced Networking', '', '', '2014-07-25 11:17:17', '0'),
('3', '103', '2', 'Quantum Computing', '', '', '2014-07-25 11:17:17', '0'),
('4', '104', '3', 'Databases', '', '', '2014-07-25 11:17:17', '0'),
('5', '105', '4', 'TOC', '', '', '2014-07-25 11:17:17', '0'),
('6', '101', '5', 'Graphics', '', '', '2014-07-25 11:17:17', '0'),
('7', '102', '8', 'Networking', '', '', '2014-07-25 11:17:17', '0');

CREATE TABLE `submission_master` (
   `submission_id` int(32) not null auto_increment,
   `submission_paper_id` int(16) not null,
   `submission_member_id` varchar(10) not null,
   `submission_hashtag` varchar(64),
   `submission_dor` timestamp not null default CURRENT_TIMESTAMP,
   `submission_dirty` tinyint(1) not null default '0',
   PRIMARY KEY (`submission_id`),
   UNIQUE KEY (`submission_paper_id`,`submission_member_id`),
   KEY `submission_paper_id` (`submission_paper_id`),
   KEY `submission_member_id` (`submission_member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=11;

INSERT INTO `submission_master` (`submission_id`, `submission_paper_id`, `submission_member_id`, `submission_hashtag`, `submission_dor`, `submission_dirty`) VALUES 
('1', '1', '3', '', '2014-10-24 09:13:44', '0'),
('2', '2', '33', '', '2014-10-25 05:59:54', '0'),
('3', '3', '34', '', '2014-11-27 05:49:08', '0'),
('4', '4', '34', '', '2014-11-27 05:52:41', '0'),
('5', '5', '34', '', '2014-11-27 05:56:24', '0'),
('6', '2', '34', '', '2014-11-28 10:47:39', '0'),
('7', '6', '40', '', '2014-12-02 21:17:34', '0'),
('8', '6', '2', '', '2014-12-02 21:17:34', '1'),
('9', '7', '41', '', '2014-12-02 23:35:26', '0'),
('10', '7', '4342', '', '2014-12-02 23:36:05', '0');

CREATE TABLE `temp_member_master` (
   `member_id` varchar(10) not null,
   `member_salutation` varchar(5) not null,
   `member_name` varchar(50) not null,
   `member_address` varchar(100) not null,
   `member_pincode` varchar(10) not null,
   `member_email` varchar(100) not null,
   `member_phone` varchar(20),
   `member_country_code` varchar(5) not null,
   `member_mobile` varchar(20) not null,
   `member_fax` varchar(20),
   `member_designation` varchar(20),
   `member_csi_mem_no` varchar(30),
   `member_iete_mem_no` varchar(30),
   `member_password` varchar(64) not null,
   `member_organization_id` int(8),
   `member_department` varchar(100) not null,
   `member_biodata_path` varchar(100),
   `member_category_id` int(4),
   `member_experience` varchar(4),
   `member_is_activated` tinyint(1) not null default '0',
   `member_hashtag` varchar(64),
   `member_dor` timestamp not null default CURRENT_TIMESTAMP,
   `member_dirty` tinyint(1) not null default '0',
   PRIMARY KEY (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- [Table `temp_member_master` is empty]

CREATE TABLE `track_master` (
   `track_id` int(8) not null auto_increment,
   `track_number` varchar(10) not null,
   `track_event_id` int(8) not null,
   `track_name` varchar(100) not null,
   `track_description` varchar(200),
   `track_hashtag` varchar(64) not null,
   `track_dor` timestamp not null default CURRENT_TIMESTAMP,
   `track_dirty` tinyint(1) not null default '0',
   PRIMARY KEY (`track_id`),
   UNIQUE KEY (`track_number`,`track_event_id`),
   KEY `track_event_id` (`track_event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=9;

INSERT INTO `track_master` (`track_id`, `track_number`, `track_event_id`, `track_name`, `track_description`, `track_hashtag`, `track_dor`, `track_dirty`) VALUES 
('1', '1', '1', 'International Conference on Sustainable Computing (ICSC-2015)', '', '', '2014-07-25 11:09:47', '0'),
('2', '2', '1', 'International Conference on High Performance Computing (ICHPC-2015)', '', '', '2014-07-25 11:09:47', '0'),
('3', '3', '1', 'International Conference on High Speed Networking and Information Security (ICHNIS-2015)', '', '', '2014-07-25 11:09:47', '0'),
('4', '4', '1', 'International Conference on Software Engineering and Emerging Technologies (ICSEET-2015)', '', '', '2014-07-25 11:09:47', '0'),
('5', '1', '2', 'Internet of Things', '', '', '2014-07-25 11:10:39', '0'),
('8', '2', '2', 'Embedded Computing', '', '', '2014-07-25 11:11:57', '0');

CREATE TABLE `user_event_role_mapper` (
   `user_id` int(8) not null,
   `role_id` int(8) not null,
   `user_event_role_mapper_hashtag` varchar(64),
   `user_event_role_mapper_dor` timestamp not null default CURRENT_TIMESTAMP,
   `user_event_role_mapper_dirty` tinyint(1) not null default '0',
   PRIMARY KEY (`user_id`,`role_id`),
   KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `user_event_role_mapper` (`user_id`, `role_id`, `user_event_role_mapper_hashtag`, `user_event_role_mapper_dor`, `user_event_role_mapper_dirty`) VALUES 
('7', '23', '', '2014-10-01 00:02:42', '0'),
('7', '24', '', '2014-10-01 04:47:28', '0'),
('7', '29', '', '2014-10-01 00:45:42', '0'),
('7', '32', '', '2014-10-01 06:02:37', '0'),
('23', '24', '', '2014-10-01 00:53:14', '0'),
('23', '29', '', '2014-10-01 00:53:14', '0'),
('24', '34', '', '2014-11-01 03:53:50', '0');

CREATE TABLE `user_master` (
   `user_id` int(8) not null auto_increment,
   `user_name` varchar(50) not null,
   `user_organization_id` int(8),
   `user_designation` varchar(50),
   `user_address` varchar(150),
   `user_office_address` varchar(150),
   `user_mobile` varchar(20),
   `user_department` varchar(50),
   `user_email` varchar(100) not null,
   `user_password` varchar(64) not null,
   `user_registrar` int(8),
   `user_hashtag` varchar(64),
   `user_dor` timestamp not null default CURRENT_TIMESTAMP,
   `user_dirty` tinyint(1) not null default '0',
   PRIMARY KEY (`user_id`),
   KEY `user_registrar` (`user_registrar`),
   KEY `user_organization_id` (`user_organization_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=25;

INSERT INTO `user_master` (`user_id`, `user_name`, `user_organization_id`, `user_designation`, `user_address`, `user_office_address`, `user_mobile`, `user_department`, `user_email`, `user_password`, `user_registrar`, `user_hashtag`, `user_dor`, `user_dirty`) VALUES 
('7', 'Saurav Deb Purkayastha', '', '', '', '', '', '', 'sauravdebp@gmail.com', '1234', '', '', '2014-09-30 11:52:58', '0'),
('23', 'Sample User', '', '', '', '', '', '', 'sample@mail.com', '1234', '7', '', '2014-10-01 00:53:14', '0'),
('24', 'Jitin Dominic', '', '', '', '', '', '', 'jitin@dominos.com', '1234', '7', '', '2014-11-01 03:53:50', '0');