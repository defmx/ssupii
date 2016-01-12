-- MySQL dump 10.13  Distrib 5.7.10, for osx10.9 (x86_64)
--
-- Host: localhost    Database: upii_bjs
-- ------------------------------------------------------
-- Server version	5.7.10

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
-- Table structure for table `CAlum`
--

DROP TABLE IF EXISTS `CAlum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CAlum` (
  `_id` varchar(20) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `app` varchar(100) DEFAULT NULL,
  `apm` varchar(100) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `bid` int(11) DEFAULT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CAlum`
--

LOCK TABLES `CAlum` WRITE;
/*!40000 ALTER TABLE `CAlum` DISABLE KEYS */;
INSERT INTO `CAlum` VALUES ('2014620017','Diego Alejandro','Alonso','López',1,1),('2014640002','Jose Gabriel','Acosta','Avila',1,1),('2014640015','Luis Antonio','Andrade','Ubaldo',1,3),('2014640018','Alan','Arcos','Castillo',2,4);
/*!40000 ALTER TABLE `CAlum` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CBeca`
--

DROP TABLE IF EXISTS `CBeca`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CBeca` (
  `_id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `amt` decimal(15,2) NOT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CBeca`
--

LOCK TABLES `CBeca` WRITE;
/*!40000 ALTER TABLE `CBeca` DISABLE KEYS */;
INSERT INTO `CBeca` VALUES (1,'Pronabes',8000.00),(2,'Institucional A',8000.00),(3,'Institucional B',8000.00),(4,'Institucional C',8000.00),(5,'h-h',8000.00),(6,'Telmex',8000.00),(7,'IPN',8000.00);
/*!40000 ALTER TABLE `CBeca` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CCarr`
--

DROP TABLE IF EXISTS `CCarr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CCarr` (
  `_id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `tim` int(11) NOT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CCarr`
--

LOCK TABLES `CCarr` WRITE;
/*!40000 ALTER TABLE `CCarr` DISABLE KEYS */;
INSERT INTO `CCarr` VALUES (1,'Ingeniería Telemática',5),(2,'Ingeniería Mecatrónica',5);
/*!40000 ALTER TABLE `CCarr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CConf`
--

DROP TABLE IF EXISTS `CConf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CConf` (
  `_key` varchar(100) NOT NULL,
  `val` varchar(100) NOT NULL,
  PRIMARY KEY (`_key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CConf`
--

LOCK TABLES `CConf` WRITE;
/*!40000 ALTER TABLE `CConf` DISABLE KEYS */;
INSERT INTO `CConf` VALUES ('MAX_YEAR','2016'),('MIN_YEAR','2010'),('SEM_PER_YEAR','2');
/*!40000 ALTER TABLE `CConf` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-01-11 22:10:14
