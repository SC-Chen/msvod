1.将程序上传至网站根目录下，还是老规矩，请勿删除根目录下的bbs.52jscn.com文件，谢谢兄弟们的支持和理解！

2.直接运行你的域名即可进入安装界面，傻瓜式安装，这里注意一点的是，填写管理员认证码的时候，自己一定要记住了；

3.用自己设置好的管理员信息进入后台，选择系统――系统维护――备份还原――还原数据库――将备份的msvod_v4_20170712还原即可：



4.还原后，登录账号和密码分别为admin和bbs.52jscn.com认证码则为你刚才安装的时候自己设置的，不变

5.重点来了，写到这基础的已经安装完了，剩下的就是改一下细节了，比如视频的试看时间，播放前的广告路径，等等，乞丐我也是找了好久，这个就在msvod\lib\Ms_Playconfig.php这个文件里，用EditPlus或者源代码编辑软件打开（不要用文本文档修改了，这个问题不想再重复了），里面有配置的相关信息自己看一下就OK了！# videocms