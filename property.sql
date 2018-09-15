/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : property

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-07-05 00:04:29
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for pro_admin
-- ----------------------------
DROP TABLE IF EXISTS `pro_admin`;
CREATE TABLE `pro_admin` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员用户ID号',
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `create_time` datetime NOT NULL COMMENT '添加时间',
  `update_time` datetime NOT NULL COMMENT '上次更改时间',
  `last_login_time` datetime NOT NULL COMMENT '上次登录时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '管理员状态；默认1：正常；0：禁用；-1：删除',
  `nickname` varchar(255) NOT NULL DEFAULT '' COMMENT '用户昵称',
  `avatarurl` varchar(255) NOT NULL DEFAULT '' COMMENT '用户头像地址',
  `count` int(11) NOT NULL DEFAULT '0' COMMENT '登陆次数统计',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pro_admin
-- ----------------------------
INSERT INTO `pro_admin` VALUES ('1', 'admin', '4297f44b13955235245b2497399d7a93', '2018-05-05 12:25:51', '2018-05-20 15:44:49', '2018-05-05 12:25:59', '1', '雨后桥前', '1.jpg', '0');
INSERT INTO `pro_admin` VALUES ('2', 'wahaha', '4297f44b13955235245b2497399d7a93', '2018-05-05 12:25:51', '2018-05-20 15:44:49', '2018-05-05 12:25:59', '1', '雨后桥前', '1.jpg', '0');
INSERT INTO `pro_admin` VALUES ('3', 'wahaha佛挡杀佛', '4297f44b13955235245b2497399d7a93', '2018-05-05 12:25:51', '2018-05-20 15:44:49', '2018-05-05 12:25:59', '1', '雨后桥前', '1.jpg', '0');

-- ----------------------------
-- Table structure for pro_announce
-- ----------------------------
DROP TABLE IF EXISTS `pro_announce`;
CREATE TABLE `pro_announce` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '公告序号',
  `create_time` datetime DEFAULT NULL COMMENT '公告发布时间',
  `update_time` datetime DEFAULT NULL COMMENT '公告最近一次修改时间',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '公告标题',
  `content` text NOT NULL COMMENT '公告内容',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '公告状态：默认0：隐藏；1：显示',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pro_announce
-- ----------------------------
INSERT INTO `pro_announce` VALUES ('1', '2018-05-15 23:16:56', null, '微信平台开放通知', '为方便用户日常缴费，设备保修等日常服务，现已开通微信平台，用户可在线查看租房，停车位，物业等缴费情况，并可在线进行缴费；同时可在线提交设备维修情况，以及对一些不满意的情况进行投诉或举报；\n感谢您的支持！！\n春暖花开小区物业', '1');
INSERT INTO `pro_announce` VALUES ('6', '2018-05-16 11:38:46', '2018-05-17 14:31:54', '关于近期硬件设备被恶意损坏通知', '由于近期，小区内多处硬件被人损坏，现已通知相关人员进行调查，也请该人员看到此消息尽快投案自首，以便从轻发落', '1');

