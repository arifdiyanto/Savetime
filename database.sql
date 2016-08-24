/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.1.13-MariaDB : Database - sfdb
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `sample` */

CREATE TABLE `sample` (
  `kode` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `sample` */

insert  into `sample`(`kode`,`nama`,`created_date`) values ('A2','BBBccd12333u','2016-08-21 09:42:17'),('A3','edited','2016-08-21 07:03:15'),('ad1','ba\'`2','2016-08-18 10:31:55'),('ad13','ba\'`2','2016-08-18 10:31:57'),('yoyoyo','jajaja','2016-08-18 10:59:16');

/*Table structure for table `symenu` */

CREATE TABLE `symenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(30) COLLATE utf8_unicode_ci DEFAULT '',
  `note` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  `url` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  `parent` int(11) DEFAULT '0',
  `icon` varchar(30) COLLATE utf8_unicode_ci DEFAULT '',
  `isaktif` int(1) DEFAULT '1',
  `created_by` varchar(30) COLLATE utf8_unicode_ci DEFAULT '',
  `updated_by` varchar(30) COLLATE utf8_unicode_ci DEFAULT '',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `symenu` */

insert  into `symenu`(`id`,`label`,`note`,`url`,`parent`,`icon`,`isaktif`,`created_by`,`updated_by`,`created_at`,`updated_at`) values (1,'Master','','',0,'fa fa-folder-open',1,'','',NULL,NULL),(2,'Transaction','','',0,'fa fa-folder-open',1,'','',NULL,NULL),(3,'Report','','',0,'fa fa-folder-open',1,'','',NULL,NULL),(4,'System','','',0,'fa fa-folder-open',1,'','',NULL,NULL),(5,'User','','system/frm_user',4,'fa fa-user',1,'','',NULL,NULL),(6,'Sample','Sekedar Contoh Saja','sample/frm_sample',4,'fa fa-list',1,'','',NULL,NULL),(7,'Generator','Untuk menggenerate kode secara otomatis','sfgenerator/frm_sfgenerator',4,'fa fa-flash',1,'','',NULL,NULL);

/*Table structure for table `syuser` */

CREATE TABLE `syuser` (
  `userid` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(30) COLLATE utf8_unicode_ci DEFAULT '',
  `pass` varchar(64) COLLATE utf8_unicode_ci DEFAULT '',
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  `phone` varchar(30) COLLATE utf8_unicode_ci DEFAULT '',
  `url_img` text COLLATE utf8_unicode_ci,
  `gender` varchar(1) COLLATE utf8_unicode_ci DEFAULT '',
  `address` text COLLATE utf8_unicode_ci,
  `token` varchar(64) COLLATE utf8_unicode_ci DEFAULT '',
  `attr` text COLLATE utf8_unicode_ci,
  `isactive` int(1) DEFAULT '1',
  `created_by` varchar(15) COLLATE utf8_unicode_ci DEFAULT '',
  `updated_by` varchar(15) COLLATE utf8_unicode_ci DEFAULT '',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `syuser` */

insert  into `syuser`(`userid`,`username`,`pass`,`email`,`phone`,`url_img`,`gender`,`address`,`token`,`attr`,`isactive`,`created_by`,`updated_by`,`created_at`,`updated_at`) values ('0012369','Arif Diyanto','e774e1d7b11ac480f3f3b909ed0a9699','arifdiyantotmg@gmail.com','',NULL,'',NULL,'',NULL,1,'','',NULL,NULL),('demo','Arif Diyanto','fe01ce2a7fbac8fafaed7c982a04e229','arifdiyantotmg@gmail.com','095646456','','','','','',1,'','','0000-00-00 00:00:00','0000-00-00 00:00:00');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
