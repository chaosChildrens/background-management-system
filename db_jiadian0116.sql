# Host: 127.0.0.1  (Version 5.6.17)
# Date: 2019-01-16 17:06:32
# Generator: MySQL-Front 6.1  (Build 1.26)


#
# Structure for table "admin"
#

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) DEFAULT NULL,
  `username` varchar(80) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `pwd` varchar(32) DEFAULT NULL,
  `role` tinyint(1) DEFAULT NULL COMMENT '0管理员1经理2销售员3售后',
  `errorNum` int(11) DEFAULT '0',
  `clientIp` varchar(255) DEFAULT NULL,
  `time` varchar(20) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `did` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

#
# Data for table "admin"
#

INSERT INTO `admin` VALUES (1,'admin',NULL,NULL,'21232f297a57a5a743894a0e4a801fc3',0,0,'0.0.0.0','1547563273',NULL,NULL),(2,'jingli','张三',NULL,'21232f297a57a5a743894a0e4a801fc3',1,0,NULL,NULL,'15800001111',1),(3,'xiaoshou','牛二',NULL,'21232f297a57a5a743894a0e4a801fc3',2,0,NULL,NULL,'15622226666',1),(4,'shouhou','赵六',NULL,'21232f297a57a5a743894a0e4a801fc3',3,0,NULL,NULL,'13566669999',1);

#
# Structure for table "category"
#

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

#
# Data for table "category"
#

INSERT INTO `category` VALUES (2,'电视1',0),(3,'空调',0),(4,'洗衣机',0),(5,'冰箱',0),(6,'曲面电视',2),(7,'4k电视',2),(8,'超薄电视',2),(9,'壁挂空调',3),(10,'立柱空调',3),(11,'滚筒洗衣机',4),(12,'波轮洗衣机',4),(13,'变频',5),(14,'定频',5),(15,'多门',5),(16,'三门',5);

#
# Structure for table "customer"
#

DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `level` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

#
# Data for table "customer"
#

INSERT INTO `customer` VALUES (1,'苏宁电器','15688887777','南京市128号1','VIP客户'),(2,'京东商城','15366668888','北京朝阳区298号8室','VIP客户'),(3,'张二小1','18688881111','相家巷仿古街193','普通客户'),(4,'李小三','15878878787','1-101','普通客户');

#
# Structure for table "dept"
#

DROP TABLE IF EXISTS `dept`;
CREATE TABLE `dept` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

#
# Data for table "dept"
#

INSERT INTO `dept` VALUES (1,'电视事业部',2,'管理电视产品'),(2,'空调事业部1',3,'负责公司空调业务'),(5,'洗衣机事业部',4,'负责公司洗衣机业务');

#
# Structure for table "orders"
#

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gname` varchar(80) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `money` decimal(10,2) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL COMMENT '备注',
  `cid` int(11) DEFAULT NULL,
  `cname` varchar(80) DEFAULT NULL,
  `aid` int(11) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='订单';

#
# Data for table "orders"
#

INSERT INTO `orders` VALUES (3,'创维65',100.00,2,200.00,'2019-01-15 16:42:46',NULL,1,'苏宁电器',3,1),(4,'创维65',100.00,1,100.00,'2019-01-15 17:23:30',NULL,2,'京东商城',3,1),(5,'电视',1998.00,15,29970.00,'2019-01-15 18:09:52',NULL,1,'苏宁电器',3,3),(6,'长虹55',150.00,2,300.00,'2019-01-15 18:12:16',NULL,2,'京东商城',3,2),(7,'创维65',100.00,11,1100.00,'2019-01-15 18:12:42',NULL,1,'苏宁电器',3,1),(8,'创维65',100.00,2,200.00,'2019-01-15 19:42:38',NULL,1,'苏宁电器',3,1),(9,'长虹55',150.00,2,300.00,'2019-01-15 20:06:51',NULL,3,'张二小',3,2),(10,'创维65',100.00,3,300.00,'2019-01-16 14:15:05',NULL,1,'苏宁电器',3,1);

#
# Structure for table "product"
#

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` varchar(255) DEFAULT NULL,
  `name` varchar(80) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `barcode` varchar(20) DEFAULT NULL COMMENT 'SDIS',
  `price` decimal(10,2) DEFAULT NULL,
  `sale` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

#
# Data for table "product"
#

INSERT INTO `product` VALUES (1,'6','创维65','5c304e31498a0.jpg','132145474',100.00,200.00),(2,'7','长虹55','5c304e1304f84.jpg','22222',150.00,250.00),(3,'6','电视','5c304dee40738.jpg','132145674',1998.00,2559.00),(4,'11','洗衣机10L','20190116\\8d1beb93ada39d8c77b7b597b6ec68e9.jpg','13546789784',988.00,1299.00);

#
# Structure for table "repair"
#

DROP TABLE IF EXISTS `repair`;
CREATE TABLE `repair` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ordersId` varchar(80) DEFAULT NULL,
  `goods` varchar(80) DEFAULT NULL,
  `info` varchar(255) DEFAULT NULL,
  `userName` varchar(80) DEFAULT NULL,
  `isVIP` tinyint(3) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `time` varchar(20) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

#
# Data for table "repair"
#

INSERT INTO `repair` VALUES (1,'20190001','65寸电视机','无声音','刘能',0,2,'1546883508',1),(2,'20180002','长虹55','不制冷','张四',1,1,'1546883538',2),(4,'20180003','电视','asdfasdfasdf','user',0,0,'1546921264',3),(5,'20180005','洗衣机10L',' 阿斯蒂芬','张四',0,0,'1547620723',4),(6,'20180006','65寸电视机','2452442','张四',0,0,'1547621003',1);
