<?php
/**
* @Msvod v.6 open source management system
* @copyright 2008-2015 msvod.cc. All rights reserved.
* @Author:Msvod By 
* @Dtime:2014-10-31
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pay extends msvod_Controller {
function __construct(){
parent::__construct();
$this->load->model('MsdjAdmin');
$this->lang->load('admin_pay');
$this->MsdjAdmin->Admin_Login();
}
public function index()
{
$this->load->view('pay_setting.html');
}
public function save()
{
$MS_Alipay = intval($this->input->post('MS_Alipay', TRUE));
$MS_Alipay_JK = intval($this->input->post('MS_Alipay_JK', TRUE));
$MS_Alipay_ID = trim($this->input->post('MS_Alipay_ID', TRUE));
$MS_Alipay_Key = trim($this->input->post('MS_Alipay_Key', TRUE));
$MS_Alipay_Name = trim($this->input->post('MS_Alipay_Name', TRUE));
$MS_Tenpay = intval($this->input->post('MS_Tenpay', TRUE));
$MS_Tenpay_ID = trim($this->input->post('MS_Tenpay_ID', TRUE));
$MS_Tenpay_Key = trim($this->input->post('MS_Tenpay_Key', TRUE));
$MS_Wypay = intval($this->input->post('MS_Wypay', TRUE));
$MS_Wypay_ID = trim($this->input->post('MS_Wypay_ID', TRUE));
$MS_Wypay_Key = trim($this->input->post('MS_Wypay_Key', TRUE));
$MS_Kqpay = intval($this->input->post('MS_Kqpay', TRUE));
$MS_Kqpay_ID = trim($this->input->post('MS_Kqpay_ID', TRUE));
$MS_Kqpay_Key = trim($this->input->post('MS_Kqpay_Key', TRUE));
$MS_Ybpay = intval($this->input->post('MS_Ybpay', TRUE));
$MS_Ybpay_ID = trim($this->input->post('MS_Ybpay_ID', TRUE));
$MS_Ybpay_Key = trim($this->input->post('MS_Ybpay_Key', TRUE));
$MS_Mspay = intval($this->input->post('MS_Mspay', TRUE));
$MS_Mspay_ID = trim($this->input->post('MS_Mspay_ID', TRUE));
$MS_Mspay_Key = trim($this->input->post('MS_Mspay_Key', TRUE));
$strs="<?php"."\r\n";
$strs.="define('MS_Alipay',".$MS_Alipay.");  //支付宝开关  \r\n";
$strs.="define('MS_Alipay_JK',".$MS_Alipay_JK.");  //支付宝接口,1为双功能接口，2为及时倒账，3为手动接口\r\n";
$strs.="define('MS_Alipay_Name','".$MS_Alipay_Name."');  //支付宝帐号  \r\n";
$strs.="define('MS_Alipay_ID','".$MS_Alipay_ID."');  //合作者ID  \r\n";
$strs.="define('MS_Alipay_Key','".$MS_Alipay_Key."');  //安全验效码KEY  \r\n";
$strs.="define('MS_Tenpay',".$MS_Tenpay.");  //微信支付开关  \r\n";
$strs.="define('MS_Tenpay_ID','".$MS_Tenpay_ID."');  //微信支付ID  \r\n";
$strs.="define('MS_Tenpay_Key','".$MS_Tenpay_Key."');  //安全验效码KEY  \r\n";
$strs.="define('MS_Wypay',".$MS_Wypay.");  //网银开关  \r\n";
$strs.="define('MS_Wypay_ID','".$MS_Wypay_ID."');  //网银ID  \r\n";
$strs.="define('MS_Wypay_Key','".$MS_Wypay_Key."');  //安全验效码KEY  \r\n";
$strs.="define('MS_Kqpay',".$MS_Kqpay.");  //快钱  \r\n";
$strs.="define('MS_Kqpay_ID','".$MS_Kqpay_ID."');  //快钱ID  \r\n";
$strs.="define('MS_Kqpay_Key','".$MS_Kqpay_Key."');  //安全验效码KEY\r\n";
$strs.="define('MS_Ybpay',".$MS_Ybpay.");  //易宝支付  \r\n";
$strs.="define('MS_Ybpay_ID','".$MS_Ybpay_ID."');  //易宝ID  \r\n";
$strs.="define('MS_Ybpay_Key','".$MS_Ybpay_Key."');  //安全验效码KEY \r\n";
$strs.="define('MS_Mspay',".$MS_Mspay.");  //官方支付  \r\n";
$strs.="define('MS_Mspay_ID','".$MS_Mspay_ID."');  //官方ID  \r\n";
$strs.="define('MS_Mspay_Key','".$MS_Mspay_Key."');  //安全验效码KEY";
//写文件
if (!write_file(MSVOD.'lib/Ms_Pay.php', $strs)){
admin_msg(L('plub_01'),site_url('admin/pay'),'no');
}else{
admin_msg(L('plub_02'),site_url('admin/pay'));
}
}
//支付记录列表
public function lists()
{
$kstime = $this->input->get_post('kstime',true);
$jstime = $this->input->get_post('jstime',true);
$dingdan= str_replace('%','',$this->input->get_post('dingdan',true));
$pid  = intval($this->input->get_post('pid'));
$zd   = $this->input->get_post('zd',true);
$key  = $this->input->get_post('key',true);
$page = intval($this->input->get('page'));
if($page==0) $page=1;
$kstimes=empty($kstime)?0:strtotime($kstime)-86400;
$jstimes=empty($jstime)?0:strtotime($jstime)+86400;
if($kstimes>$jstimes) $kstimes=strtotime($kstime);
$data['page'] = $page;
$data['dingdan'] = $dingdan;
$data['pid'] = $pid;
$data['zd'] = $zd;
$data['key'] = $key;
$data['kstime'] = $kstime;
$data['jstime'] = empty($jstime)?date('Y-m-d'):$jstime;
$sql_string = "SELECT * FROM ".MS_SqlPrefix."pay where 1=1";
if($pid>0){
$sql_string.= " and pid=".($pid-1)."";
}
if(!empty($dingdan)){
$sql_string.= " and dingdan like '%".$dingdan."%'";
}
if(!empty($key)){
if($zd=='name'){
$uid=$this->MsdjDB->getzd('user','id',$key,'name');
}else{
$uid=$key;
}
$sql_string.= " and uid=".intval($uid)."";
}
if($kstimes>0){
$sql_string.= " and addtime>".$kstimes."";
}
if($jstimes>0){
$sql_string.= " and addtime<".$jstimes."";
}
$sql_string.= " order by addtime desc";
$count_sql = str_replace('*','count(*) as count',$sql_string);
$query = $this->db->query($count_sql)->result_array();
$total = $query[0]['count'];
$base_url = site_url('admin/pay/lists')."?dingdan=".$dingdan."&zd=".$zd."&kstime=".$kstime."&jstime=".$jstime."&key=".$key."&pid=".$pid;
$per_page = 15; 
$totalPages = ceil($total / $per_page); // 总页数
$data['nums'] = $total;
if($total<$per_page){
$per_page=$total;
}
$sql_string.=' limit '. $per_page*($page-1) .','. $per_page;
$query = $this->db->query($sql_string);
$data['pay'] = $query->result();
$data['pages'] = get_admin_page($base_url,$totalPages,$page,10); //获取分页类
$this->load->view('pay_list.html',$data);
}
//强制更新订单到成功
public function init()
{
$id = intval($this->input->get('id'));
$row=$this->db->query("SELECT * FROM ".MS_SqlPrefix."pay where id=".$id."")->row();
if($row){
$edit['pid']=1;
$this->MsdjDB->get_update('pay',$id,$edit);
//给会员增加金钱
$this->db->query("update ".MS_SqlPrefix."user set cion=cion+".$row->cion." where id=".$row->uid."");
//发送邮件
$email=$this->MsdjDB->getzd('user','email',$row->uid);
$this->load->model('MsdjEmail');
$title=L('plub_03');
$emailneir=vsprintf(L('plub_04'),array($row->cion));
$this->MsdjEmail->send($email,$title,$emailneir);  //发送通知邮件
}
admin_msg(L('plub_05'),'javascript:history.back();');
}
//支付订单删除
public function del()
{
$id = $this->input->get_post('id',true);
if(empty($id)) admin_msg(L('plub_06'),'javascript:history.back();','no');  //数据不完成
$this->MsdjDB->get_del('pay',$id);
admin_msg(L('plub_05'),site_url('admin/pay/lists'),'ok');  //操作成功
}
//消费记录列表
public function spend()
{
$kstime = $this->input->get_post('kstime',true);
$jstime = $this->input->get_post('jstime',true);
$sid  = intval($this->input->get_post('sid'));
$dir  = $this->input->get_post('dir',true);
$zd   = $this->input->get_post('zd',true);
$key  = $this->input->get_post('key',true);
$page = intval($this->input->get('page'));
if($page==0) $page=1;
$kstimes=empty($kstime)?0:strtotime($kstime)-86400;
$jstimes=empty($jstime)?0:strtotime($jstime)+86400;
if($kstimes>$jstimes) $kstimes=strtotime($kstime);
$data['page'] = $page;
$data['dir'] = $dir;
$data['sid'] = $sid;
$data['zd'] = $zd;
$data['key'] = $key;
$data['kstime'] = $kstime;
$data['jstime'] = empty($jstime)?date('Y-m-d'):$jstime;
$sql_string = "SELECT * FROM ".MS_SqlPrefix."spend where 1=1";
if($sid>0){
$sql_string.= " and sid=".($sid-1)."";
}
if(!empty($key)){
if($zd=='name'){
$uid=$this->MsdjDB->getzd('user','id',$key,'name');
}else{
$uid=$key;
}
$sql_string.= " and uid=".intval($uid)."";
}
if(!empty($dir)){
$sql_string.= " and dir='".$dir."'";
}
if($kstimes>0){
$sql_string.= " and addtime>".$kstimes."";
}
if($jstimes>0){
$sql_string.= " and addtime<".$jstimes."";
}
$sql_string.= " order by addtime desc";
$count_sql = str_replace('*','count(*) as count',$sql_string);
$query = $this->db->query($count_sql)->result_array();
$total = $query[0]['count'];
$base_url = site_url('admin/pay/spend')."?dir=".$dir."&zd=".$zd."&kstime=".$kstime."&jstime=".$jstime."&key=".$key."&sid=".$sid;
$per_page = 15; 
$totalPages = ceil($total / $per_page); // 总页数
$data['nums'] = $total;
if($total<$per_page){
$per_page=$total;
}
$sql_string.=' limit '. $per_page*($page-1) .','. $per_page;
$query = $this->db->query($sql_string);
$data['spend'] = $query->result();
$data['pages'] = get_admin_page($base_url,$totalPages,$page,10); //获取分页类
$this->load->view('pay_spend.html',$data);
}
//消费记录删除
public function spend_del()
{
$id = $this->input->get_post('id',true);
if(empty($id)) admin_msg(L('plub_06'),'javascript:history.back();','no');  //数据不完成
$this->MsdjDB->get_del('spend',$id);
admin_msg(L('plub_05'),site_url('admin/pay/spend'),'ok');  //操作成功
}
//分成记录列表
public function income()
{
$kstime = $this->input->get_post('kstime',true);
$jstime = $this->input->get_post('jstime',true);
$dir  = $this->input->get_post('dir',true);
$sid  = intval($this->input->get_post('sid'));
$zd   = $this->input->get_post('zd',true);
$key  = $this->input->get_post('key',true);
$page = intval($this->input->get('page'));
if($page==0) $page=1;
$kstimes=empty($kstime)?0:strtotime($kstime)-86400;
$jstimes=empty($jstime)?0:strtotime($jstime)+86400;
if($kstimes>$jstimes) $kstimes=strtotime($kstime);
$data['page'] = $page;
$data['dir'] = $dir;
$data['sid'] = $sid;
$data['zd'] = $zd;
$data['key'] = $key;
$data['kstime'] = $kstime;
$data['jstime'] = empty($jstime)?date('Y-m-d'):$jstime;
$sql_string = "SELECT * FROM ".MS_SqlPrefix."income where 1=1";
if($sid>0){
$sql_string.= " and sid=".($sid-1)."";
}
if(!empty($key)){
if($zd=='name'){
$uid=$this->MsdjDB->getzd('user','id',$key,'name');
}else{
$uid=$key;
}
$sql_string.= " and uid=".intval($uid)."";
}
if(!empty($dir)){
$sql_string.= " and dir='".$dir."'";
}
if($kstimes>0){
$sql_string.= " and addtime>".$kstimes."";
}
if($jstimes>0){
$sql_string.= " and addtime<".$jstimes."";
}
$sql_string.= " order by addtime desc";
$count_sql = str_replace('*','count(*) as count',$sql_string);
$query = $this->db->query($count_sql)->result_array();
$total = $query[0]['count'];
$base_url = site_url('admin/pay/income')."?dir=".$dir."&zd=".$zd."&kstime=".$kstime."&jstime=".$jstime."&key=".$key."&sid=".$sid;
$per_page = 15; 
$totalPages = ceil($total / $per_page); // 总页数
$data['nums'] = $total;
if($total<$per_page){
$per_page=$total;
}
$sql_string.=' limit '. $per_page*($page-1) .','. $per_page;
$query = $this->db->query($sql_string);
$data['income'] = $query->result();
$data['pages'] = get_admin_page($base_url,$totalPages,$page,10); //获取分页类
$this->load->view('pay_income.html',$data);
}
//分成记录删除
public function income_del()
{
$id = $this->input->get_post('id',true);
if(empty($id)) admin_msg(L('plub_06'),'javascript:history.back();','no');  //数据不完成
$this->MsdjDB->get_del('income',$id);
admin_msg(L('plub_05'),site_url('admin/pay/income'),'ok');  //操作成功
}
//充值卡列表
public function card()
{
$card = str_replace('%','',$this->input->get_post('card',true));
$sid  = intval($this->input->get_post('sid'));
$zd   = $this->input->get_post('zd',true);
$key  = $this->input->get_post('key',true);
$page = intval($this->input->get('page'));
if($page==0) $page=1;
$data['page'] = $page;
$data['sid'] = $sid;
$data['zd'] = $zd;
$data['key'] = $key;
$data['card'] = $card;
$sql_string = "SELECT * FROM ".MS_SqlPrefix."paycard where 1=1";
if(!empty($card)){
$sql_string.= " and card like '%".$card."%'";
}
if($sid==1){
$sql_string.= " and uid>0";
}
if($sid==2){
$sql_string.= " and uid=0";
}
if(!empty($key)){
if($zd=='name'){
$uid=$this->MsdjDB->getzd('user','id',$key,'name');
}else{
$uid=$key;
}
$sql_string.= " and uid=".intval($uid)."";
}
$sql_string.= " order by addtime desc";
$count_sql = str_replace('*','count(*) as count',$sql_string);
$query = $this->db->query($count_sql)->result_array();
$total = $query[0]['count'];
$base_url = site_url('admin/pay/card')."?zd=".$zd."&card=".$card."&key=".$key."&sid=".$sid;
$per_page = 15; 
$totalPages = ceil($total / $per_page); // 总页数
$data['nums'] = $total;
if($total<$per_page){
$per_page=$total;
}
$sql_string.=' limit '. $per_page*($page-1) .','. $per_page;
$query = $this->db->query($sql_string);
$data['paycard'] = $query->result();
$data['pages'] = get_admin_page($base_url,$totalPages,$page,10); //获取分页类
$this->load->view('pay_card.html',$data);
}
//新增充值卡
public function card_add()
{
$this->load->view('pay_card_add.html');
}
//生成充值卡
public function card_save()
{
$this->load->helper('string');
$cion = intval($this->input->post('cion'));
$nums = intval($this->input->post('nums'));
for($j=0;$j<$nums;$j++){	
$add['cion']=$cion;
$add['card']=date('Ymd').random_string('alnum',10);
$add['pass']=random_string('alnum',6);
$add['addtime']=time();
$this->MsdjDB->get_insert('paycard',$add);
}
admin_msg(L('plub_05'),site_url('admin/pay/card'),'ok');  //操作成功
}
//删除充值卡
public function card_del()
{
$id = $this->input->get_post('id',true);
if(empty($id)) admin_msg(L('plub_06'),'javascript:history.back();','no');  //数据不完成
$this->MsdjDB->get_del('paycard',$id);
admin_msg(L('plub_05'),site_url('admin/pay/card'),'ok');  //操作成功
}
}
