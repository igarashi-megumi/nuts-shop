-- Adminer 4.8.1 MySQL 5.7.28 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `login` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `customer` (`id`, `name`, `address`, `email`, `login`, `password`) VALUES
(17,	'五十嵐めぐみ',	'北海道札幌市',	'mgm.817.shishi@gmail.com',	'megumi',	'$2y$10$7u5hdRZEb7eIgnGLRoGiEeUpuDzYmPSSeFiqUa2iw/U3OO7XK2QGi'),
(22,	'サンプル太郎',	'秋田県秋田市寺内',	'taro@gmail.com',	'taro',	'$2y$10$cLcIe2c8ihfdORMGZltrReJeRmvaut68uL.bQbBuAy.q0wHFTCn6S');

DROP TABLE IF EXISTS `favorite`;
CREATE TABLE `favorite` (
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`customer_id`,`product_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `favorite_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  CONSTRAINT `favorite_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `favorite` (`customer_id`, `product_id`) VALUES
(17,	1),
(17,	5);

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `price` int(11) NOT NULL,
  `images` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `product` (`id`, `name`, `price`, `images`) VALUES
(1,	'松の実',	400,	''),
(2,	'くるみ',	270,	''),
(3,	'ひまわりの種',	210,	''),
(4,	'アーモンド',	220,	''),
(5,	'カシューナッツ',	250,	''),
(6,	'ジャイアントコーン',	180,	''),
(7,	'ピスタチオ',	310,	''),
(8,	'マカダミアナッツ',	600,	''),
(9,	'かぼちゃの種',	180,	''),
(10,	'ピーナッツ',	150,	''),
(11,	'クコの実',	400,	''),
(12,	'落花生',	1200,	''),
(13,	'枝豆',	1500,	''),
(14,	'そら豆',	1100,	''),
(67,	'ミックスナッツ(3種)',	1000,	'a:3:{i:0;s:12:\"upload/4.jpg\";i:1;s:12:\"upload/5.jpg\";i:2;s:13:\"upload/10.jpg\";}');

DROP TABLE IF EXISTS `purchase`;
CREATE TABLE `purchase` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `purchase_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `purchase` (`id`, `customer_id`, `date`) VALUES
(1,	17,	'2022-02-25 02:09:14'),
(2,	22,	'2022-02-25 02:09:14'),
(3,	17,	'2022-02-26 04:18:27'),
(4,	17,	'2022-03-01 23:39:58'),
(5,	17,	'2022-03-04 04:39:09'),
(6,	17,	'2022-03-07 00:14:12'),
(7,	17,	'2022-03-07 03:58:26');

DROP TABLE IF EXISTS `purchase_detail`;
CREATE TABLE `purchase_detail` (
  `purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY (`purchase_id`,`product_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `purchase_detail_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `purchase` (`id`),
  CONSTRAINT `purchase_detail_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `purchase_detail` (`purchase_id`, `product_id`, `count`) VALUES
(1,	1,	1),
(2,	2,	1),
(3,	2,	1),
(4,	4,	2),
(4,	8,	1),
(5,	14,	1),
(6,	3,	2),
(7,	5,	1);

-- 2022-03-07 04:13:03
