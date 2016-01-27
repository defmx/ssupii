-- MySQL dump 10.16  Distrib 10.1.9-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: upii_bjs
-- ------------------------------------------------------
-- Server version	10.1.9-MariaDB

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
-- Table structure for table `calum`
--

DROP TABLE IF EXISTS `calum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calum` (
  `_id` varchar(20) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `app` varchar(100) DEFAULT NULL,
  `apm` varchar(100) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `bid` int(11) DEFAULT NULL,
  `sem` int(11) DEFAULT NULL,
  `yr` int(11) DEFAULT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calum`
--

LOCK TABLES `calum` WRITE;
/*!40000 ALTER TABLE `calum` DISABLE KEYS */;
INSERT INTO `calum` VALUES ('01ffd178-bf5b-11e5-8','Jorge','Alva Félix','Díaz',2,-1,2,2014),('0d22fcdd-bf6d-11e5-8','Jose Mauro','Cortés','Herrera',2,-1,2,2014),('10891b6a-bf59-11e5-8','Sergio Eladio','Aburto','Mastache',2,-1,2,2014),('2013300121','Luis Edgar','Chaparro','Reyes',2,9,2,2014),('2014300289','Alan','Cazares','Leyva',2,4,2,2014),('2014360058','Fernando','Arias','Guarnero',2,4,2,2014),('2014360131','Alan Edu','Carro','Urbano',3,4,2,2014),('2014360257','Flavio','Flores','Escalante',2,4,2,2014),('2014361309','Alexis','Corte','Lerma',2,5,2,2014),('2014620017','Diego Alejandro','Alonso','López',2,4,2,2014),('2014640002','Jose Gabriel','Acosta','Avila',1,4,2,2014),('2014640015','Luis Antonio','Andrade','Ubaldo',1,3,2,2015),('2014640018','Alan','Arcos','Castillo',2,9,2,2015),('2014640024','Daniel','Barrera','Rocha',2,4,2,2014),('2014640028','Segio','Benites','Garcilazo',1,4,2,2014),('2014640038','Fernando Alonso','Calva','Sánchez',2,4,2,2014),('2014640043','César Iván','Cariño','Díaz',3,9,2,2014),('2014640067','Eduardo','Díaz','Blancas',2,4,2,2014),('2014640304','Jorge Armando','Ángeles','Pacheco',2,4,2,2014),('2014640308','Edgar Iván','Bautista','Vigil',2,4,2,2014),('2052b134-bf5c-11e5-8','Edgar Eduardo','Arias','Vargas',1,-1,2,2014),('260ecb81-bf6e-11e5-8','Luis Enrique','Farías','Quiroz',1,-1,2,2014),('27b8f7f1-bf68-11e5-8','Ana Karen','Carrasco','Martín',2,-1,2,2014),('27fdbb00-bf6d-11e5-8','Jose Alonso','Coxtinica','Téllez',2,-1,2,2014),('2e4ffa96-bf5c-11e5-8','Luis Enrique','Avilés','Kim',2,-1,2,2014),('3193b6ad-bf69-11e5-8','Carlos Daniel','Castillo','Fernández',1,-1,2,2014),('325a03f0-bf6d-11e5-8','Jose Alberto','Cruz','Varela',1,-1,2,2014),('335d2955-bf68-11e5-8','Raymundo','Carrasco','Rodríguez',2,-1,2,2014),('35b2f7be-bf6e-11e5-8','Abril Evangelina','Fierro','De La Rosa',1,-1,2,2014),('368192f0-bf5b-11e5-8','Yessica Noemi','Álvarez','Quintana',3,-1,2,2014),('3dc7d628-bf69-11e5-8','Rodrigo','Castillo','Fonseca',2,-1,2,2014),('42d0d947-bf6d-11e5-8','Cristian Arturo','Cuéllar','Cienfuegos',2,-1,2,2014),('43861590-bf6e-11e5-8','Carlos','Flores','Alvarado',2,-1,2,2014),('4d6581f1-bf5c-11e5-8','Carlos Eduardo','Bautista','Cruz',1,-1,2,2014),('4ebc57b4-bf6d-11e5-8','Adrian','Curiel','Castillo',1,-1,2,2014),('5159503f-bf66-11e5-8','Daniel Alejandro','Bravo','Jaimes',1,-1,2,2014),('586b88d3-bf68-11e5-8','Carlos Saúl','Carrillo','Cazares',2,-1,2,2014),('58e2475e-bf6d-11e5-8','Roberto Eduardo','Custodio','González',1,-1,2,2014),('59d115e0-bf66-11e5-8','Oscar','Briseño','Salmeron',2,-1,2,2014),('628ec5bc-bf66-11e5-8','Aldo Misael','Bucio','Ibarra',2,-1,2,2014),('635c8d1b-bf6d-11e5-8','Ulises','Dávila','García',3,-1,2,2014),('6e9670fb-bf6c-11e5-8','Guillermo Daniel','Cervantes','Alba',2,-1,2,2014),('7082f5d5-bf66-11e5-8','Saul Guillermo','Bustamante','Martínez',3,-1,2,2014),('7139ffda-bf6d-11e5-8','Arturo Abiran','De Leon','Luna',3,-1,2,2014),('774b0b4c-bf68-11e5-8','Luis Ioan','Castellanos','Ambriz',1,-1,2,2014),('7a0aaad8-bf5c-11e5-8','Gael','Bedolla','Cabello',2,-1,2,2014),('7b5a92f7-bf6c-11e5-8','Gustavo Manuel','César','Ortiz',2,-1,2,2014),('7fd3372a-bf5b-11e5-8','Fernando Daniel','Ángeles','Reyes',2,-1,2,2014),('8a02b4e1-bf6d-11e5-8','Felipe De Jesús','De Los Santos','Cigarroa',1,-1,2,2014),('8e80e192-bf6e-11e5-8','Miguel Angel','Flores','Carrasco',2,-1,2,2014),('8ea7a694-bf5b-11e5-8','Daniel Isai','Aparicio','Martínez',2,-1,2,2014),('956f4f39-bf69-11e5-8','Luis Miguel','Cazares','Vásquez',2,-1,2,2014),('96d7e4ff-bf6d-11e5-8','Elias De Jesús','Delgado','Aguilar',3,-1,2,2014),('a3559258-bf6c-11e5-8','Giovanna Charlene','Chichia','Cerda',2,-1,2,2014),('a67afa63-bf6d-11e5-8','Alfonso Alberto','Delgado','Reyes',2,-1,2,2014),('ab01ccf1-bf6e-11e5-8','César Augusto','Flores','Cruz',2,-1,2,2014),('ac31c0c0-bf5c-11e5-8','Juan José','Benavente','Vázquez',2,-1,2,2014),('ad44c814-bf69-11e5-8','Daniel','Cedillo','Maldonado',1,-1,2,2014),('afeebeb1-bf6c-11e5-8','Gibran','Coahuilazo','Cosme',1,-1,2,2014),('b09a9e53-bf6d-11e5-8','Carlos Alberto','Díaz','Aldana',3,-1,2,2014),('c05ad097-bf6c-11e5-8','Jesus Manuel','Colin','Torres',2,-1,2,2014),('c192d32a-bf5a-11e5-8','Juan Carlos','Aguilar','Soriano',1,-1,2,2014),('c4344d96-bf68-11e5-8','Carlos Armando','Castillo','Díaz',3,-1,2,2014),('c8b1f773-bf6e-11e5-8','Manuel Caleb','Flores','Hernández',2,-1,2,2014),('cb15e629-bf6d-11e5-8','Bryan Uriel','España','Pérez',2,-1,2,2014),('cf10bdce-bf67-11e5-8','Ricardo Abraham','Carvez','López',2,-1,2,2014),('d6e1b8ca-bf6d-11e5-8','Oscar Manuel','Espitia','Hernández',3,-1,2,2014),('d767a794-bf59-11e5-8','Ricardo Moisés','Aguilar','Hernández',2,-1,2,2014),('df00cfdd-bf5a-11e5-8','Diego','Alonso','Del Río',2,-1,2,2014),('df9775f2-bf6c-11e5-8','Armando Zenif','Contreras','Castillo',2,-1,2,2014),('e0f73d6f-bf67-11e5-8','Roberto','Cardona','Díez de Sollano',2,-1,2,2014);
/*!40000 ALTER TABLE `calum` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cbeca`
--

DROP TABLE IF EXISTS `cbeca`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cbeca` (
  `_id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `amt` decimal(15,2) NOT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cbeca`
--

LOCK TABLES `cbeca` WRITE;
/*!40000 ALTER TABLE `cbeca` DISABLE KEYS */;
INSERT INTO `cbeca` VALUES (-1,'(Sin beca)',0.00),(1,'Institucional A',8000.00),(2,'Institucional B',8000.00),(3,'Institucional C',8000.00),(4,'Pronabes',8000.00),(5,'Bécalos',8000.00),(6,'h-h',8000.00),(7,'Telmex',8000.00),(8,'Alto Rendimiento',8000.00),(9,'Probeup',8000.00);
/*!40000 ALTER TABLE `cbeca` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ccarr`
--

DROP TABLE IF EXISTS `ccarr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ccarr` (
  `_id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `tim` int(11) NOT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ccarr`
--

LOCK TABLES `ccarr` WRITE;
/*!40000 ALTER TABLE `ccarr` DISABLE KEYS */;
INSERT INTO `ccarr` VALUES (1,'Ingeniería Telemática',5),(2,'Ingeniería Mecatrónica',5),(3,'Ingeniería Biónica',5);
/*!40000 ALTER TABLE `ccarr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cconf`
--

DROP TABLE IF EXISTS `cconf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cconf` (
  `_key` varchar(100) NOT NULL,
  `val` varchar(100) NOT NULL,
  PRIMARY KEY (`_key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cconf`
--

LOCK TABLES `cconf` WRITE;
/*!40000 ALTER TABLE `cconf` DISABLE KEYS */;
INSERT INTO `cconf` VALUES ('MAX_YEAR','2016'),('MIN_YEAR','2010'),('SEM_PER_YEAR','2');
/*!40000 ALTER TABLE `cconf` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_fullname` varchar(25) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `user_status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'jojo','jojojo','jojojo',1),(2,'koko','kokoko','kokokoko',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-01-27  1:05:29
