-- MySQL dump 10.13  Distrib 5.7.16, for Linux (x86_64)
--
-- Host: localhost    Database: linuxcounter
-- ------------------------------------------------------
-- Server version	5.7.16-0ubuntu0.16.04.1

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
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `population` int(11) NOT NULL,
  `machinesnum` int(11) DEFAULT NULL,
  `usersnum` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=233 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (1,'af','Afghanistan',33369945,0,0);
INSERT INTO `countries` VALUES (2,'al','Albania',2903700,0,0);
INSERT INTO `countries` VALUES (3,'dz','Algeria',40375954,0,0);
INSERT INTO `countries` VALUES (4,'as','American Samoa',55602,0,0);
INSERT INTO `countries` VALUES (5,'ad','Andorra',69165,0,0);
INSERT INTO `countries` VALUES (6,'ao','Angola',25830958,0,0);
INSERT INTO `countries` VALUES (7,'ai','Anguilla',14763,0,0);
INSERT INTO `countries` VALUES (8,'ag','Antigua and Barbuda',92738,0,0);
INSERT INTO `countries` VALUES (9,'ar','Argentina',43847277,0,0);
INSERT INTO `countries` VALUES (10,'am','Armenia',3026048,0,0);
INSERT INTO `countries` VALUES (11,'aw','Aruba',104263,0,0);
INSERT INTO `countries` VALUES (12,'au','Australia',24309330,0,0);
INSERT INTO `countries` VALUES (13,'at','Austria',8569633,0,0);
INSERT INTO `countries` VALUES (14,'az','Azerbaijan',9868447,0,0);
INSERT INTO `countries` VALUES (15,'bs','Bahamas',392718,0,0);
INSERT INTO `countries` VALUES (16,'bh','Bahrain',1396829,0,0);
INSERT INTO `countries` VALUES (17,'bd','Bangladesh',162910864,0,0);
INSERT INTO `countries` VALUES (18,'bb','Barbados',285006,0,0);
INSERT INTO `countries` VALUES (19,'by','Belarus',9481521,0,0);
INSERT INTO `countries` VALUES (20,'be','Belgium',11371928,0,0);
INSERT INTO `countries` VALUES (21,'bz','Belize',366942,0,0);
INSERT INTO `countries` VALUES (22,'bj','Benin',11166658,0,0);
INSERT INTO `countries` VALUES (23,'bm','Bermuda',61662,0,0);
INSERT INTO `countries` VALUES (24,'bt','Bhutan',784103,0,0);
INSERT INTO `countries` VALUES (25,'bo','Bolivia',10888402,0,0);
INSERT INTO `countries` VALUES (26,'ba','Bosnia and Herzegovina',3802134,0,0);
INSERT INTO `countries` VALUES (27,'bw','Botswana',2303820,0,0);
INSERT INTO `countries` VALUES (28,'br','Brazil',209567920,0,0);
INSERT INTO `countries` VALUES (29,'vg','Virgin Islands (British)',30659,0,0);
INSERT INTO `countries` VALUES (30,'bn','Brunei',428874,0,0);
INSERT INTO `countries` VALUES (31,'bg','Bulgaria',7097796,0,0);
INSERT INTO `countries` VALUES (32,'bf','Burkina Faso',18633725,0,0);
INSERT INTO `countries` VALUES (33,'bi','Burundi',11552561,0,0);
INSERT INTO `countries` VALUES (34,'cv','Cabo Verde',526993,0,0);
INSERT INTO `countries` VALUES (35,'kh','Cambodia',15827241,0,0);
INSERT INTO `countries` VALUES (36,'cm','Cameroon',23924407,0,0);
INSERT INTO `countries` VALUES (37,'ca','Canada',36286378,0,0);
INSERT INTO `countries` VALUES (38,'ky','Cayman Islands',60764,0,0);
INSERT INTO `countries` VALUES (39,'cf','Central African Republic',4998493,0,0);
INSERT INTO `countries` VALUES (40,'td','Chad',14496739,0,0);
INSERT INTO `countries` VALUES (41,'cl','Chile',18131850,0,0);
INSERT INTO `countries` VALUES (42,'cn','China',1382323332,0,0);
INSERT INTO `countries` VALUES (43,'co','Colombia',48654392,0,0);
INSERT INTO `countries` VALUES (44,'km','Comoros',807118,0,0);
INSERT INTO `countries` VALUES (45,'cg','Congo',4740992,0,0);
INSERT INTO `countries` VALUES (46,'ck','Cook Islands',20948,0,0);
INSERT INTO `countries` VALUES (47,'cr','Costa Rica',4857218,0,0);
INSERT INTO `countries` VALUES (48,'hr','Croatia',4225001,0,0);
INSERT INTO `countries` VALUES (49,'cu','Cuba',11392889,0,0);
INSERT INTO `countries` VALUES (50,'cw','Curacao',158635,0,0);
INSERT INTO `countries` VALUES (51,'cy','Cyprus',1176598,0,0);
INSERT INTO `countries` VALUES (52,'cz','Czech Republic',10548058,0,0);
INSERT INTO `countries` VALUES (53,'ci','Cote d\'Ivoire',23254184,0,0);
INSERT INTO `countries` VALUES (54,'cd','Congo (Democratic Republic of the)',79722624,0,0);
INSERT INTO `countries` VALUES (55,'dk','Denmark',5690750,0,0);
INSERT INTO `countries` VALUES (56,'dj','Djibouti',899598,0,0);
INSERT INTO `countries` VALUES (57,'dm','Dominica',73016,0,0);
INSERT INTO `countries` VALUES (58,'do','Dominican Republic',10648613,0,0);
INSERT INTO `countries` VALUES (59,'ec','Ecuador',16385450,0,0);
INSERT INTO `countries` VALUES (60,'eg','Egypt',93383574,0,0);
INSERT INTO `countries` VALUES (61,'sv','El Salvador',6146419,0,0);
INSERT INTO `countries` VALUES (62,'gq','Equatorial Guinea',869587,0,0);
INSERT INTO `countries` VALUES (63,'er','Eritrea',5351680,0,0);
INSERT INTO `countries` VALUES (64,'ee','Estonia',1309104,0,0);
INSERT INTO `countries` VALUES (65,'et','Ethiopia',101853268,0,0);
INSERT INTO `countries` VALUES (66,'fk','Falkland Islands',2912,0,0);
INSERT INTO `countries` VALUES (67,'fo','Faroe Islands',48239,0,0);
INSERT INTO `countries` VALUES (68,'fm','Micronesia (Federated States of)',104966,0,0);
INSERT INTO `countries` VALUES (69,'fj','Fiji',897537,0,0);
INSERT INTO `countries` VALUES (70,'fi','Finland',5523904,0,0);
INSERT INTO `countries` VALUES (71,'fr','France',64668129,0,0);
INSERT INTO `countries` VALUES (72,'gf','French Guiana',275688,0,0);
INSERT INTO `countries` VALUES (73,'pf','French Polynesia',285735,0,0);
INSERT INTO `countries` VALUES (74,'ga','Gabon',1763142,0,0);
INSERT INTO `countries` VALUES (75,'gm','Gambia',2054986,0,0);
INSERT INTO `countries` VALUES (76,'ge','Georgia',3979781,0,0);
INSERT INTO `countries` VALUES (77,'de','Germany',80682351,0,0);
INSERT INTO `countries` VALUES (78,'gh','Ghana',28033375,0,0);
INSERT INTO `countries` VALUES (79,'gi','Gibraltar',32373,0,0);
INSERT INTO `countries` VALUES (80,'gr','Greece',10919459,0,0);
INSERT INTO `countries` VALUES (81,'gl','Greenland',56196,0,0);
INSERT INTO `countries` VALUES (82,'gd','Grenada',107327,0,0);
INSERT INTO `countries` VALUES (83,'gp','Guadeloupe',470547,0,0);
INSERT INTO `countries` VALUES (84,'gu','Guam',172094,0,0);
INSERT INTO `countries` VALUES (85,'gt','Guatemala',16672956,0,0);
INSERT INTO `countries` VALUES (86,'gg','Guernsey',164466,0,0);
INSERT INTO `countries` VALUES (87,'gn','Guinea',12947122,0,0);
INSERT INTO `countries` VALUES (88,'gw','Guinea-Bissau',1888429,0,0);
INSERT INTO `countries` VALUES (89,'gy','Guyana',770610,0,0);
INSERT INTO `countries` VALUES (90,'ht','Haiti',10848175,0,0);
INSERT INTO `countries` VALUES (91,'hn','Honduras',8189501,0,0);
INSERT INTO `countries` VALUES (92,'hk','Hong Kong',7346248,0,0);
INSERT INTO `countries` VALUES (93,'hu','Hungary',9821318,0,0);
INSERT INTO `countries` VALUES (94,'is','Iceland',331778,0,0);
INSERT INTO `countries` VALUES (95,'in','India',1326801576,0,0);
INSERT INTO `countries` VALUES (96,'id','Indonesia',260581100,0,0);
INSERT INTO `countries` VALUES (97,'ir','Iran (Islamic Republic of)',80043146,0,0);
INSERT INTO `countries` VALUES (98,'iq','Iraq',37547686,0,0);
INSERT INTO `countries` VALUES (99,'ie','Ireland',4713993,0,0);
INSERT INTO `countries` VALUES (100,'im','Isle of Man',88421,0,0);
INSERT INTO `countries` VALUES (101,'il','Israel',8192463,0,0);
INSERT INTO `countries` VALUES (102,'it','Italy',59801004,0,0);
INSERT INTO `countries` VALUES (103,'jm','Jamaica',2803362,0,0);
INSERT INTO `countries` VALUES (104,'jp','Japan',126323715,0,0);
INSERT INTO `countries` VALUES (105,'jo','Jordan',7747800,0,0);
INSERT INTO `countries` VALUES (106,'kz','Kazakhstan',17855384,0,0);
INSERT INTO `countries` VALUES (107,'ke','Kenya',47251449,0,0);
INSERT INTO `countries` VALUES (108,'ki','Kiribati',114405,0,0);
INSERT INTO `countries` VALUES (109,'kw','Kuwait',4007146,0,0);
INSERT INTO `countries` VALUES (110,'kg','Kyrgyzstan',6033769,0,0);
INSERT INTO `countries` VALUES (111,'la','Laos',6918367,0,0);
INSERT INTO `countries` VALUES (112,'lv','Latvia',1955742,0,0);
INSERT INTO `countries` VALUES (113,'lb','Lebanon',5988153,0,0);
INSERT INTO `countries` VALUES (114,'ls','Lesotho',2160309,0,0);
INSERT INTO `countries` VALUES (115,'lr','Liberia',4615222,0,0);
INSERT INTO `countries` VALUES (116,'ly','Libya',6330159,0,0);
INSERT INTO `countries` VALUES (117,'li','Liechtenstein',37776,0,0);
INSERT INTO `countries` VALUES (118,'lt','Lithuania',2850030,0,0);
INSERT INTO `countries` VALUES (119,'lu','Luxembourg',576243,0,0);
INSERT INTO `countries` VALUES (120,'mo','Macau',597126,0,0);
INSERT INTO `countries` VALUES (121,'mg','Madagascar',24915822,0,0);
INSERT INTO `countries` VALUES (122,'mw','Malawi',17749826,0,0);
INSERT INTO `countries` VALUES (123,'my','Malaysia',30751602,0,0);
INSERT INTO `countries` VALUES (124,'mv','Maldives',369812,0,0);
INSERT INTO `countries` VALUES (125,'ml','Mali',18134835,0,0);
INSERT INTO `countries` VALUES (126,'mt','Malta',419615,0,0);
INSERT INTO `countries` VALUES (127,'mh','Marshall Islands',53069,0,0);
INSERT INTO `countries` VALUES (128,'mq','Martinique',396364,0,0);
INSERT INTO `countries` VALUES (129,'mr','Mauritania',4166463,0,0);
INSERT INTO `countries` VALUES (130,'mu','Mauritius',1277459,0,0);
INSERT INTO `countries` VALUES (131,'yt','Mayotte',246496,0,0);
INSERT INTO `countries` VALUES (132,'mx','Mexico',128632004,0,0);
INSERT INTO `countries` VALUES (133,'md','Moldova (Republic of)',4062862,0,0);
INSERT INTO `countries` VALUES (134,'mc','Monaco',37863,0,0);
INSERT INTO `countries` VALUES (135,'mn','Mongolia',3006444,0,0);
INSERT INTO `countries` VALUES (136,'me','Montenegro',626101,0,0);
INSERT INTO `countries` VALUES (137,'ms','Montserrat',5154,0,0);
INSERT INTO `countries` VALUES (138,'ma','Morocco',34817065,0,0);
INSERT INTO `countries` VALUES (139,'mz','Mozambique',28751362,0,0);
INSERT INTO `countries` VALUES (140,'mm','Myanmar',54363426,0,0);
INSERT INTO `countries` VALUES (141,'na','Namibia',2513981,0,0);
INSERT INTO `countries` VALUES (142,'nr','Nauru',10263,0,0);
INSERT INTO `countries` VALUES (143,'np','Nepal',28850717,0,0);
INSERT INTO `countries` VALUES (144,'nl','Netherlands',16979729,0,0);
INSERT INTO `countries` VALUES (145,'nc','New Caledonia',266431,0,0);
INSERT INTO `countries` VALUES (146,'nz','New Zealand',4565185,0,0);
INSERT INTO `countries` VALUES (147,'ni','Nicaragua',6150035,0,0);
INSERT INTO `countries` VALUES (148,'ne','Niger',20715285,0,0);
INSERT INTO `countries` VALUES (149,'ng','Nigeria',186987563,0,0);
INSERT INTO `countries` VALUES (150,'nu','Niue',1612,0,0);
INSERT INTO `countries` VALUES (151,'kr','Korea (Republic of)',25281327,0,0);
INSERT INTO `countries` VALUES (152,'mp','Northern Mariana Islands',55389,0,0);
INSERT INTO `countries` VALUES (153,'no','Norway',5271958,0,0);
INSERT INTO `countries` VALUES (154,'om','Oman',4654471,0,0);
INSERT INTO `countries` VALUES (155,'pk','Pakistan',192826502,0,0);
INSERT INTO `countries` VALUES (156,'pw','Palau',21501,0,0);
INSERT INTO `countries` VALUES (157,'ps','Palestine, State of',4797239,0,0);
INSERT INTO `countries` VALUES (158,'pa','Panama',3990406,0,0);
INSERT INTO `countries` VALUES (159,'pg','Papua New Guinea',7776115,0,0);
INSERT INTO `countries` VALUES (160,'py','Paraguay',6725430,0,0);
INSERT INTO `countries` VALUES (161,'pe','Peru',31774225,0,0);
INSERT INTO `countries` VALUES (162,'ph','Philippines',102250133,0,0);
INSERT INTO `countries` VALUES (163,'pl','Poland',38593161,0,0);
INSERT INTO `countries` VALUES (164,'pt','Portugal',10304434,0,0);
INSERT INTO `countries` VALUES (165,'pr','Puerto Rico',3680772,0,0);
INSERT INTO `countries` VALUES (166,'qa','Qatar',2291368,0,0);
INSERT INTO `countries` VALUES (167,'mk','Republic of Macedonia',2081012,0,0);
INSERT INTO `countries` VALUES (168,'ro','Romania',19372734,0,0);
INSERT INTO `countries` VALUES (169,'ru','Russian Federation',143439832,0,0);
INSERT INTO `countries` VALUES (170,'rw','Rwanda',11882766,0,0);
INSERT INTO `countries` VALUES (171,'re','Réunion',867214,0,0);
INSERT INTO `countries` VALUES (172,'sh','Saint Helena, Ascension and Tristan da Cunha',3956,0,0);
INSERT INTO `countries` VALUES (173,'kn','Saint Kitts and Nevis',56183,0,0);
INSERT INTO `countries` VALUES (174,'lc','Saint Lucia',186383,0,0);
INSERT INTO `countries` VALUES (175,'pm','Saint Pierre and Miquelon',6301,0,0);
INSERT INTO `countries` VALUES (176,'vc','Saint Vincent and the Grenadines',109644,0,0);
INSERT INTO `countries` VALUES (177,'ws','Samoa',194523,0,0);
INSERT INTO `countries` VALUES (178,'sm','San Marino',31950,0,0);
INSERT INTO `countries` VALUES (179,'st','Sao Tome and Principe',194390,0,0);
INSERT INTO `countries` VALUES (180,'sa','Saudi Arabia',32157974,0,0);
INSERT INTO `countries` VALUES (181,'sn','Senegal',15589485,0,0);
INSERT INTO `countries` VALUES (182,'rs','Serbia',8812705,0,0);
INSERT INTO `countries` VALUES (183,'sc','Seychelles',97026,0,0);
INSERT INTO `countries` VALUES (184,'sl','Sierra Leone',6592102,0,0);
INSERT INTO `countries` VALUES (185,'sg','Singapore',5696506,0,0);
INSERT INTO `countries` VALUES (186,'sx','Sint Maarten',39538,0,0);
INSERT INTO `countries` VALUES (187,'sk','Slovakia',5429418,0,0);
INSERT INTO `countries` VALUES (188,'si','Slovenia',2069362,0,0);
INSERT INTO `countries` VALUES (189,'sb','Solomon Islands',594934,0,0);
INSERT INTO `countries` VALUES (190,'so','Somalia',11079013,0,0);
INSERT INTO `countries` VALUES (191,'za','South Africa',54978907,0,0);
INSERT INTO `countries` VALUES (192,'kp','Korea (Democratic People\'s Republic of)',50503933,0,0);
INSERT INTO `countries` VALUES (193,'ss','South Sudan',12733427,0,0);
INSERT INTO `countries` VALUES (194,'es','Spain',46064604,0,0);
INSERT INTO `countries` VALUES (195,'lk','Sri Lanka',20810816,0,0);
INSERT INTO `countries` VALUES (196,'sd','Sudan',41175541,0,0);
INSERT INTO `countries` VALUES (197,'sr','Suriname',547610,0,0);
INSERT INTO `countries` VALUES (198,'sz','Swaziland',1304063,0,0);
INSERT INTO `countries` VALUES (199,'se','Sweden',9851852,0,0);
INSERT INTO `countries` VALUES (200,'ch','Switzerland',8379477,0,0);
INSERT INTO `countries` VALUES (201,'sy','Syrian Arab Republic',18563595,0,0);
INSERT INTO `countries` VALUES (202,'tw','Taiwan',23395600,0,0);
INSERT INTO `countries` VALUES (203,'tj','Tajikistan',8669464,0,0);
INSERT INTO `countries` VALUES (204,'tz','Tanzania, United Republic of',55155473,0,0);
INSERT INTO `countries` VALUES (205,'th','Thailand',68146609,0,0);
INSERT INTO `countries` VALUES (206,'tl','Timor-Leste',1211245,0,0);
INSERT INTO `countries` VALUES (207,'tg','Togo',7496833,0,0);
INSERT INTO `countries` VALUES (208,'tk','Tokelau',1276,0,0);
INSERT INTO `countries` VALUES (209,'to','Tonga',106915,0,0);
INSERT INTO `countries` VALUES (210,'tt','Trinidad and Tobago',1364973,0,0);
INSERT INTO `countries` VALUES (211,'tn','Tunisia',11375220,0,0);
INSERT INTO `countries` VALUES (212,'tr','Turkey',79622062,0,0);
INSERT INTO `countries` VALUES (213,'tm','Turkmenistan',5438670,0,0);
INSERT INTO `countries` VALUES (214,'tc','Turks and Caicos Islands',34904,0,0);
INSERT INTO `countries` VALUES (215,'tv','Tuvalu',9943,0,0);
INSERT INTO `countries` VALUES (216,'ug','Uganda',40322768,0,0);
INSERT INTO `countries` VALUES (217,'ua','Ukraine',44624373,0,0);
INSERT INTO `countries` VALUES (218,'ae','United Arab Emirates',9266971,0,0);
INSERT INTO `countries` VALUES (219,'gb','United Kingdom',65111143,0,0);
INSERT INTO `countries` VALUES (220,'us','United States of America',324118787,0,0);
INSERT INTO `countries` VALUES (221,'vi','Virgin Islands (U.S.)',106415,0,0);
INSERT INTO `countries` VALUES (222,'uy','Uruguay',3444071,0,0);
INSERT INTO `countries` VALUES (223,'uz','Uzbekistan',30300446,0,0);
INSERT INTO `countries` VALUES (224,'vu','Vanuatu',270470,0,0);
INSERT INTO `countries` VALUES (225,'va','Vatican City',801,0,0);
INSERT INTO `countries` VALUES (226,'ve','Venezuela (Bolivarian Republic of)',31518855,0,0);
INSERT INTO `countries` VALUES (227,'vn','Vietnam',94444200,0,0);
INSERT INTO `countries` VALUES (228,'wf','Wallis and Futuna',13112,0,0);
INSERT INTO `countries` VALUES (229,'eh','Western Sahara',584206,0,0);
INSERT INTO `countries` VALUES (230,'ye','Yemen',27477600,0,0);
INSERT INTO `countries` VALUES (231,'zm','Zambia',16717332,0,0);
INSERT INTO `countries` VALUES (232,'zw','Zimbabwe',15966810,0,0);
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-24 15:04:05
