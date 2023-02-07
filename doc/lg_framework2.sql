
-- 后台用户组表
DROP TABLE IF EXISTS `lg_staff_group`;
CREATE TABLE `lg_staff_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT  COMMENT 'ID',
  `group_name` varchar(64) NOT NULL DEFAULT '' COMMENT '用户组名称',
  `note` text NOT NULL DEFAULT '' COMMENT '备注',
  `is_delete` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否删除:0-否；1-删除',
  `add_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
  `edit_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`group_id`)
) ENGINE=INNODB  DEFAULT CHARSET=utf8mb4 COMMENT='后台用户组表';
insert into `lg_staff_group` ( `is_delete`, `add_time`, `group_name`, `note`, `edit_time`, `group_id`) values ( '1', '0000-00-00 00:00:00', '管理员组', '管理员组', '0000-00-00 00:00:00', '1');


-- 后台用户表
DROP TABLE IF EXISTS `lg_staff`;
CREATE TABLE `lg_staff` (
  `staff_id` int(11) NOT NULL AUTO_INCREMENT  COMMENT '主键',
  `group_id` int(11) NOT NULL COMMENT '用户组ID',
  `username` varchar(64) NOT NULL DEFAULT ''  COMMENT '用户名',
  `password` varchar(64) NOT NULL DEFAULT ''  COMMENT '密码',
  `truename` varchar(32) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `is_super` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否超级用户',
  `ifmod` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否通过',
  `headlogo_url` varchar(256) NOT NULL DEFAULT '' COMMENT '用户头像',
  `note` varchar(512) NOT NULL DEFAULT '' COMMENT '备注',
  `add_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
  `edit_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`staff_id`),
  KEY `group_id` (`group_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COMMENT='后台用户表';
insert into `lg_staff` ( `truename`, `password`, `group_id`, `headlogo_url`, `note`, `is_super`, `add_time`, `username`, `staff_id`, `edit_time`, `ifmod`) values ( '超级管理员', 'e10adc3949ba59abbe56e057f20f883e', '1', '/ware/upload/staff/20160725/a4e3a6df87cbf83591d7cb193467ae26.png', '', '1', '0000-00-00 00:00:00', 'admin', '1', '2019-06-03 12:00:02', '1');

-- 后台用户登录日志表
DROP TABLE IF EXISTS `lg_staff_login_log`;
CREATE TABLE `lg_staff_login_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `staff_id` int(11) NOT NULL DEFAULT '0' COMMENT '后台用户ID',
  `username` varchar(64) NOT NULL DEFAULT ''  COMMENT '用户名',
  `login_ip` varchar(16) NOT NULL COMMENT 'ip地址',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`log_id`),
  KEY `staff_id` (`staff_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT='后台用户登录日志表';


-- 后台用户操作日志表
DROP TABLE IF EXISTS `lg_staff_action_log`;
CREATE TABLE `lg_staff_action_log` (
  `log_id` int(11) unsigned NOT NULL AUTO_INCREMENT  COMMENT '主键',
  `type` varchar(16) NOT NULL DEFAULT '' COMMENT '日志类型',
  `action_type_id` smallint(6) NOT NULL DEFAULT '0' COMMENT '操作类型ID（和后台权限菜单表（lyx_staff_right_menus）ID对应）',
  `main_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作类型主表主键ID',
  `staff_id` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '后台用户ID',
  `log_info` text NOT NULL COMMENT '操作信息',
  `ip_address` varchar(16) NOT NULL DEFAULT '' COMMENT 'ip地址',
  `add_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '操作时间',
  PRIMARY KEY (`log_id`),
  KEY `staff_uid` (`staff_id`),
  KEY `action_type_id` (`action_type_id`,`main_id`)
) ENGINE=INNODB  DEFAULT CHARSET=utf8mb4 COMMENT='后台用户操作日志表';

