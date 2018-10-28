#
# TABLE STRUCTURE FOR: ms_admin
#

DROP TABLE IF EXISTS ms_admin;

CREATE TABLE `ms_admin` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `adminname` varchar(64) DEFAULT '' COMMENT '账号',
  `adminpass` varchar(64) DEFAULT '' COMMENT '密码',
  `admincode` varchar(6) DEFAULT '' COMMENT '密钥',
  `logip` varchar(128) DEFAULT '' COMMENT '最后登录IP',
  `lognums` int(10) DEFAULT '0' COMMENT '登录次数',
  `logtime` int(10) DEFAULT '0' COMMENT '最后登录时间',
  `card` varchar(255) DEFAULT '' COMMENT '口令卡',
  `sid` smallint(3) unsigned DEFAULT '0' COMMENT '角色id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='管理员表';

#
# TABLE STRUCTURE FOR: ms_admin_log
#

DROP TABLE IF EXISTS ms_admin_log;

CREATE TABLE `ms_admin_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` smallint(5) unsigned DEFAULT '0' COMMENT '用户ID',
  `loginip` varchar(50) DEFAULT '' COMMENT '登录IP',
  `logintime` int(10) unsigned DEFAULT '0' COMMENT '登录时间',
  `useragent` varchar(255) DEFAULT '' COMMENT '客户端信息',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COMMENT='管理员登录表';

#
# TABLE STRUCTURE FOR: ms_adminzu
#

DROP TABLE IF EXISTS ms_adminzu;

CREATE TABLE `ms_adminzu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT '' COMMENT '角色名称',
  `sys` text COMMENT '默认权限',
  `app` text COMMENT '板块权限',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='管理员角色表';

#
# TABLE STRUCTURE FOR: ms_ads
#

DROP TABLE IF EXISTS ms_ads;

CREATE TABLE `ms_ads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT '' COMMENT '标签标示',
  `js` varchar(100) DEFAULT '' COMMENT 'JS路径',
  `html` text COMMENT '标签代码',
  `neir` varchar(200) DEFAULT '' COMMENT '标签介绍',
  `addtime` int(11) DEFAULT '0' COMMENT '增加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='自定义JS表';

#
# TABLE STRUCTURE FOR: ms_blog
#

DROP TABLE IF EXISTS ms_blog;

CREATE TABLE `ms_blog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned DEFAULT '0' COMMENT '会员ID',
  `hits` int(10) unsigned DEFAULT '0' COMMENT '浏览次数',
  `phits` int(10) unsigned DEFAULT '0' COMMENT '评论次数',
  `neir` text COMMENT '说说内容',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '发表时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `pjits` (`phits`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员说说表';

#
# TABLE STRUCTURE FOR: ms_caiji
#

DROP TABLE IF EXISTS ms_caiji;

CREATE TABLE `ms_caiji` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT '',
  `url` varchar(250) DEFAULT '',
  `code` varchar(10) DEFAULT '',
  `dir` varchar(64) DEFAULT '',
  `zid` tinyint(1) DEFAULT '0',
  `fid` smallint(5) DEFAULT '0',
  `cfid` tinyint(1) DEFAULT '0',
  `picid` tinyint(1) DEFAULT '0',
  `dxid` tinyint(1) DEFAULT '0',
  `rkid` tinyint(1) DEFAULT '0',
  `htmlid` tinyint(1) DEFAULT '0',
  `cjurl` text,
  `ksid` int(10) DEFAULT '0',
  `jsid` int(10) DEFAULT '0',
  `listks` text,
  `listjs` text,
  `picmode` tinyint(1) DEFAULT '0',
  `picks` text,
  `picjs` text,
  `linkks` text,
  `linkjs` text,
  `nameks` text,
  `namejs` text,
  `strth` text,
  `addtime` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='采集规则表';

#
# TABLE STRUCTURE FOR: ms_cjannex
#

DROP TABLE IF EXISTS ms_cjannex;

CREATE TABLE `ms_cjannex` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT '',
  `cid` int(10) unsigned DEFAULT '0',
  `fid` tinyint(1) DEFAULT '0',
  `htmlid` tinyint(1) DEFAULT '0',
  `zd` varchar(128) DEFAULT '',
  `ks` text,
  `js` text,
  `fname` varchar(64) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cid` (`cid`),
  KEY `fid` (`fid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='采集新增规则表';

#
# TABLE STRUCTURE FOR: ms_cjdata
#

DROP TABLE IF EXISTS ms_cjdata;

CREATE TABLE `ms_cjdata` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dir` varchar(64) DEFAULT '',
  `name` varchar(255) DEFAULT '',
  `pic` varchar(255) DEFAULT '',
  `zid` tinyint(1) DEFAULT '0',
  `cfid` tinyint(1) DEFAULT '0',
  `zdy` text,
  `addtime` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `zid` (`zid`)
) ENGINE=MyISAM AUTO_INCREMENT=935 DEFAULT CHARSET=utf8 COMMENT='采集数据表';

#
# TABLE STRUCTURE FOR: ms_cjlist
#

DROP TABLE IF EXISTS ms_cjlist;

