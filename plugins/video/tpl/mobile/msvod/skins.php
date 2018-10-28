<?php
if (!defined('MSVODPATH')) exit('No permission resources');

return array(
           'index' => array(
                  'index.html' => '视频主页',
                  'list.html' => '视频列表页',
                  'play.html' => '视频播放页',
                  'down.html' => '视频下载页',
                  'play-lrc.html' => '带LRC播放页',
				  'search.html' => '视频搜索页',
                  'head.html' => '网站顶部',
                  'bottom.html' => '网站底部',
                  'pl.html' => '评论模板',
                  'ulogin.html' => '会员登陆前',
                  'uinfo.html' => '会员登录后',
                  'topic.html' => '专题列表页',
                  'topic-show.html' => '专题内容页',
           ),
           'user' => array(
                  'fav.html' => '视频收藏记录',
           ),
           'home' => array(
                  'album.html' => '专题列表',
                  'video.html' => '视频列表',
           )
);
