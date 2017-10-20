-- MySQL dump 10.13  Distrib 5.7.19, for Linux (x86_64)
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
  `acc_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `acc_crypt_pair` text NOT NULL,
  PRIMARY KEY (`acc_id`),
  UNIQUE KEY `accounts_login_index` (`acc_login`),
  UNIQUE KEY `accounts_email_index` (`acc_email`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,'Ihor','Siryi','awesomeua','for0work0@gmail.com','$2y$08$ZFB3U2JUTlQ2eEl2TDMxTu/CsInqLpkR2eY9uA0p1X87UXraAovmW','80179160',0,'2017-10-17 16:27:18','eyJpdiI6Imh1eGYvT25JN2k1RGJrYnFqVllPT2c9PSIsInYiOjEsIml0ZXIiOjEwMDAwLCJrcyI6MTI4LCJ0cyI6NjQsIm1vZGUiOiJjY20iLCJhZGF0YSI6IiIsImNpcGhlciI6ImFlcyIsInNhbHQiOiJ6MkQ3TitXTUpkdz0iLCJjdCI6InRRS2kxeUtxV3Q1MTJOTjlJSE95SVhqRXNycEROYkNYVEVMZU1SeFV2R2ErOXh5YnFHVmR4eGg2RGV1WktxK3N5ZnpZUDYvOE9nN0d6WStUYmtIQ0QvMEhNbGZ5YXlFRm5oNmJnSkNQYndWOTA4SEptSTJ4T2RxaWFpTWE1bW04VlhEcmdYczkvSVJjcHlML0U1Nk8yVEZhQ0k4OWdHai9HOURpQkFXS05uUGtqakNUR29GTHg4VkRXd21QcHU0SzZpcVNSSmxsMEtLNGRLNjhFWUZtVE9IM0tqWm9Wc0hSeVZMMUNqeWwyTDdXRy81OGdzNTMvM1pLZG9KRy9vVVNlWGxkMXVWa004cGRsMjZaSHMrRjloU3E2MHFOMUs1L3JtY2hxd3lxWVgwRERjZUxiV3BneVNnYlJIWDBoQVUrbisrRkJidFpnMExWL1RtL0xmblNodUc1YUQ3dW1CQkxvZ3I0YVNUcExXbHEyd1kxa3RUazVWbXRiYWk3SU1BY0xIM2JJMjhvaXAxM1dZcUYvQURBT3pjNnJxWDRFUXg2bCtydFFIVmdpYkQ3ZFVUSDk0OGIvck1IQXZPNEFOZ2Q5TVh2RFhjR3g1UmJudXVUR09SZE12WXhSbm50QzNiUFc2UDRjZGovMkhWWDVibzRUSHdHYVdpdzNQYzBsMk5rRWVvek9HaTJYSXJ2Z2lJeXhXRzR4WVMrQ3J4L1NRPT0ifQ=='),(2,'Ihor','Siryi','awesomeua1','for0work1@gmail.com','$2y$08$UjVrRGpYOVpXSG85eG5mLuSTl1V3IjPCCJYIUPsDKuNM4SJEcyspe','63005819',0,'2017-10-17 16:31:04','eyJpdiI6ImNENEd1TWdGWVJ1VU03SFZwc0xDdEE9PSIsInYiOjEsIml0ZXIiOjEwMDAwLCJrcyI6MTI4LCJ0cyI6NjQsIm1vZGUiOiJjY20iLCJhZGF0YSI6IiIsImNpcGhlciI6ImFlcyIsInNhbHQiOiJ6MkQ3TitXTUpkdz0iLCJjdCI6ImsyVnFxa3Z0cVNmMHk5M1pNVUtINVZkN1g5dUcyN0c4MHluY2lNNDFMdGY1QjViNTBqOEZDTlRNcW1FV0lkS0h1VWhsaC9yV2FzblFUNGl5UWtSOFJVK0lDbDkrL2pOLzFjTllCdVAzRWdpdUJqcFVxQVd1QU04NzBMZk4wT3k4WFVjV1FNaWUrN2dVWU0wcHJZZXd5MGZXNVRud0N5bEMrVUUxRkdtbHh0azEwRm5ET2xqWW5OUVE1VkNKNnVyOU1KWjJXQnk1UEU3c09kSU05d3ZndWVKanRucmtDYkt5VWlLejFZNHdIR2l0c0I5NklsS2J1emkzZWhIZzdtdStJVzhtOEpjcGpGRVRmeGMyaHR3MkNTd0VYRjd0TDJ3NXdKMlk4WEdBQTZueGFYWmRJWHRPS0x4aFdVa1REV1ZsMW52cm1KRjVBeFJRandCU0RhM2dySUFtUGd5OEgzSjB2SDVQKzV0bWRlWkdhVWtRTGdNS1NidCtSNHdNeVM5VEtieEJISUdiS0M3NEpLNkN5bUtRZWJFcE9sdUZpQm81VUdaekYvcWNJZDg4RW9qMUdJbDFtNjgyd3dYWCtTeXdkNVMya0luai9XQmM0REJqWFV3eTMwbnJtdGZ5MmJ5d1hjeE55dG5BYWJnMGliall5UlJ5VlFIWElxSE53OWtIM2dsRGQva2VtNFVkajNkUkdnPT0ifQ=='),(3,'Ihor','Siryi','awesomeua2','for0work2@gmail.com','$2y$08$S2N6Z28wbDVXWndQZUg1Mu0hndjfWEEj3/z2h7x0q0adfo8PUfTbC','97781779',0,'2017-10-17 16:33:28','eyJpdiI6Ijh4WE1qYTNzZnJrWkhpTmc3bE5obnc9PSIsInYiOjEsIml0ZXIiOjEwMDAwLCJrcyI6MTI4LCJ0cyI6NjQsIm1vZGUiOiJjY20iLCJhZGF0YSI6IiIsImNpcGhlciI6ImFlcyIsInNhbHQiOiJ6MkQ3TitXTUpkdz0iLCJjdCI6Ik5zRDdrT3ZGVVNrTUl6bVJCbm5peVhQWjJSRHAydG4wZVJmNkJYQW5vUWxuVlhRb0QvQjNzdmV4Q0FIN3pJZDltaGN5djJaT0tiYm4vSyt4KytkRXNNSUU5cklhQlh5M1c0anJ0TVdiZmtxNUMxL1lnTnNNVld0clpIWGphK3JucGM3bXpETDdKYkkrTi9oTWx4MXJKYXcwNlM3YTVVbTE5UGxReXJVbnRaTW5vczYyZVp3K2Q0VXpRQVMyNUR6M2locTRwNm5XdTgzem5tRk00N29UdmNzcWVWZXd4cWE3akVmelc5MHcwS1o2eUM3UFVXNXhPMVRsSEpBbUdxWFNXS2xBZFFTY004ck90Q3dDSXZtMjAwWjBmV1BWS2lrNjZ5V3Vtb0d3bUtqWEQyaUtnbGpkdlNEYUFGSFkxL3Z1WXJYWG1OaHo3ZU13NWIrQjR4bFhiVkVpT1JHSmdrTGJSeUQ3a213TnlvTlRJV01HbTJvdVBDY3krMkxBRkZDS1FzNDZVcTlPVHlSN2Y1VEF1RUFWQlBnV2tZUkxQODNjOStzTFdhL2dwRWZhWHdwWHBpRURub1pTQ2JkMWMxZyt5Qnh3WTgrdHU5YkVSNk1ncnBWcWhOb1RRYzBEY1hYQzhEb3dIa3Q1ZmVMNXU2d3AvVjdENXBUdTllUU82OU1JT2NhdUwxTXd6SzQvN2J6ZXJ4blFCNHNGVDRPTFAxeEkyZz09In0='),(4,'Ihor','Siryi','awesomeua3','for0work3@gmail.com','$2y$08$aVZXZCtjQWpKcTlNbWppWOd543eW0zI6w/zliVzeP8JbUrFBuBdGC','96273959',0,'2017-10-17 16:34:48','eyJpdiI6IjQwU0hTSE5mdWx5Wkd1aCtXTWNOMXc9PSIsInYiOjEsIml0ZXIiOjEwMDAwLCJrcyI6MTI4LCJ0cyI6NjQsIm1vZGUiOiJjY20iLCJhZGF0YSI6IiIsImNpcGhlciI6ImFlcyIsInNhbHQiOiJ6MkQ3TitXTUpkdz0iLCJjdCI6InBqTUZkb3pQcDRIWExhOStzY0VFSU1mU0hwUXo2YnNLOUJWZTRCQ0Z0ZkF0cWJQZUtkOFlIOFNDTFBCeGJxdDM3ZktQUktsRVBDSDN0M0c5a3dhaHhVTG5rZHhXcU8vVXlpWUxjMlN0TG8yTCtMSGNyVUJySC84WEJDTDFPVDc3MGg4QlRrK3VTL2tDWEs5UVVEUXFhdUFXVXhSeHZXSW9OblEzVUt3R3YvNTg3Z25JSmxHY0EwZklGOTJ4bnhvQUdqY1poZTZpazJZTkhXVSsySW5maEVzWnpia0NnejJxdk9haW5vK1JnQ3pLTXkvRVVBYkwwaCtQWU1PSE0xendvWlZGaEhHZ2ZzNkdsWGRrQTA4ck5wTlZ1N3V1UVJuZ3I3WjVYVU1kZ3luNTFLeFlQN0cvcFBaMERidzhCampJdDNhRnVkRmI0a1p5YkZ5NGhYTXN5ZHI2MTQ0cW1kZDVtd01nVkN1dUFkTnJKQUNXdDI4UGtqWHVrNkkzVGxMZUxUaVNua0UvZ25OR2hXcGRzK2JUQzhXZFkzY2FCYjBrM2FWQVBYUnBEa3RPLzFHYVFNNDZBdERsdVJ1SnlEc290RDVGZG5Tdm4wN2RZTXJESWI3WjhsaFN6ZlJYQ3hiY2ZRN21OV1FyMFliNzFSZHQxMzFCLzlWQXFzV1pBOTNFYmNlOFJ1QmlzTmM3NjlUNVdPOD0ifQ=='),(5,'Ihor','Siryi','awesomeua4','for0work4@gmail.com','$2y$08$aFQ1WU8wUFhZT29TUVBLTesdJHWTtnKnUKjBffcIDVRsIYuIA0csu','48239332',0,'2017-10-17 16:35:44','eyJpdiI6Ill0dVN2cEErczMxNXl6NThOY3p4N2c9PSIsInYiOjEsIml0ZXIiOjEwMDAwLCJrcyI6MTI4LCJ0cyI6NjQsIm1vZGUiOiJjY20iLCJhZGF0YSI6IiIsImNpcGhlciI6ImFlcyIsInNhbHQiOiJ6MkQ3TitXTUpkdz0iLCJjdCI6Impuc3Z3Q0JlL3diTVlrSlE2Z1piSGlpbmdNUHpEL2dVdncxL0IxcjhXb21wSCtnUWlKbmF4aHl6RmcwaENxbmF5YlRNMXZ5NXpXZE13MitGWVZsSUNNZ0R2NDRTREZDd09DMEsyQ3VIWThPRXU0Vy9WaXFKM2ZXQ3RYdGlWd0lqNU9wcVNrSDFPYzY1WTZZNUJYU08vTzNBcW85TXh0NGpRemxWV2h4Z294VlRLcDlqUkhGM0hTUFdvdHdpNFIvbnIzMWFXT1RhZXhlRkJlZk40ck9xR3Z0TnlFVW4xS2ltTGpPOGdjb1pCZXdrcGJIQUhlWWhRakQ1Yy9HeUl5RDhaMEJ6VUltQWlMc3dLRktQMUNPbzVwUWY3UkFMR2FrNG55Vjl6R241VHlUQzc1VnJ3N1RDS1NYSUJWU3YwOFR3ZVZycjkyQW1pdG9qdGRkT3VUUnFic1BaUmZTeDFBQUV0bVJ6ZGN6VkVPQU1SSmZCRzRLZTErK09SSVhzVnJMWGM0TmtxWWZnNnFqMU4yNVR6eERJRG5aTHV6Yy9oWjFpaDgxcUxESUR3bmFjUVl2cFM4TXlERHAraGV0dS90WXplMWZUdlF6c3UwRGRqOXJxQU9LMnBXSkdIb1czckEvK21aYUFPYzlrTFN6N00zV2kyeFVjb1p5U2Z6WWk5TEw1K291N0gxcXFKT3dkZUM1eTlTaz0ifQ=='),(6,'Ihor','Siryi','awesomeua5','for0work5@gmail.com','$2y$08$WGtBMm4wTUNrbEMyMDNkROlAUfyKA14doGAnEuVIq6niSuo2tmDc2','71603243',0,'2017-10-17 16:36:35','eyJpdiI6IjAzZC91YjM2bkxsbG96WUtkRURpeHc9PSIsInYiOjEsIml0ZXIiOjEwMDAwLCJrcyI6MTI4LCJ0cyI6NjQsIm1vZGUiOiJjY20iLCJhZGF0YSI6IiIsImNpcGhlciI6ImFlcyIsInNhbHQiOiJ6MkQ3TitXTUpkdz0iLCJjdCI6Iit0cWRJRkQ4TEwzRzJQa0VLNXBtUDluWnFEOGdUTVh5N1hMb2FUT1Z2VkMrRG9kcG9DejdheWUwOWZnWW1aaFNBLzB4VWVQdE9ZcndnRzF1cEZuQmk0MEJhbWhJSkFwSzI1bmQwcUFJL3FKbzRmdWdSL3JpV1p0MC9IRTBmOGU0TDRKb1BscHZFTzZNM0ZEVDc4V0NCMHFnNUdQV0cxU2U3M3hCYUQ0MFpZMWU5VFU0VXcyTmxnZFdPTGs1YnZJMU5KZHhyNTdtbENndmZRMFJDb2c0eUNkU0g3MUJDdktyUDJMK0Nxbzk2eEIrcWxxd3VpYWZCWDdPeXpmd1hTTi9jaGRKTU5xbHdVRFM4cXZyVjhxdTdaWDVCZFJQQzRBTnpjRjdzRldKc3hwMCtTWmJLYy9tYVRJSGpXcC9OcWx5eUFpdEtxaFg3Wnpha0prVWx3eG5BUTBWMjFqSWkza0lpQTlnK2ZJTGRNUmpKTjl0bXJlb2o0N1NWTGszZlVMOUYwRWNsR2hlV0d1UE9raGNKb3RtTkdUUm5NWk9WYS9sL3EwbllZbHNwSU85NjJJUkNubC9Kbnd5aTFGN2k4dy9Rc2E2T2xUeHh3ak9VOW9PeEJRRGNLeXZ0eTM2dnBHYUx4TjAxSWpqWGkvdXdvZExnczFCYkFHUnYvRXNNdVd6QkcrREZRWGJaeXdxYXpVNUNsST0ifQ=='),(7,'Ihor','Siryi','awesomeua6','for0work6@gmail.com','$2y$08$NkdWUDFOTDVZa0tHNlFxc.fcBUgBr8zSf1.xbdn/Kf90sFcBzz1hy','16865665',0,'2017-10-17 16:38:07','eyJpdiI6IldjVytaeS9oZ0FHbGRxQnplTXVpRHc9PSIsInYiOjEsIml0ZXIiOjEwMDAwLCJrcyI6MTI4LCJ0cyI6NjQsIm1vZGUiOiJjY20iLCJhZGF0YSI6IiIsImNpcGhlciI6ImFlcyIsInNhbHQiOiJDbTd2TnlqblRuaz0iLCJjdCI6IkhKNDMvbjRHYmljTVpDVHFPK0h0UzVCMXhrRWsxbk5NQVNZTk5Nc2NsN09sdVo2Wmt2YWdic1N2M2lHdUEyQnlDcUd4YlM4VWE3UjlLd0FQcy9vMTQzSkVQODRYbFBPdmZqSXZjNW4zZmtNUkhQOXFFRStNVUUzaWF0cWJPK3NMbUVYL2ZtUGRHNFdCTGlhalAvSGNYOFM0bDBlSC9vZVFjS2lpa2p1R214c2hVOEttTmo3UXlwaG00S24zVnBOR01GRG9lV3pQdWtHVnVndTBBZUVGUFVHYnRIL1lXL2w0UlpicTZtWml5bVBSNkdwbDh5eWNhd2xPUzMyeG1HSVlicnQ0ZFgrZDZuT0lrNTBUaFdVa21UVlBtREs3SkZyRzhZeGlxeEpiNTlCMGIra3o1QnVwRjhWSEdEbDBrcTdmQm1Oa2JFdHVEOVB0V2wrRDN2clViSmkzalYwRTFvYUNtQWV4YmcvdktQWE1KS1czMUNkRFpDSWJuOXVZbXZPUDNHREswejJ4akdVUmo5VDBaRjRaTzZSLzkrSzVHdGxJczV6clk1VmVMZlQ2NFNmdG53NXd6Z2ZuMDh5MWlqV3JKOGNOM0VBUFVKNWM0V0w0US91UlFjeXlsS0ZtU3huZS9zeE5sYTB1OUhueWZpRHJJWWRISDdKd2xteHVUcnh4MzFFV3QyM0NnTGtzNXViSFRNRzV5Zjc3N2V1a3VuTlF5a0E9In0='),(8,'Ihor','Siryi','awesomeua7','for0work7@gmail.com','$2y$08$Wm5heFJaaElXbnNabmNXb.3Z5rq0Lapd4cuov.LNyhhxWruEsr76O','10867352',0,'2017-10-17 16:39:17','eyJpdiI6ImJ5U2p3Q1oxZHdHMmRQTEs3cHVWeFE9PSIsInYiOjEsIml0ZXIiOjEwMDAwLCJrcyI6MTI4LCJ0cyI6NjQsIm1vZGUiOiJjY20iLCJhZGF0YSI6IiIsImNpcGhlciI6ImFlcyIsInNhbHQiOiJqMEJSNUtWV3VaTT0iLCJjdCI6InY2TnBidm1QMlBTVy9UR0xXVlpET1Mzd1A2em9kOEh0bFV5T3J6WTByeGU1WFlZTHNNT2lHZVI0dVNWcDNKR2Fjb0oydDQvNTV4cjJ6eVNMaTdHNHVXdm9qTVltYm1PbG9mS2h3M3JSUGQvNlIxMW03K3RLM0RjMXhld2hZZDFGQTU1SFY2Rkg1SnBBUDUyNWxXbWxtaTJtbS9QWVlUUkZsNTQ4VVVmQUtEWTJPZUxjT0xsODU2dDVoRG1jSUJGNktyTjU3cWdUTDdJcVRYY3lsUDBsQ1RHdmFOdVNqcEZGamVUcG96Nk9iZmp3SkNCN3gzZ0xBMzlsY2txcE91K29rUE5vdG1MRDI5TjlxQWdOK2JQc0tHdUtRWkxoYmNicWs4bHJvZXhlWkNJMXpjQndndWFlMXpUWHkvM0FEY2xHclUzUnFCMnNjYnUrRlBOeHVCZ2JUcXdYNFlZR1hrWDBNcWVvVWxDU2R5VE9CeE8rSkxBUlRESXF6YmFNbmpIMzVkUEx6bG5QQnZlTDdueU1aN0NFWHNLRWw5b0FJMGs3aE8vSHBFK0oyRVd1TXZyaWFDMnVQOUIrQ0NCendEcVRteEtLNG9LSklqNWc3OG4yV2VJakJpcEhBU3QzZUJDQ2Fyd2NSYnQ5R2tyanhTaU56YVJoVGJVQ1ExMk1waWlPaHRVcnlTNU9CNTE0RGVVdUxOMi9XbzJ0MWQwPSJ9'),(9,'Ihor','Siryi','awesomeua8','for0work8@gmail.com','$2y$08$N3pROG0xVVFhS1d5d2Z3N.7cUknzvJ1N8yhta.hknz26lCyfBFrVa','68132374',0,'2017-10-17 16:40:45','eyJpdiI6Ik1JLzNBTm9yaVJzU3Z6bHIxRTZoaHc9PSIsInYiOjEsIml0ZXIiOjEwMDAwLCJrcyI6MTI4LCJ0cyI6NjQsIm1vZGUiOiJjY20iLCJhZGF0YSI6IiIsImNpcGhlciI6ImFlcyIsInNhbHQiOiJOdWJTQkI3T2xmST0iLCJjdCI6Ill1SWl4L3RsM2IvOUppNFUzVEZhdDE0clVtUEhNcVF4UnVTRVVUQm9QOXhWSGtTdDFLSHkwM3FSejFxcVFVeWJmSUxqcVdqZ28vTnVFbXN0VTBjdGo0QWxXUlNpaWJQVXMvZXpUQkJvdXBoYjNnS2hETTRaWm9icHM5MVR0QkpFUzNickdHd0tkQkkzU1A4c0lSU2I0VU9Vek9UZkJ1K3JPRER1UTVMamlxbUYzTXptMWZrRFhMSDFsRFVVZHFQQldIdkY0eFFHYXljTUFsbldzWW1qSVNrMk54eVRtRUVZdjcyckJYd2xLV01xNTlwbmxtZ3hyNU5zd3Jta05LZFJVZHpRb1dPUm9iejJQL2pDVk8yRHZmM3pCUFNKdDJPSy9QVTBCQkwyb2czeUV0RXhnOEE3Ymh0am53Y0RwcFZCbjdjblpWMC96NURGYVFLYTd6VHJNRmgzeC85THV4ZDBhVDhCeXR4RVp1SUx4SHdGQ0pZbVcyWGR3TTRsdUVmdWdhV2VMWTNSbGFyTlhtcWtWNWFsU01ad29jQ210R1loY2RYcDltQ3FBSXBXaXZLZU8veUlabzFPNHd1SUFXbEZnNXBFQlVQRThhMU5odlRXOVpOcVRLTm1tbCt3NzFNQzFzVWtXMXFlbG92Rkc5V2Y1OHZ2ZG9IRzN2ODlibVJ0Vk96OHdENjA3azBXZUtSS3pnPT0ifQ=='),(10,'Ihor','Siryi','awesomeua99','for0work99@gmail.com','$2y$08$VmRXWEdUd1VvemFYbEdKeeR2O0A3GQ0AylD3slVvS.E7l/7LcA48q','77005189',0,'2017-10-17 16:50:04','eyJpdiI6IkFWQzcyOEZPK3hhdWJlL3l5MGhiWUE9PSIsInYiOjEsIml0ZXIiOjEwMDAwLCJrcyI6MTI4LCJ0cyI6NjQsIm1vZGUiOiJjY20iLCJhZGF0YSI6IiIsImNpcGhlciI6ImFlcyIsInNhbHQiOiIvdStESVFWS2FYQT0iLCJjdCI6ImZkbkR0MU9jVDB6YTdlOGZJN2RTeHViWlc3L3FkVzd6VnZUU091Zys4WFYrOXFSWTBZbU9MTXBIRWYxSmpJakpDekUxbHpWZVo5cGdsR1ZlQjhHZ3FYNU5wZ0U3QWFBMEpWaGZqQXZXK1JZcUMxOXl5dUExTEFKUEtWbG14MlowNmZCc0ZzVGxKSXU2R2tCaDVZL2ZwK01vK3F6SzFpbjE3cUhveFFDQjc4WFFTeHo2MzZuNXk5S3FvSlBZVFdKYXBzSThQN21DYTlWOG02eENHbEt0aDRORFBYMmM5Qko1NHhXMjhhWXVVb01xOVQ0NXNyc0gxSnFubVBSTUhCbkxRY255RFJYY2dKU3p4VVpTd3ZkelJ2eFByTGZMRWkzTk1IRytvdHFKaFNWd05MdnlYUzN0ZjBhdEFnbWo5eHNoSDliR3R0VTlFQ2VVdGZOcm5qV2U1R09JeUMvWHpzWXRmclYwOWtpN3B4bVRqeTl4YnlrVjd1YmorcVl4d0hhR24rZlRQRXlFcG1HVld3T0d4RVZpc2Z5a1JJYWtTSnlYMjNiWGVOTFNhM1pQZy90L0dRV3VCdy9EY3FCbmx0Z3VObTRLdXp2UXRISlVNbmhVRVJYUWY0dlI5Tk14V0QxZ0Vrd25LTzRTQ0R6N1YrN1J1VVloNHQvdFhrTHF4d1ZtOEpCcU1uQ2dieXl6V3BzZlUwd3U5Tlk9In0='),(11,'Ihor','Siryi','awesomeua111','for0work111@gmail.com','$2y$08$TE5sWE5COVVLNjR5akNRZ.8Vrc9nRCVk6mEBvG/JFDJbWRdsy1unG','84662532',0,'2017-10-17 16:53:52','eyJpdiI6ImdVb29zcy9rUkhrZ0JJRE9VTXk2Z1E9PSIsInYiOjEsIml0ZXIiOjEwMDAwLCJrcyI6MTI4LCJ0cyI6NjQsIm1vZGUiOiJjY20iLCJhZGF0YSI6IiIsImNpcGhlciI6ImFlcyIsInNhbHQiOiJMTWpQcmVYV0Y4ND0iLCJjdCI6ImEraWtBMGhkMXNCT3JvTktrcHRnSVFoM0k5Vk1XZnd3WDZVUXpRdExqay9ROWRZazBqbEV3NUZKRGFSTXNlZ01vRTJDMnVUUW1JVmFsVFNwMzlrblJkLzRsK3ZFZE9pYmlSNEhCVm1TUHJOM2lWRmw5SW5sTFdMVUlGdjBtb3NOeXhDdjdPMXZmdlIyQjFUWFc1b1E5UjA4SEppZFNBWWNxSHdBMDVpZTVUdE50SVZwSVVsbnpVR012TERSNVhBS0Y1REJKN3JTVzlhbGY0TElHMER0RXNPN2xxc2hsWkxsWUJ3NmVEcHk4WWFFOEFKN1B3dWluS1k5TmhTZlNGT25DVDIvSit1cDRua1FQVzU1cjMxdzRDREN3VDJmSjcyd3grMlVFQkZIWGFJMmhwbE1kTlBuOEYwT2ZqOUlOT2xuNUJyN1BWN0tPcnFRd1pmZzd1VFpEY2RDVDNMSGNydldDUnVUU3cvbXZqYkNkRXpWOG51dExycG82MG05QURvdG9XQ1p6K0FlUUNUTnJhRitNZmRLZEp2ZUdHUEgvK0Z1UmNMQVpWbU1iY1RXS2dBd1NZWkcydXcyOFZUamR4QkFydUk5RmdrNkgyWDB4UWFPRHdYdk1sUHNHVXloWkFQZmd0SlVXSk14Qmt4T0MzYzJFN2ZpWkpPZ2FsQXV3S01LY2hOcnV4akQxSkx2S2hwSHJSODVXVTRPQjhRalgwWlNSVzg9In0='),(12,'Ihor','Siryi','awesomeua11111','for0work0123@gmail.com','$2y$08$NkhTbGJFYzVNOW1zekI4Ve/bVRuM19dSb68kMU.GAC.wtmu90GnyG','11975950',0,'2017-10-17 16:54:46','eyJpdiI6InEzalN4N0R1VzhsNlRCOW4vZk9LY1E9PSIsInYiOjEsIml0ZXIiOjEwMDAwLCJrcyI6MTI4LCJ0cyI6NjQsIm1vZGUiOiJjY20iLCJhZGF0YSI6IiIsImNpcGhlciI6ImFlcyIsInNhbHQiOiIzV2VTQ2d0emgxST0iLCJjdCI6ImNsL0VmMkJXWkVlb0t4QjdjdDJVRXhOck9jMHJQNEZ0S0pndi9ZbEMvb2hXTWh2MTZWMDJKU0JoWW1tc2RBNnkwQ3RzbHY1SnpFLzZuaW9tdEN0enhCT2hKY1lJN3AzZG1UU2FwVXpXbUZ2blU3N055VjV3eU0zVUxPRW5NR1BaK0hnK1QvOW1xR05hZEs0VVlvcCtJbEYxSkxPbE9OaEtCOCtCd0tjTGx5U3lhdGVaNHpzeUNDSzlIa1dnNXFycWt1dlVDUjExQlBKd1lqWitlcWhDYlpuVWJQUENncVhzV2g0T2VzVDE2Q1p2eFg5aUJ1L3BPbTlnUm5IWkF0eWpxbmR3dTJaVms1ZnNSVHErYXpCbXRDWHBQQm56bkZORGxJaXgwczIxaUs5b2I3SWkzUWNXdnkyVGkzUllpR25jd3pYNGp0ajhaTUdFelY4RW1ob205M2RBZlRXVFFVVCtIczBxdm45NEdLMU5mZVFud0NGSVZrVzlJMkI1cXNNTHA2Mzd1T2liRmk3bHY0NjRka041TWtxa09NcjJwb1JwdTBEWStuYmVlS0tNNzZmVnNVUzkvelcxdTNuTk5tRFM3UHVSa0xmL25peHVEaklpTnJzbUpwbmhPZmRNSUNmOVBVRUR3TS90dzZsRkhwakMvakNCNUdLd0sxUVZsYjM0MjcxMm9mVTdDYUZWTVl1U0xKdz0ifQ=='),(13,'Ihor','Siryi','awesomeua123','for0work1230@gmail.com','$2y$08$dG8vODNIUkpyREN3THJSMuFLfcEgwLlZbTkfqL711GN56tXbITrTG','37287639',0,'2017-10-17 16:56:12','eyJpdiI6InNmZ29QcGVrRXdCVklhYmxLUW95cVE9PSIsInYiOjEsIml0ZXIiOjEwMDAwLCJrcyI6MTI4LCJ0cyI6NjQsIm1vZGUiOiJjY20iLCJhZGF0YSI6IiIsImNpcGhlciI6ImFlcyIsInNhbHQiOiI3eDZ0NjlTWGtjWT0iLCJjdCI6InVGVlJsV3dlbXB0R1FmU0U0T2huOGNyMmNFenFyeWVjbW1hZys5TnR0cDRXMG52S0htS0JCbXhZUHUrS0swWVUrb0duK3laMW9QcU5USHVPclRnUmZocUpYSklFcW9SWW1pVzBBazlhZVVnZ0x5c2xuR1BnWmUwN2Myd05NUFU3WFpsSE1yREhHOGlhK1ZEYmJJeGNndHlwdzRNSjZZQUR5Q2tWSkxWdzZVTWVac2lIemRES0UzZnJlcWRaOXVXQjJ3WDRhd01kT05acjNJTjR5bUFKL3dOejh0WkdHRGFMREJCWGgweXVvRm4wcm9HZnhPVmoyT2VsOVpwRU5LL0ZUWFdUOXVWMjZUZ3YxdUFyNFR2SS96UklRRUpYZzBaQTZsUVlGcnVNdVJoOFloVHlzRDhEQW9NeC9FdG1YUlJPUUFLblNNcmdXaU5GVFhqazlIaklFWWZVOUNsYzV4QUxCeVMyT0lUV09BSWI5WWJoWlVsQ0R4S3I5NUMvM1Y0RmNUZW5KdEoyUEcveUFlZnJBalRwdCs0Yk9OY25GbFJQN0VtcitDNFk3MXZuTUZQZHhhbnU5N1Z1dzBuN05FdTRSY2xwUnhBeWlJVXl6ZVFQWDZxMlJhUlNORFpuVUxOSUFSMmxJRVdORkwwdVp1UjVjSmNhVUh3TlczYzZ2VFhPQ01HTERDT0x2RThTWUUxSHRHKzRzQT09In0='),(14,'Ihor','Siryi','awesomeua545','for0wo2355rk0@gmail.com','$2y$08$ZEdkWGZaSWpZa0lkOThjdeags1Z5oW7CDAvnw5kC.UqMcHcX0YLWO','79850771',1,'2017-10-17 16:58:07','eyJpdiI6IlljR2FxNFJKZ3plZldMN2UrVFlPNWc9PSIsInYiOjEsIml0ZXIiOjEwMDAwLCJrcyI6MTI4LCJ0cyI6NjQsIm1vZGUiOiJjY20iLCJhZGF0YSI6IiIsImNpcGhlciI6ImFlcyIsInNhbHQiOiJVSmtiaGRZUUR0ST0iLCJjdCI6IjZoMGJLN0V2N0ZaS3FzK1MwRzRnRCtJQnM3RStnVnJTdG96QkhlYUdIQWtjRHVLek1DZkpHRHhTTTVKZ1RtMjdTeWk5blhaUGlZVFc5RE1XR2p1Yk16T1BIY01yTkVuK1NPWGRmV1FKaEhWMDI3Wk84ZFJRUklUZEtNNzJUcUxheVh3UTZ4WDlmcWE4SWtPWmRRVkFqbDlnb1QxQ2xqTjBPQzNKbEpGMG9YVUVkTlJnNEdoRXFDVlZOMEFYQVZhOVZiS3F3Z1J1K2IySTFBaTRBTE81MEtnTDhlVkNncU12cDluSHNncENRdEJpdXV2eUtveWlvaGw2eEtmU09GaHIrTWpIQktXWGV2akxPT1VmbHVCZERjMml2TXRiL29oTUFYd2dWOXBweDFhUG9VcjVmMDB6U05qWmJyRFFvc25zc00zNGFveFpxbWNiRGpVMUlPZWI2a0g5RzhKdytlUTAxaS9sWHNhR0ZSaGxEemIydUxPemV3REdhVVRvWGFaRjVHdDEya2NESXFLMEUvcytqdnJDTkFsRlQ0OFhsVnV2MWRBc0ZEanU2bTcxRm9uRUpQM002MjZQbGl6dmcwdVRMMTVMOFJwc3hGL0IzSm9NQXBuYmtIVUM0blgvc3M1aTB3TzhtTURkd2dhV2loeGVlNGpzSHBGbTlxUCtMRkp2RUhCbDlXRklJNENWcDlBTm01Z0Nyby9yIn0='),(15,'test','test','test1','1test@test.com','$2y$08$dFdaU3drbGtWQjJORHJ6M.vd4IJtuUW.lBTKWz6ggi9oaRse2GF8m','68807318',1,'2017-10-18 06:53:28','teststsdfgbcdghfgh'),(16,'test','test','test2','test2@test.com','$2y$08$a0ZabWdhMnphektQc1ZQWeTMlRR7FubY6XhCiCZTasjSFbwR6gLQS','29252530',0,'2017-10-18 07:43:27','teststsdfgbcdghfgh'),(17,'test','test','test3','test3@test.com','$2y$08$bHNZOXV0K3g2aXdSZUY1TO672O6dDBeH6kH/S2NbQhnsqDOQOZwT2','81727916',1,'2017-10-18 08:23:04','teststsdfgbcdghfgh'),(18,'Ihor','Siryi','client_test','xudixupod@p33.org','$2y$08$bnlabE5YUlg1WDZ1MUhpUuHAhYR.rK.l9qSYBkYDA92wAu4nnlVsG','96401330',1,'2017-10-20 06:50:58','eyJpdiI6IkVoMDN5Znk4aVJrZ2t6Mkdzdk1yMFE9PSIsInYiOjEsIml0ZXIiOjEwMDAwLCJrcyI6MTI4LCJ0cyI6NjQsIm1vZGUiOiJjY20iLCJhZGF0YSI6IiIsImNpcGhlciI6ImFlcyIsInNhbHQiOiJSY3JSa0dBUGdzZz0iLCJjdCI6IktaU0RISTF4eUQ0V0R5V1dnSlVPMFRjUzlYWjBZelRiazg3dGxFcy9odjg1MmE1UjJFQ1llKzBRTFdZbkl0NkhSa3dwSWJWSitvYThZeWx4NjlPbElCY1VWTjlLUmIySnhBZk0vRWFNZm1iMHFkUGd6RkFscVBmU01OK3MwV2tKd3ZXaVA5b1ZSREVqa29NWi9mMERTWEpWUlczdE1DMnVscDJKekVlM1RwZURGYXhSREJMVWd4RjkwOG1oRG5qTUZJOTRSZFJ2dkpNbFdDUTVaUTRaS0tteWlCQTlQRTNoRno0cHhINEJDYkI0MU1GbkI5ZHYvaEZoL2dzMU80aytLOHBIUVVTa3RmZ1ZIWitoQmVhdHMxOHhjNGx2VjNWcThjQ21PMUJPaTVyNU9EQ1RHcGxGVHpUZFB0dFRHK3BmYmt2NTArZzI0RVFUZzJLcHpEMk1rVk4vME5lU0tkdmlwNzVJNzZUL08waFJxR3NnOE5rTkprV2J4dS8zdW5zWkFZcFJMQkk1VHM2bERXdmZVMjhac05qd0F2K1FXNVFwZHhXM1JXQVJ4UnpmSUFzcUdqTlRCU050R1VTS1ZnNEdpNjBKQW1GY2IydEJQU0RvY2pxWDBHL1kvK3ZVZE9NcDltazhFL0FMejVPcEt3SDZNeXpHZGFsWjJCUEJyMUV5SGl3MWxjS2gydnVaa0lRRyJ9'),(19,'Ihor','Siryi','yumono','yumono@p33.org','$2y$08$aFVmaW5zMXNwdnBwN0YydOw/zH7R0KDi4Phn8MDAqoM4Oi.BAu5fG','85839071',0,'2017-10-20 14:19:39','eyJpdiI6ImhsVVlqUnNJSjB0bU12MEpzc2QrUnc9PSIsInYiOjEsIml0ZXIiOjEwMDAwLCJrcyI6MTI4LCJ0cyI6NjQsIm1vZGUiOiJjY20iLCJhZGF0YSI6IiIsImNpcGhlciI6ImFlcyIsInNhbHQiOiJPZHpPdVpkRTF3ST0iLCJjdCI6InNEWk9oc3phZXFiNkdXb1hrektnT01IUzJTeHlsNjJJb2s4Q0RRRVFzRFIvOVd0dVEwS2tSRncyS0VYV0h4RGNXV2ZrZ1d0R3p4ZTQrT2xqcGIrMWpHb09tN2pIcE9KZlMrMGxNMVRmdnl0RHVGR2ZucWxqQmltSFlrUzdZQnV1YmFtOWtxRHlWN2JWQUpRcUgyWFdlbjhWbk1Ybi9GVEMxYkszZENuWG1OeHpveWtaelpDMk8yOW9ZOFc2azNSMHV5eTQwZW9yMXk2VEs5REhGVGpZekk1UFZUazdiQ2FhVmpmM2sweDMreDhKYUk1TXRGRzVkV0tvUERwR290R1d4SFVoMEdNWlhRODQ2R3dheEI0ano2R242Wm9jT0FkNExwYzFIMVhCU1BQeUE0Sk1ZQ2tUOXhtVVJGcDMyK3JWV1N1OVVXUUtyNGNBNXd4eGNLUVE1eGF5RHhtNmcxWlI5Sm1HUmNOYUdUbTF6Z1dPMW02SnJYWHJVQTg2VXo5eE9XTUxPVkRXRnJkbEpRTlB0Ny9QWDh6VVg2RElHM1hpNDNWT3l2MWRudGlmWUVOUXZJK3E2aXhtTW9WLytxSlh4UGF2TUw2K0xlMjBEUDN3dmwxR1ZsK1Rlb2x3dlV1Q0hZVzd4c3AySmZQcU5iZ0V4b1AzcUJDcXNiVlgwNGFDU01wK2czTTN4MWY1dGFTN2hiSDhZUWU1ckdTQ09RPT0ifQ=='),(20,'Ihor','Siryi','rubu','rubu@p33.org','$2y$08$YmRIdmZjSHVDMk1ZQm1hTOQAL3v5RBHTURWcD4Wp3OH56y6hbDzkq','66832277',1,'2017-10-20 14:21:36','eyJpdiI6InR0TGRFMXNVbnRvdk0wbWprWDZBYlE9PSIsInYiOjEsIml0ZXIiOjEwMDAwLCJrcyI6MTI4LCJ0cyI6NjQsIm1vZGUiOiJjY20iLCJhZGF0YSI6IiIsImNpcGhlciI6ImFlcyIsInNhbHQiOiI3VzY4RjBQRHV0TT0iLCJjdCI6ImFJdkxqRjVBTzRIQ1NNRXNiVHNhL1h1NTJhNDVsN0FTbG5UVFJmaWdZQTQ5K1dsRS94R21sVXpvSDlGemxVSkVxNmVrV3J2TEh5REJRMnhHT0FiMnhLbmtrZjNLQmt1OHFmblVua1BKamlNV1hCMkZFU29yejh3WUJHUnRiRjhhVGZRbjVWRjFZNHNMNTNKbSsxaEFKOVJORUhKQzBrQ29wN1FVRS9hRW1WdkRlNmpEbENNTW54UmsrOHVFM1lIdW1rN1BxRkpDYmdudjgzMktEQzlmZCs5b09mU1lqMi84WS9OMDN4WWQwdWV0NlYxVjhjd1NmRmpHQjg1K1ZDUm5SQmZqcXgwdjNsN0FSN0JqQk9QcXVaY0FiTkhxMk9uRjVOVTgrMFlncUtkd3o5Z2U5MW5SL0JSLzVyY3dObUw3L0l1UkhhTHE1M01LanROMVp0VFlhSURUN0ExdU1jNnpKaDZGMEJxRmVWN2FTOGpBTDZDbEFtQkR1U25jQ2dLVUlJb1Azczd5czQ2Y0xURWxHU251RUxBK2lNRlFha3NKVFQ3cXYzK0gza1gwVTNlbUlPTThLZE5OR25yTXZEdUZtSUpQV2FpUGdmODkyQmlGcTNmNWhnTlpjNFZNMzNDSDIxQWRkaGY3bzJxWTRmUDJmREl4cXA0N2FqOHQ3MXYrY1lFb29ncFJScTMvdncreTRTaC9DcVJmSFo4MXhoVT0ifQ=='),(21,'Ihor','Siryi','joboyina','joboyina@p33.org','$2y$08$MDJGRFFxb3VBMjRTMnBSbOJsGYcnwwMq.XEJLwcWSHjoMMULFVeqS','24235025',1,'2017-10-20 14:30:32','eyJpdiI6IlJpaysxNkRTN1hLbXU2Uk9SZmtVN2c9PSIsInYiOjEsIml0ZXIiOjEwMDAwLCJrcyI6MTI4LCJ0cyI6NjQsIm1vZGUiOiJjY20iLCJhZGF0YSI6IiIsImNpcGhlciI6ImFlcyIsInNhbHQiOiJqeHBxY3YvUmVUQT0iLCJjdCI6Imd4ZW1ZK2dCOGFXaGVoY1BqaGJzKzNYWGU2NkVWZ1BQVjBlekhUUzExZlhxL1hXWE13Uk9UUTJUL0p6WlZCaXFRbCswNStqZTFGMVVKZ3gwN2tOSXlUVU1EWDRqVHhqVVVDWERTbFdmanVySkx1Mi9DMEVLOHVlWHk3c3hlaUZxK2ZqS1hMNyswQzE4NGVnWkpTMFB0cGJIVzZ4ZFVhMHhOQ1RoWWg5ZzJ0NjVyOU4zK3FwRk5uemNSbHhZZjduaWxhTG5DYlpNR2ZIWEZwcU11NkNpTm9vQTJnYnc0NkhUejBKVTh5SjFJTGxiS0drSDgyTERNaEpOZjZ3KzgzakZZU3hmaFRBWUJrNmRMMDlNbUs4S05CVHdnRnRvRThtU3Z6dkNJNS9MSWVUanZYc0YxYjRXU2VhejFTek82N0FYMFpmYVNqcmN2VVU2Yk5aM1p1L0pWNUZ6R0dkenYvRXR5cEFOUjArSjZRSEh2OGRweE4rZ1VaeEQwSERRSVVHdUZsTUFUdm41NExNK1BrNXBIZkFGSVJCaWQzbi9MSDZVT2s1OVZyTHhPN3pucE5hY2puZzV1cVB2WEwrdld2T0ZuRzRMc05IV0pxOUtBMHAzckRmN1BXN1pzNUsyQWdGY1h3R1JTYnIxRGJrL05SeFVLUFJ5ZDJLMmNJa09HTCtjbDZNcjZ6dFFEUEZzWkR3bFdwZ0ErRHdUTVE9PSJ9');
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
INSERT INTO `attachments` VALUES (1,42,'attic.txt','/files/project_attachments/k0ytyyD5At5nqnjI_attic.txt'),(2,42,'todo.txt','/files/project_attachments/iXQDFzIISbKZNJ5S_todo.txt'),(3,43,'copy.txt','/files/project_attachments/Ivv31bZb44GWDuGp_copy.txt'),(4,43,'data.jpg','/files/project_attachments/Kpl1O0yNMR9aK8nj_data.jpg'),(5,44,'copy.txt','/files/project_attachments/cxiIY2C/+6azSusu_copy.txt'),(6,44,'data.jpg','/files/project_attachments/ez3S21YPLaDQMCAK_data.jpg');
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
  `cln_description` text,
  PRIMARY KEY (`cln_id`),
  KEY `cln_account_id` (`acc_id`),
  CONSTRAINT `cln_acc__fk` FOREIGN KEY (`acc_id`) REFERENCES `accounts` (`acc_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES (1,15,NULL),(2,16,NULL),(3,17,NULL),(4,18,NULL),(5,19,NULL),(6,20,NULL),(7,21,NULL);
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
  `frl_description` text,
  PRIMARY KEY (`frl_id`),
  KEY `frl_account_id` (`acc_id`),
  CONSTRAINT `frl_acc__fk` FOREIGN KEY (`acc_id`) REFERENCES `accounts` (`acc_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `freelancers`
--

LOCK TABLES `freelancers` WRITE;
/*!40000 ALTER TABLE `freelancers` DISABLE KEYS */;
INSERT INTO `freelancers` VALUES (1,1,NULL),(2,2,NULL),(3,3,NULL),(4,4,NULL),(5,5,NULL),(6,6,NULL),(7,7,NULL),(8,8,NULL),(9,9,NULL),(10,10,NULL),(11,11,NULL),(12,12,NULL),(13,13,NULL),(14,14,NULL);
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
  `prj_title` varchar(255) NOT NULL,
  `prj_description` text NOT NULL,
  `prj_budget` decimal(11,2) NOT NULL,
  `prj_deadline` timestamp NULL DEFAULT NULL,
  `prj_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `prj_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`prj_id`),
  KEY `cln_id` (`cln_id`),
  CONSTRAINT `prj_cln__fk` FOREIGN KEY (`cln_id`) REFERENCES `clients` (`cln_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,1,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 07:52:21',NULL),(2,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 08:22:14',NULL),(3,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 08:23:20',NULL),(4,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 08:34:00',NULL),(5,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 08:38:23',NULL),(6,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 08:39:01',NULL),(7,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 08:41:01',NULL),(8,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 08:47:37',NULL),(9,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 08:49:02',NULL),(10,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 08:49:12',NULL),(11,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 08:49:41',NULL),(12,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 08:50:14',NULL),(13,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 08:50:59',NULL),(14,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 10:07:45',NULL),(15,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 10:25:43',NULL),(16,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 11:50:15',NULL),(17,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 11:51:47',NULL),(18,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 11:53:11',NULL),(19,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 11:53:30',NULL),(20,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 11:53:39',NULL),(21,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 11:53:47',NULL),(22,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 11:53:55',NULL),(23,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 11:54:17',NULL),(24,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 11:57:15',NULL),(25,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 11:58:53',NULL),(26,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 11:59:18',NULL),(27,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 12:00:10',NULL),(28,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 12:08:24',NULL),(29,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 12:16:34',NULL),(30,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 12:19:30',NULL),(31,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 12:20:03',NULL),(32,3,'test','test',100.00,'0000-00-00 00:00:00','2017-10-19 12:27:29',NULL),(33,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 12:31:24',NULL),(34,3,'test','test',100.00,'0000-00-00 00:00:00','2017-10-19 12:47:53',NULL),(35,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 13:02:37',NULL),(36,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 13:03:01',NULL),(37,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 13:05:40',NULL),(38,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 13:17:33',NULL),(39,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 13:59:37',NULL),(40,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 14:00:11',NULL),(41,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 14:01:41',NULL),(42,3,'first','description 1',10000.00,'2017-10-09 00:00:00','2017-10-19 14:04:48',NULL),(43,3,'test','test',100.00,'2017-10-19 00:00:00','2017-10-19 14:33:57',NULL),(44,7,'test','test',100.00,'2017-10-03 00:00:00','2017-10-20 15:05:27',NULL),(45,7,'test2','test2',100.00,'2017-10-01 00:00:00','2017-10-20 15:34:02',NULL);
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
INSERT INTO `projects_freelancers` VALUES (14,1,0,1000,'zxczczczczxc',NULL,'2017-10-20 13:21:30',NULL);
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
INSERT INTO `projects_skills` VALUES (1,1),(2,1),(4,1),(2,14),(4,14);
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
  `text` text NOT NULL,
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
  PRIMARY KEY (`stp_id`),
  KEY `prj_id` (`prj_id`),
  CONSTRAINT `stp_prj__fc` FOREIGN KEY (`prj_id`) REFERENCES `projects` (`prj_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `steps`
--

LOCK TABLES `steps` WRITE;
/*!40000 ALTER TABLE `steps` DISABLE KEYS */;
INSERT INTO `steps` VALUES (1,14,'step1','desc1',50.00),(2,14,'step2','desc2',132.00),(3,15,'step1','desc1',50.00),(4,15,'step2','desc2',132.00),(5,16,'step1','desc1',50.00),(6,16,'step2','desc2',132.00),(7,17,'step1','desc1',50.00),(8,17,'step2','desc2',132.00),(9,18,'step1','desc1',50.00),(10,18,'step2','desc2',132.00),(11,19,'step1','desc1',50.00),(12,19,'step2','desc2',132.00),(13,20,'step1','desc1',50.00),(14,20,'step2','desc2',132.00),(15,21,'step1','desc1',50.00),(16,21,'step2','desc2',132.00),(17,22,'step1','desc1',50.00),(18,22,'step2','desc2',132.00),(19,23,'step1','desc1',50.00),(20,23,'step2','desc2',132.00),(21,24,'step1','desc1',50.00),(22,24,'step2','desc2',132.00),(23,25,'step1','desc1',50.00),(24,25,'step2','desc2',132.00),(25,26,'step1','desc1',50.00),(26,26,'step2','desc2',132.00),(27,27,'step1','desc1',50.00),(28,27,'step2','desc2',132.00),(29,28,'step1','desc1',50.00),(30,28,'step2','desc2',132.00),(31,29,'step1','desc1',50.00),(32,29,'step2','desc2',132.00),(33,30,'step1','desc1',50.00),(34,30,'step2','desc2',132.00),(35,31,'step1','desc1',50.00),(36,31,'step2','desc2',132.00),(37,32,'1','3',2.00),(38,32,'3','5',4.00),(39,33,'step1','desc1',50.00),(40,33,'step2','desc2',132.00),(41,34,'1','1',1.00),(42,35,'step1','desc1',50.00),(43,35,'step2','desc2',132.00),(44,36,'step1','desc1',50.00),(45,36,'step2','desc2',132.00),(46,37,'step1','desc1',50.00),(47,37,'step2','desc2',132.00),(48,38,'step1','desc1',50.00),(49,38,'step2','desc2',132.00),(50,39,'step1','desc1',50.00),(51,39,'step2','desc2',132.00),(52,40,'step1','desc1',50.00),(53,40,'step2','desc2',132.00),(54,41,'step1','desc1',50.00),(55,41,'step2','desc2',132.00),(56,42,'step1','desc1',50.00),(57,42,'step2','desc2',132.00),(58,43,'1','3',2.00),(59,44,'1','3',2.00),(60,45,'1','3',2.00);
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

-- Dump completed on 2017-10-20 18:42:19
