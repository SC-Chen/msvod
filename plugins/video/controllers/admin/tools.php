<?php if ( ! defined('IS_ADMIN')) exit('No direct script access allowed');
/**
* @Msvod 4.x open source management system
* @copyright 2009-2014 msvod.cc. All rights reserved.
* @Author:Msvod QQ:
* @Dtime:2014-12-03
*/
class Tools extends Msvod_Controller {
function __construct(){
parent::__construct();
$this->load->helper('video');
$this->load->model('MsdjAdmin');
$this->MsdjAdmin->Admin_Login();
}
public function index()
{
$this->load->view('tools.html');
}
public function lists()
{
$cid   = intval($this->input->get_post('cid'));
$renqi = $this->input->get_post('renqi',true);
$day   = intval($this->input->get_post('day'));
$kshits   = intval($this->input->get_post('kshits'));
$jshits   = intval($this->input->get_post('jshits'));
$per_page   = intval($this->input->get_post('page'));
$pages   = intval($this->input->get_post('pages'));
if(empty($renqi)) exit();
if($per_page==0) $per_page=20;
if($pages==0) $pages=1;
$sql_string = "SELECT * FROM ".MS_SqlPrefix."video where 1=1 and hid=0";
if($cid>0){
$sql_string.= " and cid='".$cid."'";
}
if($day!=0){
$time=time()-$day*60*60*24;
$sql_string.= " and addtime>='".$time."'";
}
$sql_string.=" order by addtime desc";
$count_sql = str_replace('*','count(*) as count',$sql_string);
$query = $this->db->query($count_sql)->result_array();
$total = $query[0]['count'];
$totalPages = ceil($total / $per_page); // 总页数
if($total<$per_page){
$per_page=$total;
}
$sql_string.=' limit '. $per_page*($pages-1) .','. $per_page;
$data= $this->db->query($sql_string)->result();
if(empty($data)) exit('<br>=================当前没有记录!===================<br>');
echo "<table align='left' border='0'style='border-collapse:collapse;'><tr><td>&nbsp;正在随机人气第<font style='color:red; font-size:15px; font-style:italic'>".$pages."</font>页，共<font style='color:red; font-size:15px; font-style:italic'>".$totalPages."</font>页&nbsp;&nbsp;&nbsp;<a href='".site_url('video/admin/tools/lists')."'><font color=#0000ff>紧急停止</font></a></td></tr>" ;
foreach ($data as $row) { 
$hits=mt_rand($kshits,$jshits);
$this->db->query("update ".MS_SqlPrefix."video set ".$renqi."=".$hits." where id=".$row->id."");
echo "<tr><td>&nbsp;<font style=font-size:10pt;><font color=red>".$row->name."</font>的人气变为了<font color=red>".$hits."</font></font></td></tr>";
}
if($pages>=$totalPages){
die("<tr><td>&nbsp;<font style=color:red;font-size:10pt;><b>所有的随机人气完毕．．．．</b></font></td></tr></table>");
}else{	
die("<tr><td>&nbsp;<font style=font-size:10pt;>暂停5秒后继续随机人气 ．．．．</font><script language='javascript'>setTimeout('ReadGo();',".(5000).");function ReadGo(){location.href='".site_url('video/admin/tools/lists')."?pages=".($pages+1)."&page=".$per_page."&cid=".$cid."&renqi=".$renqi."&jshits=".$jshits."&day=".$day."&kshits=".$kshits."';}</script></td></tr></table>");
}
}
}
