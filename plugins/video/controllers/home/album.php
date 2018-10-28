<?php if ( ! defined('HOMEPATH')) exit('No direct script access allowed');
/**
 * @Msvod v.6 open source management system
 * @copyright 2009-2014 msvod.cc. All rights reserved.
 * @Author:Msvod By 
 * @Dtime:2015-04-18
 */
class Album extends msvod_Controller {

	function __construct(){
		    parent::__construct();
			$this->load->helper('video');
		    $this->load->model('MsdjTpl');
	}

	public function index()
	{
            $page = (int)$this->uri->segment(6);   //页数
			//模板
			$tpl='album.html';
			//当前会员
			$uid=get_home_uid();
		    $row=$this->MsdjDB->get_row_arr('user','*',$uid);
			if(empty($row['nichen'])) $row['nichen']=$row['name'];
			//装载模板
			$title=$row['nichen'].'的专题';
			$ids['uid']=$row['id'];
			$ids['uida']=$row['id'];
            $this->MsdjTpl->home_list($row,'video/album',$page,$tpl,$title,$ids,'index');
	}
}

