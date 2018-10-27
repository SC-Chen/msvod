--
-- 数据库: 'msvod_v6'
--

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--msvod_admin<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}admin` (
  `id` smallint(5) NOT NULL auto_increment,
  `adminname` varchar(64) default '' COMMENT '账号',
  `adminpass` varchar(64) default '' COMMENT '密码',
  `admincode` varchar(6) default '' COMMENT '密钥',
  `logip` varchar(128) default '' COMMENT '最后登录IP',
  `lognums` int(10) default '0' COMMENT '登录次数',
  `logtime` int(10) default '0' COMMENT '最后登录时间',
  `card` varchar(255) default '' COMMENT '口令卡',
  `sid` smallint(3) unsigned default '0' COMMENT '角色id',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='管理员表';

--msvod_adminzu<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}adminzu` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(64) default '' COMMENT '角色名称',
  `sys` text COMMENT '默认权限',
  `app` text COMMENT '板块权限',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='管理员角色表';


--msvod_admin_log<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}admin_log` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `uid` smallint(5) unsigned default '0' COMMENT '用户ID',
  `loginip` varchar(50) default '' COMMENT '登录IP',
  `logintime` int(10) unsigned default '0' COMMENT '登录时间',
  `useragent` varchar(255) default '' COMMENT '客户端信息',
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='管理员登录表';


--msvod_ads<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}ads` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(64) default '' COMMENT '标签标示',
  `js` varchar(100) default '' COMMENT 'JS路径',
  `html` text COMMENT '标签代码',
  `neir` varchar(200) default '' COMMENT '标签介绍',
  `addtime` int(11) default '0' COMMENT '增加时间',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='自定义JS表';


