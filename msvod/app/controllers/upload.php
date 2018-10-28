<?php 
/**
* @Msvod v.6 open source management system
* @copyright 2008-2015 msvod.cc. All rights reserved.
* @Author:Msvod By 
* @Dtime:2014-09-20
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Upload extends msvod_Controller {

function __construct(){
parent::__construct();
$this->load->model('MsdjUser');
$this->load->helper('string');
}

//上传附件
public function index()
{
if(!$this->MsdjUser->User_Login(1)){
exit('No Login');
}
//检测会员组上传附件权限
$zuid=getzd('user','zid',$_SESSION['msvod__id']);
$rowu=$this->MsdjDB->get_row('userzu','fid',$zuid);
if($rowu->fid==0){
exit(L('up_01'));
}
$nums=intval($this->input->get('nums')); //支持数量
$types=$this->input->get('type',true);  //支持格式
$data['tsid']=$this->input->get('tsid',true); //返回提示ID
$data['sid']=intval($this->input->get('sid')); //返回输入框方法，0替换、1换行增加
$data['dir']=$this->input->get('dir',true);   //上传目录
$data['fid']=$this->input->get('fid',true);   //返回ID，一个页面多个返回可以用到
$data['upsave']=site_url('upload/up_save');
$data['size'] = UP_Size;
$data['types'] = (empty($types))?"*":$types;
$data['nums']=($nums==0)?1:$nums;
if($data['fid']=='undefined') $data['fid']='';
if($data['tsid']=='undefined') $data['tsid']='';
if($data['types']=='undefined') $data['types']='*';
if($data['dir']=='undefined') $data['dir']='other';
$str['fid']=$rowu->fid;
$str['id']=$_SESSION['msvod__id'];
$str['login']=$_SESSION['msvod__login'];
$data['key'] = sys_auth(addslashes(serialize($str)),'E');
$this->load->get_templates('common');
$this->load->view('upload.html',$data);
}

//保存附件
public function up_save()
{
$key=$this->input->post('key',true);
if(!$this->MsdjUser->User_Login(1,$key)){
exit('No Login');
}
//检测会员组上传附件权限
$key   = unserialize(stripslashes(sys_auth($key,'D')));
$fid   = isset($key['fid'])?intval($key['fid']):0;
if($fid==0){
exit('You do not have permission to upload attachments of group members!');
}
$dir=$this->input->post('dir',true);
if(empty($dir) || !preg_match('/^[0-9a-zA-Z\_]*$/', $dir)) {  
$dir='other';
}
//上传目录
if(UP_Mode==1 && UP_Pan!=''){
$path = UP_Pan.'/attachment/'.$dir.'/'.date('Ym').'/'.date('d').'/';
$path = str_replace("//","/",$path);
}else{
$path = FCPATH.'attachment/'.$dir.'/'.date('Ym').'/'.date('d').'/';
}
$tempFile = $_FILES['Filedata']['tmp_name'];
$file_name = $_FILES['Filedata']['name'];
$file_size = filesize($tempFile);
$file_ext = strtolower(trim(substr(strrchr($file_name, '.'), 1)));

//检查扩展名
$ext_arr = explode("|", UP_Type);
if (in_array($file_ext,$ext_arr) === false) {
exit(escape(L('up_02')));
}elseif($file_ext=='jpg' || $file_ext=='png' || $file_ext=='gif' || $file_ext=='bmp' || $file_ext=='jpge'){
list($width, $height, $type, $attr) = getimagesize($tempFile);
if ( intval($width) < 10 || intval($height) < 10 || $type == 4 ) {
exit(escape(L('up_03')));
}
}
//PHP上传失败
if (!empty($_FILES['Filedata']['error'])) {
switch($_FILES['Filedata']['error']){
case '1':
$error = L('up_04');
break;
case '2':
$error = L('up_05');
break;
case '3':
$error = L('up_06');
break;
case '4':
$error = L('up_07');
break;
case '6':
$error = L('up_08');
break;
case '7':
$error = L('up_09');
break;
case '8':
$error = 'File upload stopped by extension。';
break;
case '999':
default:
$error = L('up_10');
}
exit(escape($error));
}
//创建目录
if (!is_dir($path)) {
mkdirss($path);
}
//新文件名
$file_name=random_string('alnum', 20). '.' . $file_ext;
$file_path=$path.$file_name;
if (move_uploaded_file($tempFile, $file_path) !== false) { //上传成功

$filepath=(UP_Mode==1)?'/'.date('Ym').'/'.date('d').'/'.$file_name : '/'.date('Ymd').'/'.$file_name;

//判断水印
if($dir!='links' && MS_WaterMark==1){
if($file_ext=='jpg' || $file_ext=='png' || $file_ext=='gif' || $file_ext=='bmp' || $file_ext=='jpge'){
$this->load->library('watermark');
$this->watermark->imagewatermark($file_path);
}
}

//判断上传方式
$this->load->library('msup');
$res=$this->msup->up($file_path,$file_name);
if($res){
if(UP_Mode==1 && ($dir=='look' || $dir=='video')){
$filepath='/attachment/'.$dir.$filepath;
}
exit('ok=msvod='.$filepath);
}else{
@unlink($file_path);
exit('no');
}

}else{ //上传失败
exit('no');
}
}




//编辑器上传
public function editor()
{
$this->MsdjUser->User_Login();
//检测会员组上传附件权限
$zuid=getzd('user','zid',$_SESSION['msvod__id']);
$rowu=$this->MsdjDB->get_row('userzu','fid',$zuid);
if($rowu->fid==0){
$this->alert(L('up_01'));
}
$dir_name = $this->input->get('dir',true);
if(empty($dir_name) || !preg_match('/^[0-9a-zA-Z\_]*$/', $dir_name)) {  
$dir_name = 'image';
}
//文件保存目录路径
$save_path = './attachment/editor/';
//文件保存目录URL
$save_url = 'http://'.Web_Url.Web_Path.'/attachment/editor/';
//定义允许上传的文件扩展名
$ext_arr = array(
'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
'flash' => array('swf', 'flv'),
'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
);
//最大文件大小
$max_size = 10000000;
//PHP上传失败
if (!empty($_FILES['imgFile']['error'])) {
switch($_FILES['imgFile']['error']){
case '1':
$error = '超过php.ini允许的大小。';
break;
case '2':
$error = '超过表单允许的大小。';
break;
case '3':
$error = '图片只有部分被上传。';
break;
case '4':
$error = '请选择图片。';
break;
case '6':
$error = '找不到临时目录。';
break;
case '7':
$error = '写文件到硬盘出错。';
break;
case '8':
$error = 'File upload stopped by extension。';
break;
case '999':
default:
$error = '未知错误。';
}
$this->alert($error);
}
//有上传文件时
if (!empty($_FILES) === false) {
$this->alert("请选择文件。");
}
//原文件名
$file_name = $_FILES['imgFile']['name'];
//服务器上临时文件名
$tmp_name = $_FILES['imgFile']['tmp_name'];
//文件大小
$file_size = $_FILES['imgFile']['size'];
//检查文件名
if (!$file_name) {
$this->alert("请选择文件。");
}
//检查目录
if (@is_dir($save_path) === false) {
$this->alert("上传目录不存在。");
}
//检查目录写权限
if (@is_writable($save_path) === false) {
$this->alert("上传目录没有写权限。");
}
//检查是否已上传
if (@is_uploaded_file($tmp_name) === false) {
$this->alert("上传失败。");
}
//检查文件大小
if ($file_size > $max_size) {
$this->alert("上传文件大小超过限制。");
}
//检查目录名
$dir_name = empty($_GET['dir']) ? 'image' : trim($_GET['dir']);
if (empty($ext_arr[$dir_name])) {
$this->alert("目录名不正确。");
}
//检查图片文件是否正确
if($dir_name=='image'){
$aa=getimagesize($tmp_name);
$weight=$aa["0"];////获取图片的宽
$height=$aa["1"];///获取图片的高
if($weight<1 || $height<1){
@unlink($tmp_name);
$this->alert("图片内容不正确。");
}
}
//获得文件扩展名
$temp_arr = explode(".", $file_name);
$file_ext = array_pop($temp_arr);
$file_ext = trim($file_ext);
$file_ext = strtolower($file_ext);
//检查扩展名
if (in_array($file_ext, $ext_arr[$dir_name]) === false) {
$this->alert("上传文件扩展名是不允许的扩展名。\n只允许" . implode(",", $ext_arr[$dir_name]) . "格式。");
}
if($dir_name=='file'){
$dir_name='papers';
}
//创建文件夹
if ($dir_name !== '') {
$save_path .= $dir_name . "/";
$save_url .= $dir_name . "/";
if (!file_exists($save_path)) {
@mkdir($save_path);
}
}
$ymd = date("Ymd");
$save_path .= $ymd . "/";
$save_url .= $ymd . "/";
if (!file_exists($save_path)) {
@mkdir($save_path);
}
//新文件名
$new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
//移动文件
$file_path = $save_path . $new_file_name;
if (move_uploaded_file($tmp_name, $file_path) === false) {
$this->alert("上传文件失败。");
}
@chmod($file_path, 0644);
//判断水印
if(MS_WaterMark==1 && $dir_name=='image'){
$this->load->model('MsdjPic');
$this->MsdjPic->imageWaterMark($file_path);
}
$file_url = $save_url . $new_file_name;
echo json_encode(array('error' => 0, 'url' => $file_url));
}
public function alert($msg) {
echo json_encode(array('error' => 1, 'message' => $msg));
exit();
}
}