CREATE TABLE `ms_cjlist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT '',
  `dir` varchar(64) DEFAULT '',
  `url` varchar(255) DEFAULT '',
  `names` varchar(255) DEFAULT '',
  `zid` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `zid` (`zid`)
) ENGINE=MyISAM AUTO_INCREMENT=1011 DEFAULT CHARSET=utf8 COMMENT='采集站点表';

#
# TABLE STRUCTURE FOR: ms_daili_jilu
#

DROP TABLE IF EXISTS ms_daili_jilu;

CREATE TABLE `ms_daili_jilu` (
  `id` mediumint(5) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(5) DEFAULT '0' COMMENT '会员ID',
  `dlid` mediumint(5) DEFAULT '0' COMMENT '代理ID',
  `dljb` mediumint(5) DEFAULT '0' COMMENT '代理级别',
  `cion` mediumint(5) DEFAULT '0' COMMENT '充值金币',
  `dltime` int(10) unsigned DEFAULT '0' COMMENT '充值时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `dlid` (`dlid`),
  KEY `dljb` (`dljb`),
  KEY `cion` (`cion`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='代理提成记录';

#
# TABLE STRUCTURE FOR: ms_daili_tixian
#

DROP TABLE IF EXISTS ms_daili_tixian;

CREATE TABLE `ms_daili_tixian` (
  `id` mediumint(5) unsigned NOT NULL AUTO_INCREMENT,
  `cid` mediumint(5) DEFAULT '0' COMMENT '分类ID',
  `uid` mediumint(5) DEFAULT '0' COMMENT '代理ID',
  `tcion` mediumint(5) DEFAULT '0' COMMENT '提现金币',
  `zid` mediumint(5) DEFAULT '0' COMMENT '状态',
  `text` text COMMENT '详细介绍',
  `dltime` int(10) unsigned DEFAULT '0' COMMENT '提现时间',
  `tell` text COMMENT '详细介绍',
  `name` text COMMENT '详细介绍',
  PRIMARY KEY (`id`),
  KEY `cid` (`cid`),
  KEY `dlid` (`uid`),
  KEY `zid` (`zid`),
  KEY `tcion` (`tcion`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='提现记录';

#
# TABLE STRUCTURE FOR: ms_daili_type
#

DROP TABLE IF EXISTS ms_daili_type;

CREATE TABLE `ms_daili_type` (
  `id` mediumint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT '' COMMENT '名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='提现分类';

#
# TABLE STRUCTURE FOR: ms_daili_xiaji
#

DROP TABLE IF EXISTS ms_daili_xiaji;

CREATE TABLE `ms_daili_xiaji` (
  `id` mediumint(5) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(5) DEFAULT '0' COMMENT '会员ID',
  `dlid` mediumint(5) DEFAULT '0' COMMENT '代理ID',
  `dljb` mediumint(5) DEFAULT '0' COMMENT '代理级别',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `dlid` (`dlid`),
  KEY `dljb` (`dljb`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='下级代理';

#
# TABLE STRUCTURE FOR: ms_dt
#

DROP TABLE IF EXISTS ms_dt;

CREATE TABLE `ms_dt` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned DEFAULT '0' COMMENT '会员ID',
  `dir` varchar(64) DEFAULT '' COMMENT '版块标示',
  `yid` tinyint(1) DEFAULT '0' COMMENT '是否显示',
  `title` varchar(255) DEFAULT '' COMMENT '类型标题',
  `did` int(10) unsigned DEFAULT '0' COMMENT '数据ID',
  `name` varchar(255) DEFAULT '' COMMENT '数据标题',
  `link` varchar(255) DEFAULT '' COMMENT '数据链接',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '增加时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `yid` (`yid`),
  KEY `did` (`did`),
  KEY `dt_dir_id` (`dir`,`id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COMMENT='会员动态表';

#
# TABLE STRUCTURE FOR: ms_fans
#

DROP TABLE IF EXISTS ms_fans;