--msvod_blog<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}blog` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `uid` int(10) unsigned default '0' COMMENT '会员ID',
  `hits` int(10) unsigned default '0' COMMENT '浏览次数',
  `phits` int(10) unsigned default '0' COMMENT '评论次数',
  `neir` text COMMENT '说说内容',
  `addtime` int(10) unsigned default '0' COMMENT '发表时间',
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`),
  KEY `pjits` (`phits`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='会员说说表';


--msvod_caiji<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}caiji` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(50) default '',
  `url` varchar(250) default '',
  `code` varchar(10) default '',
  `dir` varchar(64) default '',
  `zid` tinyint(1) default '0',
  `fid` smallint(5) default '0',
  `cfid` tinyint(1) default '0',
  `picid` tinyint(1) default '0',
  `dxid` tinyint(1) default '0',
  `rkid` tinyint(1) default '0',
  `htmlid` tinyint(1) default '0',
  `cjurl` text,
  `ksid` int(10) default '0',
  `jsid` int(10) default '0',
  `listks` text,
  `listjs` text,
  `picmode` tinyint(1) default '0',
  `picks` text,
  `picjs` text,
  `linkks` text,
  `linkjs` text,
  `nameks` text,
  `namejs` text,
  `strth` text,
  `addtime` int(10) unsigned default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='采集规则表';



--msvod_cjannex<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}cjannex` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(128) default '',
  `cid` int(10) unsigned default '0',
  `fid` tinyint(1) default '0',
  `htmlid` tinyint(1) default '0',
  `zd` varchar(128) default '',
  `ks` text,
  `js` text,
  `fname` varchar(64) default '',
  PRIMARY KEY  (`id`),
  KEY `cid` (`cid`),
  KEY `fid` (`fid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='采集新增规则表';


--msvod_cjdata<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}cjdata` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `dir` varchar(64) default '',
  `name` varchar(255) default '',
  `pic` varchar(255) default '',
  `zid` tinyint(1) default '0',
  `cfid` tinyint(1) default '0',
  `zdy` text,
  `addtime` int(10) unsigned default '0',
  PRIMARY KEY  (`id`),
  KEY `zid` (`zid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='采集数据表';



--msvod_cjlist<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}cjlist` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) default '',
  `dir` varchar(64) default '',
  `url` varchar(255) default '',
  `names` varchar(255) default '',
  `zid` tinyint(1) default '0',
  PRIMARY KEY  (`id`),
  KEY `zid` (`zid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='采集站点表';


--msvod_dt<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}dt` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `uid` int(10) unsigned default '0' COMMENT '会员ID',
  `dir` varchar(64) default '' COMMENT '版块标示',
  `yid` tinyint(1) default '0' COMMENT '是否显示',
  `title` varchar(255) default '' COMMENT '类型标题',
  `did` int(10) unsigned default '0' COMMENT '数据ID',
  `name` varchar(255) default '' COMMENT '数据标题',
  `link` varchar(255) default '' COMMENT '数据链接',
  `addtime` int(10) unsigned default '0' COMMENT '增加时间',
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`),
  KEY `yid` (`yid`),
  KEY `did` (`did`),
  KEY `dt_dir_id` (`dir`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='会员动态表';


--msvod_fans<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}fans` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `uida` int(10) unsigned default '0' COMMENT '会员ID',
  `uidb` int(10) unsigned default '0' COMMENT '粉丝ID',
  `addtime` int(10) unsigned default '0' COMMENT '时间',
  PRIMARY KEY  (`id`),
  KEY `fans_uida_id` (`uida`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='粉丝表';


--msvod_friend<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}friend` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `uida` int(10) unsigned default '0' COMMENT '会员ID',
  `uidb` int(10) unsigned default '0' COMMENT '好友ID',
  `addtime` int(10) unsigned default '0' COMMENT '时间',
  PRIMARY KEY  (`id`),
  KEY `friend_uida_id` (`uida`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='好友表';


--msvod_funco<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}funco` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `uida` int(10) unsigned default '0' COMMENT '会员ID',
  `uidb` int(10) unsigned default '0' COMMENT '访问者ID',
  `addtime` int(10) unsigned default '0' COMMENT '时间',
  PRIMARY KEY  (`id`),
  KEY `funco_uida_id` (`uida`,`id`),
  KEY `funco_uidb_id` (`uidb`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='访客表';


--msvod_gbook<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}gbook` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `cid` tinyint(1) default '0' COMMENT '类型ID',
  `fid` int(10) unsigned default '0' COMMENT '上级ID',
  `uida` int(10) unsigned default '0' COMMENT '会员ID',
  `uidb` int(10) unsigned default '0' COMMENT '留言者ID',
  `neir` text COMMENT '内容',
  `ip` varchar(20) default '' COMMENT 'IP',
  `addtime` int(10) unsigned default '0' COMMENT '时间',
  PRIMARY KEY  (`id`),
  KEY `fid` (`fid`),
  KEY `cid` (`cid`),
  KEY `gbook_uida_id` (`uida`,`id`),
  KEY `gbook_uidb_id` (`uidb`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='留言表';


--msvod_label<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}label` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(64) default '' COMMENT '唯一标示',
  `selflable` text COMMENT '标签内容',
  `neir` varchar(128) default '' COMMENT '标签介绍',
  `addtime` int(10) unsigned default '0' COMMENT '时间',
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='静态标签表';


--msvod_link<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}link` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(64) default '' COMMENT '名称',
  `url` varchar(255) default '' COMMENT '地址',
  `pic` varchar(255) default '' COMMENT 'LOGO',
  `cid` tinyint(1) default '1' COMMENT '类型',
  `sid` tinyint(1) default '1' COMMENT '主页是否显示',
  `xid` smallint(5) default '0' COMMENT '排序号',
  PRIMARY KEY  (`id`),
  KEY `cid` (`cid`),
  KEY `sid` (`sid`),
  KEY `xid` (`xid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='友情链接表';


--msvod_income<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}income` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `dir` varchar(64) default '' COMMENT '所属板块',
  `title` varchar(255) default '' COMMENT '收入内容',
  `sid` tinyint(1) default '0' COMMENT '分类ID',
  `uid` int(10) unsigned default '0' COMMENT '会员ID',
  `nums` int(10) unsigned default '0' COMMENT '数量',
  `ip` varchar(15) default '' COMMENT 'IP',
  `addtime` int(10) unsigned default '0' COMMENT '时间',
  PRIMARY KEY  (`id`),
  KEY `sid` (`sid`),
  KEY `uid` (`uid`),
  KEY `dir` (`dir`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='收入记录表';


--msvod_page<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}page` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `sid` tinyint(1) default '0' COMMENT '运行方式',
  `name` varchar(64) default '' COMMENT '唯一标示',
  `neir` varchar(128) default '' COMMENT '页面介绍',
  `url` varchar(100) default '' COMMENT '页面路径',
  `html` text COMMENT '页面被容',
  `addtime` int(10) unsigned default '0' COMMENT '时间',
  PRIMARY KEY  (`id`),
  KEY `sid` (`sid`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='自定义页面表';


--msvod_pay<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}pay` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `dingdan` varchar(64) default '' COMMENT '订单',
  `type` varchar(30) default '' COMMENT '支付方式',
  `uid` int(10) unsigned default '0' COMMENT '会员ID',
  `rmb` decimal(10,2) default '0' COMMENT '金额',
  `pid` tinyint(1) default '0' COMMENT '状态',
  `ip` varchar(15) default '' COMMENT 'IP',
  `addtime` int(10) unsigned default '0' COMMENT '时间',
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`),
  KEY `pid` (`pid`),
  KEY `dingdan` (`dingdan`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='支付记录表';


--msvod_paycard<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}paycard` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `card` varchar(20) default '' COMMENT '卡号',
  `pass` varchar(10) default '' COMMENT '卡密',
  `uid` int(10) unsigned default '0' COMMENT '会员ID',
  `rmb` decimal(10,2) default '0' COMMENT '金额',
  `usertime` int(10) unsigned default '0' COMMENT '使用时间',
  `addtime` int(10) unsigned default '0' COMMENT '生成时间',
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='充值卡表';


--msvod_plugins<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}plugins` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(100) default '' COMMENT '板块名称',
  `author` varchar(20) default '' COMMENT '作者',
  `dir` varchar(30) default '' COMMENT '目录',
  `version` varchar(10) default '' COMMENT '版本号',
  `description` varchar(200) default '' COMMENT '介绍',
  `sid` tinyint(1) default '0' COMMENT '类型',
  `ak` text COMMENT 'ak',
  PRIMARY KEY  (`id`),
  KEY `dir` (`dir`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='板块表';


--cs_pl<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}pl` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user` varchar(64) default '' COMMENT '会员名称',
  `uid` int(10) unsigned default '0' COMMENT '会员ID',
  `content` text COMMENT '评论内容',
  `ip` varchar(18) default '' COMMENT '评论IP',
  `did` int(10) unsigned default '0' COMMENT '数据ID',
  `dir` varchar(64) default '' COMMENT '所属板块',
  `cid` tinyint(2) default '0' COMMENT '板块分支ID',
  `fid` int(10) unsigned default '0' COMMENT '上级ID',
  `addtime` int(10) unsigned default '0' COMMENT '时间',
  PRIMARY KEY  (`id`),
  KEY `cid` (`cid`),
  KEY `uid` (`uid`),
  KEY `did` (`did`),
  KEY `fid` (`fid`),
  KEY `pl_dir_did_id` (`dir`,`did`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='评论表';


--msvod_session<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}session` (
  `sessionid` varchar(40) NOT NULL DEFAULT '0',
  `uid` int(10) unsigned default '0' COMMENT '会员ID',
  `plub` varchar(18) default '' COMMENT '分类ID',
  `data` text COMMENT 'session数据',
  `ip` varchar(15) default '' COMMENT 'IP',
  `addtime` int(10) unsigned default '0' COMMENT '时间',
  PRIMARY KEY  (`sessionid`),
  KEY `uid` (`uid`),
  KEY `addtime` (`addtime`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='session数据表';



--msvod_spend<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}spend` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `dir` varchar(64) default '' COMMENT '所属板块',
  `title` varchar(255) default '' COMMENT '消费内容',
  `sid` tinyint(1) default '0' COMMENT '分类ID',
  `uid` int(10) unsigned default '0' COMMENT '会员ID',
  `nums` int(10) unsigned default '0' COMMENT '数量',
  `ip` varchar(15) default '' COMMENT 'IP',
  `addtime` int(10) unsigned default '0' COMMENT '时间',
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`),
  KEY `sid` (`sid`),
  KEY `dir` (`dir`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='消费记录表';


--msvod_tags<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}tags` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(30) default '' COMMENT '名称',
  `fid` int(8) unsigned default '0' COMMENT '分类ID',
  `xid` int(3) unsigned default '0' COMMENT '排序ID',
  `hits` int(10) unsigned default '0' COMMENT '人气',
  PRIMARY KEY  (`id`),
  KEY `fid` (`fid`),
  KEY `xid` (`xid`),
  KEY `hits` (`hits`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='全站TAGS标签表';


--msvod_user<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}user` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(20) default '' COMMENT '账号',
  `uid` bigint(20) default '0' COMMENT 'UCID',
  `tid` tinyint(1) default '0' COMMENT '是否推荐',
  `sid` tinyint(1) default '0' COMMENT '是否锁定',
  `yid` tinyint(1) default '0' COMMENT '是否激活',
  `zid` int(6) unsigned default '1' COMMENT '会员组ID',
  `rzid` tinyint(1) default '0' COMMENT '是否认证',
  `pass` varchar(32) default '' COMMENT '密码',
  `code` varchar(6) default '' COMMENT '密钥',
  `logip` varchar(20) default '' COMMENT '登录IP',
  `lognum` smallint(5) unsigned default '0' COMMENT '登录次数',
  `logtime` int(10) unsigned default '0' COMMENT '登录时间',
  `addtime` int(10) unsigned default '0' COMMENT '注册时间',
  `zutime` int(10) unsigned default '0' COMMENT '会员组到期时间',
  `qq` varchar(50) default '' COMMENT 'QQ',
  `tel` varchar(15) default '' COMMENT '电话',
  `sex` tinyint(1) default '0' COMMENT '性别',
  `city` varchar(30) default '' COMMENT '地区',
  `email` varchar(50) default '' COMMENT '邮箱',
  `logo` varchar(255) default '' COMMENT '头像',
  `nichen` varchar(50) default '' COMMENT '昵称',
  `cion` int(10) unsigned default '0' COMMENT '金币',
  `rmb` decimal(10,2) default '0' COMMENT '金钱',
  `vip` tinyint(1) unsigned default '0' COMMENT '是否VIP',
  `viptime` int(10) unsigned default '0' COMMENT 'VIP到期时间',
  `qianm` varchar(255) default '' COMMENT '签名',
  `zx` tinyint(1) default '0' COMMENT '在线状态',
  `logms` int(10) unsigned default '0' COMMENT '最后操作时间',
  `qdts` smallint(5) unsigned default '0' COMMENT '签到天数',
  `qdtime` int(10) unsigned default '0' COMMENT '签到时间',
  `level` int(6) unsigned default '0' COMMENT '等级',
  `jinyan` int(10) unsigned default '0' COMMENT '经验',
  `hits` int(10) unsigned default '0' COMMENT '空间人气',
  `yhits` int(10) unsigned default '0' COMMENT '空间月人气',
  `zhits` int(10) unsigned default '0' COMMENT '空间周人气',
  `rhits` int(10) unsigned default '0' COMMENT '空间日人气',
  `zanhits` int(10) unsigned default '0' COMMENT '被赞人气',
  `addhits` int(10) unsigned default '0' COMMENT '发表数据次数',
  `regip` varchar(20) default '' COMMENT '注册IP',
  `skins` varchar(128) default '' COMMENT '模板路径',
  `bgpic` varchar(255) default '' COMMENT '主页背景',
  PRIMARY KEY  (`id`),
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
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='会员表';


--msvod_user_log<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}user_log` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `uid` int(10) unsigned default '0' COMMENT '会员ID',
  `loginip` varchar(50) default '' COMMENT '登录IP',
  `logintime` int(10) unsigned default '0' COMMENT '登录时间',
  `useragent` varchar(255) default '' COMMENT '客户端信息',
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='会员登录表';


