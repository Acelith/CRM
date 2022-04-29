-- MySQL dump 10.13  Distrib 5.5.62, for Win64 (AMD64)
--
-- Host: 192.168.129.9    Database: LPI-Backupper
-- ------------------------------------------------------
-- Server version	5.5.68-MariaDB

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
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(250) NOT NULL,
  `dt_insert` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (1,'Acme SA','2022-03-30 09:11:24'),(2,'SOS','2022-04-01 09:42:26'),(3,'jjmoix','2022-04-05 07:15:21');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `impostazioni`
--

DROP TABLE IF EXISTS `impostazioni`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `impostazioni` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `default_modulo` int(11) DEFAULT NULL,
  `percorso_backup_default` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_impostazioni__modulo` (`default_modulo`),
  CONSTRAINT `FK_impostazioni__modulo` FOREIGN KEY (`default_modulo`) REFERENCES `modulo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `impostazioni`
--

LOCK TABLES `impostazioni` WRITE;
/*!40000 ALTER TABLE `impostazioni` DISABLE KEYS */;
INSERT INTO `impostazioni` VALUES (1,1,'/mnt/backup/');
/*!40000 ALTER TABLE `impostazioni` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_schedulazione`
--

DROP TABLE IF EXISTS `log_schedulazione`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_schedulazione` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_schedulazione` int(11) NOT NULL,
  `messaggio` text,
  `dt_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_log_schedulazione__schedulazione` (`id_schedulazione`),
  CONSTRAINT `FK_log_schedulazione__schedulazione` FOREIGN KEY (`id_schedulazione`) REFERENCES `schedulazione` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_schedulazione`
--

LOCK TABLES `log_schedulazione` WRITE;
/*!40000 ALTER TABLE `log_schedulazione` DISABLE KEYS */;
INSERT INTO `log_schedulazione` VALUES (1,1,'sending incremental file list\n\nsent 18 bytes  received 12 bytes  20.00 bytes/sec\ntotal size is 0  speedup is 0.00','2022-04-04 07:55:17'),(2,1,'sending incremental file list\n\nsent 18 bytes  received 12 bytes  20.00 bytes/sec\ntotal size is 0  speedup is 0.00','2022-04-04 07:55:17'),(3,1,'sending incremental file list\n\nsent 18 bytes  received 12 bytes  20.00 bytes/sec\ntotal size is 0  speedup is 0.00','2022-04-04 07:55:17'),(4,1,'rsync -azvq  @:','2022-04-04 08:07:16'),(5,1,'rsync -azvq /mnt/c/Users/Joel/Downloads/random_fiulesd test@192.168.150.129:/home/test/bck/','2022-04-04 08:07:48'),(6,1,'sending incremental file list\n\nsent 18 bytes  received 12 bytes  20.00 bytes/sec\ntotal size is 0  speedup is 0.00','2022-04-04 08:40:09'),(7,1,'sending incremental file list\n\nsent 18 bytes  received 12 bytes  20.00 bytes/sec\ntotal size is 0  speedup is 0.00','2022-04-04 08:42:11'),(8,1,'sending incremental file list\n\nsent 18 bytes  received 12 bytes  20.00 bytes/sec\ntotal size is 0  speedup is 0.00','2022-04-04 08:43:47'),(9,1,'sending incremental file list\n\nsent 18 bytes  received 12 bytes  20.00 bytes/sec\ntotal size is 0  speedup is 0.00','2022-04-04 08:44:11'),(10,1,'sending incremental file list\n\nsent 18 bytes  received 12 bytes  20.00 bytes/sec\ntotal size is 0  speedup is 0.00','2022-04-04 08:45:08'),(11,1,'sending incremental file list\n\nsent 18 bytes  received 12 bytes  20.00 bytes/sec\ntotal size is 0  speedup is 0.00','2022-04-04 08:47:34'),(12,1,'','2022-04-04 08:50:32'),(13,1,'','2022-04-04 08:51:33'),(14,1,'rsync: link_stat /mnt/c/Users/Joel/Downloads/random_fiulesd failed: No such file or directory (2)\nrsync error: some files/attrs were not transferred (see previous errors) (code 23) at main.c(1207) [sender=3.1.3]','2022-04-04 08:52:20'),(15,1,'rsync: link_stat /mnt/c/Users/Joel/Downloads/random_fiulesd failed: No such file or directory (2)\nrsync error: some files/attrs were not transferred (see previous errors) (code 23) at main.c(1207) [sender=3.1.3]','2022-04-04 08:53:11'),(16,1,'rsync: link_stat /mnt/c/Users/Joel/Downloads/random_fiulesd failed: No such file or directory (2)\nrsync error: some files/attrs were not transferred (see previous errors) (code 23) at main.c(1207) [sender=3.1.3]','2022-04-04 08:53:48'),(17,1,'rsync: link_stat /mnt/c/Users/Joel/Downloads/random_fiulesd failed: No such file or directory (2)\nrsync error: some files/attrs were not transferred (see previous errors) (code 23) at main.c(1207) [sender=3.1.3]','2022-04-04 08:54:00'),(18,1,'rsync: link_stat /mnt/c/Users/Joel/Downloads/random_fiulesd failed: No such file or directory (2)\nrsync error: some files/attrs were not transferred (see previous errors) (code 23) at main.c(1207) [sender=3.1.3]','2022-04-04 08:54:41'),(19,4,'kex_exchange_identification: read: Connection reset by peer\r\nrsync: connection unexpectedly closed (0 bytes received so far) [sender]\nrsync error: unexplained error (code 255) at io.c(235) [sender=3.1.3]','2022-04-05 08:31:06'),(20,4,'kex_exchange_identification: read: Connection reset by peer\r\nrsync: connection unexpectedly closed (0 bytes received so far) [sender]\nrsync error: unexplained error (code 255) at io.c(235) [sender=3.1.3]','2022-04-05 08:33:58');
/*!40000 ALTER TABLE `log_schedulazione` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modulo`
--

DROP TABLE IF EXISTS `modulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modulo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `abilitato` tinyint(1) DEFAULT NULL,
  `icona` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modulo`
--

LOCK TABLES `modulo` WRITE;
/*!40000 ALTER TABLE `modulo` DISABLE KEYS */;
INSERT INTO `modulo` VALUES (0,'login',1,''),(1,'Dashboard',1,'bi bi-speedometer'),(2,'Impostazioni',1,'bi bi-gear-wide-connected');
/*!40000 ALTER TABLE `modulo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedulazione`
--

DROP TABLE IF EXISTS `schedulazione`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedulazione` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `id_stato` int(11) DEFAULT '4',
  `percorso_backup` varchar(300) DEFAULT NULL,
  `abilitata` tinyint(1) NOT NULL DEFAULT '0',
  `dt_creazione` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `dt_last_run` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_schedulazione__cliente` (`id_cliente`),
  KEY `FK_schedulazione__stato_schedulazione` (`id_stato`),
  CONSTRAINT `FK_schedulazione__cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id`),
  CONSTRAINT `FK_schedulazione__stato_schedulazione` FOREIGN KEY (`id_stato`) REFERENCES `stato_schedulazione` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedulazione`
--

LOCK TABLES `schedulazione` WRITE;
/*!40000 ALTER TABLE `schedulazione` DISABLE KEYS */;
INSERT INTO `schedulazione` VALUES (1,1,2,'/home/test/bck/',1,'2022-03-30 09:11:24','2022-04-04 08:57:30'),(2,2,4,'/home/sos/bck',0,'2022-04-01 09:42:47',NULL),(3,1,4,'/home/test/bck_contabilita/',0,'2022-04-01 10:08:46',NULL),(4,3,1,'/home/acelith/bck/',1,'2022-04-05 07:15:53','2022-04-05 08:23:37');
/*!40000 ALTER TABLE `schedulazione` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stato_schedulazione`
--

DROP TABLE IF EXISTS `stato_schedulazione`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stato_schedulazione` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stato` varchar(100) DEFAULT NULL,
  `colore` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stato_schedulazione`
--

LOCK TABLES `stato_schedulazione` WRITE;
/*!40000 ALTER TABLE `stato_schedulazione` DISABLE KEYS */;
INSERT INTO `stato_schedulazione` VALUES (1,'in corso','#239B56 '),(2,'finita','green'),(3,'finita con errori','#FF7F50'),(4,'mai avviata','#40E0D0');
/*!40000 ALTER TABLE `stato_schedulazione` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utente`
--

DROP TABLE IF EXISTS `utente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `utente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(500) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `cognome` varchar(100) DEFAULT NULL,
  `dt_creazione` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `dt_last_login` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utente`
--

LOCK TABLES `utente` WRITE;
/*!40000 ALTER TABLE `utente` DISABLE KEYS */;
INSERT INTO `utente` VALUES (1,'joelmoix','staff@pingitoreinformatica.ch','$2y$10$KdI2Pz.Ctg8TKZCekO/MteU5kljY6cD0ugy65Iuy3N0WgK4xtUH86','Joel','Moix','2022-03-30 09:11:24','2022-04-05 06:22:56');
/*!40000 ALTER TABLE `utente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'LPI-Backupper'
--

--
-- Dumping routines for database 'LPI-Backupper'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-04-05 12:29:12
