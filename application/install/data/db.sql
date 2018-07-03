/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : 127.0.0.1:3306
Source Database       : DepStore

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-09-16 19:00:31
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tp_articles
-- ----------------------------
DROP TABLE IF EXISTS `tp_articles`;
CREATE TABLE `tp_articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章id',
  `title` varchar(155) NOT NULL COMMENT '文章标题',
  `description` varchar(255) NOT NULL COMMENT '文章描述',
  `keywords` varchar(155) NOT NULL COMMENT '文章关键字',
  `thumbnail` varchar(255) NOT NULL COMMENT '文章缩略图',
  `content` text NOT NULL COMMENT '文章内容',
  `add_time` datetime NOT NULL COMMENT '发布时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_articles
-- ----------------------------
INSERT INTO `tp_articles` VALUES ('2', '文章标题', '文章描述', '关键字1,关键字2,关键字3', '/upload/20170916/1e915c70dbb9d3e8a07bede7b64e4cff.png', '<p><img src=\"/upload/image/20170916/1505555254.png\" title=\"1505555254.png\" alt=\"QQ截图20170916174651.png\"/></p><p>测试文章内容</p><p>测试内容</p>', '2017-09-16 17:47:44');


-- ----------------------------
-- Table structure for tp_tenants 租户表
-- ----------------------------
DROP TABLE IF EXISTS `tp_tenants`;
CREATE TABLE IF NOT EXISTS `tp_tenants`(
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '租户名称',
  `dbstr` text NOT NULL COMMENT '数据库链接字符串',
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='租户表';


-- ----------------------------
-- Table structure for tp_nodes
-- ----------------------------
DROP TABLE IF EXISTS `tp_nodes`;
CREATE TABLE `tp_nodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `node_name` varchar(155) NOT NULL DEFAULT '' COMMENT '节点名称',
  `control_name` varchar(155) NOT NULL DEFAULT '' COMMENT '控制器名',
  `action_name` varchar(155) NOT NULL COMMENT '方法名',
  `is_menu` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否是菜单项 1不是 2是',
  `type_id` int(11) NOT NULL COMMENT '父级节点id',
  `style` varchar(155) DEFAULT '' COMMENT '菜单样式',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of tp_nodes
-- ----------------------------

insert into `tp_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('26','权限管理','#','#','2','0','fa fa-users');
insert into `tp_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('27','管理员管理','user','index','2','26','');
insert into `tp_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('28','添加管理员','user','useradd','1','27','');
insert into `tp_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('29','编辑管理员','user','useredit','1','27','');
insert into `tp_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('30','删除管理员','user','userdel','1','27','');
insert into `tp_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('31','角色管理','role','index','2','26','');
insert into `tp_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('32','添加角色','role','roleadd','1','31','');
insert into `tp_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('33','编辑角色','role','roleedit','1','31','');
insert into `tp_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('34','删除角色','role','roledel','1','31','');
insert into `tp_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('35','分配权限','role','giveaccess','1','31','');
insert into `tp_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('36','节点管理','node','index','2','26','');
insert into `tp_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('37','添加节点','node','nodeadd','1','36','');
insert into `tp_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('38','编辑节点','node','nodeedit','1','36','');
insert into `tp_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('39','删除节点','node','nodedel','1','36','');

insert into `tp_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('49','平台管理','#','#','2','0','fa fa-desktop');
insert into `tp_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('50','数据备份/还原','data','index','2','49','');
insert into `tp_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('51','备份数据','data','importdata','1','50','');
insert into `tp_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('52','还原数据','data','backdata','1','50','');
insert into `tp_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('53','操作日志','adminlog','index','2','49','');
insert into `tp_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('54','清空操作日志','adminlog','adminlogdel','1','53','');
insert into `tp_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('55','系统日志','systemlog','index','2','49','');
insert into `tp_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('56','清空系统日志','systemlog','systemlogdel','1','55','');
insert into `tp_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('57','平台配置','setting','index','2','49','');

-- ----------------------------
-- Table structure for tp_roles
-- ----------------------------
DROP TABLE IF EXISTS `tp_roles`;
CREATE TABLE `tp_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `role_name` varchar(155) NOT NULL COMMENT '角色名称',
  `rule` varchar(255) DEFAULT '' COMMENT '权限节点数据',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of tp_role
-- ----------------------------
INSERT INTO `tp_roles` VALUES ('1', '超级管理员', '*');
INSERT INTO `tp_roles` VALUES ('2', '系统维护员', '55,56,57,58,59,60');

-- ----------------------------
-- Table structure for tp_users
-- ----------------------------
DROP TABLE IF EXISTS `tp_users`;
CREATE TABLE `tp_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '密码',
  `login_times` int(11) NOT NULL DEFAULT '0' COMMENT '登陆次数',
  `last_login_ip` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `real_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '真实姓名',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `role_id` int(11) NOT NULL DEFAULT '1' COMMENT '用户角色id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of tp_users
-- ----------------------------
INSERT INTO `tp_users` VALUES ('1', 'admin', '21232f297a57a5a743894a0e4a801fc3', '41', '127.0.0.1', '1505559479', 'admin', '1', '1');