--msvod_userzu<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}userzu` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(100) default '' COMMENT '名称',
  `xid` smallint(5) default '0' COMMENT '排序ID',
  `color` varchar(10) default '' COMMENT '名称颜色',
  `pic` varchar(255) default '' COMMENT '组图标',
  `info` varchar(255) default '' COMMENT '介绍',
  `cion_y`  int(10) unsigned default '0' COMMENT '包年金币',
  `cion_m`  int(10) unsigned default '0' COMMENT '包月金币',
  `cion_d`  int(10) unsigned default '0' COMMENT '包天金币',
  `fid` tinyint(1) default '0' COMMENT '上传附件权限',
  `aid` tinyint(1) default '0' COMMENT '发表数据权限',
  `sid` tinyint(1) default '0' COMMENT '发表数据审核',
  `vid` tinyint(1) default '0' COMMENT '自助升级权限',
  `mid` tinyint(1) default '0' COMMENT '发送私信权限',
  `did` tinyint(1) default '0' COMMENT '下载免费权限',
  PRIMARY KEY  (`id`),
  KEY `xid` (`xid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='会员组表';


--msvod_userlevel<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}userlevel` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `xid` smallint(5) default '0' COMMENT '排序ID',
  `name` varchar(100) default '' COMMENT '名称',
  `stars` smallint(3) default '0' COMMENT '星星数量',
  `jinyan` int(10) unsigned default '0' COMMENT '所需经验',
  PRIMARY KEY  (`id`),
  KEY `xid` (`xid`),
  KEY `stars` (`stars`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='会员等级表';


--msvod_useroauth<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}useroauth` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `cid` tinyint(2) default '0' COMMENT '类型ID',
  `uid` int(10) unsigned default '0' COMMENT '会员ID',
  `csid` int(10) unsigned default '0' COMMENT 'msvod官方返回ID',
  `nickname` varchar(255) default '' COMMENT '授权返回昵称',
  `avatar` varchar(255) default '' COMMENT '授权返回头像地址',
  `oid` varchar(255) default '' COMMENT '授权返回ID',
  `access_token` varchar(255) default '' COMMENT '授权token',
  `refresh_token` varchar(255) default '' COMMENT '授权刷新token',
  `expire_at` int(10) unsigned default '0' COMMENT '授权到期时间',
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`),
  KEY `csid` (`csid`),
  KEY `cid` (`cid`),
  KEY `oid` (`oid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='会员OAuth2授权表';


