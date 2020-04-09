-- MySQL dump 10.16  Distrib 10.1.44-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: library
-- ------------------------------------------------------
-- Server version	10.1.44-MariaDB-0ubuntu0.18.04.1

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
-- Table structure for table `authors`
--

DROP TABLE IF EXISTS `authors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `authors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `authors`
--

LOCK TABLES `authors` WRITE;
/*!40000 ALTER TABLE `authors` DISABLE KEYS */;
INSERT INTO `authors` VALUES (1,'Влад Черноморец','2020-03-30 18:38:35'),(2,'fas','2020-03-30 18:38:35'),(4,'Author 2','2020-03-30 18:43:15'),(5,'Марк Саммерфильд','2020-04-05 19:02:17'),(6,'М., Вильямс','2020-04-05 19:04:14'),(7,'Уэс Маккинни','2020-04-05 19:04:39'),(8,'Брюс Эккель','2020-04-05 19:05:39'),(9,'Томас Кормен','2020-04-05 19:06:35'),(10,'Чарльз Лейзерсон','2020-04-05 19:06:35'),(11,'Рональд Ривест','2020-04-05 19:06:35'),(12,'Дэвид Флэнаган','2020-04-05 19:09:07'),(13,'Гэри Маклин Холл','2020-04-05 19:10:08'),(14,'Джеймс Р. Грофф','2020-04-05 20:27:49'),(15,'Люк Веллинг','2020-04-05 20:28:28'),(16,'Сергей Мастицкий','2020-04-05 20:29:04'),(17,'36','2020-04-05 20:30:12'),(18,'Джереми Блум','2020-04-05 20:30:49'),(19,'А. Белов','2020-04-05 20:31:13'),(20,'Сэмюэл Грингард','2020-04-05 20:31:43'),(21,'Сет Гринберг','2020-04-05 20:32:11'),(22,'Александр Сераков','2020-04-05 20:32:31'),(23,'Тим Кедлек','2020-04-05 20:32:57'),(24,'Пол Дейтел','2020-04-05 20:33:28'),(25,'Харви Дейтел','2020-04-05 20:33:28');
/*!40000 ALTER TABLE `authors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `books` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `year` int(10) NOT NULL,
  `description` text,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `click` int(10) DEFAULT '0',
  `wantRead` int(9) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` VALUES (1,'BookName','54159f990d9a6032ce507e4eb7789eba.jpg',1902,'fadfdsfsdf','2020-03-30 18:38:35',1,3),(2,'New','f0e4ce561c143b96861fe620ebc42ea5.jpg',1900,'utiuytiy','2020-03-30 18:43:15',1,1),(3,'книга без ватора','9633ab93abdbbe639e03e8e60dc5e607.jpg',1905,'У этой книги нет автора!','2020-04-05 15:34:07',0,0),(4,'Программирование на языке Go!','f87fdd718745ff42f5c47287019e70ff.jpg',1901,'Программирование на языке Go!','2020-04-05 19:02:17',0,0),(5,'Толковый словарь сетевых терминов и аббревиатур','9ee4fd11769621b95e6be540240351f9.jpg',1902,'Толковый словарь сетевых терминов и аббревиатур','2020-04-05 19:04:14',0,0),(6,'Python for Data Analysis','f0e4ce561c143b96861fe620ebc42ea5.jpg',1903,'Python for Data Analysis','2020-04-05 19:04:39',0,0),(7,'Thinking in Java (4th Edition)','59d705678a982c3796f7749a6d729afb.jpg',1911,'Thinking in Java (4th Edition)','2020-04-05 19:05:39',0,0),(8,'Introduction to Algorithms','3d6cc83249bc8a2b146e8b11a7f667e4.jpg',1918,'Introduction to Algorithms','2020-04-05 19:06:35',2,0),(9,'JavaScript Pocket Reference','66625ed9ecd605d78f4134713d04f509.jpg',1954,'JavaScript Pocket Reference','2020-04-05 19:09:07',0,0),(10,'Adaptive Code via C#: Class and Interface Design, Design Patterns, and SOLID Principles','55ffc2630d39392dfe724ff68899afd3.jpg',1999,'Adaptive Code via C#: Class and Interface Design, Design Patterns, and SOLID Principles','2020-04-05 19:10:08',0,0),(11,'SQL: The Complete Referenc','3103ac7c215b96b01aadcee731163687.jpg',1943,'SQL: The Complete Referenc','2020-04-05 20:27:49',0,0),(12,'PHP and MySQL Web Development','8e9a1fbf2602b3cd5bc882bfe72f1fb3.jpg',2020,'PHP and MySQL Web Development','2020-04-05 20:28:28',0,0),(13,'Статистический анализ и визуализация данных с помощью R','9633ab93abdbbe639e03e8e60dc5e607.jpg',1901,'Статистический анализ и визуализация данных с помощью R','2020-04-05 20:29:04',0,0),(14,'Computer Coding for Kid','1bfc8d6cecd6ab84802a21ac6f0b8a23.jpg',1902,'Computer Coding for Kid','2020-04-05 20:30:12',0,0),(15,'Exploring Arduino: Tools and Techniques for Engineering Wizardry','a30e38ed135f4af88b41ff4f695afe7a.jpg',1903,'Exploring Arduino: Tools and Techniques for Engineering Wizardry','2020-04-05 20:30:49',0,0),(16,'Программирование микроконтроллеров для начинающих и не только','5a98e76495e8ce472c834f6d6d57187b.jpg',1901,'Программирование микроконтроллеров для начинающих и не только','2020-04-05 20:31:13',0,0),(17,'The Internet of Things','2b90b6c45e324eb6c7adc20360e6b523.jpg',1900,'The Internet of Things','2020-04-05 20:31:43',0,0),(18,'Sketching User Experiences: The Workbook','b3f381d07a19934b752e94b9534ccec5.jpg',1905,'Sketching User Experiences: The Workbook','2020-04-05 20:32:11',0,0),(19,'InDesign CS6','7b8125a3a5a374b893a285c3965e2d90.jpg',1901,'InDesign CS6','2020-04-05 20:32:31',0,0),(20,'Адаптивный дизайн. Делаем сайты для любых устройств','54159f990d9a6032ce507e4eb7789eba.jpg',1903,'Адаптивный дизайн. Делаем сайты для любых устройств','2020-04-05 20:32:57',0,0),(21,'Android для разработчиков','056e9239ca71f5459e9a75cf45d044c9.jpg',1900,'Android для разработчиков','2020-04-05 20:33:28',0,0);
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `booksAuthors`
--

DROP TABLE IF EXISTS `booksAuthors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `booksAuthors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `author_id` int(10) unsigned NOT NULL,
  `book_id` int(10) unsigned NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`),
  KEY `book_id` (`book_id`),
  CONSTRAINT `booksAuthors_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `booksAuthors_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `booksAuthors`
--

LOCK TABLES `booksAuthors` WRITE;
/*!40000 ALTER TABLE `booksAuthors` DISABLE KEYS */;
INSERT INTO `booksAuthors` VALUES (1,1,1,'2020-03-30 18:38:35'),(2,2,1,'2020-03-30 18:38:35'),(3,1,2,'2020-03-30 18:43:15'),(4,4,2,'2020-03-30 18:43:15'),(5,5,4,'2020-04-05 19:02:17'),(6,6,5,'2020-04-05 19:04:14'),(7,7,6,'2020-04-05 19:04:39'),(8,8,7,'2020-04-05 19:05:39'),(9,9,8,'2020-04-05 19:06:35'),(10,10,8,'2020-04-05 19:06:35'),(11,11,8,'2020-04-05 19:06:35'),(12,12,9,'2020-04-05 19:09:08'),(13,13,10,'2020-04-05 19:10:08'),(14,14,11,'2020-04-05 20:27:49'),(15,15,12,'2020-04-05 20:28:28'),(16,16,13,'2020-04-05 20:29:04'),(17,17,14,'2020-04-05 20:30:12'),(18,18,15,'2020-04-05 20:30:49'),(19,19,16,'2020-04-05 20:31:13'),(20,20,17,'2020-04-05 20:31:43'),(21,21,18,'2020-04-05 20:32:11'),(22,22,19,'2020-04-05 20:32:31'),(23,23,20,'2020-04-05 20:32:57'),(24,24,21,'2020-04-05 20:33:28'),(25,25,21,'2020-04-05 20:33:28');
/*!40000 ALTER TABLE `booksAuthors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `versions`
--

DROP TABLE IF EXISTS `versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `versions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `versions`
--

LOCK TABLES `versions` WRITE;
/*!40000 ALTER TABLE `versions` DISABLE KEYS */;
INSERT INTO `versions` VALUES (1,'0001_versions.sql','2020-03-30 18:37:33'),(2,'0002_books.sql','2020-03-30 18:37:33'),(3,'0003_authors.sql','2020-03-30 18:37:33'),(4,'0004_booksAuthors.sql','2020-03-30 18:37:33'),(5,'0005_addClickForBooks.sql','2020-04-05 14:58:01'),(6,'0006_addWantReadForBooks.sql','2020-04-05 14:58:01');
/*!40000 ALTER TABLE `versions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-04-07 21:04:19
