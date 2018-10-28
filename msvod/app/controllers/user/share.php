<?php 
/**
 * @Msvod v.6 open source management system
 * @copyright 2009-2016 msvod.cc. All rights reserved.
 * @Author:Msvod By 
 * @Dtime:2015-03-30
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Share extends msvod_Controller {

	function __construct(){
		    parent::__construct();
		    $this->load->model('MsdjTpl');
		    $this->load->model('MsdjUser');
			$this->MsdjUser->User_Login();
			$this->lang->load('user');
	}

    //宣传地址
	public function index()
	{
			//模板
			$tpl='share.html';
			//URL地址
		    $url='share/index';
			//当前会员
		    $row=$this->MsdjDB->get_row_arr('user','*',$_SESSION['msvod__id']);
			if(empty($row['nichen'])) $row['nichen']=$row['name'];
			//装载模板
			$title=L('share_01');
			$ids['uid']=$_SESSION['msvod__id'];
			$ids['uida']=$_SESSION['msvod__id'];
            $Mark_Text=$this->MsdjTpl->user_list($row,$url,1,$tpl,$title,'','',$ids,true,false);
			//分享地址
			$Mark_Text=str_replace("[user:sharelink]",site_url('share/'.$_SESSION['msvod__id']),$Mark_Text);
			$Mark_Text=str_replace("[user:sharecion]",User_Cion_Share,$Mark_Text);
			$Mark_Text=str_replace("[user:sharejinyan]",User_Jinyan_Share,$Mark_Text);
			$Mark_Text=str_replace("[user:sharenums]",User_Nums_Share,$Mark_Text);
			//会员版块导航
			$Mark_Text=$this->skins->msvodumenu($Mark_Text,$_SESSION['msvod__id']);
            $Mark_Text=$this->skins->labelif($Mark_Text);
			echo $Mark_Text;
	}

    //宣传记录
	public function lists()
	{
		    $page=intval($this->uri->segment(4)); //分页
			//模板
			$tpl='share-list.html';
			//URL地址
		    $url='share/lists';
			//当前会员
		    $row=$this->MsdjDB->get_row_arr('user','*',$_SESSION['msvod__id']);
			if(empty($row['nichen'])) $row['nichen']=$row['name'];
			//装载模板
			$title=L('share_02');
			$ids['uid']=$_SESSION['msvod__id'];
			$ids['uida']=$_SESSION['msvod__id'];
            $Mark_Text=$this->MsdjTpl->user_list($row,$url,$page,$tpl,$title,'','',$ids,true,false);
			//会员版块导航
			$Mark_Text=$this->skins->msvodumenu($Mark_Text,$_SESSION['msvod__id']);
            $Mark_Text=$this->skins->labelif($Mark_Text);
			echo $Mark_Text;
	}
}
