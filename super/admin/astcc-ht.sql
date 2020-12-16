-- MySQL dump 10.11
--
-- Host: localhost    Database: astcc
-- ------------------------------------------------------
-- Server version	5.0.32-Debian_7etch8-log

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
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
CREATE TABLE `brands` (
  `name` char(40) NOT NULL default '',
  `language` char(10) default NULL,
  `publishednum` char(40) default NULL,
  `did` char(40) default NULL,
  `markup` int(11) default NULL,
  `inc` int(11) default NULL,
  `fee` int(11) default NULL,
  `days` int(11) default NULL,
  PRIMARY KEY  (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES ('pp','fr','','',0,1,0,0);
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cards`
--

DROP TABLE IF EXISTS `cards`;
CREATE TABLE `cards` (
  `number` char(20) NOT NULL default '',
  `language` char(10) default NULL,
  `facevalue` int(11) default NULL,
  `used` int(11) NOT NULL default '0',
  `inc` int(11) NOT NULL default '0',
  `markup` int(11) NOT NULL default '0',
  `creation` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `firstuse` timestamp NOT NULL default '0000-00-00 00:00:00',
  `expiration` timestamp NOT NULL default '0000-00-00 00:00:00',
  `inuse` int(11) default NULL,
  `brand` char(40) default NULL,
  `nextfee` int(11) default NULL,
  `pin` int(11) default NULL,
  `nomcab` varchar(20) default NULL,
  PRIMARY KEY  (`number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cards`
--


--
-- Table structure for table `cdrs`
--

DROP TABLE IF EXISTS `cdrs`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `cdrs` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `cardnum` varchar(40) character set utf8 collate utf8_czech_ci default NULL,
  `callerid` varchar(80) character set utf8 collate utf8_czech_ci default NULL,
  `callednum` varchar(80) character set utf8 collate utf8_czech_ci default NULL,
  `trunk` varchar(40) character set utf8 collate utf8_czech_ci default NULL,
  `disposition` varchar(20) character set utf8 collate utf8_czech_ci default NULL,
  `billseconds` int(11) default NULL,
  `billcost` int(11) default NULL,
  `callstart` varchar(24) character set utf8 collate utf8_czech_ci default NULL,
  `datecall` datetime default '0000-00-00 00:00:00',
  `includedseconds` int(11) default '0',
  `routecost` int(11) default NULL,
  `comment` varchar(40) default NULL,
  `opcost` varchar(80) collate utf8_czech_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3020 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `cdrs`
--

LOCK TABLES `cdrs` WRITE;
/*!40000 ALTER TABLE `cdrs` DISABLE KEYS */;
/*!40000 ALTER TABLE `cdrs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cdrs_buff`
--

DROP TABLE IF EXISTS `cdrs_buff`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `cdrs_buff` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `cardnum` varchar(40) collate utf8_czech_ci default NULL,
  `callerid` varchar(80) collate utf8_czech_ci default NULL,
  `callednum` varchar(80) collate utf8_czech_ci default NULL,
  `trunk` varchar(40) collate utf8_czech_ci default NULL,
  `disposition` varchar(20) collate utf8_czech_ci default NULL,
  `billseconds` int(11) default NULL,
  `billcost` int(11) default NULL,
  `callstart` int(11) default NULL,
  `datecall` datetime NOT NULL default '0000-00-00 00:00:00',
  `comment` varchar(40) collate utf8_czech_ci default NULL,
  `opcost` varchar(80) collate utf8_czech_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1942 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `cdrs_buff`
--

LOCK TABLES `cdrs_buff` WRITE;
/*!40000 ALTER TABLE `cdrs_buff` DISABLE KEYS */;
/*!40000 ALTER TABLE `cdrs_buff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cdrs_last`
--

DROP TABLE IF EXISTS `cdrs_last`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `cdrs_last` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `cardnum` varchar(40) default NULL,
  `callerid` varchar(80) default NULL,
  `callednum` varchar(80) default NULL,
  `trunk` varchar(40) default NULL,
  `disposition` varchar(20) default NULL,
  `billseconds` int(11) default NULL,
  `billcost` int(11) default NULL,
  `callstart` int(11) default NULL,
  `datecall` datetime default '0000-00-00 00:00:00',
  `comment` varchar(40) default NULL,
  `opcost` varchar(80) collate utf8_czech_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1979 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `cdrs_last`
--

LOCK TABLES `cdrs_last` WRITE;
/*!40000 ALTER TABLE `cdrs_last` DISABLE KEYS */;
/*!40000 ALTER TABLE `cdrs_last` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cumul`
--

DROP TABLE IF EXISTS `cumul`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `cumul` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `cardnum` varchar(40) collate utf8_czech_ci default NULL,
  `callerid` varchar(80) collate utf8_czech_ci default NULL,
  `callednum` varchar(80) collate utf8_czech_ci default NULL,
  `trunk` varchar(40) collate utf8_czech_ci default NULL,
  `disposition` varchar(20) collate utf8_czech_ci default NULL,
  `billseconds` int(11) default NULL,
  `billcost` int(11) default NULL,
  `callstart` int(11) default NULL,
  `datecall` datetime NOT NULL default '0000-00-00 00:00:00',
  `comment` varchar(40) collate utf8_czech_ci default NULL,
  `opcost` varchar(80) collate utf8_czech_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1942 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `cumul`
--

LOCK TABLES `cumul` WRITE;
/*!40000 ALTER TABLE `cumul` DISABLE KEYS */;
/*!40000 ALTER TABLE `cumul` ENABLE KEYS */;
UNLOCK TABLES;

-- Table structure for table `routes`
--

DROP TABLE IF EXISTS `routes`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `routes` (
  `pattern` varchar(40) NOT NULL default '',
  `comment` varchar(80) default NULL,
  `trunks` varchar(180) default NULL,
  `connectcost` int(11) NOT NULL default '0',
  `includedseconds` int(11) NOT NULL default '0',
  `ek` int(11) NOT NULL default '0',
  `cost` int(11) NOT NULL default '0',
  `opcc` int(11) NOT NULL default '0',
  `opsecinc` int(11) NOT NULL default '0',
  `oppal` int(11) NOT NULL default '1',
  PRIMARY KEY  (`pattern`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `routes`
--

--
-- Table structure for table `trunks`
--

DROP TABLE IF EXISTS `trunks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trunks` (
  `name` char(40) NOT NULL DEFAULT '',
  `tech` char(10) DEFAULT NULL,
  `path` char(40) NOT NULL DEFAULT '',
  `prefix` char(10) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trunks`
--

LOCK TABLES `trunks` WRITE;
/*!40000 ALTER TABLE `trunks` DISABLE KEYS */;
/*!40000 ALTER TABLE `trunks` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Table structure for table `webadmins`
--

DROP TABLE IF EXISTS `webadmins`;
CREATE TABLE `webadmins` (
  `admin_id` int(10) unsigned NOT NULL auto_increment,
  `admin_username` tinytext,
  `admin_password` tinytext,
  `admin_status` set('1','0') default '0',
  `websession` varchar(255) default NULL,
  `lastlogin` datetime default '0000-00-00 00:00:00',
  `created` datetime default '0000-00-00 00:00:00',
  `admin_vorname` varchar(150) default NULL,
  `admin_nachname` tinytext,
  `admin_firma` tinytext,
  `admin_strasse` tinytext,
  `admin_adresszusatz` tinytext,
  `admin_hausnr` tinytext,
  `admin_plz` tinytext,
  `admin_ort` tinytext,
  `admin_gebdat` date default '0000-00-00',
  `admin_email` tinytext,
  `admin_telefon` tinytext,
  `admin_ip` tinytext,
  PRIMARY KEY  (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Table structure for table `dynacab`
--

DROP TABLE IF EXISTS `dynacab`;
CREATE TABLE `dynacab` (
  `id` int(24) NOT NULL auto_increment,
  `cardnumo` varchar(24) default NULL,
  `timeo` int(24) default NULL,
  `callednumo` varchar(24) default NULL,
  `commento` varchar(40) default NULL,
  `costo` int(24) default NULL,
  `connectcosto` int(24) default NULL,
  `includedsecondso` int(24) default NULL,
  `dispositiono` varchar(24) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dynacab`
--

LOCK TABLES `dynacab` WRITE;
/*!40000 ALTER TABLE `dynacab` DISABLE KEYS */;
/*!40000 ALTER TABLE `dynacab` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `webadmins`
--

LOCK TABLES `webadmins` WRITE;
/*!40000 ALTER TABLE `webadmins` DISABLE KEYS */;
/*!40000 ALTER TABLE `webadmins` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Table structure for table `cyber_compta`
--

DROP TABLE IF EXISTS `cyber_compta`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `cyber_compta` (
  `time` varchar(20) default NULL,
  `price` varchar(20) default NULL,
  `ip` varchar(20) default NULL,
  `date` varchar(20) default NULL,
  `id` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=131 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `cyber_compta`
--

LOCK TABLES `cyber_compta` WRITE;
/*!40000 ALTER TABLE `cyber_compta` DISABLE KEYS */;
/*!40000 ALTER TABLE `cyber_compta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cyber_custom`
--

DROP TABLE IF EXISTS `cyber_custom`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `cyber_custom` (
  `id` int(25) NOT NULL auto_increment,
  `login` varchar(25) NOT NULL,
  `pass` varchar(25) NOT NULL,
  `time` varchar(25) default NULL,
  `start` varchar(25) default NULL,
  `stop` varchar(25) default NULL,
  `ip` varchar(25) default NULL,
  `typabo` varchar(25) default NULL,
  `client` varchar(25) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `cyber_custom`
--

LOCK TABLES `cyber_custom` WRITE;
/*!40000 ALTER TABLE `cyber_custom` DISABLE KEYS */;
/*!40000 ALTER TABLE `cyber_custom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cyber_network`
--

DROP TABLE IF EXISTS `cyber_network`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `cyber_network` (
  `name` varchar(25) NOT NULL,
  `ip` varchar(25) NOT NULL,
  `state` tinyint(2) NOT NULL,
  `start` varchar(25) default NULL,
  `id` int(11) NOT NULL auto_increment,
  `cron` tinyint(4) NOT NULL default '0',
  `stop` varchar(25) default NULL,
  `remaintime` varchar(25) default NULL,
  `ping` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `cyber_network`
--

LOCK TABLES `cyber_network` WRITE;
/*!40000 ALTER TABLE `cyber_network` DISABLE KEYS */;
/*!40000 ALTER TABLE `cyber_network` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cyber_tarif`
--

DROP TABLE IF EXISTS `cyber_tarif`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `cyber_tarif` (
  `id` int(11) NOT NULL auto_increment,
  `pal1p` varchar(20) default NULL,
  `pal1t` varchar(20) default NULL,
  `pal1d` varchar(20) default NULL,
  `pal2p` varchar(20) default NULL,
  `pal2t` varchar(20) default NULL,
  `pal2d` varchar(20) default NULL,
  `pal3p` varchar(20) default NULL,
  `pal3t` varchar(20) default NULL,
  `pal3d` varchar(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `cyber_tarif`
--

LOCK TABLES `cyber_tarif` WRITE;
/*!40000 ALTER TABLE `cyber_tarif` DISABLE KEYS */;
INSERT INTO `cyber_tarif` VALUES (1,'1','30','30','0.0333333333333','1','1',NULL,NULL,NULL);
/*!40000 ALTER TABLE `cyber_tarif` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gensale`
--

DROP TABLE IF EXISTS `gensale`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `gensale` (
  `id` int(30) NOT NULL auto_increment,
  `date` date default NULL,
  `cabs` varchar(20) default NULL,
  `cabp` varchar(20) default NULL,
  `cybs` varchar(20) default NULL,
  `cybp` varchar(20) default NULL,
  `pros` varchar(20) default NULL,
  `prop` varchar(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `gensale`
--

LOCK TABLES `gensale` WRITE;
/*!40000 ALTER TABLE `gensale` DISABLE KEYS */;
/*!40000 ALTER TABLE `gensale` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mycat`
--

DROP TABLE IF EXISTS `mycat`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mycat` (
  `id` tinyint(10) NOT NULL default '1',
  `description` varchar(30) default NULL,
  `icone` varchar(30) default NULL,
  `dive` varchar(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mycat`
--

LOCK TABLES `mycat` WRITE;
/*!40000 ALTER TABLE `mycat` DISABLE KEYS */;
/*!40000 ALTER TABLE `mycat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mysale`
--

DROP TABLE IF EXISTS `mysale`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mysale` (
  `id` int(50) NOT NULL auto_increment,
  `nom` varchar(50) default NULL,
  `achat` varchar(15) default NULL,
  `vente` varchar(15) default NULL,
  `cat` int(11) default NULL,
  `date` datetime default '0000-00-00 00:00:00',
  `unid` varchar(30) default NULL,
  `cyber` varchar(20) default NULL,
  `cabine` varchar(20) default NULL,
  `billed` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=203 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mysale`
--

LOCK TABLES `mysale` WRITE;
/*!40000 ALTER TABLE `mysale` DISABLE KEYS */;
/*!40000 ALTER TABLE `mysale` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mysale_buff`
--

DROP TABLE IF EXISTS `mysale_buff`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mysale_buff` (
  `id` int(50) NOT NULL auto_increment,
  `nom` varchar(50) default NULL,
  `achat` varchar(15) default NULL,
  `vente` varchar(15) default NULL,
  `cat` int(11) default NULL,
  `date` datetime default '0000-00-00 00:00:00',
  `unid` varchar(30) default NULL,
  `cyber` varchar(20) default NULL,
  `cabine` varchar(20) default NULL,
  `billed` tinyint(4) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mysale_buff`
--

LOCK TABLES `mysale_buff` WRITE;
/*!40000 ALTER TABLE `mysale_buff` DISABLE KEYS */;
/*!40000 ALTER TABLE `mysale_buff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mystock`
--

DROP TABLE IF EXISTS `mystock`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mystock` (
  `id` tinyint(4) NOT NULL auto_increment,
  `nom` varchar(30) default NULL,
  `achat` varchar(15) default NULL,
  `vente` varchar(15) default NULL,
  `cat` varchar(30) default NULL,
  `stock` int(11) default NULL,
  `color` varchar(15) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `mystock`
--

LOCK TABLES `mystock` WRITE;
/*!40000 ALTER TABLE `mystock` DISABLE KEYS */;
/*!40000 ALTER TABLE `mystock` ENABLE KEYS */;
UNLOCK TABLES;


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2009-03-05 12:13:32
