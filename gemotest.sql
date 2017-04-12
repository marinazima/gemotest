/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50545
Source Host           : localhost:3306
Source Database       : gemotest

Target Server Type    : MYSQL
Target Server Version : 50545
File Encoding         : 65001

Date: 2017-04-12 02:59:47
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `discount`
-- ----------------------------
DROP TABLE IF EXISTS `discount`;
CREATE TABLE `discount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `birthdate_before` int(11) DEFAULT NULL,
  `birthdate_after` int(11) DEFAULT NULL,
  `phone_exists` int(11) DEFAULT NULL,
  `phone_tail` int(11) DEFAULT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_start` int(11) DEFAULT NULL,
  `date_end` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of discount
-- ----------------------------
INSERT INTO `discount` VALUES ('1', '1491773148', '1491943118', '5.00', '1', '0', '1', null, 'male', '1491856718', '1492375118');
INSERT INTO `discount` VALUES ('2', '1491844320', '1491943959', '10.00', '0', '1', '1', '2222', 'male', '1492030359', '1492375959');
INSERT INTO `discount` VALUES ('3', '1491855497', '1491855710', '15.00', '1', '1', '0', null, null, '1491510110', null);

-- ----------------------------
-- Table structure for `discount_service`
-- ----------------------------
DROP TABLE IF EXISTS `discount_service`;
CREATE TABLE `discount_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `discount_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-discount_service-discount_id` (`discount_id`),
  CONSTRAINT `fk-discount_service-discount_id` FOREIGN KEY (`discount_id`) REFERENCES `discount` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of discount_service
-- ----------------------------
INSERT INTO `discount_service` VALUES ('7', '3', '3');
INSERT INTO `discount_service` VALUES ('18', '1', '1');
INSERT INTO `discount_service` VALUES ('19', '1', '2');
INSERT INTO `discount_service` VALUES ('20', '2', '3');
INSERT INTO `discount_service` VALUES ('21', '2', '4');

-- ----------------------------
-- Table structure for `migration`
-- ----------------------------
DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of migration
-- ----------------------------
INSERT INTO `migration` VALUES ('m000000_000000_base', '1491503420');
INSERT INTO `migration` VALUES ('m170406_183306_order_create_table', '1491506263');
INSERT INTO `migration` VALUES ('m170406_184023_service_create_table', '1491506263');
INSERT INTO `migration` VALUES ('m170406_184031_order_service_create_table', '1491506430');
INSERT INTO `migration` VALUES ('m170406_184119_discount_create_table', '1491506430');
INSERT INTO `migration` VALUES ('m170406_190411_discount_service_create_table', '1491506430');
INSERT INTO `migration` VALUES ('m170406_201447_order_add_field', '1491509872');

-- ----------------------------
-- Table structure for `order`
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `customer` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `birthdate` int(11) NOT NULL,
  `phone` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `discount` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of order
-- ----------------------------
INSERT INTO `order` VALUES ('1', '1491662131', '1491943471', 'Аристарх Аполлонович Кошкин', '955741471', '+74356347478', 'male', '0.00');
INSERT INTO `order` VALUES ('2', '1491684743', '1491694594', 'Семен Петрович Иванушкин', '942363394', '+72934562873', 'male', '0.00');
INSERT INTO `order` VALUES ('3', '1491684843', '1491690089', 'Капитолина Васильевна Чебурашкина', '298678889', '+72837562873', 'female', '0.00');
INSERT INTO `order` VALUES ('5', '1491695045', '1491695045', 'Аполинария Степановна Финтифлюшкина', '1484005445', '+72345667568', 'male', '0.00');
INSERT INTO `order` VALUES ('51', '1491954645', '1491954692', 'sdfs', '1492300292', '+72222222222', 'male', '5.00');

-- ----------------------------
-- Table structure for `order_service`
-- ----------------------------
DROP TABLE IF EXISTS `order_service`;
CREATE TABLE `order_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-order_service-order_id` (`order_id`),
  CONSTRAINT `fk-order_service-order_id` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=280 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of order_service
-- ----------------------------
INSERT INTO `order_service` VALUES ('6', '3', '2');
INSERT INTO `order_service` VALUES ('7', '3', '3');
INSERT INTO `order_service` VALUES ('8', '2', '4');
INSERT INTO `order_service` VALUES ('9', '2', '5');
INSERT INTO `order_service` VALUES ('16', '5', '1');
INSERT INTO `order_service` VALUES ('17', '5', '4');
INSERT INTO `order_service` VALUES ('18', '5', '5');
INSERT INTO `order_service` VALUES ('106', '1', '1');
INSERT INTO `order_service` VALUES ('107', '1', '2');
INSERT INTO `order_service` VALUES ('108', '1', '3');
INSERT INTO `order_service` VALUES ('275', '51', '1');
INSERT INTO `order_service` VALUES ('276', '51', '2');
INSERT INTO `order_service` VALUES ('277', '51', '3');
INSERT INTO `order_service` VALUES ('278', '51', '4');
INSERT INTO `order_service` VALUES ('279', '51', '5');

-- ----------------------------
-- Table structure for `service`
-- ----------------------------
DROP TABLE IF EXISTS `service`;
CREATE TABLE `service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of service
-- ----------------------------
INSERT INTO `service` VALUES ('1', '1491507691', '1491507691', 'Погладить кота');
INSERT INTO `service` VALUES ('2', '1491507722', '1491507722', 'Поиграть с котом');
INSERT INTO `service` VALUES ('3', '1491507735', '1491507735', 'Покормить кота');
INSERT INTO `service` VALUES ('4', '1491507751', '1491507751', 'Почесать коту за ухом');
INSERT INTO `service` VALUES ('5', '1491507771', '1491507771', 'Драконить кота');
