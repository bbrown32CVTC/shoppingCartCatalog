CREATE DATABASE  IF NOT EXISTS `coolcat1` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */;
USE `coolcat1`;
-- MySQL dump 10.13  Distrib 8.0.15, for Win64 (x86_64)
--
-- Host: localhost    Database: coolcat1
-- ------------------------------------------------------
-- Server version	8.0.15

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8 ;
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
 SET character_set_client = utf8mb4 ;
CREATE TABLE `categories` (
  `catid` int(11) NOT NULL AUTO_INCREMENT,
  `catname` char(60) NOT NULL DEFAULT '',
  PRIMARY KEY (`catid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'figures'),(2,'prints'),(3,'scenery');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `products` (
  `prodid` int(11) NOT NULL AUTO_INCREMENT,
  `loc` varchar(255) NOT NULL DEFAULT '',
  `price` float(4,2) NOT NULL DEFAULT '0.00',
  `description` varchar(255) NOT NULL DEFAULT '',
  `category` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`prodid`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'images/figures/bavarianFiring1.png',4.00,'25mm Bavarian Line Infantry Standing Firing - Franco-Prussian War of 1870',1),(2,'images/figures/frenchLineDefending1.png',4.25,'25mm French Line Infantry Defending- Franco-Prussian War of 1870',1),(3,'images/figures/jaegerLoading1.png',4.00,'25mm Prussian Jaeger Loading - Franco-Prussian War of 1870',1),(4,'images/figures/prussianLineDefending1.png',4.50,'25mm Prussian Line Infantry Defending - Franco-Prussian War of 1870',1),(5,'images/figures/zouaveCharging1.png',4.25,'25mm French Zouave Charging - Franco-Prussian War of 1870',1),(6,'images/prints/bavarianBugler.png',12.50,'Bavarian bugler inserted in a logo -circa 1890 - by Ernst Zimmer',2),(7,'images/prints/saarbrucken.png',31.98,'French assault on Saarbrucken - August 2, 1870 - by Alphonse DeNeuville',2),(8,'images/prints/77th_at_GoldenBremme.png',22.00,'The 77th Prussian line regiment at the Golden Bremme - August 6, 1870 - by Carl Rochling',2),(9,'images/prints/artilleryPrussian.png',20.00,'Prussian Artillery in action - August 6, 1870 - by Ernst Zimmer',2),(10,'images/prints/chasseursDeneuville.png',28.00,'Chasseurs a Pied - by Alphonse de Neuville',2),(11,'images/scenery/ArchHeritage1.png',28.75,'Stucco Western European building suitable for the period 1700 - present',3),(12,'images/scenery/waterPump.png',32.00,'Handcrafted water pump',3),(13,'images/scenery/fountainCross.png',17.50,'Handcrafted town square monument with cross',3),(14,'images/scenery/signPost1.png',17.50,'Handcrafted road sign post',3);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-05-02 15:10:57

CREATE USER IF NOT EXISTS
 'itsd'@'localhost' IDENTIFIED WITH mysql_native_password BY 'mysql';
 
GRANT ALL ON coolcat1.* TO 'itsd'@'localhost';
