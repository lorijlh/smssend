SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for sms_account
-- ----------------------------
DROP TABLE IF EXISTS `dh2y_account`;
CREATE TABLE `dh2y_account`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `symbol` enum('+','-') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '+' COMMENT '资金符号',
  `money` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '资金',
  `balance` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '余额',
  `remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `create_time` int(11) NULL DEFAULT NULL COMMENT '添加时间',
  `update_time` int(11) NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '财务明细记录' ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table structure for sms_admin
-- ----------------------------
DROP TABLE IF EXISTS `dh2y_admin`;
CREATE TABLE `dh2y_admin`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `admin_name` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '管理员姓名',
  `password` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `token` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1 COMMENT '{1:开启,0:关闭}',
  `last_login` int(11) NULL DEFAULT 0 COMMENT '最后登录时间',
  `balance` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '余额',
  `num` int(11) NOT NULL DEFAULT 0 COMMENT '短信剩余条数',
  `vip` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'vip 0普通用户 1会员用户',
  `vip_time` int(11) NULL DEFAULT 0 COMMENT 'vip到期时间',
  `login_ip` varchar(126) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '登录ip',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '管理员' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sms_admin
-- ----------------------------
INSERT INTO `dh2y_admin` VALUES (1, 'admin', 'Boss', '909e0d7b67203e856abab3ee7d073dbf', '0ZykT6', 'dkewl@qq.com', 1, 1625495945, 1.00, 9975, 1, 1751290164, '221.178.124.98', 0, 0);
-- ----------------------------
-- Table structure for sms_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `dh2y_auth_group`;
CREATE TABLE `dh2y_auth_group`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `rules` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sms_auth_group
-- ----------------------------
INSERT INTO `dh2y_auth_group` VALUES (1, '超级管理员', 1, '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,32,31,30,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70');
INSERT INTO `dh2y_auth_group` VALUES (2, '平台用户', 1, '18,23,24,25,27,28,29,30,31,32,33,35,36,37,38,39,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,on,62');

-- ----------------------------
-- Table structure for sms_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `dh2y_auth_group_access`;
CREATE TABLE `dh2y_auth_group_access`  (
  `uid` mediumint(8) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL,
  UNIQUE INDEX `uid_group_id`(`uid`, `group_id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `group_id`(`group_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of sms_auth_group_access
-- ----------------------------
INSERT INTO `dh2y_auth_group_access` VALUES (1, 1);

-- ----------------------------
-- Table structure for sms_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `dh2y_auth_rule`;
CREATE TABLE `dh2y_auth_rule`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` char(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `title` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT 1,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `condition` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mid` int(8) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `name`(`name`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 71 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of sms_auth_rule
-- ----------------------------
INSERT INTO `dh2y_auth_rule` VALUES (1, 'admin/menu/remove', '删除', 1, 1, '', 4);
INSERT INTO `dh2y_auth_rule` VALUES (2, 'admin/menu/edit', '编辑', 1, 1, '', 4);
INSERT INTO `dh2y_auth_rule` VALUES (3, 'admin/menu/add', '添加', 1, 1, '', 4);
INSERT INTO `dh2y_auth_rule` VALUES (4, 'admin/menu/index', '菜单列表', 1, 1, '', 4);
INSERT INTO `dh2y_auth_rule` VALUES (5, 'admin/auth/remove_group', '删除', 1, 1, '', 3);
INSERT INTO `dh2y_auth_rule` VALUES (6, 'admin/auth/edit_group', '编辑', 1, 1, '', 3);
INSERT INTO `dh2y_auth_rule` VALUES (7, 'admin/auth/add_group', '添加', 1, 1, '', 3);
INSERT INTO `dh2y_auth_rule` VALUES (8, 'admin/admin/index', '列表', 1, 1, '', 5);
INSERT INTO `dh2y_auth_rule` VALUES (9, 'admin/admin/add', '添加', 1, 1, '', 5);
INSERT INTO `dh2y_auth_rule` VALUES (10, 'admin/admin/edit', '编辑', 1, 1, '', 5);
INSERT INTO `dh2y_auth_rule` VALUES (11, 'admin/admin/remove', '删除', 1, 1, '', 5);
INSERT INTO `dh2y_auth_rule` VALUES (12, 'admin/admin/status', '状态更改', 1, 1, '', 5);
INSERT INTO `dh2y_auth_rule` VALUES (13, 'admin/auth/edit_access', '修改', 1, 1, '', 6);
INSERT INTO `dh2y_auth_rule` VALUES (14, 'admin/auth/add_access', '添加', 1, 1, '', 6);
INSERT INTO `dh2y_auth_rule` VALUES (15, 'admin/auth/remove', '删除', 1, 1, '', 6);
INSERT INTO `dh2y_auth_rule` VALUES (16, 'admin/auth/index', '权限列表', 1, 1, '', 6);
INSERT INTO `dh2y_auth_rule` VALUES (17, 'admin/auth/group_list', '角色列表', 1, 1, '', 3);
INSERT INTO `dh2y_auth_rule` VALUES (18, 'admin/sms/index', '群发对象', 1, 1, '', 8);
INSERT INTO `dh2y_auth_rule` VALUES (19, 'admin/service/index', '服务商', 1, 1, '', 7);
INSERT INTO `dh2y_auth_rule` VALUES (20, 'admin/service/add', '添加', 1, 1, '', 7);
INSERT INTO `dh2y_auth_rule` VALUES (21, 'admin/service/edit', '编辑', 1, 1, '', 7);
INSERT INTO `dh2y_auth_rule` VALUES (22, 'admin/service/remove', '删除', 1, 1, '', 7);
INSERT INTO `dh2y_auth_rule` VALUES (23, 'admin/sms/add', '添加', 1, 1, '', 8);
INSERT INTO `dh2y_auth_rule` VALUES (24, 'admin/sms/send', '发送短信', 1, 1, '', 8);
INSERT INTO `dh2y_auth_rule` VALUES (25, 'admin/sms/remove', '删除', 1, 1, '', 8);
INSERT INTO `dh2y_auth_rule` VALUES (26, 'admin/service/send', '发送短信', 1, 1, '', 7);
INSERT INTO `dh2y_auth_rule` VALUES (27, 'admin/sms/repet', '去重', 1, 1, '', 8);
INSERT INTO `dh2y_auth_rule` VALUES (28, 'admin/sms/bath_remove', '一键删除', 1, 1, '', 8);
INSERT INTO `dh2y_auth_rule` VALUES (29, 'admin/template/index', '列表', 1, 1, '', 54);
INSERT INTO `dh2y_auth_rule` VALUES (30, 'admin/template/remove', '删除', 1, 1, '', 54);
INSERT INTO `dh2y_auth_rule` VALUES (31, 'admin/template/add', '添加', 1, 1, '', 54);
INSERT INTO `dh2y_auth_rule` VALUES (32, 'admin/template/edit', '编辑', 1, 1, '', 54);
INSERT INTO `dh2y_auth_rule` VALUES (33, 'admin/template/params', '参数值替换', 1, 1, '', 54);
INSERT INTO `dh2y_auth_rule` VALUES (35, 'admin/sms/log', '发送记录', 1, 1, '', 55);
INSERT INTO `dh2y_auth_rule` VALUES (36, 'admin/member/index', '我的账号', 1, 1, '', 57);
INSERT INTO `dh2y_auth_rule` VALUES (37, 'admin/member/pay_log', '充值记录', 1, 1, '', 58);
INSERT INTO `dh2y_auth_rule` VALUES (38, 'admin/sms/del_log', '删除记录', 1, 1, '', 55);
INSERT INTO `dh2y_auth_rule` VALUES (39, 'admin/member/account', '财务明细', 1, 1, '', 59);
INSERT INTO `dh2y_auth_rule` VALUES (40, 'admin/setting/index', '系统设置', 1, 1, '', 10);
INSERT INTO `dh2y_auth_rule` VALUES (41, 'admin/setting/base', '基础配置', 1, 1, '', 10);
INSERT INTO `dh2y_auth_rule` VALUES (42, 'admin/setting/relation', '联系配置', 1, 1, '', 10);
INSERT INTO `dh2y_auth_rule` VALUES (43, 'admin/setting/redis', 'Redis配置', 1, 1, '', 10);
INSERT INTO `dh2y_auth_rule` VALUES (44, 'admin/links/index', '友情链接', 1, 1, '', 11);
INSERT INTO `dh2y_auth_rule` VALUES (45, 'admin/links/add', '添加', 1, 1, '', 11);
INSERT INTO `dh2y_auth_rule` VALUES (46, 'admin/links/edit', '编辑', 1, 1, '', 11);
INSERT INTO `dh2y_auth_rule` VALUES (47, 'admin/links/remove', '删除', 1, 1, '', 11);
INSERT INTO `dh2y_auth_rule` VALUES (48, 'admin/document/index', '文章列表', 1, 1, '', 12);
INSERT INTO `dh2y_auth_rule` VALUES (49, 'admin/document/add', '添加', 1, 1, '', 12);
INSERT INTO `dh2y_auth_rule` VALUES (50, 'admin/document/edit', '编辑', 1, 1, '', 12);
INSERT INTO `dh2y_auth_rule` VALUES (51, 'admin/document/remove', '删除', 1, 1, '', 12);
INSERT INTO `dh2y_auth_rule` VALUES (52, 'admin/document/status', '状态更改', 1, 1, '', 12);
INSERT INTO `dh2y_auth_rule` VALUES (53, 'admin/setting/pay', '支付设置', 1, 1, '', 13);
INSERT INTO `dh2y_auth_rule` VALUES (54, 'admin/setting/alipay', '支付宝支付', 1, 1, '', 13);
INSERT INTO `dh2y_auth_rule` VALUES (55, 'admin/setting/bank', '银行卡支付', 1, 1, '', 13);
INSERT INTO `dh2y_auth_rule` VALUES (56, 'admin/setting/usdt', 'USDT支付', 1, 1, '', 13);
INSERT INTO `dh2y_auth_rule` VALUES (57, 'admin/goods/index', '套餐列表', 1, 1, '', 14);
INSERT INTO `dh2y_auth_rule` VALUES (58, 'admin/goods/add', '添加', 1, 1, '', 14);
INSERT INTO `dh2y_auth_rule` VALUES (59, 'admin/goods/edit', '编辑', 1, 1, '', 14);
INSERT INTO `dh2y_auth_rule` VALUES (60, 'admin/goods/remove', '删除', 1, 1, '', 14);
INSERT INTO `dh2y_auth_rule` VALUES (61, 'admin/goods/status', '状态更改', 1, 1, '', 14);
INSERT INTO `dh2y_auth_rule` VALUES (62, 'admin/tag/index', '群组信息', 1, 1, '', 8);
INSERT INTO `dh2y_auth_rule` VALUES (63, 'admin/business/recharge', '充值管理', 1, 1, '', 61);
INSERT INTO `dh2y_auth_rule` VALUES (64, 'admin/business/account', '财务管理', 1, 1, '', 62);
INSERT INTO `dh2y_auth_rule` VALUES (65, 'admin/business/member', '用户管理', 1, 1, '', 63);
INSERT INTO `dh2y_auth_rule` VALUES (66, 'admin/business/audit', '充值审核', 1, 1, '', 61);
INSERT INTO `dh2y_auth_rule` VALUES (67, 'admin/business/remove', '删除充值', 1, 1, '', 61);
INSERT INTO `dh2y_auth_rule` VALUES (68, 'admin/business/capital', '加减款', 1, 1, '', 63);
INSERT INTO `dh2y_auth_rule` VALUES (69, 'admin/business/log', '短信记录', 1, 1, '', 64);
INSERT INTO `dh2y_auth_rule` VALUES (70, 'admin/business/sms_num', '加减短信', 1, 1, '', 63);

-- ----------------------------
-- Table structure for sms_document
-- ----------------------------
DROP TABLE IF EXISTS `dh2y_document`;
CREATE TABLE `dh2y_document`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `des` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `thumb_img` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `show` tinyint(4) NOT NULL DEFAULT 1,
  `read` int(255) NOT NULL DEFAULT 0,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '文档介绍' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sms_document
-- ----------------------------
INSERT INTO `dh2y_document` VALUES (1, '产品功能', '一款辅助的短信，群发工具。可绕过短信服务商的模板审核。发你想发的内容', '/static/index/img/Product_img1.jpg', '<p>一款辅助的短信，群发工具。可绕过短信服务商的模板审核。发你想发的内容</p>', 1, 2145, 1612000086, 1612000086);
INSERT INTO `dh2y_document` VALUES (2, '短信服务商配置', '本系统只是工具，不提供短信包。需要去服务商购买，拿到参数在系统里配置。', '/static/index/img/Product_img2.jpg', '<p>本系统只是工具，不提供短信包。需要去服务商购买，拿到参数在系统里配置。</p>', 1, 1582, 1612000086, 1612000086);
INSERT INTO `dh2y_document` VALUES (3, '申请模板', '如果是模板类的短信服务商，需要申请模板。随便申请一个即可', '/static/index/img/Product_img2.jpg', '<p>如果是模板类的短信服务商，需要申请模板。随便申请一个即可</p>', 1, 3531, 1612000086, 1612000086);
INSERT INTO `dh2y_document` VALUES (4, '批量导入用户', '批量导入用户，文件名称就是导入用户的标签。通过标签可以进行人群定位发送', '/static/index/img/Product_img2.jpg', '<p><span style=\"font-family: &quot;Helvetica Neue&quot;, Helvetica, &quot;PingFang SC&quot;, Tahoma, Arial, sans-serif; font-size: 18px; text-align: justify; background-color: rgb(255, 255, 255);\">批量导入用户，文件名称就是导入用户的标签。通过标签可以进行人群定位发送</span></p>', 1, 2957, 1612000086, 1612000086);
INSERT INTO `dh2y_document` VALUES (5, '免费测试短信群发流程', '注册完毕后联系客服飞机@sms456com 发送您的会员账号即可免费测试10条', 'https://www.sms456.com/static/index/img/Product_img2.jpg', '<p><span style=\"font-size: 16px;\">1.打开我们官方网站www.sms456.com注册个会员！</span></p><p><span style=\"font-size: 16px;\">2.注册完毕后联系客服飞机@sms456com 发送您的会员账号即可免费测试10条</span></p><p><span style=\"font-size: 16px;\">3.登录后台→短信模板→提交您的模板</span></p><p><span style=\"font-size: 16px;\">4.群发对象→导入联系人→即可发送短信</span></p><p><span style=\"font-size: 16px;\">5.提交模板演示图</span></p><p><img src=\"https://apk.ml8s.com/sms/a1.png\" width=\"\" height=\"\" title=\"\" alt=\"\"/></p><p><img src=\"https://apk.ml8s.com/sms/a4.png\"/></p><p><span style=\"font-size: 16px;\">6.批量导入演示图</span></p><p><img src=\"https://apk.ml8s.com/sms/a2.png\" width=\"\" height=\"\" title=\"\" alt=\"\"/></p><p><img src=\"https://apk.ml8s.com/sms/a3.png\" width=\"\" height=\"\" title=\"\" alt=\"\"/></p><p><br/></p><p><span style=\"font-size: 16px;\">7.群发短信演示图</span></p><p><span style=\"font-size: 16px;\"><img src=\"https://apk.ml8s.com/sms/a5.png\" width=\"\" height=\"\" title=\"\" alt=\"\"/></span></p>', 1, 1851, 1625366940, 1625366940);

-- ----------------------------
-- Table structure for sms_goods
-- ----------------------------
DROP TABLE IF EXISTS `dh2y_goods`;
CREATE TABLE `dh2y_goods`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `day` int(11) NOT NULL COMMENT '天数',
  `give` int(11) NOT NULL DEFAULT 0 COMMENT '赠送天数',
  `price` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '价格',
  `usdt` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT 'usdt价格',
  `num` int(11) NOT NULL DEFAULT 0 COMMENT '可发送的短信条数',
  `state` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态',
  `create_time` int(11) NULL DEFAULT NULL COMMENT '添加时间',
  `update_time` int(11) NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '充值套餐' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sms_goods
-- ----------------------------
INSERT INTO `dh2y_goods` VALUES (1, '1万条[国内套餐通道]', 365, 0, 2350.00, 363.63, 10000, 1, 1612000086, 1612000086);
INSERT INTO `dh2y_goods` VALUES (2, '1万条[海外套餐通道]', 365, 0, 2550.00, 394.58, 10000, 1, 1612000086, 1612000086);
INSERT INTO `dh2y_goods` VALUES (3, '5万条[黑五类国内通道]', 365, 0, 10000.00, 1547.37, 50000, 1, 1612000086, 1612000086);
INSERT INTO `dh2y_goods` VALUES (4, '5万条[黑五类外海通道]', 365, 0, 11000.00, 1702.10, 50000, 1, 1612000086, 1612000086);
INSERT INTO `dh2y_goods` VALUES (5, '20万条[无限制通道]', 999, 0, 27000.00, 4177.89, 200000, 1, 1625027852, 1625027852);
INSERT INTO `dh2y_goods` VALUES (6, '50万条[无限制通道]', 999, 0, 55000.00, 8510.51, 500000, 1, 1625027872, 1625027872);

-- ----------------------------
-- Table structure for sms_links
-- ----------------------------
DROP TABLE IF EXISTS `dh2y_links`;
CREATE TABLE `dh2y_links`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `links` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `state` tinyint(4) NOT NULL DEFAULT 1 COMMENT '上架',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '友情链接' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sms_links
-- ----------------------------
INSERT INTO `dh2y_links` VALUES (1, 'ac', 'https://gmail.com/', 1, 1612008141, 1612008141);

-- ----------------------------
-- Table structure for sms_menu
-- ----------------------------
DROP TABLE IF EXISTS `dh2y_menu`;
CREATE TABLE `dh2y_menu`  (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `pid` smallint(6) NOT NULL DEFAULT 0,
  `title` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '菜单名称',
  `link` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '链接',
  `icon` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '字体图标',
  `sort` smallint(6) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 65 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '菜单表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sms_menu
-- ----------------------------
INSERT INTO `dh2y_menu` VALUES (1, 0, '权限管理', '#', 'Hui-iconfont-user-group', 1);
INSERT INTO `dh2y_menu` VALUES (2, 0, '短信管理', '#', 'Hui-iconfont-news', 3);
INSERT INTO `dh2y_menu` VALUES (3, 1, '角色管理', '/admin/auth/group_list', '', 1);
INSERT INTO `dh2y_menu` VALUES (4, 1, '菜单模块', '/admin/menu/index', '', 1);
INSERT INTO `dh2y_menu` VALUES (5, 1, '用户列表', '/admin/admin/index', '', 1);
INSERT INTO `dh2y_menu` VALUES (6, 1, '权限列表', '/admin/auth/index', '', 1);
INSERT INTO `dh2y_menu` VALUES (7, 2, '短信服务商', '/admin/service/index', '', 1);
INSERT INTO `dh2y_menu` VALUES (8, 2, '群发对象', '/admin/sms/index', '', 1);
INSERT INTO `dh2y_menu` VALUES (9, 0, '系统管理', '#', 'Hui-iconfont-jifen', 1);
INSERT INTO `dh2y_menu` VALUES (10, 9, '系统设置', '/admin/setting/index', '', 1);
INSERT INTO `dh2y_menu` VALUES (11, 9, '友情链接', '/admin/links/index', '', 1);
INSERT INTO `dh2y_menu` VALUES (12, 9, '文章管理', '/admin/document/index', '', 1);
INSERT INTO `dh2y_menu` VALUES (13, 9, '支付设置', '/admin/setting/pay', '', 1);
INSERT INTO `dh2y_menu` VALUES (14, 9, '充值套餐', '/admin/goods/index', '', 1);
INSERT INTO `dh2y_menu` VALUES (54, 2, '短信模板', '/admin/template/index', '', 1);
INSERT INTO `dh2y_menu` VALUES (55, 56, '发送记录', '/admin/sms/log', '', 3);
INSERT INTO `dh2y_menu` VALUES (56, 0, '个人中心', '#', 'Hui-iconfont-user2', 1);
INSERT INTO `dh2y_menu` VALUES (57, 56, '我的账号', '/admin/member/index', '', 4);
INSERT INTO `dh2y_menu` VALUES (58, 56, '充值记录', '/admin/member/pay_log', '', 1);
INSERT INTO `dh2y_menu` VALUES (59, 56, '财务明细', '/admin/member/account', '', 1);
INSERT INTO `dh2y_menu` VALUES (60, 0, '业务管理', '#', 'Hui-iconfont-vip-card2', 1);
INSERT INTO `dh2y_menu` VALUES (61, 60, '充值管理', '/admin/business/recharge', '', 1);
INSERT INTO `dh2y_menu` VALUES (62, 60, '财务管理', '/admin/business/account', '', 1);
INSERT INTO `dh2y_menu` VALUES (63, 60, '用户管理', '/admin/business/member', '', 1);
INSERT INTO `dh2y_menu` VALUES (64, 60, '短信记录', '/admin/business/log', '', 1);

-- ----------------------------
-- Table structure for sms_phone
-- ----------------------------
DROP TABLE IF EXISTS `dh2y_phone`;
CREATE TABLE `dh2y_phone`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT 0 COMMENT '所属用户id',
  `phone` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '手机号',
  `create_time` int(11) NULL DEFAULT NULL COMMENT '添加时间',
  `tag` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'tag标签',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '短信发送对象表' ROW_FORMAT = Dynamic;



-- ----------------------------
-- Table structure for sms_recharge
-- ----------------------------
DROP TABLE IF EXISTS `dh2y_recharge`;
CREATE TABLE `dh2y_recharge`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `out_trade_no` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `uid` int(11) NOT NULL,
  `amount` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00,
  `give_amount` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `goods` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '充值的套餐信息',
  `state` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0待支付，1支付成功，2支付失败',
  `create_time` int(11) NULL DEFAULT NULL COMMENT '添加时间',
  `update_time` int(11) NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '充值记录' ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table structure for sms_send_log
-- ----------------------------
DROP TABLE IF EXISTS `dh2y_send_log`;
CREATE TABLE `dh2y_send_log`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(11) NULL DEFAULT NULL,
  `phone` char(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `state` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1发送成功，2失败',
  `msg` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '错误信息',
  `is_temp` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否是临时加的手机号',
  `create_time` int(11) NULL DEFAULT NULL COMMENT '添加时间',
  `update_time` int(11) NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 73 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '发送记录表' ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table structure for sms_service
-- ----------------------------
DROP TABLE IF EXISTS `dh2y_service`;
CREATE TABLE `dh2y_service`  (
  `id` smallint(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT 0 COMMENT '所属用户id',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `class_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '类名',
  `account` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '短信账户',
  `password` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '短信秘钥',
  `signature` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '短信签名',
  `app_id` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'app_id',
  `type` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '模板类型',
  `is_use` tinyint(4) NOT NULL DEFAULT 0 COMMENT '选中正在使用',
  `is_test` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否是测试',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '短信服务商表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sms_service
-- ----------------------------
INSERT INTO `dh2y_service` VALUES (2, 1, '云通讯', 'Yuntongxun', '8a216da86b652116016b78c233941083', 'f7729bdc7f24403c926ce7d2ea81026e', '抖友钱包', '8a216da86b652116016b78c234041089', 'template', 1, 0);
INSERT INTO `dh2y_service` VALUES (3, 0, '黑五类通道[+86]', 'Yuntongxun', 'asdasdasd', 'asdadadqasd', '', '', 'template', 0, 1);
INSERT INTO `dh2y_service` VALUES (4, 0, '大陆通道[0086]', 'Yuntongxun', '111111qq', '111111qq', '', '', 'template', 0, 1);
INSERT INTO `dh2y_service` VALUES (5, 0, '国际通道[00855]', 'Aliyun', '111111qq', '111111qq', '', '', 'template', 0, 1);

-- ----------------------------
-- Table structure for sms_template
-- ----------------------------
DROP TABLE IF EXISTS `dh2y_template`;
CREATE TABLE `dh2y_template`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT 0 COMMENT '所属用户id',
  `template_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '模板名称',
  `code` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '模板id',
  `message` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '模板内容',
  `sid` int(11) NOT NULL COMMENT '所属服务商',
  `params` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '参数内容',
  `signature` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '短信签名',
  `is_use` tinyint(4) NOT NULL DEFAULT 0 COMMENT '选中正在使用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '短信模板' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sms_template
-- ----------------------------
INSERT INTO `dh2y_template` VALUES (1, 1, '融云模板1', '442268', '您的账户%name%，因为%reason%，金额变化%money%，账户余额%balance%', 2, '{\"name\":\"\",\"reason\":\"\\u516c\\u53f8\\u53d1\\u798f\\u5229\\u4e86\\uff0c\\u4f60\\u539f\\u672c\\u76845000\",\"money\":\"\",\"balance\":\"20000\\uff0c\\u8fdb\\u53bb\\u67e5\\u8be2\\u4e00\\u4e0b\\u5427http:\\/\\/suo.im\\/4Ddkin\"}', '抖友钱包', 1);
INSERT INTO `dh2y_template` VALUES (5, 0, '一元购', '23442', '您好，平台限时推出一元购物体检。快来参加体验吧%url%', 3, '{\"url\":\"\"}', '', 0);
INSERT INTO `dh2y_template` VALUES (6, 10, '测试', '234234', '0元购活动正式开始了，大家赶紧来撸羊毛吧。%url%', 3, '{\"url\":\"http:\\/\\/url.cn\\/dddasd\"}', '', 0);
INSERT INTO `dh2y_template` VALUES (7, 11, '模板1', '442269', 'EGB99 →  %url%', 3, '{\"url\":\"www.egb99.com\"}', '', 0);
INSERT INTO `dh2y_template` VALUES (8, 1, '测试', '34453', '告诉对方答复不分高低', 3, '[]', '', 0);

-- ----------------------------
-- View structure for sms_account_view
-- ----------------------------
DROP VIEW IF EXISTS `dh2y_account_view`;
CREATE  VIEW `dh2y_account_view` AS select `ac`.`id` AS `id`,`ac`.`uid` AS `uid`,`ac`.`symbol` AS `symbol`,`ac`.`money` AS `money`,`ac`.`balance` AS `balance`,`ac`.`remark` AS `remark`,`ac`.`create_time` AS `create_time`,`ac`.`update_time` AS `update_time`,`a`.`username` AS `username`,`a`.`admin_name` AS `admin_name`,`a`.`email` AS `email` from (`dh2y_account` `ac` left join `dh2y_admin` `a` on((`ac`.`uid` = `a`.`id`)));

-- ----------------------------
-- View structure for sms_admin_group_view
-- ----------------------------
DROP VIEW IF EXISTS `dh2y_admin_group_view`;
CREATE  VIEW `dh2y_admin_group_view` AS select `a`.`username` AS `username`,`g`.`uid` AS `uid`,`g`.`group_id` AS `group_id`,`a`.`admin_name` AS `admin_name` from (`dh2y_admin` `a` left join `dh2y_auth_group_access` `g` on((`a`.`id` = `g`.`uid`)));

-- ----------------------------
-- View structure for sms_admin_view
-- ----------------------------
DROP VIEW IF EXISTS `dh2y_admin_view`;
CREATE  VIEW `dh2y_admin_view` AS select `a`.`id` AS `id`,`a`.`username` AS `username`,`a`.`admin_name` AS `admin_name`,`a`.`password` AS `password`,`a`.`token` AS `token`,`a`.`email` AS `email`,`a`.`status` AS `status`,`a`.`last_login` AS `last_login`,`a`.`balance` AS `balance`,`a`.`vip` AS `vip`,`a`.`num` AS `num`,`a`.`vip_time` AS `vip_time`,`a`.`login_ip` AS `login_ip`,`a`.`create_time` AS `create_time`,`a`.`update_time` AS `update_time` from (`dh2y_admin` `a` left join `dh2y_auth_group_access` `g` on((`a`.`id` = `g`.`uid`))) where (`g`.`group_id` = 2);

-- ----------------------------
-- View structure for sms_recharge_view
-- ----------------------------
DROP VIEW IF EXISTS `dh2y_recharge_view`;
CREATE  VIEW `dh2y_recharge_view` AS select `a`.`username` AS `username`,`a`.`admin_name` AS `admin_name`,`a`.`email` AS `email`,`r`.`id` AS `id`,`r`.`out_trade_no` AS `out_trade_no`,`r`.`uid` AS `uid`,`r`.`amount` AS `amount`,`r`.`give_amount` AS `give_amount`,`r`.`type` AS `type`,`r`.`goods` AS `goods`,`r`.`state` AS `state`,`r`.`create_time` AS `create_time`,`r`.`update_time` AS `update_time` from (`dh2y_admin` `a` left join `dh2y_recharge` `r` on((`a`.`id` = `r`.`uid`)));

-- ----------------------------
-- View structure for sms_rule_menu_view
-- ----------------------------
DROP VIEW IF EXISTS `dh2y_rule_menu_view`;
CREATE  VIEW `dh2y_rule_menu_view` AS select `r`.`id` AS `id`,`r`.`name` AS `name`,`r`.`title` AS `title`,`r`.`status` AS `status`,`r`.`condition` AS `condition`,`m`.`title` AS `menu` from (`dh2y_auth_rule` `r` left join `dh2y_menu` `m` on((`r`.`mid` = `m`.`id`)));

-- ----------------------------
-- View structure for sms_send_log_view
-- ----------------------------
DROP VIEW IF EXISTS `dh2y_send_log_view`;
CREATE  VIEW `dh2y_send_log_view` AS select `l`.`id` AS `id`,`l`.`uid` AS `uid`,`l`.`phone` AS `phone`,`l`.`content` AS `content`,`l`.`state` AS `state`,`l`.`msg` AS `msg`,`l`.`is_temp` AS `is_temp`,`l`.`create_time` AS `create_time`,`l`.`update_time` AS `update_time`,`a`.`username` AS `username`,`a`.`admin_name` AS `admin_name`,`a`.`email` AS `email` from (`dh2y_send_log` `l` left join `dh2y_admin` `a` on((`l`.`uid` = `a`.`id`)));

SET FOREIGN_KEY_CHECKS = 1;
