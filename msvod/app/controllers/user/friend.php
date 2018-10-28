<?php 
/**
 * @Msvod v.6 open source management system
 * @copyright 2009-2016 msvod.cc. All rights reserved.
 * @Author:Msvod By 
 * @Dtime:2015-03-07
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Friend extends msvod_Controller {

	function __construct(){
		    parent::__construct();
		    $this->load->model('MsdjTpl');
		    $this->load->model('MsdjUser');
			$this->lang->load('user');
			$this->MsdjUser->User_Login();
	}

    //关注列表
	public function index()
	{
		    $page=intval($this->uri->segment(5)); //分页
			//模板
			$tpl='friend.html';
			//URL地址
		    $url='friend/index';
			//当前会员
		    $row=$this->MsdjDB->get_row_arr('user','*',$_SESSION['msvod__id']);
			if(empty($row['nichen'])) $row['nichen']=$row['name'];
			//装载模板
			$title=L('friend_01');
			$ids['uid']=$_SESSION['msvod__id'];
			$ids['uida']=$_SESSION['msvod__id'];
            $Mark_Text=$this->MsdjTpl->user_list($row,$url,$page,$tpl,$title,'id','',$ids,true,false);
			//会员版块导航
			$Mark_Text=$this->skins->msvodumenu($Mark_Text,$_SESSION['msvod__id']);
            $Mark_Text=$this->skins->labelif($Mark_Text);
			echo $Mark_Text;
	}

    //删除关注
	public function del()
	{
		    $id=intval($this->uri->segment(4)); //ID
			if($id==0) msg_url(L('friend_02'),'javascript:history.back();');
            $this->db->query("delete from ".MS_SqlPrefix."friend where uida=".$_SESSION['msvod__id']." and id=".$id."");
            msg_url(L('friend_03'),$_SERVER['HTTP_REFERER']);
	}
}