-- 后台权限菜单表
DROP TABLE IF EXISTS `lg_staff_right_menus`;
CREATE TABLE `lg_staff_right_menus` (
  `sr_menu_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `level` tinyint(2) NOT NULL DEFAULT '1' COMMENT '层级',
  `parent_id` int(11) NOT NULL COMMENT '父ID',
  `right_name` varchar(64) NOT NULL DEFAULT '' COMMENT '权限名称',
  `right_code` varchar(32) NOT NULL DEFAULT '' COMMENT '权限CODE码',
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1-可用；0-不可用',
  `note` varchar(256) NOT NULL DEFAULT '' COMMENT '备注',
  `url` varchar(256) NOT NULL DEFAULT '' COMMENT 'url地址',
  `sort_num` int(11) NOT NULL DEFAULT '0',
  `icon` varchar(16) NOT NULL,
  PRIMARY KEY (`sr_menu_id`),
  KEY `level` (`level`)
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='后台权限菜单表';


-- 后台用户权限对应表
DROP TABLE IF EXISTS `lyx_staff_rights`;
CREATE TABLE `lyx_staff_rights` (
  `sr_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `staff_id` int(11) NOT NULL COMMENT '员工ID',
  `right_id` int(11) NOT NULL COMMENT '权限ID',
  PRIMARY KEY (`sr_id`),
  UNIQUE KEY `uni_staff_right` (`staff_id`,`right_id`)
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='后台用户权限对应表';


-- 后台用户组权限对应表
DROP TABLE IF EXISTS `lyx_staff_group_rights`;
CREATE TABLE `lyx_staff_group_rights` (
  `sgr_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `group_id` int(11) NOT NULL COMMENT '组ID',
  `right_id` int(11) NOT NULL COMMENT '权限ID',
  PRIMARY KEY (`sgr_id`),
  UNIQUE KEY `uni_staff_grpup_right` (`group_id`,`right_id`)
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='后台用户组权限对应表';

-- IP黑名单表名单表'
CREATE TABLE `lyx_blackid_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `ip` varchar(16) NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：0-关闭；1-启用',
  `add_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `ip` (`ip`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COMMENT='IP黑名单表';


-- api请求授权表
CREATE TABLE `lyx_api_authorize` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(128) NOT NULL COMMENT '名称',
  `company_id` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000' COMMENT '企业ID',
  `access_key` varchar(40) NOT NULL,
  `secret_key` varchar(40) NOT NULL,
  `expire` datetime NOT NULL COMMENT '有效期：0-长久有效',
  `status` varchar(255) NOT NULL DEFAULT '1' COMMENT '状态：0-不可用；1-可用',
  `access_count` int(11) DEFAULT '0' COMMENT '累计调用次数',
  `rate_minute` smallint(6) DEFAULT '0' COMMENT '每分钟请求次数（等于0表示不限制）',
  `rate_hour` smallint(6) DEFAULT '0' COMMENT '每小时请求次数（等于0表示不限制）',
  `rate_day` smallint(6) DEFAULT '0' COMMENT '每天请求次数（0表示不限制）',
  `rate_month` smallint(6) DEFAULT '0' COMMENT '每月请求次数(0-表示不限制)',
  `white_list` varchar(255) DEFAULT '' COMMENT '白名单',
  `access_type` tinyint(2) DEFAULT '1' COMMENT '访问类型:1-公开访问；2-白名单；',
  `uuid` varchar(64) DEFAULT '' COMMENT '唯一ID',
  `add_time` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `update_time` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`) USING BTREE,
  KEY `indx_ak_sk` (`access_key`,`secret_key`) USING BTREE,
  KEY `uuid` (`uuid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Api调用请求授权表';

CREATE TABLE `lyx_urls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sha1` char(40) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_at` int(11) NOT NULL,
  `creator` int(11) unsigned NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `expire` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sha1` (`sha1`),
  KEY `create_at` (`create_at`),
  KEY `creator` (`creator`),
  KEY `count` (`count`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='URL地址映射表';


CREATE TABLE `lyx_short_addrs` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT '名称，根据shorturl自动生成',
  `sha1` char(40) COLLATE utf8_unicode_ci NOT NULL COMMENT 'short_url的hash值',
  `short_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '短链接地址',
  `add_time` date not null   NOT NULL COMMENT '添加时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：0-禁用;1-启用',
  `company_id` int(11) NOT NULL COMMENT '企业ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sha1` (`sha1`),
  UNIQUE KEY `name` (`name`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='短网址地址表';
