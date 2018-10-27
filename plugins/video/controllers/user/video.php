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

//�����
public function index()
{
$cid=intval($this->uri->segment(4)); //����ID
$page=intval($this->uri->segment(5)); //��ҳ
//ģ��
$tpl='video.html';
//URL��ַ
$url='video/index/'.$cid;
$sqlstr = "select {field} from ".MS_SqlPrefix."video where yid=0 and uid=".$_SESSION['msvod__id'];
if($cid>0){
$cids=getChild($cid);
$sqlstr.= " and cid in(".$cids.")";
}
//��ǰ��Ա
$row=$this->MsdjDB->get_row_arr('user','*',$_SESSION['msvod__id']);
if(empty($row['nichen'])) $row['nichen']=$row['name'];
//װ��ģ��
$title='�ҵ���Ƶ - ��Ա����';
$ids['uid']=$_SESSION['msvod__id'];
$ids['uida']=$_SESSION['msvod__id'];
$Mark_Text=$this->MsdjTpl->user_list($row,$url,$page,$tpl,$title,$cid,$sqlstr,$ids,true,false);
$Mark_Text=str_replace("[video:cid]",$cid,$Mark_Text);
//��Ա��鵼��
$Mark_Text=$this->skins->msvodumenu($Mark_Text,$_SESSION['msvod__id']);
$Mark_Text=$this->skins->labelif($Mark_Text);
echo $Mark_Text;
}

//�����
public function verify()
{
$cid=intval($this->uri->segment(4)); //����ID
$page=intval($this->uri->segment(5)); //��ҳ
//ģ��
$tpl='verify.html';
//URL��ַ
$url='video/verify/'.$cid;
$sqlstr = "select {field} from ".MS_SqlPrefix."video where yid=1 and uid=".$_SESSION['msvod__id'];
if($cid>0){
$cids=getChild($cid);
$sqlstr.= " and cid in(".$cids.")";
}
//��ǰ��Ա
$row=$this->MsdjDB->get_row_arr('user','*',$_SESSION['msvod__id']);
if(empty($row['nichen'])) $row['nichen']=$row['name'];
//װ��ģ��
$title='������Ƶ - ��Ա����';
$ids['uid']=$_SESSION['msvod__id'];
$ids['uida']=$_SESSION['msvod__id'];
$Mark_Text=$this->MsdjTpl->user_list($row,$url,$page,$tpl,$title,$cid,$sqlstr,$ids,true,false);
$Mark_Text=str_replace("[video:cid]",$cid,$Mark_Text);
//��Ա��鵼��
$Mark_Text=$this->skins->msvodumenu($Mark_Text,$_SESSION['msvod__id']);
$Mark_Text=$this->skins->labelif($Mark_Text);
echo $Mark_Text;
}

//�ϴ���Ƶ
public function add()
{
//ģ��
$tpl='add.html';
//URL��ַ
$url='video/add';
//��ǰ��Ա
$row=$this->MsdjDB->get_row_arr('user','*',$_SESSION['msvod__id']);
if(empty($row['nichen'])) $row['nichen']=$row['name'];

//��ⷢ��Ȩ��
$rowz=$this->MsdjDB->get_row('userzu','aid,sid',$row['zid']);
if(!$rowz || $rowz->aid==0){
msg_url('�����ڻ�Ա��û��Ȩ�޷�����Ƶ~!','javascript:history.back();');
}

//װ��ģ��
$title='�ϴ���Ƶ - ��Ա����';
$ids['uid']=$_SESSION['msvod__id'];
$ids['uida']=$_SESSION['msvod__id'];
$Mark_Text=$this->MsdjTpl->user_list($row,$url,1,$tpl,$title,'','',$ids,true,false);
//token
$Mark_Text=str_replace("[user:token]",get_token('video_token'),$Mark_Text);
//�ύ��ַ
$Mark_Text=str_replace("[user:videosave]",spacelink('video,save','video'),$Mark_Text);
//��Ա��鵼��
$Mark_Text=$this->skins->msvodumenu($Mark_Text,$_SESSION['msvod__id']);
$Mark_Text=$this->skins->labelif($Mark_Text);
echo $Mark_Text;
}

//�ϴ���Ƶ����
public function save()
{
$token=$this->input->post('token', TRUE);
if(!get_token('video_token',1,$token)) msg_url('�Ƿ��ύ~!','javascript:history.back();');

//��ⷢ��Ȩ��
$zuid=getzd('user','zid',$_SESSION['msvod__id']);
$rowu=$this->MsdjDB->get_row('userzu','aid,sid',$zuid);
if(!$rowu || $rowu->aid==0){
msg_url('�����ڻ�Ա��û��Ȩ�޷�����Ƶ~!','javascript:history.back();');
}
//��ⷢ�������Ƿ���Ҫ���
$look['yid']=($rowu->sid==1)?0:1;

//�����ֶ�
$look['name']=str_encode($_POST['name']);
$look['cid']=intval($this->input->post('cid'));
$look['purl']=$this->input->post('purl', TRUE, TRUE);
$look['durl']=$this->input->post('durl', TRUE, TRUE);

//�������ֶ�
if($look['cid']==0) msg_url('��ѡ����Ƶ����~!','javascript:history.back();');
if(empty($look['name'])) msg_url('��Ƶ���Ʋ���Ϊ��~!','javascript:history.back();');
if(empty($look['purl'])) msg_url('��Ƶ��ַ����Ϊ��~!','javascript:history.back();');
if(empty($look['durl'])) msg_url('��Ƶ��ַ����Ϊ��~!','javascript:history.back();');

//ѡ���ֶ�
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
//�ж���Ա�Ƿ����
if(!empty($singer)){
$row=$this->MsdjDB->get_row('singer','id',$singer,'name');
if($row){
$look['singerid']=$row->id;
}
}
//��ȡ��С�����ʡ�ʱ��
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
//���ӵ����ݿ�
$did=$this->MsdjDB->get_insert('video',$look);
if(intval($did)==0){
msg_url('��Ƶ����ʧ�ܣ����Ժ�����~!','javascript:history.back();');
}

//�ݻ�token
get_token('video_token',2);

//���Ӷ�̬
$dt['dir'] = 'video';
$dt['uid'] = $_SESSION['msvod__id'];
$dt['did'] = $did;
$dt['yid'] = $look['yid'];
$dt['title'] = '��������Ƶ';
$dt['name'] = $look['name'];
$dt['link'] = linkurl('play','id',$did,1,'video');
$dt['addtime'] = time();
$this->MsdjDB->get_insert('dt',$dt);

//�������ˣ������Ա������Ӧ��ҡ�����
if($look['yid']==0){
$addhits=getzd('user','addhits',$_SESSION['msvod__id']);
if($addhits<User_Nums_Add){
$this->db->query("update ".MS_SqlPrefix."user set cion=cion+".User_Cion_Add.",jinyan=jinyan+".User_Jinyan_Add.",addhits=addhits+1 where id=".$_SESSION['msvod__id']."");
}
msg_url('��ϲ������Ƶ�����ɹ�~!',spacelink('video','video'));
}else{
msg_url('��ϲ������Ƶ�����ɹ�,��ȴ�����Ա���~!',spacelink('video/verify','video'));
}
}
}
