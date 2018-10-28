<?php
/**
* @Mscms 4.x open source management system
* @copyright 2009-2015 msvod.cc. All rights reserved.
* @Author:Msvod QQ:
* @Dtime:2015-03-07
*/
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Daili extends msvod_Controller {
function __construct(){
parent::__construct();
$this->load->model('MsdjTpl');
$this->load->model('MsdjUser');
$this->lang->load('user');
$this->MsdjUser->User_Login();
$this->load->helper('string');
}
//资料
public function index()
{
//模板
$tpl='daili.html';
//URL地址
$url='daili/index';
//当前会员
$row=$this->MsdjDB->get_row_arr('user','*',$_SESSION['msvod__id']);
if(empty($row['nichen'])) $row['nichen']=$row['name'];
//装载模板
$title='代理管理';
$ids['uid']=$_SESSION['msvod__id'];
$ids['uida']=$_SESSION['msvod__id'];
$Mark_Text=$this->MsdjTpl->user_list($row,$url,1,$tpl,$title,'id','',$ids,true,false);
//会员版块导航
$Mark_Text=$this->skins->msvodumenu($Mark_Text,$_SESSION['msvod__id']);
$Mark_Text=$this->skins->labelif($Mark_Text);
//提交地址
$Mark_Text=str_replace("[user:dailisave]",spacelink('daili,save'),$Mark_Text);
$Mark_Text=str_replace("[user:tuiguanglink]",site_url('user/reg?id='.$_SESSION['msvod__id']),$Mark_Text);
$Mark_Text=str_replace("[user:tichengy]",User_Cion_tichengy,$Mark_Text);
$Mark_Text=str_replace("[user:tichenge]",User_Cion_tichenge,$Mark_Text);
$Mark_Text=str_replace("[user:tichengs]",User_Cion_tichengs,$Mark_Text);
echo $Mark_Text;
}
//资料修改
public function save()
{
$row=$this->db->query("select * from ".MS_SqlPrefix."user where id=".$_SESSION['msvod__id']."")->row();
if($row->dlrz==2){
$data['msg']=2;
}else if($row->dlrz==1){
$data['msg']=1;
}else{
//修改入库
$userinfo['dlrz']=1;
$this->MsdjDB->get_update ('user',$_SESSION['msvod__id'],$userinfo);
$data['msg']=0;
}
echo json_encode($data);
}
//佣金提现提交
public function tx_save()
{
$cion=$this->input->get_post('cion', TRUE);
$cid=$this->input->get_post('cid', TRUE);
$text=$this->input->get_post('text', TRUE);
$name=$this->input->get_post('name', TRUE);
$tell=$this->input->get_post('tell', TRUE);
if(empty($cion)) msg_url('提现金额不能为空！','javascript:history.back();');
if(empty($cid)) msg_url('提现银行类型不能为空！','javascript:history.back();');
if(empty($text)) msg_url('提现银行账号不能为空！','javascript:history.back();');
if(empty($name)) msg_url('提现姓名不能为空！','javascript:history.back();');
if(empty($tell)) msg_url('提现联系电话不能为空！','javascript:history.back();');
$row=$this->db->query("select * from ".MS_SqlPrefix."user where id=".$_SESSION['msvod__id']."")->row();
if($row->zjcion>=50){
if($row->zjcion<$cion){
$cion=$row->zjcion;
}
$this->db->query("update ".MS_SqlPrefix."user set zjcion=zjcion-".$cion." where id=".$_SESSION['msvod__id']."");
$add2['uid']=$_SESSION['msvod__id'];
$add2['cid']=$cid;
$add2['zid']=1;
$add2['tcion']=$cion;
$add2['text']=$text;
$add2['name']=$name;
$add2['tell']=$tell;
$add2['dltime']=time();
$this->MsdjDB->get_insert('daili_tixian',$add2);
msg_url('提现申请成功，请等待管理审核！',userurl(site_url('user/daili/tixian')),'ok');
}else{
msg_url('不符合提现条件！','javascript:history.back();');
}
echo json_encode($data);
}
//佣金提现记录
public function tx_lists()
{
$page=intval($this->uri->segment(4)); //分页
//模板
$tpl='tixian-list.html';
//URL地址
$url='daili/tx_lists';
//当前会员
$row=$this->MsdjDB->get_row_arr('user','*',$_SESSION['msvod__id']);
if(empty($row['nichen'])) $row['nichen']=$row['name'];
$sqlstr = "select {field} from ".MS_SqlPrefix."daili_tixian where uid='".$_SESSION['msvod__id']."'";
//装载模板
$title='提现记录';
$ids['uid']=$_SESSION['msvod__id'];
$ids['uida']=$_SESSION['msvod__id'];
$Mark_Text=$this->MsdjTpl->user_list($row,$url,$page,$tpl,$title,'',$sqlstr,$ids,true,false);
//会员版块导航
$Mark_Text=$this->skins->msvodumenu($Mark_Text,$_SESSION['msvod__id']);
$Mark_Text=$this->skins->labelif($Mark_Text);
echo $Mark_Text;
}
//礼品兑换申请
public function duihuan()
{
$id=$this->input->get_post('id', TRUE);
//模板
$tpl='lipin-duihuan.html';
//URL地址
$url='daili/duihuan';
//当前会员
$row=$this->MsdjDB->get_row_arr('user','*',$_SESSION['msvod__id']);
if(empty($row['nichen'])) $row['nichen']=$row['name'];
//装载模板
$title='兑换礼品';
$ids['uid']=$_SESSION['msvod__id'];
$ids['uida']=$_SESSION['msvod__id'];
//礼品
$lipin=$this->db->query("select * from ".MS_SqlPrefix."lipin_list where id=".$id."")->row();
$row['lipin_id']=$lipin->id;
$row['lipin_name']=$lipin->name;
$row['lipin_cid']=$lipin->cid;
$row['lipin_cion']=$lipin->cion;
$row['lipin_text']=$lipin->text;
$row['lipin_pic']=piclink('lipin',$lipin->pic);
$row['lipin_addtime']=$lipin->addtime;
$Mark_Text=$this->MsdjTpl->user_list($row,$url,1,$tpl,$title,'id','',$ids,true,false);
//会员版块导航
$Mark_Text=$this->skins->msvodumenu($Mark_Text,$_SESSION['msvod__id']);
$Mark_Text=$this->skins->labelif($Mark_Text);
//提交地址
$Mark_Text=str_replace("[user:dailisave]",spacelink('daili,tixian_save'),$Mark_Text);
echo $Mark_Text;
}
//礼品兑换提交
public function tixian_save()
{
$id=intval($this->input->get_post('id', TRUE));
$nums=intval($this->input->get_post('nums', TRUE));
$text=$this->input->get_post('text', TRUE);
if($id==0) msg_url('礼品ID不能为空！','javascript:history.back();');
if($nums==0) $nums=1;
if(empty($text)) msg_url('地址信息不能为空！','javascript:history.back();');
$ticheng=$this->db->query("select sum(cion) as cion from ".MS_SqlPrefix."daili_jilu where dlid=".$_SESSION['msvod__id']."")->row();
$xiaofei=$this->db->query("select sum(cion) as cion from ".MS_SqlPrefix."lipin_jilu where uid=".$_SESSION['msvod__id']."")->row();
$cion=$ticheng->cion-$xiaofei->cion;
$lipin=$this->db->query("select * from ".MS_SqlPrefix."lipin_list where id=".$id."")->row();
if($cion>=($nums*$lipin->cion)){
$userinfo['name']=$lipin->name;
$userinfo['uid']=$_SESSION['msvod__id'];
$userinfo['lid']=$id;
$userinfo['nums']=$nums;
$userinfo['cion']=$nums*$lipin->cion;
$userinfo['zid']=0;
$userinfo['text']=$text;
$userinfo['addtime']=time();
$this->MsdjDB->get_insert('lipin_jilu',$userinfo);
$data['code']=1;
}else{
$user=$this->db->query("select * from ".MS_SqlPrefix."user where id=".$_SESSION['msvod__id']."")->row();
if(($cion+$user->cion)>=($nums*$lipin->cion)){
$userinfo['name']=$lipin->name;
$userinfo['uid']=$_SESSION['msvod__id'];
$userinfo['lid']=$id;
$userinfo['nums']=$nums;
$userinfo['cion']=$cion;
$userinfo['zid']=0;
$userinfo['text']=$text;
$userinfo['addtime']=time();
$this->MsdjDB->get_insert('lipin_jilu',$userinfo);
//修改入库
$zcions=$nums*$lipin->cion-$cion;
$this->db->query("update ".MS_SqlPrefix."user set cion=cion-".$zcions." where id=".$_SESSION['msvod__id']."");
//写入消费记录
$add2['title']='兑换'.$nums.'个'.$lipin->name.'';
$add2['uid']=$_SESSION['msvod__id'];
$add2['dir']='user';
$add2['nums']=$zcions;
$add2['ip']=getip();
$add2['addtime']=time();
$this->MsdjDB->get_insert('spend',$add2);
$data['code']=1;
}else{
$data['code']=2;
}
}
echo json_encode($data);
}
//佣金提现换申请
public function tixian()
{
//模板
$tpl='tixian.html';
//URL地址
$url='daili/tixian';
//当前会员
$row=$this->MsdjDB->get_row_arr('user','*',$_SESSION['msvod__id']);
if(empty($row['nichen'])) $row['nichen']=$row['name'];
//装载模板
$title='代理管理';
$ids['uid']=$_SESSION['msvod__id'];
$ids['uida']=$_SESSION['msvod__id'];
$Mark_Text=$this->MsdjTpl->user_list($row,$url,1,$tpl,$title,'id','',$ids,true,false);
//会员版块导航
$Mark_Text=$this->skins->msvodumenu($Mark_Text,$_SESSION['msvod__id']);
$Mark_Text=$this->skins->labelif($Mark_Text);
//提交地址
$Mark_Text=str_replace("[user:dailisave]",spacelink('daili,tixian_save'),$Mark_Text);
echo $Mark_Text;
}
//礼品兑换记录
public function lipin_jilu()
{
$page=intval($this->uri->segment(4)); //分页
//模板
$tpl='lipin-jilu.html';
//URL地址
$url='daili/lipin_jilu';
//当前会员
$row=$this->MsdjDB->get_row_arr('user','*',$_SESSION['msvod__id']);
if(empty($row['nichen'])) $row['nichen']=$row['name'];
$sqlstr = "select {field} from ".MS_SqlPrefix."lipin_jilu where uid='".$_SESSION['msvod__id']."'";
//装载模板
$title='兑换记录';
$ids['uid']=$_SESSION['msvod__id'];
$ids['uida']=$_SESSION['msvod__id'];
$Mark_Text=$this->MsdjTpl->user_list($row,$url,$page,$tpl,$title,'',$sqlstr,$ids,true,false);
//会员版块导航
$Mark_Text=$this->skins->msvodumenu($Mark_Text,$_SESSION['msvod__id']);
$Mark_Text=$this->skins->labelif($Mark_Text);
echo $Mark_Text;
}
public function lists()
{
$page=intval($this->uri->segment(4)); //分页
//模板
$tpl='daili-list.html';
//URL地址
$url='daili/lists';
//当前会员
$row=$this->MsdjDB->get_row_arr('user','*',$_SESSION['msvod__id']);
if(empty($row['nichen'])) $row['nichen']=$row['name'];
$sqlstr = "select {field} from ".MS_SqlPrefix."daili_xiaji where dlid='".$_SESSION['msvod__id']."'";
//装载模板
$title='下级会员';
$ids['uid']=$_SESSION['msvod__id'];
$ids['uida']=$_SESSION['msvod__id'];
$Mark_Text=$this->MsdjTpl->user_list($row,$url,$page,$tpl,$title,'',$sqlstr,$ids,true,false);
//会员版块导航
$Mark_Text=$this->skins->msvodumenu($Mark_Text,$_SESSION['msvod__id']);
$Mark_Text=$this->skins->labelif($Mark_Text);
echo $Mark_Text;
}
//礼品列表
public function lipin_list()
{
$page=intval($this->uri->segment(4)); //分页
//模板
$tpl='lipin-list.html';
//URL地址
$url='daili/lipin_list';
//当前会员
$row=$this->MsdjDB->get_row_arr('user','*',$_SESSION['msvod__id']);
if(empty($row['nichen'])) $row['nichen']=$row['name'];
$sqlstr = "select {field} from ".MS_SqlPrefix."lipin_list where 1=1";
//装载模板
$title='礼物列表';
$ids['uid']=$_SESSION['msvod__id'];
$ids['uida']=$_SESSION['msvod__id'];
$Mark_Text=$this->MsdjTpl->user_list($row,$url,$page,$tpl,$title,'',$sqlstr,$ids,true,false);
//会员版块导航
$Mark_Text=$this->skins->msvodumenu($Mark_Text,$_SESSION['msvod__id']);
$Mark_Text=$this->skins->labelif($Mark_Text);
echo $Mark_Text;
}
}
