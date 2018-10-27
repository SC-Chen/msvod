<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

return array(

//后台菜单部分	
'admin' => array(
array(
'name' => '视频管理',
'menu' => array(
array(
'name' => '视频管理',
'link' => 'admin/video'
),
array(
'name' => '视频分类',
'link' => 'admin/lists'
),
array(
'name' => '服务器组',
'link' => 'admin/server'
),
//array(
//'name' => '视频专题',
//'link' => 'admin/topic'
//),
//array(
//'name' => '视频扫描',
//'link' => 'admin/saomiao'
//),
array(
'name' => '播放记录',
'link' => 'admin/opt/play'
),
array(
'name' => '下载记录',
'link' => 'admin/opt/down'
),
array(
'name' => '收藏记录',
'link' => 'admin/opt/fav'
),
array(
'name' => '播放器设置',
'link' => '../admin/playsz'
),
array(
'name' => '随机批量点击',
'link' => 'admin/tools'
),
),
),
//array(
//'name' => '静态生成',
//'menu' => array(
//array(
//'name' => '生成版块首页',
//'link' => 'admin/html/index'
//),
//array(
//'name' => '生成分类页',
//'link' => 'admin/html/type'
//),
//array(
//'name' => '生成播放页',
//'link' => 'admin/html/play'
//),
//array(
//'name' => '生成下载页',
//'link' => 'admin/html/down'
//),
//array(
//'name' => '生成专题',
//'link' => 'admin/html/topic'
//),
//array(
//'name' => '生成自定义页',
//'link' => 'admin/html/opt'
//),
//),
//)
),

//会员中心菜单部分
'user' => array(
array(
'name' => '视频管理',
'menu' => array(
array(
'name' => '我的视频',
'link' => 'user/video',
),
array(
'name' => '上传视频',
'link' => 'user/video/add',
),
//array(
//'name' => '我的专题',
//'link' => 'user/album',
//)
)
),
),
);
