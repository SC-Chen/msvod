<?php 
/**
* @Msvod v.6 open source management system
* @copyright 2009-2016 msvod.cc. All rights reserved.
* @Author:Msvod By 
* @Dtime:2015-04-10
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Weixin extends msvod_Controller {

function __construct(){
parent::__construct();
$this->load->model('MsdjUser');
$this->lang->load('pay');
}

//请求支付
public function index()
{
$this->MsdjUser->User_Login();
$id=(int)$this->uri->segment(4); //订单ID
if($id==0)  msg_url(L('pay_01'),spacelink('pay'));
$row=$this->MsdjDB->get_row('pay','*',$id);
if(!$row || $row->uid!=$_SESSION['msvod__id']){
msg_url(L('pay_02'),spacelink('pay'));
}
$v_amount    = $row->rmb;
$v_moneytype = 'CNY';
$v_oid       = $row->dingdan;
$v_mid       = MS_Tenpay_ID;
$v_url       = site_url('pay/weixin/return_url');
$v_url2      = "[url:=".site_url('pay/weixin/notify_url')."]";
$key         = MS_Tenpay_Key;
$text        = $v_amount.$v_moneytype.$v_oid.$v_mid.$v_url.$key;
$md5info     = strtoupper(md5($text));
echo '
<form method="post" id="form1" name="form1" action="/index.php/user/weixin">
<input type="hidden" name="v_mid" value="'.$v_mid.'">
<input type="hidden" name="v_oid" value="'.$v_oid.'">
<input type="hidden" name="v_amount" value="'.$v_amount.'">
<input type="hidden" name="v_moneytype" value="'.$v_moneytype.'">
<input type="hidden" name="v_url" value="'.$v_url.'">
<input type="hidden" name="remark2" value="'.$v_url2.'">
<input type="hidden" name="v_md5info" value="'.$md5info.'">
</form><script language="javascript">document.form1.submit();</script>';
}

//同步返回
public function return_url()
{
$this->MsdjUser->User_Login();
$v_oid=$this->input->get('v_oid', TRUE,TRUE);      
$v_pstatus=$this->input->get('v_pstatus', TRUE,TRUE);    
$v_pstring=$this->input->get('v_pstring', TRUE,TRUE);   
$v_amount=$this->input->get('v_amount', TRUE,TRUE);  
$v_moneytype=$this->input->get('v_moneytype', TRUE,TRUE);   
$v_md5str=$this->input->get('v_md5str', TRUE,TRUE); 
$key = MS_Tenpay_Key;
//重新计算md5的值
$md5string=strtoupper(md5($v_oid.$v_pstatus.$v_amount.$v_moneytype.$key)); //拼凑加密串
//支付状态验证
if ($v_md5str==$md5string && $v_pstatus=="20"){
msg_url(L('pay_07').$v_oid,spacelink('pay'));
} else {  //验证支付失败
msg_url(L('pay_09'),spacelink('pay'));
}
}

//异步返回
public function notify_url()
{
/*取返回参数*/
$v_oid=$this->input->post('v_oid', TRUE,TRUE);      
$v_pstatus=$this->input->post('v_pstatus', TRUE,TRUE);    
$v_pstring=$this->input->post('v_pstring', TRUE,TRUE);   
$v_amount=$this->input->post('v_amount', TRUE,TRUE);  
$v_moneytype=$this->input->post('v_moneytype', TRUE,TRUE);   
$v_md5str=$this->input->post('v_md5str', TRUE,TRUE); 
$key = MS_Tenpay_Key;
//重新计算md5的值
$md5string=strtoupper(md5($v_oid.$v_pstatus.$v_amount.$v_moneytype.$key)); //拼凑加密串
//支付状态验证
if ($v_md5str==$md5string){
if($v_pstatus=="20"){
$row=$this->MsdjDB->get_row('pay','*',$v_oid,'dingdan');
if($row && $row->pid!=1){
//增加金钱
$this->db->query("update ".MS_SqlPrefix."user set rmb=rmb+".$row->rmb." where id=".$row->uid."");
//改变状态
$this->db->query("update ".MS_SqlPrefix."pay set pid=1 where id=".$row->id."");
//发送通知
$add['uida']=$row->uid;
$add['uidb']=0;
$add['name']=L('pay_11');
$add['neir']=L('pay_17',array($row->rmb,$v_oid));
$add['addtime']=time();
$this->MsdjDB->get_insert('msg',$add);
}
}
echo "ok";
}else{
echo "error";
}
}
}
