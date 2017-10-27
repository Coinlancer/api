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
  `acc_password` text NOT NULL,
  `acc_verification_key` text NOT NULL,
  `acc_is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `acc_description` text,
  `acc_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `acc_crypt_pair` text NOT NULL,
  PRIMARY KEY (`acc_id`),
  UNIQUE KEY `accounts_login_index` (`acc_login`),
  UNIQUE KEY `accounts_email_index` (`acc_email`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (23,'Ihor','Siryi','freelancer','vepixiwiz@p33.org','$2y$08$cS9QUktDUnhCdGoyKytJSe9AFf5HdenMMrpPpFHuVjvBWchYRvQAW','54349969',0,NULL,'2017-10-27 12:00:01','eyJpdiI6IjZaSXBlcTM1M05ndUhvcEZsWmdxWlE9PSIsInYiOjEsIml0ZXIiOjEwMDAwLCJrcyI6MTI4LCJ0cyI6NjQsIm1vZGUiOiJjY20iLCJhZGF0YSI6IiIsImNpcGhlciI6ImFlcyIsInNhbHQiOiI4cWpBS2h1aGpqST0iLCJjdCI6IkRhTkhPWUNJUFlBb1V0RERKeDlKaDNrdHh0eUs0WmhLd21ScGZndjdRUjZwWXVBMWgyRkhsei84M1kxOUErVzJESzR1b2NYT2xCZDVJWVdud0pXVklVRlVGQ3I1VStOcXJOWDFwUWFVVEcxN3ZBTEVyNUhnaW14N1g1c2NNL1ZJdllyeGtLN3NFTnhNaDduL2JETXpDQ3pUYWorRm52a1pYbWpRQmNWZzZYU3l0VkpUdDNLd05iUTc0a0pzT2oxSWpiRzl3V0oxVmF6WXZBREZIWitHSFNEZDJRL2tERk9hZGFxQ2xudmtZc3dpbDdrdm9pVTc1MGlZcUs2T2RQRTNUMnJTWmM3cXJXWVgwYVgwYXJjTFVNQWFtVElrcUl6TlBQUGJkMFFSaGt1TTdvNWMxRElRQU5xSmpPYnJGUFc3RFp2QWVrL2grZDA2c3JpWHBESXRieWtNdmZIc2xCR25CSmIxUWgxZUdGU2F2Mi80RXg4V000WnVyWTNyWGpOd296UkVrbVBkKzRHaXJQSHBETDFqd3M4dktPM1FId3RoN0UxWlhrMEhtdHNhQVRoWFZOM2ZFUHVad0RsZUMvM0VwLy9sM05LY0Zhdjczbkk2RnFhOXlqcmorcW91dHg2TGNPSy9HaWtxay9GSDJpbkMxSG5Jc08xOXRJVjJFLzY0TEpaVUtwSjRSN014bmhKYUIrRlAifQ=='),(25,'Ihor','Siryi','freelancer_test','gejo@p33.org','$2y$08$ZXpRSTNYYmovWitTMk56VuEqEV4J5zk12QYbo5sQoLnzp7WoT3476','72687698',0,NULL,'2017-10-27 12:01:36','eyJpdiI6InZUUjdDQXlMQWNIUUNBVTVienp1bVE9PSIsInYiOjEsIml0ZXIiOjEwMDAwLCJrcyI6MTI4LCJ0cyI6NjQsIm1vZGUiOiJjY20iLCJhZGF0YSI6IiIsImNpcGhlciI6ImFlcyIsInNhbHQiOiI4cWpBS2h1aGpqST0iLCJjdCI6IjlnencvVkZXREhoRlJWakFnSkovY3FTajRncElrYk4yNWQrUCtvdHRVMGFpNWJmN1BJeFoyNDllcnEreVNHUFBJcU93ZWxIQXZyeE9ZcE1qaDNtKy9rTzYycUsvZG9ML1VzajZ4alI3QVlxTmkwOGZsclVEMFhUYWl4KzViWWNsa0x6NllPemJHcWg2a2wzRU96VTgrSVF4MzM0MFBlZHVoc21PUk0vYVU4akkyWXg3azhINlJSb084dmc1N25mTU43Y2NzL2d1Q3ZrL3FpMGRsbTNFS2JJbjczVU16Vyt6SENqMU1YSWxQQzQ4THhGSkJMT1NGK3pJN3NqUUV4cTNoV3hnOVYyek10TG1HVWxwa1NEdFRHZnJJRWxHdjAxYUF4cnJsWFJMWHBqUUpqZnBPU01CM0lQTzZFTitVdUZoaWxLL1E5NXVRZGpNaHJteU85RFd4RS95SGNtUmxtQ212NzhsMndhWmVOS1g2ZG1hbnE2YzlYdDJDR0M2bkxIOGpMUVQweHZTUjd4R3JUL25rTlRBMWYyNnJNR1NsR3RYdEgyOTNYZlVOSkFxZ3U2SGJHa09TcCtJVGZEZWs3NkVld082MlZDaXFEd3RhZW1FREFoRWwwNXZSMjZyUnFISzNMclBrTHNab3Z5Tlhyd0ZiaEpxWmczT2s1Zkx6LzJ1MHVqVEs5aGxaTGpsRHF6ZWdadC9GT2oxIn0='),(27,'Ihor','Siryi','freelancer_user','rojenel@p33.org','$2y$08$Y0tWdTg4UHRTdzZlWHNJcOcFBRtHXPxPj/ltiz5e2tfD1grvYWWS2','55165486',1,NULL,'2017-10-27 12:03:22','eyJpdiI6ImsxNVFhSjIvNFowa29HbU1CQlpFNkE9PSIsInYiOjEsIml0ZXIiOjEwMDAwLCJrcyI6MTI4LCJ0cyI6NjQsIm1vZGUiOiJjY20iLCJhZGF0YSI6IiIsImNpcGhlciI6ImFlcyIsInNhbHQiOiI4cWpBS2h1aGpqST0iLCJjdCI6IjV1TTNvYzJEWFl1QjMyRXVJQnJBUTNKbjVSU2psVU9GeHRhM28wRjlLYWhlcG4zbmtMZlBsTGZhZ0dSNUtwNjdLZTVha0NGTlJiY0FPWHhlcmZtZlNNbGVMd3JIMGlrYUlXK3NBajVBRFRtazh5KzJMY2QzN0JmRDUxNzVyaDNpT1p2eTBkQ1NHYWdZU2NCOXJIdm80TjQ2R1pZdXMvQ24yUFEvZGUxUldEeG5GK1F1YmpXNjUvdnpWYms1NVQ0bDJMSDRlalpJdmNxTkNjdXZLLzRlbGlBOTIvdFdyVXVVYTV4UDJiWENmYTB5aHI5NlVKYTZwQzUwM3VEbmVIRlI4bnlYc1ZFbmJ2enYxUXlud0JrWEdNd1lGUXZ1VEJESkRmM2pIcXJ0QkFSa0krMVQwWkp3OUhYR09heUhkWE9jNGhNNm1TSkNxY1VaV1ZvelV2Uk40OUllRkFGR2t5ajhQcjVONDB5Ukhua3h3SGdGM085cnRFeUUrV3VQNGdhQ00wUFBIbDB6R3JBZ2Y5YTkzOHVzeUtIUUMyU1dMRUYybW5rQ2J1YXJ2cnk1bHppSUVsOXhCRE5nd2ZmcitKRUZXUmp6OTVMTTRuUTY2V1hpaGRqbUpTLzluaXdXYThMRXlidmJ5cCtlcmMzV0dqNG9TaTdlaUR5ZlVERGR2ZjdtdFhzakh6dE1uTnR6S2c9PSJ9'),(28,'Sergiy','Korzun','client_user','vevamor@p33.org','$2y$08$bm9JM1NVSnJxbjN6U3BtcOLT0VK/n4LzgC8hGCnaj6eWK8Bkini0S','44644044',1,NULL,'2017-10-27 12:22:20','eyJpdiI6ImlQSnpnbmQ5TXZDUzVWRWhOOGUzRUE9PSIsInYiOjEsIml0ZXIiOjEwMDAwLCJrcyI6MTI4LCJ0cyI6NjQsIm1vZGUiOiJjY20iLCJhZGF0YSI6IiIsImNpcGhlciI6ImFlcyIsInNhbHQiOiJ3VFdxYnllK1pERT0iLCJjdCI6Iit5K1RuUUh4czlyQW9jd3pYV0s2TENkazhCOGJkUDZwcnExV3RzK3I0VmJPZllkSHk1SWhMY1FHQU0vUXFZZ04vVkVqaUlPZWFST1JuZjg5UUczZGxzelVVR25uYWgxWTFjRXVHeVFndEt6NWpwVHhRVTNBRklJR1JUbWRoOGJkUEFqcFNqVFVWUlRuRURqZnRwaDVoY0piOHVLUFF1dkE5ZFFtN2ptMWQxZEdNb3BpM053WFl1dkZXS2JsWnlpUitJNGtUVUVqN3lYcFhQVndjaElRTnZKOUtMZ1ByUGYwTWlTOFpjaVVLTWdSM1Fjc1R5K3JPTXZPeGVNMnl5Q3V0NzJBM3hRdDh1RlJoaXoycExJQWJ4YkJTaDNIZEZuR0JYMk5SZXlPLzJSTHc5enYwWVc3dkdZclFCUE9IZFN1RVd0OFpEYUpDdVhTUTRES2hxcHkyRkJkY3ZwSi9MYm9aWlFiSnRtRHZFdmMzbFp1SzZVVmlZWWFxRFNwTnJvRmpXQ0o2UFh5dEVzd0tHSUtma3BkTk4rM2tLbHZSc29UR3ZneU4zOXhxdjdOTlU5c3YyWE1QZkpqa1hRMVZpQWNIbjZsTWthRjlQN3ZQWWFDc09laUZ2ZTQ0cjkwcTlWYXlhY09Hb25YSEJPN2kySTdFRFd6c2JXdVVkMGsvOVBKb0hIRmhXeHBmNGt5QzVBUHhxSjlkRnN0TWc9PSJ9');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

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
  `tch_path` text NOT NULL,
  PRIMARY KEY (`tch_id`),
  KEY `prj_id` (`prj_id`),
  CONSTRAINT `tch_prj__fc` FOREIGN KEY (`prj_id`) REFERENCES `projects` (`prj_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attachments`
--

LOCK TABLES `attachments` WRITE;
/*!40000 ALTER TABLE `attachments` DISABLE KEYS */;
/*!40000 ALTER TABLE `attachments` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Default','Test');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES (11,28);
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `freelancers`
--

LOCK TABLES `freelancers` WRITE;
/*!40000 ALTER TABLE `freelancers` DISABLE KEYS */;
INSERT INTO `freelancers` VALUES (16,23),(17,25),(18,27),(19,28);
/*!40000 ALTER TABLE `freelancers` ENABLE KEYS */;
UNLOCK TABLES;

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
  `prj_budget` decimal(11,2) DEFAULT NULL,
  `prj_deadline` timestamp NULL DEFAULT NULL,
  `prj_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `prj_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`prj_id`),
  KEY `cln_id` (`cln_id`),
  KEY `projects_sct__fk` (`sct_id`),
  CONSTRAINT `prj_cln__fk` FOREIGN KEY (`cln_id`) REFERENCES `clients` (`cln_id`) ON UPDATE CASCADE,
  CONSTRAINT `projects_sct__fk` FOREIGN KEY (`sct_id`) REFERENCES `subcategories` (`sct_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (58,11,1,'Python Development using 3rd Party Library','I have a project working with Zillow API but I get some errors so I am looking for someone who can fix the problem, This can be a great opportunity to work for a long time with me\r\nIf you think you are expert, don\'t hesitate to contact me\r\n\r\nSee more: web development using python, using 3rd party api php, 3rd party library, middleware developer using 3rd party sdk, simple library management project using, library management project using, library management project java using access, python development project, codeigniter 3rd party library include, codeigniter 3rd party library integration, mobile web development using python, code selenium test development using python, project documentation web development using php mysql, gui development using, free 3rd party applications',1000.00,'2017-11-30 00:00:00','2017-10-27 12:28:11',NULL);
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

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
  `prf_price` decimal(11,0) DEFAULT NULL,
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
-- Dumping data for table `projects_freelancers`
--

LOCK TABLES `projects_freelancers` WRITE;
/*!40000 ALTER TABLE `projects_freelancers` DISABLE KEYS */;
INSERT INTO `projects_freelancers` VALUES (58,18,0,900,'I will fix your problems.\n\nLet us discuss and move ahead.\n\nI am expert\n\nRelevant Skills and Experience\nPHP',90,'2017-10-27 12:52:07',NULL);
/*!40000 ALTER TABLE `projects_freelancers` ENABLE KEYS */;
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
-- Dumping data for table `projects_skills`
--

LOCK TABLES `projects_skills` WRITE;
/*!40000 ALTER TABLE `projects_skills` DISABLE KEYS */;
INSERT INTO `projects_skills` VALUES (23,58),(45,58),(56,58);
/*!40000 ALTER TABLE `projects_skills` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `projects_subcategories`
--

LOCK TABLES `projects_subcategories` WRITE;
/*!40000 ALTER TABLE `projects_subcategories` DISABLE KEYS */;
/*!40000 ALTER TABLE `projects_subcategories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `rev_id` int(11) NOT NULL AUTO_INCREMENT,
  `prj_id` int(11) NOT NULL,
  `rev_title` varchar(255) NOT NULL,
  `rev_text` text NOT NULL,
  `rev_stars_count` tinyint(4) DEFAULT NULL,
  `rev_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`rev_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `reviews_freelancers`
--

LOCK TABLES `reviews_freelancers` WRITE;
/*!40000 ALTER TABLE `reviews_freelancers` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews_freelancers` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Table structure for table `skills_freelancers`
--

DROP TABLE IF EXISTS `skills_freelancers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `skills_freelancers` (
  `skl_id` int(11) NOT NULL,
  `frl_id` int(11) NOT NULL,
  PRIMARY KEY (`skl_id`,`frl_id`),
  KEY `skl_frl_frl__fc` (`frl_id`),
  CONSTRAINT `skl_frl_frl__fc` FOREIGN KEY (`frl_id`) REFERENCES `freelancers` (`frl_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `skl_frl_skl__fc` FOREIGN KEY (`skl_id`) REFERENCES `skills` (`skl_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skills_freelancers`
--

LOCK TABLES `skills_freelancers` WRITE;
/*!40000 ALTER TABLE `skills_freelancers` DISABLE KEYS */;
/*!40000 ALTER TABLE `skills_freelancers` ENABLE KEYS */;
UNLOCK TABLES;

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
  `stp_is_completed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`stp_id`),
  KEY `prj_id` (`prj_id`),
  CONSTRAINT `stp_prj__fc` FOREIGN KEY (`prj_id`) REFERENCES `projects` (`prj_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `steps`
--

LOCK TABLES `steps` WRITE;
/*!40000 ALTER TABLE `steps` DISABLE KEYS */;
INSERT INTO `steps` VALUES (72,58,'Create api','Create backend with restful concept',500.00,0),(73,58,'Create frontend','Use some js framework for frontend part',350.00,0),(75,58,'Tests','Use unit testing for api and frontend',150.00,0);
/*!40000 ALTER TABLE `steps` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subcategories`
--

LOCK TABLES `subcategories` WRITE;
/*!40000 ALTER TABLE `subcategories` DISABLE KEYS */;
INSERT INTO `subcategories` VALUES (1,1,'Websites, IT & Software'),(2,1,'Mobile Phones & Computing'),(3,1,'Design, Media & Architecture'),(4,1,'Writing & Content'),(5,1,'Data Entry & Admin'),(6,1,'Sales & Marketing'),(7,1,'Product Sourcing & Manufacturing'),(8,1,'Translation & Languages'),(9,1,'Engineering & Science'),(10,1,'Local Jobs & Services'),(11,1,'Other'),(12,1,'Landings'),(13,1,'Internet shops');
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

-- Dump completed on 2017-10-27 16:20:50