--msvod_msg<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}msg` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `did` tinyint(1) default '0' COMMENT '是否已读',
  `name` varchar(255) default '' COMMENT '标题',
  `neir` text COMMENT '内容',
  `uida` int(10) unsigned default '0' COMMENT '会员ID',
  `uidb` int(10) unsigned default '0' COMMENT '发送者ID',
  `addtime` int(10) unsigned default '0' COMMENT '时间',
  PRIMARY KEY  (`id`),
  KEY `did` (`did`),
  KEY `msg_uida_id` (`uida`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='会员消息表';


--msvod_web_pay<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}web_pay` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `mid` int(10) unsigned default '0' COMMENT '模板唯一ID',
  `name` varchar(255) default '' COMMENT '模板标题',
  `uid` int(10) unsigned default '0' COMMENT '会员ID',
  `cion` int(10) unsigned default '0' COMMENT '扣除金币',
  `addtime` int(10) unsigned default '0' COMMENT '时间',
  PRIMARY KEY  (`id`),
  KEY `mid` (`mid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='模板使用记录表';


--msvod_share<msvod>--

CREATE TABLE IF NOT EXISTS `{Prefix}share` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `ip` varchar(20) default '' COMMENT '访问IP',
  `agent` varchar(255) default '' COMMENT '访问客户端',
  `uid` int(10) unsigned default '0' COMMENT '会员ID',
  `cion` int(10) unsigned default '0' COMMENT '赠送金币',
  `jinyan` int(10) unsigned default '0' COMMENT '赠送经验',
  `addtime` int(10) unsigned default '0' COMMENT '访问时间',
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='宣传记录表';
