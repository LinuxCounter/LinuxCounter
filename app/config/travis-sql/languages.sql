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
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `locale` varchar(7) NOT NULL,
  `country` varchar(7) NOT NULL,
  `language` varchar(128) NOT NULL,
  `active` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `languages`
--

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES (1,'af','af','Afrikaans',1),(2,'am','am','Amharic',1),(3,'ar','ar','Arabic',1),(4,'as','as','Assamese',1),(5,'az','az','Azeri',1),(6,'be','be','Belarusian',1),(7,'bg','bg','Bulgarian',1),(8,'bn','bn','Bengali',1),(9,'bo','bo','Tibetan',1),(10,'bs','bs','Bosnian',1),(11,'ca','ca','Catalan',1),(12,'cs','cs','Czech',1),(13,'cy','cy','Welsh',1),(14,'da','da','Danish',1),(15,'de','de','Deutsch',1),(16,'dv','dv','Divehi; Dhivehi; Maldivian',1),(17,'el','el','Greek',1),(18,'en','en','English',1),(19,'es','es','Spanish',1),(20,'et','et','Estonian',1),(21,'eu','eu','Basque',1),(22,'fa','fa','Farsi - Persian',1),(23,'fi','fi','Finnish',1),(24,'fo','fo','Faroese',1),(25,'fr','fr','French',1),(26,'gd','gd','Gaelic',1),(27,'gl','gl','Galician',1),(28,'gn','gn','Guarani',1),(29,'gu','gu','Gujarati',1),(30,'he','he','Hebrew',1),(31,'hi','hi','Hindi',1),(32,'hr','hr','Croatian',1),(33,'hu','hu','Hungarian',1),(34,'hy','hy','Armenian',1),(35,'id','id','Indonesian',1),(36,'is','is','Icelandic',1),(37,'it','it','Italian',1),(38,'ja','ja','Japanese',1),(39,'ka','ka','Georgian',1),(40,'kk','kk','Kazakh',1),(41,'km','km','Khmer',1),(42,'kn','kn','Kannada',1),(43,'ko','ko','Korean',1),(44,'ks','ks','Kashmiri',1),(45,'la','la','Latin',1),(46,'lo','lo','Lao',1),(47,'lt','lt','Lithuanian',1),(48,'lv','lv','Latvian',1),(49,'mi','mi','Maori',1),(50,'mk','mk','Macedonia',1),(51,'ml','ml','Malayalam',1),(52,'mn','mn','Mongolian',1),(53,'mn','mn','Mongolian',1),(54,'mr','mr','Marathi',1),(55,'ms','ms','Malay',1),(56,'mt','mt','Maltese',1),(57,'my','my','Burmese',1),(58,'nb','nb','Norwegian',1),(59,'ne','ne','Nepali',1),(60,'nl','nl','Dutch',1),(61,'or','or','Oriya',1),(62,'pa','pa','Punjabi',1),(63,'pl','pl','Polish',1),(64,'pt-br','pt','Portuguese - Brazil',1),(65,'pt','pt','Portuguese - Portugal',1),(66,'rm','rm','Raeto-Romance',1),(67,'ro','ro','Romanian',1),(68,'ru','ru','Russian',1),(69,'sa','sa','Sanskrit',1),(70,'sb','sb','Sorbian',1),(71,'sd','sd','Sindhi',1),(72,'si','si','Sinhala; Sinhalese',1),(73,'sk','sk','Slovak',1),(74,'sl','sl','Slovenian',1),(75,'so','so','Somali',1),(76,'sq','sq','Albanian',1),(77,'sr-la','sr','Serbian',1),(78,'sv','sv','Swedish',1),(79,'sw','sw','Swahili',1),(80,'ta','ta','Tamil',1),(81,'te','te','Telugu',1),(82,'tg','tg','Tajik',1),(83,'th','th','Thai',1),(84,'tk','tk','Turkmen',1),(85,'tn','tn','Setsuana',1),(86,'tr','tr','Turkish',1),(87,'ts','ts','Tsonga',1),(88,'tt','tt','Tatar',1),(89,'uk','uk','Ukrainian',1),(90,'ur','ur','Urdu',1),(91,'uz','uz','Uzbek',1),(92,'vi','vi','Vietnamese',1),(93,'xh','xh','Xhosa',1),(94,'yi','yi','Yiddish',1),(95,'zh-cn','zh','Chinese - China',1),(96,'zu','zu','Zulu',1);
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-04-22 13:08:34
