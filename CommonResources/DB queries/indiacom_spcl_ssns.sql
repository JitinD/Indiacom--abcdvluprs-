CREATE DATABASE  IF NOT EXISTS `indiacom` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `indiacom`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: localhost    Database: indiacom
-- ------------------------------------------------------
-- Server version	5.6.20-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `special_session_request`
--

DROP TABLE IF EXISTS `special_session_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `special_session_request` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` varchar(10) CHARACTER SET latin1 NOT NULL,
  `title` text NOT NULL,
  `aim` text NOT NULL,
  `profile` text NULL,
  `verified` tinyint(4) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sid`),
  KEY `member_id` (`member_id`),
  CONSTRAINT `special_session_request_ibfk_3` FOREIGN KEY (`member_id`) REFERENCES `member_master` (`member_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `area_of_coverage`
--

DROP TABLE IF EXISTS `area_of_coverage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `area_of_coverage` (
  `aoc_id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`aoc_id`),
  KEY `sid` (`sid`),
  CONSTRAINT `area_of_coverage_ibfk_1` FOREIGN KEY (`sid`) REFERENCES `special_session_request` (`sid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `technical_programme_committee`
--

DROP TABLE IF EXISTS `technical_programme_committee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `technical_programme_committee` (
  `tpc_id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`tpc_id`),
  KEY `sid` (`sid`),
  CONSTRAINT `technical_programme_committee_ibfk_1` FOREIGN KEY (`sid`) REFERENCES `special_session_request` (`sid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


-- alter table commands for member_master incorporating changes for adding country, city code for fax and phone

ALTER TABLE member_master add column member_phone_cityCode varchar(7) NULL after member_email;
ALTER TABLE member_master add column member_phone_countryCode varchar(4) NULL after member_phone_cityCode;
ALTER TABLE member_master add column member_fax_cityCode varchar(7) NULL after member_phone_countryCode;
ALTER TABLE member_master add column member_fax_countryCode varchar(4) NULL after member_fax_cityCode;
ALTER TABLE member_master add column member_country varchar(20) NULL after member_fax_countryCode;
ALTER TABLE member_master add column member_city varchar(20) NULL after member_country;

-- alter table commands for temp_member_master incorporating changes for adding country, city code for fax and phone


ALTER TABLE temp_member_master add column member_phone_cityCode varchar(7) NULL after member_email;
ALTER TABLE temp_member_master add column member_phone_countryCode varchar(4) NULL after member_phone_cityCode;
ALTER TABLE temp_member_master add column member_fax_cityCode varchar(7) NULL after member_phone_countryCode;
ALTER TABLE temp_member_master add column member_fax_countryCode varchar(4) NULL after member_fax_cityCode;
ALTER TABLE temp_member_master add column member_country varchar(20) NULL after member_fax_countryCode;
ALTER TABLE temp_member_master add column member_city varchar(20) NULL after member_country;


-- adding data to member_category_master
insert into member_category_master(member_category_name, member_category_event_id) values('B.Tech', 1), ('M.Tech', 1), ('MCA', 1);


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-08-18 21:34:13
