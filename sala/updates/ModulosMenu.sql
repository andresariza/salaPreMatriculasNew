/*
Navicat MySQL Data Transfer

Source Server         : Desarrollo
Source Server Version : 50552
Source Host           : 172.16.36.8:3306
Source Database       : sala2

Target Server Type    : MYSQL
Target Server Version : 50552
File Encoding         : 65001

Date: 2018-02-16 11:22:58
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ModulosMenu
-- ----------------------------
DROP TABLE IF EXISTS `ModulosMenu`;
CREATE TABLE `ModulosMenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemId` int(11) DEFAULT '0',
  `modulo` varchar(255) DEFAULT NULL,
  `estado` int(3) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ModulosMenu
-- ----------------------------
INSERT INTO `ModulosMenu` VALUES ('1', '0', 'mainMenu', '1');
INSERT INTO `ModulosMenu` VALUES ('2', '0', 'userMenu', '1');
INSERT INTO `ModulosMenu` VALUES ('3', '0', 'asideContainer', '1');
SET FOREIGN_KEY_CHECKS=1;
