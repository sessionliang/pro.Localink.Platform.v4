SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `ds_nodes`;
CREATE TABLE `ds_nodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `node_name` varchar(155) NOT NULL DEFAULT '' COMMENT '节点名称',
  `control_name` varchar(155) NOT NULL DEFAULT '' COMMENT '控制器名',
  `action_name` varchar(155) NOT NULL COMMENT '方法名',
  `is_menu` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否是菜单项 1不是 2是',
  `type_id` int(11) NOT NULL COMMENT '父级节点id',
  `style` varchar(155) DEFAULT '' COMMENT '菜单样式',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('1','权限管理','#','#','2','0','fa fa-users');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('2','管理员管理','user','index','2','1','');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('3','添加管理员','user','useradd','1','2','');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('4','编辑管理员','user','useredit','1','2','');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('5','删除管理员','user','userdel','1','2','');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('6','角色管理','role','index','2','1','');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('7','添加角色','role','roleadd','1','6','');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('8','编辑角色','role','roleedit','1','6','');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('9','删除角色','role','roledel','1','6','');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('10','分配权限','role','giveaccess','1','6','');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('11','平台管理','#','#','2','0','fa fa-desktop');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('12','数据备份/还原','data','index','2','11','');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('13','备份数据','data','importdata','1','12','');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('14','还原数据','data','backdata','1','12','');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('15','节点管理','node','index','2','1','');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('16','添加节点','node','nodeadd','1','15','');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('17','编辑节点','node','nodeedit','1','15','');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('18','删除节点','node','nodedel','1','15','');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('19','文章管理','article','index','2','0','fa fa-book');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('20','文章列表','article','index','2','19','');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('21','添加文章','article','articleadd','1','19','');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('22','编辑文章','article','articleedit','1','19','');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('23','删除文章','article','articledel','1','19','');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('24','上传图片','article','uploadImg','1','19','');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('26','微信平台','#','#','2','0','fa fa-wechat');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('27','公众号管理','weixin/mp','mplist','2','26','');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('28','微信应用','#','#','2','0','fa fa-map');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('29','内部管理','#','#','2','0','fa fa-gear');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('30','部门设置管理','department','index','2','29','');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('31','店铺管理','shop','index','2','29','');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('32','收银员管理','cashier','index','2','29','');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('33','店员管理','salesperson','index','2','29','');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('34','会员管理','#','#','2','0','fa fa-user');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('35','会员管理','member','index','2','34','');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('36','插件管理','addon','index','2','26','');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('37','操作日志','adminlog','index','2','11','');
insert into `ds_nodes`(`id`,`node_name`,`control_name`,`action_name`,`is_menu`,`type_id`,`style`) values('38','系统日志','systemlog','index','2','11','');
