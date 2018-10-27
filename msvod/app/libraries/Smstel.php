<?php
/**
* @Msvod v6 open source management system
* @copyright 2009-2016 msvod.cc. All rights reserved.
* @Author:Msvod 
* @Dtime:2016-09-20
*/
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* �ֻ�������
*/
class Smstel {
function __construct ()
{
$this->appid   = MS_Sms_ID;  //�̻�ID
$this->appkey  = MS_Sms_Key;  //�̻�KEY
$this->curl    = 'http://http.yunsms.cn/mm/';
}
//����
function add($tel,$neir){
$get='index?uid='.$this->appid;
$get.='&key='.$this->appkey;
$get.='&tel='.trim($tel);
$get.='&neir='.$neir.'��'.MS_Sms_Name.'��';
$url=$this->curl.$get;
$msg=htmlall($url);
$msg=$this->error($msg);
return $msg;
}
//����ע����֤��
function seadd($tel){
$tel_time=$_SESSION['tel_time'];
if($tel_time && $tel_time+60>time()){
return 'addok'; //����ʱ��û�й�60��
}
$code=random_string('nozero',4);
$_SESSION['tel_code']=$code;
$_SESSION['tel_time']=time();		   
$neir='��ӭע��'.Web_Name.'��������֤����'.$code.'���뾡�������֤��(��Ǳ��˲������ɲ������)��'.MS_Sms_Name.'��';
//��ʱ����
$res = $this->sendSMS($this->appid,$this->appkey,trim($tel),$neir);
if(trim($res)==100){
$data=1;
}else{
$data=trim($this->ererr($res));
}
return $data;
}
//��ѯ���
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
$d='��֤ʧ�ܣ��ʺ��������';
}elseif($id==102){
$d='���Ų���';
}elseif($id==103){
$d='����ʧ��';
}elseif($id==104){
$d='�Ƿ��ַ�';
}elseif($id==105){
$d='���ݹ���';
}elseif($id==106){
$d='�������';
}elseif($id==107){
$d='Ƶ�ʹ���';
}elseif($id==108){
$d='��������Ϊ��';
}elseif($id==109){
$d='�ʺ��쳣';
}elseif($id==110){
$d='��ֹƵ����������';
}elseif($id==111){
$d='�ʺ���ͣ����';
}elseif($id==112){
$d='�������';
}elseif($id==113){
$d='��ʱʱ���ʽ����ȷ';
}elseif($id==114){
$d='�ʺ���ʱ������10���Ӻ��Զ�����';
}elseif($id==115){
$d='����ʧ��';
}elseif($id==116){
$d='��ֹ�ӿڷ���';
}elseif($id==117){
$d='��IP����';
}elseif($id==120){
$d='ϵͳ����';
}
return $d;
}
function sendSMS($uid,$pwd,$mobile,$content,$time='',$mid='')
{
$http = 'http://http.yunsms.cn/tx/';
$data = array
(
'uid'=>$uid,					//�����û���
'pwd'=>strtolower(md5($pwd)),	//MD5λ32����
'mobile'=>$mobile,				//����
'content'=>$content,			//���� ����Է���utf-8���룬����ת��iconv('gbk','utf-8',$content); �����gbk������ת��
'time'=>$time,		//��ʱ����
'mid'=>$mid						//����չ��
);
$re= $this->postSMS($http,$data);			//POST��ʽ�ύ
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
$post .= rawurlencode($k)."=".rawurlencode($v)."&";	//תURL��׼��
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
//������ʾ
function error($msg){
if(empty($msg)){
return L('curl_err');
}
return $msg;
}
}
