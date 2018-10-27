<?php
/**
* @Msvod v6 open source management system
* @copyright 2009-2016 msvod.cc. All rights reserved.
* @Author:Msvod 
* @Dtime:2016-09-20
*/
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* 手机短信类
*/
class Smstel {
function __construct ()
{
$this->appid   = MS_Sms_ID;  //商户ID
$this->appkey  = MS_Sms_Key;  //商户KEY
$this->curl    = 'http://http.yunsms.cn/mm/';
}
//发送
function add($tel,$neir){
$get='index?uid='.$this->appid;
$get.='&key='.$this->appkey;
$get.='&tel='.trim($tel);
$get.='&neir='.$neir.'【'.MS_Sms_Name.'】';
$url=$this->curl.$get;
$msg=htmlall($url);
$msg=$this->error($msg);
return $msg;
}
//发送注册验证码
function seadd($tel){
$tel_time=$_SESSION['tel_time'];
if($tel_time && $tel_time+60>time()){
return 'addok'; //发送时间没有过60秒
}
$code=random_string('nozero',4);
$_SESSION['tel_code']=$code;
$_SESSION['tel_time']=time();		   
$neir='欢迎注册'.Web_Name.'，您的验证码是'.$code.'，请尽快完成验证。(如非本人操作，可不予理会)【'.MS_Sms_Name.'】';
//即时发送
$res = $this->sendSMS($this->appid,$this->appkey,trim($tel),$neir);
if(trim($res)==100){
$data=1;
}else{
$data=trim($this->ererr($res));
}
return $data;
}
//查询余额
function balance(){
$get='?uid='.$this->appid;
$get.='&pwd='.strtolower(md5($this->appkey));
$url=$this->curl.$get;
$rmb=explode("||",htmlall($url));
if($rmb[0]==100){
$d=$rmb[1];
}else{
$d=$this->ererr($rmb[0]);
}
return $d;
}
function ererr($id){
if($id==100){
$d='1';
}elseif($id==101){
$d='验证失败（帐号密码错误）';
}elseif($id==102){
$d='短信不足';
}elseif($id==103){
$d='操作失败';
}elseif($id==104){
$d='非法字符';
}elseif($id==105){
$d='内容过多';
}elseif($id==106){
$d='号码过多';
}elseif($id==107){
$d='频率过快';
}elseif($id==108){
$d='号码内容为空';
}elseif($id==109){
$d='帐号异常';
}elseif($id==110){
$d='禁止频繁单条发送';
}elseif($id==111){
$d='帐号暂停发送';
}elseif($id==112){
$d='号码错误';
}elseif($id==113){
$d='定时时间格式不正确';
}elseif($id==114){
$d='帐号临时锁定，10分钟后自动解锁';
}elseif($id==115){
$d='连接失败';
}elseif($id==116){
$d='禁止接口发送';
}elseif($id==117){
$d='绑定IP错误';
}elseif($id==120){
$d='系统升级';
}
return $d;
}
function sendSMS($uid,$pwd,$mobile,$content,$time='',$mid='')
{
$http = 'http://http.yunsms.cn/tx/';
$data = array
(
'uid'=>$uid,					//数字用户名
'pwd'=>strtolower(md5($pwd)),	//MD5位32密码
'mobile'=>$mobile,				//号码
'content'=>$content,			//内容 如果对方是utf-8编码，则需转码iconv('gbk','utf-8',$content); 如果是gbk则无需转码
'time'=>$time,		//定时发送
'mid'=>$mid						//子扩展号
);
$re= $this->postSMS($http,$data);			//POST方式提交
return $re;
}
function postSMS($url,$data='')
{
$post='';
$row = parse_url($url);
$host = $row['host'];
$port = $row['port'] ? $row['port']:80;
$file = $row['path'];
while (list($k,$v) = each($data)) 
{
$post .= rawurlencode($k)."=".rawurlencode($v)."&";	//转URL标准码
}
$post = substr( $post , 0 , -1 );
$len = strlen($post);
$fp = @fsockopen( $host ,$port, $errno, $errstr, 10);
if (!$fp) {
return "$errstr ($errno)\n";
} else {
$receive = '';
$out = "POST $file HTTP/1.0\r\n";
$out .= "Host: $host\r\n";
$out .= "Content-type: application/x-www-form-urlencoded\r\n";
$out .= "Connection: Close\r\n";
$out .= "Content-Length: $len\r\n\r\n";
$out .= $post;		
fwrite($fp, $out);
while (!feof($fp)) {
$receive .= fgets($fp, 128);
}
fclose($fp);
$receive = explode("\r\n\r\n",$receive);
unset($receive[0]);
return implode("",$receive);
}
}
//错误提示
function error($msg){
if(empty($msg)){
return L('curl_err');
}
return $msg;
}
}
