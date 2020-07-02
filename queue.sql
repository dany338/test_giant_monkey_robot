/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : queue

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2020-06-24 17:14:43
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for queues
-- ----------------------------
DROP TABLE IF EXISTS `queues`;
CREATE TABLE `queues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL COMMENT 'job_id',
  `submitters_id` varchar(100) NOT NULL COMMENT 'submitters_id',
  `processors_id` int(11) NOT NULL COMMENT 'processors_id',
  `command_to_execute` varchar(100) NOT NULL COMMENT 'command_to_execute',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of queues
-- ----------------------------
INSERT INTO `queues` VALUES ('1', '3', '3', '3', '3');
INSERT INTO `queues` VALUES ('2', '6', '6', '6', '6');
INSERT INTO `queues` VALUES ('3', '1', '1', '1', '1');
INSERT INTO `queues` VALUES ('4', '2', '2', '2', '2');
INSERT INTO `queues` VALUES ('5', '5', '5', '5', '5');
INSERT INTO `queues` VALUES ('6', '10', '10', '10', '10');
INSERT INTO `queues` VALUES ('7', '2', '2', '2', '2');
INSERT INTO `queues` VALUES ('8', '4', '4', '4', '4');
INSERT INTO `queues` VALUES ('9', '4', '4', '4', '4');
INSERT INTO `queues` VALUES ('10', '3', '3', '3', '3');
INSERT INTO `queues` VALUES ('11', '6', '6', '6', '6');
