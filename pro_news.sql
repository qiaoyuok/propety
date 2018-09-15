/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : property

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-05-26 14:57:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for pro_news
-- ----------------------------
DROP TABLE IF EXISTS `pro_news`;
CREATE TABLE `pro_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '新闻ID号',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '新闻标题',
  `content` text NOT NULL COMMENT '新闻内容',
  `author` varchar(255) NOT NULL DEFAULT '' COMMENT '作者',
  `create_time` datetime NOT NULL COMMENT '新闻创建时间',
  `update_time` datetime NOT NULL COMMENT '新闻上次修改时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '新闻状态；1：默认显示；0：隐藏',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
