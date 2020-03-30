-- MySQL dump 10.13  Distrib 5.7.26, for Win64 (x86_64)
--
-- Host: localhost    Database: bug.com
-- ------------------------------------------------------
-- Server version	5.7.26

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
-- Table structure for table `lizhili_admin`
--

DROP TABLE IF EXISTS `lizhili_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lizhili_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL COMMENT '1代表bug提交者，2代表修改者',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `isopen` tinyint(1) DEFAULT '1',
  `desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='这个是，用户登陆表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lizhili_admin`
--

LOCK TABLES `lizhili_admin` WRITE;
/*!40000 ALTER TABLE `lizhili_admin` DISABLE KEYS */;
INSERT INTO `lizhili_admin` VALUES (1,'李志立','a3f17ee3685c44216eed0724f0c717c2',2,1585535082,1585535082,1,'我是运维人员'),(2,'李志立1','a3f17ee3685c44216eed0724f0c717c2',1,1585535101,1585535101,1,'我是测试人员');
/*!40000 ALTER TABLE `lizhili_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lizhili_admin_item`
--

DROP TABLE IF EXISTS `lizhili_admin_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lizhili_admin_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `itemid` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lizhili_admin_item`
--

LOCK TABLES `lizhili_admin_item` WRITE;
/*!40000 ALTER TABLE `lizhili_admin_item` DISABLE KEYS */;
INSERT INTO `lizhili_admin_item` VALUES (1,1,1,1585535082,1585535082),(2,2,1,1585535101,1585535101);
/*!40000 ALTER TABLE `lizhili_admin_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lizhili_bug`
--

DROP TABLE IF EXISTS `lizhili_bug`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lizhili_bug` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `level` tinyint(1) DEFAULT NULL COMMENT '1重要紧急，2紧急，3,重要，4微小',
  `res` tinyint(1) DEFAULT '0' COMMENT '0尚未解决，1设计如此，2外部原因，3,已解决，4无法重现，5延期解决，6不予解决',
  `res_time` int(11) DEFAULT NULL COMMENT '处理时间',
  `res_uid` int(11) DEFAULT NULL COMMENT 'bug修改者id',
  `res_text` varchar(255) DEFAULT NULL,
  `bug_text` text,
  `bug_time` int(11) DEFAULT NULL COMMENT '提交bug时间',
  `bug_uid` int(11) DEFAULT NULL COMMENT 'bug提交者',
  `iswan` tinyint(4) DEFAULT '0' COMMENT '是否已经完成',
  `on` int(255) DEFAULT NULL COMMENT '编号',
  `itemid` int(255) DEFAULT NULL COMMENT '所属项目',
  `ischu` tinyint(1) DEFAULT '0' COMMENT '1处理状态，现在是否是处理状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lizhili_bug`
--

LOCK TABLES `lizhili_bug` WRITE;
/*!40000 ALTER TABLE `lizhili_bug` DISABLE KEYS */;
INSERT INTO `lizhili_bug` VALUES (1,'首页显示不正常',1,3,1585535272,1,'已经解决','<br><br>[步骤]<br><img src=\"/storage/topic/20200330/7b5c282648bb1e7f854b57512aed3e45.jpg\" alt=\"\"><br><br>[结果]<br><br><br>[期望]<br><br><br>',1585535245,2,0,1001,1,1);
/*!40000 ALTER TABLE `lizhili_bug` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lizhili_item`
--

DROP TABLE IF EXISTS `lizhili_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lizhili_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lizhili_item`
--

LOCK TABLES `lizhili_item` WRITE;
/*!40000 ALTER TABLE `lizhili_item` DISABLE KEYS */;
INSERT INTO `lizhili_item` VALUES (1,'专财网',1585272704,1585535004,'财务管理网站，APP');
/*!40000 ALTER TABLE `lizhili_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lizhili_manage`
--

DROP TABLE IF EXISTS `lizhili_manage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lizhili_manage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `isopen` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lizhili_manage`
--

LOCK TABLES `lizhili_manage` WRITE;
/*!40000 ALTER TABLE `lizhili_manage` DISABLE KEYS */;
INSERT INTO `lizhili_manage` VALUES (1,'admin','a3f17ee3685c44216eed0724f0c717c2',1);
/*!40000 ALTER TABLE `lizhili_manage` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-03-30 10:34:03
