-- MySQL dump 10.13  Distrib 5.7.20, for Linux (x86_64)
--
-- Host: 192.168.1.125    Database: coinlancer
-- ------------------------------------------------------
-- Server version	5.6.37

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
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `acc_id` int(11) NOT NULL AUTO_INCREMENT,
  `acc_name` varchar(128) NOT NULL,
  `acc_surname` varchar(128) NOT NULL,
  `acc_login` varchar(128) NOT NULL,
  `acc_email` varchar(255) NOT NULL,
  `acc_is_email_sent` tinyint(1) NOT NULL DEFAULT '0',
  `acc_phone` varchar(128) DEFAULT NULL,
  `acc_skype` varchar(128) DEFAULT NULL,
  `acc_avatar` varchar(255) DEFAULT NULL,
  `acc_password` text NOT NULL,
  `acc_description` text,
  `acc_verification_key` text NOT NULL,
  `acc_is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `acc_crypt_address` varchar(42) NOT NULL,
  `acc_crypt_pair` text NOT NULL,
  `acc_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `acc_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`acc_id`),
  UNIQUE KEY `accounts_login_index` (`acc_login`),
  UNIQUE KEY `accounts_email_index` (`acc_email`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `attachments`
--

DROP TABLE IF EXISTS `attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachments` (
  `tch_id` int(11) NOT NULL AUTO_INCREMENT,
  `prj_id` int(11) DEFAULT NULL,
  `tch_title` varchar(255) NOT NULL,
  `tch_full_title` varchar(255) NOT NULL,
  `tch_path` text NOT NULL,
  `tch_hash` varchar(32) NOT NULL,
  PRIMARY KEY (`tch_id`),
  KEY `prj_id` (`prj_id`),
  CONSTRAINT `tch_prj__fc` FOREIGN KEY (`prj_id`) REFERENCES `projects` (`prj_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clients` (
  `cln_id` int(11) NOT NULL AUTO_INCREMENT,
  `acc_id` int(11) NOT NULL,
  PRIMARY KEY (`cln_id`),
  KEY `cln_account_id` (`acc_id`),
  CONSTRAINT `cln_acc__fk` FOREIGN KEY (`acc_id`) REFERENCES `accounts` (`acc_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `freelancers`
--

