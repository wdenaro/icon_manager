# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: craftbostondb.czctodagdzsc.us-east-1.rds.amazonaws.com (MySQL 5.6.40-log)
# Database: l_app_reorder_app_icon_manager
# Generation Time: 2019-06-14 21:30:25 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table batch_info
# ------------------------------------------------------------

DROP TABLE IF EXISTS `batch_info`;

CREATE TABLE `batch_info` (
  `batch_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) DEFAULT NULL,
  `priority` int(5) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`batch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `batch_info` WRITE;
/*!40000 ALTER TABLE `batch_info` DISABLE KEYS */;

INSERT INTO `batch_info` (`batch_id`, `name`, `priority`, `created_at`)
VALUES
	(1,'First Batch of SKUS.xlsx',1,'2019-06-03 18:09:40'),
	(2,'Second Batch of SKUS.xls',2,'2019-06-03 18:10:13');

/*!40000 ALTER TABLE `batch_info` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `category_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) DEFAULT NULL,
  `active` int(1) unsigned DEFAULT '1',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `log`;

CREATE TABLE `log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `entry` varchar(191) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;

INSERT INTO `log` (`id`, `entry`, `created_at`)
VALUES
	(6,'WES WUZ HERE','2019-05-13 16:56:04');

/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table sku_data
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sku_data`;

CREATE TABLE `sku_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `batch_id` int(5) unsigned DEFAULT NULL,
  `sku` varchar(191) DEFAULT NULL,
  `category_id` int(5) unsigned DEFAULT NULL,
  `description` varchar(191) DEFAULT NULL,
  `status` int(4) unsigned DEFAULT NULL,
  `hash_id` varchar(5) DEFAULT NULL,
  `akamai_numbers` varchar(191) DEFAULT NULL,
  `line1_text` varchar(191) DEFAULT NULL,
  `line2_text` varchar(191) DEFAULT NULL,
  `button_filename` varchar(191) DEFAULT NULL,
  `published_url` varchar(191) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `sku_data` WRITE;
/*!40000 ALTER TABLE `sku_data` DISABLE KEYS */;

INSERT INTO `sku_data` (`id`, `batch_id`, `sku`, `category_id`, `description`, `status`, `hash_id`, `akamai_numbers`, `line1_text`, `line2_text`, `button_filename`, `published_url`, `created_at`, `updated_at`)
VALUES
	(1,1,'862426',NULL,'Purell® Sanitizing Wipes, 1,200 Wipes/Pack, 2 Packs per Carton',20,'41627','m007187862,m007187864','Purell® Sanitizing Wipes,','1,200 Wipes/Pack','862426_41627.png',NULL,'2019-05-31 14:49:16','2019-06-14 17:12:48'),
	(2,1,'815023',NULL,'Brighton Professional™ Enzyme Plus™ Odor Eliminator Deodorizer, Citrus, 1 Gallon Concentrate (BPR735001-B-CC)',20,'9e776','s0466701','Enzyme Plus™ Odor','Eliminator Deodorizer','815023_9e776.png',NULL,'2019-05-31 14:49:16','2019-06-14 17:13:28'),
	(3,1,'2091644',NULL,'Sustainable Earth® by Staples® Quick Mix® #70 Restroom Cleaner Washroom Cleaner, Quick Mix, 1 Gallon, 2/CT (SEB29894-CC)',NULL,NULL,'s0352168',NULL,NULL,NULL,NULL,'2019-05-31 14:49:16','2019-06-14 21:28:35'),
	(4,1,'2091620',NULL,'Brighton Professional™ Quick Mix® #66 Disinfectant and Sanitizer, Quick Mix , 1 Gallon, 2/CT (STP29904-CC)',NULL,NULL,'s0358191',NULL,NULL,NULL,NULL,'2019-05-31 14:49:16','2019-06-14 21:28:49'),
	(5,1,'2091645',NULL,'Sustainable Earth™ by Staples® Quick Mix® #64 Neutral All Purpose Cleaner, Quick Mix, 1 Gallon, 2/CT (SEB29892-CC)',NULL,NULL,'s0352128',NULL,NULL,NULL,NULL,'2019-05-31 14:49:16','2019-06-14 21:29:08'),
	(6,1,'851076',NULL,'Technical Concepts TCell Passive Air System Refill, Cucumber Melon, 6/Carton (FG402470)',20,'49c6d','sp40890539','TCell Passive Air System','Refill, 6/Carton','851076_49c6d.png',NULL,'2019-05-31 14:49:16','2019-06-14 17:15:33'),
	(7,1,'816011',NULL,'Brawny® Industrial Dine-A-Max™ Foodservice and Bar Towels; 1-Ply, 150 Towels/Carton (GEP29416)',20,'efd67','s0372717','Brawny® Industrial','Towels, 150 Towels','816011_efd67.png',NULL,'2019-05-31 14:49:16','2019-06-14 17:16:51'),
	(8,1,'700938',NULL,'Seventh Generation Free & Clear Powerful Clean Dishwasher Detergent Powder, 45 oz., Unscented (22150)',20,'89e3c','sp51831320,sp45448392,sp45448393','Powerful Clean Dishwasher','Detergent, 45 oz.','700938_89e3c.png',NULL,'2019-05-31 14:49:16','2019-06-14 17:18:31'),
	(9,2,'913740',NULL,'Oxivir Tb Cleaner Disinfectant, 32 Oz., 12/Carton (4277285)',NULL,NULL,'sp44340747',NULL,NULL,NULL,NULL,'2019-06-01 18:59:17','2019-06-14 20:23:39'),
	(10,2,'815040',NULL,'Sustainable Earth by Staples® #71 Restroom Cleaner Toilet and Urinal Cleaner, 32 oz. (SEB710032-C-CC)',NULL,NULL,'s0321472,s0344431',NULL,NULL,NULL,NULL,'2019-06-01 18:59:17','2019-06-14 20:23:39'),
	(11,2,'24376039',NULL,'Mr. Clean Multi-Surface Magic Eraser with DURAFOAM Original, 6 Pack (79009)',NULL,NULL,'sp44582213,sp44582214',NULL,NULL,NULL,NULL,'2019-06-01 18:59:17','2019-06-14 20:23:39'),
	(12,2,'517899',NULL,'Scotch-Brite® Heavy Duty Scrub Sponge, Green/Yellow, 3/Pack (HD-3)',NULL,NULL,'sp47852598,sp47852520,sp47852410',NULL,NULL,NULL,NULL,'2019-06-01 18:59:17','2019-06-14 20:23:39'),
	(14,2,'700937',NULL,'Seventh Generation Free & Clear Dish Soap Liquid, Unscented (22733)',NULL,NULL,'sp44342839',NULL,NULL,NULL,NULL,'2019-06-01 18:59:17','2019-06-14 20:23:39'),
	(15,2,'503557',NULL,'Duracell Coppertop D Alkaline Batteries, 8/Pack',NULL,NULL,'m007162658,sp50125924',NULL,NULL,NULL,NULL,'2019-06-01 18:59:17','2019-06-14 20:23:39'),
	(16,2,'812862',NULL,'Scotch-Brite™ Light Duty Cleansing Pad, White, 60/Carton (98)',NULL,NULL,'sp47852532,s0338496',NULL,NULL,NULL,NULL,'2019-06-01 18:59:17','2019-06-13 21:16:24');

/*!40000 ALTER TABLE `sku_data` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table telemetry_data
# ------------------------------------------------------------

DROP TABLE IF EXISTS `telemetry_data`;

CREATE TABLE `telemetry_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `hash_id` varchar(5) DEFAULT NULL,
  `data` mediumtext,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `telemetry_data` WRITE;
/*!40000 ALTER TABLE `telemetry_data` DISABLE KEYS */;

INSERT INTO `telemetry_data` (`id`, `hash_id`, `data`, `created_at`)
VALUES
	(18,'41627','{\"text\":{\"line_1\":\"Purell\\u00ae Sanitizing Wipes,\",\"line_2\":\"1,200 Wipes\\/Pack\"},\"layer-a\":{\"url\":\"https:\\/\\/www.staples-3p.com\\/s7\\/is\\/image\\/Staples\\/m007187862_sc7?wid=1000&hei=1000\",\"rotation\":\"0.00\",\"scale\":\"0.624\",\"x_offset_js\":-74,\"y_offset_js\":-115,\"x_offset_gsap\":-262,\"y_offset_gsap\":-303}}','2019-06-14 21:12:48'),
	(19,'9e776','{\"text\":{\"line_1\":\"Enzyme Plus\\u2122 Odor\",\"line_2\":\"Eliminator Deodorizer\"},\"layer-a\":{\"url\":\"https:\\/\\/www.staples-3p.com\\/s7\\/is\\/image\\/Staples\\/s0466701_sc7?wid=1000&hei=1000\",\"rotation\":\"0.00\",\"scale\":\"0.574\",\"x_offset_js\":-52,\"y_offset_js\":-61,\"x_offset_gsap\":-265,\"y_offset_gsap\":-274}}','2019-06-14 21:13:28'),
	(20,'49c6d','{\"text\":{\"line_1\":\"TCell Passive Air System\",\"line_2\":\"Refill, 6\\/Carton\"},\"layer-a\":{\"url\":\"https:\\/\\/www.staples-3p.com\\/s7\\/is\\/image\\/Staples\\/sp40890539_sc7?wid=1000&hei=1000\",\"rotation\":\"-15.00\",\"scale\":\"0.674\",\"x_offset_js\":-324,\"y_offset_js\":-327,\"x_offset_gsap\":-411,\"y_offset_gsap\":-414},\"layer-b\":{\"url\":\"https:\\/\\/www.staples-3p.com\\/s7\\/is\\/image\\/Staples\\/sp40890539_sc7?wid=1000&hei=1000\",\"rotation\":\"-15.00\",\"scale\":\"0.67\",\"x_offset_js\":-45,\"y_offset_js\":-83,\"x_offset_gsap\":-132,\"y_offset_gsap\":-170}}','2019-06-14 21:15:33'),
	(21,'efd67','{\"text\":{\"line_1\":\"Brawny\\u00ae Industrial\",\"line_2\":\"Towels, 150 Towels\"},\"layer-a\":{\"url\":\"https:\\/\\/www.staples-3p.com\\/s7\\/is\\/image\\/Staples\\/s0372717_sc7?wid=1000&hei=1000\",\"rotation\":\"0.00\",\"scale\":\"0.674\",\"x_offset_js\":-110,\"y_offset_js\":-166,\"x_offset_gsap\":-273,\"y_offset_gsap\":-329}}','2019-06-14 21:16:50'),
	(22,'89e3c','{\"text\":{\"line_1\":\"Powerful Clean Dishwasher\",\"line_2\":\"Detergent, 45 oz.\"},\"layer-a\":{\"url\":\"https:\\/\\/www.staples-3p.com\\/s7\\/is\\/image\\/Staples\\/sp51831320_sc7?wid=1000&hei=1000\",\"rotation\":\"0.00\",\"scale\":\"0.474\",\"x_offset_js\":-71,\"y_offset_js\":-79,\"x_offset_gsap\":-334,\"y_offset_gsap\":-342},\"layer-b\":{\"url\":\"https:\\/\\/www.staples-3p.com\\/s7\\/is\\/image\\/Staples\\/sp45448393_sc7?wid=1000&hei=1000\",\"rotation\":\"0.00\",\"scale\":\"0.12\",\"x_offset_js\":340,\"y_offset_js\":195,\"x_offset_gsap\":-98,\"y_offset_gsap\":-243},\"layer-c\":{\"url\":\"https:\\/\\/www.staples-3p.com\\/s7\\/is\\/image\\/Staples\\/sp45448392_sc7?wid=1000&hei=1000\",\"rotation\":\"0.00\",\"scale\":\"0.27\",\"x_offset_js\":245,\"y_offset_js\":6,\"x_offset_gsap\":-118,\"y_offset_gsap\":-357}}','2019-06-14 21:18:30');

/*!40000 ALTER TABLE `telemetry_data` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table unique_hash
# ------------------------------------------------------------

DROP TABLE IF EXISTS `unique_hash`;

CREATE TABLE `unique_hash` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `hash` varchar(5) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `unique_hash` WRITE;
/*!40000 ALTER TABLE `unique_hash` DISABLE KEYS */;

INSERT INTO `unique_hash` (`id`, `hash`)
VALUES
	(287,X'3431363237'),
	(288,X'3965373736'),
	(292,X'3439633664'),
	(293,X'6566643637'),
	(294,X'3839653363');

/*!40000 ALTER TABLE `unique_hash` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
