<?php 
/**
* @Msvod v.6 open source management system
* @copyright 2009-2016 msvod.cc. All rights reserved.
* @Author:Msvod By 
* @Dtime:2014-12-16
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Show extends msvod_Controller {
function __construct(){
parent::__construct();
$this->load->helper('tu');
$this->load->model('MsdjTpl');
}
//内容
public function index($fid = 'id', $id = 0)
{
$id = (intval($fid)>0)?intval($fid):intval($id);   //ID
//判断ID
if($id==0) msg_url('出错了，ID不能为空！',Web_Path);
//获取数据
$row=$this->MsdjDB->get_row_arr('tu','*',$id);
if(!$row || $row['yid']>0 || $row['hid']>0){
msg_url('出错了，该数据不存在或者没有审核！',Web_Path);
}
//判断运行模式,生成则跳转至静态页面
$html=config('Html_Uri');
if(config('Web_Mode')==3 && $html['show']['check']==1 && !defined('MOBILE')){
//获取静态路径
$Htmllink=LinkUrl('show',$fid,$id,0,'tu');
header("Location: ".$Htmllink);
exit;
}
//摧毁部分需要超级链接字段数组
$rows=$row; //先保存数组保留下面使用
unset($row['tags']);
unset($row['content']);
//获取当前分类下二级分类ID
$arr['cid']=getChild($row['cid']);
$arr['uid']=$row['uid'];
$arr['tags']=$rows['tags'];
//默认模板
$skins=empty($row['skins'])?'show.html':$row['skins'];
//装载模板并输出
$Mark_Text=$this->MsdjTpl->plub_show('tu',$row,$arr,TRUE,$skins,$row['name'],$row['name']);
//评论
$Mark_Text=str_replace("[tu:pl]",get_pl('tu',$id),$Mark_Text);
//分类地址、名称
$Mark_Text=str_replace("[tu:link]",LinkUrl('show','id',$row['id'],1,'tu'),$Mark_Text);
$Mark_Text=str_replace("[tu:classlink]",LinkUrl('lists','id',$row['cid'],1,'tu'),$Mark_Text);
$Mark_Text=str_replace("[tu:classname]",$this->MsdjDB->getzd('tu_list','name',$row['cid']),$Mark_Text);
//获取上下篇
preg_match_all('/[tu:slink]/',$Mark_Text,$arr);
if(!empty($arr[0]) && !empty($arr[0][0])){
$rowd=$this->db->query("Select id,cid,name from ".MS_SqlPrefix."tu where yid=0 and hid=0 and id<".$id." order by id desc limit 1")->row();
if($rowd){
$Mark_Text=str_replace("[tu:slink]",LinkUrl('show','id',$rowd->id,1,'tu'),$Mark_Text);
$Mark_Text=str_replace("[tu:sname]",$rowd->name,$Mark_Text);
$Mark_Text=str_replace("[tu:sid]",$rowd->id,$Mark_Text);
}else{
$Mark_Text=str_replace("[tu:slink]","#",$Mark_Text);
$Mark_Text=str_replace("[tu:sname]","没有了",$Mark_Text);
$Mark_Text=str_replace("[tu:sid]",0,$Mark_Text);
}
}
unset($arr);
preg_match_all('/[tu:xlink]/',$Mark_Text,$arr);
if(!empty($arr[0]) && !empty($arr[0][0])){
$rowd=$this->db->query("Select id,cid,name from ".MS_SqlPrefix."tu where yid=0 and hid=0 and id>".$id." order by id asc limit 1")->row();
if($rowd){
$Mark_Text=str_replace("[tu:xlink]",LinkUrl('show','id',$rowd->id,1,'tu'),$Mark_Text);
$Mark_Text=str_replace("[tu:xname]",$rowd->name,$Mark_Text);
$Mark_Text=str_replace("[tu:xid]",$rowd->id,$Mark_Text);
}else{
$Mark_Text=str_replace("[tu:xlink]","#",$Mark_Text);
$Mark_Text=str_replace("[tu:xname]","没有了",$Mark_Text);
$Mark_Text=str_replace("[tu:xid]",0,$Mark_Text);
}
}
unset($arr);
//标签加超级连接
$Mark_Text=str_replace("[tu:tags]",SearchLink($rows['tags']),$Mark_Text);
//图片内容,判断是否是收费图片
if($row['vip']>0 || $row['level']>0 || $row['cion']>0){
$content="<div id='msvod_content'></div>";
if(config('Ym_Mode','tu')==1){
$content.="<script type='text/javascript' src='http://".config('Ym_Url','tu').Web_Path."index.php/show/pay/".$id."'></script>";
}else{
$content.="<script type='text/javascript' src='http://".Web_Url.Web_Path."index.php/tu/show/pay/".$id."'></script>";
}
}else{
$content=$rows['content'];
}
$Mark_Text=str_replace("[tu:content]",$content,$Mark_Text);
//增加人气
$Mark_Text=hits_js($Mark_Text,hitslink('hits/ids/'.$id,'tu'));
echo $Mark_Text;
$this->cache->end(); //由于前面不是直接输出，所以这里需要加入写缓存
}
//判断权限、积分
public function pay($id=0)
{
@header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
@header("Cache-Control: no-cache, must-revalidate"); 
@header("Pragma: no-cache");
$this->load->model('MsdjUser');
//判断ID
if($id==0) exit();
//获取数据
$row=$this->MsdjDB->get_row_arr('tu','name,uid,cid,yid,hid,id,vip,level,cion,content',$id);
if(!$row || $row['yid']>0 || $row['hid']>0){
exit("alert('数据没有审核，或者被删除~!');");
}
//判断收费
if($row['vip']>0 || $row['level']>0 || $row['cion']>0){
$login=$this->MsdjUser->User_Login(1);
if(!$login) exit("alert('抱歉，该图片需要登录才能欣赏，请先登录！');");
$rowu=$this->MsdjDB->get_row_arr('user','zid,zutime,vip,level,cion',$_SESSION['msvod__id']);
if($rowu['zutime']<time()){
$this->db->query("update ".MS_SqlPrefix."user set zid=1,zutime=0 where id=".$_SESSION['msvod__id']."");
$rowu['zid']=1;
}
}
//判断会员组权限
if($row['vip']>0 && $row['uid']!=$_SESSION['msvod__id'] && $rowu['vip']==0){
if($row['vip']>$rowu['zid']){
exit("alert('抱歉，您所在的会员组不能欣赏该图片，请先升级！');");
}
}
//判断会员等级权限
if($row['level']>0 && $row['uid']!=$_SESSION['msvod__id']){
if($row['level']>$rowu['level']){
exit("alert('抱歉，您等级不够，不能欣赏该图片！');");
}
}
//判断金币
$down=0;
if($row['cion']>0 && $row['uid']!=$_SESSION['msvod__id']){
//判断是否下载过
$did=$id;
$rowd=$this->db->query("SELECT id,addtime FROM ".MS_SqlPrefix."tu_look where did='".$did."' and uid='".$_SESSION['msvod__id']."'")->row_array();
if($rowd){
$down=1; //数据已经存在
$downtime=User_Downtime*3600+$rowd['addtime'];
if($downtime>time()){
$down=2; //在多少时间内不重复扣币
}
}
//判断会员组下载权限
$rowz=$this->db->query("SELECT id,did FROM ".MS_SqlPrefix."userzu where id='".$rowu['zid']."'")->row_array();
if($rowz && $rowz['did']==1){ //有免费下载权限
$down=2; //该会员下载不收费
}
if($down<2){ //判断扣币
if($row['cion']>$rowu['cion']){
exit("alert('欣赏图片需要".$row['cion']."个金币，您的当前金币不足无法显示，请先充值！');");
}else{
//扣币
$edit['cion']=$rowu['cion']-$row['cion'];
$this->MsdjDB->get_update('user',$_SESSION['msvod__id'],$edit);
//写入消费记录
$add2['title']='欣赏图片《'.$row['name'].'》';
$add2['uid']=$_SESSION['msvod__id'];
$add2['nums']=$row['cion'];
$add2['ip']=getip();
$add2['dir']='tu';
$add2['addtime']=time();
$this->MsdjDB->get_insert('spend',$add2);
//判断分成
if(User_DownFun==1 && $row['uid']>0){
//分成比例
$bi=(User_Downcion<10)?'0.0'.User_Downcion:'0.'.User_Downcion;
$scion= intval($row['cion'] * $bi);
if($scion>0){
$this->db->query("update ".MS_SqlPrefix."user set cion=cion+".$scion." where id=".$row['uid']."");
//写入分成记录
$add3['title']='图片《'.$row['name'].'》 - 欣赏分成';
$add3['uid']=$row['uid'];
$add3['dir']='tu';
$add3['nums']=$scion;
$add3['ip']=getip();
$add3['addtime']=time();
$this->MsdjDB->get_insert('income',$add3);
}
}
}
}
//增加欣赏记录
if($down==0){
$add['name']=$row['name'];
$add['cid']=$row['cid'];
$add['did']=$did;
$add['uid']=$_SESSION['msvod__id'];
$add['cion']=$row['cion'];
$add['addtime']=time();
$this->MsdjDB->get_insert('tu_look',$add);
}
}
echo "var msvod_content='".escape($row['content'])."';$('#msvod_content').html(unescape(msvod_content));";
}
}
