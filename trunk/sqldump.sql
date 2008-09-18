-- MySQL dump 10.11
--
-- Host: localhost    Database: test_herstelformulier
-- ------------------------------------------------------
-- Server version	5.0.32-Debian_7etch6-log

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
-- Table structure for table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE `categorie` (
  `id` int(11) NOT NULL auto_increment,
  `naamNL` varchar(255) NOT NULL,
  `naamEN` varchar(255) NOT NULL,
  `locatie` enum('kamer','verdiep','gemeenschappelijk') NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categorie`
--

LOCK TABLES `categorie` WRITE;
/*!40000 ALTER TABLE `categorie` DISABLE KEYS */;
INSERT INTO `categorie` VALUES (1,'Elektriciteit','Electricity','kamer'),(2,'Sanitair','Plumbing','kamer'),(3,'Meubilair','Furniture','kamer'),(4,'Keuken','Kitchen','verdiep'),(5,'Badkamer Keukenkant','Bathroom Kitchenside','verdiep'),(6,'Badkamer Bijkeukenkant','Bathroom Sidekitchen','verdiep'),(7,'Bijkeuken','Sidekitchen','verdiep'),(8,'Gemeenschapsruimte','Recreationroom','gemeenschappelijk'),(9,'Hall','Hall','kamer'),(10,'Badkamer','Bathroom','kamer'),(11,'Kookhoek','Kitchen','kamer'),(12,'Verlichting','Lighting','kamer'),(13,'Schakelaars','Switches','kamer'),(14,'Stopcontacten','Sockets','kamer'),(15,'Overige','miscellaneous','kamer'),(16,'Centrale verwarming','Heating','kamer');
/*!40000 ALTER TABLE `categorie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `error`
--

DROP TABLE IF EXISTS `error`;
CREATE TABLE `error` (
  `id` int(11) NOT NULL auto_increment,
  `datum` datetime default NULL,
  `melding` text,
  `file` varchar(256) default NULL,
  `lijn` varchar(8) default NULL,
  `user` varchar(16) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `error`
--

LOCK TABLES `error` WRITE;
/*!40000 ALTER TABLE `error` DISABLE KEYS */;
INSERT INTO `error` VALUES (4,'2008-09-10 16:23:16','Er werd een foutieve parameter doorgegeven. ','/home/sites/test_herstelformulier/WWW/repair/classes/Home.class.php','50','bmesuere'),(5,'2008-09-10 17:08:06','U heeft onvoldoende rechten om deze pagina te bekijken. ','/home/sites/test_herstelformulier/WWW/repair/personeelExporteer.php','17',''),(6,'2008-09-15 15:37:48','Deze applicatie is enkel toegankelijk voor bewoners van een studentehomes','/home/sites/herstelformulier/WWW/classes/Auth.class.php','68',''),(7,'2008-09-15 15:38:07','Deze applicatie is enkel toegankelijk voor bewoners van een studentehomes','/home/sites/herstelformulier/WWW/classes/Auth.class.php','68',''),(8,'2008-09-17 08:06:20','Er werd een foutieve parameter doorgegeven: Formid is ongeldig','/home/sites/herstelformulier/WWW/ajax/doorgevenMelding.php','15','luvdnber'),(9,'2008-09-17 21:51:02','Deze applicatie is enkel toegankelijk voor bewoners van een studentehomes','/home/sites/herstelformulier/WWW/classes/Auth.class.php','68',''),(10,'2008-09-17 21:51:24','Deze applicatie is enkel toegankelijk voor bewoners van een studentehomes','/home/sites/herstelformulier/WWW/classes/Auth.class.php','68',''),(11,'2008-09-18 11:20:36','Deze applicatie is enkel toegankelijk voor bewoners van een studentehomes','/home/sites/herstelformulier/WWW/classes/Auth.class.php','68','');
/*!40000 ALTER TABLE `error` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `herstelformulier`
--

DROP TABLE IF EXISTS `herstelformulier`;
CREATE TABLE `herstelformulier` (
  `id` int(11) NOT NULL auto_increment,
  `factuurnummer` int(11) NOT NULL,
  `datum` datetime NOT NULL,
  `status` enum('ongezien','gezien','gedaan','afgesloten') NOT NULL,
  `userId` int(11) NOT NULL,
  `kamer` varchar(13) NOT NULL,
  `homeId` int(11) NOT NULL,
  `opmerking` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `userId` (`userId`),
  KEY `homeId` (`homeId`),
  CONSTRAINT `herstelformulier_ibfk_2` FOREIGN KEY (`homeId`) REFERENCES `home` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `herstelformulier_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `herstelformulier`
--

LOCK TABLES `herstelformulier` WRITE;
/*!40000 ALTER TABLE `herstelformulier` DISABLE KEYS */;
INSERT INTO `herstelformulier` VALUES (8,0,'2008-09-15 18:41:37','ongezien',7,'91.01.240.020',1,'Het regent binnen langs de bovenkant van het raam.'),(9,0,'2008-09-15 22:04:04','ongezien',10,'91.01.220.003',1,'De rubberen strook tussen de twee ramen is verstorven en deels eraf gevallen.'),(10,0,'2008-09-16 17:57:26','ongezien',11,'91.01.200.005',1,'Stopcontact in de zaal achter de gemeenschapszaal is stuk'),(11,0,'2008-09-16 18:38:45','gedaan',12,'31.02.140.018',3,''),(12,0,'2008-09-16 19:44:41','ongezien',13,'91.01.160.011',1,''),(13,0,'2008-09-16 22:28:19','ongezien',14,'91.01.210.015',1,''),(14,0,'2008-09-16 22:31:50','ongezien',15,'91.01.240.007',1,'Handdoek-bar is kapot (al 6 jaar)'),(15,0,'2008-09-16 22:52:31','ongezien',16,'91.01.230.015',1,'omhulsel van lamp boven bed al precies een jaar weg, nog voor mijn aankomst in mijn kamer, voor de veiligheid dringend herstel gevraagd'),(16,0,'2008-09-17 16:03:50','ongezien',17,'91.01.210.001',1,'bed  has no scrolls, one of the support for the bed floor is broken, i have been using paper to support the bed to avoid it falling off and making noise at night when turning on the bed,'),(17,0,'2008-09-17 16:45:19','ongezien',18,'40.13.120.041',5,'Ik kan wel nog spreken in telefoon, maar ik kan niemand horen.'),(18,0,'2008-09-17 17:26:50','ongezien',19,'91.01.170.028',1,''),(19,0,'2008-09-17 18:24:09','gedaan',12,'31.02.140.018',3,''),(20,0,'2008-09-17 23:12:33','gedaan',20,'55.01.140.013',4,''),(21,0,'2008-09-18 08:51:07','ongezien',21,'40.13.110.046',5,'De TL-lamp boven de spiegel in de badkamer is defect. \n\nDe lampen van de dampkap werken niet, de dampkap zelf zuigt niet af.\n\nEen gedeelte van de rubberen afsluiting bovenaan het raam zit los (zichtbaar als het raam openstaat)\n\nTer informatie - m.b.t. de waarborg: In de leefruimte is de verf op enkele plaatsen afgebladerd. In de muur boven de radiator is er een gat geboord en is er een stukje uit de muur. Deze schade werd door de vorige huurder aangebracht.  ');
/*!40000 ALTER TABLE `herstelformulier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `home`
--

DROP TABLE IF EXISTS `home`;
CREATE TABLE `home` (
  `id` int(11) NOT NULL auto_increment,
  `korteNaam` varchar(255) NOT NULL,
  `langeNaam` varchar(255) NOT NULL,
  `adres` varchar(255) NOT NULL,
  `verdiepen` int(11) NOT NULL,
  `kamerPrefix` varchar(5) NOT NULL,
  `ldapNaam` varchar(255) NOT NULL,
  `verwijderd` tinyint(1) NOT NULL,
  `basistelefoonnummer` int(5) NOT NULL,
  `kamersperverdiep` int(3) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `korteNaam` (`korteNaam`,`adres`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `home`
--

LOCK TABLES `home` WRITE;
/*!40000 ALTER TABLE `home` DISABLE KEYS */;
INSERT INTO `home` VALUES (1,'Boudewijn','Home Koning Boudewijn','Harelbekestraat 70',14,'91.01','HOME BOUDEWIJN',0,14287,32),(2,'Astrid','Home Koningin Astrid','Krijgslaan 250',5,'53.01','HOME ASTRID',0,12622,55),(3,'Fabiola','Home Koningin Fabiola','Stalhof 4',7,'31.02','HOME FABIOLA',0,13987,32),(4,'Vermeylen','Home August Vermeylen','Stalhof 6',8,'55.01','HOME VERMEYLEN',0,0,32),(5,'Bertha','Home Bertha De Vriese','De Pintelaan 260B',4,'40.13','HOME BERTHA DE VRIESE',0,0,32),(6,'Heymans','Home Corneel Heymans','Isabellakaai 120',7,'55.02','HOME HEYMANS',0,0,32);
/*!40000 ALTER TABLE `home` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personeel`
--

DROP TABLE IF EXISTS `personeel`;
CREATE TABLE `personeel` (
  `userId` int(11) NOT NULL,
  `verwijderd` tinyint(1) NOT NULL,
  `mails` tinyint(1) NOT NULL,
  PRIMARY KEY  (`userId`),
  CONSTRAINT `personeel_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `personeel`
--

LOCK TABLES `personeel` WRITE;
/*!40000 ALTER TABLE `personeel` DISABLE KEYS */;
INSERT INTO `personeel` VALUES (1,0,1),(2,0,1),(3,0,0),(4,0,1),(6,0,1);
/*!40000 ALTER TABLE `personeel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `relatie_herstelformulier_velden`
--

DROP TABLE IF EXISTS `relatie_herstelformulier_velden`;
CREATE TABLE `relatie_herstelformulier_velden` (
  `herstelformulierId` int(11) NOT NULL,
  `veldId` int(11) NOT NULL,
  `referentienummer` int(11) NOT NULL,
  KEY `herstelformulierId` (`herstelformulierId`),
  KEY `veldId` (`veldId`),
  CONSTRAINT `relatie_herstelformulier_velden_ibfk_1` FOREIGN KEY (`herstelformulierId`) REFERENCES `herstelformulier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `relatie_herstelformulier_velden_ibfk_2` FOREIGN KEY (`veldId`) REFERENCES `velden` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `relatie_herstelformulier_velden`
--

LOCK TABLES `relatie_herstelformulier_velden` WRITE;
/*!40000 ALTER TABLE `relatie_herstelformulier_velden` DISABLE KEYS */;
INSERT INTO `relatie_herstelformulier_velden` VALUES (8,16,0),(9,10,0),(9,11,0),(9,27,0),(11,46,1786383435),(12,11,0),(13,18,0),(16,15,0),(16,20,0),(16,32,0),(16,14,0),(17,180,0),(18,32,0),(19,36,1218766300),(20,68,1218766401),(20,66,1218766401),(21,163,0),(21,169,0),(21,191,0),(21,193,0);
/*!40000 ALTER TABLE `relatie_herstelformulier_velden` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `relatie_personeel_home`
--

DROP TABLE IF EXISTS `relatie_personeel_home`;
CREATE TABLE `relatie_personeel_home` (
  `homeId` int(11) NOT NULL,
  `personeelId` int(11) NOT NULL,
  KEY `homeId` (`homeId`),
  KEY `personeelId` (`personeelId`),
  CONSTRAINT `relatie_personeel_home_ibfk_2` FOREIGN KEY (`personeelId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `relatie_personeel_home_ibfk_1` FOREIGN KEY (`homeId`) REFERENCES `home` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `relatie_personeel_home`
--

LOCK TABLES `relatie_personeel_home` WRITE;
/*!40000 ALTER TABLE `relatie_personeel_home` DISABLE KEYS */;
INSERT INTO `relatie_personeel_home` VALUES (1,3),(2,3),(3,3),(4,3),(5,3),(6,3),(1,4),(2,4),(5,4),(3,6),(4,6),(6,6),(1,2),(2,2),(3,2),(4,2),(5,2),(6,2),(1,1),(2,1),(3,1),(4,1),(5,1),(6,1);
/*!40000 ALTER TABLE `relatie_personeel_home` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE `student` (
  `userId` int(11) NOT NULL,
  `taal` enum('nl','en') NOT NULL,
  `homeId` int(11) NOT NULL,
  `kamer` varchar(13) NOT NULL,
  `telefoon` int(5) NOT NULL,
  `verwijderd` tinyint(1) NOT NULL,
  UNIQUE KEY `userId` (`userId`,`kamer`,`telefoon`),
  KEY `homeId` (`homeId`),
  CONSTRAINT `student_ibfk_2` FOREIGN KEY (`homeId`) REFERENCES `home` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `student_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES (1,'nl',1,'91.01.230.012',14715,0),(2,'nl',1,'91.01.240.030',14765,0),(5,'nl',1,'91.01.180.014',0,0),(7,'nl',1,'91.01.240.020',0,0),(8,'nl',5,'40.13.130.015',0,0),(9,'nl',2,'53.01.110.008',0,0),(10,'nl',1,'91.01.220.003',0,0),(11,'nl',1,'91.01.200.005',0,0),(12,'en',3,'31.02.140.018',0,0),(13,'en',1,'91.01.160.011',0,0),(14,'nl',1,'91.01.210.015',0,0),(15,'nl',1,'91.01.240.007',0,0),(16,'nl',1,'91.01.230.015',0,0),(17,'en',1,'91.01.210.001',0,0),(18,'nl',5,'40.13.120.041',0,0),(19,'nl',1,'91.01.170.028',0,0),(20,'en',4,'55.01.140.013',0,0),(21,'nl',5,'40.13.110.046',0,0),(22,'nl',1,'91.01.210.027',0,0);
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL auto_increment,
  `gebruikersnaam` varchar(8) NOT NULL,
  `voornaam` varchar(255) NOT NULL,
  `achternaam` varchar(255) NOT NULL,
  `laatsteOnline` datetime NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `gebruikersnaam` (`gebruikersnaam`,`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'bmesuere','Bart','Mesuere','2008-06-26 19:56:05','bart.mesuere@ugent.be'),(2,'bevdeghi','Bert','Vandeghinste','2008-06-26 19:56:23','bert.vandeghinste@ugent.be'),(3,'mmartens','Marianne','Martens','2008-09-09 16:10:37','Marianne.Martens@UGent.be'),(4,'dmathys','Dirk','Mathys','2008-09-09 16:10:47','Dirk.Mathys@UGent.be'),(5,'dverhass','David','Verhasselt','2008-09-09 16:42:07','David.Verhasselt@UGent.be'),(6,'luvdnber','Luc','Van den berghe','2008-09-10 10:49:40','Luc.Vandenberghe@UGent.be'),(7,'avraes','Aagje','Vanraes','2008-09-15 15:52:15','Aagje.Vanraes@UGent.be'),(8,'hpijpeli','Hans','Pijpelink','2008-09-15 18:19:01','Hans.Pijpelink@UGent.be'),(9,'pspeybro','Peter','Speybrouck','2008-09-15 19:17:58','Peter.Speybrouck@UGent.be'),(10,'smdgryse','Stijn','Degryse','2008-09-15 22:01:15','Stijn.Degryse@UGent.be'),(11,'wodgreve','Wouter','DegrÃ¨ve','2008-09-16 17:56:24','W.Degreve@UGent.be'),(12,'fmandits','Faith Angeline','Manditsera','2008-09-16 18:37:35','FaithAngeline.Manditsera@UGent.be'),(13,'nebrahim','Negin','Ebrahimi','2008-09-16 19:36:47','Negin.Ebrahimi@UGent.be'),(14,'shoreman','Silvy','Horemans','2008-09-16 22:27:22','Silvy.Horemans@UGent.be'),(15,'craemdon','Cedric','Raemdonck','2008-09-16 22:30:38','Cedric.Raemdonck@UGent.be'),(16,'csarrazi','Christophe','Sarrazin','2008-09-16 22:49:43','Christophe.Sarrazin@UGent.be'),(17,'mkahpui','Mariama Salifu','Kahpui','2008-09-17 15:56:12','MariamSalifu.Kahpui@UGent.be'),(18,'brclaeys','Bert','Claeys','2008-09-17 16:44:22','Bert.Claeys@UGent.be'),(19,'rvcaysee','Robbe','Vancayseele','2008-09-17 17:26:06','Robbe.Vancayseele@UGent.be'),(20,'thinguye','Thi Hanh Tien','Nguyen','2008-09-17 23:11:08','ThiHanhTien.Nguyen@UGent.be'),(21,'jroobaer','Joni','Roobaert','2008-09-18 08:33:17','Joni.Roobaert@UGent.be'),(22,'twaegemn','Tim','Waegeman','2008-09-18 11:36:35','Tim.Waegeman@UGent.be');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `velden`
--

DROP TABLE IF EXISTS `velden`;
CREATE TABLE `velden` (
  `id` int(11) NOT NULL auto_increment,
  `naamNL` varchar(255) NOT NULL,
  `naamEN` varchar(255) NOT NULL,
  `categorieId` int(11) NOT NULL,
  `homeId` int(11) NOT NULL,
  `verwijderd` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `categorieId` (`categorieId`),
  KEY `homeId` (`homeId`),
  CONSTRAINT `velden_ibfk_2` FOREIGN KEY (`homeId`) REFERENCES `home` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `velden_ibfk_1` FOREIGN KEY (`categorieId`) REFERENCES `categorie` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `velden`
--

LOCK TABLES `velden` WRITE;
/*!40000 ALTER TABLE `velden` DISABLE KEYS */;
INSERT INTO `velden` VALUES (1,'Lamp boven lavabo','Lamp above the sink',1,1,0),(2,'Grote lichten','Striplighting',1,1,0),(3,'Lamp boven bed','Lamp above the bed',1,1,0),(4,'Schakelaar boven lavabo','Switch of lamp above the sink',1,1,0),(5,'Schakelaar grote lichten','Switch of striplighting',1,1,0),(6,'Schakelaar lamp boven bed','Switch of lamp above the bed',1,1,0),(7,'Stopcontacten','Sockets',1,1,0),(8,'Telefoon','Phone',1,1,0),(9,'Sifon lavabo lekt','Drain sink drips',2,1,0),(10,'Kraan lavabo lekt','Tap sink leaks',2,1,0),(11,'Lavabo verstopt','Drain sink is clogged',2,1,0),(12,'Radiator sluit niet af','Radiator can not be turned off',16,1,0),(13,'Radiator kraan lekt','Radiator tap leaks',16,1,0),(14,'geen warmte uit radiator','radiator gives no heating',16,1,0),(15,'bedpoot afgebroken','leg of bed is broken',3,1,0),(16,'skandiaflex','persian blind',3,1,0),(17,'ingangsdeur slot','bedroomdoor lock is broken',3,1,0),(18,'ingangsdeur sleept','bedroomdoor drags',3,1,0),(19,'scharnier kast','hinge wardrobe',3,1,0),(20,'kast sluit niet','wardrobe doesnt close',3,1,0),(21,'bovenblad bureel beschadigd','desk has damaged tabletop',3,1,0),(22,'schuiven bij bureel','drawers of writingdesk',3,1,0),(23,'raamglas gebarsten','windowglass is broken',3,1,0),(24,'raam gaat niet open','window does not open',3,1,0),(25,'vloerbedekking beschadigd','floorcovering is damaged',3,1,0),(26,'plinten los','skirting-board has come off',3,1,0),(27,'Elektrisch vuurtje werkt niet','Electric stove doesnt work',4,1,0),(28,'Microgolf kapot','Microwaveoven broken',4,1,0),(29,'Niet schoongemaakt','Not cleaned well',7,1,0),(30,'TV kapot','TV broken',8,1,0),(31,'Pingpongtafel kapot','Pingpongtable broken',8,1,0),(32,'zetel','armchair',3,1,0),(33,'Niet schoongemaakt','Not cleaned well',4,1,0),(34,'Niet schoongemaakt','Not cleaned well',5,1,0),(35,'Niet schoongemaakt','Not cleaned well',6,1,0),(36,'Lamp boven lavabo','Lamp above the sink',1,3,0),(37,'Grote lichten','Striplighting',1,3,0),(38,'Lamp boven bed','Lamp above the bed',1,3,0),(39,'Schakelaar boven lavabo','Switch of lamp above the sink',1,3,0),(40,'Schakelaar grote lichten','Switch of striplighting',1,3,0),(41,'Schakelaar lamp boven bed','Switch of lamp above the bed',1,3,0),(42,'Stopkontacten','Sockets',1,3,0),(43,'telefoon','telephone',1,3,0),(44,'Lavabo hangt los','Sink is loos',2,3,0),(45,'Lavabo sinfon lekt','Sink drain drips',2,3,0),(46,'Lavabo kraan lekt','Sink tap leaks',2,3,0),(47,'Lavabo verstopt','Sink drain is clogged',2,3,0),(48,'Handdoekdrager los','Towelbar loose',2,3,0),(49,'Radiator sluit niet af','Radiator can not be truned off',2,3,0),(50,'Radiator kraan lekt','Radiator tap leaks',2,3,0),(51,'Radiator geen warmte','Radiator no heating',2,3,0),(52,'Lattenbodem kapot','Bed frame damaged',3,3,0),(53,'Matrashoes vervangen','Replace zipper',3,3,0),(54,'Skandiaflex','Persian blind',3,3,0),(55,'Ingangsdeur slot','Bedroomdoor lock',3,3,0),(56,'Ingangsdeur sleept','Bedroomdoor drags',3,3,0),(57,'Kast scharnier','Wardrobe hinge',3,3,0),(58,'Kast sluit niet','Wardrobe doesn\'t close',3,3,0),(59,'Bovenblad bureel beschadigd','Desk tabletop damaged',3,3,0),(60,'Bureel schuiven','Desk drawers',3,3,0),(61,'Raam gebarsten','Window is broken',3,3,0),(62,'Raam gaat niet open','Window does not open',3,3,0),(63,'Vloerbekleding beschadigd','Floorcovering is damaged',3,3,0),(64,'Plinten los','Skirting-board has come off',3,3,0),(65,'Stoel ontbreekt','Chair is missing',3,3,0),(66,'Lamp boven lavabo','Lamp above the sink',1,4,0),(67,'Grote lichten','Striplighting',1,4,0),(68,'Lamp boven bed','Lamp above the bed',1,4,0),(69,'Schakelaar boven lavabo','Switch of lamp above the sink',1,4,0),(70,'Schakelaar grote lichten','Switch of striplighting',1,4,0),(71,'Schakelaar lamp boven bed','Switch of lamp above the bed',1,4,0),(72,'Stopkontacten','Sockets',1,4,0),(73,'telefoon','telephone',1,4,0),(74,'Lavabo hangt los','Sink is loos',2,4,0),(75,'Lavabo sinfon lekt','Sink drain drips',2,4,0),(76,'Lavabo kraan lekt','Sink tap leaks',2,4,0),(77,'Lavabo verstopt','Sink drain is clogged',2,4,0),(78,'Handdoekdrager los','Towelbar loose',2,4,0),(79,'Radiator sluit niet af','Radiator can not be truned off',2,4,0),(80,'Radiator kraan lekt','Radiator tap leaks',2,4,0),(81,'Radiator geen warmte','Radiator no heating',2,4,0),(82,'Lattenbodem kapot','Bed frame damaged',3,4,0),(83,'Matrashoes vervangen','Replace zipper',3,4,0),(84,'Skandiaflex','Persian blind',3,4,0),(85,'Ingangsdeur slot','Bedroomdoor lock',3,4,0),(86,'Ingangsdeur sleept','Bedroomdoor drags',3,4,0),(87,'Kast scharnier','Wardrobe hinge',3,4,0),(88,'Kast sluit niet','Wardrobe doesn\'t close',3,4,0),(89,'Bovenblad bureel beschadigd','Desk tabletop damaged',3,4,0),(90,'Bureel schuiven','Desk drawers',3,4,0),(91,'Raam gebarsten','Window is broken',3,4,0),(92,'Raam gaat niet open','Window does not open',3,4,0),(93,'Vloerbekleding beschadigd','Floorcovering is damaged',3,4,0),(94,'Plinten los','Skirting-board has come off',3,4,0),(95,'Stoel ontbreekt','Chair is missing',3,4,0),(96,'Lamp boven lavabo','Lamp above the sink',1,2,0),(97,'Grote lichten','Striplighting',1,2,0),(98,'Lamp boven bed','Lamp above the bed',1,2,0),(99,'Schakelaar boven lavabo','Switch of lamp above the sink',1,2,0),(100,'Schakelaar grote lichten','Switch of striplighting',1,2,0),(101,'Schakelaar lamp boven bed','Switch of lamp above the bed',1,2,0),(102,'Stopcontacten','Sockets',1,2,0),(103,'Telefoon','Phone',1,2,0),(104,'Sifon lavabo lekt','Drain sink drips',2,2,0),(105,'Kraan lavabo lekt','Tap sink leaks',2,2,0),(106,'Lavabo verstopt','Drain sink is clogged',2,2,0),(107,'Radiator sluit niet af','Radiator can not be turned off',2,2,0),(108,'Radiator kraan lekt','Radiator tap leaks',2,2,0),(109,'geen warmte uit radiator','radiator gives no heating',2,2,0),(110,'bedpoot afgebroken','leg of bed is broken',3,2,0),(111,'skandiaflex','persian blind',3,2,0),(112,'ingangsdeur slot','bedroomdoor lock is broken',3,2,0),(113,'ingangsdeur sleept','bedroomdoor drags',3,2,0),(114,'scharnier kast','hinge wardrobe',3,2,0),(115,'kast sluit niet','wardrobe doesnt close',3,2,0),(116,'bovenblad bureel beschadigd','desk has damaged tabletop',3,2,0),(117,'schuiven bij bureel','drawers of writingdesk',3,2,0),(118,'raamglas gebarsten','windowglass is broken',3,2,0),(119,'raam gaat niet open','window does not open',3,2,0),(120,'vloerbedekking beschadigd','floorcovering is damaged',3,2,0),(121,'plinten los','skirting-board has come off',3,2,0),(122,'Elektrisch vuurtje werkt niet','Electric stove doesnt work',4,2,0),(123,'Microgolf kapot','Microwaveoven broken',4,2,0),(124,'zetel','armchair',3,2,0),(125,'tv distributie','cable TV',1,2,0),(126,'licht toiletkastje','light bathroom cupboard',1,2,0),(127,'deur toiletkastje','door bathroom cupboard',2,2,0),(128,'spiegel toiletkastje','mirror bathroon cupboard',2,2,0),(129,'Deur','Door',9,5,0),(130,'Deurslot','Doorlock',9,5,0),(131,'Deurkruk','Doorknob',9,5,0),(132,'Muren','Walls',9,5,0),(133,'Plafond','Ceiling',9,5,0),(134,'Vloerbekleding','Floor',9,5,0),(135,'Deur','Door',10,5,0),(136,'Lavabo','Sink',10,5,0),(137,'Douche','Shower',10,5,0),(138,'Kastje onder lavabo','Cupboard under sink',10,5,0),(139,'Sproeier douche','Showerhead',10,5,0),(140,'Toilet','Toilet',10,5,0),(141,'Handdoekhouder','Towelbar',10,5,0),(142,'Papierrolhouder','Toilet paper dispenser',10,5,0),(143,'Zeephouder douche','Soapholder shower',10,5,0),(144,'muren','walls',10,5,0),(145,'kleerhanger',' cloth hanger',10,5,0),(146,'vloer','floor',10,5,0),(147,'spiegel','mirror',10,5,0),(148,'plafond','ceiling',10,5,0),(149,'bureautafel + laden','desk + drawers',3,5,0),(150,'bed + lattenbodem','bed',3,5,0),(151,'stoelen','chairs',3,5,0),(152,'matras','Mattress',3,5,0),(153,'Eettafel','Diningtable',3,5,0),(154,'Kleerkast','Wardrobe',3,5,0),(155,'Zetel','Sofa',3,5,1),(156,'Ingebouwde boekenkast','shelf',3,5,0),(157,'ijskast','fridge',11,5,0),(158,'verlichting ijskast','fridge light',11,5,0),(159,'vuilnisbakje','Bin',11,5,0),(160,'kookvuur','stove',11,5,0),(161,'knoppen kookplaten','knobs cooking plates',11,5,0),(162,'aanrecht','countertop',11,5,0),(163,'verlichting dampkap','lighting extractor hood',11,5,0),(164,'lade voor bestek','cutlery drawer',11,5,0),(165,'kast naast kleerkast','cupboard next to wardrobe',11,5,0),(166,'kast boven dampkap','cupboard above extractor hood',11,5,0),(167,'kast naast dampkap','cupboard next to extractor hood',11,5,0),(168,'hall','hall',12,5,0),(169,'badkamer','bathroom',12,5,0),(170,'leerruimte','livingroom',12,5,0),(171,'boven aanrecht','above countertop',12,5,0),(172,'boven bed','above bed',12,5,0),(173,'boven aanrecht','above countertop',13,5,0),(174,'boven bed','above bed',13,5,0),(175,'boven tafel','above table',13,5,0),(176,'in hall','in hall',13,5,0),(177,'zekeringkas','fusebox',1,5,0),(178,'internet-aansluitingsdoos','ethernet socket',1,5,0),(179,'televisie-distributie','cable TV',1,5,0),(180,'telefoon','phone',1,5,0),(181,'boven bureaublad','above desk',14,5,0),(182,'boven bed','above bed',14,5,0),(183,'in boekenkast','in shelf',14,5,0),(184,'in kookhoek','in kitchen',14,5,0),(185,'in badkamer','in bathroom',14,5,0),(186,'bij tafel','next to table',14,5,0),(187,'gordijnen','curtains',15,5,0),(188,'skandiaflex','persian blind',15,5,0),(189,'radiator','heating',15,5,0),(190,'vloeren leefruimte','floor livingroom',15,5,0),(191,'muren leefruimte','walls livingroom',15,5,0),(192,'plafond leefruimte','ceiling livingroom',15,5,0),(193,'raam','window',15,5,0);
/*!40000 ALTER TABLE `velden` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2008-09-18 11:16:57
