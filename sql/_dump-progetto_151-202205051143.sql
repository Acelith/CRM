-- MySQL dump 10.13  Distrib 8.0.21, for Win64 (x86_64)
--
-- Host: localhost    Database: progetto_151
-- ------------------------------------------------------
-- Server version	5.5.5-10.6.7-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `azienda`
--

DROP TABLE IF EXISTS `azienda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `azienda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` text DEFAULT NULL,
  `telefono` varchar(100) DEFAULT NULL,
  `sito_web` varchar(100) DEFAULT NULL,
  `indirizzo` text DEFAULT NULL,
  `citta` text DEFAULT NULL,
  `cap` varchar(100) DEFAULT NULL,
  `provincia` text DEFAULT NULL,
  `nazione` text DEFAULT NULL,
  `note` text DEFAULT NULL,
  `id_utente` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_azienda__utente` (`id_utente`),
  CONSTRAINT `FK_azienda__utente` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=260 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `azienda`
--

LOCK TABLES `azienda` WRITE;
/*!40000 ALTER TABLE `azienda` DISABLE KEYS */;
INSERT INTO `azienda` VALUES (2,'Acme SA ','6666','acme.com','Via Dal Canyon','Il Canyon','420','California','USA','Quella che fa davvero casino, attenzione hai dipendenti, hanno fame ... ',2),(10,'Katell Crosby','(027) 33622787',NULL,NULL,'Huacho','50201','Biobío','Chile',NULL,NULL),(11,'Dustin Stafford','(01583) 7884407',NULL,NULL,'Volgograd','24925','Luik','Costa Rica',NULL,NULL),(12,'Macon Riggs','(08470) 0624241',NULL,NULL,'Hisar','4221 MJ','Podlaskie','Colombia',NULL,NULL),(13,'Kimberly Payne','(0171) 84570384',NULL,NULL,'Muiden','07662','Dalarnas län','Belgium',NULL,NULL),(14,'Carol Newman','(031845) 163231',NULL,NULL,'Curitiba','4492-0807','North Island','Costa Rica',NULL,NULL),(15,'Hayden Crawford','(05670) 7226970',NULL,NULL,'Broken Arrow','55982-372','North Jeolla','Singapore',NULL,NULL),(16,'Colleen Burnett','(032328) 084211',NULL,NULL,'Columbus','695051','Gävleborgs län','Russian Federation',NULL,NULL),(17,'Aristotle Newton','(07237) 6427696',NULL,NULL,'Jecheon','58920-87463','Bangsamoro','Norway',NULL,NULL),(18,'Ross Rodriquez','(073) 04476108',NULL,NULL,'Reynosa','92813-588','South Island','Nigeria',NULL,NULL),(19,'Rahim Riddle','(09510) 2970548',NULL,NULL,'Terzorio','99324-282','Australian Capital Territory','Ukraine',NULL,NULL),(20,'Ahmed Jordan','(0557) 80132842',NULL,NULL,'Zaffelare','464587','Bangsamoro','Netherlands',NULL,2),(21,'Kai Cote','(032118) 726770',NULL,NULL,'Whitehorse','69-58','Somerset','Ireland',NULL,NULL),(22,'Tate Daniel','(0736) 30684009',NULL,NULL,'Arrone','125457','Southwestern Tagalog Region','New Zealand',NULL,NULL),(23,'Tyrone Deleon','(0055) 95547511',NULL,NULL,'Le Puy-en-Velay','02883','Mecklenburg-Vorpommern','Chile',NULL,NULL),(24,'Gillian Dale','(043) 68615753',NULL,NULL,'Puntarenas','W3H 7C5','Central Sulawesi','Spain',NULL,NULL),(25,'Phillip Burris','(06559) 8569647',NULL,NULL,'Moncton','6413','North Jeolla','Ukraine',NULL,NULL),(26,'Leilani Foreman','(037200) 517366',NULL,NULL,'Whakatane','04855-11840','Lower Austria','Norway',NULL,NULL),(27,'Davis Rasmussen','(036079) 165571',NULL,NULL,'Guadalupe','34881','Haute-Normandie','United States',NULL,NULL),(28,'Kay Scott','(00061) 7157728',NULL,NULL,'Lambayeque','735742','Limburg','Mexico',NULL,NULL),(29,'Erasmus Jones','(023) 75606886',NULL,NULL,'Ostrowiec Świętokrzyski','21447','Nordrhein-Westphalen','United Kingdom',NULL,NULL),(30,'Colby Hopper','(00685) 0916058',NULL,NULL,'Mthatha','S8R 2L7','East Region','Peru',NULL,NULL),(31,'Haley Gonzalez','(031342) 836383',NULL,NULL,'Shigar','67113','Meta','Belgium',NULL,NULL),(32,'Felix Walter','(0356) 14048336',NULL,NULL,'Jönköping','85-195','Upper Austria','Peru',NULL,NULL),(33,'Uta Craig','(031427) 866696',NULL,NULL,'Mielec','8030-6180','Katsina','Philippines',NULL,NULL),(34,'Willa Rowe','(071) 52666518',NULL,NULL,'Sungai Penuh','72060','Florida','Belgium',NULL,NULL),(35,'Cora Whitney','(036120) 116228',NULL,NULL,'Tulln an der Donau','76566','Zamboanga Peninsula','Australia',NULL,NULL),(36,'Wesley Strong','(035262) 915577',NULL,NULL,'Sumy','9813 IL','West-Vlaanderen','New Zealand',NULL,NULL),(37,'Ezra Clark','(019) 81289826',NULL,NULL,'North Waziristan','45155-303','Santa Catarina','Indonesia',NULL,NULL),(38,'Phoebe Bush','(037340) 672377',NULL,NULL,'Hartford','51756','East Region','Norway',NULL,NULL),(39,'Cally Aguilar','(09437) 2735455',NULL,NULL,'Kherson','25-72','Atacama','Nigeria',NULL,NULL),(40,'Lunea Vaughan','(056) 22780277',NULL,NULL,'Agartala','718248','Hidalgo','United States',NULL,NULL),(41,'Abel Joseph','(039040) 294859',NULL,NULL,'Enns','V8X 3BJ','South Jeolla','Singapore',NULL,2),(42,'Quin Murray','(0831) 61198398',NULL,NULL,'Ribeirão das Neves','560425','Vestfold og Telemark','Singapore',NULL,NULL),(43,'Hedley Rhodes','(01173) 4861258',NULL,NULL,'Tagum','66-626','Bahia','Germany',NULL,NULL),(44,'Ava Walsh','(067) 59774661',NULL,NULL,'Invercargill','10981','Thanh Hóa','Singapore',NULL,NULL),(45,'Melyssa Saunders','(0786) 23263396',NULL,NULL,'San Ramón','2761','British Columbia','Brazil',NULL,NULL),(46,'Fulton Warren','(02885) 4344161',NULL,NULL,'Balclutha','8249','North West','Turkey',NULL,NULL),(47,'Medge Spencer','(082) 16022245',NULL,NULL,'Gander','6423 MU','Vienna','Costa Rica',NULL,NULL),(48,'Guy Stafford','(031843) 507213',NULL,NULL,'Magadan','306833','Haryana','China',NULL,NULL),(49,'Reagan Ward','(0130) 44151799',NULL,NULL,'Vedrin','09370','Volgograd Oblast','Peru',NULL,NULL),(50,'Summer Callahan','(037733) 615766',NULL,NULL,'Sobral','18382','Jammu and Kashmir','United States',NULL,NULL),(51,'Nelle Berry','(0512) 35794523',NULL,NULL,'Kalush','593131','Limburg','Ukraine',NULL,NULL),(52,'Jolene Curtis','(06314) 4894411',NULL,NULL,'Melitopol','338484','Nordrhein-Westphalen','United States',NULL,NULL),(53,'Paul Suarez','(036051) 268702',NULL,NULL,'Henstedt-Ulzburg','23235','Guaviare','Ukraine',NULL,NULL),(54,'Phyllis Marks','(01579) 7513325',NULL,NULL,'Indianapolis','7980-5779','Hamburg','Italy',NULL,NULL),(55,'Yasir Donovan','(0471) 95158864',NULL,NULL,'Shillong','16316','Khmelnytskyi oblast','Costa Rica',NULL,NULL),(56,'Germane Mason','(03806) 3303424',NULL,NULL,'Lagos','7411','Queensland','Russian Federation',NULL,NULL),(57,'Remedios Hawkins','(05425) 1398861',NULL,NULL,'Gorinchem','8865','Tasmania','United Kingdom',NULL,NULL),(58,'Jonas Buck','(0440) 61299555',NULL,NULL,'Lelystad','572815','Lincolnshire','India',NULL,NULL),(59,'Jenna Patel','(036877) 506130',NULL,NULL,'Zapopan','616495','Munster','Brazil',NULL,NULL),(60,'Carson Watson','(039727) 405367',NULL,NULL,'Columbus','56331','Saarland','Belgium',NULL,NULL),(61,'Moses Ewing','(012) 76585797',NULL,NULL,'Xinjiang','433156','Dunbartonshire','Ireland',NULL,NULL),(62,'Tyrone Ray','(031338) 163304',NULL,NULL,'Remagne','1671','Vestland','Pakistan',NULL,NULL),(63,'Deacon Macias','(091) 98128364',NULL,NULL,'Afşin','89H 6R3','Västra Götalands län','Indonesia',NULL,NULL),(64,'Andrew Case','(054) 45563803',NULL,NULL,'Namsos','76-54','Assam','Germany',NULL,NULL),(65,'Ferris Hutchinson','(0636) 05135621',NULL,NULL,'Middelburg','693529','Western Australia','France',NULL,NULL),(66,'Rooney Butler','(038172) 151171',NULL,NULL,'Ergani','3274','Metropolitana de Santiago','Spain',NULL,NULL),(67,'Iliana Flowers','(04394) 7686036',NULL,NULL,'Palu','154207','Bình Thuận','South Africa',NULL,NULL),(68,'Timon Juarez','(032435) 327158',NULL,NULL,'Oldenzaal','292702','Berlin','India',NULL,NULL),(69,'Ulla Mckenzie','(03288) 6718574',NULL,NULL,'Arequipa','4738','Haryana','Ukraine',NULL,NULL),(70,'Gannon Dudley','(017) 70314985',NULL,NULL,'Valparaíso de Goiás','47211','Aquitaine','Singapore',NULL,NULL),(71,'Irene Barron','(0141) 15258840',NULL,NULL,'Benoni','7217','Tyrol','Mexico',NULL,NULL),(72,'Sybill Prince','(030) 68268306',NULL,NULL,'Port Elizabeth','05473','Galicia','Costa Rica',NULL,NULL),(73,'Kevin Herman','(01578) 4085743',NULL,NULL,'Rawalakot','74656','Baden Württemberg','Turkey',NULL,NULL),(74,'Mark Shepard','(075) 81406718',NULL,NULL,'Fujian','8200-0356','Sachsen-Anhalt','Canada',NULL,NULL),(75,'Steel Hayden','(032201) 334851',NULL,NULL,'Verrebroek','5323','Castilla - La Mancha','Ireland',NULL,NULL),(76,'Elliott Sosa','(0898) 59772575',NULL,NULL,'Chortkiv','28934','Noord Brabant','Singapore',NULL,NULL),(77,'Beatrice Berg','(06431) 9661118',NULL,NULL,'Valledupar','JZ1Y 4UT','San José','Colombia',NULL,NULL),(78,'Vivian Sanders','(0394) 34336766',NULL,NULL,'Carson City','44664','Utrecht','Colombia',NULL,NULL),(79,'Chaim Bailey','(0623) 08589304',NULL,NULL,'Kovel','278926','Western Visayas','Nigeria',NULL,NULL),(80,'Noel Benton','(051) 62803052',NULL,NULL,'Anhui','50868','Styria','South Africa',NULL,NULL),(81,'Raymond Lowe','(06831) 0565895',NULL,NULL,'Sumy','228127','Brussels Hoofdstedelijk Gewest','United Kingdom',NULL,NULL),(82,'Hammett Howe','(031845) 058235',NULL,NULL,'Götzis','676392','Kentucky','Turkey',NULL,NULL),(83,'Chiquita Daniels','(0051) 24437460',NULL,NULL,'Tranås','36-572','Belgorod Oblast','United Kingdom',NULL,NULL),(84,'Galvin Carney','(0578) 66733016',NULL,NULL,'Nicoya','18869','Bắc Giang','Italy',NULL,NULL),(85,'Stacy Conway','(000) 62068546',NULL,NULL,'Lviv','13186','Sussex','Russian Federation',NULL,NULL),(86,'Alexander Macdonald','(025) 27185177',NULL,NULL,'Maasmechelen','17431','Brussels Hoofdstedelijk Gewest','Poland',NULL,NULL),(87,'Pascale Whitehead','(0467) 09471713',NULL,NULL,'Castanhal','588985','Puntarenas','United States',NULL,NULL),(88,'Hunter Barker','(0358) 84106941',NULL,NULL,'Castletown','6115','Kherson oblast','Philippines',NULL,NULL),(89,'Violet Freeman','(085) 21412483',NULL,NULL,'Mersin','7373','San José','Pakistan',NULL,NULL),(90,'Tad Anthony','(038) 69363687',NULL,NULL,'Bevagna','3864-7728','Extremadura','Belgium',NULL,NULL),(91,'Jana Carver','(034018) 222813',NULL,NULL,'Medan','155833','Phú Yên','India',NULL,NULL),(92,'Kirk Berry','(0203) 83361337',NULL,NULL,'Gilgit','67080','Cundinamarca','Sweden',NULL,NULL),(93,'Jolie Joseph','(035) 25106665',NULL,NULL,'Kremenchuk','38226','Tiền Giang','Ireland',NULL,NULL),(94,'Sage Wiggins','(0688) 71070274',NULL,NULL,'Shanxi','3467','Paraíba','Vietnam',NULL,NULL),(95,'Stewart Ayers','(07458) 7689598',NULL,NULL,'Lustenau','72-223','North Island','Canada',NULL,NULL),(96,'Xyla Snyder','(041) 64663157',NULL,NULL,'Autre-Eglise','274515','Rogaland','Belgium',NULL,NULL),(97,'Garrett Walton','(033996) 297547',NULL,NULL,'Clearwater Municipal District','27681','Baden Württemberg','France',NULL,NULL),(98,'Tamekah Brennan','(07167) 1412695',NULL,NULL,'Qinghai','451522','Pays de la Loire','Poland',NULL,NULL),(99,'Solomon Henson','(04754) 3731924',NULL,NULL,'Arequipa','8617','California','Indonesia',NULL,NULL),(100,'Bradley Powers','(02187) 7142645',NULL,NULL,'Opole','3173','Bắc Giang','Pakistan',NULL,NULL),(101,'Brynne Mckenzie','(03187) 7419480',NULL,NULL,'Manokwari','81471','Central Kalimantan','Spain',NULL,NULL),(102,'Abdul Mcdowell','(06928) 7371673','','','Arequipa','665742','Midi-Pyrénées','asdsad','asdadsasdasdas',3),(103,'Noble Ball','(03273) 6783547',NULL,NULL,'Campos dos Goytacazes','38-74','Missouri','Brazil',NULL,NULL),(104,'Holly Page','(038116) 851505',NULL,NULL,'Flint','681424','Hatay','Singapore',NULL,NULL),(105,'Adrienne Clements','(0842) 97973195',NULL,NULL,'Anchorage','454343','Xīběi','Costa Rica',NULL,NULL),(106,'Oliver Wilkerson','(08453) 6132349',NULL,NULL,'Teruel','26765','West-Vlaanderen','Nigeria',NULL,NULL),(107,'Tamekah Moody','(036227) 737091',NULL,NULL,'Jaboatão dos Guararapes','15966','Orenburg Oblast','South Africa',NULL,NULL),(108,'Jesse Clay','(0409) 21853408',NULL,NULL,'Völkermarkt','43752','Argyllshire','Colombia',NULL,NULL),(109,'Amity Key','(0514) 56151861',NULL,NULL,'Villahermosa','67887','New South Wales','Philippines',NULL,NULL),(110,'Jamal Booth','(082) 22446223',NULL,NULL,'Keith','71082','Comunitat Valenciana','South Africa',NULL,NULL),(111,'April Compton','(035634) 422488',NULL,NULL,'Kurram Agency','773421','Friuli-Venezia Giulia','Philippines',NULL,NULL),(112,'Preston Hull','(021) 83713197',NULL,NULL,'Nagar','61945','Małopolskie','Spain',NULL,NULL),(113,'Quail Duke','(04914) 5688664',NULL,NULL,'Kumluca','42634-410','Rheinland-Pfalz','Austria',NULL,NULL),(114,'Reese Dotson','(038755) 638108',NULL,NULL,'San Rafael Abajo','21150','Mazowieckie','Austria',NULL,NULL),(115,'Kim Ball','(0414) 63635132',NULL,NULL,'Augsburg','114103','Rogaland','Australia',NULL,NULL),(116,'Macey Mann','(0636) 69687441',NULL,NULL,'Molde','21767','Irkutsk Oblast','Sweden',NULL,NULL),(117,'Summer Holmes','(068) 08558115',NULL,NULL,'Grand-Halleux','M6S 4CS','North Gyeongsang','Netherlands',NULL,NULL),(118,'Tatiana Crosby','(032) 82867862',NULL,NULL,'Barranca','7918','Central Region','Pakistan',NULL,NULL),(119,'Eaton Malone','(074) 88541759',NULL,NULL,'Pervomaisk','2196','Viken','Colombia',NULL,NULL),(120,'Carol Savage','(029) 30764026',NULL,NULL,'Buner','97132','Toscana','India',NULL,NULL),(121,'Sage Estrada','(06425) 2341152',NULL,NULL,'Cumaribo','53425','Arequipa','Spain',NULL,NULL),(122,'Jermaine Stout','(0171) 82073427',NULL,NULL,'Dordrecht','338210','Himachal Pradesh','Austria',NULL,NULL),(123,'Jenette Young','(038546) 866217',NULL,NULL,'Aurora','6875','Zuid Holland','Sweden',NULL,NULL),(124,'Shafira Mcbride','(031488) 873764',NULL,NULL,'Griesheim','163353','Maule','Costa Rica',NULL,NULL),(125,'Ifeoma Watts','(034) 41453747',NULL,NULL,'Saint-Lô','6936','Corse','Ireland',NULL,NULL),(126,'Allen Lott','(08800) 7434683',NULL,NULL,'Bhimber','T7 1QV','Gävleborgs län','Australia',NULL,NULL),(127,'Hop Marsh','(05254) 1866670',NULL,NULL,'Cork','267783','Zaporizhzhia oblast','South Korea',NULL,NULL),(128,'Daquan Watkins','(0083) 72106569',NULL,NULL,'Jilin','47479','Lower Austria','France',NULL,NULL),(129,'Janna Rivera','(039577) 804738',NULL,NULL,'Pinkafeld','02748','Utrecht','Spain',NULL,NULL),(130,'Fiona Kirby','(031693) 468334',NULL,NULL,'Katihar','64-490','Chernihiv oblast','Vietnam',NULL,NULL),(131,'Clark Flowers','(036047) 315575',NULL,NULL,'Lugo','174421','Veneto','South Africa',NULL,NULL),(132,'Galena Head','(09062) 7483351',NULL,NULL,'Koekelberg','873270','Alberta','South Africa',NULL,NULL),(133,'Kalia Woodward','(0417) 56250098',NULL,NULL,'Palu','2715','Île-de-France','South Korea',NULL,NULL),(134,'Price Abbott','(021) 58754434',NULL,NULL,'Doetinchem','17-806','Lubuskie','Singapore',NULL,NULL),(135,'Chadwick Macias','(0168) 41506558',NULL,NULL,'Querétaro','2732','Guanacaste','Germany',NULL,NULL),(136,'Jordan Foreman','(065) 49817753',NULL,NULL,'Osogbo','74294','Junín','Indonesia',NULL,NULL),(137,'Conan Davidson','(0216) 26527376',NULL,NULL,'Cartago','62779','Lombardia','Chile',NULL,NULL),(138,'Whoopi Gonzales','(04393) 1582514',NULL,NULL,'Murcia','42528','Tamaulipas','Norway',NULL,NULL),(139,'Yetta Maddox','(0763) 78680185',NULL,NULL,'Oslo','5485','Penza Oblast','Belgium',NULL,NULL),(140,'McKenzie Padilla','(038468) 713492',NULL,NULL,'Puntarenas','47-608','North Island','Spain',NULL,NULL),(141,'Scarlett Black','(037) 75218430',NULL,NULL,'Finspång','846654','Troms og Finnmark','Poland',NULL,NULL),(142,'Wendy Ballard','(0180) 56248936',NULL,NULL,'Alto Baudó','752390','Balochistan','Norway',NULL,NULL),(143,'Lamar Sparks','(039315) 984814',NULL,NULL,'Rigolet','143512','Innlandet','Pakistan',NULL,NULL),(144,'Natalie Chavez','(032649) 392486',NULL,NULL,'Córdoba','6534','Sikkim','China',NULL,NULL),(145,'Linda Zimmerman','(038446) 666644',NULL,NULL,'Dordrecht','827468','Extremadura','Canada',NULL,NULL),(146,'Jesse Maddox','(02096) 3866462',NULL,NULL,'Ulsan','9711','Kerala','Austria',NULL,NULL),(147,'Kieran Mack','(01581) 8622458',NULL,NULL,'Fortaleza','11612','Antofagasta','Canada',NULL,NULL),(148,'Vivien Hopkins','(037711) 302337',NULL,NULL,'Mykolaiv','536586','Ulster','Indonesia',NULL,NULL),(149,'Vaughan Roy','(0517) 85433535',NULL,NULL,'Western Islands','642550','La Libertad','France',NULL,NULL),(150,'Macon Beard','(037429) 421372',NULL,NULL,'Velden am Wörther See','5352','FATA','Sweden',NULL,NULL),(151,'Uriel Jefferson','(055) 10808144',NULL,NULL,'Camaçari','57744','Ogun','Brazil',NULL,NULL),(152,'Jolene Santos','(052) 16672738',NULL,NULL,'Bedok','047444','Innlandet','Spain',NULL,NULL),(153,'Scott Vang','(032480) 791347',NULL,NULL,'Tongyeong','437651','Eastern Visayas','Brazil',NULL,NULL),(154,'Heather Beck','(033113) 228754',NULL,NULL,'Emalahleni','2207','Imo','Canada',NULL,NULL),(155,'Mona Watts','(040) 20628864',NULL,NULL,'Lviv','190776','Gangwon','United States',NULL,NULL),(156,'Astra Ramos','(08672) 2765885',NULL,NULL,'San Marcos','7265','Mykolaiv oblast','United States',NULL,NULL),(157,'Elliott Whitfield','(08263) 2201318',NULL,NULL,'Rockhampton','584012','Caithness','Italy',NULL,NULL),(158,'Ulric Macdonald','(0586) 88674735',NULL,NULL,'Kiện Khê','6888','Brussels Hoofdstedelijk Gewest','Indonesia',NULL,NULL),(159,'Evelyn Atkinson','(09878) 8707189',NULL,NULL,'Mohmand Agency','35669','Piura','Italy',NULL,NULL),(160,'Abraham Fowler','(0359) 68734398',NULL,NULL,'Tapachula','43368','Møre og Romsdal','Turkey',NULL,3),(161,'Austin Mccoy','(014) 50648948',NULL,NULL,'Waardamme','2855','Salzburg','United States',NULL,NULL),(162,'Cooper Reese','(038725) 648281',NULL,NULL,'Sogamoso','07514','Kayseri','South Korea',NULL,NULL),(163,'Joelle Talley','(0578) 15229445',NULL,NULL,'Nogales','86-75','Western Australia','Philippines',NULL,NULL),(164,'Tyrone Dunn','(0446) 54854831',NULL,NULL,'Jakarta','6332','Vestfold og Telemark','Vietnam',NULL,NULL),(165,'Tate Key','(09393) 4134628',NULL,NULL,'Blankenfelde-Mahlow','73322','Puno','Canada',NULL,NULL),(166,'Mia Robertson','(075) 70800557',NULL,NULL,'Van','81135','Central Java','United Kingdom',NULL,NULL),(167,'Dustin Guthrie','(00264) 0108268',NULL,NULL,'Davao City','53767','Saratov Oblast','South Korea',NULL,NULL),(168,'Abraham Potts','(0963) 54984856',NULL,NULL,'Seogwipo','723677','Manitoba','Netherlands',NULL,NULL),(169,'Jeanette Franklin','(0137) 50739758',NULL,NULL,'Changi','747335','La Guajira','New Zealand',NULL,NULL),(170,'Andrew Mclaughlin','(051) 76254214',NULL,NULL,'Belém','31664','Sokoto','Philippines',NULL,NULL),(171,'Willow Cline','(07269) 4882732',NULL,NULL,'Bama','28379','Ogun','United Kingdom',NULL,NULL),(172,'Shelly Coleman','(0451) 33733764',NULL,NULL,'Innsbruck','47163','North Region','Russian Federation',NULL,NULL),(173,'Rogan Small','(0134) 51679626',NULL,NULL,'SŽlange','46587','South Sulawesi','South Africa',NULL,NULL),(174,'Eve Kline','(035) 28340355',NULL,NULL,'Wonju','14867','Pernambuco','Russian Federation',NULL,NULL),(175,'Remedios Cruz','(050) 80434097',NULL,NULL,'Paço do Lumiar','678676','Lviv oblast','Brazil',NULL,NULL),(176,'Arthur Wolfe','(0775) 40298172',NULL,NULL,'Maryborough','64765','Gangwon','Sweden',NULL,NULL),(177,'Julie Gallagher','(0242) 02576795',NULL,NULL,'Bergen','8838','Nova Scotia','Sweden',NULL,NULL),(178,'Martin Tanner','(032717) 675616',NULL,NULL,'Itapipoca','72244','Rivers','Russian Federation',NULL,NULL),(179,'Prescott Carver','(062) 72580655',NULL,NULL,'Wanaka','7764','Styria','Italy',NULL,NULL),(180,'Stone Cooper','(036194) 412353',NULL,NULL,'Upper Hutt','33483','Møre og Romsdal','Italy',NULL,NULL),(181,'Preston Mcpherson','(0615) 36317147',NULL,NULL,'Konstanz','08727','Nariño','Poland',NULL,NULL),(182,'Warren Robles','(031521) 948826',NULL,NULL,'Chepén','882037','Leinster','Nigeria',NULL,NULL),(183,'Benjamin Banks','(097) 85580244',NULL,NULL,'Campochiaro','860187','Lazio','Sweden',NULL,2),(184,'Tate Pickett','(035314) 193256',NULL,NULL,'Inner Mongolia','56218','Western Cape','New Zealand',NULL,NULL),(185,'Nero Noble','(023) 35426644',NULL,NULL,'Astore','4975','Free State','Philippines',NULL,NULL),(186,'Jasper Mcguire','(026) 35112461',NULL,NULL,'Villahermosa','372498','Goiás','New Zealand',NULL,NULL),(187,'Leandra Bell','(037266) 770887',NULL,NULL,'Redlands','12217','Guanacaste','Turkey',NULL,NULL),(188,'Cruz Buck','(032565) 423974',NULL,NULL,'İmamoğlu','1524','Belgorod Oblast','Mexico',NULL,NULL),(189,'Quinlan Estrada','(038) 31171346',NULL,NULL,'Darıca','154225','Gorontalo','France',NULL,NULL),(190,'Dylan Padilla','(037736) 182864',NULL,NULL,'Liaoning','3431','Huáběi','Chile',NULL,NULL),(191,'Christine Horton','(0376) 32376244',NULL,NULL,'St. Catharines','8177','Melilla','Sweden',NULL,NULL),(192,'Brody May','(038) 98447846',NULL,NULL,'Futaleufú','341312','Puntarenas','Spain',NULL,NULL),(193,'Doris Velez','(031) 78751218',NULL,NULL,'Santa Maria','25237','Jeju','South Korea',NULL,NULL),(194,'Unity Walters','(038176) 702773',NULL,NULL,'Dutse','7095','Eastern Visayas','Ireland',NULL,NULL),(195,'Courtney Wall','(0835) 16727868',NULL,NULL,'Falun','154473','Principado de Asturias','Colombia',NULL,NULL),(196,'Rae Castillo','(0392) 42824666',NULL,NULL,'Thames','Y7E 6H6','Northwest Territories','Costa Rica',NULL,NULL),(197,'Fitzgerald Lane','(0777) 90203647',NULL,NULL,'Wels','50514','Quebec','New Zealand',NULL,NULL),(198,'Winter Rivers','(088) 93220472',NULL,NULL,'Santarém','41627','Katsina','China',NULL,NULL),(199,'Winifred Key','(032526) 378050',NULL,NULL,'Çaldıran','00671','North Island','Colombia',NULL,NULL),(200,'Chantale Bender','(035825) 499340',NULL,NULL,'Marina East','6692','Rogaland','Philippines',NULL,NULL),(201,'Janna Dale','(04513) 3585320',NULL,NULL,'Da Lat','616131','San Andrés y Providencia','France',NULL,NULL),(202,'Kennan Goodman','(0117) 76118127',NULL,NULL,'Huasco','24197','South Sulawesi','Mexico',NULL,NULL),(203,'Aidan Campos','(046) 53317934',NULL,NULL,'Kimberley','791926','Puntarenas','Colombia',NULL,NULL),(204,'Drew Watkins','(058) 44327544',NULL,NULL,'Cambridge','430468','Tuyên Quang','United States',NULL,NULL),(205,'Bevis Goodwin','(0694) 45478654',NULL,NULL,'Finspång','4683','Cagayan Valley','Austria',NULL,NULL),(206,'Julian Little','(05385) 5795468',NULL,NULL,'Cajamarca','41318','Innlandet','Singapore',NULL,NULL),(207,'Jorden Cooke','(037274) 515265',NULL,NULL,'Merrickville-Wolford','3525','Nordland','Sweden',NULL,NULL),(208,'Jordan Walters','(035131) 139161',NULL,NULL,'Cumberland County','342271','Castilla y León','Ukraine',NULL,NULL),(209,'Price Harding','(04589) 7294464',NULL,NULL,'La Plata','67663','Heredia','India',NULL,NULL),(210,'Harlan Moore','(031) 22458613',NULL,NULL,'Alingsås','27755-309','North-East Region','Belgium',NULL,NULL),(211,'Laith Hurst','(039006) 764458',NULL,NULL,'Crato','03608','Vienna','Vietnam',NULL,NULL),(212,'Reece Patel','(038543) 219074',NULL,NULL,'New Haven','83311','Ulster','Mexico',NULL,NULL),(213,'Briar Buckner','(09792) 7172620',NULL,NULL,'Launceston','874437','Connecticut','Pakistan',NULL,NULL),(214,'Marah Melendez','(033626) 237438',NULL,NULL,'Beausejour','768875','Illes Balears','Brazil',NULL,NULL),(215,'May Frederick','(033734) 556375',NULL,NULL,'Yurimaguas','35722','Niedersachsen','United Kingdom',NULL,NULL),(216,'Camilla Villarreal','(037938) 624792',NULL,NULL,'Cork','86535','Connacht','Norway',NULL,NULL),(217,'Montana Holloway','(0572) 62568676',NULL,NULL,'Cape Breton Island','445211','Liguria','France',NULL,NULL),(218,'Macey Rojas','(01840) 0625832',NULL,NULL,'Tame','3435','Troms og Finnmark','Turkey',NULL,NULL),(219,'Xanthus Butler','(085) 34922576',NULL,NULL,'Gaziantep','V6F 1EZ','Guanacaste','Netherlands',NULL,NULL),(220,'Kenyon Ashley','(05475) 4183969',NULL,NULL,'Annapolis','99780','East Lothian','Pakistan',NULL,NULL),(221,'Joan Mccormick','(036262) 573561',NULL,NULL,'Tandag','217174','Nordrhein-Westphalen','Canada',NULL,NULL),(222,'Xena Forbes','(038521) 106732',NULL,NULL,'Lapu-Lapu City','33677','Colorado','Spain',NULL,NULL),(223,'Carlos Weber','(05325) 0775754',NULL,NULL,'Denver','14215','West Nusa Tenggara','Ukraine',NULL,NULL),(224,'Thomas Edwards','(031516) 302773',NULL,NULL,'Itanagar','15913','South Gyeongsang','Vietnam',NULL,NULL),(225,'Rashad Huber','(03110) 5527277',NULL,NULL,'Mỹ Tho','15-22','Iowa','Sweden',NULL,NULL),(226,'Lunea Estrada','(050) 20483087',NULL,NULL,'Penza','16695','Östergötlands län','India',NULL,NULL),(227,'Gray Hartman','(07966) 5553423',NULL,NULL,'Kurgan','8783 HO','Sląskie','South Korea',NULL,NULL),(228,'Charissa Blair','(039648) 628344',NULL,NULL,'Le Havre','866820','Leinster','Sweden',NULL,NULL),(229,'Ray Lamb','(088) 95509294',NULL,NULL,'Tierra Amarilla','87238','West Papua','Norway',NULL,NULL),(230,'Orlando David','(085) 64336407',NULL,NULL,'Ambon','799711','New Brunswick','Australia',NULL,NULL),(231,'Benedict Haley','(01496) 3047157',NULL,NULL,'Denpasar','16268','Benue','Brazil',NULL,NULL),(232,'Chanda Buck','(0448) 56419374',NULL,NULL,'Ceuta','8786-9332','Oryol Oblast','Germany',NULL,NULL),(233,'Naida Owen','(0842) 62199886',NULL,NULL,'Maracanaú','61944','Special Region of Yogyakarta','Norway',NULL,NULL),(234,'Tate Horne','(056) 25404341',NULL,NULL,'Hamburg','050565','Minnesota','Indonesia',NULL,NULL),(235,'Willa Morse','(077) 39454338',NULL,NULL,'Nizhyn','474326','Swiętokrzyskie','Vietnam',NULL,NULL),(236,'Cameron Monroe','(035) 64136416',NULL,NULL,'Fort Collins','938852','Zamboanga Peninsula','Germany',NULL,NULL),(237,'Mary Garcia','(005) 36688573',NULL,NULL,'Neder-Over-Heembeek','68-68','Balochistan','Peru',NULL,NULL),(238,'Kimberly Holden','(026) 76936181',NULL,NULL,'Erlangen','7352','Victoria','Austria',NULL,NULL),(239,'Kevyn Shaw','(0244) 44873647',NULL,NULL,'Dublin','05487-63851','Baden Württemberg','Turkey',NULL,NULL),(240,'Elliott Whitfield','(071) 24496177',NULL,NULL,'Attimis','57-378','West Java','Colombia',NULL,NULL),(241,'Oleg Davis','(03746) 3862848',NULL,NULL,'Moelv','27351','Jönköpings län','Vietnam',NULL,NULL),(242,'Mufutau Mooney','(045) 03816757',NULL,NULL,'Steinkjer','810218','Jigawa','South Africa',NULL,NULL),(243,'Renee Travis','(061) 58285021',NULL,NULL,'Nizhny','0381-8625','Texas','United States',NULL,NULL),(244,'Ivana Clemons','(058) 71703484',NULL,NULL,'Lörrach','574110','Huáběi','New Zealand',NULL,NULL),(245,'Galvin Perez','(0308) 62621566',NULL,NULL,'Charlottetown','409535','Gorontalo','China',NULL,NULL),(246,'Abigail Neal','(06230) 1684223',NULL,NULL,'Tuy Hòa','547367','Bangsamoro','Belgium',NULL,3),(247,'Liberty Larson','(048) 16136742',NULL,NULL,'Odendaalsrus','66455','Tây Ninh','Ireland',NULL,NULL),(248,'Shafira Mcmillan','(09952) 7897804',NULL,NULL,'Dir','779187','Tula Oblast','Austria',NULL,NULL),(249,'Priscilla Stanley','(0679) 26068871',NULL,NULL,'Galway','171343','Ulster','Spain',NULL,NULL),(250,'Boris Alvarado','(02254) 1524986',NULL,NULL,'Raufoss','5813','Kinross-shire','Netherlands',NULL,NULL),(251,'Brennan Booker','(09292) 2942578',NULL,NULL,'Waterbury','64874','Riau Islands','United States',NULL,NULL),(252,'Jacob Booker','(0558) 29143328',NULL,NULL,'Bostaniçi','3387','New South Wales','Costa Rica',NULL,NULL),(253,'Logan Bray','(085) 77527803',NULL,NULL,'Albury','82020','Mississippi','China',NULL,NULL),(254,'Brianna Fitzpatrick','(0091) 33644131',NULL,NULL,'Zamość','20413','Leinster','Mexico',NULL,NULL),(255,'Alexa Hunt','(033731) 935243',NULL,NULL,'Quemchi','8282','Sachsen','Singapore',NULL,NULL),(256,'Kitra Reynolds','(037314) 057121',NULL,NULL,'Pachuca','03-738','Tamaulipas','Colombia',NULL,NULL),(257,'Whilemina Freeman','(01643) 4528514',NULL,NULL,'Badajoz','64526','Puno','Poland',NULL,NULL),(258,'Ashely Hogan','(02011) 3817864',NULL,NULL,'La Pintana','3123','Dōngběi','India',NULL,NULL),(259,'Kim Bernard','(031151) 526438',NULL,NULL,'Muradiye','39852','Soccsksargen','Colombia',NULL,NULL);
/*!40000 ALTER TABLE `azienda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contatto`
--

DROP TABLE IF EXISTS `contatto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contatto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(250) DEFAULT NULL,
  `cognome` varchar(250) DEFAULT NULL,
  `telefono` varchar(250) DEFAULT NULL,
  `id_azienda` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_contatto__azienda` (`id_azienda`),
  CONSTRAINT `FK_contatto__azienda` FOREIGN KEY (`id_azienda`) REFERENCES `azienda` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contatto`
--

LOCK TABLES `contatto` WRITE;
/*!40000 ALTER TABLE `contatto` DISABLE KEYS */;
INSERT INTO `contatto` VALUES (1,'Joël','Moix','12112',2);
/*!40000 ALTER TABLE `contatto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `impostazioni`
--

DROP TABLE IF EXISTS `impostazioni`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `impostazioni` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `default_modulo` int(11) DEFAULT NULL,
  `immagine_azienda` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_impostazioni__modulo` (`default_modulo`),
  CONSTRAINT `FK_impostazioni__modulo` FOREIGN KEY (`default_modulo`) REFERENCES `modulo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `impostazioni`
--

LOCK TABLES `impostazioni` WRITE;
/*!40000 ALTER TABLE `impostazioni` DISABLE KEYS */;
INSERT INTO `impostazioni` VALUES (2,1,'acme-logo.png');
/*!40000 ALTER TABLE `impostazioni` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modulo`
--

DROP TABLE IF EXISTS `modulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `modulo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `abilitato` tinyint(1) DEFAULT NULL,
  `icona` varchar(100) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modulo`
--

LOCK TABLES `modulo` WRITE;
/*!40000 ALTER TABLE `modulo` DISABLE KEYS */;
INSERT INTO `modulo` VALUES (0,'login',1,'',0),(1,'Azienda',1,'bi bi-building',0),(2,'Contatto',1,'bi bi-file-earmark-person-fill',0),(3,'Impostazioni',1,'bi bi-gear-wide-connected',1),(101,'Admin',1,'bi bi-terminal',1);
/*!40000 ALTER TABLE `modulo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utente`
--

DROP TABLE IF EXISTS `utente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `utente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(500) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `cognome` varchar(100) DEFAULT NULL,
  `dt_creazione` timestamp NULL DEFAULT current_timestamp(),
  `dt_last_login` timestamp NULL DEFAULT NULL,
  `admin` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utente`
--

LOCK TABLES `utente` WRITE;
/*!40000 ALTER TABLE `utente` DISABLE KEYS */;
INSERT INTO `utente` VALUES (2,'joelmoix','joel.jon@moix.me','$2y$10$KdI2Pz.Ctg8TKZCekO/MteU5kljY6cD0ugy65Iuy3N0WgK4xtUH86','Joel','Moix','2022-05-03 07:35:41','2022-05-05 09:05:48',1),(3,NULL,'verdi@pingi.ch','$2y$10$lfd4a8WzQ9JULakXB.50eOOQ9XQkDtri.lqZghsvjNZEYR57f/b32','Geronimo','Verdi','2022-05-03 13:21:08','2022-05-04 13:28:59',0);
/*!40000 ALTER TABLE `utente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'progetto_151'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-05 11:43:35
