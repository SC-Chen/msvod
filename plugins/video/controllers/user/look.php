<?php if ( ! defined('MSVOD')) exit('No direct script access allowed');
/**
* @Msvod v.6 open source management system
* @copyright 2009-2014 msvod.cc. All rights reserved.
* @Author:Msvod By 
* @Dtime:2015-04-08
*/
class Look extends msvod_Controller {

function __construct(){
parent::__construct();
$this->load->helper('video');
$this->load->model('MsdjTpl');
$this->load->model('MsdjUser');
$this->MsdjUser->User_Login();
}

//��Ƶ
public function index()
{
$cid=intval($this->uri->segment(4));
$page=intval($this->uri->segment(5));
//ģ��
$tpl='look.html';
//URL��ַ
$url='look/index/'.$cid;
$sqlstr = "select {field} from ".MS_SqlPrefix."video_play where uid=".$_SESSION['msvod__id'];
if($cid>0){
$sqlstr.= " and cid=".$cid."";
}
//��ǰ��Ա
$row=$this->MsdjDB->get_row_arr('user','*',$_SESSION['msvod__id']);
if(empty($row['nichen'])) $row['nichen']=$row['name'];
//װ��ģ��
$title='�����ص���Ƶ - ��Ա����';
$ids['uid']=$_SESSION['msvod__id'];
$ids['uida']=$_SESSION['msvod__id'];
$Mark_Text=$this->MsdjTpl->user_list($row,$url,$page,$tpl,$title,'',$sqlstr,$ids,true,false);
$Mark_Text=str_replace("[video:cid]",$cid,$Mark_Text);
//��Ա��鵼��
$Mark_Text=$this->skins->msvodumenu($Mark_Text,$_SESSION['msvod__id']);
$Mark_Text=$this->skins->labelif($Mark_Text);
echo $Mark_Text;
}
}

