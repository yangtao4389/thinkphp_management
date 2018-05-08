/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : basecms

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 21/12/2017 15:26:02
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cms_adminmsg
-- ----------------------------
DROP TABLE IF EXISTS `cms_adminmsg`;
CREATE TABLE `cms_adminmsg`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fromuser` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `touser` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `isread` tinyint(2) NOT NULL DEFAULT 0,
  `dttime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fromuser`(`fromuser`) USING BTREE,
  INDEX `touser`(`touser`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cms_adminmsg
-- ----------------------------
INSERT INTO `cms_adminmsg` VALUES (1, 'admin', 'bobboy007', 'sdfd', 'fdsfsdfdfsdf', 1, NULL);
INSERT INTO `cms_adminmsg` VALUES (2, 'bobboy007', 'admin', 'Re:sdfdcfddddd', '>fdsfsdfdfsdf', 1, '2010-11-08 15:45:57');
INSERT INTO `cms_adminmsg` VALUES (3, 'admin', 'bobboy007', ' 测试邮件群发', '测试内容', 1, '2010-11-09 09:17:27');
INSERT INTO `cms_adminmsg` VALUES (4, 'bobboy007', 'admin', 'Re: 测试邮件群发', '>测试内容', 1, '2010-11-09 09:44:14');
INSERT INTO `cms_adminmsg` VALUES (5, 'bobboy007', 'bobboy007', 'Re: 测试邮件群发', '>测试内容', 1, '2010-11-09 09:44:14');

-- ----------------------------
-- Table structure for cms_article_content
-- ----------------------------
DROP TABLE IF EXISTS `cms_article_content`;
CREATE TABLE `cms_article_content`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL DEFAULT 0,
  `title` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `shorttitle` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `litpic` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `author` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `adddt` datetime DEFAULT NULL,
  `pubdt` datetime DEFAULT NULL,
  `adminname` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `torder` int(11) NOT NULL DEFAULT 0,
  `description` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `hits` int(11) NOT NULL DEFAULT 0,
  `comments` int(11) NOT NULL DEFAULT 0,
  `diyflag` int(2) NOT NULL DEFAULT 0,
  `tmpfile` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `tid`(`tid`) USING BTREE,
  INDEX `senddt`(`pubdt`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cms_article_content
-- ----------------------------
INSERT INTO `cms_article_content` VALUES (1, 1, 'dfsafaaaaaaaa', 'dfdsaf', '', 'df', '2010-12-07 12:03:04', '2010-12-07 12:03:04', 'admin', 0, 'dsafd', 'fdsafdsfa', 0, 0, 0, '');
INSERT INTO `cms_article_content` VALUES (2, 1, '有图片测试', 'dsafd', '', 'fdsafdafsdf', '2010-12-07 14:57:20', '2010-12-07 14:57:20', 'admin', 0, '', '<img alt=\"\" src=\"/distribdata/uploadpic/201012/1501289151.jpg\" border=\"0\" /><img alt=\"\" src=\"distribdata/uploadpic/201012/1456586551.jpg\" border=\"0\" />#page#<br />\r\nfdsfadfdsaf第二页<br />\r\nfdsafsdfdfdsafdsaf<br />\r\nfdsafsdafdfd<br />\r\n', 0, 0, 0, '');

-- ----------------------------
-- Table structure for cms_article_diyflag
-- ----------------------------
DROP TABLE IF EXISTS `cms_article_diyflag`;
CREATE TABLE `cms_article_diyflag`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flagname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cms_article_diyflag
-- ----------------------------
INSERT INTO `cms_article_diyflag` VALUES (2, '标识一');

-- ----------------------------
-- Table structure for cms_article_placecontent
-- ----------------------------
DROP TABLE IF EXISTS `cms_article_placecontent`;
CREATE TABLE `cms_article_placecontent`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ptid` int(11) NOT NULL DEFAULT 0,
  `title` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `arturl` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `pic` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `field1` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `field2` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `field3` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `field4` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `diydt` int(11) NOT NULL DEFAULT 0,
  `adddt` int(11) NOT NULL DEFAULT 0,
  `prow` tinyint(2) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `ptid`(`ptid`) USING BTREE,
  INDEX `ptid_2`(`ptid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cms_article_placecontent
-- ----------------------------
INSERT INTO `cms_article_placecontent` VALUES (1, 1, '你好add', 'dasfdsa', NULL, NULL, 'fdsafdfsaf', NULL, NULL, NULL, 1291624597, 1291624715, 1);

-- ----------------------------
-- Table structure for cms_article_placetype
-- ----------------------------
DROP TABLE IF EXISTS `cms_article_placetype`;
CREATE TABLE `cms_article_placetype`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typename` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `defaultvalue` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `displayfield` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `porder` tinyint(2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cms_article_placetype
-- ----------------------------
INSERT INTO `cms_article_placetype` VALUES (1, '测试位置一', 'title|你好,arturl,diydt,field1', 'title|标题了,arturl|链接地址,field1|随便内容', 0);
INSERT INTO `cms_article_placetype` VALUES (2, 'dfsafdf', 'fdsafdafd', 'fdsfadf', 3);

-- ----------------------------
-- Table structure for cms_article_type
-- ----------------------------
DROP TABLE IF EXISTS `cms_article_type`;
CREATE TABLE `cms_article_type`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tname` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `tidlist` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `pid` int(11) NOT NULL DEFAULT 0,
  `degree` int(11) NOT NULL DEFAULT 0,
  `torder` int(11) NOT NULL DEFAULT 0,
  `typedir` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `contentdir` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `domainname` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `perpage` int(11) NOT NULL DEFAULT 0,
  `isindexpage` tinyint(2) NOT NULL DEFAULT 0,
  `tmpindex` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `tmplist` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `tmpcontent` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `ishide` tinyint(2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `torder`(`torder`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cms_article_type
-- ----------------------------
INSERT INTO `cms_article_type` VALUES (1, '小游戏|', '1,', 0, 1, 0, '', '', '', 0, 0, '', '', '', 0);
INSERT INTO `cms_article_type` VALUES (2, '文章列表|', '2,', 0, 1, 0, '', '', '', 0, 0, '', '', '', 0);
INSERT INTO `cms_article_type` VALUES (3, '小游戏|换装小游戏|', '1,3,', 1, 2, 0, '', '', '', 0, 0, '', '', '', 0);
INSERT INTO `cms_article_type` VALUES (4, '文章列表|游戏评测|', '2,4,', 2, 2, 0, '', '', '', 0, 0, '', '', '', 0);
INSERT INTO `cms_article_type` VALUES (5, '文章列表|新游快报1|', '2,5,', 2, 2, 0, '', '', '', 0, 0, '', '', '', 0);
INSERT INTO `cms_article_type` VALUES (6, '小游戏|休闲小游戏|', '1,6,', 1, 2, 0, '', '', '', 0, 0, '', '', '', 0);
INSERT INTO `cms_article_type` VALUES (7, '文章列表|新游快报1|热血新游快报|', '2,5,7,', 5, 3, 0, '', '', '', 0, 0, '', '', '', 0);
INSERT INTO `cms_article_type` VALUES (8, '小游戏|休闲小游戏|益智休闲小游戏1|', '1,6,8,', 6, 3, 0, '', '', '', 0, 0, '', '', '', 0);

-- ----------------------------
-- Table structure for cms_city
-- ----------------------------
DROP TABLE IF EXISTS `cms_city`;
CREATE TABLE `cms_city`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pcode` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `pname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `pflag` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1省2市',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pflag`(`pflag`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 377 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cms_city
-- ----------------------------
INSERT INTO `cms_city` VALUES (1, '340800', '安庆市', 2);
INSERT INTO `cms_city` VALUES (2, '340300', '蚌埠市', 2);
INSERT INTO `cms_city` VALUES (3, '341400', '巢湖市', 2);
INSERT INTO `cms_city` VALUES (4, '341700', '池州市', 2);
INSERT INTO `cms_city` VALUES (5, '341100', '滁州市', 2);
INSERT INTO `cms_city` VALUES (6, '341200', '阜阳市', 2);
INSERT INTO `cms_city` VALUES (7, '340100', '合肥市', 2);
INSERT INTO `cms_city` VALUES (8, '340600', '淮北市', 2);
INSERT INTO `cms_city` VALUES (9, '340400', '淮南市', 2);
INSERT INTO `cms_city` VALUES (10, '341000', '黄山市', 2);
INSERT INTO `cms_city` VALUES (11, '341500', '六安市', 2);
INSERT INTO `cms_city` VALUES (12, '340500', '马鞍山市', 2);
INSERT INTO `cms_city` VALUES (13, '341300', '宿州市', 2);
INSERT INTO `cms_city` VALUES (14, '340700', '铜陵市', 2);
INSERT INTO `cms_city` VALUES (15, '340200', '芜湖市', 2);
INSERT INTO `cms_city` VALUES (16, '341800', '宣城市', 2);
INSERT INTO `cms_city` VALUES (17, '341600', '亳州市', 2);
INSERT INTO `cms_city` VALUES (18, '110100', '市辖区', 2);
INSERT INTO `cms_city` VALUES (19, '110200', '县', 2);
INSERT INTO `cms_city` VALUES (20, '350100', '福州市', 2);
INSERT INTO `cms_city` VALUES (21, '350800', '龙岩市', 2);
INSERT INTO `cms_city` VALUES (22, '350700', '南平市', 2);
INSERT INTO `cms_city` VALUES (23, '350900', '宁德市', 2);
INSERT INTO `cms_city` VALUES (24, '350300', '莆田市', 2);
INSERT INTO `cms_city` VALUES (25, '350500', '泉州市', 2);
INSERT INTO `cms_city` VALUES (26, '350400', '三明市', 2);
INSERT INTO `cms_city` VALUES (27, '350200', '厦门市', 2);
INSERT INTO `cms_city` VALUES (28, '350600', '漳州市', 2);
INSERT INTO `cms_city` VALUES (29, '620400', '白银市', 2);
INSERT INTO `cms_city` VALUES (30, '621100', '定西市', 2);
INSERT INTO `cms_city` VALUES (31, '623000', '甘南藏族自治州', 2);
INSERT INTO `cms_city` VALUES (32, '620200', '嘉峪关市', 2);
INSERT INTO `cms_city` VALUES (33, '620300', '金昌市', 2);
INSERT INTO `cms_city` VALUES (34, '620900', '酒泉市', 2);
INSERT INTO `cms_city` VALUES (35, '620100', '兰州市', 2);
INSERT INTO `cms_city` VALUES (36, '622900', '临夏回族自治州', 2);
INSERT INTO `cms_city` VALUES (37, '621200', '陇南市', 2);
INSERT INTO `cms_city` VALUES (38, '620800', '平凉市', 2);
INSERT INTO `cms_city` VALUES (39, '621000', '庆阳市', 2);
INSERT INTO `cms_city` VALUES (40, '620500', '天水市', 2);
INSERT INTO `cms_city` VALUES (41, '620600', '武威市', 2);
INSERT INTO `cms_city` VALUES (42, '620700', '张掖市', 2);
INSERT INTO `cms_city` VALUES (43, '445100', '潮州市', 2);
INSERT INTO `cms_city` VALUES (44, '441900', '东莞市', 2);
INSERT INTO `cms_city` VALUES (45, '440600', '佛山市', 2);
INSERT INTO `cms_city` VALUES (46, '440100', '广州市', 2);
INSERT INTO `cms_city` VALUES (47, '441600', '河源市', 2);
INSERT INTO `cms_city` VALUES (48, '441300', '惠州市', 2);
INSERT INTO `cms_city` VALUES (49, '440700', '江门市', 2);
INSERT INTO `cms_city` VALUES (50, '445200', '揭阳市', 2);
INSERT INTO `cms_city` VALUES (51, '440900', '茂名市', 2);
INSERT INTO `cms_city` VALUES (52, '441400', '梅州市', 2);
INSERT INTO `cms_city` VALUES (53, '441800', '清远市', 2);
INSERT INTO `cms_city` VALUES (54, '440500', '汕头市', 2);
INSERT INTO `cms_city` VALUES (55, '441500', '汕尾市', 2);
INSERT INTO `cms_city` VALUES (56, '440200', '韶关市', 2);
INSERT INTO `cms_city` VALUES (57, '440300', '深圳市', 2);
INSERT INTO `cms_city` VALUES (58, '441700', '阳江市', 2);
INSERT INTO `cms_city` VALUES (59, '445300', '云浮市', 2);
INSERT INTO `cms_city` VALUES (60, '440800', '湛江市', 2);
INSERT INTO `cms_city` VALUES (61, '441200', '肇庆市', 2);
INSERT INTO `cms_city` VALUES (62, '442000', '中山市', 2);
INSERT INTO `cms_city` VALUES (63, '440400', '珠海市', 2);
INSERT INTO `cms_city` VALUES (64, '451000', '百色市', 2);
INSERT INTO `cms_city` VALUES (65, '450500', '北海市', 2);
INSERT INTO `cms_city` VALUES (66, '451400', '崇左市', 2);
INSERT INTO `cms_city` VALUES (67, '450600', '防城港市', 2);
INSERT INTO `cms_city` VALUES (68, '450300', '桂林市', 2);
INSERT INTO `cms_city` VALUES (69, '450800', '贵港市', 2);
INSERT INTO `cms_city` VALUES (70, '451200', '河池市', 2);
INSERT INTO `cms_city` VALUES (71, '451100', '贺州市', 2);
INSERT INTO `cms_city` VALUES (72, '451300', '来宾市', 2);
INSERT INTO `cms_city` VALUES (73, '450200', '柳州市', 2);
INSERT INTO `cms_city` VALUES (74, '450100', '南宁市', 2);
INSERT INTO `cms_city` VALUES (75, '450700', '钦州市', 2);
INSERT INTO `cms_city` VALUES (76, '450400', '梧州市', 2);
INSERT INTO `cms_city` VALUES (77, '450900', '玉林市', 2);
INSERT INTO `cms_city` VALUES (78, '520400', '安顺市', 2);
INSERT INTO `cms_city` VALUES (79, '522400', '毕节地区', 2);
INSERT INTO `cms_city` VALUES (80, '520100', '贵阳市', 2);
INSERT INTO `cms_city` VALUES (81, '520200', '六盘水市', 2);
INSERT INTO `cms_city` VALUES (82, '522600', '黔东南苗族侗族自治州', 2);
INSERT INTO `cms_city` VALUES (83, '522700', '黔南布依族苗族自治州', 2);
INSERT INTO `cms_city` VALUES (84, '522300', '黔西南布依族苗族自治州', 2);
INSERT INTO `cms_city` VALUES (85, '522200', '铜仁地区', 2);
INSERT INTO `cms_city` VALUES (86, '520300', '遵义市', 2);
INSERT INTO `cms_city` VALUES (87, '460100', '海口市', 2);
INSERT INTO `cms_city` VALUES (88, '460200', '三亚市', 2);
INSERT INTO `cms_city` VALUES (89, '469000', '省直辖县级行政单位', 2);
INSERT INTO `cms_city` VALUES (90, '130600', '保定市', 2);
INSERT INTO `cms_city` VALUES (91, '130900', '沧州市', 2);
INSERT INTO `cms_city` VALUES (92, '130800', '承德市', 2);
INSERT INTO `cms_city` VALUES (93, '130400', '邯郸市', 2);
INSERT INTO `cms_city` VALUES (94, '131100', '衡水市', 2);
INSERT INTO `cms_city` VALUES (95, '131000', '廊坊市', 2);
INSERT INTO `cms_city` VALUES (96, '130300', '秦皇岛市', 2);
INSERT INTO `cms_city` VALUES (97, '130100', '石家庄市', 2);
INSERT INTO `cms_city` VALUES (98, '130200', '唐山市', 2);
INSERT INTO `cms_city` VALUES (99, '130500', '邢台市', 2);
INSERT INTO `cms_city` VALUES (100, '130700', '张家口市', 2);
INSERT INTO `cms_city` VALUES (101, '410500', '安阳市', 2);
INSERT INTO `cms_city` VALUES (102, '410600', '鹤壁市', 2);
INSERT INTO `cms_city` VALUES (103, '410800', '焦作市', 2);
INSERT INTO `cms_city` VALUES (104, '410200', '开封市', 2);
INSERT INTO `cms_city` VALUES (105, '410300', '洛阳市', 2);
INSERT INTO `cms_city` VALUES (106, '411300', '南阳市', 2);
INSERT INTO `cms_city` VALUES (107, '410400', '平顶山市', 2);
INSERT INTO `cms_city` VALUES (108, '411200', '三门峡市', 2);
INSERT INTO `cms_city` VALUES (109, '411400', '商丘市', 2);
INSERT INTO `cms_city` VALUES (110, '410700', '新乡市', 2);
INSERT INTO `cms_city` VALUES (111, '411500', '信阳市', 2);
INSERT INTO `cms_city` VALUES (112, '411000', '许昌市', 2);
INSERT INTO `cms_city` VALUES (113, '410100', '郑州市', 2);
INSERT INTO `cms_city` VALUES (114, '411600', '周口市', 2);
INSERT INTO `cms_city` VALUES (115, '411700', '驻马店市', 2);
INSERT INTO `cms_city` VALUES (116, '411100', '漯河市', 2);
INSERT INTO `cms_city` VALUES (117, '410900', '濮阳市', 2);
INSERT INTO `cms_city` VALUES (118, '230600', '大庆市', 2);
INSERT INTO `cms_city` VALUES (119, '232700', '大兴安岭地区', 2);
INSERT INTO `cms_city` VALUES (120, '230100', '哈尔滨市', 2);
INSERT INTO `cms_city` VALUES (121, '230400', '鹤岗市', 2);
INSERT INTO `cms_city` VALUES (122, '231100', '黑河市', 2);
INSERT INTO `cms_city` VALUES (123, '230300', '鸡西市', 2);
INSERT INTO `cms_city` VALUES (124, '230800', '佳木斯市', 2);
INSERT INTO `cms_city` VALUES (125, '231000', '牡丹江市', 2);
INSERT INTO `cms_city` VALUES (126, '230900', '七台河市', 2);
INSERT INTO `cms_city` VALUES (127, '230200', '齐齐哈尔市', 2);
INSERT INTO `cms_city` VALUES (128, '230500', '双鸭山市', 2);
INSERT INTO `cms_city` VALUES (129, '231200', '绥化市', 2);
INSERT INTO `cms_city` VALUES (130, '230700', '伊春市', 2);
INSERT INTO `cms_city` VALUES (131, '420700', '鄂州市', 2);
INSERT INTO `cms_city` VALUES (132, '422800', '恩施土家族苗族自治州', 2);
INSERT INTO `cms_city` VALUES (133, '421100', '黄冈市', 2);
INSERT INTO `cms_city` VALUES (134, '420200', '黄石市', 2);
INSERT INTO `cms_city` VALUES (135, '420800', '荆门市', 2);
INSERT INTO `cms_city` VALUES (136, '421000', '荆州市', 2);
INSERT INTO `cms_city` VALUES (137, '429000', '省直辖行政单位', 2);
INSERT INTO `cms_city` VALUES (138, '420300', '十堰市', 2);
INSERT INTO `cms_city` VALUES (139, '421300', '随州市', 2);
INSERT INTO `cms_city` VALUES (140, '420100', '武汉市', 2);
INSERT INTO `cms_city` VALUES (141, '421200', '咸宁市', 2);
INSERT INTO `cms_city` VALUES (142, '420600', '襄樊市', 2);
INSERT INTO `cms_city` VALUES (143, '420900', '孝感市', 2);
INSERT INTO `cms_city` VALUES (144, '420500', '宜昌市', 2);
INSERT INTO `cms_city` VALUES (145, '430700', '常德市', 2);
INSERT INTO `cms_city` VALUES (146, '430100', '长沙市', 2);
INSERT INTO `cms_city` VALUES (147, '431000', '郴州市', 2);
INSERT INTO `cms_city` VALUES (148, '430400', '衡阳市', 2);
INSERT INTO `cms_city` VALUES (149, '431200', '怀化市', 2);
INSERT INTO `cms_city` VALUES (150, '431300', '娄底市', 2);
INSERT INTO `cms_city` VALUES (151, '430500', '邵阳市', 2);
INSERT INTO `cms_city` VALUES (152, '430300', '湘潭市', 2);
INSERT INTO `cms_city` VALUES (153, '433100', '湘西土家族苗族自治州', 2);
INSERT INTO `cms_city` VALUES (154, '430900', '益阳市', 2);
INSERT INTO `cms_city` VALUES (155, '431100', '永州市', 2);
INSERT INTO `cms_city` VALUES (156, '430600', '岳阳市', 2);
INSERT INTO `cms_city` VALUES (157, '430800', '张家界市', 2);
INSERT INTO `cms_city` VALUES (158, '430200', '株洲市', 2);
INSERT INTO `cms_city` VALUES (159, '220800', '白城市', 2);
INSERT INTO `cms_city` VALUES (160, '220600', '白山市', 2);
INSERT INTO `cms_city` VALUES (161, '220100', '长春市', 2);
INSERT INTO `cms_city` VALUES (162, '220200', '吉林市', 2);
INSERT INTO `cms_city` VALUES (163, '220400', '辽源市', 2);
INSERT INTO `cms_city` VALUES (164, '220300', '四平市', 2);
INSERT INTO `cms_city` VALUES (165, '220700', '松原市', 2);
INSERT INTO `cms_city` VALUES (166, '220500', '通化市', 2);
INSERT INTO `cms_city` VALUES (167, '222400', '延边朝鲜族自治州', 2);
INSERT INTO `cms_city` VALUES (168, '320400', '常州市', 2);
INSERT INTO `cms_city` VALUES (169, '320800', '淮安市', 2);
INSERT INTO `cms_city` VALUES (170, '320700', '连云港市', 2);
INSERT INTO `cms_city` VALUES (171, '320100', '南京市', 2);
INSERT INTO `cms_city` VALUES (172, '320600', '南通市', 2);
INSERT INTO `cms_city` VALUES (173, '320500', '苏州市', 2);
INSERT INTO `cms_city` VALUES (174, '321300', '宿迁市', 2);
INSERT INTO `cms_city` VALUES (175, '321200', '泰州市', 2);
INSERT INTO `cms_city` VALUES (176, '320200', '无锡市', 2);
INSERT INTO `cms_city` VALUES (177, '320300', '徐州市', 2);
INSERT INTO `cms_city` VALUES (178, '320900', '盐城市', 2);
INSERT INTO `cms_city` VALUES (179, '321000', '扬州市', 2);
INSERT INTO `cms_city` VALUES (180, '321100', '镇江市', 2);
INSERT INTO `cms_city` VALUES (181, '361000', '抚州市', 2);
INSERT INTO `cms_city` VALUES (182, '360700', '赣州市', 2);
INSERT INTO `cms_city` VALUES (183, '360800', '吉安市', 2);
INSERT INTO `cms_city` VALUES (184, '360200', '景德镇市', 2);
INSERT INTO `cms_city` VALUES (185, '360400', '九江市', 2);
INSERT INTO `cms_city` VALUES (186, '360100', '南昌市', 2);
INSERT INTO `cms_city` VALUES (187, '360300', '萍乡市', 2);
INSERT INTO `cms_city` VALUES (188, '361100', '上饶市', 2);
INSERT INTO `cms_city` VALUES (189, '360500', '新余市', 2);
INSERT INTO `cms_city` VALUES (190, '360900', '宜春市', 2);
INSERT INTO `cms_city` VALUES (191, '360600', '鹰潭市', 2);
INSERT INTO `cms_city` VALUES (192, '210300', '鞍山市', 2);
INSERT INTO `cms_city` VALUES (193, '210500', '本溪市', 2);
INSERT INTO `cms_city` VALUES (194, '211300', '朝阳市', 2);
INSERT INTO `cms_city` VALUES (195, '210200', '大连市', 2);
INSERT INTO `cms_city` VALUES (196, '210600', '丹东市', 2);
INSERT INTO `cms_city` VALUES (197, '210400', '抚顺市', 2);
INSERT INTO `cms_city` VALUES (198, '210900', '阜新市', 2);
INSERT INTO `cms_city` VALUES (199, '211400', '葫芦岛市', 2);
INSERT INTO `cms_city` VALUES (200, '210700', '锦州市', 2);
INSERT INTO `cms_city` VALUES (201, '211000', '辽阳市', 2);
INSERT INTO `cms_city` VALUES (202, '211100', '盘锦市', 2);
INSERT INTO `cms_city` VALUES (203, '210100', '沈阳市', 2);
INSERT INTO `cms_city` VALUES (204, '211200', '铁岭市', 2);
INSERT INTO `cms_city` VALUES (205, '210800', '营口市', 2);
INSERT INTO `cms_city` VALUES (206, '152900', '阿拉善盟', 2);
INSERT INTO `cms_city` VALUES (207, '150800', '巴彦淖尔市', 2);
INSERT INTO `cms_city` VALUES (208, '150200', '包头市', 2);
INSERT INTO `cms_city` VALUES (209, '150400', '赤峰市', 2);
INSERT INTO `cms_city` VALUES (210, '150600', '鄂尔多斯市', 2);
INSERT INTO `cms_city` VALUES (211, '150100', '呼和浩特市', 2);
INSERT INTO `cms_city` VALUES (212, '150700', '呼伦贝尔市', 2);
INSERT INTO `cms_city` VALUES (213, '150500', '通辽市', 2);
INSERT INTO `cms_city` VALUES (214, '150300', '乌海市', 2);
INSERT INTO `cms_city` VALUES (215, '150900', '乌兰察布市', 2);
INSERT INTO `cms_city` VALUES (216, '152500', '锡林郭勒盟', 2);
INSERT INTO `cms_city` VALUES (217, '152200', '兴安盟', 2);
INSERT INTO `cms_city` VALUES (218, '640400', '固原市', 2);
INSERT INTO `cms_city` VALUES (219, '640200', '石嘴山市', 2);
INSERT INTO `cms_city` VALUES (220, '640300', '吴忠市', 2);
INSERT INTO `cms_city` VALUES (221, '640100', '银川市', 2);
INSERT INTO `cms_city` VALUES (222, '640500', '中卫市', 2);
INSERT INTO `cms_city` VALUES (223, '632600', '果洛藏族自治州', 2);
INSERT INTO `cms_city` VALUES (224, '632200', '海北藏族自治州', 2);
INSERT INTO `cms_city` VALUES (225, '632100', '海东地区', 2);
INSERT INTO `cms_city` VALUES (226, '632500', '海南藏族自治州', 2);
INSERT INTO `cms_city` VALUES (227, '632800', '海西蒙古族藏族自治州', 2);
INSERT INTO `cms_city` VALUES (228, '632300', '黄南藏族自治州', 2);
INSERT INTO `cms_city` VALUES (229, '630100', '西宁市', 2);
INSERT INTO `cms_city` VALUES (230, '632700', '玉树藏族自治州', 2);
INSERT INTO `cms_city` VALUES (231, '371600', '滨州市', 2);
INSERT INTO `cms_city` VALUES (232, '371400', '德州市', 2);
INSERT INTO `cms_city` VALUES (233, '370500', '东营市', 2);
INSERT INTO `cms_city` VALUES (234, '371700', '菏泽市', 2);
INSERT INTO `cms_city` VALUES (235, '370100', '济南市', 2);
INSERT INTO `cms_city` VALUES (236, '370800', '济宁市', 2);
INSERT INTO `cms_city` VALUES (237, '371200', '莱芜市', 2);
INSERT INTO `cms_city` VALUES (238, '371500', '聊城市', 2);
INSERT INTO `cms_city` VALUES (239, '371300', '临沂市', 2);
INSERT INTO `cms_city` VALUES (240, '370200', '青岛市', 2);
INSERT INTO `cms_city` VALUES (241, '371100', '日照市', 2);
INSERT INTO `cms_city` VALUES (242, '370900', '泰安市', 2);
INSERT INTO `cms_city` VALUES (243, '371000', '威海市', 2);
INSERT INTO `cms_city` VALUES (244, '370700', '潍坊市', 2);
INSERT INTO `cms_city` VALUES (245, '370600', '烟台市', 2);
INSERT INTO `cms_city` VALUES (246, '370400', '枣庄市', 2);
INSERT INTO `cms_city` VALUES (247, '370300', '淄博市', 2);
INSERT INTO `cms_city` VALUES (248, '140400', '长治市', 2);
INSERT INTO `cms_city` VALUES (249, '140200', '大同市', 2);
INSERT INTO `cms_city` VALUES (250, '140500', '晋城市', 2);
INSERT INTO `cms_city` VALUES (251, '140700', '晋中市', 2);
INSERT INTO `cms_city` VALUES (252, '141000', '临汾市', 2);
INSERT INTO `cms_city` VALUES (253, '141100', '吕梁市', 2);
INSERT INTO `cms_city` VALUES (254, '140600', '朔州市', 2);
INSERT INTO `cms_city` VALUES (255, '140100', '太原市', 2);
INSERT INTO `cms_city` VALUES (256, '140900', '忻州市', 2);
INSERT INTO `cms_city` VALUES (257, '140300', '阳泉市', 2);
INSERT INTO `cms_city` VALUES (258, '140800', '运城市', 2);
INSERT INTO `cms_city` VALUES (259, '610900', '安康市', 2);
INSERT INTO `cms_city` VALUES (260, '610300', '宝鸡市', 2);
INSERT INTO `cms_city` VALUES (261, '610700', '汉中市', 2);
INSERT INTO `cms_city` VALUES (262, '611000', '商洛市', 2);
INSERT INTO `cms_city` VALUES (263, '610200', '铜川市', 2);
INSERT INTO `cms_city` VALUES (264, '610500', '渭南市', 2);
INSERT INTO `cms_city` VALUES (265, '610100', '西安市', 2);
INSERT INTO `cms_city` VALUES (266, '610400', '咸阳市', 2);
INSERT INTO `cms_city` VALUES (267, '610600', '延安市', 2);
INSERT INTO `cms_city` VALUES (268, '610800', '榆林市', 2);
INSERT INTO `cms_city` VALUES (269, '310100', '市辖区', 2);
INSERT INTO `cms_city` VALUES (270, '310200', '县', 2);
INSERT INTO `cms_city` VALUES (271, '513200', '阿坝藏族羌族自治州', 2);
INSERT INTO `cms_city` VALUES (272, '511900', '巴中市', 2);
INSERT INTO `cms_city` VALUES (273, '510100', '成都市', 2);
INSERT INTO `cms_city` VALUES (274, '511700', '达州市', 2);
INSERT INTO `cms_city` VALUES (275, '510600', '德阳市', 2);
INSERT INTO `cms_city` VALUES (276, '513300', '甘孜藏族自治州', 2);
INSERT INTO `cms_city` VALUES (277, '511600', '广安市', 2);
INSERT INTO `cms_city` VALUES (278, '510800', '广元市', 2);
INSERT INTO `cms_city` VALUES (279, '511100', '乐山市', 2);
INSERT INTO `cms_city` VALUES (280, '513400', '凉山彝族自治州', 2);
INSERT INTO `cms_city` VALUES (281, '511400', '眉山市', 2);
INSERT INTO `cms_city` VALUES (282, '510700', '绵阳市', 2);
INSERT INTO `cms_city` VALUES (283, '511300', '南充市', 2);
INSERT INTO `cms_city` VALUES (284, '511000', '内江市', 2);
INSERT INTO `cms_city` VALUES (285, '510400', '攀枝花市', 2);
INSERT INTO `cms_city` VALUES (286, '510900', '遂宁市', 2);
INSERT INTO `cms_city` VALUES (287, '511800', '雅安市', 2);
INSERT INTO `cms_city` VALUES (288, '511500', '宜宾市', 2);
INSERT INTO `cms_city` VALUES (289, '512000', '资阳市', 2);
INSERT INTO `cms_city` VALUES (290, '510300', '自贡市', 2);
INSERT INTO `cms_city` VALUES (291, '510500', '泸州市', 2);
INSERT INTO `cms_city` VALUES (292, '120100', '市辖区', 2);
INSERT INTO `cms_city` VALUES (293, '120200', '县', 2);
INSERT INTO `cms_city` VALUES (294, '542500', '阿里地区', 2);
INSERT INTO `cms_city` VALUES (295, '542100', '昌都地区', 2);
INSERT INTO `cms_city` VALUES (296, '540100', '拉萨市', 2);
INSERT INTO `cms_city` VALUES (297, '542600', '林芝地区', 2);
INSERT INTO `cms_city` VALUES (298, '542400', '那曲地区', 2);
INSERT INTO `cms_city` VALUES (299, '542300', '日喀则地区', 2);
INSERT INTO `cms_city` VALUES (300, '542200', '山南地区', 2);
INSERT INTO `cms_city` VALUES (301, '652900', '阿克苏地区', 2);
INSERT INTO `cms_city` VALUES (302, '654300', '阿勒泰地区', 2);
INSERT INTO `cms_city` VALUES (303, '652800', '巴音郭楞蒙古自治州', 2);
INSERT INTO `cms_city` VALUES (304, '652700', '博尔塔拉蒙古自治州', 2);
INSERT INTO `cms_city` VALUES (305, '652300', '昌吉回族自治州', 2);
INSERT INTO `cms_city` VALUES (306, '652200', '哈密地区', 2);
INSERT INTO `cms_city` VALUES (307, '653200', '和田地区', 2);
INSERT INTO `cms_city` VALUES (308, '653100', '喀什地区', 2);
INSERT INTO `cms_city` VALUES (309, '650200', '克拉玛依市', 2);
INSERT INTO `cms_city` VALUES (310, '653000', '克孜勒苏柯尔克孜自治州', 2);
INSERT INTO `cms_city` VALUES (311, '659000', '省直辖行政单位', 2);
INSERT INTO `cms_city` VALUES (312, '650300', '石河子市', 2);
INSERT INTO `cms_city` VALUES (313, '654200', '塔城地区', 2);
INSERT INTO `cms_city` VALUES (314, '652100', '吐鲁番地区', 2);
INSERT INTO `cms_city` VALUES (315, '650100', '乌鲁木齐市', 2);
INSERT INTO `cms_city` VALUES (316, '654000', '伊犁哈萨克自治州', 2);
INSERT INTO `cms_city` VALUES (317, '530500', '保山市', 2);
INSERT INTO `cms_city` VALUES (318, '532300', '楚雄彝族自治州', 2);
INSERT INTO `cms_city` VALUES (319, '532900', '大理白族自治州', 2);
INSERT INTO `cms_city` VALUES (320, '533100', '德宏傣族景颇族自治州', 2);
INSERT INTO `cms_city` VALUES (321, '533400', '迪庆藏族自治州', 2);
INSERT INTO `cms_city` VALUES (322, '532500', '红河哈尼族彝族自治州', 2);
INSERT INTO `cms_city` VALUES (323, '530100', '昆明市', 2);
INSERT INTO `cms_city` VALUES (324, '530700', '丽江市', 2);
INSERT INTO `cms_city` VALUES (325, '530900', '临沧市', 2);
INSERT INTO `cms_city` VALUES (326, '533300', '怒江傈僳族自治州', 2);
INSERT INTO `cms_city` VALUES (327, '530300', '曲靖市', 2);
INSERT INTO `cms_city` VALUES (328, '530800', '思茅市', 2);
INSERT INTO `cms_city` VALUES (329, '532600', '文山壮族苗族自治州', 2);
INSERT INTO `cms_city` VALUES (330, '532800', '西双版纳傣族自治州', 2);
INSERT INTO `cms_city` VALUES (331, '530400', '玉溪市', 2);
INSERT INTO `cms_city` VALUES (332, '530600', '昭通市', 2);
INSERT INTO `cms_city` VALUES (333, '330100', '杭州市', 2);
INSERT INTO `cms_city` VALUES (334, '330500', '湖州市', 2);
INSERT INTO `cms_city` VALUES (335, '330400', '嘉兴市', 2);
INSERT INTO `cms_city` VALUES (336, '330700', '金华市', 2);
INSERT INTO `cms_city` VALUES (337, '331100', '丽水市', 2);
INSERT INTO `cms_city` VALUES (338, '330200', '宁波市', 2);
INSERT INTO `cms_city` VALUES (339, '330600', '绍兴市', 2);
INSERT INTO `cms_city` VALUES (340, '331000', '台州市', 2);
INSERT INTO `cms_city` VALUES (341, '330300', '温州市', 2);
INSERT INTO `cms_city` VALUES (342, '330900', '舟山市', 2);
INSERT INTO `cms_city` VALUES (343, '330800', '衢州市', 2);
INSERT INTO `cms_city` VALUES (344, '500100', '市辖区', 2);
INSERT INTO `cms_city` VALUES (345, '500200', '县', 2);
INSERT INTO `cms_city` VALUES (346, '340000', '安徽省', 1);
INSERT INTO `cms_city` VALUES (347, '110000', '北京市', 1);
INSERT INTO `cms_city` VALUES (348, '350000', '福建省', 1);
INSERT INTO `cms_city` VALUES (349, '620000', '甘肃省', 1);
INSERT INTO `cms_city` VALUES (350, '440000', '广东省', 1);
INSERT INTO `cms_city` VALUES (351, '450000', '广西壮族自治区', 1);
INSERT INTO `cms_city` VALUES (352, '520000', '贵州省', 1);
INSERT INTO `cms_city` VALUES (353, '460000', '海南省', 1);
INSERT INTO `cms_city` VALUES (354, '130000', '河北省', 1);
INSERT INTO `cms_city` VALUES (355, '410000', '河南省', 1);
INSERT INTO `cms_city` VALUES (356, '230000', '黑龙江省', 1);
INSERT INTO `cms_city` VALUES (357, '420000', '湖北省', 1);
INSERT INTO `cms_city` VALUES (358, '430000', '湖南省', 1);
INSERT INTO `cms_city` VALUES (359, '220000', '吉林省', 1);
INSERT INTO `cms_city` VALUES (360, '320000', '江苏省', 1);
INSERT INTO `cms_city` VALUES (361, '360000', '江西省', 1);
INSERT INTO `cms_city` VALUES (362, '210000', '辽宁省', 1);
INSERT INTO `cms_city` VALUES (363, '150000', '内蒙古自治区', 1);
INSERT INTO `cms_city` VALUES (364, '640000', '宁夏回族自治区', 1);
INSERT INTO `cms_city` VALUES (365, '630000', '青海省', 1);
INSERT INTO `cms_city` VALUES (366, '370000', '山东省', 1);
INSERT INTO `cms_city` VALUES (367, '140000', '山西省', 1);
INSERT INTO `cms_city` VALUES (368, '610000', '陕西省', 1);
INSERT INTO `cms_city` VALUES (369, '310000', '上海市', 1);
INSERT INTO `cms_city` VALUES (370, '510000', '四川省', 1);
INSERT INTO `cms_city` VALUES (371, '120000', '天津市', 1);
INSERT INTO `cms_city` VALUES (372, '540000', '西藏自治区', 1);
INSERT INTO `cms_city` VALUES (373, '650000', '新疆维吾尔自治区', 1);
INSERT INTO `cms_city` VALUES (374, '530000', '云南省', 1);
INSERT INTO `cms_city` VALUES (375, '330000', '浙江省', 1);
INSERT INTO `cms_city` VALUES (376, '500000', '重庆市', 1);

-- ----------------------------
-- Table structure for cms_config
-- ----------------------------
DROP TABLE IF EXISTS `cms_config`;
CREATE TABLE `cms_config`  (
  `variable` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `vardata` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ismix` tinyint(2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`variable`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cms_config
-- ----------------------------
INSERT INTO `cms_config` VALUES ('webname', '游戏首发平台', 0);
INSERT INTO `cms_config` VALUES ('navname', '首页', 0);
INSERT INTO `cms_config` VALUES ('weburl', 'http://localhost:8080/', 0);
INSERT INTO `cms_config` VALUES ('keyword', '', 0);
INSERT INTO `cms_config` VALUES ('description', '', 0);
INSERT INTO `cms_config` VALUES ('webtj', '', 0);
INSERT INTO `cms_config` VALUES ('weberserviceqq', '304455977', 0);
INSERT INTO `cms_config` VALUES ('aderserviceqq', '', 0);
INSERT INTO `cms_config` VALUES ('uploadpicpath', 'distribdata/uploadpic/', 0);
INSERT INTO `cms_config` VALUES ('cpspaylimit', '30', 0);
INSERT INTO `cms_config` VALUES ('haveadtype', 'cpc,cpm', 0);
INSERT INTO `cms_config` VALUES ('codeserver', 'code.2366.com', 0);
INSERT INTO `cms_config` VALUES ('cpspayper', '50', 0);

-- ----------------------------
-- Table structure for cms_datacall_list
-- ----------------------------
DROP TABLE IF EXISTS `cms_datacall_list`;
CREATE TABLE `cms_datacall_list`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `flagname` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `dpid` int(11) NOT NULL DEFAULT 0,
  `dsql` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `datatmp` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `cachetime` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `dpid`(`dpid`) USING BTREE,
  INDEX `flagname`(`flagname`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cms_datacall_list
-- ----------------------------
INSERT INTO `cms_datacall_list` VALUES (3, '测试', 'inde_member_10', 2, 'select * from cms_member  limit 10', '<!--{loop $_SGLOBAL[\'datacall\'][\'inde_member_10\'] $value}-->\r\n<li>$value[username]</li>\r\n<!--{/loop}-->', 3600);

-- ----------------------------
-- Table structure for cms_datacall_place
-- ----------------------------
DROP TABLE IF EXISTS `cms_datacall_place`;
CREATE TABLE `cms_datacall_place`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `placename` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cms_datacall_place
-- ----------------------------
INSERT INTO `cms_datacall_place` VALUES (2, '首页');
INSERT INTO `cms_datacall_place` VALUES (3, '分类页');

-- ----------------------------
-- Table structure for cms_imagelog
-- ----------------------------
DROP TABLE IF EXISTS `cms_imagelog`;
CREATE TABLE `cms_imagelog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `uploadtime` int(11) NOT NULL DEFAULT 0,
  `uploadpath` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `imgwh` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `username`(`username`) USING BTREE,
  INDEX `imgwh`(`imgwh`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cms_member
-- ----------------------------
DROP TABLE IF EXISTS `cms_member`;
CREATE TABLE `cms_member`  (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `password` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `usertype` tinyint(2) NOT NULL DEFAULT 0 COMMENT '1广告主,2网站主',
  `isadmin` tinyint(2) NOT NULL DEFAULT 0,
  `gid` int(11) NOT NULL DEFAULT 0,
  `lastloginip` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `lastlogintime` int(11) NOT NULL DEFAULT 0,
  `state` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0未审核1正常',
  PRIMARY KEY (`uid`) USING BTREE,
  INDEX `isadmin`(`isadmin`) USING BTREE,
  INDEX `usertype`(`usertype`) USING BTREE,
  INDEX `username`(`username`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of cms_member
-- ----------------------------
INSERT INTO `cms_member` VALUES (1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, 1, 1, '127.0.0.1', 1513840934, 1);
INSERT INTO `cms_member` VALUES (2, 'bobboy007', 'dc648c803630dff6b639ba58c4453c72', 2, 0, 0, '127.0.0.1', 1291348571, 1);

-- ----------------------------
-- Table structure for cms_member_ad
-- ----------------------------
DROP TABLE IF EXISTS `cms_member_ad`;
CREATE TABLE `cms_member_ad`  (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `serviceqq` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `havemoney` float(12, 2) NOT NULL DEFAULT 0.00,
  `usedmoney` float(12, 2) NOT NULL DEFAULT 0.00,
  `authkey` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '广告主合作key',
  `question` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `answer` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `webname` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `weburl` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `telnum` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `qqmsn` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`uid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cms_member_ad
-- ----------------------------
INSERT INTO `cms_member_ad` VALUES (7, 'fdsaf', 0.00, 0.00, 'dsaf', NULL, NULL, 'dsf', 'dsfd', 'fds', 'fds', 'f');
INSERT INTO `cms_member_ad` VALUES (13, '', 0.00, 0.00, '', NULL, NULL, '', '', '', '', '');

-- ----------------------------
-- Table structure for cms_member_web
-- ----------------------------
DROP TABLE IF EXISTS `cms_member_web`;
CREATE TABLE `cms_member_web`  (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `havemoney` float NOT NULL DEFAULT 0,
  `serviceqq` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `question` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `answer` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `webname` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `weburl` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `telnum` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `qqmsn` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `province` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `city` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `realname` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `bankname` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `bankaddress` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `bankaccounts` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`uid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cms_member_webtype
-- ----------------------------
DROP TABLE IF EXISTS `cms_member_webtype`;
CREATE TABLE `cms_member_webtype`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typename` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cms_member_webtype
-- ----------------------------
INSERT INTO `cms_member_webtype` VALUES (1, '门户网站');
INSERT INTO `cms_member_webtype` VALUES (2, '聊天交友');
INSERT INTO `cms_member_webtype` VALUES (3, '软件下载');
INSERT INTO `cms_member_webtype` VALUES (4, '素材资源');
INSERT INTO `cms_member_webtype` VALUES (5, '金融财经');
INSERT INTO `cms_member_webtype` VALUES (6, '教育文化');
INSERT INTO `cms_member_webtype` VALUES (7, '生活资讯');
INSERT INTO `cms_member_webtype` VALUES (8, '文学艺术');
INSERT INTO `cms_member_webtype` VALUES (9, '医疗保健');
INSERT INTO `cms_member_webtype` VALUES (10, '军事体育');
INSERT INTO `cms_member_webtype` VALUES (11, '综合游戏');
INSERT INTO `cms_member_webtype` VALUES (12, '娱乐休闲');
INSERT INTO `cms_member_webtype` VALUES (13, '影视音乐');
INSERT INTO `cms_member_webtype` VALUES (14, '科技IT');
INSERT INTO `cms_member_webtype` VALUES (15, '人才招聘');
INSERT INTO `cms_member_webtype` VALUES (16, '其他类别');

-- ----------------------------
-- Table structure for cms_modules
-- ----------------------------
DROP TABLE IF EXISTS `cms_modules`;
CREATE TABLE `cms_modules`  (
  `moduleid` int(11) NOT NULL AUTO_INCREMENT,
  `moduletype` tinyint(2) NOT NULL DEFAULT 0 COMMENT '1模块2插件',
  `flag` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `iscore` tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否核心',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `introduce` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `directory` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `disable` tinyint(2) NOT NULL DEFAULT 0,
  `moduleconfig` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `menuconfig` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `version` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `author` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`moduleid`) USING BTREE,
  INDEX `moduletype`(`moduletype`) USING BTREE,
  INDEX `disable`(`disable`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cms_modules
-- ----------------------------
INSERT INTO `cms_modules` VALUES (10, 2, 'board', 0, '文章发布', '简单文章发布', 'board', 0, 'a:0:{}', 'a:3:{s:5:\"title\";s:12:\"文章发布\";i:0;s:28:\"board|文章列表|boardlist\";i:1;s:42:\"board|文章类型|boardlist|boardtypelist\";}', '1.0', 'bobboy007');
INSERT INTO `cms_modules` VALUES (9, 1, 'member', 1, '会员模块', '包括广告点击流程', 'member', 0, 'a:0:{}', 'a:0:{}', '1.0', 'bobboy007');
INSERT INTO `cms_modules` VALUES (12, 1, 'article', 0, 'cms系统', 'cms发布系统', 'article', 0, 'a:0:{}', 'a:0:{}', '1.0', 'bobboy007');

-- ----------------------------
-- Table structure for cms_plug_board
-- ----------------------------
DROP TABLE IF EXISTS `cms_plug_board`;
CREATE TABLE `cms_plug_board`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL DEFAULT 0,
  `title` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `litpic` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `dt` int(11) NOT NULL DEFAULT 0,
  `sorder` tinyint(2) NOT NULL DEFAULT 0,
  `adminid` int(11) NOT NULL DEFAULT 0,
  `outurl` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `tid`(`tid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cms_plug_board
-- ----------------------------
INSERT INTO `cms_plug_board` VALUES (1, 1, '测试公告', 'fdsfdsf', '反对萨芬德萨发\'fdsf<br />\r\n', 1278479136, 0, 1, NULL);
INSERT INTO `cms_plug_board` VALUES (6, 1, 'gfd', '', 'g', 1285726247, 0, 1, 'ggfds');

-- ----------------------------
-- Table structure for cms_plug_boardtype
-- ----------------------------
DROP TABLE IF EXISTS `cms_plug_boardtype`;
CREATE TABLE `cms_plug_boardtype`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typename` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cms_plug_boardtype
-- ----------------------------
INSERT INTO `cms_plug_boardtype` VALUES (1, '公告');
INSERT INTO `cms_plug_boardtype` VALUES (4, '推荐广告');
INSERT INTO `cms_plug_boardtype` VALUES (6, '常见问题');
INSERT INTO `cms_plug_boardtype` VALUES (7, 'flash幻灯');

-- ----------------------------
-- Table structure for cms_session
-- ----------------------------
DROP TABLE IF EXISTS `cms_session`;
CREATE TABLE `cms_session`  (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `password` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `lastactivity` int(11) NOT NULL DEFAULT 0,
  `ip` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`uid`) USING HASH
) ENGINE = MEMORY AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of cms_session
-- ----------------------------
INSERT INTO `cms_session` VALUES (1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1513840934, 127000000);

-- ----------------------------
-- Table structure for cms_useraction
-- ----------------------------
DROP TABLE IF EXISTS `cms_useraction`;
CREATE TABLE `cms_useraction`  (
  `acid` int(11) NOT NULL AUTO_INCREMENT,
  `title` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `umodule` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `uaction` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `uoperat` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`acid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of cms_useraction
-- ----------------------------
INSERT INTO `cms_useraction` VALUES (1, '模块列表', 'admin', 'modules', '');
INSERT INTO `cms_useraction` VALUES (4, '会员列表', 'admin', 'member', 'memberlist');
INSERT INTO `cms_useraction` VALUES (5, '渠道控制', 'member', 'channel', '');

-- ----------------------------
-- Table structure for cms_usergroup
-- ----------------------------
DROP TABLE IF EXISTS `cms_usergroup`;
CREATE TABLE `cms_usergroup`  (
  `gid` int(11) NOT NULL AUTO_INCREMENT,
  `groupname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `aclist` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `descript` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`gid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cms_usergroup
-- ----------------------------
INSERT INTO `cms_usergroup` VALUES (1, '超级管理员组', '', '拥有所有权限');
INSERT INTO `cms_usergroup` VALUES (2, '渠道用户组', '5', '可查看渠道的点击量');

SET FOREIGN_KEY_CHECKS = 1;
