-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: qj_consulting_hrms
-- ------------------------------------------------------
-- Server version	8.0.39

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin_master`
--

DROP TABLE IF EXISTS `admin_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_master` (
  `admin_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(64) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_master`
--

LOCK TABLES `admin_master` WRITE;
/*!40000 ALTER TABLE `admin_master` DISABLE KEYS */;
INSERT INTO `admin_master` VALUES (1,'admin','21232f297a57a5a743894a0e4a801fc3');
/*!40000 ALTER TABLE `admin_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_leave_map`
--

DROP TABLE IF EXISTS `employee_leave_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee_leave_map` (
  `el_id` int NOT NULL AUTO_INCREMENT,
  `emp_id` int NOT NULL,
  `leave_id` int NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `count` int NOT NULL,
  `reason` varchar(512) NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`el_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_leave_map`
--

LOCK TABLES `employee_leave_map` WRITE;
/*!40000 ALTER TABLE `employee_leave_map` DISABLE KEYS */;
INSERT INTO `employee_leave_map` VALUES (1,1,1,'2024-09-25','2024-10-05',10,'Fever',-1),(2,1,1,'2024-10-05','2024-10-10',5,'Trip to Dubai',-1),(3,2,1,'2024-10-04','2024-10-06',2,'H',1);
/*!40000 ALTER TABLE `employee_leave_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_master`
--

DROP TABLE IF EXISTS `employee_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee_master` (
  `emp_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(512) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `pswd_state` tinyint(1) NOT NULL DEFAULT '1',
  `doj` date NOT NULL,
  `dob` date DEFAULT NULL,
  `activity` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_master`
--

LOCK TABLES `employee_master` WRITE;
/*!40000 ALTER TABLE `employee_master` DISABLE KEYS */;
INSERT INTO `employee_master` VALUES (1,'DEMO Test','9876543210','test@gmail.com','83218ac34c1834c26781fe4bde918ee4',1,'2024-10-03','2004-10-07',1),(2,'DD','1234567890','d@d.com','83218ac34c1834c26781fe4bde918ee4',1,'2024-10-12',NULL,1),(3,'Shibam','9875464772','test@gmail.com','83218ac34c1834c26781fe4bde918ee4',1,'2024-09-30',NULL,1);
/*!40000 ALTER TABLE `employee_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leave_master`
--

DROP TABLE IF EXISTS `leave_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `leave_master` (
  `leave_id` int NOT NULL AUTO_INCREMENT,
  `leave_type` varchar(64) NOT NULL,
  `activity` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`leave_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leave_master`
--

LOCK TABLES `leave_master` WRITE;
/*!40000 ALTER TABLE `leave_master` DISABLE KEYS */;
/*!40000 ALTER TABLE `leave_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message_master`
--

DROP TABLE IF EXISTS `message_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `message_master` (
  `msg_id` int NOT NULL AUTO_INCREMENT,
  `emp_id` int NOT NULL,
  `message` varchar(4096) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`msg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message_master`
--

LOCK TABLES `message_master` WRITE;
/*!40000 ALTER TABLE `message_master` DISABLE KEYS */;
INSERT INTO `message_master` VALUES (1,0,'Hi. This is a message to all'),(2,1,'Hi');
/*!40000 ALTER TABLE `message_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_employee_map`
--

DROP TABLE IF EXISTS `project_employee_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_employee_map` (
  `pe_id` int NOT NULL AUTO_INCREMENT,
  `project_id` int NOT NULL,
  `emp_id` int NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`pe_id`),
  KEY `fk` (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_employee_map`
--

LOCK TABLES `project_employee_map` WRITE;
/*!40000 ALTER TABLE `project_employee_map` DISABLE KEYS */;
INSERT INTO `project_employee_map` VALUES (1,1,1,'2024-10-03',NULL),(2,3,1,'2024-10-04',NULL),(3,4,1,'2024-10-04',NULL),(4,4,2,'2024-10-04',NULL),(5,4,3,'2024-10-31',NULL);
/*!40000 ALTER TABLE `project_employee_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_master`
--

DROP TABLE IF EXISTS `project_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_master` (
  `project_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(512) COLLATE utf8mb4_general_ci NOT NULL,
  `activity` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_master`
--

LOCK TABLES `project_master` WRITE;
/*!40000 ALTER TABLE `project_master` DISABLE KEYS */;
INSERT INTO `project_master` VALUES (1,'Nemesis',1),(2,'Spectre',1),(3,'Hydra',1),(4,'ABP App',1);
/*!40000 ALTER TABLE `project_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_task_map`
--

DROP TABLE IF EXISTS `project_task_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_task_map` (
  `pt_id` int NOT NULL,
  `pe_id` int NOT NULL,
  `tst_id` int NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `total` time NOT NULL,
  `date` date NOT NULL,
  `remarks` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`pt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_task_map`
--

LOCK TABLES `project_task_map` WRITE;
/*!40000 ALTER TABLE `project_task_map` DISABLE KEYS */;
INSERT INTO `project_task_map` VALUES (1,1,3,'10:00:00','18:00:00','08:00:00','2024-10-04',''),(2,1,1,'10:00:00','18:00:00','08:00:00','2024-10-04','Developed client-side form with JS validation'),(3,1,2,'10:00:00','18:00:00','08:00:00','2024-10-04','ABC DEFGHIJK LMNOPQRSTU VWXYZ  abcdefgh hello'),(4,1,3,'14:04:00','18:00:00','03:56:00','2024-10-04','Design bug fixed in Figma'),(5,1,2,'10:03:00','18:00:00','07:57:00','2024-10-03',''),(6,1,3,'16:02:00','18:00:00','01:58:00','2024-10-01','Sample remark'),(7,1,4,'14:00:00','15:00:00','01:00:00','2024-10-02',''),(8,2,1,'10:00:00','18:00:00','08:00:00','2024-10-04',''),(9,2,2,'10:00:00','18:00:00','08:00:00','2024-10-04',''),(10,2,3,'10:00:00','18:00:00','08:00:00','2024-10-04','Testing this remarks section'),(11,2,4,'10:00:00','18:00:00','08:00:00','2024-10-04','Testing this form remaks'),(12,2,5,'10:00:00','18:00:00','08:00:00','2024-10-04',''),(13,2,1,'10:00:00','18:00:00','08:00:00','2024-10-03','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce faucibus arcu est, sit amet feugiat diam molestie id. Maecenas sit amet magna sodales, tempus leo ut, ullamcorper augue. Proin blandit eros non leo vulputate, a sollicitudin ipsum blandit. Praesent placerat porta urna, vel mattis odio convallis at. Integer condimentum ac erat in condimentum.'),(14,2,2,'10:00:00','18:00:00','08:00:00','2024-10-03','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce faucibus arcu est, sit amet feugiat diam molestie id. Maecenas sit amet magna sodales, tempus leo ut, ullamcorper augue. Proin blandit eros non leo vulputate, a sollicitudin ipsum blandit.'),(15,2,3,'14:00:00','18:00:00','04:00:00','2024-10-03',''),(16,2,4,'10:00:00','18:00:00','08:00:00','2024-10-03',''),(17,2,5,'10:00:00','18:00:00','08:00:00','2024-10-03',''),(18,1,1,'10:00:00','18:00:00','08:00:00','2024-10-01',''),(19,1,2,'10:00:00','18:00:00','08:00:00','2024-10-01',''),(20,1,3,'10:00:00','18:00:00','08:00:00','2024-10-01','Fusce faucibus arcu est, sit amet feugiat diam molestie id. Maecenas sit amet magna sodales, tempus leo ut, ullamcorper augue. Proin blandit eros non leo vulputate, a sollicitudin ipsum blandit. Praesent placerat porta urna, vel mattis odio convallis at. Integer condimentum ac erat in condimentum.'),(21,1,5,'10:00:00','18:00:00','08:00:00','2024-10-01','consectetur adipiscing elit. Fusce faucibus arcu est, sit amet feugiat diam molestie id. Maecenas sit amet magna sodales, tempus leo ut, ullamcorper augue. Proin blandit eros non leo vulputate, a sollicitudin ipsum blandit. Praesent placerat porta urna, vel mattis odio convallis at. Integer condimentum ac erat in condimentum.'),(22,3,1,'10:00:00','18:00:00','08:00:00','2024-10-04',''),(23,3,2,'10:00:00','18:00:00','08:00:00','2024-10-04',''),(24,3,6,'10:00:00','18:00:00','08:00:00','2024-10-04',''),(25,3,3,'10:00:00','18:00:00','08:00:00','2024-10-04',''),(26,3,7,'10:00:00','18:00:00','08:00:00','2024-10-04',''),(27,3,4,'10:00:00','18:00:00','08:00:00','2024-10-04',''),(28,3,5,'12:00:00','18:00:00','06:00:00','2024-10-04',''),(29,3,8,'13:00:00','16:00:00','03:00:00','2024-10-04',''),(30,3,1,'10:00:00','11:00:00','01:00:00','2024-10-03',''),(31,3,6,'16:00:00','18:00:00','02:00:00','2024-10-01','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce faucibus arcu est, sit amet feugiat diam molestie id. Maecenas sit amet magna sodales, tempus leo ut, ullamcorper augue. Proin blandit eros non leo vulputate, a sollicitudin ipsum blandit. Praesent placerat porta urna, vel mattis odio convallis at. Integer condimentum ac erat in condimentum.'),(32,1,13,'10:00:00','18:00:00','08:00:00','2024-10-04',''),(33,2,11,'10:00:00','18:00:00','08:00:00','2024-10-04',''),(34,1,3,'10:00:00','18:00:00','08:00:00','2024-09-30',''),(35,2,3,'10:00:00','18:00:00','08:00:00','2024-08-06',''),(36,4,7,'14:05:00','18:00:00','03:55:00','2024-10-04','This is other user'),(37,4,6,'10:00:00','18:00:00','08:00:00','2024-10-03',''),(38,4,5,'10:00:00','18:00:00','08:00:00','2024-09-23','Testing complete'),(39,1,7,'10:00:00','18:00:00','08:00:00','2024-10-31',''),(40,1,1,'10:00:00','13:00:00','03:00:00','2024-10-31',''),(41,5,7,'10:00:00','18:00:00','08:00:00','2024-10-31','');
/*!40000 ALTER TABLE `project_task_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_task_map_temp`
--

DROP TABLE IF EXISTS `project_task_map_temp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_task_map_temp` (
  `pt_id` int NOT NULL AUTO_INCREMENT,
  `pe_id` int NOT NULL,
  `tst_id` int NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `total` time NOT NULL,
  `date` date NOT NULL,
  `remarks` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`pt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_task_map_temp`
--

LOCK TABLES `project_task_map_temp` WRITE;
/*!40000 ALTER TABLE `project_task_map_temp` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_task_map_temp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_task_master`
--

DROP TABLE IF EXISTS `sub_task_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sub_task_master` (
  `sub_task_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(1024) NOT NULL,
  `description` varchar(8192) NOT NULL,
  `activity` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`sub_task_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_task_master`
--

LOCK TABLES `sub_task_master` WRITE;
/*!40000 ALTER TABLE `sub_task_master` DISABLE KEYS */;
INSERT INTO `sub_task_master` VALUES (1,'Form Development','Develop or Customize Forms',1),(2,'Report Development','Develop or customize reports',1),(3,'Program/Procedure Development','Develop or customize procedures or programs',1),(4,'Form Testing','To test a given form',1),(5,'UI Testing','',1),(6,'ABP Home Page','',1),(7,'Tata Cliq Dashboard','',1);
/*!40000 ALTER TABLE `sub_task_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_master`
--

DROP TABLE IF EXISTS `task_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `task_master` (
  `task_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(1024) COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(8192) COLLATE utf8mb4_general_ci NOT NULL,
  `activity` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`task_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_master`
--

LOCK TABLES `task_master` WRITE;
/*!40000 ALTER TABLE `task_master` DISABLE KEYS */;
INSERT INTO `task_master` VALUES (1,'Coding','',1),(2,'Designing','To design a given UI',1),(3,'Testing','To test an application/software',1);
/*!40000 ALTER TABLE `task_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_sub_task_map`
--

DROP TABLE IF EXISTS `task_sub_task_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `task_sub_task_map` (
  `tst_id` int NOT NULL AUTO_INCREMENT,
  `task_id` int NOT NULL,
  `sub_task_id` int NOT NULL,
  PRIMARY KEY (`tst_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_sub_task_map`
--

LOCK TABLES `task_sub_task_map` WRITE;
/*!40000 ALTER TABLE `task_sub_task_map` DISABLE KEYS */;
INSERT INTO `task_sub_task_map` VALUES (1,1,1),(2,1,3),(3,2,2),(4,3,4),(5,3,5),(6,1,6),(7,2,6),(8,3,6),(9,1,7),(11,3,7),(13,2,7);
/*!40000 ALTER TABLE `task_sub_task_map` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-02 11:49:07
