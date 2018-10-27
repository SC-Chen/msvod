<?php if ( ! defined('IS_ADMIN')) exit('No direct script access allowed');
/**
* @Msvod v.6 open source management system
* @copyright 2009-2014 msvod.cc. All rights reserved.
* @Author:Msvod By 
* @Dtime:2014-11-21
*/
class Html extends msvod_Controller {

function __construct(){
parent::__construct();
$this->load->helper('video');
$this->load->model('MsdjAdmin');
$this->MsdjAdmin->Admin_Login();
$this->load->model('MsdjTpl');
//判断运行模式
if(config('Web_Mode')!=3){
admin_msg(L('plub_17'),'javascript:history.back();','no');
}
$this->huri=config('Html_Uri');
}

//首页生成
public function index()
{
if($this->huri['index']['check']==0){
admin_msg(L('plub_18'),'javascript:history.back();','no');
}
//获取静态路径
$uri=config('Html_Uri');
$index_url=adminhtml($uri['index']['url']);
$this->load->get_templates('video',2);
$Mark_Text=$this->MsdjTpl->plub_index('video','index.html',true);
write_file(FCPATH.$index_url,$Mark_Text);
admin_msg(L('plub_19').'<a target="_blank" href="'.Web_Path.$index_url.'"><font color="red">'.L('plub_20').'</font></a>','###');
}

//专题页
public function topic()
{
$this->load->view('html_topic.html');
}

//专题列表页生成操作
public function topic_save()
{
if($this->huri['topic/lists']['check']==0){
admin_msg(L('plub_21'),'javascript:history.back();','no');
}
$start= intval($this->input->get('start')); //当前页生成编号
$pagesize= intval($this->input->get('pagesize')); //每页多少条
$pagejs= intval($this->input->get('pagejs')); //总页数
$datacount= intval($this->input->get('datacount')); //数据总数
$page= intval($this->input->get('page')); //当前页
$nums= intval($this->input->get('nums')); //分类已完成数量
$numx= intval($this->input->get('numx')); //排序方式已完成数量
$cid = $this->input->get_post('cid',true); //需要生成的分类ID
$fid = $this->input->get_post('fid',true); //需要生成的排序方式
if($start==0) $start=1;
if(empty($fid)) $fid='id';

//将数组转换成字符
if(is_array($cid)){
$cid=implode(',', $cid);
}
if(is_array($fid)){
$fid=implode(',', $fid);
}


//公众URI
$uri='?cid='.$cid.'&fid='.$fid.'&pagesize='.$pagesize.'&pagejs='.$pagejs.'&datacount='.$datacount;

//分割分类ID
$arr = explode(',',$cid);
$len = count($arr);
//分割排序方式
$arr2 = explode(',',$fid);
$len2 = count($arr2);

//全部生成完毕
if($nums>=$len){
admin_msg(L('plub_22'),site_url('video/admin/html/topic'));
}

$id=$arr[$nums]; //当前分类ID
$type=$arr2[$numx]; //当前排序

//重新定义模板路径
$this->load->get_templates('video',2);

//获取分页信息
if($datacount==0){
$template=$this->load->view('topic.html','',true);
$pagesize=10;
preg_match_all('/{msvod:([\S]+)\s+(.*?pagesize=\"([\S]+)\".*?)}([\s\S]+?){\/msvod:\1}/',$template,$page_arr);
if(!empty($page_arr) && !empty($page_arr[3][0])){
$pagesize=$page_arr[3][0];
}
$sqlstr="select id,cid from ".MS_SqlPrefix."video_topic where yid=0";
if($id>0){
$sqlstr.=" and cid=".$id."";
}
$rows=$this->db->query(str_replace("id,cid","count(*) as count",$sqlstr))->result_array();
$datacount=$rows[0]['count'];
$pagejs = ceil($datacount/$pagesize);
}
if($datacount==0) $pagejs=1;

if(empty($id)){
$row=array();
$row['name']=L('plub_23');
$id=0;
}else{
$row=$this->MsdjDB->get_row_arr('video_list','*',$cid);
}
echo '<LINK href="'.base_url().'packs/admin/css/style.css" type="text/css" rel="stylesheet"><br>';
echo vsprintf(L('plub_24'),array($row["name"],$this->gettype($type),ceil($pagejs/Html_PageNum),ceil($start/Html_PageNum)));

$n=1;
$pagego=1;
if($page>0 && $page<$pagejs){
$pagejs=$page;
}

for($i=$start;$i<=$pagejs;$i++){

//获取静态路径
$Htmllinks=$Htmllink=LinkUrl('topic/lists',$type,$id,$i,'video',$row['name']);
//转换成生成路径
$Htmllink=adminhtml($Htmllinks,'video');
$Mark_Text=$this->MsdjTpl->plub_list($row,$id,$type,$i,$id,true,'topic.html','topic/lists','',L('plub_34'),L('plub_34'));
$Mark_Text=str_replace("[topic:link]",LinkUrl('topic/lists','id',$id,$i,'video'),$Mark_Text);
$Mark_Text=str_replace("[topic:hlink]",LinkUrl('topic/lists','hits',$id,$i,'video'),$Mark_Text);
$Mark_Text=str_replace("[topic:rlink]",LinkUrl('topic/lists','ri',$id,$i,'video'),$Mark_Text);
$Mark_Text=str_replace("[topic:zlink]",LinkUrl('topic/lists','zhou',$id,$i,'video'),$Mark_Text);
$Mark_Text=str_replace("[topic:ylink]",LinkUrl('topic/lists','yue',$id,$i,'video'),$Mark_Text);
$Mark_Text=str_replace("[topic:slink]",LinkUrl('topic/lists','fav',$cid,$page,'video'),$Mark_Text);
write_file(FCPATH.$Htmllink,$Mark_Text);
echo "<a target='_blank' href='".$Htmllinks."'>&nbsp;&nbsp;".vsprintf(L('plub_25'),array($i))."&nbsp;&nbsp;".$Htmllinks."<font color=green>".L('plub_26')."</font></a><br/>";
$n++;
ob_flush();flush();

if(Html_PageNum==$n){
$pagego=2;
break;
}
}

if($pagego==2){ //操作系统设置每页数量，分多页生成
$url=site_url('video/admin/html/topic_save').$uri.'&nums='.$nums.'&numx='.$numx.'&start='.($i+1);
exit("</br>&nbsp;&nbsp;<b>".vsprintf(L('plub_27'),array(Html_StopTime))."&nbsp;>>>>&nbsp;&nbsp;<a target='_blank' href='".$url."'>".L('plub_28')."</a></b><script>setTimeout('updatenext();',".Html_StopTime."000);function updatenext(){location.href='".$url."';}</script>");
}else{  
$url=site_url('video/admin/html/topic_save').$uri.'&nums='.($nums+1);
$str="&nbsp;&nbsp;<b>".vsprintf(L('plub_27'),array(Html_StopTime))."&nbsp;>>>>&nbsp;&nbsp;<a target='_blank' href='".$url."'>".L('plub_28')."</a></b>";
}

//判断生成完毕
if(($numx+1)>=$len2){ //全部完成
$url=site_url('video/admin/html/topic_save').$uri.'&nums='.($nums+1);
$str="&nbsp;&nbsp;<b><font color=#0000ff>".L('plub_29')."</font>&nbsp;>>>>&nbsp;&nbsp;<a href='".site_url('video/admin/html/topic_save').$uri.'&nums='.($nums+1)."'>".L('plub_28')."</a></b>";
}else{ //当前排序方式完成
$url=site_url('video/admin/html/topic_save').$uri.'&nums='.$nums.'&numx='.($numx+1);
$str='&nbsp;&nbsp;<b>'.vsprintf(L('plub_30'),array($this->gettype($type))).'&nbsp;>>>>&nbsp;&nbsp;<a href="'.site_url('video/admin/html/topic_save').$uri.'&nums='.$nums.'&numx='.($numx+1).'">'.L('plub_28').'</a></b>';
}
echo("</br>".$str."<script>setTimeout('updatenext();',".Html_StopTime."000);function updatenext(){location.href='".$url."';}</script>");
}

//专题内容页生成操作
public function topicshow_save()
{
if($this->huri['topic/show']['check']==0){
admin_msg(L('plub_31'),'javascript:history.back();','no');
}
$tid = $this->input->get_post('tid',true); //需要生成的专题ID
$ksid= intval($this->input->get_post('ksid')); //开始ID
$jsid= intval($this->input->get_post('jsid')); //结束ID
$kstime= $this->input->get_post('kstime',true); //开始日期
$jstime= $this->input->get_post('jstime',true); //结束日期
$pagesize= intval($this->input->get('pagesize')); //每页多少条
$pagejs= intval($this->input->get('pagejs')); //总页数
$datacount= intval($this->input->get('datacount')); //数据总数
$page= intval($this->input->get('page')); //当前页
if($page==0) $page=1;
$str='';

//将数组转换成字符
if(is_array($tid)){
$tid=implode(',', $tid);
}

if($ksid>0 && $jsid>0){
$str.=' and id>'.($ksid-1).' and id<'.($jsid+1).'';
}
if(!empty($kstime) && !empty($jstime)){
$ktime=strtotime($kstime)-86400;
$jtime=strtotime($jstime)+86400;
$str.=' and addtime>'.$ktime.' and addtime<'.$jtime.'';
}
if(!empty($tid)){
$str.=' and id in ('.$tid.')';
}

if($datacount==0){
$sqlstr="select count(*) as count from ".MS_SqlPrefix."video_topic where yid=0 ".$str;
$rows=$this->db->query($sqlstr)->result_array();
$datacount=$rows[0]['count'];
$pagejs = ceil($datacount/Html_PageNum);
}
if($datacount==0) $pagejs=1;

$pagesize=Html_PageNum;
if($datacount<$pagesize){
$pagesize=$datacount;
}

//全部生成完毕
if($datacount==0 || $page>$pagejs){
admin_msg(L('plub_32'),site_url('video/admin/html/topic'));
}


//公众URI
$uri='?tid='.$tid.'&ksid='.$ksid.'&jsid='.$jsid.'&kstime='.$kstime.'&jstime='.$jstime.'&pagesize='.$pagesize.'&pagejs='.$pagejs.'&datacount='.$datacount;

//重新定义模板路径
$this->load->get_templates('video',2);

echo '<LINK href="'.base_url().'packs/admin/css/style.css" type="text/css" rel="stylesheet"><br>';
echo vsprintf(L('plub_33'),array($pagejs,$page));

$sql_string="select * from ".MS_SqlPrefix."video_topic where yid=0 ".$str." order by id desc";
$sql_string.=' limit '. $pagesize*($page-1) .','. $pagesize;
$query = $this->db->query($sql_string);

foreach ($query->result_array() as $row) {

$id=$row['id'];
//获取静态路径
$Htmllinks=LinkUrl('topic','show',$id,1,'video',$row['name']);
//转换成生成路径
$Htmllink=adminhtml($Htmllinks,'video');
//摧毁动态人气字段数组
unset($row['hits']);
unset($row['yhits']);
unset($row['zhits']);
unset($row['rhits']);

//装载模板并输出
$ids['tid']=$id;
$ids['uid']=$row['uid'];
$ids['singerid']=$row['singerid'];
$Mark_Text=$this->MsdjTpl->plub_show('topic',$row,$ids,true,'topic-show.html',$row['name'].'-'.L('plub_34'),$row['name']);
//评论
$Mark_Text=str_replace("[topic:pl]",get_pl('video',$id,1),$Mark_Text);
//动态人气
$Mark_Text=str_replace("[topic:hits]","<script src='".hitslink('hits/dt/hits/'.$id.'/topic','video')."'></script>",$Mark_Text);
$Mark_Text=str_replace("[topic:yhits]","<script src='".hitslink('hits/dt/yhits/'.$id.'/topic','video')."'></script>",$Mark_Text);
$Mark_Text=str_replace("[topic:zhits]","<script src='".hitslink('hits/dt/zhits/'.$id.'/topic','video')."'></script>",$Mark_Text);
$Mark_Text=str_replace("[topic:rhits]","<script src='".hitslink('hits/dt/rhits/'.$id.'/topic','video')."'></script>",$Mark_Text);
//增加人气
$Mark_Text=hits_js($Mark_Text,hitslink('hits/ids/'.$id.'/topic','video'));

//生成
write_file(FCPATH.$Htmllink,$Mark_Text);
echo "&nbsp;<font style=font-size:10pt;>".L('plub_35')."<font color=red>".$row['name']."</font>".L('plub_36')."<a href=".$Htmllinks." target=_blank>".$Htmllinks."</a></font><br/>";
ob_flush();flush();

}

$url=site_url('video/admin/html/topicshow_save').$uri.'&page='.($page+1);
$str="&nbsp;&nbsp;<b>".vsprintf(L('plub_27'),array(Html_StopTime))."&nbsp;>>>>&nbsp;&nbsp;<a href='".$url."'>".L('plub_28')."</a></b>";
echo("</br>".$str."<script>setTimeout('updatenext();',".Html_StopTime."000);function updatenext(){location.href='".$url."';}</script>");
}

//列表页
public function type()
{
$this->load->view('html_type.html');
}

//列表页生成操作
public function type_save()
{
if($this->huri['lists']['check']==0){
admin_msg(L('plub_37'),'javascript:history.back();','no');
}
$ac  = $this->input->get_post('ac',true); //方式
$cid = $this->input->get_post('cid',true); //需要生成的分类ID
$fid = $this->input->get_post('fid',true); //需要生成的排序方式
$nums= intval($this->input->get('nums')); //分类已完成数量
$numx= intval($this->input->get('numx')); //排序方式已完成数量
$start= intval($this->input->get('start')); //当前页生成编号
$pagesize= intval($this->input->get('pagesize')); //每页多少条
$pagejs= intval($this->input->get('pagejs')); //总页数
$datacount= intval($this->input->get('datacount')); //数据总数
$page= intval($this->input->get('page')); //当前页
if($start==0) $start=1;
if(empty($fid)){
$fid=($ac=='all')?'id,video,reco,hits,yhits,zhits,rhits,xhits,shits,dhits,chits,phits':'id';
}

//生成全部分类获取全部分类ID
if($ac=='all' && $nums==0){
$cid=array();
$query = $this->db->query("SELECT id FROM ".MS_SqlPrefix."video_list where yid=0 order by xid asc"); 
foreach ($query->result() as $rowc) {
$cid[]=$rowc->id;
}
}
//将数组转换成字符
if(is_array($cid)){
$cid=implode(',', $cid);
}
if(is_array($fid)){
$fid=implode(',', $fid);
}
//没有选择分类
if(empty($cid)){
admin_msg(L('plub_38'),site_url('video/admin/html/type'));
}

//公众URI
$uri='?ac='.$ac.'&cid='.$cid.'&fid='.$fid.'&pagesize='.$pagesize.'&pagejs='.$pagejs.'&datacount='.$datacount;

//分割分类ID
$arr = explode(',',$cid);
$len = count($arr);
//分割排序方式
$arr2 = explode(',',$fid);
$len2 = count($arr2);

//全部生成完毕
if($nums>=$len){
admin_msg(L('plub_39'),site_url('video/admin/html/type'));
}

$id=$arr[$nums]; //当前分类ID
$type=$arr2[$numx]; //当前排序

//重新定义模板路径
$this->load->get_templates('video',2);

//获取分类信息
$row=$this->MsdjDB->get_row_arr('video_list','*',$id);
$template=!empty($row['skins'])?$row['skins']:'list.html';
$ids=getChild($id); //获取子分类

if($datacount==0){
$template=$this->load->view($template,'',true);
$pagesize=10;
preg_match_all('/{msvod:([\S]+)\s+(.*?pagesize=\"([\S]+)\".*?)}([\s\S]+?){\/msvod:\1}/',$template,$page_arr);
if(!empty($page_arr) && !empty($page_arr[3][0])){
$pagesize=$page_arr[3][0];
}
$sqlstr="select count(*) as count from ".MS_SqlPrefix."video where yid=0 and hid=0 and cid IN (". getChild($id).")";
$rows=$this->db->query($sqlstr)->result_array();
$datacount=$rows[0]['count'];
$pagejs = ceil($datacount/$pagesize);
}
if($datacount==0) $pagejs=1;


echo '<LINK href="'.base_url().'packs/admin/css/style.css" type="text/css" rel="stylesheet"><br>';
echo vsprintf(L('plub_40'),array($row["name"],$this->gettype($type),ceil($pagejs/Html_PageNum),ceil($start/Html_PageNum)));
$n=1;
$pagego=1;
if($page>0 && $page<$pagejs){
$pagejs=$page;
}

for($i=$start;$i<=$pagejs;$i++){

//获取静态路径
$Htmllinks=LinkUrl('lists',$type,$id,$i,'video',$row['bname']);
//转换成生成路径
$Htmllink=adminhtml($Htmllinks,'video');
$skins=empty($row['skins'])?'list.html':$row['skins'];
$Mark_Text=$this->MsdjTpl->plub_list($row,$id,$type,$i,$ids,true,$skins,'lists','video',$row['name'],$row['name']);
write_file(FCPATH.$Htmllink,$Mark_Text);
echo "<a target='_blank' href='".$Htmllinks."'>&nbsp;&nbsp;".vsprintf(L('plub_25'),array($i))."&nbsp;&nbsp;".$Htmllinks."<font color=green>".L('plub_26')."</font></a><br/>";
$n++;
ob_flush();flush();

if(Html_PageNum==$n){
$pagego=2;
break;
}
}

if($pagego==2){ //操作系统设置每页数量，分多页生成
$url=site_url('video/admin/html/type_save').$uri.'&nums='.$nums.'&numx='.$numx.'&start='.($i+1);
exit("</br>&nbsp;&nbsp;<b>".vsprintf(L('plub_27'),array(Html_StopTime)).L('plub_65')."&nbsp;>>>>&nbsp;&nbsp;<a target='_blank' href='".$url."'>".L('plub_28')."</a></b><script>setTimeout('updatenext();',".Html_StopTime."000);function updatenext(){location.href='".$url."';}</script>");
}else{  
$url=site_url('video/admin/html/type_save').$uri.'&nums='.($nums+1);
$str="&nbsp;&nbsp;<b>".vsprintf(L('plub_27'),array(Html_StopTime))."&nbsp;>>>>&nbsp;&nbsp;<a target='_blank' href='".$url."'>".L('plub_28')."</a></b>";
}

//判断生成完毕
if(($numx+1)>=$len2){ //全部完成
$url=site_url('video/admin/html/type_save').$uri.'&nums='.($nums+1);
$str="&nbsp;&nbsp;<b><font color=#0000ff>".L('plub_29')."</font>&nbsp;>>>>&nbsp;&nbsp;<a href='".site_url('video/admin/html/type_save').$uri.'&nums='.($nums+1)."'>".L('plub_28')."</a></b>";
}else{ //当前排序方式完成
$url=site_url('video/admin/html/type_save').$uri.'&nums='.$nums.'&numx='.($numx+1);
$str='&nbsp;&nbsp;<b>'.vsprintf(L('plub_30'),array($this->gettype($type))).'&nbsp;>>>>&nbsp;&nbsp;<a href="'.site_url('video/admin/html/type_save').$uri.'&nums='.$nums.'&numx='.($numx+1).'">'.L('plub_28').'</a></b>';
}
echo("</br>".$str."<script>setTimeout('updatenext();',".Html_StopTime."000);function updatenext(){location.href='".$url."';}</script>");
}

//播放页
public function play()
{
$this->load->view('html_play.html');
}

//播放页生成操作
public function play_save()
{
if($this->huri['play']['check']==0){
admin_msg(L('plub_41'),'javascript:history.back();','no');
}
$day = intval($this->input->get_post('day',true)); //最近几天
$ids = $this->input->get_post('ids',true); //需要生成的数据ID
$cid = $this->input->get_post('cid',true); //需要生成的分类ID
$newid= intval($this->input->get_post('newid')); //最新个数
$ksid= intval($this->input->get_post('ksid')); //开始ID
$jsid= intval($this->input->get_post('jsid')); //结束ID
$kstime= $this->input->get_post('kstime',true); //开始日期
$jstime= $this->input->get_post('jstime',true); //结束日期
$pagesize= intval($this->input->get('pagesize')); //每页多少条
$pagejs= intval($this->input->get('pagejs')); //总页数
$datacount= intval($this->input->get('datacount')); //数据总数
$page= intval($this->input->get('page')); //当前页
if($page==0) $page=1;
$str='';

//将数组转换成字符
if(is_array($cid)){
$cid=implode(',', $cid);
}
if(is_array($ids)){
$ids=implode(',', $ids);
}

if($day>0){
$times=time()-86400*$day;
$str.=' and addtime>'.$times.'';
}
if(!empty($cid)){
$str.=' and cid in ('.$cid.')';
}
if(!empty($ids)){
$str.=' and id in ('.$ids.')';
}
if($ksid>0 && $jsid>0){
$str.=' and id>'.($ksid-1).' and id<'.($jsid+1).'';
}
if(!empty($kstime) && !empty($jstime)){
$ktime=strtotime($kstime)-86400;
$jtime=strtotime($jstime)+86400;
$str.=' and addtime>'.$ktime.' and addtime<'.$jtime.'';
}

$limit='';
if($newid>0){
$limit=' order by id desc limit '.$newid;
}
if($datacount==0){
$sqlstr="select count(*) as count from ".MS_SqlPrefix."video where yid=0 and hid=0 ".$str.$limit;
$rows=$this->db->query($sqlstr)->result_array();
$datacount=$rows[0]['count'];
$pagejs = ceil($datacount/Html_PageNum);
}
if($datacount==0) $pagejs=1;

$pagesize=Html_PageNum;
if($datacount<$pagesize){
$pagesize=$datacount;
}

//全部生成完毕
if($page>$pagejs){
admin_msg(L('plub_42'),site_url('video/admin/html/play'));
}


//公众URI
$uri='?day='.$day.'&cid='.$cid.'&ids='.$ids.'&newid='.$newid.'&ksid='.$ksid.'&jsid='.$jsid.'&kstime='.$kstime.'&jstime='.$jstime.'&pagesize='.$pagesize.'&pagejs='.$pagejs.'&datacount='.$datacount;

//重新定义模板路径
$this->load->get_templates('video',2);

echo '<LINK href="'.base_url().'packs/admin/css/style.css" type="text/css" rel="stylesheet"><br>';
echo vsprintf(L('plub_43'),array($pagejs,$page));

$sql_string="select * from ".MS_SqlPrefix."video where yid=0 and hid=0 ".$str." order by id desc";
$sql_string.=' limit '. $pagesize*($page-1) .','. $pagesize;
$query = $this->db->query($sql_string);

//获取播放页是否需要生成
$html=config('Html_Uri','video');

foreach ($query->result_array() as $row) {


$id=$row['id'];
//获取静态路径
$Htmllinks=LinkUrl('play','id',$row['id'],0,'video',$row['name']);
//转换成生成路径
$Htmllink=adminhtml($Htmllinks,'video');

//摧毁部分需要超级链接字段数组
$rows=$row; //先保存数组保留下面使用
unset($row['tags']);
unset($row['hits']);
unset($row['yhits']);
unset($row['zhits']);
unset($row['rhits']);
unset($row['dhits']);
unset($row['chits']);
unset($row['shits']);
unset($row['xhits']);
//获取当前分类下二级分类ID
$arr['cid']=getChild($row['cid']);
$arr['uid']=$row['uid'];
$arr['did']=$row['id'];
$arr['singerid']=$row['singerid'];
$arr['tags']=$rows['tags'];
//装载模板并输出
$skins=empty($row['skins'])?'play.html':$row['skins'];
$Mark_Text=$this->MsdjTpl->plub_show('video',$row,$arr,TRUE,$skins,$row['name'],$row['name']);
//评论
$Mark_Text=str_replace("[video:pl]",get_pl('video',$id),$Mark_Text);
//分类地址、名称
$Mark_Text=str_replace("[video:link]",LinkUrl('play','id',$row['id'],1,'video'),$Mark_Text);
$Mark_Text=str_replace("[video:classlink]",LinkUrl('lists','id',$row['cid'],1,'video'),$Mark_Text);
$Mark_Text=str_replace("[video:classname]",$this->MsdjDB->getzd('video_list','name',$row['cid']),$Mark_Text);
//专题
if($row['tid']==0){
$Mark_Text=str_replace("[video:topiclink]","###",$Mark_Text);
$Mark_Text=str_replace("[video:topicname]",L('plub_44'),$Mark_Text);
}else{
$Mark_Text=str_replace("[video:topiclink]",LinkUrl('topic','show',$row['tid'],1,'video'),$Mark_Text);
$Mark_Text=str_replace("[video:topicname]",$this->MsdjDB->getzd('video_topic','name',$row['tid']),$Mark_Text);
}
//获取上下曲
preg_match_all('/[video:slink]/',$Mark_Text,$arr);
if(!empty($arr[0]) && !empty($arr[0][0])){
$rowd=$this->db->query("Select id,cid,name from ".MS_SqlPrefix."video where yid=0 and hid=0 and id<".$id." order by id desc limit 1")->row();
if($rowd){
$Mark_Text=str_replace("[video:slink]",LinkUrl('play','id',$rowd->id,1,'video'),$Mark_Text);
$Mark_Text=str_replace("[video:sname]",$rowd->name,$Mark_Text);
$Mark_Text=str_replace("[video:sid]",$rowd->id,$Mark_Text);
}else{
$Mark_Text=str_replace("[video:slink]","#",$Mark_Text);
$Mark_Text=str_replace("[video:sname]",L('plub_45'),$Mark_Text);
$Mark_Text=str_replace("[video:sid]",0,$Mark_Text);
}
}
unset($arr);
preg_match_all('/[video:xlink]/',$Mark_Text,$arr);
if(!empty($arr[0]) && !empty($arr[0][0])){
$rowd=$this->db->query("Select id,cid,name from ".MS_SqlPrefix."video where yid=0 and hid=0 and id>".$id." order by id asc limit 1")->row();
if($rowd){
$Mark_Text=str_replace("[video:xlink]",LinkUrl('play','id',$rowd->id,1,'video'),$Mark_Text);
$Mark_Text=str_replace("[video:xname]",$rowd->name,$Mark_Text);
$Mark_Text=str_replace("[video:xid]",$rowd->id,$Mark_Text);
}else{
$Mark_Text=str_replace("[video:xlink]","#",$Mark_Text);
$Mark_Text=str_replace("[video:xname]",L('plub_45'),$Mark_Text);
$Mark_Text=str_replace("[video:xid]",0,$Mark_Text);
}
}
unset($arr);
//标签加超级连接
$Mark_Text=str_replace("[video:tags]",SearchLink($rows['tags']),$Mark_Text);
//动态人气
$Mark_Text=str_replace("[video:hits]","<script src='".hitslink('hits/dt/hits/'.$id,'video')."'></script>",$Mark_Text);
$Mark_Text=str_replace("[video:yhits]","<script src='".hitslink('hits/dt/yhits/'.$id,'video')."'></script>",$Mark_Text);
$Mark_Text=str_replace("[video:zhits]","<script src='".hitslink('hits/dt/zhits/'.$id,'video')."'></script>",$Mark_Text);
$Mark_Text=str_replace("[video:rhits]","<script src='".hitslink('hits/dt/rhits/'.$id,'video')."'></script>",$Mark_Text);
$Mark_Text=str_replace("[video:dhits]","<script src='".hitslink('hits/dt/dhits/'.$id,'video')."'></script>",$Mark_Text);
$Mark_Text=str_replace("[video:chits]","<script src='".hitslink('hits/dt/chits/'.$id,'video')."'></script>",$Mark_Text);
$Mark_Text=str_replace("[video:shits]","<script src='".hitslink('hits/dt/shits/'.$id,'video')."'></script>",$Mark_Text);
$Mark_Text=str_replace("[video:xhits]","<script src='".hitslink('hits/dt/xhits/'.$id,'video')."'></script>",$Mark_Text);
//视频完整试看地址
preg_match_all('/[video:qurl]/',$Mark_Text,$arr);
if(!empty($arr[0]) && !empty($arr[0][0])){
$purl=$row['purl'];
if($row['fid']>0){
$rowf=$this->db->query("Select purl from ".MS_SqlPrefix."video_server where id=".$row['fid']."")->row_array();
if($rowf){
$purl=$rowf['purl'].$row['purl'];
}
}
$purl=annexlink($purl);
$Mark_Text=str_replace("[video:qurl]",$purl,$Mark_Text);
}
unset($arr);
//cmp音频播放器
$player="<script type='text/javascript'>
var mp3_w='".MS_Play_w."';
var mp3_h='".MS_Play_h."';
var mp3_i='".$id."';
var mp3_p='".hitslink('play','video')."';
var mp3_t='".Web_Path."';
mp3_play();
</script>";
$Mark_Text=str_replace("[video:player]",$player,$Mark_Text);
//jp音频播放器
$jplayer="<script type='text/javascript'>
var mp3_i='".$id."';
var mp3_p='".hitslink('play','video')."';
var mp3_n='".str_replace("'","",$row['name'])."';
var mp3_x='".LinkUrl('down','id',$row['id'],1,'video')."';
var mp3_l='".LinkUrl('down','lrc',$row['id'],1,'video')."';
mp3_jplayer();
</script>";
$Mark_Text=str_replace("[video:jplayer]",$jplayer,$Mark_Text);
//增加人气
$Mark_Text=hits_js($Mark_Text,hitslink('hits/ids/'.$id,'video'));
//生成
write_file(FCPATH.$Htmllink,$Mark_Text);
echo "&nbsp;<font style=font-size:10pt;>".L('plub_46')."<font color=red>".$row['name']."</font>".L('plub_36')."<a href=".$Htmllinks." target=_blank>".$Htmllinks."</a></font><br/>";
ob_flush();flush();
}
if(!empty($ids)){
$url='javascript:history.back();';
$str="&nbsp;&nbsp;<b>".L('plub_66')."&nbsp;>>>>&nbsp;&nbsp;<a href='".$url."'>".L('plub_28')."</a></b>";
}else{ 
$url=site_url('video/admin/html/play_save').$uri.'&page='.($page+1);
$str="&nbsp;&nbsp;<b>".vsprintf(L('plub_27'),array(Html_StopTime))."&nbsp;>>>>&nbsp;&nbsp;<a href='".$url."'>".L('plub_28')."</a></b>";
}
echo("</br>".$str."<script>setTimeout('updatenext();',".Html_StopTime."000);function updatenext(){location.href='".$url."';}</script>");
}

//下载页
public function down()
{
$this->load->view('html_down.html');
}

//下载页生成操作
public function down_save()
{
if($this->huri['down']['check']==0){
admin_msg(L('plub_47'),'javascript:history.back();','no');
}
$day = intval($this->input->get_post('day',true)); //最近几天
$ids = $this->input->get_post('ids',true); //需要生成的数据ID
$cid = $this->input->get_post('cid',true); //需要生成的分类ID
$newid= intval($this->input->get_post('newid')); //最新个数
$ksid= intval($this->input->get_post('ksid')); //开始ID
$jsid= intval($this->input->get_post('jsid')); //结束ID
$kstime= $this->input->get_post('kstime',true); //开始日期
$jstime= $this->input->get_post('jstime',true); //结束日期
$pagesize= intval($this->input->get('pagesize')); //每页多少条
$pagejs= intval($this->input->get('pagejs')); //总页数
$datacount= intval($this->input->get('datacount')); //数据总数
$page= intval($this->input->get('page')); //当前页
if($page==0) $page=1;
$str='';

//将数组转换成字符
if(is_array($cid)){
$cid=implode(',', $cid);
}
if(is_array($ids)){
$ids=implode(',', $ids);
}

if($day>0){
$times=time()-86400*$day;
$str.=' and addtime>'.$times.'';
}
if(!empty($cid)){
$str.=' and cid in ('.$cid.')';
}
if(!empty($ids)){
$str.=' and id in ('.$ids.')';
}
if($ksid>0 && $jsid>0){
$str.=' and id>'.($ksid-1).' and id<'.($jsid+1).'';
}
if(!empty($kstime) && !empty($jstime)){
$ktime=strtotime($kstime)-86400;
$jtime=strtotime($jstime)+86400;
$str.=' and addtime>'.$ktime.' and addtime<'.$jtime.'';
}

$limit='';
if($newid>0){
$limit=' order by id desc limit '.$newid;
}
if($datacount==0){
$sqlstr="select count(*) as count from ".MS_SqlPrefix."video where yid=0 and hid=0 ".$str.$limit;
$rows=$this->db->query($sqlstr)->result_array();
$datacount=$rows[0]['count'];
$pagejs = ceil($datacount/Html_PageNum);
}
if($datacount==0) $pagejs=1;

$pagesize=Html_PageNum;
if($datacount<$pagesize){
$pagesize=$datacount;
}

//全部生成完毕
if($page>$pagejs){
admin_msg(L('plub_48'),site_url('video/admin/html/down'));
}

//公众URI
$uri='?day='.$day.'&cid='.$cid.'&ids='.$ids.'&newid='.$newid.'&ksid='.$ksid.'&jsid='.$jsid.'&kstime='.$kstime.'&jstime='.$jstime.'&pagesize='.$pagesize.'&pagejs='.$pagejs.'&datacount='.$datacount;

//重新定义模板路径
$this->load->get_templates('video',2);

echo '<LINK href="'.base_url().'packs/admin/css/style.css" type="text/css" rel="stylesheet"><br>';
echo vsprintf(L('plub_49'),array($pagejs,$page));

$sql_string="select * from ".MS_SqlPrefix."video where yid=0 and hid=0 ".$str." order by id desc";
$sql_string.=' limit '. $pagesize*($page-1) .','. $pagesize;
$query = $this->db->query($sql_string);

//获取下载页是否需要生成
$html=config('Html_Uri','video');

foreach ($query->result_array() as $row) {

$id=$row['id'];
//获取静态路径
$Htmllinks=LinkUrl('down','id',$row['id'],0,'video',$row['name']);
//转换成生成路径
$Htmllink=adminhtml($Htmllinks,'video');

//摧毁部分需要超级链接字段数组
$rows=$row; //先保存数组保留下面使用
unset($row['tags']);
unset($row['hits']);
unset($row['yhits']);
unset($row['zhits']);
unset($row['rhits']);
unset($row['dhits']);
unset($row['chits']);
unset($row['shits']);
unset($row['xhits']);
//获取当前分类下二级分类ID
$arr['cid']=getChild($row['cid']);
$arr['uid']=$row['uid'];
$arr['did']=$row['id'];
$arr['singerid']=$row['singerid'];
$arr['tags']=$rows['tags'];
//装载模板并输出
$Mark_Text=$this->MsdjTpl->plub_show('video',$row,$arr,TRUE,'down.html',$row['name'],$row['name']);
//评论
$Mark_Text=str_replace("[video:pl]",get_pl('video',$id),$Mark_Text);
//分类地址、名称
$Mark_Text=str_replace("[video:link]",LinkUrl('play','id',$row['id'],1,'video'),$Mark_Text);
$Mark_Text=str_replace("[video:classlink]",LinkUrl('lists','id',$row['cid'],1,'video'),$Mark_Text);
$Mark_Text=str_replace("[video:classname]",$this->MsdjDB->getzd('video_list','name',$row['cid']),$Mark_Text);
//专题
if($row['tid']==0){
$Mark_Text=str_replace("[video:topiclink]","###",$Mark_Text);
$Mark_Text=str_replace("[video:topicname]","未加入",$Mark_Text);
}else{
$Mark_Text=str_replace("[video:topiclink]",LinkUrl('topic','show',$row['tid'],1,'video'),$Mark_Text);
$Mark_Text=str_replace("[video:topicname]",$this->MsdjDB->getzd('video_topic','name',$row['tid']),$Mark_Text);
}
//获取上下曲
preg_match_all('/[video:slink]/',$Mark_Text,$arr);
if(!empty($arr[0]) && !empty($arr[0][0])){
$rowd=$this->db->query("Select id,cid,name from ".MS_SqlPrefix."video where yid=0 and hid=0 and id<".$id." order by id desc limit 1")->row();
if($rowd){
$Mark_Text=str_replace("[video:slink]",LinkUrl('play','id',$rowd->id,1,'video'),$Mark_Text);
$Mark_Text=str_replace("[video:sname]",$rowd->name,$Mark_Text);
$Mark_Text=str_replace("[video:sid]",$rowd->id,$Mark_Text);
}else{
$Mark_Text=str_replace("[video:slink]","#",$Mark_Text);
$Mark_Text=str_replace("[video:sname]",L('plub_45'),$Mark_Text);
$Mark_Text=str_replace("[video:sid]",0,$Mark_Text);
}
}
unset($arr);
preg_match_all('/[video:xlink]/',$Mark_Text,$arr);
if(!empty($arr[0]) && !empty($arr[0][0])){
$rowd=$this->db->query("Select id,cid,name from ".MS_SqlPrefix."video where yid=0 and hid=0 and id>".$id." order by id asc limit 1")->row();
if($rowd){
$Mark_Text=str_replace("[video:xlink]",LinkUrl('play','id',$rowd->id,1,'video'),$Mark_Text);
$Mark_Text=str_replace("[video:xname]",$rowd->name,$Mark_Text);
$Mark_Text=str_replace("[video:xid]",$rowd->id,$Mark_Text);
}else{
$Mark_Text=str_replace("[video:xlink]","#",$Mark_Text);
$Mark_Text=str_replace("[video:xname]",L('plub_45'),$Mark_Text);
$Mark_Text=str_replace("[video:xid]",0,$Mark_Text);
}
}
unset($arr);
//标签加超级连接
$Mark_Text=str_replace("[video:tags]",SearchLink($rows['tags']),$Mark_Text);
//动态人气
$Mark_Text=str_replace("[video:hits]","<script src='".hitslink('hits/dt/hits/'.$id,'video')."'></script>",$Mark_Text);
$Mark_Text=str_replace("[video:yhits]","<script src='".hitslink('hits/dt/yhits/'.$id,'video')."'></script>",$Mark_Text);
$Mark_Text=str_replace("[video:zhits]","<script src='".hitslink('hits/dt/zhits/'.$id,'video')."'></script>",$Mark_Text);
$Mark_Text=str_replace("[video:rhits]","<script src='".hitslink('hits/dt/rhits/'.$id,'video')."'></script>",$Mark_Text);
$Mark_Text=str_replace("[video:dhits]","<script src='".hitslink('hits/dt/dhits/'.$id,'video')."'></script>",$Mark_Text);
$Mark_Text=str_replace("[video:chits]","<script src='".hitslink('hits/dt/chits/'.$id,'video')."'></script>",$Mark_Text);
$Mark_Text=str_replace("[video:shits]","<script src='".hitslink('hits/dt/shits/'.$id,'video')."'></script>",$Mark_Text);
$Mark_Text=str_replace("[video:xhits]","<script src='".hitslink('hits/dt/xhits/'.$id,'video')."'></script>",$Mark_Text);
//视频完整试看、下载地址
preg_match_all('/[video:qurl]/',$Mark_Text,$arr);
if(!empty($arr[0]) && !empty($arr[0][0])){
$purl=$row['purl'];
$durl=$row['durl'];
if($row['fid']>0){
$rowf=$this->db->query("Select purl,durl from ".MS_SqlPrefix."video_server where id=".$row['fid']."")->row_array();
if($rowf){
$purl=$rowf['purl'].$row['purl'];
$durl=$rowf['durl'].$row['durl'];
}
}
$purl=annexlink($purl);
$durl=annexlink($durl);
$Mark_Text=str_replace("[video:qurl]",$purl,$Mark_Text);
$Mark_Text=str_replace("[video:qxurl]",$durl,$Mark_Text);
}
unset($arr);
//生成
write_file(FCPATH.$Htmllink,$Mark_Text);
echo "&nbsp;<font style=font-size:10pt;>".L('plub_50')."<font color=red>".$row['name']."</font>".L('plub_36')."<a href=".$Htmllinks." target=_blank>".$Htmllinks."</a></font><br/>";
ob_flush();flush();

}
if(!empty($ids)){
$url='javascript:history.back();';
$str="&nbsp;&nbsp;<b>".L('plub_66')."&nbsp;>>>>&nbsp;&nbsp;<a href='".$url."'>".L('plub_28')."</a></b>";
}else{ 
$url=site_url('video/admin/html/down_save').$uri.'&page='.($page+1);
$str="&nbsp;&nbsp;<b>".vsprintf(L('plub_27'),array(Html_StopTime))."&nbsp;>>>>&nbsp;&nbsp;<a href='".$url."'>".L('plub_28')."</a></b>";
}
echo("</br>".$str."<script>setTimeout('updatenext();',".Html_StopTime."000);function updatenext(){location.href='".$url."';}</script>");
}

//其他页
public function opt()
{
//获取自定义模板
$Skins_Dir=config('Skins_Dir','video');
$this->load->helper('directory');
$path=FCPATH.'plugins/video/tpl/skins/'.$Skins_Dir;
$dir_arr=directory_map($path, 1);
$skinsdirs=array();
if ($dir_arr) {
foreach ($dir_arr as $t) {
if (!is_dir($path.$t)) {
if(substr($t,0,4)=='opt-'){
$skinsdirs[] = $t;
}
}
}
}
$data['skins_skins'] = $skinsdirs;
$this->load->view('html_opt.html',$data);
}

//其他页生成操作
public function opt_save()
{

$path = $this->input->post('path',true); //方式

//重新定义模板路径
$this->load->get_templates('video',2);

echo '<LINK href="'.base_url().'packs/admin/css/style.css" type="text/css" rel="stylesheet"><br>';

if(!empty($path)){
foreach ($path as $t) {

$t=str_replace(".html","",$t);
$t=str_replace("opt-","",$t);
$Mark_Text=$this->MsdjTpl->opt($t,true);

$Htmllink=Web_Path.'opt/'.$t.'_video.html';

//生成
write_file(FCPATH.$Htmllink,$Mark_Text);
echo "&nbsp;<font style=font-size:10pt;>".L('plub_51')."<font color=red>".$Htmllink."</font>".L('plub_36')."<a href=".$Htmllink." target=_blank>".$Htmllink."</a></font><br/>";
ob_flush();flush();
}
}

$url=site_url('video/admin/html/opt');
echo("</br><b>&nbsp;".L('plub_52')."</b><script>setTimeout('updatenext();',".Html_StopTime."000);function updatenext(){location.href='".$url."';}</script>");
}

//获取排序名称
public function gettype($fid){
$str="ID";
switch($fid){
case 'id':$str="ID";break;
case 'video':$str=L('plub_53');break;
case 'reco':$str=L('plub_54');break;
case 'hits':$str=L('plub_55');break;
case 'yhits':$str=L('plub_56');break;
case 'zhits':$str=L('plub_57');break;
case 'rhits':$str=L('plub_58');break;
case 'shits':$str=L('plub_59');break;
case 'xhits':$str=L('plub_60');break;
case 'yue':$str=L('plub_61');break;
case 'zhou':$str=L('plub_62');break;
case 'fav':$str=L('plub_59');break;
case 'down':$str=L('plub_60');break;
case 'ri':$str=L('plub_58');break;
case 'dhits':$str=L('plub_63');break;
case 'chits':$str=L('plub_64');break;
case 'ding':$str=L('plub_64');break;
case 'cai':$str=L('plub_64');break;
}
return $str;
}
}
