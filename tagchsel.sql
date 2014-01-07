-- MySQL dump 10.13  Distrib 5.5.34, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: tagchsel
-- ------------------------------------------------------
-- Server version	5.5.34-0ubuntu0.13.04.1

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
-- Table structure for table `channel`
--

DROP TABLE IF EXISTS `channel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `channel` (
  `input` int(10) unsigned NOT NULL,
  `modul` int(10) unsigned NOT NULL,
  `pattern` int(10) unsigned NOT NULL,
  `bit` int(10) unsigned NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`input`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `channel`
--

LOCK TABLES `channel` WRITE;
/*!40000 ALTER TABLE `channel` DISABLE KEYS */;
INSERT INTO `channel` VALUES (0,0,0,0,'Tagger Ch 128'),(1,0,0,1,'Tagger Ch 129'),(2,0,0,2,'Tagger Ch 130'),(3,0,0,3,'Tagger Ch 131'),(4,0,0,4,'Tagger Ch 132'),(5,0,0,5,'Tagger Ch 133'),(6,0,0,6,'Tagger Ch 134'),(7,0,0,7,'Tagger Ch 135'),(8,0,0,8,'Tagger Ch 136'),(9,0,0,9,'Tagger Ch 137'),(10,0,0,10,'Tagger Ch 138'),(11,0,0,11,'Tagger Ch 139'),(12,0,0,12,'Tagger Ch 140'),(13,0,0,13,'Tagger Ch 141'),(14,0,0,14,'Tagger Ch 142'),(15,0,0,15,'Tagger Ch 143'),(16,0,0,16,'Tagger Ch 144'),(17,0,0,17,'Tagger Ch 145'),(18,0,0,18,'Tagger Ch 146'),(19,0,0,19,'Tagger Ch 147'),(20,0,0,20,'Tagger Ch 148'),(21,0,0,21,'Tagger Ch 149'),(22,0,0,22,'Tagger Ch 150'),(23,0,0,23,'Tagger Ch 151'),(24,0,0,24,'Tagger Ch 152'),(25,0,0,25,'Tagger Ch 153'),(26,0,0,26,'Tagger Ch 154'),(27,0,0,27,'Tagger Ch 155'),(28,0,0,28,'Tagger Ch 156'),(29,0,0,29,'Tagger Ch 157'),(30,0,0,30,'Tagger Ch 158'),(31,0,0,31,'Tagger Ch 159'),(32,0,0,32,'Tagger Ch 224'),(33,0,0,33,'Tagger Ch 225'),(34,0,0,34,'Tagger Ch 226'),(35,0,0,35,'Tagger Ch 227'),(36,0,0,36,'Tagger Ch 228'),(37,0,0,37,'Tagger Ch 229'),(38,0,0,38,'Tagger Ch 230'),(39,0,0,39,'Tagger Ch 231'),(40,0,0,40,'Tagger Ch 232'),(41,0,0,41,'Tagger Ch 233'),(42,0,0,42,'Tagger Ch 234'),(43,0,0,43,'Tagger Ch 235'),(44,0,0,44,'Tagger Ch 236'),(45,0,0,45,'Tagger Ch 237'),(46,0,0,46,'Tagger Ch 238'),(47,0,0,47,'Tagger Ch 239'),(48,0,0,48,'Tagger Ch 240'),(49,0,0,49,'Tagger Ch 241'),(50,0,0,50,'Tagger Ch 242'),(51,0,0,51,'Tagger Ch 243'),(52,0,0,52,'Tagger Ch 244'),(53,0,0,53,'Tagger Ch 245'),(54,0,0,54,'Tagger Ch 246'),(55,0,0,55,'Tagger Ch 247'),(56,0,0,56,'Tagger Ch 248'),(57,0,0,57,'Tagger Ch 249'),(58,0,0,58,'Tagger Ch 250'),(59,0,0,59,'Tagger Ch 251'),(60,0,0,60,'Tagger Ch 252'),(61,0,0,61,'Tagger Ch 253'),(62,0,0,62,'Tagger Ch 254'),(63,0,0,63,'Tagger Ch 255'),(64,0,1,0,'Tagger Ch 32'),(65,0,1,1,'Tagger Ch 33'),(66,0,1,2,'Tagger Ch 34'),(67,0,1,3,'Tagger Ch 35'),(68,0,1,4,'Tagger Ch 36'),(69,0,1,5,'Tagger Ch 37'),(70,0,1,6,'Tagger Ch 38'),(71,0,1,7,'Tagger Ch 39'),(72,0,1,8,'Tagger Ch 40'),(73,0,1,9,'Tagger Ch 41'),(74,0,1,10,'Tagger Ch 42'),(75,0,1,11,'Tagger Ch 43'),(76,0,1,12,'Tagger Ch 44'),(77,0,1,13,'Tagger Ch 45'),(78,0,1,14,'Tagger Ch 46'),(79,0,1,15,'Tagger Ch 47'),(80,0,1,16,'Tagger Ch 48'),(81,0,1,17,'Tagger Ch 49'),(82,0,1,18,'Tagger Ch 50'),(83,0,1,19,'Tagger Ch 51'),(84,0,1,20,'Tagger Ch 52'),(85,0,1,21,'Tagger Ch 53'),(86,0,1,22,'Tagger Ch 54'),(87,0,1,23,'Tagger Ch 55'),(88,0,1,24,'Tagger Ch 56'),(89,0,1,25,'Tagger Ch 57'),(90,0,1,26,'Tagger Ch 58'),(91,0,1,27,'Tagger Ch 59'),(92,0,1,28,'Tagger Ch 60'),(93,0,1,29,'Tagger Ch 61'),(94,0,1,30,'Tagger Ch 62'),(95,0,1,31,'Tagger Ch 63'),(96,1,0,0,'Tagger Ch 96'),(97,1,0,1,'Tagger Ch 97'),(98,1,0,2,'Tagger Ch 98'),(99,1,0,3,'Tagger Ch 99'),(100,1,0,4,'Tagger Ch 100'),(101,1,0,5,'Tagger Ch 101'),(102,1,0,6,'Tagger Ch 102'),(103,1,0,7,'Tagger Ch 103'),(104,1,0,8,'Tagger Ch 104'),(105,1,0,9,'Tagger Ch 105'),(106,1,0,10,'Tagger Ch 106'),(107,1,0,11,'Tagger Ch 107'),(108,1,0,12,'Tagger Ch 108'),(109,1,0,13,'Tagger Ch 109'),(110,1,0,14,'Tagger Ch 110'),(111,1,0,15,'Tagger Ch 111'),(112,1,0,16,'Tagger Ch 112'),(113,1,0,17,'Tagger Ch 113'),(114,1,0,18,'Tagger Ch 114'),(115,1,0,19,'Tagger Ch 115'),(116,1,0,20,'Tagger Ch 116'),(117,1,0,21,'Tagger Ch 117'),(118,1,0,22,'Tagger Ch 118'),(119,1,0,23,'Tagger Ch 119'),(120,1,0,24,'Tagger Ch 120'),(121,1,0,25,'Tagger Ch 121'),(122,1,0,26,'Tagger Ch 122'),(123,1,0,27,'Tagger Ch 123'),(124,1,0,28,'Tagger Ch 124'),(125,1,0,29,'Tagger Ch 125'),(126,1,0,30,'Tagger Ch 126'),(127,1,0,31,'Tagger Ch 127'),(128,1,0,32,'Tagger Ch 256'),(129,1,0,33,'Tagger Ch 257'),(130,1,0,34,'Tagger Ch 258'),(131,1,0,35,'Tagger Ch 259'),(132,1,0,36,'Tagger Ch 260'),(133,1,0,37,'Tagger Ch 261'),(134,1,0,38,'Tagger Ch 262'),(135,1,0,39,'Tagger Ch 263'),(136,1,0,40,'Tagger Ch 264'),(137,1,0,41,'Tagger Ch 265'),(138,1,0,42,'Tagger Ch 266'),(139,1,0,43,'Tagger Ch 267'),(140,1,0,44,'Tagger Ch 268'),(141,1,0,45,'Tagger Ch 269'),(142,1,0,46,'Tagger Ch 270'),(143,1,0,47,'Tagger Ch 271'),(144,1,0,48,'Tagger Ch 272'),(145,1,0,49,'Tagger Ch 273'),(146,1,0,50,'Tagger Ch 274'),(147,1,0,51,'Tagger Ch 275'),(148,1,0,52,'Tagger Ch 276'),(149,1,0,53,'Tagger Ch 277'),(150,1,0,54,'Tagger Ch 278'),(151,1,0,55,'Tagger Ch 279'),(152,1,0,56,'Tagger Ch 280'),(153,1,0,57,'Tagger Ch 281'),(154,1,0,58,'Tagger Ch 282'),(155,1,0,59,'Tagger Ch 283'),(156,1,0,60,'Tagger Ch 284'),(157,1,0,61,'Tagger Ch 285'),(158,1,0,62,'Tagger Ch 286'),(159,1,0,63,'Tagger Ch 287'),(160,1,1,0,'Tagger Ch 160'),(161,1,1,1,'Tagger Ch 161'),(162,1,1,2,'Tagger Ch 162'),(163,1,1,3,'Tagger Ch 163'),(164,1,1,4,'Tagger Ch 164'),(165,1,1,5,'Tagger Ch 165'),(166,1,1,6,'Tagger Ch 166'),(167,1,1,7,'Tagger Ch 167'),(168,1,1,8,'Tagger Ch 168'),(169,1,1,9,'Tagger Ch 169'),(170,1,1,10,'Tagger Ch 170'),(171,1,1,11,'Tagger Ch 171'),(172,1,1,12,'Tagger Ch 172'),(173,1,1,13,'Tagger Ch 173'),(174,1,1,14,'Tagger Ch 174'),(175,1,1,15,'Tagger Ch 175'),(176,1,1,16,'Tagger Ch 176'),(177,1,1,17,'Tagger Ch 177'),(178,1,1,18,'Tagger Ch 178'),(179,1,1,19,'Tagger Ch 179'),(180,1,1,20,'Tagger Ch 180'),(181,1,1,21,'Tagger Ch 181'),(182,1,1,22,'Tagger Ch 182'),(183,1,1,23,'Tagger Ch 183'),(184,1,1,24,'Tagger Ch 184'),(185,1,1,25,'Tagger Ch 185'),(186,1,1,26,'Tagger Ch 186'),(187,1,1,27,'Tagger Ch 187'),(188,1,1,28,'Tagger Ch 188'),(189,1,1,29,'Tagger Ch 189'),(190,1,1,30,'Tagger Ch 190'),(191,1,1,31,'Tagger Ch 191'),(192,2,0,0,'Tagger Ch 64'),(193,2,0,1,'Tagger Ch 65'),(194,2,0,2,'Tagger Ch 66'),(195,2,0,3,'Tagger Ch 67'),(196,2,0,4,'Tagger Ch 68'),(197,2,0,5,'Tagger Ch 69'),(198,2,0,6,'Tagger Ch 70'),(199,2,0,7,'Tagger Ch 71'),(200,2,0,8,'Tagger Ch 72'),(201,2,0,9,'Tagger Ch 73'),(202,2,0,10,'Tagger Ch 74'),(203,2,0,11,'Tagger Ch 75'),(204,2,0,12,'Tagger Ch 76'),(205,2,0,13,'Tagger Ch 77'),(206,2,0,14,'Tagger Ch 78'),(207,2,0,15,'Tagger Ch 79'),(208,2,0,16,'Tagger Ch 80'),(209,2,0,17,'Tagger Ch 81'),(210,2,0,18,'Tagger Ch 82'),(211,2,0,19,'Tagger Ch 83'),(212,2,0,20,'Tagger Ch 84'),(213,2,0,21,'Tagger Ch 85'),(214,2,0,22,'Tagger Ch 86'),(215,2,0,23,'Tagger Ch 87'),(216,2,0,24,'Tagger Ch 88'),(217,2,0,25,'Tagger Ch 89'),(218,2,0,26,'Tagger Ch 90'),(219,2,0,27,'Tagger Ch 91'),(220,2,0,28,'Tagger Ch 92'),(221,2,0,29,'Tagger Ch 93'),(222,2,0,30,'Tagger Ch 94'),(223,2,0,31,'Tagger Ch 95'),(224,2,0,32,'Tagger Ch 288'),(225,2,0,33,'Tagger Ch 289'),(226,2,0,34,'Tagger Ch 290'),(227,2,0,35,'Tagger Ch 291'),(228,2,0,36,'Tagger Ch 292'),(229,2,0,37,'Tagger Ch 293'),(230,2,0,38,'Tagger Ch 294'),(231,2,0,39,'Tagger Ch 295'),(232,2,0,40,'Tagger Ch 296'),(233,2,0,41,'Tagger Ch 297'),(234,2,0,42,'Tagger Ch 298'),(235,2,0,43,'Tagger Ch 299'),(236,2,0,44,'Tagger Ch 300'),(237,2,0,45,'Tagger Ch 301'),(238,2,0,46,'Tagger Ch 302'),(239,2,0,47,'Tagger Ch 303'),(240,2,0,48,'Tagger Ch 304'),(241,2,0,49,'Tagger Ch 305'),(242,2,0,50,'Tagger Ch 306'),(243,2,0,51,'Tagger Ch 307'),(244,2,0,52,'Tagger Ch 308'),(245,2,0,53,'Tagger Ch 309'),(246,2,0,54,'Tagger Ch 310'),(247,2,0,55,'Tagger Ch 311'),(248,2,0,56,'Tagger Ch 312'),(249,2,0,57,'Tagger Ch 313'),(250,2,0,58,'Tagger Ch 314'),(251,2,0,59,'Tagger Ch 315'),(252,2,0,60,'Tagger Ch 316'),(253,2,0,61,'Tagger Ch 317'),(254,2,0,62,'Tagger Ch 318'),(255,2,0,63,'Tagger Ch 319'),(256,2,1,0,'Tagger Ch 192'),(257,2,1,1,'Tagger Ch 193'),(258,2,1,2,'Tagger Ch 194'),(259,2,1,3,'Tagger Ch 195'),(260,2,1,4,'Tagger Ch 196'),(261,2,1,5,'Tagger Ch 197'),(262,2,1,6,'Tagger Ch 198'),(263,2,1,7,'Tagger Ch 199'),(264,2,1,8,'Tagger Ch 200'),(265,2,1,9,'Tagger Ch 201'),(266,2,1,10,'Tagger Ch 202'),(267,2,1,11,'Tagger Ch 203'),(268,2,1,12,'Tagger Ch 204'),(269,2,1,13,'Tagger Ch 205'),(270,2,1,14,'Tagger Ch 206'),(271,2,1,15,'Tagger Ch 207'),(272,2,1,16,'Tagger Ch 208'),(273,2,1,17,'Tagger Ch 209'),(274,2,1,18,'Tagger Ch 210'),(275,2,1,19,'Tagger Ch 211'),(276,2,1,20,'Tagger Ch 212'),(277,2,1,21,'Tagger Ch 213'),(278,2,1,22,'Tagger Ch 214'),(279,2,1,23,'Tagger Ch 215'),(280,2,1,24,'Tagger Ch 216'),(281,2,1,25,'Tagger Ch 217'),(282,2,1,26,'Tagger Ch 218'),(283,2,1,27,'Tagger Ch 219'),(284,2,1,28,'Tagger Ch 220'),(285,2,1,29,'Tagger Ch 221'),(286,2,1,30,'Tagger Ch 222'),(287,2,1,31,'Tagger Ch 223'),(288,3,0,0,'Tagger Ch 0'),(289,3,0,1,'Tagger Ch 1'),(290,3,0,2,'Tagger Ch 2'),(291,3,0,3,'Tagger Ch 3'),(292,3,0,4,'Tagger Ch 4'),(293,3,0,5,'Tagger Ch 5'),(294,3,0,6,'Tagger Ch 6'),(295,3,0,7,'Tagger Ch 7'),(296,3,0,8,'Tagger Ch 8'),(297,3,0,9,'Tagger Ch 9'),(298,3,0,10,'Tagger Ch 10'),(299,3,0,11,'Tagger Ch 11'),(300,3,0,12,'Tagger Ch 12'),(301,3,0,13,'Tagger Ch 13'),(302,3,0,14,'Tagger Ch 14'),(303,3,0,15,'Tagger Ch 15'),(304,3,0,16,'Tagger Ch 16'),(305,3,0,17,'Tagger Ch 17'),(306,3,0,18,'Tagger Ch 18'),(307,3,0,19,'Tagger Ch 19'),(308,3,0,20,'Tagger Ch 20'),(309,3,0,21,'Tagger Ch 21'),(310,3,0,22,'Tagger Ch 22'),(311,3,0,23,'Tagger Ch 23'),(312,3,0,24,'Tagger Ch 24'),(313,3,0,25,'Tagger Ch 25'),(314,3,0,26,'Tagger Ch 26'),(315,3,0,27,'Tagger Ch 27'),(316,3,0,28,'Tagger Ch 28'),(317,3,0,29,'Tagger Ch 29'),(318,3,0,30,'Tagger Ch 30'),(319,3,0,31,'Tagger Ch 31'),(320,3,0,32,'Tagger Ch 320'),(321,3,0,33,'Tagger Ch 321'),(322,3,0,34,'Tagger Ch 322'),(323,3,0,35,'Tagger Ch 323'),(324,3,0,36,'Tagger Ch 324'),(325,3,0,37,'Tagger Ch 325'),(326,3,0,38,'Tagger Ch 326'),(327,3,0,39,'Tagger Ch 327'),(328,3,0,40,'Tagger Ch 328'),(329,3,0,41,'Tagger Ch 329'),(330,3,0,42,'Tagger Ch 330'),(331,3,0,43,'Tagger Ch 331'),(332,3,0,44,'Tagger Ch 332'),(333,3,0,45,'Tagger Ch 333'),(334,3,0,46,'Tagger Ch 334'),(335,3,0,47,'Tagger Ch 335'),(336,3,0,48,'Tagger Ch 336'),(337,3,0,49,'Tagger Ch 337'),(338,3,0,50,'Tagger Ch 338'),(339,3,0,51,'Tagger Ch 339'),(340,3,0,52,'Tagger Ch 340'),(341,3,0,53,'Tagger Ch 341'),(342,3,0,54,'Tagger Ch 342'),(343,3,0,55,'Tagger Ch 343'),(344,3,0,56,'Tagger Ch 344'),(345,3,0,57,'Tagger Ch 345'),(346,3,0,58,'Tagger Ch 346'),(347,3,0,59,'Tagger Ch 347'),(348,3,0,60,'Tagger Ch 348'),(349,3,0,61,'Tagger Ch 349'),(350,3,0,62,'Tagger Ch 350'),(351,3,0,63,'Tagger Ch 351');
/*!40000 ALTER TABLE `channel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `output` int(10) unsigned NOT NULL,
  `input` int(10) unsigned NOT NULL,
  `status` int(10) unsigned zerofill NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config`
--

LOCK TABLES `config` WRITE;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` VALUES (1,0,288,0000000001),(2,8,289,0000000002);
/*!40000 ALTER TABLE `config` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-01-07  9:44:34
