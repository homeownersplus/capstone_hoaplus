-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: pdocrud
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(80) NOT NULL,
  `position` varchar(60) NOT NULL,
  `password` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (7,'Secretary_Vilma','Vilma Sotero','vilmasotero@gmail.com','Secretary','HOASecretary00!'),(8,'Treasurer_Anna','Anna Nga','annanga@gmail.com','Treasurer','HOATreasurer00!'),(9,'HOAStaff_Teena','Teena Lee','teenalee@gmail.com','Treasurer','HOAStaff00!'),(11,'HOAStaff_Veena','Veena Leeta','sinoko@yandex.com','HOA Staff','HOAStaff002!'),(12,'Pres_Aikka','Aikka Sy Bata','aikasybata@gmail.com','President','Preseikka06!!'),(13,'Secretary_Malliey','Mallie Xiea','malliexiea@gmail.com','Secretary','Secretarymallie'),(14,'Secretary_Sunroof','Sun Roof','tamana@yandex.com','Secretary','secrekeah00A!'),(15,'TataMc','Tata McRae','sherietionco@gmail.com','Treasurer','tataMcrae00!!'),(16,'ChescaLeel','Chesca Lee','jhasjaneestacio@gmail.com','Treasurer','jhasEst2317!!');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbladmin`
--

DROP TABLE IF EXISTS `tbladmin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbladmin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `admin_name` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbladmin`
--

LOCK TABLES `tbladmin` WRITE;
/*!40000 ALTER TABLE `tbladmin` DISABLE KEYS */;
INSERT INTO `tbladmin` VALUES (1,'admin','admin','Andres P. Jario');
/*!40000 ALTER TABLE `tbladmin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblamenities`
--

DROP TABLE IF EXISTS `tblamenities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblamenities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amename` varchar(150) NOT NULL,
  `amendesc` int(11) NOT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Photo` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblamenities`
--

LOCK TABLES `tblamenities` WRITE;
/*!40000 ALTER TABLE `tblamenities` DISABLE KEYS */;
INSERT INTO `tblamenities` VALUES (5,'Paw Park',0,'2022-10-24 05:39:48','166658998853860494463562524a1e4a'),(6,'Swimming Pool',0,'2022-10-24 07:53:25','1666598005211761023563564475a27b5'),(7,'Event\'s Place',0,'2022-10-24 07:57:35','16665982557237938546356456f69a5a'),(8,'Basketball Court',0,'2022-10-24 07:59:13','16665983531776356757635645d1b14d4'),(9,'Adult Pool',0,'2022-11-03 14:25:03','16674855037689296776363cf3fbe436');
/*!40000 ALTER TABLE `tblamenities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblusers`
--

DROP TABLE IF EXISTS `tblusers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ptitle` varchar(150) NOT NULL,
  `pcontent` varchar(10000) NOT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Photo` varchar(250) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblusers`
--

LOCK TABLES `tblusers` WRITE;
/*!40000 ALTER TABLE `tblusers` DISABLE KEYS */;
INSERT INTO `tblusers` VALUES (89,'Free Badminton Class','   Para sa lahat ng nais makiisa sa libreng badminton class ay maaring mag fill - out sa form na ito: \r\n\r\nhttps://forms.gle/Kq8gQ8U2CHqHHJJt9\r\n\r\nIto ay bukas sa lahat ng kabataan na ang edad ay walong taong gulang hanggang labing-siyam taong gulang. \r\n\r\n','2022-11-03 14:20:37','16666927228774661126357b6726e28e',0),(91,'SSS on Wheelsss 101','      Lorem Ipsum','2022-11-03 16:51:19','16674911373582331546363e5413c514',0),(93,'Garbage Collection','  lorem ipsum amet dolor','2022-11-03 14:20:55','166669261116848479946357b603d790b',0),(100,'Swab Cab ni Leni',' cgdfgryt','2022-11-03 17:16:36','166749579620436768666363f7748ab35',0),(102,'Adult Pool Now Open! G na!','  frtytyujtyuj','2022-11-04 15:34:34','1667576019179019347636530d3b99bd',0),(103,'Free Coffee on World Coffee Day!','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Mi sit amet mauris commodo quis imperdiet massa tincidunt nunc. At consectetur lorem donec massa sapien faucibus et molestie. Quis varius quam quisque id diam vel. Lobortis scelerisque fermentum dui faucibus in ornare quam viverra orci. Vel risus commodo viverra maecenas accumsan lacus vel. Placerat duis ultricies lacus sed turpis tincidunt id aliquet risus. ','2022-11-05 02:14:57','16675767512035309332636533af12b1d',0),(104,'Poste','chambe chambbe','2022-11-11 04:50:39','16681317261978518306636dab8eb275d',1),(105,'Valid Post','asdsadadadadadad','2022-11-13 14:03:16','166834819614135004226370f9242b499',0);
/*!40000 ALTER TABLE `tblusers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(250) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `phase_lot_block` varchar(500) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `fullname` varchar(250) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'user','user','user@example.com','87000','Phase 1, Block 2, Lot 3','143','Lebron James','12483690996376317d9f4f66376317d9f4f9.jpg','2022-11-17 09:39:05');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-11-17 22:21:03
