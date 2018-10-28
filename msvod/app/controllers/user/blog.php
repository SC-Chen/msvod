<?php 
/**
 * @Msvod v.6 open source management system
 * @copyright 2009-2016 msvod.cc. All rights reserved.
 * @Author:Msvod By 
 * @Dtime:2015-03-06
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends msvod_Controller {

	function __construct(){
		    parent::__construct();
		    $this->load->model('MsdjTpl');
		    $this->load->model('MsdjUser');
			$this->lang->load('user');
			$this->MsdjUser->User_Login();
	}

	public function index()
	{
		    $op=$this->uri->segment(4); //方式
		    $page=intval($this->uri->segment(5)); //分页
			if(empty($op)) $op='my';
			//模板
			$tpl='blog.html';
			//URL地址
		    $url='blog/index/'.$op;
            $sql = "select * from ".MS_SqlPrefix."blog where uid=".$_SESSION['msvod__id'];
            $sqlstr = ($op=='all') ? '' : $sql;
			//当前会员
		    $row=$this->MsdjDB->get_row_arr('user','*',$_SESSION['msvod__id']);
			if(empty($row['nichen'])) $row['nichen']=$row['name'];
			//装载模板
			$title=L('blog_01');
			$ids['uid']=$_SESSION['msvod__id'];
			$ids['uida']=$_SESSION['msvod__id'];
            $Mark_Text=$this->MsdjTpl->user_list($row,$url,$page,$tpl,$title,$op,$sqlstr,$ids,true,false);
			//会员版块导航
			$Mark_Text=$this->skins->msvodumenu($Mark_Text,$_SESSION['msvod__id']);
            $Mark_Text=$this->skins->labelif($Mark_Text);
			echo $Mark_Text;
	}
}
