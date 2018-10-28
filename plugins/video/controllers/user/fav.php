<?php if ( ! defined('MSVOD')) exit('No direct script access allowed');
/**
 * @Msvod v.6 open source management system
 * @copyright 2009-2014 msvod.cc. All rights reserved.
 * @Author:Msvod By 
 * @Dtime:2015-04-08
 */
class Fav extends msvod_Controller {

	function __construct(){
		    parent::__construct();
			$this->load->helper('video');
		    $this->load->model('MsdjTpl');
		    $this->load->model('MsdjUser');
	        $this->MsdjUser->User_Login();
	}

    //视频
	public function index()
	{
		    $page=intval($this->uri->segment(4));
			//模板
			$tpl='fav.html';
			//URL地址
		    $url='fav/index';
            $sqlstr = "select {field} from ".MS_SqlPrefix."video_fav where sid=1 and uid=".$_SESSION['msvod__id'];
			//当前会员
		    $row=$this->MsdjDB->get_row_arr('user','*',$_SESSION['msvod__id']);
			if(empty($row['nichen'])) $row['nichen']=$row['name'];
			//装载模板
			$title='我收藏的视频 - 会员中心';
			$ids['uid']=$_SESSION['msvod__id'];
			$ids['uida']=$_SESSION['msvod__id'];
            $Mark_Text=$this->MsdjTpl->user_list($row,$url,$page,$tpl,$title,'',$sqlstr,$ids,true,false);
			//会员版块导航
			$Mark_Text=$this->skins->msvodumenu($Mark_Text,$_SESSION['msvod__id']);
            $Mark_Text=$this->skins->labelif($Mark_Text);
			echo $Mark_Text;
	}

	//专题
	public function album()
	{
		    $page=intval($this->uri->segment(4));
			//模板
			$tpl='fav-album.html';
			//URL地址
		    $url='fav/album';
            $sqlstr = "select {field} from ".MS_SqlPrefix."video_fav where sid=2 and uid=".$_SESSION['msvod__id'];
			//当前会员
		    $row=$this->MsdjDB->get_row_arr('user','*',$_SESSION['msvod__id']);
			if(empty($row['nichen'])) $row['nichen']=$row['name'];
			//装载模板
			$title='我收藏的专题 - 会员中心';
			$ids['uid']=$_SESSION['msvod__id'];
			$ids['uida']=$_SESSION['msvod__id'];
            $Mark_Text=$this->MsdjTpl->user_list($row,$url,$page,$tpl,$title,'',$sqlstr,$ids,true,false);
			//会员版块导航
			$Mark_Text=$this->skins->msvodumenu($Mark_Text,$_SESSION['msvod__id']);
            $Mark_Text=$this->skins->labelif($Mark_Text);
			echo $Mark_Text;
	}

	//删除
	public function del()
	{
		    $id=intval($this->uri->segment(4));
		    $sid=intval($this->uri->segment(5));
		    $callback = $this->input->get('callback',true);
			if($sid==0) $sid=1;
            $row=$this->db->query("select uid from ".MS_SqlPrefix."video_fav where id=".$id." and sid=".$sid."")->row();
			if($row){
                     if($row->uid!=$_SESSION['msvod__id']){
						  $err=1002;
						  if(empty($callback)) msg_url('没有权限操作','javascript:history.back();');
					 }else{
                          $this->db->query("DELETE FROM ".MS_SqlPrefix."video_fav where id=".$id."");
						  $err=1001;
						  if(empty($callback)) msg_url('删除成功~!','javascript:history.back();');
					 }
			}else{
				      $err=1002;
					  if(empty($callback)) msg_url('数据不存在','javascript:history.back();');
			}
			echo $callback."({error:".$err."})";
	}
}

