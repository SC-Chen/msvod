<?php 
/**
 * @Msvod v.6 open source management system
 * @copyright 2009-2016 msvod.cc. All rights reserved.
 * @Author:Msvod By 
 * @Dtime:2015-04-17
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Funco extends msvod_Controller {
	function __construct(){
		    parent::__construct();
		    $this->load->model('MsdjTpl');
		    $this->lang->load('home');
	}
	public function index()
	{
            $page = (int)$this->uri->segment(4);   //页数
			//模板
			$tpl='funco.html';
			//当前会员
			$uid=get_home_uid();
		    $row=$this->MsdjDB->get_row_arr('user','*',$uid);
			if(empty($row['nichen'])) $row['nichen']=$row['name'];
			//装载模板
			$title=$row['nichen'].L('funco_01');
			$ids['uid']=$row['id'];
			$ids['uida']=$row['id'];
            $this->MsdjTpl->home_list($row,'funco',$page,$tpl,$title,$ids);
	}
}