-- ----------------------------
-- Table structure for pro_company
-- ----------------------------
DROP TABLE IF EXISTS `pro_company`;
CREATE TABLE `pro_company` (
  `id` int(11) NOT NULL DEFAULT '0' COMMENT '序号',
  `company_name` varchar(255) NOT NULL DEFAULT '' COMMENT '公司名称',
  `company_address` varchar(255) NOT NULL DEFAULT '' COMMENT '公司地址',
  `company_manager` varchar(255) NOT NULL DEFAULT '' COMMENT '公司负责人',
  `company_email` varchar(255) NOT NULL DEFAULT '' COMMENT '公司邮箱',
  `company_tel` varchar(255) NOT NULL DEFAULT '' COMMENT '公司电话',
  `company_des` text NOT NULL COMMENT '公司介绍',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pro_company
-- ----------------------------
INSERT INTO `pro_company` VALUES ('0', '春暖花开', '金沙湖天街', '孙乔雨', '1559946526@qq.com', '15551541542', '萨拉黝黑');

-- ----------------------------
-- Table structure for pro_complaint
-- ----------------------------
DROP TABLE IF EXISTS `pro_complaint`;
CREATE TABLE `pro_complaint` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '序号',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '投诉记录对应的用户ID号',
  `content` text NOT NULL COMMENT '投诉内容',
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '默认0：待处理；1：已处理',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pro_complaint
-- ----------------------------
INSERT INTO `pro_complaint` VALUES ('15', '23', '我哈啊哈哈哈洗澡咯哦咯\n    ', '2018-05-17 11:09:27', '0000-00-00 00:00:00', '0');
INSERT INTO `pro_complaint` VALUES ('16', '23', '明年\n    ', '2018-05-17 11:11:29', '0000-00-00 00:00:00', '0');
INSERT INTO `pro_complaint` VALUES ('17', '23', '明年\n    ', '2018-05-17 11:11:31', '0000-00-00 00:00:00', '0');
INSERT INTO `pro_complaint` VALUES ('18', '23', '顶蘑菇\n    ', '2018-05-17 11:11:40', '2018-05-18 15:01:35', '1');
INSERT INTO `pro_complaint` VALUES ('19', '23', 'UK咯用讨论组', '2018-05-17 21:52:14', '2018-05-17 21:56:37', '1');
INSERT INTO `pro_complaint` VALUES ('20', '23', '公民咯头晕晕\n    ', '2018-05-17 22:11:06', '0000-00-00 00:00:00', '0');
INSERT INTO `pro_complaint` VALUES ('21', '23', '哦肉头哦了也扣开在真\n    ', '2018-05-17 22:11:13', '0000-00-00 00:00:00', '0');
INSERT INTO `pro_complaint` VALUES ('22', '23', '今明你一直用咯一\n    ', '2018-05-17 22:11:20', '0000-00-00 00:00:00', '0');
INSERT INTO `pro_complaint` VALUES ('23', '23', '哦你屋咯工作诺克我\n    ', '2018-05-17 22:11:27', '0000-00-00 00:00:00', '0');
INSERT INTO `pro_complaint` VALUES ('24', '23', '哦你屋咯工作诺克我\n    ', '2018-05-17 22:11:27', '0000-00-00 00:00:00', '0');
INSERT INTO `pro_complaint` VALUES ('25', '23', '哦你屋咯工作诺克我\n    ', '2018-05-17 22:11:27', '0000-00-00 00:00:00', '0');

-- ----------------------------
-- Table structure for pro_device
-- ----------------------------
DROP TABLE IF EXISTS `pro_device`;
CREATE TABLE `pro_device` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '序号',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '投诉记录对应的用户ID号',
  `content` text NOT NULL COMMENT '投诉内容',
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '默认0：待处理；1：已处理',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pro_device
-- ----------------------------
INSERT INTO `pro_device` VALUES ('13', '23', '你你弄哦咯咯\n    ', '2018-05-17 11:12:00', '0000-00-00 00:00:00', '0');
INSERT INTO `pro_device` VALUES ('14', '25', '尝试一下了', '2018-05-17 11:22:43', '0000-00-00 00:00:00', '0');
INSERT INTO `pro_device` VALUES ('15', '23', '哇哈哈哈\n    ', '2018-05-17 21:50:34', '0000-00-00 00:00:00', '0');

-- ----------------------------
-- Table structure for pro_menu
-- ----------------------------
DROP TABLE IF EXISTS `pro_menu`;
CREATE TABLE `pro_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单ID号',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '菜单名',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '菜单地址',
  `sort` int(5) NOT NULL DEFAULT '0' COMMENT '菜单排序',
  `hide` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否隐藏菜单；0：显示；1：隐藏',
  `group` varchar(255) NOT NULL DEFAULT '' COMMENT '分组名',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父及菜单ID号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pro_menu
-- ----------------------------
INSERT INTO `pro_menu` VALUES ('1', '系统', 'System/index', '0', '0', '', '0');
INSERT INTO `pro_menu` VALUES ('2', '物业设置', 'System/set', '5', '0', '后台管理', '1');
INSERT INTO `pro_menu` VALUES ('28', '费用', 'Fee/index', '3', '0', '', '0');
INSERT INTO `pro_menu` VALUES ('27', '报修', 'Device/index', '2', '0', '', '0');
INSERT INTO `pro_menu` VALUES ('25', '模块管理', 'System/module', '0', '1', '前台控制', '1');
INSERT INTO `pro_menu` VALUES ('3', '菜单管理', 'System/index', '6', '0', '后台管理', '1');
INSERT INTO `pro_menu` VALUES ('26', '用户', 'User/index', '4', '0', '', '0');
INSERT INTO `pro_menu` VALUES ('29', '投诉', 'Complaint/index', '1', '0', '', '0');
INSERT INTO `pro_menu` VALUES ('33', '首页', 'Index/index', '9', '0', '', '0');
INSERT INTO `pro_menu` VALUES ('31', '管理员列表', 'User/index', '0', '0', '管理员管理', '26');
INSERT INTO `pro_menu` VALUES ('32', '用户列表', 'User/user', '0', '0', '普通用户管理', '26');
INSERT INTO `pro_menu` VALUES ('34', '用户投诉', 'Complaint/index', '0', '0', '用户投诉管理', '29');
INSERT INTO `pro_menu` VALUES ('35', '公告管理', 'System/announce', '0', '0', '前台控制', '1');
INSERT INTO `pro_menu` VALUES ('36', '报修管理', 'Device/index', '0', '0', '设备报修管理', '27');
INSERT INTO `pro_menu` VALUES ('37', '房租物业费管理', 'Fee/index', '0', '0', '费用管理', '28');
INSERT INTO `pro_menu` VALUES ('38', '房间管理', 'System/house', '0', '0', '后台管理', '1');
INSERT INTO `pro_menu` VALUES ('39', '停车位管理', 'System/park', '0', '0', '后台管理', '1');
INSERT INTO `pro_menu` VALUES ('40', '停车位费用管理', 'Fee/park', '0', '0', '费用管理', '28');
INSERT INTO `pro_menu` VALUES ('41', '订单', 'Order/index', '1', '0', '', '0');
INSERT INTO `pro_menu` VALUES ('42', '订单管理', 'Order/index', '0', '0', '订单管理', '41');
INSERT INTO `pro_menu` VALUES ('43', '小区管理', 'System/village', '4', '0', '后台管理', '1');
INSERT INTO `pro_menu` VALUES ('44', '小区新闻', 'System/news', '0', '0', '前台控制', '1');

-- ----------------------------
-- Table structure for pro_msg
-- ----------------------------
DROP TABLE IF EXISTS `pro_msg`;
CREATE TABLE `pro_msg` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '消息ID号',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '消息标题',
  `content` text COMMENT '消息内容',
  `create_time` datetime NOT NULL COMMENT '消息创建时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '消息状态：默认0：未读；1：已读',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '消息接收者ID号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pro_msg
-- ----------------------------
INSERT INTO `pro_msg` VALUES ('1', '房租催收', '你的房间1幢1单元1001室本月还没有缴纳房租，为了不影响不得正常入住，请尽快缴费', '2018-05-15 15:47:46', '1', '23');
INSERT INTO `pro_msg` VALUES ('2', '停车位费用催收', '随便写点', '2018-05-15 15:47:46', '1', '23');
INSERT INTO `pro_msg` VALUES ('3', '房租催收', '亲爱的租客，您本月尚有未缴纳房租，请及时缴纳；房间号1002', '0000-00-00 00:00:00', '1', '23');
INSERT INTO `pro_msg` VALUES ('4', '物业催收', '亲爱的租客，您本月尚有未缴纳的物业费，请及时缴纳；房间号1002', '2018-05-16 15:59:22', '1', '23');
INSERT INTO `pro_msg` VALUES ('5', '房租催收', '亲爱的租客，您本月尚有未缴纳房租，请及时缴纳；房间号1002', '2018-05-16 17:19:38', '1', '23');
INSERT INTO `pro_msg` VALUES ('6', '车位费催收', '亲爱的租客，您本月尚有未缴纳停车位费，请及时缴纳；车位号4', '2018-05-16 18:10:56', '1', '23');
INSERT INTO `pro_msg` VALUES ('7', '房租催收', '亲爱的租客，您本月尚有未缴纳房租，请及时缴纳；房间号1002', '2018-05-16 18:44:15', '1', '23');
INSERT INTO `pro_msg` VALUES ('8', '物业催收', '亲爱的租客，您本月尚有未缴纳的物业费，请及时缴纳；房间号1005', '2018-05-17 11:37:12', '1', '26');
INSERT INTO `pro_msg` VALUES ('9', '物业催收', '亲爱的租客，您本月尚有未缴纳的物业费，请及时缴纳；房间号1005', '2018-05-17 11:37:19', '0', '26');

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

-- ----------------------------
-- Records of pro_news
-- ----------------------------
INSERT INTO `pro_news` VALUES ('6', '小区物业管理系统', '<p><img src=\"http://property.com/editor/php/upload/20180526/15273254393164.jpg\"/>在这里输入新闻内容dd</p>', '', '2018-05-26 14:43:33', '2018-05-26 17:04:00', '1');

-- ----------------------------
-- Table structure for pro_order
-- ----------------------------
DROP TABLE IF EXISTS `pro_order`;
CREATE TABLE `pro_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单表序号',
  `sn` varchar(255) NOT NULL DEFAULT '' COMMENT '订单号',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '下单人',
  `create_time` datetime NOT NULL COMMENT '创建订单时间',
  `update_time` datetime NOT NULL COMMENT '订单支付时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订单状态；默认：0：待支付；1：已支付',
  `detail` tinytext NOT NULL COMMENT '订单详细信息',
  `total_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品总费用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pro_order
-- ----------------------------
INSERT INTO `pro_order` VALUES ('9', '20180516135637942129', '23', '2018-05-16 13:56:38', '0000-00-00 00:00:00', '0', '{\"flag\":1,\"name\":\"租房费用\",\"num\":25}', '0.00');
INSERT INTO `pro_order` VALUES ('10', '20180516135939536541', '23', '2018-05-16 13:59:40', '0000-00-00 00:00:00', '1', '{\"flag\":1,\"name\":\"租房费用\",\"num\":44}', '0.01');
INSERT INTO `pro_order` VALUES ('11', '20180516140018473370', '23', '2018-05-16 14:00:19', '0000-00-00 00:00:00', '1', '{\"flag\":2,\"name\":\"物业费用\",\"num\":25}', '0.02');
INSERT INTO `pro_order` VALUES ('12', '20180516140144687741', '23', '2018-05-16 14:01:45', '0000-00-00 00:00:00', '1', '{\"flag\":3,\"name\":\"停车位费用\",\"num\":21}', '0.01');
INSERT INTO `pro_order` VALUES ('13', '20180516141847549752', '23', '2018-05-16 14:18:48', '0000-00-00 00:00:00', '0', '{\"flag\":2,\"name\":\"物业费用\",\"num\":28}', '65.00');
INSERT INTO `pro_order` VALUES ('14', '20180516142109426184', '23', '2018-05-16 14:21:10', '0000-00-00 00:00:00', '0', '{\"flag\":2,\"name\":\"物业费用\",\"num\":28}', '65.00');
INSERT INTO `pro_order` VALUES ('15', '20180516142215256335', '23', '2018-05-16 14:22:16', '0000-00-00 00:00:00', '1', '{\"flag\":2,\"name\":\"物业费用\",\"num\":28}', '0.01');
INSERT INTO `pro_order` VALUES ('16', '20180516150304486251', '23', '2018-05-16 15:03:05', '0000-00-00 00:00:00', '0', '{\"flag\":3,\"name\":\"停车位费用\",\"num\":22}', '0.01');
INSERT INTO `pro_order` VALUES ('17', '20180516150354608996', '23', '2018-05-16 15:03:55', '0000-00-00 00:00:00', '0', '{\"flag\":3,\"name\":\"停车位费用\",\"num\":22}', '0.01');
INSERT INTO `pro_order` VALUES ('18', '20180516150405629129', '23', '2018-05-16 15:04:06', '0000-00-00 00:00:00', '0', '{\"flag\":3,\"name\":\"停车位费用\",\"num\":22}', '0.01');
INSERT INTO `pro_order` VALUES ('19', '20180516150457817077', '23', '2018-05-16 15:04:58', '0000-00-00 00:00:00', '0', '{\"flag\":3,\"name\":\"停车位费用\",\"num\":22}', '0.01');
INSERT INTO `pro_order` VALUES ('20', '20180516150503806777', '23', '2018-05-16 15:05:04', '0000-00-00 00:00:00', '0', '{\"flag\":3,\"name\":\"停车位费用\",\"num\":22}', '0.01');
INSERT INTO `pro_order` VALUES ('21', '20180516150535120050', '23', '2018-05-16 15:05:36', '0000-00-00 00:00:00', '1', '{\"flag\":3,\"name\":\"停车位费用\",\"num\":22}', '0.01');
INSERT INTO `pro_order` VALUES ('22', '20180516152329963442', '23', '2018-05-16 15:23:30', '0000-00-00 00:00:00', '1', '{\"flag\":1,\"name\":\"租房费用\",\"num\":31}', '0.01');
INSERT INTO `pro_order` VALUES ('23', '20180516152343884039', '23', '2018-05-16 15:23:44', '0000-00-00 00:00:00', '1', '{\"flag\":2,\"name\":\"物业费用\",\"num\":31}', '0.02');
INSERT INTO `pro_order` VALUES ('24', '20180516162521683895', '23', '2018-05-16 16:25:22', '0000-00-00 00:00:00', '0', '{\"flag\":1,\"name\":\"租房费用\",\"num\":32}', '0.01');
INSERT INTO `pro_order` VALUES ('25', '20180516184906960998', '23', '2018-05-16 18:49:06', '0000-00-00 00:00:00', '1', '{\"flag\":3,\"name\":\"停车位费用\",\"num\":24}', '0.01');
INSERT INTO `pro_order` VALUES ('26', '20180516190000939410', '23', '2018-05-16 19:00:00', '0000-00-00 00:00:00', '1', '{\"flag\":1,\"name\":\"租房费用\",\"num\":32}', '0.01');
INSERT INTO `pro_order` VALUES ('27', '20180517111406397262', '23', '2018-05-17 11:14:06', '0000-00-00 00:00:00', '1', '{\"flag\":2,\"name\":\"物业费用\",\"num\":32}', '0.01');
INSERT INTO `pro_order` VALUES ('28', '20180517113512990826', '26', '2018-05-17 11:35:12', '0000-00-00 00:00:00', '1', '{\"flag\":1,\"name\":\"租房费用\",\"num\":33}', '0.01');

-- ----------------------------
-- Table structure for pro_park
-- ----------------------------
DROP TABLE IF EXISTS `pro_park`;
CREATE TABLE `pro_park` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '房租列表ID号',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID号',
  `fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '房租费用，按月缴纳',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '默认0：普通租户；1：个人所有',
  `out_time` datetime NOT NULL COMMENT '费用到期时间',
  `last_pay_time` datetime NOT NULL COMMENT '上次缴费时间',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '车位号',
  `village_id` int(11) NOT NULL DEFAULT '0' COMMENT '小区ID号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pro_park
-- ----------------------------
INSERT INTO `pro_park` VALUES ('28', '26', '0.00', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', '8');
INSERT INTO `pro_park` VALUES ('27', '0', '0.00', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', '7');

-- ----------------------------
-- Table structure for pro_pro
-- ----------------------------
DROP TABLE IF EXISTS `pro_pro`;
CREATE TABLE `pro_pro` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '房租列表ID号',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID号',
  `fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '房租费用，按月缴纳',
  `out_time` datetime NOT NULL COMMENT '费用到期时间',
  `last_pay_time` datetime NOT NULL COMMENT '上次缴费时间',
  `room_num` int(11) NOT NULL DEFAULT '0' COMMENT '房间序号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pro_pro
-- ----------------------------
INSERT INTO `pro_pro` VALUES ('8', '23', '0.02', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '44');

-- ----------------------------
-- Table structure for pro_rent
-- ----------------------------
DROP TABLE IF EXISTS `pro_rent`;
CREATE TABLE `pro_rent` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '房租列表ID号',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID号',
  `fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '房租费用，按月缴纳',
  `out_time` datetime NOT NULL COMMENT '费用到期时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '默认0：普通租户；1：房东',
  `last_pay_time` datetime NOT NULL COMMENT '上次缴费时间',
  `room_id` int(11) NOT NULL DEFAULT '0' COMMENT '房间id号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pro_rent
-- ----------------------------
INSERT INTO `pro_rent` VALUES ('20', '23', '0.01', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '44');

-- ----------------------------
-- Table structure for pro_room
-- ----------------------------
DROP TABLE IF EXISTS `pro_room`;
CREATE TABLE `pro_room` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `room` int(5) NOT NULL DEFAULT '0' COMMENT '室',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级ID号',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '所属用户ID号',
  `attribute` tinyint(1) NOT NULL DEFAULT '0' COMMENT '房屋属性；默认0：租赁；1：房东',
  `profee` decimal(10,0) NOT NULL DEFAULT '0' COMMENT '该房间物业费用',
  `village_id` int(11) NOT NULL DEFAULT '0' COMMENT '小区ID号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pro_room
-- ----------------------------

-- ----------------------------
-- Table structure for pro_user
-- ----------------------------
DROP TABLE IF EXISTS `pro_user`;
CREATE TABLE `pro_user` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID号',
  `nickname` varchar(255) NOT NULL DEFAULT '' COMMENT '用户昵称',
  `headimgurl` varchar(255) NOT NULL DEFAULT '' COMMENT '用户头像',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户性别；0：女；1：男；2：未知性别',
  `openid` varchar(50) NOT NULL DEFAULT '' COMMENT '用户openID号',
  `tel` varchar(255) NOT NULL DEFAULT '' COMMENT '用户手机号',
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户状态；默认1：待认证；0：拉黑；2：已认证',
  `username` varchar(255) NOT NULL DEFAULT '' COMMENT '用户姓名',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pro_user
-- ----------------------------
INSERT INTO `pro_user` VALUES ('23', '雨后桥前', 'http://thirdwx.qlogo.cn/mmopen/vi_32/YODlKLdWsgPrkEwv8tnxPTGia8ATHgp1NWOGeN76OtvnpsE2YfYaaB9SRMQOO3hzIVlsP6fjXw9KmUzjqpGXaWw/132', '1', 'oeGmAxFJCnZbk-cVrSO0YPVIjGJQ', '17678328512', '2018-05-15 11:46:37', '2018-05-16 17:18:45', '2', '孙乔雨');
INSERT INTO `pro_user` VALUES ('25', '雨后桥前2号', 'http://thirdwx.qlogo.cn/mmopen/vi_32/icXowsOdKyDKEAWibukuFaj3r9B3WdSEJQxCn4keFQEbdyYB6jkxUx9gj0ibUCiaEbrwRxze8md4jhOvHQ1gqUniaWg/132', '0', 'oeGmAxJjixOG_byKruGz94aiF6JU', '17678328512', '2018-05-16 20:06:20', '2018-05-17 11:22:29', '2', '王二哈');
INSERT INTO `pro_user` VALUES ('26', 'Together *', 'http://thirdwx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTImtKhvl4ibOs73S3fSGVsXiarkg8qm4RLcOCPibP50cZiaKUZwibjbWXseJKzgdo8WNAg79CiatC6WM4mg/132', '1', 'oeGmAxAgXLy-pKdN_iK9TLWh1BZM', '13166956624', '2018-05-17 11:32:17', '2018-05-17 11:34:33', '2', '明明');

-- ----------------------------
-- Table structure for pro_village
-- ----------------------------
DROP TABLE IF EXISTS `pro_village`;
CREATE TABLE `pro_village` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '小区列表序号',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '小区名称',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '小区地址',
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pro_village
-- ----------------------------
INSERT INTO `pro_village` VALUES ('7', '锦湖家园', '金沙湖天街对面', '2018-05-18 13:15:13', '2018-05-18 13:25:34');
INSERT INTO `pro_village` VALUES ('8', '甘长村', '石祥路东信路交叉路口', '2018-05-18 13:37:45', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for tb_lemon_index
-- ----------------------------
DROP TABLE IF EXISTS `tb_lemon_index`;
CREATE TABLE `tb_lemon_index` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(20) DEFAULT NULL,
  `phone` char(11) DEFAULT NULL,
  `c_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `手机号索引` (`phone`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=1000001 DEFAULT CHARSET=utf8 COMMENT='索引演示表';