CREATE TABLE `ms_fans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uida` int(10) unsigned DEFAULT '0' COMMENT '会员ID',
  `uidb` int(10) unsigned DEFAULT '0' COMMENT '粉丝ID',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `fans_uida_id` (`uida`,`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='粉丝表';

#
# TABLE STRUCTURE FOR: ms_friend
#

DROP TABLE IF EXISTS ms_friend;

CREATE TABLE `ms_friend` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uida` int(10) unsigned DEFAULT '0' COMMENT '会员ID',
  `uidb` int(10) unsigned DEFAULT '0' COMMENT '好友ID',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `friend_uida_id` (`uida`,`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='好友表';

#
# TABLE STRUCTURE FOR: ms_funco
#

DROP TABLE IF EXISTS ms_funco;

CREATE TABLE `ms_funco` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uida` int(10) unsigned DEFAULT '0' COMMENT '会员ID',
  `uidb` int(10) unsigned DEFAULT '0' COMMENT '访问者ID',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `funco_uida_id` (`uida`,`id`),
  KEY `funco_uidb_id` (`uidb`,`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='访客表';

#
# TABLE STRUCTURE FOR: ms_gbook
#

DROP TABLE IF EXISTS ms_gbook;

CREATE TABLE `ms_gbook` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cid` tinyint(1) DEFAULT '0' COMMENT '类型ID',
  `fid` int(10) unsigned DEFAULT '0' COMMENT '上级ID',
  `uida` int(10) unsigned DEFAULT '0' COMMENT '会员ID',
  `uidb` int(10) unsigned DEFAULT '0' COMMENT '留言者ID',
  `neir` text COMMENT '内容',
  `ip` varchar(20) DEFAULT '' COMMENT 'IP',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `fid` (`fid`),
  KEY `cid` (`cid`),
  KEY `gbook_uida_id` (`uida`,`id`),
  KEY `gbook_uidb_id` (`uidb`,`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='留言表';

#
# TABLE STRUCTURE FOR: ms_income
#

DROP TABLE IF EXISTS ms_income;

CREATE TABLE `ms_income` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dir` varchar(64) DEFAULT '' COMMENT '所属板块',
  `title` varchar(255) DEFAULT '' COMMENT '收入内容',
  `sid` tinyint(1) DEFAULT '0' COMMENT '分类ID',
  `uid` int(10) unsigned DEFAULT '0' COMMENT '会员ID',
  `nums` int(10) unsigned DEFAULT '0' COMMENT '数量',
  `ip` varchar(15) DEFAULT '' COMMENT 'IP',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `sid` (`sid`),
  KEY `uid` (`uid`),
  KEY `dir` (`dir`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='收入记录表';

#
# TABLE STRUCTURE FOR: ms_label
#

DROP TABLE IF EXISTS ms_label;

CREATE TABLE `ms_label` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT '' COMMENT '唯一标示',
  `selflable` text COMMENT '标签内容',
  `neir` varchar(128) DEFAULT '' COMMENT '标签介绍',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='静态标签表';

#
# TABLE STRUCTURE FOR: ms_link
#

DROP TABLE IF EXISTS ms_link;

CREATE TABLE `ms_link` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT '' COMMENT '名称',
  `url` varchar(255) DEFAULT '' COMMENT '地址',
  `pic` varchar(255) DEFAULT '' COMMENT 'LOGO',
  `cid` tinyint(1) DEFAULT '1' COMMENT '类型',
  `sid` tinyint(1) DEFAULT '1' COMMENT '主页是否显示',
  `xid` smallint(5) DEFAULT '0' COMMENT '排序号',
  PRIMARY KEY (`id`),
  KEY `cid` (`cid`),
  KEY `sid` (`sid`),
  KEY `xid` (`xid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='友情链接表';

#
# TABLE STRUCTURE FOR: ms_lipin_jilu
#

DROP TABLE IF EXISTS ms_lipin_jilu;

CREATE TABLE `ms_lipin_jilu` (
  `id` mediumint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT '' COMMENT '礼品名称',
  `uid` mediumint(5) DEFAULT '0' COMMENT '会员ID',
  `lid` mediumint(5) DEFAULT '0' COMMENT '礼品ID',
  `nums` mediumint(5) DEFAULT '0' COMMENT '购买数量',
  `cion` mediumint(5) DEFAULT '0' COMMENT '价值金币',
  `zid` mediumint(5) DEFAULT '0' COMMENT '{0:申请中,1:通过}',
  `text` text COMMENT '发货地址',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '兑换时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `lid` (`lid`),
  KEY `nums` (`nums`),
  KEY `cion` (`cion`),
  KEY `zid` (`zid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='兑换礼品';

#
# TABLE STRUCTURE FOR: ms_lipin_list
#

DROP TABLE IF EXISTS ms_lipin_list;

CREATE TABLE `ms_lipin_list` (
  `id` mediumint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT '' COMMENT '礼品名称',
  `pic` varchar(255) DEFAULT '' COMMENT '礼品图片',
  `cid` mediumint(5) DEFAULT '0' COMMENT '分类ID',
  `nums` mediumint(5) DEFAULT '0' COMMENT '购买数量',
  `cion` mediumint(5) DEFAULT '0' COMMENT '价值金币',
  `zid` mediumint(5) DEFAULT '0' COMMENT '{0:显示,1:隐藏}',
  `text` text COMMENT '详细介绍',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '发布时间',
  PRIMARY KEY (`id`),
  KEY `cid` (`cid`),
  KEY `nums` (`nums`),
  KEY `cion` (`cion`),
  KEY `zid` (`zid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='礼品列表';

#
# TABLE STRUCTURE FOR: ms_msg
#

DROP TABLE IF EXISTS ms_msg;

CREATE TABLE `ms_msg` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `did` tinyint(1) DEFAULT '0' COMMENT '是否已读',
  `name` varchar(255) DEFAULT '' COMMENT '标题',
  `neir` text COMMENT '内容',
  `uida` int(10) unsigned DEFAULT '0' COMMENT '会员ID',
  `uidb` int(10) unsigned DEFAULT '0' COMMENT '发送者ID',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `did` (`did`),
  KEY `msg_uida_id` (`uida`)
) ENGINE=MyISAM AUTO_INCREMENT=206 DEFAULT CHARSET=utf8 COMMENT='会员消息表';

#
# TABLE STRUCTURE FOR: ms_news
#

DROP TABLE IF EXISTS ms_news;

CREATE TABLE `ms_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT '' COMMENT '名称',
  `bname` varchar(64) DEFAULT '' COMMENT '英文别名',
  `color` varchar(10) DEFAULT '' COMMENT '名称颜色',
  `tags` varchar(255) DEFAULT '' COMMENT 'TAGS标签',
  `pic` varchar(255) DEFAULT '' COMMENT '萎缩图',
  `pic2` varchar(255) DEFAULT '' COMMENT '幻灯图片',
  `cid` mediumint(5) DEFAULT '0' COMMENT '分类ID',
  `tid` mediumint(5) DEFAULT '0' COMMENT '专题ID',
  `reco` tinyint(1) DEFAULT '0' COMMENT '推荐星级',
  `yid` tinyint(1) DEFAULT '0' COMMENT '是否隐藏',
  `hid` tinyint(1) DEFAULT '0' COMMENT '是否回收站',
  `uid` int(10) unsigned DEFAULT '0' COMMENT '会员ID',
  `hits` int(10) unsigned DEFAULT '0' COMMENT '总人气',
  `yhits` int(10) unsigned DEFAULT '0' COMMENT '月人气',
  `zhits` int(10) unsigned DEFAULT '0' COMMENT '周人气',
  `rhits` int(10) unsigned DEFAULT '0' COMMENT '日人气',
  `dhits` int(10) unsigned DEFAULT '0' COMMENT '顶人气',
  `chits` int(10) unsigned DEFAULT '0' COMMENT '踩人气',
  `cion` mediumint(5) DEFAULT '0' COMMENT '阅读需要金币',
  `vip` mediumint(5) DEFAULT '0' COMMENT '可观看组',
  `level` mediumint(5) DEFAULT '0' COMMENT '可观看等级',
  `info` varchar(128) DEFAULT '' COMMENT '描述',
  `content` text COMMENT '新闻内容',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '增加时间',
  `skins` varchar(64) DEFAULT 'show.html' COMMENT '默认模板',
  `title` varchar(64) DEFAULT '' COMMENT 'SEO标题',
  `keywords` varchar(150) DEFAULT '' COMMENT 'SEO关键词',
  `description` varchar(200) DEFAULT '' COMMENT 'SEO介绍',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `cid` (`cid`),
  KEY `tid` (`tid`),
  KEY `hid` (`hid`),
  KEY `yid` (`yid`),
  KEY `reco` (`reco`),
  KEY `hits` (`hits`),
  KEY `yhits` (`yhits`),
  KEY `zhits` (`zhits`),
  KEY `rhits` (`rhits`),
  KEY `news_hid_addtime` (`hid`,`addtime`),
  KEY `news_cid_yid_hid_id` (`yid`,`hid`,`id`)
) ENGINE=MyISAM AUTO_INCREMENT=376 DEFAULT CHARSET=utf8 COMMENT='新闻表';

#
# TABLE STRUCTURE FOR: ms_news_list
#

DROP TABLE IF EXISTS ms_news_list;

CREATE TABLE `ms_news_list` (
  `id` mediumint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT '' COMMENT '名称',
  `bname` varchar(30) DEFAULT '' COMMENT '英文别名',
  `fid` tinyint(3) DEFAULT '0' COMMENT '上级ID',
  `xid` tinyint(3) DEFAULT '0' COMMENT '排序ID',
  `yid` tinyint(1) DEFAULT '0' COMMENT '是否显示',
  `skins` varchar(64) DEFAULT 'list.html' COMMENT '默认模板',
  `title` varchar(64) DEFAULT '' COMMENT 'SEO标题',
  `keywords` varchar(150) DEFAULT '' COMMENT 'SEO关键词',
  `description` varchar(200) DEFAULT '' COMMENT 'SEO介绍',
  PRIMARY KEY (`id`),
  KEY `xid` (`xid`),
  KEY `yid` (`yid`),
  KEY `fid` (`fid`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='新闻分类表';

#
# TABLE STRUCTURE FOR: ms_news_look
#

DROP TABLE IF EXISTS ms_news_look;

CREATE TABLE `ms_news_look` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT '' COMMENT '新闻名称',
  `cid` mediumint(5) unsigned DEFAULT '0' COMMENT '新闻分类ID',
  `did` varchar(128) DEFAULT '' COMMENT '新闻ID',
  `uid` int(10) unsigned DEFAULT '0' COMMENT '会员ID',
  `cion` int(10) DEFAULT '0' COMMENT '扣除金币',
  `ip` varchar(20) DEFAULT '' COMMENT '会员IP',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `cid` (`cid`),
  KEY `did` (`did`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='新闻收费阅读记录';

#
# TABLE STRUCTURE FOR: ms_news_topic
#

DROP TABLE IF EXISTS ms_news_topic;

CREATE TABLE `ms_news_topic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT '' COMMENT '名称',
  `bname` varchar(20) DEFAULT '' COMMENT '别名',
  `pic` varchar(255) DEFAULT '' COMMENT '图片',
  `toppic` varchar(255) DEFAULT '' COMMENT '顶部图片',
  `tid` tinyint(1) DEFAULT '0' COMMENT '是否推荐',
  `yid` tinyint(1) DEFAULT '0' COMMENT '是否审核',
  `hits` int(10) unsigned DEFAULT '0' COMMENT '总人气',
  `yhits` int(10) unsigned DEFAULT '0' COMMENT '月人气',
  `zhits` int(10) unsigned DEFAULT '0' COMMENT '周人气',
  `rhits` int(10) unsigned DEFAULT '0' COMMENT '日人气',
  `neir` text COMMENT '介绍',
  `skins` varchar(64) DEFAULT 'topic.html' COMMENT '默认模板',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '时间',
  `title` varchar(64) DEFAULT '' COMMENT 'SEO标题',
  `keywords` varchar(150) DEFAULT '' COMMENT 'SEO关键词',
  `description` varchar(200) DEFAULT '' COMMENT 'SEO介绍',
  PRIMARY KEY (`id`),
  KEY `tid` (`tid`),
  KEY `yid` (`yid`),
  KEY `hits` (`hits`),
  KEY `yhits` (`yhits`),
  KEY `zhits` (`zhits`),
  KEY `rhits` (`rhits`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='新闻专题表';

#
# TABLE STRUCTURE FOR: ms_page
#

DROP TABLE IF EXISTS ms_page;

CREATE TABLE `ms_page` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `sid` tinyint(1) DEFAULT '0' COMMENT '运行方式',
  `name` varchar(64) DEFAULT '' COMMENT '唯一标示',
  `neir` varchar(128) DEFAULT '' COMMENT '页面介绍',
  `url` varchar(100) DEFAULT '' COMMENT '页面路径',
  `html` text COMMENT '页面被容',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `sid` (`sid`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='自定义页面表';

#
# TABLE STRUCTURE FOR: ms_pay
#

DROP TABLE IF EXISTS ms_pay;

CREATE TABLE `ms_pay` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dingdan` varchar(64) DEFAULT '' COMMENT '订单',
  `type` varchar(30) DEFAULT '' COMMENT '支付方式',
  `uid` int(10) unsigned DEFAULT '0' COMMENT '会员ID',
  `rmb` decimal(10,2) DEFAULT '0.00' COMMENT '金额',
  `pid` tinyint(1) DEFAULT '0' COMMENT '状态',
  `ip` varchar(15) DEFAULT '' COMMENT 'IP',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '时间',
  `cion` int(100) unsigned DEFAULT '0' COMMENT '金币',
  `name` varchar(20) DEFAULT '' COMMENT '账号',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `pid` (`pid`),
  KEY `dingdan` (`dingdan`)
) ENGINE=MyISAM AUTO_INCREMENT=102 DEFAULT CHARSET=utf8 COMMENT='支付记录表';

#
# TABLE STRUCTURE FOR: ms_paycard
#

DROP TABLE IF EXISTS ms_paycard;

CREATE TABLE `ms_paycard` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `card` varchar(20) DEFAULT '' COMMENT '卡号',
  `pass` varchar(10) DEFAULT '' COMMENT '卡密',
  `uid` int(10) unsigned DEFAULT '0' COMMENT '会员ID',
  `rmb` decimal(10,2) DEFAULT '0.00' COMMENT '金额',
  `usertime` int(10) unsigned DEFAULT '0' COMMENT '使用时间',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '生成时间',
  `cion` int(10) unsigned DEFAULT '0' COMMENT '金币',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='充值卡表';

#
# TABLE STRUCTURE FOR: ms_pl
#

DROP TABLE IF EXISTS ms_pl;

CREATE TABLE `ms_pl` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(64) DEFAULT '' COMMENT '会员名称',
  `uid` int(10) unsigned DEFAULT '0' COMMENT '会员ID',
  `content` text COMMENT '评论内容',
  `ip` varchar(18) DEFAULT '' COMMENT '评论IP',
  `did` int(10) unsigned DEFAULT '0' COMMENT '数据ID',
  `dir` varchar(64) DEFAULT '' COMMENT '所属板块',
  `cid` tinyint(2) DEFAULT '0' COMMENT '板块分支ID',
  `fid` int(10) unsigned DEFAULT '0' COMMENT '上级ID',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `cid` (`cid`),
  KEY `uid` (`uid`),
  KEY `did` (`did`),
  KEY `fid` (`fid`),
  KEY `pl_dir_did_id` (`dir`,`did`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='评论表';

#
# TABLE STRUCTURE FOR: ms_plugins
#

DROP TABLE IF EXISTS ms_plugins;

CREATE TABLE `ms_plugins` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT '' COMMENT '板块名称',
  `author` varchar(20) DEFAULT '' COMMENT '作者',
  `dir` varchar(30) DEFAULT '' COMMENT '目录',
  `version` varchar(10) DEFAULT '' COMMENT '版本号',
  `description` varchar(200) DEFAULT '' COMMENT '介绍',
  `sid` tinyint(1) DEFAULT '0' COMMENT '类型',
  `ak` text COMMENT 'ak',
  PRIMARY KEY (`id`),
  KEY `dir` (`dir`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COMMENT='板块表';

#
# TABLE STRUCTURE FOR: ms_session
#

DROP TABLE IF EXISTS ms_session;

CREATE TABLE `ms_session` (
  `sessionid` varchar(40) NOT NULL DEFAULT '0',
  `uid` int(10) unsigned DEFAULT '0' COMMENT '会员ID',
  `plub` varchar(18) DEFAULT '' COMMENT '分类ID',
  `data` text COMMENT 'session数据',
  `ip` varchar(15) DEFAULT '' COMMENT 'IP',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`sessionid`),
  KEY `uid` (`uid`),
  KEY `addtime` (`addtime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='session数据表';

#
# TABLE STRUCTURE FOR: ms_share
#

DROP TABLE IF EXISTS ms_share;

CREATE TABLE `ms_share` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) DEFAULT '' COMMENT '访问IP',
  `agent` varchar(255) DEFAULT '' COMMENT '访问客户端',
  `uid` int(10) unsigned DEFAULT '0' COMMENT '会员ID',
  `cion` int(10) unsigned DEFAULT '0' COMMENT '赠送金币',
  `jinyan` int(10) unsigned DEFAULT '0' COMMENT '赠送经验',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '访问时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='宣传记录表';

#
# TABLE STRUCTURE FOR: ms_spend
#

DROP TABLE IF EXISTS ms_spend;

CREATE TABLE `ms_spend` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dir` varchar(64) DEFAULT '' COMMENT '所属板块',
  `title` varchar(255) DEFAULT '' COMMENT '消费内容',
  `sid` tinyint(1) DEFAULT '0' COMMENT '分类ID',
  `uid` int(10) unsigned DEFAULT '0' COMMENT '会员ID',
  `nums` int(10) unsigned DEFAULT '0' COMMENT '数量',
  `ip` varchar(15) DEFAULT '' COMMENT 'IP',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `sid` (`sid`),
  KEY `dir` (`dir`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=utf8 COMMENT='消费记录表';

#
# TABLE STRUCTURE FOR: ms_tags
#

DROP TABLE IF EXISTS ms_tags;

CREATE TABLE `ms_tags` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT '' COMMENT '名称',
  `fid` int(8) unsigned DEFAULT '0' COMMENT '分类ID',
  `xid` int(3) unsigned DEFAULT '0' COMMENT '排序ID',
  `hits` int(10) unsigned DEFAULT '0' COMMENT '人气',
  PRIMARY KEY (`id`),
  KEY `fid` (`fid`),
  KEY `xid` (`xid`),
  KEY `hits` (`hits`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='全站TAGS标签表';

#
# TABLE STRUCTURE FOR: ms_tu
#

DROP TABLE IF EXISTS ms_tu;

CREATE TABLE `ms_tu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT '' COMMENT '名称',
  `bname` varchar(64) DEFAULT '' COMMENT '英文别名',
  `color` varchar(10) DEFAULT '' COMMENT '名称颜色',
  `tags` varchar(255) DEFAULT '' COMMENT 'TAGS标签',
  `pic` varchar(255) DEFAULT '' COMMENT '萎缩图',
  `pic2` varchar(255) DEFAULT '' COMMENT '幻灯图片',
  `cid` mediumint(5) DEFAULT '0' COMMENT '分类ID',
  `tid` mediumint(5) DEFAULT '0' COMMENT '专题ID',
  `reco` tinyint(1) DEFAULT '0' COMMENT '推荐星级',
  `yid` tinyint(1) DEFAULT '0' COMMENT '是否隐藏',
  `hid` tinyint(1) DEFAULT '0' COMMENT '是否回收站',
  `uid` int(10) unsigned DEFAULT '0' COMMENT '会员ID',
  `hits` int(10) unsigned DEFAULT '0' COMMENT '总人气',
  `yhits` int(10) unsigned DEFAULT '0' COMMENT '月人气',
  `zhits` int(10) unsigned DEFAULT '0' COMMENT '周人气',
  `rhits` int(10) unsigned DEFAULT '0' COMMENT '日人气',
  `dhits` int(10) unsigned DEFAULT '0' COMMENT '顶人气',
  `chits` int(10) unsigned DEFAULT '0' COMMENT '踩人气',
  `cion` mediumint(5) DEFAULT '0' COMMENT '阅读需要金币',
  `vip` mediumint(5) DEFAULT '0' COMMENT '可观看组',
  `level` mediumint(5) DEFAULT '0' COMMENT '可观看等级',
  `info` varchar(128) DEFAULT '' COMMENT '描述',
  `content` text COMMENT '新闻内容',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '增加时间',
  `skins` varchar(64) DEFAULT 'show.html' COMMENT '默认模板',
  `title` varchar(64) DEFAULT '' COMMENT 'SEO标题',
  `keywords` varchar(150) DEFAULT '' COMMENT 'SEO关键词',
  `description` varchar(200) DEFAULT '' COMMENT 'SEO介绍',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `cid` (`cid`),
  KEY `tid` (`tid`),
  KEY `hid` (`hid`),
  KEY `yid` (`yid`),
  KEY `reco` (`reco`),
  KEY `hits` (`hits`),
  KEY `yhits` (`yhits`),
  KEY `zhits` (`zhits`),
  KEY `rhits` (`rhits`),
  KEY `tu_hid_addtime` (`hid`,`addtime`),
  KEY `tu_cid_yid_hid_id` (`yid`,`hid`,`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1002 DEFAULT CHARSET=utf8 COMMENT='新闻表';

#
# TABLE STRUCTURE FOR: ms_tu_list
#

DROP TABLE IF EXISTS ms_tu_list;

CREATE TABLE `ms_tu_list` (
  `id` mediumint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT '' COMMENT '名称',
  `bname` varchar(30) DEFAULT '' COMMENT '英文别名',
  `fid` tinyint(3) DEFAULT '0' COMMENT '上级ID',
  `xid` tinyint(3) DEFAULT '0' COMMENT '排序ID',
  `yid` tinyint(1) DEFAULT '0' COMMENT '是否显示',
  `skins` varchar(64) DEFAULT 'list.html' COMMENT '默认模板',
  `title` varchar(64) DEFAULT '' COMMENT 'SEO标题',
  `keywords` varchar(150) DEFAULT '' COMMENT 'SEO关键词',
  `description` varchar(200) DEFAULT '' COMMENT 'SEO介绍',
  PRIMARY KEY (`id`),
  KEY `xid` (`xid`),
  KEY `yid` (`yid`),
  KEY `fid` (`fid`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='新闻分类表';

#
# TABLE STRUCTURE FOR: ms_tu_look
#

DROP TABLE IF EXISTS ms_tu_look;

CREATE TABLE `ms_tu_look` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT '' COMMENT '新闻名称',
  `cid` mediumint(5) unsigned DEFAULT '0' COMMENT '新闻分类ID',
  `did` varchar(128) DEFAULT '' COMMENT '新闻ID',
  `uid` int(10) unsigned DEFAULT '0' COMMENT '会员ID',
  `cion` int(10) DEFAULT '0' COMMENT '扣除金币',
  `ip` varchar(20) DEFAULT '' COMMENT '会员IP',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `cid` (`cid`),
  KEY `did` (`did`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='新闻收费阅读记录';

#
# TABLE STRUCTURE FOR: ms_tu_topic
#

DROP TABLE IF EXISTS ms_tu_topic;

CREATE TABLE `ms_tu_topic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT '' COMMENT '名称',
  `bname` varchar(20) DEFAULT '' COMMENT '别名',
  `pic` varchar(255) DEFAULT '' COMMENT '图片',
  `toppic` varchar(255) DEFAULT '' COMMENT '顶部图片',
  `tid` tinyint(1) DEFAULT '0' COMMENT '是否推荐',
  `yid` tinyint(1) DEFAULT '0' COMMENT '是否审核',
  `hits` int(10) unsigned DEFAULT '0' COMMENT '总人气',
  `yhits` int(10) unsigned DEFAULT '0' COMMENT '月人气',
  `zhits` int(10) unsigned DEFAULT '0' COMMENT '周人气',
  `rhits` int(10) unsigned DEFAULT '0' COMMENT '日人气',
  `neir` text COMMENT '介绍',
  `skins` varchar(64) DEFAULT 'topic.html' COMMENT '默认模板',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '时间',
  `title` varchar(64) DEFAULT '' COMMENT 'SEO标题',
  `keywords` varchar(150) DEFAULT '' COMMENT 'SEO关键词',
  `description` varchar(200) DEFAULT '' COMMENT 'SEO介绍',
  PRIMARY KEY (`id`),
  KEY `tid` (`tid`),
  KEY `yid` (`yid`),
  KEY `hits` (`hits`),
  KEY `yhits` (`yhits`),
  KEY `zhits` (`zhits`),
  KEY `rhits` (`rhits`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='新闻专题表';

#
# TABLE STRUCTURE FOR: ms_user
#

DROP TABLE IF EXISTS ms_user;

CREATE TABLE `ms_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT '' COMMENT '账号',
  `uid` bigint(20) DEFAULT '0' COMMENT 'UCID',
  `tid` tinyint(1) DEFAULT '0' COMMENT '是否推荐',
  `sid` tinyint(1) DEFAULT '0' COMMENT '是否锁定',
  `yid` tinyint(1) DEFAULT '0' COMMENT '是否激活',
  `zid` int(6) unsigned DEFAULT '1' COMMENT '会员组ID',
  `rzid` tinyint(1) DEFAULT '0' COMMENT '是否认证',
  `pass` varchar(32) DEFAULT '' COMMENT '密码',
  `code` varchar(6) DEFAULT '' COMMENT '密钥',
  `logip` varchar(20) DEFAULT '' COMMENT '登录IP',
  `lognum` smallint(5) unsigned DEFAULT '0' COMMENT '登录次数',
  `logtime` int(10) unsigned DEFAULT '0' COMMENT '登录时间',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '注册时间',
  `zutime` int(10) unsigned DEFAULT '0' COMMENT '会员组到期时间',
  `qq` varchar(50) DEFAULT '' COMMENT 'QQ',
  `tel` varchar(15) DEFAULT '' COMMENT '电话',
  `sex` tinyint(1) DEFAULT '0' COMMENT '性别',
  `city` varchar(30) DEFAULT '' COMMENT '地区',
  `email` varchar(50) DEFAULT '' COMMENT '邮箱',
  `logo` varchar(255) DEFAULT '' COMMENT '头像',
  `nichen` varchar(50) DEFAULT '' COMMENT '昵称',
  `cion` int(10) unsigned DEFAULT '0' COMMENT '金币',
  `rmb` decimal(10,2) DEFAULT '0.00' COMMENT '金钱',
  `vip` tinyint(1) unsigned DEFAULT '0' COMMENT '是否VIP',
  `viptime` int(10) unsigned DEFAULT '0' COMMENT 'VIP到期时间',
  `qianm` varchar(255) DEFAULT '' COMMENT '签名',
  `zx` tinyint(1) DEFAULT '0' COMMENT '在线状态',
  `logms` int(10) unsigned DEFAULT '0' COMMENT '最后操作时间',
  `qdts` smallint(5) unsigned DEFAULT '0' COMMENT '签到天数',
  `qdtime` int(10) unsigned DEFAULT '0' COMMENT '签到时间',
  `level` int(6) unsigned DEFAULT '0' COMMENT '等级',
  `jinyan` int(10) unsigned DEFAULT '0' COMMENT '经验',
  `hits` int(10) unsigned DEFAULT '0' COMMENT '空间人气',
  `yhits` int(10) unsigned DEFAULT '0' COMMENT '空间月人气',
  `zhits` int(10) unsigned DEFAULT '0' COMMENT '空间周人气',
  `rhits` int(10) unsigned DEFAULT '0' COMMENT '空间日人气',
  `zanhits` int(10) unsigned DEFAULT '0' COMMENT '被赞人气',
  `addhits` int(10) unsigned DEFAULT '0' COMMENT '发表数据次数',
  `regip` varchar(20) DEFAULT '' COMMENT '注册IP',
  `skins` varchar(128) DEFAULT '' COMMENT '模板路径',
  `bgpic` varchar(255) DEFAULT '' COMMENT '主页背景',
  `dlid` int(16) DEFAULT '0',
  `dlrz` int(11) NOT NULL,
  `zjcion` int(10) unsigned DEFAULT '0' COMMENT '代理总提成',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `tid` (`tid`),
  KEY `sid` (`sid`),
  KEY `yid` (`yid`),
  KEY `rzid` (`rzid`),
  KEY `sex` (`sex`),
  KEY `zx` (`zx`),
  KEY `hits` (`hits`),
  KEY `yhits` (`yhits`),
  KEY `zhits` (`zhits`),
  KEY `rhits` (`rhits`),
  KEY `addhits` (`addhits`),
  KEY `user_yid_id` (`yid`,`id`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 COMMENT='会员表';

#
# TABLE STRUCTURE FOR: ms_user_log
#

DROP TABLE IF EXISTS ms_user_log;

CREATE TABLE `ms_user_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned DEFAULT '0' COMMENT '会员ID',
  `loginip` varchar(50) DEFAULT '' COMMENT '登录IP',
  `logintime` int(10) unsigned DEFAULT '0' COMMENT '登录时间',
  `useragent` varchar(255) DEFAULT '' COMMENT '客户端信息',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=279 DEFAULT CHARSET=utf8 COMMENT='会员登录表';

#
# TABLE STRUCTURE FOR: ms_userlevel
#

DROP TABLE IF EXISTS ms_userlevel;

CREATE TABLE `ms_userlevel` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `xid` smallint(5) DEFAULT '0' COMMENT '排序ID',
  `name` varchar(100) DEFAULT '' COMMENT '名称',
  `stars` smallint(3) DEFAULT '0' COMMENT '星星数量',
  `jinyan` int(10) unsigned DEFAULT '0' COMMENT '所需经验',
  PRIMARY KEY (`id`),
  KEY `xid` (`xid`),
  KEY `stars` (`stars`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='会员等级表';

#
# TABLE STRUCTURE FOR: ms_useroauth
#

DROP TABLE IF EXISTS ms_useroauth;

CREATE TABLE `ms_useroauth` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cid` tinyint(2) DEFAULT '0' COMMENT '类型ID',
  `uid` int(10) unsigned DEFAULT '0' COMMENT '会员ID',
  `csid` int(10) unsigned DEFAULT '0' COMMENT 'cscms官方返回ID',
  `nickname` varchar(255) DEFAULT '' COMMENT '授权返回昵称',
  `avatar` varchar(255) DEFAULT '' COMMENT '授权返回头像地址',
  `oid` varchar(255) DEFAULT '' COMMENT '授权返回ID',
  `access_token` varchar(255) DEFAULT '' COMMENT '授权token',
  `refresh_token` varchar(255) DEFAULT '' COMMENT '授权刷新token',
  `expire_at` int(10) unsigned DEFAULT '0' COMMENT '授权到期时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `csid` (`csid`),
  KEY `cid` (`cid`),
  KEY `oid` (`oid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员OAuth2授权表';

#
# TABLE STRUCTURE FOR: ms_userzu
#

DROP TABLE IF EXISTS ms_userzu;

CREATE TABLE `ms_userzu` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT '' COMMENT '名称',
  `xid` smallint(5) DEFAULT '0' COMMENT '排序ID',
  `color` varchar(10) DEFAULT '' COMMENT '名称颜色',
  `pic` varchar(255) DEFAULT '' COMMENT '组图标',
  `info` varchar(255) DEFAULT '' COMMENT '介绍',
  `cion_y` int(10) unsigned DEFAULT '0' COMMENT '包年金币',
  `cion_m` int(10) unsigned DEFAULT '0' COMMENT '包月金币',
  `cion_d` int(10) unsigned DEFAULT '0' COMMENT '包天金币',
  `fid` tinyint(1) DEFAULT '0' COMMENT '上传附件权限',
  `aid` tinyint(1) DEFAULT '0' COMMENT '发表数据权限',
  `sid` tinyint(1) DEFAULT '0' COMMENT '发表数据审核',
  `vid` tinyint(1) DEFAULT '0' COMMENT '自助升级权限',
  `mid` tinyint(1) DEFAULT '0' COMMENT '发送私信权限',
  `did` tinyint(1) DEFAULT '0' COMMENT '下载免费权限',
  PRIMARY KEY (`id`),
  KEY `xid` (`xid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='会员组表';

#
# TABLE STRUCTURE FOR: ms_video
#

DROP TABLE IF EXISTS ms_video;

CREATE TABLE `ms_video` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT '' COMMENT '名称',
  `color` varchar(10) DEFAULT '' COMMENT '名称颜色',
  `tags` varchar(64) DEFAULT '' COMMENT 'TAGS标签',
  `pic` varchar(255) DEFAULT '' COMMENT '频视图片',
  `cid` mediumint(5) DEFAULT '0' COMMENT '分类ID',
  `tid` mediumint(5) DEFAULT '0' COMMENT '专辑ID',
  `fid` mediumint(5) DEFAULT '0' COMMENT '服务器组ID',
  `reco` tinyint(1) DEFAULT '0' COMMENT '推荐星级',
  `yid` tinyint(1) DEFAULT '0' COMMENT '是否隐藏',
  `hid` tinyint(1) DEFAULT '0' COMMENT '是否回收站',
  `singerid` int(10) unsigned DEFAULT '0' COMMENT '员演ID',
  `uid` int(10) unsigned DEFAULT '0' COMMENT '会员ID',
  `hits` int(10) unsigned DEFAULT '0' COMMENT '总人气',
  `shits` int(10) unsigned DEFAULT '0' COMMENT '收藏人气',
  `xhits` int(10) unsigned DEFAULT '0' COMMENT '下载人气',
  `yhits` int(10) unsigned DEFAULT '0' COMMENT '月人气',
  `zhits` int(10) unsigned DEFAULT '0' COMMENT '周人气',
  `rhits` int(10) unsigned DEFAULT '0' COMMENT '日人气',
  `dhits` int(10) unsigned DEFAULT '0' COMMENT '顶人气',
  `chits` int(10) unsigned DEFAULT '0' COMMENT '踩人气',
  `vip` tinyint(3) DEFAULT '0' COMMENT '会员组权限',
  `level` tinyint(3) DEFAULT '0' COMMENT '会员级别权限',
  `cion` mediumint(5) DEFAULT '0' COMMENT '看观需要金币',
  `bq` varchar(64) DEFAULT '' COMMENT '否是支持试看',
  `zq` varchar(64) DEFAULT '' COMMENT '视频上传方式',
  `zc` varchar(64) DEFAULT '' COMMENT '台词',
  `hy` varchar(64) DEFAULT '' COMMENT '混音',
  `dx` varchar(10) DEFAULT '' COMMENT '大小',
  `yz` varchar(10) DEFAULT '' COMMENT '音质',
  `sc` varchar(10) DEFAULT '' COMMENT '时长',
  `lrc` text COMMENT 'LRC歌词',
  `text` text COMMENT '介绍',
  `purl` varchar(255) DEFAULT '' COMMENT '播放地址',
  `durl` varchar(255) DEFAULT '' COMMENT '下载地址',
  `wpurl` varchar(255) DEFAULT '' COMMENT '网盘下载地址',
  `wppass` varchar(255) DEFAULT '' COMMENT '网盘下载密码',
  `skins` varchar(64) DEFAULT 'play.html' COMMENT '默认模板',
  `playtime` int(10) unsigned DEFAULT '0' COMMENT '播放时间',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '增加时间',
  `title` varchar(64) DEFAULT '' COMMENT 'SEO标题',
  `keywords` varchar(150) DEFAULT '' COMMENT 'SEO关键词',
  `description` varchar(200) DEFAULT '' COMMENT 'SEO介绍',
  `dcion` mediumint(5) DEFAULT '0' COMMENT '下载需要金币',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `cid` (`cid`),
  KEY `tid` (`tid`),
  KEY `hid` (`hid`),
  KEY `yid` (`yid`),
  KEY `reco` (`reco`),
  KEY `hits` (`hits`),
  KEY `yhits` (`yhits`),
  KEY `zhits` (`zhits`),
  KEY `rhits` (`rhits`),
  KEY `video_hid_addtime` (`hid`,`addtime`),
  KEY `video_cid_yid_hid_id` (`yid`,`hid`,`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2633 DEFAULT CHARSET=utf8 COMMENT='视频表';

#
# TABLE STRUCTURE FOR: ms_video_down
#

DROP TABLE IF EXISTS ms_video_down;

CREATE TABLE `ms_video_down` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT '' COMMENT '歌曲名称',
  `cid` mediumint(5) unsigned DEFAULT '0' COMMENT '歌曲分类ID',
  `did` int(10) unsigned DEFAULT '0' COMMENT '歌曲ID',
  `uid` int(10) unsigned DEFAULT '0' COMMENT '会员ID',
  `dcion` int(10) DEFAULT '0' COMMENT '扣除金币',
  `ip` varchar(20) DEFAULT '' COMMENT '下载IP',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `cid` (`cid`),
  KEY `did` (`did`),
  KEY `down_uid_addtime` (`uid`,`addtime`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='视频表下载记录';

#
# TABLE STRUCTURE FOR: ms_video_fav
#

DROP TABLE IF EXISTS ms_video_fav;

CREATE TABLE `ms_video_fav` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sid` tinyint(1) DEFAULT '1' COMMENT '类型1歌曲，2专辑',
  `name` varchar(64) DEFAULT '' COMMENT '歌曲名称',
  `cid` mediumint(5) unsigned DEFAULT '0' COMMENT '歌曲分类ID',
  `did` int(10) unsigned DEFAULT '0' COMMENT '歌曲ID',
  `uid` int(10) unsigned DEFAULT '0' COMMENT '会员ID',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `cid` (`cid`),
  KEY `did` (`did`),
  KEY `fav_uid_addtime` (`uid`,`addtime`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='视频表收藏记录';

#
# TABLE STRUCTURE FOR: ms_video_list
#

DROP TABLE IF EXISTS ms_video_list;

CREATE TABLE `ms_video_list` (
  `id` mediumint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT '' COMMENT '名称',
  `bname` varchar(30) DEFAULT '' COMMENT '别名',
  `fid` tinyint(3) DEFAULT '0' COMMENT '上级ID',
  `xid` tinyint(3) DEFAULT '0' COMMENT '排序ID',
  `yid` tinyint(1) DEFAULT '0' COMMENT '是否显示',
  `skins` varchar(64) DEFAULT 'list.html' COMMENT '默认模板',
  `title` varchar(64) DEFAULT '' COMMENT 'SEO标题',
  `keywords` varchar(150) DEFAULT '' COMMENT 'SEO关键词',
  `description` varchar(200) DEFAULT '' COMMENT 'SEO介绍',
  PRIMARY KEY (`id`),
  KEY `xid` (`xid`),
  KEY `yid` (`yid`),
  KEY `fid` (`fid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='视频表分类表';

#
# TABLE STRUCTURE FOR: ms_video_play
#

DROP TABLE IF EXISTS ms_video_play;

CREATE TABLE `ms_video_play` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT '' COMMENT '歌曲名称',
  `cid` mediumint(5) unsigned DEFAULT '0' COMMENT '歌曲分类ID',
  `did` int(10) unsigned DEFAULT '0' COMMENT '歌曲ID',
  `uid` int(10) unsigned DEFAULT '0' COMMENT '会员ID',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '时间',
  `cion` int(10) DEFAULT '0' COMMENT '扣除金币',
  `ip` varchar(20) DEFAULT '' COMMENT '观看IP',
  `sid` tinyint(1) DEFAULT '0' COMMENT '类型ID',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `cid` (`cid`),
  KEY `did` (`did`),
  KEY `play_uid_addtime` (`uid`,`addtime`)
) ENGINE=MyISAM AUTO_INCREMENT=112 DEFAULT CHARSET=utf8 COMMENT='视频表视听记录';

#
# TABLE STRUCTURE FOR: ms_video_server
#

DROP TABLE IF EXISTS ms_video_server;

CREATE TABLE `ms_video_server` (
  `id` mediumint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT '' COMMENT '名称',
  `purl` varchar(255) DEFAULT '' COMMENT '试听地址',
  `durl` varchar(255) DEFAULT '' COMMENT '下载地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='视频服务器组';

#
# TABLE STRUCTURE FOR: ms_video_topic
#

DROP TABLE IF EXISTS ms_video_topic;

CREATE TABLE `ms_video_topic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT '' COMMENT '名称',
  `color` varchar(10) DEFAULT '' COMMENT '名称颜色',
  `pic` varchar(255) DEFAULT '' COMMENT '图片',
  `tags` varchar(64) DEFAULT '' COMMENT 'TAGS标签',
  `singerid` int(10) DEFAULT '0' COMMENT '歌手ID',
  `tid` tinyint(1) DEFAULT '0' COMMENT '是否推荐',
  `cid` mediumint(5) unsigned DEFAULT '0' COMMENT '分类ID',
  `yid` tinyint(1) DEFAULT '1' COMMENT '是否审核',
  `uid` int(10) unsigned DEFAULT '0' COMMENT '会员ID',
  `hits` int(10) unsigned DEFAULT '0' COMMENT '总人气',
  `yhits` int(10) unsigned DEFAULT '0' COMMENT '月人气',
  `zhits` int(10) unsigned DEFAULT '0' COMMENT '周人气',
  `rhits` int(10) unsigned DEFAULT '0' COMMENT '日人气',
  `shits` int(10) unsigned DEFAULT '0' COMMENT '收藏人气',
  `neir` text COMMENT '介绍',
  `yuyan` varchar(10) DEFAULT '' COMMENT '语言',
  `diqu` varchar(10) DEFAULT '' COMMENT '地区',
  `fxgs` varchar(64) DEFAULT '' COMMENT '发行公司',
  `year` varchar(10) DEFAULT '' COMMENT '发行时间',
  `skins` varchar(64) DEFAULT 'topic-show.html' COMMENT '默认模板',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '时间',
  `title` varchar(64) DEFAULT '' COMMENT 'SEO标题',
  `keywords` varchar(150) DEFAULT '' COMMENT 'SEO关键词',
  `description` varchar(200) DEFAULT '' COMMENT 'SEO介绍',
  PRIMARY KEY (`id`),
  KEY `singerid` (`singerid`),
  KEY `uid` (`uid`),
  KEY `cid` (`cid`),
  KEY `tid` (`tid`),
  KEY `hits` (`hits`),
  KEY `yhits` (`yhits`),
  KEY `zhits` (`zhits`),
  KEY `rhits` (`rhits`),
  KEY `shits` (`shits`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='视频专辑表';

#
# TABLE STRUCTURE FOR: ms_web_pay
#

DROP TABLE IF EXISTS ms_web_pay;

CREATE TABLE `ms_web_pay` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mid` int(10) unsigned DEFAULT '0' COMMENT '模板唯一ID',
  `name` varchar(255) DEFAULT '' COMMENT '模板标题',
  `uid` int(10) unsigned DEFAULT '0' COMMENT '会员ID',
  `cion` int(10) unsigned DEFAULT '0' COMMENT '扣除金币',
  `addtime` int(10) unsigned DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='模板使用记录表';