DROP TABLE IF EXISTS `freelancers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `freelancers` (
  `frl_id` int(11) NOT NULL AUTO_INCREMENT,
  `acc_id` int(11) NOT NULL,
  PRIMARY KEY (`frl_id`),
  KEY `frl_account_id` (`acc_id`),
  CONSTRAINT `frl_acc__fk` FOREIGN KEY (`acc_id`) REFERENCES `accounts` (`acc_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `prj_id` int(11) NOT NULL AUTO_INCREMENT,
  `cln_id` int(11) NOT NULL,
  `sct_id` int(11) DEFAULT NULL,
  `prj_title` varchar(255) DEFAULT NULL,
  `prj_description` text,
  `prj_status` tinyint(1) NOT NULL DEFAULT '0',
  `prj_budget` decimal(11,2) DEFAULT NULL,
  `prj_deadline` timestamp NULL DEFAULT NULL,
  `prj_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `prj_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`prj_id`),
  KEY `cln_id` (`cln_id`),
  KEY `projects_sct__fk` (`sct_id`),
  CONSTRAINT `prj_cln__fk` FOREIGN KEY (`cln_id`) REFERENCES `clients` (`cln_id`) ON UPDATE CASCADE,
  CONSTRAINT `projects_sct__fk` FOREIGN KEY (`sct_id`) REFERENCES `subcategories` (`sct_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `projects_freelancers`
--

DROP TABLE IF EXISTS `projects_freelancers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects_freelancers` (
  `prj_id` int(11) NOT NULL,
  `frl_id` int(11) NOT NULL,
  `prf_is_hired` tinyint(1) NOT NULL DEFAULT '0',
  `prf_message` text,
  `prf_hours` int(11) DEFAULT NULL,
  `prf_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `prf_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`prj_id`,`frl_id`),
  KEY `prj_frl_frl__fc` (`frl_id`),
  CONSTRAINT `prj_frl_frl__fc` FOREIGN KEY (`frl_id`) REFERENCES `freelancers` (`frl_id`) ON UPDATE CASCADE,
  CONSTRAINT `prj_frl_prj__fc` FOREIGN KEY (`prj_id`) REFERENCES `projects` (`prj_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `projects_subcategories`
--

DROP TABLE IF EXISTS `projects_subcategories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects_subcategories` (
  `prj_id` int(11) NOT NULL,
  `sct_id` int(11) NOT NULL,
  PRIMARY KEY (`prj_id`,`sct_id`),
  KEY `sct_id` (`sct_id`),
  CONSTRAINT `projects_subcategories_ibfk_1` FOREIGN KEY (`prj_id`) REFERENCES `projects` (`prj_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `projects_subcategories_ibfk_2` FOREIGN KEY (`sct_id`) REFERENCES `subcategories` (`sct_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `rev_id` int(11) NOT NULL AUTO_INCREMENT,
  `prj_id` int(11) NOT NULL,
  `cln_id` int(11) NOT NULL,
  `frl_id` int(11) NOT NULL,
  `rev_is_client_to_freelancer` tinyint(1) NOT NULL DEFAULT '0',
  `rev_title` varchar(255) NOT NULL,
  `rev_text` text NOT NULL,
  `rev_stars_count` tinyint(4) DEFAULT NULL,
  `rev_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`rev_id`),
  KEY `reviews_projects__fk` (`prj_id`),
  KEY `reviews_clients__fk` (`cln_id`),
  KEY `reviews_freelancers__fk` (`frl_id`),
  CONSTRAINT `reviews_clients__fk` FOREIGN KEY (`cln_id`) REFERENCES `clients` (`cln_id`) ON UPDATE CASCADE,
  CONSTRAINT `reviews_freelancers__fk` FOREIGN KEY (`frl_id`) REFERENCES `freelancers` (`frl_id`) ON UPDATE CASCADE,
  CONSTRAINT `reviews_projects__fk` FOREIGN KEY (`prj_id`) REFERENCES `projects` (`prj_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reviews_freelancers`
--

DROP TABLE IF EXISTS `reviews_freelancers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews_freelancers` (
  `rev_id` int(11) NOT NULL,
  `frl_id` int(11) NOT NULL,
  PRIMARY KEY (`rev_id`,`frl_id`),
  KEY `rev_frl_frl__fc` (`frl_id`),
  CONSTRAINT `rev_frl_frl__fc` FOREIGN KEY (`frl_id`) REFERENCES `freelancers` (`frl_id`) ON UPDATE CASCADE,
  CONSTRAINT `rev_frl_rev__fc` FOREIGN KEY (`rev_id`) REFERENCES `reviews` (`rev_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `skills_freelancers`
--

DROP TABLE IF EXISTS `skills_freelancers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `skills_freelancers` (
  `skl_id` int(11) NOT NULL,
  `frl_id` int(11) NOT NULL,
  `skl_frl_years` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`skl_id`,`frl_id`),
  KEY `skl_frl_frl__fc` (`frl_id`),
  CONSTRAINT `skl_frl_frl__fc` FOREIGN KEY (`frl_id`) REFERENCES `freelancers` (`frl_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `skl_frl_skl__fc` FOREIGN KEY (`skl_id`) REFERENCES `skills` (`skl_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `steps`
--

DROP TABLE IF EXISTS `steps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `steps` (
  `stp_id` int(11) NOT NULL AUTO_INCREMENT,
  `prj_id` int(11) NOT NULL,
  `stp_title` varchar(255) NOT NULL,
  `stp_description` text,
  `stp_budget` decimal(6,2) DEFAULT NULL,
  `stp_status` tinyint(1) NOT NULL DEFAULT '0',
  `stp_tx_hash` CHAR(66),
  `stp_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `stp_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`stp_id`),
  KEY `prj_id` (`prj_id`),
  CONSTRAINT `stp_prj__fc` FOREIGN KEY (`prj_id`) REFERENCES `projects` (`prj_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping events for database 'coinlancer'
--

--
-- Dumping routines for database 'coinlancer'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-11-03 19:02:59

-- MySQL dump 10.13  Distrib 5.7.20, for Linux (x86_64)
--
-- Host: 192.168.1.125    Database: coinlancer
-- ------------------------------------------------------
-- Server version	5.6.37

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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_title` varchar(255) NOT NULL,
  `cat_description` text NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Web, Mobile & Software Dev',''),(2,'IT & Networking',''),(3,'Data Science & Analytics',''),(4,'Engineering & Architecture',''),(5,'Design & Creative',''),(6,'Writing',''),(7,'Translation',''),(8,'Legal',''),(9,'Admin Support',''),(10,'Customer Service',''),(11,'Sales & Marketing',''),(12,'Accounting & Consulting','');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects_skills`
--

DROP TABLE IF EXISTS `projects_skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects_skills` (
  `skl_id` int(11) NOT NULL,
  `prj_id` int(11) NOT NULL,
  PRIMARY KEY (`skl_id`,`prj_id`),
  KEY `skl_prj_prj__fc` (`prj_id`),
  CONSTRAINT `skl_prj_prj__fc` FOREIGN KEY (`prj_id`) REFERENCES `projects` (`prj_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `skl_prj_skl__fc` FOREIGN KEY (`skl_id`) REFERENCES `skills` (`skl_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `subcategories`
--

DROP TABLE IF EXISTS `subcategories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subcategories` (
  `sct_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `sct_title` varchar(255) NOT NULL,
  PRIMARY KEY (`sct_id`),
  KEY `cat_id` (`cat_id`),
  CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`cat_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subcategories`
--

LOCK TABLES `subcategories` WRITE;
/*!40000 ALTER TABLE `subcategories` DISABLE KEYS */;
INSERT INTO `subcategories` VALUES (1,1,'All Web, Mobile & Software Dev'),(2,1,'Desktop Software Development'),(3,1,'Ecommerce Development'),(4,1,'Game Development'),(5,1,'Mobile Development'),(6,1,'Product Management'),(7,1,'QA & Testing'),(8,1,'Scripts & Utilities'),(9,1,'Web Development'),(10,1,'Web & Mobile Design'),(11,1,'Other - Software Development'),(12,2,'All IT & Networking'),(13,2,'Database Administration'),(14,2,'ERP / CRM Software'),(15,2,'Information Security'),(16,2,'Network & System Administration'),(17,2,'Other - IT & Networking'),(18,3,'All Data Science & Analytics'),(19,3,'A/B Testing'),(20,3,'Data Visualization'),(21,3,'Data Extraction / ETL'),(22,3,'Data Mining & Management'),(23,3,'Machine Learning'),(24,3,'Quantitative Analysis'),(25,3,'Other - Data Science & Analytics'),(26,4,'All Engineering & Architecture'),(27,4,'3D Modeling & CAD'),(28,4,'Architecture'),(29,4,'Chemical Engineering'),(30,4,'Civil & Structural Engineering'),(31,4,'Contract Manufacturing'),(32,4,'Electrical Engineering'),(33,4,'Interior Design'),(34,4,'Mechanical Engineering'),(35,4,'Product Design'),(36,4,'Other - Engineering & Architecture'),(37,5,'All Design & Creative'),(38,5,'Animation'),(39,5,'Audio Production'),(40,5,'Graphic Design'),(41,5,'Illustration'),(42,5,'Logo Design & Branding'),(43,5,'Photography'),(44,5,'Presentations'),(45,5,'Video Production'),(46,5,'Voice Talent'),(47,5,'Other - Design & Creative'),(48,6,'All Writing'),(49,6,'Academic Writing & Research'),(50,6,'Article & Blog Writing'),(51,6,'Copywriting'),(52,6,'Creative Writing'),(53,6,'Editing & Proofreading'),(54,6,'Grant Writing'),(55,6,'Resumes & Cover Letters'),(56,6,'Technical Writing'),(57,6,'Web Content'),(58,6,'Other - Writing'),(59,7,'All Translation'),(60,7,'General Translation'),(61,7,'Legal Translation'),(62,7,'Medical Translation'),(63,7,'Technical Translation'),(64,8,'All Legal'),(65,8,'Contract Law'),(66,8,'Corporate Law'),(67,8,'Criminal Law'),(68,8,'Family Law'),(69,8,'Intellectual Property Law'),(70,8,'Paralegal Services'),(71,8,'Other - Legal'),(72,9,'All Admin Support'),(73,9,'Data Entry'),(74,9,'Personal / Virtual Assistant'),(75,9,'Project Management'),(76,9,'Transcription'),(77,9,'Web Research'),(78,9,'Other - Admin Support'),(79,10,'All Customer Service'),(80,10,'Customer Service'),(81,10,'Technical Support'),(82,10,'Other - Customer Service'),(83,11,'All Sales & Marketing'),(84,11,'Display Advertising'),(85,11,'Email & Marketing Automation'),(86,11,'Lead Generation'),(87,11,'Market & Customer Research'),(88,11,'Marketing Strategy'),(89,11,'Public Relations'),(90,11,'SEM - Search Engine Marketing'),(91,11,'SEO - Search Engine Optimization'),(92,11,'SMM - Social Media Marketing'),(93,11,'Telemarketing & Telesales'),(94,11,'Other - Sales & Marketing'),(95,12,'All Accounting & Consulting'),(96,12,'Accounting'),(97,12,'Financial Planning'),(98,12,'Human Resources'),(99,12,'Management Consulting'),(100,12,'Other - Accounting & Consulting');
/*!40000 ALTER TABLE `subcategories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'coinlancer'
--

--
-- Dumping routines for database 'coinlancer'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-11-03 19:05:00

-- MySQL dump 10.13  Distrib 5.7.20, for Linux (x86_64)
--
-- Host: 192.168.1.125    Database: coinlancer
-- ------------------------------------------------------
-- Server version	5.6.37

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
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `skills` (
  `skl_id` int(11) NOT NULL AUTO_INCREMENT,
  `skl_title` varchar(255) NOT NULL,
  PRIMARY KEY (`skl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skills`
--

LOCK TABLES `skills` WRITE;
/*!40000 ALTER TABLE `skills` DISABLE KEYS */;
INSERT INTO `skills` VALUES (1,'Adobe InDesign'),(2,'Adobe Photoshop'),(3,'Adobe Illustrator'),(4,'Analytics'),(5,'Android'),(6,'APIs'),(7,'Art Design'),(8,'AutoCAD'),(9,'Backup Management'),(10,'C'),(11,'C++'),(12,'Certifications'),(13,'Client Server'),(14,'Client Support'),(15,'Configuration'),(16,'Content Managment'),(17,'Content Management Systems (CMS)'),(18,'Corel Draw'),(19,'Corel Word Perfect'),(20,'CSS'),(21,'Data Analytics'),(22,'Desktop Publishing'),(23,'Design'),(24,'Diagnostics'),(25,'Documentation'),(26,'End User Support'),(27,'Engineering'),(28,'Excel'),(29,'FileMaker Pro'),(30,'Fortran'),(31,'Graphic Design'),(32,'Hardware'),(33,'Help Desk'),(34,'HTML'),(35,'iOS'),(36,'Linux'),(37,'Java'),(38,'Javascript'),(39,'Mac'),(40,'Matlab'),(41,'MySQL'),(42,'Networks'),(43,'Oracle'),(44,'Perl'),(45,'PHP'),(46,'Presentations'),(47,'Programming'),(48,'Python'),(49,'Ruby'),(50,'Software'),(51,'SQL'),(52,'Systems Administration'),(53,'Tech Support'),(54,'Unix'),(55,'UI/UX'),(56,'Web Page Design'),(57,'Windows'),(58,'Word Processing'),(59,'XML'),(60,'XHTML');
/*!40000 ALTER TABLE `skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'coinlancer'
--

--
-- Dumping routines for database 'coinlancer'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-11-03 20:09:37
