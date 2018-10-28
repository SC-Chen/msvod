<?php 
/**
* @Msvod v.6 open source management system
* @copyright 2008-2015 msvod.cc. All rights reserved.
* @Author:Msvod By 
* @Dtime:2016-9-01
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Playsz extends msvod_Controller {
function __construct(){
parent::__construct();
$this->load->model('MsdjAdmin');
$this->MsdjAdmin->Admin_Login();
}
public function index()
{
$this->load->view('playsz.html',$data);
}

public function save()
{
$MS_Sk_Sj = trim($this->input->post('MS_Sk_Sj', TRUE));
$MS_Sk_Ts = trim($this->input->post('MS_Sk_Ts', TRUE));
$MS_Sk_Info = trim($this->input->post('MS_Sk_Info', TRUE));
$MS_Ad_Tzurl = trim($this->input->post('MS_Ad_Tzurl', TRUE));
$MS_Ad_Time = trim($this->input->post('MS_Ad_Time', TRUE));
$MS_Ad_Qzad = trim($this->input->post('MS_Ad_Qzad', TRUE));
$MS_Ad_Ztad = trim($this->input->post('MS_Ad_Ztad', TRUE));
$MS_Ad_Qzurl = trim($this->input->post('MS_Ad_Qzurl', TRUE));
$MS_Ad_Zturl = trim($this->input->post('MS_Ad_Zturl', TRUE));
$MS_Ad_Tg = trim($this->input->post('MS_Ad_Tg', TRUE));
$MS_Ad_Gb = trim($this->input->post('MS_Ad_Gb', TRUE));
$MS_Yd_Zm = $this->input->post('MS_Yd_Zm', TRUE, TRUE);

$strs="<?php"."\r\n";
$strs.="define('MS_Sk_Sj','".$MS_Sk_Sj."');  //试看时间限制\r\n";
$strs.="define('MS_Sk_Ts','".$MS_Sk_Ts."');  //弹出提示时间\r\n";
$strs.="define('MS_Sk_Info','".$MS_Sk_Info."');  //弹出提示内容\r\n";
$strs.="define('MS_Ad_Tzurl','".$MS_Ad_Tzurl."');  //到时跳转链接\r\n";
$strs.="define('MS_Ad_Time','".$MS_Ad_Time."');  //前置广告时间\r\n";
$strs.="define('MS_Ad_Qzad','".$MS_Ad_Qzad."');  //前置广告设置\r\n";
$strs.="define('MS_Ad_Ztad','".$MS_Ad_Ztad."');  //暂停广告设置\r\n";
$strs.="define('MS_Ad_Qzurl','".$MS_Ad_Qzurl."');  //前置广告链接\r\n";
$strs.="define('MS_Ad_Zturl','".$MS_Ad_Zturl."');  //暂停广告链接\r\n";
$strs.="define('MS_Ad_Tg','".$MS_Ad_Tg."');  //游客以及普通用户跳过广告\r\n";
$strs.="define('MS_Ad_Gb','".$MS_Ad_Gb."');  //关闭播放器所有广告\r\n";
$strs.="define('MS_Yd_Zm','".$MS_Yd_Zm."');  // 设置云端与后台上传视频对接地址，没有授权云端的不用填\r\n";
//写文件
if (!write_file(MSVOD.'lib/Ms_Playconfig.php', $strs)){
admin_msg(L('setting_err_03'),site_url('admin/playsz'),'no');
}else{
admin_msg(L('setting_err_04'),site_url('admin/playsz'));
}
}
}
