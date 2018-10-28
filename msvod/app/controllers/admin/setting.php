<?php 
/**
* @Msvod v.6 open source management system
* @copyright 2008-2015 msvod.cc. All rights reserved.
* @Author:Msvod By 
* @Dtime:2016-9-01
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Setting extends msvod_Controller {

function __construct(){
parent::__construct();
$this->load->model('MsdjAdmin');
$this->MsdjAdmin->Admin_Login();
}

public function index()
{
//获取所有手机模板
$this->load->helper('directory');
$path=MSVOD.'tpl/mobile/';
$dir_arr=directory_map($path, 1);
$dirs=array();
if ($dir_arr) {
foreach ($dir_arr as $t) {
if (is_dir($path.$t)) {
$confiles=$path.$t.'/config.php';
if (file_exists($confiles)){
$config=require_once($confiles);
$dirs[] = array(
'name' => $config['name'],
'path' => $config['path'],
);
}
}
}
}
$data['mobile_skins'] = $dirs;
$this->load->view('setting.html',$data);
}

public function ftp()
{
$this->load->library('msup');
$data['up']=$this->msup->init();
$this->load->view('ftp_setting.html',$data);
}

public function tb()
{
$this->load->view('tb_setting.html');
}

public function denglu()
{
$this->load->view('denglu_setting.html');
}

public function save()
{
$Web_Name = $this->input->post('Web_Name', TRUE, TRUE);
//$Web_Url = $this->input->post('Web_Url', TRUE, TRUE);
$Web_Logo = $this->input->post('Web_Logo', TRUE, TRUE);
$Wap_Logo = $this->input->post('Wap_Logo', TRUE, TRUE);
$User_Logo = $this->input->post('User_Logo', TRUE, TRUE);
$Web_Path = $this->input->post('Web_Path', TRUE, TRUE);
$Admin_Code = $this->input->post('Admin_Code', TRUE, TRUE);
$Web_Off = intval($this->input->post('Web_Off', TRUE));
$Web_Onneir = $this->input->post('Web_Onneir', TRUE, TRUE);
$Web_Mode = intval($this->input->post('Web_Mode', TRUE));
$Web_Icp = $this->input->post('Web_Icp', TRUE, TRUE);
$Admin_QQ = $this->input->post('Admin_QQ', TRUE, TRUE);
$Admin_Tel = $this->input->post('Admin_Tel', TRUE, TRUE);
$Admin_Mail = $this->input->post('Admin_Mail', TRUE, TRUE);
$Web_Key = $this->input->post('Web_Key', TRUE, TRUE);
$Web_Count = $_POST['Web_Count'];
$Web_Title = $this->input->post('Web_Title', TRUE);
$Web_Keywords = $this->input->post('Web_Keywords', TRUE);
$Web_Description = $this->input->post('Web_Description', TRUE);
$Web_Notice = $this->input->post('Web_Notice', TRUE, TRUE);
$Pl_Modes = intval($this->input->post('Pl_Modes', TRUE));
$Pl_Youke = intval($this->input->post('Pl_Youke', TRUE));
$Pl_Num = intval($this->input->post('Pl_Num', TRUE));
$Pl_Yy_Name = $this->input->post('Pl_Yy_Name', TRUE);
$Pl_Ds_Name = $this->input->post('Pl_Ds_Name', TRUE);
$Pl_Cy_Id = $this->input->post('Pl_Cy_Id', TRUE, TRUE);
$Pl_Str = $this->input->post('Pl_Str', TRUE, TRUE);
$Cache_Is = intval($this->input->post('Cache_Is', TRUE));
$Cache_Time = intval($this->input->post('Cache_Time', TRUE));
$MS_Play_w = intval($this->input->post('MS_Play_w'));
$MS_Play_h = intval($this->input->post('MS_Play_h'));
$MS_Play_sw = intval($this->input->post('MS_Play_sw'));
$MS_Play_sh = intval($this->input->post('MS_Play_sh'));
$MS_Play_AdloadTime = intval($this->input->post('MS_Play_AdloadTime'));
$Html_Index = $this->input->post('Html_Index', TRUE, TRUE);
$Html_StopTime = intval($this->input->post('Html_StopTime', TRUE));
$Html_PageNum = intval($this->input->post('Html_PageNum', TRUE));
$MS_Language = $this->input->post('MS_Language', TRUE, TRUE);
$MS_Play_sk = intval($this->input->post('MS_Play_sk'));
$MS_Cache_Time = intval($this->input->post('MS_Cache_Time', TRUE));
$MS_Cache_Dir = $this->input->post('MS_Cache_Dir', TRUE, TRUE);
$MS_Cache_On = $this->input->post('MS_Cache_On', TRUE, TRUE);

$Mobile_Is = intval($this->input->post('Mobile_Is', TRUE));
$Mobile_Url = $this->input->post('Mobile_Url', TRUE, TRUE);
$Mobile_Win = intval($this->input->post('Mobile_Win', TRUE));
$Mobile_Skins = $this->input->post('Mobile_Skins', TRUE, TRUE);
$Web_Skins = $this->input->post('Web_Skins', TRUE, TRUE);

if($MS_Cache_Time==0)     $MS_Cache_Time=600;
if(empty($MS_Cache_Dir))  $MS_Cache_Dir="sql";
if($MS_Cache_On!="FALSE") $MS_Cache_On="TRUE";

if($Html_StopTime==0)      $Html_StopTime=1;
if($Html_PageNum==0)       $Html_PageNum=20;
if($Pl_Num==0)             $Pl_Num=10;
if($Cache_Time==0)         $Cache_Time=600;
if($MS_Play_w==0)          $MS_Play_w=445;
if($MS_Play_h==0)          $MS_Play_h=64;
if($MS_Play_sw==0)         $MS_Play_sw=600;
if($MS_Play_sh==0)         $MS_Play_sh=450;
if($MS_Play_AdloadTime==0) $MS_Play_AdloadTime=10;

//HTML转码
$Web_Onneir= str_encode($Web_Onneir); 
$Web_Title= str_encode($Web_Title); 
$Web_Keywords= str_encode($Web_Keywords); 
$Web_Description= str_encode($Web_Description); 
$Web_Notice=str_encode($Web_Notice); 
$Web_Count= str_encode($Web_Count); 


//判断主要数据不能为空
if (empty($Web_Name)||empty($Web_Path)||empty($Admin_Code)){
admin_msg(L('setting_err_01'),site_url('admin/setting'),'no');  //站点名称、域名、路径、认证码不能为空
}

//判断生成首页文件格式
$file_ext = strtolower(trim(substr(strrchr($Html_Index, '.'), 1)));
if($file_ext!='html' && $file_ext!='htm' && $file_ext!='shtm' && $file_ext!='shtml'){
admin_msg(L('setting_err_60'),site_url('admin/setting'),'no');  //静态文件格式不正确
}

//判断数据库缓存目录
if($MS_Cache_Dir!=MS_Cache_Dir){
if(file_exists(FCPATH.'cache/'.MS_Cache_Dir)){
if(!rename(FCPATH.'cache/'.MS_Cache_Dir,FCPATH.'cache/'.$MS_Cache_Dir)){
admin_msg(vsprintf(L('setting_err_02'),array('./cache/'.MS_Cache_Dir)),site_url('admin/setting'),'no');
}
}else{
@mkdir(FCPATH.'cache/'.$MS_Cache_Dir);
}
}

//修改数据库缓存配置
$this->load->helper('file');
$db_cof=read_file(FCPATH."msvod/lib/Ms_DB.php");
$db_cof=preg_replace("/'MS_Cache_On',(.*?)\)/","'MS_Cache_On',".$MS_Cache_On.")",$db_cof);
$db_cof=preg_replace("/'MS_Cache_Dir','(.*?)'/","'MS_Cache_Dir','".$MS_Cache_Dir."'",$db_cof);
$db_cof=preg_replace("/'MS_Cache_Time',(.*?)\)/","'MS_Cache_Time',".$MS_Cache_Time.")",$db_cof);
if(!write_file(FCPATH."msvod/lib/Ms_DB.php", $db_cof)){
admin_msg(vsprintf(L('setting_err_03'),array('./msvod/lib/Ms_DB.php')),site_url('admin/setting'),'no');
}

$strs="<?php"."\r\n";
$strs.="define('Web_Name','".$Web_Name."'); //站点名称  \r\n";
$strs.="define('Web_Url','".$Web_Url."'); //站点域名  \r\n";
$strs.="define('Web_Logo','".$Web_Logo."'); //PC站点LOGO  \r\n";
$strs.="define('Wap_Logo','".$Wap_Logo."'); //手机站点LOGO  \r\n";
$strs.="define('User_Logo','".$User_Logo."'); //会员中心LOGO  \r\n";
$strs.="define('Web_Path','".$Web_Path."'); //站点路径  \r\n";
$strs.="define('Admin_Code','".$Admin_Code."');  //后台验证码  \r\n";
$strs.="define('Web_Off',".$Web_Off.");  //网站开关  \r\n";
$strs.="define('Web_Onneir','".$Web_Onneir."');  //网站关闭内容  \r\n";
$strs.="define('Web_Mode',".$Web_Mode.");  //网站运行模式  \r\n";
$strs.="define('Html_Index','".$Html_Index."');  //主页静态URL  \r\n";
$strs.="define('Html_StopTime',".$Html_StopTime.");  //生成间隔秒数  \r\n";
$strs.="define('Html_PageNum',".$Html_PageNum.");  //每页生成数量  \r\n";

$strs.="define('Web_Icp','".$Web_Icp."');  //网站ICP  \r\n";
$strs.="define('Admin_QQ','".$Admin_QQ."');  //站长QQ  \r\n";
$strs.="define('Admin_Tel','".$Admin_Tel."');  //站长电话  \r\n";
$strs.="define('Admin_Mail','".$Admin_Mail."');  //站长EMAIL  \r\n";
$strs.="define('Web_Key','".$Web_Key."');  //热门搜索  \r\n";
$strs.="define('Web_Count','".$Web_Count."');  //统计代码  \r\n";
$strs.="define('Web_Title','".$Web_Title."'); //SEO-标题  \r\n";
$strs.="define('Web_Keywords','".$Web_Keywords."'); //SEO-Keywords  \r\n";
$strs.="define('Web_Description','".$Web_Description."'); //SEO-description  \r\n";
$strs.="define('Web_Notice','".$Web_Notice."');  //网站公告  \r\n";
$strs.="define('Pl_Modes',".$Pl_Modes.");  //评论方式  \r\n";
$strs.="define('Pl_Youke',".$Pl_Youke.");  //游客是否可以评论  \r\n";
$strs.="define('Pl_Num',".$Pl_Num.");  //评论每页条数  \r\n";
$strs.="define('Pl_Yy_Name','".$Pl_Yy_Name."');  //友言账号  \r\n";
$strs.="define('Pl_Ds_Name','".$Pl_Ds_Name."');  //多说账号  \r\n";
$strs.="define('Pl_Cy_Id','".$Pl_Cy_Id."');  //畅言APP_Id  \r\n";
$strs.="define('Pl_Str','".$Pl_Str."');  //评论过滤字符  \r\n";
$strs.="define('Cache_Is',".$Cache_Is.");  //缓存开关  \r\n";
$strs.="define('Cache_Time',".$Cache_Time.");  //缓存时间  \r\n";
$strs.="define('MS_Play_w',".$MS_Play_w.");    \r\n";
$strs.="define('MS_Play_h',".$MS_Play_h.");    \r\n";
$strs.="define('MS_Play_sw',".$MS_Play_sw.");    \r\n";
$strs.="define('MS_Play_sh',".$MS_Play_sh.");    \r\n";
$strs.="define('MS_Play_AdloadTime',".$MS_Play_AdloadTime."); //电影播放前广告时间    \r\n";
$strs.="define('MS_Language','".$MS_Language."'); //网站语言,english英文，zh_cn中文 \r\n";
$strs.="define('MS_Play_yk','".$MS_Play_sk."');  //试看 \r\n";
$strs.="define('Mobile_Is',".$Mobile_Is.");    //手机门户是否开启    \r\n";
$strs.="define('Mobile_Url','".$Mobile_Url."');  //手机门户域名    \r\n";
$strs.="define('Mobile_Win',".$Mobile_Win.");   //电脑是否可以访问手机页面    \r\n";
$strs.="define('Mobile_Skins','".$Mobile_Skins."');  //手机门户模板路径    \r\n";
$strs.="define('Web_Skins','".$Web_Skins."');  //默认主页模板路径    ";

//写文件
if (!write_file(MSVOD.'lib/Ms_Config.php', $strs)){
admin_msg(L('setting_err_03'),site_url('admin/setting'),'no');
}else{
admin_msg(L('setting_err_04'),site_url('admin/setting'));
}
}

public function ftp_save()
{
$UP_Mode = intval($this->input->post('UP_Mode', TRUE));
$UP_Size = intval($this->input->post('UP_Size', TRUE));
$UP_Type = $this->input->post('UP_Type', TRUE, TRUE);

$UP_Url = $this->input->post('UP_Url', TRUE, TRUE);
$UP_Pan = str_replace("\\","/",$this->input->post('UP_Pan', TRUE, TRUE));

$FTP_Url = $this->input->post('FTP_Url', TRUE, TRUE);
$FTP_Port = intval($this->input->post('FTP_Port', TRUE));
$FTP_Server = $this->input->post('FTP_Server', TRUE, TRUE);
$FTP_Dir = $this->input->post('FTP_Dir', TRUE, TRUE);
$FTP_Name = $this->input->post('FTP_Name', TRUE, TRUE);
$FTP_Pass = $this->input->post('FTP_Pass', TRUE);
$FTP_Ive = $this->input->post('FTP_Ive', TRUE, TRUE);

if($UP_Mode==0)   $UP_Mode=1;
if($UP_Size==0)   $UP_Size=1024;
if($FTP_Port==0)  $FTP_Port=21;
if($FTP_Pass==substr(FTP_Pass,0,3).'******'){
$FTP_Pass=FTP_Pass;
}

//判断主要数据不能为空
if ($UP_Mode==2 && (empty($FTP_Url)||empty($FTP_Server)||empty($FTP_Name)||empty($FTP_Pass))){
admin_msg(L('setting_72'),'javascript:history.back();','no');
}
if (!empty($UP_Pan) && empty($UP_Url)){
admin_msg(L('setting_73'),'javascript:history.back();','no');
}
if(empty($UP_Pan) || $UP_Url=='http://'.Web_Url.Web_Path){
$UP_Url='';
}

$strs="<?php"."\r\n";
$strs.="define('UP_Mode',".$UP_Mode.");      //会员上传附件方式  1站内，2FTP，3七牛，4快盘，5阿里云，..... \r\n";
$strs.="define('UP_Size',".$UP_Size.");      //上传支持的最大MB \r\n";
$strs.="define('UP_Type','".$UP_Type."');  //上传支持的格式 \r\n";
$strs.="define('UP_Url','".$UP_Url."');  //本地访问地址 \r\n";
$strs.="define('UP_Pan','".$UP_Pan."');  //本地存储路径 \r\n";

$strs.="define('FTP_Url','".$FTP_Url."');      //远程FTP连接地址     \r\n";
$strs.="define('FTP_Server','".$FTP_Server."');      //远程FTP服务器IP    \r\n";
$strs.="define('FTP_Dir','".$FTP_Dir."');      //远程FTP目录    \r\n";
$strs.="define('FTP_Port','".$FTP_Port."');      //远程FTP端口    \r\n";
$strs.="define('FTP_Name','".$FTP_Name."');      //远程FTP帐号    \r\n";
$strs.="define('FTP_Pass','".$FTP_Pass."');      //远程FTP密码    \r\n";
$strs.="define('FTP_Ive',".$FTP_Ive.");      //是否使用被动模式   ";

if($UP_Mode>2){ //其他上传修改配置
$this->load->library('msup');
$this->msup->edit($UP_Mode);
}

//写文件
if (!write_file(MSVOD.'lib/Ms_Ftp.php', $strs)){
admin_msg(vsprintf(L('setting_err_02'),array('msvod/lib/Ms_Ftp.php')),site_url('admin/setting/ftp'),'no');
}else{
admin_msg(L('setting_err_04'),site_url('admin/setting/ftp'));
}
}

public function tb_save()
{
$MS_WaterMark = intval($this->input->post('MS_WaterMark', TRUE));
$MS_WaterMode = intval($this->input->post('MS_WaterMode', TRUE));
$MS_WaterFontSize = intval($this->input->post('MS_WaterFontSize', TRUE));
$MS_WaterLocation = intval($this->input->post('MS_WaterLocation', TRUE));
$MS_WaterFont = $this->input->post('MS_WaterFont', TRUE, TRUE);
$MS_WaterFontColor = $this->input->post('MS_WaterFontColor', TRUE, TRUE);

$MS_WaterLogo = $this->input->post('MS_WaterLogo', TRUE, TRUE);
$MS_WaterLogotm = intval($this->input->post('MS_WaterLogotm', TRUE));
$MS_WaterLocations = $this->input->post('MS_WaterLocations', TRUE, TRUE);


if($MS_WaterLogotm>100)   $MS_WaterLogotm=100;
if($MS_WaterFontSize==0)  $MS_WaterFontSize=12;
if($MS_WaterLogotm==0)    $MS_WaterLogotm=90;
if($MS_WaterLocation==0)  $MS_WaterLocation=2;

$strs="<?php"."\r\n";
$strs.="define('MS_WaterMark',".$MS_WaterMark.");  //水印开关  \r\n";
$strs.="define('MS_WaterMode',".$MS_WaterMode.");  //水印类型  \r\n";
$strs.="define('MS_WaterFontSize',".$MS_WaterFontSize.");  //水印字体大小  \r\n";
$strs.="define('MS_WaterLocation',".$MS_WaterLocation.");  //水印位置  \r\n";
$strs.="define('MS_WaterFont','".$MS_WaterFont."');  //水印文字  \r\n";
$strs.="define('MS_WaterFontColor','".$MS_WaterFontColor."');  //水印颜色  \r\n";
$strs.="define('MS_WaterLogo','".$MS_WaterLogo."');  //水印图片路径  \r\n";
$strs.="define('MS_WaterLogotm','".$MS_WaterLogotm."');  //水印质量  \r\n";
$strs.="define('MS_WaterLocations','".$MS_WaterLocations."');  //LOGO图片坐标位置 \r\n";

//写文件
if (!write_file(MSVOD.'lib/Ms_Water.php', $strs)){
admin_msg(vsprintf(L('setting_err_02'),array('msvod/lib/Ms_Water.php')),site_url('admin/setting/tb'),'no');
}else{
admin_msg(L('setting_err_04'),site_url('admin/setting/tb'));
}
}

public function denglu_save()
{
$MS_Appmode = intval($this->input->post('MS_Appmode', TRUE));
$MS_Appid = $this->input->post('MS_Appid', TRUE, TRUE);
$MS_Appkey = $this->input->post('MS_Appkey', TRUE, TRUE);
$MS_Qqmode = intval($this->input->post('MS_Qqmode', TRUE));
$MS_Qqid = $this->input->post('MS_Qqid', TRUE, TRUE);
$MS_Qqkey = $this->input->post('MS_Qqkey', TRUE, TRUE);
$MS_Wbmode = intval($this->input->post('MS_Wbmode', TRUE));
$MS_Wbid = $this->input->post('MS_Wbid', TRUE, TRUE);
$MS_Wbkey = $this->input->post('MS_Wbkey', TRUE, TRUE);
$MS_Bdmode = intval($this->input->post('MS_Bdmode', TRUE));
$MS_Bdid = $this->input->post('MS_Bdid', TRUE, TRUE);
$MS_Bdkey = $this->input->post('MS_Bdkey', TRUE, TRUE);
$MS_Rrmode = intval($this->input->post('MS_Rrmode', TRUE));
$MS_Rrid = $this->input->post('MS_Rrid', TRUE, TRUE);
$MS_Rrkey = $this->input->post('MS_Rrkey', TRUE, TRUE);
$MS_Kxmode = intval($this->input->post('MS_Kxmode', TRUE));
$MS_Kxid = $this->input->post('MS_Kxid', TRUE, TRUE);
$MS_Kxkey = $this->input->post('MS_Kxkey', TRUE, TRUE);
$MS_Dbmode = intval($this->input->post('MS_Dbmode', TRUE));
$MS_Dbid = $this->input->post('MS_Dbid', TRUE, TRUE);
$MS_Dbkey = $this->input->post('MS_Dbkey', TRUE, TRUE);

$strs="<?php"."\r\n";
$strs.="define('MS_Appmode',".$MS_Appmode.");  //第三方登录方式，0为独立，1为官方 \r\n";
$strs.="define('MS_Appid','".$MS_Appid."');  //官方Appid \r\n";
$strs.="define('MS_Appkey','".$MS_Appkey."');  //官方Appkey \r\n\r\n";
$strs.="define('MS_Qqmode',".$MS_Qqmode.");  //QQ登陆开关 \r\n";
$strs.="define('MS_Qqid','".$MS_Qqid."');  //QQ登陆id \r\n";
$strs.="define('MS_Qqkey','".$MS_Qqkey."');  //QQ登陆key \r\n\r\n";
$strs.="define('MS_Wbmode',".$MS_Wbmode.");  //微博登陆开关  \r\n";
$strs.="define('MS_Wbid','".$MS_Wbid."');   //微博登陆id  \r\n";
$strs.="define('MS_Wbkey','".$MS_Wbkey."');  //微博登陆key  \r\n\r\n";
$strs.="define('MS_Bdmode',".$MS_Bdmode.");  //百度登陆开关  \r\n";
$strs.="define('MS_Bdid','".$MS_Bdid."');   //百度登陆id  \r\n";
$strs.="define('MS_Bdkey','".$MS_Bdkey."');  //百度登陆key  \r\n\r\n";
$strs.="define('MS_Rrmode',".$MS_Rrmode.");  //人人登陆开关  \r\n";
$strs.="define('MS_Rrid','".$MS_Rrid."');   //人人登陆id  \r\n";
$strs.="define('MS_Rrkey','".$MS_Rrkey."');  //人人登陆key  \r\n\r\n";
$strs.="define('MS_Kxmode',".$MS_Kxmode.");  //开心登陆开关  \r\n";
$strs.="define('MS_Kxid','".$MS_Kxid."');   //开心登陆id  \r\n";
$strs.="define('MS_Kxkey','".$MS_Kxkey."');  //开心登陆key  \r\n\r\n";
$strs.="define('MS_Dbmode',".$MS_Dbmode.");  //豆瓣登陆开关  \r\n";
$strs.="define('MS_Dbid','".$MS_Dbid."');   //豆瓣登陆id  \r\n";
$strs.="define('MS_Dbkey','".$MS_Dbkey."');  //豆瓣登陆key ";

//写文件
if (!write_file(MSVOD.'lib/Ms_Denglu.php', $strs)){
admin_msg(vsprintf(L('setting_err_02'),array('msvod/lib/Ms_Denglu.php')),site_url('admin/setting/denglu'),'no');
}else{
admin_msg(L('setting_err_04'),site_url('admin/setting/denglu'));
}
}
}

