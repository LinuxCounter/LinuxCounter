-- MySQL dump 10.13  Distrib 5.5.41, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: licotest
-- ------------------------------------------------------
-- Server version	5.5.41-0ubuntu0.14.04.1

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
-- Table structure for table `machines`
--

DROP TABLE IF EXISTS `machines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `machines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `country` int(11) DEFAULT NULL,
  `cpu` int(11) DEFAULT NULL,
  `distribution` int(11) DEFAULT NULL,
  `architecture` int(11) DEFAULT NULL,
  `kernel` int(11) DEFAULT NULL,
  `class` int(11) DEFAULT NULL,
  `purpose` int(11) DEFAULT NULL,
  `updatekey` varchar(48) DEFAULT NULL,
  `hostname` varchar(128) DEFAULT NULL,
  `cores` int(3) DEFAULT NULL,
  `flags` varchar(255) DEFAULT NULL,
  `accounts` int(5) DEFAULT NULL,
  `diskspace` bigint(20) DEFAULT NULL,
  `diskspace_free` bigint(20) DEFAULT NULL,
  `memory` bigint(20) DEFAULT NULL,
  `memory_free` bigint(20) DEFAULT NULL,
  `swap` bigint(20) DEFAULT NULL,
  `swap_free` bigint(20) DEFAULT NULL,
  `distversion` varchar(24) DEFAULT NULL,
  `mailer` varchar(24) DEFAULT NULL,
  `network` varchar(24) DEFAULT NULL,
  `online` tinyint(1) DEFAULT NULL,
  `uptime` int(11) DEFAULT NULL,
  `loadavg` varchar(48) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `country` (`country`),
  KEY `cpu` (`cpu`),
  KEY `distribution` (`distribution`),
  KEY `architecture` (`architecture`),
  KEY `kernel` (`kernel`),
  KEY `class` (`class`),
  KEY `purpose` (`purpose`),
  KEY `key` (`updatekey`),
  KEY `created_at` (`created_at`),
  KEY `online` (`online`),
  KEY `user_online` (`user`,`online`),
  KEY `user_key` (`user`,`updatekey`),
  CONSTRAINT `FK_F1CE8DED5373C966` FOREIGN KEY (`country`) REFERENCES `countries` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_F1CE8DED5DD29AAB` FOREIGN KEY (`kernel`) REFERENCES `kernels` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_F1CE8DED74995EFA` FOREIGN KEY (`architecture`) REFERENCES `architectures` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_F1CE8DED8D93D649` FOREIGN KEY (`user`) REFERENCES `fos_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_F1CE8DEDA4483781` FOREIGN KEY (`distribution`) REFERENCES `distributions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_F1CE8DEDB887B3EB` FOREIGN KEY (`purpose`) REFERENCES `purposes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_F1CE8DEDBA80502E` FOREIGN KEY (`cpu`) REFERENCES `cpus` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_F1CE8DEDED4B199F` FOREIGN KEY (`class`) REFERENCES `classes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-04-22 13:08:34
