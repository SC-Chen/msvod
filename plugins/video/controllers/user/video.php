<?php if ( ! defined('MSVOD')) exit('No direct script access allowed');
/**
* @Msvod v.6 open source management system
* @copyright 2009-2014 msvod.cc. All rights reserved.
* @Author:Msvod By 
* @Dtime:2015-04-08
*/
class video extends msvod_Controller {

function __construct(){
parent::__construct();
$this->load->helper('video');
$this->load->model('MsdjTpl');
$this->load->model('MsdjUser');
$this->MsdjUser->User_Login();
$this->load->helper('string');
}

//已审核
public function index()
{
$cid=intval($this->uri->segment(4)); //分类ID
$page=intval($this->uri->segment(5)); //分页
//模板
$tpl='video.html';
//URL地址
$url='video/index/'.$cid;
$sqlstr = "select {field} from ".MS_SqlPrefix."video where yid=0 and uid=".$_SESSION['msvod__id'];
if($cid>0){
$cids=getChild($cid);
$sqlstr.= " and cid in(".$cids.")";
}
//当前会员
$row=$this->MsdjDB->get_row_arr('user','*',$_SESSION['msvod__id']);
if(empty($row['nichen'])) $row['nichen']=$row['name'];
//装载模板
$title='我的视频 - 会员中心';
$ids['uid']=$_SESSION['msvod__id'];
$ids['uida']=$_SESSION['msvod__id'];
$Mark_Text=$this->MsdjTpl->user_list($row,$url,$page,$tpl,$title,$cid,$sqlstr,$ids,true,false);
$Mark_Text=str_replace("[video:cid]",$cid,$Mark_Text);
//会员版块导航
$Mark_Text=$this->skins->msvodumenu($Mark_Text,$_SESSION['msvod__id']);
$Mark_Text=$this->skins->labelif($Mark_Text);
echo $Mark_Text;
}

//待审核
public function verify()
{
$cid=intval($this->uri->segment(4)); //分类ID
$page=intval($this->uri->segment(5)); //分页
//模板
$tpl='verify.html';
//URL地址
$url='video/verify/'.$cid;
$sqlstr = "select {field} from ".MS_SqlPrefix."video where yid=1 and uid=".$_SESSION['msvod__id'];
if($cid>0){
$cids=getChild($cid);
$sqlstr.= " and cid in(".$cids.")";
}
//当前会员
$row=$this->MsdjDB->get_row_arr('user','*',$_SESSION['msvod__id']);
if(empty($row['nichen'])) $row['nichen']=$row['name'];
//装载模板
$title='待审视频 - 会员中心';
$ids['uid']=$_SESSION['msvod__id'];
$ids['uida']=$_SESSION['msvod__id'];
$Mark_Text=$this->MsdjTpl->user_list($row,$url,$page,$tpl,$title,$cid,$sqlstr,$ids,true,false);
$Mark_Text=str_replace("[video:cid]",$cid,$Mark_Text);
//会员版块导航
$Mark_Text=$this->skins->msvodumenu($Mark_Text,$_SESSION['msvod__id']);
$Mark_Text=$this->skins->labelif($Mark_Text);
echo $Mark_Text;
}

//上传视频
public function add()
{
//模板
$tpl='add.html';
//URL地址
$url='video/add';
//当前会员
$row=$this->MsdjDB->get_row_arr('user','*',$_SESSION['msvod__id']);
if(empty($row['nichen'])) $row['nichen']=$row['name'];

//检测发表权限
$rowz=$this->MsdjDB->get_row('userzu','aid,sid',$row['zid']);
if(!$rowz || $rowz->aid==0){
msg_url('您所在会员组没有权限发表视频~!','javascript:history.back();');
}

//装载模板
$title='上传视频 - 会员中心';
$ids['uid']=$_SESSION['msvod__id'];
$ids['uida']=$_SESSION['msvod__id'];
$Mark_Text=$this->MsdjTpl->user_list($row,$url,1,$tpl,$title,'','',$ids,true,false);
//token
$Mark_Text=str_replace("[user:token]",get_token('video_token'),$Mark_Text);
//提交地址
$Mark_Text=str_replace("[user:videosave]",spacelink('video,save','video'),$Mark_Text);
//会员版块导航
$Mark_Text=$this->skins->msvodumenu($Mark_Text,$_SESSION['msvod__id']);
$Mark_Text=$this->skins->labelif($Mark_Text);
echo $Mark_Text;
}

//上传视频保存
public function save()
{
$token=$this->input->post('token', TRUE);
if(!get_token('video_token',1,$token)) msg_url('非法提交~!','javascript:history.back();');

//检测发表权限
$zuid=getzd('user','zid',$_SESSION['msvod__id']);
$rowu=$this->MsdjDB->get_row('userzu','aid,sid',$zuid);
if(!$rowu || $rowu->aid==0){
msg_url('您所在会员组没有权限发表视频~!','javascript:history.back();');
}
//检测发表数据是否需要审核
$look['yid']=($rowu->sid==1)?0:1;

//必填字段
$look['name']=str_encode($_POST['name']);
$look['cid']=intval($this->input->post('cid'));
$look['purl']=$this->input->post('purl', TRUE, TRUE);
$look['durl']=$this->input->post('durl', TRUE, TRUE);

//检测必须字段
if($look['cid']==0) msg_url('请选择视频分类~!','javascript:history.back();');
if(empty($look['name'])) msg_url('视频名称不能为空~!','javascript:history.back();');
if(empty($look['purl'])) msg_url('视频地址不能为空~!','javascript:history.back();');
if(empty($look['durl'])) msg_url('视频地址不能为空~!','javascript:history.back();');

//选填字段
$look['tid']=intval($this->input->post('tid'));
$look['cion']=intval($this->input->post('cion'));
$look['dcion']=intval($this->input->post('dcion'));
$look['text']=remove_xss(str_replace("\r\n","<br>",$_POST['text']));
$look['lrc']=$this->input->post('lrc', TRUE, TRUE);
$look['pic']=$this->input->post('pic', TRUE, TRUE);
$look['tags']=$this->input->post('tags', TRUE, TRUE);
$look['zc']=$this->input->post('zc', TRUE, TRUE);
$look['zq']=$this->input->post('zq', TRUE, TRUE);
$look['bq']=$this->input->post('bq', TRUE, TRUE);
$look['hy']=$this->input->post('hy', TRUE, TRUE);

$look['uid']=$_SESSION['msvod__id'];
$look['addtime']=time();

$singer=$this->input->post('singer', TRUE, TRUE);
//判断演员是否存在
if(!empty($singer)){
$row=$this->MsdjDB->get_row('singer','id',$singer,'name');
if($row){
$look['singerid']=$row->id;
}
}
//获取大小、音质、时长
if(substr($look['purl'],0,7)!='http://' && UP_Mode==1){
if(UP_Pan==''){
$filename=FCPATH.$look['purl'];
}else{
$filename=UP_Pan.$look['purl'];
}
$this->load->library('mp3file');
$arr = $this->mp3file->get_metadata($filename);
$look['dx']=!empty($arr['Filesize'])?formatsize($arr['Filesize']):'';
$look['yz']=!empty($arr['Bitrate'])?$arr['Bitrate'].' Kbps':'';
$look['sc']=!empty($arr['Length mm:ss'])?$arr['Length mm:ss']:'';
}
//增加到数据库
$did=$this->MsdjDB->get_insert('video',$look);
if(intval($did)==0){
msg_url('视频发布失败，请稍候再试~!','javascript:history.back();');
}

//摧毁token
get_token('video_token',2);

//增加动态
$dt['dir'] = 'video';
$dt['uid'] = $_SESSION['msvod__id'];
$dt['did'] = $did;
$dt['yid'] = $look['yid'];
$dt['title'] = '发布了视频';
$dt['name'] = $look['name'];
$dt['link'] = linkurl('play','id',$did,1,'video');
$dt['addtime'] = time();
$this->MsdjDB->get_insert('dt',$dt);

//如果免审核，则给会员增加相应金币、积分
if($look['yid']==0){
$addhits=getzd('user','addhits',$_SESSION['msvod__id']);
if($addhits<User_Nums_Add){
$this->db->query("update ".MS_SqlPrefix."user set cion=cion+".User_Cion_Add.",jinyan=jinyan+".User_Jinyan_Add.",addhits=addhits+1 where id=".$_SESSION['msvod__id']."");
}
msg_url('恭喜您，视频发布成功~!',spacelink('video','video'));
}else{
msg_url('恭喜您，视频发布成功,请等待管理员审核~!',spacelink('video/verify','video'));
}
}
}