-- ----------------------------
-- Table structure for tp_settings 平台配置表
-- ----------------------------
DROP TABLE IF EXISTS `tp_settings`;
CREATE TABLE IF NOT EXISTS `tp_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '配置项名称',
  `value` text NOT NULL COMMENT '配置值',
  `cate` varchar(50) NULL COMMENT '分类',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `creator_id` int(10) NULL COMMENT '创建人id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='平台配置表';

-- ----------------------------
-- Table structure for tp_admin_logs 管理员日志表
-- ----------------------------
DROP TABLE IF EXISTS `tp_admin_logs`;
CREATE TABLE IF NOT EXISTS `tp_admin_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL COMMENT '日志',
  `message` text NULL COMMENT '详细',
  `user_name` varchar(50) NULL COMMENT '管理员名称',
  `ip` varchar(50) NULL COMMENT 'ip地址',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员日志表';

-- ----------------------------
-- Table structure for tp_system_logs 系统日志表
-- ----------------------------
DROP TABLE IF EXISTS `tp_system_logs`;
CREATE TABLE IF NOT EXISTS `tp_system_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL COMMENT '日志',
  `message` text NULL COMMENT '详细',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统日志表';


-- ----------------------------
-- Table structure for tp_localink_communitys 小区
-- ----------------------------
DROP TABLE IF EXISTS `tp_localink_communitys`;
CREATE TABLE IF NOT EXISTS `tp_localink_communitys`(
  `id` int(11) NOT NULL  AUTO_INCREMENT,
  `cname` varchar(50) NOT NULL COMMENT '小区名称',
  `address` varchar(100) NULL COMMENT '地址',
  `Lat` decimal(10,7) NULL COMMENT '维度',
  `Lng` decimal(10,7) NULL COMMENT '经度',
  `images` varchar(1000) NULL COMMENT '小区图片',
  `is_auth` tinyint(1) NOT NULL DEFAULT '0' COMMENT '妙兜是否认证：0-否，1-是',
  `depart_id` varchar(50) NULL COMMENT '妙兜小区ID',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除：0-否，1-是',
  `delete_time` int(10) NULL COMMENT '删除时间',
  `deleter_id` int(10) NULL COMMENT '删除人id',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `creator_id` int(10) NULL COMMENT '创建人id',
  `update_time` int(10) NOT NULL COMMENT '修改时间',
  `updater_id` int(10) NULL COMMENT '修改人id',
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='小区表';

-- ----------------------------
-- Table structure for tp_localink_buildings 单元楼
-- ----------------------------
DROP TABLE IF EXISTS `tp_localink_buildings`;
CREATE TABLE IF NOT EXISTS `tp_localink_buildings`(
  `id` int(11) NOT NULL  AUTO_INCREMENT,
  `community_id` int(11) NOT NULL COMMENT '小区ID',
  `bname` varchar(50) NOT NULL COMMENT '单元楼名称',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除：0-否，1-是',
  `delete_time` int(10) NULL COMMENT '删除时间',
  `deleter_id` int(10) NULL COMMENT '删除人id',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `creator_id` int(10) NULL COMMENT '创建人id',
  `update_time` int(10) NOT NULL COMMENT '修改时间',
  `updater_id` int(10) NULL COMMENT '修改人id',
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='单元楼';


-- ----------------------------
-- Table structure for tp_localink_flatnumbers 门牌号
-- ----------------------------
DROP TABLE IF EXISTS `tp_localink_flatnumbers`;
CREATE TABLE IF NOT EXISTS `tp_localink_flatnumbers`(
  `id` int(11) NOT NULL  AUTO_INCREMENT,
  `community_id` int(11) NOT NULL COMMENT '小区ID',
  `building_id` int(11) NOT NULL COMMENT '单元ID',
  `flatno` varchar(50) NOT NULL COMMENT '门牌号',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除：0-否，1-是',
  `delete_time` int(10) NULL COMMENT '删除时间',
  `deleter_id` int(10) NULL COMMENT '删除人id',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `creator_id` int(10) NULL COMMENT '创建人id',
  `update_time` int(10) NOT NULL COMMENT '修改时间',
  `updater_id` int(10) NULL COMMENT '修改人id',
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='门牌号表';


-- ----------------------------
-- Table structure for tp_localink_doors 门禁
-- ----------------------------
DROP TABLE IF EXISTS `tp_localink_doors`;
CREATE TABLE IF NOT EXISTS `tp_localink_doors`(
  `id` int(11) NOT NULL  AUTO_INCREMENT,
  `community_id` int(11) NULL COMMENT '小区ID',
  `building_id` int(11) NULL COMMENT '单元ID',
  `flatno_id` int(11) NULL COMMENT '门牌号ID',
  `door_name` varchar(50) NOT NULL COMMENT '门禁名称',
  `door_type` tinyint(1) NOT NULL COMMENT '门禁类型：待完善',
  `is_auth` tinyint(1) NOT NULL DEFAULT '0' COMMENT '妙兜是否认证：0-否，1-是',
  `depart_id` varchar(50) NULL COMMENT '妙兜小区ID',
  `pid` varchar(50) NULL COMMENT '妙兜锁sn',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除：0-否，1-是',
  `delete_time` int(10) NULL COMMENT '删除时间',
  `deleter_id` int(10) NULL COMMENT '删除人id',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `creator_id` int(10) NULL COMMENT '创建人id',
  `update_time` int(10) NOT NULL COMMENT '修改时间',
  `updater_id` int(10) NULL COMMENT '修改人id',
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='门禁表';