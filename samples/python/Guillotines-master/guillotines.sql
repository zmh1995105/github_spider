/*
Navicat MySQL Data Transfer

Source Server         : mydb
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : guillotines

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2016-09-05 17:14:05
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `gu_shelldbconf`
-- ----------------------------
DROP TABLE IF EXISTS `gu_shelldbconf`;
CREATE TABLE `gu_shelldbconf` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `HOST` varchar(128) NOT NULL DEFAULT '127.0.0.1' COMMENT 'ipv4和ipv6',
  `PORT` varchar(5) NOT NULL DEFAULT '3306' COMMENT '端口号',
  `PWD` varchar(32) NOT NULL DEFAULT 'root' COMMENT '数据库密码',
  `CREATE_TIME` timestamp NOT NULL DEFAULT '2016-07-20 23:30:27' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='websehll数据库配置信息';

-- ----------------------------
-- Records of gu_shelldbconf
-- ----------------------------

-- ----------------------------
-- Table structure for `gu_users`
-- ----------------------------
DROP TABLE IF EXISTS `gu_users`;
CREATE TABLE `gu_users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(32) NOT NULL COMMENT '用户名',
  `EMAIL` varchar(100) NOT NULL COMMENT '邮箱',
  `PWD` varchar(32) NOT NULL COMMENT '密码',
  `SALT` varchar(10) NOT NULL,
  `UTYPE` varchar(10) NOT NULL DEFAULT 'user' COMMENT '用户类型',
  `CREATE_TIME` timestamp NOT NULL DEFAULT '2016-07-20 21:35:31' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户信息表';

-- ----------------------------
-- Records of gu_users
-- ----------------------------
INSERT INTO `gu_users` VALUES ('1', 'MXi4oyu', '798033502@qq.com', 'd9a3650b375d1bfdb529dbf036d626a4', '1234567890', 'user', '2016-08-31 11:34:31');

-- ----------------------------
-- Table structure for `gu_webshell`
-- ----------------------------
DROP TABLE IF EXISTS `gu_webshell`;
CREATE TABLE `gu_webshell` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `URL` varchar(255) NOT NULL,
  `PWD` varchar(32) NOT NULL,
  `IP` varchar(128) DEFAULT '' COMMENT 'IP地址',
  `IP_ADDRESS` varchar(255) DEFAULT '' COMMENT '归属地',
  `CATEGORY` varchar(6) NOT NULL COMMENT 'shell类型',
  `CREATE_TIME` timestamp NOT NULL DEFAULT '2016-07-20 22:52:47' ON UPDATE CURRENT_TIMESTAMP,
  `HTTPCODE` varchar(3) DEFAULT '' COMMENT '状态码',
  `BR` int(1) DEFAULT '0' COMMENT '权重',
  `PR` int(1) DEFAULT '0' COMMENT 'PR',
  PRIMARY KEY (`ID`),
  KEY `index_url` (`URL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gu_webshell
-- ----------------------------
